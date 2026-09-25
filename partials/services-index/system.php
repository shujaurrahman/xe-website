<?php /* DRAFT COPY — review before launch */
/* How the disciplines connect: a relay in the order work usually moves, each stage naming what it
   takes in and what it hands on, above the one foundation every stage reads from and writes to. */
$SVX_FLOW = [
    'brand-design'            => ['Decides who the brand is.',          'A business goal and an audience.',         'Positioning, identity and brand tokens.'],
    'product-experience'      => ['Turns it into something people use.', 'Brand tokens and customer problems.',     'Validated flows, a design system, specs.'],
    'technology-intelligence' => ['Builds it to run for years.',         'Specs, design system, data needs.',       'Shipped software, data platforms, secured infrastructure.'],
    'ai-design'               => ['Puts intelligence to work inside it.', 'Platforms, data and brand rules.',        'Agents, copilots and guardrailed AI tools.'],
    'campaign-content'        => ['Takes it to market.',                 'A product worth launching, on-brand tools.', 'Campaigns, content and earned attention.'],
    'marketing-technology'    => ['Measures and compounds it.',          'Campaign traffic and customer data.',     'Automation, lead flow and what to change next.'],
];
$svx_by = array_column($SITE['disciplines'], null, 'slug');
$svx_i = 0;
?>
<section class="band band--ink svx-sys" id="system" aria-labelledby="system-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div><p class="lbl"><span class="dot"></span>One system</p>
        <h2 class="h2" id="system-t"><span class="g">Six teams would hand off.</span> One system hands on.</h2></div>
      <div><p class="lead">Most programmes break at the seams — the brand guide nobody codes, the product nobody can market. Here each discipline takes in what the last one produced and passes on something the next can use directly.</p></div>
    </div>

    <ol class="svx-relay">
      <?php foreach ($SVX_FLOW as $svx_slug => $svx_f): if (!isset($svx_by[$svx_slug])) continue; $svx_d = $svx_by[$svx_slug]; $svx_i++; ?>
        <li class="svx-relay__s">
          <span class="svx-relay__node" aria-hidden="true"><?= sprintf('%02d', $svx_i) ?></span>
          <p class="svx-relay__k"><?= e($svx_d['short']) ?></p>
          <h3 class="svx-relay__t"><a href="<?= e(xe_discipline_url($svx_d)) ?>"><?= e($svx_d['name']) ?></a></h3>
          <p class="svx-relay__w"><?= e($svx_f[0]) ?></p>
          <dl class="svx-relay__io">
            <div><dt>Takes in</dt><dd><?= e($svx_f[1]) ?></dd></div>
            <div><dt>Hands on</dt><dd><?= e($svx_f[2]) ?></dd></div>
          </dl>
        </li>
      <?php endforeach; ?>
    </ol>
    <p class="svx-relay__loop"><?= xt_icon('sync') ?><span>Marketing Technology's results feed the next round of Brand Design strategy — the relay is a loop, not a line.</span></p>

    <div class="svx-core">
      <div class="svx-core__h">
        <p class="svx-core__k">The shared foundation</p>
        <p class="svx-core__t">Every stage reads from and writes to the same four things.</p>
      </div>
      <ul class="svx-core__list">
        <li><?= xt_icon('layers') ?><b>Brand tokens</b><span>Colour, type and voice rules as data — used by design files, code and AI prompts alike.</span></li>
        <li><?= xt_icon('database') ?><b>One data model</b><span>Customer, content and event definitions agreed once, not per team.</span></li>
        <li><?= xt_icon('eval') ?><b>Eval suites</b><span>Every AI feature is tested against written criteria before release and after each change.</span></li>
        <li><?= xt_icon('log') ?><b>Decision log</b><span>Approvals, trade-offs and agent actions recorded, so anyone can see why something shipped.</span></li>
      </ul>
    </div>
  </div>
</section>
