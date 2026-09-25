<?php /* DRAFT COPY — review before launch */
/* Start — the three shapes a category engagement takes, what each one hands over, and what we need from
   you to run it. The only card grid on the page, and the page's commercial step. Static, no JavaScript.
   PLACEHOLDER: every duration comes from data/industries.php and is typical, not promised. */
$ind_start = $IND['start'];
$ind_need = [
    ['A named owner', 'One person on your side who can decide, not only relay. Category work stalls on approval, never on effort.'],
    ['Access to the system of record', 'Read access to whatever holds the truth: the property system, the core platform, the catalogue, the analytics.'],
    ['Twelve months of numbers', 'Whatever you already measure, as it is. We take the baseline from your data, not from a benchmark.'],
    ['Whoever signs off compliance', 'In the room from the first week. A design reviewed at the end is a design rebuilt at the end.'],
];
?>
<section class="band ind-start" id="start" aria-labelledby="start-t">
  <div class="wrap">
    <div class="ind-head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>How it starts</p>
        <h2 class="h2" id="start-t"><span class="g">Three ways in,</span> each with a baseline before it.</h2>
      </div>
      <div>
        <p class="lead">Every one of these begins by writing down what is true now. A category engagement that starts without a baseline cannot be argued for at the next budget round, whatever it ships.</p>
        <!-- PLACEHOLDER: confirm durations, and the price ranges we quote against them, before launch -->
        <p class="ind-note">Durations are typical for work of this shape, not a commitment. Scope, price and dates are agreed in writing before anything starts.</p>
      </div>
    </div>

    <ol class="ind-start__grid" data-rv-s data-rv-step="80">
      <?php foreach ($ind_start as $ind_si => $ind_s): ?>
        <li class="ind-start__card">
          <p class="ind-start__k"><span class="ind-num"><?= str_pad((string) ($ind_si + 1), 2, '0', STR_PAD_LEFT) ?></span>Step in</p>
          <h3 class="ind-start__t"><?= e($ind_s[0]) ?></h3>
          <p class="ind-start__len"><?= e($ind_s[1]) ?></p>
          <p class="bdh-d ind-start__d"><?= e($ind_s[2]) ?></p>
          <p class="ind-k ind-start__dk">What you have at the end</p>
          <ul class="bdh-bullets" role="list">
            <?php foreach ($ind_s[3] as $ind_o): ?><li><?= e($ind_o) ?></li><?php endforeach; ?>
          </ul>
        </li>
      <?php endforeach; ?>
    </ol>

    <div class="ind-start__need" data-rv data-rv-d="60">
      <div class="ind-start__nh">
        <p class="ind-k">What we need from you</p>
        <h3 class="ind-start__nt">Four things, and none of them is a brief.</h3>
        <a class="btn btn--ink" href="<?= xe_url('contact.php') ?>">Start with your category <span class="i" aria-hidden="true">›</span></a>
        <a class="tl" href="<?= xe_url('approach.php') ?>">How we work <span class="i" aria-hidden="true">›</span></a>
      </div>
      <div class="ind-led ind-start__nl">
        <?php foreach ($ind_need as $ind_nd): ?>
          <p><b><?= e($ind_nd[0]) ?></b><span><?= e($ind_nd[1]) ?></span></p>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
