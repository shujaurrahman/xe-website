<?php /* DRAFT COPY — review before launch */ ?>
<?php
/**
 * 24 — Technology & Intelligence: what we build and run.
 *
 * "The system diagram". One layered diagram: four strata (L1 Experience … L4 Trust & operations,
 * the layer model of the Technology & Intelligence hub) with all ten capabilities visible at once
 * as nodes in their layer. Choosing a node (click, Enter, focus, or hover on hover-capable devices)
 * opens its detail below the diagram: what it ships, what it works with (the stack, grouped by
 * layer of the system) and the frameworks it is built to, with a link to its page. The frameworks
 * index underneath works the other way round: choose a framework and the diagram lights every
 * capability built to it.
 *
 * Differs from 08-disciplines (names only) and 14-platforms (a model-vendor wall): technology here
 * always appears inside a capability, grouped by the layer it runs in. Differs from 23-brand (tabs
 * in an app window): no tabs, no window chrome, everything visible at once.
 *
 * No JavaScript: nodes are anchors to their detail blocks; the first detail shows and any other
 * shows when targeted (CSS :target). The frameworks index is plain content.
 * With JavaScript (24-technology.js, .is-js): selection in place, the details share one reserved
 * cell so nothing shifts (above 900px; narrower, the open detail sizes to its content), and the framework rows become toggle buttons.
 */
$s24_ti   = require __DIR__ . '/../data/technology-intelligence.php';
$s24_site = require __DIR__ . '/../data/site.php';

/* approved one-line descriptions, keyed by capability slug */
$s24_one = [];
foreach ($s24_site['disciplines'] as $s24_d) {
    if (($s24_d['slug'] ?? '') !== 'technology-intelligence') continue;
    foreach ($s24_d['caps'] as $s24_cp) { if (!empty($s24_cp[2])) $s24_one[$s24_cp[2]] = $s24_cp[1]; }
}

/* the four strata, as the Technology & Intelligence hub draws them */
$s24_layers = [
    ['L1', 'Experience',         'What customers and search engines touch.',            ['websites-apps', 'search-ai-visibility']],
    ['L2', 'Intelligence',       'Agents, retrieval and automation doing real work.',   ['ai-strategy-agents', 'ai-product-automation']],
    ['L3', 'Platform & data',    'Custom software, data, integration and compute.',     ['custom-software-data-platforms', 'ai-infrastructure-cloud', 'integration-support']],
    ['L4', 'Trust & operations', 'Security, audits and the people who run it.',         ['cybersecurity-ai-trust', 'audits-assessments', 'tech-workforce']],
];
$s24_layer_of = [];
foreach ($s24_layers as $s24_l) { foreach ($s24_l[3] as $s24_slug) $s24_layer_of[$s24_slug] = $s24_l; }

/* the kit's eighteen technology categories, folded into six groups for "Works with" */
$s24_groups = [
    'code'     => ['Code & interfaces',   ['languages', 'frontend', 'mobile', 'backend', 'content']],
    'data'     => ['Data & models',       ['data', 'ai-ml', 'llm', 'ai-tooling']],
    'ops'      => ['Cloud & operations',  ['cloud', 'devops', 'observability', 'security']],
    'connect'  => ['Connected systems',   ['integration', 'business']],
    'search'   => ['Search & analytics',  ['search']],
    'delivery' => ['Delivery & tooling',  ['quality', 'collaboration']],
];
$s24_cat_group = [];
foreach ($s24_groups as $s24_gk => $s24_gv) { foreach ($s24_gv[1] as $s24_cat) $s24_cat_group[$s24_cat] = $s24_gk; }

/* frameworks across all ten, most widely used first */
$s24_std_n = [];
foreach ($s24_ti as $s24_cap) { foreach ($s24_cap['standards'] as $s24_sk) $s24_std_n[$s24_sk] = ($s24_std_n[$s24_sk] ?? 0) + 1; }
arsort($s24_std_n);
$s24_total = count($s24_ti);

