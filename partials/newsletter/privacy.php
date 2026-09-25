<?php /* DRAFT COPY — review before launch */
/* Your address — the six things we will never do with it, each with the mechanism that keeps the
   promise rather than the promise on its own, and then the full list of what a sign-up would hold once
   the email service is connected. A sticky rail on the left carries the two regulations this is built
   to and the link to the Privacy Notice, which is the document that governs, not this page. */
?>
<section class="band band--alt nlt-priv" id="privacy" aria-labelledby="privacy-t">
  <div class="wrap">
    <div class="nlt-priv__grid">

      <div class="nlt-priv__rail">
        <div class="nlt-priv__stick">
          <p class="lbl lbl--blue"><span class="dot"></span>Your address</p>
          <h2 class="h2 nlt-priv__h" id="privacy-t"><span class="g">Six things we will never do</span> with an email address.</h2>
          <p class="lead nlt-priv__lead">An address is the whole price of this newsletter, so the terms are worth
            printing in full. Each promise below is followed by the thing that makes it true — a setting, a
            contract or a design decision — because a promise with no mechanism behind it is a slogan.</p>

          <ul class="nlt-priv__std" aria-label="Regulations this is built to">
            <?php foreach (['gdpr', 'dpdp'] as $priv_k): ?>
              <?= xt_badge($priv_k, ['tag' => 'li', 'detail' => true]) ?>
            <?php endforeach; ?>
          </ul>
          <p class="nlt-priv__note">Frameworks the handling is built to — not certifications held.
            <a class="nlt-a" href="<?= xe_url('legal/privacy.php') ?>">Read the Privacy Notice</a>, which is the
            document that governs if anything on this page disagrees with it.</p>
        </div>
      </div>

      <div class="nlt-priv__main">
        <ol class="nlt-priv__l" data-rv-s data-rv-step="60">
          <?php foreach ($NLT['privacy'] as $priv_i => $priv_r): ?>
            <li class="nlt-priv__i">
              <p class="nlt-priv__n" aria-hidden="true"><?= str_pad((string) ($priv_i + 1), 2, '0', STR_PAD_LEFT) ?></p>
              <div class="nlt-priv__b">
                <h3 class="nlt-priv__t"><?= e($priv_r[0]) ?></h3>
                <p class="nlt-priv__d"><?= e($priv_r[1]) ?></p>
                <p class="nlt-priv__m"><span class="nlt-priv__mk">How it is kept</span><?= e($priv_r[2]) ?></p>
              </div>
            </li>
          <?php endforeach; ?>
        </ol>

        <div class="nlt-priv__hold">
          <div class="nlt-priv__hh">
            <h3 class="nlt-priv__ht">What a sign-up would hold</h3>
            <!-- PLACEHOLDER: confirm this list against the email service's own data model once it is
                 connected, and confirm the retention periods with counsel before launch. -->
            <p class="nlt-priv__hd">Five fields, once the email service is connected. Nothing is stored today,
              because there is nowhere to store it — the form emails the address to us and stops.</p>
          </div>

          <div class="bdh-scroll-x nlt-priv__scroll" tabindex="0" role="group" aria-label="What a sign-up would hold — scroll sideways to read every column">
            <table class="nlt-priv__tbl">
              <caption class="bdh-sr">Every field a confirmed sign-up would hold, what it is for and how long it is kept.</caption>
              <thead>
                <tr><th scope="col">Field</th><th scope="col">What it is for</th><th scope="col">Kept for</th></tr>
              </thead>
              <tbody>
                <?php foreach ($NLT['stored'] as $priv_s): ?>
                  <tr>
                    <th scope="row"><?= e($priv_s[0]) ?></th>
                    <td><?= e($priv_s[1]) ?></td>
                    <td class="nlt-priv__keep"><?= e($priv_s[2]) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <p class="nlt-hint-x" aria-hidden="true">Scroll sideways for every column</p>

          <p class="nlt-priv__out">Not held: your name, your employer, your job title, your IP address, which links
            you followed, or whether you opened anything. None of it is asked for and none of it is inferred.</p>
        </div>
      </div>
    </div>
  </div>
</section>
