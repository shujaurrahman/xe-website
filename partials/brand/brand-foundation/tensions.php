<?php /* DRAFT COPY — review before launch */
/* §3 Tension map — interview excerpts placed along two tensions. Pressing a pole regroups the
   excerpts that lean that way (tensions.js, FLIP). Quotes are illustrative and role-attributed only. */
$cbf_ten_axes = [   // key => [pole A, pole B]
    'x' => ['Heritage', 'Reinvention'],
    'y' => ['Premium', 'Accessible'],
];
$cbf_ten_q = [   // [quote, source, lean x 0–100, lean y 0–100, strategist note ('' = agent-clustered only)]
    ['People trust us because we have been here for decades. Do not sand that off.', 'Leadership interview · Operations', 14, 38, ''],
    ['We are expensive for a reason. The moment we discount, we are just another option.', 'Leadership interview · Finance', 42, 10, 'Premium is defended as a margin, not yet as a belief. Test it in the values session.'],
    ['Our newest customers have never heard the founding story, and they do not need to.', 'Customer conversation · Segment A', 82, 58, ''],
    ['If a first-time buyer cannot follow the offer in a minute, we have lost them.', 'Customer conversation · Segment B', 64, 86, ''],
    ['The heritage is a proof point, not the pitch.', 'Leadership interview · Marketing', 52, 44, 'This line holds both ends of the first tension. Candidate reason to believe.'],
    ['Every rebrand we tried looked like someone else’s company.', 'Leadership interview · Product', 24, 50, ''],
    ['Sales keep asking for an entry tier. The board keeps saying no.', 'Leadership interview · Sales', 58, 72, 'A pricing decision wearing brand clothes. Taken to the positioning session as a named choice.'],
    ['We should sound like the people who use us, not the people who sell to us.', 'Customer conversation · Segment C', 76, 80, ''],
];
?>
<section class="band cbf-ten" id="tensions" aria-labelledby="tensions-t">
  <div class="wrap">
    <header class="cbf-head cbf-head--split" data-rv>
      <p class="cbf-head__sec"><b>§ 03</b>Evidence</p>
      <div class="cbf-head__body">
        <h2 class="h2" id="tensions-t"><span class="g">Where the brand disagrees</span> with itself.</h2>
        <p class="lead"><?= e($CAP['offer'][3][1]) ?> We start by mapping what people actually said, grouped by the tensions a positioning has to resolve.</p>
      </div>
    </header>

    <div class="cbf-ten__grid">
      <div class="cbf-ten__instr">
        <p class="cbf-ten__cap"><span class="cbf-mono">Select a pole to regroup the excerpts</span><span class="cbf-ill">Illustrative</span></p>
        <?php foreach ($cbf_ten_axes as $cbf_ax => $cbf_poles): ?>
          <div class="cbf-ten__axis" role="group" aria-label="Tension: <?= e($cbf_poles[0]) ?> or <?= e($cbf_poles[1]) ?>">
            <button type="button" class="cbf-ten__pole" aria-pressed="false" data-axis="<?= $cbf_ax ?>" data-side="a"><?= e($cbf_poles[0]) ?></button>
            <span class="cbf-ten__rail" aria-hidden="true">
              <?php foreach ($cbf_ten_q as $cbf_qi => $cbf_q): ?><i class="cbf-ten__dot<?= $cbf_q[4] ? ' is-read' : '' ?>" style="--p:<?= (int) $cbf_q[$cbf_ax === 'x' ? 2 : 3] ?>%" data-q="<?= $cbf_qi ?>"></i><?php endforeach; ?>
            </span>
            <button type="button" class="cbf-ten__pole" aria-pressed="false" data-axis="<?= $cbf_ax ?>" data-side="b"><?= e($cbf_poles[1]) ?></button>
          </div>
        <?php endforeach; ?>
        <button type="button" class="cbf-ten__all" aria-pressed="true">Show every excerpt</button>

        <dl class="cbf-ten__key">
          <div><dt><i class="cbf-ten__k cbf-ten__k--agent" aria-hidden="true"></i>Agent-clustered</dt><dd>Grouped by an agent from the transcripts. Placement only; nobody has argued with it yet.</dd></div>
          <div><dt><i class="cbf-ten__k cbf-ten__k--read" aria-hidden="true"></i>Strategist-read</dt><dd>Read in context by a strategist, with a note on what it means for the foundation.</dd></div>
        </dl>

        <!-- PLACEHOLDER: reference photo (Unsplash) — replace with own documentary photography before launch -->
        <figure class="cbf-plate cbf-ten__plate">
          <div class="cbf-plate__img"><img src="<?= xe_url('assets/imgs/brand/brand-foundation/tensions-interview.jpg') ?>" alt="An interviewer with a notepad listens to a seated participant" width="1200" height="675" loading="lazy" decoding="async"></div>
          <figcaption><b>Plate 2</b><span>Conversations are recorded with consent, transcribed and clustered. Every placement is checked by a strategist before it reaches the leadership team.</span></figcaption>
        </figure>
      </div>

      <div class="cbf-ten__side">
        <p class="cbf-ten__status" aria-live="polite"><span class="cbf-mono" data-ten-status>All <?= count($cbf_ten_q) ?> excerpts</span></p>
        <ul class="cbf-ten__list">
          <?php foreach ($cbf_ten_q as $cbf_qi => $cbf_q): ?>
            <li class="cbf-ten__q<?= $cbf_q[4] ? ' is-read' : '' ?>" data-x="<?= (int) $cbf_q[2] ?>" data-y="<?= (int) $cbf_q[3] ?>" data-q="<?= $cbf_qi ?>">
              <blockquote class="cbf-ten__bq"><p>“<?= e($cbf_q[0]) ?>”</p></blockquote>
              <p class="cbf-ten__src"><span><?= e($cbf_q[1]) ?></span><span class="cbf-ten__tag"><?= $cbf_q[4] ? 'Strategist-read' : 'Agent-clustered' ?></span></p>
              <?php if ($cbf_q[4]): ?><p class="cbf-ten__read"><?= e($cbf_q[4]) ?></p><?php endif; ?>
            </li>
          <?php endforeach; ?>
          <li class="cbf-ten__div" aria-hidden="true" hidden><span>Leaning elsewhere</span></li>
        </ul>
      </div>
    </div>
  </div>
</section>