$s24_hub  = xe_url('services/technology-intelligence.php');
$s24_link = function (string $slug): ?string {
    return is_file(__DIR__ . '/../services/technology-intelligence/' . $slug . '.php')
        ? xe_url('services/technology-intelligence/' . $slug . '.php') : null;
};
$s24_first = $s24_layers[0][3][0];
?>
<section class="band band--ink s24 bdh" id="technology" aria-labelledby="s24-t">
  <div class="wrap">

    <div class="bdh-head bdh-head--row s24__head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Technology &amp; Intelligence</p>
        <h2 class="h2" id="s24-t"><span class="g">Ten capabilities.</span> One system we build and run.</h2>
      </div>
      <div>
        <p class="lead">Software, AI and the infrastructure under them, in four layers of one platform. Built to recognised frameworks, and looked after once they are live.</p>
        <a class="tl" href="<?= e($s24_hub) ?>">See the whole platform <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <div class="s24__sys" data-s24 data-rv data-rv-d="80">

      <!-- the diagram: four strata, every capability visible in its layer -->
      <div class="s24__dia">
        <p class="s24__hint" aria-hidden="true">Select a capability to open its stack and frameworks</p>
        <ol class="s24__strata" aria-label="Your platform, by layer">
          <?php foreach ($s24_layers as $s24_li => $s24_l): ?>
          <li class="s24__str" style="--i:<?= $s24_li ?>">
            <span class="s24__pulse" aria-hidden="true"><i></i></span>
            <div class="s24__sh">
              <p class="s24__sc"><?= e($s24_l[0]) ?></p>
              <div>
                <p class="s24__sn"><?= e($s24_l[1]) ?></p>
                <p class="s24__sd"><?= e($s24_l[2]) ?></p>
              </div>
            </div>
            <ul class="s24__nodes" aria-label="<?= e($s24_l[1]) ?> capabilities">
              <?php foreach ($s24_l[3] as $s24_slug): $s24_cap = $s24_ti[$s24_slug]; ?>
              <li>
                <a class="s24__node<?= $s24_slug === $s24_first ? ' is-on' : '' ?>" href="#s24-d-<?= e($s24_slug) ?>" aria-controls="s24-d-<?= e($s24_slug) ?>"
                   data-s24-node="<?= e($s24_slug) ?>" data-std="<?= e(implode(' ', $s24_cap['standards'])) ?>">
                  <span class="s24__nic"><?= xt_icon($s24_cap['icon'], ['size' => 18]) ?></span>
                  <span class="s24__nn"><?= e($s24_cap['name']) ?></span>
                  <span class="s24__nd" aria-hidden="true"></span>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </li>
          <?php endforeach; ?>
        </ol>
      </div>

      <!-- the details: one per capability, in the diagram's order -->
      <div class="s24__dets">
        <?php foreach ($s24_layers as $s24_l): foreach ($s24_l[3] as $s24_slug):
            $s24_cap  = $s24_ti[$s24_slug];
            $s24_href = $s24_link($s24_slug);
            $s24_by   = array_fill_keys(array_keys($s24_groups), []);
            foreach ($s24_cap['stack'] as $s24_tech) {
                $s24_t = xt_tech($s24_tech);
                $s24_by[$s24_cat_group[$s24_t['category'] ?? ''] ?? 'connect'][] = $s24_tech;
            }
            $s24_by = array_filter($s24_by);
        ?>
        <article class="s24__det<?= $s24_slug === $s24_first ? ' is-on' : '' ?>" id="s24-d-<?= e($s24_slug) ?>" aria-labelledby="s24-h-<?= e($s24_slug) ?>">
          <div class="s24__da">
            <p class="s24__k"><b><?= e($s24_l[0]) ?></b> <?= e($s24_l[1]) ?> · <?= e($s24_cap['kicker']) ?></p>
            <h3 class="s24__h" id="s24-h-<?= e($s24_slug) ?>"><?= e($s24_cap['name']) ?></h3>
            <p class="s24__d"><?= e($s24_one[$s24_slug] ?? $s24_cap['offer_lead']) ?></p>
            <p class="s24__sl">Ships</p>
            <ul class="s24__ships">
              <?php foreach (array_slice($s24_cap['offer'], 0, 4) as $s24_o): ?>
              <li><?= xt_icon($s24_o[3], ['size' => 16, 'mono' => true]) ?><span><?= e($s24_o[0]) ?></span></li>
              <?php endforeach; ?>
            </ul>
            <?php if ($s24_href): ?>
            <a class="btn btn--white btn--sm s24__go" href="<?= e($s24_href) ?>">Explore <?= e($s24_cap['name']) ?> <span class="i" aria-hidden="true">›</span></a>
            <?php endif; ?>
          </div>

          <div class="s24__db">
            <p class="s24__sl">Works with</p>
            <dl class="s24__with">
              <?php foreach ($s24_by as $s24_gk => $s24_list): ?>
              <div>
                <dt><?= e($s24_groups[$s24_gk][0]) ?></dt>
                <dd><?= xt_stack($s24_list, ['size' => 16, 'label' => $s24_groups[$s24_gk][0], 'class' => 's24__chips']) ?></dd>
              </div>
              <?php endforeach; ?>
            </dl>
          </div>

          <div class="s24__dc">
            <div>
              <p class="s24__sl">Built to</p>
              <ul class="s24__stds" aria-label="Frameworks <?= e($s24_cap['name']) ?> is built to">
                <?php foreach ($s24_cap['standards'] as $s24_sk): ?>
                <?= xt_badge($s24_sk, ['variant' => 'chip', 'tag' => 'li', 'class' => 's24__std-' . $s24_sk]) ?>
                <?php endforeach; ?>
              </ul>
            </div>
            <!-- PLACEHOLDER: confirm typical timeframes and terms before launch (data/technology-intelligence.php 'meta') -->
            <dl class="s24__meta">
              <?php foreach ($s24_cap['meta'] as $s24_mi => $s24_mv): $s24_mk = $s24_cap['meta_k'][$s24_mi] ?? ''; ?>
              <div><dt><?= e($s24_mk === 'Standard' ? 'Practice' : $s24_mk) ?></dt><dd><?= e($s24_mv) ?></dd></div>
              <?php endforeach; ?>
            </dl>
          </div>
        </article>
        <?php endforeach; endforeach; ?>
      </div>
    </div>

    <!-- the reverse view: every framework across the ten, with how many capabilities build to it -->
    <div class="s24__fw" data-rv data-rv-d="120">
      <div class="s24__fwh">
        <p class="s24__sl">Frameworks we build to <span>across all <?= $s24_total ?> capabilities</span></p>
        <div class="s24__fwr">
          <p class="s24__fwt" data-s24-read aria-live="polite">Choose a framework to light the capabilities built to it.</p>
          <ul class="s24__fwc" aria-hidden="true">
            <?php foreach ($s24_layers as $s24_l): foreach ($s24_l[3] as $s24_slug): ?>
            <li data-s24-cap="<?= e($s24_slug) ?>"><?= e($s24_ti[$s24_slug]['name']) ?></li>
            <?php endforeach; endforeach; ?>
          </ul>
        </div>
      </div>
      <ul class="s24__fwl" id="s24-fwl">
        <?php $s24_fi = 0; foreach ($s24_std_n as $s24_sk => $s24_cnt): $s24_s = xt_standard($s24_sk); if (!$s24_s) continue; $s24_fi++; ?>
        <li class="s24__fr<?= ($s24_fi > 5 ? ' s24__o5' : '') . ($s24_fi > 8 ? ' s24__more' : '') . ($s24_fi > 10 ? ' s24__o10' : '') ?>" data-s24-std="<?= e($s24_sk) ?>" data-code="<?= e($s24_s['code']) ?>" style="--n:<?= (int) $s24_cnt ?>">
          <svg class="s24__pip" viewBox="0 0 12 12" aria-hidden="true" focusable="false"><path d="M6 1 10.5 2.8v3.1c0 2.6-1.9 4.5-4.5 5.3C3.4 10.4 1.5 8.5 1.5 5.9V2.8z"/></svg>
          <span class="s24__fc"><?= e($s24_s['code']) ?></span>
          <span class="s24__fn"><?= (int) $s24_cnt ?><i aria-hidden="true">/<?= $s24_total ?></i><span class="sr"> of <?= $s24_total ?> capabilities</span></span>
          <span class="s24__fm" aria-hidden="true"></span>
        </li>
        <?php endforeach; ?>
      </ul>
      <button class="btn btn--sm s24__all" type="button" hidden aria-expanded="false" aria-controls="s24-fwl">Show all <?= $s24_fi ?> frameworks</button>
      <p class="s24__note">Technologies are ones we work with; no partner, reseller or certification tier is implied. Frameworks are what delivery is built to and aligned with, not certifications held.</p>
    </div>

  </div>
</section>
