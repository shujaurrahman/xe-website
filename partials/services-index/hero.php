<?php /* DRAFT COPY — review before launch */ ?>
<section class="band svx-hero" id="top" aria-labelledby="svx-hero-t">
  <span class="svx-hero__dots dots" aria-hidden="true"></span>
  <div class="wrap svx-hero__in">
    <div class="svx-hero__say">
      <p class="lbl lbl--blue"><span class="dot"></span>What we do</p>
      <h1 class="d1 svx-hero__h" id="svx-hero-t"><span class="g">Six disciplines.</span> One system behind your brand.</h1>
      <p class="lead svx-hero__lead">Strategy, design, engineering, AI, campaigns and marketing technology — run by one team on one shared foundation, so nothing is lost between the people who plan it and the people who ship it.</p>
      <div class="svx-hero__go">
        <a class="btn btn--ink btn--lg" href="#finder">Find a capability <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out btn--lg" href="#system">How it connects <span class="i" aria-hidden="true">›</span></a>
      </div>
      <dl class="svx-hero__stats">
        <div><dt>Disciplines</dt><dd><?= count($SITE['disciplines']) ?></dd></div>
        <div><dt>Capabilities</dt><dd><?= $svx_total ?></dd></div>
        <div><dt>Foundation</dt><dd>Shared</dd></div>
      </dl>
    </div>

    <nav class="svx-ledger" aria-label="The six disciplines">
      <p class="svx-ledger__k"><span>Index</span><span>Capabilities</span></p>
      <ol class="svx-ledger__list">
        <?php foreach ($SITE['disciplines'] as $svx_d): ?>
          <li>
            <a class="svx-ledger__row" href="<?= e(xe_discipline_url($svx_d)) ?>">
              <span class="svx-ledger__n"><?= e($svx_d['n']) ?></span>
              <span class="svx-ledger__b">
                <span class="svx-ledger__t"><?= e($svx_d['name']) ?></span>
                <span class="svx-ledger__d"><?= e($svx_d['intro']) ?></span>
              </span>
              <span class="svx-ledger__c"><?= count($svx_d['caps']) ?></span>
              <span class="svx-ledger__go" aria-hidden="true">›</span>
            </a>
          </li>
        <?php endforeach; ?>
      </ol>
    </nav>
  </div>
</section>
