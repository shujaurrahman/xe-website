<?php /* DRAFT COPY — review before launch */
/* Stack — the tools the loop runs on, grouped by the stage they serve. Technologies we work with, not partnerships. */
$pxh_stk = [
    ['01', 'Research & strategy', 'Evidence, journeys and decisions in one place.', ['figma', 'miro', 'notion', 'confluence', 'jira', 'linear']],
    ['02', 'Design & build', 'One library in design and in code.', ['storybook', 'react', 'nextdotjs', 'typescript', 'tailwindcss', 'swift', 'kotlin', 'github', 'githubactions']],
    ['03', 'Test & measure', 'Usability, accessibility, performance and behaviour.', ['playwright', 'cypress', 'jest', 'lighthouse', 'posthog', 'mixpanel', 'googleanalytics', 'looker']],
    ['04', 'AI features', 'Model-agnostic, chosen per task on evals.', ['anthropic', 'openai', 'googlegemini', 'langgraph', 'llamaindex', 'python']],
];
?>
<section class="band pxh-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>The stack</p>
        <h2 class="h2" id="stack-t"><span class="g">Your tools, where they work.</span> Ours where they don’t exist yet.</h2></div>
      <div><p class="lead">We work inside the tools your teams already use and hand everything over in them. These are the technologies we work with most across research, design, build and measurement.</p></div>
    </div>
    <div class="pxh-stack__rows">
      <?php foreach ($pxh_stk as $pxh_r): ?>
      <div class="pxh-stack__row" data-rv>
        <div class="pxh-stack__k"><span class="pxh-card__idx"><?= e($pxh_r[0]) ?></span><h3 class="h3"><?= e($pxh_r[1]) ?></h3><p class="sm"><?= e($pxh_r[2]) ?></p></div>
        <?= xt_stack($pxh_r[3], ['variant' => 'tiles', 'label' => $pxh_r[1] . ' technologies']) ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
