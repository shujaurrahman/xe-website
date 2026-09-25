<?php /* DRAFT COPY — review before launch */
/**
 * Case study — the shared renderer behind every /work/<slug> page.
 *
 * Each page file, work/<slug>.php, is three lines: it sets $wrk_slug and includes this file. Every
 * word, photograph and figure on the page comes from that programme's entry in data/work.php, so a
 * new case study needs no new markup — append the entry, copy a page file, done.
 *
 * Sections: hero · ledger · problem · what we did · the system (+ its code-built artefact) ·
 * plates · the judgement call · deliverables and measures · results (deliberately blank) ·
 * frameworks and stack · other programmes · the shared closing band.
 *
 * Optional fields simply do not render when they are empty — see the header of data/work.php.
 */
$BASE = '../';
require __DIR__ . '/../init.php';
require_once __DIR__ . '/../tech/kit.php';
require_once __DIR__ . '/lib.php';
require_once __DIR__ . '/thumbs.php';

$WRK   = require __DIR__ . '/../../data/work.php';
$wrk_c = wrk_case($WRK, (string) ($wrk_slug ?? ''));
if ($wrk_c === null) {   /* the entry was removed from data/work.php but the page file is still here */
    header('Location: ' . xe_url('work.php'), true, 302);
    return;
}

$wrk_disc = [];
foreach ($SITE['disciplines'] as $wrk_x) $wrk_disc[$wrk_x['slug']] = $wrk_x;
unset($wrk_x);
$wrk_has   = fn (string $wrk_s): bool => is_file(__DIR__ . '/../../work/' . $wrk_s . '.php');
$wrk_sect  = $WRK['industries'][$wrk_c['industry']];
$wrk_art   = wrk_thumb($wrk_c['artefact'] ?? $wrk_c['slug']);

/* other programmes: same sector first, then ones sharing a discipline, then the rest — pages only */
$wrk_mine  = array_column($wrk_c['did'], 0);
$wrk_other = [];
foreach (wrk_cases($WRK) as $wrk_o) {
    if ($wrk_o['slug'] === $wrk_c['slug'] || !$wrk_has($wrk_o['slug'])) continue;
    $wrk_score = ($wrk_o['industry'] === $wrk_c['industry'] ? 2 : 0) + count(array_intersect(array_column($wrk_o['did'], 0), $wrk_mine));
    $wrk_other[] = ['s' => $wrk_score, 'c' => $wrk_o];
}
usort($wrk_other, fn ($wrk_a, $wrk_b) => $wrk_b['s'] <=> $wrk_a['s']);
$wrk_other = array_slice(array_column($wrk_other, 'c'), 0, 3);

$pp_root = __DIR__ . '/../../';
$pp_has  = fn (string $p): ?string => (is_file($pp_root . $p) && filesize($pp_root . $p) > 0) ? $p : null;
$page = [
    'key'   => 'work',
    'title' => $wrk_c['title'],
    'desc'  => $wrk_c['brief'] . ' — an anonymised ' . strtolower($wrk_sect) . ' programme.',
    'css'   => array_values(array_filter([$pp_has('assets/css/brand/hub.css'), $pp_has('assets/css/tech/kit.css'), $pp_has('assets/css/work.css'), $pp_has('assets/css/work/case.css')])),
    'js'    => array_values(array_filter([$pp_has('assets/js/brand/hub.js'), $pp_has('assets/js/work/case.js')])),
];
include __DIR__ . '/../head.php';
include __DIR__ . '/../nav.php';
?>
<!-- PLACEHOLDER: replace with a real case study before launch. This programme is an anonymised
     illustration written in-house — no client is named, no photograph is of the client's work, and
     the results line is deliberately empty until a client approves a figure and its wording. -->
<main id="main" class="bdh wrk wrkc">

