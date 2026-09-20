<?php /* DRAFT COPY — review before launch */
/* Hero — the search console. The breadcrumb runs along the top; the headline holds the left measure
   (cols 1–7) with the lead, the calls to action and the meta readouts bottom-aligned to its right
   (cols 9–12). Below, one buyer query is typed into a wide input and answered two ways: a generic
   ranked results page on the left, and an AI answer panel with citations on the right. The engine
   switcher is a real tablist — three buttons over three panels, wired by hero.js, which also adds a
   Pause control for the timed cycle. The ranked results half is decorative and aria-hidden, described
   by the .bdh-sr sentence at the foot; the answer half is exposed, because it is operable.
   The markup already shows the complete state; hero.js only animates it. */

$tsv_hr_q = 'best payroll software for mid-size companies in India';

/* the ranked results page — every entry is fictional. The second result carries sitelinks, which a
   commercial site can still earn; FAQ rich results are deliberately not shown here, because section
   04 states correctly that Google restricted them to government and health sites in 2023. */
$tsv_hr_serp = [   // [host, breadcrumb trail, title, snippet, is-you, sitelink rows [label, note] or []]
    ['reviewsite-b.example', 'Review site B › Buyer guides',
     'Payroll software compared: 9 platforms for 200–2,000 staff',
     'Side-by-side comparison of pricing, statutory coverage and support for growing Indian teams. Updated this month.',
     false, []],
    ['yourcompany.com', 'Your company › Payroll › Mid-size',
     'Payroll for mid-size companies in India',
     'Multi-state payroll with EPF, ESI, PT and TDS filed on time, an audit trail per run, and a finance-owned approval step before money moves.',
     true, [['Pricing', 'Per employee per month, and what changes the band'],
            ['Statutory coverage', 'EPF, ESI, professional tax and TDS, state by state'],
            ['Implementation', 'Six to twelve weeks, with a parallel run']]],
    ['tradepublication-a.example', 'Trade publication A › Finance ops',
     'What finance teams get wrong when they change payroll',
     'Six failure patterns from mid-market payroll migrations, and the checks that catch them before the first live run.',
     false, []],
];

$tsv_hr_paa = [
    'What is the best payroll software for 500 employees in India?',
    'How much does payroll software cost per employee per month?',
    'Which payroll platforms handle multi-state statutory filings?',
];

/* three engines, three generative answers. Text differs, citations differ, and only two of the three
   cite the placeholder company — that is the point the section after this one picks up. */
$tsv_hr_eng = [
    [
        'key'  => 'ao', 'name' => 'AI Overview', 'meta' => 'Google · generated answer above the results',
        'lead' => 'For teams of 200–2,000 in India, buyers shortlist on statutory coverage, multi-state payroll and a clean audit trail.',
        'body' => 'Most comparisons weigh EPF, ESI, professional tax and TDS handling first<sup>1</sup>, then look at how approvals and evidence work before money moves<sup>2</sup>. Implementation is usually quoted in weeks, not days, because payroll history has to be migrated and reconciled<sup>3</sup>.',
        'cites' => [['reviewsite-b.example', false], ['yourcompany.com', true], ['tradepublication-a.example', false]],
        'moved' => [
            ['Page',     '/payroll/mid-size-india — answers in the first fifty words'],
            ['Entity',   'Organization @id resolves; the profiles state the same facts'],
            ['Citation', 'reviewsite-b.example names you in its buyer guide'],
        ],
    ],
    [
        'key'  => 'gpt', 'name' => 'ChatGPT search', 'meta' => 'Assistant answer with linked sources',
        'lead' => 'Shortlist on compliance depth, then on how the platform proves what it did.',
        'body' => 'Buyer guides for this size band consistently rank multi-state statutory filing above price<sup>1</sup>. Vendors that publish a per-run audit trail and a named approval step tend to clear finance and internal audit faster<sup>2</sup>. Expect a parallel run before cutover<sup>3</sup>.',
        'cites' => [['reviewsite-b.example', false], ['yourcompany.com', true], ['forum-c.example', false]],
        'moved' => [
            ['Page',     '/compare/platforms — a server-rendered comparison table'],
            ['Entity',   'A named author with a checkable profile on the page'],
            ['Citation', 'forum-c.example answer written by your own engineer'],
        ],
    ],
    [
        'key'  => 'ppx', 'name' => 'Perplexity', 'meta' => 'Answer with numbered citations',
        'lead' => 'Compliance coverage, migration effort and audit evidence decide most mid-market payroll choices.',
        'body' => 'Sources agree that statutory scope is the first filter<sup>1</sup> and that migration of historical payroll data is the main schedule risk<sup>2</sup>. Pricing is generally quoted per employee per month, with a floor for smaller headcounts<sup>3</sup>.',
        'cites' => [['reviewsite-b.example', false], ['tradepublication-a.example', false], ['forum-c.example', false]],
        'moved' => [
            ['Page',     'Not reached — /guides/implementation renders client-side'],
            ['Entity',   'Resolves, but no page of yours matches this question'],
            ['Citation', 'No third-party source names you for this prompt'],
        ],
    ],
];

