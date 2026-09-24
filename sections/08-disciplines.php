<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* 08 — six disciplines. A static six-tab index in the ink column drives the
   discipline pane on the right. Data lives here so the tabs, panes and hub links
   stay in step; ids and order must match DISCIPLINES.json (the nav depends on them). */
$s08_items = [
  ['slug' => 'brand-design', 'name' => 'Brand Design',
   'intro' => 'We define who a brand can become across every interaction that shapes it, and build the systems that let it show up that way at scale.',
   'caps' => ['Growth Strategy', 'Brand Identity', 'Brand Foundation', 'Brand Systems', 'Brand Architecture', 'Brand AI Tools'],
   'more' => ['#brand', 'See what each produces']],
  ['slug' => 'technology-intelligence', 'name' => 'Technology & Intelligence',
   'intro' => 'We build and run the technical foundation a brand needs — software, AI systems, infrastructure, and the security and support to keep it all dependable.',
   'caps' => ['Websites & Apps', 'Custom Software & Data Platforms', 'AI Strategy & Agents', 'AI Product & Automation', 'AI Infrastructure & Cloud', 'Cybersecurity & AI Trust', 'Integration & Support', 'Search & AI Visibility', 'Audits & Assessments', 'Tech Workforce'],
   'more' => ['#technology', 'See the system']],
  ['slug' => 'campaign-content', 'name' => 'Campaign & Content Design',
   'intro' => 'We build campaigns and content systems that earn a place in culture — using storytelling that pulls technology, media, and design into one thread.',
   'caps' => ['Content Marketing', 'Social Media Marketing', 'Public Relations', 'Social & Influencer Activation', 'Performance Marketing', 'Omnichannel Marketing Strategy', 'Campaign Design Systems', 'Global Content Production']],
  ['slug' => 'ai-design', 'name' => 'AI Design',
   'intro' => 'Using AI well under the hood is table stakes now. We go further — designing brand experiences that simply weren\'t possible before AI existed.',
   'caps' => ['AI Application Design', 'AI Content Studio', 'Brand AI Tools', 'AI Strategy & Consulting']],
  ['slug' => 'product-experience', 'name' => 'Product & Experience Design',
   'intro' => 'We rethink how people actually use what a brand builds — shaping the strategy and design that sits ahead of every build.',
   'caps' => ['Design Consulting & Solutioning', 'Product Strategy & Vision', 'Experience Design & Development', 'AI Product Strategy & Development', 'System Design']],
  ['slug' => 'marketing-technology', 'name' => 'Marketing Technology',
   'intro' => 'We build the technology backbone that makes personalization, automation, and always-on marketing possible, and design the relationships that turn a single purchase into a lasting one.',
   'caps' => ['AI-Driven Marketing Automation', 'Content & Communication Infrastructure', 'AI Campaign Optimization', 'AI Creative Solutions', 'AI Lead Generation', 'Automated & Dynamic Sales', 'Customer Journey Mapping', 'Customer Segmentation & Insights', 'Customer Engagement Programs', 'Loyalty Strategy & Programs', 'Lifecycle Marketing']],
];
$s08_n = count($s08_items);
$s08_h = static fn(string $t): string => htmlspecialchars($t, ENT_QUOTES, 'UTF-8');
?>
<section class="band band--rules bdh s08" id="disciplines" aria-labelledby="s08-t">
  <!-- Deep-link anchors. The nav mega-menu links to #d-<slug>; 08-disciplines.js
       reads the hash on load and on hashchange, activates that discipline and
       brings the section into view. Keep the ids and the order in sync with
       DISCIPLINES.json — the navigation depends on them. -->
<?php foreach ($s08_items as $s08_it): ?>
  <span class="sr" id="d-<?= $s08_h($s08_it['slug']) ?>"></span>
<?php endforeach; ?>

  <div class="wrap">
    <div class="bdh-head bdh-head--row s08__head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>What we do</p>
        <h2 class="h2" id="s08-t"><span class="g">One team,</span> six ways we help brands get ahead</h2>
      </div>
      <div>
        <p class="lead s08__lead">
          We bring together strategy, craft, and technology to build intelligent brand systems —
          the kind that create real differentiation, real customer value, and real growth.
        </p>
      </div>
    </div>

    <div class="s08__panel" data-s08-panel data-rv data-rv-d="90">

      <!-- LEFT — the ink index. Six tabs, static. While the panel is on screen the
           active tab's rail fills and hands on to the next; any interaction stops it.
           Without JS each tab is an in-page link to its (stacked) pane. -->
      <div class="s08__left">
        <div class="s08__sticky">
        <p class="s08__kick" aria-hidden="true"><span>Disciplines</span><span><?= sprintf('%02d', $s08_n) ?></span></p>
        <div class="s08__scroller" data-s08-scroller role="region" aria-label="Disciplines">
          <div class="s08__track" data-s08-track role="tablist" aria-orientation="vertical" aria-label="Six disciplines">
