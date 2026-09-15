<?php /* DRAFT COPY — review before launch */
/* 5 · Relationship and lockup rules — a lockup builder. Choose how two brands relate; a generic
   lockup renders with clear-space, ratio and minimum-size annotations, the rules that apply, and
   the same lockup placed on a blank projecting sign. HTML = the Endorsed state. */
$cba_rels = [
    // key, label, ratio, clear space, min size, rules[3], where they do not meet
    ['end', 'Endorsed', '1 : 0.42', '1× cap height', '32 px', [
        'The endorsed brand leads; the parent sits beneath, never beside.',
        'Endorsement line at 42% of the lead name’s height.',
        'Parent colour only in the endorsement, never in the lead name.',
    ], 'Pack fronts under 40 mm: endorsement moves to the back panel.'],
    ['co', 'Co-brand', '1 : 1', '1.5× cap height', '40 px', [
        'Equal visual weight, separated by a hairline divider.',
        'Host brand on the left in the host’s own channels.',
        'Neither brand’s colour dominates the shared field.',
    ], 'Never inside a single product name; co-brands are time-bound.'],
    ['desc', 'Descriptor', '1 : 0.8', '1× cap height', '24 px', [
        'The master brand and the descriptor share one baseline.',
        'Descriptor in the secondary weight, never a logo of its own.',
        'Descriptors are plain words customers already use.',
    ], 'Descriptors never carry a trademark or a separate colour.'],
    ['solo', 'Standalone', '— : —', '2× cap height', '28 px', [
        'The brand stands alone on every customer surface.',
        'The parent appears only in the legal line and investor material.',
        'No shared typeface or colour cues with the parent.',
    ], 'Corporate and careers channels are the only places they meet.'],
];
$cba_r0 = $cba_rels[0];
?>
<section class="band band--alt cba-lock" id="lockup" aria-labelledby="lockup-t">
  <div class="wrap">
    <div class="cba-head" data-rv>
      <div class="cba-head__t">
        <p class="cba-eb"><b>A-104</b><i aria-hidden="true"></i>Relationship rules</p>
        <h2 class="h2" id="lockup-t"><span class="g">How brands stand together,</span> drawn to dimension.</h2>
      </div>
      <div class="cba-head__l">
        <p class="lead"><?= e($CBA_CAP['offer'][2][1]) ?></p>
      </div>
    </div>

    <div class="cba-lock__app" data-cba-lock data-rel="end">
      <div class="cba-lock__bar">
        <p class="cba-mono cba-mono--ink" id="lockup-rel">Relationship</p>
        <div class="cba-lock__opts" role="radiogroup" aria-labelledby="lockup-rel">
          <?php foreach ($cba_rels as $cba_ri => $cba_r): ?>
            <button type="button" class="cba-ctl" role="radio" data-rel="<?= $cba_r[0] ?>" aria-checked="<?= $cba_ri === 0 ? 'true' : 'false' ?>" tabindex="<?= $cba_ri === 0 ? '0' : '-1' ?>"><?= e($cba_r[1]) ?></button>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="cba-lock__grid">
        <div class="cba-lock__board cba-sheet" aria-hidden="true">
          <span class="cba-sheet__x cba-sheet__x--tl"></span><span class="cba-sheet__x cba-sheet__x--br"></span>
          <p class="cba-lock__sheet cba-mono"><span>Lockup · <b data-l="name">Endorsed</b></span><span>Scale 1 : 1</span></p>
          <div class="cba-lock__field">
            <div class="cba-lock__mark">
              <span class="cba-lock__clear"><i></i><i></i><i></i><i></i></span>
              <span class="cba-lock__row">
                <span class="cba-lock__a" data-l="a">Sub-brand A</span>
                <span class="cba-lock__div"></span>
                <span class="cba-lock__b" data-l="b">by Your brand</span>
              </span>
              <span class="cba-lock__dim cba-lock__dim--h"><b data-l="ratio">1 : 0.42</b></span>
              <span class="cba-lock__dim cba-lock__dim--w"><b>x</b></span>
            </div>
            <div class="cba-lock__minis">
              <figure class="cba-lock__mini">
                <span class="cba-lock__row"><span class="cba-lock__a" data-l="a">Sub-brand A</span><span class="cba-lock__div"></span><span class="cba-lock__b" data-l="b">by Your brand</span></span>
                <figcaption>Minimum · <span data-l="min"><?= e($cba_r0[4]) ?></span></figcaption>
              </figure>
              <figure class="cba-lock__mini is-never">
                <span class="cba-lock__row"><span class="cba-lock__a" data-l="a">Sub-brand A</span><span class="cba-lock__div"></span><span class="cba-lock__b" data-l="b">by Your brand</span></span>
                <figcaption>Never · stretched or re-spaced</figcaption>
              </figure>
            </div>
          </div>
          <dl class="cba-lock__spec">
            <div><dt>Ratio</dt><dd data-l="ratio2"><?= e($cba_r0[2]) ?></dd></div>
            <div><dt>Clear space</dt><dd data-l="clear"><?= e($cba_r0[3]) ?></dd></div>
            <div><dt>Minimum</dt><dd data-l="min"><?= e($cba_r0[4]) ?></dd></div>
          </dl>
        </div>

        <div class="cba-lock__side">
          <!-- PLACEHOLDER: reference photography (Unsplash) — the lockup on the sign is composited in CSS; replace before launch -->
          <figure class="cba-plate cba-lock__photo" aria-hidden="true">
            <img src="<?= xe_url('assets/imgs/brand/brand-architecture/blade-sign-blank.jpg') ?>" alt="" width="1000" height="1250" loading="lazy" decoding="async">
            <span class="cba-lock__sign"><span class="cba-lock__row"><span class="cba-lock__a" data-l="a">Sub-brand A</span><span class="cba-lock__div"></span><span class="cba-lock__b" data-l="b">by Your brand</span></span></span>
            <figcaption><b>Fig. 02</b>Projecting sign · in situ</figcaption>
          </figure>
          <div class="cba-lock__rules" aria-live="polite">
            <h3 class="cba-lock__h" data-l="name2">Endorsed</h3>
            <ol class="cba-lock__list" data-l="rules">
              <?php foreach ($cba_r0[5] as $cba_rule): ?><li><?= e($cba_rule) ?></li><?php endforeach; ?>
            </ol>
            <p class="cba-lock__never"><span class="cba-mono">Where they do not meet</span><span data-l="never"><?= e($cba_r0[6]) ?></span></p>
          </div>
        </div>
      </div>
      <p class="bdh-sr">Lockup builder: choose a relationship to see a generic lockup with its ratio, clear space, minimum size and rules.</p>
    </div>
    <script type="application/json" id="lockup-data"><?= json_encode($cba_rels, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
  </div>
</section>
