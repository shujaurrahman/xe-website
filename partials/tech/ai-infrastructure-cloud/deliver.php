<?php /* DRAFT COPY — review before launch */
/* 11 Deliver — what you get, as the infrastructure repository you keep, and you can open it.
   The terminal frame holds a working repository browser: an ARIA tree on the left (arrow keys expand,
   collapse and move; Enter opens) and the selected file beside it. Every file here is a real artefact of
   the engagement, and the contents are the shape we actually ship — the same burn-rate thresholds the
   reliability section quotes, the same queue-depth autoscaling the stack names, the same residency rule
   the gateway enforces. HTML ships the tree fully expanded and the first file open, so the section reads
   without JavaScript; deliver.js adds collapsing, selection and the keyboard map. Paths are illustrative. */
$tic_dv_files = [   // key => [path, language chip, body]
    'tf-main' => ['terraform/envs/prod/main.tf', 'HCL', <<<'TXT'
module "gpu_pool" {
  source = "../../modules/gpu-pool"

  region        = "ap-south-1"    # Mumbai, primary
  instance_type = "g6e.2xlarge"   # 1 × L40S, 48 GB
  min_nodes     = 6
  max_nodes     = 10              # 6 serving + 2 warm + 2 burst
  warm_nodes    = 2
  taints        = ["nvidia.com/gpu=present:NoSchedule"]
  tags          = local.cost_tags # feature, team, model route
}
TXT],
    'tf-policy' => ['terraform/policy/region.rego', 'Rego', <<<'TXT'
package terraform.region

# Personal data never leaves India. Any resource planned
# outside the approved regions fails the policy check in CI.
approved := {"ap-south-1", "ap-south-2"}

deny[msg] {
  r := input.resource_changes[_]
  r.change.after.region
  not approved[r.change.after.region]
  msg := sprintf("%s targets %s, outside the residency set",
                 [r.address, r.change.after.region])
}
TXT],
    'helm-vllm' => ['helm/vllm-serving/values.yaml', 'YAML', <<<'TXT'
model:
  name: your-platform/chat-8b
  quantization: fp8           # eval gate: −0.01, inside the 0.02 tolerance
  maxModelLen: 8192
  gpuMemoryUtilization: 0.92
  enablePrefixCaching: true

autoscaling:
  metric: vllm:num_requests_waiting   # queue depth, never CPU
  target: "4"
  minReplicas: 6
  maxReplicas: 10

podDisruptionBudget:
  minAvailable: 5
TXT],
    'helm-gw' => ['helm/ai-gateway/values.yaml', 'YAML', <<<'TXT'
routes:
  - match: { dataClass: personal }
    provider: self-hosted     # residency rule, enforced here
  - match: { tokensIn: "<800" }
    provider: small-model
  - default: provider-a

retries:
  budget: 10%                 # of a route's requests per minute
  backoff: exponential-jitter
  idempotencyKey: required

cache:
  prompt:   { ttl: 1h }
  semantic: { threshold: 0.93, ttl: 15m }
TXT],
    'dash-finops' => ['dashboards/finops.json', 'JSON', <<<'TXT'
{
  "title": "Cost per 1,000 requests",
  "datasource": "prometheus",
  "targets": [
    {
      "expr": "sum by (feature) (rate(gen_ai_cost_usd_total[1h]))
             / sum by (feature) (rate(gen_ai_requests_total[1h])) * 1000",
      "legendFormat": "{{feature}}"
    }
  ],
  "thresholds": [{ "value": 1.43, "colorMode": "text" }],
  "description": "Cost tags are set at the gateway. Spend without a
                  tag shows up as {feature=\"\"} and gets chased."
}
TXT],
    'slo-obj' => ['slo/objectives.yaml', 'YAML', <<<'TXT'
- name: availability
  sli: successful_responses / all_responses   # at the gateway, 4xx excluded
  objective: 99.9
  window: 30d                 # 43.2 minutes of budget
  burnRateAlerts:
    - { factor: 14.4, long: 1h, short: 5m,  severity: page }
    - { factor: 6,    long: 6h, short: 30m, severity: ticket }
  freezeBelowBudget: 25       # % remaining — feature releases stop

- name: time_to_first_token
  sli: streams_first_token_under_800ms / streams
  objective: 95
  window: 30d
TXT],
    'rb-gpu' => ['runbooks/gpu-node-failure.md', 'Markdown', <<<'TXT'
# GPU node failure

Alert: vllm_node_unhealthy · Dashboard: SLO / serving
Owner: platform on-call · Expected impact: none, the warm pool absorbs it

## First five commands

1. kubectl get nodes -l nvidia.com/gpu=present -o wide
2. kubectl describe node $NODE | sed -n '/Conditions/,/Events/p'
3. kubectl drain $NODE --ignore-daemonsets --delete-emptydir-data
4. kubectl -n serving get hpa vllm-serving
5. k6 run loadtest/k6/smoke.js

## If p95 stays above 1.5 s for ten minutes

Shift the chat route to provider A in the gateway, page the model
owner, and open an incident. The drill for this is in section 04.
TXT],
    'k6-peak' => ['loadtest/k6/peak.js', 'JavaScript', <<<'TXT'
import http from 'k6/http';
import { check } from 'k6';

export const options = {
  scenarios: {
    peak: { executor: 'constant-arrival-rate', rate: 40,
            timeUnit: '1s', duration: '20m', preAllocatedVUs: 300 },
  },
  thresholds: {
    'http_req_duration{endpoint:chat}': ['p(95)<1500', 'p(99)<3000'],
    'http_req_failed': ['rate<0.01'],
  },
};

export default function () {
  const res = http.post(`${__ENV.BASE}/v1/chat`, PAYLOAD,
                        { tags: { endpoint: 'chat' } });
  check(res, { 'first token under 800 ms': (r) => r.timings.waiting < 800 });
}
TXT],
    'dr-drill' => ['dr/restore-drill.sh', 'Shell', <<<'TXT'
#!/usr/bin/env bash
set -euo pipefail

# Quarterly drill: rebuild production in the standby region from
# code and backups only, and time it against the agreed RTO.
START=$(date +%s)

terraform -chdir=terraform/envs/dr apply -auto-approve
helm upgrade --install platform helm/platform -f helm/platform/dr.yaml
./dr/restore-vectors.sh --snapshot "$(date -u +%F)"   # RPO: hourly
k6 run loadtest/k6/smoke.js

echo "RTO $(( $(date +%s) - START ))s against a 3600s target."
echo "Evidence written to dr/evidence/$(date -u +%F)/."
TXT],
];
$tic_dv_tree = [   // [dir key, dir label, dir comment, [file keys]]
    ['terraform', 'terraform/',   'cloud, network, GPU pools',     ['tf-main', 'tf-policy']],
    ['helm',      'helm/',        'what runs on the clusters',     ['helm-vllm', 'helm-gw']],
    ['dashboards','dashboards/',  'Grafana as code',               ['dash-finops']],
    ['slo',       'slo/',         'targets and burn-rate alerts',  ['slo-obj']],
    ['runbooks',  'runbooks/',    'one per alert',                 ['rb-gpu']],
    ['loadtest',  'loadtest/k6/', 'load profiles',                 ['k6-peak']],
    ['dr',        'dr/',          'restore drill and evidence',    ['dr-drill']],
];
$tic_dv_open = 'tf-main';
$tic_dv_prov = [   // how each file got there: the review story the section argues for, made concrete
    'tf-main'     => 'PR #482 · platform · plan attached, 26 policy checks passed',
    'tf-policy'   => 'PR #455 · security · ap-south-2 added to the residency set',
    'helm-vllm'   => 'PR #501 · serving · FP8 after the eval gate came back −0.01',
    'helm-gw'     => 'PR #498 · platform · retry budget capped at 10% of the route',
    'dash-finops' => 'PR #471 · finops · cost tag added to the gateway span',
    'slo-obj'     => 'PR #440 · SRE · burn-rate pair agreed with you, then merged',
    'rb-gpu'      => 'PR #466 · on-call · the five commands verified in a drill',
    'k6-peak'     => 'PR #489 · quality · peak profile raised to 40 req/s',
    'dr-drill'    => 'PR #430 · platform · last quarter\'s RTO evidence attached',
];

/* Render a file body as numbered lines, with comments dimmed. Escaped first, so the markers below
   can only ever match literal text. Markdown keeps its headings instead of a comment colour. */
$tic_dv_code = function (string $body, bool $md): string {
    $out = '';
    foreach (explode("\n", $body) as $tic_dv_i => $tic_dv_line) {
        $tic_dv_t = e($tic_dv_line);
        if ($md) {
            if (str_starts_with($tic_dv_line, '#')) $tic_dv_t = '<b>' . $tic_dv_t . '</b>';
        } elseif (preg_match('~^(\s*)((?:\#|//).*)$~', $tic_dv_line)) {
            $tic_dv_t = preg_replace('~^(\s*)((?:\#|//).*)$~', '$1<em>$2</em>', $tic_dv_t);
        } elseif (preg_match('~\s{2,}(?:\#|//)~', $tic_dv_line)) {
            $tic_dv_t = preg_replace('~(\s{2,})((?:\#|//).*)$~', '$1<em>$2</em>', $tic_dv_t);
        }
        $out .= '<span class="tic-dv__l"><i aria-hidden="true">' . sprintf('%02d', $tic_dv_i + 1) . '</i><span>' . ($tic_dv_t === '' ? '&nbsp;' : $tic_dv_t) . '</span></span>';
    }
    return $out;
};
$tic_dv_n = count($tic_dv_files);
?>
<section class="band band--alt tic-deliver" id="deliver" aria-labelledby="deliver-t">
  <div class="wrap">
    <div class="tic-head" data-rv>
      <p class="tic-ch"><b>11</b><span>What you get</span><i aria-hidden="true"></i><em>a repository, not a slide deck</em></p>
      <div class="tic-head__t">
        <h2 class="h2" id="deliver-t"><span class="g">Everything we build</span> lands in a repository you own.</h2>
      </div>
      <div class="tic-head__l">
        <p class="lead">No black boxes and no console-clicked infrastructure. The platform is defined in code, reviewed like code, and rebuildable from an empty account. Open any file below — this is the shape we hand over.</p>
      </div>
    </div>

    <div class="tic-dv">
      <div class="tic-dv__termwrap" data-rv>
        <p class="bdh-sr">A browsable listing of the infrastructure repository handed over at the end of the engagement, with <?= $tic_dv_n ?> files you can open: Terraform for the GPU pool and the residency policy, Helm values for model serving and the AI gateway, a Grafana cost dashboard, the SLO objectives with their burn-rate alert rules, the GPU node-failure runbook, a k6 peak-load profile and the disaster-recovery drill script.</p>

        <div class="tic-panel tic-panel--ink tic-dv__term" data-dv-browser>
          <div class="tic-panel__bar tic-dv__bar">
            <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
            <span class="tic-dv__repo">your-platform-infra — main</span>
            <span class="tic-dv__count" aria-hidden="true"><?= $tic_dv_n ?> files · <?= count($tic_dv_tree) ?> directories</span>
          </div>

          <div class="tic-dv__body">
            <div class="tic-dv__treewrap">
              <p class="tic-dv__hint" id="deliver-hint">Arrow keys move, → opens a directory, ← closes it, Enter shows a file.</p>
              <ul class="tic-dv__tree" role="tree" aria-label="Infrastructure repository" aria-describedby="deliver-hint" data-dv-tree>
                <?php foreach ($tic_dv_tree as $tic_dv_di => $tic_dv_d): ?>
                  <li role="none" class="tic-dv__group">
                    <button type="button" role="treeitem" class="tic-dv__dir" aria-expanded="true" aria-level="1" aria-owns="deliver-g<?= $tic_dv_di ?>" tabindex="-1" data-dv-dir="<?= e($tic_dv_d[0]) ?>">
                      <span class="tic-dv__caret" aria-hidden="true"></span>
                      <span class="tic-dv__dn"><?= e($tic_dv_d[1]) ?></span>
                      <span class="tic-dv__dc"><?= e($tic_dv_d[2]) ?></span>
                    </button>
                    <ul role="group" id="deliver-g<?= $tic_dv_di ?>" class="tic-dv__kids">
                      <?php foreach ($tic_dv_d[3] as $tic_dv_k): $tic_dv_f = $tic_dv_files[$tic_dv_k]; $tic_dv_on = $tic_dv_k === $tic_dv_open; ?>
                        <li role="none">
                          <button type="button" role="treeitem" class="tic-dv__file<?= $tic_dv_on ? ' is-on' : '' ?>" aria-selected="<?= $tic_dv_on ? 'true' : 'false' ?>" aria-level="2" tabindex="<?= $tic_dv_on ? '0' : '-1' ?>" data-dv-file="<?= e($tic_dv_k) ?>" data-dv-parent="<?= e($tic_dv_d[0]) ?>">
                            <span class="tic-dv__fi" aria-hidden="true"></span>
                            <span class="tic-dv__fn"><?= e(substr($tic_dv_f[0], strlen($tic_dv_d[1]))) ?></span>
                            <span class="tic-dv__lang"><?= e($tic_dv_f[1]) ?></span>
                          </button>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>

            <div class="tic-dv__view">
              <p class="tic-dv__path" aria-hidden="true"><span data-dv-path><?= e($tic_dv_files[$tic_dv_open][0]) ?></span><b data-dv-lang><?= e($tic_dv_files[$tic_dv_open][1]) ?></b></p>
              <div class="tic-dv__panes" data-dv-panes>
                <?php foreach ($tic_dv_files as $tic_dv_k => $tic_dv_f): $tic_dv_md = str_ends_with($tic_dv_f[0], '.md'); ?>
                  <div class="tic-dv__pane<?= $tic_dv_md ? ' tic-dv__pane--md' : '' ?>" data-dv-pane="<?= e($tic_dv_k) ?>"<?= $tic_dv_k === $tic_dv_open ? '' : ' hidden' ?>>
                    <p class="tic-dv__fp"><?= e($tic_dv_f[0]) ?></p>
                    <pre class="tic-dv__code bdh-scroll-x" tabindex="0" aria-label="<?= e($tic_dv_f[0]) ?>"><?= $tic_dv_code($tic_dv_f[2], $tic_dv_md) ?></pre>
                    <p class="tic-dv__prov"><span><?= count(explode("\n", $tic_dv_f[2])) ?> lines</span><span><?= e($tic_dv_prov[$tic_dv_k] ?? '') ?></span></p>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>

          <p class="tic-dv__status bdh-sr" aria-live="polite" data-dv-status></p>
        </div>
        <p class="tic-note tic-dv__foot"><span>Paths and values are illustrative; the shape, and the arithmetic behind the thresholds, are the ones we ship.</span> <span class="bdh-ill">Illustrative</span></p>
      </div>

      <div class="tic-dv__side">
        <div class="tic-dv__hand" data-rv>
          <p class="tic-k">Handover pack</p>
          <ul class="bdh-list tic-dv__list" role="list">
            <?php foreach ($CAP['deliver'] as $tic_dv_d2): ?>
              <li><span><?= e($tic_dv_d2[0]) ?></span><small><?= e($tic_dv_d2[1]) ?></small></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <ul class="tic-dv__rules" role="list" data-rv-s data-rv-step="90">
          <li class="tic-dv__rule"><?= xt_icon('git-branch', ['size' => 18]) ?><b>Change goes through review</b><span>Every environment change is a pull request with a plan attached, a policy check and an approver. Nothing reaches production from a laptop.</span></li>
          <li class="tic-dv__rule"><?= xt_icon('key', ['size' => 18]) ?><b>Your accounts, your keys</b><span>The cloud accounts, registries, secret stores and provider keys are yours from day one. We work inside them with scoped, auditable access.</span></li>
          <li class="tic-dv__rule"><?= xt_icon('doc', ['size' => 18]) ?><b>Decisions are written down</b><span>Architecture decision records explain what was chosen, what was rejected and what would change the answer — the context a future team needs.</span></li>
        </ul>

        <div class="tic-dv__stack" data-rv>
          <p class="tic-k">Built and operated with</p>
          <?= xt_stack(['terraform', 'helm', 'kubernetes', 'argo', 'githubactions', 'vault', 'grafana', 'k6'], ['variant' => 'chips', 'size' => 17, 'label' => 'Infrastructure and delivery technologies we work with']) ?>
        </div>
      </div>
    </div>
  </div>
</section>
