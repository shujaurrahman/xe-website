<?php /* DRAFT COPY — review before launch */
/* Hero — the pipeline. A token changes in column one and the change re-renders every
   component, template and channel to its right. HTML is the resting state; hero.js animates. */
$cbs_h_tokens = [
    ['color.primary', '#0082FB', 'p'],
    ['radius.md',     '10px',    'r'],
    ['type.ratio',    '1.250',   't'],
    ['space.unit',    '8px',     's'],
];
$cbs_h_cols = [
    ['01', 'Token',     'tokens.json'],
    ['02', 'Component', 'button · input · chip'],
    ['03', 'Template',  'email / campaign'],
    ['04', 'Channel',   'app · social · web'],
];
?>
<section class="cbs-hero" id="top" aria-labelledby="cbs-hero-t" data-bdh-live>
  <span class="cbs-gridbg cbs-hero__grid" aria-hidden="true"></span>

  <div class="wrap cbs-hero__in">
    <nav class="cbs-hero__crumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="<?= xe_url('services/') ?>">Services</a></li>
        <li><a href="<?= xe_discipline_url($BRAND) ?>"><?= e($BRAND['name']) ?></a></li>
        <li><span aria-current="page"><?= e($CAP['n']) ?> · <?= e($CAP['name']) ?></span></li>
      </ol>
    </nav>

    <div class="cbs-hero__top">
      <div class="cbs-hero__say">
        <p class="cbs-hero__kick"><span class="cbs-hero__pkg">@yourbrand/system</span><span class="cbs-hero__ver" data-cbs-hero-ver>v2.4.0</span><span><?= e($CAP['kicker']) ?></span></p>
        <h1 class="cbs-hero__h" id="cbs-hero-t"><?= $CAP['title'] ?></h1>
      </div>
      <div class="cbs-hero__side">
        <p class="lead cbs-hero__lead"><?= e($CAP['lead']) ?></p>
        <div class="cbs-hero__act">
          <a class="btn btn--ink btn--lg" href="<?= xe_url('contact.php') ?>"><?= e($CAP['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
          <a class="btn btn--out btn--lg" href="#editor">Try the token editor <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>
    </div>

    <dl class="cbs-hero__meta">
      <?php foreach ($CAP['meta'] as $cbs_mi => $cbs_mv): ?>
        <div><dt><?= e($CAP['meta_k'][$cbs_mi] ?? '') ?></dt><dd><?= e($cbs_mv) ?></dd></div>
      <?php endforeach; ?>
      <div><dt>Built on</dt><dd>Tokens → components → templates → channels</dd></div>
    </dl>

    <p class="bdh-sr" id="cbs-hero-sum">Illustration: a design token such as the primary colour or corner radius changes, and the change flows through the components, templates and channels built on it, each re-rendering in turn.</p>

    <div class="cbs-pipe" data-cbs-pipe aria-hidden="true">
      <div class="cbs-pipe__bar">
        <span class="cbs-pipe__run"><i class="cbs-live"></i><span data-cbs-pipe-status>release v2.4.0 · all channels in sync</span></span>
        <span class="cbs-pipe__ill">Illustrative</span>
      </div>

      <div class="cbs-pipe__cols">
        <?php foreach ($cbs_h_cols as $cbs_ci => $cbs_col): ?>
          <div class="cbs-pipe__col cbs-pipe__col--<?= $cbs_ci + 1 ?>" data-cbs-pipe-col>
            <p class="cbs-pipe__hd"><b><?= e($cbs_col[0]) ?></b><?= e($cbs_col[1]) ?><span><?= e($cbs_col[2]) ?></span></p>
            <div class="cbs-pipe__body">
              <?php if ($cbs_ci === 0): ?>
                <ul class="cbs-pipe__tok">
                  <?php foreach ($cbs_h_tokens as $cbs_t): ?>
                    <li data-cbs-tok="<?= e($cbs_t[2]) ?>"><code><?= e($cbs_t[0]) ?></code><span><i class="cbs-pipe__sw cbs-pipe__sw--<?= e($cbs_t[2]) ?>"></i><em data-cbs-tok-v><?= e($cbs_t[1]) ?></em></span></li>
                  <?php endforeach; ?>
                </ul>
              <?php elseif ($cbs_ci === 1): ?>
                <div class="cbs-pipe__cmp">
                  <span class="cbs-k-btn">Get started</span>
                  <span class="cbs-k-btn cbs-k-btn--out">Learn more</span>
                  <span class="cbs-k-input"><i></i>you@company.com</span>
                  <span class="cbs-k-chips"><i class="is-on">Segment A</i><i>Segment B</i></span>
                </div>
              <?php elseif ($cbs_ci === 2): ?>
                <div class="cbs-pipe__tpl">
                  <span class="cbs-pipe__tpl-hd"><b>Your brand</b><i></i></span>
                  <span class="cbs-pipe__tpl-hero"><b>Spring range, now in Market 03</b><i></i><i class="is-s"></i><span class="cbs-k-btn">Shop now</span></span>
                  <span class="cbs-pipe__tpl-row"><i></i><i></i><i></i></span>
                </div>
              <?php else: ?>
                <div class="cbs-pipe__ch">
                  <span class="cbs-pipe__phone"><i class="cbs-pipe__phone-n"></i><b>Product C</b><i class="cbs-pipe__phone-l"></i><i class="cbs-pipe__phone-l is-s"></i><span class="cbs-k-btn">Continue</span></span>
                  <span class="cbs-pipe__social"><b>New in Market 03</b><span class="cbs-k-btn">See more</span></span>
                  <span class="cbs-pipe__banner"><b>Your brand</b><span class="cbs-k-btn">Book</span></span>
                </div>
              <?php endif; ?>
            </div>
            <p class="cbs-pipe__ft"><span class="cbs-pipe__chk">in sync</span><span data-cbs-pipe-hash>#a41f2c</span></p>
          </div>
          <?php if ($cbs_ci < 3): ?><span class="cbs-pipe__link" data-cbs-pipe-link><i></i></span><?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
