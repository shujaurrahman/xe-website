<?php /* DRAFT COPY — review before launch */
/* Other ways in: one inbox per kind of message, what reply to expect from each, and the offices with map links. */
$ct_dom = substr(strrchr($SITE['company']['email'], '@'), 1);
/* PLACEHOLDER: confirm careers@, press@ and security@ exist on this domain, and every response time below, before launch. */
$ct_boxes = [
    ['New work',         $SITE['company']['email'], 'briefcase', 'Projects, proposals and anything you would rather not put in a form.', 'Aim: 1 working day'],
    ['Careers',          'careers@' . $ct_dom,      'users',     'Applications, portfolios and questions about open roles.',               'Aim: 5 working days'],
    ['Press',            'press@' . $ct_dom,        'chat',      'Interviews, commentary and speaking requests.',                           'Aim: 2 working days'],
    ['Security',         'security@' . $ct_dom,     'shield',    'Report a vulnerability in anything we run. Please do not test live client systems.', 'Acknowledged: 2 working days'],
];
?>
<section class="band band--alt ct-reach" id="reach" aria-labelledby="reach-t">
  <div class="wrap">
    <div class="ct-reach__head">
      <p class="lbl lbl--blue"><span class="dot"></span>Other ways in</p>
      <h2 class="h2" id="reach-t"><span class="g">The right inbox,</span> and when to expect a reply.</h2>
    </div>

    <ul class="ct-boxes">
      <?php foreach ($ct_boxes as $ct_b): ?>
        <li class="ct-box">
          <span class="ct-box__ico" aria-hidden="true"><?= xt_icon($ct_b[2] === 'briefcase' ? 'handshake' : $ct_b[2]) ?></span>
          <h3 class="ct-box__t"><?= e($ct_b[0]) ?></h3>
          <p class="ct-box__d"><?= e($ct_b[3]) ?></p>
          <a class="ct-box__a" href="mailto:<?= e($ct_b[1]) ?>"><?= e($ct_b[1]) ?></a>
          <p class="ct-box__sla"><?= xt_icon('clock') ?><span><?= e($ct_b[4]) ?></span></p>
        </li>
      <?php endforeach; ?>
    </ul>

    <h3 class="ct-reach__sub">Offices</h3>
    <ul class="ct-offices">
      <?php foreach ($SITE['company']['studios'] as $ct_o): $ct_q = rawurlencode(implode(', ', $ct_o['lines'])); ?>
        <li class="ct-office">
          <p class="ct-office__k"><?= xt_icon('pin') ?><span><?= e($ct_o['city']) ?></span></p>
          <address class="ct-office__a">
            <?php foreach ($ct_o['units'] as $ct_u): ?><span class="ct-office__u"><?= e($ct_u) ?></span><?php endforeach; ?>
            <?php foreach ($ct_o['lines'] as $ct_ln): ?><span><?= e($ct_ln) ?></span><?php endforeach; ?>
          </address>
          <a class="ct-office__map" href="https://www.google.com/maps/search/?api=1&amp;query=<?= $ct_q ?>" target="_blank" rel="noopener">Open in Maps<span class="sr"> — <?= e($ct_o['city']) ?> office (opens in a new tab)</span> <span class="i" aria-hidden="true">›</span></a>
        </li>
      <?php endforeach; ?>
      <li class="ct-office ct-office--visit">
        <p class="ct-office__k"><?= xt_icon('calendar') ?><span>Visiting</span></p>
        <p class="ct-office__p">Meetings at either office are by appointment. Tell us in your brief and we will send directions and a time.</p>
      </li>
    </ul>
  </div>
</section>
