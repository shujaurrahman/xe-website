<?php
/**
 * Technology & Intelligence — kit sheet. A development reference, not a public page:
 * every logo by category, the stack variants, every icon, every standards badge on paper
 * and ink, and the "Keep going" partial for a sample capability.
 *
 *   php -S 127.0.0.1:8912 router.php   →   http://127.0.0.1:8912/tools/tech-kit
 */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';

$TI  = require __DIR__ . '/../data/technology-intelligence.php';
$tks_stack = xt_stack_data();
$tks_cats  = xt_categories();
$tks_by    = [];
foreach ($tks_stack as $tks_slug => $tks_row) { $tks_by[$tks_row['category']][] = $tks_slug; }
$tks_files = count(array_filter($tks_stack, fn ($tks_r) => !empty($tks_r['file'])));

$tks_sample = $_GET['cap'] ?? 'ai-infrastructure-cloud';
$CAP = $TI[$tks_sample] ?? $TI['ai-infrastructure-cloud'];

$page = [
    'key'   => 'tools',
    'title' => 'Technology kit',
    'desc'  => 'Shared logos, icons, standards badges and the onward aid for the Technology & Intelligence pages.',
    'css'   => ['assets/css/brand/hub.css', 'assets/css/tech/kit.css'],
    'js'    => ['assets/js/brand/hub.js'],
];

include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/nav.php';
?>
<style>
  /* sheet layout only */
  .tks{--tks-gap:clamp(20px,2.4vw,32px)}
  .tks-top{padding-top:clamp(136px,16vh,196px)}
  .tks-top .d2{max-width:18ch;margin-block:18px}
  .tks-top dl{display:flex;flex-wrap:wrap;gap:12px 40px;margin-top:32px}
  .tks-top dt{font-family:var(--f);font-size:var(--t-lbl);letter-spacing:.14em;text-transform:uppercase;color:var(--faint)}
  .tks-top dd{font-family:var(--f);font-size:1.5rem;color:var(--ink)}
  .tks-cat+.tks-cat{margin-top:clamp(40px,4vw,56px)}
  .tks-cat__h{display:flex;align-items:baseline;justify-content:space-between;gap:16px;margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid var(--line)}
  .band--ink .tks-cat__h{border-color:var(--on-ink-line)}
  .tks-cat__h small{font-family:var(--f);font-size:var(--t-lbl);letter-spacing:.12em;text-transform:uppercase;color:var(--faint)}
  .tks-demo{display:grid;gap:clamp(36px,4vw,56px)}
  .tks-demo>div{display:flex;flex-direction:column;gap:14px;min-width:0}
  .tks-code{font-family:var(--f);font-size:var(--t-xs);color:var(--muted);overflow-wrap:anywhere}
  .band--ink .tks-code{color:var(--on-ink-3)}
  .tks-icons{display:grid;grid-template-columns:repeat(auto-fill,minmax(112px,1fr));gap:8px;list-style:none}
  .tks-icons li{display:flex;flex-direction:column;align-items:center;gap:12px;padding:20px 8px 14px;border:1px solid var(--line);border-radius:var(--r);background:var(--paper);color:var(--ink)}
  .band--ink .tks-icons li{background:var(--on-ink-card);border-color:var(--on-ink-line);color:var(--on-ink)}
  .tks-icons span{font-family:var(--f);font-size:.625rem;letter-spacing:.04em;color:var(--muted);text-align:center;overflow-wrap:anywhere}
  .band--ink .tks-icons span{color:var(--on-ink-3)}
  .tks-chips{display:flex;flex-wrap:wrap;gap:8px;list-style:none}
  .tks-detail{display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,340px),1fr));gap:36px var(--tks-gap);list-style:none}
  .tks-sizes{display:flex;flex-wrap:wrap;align-items:center;gap:28px;color:var(--ink)}
</style>

