<?php /* DRAFT COPY — review before launch */
/* FAQ — the questions procurement and engineering actually ask before signing a support agreement.
   The five from data/technology-intelligence.php come first, then two this page owes the reader:
   what happens when a vendor changes an API, and how the relationship ends. Native <details> with
   an exclusive name, so the accordion needs no JS and stays keyboard- and screen-reader-correct.
   The first panel is open so the section never reads as an empty list. */

$tis_fq_extra = [
    ['What happens when a vendor changes their API?',
     'Vendor changelogs and deprecation notices are monitored for every connector we run, and contract tests run against their sandbox in CI. A breaking change shows up as a failing pipeline with the affected consumers listed, which gives us the deprecation window to migrate rather than an outage to explain. Where a vendor gives no notice, the connector fails closed into the dead-letter queue and replays once the fix ships, so nothing is lost.'],
    ['Can we end the support agreement?',
     'Yes. Support runs on a rolling term with a notice period agreed in the contract, and it is designed to be leavable: the connectors, infrastructure definitions, tests, dashboards and runbooks are in your repositories throughout, and credentials are in your vault. Handover is a scheduled piece of work, not a negotiation. <!-- PLACEHOLDER: confirm notice period and handover terms before launch -->'],
];

$tis_fq_items = [];
foreach ($CAP['faq'] as $tis_fq_q) { $tis_fq_items[] = [$tis_fq_q[0], $tis_fq_q[1], false]; }
foreach ($tis_fq_extra as $tis_fq_q) { $tis_fq_items[] = [$tis_fq_q[0], $tis_fq_q[1], true]; }

/* Short tag beside each question, so the list is scannable before anything is opened. */
$tis_fq_tag = ['Approach', 'Service levels', 'Onboarding', 'Incidents', 'Retainer', 'Change', 'Exit'];
?>
<section class="band tis-fq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">

    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tis-kick"><b>$ ask --plainly</b> <span>seven answers, before the contract</span></p>
        <h2 class="h2" id="faq-t"><span class="g">Integration and support,</span> asked directly.</h2>
      </div>
      <div>
        <p class="lead">The questions that decide whether an integration programme is worth starting. If yours is not here, put it in the brief and we will answer it in writing before any commercial conversation.</p>
      </div>
    </div>

    <div class="tis-fq__grid">

      <div class="tis-fq__list" data-rv>
        <?php foreach ($tis_fq_items as $tis_fq_i => $tis_fq_it): ?>
          <details class="tis-fq__item" name="tis-faq"<?= $tis_fq_i === 0 ? ' open' : '' ?>>
            <summary class="tis-fq__q">
              <span class="tis-fq__n"><?= e(sprintf('%02d', $tis_fq_i + 1)) ?></span>
              <span class="tis-fq__qt"><?= e($tis_fq_it[0]) ?></span>
              <?php if (isset($tis_fq_tag[$tis_fq_i])): ?>
                <span class="tis-fq__tag"><?= e($tis_fq_tag[$tis_fq_i]) ?></span>
              <?php endif; ?>
              <span class="tis-fq__mk" aria-hidden="true"><i></i><i></i></span>
            </summary>
            <div class="tis-fq__a">
              <p><?= $tis_fq_it[2] ? $tis_fq_it[1] : e($tis_fq_it[1]) ?></p>
            </div>
          </details>
        <?php endforeach; ?>
      </div>

      <aside class="tis-fq__side" data-rv aria-labelledby="faq-side-t">
        <div class="tis-fq__card">
          <span class="tis-fq__cardi" aria-hidden="true"><?= xt_icon('headset', ['size' => 22]) ?></span>
          <h3 class="bdh-t" id="faq-side-t">Ask about your own estate</h3>
          <p class="bdh-d">Send the list of systems you run and where data is copied by hand. You get back a first read on the integration map, the pattern we would use for each flow, and what support would need to cover.</p>
          <a class="btn btn--ink tis-fq__cta" href="<?= xe_url('contact.php') ?>"><?= e($CAP['cta']) ?></a>
          <p class="tis-fq__fine">No obligation, and nothing in the first read is chargeable.
            <!-- PLACEHOLDER: confirm scope of the free first read before launch --></p>
        </div>

        <!-- The page's own answers, not the hero's three lines again: what a reader at the bottom
             of the page would want summarised before they write to us. -->
        <!-- PLACEHOLDER: confirm the plan names, coverage windows and response targets quoted here before launch -->
        <ul class="tis-fq__facts" role="list">
          <?php foreach ([
            ['Support plans',      'Essential · Business · Critical'],
            ['Coverage',           'Mon–Fri 09:00–18:00 IST, up to 24×7'],
            ['P1 first response',  '30 minutes to 4 business hours'],
            ['MTTA target',        '15 minutes on a priority one'],
            ['Connectors mapped',  '31 systems, with their vendor limits'],
          ] as $tis_fq_f): ?>
            <li>
              <span class="tis-fq__fk"><?= e($tis_fq_f[0]) ?></span>
              <span class="tis-fq__fv"><?= e($tis_fq_f[1]) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>

        <ul class="xt-badges tis-fq__badges" role="list">
          <?php foreach (['iso27001', 'soc2', 'iso22301'] as $tis_fq_b): ?>
            <?= xt_badge($tis_fq_b, ['tag' => 'li', 'variant' => 'chip']) ?>
          <?php endforeach; ?>
        </ul>
        <p class="tis-fq__bnote">Frameworks we align delivery with. Controls are built into the integration and support model; they are not a claim that Xterra Edze itself is certified.
          <!-- PLACEHOLDER: confirm any certification claim before launch --></p>
      </aside>

    </div>

  </div>
</section>
