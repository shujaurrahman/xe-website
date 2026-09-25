<?php /* DRAFT COPY — review before launch */ ?>
<section class="band car-gen" id="apply" aria-labelledby="apply-t">
  <div class="wrap car-gen__grid">
    <div class="car-gen__copy">
      <p class="lbl lbl--blue"><span class="dot"></span>General application</p>
      <h2 class="h2" id="apply-t"><span class="g">Not seeing your role?</span> Tell us what you do best.</h2>
      <p class="lead">Strong people shape roles here. Send your work and what you want to do next, and we will come back to you when there is a fit.</p>
      <div class="car-eeo">
        <h3 class="car-eeo__t">Equal opportunity</h3>
        <p>Xterra Edze is an equal-opportunity employer. We hire on skill and potential, and we do not discriminate on the basis of religion, caste, gender, gender identity, sexual orientation, age, disability, marital status, region or any other personal characteristic. If you need an adjustment at any step of our process, tell us in your application and we will make it.</p>
      </div>
    </div>
    <?php /* The application itself is on its own page, /careers/apply (no role pre-selected here, so it
             opens as a general application). */ ?>
    <div class="car-apply car-apply--gen">
      <p class="car-apply__h">General application</p>
      <p class="car-apply__note">Your details, a link to your work, and what you want to do next. It takes a few minutes, and we use your details only to consider you for roles at Xterra Edze.</p>
      <a class="btn btn--ink car-apply__go" href="<?= e(xe_url('careers/apply.php')) ?>">Start an application <span class="i" aria-hidden="true">›</span></a>
    </div>
  </div>
</section>
