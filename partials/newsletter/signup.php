<?php /* DRAFT COPY — review before launch */
/**
 * =====================================================================================================
 * THE DISPATCH SIGN-UP — the reusable component. One line puts it on any page.
 * =====================================================================================================
 *
 *   <?php include __DIR__ . '/../newsletter/signup.php'; ?>          from a partial one folder deep
 *   <?php include __DIR__ . '/partials/newsletter/signup.php'; ?>    from a page at the site root
 *
 * That is the whole integration. The component brings its own stylesheet and script, so the host page
 * needs no change to $page['css'] or $page['js'], and it needs no per-page CSS: it reads its
 * surroundings and sits correctly on a plain paper band, on .band--alt and on .band--ink.
 *
 * OPTIONS — set $nl_signup immediately before the include. Every key is optional, and the array is
 * consumed, so a second include on the same page starts from the defaults again.
 *
 *   <?php $nl_signup = ['variant' => 'inline', 'id' => 'blog', 'source' => 'blog']; ?>
 *   <?php include __DIR__ . '/../newsletter/signup.php'; ?>
 *
 *   'variant'  'card' (default) · 'inline' (one row, for a hero or a footer) · 'full' (adds the
 *              optional interest boxes and the longer note)
 *   'id'       a-z0-9- , unique on the page. Default 'nls1', 'nls2', … It becomes the id prefix for
 *              every element inside, so two instances on one page never collide, and it is the key the
 *              result is rendered against (see RESULTS below).
 *   'source'   the page key recorded in the notification email, so we can tell which writing brings
 *              people in. Defaults to 'id'. Use the page's own key: 'blog', 'home', 'newsletter'.
 *   'heading'  a short heading rendered inside the card (card / full only). Omit on a page whose
 *              section already carries an <h2> above the component.
 *   'cta'      the button label. Default 'Subscribe'.
 *   'label'    the field label. Default 'Your email address'.
 *   'topics'   true / false — force the interest boxes on or off. Default: on for 'full' only.
 *
 * WHERE IT POSTS
 * Always to /newsletter, because that page is the only one that runs partials/newsletter/handler.php.
 * With JavaScript off, submitting from any page takes the visitor to /newsletter: a success shows the
 * confirmation there, and an error re-renders the form there with the address still in the box. With
 * JavaScript on, the component posts in the background and writes the answer into its own aria-live
 * region, so the visitor's page never moves.
 *
 * RESULTS
 * The handler puts the outcome in $NL. This component renders it only when $NL['inst'] matches this
 * instance's 'id', so on a page with three sign-ups the answer appears on the one that was used.
 * newsletter.php normalises an id it does not know into its main instance. On a page that never runs
 * the handler, $NL is simply absent and the component renders the plain form — that is the normal case
 * for every page except /newsletter.
 *
 * WHAT IT PROMISES THE VISITOR
 * Nothing that is not true. There is no database and no email service on this site yet, so a valid
 * submission emails the address to the company inbox and stops. The note under the field says exactly
 * that, and says that confirmed opt-in is the intention rather than the current behaviour.
 * <!-- PLACEHOLDER: confirm the email service, the confirmation email, the unsubscribe link and the
 *      sending address before launch, then update this note and partials/newsletter/handler.php. -->
 *
 * Locals are prefixed nls_ and the markup is .nls-*, so the component shares no name with any page.
 */

/* ---------- options, defaults and a per-request instance counter ---------- */
$nls_o = (isset($nl_signup) && is_array($nl_signup)) ? $nl_signup : [];
$nl_signup = null;
unset($nl_signup);

if (!isset($GLOBALS['nls_seq'])) { $GLOBALS['nls_seq'] = 0; }
$GLOBALS['nls_seq']++;

$nls_var = in_array($nls_o['variant'] ?? '', ['card', 'inline', 'full'], true) ? $nls_o['variant'] : 'card';
$nls_id  = (isset($nls_o['id']) && is_string($nls_o['id']) && preg_match('~^[a-z0-9][a-z0-9-]{0,39}$~', $nls_o['id']))
    ? $nls_o['id'] : 'nls' . $GLOBALS['nls_seq'];
$nls_src = (isset($nls_o['source']) && is_string($nls_o['source']) && preg_match('~^[a-z0-9][a-z0-9-]{0,39}$~', $nls_o['source']))
    ? $nls_o['source'] : $nls_id;
$nls_head = (isset($nls_o['heading']) && is_string($nls_o['heading'])) ? $nls_o['heading'] : '';
$nls_cta  = (isset($nls_o['cta'])   && is_string($nls_o['cta']))   ? $nls_o['cta']   : 'Subscribe';
$nls_lbl  = (isset($nls_o['label']) && is_string($nls_o['label'])) ? $nls_o['label'] : 'Your email address';
$nls_tops = array_key_exists('topics', $nls_o) ? (bool) $nls_o['topics'] : ($nls_var === 'full');
unset($nls_o);

