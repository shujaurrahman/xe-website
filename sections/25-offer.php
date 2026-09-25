<?php /* DRAFT COPY — review before launch */ ?>
<?php
/**
 * 25-offer — the route into the catalogue.
 *
 * Deliberately plain. The full catalogue is a real component with tabs, a brief tray
 * and a package picker (partials/services/catalogue.php), and it belongs on the
 * discipline pages where someone is already deciding. On the home page it only has to
 * do one thing: show that every service is priced and listed somewhere, and point at
 * the right shelf. So this is six rows and two buttons — no tabs, no tray, no stat
 * wall, nothing to operate.
 *
 * 18-engagements already explains the three ways of working, so this section does not
 * re-explain them; it counts them and links on.
 *
 * Every number here is derived from data/services/*.php through the shared lib, so it
 * cannot drift from the catalogue it is describing.
 *
 * Locals are prefixed s25_ — index.php loops with $s and the chrome uses
 * $c $d $i $k $item $url $current $disc $col $l, so none of those may be touched.
 *
 * $SITE is imported explicitly: xe_section() includes this file from inside a
 * function, so the page's variables are not in scope here — only globals are.
 */
global $SITE;

require_once __DIR__ . '/../partials/services/lib.php';

$s25_rows  = [];
$s25_total = 0;
foreach ($SITE['disciplines'] as $s25_disc) {
    $s25_page = svc_page($s25_disc['slug']);
    if (!$s25_page) continue;                       // a discipline with no catalogue file yet is simply not listed
    $s25_cats = array_values(array_filter($s25_page['categories'], fn ($x) => !empty($x['offers'])));
    $s25_n    = array_sum(array_map(fn ($x) => count($x['offers']), $s25_cats));
    $s25_total += $s25_n;
    $s25_rows[] = [
        'n'     => $s25_disc['n'],
        'name'  => $s25_disc['name'],
        'url'   => xe_discipline_url($s25_disc),
        'count' => $s25_n,
        'cats'  => count($s25_cats),
    ];
}
$s25_packs = count(svc_packages());
?>
<section class="band band--rules bdh s25" id="offer" aria-labelledby="s25-t">
  <div class="wrap">

    <div class="bdh-head s25__head" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>Build a brief</p>
      <h2 class="h2" id="s25-t"><span class="g">Choose the work.</span> Then choose the contract.</h2>
      <p class="lead s25__lead">Every service we sell is listed on its discipline page, with the ways
        of working it can be bought on. Pick what you need there and your brief arrives with us
        already filled in.</p>
    </div>

    <ul class="s25__list" data-rv-s data-rv-step="50">
      <?php foreach ($s25_rows as $s25_row): ?>
        <li class="s25__row">
          <a class="s25__link" href="<?= $s25_row['url'] ?>">
            <span class="s25__n" aria-hidden="true"><?= e($s25_row['n']) ?></span>
            <span class="s25__name"><?= e($s25_row['name']) ?></span>
            <span class="s25__c">
              <?= (int) $s25_row['count'] ?> services<span class="s25__cs"> in <?= (int) $s25_row['cats'] ?> categories</span>
            </span>
            <span class="s25__go" aria-hidden="true">›</span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="s25__foot" data-rv data-rv-d="80">
      <p class="s25__sum">
        <?= (int) $s25_total ?> services across <?= count($s25_rows) ?> disciplines,
        on <?= (int) $s25_packs ?> ways of working.
      </p>
      <div class="s25__acts">
        <a class="btn btn--ink" href="<?= xe_url('services/') ?>">Browse every service <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out" href="<?= xe_url('contact.php') ?>">Describe the problem instead</a>
      </div>
    </div>

  </div>
</section>
