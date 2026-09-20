<?php /* DRAFT COPY — review before launch */
/* Delivery — from first call to a platform your teams run. A programme swimlane: five phases (Discover · Design
   · Build · Launch · Run) across four lanes by discipline (Product & design, Engineering, AI & data, Security &
   quality), with four gates on the phase boundaries. The phase headers are tabs: choosing one opens a pane with
   the decision it ends in, the artefacts, who is in the room, where agents assist and the gate. delivery.js
   grows the lane bars on entry and walks a playhead through the gates, selecting each phase, until the reader
   takes over. HTML = the finished board with Build selected. */
// PLACEHOLDER: confirm typical phase lengths before launch
$dlv_phases = [
    // [name, weeks, decision, artefacts, in the room, agents assist, gate after it or '']
    ['Discover', 'Wk 1–2',
     'What to build first, what it must achieve, and whether the data can support it.',
     ['Problem statement and success measures', 'Current-state architecture map', 'Data and AI-readiness assessment', 'Risk register and DPIA screening'],
     ['Your sponsor', 'Your product owner', 'Domain experts', 'Programme lead', 'Solution architect', 'AI lead'],
     ['Turns interview notes and tickets into themes, with sources attached', 'Maps systems and data flows from your documents and repositories', 'Drafts the first risk register for people to review'],
     ''],
    ['Design', 'Wk 2–4',
     'The architecture, the build order and the quality gates the build has to pass.',
     ['Reference architecture and decision records', 'Prototype tested with real users', 'Golden set and eval plan', 'Threat model and security architecture', 'Sprint plan with goals'],
     ['Solution architect', 'Tech lead', 'Product designer', 'Security engineer', 'Your IT and security leads'],
     ['Drafts architecture options with trade-offs for the architect to decide', 'Generates prototype variants from the design system', 'Proposes golden-set cases from real tickets'],
     'Architecture approved'],
    ['Build', 'Wk 4–16',
     'Every two weeks: what ships this sprint, shown working in the demo.',
     ['Working software every sprint', 'Tests, evals and scans in CI on every change', 'Runbooks written as features land', 'A decision log kept current'],
     ['Tech lead', 'Engineers', 'Product designer', 'QA and eval engineer', 'Your product owner, weekly'],
     ['Pairs with engineers in the IDE; people review every line', 'Writes tests and pull-request summaries', 'Runs the eval suite on every change and flags regressions'],
     'Security sign-off'],
    ['Launch', 'Wk 16–18',
     'Go live, with the rollback rehearsed and the on-call rota staffed.',
     ['Load-test report at expected peak', 'Independent penetration-test report', 'Cutover plan and rollback rehearsal', 'On-call rota, runbooks and training'],
     ['Release manager', 'Site reliability engineer', 'Security engineer', 'Your support lead', 'Your sponsor'],
     ['Compares AI outputs with people in shadow mode before anything goes live', 'Watches the canary and rolls back on its own if error rates move', 'Drafts release notes and training material'],
     'Go-live'],
    ['Run', 'Wk 18 →',
     'Every month: what to improve next, decided on SLOs, evals and cost.',
     ['Monthly service report: SLOs, evals, cost and carbon', 'Incident reviews without blame', 'A ranked improvement backlog', 'The 90-day review'],
     ['Service owner', 'On-call squad', 'Your product owner', 'Your finance partner, for cloud cost'],
     ['Triages alerts and drafts incident timelines', 'Watches for eval drift after model or data changes', 'Flags cost anomalies with a proposed fix for approval'],
     '90-day review'],
];
$dlv_sel = 2;
$dlv_lanes = [
    // lane => [[from phase, to phase, label], …]
    'Product & design'   => [[0, 0, 'Interviews · journey map'], [1, 1, 'Prototype tested with users'], [2, 2, 'UX in every sprint · design system'], [3, 3, 'Training · launch comms'], [4, 4, 'Usage analytics · roadmap']],
    'Engineering'        => [[0, 0, 'Current-state map'], [1, 1, 'Architecture · ADRs'], [2, 2, 'Two-week sprints · demo each sprint'], [3, 3, 'Cutover · hypercare'], [4, 4, 'Managed platform · SLOs']],
    'AI & data'          => [[0, 0, 'Data & readiness audit'], [1, 1, 'Golden set · eval plan'], [2, 2, 'RAG and agents · evals in CI'], [3, 3, 'Shadow → canary'], [4, 4, 'Drift and eval monitoring']],
    'Security & quality' => [[0, 1, 'Threat model · DPIA screening'], [2, 2, 'SAST · tests · red-team in CI'], [3, 3, 'Pen test · load test'], [4, 4, 'Vulnerability SLAs · audit']],
];
$dlv_gate_n = 0;
$dlv_rituals = [
    ['calendar', 'Two-week sprints',       'A goal per sprint, agreed with your product owner.'],
    ['browser',  'A demo every sprint',    'Working software, not slides, on a preview environment.'],
    ['log',      'A decision log',         'Architecture decision records, so choices outlive the people who made them.'],
    ['doc',      'Runbooks before go-live', 'Written as features land and rehearsed before launch.'],
];
?>
<section class="band band--alt tih-delivery" id="delivery" aria-labelledby="delivery-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>How a programme runs</p>
        <h2 class="h2" id="delivery-t"><span class="g">From first call</span> to a platform your teams run.</h2>
      </div>
      <div>
        <p class="lead">Four disciplines work in the same sprints from week one, and four gates decide when the work moves on. Choose a phase to see the decision it ends in, who is in the room and where agents do the legwork.</p>
      </div>
    </div>

    <!-- PLACEHOLDER: confirm typical phase lengths and team make-up before launch -->
    <div class="tih-dlv" data-rv data-rv-d="60">
      <p class="bdh-sr">A programme plan in five phases, Discover in weeks 1 to 2, Design in weeks 2 to 4, Build in weeks 4 to 16, Launch in weeks 16 to 18 and Run from week 18, across four lanes: product and design, engineering, AI and data, security and quality. Gates: architecture approved after Design, security sign-off after Build, go-live after Launch, and a 90-day review in Run.</p>
      <div class="tih-dlv__scroll bdh-scroll-x" tabindex="0" role="region" aria-label="Programme plan, scroll sideways on small screens">
        <div class="tih-dlv__board" data-bdh-in>
          <div class="tih-dlv__row tih-dlv__row--head">
            <span class="tih-dlv__corner"><span class="tih-k">Lane</span><span class="tih-k">Phase · typical</span></span>
            <div class="tih-dlv__tabs" role="tablist" aria-label="Programme phases">
              <?php foreach ($dlv_phases as $dlv_i => $dlv_p): ?>
                <button type="button" role="tab" class="tih-dlv__ph" id="delivery-t<?= $dlv_i ?>" aria-controls="delivery-p<?= $dlv_i ?>" aria-selected="<?= $dlv_i === $dlv_sel ? 'true' : 'false' ?>" tabindex="<?= $dlv_i === $dlv_sel ? '0' : '-1' ?>">
                  <span class="tih-dlv__pn"><b><?= str_pad((string) ($dlv_i + 1), 2, '0', STR_PAD_LEFT) ?></b><?= e($dlv_p[0]) ?></span>
                  <span class="tih-dlv__pw"><?= e($dlv_p[1]) ?></span>
                  <?php if ($dlv_p[0] === 'Build'): ?><span class="tih-dlv__spr" aria-hidden="true"><?php for ($dlv_k = 1; $dlv_k <= 6; $dlv_k++): ?><i>S<?= $dlv_k ?></i><?php endfor; ?></span><?php endif; ?>
                </button>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="tih-dlv__gates" aria-hidden="true">
            <span class="tih-dlv__corner"></span>
            <div class="tih-dlv__gl">
              <?php foreach ($dlv_phases as $dlv_i => $dlv_p): if ($dlv_p[6] === '') continue; $dlv_gate_n++; ?>
                <span class="tih-dlv__gate" data-after="<?= $dlv_i ?>" title="Gate <?= $dlv_gate_n ?>: <?= e($dlv_p[6]) ?>, at the end of <?= e($dlv_p[0]) ?>"><i></i><b>G<?= $dlv_gate_n ?></b><em><?= e($dlv_p[6]) ?></em></span>
              <?php endforeach; ?>
            </div>
          </div>
          <p class="tih-dlv__gkey" aria-hidden="true"><?php $dlv_kn = 0; foreach ($dlv_phases as $dlv_p): if ($dlv_p[6] === '') continue; $dlv_kn++; ?><span><b>G<?= $dlv_kn ?></b><?= e($dlv_p[6]) ?> · ends <?= e($dlv_p[0]) ?></span><?php endforeach; ?></p>

          <?php $dlv_li = 0; foreach ($dlv_lanes as $dlv_lane => $dlv_bars): ?>
            <div class="tih-dlv__row">
              <span class="tih-dlv__lane"><?= e($dlv_lane) ?></span>
              <div class="tih-dlv__cells" aria-hidden="true">
                <?php foreach ($dlv_bars as $dlv_bi => $dlv_b): ?>
                  <span class="tih-dlv__bar bdh-grow<?= ($dlv_b[0] <= $dlv_sel && $dlv_b[1] >= $dlv_sel) ? ' is-sel' : '' ?>" data-from="<?= $dlv_b[0] ?>" data-to="<?= $dlv_b[1] ?>" style="grid-column:<?= $dlv_b[0] + 1 ?> / <?= $dlv_b[1] + 2 ?>;--i:<?= $dlv_li * 2 + $dlv_bi ?>"><?= e($dlv_b[2]) ?></span>
                <?php endforeach; ?>
              </div>
            </div>
          <?php $dlv_li++; endforeach; ?>

          <span class="tih-dlv__play" aria-hidden="true"><i></i></span>
        </div>
      </div>

      <div class="tih-dlv__panes bdh-panes">
        <?php foreach ($dlv_phases as $dlv_i => $dlv_p): ?>
          <div class="bdh-pane tih-dlv__pane<?= $dlv_i === $dlv_sel ? ' is-on' : '' ?>" id="delivery-p<?= $dlv_i ?>" role="tabpanel" aria-labelledby="delivery-t<?= $dlv_i ?>">
            <div class="tih-dlv__ph1">
              <p class="tih-k">Phase <?= str_pad((string) ($dlv_i + 1), 2, '0', STR_PAD_LEFT) ?> · <?= e($dlv_p[1]) ?></p>
              <h3 class="tih-dlv__pt"><?= e($dlv_p[0]) ?></h3>
              <p class="tih-dlv__dec"><span class="tih-k">Ends in a decision</span><?= e($dlv_p[2]) ?></p>
              <?php if ($dlv_p[6] !== ''): ?>
                <p class="tih-dlv__pg"><i aria-hidden="true"></i>Gate · <?= e($dlv_p[6]) ?></p>
              <?php endif; ?>
            </div>
            <div class="tih-dlv__col">
              <p class="tih-k">Artefacts</p>
              <ul class="bdh-bullets"><?php foreach ($dlv_p[3] as $dlv_a): ?><li><?= e($dlv_a) ?></li><?php endforeach; ?></ul>
            </div>
            <div class="tih-dlv__col">
              <p class="tih-k">In the room</p>
              <p class="tih-dlv__room"><?php foreach ($dlv_p[4] as $dlv_r): ?><span class="bdh-tag<?= strpos($dlv_r, 'Your') === 0 ? ' bdh-tag--blue' : '' ?>"><?= e($dlv_r) ?></span><?php endforeach; ?></p>
            </div>
            <div class="tih-dlv__col tih-dlv__col--ai">
              <p class="tih-k"><?= xt_icon('agent', ['size' => 14]) ?> Where agents assist</p>
              <ul class="tih-dlv__ai"><?php foreach ($dlv_p[5] as $dlv_x): ?><li><?= e($dlv_x) ?></li><?php endforeach; ?></ul>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="tih-dlv__foot">
      <!-- PLACEHOLDER: reference photograph (Unsplash) — replace with commissioned/own imagery before launch -->
      <figure class="bdh-img bdh-img--r43 tih-dlv__img" data-rv>
        <img src="<?= xe_url('assets/imgs/tech/hub/delivery-whiteboard.jpg') ?>" alt="Two colleagues working through a diagram on a whiteboard" width="1400" height="934" loading="lazy" decoding="async">
        <span class="bdh-cap-chip tih-dlv__chip"><b>Design · week 3</b>Architecture options on the wall before any are built</span>
      </figure>
      <ul class="tih-dlv__rit" data-rv-s data-rv-step="80">
        <?php foreach ($dlv_rituals as $dlv_ri): ?>
          <li>
            <span class="tih-dlv__ri" aria-hidden="true"><?= xt_icon($dlv_ri[0], ['size' => 20]) ?></span>
            <h3 class="bdh-t bdh-t--s"><?= e($dlv_ri[1]) ?></h3>
            <p class="bdh-d"><?= e($dlv_ri[2]) ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
