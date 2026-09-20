<?php /* DRAFT COPY — review before launch */
/* Content (alt) — the anatomy of a page an answer can quote. A long-form comparison page is mocked
   on the right with seven annotated blocks; the notes on the left explain what each block does for a
   reader first and for an engine second. content.js links the two with BDH.spy, so the note for the
   block in the middle of the viewport is the one highlighted. Nothing is hidden: every note is
   readable at once, the highlight is only emphasis.
   The mock page, its figures and its author are placeholders for the example company. */

/* [n, block key, note title, note body, the mark it earns] */
$tsv_ct_notes = [
    ['01', 'answer', 'A direct answer in the first fifty words',
     'The page states the answer before it explains it. A reader who only wants the answer gets it; an engine lifting a passage gets a complete sentence rather than a preamble.',
     'Passage-ready'],
    ['02', 'table', 'A comparison table with real columns',
     'Generated answers lean on structured comparisons because they are unambiguous. Rows are options, columns are the criteria buyers actually use, and every cell is filled or explicitly marked as not applicable.',
     'Quotable structure'],
    ['03', 'data', 'One piece of information that exists nowhere else',
     'Original data is the single strongest reason to cite a page. A survey, a benchmark you ran, a cost breakdown from your own delivery — anything that cannot be paraphrased from a competitor.',
     'Citation magnet'],
    ['04', 'author', 'A named author with checkable credentials',
     'A real person, a real role, a bio that links to profiles that confirm it, and an Article with an <code>author</code> property pointing at that Person. Anonymous pages are cheap to produce and easy to discount.',
     'Experience shown'],
    ['05', 'fresh', 'A visible updated date and what changed',
     'Not a date stamp that moves on every deploy. A short changelog beneath it that says what was revised, so freshness is a fact rather than a formatting trick.',
     'Honest freshness'],
    ['06', 'sources', 'Sources, linked and dated',
     'Statutory rules, official guidance and published research, linked to the primary source with the date it was checked. It makes the page verifiable, and it puts you in the citation neighbourhood you want to be in.',
     'Verifiable'],
    ['07', 'faq', 'The questions people actually ask next',
     'Taken from sales calls, support tickets and the prompts in the panel — not from a keyword tool alone. Each answered in two or three sentences directly under the question.',
     'Answer surface'],
];

$tsv_ct_table = [
    ['Criterion',              'Platform A',        'Platform B',      'Platform C'],
    ['Multi-state PT slabs',   'All states',        '18 states',       'Manual upload'],
    ['EPF / ESI filing',       'Automated',         'Automated',       'Export only'],
    ['Approval before payout', 'Named approver',    'Any admin',       'Named approver'],
    ['Audit trail per run',    'Immutable log',     '90-day log',      'None'],
    ['Typical go-live',        '6–8 weeks',         '4–6 weeks',       '10–12 weeks'],
];

