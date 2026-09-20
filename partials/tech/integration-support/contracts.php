<?php /* DRAFT COPY — review before launch */
/* Contracts — an integration is a promise between two systems, so it gets a written contract.
   Left: an OpenAPI 3.1 excerpt where a field has been removed, shown as a CI diff. Right: the
   pipeline that caught it — a contract-test job that goes red, the consumer impact list, and the
   resolution (a major version and a deprecation window) that turns it amber then green.
   The shipped verdict matches the rows underneath it — v1 is blocked and the change ships as a
   major version — and contracts.js, which steps the CI check and the diff highlight once the band
   is on screen, resolves it to "ready to merge" at the end of the run. The HTML is the complete,
   readable state throughout: the diff, all five jobs, the deprecation window and all three
   registered consumers are present with no JS. */
$tis_ct_diff = [   // [gutter, kind: ctx|del|add|hunk, code html]
    ['', 'hunk', '@@ components.schemas.Order @@'],
    ['312', 'ctx', '<span class="k">required</span>:'],
    ['313', 'ctx', '  - <span class="s">id</span>'],
    ['314', 'ctx', '  - <span class="s">order_date</span>'],
    ['315', 'del', '  - <span class="s">customer_email</span>'],
    ['315', 'add', '  - <span class="s">customer_id</span>'],
    ['316', 'ctx', '  - <span class="s">amount</span>'],
    ['317', 'ctx', '<span class="k">properties</span>:'],
    ['318', 'del', '  <span class="k">customer_email</span>: { <span class="k">type</span>: <span class="s">string</span>, <span class="k">format</span>: <span class="s">email</span> }'],
    ['318', 'add', '  <span class="k">customer_id</span>:    { <span class="k">type</span>: <span class="s">string</span>, <span class="k">pattern</span>: <span class="s">"^C-\\d{6}$"</span> }'],
    ['319', 'ctx', '  <span class="k">amount</span>:         { <span class="k">type</span>: <span class="s">number</span>, <span class="k">minimum</span>: <span class="n">0</span> }'],
];
$tis_ct_steps = [   // [id, job, detail, verdict: fail|warn|pass, readout]
    ['lint',   'Lint the spec',            'Spectral rules: operation ids, error shapes, pagination, examples present.', 'pass', '46 rules · 0 errors'],
    ['break',  'Detect breaking changes',  'The new spec is compared with the published one. Removing a required property is breaking.', 'fail', '1 breaking · order.customer_email removed'],
    ['pact',   'Consumer contract tests',  'Every registered consumer replays its recorded expectations against the new spec.', 'fail', '2 of 3 consumers fail'],
    ['ver',    'Version &amp; deprecation', 'Breaking change accepted behind a major version, with the old field kept for one window.', 'warn', 'v2.0.0 proposed · needs sign-off'],
    ['pub',    'Publish &amp; notify',     'The spec, the changelog and the generated clients are published; consumers are notified.', 'pass', 'v2.0.0 published · 3 consumers notified'],
];
$tis_ct_cons = [   // [consumer, owner, what breaks, status]
    ['Warehouse dispatch',   'Logistics',        'Reads customer_email on every dispatch note.',     'fail'],
    ['Marketing sync',       'Growth',           'Keys its audience upsert on the email address.',   'fail'],
    ['Finance export',       'Finance',          'Uses id, order_date and amount only.',             'pass'],
];
/* Specifications have no badge in the kit (badges are governance frameworks only), so they render as
   mono spec chips; the two frameworks that do have badges are drawn with xt_badge. */
