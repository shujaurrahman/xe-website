<?php /* DRAFT COPY — review before launch */
/* 04.3 Conversation — a support conversation opened up. Left: the transcript as your team sees it, with a
   Chat / Voice call switch. Right: the agent desk the assistant works from: detected intent, the customer
   record, a confidence trace against the 0.60 handover line, tools called with their permissions, PII
   redaction before logging, and the suggested next step handed to the person who takes over.
   The Voice call tab has its own desk state (a verified address change, resolved with no handover).
   HTML = the finished conversations (chat handed over and resolved by a person; call resolved by the
   assistant). conversation.js replays them. */
$tapc_msgs = [   // [step, who: cust | bot | human, text, meta, intent, confidence]
    [1, 'cust',  'My order arrived today but the blender jug is cracked.', '', '', ''],
    [2, 'bot',   'Sorry about that. I can see order 48213, delivered this morning. I can send a replacement jug or refund ₹3,499. Which would you prefer?', 'orders.lookup · 0.93', 'damaged_item', '0.93'],
    [3, 'cust',  'A replacement, please. Can it arrive before Saturday? It’s a gift.', '', '', ''],
    [4, 'bot',   'It can reach you by Friday. I’ve booked the replacement and emailed a free return label for the cracked jug.', 'replacements.create · 0.88', 'delivery_date', '0.88'],
    [5, 'cust',  'Also, my card 4111 1111 1111 4242 was charged twice for this order.', '', '', ''],
    [6, 'bot',   'I’ll pass this to our billing team with everything so far, so you won’t need to repeat it. Someone will reply here within a few minutes.', 'handover · 0.41', 'billing_dispute', '0.41'],
    [7, 'human', 'Hi, this is Priya from billing support. I can see the duplicate charge of ₹3,499 and I’ve reversed it. It will show on your statement within 5 to 7 working days.', 'Sent by Priya · Billing support', '', ''],
];
$tapc_tools = [   // [step, call, result, state: ok | block]
    [2, 'orders.lookup(48213)',        '200 · 180 ms',              'ok'],
    [4, 'replacements.create(48213)',  '201 · 420 ms',              'ok'],
    [6, 'payments.refund(48213)',      'not permitted · needs a person', 'block'],
];
$tapc_voice = [   // [time, speaker | 'event', text, class: '' | 'is-bot' | 'is-barge' | 'is-ev', voice-desk step]
    ['00:00.8', 'Caller',    'Hi, I need to change the delivery address for my order.', '', 1],
    ['00:02.9', 'Assistant', 'Of course. Is that order 48213, arriving on Friday?', 'is-bot', 1],
    ['00:05.1', 'Caller',    'Yes, that one. Send it to my office instead, the address on my account.', 'is-barge', 2],
    ['00:05.2', 'event',     'Barge-in detected · assistant audio stopped in 90 ms', 'is-ev', 2],
    ['00:08.4', 'Assistant', 'I’ve sent a one-time code to the number ending 42. Could you read it out?', 'is-bot', 3],
    ['00:14.7', 'Caller',    'It’s [code redacted].', '', 4],
    ['00:16.2', 'Assistant', 'Thank you, that’s verified. Your order will now go to your office address on Friday.', 'is-bot', 5],
    ['00:19.0', 'event',     'Resolved · no handover · call 00:19', 'is-ev', 5],
];
$tapc_lat = [   // [stage, engine (illustrative), ms]
    ['Speech-to-text', 'Whisper large-v3 turbo, streamed', '190'],
    ['LLM first token', 'small model, routed', '310'],
    ['Text-to-speech first audio', 'ElevenLabs Flash', '220'],
];
$tapc_vtools = [   // [voice step, call, result, state]
    [1, 'orders.lookup(48213)',          '200 · 160 ms', 'ok'],
    [3, 'otp.send(phone ••42)',          '202 · 310 ms', 'ok'],
    [4, 'otp.verify()',                  'passed',       'ok'],
    [5, 'orders.update_address(48213)',  '200 · 240 ms', 'ok'],
];
?>
<section class="band tap-conversation" id="conversation" aria-labelledby="conversation-t">
  <div class="wrap">
    <div class="tap-head" data-rv>
      <div>
        <p class="tap-eb"><span class="tap-eb__box" aria-hidden="true"></span><span class="tap-eb__n">04.3</span><span>Conversational AI</span><span class="tap-eb__p">/conversation</span></p>
        <h2 class="h2" id="conversation-t"><span class="g">Conversations that know</span> when to hand over.</h2>
      </div>
      <div>
        <p class="lead">The assistant resolves what it is permitted to resolve through your systems. When confidence drops below the line, or the request needs a person, it hands over with the transcript, the intent, the tools it called and a suggested next step.</p>
      </div>
    </div>

    <div class="tap-cv" data-rv data-cv-at="7">
      <div class="tap-cv__view" role="group" aria-label="Panel shown">
        <div class="bdh-seg">
          <button type="button" data-cv-view="0" aria-pressed="true">Conversation</button>
          <button type="button" data-cv-view="1" aria-pressed="false">Agent desk <span class="tap-cv__vk" data-cv-vk>0.41</span></button>
        </div>
      </div>
      <p class="bdh-sr">Illustrative support conversations. In the chat, a customer reports a cracked blender jug; the assistant looks up the order and books a replacement with confidence 0.93 and 0.88. The customer then reports a duplicate card charge; confidence falls to 0.41, below the 0.60 handover threshold, and refunds need a person, so the assistant hands over to billing support with full context. Priya from billing support reverses the charge. The card number was redacted before logging. On the voice call, a caller changes a delivery address: the caller interrupts the assistant mid-sentence, verifies with a one-time code, and the assistant updates the order with confidence 0.94 and no handover. The phone number, code and address are redacted before logging.</p>

      <div class="tap-cv__main tap-win">
        <div class="tap-win__bar tap-cv__bar">
          <span class="tap-win__dots" aria-hidden="true"><i></i><i></i><i></i></span>
          <span class="tap-win__path"><b>support</b> · <span data-cv-path>conversation 7731</span></span>
          <span class="tap-win__end">
            <span class="tap-cv__ch" aria-hidden="true"><?= xt_icon('chat', ['size' => 14, 'mono' => true]) ?>Web</span>
            <span class="tap-cv__ch" aria-hidden="true"><?= xt_logo('whatsapp', ['size' => 13, 'hidden' => true]) ?>WhatsApp</span>
            <span class="tap-cv__ch" aria-hidden="true"><?= xt_icon('voice', ['size' => 14, 'mono' => true]) ?>Voice</span>
          </span>
        </div>
        <div class="tap-cv__mode">
          <div class="bdh-seg" role="tablist" aria-label="Channel">
            <button type="button" role="tab" id="cv-t0" aria-controls="cv-p0" aria-selected="true">Chat</button>
            <button type="button" role="tab" id="cv-t1" aria-controls="cv-p1" aria-selected="false" tabindex="-1">Voice call</button>
          </div>
          <button type="button" class="tap-btn tap-cv__replay" data-cv-replay>Replay <span class="tap-btn__i" aria-hidden="true">↻</span></button>
        </div>

        <div class="bdh-panes">
          <div class="bdh-pane is-on tap-cv__pane" id="cv-p0" role="tabpanel" aria-labelledby="cv-t0">
            <ol class="tap-cv__log" aria-label="Chat transcript">
              <?php foreach ($tapc_msgs as $tapc_m):
                  if ($tapc_m[0] === 6): ?>
                <li class="tap-cv__hand" data-s="6">
                  <span class="tap-cv__handi" aria-hidden="true"><?= xt_icon('users', ['size' => 18, 'mono' => true]) ?></span>
                  <span><b>Handed to Billing support</b> Confidence 0.41 is under the 0.60 line, and refunds need a person. Transcript, intent, tool calls and a suggested reply attached.</span>
                </li>
              <?php endif; ?>
                <li class="tap-cv__msg tap-cv__msg--<?= $tapc_m[1] ?>" data-s="<?= $tapc_m[0] ?>"<?= $tapc_m[4] ? ' data-intent="' . e($tapc_m[4]) . '" data-conf="' . e($tapc_m[5]) . '"' : '' ?>>
                  <p class="tap-cv__who"><?= $tapc_m[1] === 'cust' ? 'Customer' : ($tapc_m[1] === 'bot' ? 'Assistant' : 'Billing support') ?></p>
                  <div class="tap-cv__bub">
                    <span class="tap-cv__dots" aria-hidden="true"><i></i><i></i><i></i></span>
                    <p class="tap-cv__txt"><?= e($tapc_m[2]) ?></p>
                  </div>
                  <?php if ($tapc_m[3]): ?><p class="tap-cv__meta"><?= e($tapc_m[3]) ?></p><?php endif; ?>
                </li>
              <?php endforeach; ?>
            </ol>
          </div>

          <div class="bdh-pane tap-cv__pane tap-cv__voice" id="cv-p1" role="tabpanel" aria-labelledby="cv-t1">
            <div class="tap-cv__call">
              <span class="tap-cv__calli"><?= xt_icon('voice', ['size' => 22]) ?></span>
              <div><p class="tap-cv__callt">Voice call · order support</p><p class="tap-cv__calls"><span class="bdh-pulse" aria-hidden="true"></span>Streaming · barge-in on · <span data-cv-clock>00:19</span></p></div>
            </div>
            <div class="tap-cv__wave" aria-hidden="true">
              <?php for ($tapc_w = 0; $tapc_w < 48; $tapc_w++): ?><i style="--h:<?= round(0.25 + 0.75 * abs(sin($tapc_w * 0.55) * cos($tapc_w * 0.21)), 2) ?>;--k:<?= $tapc_w ?>"></i><?php endfor; ?>
            </div>
            <ol class="tap-cv__tr" aria-label="Call transcript, streamed from speech-to-text">
              <?php foreach ($tapc_voice as $tapc_i => $tapc_v): ?>
                <li class="tap-cv__trl <?= $tapc_v[3] ?>" data-v="<?= $tapc_i ?>" data-vs="<?= $tapc_v[4] ?>" data-t="<?= e($tapc_v[0]) ?>">
                  <span class="tap-cv__trt"><?= e($tapc_v[0]) ?></span>
                  <?php if ($tapc_v[1] === 'event'): ?>
                    <span class="tap-cv__trx"><?= e($tapc_v[2]) ?></span>
                  <?php else: ?>
                    <b><?= e($tapc_v[1]) ?><?= $tapc_v[3] === 'is-barge' ? ' · barge-in' : '' ?></b><span class="tap-cv__trx"><?= e($tapc_v[2]) ?></span>
                  <?php endif; ?>
                </li>
              <?php endforeach; ?>
            </ol>
            <div class="tap-cv__lat">
              <p class="tap-cv__latk">Time to first audio <span class="tap-ill">Illustrative</span></p>
              <div class="tap-cv__latbar" aria-hidden="true">
                <?php foreach ($tapc_lat as $tapc_i => $tapc_l): ?><span style="--w:<?= $tapc_l[2] ?>;--i:<?= $tapc_i ?>"></span><?php endforeach; ?>
                <b style="--at:800"></b>
              </div>
              <ul class="tap-cv__latl" role="list">
                <?php foreach ($tapc_lat as $tapc_i => $tapc_l): ?><li><i style="--i:<?= $tapc_i ?>"></i><span><?= e($tapc_l[0]) ?> <b><?= e($tapc_l[2]) ?> ms</b><small><?= e($tapc_l[1]) ?></small></span></li><?php endforeach; ?>
                <li class="tap-cv__lattot"><span>Total <b>720 ms</b><small>target under 800 ms</small></span></li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <aside class="tap-cv__desk tap-win tap-win--ink tap-on-ink" aria-label="Agent desk">
        <div class="tap-win__bar"><span class="tap-win__path"><b>agent desk</b> · what the assistant sees</span><span class="tap-win__end"><span class="tap-cv__dkch" data-cv-dkch>chat</span><span class="tap-led tap-led--pulse"></span></span></div>

        <div class="bdh-panes tap-cv__dks">
        <div class="bdh-pane is-on tap-cv__dk" data-desk="0">
          <div class="tap-cv__blk">
            <p class="tap-cv__k">Intent</p>
            <p class="tap-cv__intent"><code data-cv-intent>billing_dispute</code><span class="tap-conf is-low" data-cv-confw style="--v:0.41"><span data-cv-conf>0.41</span><span class="tap-conf__bar"></span></span></p>
          </div>

          <div class="tap-cv__blk">
            <p class="tap-cv__k">Confidence by turn <span>handover under 0.60</span></p>
            <svg class="tap-cv__spark" viewBox="0 0 480 100" aria-hidden="true">
              <line class="tap-cv__th" x1="0" y1="40" x2="480" y2="40"/>
              <text class="tap-cv__tht" x="480" y="33" text-anchor="end">0.60</text>
              <line class="tap-cv__seg" data-s="4" x1="60" y1="7" x2="240" y2="12"/>
              <line class="tap-cv__seg tap-cv__seg--low" data-s="6" x1="240" y1="12" x2="420" y2="59"/>
              <circle class="tap-cv__pt" data-s="2" cx="60" cy="7" r="5"/>
              <circle class="tap-cv__pt" data-s="4" cx="240" cy="12" r="5"/>
              <circle class="tap-cv__pt is-low" data-s="6" cx="420" cy="59" r="5.5"/>
              <text class="tap-cv__ptt" x="60" y="94" text-anchor="middle">T1 0.93</text><text class="tap-cv__ptt" x="240" y="94" text-anchor="middle">T2 0.88</text><text class="tap-cv__ptt" x="420" y="94" text-anchor="middle">T3 0.41</text>
            </svg>
          </div>

          <div class="tap-cv__blk">
            <p class="tap-cv__k">Customer</p>
            <dl class="tap-cv__kv">
              <div><dt>Account</dt><dd>Member since 2022</dd></div>
              <div><dt>Orders</dt><dd>14 · 1 open</dd></div>
              <div><dt>Open order</dt><dd>48213 · ₹3,499</dd></div>
            </dl>
          </div>

          <div class="tap-cv__blk">
            <p class="tap-cv__k">Tools called</p>
            <ul class="tap-cv__tools" role="list">
              <?php foreach ($tapc_tools as $tapc_t): ?>
                <li class="is-<?= $tapc_t[3] ?>" data-s="<?= $tapc_t[0] ?>"><code><?= e($tapc_t[1]) ?></code><span><?= e($tapc_t[2]) ?></span></li>
              <?php endforeach; ?>
            </ul>
          </div>

          <div class="tap-cv__blk">
            <p class="tap-cv__k">Before logging</p>
            <p class="tap-cv__red" data-s="5"><code>card_number</code><span aria-hidden="true">→</span><code>[REDACTED:PAN]</code></p>
          </div>

          <div class="tap-cv__blk tap-cv__sug" data-s="6">
            <p class="tap-cv__k">Suggested for billing support</p>
            <p class="tap-cv__sugt">Two captures of ₹3,499 found on order 48213, 11 seconds apart. Reverse the second and confirm the 5 to 7 working day timeline.</p>
          </div>

          <div class="tap-cv__blk" data-s="6">
            <p class="tap-cv__k">Handover packet <span class="tap-cv__pku" data-s="7">picked up in 1 m 12 s · SLA 5 min</span></p>
            <ul class="tap-cv__pkt" role="list">
              <li>Transcript · 6 turns</li><li>Intent + confidence</li><li>3 tool calls</li><li>Order record</li><li>Suggested reply</li>
            </ul>
          </div>
        </div>

        <div class="bdh-pane tap-cv__dk" data-desk="1">
          <div class="tap-cv__blk">
            <p class="tap-cv__k">Intent</p>
            <p class="tap-cv__intent"><code>change_delivery_address</code><span class="tap-conf" style="--v:0.94"><span>0.94</span><span class="tap-conf__bar"></span></span></p>
          </div>

          <div class="tap-cv__blk">
            <p class="tap-cv__k">Confidence by turn <span>handover under 0.60</span></p>
            <svg class="tap-cv__spark" viewBox="0 0 480 100" aria-hidden="true">
              <line class="tap-cv__th" x1="0" y1="40" x2="480" y2="40"/>
              <text class="tap-cv__tht" x="480" y="33" text-anchor="end">0.60</text>
              <line class="tap-cv__seg" data-vs="3" x1="60" y1="6" x2="240" y2="9"/>
              <line class="tap-cv__seg" data-vs="5" x1="240" y1="9" x2="420" y2="4"/>
              <circle class="tap-cv__pt" data-vs="1" cx="60" cy="6" r="5"/>
              <circle class="tap-cv__pt" data-vs="3" cx="240" cy="9" r="5"/>
              <circle class="tap-cv__pt" data-vs="5" cx="420" cy="4" r="5"/>
              <text class="tap-cv__ptt" x="60" y="94" text-anchor="middle">T1 0.94</text><text class="tap-cv__ptt" x="240" y="94" text-anchor="middle">T2 0.91</text><text class="tap-cv__ptt" x="420" y="94" text-anchor="middle">T3 0.96</text>
            </svg>
          </div>

          <div class="tap-cv__blk">
            <p class="tap-cv__k">Caller</p>
            <dl class="tap-cv__kv">
              <div><dt>Matched by</dt><dd>Registered number</dd></div>
              <div><dt>Identity</dt><dd data-vs="4">OTP verified</dd></div>
              <div><dt>Open order</dt><dd>48213 · Friday</dd></div>
            </dl>
          </div>

          <div class="tap-cv__blk">
            <p class="tap-cv__k">Tools called</p>
            <ul class="tap-cv__tools" role="list">
              <?php foreach ($tapc_vtools as $tapc_t): ?>
                <li class="is-<?= $tapc_t[3] ?>" data-vs="<?= $tapc_t[0] ?>"><code><?= e($tapc_t[1]) ?></code><span><?= e($tapc_t[2]) ?></span></li>
              <?php endforeach; ?>
            </ul>
          </div>

          <div class="tap-cv__blk">
            <p class="tap-cv__k">Before logging</p>
            <p class="tap-cv__red" data-vs="3"><code>phone_number</code><span aria-hidden="true">→</span><code>[REDACTED:PHONE]</code></p>
            <p class="tap-cv__red" data-vs="4"><code>otp_code</code><span aria-hidden="true">→</span><code>[REDACTED:OTP]</code></p>
            <p class="tap-cv__red" data-vs="5"><code>delivery_address</code><span aria-hidden="true">→</span><code>[REDACTED:ADDRESS]</code></p>
          </div>

          <div class="tap-cv__blk">
            <p class="tap-cv__k">Policy applied</p>
            <ul class="tap-cv__pol" role="list">
              <li data-vs="3"><code>orders.update_address</code> needs a verified caller: one-time code first</li>
              <li>Refunds and payment changes always go to a person</li>
            </ul>
          </div>

          <div class="tap-cv__blk tap-cv__done" data-vs="5">
            <p class="tap-cv__k">Outcome</p>
            <p class="tap-cv__sugt"><span class="tap-led" aria-hidden="true"></span> Resolved by the assistant · no handover. Address change confirmed by SMS; call summary written to the order record.</p>
          </div>
        </div>
        </div>
      </aside>
    </div>

    <ul class="tap-cv__facts" role="list" data-rv-s>
      <li><span class="tap-cv__fi"><?= xt_icon('voice', ['size' => 22]) ?></span><div><h3 class="tap-cv__ft">Voice, end to end</h3><p>Streaming speech-to-text, the LLM and text-to-speech run as one pipeline, with voice activity detection so callers can interrupt. We design to a first-audio target of under about 800 ms.</p></div></li>
      <li><span class="tap-cv__fi"><?= xt_icon('handshake', ['size' => 22]) ?></span><div><h3 class="tap-cv__ft">Handover with context</h3><p>Thresholds, permissions and topics that always need a person are set per intent. The person who takes over sees the transcript, the intent, the tool calls and a suggested reply.</p></div></li>
      <li><span class="tap-cv__fi"><?= xt_icon('lock', ['size' => 22]) ?></span><div><h3 class="tap-cv__ft">Redaction before logging</h3><p>Card numbers, phone numbers, one-time codes and government IDs are masked before transcripts are stored, sent to analytics or reused as evaluation data.</p></div></li>
    </ul>
  </div>
</section>
