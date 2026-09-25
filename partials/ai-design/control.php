<?php /* DRAFT COPY — review before launch */
/* Control — guardrails, misuse testing and the human approval gate. Three cards for what goes in, what
   comes out and what the system is allowed to do; a red-team table under them; and, beside a photograph
   of a review in progress, the rule about who signs what.
 *
 * The OWASP references are exact: LLM01 prompt injection, LLM02 sensitive information disclosure,
 * LLM06 excessive agency, LLM08 vector and embedding weaknesses (OWASP Top 10 for LLM Applications).
 * Uses .aih-card (the card system) and .aih-ledger (the record table) from assets/css/ai-design.css.
 */
$ct_groups = [
    [
        'n'    => '01',
        'icon' => 'shield',
        'name' => 'Into the model',
        'sub'  => 'Input guardrails',
        'list' => [
            'Untrusted text — a web page, a document, an email, a customer message — checked for prompt injection before it reaches a model (OWASP LLM01).',
            'Personal data and secrets stripped or tokenised before a request leaves your boundary.',
            'Prompts outside the brief or outside the policy refused, with the refusal recorded rather than silently dropped.',
            'Uploads scanned, and the file type and size limited to what the task actually needs.',
        ],
    ],
    [
        'n'    => '02',
        'icon' => 'eye',
        'name' => 'Out of the model',
        'sub'  => 'Output guardrails',
        'list' => [
            'Third-party marks, logos and trade dress blocked, with a blocklist kept current by your brand team.',
            'A named or recognisable person blocked unless consent is on file for that use.',
            'Unsubstantiated and comparative claims flagged to a person rather than published.',
            'Sensitive information disclosure checked on the way out, not only on the way in (OWASP LLM02).',
        ],
    ],
    [
        'n'    => '03',
        'icon' => 'lock',
        'name' => 'What it may do',
        'sub'  => 'Agency limits',
        'list' => [
            'Tools on an allow-list. An agent can only reach what it was given, and only for the task it was given.',
            'No irreversible action without a person approving that step (OWASP LLM06, excessive agency).',
            'Spend, rate and concurrency capped per tool, per team and per day.',
            'Every action logged with its inputs, so what happened can be read back and undone.',
        ],
    ],
];
$ct_red = [
    // [suite, what it probes, reference, when it runs]
    ['Prompt injection',      'Instructions hidden in retrieved documents, images, filenames and customer text.', 'OWASP LLM01', 'Before every release'],
    ['Jailbreak & misuse',    'Attempts to make a brand model produce a competitor’s mark, a real person or a banned claim.', 'OWASP LLM01', 'Before every release'],
    ['Data exfiltration',     'Whether a crafted prompt can pull training material, a system prompt or another tenant’s data back out.', 'OWASP LLM02', 'Before every release'],
    ['Retrieval poisoning',   'A document planted in the index, and what the model does with an embedding it should not trust.', 'OWASP LLM08', 'On every index change'],
    ['Agency escape',         'Whether a tool can be reached, chained or re-used outside the task it was approved for.', 'OWASP LLM06', 'Before every release'],
];
$ct_always = [
    'Publishing anything synthetic, in any market',
    'Any likeness of a person, real or generated',
    'Any claim, comparison or price on a generated asset',
    'Releasing a new model, adapter or prompt version',
    'Changing a guardrail, a blocklist or a threshold',
];
$ct_never = [
    'Internal exploration and drafts nobody sees',
    'Resizes and crops of an already approved master',
    'Variants assembled only from approved components',
];
?>
<section class="band aih-ct" id="control" aria-labelledby="control-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Guardrails &amp; approval</p>
        <h2 class="h2" id="control-t"><span class="g">The guardrails are the design.</span> So is the person who says yes.</h2>
      </div>
      <div>
        <p class="lead">A generative tool put in front of a team will eventually be asked for something the brand must never make. That is not a failure of the team. It is what the guardrails, the misuse testing and the approval step are for, and all three are built before anyone is given the tool.</p>
        <p class="aih-note">References below are to the OWASP Top 10 for LLM Applications, by their published identifiers.</p>
      </div>
    </div>

    <div class="aih-cards aih-cards--3 aih-ct__cards" data-rv data-rv-d="50">
      <?php foreach ($ct_groups as $ct_g): ?>
        <article class="aih-card">
          <div class="aih-card__rail">
            <span class="aih-card__ico"><?= xt_icon($ct_g['icon'], ['size' => 20]) ?></span>
            <span class="aih-card__n"><?= e($ct_g['n']) ?></span>
          </div>
          <h3 class="aih-card__t"><?= e($ct_g['name']) ?></h3>
          <p class="aih-k aih-ct__sub"><?= e($ct_g['sub']) ?></p>
          <ul class="bdh-bullets aih-ct__list">
            <?php foreach ($ct_g['list'] as $ct_l): ?><li><?= e($ct_l) ?></li><?php endforeach; ?>
          </ul>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="bdh-grid aih-ct__low">
      <div class="bdh-c7 aih-ct__red" data-rv data-rv-d="40">
        <div class="aih-panel aih-panel--flat">
          <div class="aih-panel__bar">
            <span class="aih-panel__title">misuse testing <i>/</i> run before release, not after an incident</span>
          </div>
          <div class="aih-panel__body">
            <p class="aih-note aih-ct__hint">The table scrolls sideways on a narrow screen.</p>
            <div class="bdh-scroll-x aih-ct__wrap" tabindex="0" role="group" aria-label="Misuse testing suites, scroll sideways on a narrow screen">
              <table class="aih-ledger aih-ct__tbl">
                <thead>
                  <tr><th scope="col">Suite</th><th scope="col">What it probes</th><th scope="col">Reference</th><th scope="col">When</th></tr>
                </thead>
                <tbody>
                  <?php foreach ($ct_red as $ct_r): ?>
                    <tr>
                      <th scope="row"><?= e($ct_r[0]) ?></th>
                      <td><?= e($ct_r[1]) ?></td>
                      <td><b><?= e($ct_r[2]) ?></b></td>
                      <td><?= e($ct_r[3]) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <p class="aih-ct__after">Findings are written up with a severity, fixed, and then retested on the same suite. The report is handed over, including the tests that passed, so your own team can run them again after we leave.</p>
          </div>
        </div>
      </div>

      <div class="bdh-c5 aih-ct__human" data-rv data-rv-d="70">
        <!-- PLACEHOLDER: reference photograph (Unsplash, credited in assets/imgs/ai-design/hub/CREDITS.md) — replace with commissioned or own imagery before launch -->
        <figure class="bdh-img bdh-img--r43 aih-ct__photo">
          <img src="<?= xe_url('assets/imgs/ai-design/hub/control-review.jpg') ?>" alt="Two colleagues reviewing work together at a whiteboard" width="1400" height="934" loading="lazy" decoding="async">
          <figcaption class="bdh-cap-chip aih-ct__chip"><b>The approval gate</b>Direction and approval stay with people. The machine does the repetition.</figcaption>
        </figure>

        <div class="aih-ct__gate">
          <div class="aih-ct__gc">
            <p class="aih-k aih-k--blue">Always needs a named person</p>
            <ul class="bdh-bullets">
              <?php foreach ($ct_always as $ct_a): ?><li><?= e($ct_a) ?></li><?php endforeach; ?>
            </ul>
          </div>
          <div class="aih-ct__gc">
            <p class="aih-k">Does not</p>
            <ul class="bdh-bullets aih-ct__nb">
              <?php foreach ($ct_never as $ct_n): ?><li><?= e($ct_n) ?></li><?php endforeach; ?>
            </ul>
          </div>
        </div>
        <p class="aih-note">Approval is a queue with named owners, not a group chat. Who approved what, on which model version, with which rights record attached, is the next section.</p>
      </div>
    </div>
  </div>
</section>