<main id="main" class="tks bdh">

  <section class="band tks-top" aria-labelledby="tks-t">
    <div class="wrap">
      <p class="lbl lbl--blue"><span class="dot"></span>Technology &amp; Intelligence · shared kit</p>
      <h1 class="d2" id="tks-t"><span class="g">One kit,</span> ten capability pages.</h1>
      <p class="lead">Logos from data/tech-stack.php, line icons, code-built standards badges and the onward aid. Render through partials/tech/kit.php; style from assets/css/tech/kit.css.</p>
      <dl>
        <div><dt>Technologies</dt><dd><?= count($tks_stack) ?></dd></div>
        <div><dt>SVG marks</dt><dd><?= $tks_files ?></dd></div>
        <div><dt>Wordmarks</dt><dd><?= count($tks_stack) - $tks_files ?></dd></div>
        <div><dt>Icons</dt><dd><?= count(xt_icons()) ?></dd></div>
        <div><dt>Standards</dt><dd><?= count(xt_standards()) ?></dd></div>
      </dl>
    </div>
  </section>

  <section class="band band--alt tks-logos" aria-labelledby="tks-logos-t">
    <div class="wrap">
      <div class="bdh-head">
        <p class="lbl"><span class="dot"></span>xt_stack($slugs, ['variant' =&gt; 'tiles'])</p>
        <h2 class="h2" id="tks-logos-t"><span class="g">Logo library,</span> by category</h2>
        <p class="lead">Monochrome Simple Icons marks in currentColor. Brands without a licence-clean mark render as a mono wordmark.</p>
      </div>
      <?php foreach ($tks_cats as $tks_ck => $tks_cl): if (empty($tks_by[$tks_ck])) continue; ?>
        <div class="tks-cat">
          <div class="tks-cat__h"><h3 class="h4"><?= e($tks_cl) ?></h3><small><?= e($tks_ck) ?> · <?= count($tks_by[$tks_ck]) ?></small></div>
          <?= xt_stack($tks_by[$tks_ck], ['variant' => 'tiles', 'label' => $tks_cl]) ?>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="band tks-variants" aria-labelledby="tks-var-t">
    <div class="wrap">
      <div class="bdh-head">
        <p class="lbl"><span class="dot"></span>Variants on paper</p>
        <h2 class="h2" id="tks-var-t"><span class="g">Chips, logos,</span> rows and marquee</h2>
      </div>
      <div class="tks-demo">
        <div><p class="tks-code">xt_stack($CAP['stack']) · chips</p><?= xt_stack($CAP['stack']) ?></div>
        <div><p class="tks-code">xt_stack($CAP['stack'], ['variant' =&gt; 'logos'])</p><?= xt_stack($CAP['stack'], ['variant' => 'logos']) ?></div>
        <div><p class="tks-code">xt_stack($slugs, ['variant' =&gt; 'tiles', 'cat' =&gt; true, 'size' =&gt; 32])</p><?= xt_stack(array_slice($CAP['stack'], 0, 8), ['variant' => 'tiles', 'cat' => true, 'size' => 32]) ?></div>
        <div><p class="tks-code">xt_stack($slugs, ['variant' =&gt; 'row', 'marquee' =&gt; true])</p><?= xt_stack(array_merge($TI['ai-product-automation']['stack'], $TI['websites-apps']['stack']), ['variant' => 'row', 'marquee' => true, 'label' => 'Technologies we work with']) ?></div>
        <div><p class="tks-code">xt_logo($slug, ['size' =&gt; 16 | 24 | 40]) · xt_logo($slug, ['label' =&gt; true])</p>
          <div class="tks-sizes"><?= xt_logo('kubernetes', ['size' => 16]) ?><?= xt_logo('kubernetes', ['size' => 24]) ?><?= xt_logo('kubernetes', ['size' => 40]) ?><?= xt_logo('amazonwebservices') ?><?= xt_logo('postgresql', ['label' => true]) ?><?= xt_logo('salesforce', ['label' => true]) ?></div>
        </div>
      </div>
    </div>
  </section>

  <section class="band band--ink tks-ink" aria-labelledby="tks-ink-t">
    <div class="wrap">
      <div class="bdh-head">
        <p class="lbl"><span class="dot"></span>Variants on ink</p>
        <h2 class="h2" id="tks-ink-t"><span class="g">The same kit</span> on a dark band</h2>
      </div>
      <div class="tks-demo">
        <div><p class="tks-code">chips</p><?= xt_stack($TI['cybersecurity-ai-trust']['stack']) ?></div>
        <div><p class="tks-code">logos</p><?= xt_stack($TI['cybersecurity-ai-trust']['stack'], ['variant' => 'logos']) ?></div>
        <div><p class="tks-code">tiles</p><?= xt_stack(array_slice($TI['ai-strategy-agents']['stack'], 0, 8), ['variant' => 'tiles', 'cat' => true]) ?></div>
        <div><p class="tks-code">marquee row</p><?= xt_stack($TI['ai-infrastructure-cloud']['stack'], ['variant' => 'row', 'marquee' => true, 'speed' => 40]) ?></div>
      </div>
    </div>
  </section>

  <section class="band tks-icons-s" aria-labelledby="tks-ico-t">
    <div class="wrap">
      <div class="bdh-head">
        <p class="lbl"><span class="dot"></span>xt_icon($name)</p>
        <h2 class="h2" id="tks-ico-t"><span class="g"><?= count(xt_icons()) ?> line icons,</span> 24 px, stroke 1.5</h2>
      </div>
      <ul class="tks-icons" role="list">
        <?php foreach (xt_icons() as $tks_i): ?><li><?= xt_icon($tks_i) ?><span><?= e($tks_i) ?></span></li><?php endforeach; ?>
      </ul>
    </div>
  </section>

  <section class="band band--ink tks-icons-ink" aria-labelledby="tks-icoi-t">
    <div class="wrap">
      <div class="bdh-head">
        <p class="lbl"><span class="dot"></span>Icons on ink · mono variant below</p>
        <h2 class="h2" id="tks-icoi-t"><span class="g">Icons</span> on a dark band</h2>
      </div>
      <ul class="tks-icons" role="list">
        <?php foreach (array_slice(xt_icons(), 0, 24) as $tks_i): ?><li><?= xt_icon($tks_i) ?><span><?= e($tks_i) ?></span></li><?php endforeach; ?>
        <?php foreach (array_slice(xt_icons(), 24, 12) as $tks_i): ?><li><?= xt_icon($tks_i, ['mono' => true]) ?><span><?= e($tks_i) ?> · mono</span></li><?php endforeach; ?>
      </ul>
    </div>
  </section>

  <section class="band band--alt tks-badges" aria-labelledby="tks-bdg-t">
    <div class="wrap">
      <div class="bdh-head">
        <p class="lbl"><span class="dot"></span>xt_badge($key)</p>
        <h2 class="h2" id="tks-bdg-t"><span class="g">Frameworks we build to</span> and align delivery with</h2>
        <p class="lead">Code-built badges, never official marks. Seal for management-system and technical standards, shield for security frameworks and regulation, hexagon for metrics and sustainability.</p>
      </div>
      <ul class="xt-badges" role="list">
        <?php foreach (array_keys(xt_standards()) as $tks_b): ?><?= xt_badge($tks_b, ['tag' => 'li']) ?><?php endforeach; ?>
      </ul>
      <div class="tks-cat" style="margin-top:clamp(48px,5vw,72px)">
        <div class="tks-cat__h"><h3 class="h4">Detail and apply</h3><small>['detail' =&gt; true, 'apply' =&gt; true, 'variant' =&gt; 'seal' | 'shield' | 'hex']</small></div>
        <ul class="tks-detail" role="list">
          <?= xt_badge('owasp-llm', ['tag' => 'li', 'detail' => true, 'apply' => true]) ?>
          <?= xt_badge('iso42001', ['tag' => 'li', 'detail' => true, 'apply' => true]) ?>
          <?= xt_badge('sci', ['tag' => 'li', 'detail' => true, 'apply' => true]) ?>
        </ul>
      </div>
      <div class="tks-cat">
        <div class="tks-cat__h"><h3 class="h4">Chip variant</h3><small>['variant' =&gt; 'chip']</small></div>
        <ul class="tks-chips" role="list"><?php foreach (array_keys(xt_standards()) as $tks_b): ?><?= xt_badge($tks_b, ['variant' => 'chip', 'tag' => 'li']) ?><?php endforeach; ?></ul>
      </div>
    </div>
  </section>

  <section class="band band--ink tks-badges-ink" aria-labelledby="tks-bdgi-t">
    <div class="wrap">
      <div class="bdh-head">
        <p class="lbl"><span class="dot"></span>Badges on ink</p>
        <h2 class="h2" id="tks-bdgi-t"><span class="g">Standards</span> on a dark band</h2>
      </div>
      <ul class="xt-badges" role="list">
        <?php foreach (array_keys(xt_standards()) as $tks_b): ?><?= xt_badge($tks_b, ['tag' => 'li']) ?><?php endforeach; ?>
      </ul>
      <ul class="tks-chips" role="list" style="margin-top:48px"><?php foreach (['iso27001', 'soc2', 'owasp-llm', 'eu-ai-act', 'dpdp', 'wcag22'] as $tks_b): ?><?= xt_badge($tks_b, ['variant' => 'chip', 'tag' => 'li']) ?><?php endforeach; ?></ul>
    </div>
  </section>

<?php include __DIR__ . '/../partials/tech/next.php'; ?>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
