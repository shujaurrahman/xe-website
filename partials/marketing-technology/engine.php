<?php /* DRAFT COPY — review before launch */
/* The signature showcase: the always-on engine. Six illustrative profiles run through a lifecycle journey —
   trigger, consent, decision, guardrails, human approval, send — and every step is written to an audit log.
   The rules below are evaluated here for the finished no-JS state and mirrored in
   assets/js/marketing-technology/engine.js, which replays them live and lets the visitor switch journeys,
   withdraw or give consent per channel, and approve or reject sensitive sends. Keep the two in step. */
$mth_en = [
    'channels' => ['email' => 'Email', 'wa' => 'WhatsApp', 'sms' => 'SMS'],
    'nodes'    => [
        ['Trigger',    'bolt'],
        ['Consent',    'shield'],
        ['Decide',     'brain'],
        ['Guardrails', 'gauge'],
        ['Approval',   'approve'],
        ['Send',       'chat'],
    ],
    'journeys' => [
        'cart'    => ['name' => 'Cart recovery', 'trigger' => 'cart_abandoned · 30 min idle', 'decide' => 'Next best action per person · 10% holdout',
                      'rule' => 'Discount codes need a person to approve', 'tpl' => 'cart_reminder_v4'],
        'onboard' => ['name' => 'Onboarding',    'trigger' => 'account_created · server event', 'decide' => 'Next setup step per person · 10% holdout',
                      'rule' => 'First send of an AI-drafted variant needs approval', 'tpl' => 'onboarding_step_v2'],
        'winback' => ['name' => 'Win-back',      'trigger' => 'no purchase in 90 days', 'decide' => 'Offer and channel per person · 10% holdout',
                      'rule' => 'Offers to high-value customers need approval', 'tpl' => 'winback_offer_v3'],
    ],
    'guard'    => 'Max 3 messages in 7 days · quiet hours 21:00–09:00 local',
    'consent'  => 'Marketing consent per channel, checked at the moment of sending',
    'send'     => 'Approved templates only · delivery logged',
    /* id, segment, consent [email, wa, sms], preferred channel, local hour, messages in last 7 days, holdout, value, price-sensitive, model confidence */
    'profiles' => [
        ['id' => 'A-1042', 'seg' => 'New · high intent',   'c' => ['email' => 1, 'wa' => 1, 'sms' => 0], 'pref' => 'wa',    'hr' => 22, 'n7' => 1, 'ho' => 0, 'val' => 'mid',  'ps' => 0, 'cf' => 0.82],
        ['id' => 'B-2210', 'seg' => 'Returning',           'c' => ['email' => 1, 'wa' => 0, 'sms' => 1], 'pref' => 'sms',   'hr' => 14, 'n7' => 3, 'ho' => 0, 'val' => 'mid',  'ps' => 0, 'cf' => 0.71],
        ['id' => 'C-3307', 'seg' => 'Lapsed · high value', 'c' => ['email' => 1, 'wa' => 0, 'sms' => 0], 'pref' => 'email', 'hr' => 11, 'n7' => 0, 'ho' => 0, 'val' => 'high', 'ps' => 0, 'cf' => 0.77],
        ['id' => 'D-4415', 'seg' => 'Browsing',            'c' => ['email' => 0, 'wa' => 0, 'sms' => 0], 'pref' => 'email', 'hr' => 16, 'n7' => 0, 'ho' => 0, 'val' => 'low',  'ps' => 0, 'cf' => 0.66],
        ['id' => 'E-5120', 'seg' => 'Returning',           'c' => ['email' => 1, 'wa' => 0, 'sms' => 0], 'pref' => 'email', 'hr' => 12, 'n7' => 1, 'ho' => 1, 'val' => 'mid',  'ps' => 0, 'cf' => 0.74],
        ['id' => 'F-6093', 'seg' => 'Price-sensitive',     'c' => ['email' => 1, 'wa' => 1, 'sms' => 1], 'pref' => 'wa',    'hr' => 10, 'n7' => 1, 'ho' => 0, 'val' => 'mid',  'ps' => 1, 'cf' => 0.54],
    ],
];

