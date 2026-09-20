<?php /* DRAFT COPY — review before launch */
/* Hero — "The Field Test". Centred headline over a staged device cluster: one "Your platform" product page rendered
   at three breakpoints (browser, tablet, phone), each docked to its p75 field-data chip. The HTML is the finished
   state; hero.js assembles the rig on entry, streams each page in (skeleton → image → text) with the phone a beat
   behind the desktop, and alternates two products while on screen. Chip values are illustrative. */
$twa_hero_p = [   // two product states the pages alternate between
    ['src' => 'assets/imgs/tech/websites-apps/product-vase.jpg', 'w' => 1400, 'h' => 933, 'pos' => '62% 58%', 'name' => 'Speckled stoneware set', 'cat' => 'Shop / Tableware', 'price' => '48.00'],
    ['src' => 'assets/imgs/tech/websites-apps/product-jug.jpg',  'w' => 1400, 'h' => 933, 'pos' => '56% 56%', 'name' => 'Tall stoneware jug',     'cat' => 'Shop / Serveware', 'price' => '36.00'],
];
$twa_hero_dev = [   // key, label, context, [LCP s, INP ms, CLS], stream lag ms
    'web'   => ['Desktop', 'Broadband',              ['1.2', '60',  '0.01'], 0],
    'tab'   => ['Tablet',  'Wi-Fi',                  ['1.7', '110', '0.02'], 140],
    'phone' => ['Phone',   'Mid-range Android · 4G', ['1.9', '140', '0.04'], 340],
];

/* one product page at a breakpoint: web (two columns), tab (stacked), phone (stacked, sticky basket) */
$twa_hero_pp = function (string $layout) use ($twa_hero_p, $twa_hero_dev): string {
    $v = function (string $k) use ($twa_hero_p): string {
        return '<span class="twa-pp__v"><em class="v0">' . e($twa_hero_p[0][$k]) . '</em><em class="v1">' . e($twa_hero_p[1][$k]) . '</em></span>';
    };
    $imgs = '';
    foreach ($twa_hero_p as $twa_hi => $twa_hp) {
        $imgs .= '<img class="twa-pp__img twa-pp__img--' . $twa_hi . '" src="' . xe_url($twa_hp['src']) . '" width="' . $twa_hp['w'] . '" height="' . $twa_hp['h'] . '" alt="" decoding="async"'
               . ($twa_hi ? ' loading="lazy"' : ' fetchpriority="high"') . ' style="object-position:' . e($twa_hp['pos']) . '">';
    }
    ob_start(); ?>
    <div class="twa-pp twa-pp--<?= e($layout) ?>" data-st="done" data-v="0" data-lag="<?= (int) $twa_hero_dev[$layout][3] ?>">
      <?php if ($layout === 'phone'): ?><div class="twa-pp__status"><b>9:41</b><span><i></i><i></i><i></i><i></i></span></div><?php endif; ?>
      <div class="twa-pp__nav">
        <span class="twa-pp__burger"><i></i><i></i><i></i></span>
        <b class="twa-pp__logo"><i></i>Your platform</b>
        <span class="twa-pp__links"><i>Shop</i><i>Journal</i><i>Stores</i><i>Help</i></span>
        <span class="twa-pp__bag">Bag<em>2</em></span>
      </div>
      <div class="twa-pp__main">
        <div class="twa-pp__media">
          <span class="twa-pp__pic"><?= $imgs ?></span>
          <span class="twa-pp__thumbs"><i></i><i></i><i></i><i></i></span>
        </div>
        <div class="twa-pp__info">
          <span class="twa-pp__tx twa-pp__crumb"><?= $v('cat') ?></span>
          <b class="twa-pp__tx twa-pp__title"><?= $v('name') ?></b>
          <span class="twa-pp__tx twa-pp__stars"><span><i></i><i></i><i></i><i></i><i></i><small>4.8 · 312</small></span></span>
          <span class="twa-pp__tx twa-pp__price"><?= $v('price') ?></span>
          <span class="twa-pp__sw"><i></i><i></i><i></i></span>
          <span class="twa-pp__tx twa-pp__cta"><span>Add to basket</span></span>
          <span class="twa-pp__tx twa-pp__note"><span>Delivery in 2–3 days · free returns</span></span>
          <?php if ($layout === 'web'): ?>
          <span class="twa-pp__spec"><span class="twa-pp__tx"><span><b>Material</b>Speckled stoneware</span></span><span class="twa-pp__tx"><span><b>Care</b>Dishwasher safe</span></span><span class="twa-pp__tx"><span><b>In stock</b>Online and in 2 stores</span></span></span>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php return (string) ob_get_clean();
};

