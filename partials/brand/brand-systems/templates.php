<?php /* DRAFT COPY — review before launch */
/* 06 · Templates for channels — one set of content, four formats. Tabs switch the frame and
   the elements re-lay with a FLIP transition; the headline field is live and checked per format. */
$cbs_tp_formats = [   // [key, tab label, spec, headline limit, rules]
    ['email',  'Email',        '600 px · single column',  60, ['Single column, 600 px wide', 'Image above the headline at 2:1', 'Headline up to two lines', 'Legal line pulled from the market pack']],
    ['social', 'Social',       '1080 × 1080',             40, ['Square, 1080 × 1080', 'Headline sits on the image', 'Logo top left with 1× clearspace', 'No body copy on the tile']],
    ['slide',  'Presentation', '1920 × 1080 · 12 columns', 60, ['16:9 on a 12-column grid', 'Text on six columns, image on six', 'Headline at display size', 'Market code in the footer']],
    ['banner', 'Web banner',   '728 × 90 leaderboard',     30, ['Leaderboard, 728 × 90', 'Logo, headline and button only', 'Headline 30 characters at most', 'Button always visible']],
];
$cbs_tp_head = 'Built for Segment A, ready in Market 03';
?>
<section class="band cbs-tp" id="templates" aria-labelledby="cbs-tp-t">
  <div class="wrap">
    <header class="cbs-head cbs-head--split" data-rv>
      <p class="cbs-head__path"><b>06</b><i>/</i>templates<i>/</i>channels</p>
      <h2 class="cbs-head__h" id="cbs-tp-t"><span class="g">Content in.</span> On brand out.</h2>
      <p class="lead cbs-head__lead">A template holds the rules so the person filling it does not have to. Write the content once; each format lays it out its own way, drops what it cannot carry and warns when a line will not fit. Type a headline and switch formats.</p>
    </header>

    <div class="cbs-tp__box" data-cbs-tp>
      <div class="cbs-tp__content">
        <p class="cbs-tp__lbl">content.json</p>
        <div class="cbs-tp__field">
          <label for="cbs-tp-head"><code>headline</code><span data-cbs-tp-count>0 / 60</span></label>
          <textarea id="cbs-tp-head" rows="2" maxlength="72" autocomplete="off" spellcheck="false" data-cbs-tp-input aria-describedby="cbs-tp-check"><?= e($cbs_tp_head) ?></textarea>
        </div>
        <dl class="cbs-tp__fixed">
          <div><dt>eyebrow</dt><dd>Spring range</dd></div>
          <div><dt>body</dt><dd>Three ways teams use Product C in the first month.</dd></div>
          <div><dt>cta</dt><dd>Book a demo</dd></div>
          <div><dt>image</dt><dd>hero / pattern-04</dd></div>
          <div><dt>market</dt><dd>M03 · en-GB</dd></div>
        </dl>
        <p class="cbs-tp__check" id="cbs-tp-check" role="status" aria-live="polite" data-cbs-tp-check></p>
      </div>

      <div class="cbs-tp__right">
        <div class="cbs-tp__tabs" role="tablist" aria-label="Channel format">
          <?php foreach ($cbs_tp_formats as $cbs_fi => $cbs_f): ?>
            <button type="button" role="tab" id="cbs-tp-tab-<?= e($cbs_f[0]) ?>" aria-controls="cbs-tp-pane-<?= e($cbs_f[0]) ?>" aria-selected="<?= $cbs_fi === 0 ? 'true' : 'false' ?>"<?= $cbs_fi ? ' tabindex="-1"' : '' ?> data-format="<?= e($cbs_f[0]) ?>" data-limit="<?= $cbs_f[3] ?>"><?= e($cbs_f[1]) ?><small><?= e($cbs_f[2]) ?></small></button>
          <?php endforeach; ?>
        </div>

        <div class="cbs-tp__stage" aria-hidden="true">
          <div class="cbs-tp__frame is-email" data-cbs-tp-frame>
            <span class="cbs-tp__el cbs-tp__logo" data-cbs-tp-el>Your brand</span>
            <span class="cbs-tp__el cbs-tp__img" data-cbs-tp-el><i></i></span>
            <span class="cbs-tp__el cbs-tp__eye" data-cbs-tp-el>Spring range</span>
            <b class="cbs-tp__el cbs-tp__head" data-cbs-tp-el data-cbs-tp-headline><?= e($cbs_tp_head) ?></b>
            <span class="cbs-tp__el cbs-tp__body" data-cbs-tp-el>Three ways teams use Product C in the first month.</span>
            <span class="cbs-tp__el cbs-tp__cta" data-cbs-tp-el>Book a demo</span>
            <span class="cbs-tp__el cbs-tp__legal" data-cbs-tp-el>M03 · Your brand Ltd · Unsubscribe</span>
          </div>
        </div>

        <?php foreach ($cbs_tp_formats as $cbs_fi => $cbs_f): ?>
          <div class="cbs-tp__pane" role="tabpanel" id="cbs-tp-pane-<?= e($cbs_f[0]) ?>" aria-labelledby="cbs-tp-tab-<?= e($cbs_f[0]) ?>"<?= $cbs_fi ? ' hidden' : '' ?>>
            <p class="cbs-tp__pl">Rules this template enforces</p>
            <ul class="cbs-tp__rules">
              <?php foreach ($cbs_f[4] as $cbs_rule): ?><li><?= e($cbs_rule) ?></li><?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
