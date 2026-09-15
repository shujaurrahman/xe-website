<?php /* DRAFT COPY — review before launch */
/* Plate 06 — SIGNATURE: voice and tone tuner. Pick a context, dial formal↔warm and concise↔expansive;
   the voice agent rewrites the line (pre-authored matrix below, no live model), runs four voice checks,
   and only a person can approve the line into the log. voice.js autoplays until the desk is touched. */
$voice_ctx = [   // [key, label, the situation]
    ['support', 'Support reply', 'A customer asks where their refund is'],
    ['launch',  'Launch post',   'Product C ships shared workspaces'],
    ['error',   'Error message', 'A card payment does not go through'],
    ['price',   'Price change',  'The Team plan price rises on 1 May'],
];
$voice_f = ['Formal', 'Neutral', 'Warm'];
$voice_l = ['Concise', 'Balanced', 'Expansive'];
/* [context][formality 0–2][length 0–2] — three variants are deliberately flagged by the checks */
$voice_m = [
  'support' => [
    ['Your refund was issued today. Please allow five working days for it to reach your account.',
     'Your refund was issued today and should reach your account within five working days. If it has not arrived by then, reply to this message and we will investigate.',
     'We apologise for any inconvenience caused. Your refund was issued today and should reach your account within five working days, depending on your bank. If it has not arrived by then, reply with your order number and we will investigate.'],
    ['Your refund went out today. Expect it within five working days.',
     'Your refund went out today, so it should land within five working days. Not there by then? Reply here and we’ll look into it.',
     'Thanks for getting in touch. Your refund went out today, and most banks show it within five working days. If it hasn’t landed by then, reply here with your order number and we’ll chase it for you.'],
    ['Good news: your refund is on its way. Give it five working days.',
     'Good news: your refund left us today. It usually lands within five working days, and if it doesn’t, just reply and we’ll sort it.',
     'Thanks for bearing with us. Your refund left us today and usually lands within five working days, depending on your bank. If it hasn’t arrived by then, reply here and we’ll chase it ourselves, so you don’t have to.'],
  ],
  'launch' => [
    ['Product C is now available. It brings shared workspaces to every team plan.',
     'Product C is now available on every team plan. Shared workspaces let teams plan, review and publish in one place, with permissions set by the account owner.',
     'Today we are releasing Product C to every team plan. Shared workspaces let teams plan, review and publish in one place, with permissions set by the account owner. Existing projects move across automatically, and a guided tour is available from the dashboard.'],
    ['Product C is here: shared workspaces for every team plan.',
     'Product C is here. Plan, review and publish together in one shared workspace, included in every team plan from today.',
     'Product C is here. Plan, review and publish together in one shared workspace, included in every team plan from today. Your existing projects move across on their own, and there’s a short tour in the dashboard when you’re ready.'],
    ['Say hello to Product C. Your whole team, one workspace.',
     'Say hello to Product C. Your whole team can now plan, review and publish in one shared space, and it’s already in your plan.',
     'Say hello to Product C!! Your whole team can now plan, review and publish in one shared space, and it’s already part of your plan. Your projects move across on their own, and a two-minute tour is waiting in the dashboard.'],
  ],
  'error' => [
    ['Invalid card details entered. Payment rejected.',
     'The payment could not be completed. Please check that your card details are correct, or choose another payment method.',
     'The payment could not be completed. This usually happens when card details have changed or the bank has declined the transaction. Please check your details, choose another payment method, or contact your bank. Your basket has been saved.'],
    ['That payment didn’t go through. Check your card details and try again.',
     'That payment didn’t go through. Check your card details, or try a different payment method. Your basket is saved.',
     'That payment didn’t go through. It’s usually a changed card number or a bank check. Try your details again, pick another payment method, or ask your bank to approve it. Your basket is saved, so nothing is lost.'],
    ['That didn’t go through. Let’s try the card details again.',
     'That didn’t go through, but your basket is safe. Check the card details or try another way to pay.',
     'That didn’t go through, and it’s rarely anything you did. Card numbers change and banks double-check sometimes. Your basket is safe, so try your details again, pick another way to pay, or give your bank a quick call.'],
  ],
  'price' => [
    ['From 1 May, the Team plan price will increase. The new rate is shown in your account.',
     'From 1 May, the Team plan price will increase to cover expanded storage and support. The new rate is in your account, and you may change or cancel before then.',
     'We are writing to let you know that, from 1 May, the Team plan price will increase. The change reflects expanded storage, longer history and extended support hours. The new rate is shown in your account, and you may change or cancel your plan before it takes effect.'],
    ['Your Team plan price goes up on 1 May. See the new rate in your account.',
     'Your Team plan price goes up on 1 May, alongside more storage and longer support hours. The new rate is in your account, and you can change plans any time before then.',
     'Your Team plan price goes up on 1 May. Here’s why: more storage, a longer history and support that stays open later. The new rate is in your account. If it doesn’t suit you, you can change or cancel before 1 May.'],
    ['A heads-up: your Team plan price changes on 1 May. The new rate is in your account.',
     'A heads-up: your Team plan price changes on 1 May, with more storage and longer support hours. The new rate is in your account, and you can switch plans any time.',
     'We wanted you to hear this from us first, not from an invoice: your Team plan price changes on 1 May. It pays for more storage, a longer history and support that stays open later. The new rate is in your account, and you can switch or cancel before then.'],
  ],
];
$voice_checks = ['Length for the setting', 'Lexicon: never-use words', 'No blame on the reader', 'One exclamation mark at most'];
?>
<section class="cbi-sec cbi-sec--ink cbi-voice" id="voice" aria-labelledby="voice-t">
  <div class="wrap">
    <div class="cbi-head" data-rv>
      <p class="cbi-head__folio"><span>Plate 06 · Voice &amp; tone</span><span>Try it: the voice tuner</span></p>
      <div class="cbi-head__t">
        <h2 class="h2" id="voice-t"><span class="g">One voice, four moments.</span> Tune the line, then sign it off.</h2>
      </div>
      <p class="lead">Voice stays fixed; tone moves with the moment. An agent redrafts the line to your settings and checks it against the voice rules. A person decides whether it ships.</p>
    </div>

    <div class="cbi-voice__desk" data-voice='<?= e(json_encode(['m' => $voice_m, 'f' => $voice_f, 'l' => $voice_l, 'ctx' => $voice_ctx], JSON_UNESCAPED_UNICODE)) ?>'>
      <div class="cbi-voice__tabs" role="group" aria-label="Context">
        <?php foreach ($voice_ctx as $voice_i => $voice_c): ?>
        <button type="button" class="cbi-voice__tab" data-ctx="<?= e($voice_c[0]) ?>" aria-pressed="<?= $voice_i === 0 ? 'true' : 'false' ?>">
          <span><?= chr(65 + $voice_i) ?></span><b><?= e($voice_c[1]) ?></b><small><?= e($voice_c[2]) ?></small>
        </button>
        <?php endforeach; ?>
      </div>

      <div class="cbi-voice__body">
        <div class="cbi-voice__dials">
          <?php foreach ([['formality', 'Formal', 'Warm', $voice_f], ['length', 'Concise', 'Expansive', $voice_l]] as $voice_d): ?>
          <div class="cbi-voice__dial">
            <label class="cbi-voice__dl" for="voice-<?= $voice_d[0] ?>"><span><?= e($voice_d[1]) ?></span><output id="voice-<?= $voice_d[0] ?>-o"><?= e($voice_d[3][1]) ?></output><span><?= e($voice_d[2]) ?></span></label>
            <input class="cbi-voice__range" id="voice-<?= $voice_d[0] ?>" type="range" min="0" max="2" step="1" value="1" aria-valuetext="<?= e($voice_d[3][1]) ?>">
            <span class="cbi-voice__ticks" aria-hidden="true"><i></i><i></i><i></i></span>
          </div>
          <?php endforeach; ?>
          <dl class="cbi-voice__who">
            <div><dt>Voice agent</dt><dd>Redrafts to the settings using the voice rules and lexicon, then runs the checks. It cannot approve.</dd></div>
            <div><dt>Brand lead</dt><dd>Reads the draft and the flags, then approves the line or sends it back.</dd></div>
          </dl>
        </div>

        <div class="cbi-voice__proof">
          <span class="cbi-crop" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
          <p class="cbi-voice__meta"><span class="cbi-voice__status"><i></i>Draft ready</span><span class="cbi-voice__set">Support reply · Neutral · Balanced</span></p>
          <p class="cbi-voice__line" aria-live="polite"><?= e($voice_m['support'][1][1]) ?></p>
          <p class="cbi-voice__count"><span class="cbi-voice__words">25 words</span><span class="cbi-ill">Illustrative lines</span></p>
          <ul class="cbi-voice__checks">
            <?php foreach ($voice_checks as $voice_i => $voice_ch): ?>
            <li class="is-ok" data-check="<?= $voice_i ?>"><b aria-hidden="true"></b><span><?= e($voice_ch) ?></span><em>Pass</em></li>
            <?php endforeach; ?>
          </ul>
          <div class="cbi-voice__act">
            <button type="button" class="cbi-btn cbi-btn--blue cbi-voice__approve">Approve line</button>
            <p class="cbi-voice__hint">All four checks pass. Your call.</p>
          </div>
        </div>
      </div>

      <div class="cbi-voice__log">
        <p class="cbi-lbl">Approved lines · this session</p>
        <ol class="cbi-voice__logl" aria-live="polite"><li class="cbi-voice__empty">Nothing approved yet. Only a person can add a line here.</li></ol>
      </div>
    </div>
  </div>
</section>
