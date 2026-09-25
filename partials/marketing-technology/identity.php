<?php /* DRAFT COPY — review before launch */
/* Identity — the two things everything else rests on: one record per person, and a consent state that is
   enforced when a message is sent rather than when a list is built. The ladder diagram reuses the stage
   and node idiom, with connectors routed by mth_edge() into one trunk, so five sources read as a bus into
   the match rules rather than five lines crossing the boxes. The consent ledger is a real table with
   header scopes; the send decision beside it is a decorative readout with a spoken-word description.
   No JavaScript in this section: everything here is the finished state. */
$ide_srcs = [
    ['Commerce platform', 'orders · carts · addresses'],
    ['CRM',               'contacts · deals · activity'],
    ['Service desk',      'tickets · calls · outcomes'],
    ['Web & app',         'events · sessions · device'],
    ['Loyalty',           'member id · tier · points'],
];
$ide_rules = [
    ['01', 'Deterministic first', 'sha256(email) · sha256(phone) · member_id · order_id'],
    ['02', 'Stitched at login',   'device_id joined only when a person signs in'],
    ['03', 'Survivorship order',  'CRM wins on name and consent · commerce wins on address'],
    ['04', 'Retention applied',   'deleted on request · expired on the rule, not on memory'],
];
/* stage geometry, 1000 × 500 */
$ide_ys    = [58, 158, 258, 358, 452];
$ide_match = mth_box(500, 258, 250, 210);
$ide_prof  = mth_box(852, 258, 220, 170);
$ide_boxes = array_map(fn ($ide_y) => mth_box(140, $ide_y, 220, 66), $ide_ys);

