<?php /* DRAFT COPY — review before launch */
/* FAQ — the questions people actually open with, answered at discipline level. The commercial facts
   sit in a strip above the list rather than in a rail, so the answers get the full width and each one
   can end with the capability cards it touches. The core [data-acc] accordion does the work, so there
   is no faq.js; the first answer ships open and the <noscript> rule below leaves every answer open
   without JavaScript. Answers restate the positions already set out in data/campaign-content.php. */
$fq_facts = [
    ['First reply',   'One working day, from a strategist'],
    ['First call',    '45 minutes, no slide deck'],
    ['Under NDA',     'Signed before anything commercial is shared'],
    ['Outline plan',  'Scope, shape and a price range within a week'],
];
$fq_items = [
    ['Can we buy one capability on its own?',
     'Yes. Most engagements start with one: a content plan, a campaign system, a PR programme or paid media. Each is scoped and priced on its own, and built so it plugs into the rest of the loop when you are ready for the next part.',
     ['omnichannel-marketing-strategy', 'content-marketing', 'performance-marketing']],
    ['Do you write and design with AI?',
     'AI helps with research, outlines, copy variants, metadata, resizing, subtitles and translation drafts. A person writes or rewrites the substance, a named editor approves every piece, provenance is recorded against each asset, and we disclose AI assistance where a platform, a market code or your own policy requires it. Nothing publishes unreviewed.',
     ['content-marketing', 'global-content-production']],
    ['Can you guarantee coverage, rankings or a viral moment?',
     'No, and nobody honest can. Editorial decisions belong to journalists and editors, ranking systems change, and attention is not sold at a fixed price. We commit to the narrative, the evidence, the production standard, the media discipline and the measurement, and we report what landed and what did not.',
     ['public-relations', 'social-media-marketing']],
    ['Who owns the work?',
     'You do. Copy, design files, photography and licences transfer to you on delivery, with usage rights recorded per asset. Campaigns run in your own accounts, under your billing, with your data, and access is handed back in full at the end of the engagement.',
     ['global-content-production', 'performance-marketing']],
    // PLACEHOLDER: confirm typical timeframes before launch
    ['How long before any of this performs?',
     'It depends on which part. Paid media and technical fixes can move within weeks of the measurement layer being validated. Content clusters typically take three to six months to compound. Earned coverage depends on the news cycle as much as on the pitch. The first read is at day 30 and the first budget decision at day 90.',
     ['performance-marketing', 'content-marketing'], 'typical timeframes'],
    ['Can you work with our in-house team, or our existing agencies?',
     'Yes, in whichever shape helps. We often run strategy, production standards and reporting while your team publishes and replies, or take the markets and channels where you have no coverage. The operating rhythm makes the split of responsibility explicit, so nothing falls between two teams.',
     ['omnichannel-marketing-strategy', 'social-media-marketing']],
    ['How much creative do we actually need?',
     'More than most teams expect. Platforms now optimise across creative more than across audiences, so a steady supply of genuinely different concepts — not colour variants — is what moves cost per acquisition. The campaign system exists so that volume does not cost consistency.',
     ['performance-marketing', 'campaign-design-systems']],
    ['How do you handle disclosure, and what if a creator becomes a problem?',
     'Paid partnerships are labelled, with the disclosure obligation written into the brief and the contract and checked at publication rather than assumed. Brand-safety criteria, conduct clauses and a takedown route are agreed with your legal team before an activation starts, along with the escalation path.',
     ['social-influencer-activation', 'public-relations']],
];
?>
<noscript><style>.cch-fq__p{height:auto;overflow:visible}.cch-fq__plus{display:none}</style></noscript>
<section class="band cch-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
        <h2 class="h2" id="faq-t"><span class="g">Campaign &amp; Content,</span> asked directly.</h2>
      </div>
      <div>
        <p class="lead">The eight questions that come up before anyone signs anything, answered the way we would answer them on a call. Anything else, ask the strategists who would run the work.</p>
        <div class="cch-fq__act">
          <a class="btn btn--ink" href="<?= e(svc_contact_url([], null, 'campaign-content')) ?>">Ask the team <span class="i" aria-hidden="true">›</span></a>
          <a class="tl" href="#adapt">Open the adaptation engine <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>
    </div>

    <!-- PLACEHOLDER: confirm response times, the first-call format and the NDA position before launch -->
    <dl class="cch-fq__facts" data-rv data-rv-d="40">
      <?php foreach ($fq_facts as $fq_f): ?>
        <div><dt><?= e($fq_f[0]) ?></dt><dd><?= e($fq_f[1]) ?></dd></div>
      <?php endforeach; ?>
    </dl>

    <div class="cch-fq__list" data-acc data-rv data-rv-d="80">
      <?php foreach ($fq_items as $fq_i => $fq_q): $fq_open = $fq_i === 0; ?>
        <?php if (!empty($fq_q[3])): ?><!-- PLACEHOLDER: confirm <?= e($fq_q[3]) ?> before launch --><?php endif; ?>
        <div class="cch-fq__row">
          <h3 class="cch-fq__hq">
            <button class="cch-fq__q" type="button" data-acc-b aria-expanded="<?= $fq_open ? 'true' : 'false' ?>" aria-controls="faq-a<?= $fq_i ?>" id="faq-q<?= $fq_i ?>">
              <span class="cch-fq__n" aria-hidden="true"><?= str_pad((string) ($fq_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <span class="cch-fq__t"><?= e($fq_q[0]) ?></span>
              <span class="cch-fq__plus" aria-hidden="true"></span>
            </button>
          </h3>
          <div class="cch-fq__p<?= $fq_open ? ' is-open' : '' ?>" id="faq-a<?= $fq_i ?>" role="region" aria-labelledby="faq-q<?= $fq_i ?>" data-acc-p>
            <div class="cch-fq__a">
              <p><?= e($fq_q[1]) ?></p>
              <p class="cch-fq__rel">
                <span class="cch-k">Covered by</span>
                <?php foreach ($fq_q[2] as $fq_s): $fq_c = $CAPS[$fq_s]; ?>
                  <a class="cch-capl" href="#<?= e($fq_s) ?>"><b><?= e($fq_c['n']) ?></b><?= e($fq_c['short']) ?><i aria-hidden="true">›</i></a>
                <?php endforeach; ?>
              </p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
