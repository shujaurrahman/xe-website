<?php /* DRAFT COPY — review before launch */
/* Done — the Post/Redirect/Get success state. Reloading it cannot resend anything, because the
   brief was sent by the POST that redirected here. It confirms the reference, whether a document
   travelled with it, and what happens now. #route follows it with the full five-station picture.
   PLACEHOLDER: confirm the response times quoted here before launch. */
?>
<section class="band ct-done" aria-labelledby="ct-done-t" data-ct-sent>
  <div class="wrap">
    <div class="ct-done__card" data-rv>
      <span class="ct-done__tick" aria-hidden="true"><?= svc_icon('tick') ?></span>
      <div class="ct-done__main">
        <p class="lbl lbl--blue"><span class="dot"></span>Sent</p>
        <h2 class="ct-done__t" id="ct-done-t"><?= $ct_apps ? 'We have your application.' : 'We have your brief.' ?></h2>
        <?php if ($CT['ref']): ?>
          <p class="ct-done__ref"><span>Reference</span><b><?= e($CT['ref']) ?></b></p>
        <?php endif; ?>
        <?php if ($CT['doc']): ?>
          <p class="ct-done__doc"><span aria-hidden="true"><?= svc_icon('doc') ?></span>Your document travelled with it, renamed against the reference. The copy on this server has already been deleted.</p>
        <?php endif; ?>
        <p class="ct-done__p">It is with the team now. If anything changes before we reply, write to
          <a href="mailto:<?= e($SITE['company']['email']) ?>"><?= e($SITE['company']['email']) ?></a><?= $CT['ref'] ? ' and quote the reference' : '' ?>.</p>
      </div>
      <ol class="ct-next">
        <?php if ($ct_apps): ?>
          <li><span class="ct-next__n">01</span><b>The hiring lead reads it.</b><span>Every application is read by a person, not screened by keyword.</span></li>
          <li><span class="ct-next__n">02</span><b>You hear back either way.</b><span>We aim to reply within five working days, with next steps or a clear no.</span></li>
          <li><span class="ct-next__n">03</span><b>A conversation, then a task.</b><span>If it fits, a first call and a short, scoped work sample.</span></li>
        <?php else: ?>
          <li><span class="ct-next__n">01</span><b>It goes to the right lead.</b><span>Each brief is routed to the lead for the discipline it is about.</span></li>
          <li><span class="ct-next__n">02</span><b>A named lead replies.</b><span>We aim to reply within one working day, with questions or a time to talk.</span></li>
          <li><span class="ct-next__n">03</span><b>Thirty minutes, then a scope.</b><span>A call, a straight answer, and a written scope if we are the right team.</span></li>
        <?php endif; ?>
      </ol>
      <div class="ct-done__go">
        <?php if ($ct_from): ?>
          <a class="btn btn--out" href="<?= e($ct_from['url']) ?>">Back to <?= e($ct_from['name']) ?> <span class="i" aria-hidden="true">›</span></a>
        <?php endif; ?>
        <a class="btn btn--ink" href="<?= xe_url('services/') ?>">Explore our services <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out" href="<?= xe_url('work.php') ?>">See the work <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>
  </div>
</section>
