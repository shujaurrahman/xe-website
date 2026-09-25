<?php /* DRAFT COPY — review before launch */
/* Lens — the inverse of the console. There the sector comes first; here the job does. Pick one of five
   jobs every programme contains, and read the same job across all six sectors at once. That is where
   the categories separate: the work has the same name and almost none of the same constraints.
   Every pane is a real table (th scope), so the comparison survives without CSS; the <noscript> rule
   stacks all five. The last two rows of every pane are generated from the sector data, so the page
   cannot drift from itself. */
$lns_jobs = [
    ['sign-off',  'The sign-off',    'Who has to say yes before it reaches a customer?', 'approve',
     'Every sector has an approval step. What differs is who owns it, what they check against, and whether it runs before the work ships or after it has already been seen.'],
    ['record',    'The record',      'What does “one customer” mean, and which system is allowed to be the truth?', 'database',
     'Personalisation, consent and measurement all fail in the same place: nobody agreed which system holds the customer. The answer is different in every category.'],
    ['first',     'The first screen', 'Where does discovery happen, and what has to be true there?', 'search',
     'The first screen is rarely yours. What it has to get right — a claim, a rate, a total price, a stock level — is set by the category, not by the brand.'],
    ['assistant', 'The assistant',   'What is the AI allowed to do, and what is it never allowed to do?', 'agent',
     'The useful question is not which model. It is what the assistant may touch, what it must refuse, and who signs off when it is wrong.'],
    ['number',    'The number',      'What gets reported, and what does it actually count?', 'gauge',
     'A number without a written definition and an agreed baseline is a decoration. These are the definitions we work to, written before anything ships.'],
];
/* [answer, the constraint that shapes it] per sector; the last two jobs read from data/industries.php */
$lns_cells = [
    'sign-off' => [
        'consumer-health'    => ['Medical, legal and regulatory review, against the approved claims library and the evidence behind each claim.', 'Named reviewer'],
        'financial-services' => ['Compliance reviews the journey, not only the copy, because placement decides whether a disclosure counts.', 'Before launch'],
        'retail-commerce'    => ['Brand and merchandising approve the master; variants are spot-checked against it rather than re-approved one by one.', 'Sample check'],
        'b2b-technology'     => ['Product marketing owns the claim; security owns anything a buyer’s questionnaire will later ask about.', 'Two owners'],
        'hospitality'        => ['Revenue management owns rate, inventory and fee language. Brand owns everything around it.', 'Split by field'],
        'telecom-media'      => ['Regulatory approves the template, the template is registered on DLT, and only then can anything be sent.', 'Registered first'],
    ],
    'record' => [
        'consumer-health'    => ['Often there is no single customer: the shopper belongs to the retailer, the pharmacist belongs to you.', 'Consented only'],
        'financial-services' => ['The core system holds it. The CRM is a copy, and a copy may inform a message but never a decision.', 'Core is the truth'],
        'retail-commerce'    => ['An order, not a person — until a loyalty or account identifier joins the orders together.', 'Order-first'],
        'b2b-technology'     => ['The account, not the user. The tenant boundary is a product requirement, not an infrastructure detail.', 'Tenant-scoped'],
        'hospitality'        => ['A guest exists in five systems. The reservation number is usually the only thing all five share.', 'Five copies'],
        'telecom-media'      => ['The subscription, not the person. One person may hold four of them, and each has its own consent.', 'SIM is not a person'],
    ],
    'first' => [
        'consumer-health'    => ['A search result or an AI answer about a symptom. It has to be accurate and claim-safe before it is persuasive.', 'Answer-first'],
        'financial-services' => ['An aggregator comparison. The rate, the fee and the eligibility shown there have to match the app exactly.', 'Must match'],
        'retail-commerce'    => ['A marketplace thumbnail. Title, price, net quantity and country of origin are mandatory, not editorial.', 'Listing rules'],
        'b2b-technology'     => ['Documentation and a peer thread, read for months before a call. Both have to be current to be useful.', 'Docs are sales'],
        'hospitality'        => ['A metasearch result showing a total. A fee revealed at the last step sends the guest back to the aggregator.', 'All-in price'],
        'telecom-media'      => ['The self-care app or a retail counter. The plan shown has to be the plan billed, on the same day.', 'Offer parity'],
    ],
    'assistant' => [
        'consumer-health'    => ['Drafts from the approved claims library. A cure claim for a listed condition is blocked before a human ever sees it.', 'Blocked-claims list'],
        'financial-services' => ['Answers on the account in session. A rate, an eligibility or a settlement is refused, not estimated.', 'Hard refusals'],
        'retail-commerce'    => ['Generates variants from an approved master. A price or a stock level is looked up in the catalogue, never guessed.', 'Catalogue lookup'],
        'b2b-technology'     => ['Answers from your docs and the customer’s own tenant. Reading across tenants is prevented at retrieval, not in the prompt.', 'Tenant isolation'],
        'hospitality'        => ['Takes a request through to the property system. It cannot move a rate, release a room or touch a card number.', 'No commitments'],
        'telecom-media'      => ['Resolves the intent or escalates with the transcript attached. It never closes a conversation it did not resolve.', 'Escalate, never deflect'],
    ],
];
$lns_first = $lns_jobs[0][0];
?>
<noscript><style>
  .ind-lns__tabs{display:grid}
  .ind-lns__tabs [role="tab"]{cursor:default}
  .ind-lns__panes{display:grid;gap:clamp(28px,4vw,56px)}
  .ind-lns__panes>.bdh-pane{grid-area:auto;opacity:1;visibility:visible;transform:none}
