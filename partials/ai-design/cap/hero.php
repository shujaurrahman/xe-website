<?php /* DRAFT COPY — review before launch */
/* Hero — breadcrumb, the capability's promise and meta, and beside it the topic's signature mock
   (sig/<slug>.php sets $aid_sig: head, sr, steps, body). The mock is aria-hidden with a .bdh-sr sentence; its step
   controls are real buttons, rendered hidden and revealed by sig.js, so without JS the finished state simply shows. */
include __DIR__ . '/sig/' . basename($AID_KEY) . '.php';
?>
<section class="band aid-hero" id="hero" aria-labelledby="hero-t">
  <div class="wrap aid-hero__grid">
    <div class="aid-hero__copy">
      <nav class="aid-crumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="<?= e(xe_url('services.php')) ?>">Services</a></li>
          <li><a href="<?= e($AIH_URL) ?>">AI Design</a></li>
          <li aria-current="page"><?= e($CAP['name']) ?></li>
        </ol>
      </nav>
      <p class="lbl lbl--blue"><span class="dot"></span>Capability <?= e($CAP['n']) ?> / 04 · <?= e($CAP['kicker']) ?></p>
      <h1 class="d2" id="hero-t"><?= $CAP['title'] ?></h1>
      <p class="lead"><?= e($CAP['lead']) ?></p>
      <div class="aid-hero__cta">
        <a class="btn btn--ink btn--lg" href="<?= e(svc_contact_url([], null, $AID_SVC)) ?>"><?= e($CAP['cta']) ?> <span class="i" aria-hidden="true"></span></a>
        <a class="btn btn--out btn--lg" href="#offer">What it covers <span class="i" aria-hidden="true"></span></a>
      </div>
      <!-- PLACEHOLDER: confirm typical timeframe before launch -->
      <dl class="aid-hero__meta">
        <?php foreach ($CAP['meta'] as $aid_i => $aid_m): ?>
          <div><dt><?= e($CAP['meta_k'][$aid_i] ?? '') ?></dt><dd><?= e($aid_m) ?></dd></div>
        <?php endforeach; ?>
      </dl>
    </div>

    <div class="aid-sig" id="signature" data-aid-sig data-bdh-live>
      <div class="aid-sig__bar" aria-hidden="true">
        <span class="aid-sig__dot"></span><span class="aid-sig__path"><?= $aid_sig['head'] ?></span><span class="aid-sig__tag">Illustrative</span>
      </div>
      <p class="bdh-sr"><?= e($aid_sig['sr']) ?></p>
      <div class="aid-sig__body" aria-hidden="true"><?= $aid_sig['body'] ?></div>
      <div class="aid-sig__ctl" role="group" aria-label="Step through the example" hidden>
        <?php foreach ($aid_sig['steps'] as $aid_i => $aid_st): ?>
          <button type="button" class="aid-sig__b" data-aid-go="<?= $aid_i + 1 ?>" data-say="<?= e($aid_st[1]) ?>" aria-pressed="false"><span aria-hidden="true"><?= str_pad((string) ($aid_i + 1), 2, '0', STR_PAD_LEFT) ?></span><?= e($aid_st[0]) ?></button>
        <?php endforeach; ?>
        <button type="button" class="aid-sig__play" data-aid-play aria-pressed="true" aria-label="Pause the example"><span aria-hidden="true"></span></button>
      </div>
      <p class="bdh-sr" aria-live="polite" data-aid-say></p>
    </div>
  </div>
</section>
