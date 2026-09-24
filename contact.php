<?php
/**
 * Contact — the brief. Arrives pre-filled from any service catalogue (partials/services/catalogue.php):
 *   contact?service[]=<page>:<offer>&service[]=…&package=<key>&from=<page key>
 *   or the same fields POSTed with intent=select (what the catalogue does, so a long brief
 *   stays out of the URL); a single "Enquire" posts only=<page>:<offer>, a package card
 *   posts pick_package=<key>. Both routes pre-fill; neither sends anything.
 * The query and the POST are handled in partials/contact/handler.php (validation, the lead email,
 * Post/Redirect/Get, the honest failure state). Styles: assets/css/contact.css (.ct-*);
 * behaviour: assets/js/contact.js (live brief, service search, counters, error focus).
 * Every link is written through xe_url(), so no URL shows .php.
 */
$BASE = '';
require 'partials/init.php';
require_once 'partials/services/lib.php';
require_once 'partials/tech/kit.php';
require 'partials/contact/handler.php';

$ct_v    = $CT['v'];
$ct_err  = $CT['errors'];
$ct_pks  = svc_packages();
$ct_from = $ct_v['from'] !== '' ? svc_page_meta($ct_v['from']) : null;
if ($ct_from && empty($ct_from['url'])) $ct_from = null;

$page = [
    'key'   => 'contact',
    'title' => 'Contact',
    'desc'  => 'Tell us what you are building and we will tell you straight whether we are the right team for it.',
    'css'   => ['assets/css/tech/kit.css', 'assets/css/contact.css'],
    'js'    => ['assets/js/contact.js'],
];

/* PLACEHOLDER: confirm the response times quoted on this page ("one working day", "five working days") before launch. */
$ct_app  = $CT['app'];
$ct_apps = $CT['state'] === 'sent' && $ct_v['from'] === 'careers';
if ($CT['state'] === 'sent') {
    $hero = $ct_apps
        ? ['eyebrow' => 'Application received', 'title' => 'Thank you.<br><span class="g">Your application is with us.</span>',
           'lead' => 'The hiring lead for the role reads every application and aims to reply within five working days.']
        : ['eyebrow' => 'Brief received', 'title' => 'Thank you.<br><span class="g">Your brief is with us.</span>',
           'lead' => 'A named lead reads every brief and aims to reply within one working day.'];
} elseif ($ct_app) {
    $hero = ['eyebrow' => 'Careers · Apply', 'title' => 'Apply for<br><span class="g">' . e($ct_app['role']) . '.</span>',
             'lead' => 'Tell us who you are and send a link to your work. The hiring lead for the role reads every application.',
             'meta' => ['Reference ' . $ct_app['id'], 'Reply aimed within five working days', 'No recruiters, please']];
} else {
    $hero = ['eyebrow' => 'Contact', 'title' => 'Thirty minutes,<br><span class="g">and a straight answer.</span>',
             'lead' => 'Tell us what you are building and we will tell you straight whether we are the right team for it.',
             'meta' => ['Reply aimed within one working day', 'NDA on request', 'New Delhi · Ludhiana']];
}

