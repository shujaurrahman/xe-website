<?php /* DRAFT COPY — review before launch */
/* Transfer — the answer to "you have not worked in my category". Six mechanisms that were built for
   one sector's constraint and now run in others, each with the one thing that has to be re-decided
   when it moves. The route rail is code-built: the sector it came from, then the sectors it runs in.
   Every sector reference is a real anchor on this page. */
$trf_by = [];
foreach ($IND as $trf_s) { $trf_by[$trf_s['id']] = $trf_s; }
$trf_rows = [
    ['The approval trail', 'consumer-health', ['financial-services', 'b2b-technology'], 'approve',
     'Evidence attached to every statement, a blocked list applied before anything is drafted, a named reviewer, and a log of what was published and when.',
     'The source of truth. An approved claim becomes a required disclosure, or a product fact — the shape of the trail does not move.'],
    ['The step-by-step funnel', 'financial-services', ['hospitality', 'retail-commerce'], 'pipeline',
     'Every step named, instrumented and owned, with the drop between two steps treated as a defect with an owner rather than as a benchmark.',
     'Which step may never be skipped for speed. In lending it is the Key Fact Statement; in booking it is the all-in price.'],
    ['The season calendar', 'retail-commerce', ['telecom-media', 'hospitality'], 'calendar',
     'Plan, produce, live — three gates and a lead time, so a campaign is finished before it is needed instead of during the week it runs.',
     'The cycle length. A retail season is quarterly, a telecom offer is monthly, a rate season is annual with weekly overrides.'],
    ['Tenant-scoped retrieval', 'b2b-technology', ['financial-services', 'telecom-media'], 'lock',
     'An assistant that can only read the records of the party in session, enforced at the retrieval layer and tested for, never merely requested in a prompt.',
     'What counts as a tenant: a customer account, a bank customer, a subscription — and who is allowed to cross one in support.'],
    ['The single customer record', 'hospitality', ['telecom-media', 'retail-commerce'], 'users',
     'One identity assembled from systems that disagree, with a written rule for which system wins each field and a consent attached to each use of it.',
     'Which system is allowed to be the truth, and whether the identity is the person or the contract.'],
    ['The intent model', 'telecom-media', ['b2b-technology', 'financial-services'], 'workflow',
     'Contacts labelled by what the person actually wanted, then measured on resolution rather than on deflection or handling time.',
     'What counts as resolved, and how long the window is before a repeat contact on the same intent cancels it.'],
];
?>
<section class="band ind-trf" id="transfer" aria-labelledby="transfer-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>What travels</p>
        <h2 class="h2" id="transfer-t"><span class="g">Sector knowledge is not a moat.</span> Mechanisms are.</h2>
      </div>
      <div>
        <p class="lead">“You have not worked in our category” is a fair question. The honest answer is that the constraints are specific and the mechanisms are not — these six were built for one sector’s problem and now run in others.</p>
        <p class="ind-note">Each card names the one decision that has to be taken again when a mechanism crosses a category. That decision is the work; the mechanism is the head start.</p>
      </div>
    </div>

    <ol class="ind-trf__list" data-rv-s data-rv-step="70">
      <?php foreach ($trf_rows as $trf_i => $trf_r): $trf_from = $trf_by[$trf_r[1]]; ?>
        <li class="ind-trf__card">
          <p class="ind-trf__route" aria-hidden="true">
            <a class="ind-trf__chip is-from" href="#<?= e($trf_from['id']) ?>"><b><?= e($trf_from['n']) ?></b><?= e($trf_from['short']) ?></a>
            <i class="ind-trf__arrow"></i>
            <?php foreach ($trf_r[2] as $trf_to): $trf_t = $trf_by[$trf_to]; ?>
              <a class="ind-trf__chip" href="#<?= e($trf_t['id']) ?>"><b><?= e($trf_t['n']) ?></b><?= e($trf_t['short']) ?></a>
            <?php endforeach; ?>
          </p>
          <p class="bdh-sr">Built for <?= e($trf_from['name']) ?>; now also used in <?= e(implode(' and ', array_map(fn ($trf_k) => $trf_by[$trf_k]['name'], $trf_r[2]))) ?>.</p>

          <p class="ind-trf__top"><span class="bdh-idx"><?= str_pad((string) ($trf_i + 1), 2, '0', STR_PAD_LEFT) ?></span><span class="ind-trf__ico" aria-hidden="true"><?= xt_icon($trf_r[3], ['size' => 20]) ?></span></p>
          <h3 class="bdh-t bdh-t--l ind-trf__t"><?= e($trf_r[0]) ?></h3>
          <p class="bdh-d ind-trf__d"><?= e($trf_r[4]) ?></p>
          <div class="ind-trf__ch">
            <span class="ind-k">What has to be decided again</span>
            <p><?= e($trf_r[5]) ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
