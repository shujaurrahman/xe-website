<?php /* DRAFT COPY — review before launch */
/* Research — the evidence half of the discipline. A method matrix (what each method answers, the
   sample it needs and when we run it), then the four measures we baseline before the work and repeat
   after release. Figures are the same ones the hero panel shows, because a page should not contradict
   itself. The table scrolls sideways inside .bdh-scroll-x on phones. */
$rsh_methods = [
    ['Moderated usability test',      'Why people get stuck, in their own words',                       '5–8 per round',              'Every fortnight through design'],
    ['Unmoderated task test',         'Whether a change worked, quickly',                               '15–30',                      'Between moderated rounds'],
    ['Tree testing &amp; first-click',    'Whether the structure matches how people look for things',       '30–50',                      'Before any screen is drawn'],
    ['Concept test',                  'Which of two directions people prefer, and for what reason',     '8–12',                       'At a fork in the road'],
    ['Usability benchmark',           'Task success, time on task and error rate as numbers',           '60+',                        'Before the work, and after release'],
    ['Diary study',                   'What the job actually looks like away from a desk',              '6–10, over one to two weeks','When the context is the question'],
    ['Testing with assistive technology', 'Barriers an automated check will never find',                '5–8, across technologies',   'Before every major release'],
    ['Analytics &amp; session replay',    'Where people leave, at which step and on which device',          'Your whole population',      'Continuously'],
    ['Win–loss and support read',     'Why people did not buy, and what they keep asking for',          '20–40 records',              'At the start of a strategy'],
    ['Preference and trust test',     'Whether people believe an AI answer and notice when it is wrong','8–12',                       'Whenever a model is in the journey'],
];
/* PLACEHOLDER: illustrative baseline and post-release figures, not a client result. 86 %, 41 s and 78
   are the same values the hero panel and #measures report.
   [name, printed baseline, printed after, printed target, unit, bar % baseline, bar % after,
    bar % target, which direction is better, definition] */