/* ---- the services picker: every discipline, grouped by page and category ---- */
$ct_sel = array_flip($ct_v['services']);
$ct_chip = function (string $id, string $name, string $meta, string $search) use ($ct_sel): array {
    return ['id' => $id, 'name' => $name, 'meta' => $meta, 'search' => strtolower($name . ' ' . $search), 'on' => isset($ct_sel[$id])];
};
$ct_groups = [];
foreach ($SITE['disciplines'] as $ct_d) {
    $ct_pages = array_filter(svc_all(), fn ($ct_p) => ($ct_p['discipline'] ?? '') === $ct_d['slug']);
    $ct_g = ['d' => $ct_d, 'main' => [], 'more' => []];
    if ($ct_pages) {
        /* capability pages in the order data/site.php lists them, then anything else */
        $ct_order = array_values(array_filter(array_map(fn ($ct_c) => $ct_c[2] ?? null, $ct_d['caps'])));
        uksort($ct_pages, function ($a, $b) use ($ct_order, $ct_d) {
            $ia = $a === $ct_d['slug'] ? -1 : (array_search($a, $ct_order, true) === false ? 99 : array_search($a, $ct_order, true));
            $ib = $b === $ct_d['slug'] ? -1 : (array_search($b, $ct_order, true) === false ? 99 : array_search($b, $ct_order, true));
            return $ia <=> $ib;
        });
        foreach ($ct_pages as $ct_pk => $ct_p) {
            $ct_m   = svc_page_meta($ct_pk);
            $ct_hub = $ct_pk === $ct_d['slug'];
            if ($ct_hub) {
                foreach ($ct_p['categories'] as $ct_c) {
                    $ct_block = ['label' => $ct_c['name'], 'sub' => '', 'chips' => []];
                    foreach ($ct_c['offers'] as $ct_o) {
                        $ct_block['chips'][] = $ct_chip($ct_pk . ':' . $ct_o['key'], $ct_o['name'], $ct_d['name'] . ' · Overview · ' . $ct_c['name'],
                            $ct_c['name'] . ' ' . implode(' ', $ct_o['tags'] ?? []) . ' ' . implode(' ', $ct_o['stack'] ?? []));
                    }
                    $ct_g['main'][] = $ct_block;
                }
            } else {
                $ct_block = ['label' => $ct_m['name'], 'sub' => 'Capability page', 'chips' => []];
                foreach ($ct_p['categories'] as $ct_c) {
                    foreach ($ct_c['offers'] as $ct_o) {
                        $ct_block['chips'][] = $ct_chip($ct_pk . ':' . $ct_o['key'], $ct_o['name'], $ct_d['name'] . ' · ' . $ct_m['name'] . ' · ' . $ct_c['name'],
                            $ct_m['name'] . ' ' . $ct_c['name'] . ' ' . implode(' ', $ct_o['tags'] ?? []) . ' ' . implode(' ', $ct_o['stack'] ?? []));
                    }
                }
                if (isset($ct_pages[$ct_d['slug']])) $ct_g['more'][] = $ct_block; else $ct_g['main'][] = $ct_block;
            }
        }
    } else {
        $ct_block = ['label' => 'Capabilities', 'sub' => '', 'chips' => []];
        foreach (svc_general()[$ct_d['slug']]['options'] ?? [] as $ct_o) {
            $ct_block['chips'][] = $ct_chip($ct_o['id'], $ct_o['name'], $ct_d['name'] . ' · ' . $ct_o['name'], $ct_o['desc']);
        }
        $ct_g['main'][] = $ct_block;
    }
    $ct_count = fn (array $ct_blocks): int => array_sum(array_map(fn ($ct_b) => count(array_filter($ct_b['chips'], fn ($ct_x) => $ct_x['on'])), $ct_blocks));
    $ct_g['on_main'] = $ct_count($ct_g['main']);
    $ct_g['on_more'] = $ct_count($ct_g['more']);
    $ct_g['total']   = array_sum(array_map(fn ($ct_b) => count($ct_b['chips']), array_merge($ct_g['main'], $ct_g['more'])));
    $ct_g['open']    = ($ct_g['on_main'] + $ct_g['on_more']) > 0 || ($ct_from && $ct_from['dslug'] === $ct_d['slug']);
    $ct_groups[] = $ct_g;
}

