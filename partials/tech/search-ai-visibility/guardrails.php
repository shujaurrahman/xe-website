<?php /* DRAFT COPY — review before launch */
/* Guardrails (paper) — 09 · the rules we work inside.
   Left: the quality gate, in two halves. Six checks every page passes before it publishes, and
   five things we will not do to move a number. Right: the published rulebooks these gates come
   from, and the frameworks we align delivery with, as kit badges. Below: the sustainability line,
   because a lean, deduplicated site wastes less crawling and less transfer.
   Badges name frameworks, not certificates held by Xterra Edze. The marks are drawn by the kit and
   are never an official logo. */

/* [name, detail] */
$tsv_gr_pass = [
    ['Crawlable and indexable',
     'Returns 200, canonicals point at themselves, no stray noindex, and the URL is in the sitemap we submit.'],
    ['Accessible to WCAG 2.2 AA',
     'Real heading order, labelled controls, visible focus and a keyboard path. The structure that helps a screen reader is the structure a parser reads.'],
    ['Inside the Core Web Vitals good band',
     'LCP ≤ 2.5 s, INP ≤ 200 ms and CLS ≤ 0.1, measured at the 75th percentile of real visits.'],
    ['Structured data that matches the page',
     'Schema.org JSON-LD describing content a visitor can actually see, validated before release and re-validated in the build.'],
    ['A named author and a review date',
     'Someone is accountable for every claim on the page, with sources linked and the date it was last checked.'],
    ['Consent before measurement',
     'Analytics and advertising tags fire after consent under the GDPR and the India DPDP Act 2023. Search Console reporting is unaffected, because it does not depend on a tag.'],
];

/* [name, detail] */
$tsv_gr_never = [
    ['No cloaking',
     'A crawler and a person get the same page. Serving different content by user agent breaks the spam policies, and it is detectable.'],
    ['No scaled content abuse',
     'No mass-generated pages pushed live without an editor. Agents draft briefs and check claims against sources; a person decides what publishes.'],
    ['No bought or exchanged links',
     'Coverage is earned or it is not pursued. Anything paid for carries rel="sponsored", and we say so in the report.'],
    ['No markup for content that is not there',
     'No invented reviews, no FAQ markup for questions the page does not answer, no ratings nobody gave.'],
    ['No promises we do not control',
     'Search engines and model providers decide what ranks and what gets cited. We commit to the work, the baseline and the reporting.'],
];

/* [icon, name, what it governs, our reading] */
$tsv_gr_books = [
    ['doc', 'Google Search Essentials', 'Technical requirements, spam policies and guidance on helpful, people-first content.',
     'It is the published contract for appearing in Google Search, and Google states that no extra markup is needed to be eligible for its AI features beyond it. It changes, so we re-read it and re-check the site against it.'],
    ['cube', 'Schema.org', 'The shared vocabulary search engines and assistants read for entities, products, articles and FAQs.',
     'We write JSON-LD to the vocabulary and treat eligibility as eligibility: valid structured data makes a rich result possible, never certain.'],
];

$tsv_gr_badges = $CAP['standards'] ?? ['cwv', 'wcag22', 'gdpr', 'dpdp'];
if (!in_array('sci', $tsv_gr_badges, true)) { $tsv_gr_badges[] = 'sci'; }

