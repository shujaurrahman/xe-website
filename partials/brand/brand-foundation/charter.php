<?php /* DRAFT COPY — review before launch */
/* §2 Charter — the six $BD offer items set as clauses 1.1–1.6 of a governing document, each with its
   standard (the $BD tag), a cross-reference to where this page shows it working, and an initial box. */
$cbf_charter_xref = [   // offer index => [anchor, label]
    ['#narrative', '§ 06 Narrative'],
    ['#composer',  '§ 04 Composer'],
    ['#rules',     '§ 05 Decision rules'],
    ['#tensions',  '§ 03 Tension map'],
    ['#narrative', '§ 06 Narrative'],
    ['#rules',     '§ 05 Decision rules'],
];
?>
<section class="band band--alt cbf-charter" id="charter" aria-labelledby="charter-t">
  <div class="wrap">
    <header class="cbf-head cbf-head--split" data-rv>
      <p class="cbf-head__sec"><b>§ 02</b>Charter</p>
      <div class="cbf-head__body">
        <h2 class="h2" id="charter-t"><?= $CAP['offer_title'] ?></h2>
        <p class="lead"><?= e($CAP['offer_lead']) ?></p>
      </div>
    </header>

    <article class="cbf-charter__sheet" aria-labelledby="charter-art">
      <header class="cbf-charter__top">
        <p class="cbf-charter__art" id="charter-art">Article 1 <span aria-hidden="true">—</span> What the brand decides</p>
        <p class="cbf-charter__pre">The leadership team agrees the clauses below, in plain words, and tests each one against decisions already made before it is signed.</p>
      </header>

      <ol class="cbf-charter__list">
        <?php foreach ($CAP['offer'] as $cbf_i => $cbf_o): $cbf_no = '1.' . ($cbf_i + 1); ?>
          <li class="cbf-charter__cl" data-rv>
            <span class="cbf-charter__no" aria-hidden="true"><?= e($cbf_no) ?></span>
            <div class="cbf-charter__main">
              <h3 class="cbf-charter__t"><span class="bdh-sr">Clause <?= e($cbf_no) ?>: </span><?= e($cbf_o[0]) ?></h3>
              <p class="cbf-charter__x"><?= e($cbf_o[1]) ?></p>
            </div>
            <dl class="cbf-charter__side">
              <div><dt>Standard</dt><dd><?= e($cbf_o[2]) ?></dd></div>
              <div><dt>See</dt><dd><a href="<?= e($cbf_charter_xref[$cbf_i][0]) ?>"><?= e($cbf_charter_xref[$cbf_i][1]) ?></a></dd></div>
            </dl>
            <span class="cbf-charter__init" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M5 12.5l4.2 4.2L19 7"/></svg></span>
          </li>
        <?php endforeach; ?>
      </ol>

      <footer class="cbf-charter__sign">
        <p><span>Signed for</span><b>Your brand · Executive team</b></p>
        <p><span>Initialled</span><b><?= count($CAP['offer']) ?> of <?= count($CAP['offer']) ?> clauses</b></p>
        <p><span>Review</span><b>Annually, or when strategy changes</b></p>
      </footer>
    </article>
  </div>
</section>