/* ---- the brief summary (server copy; contact.js keeps it live) ---- */
$ct_rows = array_values(array_filter(array_map('svc_resolve', $ct_v['services'])));
$ct_pkg  = $ct_v['package'] !== '' ? $ct_pks[$ct_v['package']] : null;
$ct_without = function (?string $drop_id, bool $drop_pkg) use ($ct_v): string {
    return svc_contact_url(array_values(array_diff($ct_v['services'], [$drop_id])), $drop_pkg ? null : ($ct_v['package'] ?: null), $ct_v['from'] ?: null);
};
$ct_fe = fn (string $f): string => isset($ct_err[$f]) ? ' aria-invalid="true" aria-describedby="ct-e-' . $f . '"' : '';
$ct_err_labels = ['form' => 'Form', 'name' => 'Name', 'email' => 'Work email', 'phone' => 'Phone', 'service' => 'What you need'];

include 'partials/head.php';
include 'partials/nav.php';
?>

<main id="main" class="ct">
<?php include 'partials/page-hero.php'; ?>

<?php if ($CT['state'] === 'sent'): ?>
  <section class="band ct-done" aria-labelledby="ct-done-t" data-ct-sent>
    <div class="wrap">
      <div class="ct-done__card" data-rv>
        <span class="ct-done__tick" aria-hidden="true"><?= svc_icon('tick') ?></span>
        <div class="ct-done__main">
          <p class="lbl lbl--blue"><span class="dot"></span>Sent</p>
          <h2 class="ct-done__t" id="ct-done-t"><?= $ct_apps ? 'We have your application.' : 'We have your brief.' ?></h2>
          <?php if ($CT['ref']): ?>
            <p class="ct-done__ref"><span>Reference</span><b><?= e($CT['ref']) ?></b></p>
          <?php endif; ?>
          <p class="ct-done__p">It is with the team now. If anything changes before we reply, write to
            <a href="mailto:<?= e($SITE['company']['email']) ?>"><?= e($SITE['company']['email']) ?></a><?= $CT['ref'] ? ' and quote the reference' : '' ?>.</p>
        </div>
        <ol class="ct-next">
          <?php if ($ct_apps): ?>
            <li><span class="ct-next__n">01</span><b>The hiring lead reads it.</b><span>Every application is read by a person, not screened by keyword.</span></li>
            <li><span class="ct-next__n">02</span><b>You hear back either way.</b><span>We aim to reply within five working days, with next steps or a clear no.</span></li>
            <li><span class="ct-next__n">03</span><b>A conversation, then a task.</b><span>If it fits, a first call and a short, scoped work sample.</span></li>
          <?php else: ?>
            <li><span class="ct-next__n">01</span><b>It goes to the right lead.</b><span>Each brief is routed to the lead for the discipline it is about.</span></li>
            <li><span class="ct-next__n">02</span><b>A named lead replies.</b><span>We aim to reply within one working day, with questions or a time to talk.</span></li>
            <li><span class="ct-next__n">03</span><b>Thirty minutes, then a scope.</b><span>A call, a straight answer, and a written scope if we are the right team.</span></li>
          <?php endif; ?>
        </ol>
        <div class="ct-done__go">
          <?php if ($ct_from): ?>
            <a class="btn btn--out" href="<?= e($ct_from['url']) ?>">Back to <?= e($ct_from['name']) ?> <span class="i" aria-hidden="true">›</span></a>
          <?php endif; ?>
          <a class="btn btn--ink" href="<?= xe_url('services/') ?>">Explore our services <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>
    </div>
  </section>

