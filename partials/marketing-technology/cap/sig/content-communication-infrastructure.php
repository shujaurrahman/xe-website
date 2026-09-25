<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Signature: one message routed to channels with consent. A shipping update, written once, is checked per channel
   against the person's consent and then sent, suppressed or queued, each with its reason. */
$mtd_ch = [
    ['Email',    'doc',    'Order shipped · HTML + text',        ['Rendered', 'Consent · yes',        'Sent'],         ['hold', 'ok', 'ok']],
    ['SMS',      'mobile', '160 chars · link shortened',         ['Rendered', 'No SMS consent',       'Suppressed'],   ['hold', 'stop', 'stop']],
    ['WhatsApp', 'chat',   'Utility template · approved',        ['Rendered', 'Opt-in · 12 Mar',      'Sent'],         ['hold', 'ok', 'ok']],
    ['Push',     'bolt',   'Title + deep link',                  ['Rendered', 'Token valid',          'Sent'],         ['hold', 'ok', 'ok']],
    ['In-app',   'browser','Banner on next session',             ['Rendered', 'Signed-in user',       'Queued'],       ['hold', 'ok', 'hold']],
];
?>
<?= mtd_sig_open('Message router · order.shipped', 'Your platform', [
    ['Compose', 'Compose: one shipping update written once and rendered for five channels.'],
    ['Consent', 'Consent: each channel checked against the person’s consent; SMS has none, so it will not be used.'],
    ['Route', 'Route: email, WhatsApp and push sent, SMS suppressed for lack of consent, and the in-app banner queued for the next session.'],
], 'Routing step') ?>
  <div class="mtd-rt">
    <div class="mtd-rt__msg">
      <p class="mtd-rt__k">Source · content model</p>
      <p class="mtd-rt__t">Your order is on its way</p>
      <dl class="mtd-rt__f">
        <div><dt>type</dt><dd>order.shipped</dd></div>
        <div><dt>locale</dt><dd>en-IN · hi-IN</dd></div>
        <div><dt>purpose</dt><dd>service</dd></div>
        <div><dt>fields</dt><dd>{{name}} {{eta}} {{track_url}}</dd></div>
      </dl>
    </div>
    <ul class="mtd-rt__ch">
      <?php foreach ($mtd_ch as $mtd_c): ?>
      <li data-on="<?= $mtd_c[0] === 'SMS' ? '2 3' : '' ?>">
        <span class="mtd-rt__ic"><?= xt_icon($mtd_c[1]) ?></span>
        <span class="mtd-rt__tx"><span class="mtd-rt__n"><?= e($mtd_c[0]) ?></span><span class="mtd-rt__d"><?= e($mtd_c[2]) ?></span></span>
        <span class="mth-chip mth-chip--<?= e(end($mtd_c[4])) ?>" data-c1="<?= e($mtd_c[4][0]) ?>" data-c2="<?= e($mtd_c[4][1]) ?>" data-c3="<?= e($mtd_c[4][2]) ?>"<?= mtd_t($mtd_c[3]) ?></span>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
<?= mtd_sig_close('Illustrative. Consent is checked at the moment of sending, per purpose and channel, not when the list was built.') ?>
