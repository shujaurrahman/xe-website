<?php
/**
 * Apply — the application form, one level down from the root, so $BASE is '../'.
 * Reached at /careers/apply, and at /careers/apply?role=<slug> from any role on /careers.
 *
 * Seven parts rather than one wall of inputs: about you, the role, your work, your CV, your
 * experience, two questions, and consent. A rail in the column beside them lists the seven; with
 * JavaScript it tracks which part you are in and ticks the ones you have finished, and without it
 * the same rail is a set of in-page links that still work.
 *
 * The submission mechanism is the one contact.php already uses: validate, compose one email to
 * $SITE['company']['email'] with Reply-To set to the applicant, send it with mail(), then
 * Post/Redirect/Get to ?sent=1. The addition here is a multipart/mixed body, so the CV rides along
 * as a real attachment. Nothing is written to disk and nothing is stored on this website. All of
 * that is in partials/careers/apply-handler.php, included before any output because it may redirect.
 *
 * Field, label, error and alert styling mirrors assets/css/contact.css deliberately: same field
 * heights, same focus ring, same error dot, same dark send block, under .apl-* names in
 * assets/css/careers-apply.css. assets/js/careers-apply.js is an enhancement only — the form is a
 * plain multipart POST with server-side validation and works with JavaScript off.
 *
 * Variables: $SITE, $APL (the handler's state), $APL_ROLE (the role applied for, or null).
 * Locals are prefixed apl_.
 */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require_once __DIR__ . '/../partials/careers/lib.php';
require __DIR__ . '/../partials/careers/apply-handler.php';

$apl_v    = $APL['v'];
$apl_err  = $APL['errors'];
$APL_ROLE = $apl_v['role'] !== '' ? car_role($apl_v['role']) : null;
$apl_grp  = $APL_ROLE ? car_group($APL_ROLE['discipline']) : null;
$apl_types = car_data()['types'];

/* roles grouped by practice for the two <select>s, in the same order /careers lists them */
$apl_by_g = [];
foreach (car_roles() as $apl_slug => $apl_r) { $apl_by_g[$apl_r['discipline']][$apl_slug] = $apl_r; }

$apl_fe = fn (string $f): string => isset($apl_err[$f]) ? ' aria-invalid="true" aria-describedby="apl-e-' . $f . '"' : '';

/* the seven parts, so the rail and the fieldset legends can never fall out of step */
$apl_parts = [
    ['s1', 'About you',    'Who we reply to, and where you are'],
    ['s2', 'The role',     'What you are applying for'],
    ['s3', 'Your work',    'Links we can open'],
    ['s4', 'Your CV',      'One file — PDF, DOC or DOCX'],
    ['s5', 'Experience',   'Where you are in your career'],
    ['s6', 'Two questions', 'The part we read most closely'],
    ['s7', 'Consent',      'What we may do with this'],
];
/* which part each field lives in, so an error in the summary can say where to go */
$apl_labels = [
    'form' => 'Form', 'name' => 'Full name', 'email' => 'Email', 'phone' => 'Phone',
    'location' => 'Where you are', 'auth' => 'Right to work', 'role' => 'Role', 'role2' => 'Second choice',
    'portfolio' => 'Portfolio or website', 'linkedin' => 'LinkedIn', 'profile' => 'Repository or profile',
    'cv' => 'CV', 'years' => 'Years of experience', 'notice' => 'Notice period', 'start' => 'Earliest start',
    'why' => 'Why us', 'proud' => 'Work you are proud of',
];

/**
 * One text-ish field, rendered the same way every time: label, optional hint on the label, input,
 * the server's error under it. $o: type, autocomplete, inputmode, maxlength, required, opt (the
 * small grey note on the label), hint (the line under the field), placeholder, pattern.
 */
