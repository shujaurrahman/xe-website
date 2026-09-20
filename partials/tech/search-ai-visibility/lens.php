<?php /* DRAFT COPY — review before launch */
/* Lens (paper) — THE SIGNATURE COMPONENT. A share-of-answer panel: twelve buyer prompts grouped by
   intent (discover, compare, decide) against four engines (Google organic, AI Overview, ChatGPT
   search, Perplexity). Every cell carries a before state and an after-fixes state; clicking or
   pressing Enter on a cell opens a drawer with that engine's generic answer, the sources it cited,
   where the placeholder company appears or why it is missing, and the fix. The grid is a real table
   with header scopes; cells are buttons; the drawer has a server-rendered default so the section is
   complete and readable with JavaScript off.
   All prompts, answers, hosts and rates are illustrative. */

$tsv_ln_eng = [   // [key, name, short name, what it is]
    ['go',  'Google organic',   'Organic',      'Ranked results'],
    ['ao',  'Google AI Overview', 'AI Overview', 'Generated summary'],
    ['gpt', 'ChatGPT search',   'ChatGPT',      'Assistant answer'],
    ['ppx', 'Perplexity',       'Perplexity',   'Cited answer'],
];
$tsv_ln_intents = [
    'discover' => ['Discover', 'Learning the problem exists'],
    'compare'  => ['Compare',  'Drawing up a shortlist'],
    'decide'   => ['Decide',   'Getting it through the business'],
];
$tsv_ln_states = [
    'cited'   => ['Cited',    'named with a link to your page'],
    'mention' => ['Mentioned', 'named without a link'],
    'absent'  => ['Absent',   'not named at all'],
];

