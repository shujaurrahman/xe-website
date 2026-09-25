<?php /* DRAFT COPY — review before launch */
/* Equal opportunity, adjustments and the specific mechanics we use to take bias out of the process.
   The statement used to sit inside the general-application block; it is its own section because a
   candidate deciding whether to apply should not have to scroll past a form to find it.
   PLACEHOLDER: have counsel and HR confirm the statement, the adjustments list and every practice
   below before launch. Locals prefixed eo_. */
$eo_adjust = [
    ['clock',         'More time',                     'Longer for a work sample, or a longer call with breaks in it.'],
    ['doc',           'Questions in advance',          'The interview questions in writing, before the call, so you can think rather than perform.'],
    ['chat',          'Captions and transcripts',      'Live captions on video calls, and a written record afterwards.'],
    ['accessibility', 'A different format',            'A written exercise instead of a live one, a remote stage instead of an in-person one, or the reverse.'],
    ['pin',           'A room that works for you',     'A quiet space, step-free access, or a different time of day.'],
    ['headset',       'Someone with you',              'A support worker, interpreter or advocate in any stage, at our cost.'],
];
$eo_fair = [
    ['The same questions for everyone', 'Each stage for a role runs from one written question set, so candidates are compared on answers rather than on rapport.'],
    ['Two people, notes first',         'Every craft conversation has two interviewers, and both write their notes before they talk to each other.'],
    ['A published rubric',              'Work samples are scored against the criteria we gave you with the brief, not against a feeling afterwards.'],
    ['The range, unprompted',           'We state the pay range for the role on the first call, and we do not ask what you earn now or use it to set an offer.'],
    ['A reason with every no',          'Rejections say what was missing. It is the part of the process candidates thank us for most.'],
];
?>
<section class="band car-eo" id="equal-opportunity" aria-labelledby="eeo-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Equal opportunity</p>
        <h2 class="h2" id="eeo-t"><span class="g">A fair process</span> is a set of mechanics, not a sentence.</h2></div>
      <div><p class="lead">The statement matters, and so does what sits under it. Both are here, and both are things you can hold us to during your own process.</p></div>
    </div>

    <div class="car-eo__grid">
      <!-- PLACEHOLDER: have counsel confirm the equal-opportunity statement before launch -->
      <div class="car-eo__stmt">
        <p class="car-eo__lead">Xterra Edze is an equal-opportunity employer. We hire on skill, judgement and potential. We do not discriminate on the basis of religion, caste, gender, gender identity or expression, sexual orientation, age, disability, marital or parental status, region, language or any other personal characteristic, and we will not tolerate it from a client either.</p>
        <p class="car-eo__p">If any part of our process is harder for you than it needs to be, that is our problem to fix and not yours to work around. Tell us in your application, or write to us at any point afterwards. Asking never counts against you, and you never have to explain why.</p>
        <p class="car-eo__p">If you believe any of this was not true of your own process, say so directly. A concern about hiring goes to a founder rather than to the people who interviewed you, and you get a written answer whether or not we agree with it.</p>
        <ul class="car-eo__links">
          <li><a class="tl" href="<?= e(xe_url('legal/accessibility.php')) ?>">How this site is built for access <span class="i" aria-hidden="true">›</span></a></li>
          <li><a class="tl" href="<?= e(xe_url('legal/privacy.php')) ?>">What we do with what you send <span class="i" aria-hidden="true">›</span></a></li>
        </ul>
        <a class="btn btn--out car-eo__btn" href="mailto:<?= e($SITE['company']['email']) ?>?subject=<?= e(rawurlencode('Adjustment for an application')) ?>">Ask for an adjustment <span class="i" aria-hidden="true">›</span></a>
        <!-- PLACEHOLDER: confirm the hiring inbox that adjustment requests should reach before launch -->
        <p class="car-eo__note">Requests go to <?= e($SITE['company']['email']) ?> and are handled by the hiring lead, not by the interviewers you will meet.</p>
      </div>

      <div class="car-eo__cols">
        <div class="car-eo__card">
          <p class="car-eo__k"><?= xt_icon('accessibility', ['size' => 18]) ?> Adjustments we make, routinely</p>
          <ul class="car-adj">
            <?php foreach ($eo_adjust as $eo_a): ?>
            <li><span class="car-adj__ico" aria-hidden="true"><?= xt_icon($eo_a[0], ['size' => 17]) ?></span><b><?= e($eo_a[1]) ?></b><span><?= e($eo_a[2]) ?></span></li>
            <?php endforeach; ?>
          </ul>
          <p class="car-eo__sub">Not an exhaustive list. If what you need is not here, ask for it anyway.</p>
        </div>

        <div class="car-eo__card car-eo__card--fair">
          <p class="car-eo__k"><?= xt_icon('clipboard-check', ['size' => 18]) ?> How we take bias out of it</p>
          <ol class="car-fair">
            <?php foreach ($eo_fair as $eo_i => $eo_f): ?>
            <li><span class="car-fair__n"><?= str_pad((string) ($eo_i + 1), 2, '0', STR_PAD_LEFT) ?></span><b><?= e($eo_f[0]) ?></b><span><?= e($eo_f[1]) ?></span></li>
            <?php endforeach; ?>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>
