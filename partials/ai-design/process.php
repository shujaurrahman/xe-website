<?php /* DRAFT COPY — review before launch */
/* Process — the stepper (.aih-steps / .aih-step, promoted in assets/css/ai-design.css so the capability
   subpages can reuse it with their own stages). Complete and readable in the shipped HTML: every stage,
   its timing, its outputs and what stops it are all on the page. process.js only walks a highlight along
   the rail while the section is on screen, and stops the moment the reader touches anything.
 *
 * PLACEHOLDER: every timing is typical for this discipline, not promised. Confirm before launch.
 */
$pc_steps = [
    [
        'n'    => '01',
        'name' => 'Frame',
        'wk'   => 'Wk 01–03',
        'text' => 'What is worth doing, what the system may see and what it may do. Failure modes are named before features, and the numbers we will be judged on are measured before anything changes.',
        'out'  => ['Experience brief', 'Capability & risk map', 'Baseline measures'],
        'lead' => 'ai-strategy-consulting',
        'risk' => 'Skipped, and the pilot has nothing to be compared against.',
    ],
    [
        'n'    => '02',
        'name' => 'Direct',
        'wk'   => 'Wk 02–06',
        'text' => 'Art direction, conversation scripts, the training set and the scoring set. The rules the output has to hold are written down while there is still time for them to change the work.',
        'out'  => ['Creative direction', 'Prompt & scoring set', 'Rights position'],
        'lead' => 'ai-content-studio',
        'risk' => 'Skipped, and the output settles into a model’s default look.',
    ],
    [
        'n'    => '03',
        'name' => 'Build',
        'wk'   => 'Wk 04–10',
        'text' => 'A prototype on a live model, an adapter tuned on your own material, the pipeline wired and the interface built in your design system rather than around it.',
        'out'  => ['Live prototype', 'Tuned model or studio', 'Production pipeline'],
        'lead' => 'ai-application-design',
        'risk' => 'Built on a static mock, and nobody learns how it actually feels.',
    ],
    [
        'n'    => '04',
        'name' => 'Prove',
        'wk'   => 'Wk 08–14',
        'text' => 'Every version scored, real users on real prompts including the awkward ones, the misuse suites run, and a go or no-go decision argued from the numbers either way.',
        'out'  => ['Score report', 'Usability findings', 'Red-team report', 'Decision record'],
        'lead' => 'brand-ai-tools',
        'risk' => 'Left out, and the release decision becomes a matter of taste.',
    ],
    [
        'n'    => '05',
        'name' => 'Embed',
        'wk'   => 'Wk 14+',
        'text' => 'Served, staffed and reviewed: the approval queue, the training, the playbooks, and the weights, prompts, datasets and logs handed into your own accounts.',
        'out'  => ['Served model & studio', 'Playbooks & training', 'Quarterly review'],
        'lead' => 'ai-strategy-consulting',
        'risk' => 'Left out, and the new way of working quietly lapses.',
    ],
];
?>
<section class="band aih-pc" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>How the work runs</p>
        <h2 class="h2" id="process-t"><span class="g">Five stages,</span> and the one everybody skips.</h2>
      </div>
      <div>
        <p class="lead">The shape is the same whether the engagement is a two-week concept sprint or a year-long programme; only the weeks change. Stage 01 and stage 05 are the ones that get cut for time, and they are the two that decide whether any of it holds.</p>
        <p class="aih-note">Timings are typical for this discipline, not a commitment. Each capability runs its own version of these stages.</p>
      </div>
    </div>

    <div class="aih-pc__wrap" data-rv data-rv-d="50">
      <ol class="aih-steps aih-pc__steps">
        <?php foreach ($pc_steps as $pc_i => $pc_s): ?>
          <li class="aih-step aih-pc__step<?= $pc_i === 0 ? ' is-on' : '' ?>">
            <span class="aih-step__n"><?= e($pc_s['n']) ?> · <?= e($pc_s['wk']) ?></span>
            <h3 class="aih-step__t"><?= e($pc_s['name']) ?></h3>
            <p class="aih-step__d"><?= e($pc_s['text']) ?></p>
            <ul class="aih-step__o">
              <?php foreach ($pc_s['out'] as $pc_o): ?><li><?= e($pc_o) ?></li><?php endforeach; ?>
            </ul>
            <p class="aih-pc__risk"><?= e($pc_s['risk']) ?></p>
            <a class="aih-caplink aih-pc__lead" href="#<?= e($pc_s['lead']) ?>"><b>Leads</b><span><?= e($CAPS[$pc_s['lead']]['short']) ?></span><i aria-hidden="true">›</i></a>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <div class="aih-pc__foot">
      <p class="aih-pc__fk aih-k">Whichever way you start</p>
      <ul class="aih-pc__ways">
        <li><b>Two weeks</b> Three concepts, each demoed on a real model rather than shown on a slide.</li>
        <li><b>Six weeks</b> A diagnostic with your own numbers, and a sequenced plan you can defend.</li>
        <li><b>A quarter</b> One workflow run the new way by a real team, measured against its baseline.</li>
      </ul>
      <a class="btn btn--out aih-pc__cta" href="#services">See what that costs to buy <span class="i" aria-hidden="true">›</span></a>
    </div>
  </div>
</section>
