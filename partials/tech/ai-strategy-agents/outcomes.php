<?php /* DRAFT COPY — review before launch */
/* Outcomes — the 90-day agent review as a scorecard. Six measures (carbon is an SCI estimate against the manual process), each with a pass line and a hold
   line agreed before the agent is built, a meter, the value at review and a status (pass · watch ·
   hold). A switch compares two agents: one that stays and one that goes back a level, so the page
   shows the measures deciding. outcomes.js swaps the agent, moves the meters and ticks the statuses
   on entry. Every value is illustrative; the lines are targets, not reported results.
   HTML = agent A, the finished review. */
$tas_oc_rows = [   // [key, measure, how it is measured, scale [min,max], dir (up = higher is better), pass line, hold line, [pass label, hold label]]
    ['hours', 'Hours returned per week',      'Handling time saved × volume, against the baseline taken before build',            [0, 100], 'up',   60, 30, ['≥ 60 h', '< 30 h']],
    ['succ',  'Task success on evals',        'The golden set, re-run on every change and at each review',                         [70, 100], 'up',  92, 85, ['≥ 92%', '< 85%']],
    ['cost',  'Cost per task vs manual',      'Models, tools, hosting and review time per completed task, as a share of manual cost', [0, 100], 'down', 25, 50, ['≤ 25%', '> 50%']],
    ['esc',   'Escalation rate',              'Share of runs handed to a person, by reason',                                       [0, 30],  'down', 10, 20, ['≤ 10%', '> 20%']],
    ['viol',  'Policy violations',            'Writes outside policy, from the audit log and the red-team suite',                  [0, 5],   'down', 0,  1,  ['= 0', '≥ 1']],
    ['carbon','Carbon per task vs manual',    'SCI estimate per completed task, as a share of the manual process on the same grid', [0, 120], 'down', 50, 100, ['≤ 50%', '≥ 100%']],
];
$tas_oc_agents = [
    'a' => [
        'id' => 'renewals-agent', 'task' => 'Draft renewal quotes', 'lvl' => 3, 'owner' => 'Sales ops lead', 'days' => 90,
        'vals' => ['hours' => [74, '74 h'], 'succ' => [94.2, '94.2%'], 'cost' => [13, '13% · $0.62 vs $4.80'], 'esc' => [6.8, '6.8%'], 'viol' => [0, '0'], 'carbon' => [19, '19% · 0.9 vs 4.8 Wh est.']],
        'dec' => 'Stays at L3', 'dlvl' => 3,
        'next' => 'Review in 90 days whether quotes with discounts of 5% or less can move to L4, inside limits.',
    ],
    'b' => [
        'id' => 'billing-agent', 'task' => 'Resolve billing disputes', 'lvl' => 3, 'owner' => 'Service lead', 'days' => 90,
        'vals' => ['hours' => [41, '41 h'], 'succ' => [88.0, '88.0%'], 'cost' => [74, '74% · $3.10 vs $4.20'], 'esc' => [23, '23%'], 'viol' => [0, '0'], 'carbon' => [69, '69% · 2.9 vs 4.2 Wh est.']],
        'dec' => 'Back to L2 · Draft', 'dlvl' => 2,
        'next' => 'Billing history is split across two systems, so a quarter of disputes escalate. Fix the integration, re-run the evals, review in 30 days.',
    ],
];
$tas_oc_pos = function (array $r, float $v): float { return round(max(0, min(1, ($v - $r[3][0]) / ($r[3][1] - $r[3][0]))) * 100, 2); };
$tas_oc_state = function (array $r, float $v): string {
    if ($r[4] === 'up') return $v >= $r[5] ? 'pass' : ($v < $r[6] ? 'hold' : 'watch');
    return $v <= $r[5] ? 'pass' : ($v >= $r[6] ? 'hold' : 'watch');
};
$tas_oc_word = ['pass' => 'Pass', 'watch' => 'Watch', 'hold' => 'Hold'];
/* client-side data for the switch */
$tas_oc_json = [];
foreach ($tas_oc_agents as $tas_ak => $tas_a) {
    $tas_rows = [];
    foreach ($tas_oc_rows as $tas_r) {
        $tas_v = $tas_a['vals'][$tas_r[0]];
        $tas_rows[$tas_r[0]] = ['p' => $tas_oc_pos($tas_r, $tas_v[0]), 't' => $tas_v[1], 's' => $tas_oc_state($tas_r, $tas_v[0])];
    }
    $tas_oc_json[$tas_ak] = ['id' => $tas_a['id'], 'task' => $tas_a['task'], 'owner' => $tas_a['owner'], 'rows' => $tas_rows, 'dec' => $tas_a['dec'], 'dlvl' => $tas_a['dlvl'], 'next' => $tas_a['next']];
}
$tas_oc_a = $tas_oc_agents['a'];
?>
<section class="band tas-outcomes" id="outcomes" aria-labelledby="outcomes-t">
  <div class="wrap">
    <div class="tas-head" data-rv>
      <div class="tas-head__t">
        <p class="tas-kick"><span class="tas-kick__ref">11</span>Outcomes · the 90-day review</p>
        <h2 class="h2" id="outcomes-t"><span class="g">Measures that decide</span> whether an agent stays.</h2>
      </div>
      <div class="tas-head__l">
        <p class="lead">Every agent is reviewed on the same six measures, with a pass line and a hold line agreed before it is built. An agent that misses them goes back a level. The lines are review targets, not results we are reporting.</p>
      </div>
    </div>

    <div class="tas-oc" data-tas-oc data-agent="a" data-rv data-oc='<?= e(json_encode($tas_oc_json, JSON_UNESCAPED_UNICODE)) ?>'>
      <div class="tas-oc__bar">
        <div class="tas-oc__id">
          <p class="tas-lbl">Agent review · day <?= (int) $tas_oc_a['days'] ?></p>
          <p class="tas-oc__who"><code data-oc="id"><?= e($tas_oc_a['id']) ?></code><span data-oc="task"><?= e($tas_oc_a['task']) ?></span><span class="tas-oc__own">owner <b data-oc="owner"><?= e($tas_oc_a['owner']) ?></b></span></p>
        </div>
        <div class="bdh-seg tas-oc__seg" role="group" aria-label="Choose the agent under review">
          <button type="button" aria-pressed="true" data-oc-agent="a">Agent A · renewals</button>
          <button type="button" aria-pressed="false" data-oc-agent="b">Agent B · billing</button>
        </div>
      </div>

      <div class="tas-oc__tbl" role="table" aria-label="Review scorecard" aria-describedby="outcomes-note">
        <div class="tas-oc__hr" role="row">
          <span role="columnheader">Measure</span>
          <span role="columnheader">Hold and pass lines</span>
          <span role="columnheader">At review</span>
          <span role="columnheader">Status</span>
        </div>
        <?php foreach ($tas_oc_rows as $tas_ri => $tas_r):
            $tas_v = $tas_oc_a['vals'][$tas_r[0]];
            $tas_st = $tas_oc_state($tas_r, $tas_v[0]);
            $tas_pp = $tas_oc_pos($tas_r, (float) $tas_r[5]); $tas_hp = $tas_oc_pos($tas_r, (float) $tas_r[6]);
            $tas_zl = $tas_r[4] === 'up' ? $tas_pp : 0; $tas_zw = $tas_r[4] === 'up' ? 100 - $tas_pp : $tas_pp;
            $tas_hl = $tas_r[4] === 'up' ? 0 : $tas_hp; $tas_hw = $tas_r[4] === 'up' ? $tas_hp : 100 - $tas_hp; ?>
          <div class="tas-oc__row" role="row" data-row="<?= e($tas_r[0]) ?>" data-s="<?= e($tas_st) ?>" style="--i:<?= $tas_ri ?>">
            <div class="tas-oc__m" role="rowheader">
              <h3><?= e($tas_r[1]) ?></h3>
              <p><?= e($tas_r[2]) ?></p>
            </div>
            <div class="tas-oc__meter" role="cell">
              <span class="tas-oc__track" aria-hidden="true">
                <i class="tas-oc__zone tas-oc__zone--pass" style="left:<?= $tas_zl ?>%;width:<?= max(0.8, $tas_zw) ?>%"></i>
                <i class="tas-oc__zone tas-oc__zone--hold" style="left:<?= $tas_hl ?>%;width:<?= $tas_hw ?>%"></i>
                <i class="tas-oc__tick" style="left:<?= $tas_pp ?>%"></i>
                <i class="tas-oc__tick tas-oc__tick--h" style="left:<?= $tas_hp ?>%"></i>
                <i class="tas-oc__val" style="--p:<?= $tas_oc_pos($tas_r, $tas_v[0]) / 100 ?>"></i>
              </span>
              <span class="tas-oc__lines"><?php if ($tas_r[4] === 'up'): ?><span>Hold <?= e($tas_r[7][1]) ?></span><span>Pass <?= e($tas_r[7][0]) ?></span><?php else: ?><span>Pass <?= e($tas_r[7][0]) ?></span><span>Hold <?= e($tas_r[7][1]) ?></span><?php endif; ?></span>
            </div>
            <p class="tas-oc__v" role="cell" data-oc-v><?= e($tas_v[1]) ?></p>
            <p class="tas-oc__st" role="cell"><span class="tas-oc__pill" data-oc-s><i aria-hidden="true"></i><span><?= e($tas_oc_word[$tas_st]) ?></span></span></p>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="tas-oc__dec" aria-live="polite">
        <p class="tas-lbl">Decision</p>
        <p class="tas-oc__dt"><span data-oc="dec"><?= e($tas_oc_a['dec']) ?></span><span data-oc="dlvl"><?= tas_lvl($tas_oc_a['dlvl']) ?></span></p>
        <p class="tas-oc__dn" data-oc="next"><?= e($tas_oc_a['next']) ?></p>
        <p class="tas-oc__sign"><span>Signed · owner</span><span>Reviewed · risk and security</span><span>Logged · audit trail</span></p>
      </div>
      <p class="tas-oc__note" id="outcomes-note"><span class="tas-ill">Illustrative review</span>Lines are agreed per agent before build. Cost includes the time people spend approving and reviewing.</p>
    </div>

  </div>
</section>
