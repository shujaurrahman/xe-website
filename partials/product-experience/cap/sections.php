<?php /* DRAFT COPY — review before launch */
/* The data-driven middle of every capability page: offer · process · deliver · outcomes · stack · standards.
   Markup reuses the hub's idioms (.pxh-card, .pxh-steps, .pxh-man, .pxh-db, .pxh-stack, .pxh-standards). */
$pxd_steps = $CAP['process']['steps'];
$pxd_deliv = $CAP['deliver'];
?>
<section class="band band--alt pxd-offer" id="offer" aria-labelledby="offer-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>What it covers</p>
        <h2 class="h2" id="offer-t"><?= $CAP['offer_title'] ?></h2></div>
      <div><p class="lead"><?= e($CAP['offer_lead']) ?></p></div>
    </div>
    <div class="pxh-cards pxd-offer__cards" data-bdh-stagger>
      <?php foreach ($CAP['offer'] as $pxd_i => $pxd_o): ?>
      <article class="pxh-card pxd-offer__card" aria-labelledby="offer-<?= $pxd_i ?>-t">
        <div class="pxh-card__top">
          <span class="pxh-card__idx"><?= str_pad((string) ($pxd_i + 1), 2, '0', STR_PAD_LEFT) ?> / <?= str_pad((string) count($CAP['offer']), 2, '0', STR_PAD_LEFT) ?></span>
          <span class="pxh-card__ico"><?= xt_icon($pxd_o[3]) ?></span>
        </div>
        <h3 class="pxh-card__t" id="offer-<?= $pxd_i ?>-t"><?= e($pxd_o[0]) ?></h3>
        <p class="pxh-card__d"><?= e($pxd_o[1]) ?></p>
        <div class="pxh-card__foot"><span class="pxd-tag"><?= e($pxd_o[2]) ?></span></div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="band pxd-process" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>How it runs</p>
        <h2 class="h2" id="process-t"><?= $CAP['process']['title'] ?></h2></div>
      <div><p class="lead"><?= e($CAP['process']['lead']) ?></p></div>
    </div>
    <!-- PLACEHOLDER: confirm typical stage timings before launch -->
    <ol class="pxh-steps pxd-steps" data-bdh-stagger>
      <?php foreach ($pxd_steps as $pxd_i => $pxd_s): ?>
      <li class="pxh-steps__i<?= $pxd_i === count($pxd_steps) - 2 ? ' is-key' : '' ?>">
        <span class="pxh-steps__n" aria-hidden="true">0<?= $pxd_i + 1 ?></span>
        <div class="pxh-steps__b">
          <h3 class="pxh-steps__t"><?= e($pxd_s[0]) ?> <small><?= e($pxd_s[1]) ?></small></h3>
          <p class="pxh-steps__d"><?= e($pxd_s[2]) ?></p>
          <ul class="pxh-steps__out" aria-label="Outputs"><?php foreach ($pxd_s[3] as $pxd_o): ?><li><?= e($pxd_o) ?></li><?php endforeach; ?></ul>
          <?php if (!empty($PXD_X['gates'][$pxd_i])): ?><p class="pxh-steps__gate">Gate · <?= e($PXD_X['gates'][$pxd_i]) ?></p><?php endif; ?>
        </div>
      </li>
      <?php endforeach; ?>
    </ol>
    <p class="pxh-note">Timings are typical and shorten when the evidence already exists.</p>
  </div>
</section>