$tsv_ct_how = [
    ['Agents draft, editors decide', 'brief',
     'An agent assembles the brief: the prompts the panel shows you are losing, the questions support gets asked, the comparison columns competitors leave blank, and the sources worth citing. A person writes from it.'],
    ['Every claim checked against a source', 'eval',
     'Before publication an agent re-reads the draft against the linked sources and flags any sentence the source does not support. The flags go to the editor; the editor decides. Nothing publishes on an agent\'s word.'],
    ['One human name on every page', 'approve',
     'A named editor signs off and stays accountable for the page. We do not publish mass-produced pages, and we do not put a byline on work the named person did not review.'],
];
?>
<section class="band band--alt tsv-cnt" id="content" aria-labelledby="content-t">
  <div class="wrap">

    <header class="tsv-head" data-rv>
      <div class="tsv-head__t">
        <p class="tsv-kick"><span class="tsv-kick__ref">05 · Content</span><span>Answer-first pages</span></p>
        <h2 class="h2" id="content-t"><span class="g">Content</span> an answer can quote.</h2>
      </div>
      <div class="tsv-head__l">
        <p class="lead">A page that earns citations is not a page written for machines. It is a page so clearly organised that a machine can find the part worth quoting — and a reader can too. Seven blocks do most of the work.</p>
      </div>
    </header>

    <div class="tsv-cnt__grid" data-tsv-anatomy>

      <div class="tsv-cnt__notes">
        <ol class="tsv-notes" role="list">
          <?php foreach ($tsv_ct_notes as $tsv_cn): ?>
            <li class="tsv-note-i" data-note="<?= e($tsv_cn[1]) ?>">
              <span class="tsv-note-i__n"><?= e($tsv_cn[0]) ?></span>
              <h3 class="tsv-note-i__t"><?= e($tsv_cn[2]) ?></h3>
              <p class="tsv-note-i__d"><?= $tsv_cn[3] ?></p>
              <span class="tsv-note-i__tag"><?= e($tsv_cn[4]) ?></span>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>

      <div class="tsv-cnt__page" data-rv>
        <div class="tsv-win tsv-page" aria-hidden="true">
          <p class="tsv-win__bar">
            <span class="tsv-win__dots" aria-hidden="true"><i></i><i></i><i></i></span>
            <span class="tsv-win__path"><b>yourcompany.com</b>/compare/payroll-platforms-india</span>
            <span class="tsv-win__end"><span class="tsv-ill">Illustrative</span></span>
          </p>

          <article class="tsv-page__body">

            <div class="tsv-blk" data-blk="answer">
              <span class="tsv-blk__n">01</span>
              <h4 class="tsv-page__h">Payroll platforms for mid-size companies in India, compared</h4>
              <p class="tsv-page__a">For a company of 200–2,000 staff in India, the platform that fits is the one that files every state’s statutory return without manual work and records who approved each run. Coverage and evidence decide it; price rarely does.</p>
            </div>

            <div class="tsv-blk" data-blk="table">
              <span class="tsv-blk__n">02</span>
              <div class="tsv-page__tbw">
              <table class="tsv-page__tb">
                <caption class="bdh-sr">An illustrative comparison of three unnamed payroll platforms across five criteria.</caption>
                <thead>
                  <tr><?php foreach ($tsv_ct_table[0] as $tsv_cti => $tsv_cth): ?><th scope="col"<?= $tsv_cti === 0 ? ' class="tsv-page__tbk"' : '' ?>><?= e($tsv_cth) ?></th><?php endforeach; ?></tr>
                </thead>
                <tbody>
                  <?php foreach (array_slice($tsv_ct_table, 1) as $tsv_ctr): ?>
                    <tr>
                      <th scope="row" class="tsv-page__tbk"><?= e($tsv_ctr[0]) ?></th>
                      <?php foreach (array_slice($tsv_ctr, 1) as $tsv_ctc): ?><td><?= e($tsv_ctc) ?></td><?php endforeach; ?>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              </div>
            </div>

            <div class="tsv-blk" data-blk="data">
              <span class="tsv-blk__n">03</span>
              <figure class="tsv-page__fig">
                <figcaption>Original data · from our own migrations</figcaption>
                <p class="tsv-page__stat"><b>11</b> of the last <b>14</b> migrations lost time to one thing: historical payroll data that did not reconcile against the last filed return.</p>
                <small>Sample: 14 mid-market migrations. Figures illustrative for this mock.</small>
              </figure>
            </div>

            <div class="tsv-blk" data-blk="author">
              <span class="tsv-blk__n">04</span>
              <div class="tsv-page__by">
                <span class="tsv-page__av" aria-hidden="true"></span>
                <span class="tsv-page__bn"><b>Written by a named payroll lead</b><small>Twelve years in Indian statutory payroll · profile linked · marked up as <code>Article &gt; author &gt; Person</code></small></span>
              </div>
            </div>

            <div class="tsv-blk" data-blk="fresh">
              <span class="tsv-blk__n">05</span>
              <p class="tsv-page__up"><i class="tsv-led" aria-hidden="true"></i><b>Updated 14 days ago</b> — added the FY changes to professional tax slabs in two states and re-checked every filing deadline in the table.</p>
            </div>

            <div class="tsv-blk" data-blk="sources">
              <span class="tsv-blk__n">06</span>
              <p class="tsv-page__sk">Sources</p>
              <ol class="tsv-page__src">
                <li><?= tsv_src('gov-portal.example', ['n' => '1']) ?><span>Statutory filing calendar · checked this month</span></li>
                <li><?= tsv_src('tradepublication-a.example', ['n' => '2']) ?><span>Mid-market payroll survey · published last quarter</span></li>
                <li><?= tsv_src('analyst-d.example', ['n' => '3']) ?><span>Implementation benchmark · <?= e((int) date('Y')) ?> edition</span></li>
              </ol>
            </div>

            <div class="tsv-blk" data-blk="faq">
              <span class="tsv-blk__n">07</span>
              <p class="tsv-page__sk">Frequently asked</p>
              <ul class="tsv-page__faq" role="list">
                <li><b>How long does a payroll migration take?</b><span>Six to twelve weeks for most mid-size companies, driven by how clean the historical data is.</span></li>
                <li><b>Can one platform file for every state?</b><span>Some can. Check professional tax and labour welfare fund coverage state by state before you sign.</span></li>
              </ul>
            </div>

          </article>
        </div>
        <p class="bdh-sr">An illustrative comparison page for the placeholder company, marked up with seven numbered blocks: a direct answer, a five-row comparison table for three unnamed platforms, an original data point from fourteen migrations, a named author, a dated update note, three linked sources, and two frequently asked questions. Each numbered block matches the note of the same number beside it.</p>
      </div>

    </div>

    <div class="tsv-cnt__how">
      <figure class="bdh-img bdh-img--r43 tsv-cnt__img" data-rv data-bdh-parallax="0.05">
        <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
        <img src="<?= xe_url('assets/imgs/tech/search-ai-visibility/editorial-review.jpg') ?>" width="1200" height="800" loading="lazy" decoding="async"
             alt="Hands typing at a laptop beside an open notebook and pencil">
      </figure>

      <div class="tsv-cnt__howt" data-rv data-rv-d="90">
        <h3 class="tsv-sub">How the pages get made</h3>
        <p class="tsv-cnt__lead">Agents do the work that scales: reading the panel, assembling the brief, checking every claim against its source. People do the work that has to be owned — the argument, the judgement and the byline.</p>
        <ul class="tsv-how" role="list" data-bdh-stagger>
          <?php foreach ($tsv_ct_how as $tsv_ch): ?>
            <li>
              <span class="tsv-how__i"><?= xt_icon($tsv_ch[1], ['size' => 20]) ?></span>
              <b><?= e($tsv_ch[0]) ?></b>
              <small><?= e($tsv_ch[2]) ?></small>
            </li>
          <?php endforeach; ?>
        </ul>
        <p class="tsv-note">
          <?= xt_icon('doc', ['size' => 18]) ?>
          <span><b>Where this comes from.</b> Google’s guidance asks for helpful, reliable, people-first content and treats scaled content produced primarily to game rankings as spam — regardless of whether a person or a model wrote it. We use AI where it makes an editor faster and more accurate, never to fill a site with pages nobody asked for.</span>
        </p>
      </div>
    </div>

  </div>
</section>
