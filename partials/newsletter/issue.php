<?php /* DRAFT COPY — review before launch */
/**
 * THE SIGNATURE SECTION — a sample issue, opened.
 *
 * Rather than describing what arrives, the issue is here to read. It is framed as a reading pane: the
 * header lines, the six blocks written out in full, and under each block the two lines that make it a
 * contract — why the block exists, and what it will never contain.
 *
 * WITHOUT JAVASCRIPT the whole issue is in reading order inside the frame, every block complete, with
 * its annotation. That is the shipped HTML and it is the finished state.
 * WITH JAVASCRIPT assets/js/newsletter/issue.js adds .is-app, which folds the blocks into one pane at
 * a time and reveals the contents rail beside them as a real tablist: arrow keys, Home / End, roving
 * tabindex, aria-selected and aria-controls, with a live region naming the block as it changes.
 *
 * Every figure in the readout is measured from the text below it, not asserted: the word counts come
 * from counting the words on this page, and the reading time is those words at 210 words a minute —
 * the same rate partials/blog/lib.php uses, so a minute means the same thing across the site.
 *
 * PLACEHOLDER: the issue is written in-house as a proof of the format. No issue has been sent, so it
 * carries no issue number and no date, and every part of it is marked as a sample.
 */
$iss_i = $NLT['issue'];

