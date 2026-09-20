<?php /* DRAFT COPY — review before launch */
/* FAQ — Technology & Intelligence, asked directly. A sticky rail on the left: the two ways forward (ask the
   team, or try the Platform Composer) and what happens when you do. An accordion on the right (core
   [data-acc]); each answer ends with the capability pages it touches, as links. faq.js is not needed: the
   core accordion does the work, and the <noscript> rule below leaves every answer open without it. */
$faq_by_n = [];
foreach ($TI as $faq_s => $faq_c) { $faq_by_n[$faq_c['n']] = $faq_s; }
/* what happens when you ask — the commercial facts people want before they write in.
   PLACEHOLDER: confirm response times, the first-call format and the NDA position before launch */
$faq_facts = [
    ['First reply',   'One working day, from an engineer'],
    ['First call',    '45 minutes, no slide deck'],
    ['Under NDA',     'Signed before anything technical is shared'],
    ['Outline plan',  'Scope, shape and a price range within a week'],
];
$faq_items = [
    ['Can we buy one capability on its own?',
     'Yes. Many engagements start with one: an audit, a single AI feature, a website or a squad. Each capability is scoped and priced on its own, and built so it plugs into the rest of the platform when you are ready.',
     ['09', '01', '04']],
    ['Which AI models do you use?',
     'The ones that win on your evals. We are model-agnostic: models from OpenAI, Anthropic, Google, Meta and Mistral, and open-weight models run in your own cloud, all sit behind one gateway and are chosen per task on quality, latency and cost. When a better or cheaper model ships, we re-run the evals and switch if it earns it.',
     ['03', '05']],
    ['Can the AI run in our cloud, or in an India region?',
     'Yes. We deploy into your AWS, Azure or Google Cloud account, including India regions, and use enterprise model endpoints with training on your data switched off. Where data may not leave your network at all, open-weight models run inside it.',
     ['05', '06']],
    ['Who owns the code, the prompts and the evals?',
     'You do. Source code, infrastructure code, prompts, eval sets and model configuration live in your repositories from the first commit, and the IP is assigned to you as it is created.',
     ['02', '10']],
    ['How do you handle security questionnaires and audits?',
     'Early and in writing. We answer your questionnaire during scoping, work under your policies, and produce the evidence your auditors ask for as part of delivery. If you are working towards ISO/IEC 27001 or SOC 2, we prepare you for the independent auditor; certificates come from them, not from us.',
     ['06', '09']],
    // PLACEHOLDER: confirm typical timeframes before launch
    ['How fast can an AI agent reach production?',
     'Typically four to eight weeks from a framed problem to production with guardrails: a prototype on your real data in days, an eval baseline in the first week, and a pilot with named users by week three. Regulated or high-risk uses take longer, because the review steps do.',
     ['03', '04', '06'], 'typical timeframes'],
    ['Do you work with our in-house team?',
     'Yes, in whichever shape helps: engineers embedded in your sprints, a squad that owns a stream of work end to end, or reviews and pairing while your team builds. Knowledge transfer is planned from the first week, not left for the last.',
     ['10', '07']],
    // PLACEHOLDER: confirm support tiers and service levels before launch
    ['What happens after launch?',
     'Either a managed service with agreed service levels, or a handover to your team with runbooks, dashboards and training. Either way, the first 90 days are reviewed against the measures we agreed before launch.',
     ['07', '10'], 'support tiers and service levels'],
];
?>
<noscript><style>.tih-faq__p{height:auto;overflow:visible}.tih-faq__plus{display:none}</style></noscript>
<section class="band band--alt tih-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap bdh-grid tih-faq__grid">
    <div class="bdh-c4 tih-faq__side">
      <div class="bdh-sticky tih-faq__head" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
        <h2 class="h2" id="faq-t"><span class="g">Technology &amp; Intelligence,</span> asked directly.</h2>
        <p class="tih-faq__more">Anything else? Ask the engineers who would run your programme, or see a plan take shape first.</p>
        <div class="tih-faq__act">
          <a class="btn btn--ink" href="<?= e(svc_contact_url([], null, 'technology-intelligence')) ?>">Ask the team <span class="i" aria-hidden="true">›</span></a>
          <a class="tl tih-faq__tl" href="#composer">Try the Platform Composer <span class="i" aria-hidden="true">›</span></a>
        </div>
        <!-- PLACEHOLDER: confirm response times, the first-call format and the NDA position before launch -->
        <dl class="tih-faq__facts">
          <?php foreach ($faq_facts as $faq_f): ?>
            <div><dt><?= e($faq_f[0]) ?></dt><dd><?= e($faq_f[1]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
      </div>
    </div>

    <div class="bdh-c7 bdh-s6 tih-faq__list" data-acc data-rv data-rv-d="80">
      <?php foreach ($faq_items as $faq_i => $faq_q): $faq_n = str_pad((string) ($faq_i + 1), 2, '0', STR_PAD_LEFT); $faq_open = $faq_i === 0; ?>
        <?php if (!empty($faq_q[3])): ?><!-- PLACEHOLDER: confirm <?= e($faq_q[3]) ?> before launch --><?php endif; ?>
        <div class="tih-faq__row">
          <h3 class="tih-faq__hq">
            <button class="tih-faq__q" type="button" data-acc-b aria-expanded="<?= $faq_open ? 'true' : 'false' ?>" aria-controls="faq-a<?= $faq_i ?>" id="faq-q<?= $faq_i ?>">
              <span class="tih-faq__n" aria-hidden="true">Q<?= $faq_n ?></span>
              <span class="tih-faq__t"><?= e($faq_q[0]) ?></span>
              <span class="tih-faq__plus" aria-hidden="true"></span>
            </button>
          </h3>
          <div class="tih-faq__p<?= $faq_open ? ' is-open' : '' ?>" id="faq-a<?= $faq_i ?>" role="region" aria-labelledby="faq-q<?= $faq_i ?>" data-acc-p>
            <div class="tih-faq__a">
              <p><?= e($faq_q[1]) ?></p>
              <?php if ($faq_q[2]): ?>
                <p class="tih-faq__rel"><span class="tih-k">Related</span><?php foreach ($faq_q[2] as $faq_rn): $faq_rs = $faq_by_n[$faq_rn]; ?><a class="tih-capl" href="<?= xe_url('services/technology-intelligence/' . $faq_rs . '.php') ?>"><b><?= e($faq_rn) ?></b><?= e($TI[$faq_rs]['short']) ?><i aria-hidden="true">›</i></a><?php endforeach; ?></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
