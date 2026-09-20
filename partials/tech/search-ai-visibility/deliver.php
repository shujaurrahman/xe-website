<?php /* DRAFT COPY — review before launch */
/* Deliver (paper) — 11 · What you get. The six deliverables from $CAP['deliver'], each opened out
   with what is actually inside it, when it first lands and what keeps it current. A handover panel
   sits beside the list, with the honest list of what is not in the pack under it.
   Motion is the core stagger on reveal; no JS of its own. */

$tsv_dl_items = isset($CAP['deliver']) ? $CAP['deliver'] : [];

/* Page-side detail, index-matched to the data list. */
$tsv_dl_meta = [
    [
        'icon'  => 'clipboard-check',
        'in'    => 'Every indexable URL crawled against the rendered DOM, a log sample read by user agent, and index coverage pulled from Search Console. Findings are ranked by traffic at risk against effort and written into your tracker as tickets a developer can pick up without a translation layer.',
        'first' => 'Week 03',
        'keep'  => 'Re-crawled monthly, re-audited each quarter',
    ],
    [
        'icon'  => 'code',
        'in'    => 'Organization, Product, Article with a named author, BreadcrumbList, and FAQPage only where the page genuinely qualifies. Written to the Schema.org vocabulary, validated before release, re-validated in CI, then watched in Search Console for enhancement errors after it ships.',
        'first' => 'Week 06',
        'keep'  => 'Validated on every release',
    ],
    [
        'icon'  => 'network',
        'in'    => 'Your entity and its attributes — legal name, locations, contact data, products, people — mapped to the external profiles that state the same facts, and matched against the question clusters that lead to revenue. It is the brief for both the content plan and the markup.',
        'first' => 'Week 04',
        'keep'  => 'Reviewed monthly',
    ],
    [
        'icon'  => 'doc',
        'in'    => 'Pages that answer in the first fifty words, then prove it: a comparison table, an original data point, a named author with credentials, a real updated date and the sources. Agents draft the brief and check claims against sources; a human editor writes, approves and signs the page.',
        'first' => 'Week 06 onward',
        'keep'  => 'Published to a calendar, refreshed on a schedule',
    ],
    [
        'icon'  => 'radar',
        'in'    => 'The prompt panel itself, the sampling harness that runs it, and the full run history: cited, mentioned without a link, or absent, per engine, per prompt. Reported as rates with a sample size, because a generated answer differs run to run and one screenshot proves nothing.',
        'first' => 'Week 03',
        'keep'  => 'Re-sampled weekly',
    ],
    [
        'icon'  => 'dashboard',
        'in'    => 'Clicks, impressions and position from Search Console beside share of answer and citation rate by engine, with organic-assisted conversions and the Core Web Vitals pass rate. Measured and sampled figures are labelled and kept in separate columns, never averaged together.',
        'first' => 'Month 01',
        'keep'  => 'Monthly, against the baseline',
    ],
];

$tsv_dl_hand = [
    ['plug', 'It lands in your accounts', 'Search Console, analytics, the warehouse, the repository and the dashboard stay yours. We work inside them and leave nothing behind that only we can open.'],
    ['terminal', 'The sampling code ships with it', 'The prompt panel, the run harness and the queries behind every chart are readable and re-runnable, so your team can check a number instead of trusting it.'],
    ['doc', 'The report is a page, not a performance', 'One dashboard both teams read, plus a short written read each month: what moved, what shipped, what changed our minds.'],
];

$tsv_dl_not = [
    ['A guaranteed ranking or citation', 'Search engines and model providers control their own results. We commit to the work, the measurement and the reporting.'],
    ['Bought links or link exchanges',   'Link schemes are against search engine spam policies and put the whole domain at risk. We earn mentions or we do without them.'],
    ['Mass-produced pages',              'Scaled content made to game rankings is a policy violation and a poor citation source. Every page has an editor and a named author.'],
];
?>
<section class="band tsv-del" id="deliver" aria-labelledby="deliver-t">
  <div class="wrap">

    <header class="tsv-head" data-rv>
      <div class="tsv-head__t">
        <p class="tsv-kick"><span class="tsv-kick__ref">11 · Deliverables</span><span>What you get</span></p>
        <h2 class="h2" id="deliver-t"><span class="g">What lands,</span> and what it is for.</h2>
      </div>
      <div class="tsv-head__l">
        <p class="lead">Six artefacts, each with an owner and a life after handover. None of them is a slide deck about search. Every one of them is something your team can open, run, edit or ship on Monday morning.</p>
      </div>
    </header>

    <div class="tsv-del__grid">

      <ol class="tsv-del__list" data-rv-s data-rv-step="70">
        <?php foreach ($tsv_dl_items as $tsv_dl_i => $tsv_dl_d):
            $tsv_dl_m = isset($tsv_dl_meta[$tsv_dl_i]) ? $tsv_dl_meta[$tsv_dl_i] : null;
            if (!$tsv_dl_m) { continue; } ?>
          <li class="tsv-del__row">
            <span class="tsv-del__n"><?= str_pad((string) ($tsv_dl_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <span class="tsv-del__ico"><?= xt_icon($tsv_dl_m['icon'], ['size' => 20]) ?></span>
            <div class="tsv-del__body">
              <div class="tsv-del__top">
                <h3 class="tsv-del__t"><?= e($tsv_dl_d[0]) ?></h3>
                <span class="tsv-del__fmt"><?= e($tsv_dl_d[1]) ?></span>
              </div>
              <p class="tsv-del__in"><?= e($tsv_dl_m['in']) ?></p>
              <dl class="tsv-del__meta">
                <div><dt>First lands</dt><dd><?= e($tsv_dl_m['first']) ?></dd></div>
                <div><dt>Kept current</dt><dd><?= e($tsv_dl_m['keep']) ?></dd></div>
              </dl>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>

      <aside class="tsv-del__side" aria-labelledby="deliver-hand-t">
        <div class="tsv-del__panel" data-rv data-rv-d="120">
          <h3 class="tsv-del__pt" id="deliver-hand-t">How it hands over</h3>
          <ul class="tsv-del__hand" role="list">
            <?php foreach ($tsv_dl_hand as $tsv_dl_h): ?>
              <li>
                <span class="tsv-del__hi"><?= xt_icon($tsv_dl_h[0], ['size' => 18]) ?></span>
                <b><?= e($tsv_dl_h[1]) ?></b>
                <small><?= e($tsv_dl_h[2]) ?></small>
              </li>
            <?php endforeach; ?>
          </ul>
          <!-- PLACEHOLDER: confirm week and month timings against the signed scope before launch -->
          <p class="tsv-del__pn">Timings above describe a typical 90-day programme and are agreed in the scope before anything starts.</p>
        </div>

        <div class="tsv-del__panel tsv-del__panel--not" data-rv data-rv-d="180">
          <h3 class="tsv-del__pt">What is not in the pack</h3>
          <ul class="tsv-del__not" role="list">
            <?php foreach ($tsv_dl_not as $tsv_dl_x): ?>
              <li>
                <b><?= xt_icon('alert', ['size' => 16]) ?><?= e($tsv_dl_x[0]) ?></b>
                <small><?= e($tsv_dl_x[1]) ?></small>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <a class="btn btn--out tsv-del__cta" href="<?= xe_url('contact.php') ?>">Ask what your pack would include <span class="i" aria-hidden="true">›</span></a>
      </aside>

    </div>

  </div>
</section>
