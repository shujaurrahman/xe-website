<?php /* DRAFT COPY — review before launch */
/* Model — the division of labour, stated before the stages so the rest of the page reads against it.
   Three columns: what the machine runs, the line between them, what people decide. The line is the
   approval gate, and it is drawn as a real rule rather than described. No motion beyond the shared
   reveal; the concrete detail lives in ai-native and assurance further down. */
$aprm_ops = [
    ['radar',    'Reading',   'Desk research, competitor reads, analytics summaries and ticket analysis, with sources attached.'],
    ['doc',      'Drafting',  'First drafts of specs, tests, copy variants, route options and release notes.'],
    ['eval',     'Checking',  'Evals, tests, security scans, accessibility scanners and performance budgets on every change.'],
    ['rocket',   'Shipping',  'Canary releases, threshold-triggered rollback, alert triage and incident timelines.'],
    ['log',      'Recording', 'Every action logged with its model, prompt version, inputs, output and reviewer.'],
];
$aprm_people = [
    ['target',    'What problem',   'Which problem is worth solving first, and what number it is judged on.'],
    ['compass',   'Which route',    'The trade-off nobody else can make for you: speed against control, scope against certainty.'],
    ['approve',   'What ships',     'Every merge and every production change is approved by a named person.'],
    ['shield',    'What we claim',  'Anything stated as fact to a customer is checked by a person against its source.'],
    ['handshake', 'Who is answerable', 'When something goes wrong, a named person calls you. Not a queue.'],
];
$aprm_facts = [
    ['Agents in delivery',   'Reading, drafting, checking, shipping, recording'],
    ['Agents never',         'Merge, waive a finding, change a gate, close an incident'],
    ['Human approval',       'Every merge · every production change · every claim'],
    ['Audit trail',          'Kept with the pull request and the release'],
];
?>
<section class="band apr-model" id="model" aria-labelledby="model-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The division of labour</p>
        <h2 class="h2" id="model-t"><span class="g">The operation is automated.</span> The judgement is not.</h2>
      </div>
      <div>
        <p class="lead">Agents do the reading, the drafting, the checking, the shipping and the recording,
          because they are faster and they never get bored. People decide what problem to solve, which
          trade-off to take, what may be claimed, and what is allowed to ship. Between the two there is a
          line, and it is an approval, not a policy statement.</p>
        <a class="tl" href="#stages">See the stages <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <p class="bdh-sr">Two columns. On the left, the five things agents run in delivery: reading, drafting,
      checking, shipping and recording. On the right, the five things people decide: what problem to solve,
      which route to take, what ships, what may be claimed, and who is answerable. Between them a rule
      marked "a named person approves", which every item on the left has to pass through.</p>

    <div class="apr-model__split" data-rv data-rv-d="70">
      <div class="apr-model__col">
        <p class="apr-model__ch"><span class="apr-k">Runs the operation</span><span class="bdh-tag">Agents</span></p>
        <ul class="apr-model__list">
          <?php foreach ($aprm_ops as $aprm_i => $aprm_o): ?>
            <li>
              <span class="apr-ico" aria-hidden="true"><?= xt_icon($aprm_o[0], ['size' => 18]) ?></span>
              <h3 class="bdh-t bdh-t--s"><?= e($aprm_o[1]) ?></h3>
              <p class="bdh-d"><?= e($aprm_o[2]) ?></p>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="apr-model__line" aria-hidden="true">
        <span class="apr-model__lr"></span>
        <span class="apr-model__lb"><?= xt_icon('approve', ['size' => 16, 'mono' => true]) ?>A named person approves</span>
        <span class="apr-model__lr"></span>
      </div>

      <div class="apr-model__col apr-model__col--p">
        <p class="apr-model__ch"><span class="apr-k">Runs the strategy</span><span class="bdh-tag bdh-tag--blue">People</span></p>
        <ul class="apr-model__list">
          <?php foreach ($aprm_people as $aprm_p): ?>
            <li>
              <span class="apr-ico" aria-hidden="true"><?= xt_icon($aprm_p[0], ['size' => 18]) ?></span>
              <h3 class="bdh-t bdh-t--s"><?= e($aprm_p[1]) ?></h3>
              <p class="bdh-d"><?= e($aprm_p[2]) ?></p>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <dl class="apr-defs apr-model__facts" data-rv data-rv-d="120">
      <?php foreach ($aprm_facts as $aprm_f): ?>
        <div><dt><?= e($aprm_f[0]) ?></dt><dd><?= e($aprm_f[1]) ?></dd></div>
      <?php endforeach; ?>
    </dl>
  </div>
</section>
