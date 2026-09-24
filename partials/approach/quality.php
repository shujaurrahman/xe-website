<?php /* DRAFT COPY — review before launch */ ?>
<section class="band band--alt apr-q" id="quality" aria-labelledby="quality-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Quality bars</p>
        <h2 class="h2" id="quality-t"><span class="g">Numbers, not adjectives.</span> The bars every release clears.</h2></div>
      <div><p class="lead">Written into acceptance criteria and checked by evals on every change. These are frameworks we build to, not certifications we hold.</p></div>
    </div>
    <div class="apr-q__grid">
      <article class="apr-qc apr-qc--cwv">
        <p class="apr-qc__k"><?= xt_icon('gauge') ?> Performance · Core Web Vitals</p>
        <h3 class="apr-qc__t">“Good” at the 75th percentile of real visits</h3>
        <ul class="apr-meter">
          <li><span class="apr-meter__n">LCP</span><span class="apr-meter__bar"><i style="--v:.62"></i></span><b>≤ 2.5 s</b><small>Largest Contentful Paint · loading</small></li>
          <li><span class="apr-meter__n">INP</span><span class="apr-meter__bar"><i style="--v:.4"></i></span><b>≤ 200 ms</b><small>Interaction to Next Paint · responsiveness</small></li>
          <li><span class="apr-meter__n">CLS</span><span class="apr-meter__bar"><i style="--v:.4"></i></span><b>≤ 0.1</b><small>Cumulative Layout Shift · visual stability</small></li>
        </ul>
        <p class="apr-qc__b"><?= xt_badge('cwv', ['variant' => 'chip']) ?></p>
      </article>
      <article class="apr-qc">
        <p class="apr-qc__k"><?= xt_icon('accessibility') ?> Accessibility</p>
        <h3 class="apr-qc__t">WCAG 2.2 AA, tested by tools and by people</h3>
        <ul class="apr-qc__l">
          <li><b>4.5:1</b> text contrast, 3:1 for large text and UI</li>
          <li><b>24 × 24</b> CSS px minimum targets (2.5.8)</li>
          <li><b>Focus</b> never hidden behind sticky UI (2.4.11)</li>
          <li><b>Keyboard</b> and screen-reader passes before release</li>
        </ul>
        <p class="apr-qc__b"><?= xt_badge('wcag22', ['variant' => 'chip']) ?></p>
      </article>
      <article class="apr-qc">
        <p class="apr-qc__k"><?= xt_icon('lock') ?> Security and privacy by design</p>
        <h3 class="apr-qc__t">Threat-modelled before it is built</h3>
        <ul class="apr-qc__l">
          <li><b>ASVS</b> controls chosen per risk, verified in review</li>
          <li><b>LLM01</b> prompt injection tested on every AI surface</li>
          <li><b>Data</b> minimised, purpose-bound, consent recorded (DPDP, GDPR)</li>
          <li><b>Secrets</b> scanned on every commit</li>
        </ul>
        <p class="apr-qc__b"><?= xt_badge('owasp-asvs', ['variant' => 'chip']) ?><?= xt_badge('owasp-llm', ['variant' => 'chip']) ?><?= xt_badge('dpdp', ['variant' => 'chip']) ?></p>
      </article>
      <article class="apr-qc apr-qc--sci">
        <p class="apr-qc__k"><?= xt_icon('leaf') ?> Carbon · Software Carbon Intensity</p>
        <h3 class="apr-qc__t">Measured per unit of use, then reduced</h3>
        <p class="apr-sci" aria-label="SCI equals open bracket E times I plus M close bracket per R"><span>SCI</span> = ((<b>E</b> × <b>I</b>) + <b>M</b>) per <b>R</b></p>
        <dl class="apr-sci__k">
          <div><dt>E</dt><dd>Energy used by the software, kWh</dd></div>
          <div><dt>I</dt><dd>Carbon intensity of that energy, gCO₂e/kWh</dd></div>
          <div><dt>M</dt><dd>Embodied emissions of the hardware share</dd></div>
          <div><dt>R</dt><dd>The functional unit: a visit, a call, a user</dd></div>
        </dl>
        <p class="apr-qc__b"><?= xt_badge('sci', ['variant' => 'chip']) ?></p>
      </article>
    </div>
  </div>
</section>
