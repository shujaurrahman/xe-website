<?php
/**
 * Contact — the brief desk. A progressive request for quotation: a short path that always works,
 * and a full RFQ that unfolds for buyers who want to specify properly.
 *
 * Arrives pre-filled from any service catalogue (partials/services/catalogue.php):
 *   contact?service[]=<page>:<offer>&service[]=…&package=<key>&from=<page key>
 *   or the same fields POSTed with intent=select (what the catalogue does, so a long brief
 *   stays out of the URL); a single "Enquire" posts only=<page>:<offer>, a package card
 *   posts pick_package=<key>. Both routes pre-fill; neither sends anything.
 *
 * The query, the POST, the optional brief document and the lead email are all handled in
 * partials/contact/handler.php (it may redirect, so it runs before any output). Sections are
 * partials/contact/<id>.php; styles assets/css/contact.css (.ct-*); behaviour assets/js/contact.js.
 * The depth chooser (#paths) and the form (#brief) sit inside ONE <form>, so the chooser posts.
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
$ct_app  = $CT['app'];
$ct_sent = $CT['state'] === 'sent';
$ct_apps = $ct_sent && $ct_v['from'] === 'careers';

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
                $ct_block = ['label' => $ct_m['name'], 'sub' => 'Capability page', 'key' => $ct_pk, 'url' => $ct_m['url'] ?? xe_discipline_url($ct_d), 'chips' => []];
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
    /* one vocabulary site-wide: "services" = the discipline's own offers (the same count home s25 shows);
       the capability pages' finer-grained offers are "in detail" and load on demand */
    $ct_g['n_main']  = array_sum(array_map(fn ($ct_b) => count($ct_b['chips']), $ct_g['main']));
    $ct_g['n_more']  = array_sum(array_map(fn ($ct_b) => count($ct_b['chips']), $ct_g['more']));
    $ct_g['open']    = ($ct_g['on_main'] + $ct_g['on_more']) > 0 || ($ct_from && $ct_from['dslug'] === $ct_d['slug']);
    $ct_groups[] = $ct_g;
}