$rsh_bench = [
    ['Task success rate', '61', '86', '85', '%',   61, 86, 85, 'up',
     'The share of participants who finish the task unaided, with no prompting from the moderator.'],
    ['Time on task',      '78', '41', '45', ' s',  78, 41, 45, 'down',
     'Median seconds from the start of the task to the point the participant considers it done.'],
    ['Error rate',        '0.9', '0.2', '0.3', '', 90, 20, 30, 'down',
     'Errors per attempt, counted against a written definition of what an error is for this journey. Bars are drawn on a scale of nought to one.'],
    ['SUS',               '54', '78', '72', '',    54, 78, 72, 'up',
     'System Usability Scale: a ten-item questionnaire scored nought to 100. It is a score, not a percentage. UMUX-Lite, a two-item measure, is used where a shorter instrument fits.'],
];
?>
<section class="band pxh-research" id="research" aria-labelledby="research-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Evidence</p>
        <h2 class="h2" id="research-t"><span class="g">Opinions are cheap.</span> Put it in front of someone.</h2>
      </div>
      <div>
        <p class="lead">Every method here answers a different question and needs a different sample. We say which one we are running, what it can settle and what it cannot, before the sessions are booked.</p>
      </div>
    </div>

    <div class="pxh-research__top">
      <div class="pxh-research__tbl" data-rv>
        <div class="bdh-scroll-x mask-x pxh-wide" tabindex="0" role="group" aria-label="Research methods, what each answers and the sample it needs. Scroll sideways to see every column.">
          <table class="pxh-tbl pxh-research__table">
            <caption class="bdh-sr">Ten research methods, what each one answers, the typical sample size and when in a project it runs.</caption>
            <thead>
              <tr><th scope="col">Method</th><th scope="col">What it answers</th><th scope="col">Typical sample</th><th scope="col">When it runs</th></tr>
            </thead>
            <tbody>
              <?php foreach ($rsh_methods as $rsh_m): ?>
                <tr>
                  <th scope="row"><?= $rsh_m[0] ?></th>
                  <td><?= $rsh_m[1] ?></td>
                  <td class="pxh-tbl__m"><?= e($rsh_m[2]) ?></td>
                  <td class="pxh-tbl__m"><?= e($rsh_m[3]) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="pxh-research__aside" data-rv data-rv-d="80">
        <!-- PLACEHOLDER: reference photograph (Unsplash, credited in assets/imgs/product-experience/CREDITS.md)
             — replace with commissioned photography before launch -->
        <figure class="pxh-research__fig">
          <span class="bdh-img bdh-img--r43">
            <img src="<?= xe_url('assets/imgs/product-experience/research-notes.jpg') ?>" alt="Hands sorting handwritten notes across a table during a synthesis session" width="1000" height="750" loading="lazy" decoding="async">
          </span>
          <figcaption class="pxh-research__figcap">Synthesis is where sessions become decisions. Every theme has to point at something a participant did.</figcaption>
        </figure>
        <div class="pxh-research__q">
          <p class="pxh-k">Why five to eight</p>
          <p>Five to eight participants per round finds most usability problems in a single journey, which is why we run many small rounds rather than one large study. Benchmarks and preference tests need larger quantitative samples, and we say which kind we are running and why.</p>
        </div>
        <p class="pxh-note">Participants are recruited with informed consent and paid an incentive. Recordings and transcripts are kept for the life of the project and then deleted, and research data is handled under the GDPR and the DPDP Act 2023 alongside your own policies.</p>
      </div>
    </div>

    <div class="pxh-research__bench">
      <div class="pxh-research__bh" data-rv>
        <div>
          <p class="pxh-k">The baseline</p>
          <p class="pxh-research__bt">Four numbers, taken before the work and repeated after release.</p>
        </div>
        <p class="pxh-note pxh-research__bn">A redesign that cannot be measured is a matter of taste. We take these four before anything changes, agree the target with you, and repeat the same tasks with the same script after release. <b>The figures below are illustrative.</b></p>
      </div>

      <ul class="pxh-cards pxh-cards--4 pxh-research__cards" role="list" data-rv-s data-rv-step="70">
        <?php foreach ($rsh_bench as $rsh_i => $rsh_b): ?>
          <li class="pxh-card pxh-research__card">
            <span class="pxh-card__top">
              <span class="pxh-card__n"><?= str_pad((string) ($rsh_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <span class="bdh-ill"><?= $rsh_b[8] === 'up' ? 'Higher is better' : 'Lower is better' ?></span>
            </span>
            <h3 class="pxh-card__t"><?= e($rsh_b[0]) ?></h3>
            <p class="pxh-meter"><b><?= e($rsh_b[2]) ?></b><?= $rsh_b[4] !== '' ? '<small>' . e(trim($rsh_b[4])) . '</small>' : '' ?><span>after · from <?= e($rsh_b[1]) ?><?= e($rsh_b[4]) ?></span></p>
            <div class="pxh-bars pxh-research__bars">
              <div class="pxh-bar pxh-bar--tgt">
                <span class="pxh-bar__n">Baseline</span>
                <span class="pxh-bar__v"><?= e($rsh_b[1]) ?><?= e($rsh_b[4]) ?></span>
                <span class="pxh-bar__track"><i class="pxh-bar__fill pxh-bar__fill--quiet" style="--p:<?= $rsh_b[5] ?>"></i><i class="pxh-bar__tgt" style="--tgt:<?= $rsh_b[7] ?>"></i></span>
              </div>
              <div class="pxh-bar pxh-bar--tgt">
                <span class="pxh-bar__n">After release</span>
                <span class="pxh-bar__v"><?= e($rsh_b[2]) ?><?= e($rsh_b[4]) ?></span>
                <span class="pxh-bar__track"><i class="pxh-bar__fill" style="--p:<?= $rsh_b[6] ?>;--i:1"></i><i class="pxh-bar__tgt" style="--tgt:<?= $rsh_b[7] ?>"></i></span>
              </div>
            </div>
            <p class="pxh-research__def"><span class="pxh-k">Definition</span><?= e($rsh_b[9]) ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
      <p class="pxh-note pxh-research__legend"><span class="pxh-research__key" aria-hidden="true"></span>The upright rule on each pair of bars is the target agreed before the work starts. Task success and SUS get better by going up; time on task and error rate get better by going down, so on those two a shorter bar is the good one.</p>
    </div>
  </div>
</section>
