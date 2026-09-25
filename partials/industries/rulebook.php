<?php /* DRAFT COPY — review before launch */
/* Rulebook — the section that exists so nobody has to guess. Two parts: a grid of what applies where,
   and then, per sector, the three rulings that matter most — including one thing that explicitly does
   NOT apply. Naming a regulation that does not reach a category is a factual error, and it is the most
   common one in this kind of page, so the "not in scope" row is deliberate and says why.
   Frameworks we design and build to. Never a claim that Xterra Edze holds a certification. */
$rbk_marks = [
    'y' => ['Applies',          'Applies to a typical programme in this category.'],
    'c' => ['In defined cases', 'Applies only in the circumstances named beside the row.'],
    'n' => ['Not in scope',     'Does not reach a typical programme in this category.'],
];
$rbk_rows = [
    ['dpdp',      ['y', 'y', 'y', 'y', 'y', 'y'], 'Wherever personal data of people in India is processed. At telecom scale it usually brings the significant-data-fiduciary duties with it.', ''],
    ['gdpr',      ['c', 'c', 'c', 'c', 'c', 'c'], 'Wherever an EU resident’s data is processed — which is a question about your customers, not about where you are registered.', ''],
    ['pci-dss',   ['c', 'y', 'y', 'c', 'y', 'y'], 'Where your own systems store, process or transmit card data. Since v4 that includes every script running on a payment page, so a hosted checkout is not an automatic exemption.', ''],
    ['hipaa',     ['c', 'n', 'n', 'c', 'n', 'n'], 'Only if you handle United States patient records, or process them for someone who does.', 'It binds US covered entities and their business associates. Working in a health-adjacent category is not what triggers it, and naming it where it does not apply is a mistake, not caution.'],
    ['wcag22',    ['y', 'y', 'y', 'y', 'y', 'y'], 'Our floor everywhere. In the EU, the Accessibility Act has made it enforceable for consumer services since 28 June 2025.', ''],
    ['eu-ai-act', ['c', 'c', 'c', 'y', 'c', 'c'], 'Where an AI system is placed on the EU market or its output is used there. The risk tier, not the technology, decides the obligation.', ''],
    ['owasp-llm', ['y', 'y', 'y', 'y', 'y', 'y'], 'Applied to every assistant or agent we ship, in every category. It is a test suite, not a law.', ''],
    ['cert-in',   ['c', 'y', 'c', 'c', 'c', 'y'], 'For organisations running systems in India: specified incidents reported within six hours, logs retained 180 days in-country.', ''],
    ['soc2',      ['n', 'c', 'n', 'y', 'n', 'c'], 'When enterprise or regulated buyers make the report a condition of purchase.', 'Consumer categories are rarely asked for it. The underlying controls still shape the build; the attestation simply is not what the buyer wants.'],
];
$rbk_nlabel = ['soc2' => 'Rarely asked'];
$rbk_vcls = ['Applies' => 'y', 'Not in scope' => 'n'];
?>
<section class="band ind-rbk" id="rulebook" aria-labelledby="rulebook-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>What applies, and what does not</p>
        <h2 class="h2" id="rulebook-t"><span class="g">Half of compliance</span> is knowing what you are not subject to.</h2>
      </div>
      <div>
        <p class="lead">Rules named where they do not apply cost as much as rules missed. This grid is our working reading of which frameworks reach a typical programme in each category — and where one plainly does not, it says so.</p>
        <p class="ind-note">Orientation, not legal advice. Your counsel and compliance teams keep the judgement and the sign-off; our job is to build so their review is short.</p>
      </div>
    </div>

    <figure class="ind-rbk__wrap" data-rv data-rv-d="60">
      <figcaption class="ind-rbk__cap">
        <span class="ind-k">Applicability, by category</span>
        <span class="ind-rbk__key" aria-hidden="true">
          <?php foreach ($rbk_marks as $rbk_mk => $rbk_m): ?>
            <span><i class="ind-rbk__m ind-rbk__m--<?= e($rbk_mk) ?>"></i><?= e($rbk_m[0]) ?></span>
          <?php endforeach; ?>
        </span>
      </figcaption>
      <div class="bdh-scroll-x mask-x ind-rbk__scroll" tabindex="0" role="region" aria-label="Which frameworks apply in which sector">
        <table class="ind-ledger ind-rbk__tbl">
          <caption class="sr">For nine frameworks, whether each applies to a typical programme in each of the six sectors: applies, applies in defined cases, or not in scope.</caption>
          <thead>
            <tr>
              <th scope="col">Framework</th>
              <?php foreach ($IND as $rbk_s): ?>
                <th scope="col"><span class="ind-rbk__cn"><?= e($rbk_s['n']) ?></span><?= e($rbk_s['short']) ?></th>
              <?php endforeach; ?>
              <th scope="col" class="ind-rbk__wc">When it switches on</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rbk_rows as $rbk_r): $rbk_st = xt_standard($rbk_r[0]); ?>
              <tr>
                <th scope="row">
                  <span class="ind-rbk__fc"><?= e($rbk_st ? $rbk_st['code'] : $rbk_r[0]) ?></span>
                  <span class="ind-rbk__fk"><?= e($rbk_st ? $rbk_st['kind'] : '') ?></span>
                </th>
                <?php foreach ($IND as $rbk_ci => $rbk_s): $rbk_v = $rbk_r[1][$rbk_ci]; ?>
                  <td>
                    <i class="ind-rbk__m ind-rbk__m--<?= e($rbk_v) ?>" aria-hidden="true"></i>
                    <span class="sr"><?= e($rbk_v === 'n' && isset($rbk_nlabel[$rbk_r[0]]) ? $rbk_nlabel[$rbk_r[0]] : $rbk_marks[$rbk_v][0]) ?></span>
                  </td>
                <?php endforeach; ?>
                <td class="ind-rbk__when"><?= e($rbk_r[2]) ?><?= $rbk_r[3] !== '' ? '<span class="ind-rbk__not">' . e($rbk_r[3]) . '</span>' : '' ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <p class="ind-note ind-rbk__note"><b>Frameworks we build to.</b> Standards and codes shape how delivery works; they are not certifications Xterra Edze holds. Where a programme needs formal certification or attestation, we prepare the evidence and your independent auditor issues it.<span class="ind-rbk__swipe"> Swipe the table to read every column.</span></p>
    </figure>

    <div class="ind-rbk__scopes" data-rv data-rv-d="100">
      <div class="ind-rbk__sh">
        <h3 class="bdh-t bdh-t--l">Three rulings per category</h3>
        <p class="ind-note">The one that always applies, the one that depends on how you are built, and the one people name by habit and should not.</p>
      </div>
      <ul class="ind-rbk__plates">
        <?php foreach ($IND as $rbk_s): ?>
          <li class="ind-plate">
            <p class="ind-plate__h"><span class="ind-plate__n"><?= e($rbk_s['n']) ?></span><a class="ind-rbk__pn" href="#<?= e($rbk_s['id']) ?>"><?= e($rbk_s['name']) ?></a></p>
            <div class="ind-plate__b">
              <dl class="ind-rbk__sl">
                <?php foreach ($rbk_s['scope'] as $rbk_sc): $rbk_st = xt_standard($rbk_sc[0]); ?>
                  <div>
                    <dt>
                      <span class="ind-rbk__sn"><?= e($rbk_st ? $rbk_st['code'] : $rbk_sc[0]) ?></span>
                      <span class="ind-scope ind-scope--<?= e($rbk_vcls[$rbk_sc[1]] ?? 'c') ?>"><?= e($rbk_sc[1]) ?></span>
                    </dt>
                    <dd><?= e($rbk_sc[2]) ?></dd>
                  </div>
                <?php endforeach; ?>
              </dl>
              <div class="ind-rbk__badges">
                <span class="ind-k">Built to</span>
                <div><?php foreach ($rbk_s['badges'] as $rbk_b) echo xt_badge($rbk_b, ['variant' => 'chip']); ?></div>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
