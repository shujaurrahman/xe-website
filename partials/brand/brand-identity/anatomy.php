<?php /* DRAFT COPY — review before launch */
/* Plate 01 — Anatomy of an identity. An exploded view: seven stacked plates that separate as the
   section enters. The list on the right names each layer; hovering or pressing one lifts its plate. */
$anat_layers = [   // [name, what it is, code it belongs to]
    ['Mark',    'The shortest form of the brand. Built on a grid so it holds at sixteen pixels and on the side of a building.', 'Visual'],
    ['Colour',  'A palette with proportions and contrast pairs, not a list of favourite colours.', 'Visual'],
    ['Type',    'Faces with jobs: one to be seen, one to be read, one for figures and labels.', 'Visual'],
    ['Imagery', 'What the brand photographs, how it crops, and what it never shows.', 'Visual'],
    ['Voice',   'How it sounds in a launch and in an apology. Rules written with examples.', 'Verbal'],
    ['Motion',  'Timing and easing, so an interface, a film and a slide move alike.', 'Behavioural'],
    ['Sound',   'A short signature for the moments that are heard rather than seen.', 'Behavioural'],
];
?>
<section class="cbi-sec cbi-anat" id="anatomy" aria-labelledby="anatomy-t">
  <div class="wrap">
    <div class="cbi-head" data-rv>
      <p class="cbi-head__folio"><span>Plate 01 · Anatomy</span><span>Seven layers</span></p>
      <div class="cbi-head__t">
        <h2 class="h2" id="anatomy-t"><span class="g">Take the logo off.</span> Seven layers are still talking.</h2>
      </div>
      <p class="lead">An identity is a stack, not a symbol. Each layer is designed with the others in view, and behaviour runs through all seven: how the brand moves, sounds and answers when something goes wrong.</p>
    </div>

    <div class="cbi-anat__grid">
      <div class="cbi-anat__stage" aria-hidden="true">
        <div class="cbi-anat__stack">
          <?php foreach ($anat_layers as $anat_i => $anat_l): ?>
          <div class="cbi-plate cbi-plate--<?= $anat_i ?>" style="--i:<?= $anat_i ?>">
            <span class="cbi-plate__n"><?= sprintf('%02d', $anat_i + 1) ?> · <?= e($anat_l[0]) ?></span>
            <div class="cbi-plate__art">
              <?php if ($anat_i === 0): ?>
                <svg viewBox="0 0 400 400" class="cbi-plate__mark"><circle cx="150" cy="200" r="100"/><path d="M250 100h100v100h-100z" class="b"/><path d="M250 200h100a100 100 0 0 1-100 100z"/><circle cx="150" cy="200" r="50" class="k"/></svg>
              <?php elseif ($anat_i === 1): ?>
                <span class="cbi-plate__sw"><i></i><i></i><i></i><i></i><i></i></span>
              <?php elseif ($anat_i === 2): ?>
                <span class="cbi-plate__aa">Aa</span><span class="cbi-plate__lines"><i></i><i></i><i></i></span>
              <?php elseif ($anat_i === 3): ?>
                <svg viewBox="0 0 300 200" class="cbi-plate__img"><rect x="20" y="20" width="260" height="160"/><circle cx="210" cy="70" r="22"/><path d="M20 180l80-70 50 40 40-30 90 60"/></svg>
              <?php elseif ($anat_i === 4): ?>
                <span class="cbi-plate__q">“Say it plainly.”</span><span class="cbi-plate__lines"><i></i><i></i></span>
              <?php elseif ($anat_i === 5): ?>
                <svg viewBox="0 0 300 200" class="cbi-plate__curve"><path d="M30 170C120 170 150 30 270 30"/><circle cx="270" cy="30" r="9"/></svg>
              <?php else: ?>
                <span class="cbi-plate__wave"><?php for ($anat_b = 0; $anat_b < 24; $anat_b++): ?><i style="--h:<?= 18 + (int) round(70 * abs(sin($anat_b * 0.55)) * (1 - abs($anat_b - 11.5) / 14)) ?>%"></i><?php endfor; ?></span>
              <?php endif; ?>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <span class="cbi-anat__axis"><i>Top</i><i>Base</i></span>
      </div>

      <div class="cbi-anat__side">
        <ol class="cbi-anat__list">
          <?php foreach ($anat_layers as $anat_i => $anat_l): ?>
          <li>
            <button type="button" class="cbi-anat__item" data-i="<?= $anat_i ?>" aria-pressed="false">
              <span class="cbi-anat__no"><?= sprintf('%02d', $anat_i + 1) ?></span>
              <span class="cbi-anat__body">
                <span class="cbi-anat__name"><?= e($anat_l[0]) ?></span>
                <span class="cbi-anat__desc"><?= e($anat_l[1]) ?></span>
              </span>
              <span class="cbi-anat__code"><?= e($anat_l[2]) ?></span>
            </button>
          </li>
          <?php endforeach; ?>
        </ol>
        <button type="button" class="cbi-btn cbi-anat__toggle" aria-pressed="false">Collapse the stack</button>
      </div>
    </div>
  </div>
</section>