if (!function_exists('mth_engine_eval')) {
    /** One profile through one journey → [[node, state ok|hold|stop|wait, text], …]. Mirrored in engine.js. */
    function mth_engine_eval(array $en, string $jk, array $p): array {
        $j = $en['journeys'][$jk]; $ch = $en['channels']; $out = [];
        $out[] = [0, 'ok', 'Entered on ' . $j['trigger']];
        $has = array_keys(array_filter($p['c']));
        if (!$has) { $out[] = [1, 'stop', 'No marketing consent on any channel · suppressed, nothing sent']; return $out; }
        $out[] = [1, 'ok', 'Consent valid for marketing · ' . implode(', ', array_map(fn ($k) => $ch[$k], $has))];
        if ($p['ho']) { $out[] = [2, 'stop', 'In the 10% holdout · no message, counted for lift']; return $out; }
        $use = in_array($p['pref'], $has, true) ? $p['pref'] : (array_values(array_intersect(['email', 'wa', 'sms'], $has))[0]);
        $act = mth_engine_action($jk, $p);
        $out[] = $p['cf'] < 0.6
            ? [2, 'ok', 'Confidence ' . number_format($p['cf'], 2) . ' below 0.60 · rule-based fallback: ' . $act . ' by ' . $ch[$use]]
            : [2, 'ok', 'Next best action: ' . $act . ' by ' . $ch[$use] . ' · confidence ' . number_format($p['cf'], 2)];
        if ($p['n7'] >= 3) { $out[] = [3, 'stop', 'Frequency cap reached · 3 in 7 days · deferred']; return $out; }
        $out[] = ($p['hr'] >= 21 || $p['hr'] < 9)
            ? [3, 'hold', 'Quiet hours at ' . sprintf('%02d', $p['hr']) . ':00 local · queued until 09:00']
            : [3, 'ok', 'Within limits · ' . $p['n7'] . ' of 3 this week, outside quiet hours'];
        if (mth_engine_sensitive($jk, $p)) { $out[] = [4, 'wait', 'Waiting for a person · ' . $en['journeys'][$jk]['rule']]; return $out; }
        $out[] = [4, 'ok', 'Nothing sensitive · template approved once, monitored'];
        $out[] = [5, 'ok', 'Sent by ' . $ch[$use] . ' · ' . $j['tpl']];
        return $out;
    }
    function mth_engine_action(string $jk, array $p): string {
        if ($jk === 'cart')    return $p['ps'] ? 'reminder + 10% code' : ($p['val'] === 'high' ? 'reminder + free delivery' : 'reminder');
        if ($jk === 'onboard') return str_starts_with($p['seg'], 'New') ? 'setup guide, variant v3 (AI draft)' : 'setup guide';
        return $p['val'] === 'high' ? '15% return offer' : 'what’s-new digest';
    }
    function mth_engine_sensitive(string $jk, array $p): bool {
        if ($jk === 'cart')    return (bool) $p['ps'];
        if ($jk === 'onboard') return str_starts_with($p['seg'], 'New');
        return $p['val'] === 'high';
    }
}

