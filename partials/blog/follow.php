<?php /* DRAFT COPY — review before launch */
/* Follow the journal. The newsletter is a separate page owned elsewhere in the build, so this section
   looks for it at run time: if newsletter.php (or newsletter/index.php) exists, the first card links
   to it; until then the card says so honestly and offers the written route instead. Nothing here
   points at a page that is not there. */
$fol_root = dirname(__DIR__, 2) . '/';
$fol_news = is_file($fol_root . 'newsletter.php') ? 'newsletter.php'
          : (is_file($fol_root . 'newsletter/index.php') ? 'newsletter/index.php' : null);
$fol_li = null;
foreach ($SITE['social'] as $fol_s) { if ($fol_s[0] === 'LinkedIn') $fol_li = $fol_s[1]; }
?>
<section class="band blg-follow" id="follow" aria-labelledby="follow-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--c" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>Stay with it</p>
      <h2 class="h2" id="follow-t"><span class="g">Three ways to keep reading.</span> None of them tracks you across the web.</h2>
      <p class="lead">The journal carries no advertising, no third-party share widgets and no cross-site pixels. What we know about a visit is what the server log holds.</p>
    </div>

    <ul class="blg-follow__l" data-rv-s data-rv-step="70">
      <li class="blg-follow__i">
        <article class="bdh-card blg-follow__c">
          <span class="blg-follow__ico" aria-hidden="true"><?= xt_icon('doc', ['size' => 22]) ?></span>
          <h3 class="bdh-t">The newsletter</h3>
          <?php if ($fol_news): ?>
            <p class="bdh-d">New posts, a short note on what changed in the work, and nothing else. Unsubscribe in one click.</p>
            <a class="tl" href="<?= xe_url($fol_news) ?>">Subscribe <span class="i" aria-hidden="true">›</span></a>
          <?php else: ?>
            <!-- PLACEHOLDER: the newsletter page is being built separately. This card links to it automatically the moment newsletter.php exists. -->
            <p class="bdh-d">A short note when something is published. The sign-up page is being built — until it is live, ask for it in a line and we will add you when it opens.</p>
            <a class="tl" href="<?= xe_url('contact.php') ?>">Ask to be added <span class="i" aria-hidden="true">›</span></a>
          <?php endif; ?>
        </article>
      </li>

      <li class="blg-follow__i">
        <article class="bdh-card blg-follow__c">
          <span class="blg-follow__ico" aria-hidden="true"><?= xt_icon('users', ['size' => 22]) ?></span>
          <h3 class="bdh-t">On LinkedIn</h3>
          <p class="bdh-d">Posts go out there too, with the argument in the post rather than a link and a teaser.</p>
          <?php if ($fol_li): ?>
            <a class="tl" href="<?= e($fol_li) ?>" target="_blank" rel="noopener">Follow the company page <span class="i" aria-hidden="true">›</span><span class="bdh-sr"> — opens in a new tab</span></a>
          <?php endif; ?>
        </article>
      </li>

      <li class="blg-follow__i">
        <article class="bdh-card blg-follow__c">
          <span class="blg-follow__ico" aria-hidden="true"><?= xt_icon('lightbulb', ['size' => 22]) ?></span>
          <h3 class="bdh-t">Ask for a subject</h3>
          <p class="bdh-d">If there is a decision you are stuck on and we have an opinion worth writing down, say so. A question with a real constraint behind it makes a better post than a content calendar does.</p>
          <a class="tl" href="<?= xe_url('contact.php') ?>">Send us the question <span class="i" aria-hidden="true">›</span></a>
        </article>
      </li>
    </ul>
  </div>
</section>
