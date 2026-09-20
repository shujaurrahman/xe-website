<?php /* DRAFT COPY — review before launch */
/* 08 Governance — the data catalogue with agents doing the housekeeping. One wide catalogue window: the columns
   of silver.customers with agent-proposed classifications and confidence, beside the steward queue where a
   person approves or rejects each proposal (the buttons work); below them, column-level lineage from source to
   use with the catalogue answering a lineage question; in the foot, a deletion request executed across four
   systems with evidence. Under the window, a strip of the frameworks we align delivery with. governance.js runs
   the classifier sweep, the approvals and the lineage trace until the first interaction. All data fictional. */
$tcs_gv_cols = [   // [column, type, proposed tag, confidence, state in the finished view: approved | proposed | none, reason]
    ['customer_id',       'uuid',      '',                 0,   'none',     'primary key'],
    ['email',             'text',      'PII.contact',      .99, 'approved', 'pattern + column name'],
    ['phone_e164',        'text',      'PII.contact',      .98, 'proposed', 'E.164 pattern'],
    ['pan_last4',         'char(4)',   'Payment.truncated', .97, 'approved', 'name + source: payments'],
    ['date_of_birth',     'date',      'PII.sensitive',    .96, 'proposed', 'name + value distribution'],
    ['region',            'text',      '',                 0,   'none',     'reference data'],
    ['lifetime_value',    'numeric',   'Business.metric',  .91, 'policy',   'derived in gold · auto-approved by policy'],
    ['consent_marketing', 'boolean',   'Consent.purpose',  .99, 'policy',   'source: consents · auto-approved by policy'],
];
$tcs_gv_queue = [   // [key, kind, title, sub, state: waiting | done]
    ['email',    'tag',   'Tag email as PII.contact',              'confidence 0.99 · masks in non-prod · 30-day access log',   'done'],
    ['pan',      'tag',   'Tag pan_last4 as Payment.truncated',    'confidence 0.97 · last four digits only · finance role',    'done'],
    ['phone',    'tag',   'Tag phone_e164 as PII.contact',         'confidence 0.98 · masks in non-prod',                       'waiting'],
    ['dob',      'tag',   'Tag date_of_birth as PII.sensitive',    'confidence 0.96 · restricts to support lead role',          'waiting'],
    ['contract', 'draft', 'Data contract silver.customers v4',     'drafted from the schema and last 30 days of batches',       'waiting'],
    ['docs',     'draft', 'Column descriptions · 8 of 8',          'drafted from names, sources and sample values',             'waiting'],
];
$tcs_gv_lin = [   // rows of the lineage graph: key => [label, nodes [[layer, name]]]
    'email' => ['email', [['source', 'crm.contacts.email'], ['bronze', 'contacts_raw.email'], ['silver', 'customers.email'], ['gold', 'dim_customer.email_hash'], ['use', 'Active customers · BI']]],
    'pan'   => ['pan_last4', [['source', 'payments.card.last4'], ['bronze', 'payments_raw.last4'], ['silver', 'customers.pan_last4'], ['gold', 'fct_payments.pan_last4'], ['use', 'Chargeback report · finance']]],
    'ltv'   => ['lifetime_value', [['source', 'orders.total · refunds'], ['bronze', 'orders_raw.total'], ['silver', 'orders.total'], ['gold', 'dim_customer.ltv'], ['use', 'Segments · reverse ETL']]],
];
$tcs_gv_systems = ['CRM', 'Warehouse', 'Email platform', 'Ads audiences'];
$tcs_gv_badges = ['gdpr', 'dpdp', 'iso27001', 'soc2', 'pci-dss', 'hipaa'];
$tcs_gv_explain = [
    ['agent',  'Agents propose, stewards approve', 'A classifier reads names, types, sources and sample values and proposes a tag with its confidence. Low-risk tags are approved by policy; anything personal or regulated waits for a named steward. Nothing is applied silently.'],
    ['doc',    'Contracts and docs from schemas',  'Agents draft data contracts, column descriptions and the lineage answer to “where does this number come from”, from the models themselves. People edit and sign off, and the drafts are never stale because they are regenerated on change.'],
    ['shield', 'Deletion with evidence',            'A subject’s deletion request runs across every system that holds them, in order, with a receipt from each. The evidence bundle is what you hand to a regulator under GDPR or the DPDP Act, not a promise.'],
];
?>
<section class="band band--ink tcs-governance" id="governance" aria-labelledby="governance-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tcs-eb"><span class="tcs-eb__g" aria-hidden="true"></span>Governance · AI-native housekeeping</p>
        <h2 class="h2" id="governance-t"><span class="g">Governed data,</span> with agents doing the housekeeping.</h2>
      </div>
      <div>
        <p class="lead">Classification, contracts, documentation and lineage are the work nobody has time for, so it never gets done. Agents do it continuously; people approve what matters.</p>
      </div>
    </div>

    <div class="tcs-gv" data-rv>
      <div class="tcs-gv__main">
        <div class="bdh-ui bdh-ui--ink tcs-gv__win">
          <div class="bdh-ui__bar tcs-gv__bar">
            <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
            <span class="tcs-gv__path">catalogue <i>/</i> silver <i>/</i> <b>customers</b></span>
            <span class="tcs-gv__agent"><?= xt_icon('agent', ['size' => 14, 'mono' => true]) ?><span data-gv-agent>classifier v4 · 2 proposals · 2 approved by policy</span></span>
            <button type="button" class="tcs-btn" data-gv-run><?= xt_icon('scan', ['size' => 14, 'mono' => true]) ?>Run classifier</button>
          </div>
          <p class="bdh-sr">Interactive demonstration with fictional data. The columns list shows agent-proposed classifications with confidence. The steward queue has approve and reject buttons that apply or discard a proposal. Run classifier repeats the scan. The status line announces changes. Column-level lineage traces email from crm.contacts.email through bronze and silver to a hashed column in gold used by the Active customers dashboard, and the catalogue answers lineage questions in plain language. A deletion request, DSR-1042, runs across the CRM, the warehouse, the email platform and the ad audiences in order, with a receipt from each sealed into an evidence bundle.</p>

          <div class="tcs-gv__panes">
            <div class="tcs-gv__pane tcs-gv__cols">
              <p class="tcs-gv__h"><span>Columns</span><em data-gv-tagged>6 of 8 classified</em></p>
              <ul class="tcs-gv__cl" aria-label="Columns of silver.customers">
                <?php foreach ($tcs_gv_cols as $tcs_gv_c): ?>
                  <li class="tcs-gv__c is-<?= $tcs_gv_c[4] ?>" data-col="<?= e($tcs_gv_c[0]) ?>" data-tag="<?= e($tcs_gv_c[2]) ?>" data-conf="<?= $tcs_gv_c[3] ?>" data-state="<?= $tcs_gv_c[4] ?>">
                    <span class="tcs-gv__cn"><?= e($tcs_gv_c[0]) ?></span>
                    <span class="tcs-gv__ct"><?= e($tcs_gv_c[1]) ?></span>
                    <span class="tcs-gv__tag" data-gv-tag><?= $tcs_gv_c[2] !== '' ? e($tcs_gv_c[2]) : '—' ?></span>
                    <span class="tcs-gv__conf" data-gv-conf><?= $tcs_gv_c[3] ? number_format($tcs_gv_c[3], 2) : '' ?></span>
                    <span class="tcs-gv__why"><?= e($tcs_gv_c[5]) ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
              <ul class="tcs-gv__key" aria-hidden="true"><li><i class="is-approved"></i>Approved</li><li><i class="is-policy"></i>By policy</li><li><i class="is-proposed"></i>Proposed</li></ul>
              <div class="tcs-gv__pol">
                <p class="tcs-gv__pk"><?= xt_icon('shield', ['size' => 13, 'mono' => true]) ?>Approval policy <em>policies/classification.yaml</em></p>
