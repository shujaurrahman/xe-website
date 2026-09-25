<?php /* DRAFT COPY — review before launch */
/* AI-native, concretely: what each marketing agent is allowed to touch. The permission matrix is the contract;
   the four guardrails beside it are how it is enforced. */
$mth_ai_cols = ['Read profiles', 'Draft content', 'Build audiences', 'Send or publish', 'Move budget'];
/* y = allowed · a = with a person's approval · n = never · - = not its job; [code, note] */
$mth_ai_rows = [
    ['Brief assembler',  'Pulls goals, segment facts and past results into a campaign brief.', [['y', 'Aggregates'], ['y', 'Brief'], ['-', ''], ['n', ''], ['n', '']]],
    ['Variant drafter',  'Writes copy and layout variants from approved claims and components.', [['-', ''], ['y', 'Draft state'], ['-', ''], ['a', 'First send'], ['n', '']]],
    ['Audience builder', 'Turns a plain-language brief into a segment definition with its size.', [['y', 'Scoped'], ['-', ''], ['y', 'Draft state'], ['a', 'Activate'], ['n', '']]],
    ['Pre-flight QA',    'Checks links, legal lines, consent scope, rendering and brand rules.', [['y', 'Scoped'], ['n', 'Flags only'], ['n', 'Flags only'], ['y', 'Can block'], ['-', '']]],
    ['Budget proposer',  'Suggests reallocations with expected effect and confidence.', [['y', 'Aggregates'], ['-', ''], ['-', ''], ['-', ''], ['a', 'Above threshold']]],
    ['Lead router',      'Scores and routes inbound leads with the reasons shown.', [['y', 'Scoped'], ['-', ''], ['-', ''], ['y', 'Approved templates'], ['n', '']]],
];
$mth_ai_k = ['y' => 'Allowed', 'a' => 'Needs approval', 'n' => 'Never', '-' => 'Not its job'];
$mth_ai_g = [
    ['eval',   'Evaluated before release', 'Each agent is tested against a fixed set of real briefs and edge cases, including brand, claims and consent checks, and re-tested on every model or prompt change.'],
    ['gauge',  'Confidence has a floor',  'Below the threshold an agent hands over to a rule-based path or a person. The threshold is set per task and reviewed with the results.'],
    ['shield', 'Inbound text is untrusted', 'Replies, form fields and web pages an agent reads are treated as data, never as instructions, which is the defence against prompt injection (OWASP LLM01).'],
    ['log',    'Every step is logged',    'Inputs, model and prompt version, output, checks passed and the person who approved, kept with the campaign and exportable.'],
];
?>
<section class="band band--alt mth-ai" id="ai-native" aria-labelledby="ai-native-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>AI-native, with limits</p>
        <h2 class="h2" id="ai-native-t"><span class="g">Agents do the assembly.</span> People keep the send button.</h2>
      </div>
      <div><p class="lead">We deploy marketing agents with written permissions, the same way you would scope a new hire’s access. This is the default contract; yours is agreed in the first weeks.</p></div>
    </div>

    <div class="mth-ai__wrap">
      <div class="mth-ai__mx">
        <div class="bdh-scroll-x mask-x" tabindex="0" role="region" aria-label="Agent permission matrix">
          <table class="mth-ai__tbl" aria-label="What each marketing agent may do">
            <thead><tr><th scope="col">Agent</th><?php foreach ($mth_ai_cols as $mth_ai_c): ?><th scope="col"><?= e($mth_ai_c) ?></th><?php endforeach; ?></tr></thead>
            <tbody>
            <?php foreach ($mth_ai_rows as $mth_ai_r): ?>
              <tr>
                <th scope="row"><span class="mth-ai__an"><?= e($mth_ai_r[0]) ?></span><span class="mth-ai__ad"><?= e($mth_ai_r[1]) ?></span></th>
                <?php foreach ($mth_ai_r[2] as $mth_ai_ci => $mth_ai_cell): ?>
                <td data-k="<?= e($mth_ai_cols[$mth_ai_ci]) ?>"><span class="mth-ai__v mth-ai__v--<?= $mth_ai_cell[0] === '-' ? 'x' : $mth_ai_cell[0] ?>"><i aria-hidden="true"></i><span class="sr"><?= e($mth_ai_k[$mth_ai_cell[0]]) ?></span><?= $mth_ai_cell[1] !== '' ? '<em>' . e($mth_ai_cell[1]) . '</em>' : '' ?></span></td>
                <?php endforeach; ?>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <ul class="mth-ai__key" aria-label="Key">
          <?php foreach ($mth_ai_k as $mth_ai_kk => $mth_ai_kl): ?><li><span class="mth-ai__v mth-ai__v--<?= $mth_ai_kk === '-' ? 'x' : $mth_ai_kk ?>"><i aria-hidden="true"></i></span><?= e($mth_ai_kl) ?></li><?php endforeach; ?>
        </ul>
      </div>
      <ul class="mth-ai__guards">
        <?php foreach ($mth_ai_g as $mth_ai_gi): ?>
        <li><?= xt_icon($mth_ai_gi[0]) ?><div><h3 class="bdh-t bdh-t--s"><?= e($mth_ai_gi[1]) ?></h3><p class="bdh-d"><?= e($mth_ai_gi[2]) ?></p></div></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
