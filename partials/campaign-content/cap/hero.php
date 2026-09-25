<?php /* DRAFT COPY — review before launch */ ?>
<?php /* Hero: breadcrumb, kicker, h1, lead, actions and meta on the left; the capability's signature mock on the right. */ ?>
<section class="band ccd-hero" id="top" aria-labelledby="ccd-h1">
  <div class="wrap ccd-hero__g">
    <div class="ccd-hero__tx">
      <nav class="ccd-crumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="<?= e(xe_url('')) ?>">Home</a></li>
          <li><a href="<?= e(xe_discipline_url($DISC)) ?>"><?= e($DISC['name']) ?></a></li>
          <li aria-current="page"><?= e($CAP['name']) ?></li>
        </ol>
      </nav>
      <p class="lbl lbl--blue"><span class="dot"></span>Capability <?= e($CAP['n']) ?> · <?= e($CAP['kicker']) ?></p>
      <h1 class="d2 ccd-hero__h" id="ccd-h1"><?= $CAP['title'] ?></h1>
      <p class="lead ccd-hero__lead"><?= e($CAP['lead']) ?></p>
      <div class="ccd-hero__act">
        <a class="btn btn--ink btn--lg" href="<?= e(svc_contact_url([], null, $CCD_KEY)) ?>"><?= e($CAP['cta']) ?> <span class="i"></span></a>
        <a class="btn btn--out btn--lg" href="#process">How it runs <span class="i"></span></a>
      </div>
      <!-- PLACEHOLDER: confirm typical timeframes before launch -->
      <dl class="ccd-meta">
        <?php foreach ($CAP['meta'] as $ccd_i => $ccd_m): ?>
        <div><dt><?= e($CAP['meta_k'][$ccd_i] ?? '') ?></dt><dd><?= e($ccd_m) ?></dd></div>
        <?php endforeach; ?>
      </dl>
    </div>
    <div class="ccd-hero__sig" id="signature">
      <?php include __DIR__ . '/sig/' . basename($CCD_KEY) . '.php'; ?>
    </div>
  </div>
</section>
