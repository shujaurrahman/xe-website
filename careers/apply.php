<?php
/**
 * Apply — the application form, one level down from the root, so $BASE is '../'.
 * Reached at /careers/apply, and at /careers/apply?role=<slug> from any role on /careers.
 *
 * The submission mechanism is the one contact.php already uses: validate, compose one email to
 * $SITE['company']['email'] with Reply-To set to the applicant, send it with mail(), then
 * Post/Redirect/Get to ?sent=1. The only addition is a multipart/mixed body so the CV rides along
 * as a real attachment. Nothing is written to disk and nothing is stored on this website. All of
 * that is in partials/careers/apply-handler.php, included before any output because it may redirect.
 *
 * Field, label, error and alert styling mirrors assets/css/contact.css deliberately: same field
 * heights, same focus ring, same error dot, same dark send block, under .apl-* names in
 * assets/css/careers-apply.css. assets/js/careers-apply.js is an enhancement only — the form is a
 * plain POST with server-side validation and works with JavaScript off.
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

/* roles grouped by practice for the <select>, in the same order /careers lists them */
$apl_by_g = [];
foreach (car_roles() as $apl_slug => $apl_r) { $apl_by_g[$apl_r['discipline']][$apl_slug] = $apl_r; }

$apl_fe = fn (string $f): string => isset($apl_err[$f]) ? ' aria-invalid="true" aria-describedby="apl-e-' . $f . '"' : '';
$apl_labels = [
    'form' => 'Form', 'name' => 'Name', 'email' => 'Email', 'phone' => 'Phone', 'role' => 'Role',
    'portfolio' => 'Link to your work', 'location' => 'Where you are', 'notice' => 'Notice period',
    'why' => 'Why us', 'cv' => 'CV',
];

$page = [
    'key'   => 'careers',
    'title' => $APL_ROLE ? 'Apply — ' . $APL_ROLE['title'] : 'Apply',
    'desc'  => $APL_ROLE
        ? 'Apply for ' . $APL_ROLE['title'] . ' at Xterra Edze. One form, read by a person in the practice you applied to.'
        : 'Apply to Xterra Edze. One form, read by a person in the practice you applied to, with a reply either way.',
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
       'lead'    => 'Ten minutes, honestly answered, beats a polished template. Tell us what you have made and what you want to make next.',
       'meta'    => ['No account to create', 'Target: a reply in 5 working days', 'Adjustments on request']];

include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/nav.php';
?>

