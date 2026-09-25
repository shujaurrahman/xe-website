<?php /* DRAFT COPY — review before launch */
/* Markets — the second axis nobody budgets for. The same sector is not the same programme in India,
   the EU and the United States: the instrument changes, the evidence changes, and sometimes the
   journey has to change with it. Three markets because those are the three we are asked about; the
   method is the same anywhere, and the instruments are looked up, never assumed. */
$mkt_codes = ['India' => 'IN', 'European Union' => 'EU', 'United States' => 'US'];
?>
<section class="band band--alt ind-mkt" id="markets" aria-labelledby="markets-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Same sector, different market</p>
        <h2 class="h2" id="markets-t"><span class="g">A category is not a jurisdiction.</span> Crossing a border rewrites the brief.</h2>
      </div>
      <div>
        <p class="lead">Most programmes we are asked to run span at least two of these three. The discipline mix barely moves; the instruments, the evidence and often one step of the journey do.</p>
      </div>
    </div>

    <div class="ind-mkt__top" data-rv data-rv-d="60">
      <!-- PLACEHOLDER: reference photograph (Unsplash) — replace with commissioned/own imagery before launch -->
      <figure class="bdh-img bdh-img--r45 ind-mkt__img" data-bdh-parallax="0.05">
        <img src="<?= e($BASE) ?>assets/imgs/industries/markets-crowd.jpg" alt="A dense crowd of people crossing a city intersection, seen from above" width="800" height="1200" loading="lazy" decoding="async">
        <span class="bdh-cap-chip ind-mkt__chip"><b>The market is the constraint</b>The same product, three sets of rules about how it may be described, sold and measured</span>
      </figure>
      <div class="ind-mkt__intro">
        <div class="ind-mkt__pair">
          <div>
            <p class="ind-k">What changes at the border</p>
            <ul class="bdh-bullets">
              <li>The instrument. A claim cleared under the ASCI code is not cleared under EU health-claim authorisation.</li>
              <li>The lawful basis and the evidence. DPDP records a consent; GDPR wants a basis, a retention period and, for high-risk processing, a DPIA.</li>
              <li>The journey itself. Price display, cooling-off and authentication rules change what a screen has to contain and in what order.</li>
              <li>Who answers. Some markets require a named contact or representative in-country before you may process at all.</li>
            </ul>
          </div>
          <div>
            <p class="ind-k">What does not change</p>
            <ul class="bdh-bullets">
              <li>The brand system, the design system and the component library.</li>
              <li>The approval trail: evidence, a named reviewer, a log of what was published and when.</li>
              <li>Accessibility, performance and security budgets — we hold one standard everywhere.</li>
              <li>The number we are judged on, and the definition written down before the work starts.</li>
            </ul>
          </div>
        </div>
        <p class="ind-note">A summary for orientation, not legal advice. In every market the instruments are confirmed with your counsel before a journey is designed against them.</p>
      </div>
    </div>

    <ul class="ind-mkt__list" data-rv-s data-rv-step="60">
      <?php foreach ($IND as $mkt_s): ?>
        <li class="ind-plate ind-mkt__plate">
          <p class="ind-plate__h"><span class="ind-plate__n"><?= e($mkt_s['n']) ?></span><a class="ind-mkt__pn" href="#<?= e($mkt_s['id']) ?>"><?= e($mkt_s['name']) ?></a></p>
          <div class="ind-plate__b">
            <dl class="ind-mkt__rows">
              <?php foreach ($mkt_s['markets'] as $mkt_m): ?>
                <div>
                  <dt><span class="ind-mkt__code" aria-hidden="true"><?= e($mkt_codes[$mkt_m[0]] ?? '') ?></span><?= e($mkt_m[0]) ?></dt>
                  <dd><?= e($mkt_m[1]) ?></dd>
                </div>
              <?php endforeach; ?>
            </dl>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
