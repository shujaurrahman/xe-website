<?php /* DRAFT COPY — review before launch */
/* Proving — SIGNATURE. The Proving Ground: pick one of five bets a product team actually faces
   (a listbox: arrows move and select, Home/End jump, Enter/Space confirm) and the panel lays out the
   four rungs of proof it has to climb before it earns engineering — what each rung is, at what
   fidelity, how long it takes, who is in the room, and the written condition that passes or fails it.
   Under that, the arithmetic that makes the argument: days to prove against days to build, and the
   cheapest place to stop.
   All five plans are in the markup (plan 1 shown); proving.js switches them, runs the rungs in order
   and updates the live summary. Reduced motion: instant switching, no run.
   PLACEHOLDER: every duration, team shape and effort figure below is a typical range for work of this
   shape, not a quote — confirm before launch. */
$prv_bets = [
    [
        'slug'  => 'ai-assistant',
        'title' => 'Put an AI assistant in the product',
        'icon'  => 'sparkle',
        'stake' => 'A quarter of engineering, plus the model cost of every answer it ever gives.',
        'assume'=> 'People will trust an answer enough to act on it without going to check the source.',
        'build' => 60,   // typical working days to build it
        'rungs' => [
            ['Read the journey', 'Desk', 3, 'Product designer · your support lead',
             'There are tasks where AI removes real effort.',
             'Every candidate turns out to be a search box with a nicer label.'],
            ['Wizard-of-Oz test', 'Paper', 4, 'Researcher · 6 participants',
             'People act on the answer, and say what would make them check it.',
             'They read it, then go and do the task the old way anyway.'],
            ['Prototype on a live model', 'Coded', 10, 'Designer · AI engineer · 8 participants',
             'The answer is right often enough on your own content, and people notice when it is not.',
             'They accept a wrong answer without noticing it was wrong.'],
            ['Pilot behind a flag', 'Pilot', 15, 'Squad · your support team · 5% of users',
             'Week-four use holds, corrections are rare, and escalation to a person works.',
             'Use collapses once the launch spike passes.'],
        ],
        'caps'     => ['ai-product-strategy-development', 'experience-design-development'],
        'services' => ['ai-opportunity', 'ai-prototype'],
    ],
    [
        'slug'  => 'onboarding',
        'title' => 'Rebuild the onboarding journey',
        'icon'  => 'browser',
        'stake' => 'Ten to twenty weeks, and the risk of replacing a journey that currently pays the bills.',
        'assume'=> 'People drop out because of the form, not because of the price.',
        'build' => 75,
        'rungs' => [
            ['Read the funnel', 'Desk', 3, 'Designer · analyst · your own analytics',
             'The drop-off concentrates in steps you can actually change.',
             'It is spread evenly, which usually means the offer rather than the interface.'],
            ['Five sessions on the live journey', 'Live product', 4, 'Researcher · 5–8 participants',
             'The same barrier appears in most sessions.',
             'Every participant stops somewhere different.'],
            ['Two prototypes, side by side', 'Clickable', 8, 'Designer · researcher · 8 participants',
             'Task success and time on task beat the baseline you measured first.',
             'The new flow tests no better than the one you already have.'],
            ['One journey behind a flag', 'Pilot', 15, 'Squad · your engineers · staged rollout',
             'The benchmark repeats in the field and conversion holds.',
             'The result from the lab does not survive real traffic.'],
        ],
        'caps'     => ['experience-design-development', 'design-consulting-solutioning'],
        'services' => ['app-redesign', 'user-research'],
    ],
    [
        'slug'  => 'self-serve',
        'title' => 'Launch a self-serve tier',
        'icon'  => 'cost',
        'stake' => 'A new tier, a new signup, a new support load, and a sales team that has to be told.',
        'assume'=> 'Buyers will configure and pay for it themselves rather than ask for a call.',
        'build' => 100,
        'rungs' => [
            ['Win–loss and support read', 'Desk', 3, 'Strategist · analyst · your own records',
             'There is a segment that asks to buy without help.',
             'Every deal needed a person, and the reason is the product rather than the funnel.'],
            ['Concept test with that segment', 'Paper', 5, 'Strategist · researcher · 10 participants',
             'One packaging option is chosen for the same reasons by most participants.',
             'Preference splits and nobody can say why.'],
            ['Coded signup on a payment sandbox', 'Coded', 10, 'Designer · front-end engineer · 12 participants',
             'People complete a self-serve purchase unaided.',
             'They reach the plan picker and stop.'],
            ['Open it in one market', 'Pilot', 20, 'Squad · your revenue team · one region',
             'Self-serve revenue arrives without displacing assisted deals.',
             'It takes revenue from the assisted funnel instead of adding to it.'],
        ],
        'caps'     => ['product-strategy-vision', 'experience-design-development'],
        'services' => ['product-discovery', 'vision-prototype'],
    ],
    [
        'slug'  => 'design-system',
        'title' => 'Replace five front ends with one design system',
        'icon'  => 'cube',
        'stake' => 'Two to four quarters of platform work, spread across every product team you have.',
        'assume'=> 'Teams will adopt it rather than route around it.',
        'build' => 160,
        'rungs' => [
            ['Interface inventory', 'Desk', 5, 'Designer · front-end engineer',
             'The same component exists four or more times, with differences nobody chose.',
             'The variation is deliberate, and the products really are that different.'],
            ['Interview the consuming teams', 'Paper', 4, 'Systems lead · researcher · 6 teams',
             'Teams name the same missing components and would consume them.',
             'They will not give up control of their own components, and say why.'],
            ['One pilot component, end to end', 'Coded', 10, 'Designer · engineer · one pilot team',
             'The pilot team ships a screen with it and the accessibility tests pass in their own CI.',
             'Using it takes them longer than writing their own did.'],
            ['Migrate the pilot product', 'Pilot', 20, 'Systems team · the pilot team · one release',
             'Adoption is measurable and the team asks for the next components.',
             'Adoption stalls the moment hands-on support stops.'],
        ],
        'caps'     => ['system-design', 'design-consulting-solutioning'],
        'services' => ['design-system-build', 'design-tokens'],
    ],
    [
        'slug'  => 'mobile-app',
        'title' => 'Ship a mobile app',
        'icon'  => 'mobile',
        'stake' => 'Two platforms, two release processes, and a second product to keep current for years.',
        'assume'=> 'The job people do on a phone is the same job they do at a desk.',
        'build' => 120,
        'rungs' => [
            ['Read the mobile evidence', 'Desk', 3, 'Designer · analyst · analytics by device',
             'There is a distinct mobile job, in distinct moments.',
             'Mobile traffic is doing the desktop job badly, which a responsive fix answers far cheaper.'],
            ['Diary study with mobile users', 'Field', 7, 'Researcher · 8 participants · one week',
             'The job happens away from a desk, in short bursts, sometimes offline.',
             'People only reach for the phone when a laptop is not nearby.'],
            ['Prototype the one moment that matters', 'Coded', 10, 'Designer · mobile engineer · 8 participants',
             'That moment measurably works better native than in a browser.',
             'A responsive web page does the same job just as well.'],
            ['Closed beta', 'Pilot', 20, 'Squad · your support team · internal track',
             'Week-four retention beats the mobile web baseline.',
             'People install it once and go back to the browser.'],
        ],
        'caps'     => ['product-strategy-vision', 'experience-design-development'],
        'services' => ['product-discovery', 'ux-ui-design'],
    ],
];
/* the fidelity ladder, in the order a proof climbs it */
$prv_fid  = ['Desk' => 1, 'Paper' => 2, 'Field' => 2, 'Live product' => 2, 'Clickable' => 3, 'Coded' => 3, 'Pilot' => 4];
$prv_days = fn (array $prv_b): int => array_sum(array_map(fn ($prv_r) => $prv_r[2], $prv_b['rungs']));
$prv_cheap = fn (array $prv_b): int => $prv_b['rungs'][0][2] + $prv_b['rungs'][1][2];
$prv_url = fn (array $prv_b): string => svc_contact_url(
    array_map(fn ($prv_k) => 'product-experience:' . $prv_k, array_values(array_filter($prv_b['services'], fn ($prv_k) => (bool) svc_find('product-experience:' . $prv_k)))),
    null,
    'product-experience'
);
$prv_sum = fn (array $prv_b): string => $prv_b['title'] . ' · 4 rungs · ' . $prv_days($prv_b) . ' days to prove against about ' . $prv_b['build'] . ' days to build';
$prv_name = fn (string $prv_s): array => [$CAPS[$prv_s]['n'], $CAPS[$prv_s]['short']];
?>
<section class="band pxh-proving" id="proving" aria-labelledby="proving-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The Proving Ground</p>
        <h2 class="h2" id="proving-t"><span class="g">Pick a bet.</span> See the cheapest thing that could break it.</h2>
      </div>
      <div>
        <p class="lead">Choose one of the bets product teams bring us and the Proving Ground lays out the four rungs it has to climb: what each one tests, at what fidelity, how long it takes, and the written condition that lets it pass or sends it back. Then the arithmetic — days to prove against days to build.</p>
      </div>
    </div>

    <div class="pxh-panel pxh-prov" data-bet="0" data-rv data-rv-d="60" data-bdh-live>
      <div class="pxh-panel__bar">
        <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="pxh-panel__name">Proving Ground <i>/</i> your product <i>/</i> draft proof plan</span>
        <span class="pxh-panel__pill pxh-prov__state"><i class="bdh-pulse" aria-hidden="true"></i><span class="pxh-prov__stxt">Proof plan ready</span></span>
        <span class="pxh-panel__ill">Typical ranges</span>
      </div>

      <div class="pxh-prov__body">
        <div class="pxh-prov__rail">
          <p class="pxh-k pxh-prov__rk">Open bets<span><?= count($prv_bets) ?></span></p>
          <div class="pxh-prov__list" role="listbox" aria-label="Open bets" aria-describedby="proving-hint">
            <?php foreach ($prv_bets as $prv_i => $prv_b): ?>
              <button class="pxh-prov__opt" type="button" role="option" id="proving-o<?= $prv_i ?>"
                      aria-selected="<?= $prv_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $prv_i === 0 ? '0' : '-1' ?>" data-bet="<?= $prv_i ?>">
                <span class="pxh-prov__oi" aria-hidden="true"><?= xt_icon($prv_b['icon'], ['size' => 20]) ?></span>
                <span class="pxh-prov__ot"><?= e($prv_b['title']) ?></span>
                <span class="pxh-prov__om"><b><?= $prv_days($prv_b) ?> d</b> to prove · <b><?= $prv_b['build'] ?> d</b> to build</span>
              </button>
            <?php endforeach; ?>
          </div>
          <p class="pxh-prov__hint" id="proving-hint"><span class="pxh-kbd">↑</span><span class="pxh-kbd">↓</span> to change bet · <span class="pxh-kbd">Home</span> / <span class="pxh-kbd">End</span> to jump</p>
          <p class="bdh-sr pxh-prov__live" aria-live="polite">Proof plan: <?= e($prv_sum($prv_bets[0])) ?></p>

          <div class="pxh-prov__fid">
            <p class="pxh-k">The fidelity ladder</p>
            <ol>
              <?php foreach ([
                  ['Desk', 1, 'Evidence you already own'],
                  ['Paper · field', 2, 'Sketches, sessions, a human behind the curtain'],
                  ['Coded', 3, 'A working prototype on real content'],
                  ['Pilot', 4, 'Production, behind a flag, for some of the traffic'],
              ] as $prv_f): ?>
                <li>
                  <span class="pxh-prov__rsteps" aria-hidden="true"><?php for ($prv_s = 1; $prv_s <= 4; $prv_s++): ?><i<?= $prv_s <= $prv_f[1] ? ' class="is-on"' : '' ?>></i><?php endfor; ?></span>
                  <b><?= e($prv_f[0]) ?></b>
                  <span><?= e($prv_f[2]) ?></span>
                </li>
              <?php endforeach; ?>
            </ol>
          </div>
          <p class="pxh-note pxh-prov__rn">Days are working days for a team of this shape, not a quote. Every proof plan is scoped with your team before it starts.</p>
        </div>

        <div class="pxh-prov__panes bdh-panes">
          <?php foreach ($prv_bets as $prv_i => $prv_b):
              $prv_tot = $prv_days($prv_b);
              $prv_run = 0; ?>
            <div class="bdh-pane pxh-prov__pane<?= $prv_i === 0 ? ' is-on' : '' ?>" data-pane="<?= $prv_i ?>" data-summary="<?= e($prv_sum($prv_b)) ?>">
              <div class="pxh-prov__ph">
                <div>
                  <p class="pxh-k">Bet <?= $prv_i + 1 ?> of <?= count($prv_bets) ?></p>
                  <h3 class="pxh-prov__pt"><?= e($prv_b['title']) ?></h3>
                  <p class="pxh-prov__pa"><span class="pxh-k pxh-k--blue">The assumption it rests on</span><?= e($prv_b['assume']) ?></p>
                </div>
                <dl class="pxh-prov__pm">
                  <div><dt>At stake</dt><dd><?= e($prv_b['stake']) ?></dd></div>
                  <div><dt>Rungs</dt><dd><?= count($prv_b['rungs']) ?></dd></div>
                </dl>
              </div>

              <ol class="pxh-prov__rungs">
                <?php foreach ($prv_b['rungs'] as $prv_ri => $prv_r): $prv_run += $prv_r[2]; ?>
                  <li class="pxh-prov__rung" style="--i:<?= $prv_ri ?>" data-rung="<?= $prv_ri ?>">
                    <span class="pxh-prov__rn2"><?= sprintf('R%d', $prv_ri + 1) ?></span>
                    <span class="pxh-prov__rmain">
                      <span class="pxh-prov__rt"><?= e($prv_r[0]) ?></span>
                      <span class="pxh-prov__rwho"><?= e($prv_r[3]) ?></span>
                      <span class="pxh-prov__rc">
                        <span class="is-pass"><b>Passes if</b><?= e($prv_r[4]) ?></span>
                        <span class="is-fail"><b>Sent back if</b><?= e($prv_r[5]) ?></span>
                      </span>
                    </span>
                    <span class="pxh-prov__rfid" aria-hidden="true">
                      <span class="pxh-prov__rfl"><?= e($prv_r[1]) ?></span>
                      <span class="pxh-prov__rsteps">
                        <?php for ($prv_s = 1; $prv_s <= 4; $prv_s++): ?><i<?= $prv_s <= ($prv_fid[$prv_r[1]] ?? 1) ? ' class="is-on"' : '' ?>></i><?php endfor; ?>
                      </span>
                    </span>
                    <span class="pxh-prov__rd">
                      <b><?= $prv_r[2] ?></b> days
                      <span class="pxh-prov__rcum">by day <?= $prv_run ?></span>
                    </span>
                  </li>
                <?php endforeach; ?>
              </ol>

              <div class="pxh-prov__verdict">
                <div class="pxh-prov__vsum">
                  <p class="pxh-k">The arithmetic</p>
                  <p class="pxh-prov__vh">Stop at rung 2 and you have spent <b><?= $prv_cheap($prv_b) ?> days</b>, not <b><?= $prv_b['build'] ?></b>.</p>
                  <p class="pxh-prov__vd">Climbing all four rungs costs about <?= $prv_tot ?> working days — roughly <?= (int) round($prv_tot / $prv_b['build'] * 100) ?> per cent of the build it protects. Most bets are settled long before rung 4.</p>
                </div>
                <div class="pxh-bars pxh-prov__vbars">
                  <div class="pxh-bar">
                    <span class="pxh-bar__n">Days to prove it, all four rungs</span>
                    <span class="pxh-bar__v"><?= $prv_tot ?> d</span>
                    <span class="pxh-bar__track"><i class="pxh-bar__fill" style="--p:<?= round($prv_tot / $prv_b['build'] * 100, 1) ?>"></i></span>
                  </div>
                  <div class="pxh-bar">
                    <span class="pxh-bar__n">Days to build it, if the bet is right</span>
                    <span class="pxh-bar__v"><?= $prv_b['build'] ?> d</span>
                    <span class="pxh-bar__track"><i class="pxh-bar__fill pxh-bar__fill--quiet" style="--p:100;--i:1"></i></span>
                  </div>
                  <div class="pxh-bar">
                    <span class="pxh-bar__n">Cheapest place to find out you are wrong</span>
                    <span class="pxh-bar__v">day <?= $prv_cheap($prv_b) ?></span>
                    <span class="pxh-bar__track"><i class="pxh-bar__fill" style="--p:<?= round($prv_cheap($prv_b) / $prv_b['build'] * 100, 1) ?>;--i:2"></i></span>
                  </div>
                </div>
              </div>

              <div class="pxh-prov__foot">
                <p class="pxh-prov__fc"><span class="pxh-k">Capabilities involved</span><?php foreach ($prv_b['caps'] as $prv_c): [$prv_n, $prv_sh] = $prv_name($prv_c); ?><a class="pxh-capl" href="#<?= e($prv_c) ?>"><b><?= e($prv_n) ?></b><span><?= e($prv_sh) ?></span><i aria-hidden="true">›</i></a><?php endforeach; ?></p>
                <a class="btn btn--ink btn--sm" href="<?= e($prv_url($prv_b)) ?>">Scope this proof with us <span class="i" aria-hidden="true">›</span><span class="bdh-sr">: <?= e($prv_b['title']) ?></span></a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <p class="pxh-note pxh-prov__note">The rungs are ordered by what they cost, not by how convincing they look. A bet that survives all four is worth building; one that fails at rung 2 has saved you the other three, and that is the whole argument for putting design ahead of the build.</p>
  </div>
</section>
