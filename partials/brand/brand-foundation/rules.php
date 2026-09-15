<?php /* DRAFT COPY — review before launch */
/* §5 Values as decision rules — pick a case; each value rule rules on it with a short reasoning
   trace, and the ruling is logged by a person. Values, cases and rulings are illustrative. */
$cbf_rules_v = [   // [name, rule]
    ['Traceable before persuasive', 'We do not make a claim we cannot show the source for.'],
    ['Earned, not discounted',      'Price reflects the work. We do not buy share with discounts.'],
    ['Useful in a minute',          'A first-time customer understands the offer within a minute.'],
    ['Standards over silos',        'We back open standards, even when a rival benefits.'],
];
$cbf_rules_c = [   // [title, context, [[answer yes|no|cond|na, reads, rules] × values], verdict, owner]
    ['Enter a discount marketplace', 'A large channel offers reach in exchange for a standing discount.', [
        ['yes',  'Listings reuse sourced product claims.',            'No conflict.'],
        ['no',   'Entry requires a permanent price reduction.',       'Conflicts with the rule as written.'],
        ['yes',  'The channel format is short and plain.',            'Supports the rule.'],
        ['na',   'No standard is involved.',                          'Not engaged.'],
    ], 'Decline as proposed. Counter with a fixed-price listing.', 'Commercial lead'],
    ['Launch in Market 03', 'Demand is proven; local proof points are not yet in hand.', [
        ['cond', 'Launch claims rely on proof from other markets.',   'Proceed once local sources are gathered.'],
        ['yes',  'Standard pricing is planned.',                      'Supports the rule.'],
        ['cond', 'The offer summary is not yet in the local language.', 'Proceed once it is translated and tested.'],
        ['yes',  'The launch uses the shared data format.',           'Supports the rule.'],
    ], 'Proceed, with two conditions logged against the launch plan.', 'Regional director'],
    ['Co-author a standard with a rival', 'A competitor proposes a shared reporting standard.', [
        ['yes',  'A shared standard makes figures easier to trace.',  'Supports the rule.'],
        ['na',   'No pricing effect.',                                'Not engaged.'],
        ['yes',  'Customers read one format instead of two.',         'Supports the rule.'],
        ['yes',  'This is the case the rule was written for.',        'Settles it.'],
    ], 'Proceed. The foundation settles what used to be a three-meeting debate.', 'Executive team'],
];
$cbf_rules_lbl = ['yes' => 'Yes', 'no' => 'No', 'cond' => 'If', 'na' => 'N/A'];
?>
<section class="band cbf-rules" id="rules" aria-labelledby="rules-t">
  <div class="wrap">
    <header class="cbf-head cbf-head--split" data-rv>
      <p class="cbf-head__sec"><b>§ 05</b>Decision rules</p>
      <div class="cbf-head__body">
        <h2 class="h2" id="rules-t"><span class="g">Values that settle arguments,</span> not values for the wall.</h2>
        <p class="lead"><?= e($CAP['offer'][2][1]) ?> Choose a case to see each rule reach a ruling, with its reasoning shown.</p>
      </div>
    </header>

    <!-- PLACEHOLDER: illustrative values, cases and rulings — confirm before launch -->
    <div class="cbf-rules__grid" data-cbf-rules>
      <div class="cbf-rules__cases">
        <p class="cbf-rules__cap"><span class="cbf-mono">Case file</span><span class="cbf-ill">Illustrative</span></p>
        <div class="cbf-rules__tabs" role="tablist" aria-label="Decision cases" aria-orientation="vertical">
          <?php foreach ($cbf_rules_c as $cbf_i => $cbf_c): ?>
            <button type="button" class="cbf-rules__case" role="tab" id="rules-tab-<?= $cbf_i ?>" aria-controls="rules-pane-<?= $cbf_i ?>" aria-selected="<?= $cbf_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $cbf_i === 0 ? '0' : '-1' ?>">
              <span class="cbf-rules__cn">Case 0<?= $cbf_i + 1 ?></span>
              <span class="cbf-rules__ct"><?= e($cbf_c[0]) ?></span>
              <span class="cbf-rules__cx"><?= e($cbf_c[1]) ?></span>
            </button>
          <?php endforeach; ?>
        </div>
        <p class="cbf-rules__note">Traces are drafted by an agent that reads the case against the foundation. The ruling is a person’s, and it is logged with their name.</p>
      </div>

      <div class="cbf-rules__panes">
        <?php foreach ($cbf_rules_c as $cbf_i => $cbf_c):
            $cbf_tally = array_count_values(array_column($cbf_c[2], 0)); ?>
          <div class="cbf-rules__pane" role="tabpanel" id="rules-pane-<?= $cbf_i ?>" aria-labelledby="rules-tab-<?= $cbf_i ?>" tabindex="0"<?= $cbf_i ? ' hidden' : '' ?>>
            <p class="cbf-rules__head"><span class="cbf-mono">Ruling · Case 0<?= $cbf_i + 1 ?></span><span class="cbf-rules__tally"><?php foreach ($cbf_rules_lbl as $cbf_k => $cbf_l): if (!empty($cbf_tally[$cbf_k])): ?><i class="is-<?= $cbf_k ?>"><?= $cbf_tally[$cbf_k] ?> <?= e($cbf_l) ?></i><?php endif; endforeach; ?></span></p>
            <ol class="cbf-rules__list">
              <?php foreach ($cbf_rules_v as $cbf_vi => $cbf_v): $cbf_a = $cbf_c[2][$cbf_vi]; ?>
                <li class="cbf-rules__row is-<?= $cbf_a[0] ?>" style="--i:<?= $cbf_vi ?>">
                  <div class="cbf-rules__rule">
                    <h3 class="cbf-rules__vn"><span class="cbf-rules__vi">V<?= $cbf_vi + 1 ?></span><?= e($cbf_v[0]) ?></h3>
                    <p class="cbf-rules__vt"><?= e($cbf_v[1]) ?></p>
                  </div>
                  <p class="cbf-rules__ans"><span class="bdh-sr">Answer: </span><?= e($cbf_rules_lbl[$cbf_a[0]]) ?></p>
                  <p class="cbf-rules__trace"><span><b>Reads</b><?= e($cbf_a[1]) ?></span><span><b>Rules</b><?= e($cbf_a[2]) ?></span></p>
                </li>
              <?php endforeach; ?>
            </ol>
            <div class="cbf-rules__verdict">
              <p class="cbf-rules__vl"><span class="cbf-mono">Decision</span><b><?= e($cbf_c[3]) ?></b></p>
              <p class="cbf-rules__own"><span class="cbf-mono">Logged by</span><b><?= e($cbf_c[4]) ?></b></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