</style></noscript>
<section class="band band--alt ind-lns" id="lens" aria-labelledby="lens-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The same job, six ways</p>
        <h2 class="h2" id="lens-t"><span class="g">The work has the same name</span> and almost none of the same constraints.</h2>
      </div>
      <div>
        <p class="lead">Five jobs sit inside every programme we run. Choose one and read it across all six sectors: the category is the difference, not the discipline.</p>
      </div>
    </div>

    <div class="ind-lns__app" data-rv data-rv-d="60">
      <div class="ind-lns__tabs" role="tablist" aria-label="Recurring jobs">
        <?php foreach ($lns_jobs as $lns_i => $lns_j): ?>
          <button type="button" role="tab" id="lens-t<?= $lns_i ?>" aria-controls="lens-p<?= $lns_i ?>" aria-selected="<?= $lns_i ? 'false' : 'true' ?>" tabindex="<?= $lns_i ? '-1' : '0' ?>">
            <span class="ind-lns__tn"><?= str_pad((string) ($lns_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <span class="ind-lns__ti" aria-hidden="true"><?= xt_icon($lns_j[3], ['size' => 18]) ?></span>
            <span class="ind-lns__tt"><?= e($lns_j[1]) ?></span>
          </button>
        <?php endforeach; ?>
      </div>

      <div class="ind-lns__panes bdh-panes">
        <?php foreach ($lns_jobs as $lns_i => $lns_j): ?>
          <div class="bdh-pane ind-lns__pane<?= $lns_i ? '' : ' is-on' ?>" id="lens-p<?= $lns_i ?>" role="tabpanel" aria-labelledby="lens-t<?= $lns_i ?>" tabindex="0">
            <div class="ind-lns__q">
              <h3 class="ind-lns__qt"><?= e($lns_j[2]) ?></h3>
              <p class="ind-lns__qd"><?= e($lns_j[4]) ?></p>
            </div>
            <div class="bdh-scroll-x mask-x ind-lns__scroll" tabindex="0" role="region" aria-label="<?= e($lns_j[1]) ?>, compared across the six sectors">
              <table class="ind-ledger ind-lns__tbl">
                <caption class="sr"><?= e($lns_j[1]) ?> — <?= e($lns_j[2]) ?> — answered for each of the six sectors.</caption>
                <thead><tr><th scope="col">Sector</th><th scope="col"><?= e($lns_j[1]) ?></th><th scope="col">What shapes it</th></tr></thead>
                <tbody>
                  <?php foreach ($IND as $lns_s):
                      if ($lns_j[0] === 'number') { $lns_a = $lns_s['kpi_def']; $lns_c = $lns_s['kpi']; }
                      else { [$lns_a, $lns_c] = $lns_cells[$lns_j[0]][$lns_s['id']]; } ?>
                    <tr>
                      <th scope="row"><a href="#<?= e($lns_s['id']) ?>"><span class="ind-lns__sn"><?= e($lns_s['n']) ?></span><?= e($lns_s['name']) ?></a></th>
                      <td><?= e($lns_a) ?></td>
                      <td><span class="bdh-tag bdh-tag--blue"><?= e($lns_c) ?></span></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <p class="ind-note ind-lns__note">This is why a playbook from one category rarely survives the move to another. The method transfers; the constraint does not.<span class="ind-lns__swipe"> Swipe each table to read the right-hand column.</span> <a class="tl" href="#transfer">See what does travel <span class="i" aria-hidden="true">›</span></a></p>
  </div>
</section>
