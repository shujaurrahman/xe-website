<?php /* DRAFT COPY — review before launch */
/* Plate 08 — Seen across touchpoints. A drag / snap gallery of blank, unbranded photos; the generic
   identity is set onto each surface in HTML/CSS (not baked into the image) and draws in as a slide
   comes into view. Overlay boxes are % of a 4:5 frame (object-position centre). */
$tp_mark = '<svg class="cbi-tp__mk" viewBox="50 100 300 200" aria-hidden="true"><path class="o" fill-rule="evenodd" d="M50 200a100 100 0 1 0 200 0a100 100 0 1 0-200 0zM100 200a50 50 0 1 0 100 0a50 50 0 1 0-100 0z"/><path class="a" d="M250 100h100v100h-100z"/><path class="o" d="M250 200h100a100 100 0 0 1-100 100z"/></svg>';
$tp_slides = [   // [file, w, h, alt, sector, surface, elements applied, overlay kind, [left, top, width, height] %]
    ['tp-sign',      960,  1200, 'A blank rectangular sign on a pole against a pale blue sky',                'Wayfinding',  'Site signage',        'Mark · Ink panel · Outfit',        'sign',    [37, 16, 29, 44]],
    ['tp-phone',     1200, 1200, 'Two hands holding a phone with a blank white screen over a pale wooden desk', 'Product',   'App launch screen',   'Mark · Signal blue · Montserrat',  'screen',  [31.6, 25.6, 36.8, 55.2]],
    ['tp-billboard', 1200, 1200, 'An empty poster frame on a terrace between apartment buildings',          'Out of home', 'Poster',              'Signal blue ground · Outfit display', 'poster', [25.6, 17.6, 46.4, 41.4]],
    ['tp-box',       1200, 800,  'A plain white shipping box with open flaps on a white table',             'Packaging',   'Shipping box',        'Lockup · Ink on kraft white',      'box',     [22, 52, 54, 26]],
    ['tp-van',       1200, 675,  'A plain white van parked on a city street',                               'Fleet',       'Vehicle side panel',  'Lockup · Signal blue accent',      'van',     [7, 40, 54, 20]],
    ['tp-apron',     1200, 800,  'A person in an apron beside a closed metal shutter, in black and white',  'Retail',      'Storefront shutter',  'Mark at architectural scale',      'shutter', [7, 12, 36, 32]],
];
?>
<section class="cbi-sec cbi-tp" id="touchpoints" aria-labelledby="touchpoints-t">
  <div class="wrap">
    <div class="cbi-head" data-rv>
      <p class="cbi-head__folio"><span>Plate 08 · Applied</span><span><?= count($tp_slides) ?> surfaces</span></p>
      <div class="cbi-head__t">
        <h2 class="h2" id="touchpoints-t"><span class="g">Directions are judged on real surfaces,</span> never on a poster alone.</h2>
      </div>
      <p class="lead">A sign in the sky, a screen in a hand, a box on a doorstep, a van in traffic. The same kit of parts has to hold on each, which is why we test it on them from the concept stage.</p>
    </div>
  </div>

  <div class="cbi-tp__rail">
    <div class="cbi-tp__scroller bdh-scroll-x" tabindex="0" role="region" aria-label="Identity applied to six touchpoints, scroll sideways">
      <ol class="cbi-tp__list">
        <?php foreach ($tp_slides as $tp_i => $tp_s): [$tp_l, $tp_t, $tp_w, $tp_h] = $tp_s[8]; ?>
        <li class="cbi-tp__slide">
          <figure class="cbi-tp__fig">
            <div class="cbi-tp__frame cbi-tp__frame--<?= e($tp_s[7]) ?>">
              <!-- PLACEHOLDER: reference photo (Unsplash), blank surface; identity overlaid in code — replace with own photography before launch -->
              <img src="<?= xe_url('assets/imgs/brand/brand-identity/' . $tp_s[0] . '.jpg') ?>" alt="<?= e($tp_s[3]) ?>, with the “Your brand” identity applied" width="<?= $tp_s[1] ?>" height="<?= $tp_s[2] ?>" loading="lazy" decoding="async">
              <div class="cbi-tp__ov cbi-tp__ov--<?= e($tp_s[7]) ?>" style="--l:<?= $tp_l ?>%;--t:<?= $tp_t ?>%;--w:<?= $tp_w ?>%;--h:<?= $tp_h ?>%" aria-hidden="true">
                <span class="cbi-tp__in">
                <?php if ($tp_s[7] === 'sign'): ?>
                  <?= $tp_mark ?><b>Entrance B</b><i>→</i>
                <?php elseif ($tp_s[7] === 'screen'): ?>
                  <span class="cbi-tp__bar"></span><?= $tp_mark ?><b>Your brand</b><em>Get started</em>
                <?php elseif ($tp_s[7] === 'poster'): ?>
                  <?= $tp_mark ?><b>Recognisable at a glance.</b><small>yourbrand.example</small>
                <?php else: ?>
                  <?= $tp_mark ?><b>Your brand</b>
                <?php endif; ?>
                </span>
              </div>
              <span class="cbi-tp__no" aria-hidden="true"><?= sprintf('%02d', $tp_i + 1) ?></span>
            </div>
            <figcaption class="cbi-tp__cap">
              <span class="cbi-tp__sector"><?= e($tp_s[4]) ?></span>
              <span class="cbi-tp__surface"><?= e($tp_s[5]) ?></span>
              <span class="cbi-tp__els"><?= e($tp_s[6]) ?></span>
            </figcaption>
          </figure>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>

  <div class="wrap cbi-tp__foot">
    <p class="cbi-tp__count" aria-live="polite"><b>01</b> / <?= sprintf('%02d', count($tp_slides)) ?></p>
    <span class="cbi-tp__progress" aria-hidden="true"><i></i></span>
    <div class="cbi-tp__nav">
      <button type="button" class="cbi-btn" data-tp="-1" aria-label="Previous touchpoint"><span aria-hidden="true">‹</span></button>
      <button type="button" class="cbi-btn" data-tp="1" aria-label="Next touchpoint"><span aria-hidden="true">›</span></button>
    </div>
  </div>
</section>
