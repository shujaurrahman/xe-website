<?php /* DRAFT COPY — review before launch */
/* Symptoms — when the spreadsheet becomes the system. A restrained photograph (a laptop open on a spreadsheet) with a small spreadsheet mock
   on top of it (a range copied from the CRM export and pasted into Billing, where one lookup fails), beside
   four symptom rows, each with an illustrative hours-per-week cost. symptoms.js plays the copy-paste loop. */
$tcs_sym_rows = [   // [index, title, text, figure, unit, what the time goes on]
    ['01', 'Same customer, four tools, four IDs.', 'Sales knows them as ACC-10442, billing as C-88121, support by an email address and the spreadsheet by a company name. Every report starts with a matching exercise.', '9.5', 'h / week', 'Reconciling records'],
    ['02', 'Approvals by email.', 'Discounts, refunds and credit limits are agreed in reply-all threads. Nobody can say who approved what, or when, without searching an inbox.', '7', 'h / week', 'Chasing sign-off'],
    ['03', 'Reports rebuilt every Monday.', 'Someone exports five sheets, pastes them together and hopes the formulas held. The numbers are a week old by the time anyone reads them.', '6', 'h / week', 'Rebuilding reports'],
    ['04', 'No trail of who changed what.', 'When a price or a status changes, there is no record of the old value, the person or the reason. Every audit becomes archaeology.', '4.5', 'h / week', 'Reconstructing changes'],
];
$tcs_sym_tabs = [   // [tab, third column, rows [[customer, id, third]]]
    ['CRM export', 'Owner', [['Your company', 'ACC-10442', 'Key accounts'], ['Account 0192', 'ACC-10458', 'Mid-market'], ['Account 0217', 'ACC-10461', 'Mid-market']]],
    ['Billing',    'CRM ID', [['Your company', 'C-88121', 'ACC-10442'], ['Account 0192', 'C-88140', 'ACC-10458'], ['Acct. 217', 'C-88203', '#N/A']]],
    ['Support',    'Queue', [['ops@yourco…', 'T-5521', 'Tier 2'], ['help@acct0192…', 'T-5534', 'Tier 1'], ['—', '—', 'Unmatched']]],
];
?>
<section class="band band--alt tcs-symptoms" id="symptoms" aria-labelledby="symptoms-t">
  <div class="wrap">
    <div class="bdh-grid tcs-sym">
      <div class="bdh-c5 tcs-sym__vis">
        <div class="tcs-sym__sticky">
          <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
          <figure class="bdh-img bdh-img--r45 tcs-sym__img" data-rv>
            <img src="<?= xe_url('assets/imgs/tech/custom-software-data-platforms/symptoms-spreadsheet.jpg') ?>" alt="Over a colleague's shoulder: a laptop open on a dense spreadsheet of rows and columns at a shared table" width="1500" height="2250" loading="lazy" decoding="async" style="object-position:40% 45%">
          </figure>

          <div class="tcs-sheet" data-tab="1" data-rv data-rv-d="120" aria-hidden="true">
            <div class="tcs-sheet__bar"><span class="tcs-sheet__file">customers_FINAL_v7.xlsx</span><span class="tcs-sheet__ed">23 editors</span></div>
            <div class="tcs-sheet__tabs">
              <?php foreach ($tcs_sym_tabs as $tcs_sym_i => $tcs_sym_t): ?>
                <span class="tcs-sheet__tab" data-t="<?= $tcs_sym_i ?>"><?= e($tcs_sym_t[0]) ?></span>
              <?php endforeach; ?>
            </div>
            <div class="tcs-sheet__panes">
              <?php foreach ($tcs_sym_tabs as $tcs_sym_i => $tcs_sym_t): ?>
                <div class="tcs-sheet__pane" data-p="<?= $tcs_sym_i ?>">
                  <span class="tcs-sheet__rh"></span><span class="tcs-sheet__ch">A · Customer</span><span class="tcs-sheet__ch">B · ID</span><span class="tcs-sheet__ch">C · <?= e($tcs_sym_t[1]) ?></span>
                  <?php foreach ($tcs_sym_t[2] as $tcs_sym_r => $tcs_sym_row): ?>
                    <span class="tcs-sheet__rh"><?= $tcs_sym_r + 2 ?></span>
                    <?php foreach ($tcs_sym_row as $tcs_sym_c => $tcs_sym_v): ?>
                      <span class="tcs-sheet__c<?= in_array($tcs_sym_v, ['#N/A', 'Unmatched', '—'], true) ? ' is-err' : '' ?><?= $tcs_sym_c === 2 && $tcs_sym_i === 1 ? ' is-paste' : '' ?>"><?= e($tcs_sym_v) ?></span>
                    <?php endforeach; ?>
                  <?php endforeach; ?>
                </div>
              <?php endforeach; ?>
              <svg class="tcs-sheet__sel" viewBox="0 0 100 100" preserveAspectRatio="none"><rect x="1" y="1" width="98" height="98" vector-effect="non-scaling-stroke"/></svg>
            </div>
            <p class="tcs-sheet__st"><span class="tcs-sheet__fx">fx</span><span data-sheet-status>=VLOOKUP(A4, 'CRM export'!A:B, 2, FALSE) → #N/A in 1 of 3 rows</span></p>
          </div>
          <p class="bdh-sr">An illustrative shared spreadsheet with CRM export, Billing and Support tabs. A range copied from the CRM export into Billing fails one VLOOKUP (#N/A) because the account name is spelled differently, and Support can only be matched by email.</p>
        </div>
      </div>

      <div class="bdh-c6 bdh-s7 tcs-sym__body">
        <div class="bdh-head tcs-sym__head" data-rv>
          <p class="tcs-eb"><span class="tcs-eb__g" aria-hidden="true"></span>Where it breaks</p>
          <h2 class="h2" id="symptoms-t"><span class="g">When the spreadsheet becomes the system,</span> the cost is quiet and weekly.</h2>
          <p class="lead">Most custom platforms replace something that grew by accident: an export, a shared sheet, an inbox rule. It works until the business depends on it. These are the signs.</p>
        </div>

        <ol class="tcs-sym__list" data-rv-s>
          <?php foreach ($tcs_sym_rows as $tcs_sym_row): ?>
            <li class="tcs-sym__row">
              <span class="tcs-sym__n"><?= e($tcs_sym_row[0]) ?></span>
              <div class="tcs-sym__txt">
                <h3 class="tcs-sym__t"><?= e($tcs_sym_row[1]) ?></h3>
                <p class="tcs-sym__d"><?= e($tcs_sym_row[2]) ?></p>
              </div>
              <p class="tcs-sym__fig"><span class="tcs-sym__fv"><b data-bdh-count><?= e($tcs_sym_row[3]) ?></b><span><?= e($tcs_sym_row[4]) ?></span></span><small><?= e($tcs_sym_row[5]) ?></small></p>
            </li>
          <?php endforeach; ?>
        </ol>

        <div class="tcs-sym__total" data-rv>
          <p class="tcs-sym__tk">Across all four</p>
          <p class="tcs-sym__tv"><b data-bdh-count>27</b> h / week <span>about 0.7 of a full-time role, before a single error is counted</span></p>
        </div>
        <p class="tcs-note"><span class="bdh-ill">Illustrative</span>Figures for a 40-person operations team. We measure your own baseline in the first week, before anything is built.</p>
      </div>
    </div>
  </div>
</section>