/* [intent, prompt, the generic answer an engine gives, sources it draws on, before[4], after[4], why, fix] */
$tsv_ln_rows = [
    ['discover', 'what is multi-state payroll and why is it hard',
     'Multi-state payroll means running one pay cycle against several state rules at once: professional tax slabs, labour welfare fund deductions and minimum wage notifications all differ by state, and each has its own filing calendar.',
     ['tradepublication-a.example', 'reviewsite-b.example', 'gov-portal.example'],
     ['mention', 'absent', 'absent', 'absent'],
     ['cited', 'cited', 'mention', 'cited'],
     'Your explainer exists, but it opens with 900 words of preamble before it defines the term, so no engine can lift a clean definition.',
     'Rewrite the page to answer in the first 50 words, add a state-by-state table, and mark it up as an Article with a named author and an updated date.'],

    ['discover', 'how do mid-size companies in India run payroll today',
     'Most companies in the 200–2,000 band run a hybrid: a payroll platform for calculation and filing, a finance owner for approvals, and a spreadsheet that quietly holds the exceptions.',
     ['tradepublication-a.example', 'forum-c.example', 'analyst-d.example'],
     ['absent', 'absent', 'mention', 'absent'],
     ['mention', 'cited', 'cited', 'mention'],
     'No page on your site covers current practice — only product pages. Engines answering this prompt have nothing of yours to quote.',
     'Publish one original benchmark page with data you actually hold, and keep it updated quarterly so it stays the freshest source on the question.'],

    ['discover', 'payroll compliance checklist for a 500-person company',
     'A workable checklist covers EPF and ESI registration and monthly returns, professional tax by state, TDS deposit and quarterly returns, gratuity provisioning, and an auditable record of every approved run.',
     ['gov-portal.example', 'reviewsite-b.example', 'yourcompany.com'],
     ['cited', 'mention', 'absent', 'absent'],
     ['cited', 'cited', 'cited', 'cited'],
     'You rank well in organic for this, but the checklist lives inside a gated PDF, so the generated answers cannot read it.',
     'Publish the checklist as an indexable HTML page with the gate on the downloadable version, and add FAQPage markup for the questions it answers.'],

    ['discover', 'signs your payroll process has outgrown spreadsheets',
     'The usual signals are a growing exception list, reconciliation that takes longer each cycle, and no single record of who approved what before money moved.',
     ['forum-c.example', 'tradepublication-a.example', 'yourcompany.com'],
     ['cited', 'absent', 'absent', 'mention'],
     ['cited', 'cited', 'cited', 'cited'],
     'The page is strong but has no author, no credentials and no updated date, so assistants treat it as a marketing page rather than a source.',
     'Add a named author with their role and experience, an updated date, and links to the sources behind each claim.'],

    ['compare', 'best payroll software for mid-size companies in India',
     'Buyer guides for this size band rank statutory coverage first, then migration effort, then price, and most recommend a parallel run before cutover.',
     ['reviewsite-b.example', 'yourcompany.com', 'tradepublication-a.example'],
     ['cited', 'cited', 'mention', 'absent'],
     ['cited', 'cited', 'cited', 'cited'],
     'Perplexity leans on comparison tables it can parse. Your comparison lives in a JavaScript tab component that renders nothing without execution.',
     'Render the comparison as server-side HTML in a real table, and keep the tab behaviour as an enhancement over it.'],

    ['compare', 'payroll platforms compared for 200 to 2000 employees',
     'Comparisons at this size focus on multi-state filing, approval workflow, integration with the finance stack, and whether the vendor publishes audit evidence.',
     ['reviewsite-b.example', 'analyst-d.example', 'forum-c.example'],
     ['mention', 'absent', 'absent', 'absent'],
     ['cited', 'mention', 'cited', 'cited'],
     'You have no page that compares options honestly, including where you are not the right fit, so nothing of yours reads as a comparison.',
     'Write a genuine comparison page with a table, state where you are not the best choice, and cite the sources for every figure.'],

    ['compare', 'alternatives to an in-house payroll team',
     'The realistic options are a managed payroll service, a platform with an internal owner, or an outsourced provider; the trade-off is control against headcount.',
     ['analyst-d.example', 'tradepublication-a.example', 'forum-c.example'],
     ['absent', 'absent', 'absent', 'absent'],
     ['mention', 'mention', 'cited', 'mention'],
     'This prompt sits one step outside your category language, so nothing on your site matches the question the buyer actually typed.',
     'Add a page in the buyer\'s words rather than the category\'s, and link it into the comparison cluster with descriptive internal links.'],

    ['compare', 'payroll software pricing per employee per month',
     'Pricing is generally quoted per employee per month with a floor for smaller headcounts; implementation is usually a separate one-off fee.',
     ['reviewsite-b.example', 'forum-c.example', 'analyst-d.example'],
     ['mention', 'absent', 'mention', 'absent'],
     ['cited', 'cited', 'cited', 'mention'],
     'Your pricing page shows a contact form instead of a structure, so engines quote third-party estimates of your price rather than your own.',
     'Publish the pricing model, the bands and what changes the number, even without a final figure, and add Offer markup where it is accurate.'],

    ['decide', 'how long does a payroll migration take',
     'Most migrations run six to twelve weeks: data extraction and cleaning, a parallel run against the incumbent, then cutover at a period boundary.',
     ['yourcompany.com', 'tradepublication-a.example', 'analyst-d.example'],
     ['cited', 'mention', 'cited', 'absent'],
     ['cited', 'cited', 'cited', 'cited'],
     'Perplexity did not reach the page: your implementation guide returns a 200 status with an empty body until a script loads.',
     'Server-render the guide, confirm the rendered HTML in the URL inspection tool, and check the status codes on every step of the path.'],

    ['decide', 'questions to ask a payroll vendor before signing',
     'Strong lists cover statutory scope by state, who owns the approval step, what evidence a run produces, exit and data-portability terms, and support hours.',
     ['tradepublication-a.example', 'forum-c.example', 'yourcompany.com'],
     ['cited', 'absent', 'mention', 'mention'],
     ['cited', 'cited', 'cited', 'cited'],
     'You are named without a link. The answer paraphrases your list but has no single page to point at — the questions are spread across four blog posts.',
     'Consolidate the four posts into one canonical page, redirect the rest, and keep the internal links pointing at the survivor.'],

    ['decide', 'which payroll vendors publish audit evidence',
     'Buyers look for a per-run audit trail, retained approval records, and a security page that states which frameworks the vendor aligns delivery with.',
     ['analyst-d.example', 'reviewsite-b.example', 'gov-portal.example'],
     ['absent', 'absent', 'absent', 'absent'],
     ['mention', 'absent', 'mention', 'cited'],
     'Your trust page is excluded in robots.txt, a leftover from a staging rule, so no crawler — search or assistant — has ever read it.',
     'Remove the stale disallow rule, request indexing, and keep the trust page in the sitemap with a sensible change frequency.'],

    ['decide', 'payroll software implementation checklist',
     'A usable checklist sequences data extraction, mapping, a parallel run, sign-off by finance, cutover and a first-run review with the vendor.',
     ['yourcompany.com', 'tradepublication-a.example', 'reviewsite-b.example'],
     ['cited', 'cited', 'absent', 'mention'],
     ['cited', 'cited', 'cited', 'cited'],
     'ChatGPT search cannot fetch the page: OAI-SearchBot is disallowed in robots.txt alongside the training crawlers.',
     'Separate the rules — allow OAI-SearchBot and PerplexityBot for search, and decide the training crawlers (GPTBot, Google-Extended) as a policy choice.'],
];