/* every figure below is counted from the text this section prints — see partials/newsletter/lib.php */
$iss_st     = nlt_stats($NLT);
$iss_total  = $iss_st['total'];
$iss_minutes = $iss_st['minutes'];
$iss_blocks = [];
foreach ($NLT['blocks'] as $iss_b) {
    $iss_b['count'] = $iss_st['blocks'][$iss_b['key']] ?? 0;
    $iss_blocks[]   = $iss_b;
}
$iss_first = $iss_blocks[0]['key'];
?>
<section class="band band--alt nlt-iss" id="issue" aria-labelledby="issue-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Open the sample issue</p>
        <h2 class="h2" id="issue-t"><span class="g">Rather than describe it,</span> here is one to read.</h2>
      </div>
      <div>
        <p class="lead">The whole thing, written the way an issue is written, with the reason each block exists
          printed underneath it. Nothing is withheld for the email: what a subscriber gets is this.</p>
        <p class="nlt-iss__hint"><span class="nlt-sample">Sample</span> Written in-house as a proof of the format. No issue has been sent.</p>
      </div>
    </div>

    <div class="nlt-iss__grid" id="issue-app">

      <!-- ---- the contents rail. The readout is always here; the tablist only appears once
                issue.js has folded the issue into panes, because without it the tabs would
                control nothing. ---- -->
      <div class="nlt-iss__rail">
        <div class="nlt-iss__read">
          <p class="nlt-k">This issue</p>
          <p class="nlt-iss__big"><span class="nlt-num" data-iss-words><?= (int) $iss_total ?></span><span>words</span></p>
          <p class="nlt-iss__sub"><span class="nlt-num"><?= (int) $iss_minutes ?></span> minutes at 210 words a minute · <?= count($iss_blocks) ?> blocks</p>
          <p class="nlt-iss__now" data-iss-now hidden></p>
        </div>

        <div class="nlt-iss__tabs" data-iss-tabs hidden>
          <p class="nlt-k nlt-iss__tk" id="issue-tk">Contents</p>
          <div class="nlt-iss__tl" role="tablist" aria-labelledby="issue-tk">
              <?php foreach ($iss_blocks as $iss_n => $iss_b): ?>
                <button type="button" class="nlt-iss__tab" role="tab"
                        id="issue-t-<?= e($iss_b['key']) ?>"
                        aria-controls="issue-b-<?= e($iss_b['key']) ?>"
                        aria-selected="<?= $iss_n === 0 ? 'true' : 'false' ?>"
                        tabindex="<?= $iss_n === 0 ? '0' : '-1' ?>"
                        data-iss-tab="<?= e($iss_b['key']) ?>">
                  <span class="nlt-iss__tn"><?= e($iss_b['n']) ?></span>
                  <span class="nlt-iss__tt"><span class="nlt-iss__tfull"><?= e($iss_b['name']) ?></span><span class="nlt-iss__tshort"><?= e($iss_b['short']) ?></span></span>
                  <span class="nlt-iss__tw"><?= (int) $iss_b['count'] ?> w</span>
                  <span class="nlt-iss__tbar" aria-hidden="true"><i style="--w:<?= $iss_total ? round($iss_b['count'] / $iss_total * 100, 1) : 0 ?>%"></i></span>
                </button>
              <?php endforeach; ?>
          </div>
          <p class="nlt-iss__tfoot">Arrow keys move between blocks.</p>
        </div>

        <p class="bdh-sr" role="status" aria-live="polite" data-iss-live></p>
      </div>

      <!-- ---- the reading pane ---- -->
      <article class="nlt-iss__mail nlt-paper">
        <header class="nlt-iss__head">
          <div class="nlt-iss__hbar">
            <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
            <span class="nlt-iss__hl"><?= e($NLT['meta']['name']) ?></span>
            <span class="nlt-sample">Sample issue · not sent</span>
          </div>
          <div class="nlt-iss__meta">
            <!-- PLACEHOLDER: confirm the sending address and the desk by-line before launch. -->
            <p class="nlt-iss__from"><b><?= e($NLT['meta']['from']) ?></b> &lt;<?= e($NLT['meta']['sender']) ?>&gt;<span>to <?= e($iss_i['to']) ?></span></p>
            <h3 class="nlt-iss__subj"><?= e($iss_i['subject']) ?></h3>
            <p class="nlt-iss__pre"><?= e($iss_i['preheader']) ?></p>
            <p class="nlt-iss__desk"><?= e($iss_i['desk']) ?><span class="nlt-iss__dot" aria-hidden="true"></span>No issue number: none has been sent</p>
          </div>
        </header>

        <div class="nlt-iss__body" data-iss-body>
          <?php foreach ($iss_blocks as $iss_n => $iss_b): ?>
            <article class="nlt-iss__b<?= $iss_b['key'] === $iss_first ? ' is-on' : '' ?>"
                     id="issue-b-<?= e($iss_b['key']) ?>"
                     data-iss-pane="<?= e($iss_b['key']) ?>"
                     aria-labelledby="issue-h-<?= e($iss_b['key']) ?>">
              <p class="nlt-iss__bk"><span><?= e($iss_b['n']) ?></span><?= e($iss_b['name']) ?></p>
              <h4 class="nlt-iss__bh" id="issue-h-<?= e($iss_b['key']) ?>"><?= e($iss_b['sample']['head']) ?></h4>

              <?php foreach ($iss_b['sample']['body'] ?? [] as $iss_p): ?>
                <p class="nlt-iss__p"><?= e($iss_p) ?></p>
              <?php endforeach; ?>

              <?php if (!empty($iss_b['sample']['items'])): ?>
                <ol class="nlt-iss__items">
                  <?php foreach ($iss_b['sample']['items'] as $iss_r): ?>
                    <li>
                      <span class="nlt-iss__ik"><?= e($iss_r[0]) ?></span>
                      <p class="nlt-iss__it"><?php
                        if (!empty($iss_r[2])) {
                            echo '<a class="nlt-a" href="' . e(xe_url($iss_r[2])) . '">' . e($iss_r[1]) . '</a>';
                        } else {
                            echo e($iss_r[1]);
                        }
                      ?></p>
                    </li>
                  <?php endforeach; ?>
                </ol>
              <?php endif; ?>

              <?php if (!empty($iss_b['sample']['note'])): ?>
                <p class="nlt-iss__note"><?= e($iss_b['sample']['note']) ?></p>
              <?php endif; ?>

              <dl class="nlt-iss__ann">
                <div><dt>Why this block is here</dt><dd><?= e($iss_b['job']) ?></dd></div>
                <div><dt>What it never contains</dt><dd><?= e($iss_b['never']) ?></dd></div>
                <div><dt>Length</dt><dd><span class="nlt-num"><?= (int) $iss_b['count'] ?></span> words here · target about <span class="nlt-num"><?= (int) $iss_b['words'] ?></span></dd></div>
              </dl>
            </article>
          <?php endforeach; ?>
        </div>

        <footer class="nlt-iss__foot">
          <!-- PLACEHOLDER: the unsubscribe link, the List-Unsubscribe header and the postal footer line all
               come from the email service. Confirm the wording and the sending address before launch. -->
          <p>You are reading this because you confirmed your address. <span>Unsubscribe</span> · one click, no survey.</p>
          <p class="nlt-iss__foot2"><?= e($NLT['meta']['from']) ?> · replies reach a person at the desk that wrote it</p>
        </footer>
      </article>
    </div>
  </div>
</section>
