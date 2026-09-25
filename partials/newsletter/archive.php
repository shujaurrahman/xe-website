<?php /* DRAFT COPY — review before launch */
/* The archive — which is empty, and says so. The three rows below are the sample issues the format was
   designed against; every one of them is marked as a sample, carries no issue number and no date, and
   links to nothing, because linking to a page that does not exist is the one thing an archive must
   never do. Replace this list with real issues once the first one is sent, or empty 'archive' in
   data/newsletter.php and the honest empty state below is all that renders. */
$arc_rows = $NLT['archive'];
/* the desk marks used across the site's journal, mapped from the desk name on each row */
$arc_marks = ['Technology & Intelligence desk' => 'T&I', 'Product & Experience desk' => 'P&E', 'Marketing Technology desk' => 'MT'];
$arc_topics = $NLT['topics'];
?>
<section class="band nlt-arc" id="archive" aria-labelledby="archive-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The archive</p>
        <h2 class="h2" id="archive-t"><span class="g">There is nothing in it yet,</span> which is the honest state of it.</h2>
      </div>
      <div>
        <p class="lead">Every issue is published here as a web page on the day it is sent, in full, with nothing
          held back for subscribers. Until the first one goes out, the shelf below holds the three sample issues
          the format was designed against.</p>
      </div>
    </div>

    <!-- PLACEHOLDER: the three entries below are sample issues written in-house as a proof of the
         format. Replace them with real issues once the first one is sent, or empty 'archive' in
         data/newsletter.php and the honest empty state renders instead. -->
    <?php if (!$arc_rows): ?>
      <div class="nlt-arc__empty" data-rv>
        <p class="nlt-k">Issues published</p>
        <p class="nlt-arc__zero"><span class="nlt-num">0</span></p>
        <p class="nlt-arc__ep">The first issue has not been sent. When it is, it will appear here the same day.</p>
      </div>
    <?php else: ?>
      <ol class="nlt-arc__shelf" data-rv-s data-rv-step="70">
        <?php foreach ($arc_rows as $arc_i => $arc_r): ?>
          <li class="nlt-arc__i">
            <span class="nlt-arc__plate" aria-hidden="true">
              <span class="nlt-arc__pm"><?= e($arc_marks[$arc_r[2]] ?? '—') ?></span>
              <span class="nlt-arc__pn">Sample <?= str_pad((string) ($arc_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            </span>
            <div class="nlt-arc__b">
              <p class="nlt-arc__meta"><span class="nlt-sample">Sample · not sent</span><span class="nlt-arc__desk"><?= e($arc_r[2]) ?></span></p>
              <h3 class="nlt-arc__t"><?= e($arc_r[0]) ?></h3>
              <p class="nlt-arc__d"><?= e($arc_r[1]) ?></p>
              <ul class="nlt-arc__tags">
                <?php foreach ($arc_r[3] as $arc_k): ?>
                  <li><?= e($arc_topics[$arc_k] ?? $arc_k) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <p class="nlt-arc__no">No date · no issue number</p>
          </li>
        <?php endforeach; ?>
      </ol>
    <?php endif; ?>

    <dl class="nlt-facts nlt-arc__facts" data-rv>
      <div><dt>Published</dt><dd>Every issue, in full, on the day it is sent — no subscriber-only content.</dd></div>
      <div><dt>Corrections</dt><dd>Made in public on the web version, with a date and a line saying what changed.</dd></div>
      <div><dt>Feeds</dt><dd>
        <!-- PLACEHOLDER: decide whether to publish an RSS feed of issues before launch. -->
        No RSS feed for issues yet. The journal is the written record in the meantime.</dd></div>
    </dl>
  </div>
</section>
