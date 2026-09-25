<?php /* DRAFT COPY — review before launch */
/* Why here, specifically — four claims, each with its evidence and a code-built visual.
   The four are a tablist when JavaScript runs (assets/js/careers/reasons.js, ARIA from BDH.tabs);
   without it the <noscript> rule below hides the tab strip and every panel stays open, so the
   shipped HTML is already the finished, readable state. Locals prefixed rsn_. */

$rsn_ring = [
    ['BR', 'Brand Design',                160,    64],
    ['TE', 'Technology & Intelligence',   243.14, 112],
    ['CA', 'Campaign & Content Design',   243.14, 208],
    ['AI', 'AI Design',                   160,    256],
    ['PX', 'Product & Experience Design', 76.86,  208],
    ['MT', 'Marketing Technology',        76.86,  112],
];
/* spokes trimmed to leave the hub and each node, with a gap, rather than running through them */
$rsn_spokes = [
    [160, 112, 160, 92], [201.57, 136, 218.89, 126], [201.57, 184, 218.89, 194],
    [160, 208, 160, 228], [118.43, 184, 101.11, 194], [118.43, 136, 101.11, 126],
];
$rsn_hand = [
    ['Source code and infrastructure code', 'In your repositories from the first commit'],
    ['Design files, tokens and templates',  'Editable, not flattened exports'],
    ['Prompts, eval sets and model config', 'Versioned beside the code they govern'],
    ['Decision log and runbooks',           'Why it is built this way, and how to run it'],
];
$rsn_locs = [];
foreach ($car_roles as $rsn_r) $rsn_locs[$rsn_r['loc']] = ($rsn_locs[$rsn_r['loc']] ?? 0) + 1;

