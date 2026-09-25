<?php /* DRAFT COPY — review before launch */
/* AI in the day — the ink band. Concrete, not a claim: five stages of a normal piece of work with the
   agent's column and the human's column side by side, and a mock approval log beside it showing an
   eval gate failing and a human signing the release. The log is decorative (aria-hidden) with a
   .bdh-sr sentence describing it. Nothing here is filled with --blue, so the icon accent is untouched.
   Locals prefixed ai_. */

$ai_rows = [
    ['Research and gather', 'Pulls sources, transcribes calls, summarises, tags and de-duplicates.', 'Decide what is true, what is relevant, and what is missing.'],
    ['Generate options',    'Produces variants inside the brand system at volume, on-spec and on-grid.', 'Direct it, kill most of it, and choose the one worth refining by hand.'],
    ['Build and test',      'Scaffolds, writes the obvious tests, runs the eval suite and the accessibility sweep on every commit.', 'Design the system, and own what the suite finds.'],
    ['Review',              'Flags contrast failures, reading level, dead links, policy breaches and factual drift.', 'Approve. Nothing client-facing ships without a named human approval.'],
    ['Report',              'Assembles the numbers and a first draft of the narrative.', 'Say what it means, what it cost, and what happens next.'],
];

/* the mock log — a plausible afternoon on one piece of work. No real names, no client names. */
$ai_log = [
    ['14:02', 'agent.research',  '42 sources → 9 kept',                   'ok'],
    ['14:20', 'agent.variants',  '120 generated · 6 shortlisted',         ''],
    ['15:05', 'eval.brand-tone', 'score 0.91 · baseline 0.88 → pass',     'ok'],
    ['15:06', 'eval.a11y',       'contrast 3.9:1 on caption → gate held', 'no'],
    ['15:24', 'human.fix',       'caption recoloured · re-run queued',    ''],
    ['15:29', 'eval.a11y',       'contrast 4.9:1 → pass',                 'ok'],
    ['15:31', 'human.approve',   'variant 04 · approved by you',          'ok'],
];

$ai_rules = ['owasp-llm', 'nist-ai-rmf', 'iso42001'];
?>
<section class="band band--ink car-ai" id="ai-native" aria-labelledby="ai-native-t">
  <span class="car-ai__dots dots-ink" aria-hidden="true"></span>
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>AI in the day</p>
        <h2 class="h2" id="ai-native-t"><span class="g">The machine takes the repetition.</span> You keep the judgement.</h2>
      </div>
      <div>
        <p class="lead">This is the part of the job most candidates ask about, so here it is in full. Agents do the work that is describable. Every gate that matters is a person, and the log says who.</p>
      </div>
    </div>

    <div class="car-ai__grid">
      <ol class="car-ai__ledger" data-rv-s data-rv-step="70">
        <li class="car-ai__head" aria-hidden="true">
          <span class="car-ai__hk">What the agent does</span>
          <span class="car-ai__hk car-ai__hk--you">What you do</span>
        </li>
        <?php foreach ($ai_rows as $ai_i => $ai_r): ?>
          <li class="car-ai__row">
            <span class="car-ai__n" aria-hidden="true"><?= str_pad((string) ($ai_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <h3 class="bdh-t car-ai__t"><?= e($ai_r[0]) ?></h3>
            <p class="car-ai__a"><span class="car-k">Agent</span><?= e($ai_r[1]) ?></p>
            <p class="car-ai__h"><span class="car-k car-k--blue">You</span><?= e($ai_r[2]) ?></p>
          </li>
        <?php endforeach; ?>
      </ol>

      <div class="car-ai__side" data-rv data-rv-d="100">
        <div class="bdh-ui bdh-ui--ink car-ai__log" aria-hidden="true" data-bdh-live>
          <div class="bdh-ui__bar">
            <span class="bdh-ui__dots"><i></i><i></i><i></i></span>
            <span>approval log · one engagement · today</span>
            <span class="bdh-pulse car-ai__pulse"></span>
          </div>
          <ul class="car-ai__lines" role="none">
            <?php foreach ($ai_log as $ai_l): ?>
              <li class="bdh-ro car-ai__line" data-s="<?= e($ai_l[3]) ?>">
                <span class="car-ai__ts"><?= e($ai_l[0]) ?></span>
                <span class="car-ai__ev"><?= e($ai_l[1]) ?></span>
                <span class="car-ai__ms"><?= e($ai_l[2]) ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
          <p class="car-ai__foot"><span class="bdh-flag">7</span>gates on this piece · 1 held · 1 human signature</p>
        </div>
        <p class="bdh-sr">An illustration of an approval log for one piece of work: the research agent keeps nine of forty-two sources, a variant agent shortlists six of a hundred and twenty, a brand-tone eval passes at 0.91 against a baseline of 0.88, an accessibility eval holds the release over a 3.9 to 1 contrast ratio, a person recolours the caption, the re-run passes at 4.9 to 1, and a person approves the release.</p>

        <div class="car-ai__rules">
          <p class="car-k">Frameworks we build to</p>
          <ul class="car-ai__badges" role="list">
            <?php foreach ($ai_rules as $ai_k): ?><?= xt_badge($ai_k, ['variant' => 'chip', 'tag' => 'li']) ?><?php endforeach; ?>
          </ul>
          <p class="car-ai__note">Frameworks we align delivery with. No certification or partner status is claimed by naming them, and you will be taught how we apply each one rather than expected to arrive knowing.</p>
        </div>
      </div>
    </div>
  </div>
</section>
