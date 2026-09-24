<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Stepper (.cch-steps). Timings are typical for a launch campaign. */
$cch_steps = [   // [name, timing, description, outputs]
    ['Discover', 'Wk 01–02', 'Business goal, audience evidence, category conventions and what has worked before. We agree the measure before any creative starts.', ['Campaign brief', 'Measurement plan', 'Audience map']],
    ['Idea',     'Wk 02–04', 'Two or three routes, each written as a platform and tested in rough form with real people. One is chosen on evidence.', ['Campaign platform', 'Route testing', 'Key message']],
    ['System',   'Wk 04–06', 'The chosen idea built into a kit of parts: key visual, headline system, templates and channel rules.', ['Key visual', 'Campaign toolkit', 'Templates']],
    ['Produce',  'Wk 05–09', 'One production planned to yield a season of assets, then every channel cut made, checked and approved.', ['Hero content', 'Channel cut-downs', 'Asset library']],
    ['Flight & learn', 'Wk 09 →', 'Launch, weekly optimisation, a mid-flight read and a final incrementality result that feeds the next brief.', ['Flighting plan', 'Live dashboard', 'Results & learnings']],
];
?>
<section class="band cch-process" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>How a campaign runs</p>
        <h2 class="h2" id="process-t"><span class="g">Nine weeks to launch,</span> then a result that writes the next brief.</h2></div>
      <div><!-- PLACEHOLDER: confirm typical timeline before launch --><p class="lead">A typical launch campaign. Always-on programmes use the same five stages on a monthly rhythm. Stages overlap on purpose: production starts while the system is still being finished.</p></div>
    </div>
    <ol class="cch-steps">
      <?php foreach ($cch_steps as $cch_i => $cch_s): ?>
      <li class="cch-steps__i" data-rv>
        <span class="cch-steps__n"><?= sprintf('%02d', $cch_i + 1) ?></span>
        <p class="cch-steps__w bdh-ro"><?= e($cch_s[1]) ?></p>
        <h3 class="h3 cch-steps__t"><?= e($cch_s[0]) ?></h3>
        <p class="sm cch-steps__d"><?= e($cch_s[2]) ?></p>
        <ul class="cch-steps__o"><?php foreach ($cch_s[3] as $cch_o): ?><li><?= e($cch_o) ?></li><?php endforeach; ?></ul>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