$tis_ct_specs  = ['OpenAPI 3.1', 'AsyncAPI 3.0', 'CloudEvents 1.0', 'JSON Schema 2020-12', 'OAuth 2.1 · OIDC', 'Semantic Versioning 2.0'];
$tis_ct_badges = ['iso27001', 'soc2', 'gdpr', 'dpdp'];
?>
<section class="band tis-contracts" id="contracts" aria-labelledby="contracts-t">
  <div class="wrap">

    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tis-kick"><b>$ spec diff --against published</b> <span>contract-first · versioned</span></p>
        <h2 class="h2" id="contracts-t"><span class="g">Integrations with contracts,</span> not assumptions.</h2>
      </div>
      <div>
        <p class="lead">Most integration outages start as a small, reasonable change on the other side of the wire. When both sides share a written contract, that change meets a failing build instead of your customers.</p>
        <p class="tis-ill">Illustrative pipeline · fictional API</p>
      </div>
    </div>

    <div class="tis-ct" data-rv>

      <!-- the diff -->
      <div class="tis-ct__spec tis-panel">
        <div class="tis-panel__bar">
          <span><b>orders-api.yaml</b> · OpenAPI 3.1</span>
          <span class="tis-ct__branch">feat/customer-id</span>
        </div>
        <div class="tis-ct__diff bdh-scroll-x" tabindex="0" role="group" aria-label="Specification diff: customer_email replaced by customer_id">
          <ol class="tis-ct__lines">
            <?php foreach ($tis_ct_diff as $tis_ct_i => $tis_ct_l): ?>
              <li class="tis-ct__l tis-ct__l--<?= e($tis_ct_l[1]) ?>" style="--i:<?= $tis_ct_i ?>">
                <span class="tis-ct__g" aria-hidden="true"><?= e($tis_ct_l[0]) ?></span>
                <span class="tis-ct__s" aria-hidden="true"><?= $tis_ct_l[1] === 'del' ? '−' : ($tis_ct_l[1] === 'add' ? '+' : '') ?></span>
                <code class="tis-code"><?= $tis_ct_l[2] ?></code>
              </li>
            <?php endforeach; ?>
          </ol>
        </div>
        <p class="tis-ct__note">
          <?= xt_icon('alert', ['size' => 16]) ?>
          <span><b>Removing a required property is a breaking change.</b> It ships as a new major version with the old field kept through an agreed deprecation window, never as a silent edit to v1.</span>
        </p>

        <!-- PLACEHOLDER: confirm the standard deprecation window offered to consumers before launch -->
        <div class="tis-ct__dep">
          <p class="tis-ct__depk">Deprecation window, written into the change</p>
          <ol class="tis-ct__deps" role="list">
            <?php foreach ([
              ['Week 0', 'v2.0.0 published', 'v1 keeps serving customer_email. Both versions run side by side and both are monitored.', 'now'],
              ['Week 1', 'Consumers notified', 'Each registered consumer gets the changelog, the generated client and a migration date it agrees to.', 'done'],
              ['Week 8', 'v1 sunset', 'v1 responds 410 Gone with a link to the migration note. Nothing is removed while a consumer is still calling it.', 'planned'],
            ] as $tis_ct_d): ?>
              <li class="tis-ct__dp is-<?= e($tis_ct_d[3]) ?>">
                <span class="tis-ct__dpw bdh-ro"><?= e($tis_ct_d[0]) ?></span>
                <span class="tis-ct__dpb">
                  <b><?= e($tis_ct_d[1]) ?></b>
                  <span><?= e($tis_ct_d[2]) ?></span>
                </span>
              </li>
            <?php endforeach; ?>
          </ol>
        </div>
      </div>

      <!-- the pipeline -->
      <div class="tis-ct__ci tis-panel">
        <div class="tis-panel__bar">
          <span><b>contract-check</b> · pull request #418</span>
          <span class="tis-ct__verdict" data-verdict><span class="tis-led tis-led--pulse"></span><span data-verdict-t data-verdict-end="Ready to merge as v2.0.0">Blocked on v1 &middot; ships as v2.0.0</span></span>
        </div>
        <ol class="tis-ct__jobs">
          <?php foreach ($tis_ct_steps as $tis_ct_j => $tis_ct_s): ?>
            <li class="tis-ct__job is-<?= e($tis_ct_s[3]) ?>" data-job="<?= e($tis_ct_s[0]) ?>" style="--i:<?= $tis_ct_j ?>">
              <span class="tis-ct__mark" aria-hidden="true"><?= xt_icon($tis_ct_s[3] === 'pass' ? 'check' : ($tis_ct_s[3] === 'fail' ? 'alert' : 'clock'), ['size' => 14, 'mono' => true]) ?></span>
              <div class="tis-ct__jb">
                <h3 class="bdh-t bdh-t--s"><?= $tis_ct_s[1] ?></h3>
                <p class="bdh-d"><?= $tis_ct_s[2] ?></p>
                <p class="tis-ct__ro bdh-ro"><?= $tis_ct_s[4] ?></p>
              </div>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>

      <!-- who it breaks -->
      <div class="tis-ct__cons tis-panel">
        <div class="tis-panel__bar"><span><b>Consumer impact</b> · from the contract registry</span><span>3 registered</span></div>
        <ul class="tis-ct__clist" role="list">
          <?php foreach ($tis_ct_cons as $tis_ct_c): ?>
            <li class="tis-ct__c is-<?= e($tis_ct_c[3]) ?>">
              <span class="tis-led <?= $tis_ct_c[3] === 'pass' ? '' : 'tis-led--warn' ?>" aria-hidden="true"></span>
              <span class="tis-ct__cn"><?= e($tis_ct_c[0]) ?><small><?= e($tis_ct_c[1]) ?></small></span>
              <span class="tis-ct__cd"><?= e($tis_ct_c[2]) ?></span>
              <span class="tis-ct__cs bdh-ro"><?= $tis_ct_c[3] === 'pass' ? 'unaffected' : 'needs a change' ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
        <dl class="tis-ct__reg">
          <?php foreach ([
            ['What the registry holds', 'Recorded expectations per consumer, its owner and on-call contact'],
            ['When it is replayed', 'Every push to the provider, and nightly against the vendor sandbox'],
            ['What a red result blocks', 'The merge, not the consumer: v1 keeps serving until the window closes'],
            ['How a consumer joins', 'It publishes its expectations from its own test suite; no ticket to us'],
          ] as $tis_ct_g): ?>
            <div><dt><?= e($tis_ct_g[0]) ?></dt><dd><?= e($tis_ct_g[1]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
      </div>

      <!-- the rules that come with a contract -->
      <ul class="tis-ct__rules" role="list">
        <?php foreach ([
          ['key', 'Secrets in a vault', 'Credentials live in a managed secret store with rotation and scoped access, never in code, CI variables or a connector’s notes field.'],
          ['lock', 'Scoped OAuth tokens', 'Each integration gets its own client with the narrowest scopes that work, so a leaked token cannot read the whole tenant.'],
          ['gauge', 'Rate limits, both ways', 'We honour the other side’s limits with exponential backoff and jitter, and publish our own so consumers can plan for them.'],
          ['eval', 'Tests the consumer wrote', 'Consumer-driven contract tests are recorded by the teams that call the API and replayed on every change to it.'],
        ] as $tis_ct_r): ?>
          <li class="tis-ct__rule">
            <?= xt_icon($tis_ct_r[0], ['size' => 20]) ?>
            <div>
              <h3 class="bdh-t bdh-t--s"><?= e($tis_ct_r[1]) ?></h3>
              <p class="bdh-d"><?= e($tis_ct_r[2]) ?></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="tis-ct__std">
        <div class="tis-ct__stdg">
          <p class="tis-ct__stdk">Specifications every integration is written against</p>
          <ul class="tis-ct__specs" role="list">
            <?php foreach ($tis_ct_specs as $tis_ct_sp): ?><li><span class="tis-word"><?= e($tis_ct_sp) ?></span></li><?php endforeach; ?>
          </ul>
        </div>
        <div class="tis-ct__stdg">
          <p class="tis-ct__stdk">Frameworks we align integration delivery with</p>
          <ul class="xt-badges" role="list">
            <?php foreach ($tis_ct_badges as $tis_ct_b): ?><?= xt_badge($tis_ct_b, ['tag' => 'li']) ?><?php endforeach; ?>
          </ul>
        </div>
      </div>

    </div>

    <p class="bdh-sr">The pipeline shown is illustrative: a contract check on a fictional orders API detects that a required field was removed, lists the two of three registered consumers that would break, and resolves it as a new major version with a deprecation window.</p>
  </div>
</section>
