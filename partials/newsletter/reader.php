<?php /* DRAFT COPY — review before launch */
/* Who it is for — four readers, each with the thing they would use it for and the thing that would
   make it a waste of their inbox. The "skip it if" line is the point of the section: a newsletter that
   claims to be for everyone is for nobody, and saying who should not subscribe is cheaper for both
   sides than an unsubscribe. */
?>
<section class="band nlt-rdr" id="reader" aria-labelledby="reader-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Who it is for</p>
        <h2 class="h2" id="reader-t"><span class="g">Four people it is written for,</span> and what would make it a waste of your inbox.</h2>
      </div>
      <div>
        <p class="lead">It is written for people who have to make a decision with technology in it and would rather
          not be sold to on the way. If none of these is close enough, do not subscribe — read the journal instead,
          which costs you nothing and asks for nothing.</p>
        <a class="tl" href="<?= xe_url('blog/index.php') ?>">Read the journal <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <ul class="nlt-rdr__l" data-rv-s data-rv-step="80">
      <?php foreach ($NLT['readers'] as $rdr_i => $rdr_r): ?>
        <li class="nlt-rdr__i">
          <article class="nlt-rdr__c">
            <span class="nlt-rdr__bar" aria-hidden="true"></span>
            <p class="nlt-rdr__code" aria-hidden="true"><?= e($rdr_r[0]) ?></p>
            <h3 class="nlt-rdr__who"><?= e($rdr_r[1]) ?></h3>
            <dl class="nlt-rdr__d">
              <dt>You would use it for</dt>
              <dd><?= e($rdr_r[2]) ?></dd>
              <dt class="nlt-rdr__skip">Skip it if</dt>
              <dd><?= e($rdr_r[3]) ?></dd>
            </dl>
          </article>
        </li>
      <?php endforeach; ?>
    </ul>

    <p class="nlt-rdr__foot" data-rv>
      <span class="nlt-k">One more honest line</span>
      Nobody at Xterra Edze is measured on how many addresses this page collects. There is no subscriber target
      on a dashboard somewhere, which is why this section is allowed to talk you out of it.
    </p>
  </div>
</section>
