<?php /* DRAFT COPY — review before launch */
/* 03 Training set curator — the Ground phase made tangible. A batch of references, each with
   an agent's suggestion; a person approves or rejects (buttons, or A / R on a focused tile).
   Dataset stats and rejection reasons recount live. HTML = the decided batch; curate.js replays it. */
$cat_step = $CAT['process']['steps'][0];   // Ground
$cat_tiles = [   // [id, kind, src|art, alt, category, source, agent verdict, agent note, reason if rejected]
    ['ref-0231', 'img', 'tile-teapot.jpg',       'A white porcelain teapot lit from the side against black', 'Product', 'Studio 2 · owned',    'approve', 'palette match 0.94', ''],
    ['ref-0232', 'art', 'palette',               '',                                                          'Rules',   'Brand system v7',     'approve', 'tokens v7 · exact',  ''],
    ['ref-0233', 'img', 'gen-blue-gradient.jpg', 'A soft abstract wash of blue light',                        'Mood',    'Stock · licence ends', 'reject', 'rights unclear',     'Rights unclear'],
    ['ref-0234', 'img', 'tile-shell.jpg',        'A single white seashell on a pale grey ground',             'Texture', 'Studio 2 · owned',    'approve', 'tone match 0.91',    ''],
    ['ref-0235', 'art', 'lockup-old',            '',                                                          'Rules',   'Archive 2019',        'reject',  'superseded identity', 'Outdated identity'],
    ['ref-0236', 'img', 'gen-shadow-object.jpg', 'A sculptural object casting a long shadow on a wall',       'Product', 'Archive 2023 · owned', 'approve', 'palette match 0.89', ''],
    ['ref-0237', 'art', 'type',                  '',                                                          'Rules',   'Brand system v7',     'approve', 'type scale · exact', ''],
    ['ref-0238', 'img', 'gen-vase.jpg',          'A ceramic vase on a table in soft daylight',                'Product', 'Agency upload',       'reject',  'near-duplicate of ref-0231', 'Duplicate'],
];
$cat_reasons = ['Rights unclear', 'Outdated identity', 'Duplicate', 'Off palette'];
$cat_cats = ['Product', 'Rules', 'Mood', 'Texture'];
$cat_img = fn ($f) => xe_url('assets/imgs/brand/brand-ai-tools/' . $f);
?>
<section class="band cat-paper cat-paper--alt cat-cur" id="curate" aria-labelledby="curate-t">
  <div class="wrap">
    <div class="cat-head" data-rv>
      <div>
        <p class="cat-prompt"><b>$ brandctl curate ./references</b> <span>phase 01 · <?= e($cat_step[0]) ?> · <?= e($cat_step[1]) ?></span></p>
        <h2 class="h2" id="curate-t"><span class="g">A model learns what it is shown.</span> People choose what it sees.</h2>
      </div>
      <p class="lead">Before any tuning, the brand system becomes a training set. An agent sorts, labels and rights-checks every reference and suggests a verdict; a person approves or rejects each one. Nothing enters the set without a name against it.</p>
    </div>

    <div class="cat-cur__ui" data-rv>
      <div class="cat-cur__batch">
        <div class="cat-cur__bar">
          <span class="cat-mono">batch 14 · <b data-cur-left>0</b> left to decide</span>
          <span class="cat-cur__keys"><span class="cat-kbd">A</span> approve <span class="cat-kbd">R</span> reject <span class="cat-kbd">U</span> undo</span>
        </div>
        <ul class="cat-cur__grid">
          <?php foreach ($cat_tiles as $cat_ti => $cat_t): $cat_st = $cat_t[6] === 'approve' ? 'approved' : 'rejected'; ?>
            <li class="cat-cur__tile" data-state="<?= $cat_st ?>" data-verdict="<?= $cat_t[6] ?>" data-cat="<?= e($cat_t[4]) ?>" data-reason="<?= e($cat_t[8]) ?>" tabindex="0" aria-label="<?= e($cat_t[0] . ', ' . $cat_t[4] . ', ' . $cat_t[5] . '. Agent suggests ' . $cat_t[6] . ': ' . $cat_t[7]) ?>" style="--i:<?= $cat_ti ?>">
              <div class="cat-cur__media cat-cur__media--<?= e($cat_t[2] === 'palette' || $cat_t[2] === 'type' || $cat_t[2] === 'lockup-old' ? $cat_t[2] : 'photo') ?>">
                <?php if ($cat_t[1] === 'img'): ?>
                  <!-- PLACEHOLDER: reference photography (Unsplash) — replace with your own reference library before launch -->
                  <img src="<?= $cat_img($cat_t[2]) ?>" alt="<?= e($cat_t[3]) ?>" width="525" height="700" loading="lazy" decoding="async">
                <?php elseif ($cat_t[2] === 'palette'): ?>
                  <span aria-hidden="true"><i></i><i></i><i></i><i></i><small>Palette · v7</small></span>
                <?php elseif ($cat_t[2] === 'type'): ?>
                  <span aria-hidden="true"><b>Aa</b><small>Display · 500 · −3.5%</small></span>
                <?php else: ?>
                  <span aria-hidden="true"><b>Your brand</b><small>Lockup · 2019</small></span>
                <?php endif; ?>
                <span class="cat-cur__stamp" aria-hidden="true"></span>
              </div>
              <div class="cat-cur__meta">
                <p class="cat-cur__id"><span><?= e($cat_t[0]) ?></span><span><?= e($cat_t[4]) ?></span></p>
                <p class="cat-cur__src"><?= e($cat_t[5]) ?></p>
                <p class="cat-cur__agent"><span class="cat-led<?= $cat_t[6] === 'reject' ? ' cat-led--wait' : '' ?>"></span>Agent: <?= e($cat_t[6]) ?> · <?= e($cat_t[7]) ?></p>
              </div>
              <div class="cat-cur__btns" role="group" aria-label="Decide <?= e($cat_t[0]) ?>">
                <button type="button" class="cat-cur__btn" data-act="approve" aria-pressed="<?= $cat_st === 'approved' ? 'true' : 'false' ?>">Approve</button>
                <button type="button" class="cat-cur__btn" data-act="reject" aria-pressed="<?= $cat_st === 'rejected' ? 'true' : 'false' ?>">Reject</button>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <aside class="cat-cur__side" aria-labelledby="curate-stats">
        <!-- PLACEHOLDER: reference photo (Unsplash) — replace with your own review session before launch -->
        <figure class="cat-photo cat-cur__photo">
          <img src="<?= $cat_img('prints-hands.jpg') ?>" alt="Hands sorting printed photographs across a wooden table" width="1400" height="933" loading="lazy" decoding="async">
          <figcaption><span>Reference review · in person</span></figcaption>
        </figure>
        <div class="cat-cur__stats">
          <h3 class="cat-cur__h" id="curate-stats">Batch 14 <span class="cat-illus">Illustrative</span></h3>
          <!-- PLACEHOLDER: illustrative dataset figures — confirm before launch -->
          <dl class="cat-cur__nums" aria-live="polite">
            <div><dt>Approved</dt><dd data-cur-n="approved">5</dd></div>
            <div><dt>Rejected</dt><dd data-cur-n="rejected">3</dd></div>
            <div><dt>In set v7</dt><dd data-cur-n="set">2,418</dd></div>
          </dl>
          <p class="cat-cur__cap">Coverage by category</p>
          <ul class="cat-cur__cov">
            <?php foreach ($cat_cats as $cat_cc): ?>
              <li data-cur-cat="<?= e($cat_cc) ?>"><span><?= e($cat_cc) ?></span><i><b></b></i><em>0</em></li>
            <?php endforeach; ?>
          </ul>
          <p class="cat-cur__cap">Rejection reasons</p>
          <ul class="cat-cur__why">
            <?php foreach ($cat_reasons as $cat_rr): ?>
              <li data-cur-why="<?= e($cat_rr) ?>"><span><?= e($cat_rr) ?></span><em>0</em></li>
            <?php endforeach; ?>
          </ul>
          <p class="cat-cur__out">Ships as: <?= e(implode(' · ', $cat_step[3])) ?></p>
        </div>
      </aside>
    </div>
  </div>
</section>
