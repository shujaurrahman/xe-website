<?php /* DRAFT COPY — review before launch */
/* Brief — what this page is and what state it is in. The archive is a structure: this section says so
   plainly, gives the live readout of what the structure currently holds (read from data/work.php, never
   typed here), and carries the one note addressed to whoever maintains that file. The note is deliberately
   styled as scaffolding, not marketing, and is meant to be deleted once real case studies are in. */
$wkb_reads = [
    ['The problem', 'What was true before we started, in the client\'s terms.'],
    ['What we did', 'The decisions, not the deliverables.'],
    ['What you get', 'The outputs the client received and now owns.'],
    ['What changed', 'The outcome, with its baseline and who verified it.'],
];
$wkb_stats = [
    ['Records', (string) count($WK['cases']), 'in the archive'],
    ['Sectors', count($WK['count_i']) . ' / ' . count($WK['industries']), 'represented'],
    ['Disciplines', count($WK['count_d']) . ' / ' . count($WK['disc']), 'involved'],
    ['Awaiting release', (string) $WK['holding'], 'placeholder records'],
];
?>
<section class="band wk-brief" id="brief" aria-labelledby="brief-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The archive</p>
        <h2 class="h2" id="brief-t"><span class="g">Every project, kept</span> as one record.</h2>
      </div>
      <div>
        <p class="lead">One record per programme, in the same shape every time: the problem, the decisions,
          the outputs and what changed. Filter by discipline or by sector, then open a record and read all
          of it. Nothing is summarised into a number you cannot trace.</p>
        <a class="tl" href="#index">Go to the showcase <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <div class="wk-brief__grid">
      <ul class="wk-brief__reads" data-rv-s data-rv-step="70">
        <?php foreach ($wkb_reads as $wkb_i => $wkb_r): ?>
          <li>
            <span class="bdh-idx"><?= str_pad((string) ($wkb_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <h3 class="bdh-t bdh-t--s"><?= e($wkb_r[0]) ?></h3>
            <p class="bdh-d"><?= e($wkb_r[1]) ?></p>
          </li>
        <?php endforeach; ?>
      </ul>

      <dl class="wk-brief__stats" data-rv data-rv-d="90">
        <?php foreach ($wkb_stats as $wkb_s): ?>
          <div>
            <dt class="wk-k"><?= e($wkb_s[0]) ?></dt>
            <dd><b class="num"><?= e($wkb_s[1]) ?></b><span><?= e($wkb_s[2]) ?></span></dd>
          </div>
        <?php endforeach; ?>
      </dl>
    </div>

    <!-- PLACEHOLDER: replace with real case studies before launch. This whole block, and every
         record in data/work.php marked 'placeholder' => true, comes out at that point. -->
    <div class="wk-editor wk-brief__note" data-rv data-rv-d="60">
      <div class="wk-brief__note1">
        <p class="wk-editor__h">
          <span class="wk-editor__t">Pre-launch note</span>
          <span class="bdh-ill">Delete before launch</span>
        </p>
        <p>The <?= (int) $WK['holding'] ?> records below are illustrative. They exist so the page can be
           judged, filtered and signed off while the real thing is still in clearance. None of them is a
           real project, none names a client, and none carries a measured result.</p>
      </div>
      <div class="wk-brief__note2">
        <p><b>Your work goes here.</b> A real case study is one entry appended to
           <code>data/work.php</code>. The filters, the counts and the sector list rebuild themselves from
           that file, so nothing else needs editing.</p>
        <p class="wk-note">The file's header comment explains every field, what it answers and who supplies
           it. The same list is printed further down this page, under
           <a class="tl wk-brief__tl" href="#anatomy">the record<span class="i" aria-hidden="true">›</span></a></p>
      </div>
      <ol class="wk-brief__note3">
        <li>Copy a record in <code>data/work.php</code> and paste it at the top of the list.</li>
        <li>Replace every value with the real one.</li>
        <li>Set <code>'placeholder' =&gt; false</code> and save.</li>
      </ol>
    </div>
  </div>
</section>