/* the consent ledger: [channel, state class, state, what is recorded, captured where, enforced where] */
$ide_ledger = [
    ['Email marketing',    'on',   'Granted',    'Consent text version, timestamp, source form', 'Preference centre · checkout', 'At send, per message'],
    ['WhatsApp',           'on',   'Opted in',   'Opt-in event, template category, service window', 'WhatsApp opt-in · checkout', 'At send, template checked'],
    ['SMS',                'wait', 'Not asked',  'Nothing recorded yet',                          'Not requested',                'Blocked until asked'],
    ['Analytics measurement', 'on', 'Granted',   'Consent Mode signal, timestamp',                'Consent banner',               'Read by the server-side tag'],
    ['Ad personalisation', 'off',  'Denied',     'Consent Mode signal, timestamp',                'Consent banner',               'Tags stay limited · no audience push'],
];
/* the send decision, as the system records it (illustrative) */
$ide_checks = [
    ['pass',  'consent(email)',                   'granted · preference centre · 12 Mar'],
    ['pass',  'suppression(ordered_24h)',         'false'],
    ['pass',  'frequency(1 / 7d)',                '0 of 1 used'],
    ['pass',  'quiet_hours(21:00–08:00 local)',   'outside'],
    ['block', 'audience_push(ad_personalization)', 'denied → skipped'],
];
$ide_never = [
    'Buy or rent contact lists.',
    'Infer or target on special-category data such as health, religion, politics or sexual orientation.',
    'Price or discount by an individual’s personal characteristics or inferred willingness to pay.',
    'Match on a raw email address or phone number where a hash does the same job.',
    'Join devices or households into one person without a sign-in event.',
    'Keep personal data past the retention rule agreed for its purpose.',
];
?>
<section class="band mth-identity" id="identity" aria-labelledby="identity-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Identity &amp; consent</p>
        <h2 class="h2" id="identity-t"><span class="g">One person, one record.</span> Consent enforced at the send.</h2>
      </div>
      <div>
        <p class="lead">Every model, segment and journey on this page is only as good as the record under it. So the record comes first: matched on hashed identifiers, deduplicated with a survivorship order, and carrying a consent state that the send itself checks.</p>
      </div>
    </div>

    <figure class="mth-ide__fig" data-rv data-rv-d="50">
      <p class="bdh-sr">A diagram of identity resolution: five source systems — commerce, CRM, the service desk, web and app, and loyalty — feed one set of match rules. Deterministic keys are tried first on hashed email, hashed phone, member id and order id; device identifiers are stitched only at sign-in; a survivorship order decides which system wins each field; and retention rules are applied to the record. The output is one profile with its identifiers, consent, segments, scores and history.</p>
      <div class="mth-stage mth-ide__stage" style="--ar:1000 / 500" aria-hidden="true">
        <svg viewBox="0 0 1000 500" focusable="false">
          <?php foreach ($ide_boxes as $ide_b): ?>
            <path class="mth-edge" d="<?= e(mth_edge($ide_b, $ide_match, 'h')) ?>"/>
          <?php endforeach; ?>
          <path class="mth-edge mth-edge--live" d="<?= e(mth_edge($ide_match, $ide_prof, 'straight-h')) ?>"/>
        </svg>
        <?php foreach ($ide_srcs as $ide_i => $ide_s): ?>
          <span class="mth-node" style="--x:14;--y:<?= round($ide_ys[$ide_i] / 5, 2) ?>;--w:22">
            <span class="mth-node__t"><?= e($ide_s[0]) ?></span>
            <span class="mth-node__s"><?= e($ide_s[1]) ?></span>
          </span>
        <?php endforeach; ?>

        <span class="mth-node mth-ide__match" style="--x:50;--y:51.6;--w:25">
          <span class="mth-node__t"><b>MATCH</b>Resolution rules</span>
          <span class="mth-ide__rules">
            <?php foreach ($ide_rules as $ide_r): ?>
              <span class="mth-ide__rule"><i><?= e($ide_r[0]) ?></i><b><?= e($ide_r[1]) ?></b><em><?= e($ide_r[2]) ?></em></span>
            <?php endforeach; ?>
          </span>
        </span>

        <span class="mth-node mth-node--on mth-ide__prof" style="--x:85.2;--y:51.6;--w:22">
          <span class="mth-node__t"><b>PROFILE</b>One customer</span>
          <span class="mth-ide__pl">
            <span>identifiers</span><span>consent &amp; preferences</span><span>segments &amp; scores</span><span>transactions &amp; service history</span>
          </span>
          <span class="mth-node__s">0 duplicates · retention applied</span>
        </span>
      </div>
      <figcaption class="mth-note mth-ide__cap"><b>Five feeds, one trunk, one profile.</b> The match rules are written down and version-controlled, so a merge can be explained and, if it was wrong, reversed.</figcaption>
    </figure>

    <div class="mth-ide__grid">
      <div class="mth-ide__ledger" data-rv>
        <h3 class="mth-ide__h3">The consent ledger</h3>
        <p class="mth-ide__sub">One row per channel, held against the profile rather than against a list. States below are an illustrative record for one person.</p>
        <div class="bdh-scroll-x mth-ide__scroll" tabindex="0" role="group" aria-label="Consent ledger, scroll sideways to see every column">
          <table class="mth-ide__table">
            <thead>
              <tr>
                <th scope="col">Channel</th>
                <th scope="col">State</th>
                <th scope="col">What is recorded</th>
                <th scope="col">Captured where</th>
                <th scope="col">Enforced where</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($ide_ledger as $ide_l): ?>
                <tr>
                  <th scope="row"><?= e($ide_l[0]) ?></th>
                  <td><span class="mth-flag mth-flag--<?= e($ide_l[1]) ?>"><?= e($ide_l[2]) ?></span></td>
                  <td><?= e($ide_l[3]) ?></td>
                  <td><?= e($ide_l[4]) ?></td>
                  <td><?= e($ide_l[5]) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <p class="mth-note">Consent is captured with its text version, its scope and its timestamp, so a data-principal or data-subject request can be answered with a record rather than with an assurance. Frameworks this is built to are in <a class="mth-ide__jump" href="#standards">Standards &amp; frameworks</a>.</p>
      </div>

      <div class="mth-ide__right">
        <div class="mth-ide__send mth-on-ink" data-rv data-rv-d="60">
          <p class="mth-ide__sendh"><span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span><span>send-decision · prf_8f21c</span><span class="bdh-ill">Illustrative</span></p>
          <p class="bdh-sr">An illustrative send decision for one profile: consent for email granted, no suppression, no frequency cap used, outside quiet hours, and the paid-audience push skipped because ad personalisation is denied. The message goes out on WhatsApp and the audience push is held.</p>
          <ul class="mth-ide__checks" aria-hidden="true">
            <?php foreach ($ide_checks as $ide_ck): ?>
              <li class="mth-ide__check is-<?= e($ide_ck[0]) ?>">
                <i aria-hidden="true"><?= $ide_ck[0] === 'pass' ? '✓' : '✕' ?></i>
                <b><?= e($ide_ck[1]) ?></b>
                <span><?= e($ide_ck[2]) ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
          <p class="mth-ide__out" aria-hidden="true"><span class="mth-k">Decision</span>Send on WhatsApp at 19:10 IST. Hold the paid audience push.</p>
        </div>

        <div class="mth-ide__never" data-rv data-rv-d="90">
          <h3 class="mth-ide__h3">What we do not do with customer data</h3>
          <ul class="bdh-bullets mth-ide__nl">
            <?php foreach ($ide_never as $ide_n): ?><li><?= e($ide_n) ?></li><?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
