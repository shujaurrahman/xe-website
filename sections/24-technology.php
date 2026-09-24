<?php /* DRAFT COPY — review before launch */ ?>
<?php
/**
 * 24 — Technology & Intelligence: what we build and run.
 *
 * "The manifest". The ten capabilities as one explorer: pick a capability in the rail and its
 * manifest opens — what it ships, the stack it runs on grouped into four run layers, and the
 * frameworks it is built to. The frameworks strip underneath works the other way round: choose
 * a framework and the rail marks every capability built to it.
 *
 * Differs from 08-disciplines (names only) and 14-platforms (a model-vendor wall): here the
 * technology is always tied to a capability and to the layer of the system it runs in.
 *
 * Data: data/site.php (approved one-liners), data/technology-intelligence.php (kicker, icon,
 * meta, offer, stack, standards), data/tech-stack.php via xt_* (partials/tech/kit.php, loaded
 * by index.php). Links: the hub and each capability page through xe_url().
 *
 * No JavaScript: the rail is hidden and all ten manifests render one after another, complete.
 * With JavaScript (24-technology.js) the rail becomes an ARIA tablist and one manifest shows.
 */
$s24_ti   = require __DIR__ . '/../data/technology-intelligence.php';
$s24_site = require __DIR__ . '/../data/site.php';

/* approved one-line descriptions, keyed by capability slug */
$s24_one = [];
foreach ($s24_site['disciplines'] as $s24_d) {
    if (($s24_d['slug'] ?? '') !== 'technology-intelligence') continue;
    foreach ($s24_d['caps'] as $s24_cp) { if (!empty($s24_cp[2])) $s24_one[$s24_cp[2]] = $s24_cp[1]; }
}

/* The four layers of the platform, as the Technology & Intelligence hub draws them */
$s24_groups = [
    ['L1', 'Experience',         ['websites-apps', 'search-ai-visibility']],
    ['L2', 'Intelligence',       ['ai-strategy-agents', 'ai-product-automation']],
    ['L3', 'Platform & data',    ['custom-software-data-platforms', 'ai-infrastructure-cloud', 'integration-support']],
    ['L4', 'Trust & operations', ['cybersecurity-ai-trust', 'audits-assessments', 'tech-workforce']],
];

/* Four run layers the stack is grouped into: the kit's eighteen categories folded down */
$s24_run = [
    'code'    => ['Code & interfaces',     ['languages', 'frontend', 'mobile', 'backend', 'content']],
    'data'    => ['Data & models',         ['data', 'ai-ml', 'llm', 'ai-tooling']],
    'ops'     => ['Cloud & operations',    ['cloud', 'devops', 'observability', 'quality', 'security']],
    'connect' => ['Connected systems',     ['integration', 'business', 'search', 'collaboration']],
];
$s24_cat_run = [];
foreach ($s24_run as $s24_rk => $s24_rv) { foreach ($s24_rv[1] as $s24_cat) $s24_cat_run[$s24_cat] = $s24_rk; }

/* Frameworks across all ten, most widely used first */
$s24_std_n = [];
foreach ($s24_ti as $s24_cap) { foreach ($s24_cap['standards'] as $s24_sk) $s24_std_n[$s24_sk] = ($s24_std_n[$s24_sk] ?? 0) + 1; }
arsort($s24_std_n);
$s24_total = count($s24_ti);

