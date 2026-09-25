<?php /* DRAFT COPY — review before launch */
/* Needs — what each of the six disciplines actually needs from you before it can put a number on
   anything, what comes back, and the smallest sensible first step. Six tabs over one panel
   (BDH.tabs in contact.js). Every pane carries its own visible h3, so the <noscript> rule below can
   simply stack all six and drop the tab strip: with JavaScript off the section is complete, not
   blank. "Start here" jumps to the brief and, with JavaScript, opens that discipline's service list.
   PLACEHOLDER: confirm the typical first-step lengths below before launch. */
$ct_nd = [
    'brand-design' => [
        'need' => [
            'The logo files, guidelines and templates you have now — even if they are out of date',
            'Which markets and languages the brand has to work in',
            'What you are unhappy with, in your own words, and who else agrees',
            'Who signs off: one person, a committee, or a board',
        ],
        'back' => [
            'A read on the current system and where it breaks',
            'The scope of an identity or brand-system programme, phased',
            'A schedule that shows what lands when, and what you have to review',
        ],
        'step' => ['Brand diagnostic', '2–3 weeks', 'A written view of the current brand, the gaps, and the shortest route to fixing them.'],
    ],
    'technology-intelligence' => [
        'need' => [
            'The stack and where it runs — cloud, region, who has access',
            'Traffic, data volumes and the peaks you actually care about',
            'Who maintains it today, in-house or an agency',
            'Any security, residency or compliance regime it has to satisfy',
        ],
        'back' => [
            'Two or three architecture options with the trade-off stated plainly',
            'A delivery plan with gates you approve one at a time',
            'A price range per phase, not one number for the whole thing',
        ],
        'step' => ['Technical audit or a one-week spike', '1–2 weeks', 'Either a written assessment of what exists, or working code that proves the risky part is possible.'],
    ],
    'campaign-content' => [
        'need' => [
            'The markets, channels and the date you have to hit',
            'How the media budget splits, and who buys it today',
            'Existing assets, and who owns the rights to them',
            'What counts as success: reach, response, or something further down',
        ],
        'back' => [
            'The shape of the campaign and the idea it hangs on',
            'A production plan with volumes, formats and localisation',
            'A measurement plan agreed before anything is made',
        ],
        'step' => ['Messaging and channel sprint', '2–3 weeks', 'The story, the channel plan and a test matrix, ready to produce against.'],
    ],
    'ai-design' => [
        'need' => [
            'The task you want a model to do, described as a person doing it',
            'Twenty real examples of that task done well, if you have them',
            'Where the data lives and what may not leave your network',
            'Who approves an output before a customer sees it',
        ],
        'back' => [
            'An honest feasibility read, including when the answer is "not with today\'s models"',
            'An eval plan: the cases, the scoring and the bar to pass',
            'A prototype scope with a go or stop decision at the end',
        ],
        'step' => ['Prototype with an eval baseline', '2–4 weeks', 'A working prototype on masked copies of your data, scored against a golden set.'],
    ],
    'product-experience' => [
        'need' => [
            'Who uses it, and what they do instead today',
            'Any analytics, session recordings or research already sitting on a drive',
            'The release cadence the team works to',
            'The constraints that are not negotiable — platform, tech, regulation',
        ],
        'back' => [
            'The problem framed as something testable',
            'A design scope with the artefacts named',
            'A validation plan: what would prove it worked before the build',
        ],
        'step' => ['Discovery sprint', '2–4 weeks', 'Research, a framed problem and a prototype worth testing with real users.'],
    ],
    'marketing-technology' => [
        'need' => [
            'The platforms already in place — CRM, CDP, email, analytics, tag management',
            'Where customer data comes from and who owns each source',
            'Your consent and data-protection position by market',
            'The team who will run it after we hand it over',
        ],
        'back' => [
            'A target architecture, with what to keep and what to retire',
            'An implementation plan sequenced by the value it unlocks',
            'A run model: who does what, monthly, once it is live',
        ],
        'step' => ['Martech audit', '2–3 weeks', 'What you own, what it costs, what it does not do, and the order to fix it in.'],
    ],
];
$ct_nd_list = [];
foreach ($SITE['disciplines'] as $ct_d2) {
    if (isset($ct_nd[$ct_d2['slug']])) $ct_nd_list[] = ['d' => $ct_d2] + $ct_nd[$ct_d2['slug']];
}
?>
<noscript><style>
.ct-needs__tabs{display:none}
.ct-needs .bdh-panes{display:block}
.ct-needs .bdh-pane{opacity:1;visibility:visible;transform:none}
.ct-needs .bdh-pane+.bdh-pane{margin-top:var(--bdh-block)}
</style></noscript>
<section class="band band--alt ct-needs" id="needs" aria-labelledby="needs-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row ct-needs__head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Before we can price it</p>
        <h2 class="h2" id="needs-t"><span class="g">What each discipline</span> needs from you.</h2>
      </div>
      <div>
        <p class="lead">A quote is only as honest as the brief under it. These are the things that, missing, turn a price into a guess — and the smallest first step when you cannot answer them yet.</p>
      </div>
    </div>

    <div class="ct-needs__tabs bdh-tabs" role="tablist" aria-label="Disciplines" data-ct-ndtabs>
      <?php foreach ($ct_nd_list as $ct_i => $ct_n): ?>
        <button type="button" role="tab" id="nd-t<?= $ct_i ?>" aria-controls="nd-p<?= $ct_i ?>" aria-selected="<?= $ct_i === 0 ? 'true' : 'false' ?>"<?= $ct_i === 0 ? '' : ' tabindex="-1"' ?>>
          <span class="ct-needs__tn"><?= e($ct_n['d']['n']) ?></span><?= e($ct_n['d']['short']) ?>
        </button>
      <?php endforeach; ?>
    </div>

    <div class="bdh-panes ct-needs__panes" data-ct-ndpanes>
      <?php foreach ($ct_nd_list as $ct_i => $ct_n): ?>
        <div class="bdh-pane ct-nd<?= $ct_i === 0 ? ' is-on' : '' ?>" id="nd-p<?= $ct_i ?>" role="tabpanel" aria-labelledby="nd-t<?= $ct_i ?>"<?= $ct_i === 0 ? '' : ' tabindex="0"' ?>>
          <div class="ct-nd__head">
            <p class="ct-nd__idx"><?= e($ct_n['d']['n']) ?></p>
            <h3 class="ct-nd__t"><?= e($ct_n['d']['name']) ?></h3>
            <p class="ct-nd__lead"><?= e($ct_n['d']['intro']) ?></p>
            <a class="tl ct-nd__link" href="<?= e(xe_discipline_url($ct_n['d'])) ?>">Read the <?= e($ct_n['d']['short']) ?> page <span class="i" aria-hidden="true">›</span></a>
          </div>

          <div class="ct-nd__cols">
            <div class="ct-nd__col">
              <p class="ct-nd__k"><span class="ct-nd__ki" aria-hidden="true"><?= xt_icon('clipboard-check', ['size' => 16]) ?></span>Tell us</p>
              <ul class="ct-nd__l">
                <?php foreach ($ct_n['need'] as $ct_x): ?><li><?= e($ct_x) ?></li><?php endforeach; ?>
              </ul>
            </div>
            <div class="ct-nd__col">
              <p class="ct-nd__k"><span class="ct-nd__ki" aria-hidden="true"><?= xt_icon('doc', ['size' => 16]) ?></span>You get back</p>
              <ul class="ct-nd__l ct-nd__l--back">
                <?php foreach ($ct_n['back'] as $ct_x): ?><li><?= e($ct_x) ?></li><?php endforeach; ?>
              </ul>
            </div>
            <div class="ct-nd__col ct-nd__col--step">
              <p class="ct-nd__k"><span class="ct-nd__ki" aria-hidden="true"><?= xt_icon('bolt', ['size' => 16]) ?></span>If you cannot answer those yet</p>
              <div class="ct-nd__step">
                <p class="ct-nd__sn"><?= e($ct_n['step'][0]) ?></p>
                <p class="ct-nd__sl"><?= e($ct_n['step'][1]) ?></p>
                <p class="ct-nd__sd"><?= e($ct_n['step'][2]) ?></p>
              </div>
              <a class="btn btn--out ct-nd__go" href="#brief" data-ct-jump="<?= e($ct_n['d']['slug']) ?>">Start a <?= e($ct_n['d']['short']) ?> brief <span class="i" aria-hidden="true">›</span></a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
