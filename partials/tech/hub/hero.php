<?php /* DRAFT COPY — review before launch */
/* Hero — the control plane. Text on paper, left. Right: an ink panel that bleeds to the viewport edge and
   holds a live topology of "Your platform" in four layers, with a status bar. The HTML is the finished state
   (every edge drawn, readouts at their values); hero.js runs packets along the edges and ticks the readouts
   while the panel is on screen. Reduced motion keeps the static diagram. */
$hero_stage_h = 700;
$hero_status = [
    // [key, label, value, unit]  PLACEHOLDER: illustrative readouts, not client results
    ['p95',    'p95 latency',  '212',     'ms'],
    ['evals',  'Evals',        '148/148', 'pass'],
    ['budget', 'Error budget', '71%',     'left'],
    ['sci',    'Carbon',       '0.18',    'gCO₂e/req'],
];
// the control plane's event feed: one line at a time, typed by hero.js (illustrative)
$hero_feed = [
    ['10:42:07', 'gateway',    'support.answer → route:small · 38 ms'],
    ['10:42:09', 'evals',      'golden-set@v14 · 148/148 pass · faithfulness 0.94'],
    ['10:42:12', 'guardrails', 'prompt injection (LLM01) blocked · ticket/88412'],
    ['10:42:15', 'deploy',     'canary 5% → 25% · error rate 0.08% · rollback armed'],
    ['10:42:18', 'finops',     'cost per 1k requests $1.02 · under cap'],
    ['10:42:21', 'carbon',     'batch.embed moved to 02:00 IST · cleaner grid'],
    ['10:42:24', 'search',     'cited in 3 of 4 answer engines · prompt panel'],
    ['10:42:27', 'on-call',    'SLO burn 0.4× · no page'],
];
$hero_sr_layers = [];
foreach ($TIH['layers'] as $hero_lk => $hero_l) {
    $hero_sr_layers[] = $hero_l['name'] . ' (' . implode(', ', array_map(fn ($hero_s) => $TI[$hero_s]['name'], $hero_l['caps'])) . ')';
}
?>
<section class="tih-hero" id="top" aria-labelledby="hero-t">
  <div class="tih-hero__bg" aria-hidden="true"><span class="tih-hero__grid dots"></span></div>

  <div class="wrap tih-hero__in">
    <div class="tih-hero__text">
      <p class="lbl lbl--blue tih-hero__up" style="--i:0"><span class="dot"></span>What we do · <?= e($TECH['n']) ?> · <?= e($TECH['name']) ?></p>
      <h1 class="tih-hero__h tih-hero__up" id="hero-t" style="--i:1"><span class="g">Software, AI and infrastructure</span> run as one platform.</h1>
      <p class="lead tih-hero__lead tih-hero__up" style="--i:2"><?= e($TECH['intro']) ?></p>
      <div class="tih-hero__act tih-hero__up" style="--i:3">
        <a class="btn btn--ink" href="<?= e(svc_contact_url([], null, 'technology-intelligence')) ?>">Start a technology brief <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out" href="#composer">Compose your platform <span class="i" aria-hidden="true">›</span></a>
      </div>
      <dl class="tih-hero__proof tih-hero__up" style="--i:4">
        <div><dt>Capabilities</dt><dd><?= count($TI) ?></dd></div>
        <div><dt>Scope</dt><dd>Discovery → run</dd></div>
        <div><dt>Delivery</dt><dd>AI-native</dd></div>
      </dl>
    </div>

    <div class="tih-hero__vis">
      <!-- PLACEHOLDER: reference photograph (Unsplash) — replace with commissioned/own imagery before launch -->
      <figure class="bdh-img tih-hero__photo" aria-hidden="true">
        <img src="<?= xe_url('assets/imgs/tech/hub/hero-tower.jpg') ?>" alt="" width="640" height="800" decoding="async">
      </figure>

      <p class="bdh-sr">A live topology of Your platform in four layers: <?= e(implode('; ', $hero_sr_layers)) ?>. Requests travel between the capabilities while an illustrative status bar reports p95 latency of 212 milliseconds, 148 of 148 evals passing, 71 percent of the error budget left and 0.18 grams of CO2e per request.</p>

      <div class="tih-hero__panel tih-on-ink" aria-hidden="true" data-bdh-in>
        <div class="tih-hero__bar">
          <span class="bdh-ui__dots"><i></i><i></i><i></i></span>
          <span class="tih-hero__title">control-plane <i>/</i> your-platform</span>
          <span class="tih-hero__env">prod · in-region</span>
          <span class="tih-hero__ill">Illustrative</span>
          <span class="tih-live"><i class="bdh-pulse"></i>Live</span>
        </div>

        <div class="tih-hero__map">
          <div class="tih-stage tih-hero__stage">
            <svg viewBox="0 0 1000 <?= $hero_stage_h ?>" focusable="false">
              <?php $hero_li = 0; foreach ($TIH['layers'] as $hero_lk => $hero_l): ?>
                <rect class="tih-hero__band<?= $hero_li % 2 ? ' is-alt' : '' ?>" x="0" y="<?= $hero_l['y'] - 80 ?>" width="1000" height="160" rx="14"/>
              <?php $hero_li++; endforeach; ?>
              <g class="tih-hero__edges bdh-draw">
                <?php foreach ($TIH['edges'] as $hero_ei => $hero_e): ?>
                  <path class="tih-hero__edge" d="<?= e($hero_e[2]) ?>" pathLength="1" style="--i:<?= $hero_ei * 2 + 4 ?>"/>
                <?php endforeach; ?>
              </g>
              <g class="tih-hero__pks">
                <?php foreach ($TIH['edges'] as $hero_ei => $hero_e): ?>
                  <path class="tih-hero__pk" d="<?= e($hero_e[2]) ?>" pathLength="1" data-to="<?= e($hero_e[1]) ?>" data-edge="<?= $hero_ei ?>"/>
                <?php endforeach; ?>
              </g>
            </svg>

            <?php $hero_li = 0; foreach ($TIH['layers'] as $hero_lk => $hero_l): ?>
              <span class="tih-hero__lane" style="--y:<?= round(($hero_l['y'] - 70) / $hero_stage_h * 100, 3) ?>"><b><?= e($hero_l['code']) ?></b><?= e($hero_l['name']) ?></span>
              <?php foreach ($hero_l['caps'] as $hero_s): $hero_xy = $TIH['nodes'][$hero_s]; ?>
                <span class="tih-node tih-hero__node" data-slug="<?= e($hero_s) ?>" style="--x:<?= $hero_xy[0] / 10 ?>;--y:<?= round($hero_xy[1] / $hero_stage_h * 100, 3) ?>;--i:<?= $hero_li ?>"><b><?= e($TI[$hero_s]['n']) ?></b><span><?= e($TI[$hero_s]['short']) ?></span></span>
              <?php endforeach; ?>
            <?php $hero_li++; endforeach; ?>
          </div>
        </div>

        <p class="tih-hero__feed" data-bdh-live data-feed="<?= e(json_encode($hero_feed, JSON_UNESCAPED_UNICODE)) ?>">
          <span class="tih-hero__fp">›</span><span class="tih-hero__ft"><?= e($hero_feed[0][0]) ?></span><span class="tih-hero__fs"><?= e($hero_feed[0][1]) ?></span><span class="tih-hero__fx"><span class="tih-hero__fxt"><?= e($hero_feed[0][2]) ?></span><span class="bdh-caret"></span></span>
        </p>

        <dl class="tih-hero__status">
          <?php foreach ($hero_status as $hero_st): ?>
            <div><dt><?= e($hero_st[1]) ?></dt><dd><b data-k="<?= e($hero_st[0]) ?>"><?= e($hero_st[2]) ?></b> <?= e($hero_st[3]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
      </div>
    </div>
  </div>
</section>
