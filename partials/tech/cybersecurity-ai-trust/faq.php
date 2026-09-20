<?php /* DRAFT COPY — review before launch */
/* TM-12 FAQ — the questions that decide whether a security engagement starts, answered without
   hedging. Five come from data/technology-intelligence.php so the hub and this page never disagree;
   three more are specific to this page's subject matter. core.js drives the accordion ([data-acc]). */

$tscf_rows = $CAP['faq'];
$tscf_rows[] = ['What does CERT-In require of us?',
    'The CERT-In Directions of 28 April 2022 require specified cyber incidents to be reported within six hours of noticing them, ICT system logs to be maintained for a rolling 180 days within India, clocks synchronised to NTP sources, and a named point of contact on file. We wire the clock, the log retention tiers and the reporting template into the incident runbook, so the deadline is met by a process rather than by whoever is awake.'];
$tscf_rows[] = ['Is our data used to train models?',
    'Not by us. Where a model provider is involved we select the enterprise terms that exclude your data from training, set retention to zero or the minimum the API allows, and keep the configuration as evidence. Anything used for fine-tuning is agreed in writing first, inventoried, and given its own retention and deletion rule.'];
$tscf_rows[] = ['Can you test without taking production down?',
    'Yes. Scope, rate limits, test windows and a stop condition are agreed before anything runs. Destructive and load-based cases go against a production-like environment, and a named contact on each side can halt a test within minutes. Findings are proven with a reproducible proof of concept, never with an outage.'];
?>
<section class="band tsc-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="tsc-fq">
      <aside class="tsc-fq__side" data-rv>
        <p class="tsc-ref"><b>TM-12</b><span>Asked directly</span></p>
        <h2 class="h2 tsc-fq__h" id="faq-t"><span class="g">Cybersecurity &amp; AI Trust,</span> asked directly.</h2>
        <p class="lead tsc-fq__lead">Straight answers, including the ones that are inconvenient for us to give. If a question below is the one blocking your decision, it is worth a call rather than a form.</p>
        <div class="tsc-fq__cta">
          <a class="btn btn--ink btn--lg" href="<?= e(xe_url('contact.php')) ?>?from=cybersecurity-ai-trust"><?= e($CAP['cta']) ?></a>
          <p class="tsc-fq__cw">We will tell you in the first conversation if what you need is smaller, cheaper or outside our scope.</p>
        </div>
        <ul class="xt-badges tsc-fq__badges" role="list" aria-label="Frameworks we align delivery with">
          <?php foreach (['iso27001', 'soc2', 'owasp-llm', 'cert-in'] as $tscf_b): ?><?= xt_badge($tscf_b, ['tag' => 'li', 'variant' => 'chip']) ?><?php endforeach; ?>
        </ul>
      </aside>

      <ol class="tsc-fq__list" data-acc data-rv-s data-rv-step="50">
        <?php foreach ($tscf_rows as $tscf_i => $tscf_q): ?>
          <li class="tsc-fq__row" style="--i:<?= $tscf_i ?>">
            <h3 class="tsc-fq__q">
              <button type="button" data-acc-b aria-expanded="<?= $tscf_i === 0 ? 'true' : 'false' ?>" aria-controls="faq-p<?= $tscf_i ?>" id="faq-b<?= $tscf_i ?>">
                <span class="tsc-fq__n tsc-mono"><?= str_pad((string) ($tscf_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                <span class="tsc-fq__qt"><?= e($tscf_q[0]) ?></span>
                <span class="tsc-fq__pm" aria-hidden="true"></span>
              </button>
            </h3>
            <div class="tsc-fq__p" id="faq-p<?= $tscf_i ?>" role="region" aria-labelledby="faq-b<?= $tscf_i ?>" data-acc-p>
              <p class="tsc-fq__a"><?= e($tscf_q[1]) ?></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>
