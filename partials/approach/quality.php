<?php /* DRAFT COPY — review before launch */
/* Quality — the enforcement mechanics, not the thresholds. The thresholds themselves are on the Work
   page (work.php#craft), and this section links there rather than restating them, so the two can never
   drift. What matters here is where each check runs, who owns it and what happens when it fails, because
   a check that can be waived under pressure is not a check. */
$aprq_checks = [
    ['Tests',          'Every push, in your pipeline',        'Our engineer',              'The build fails. The change does not merge.',            'Unit and contract tests, written with the change'],
    ['Evals',          'Every push that touches an AI path',  'Your QA and eval engineer', 'The merge is blocked until the gate is met again.',      'The golden set, scored against fixed gates'],
    ['Security scans', 'Every push, and nightly on the branch', 'Your security engineer',  'A critical or high finding blocks the release.',         'Static analysis, dependencies, containers, secrets'],
    ['Accessibility',  'Automated on every push, by a person before release', 'Our accessibility reviewer', 'Release is held until the keyboard path works.', 'WCAG 2.2 level AA, keyboard and screen-reader pass'],
    ['Performance',    'Every push, against a budget',        'Our tech lead',             'The budget breach fails the build.',                     'Field-representative devices, not a lab score'],
    ['Content review', 'Before anything with a claim ships',  'Our discipline lead',       'The claim is cut or substantiated. No third option.',    'Every factual claim checked against its source'],
];
$aprq_waiver = [
    ['Who can waive a check', 'Only the named owner of that check, in writing, with an expiry date.'],
    ['What a waiver records', 'What was waived, why, what compensates for it, and when it is reviewed.'],
    ['What cannot be waived', 'The keyboard path, a critical security finding, and a person\'s approval of a merge.'],
    ['Where it is visible',   'In the decision log and in the weekly report, not in a private thread.'],
];
?>
<section class="band band--alt apr-quality" id="quality" aria-labelledby="quality-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Quality</p>
        <h2 class="h2" id="quality-t"><span class="g">A standard is only real</span> if it can fail a build.</h2>
      </div>
      <div>
        <p class="lead">Six checks run on the work, each with an owner and a consequence. They live in your
          pipeline, not ours, so they keep running after we have gone. The thresholds themselves are
          published on the work page.</p>
        <a class="tl" href="<?= xe_url('work.php') ?>#craft">See the thresholds <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <div class="bdh-scroll-x apr-q__scroll" tabindex="0" role="region" aria-label="The six checks and what happens when one fails, scroll sideways on small screens" data-rv>
      <table class="apr-q__t">
        <caption class="bdh-sr">Each check that runs on the work: when it runs, who owns it, what it covers and what happens when it fails.</caption>
        <thead>
          <tr>
            <th scope="col"><span class="apr-k">Check</span></th>
            <th scope="col"><span class="apr-k">When it runs</span></th>
            <th scope="col"><span class="apr-k">What it covers</span></th>
            <th scope="col"><span class="apr-k">Who owns it</span></th>
            <th scope="col"><span class="apr-k">On failure</span></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($aprq_checks as $aprq_c): ?>
            <tr>
              <th scope="row"><?= e($aprq_c[0]) ?></th>
              <td><?= e($aprq_c[1]) ?></td>
              <td><?= e($aprq_c[4]) ?></td>
              <td><span class="apr-who <?= strpos($aprq_c[2], 'Your') === 0 ? 'is-yours' : 'is-ours' ?>"><?= e($aprq_c[2]) ?></span></td>
              <td class="apr-q__fail"><?= e($aprq_c[3]) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="apr-q__waiver" data-rv data-rv-d="80">
      <div class="apr-q__wh">
        <p class="apr-k">When a check has to be waived</p>
        <h3 class="bdh-t bdh-t--l">Sometimes a date wins. It gets written down.</h3>
        <p class="bdh-d">Pretending waivers never happen is how they end up undocumented. Ours have an
          owner, a reason, a compensating control and an expiry, and they appear in the weekly report the
          same week they are signed.</p>
      </div>
      <dl class="apr-defs apr-q__wd">
        <?php foreach ($aprq_waiver as $aprq_w): ?>
          <div><dt><?= e($aprq_w[0]) ?></dt><dd><?= e($aprq_w[1]) ?></dd></div>
        <?php endforeach; ?>
      </dl>
    </div>
  </div>
</section>
