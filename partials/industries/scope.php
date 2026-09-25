<?php /* DRAFT COPY — review before launch */
/* Scope — the index of the six categories and why they are grouped this way. Three organising axes on
   the left, then one row per category: index, name and eyebrow, the sentence that says what it is under,
   the two disciplines that usually lead, and a jump into that category's brief further down the page.
   No JavaScript: the rows are anchors, and the reveal resolves itself with JS off. */
$ind_axes = [
    ['target',  'What decides a purchase', 'One person in a minute, or a committee over two quarters. Decision length sets the content, the measurement window and the sales motion.'],
    ['doc',     'What governs the words',  'Claim law, an advertising code, a disclosure regime or a buyer’s evidence pack. It is settled before a layout exists.'],
    ['compass', 'Where it is experienced', 'A shelf, a branch, a lobby, an app, someone else’s listing, someone else’s answer engine. Each surface has an owner and a lead time.'],
];
?>
<section class="band ind-scope" id="scope" aria-labelledby="scope-t">
  <div class="wrap">
    <div class="ind-head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Who we serve</p>
        <h2 class="h2" id="scope-t"><span class="g">Six categories,</span> grouped by how their decisions get made.</h2>
      </div>
      <div>
        <p class="lead">We do not organise by sector code. A category earns a place here when we understand what decides a purchase in it, what governs the words, and where the experience is actually had. These six are the ones we can go deep in.</p>
      </div>
    </div>

    <div class="ind-scope__grid">
      <ol class="ind-scope__axes" data-rv-s data-rv-step="70" aria-label="What we read a category against">
        <?php foreach ($ind_axes as $ind_ai => $ind_ax): ?>
          <li>
            <span class="ind-scope__axi" aria-hidden="true"><?= xt_icon($ind_ax[0], ['size' => 20]) ?></span>
            <p class="ind-k">Axis <?= str_pad((string) ($ind_ai + 1), 2, '0', STR_PAD_LEFT) ?></p>
            <h3 class="bdh-t bdh-t--s"><?= e($ind_ax[1]) ?></h3>
            <p class="bdh-d"><?= e($ind_ax[2]) ?></p>
          </li>
        <?php endforeach; ?>
      </ol>

      <ol class="ind-scope__list" data-rv-s data-rv-step="60">
        <?php foreach ($IND_SET as $ind_c): ?>
          <li>
            <a class="ind-scope__row" href="#<?= e($ind_c['slug']) ?>">
              <span class="ind-scope__n"><?= e($ind_c['n']) ?></span>
              <span class="ind-scope__main">
                <span class="ind-scope__name"><?= e($ind_c['name']) ?></span>
                <span class="ind-scope__kick"><?= e($ind_c['kicker']) ?></span>
              </span>
              <span class="ind-scope__line"><?= e($ind_c['line']) ?></span>
              <span class="ind-scope__led">
                <span class="ind-k">Usually led by</span>
                <?php foreach ($ind_c['led'] as $ind_ls): $ind_d = $IND_DISC($ind_ls); ?>
                  <span class="ind-chip"><?= e($ind_d['short'] ?? $ind_ls) ?></span>
                <?php endforeach; ?>
              </span>
              <span class="ind-scope__go">Read the brief <i aria-hidden="true">›</i></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <div class="ind-foot" data-rv>
      <p class="ind-note">
        Every category below is written against the same five questions, so two briefs can be compared
        line for line. Regulatory notes are a summary for orientation, not legal advice.
      </p>
    </div>
  </div>
</section>
