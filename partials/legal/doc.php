<?php /* DRAFT COPY — review before launch */ ?>
<?php
/**
 * The one legal document template (prefix lgl). A page sets $LG and requires this file; it renders
 * head, nav, the document header with its "In short" box, the sticky contents rail (a <details> that
 * collapses on phones), the body partial, related policies and the footer.
 *
 *   $LG = [
 *     'key'   => register key in $LGL_POLICIES     'h1' => [grey phrase, ink rest]
 *     'lead'  => one-paragraph lead                'short' => ['…', …]  the "In short" points
 *     'scope' => who/what it applies to            'toc' => [id => title]  body sections, in order
 *     'body'  => partial path                      'related' => [key, …]
 *     'css'/'js' => extra assets (optional)
 *   ]
 */
$lgl_doc   = $LGL_POLICIES[$LG['key']];
$lgl_css = ['assets/css/brand/hub.css', 'assets/css/tech/kit.css', 'assets/css/legal.css'];
$page = [
    'key'   => 'legal',
    'title' => $lgl_doc['title'],
    'desc'  => $lgl_doc['sum'],
    'css'   => $lgl_css,
    'js'    => ['assets/js/legal.js'],
];
include __DIR__ . '/../head.php';
include __DIR__ . '/../nav.php';
$lgl_idx = array_search($LG['key'], array_keys($LGL_POLICIES), true) + 1;
?>
<!-- PLACEHOLDER: legal review by qualified counsel before launch -->
<main id="main" class="bdh lgl lgl--<?= e($LG['key']) ?>">

<header class="band lgl-hero" aria-labelledby="lgl-h1">
  <div class="wrap lgl-hero__g">
    <div class="lgl-hero__main">
      <nav class="lgl-crumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="<?= e(lgl_url('index')) ?>">Legal</a></li>
          <li aria-current="page"><?= e($lgl_doc['title']) ?></li>
        </ol>
      </nav>
      <p class="lbl lbl--blue"><span class="dot"></span>Legal · <?= sprintf('%02d', $lgl_idx) ?> of <?= count($LGL_POLICIES) ?></p>
      <h1 class="d2 lgl-h1" id="lgl-h1"><span class="g"><?= e($LG['h1'][0]) ?></span> <?= e($LG['h1'][1]) ?></h1>
      <p class="lead lgl-lead"><?= $LG['lead'] ?></p>
      <dl class="lgl-meta">
        <div><dt>Last updated</dt><dd><time datetime="<?= e($lgl_doc['iso']) ?>"><?= e($lgl_doc['updated']) ?></time></dd></div>
        <div><dt>Version</dt><dd><?= e($lgl_doc['version']) ?></dd></div>
        <div><dt>Applies to</dt><dd><?= e($LG['scope']) ?></dd></div>
      </dl>
      <p class="lgl-draft"><span class="lgl-draft__dot" aria-hidden="true"></span>Draft — under legal review. This text may change before it takes effect.</p>
    </div>
    <aside class="lgl-short" aria-labelledby="lgl-short-t">
      <p class="lgl-short__k" id="lgl-short-t">In short</p>
      <ol class="lgl-short__l">
        <?php foreach ($LG['short'] as $lgl_s): ?><li><?= $lgl_s ?></li><?php endforeach; ?>
      </ol>
      <p class="lgl-short__f">The full text below governs. The summary is here to help, not to replace it.</p>
    </aside>
  </div>
</header>

<div class="band lgl-docband">
  <div class="wrap lgl-doc">
    <nav class="lgl-toc" aria-label="On this page">
      <details class="lgl-toc__d" open data-lgl-toc>
        <summary class="lgl-toc__s"><span>On this page</span><span class="lgl-toc__n"><?= count($LG['toc']) ?> sections</span></summary>
        <ol class="lgl-toc__l">
          <?php $lgl_n = 0; foreach ($LG['toc'] as $lgl_id => $lgl_t): $lgl_n++; ?>
            <li><a href="#<?= e($lgl_id) ?>"><span class="lgl-toc__i"><?= sprintf('%02d', $lgl_n) ?></span><?= e($lgl_t) ?></a></li>
          <?php endforeach; ?>
        </ol>
      </details>
      <div class="lgl-toc__x">
        <a class="lgl-toc__top" href="#main">Back to top</a>
        <button class="lgl-toc__print" type="button" data-lgl-print hidden>Print or save as PDF</button>
      </div>
    </nav>
    <article class="lgl-body" aria-labelledby="lgl-h1">
      <?php include $LG['body']; ?>
      <footer class="lgl-end">
        <p><strong><?= e($lgl_doc['title']) ?></strong> · version <?= e($lgl_doc['version']) ?> · last updated <?= e($lgl_doc['updated']) ?>.</p>
        <p>Questions about this document: <a class="tl" href="<?= e(lgl_mail($lgl_doc['title'] . ' — question')) ?>"><?= e($SITE['company']['email']) ?></a>. This page is a draft under review by counsel and is not legal advice.</p>
      </footer>
    </article>
  </div>
</div>

<section class="band band--alt lgl-rel" aria-labelledby="lgl-rel-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div><p class="lbl lbl--blue"><span class="dot"></span>Related policies</p>
        <h2 class="h2" id="lgl-rel-t"><span class="g">Read it alongside.</span> The documents this one leans on.</h2></div>
      <div><p class="lead">Every policy, its date and its version sit in one register.</p>
        <p><a class="btn btn--out" href="<?= e(lgl_url('index')) ?>">All legal documents <span class="i" aria-hidden="true">›</span></a></p></div>
    </div>
    <ul class="lgl-rel__l">
      <?php foreach ($LG['related'] as $lgl_k): $lgl_r = $LGL_POLICIES[$lgl_k]; ?>
        <li class="lgl-rel__c">
          <span class="lgl-rel__ico"><?= xt_icon($lgl_r['icon']) ?></span>
          <h3 class="lgl-rel__t"><a href="<?= e(lgl_url($lgl_k)) ?>"><?= e($lgl_r['title']) ?></a></h3>
          <p class="lgl-rel__d"><?= e($lgl_r['sum']) ?></p>
          <p class="lgl-rel__m">v<?= e($lgl_r['version']) ?> · <?= e($lgl_r['updated']) ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
</main>
<script type="application/ld+json"><?= json_encode([
    '@context' => 'https://schema.org', '@type' => 'WebPage', 'name' => $lgl_doc['title'], 'description' => $lgl_doc['sum'],
    'dateModified' => $lgl_doc['iso'], 'version' => $lgl_doc['version'], 'inLanguage' => 'en-IN',
    'publisher' => ['@type' => 'Organization', 'name' => $SITE['company']['name']],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?php include __DIR__ . '/../footer.php'; ?>