<!-- The shipped HTML is the finished state. The form is a plain multipart POST answered by
     partials/careers/apply-handler.php; assets/js/careers-apply.js only adds a counter, inline
     checks, the file-name readout and focus handling. -->

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
            <?php if ($APL['cv']): ?>Your CV came through with it. <?php endif; ?>
            If anything changes before we reply, write to
            <a href="mailto:<?= e($SITE['company']['email']) ?>"><?= e($SITE['company']['email']) ?></a><?= $APL['ref'] ? ' and quote the reference' : '' ?>.
          </p>
        </div>
        <ol class="apl-next">
          <li><span class="apl-next__n">01</span><b>A person reads it.</b><span>The lead for the practice you applied to, not a keyword filter and not an agency.</span></li>
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
          <!-- PLACEHOLDER: confirm where applications should go and that the live host can send mail, before launch -->
          <div class="apl-alert apl-alert--fail" role="alert" tabindex="-1" data-apl-focus>
            <span class="apl-alert__ico" aria-hidden="true"><?= xt_icon('alert', ['size' => 20]) ?></span>
            <div class="apl-alert__b">
              <p class="apl-alert__t">We could not send your application from this page.</p>
              <p class="apl-alert__p">Nothing you typed is lost — it is still in the form below. The button opens your email app with the same application written out, ready to send to <?= e($SITE['company']['email']) ?>.
                <?php if ($APL['cv']): ?><b>Your CV cannot travel that way, so attach <?= e($APL['cv']['name']) ?> to that email yourself.</b><?php endif; ?></p>
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
              <?php if ($APL['cv_lost']): ?>
                <p class="apl-alert__p">Your browser cannot re-attach a file after a page reload, so the CV you chose was not kept. Attach it again before you send.</p>
              <?php endif; ?>
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
          <fieldset class="apl-set" aria-describedby="apl-set1-d">
            <legend class="apl-set__lg"><span class="apl-set__n">01</span>About you</legend>
            <p class="apl-set__d" id="apl-set1-d">So we know who to reply to. Every field marked * is required.</p>
            <div class="apl-fields">
              <div class="apl-field<?= isset($apl_err['name']) ? ' is-bad' : '' ?>">
                <label class="apl-label" for="apl-name">Full name <span aria-hidden="true">*</span></label>
                <input class="apl-input" id="apl-name" name="name" type="text" autocomplete="name" maxlength="120" required value="<?= e($apl_v['name']) ?>"<?= $apl_fe('name') ?>>
                <?php if (isset($apl_err['name'])): ?><p class="apl-err" id="apl-e-name"><?= e($apl_err['name']) ?></p><?php endif; ?>
              </div>
              <div class="apl-field<?= isset($apl_err['email']) ? ' is-bad' : '' ?>">
                <label class="apl-label" for="apl-email">Email <span aria-hidden="true">*</span></label>
                <input class="apl-input" id="apl-email" name="email" type="email" autocomplete="email" inputmode="email" maxlength="190" required value="<?= e($apl_v['email']) ?>"<?= $apl_fe('email') ?>>
                <?php if (isset($apl_err['email'])): ?><p class="apl-err" id="apl-e-email"><?= e($apl_err['email']) ?></p><?php endif; ?>
              </div>
              <div class="apl-field<?= isset($apl_err['phone']) ? ' is-bad' : '' ?>">
                <label class="apl-label" for="apl-phone">Phone <span aria-hidden="true">*</span> <span class="apl-opt">With the country code</span></label>
                <input class="apl-input" id="apl-phone" name="phone" type="tel" autocomplete="tel" maxlength="40" required value="<?= e($apl_v['phone']) ?>"<?= $apl_fe('phone') ?>>
                <?php if (isset($apl_err['phone'])): ?><p class="apl-err" id="apl-e-phone"><?= e($apl_err['phone']) ?></p><?php endif; ?>
              </div>
              <div class="apl-field<?= isset($apl_err['location']) ? ' is-bad' : '' ?>">
                <label class="apl-label" for="apl-location">Where you are <span aria-hidden="true">*</span> <span class="apl-opt">City is enough</span></label>
                <input class="apl-input" id="apl-location" name="location" type="text" autocomplete="address-level2" maxlength="120" required value="<?= e($apl_v['location']) ?>"<?= $apl_fe('location') ?>>
                <?php if (isset($apl_err['location'])): ?><p class="apl-err" id="apl-e-location"><?= e($apl_err['location']) ?></p><?php endif; ?>
              </div>
            </div>
          </fieldset>

          <!-- 02 · The role -->
          <fieldset class="apl-set" aria-describedby="apl-set2-d">
            <legend class="apl-set__lg"><span class="apl-set__n">02</span>The role</legend>
            <p class="apl-set__d" id="apl-set2-d">Apply for the closest role and mention any second one in your note. If nothing fits, a general application is a real option, not a dead letter.</p>
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
              <div class="apl-field<?= isset($apl_err['notice']) ? ' is-bad' : '' ?>" id="apl-notice-f">
                <label class="apl-label" for="apl-notice">How soon could you start? <span aria-hidden="true">*</span></label>
                <span class="apl-selw">
                  <select class="apl-input apl-select" id="apl-notice" name="notice" required<?= $apl_fe('notice') ?>>
                    <option value=""<?= $apl_v['notice'] === '' ? ' selected' : '' ?>>Choose your notice period</option>
                    <?php foreach ($APL['notices'] as $apl_nk => $apl_nl): ?>
                      <option value="<?= e($apl_nk) ?>"<?= $apl_v['notice'] === $apl_nk ? ' selected' : '' ?>><?= e($apl_nl) ?></option>
                    <?php endforeach; ?>
                  </select>
                </span>
                <?php if (isset($apl_err['notice'])): ?><p class="apl-err" id="apl-e-notice"><?= e($apl_err['notice']) ?></p><?php endif; ?>
                <p class="apl-hint">A long notice period has never been the reason we did not make an offer.</p>
              </div>
            </div>
          </fieldset>

          <!-- 03 · Your work -->
          <fieldset class="apl-set" aria-describedby="apl-set3-d">
            <legend class="apl-set__lg"><span class="apl-set__n">03</span>Your work</legend>
            <p class="apl-set__d" id="apl-set3-d">One link is required. The CV is optional — the link is what gets read first.</p>
            <div class="apl-fields apl-fields--1">
              <div class="apl-field<?= isset($apl_err['portfolio']) ? ' is-bad' : '' ?>">
                <label class="apl-label" for="apl-portfolio">Link to your work <span aria-hidden="true">*</span> <span class="apl-opt">Portfolio, repository, LinkedIn or your own site</span></label>
                <input class="apl-input" id="apl-portfolio" name="portfolio" type="url" inputmode="url" autocomplete="url" maxlength="300" required placeholder="yourname.com or linkedin.com/in/yourname" value="<?= e($apl_v['portfolio']) ?>"<?= $apl_fe('portfolio') ?>>
                <?php if (isset($apl_err['portfolio'])): ?><p class="apl-err" id="apl-e-portfolio"><?= e($apl_err['portfolio']) ?></p><?php endif; ?>
                <p class="apl-hint">If it needs a password, put the password in your note below.</p>
              </div>

              <div class="apl-field apl-field--file<?= isset($apl_err['cv']) ? ' is-bad' : '' ?>" id="apl-cv-f">
                <label class="apl-label" for="apl-cv">CV or résumé <span class="apl-opt">Optional · PDF, DOC or DOCX up to <?= e(apl_size($APL['max_cv'])) ?></span></label>
                <div class="apl-file">
                  <input class="apl-file__in" id="apl-cv" name="cv" type="file" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"<?= $apl_fe('cv') ?> data-apl-cv data-max="<?= (int) $APL['max_cv'] ?>">
                  <span class="apl-file__ui" aria-hidden="true">
                    <span class="apl-file__ico"><?= xt_icon('doc', ['size' => 20]) ?></span>
                    <span class="apl-file__txt" data-apl-cvname>Choose a file, or drop one here</span>
                  </span>
                </div>
                <?php if (isset($apl_err['cv'])): ?><p class="apl-err" id="apl-e-cv"><?= e($apl_err['cv']) ?></p><?php endif; ?>
                <p class="apl-hint">The file is attached to the email that reaches the team. It is not stored on this website.</p>
              </div>
            </div>
          </fieldset>

          <!-- 04 · Why us -->
          <fieldset class="apl-set" aria-describedby="apl-set4-d">
            <legend class="apl-set__lg"><span class="apl-set__n">04</span>Why us</legend>
            <p class="apl-set__d" id="apl-set4-d">The part we read most closely. What you have made that you are proud of, what you want to get better at, and why this team rather than another one. Plain words. No cover-letter voice.</p>
            <div class="apl-field<?= isset($apl_err['why']) ? ' is-bad' : '' ?>">
              <label class="apl-label" for="apl-why">Your note <span aria-hidden="true">*</span></label>
              <textarea class="apl-input apl-area" id="apl-why" name="why" rows="8" maxlength="2000" required aria-describedby="apl-why-n<?= isset($apl_err['why']) ? ' apl-e-why' : '' ?>" data-apl-why><?= e($apl_v['why']) ?></textarea>
              <p class="apl-count" id="apl-why-n" data-apl-count>Up to 2,000 characters. Sixty is the minimum.</p>
              <?php if (isset($apl_err['why'])): ?><p class="apl-err" id="apl-e-why"><?= e($apl_err['why']) ?></p><?php endif; ?>
            </div>
          </fieldset>

          <div class="apl-send">
            <!-- PLACEHOLDER: link "Privacy Notice" to the real page once it exists (data/site.php 'legal'). -->
            <p class="apl-consent">Sending this emails your answers, and your CV if you attached one, to <?= e($SITE['company']['email']) ?>, where the practice lead reads it. Nothing is stored on this website, nothing is added to a mailing list, and nothing is shared outside the team. Ask us to delete it at any time and we will.</p>
            <button class="btn btn--ink btn--lg apl-send__btn" type="submit" data-apl-send>Send application <span class="i" aria-hidden="true">›</span></button>
          </div>
        </form>
      </div>

      <aside class="apl-side" aria-labelledby="apl-side-t">
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
