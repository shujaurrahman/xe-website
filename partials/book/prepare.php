<?php /* DRAFT COPY — review before launch */
/**
 * Book · prepare — what to have ready, as a prep sheet rather than a homework list.
 *
 * Each row carries its own honesty tag (Needed / Helps / Optional), so the page never implies that
 * four items are a gate on booking. The panel beside it exists for the reader who has none of them,
 * because that reader is the one most likely to close the tab.
 *
 * Requires $BK (book.php). Locals are prefixed pr_.
 */
$pr_items = [
    ['Needed', 'One sentence on what you want to change',
     'The change, not the project. “Renewals have gone flat” is a far more useful opening than “we need a new website”.'],
    ['Needed', 'The constraint that actually binds',
     'A launch date, a budget ceiling, a platform you cannot leave, a compliance review you have to pass. One real constraint shapes the answer more than a full requirements list.'],
    ['Helps', 'Who decides, and when they next meet',
     'It sets whether the answer we give you is useful this quarter or next, and whether the first step should be a pilot or a paper.'],
    ['Optional', 'Anything already written',
     'A brief, a deck, a backlog, a URL, a dashboard that is telling you something bad. Attach it to the booking or bring it up on the call.'],
];
?>
<section class="band band--alt bk-pr" id="prepare" aria-labelledby="prepare-t">
  <div class="wrap">

    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Before the call</p>
        <h2 class="h2" id="prepare-t"><span class="g">Four things worth having ready.</span> None of them is a deck.</h2>
      </div>
      <div>
        <p class="lead">Two of them change the quality of the half hour. The other two only make it
          faster. Nothing here is a condition of booking.</p>
      </div>
    </div>

    <div class="bdh-grid bk-pr__grid">

      <div class="bdh-c8 bk-pr__sheet" data-rv data-rv-d="50">
        <div class="bk-pr__head">
          <span class="bk-k">Prep sheet</span>
          <span class="bk-k bk-pr__count"><?= count($pr_items) ?> items · <?= (int) $BK['mins'] ?> minutes</span>
        </div>
        <ol class="bk-pr__list">
          <?php foreach ($pr_items as $pr_i => $pr_it): ?>
            <li class="bk-pr__row">
              <span class="bk-num bk-pr__n" aria-hidden="true"><?= str_pad((string) ($pr_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <div class="bk-pr__body">
                <h3 class="bdh-t bdh-t--s"><?= e($pr_it[1]) ?></h3>
                <p class="bdh-d bk-pr__d"><?= e($pr_it[2]) ?></p>
              </div>
              <span class="bk-pr__tag bk-pr__tag--<?= e(strtolower($pr_it[0])) ?>"><?= e($pr_it[0]) ?></span>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>

      <aside class="bdh-c4 bk-pr__side" aria-labelledby="prepare-none" data-rv data-rv-d="90">
        <div class="bk-pr__none">
          <span class="bk-pr__ico" aria-hidden="true"><?= xt_icon('lightbulb') ?></span>
          <h3 class="bdh-t" id="prepare-none">None of it ready? Book anyway.</h3>
          <p>Thirty minutes of the right questions is often how the brief gets written in the first
            place. Arriving with a problem and no plan is a perfectly good reason to be on the call.</p>
          <p class="bk-pr__nonef">If you would rather write it down first, the brief form takes the shape
            of the work and reaches the same lead.</p>
          <div class="bk-pr__acts">
            <a class="btn btn--out btn--sm" href="<?= xe_url('contact.php') ?>">Send a written brief <span class="i" aria-hidden="true">›</span></a>
            <a class="tl" href="#scheduler">Back to the calendar <span class="i" aria-hidden="true">›</span></a>
          </div>
        </div>
      </aside>

    </div>
  </div>
</section>
