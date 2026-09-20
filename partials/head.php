<?php
/** Opens the document. Expects $page = ['title' =>, 'desc' =>, 'key' =>]. */
$title = $page['title'] ?? $SITE['company']['name'];
$desc  = $page['desc']  ?? $SITE['company']['tagline'];
$full  = ($page['key'] ?? '') === 'home'
    ? $title
    : $title . ' — ' . $SITE['company']['name'];
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($full) ?></title>
<meta name="description" content="<?= e($desc) ?>">
<meta name="theme-color" content="#FFFFFF">
<meta name="color-scheme" content="light">

<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= e($SITE['company']['name']) ?>">
<meta property="og:title" content="<?= e($full) ?>">
<meta property="og:description" content="<?= e($desc) ?>">
<meta property="og:image" content="<?= xe_url('assets/brand/icon-512.png') ?>">
<meta name="twitter:card" content="summary_large_image">

<link rel="icon" href="<?= xe_url('assets/brand/favicon.svg') ?>" type="image/svg+xml">
<link rel="icon" href="<?= xe_url('assets/brand/favicon-32.png') ?>" sizes="32x32">
<link rel="apple-touch-icon" href="<?= xe_url('assets/brand/apple-touch-icon.png') ?>">

<link rel="preload" href="<?= xe_url('assets/fonts/outfit-latin.woff2') ?>" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="<?= xe_url('assets/fonts/montserrat-latin.woff2') ?>" as="font" type="font/woff2" crossorigin>
<link rel="stylesheet" href="<?= xe_asset('assets/css/core.css') ?>">
<link rel="stylesheet" href="<?= xe_asset('assets/css/sections.css') ?>">
<noscript><style>.pre{display:none}</style></noscript><!-- the intro mark is dismissed by core.js; without JS it must never cover the page -->
<?php foreach ($page['css'] ?? [] as $css): ?>
<link rel="stylesheet" href="<?= xe_asset($css) ?>">
<?php endforeach; ?>

<noscript><style>
  /* Scroll reveals start hidden and are opened by a class core.js/hub.js add. Without JS that class
     never arrives, so every revealed element on the site would stay invisible. Restore the finished
     state here — after the page stylesheets, since brand/hub.css also declares .bdh-up{opacity:0}. */
  [data-rv],[data-rv-s]>*,.bdh-up{opacity:1;transform:none}
  .bdh-grow,.bdh-growY{transform:none}
  .bdh-draw :is(path,line,rect,circle,ellipse,polyline,polygon),:is(path,line,rect,circle,ellipse,polyline,polygon).bdh-draw{stroke-dashoffset:0}
</style></noscript>

<script type="application/ld+json">
<?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'Organization',
    'name'        => $SITE['company']['name'],
    'description' => $SITE['company']['tagline'],
    'email'       => $SITE['company']['email'],
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
</script>
</head>
<body<?= ($page['key'] ?? '') === 'home' ? ' id="top"' : '' ?> class="page page--<?= e($page['key'] ?? 'default') ?>">

<div class="pre" id="pre" aria-hidden="true">
  <video class="pre__v" width="832" height="464" muted playsinline preload="auto"
    poster="<?= xe_url('assets/brand/icon-512.png') ?>" src="<?= xe_url('assets/brand/xe-logo-anim.mp4') ?>"></video>
</div>

<a class="skip" href="#main">Skip to content</a>
