<?php /* DRAFT COPY — review before launch */
/* Plate 03 — Mark construction lab. One drawing board, five states: grid → geometry → optical
   corrections → clear space → minimum size. construct.js walks the steps until the visitor takes over. */
$cx_steps = [   // [title, explanation, [[readout label, value], …]]  PLACEHOLDER: illustrative values for a generic mark — confirm before launch
    ['Grid',                'Six units wide, four high. Every part of the mark sits on this grid, so anyone can redraw it exactly, in any tool, at any size.', [['Grid', '6 × 4 units'], ['Unit', '1u = width ÷ 6']]],
    ['Geometry',            'Three primitives and a counter: a circle, a square and a quarter-disc. The construction lines are kept, because they become the rules for icons and layouts later.', [['Parts', '3 + counter'], ['Radius', '2u']]],
    ['Optical corrections', 'Geometry that is right on paper can look wrong to the eye. The circle overshoots the flat top so it looks the same height, and the counter opens so it does not fill in when printed.', [['Overshoot', '+4%'], ['Counter', '+6%']]],
    ['Clear space',         'The empty space around the mark equals the counter’s radius, x. Nothing enters it: not a headline, not the edge of a screen, not another logo.', [['Clear space', '1x on all sides'], ['x', '1u']]],
    ['Minimum size',        'Below 24 pixels the counter closes up, so a solid version takes over. Each size is checked on screen and in print before it is signed off.', [['Digital', '16 px minimum'], ['Print', '6 mm minimum']]],
];
?>
<section class="cbi-sec cbi-sec--tint cbi-cx" id="construct" aria-labelledby="construct-t">
  <div class="wrap">
    <div class="cbi-head" data-rv>
      <p class="cbi-head__folio"><span>Plate 03 · Mark construction</span><span>Five steps</span></p>
      <div class="cbi-head__t">
        <h2 class="h2" id="construct-t"><span class="g">A mark is drawn once,</span> then used a million times.</h2>
      </div>
      <p class="lead">So it is built like an engineering drawing. The grid, the corrections and the limits are written down with the mark, which is what lets it survive a favicon, a fascia and a file someone else exported.</p>
    </div>

    <div class="cbi-cx__grid">
      <div class="cbi-cx__board" data-step="0">
        <span class="cbi-crop" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
        <p class="cbi-cx__bar" aria-hidden="true"><span class="cbi-cx__count">Step <b>01</b> / 05</span><span class="cbi-ill">Illustrative mark</span></p>
        <svg class="cbi-cx__svg" viewBox="0 0 600 440" fill="none" aria-hidden="true">
          <defs>
            <g id="construct-mk"><circle cx="250" cy="220" r="100" style="fill:var(--ink)"/><path d="M350 120h100v100h-100z" style="fill:var(--blue)"/><path d="M350 220h100a100 100 0 0 1-100 100z" style="fill:var(--ink)"/><circle cx="250" cy="220" r="50" style="fill:var(--paper)"/></g>
            <g id="construct-solid"><circle cx="250" cy="220" r="100" style="fill:var(--ink)"/><path d="M350 120h100v100h-100z" style="fill:var(--blue)"/><path d="M350 220h100a100 100 0 0 1-100 100z" style="fill:var(--ink)"/></g>
          </defs>
          <g class="l-grid">
            <?php for ($cx_x = 50; $cx_x <= 550; $cx_x += 50): ?><line x1="<?= $cx_x ?>" y1="20" x2="<?= $cx_x ?>" y2="420" class="<?= ($cx_x - 150) % 100 === 0 && $cx_x >= 150 && $cx_x <= 450 ? 'mj' : '' ?>"/><?php endfor; ?>
            <?php for ($cx_y = 20; $cx_y <= 420; $cx_y += 50): ?><line x1="20" y1="<?= $cx_y ?>" x2="580" y2="<?= $cx_y ?>"/><?php endfor; ?>
          </g>
          <g class="l-units">
            <rect x="150" y="120" width="300" height="200" class="frame"/>
            <?php for ($cx_u = 0; $cx_u < 6; $cx_u++): ?><text x="<?= 175 + $cx_u * 50 ?>" y="104" text-anchor="middle"><?= $cx_u + 1 ?>u</text><?php endfor; ?>
            <?php for ($cx_u = 0; $cx_u < 4; $cx_u++): ?><text x="132" y="<?= 149 + $cx_u * 50 ?>" text-anchor="end"><?= $cx_u + 1 ?></text><?php endfor; ?>
          </g>
          <g class="l-geo">
            <circle cx="250" cy="220" r="100"/><circle cx="250" cy="220" r="50"/><circle cx="350" cy="220" r="100"/>
            <line x1="150" y1="120" x2="450" y2="320"/><line x1="150" y1="320" x2="450" y2="120"/><line x1="350" y1="100" x2="350" y2="340"/>
          </g>
          <g class="l-outline">
            <circle cx="250" cy="220" r="100"/><path d="M350 120h100v100h-100z"/><path d="M350 220h100a100 100 0 0 1-100 100z"/><circle cx="250" cy="220" r="50"/>
          </g>
          <g class="l-fill">
            <circle class="c-main" cx="250" cy="220" r="100"/><path d="M350 120h100v100h-100z" class="b"/><path d="M350 220h100a100 100 0 0 1-100 100z"/><circle class="c-counter" cx="250" cy="220" r="50"/>
          </g>
          <g class="l-optic">
            <line x1="120" y1="120" x2="480" y2="120" class="dash"/><line x1="120" y1="320" x2="480" y2="320" class="dash"/>
            <path d="M250 116v-40M244 116h12" class="lead"/><text x="262" y="82">+4% overshoot</text>
            <path d="M296 214l78 -104" class="lead"/><text x="380" y="98">counter +6%</text>
          </g>
          <g class="l-clear">
            <rect x="100" y="70" width="400" height="300" class="dash"/>
            <rect x="100" y="70" width="50" height="50" class="xbox"/><rect x="450" y="70" width="50" height="50" class="xbox"/>
            <rect x="100" y="320" width="50" height="50" class="xbox"/><rect x="450" y="320" width="50" height="50" class="xbox"/>
            <text x="125" y="100" text-anchor="middle" class="x">x</text><text x="475" y="100" text-anchor="middle" class="x">x</text>
            <text x="125" y="350" text-anchor="middle" class="x">x</text><text x="475" y="350" text-anchor="middle" class="x">x</text>
          </g>
          <g class="l-min">
            <g transform="translate(40 150) scale(.36)"><use href="#construct-mk"/></g>
            <g transform="translate(230 192) scale(.18)"><use href="#construct-mk"/></g>
            <g transform="translate(360 206) scale(.12)"><use href="#construct-solid"/></g>
            <line x1="90" y1="300" x2="200" y2="300"/><text x="145" y="330" text-anchor="middle">72 px</text>
            <line x1="255" y1="300" x2="310" y2="300"/><text x="282" y="330" text-anchor="middle">36 px</text>
            <line x1="378" y1="300" x2="416" y2="300"/><text x="397" y="330" text-anchor="middle">16 px · solid</text>
          </g>
        </svg>
        <div class="cbi-cx__track" aria-hidden="true"><?php foreach ($cx_steps as $cx_i => $cx_s): ?><i class="<?= $cx_i === 0 ? 'is-on' : '' ?>"></i><?php endforeach; ?></div>
      </div>

      <div class="cbi-cx__side">
        <ol class="cbi-cx__steps" aria-label="Construction steps">
          <?php foreach ($cx_steps as $cx_i => $cx_s): ?>
          <li><button type="button" class="cbi-cx__step" data-i="<?= $cx_i ?>" aria-controls="construct-p<?= $cx_i ?>" aria-pressed="<?= $cx_i === 0 ? 'true' : 'false' ?>"><span><?= sprintf('%02d', $cx_i + 1) ?></span><?= e($cx_s[0]) ?></button></li>
          <?php endforeach; ?>
        </ol>
        <div class="cbi-cx__panes" aria-live="polite">
          <?php foreach ($cx_steps as $cx_i => $cx_s): ?>
          <div class="cbi-cx__pane<?= $cx_i === 0 ? ' is-on' : '' ?>" id="construct-p<?= $cx_i ?>">
            <h3 class="cbi-cx__t"><?= e($cx_s[0]) ?></h3>
            <p class="cbi-cx__d"><?= e($cx_s[1]) ?></p>
            <dl class="cbi-cx__ro"><?php foreach ($cx_s[2] as $cx_r): ?><div><dt><?= e($cx_r[0]) ?></dt><dd><?= e($cx_r[1]) ?></dd></div><?php endforeach; ?></dl>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="cbi-cx__nav">
          <button type="button" class="cbi-btn" data-go="-1" disabled><span aria-hidden="true">‹</span> Previous</button>
          <button type="button" class="cbi-btn cbi-btn--blue" data-go="1">Next step <span aria-hidden="true">›</span></button>
        </div>
      </div>
    </div>
  </div>
</section>
