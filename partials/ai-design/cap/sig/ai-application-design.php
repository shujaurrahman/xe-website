<?php /* DRAFT COPY — review before launch */
/* Signature — an assistant conversation: question, a visible read-only plan of tool calls, a cited answer that
   admits what it could not read, and a consequential action held for approval. Items carry data-s (step 1–4). */
$aid_sig = [
    'head'  => 'assistant <b>/</b> your-platform <b>/</b> renewals',
    'sr'    => 'Illustration: an assistant conversation. A user asks which enterprise contracts renew before March and whether pricing terms changed. The assistant shows a read-only plan of three tool calls, answers with three numbered citations, says two scanned contracts could not be read, and proposes drafting reminders to three account owners, which waits for the user to approve.',
    'steps' => [
        ['Ask',          'Step 1 of 4: the user asks a question.'],
        ['Plan & tools', 'Step 2 of 4: the assistant shows its read-only plan and runs three tool calls.'],
        ['Cited answer', 'Step 3 of 4: the answer arrives with citations and says what it could not read.'],
        ['Approve',      'Step 4 of 4: a proposed action waits for the user to approve it.'],
    ],
];
ob_start(); ?>
<div class="aid-chat">
  <div class="aid-msg aid-msg--u" data-s="1"><span class="aid-who">You</span><p>Which enterprise contracts renew before March, and did any pricing terms change?</p></div>
  <div class="aid-plan" data-s="2">
    <p class="aid-k"><span>Plan · 3 steps</span><span>Read-only</span></p>
    <ol>
      <li><code>contracts.search</code><span>renews &lt; 31 Mar · enterprise</span><em class="ok">14 found</em></li>
      <li><code>clauses.read</code><span>pricing, indexation × 14</span><em class="ok">12 read</em></li>
      <li><code>clauses.diff</code><span>against the previous term</span><em>3 changed</em></li>
    </ol>
  </div>
  <div class="aid-msg aid-msg--a" data-s="3">
    <span class="aid-who">Assistant</span>
    <p>14 contracts renew before 31 March. Three changed pricing terms: two moved to CPI indexation <sup>1</sup> <sup>2</sup> and one removed a volume discount <sup>3</sup>.</p>
    <ul class="aid-cite"><li><b>1</b>MSA-2291 · §7.2</li><li><b>2</b>MSA-2310 · §7.1</li><li><b>3</b>MSA-2187 · Sch. B</li></ul>
    <p class="aid-conf"><span class="aid-flag">Partial</span>2 contracts are scanned images and were not read.</p>
  </div>
  <div class="aid-act" data-s="4">
    <div><p class="aid-k"><span>Proposed action · needs approval</span></p><p class="aid-act__t">Draft renewal reminders to 3 account owners</p></div>
    <div class="aid-act__b"><span class="aid-btn">Edit plan</span><span class="aid-btn aid-btn--go">Approve</span></div>
  </div>
</div>
<?php $aid_sig['body'] = ob_get_clean();
