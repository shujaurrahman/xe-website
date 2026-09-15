<?php /* DRAFT COPY — review before launch */
/* §9 Deliverables — the $BD deliver list as the document's appendix drawer: one filing folder per
   appendix, tabs staggered across the drawer like a real file, each folder stamped with its formats
   and the clause it evidences. */
$cbf_app = [   // aligned to $CAP['deliver'] order: [clause, what is filed inside]
    ['§ 1.1', 'The purpose, vision and mission in plain words, with the drafts they replaced.'],
    ['§ 1.2', 'The signed statement, and the proof behind every claim in it.'],
    ['§ 1.3', 'Each value written as a rule, with the past decisions it would have settled.'],
    ['§ 1.4', 'Who the brand is for, what they need, and the evidence behind the insight.'],
    ['§ 1.5', 'The same story told for a lift, a deck and a new starter.'],
    ['§ 08',  'The whole foundation on one sheet, for the wall and the first page of every brief.'],
];
?>
<section class="band cbf-app" id="deliverables" aria-labelledby="deliverables-t">
  <div class="wrap">
    <header class="cbf-head cbf-head--split" data-rv>
      <p class="cbf-head__sec"><b>§ 09</b>Appendices</p>
      <div class="cbf-head__body">
        <h2 class="h2" id="deliverables-t"><span class="g">What you receive,</span> filed as appendices.</h2>
        <p class="lead">Every clause in the charter ships with its own appendix: the decision, the evidence behind it and a format your teams already use.</p>
      </div>
    </header>

    <div class="cbf-app__drawer">
      <p class="cbf-app__label"><span class="cbf-mono">Appendix drawer · Your brand foundation</span><span class="cbf-mono"><?= count($CAP['deliver']) ?> files</span></p>
      <ol class="cbf-app__files" data-rv-s>
        <?php foreach ($CAP['deliver'] as $cbf_i => $cbf_d): $cbf_letter = chr(65 + $cbf_i); $cbf_a = $cbf_app[$cbf_i] ?? ['', '']; ?>
          <li class="cbf-app__file" style="--t:<?= $cbf_i ?>">
            <span class="cbf-app__tab" aria-hidden="true">App. <?= $cbf_letter ?></span>
            <div class="cbf-app__body">
              <p class="cbf-app__ref"><span class="cbf-mono">Evidences</span> <?= e($cbf_a[0]) ?></p>
              <h3 class="cbf-app__h"><span class="bdh-sr">Appendix <?= $cbf_letter ?>: </span><?= e($cbf_d[0]) ?></h3>
              <p class="cbf-app__in"><?= e($cbf_a[1]) ?></p>
              <p class="cbf-app__fmt"><span class="bdh-sr">Formats: </span>
                <?php foreach (array_map('trim', explode('·', $cbf_d[1])) as $cbf_f): ?><span><?= e($cbf_f) ?></span><?php endforeach; ?>
              </p>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
      <p class="cbf-app__foot">Handed over as editable files, with the working sessions’ notes and the interview synthesis kept on file for the next review.</p>
    </div>
  </div>
</section>
