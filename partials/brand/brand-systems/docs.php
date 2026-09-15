<?php /* DRAFT COPY — review before launch */
/* 08 · System documentation — a docs site mock. Sidebar navigation opens pages; the search field
   filters the page index live. Page content comes from docs.js; the Button page is server-rendered
   so the mock reads without JavaScript. */
$cbs_dc_nav = [   // group => [[id, title, keywords], …] — ids match PAGES in docs.js
    'Get started' => [['install', 'Install and import', 'setup npm package design tool library figma'], ['principles', 'How to use this site', 'setup principles start']],
    'Foundations' => [['colour', 'Colour', 'color primary palette contrast tokens'], ['type', 'Typography', 'type scale ratio font heading'], ['space', 'Spacing and density', 'space unit density compact grid']],
    'Components'  => [['button', 'Button', 'button cta primary secondary contrast'], ['input', 'Input', 'form field input label error'], ['card', 'Card', 'card product article radius']],
    'Templates'   => [['email', 'Email header', 'email template header newsletter'], ['social', 'Social tile', 'social tile square story campaign']],
    'Governance'  => [['contribute', 'Propose a change', 'governance contribute proposal review'], ['releases', 'Releases and versions', 'governance semver release changelog deprecated breaking']],
];
?>
<section class="band cbs-dc" id="docs" aria-labelledby="cbs-dc-t">
  <div class="wrap">
    <div class="cbs-dc__intro">
      <header class="cbs-head" data-rv>
        <p class="cbs-head__path"><b>08</b><i>/</i>documentation<i>/</i>system-site</p>
        <h2 class="cbs-head__h" id="cbs-dc-t"><span class="g">A living site,</span> not a PDF.</h2>
        <p class="lead cbs-head__lead">The documentation shows the system in use, with design and code side by side and the owner of every page named. It is searchable, versioned with the releases, and yours to run. Search it below.</p>
      </header>
      <!-- PLACEHOLDER: reference photo (Unsplash) — confirm before launch -->
      <figure class="cbs-photo cbs-dc__photo" data-rv>
        <img src="<?= xe_url('assets/imgs/brand/brand-systems/docs-team.jpg') ?>" alt="A small team gathered around a monitor, one person pointing at the screen" width="1200" height="900" loading="lazy" decoding="async">
        <figcaption><span>Design and engineering, one page each</span></figcaption>
      </figure>
    </div>

    <div class="cbs-dc__site" data-cbs-dc>
      <div class="cbs-dc__top">
        <p class="cbs-dc__brand"><span class="cbs-dc__mark" aria-hidden="true"></span>Your brand <span>system</span></p>
        <div class="cbs-dc__search">
          <label class="bdh-sr" for="cbs-dc-q">Search the documentation</label>
          <input type="search" id="cbs-dc-q" placeholder="Search pages, tokens, components" autocomplete="off" spellcheck="false" data-cbs-dc-q aria-describedby="cbs-dc-count">
          <kbd aria-hidden="true">/</kbd>
        </div>
        <label class="cbs-dc__ver"><span class="bdh-sr">Documentation version</span>
          <select data-cbs-dc-ver><option>v2.4.0</option><option>v2.3.2</option><option>v1.4.0</option></select>
        </label>
      </div>

      <div class="cbs-dc__body">
        <nav class="cbs-dc__nav" aria-label="Documentation pages">
          <p class="cbs-dc__count" id="cbs-dc-count" role="status" aria-live="polite" data-cbs-dc-count>12 pages</p>
          <?php foreach ($cbs_dc_nav as $cbs_grp => $cbs_pages): ?>
            <div class="cbs-dc__grp" data-cbs-dc-grp>
              <p class="cbs-dc__gl"><?= e($cbs_grp) ?></p>
              <ul>
                <?php foreach ($cbs_pages as $cbs_pg): ?>
                  <li data-cbs-dc-li><button type="button" data-cbs-dc-page="<?= e($cbs_pg[0]) ?>" data-kw="<?= e($cbs_pg[2]) ?>"<?= $cbs_pg[0] === 'button' ? ' aria-current="page"' : '' ?>><?= e($cbs_pg[1]) ?></button></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endforeach; ?>
          <p class="cbs-dc__none" hidden data-cbs-dc-none>No pages match. Try “contrast” or “release”.</p>
        </nav>

        <article class="cbs-dc__page" data-cbs-dc-out tabindex="-1" aria-live="polite">
          <p class="cbs-dc__crumb">Components / Button</p>
          <h3 class="cbs-dc__h">Button</h3>
          <p class="cbs-dc__lede">The main action on a surface. One primary per view; secondary and text buttons for everything else.</p>
          <div class="cbs-dc__split">
            <div class="cbs-dc__ex" aria-hidden="true"><span class="cbs-dc__x-btn">Book a demo</span><span class="cbs-dc__x-btn is-2">Compare plans</span></div>
            <pre class="cbs-dc__code"><code>&lt;Button variant="primary"&gt;Book a demo&lt;/Button&gt;</code></pre>
          </div>
          <ul class="cbs-dc__rules"><li class="is-do"><b>Do</b>Use one primary button per view.</li><li class="is-dont"><b>Don’t</b>Set label text below 4.5:1 contrast.</li></ul>
          <p class="cbs-dc__meta"><span>Owner · Design systems lead</span><span>Updated in v2.4.0</span></p>
        </article>
      </div>
    </div>
  </div>
</section>