$apl_field = function (string $k, string $label, array $o = []) use ($apl_v, $apl_err, $apl_fe): void {
    $bad = isset($apl_err[$k]);
    $req = !empty($o['required']);
    echo '<div class="apl-field' . ($bad ? ' is-bad' : '') . '">';
    echo '<label class="apl-label" for="apl-' . e($k) . '">' . e($label);
    if ($req) echo ' <span aria-hidden="true">*</span>';
    if (!empty($o['opt'])) echo ' <span class="apl-opt">' . e($o['opt']) . '</span>';
    echo '</label>';
    echo '<input class="apl-input" id="apl-' . e($k) . '" name="' . e($k) . '"'
        . ' type="' . e($o['type'] ?? 'text') . '"'
        . (!empty($o['autocomplete']) ? ' autocomplete="' . e($o['autocomplete']) . '"' : '')
        . (!empty($o['inputmode']) ? ' inputmode="' . e($o['inputmode']) . '"' : '')
        . (!empty($o['maxlength']) ? ' maxlength="' . (int) $o['maxlength'] . '"' : '')
        . (!empty($o['min']) ? ' min="' . e($o['min']) . '"' : '')
        . (!empty($o['max']) ? ' max="' . e($o['max']) . '"' : '')
        . (!empty($o['placeholder']) ? ' placeholder="' . e($o['placeholder']) . '"' : '')
        . ($req ? ' required' : '')
        . ' value="' . e($apl_v[$k]) . '"' . $apl_fe($k) . '>';
    if ($bad) echo '<p class="apl-err" id="apl-e-' . e($k) . '">' . e($apl_err[$k]) . '</p>';
    if (!empty($o['hint'])) echo '<p class="apl-hint">' . $o['hint'] . '</p>';
    echo '</div>';
};

/** One <select> over an option list from the handler. */
$apl_select = function (string $k, string $label, array $opts, string $blank, array $o = []) use ($apl_v, $apl_err, $apl_fe): void {
    $bad = isset($apl_err[$k]);
    $req = !empty($o['required']);
    echo '<div class="apl-field' . ($bad ? ' is-bad' : '') . '" id="apl-' . e($k) . '-f">';
    echo '<label class="apl-label" for="apl-' . e($k) . '">' . e($label);
    if ($req) echo ' <span aria-hidden="true">*</span>';
    if (!empty($o['opt'])) echo ' <span class="apl-opt">' . e($o['opt']) . '</span>';
    echo '</label><span class="apl-selw"><select class="apl-input apl-select" id="apl-' . e($k) . '" name="' . e($k) . '"'
        . ($req ? ' required' : '') . $apl_fe($k) . '>';
    echo '<option value=""' . ($apl_v[$k] === '' ? ' selected' : '') . '>' . e($blank) . '</option>';
    foreach ($opts as $ok => $ol) {
        echo '<option value="' . e((string) $ok) . '"' . ($apl_v[$k] === (string) $ok ? ' selected' : '') . '>' . e($ol) . '</option>';
    }
    echo '</select></span>';
    if ($bad) echo '<p class="apl-err" id="apl-e-' . e($k) . '">' . e($apl_err[$k]) . '</p>';
    if (!empty($o['hint'])) echo '<p class="apl-hint">' . $o['hint'] . '</p>';
    echo '</div>';
};

$page = [
    'key'   => 'careers',
    'title' => $APL_ROLE ? 'Apply — ' . $APL_ROLE['title'] : 'Apply',
    'desc'  => $APL_ROLE
        ? 'Apply for ' . $APL_ROLE['title'] . ' at Xterra Edze. Seven short parts, a CV, and two questions — read by a person in the practice you applied to.'
        : 'Apply to Xterra Edze. Seven short parts, a CV, and two questions — read by a person in the practice you applied to, with a reply either way.',
    'css'   => ['assets/css/brand/hub.css', 'assets/css/tech/kit.css', 'assets/css/careers-apply.css'],
    'js'    => ['assets/js/brand/hub.js', 'assets/js/careers-apply.js'],
];

$hero = $APL['state'] === 'sent'
    ? ['eyebrow' => 'Application received', 'title' => 'Thank you.<br><span class="g">It is with the team.</span>',
       'lead'    => 'A person in the practice you applied to reads it, and you get an answer either way.']
    : ['eyebrow' => $APL_ROLE ? 'Apply · ' . ($apl_grp['name'] ?? 'Open role') : 'Apply',
       'title'   => $APL_ROLE
            ? 'Apply for<br><span class="g">' . e($APL_ROLE['title']) . '.</span>'
            : 'One form,<br><span class="g">read by a person.</span>',
       'lead'    => 'Seven short parts, about ten minutes. Ten minutes answered honestly beats a polished template — we would rather read what you actually made than what you can format.',
       'meta'    => ['No account to create', 'CV attached, never stored here', 'Target: a reply in 5 working days', 'Adjustments on request']];

