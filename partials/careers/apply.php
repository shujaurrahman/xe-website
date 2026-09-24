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
    <form class="car-apply car-apply--gen" action="<?= e(xe_url('contact.php')) ?>" method="post" aria-labelledby="apply-t">
      <input type="hidden" name="from" value="careers">
      <input type="hidden" name="t" value="<?= e($car_token) ?>">
      <div class="car-hp" aria-hidden="true"><label for="car-gen-w">Leave this empty</label><input type="text" id="car-gen-w" name="website" tabindex="-1" autocomplete="off"></div>
      <label class="car-f"><span>Full name</span><input type="text" name="name" autocomplete="name" maxlength="120" required></label>
      <label class="car-f"><span>Email</span><input type="email" name="email" autocomplete="email" maxlength="190" required></label>
      <label class="car-f"><span>Phone <i>optional</i></span><input type="tel" name="phone" autocomplete="tel" maxlength="40"></label>
      <label class="car-f"><span>About you <i>your craft, a link to your work, where you want to be based</i></span><textarea name="message" rows="6" maxlength="4000" required>Application: General application (general)&#10;&#10;Portfolio or LinkedIn: &#10;&#10;What I do best: </textarea></label>
      <button class="btn btn--ink car-apply__go" type="submit">Send application <span class="i" aria-hidden="true">›</span></button>
      <p class="car-apply__note">We use your details only to consider you for roles at Xterra Edze.</p>
    </form>
  </div>
</section>
