<?php /* DRAFT COPY — review before launch */
/* TM-09 Process — the programme as a lap you can step, not a project that ends. A dial with four
   numbered nodes (Assess · Harden · Govern · Assure) drives a sheet that shows what the stage starts
   from, what we do in it, what it leaves behind and what it hands to the next stage. Picking a node
   swings the blue quadrant arc round to it, and the dial's centre reads the stage back.

   Stage names, timings, descriptions and outputs come from data/technology-intelligence.php so the hub,
   this page and the catalogue never drift apart. The question, the inputs, the actions and the hand-over
   are page-side, written for this section. Every stage carries the same number of rows, so the pane
   never leaves a void under the short ones.

   The shipped HTML is the finished sheet with stage 01 selected and its arc drawn, so the section reads
   with no JavaScript; process.js only re-points the dial. Timings are typical ranges, not promises. */

$tscpr = $CAP['process'];
$tscpr_steps = array_values($tscpr['steps']);

/* [the question the stage answers, what it starts from, what we do, what it hands to the next stage] */
$tscpr_more = [
    [
        'What is actually exposed, and what would it cost us?',
        ['Your architecture, your cloud accounts and the AI systems already in production.',
         'Whatever the last audit, penetration test or incident has already told you.'],
        ['Threat model every trust boundary, including the ones a model or an agent crosses.',
         'Review identity, network, application and data controls against how the estate is really built.',
         'Inventory each AI system: model, prompt, tools, data and the human accountable for it.'],
        ['Harden', 'a backlog ranked by exploitability against business impact, not by scanner severity'],
    ],
    [
        'Fix the exploitable things first, then stop them coming back.',
        ['The ranked backlog from Assess, with an owner and a date on every item.',
         'Your delivery pipeline exactly as it runs today.'],
        ['Fix what is exploitable now; everything else goes on the register with a date and an owner.',
         'Put the check that would have caught it into the pipeline: SAST, DAST, dependency, secret and AI red-team gates.',
         'Clean up standing access, rotate secrets, and place guardrails in front of and behind every model.'],
        ['Govern', 'controls that work, but that nobody has yet been made accountable for'],
    ],
    [
        'Name the owners, write the rules, automate the proof.',
        ['Working controls with no named owner and no written rule behind them.',
         'The frameworks you actually answer to, from the crosswalk in TM-06.'],
        ['Write the policy set and the statement of applicability against your systems, not a template.',
         'Give every control and every AI use case a named owner and a review cadence.',
         'Wire evidence collection into the pipeline, so the proof is produced by the work itself.'],
        ['Assure', 'a control set that is owned, written down and collecting its own evidence'],
    ],
    [
        'Keep testing, keep watching, keep the evidence current.',
        ['A governed control set, and an estate that will not stop changing.',
         'The detection rules, red-team suites and runbooks the first three stages left behind.'],
        ['Run the scanners, the red-team suites and the tabletop exercises on a schedule.',
         'Watch detection quality, not alert volume: what fired, what should have, and what did not.',
         'Report posture to leadership in numbers a board can act on, and carry the audit when it comes.'],
        ['Assess', 'the next lap, opened by the quarter or by whichever change below lands first'],
    ],
];
$tscpr_pos = ['top', 'right', 'bottom', 'left'];   // where each node sits on the dial
?>
<section class="band band--alt tsc-process" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tsc-ref"><b>TM-09</b><span>How we run it</span></p>
        <h2 class="h2" id="process-t"><span class="g">Assess, harden, govern,</span> assure &#8212; then round again.</h2>
      </div>
      <div>
        <p class="lead"><?= e($tscpr['lead']) ?> A security programme that ends is a security programme that expires. Step the lap below: each stage says what it starts from, what it leaves behind and what it hands on.</p>
      </div>
    </div>

    <div class="tsc-cy" data-rv>
      <div class="tsc-cy__left">
        <div class="tsc-cy__dial" style="--i:0" data-cy-dial>
          <svg class="tsc-cy__ring" viewBox="0 0 400 400" fill="none" aria-hidden="true" focusable="false">
            <circle class="tsc-cy__base" cx="200" cy="200" r="130"/>
            <circle class="tsc-cy__arc" cx="200" cy="200" r="130" pathLength="100" transform="rotate(-90 200 200)"/>
          </svg>

          <div class="tsc-cy__nodes" role="tablist" aria-label="Stages of one lap">
            <?php foreach ($tscpr_steps as $tscpr_i => $tscpr_s): ?>
              <button type="button" role="tab" class="tsc-cy__node tsc-cy__node--<?= $tscpr_pos[$tscpr_i] ?>"
                      id="process-tab<?= $tscpr_i ?>" aria-controls="process-p<?= $tscpr_i ?>"
                      aria-selected="<?= $tscpr_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $tscpr_i === 0 ? '0' : '-1' ?>">
                <span class="tsc-cy__nn"><?= str_pad((string) ($tscpr_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                <span class="bdh-sr"><?= e($tscpr_s[0]) ?></span>
              </button>
            <?php endforeach; ?>
          </div>

          <p class="tsc-cy__core" aria-hidden="true">
            <span class="tsc-cy__ck">Stage <b data-cy-idx>01</b> of <?= count($tscpr_steps) ?></span>
            <span class="tsc-cy__cn" data-cy-name><?= e($tscpr_steps[0][0]) ?></span>
            <span class="tsc-cy__cw tsc-mono" data-cy-when><?= e($tscpr_steps[0][1]) ?></span>
          </p>
        </div>

        <p class="tsc-cy__legend" aria-hidden="true">
          <?php foreach ($tscpr_steps as $tscpr_i => $tscpr_s): ?>
            <span class="tsc-cy__lg<?= $tscpr_i === 0 ? ' is-on' : '' ?>" data-cy-lg="<?= $tscpr_i ?>"><i><?= str_pad((string) ($tscpr_i + 1), 2, '0', STR_PAD_LEFT) ?></i><?= e($tscpr_s[0]) ?></span>
          <?php endforeach; ?>
        </p>

        <p class="tsc-cy__cad">
          <span class="tsc-led tsc-led--ping" aria-hidden="true"></span>
          <!-- PLACEHOLDER: confirm the standing cadence we commit to before launch -->
          One lap per quarter, plus a lap on every material change. The lap never closes; it starts again from whatever changed.
        </p>

        <p class="bdh-sr">Illustrative programme dial. Four stages sit on a ring: Assess at the top, Harden to the right, Govern at the foot and Assure to the left, with a blue arc running from the stage you pick to the one it hands to. Selecting a stage is the same as choosing its tab; each stage is written out in full in the sheet beside the dial, and the fourth stage hands back to the first.</p>
      </div>

      <div class="bdh-panes tsc-cy__panes">
        <?php foreach ($tscpr_steps as $tscpr_i => $tscpr_s):
            $tscpr_m = $tscpr_more[$tscpr_i]; ?>
          <div class="bdh-pane tsc-cy__pane<?= $tscpr_i === 0 ? ' is-on' : '' ?>" id="process-p<?= $tscpr_i ?>" role="tabpanel" aria-labelledby="process-tab<?= $tscpr_i ?>">
            <div class="tsc-cy__ph">
              <p class="tsc-cy__pk">Stage <?= str_pad((string) ($tscpr_i + 1), 2, '0', STR_PAD_LEFT) ?> of <?= count($tscpr_steps) ?> <i>&#183;</i>
                <!-- PLACEHOLDER: confirm typical timing before launch -->
                <?= e($tscpr_s[1]) ?></p>
              <h3 class="tsc-cy__pt"><?= e($tscpr_s[0]) ?></h3>
              <p class="tsc-cy__pq"><?= e($tscpr_m[0]) ?></p>
            </div>
            <p class="tsc-cy__pd"><?= e($tscpr_s[2]) ?></p>

            <div class="tsc-cy__relay">
              <div class="tsc-cy__rb">
                <p class="tsc-cy__rk">Starts from</p>
                <ul class="tsc-cy__rl" role="list">
                  <?php foreach ($tscpr_m[1] as $tscpr_k => $tscpr_v): ?><li style="--i:<?= $tscpr_k ?>"><?= e($tscpr_v) ?></li><?php endforeach; ?>
                </ul>
              </div>
              <div class="tsc-cy__rb">
                <p class="tsc-cy__rk">What we do</p>
                <ul class="tsc-cy__rl tsc-cy__rl--do" role="list">
                  <?php foreach ($tscpr_m[2] as $tscpr_k => $tscpr_v): ?><li style="--i:<?= $tscpr_k ?>"><span class="tsc-tick" aria-hidden="true"></span><?= e($tscpr_v) ?></li><?php endforeach; ?>
                </ul>
              </div>
              <div class="tsc-cy__rb">
                <p class="tsc-cy__rk">What you keep</p>
                <ul class="bdh-tags tsc-cy__ro" role="list">
                  <?php foreach ($tscpr_s[3] as $tscpr_o): ?><li class="bdh-tag"><?= e($tscpr_o) ?></li><?php endforeach; ?>
                </ul>
              </div>
            </div>

            <p class="tsc-cy__hand">
              <span class="tsc-cy__hk">Hands to</span>
              <span class="tsc-kbd"><?= str_pad((string) ((($tscpr_i + 1) % count($tscpr_steps)) + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <b><?= e($tscpr_m[3][0]) ?></b>
              <span class="tsc-cy__hw"><?= e($tscpr_m[3][1]) ?></span>
            </p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="tsc-cy__foot">
      <p class="tsc-cy__ft"><span class="tsc-ill">Typical shape</span><span>Timings depend on scope, estate size and how much evidence already exists. We agree them in the first week and hold to them, or we tell you early that they have changed.</span></p>
      <ul class="tsc-cy__trig" role="list" aria-label="What starts an unscheduled lap">
        <li><span class="tsc-tick" aria-hidden="true"></span>A new model, prompt or agent tool reaches production</li>
        <li><span class="tsc-tick" aria-hidden="true"></span>A new supplier or sub-processor touches personal data</li>
        <li><span class="tsc-tick" aria-hidden="true"></span>An architecture change moves a trust boundary</li>
        <li><span class="tsc-tick" aria-hidden="true"></span>A regulator, customer or auditor changes what they ask for</li>
      </ul>
    </div>
  </div>
</section>
