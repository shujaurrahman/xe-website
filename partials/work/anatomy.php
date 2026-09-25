<?php /* DRAFT COPY — review before launch */
/* Anatomy — the record's shape, printed from the same list that documents data/work.php ('fields'), so the
   page and the file can never drift apart. Beside it: the three rules that decide what may be published,
   which is why the placeholders carry no client names, no figures and no photographs. */
$wka_rules = [
    ['handshake', 'A client is named only in writing',
     'Until a client has agreed in writing to be named, the record is attributed to its sector and scope. "Consumer health · nine markets" is a complete attribution, not a gap.'],
    ['chart', 'A number is published with its evidence',
     'A figure appears only with the baseline it is measured against, the window it was measured over and the source that verified it. Without all three the record describes what changed in words.'],
    ['eye', 'A stock photograph never stands in for the work',
     'A record with no released imagery draws a plate in code and says so. Nothing on this page is a photograph of a project it did not come from.'],
];
$wka_absent = [
    'Logo walls of companies we have not worked with',
    'Percentage lifts with no control and no baseline',
    'Awards or rankings we have not received',
    'Testimonials nobody has signed off',
    'Headcounts and client counts stated as facts',
];
?>
<section class="band wk-anatomy" id="anatomy" aria-labelledby="anatomy-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The record</p>
        <h2 class="h2" id="anatomy-t"><span class="g">Eight fields.</span> The same eight, every time.</h2>
      </div>
      <div>
        <p class="lead">A case study here is a record, not an essay. Every project answers the same eight
          questions, in the same order, so two pieces of work can be compared without taking anyone's word
          for it. This is the list that lives in the data file.</p>
      </div>
    </div>

    <div class="wk-anatomy__grid">
      <div class="wk-anatomy__table" data-rv>
        <div class="bdh-scroll-x" tabindex="0" role="region" aria-label="The eight fields of a case-study record, scroll sideways on small screens">
          <table class="wk-anatomy__t">
            <caption class="bdh-sr">Each field of a case-study record, what it answers and who supplies it.</caption>
            <thead>
              <tr>
                <th scope="col"><span class="wk-k">#</span></th>
                <th scope="col"><span class="wk-k">Field</span></th>
                <th scope="col"><span class="wk-k">What it answers</span></th>
                <th scope="col"><span class="wk-k">Who supplies it</span></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($WK['fields'] as $wka_i => $wka_f): ?>
                <tr>
                  <td class="wk-anatomy__n"><?= str_pad((string) ($wka_i + 1), 2, '0', STR_PAD_LEFT) ?></td>
                  <th scope="row"><?= e($wka_f[0]) ?></th>
                  <td><?= e($wka_f[1]) ?></td>
                  <td class="wk-anatomy__who"><?= e($wka_f[2]) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <p class="wk-note">Fields are read from <code>data/work.php</code>. Adding a field there adds a row
          here. <a class="wk-index__lk" href="#index">Every record above</a> prints all eight.</p>
      </div>

      <div class="wk-anatomy__side">
        <ul class="wk-anatomy__rules" data-rv-s data-rv-step="80">
          <?php foreach ($wka_rules as $wka_r): ?>
            <li>
              <span class="wk-anatomy__ri" aria-hidden="true"><?= xt_icon($wka_r[0], ['size' => 20]) ?></span>
              <h3 class="bdh-t bdh-t--s"><?= e($wka_r[1]) ?></h3>
              <p class="bdh-d"><?= e($wka_r[2]) ?></p>
            </li>
          <?php endforeach; ?>
        </ul>

        <div class="wk-anatomy__absent" data-rv data-rv-d="90">
          <p class="wk-k">What you will not find on this page</p>
          <ul class="wk-anatomy__no">
            <?php foreach ($wka_absent as $wka_a): ?>
              <li><i aria-hidden="true">&times;</i><?= e($wka_a) ?></li>
            <?php endforeach; ?>
          </ul>
          <p class="wk-note">If a claim cannot be evidenced, it is not on the site. That rule is easier to
            keep than to recover from.</p>
        </div>
      </div>
    </div>
  </div>
</section>
