<?php /* DRAFT COPY — review before launch */
/**
 * Book · who — who is actually on the call, on both sides.
 *
 * No names, no photographs and no headcount: the roles are the honest unit here, and inventing a
 * person to put on a booking page would be a fabrication. The discipline chips come straight from
 * data/site.php so they can never drift from the menu. They are deliberately NOT links — four of the
 * six discipline hubs are being built in parallel, so this section links once to the services index,
 * which exists, rather than to pages that may not.
 *
 * Composed as three stacked rows (our seats, then the two sides, then the disciplines strip) rather
 * than two tall columns, because our side has twice the content and a two-column split left a long
 * empty column beside it.
 *
 * Requires $SITE and $BK (book.php). Locals are prefixed wh_.
 */
$wh_ours = [
    ['users', 'The lead who would run it',
     'A discipline lead rather than an account manager. If the work goes ahead, this is the person accountable for it, and they will be on the call that decides whether it should.'],
    ['wrench', 'A practitioner from your discipline',
     'An engineer, designer, strategist or marketer, depending on where the work sits. They are there to ask the awkward question early, while it is still cheap to answer.'],
];
$wh_yours = [
    'The person who owns the outcome. Without them the call becomes a summary of a decision made elsewhere.',
    'Whoever holds the real constraint — the date, the budget ceiling, the legal review, or the platform you cannot leave.',
    'If the work is technical, one person who knows how the current setup actually behaves, not how it was documented.',
];
?>
<section class="band bk-who" id="who" aria-labelledby="who-t">
  <div class="wrap">

    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>In the room</p>
        <h2 class="h2" id="who-t"><span class="g">Two people from our side.</span> Both of them do the work.</h2>
      </div>
      <div>
        <p class="lead">No account team, no note-taker, and nobody who will hand you on afterwards.
          The two who join are the two who would run it.</p>
      </div>
    </div>

    <!-- PLACEHOLDER: confirm who attends a discovery call, and the titles used, before launch -->
    <div class="bk-who__row" data-rv data-rv-d="50">
      <p class="bk-k bk-who__k">From our side</p>
      <div class="bk-seats">
        <?php foreach ($wh_ours as $wh_s): ?>
          <article class="bk-seat">
            <span class="bk-seat__ico" aria-hidden="true"><?= xt_icon($wh_s[0]) ?></span>
            <h3><?= e($wh_s[1]) ?></h3>
            <p><?= e($wh_s[2]) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="bk-who__row bdh-grid bk-who__split" data-rv data-rv-d="80">
      <div class="bdh-c5">
        <p class="bk-k bk-who__k">From your side</p>
        <ul class="bdh-bullets bk-who__list">
          <?php foreach ($wh_yours as $wh_y): ?>
            <li><?= e($wh_y) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="bdh-c6 bdh-s7 bk-who__notes">
        <p class="bk-k bk-who__k">Worth knowing</p>
        <p class="bk-note">
          <b>Two or three is ideal</b>
          Past about five people it becomes a briefing, and a briefing is not a conversation. Anyone
          who could not make it gets the written summary afterwards.
        </p>
        <!-- PLACEHOLDER: confirm the NDA position and who signs before launch -->
        <p class="bk-note">
          <b>Under NDA if you need it</b>
          We will sign yours before the call so you can talk specifics. Ask in the booking notes, or
          send it to <a href="mailto:<?= e($BK['email']) ?>"><?= e($BK['email']) ?></a> and we will
          return it before the invitation.
        </p>
      </div>
    </div>

    <div class="bk-who__disc" data-rv data-rv-d="110">
      <div class="bk-who__disct">
        <p class="bk-who__discp">The practitioner comes from whichever of the six disciplines your work
          sits in. Say which one in the booking notes and we will bring the right person.</p>
        <a class="tl" href="<?= xe_url('services/') ?>">What each discipline covers <span class="i" aria-hidden="true">›</span></a>
      </div>
      <ul class="bdh-tags bk-who__chips" role="list">
        <?php foreach ($SITE['disciplines'] as $wh_d): ?>
          <li><span class="bdh-tag"><?= e($wh_d['short']) ?></span></li>
        <?php endforeach; ?>
      </ul>
    </div>

  </div>
</section>
