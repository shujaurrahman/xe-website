<?php /* DRAFT COPY — review before launch */
/* What it is, and what it is not — two ledgers side by side, because most newsletter pages only write
   the first one. Each row is a claim with the thing that makes it true underneath. Below both: the one
   editorial rule the format is built on, set large. Nothing here is a measurement; it is the contract
   the issues will be written to. */
$pro_rule = 'If an issue has nothing in it we got wrong, it is usually an issue not worth sending.';
?>
<section class="band band--alt nlt-pro" id="promise" aria-labelledby="promise-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The format</p>
        <h2 class="h2" id="promise-t"><span class="g">What it is,</span> and what it is not.</h2>
      </div>
      <div>
        <p class="lead">A newsletter is a standing promise about what will arrive. Both halves of that promise are
          written down here, because the second half is the one that decides whether it is worth an address.</p>
      </div>
    </div>

    <div class="nlt-pro__grid">
      <div class="nlt-pro__col nlt-pro__col--is">
        <header class="nlt-pro__ch">
          <span class="nlt-pro__mk nlt-pro__mk--y" aria-hidden="true"><?= xt_icon('check', ['size' => 15]) ?></span>
          <h3 class="nlt-pro__ct" id="promise-is">What it is</h3>
          <span class="nlt-k nlt-pro__cn"><?= count($NLT['promise']['is']) ?> promises</span>
        </header>
        <ul class="nlt-pro__l">
          <?php foreach ($NLT['promise']['is'] as $pro_i => $pro_r): ?>
            <li style="--i:<?= $pro_i ?>">
              <p class="nlt-pro__t"><?= e($pro_r[0]) ?></p>
              <p class="nlt-pro__d"><?= e($pro_r[1]) ?></p>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <span class="nlt-pro__spine" aria-hidden="true"></span>

      <div class="nlt-pro__col nlt-pro__col--not">
        <header class="nlt-pro__ch">
          <span class="nlt-pro__mk nlt-pro__mk--n" aria-hidden="true">
            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" focusable="false"><path d="M6 6 18 18M18 6 6 18"/></svg>
          </span>
          <h3 class="nlt-pro__ct" id="promise-not">What it is not</h3>
          <span class="nlt-k nlt-pro__cn"><?= count($NLT['promise']['not']) ?> refusals</span>
        </header>
        <ul class="nlt-pro__l">
          <?php foreach ($NLT['promise']['not'] as $pro_i => $pro_r): ?>
            <li style="--i:<?= $pro_i ?>">
              <p class="nlt-pro__t"><?= e($pro_r[0]) ?></p>
              <p class="nlt-pro__d"><?= e($pro_r[1]) ?></p>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <figure class="nlt-pro__rule" data-rv>
      <blockquote><p><?= e($pro_rule) ?></p></blockquote>
      <figcaption class="nlt-k">The editorial rule the format is built on</figcaption>
    </figure>
  </div>
</section>
