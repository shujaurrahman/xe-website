<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* 25 — Offer: "choose the work, then the package".
   A brief builder over the shared services data. Step 01 lists every discipline's named services
   (data/services/<discipline>.php, the hub page's catalogue), grouped by that hub's categories.
   Step 02 compares the six engagement packages (data/services/packages.php) in one table.
   Step 03 posts the choices to the contact page, which pre-fills its form: the same lead-tagged
   flow the services catalogue uses (intent=select, service[]=<page>:<offer>, package=<key>).

   Progressive enhancement: the form is complete without JavaScript — every discipline's services
   are listed in turn, the checkboxes and radios are real, and "Continue to contact" is a real
   submit. 25-offer.js turns the six lists into tabs, counts picks per discipline, keeps the
   summary bar current and marks the package that most often fits the services ticked.

   Section-scope locals only ($s25_…). xe_section() includes this inside a function, so $SITE is
   read from $GLOBALS. No prices, ever: typical length and pricing model only. */
require_once __DIR__ . '/../partials/services/lib.php';

$s25_site  = (isset($GLOBALS['SITE']) && is_array($GLOBALS['SITE'])) ? $GLOBALS['SITE'] : (require __DIR__ . '/../data/site.php');
$s25_pks   = svc_packages();
$s25_two   = fn (int $s25_n): string => str_pad((string) $s25_n, 2, '0', STR_PAD_LEFT);
$s25_discs = [];
$s25_total = 0;
foreach ($s25_site['disciplines'] as $s25_d) {
    $s25_pg = svc_page($s25_d['slug']);
    if (!$s25_pg) continue;
    $s25_cats = array_values(array_filter($s25_pg['categories'], fn ($s25_x) => !empty($s25_x['offers'])));
    if (!$s25_cats) continue;
    $s25_n = array_sum(array_map(fn ($s25_x) => count($s25_x['offers']), $s25_cats));
    $s25_total += $s25_n;
    /* Point at the hub's own catalogue when the hub has one; otherwise at the hub itself. */
    $s25_file = __DIR__ . '/../services/' . $s25_d['slug'] . '.php';
    $s25_hash = (is_file($s25_file) && strpos((string) file_get_contents($s25_file), 'services/catalogue.php') !== false) ? '#services' : '';
    $s25_discs[] = [
        'd'     => $s25_d,
        'key'   => $s25_pg['key'],
        'cats'  => $s25_cats,
        'n'     => $s25_n,
        'pks'   => array_values(array_filter($s25_pg['packages'], fn ($s25_x) => isset($s25_pks[$s25_x]))),
        'url'   => xe_discipline_url($s25_d) . $s25_hash,
    ];
}
$s25_pkkeys = array_keys($s25_pks);
?>
<?php if ($s25_discs && $s25_pks): ?>
<section class="band s25 bdh" id="offer" aria-labelledby="s25-t" data-s25>
  <div class="wrap">

    <div class="bdh-head bdh-head--row s25-head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Build a brief</p>
        <h2 class="h2" id="s25-t"><span class="g">Choose the work,</span> then the package.</h2>
      </div>
      <div>
        <p class="lead">Every service we sell, by discipline, and the six ways to contract it. Tick what you need, pick a package, and your brief arrives on the contact form already filled in.</p>
        <dl class="s25-facts">
          <div><dt>Disciplines</dt><dd><?= $s25_two(count($s25_discs)) ?></dd></div>
          <div><dt>Services</dt><dd><?= $s25_two($s25_total) ?></dd></div>
          <div><dt>Packages</dt><dd><?= $s25_two(count($s25_pks)) ?></dd></div>
        </dl>
      </div>
    </div>

    <?php /* Posted, not linked, exactly like the services catalogue: a brief of many services would
             make a very long query string. 'intent=select' tells the contact page to pre-fill,
             not to send. 'from' tags the lead with where it started. */ ?>
    <form class="s25-form" action="<?= e(xe_url('contact.php')) ?>" method="post" data-s25-form>
      <input type="hidden" name="intent" value="select">
      <input type="hidden" name="from" value="home">

      <!-- ── 01 · the work ─────────────────────────────────────────────── -->
      <div class="s25-step" data-rv>
        <div class="s25-step__h">
          <span class="s25-step__n" aria-hidden="true">01</span>
          <h3 class="s25-step__t" id="s25-s1">Choose the work</h3>
          <p class="s25-step__d">Tick any services, in as many disciplines as the brief needs.</p>
        </div>

        <?php /* Hidden until 25-offer.js runs: without it, every discipline below is listed in turn. */ ?>
        <div class="s25-tabs" role="tablist" aria-labelledby="s25-s1" data-s25-tabs hidden>
          <?php foreach ($s25_discs as $s25_i => $s25_x): ?>
            <button class="s25-tab" type="button" role="tab" id="s25-t-<?= e($s25_x['d']['slug']) ?>"
                    aria-controls="s25-p-<?= e($s25_x['d']['slug']) ?>" aria-selected="<?= $s25_i === 0 ? 'true' : 'false' ?>"
                    tabindex="<?= $s25_i === 0 ? '0' : '-1' ?>" data-s25-tab="<?= e($s25_x['d']['slug']) ?>">
              <span class="s25-tab__n" aria-hidden="true"><?= e($s25_x['d']['n']) ?></span>
              <span class="s25-tab__name"><?= e($s25_x['d']['name']) ?></span>
              <span class="s25-tab__c"><span class="sr">, </span><?= (int) $s25_x['n'] ?> services</span>
              <span class="s25-tab__pick" data-s25-tabpick hidden></span>
            </button>
          <?php endforeach; ?>
        </div>

        <!-- PLACEHOLDER: every service timeline below is typical, from data/services/*.php — confirm before launch -->
        <div class="s25-panes">
          <?php foreach ($s25_discs as $s25_i => $s25_x): $s25_slug = $s25_x['d']['slug']; ?>
            <div class="s25-pane" id="s25-p-<?= e($s25_slug) ?>" data-s25-pane="<?= e($s25_slug) ?>">
              <div class="s25-pane__head">
                <div class="s25-pane__id">
                  <span class="s25-pane__n" aria-hidden="true"><?= e($s25_x['d']['n']) ?></span>
                  <h4 class="s25-pane__t" id="s25-h-<?= e($s25_slug) ?>"><?= e($s25_x['d']['name']) ?></h4>
                  <p class="s25-pane__m"><?= (int) $s25_x['n'] ?> services · <?= count($s25_x['cats']) ?> categories</p>
                </div>
                <div class="s25-pane__side">
                  <p class="s25-pane__pk"><span class="s25-pane__pkk">Packages that apply</span>
                    <span class="s25-pane__pkl"><?php foreach ($s25_x['pks'] as $s25_pi => $s25_p): ?><span class="s25-pane__pki"><?= e($s25_pks[$s25_p]['name']) ?></span><?php endforeach; ?></span>
                  </p>
                  <a class="tl s25-pane__go" href="<?= e($s25_x['url']) ?>">Every service in detail<span class="sr"> on the <?= e($s25_x['d']['name']) ?> page</span> <span class="i" aria-hidden="true">›</span></a>
                </div>
              </div>

              <div class="s25-grps s25-grps--<?= count($s25_x['cats']) ?>">
                <?php foreach ($s25_x['cats'] as $s25_ci => $s25_c): $s25_gid = 's25-g-' . $s25_slug . '-' . $s25_c['key']; ?>
                  <div class="s25-grp">
                    <p class="s25-grp__k" id="<?= e($s25_gid) ?>"><span class="s25-grp__n" aria-hidden="true"><?= $s25_two($s25_ci + 1) ?></span><?= e($s25_c['name']) ?></p>
                    <ul class="s25-list" aria-labelledby="s25-h-<?= e($s25_slug) ?> <?= e($s25_gid) ?>">
                      <?php foreach ($s25_c['offers'] as $s25_o): $s25_id = $s25_x['key'] . ':' . $s25_o['key']; ?>
                        <li>
                          <label class="s25-svc">
                            <input class="s25-svc__in" type="checkbox" name="service[]" value="<?= e($s25_id) ?>"
                                   data-s25-svc data-d="<?= e($s25_slug) ?>" data-name="<?= e($s25_o['name']) ?>" data-time="<?= e($s25_o['time'] ?? '') ?>">
                            <span class="s25-svc__box" aria-hidden="true"><?= svc_icon('tick', ['size' => 12]) ?></span>
                            <span class="s25-svc__n"><?= e($s25_o['name']) ?></span>
                            <?php if (!empty($s25_o['time'])): ?>
                              <span class="s25-svc__t"><span class="sr">, typically </span><?= e($s25_o['time']) ?></span>
                            <?php endif; ?>
                          </label>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <p class="s25-note">Timelines are typical. Every quote follows a written scope.</p>
      </div>

      <!-- ── 02 · the package ──────────────────────────────────────────── -->
      <fieldset class="s25-step s25-step--pk" data-rv>
        <legend class="sr">Choose the package</legend>
        <div class="s25-step__h">
          <span class="s25-step__n" aria-hidden="true">02</span>
          <h3 class="s25-step__t" id="s25-s2">Then the package</h3>
          <p class="s25-step__d">Six ways to contract the same team. Each shows how it is priced; the amount follows a written scope.</p>
        </div>

        <!-- PLACEHOLDER: package lengths are typical (data/services/packages.php) — confirm before launch -->
        <div class="s25-cmp bdh-scroll-x mask-x" tabindex="0" role="region" aria-label="Engagement packages compared. Scroll sideways on small screens." data-s25-cmp>
          <table class="s25-tbl">
            <caption class="bdh-sr">The six engagement packages compared by typical length, pricing model, what every engagement includes and who each suits. Lengths are typical. Choose one with the control in its column heading.</caption>
            <thead>
              <tr>
                <th scope="col" class="s25-tbl__h0"><span class="s25-tbl__h0k">Package</span></th>
                <?php foreach ($s25_pkkeys as $s25_pi => $s25_k): $s25_p = $s25_pks[$s25_k]; ?>
                  <th scope="col" class="s25-tbl__ph" data-col="<?= e($s25_k) ?>">
                    <label class="s25-pk">
                      <input class="s25-pk__in" type="radio" name="package" value="<?= e($s25_k) ?>" aria-labelledby="s25-pk-<?= e($s25_k) ?>-n" aria-describedby="s25-pk-<?= e($s25_k) ?>-d" data-s25-pkg data-name="<?= e($s25_p['name']) ?>">
                      <span class="s25-pk__top">
                        <span class="s25-pk__ico" aria-hidden="true"><?= svc_icon($s25_p['icon'] ?? 'dot', ['size' => 18]) ?></span>
                        <span class="s25-pk__idx" aria-hidden="true">P·<?= $s25_two($s25_pi + 1) ?></span>
                      </span>
                      <span class="s25-pk__n" id="s25-pk-<?= e($s25_k) ?>-n"><?= e($s25_p['name']) ?></span>
                      <span class="s25-pk__pick" aria-hidden="true"><span class="s25-pk__radio"></span><span class="s25-pk__off">Choose</span><span class="s25-pk__on">Chosen</span></span>
                      <span class="s25-pk__tag" id="s25-pk-<?= e($s25_k) ?>-d"><?= e($s25_p['tagline']) ?></span>
                    </label>
                    <span class="s25-pk__fit" data-s25-fit hidden>Likely fit</span>
                  </th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row" class="s25-tbl__rh">Typical length</th>
                <?php foreach ($s25_pkkeys as $s25_k): ?><td data-col="<?= e($s25_k) ?>"><span class="s25-tbl__fig"><?= e($s25_pks[$s25_k]['duration']) ?></span></td><?php endforeach; ?>
              </tr>
              <tr>
                <th scope="row" class="s25-tbl__rh">Pricing model</th>
                <?php foreach ($s25_pkkeys as $s25_k): ?><td data-col="<?= e($s25_k) ?>"><span class="s25-tbl__fig"><?= e($s25_pks[$s25_k]['pricing']) ?></span></td><?php endforeach; ?>
              </tr>
              <tr>
                <th scope="row" class="s25-tbl__rh">Always included</th>
                <?php foreach ($s25_pkkeys as $s25_k): ?>
                  <td data-col="<?= e($s25_k) ?>">
                    <ul class="s25-tbl__inc">
                      <?php foreach ($s25_pks[$s25_k]['includes'] as $s25_y): ?><li><?= e($s25_y) ?></li><?php endforeach; ?>
                    </ul>
                  </td>
                <?php endforeach; ?>
              </tr>
              <tr>
                <th scope="row" class="s25-tbl__rh">Best for</th>
                <?php foreach ($s25_pkkeys as $s25_k): ?><td data-col="<?= e($s25_k) ?>"><span class="s25-tbl__best"><?= e($s25_pks[$s25_k]['best']) ?></span></td><?php endforeach; ?>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="s25-pkfoot">
          <label class="s25-unsure">
            <input class="s25-unsure__in" type="radio" name="package" value="" checked data-s25-pkg data-name="">
            <span class="s25-unsure__radio" aria-hidden="true"></span>
            <span>Not sure yet. <span class="s25-unsure__d">We will recommend one before any scope is written.</span></span>
          </label>
          <p class="s25-fitnote" data-s25-fitnote hidden><b>Likely fit</b> is read from the typical length of the services you ticked. It is a starting point, not a rule.</p>
        </div>
      </fieldset>

      <!-- ── 03 · send ─────────────────────────────────────────────────── -->
      <div class="s25-send" role="region" aria-labelledby="s25-s3" data-s25-send>
        <div class="s25-send__in">
          <div class="s25-send__h">
            <span class="s25-step__n" aria-hidden="true">03</span>
            <h3 class="s25-send__t" id="s25-s3">Your brief</h3>
          </div>
          <dl class="s25-sum">
            <div><dt>Services</dt><dd data-s25-count>As ticked above</dd></div>
            <div><dt>Package</dt><dd><span class="s25-sum__pre" aria-hidden="true">Package · </span><span data-s25-pkname>As chosen above</span></dd></div>
          </dl>
          <p class="s25-send__names" data-s25-names hidden></p>
          <div class="s25-send__go">
            <button class="s25-send__clear" type="button" data-s25-clear hidden>Clear</button>
            <button class="btn btn--ink s25-send__btn" type="submit">Continue<span class="s25-send__x"> to contact</span> <span class="i" aria-hidden="true">›</span></button>
          </div>
        </div>
        <p class="sr" aria-live="polite" data-s25-live></p>
      </div>
      <p class="s25-send__hint">Your choices pre-fill the contact form. Nothing is sent until you add your details there. <a class="s25-send__alt" href="<?= e(xe_url('contact.php')) ?>">Or describe the problem in your own words</a></p>
    </form>

  </div>
</section>
<?php endif; ?>
