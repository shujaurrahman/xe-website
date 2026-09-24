<?php /* DRAFT COPY — review before launch */
/* System — the diagram idiom (.pxh-flow): how one decision travels from a token to every surface, with the
   automated gate that guards each hop. Connectors live in the column gaps, so none runs through a node. */
$pxh_sy = [
    ['Tokens', [['Colour', 'Semantic roles, contrast-checked pairs'], ['Type & space', 'One scale, every breakpoint'], ['Motion', 'Durations, easing, reduced-motion']], 'Contrast pairs ≥ 4.5 : 1'],
    ['Components', [['Figma library', 'Variants and every state'], ['Code package', 'Same names, same props', true], ['Docs', 'Usage, do and don’t']], 'Keyboard & screen-reader tests'],
    ['Patterns', [['Flows', 'Sign-up, checkout, plan change'], ['AI states', 'Loading, low confidence, refusal'], ['Content', 'Voice, errors, empty states']], 'Visual regression on each change'],
    ['Surfaces', [['Web', 'React · Next.js'], ['iOS & Android', 'SwiftUI · Jetpack Compose'], ['Email & in-app', 'Themed from the same tokens']], 'Adoption tracked per team'],
];
?>
<section class="band band--alt pxh-system" id="system" aria-labelledby="system-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Built to grow</p>
        <h2 class="h2" id="system-t"><span class="g">Fix it once.</span> Every product inherits the fix.</h2></div>
      <div><p class="lead">A design system is the difference between redrawing a screen and assembling one. Decisions flow one way, from tokens to surfaces, and an automated check guards each hop, so a contrast or focus fix made in a component reaches every product that uses it.</p></div>
    </div>
    <div class="pxh-flow" style="--pxh-cols:4" data-bdh-stagger>
      <?php foreach ($pxh_sy as $pxh_i => $pxh_c): ?>
      <div class="pxh-flow__col">
        <p class="pxh-flow__lbl">0<?= $pxh_i + 1 ?> · <?= e($pxh_c[0]) ?></p>
        <?php foreach ($pxh_c[1] as $pxh_n): ?>
        <div class="pxh-flow__node<?= !empty($pxh_n[2]) ? ' pxh-flow__node--key' : '' ?>"><b><?= e($pxh_n[0]) ?></b><span><?= e($pxh_n[1]) ?></span></div>
        <?php endforeach; ?>
        <div class="pxh-flow__gate"><?= xt_icon('check') ?><?= e($pxh_c[2]) ?></div>
      </div>
      <?php endforeach; ?>
    </div>
    <p class="pxh-note">The same idiom maps a research operation, an AI evaluation loop or an operating model on the capability pages.</p>
  </div>
</section>