/* share of answer by intent, before and after — cited cells as a share of all cells in the group */
$tsv_ln_share = [];
foreach ($tsv_ln_intents as $tsv_lk => $tsv_lv) {
    $tsv_lb = $tsv_la = $tsv_lt = 0;
    foreach ($tsv_ln_rows as $tsv_lr) {
        if ($tsv_lr[0] !== $tsv_lk) continue;
        foreach ($tsv_lr[4] as $tsv_ls) { $tsv_lt++; if ($tsv_ls === 'cited') $tsv_lb++; }
        foreach ($tsv_lr[5] as $tsv_ls) { if ($tsv_ls === 'cited') $tsv_la++; }
    }
    $tsv_ln_share[$tsv_lk] = [
        'name'   => $tsv_lv[0],
        'note'   => $tsv_lv[1],
        'before' => $tsv_lt ? (int) round($tsv_lb / $tsv_lt * 100) : 0,
        'after'  => $tsv_lt ? (int) round($tsv_la / $tsv_lt * 100) : 0,
    ];
}
unset($tsv_lk, $tsv_lv, $tsv_lb, $tsv_la, $tsv_lt, $tsv_lr, $tsv_ls);

$tsv_ln_group = null;
?>
<section class="band tsv-lens" id="lens" aria-labelledby="lens-t">
  <div class="wrap">

    <header class="tsv-head tsv-head--wide" data-rv>
      <div class="tsv-head__t">
        <p class="tsv-kick"><span class="tsv-kick__ref">02 · The lens</span><span>Share of answer</span></p>
        <h2 class="h2" id="lens-t"><span class="g">Where you are cited,</span> and where you are missing.</h2>
      </div>
      <div class="tsv-head__l">
        <p class="lead">We build a panel of the prompts your buyers actually use, sample it across the engines that answer them, and read the result as one picture. Open any cell to see the answer that engine gave, who it cited, and what would change it.</p>
      </div>
    </header>

    <div class="tsv-lens__ui" data-tsv-lens>

      <div class="tsv-lens__bar">
        <p class="tsv-lens__title"><b>Share-of-Answer Lens</b> · Your company · payroll, India</p>
        <p class="tsv-lens__read tsv-ro" data-lens-read>Panel of 12 prompts · 4 engines · <b data-lens-n>20</b> runs per engine per week</p>
        <div class="tsv-lens__ctrl">
          <button class="tsv-btn tsv-btn--go" type="button" data-lens-sample>Sample the panel</button>
          <button class="bdh-switch tsv-lens__sw" type="button" aria-pressed="false" data-lens-after>
            <span class="bdh-switch__track" aria-hidden="true"></span>Show after fixes
          </button>
        </div>
      </div>

      <div class="tsv-lens__grid">
        <div class="tsv-lens__frame">
        <div class="bdh-scroll-x mask-x tsv-lens__scroll" tabindex="0" role="group" aria-label="Prompt and engine grid, scroll sideways to see every engine">
          <table class="tsv-grid">
            <caption class="bdh-sr">Illustrative share-of-answer panel. Twelve buyer prompts, grouped by intent, against four engines. Each cell records whether the placeholder company was cited with a link, mentioned without a link, or absent from that engine's answer.</caption>
            <thead>
              <tr>
                <th scope="col" class="tsv-grid__ph">Buyer prompt</th>
                <?php foreach ($tsv_ln_eng as $tsv_le): ?>
                  <th scope="col" class="tsv-grid__eh">
                    <span class="tsv-grid__en"><?= e($tsv_le[1]) ?></span>
                    <span class="tsv-grid__es"><?= e($tsv_le[2]) ?></span>
                    <span class="tsv-grid__ed"><?= e($tsv_le[3]) ?></span>
                  </th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($tsv_ln_rows as $tsv_lri => $tsv_lr):
                  if ($tsv_lr[0] !== $tsv_ln_group):
                      $tsv_ln_group = $tsv_lr[0]; ?>
                      <tr class="tsv-grid__grp">
                        <th scope="colgroup" colspan="5">
                          <span class="tsv-grid__gk"><?= e($tsv_ln_intents[$tsv_lr[0]][0]) ?></span>
                          <span class="tsv-grid__gn"><?= e($tsv_ln_intents[$tsv_lr[0]][1]) ?></span>
                        </th>
                      </tr>
                  <?php endif; ?>
                <tr data-row="<?= $tsv_lri ?>"
                    data-q="<?= e($tsv_lr[1]) ?>"
                    data-a="<?= e($tsv_lr[2]) ?>"
                    data-src="<?= e(implode('|', $tsv_lr[3])) ?>"
                    data-why="<?= e($tsv_lr[6]) ?>"
                    data-fix="<?= e($tsv_lr[7]) ?>">
                  <th scope="row" class="tsv-grid__q"><?= e($tsv_lr[1]) ?></th>
                  <?php foreach ($tsv_ln_eng as $tsv_lei => $tsv_le):
                      $tsv_lsb = $tsv_lr[4][$tsv_lei];
                      $tsv_lsa = $tsv_lr[5][$tsv_lei]; ?>
                    <td class="tsv-grid__c">
                      <button class="tsv-cell" type="button" data-s1="<?= e($tsv_lsb) ?>" data-s2="<?= e($tsv_lsa) ?>" data-now="<?= e($tsv_lsb) ?>"
                              data-e="<?= $tsv_lei ?>" data-en="<?= e($tsv_le[1]) ?>" data-ed="<?= e($tsv_le[3]) ?>"
                              aria-label="<?= e($tsv_le[1] . ' · ' . $tsv_ln_states[$tsv_lsb][0] . ' · ' . $tsv_lr[1]) ?>">
                        <span class="tsv-cell__m" aria-hidden="true"></span>
                        <span class="tsv-cell__t"><?= e($tsv_ln_states[$tsv_lsb][0]) ?></span>
                      </button>
                    </td>
                  <?php endforeach; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        </div>

        <ul class="tsv-lens__key" role="list">
          <?php foreach ($tsv_ln_states as $tsv_lsk => $tsv_lsv): ?>
            <li><span class="tsv-cell__m" data-now="<?= e($tsv_lsk) ?>" aria-hidden="true"></span><b><?= e($tsv_lsv[0]) ?></b><small><?= e($tsv_lsv[1]) ?></small></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <aside class="tsv-drawer" data-lens-drawer aria-live="polite" aria-labelledby="lens-drawer-t">
        <div class="tsv-drawer__bar">
          <p class="tsv-drawer__k" data-drawer-eng>The panel</p>
          <button class="tsv-drawer__x" type="button" data-drawer-close hidden>Close<span aria-hidden="true">×</span></button>
        </div>
        <h3 class="bdh-t tsv-drawer__t" id="lens-drawer-t" data-drawer-q>Pick any cell to read the answer behind it</h3>
        <p class="tsv-drawer__a" data-drawer-a>Each cell holds one engine's answer to one prompt. The drawer shows that answer, the sources it cited, whether your company appears in it, and the single change most likely to move the cell.</p>
        <p class="tsv-drawer__sk">Sources cited</p>
        <ul class="tsv-drawer__src" role="list" data-drawer-src>
          <li class="tsv-drawer__empty">Sources appear here once a cell is open.</li>
        </ul>
        <div class="tsv-drawer__verdict" data-drawer-verdict>
          <p class="tsv-drawer__vk">Verdict</p>
          <p class="tsv-drawer__vt">Sample the panel, then open a cell.</p>
        </div>
        <div class="tsv-drawer__fix">
          <p class="tsv-drawer__fk"><?= xt_icon('wrench', ['size' => 16]) ?>The fix</p>
          <p class="tsv-drawer__ft" data-drawer-fix>Every cell in this panel has one. The order we do them in is the audit.</p>
        </div>
      </aside>

      <div class="tsv-lens__share">
        <p class="tsv-share__k">Share of answer by intent<span class="tsv-prov">Sampled estimate</span></p>
        <ul class="tsv-share" role="list" data-lens-share>
          <?php foreach ($tsv_ln_share as $tsv_lsk => $tsv_lsv): ?>
            <li class="tsv-share__row" data-before="<?= (int) $tsv_lsv['before'] ?>" data-after="<?= (int) $tsv_lsv['after'] ?>">
              <span class="tsv-share__n"><b><?= e($tsv_lsv['name']) ?></b><small><?= e($tsv_lsv['note']) ?></small></span>
              <span class="tsv-share__bar"><i style="--p:<?= number_format($tsv_lsv['before'] / 100, 3) ?>"></i></span>
              <span class="tsv-share__v"><b data-share-v><?= (int) $tsv_lsv['before'] ?></b>%<small>cited</small></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <p class="tsv-note tsv-lens__note">
        <?= xt_icon('scan', ['size' => 18]) ?>
        <span><b>How this is measured.</b> Generated answers vary run to run, so a single check proves nothing. We sample every prompt on a schedule — twenty runs per engine per week, from a clean session in the buyer's market — and report the result as a rate with its sample size, never as a single screenshot. Organic positions come from Search Console where the query is available; everything on the generated side is a sampled estimate and is labelled as one. Figures shown here are illustrative.</span>
      </p>

    </div>
  </div>
</section>
