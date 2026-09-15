<?php /* DRAFT COPY — review before launch */
/* Plate 05 — Type system. A scale ladder re-rendered live from one base and a ratio
   (1.2 / 1.25 / 1.333), each step set in the face that does that job; then the three faces as
   foundry specimens. HTML renders the 1.25 scale; type.js recalculates. */
$type_base = 16;
$type_ratios = [['1.2', 'Minor third', 'Dense product UI'], ['1.25', 'Major third', 'Balanced: web and print'], ['1.333', 'Perfect fourth', 'Editorial, campaigns']];
$type_steps = [   // [step, role, face key, sample, line-height]
    [6,  'Display',   'h', 'Recognisable',                                  1.0],
    [5,  'Headline',  'h', 'Everywhere it shows up',                        1.02],
    [4,  'Heading 1', 'h', 'One brand, every touchpoint',                   1.06],
    [3,  'Heading 2', 'h', 'Rules written with examples',                   1.1],
    [2,  'Heading 3', 'h', 'A kit of parts, not a poster',                  1.2],
    [1,  'Lead',      'b', 'Leads introduce a section in a sentence or two.', 1.5],
    [0,  'Body',      'b', 'Body text is set for reading, at a measure of sixty to seventy-five characters.', 1.65],
    [-1, 'Caption',   'b', 'Captions carry sources, credits and figure notes.', 1.5],
    [-2, 'Label',     'm', 'LABEL · STEP 02 · STATUS',                      1.3],
];
$type_faces = [   // [key, family token, name, job, weights, sample glyphs]
    ['h', '--f-h', 'Outfit',         'To be seen: headlines, titles, statements.',     '500 display · 400 large', 'Rg'],
    ['b', '--f-b', 'Montserrat',     'To be read: body, leads, buttons, forms.',       '400 · 500 · 600',         'Rg'],
    ['m', '--f',   'JetBrains Mono', 'To be scanned: labels, figures, codes, data.',   '400 · 500',               'R0'],
];
$type_fam = ['h' => 'var(--f-h)', 'b' => 'var(--f-b)', 'm' => 'var(--f)'];
$type_face_name = array_column($type_faces, 2, 0);
?>
<section class="cbi-sec cbi-sec--tint cbi-type" id="type" aria-labelledby="type-t">
  <div class="wrap">
    <div class="cbi-head" data-rv>
      <p class="cbi-head__folio"><span>Plate 05 · Type</span><span>One base, one ratio</span></p>
      <div class="cbi-head__t">
        <h2 class="h2" id="type-t"><span class="g">Nine sizes,</span> from a single decision.</h2>
      </div>
      <p class="lead">A type scale is multiplied, not picked. Choose the ratio and every size recalculates from a <?= $type_base ?> px base, so a headline and a caption stay related wherever they are set.</p>
    </div>

    <div class="cbi-type__ctl">
      <p class="cbi-lbl cbi-lbl--ink" id="type-ratio-l">Scale ratio</p>
      <div class="cbi-type__ratios" role="group" aria-labelledby="type-ratio-l">
        <?php foreach ($type_ratios as $type_r): ?>
        <button type="button" class="cbi-type__ratio" data-r="<?= e($type_r[0]) ?>" aria-pressed="<?= $type_r[0] === '1.25' ? 'true' : 'false' ?>">
          <b><?= e(number_format((float) $type_r[0], 3)) ?></b><span><?= e($type_r[1]) ?></span><small><?= e($type_r[2]) ?></small>
        </button>
        <?php endforeach; ?>
      </div>
      <p class="cbi-type__base"><span class="cbi-lbl">Base</span><b><?= $type_base ?> px</b></p>
    </div>

    <ol class="cbi-type__ladder" aria-live="polite">
      <?php foreach ($type_steps as $type_i => $type_s): $type_px = $type_base * (1.25 ** $type_s[0]); ?>
      <li class="cbi-type__row cbi-type__row--<?= e($type_s[2]) ?>" data-step="<?= $type_s[0] ?>" style="--px:<?= round($type_px, 2) ?>;--lh:<?= $type_s[4] ?>;--i:<?= $type_i ?>">
        <span class="cbi-type__meta">
          <b><?= $type_s[0] > 0 ? '+' . $type_s[0] : $type_s[0] ?></b>
          <span class="cbi-type__role"><?= e($type_s[1]) ?></span>
        </span>
        <span class="cbi-type__sample" style="font-family:<?= $type_fam[$type_s[2]] ?>"><?= e($type_s[3]) ?></span>
        <span class="cbi-type__ro">
          <span class="cbi-type__px"><?= number_format($type_px, 1) ?> px</span>
          <span class="cbi-type__rem"><?= number_format($type_px / $type_base, 3) ?> rem · <?= e($type_face_name[$type_s[2]]) ?></span>
          <span class="cbi-type__bar" aria-hidden="true"><i></i></span>
        </span>
      </li>
      <?php endforeach; ?>
    </ol>

    <div class="cbi-type__faces">
      <?php foreach ($type_faces as $type_f): ?>
      <article class="cbi-face" style="--ff:var(<?= e($type_f[1]) ?>)">
        <p class="cbi-face__top"><span><?= e($type_f[2]) ?></span><span><?= e($type_f[4]) ?></span></p>
        <span class="cbi-face__g" aria-hidden="true"><?= e($type_f[5]) ?></span>
        <span class="cbi-face__set" aria-hidden="true">ABCDEFGHIJKLMNOPQRSTUVWXYZ<br>abcdefghijklmnopqrstuvwxyz<br>0123456789 &amp; ? ! § % → ·</span>
        <h3 class="cbi-face__t"><?= e($type_f[3]) ?></h3>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