$s24_hub = xe_url('services/technology-intelligence.php');
$s24_link = function (string $slug): ?string {
    return is_file(__DIR__ . '/../services/technology-intelligence/' . $slug . '.php')
        ? xe_url('services/technology-intelligence/' . $slug . '.php') : null;
};
?>
<section class="band band--ink s24 bdh" id="technology" aria-labelledby="s24-t">
  <div class="wrap">

    <div class="bdh-head bdh-head--row s24__head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Technology &amp; Intelligence</p>
        <h2 class="h2" id="s24-t"><span class="g">Ten capabilities.</span> One system we build and run.</h2>
      </div>
      <div>
        <p class="lead">Software, AI and the infrastructure under them, built to recognised frameworks and looked after once they are live. Choose a capability to see what it ships, what it runs on and what it is built to.</p>
        <a class="tl" href="<?= e($s24_hub) ?>">See the whole platform <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <div class="s24__x" data-s24 data-rv data-rv-d="80">

      <!-- the rail: ten capabilities in the four layers they build. Tabs once JS runs. -->
      <div class="s24__rail" data-s24-rail>
        <?php foreach ($s24_groups as $s24_g): ?>
        <div class="s24__grp">
          <p class="s24__gl" aria-hidden="true"><b><?= e($s24_g[0]) ?></b> <?= e($s24_g[1]) ?></p>
          <div class="s24__tabs">
            <?php foreach ($s24_g[2] as $s24_slug): $s24_cap = $s24_ti[$s24_slug]; ?>
            <button class="s24__tab" type="button" id="s24-tab-<?= e($s24_slug) ?>" aria-controls="s24-cap-<?= e($s24_slug) ?>"
                    data-std="<?= e(implode(' ', $s24_cap['standards'])) ?>">
              <span class="s24__tn"><?= e($s24_cap['n']) ?></span>
              <span class="s24__tt"><?= e($s24_cap['name']) ?><span class="sr">, <?= e($s24_g[0] . ' ' . $s24_g[1]) ?></span></span>
              <span class="s24__bar" aria-hidden="true"></span>
            </button>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- the manifests: one per capability, in the rail's order -->
      <div class="s24__panes">
        <?php foreach ($s24_groups as $s24_g): foreach ($s24_g[2] as $s24_slug):
            $s24_cap  = $s24_ti[$s24_slug];
            $s24_href = $s24_link($s24_slug);
            $s24_by   = array_fill_keys(array_keys($s24_run), []);
            foreach ($s24_cap['stack'] as $s24_tech) {
                $s24_t = xt_tech($s24_tech);
                $s24_by[$s24_cat_run[$s24_t['category'] ?? ''] ?? 'connect'][] = $s24_tech;
            }
            $s24_used = count(array_filter($s24_by));
        ?>
        <article class="s24__pane" id="s24-cap-<?= e($s24_slug) ?>" aria-labelledby="s24-h-<?= e($s24_slug) ?>">
          <div class="s24__top" aria-hidden="true">
            <span class="s24__dots"><i></i><i></i><i></i></span>
            <span class="s24__path">your-platform / <?= e($s24_g[0]) ?> / <b><?= e($s24_slug) ?></b></span>
            <span class="s24__st"><i></i>running</span>
          </div>

          <div class="s24__body">
            <div class="s24__intro">
              <p class="s24__k"><span class="s24__ic"><?= xt_icon($s24_cap['icon'], ['size' => 20]) ?></span><?= e($s24_cap['n']) ?> · <?= e($s24_cap['kicker']) ?></p>
              <h3 class="s24__h" id="s24-h-<?= e($s24_slug) ?>"><?= e($s24_cap['name']) ?></h3>
              <p class="s24__d"><?= e($s24_one[$s24_slug] ?? $s24_cap['offer_lead']) ?></p>

              <p class="s24__sl">Ships</p>
              <ul class="s24__ships">
                <?php foreach (array_slice($s24_cap['offer'], 0, 4) as $s24_o): ?>
                <li><?= xt_icon($s24_o[3], ['size' => 16]) ?><span><?= e($s24_o[0]) ?></span></li>
                <?php endforeach; ?>
              </ul>

              <!-- PLACEHOLDER: confirm typical timeframes and terms before launch (data/technology-intelligence.php 'meta') -->
              <dl class="s24__meta">
                <?php foreach ($s24_cap['meta'] as $s24_mi => $s24_mv): ?>
                <div><dt><?= e($s24_cap['meta_k'][$s24_mi] ?? '') ?></dt><dd><?= e($s24_mv) ?></dd></div>
                <?php endforeach; ?>
              </dl>

              <?php if ($s24_href): ?>
              <a class="btn btn--white btn--sm s24__go" href="<?= e($s24_href) ?>">Explore <?= e($s24_cap['short']) ?> <span class="i" aria-hidden="true">›</span><span class="sr"> — <?= e($s24_cap['name']) ?></span></a>
              <?php endif; ?>
            </div>

            <div class="s24__spec">
              <div class="s24__runs">
                <p class="s24__sl">Runs on <span><?= count($s24_cap['stack']) ?> technologies · <?= $s24_used ?> of 4 layers</span></p>
                <ol class="s24__layers">
                  <?php $s24_li = 0; foreach ($s24_run as $s24_rk => $s24_rv): $s24_li++; $s24_has = !empty($s24_by[$s24_rk]); ?>
                  <li class="s24__lay<?= $s24_has ? '' : ' is-empty' ?>" style="--i:<?= $s24_li ?>">
                    <p class="s24__ln"><b>R<?= $s24_li ?></b> <?= e($s24_rv[0]) ?></p>
                    <?php if ($s24_has): ?>
                    <?= xt_stack($s24_by[$s24_rk], ['size' => 16, 'label' => $s24_rv[0] . ' for ' . $s24_cap['name'], 'class' => 's24__chips']) ?>
                    <?php else: ?>
                    <p class="s24__none">Draws on the shared platform</p>
                    <?php endif; ?>
                  </li>
                  <?php endforeach; ?>
                </ol>
              </div>

              <div class="s24__built">
                <p class="s24__sl">Built to <span>frameworks, not certifications</span></p>
                <ul class="s24__stds" aria-label="Frameworks <?= e($s24_cap['name']) ?> is built to">
                  <?php foreach ($s24_cap['standards'] as $s24_sk): ?>
                  <?= xt_badge($s24_sk, ['variant' => 'chip', 'tag' => 'li', 'class' => 's24__std-' . $s24_sk]) ?>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </div>
        </article>
        <?php endforeach; endforeach; ?>
      </div>
    </div>

    <!-- the reverse view: every framework across the ten, with how many capabilities build to it -->
    <div class="s24__fw" data-rv data-rv-d="120">
      <div class="s24__fwh">
        <p class="s24__sl">Frameworks we build to <span>across all <?= $s24_total ?></span></p>
        <p class="s24__fwr" data-s24-read aria-live="polite">Choose a framework to mark the capabilities built to it.</p>
      </div>
      <ul class="s24__fwl" id="s24-fwl">
        <?php $s24_fi = 0; foreach ($s24_std_n as $s24_sk => $s24_cnt): $s24_s = xt_standard($s24_sk); if (!$s24_s) continue; $s24_fi++; ?>
        <li<?= $s24_fi > 8 ? ' class="s24__more"' : '' ?>>
          <button class="s24__fb" type="button" disabled aria-pressed="false" data-s24-std="<?= e($s24_sk) ?>" data-code="<?= e($s24_s['code']) ?>" data-n="<?= (int) $s24_cnt ?>" style="--n:<?= (int) $s24_cnt ?>">
            <svg class="s24__pip" viewBox="0 0 12 12" aria-hidden="true" focusable="false"><path d="M6 1 10.5 2.8v3.1c0 2.6-1.9 4.5-4.5 5.3C3.4 10.4 1.5 8.5 1.5 5.9V2.8z"/></svg>
            <span class="s24__fc"><?= e($s24_s['code']) ?></span>
            <span class="s24__fn"><?= (int) $s24_cnt ?><i aria-hidden="true">/<?= $s24_total ?></i><span class="sr"> of <?= $s24_total ?> capabilities</span></span>
            <span class="s24__fm" aria-hidden="true"></span>
          </button>
        </li>
        <?php endforeach; ?>
      </ul>
      <button class="btn btn--sm s24__all" type="button" hidden aria-expanded="false" aria-controls="s24-fwl">Show all <?= count($s24_std_n) ?> frameworks</button>
      <p class="s24__note">Technologies are ones we work with; no partner, reseller or certification tier is implied. Frameworks are what delivery is built to and aligned with, not certifications held.</p>
    </div>

  </div>
</section>
