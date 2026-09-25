<?php /* DRAFT COPY — review before launch */
/* Questions, in three groups: the reading, your address, the mechanics. Native <details>, so every
   answer is reachable with JavaScript off and the browser handles the keyboard for us. The answer
   strings in data/newsletter.php are authored HTML — they carry the PLACEHOLDER comments that mark
   what has to be confirmed before launch — so they are echoed raw here. Nothing a visitor types ever
   reaches this file. */
$faq_open = 0;   /* the first question of the first group ships open, so the block reads as an answer */
$faq_n = 0;
foreach ($NLT['faq'] as $faq_g) { $faq_n += count($faq_g[1]); }
unset($faq_g);
$faq_words = [3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen'];
?>
<section class="band nlt-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
        <h2 class="h2" id="faq-t"><span class="g">The <?= e($faq_words[$faq_n] ?? (string) $faq_n) ?> questions</span> people actually ask about a newsletter.</h2>
      </div>
      <div>
        <p class="lead">If the one you need is not here, write to
          <a class="nlt-a" href="mailto:<?= e($SITE['company']['email']) ?>"><?= e($SITE['company']['email']) ?></a>
          and we will answer it — and probably add it.</p>
      </div>
    </div>

    <div class="nlt-faq__grid">
      <?php foreach ($NLT['faq'] as $faq_gi => $faq_g): ?>
        <div class="nlt-faq__g">
          <header class="nlt-faq__gh">
            <span class="nlt-faq__gn" aria-hidden="true"><?= str_pad((string) ($faq_gi + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <h3 class="nlt-faq__gt" id="faq-g<?= $faq_gi ?>"><?= e($faq_g[0]) ?></h3>
          </header>
          <div class="nlt-faq__l">
            <?php foreach ($faq_g[1] as $faq_qi => $faq_q): ?>
              <details class="nlt-faq__i"<?= ($faq_gi === 0 && $faq_qi === $faq_open) ? ' open' : '' ?>>
                <summary>
                  <span class="nlt-faq__q"><?= e($faq_q[0]) ?></span>
                  <span class="nlt-faq__mk" aria-hidden="true"></span>
                </summary>
                <div class="nlt-faq__a"><p><?= $faq_q[1] ?></p></div>
              </details>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
