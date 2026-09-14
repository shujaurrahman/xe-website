<?php /* DRAFT COPY — review before launch */
/* Sustainability & responsible branding — practice, not outcome claims. A claim check shows
   anti-greenwashing by example; the weight budget is illustrative. */
$sus_practices = [
    ['Materials & packaging',   'Guidance on substrates, inks, finishes and formats, written into the system so every market starts from the same responsible defaults.', 'Packaging specification'],
    ['Digital carbon',          'Lighter identities for screens: subset variable fonts, image budgets, and motion that respects bandwidth and battery.',                 'Asset weight budgets'],
    ['Accessibility',           'Colour tokens that meet WCAG contrast, type that stays legible, and a reduced-motion version of every animation.',                     'Accessibility checks in the brand check'],
    ['Inclusive design',        'Imagery and language guidance written and reviewed with the people it portrays.',                                                      'Inclusive imagery & language guide'],
    ['Honest ESG storytelling', 'Claims matched to evidence, specific rather than sweeping, and checked against the rules in each market you operate in.',              'Claims library & review'],
];
/* PLACEHOLDER: illustrative proportions (share of page weight) — not measurements */
$sus_bars = [
    ['Unbudgeted launch page', 100, [['Fonts', 30], ['Images', 44], ['Scripts', 18], ['Motion', 8]]],
    ['Budgeted with the system', 42, [['Fonts', 22], ['Images', 46], ['Scripts', 22], ['Motion', 10]]],
];
?>
<section class="band band--alt bdh-sustainability" id="sustainability" aria-labelledby="sustainability-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Sustainability &amp; responsibility</p>
        <h2 class="h2" id="sustainability-t"><span class="g">Responsible by design,</span> not by claim.</h2>
      </div>
      <div><p class="lead">Brand decisions carry material, digital and social costs. We build responsible defaults into the system, and we will not help a brand say more than it can prove.</p></div>
    </div>

    <div class="bdh-grid bdh-sus__grid">
      <div class="bdh-c5 bdh-sus__media" data-rv>
        <!-- PLACEHOLDER: reference photography (Unsplash) — replace with commissioned/own imagery before launch -->
        <figure class="bdh-img bdh-img--r45 bdh-img--xl bdh-sus__img" data-bdh-parallax="0.05">
          <img src="<?= xe_url('assets/imgs/brand/hub/sustainability/landscape.jpg') ?>" alt="Morning light over an open landscape" width="1600" height="1066" loading="lazy" decoding="async">
        </figure>
        <div class="bdh-sus__claim" data-bdh-in data-bdh-live>
          <p class="bdh-sus__ch"><span>Claim check</span><span class="bdh-tag bdh-tag--blue">Sources required</span></p>
          <p class="bdh-sus__line">“Our packaging is <mark>100% sustainable</mark>.”</p>
          <p class="bdh-sus__note"><span class="bdh-flag" aria-hidden="true">!</span>Too broad to substantiate. Name the material and the evidence.</p>
          <p class="bdh-sus__fix"><span>Suggested</span>“Our cartons use recycled board. Evidence on file.”</p>
        </div>
      </div>

      <ol class="bdh-c6 bdh-s7 bdh-sus__list" data-rv-s data-rv-step="80">
        <?php foreach ($sus_practices as $sus_i => $sus_p): ?>
          <li class="bdh-sus__row">
            <span class="bdh-idx"><?= str_pad((string) ($sus_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <div>
              <h3 class="bdh-t"><?= e($sus_p[0]) ?></h3>
              <p class="bdh-sus__d"><?= e($sus_p[1]) ?></p>
              <span class="bdh-tag"><?= e($sus_p[2]) ?></span>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <div class="bdh-card bdh-sus__budget" data-rv>
      <div class="bdh-sus__bh">
        <div>
          <h3 class="bdh-t bdh-t--l">Weight is a brand decision</h3>
          <p class="bdh-d">Budgets for fonts, images, scripts and motion are set with your team and enforced by the brand check.</p>
        </div>
        <span class="bdh-ill">Illustrative</span>
      </div>
      <div class="bdh-sus__bars">
        <?php foreach ($sus_bars as $sus_b): ?>
          <div class="bdh-sus__barrow">
            <p class="bdh-sus__bl"><?= e($sus_b[0]) ?></p>
            <div class="bdh-sus__track">
              <div class="bdh-sus__bar" style="width:<?= $sus_b[1] ?>%">
                <?php foreach ($sus_b[2] as $sus_k => $sus_s): ?><i class="bdh-grow is-s<?= $sus_k ?>" style="flex-basis:<?= $sus_s[1] ?>%;--i:<?= $sus_k ?>" title="<?= e($sus_s[0]) ?>"></i><?php endforeach; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <p class="bdh-sus__legend"><span><i class="is-s0"></i>Fonts</span><span><i class="is-s1"></i>Images</span><span><i class="is-s2"></i>Scripts</span><span><i class="is-s3"></i>Motion</span></p>
    </div>
  </div>
</section>