<section class="band wrkc-hero" id="top" aria-labelledby="wrkc-hero-t">
  <div class="wrap">
    <nav class="wrkc-crumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="<?= xe_url('work.php') ?>">Work</a></li>
        <li><a href="<?= xe_url('work.php') ?>?i=<?= e($wrk_c['industry']) ?>#programmes"><?= e($wrk_sect) ?></a></li>
        <li aria-current="page"><?= e($wrk_c['title']) ?></li>
      </ol>
    </nav>

    <div class="wrkc-hero__grid">
      <div class="wrkc-hero__say">
        <p class="lbl lbl--blue"><span class="dot"></span><?= e($wrk_c['client'] ?: 'Client not named · ' . $wrk_sect) ?></p>
        <h1 class="d2" id="wrkc-hero-t"><?= e($wrk_c['title']) ?></h1>
        <blockquote class="wrk-brief wrkc-hero__brief">
          <p class="bdh-ro wrk-brief__l">The brief, as the client put it</p>
          <p class="wrk-brief__t"><?= e($wrk_c['brief']) ?></p>
        </blockquote>
        <ul class="wrkc-hero__chips" aria-label="Disciplines involved">
          <?php foreach ($wrk_c['did'] as $wrk_x): $wrk_d = $wrk_disc[$wrk_x[0]] ?? null; if (!$wrk_d) continue; ?>
          <li><a class="wrk-capl" href="<?= xe_discipline_url($wrk_d) ?>"><b><?= e($wrk_d['n']) ?></b><?= e($wrk_d['short'] ?? $wrk_d['name']) ?><i aria-hidden="true">›</i></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- PLACEHOLDER: reference photograph (assets/imgs/work/CREDITS.md) — replace with this programme's own plate -->
      <?= wrk_img($wrk_c['img'], [
          'ratio' => 'r43', 'class' => 'bdh-img--xl wrkc-hero__img', 'eager' => true,
          'inner' => '<span class="wrk-frame" aria-hidden="true"><i></i><i></i><i></i><i></i></span>'
                   . '<span class="wrkc-hero__ro bdh-ro" aria-hidden="true"><i class="bdh-pulse"></i>' . e($wrk_sect) . '</span>',
      ]) ?>
    </div>

    <dl class="wrk-led wrkc-led" aria-label="Programme at a glance">
      <div><dt>Sector</dt><dd class="wrkc-led__t"><?= e($wrk_sect) ?></dd></div>
      <div><dt>Typical duration</dt><dd class="wrkc-led__t"><?= e($wrk_c['duration']) ?></dd></div>
      <div><dt>Dates</dt><dd class="wrkc-led__t"><?= $wrk_c['dates'] ?? '' ? e($wrk_c['dates']) : 'Shared under NDA' ?></dd></div>
      <div><dt>Disciplines</dt><dd><?= count($wrk_c['did']) ?></dd></div>
      <?php if (!empty($wrk_c['scope'])): ?><div class="wrk-led--wide"><dt>Team</dt><dd class="wrkc-led__t"><?= e($wrk_c['scope']) ?></dd></div><?php endif; ?>
    </dl>
  </div>
</section>

<?php if (!empty($wrk_c['problem'])): ?>
<section class="band band--alt wrkc-prob" id="problem" aria-labelledby="problem-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>The problem</p>
        <h2 class="h2" id="problem-t"><span class="g">What was actually</span> in the way.</h2></div>
      <div><p class="lead">Written as it was at the start, before we reframed anything. The reframing is the next section.</p></div>
    </div>
    <div class="wrkc-prob__body" data-rv data-rv-d="60">
      <?php foreach ($wrk_c['problem'] as $wrk_i => $wrk_p): ?>
      <p class="wrkc-prob__p<?= $wrk_i === 0 ? ' wrkc-prob__p--lead' : '' ?>"><?= e($wrk_p) ?></p>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="band wrkc-did" id="what-we-did" aria-labelledby="what-we-did-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>What we did</p>
        <h2 class="h2" id="what-we-did-t"><span class="g"><?= count($wrk_c['did']) ?> disciplines,</span> one delivery team.</h2></div>
      <div><p class="lead">One programme, one plan, one set of measures. The disciplines below describe the craft involved, not separate workstreams with separate meetings.</p></div>
    </div>
    <ol class="wrkc-did__list" data-bdh-stagger data-bdh-in>
      <?php foreach ($wrk_c['did'] as $wrk_i => $wrk_x): $wrk_d = $wrk_disc[$wrk_x[0]] ?? null; if (!$wrk_d) continue; ?>
      <li class="bdh-up">
        <span class="bdh-idx"><?= e($wrk_d['n']) ?></span>
        <div>
          <h3 class="bdh-t bdh-t--l"><a href="<?= xe_discipline_url($wrk_d) ?>"><?= e($wrk_d['name']) ?><span class="i" aria-hidden="true">›</span></a></h3>
          <p class="wrkc-did__r"><?= e($wrk_x[1]) ?></p>
          <p class="bdh-d"><?= e($wrk_d['intro']) ?></p>
        </div>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<section class="band band--ink wrkc-sys" id="the-system" aria-labelledby="the-system-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>The system</p>
        <h2 class="h2" id="the-system-t"><span class="g">What was left behind</span> and is still running.</h2></div>
      <div><p class="lead"><?= e($wrk_c['system']) ?></p></div>
    </div>

    <div class="wrkc-sys__grid">
      <?php if (!empty($wrk_c['build'])): ?>
      <ol class="wrkc-build" data-bdh-stagger data-bdh-in>
        <?php foreach ($wrk_c['build'] as $wrk_i => $wrk_b): ?>
        <li class="bdh-up"><span class="wrkc-build__n bdh-ro"><?= wrk_n($wrk_i + 1) ?></span>
          <div><h3 class="bdh-t bdh-t--l"><?= e($wrk_b[0]) ?></h3><p class="bdh-d"><?= e($wrk_b[1]) ?></p></div></li>
        <?php endforeach; ?>
      </ol>
      <?php endif; ?>

      <?php if ($wrk_art): ?>
      <div class="wrkc-art" data-rv data-rv-d="80">
        <p class="bdh-ro wrkc-art__l">The artefact it left behind</p>
        <?= $wrk_art ?>
        <p class="wrkc-art__f">A working sketch of the artefact, drawn in HTML — not a screenshot of a client system, and none of its figures is a client result.</p>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php if (!empty($wrk_c['gallery'])): ?>
