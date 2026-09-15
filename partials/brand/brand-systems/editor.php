<?php /* DRAFT COPY — review before launch */
/* Signature — the live token editor. Four controls rewrite the tokens; six real components
   re-render; the export regenerates in three formats; an agent reports impact and contrast.
   editor.js autoplays edits until the visitor touches a control, then hands over. */
$cbs_ed_hues = [
    ['blue',  'Blue',       '#0082FB', 'var(--blue)'],
    ['deep',  'Blue deep',  '#006CD0', 'var(--blue-d)'],
    ['ink',   'Ink',        '#19191D', 'var(--ink)'],
    ['slate', 'Slate',      '#75757E', 'var(--muted)'],
];
$cbs_ed_ratios = [['1.125', 'Minor second'], ['1.2', 'Minor third'], ['1.25', 'Major third'], ['1.333', 'Perfect fourth']];
$cbs_ed_dens = [['6', 'Compact'], ['8', 'Default'], ['10', 'Comfortable']];
?>
<section class="band cbs-ed" id="editor" aria-labelledby="cbs-ed-t">
  <div class="wrap">
    <header class="cbs-head cbs-head--split" data-rv>
      <p class="cbs-head__path"><b>02</b><i>/</i>signature<i>/</i>token-editor</p>
      <h2 class="cbs-head__h" id="cbs-ed-t"><span class="g">Change one value.</span> Watch every touchpoint follow.</h2>
      <p class="lead cbs-head__lead">This is the system working the way yours will. Pick a primary colour, a corner radius, a type scale and a density. Six real components re-render, the tokens export in three formats, and an agent reports what changed and what now fails contrast. A person still approves the release.</p>
    </header>

    <div class="cbs-ed__app" data-cbs-ed data-rv>
      <div class="cbs-ed__bar">
        <span class="cbs-ed__file"><i class="cbs-live"></i>tokens / your-brand.json</span>
        <span class="cbs-ed__branch">branch <b>proposal/primary</b></span>
        <span class="cbs-ed__auto" data-cbs-ed-auto>Autoplaying · touch any control to take over</span>
      </div>

      <div class="cbs-ed__top">
        <form class="cbs-ed__ctl" aria-label="Token controls" onsubmit="return false">
          <fieldset class="cbs-ed__f">
            <legend>color.primary</legend>
            <div class="cbs-ed__hues">
              <?php foreach ($cbs_ed_hues as $cbs_hi => $cbs_h): ?>
                <label class="cbs-ed__hue" style="--sw:<?= $cbs_h[3] ?>">
                  <input type="radio" name="cbs-ed-hue" value="<?= e($cbs_h[0]) ?>" data-hex="<?= e($cbs_h[2]) ?>" data-css="<?= e($cbs_h[3]) ?>"<?= $cbs_hi === 1 ? ' checked' : '' ?>>
                  <span class="cbs-ed__chip" aria-hidden="true"></span>
                  <span class="cbs-ed__hn"><?= e($cbs_h[1]) ?><code><?= e($cbs_h[2]) ?></code></span>
                </label>
              <?php endforeach; ?>
            </div>
          </fieldset>

          <div class="cbs-ed__f">
            <label class="cbs-ed__lg" for="cbs-ed-radius">radius.md <output data-cbs-ed-out="radius">10px</output></label>
            <input class="cbs-ed__range" type="range" id="cbs-ed-radius" min="0" max="24" step="2" value="10" data-cbs-ed-radius>
            <span class="cbs-ed__scale" aria-hidden="true"><i>0</i><i>12</i><i>24</i></span>
          </div>

          <fieldset class="cbs-ed__f">
            <legend>type.ratio</legend>
            <div class="cbs-ed__seg">
              <?php foreach ($cbs_ed_ratios as $cbs_ri => $cbs_r): ?>
                <label><input type="radio" name="cbs-ed-ratio" value="<?= e($cbs_r[0]) ?>"<?= $cbs_ri === 2 ? ' checked' : '' ?>><span><?= e($cbs_r[0]) ?><small><?= e($cbs_r[1]) ?></small></span></label>
              <?php endforeach; ?>
            </div>
          </fieldset>

          <fieldset class="cbs-ed__f">
            <legend>space.unit</legend>
            <div class="cbs-ed__seg cbs-ed__seg--3">
              <?php foreach ($cbs_ed_dens as $cbs_di => $cbs_dn): ?>
                <label><input type="radio" name="cbs-ed-dens" value="<?= e($cbs_dn[0]) ?>"<?= $cbs_di === 1 ? ' checked' : '' ?>><span><?= e($cbs_dn[1]) ?><small><?= e($cbs_dn[0]) ?>px</small></span></label>
              <?php endforeach; ?>
            </div>
          </fieldset>
          <button type="button" class="cbs-btn cbs-ed__reset" data-cbs-ed-reset>Reset to v2.4.0</button>
        </form>

        <div class="cbs-ed__stage" aria-hidden="true" data-cbs-ed-stage>
          <div class="cbs-ed__cell cbs-ed__cell--btn">
            <p class="cbs-ed__cap">Button</p>
            <div class="cbs-x-row"><span class="cbs-x-btn">Get started</span><span class="cbs-x-btn cbs-x-btn--2">Compare plans</span></div>
          </div>
          <div class="cbs-ed__cell cbs-ed__cell--in">
            <p class="cbs-ed__cap">Input</p>
            <span class="cbs-x-lab">Work email</span>
            <span class="cbs-x-in"><i></i>name@company.com</span>
          </div>
          <div class="cbs-ed__cell cbs-ed__cell--card">
            <p class="cbs-ed__cap">Card</p>
            <div class="cbs-x-card"><span class="cbs-x-card__img"></span><span class="cbs-x-card__b"><b class="cbs-x-h3">Product C, explained</b><span class="cbs-x-p">Three ways teams use it in the first month.</span><span class="cbs-x-link">Read the guide ›</span></span></div>
          </div>
          <div class="cbs-ed__cell cbs-ed__cell--mail">
            <p class="cbs-ed__cap">Email header</p>
            <div class="cbs-x-mail"><span class="cbs-x-mail__top"><b>Your brand</b><i>View online</i></span><b class="cbs-x-h2">Your March update</b><span class="cbs-x-p">What shipped in Market 03, and what is next.</span><span class="cbs-x-btn">Open the update</span></div>
          </div>
          <div class="cbs-ed__cell cbs-ed__cell--social">
            <p class="cbs-ed__cap">Social tile · 1:1</p>
            <div class="cbs-x-social"><i>Your brand</i><b class="cbs-x-h2">Built for Segment A</b><span class="cbs-x-btn cbs-x-btn--w">Learn more</span></div>
          </div>
          <div class="cbs-ed__cell cbs-ed__cell--slide">
            <p class="cbs-ed__cap">Slide title · 16:9</p>
            <div class="cbs-x-slide"><i>Q3 review · 01</i><b class="cbs-x-h1">One system, every market</b><span class="cbs-x-p">Sub-brand B roll-out plan</span><span class="cbs-x-bar"></span></div>
          </div>
        </div>
      </div>

      <div class="cbs-ed__bottom">
        <div class="cbs-ed__code">
          <div class="cbs-ed__tabbar">
            <div class="cbs-ed__tabs" role="tablist" aria-label="Export format">
              <button type="button" role="tab" id="cbs-ed-tab-css" aria-controls="cbs-ed-pane-css" aria-selected="true">CSS variables</button>
              <button type="button" role="tab" id="cbs-ed-tab-json" aria-controls="cbs-ed-pane-json" aria-selected="false" tabindex="-1">JSON</button>
              <button type="button" role="tab" id="cbs-ed-tab-dt" aria-controls="cbs-ed-pane-dt" aria-selected="false" tabindex="-1">Design-tool tokens</button>
            </div>
            <button type="button" class="cbs-ed__copy" data-cbs-ed-copy>Copy</button>
          </div>
          <pre class="cbs-ed__pre" role="tabpanel" id="cbs-ed-pane-css" aria-labelledby="cbs-ed-tab-css" tabindex="0"><code data-cbs-ed-code="css"></code></pre>
          <pre class="cbs-ed__pre" role="tabpanel" id="cbs-ed-pane-json" aria-labelledby="cbs-ed-tab-json" tabindex="0" hidden><code data-cbs-ed-code="json"></code></pre>
          <pre class="cbs-ed__pre" role="tabpanel" id="cbs-ed-pane-dt" aria-labelledby="cbs-ed-tab-dt" tabindex="0" hidden><code data-cbs-ed-code="dt"></code></pre>
          <p class="cbs-ed__copied" role="status" aria-live="polite" data-cbs-ed-copied></p>
          <dl class="cbs-ed__meta">
            <div><dt>Exports</dt><dd>tokens.css · tokens.json · tokens.dtcg.json</dd></div>
            <div><dt>Read by</dt><dd>web app · email CMS · slide templates · social kit</dd></div>
            <div><dt>Merge</dt><dd>proposal/primary → main · <span data-cbs-ed-merge>nothing to merge</span></dd></div>
          </dl>
        </div>

        <div class="cbs-ed__report" aria-live="polite">
          <p class="cbs-ed__rh"><span><i class="cbs-ed__bot" aria-hidden="true"></i>Agent · impact report</span><span data-cbs-ed-diff>0 changes</span></p>
          <ul class="cbs-ed__imp" data-cbs-ed-impact></ul>
          <p class="cbs-ed__rs">Contrast · WCAG 2.2</p>
          <ul class="cbs-ed__con" data-cbs-ed-contrast></ul>
          <p class="cbs-ed__human"><b>People decide</b><span>The agent flags; the system owner approves the release, or sends it back.</span></p>
        </div>
      </div>
    </div>
  </div>
</section>
