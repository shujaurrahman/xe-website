<?php /* DRAFT COPY — review before launch */
/* Plate 04 — Colour system. Paint chips for a generic palette (site tokens), a live WCAG contrast
   checker for any text/background pairing, and the proportion bar. colour.js computes ratios. */
$col_pal = [   // [key, generic name, token, hex, role]
    ['ink',    'Ink',         '--ink',     '#19191D', 'Primary text'],
    ['ink-2',  'Graphite',    '--ink-2',   '#2A2A31', 'Dark surfaces'],
    ['txt',    'Slate',       '--txt',     '#4A4A52', 'Body copy'],
    ['muted',  'Pewter',      '--muted',   '#75757E', 'Secondary text'],
    ['blue',   'Signal blue', '--blue',    '#0082FB', 'Action · accent'],
    ['blue-d', 'Deep blue',   '--blue-d',  '#006CD0', 'Pressed · links'],
    ['line',   'Mist',        '--line',    '#E7E7EA', 'Rules · borders'],
    ['paper',  'Paper',       '--paper',   '#FFFFFF', 'Ground'],
];
$col_mix = [['paper', 58], ['ink', 22], ['blue', 10], ['line', 6], ['blue-d', 4]];   // PLACEHOLDER: illustrative proportions — confirm before launch
$col_rules = [   // [label, threshold, applies to]
    ['AA · body text', 4.5], ['AA · large text', 3], ['AAA · body text', 7], ['AAA · large text', 4.5], ['UI parts & icons', 3],
];
$col_lum = function (string $hex): float {
    $c = array_map(fn ($h) => hexdec($h) / 255, str_split(ltrim($hex, '#'), 2));
    $c = array_map(fn ($v) => $v <= 0.03928 ? $v / 12.92 : (($v + 0.055) / 1.055) ** 2.4, $c);
    return 0.2126 * $c[0] + 0.7152 * $c[1] + 0.0722 * $c[2];
};
$col_ratio = ($col_lum('#FFFFFF') + 0.05) / ($col_lum('#19191D') + 0.05);
$col_by = array_column($col_pal, null, 0);
?>
<section class="cbi-sec cbi-col" id="colour" aria-labelledby="colour-t">
  <div class="wrap">
    <div class="cbi-head" data-rv>
      <p class="cbi-head__folio"><span>Plate 04 · Colour</span><span>Contrast, checked</span></p>
      <div class="cbi-head__t">
        <h2 class="h2" id="colour-t"><span class="g">A palette is a set of pairings,</span> not a list of favourites.</h2>
      </div>
      <p class="lead">Every colour ships with its role, its share of the page and the pairings it is allowed in. Try any two below: the ratio is calculated live against WCAG 2.2.</p>
    </div>

    <ol class="cbi-col__chips" data-rv-s>
      <?php foreach ($col_pal as $col_p): ?>
      <li class="cbi-col__chip" style="--c:var(<?= e($col_p[2]) ?>)">
        <span class="cbi-col__patch" aria-hidden="true"></span>
        <span class="cbi-col__name"><?= e($col_p[1]) ?></span>
        <span class="cbi-col__tok"><?= e($col_p[2]) ?> · <?= e($col_p[3]) ?></span>
        <span class="cbi-col__role"><?= e($col_p[4]) ?></span>
      </li>
      <?php endforeach; ?>
    </ol>

    <div class="cbi-col__lab">
      <div class="cbi-col__view" style="--fg:#19191D;--bg:#FFFFFF" aria-hidden="true">
        <p class="cbi-col__vtop"><span class="cbi-col__pair">Ink on Paper</span><span>Specimen</span></p>
        <span class="cbi-col__aa">Aa</span>
        <p class="cbi-col__big">Recognisable at a glance.</p>
        <p class="cbi-col__small">Small text is where a palette fails first: on a phone in daylight, on a receipt, in a notification. So it is tested at the smallest size it will ever be used.</p>
        <span class="cbi-col__btnmock">Continue</span>
      </div>

      <div class="cbi-col__ctl">
        <?php foreach (['fg' => ['Text colour', 'ink'], 'bg' => ['Background', 'paper']] as $col_k => $col_f): ?>
        <fieldset class="cbi-col__set">
          <legend class="cbi-lbl cbi-lbl--ink"><?= e($col_f[0]) ?></legend>
          <div class="cbi-col__opts">
            <?php foreach ($col_pal as $col_p): ?>
            <label class="cbi-col__opt" title="<?= e($col_p[1]) ?>">
              <input class="cbi-col__in" type="radio" name="colour-<?= $col_k ?>" value="<?= e($col_p[0]) ?>" data-hex="<?= e($col_p[3]) ?>" data-name="<?= e($col_p[1]) ?>"<?= $col_p[0] === $col_f[1] ? ' checked' : '' ?>>
              <span class="cbi-col__dot" style="--c:var(<?= e($col_p[2]) ?>)" aria-hidden="true"></span><span class="bdh-sr"><?= e($col_p[1]) ?></span>
            </label>
            <?php endforeach; ?>
          </div>
        </fieldset>
        <?php endforeach; ?>

        <div class="cbi-col__read">
          <p class="cbi-col__ratio" aria-live="polite"><b><?= number_format($col_ratio, 2) ?></b><span>:1 contrast</span></p>
          <button type="button" class="cbi-btn cbi-col__swap">Swap colours <span aria-hidden="true">⇄</span></button>
        </div>
        <ul class="cbi-col__rules">
          <?php foreach ($col_rules as $col_r): $col_ok = $col_ratio >= $col_r[1]; ?>
          <li class="<?= $col_ok ? 'is-ok' : 'is-no' ?>" data-min="<?= $col_r[1] ?>"><span><?= e($col_r[0]) ?> <small><?= $col_r[1] ?>:1</small></span><b><?= $col_ok ? 'Pass' : 'Fail' ?></b></li>
          <?php endforeach; ?>
        </ul>
        <p class="cbi-col__agent"><span class="cbi-lbl cbi-lbl--blue">Agent · export check</span>The same test runs on every file exported from the templates and flags failing pairs. A designer decides whether an exception is allowed, and the decision is logged.</p>
      </div>
    </div>

    <div class="cbi-col__mix">
      <p class="cbi-col__mixh"><span class="cbi-lbl cbi-lbl--ink">Share of the page, by area</span><span class="cbi-ill">Illustrative</span></p>
      <div class="cbi-col__bar" data-rv>
        <?php foreach ($col_mix as $col_i => $col_m): $col_p = $col_by[$col_m[0]]; ?>
        <span class="cbi-col__seg cbi-col__seg--<?= e($col_m[0]) ?>" style="--w:<?= (int) $col_m[1] ?>;--c:var(<?= e($col_p[2]) ?>);--i:<?= $col_i ?>"><b><?= (int) $col_m[1] ?>%</b><em><?= e($col_p[1]) ?></em></span>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