$rsn_items = [
    ['k' => 'team',  'tab' => 'One team',        'n' => '01',
     't' => 'Six disciplines, one room, one engagement.',
     'p' => 'Brand, technology, campaign, AI, product and marketing technology are one company with one delivery model, not six agencies sharing a landlord. You will sit in reviews outside your own craft in your first month, and keep sitting in them.',
     'e' => [['users', 'No handoffs between companies', 'A strategist, an engineer and a designer are on the same engagement, reading the same decision log.'],
             ['doc',   'Written first',               'Briefs, decisions and reviews are written down, so the argument survives the meeting.'],
             ['eye',   'You see the whole shape',     'Junior people are in the client review, not briefed about it afterwards.']],
     'sr' => 'A ring of six discipline nodes — brand, technology, campaign, AI, product and marketing technology — joined by spokes to a single hub labelled one engagement.'],

    ['k' => 'ai',    'tab' => 'AI-native',       'n' => '02',
     't' => 'Agents do the repeatable work. People approve what ships.',
     'p' => 'Every hire gets their own AI workspace in week two and builds one agent for the repetitive part of their role. Nothing an agent produces reaches a client without a named person approving it, and every approval is logged.',
     'e' => [['eval',    'Evals before trust',   'An agent runs against a written test set before anyone relies on it. The pass rate is recorded, not remembered.'],
             ['approve', 'A human signs off',    'Approval is a person and a timestamp, not a policy sentence on a website.'],
             ['log',     'An audit trail by default', 'What ran, on what input, who approved it — kept for the life of the engagement.']],
     'sr' => 'A mock approval readout: an agent run against a twenty-case eval set, nineteen passes, one case held for a person to review, and an audit entry naming the approver.'],

    ['k' => 'owned', 'tab' => 'Client-owned',    'n' => '03',
     't' => 'What we make is handed over in full.',
     'p' => 'Code, design files, prompts, eval sets and the reasoning behind them go to the client, in their accounts, as the work is made. Nothing is held back as leverage. For you that means the work is real, it ships, and you can describe honestly what you did.',
     'e' => [['git-branch', 'Built in their repositories', 'Not ours, not a zip at the end. Your commits are in the history with your name on them.'],
             ['key',        'No hostage tooling',          'We do not build a dependency on us and then price it.'],
             ['handshake',  'Credit where it is due',      'Who did what is recorded in the decision log, so a reference call has something to point at.']],
     'sr' => 'A handover manifest listing source code and infrastructure code, design files and tokens, prompts and eval sets, and the decision log and runbooks, each marked as delivered to the client.'],

    ['k' => 'where', 'tab' => 'Where you are',   'n' => '04',
     't' => 'Two studios, and the rest of India.',
     'p' => 'Offices in New Delhi and Ludhiana, and remote roles open to anyone in India. Teams agree their own office days rather than having a policy handed to them, and the written-first habit is what keeps remote from meaning out of the loop.',
     'e' => [['pin',   'Two studios',        'New Delhi and Ludhiana. Client workshops happen in person when being in a room helps.'],
             ['globe', 'Remote in India',    'For every role marked remote. Occasional travel for workshops and team weeks.'],
             ['clock', 'Core overlap hours', 'A shared window for working together; the rest of the day is yours to plan.']],
     'sr' => 'Three location plates — New Delhi, Ludhiana and remote in India — each showing how many of the listed roles are based there.'],
];
?>
<noscript><style>.car-rsn__tabs{display:none}.car-rsn__pane{display:block}</style></noscript>
<section class="band band--alt car-rsn" id="reasons" aria-labelledby="reasons-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Why here</p>
        <h2 class="h2" id="reasons-t"><span class="g">Four reasons,</span> each with the evidence under it.</h2></div>
      <div><p class="lead">Every company says it is collaborative and AI-native. These are the four things about working here that are specific enough to check on your first day — and to hold us to if they turn out not to be true.</p></div>
    </div>

    <div class="car-rsn__box" data-car-rsn>
      <div class="car-rsn__tabs" role="tablist" aria-label="Reasons to join">
        <?php foreach ($rsn_items as $rsn_i => $rsn_it): ?>
          <button class="car-rsn__tab<?= $rsn_i === 0 ? ' is-on' : '' ?>" type="button" role="tab" id="rsn-t<?= $rsn_i ?>"
                  aria-controls="rsn-p<?= $rsn_i ?>" aria-selected="<?= $rsn_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $rsn_i === 0 ? '0' : '-1' ?>">
            <span class="car-rsn__tn"><?= e($rsn_it['n']) ?></span><span class="car-rsn__tl"><?= e($rsn_it['tab']) ?></span>
          </button>
        <?php endforeach; ?>
      </div>

      <?php foreach ($rsn_items as $rsn_i => $rsn_it): ?>
      <?php /* role="tabpanel", tabindex and aria-labelledby are added by assets/js/careers/reasons.js:
               without the script there is no tablist on the page, so a bare region with its own h3
               is the honest markup. */ ?>
      <div class="car-rsn__pane" id="rsn-p<?= $rsn_i ?>">
        <div class="car-rsn__copy">
          <p class="car-rsn__n" aria-hidden="true"><?= e($rsn_it['n']) ?> · <?= e($rsn_it['tab']) ?></p>
          <h3 class="car-rsn__t"><?= e($rsn_it['t']) ?></h3>
          <p class="car-rsn__p"><?= e($rsn_it['p']) ?></p>
          <ul class="car-rsn__ev">
            <?php foreach ($rsn_it['e'] as $rsn_e): ?>
            <li><span class="car-rsn__eico" aria-hidden="true"><?= xt_icon($rsn_e[0], ['size' => 18]) ?></span><b><?= e($rsn_e[1]) ?></b><span><?= e($rsn_e[2]) ?></span></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="car-rsn__vis">
          <?php if ($rsn_it['k'] === 'team'): ?>
            <div class="car-ring" aria-hidden="true" data-bdh-live>
              <svg class="car-ring__svg" viewBox="0 0 320 320" fill="none" stroke="currentColor" focusable="false">
                <circle class="car-ring__orbit" cx="160" cy="160" r="96" stroke-dasharray="2 6"/>
                <?php foreach ($rsn_spokes as $rsn_s): ?>
                  <line class="car-ring__spoke" x1="<?= $rsn_s[0] ?>" y1="<?= $rsn_s[1] ?>" x2="<?= $rsn_s[2] ?>" y2="<?= $rsn_s[3] ?>"/>
                <?php endforeach; ?>
                <circle class="car-ring__hub" cx="160" cy="160" r="40"/>
                <text class="car-ring__hubt" x="160" y="156" text-anchor="middle">ONE</text>
                <text class="car-ring__hubt" x="160" y="170" text-anchor="middle">TEAM</text>
                <?php foreach ($rsn_ring as $rsn_j => $rsn_nd): ?>
                  <g class="car-ring__node" style="--i:<?= $rsn_j ?>">
                    <circle class="car-ring__disc" cx="<?= $rsn_nd[2] ?>" cy="<?= $rsn_nd[3] ?>" r="26"/>
                    <circle class="car-ring__glow" cx="<?= $rsn_nd[2] ?>" cy="<?= $rsn_nd[3] ?>" r="26"/>
                    <text class="car-ring__nt" x="<?= $rsn_nd[2] ?>" y="<?= $rsn_nd[3] + 4 ?>" text-anchor="middle"><?= e($rsn_nd[0]) ?></text>
                  </g>
                <?php endforeach; ?>
              </svg>
              <ul class="car-ring__key">
                <?php foreach ($rsn_ring as $rsn_nd): ?><li><b><?= e($rsn_nd[0]) ?></b><?= e($rsn_nd[1]) ?></li><?php endforeach; ?>
              </ul>
            </div>

          <?php elseif ($rsn_it['k'] === 'ai'): ?>
            <div class="bdh-ui car-ai" aria-hidden="true">
              <div class="bdh-ui__bar"><span class="bdh-ro">AGENT RUN · brief-to-variants</span><span class="bdh-tag bdh-tag--blue">held for review</span></div>
              <ul class="car-ai__rows">
                <li><span class="bdh-ro">Eval set</span><b>20 cases · brand claims, tone, factual grounding</b></li>
                <li><span class="bdh-ro">Result</span><b>19 pass · 1 held</b><span class="car-ai__bar" style="--p:95%"><span class="car-ai__fill"></span></span></li>
                <li><span class="bdh-ro">Held case</span><b>Regulated claim without a source — routed to a person</b></li>
              </ul>
              <div class="car-ai__foot"><span class="bdh-ro">Approved by · practice lead</span><span class="bdh-ok">logged · D-0142</span></div>
            </div>

          <?php elseif ($rsn_it['k'] === 'owned'): ?>
            <div class="bdh-ui car-hand" aria-hidden="true">
              <div class="bdh-ui__bar"><span class="bdh-ro">HANDOVER · Your company</span><span class="bdh-tag">4 of 4 delivered</span></div>
              <ul class="car-hand__list">
                <?php foreach ($rsn_hand as $rsn_j => $rsn_h): ?>
                <li style="--i:<?= $rsn_j ?>"><span class="car-hand__tick"><?= xt_icon('check', ['size' => 14]) ?></span><b><?= e($rsn_h[0]) ?></b><span><?= e($rsn_h[1]) ?></span></li>
                <?php endforeach; ?>
              </ul>
            </div>

          <?php else: ?>
            <ul class="car-plates" aria-hidden="true">
              <?php foreach ($rsn_locs as $rsn_ln => $rsn_lc): ?>
              <li class="car-plate"><span class="car-plate__k"><?= xt_icon($rsn_ln === 'Remote (India)' ? 'globe' : 'pin', ['size' => 16]) ?> <?= $rsn_ln === 'Remote (India)' ? 'Remote' : 'Studio' ?></span>
                <b class="car-plate__t"><?= e($rsn_ln) ?></b>
                <span class="car-plate__n"><?= $rsn_lc ?> of <?= count($car_roles) ?> listed roles</span></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
          <p class="bdh-sr"><?= e($rsn_it['sr']) ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