<?php foreach ($s08_items as $s08_k => $s08_it): $s08_on = $s08_k === 0; ?>
            <a class="s08__pill<?= $s08_on ? ' is-on' : '' ?>" href="#s08-pane-<?= $s08_k ?>" role="tab" data-i="<?= $s08_k ?>"
               id="s08-tab-<?= $s08_k ?>" aria-controls="s08-pane-<?= $s08_k ?>" aria-selected="<?= $s08_on ? 'true' : 'false' ?>" tabindex="<?= $s08_on ? '0' : '-1' ?>">
              <span class="s08__pn" aria-hidden="true"><?= sprintf('%02d', $s08_k + 1) ?></span><span class="s08__pl"><?= $s08_h($s08_it['name']) ?></span><span class="s08__bar" aria-hidden="true"></span>
            </a>
<?php endforeach; ?>
          </div>
        </div>
        </div>
        <p class="s08__keys" aria-hidden="true"><kbd>↑</kbd><kbd>↓</kbd>to browse</p>
      </div>

      <!-- RIGHT — the active discipline. Every pane ships in the markup and all six
           share one grid cell, so the panel is exactly as tall as the longest pane;
           only the active one is visible (the rest are visibility:hidden). -->
      <div class="s08__right">
        <div class="s08__stack" data-s08-stack>
<?php foreach ($s08_items as $s08_k => $s08_it):
        $s08_hub = 'services/' . $s08_it['slug'] . '.php';
        $s08_has = is_file(__DIR__ . '/../' . $s08_hub); ?>
          <article class="s08__pane<?= $s08_k === 0 ? ' is-on' : '' ?>" id="s08-pane-<?= $s08_k ?>" role="tabpanel" aria-labelledby="s08-tab-<?= $s08_k ?>" data-i="<?= $s08_k ?>">
            <div class="s08__meta" aria-hidden="true">
              <span class="s08__n"><?= sprintf('%02d', $s08_k + 1) ?> <i>/ <?= sprintf('%02d', $s08_n) ?></i></span>
            </div>
            <h3 class="s08__name"><?= $s08_h($s08_it['name']) ?></h3>
            <p class="s08__intro"><?= $s08_h($s08_it['intro']) ?></p>
<?php /* Brand Design and Technology & Intelligence are expanded by 23 and 24 directly below,
         so here their capabilities run as one inline line with a link down to the full version */ ?>
            <ul class="s08__caps<?= isset($s08_it['more']) ? ' s08__caps--line' : '' ?>">
<?php foreach ($s08_it['caps'] as $s08_cap): ?>
              <li class="s08__cap"><?= $s08_h($s08_cap) ?></li>
<?php endforeach; ?>
            </ul>
<?php if (isset($s08_it['more'])): ?>
            <a class="tl s08__down" href="<?= $s08_h($s08_it['more'][0]) ?>"><?= $s08_h($s08_it['more'][1]) ?> <span class="s08__arr" aria-hidden="true">↓</span></a>
<?php endif; ?>
            <div class="s08__acts">
<?php if ($s08_has): ?>
              <a class="btn btn--ink s08__hub" href="<?= $s08_h(xe_url($s08_hub)) ?>">Explore <?= $s08_h($s08_it['name']) ?> <span class="i" aria-hidden="true">›</span></a>
<?php endif; ?>
              <a class="tl s08__cta" href="#book">Talk to us about <?= $s08_h($s08_it['name']) ?> <span class="i" aria-hidden="true">›</span></a>
            </div>
          </article>
<?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
  <noscript><style>
    .s08__stack{display:block}
    .s08__pane{position:static;visibility:visible;opacity:1;transform:none}
    .s08__keys{display:none}
    .s08__pane + .s08__pane{margin-top:40px;padding-top:40px;border-top:1px solid var(--line)}
    .s08__pill,.s08__pill.is-on{background:transparent;border-color:var(--on-ink-line);color:var(--on-ink-2)}
    .s08__pill .s08__pn,.s08__pill.is-on .s08__pn{color:var(--on-ink-3)}
    .s08__pill:hover{background:var(--on-ink-card);color:var(--on-ink)}
    @media (min-width:901px){
      .s08__panel{overflow:clip}
      .s08__left{display:block}
      .s08__sticky{position:sticky;top:176px}
    }
  </style></noscript>
</section>
