<?php /* DRAFT COPY — review before launch */
/* Signature — Design Consulting: capability-to-roadmap solution map. Five capabilities the ambition needs, each placed
   on three roadmap phases by the route chosen (a extend · b compose · c build new). Bars move between routes; the
   readout compares effort, run cost and risk like for like. Ships route b (the recommended one). */
$pxd_opts = [
    ['a', 'Route A · Extend', 'Extend the current platform: 14–20 weeks, but the billing rewrite blocks phase two. Rejected, reason recorded.'],
    ['b', 'Route B · Compose', 'Compose proven services around the core: 9–13 weeks, lowest change risk. Recommended.'],
    ['c', 'Route C · Build new', 'Build a new service: 26–38 weeks for the same outcome. Rejected, reason recorded.'],
];
$pxd_def = 1;
$pxd_sr  = 'An illustrative solution map: five capabilities placed on three roadmap phases for three routes, with effort, running cost and risk compared; the compose route is recommended.';
$pxd_sm = [   // capability => [route => [start phase 0-2, span 1-3, how]]
    'Identity & SSO'         => ['a' => [0, 1, 'Extend'],   'b' => [0, 1, 'Buy'],     'c' => [0, 2, 'Build']],
    'Self-serve onboarding'  => ['a' => [0, 2, 'Redesign'], 'b' => [0, 1, 'Compose'], 'c' => [1, 2, 'Build']],
    'Usage analytics'        => ['a' => [1, 1, 'Extend'],   'b' => [0, 1, 'Buy'],     'c' => [1, 2, 'Build']],
    'Billing & plan change'  => ['a' => [1, 2, 'Rewrite'],  'b' => [1, 1, 'Buy'],     'c' => [0, 3, 'Build']],
    'AI setup assistant'     => ['a' => [2, 1, 'Pilot'],    'b' => [1, 2, 'Compose'], 'c' => [2, 1, 'Build']],
];
$pxd_ro = [
    'Effort'      => ['a' => '14–20 wks', 'b' => '9–13 wks', 'c' => '26–38 wks'],
    'Run cost'    => ['a' => '1.0× today', 'b' => '1.2× today', 'c' => '0.9× today'],
    'Change risk' => ['a' => 'High', 'b' => 'Low', 'c' => 'Medium'],
];
?>
<div class="pxd-sm">
  <div class="pxd-sm__head"><span>Capability needed</span><span>P1 · Q1</span><span>P2 · Q2</span><span>P3 · H2</span></div>
  <?php foreach ($pxd_sm as $pxd_name => $pxd_rt): ?>
  <div class="pxd-sm__row">
    <span class="pxd-sm__k"><?= e($pxd_name) ?></span>
    <span class="pxd-sm__tr" style="<?php foreach ($pxd_rt as $pxd_v => $pxd_b) echo "--s$pxd_v:{$pxd_b[0]};--w$pxd_v:{$pxd_b[1]};"; ?>">
      <span class="pxd-sm__bar"><?php foreach ($pxd_rt as $pxd_v => $pxd_b): ?><i data-on="<?= $pxd_v ?>"><?= e($pxd_b[2]) ?></i><?php endforeach; ?></span>
    </span>
  </div>
  <?php endforeach; ?>
  <dl class="pxd-sm__ro">
    <?php foreach ($pxd_ro as $pxd_k => $pxd_vals): ?>
    <div><dt><?= e($pxd_k) ?></dt><dd><?php foreach ($pxd_vals as $pxd_v => $pxd_t): ?><span data-on="<?= $pxd_v ?>"><?= e($pxd_t) ?></span><?php endforeach; ?></dd></div>
    <?php endforeach; ?>
    <div class="pxd-sm__verdict"><dt>Verdict</dt><dd><span data-on="a">Rejected</span><span data-on="b" class="is-rec">Recommended</span><span data-on="c">Rejected</span></dd></div>
  </dl>
</div>
