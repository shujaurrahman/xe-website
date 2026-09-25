<?php /* DRAFT COPY — review before launch */
/* Stages — the spine of the page and its signature component.
   The markup ships as a complete ordered list: six stages, each with everything about it, in order,
   visible. Above it sit two rails. The first is a <nav> of real in-page links, which is what a reader
   without JavaScript gets and which genuinely works. The second is a tablist carrying the correct ARIA,
   shipped with the hidden attribute so it is absent from the accessibility tree until there is
   JavaScript to implement it. assets/js/approach/stages.js swaps them: it unhides the tablist, hides
   the jump rail, marks each <li> as a tabpanel and hands the whole thing to BDH.tabs, which gives
   arrow-key, Home and End navigation. With JavaScript off, nothing is hidden and nothing is lost.
   Timeframes are typical ranges, never promises — see the note at the foot of the section. */
$aprs_first = $APR['stages'][0]['key'];
?>
<section class="band band--alt apr-stages" id="stages" aria-labelledby="stages-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The stages</p>
        <h2 class="h2" id="stages-t"><span class="g">Six stages.</span> Each one ends in a decision.</h2>
      </div>
      <div>
        <p class="lead">Every engagement runs through the same six stages, whichever discipline leads it.
          Each stage has a typical length, a named set of people on both sides, something you hold at the
          end of it, and one decision it exists to make possible.</p>
      </div>
    </div>

    <div class="apr-st" data-apr-stepper>
      <p class="bdh-sr">The six stages of a project, in order: Frame, Shape, Build, Prove, Launch, and Run
        and hand over. Each stage below lists what happens, how long it typically takes, who is involved on
        both sides, what you hold at the end of it, where agents do the legwork, and what a named person
        signs before it can close.</p>

      <!-- without JavaScript this is the navigation: six real in-page links -->
      <nav class="apr-st__jump" aria-label="Jump to a stage" data-apr-jump>
        <?php foreach ($APR['stages'] as $aprs_s): ?>
          <a href="#stage-<?= e($aprs_s['key']) ?>"><b><?= e($aprs_s['n']) ?></b><?= e($aprs_s['name']) ?></a>
        <?php endforeach; ?>
      </nav>

      <!-- with JavaScript this replaces it; hidden until stages.js implements the behaviour -->
      <div class="apr-st__rail" data-apr-tabs hidden>
        <div class="apr-st__tabs" role="tablist" aria-label="Project stages" aria-orientation="horizontal">
          <?php foreach ($APR['stages'] as $aprs_i => $aprs_s): $aprs_on = $aprs_i === 0; ?>
            <button class="apr-st__tab<?= $aprs_on ? ' is-on' : '' ?>" type="button" role="tab"
                    id="stages-t<?= $aprs_i ?>" aria-controls="stage-<?= e($aprs_s['key']) ?>"
                    aria-selected="<?= $aprs_on ? 'true' : 'false' ?>" tabindex="<?= $aprs_on ? '0' : '-1' ?>">
              <span class="apr-st__tn"><b><?= e($aprs_s['n']) ?></b><?= e($aprs_s['name']) ?></span>
              <span class="apr-st__tc"><?= e($aprs_s['clock']) ?></span>
              <span class="apr-st__tbar" aria-hidden="true"></span>
            </button>
          <?php endforeach; ?>
        </div>
        <p class="apr-st__hint">
          <span class="apr-kbd" aria-hidden="true">←</span><span class="apr-kbd" aria-hidden="true">→</span>
          move between stages
        </p>
      </div>

      <ol class="apr-st__list" data-apr-list>
        <?php foreach ($APR['stages'] as $aprs_i => $aprs_s):
                $aprs_gate = $aprs_s['gate'] !== '' ? $APR['gates'][$aprs_s['gate']] : null; ?>
          <li class="apr-st__item" id="stage-<?= e($aprs_s['key']) ?>" data-apr-pane data-stage="<?= $aprs_i ?>">
            <div class="apr-st__head">
              <span class="apr-st__ico" aria-hidden="true"><?= xt_icon($aprs_s['icon'], ['size' => 24]) ?></span>
              <p class="apr-st__no"><span class="bdh-idx">Stage <?= e($aprs_s['n']) ?></span><span class="apr-st__of">of <?= count($APR['stages']) ?></span></p>
              <h3 class="apr-st__name"><?= e($aprs_s['name']) ?></h3>
              <p class="apr-st__clock"><?= xt_icon('clock', ['size' => 14, 'mono' => true]) ?><?= e($aprs_s['clock']) ?></p>
              <p class="apr-st__line"><?= e($aprs_s['line']) ?></p>
            </div>

            <div class="apr-st__body">
              <div class="apr-st__col apr-st__col--h">
                <p class="apr-k">What happens</p>
                <ul class="bdh-bullets">
                  <?php foreach ($aprs_s['happens'] as $aprs_v): ?><li><?= e($aprs_v) ?></li><?php endforeach; ?>
                </ul>
              </div>

              <div class="apr-st__col">
                <p class="apr-k">What you hold at the end</p>
                <ul class="apr-st__gets">
                  <?php foreach ($aprs_s['gets'] as $aprs_v): ?>
                    <li><span class="apr-tick" aria-hidden="true">✓</span><?= e($aprs_v) ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>

              <div class="apr-st__col apr-st__col--who">
                <p class="apr-k">In the room</p>
                <p class="apr-whos">
                  <?php foreach ($aprs_s['ours'] as $aprs_v): ?><span class="apr-who is-ours"><?= e($aprs_v) ?></span><?php endforeach; ?>
                  <?php foreach ($aprs_s['yours'] as $aprs_v): ?><span class="apr-who is-yours"><?= e($aprs_v) ?></span><?php endforeach; ?>
                </p>
                <p class="apr-st__key"><span><i class="is-ours" aria-hidden="true"></i>Our people</span><span><i class="is-yours" aria-hidden="true"></i>Yours</span></p>
              </div>

              <div class="apr-st__col apr-st__col--ai">
                <p class="apr-k"><?= xt_icon('agent', ['size' => 14, 'mono' => true]) ?> Where agents do the legwork</p>
                <ul class="apr-st__ai">
                  <?php foreach ($aprs_s['agents'] as $aprs_v): ?><li><?= e($aprs_v) ?></li><?php endforeach; ?>
                </ul>
              </div>
            </div>

            <div class="apr-st__foot">
              <p class="apr-st__unlock">
                <span class="apr-k">The decision it unlocks</span>
                <span><?= e($aprs_s['unlocks']) ?></span>
              </p>
              <p class="apr-st__sign">
                <span class="apr-k"><?= xt_icon('approve', ['size' => 14, 'mono' => true]) ?> A person signs</span>
                <span><?= e($aprs_s['signs']) ?></span>
              </p>
              <?php if ($aprs_gate): ?>
                <p class="apr-st__gate">
                  <a class="apr-gate" href="#gate-<?= e($aprs_s['gate']) ?>"><b><?= e($aprs_gate['n']) ?></b><?= e($aprs_gate['name']) ?></a>
                  <span class="apr-note">This stage closes at a gate. <?= e($aprs_gate['signs']) ?> signs it.</span>
                </p>
              <?php else: ?>
                <p class="apr-st__gate">
                  <span class="bdh-ill">No gate</span>
                  <span class="apr-note">Launch runs inside the go-live decision taken at the end of Prove.</span>
                </p>
              <?php endif; ?>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <!-- PLACEHOLDER: confirm typical stage lengths and team make-up before launch -->
    <p class="apr-note apr-stages__foot" data-rv>
      <b>Every timeframe on this page is typical, not promised.</b> A brand sprint compresses Frame and
      Shape into days; a regulated platform programme runs longer at every stage, and
      <a class="apr-lk" href="<?= xe_url('services/technology-intelligence.php') ?>#delivery">the programme plan on the Technology &amp; Intelligence page</a>
      shows that longer shape in full. Your dates come out of Frame, in writing, before anything is built.
    </p>
  </div>
</section>