/* ---- the capability pages' services, fetched by contact.js when a list opens or a search runs ---- */
if (isset($_GET['ct_more'])) {
    $ct_json = [];
    foreach ($ct_groups as $ct_g) foreach ($ct_g['more'] as $ct_b) {
        $ct_json[$ct_b['key']] = array_map(fn ($ct_x) => [$ct_x['id'], $ct_x['name'], $ct_x['meta'], $ct_x['search']], $ct_b['chips']);
    }
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: public, max-age=300');
    echo json_encode($ct_json, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

/* ---- the brief summary, the preview and the meter, all from one structure (handler.php) ---- */
$ct_rows   = array_values(array_filter(array_map('svc_resolve', $ct_v['services'])));
$ct_pkg    = $ct_v['package'] !== '' ? $ct_pks[$ct_v['package']] : null;
$ct_blocks = ct_blocks($CT, $ct_rows, $ct_pkg);
[$ct_on, $ct_all] = ct_answered($CT);
$ct_without = function (?string $drop_id, bool $drop_pkg) use ($ct_v): string {
    return svc_contact_url(array_values(array_diff($ct_v['services'], [$drop_id])), $drop_pkg ? null : ($ct_v['package'] ?: null), $ct_v['from'] ?: null);
};
$ct_fe = fn (string $f): string => isset($ct_err[$f]) ? ' aria-invalid="true" aria-describedby="ct-e-' . $f . '"' : '';
$ct_err_labels = [
    'form' => 'Form', 'name' => 'Name', 'email' => 'Work email', 'phone' => 'Phone', 'website' => 'Website',
    'service' => 'What you need', 'message' => 'The problem', 'deadline' => 'Fixed date', 'doc' => 'Brief document',
];
/* which collapsible blocks start open: the depth asks for them, something in them is filled, or
   something in them failed validation — a closed block must never hide an error or an answer */
$ct_openif = function (array $fields) use ($ct_v, $ct_err): bool {
    foreach ($fields as $f) {
        if (isset($ct_err[$f])) return true;
        if (is_array($ct_v[$f] ?? null) ? !empty($ct_v[$f]) : (($ct_v[$f] ?? '') !== '')) return true;
    }
    return false;
};
$ct_open_detail = $ct_v['depth'] === 'rfq' || $ct_openif(['goals', 'audience', 'current', 'measures']);
$ct_open_money  = $ct_v['depth'] !== 'hello' || $ct_openif(['package', 'budget', 'timeline', 'deadline', 'decision', 'stakeholders', 'buying']);
$ct_open_prac   = $ct_v['depth'] === 'rfq' || $ct_openif(['heard', 'heard_note', 'nda', 'access']);

/* PLACEHOLDER: confirm the response times quoted on this page ("one working day", "five working days") before launch. */
if ($ct_sent) {
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
    $hero = ['eyebrow' => 'Contact · Request a quotation', 'title' => 'Tell us the problem.<br><span class="g">We will tell you what it takes.</span>',
             'lead' => 'A short note is enough to start. A full brief gets you a scope, a shape of team and a price range instead of a sales call.',
             'meta' => ['Reply aimed within one working day', 'NDA before anything detailed', 'New Delhi · Ludhiana']];
}

$ct_css = ['assets/css/brand/hub.css', 'assets/css/tech/kit.css', 'assets/css/contact.css'];
$ct_js  = ['assets/js/brand/hub.js', 'assets/js/contact.js'];
$page = [
    'key'   => 'contact',
    'title' => 'Contact',
    'desc'  => 'Send a short note or a full request for quotation. Tell us what you are building and we will tell you straight whether we are the right team for it.',
    'css'   => $ct_css,
    'js'    => $ct_js,
];

include 'partials/head.php';
include 'partials/nav.php';
?>

<main id="main" class="bdh ct">
<?php include 'partials/page-hero.php'; ?>

<?php if ($ct_sent): ?>
  <?php include 'partials/contact/done.php'; ?>
  <?php include 'partials/contact/route.php'; ?>
  <?php include 'partials/contact/reach.php'; ?>
  <?php include 'partials/contact/faq.php'; ?>
<?php else: ?>
  <form class="ct-form" id="brief-form" action="<?= e(xe_url('contact.php')) ?>" method="post" enctype="multipart/form-data" novalidate data-ct-form>
    <input type="hidden" name="from" value="<?= e($ct_v['from']) ?>">
    <input type="hidden" name="pre" value="<?= e(implode(',', $ct_v['pre'])) ?>">
    <input type="hidden" name="t" value="<?= e($CT['t']) ?>">
    <?php if ($ct_app): ?><input type="hidden" name="apply" value="<?= e('Application: ' . $ct_app['role'] . ' (' . $ct_app['id'] . ')') ?>"><?php endif; ?>
    <div class="ct-hp" aria-hidden="true">
      <label for="ct-fax">Fax (leave this empty)</label>
      <input type="text" id="ct-fax" name="fax" tabindex="-1" autocomplete="off">
    </div>
    <?php include 'partials/contact/paths.php'; ?>
    <?php include 'partials/contact/brief.php'; ?>
  </form>
  <?php if (!$ct_app): /* a careers application has no RFQ, no catalogue and no procurement */ ?>
    <?php include 'partials/contact/preview.php'; ?>
  <?php endif; ?>
  <?php include 'partials/contact/route.php'; ?>
  <?php if (!$ct_app): ?>
    <?php include 'partials/contact/needs.php'; ?>
    <?php include 'partials/contact/procure.php'; ?>
  <?php endif; ?>
  <?php include 'partials/contact/reach.php'; ?>
  <?php include 'partials/contact/faq.php'; ?>
<?php endif; ?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type'    => 'ContactPage',
    'name'     => $SITE['company']['name'] . ' — contact and request for quotation',
    'url'      => 'contact',
    'about'    => ['@type' => 'Organization', 'name' => $SITE['company']['name'], 'email' => $SITE['company']['email']],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>
</script>

<?php include 'partials/footer.php'; ?>