/* ---------- its own assets, emitted once per request ----------
   A stylesheet link is valid in the body (rel="stylesheet" is body-ok in HTML), which is what lets the
   component be self-contained. A page that would rather load them in the head can add the two paths to
   $page['css'] / $page['js'] itself; the check below then finds them and emits nothing. */
$nls_css = 'assets/css/newsletter/signup.css';
$nls_js  = 'assets/js/newsletter/signup.js';
if (empty($GLOBALS['nls_assets'])) {
    $GLOBALS['nls_assets'] = true;
    if (!in_array($nls_css, (isset($page['css']) && is_array($page['css'])) ? $page['css'] : [], true)) {
        echo '<link rel="stylesheet" href="' . e(xe_asset($nls_css)) . '">' . "\n";
    }
    if (!in_array($nls_js, (isset($page['js']) && is_array($page['js'])) ? $page['js'] : [], true)) {
        echo '<script defer src="' . e(xe_asset($nls_js)) . '"></script>' . "\n";
    }
}

/* ---------- the state this instance renders ---------- */
$nls_st  = (isset($NL) && is_array($NL) && ($NL['inst'] ?? '') === $nls_id) ? ($NL['state'] ?? 'form') : 'form';
$nls_err = $nls_st === 'error' ? ($NL['errors'] ?? []) : [];
$nls_val = ($nls_st === 'error' || $nls_st === 'failed') ? ($NL['v']['email'] ?? '') : '';
$nls_sel = ($nls_st === 'error' || $nls_st === 'failed') ? ($NL['v']['topics'] ?? []) : [];
$nls_tok = (isset($NL) && is_array($NL) && !empty($NL['t'])) ? $NL['t'] : '';
$nls_all = (isset($NL) && is_array($NL) && !empty($NL['topics'])) ? $NL['topics'] : [];
if ($nls_tops && !$nls_all) {
    /* a page that does not run the handler still gets the real list */
    $nls_all = (require __DIR__ . '/../../data/newsletter.php')['topics'];
}
if ($nls_tok === '') {
    /* The same signed render time the handler checks. On /newsletter the handler has already made one;
       on every other page it has not been included, so the token is built here with the identical key
       (nl_key() hashes handler.php's own path, which is what __DIR__ resolves to below). */
    if (function_exists('nl_token')) {
        $nls_tok = nl_token();
    } else {
        $nls_now = (string) time();
        $nls_tok = $nls_now . '.' . substr(hash_hmac('sha256', $nls_now,
            hash('sha256', __DIR__ . '/handler.php|' . php_uname('n') . '|xe-newsletter')), 0, 20);
        unset($nls_now);
    }
}
$nls_done = $nls_st === 'sent';
?>
<div class="nls nls--<?= e($nls_var) ?><?= $nls_done ? ' is-done' : '' ?>" id="<?= e($nls_id) ?>-form" data-nls="<?= e($nls_id) ?>">

  <?php /* One region for both answers, and it sits ABOVE the form on purpose: a failure or an error
           is then the first thing read, rather than something under a full form the visitor has to
           scroll past. The server writes into it on a plain post and the script writes into it on a
           background post, so both routes put the same answer in the same place. Content already here
           at load is not announced by a screen reader, which is what we want after a redirect. */ ?>
  <div class="nls__live" role="status" aria-live="polite" data-nls-live>
    <?php if ($nls_done): ?>
      <div class="nls__res nls__res--ok">
        <p class="nls__rt"><span class="nls__ri" aria-hidden="true">✓</span>Your address is with us.</p>
        <p class="nls__rp"><b>You are not subscribed yet</b>, and we are not pretending otherwise: nothing was
          stored. A person adds you to the list by hand until the email service is connected, and when it is,
          you will get a confirmation link to click.
          <?php if (!empty($NL['ref'])): ?> Your reference is <span class="nls__ref"><?= e($NL['ref']) ?></span>.<?php endif; ?></p>
        <p class="nls__rp">Nothing else happens. No sales email, no sequence, no sharing.</p>
      </div>
    <?php elseif ($nls_st === 'failed'): ?>
      <div class="nls__res nls__res--bad">
        <p class="nls__rt"><span class="nls__ri" aria-hidden="true">!</span>Your address did not reach our inbox.</p>
        <p class="nls__rp">The site could not send the message just now, so nothing was lost on your side — it
          simply did not arrive. Your address is still in the form below. Send it to us directly instead, or try again.</p>
        <p class="nls__ract">
          <a class="btn btn--out nls__mailto" href="<?= e($NL['mailto'] ?? '') ?>">Email it to us<span class="i" aria-hidden="true">›</span></a>
          <span class="nls__rref">Reference <?= e($NL['ref'] ?? '') ?></span>
        </p>
      </div>
    <?php endif; ?>
  </div>

  <form class="nls__f" method="post" action="<?= e(xe_url('newsletter.php')) ?>#<?= e($nls_id) ?>-form"<?= $nls_done ? ' hidden' : '' ?>>
    <?php if ($nls_head !== ''): ?>
      <p class="nls__h"><?= e($nls_head) ?></p>
    <?php endif; ?>

    <div class="nls__row">
      <div class="nls__field">
        <label class="nls__lbl" for="<?= e($nls_id) ?>-email"><?= e($nls_lbl) ?></label>
        <input class="nls__in" type="email" id="<?= e($nls_id) ?>-email" name="email"
               value="<?= e($nls_val) ?>" placeholder="name@company.com"
               autocomplete="email" inputmode="email" spellcheck="false" maxlength="190" required
               aria-describedby="<?= e($nls_id) ?>-note"
               <?= isset($nls_err['email']) ? ' aria-invalid="true" autofocus' : '' ?>>
      </div>
      <button class="btn btn--ink nls__go" type="submit"><?= e($nls_cta) ?><span class="i" aria-hidden="true">›</span></button>
    </div>

    <p class="nls__err" id="<?= e($nls_id) ?>-err"<?= isset($nls_err['email']) ? '' : ' hidden' ?>><?= e($nls_err['email'] ?? '') ?></p>

    <?php if (isset($nls_err['form'])): ?>
      <p class="nls__err nls__err--form"><?= e($nls_err['form']) ?></p>
    <?php endif; ?>

    <?php if ($nls_tops && $nls_all): ?>
      <fieldset class="nls__topics">
        <legend class="nls__leg">What would you like more of? <span>Optional</span></legend>
        <ul class="nls__tl">
          <?php foreach ($nls_all as $nls_k => $nls_name): ?>
            <li>
              <input class="nls__cb" type="checkbox" id="<?= e($nls_id . '-t-' . $nls_k) ?>" name="topic[]" value="<?= e($nls_k) ?>"<?= in_array($nls_k, $nls_sel, true) ? ' checked' : '' ?>>
              <label class="nls__tlab" for="<?= e($nls_id . '-t-' . $nls_k) ?>"><span class="nls__box" aria-hidden="true"></span><?= e($nls_name) ?></label>
            </li>
          <?php endforeach; ?>
        </ul>
        <p class="nls__tnote">These tell us what to write. They do not split the list into different sends today.</p>
      </fieldset>
    <?php endif; ?>

    <p class="nls__note" id="<?= e($nls_id) ?>-note">
      <?php if ($nls_var === 'inline'): ?>
        <!-- PLACEHOLDER: confirm the email service and the confirmation email before launch, then rewrite this note. -->
        Nothing is stored yet — this emails your address to us. Confirmed opt-in is how it will work.
        <a class="nls__a" href="<?= e(xe_url('newsletter.php')) ?>#subscribe">What happens on submit</a>
      <?php else: ?>
        <!-- PLACEHOLDER: confirm the email service and the confirmation email before launch, then rewrite this note. -->
        <b>What pressing subscribe does today:</b> it emails your address to our inbox. Nothing is written
        to a database, no confirmation email is sent yet, and you are not subscribed. Once the email
        service is connected, this form will send you a confirmation link and you will be on the list
        only after you click it.
      <?php endif; ?>
    </p>

    <p class="nls__legal">
      We never sell or share your address, and there is no tracking pixel in the issue.
      <a class="nls__a" href="<?= e(xe_url('legal/privacy.php')) ?>">Privacy Notice</a>
    </p>

    <?php /* the honeypot: a field no person sees and no assistive technology reaches. A filled one is
             answered with the same success a person gets, and nothing is sent. */ ?>
    <div class="nls__hp" aria-hidden="true">
      <label for="<?= e($nls_id) ?>-website">Company website — leave this empty</label>
      <input id="<?= e($nls_id) ?>-website" name="website" type="text" tabindex="-1" autocomplete="off">
    </div>

    <input type="hidden" name="nl" value="1">
    <input type="hidden" name="inst" value="<?= e($nls_id) ?>">
    <input type="hidden" name="source" value="<?= e($nls_src) ?>">
    <input type="hidden" name="t" value="<?= e($nls_tok) ?>">
    <input type="hidden" name="js" value="0" data-nls-js>
  </form>

</div>
