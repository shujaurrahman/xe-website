<?php /* DRAFT COPY — review before launch */
/* Reach — the other ways in: one inbox per kind of message with the reply we aim for, the offices
   with map links, and the hours a call can land in. Shown in both the form state and after a brief
   is sent, because that is when people look for the right inbox for the follow-up.
   PLACEHOLDER: confirm careers@, press@, invoices@ and security@ exist on this domain, and every
   response time and office hour below, before launch. */
$ct_dom = substr(strrchr($SITE['company']['email'], '@'), 1);
$ct_boxes = [
    ['New work',  $SITE['company']['email'], 'handshake', 'Projects, proposals, tenders and anything you would rather not put in a form.', 'Aim: 1 working day'],
    ['Careers',   'careers@' . $ct_dom,      'users',     'Applications, portfolios and questions about open roles.',                      'Aim: 5 working days'],
    ['Press',     'press@' . $ct_dom,        'chat',      'Interviews, commentary and speaking requests.',                                 'Aim: 2 working days'],
    ['Security',  'security@' . $ct_dom,     'shield',    'Report a vulnerability in anything we run. Please do not test live client systems.', 'Acknowledged: 2 working days'],
];
/* PLACEHOLDER: confirm office hours and the overlap window before launch */
$ct_hours = [
    ['Both offices', 'Mon–Fri, 09:30–18:30 IST', 'UTC+5:30'],
    ['Overlap with Europe', '13:00–18:30 IST', 'Most of the European working afternoon'],
    ['Overlap with the Americas', '18:00–21:00 IST', 'Arranged per engagement, not standing'],
];
?>
<section class="band band--alt ct-reach" id="reach" aria-labelledby="reach-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row ct-reach__head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Other ways in</p>
        <h2 class="h2" id="reach-t"><span class="g">The right inbox,</span> and when to expect a reply.</h2>
      </div>
      <div>
        <p class="lead">Four addresses, each read by the people it belongs to. A brief sent through the form reaches the same place as the first one, already routed by discipline.</p>
      </div>
    </div>

    <ul class="ct-boxes" data-rv-s data-rv-step="60">
      <?php foreach ($ct_boxes as $ct_b): ?>
        <li class="ct-box">
          <span class="ct-box__ico" aria-hidden="true"><?= xt_icon($ct_b[2]) ?></span>
          <h3 class="ct-box__t"><?= e($ct_b[0]) ?></h3>
          <p class="ct-box__d"><?= e($ct_b[3]) ?></p>
          <a class="ct-box__a" href="mailto:<?= e($ct_b[1]) ?>"><?= e($ct_b[1]) ?></a>
          <p class="ct-box__sla"><?= xt_icon('clock') ?><span><?= e($ct_b[4]) ?></span></p>
        </li>
      <?php endforeach; ?>
    </ul>

    <h3 class="ct-reach__sub">Offices and hours</h3>
    <div class="ct-reach__two">
      <ul class="ct-offices">
        <?php foreach ($SITE['company']['studios'] as $ct_o): $ct_q = rawurlencode(implode(', ', $ct_o['lines'])); ?>
          <li class="ct-office">
            <p class="ct-office__k"><?= xt_icon('pin') ?><span><?= e($ct_o['city']) ?></span></p>
            <address class="ct-office__a">
              <?php foreach ($ct_o['units'] as $ct_u): ?><span class="ct-office__u"><?= e($ct_u) ?></span><?php endforeach; ?>
              <?php foreach ($ct_o['lines'] as $ct_ln): ?><span><?= e($ct_ln) ?></span><?php endforeach; ?>
            </address>
            <a class="ct-office__map" href="https://www.google.com/maps/search/?api=1&amp;query=<?= $ct_q ?>" target="_blank" rel="noopener">Open in Maps<span class="bdh-sr"> — <?= e($ct_o['city']) ?> office (opens in a new tab)</span> <span class="i" aria-hidden="true">›</span></a>
          </li>
        <?php endforeach; ?>
        <li class="ct-office ct-office--visit">
          <p class="ct-office__k"><?= xt_icon('calendar') ?><span>Visiting</span></p>
          <p class="ct-office__p">Meetings at either office are by appointment. Say so in your brief and we will send directions and a time.</p>
        </li>
      </ul>

      <div class="ct-hours">
        <p class="ct-hours__k">When a call can land</p>
        <!-- PLACEHOLDER: confirm the hours and overlap windows below before launch -->
        <dl class="ct-hours__l">
          <?php foreach ($ct_hours as $ct_h): ?>
            <div><dt><?= e($ct_h[0]) ?></dt><dd><b><?= e($ct_h[1]) ?></b><span><?= e($ct_h[2]) ?></span></dd></div>
          <?php endforeach; ?>
        </dl>
        <p class="ct-hours__n">Tell us your time zone in the brief and we will propose a time inside your working day, not at the edge of it.</p>
      </div>
    </div>
  </div>
</section>
