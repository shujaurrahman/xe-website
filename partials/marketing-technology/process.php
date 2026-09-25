<?php /* DRAFT COPY — review before launch */
/* Process — how an engagement runs, as a vertical spine of five phases with a gate that has to pass before
   the next one starts, and what we need from your side in each. Below it, the same stepper idiom laid
   horizontally: each capability's own four phases, straight from data/marketing-technology.php, behind a
   capability selector. Every phase and gate is in the markup; process.js only lights the phase the reader
   has reached and switches the capability pane, so with JavaScript off the whole thing reads as printed.
   PLACEHOLDER: every week range on this page is typical for work of this shape — confirm before launch. */
$pro_phases = [
    ['Frame', 'Wk 01–02',
     'An audit you can act on: the tools you pay for, the data you hold, the consent you can prove and the one thing worth fixing first. What good looks like is agreed before anything is built.',
     ['Stack & data audit', 'Measurement plan', 'Prioritised backlog'],
     'One definition of a conversion and of a customer, signed by marketing and by finance.',
     'A named owner in marketing, and read access to the systems in scope.'],
    ['Foundation', 'Wk 02–06',
     'The record and the plumbing under it: identity rules, consent capture, event tracking and the content model that every later stage reads from.',
     ['Identity & consent rules', 'Event tracking', 'Content model'],
     'One profile per person in a test set, with consent enforced at send rather than at list build.',
     'Access to source systems, and a decision on where the customer record will live.'],
    ['Build', 'Wk 05–11',
     'The first journeys, models, creative pipeline or CRM changes, built in the order that pays first and tested against real profiles rather than sample data.',
     ['First journeys live', 'Models in your platform', 'Runbooks'],
     'Every automated path has an entry rule, an exit rule, a suppression list and a holdout group.',
     'Approved content and claims, and a person who can sign off a send.'],
    ['Prove', 'Wk 09–13',
     'Holdouts, experiments and evals. Nothing is called a success on a platform-reported number, and anything that cannot show an incremental effect is changed or stopped.',
     ['Experiment readouts', 'Eval results', 'Baseline report'],
     'An incremental effect measured against a control, with the method written down.',
     'Patience for a holdout group, and agreement on the baseline before the programme starts.'],
    ['Run', 'Wk 13 onward',
     'Handover with documentation and an owner per stage, a weekly operating rhythm, and a backlog ranked by expected lift rather than by who asked last.',
     ['Documentation & owners', 'Operating rhythm', 'Improvement backlog'],
     'Your team can change a journey, a segment and a template without calling us.',
     'Time in the calendar for the weekly review, and one person accountable per stage.'],
];
$pro_first = array_key_first($CAPS);
?>
<section class="band mth-process" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>How it runs</p>
        <h2 class="h2" id="process-t"><span class="g">Five phases,</span> and a gate before each next one.</h2>
      </div>
      <div>
        <p class="lead">Marketing technology programmes fail in the same two ways: automating a process nobody agreed on, and modelling data nobody trusts. The gates exist to stop both. A phase does not start until the one before it has passed its gate.</p>
      </div>
    </div>

    <ol class="mth-pro__spine" data-rv data-rv-d="50">
      <?php foreach ($pro_phases as $pro_i => $pro_p): ?>
        <li class="mth-pro__ph<?= $pro_i === 0 ? ' is-on' : '' ?>" data-phase="<?= $pro_i ?>">
          <div class="mth-pro__lead">
            <p class="mth-pro__n"><?= str_pad((string) $pro_i, 2, '0', STR_PAD_LEFT) ?></p>
            <h3 class="mth-pro__t"><?= e($pro_p[0]) ?></h3>
            <p class="mth-pro__w"><?= e($pro_p[1]) ?></p>
          </div>
          <p class="mth-pro__d"><?= e($pro_p[2]) ?></p>
          <div class="mth-pro__out">
            <p class="mth-k">Out of this phase</p>
            <span class="bdh-tags"><?php foreach ($pro_p[3] as $pro_o): ?><span class="bdh-tag"><?= e($pro_o) ?></span><?php endforeach; ?></span>
          </div>
          <div class="mth-pro__gate">
            <p class="mth-k mth-k--blue">Gate to the next phase</p>
            <p class="mth-pro__gt"><?= e($pro_p[4]) ?></p>
            <p class="mth-k">From your side</p>
            <p class="mth-pro__you"><?= e($pro_p[5]) ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>

    <div class="mth-pro__caps" data-rv data-rv-d="60">
      <div class="mth-pro__ch">
        <div>
          <p class="mth-k mth-k--blue">Inside a capability</p>
          <h3 class="mth-pro__cht">Each capability has its own four</h3>
        </div>
        <div class="mth-pro__tabs bdh-tabs" role="tablist" aria-label="Capability delivery phases">
          <?php foreach ($CAPS as $pro_cs => $pro_c): $pro_on = $pro_cs === $pro_first; ?>
            <button class="mth-pro__tab" type="button" role="tab" id="pro-t-<?= e($pro_cs) ?>" aria-controls="pro-p-<?= e($pro_cs) ?>"
                    aria-selected="<?= $pro_on ? 'true' : 'false' ?>" tabindex="<?= $pro_on ? '0' : '-1' ?>">
              <b><?= e($pro_c['n']) ?></b><?= e($pro_c['short']) ?>
            </button>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="bdh-panes mth-pro__panes">
        <?php foreach ($CAPS as $pro_cs => $pro_c): $pro_on = $pro_cs === $pro_first; ?>
          <div class="bdh-pane mth-pro__pane<?= $pro_on ? ' is-on' : '' ?>" id="pro-p-<?= e($pro_cs) ?>" role="tabpanel"
               aria-labelledby="pro-t-<?= e($pro_cs) ?>" tabindex="0">
            <div class="mth-pro__ph2">
              <h4 class="mth-pro__pt"><?= $pro_c['process']['title'] ?></h4>
              <p class="mth-pro__pl"><?= e($pro_c['process']['lead']) ?></p>
              <a class="mth-capl" href="<?= e(($MTH['cap_href'])($pro_cs)) ?>"><b><?= e($pro_c['n']) ?></b><?= e($pro_c['name']) ?><i aria-hidden="true">›</i></a>
            </div>
            <ol class="mth-steps" style="--cols:4">
              <?php foreach ($pro_c['process']['steps'] as $pro_si => $pro_s): ?>
                <li class="mth-step<?= $pro_si === 0 ? ' is-on' : '' ?>">
                  <p class="mth-step__n"><?= str_pad((string) ($pro_si + 1), 2, '0', STR_PAD_LEFT) ?></p>
                  <p class="mth-step__t"><?= e($pro_s[0]) ?></p>
                  <p class="mth-step__w"><?= e($pro_s[1]) ?></p>
                  <p class="mth-step__d"><?= e($pro_s[2]) ?></p>
                  <span class="mth-step__o"><?php foreach ($pro_s[3] as $pro_o2): ?><span><?= e($pro_o2) ?></span><?php endforeach; ?></span>
                </li>
              <?php endforeach; ?>
            </ol>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