<pre class="tcs-gv__pc"><code><span class="k">auto_approve:</span>
  when: tag in [Business.*, Consent.*]
    and confidence ≥ 0.90
<span class="k">otherwise:</span> queue for data_steward
<span class="k">never_auto:</span> [PII.*, Payment.*, Health.*]</code></pre>
              </div>
            </div>

            <div class="tcs-gv__pane tcs-gv__queue">
              <p class="tcs-gv__h"><span>Steward queue</span><em data-gv-qn>4 waiting</em></p>
              <ul class="tcs-gv__ql">
                <?php foreach ($tcs_gv_queue as $tcs_gv_q): ?>
                  <li class="tcs-gv__qi is-<?= $tcs_gv_q[4] ?>" data-q="<?= $tcs_gv_q[0] ?>" data-kind="<?= $tcs_gv_q[1] ?>">
                    <span class="tcs-gv__qk"><?= $tcs_gv_q[1] === 'tag' ? 'Classification' : 'Draft' ?></span>
                    <span class="tcs-gv__qt"><?= e($tcs_gv_q[2]) ?></span>
                    <span class="tcs-gv__qs"><?= e($tcs_gv_q[3]) ?></span>
                    <span class="tcs-gv__qa">
                      <button type="button" class="tcs-btn tcs-btn--pri" data-gv-decide="approve" data-for="<?= $tcs_gv_q[0] ?>"><?= $tcs_gv_q[1] === 'tag' ? 'Approve' : 'Accept draft' ?></button>
                      <button type="button" class="tcs-btn" data-gv-decide="reject" data-for="<?= $tcs_gv_q[0] ?>"><?= $tcs_gv_q[1] === 'tag' ? 'Reject' : 'Send back' ?></button>
                    </span>
                    <span class="tcs-gv__qd" data-gv-qd><?= $tcs_gv_q[4] === 'done' ? 'Approved · data_steward · 02:14' : '' ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
              <dl class="tcs-gv__qstats">
                <div><dt>Decided this week</dt><dd>38</dd></div>
                <div><dt>Median time to decision</dt><dd>4 h 10 min</dd></div>
                <div><dt>Applied without a person</dt><dd>0 regulated tags</dd></div>
              </dl>
            </div>
            <div class="tcs-gv__pane tcs-gv__lin">
              <p class="tcs-gv__h"><span>Column-level lineage</span><em data-gv-linnote>email · source to use</em></p>
              <div class="tcs-gv__lwrap">
                <div class="tcs-gv__lg" aria-hidden="true">
                <p class="tcs-gv__lh"><span>Source</span><span>Bronze</span><span>Silver</span><span>Gold</span><span>Use</span></p>
                <?php foreach ($tcs_gv_lin as $tcs_gv_k => $tcs_gv_row): ?>
                  <div class="tcs-gv__lr<?= $tcs_gv_k === 'email' ? ' is-on' : '' ?>" data-lin="<?= $tcs_gv_k ?>">
                    <?php foreach ($tcs_gv_row[1] as $tcs_gv_j => $tcs_gv_n): ?>
                      <?php if ($tcs_gv_j > 0): ?><span class="tcs-gv__edge" style="--i:<?= $tcs_gv_j ?>"><i></i></span><?php endif; ?>
                      <span class="tcs-gv__node tcs-gv__node--<?= $tcs_gv_n[0] ?>" style="--i:<?= $tcs_gv_j ?>"><?= str_replace('.', '.<wbr>', e($tcs_gv_n[1])) ?></span>
                    <?php endforeach; ?>
                  </div>
                <?php endforeach; ?>
              </div>
              <div class="tcs-gv__ask">
                <p class="tcs-gv__aq"><span class="tcs-gv__ap">›</span><span data-gv-q>Where does the email in Active customers come from, and is it masked?</span></p>
                <p class="tcs-gv__aa" data-gv-a>dim_customer.email_hash ← silver.customers.email ← bronze.contacts_raw.email ← crm.contacts.email. SHA-256 hashed in gold, masked in non-prod since 02:14. Owner: growth. 1 consumer, 4 sources cited.</p>
              </div>
              </div>
            </div>

          </div>

          <div class="tcs-gv__foot">
            <div class="tcs-gv__dsr" data-gv-dsr>
              <p class="tcs-gv__h"><span>Deletion request</span><em>DSR-1042 · subject 9b2e…41 · GDPR Art. 17 / DPDP s.12</em></p>
              <ol class="tcs-gv__sys">
                <?php foreach ($tcs_gv_systems as $tcs_gv_i => $tcs_gv_s): ?>
                  <li class="is-done" data-sys="<?= $tcs_gv_i ?>"><span class="tcs-gv__sc"><?= xt_icon('check', ['size' => 11, 'mono' => true]) ?></span><b><?= e($tcs_gv_s) ?></b><span data-gv-sr>receipt · <?= ['a91c…', '4e07…', 'c2f8…', '77d1…'][$tcs_gv_i] ?></span></li>
                <?php endforeach; ?>
              </ol>
              <p class="tcs-gv__ev" data-gv-ev>Evidence bundle e7c1…3a sealed · 4 of 4 systems · 38 s</p>
            </div>
            <p class="tcs-gv__log" aria-live="polite" data-gv-status>Steward approved pan_last4 → Payment.truncated · restricted to finance role · logged 02:14:07</p>
          </div>
        </div>
      </div>

    </div>

    <aside class="tcs-gv__rail" aria-labelledby="governance-rail-t" data-rv>
      <div class="tcs-gv__rh">
        <p class="tcs-gv__rt" id="governance-rail-t">Frameworks we align delivery with</p>
        <p class="tcs-gv__rn">Code-built marks, not certifications. Controls are mapped to these frameworks in the access matrix and the audit log you receive.</p>
      </div>
      <ul class="tcs-gv__badges" role="list">
        <?php foreach ($tcs_gv_badges as $tcs_gv_b): ?><?= xt_badge($tcs_gv_b, ['tag' => 'li']) ?><?php endforeach; ?>
      </ul>
    </aside>

    <div class="tcs-gv__explain">
      <?php foreach ($tcs_gv_explain as $tcs_gv_x): ?>
        <div class="tcs-gv__x">
          <span class="tcs-gv__xi"><?= xt_icon($tcs_gv_x[0], ['size' => 22]) ?></span>
          <h3 class="tcs-gv__xt"><?= e($tcs_gv_x[1]) ?></h3>
          <p><?= e($tcs_gv_x[2]) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