<?php else: ?>
  <section class="band ct-main" aria-labelledby="ct-form-t">
    <div class="wrap ct-grid">

      <div class="ct-formcol">
        <h2 class="sr" id="ct-form-t">Send us a brief</h2>

        <?php if ($CT['state'] === 'failed'): ?>
          <!-- PLACEHOLDER: confirm where leads should go (email / CRM) before launch -->
          <div class="ct-alert ct-alert--fail" role="alert" tabindex="-1" data-ct-focus>
            <span class="ct-alert__ico" aria-hidden="true"><?= svc_icon('mail') ?></span>
            <div class="ct-alert__b">
              <p class="ct-alert__t">We could not send your brief from this page.</p>
              <p class="ct-alert__p">Nothing is lost. Your answers are still below, and the button opens your email app with the same brief written out, ready to send to <?= e($SITE['company']['email']) ?>.</p>
              <div class="ct-alert__go">
                <a class="btn btn--ink" href="<?= e($CT['mailto']) ?>">Email the brief instead <span class="i" aria-hidden="true">›</span></a>
                <?php if ($CT['ref']): ?><span class="ct-alert__ref">Reference <?= e($CT['ref']) ?></span><?php endif; ?>
              </div>
            </div>
          </div>
        <?php elseif ($ct_err): ?>
          <div class="ct-alert" role="alert" tabindex="-1" id="ct-errs" data-ct-focus>
            <span class="ct-alert__ico" aria-hidden="true"><?= svc_icon('dot') ?></span>
            <div class="ct-alert__b">
              <p class="ct-alert__t"><?= count($ct_err) === 1 ? 'One thing to fix before we can send this.' : count($ct_err) . ' things to fix before we can send this.' ?></p>
              <ul class="ct-alert__list">
                <?php foreach ($ct_err as $ct_f => $ct_m): ?>
                  <li><?php if ($ct_f === 'form'): ?><?= e($ct_m) ?><?php else: ?><a href="#ct-<?= e($ct_f) ?>"><?= e($ct_err_labels[$ct_f] ?? ucfirst($ct_f)) ?>: <?= e($ct_m) ?></a><?php endif; ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        <?php endif; ?>

        <?php if ($CT['dropped']): ?>
          <p class="ct-note"><?= $CT['dropped'] === 1 ? 'One service in the link you followed is no longer listed, so it is not selected below.' : $CT['dropped'] . ' services in the link you followed are no longer listed, so they are not selected below.' ?></p>
        <?php endif; ?>

        <form class="ct-form" action="<?= e(xe_url('contact.php')) ?>" method="post" novalidate data-ct-form>
          <input type="hidden" name="from" value="<?= e($ct_v['from']) ?>">
          <input type="hidden" name="pre" value="<?= e(implode(',', $ct_v['pre'])) ?>">
          <input type="hidden" name="t" value="<?= e($CT['t']) ?>">
          <?php if ($ct_app): ?><input type="hidden" name="apply" value="<?= e('Application: ' . $ct_app['role'] . ' (' . $ct_app['id'] . ')') ?>"><?php endif; ?>
          <div class="ct-hp" aria-hidden="true">
            <label for="ct-website">Website (leave this empty)</label>
            <input type="text" id="ct-website" name="website" tabindex="-1" autocomplete="off">
          </div>

          <!-- 01 · About you -->
          <fieldset class="ct-set" aria-describedby="ct-set1-d">
            <legend class="ct-set__lg"><span class="ct-set__n">01</span>About you</legend>
            <p class="ct-set__d" id="ct-set1-d">So we know who to reply to. Fields marked * are required.</p>
            <div class="ct-fields">
              <div class="ct-field<?= isset($ct_err['name']) ? ' is-bad' : '' ?>">
                <label class="ct-label" for="ct-name">Name <span aria-hidden="true">*</span></label>
                <input class="ct-input" id="ct-name" name="name" type="text" autocomplete="name" maxlength="120" required value="<?= e($ct_v['name']) ?>"<?= $ct_fe('name') ?>>
                <?php if (isset($ct_err['name'])): ?><p class="ct-err" id="ct-e-name"><?= e($ct_err['name']) ?></p><?php endif; ?>
              </div>
              <div class="ct-field<?= isset($ct_err['email']) ? ' is-bad' : '' ?>">
                <label class="ct-label" for="ct-email">Work email <span aria-hidden="true">*</span></label>
                <input class="ct-input" id="ct-email" name="email" type="email" autocomplete="email" maxlength="190" required inputmode="email" value="<?= e($ct_v['email']) ?>"<?= $ct_fe('email') ?>>
                <?php if (isset($ct_err['email'])): ?><p class="ct-err" id="ct-e-email"><?= e($ct_err['email']) ?></p><?php endif; ?>
              </div>
              <div class="ct-field">
                <label class="ct-label" for="ct-company">Company</label>
                <input class="ct-input" id="ct-company" name="company" type="text" autocomplete="organization" maxlength="160" value="<?= e($ct_v['company']) ?>">
              </div>
              <div class="ct-field<?= isset($ct_err['phone']) ? ' is-bad' : '' ?>">
                <label class="ct-label" for="ct-phone">Phone <span class="ct-opt">Optional</span></label>
                <input class="ct-input" id="ct-phone" name="phone" type="tel" autocomplete="tel" maxlength="40" value="<?= e($ct_v['phone']) ?>"<?= $ct_fe('phone') ?>>
                <?php if (isset($ct_err['phone'])): ?><p class="ct-err" id="ct-e-phone"><?= e($ct_err['phone']) ?></p><?php endif; ?>
              </div>
            </div>
          </fieldset>

          <?php if (!$ct_app): /* an application skips services, package and budget */ ?>
          <!-- 02 · What you need -->
          <fieldset class="ct-set ct-set--svc<?= isset($ct_err['service']) ? ' is-bad' : '' ?>" id="ct-service" aria-describedby="ct-set2-d<?= isset($ct_err['service']) ? ' ct-e-service' : '' ?>">
            <legend class="ct-set__lg"><span class="ct-set__n">02</span>What you need</legend>
            <p class="ct-set__d" id="ct-set2-d">Choose as many services as you like. Not sure? Skip this and describe the problem in your message.</p>
            <?php if (isset($ct_err['service'])): ?><p class="ct-err" id="ct-e-service"><?= e($ct_err['service']) ?></p><?php endif; ?>

            <div class="ct-find" hidden data-ct-find>
              <label class="sr" for="ct-q">Search services</label>
              <span class="ct-find__ico" aria-hidden="true"><?= svc_icon('search') ?></span>
              <input class="ct-find__in" id="ct-q" type="search" placeholder="Search every service, e.g. packaging, audit, React" autocomplete="off" data-ct-q>
              <p class="ct-find__n" aria-live="polite" data-ct-qn></p>
            </div>

            <div class="ct-discs">
              <?php foreach ($ct_groups as $ct_gi => $ct_g): $ct_on = $ct_g['on_main'] + $ct_g['on_more']; ?>
                <details class="ct-disc" data-ct-disc<?= $ct_g['open'] ? ' open' : '' ?>>
                  <summary class="ct-disc__s">
                    <span class="ct-disc__n"><?= e($ct_g['d']['n']) ?></span>
                    <span class="ct-disc__t"><?= e($ct_g['d']['name']) ?></span>
                    <span class="ct-disc__c" data-ct-dcount><?= $ct_on ? $ct_on . ' selected' : '' ?></span>
                    <span class="ct-disc__all"><?= $ct_g['total'] ?> services</span>
                    <span class="ct-disc__pm" aria-hidden="true"></span>
                  </summary>
                  <div class="ct-disc__b">
                    <?php foreach ($ct_g['main'] as $ct_b): ?>
                      <div class="ct-block" data-ct-block>
                        <p class="ct-block__h"><?= e($ct_b['label']) ?><?php if ($ct_b['sub']): ?> <span><?= e($ct_b['sub']) ?></span><?php endif; ?></p>
                        <ul class="ct-chips">
                          <?php foreach ($ct_b['chips'] as $ct_x): ?>
                            <li data-ct-item data-s="<?= e($ct_x['search']) ?>">
                              <label class="ct-chip">
                                <input type="checkbox" name="service[]" value="<?= e($ct_x['id']) ?>" data-name="<?= e($ct_x['name']) ?>" data-meta="<?= e($ct_x['meta']) ?>"<?= $ct_x['on'] ? ' checked' : '' ?>>
                                <span class="ct-chip__box" aria-hidden="true"><?= svc_icon('tick') ?></span>
                                <span class="ct-chip__n"><?= e($ct_x['name']) ?></span>
                              </label>
                            </li>
                          <?php endforeach; ?>
                        </ul>
                      </div>
                    <?php endforeach; ?>

                    <?php if ($ct_g['more']): ?>
                      <div class="ct-caps" data-ct-caps>
                        <p class="ct-block__h">Every service, by capability page</p>
                        <?php foreach ($ct_g['more'] as $ct_b): $ct_bon = count(array_filter($ct_b['chips'], fn ($ct_x) => $ct_x['on'])); ?>
                          <details class="ct-more" data-ct-more<?= $ct_bon ? ' open' : '' ?>>
                            <summary class="ct-more__s">
                              <span class="ct-more__t"><?= e($ct_b['label']) ?></span>
                              <span class="ct-more__on" data-ct-mcount><?= $ct_bon ? $ct_bon . ' selected' : '' ?></span>
                              <span class="ct-more__c"><?= count($ct_b['chips']) ?> services</span>
                            </summary>
                            <div class="ct-more__b">
                              <div class="ct-block" data-ct-block>
                                <ul class="ct-chips">
                                  <?php foreach ($ct_b['chips'] as $ct_x): ?>
                                    <li data-ct-item data-s="<?= e($ct_x['search']) ?>">
                                      <label class="ct-chip">
                                        <input type="checkbox" name="service[]" value="<?= e($ct_x['id']) ?>" data-name="<?= e($ct_x['name']) ?>" data-meta="<?= e($ct_x['meta']) ?>"<?= $ct_x['on'] ? ' checked' : '' ?>>
                                        <span class="ct-chip__box" aria-hidden="true"><?= svc_icon('tick') ?></span>
                                        <span class="ct-chip__n"><?= e($ct_x['name']) ?></span>
                                      </label>
                                    </li>
                                  <?php endforeach; ?>
                                </ul>
                              </div>
                            </div>
                          </details>
                        <?php endforeach; ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </details>
              <?php endforeach; ?>
            </div>
            <p class="ct-find__none" hidden data-ct-none>No service matches that. Describe what you need in your message and we will route it.</p>
          </fieldset>

          <!-- 03 · How you would like to engage -->
          <fieldset class="ct-set" aria-describedby="ct-set3-d">
            <legend class="ct-set__lg"><span class="ct-set__n">03</span>How you would like to engage</legend>
            <p class="ct-set__d" id="ct-set3-d">Pick the package that sounds closest. We will confirm the right one with you before any scope is written.</p>
            <div class="ct-pks">
              <?php foreach ($ct_pks as $ct_k => $ct_p): ?>
                <label class="ct-pk">
                  <input type="radio" name="package" value="<?= e($ct_k) ?>" data-name="<?= e($ct_p['name']) ?>" data-meta="<?= e($ct_p['pricing'] . ' · ' . $ct_p['duration']) ?>"<?= $ct_v['package'] === $ct_k ? ' checked' : '' ?>>
                  <span class="ct-pk__top">
                    <span class="ct-pk__ico" aria-hidden="true"><?= svc_icon($ct_p['icon'] ?? 'dot') ?></span>
                    <span class="ct-pk__dot" aria-hidden="true"></span>
                  </span>
                  <span class="ct-pk__n"><?= e($ct_p['name']) ?></span>
                  <span class="ct-pk__d"><?= e($ct_p['tagline']) ?></span>
                  <span class="ct-pk__m"><span><?= e($ct_p['pricing']) ?></span><span><?= e($ct_p['duration']) ?></span></span>
                </label>
              <?php endforeach; ?>
              <label class="ct-pk ct-pk--none">
                <input type="radio" name="package" value="" data-name="" data-meta=""<?= $ct_v['package'] === '' ? ' checked' : '' ?>>
                <span class="ct-pk__top">
                  <span class="ct-pk__ico" aria-hidden="true"><?= svc_icon('compass') ?></span>
                  <span class="ct-pk__dot" aria-hidden="true"></span>
                </span>
                <span class="ct-pk__n">Not sure yet</span>
                <span class="ct-pk__d">Tell us the problem and we will recommend the way to work that fits it.</span>
              </label>
            </div>
          </fieldset>

          <!-- 04 · Budget and timing -->
          <fieldset class="ct-set">
            <legend class="ct-set__lg"><span class="ct-set__n">04</span>Budget and timing</legend>
            <p class="ct-set__d">Both optional. A range helps us propose the right scope the first time.</p>
            <div class="ct-fields">
              <div class="ct-field">
                <label class="ct-label" for="ct-budget">Budget range <span class="ct-opt">Optional</span></label>
                <span class="ct-selw">
                  <select class="ct-input ct-select" id="ct-budget" name="budget">
                    <option value="">Prefer not to say</option>
                    <?php foreach ($CT['budgets'] as $ct_k => $ct_l): ?><option value="<?= e($ct_k) ?>"<?= $ct_v['budget'] === $ct_k ? ' selected' : '' ?>><?= e($ct_l) ?></option><?php endforeach; ?>
                  </select>
                </span>
              </div>
              <div class="ct-field">
                <label class="ct-label" for="ct-timeline">When would you like to start? <span class="ct-opt">Optional</span></label>
                <span class="ct-selw">
                  <select class="ct-input ct-select" id="ct-timeline" name="timeline">
                    <option value="">Choose a timeframe</option>
                    <?php foreach ($CT['timelines'] as $ct_k => $ct_l): ?><option value="<?= e($ct_k) ?>"<?= $ct_v['timeline'] === $ct_k ? ' selected' : '' ?>><?= e($ct_l) ?></option><?php endforeach; ?>
                  </select>
                </span>
              </div>
            </div>
          </fieldset>

          <?php endif; ?>
          <!-- 05 · Anything else (02 for an application) -->
          <fieldset class="ct-set">
            <legend class="ct-set__lg"><span class="ct-set__n"><?= $ct_app ? '02' : '05' ?></span><?= $ct_app ? 'About you and your work' : 'Anything else' ?></legend>
            <div class="ct-field">
              <?php if ($ct_app): ?>
              <label class="ct-label" for="ct-message">Your application <span class="ct-opt">A few lines on why this role, and links to your portfolio, CV or code</span></label>
              <?php else: ?>
              <label class="ct-label" for="ct-message">Tell us about the work <span class="ct-opt">What you are building, what is in the way, what good looks like</span></label>
              <?php endif; ?>
              <textarea class="ct-input ct-area" id="ct-message" name="message" rows="7" maxlength="4000" aria-describedby="ct-message-n" data-ct-msg><?= e($ct_v['message']) ?></textarea>
              <p class="ct-count" id="ct-message-n" data-ct-count>Up to 4,000 characters.</p>
            </div>
          </fieldset>

          <div class="ct-send">
            <!-- PLACEHOLDER: link "Privacy Notice" to the real page once it exists (data/site.php 'legal'). -->
            <p class="ct-consent">By sending this <?= $ct_app ? 'application' : 'brief' ?> you agree that we use these details to reply to it. Nothing is added to a mailing list, and nothing is shared outside the team.</p>
            <button class="btn btn--ink btn--lg ct-send__btn" type="submit" data-ct-send><?= $ct_app ? 'Send the application' : 'Send the brief' ?> <span class="i" aria-hidden="true">›</span></button>
          </div>
        </form>
      </div>

      <aside class="ct-side<?= ($ct_rows || $ct_pkg || $ct_app) ? ' ct-side--lead' : '' ?>" aria-labelledby="ct-brief-t">
        <div class="ct-brief" data-ct-brief>
          <div class="ct-brief__head">
            <h2 class="ct-brief__t" id="ct-brief-t"><?= $ct_app ? 'Your application' : 'Your brief' ?></h2>
            <?php if (!$ct_app): ?><span class="ct-brief__c" data-ct-bcount><?= count($ct_rows) === 1 ? '1 service' : count($ct_rows) . ' services' ?></span><?php endif; ?>
          </div>
          <?php if ($ct_from): ?>
            <p class="ct-brief__from"><span>From</span><a href="<?= e($ct_from['url']) ?>"><?= e($ct_from['name']) ?></a></p>
          <?php endif; ?>

          <?php if ($ct_app): ?>
            <p class="ct-brief__role"><span>Role</span><b><?= e($ct_app['role']) ?></b><span>Reference <?= e($ct_app['id']) ?></span></p>
          <?php endif; ?>
          <ul class="ct-brief__list" data-ct-blist<?= $ct_app ? ' hidden' : '' ?>>
            <?php foreach ($ct_rows as $ct_r): ?>
              <li class="ct-bi">
                <span class="ct-bi__n"><?= e($ct_r['name']) ?></span>
                <span class="ct-bi__m"><?= e($ct_r['discipline'] . ' · ' . ($ct_r['hub'] ? 'Overview' : $ct_r['page']) . ' · ' . $ct_r['category']) ?></span>
                <a class="ct-bi__x" href="<?= e($ct_without($ct_r['id'], false)) ?>" data-ct-rm="<?= e($ct_r['id']) ?>" aria-label="Remove <?= e($ct_r['name']) ?> from your brief"><?= svc_icon('x') ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
          <?php if (!$ct_app): ?><p class="ct-brief__empty" data-ct-bempty<?= $ct_rows ? ' hidden' : '' ?>>No services chosen yet. Pick some from the list, or simply tell us the problem.</p><?php endif; ?>

          <div class="ct-brief__pk" data-ct-bpk<?= $ct_pkg ? '' : ' hidden' ?>>
            <span class="ct-brief__pkk">Package</span>
            <span class="ct-brief__pkn" data-ct-bpkn><?= $ct_pkg ? e($ct_pkg['name']) : '' ?></span>
            <span class="ct-brief__pkm" data-ct-bpkm><?= $ct_pkg ? e($ct_pkg['pricing'] . ' · ' . $ct_pkg['duration']) : '' ?></span>
            <a class="ct-bi__x" href="<?= e($ct_without(null, true)) ?>" data-ct-rmpk aria-label="Remove the package from your brief"><?= svc_icon('x') ?></a>
          </div>

          <ol class="ct-brief__next">
            <?php if ($ct_app): ?>
              <li><span>01</span>The hiring lead for the role reads it.</li>
              <li><span>02</span>We aim to reply within five working days.</li>
              <li><span>03</span>A first call if it is a fit.</li>
            <?php else: ?>
              <li><span>01</span>It goes to the lead for that discipline.</li>
              <li><span>02</span>We aim to reply within one working day.</li>
              <li><span>03</span>A thirty-minute call, then a written scope.</li>
            <?php endif; ?>
          </ol>
        </div>

        <div class="ct-direct">
          <p class="ct-direct__k">Prefer to write or talk?</p>
          <a class="ct-direct__mail" href="mailto:<?= e($SITE['company']['email']) ?>"><?= e($SITE['company']['email']) ?></a>
          <a class="tl" href="<?= xe_url('index.php#book') ?>">Book a thirty-minute call <span class="i" aria-hidden="true">›</span></a>
          <a class="tl" href="#reach">Other inboxes and our offices <span class="i" aria-hidden="true">›</span></a>
        </div>
      </aside>

    </div>
  </section>
<?php endif; ?>
<?php include 'partials/contact/reach.php'; ?>
</main>

<?php include 'partials/footer.php'; ?>