$twa_hero_chip = function (string $k, string $cls = '') use ($twa_hero_dev): string {
    $d = $twa_hero_dev[$k];
    return '<span class="twa-chip ' . e($cls) . '">'
         . '<span class="twa-chip__top"><span>p75 · ' . e($d[0]) . ' · ' . e($d[1]) . '</span><span class="twa-rt twa-rt--good">Good</span></span>'
         . '<span class="twa-chip__m"><span>LCP <b data-bdh-count>' . e($d[2][0]) . ' s</b></span><span>INP <b data-bdh-count>' . e($d[2][1]) . ' ms</b></span><span>CLS <b data-bdh-count>' . e($d[2][2]) . '</b></span></span>'
         . '</span>';
};
?>
<section class="band twa-hero" id="hero" aria-labelledby="hero-t">
  <div class="wrap">
    <div class="twa-hero__head">
      <nav class="twa-crumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="<?= xe_url('services/') ?>">Services</a></li>
          <li><a href="<?= xe_url('services/technology-intelligence.php') ?>"><?= e($TECH['name']) ?></a></li>
          <li><span aria-current="page"><?= e($CAP['name']) ?></span></li>
        </ol>
      </nav>
      <p class="twa-hero__eb"><b>Capability <?= e($CAP['n']) ?> of <?= count($TECH['caps']) ?></b><span aria-hidden="true">·</span><span>Built for day 90</span></p>
      <h1 class="twa-hero__h" id="hero-t"><span class="g">Fast on the phone in your customer’s hand,</span> not just on launch day.</h1>
      <p class="lead twa-hero__lead"><?= e($CAP_ROW[1] ?? '') ?> Performance budgets, accessibility and real-user monitoring are built in from the first sprint, so what is fast in the demo stays fast on a mid-range phone ninety days later.</p>
      <div class="twa-hero__act">
        <a class="btn btn--ink btn--lg" href="<?= xe_url('contact.php') ?>"><?= e($CAP['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out btn--lg" href="#simulator">Run the field test <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <div class="twa-hero__rig" data-bdh-live>
      <p class="bdh-sr">Illustration: the same “Your platform” product page shown on a desktop browser, a tablet and a phone, each laid out for its screen. Field data at the 75th percentile is good on all three: desktop LCP 1.2 seconds, INP 60 milliseconds, CLS 0.01; tablet LCP 1.7 seconds, INP 110 milliseconds, CLS 0.02; phone on a mid-range Android over 4G LCP 1.9 seconds, INP 140 milliseconds, CLS 0.04. Values are illustrative.</p>
      <!-- PLACEHOLDER: reference photographs (Unsplash) standing in for a client product page — confirm before launch -->
      <div class="twa-hero__stage" aria-hidden="true">
        <p class="twa-hero__tag"><span class="bdh-pulse"></span>Field data · p75 · rolling 28 days</p>
        <div class="twa-dev twa-dev--tab">
          <div class="twa-dev__body"><span class="twa-dev__cam"></span><div class="twa-dev__screen"><?= $twa_hero_pp('tab') ?></div></div>
          <?= $twa_hero_chip('tab') ?>
        </div>
        <div class="twa-dev twa-dev--web">
          <div class="twa-dev__win">
            <div class="twa-dev__bar"><span class="twa-dev__dots"><i></i><i></i><i></i></span><span class="twa-dev__url"><i></i>your-platform.com/shop/stoneware</span><span class="twa-dev__rel">Release 42</span></div>
            <div class="twa-dev__screen"><?= $twa_hero_pp('web') ?></div>
          </div>
          <?= $twa_hero_chip('web') ?>
        </div>
        <div class="twa-dev twa-dev--phone">
          <div class="twa-dev__body"><span class="twa-dev__island"></span><div class="twa-dev__screen"><?= $twa_hero_pp('phone') ?></div></div>
          <?= $twa_hero_chip('phone') ?>
        </div>
        <span class="twa-hero__floor"></span>
      </div>
      <div class="twa-hero__chips" aria-hidden="true">
        <?php foreach (['phone', 'tab', 'web'] as $twa_hk): ?><?= $twa_hero_chip($twa_hk, 'twa-chip--list') ?><?php endforeach; ?>
      </div>
    </div>

    <!-- PLACEHOLDER: confirm typical first-release timeframe before launch -->
    <dl class="twa-hero__meta">
      <?php foreach ($CAP['meta'] as $twa_hi => $twa_hm): ?>
        <div><dt><?= e($CAP['meta_k'][$twa_hi] ?? '') ?></dt><dd><?= e($twa_hm) ?></dd></div>
      <?php endforeach; ?>
    </dl>
  </div>
</section>
