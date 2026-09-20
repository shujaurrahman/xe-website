<?php /* DRAFT COPY — review before launch */
/* 12 · Websites & Apps, asked directly. A real disclosure accordion: every answer is open in the HTML, so the
   section is fully readable without JavaScript; faq.js leaves the first open and collapses the rest.
   The five approved answers from data/technology-intelligence.php come first, then two this page owes the reader:
   rebuilding without losing search, and keeping the speed after launch. */
$twa_fq_items = $CAP['faq'];
$twa_fq_items[] = [
    'Can you rebuild the site without losing our search rankings?',
    'Yes, if the migration is planned rather than discovered. Before anything ships we crawl the current site, export the URLs that earn traffic and links, and build a redirect map that is tested in CI. Titles, headings, structured data and internal links are checked for parity template by template, and the sitemap and search console are updated on release day. After launch we watch coverage, impressions and Core Web Vitals daily for the first month. Rankings usually move a little during reindexing; the point is that nothing is lost because a URL quietly disappeared.',
];
$twa_fq_items[] = [
    'How do you keep the speed after launch, when everyone starts adding things?',
    'By making weight a rule rather than an intention. Image, script and font budgets live in the repository and run on every pull request, so a change that pushes the page past its ceiling fails the build and the conversation happens before the merge, not six months later. Real-user monitoring reports Core Web Vitals at p75 by template and device, and the release guard rolls back a release that regresses interaction latency. At day 90 we review the field data with you, fix the three regressions costing the most and reset the budget for the next quarter.',
];
$twa_fq_ask = [
    ['Native, cross-platform or web?', 'mobile'],
    ['Which CMS?', 'doc'],
    ['Who owns the code?', 'key'],
    ['AI in delivery', 'agent'],
    ['After launch', 'uptime'],
    ['Search parity', 'search'],
    ['Keeping the speed', 'gauge'],
];
?>
<section class="band twa-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="twa-head" data-rv>
      <p class="twa-head__run"><b>12 · Questions</b><span>Seven answers · no hedging</span></p>
      <div class="twa-head__t">
        <h2 class="h2" id="faq-t"><span class="g">Websites &amp; Apps,</span> asked directly.</h2>
      </div>
      <div class="twa-head__l">
        <p class="lead">The questions that decide a build: what to build it on, who owns it afterwards, and what happens to the search traffic and the speed once everyone starts adding things.</p>
      </div>
    </div>

    <div class="twa-fq" data-rv>
      <ul class="twa-fq__list" role="list">
        <?php foreach ($twa_fq_items as $twa_i => $twa_q): ?>
          <li class="twa-fq__item">
            <h3 class="twa-fq__h">
              <button type="button" class="twa-fq__q" id="faq-q-<?= $twa_i ?>" aria-expanded="true" aria-controls="faq-a-<?= $twa_i ?>" data-fq-q>
                <span class="twa-fq__no" aria-hidden="true"><?= str_pad((string) ($twa_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                <span class="twa-fq__qt"><?= e($twa_q[0]) ?></span>
                <span class="twa-fq__sign" aria-hidden="true"><i></i><i></i></span>
              </button>
            </h3>
            <div class="twa-fq__a" id="faq-a-<?= $twa_i ?>" role="region" aria-labelledby="faq-q-<?= $twa_i ?>">
              <p><?= e($twa_q[1]) ?></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>

      <aside class="twa-fq__aside">
        <p class="twa-fq__ak">Jump to a question</p>
        <ul class="twa-fq__tags" role="list">
          <?php foreach ($twa_fq_ask as $twa_i => $twa_t): ?>
            <li><?= xt_icon($twa_t[1], ['size' => 15]) ?><?= e($twa_t[0]) ?></li>
          <?php endforeach; ?>
        </ul>
        <p class="twa-fq__ad">Something here that does not match your situation? Say so in the brief and we will answer it specifically rather than generally.</p>
        <a class="btn btn--ink twa-fq__cta" href="<?= e(xe_url('contact.php') . '?from=websites-apps') ?>"><?= e($CAP['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
      </aside>
    </div>
  </div>
</section>