$tsv_hr_lead = 'One question, answered twice. We work the ranking and the citation as a single system: pages a crawler can read, entities a model can be sure of, and answers worth quoting.';
$tsv_hr_meta = [];
foreach ($CAP['meta_k'] as $tsv_hmk => $tsv_hmv) { $tsv_hr_meta[] = [$tsv_hmv, $CAP['meta'][$tsv_hmk] ?? '']; }
unset($tsv_hmk, $tsv_hmv);
?>
<section class="tsv-hero" id="top" aria-labelledby="hero-t">
  <span class="tsv-hero__wall dots" aria-hidden="true"></span>

  <div class="wrap">
    <nav class="tsv-crumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="<?= xe_url('services/') ?>">Services</a></li>
        <li><a href="<?= xe_url('services/technology-intelligence.php') ?>"><?= e($TECH['name'] ?? 'Technology &amp; Intelligence') ?></a></li>
        <li><span aria-current="page"><?= e($CAP['name']) ?></span></li>
      </ol>
    </nav>
  </div>

  <div class="wrap tsv-hero__in">

    <div class="tsv-hero__t">
      <p class="tsv-kick"><span class="tsv-kick__ref">Capability 08 / 10</span><span><?= e($CAP['kicker']) ?></span></p>
      <h1 class="tsv-hero__h" id="hero-t"><span class="g">Found on Google.</span> Cited in the answer.</h1>
    </div>

    <div class="tsv-hero__side">
      <p class="lead tsv-hero__lead"><?= e($tsv_hr_lead) ?></p>
      <div class="tsv-hero__act">
        <a class="btn btn--ink btn--lg" href="<?= xe_url('contact.php') ?>"><?= e($CAP['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out btn--lg" href="#lens">Open the lens <span class="i" aria-hidden="true">›</span></a>
      </div>
      <!-- PLACEHOLDER: confirm typical cycle and reporting cadence before launch -->
      <dl class="tsv-hero__meta">
        <?php foreach ($tsv_hr_meta as $tsv_hm): ?>
          <div><dt><?= e($tsv_hm[0]) ?></dt><dd><?= e($tsv_hm[1]) ?></dd></div>
        <?php endforeach; ?>
      </dl>
    </div>

    <div class="tsv-hero__console">
      <div class="tsv-console" data-tsv-console>

        <div class="tsv-console__q" aria-hidden="true">
          <span class="tsv-console__ico"><?= xt_icon('search', ['size' => 18]) ?></span>
          <span class="tsv-console__typed"><span data-typed-target><?= e($tsv_hr_q) ?></span><span class="bdh-caret" aria-hidden="true"></span></span>
          <span class="tsv-console__go">Search</span>
        </div>

        <div class="tsv-console__cols">

          <div class="tsv-serp" aria-hidden="true">
            <p class="tsv-col__h"><span class="tsv-col__k">Results page</span><span class="tsv-col__m">Organic · 10 blue links</span></p>
            <ol class="tsv-serp__list">
              <?php foreach ($tsv_hr_serp as $tsv_hi => $tsv_hs): ?>
                <li class="tsv-res<?= $tsv_hs[4] ? ' is-you' : '' ?>" style="--i:<?= $tsv_hi ?>">
                  <span class="tsv-res__pos"><?= str_pad((string) ($tsv_hi + 1), 2, '0', STR_PAD_LEFT) ?></span>
                  <span class="tsv-res__top"><?= tsv_src($tsv_hs[0], ['you' => $tsv_hs[4]]) ?><span class="tsv-res__crumb"><?= e($tsv_hs[1]) ?></span></span>
                  <span class="tsv-res__t"><?= e($tsv_hs[2]) ?></span>
                  <span class="tsv-res__d"><?= e($tsv_hs[3]) ?></span>
                  <?php if ($tsv_hs[5]): ?>
                    <span class="tsv-res__rich">
                      <span class="tsv-res__richk">Sitelinks</span>
                      <?php foreach ($tsv_hs[5] as $tsv_hq): ?><span class="tsv-res__q"><b><?= e($tsv_hq[0]) ?></b><small><?= e($tsv_hq[1]) ?></small><i aria-hidden="true">&rsaquo;</i></span><?php endforeach; ?>
                    </span>
                  <?php endif; ?>
                </li>
              <?php endforeach; ?>
            </ol>
            <div class="tsv-paa">
              <p class="tsv-paa__k">People also ask</p>
              <?php foreach ($tsv_hr_paa as $tsv_hp): ?><span class="tsv-paa__q"><?= e($tsv_hp) ?><i aria-hidden="true">+</i></span><?php endforeach; ?>
            </div>
          </div>

          <div class="tsv-ans">
            <p class="tsv-col__h"><span class="tsv-col__k">Generated answer</span><span class="tsv-col__m">Three sources cited</span></p>
            <p class="bdh-sr" id="hero-ans-h">Illustrative generated answers for the same query. Hosts, wording and citations are fictional. Choose an engine to read its answer, the sources it cited, and what produced the mention.</p>
            <div class="tsv-ans__bar">
              <div class="tsv-ans__chips" role="tablist" aria-label="Answer engine" aria-describedby="hero-ans-h" data-tsv-chips>
                <?php foreach ($tsv_hr_eng as $tsv_hei => $tsv_he): ?>
                  <button class="tsv-ans__chip<?= $tsv_hei === 0 ? ' is-on' : '' ?>" type="button" role="tab"
                          id="hero-tab-<?= e($tsv_he['key']) ?>" aria-controls="hero-pane-<?= e($tsv_he['key']) ?>"
                          aria-selected="<?= $tsv_hei === 0 ? 'true' : 'false' ?>" tabindex="<?= $tsv_hei === 0 ? '0' : '-1' ?>"><?= e($tsv_he['name']) ?></button>
                <?php endforeach; ?>
              </div>
              <div class="tsv-ans__pause" data-tsv-pause></div>
            </div>
            <div class="bdh-panes tsv-ans__panes" data-tsv-panes>
              <?php foreach ($tsv_hr_eng as $tsv_hei => $tsv_he): ?>
                <div class="bdh-pane tsv-ans__pane<?= $tsv_hei === 0 ? ' is-on' : '' ?>" id="hero-pane-<?= e($tsv_he['key']) ?>"
                     role="tabpanel" aria-labelledby="hero-tab-<?= e($tsv_he['key']) ?>" tabindex="0" data-pane="<?= e($tsv_he['key']) ?>">
                  <p class="tsv-ans__meta"><i class="tsv-led tsv-led--pulse" aria-hidden="true"></i><?= e($tsv_he['meta']) ?></p>
                  <p class="tsv-ans__lead"><?= e($tsv_he['lead']) ?></p>
                  <p class="tsv-ans__body"><?= $tsv_he['body'] ?></p>
                  <p class="tsv-ans__sk">Sources</p>
                  <ol class="tsv-ans__cites">
                    <?php foreach ($tsv_he['cites'] as $tsv_hci => $tsv_hc): ?>
                      <li<?= $tsv_hc[1] ? ' class="is-you"' : '' ?>><?= tsv_src($tsv_hc[0], ['you' => $tsv_hc[1], 'n' => (string) ($tsv_hci + 1)]) ?></li>
                    <?php endforeach; ?>
                  </ol>
                  <div class="tsv-ans__moved">
                    <p class="tsv-ans__sk tsv-ans__sk--m">What moved this answer</p>
                    <ul class="tsv-moved" role="list">
                      <?php foreach ($tsv_he['moved'] as $tsv_hmv2): ?>
                        <li><b><?= e($tsv_hmv2[0]) ?></b><span><?= e($tsv_hmv2[1]) ?></span></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

        </div>
      </div>

      <p class="bdh-sr">An illustrative ranked results page, shown for contrast beside the answer panel above. The query “<?= e($tsv_hr_q) ?>” returns a review site first; “Your company” second, with sitelinks to its pricing, statutory coverage and implementation pages; and a trade publication third, followed by three People-also-ask questions. All results, hosts and figures are fictional.</p>
    </div>

  </div>
</section>
