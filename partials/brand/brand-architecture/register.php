<?php /* DRAFT COPY — review before launch */
/* 10 · Deliverables — a drawing register, the way an architect issues a set: sheet number, title,
   format, what it answers and its issue stage. Rows come from $BD deliver; the "answers" column
   and stage are DRAFT COPY. Rows are stamped in on entry. */
$cba_deliver = $CBA_CAP['deliver'];
$cba_answers = [
    'Which brands exist, what each costs and earns, where customers get lost.',
    'Which model, why, and what was traded away to choose it.',
    'How any two brands appear together, and where they never meet.',
    'What the next product, tier or feature is called, without a debate.',
    'What moves when, in what order, with which risks watched.',
    'Whether a proposal deserves a brand at all.',
];
$cba_stage = ['Wk 02', 'Wk 05', 'Wk 05', 'Wk 08', 'Wk 08', 'Wk 08']; /* PLACEHOLDER: issue weeks follow the 8-week plan — confirm per engagement */
?>
<section class="band cba-reg" id="register" aria-labelledby="register-t">
  <div class="wrap">
    <div class="cba-head" data-rv>
      <div class="cba-head__t">
        <p class="cba-eb"><b>A-109</b><i aria-hidden="true"></i>Drawing register · what you receive</p>
        <h2 class="h2" id="register-t"><span class="g">Issued as a set.</span> Every sheet answers one question.</h2>
      </div>
      <div class="cba-head__l">
        <p class="lead">Each deliverable is issued like a sheet in a drawing set: numbered, in a working format your teams already use, and dated to the week it is signed.</p>
      </div>
    </div>

    <div class="cba-reg__set" data-bdh-in>
      <div class="cba-reg__title" aria-hidden="true">
        <span class="cba-reg__tk">Set</span><b>Your brand · Portfolio architecture</b>
        <span class="cba-reg__tk">Sheets</span><b><?= count($cba_deliver) ?></b>
        <span class="cba-reg__tk">Status</span><b class="cba-reg__issued">Issued for use</b>
      </div>
      <p class="cba-reg__note"><span class="cba-illus">Illustrative</span><span>Issue weeks follow the eight-week plan; each engagement sets its own.</span></p>
      <div class="bdh-scroll-x cba-reg__scroll" tabindex="0" role="region" aria-label="Drawing register, scroll sideways on small screens">
        <table class="cba-reg__table">
          <caption class="bdh-sr">Deliverables register: sheet number, title, format, the question each answers, and the week it is issued</caption>
          <thead>
            <tr><th scope="col">Sheet</th><th scope="col">Title</th><th scope="col">Format</th><th scope="col">Answers</th><th scope="col">Issued</th></tr>
          </thead>
          <tbody>
            <?php foreach ($cba_deliver as $cba_di => $cba_dv): ?>
              <tr style="--i:<?= $cba_di ?>">
                <td class="cba-reg__no">A-<?= 201 + $cba_di ?></td>
                <th scope="row" class="cba-reg__name"><?= e($cba_dv[0]) ?></th>
                <td class="cba-reg__fmt"><?php foreach (preg_split('/\s*·\s*/u', $cba_dv[1]) as $cba_f): ?><span><?= e($cba_f) ?></span><?php endforeach; ?></td>
                <td class="cba-reg__ans"><?= e($cba_answers[$cba_di] ?? '') ?></td>
                <td class="cba-reg__wk"><span><?= e($cba_stage[$cba_di] ?? '') ?></span></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <p class="cba-reg__foot"><span class="cba-mono cba-mono--blue">Agent</span> keeps the register current and checks every sheet against the decision record. <span class="cba-mono cba-mono--ink">People</span> sign each sheet before it is issued.</p>
    </div>
  </div>
</section>
