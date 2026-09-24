<?php /* DRAFT COPY — review before launch */
/* Hero — breadcrumb, capability position, h1/lead/meta from data, and the capability's signature mock on the right.
   The sig file sets $pxd_opts ([[state, button label, caption]], first = shipped state) and $pxd_sr, then prints the
   stage. Without JS the stage shows state "a" and its caption; the controls stay hidden until sig.js wires them. */
ob_start();
include __DIR__ . '/sig/' . $PXD_KEY . '.php';
$pxd_stage = ob_get_clean();
$pxd_def   = $pxd_def ?? 0;   // the sig may ship a state other than its first option
$pxd_total = str_pad((string) count($CAPS), 2, '0', STR_PAD_LEFT);
?>
<section class="band pxd-hero" id="top" aria-labelledby="top-t">
  <span class="dots" aria-hidden="true"></span>
  <div class="wrap">
    <div class="pxd-hero__bar">
      <nav class="pxd-crumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="<?= e(xe_url('services/')) ?>">Services</a></li>
          <li><a href="<?= e($PXD_HUB) ?>"><?= e($DISC['name']) ?></a></li>
          <li><span aria-current="page"><?= e($CAP['name']) ?></span></li>
        </ol>
      </nav>
      <p class="pxd-hero__pos"><span class="pxd-hero__ico"><?= xt_icon($CAP['icon']) ?></span>Capability <?= e($CAP['n']) ?> of <?= e($pxd_total) ?> · <?= e($CAP['kicker']) ?></p>
    </div>
    <div class="pxd-hero__g">
      <div class="pxd-hero__txt">
        <p class="lbl lbl--blue"><span class="dot"></span><?= e($CAP['name']) ?></p>
        <h1 class="d2" id="top-t"><?= $CAP['title'] ?></h1>
        <p class="lead"><?= e($CAP['lead']) ?></p>
        <div class="pxd-hero__cta">
          <a class="btn btn--ink" href="<?= e(xe_url('contact.php')) ?>"><?= e($CAP['cta']) ?> <span class="i" aria-hidden="true"></span></a>
          <a class="btn btn--out" href="#offer">What it covers <span class="i" aria-hidden="true"></span></a>
        </div>
        <!-- PLACEHOLDER: confirm typical length before launch -->
        <dl class="pxh-hero__meta">
          <?php foreach ($CAP['meta'] as $pxd_i => $pxd_m): ?>
          <div><dt><?= e($CAP['meta_k'][$pxd_i] ?? '') ?></dt><dd><?= e($pxd_m) ?></dd></div>
          <?php endforeach; ?>
        </dl>
      </div>
      <figure class="pxd-sig pxd-sig--<?= e($PXD_KEY) ?>" id="sig" data-pxd-sig data-state="<?= e($pxd_opts[$pxd_def][0]) ?>">
        <div class="pxh-win">
          <div class="pxh-win__bar"><span class="dots3" aria-hidden="true"><i></i><i></i><i></i></span><span class="pxd-sig__title"><?= e($PXD_X['sig'][1]) ?></span><span class="sp">Illustrative</span></div>
          <div class="pxd-sig__stage" aria-hidden="true"><?= $pxd_stage ?></div>
        </div>
        <p class="bdh-sr"><?= e($pxd_sr) ?></p>
        <div class="pxd-sig__ctl" role="group" aria-label="<?= e($PXD_X['sig'][0]) ?>" hidden>
          <?php foreach ($pxd_opts as $pxd_i => $pxd_o): ?>
          <button type="button" class="pxd-sig__opt" data-v="<?= e($pxd_o[0]) ?>" data-k="<?= e($pxd_o[1]) ?>" data-say="<?= e($pxd_o[2]) ?>" aria-pressed="<?= $pxd_i === $pxd_def ? 'true' : 'false' ?>"><?= e($pxd_o[1]) ?></button>
          <?php endforeach; ?>
        </div>
        <figcaption class="pxd-sig__cap"><span class="pxd-sig__k"><?= e($pxd_opts[$pxd_def][1]) ?></span><span class="pxd-sig__live" aria-live="polite"><?= e($pxd_opts[$pxd_def][2]) ?></span></figcaption>
      </figure>
    </div>
  </div>
</section>
