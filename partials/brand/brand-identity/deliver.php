<?php /* DRAFT COPY — review before launch */
/* Plate 10 — Deliverables ($CAP['deliver']) as the guidelines book's contents page: chapters with dotted
   leaders and page numbers on the left page; the chosen chapter's opening page on the right. */
$dl_inside = [   // three lines per $CAP['deliver'] row, same order
    ['Master mark, wordmark and lockups', 'Clear space and minimum sizes', 'Misuse, drawn rather than described'],
    ['Palette with roles and proportions', 'Approved contrast pairings', 'Tokens named for design tools and code'],
    ['Three faces and the job each one does', 'Scale, line height and measure', 'Fallbacks for Office and email'],
    ['Voice principles with before-and-after lines', 'Tone for the moments that matter most', 'Words we use, and words we never use'],
    ['Principles for first open, errors and goodbyes', 'Worked examples for each moment', 'What to do when two principles conflict'],
    ['Four curves and their timings', 'The mark in motion', 'Do and do-not clips'],
    ['Searchable online reference', 'Versioned PDF export', 'Change log and named owners'],
    ['Presentation, document and email templates', 'Social and advertising frames', 'Signage and merchandise artwork'],
];
$dl_pages = [4, 10, 18, 24, 32, 38, 44, 50];   // PLACEHOLDER: illustrative page numbers
?>
<section class="cbi-sec cbi-dl" id="deliver" aria-labelledby="deliver-t">
  <div class="wrap">
    <div class="cbi-head" data-rv>
      <p class="cbi-head__folio"><span>Plate 10 · Deliverables</span><span><?= count($CAP['deliver']) ?> chapters</span></p>
      <div class="cbi-head__t">
        <h2 class="h2" id="deliver-t"><span class="g">What you hold at the end:</span> the book, and every file it points to.</h2>
      </div>
      <p class="lead">Each chapter ships with the files your teams will actually open. The guidelines live online and export to PDF, so the book and the library never disagree.</p>
    </div>

    <div class="cbi-dl__book">
      <div class="cbi-dl__page cbi-dl__page--l">
        <p class="cbi-dl__run"><span>Your brand</span><span>Identity guidelines · v1.0</span></p>
        <h3 class="cbi-dl__contents">Contents</h3>
        <ol class="cbi-dl__toc">
          <?php foreach ($CAP['deliver'] as $dl_i => $dl_d): ?>
          <li>
            <button type="button" class="cbi-dl__ch" data-i="<?= $dl_i ?>" aria-pressed="<?= $dl_i === 0 ? 'true' : 'false' ?>" aria-controls="deliver-open">
              <span class="cbi-dl__n"><?= sprintf('%02d', $dl_i + 1) ?></span>
              <span class="cbi-dl__name"><?= e($dl_d[0]) ?><small><?= e($dl_d[1]) ?></small></span>
              <span class="cbi-dl__dots" aria-hidden="true"></span>
              <span class="cbi-dl__pg"><span class="bdh-sr">page </span><?= $dl_pages[$dl_i] ?? '' ?></span>
            </button>
          </li>
          <?php endforeach; ?>
        </ol>
        <p class="cbi-dl__folio"><span>ii</span><span class="cbi-ill">Illustrative pagination</span></p>
      </div>

      <div class="cbi-dl__page cbi-dl__page--r" id="deliver-open" aria-live="polite">
        <?php foreach ($CAP['deliver'] as $dl_i => $dl_d): ?>
        <div class="cbi-dl__open<?= $dl_i === 0 ? ' is-on' : '' ?>" data-i="<?= $dl_i ?>">
          <p class="cbi-dl__run"><span>Chapter <?= sprintf('%02d', $dl_i + 1) ?></span><span><?= e($dl_d[1]) ?></span></p>
          <span class="cbi-dl__big" aria-hidden="true"><?= sprintf('%02d', $dl_i + 1) ?></span>
          <p class="cbi-dl__title"><?= e($dl_d[0]) ?></p>
          <ul class="cbi-dl__inside"><?php foreach ($dl_inside[$dl_i] ?? [] as $dl_x): ?><li><?= e($dl_x) ?></li><?php endforeach; ?></ul>
          <p class="cbi-dl__fmts"><span class="cbi-lbl">Delivered as</span><?php foreach (explode('·', $dl_d[1]) as $dl_f): ?><b><?= e(trim($dl_f)) ?></b><?php endforeach; ?></p>
          <p class="cbi-dl__folio"><span>Chapter <?= sprintf('%02d', $dl_i + 1) ?></span><span><?= $dl_pages[$dl_i] ?? '' ?></span></p>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