<section class="band wrkc-plates" id="plates" aria-labelledby="plates-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Plates</p>
        <h2 class="h2" id="plates-t"><span class="g">Where the work</span> ended up.</h2></div>
      <div><p class="lead">Reference plates standing in for this programme’s own photography. <!-- PLACEHOLDER: replace with the programme's own images before launch --> None of them shows a client’s asset.</p></div>
    </div>
    <ul class="wrkc-plates__grid" data-bdh-stagger data-bdh-in>
      <?php foreach ($wrk_c['gallery'] as $wrk_i => $wrk_g): ?>
      <li class="bdh-up bdh-zoom">
        <?= wrk_img($wrk_g, ['ratio' => $wrk_i === 0 ? 'r169' : 'r43', 'class' => 'wrkc-plates__i',
            'inner' => '<span class="wrk-frame wrk-frame--s" aria-hidden="true"><i></i><i></i><i></i><i></i></span>']) ?>
        <?php if (!empty($wrk_g['cap'])): ?><p class="wrkc-plates__c"><span class="bdh-ro"><?= wrk_n($wrk_i + 1) ?></span><?= e($wrk_g['cap']) ?></p><?php endif; ?>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
<?php endif; ?>

<?php if (!empty($wrk_c['call'])): ?>
<section class="band band--alt band--tight wrkc-call" id="the-call" aria-labelledby="the-call-t">
  <div class="wrap wrkc-call__in" data-rv>
    <p class="lbl lbl--blue"><span class="dot"></span><?= e($wrk_c['call'][0]) ?></p>
    <h2 class="d2 wrkc-call__h" id="the-call-t"><?= e($wrk_c['call'][1]) ?></h2>
    <p class="wrkc-call__f bdh-ro">Written by the team that ran the programme · not a client statement</p>
  </div>
</section>
<?php endif; ?>

