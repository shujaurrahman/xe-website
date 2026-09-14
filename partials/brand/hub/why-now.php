<?php /* DRAFT COPY — review before launch */
/* Why brand, why now — a scroll-lit statement, one wide photograph, four shifts. Words are split
   into spans here so why-now.js can light them; the markup already reads in full without it. */
$why_grey = 'A brand is no longer a logo and a campaign.';
$why_ink  = 'It is a system that thousands of people, partners and AI tools produce against every day.';
$why_words = function (string $text): string {
    return implode(' ', array_map(fn ($w) => '<span class="bdh-why__w">' . e($w) . '</span>', preg_split('/\s+/', trim($text))));
};
$why_shifts = [
    ['Touchpoints multiplied',     'Apps, stores, service, partner channels and AI assistants. The brand is experienced in more places than any team can review.'],
    ['Content outran review',      'Generative tools make assets faster than brand teams can approve them. The rules have to be written for machines as well as people.'],
    ['Portfolios got complicated', 'Acquisitions, sub-brands and new ventures pile up. Without architecture, equity spreads thin and customers get lost.'],
    ['Scrutiny went up',           'Accessibility rules, sustainability claims and AI disclosure are brand questions now, not only legal ones.'],
];
?>
<section class="band bdh-why-now" id="why-now" aria-labelledby="why-now-t">
  <div class="wrap">
    <p class="lbl lbl--blue bdh-why__lbl" data-rv><span class="dot"></span>Why brand, why now</p>
    <h2 class="bdh-why__h" id="why-now-t"><span class="g"><?= $why_words($why_grey) ?></span> <?= $why_words($why_ink) ?></h2>

    <!-- PLACEHOLDER: reference photography (Unsplash) — replace with commissioned/own imagery before launch -->
    <figure class="bdh-img bdh-img--r219 bdh-img--xl bdh-why__img" data-bdh-parallax="0.06" data-rv>
      <img src="<?= xe_url('assets/imgs/brand/hub/why-now/glass-lattice.jpg') ?>" alt="Looking up through the steel and glass lattice of a large public roof" width="1600" height="953" loading="lazy" decoding="async">
      <span class="bdh-cap-chip bdh-why__chip"><b>Where the brand is experienced now</b>Stores, screens, service desks, partners and AI assistants</span>
    </figure>

    <ol class="bdh-why__shifts" data-rv-s data-rv-step="90">
      <?php foreach ($why_shifts as $why_i => $why_s): ?>
        <li>
          <span class="bdh-idx"><?= str_pad((string) ($why_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <h3 class="bdh-t bdh-why__t"><?= e($why_s[0]) ?></h3>
          <p class="bdh-d bdh-why__d"><?= e($why_s[1]) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>

    <a class="tl bdh-why__more" href="#capabilities">What we build in response <span class="i" aria-hidden="true">›</span></a>
  </div>
</section>
