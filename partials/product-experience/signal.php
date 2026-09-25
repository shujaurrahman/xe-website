<?php /* DRAFT COPY — review before launch */
/* Signal → shipped — the signature showcase. One product idea ("let customers change plan without calling
   support") travels through five fidelities in one canvas: the same six blocks morph from interview notes
   to a journey, a wireframe, a prototype and a release, while an assumption tracker updates its states and
   confidence. Real controls: a stepper (buttons, aria-current), previous/next, play/pause, ← → keys.
   The shipped HTML is the finished state (stage 5, release). All figures are illustrative. */
$pxh_sg_names = ['Evidence', 'Journey', 'Wireframe', 'Prototype', 'Release'];
/* block geometry per stage: [x, y, w, h] in % of the canvas */
$pxh_sg_ui = [[4, 4, 92, 12], [4, 20, 29, 40], [35.5, 20, 29, 40], [67, 20, 29, 40], [4, 64, 60, 15], [68, 65, 28, 13]];
$pxh_sg_geo = [
    [[3, 6, 27, 32], [36.5, 3, 27, 32], [70, 8, 27, 32], [5, 52, 27, 32], [38, 56, 27, 32], [70.5, 50, 27, 32]],
    [[1, 22, 13.5, 20], [18.1, 40, 13.5, 20], [35.2, 64, 13.5, 20], [52.3, 50, 13.5, 20], [69.4, 68, 13.5, 20], [86.5, 12, 13.5, 20]],
    $pxh_sg_ui, $pxh_sg_ui, $pxh_sg_ui,
];
$pxh_sg_rot = [-2.5, 1.5, -1, 2, -1.5, 1];
$pxh_sg_blocks = [
    ['q' => '“Called support just to downgrade.”', 'src' => 'Interview 07', 'j' => 'Notice the need', 'u' => ['Change plan', 'Your platform · Billing']],
    ['q' => '“Where is billing? I checked settings twice.”', 'src' => 'Session 03', 'j' => 'Search settings', 'u' => ['Starter', '1 workspace', '3 seats · 5 GB · email support']],
    ['q' => '“We moved teams, not budgets.”', 'src' => 'Interview 11', 'j' => 'Give up', 'u' => ['Team', 'Current plan', '10 seats · 100 GB · roles']],
    ['q' => '“Scared we would lose our data if we switched.”', 'src' => 'Interview 04', 'j' => 'Email support', 'u' => ['Scale', 'Unlimited', 'Unlimited seats · SSO · audit log']],
    ['q' => '“I just want to see what changes.”', 'src' => 'Survey · open text', 'j' => 'Wait two days', 'u' => ['What changes', '3 seats removed · all data kept']],
    ['q' => '38 tickets a month tagged “plan change”', 'src' => 'Support analytics', 'j' => 'Plan changed', 'u' => ['Confirm change', '']],
];
/* journey edges, trimmed to leave each box at its side, plus a small gap (defect 4) */
$pxh_sg_edges = [];
for ($pxh_i = 0; $pxh_i < 5; $pxh_i++) {
    $pxh_a = $pxh_sg_geo[1][$pxh_i]; $pxh_b = $pxh_sg_geo[1][$pxh_i + 1];
    $pxh_sg_edges[] = [$pxh_a[0] + $pxh_a[2] + .6, $pxh_a[1] + $pxh_a[3] / 2, $pxh_b[0] - .6, $pxh_b[1] + $pxh_b[3] / 2];
}
/* phones: the journey runs top to bottom, with frustration to the left and relief to the right */
$pxh_sg_emo = [.6, .4, .1, .3, .05, .95];
$pxh_sg_mj = [];
foreach ($pxh_sg_emo as $pxh_i => $pxh_v) { $pxh_sg_mj[] = [round(2 + $pxh_v * 54, 1), 3 + $pxh_i * 16.2, 42, 11]; }
$pxh_sg_medges = [];
for ($pxh_i = 0; $pxh_i < 5; $pxh_i++) {
    $pxh_a = $pxh_sg_mj[$pxh_i]; $pxh_b = $pxh_sg_mj[$pxh_i + 1];
    $pxh_sg_medges[] = [$pxh_a[0] + $pxh_a[2] / 2, $pxh_a[1] + $pxh_a[3] + .8, $pxh_b[0] + $pxh_b[2] / 2, $pxh_b[1] - .8];
}
$pxh_sg_asm = ['People want to change plan without talking to anyone', 'Downgrades are mainly about price', 'Fear of losing data blocks the switch', 'Self-serve cuts plan-change contacts by 30%'];
$pxh_sg_stages = [
    ['title' => 'Collect the signal', 'did' => 'Twelve interviews, a support-ticket export and an open-text survey, tagged into one evidence base.', 'method' => 'Interviews · ticket analysis', 'strip' => '',
     'asm' => [['testing', 55, '9 of 12 interviews raise it unprompted'], ['testing', 40, 'Two quotes mention cost'], ['testing', 45, 'Raised in 4 interviews'], ['untested', 10, 'Baseline: 38 contacts a month']]],
    ['title' => 'Map the journey', 'did' => 'The quotes become one journey. The low point is not the price page; it is the two-day wait for support.', 'method' => 'Journey mapping', 'strip' => '',
     'asm' => [['validated', 72, 'Every journey ends in a support contact'], ['invalidated', 12, 'Team changes, not budgets, trigger it'], ['testing', 52, 'Drop-off at “what happens to our data”'], ['untested', 10, 'Baseline: 38 contacts a month']]],
    ['title' => 'Wireframe the answer', 'did' => 'Three plans side by side and a “what changes” panel that answers the data question before it is asked.', 'method' => 'Wireframes · engineering review', 'strip' => 'Wireframe · sized with 3 engineers · 1 API change',
     'asm' => [['validated', 74, 'Carried forward'], ['invalidated', 10, 'Pricing copy left out of scope'], ['testing', 60, 'Panel added to test it directly'], ['testing', 25, 'Target set: −30% in 4 weeks']]],
    ['title' => 'Prototype and test', 'did' => 'A clickable prototype in six moderated sessions. Five of six completed the change unaided; one missed the panel, so it moved up.', 'method' => 'Usability testing · 6 sessions', 'strip' => 'Prototype v3 · 5 of 6 completed unaided',
     'asm' => [['validated', 86, '5 of 6 completed unaided'], ['invalidated', 10, 'No participant asked about price'], ['validated', 82, '“Now I know nothing is lost” — P4'], ['testing', 40, 'Instrumented before release']]],
    ['title' => 'Release and measure', 'did' => 'Shipped behind a flag to 10%, then everyone. Plan-change contacts are tracked against the baseline for four weeks.', 'method' => 'Staged rollout · product analytics', 'strip' => 'Released · 100% · plan-change contacts −41% vs baseline (illustrative)',
     'asm' => [['validated', 92, 'Self-serve completion 94% (illustrative)'], ['invalidated', 8, 'Closed'], ['validated', 88, 'Panel viewed in 71% of changes'], ['measuring', 70, '−41% at week 4 · target −30%']]],
];
$pxh_sg_cur = 4;
$pxh_sg_c = $pxh_sg_stages[$pxh_sg_cur];
$pxh_sg_json = array_map(fn ($pxh_s) => $pxh_s, $pxh_sg_stages);
$pxh_sg_avg = fn ($pxh_st) => (int) round(array_sum(array_map(fn ($pxh_a) => $pxh_a[0] === 'invalidated' ? 100 - $pxh_a[1] : $pxh_a[1], $pxh_st['asm'])) / 4);
foreach ($pxh_sg_json as $pxh_i => $pxh_s) { $pxh_sg_json[$pxh_i]['risk'] = $pxh_sg_avg($pxh_s); $pxh_sg_json[$pxh_i]['name'] = $pxh_sg_names[$pxh_i]; }
?>
<section class="band band--alt pxh-signal" id="signal" aria-labelledby="signal-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>From signal to shipped</p>
        <h2 class="h2" id="signal-t"><span class="g">Follow one idea.</span> Watch the assumptions resolve.</h2></div>
      <div><p class="lead">One product idea, five fidelities, one canvas. Step through it: the same six pieces of evidence become a journey, a wireframe, a tested prototype and a release, and every assumption is tracked from “untested” to “measured”. The example and its figures are illustrative.</p></div>
    </div>

    <div class="pxh-sig" data-stage="<?= $pxh_sg_cur ?>">
      <div class="pxh-sig__nav">
        <ol class="pxh-sig__steps" aria-label="Stages of the idea">
          <?php foreach ($pxh_sg_names as $pxh_i => $pxh_n): ?>
          <li><button type="button" class="pxh-sig__step" data-i="<?= $pxh_i ?>"<?= $pxh_i === $pxh_sg_cur ? ' aria-current="step"' : '' ?>><span class="pxh-sig__sn">0<?= $pxh_i + 1 ?></span><span class="pxh-sig__st"><?= e($pxh_n) ?></span></button></li>
          <?php endforeach; ?>
        </ol>
        <div class="pxh-sig__ctl">
          <button type="button" class="pxh-sig__btn" data-act="prev" aria-label="Previous stage"><span aria-hidden="true">←</span></button>
          <button type="button" class="pxh-sig__btn pxh-sig__play" data-act="play" aria-pressed="false" aria-label="Play through the stages"><span class="pxh-sig__pi" aria-hidden="true"></span></button>
          <button type="button" class="pxh-sig__btn" data-act="next" aria-label="Next stage"><span aria-hidden="true">→</span></button>
        </div>
      </div>

      <div class="pxh-sig__g">
        <div class="pxh-win pxh-sig__win">
          <div class="pxh-win__bar"><span class="dots3" aria-hidden="true"><i></i><i></i><i></i></span><span>Idea 014 · Self-serve plan change</span><span class="sp pxh-sig__fid" data-bind="name"><?= e($pxh_sg_names[$pxh_sg_cur]) ?></span></div>
          <div class="pxh-sig__canvas" aria-hidden="true">
            <svg class="pxh-sig__edges pxh-sig__edges--d" viewBox="0 0 100 100" preserveAspectRatio="none" focusable="false">
              <?php foreach ($pxh_sg_edges as $pxh_e): ?><line x1="<?= $pxh_e[0] ?>" y1="<?= $pxh_e[1] ?>" x2="<?= $pxh_e[2] ?>" y2="<?= $pxh_e[3] ?>"/><?php endforeach; ?>
            </svg>
            <svg class="pxh-sig__edges pxh-sig__edges--m" viewBox="0 0 100 100" preserveAspectRatio="none" focusable="false">
              <?php foreach ($pxh_sg_medges as $pxh_e): ?><line x1="<?= $pxh_e[0] ?>" y1="<?= $pxh_e[1] ?>" x2="<?= $pxh_e[2] ?>" y2="<?= $pxh_e[3] ?>"/><?php endforeach; ?>
            </svg>
            <span class="pxh-sig__axis"><i>Frustration</i><i>Relief</i></span>
            <?php foreach ($pxh_sg_blocks as $pxh_i => $pxh_b):
                $pxh_st = '';
                foreach ($pxh_sg_geo as $pxh_si => $pxh_g) { $pxh_q = $pxh_g[$pxh_i]; $pxh_st .= "--x$pxh_si:{$pxh_q[0]}%;--y$pxh_si:{$pxh_q[1]}%;--w$pxh_si:{$pxh_q[2]}%;--h$pxh_si:{$pxh_q[3]}%;"; }
                $pxh_q = $pxh_sg_mj[$pxh_i]; $pxh_st .= "--mx1:{$pxh_q[0]}%;--my1:{$pxh_q[1]}%;--mw1:{$pxh_q[2]}%;--mh1:{$pxh_q[3]}%;";
                $pxh_st .= '--r0:' . $pxh_sg_rot[$pxh_i] . 'deg'; ?>
            <div class="pxh-sig__b pxh-sig__b--<?= $pxh_i + 1 ?>" style="<?= $pxh_st ?>">
              <span class="c-q"><b><?= e($pxh_b['q']) ?></b><small><?= e($pxh_b['src']) ?></small></span>
              <span class="c-j"><small>0<?= $pxh_i + 1 ?></small><b><?= e($pxh_b['j']) ?></b></span>
              <span class="c-w"><i></i><i></i><i></i></span>
              <span class="c-u"><b><?= e($pxh_b['u'][0]) ?></b><?php if ($pxh_b['u'][1] !== ''): ?><small><?= e($pxh_b['u'][1]) ?></small><?php endif; ?><?php if (!empty($pxh_b['u'][2])): ?><em><?= e($pxh_b['u'][2]) ?></em><?php endif; ?></span>
            </div>
            <?php endforeach; ?>
            <div class="pxh-sig__strip"><span class="pxh-sig__sd"></span><span data-bind="strip"><?= e($pxh_sg_c['strip']) ?></span></div>
            <span class="pxh-sig__cur"></span>
          </div>
          <p class="bdh-sr">The canvas shows the same six blocks at each stage: interview quotes, then a journey from noticing the need to the plan being changed, then a wireframe and a prototype of a plan-change screen with a “what changes” panel, then the released screen.</p>
        </div>

        <div class="pxh-sig__side">
          <div class="pxh-sig__panel" aria-live="polite">
            <p class="pxh-card__idx">Stage <span data-bind="num">0<?= $pxh_sg_cur + 1 ?></span> of 05 · <span data-bind="method"><?= e($pxh_sg_c['method']) ?></span></p>
            <h3 class="h3" data-bind="title"><?= e($pxh_sg_c['title']) ?></h3>
            <p class="p" data-bind="did"><?= e($pxh_sg_c['did']) ?></p>
          </div>
          <div class="pxh-sig__risk">
            <div class="pxh-sig__rk"><span class="pxh-mono">Confidence in the bet</span><b data-bind="risk"><?= $pxh_sg_json[$pxh_sg_cur]['risk'] ?>%</b></div>
            <div class="pxh-bar"><i style="--v:<?= $pxh_sg_json[$pxh_sg_cur]['risk'] ?>%" data-bind-v="risk"></i></div>
          </div>
          <table class="pxh-as">
            <caption class="pxh-mono">Assumption tracker</caption>
            <thead class="sr"><tr><th scope="col">Assumption</th><th scope="col">State</th><th scope="col">Evidence</th></tr></thead>
            <tbody>
              <?php foreach ($pxh_sg_asm as $pxh_i => $pxh_a): $pxh_r = $pxh_sg_c['asm'][$pxh_i]; ?>
              <tr class="pxh-as__r" data-a="<?= $pxh_i ?>">
                <th scope="row"><span class="pxh-as__id">A<?= $pxh_i + 1 ?></span><?= e($pxh_a) ?></th>
                <td class="pxh-as__s"><span class="pxh-st" data-st="<?= e($pxh_r[0]) ?>"><?= e($pxh_r[0]) ?></span><span class="pxh-bar"><i style="--v:<?= $pxh_r[1] ?>%"></i></span></td>
                <td class="pxh-as__e"><?= e($pxh_r[2]) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <script type="application/json" class="pxh-sig__data"><?= json_encode($pxh_sg_json, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
      <noscript><style>.pxh-sig__ctl{display:none}.pxh-sig__step{pointer-events:none}</style></noscript>
    </div>
    <p class="pxh-note">An illustrative engagement. Participant counts, ticket volumes and results are examples of what is measured, not client results.</p>
  </div>
</section>
