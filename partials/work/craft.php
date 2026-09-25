<?php /* DRAFT COPY — review before launch */
/* Craft — the detail strip. Ten plates of the surfaces a programme actually lands on, in a
   horizontal scroller that works with the keyboard and with JavaScript off (native overflow scroll,
   scroll-snap, .bdh-scroll-x.mask-x with a role and a label). craft.js only adds the arrows. */
$wrk_strip = [
    ['d-letterpress.jpg', 'Metal letterpress type arranged in a composing stick', 1400, 933,  'Specimen',   'The type scale, proved at size before it is written down'],
    ['d-stationery.jpg',  'Plain stationery laid out on a neutral surface',       1200, 800,  'Stationery', 'The smallest surface the system has to survive'],
    ['d-box.jpg',         'A plain cardboard carton against a pale background',    1200, 800,  'Pack',       'Pack geometry: the grid every market inherits'],
    ['d-cup.jpg',         'An unbranded takeaway cup on a table beside a resting hand', 1200, 800, 'In hand',  'Where a logo meets a thumb, a fold and a lid'],
    ['d-app.jpg',         'A phone held in one hand, its screen blank and lit',    1200, 1011, 'Screen',     'The same tokens, compiled for a product'],
    ['d-wayfinding.jpg',  'A blank overhead display panel in a public concourse',  1600, 1066, 'Wayfinding', 'Type that has to be read at ten metres and at one'],
    ['d-billboard.jpg',   'A large blank billboard frame against a clear sky',     1200, 1200, 'Out of home','One key visual, re-cut by rule rather than by hand'],
    ['d-van.jpg',         'A plain white van parked on a city street',             1200, 675,  'Vehicle',    'The surface nobody designs for, and everybody sees'],
    ['d-apron.jpg',       'A shop worker in a plain apron opening a shutter at the start of the day', 1200, 800, 'Uniform', 'Worn every day, washed every week, still on-brand'],
    ['d-tote.jpg',        'A person holding a plain canvas tote bag against a concrete wall', 1200, 800, 'Merch', 'The asset that outlives the campaign that made it'],
];
?>
<section class="band band--alt wrk-craft" id="craft" aria-labelledby="craft-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The detail</p>
        <h2 class="h2" id="craft-t"><span class="g">A system is only real</span> where it lands.</h2>
      </div>
      <div>
        <p class="lead">Guidelines are easy to agree and hard to keep. These are the surfaces that decide whether a system held: the ones made at speed, in volume, by people who were not in the room when it was designed.</p>
        <div class="wrk-craft__ctl">
          <button class="wrk-craft__arw" type="button" data-wrk-prev aria-label="Scroll the detail strip left" hidden><span aria-hidden="true">‹</span></button>
          <button class="wrk-craft__arw" type="button" data-wrk-next aria-label="Scroll the detail strip right" hidden><span aria-hidden="true">›</span></button>
        </div>
      </div>
    </div>
  </div>

  <!-- PLACEHOLDER: reference plates (assets/imgs/work/CREDITS.md) — replace with photography of our own delivered artefacts -->
  <div class="wrk-craft__rail bdh-scroll-x" tabindex="0" role="region" aria-label="Detail strip — ten surfaces a programme lands on, scroll sideways" data-wrk-rail>
    <ul class="wrk-craft__strip">
      <?php foreach ($wrk_strip as $wrk_i => $wrk_p): ?>
      <li class="wrk-craft__i bdh-zoom">
        <?= wrk_img(['file' => $wrk_p[0], 'alt' => $wrk_p[1], 'w' => $wrk_p[2], 'h' => $wrk_p[3]], [
            'ratio' => 'r45', 'class' => 'wrk-craft__img',
            'inner' => '<span class="wrk-craft__n bdh-ro" aria-hidden="true">' . wrk_n($wrk_i + 1) . '</span>']) ?>
        <p class="wrk-craft__k bdh-ro"><?= e($wrk_p[4]) ?></p>
        <p class="wrk-craft__c"><?= e($wrk_p[5]) ?></p>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>

  <div class="wrap">
    <p class="wrk-craft__foot">Reference plates, standing in for the artefacts a programme produces. <a class="tl" href="<?= xe_url('services/brand-design.php') ?>">How the system behind them is built <span class="i" aria-hidden="true">›</span></a></p>
  </div>
</section>
