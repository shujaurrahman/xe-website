<?php /* DRAFT COPY — review before launch */ ?>
<?php /* Hero: breadcrumb, kicker, h1, lead, actions and meta on the left; the capability's signature mock on the right. */ ?>
<section class="band mtd-hero" id="top" aria-labelledby="mtd-h1">
  <div class="wrap mtd-hero__g">
    <div class="mtd-hero__tx">
      <nav class="mtd-crumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="<?= e(xe_url('')) ?>">Home</a></li>
          <li><a href="<?= e(xe_discipline_url($DISC)) ?>"><?= e($DISC['name']) ?></a></li>
          <li aria-current="page"><?= e($CAP['name']) ?></li>
        </ol>
      </nav>
      <p class="lbl lbl--blue"><span class="dot"></span>Capability <?= e($CAP['n']) ?> · <?= e($CAP['kicker']) ?></p>
      <h1 class="d2 mtd-hero__h" id="mtd-h1"><?= $CAP['title'] ?></h1>
      <p class="lead mtd-hero__lead"><?= e($CAP['lead']) ?></p>
      <div class="mtd-hero__act">
        <a class="btn btn--ink btn--lg" href="<?= e(svc_contact_url([], null, $MTD_KEY)) ?>"><?= e($CAP['cta']) ?> <span class="i"></span></a>
        <a class="btn btn--out btn--lg" href="#process">How it runs <span class="i"></span></a>
      </div>
      <!-- PLACEHOLDER: confirm typical timeframes before launch -->
      <dl class="mtd-meta">
        <?php foreach ($CAP['meta'] as $mtd_i => $mtd_m): ?>
        <div><dt><?= e($CAP['meta_k'][$mtd_i] ?? '') ?></dt><dd><?= e($mtd_m) ?></dd></div>
        <?php endforeach; ?>
      </dl>
    </div>
    <div class="mtd-hero__sig" id="signature">
      <?php include __DIR__ . '/sig/' . basename($MTD_KEY) . '.php'; ?>
    </div>
  </div>
</section>
