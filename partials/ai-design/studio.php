<?php /* DRAFT COPY — review before launch */
/* Studio — the signature showcase. One request routed across text, image, voice and video models; each lane
   passes brand, rights and safety guardrails and an eval floor; one lane is flagged; a person sends it back or
   approves, and every event lands in the audit log. Real controls (buttons, aria-pressed presets, aria-live log).
   The shipped HTML is the finished state of request 1: all lanes run, one flagged, waiting for a person.
   studio.js reads the JSON below and runs the same state machine; with JS off the controls stay hidden. */
$aih_st_floor = 0.85;
$aih_st = [
  [
    'id' => 'R-0412', 'name' => 'Launch in four markets',
    'brief' => 'Spring launch: a hero still, product copy in four languages, a voice read and 8-second film cut-downs for India, the UAE, the UK and Germany.',
    'lanes' => [
      'text'  => ['m' => 'Claude · brand voice prompt set', 'why' => 'Top brand-voice score on the 120-prompt set', 'v' => 0.91, 'out' => '4 × product copy · 4 languages'],
      'image' => ['m' => 'Brand-tuned Flux model · v4', 'why' => 'Only candidate above the brand floor', 'v' => 0.93, 'out' => '12 stills · 4:5, 1:1, 16:9'],
      'voice' => ['m' => 'ElevenLabs · licensed brand voice', 'why' => 'Consented voice, contract on file', 'v' => 0.88, 'out' => '4 × 20 s reads',
                  'flag' => ['c' => 'safety', 'note' => 'Script says “clinically proven”, which is not on the approved claims list.', 'fix' => 'Line rewritten to approved claim C-12 and re-voiced.']],
      'video' => ['m' => 'Veo · storyboard-locked', 'why' => 'Best motion consistency on the brand set', 'v' => 0.86, 'out' => '8 × 8 s cut-downs'],
    ],
  ],
  [
    'id' => 'R-0413', 'name' => 'Personalised onboarding',
    'brief' => 'A welcome sequence for six customer segments: an email, an in-app card and a header image per segment, in the brand voice.',
    'lanes' => [
      'text'  => ['m' => 'GPT · structured output', 'why' => 'Held the six-segment schema on every run', 'v' => 0.9, 'out' => '6 × email + in-app card'],
      'image' => ['m' => 'Brand-tuned Flux model · v4', 'why' => 'Brand floor met across all six segments', 'v' => 0.89, 'out' => '6 header images',
                  'flag' => ['c' => 'rights', 'note' => 'One reference image has no model release on file.', 'fix' => 'Swapped for cleared reference ref-0238 and regenerated.']],
      'voice' => ['skip' => 'Not needed for this request'],
      'video' => ['skip' => 'Not needed for this request'],
    ],
  ],
  [
    'id' => 'R-0414', 'name' => 'Accessible product explainer',
    'brief' => 'A 60-second product explainer with narration and captions. The source material is confidential and may not leave your cloud region.',
    'lanes' => [
      'text'  => ['m' => 'Mistral · open weights, your cloud', 'why' => 'Data stays in region; passed the script eval', 'v' => 0.87, 'out' => 'Script · captions · alt text'],
      'image' => ['skip' => 'Existing product renders reused'],
      'voice' => ['m' => 'ElevenLabs · licensed brand voice', 'why' => 'Consented voice, contract on file', 'v' => 0.9, 'out' => '60 s narration'],
      'video' => ['m' => 'Runway · storyboard-locked', 'why' => 'Best match to the approved storyboard', 'v' => 0.88, 'out' => '1 × 60 s film',
                  'flag' => ['c' => 'safety', 'note' => 'Captions missing on 2 of 8 scenes, so the film fails WCAG 2.2 AA.', 'fix' => 'Captions generated from the script and checked line by line.']],
    ],
  ],
];
$aih_st_lanes = ['text' => ['Text', 'doc'], 'image' => ['Image', 'vision'], 'voice' => ['Voice', 'voice'], 'video' => ['Video', 'layers']];
$aih_st_checks = ['brand' => 'Brand', 'rights' => 'Rights', 'safety' => 'Safety'];
$aih_st0 = $aih_st[0];
$aih_st_log = [
  ['00:00.2', 'Brief parsed · 4 outputs, 4 markets'],
  ['00:00.9', 'Routed · text, image, voice, video'],
  ['00:06.4', 'Guardrails · 11 of 12 checks passed'],
  ['00:06.8', 'Voice lane flagged · claims list'],
  ['00:07.0', 'Waiting for a named approver'],
];
?>
<section class="band band--ink aih-studio" id="studio" aria-labelledby="studio-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div>
        <p class="lbl"><span class="dot"></span>The studio, running</p>
        <h2 class="h2" id="studio-t"><span class="g">One request.</span> Four models, three guardrails, one person who signs it off.</h2>
      </div>
      <div><p class="lead">Pick a request and run it. Each output goes to the model that won its evaluation, every lane is checked for brand, rights and safety, and nothing ships until a person has looked at what was flagged.</p></div>
    </div>

    <div class="aih-st" data-floor="<?= e((string) $aih_st_floor) ?>">
      <div class="aih-st__bar">
        <span class="aih-st__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span>Studio · Your company</span>
        <span class="aih-st__rid">Request <b data-st-rid><?= e($aih_st0['id']) ?></b></span>
      </div>

      <div class="aih-st__grid">
        <div class="aih-st__req">
          <p class="aih-st__k">Request</p>
          <div class="aih-st__presets" role="group" aria-label="Choose a request" hidden data-st-js>
            <?php foreach ($aih_st as $aih_i => $aih_p): ?>
              <button type="button" class="aih-st__preset" data-st-preset="<?= $aih_i ?>" aria-pressed="<?= $aih_i === 0 ? 'true' : 'false' ?>"><span><?= e($aih_p['id']) ?></span><?= e($aih_p['name']) ?></button>
            <?php endforeach; ?>
          </div>
          <p class="aih-st__brief" data-st-brief><?= e($aih_st0['brief']) ?></p>
          <button type="button" class="btn btn--ink aih-st__run" data-st-run hidden data-st-js>Run request <span class="i" aria-hidden="true"></span></button>
          <p class="aih-st__floor">Eval floor <b><?= e(number_format($aih_st_floor, 2)) ?></b> · below it, a lane never reaches review.</p>
        </div>

        <ol class="aih-st__lanes" aria-label="Model lanes">
          <?php foreach ($aih_st_lanes as $aih_lk => $aih_lm):
            $aih_ln = $aih_st0['lanes'][$aih_lk];
            $aih_state = isset($aih_ln['skip']) ? 'skip' : (isset($aih_ln['flag']) ? 'flag' : 'pass'); ?>
            <li class="aih-ln" data-lane="<?= e($aih_lk) ?>" data-st="<?= e($aih_state) ?>">
              <div class="aih-ln__h">
                <span class="aih-ln__ic"><?= xt_icon($aih_lm[1]) ?></span>
                <span class="aih-ln__k"><?= e($aih_lm[0]) ?></span>
                <span class="aih-ln__st" data-f="st"><?= $aih_state === 'flag' ? 'Flagged' : ($aih_state === 'skip' ? 'Skipped' : 'Passed') ?></span>
              </div>
              <p class="aih-ln__m" data-f="m"><?= e($aih_ln['m'] ?? $aih_ln['skip']) ?></p>
              <p class="aih-ln__why" data-f="why"><?= e($aih_ln['why'] ?? '') ?></p>
              <ul class="aih-ln__chk" aria-label="Guardrails">
                <?php foreach ($aih_st_checks as $aih_ck => $aih_cn):
                  $aih_cs = $aih_state === 'skip' ? 'off' : ((($aih_ln['flag']['c'] ?? '') === $aih_ck) ? 'flag' : 'pass'); ?>
                  <li data-c="<?= e($aih_ck) ?>" data-s="<?= e($aih_cs) ?>"><?= e($aih_cn) ?></li>
                <?php endforeach; ?>
              </ul>
              <div class="aih-ln__ev">
                <span class="aih-ln__track"><span class="aih-ln__fill" style="--v:<?= e((string) ($aih_ln['v'] ?? 0)) ?>"></span><span class="aih-ln__thr" style="--t:<?= e((string) $aih_st_floor) ?>"></span></span>
                <span class="aih-ln__v" data-f="v"><?= isset($aih_ln['v']) ? e(number_format($aih_ln['v'], 2)) : '—' ?></span>
              </div>
              <p class="aih-ln__out" data-f="out"><?= e($aih_ln['out'] ?? '') ?></p>
              <p class="aih-ln__flag" data-f="flag"><?= e($aih_ln['flag']['note'] ?? '') ?></p>
            </li>
          <?php endforeach; ?>
        </ol>

        <div class="aih-st__ap">
          <p class="aih-st__k">Human approval</p>
          <p class="aih-st__sum" data-st-sum aria-live="polite">1 lane flagged. Voice: script says “clinically proven”, which is not on the approved claims list.</p>
          <div class="aih-st__who"><span class="aih-st__av" aria-hidden="true">CD</span><span><b>Creative director</b><br>Named approver for this brand</span></div>
          <div class="aih-st__acts" hidden data-st-js>
            <button type="button" class="btn btn--out aih-st__send" data-st-send>Send back flagged lane</button>
            <button type="button" class="btn btn--ink aih-st__ok" data-st-approve disabled>Approve and publish</button>
          </div>
          <p class="aih-st__rule">Approve stays locked while any lane is flagged. The approver can send a lane back, never wave it through.</p>
        </div>

        <div class="aih-st__log">
          <p class="aih-st__k">Audit log</p>
          <ol class="aih-st__ev" data-st-log aria-live="polite" aria-label="Audit log">
            <?php foreach ($aih_st_log as $aih_e): ?>
              <li><time><?= e($aih_e[0]) ?></time><span><?= e($aih_e[1]) ?></span></li>
            <?php endforeach; ?>
          </ol>
        </div>
      </div>
    </div>
    <p class="aih-st__note">Illustrative run. Model choices change per brief, because they are chosen on your own evaluation set, not on reputation.</p>
  </div>
  <script type="application/json" id="aih-st-data"><?= json_encode($aih_st, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
</section>
