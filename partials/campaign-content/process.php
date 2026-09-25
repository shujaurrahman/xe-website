<?php /* DRAFT COPY — review before launch */
/* Process — the stepper idiom (.cch-step, from assets/css/campaign-content.css). Four phases at
   discipline level: read, decide, build, run. The phases, their outputs and their timings are the
   common shape of the eight capability processes in data/campaign-content.php; each capability's own
   four steps sit inside them. Every phase also states what we need from your side, because that is
   where engagements actually slip.
   PLACEHOLDER: every week range here is typical, not promised. */
$pr_steps = [
    [
        'n' => '01', 'name' => 'Read', 'when' => 'Wk 01–03',
        'd' => 'Performance history, analytics and CRM data, search demand, the questions sales and support keep answering, category context, and an inventory of what you already have with how it performed.',
        'out' => ['Demand and question map', 'Content inventory', 'Performance read', 'Audience analysis'],
        'need' => ['Access to analytics, ad accounts and CRM', 'A few hours with each channel owner', 'Whatever research already exists'],
    ],
    [
        'n' => '02', 'name' => 'Decide', 'when' => 'Wk 03–06',
        'd' => 'Audiences, channel roles, the message sequence and the budget split agreed in working sessions, with a larger and a smaller budget modelled against each. One definition per metric, agreed with sales and finance before anything is bought.',
        'out' => ['Channel architecture', 'Message and offer sequence', 'Budget model with scenarios', 'Measure set and definitions'],
        'need' => ['The people who will run the plan, in the room', 'Finance to agree the revenue definition', 'A decision on the no-go list'],
    ],
    [
        'n' => '03', 'name' => 'Build', 'when' => 'Wk 04–13',
        'd' => 'Two or three campaign platforms shown on real placements, including the awkward ones, and one chosen and systemised into tokens, templates and rules. The first content cluster written with your experts. The consented measurement layer implemented and validated end to end.',
        'out' => ['Campaign platform and art direction', 'Master templates and tokens', 'First published cluster', 'Validated measurement layer'],
        'need' => ['Your experts for interviews, an hour each', 'Legal to pass the claims', 'Brand tokens, or we build them'],
    ],
    [
        'n' => '04', 'name' => 'Run', 'when' => 'Monthly, ongoing',
        'd' => 'Publish, reply, buy, test and report on a monthly rhythm, with a quarterly refresh of the content that has aged and a quarterly reallocation of budget. Each decision is recorded against the evidence that prompted it, so the plan is corrected by performance rather than by the last meeting.',
        'out' => ['Monthly performance report', 'Refresh backlog', 'Updated budget model', 'Operating rhythm your team owns'],
        'need' => ['One owner on your side', 'One hour a month for the review', 'A route to legal for reactive work'],
    ],
];
?>
<section class="band band--alt cch-process" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>How an engagement runs</p>
        <h2 class="h2" id="process-t"><span class="g">Four phases.</span> The first thing ships in week six.</h2>
      </div>
      <div>
        <p class="lead">The plan is not finished before the work starts. One cluster and a measurement baseline ship while the system is still being built, so the plan is corrected by performance rather than by debate.</p>
      </div>
    </div>

    <ol class="cch-steps cch-pr__steps" data-rv data-rv-d="60">
      <?php foreach ($pr_steps as $pr_s): ?>
        <li class="cch-step cch-pr__step">
          <p class="cch-step__n"><?= e($pr_s['n']) ?><small><?= e($pr_s['when']) ?></small></p>
          <div class="cch-step__b cch-pr__b">
            <div>
              <h3 class="cch-step__t"><?= e($pr_s['name']) ?></h3>
              <p class="cch-step__d"><?= e($pr_s['d']) ?></p>
            </div>
            <div class="cch-pr__c">
              <p class="cch-k">What comes out</p>
              <p class="cch-step__out">
                <?php foreach ($pr_s['out'] as $pr_o): ?><span class="cch-step__o"><?= e($pr_o) ?></span><?php endforeach; ?>
              </p>
            </div>
            <div class="cch-pr__c">
              <p class="cch-k">What we need from you</p>
              <ul class="cch-pr__need" role="list">
                <?php foreach ($pr_s['need'] as $pr_nd): ?><li><?= e($pr_nd) ?></li><?php endforeach; ?>
              </ul>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>

    <div class="cch-pr__own" data-rv data-rv-d="60">
      <h3 class="cch-pr__ot"><span class="g">One more thing about the process.</span> You own the output.</h3>
      <ul class="cch-pr__olist" role="list">
        <li><b>Copy, design files, photography and licences</b> transfer to you on delivery, with usage rights recorded per asset.</li>
        <li><b>Campaigns run in your accounts</b>, under your billing, with your data, and access is handed back in full at the end.</li>
        <li><b>Briefs, standards and dashboards</b> are handed over, so publishing continues at the same standard without us.</li>
      </ul>
    </div>
  </div>
</section>