include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/nav.php';
?>

<!-- The shipped HTML is the finished state. The form is a plain multipart POST answered by
     partials/careers/apply-handler.php; assets/js/careers-apply.js only adds the counters, inline
     checks, the file readout, the progress rail's tracking and focus handling. -->

<main id="main" class="bdh apl">
<?php include __DIR__ . '/../partials/page-hero.php'; ?>

<?php if ($APL['state'] === 'sent'): ?>
  <section class="band apl-done" aria-labelledby="apl-done-t">
    <div class="wrap">
      <div class="apl-done__card">
        <span class="apl-done__tick" aria-hidden="true"><?= xt_icon('check', ['size' => 26, 'mono' => true]) ?></span>
        <div class="apl-done__main">
          <p class="lbl lbl--blue"><span class="dot"></span>Sent</p>
          <h2 class="apl-done__t" id="apl-done-t">We have your application.</h2>
          <?php if ($APL['ref']): ?>
            <p class="apl-done__ref"><span>Reference</span><b><?= e($APL['ref']) ?></b></p>
          <?php endif; ?>
          <p class="apl-done__p">
            <?php if ($APL_ROLE): ?>You applied for <b><?= e($APL_ROLE['title']) ?></b>. <?php endif; ?>
            <?php if ($APL['cv']): ?>Your CV came through attached to it. <?php endif; ?>
            If anything changes before we reply, write to
            <a href="mailto:<?= e($SITE['company']['email']) ?>"><?= e($SITE['company']['email']) ?></a><?= $APL['ref'] ? ' and quote the reference' : '' ?>.
          </p>
        </div>
        <ol class="apl-next">
          <li><span class="apl-next__n">01</span><b>A person reads it.</b><span>The lead for the practice you applied to, not a keyword filter and not a scoring model.</span></li>
          <li><span class="apl-next__n">02</span><b>You hear back either way.</b><span>Target: five working days. A yes, a no, or a question — always one of the three, always in writing.</span></li>
          <li><span class="apl-next__n">03</span><b>Then a thirty-minute call.</b><span>Your work, our work, and the pay range for the role before you spend more time on us.</span></li>
        </ol>
        <div class="apl-done__go">
          <a class="btn btn--out" href="<?= xe_url('careers.php') ?>#roles">Back to open roles <span class="i" aria-hidden="true">›</span></a>
          <a class="btn btn--ink" href="<?= xe_url('careers.php') ?>#hiring">See the hiring stages <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>
    </div>
  </section>

