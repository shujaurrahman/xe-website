<?php /* DRAFT COPY — review before launch */
/* Quality — the four bars written into acceptance criteria, then the checks that enforce them on every
   change. The table is the part people ask for: what runs, who runs it, when, and whether it stops the
   merge. Standards here are frameworks delivery is built to, never certifications held. */
$q_checks = [
  // [check, what it proves, who runs it, when, blocks?]
  ['Unit and contract tests', 'The change does what the criteria say, and nothing else broke.', 'code.pair writes them · CI runs them', 'Every commit', 'yes'],
  ['Performance budgets', 'LCP, INP, CLS and bundle size stay inside the budget on a throttled profile.', 'CI', 'Every pull request', 'yes'],
  ['Automated accessibility checks', 'Contrast, target size, labels and focus order on every changed view.', 'make.variants · axe in CI', 'Every commit', 'yes'],
  ['The eval suite', 'The AI route still answers the golden set at the agreed thresholds.', 'guard.release', 'Every change to a prompt, model or retrieval', 'yes'],
  ['Security scans', 'No known critical dependency, container, image or secret issue.', 'guard.release', 'Every commit', 'yes'],
  ['Prompt-injection suite', 'OWASP LLM01 cases are refused rather than followed.', 'guard.release', 'Every AI release', 'yes'],
  ['Human code review', 'A named person understands the change and signs for it.', 'A named engineer', 'Every merge', 'yes'],
  ['Keyboard and screen-reader pass', 'The key journeys work without a mouse and read correctly.', 'Accessibility reviewer', 'Every release', 'partial'],
  ['Content and claims review', 'Nothing is published that we cannot source.', 'Your brand or legal reviewer', 'Before publication', 'yes'],
];
$q_blocks = ['yes' => ['Blocks the merge', 'is-yes'], 'partial' => ['Blocks the key journeys', 'is-part']];
?>
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

    <div class="apr-q__checks">
      <div class="apr-q__ch">
        <p class="apr-k">How the bars are enforced</p>
        <h3 class="apr-q__h">Nine checks on every change, not an audit at the end</h3>
        <p class="apr-q__hd">A bar that is only measured before launch is a hope. These run on the change itself, and eight of the nine stop the merge when they fail.</p>
      </div>
      <div class="bdh-scroll-x mask-x apr-nomask" tabindex="0" role="region" aria-labelledby="apr-q-chk">
        <table class="apr-q__tbl">
          <caption class="apr-k" id="apr-q-chk">Every check that runs on a change</caption>
          <thead><tr><th scope="col">Check</th><th scope="col">What it proves</th><th scope="col">Who runs it</th><th scope="col">When</th><th scope="col">If it fails</th></tr></thead>
          <tbody>
            <?php foreach ($q_checks as $q_c): ?>
            <tr>
              <th scope="row"><?= e($q_c[0]) ?></th>
              <td><?= e($q_c[1]) ?></td>
              <td class="apr-q__who"><?= e($q_c[2]) ?></td>
              <td class="apr-q__when"><?= e($q_c[3]) ?></td>
              <td><span class="apr-q__blk <?= e($q_blocks[$q_c[4]][1]) ?>"><?= e($q_blocks[$q_c[4]][0]) ?></span></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <p class="apr-q__dod"><span class="apr-k">Definition of done</span>Written into the acceptance criteria in Define, not agreed afterwards: the feature works, the tests and evals pass, the budgets hold, the scans are clean, a person has reviewed it, the runbook is updated, and the words have been read by whoever answers for them.</p>
    </div>
  </div>
</section>
