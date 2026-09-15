<?php /* DRAFT COPY — review before launch */
/* §0 Hero — the headline, then the document itself: a positioning line being redrafted in
   redline, with the document's metadata column. HTML is the finished (ratified) state with the
   last revision still visible; hero.js replays the drafts from v0.1. */
$cbf_hero_slots = [   // each slot's text per draft (v0.1, v0.4, v0.7, v1.0) — the statement is illustrative
    ['Your brand is', 'Your brand is', 'Your brand is', 'Your brand is'],
    ['a leading, innovative provider of end-to-end solutions', 'the operations partner', 'the operations partner', 'the operations partner'],
    ['for businesses of every size.', 'for businesses of every size.', 'for finance teams who close the month under pressure,', 'for finance teams who close the month under pressure,'],
    ['', '', '', 'because every figure can be traced to its source.'],
];
$cbf_hero_revs = [   // [version, status, last decision, note author, note]
    ['v0.1', 'First draft',      'None yet',                     'Draft',      'Written from the documents already in circulation.'],
    ['v0.4', 'Agent review',     '§1.2 frame narrowed',          'Agent',      '“Leading” and “innovative” recur across the category statements scanned.'],
    ['v0.7', 'Leadership read',  '§1.2 audience named',          'Strategist', 'Name the people who choose us, not everyone who could.'],
    ['v1.0', 'Ratified',         '§1.2 reason to believe added', 'Exec team',  'Signed. Every later brief starts from this line.'],
];
$cbf_hero_last = count($cbf_hero_revs) - 1;
$cbf_hero_json = json_encode(['slots' => $cbf_hero_slots, 'revs' => $cbf_hero_revs], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP);
?>
<section class="cbf-hero" id="top" aria-labelledby="hero-t">
  <span class="cbf-hero__ground dots" aria-hidden="true"></span>
  <div class="wrap cbf-hero__in">
    <nav class="cbf-hero__crumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="<?= xe_url('services/') ?>">Services</a></li>
        <li><a href="<?= xe_discipline_url($BRAND) ?>"><?= e($BRAND['name']) ?></a></li>
        <li><span aria-current="page"><?= e($CAP['name']) ?></span></li>
      </ol>
    </nav>

    <div class="cbf-hero__top">
      <div class="cbf-hero__say">
        <p class="lbl lbl--blue"><span class="dot"></span><?= e($BRAND['n']) ?>.<?= e($CAP['n']) ?> · <?= e($CAP['name']) ?> · <?= e($CAP['kicker']) ?></p>
        <h1 class="cbf-hero__h" id="hero-t"><?= $CAP['title'] ?></h1>
      </div>
      <div class="cbf-hero__aside">
        <p class="lead"><?= e($CAP['lead']) ?></p>
        <div class="cbf-hero__act">
          <a class="btn btn--ink btn--lg" href="<?= xe_url('contact.php') ?>"><?= e($CAP['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
          <a class="btn btn--out btn--lg" href="#composer">Draft a positioning <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>
    </div>

    <!-- PLACEHOLDER: illustrative positioning statement and document metadata — confirm before launch -->
    <article class="cbf-doc" aria-label="Illustrative foundation document, section 1.2, redrafted to version 1.0" data-cbf-hero='<?= $cbf_hero_json ?>'>
      <header class="cbf-doc__bar">
        <span class="cbf-doc__id">Foundation document · Your brand · <span class="cbf-doc__ref">DOC-BF-01</span></span>
        <span class="cbf-doc__bar-r"><span class="cbf-ill">Illustrative</span><span class="cbf-doc__page">Page 1 of 1</span></span>
      </header>

      <div class="cbf-doc__body">
        <div class="cbf-doc__margin" aria-hidden="true">
          <span class="cbf-doc__sec">§ 1.2</span>
          <span class="cbf-doc__sec-n">Positioning</span>
          <span class="cbf-doc__lines"><i>01</i><i>02</i><i>03</i><i>04</i></span>
        </div>

        <div class="cbf-doc__main">
          <p class="cbf-doc__line" aria-live="off">
            <?php foreach ($cbf_hero_slots as $cbf_i => $cbf_slot):
                $cbf_prev = $cbf_slot[$cbf_hero_last - 1]; $cbf_now = $cbf_slot[$cbf_hero_last]; ?>
              <span class="cbf-doc__slot" data-slot="<?= $cbf_i ?>"><?php if ($cbf_prev !== $cbf_now && $cbf_prev !== ''): ?><del class="cbf-doc__del"><?= e($cbf_prev) ?></del> <?php endif; ?><?php if ($cbf_prev !== $cbf_now): ?><ins class="cbf-doc__ins"><?= e($cbf_now) ?></ins><?php else: ?><span class="cbf-doc__txt"><?= e($cbf_now) ?></span><?php endif; ?></span>
            <?php endforeach; ?>
          </p>
          <p class="cbf-doc__note">
            <span class="cbf-doc__who" data-k="who"><?= e($cbf_hero_revs[$cbf_hero_last][3]) ?></span>
            <span class="cbf-doc__say" data-k="note"><?= e($cbf_hero_revs[$cbf_hero_last][4]) ?></span>
          </p>
        </div>

        <dl class="cbf-doc__meta">
          <div><dt>Version</dt><dd data-k="ver"><?= e($cbf_hero_revs[$cbf_hero_last][0]) ?></dd></div>
          <div><dt>Status</dt><dd data-k="status"><i class="cbf-doc__led" aria-hidden="true"></i><span><?= e($cbf_hero_revs[$cbf_hero_last][1]) ?></span></dd></div>
          <div><dt>Owners</dt><dd>Executive team · Brand lead</dd></div>
          <div><dt>Last decision</dt><dd data-k="last"><?= e($cbf_hero_revs[$cbf_hero_last][2]) ?></dd></div>
          <div class="cbf-doc__steps" aria-hidden="true"><dt>Revisions</dt><dd><?php foreach ($cbf_hero_revs as $cbf_i => $cbf_r): ?><i class="<?= $cbf_i === $cbf_hero_last ? 'is-on' : 'is-done' ?>"><?= e($cbf_r[0]) ?></i><?php endforeach; ?></dd></div>
        </dl>
      </div>

      <footer class="cbf-doc__foot">
        <?php foreach ($CAP['meta'] as $cbf_i => $cbf_m): ?>
          <p><span><?= e($CAP['meta_k'][$cbf_i] ?? '') ?></span><b><?= e($cbf_m) ?></b></p>
        <?php endforeach; ?>
      </footer>
    </article>
  </div>
</section>
