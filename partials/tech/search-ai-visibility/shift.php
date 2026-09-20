<?php /* DRAFT COPY — review before launch */
/* Shift (ink) — what changed between the ten-blue-links journey and the answer-first one.
   Two journeys drawn as flow lines with labelled stops; the modern path's last leg is deliberately
   thin, because a large share of answers end without a visit. Three honest shift cards beneath, and
   one photograph on the right. CSS-only motion: the connectors draw when the section enters. */

$tsv_sh_journeys = [
    [
        'k' => 'Then', 'when' => 'The ten-links journey', 'note' => 'One query, a page of options, a visit.',
        'stops' => [
            ['Query', 'typed into the box'],
            ['Ten links', 'scanned and compared'],
            ['Click', 'usually more than one'],
            ['Your site', 'the answer is on your page'],
        ],
        'thin' => -1,
    ],
    [
        'k' => 'Now', 'when' => 'The answer-first journey', 'note' => 'One query, an answer, sometimes a visit.',
        'stops' => [
            ['Query', 'typed, spoken or prompted'],
            ['Generated answer', 'assembled from a few sources'],
            ['Citation', 'shown, not always followed'],
            ['Your site', 'or no visit at all'],
        ],
        'thin' => 3,
    ],
];

$tsv_sh_cards = [
    ['Answers cite a handful of sources',
     'A results page shows ten organic links. A generated answer usually names a few. The work is no longer ranking somewhere on page one — it is being one of the small number of pages an engine considers worth quoting for the question your buyer actually asks.',
     'quote', 'Few sources, not ten'],
    ['A citation counts even without the click',
     'When your brand is named inside the answer, the buyer has already seen you before any visit. That changes what you measure: share of answer and citation rate alongside sessions, not instead of them. We report both, and we never pass an estimate off as a measurement.',
     'radar', 'Measured and sampled'],
    ['Classic SEO is still the foundation',
     'Answer engines draw on pages that are indexed, crawlable, fast and trusted — exactly what technical SEO produces. Google states that no special markup is needed for its AI features beyond following Search Essentials. The surfaces changed; the groundwork did not.',
     'layers', 'Same groundwork'],
];
?>
<section class="band band--ink tsv-shift" id="shift" aria-labelledby="shift-t">
  <div class="wrap">

    <header class="tsv-head" data-rv>
      <div class="tsv-head__t">
        <p class="tsv-kick"><span class="tsv-kick__ref">01 · The shift</span><span>Search behaviour</span></p>
        <h2 class="h2" id="shift-t"><span class="g">Fewer clicks,</span> more answers.</h2>
      </div>
      <div class="tsv-head__l">
        <p class="lead">The question your buyer asks has not changed. What happens after they ask it has. Both journeys still start with a query, and both still end at a page someone wrote — but only one of them guarantees you a visit.</p>
      </div>
    </header>

    <div class="tsv-shift__grid">

      <div class="tsv-shift__j" data-rv>
        <?php foreach ($tsv_sh_journeys as $tsv_shi => $tsv_shj): ?>
          <div class="tsv-jrn<?= $tsv_shi === 1 ? ' is-now' : '' ?>">
            <p class="tsv-jrn__h"><span class="tsv-jrn__k"><?= e($tsv_shj['k']) ?></span><span class="tsv-jrn__w"><?= e($tsv_shj['when']) ?></span></p>
            <ol class="tsv-jrn__stops">
              <?php foreach ($tsv_shj['stops'] as $tsv_shsi => $tsv_shs): ?>
                <li class="tsv-stop<?= $tsv_shsi === $tsv_shj['thin'] ? ' is-thin' : '' ?>" style="--i:<?= $tsv_shsi ?>">
                  <span class="tsv-stop__d" aria-hidden="true"></span>
                  <b><?= e($tsv_shs[0]) ?></b>
                  <small><?= e($tsv_shs[1]) ?></small>
                </li>
              <?php endforeach; ?>
            </ol>
            <p class="tsv-jrn__n"><?= e($tsv_shj['note']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="tsv-shift__img" data-rv data-rv-d="120">
        <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch. Re-cropped below the
             browser chrome so the prompt line reads whole and no equipment or browser brand mark is legible. -->
        <figure class="bdh-img bdh-img--r43" data-bdh-parallax="0.05">
          <img src="<?= xe_url('assets/imgs/tech/search-ai-visibility/answer-bar.jpg') ?>" width="1100" height="825" loading="lazy" decoding="async"
               alt="A laptop screen showing an assistant prompt bar reading “What can I help with?”, waiting for a question">
        </figure>
        <p class="tsv-shift__cap">The box people type into is the same shape. What comes back is not.</p>

        <dl class="tsv-shift__rep">
          <div><dt>What we still report</dt><dd>Clicks, sessions and conversions, measured as before.</dd></div>
          <div><dt>What we add</dt><dd>Share of answer and citation rate, sampled weekly with the sample size shown.</dd></div>
        </dl>
      </div>

    </div>

    <ul class="tsv-shift__cards" role="list" data-rv data-bdh-stagger>
      <?php foreach ($tsv_sh_cards as $tsv_shc): ?>
        <li class="bdh-card tsv-shift__card">
          <span class="tsv-shift__ico"><?= xt_icon($tsv_shc[2], ['size' => 22]) ?></span>
          <h3 class="bdh-t"><?= e($tsv_shc[0]) ?></h3>
          <p class="bdh-d"><?= e($tsv_shc[1]) ?></p>
          <span class="bdh-tag"><?= e($tsv_shc[3]) ?></span>
        </li>
      <?php endforeach; ?>
    </ul>

  </div>
</section>
