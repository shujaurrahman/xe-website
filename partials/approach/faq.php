<?php /* DRAFT COPY — review before launch */
/* FAQ — the questions that actually get asked on a first call, grouped into three. Built on native
   <details>/<summary>, so it opens and closes with no JavaScript at all and every answer is reachable with
   the keyboard by default. Each answer points at the section of this page that carries it in depth.
   Question row: [question, answer, anchor or url, link label] */
// PLACEHOLDER: confirm start times, response times, the first-call format and the NDA position before launch
$fq_groups = [
  ['01', 'Getting started', 'What it takes to begin, and what we need from you.', [
    ['How quickly can you start?',
     'Usually within two to three weeks of a signed statement of work, and sooner for a sprint. The honest constraint is rarely our availability — it is how fast the first decisions can be made on your side.',
     '#delivery', 'How a project runs'],
    ['Can we start with something small?',
     'Yes, and most engagements do. A sprint answers one fixed question in one to three weeks and ends at a gate with a decision in your hands: whether to go further, and on what. Nothing about it assumes a larger programme follows.',
     '#contracts', 'Six ways to engage'],
    ['What do you need from us to make this work?',
     'Four things: a decision-maker with the authority to say yes, a named reviewer for about two hours a week, access we can actually use rather than a ticket queue, and honest access to the data — including the parts that are messy. Programmes stall on decisions far more often than on engineering.',
     '#governance', 'Who owns what'],
  ]],
  ['02', 'How we work', 'What the agents do, what people do, and what happens when something breaks.', [
    ['Who actually does the work — people or agents?',
     'Both, and the register says which. Agents do the repeatable legwork: synthesis, drafts, tests, scans and monitoring. People carry the judgement and the accountability. No agent merges code, deploys without an approved release, changes a guardrail, spends money or speaks to your customers.',
     '#agents', 'The agent register'],
    ['Will our data be used to train models?',
     'No. We use enterprise model endpoints with training turned off, in your region where that matters, and retention is set per project and written into the contract. What we take away from an engagement is what we learned, never what you own.',
     '#responsible', 'Responsible AI'],
    ['What happens if the AI gets something wrong in front of a customer?',
     'Most of the time it does not get that far: the guardrail holds anything unsourced or sensitive, and low confidence hands off to a person. When something does reach a customer, it follows the severity ladder — acknowledged, mitigated, then a written review with actions, owners and dates, sent to you whether or not you asked for it.',
     '#recovery', 'When it fails'],
    ['How do you stay fast without the quality dropping?',
     'The bars are numbers rather than adjectives, and they are checked on every change instead of at the end. A failed eval, a breached performance budget or a critical scan finding stops the merge. The speed comes from agents doing the legwork; the safety comes from the gates not moving.',
     '#quality', 'The quality bars'],
  ]],
  ['03', 'Commercial and legal', 'Price, ownership, and what happens if it ends.', [
    ['Do you work to a fixed price?',
     'For scoped work, yes. The estimate is a range that narrows at each gate, and the committed number is the one written into the statement of work after Define. For open-ended work we use a milestone or retainer model, where you approve and pay for one gate at a time.',
     '#scope', 'Scope, change and estimates'],
    ['Who owns what you build for us?',
     'You do. Deliverables are assigned to you on payment — code, designs, prompts, evals, data and documentation. Our pre-existing tools and know-how stay ours, and you get a licence to everything you need in order to run what we built.',
     '#handover', 'Handover and IP'],
    ['What happens if we want to stop?',
     'You give the notice set out in the signed agreement, we invoice the work to the point it stopped, and the handover manifest transfers. Because the accounts are in your name from day one, stopping is an administrative act rather than a migration project.',
     '#handover', 'The handover manifest'],
    ['Will you sign our NDA and our master agreement?',
     'Yes. We have standard terms, set out in the Commercial Policy, and where your signed agreement says something different, your signed agreement prevails. An NDA is signed before anything technical is shared.',
     'legal/commercial-policy.php', 'Commercial Policy'],
  ]],
];
$fq_facts = [
  ['First reply',  'One working day, from someone who would do the work'],
  ['First call',   '45 minutes, no slide deck'],
  ['Under NDA',    'Signed before anything technical is shared'],
  ['Outline plan', 'Shape, scope and a price range within a week'],
];
$fq_n = 0;
$fq_ld = [];
foreach ($fq_groups as $fq_g) { foreach ($fq_g[3] as $fq_q) {
    $fq_ld[] = ['@type' => 'Question', 'name' => $fq_q[0],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $fq_q[1]]];
} }
?>
<section class="band apr-fq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
        <h2 class="h2" id="faq-t"><span class="g">The questions</span> a first call actually starts with.</h2>
      </div>
      <div>
        <p class="lead">Including the awkward ones. Each answer points at the part of this page that carries it in full, so you can check the claim rather than take it.</p>
      </div>
    </div>

    <?php foreach ($fq_groups as $fq_g): ?>
    <div class="apr-fq__grp">
      <div class="apr-fq__gh">
        <p class="apr-k"><span class="apr-fq__gn"><?= e($fq_g[0]) ?></span><?= e($fq_g[1]) ?></p>
        <p class="apr-fq__gd"><?= e($fq_g[2]) ?></p>
      </div>
      <div class="apr-fq__list">
        <?php foreach ($fq_g[3] as $fq_q): $fq_n++; ?>
        <details class="apr-fq__d"<?= $fq_n === 1 ? ' open' : '' ?>>
          <summary class="apr-fq__s">
            <h3 class="apr-fq__q"><?= e($fq_q[0]) ?></h3>
            <span class="apr-fq__mk" aria-hidden="true"></span>
          </summary>
          <div class="apr-fq__a">
            <p><?= e($fq_q[1]) ?></p>
            <?php $fq_href = strpos($fq_q[2], '#') === 0 ? $fq_q[2] : xe_url($fq_q[2]); ?>
            <a class="apr-fq__lk" href="<?= e($fq_href) ?>"><?= e($fq_q[3]) ?> <span class="i" aria-hidden="true">›</span></a>
          </div>
        </details>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endforeach; ?>

    <div class="apr-fq__ask">
      <div class="apr-fq__akt">
        <h3 class="apr-fq__ah">Something here that does not fit your situation?</h3>
        <p class="apr-fq__ap">Ask the people who would run the work. No qualification call, no discovery deck — a straight answer about whether this is a good fit, including when it is not.</p>
        <a class="btn btn--ink btn--lg" href="<?= e(svc_contact_url([], null, 'approach')) ?>">Ask a direct question <span class="i" aria-hidden="true">›</span></a>
      </div>
      <!-- PLACEHOLDER: confirm response times, the first-call format and the NDA position before launch -->
      <dl class="apr-fq__facts">
        <?php foreach ($fq_facts as $fq_f): ?>
        <div><dt><?= e($fq_f[0]) ?></dt><dd><?= e($fq_f[1]) ?></dd></div>
        <?php endforeach; ?>
      </dl>
    </div>
  </div>
</section>
<script type="application/ld+json"><?= json_encode([
    '@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $fq_ld,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