/* [icon, title, detail] */
$tsv_gr_lean = [
    ['pipeline', 'Redirect chains collapsed', 'One hop, 301, then stop. Every extra hop is a request that renders nothing for anyone.'],
    ['filter', 'Duplicate and parameter URLs consolidated', 'Crawl effort goes to pages that have a reader, not to eleven addresses for the same one.'],
    ['gauge', 'Page weight budgeted per template', 'A budget agreed at design time and checked in the build, so a page cannot quietly double in size.'],
];
?>
<section class="band tsv-rules" id="guardrails" aria-labelledby="guardrails-t">
  <div class="wrap">

    <header class="tsv-head" data-rv>
      <div class="tsv-head__t">
        <p class="tsv-kick"><span class="tsv-kick__ref">09 · Guardrails</span><span>Published rules · quality gate</span></p>
        <h2 class="h2" id="guardrails-t"><span class="g">Rules</span> we play by.</h2>
      </div>
      <div class="tsv-head__l">
        <p class="lead">Most of the damage we are asked to repair was not caused by a missing tactic. It was caused by a shortcut somebody took two years ago. We work inside the published rules and keep the evidence.</p>
      </div>
    </header>

    <div class="tsv-rules__g">

      <div class="tsv-rules__gate" data-tsv-rules data-rv>
        <div class="tsv-gates">
          <div class="tsv-gates__hd">
            <h3 class="tsv-gates__t">Every page passes these gates</h3>
            <p class="tsv-ro"><b><?= count($tsv_gr_pass) ?></b> checks · before publish</p>
          </div>
          <ul class="tsv-gate" role="list">
            <?php foreach ($tsv_gr_pass as $tsv_gpi => $tsv_gp): ?>
              <li class="tsv-gate__i" style="--i:<?= $tsv_gpi ?>">
                <span class="tsv-gate__m" aria-hidden="true">
                  <svg viewBox="0 0 18 18" fill="none" focusable="false"><path d="M4.4 9.3 7.5 12.4 13.6 5.9" pathLength="1"></path></svg>
                </span>
                <span class="tsv-gate__x">
                  <b><?= e($tsv_gp[0]) ?></b>
                  <small><?= e($tsv_gp[1]) ?></small>
                </span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="tsv-gates tsv-gates--no">
          <div class="tsv-gates__hd">
            <h3 class="tsv-gates__t">Lines we do not cross</h3>
            <p class="tsv-ro"><b><?= count($tsv_gr_never) ?></b> refusals · whoever asks</p>
          </div>
          <ul class="tsv-gate" role="list">
            <?php foreach ($tsv_gr_never as $tsv_gni => $tsv_gn): ?>
              <li class="tsv-gate__i" style="--i:<?= $tsv_gni + count($tsv_gr_pass) ?>">
                <span class="tsv-gate__m" aria-hidden="true">
                  <svg viewBox="0 0 18 18" fill="none" focusable="false"><path d="M5.6 5.6 12.4 12.4" pathLength="1"></path><path d="M12.4 5.6 5.6 12.4" pathLength="1"></path></svg>
                </span>
                <span class="tsv-gate__x">
                  <b><?= e($tsv_gn[0]) ?></b>
                  <small><?= e($tsv_gn[1]) ?></small>
                </span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <div class="tsv-rules__side">
        <div class="tsv-books" data-rv>
          <h3 class="tsv-rules__st">The rulebooks</h3>
          <ul class="tsv-books__l" role="list">
            <?php foreach ($tsv_gr_books as $tsv_gb): ?>
              <li class="tsv-book">
                <span class="tsv-book__i" aria-hidden="true"><?= xt_icon($tsv_gb[0], ['size' => 18]) ?></span>
                <h4 class="tsv-book__t"><?= e($tsv_gb[1]) ?></h4>
                <p class="tsv-book__g"><?= e($tsv_gb[2]) ?></p>
                <p class="tsv-book__d"><?= e($tsv_gb[3]) ?></p>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="tsv-frames" data-rv>
          <h3 class="tsv-rules__st">Frameworks we align delivery with</h3>
          <ul class="xt-badges tsv-frames__l" role="list">
            <?php foreach ($tsv_gr_badges as $tsv_gk): ?>
              <?= xt_badge($tsv_gk, ['tag' => 'li', 'detail' => true]) ?>
            <?php endforeach; ?>
          </ul>
          <p class="tsv-ro tsv-frames__n">These are the frameworks the work is built to. Certification, where a standard offers it, is issued by an accredited body and never by us.</p>
        </div>
      </div>

    </div>

    <div class="tsv-lean">
      <div class="tsv-lean__hd" data-rv>
        <span class="tsv-lean__i" aria-hidden="true"><?= xt_icon('leaf', ['size' => 20]) ?></span>
        <h3 class="tsv-lean__t">Lean pages, clean crawl paths</h3>
        <p class="tsv-lean__l">A site that serves one URL per thing, in one hop, at a sensible weight is cheaper to crawl, cheaper to serve and faster for the person reading it. The same three fixes do all three jobs.</p>
      </div>
      <ul class="tsv-lean__l3" role="list" data-rv data-bdh-stagger>
        <?php foreach ($tsv_gr_lean as $tsv_gl): ?>
          <li class="tsv-lean__c">
            <span class="tsv-lean__ci" aria-hidden="true"><?= xt_icon($tsv_gl[0], ['size' => 18]) ?></span>
            <h4 class="tsv-lean__ct"><?= e($tsv_gl[1]) ?></h4>
            <p class="tsv-lean__cd"><?= e($tsv_gl[2]) ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
      <p class="tsv-note tsv-lean__n">
        <?= xt_icon('leaf', ['size' => 18]) ?>
        <span><b>What we can honestly claim.</b> The Software Carbon Intensity specification scores a system as SCI = ((E × I) + M) per R: energy multiplied by the carbon intensity of the electricity that supplied it, plus embodied emissions, for each unit of work. Removing wasted crawls and trimming page weight lowers E and the number of requests. It does not change I or M, so those stay out of anything we report.</span>
      </p>
    </div>

  </div>
</section>
