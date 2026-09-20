<?php /* DRAFT COPY — review before launch */
/* FAQ — the five questions from $CAP['faq'], plus the four that come up in every audit scoping call.
   Native <details> so every answer is in the page and reachable by keyboard without script; the
   motion is the disclosure itself. The aside carries the direct route to a person. */
$taa_fq_d = $CAP['faq'];
$taa_fq = [
    ['Method',          $taa_fq_d[0][0], $taa_fq_d[0][1]],
    ['Access',          $taa_fq_d[1][0], $taa_fq_d[1][1]],
    ['Safety', 'Will it disrupt production?',
        'No. Collection is read-only, scans are rate-limited and anything that generates load is scheduled with your team. Load tests and active security testing run against a non-production environment, or inside a window you agree in writing. If a check could affect a live service, it does not run until someone on your side has said yes.'],
    ['Independence',    $taa_fq_d[2][0], $taa_fq_d[2][1]],
    ['Security testing','Is a penetration test included?',
        'A security audit tests the application and the cloud posture against the OWASP Top 10, OWASP ASVS and CIS Benchmarks, under signed rules of engagement, and rates what it finds with CVSS v3.1. A formal penetration test with an attestation letter for a customer or an insurer is a separate engagement. Certificates and attestations of that kind come from accredited bodies, never from us.'],
    ['Vendors',         'Can you audit a system another vendor built?',
        'Yes, and most audits are. We need read access and whatever documentation survived the build. Findings describe the system, not the supplier, and each one is written with reproduction steps and an acceptance test so it can be handed to that supplier as a work order rather than an argument.'],
    ['Numbers',         'How do you put a number on a finding?',
        'Revenue items use your own analytics: affected sessions, conversion rate, average order value and the uplift the fix is modelled to return. Waste items come off the cloud bill and the tooling spend. Risk items are not priced — they are rated by severity and likelihood, because a breach is a probability, not a monthly line. Every input is visible in the model and you can change any of them.'],
    ['After the audit', $taa_fq_d[3][0], $taa_fq_d[3][1]],
    ['Scope',           $taa_fq_d[4][0], $taa_fq_d[4][1]],
];
?>
<section class="band taa-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">

    <header class="taa-head taa-head--wide" data-rv>
      <div class="taa-head__t">
        <p class="taa-kick"><span class="taa-kick__ref">12</span><span>Asked directly</span></p>
        <h2 class="h2" id="faq-t"><span class="g">Audits and assessments,</span> asked directly.</h2>
      </div>
      <div class="taa-head__l">
        <p class="lead">The questions that come up in every scoping call, answered the way we would answer them on the call.</p>
      </div>
    </header>

    <div class="taa-fq">
      <ul class="taa-fq__list" role="list">
        <?php foreach ($taa_fq as $taa_fqi => $taa_fqq): ?>
          <li class="taa-fq__i">
            <details<?= $taa_fqi === 0 ? ' open' : '' ?>>
              <summary>
                <span class="taa-fq__ix taa-id"><?= sprintf('%02d', $taa_fqi + 1) ?></span>
                <h3 class="taa-fq__q"><?= e($taa_fqq[1]) ?></h3>
                <span class="taa-fq__tag"><?= e($taa_fqq[0]) ?></span>
                <span class="taa-fq__mk" aria-hidden="true"><i></i><i></i></span>
              </summary>
              <div class="taa-fq__a">
                <p><?= e($taa_fqq[2]) ?></p>
              </div>
            </details>
          </li>
        <?php endforeach; ?>
      </ul>

      <aside class="taa-fq__side" aria-labelledby="faq-ask-t">
        <div class="taa-fq__card">
          <span class="taa-fq__ci"><?= xt_icon('chat', ['size' => 22]) ?></span>
          <p class="taa-lbl" id="faq-ask-t">Not answered here</p>
          <p class="taa-fq__cl">Send the system, the deadline and the decision the audit has to inform. You get a scope, a length and a price — or an honest note that an audit is not what you need yet.</p>
          <a class="btn btn--ink" href="<?= xe_url('contact.php') ?>"><?= e($CAP['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
          <!-- PLACEHOLDER: confirm response time before launch -->
          <p class="taa-ro taa-fq__cr">Scoping call · 30 minutes · no obligation</p>
        </div>

        <div class="taa-fq__topics">
          <p class="taa-lbl">On this page</p>
          <ul role="list">
            <?php foreach ($taa_fq as $taa_fqt): ?><li class="taa-pill"><?= e($taa_fqt[0]) ?></li><?php endforeach; ?>
          </ul>
        </div>
      </aside>
    </div>

  </div>
</section>
