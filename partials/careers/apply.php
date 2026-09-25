<?php /* DRAFT COPY — review before launch */
/* The last section: the general application. The form itself lives on its own page, /careers/apply,
   which the owner asked for; with no ?role= it opens as a general application. What this section
   adds is the thing that makes a general application worth reading — what to put in it.
   Locals prefixed gn_. */
$gn_send = [
    ['The one thing you want to spend your time on', 'A general application that says "anything creative" is the hardest kind to place. One sentence of specificity puts it in front of the right lead.'],
    ['Work, with your own part named',               'A link and a CV. On team projects, say plainly which decisions were yours.'],
    ['What you want to get better at',               'It tells us which practice would actually be good for you, which is a different question from which one you would be good at.'],
    ['When you could start, and from where',         'Notice period and city. Neither has ever been the reason we did not make an offer.'],
];
?>
<section class="band car-gen" id="apply" aria-labelledby="apply-t">
  <div class="wrap car-gen__grid">
    <div class="car-gen__copy">
      <p class="lbl lbl--blue"><span class="dot"></span>General application</p>
      <h2 class="h2" id="apply-t"><span class="g">Not seeing your role?</span> Tell us what you do best.</h2>
      <p class="lead">Strong people have shaped roles here that were not on this page when they wrote in. A general application goes to the same inbox, is read by the same practice leads, and gets the same written answer either way.</p>
      <ul class="car-gen__list">
        <?php foreach ($gn_send as $gn_i => $gn_s): ?>
        <li><span class="car-gen__n"><?= str_pad((string) ($gn_i + 1), 2, '0', STR_PAD_LEFT) ?></span><b><?= e($gn_s[0]) ?></b><span><?= e($gn_s[1]) ?></span></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="car-apply car-apply--gen">
      <p class="car-apply__h">Start an application</p>
      <p class="car-apply__note">About ten minutes: your details, the role or a general application, links to your work, your CV and two questions worth answering properly.</p>
      <ul class="car-apply__facts">
        <li><?= xt_icon('doc', ['size' => 17]) ?><span>CV as PDF, DOC or DOCX</span></li>
        <li><?= xt_icon('lock', ['size' => 17]) ?><span>Nothing is stored on this website</span></li>
        <li><?= xt_icon('clock', ['size' => 17]) ?><span>Target: an answer in five working days</span></li>
      </ul>
      <!-- PLACEHOLDER: confirm the five-working-day reply target before launch -->
      <a class="btn btn--ink car-apply__go" href="<?= e(xe_url('careers/apply.php')) ?>">Start a general application <span class="i" aria-hidden="true">›</span></a>
      <p class="car-apply__fine">Applying for something specific? Every listing above has its own <a class="tl" href="#roles">apply link</a>, which fills the role in for you. How we handle what you send is set out in our <a class="tl" href="<?= e(xe_url('legal/privacy.php')) ?>">privacy notice</a>.</p>
    </div>
  </div>
</section>
