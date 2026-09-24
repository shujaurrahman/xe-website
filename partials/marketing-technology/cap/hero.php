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
        <a class="btn btn--ink btn--lg" href="<?= e(svc_contact_url([], null, 'marketing-technology')) ?>"><?= e($CAP['cta']) ?> <span class="i"></span></a>
        <a class="btn btn--out btn--lg" href="#process">How it runs <span class="i"></span></a>
      </div>
      <!-- PLACEHOLDER: confirm typical timeframes before launch -->
      <dl class="mtd-meta">
        <?php foreach ($CAP['meta'] as $mtd_i => $mtd_m): ?>
        <div><dt><?= e($CAP['meta_k'][$mtd_i] ?? '') ?></dt><dd><?= e($mtd_m) ?></dd></div>
        <?php endforeach; ?>
      </dl>
      <?php if (!empty($MTD_X['parts'])): ?>
      <nav class="mtd-jump" aria-label="The five practices on this page">
        <p class="bdh-ro">One capability · five practices</p>
        <ol>
          <?php foreach ($MTD_X['parts'] as $mtd_i => $mtd_p): ?>
          <li><a href="#<?= e($mtd_p[0]) ?>"><span class="bdh-ro"><?= sprintf('%02d', $mtd_i + 1) ?></span><?= e($CAP['offer'][$mtd_i][0]) ?></a></li>
          <?php endforeach; ?>
        </ol>
      </nav>
      <?php endif; ?>
    </div>
    <div class="mtd-hero__sig" id="signature">
      <?php include __DIR__ . '/sig/' . basename($MTD_KEY) . '.php'; ?>
    </div>
  </div>
</section>
