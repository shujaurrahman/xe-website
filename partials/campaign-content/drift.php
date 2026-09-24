<?php /* DRAFT COPY — review before launch */ ?>
<?php
$cch_rows = [   // [stage, what usually happens, what we do instead]
    ['The idea',       'Written as a tagline in a deck, then reinterpreted by every team that picks it up.', 'Written as a platform: an insight, a tension, a line and the rules for extending it — so a stranger could brief the fortieth execution.'],
    ['The formats',    'The hero film is made first. Everything else is cut down from it at the end, in a hurry.', 'The kit of parts is designed for the smallest frame first, so a 9:16 story and a 300 × 250 banner carry the idea as clearly as the film.'],
    ['The channels',   'Each channel is planned by a different team, on a different calendar, against a different number.', 'One flighting plan with shared audiences, sequencing and frequency, and one owner per channel who reports to it.'],
    ['The measurement','Reported on what was easy to count: impressions, clicks, platform-attributed conversions.', 'Agreed before launch: what would change, how we would know, and a holdout or lift study that shows what the campaign caused.'],
];
?>
<section class="band band--alt cch-drift" id="drift" aria-labelledby="drift-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Where campaigns lose the idea</p>
        <h2 class="h2" id="drift-t"><span class="g">Most ideas do not fail.</span> They fade on the way to the channel.</h2></div>
      <div><p class="lead">A campaign passes through four hands between the pitch and the feed. Each one is a chance to dilute it. We design each hand-off so the idea arrives intact.</p></div>
    </div>
    <div class="cch-drift__t" role="table" aria-label="How a campaign loses its idea, and what we do instead">
      <div class="cch-drift__h" role="row">
        <span role="columnheader">Stage</span><span role="columnheader">The usual hand-off</span><span role="columnheader">Designed as a system</span>
      </div>
      <?php foreach ($cch_rows as $cch_i => $cch_r): ?>
      <div class="cch-drift__r" role="row" data-rv>
        <span class="cch-drift__s" role="rowheader"><span class="bdh-idx"><?= sprintf('%02d', $cch_i + 1) ?></span><?= e($cch_r[0]) ?></span>
        <span class="cch-drift__was" role="cell"><span class="cch-drift__k">Usual</span><span class="cch-drift__fade" aria-hidden="true"><i style="--o:<?= 1 - $cch_i * .22 ?>"></i></span><?= e($cch_r[1]) ?></span>
        <span class="cch-drift__now" role="cell"><span class="cch-drift__k">System</span><?= e($cch_r[2]) ?></span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