$mth_en_j    = 'winback';
$mth_en_runs = [];
foreach ($mth_en['profiles'] as $mth_en_p) $mth_en_runs[$mth_en_p['id']] = mth_engine_eval($mth_en, $mth_en_j, $mth_en_p);
/* per-node tallies for the finished state */
$mth_en_tal = array_fill(0, 6, ['ok' => 0, 'hold' => 0, 'stop' => 0, 'wait' => 0]);
foreach ($mth_en_runs as $mth_en_r) foreach ($mth_en_r as $mth_en_s) $mth_en_tal[$mth_en_s[0]][$mth_en_s[1]]++;
$mth_en_state = ['ok' => 'Passed', 'hold' => 'Held', 'stop' => 'Exited', 'wait' => 'Approval'];
$mth_en_clock = 9 * 3600 + 58 * 60;
?>
<section class="band mth-engine" id="engine" aria-labelledby="engine-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The always-on engine</p>
        <h2 class="h2" id="engine-t"><span class="g">Every message earns its send.</span> Watch the checks run.</h2>
      </div>
      <div><p class="lead">Six illustrative customers enter a journey. Consent, holdouts, contact limits and a person’s approval are applied to each in turn, and every step is logged. Switch the journey, withdraw a consent, approve or reject a send.</p></div>
    </div>

    <div class="mth-eng" data-mth-engine data-bdh-live>
      <script type="application/json" class="mth-eng__cfg"><?= json_encode($mth_en, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
      <div class="mth-eng__bar">
        <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="mth-eng__name"><span class="bdh-pulse" aria-hidden="true"></span>Journey engine · Your company</span>
        <div class="mth-eng__js" role="group" aria-label="Journey" hidden>
          <?php foreach ($mth_en['journeys'] as $mth_en_k => $mth_en_jr): ?>
          <button type="button" class="mth-eng__jb" data-j="<?= e($mth_en_k) ?>" aria-pressed="<?= $mth_en_k === $mth_en_j ? 'true' : 'false' ?>"><?= e($mth_en_jr['name']) ?></button>
          <?php endforeach; ?>
        </div>
        <p class="mth-eng__jname" data-nojs><?= e($mth_en['journeys'][$mth_en_j]['name']) ?> · finished run</p>
        <div class="mth-eng__ctl" hidden>
          <button type="button" class="mth-eng__btn" data-act="run" aria-pressed="false">Run</button>
          <button type="button" class="mth-eng__btn" data-act="step">Step</button>
          <button type="button" class="mth-eng__btn" data-act="reset">Reset</button>
          <span class="mth-eng__clock bdh-ro" aria-hidden="true"><?= gmdate('H:i:s', $mth_en_clock) ?></span>
        </div>
      </div>

      <div class="mth-eng__canvas dots">
        <ol class="mth-flow mth-eng__flow" aria-label="Journey steps">
          <?php foreach ($mth_en['nodes'] as $mth_en_i => $mth_en_n):
            $mth_en_d = [$mth_en['journeys'][$mth_en_j]['trigger'], $mth_en['consent'], $mth_en['journeys'][$mth_en_j]['decide'], $mth_en['guard'], $mth_en['journeys'][$mth_en_j]['rule'], $mth_en['send']][$mth_en_i];
            $mth_en_t = $mth_en_tal[$mth_en_i]; ?>
          <li class="mth-node" data-node="<?= $mth_en_i ?>">
            <span class="mth-node__k"><?= xt_icon($mth_en_n[1]) ?><?= sprintf('%02d', $mth_en_i + 1) ?></span>
            <span class="mth-node__t"><?= e($mth_en_n[0]) ?></span>
            <span class="mth-node__d" data-rule><?= e($mth_en_d) ?></span>
            <span class="mth-eng__tally bdh-ro" data-tally><?php
              $mth_en_bits = [];
              if ($mth_en_t['ok'] + $mth_en_t['hold']) $mth_en_bits[] = ($mth_en_t['ok'] + $mth_en_t['hold']) . ' through';
              if ($mth_en_t['hold']) $mth_en_bits[] = $mth_en_t['hold'] . ' held';
              if ($mth_en_t['stop']) $mth_en_bits[] = $mth_en_t['stop'] . ' out';
              if ($mth_en_t['wait']) $mth_en_bits[] = $mth_en_t['wait'] . ' waiting';
              echo e($mth_en_bits ? implode(' · ', $mth_en_bits) : '—'); ?></span>
          </li>
          <?php endforeach; ?>
        </ol>
      </div>

      <div class="mth-eng__panels">
        <div class="mth-eng__pan mth-eng__pan--people">
          <p class="mth-eng__h">Profiles <span>consent per channel</span></p>
          <div class="bdh-scroll-x mask-x" tabindex="0" role="region" aria-label="Profiles and their consent">
            <table class="mth-eng__tbl">
              <thead><tr><th scope="col">Profile</th><?php foreach ($mth_en['channels'] as $mth_en_cl): ?><th scope="col"><?= e($mth_en_cl) ?></th><?php endforeach; ?><th scope="col">Status</th></tr></thead>
              <tbody>
              <?php foreach ($mth_en['profiles'] as $mth_en_p):
                $mth_en_last = end($mth_en_runs[$mth_en_p['id']]); ?>
                <tr data-p="<?= e($mth_en_p['id']) ?>">
                  <th scope="row"><span class="mth-eng__pid"><?= e($mth_en_p['id']) ?></span><span class="mth-eng__seg"><?= e($mth_en_p['seg']) ?></span></th>
                  <?php foreach ($mth_en['channels'] as $mth_en_ck => $mth_en_cl): ?>
                  <td><button type="button" class="mth-eng__cons" data-ch="<?= e($mth_en_ck) ?>" aria-pressed="<?= $mth_en_p['c'][$mth_en_ck] ? 'true' : 'false' ?>" aria-label="<?= e($mth_en_cl) ?> marketing consent for <?= e($mth_en_p['id']) ?>" disabled><span aria-hidden="true"><?= $mth_en_p['c'][$mth_en_ck] ? 'On' : 'Off' ?></span></button></td>
                  <?php endforeach; ?>
                  <td data-status><span class="mth-chip mth-chip--<?= e($mth_en_last[1]) ?>"><?= e($mth_en_last[1] === 'ok' && $mth_en_last[0] === 5 ? 'Sent' : $mth_en_state[$mth_en_last[1]]) ?></span></td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="mth-eng__pan mth-eng__pan--queue">
          <p class="mth-eng__h">Approvals <span data-qn><?php $mth_en_q = array_filter($mth_en_runs, fn ($mth_r) => end($mth_r)[1] === 'wait'); echo count($mth_en_q); ?> waiting</span></p>
          <ul class="mth-eng__queue" data-queue>
            <?php foreach ($mth_en_q as $mth_en_id => $mth_en_r): ?>
            <li class="mth-eng__qi">
              <p><b><?= e($mth_en_id) ?></b> · <?= e(substr(end($mth_en_r)[2], strlen('Waiting for a person · '))) ?></p>
              <p class="mth-eng__qd"><?= e($mth_en_r[2][2]) ?></p>
            </li>
            <?php endforeach; ?>
          </ul>
          <p class="mth-eng__qe" data-qempty<?= $mth_en_q ? ' hidden' : '' ?>>Nothing waiting. Sensitive sends appear here and stop until someone decides.</p>
        </div>

        <div class="mth-eng__pan mth-eng__pan--log">
          <p class="mth-eng__h">Audit log <span>newest first</span></p>
          <div class="mth-eng__logwrap" tabindex="0" role="region" aria-label="Audit log">
            <ol class="mth-ledger" data-log role="log" aria-live="polite" aria-relevant="additions">
              <?php
              $mth_en_rows = [];
              foreach ($mth_en_runs as $mth_en_id => $mth_en_r) foreach ($mth_en_r as $mth_en_s) $mth_en_rows[] = [$mth_en_id, $mth_en_s];
              $mth_en_tm = $mth_en_clock;
              foreach ($mth_en_rows as $mth_en_x => $mth_en_row) { $mth_en_rows[$mth_en_x][] = gmdate('H:i:s', $mth_en_tm); $mth_en_tm += 7; }
              foreach (array_reverse($mth_en_rows) as $mth_en_row): ?>
              <li><span class="mth-ledger__tm"><?= $mth_en_row[2] ?></span><span class="mth-ledger__id"><?= e($mth_en_row[0]) ?></span><span class="mth-ledger__tx"><b><?= e($mth_en['nodes'][$mth_en_row[1][0]][0]) ?></b> · <?= e($mth_en_row[1][2]) ?></span></li>
              <?php endforeach; ?>
            </ol>
          </div>
        </div>
      </div>
      <p class="mth-eng__foot">Illustrative profiles and rules. Consent withdrawal is honoured at the next send, as easily as consent was given (DPDP Act 2023 s. 6(4); GDPR Art. 7(3)).</p>
    </div>

    <ul class="mth-eng__notes" data-bdh-stagger data-bdh-in>
      <li class="bdh-up"><span class="bdh-idx">01</span><p><b>Consent is checked at send time.</b> Not when the list was built. A withdrawal made a minute ago stops the next message.</p></li>
      <li class="bdh-up"><span class="bdh-idx">02</span><p><b>Holdouts are always on.</b> One in ten people receives nothing, so the lift each journey claims can be measured, not assumed.</p></li>
      <li class="bdh-up"><span class="bdh-idx">03</span><p><b>People own the sensitive switch.</b> Discounts, high-value offers and new AI-drafted copy wait for a named approver.</p></li>
    </ul>
  </div>
</section>
