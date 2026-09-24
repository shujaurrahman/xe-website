<?php /* DRAFT COPY — review before launch */
/* PLACEHOLDER: every benefit and every tool below is a draft — confirm the actual package and tool licences with HR and IT before launch. */
$car_tools = ['anthropic', 'openai', 'googlegemini', 'githubcopilot', 'cursor', 'figma', 'langgraph', 'notion', 'linear', 'github'];
$car_rules = [
  ['key', 'A seat, not a shared login', 'Your own licences from day one, paid by us.'],
  ['lock', 'Client data stays in approved workspaces', 'Zero-retention enterprise accounts only. No client material in personal tools.'],
  ['eval', 'Evals before trust', 'Anything you automate runs against a test set, and the results are logged.'],
  ['approve', 'A human signs off', 'Agents draft and check. People approve what reaches a client.'],
];
$car_ben = [
  ['Health cover', 'Medical insurance for you and your family.'],
  ['Time off', 'Paid leave, public holidays and a winter break.'],
  ['Learning budget', 'An annual budget for courses, books and conferences.'],
  ['Home setup', 'A laptop of your choice and a home-office allowance.'],
  ['Parental leave', 'Paid leave for every new parent.'],
  ['Growth reviews', 'Twice-yearly reviews against a published career framework.'],
  ['Team weeks', 'The whole company together, in person, twice a year.'],
];
?>
<section class="band band--ink car-ben" id="benefits" aria-labelledby="benefits-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Tooling and benefits</p>
        <h2 class="h2" id="benefits-t"><span class="g">The tools on day one,</span> and the rules that come with them.</h2></div>
      <div><p class="p">A draft of the package we intend to offer. Final tools and benefits are confirmed in every offer letter.</p></div>
    </div>
    <!-- PLACEHOLDER: confirm tool licences and benefits before launch -->
    <div class="car-ben__g">
      <div class="car-kit">
        <p class="car-kit__k">Your AI workspace</p>
        <?= xt_stack($car_tools, ['variant' => 'chips', 'label' => 'Tools provided to every hire']) ?>
        <ul class="car-kit__rules">
          <?php foreach ($car_rules as $car_r): ?>
          <li><?= xt_icon($car_r[0]) ?><div><h3 class="car-kit__t"><?= e($car_r[1]) ?></h3><p class="car-kit__p"><?= e($car_r[2]) ?></p></div></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="car-pk">
        <p class="car-kit__k">Everything else</p>
        <dl class="car-pk__dl">
          <?php foreach ($car_ben as $car_b): ?>
          <div><dt><?= e($car_b[0]) ?></dt><dd><?= e($car_b[1]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
      </div>
    </div>
  </div>
</section>
