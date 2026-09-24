<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* 04 — why the layer matters, shown as a mechanism: a chart of starting over vs compounding, and a
   12-week ledger in which each outcome lane hands something to the next. Illustrative programme, not a result. */
$s04_lanes = [
  ['k' => 'Differentiation', 't' => 'Real differentiation', 'd' => 'Brand Design',
   'w' => ['Voice rules and design tokens written once, as data', 'Rules applied across the first 40 assets; drift flagged, not fixed by hand', 'An on-brand check runs before human review, on every asset', 'A new market launches from the same rules, in its own language'],
   'f' => 'Hands product a shared vocabulary of components and words.'],
  ['k' => 'Customer value', 't' => 'Real customer value', 'd' => 'Product &amp; Experience',
   'w' => ['Journey evidence: interviews, support logs and search queries tagged', 'The two costliest moments redesigned from the brand system’s components', 'Changes ship behind flags; task success is measured before and after', 'The journey model becomes the brief for every campaign'],
   'f' => 'Hands campaigns the moments that matter and proof of what works.'],
  ['k' => 'Growth', 't' => 'Real growth', 'd' => 'Campaign &amp; Marketing Technology',
   'w' => ['Baseline read and a written test plan, one hypothesis per cell', 'First creative tests read; losers retired inside the week', 'Spend follows what is working this week, with a human approving shifts', 'What won is written back into the brand rules and the journey model'],
   'f' => 'Hands the brand evidence — and the loop starts again, one step ahead.'],
];
$s04_weeks = ['Week 1', 'Week 4', 'Week 8', 'Week 12'];
?>
<section class="band band--rules s04" id="pillars" aria-labelledby="s04-t">
  <div class="wrap">
    <div class="head head--row s04__head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Why the layer matters</p>
        <h2 class="h2" id="s04-t"><span class="g">Win on what compounds.</span> Every week starts where the last one ended.</h2>
      </div>
      <p class="lead">Because brand, product and growth feed the same layer, each one hands the next something it can use. The work gets sharper every week instead of starting over each quarter.</p>
    </div>

    <div class="s04__grid">
      <figure class="s04__chart" data-rv>
        <figcaption class="s04__cap"><span>Value the work keeps</span><em>Illustrative · 12 weeks</em></figcaption>
        <svg class="s04__svg" viewBox="0 0 320 200" aria-hidden="true" focusable="false">
          <g class="s04__gridl"><path d="M24 20H312M24 70H312M24 120H312M24 170H312"/></g>
          <path class="s04__saw" d="M24 170 L92 128 L92 162 L160 120 L160 156 L228 116 L228 152 L296 112"/>
          <path class="s04__comp" d="M24 170 C 90 160, 150 128, 200 92 S 280 30, 296 24"/>
          <circle class="s04__end" cx="296" cy="24" r="4.5"/>
          <g class="s04__ax"><text x="24" y="192">W1</text><text x="92" y="192">W4</text><text x="160" y="192">W8</text><text x="228" y="192">W10</text><text x="296" y="192" text-anchor="end">W12</text></g>
        </svg>
        <ul class="s04__key">
          <li><i class="s04__k s04__k--c" aria-hidden="true"></i>One layer: each lane builds on the others</li>
          <li><i class="s04__k s04__k--s" aria-hidden="true"></i>Separate teams: each quarter re-briefs from zero</li>
        </ul>
        <p class="bdh-sr">An illustrative chart. A line for work on one shared layer rises steadily over twelve weeks; a saw-tooth line for separate teams climbs and falls back at every hand-over, ending far lower.</p>
      </figure>

      <div class="s04__ledger" data-rv data-rv-d="90">
        <p class="s04__lh" aria-hidden="true"><span>Outcome</span><?php foreach ($s04_weeks as $s04_w): ?><span><?= $s04_w ?></span><?php endforeach; ?></p>
<?php foreach ($s04_lanes as $s04_n => $s04_l): ?>
        <article class="s04__lane" aria-labelledby="s04-l<?= $s04_n ?>">
          <div class="s04__who">
            <span class="s04__idx"><?= sprintf('%02d', $s04_n + 1) ?></span>
            <h3 class="s04__t" id="s04-l<?= $s04_n ?>"><?= $s04_l['t'] ?></h3>
            <span class="s04__d"><?= $s04_l['d'] ?></span>
          </div>
          <ol class="s04__steps">
<?php foreach ($s04_l['w'] as $s04_i => $s04_s): ?>
            <li class="s04__st"><b><?= $s04_weeks[$s04_i] ?></b><?= $s04_s ?></li>
<?php endforeach; ?>
          </ol>
          <p class="s04__feed"><span class="s04__arr" aria-hidden="true">↳</span><?= $s04_l['f'] ?></p>
        </article>
<?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
