<?php /* DRAFT COPY — review before launch */
/* Measure — how an outcome gets published. The measurement contract is agreed in writing before the work
   starts, which is the only way a number on this page can mean anything afterwards. The panel below is the
   contract as a form, and the right column is what will not be published whatever the number says. */
$wkm_contract = [
    ['target',  'The measure',   'One number the work is judged on, chosen with the client before delivery starts. Not a dashboard of twenty.', 'Agreed in the statement of work'],
    ['chart',   'The baseline',  'What that number reads today, captured before we change anything, from the client\'s own system.', 'Captured in the first week'],
    ['clock',   'The window',    'The period the comparison runs over, long enough to survive a good week and a bad one.', 'Fixed before launch'],
    ['approve', 'The verifier',  'Whose system the reading comes from. Ours is instrumentation; theirs is evidence.', 'Named in writing'],
];
$wkm_never = [
    ['A percentage with no baseline', 'A lift is meaningless without the number it lifted from.'],
    ['A result with no window',       'Any metric can be made to look good over the right fortnight.'],
    ['A projection printed as a result', 'A model of what should happen is not what happened.'],
    ['A figure from our own dashboard alone', 'If the client\'s system cannot see it, it is not published.'],
    ['A client\'s confidential number',  'Commercially sensitive figures stay in the room, whatever they say about us.'],
];
$wkm_steps = [
    ['Before', 'The measure, baseline, window and verifier are written into the statement of work.'],
    ['During', 'Instrumentation goes in with the build, so the baseline is not reconstructed later.'],
    ['After',  'The reading is taken from the client\'s system at the end of the window, and reviewed with them.'],
    ['Then',   'Only what the client approves in writing appears in the record.'],
];
?>
<section class="band wk-measure" id="measure" aria-labelledby="measure-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Evidence</p>
        <h2 class="h2" id="measure-t"><span class="g">A number is only a result</span> if you can check it.</h2>
      </div>
      <div>
        <p class="lead">Every engagement agrees four things in writing before delivery starts. Those four
          are what turns a figure into evidence, and they are why the records above carry their baseline
          and their source rather than a headline percentage.</p>
      </div>
    </div>

    <div class="wk-measure__grid">
      <div class="wk-measure__panel" data-rv>
        <div class="bdh-ui wk-measure__ui">
          <p class="bdh-ui__bar">
            <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
            <span class="wk-measure__title">measurement contract <i aria-hidden="true">/</i> agreed before delivery</span>
            <span class="wk-measure__stamp">4 fields · all required</span>
          </p>
          <ol class="wk-measure__fields">
            <?php foreach ($wkm_contract as $wkm_i => $wkm_f): ?>
              <li>
                <span class="wk-measure__fi" aria-hidden="true"><?= xt_icon($wkm_f[0], ['size' => 18]) ?></span>
                <span class="wk-measure__fn"><b><?= str_pad((string) ($wkm_i + 1), 2, '0', STR_PAD_LEFT) ?></b><?= e($wkm_f[1]) ?></span>
                <span class="wk-measure__fd"><?= e($wkm_f[2]) ?></span>
                <span class="wk-measure__fw"><?= e($wkm_f[3]) ?></span>
              </li>
            <?php endforeach; ?>
          </ol>
        </div>

        <ol class="wk-measure__steps">
          <?php foreach ($wkm_steps as $wkm_s): ?>
            <li><span class="wk-k"><?= e($wkm_s[0]) ?></span><span><?= e($wkm_s[1]) ?></span></li>
          <?php endforeach; ?>
        </ol>
      </div>

      <div class="wk-measure__side" data-rv data-rv-d="90">
        <p class="wk-k">What will not be published</p>
        <ul class="wk-measure__never">
          <?php foreach ($wkm_never as $wkm_n): ?>
            <li>
              <span class="wk-measure__x" aria-hidden="true">&times;</span>
              <h3 class="bdh-t bdh-t--s"><?= e($wkm_n[0]) ?></h3>
              <p class="bdh-d"><?= e($wkm_n[1]) ?></p>
            </li>
          <?php endforeach; ?>
        </ul>
        <p class="wk-note">This is why several records above say <em>no figure published</em>. The
          measurement is running; the reading is not ours to announce.</p>
      </div>
    </div>
  </div>
</section>
