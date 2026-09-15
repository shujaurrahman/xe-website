<?php /* DRAFT COPY — review before launch */
/* §11 FAQ — the $BD faq set as an interview transcript: timestamped Q: lines are buttons, and each A:
   is revealed in place (core [data-acc="multi"]). Timestamps are decorative. */
$cbf_tr_time = ['00:42', '03:15', '07:58', '11:20', '14:05', '16:31'];
?>
<section class="band cbf-tr" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <header class="cbf-head cbf-head--split" data-rv>
      <p class="cbf-head__sec"><b>§ 11</b>Transcript</p>
      <div class="cbf-head__body">
        <h2 class="h2" id="faq-t"><span class="g">Questions leadership teams</span> ask us first.</h2>
        <p class="lead">Taken from the first conversation, more or less word for word. Select a question to read the answer.</p>
      </div>
    </header>

    <div class="cbf-tr__doc">
      <p class="cbf-tr__meta" aria-hidden="true"><span>Transcript · first conversation</span><span>Q · Your leadership team</span><span>A · Foundation lead</span></p>
      <ol class="cbf-tr__list" data-acc="multi">
        <?php foreach ($CAP['faq'] as $cbf_i => $cbf_f): ?>
          <li class="cbf-tr__row">
            <span class="cbf-tr__ts" aria-hidden="true"><?= e($cbf_tr_time[$cbf_i] ?? '') ?></span>
            <div class="cbf-tr__body">
              <h3 class="cbf-tr__h">
                <button type="button" class="cbf-tr__q" data-acc-b aria-expanded="<?= $cbf_i === 0 ? 'true' : 'false' ?>" aria-controls="faq-a-<?= $cbf_i ?>" id="faq-q-<?= $cbf_i ?>">
                  <span class="cbf-tr__who" aria-hidden="true">Q:</span>
                  <span class="cbf-tr__qt"><?= e($cbf_f[0]) ?></span>
                  <span class="cbf-tr__more" aria-hidden="true"></span>
                </button>
              </h3>
              <div class="cbf-tr__a" id="faq-a-<?= $cbf_i ?>" data-acc-p role="region" aria-labelledby="faq-q-<?= $cbf_i ?>"<?= $cbf_i === 0 ? '' : ' style="height:0"' ?>>
                <p class="cbf-tr__at"><span class="cbf-tr__who" aria-hidden="true">A:</span><span><?= e($cbf_f[1]) ?></span></p>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
      <p class="cbf-tr__end"><span class="cbf-mono">End of transcript</span><a class="cbf-tr__ask" href="<?= xe_url('contact.php') ?>">Ask your own question <span aria-hidden="true">›</span></a></p>
    </div>
  </div>
</section>
