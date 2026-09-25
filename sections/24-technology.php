<?php /* DRAFT COPY — review before launch */ ?>
<?php
/**
 * 24-technology — what we build and run.
 *
 * The home page's route into Technology & Intelligence: the ten capabilities, the
 * technologies they are built on, and the frameworks delivery is held to. The one
 * ink band in the body of the page, so the technical half of the company lands with
 * some weight between the two paper bands either side of it.
 *
 * Distinct from what is already on the page: 08-disciplines names these ten inside a
 * tab panel and links every one to #book; 14-platforms is about the platforms we
 * operate on. This section is the only place the home page reaches the ten
 * capability pages themselves.
 *
 * Content: data/technology-intelligence.php (long form, incl. each capability's own
 * stack and standards) and data/site.php (approved names). The stack row and the
 * badges come from the shared kit, which index.php already loads
 * (partials/tech/kit.php + assets/css/tech/kit.css); the kit has explicit
 * .band--ink styling, so the marks invert correctly here.
 *
 * Locals are prefixed s24_ — index.php loops with $s and the chrome uses
 * $c $d $i $k $item $url $current $disc $col $l, so none of those may be touched.
 *
 * $SITE is imported explicitly: xe_section() includes this file from inside a
 * function, so the page's variables are not in scope here — only globals are.
 */
global $SITE;

$s24_caps = require __DIR__ . '/../data/technology-intelligence.php';
$s24_disc = null;
foreach ($SITE['disciplines'] as $s24_row) { if ($s24_row['slug'] === 'technology-intelligence') $s24_disc = $s24_row; }
unset($s24_row);

/* The union of what the ten capabilities are actually built on, most widely used first,
   so the row below is derived from the capability data and can never contradict it. */
$s24_tally = [];
foreach ($s24_caps as $s24_cap) {
    foreach ($s24_cap['stack'] ?? [] as $s24_slug) {
        $s24_tally[$s24_slug] = ($s24_tally[$s24_slug] ?? 0) + 1;
    }
}
arsort($s24_tally);
$s24_stack = array_slice(array_keys($s24_tally), 0, 42);

/* Same for the frameworks delivery is built to — every one of these is claimed as a
   framework we work to, never as a certification Xterra Edze holds. */
$s24_stds = [];
foreach ($s24_caps as $s24_cap) {
    foreach ($s24_cap['standards'] ?? [] as $s24_key) {
        $s24_stds[$s24_key] = ($s24_stds[$s24_key] ?? 0) + 1;
    }
}
arsort($s24_stds);
$s24_stds = array_slice(array_keys($s24_stds), 0, 10);
?>
<section class="band band--ink bdh s24" id="technology" aria-labelledby="s24-t">
  <span class="s24__dots dots-ink" aria-hidden="true"></span>

  <div class="wrap">

    <div class="bdh-head bdh-head--row s24__head" data-rv>
      <div>
        <p class="lbl s24__eyebrow"><span class="dot"></span><?= e($s24_disc['n']) ?> · <?= e($s24_disc['name']) ?></p>
        <h2 class="h2" id="s24-t"><span class="g">Ten capabilities.</span> One system we build and then run.</h2>
      </div>
      <div>
        <p class="lead s24__lead"><?= e($s24_disc['intro']) ?></p>
        <a class="tl s24__all" href="<?= xe_url('services/technology-intelligence.php') ?>">All of Technology &amp; Intelligence <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <ul class="s24__grid" data-rv-s data-rv-step="40">
      <?php foreach ($s24_caps as $s24_slug => $s24_cap): ?>
        <li class="s24__cell">
          <a class="s24__card" href="<?= xe_url('services/technology-intelligence/' . $s24_slug . '.php') ?>">
            <span class="s24__top">
              <span class="s24__ico" aria-hidden="true"><?= xt_icon($s24_cap['icon'], ['size' => 22]) ?></span>
              <span class="s24__n" aria-hidden="true"><?= e($s24_cap['n']) ?></span>
            </span>
            <h3 class="h3 s24__name"><?= e($s24_cap['name']) ?></h3>
            <span class="s24__kicker"><?= e($s24_cap['kicker']) ?></span>
            <span class="s24__go" aria-hidden="true">›</span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="s24__foot">

      <div class="s24__built" data-rv>
        <p class="s24__k">Built on</p>
        <?php /* Technologies we work with — not partnerships, not partner tiers. */ ?>
        <?= xt_stack($s24_stack, [
              'variant' => 'row',
              'marquee' => true,
              'speed'   => 90,
              'size'    => 20,
              'label'   => 'Technologies we work with',
              'class'   => 's24__marquee',
            ]) ?>
      </div>

      <div class="s24__stds" data-rv data-rv-d="80">
        <p class="s24__k">Delivery is built to</p>
        <ul class="s24__badges">
          <?php foreach ($s24_stds as $s24_key): ?>
            <?= xt_badge($s24_key, ['variant' => 'chip', 'tag' => 'li', 'class' => 's24__badge']) ?>
          <?php endforeach; ?>
        </ul>
        <p class="s24__note">Frameworks we build and audit against. Xterra Edze does not claim
          certification against them on your behalf.</p>
      </div>

    </div>

  </div>
</section>
