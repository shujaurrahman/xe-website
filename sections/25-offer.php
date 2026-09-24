<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* 25 — Offer: "choose the work, then the contract".
   A brief builder over the shared services data. Step 01 lists every discipline's named services
   (data/services/<discipline>.php, the hub page's catalogue), grouped by that hub's categories.
   Step 02 sets the six contracts (data/services/packages.php) against the three ways of working
   that 18-engagements shows directly above. Step 03 posts the choices to the contact page, which
   pre-fills its form: the same lead-tagged flow the services catalogue uses
   (intent=select, service[]=<page>:<offer>, package=<key>).

   Progressive enhancement. Without JavaScript: each discipline is a native <details> (the first
   open, the rest one click away; boxes inside a closed <details> still submit), the comparison
   table sits open under six radio cards on phones, and "Continue to contact" is a real submit.
   25-offer.js upgrades the disciplines to a tablist at ≥769px (an exclusive accordion below),
   collapses the comparison on phones, keeps the brief bar current and offers a "Likely fit".

   Two sets of package radios share name="package": the table's (JS, ≥769px) and the cards' (phones, and
   every width without JS). With JS the hidden set is disabled so exactly one set submits; without JS
   they act as one group.

   Section-scope locals only ($s25_…). xe_section() includes this inside a function, so $SITE is
   read from $GLOBALS. No prices, ever: typical length and pricing model only. */
require_once __DIR__ . '/../partials/services/lib.php';

$s25_site  = (isset($GLOBALS['SITE']) && is_array($GLOBALS['SITE'])) ? $GLOBALS['SITE'] : (require __DIR__ . '/../data/site.php');
$s25_pks   = svc_packages();
$s25_two   = fn (int $s25_n): string => str_pad((string) $s25_n, 2, '0', STR_PAD_LEFT);
/* A short timeline for display ("4–6 wk", "4–6 wk + ongoing", "Ongoing"). Screen readers and data-time keep the full text. */
$s25_wk    = function (string $s25_t): string {
    if (preg_match('~^\s*(ongoing|start in)~i', $s25_t) || !preg_match('~(\d+(?:–\d+)?)\s*weeks?~', $s25_t, $s25_m)) return 'Ongoing';
    return $s25_m[1] . ' wk' . (preg_match('~then|ongoing|monthly|quarterly~i', $s25_t) ? ' + ongoing' : '');
};
/* How each contract maps onto the three ways of working in 18-engagements. Section-local on purpose:
   packages.php stays the site-wide source for the contracts themselves. */
$s25_way   = ['sprint' => 'Sprint', 'project' => 'Program', 'milestone' => 'Program', 'retainer' => 'After launch', 'enterprise' => 'Program', 'squad' => 'Embedded squad'];
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
    $s25_cat  = is_file($s25_file) && strpos((string) file_get_contents($s25_file), 'services/catalogue.php') !== false;
    $s25_pkl  = array_values(array_filter($s25_pg['packages'], fn ($s25_x) => isset($s25_pks[$s25_x])));
    $s25_discs[] = [
        'd'    => $s25_d,
        'key'  => $s25_pg['key'],
        'cats' => $s25_cats,
        'n'    => $s25_n,
        'pks'  => count($s25_pkl) < count($s25_pks) ? $s25_pkl : [],   // listed only when some do not apply
        'url'  => xe_discipline_url($s25_d) . ($s25_cat ? '#services' : ''),
        'link' => $s25_cat ? 'Every ' . $s25_d['name'] . ' service in detail' : 'About ' . $s25_d['name'],
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
        <h2 class="h2" id="s25-t"><span class="g">Choose the work,</span> then the contract.</h2>
      </div>
      <div>
        <p class="lead">Every service we sell, and the contract each way of working is written on. Tick what you need, pick one, and your brief arrives on the contact form already filled in.</p>
        <dl class="s25-facts">
          <div><dt>Disciplines</dt><dd><?= $s25_two(count($s25_discs)) ?></dd></div>
          <div><dt>Services</dt><dd><?= $s25_two($s25_total) ?></dd></div>
          <div><dt>Contracts</dt><dd><?= $s25_two(count($s25_pks)) ?></dd></div>
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
          <p class="s25-step__d">Tick any services, in as many disciplines as the brief needs. Timelines are typical; every quote follows a written scope.</p>
        </div>

        <?php /* Shown by 25-offer.js at ≥769px only. Each tab opens its discipline's <details>. */ ?>
        <div class="s25-tabs" role="tablist" aria-labelledby="s25-s1" data-s25-tabs hidden>
          <?php foreach ($s25_discs as $s25_i => $s25_x): ?>
            <button class="s25-tab" type="button" role="tab" id="s25-t-<?= e($s25_x['d']['slug']) ?>"
                    aria-controls="s25-p-<?= e($s25_x['d']['slug']) ?>" aria-selected="<?= $s25_i === 0 ? 'true' : 'false' ?>"
                    tabindex="<?= $s25_i === 0 ? '0' : '-1' ?>" data-s25-tab="<?= e($s25_x['d']['slug']) ?>">
              <span class="s25-tab__top"><span class="s25-tab__n" aria-hidden="true"><?= e($s25_x['d']['n']) ?></span><span class="s25-tab__c" aria-hidden="true"><?= (int) $s25_x['n'] ?> services</span></span>
              <span class="s25-tab__name"><?= e($s25_x['d']['name']) ?><span class="sr">, <?= (int) $s25_x['n'] ?> services</span></span>
              <span class="s25-pick" data-s25-pick="<?= e($s25_x['d']['slug']) ?>" hidden><span aria-hidden="true" data-s25-pickn></span><span class="sr" data-s25-picksr></span></span>
            </button>
          <?php endforeach; ?>
        </div>

        <!-- PLACEHOLDER: every service timeline below is typical, from data/services/*.php — confirm before launch -->
        <div class="s25-panes" data-s25-panes>
          <?php foreach ($s25_discs as $s25_i => $s25_x): $s25_slug = $s25_x['d']['slug']; ?>
            <details class="s25-disc" name="s25-disc" data-s25-disc="<?= e($s25_slug) ?>"<?= $s25_i === 0 ? ' open' : '' ?>>
              <summary class="s25-disc__s">
                <span class="s25-disc__n" aria-hidden="true"><?= e($s25_x['d']['n']) ?></span>
                <h4 class="s25-disc__t" id="s25-h-<?= e($s25_slug) ?>"><?= e($s25_x['d']['name']) ?></h4>
                <span class="s25-disc__c"><span class="sr">, </span><?= (int) $s25_x['n'] ?> services</span>
                <span class="s25-pick" data-s25-pick="<?= e($s25_slug) ?>" hidden><span aria-hidden="true" data-s25-pickn></span><span class="sr" data-s25-picksr></span></span>
                <span class="s25-disc__chev" aria-hidden="true"></span>
              </summary>
              <div class="s25-disc__b s25-disc__b--<?= count($s25_x['cats']) ?>" id="s25-p-<?= e($s25_slug) ?>">
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
                              <span class="s25-svc__t"><span class="sr">, typically <?= e($s25_o['time']) ?></span><span aria-hidden="true"><?= e($s25_wk($s25_o['time'])) ?></span></span>
                            <?php endif; ?>
                          </label>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                <?php endforeach; ?>
                <div class="s25-disc__f">
                  <?php if ($s25_x['pks']): ?>
                    <p class="s25-disc__pk">Contracts that apply: <?= e(implode(' · ', array_map(fn ($s25_p) => $s25_pks[$s25_p]['name'], $s25_x['pks']))) ?></p>
                  <?php endif; ?>
                  <a class="tl s25-disc__go" href="<?= e($s25_x['url']) ?>"><?= e($s25_x['link']) ?> <span class="i" aria-hidden="true">›</span></a>
                </div>
              </div>
            </details>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- ── 02 · the contract ─────────────────────────────────────────── -->
      <fieldset class="s25-step s25-step--pk" data-rv>
        <legend class="sr">Choose the contract</legend>
        <div class="s25-step__h">
          <span class="s25-step__n" aria-hidden="true">02</span>
          <h3 class="s25-step__t" id="s25-s2">Then the contract</h3>
          <p class="s25-step__d">The three ways to work above, written as contracts. A Program is scoped as a Project, a Milestone plan or an Enterprise programme depending on its size; an Embedded squad is contracted as a Squad; a Retainer keeps any of them running after launch.</p>
        </div>

        <!-- PLACEHOLDER: contract lengths are typical (data/services/packages.php) — confirm before launch -->
        <?php /* One radio card per contract: phones, and every width without JS. With JS at ≥769px the
                 table's own column controls take over and these are hidden. */ ?>
        <ul class="s25-cards" role="list">
          <?php foreach ($s25_pkkeys as $s25_pi => $s25_k): $s25_p = $s25_pks[$s25_k]; ?>
            <li class="s25-card" data-col="<?= e($s25_k) ?>">
              <label class="s25-card__l">
                <input class="s25-card__in" type="radio" name="package" value="<?= e($s25_k) ?>" data-s25-pkg data-s25-set="cards" data-name="<?= e($s25_p['name']) ?>"
                       aria-describedby="s25-c-<?= e($s25_k) ?>-m s25-c-<?= e($s25_k) ?>-d">
                <span class="s25-card__radio" aria-hidden="true"></span>
                <span class="s25-card__top">
                  <span class="s25-card__n"><?= e($s25_p['name']) ?></span>
                  <span class="s25-card__way"><span class="sr">Way of working: </span><?= e($s25_way[$s25_k] ?? '') ?></span>
                  <span class="s25-fit" data-s25-fit hidden>Likely fit</span>
                </span>
                <span class="s25-card__m" id="s25-c-<?= e($s25_k) ?>-m"><?= e($s25_p['duration']) ?> · <?= e($s25_p['pricing']) ?></span>
                <span class="s25-card__d" id="s25-c-<?= e($s25_k) ?>-d"><?= e($s25_p['tagline']) ?></span>
              </label>
            </li>
          <?php endforeach; ?>
        </ul>

        <?php /* Folded by default under the cards; with JS at ≥769px it is opened and its summary hidden. */ ?>
        <details class="s25-cmpd" data-s25-cmpd>
          <summary class="s25-cmpd__s">Compare all six in detail<span class="s25-disc__chev" aria-hidden="true"></span></summary>
          <div class="s25-cmp bdh-scroll-x mask-x" tabindex="0" role="region" aria-label="Contracts compared. Scroll sideways on small screens." data-s25-cmp>
            <table class="s25-tbl">
              <caption class="bdh-sr">The six contracts compared by way of working, typical length and pricing model, what every engagement includes and who each suits. Lengths are typical. On wider screens, choose one with the control in its column heading.</caption>
              <thead>
                <tr>
                  <th scope="col" class="s25-tbl__h0"><span class="s25-tbl__h0k">Contract</span></th>
                  <?php foreach ($s25_pkkeys as $s25_pi => $s25_k): $s25_p = $s25_pks[$s25_k]; ?>
                    <th scope="col" class="s25-tbl__ph" data-col="<?= e($s25_k) ?>">
                      <label class="s25-pk">
                        <input class="s25-pk__in" type="radio" name="package" value="<?= e($s25_k) ?>" aria-labelledby="s25-pk-<?= e($s25_k) ?>-n" aria-describedby="s25-pk-<?= e($s25_k) ?>-d"
                               data-s25-pkg data-s25-set="table" data-name="<?= e($s25_p['name']) ?>">
                        <span class="s25-pk__n" id="s25-pk-<?= e($s25_k) ?>-n"><?= e($s25_p['name']) ?></span>
                        <span class="s25-pk__pick" aria-hidden="true"><span class="s25-pk__radio"></span><span class="s25-pk__off">Choose</span><span class="s25-pk__on">Chosen</span></span>
                        <span class="s25-pk__tag" id="s25-pk-<?= e($s25_k) ?>-d"><?= e($s25_p['tagline']) ?></span>
                      </label>
                      <span class="s25-fit" data-s25-fit hidden>Likely fit</span>
                    </th>
                  <?php endforeach; ?>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row" class="s25-tbl__rh">Way of working</th>
                  <?php foreach ($s25_pkkeys as $s25_k): ?><td data-col="<?= e($s25_k) ?>"><span class="s25-tbl__way"><?= e($s25_way[$s25_k] ?? '—') ?></span></td><?php endforeach; ?>
                </tr>
                <tr>
                  <th scope="row" class="s25-tbl__rh">Length<span class="s25-tbl__rs"> · pricing</span></th>
                  <?php foreach ($s25_pkkeys as $s25_k): ?><td data-col="<?= e($s25_k) ?>"><span class="s25-tbl__fig"><span class="sr">Typical length: </span><?= e($s25_pks[$s25_k]['duration']) ?></span><span class="s25-tbl__fig s25-tbl__fig--p"><span class="sr">Pricing model: </span><?= e($s25_pks[$s25_k]['pricing']) ?></span></td><?php endforeach; ?>
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
        </details>

        <div class="s25-pkfoot">
          <label class="s25-unsure">
            <input class="s25-unsure__in" type="radio" name="package" value="" checked data-s25-pkg data-name="">
            <span class="s25-unsure__radio" aria-hidden="true"></span>
            <span>Not sure yet. <span class="s25-unsure__d">We will recommend one before any scope is written.</span></span>
          </label>
          <p class="s25-fitnote" data-s25-fitnote hidden><b>Likely fit</b> is read from the typical length of the services you ticked. A starting point, not a rule.</p>
        </div>
      </fieldset>

      <!-- ── 03 · send ─────────────────────────────────────────────────── -->
      <div class="s25-send" role="region" aria-labelledby="s25-s3" data-s25-send>
        <div class="s25-send__in">
          <div class="s25-send__h">
            <span class="s25-step__n" aria-hidden="true">03</span>
            <h3 class="s25-send__t" id="s25-s3">Your brief</h3>
          </div>
          <div class="s25-send__meta">
            <dl class="s25-sum">
              <div><dt>Services</dt><dd data-s25-count>As ticked above</dd></div>
              <div><dt>Contract</dt><dd><span class="s25-sum__pre" aria-hidden="true">Contract · </span><span data-s25-pkname>As chosen above</span></dd></div>
            </dl>
            <p class="s25-send__hint">Nothing is sent until you add your details.</p>
          </div>
          <p class="s25-send__names" data-s25-names hidden></p>
          <button class="s25-send__fit" type="button" data-s25-fitbtn hidden><span class="s25-send__fk">Likely fit</span><span class="sr">: </span><b data-s25-fitname></b><span class="sr">. Choose it.</span></button>
          <div class="s25-send__go">
            <button class="s25-send__clear" type="button" data-s25-clear hidden>Clear</button>
            <button class="btn btn--ink s25-send__btn" type="submit"><span>Continue<span class="s25-send__x"> to contact</span></span><span class="i" aria-hidden="true">›</span></button>
          </div>
        </div>
        <p class="sr" aria-live="polite" data-s25-live></p>
      </div>
      <p class="s25-send__hint2">Nothing is sent until you add your details.</p>
    </form>

  </div>
</section>
<?php endif; ?>
