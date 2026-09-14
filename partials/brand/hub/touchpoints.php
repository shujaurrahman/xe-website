<?php /* DRAFT COPY — review before launch */
/* The system, in the world — unbranded surface photography with a generic system element on each,
   and a "Show the system" switch that reveals the rules behind every surface. */
$tp_tiles = [
    // [key, label, rule, photo, w, h, alt, callout, composite]
    ['wayfinding', 'Wayfinding',   'Type size set by viewing distance.',          'wayfinding.jpg', 1600, 1066, 'A blank lightbox sign in a bright transit hall', 'Cap height 120 mm · read at 25 m', 'sign'],
    ['app',        'App',          'Tokens shared with the product UI.',          'app.jpg',        1200, 1011, 'A hand holding a phone with a blank screen',     'Tokens 1:1 with the product',     'ui'],
    ['packaging',  'Packaging',    'One grid across every pack size.',            'packaging.jpg',  1200, 800,  'A plain white mailer box on a pale surface',    'Grid 6 col · 16 gutter',          'pack'],
    ['cup',        'Takeaway cup', 'Marks that survive curves and heat.',         'cup.jpg',        1200, 800,  'A plain takeaway cup held in a hand',           'Min mark size 24 px',             'mark'],
    ['stationery', 'Stationery',   'Print colour matched to the screen tokens.',  'stationery.jpg', 1200, 800,  'Stacks of blank business cards',                'Colour · ink / blue',             'card'],
    ['tote',       'Tote',         'Minimum sizes for fabric and embroidery.',    'tote.jpg',       1200, 800,  'A plain canvas tote bag',                       'Clearspace 1×',                   'mark'],
];
$tp_more = ['Email', 'Events', 'Uniform', 'Vehicle livery', 'Product UI', 'Voice assistant', 'Annual report', 'Careers site', 'Partner portal', 'Trade show', 'Service desk', 'Retail fit-out'];
?>
<section class="band bdh-touchpoints" id="touchpoints" aria-labelledby="touchpoints-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>In the world</p>
        <h2 class="h2" id="touchpoints-t"><span class="g">One system,</span> on every surface it meets.</h2>
      </div>
      <div>
        <p class="lead">A sign read from across a terminal. An app opened in a hurry. A box on a doorstep. Each surface has its own rules, and all of them come from the same system.</p>
        <button class="bdh-switch bdh-tp__switch" type="button" aria-pressed="false" aria-controls="touchpoints-grid"><span class="bdh-switch__track" aria-hidden="true"></span>Show the system</button>
      </div>
    </div>

    <!-- PLACEHOLDER: reference photography (Unsplash) — replace with commissioned/own imagery before launch -->
    <div class="bdh-tp__grid" id="touchpoints-grid" data-rv-s data-rv-step="70">
      <?php foreach ($tp_tiles as $tp_i => $tp_t): ?>
        <figure class="bdh-tp__tile bdh-tp__tile--<?= e($tp_t[0]) ?> bdh-zoom" style="--i:<?= $tp_i ?>">
          <span class="bdh-img bdh-img--xl bdh-tp__img">
            <img src="<?= xe_url('assets/imgs/brand/hub/touchpoints/' . $tp_t[3]) ?>" alt="<?= e($tp_t[6]) ?>" width="<?= $tp_t[4] ?>" height="<?= $tp_t[5] ?>" loading="lazy" decoding="async">
          </span>

          <span class="bdh-tp__sys" aria-hidden="true"><i class="bdh-tp__cols"></i></span>

          <span class="bdh-tp__comp bdh-tp__comp--<?= e($tp_t[8]) ?>" aria-hidden="true">
            <?php if ($tp_t[8] === 'sign'): ?>
              <b>Gate 12</b><i>Arrivals · Departures</i><em>→</em>
            <?php elseif ($tp_t[8] === 'ui'): ?>
              <b>Your brand</b><i></i><i class="is-s"></i><em>Continue</em>
            <?php elseif ($tp_t[8] === 'pack'): ?>
              <b>Your brand</b><i>LOT 0412 · 250 g</i>
            <?php elseif ($tp_t[8] === 'card'): ?>
              <b>Your brand</b><i>Name Surname</i><i class="is-s">Role · Market 03</i>
            <?php else: ?>
              <b>Your brand</b>
            <?php endif; ?>
            <span class="bdh-tp__call"><?= e($tp_t[7]) ?></span>
          </span>

          <figcaption class="bdh-cap-chip bdh-tp__cap"><b><?= e($tp_t[1]) ?></b><?= e($tp_t[2]) ?></figcaption>
        </figure>
      <?php endforeach; ?>
    </div>

    <div class="bdh-tp__more mask-x" aria-label="More surfaces the system covers">
      <div class="mq mq--l" data-mq style="--mq-dur:60s">
        <?php foreach ($tp_more as $tp_m): ?><span class="bdh-tp__mi"><?= e($tp_m) ?></span><?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