<section class="band wrkc-out" id="delivered" aria-labelledby="delivered-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Delivered and measured</p>
        <h2 class="h2" id="delivered-t"><span class="g">What you would own,</span> and what it is judged by.</h2></div>
      <div><p class="lead">Deliverables are the artefacts handed over. Measures are the numbers the programme is held to. Neither is a result — the results line below says why it is empty.</p></div>
    </div>

    <div class="wrkc-out__grid">
      <div class="wrkc-col">
        <p class="wrkc-col__h bdh-ro"><?= xt_icon('layers', ['size' => 16]) ?>Deliverables</p>
        <ul class="wrkc-list"><?php foreach ($wrk_c['deliverables'] as $wrk_x): ?><li><?= e($wrk_x) ?></li><?php endforeach; ?></ul>
      </div>
      <div class="wrkc-col">
        <p class="wrkc-col__h bdh-ro"><?= xt_icon('gauge', ['size' => 16]) ?>Measured by</p>
        <ul class="wrkc-list"><?php foreach ($wrk_c['measure'] as $wrk_x): ?><li><?= e($wrk_x) ?></li><?php endforeach; ?></ul>
      </div>
      <div class="wrkc-col wrkc-col--res">
        <p class="wrkc-col__h bdh-ro"><?= xt_icon('lock', ['size' => 16]) ?>Results</p>
        <?php if (!empty($wrk_c['outcome'])): ?>
          <p class="wrkc-res__t"><?= e($wrk_c['outcome']) ?></p>
        <?php else: ?>
          <!-- PLACEHOLDER: results pending client approval — add 'outcome' to this entry in data/work.php once approved -->
          <p class="wrkc-res__b" aria-hidden="true"><span class="wrk-red" style="--w:6"></span> <span class="wrk-red" style="--w:9"></span><br><span class="wrk-red" style="--w:4"></span> <span class="wrk-red" style="--w:7"></span></p>
          <p class="wrkc-res__t">Held back until the client approves the figure and the wording. Shared in full under an NDA, with the baseline, the period and the source named.</p>
          <a class="tl" href="<?= xe_url('contact.php') ?>">Ask for the walk-through <span class="i" aria-hidden="true">›</span></a>
        <?php endif; ?>
        <?php if (!empty($wrk_c['quote'][0])): ?>
          <blockquote class="wrkc-quote"><p><?= e($wrk_c['quote'][0]) ?></p><footer class="bdh-ro"><?= e($wrk_c['quote'][1] ?? '') ?></footer></blockquote>
        <?php endif; ?>
      </div>
    </div>

    <?php if (!empty($wrk_c['standards']) || !empty($wrk_c['stack'])): ?>
    <div class="wrkc-frame" data-rv data-rv-d="80">
      <?php if (!empty($wrk_c['standards'])): ?>
      <div>
        <p class="bdh-ro wrkc-frame__h">Frameworks the delivery was built to</p>
        <ul class="wrkc-frame__b" role="list" aria-label="Frameworks this programme was built to"><?php foreach ($wrk_c['standards'] as $wrk_s) { echo xt_badge($wrk_s, ['variant' => 'chip', 'tag' => 'li']); } ?></ul>
        <p class="wrkc-frame__n">Frameworks delivery is built and audited against. Not certifications held by Xterra Edze.</p>
      </div>
      <?php endif; ?>
      <?php if (!empty($wrk_c['stack'])): ?>
      <div>
        <p class="bdh-ro wrkc-frame__h">Technologies we worked with</p>
        <?= xt_stack($wrk_c['stack'], ['variant' => 'chips', 'size' => 16, 'label' => 'Technologies used on this programme']) ?>
      </div>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php if ($wrk_other): ?>
<section class="band band--alt wrkc-next" id="more" aria-labelledby="more-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Keep going</p>
        <h2 class="h2" id="more-t"><span class="g">Other programmes</span> that share the problem.</h2></div>
      <div><p class="lead">Chosen by sector first, then by the disciplines this one used.</p>
        <a class="tl" href="<?= xe_url('work.php') ?>#programmes">All programmes <span class="i" aria-hidden="true">›</span></a></div>
    </div>
    <ul class="wrkc-next__grid">
      <?php foreach ($wrk_other as $wrk_i => $wrk_o): ?>
      <li class="wrkc-nx bdh-zoom" data-rv data-rv-d="<?= 40 * $wrk_i ?>">
        <a href="<?= xe_url('work/' . $wrk_o['slug'] . '.php') ?>">
          <?= wrk_img($wrk_o['img'], ['ratio' => 'r43', 'class' => 'wrkc-nx__img', 'tag' => 'span',
              'inner' => '<span class="wrk-card__sector bdh-ro">' . e($WRK['industries'][$wrk_o['industry']]) . '</span>']) ?>
          <span class="wrkc-nx__b">
            <span class="wrkc-nx__t"><?= e($wrk_o['title']) ?></span>
            <span class="wrkc-nx__d"><?= e($wrk_o['brief']) ?></span>
            <span class="tl">Read the case<span class="i" aria-hidden="true">›</span></span>
          </span>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
<?php endif; ?>

<?php include __DIR__ . '/../cta.php'; ?>
</main>

<script type="application/ld+json"><?= json_encode(array_filter([
    '@context'    => 'https://schema.org',
    '@type'       => 'CreativeWork',
    'name'        => $wrk_c['title'],
    'description' => $wrk_c['brief'],
    'about'       => $wrk_sect,
    'creator'     => ['@type' => 'Organization', 'name' => $SITE['company']['name']],
    'isPartOf'    => ['@type' => 'CollectionPage', 'name' => 'Work — ' . $SITE['company']['name'], 'url' => xe_url('work.php')],
]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?php include __DIR__ . '/../footer.php'; ?>
