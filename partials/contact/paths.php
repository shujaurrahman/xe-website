<?php /* DRAFT COPY — review before launch */
/* Paths — the depth chooser, and the first band of the form (contact.php opens the <form> above it).
   Three radios decide how much of the brief starts open. They are real form controls: with
   JavaScript off they still post, and every field below stays reachable because the blocks they
   control are <details> a reader can open. contact.js only toggles those blocks as the choice
   changes. The matrix on each card is the honest picture of what that depth asks for. */
$ct_p_blocks = ['Who you are', 'What you need', 'The problem', 'Goals, audience, what exists today', 'Budget, timing, decision', 'Source, NDA, access needs'];
$ct_p_map = [
    'hello' => [1, 1, 1, 0, 0, 0],
    'brief' => [1, 1, 1, 0, 1, 0],
    'rfq'   => [1, 1, 1, 1, 1, 1],
];
$ct_p_icon = ['hello' => 'chat', 'brief' => 'doc', 'rfq' => 'clipboard-check'];
?>
<section class="band ct-paths" id="paths" aria-labelledby="paths-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row ct-paths__head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Start here</p>
        <h2 class="h2" id="paths-t"><span class="g">One form,</span> three depths.</h2>
      </div>
      <div>
        <p class="lead">A sentence is enough to get a reply. A full request for quotation is enough to get a scope, a shape of team and a price range. Choose the depth and the form follows — nothing is hidden from you, and you can open any block yourself.</p>
      </div>
    </div>

    <?php if ($ct_app): ?>
      <p class="ct-paths__note">You are applying for a role, so the brief questions are put away. This short form reaches the hiring lead. <a class="tl" href="<?= xe_url('careers/apply.php') ?>">The full application form, with a CV upload, is here <span class="i" aria-hidden="true">›</span></a></p>
    <?php else: ?>

    <fieldset class="ct-depths" aria-describedby="ct-depths-d">
      <legend class="bdh-sr">How much detail do you want to send?</legend>
      <p class="ct-depths__d" id="ct-depths-d">Pick one. It changes which blocks of the form start open, and nothing else.</p>
      <div class="ct-depths__row" data-rv-s data-rv-step="60">
        <?php foreach ($CT['depths'] as $ct_dk => $ct_dp): $ct_dn = $ct_p_map[$ct_dk]; ?>
          <label class="ct-depth<?= $ct_v['depth'] === $ct_dk ? ' is-on' : '' ?>">
            <input type="radio" name="depth" value="<?= e($ct_dk) ?>"<?= $ct_v['depth'] === $ct_dk ? ' checked' : '' ?> data-ct-depth="<?= e($ct_dk) ?>">
            <span class="ct-depth__top">
              <span class="ct-depth__ico" aria-hidden="true"><?= xt_icon($ct_p_icon[$ct_dk], ['size' => 20]) ?></span>
              <span class="ct-depth__dot" aria-hidden="true"></span>
            </span>
            <span class="ct-depth__n"><?= e($ct_dp[0]) ?></span>
            <span class="ct-depth__d"><?= e($ct_dp[1]) ?></span>
            <span class="ct-depth__bars" aria-hidden="true">
              <?php foreach ($ct_p_blocks as $ct_bi => $ct_bn): ?>
                <span class="ct-depth__bar<?= $ct_dn[$ct_bi] ? ' is-on' : '' ?>" style="--i:<?= $ct_bi ?>"></span>
              <?php endforeach; ?>
            </span>
            <span class="ct-depth__asks">
              <span class="bdh-sr">This depth opens: </span>
              <?= e(implode(', ', array_values(array_filter($ct_p_blocks, fn ($ct_x, $ct_i) => (bool) $ct_dn[$ct_i], ARRAY_FILTER_USE_BOTH)))) ?>.
            </span>
            <span class="ct-depth__foot">
              <span class="ct-depth__t"><?= e($ct_dp[2]) ?></span>
              <span class="ct-depth__add"><?= e($ct_dp[3]) ?></span>
            </span>
          </label>
        <?php endforeach; ?>
      </div>
    </fieldset>

    <ul class="ct-always">
      <li><span class="ct-always__k">Always required</span><b>A name and an address we can reply to</b><span>Two fields. Everything else on this page is optional.</span></li>
      <li><span class="ct-always__k">Always required</span><b>One service, or a paragraph</b><span>Tick what you think you need, or describe the problem and we will map it.</span></li>
      <li><span class="ct-always__k">Never required</span><b>A budget number</b><span>A range helps us scope once instead of twice. “Prefer not to say” is a real answer.</span></li>
    </ul>

    <p class="ct-paths__alt">Would rather talk first? <a class="tl" href="<?= xe_url('index.php#book') ?>">Book a thirty-minute call <span class="i" aria-hidden="true">›</span></a> <span class="ct-paths__sep" aria-hidden="true">·</span> Or write to <a class="ct-paths__mail" href="mailto:<?= e($SITE['company']['email']) ?>"><?= e($SITE['company']['email']) ?></a></p>
    <?php endif; ?>
  </div>
</section>