<section class="band band--alt pxd-deliver" id="deliverables" aria-labelledby="deliverables-t">
  <div class="wrap">
    <div class="bdh-grid">
      <div class="bdh-c4">
        <div class="bdh-sticky bdh-head" data-rv>
          <p class="lbl lbl--blue"><span class="dot"></span>What you keep</p>
          <h2 class="h2" id="deliverables-t"><span class="g"><?= count($pxd_deliv) ?> working files.</span> Yours from day one.</h2>
          <p class="lead">Everything is handed over in the tools your teams already use, with the evidence and decisions that produced it.</p>
        </div>
      </div>
      <div class="bdh-c7 bdh-s6 pxh-man pxd-deliver__man" data-bdh-stagger>
        <div class="pxh-man__f">
          <p class="pxh-man__path"><?= xt_icon('layers') ?>/handover/<?= e($CAP['n']) ?>-<?= e(strtolower(str_replace(' ', '-', $CAP['short']))) ?>/</p>
          <h3 class="pxh-man__t"><?= e($CAP['name']) ?></h3>
          <ul class="pxh-man__list">
            <?php foreach ($pxd_deliv as $pxd_d): ?><li><span><?= e($pxd_d[0]) ?></span><em><?= e($pxd_d[1]) ?></em></li><?php endforeach; ?>
          </ul>
        </div>
        <div class="pxh-man__f pxh-man__f--all">
          <p class="pxh-man__path"><?= xt_icon('check') ?>/handover/README</p>
          <h3 class="pxh-man__t">In every handover</h3>
          <ul class="pxh-man__list">
            <li><span>Decision record, with evidence links</span><em>Doc</em></li>
            <li><span>Assumption tracker, final states</span><em>Sheet</em></li>
            <li><span>Research consent &amp; retention log</span><em>Sheet</em></li>
            <li><span>Walkthrough session, recorded</span><em>Video</em></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="band pxh-outcomes pxd-outcomes" id="outcomes" aria-labelledby="outcomes-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>What changes</p>
        <h2 class="h2" id="outcomes-t"><span class="g">Three outcomes.</span> Each with the measure that proves it.</h2></div>
      <div><p class="lead">The baseline, the target and the instrument are agreed in the first week, and the same instrument is used afterwards so the comparison is honest.</p></div>
    </div>
    <div class="bdh-grid">
      <ol class="bdh-c5 pxd-outcomes__list">
        <?php foreach ($CAP['outcomes'] as $pxd_i => $pxd_o): ?>
        <li class="pxh-card pxd-outcomes__card">
          <span class="pxh-card__idx">Outcome 0<?= $pxd_i + 1 ?></span>
          <h3 class="pxh-card__t"><?= e($pxd_o[0]) ?></h3>
          <p class="pxh-card__d"><?= e($pxd_o[1]) ?></p>
        </li>
        <?php endforeach; ?>
      </ol>
      <figure class="bdh-c7 bdh-s6 pxh-outcomes__fig">
        <div class="pxh-win">
          <div class="pxh-win__bar"><span class="dots3" aria-hidden="true"><i></i><i></i><i></i></span>Outcome review · Your company<span class="sp">Illustrative</span></div>
          <div class="pxh-outcomes__body">
            <ul class="pxh-db">
              <?php foreach ($PXD_X['measures'] as $pxd_i => $pxd_m): ?>
              <li class="pxh-db__row" style="--a:<?= (int) $pxd_m[2] ?>%;--b:<?= (int) $pxd_m[3] ?>%;--t:<?= (int) $pxd_m[4] ?>%">
                <div class="pxh-db__k"><b><span class="pxd-db__n">0<?= $pxd_i + 1 ?></span> <?= e($pxd_m[0]) ?></b><span><?= e($pxd_m[1]) ?></span></div>
                <div class="pxh-db__track" aria-hidden="true"><span class="pxh-db__seg"></span><span class="pxh-db__tgt"></span><span class="pxh-db__dot pxh-db__dot--a"></span><span class="pxh-db__dot pxh-db__dot--b"></span></div>
                <div class="pxh-db__v"><?= $pxd_m[3] . $pxd_m[5] ?><small>from <?= $pxd_m[2] . $pxd_m[5] ?></small><small>target <?= $pxd_m[4] . $pxd_m[5] ?></small></div>
              </li>
              <?php endforeach; ?>
            </ul>
            <div class="pxh-db__legend" aria-hidden="true"><span><i class="a"></i>Baseline</span><span><i class="b"></i>After</span><span><i class="t"></i>Agreed target</span></div>
          </div>
        </div>
        <figcaption class="pxh-note">Scale 0–100 on every row; row numbers match the outcomes. Figures are illustrative examples of the measures we set, not client results.</figcaption>
      </figure>
    </div>
  </div>
</section>

<section class="band band--alt pxd-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>The stack</p>
        <h2 class="h2" id="stack-t"><span class="g">The tools this runs on.</span> Usually yours already.</h2></div>
      <div><p class="lead">Technologies we work with most for <?= e(strtolower($CAP['short'])) ?> work, most relevant first. We work in your accounts and hand everything over in them.</p></div>
    </div>
    <?= xt_stack($CAP['stack'], ['variant' => 'tiles', 'label' => $CAP['name'] . ' technologies']) ?>
  </div>
</section>

<section class="band pxh-standards pxd-standards" id="standards" aria-labelledby="standards-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Frameworks we build to</p>
        <h2 class="h2" id="standards-t"><span class="g">A standard is a test.</span> Here is where each one runs.</h2></div>
      <div><p class="lead">These are frameworks this work is built to or aligned with. They are not certifications we hold; each is a set of checks with a place in the process.</p></div>
    </div>
    <ul class="pxh-standards__list">
      <?php foreach ($CAP['standards'] as $pxd_k): $pxd_st = xt_standard($pxd_k); if (!$pxd_st) continue; ?>
      <li class="pxh-standards__r" data-rv>
        <div class="pxh-standards__b"><?= xt_badge($pxd_k) ?></div>
        <p class="pxh-standards__d"><?= e($pxd_st['covers']) ?></p>
        <p class="pxh-standards__w"><span class="pxh-mono">How we apply it</span><?= e($pxd_st['apply']) ?></p>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
