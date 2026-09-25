<?php /* DRAFT COPY — review before launch */
/* Share — plain links only. No third-party widget, no tracking script, nothing that loads from
   another origin: LinkedIn and X take a URL in their own intent endpoint, e-mail is a mailto, and
   the permalink is an ordinary anchor that works with JavaScript off.
   The copy and print buttons do need JavaScript, so they ship hidden and post.js reveals them.
   Set $blg_share_variant ('rail' | 'end') before including. Each include gets its own ids. */
$shr_variant = $blg_share_variant ?? 'end';
unset($blg_share_variant);
$GLOBALS['blg_share_n'] = ($GLOBALS['blg_share_n'] ?? 0) + 1;   // several includes per page, so ids stay unique
$shr_id   = 'share-' . $GLOBALS['blg_share_n'];
$shr_url  = blog_abs('blog/' . $POST['slug'] . '.php');
$shr_text = $POST['title'] . ' — ' . $SITE['company']['name'];
$shr_mail = 'mailto:?subject=' . rawurlencode($shr_text) . '&body=' . rawurlencode($POST['dek'] . "\n\n" . $shr_url);
$shr_li   = 'https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode($shr_url);
$shr_x    = 'https://x.com/intent/post?url=' . rawurlencode($shr_url) . '&text=' . rawurlencode($POST['title']);
?>
<div class="blg-share blg-share--<?= e($shr_variant) ?>" data-blg-share data-url="<?= e($shr_url) ?>">
  <p class="blg-k" id="<?= e($shr_id) ?>-t">Share this</p>
  <ul class="blg-share__l" aria-labelledby="<?= e($shr_id) ?>-t">
    <li>
      <a class="blg-share__b" href="<?= e($shr_li) ?>" target="_blank" rel="noopener">
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.42v1.56h.05c.47-.9 1.63-1.85 3.37-1.85 3.6 0 4.26 2.37 4.26 5.46v6.28ZM5.34 7.43a2.06 2.06 0 1 1 0-4.13 2.06 2.06 0 0 1 0 4.13ZM7.12 20.45H3.56V9h3.56v11.45Z"/></svg>
        <span>LinkedIn<span class="bdh-sr"> — share this post on LinkedIn, opens in a new tab</span></span>
      </a>
    </li>
    <li>
      <a class="blg-share__b" href="<?= e($shr_x) ?>" target="_blank" rel="noopener">
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M17.53 3h3.2l-6.99 7.99L22 21h-6.44l-5.04-6.6L4.75 21H1.54l7.48-8.55L2 3h6.6l4.56 6.03L17.53 3Zm-1.12 16.06h1.77L7.68 4.84H5.78l10.63 14.22Z"/></svg>
        <span>X<span class="bdh-sr"> — share this post on X, opens in a new tab</span></span>
      </a>
    </li>
    <li>
      <a class="blg-share__b" href="<?= e($shr_mail) ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="m3.6 6.8 8.4 6 8.4-6"/></svg>
        <span>E-mail<span class="bdh-sr"> — share this post by e-mail</span></span>
      </a>
    </li>
    <li>
      <button class="blg-share__b blg-share__b--copy" type="button" data-blg-copy hidden>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="9" y="9" width="11" height="11" rx="2.5"/><path d="M15 6.5V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h.5"/></svg>
        <span data-blg-copy-label>Copy link</span>
      </button>
    </li>
    <li>
      <button class="blg-share__b blg-share__b--print" type="button" data-blg-print hidden>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M7 9V4h10v5"/><rect x="4" y="9" width="16" height="7" rx="2"/><path d="M7 16h10v4H7z"/></svg>
        <span>Print</span>
      </button>
    </li>
  </ul>
  <p class="blg-share__link">Permalink <a class="blg-a" href="<?= e(blog_url($POST['slug'])) ?>"><?= e($shr_url) ?></a></p>
  <p class="blg-share__live" role="status" aria-live="polite" data-blg-copy-status></p>
</div>
