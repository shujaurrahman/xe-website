<?php /* DRAFT COPY — review before launch */
/* 09 · Process ($CAP['process']) as a CI pipeline. Each phase is a stage; its artefacts are the jobs
   that must pass before the next stage runs. HTML is the finished (all passed) state; process.js
   runs it queued → running → passed on entry and on "Run again". Weeks come from data (PLACEHOLDER). */
$cbs_pr = $CAP['process'];
$cbs_pr_n = count($cbs_pr['steps']);
?>
<section class="band cbs-pr" id="process" aria-labelledby="cbs-pr-t">
  <div class="wrap">
    <header class="cbs-head cbs-head--split" data-rv>
      <p class="cbs-head__path"><b>09</b><i>/</i>how-it-runs<i>/</i>pipeline</p>
      <h2 class="cbs-head__h" id="cbs-pr-t"><?php /* DRAFT COPY */ ?><span class="g">A build pipeline,</span> not a big reveal.</h2>
      <p class="lead cbs-head__lead"><?= e($cbs_pr['lead']) ?> Each phase only closes when its artefacts pass review, the same way code only ships when its checks go green.</p>
    </header>

    <div class="cbs-pr__run" data-cbs-pr>
      <div class="cbs-pr__bar">
        <p class="cbs-pr__id"><span class="cbs-pr__dot" data-cbs-pr-dot></span><b>pipeline</b> brand-system / main</p>
        <p class="cbs-pr__state" role="status" aria-live="polite" data-cbs-pr-state>All <?= $cbs_pr_n ?> stages passed · v1.0 tagged</p>
        <button type="button" class="cbs-btn cbs-pr__again" data-cbs-pr-again>Run again</button>
      </div>

      <ol class="cbs-pr__stages">
        <?php foreach ($cbs_pr['steps'] as $cbs_si => $cbs_s): ?>
          <li class="cbs-pr__stage is-passed" data-cbs-pr-stage>
            <div class="cbs-pr__sh">
              <p class="cbs-pr__sn">stage <?= $cbs_si + 1 ?>/<?= $cbs_pr_n ?></p>
              <span class="cbs-pr__pill" data-cbs-pr-pill>passed</span>
            </div>
            <h3 class="cbs-pr__h"><?= e($cbs_s[0]) ?></h3>
            <p class="cbs-pr__wk"><?= e($cbs_s[1]) ?></p>
            <p class="cbs-pr__d"><?= e($cbs_s[2]) ?></p>
            <ul class="cbs-pr__jobs" aria-label="<?= e($cbs_s[0]) ?> artefacts">
              <?php foreach ($cbs_s[3] as $cbs_ai => $cbs_a): ?>
                <li class="is-passed" data-cbs-pr-job><i aria-hidden="true"></i><span><?= e($cbs_a) ?></span><em><?= $cbs_ai === count($cbs_s[3]) - 1 ? 'reviewed' : 'passed' ?></em></li>
              <?php endforeach; ?>
            </ul>
            <p class="cbs-pr__gate"><?= $cbs_si < $cbs_pr_n - 1 ? 'Gate · sign-off before stage ' . ($cbs_si + 2) : 'Gate · system owner tags the release' ?></p>
          </li>
        <?php endforeach; ?>
      </ol>

      <div class="cbs-pr__log" aria-hidden="true">
        <p class="cbs-pr__lh"><span>run log</span><span class="cbs-note">Illustrative</span></p>
        <ol data-cbs-pr-log>
          <li><b>✓</b> audit · drift report reviewed by brand lead</li>
          <li><b>✓</b> foundations · token set exported to design tools and code</li>
          <li><b>✓</b> extend · flex rules tested on a live campaign</li>
          <li><b>✓</b> run · v1.0 tagged by the system owner</li>
        </ol>
      </div>
    </div>
  </div>
</section>
