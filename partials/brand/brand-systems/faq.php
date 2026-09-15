<?php /* DRAFT COPY — review before launch */
/* 12 · FAQ ($CAP['faq']) as docs-style reference: a search field and category chips filter a
   full-width list; rows open with the core accordion ([data-acc]). Extra questions are DRAFT. */
$cbs_fq_cat = ['Setup', 'Tooling', 'Governance', 'Setup'];   // category for each $CAP['faq'] item, in order
$cbs_fq_extra = [
    ['How do tokens reach our design tools and code?', 'One source file exports to CSS variables, JSON and design-tool variables on every release. Nobody copies values by hand.', 'Tooling'],
    ['What happens when a market needs something the system does not have?', 'It asks inside the flex ranges first. If the need sits outside them, it becomes a proposal, and the system owner decides whether it joins the system or stays a local exception.', 'Governance'],
    ['Where do AI agents fit in?', 'Agents check assets against tokens, ranges and contrast, cluster duplicates in audits and draft release notes. People review what they flag and make every decision that ships.', 'Tooling'],
];
$cbs_fq = [];
foreach ($CAP['faq'] as $cbs_qi => $cbs_q) { $cbs_fq[] = [$cbs_q[0], $cbs_q[1], $cbs_fq_cat[$cbs_qi] ?? 'Setup']; }
$cbs_fq = array_merge($cbs_fq, $cbs_fq_extra);
$cbs_fq_cats = ['All', 'Setup', 'Governance', 'Tooling'];
?>
<section class="band cbs-fq" id="faq" aria-labelledby="cbs-fq-t">
  <div class="wrap">
    <header class="cbs-head cbs-head--split" data-rv>
      <p class="cbs-head__path"><b>12</b><i>/</i>reference<i>/</i>questions</p>
      <h2 class="cbs-head__h" id="cbs-fq-t"><span class="g">Questions teams ask</span> before they start.</h2>
      <p class="lead cbs-head__lead">Filter by topic or search. If your question is not here, it is a good one to bring to the first call.</p>
    </header>

    <div class="cbs-fq__box" data-cbs-fq>
      <div class="cbs-fq__bar">
        <div class="cbs-fq__search">
          <label class="bdh-sr" for="cbs-fq-q">Search questions</label>
          <input type="search" id="cbs-fq-q" placeholder="Search questions" autocomplete="off" data-cbs-fq-q aria-describedby="cbs-fq-count">
        </div>
        <div class="cbs-fq__chips" role="group" aria-label="Filter by topic">
          <?php foreach ($cbs_fq_cats as $cbs_ck): ?>
            <button type="button" class="cbs-fq__chip" aria-pressed="<?= $cbs_ck === 'All' ? 'true' : 'false' ?>" data-cbs-fq-cat="<?= e($cbs_ck) ?>"><?= e($cbs_ck) ?><span data-cbs-fq-n><?= $cbs_ck === 'All' ? count($cbs_fq) : count(array_filter($cbs_fq, fn ($cbs_x) => $cbs_x[2] === $cbs_ck)) ?></span></button>
          <?php endforeach; ?>
        </div>
        <p class="cbs-fq__count" id="cbs-fq-count" role="status" aria-live="polite" data-cbs-fq-count><?= count($cbs_fq) ?> questions</p>
      </div>

      <div class="cbs-fq__list" data-acc>
        <?php foreach ($cbs_fq as $cbs_qi => $cbs_q): ?>
          <div class="cbs-fq__row" data-cbs-fq-row data-cat="<?= e($cbs_q[2]) ?>">
            <span class="cbs-fq__cat" aria-hidden="true"><?= e($cbs_q[2]) ?></span>
            <h3 class="cbs-fq__q">
              <button type="button" data-acc-b aria-expanded="false" aria-controls="cbs-fq-a<?= $cbs_qi ?>" id="cbs-fq-b<?= $cbs_qi ?>">
                <span class="cbs-fq__id" aria-hidden="true">Q<?= sprintf('%02d', $cbs_qi + 1) ?></span><span class="cbs-fq__qt"><?= e($cbs_q[0]) ?></span><i class="cbs-fq__pm" aria-hidden="true"></i>
              </button>
            </h3>
            <div class="cbs-fq__a" id="cbs-fq-a<?= $cbs_qi ?>" role="region" aria-labelledby="cbs-fq-b<?= $cbs_qi ?>" data-acc-p>
              <p><?= e($cbs_q[1]) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <p class="cbs-fq__none" hidden data-cbs-fq-none>No questions match. Clear the search or pick another topic.</p>
    </div>
  </div>
</section>