<?php else: ?>
  <section class="band apl-main" aria-labelledby="apl-form-t">
    <div class="wrap apl-grid">

      <div class="apl-formcol">
        <h2 class="sr" id="apl-form-t">Send an application</h2>

        <?php if ($APL['state'] === 'failed'): ?>
          <!-- PLACEHOLDER: confirm the hiring inbox, and that the live host can send mail with attachments, before launch -->
          <div class="apl-alert apl-alert--fail" role="alert" tabindex="-1" data-apl-focus>
            <span class="apl-alert__ico" aria-hidden="true"><?= xt_icon('alert', ['size' => 20]) ?></span>
            <div class="apl-alert__b">
              <p class="apl-alert__t">We could not send your application from this page.</p>
              <p class="apl-alert__p">Nothing you typed is lost — it is still in the form below. The button opens your email app with the same application written out, ready to send to <?= e($SITE['company']['email']) ?>.
                <?php if ($APL['cv']): ?><b>A CV cannot travel inside a mailto link, so attach your file to that email yourself.</b><?php endif; ?></p>
              <div class="apl-alert__go">
                <a class="btn btn--ink" href="<?= e($APL['mailto']) ?>">Email the application instead <span class="i" aria-hidden="true">›</span></a>
                <?php if ($APL['ref']): ?><span class="apl-alert__ref">Reference <?= e($APL['ref']) ?></span><?php endif; ?>
              </div>
            </div>
          </div>
        <?php elseif ($apl_err): ?>
          <div class="apl-alert" role="alert" tabindex="-1" id="apl-errs" data-apl-focus>
            <span class="apl-alert__ico" aria-hidden="true"><?= xt_icon('dot', ['size' => 20]) ?></span>
            <div class="apl-alert__b">
              <p class="apl-alert__t"><?= count($apl_err) === 1 ? 'One thing to fix before we can send this.' : count($apl_err) . ' things to fix before we can send this.' ?></p>
              <ul class="apl-alert__list">
                <?php foreach ($apl_err as $apl_f => $apl_m): ?>
                  <li><?php if ($apl_f === 'form'): ?><?= e($apl_m) ?><?php else: ?><a href="#apl-<?= e($apl_f) ?>"><?= e($apl_labels[$apl_f] ?? ucfirst($apl_f)) ?>: <?= e($apl_m) ?></a><?php endif; ?></li>
                <?php endforeach; ?>
              </ul>
              <p class="apl-alert__p">Everything else you typed is still below, exactly as you left it.</p>
            </div>
          </div>
        <?php endif; ?>

        <?php if ($APL['role_gone'] !== ''): ?>
          <p class="apl-note">The role in the link you followed is not open any more, so nothing is pre-selected. Pick the closest one below, or send a general application.</p>
        <?php endif; ?>

        <form class="apl-form" action="<?= e(xe_url('careers/apply.php')) ?>" method="post" enctype="multipart/form-data" novalidate data-apl-form data-careers="<?= e(xe_url('careers.php')) ?>">
          <input type="hidden" name="t" value="<?= e($APL['t']) ?>">
          <input type="hidden" name="MAX_FILE_SIZE" value="<?= (int) $APL['max_cv'] ?>">
          <div class="apl-hp" aria-hidden="true">
            <label for="apl-website">Website (leave this empty)</label>
            <input type="text" id="apl-website" name="website" tabindex="-1" autocomplete="off">
          </div>

          <!-- 01 · About you -->
          <fieldset class="apl-set" id="apl-s1" aria-describedby="apl-s1-d" data-apl-part="s1">
            <legend class="apl-set__lg"><span class="apl-set__n">01</span>About you</legend>
            <p class="apl-set__d" id="apl-s1-d">So we know who to reply to, and where you are. Every field marked * is required.</p>
            <div class="apl-fields">
              <?php $apl_field('name', 'Full name', ['required' => true, 'autocomplete' => 'name', 'maxlength' => 120]); ?>
              <?php $apl_field('email', 'Email', ['required' => true, 'type' => 'email', 'autocomplete' => 'email', 'inputmode' => 'email', 'maxlength' => 190]); ?>
              <?php $apl_field('phone', 'Phone', ['required' => true, 'type' => 'tel', 'autocomplete' => 'tel', 'maxlength' => 40, 'opt' => 'With the country code']); ?>
              <?php $apl_field('location', 'Where you are', ['required' => true, 'autocomplete' => 'address-level2', 'maxlength' => 120, 'opt' => 'City is enough']); ?>
            </div>
            <div class="apl-fields apl-fields--1">
              <!-- PLACEHOLDER: confirm the employing entities, and whether any role can be sponsored, before launch -->
              <?php $apl_select('auth', 'Your right to work in India', $APL['auth'], 'Choose the line that fits', [
                  'required' => true,
                  'hint' => 'Every role listed is employed in India. We are not able to sponsor a visa at the moment, and we would rather you knew that now than at stage four.',
              ]); ?>
            </div>
          </fieldset>

          <!-- 02 · The role -->
          <fieldset class="apl-set" id="apl-s2" aria-describedby="apl-s2-d" data-apl-part="s2">
            <legend class="apl-set__lg"><span class="apl-set__n">02</span>The role</legend>
            <p class="apl-set__d" id="apl-s2-d">Apply for the closest role, and name a second one if there genuinely is one. If nothing fits, a general application is a real option here, not a dead letter.</p>
            <div class="apl-fields">
              <div class="apl-field<?= isset($apl_err['role']) ? ' is-bad' : '' ?>" id="apl-role-f">
                <label class="apl-label" for="apl-role">Role you are applying for</label>
                <span class="apl-selw">
                  <select class="apl-input apl-select" id="apl-role" name="role" data-apl-role<?= $apl_fe('role') ?>>
                    <option value=""<?= $apl_v['role'] === '' ? ' selected' : '' ?>>General application</option>
                    <?php foreach (car_groups() as $apl_gk => $apl_g): if (empty($apl_by_g[$apl_gk])) continue; ?>
                      <optgroup label="<?= e($apl_g['name']) ?>">
                        <?php foreach ($apl_by_g[$apl_gk] as $apl_slug => $apl_r): ?>
                          <option value="<?= e($apl_slug) ?>"<?= $apl_v['role'] === $apl_slug ? ' selected' : '' ?>><?= e($apl_r['title']) ?></option>
                        <?php endforeach; ?>
                      </optgroup>
                    <?php endforeach; ?>
                  </select>
                </span>
                <?php if (isset($apl_err['role'])): ?><p class="apl-err" id="apl-e-role"><?= e($apl_err['role']) ?></p><?php endif; ?>
                <p class="apl-hint" data-apl-rolehint<?= $APL_ROLE ? '' : ' hidden' ?>>
                  <a href="<?= xe_url('careers.php') ?><?= $APL_ROLE ? '?role=' . e(rawurlencode($APL_ROLE['slug'])) . '#role-' . e($APL_ROLE['slug']) : '#roles' ?>" data-apl-rolelink>Read the full listing again <span class="i" aria-hidden="true">›</span></a>
                </p>
              </div>
              <div class="apl-field<?= isset($apl_err['role2']) ? ' is-bad' : '' ?>" id="apl-role2-f">
                <label class="apl-label" for="apl-role2">Second choice <span class="apl-opt">Optional</span></label>
                <span class="apl-selw">
                  <select class="apl-input apl-select" id="apl-role2" name="role2"<?= $apl_fe('role2') ?>>
                    <option value=""<?= $apl_v['role2'] === '' ? ' selected' : '' ?>>No second choice</option>
                    <?php foreach (car_groups() as $apl_gk => $apl_g): if (empty($apl_by_g[$apl_gk])) continue; ?>
                      <optgroup label="<?= e($apl_g['name']) ?>">
                        <?php foreach ($apl_by_g[$apl_gk] as $apl_slug => $apl_r): ?>
                          <option value="<?= e($apl_slug) ?>"<?= $apl_v['role2'] === $apl_slug ? ' selected' : '' ?>><?= e($apl_r['title']) ?></option>
                        <?php endforeach; ?>
                      </optgroup>
                    <?php endforeach; ?>
                  </select>
                </span>
                <?php if (isset($apl_err['role2'])): ?><p class="apl-err" id="apl-e-role2"><?= e($apl_err['role2']) ?></p><?php endif; ?>
                <p class="apl-hint">One considered application beats five copies of the same one. A second choice costs you nothing and is read by both leads.</p>
              </div>
            </div>
          </fieldset>

          <!-- 03 · Your work -->
          <fieldset class="apl-set" id="apl-s3" aria-describedby="apl-s3-d" data-apl-part="s3">
            <legend class="apl-set__lg"><span class="apl-set__n">03</span>Your work</legend>
            <p class="apl-set__d" id="apl-s3-d">At least one link, and as many of the three as apply. This is what the reader opens first — before your note, and often before your CV.</p>
            <div class="apl-fields apl-fields--1">
              <?php $apl_field('portfolio', 'Portfolio or website', [
                  'type' => 'url', 'inputmode' => 'url', 'autocomplete' => 'url', 'maxlength' => 300,
                  'opt' => 'Your own site, a case-study deck or a public folder',
                  'placeholder' => 'yourname.com',
                  'hint' => 'If it needs a password, put the password in your note in part six.',
              ]); ?>
              <div class="apl-fields apl-fields--2in1">
                <?php $apl_field('linkedin', 'LinkedIn', [
                    'type' => 'url', 'inputmode' => 'url', 'maxlength' => 300, 'opt' => 'Optional',
                    'placeholder' => 'linkedin.com/in/yourname',
                ]); ?>
                <?php $apl_field('profile', 'Repository or profile', [
                    'type' => 'url', 'inputmode' => 'url', 'maxlength' => 300, 'opt' => 'GitHub, GitLab, Behance, Dribbble, Substack',
                    'placeholder' => 'github.com/yourname',
                ]); ?>
              </div>
            </div>
          </fieldset>

          <!-- 04 · Your CV -->
          <fieldset class="apl-set apl-set--cv" id="apl-s4" aria-describedby="apl-s4-d" data-apl-part="s4">
            <legend class="apl-set__lg"><span class="apl-set__n">04</span>Your CV</legend>
            <p class="apl-set__d" id="apl-s4-d">One file, attached to the email that reaches the team. It is never written to this website, never published, and never given a name you chose.</p>

            <?php if ($APL['cv_reattach']): ?>
              <p class="apl-warn"><span class="apl-warn__ico" aria-hidden="true"><?= xt_icon('alert', ['size' => 17]) ?></span>
                Your CV arrived, but a browser cannot put a chosen file back into a form after a page reload, so it was dropped along with the send. Everything else you typed is still here. Attach the file once more and send again.</p>
            <?php endif; ?>

            <div class="apl-field apl-field--file<?= isset($apl_err['cv']) ? ' is-bad' : '' ?>" id="apl-cv-f">
              <label class="apl-label" for="apl-cv">CV or résumé <span aria-hidden="true">*</span> <span class="apl-opt">PDF, DOC or DOCX, up to <?= e(apl_size($APL['max_cv'])) ?></span></label>
              <div class="apl-file">
                <input class="apl-file__in" id="apl-cv" name="cv" type="file" required accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"<?= $apl_fe('cv') ?> data-apl-cv data-max="<?= (int) $APL['max_cv'] ?>">
                <span class="apl-file__ui" aria-hidden="true">
                  <span class="apl-file__ico"><?= xt_icon('doc', ['size' => 20]) ?></span>
                  <span class="apl-file__txt" data-apl-cvname>Choose a file, or drop one here</span>
                </span>
              </div>
              <?php if (isset($apl_err['cv'])): ?><p class="apl-err" id="apl-e-cv"><?= e($apl_err['cv']) ?></p><?php endif; ?>
            </div>

            <ul class="apl-cvfacts">
              <li><span class="apl-cvfacts__i" aria-hidden="true"><?= xt_icon('lock', ['size' => 16]) ?></span><span><b>Not stored here.</b> This site has no database and no file store. The file is read once, attached to the email, and gone.</span></li>
              <li><span class="apl-cvfacts__i" aria-hidden="true"><?= xt_icon('scan', ['size' => 16]) ?></span><span><b>Checked, not trusted.</b> We read the file's own bytes to confirm it really is a PDF or a Word document, whatever it is named.</span></li>
              <li><span class="apl-cvfacts__i" aria-hidden="true"><?= xt_icon('doc', ['size' => 16]) ?></span><span><b>Renamed.</b> It is attached under our reference and your name, so the name your computer used never travels.</span></li>
            </ul>
          </fieldset>

          <!-- 05 · Experience -->
          <fieldset class="apl-set" id="apl-s5" aria-describedby="apl-s5-d" data-apl-part="s5">
            <legend class="apl-set__lg"><span class="apl-set__n">05</span>Experience</legend>
            <p class="apl-set__d" id="apl-s5-d">Enough to place you, no more. We do not screen on years, and we do not use what you earn now to set an offer — the last two fields are so the first call starts in the right place.</p>
            <div class="apl-fields">
              <?php $apl_select('years', 'Years doing this work', $APL['years'], 'Choose a range', ['required' => true]); ?>
              <?php $apl_select('notice', 'How soon could you start?', $APL['notices'], 'Choose your notice period', [
                  'required' => true,
                  'hint' => 'A long notice period has never been the reason we did not make an offer.',
              ]); ?>
              <?php $apl_field('title_now', 'Current or most recent title', ['maxlength' => 120, 'opt' => 'Optional', 'autocomplete' => 'organization-title']); ?>
              <?php $apl_field('company_now', 'Current or most recent company', ['maxlength' => 120, 'opt' => 'Optional', 'autocomplete' => 'organization']); ?>
              <?php $apl_field('start', 'Earliest start date', [
                  'type' => 'date', 'opt' => 'Optional',
                  'min' => date('Y-m-d'), 'max' => date('Y-m-d', strtotime('+2 years')),
              ]); ?>
              <?php $apl_field('comp', 'Expected compensation', [
                  'maxlength' => 80, 'opt' => 'Optional',
                  'placeholder' => 'A number or a range, in whatever unit you think in',
                  'hint' => 'Leave it blank if you would rather hear our range first. We state it on the intro call either way.',
              ]); ?>
            </div>
          </fieldset>

          <!-- 06 · Two questions -->
          <fieldset class="apl-set" id="apl-s6" aria-describedby="apl-s6-d" data-apl-part="s6">
            <legend class="apl-set__lg"><span class="apl-set__n">06</span>Two questions</legend>
            <p class="apl-set__d" id="apl-s6-d">The part we read most closely, and the part a template loses on. Plain words, specific examples, no cover-letter voice.</p>

            <div class="apl-field<?= isset($apl_err['why']) ? ' is-bad' : '' ?>">
              <label class="apl-label" for="apl-why">Why this team, rather than another one? <span aria-hidden="true">*</span></label>
              <textarea class="apl-input apl-area" id="apl-why" name="why" rows="7" maxlength="2000" required aria-describedby="apl-why-n<?= isset($apl_err['why']) ? ' apl-e-why' : '' ?>" data-apl-why data-min="60"><?= e($apl_v['why']) ?></textarea>
              <p class="apl-count" id="apl-why-n" data-apl-count="why">Up to 2,000 characters. Sixty is the minimum.</p>
              <?php if (isset($apl_err['why'])): ?><p class="apl-err" id="apl-e-why"><?= e($apl_err['why']) ?></p><?php endif; ?>
            </div>

            <div class="apl-field<?= isset($apl_err['proud']) ? ' is-bad' : '' ?>">
              <label class="apl-label" for="apl-proud">One piece of work you are proud of — and what your own part in it was <span aria-hidden="true">*</span></label>
              <textarea class="apl-input apl-area" id="apl-proud" name="proud" rows="7" maxlength="1500" required aria-describedby="apl-proud-n<?= isset($apl_err['proud']) ? ' apl-e-proud' : '' ?>" data-apl-why data-min="60"><?= e($apl_v['proud']) ?></textarea>
              <p class="apl-count" id="apl-proud-n" data-apl-count="proud">Up to 1,500 characters. Sixty is the minimum.</p>
              <?php if (isset($apl_err['proud'])): ?><p class="apl-err" id="apl-e-proud"><?= e($apl_err['proud']) ?></p><?php endif; ?>
              <p class="apl-hint">Team work is welcome — name the decisions that were yours. "I did all of it" is rarely true and never the strongest answer.</p>
            </div>
          </fieldset>

          <!-- 07 · Consent -->
          <fieldset class="apl-set" id="apl-s7" aria-describedby="apl-s7-d" data-apl-part="s7">
            <legend class="apl-set__lg"><span class="apl-set__n">07</span>Consent</legend>
            <p class="apl-set__d" id="apl-s7-d">One box, and it is a genuine choice — leaving it unticked does not weaken your application for the role you are applying for.</p>
            <label class="apl-check" for="apl-keep">
              <input class="apl-check__in" id="apl-keep" name="keep" type="checkbox" value="1"<?= $apl_v['keep'] === '1' ? ' checked' : '' ?>>
              <span class="apl-check__box" aria-hidden="true"></span>
              <span class="apl-check__b">
                <b>Keep me on file for future roles.</b>
                <span>If this one is not right, we may come back to you when something closer opens. Without this tick we consider you only for the role above and go no further.</span>
              </span>
            </label>
            <!-- PLACEHOLDER: confirm the retention period for applications with counsel before launch -->
            <p class="apl-legal">What happens to what you send, how long it is kept and how to have it deleted are set out in our <a href="<?= e(xe_url('legal/privacy.php')) ?>">privacy notice</a>. You can withdraw this consent, or ask us to delete the whole application, at any time by writing to <a href="mailto:<?= e($SITE['company']['email']) ?>"><?= e($SITE['company']['email']) ?></a>, and we will confirm in writing when it is done.</p>
          </fieldset>

          <div class="apl-send">
            <div class="apl-send__b">
              <p class="apl-send__k">What pressing send does</p>
              <p class="apl-consent">It emails your answers and your CV to <?= e($SITE['company']['email']) ?>, with Reply-To set to your address, and shows you a reference. Nothing is written to this website, nothing is added to a mailing list, and nothing is shared outside the team. If the email cannot be sent, this page says so and hands the application back to you rather than pretending.</p>
            </div>
            <button class="btn btn--ink btn--lg apl-send__btn" type="submit" data-apl-send>Send application <span class="i" aria-hidden="true">›</span></button>
          </div>
        </form>
      </div>

      <aside class="apl-side" aria-labelledby="apl-side-t">
        <nav class="apl-rail" aria-labelledby="apl-rail-t" data-apl-rail>
          <p class="apl-k" id="apl-rail-t">The seven parts</p>
          <ol class="apl-rail__list">
            <?php foreach ($apl_parts as $apl_i => $apl_pt): ?>
              <li class="apl-rail__i">
                <a class="apl-rail__a" href="#apl-<?= e($apl_pt[0]) ?>" data-apl-jump="<?= e($apl_pt[0]) ?>">
                  <span class="apl-rail__n" aria-hidden="true"><?= str_pad((string) ($apl_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                  <span class="apl-rail__t"><?= e($apl_pt[1]) ?></span>
                  <span class="apl-rail__d"><?= e($apl_pt[2]) ?></span>
                </a>
              </li>
            <?php endforeach; ?>
          </ol>
          <p class="apl-rail__note">About ten minutes end to end. Nothing is saved as you type, so finish it in one sitting.</p>
        </nav>

        <div class="apl-card">
          <div class="apl-card__head">
            <h2 class="apl-card__t" id="apl-side-t"><?= $APL_ROLE ? 'The role' : 'Before you write' ?></h2>
          </div>
          <?php if ($APL_ROLE): ?>
            <p class="apl-card__role"><?= e($APL_ROLE['title']) ?></p>
            <ul class="apl-card__meta" role="list">
              <li><span>Practice</span><b><?= e($apl_grp['name'] ?? '') ?></b></li>
              <li><span>Based</span><b><?= e(car_loc_line($APL_ROLE)) ?></b></li>
              <li><span>Type</span><b><?= e($apl_types[$APL_ROLE['type']] ?? '—') ?></b></li>
              <li><span>Experience</span><b><?= e($APL_ROLE['experience']) ?></b></li>
            </ul>
            <p class="apl-card__p"><?= e($APL_ROLE['does']) ?></p>
            <a class="tl" href="<?= xe_url('careers.php') ?>?role=<?= e(rawurlencode($APL_ROLE['slug'])) ?>#role-<?= e($APL_ROLE['slug']) ?>">Read the full listing <span class="i" aria-hidden="true">›</span></a>
          <?php else: ?>
            <ul class="apl-card__tips" role="list">
              <li>Lead with the work, not the summary of the work.</li>
              <li>Name your own part on team projects.</li>
              <li>Say what you want to get better at next.</li>
              <li>One application for the closest role beats five.</li>
            </ul>
            <a class="tl" href="<?= xe_url('careers.php') ?>#bar">What we look for <span class="i" aria-hidden="true">›</span></a>
          <?php endif; ?>
        </div>

        <div class="apl-aid">
          <p class="apl-k">Need an adjustment?</p>
          <p class="apl-aid__p">Extra time, written questions ahead of a call, captions, a different format — tell us and we will arrange it. Asking never counts against you and you do not have to explain why.</p>
          <a class="apl-aid__mail" href="mailto:<?= e($SITE['company']['email']) ?>?subject=<?= e(rawurlencode('Adjustment for an application')) ?>"><?= e($SITE['company']['email']) ?></a>
          <ul class="apl-aid__offices" role="list">
            <?php foreach ($SITE['company']['studios'] as $apl_s): ?>
              <li><b><?= e($apl_s['city']) ?></b><span><?= e(implode(', ', $apl_s['lines'])) ?></span></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </aside>

    </div>
  </section>
<?php endif; ?>

<?php include __DIR__ . '/../partials/careers/apply-next.php'; ?>
<?php include __DIR__ . '/../partials/cta.php'; ?>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
