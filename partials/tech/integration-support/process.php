<?php /* DRAFT COPY — review before launch */
/* Process — the four phases drawn as one transit line, which is the page's governing idea: Map,
   Connect, Transition, Support. Content comes from $CAP['process'] so the hub and this page never
   drift. Each station is a block on the line and a tab; process.js moves the service car along the
   line, fills the line behind it and marks the stations already called at. Without JS the first
   panel is visible, every station is a link to it and the line reads as four stations in order.
   The board beside each phase carries what it leaves behind, who is on the line and where the
   phase usually slips, so both halves of the band carry weight. Timings are PLACEHOLDER. */
$tis_pr    = $CAP['process'];
$tis_pr_st = $tis_pr['steps'];
$tis_pr_no = count($tis_pr_st);
/* per phase: [what we need from you, the question this phase settles, what clears the station,
   who is on the line, where this phase usually slips]. The technologies are drawn once on this
   page, in #catalogue and #support; repeating a logo strip in every phase panel would add weight
   and say nothing the reader has not already seen. */
$tis_pr_ex = [
    ['Access to the systems in scope, and the person who owns each one.',
     'Which flows matter, and who decides when they disagree.',
     'Every flow in scope has one named owner on your side and an agreed pattern on ours, written down and signed off.',
     ['Integration architect', 'Your system owners', 'Delivery lead'],
     'Ownership. Two teams each believe they hold the customer record, and no flow can be built until one of them decides which copy is the truth.'],
    ['A sandbox or test tenant per system, and sample data with the awkward records in it.',
     'How each flow behaves when the other side is slow, down or wrong.',
     'Each flow passes its contract tests against the vendor sandbox, and survives a deliberate failure with no data lost.',
     ['Integration engineers', 'Your platform team', 'QA'],
     'Sandboxes. A vendor test tenant that behaves differently from production is worse than none, so every flow is also replayed against recorded production traffic.'],
    ['An hour from whoever will take the call, and your alerting destinations.',
     'Who is paged, what they read first, and what they are allowed to do.',
     'Your team and ours run one rehearsed incident end to end, against the real runbook and the real alert.',
     ['Site reliability engineer', 'Your on-call rota', 'Service manager'],
     'The rota. An alert that pages a shared mailbox is not on-call. This station does not clear until a named person is on the other end of it.'],
    ['A monthly half hour for the service review.',
     'What we change next, and what it is worth changing.',
     'Nothing: this station does not close. It is reviewed every month against the same measures.',
     ['Named incident lead', 'Service manager', 'Your product owner'],
     'Silence. An estate that reports no incidents for a quarter usually has monitoring that is not looking, rather than an estate that is not failing.'],
];
?>
<section class="band band--alt tis-pr" id="process" aria-labelledby="process-t">
  <div class="wrap">

    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tis-kick"><b>$ run phase --next</b> <span>4 stations · support starts at station three, not after it</span></p>
        <h2 class="h2" id="process-t"><span class="g">Map, connect,</span> harden, run.</h2>
      </div>
      <div>
        <p class="lead"><?= e($tis_pr['lead']) ?></p>
        <p class="tis-ill">Indicative phase lengths</p>
      </div>
    </div>

    <div class="tis-pr__line" data-rv data-tis-pr style="--tis-train:0">

      <div class="tis-pr__rail">
        <div class="tis-pr__track" aria-hidden="true">
          <span class="tis-pr__wire"></span>
          <span class="tis-pr__done"></span>
          <span class="tis-pr__car"><?= xt_icon('plug', ['size' => 14, 'mono' => true]) ?></span>
        </div>
        <div class="bdh-tabs tis-pr__stns" role="tablist" aria-label="Integration and support phases">
          <?php foreach ($tis_pr_st as $tis_pr_i => $tis_pr_s): ?>
            <button type="button" role="tab" class="tis-pr__stn<?= $tis_pr_i === 0 ? ' is-here' : '' ?>"
                    id="process-t<?= (int) $tis_pr_i ?>" aria-controls="process-p<?= (int) $tis_pr_i ?>"
                    aria-selected="<?= $tis_pr_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $tis_pr_i === 0 ? '0' : '-1' ?>">
              <span class="tis-pr__mark" aria-hidden="true"><span class="tis-stn<?= $tis_pr_i === 0 ? ' tis-stn--hub' : '' ?>"></span></span>
              <span class="tis-pr__stnt">
                <span class="tis-pr__stni"><?= e(str_pad((string) ($tis_pr_i + 1), 2, '0', STR_PAD_LEFT)) ?></span>
                <span class="tis-pr__stnn"><?= e($tis_pr_s[0]) ?></span>
                <span class="tis-pr__stnw"><?= e($tis_pr_s[1]) ?></span>
              </span>
              <span class="tis-pr__stnc" aria-hidden="true"><?= count($tis_pr_s[3]) ?> artefacts</span>
            </button>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="bdh-panes tis-pr__panes">
        <?php foreach ($tis_pr_st as $tis_pr_i => $tis_pr_s): $tis_pr_e = $tis_pr_ex[$tis_pr_i] ?? null; ?>
          <div class="bdh-pane tis-pr__pane<?= $tis_pr_i === 0 ? ' is-on' : '' ?>" id="process-p<?= (int) $tis_pr_i ?>"
               role="tabpanel" aria-labelledby="process-t<?= (int) $tis_pr_i ?>" tabindex="0">
            <div class="tis-pr__grid">

              <div class="tis-pr__main">
                <p class="tis-pr__ph">
                  <span class="bdh-idx">Phase <?= e(str_pad((string) ($tis_pr_i + 1), 2, '0', STR_PAD_LEFT)) ?> / <?= e(str_pad((string) $tis_pr_no, 2, '0', STR_PAD_LEFT)) ?></span>
                  <!-- PLACEHOLDER: confirm the phase timings quoted here before launch -->
                  <span class="tis-pr__pw"><?= e($tis_pr_s[1]) ?></span>
                </p>
                <h3 class="h3 tis-pr__pt"><?= e($tis_pr_s[0]) ?></h3>
                <p class="tis-pr__pd"><?= e($tis_pr_s[2]) ?></p>
                <?php if ($tis_pr_e): ?>
                  <dl class="tis-pr__qs">
                    <div>
                      <dt>What this phase settles</dt>
                      <dd><?= e($tis_pr_e[1]) ?></dd>
                    </div>
                    <div>
                      <dt>What we need from you</dt>
                      <dd><?= e($tis_pr_e[0]) ?></dd>
                    </div>
                  </dl>
                  <div class="tis-pr__gate">
                    <span class="tis-pr__gatei" aria-hidden="true"><?= xt_icon('flag', ['size' => 18]) ?></span>
                    <div>
                      <p class="tis-pr__gatek">The station clears when</p>
                      <p class="tis-pr__gatev"><?= e($tis_pr_e[2]) ?></p>
                    </div>
                  </div>
                <?php endif; ?>
              </div>

              <div class="tis-pr__out">
                <div class="tis-pr__outh">
                  <p class="tis-pr__outk">Leaves behind</p>
                  <span class="tis-pr__outn"><?= count($tis_pr_s[3]) ?></span>
                </div>
                <ul class="bdh-list" role="list">
                  <?php foreach ($tis_pr_s[3] as $tis_pr_o): ?>
                    <li><?= e($tis_pr_o) ?><small><?= xt_icon('check', ['size' => 14, 'mono' => true]) ?></small></li>
                  <?php endforeach; ?>
                </ul>
                <?php if ($tis_pr_e): ?>
                  <div class="tis-pr__seg">
                    <p class="tis-pr__segk">On the line at this phase</p>
                    <ul class="tis-pr__who" role="list">
                      <?php foreach ($tis_pr_e[3] as $tis_pr_w): ?>
                        <li><span class="tis-stn" aria-hidden="true"></span><?= e($tis_pr_w) ?></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                  <div class="tis-pr__seg">
                    <p class="tis-pr__segk">Where this phase usually slips</p>
                    <p class="tis-pr__risk"><?= e($tis_pr_e[4]) ?></p>
                  </div>
                <?php endif; ?>
              </div>

            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="tis-pr__nav">
        <button type="button" class="tis-btn" data-tis-prev>
          <span aria-hidden="true">&larr;</span> Previous station
        </button>
        <button type="button" class="tis-btn tis-btn--blue" data-tis-next>
          Next station <span aria-hidden="true">&rarr;</span>
        </button>
        <p class="tis-pr__navn">Support is station three, not a hand-off after station four. The team that built the flow is the team that answers the alert.</p>
      </div>
    </div>

    <p class="bdh-sr">The four phases in order: <?php foreach ($tis_pr_st as $tis_pr_i => $tis_pr_s) { echo e($tis_pr_s[0]) . ' (' . e($tis_pr_s[1]) . ')' . ($tis_pr_i < $tis_pr_no - 1 ? ', ' : '.'); } ?> Each panel below the line lists what that phase settles, what it needs from you, what clears the station, what it leaves behind, who is involved and where the phase usually slips.</p>
  </div>
</section>
