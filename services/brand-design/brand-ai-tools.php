<?php
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';
$BD  = require __DIR__ . '/../../data/brand-design.php';
$cap = $BD['brand-ai-tools'];

$page = [
    'key'   => 'services',
    'title' => $cap['name'] . ' · Brand Design',
    'desc'  => $cap['lead'],
    'css'   => ['assets/css/brand.css', 'assets/css/brand/brand-ai-tools.css'],
    'js'    => ['assets/js/brand.js', 'assets/js/brand/brand-ai-tools.js'],
];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';

/* ---- the hero stage: a prompt goes in, six assets come out, the check catches the one that slipped ---- */
ob_start(); ?>
<div class="bd-stage bt-gen" data-bd-live data-bd-gen>
  <div class="bd-stage__bar">
    <span class="bd-stage__dots" aria-hidden="true"><i></i><i></i><i></i></span>
    <span class="bd-stage__title">Brand model <i aria-hidden="true">›</i> generation</span>
    <span class="bt-gen__models" aria-hidden="true"><i>Flux</i><i>Firefly</i><i>ComfyUI</i></span>
  </div>
  <div class="bd-stage__body bt-gen__body">
    <div class="bt-gen__main" aria-hidden="true">
      <div class="bt-gen__bar">
        <span class="bt-gen__prompt" data-bd-gen-prompt></span><i class="bt-gen__caret"></i>
        <b class="bt-gen__send">›</b>
      </div>
      <div class="bt-gen__grid">
        <?php for ($i = 0; $i < 6; $i++): ?>
          <div class="bt-gen__tile<?= $i === 3 ? ' bt-gen__tile--flag' : '' ?>" style="--i:<?= $i ?>">
            <span class="bt-gen__art"><i></i><b>›</b><em></em></span>
            <span class="bt-gen__badge"><span class="bt-gen__ok">on brand</span><span class="bt-gen__bad">off brand</span><span class="bt-gen__fixed">fixed</span></span>
          </div>
        <?php endfor; ?>
      </div>
      <p class="bt-gen__status" data-bd-gen-status>Waiting for a prompt</p>
    </div>

    <div class="bt-gen__side">
      <p class="bt-gen__sh">Guardrails</p>
      <button class="bt-guard" type="button" aria-pressed="true" data-bd-guard><span class="bt-guard__sw" aria-hidden="true"><i></i></span>Palette lock</button>
      <button class="bt-guard" type="button" aria-pressed="true" data-bd-guard><span class="bt-guard__sw" aria-hidden="true"><i></i></span>Logo clearspace</button>
      <button class="bt-guard" type="button" aria-pressed="true" data-bd-guard><span class="bt-guard__sw" aria-hidden="true"><i></i></span>Tone &amp; lexicon</button>
      <button class="bt-guard" type="button" aria-pressed="true" data-bd-guard><span class="bt-guard__sw" aria-hidden="true"><i></i></span>Human review</button>
      <p class="bt-gen__own"><i aria-hidden="true"></i>Weights · datasets · logs · yours</p>
    </div>
  </div>
</div>
<?php $mockHtml = ob_get_clean(); ?>

<main id="main" class="bd" data-bd="ai-tools">
  <?php include __DIR__ . '/../../partials/brand/phero.php'; ?>
  <?php include __DIR__ . '/../../partials/brand/rail.php'; ?>
  <?php include __DIR__ . '/../../partials/brand/offer.php'; ?>

  <!-- ===== signature · the tools, at work ===== -->
  <section class="band band--alt bt-tools" aria-labelledby="tools-t">
    <div class="wrap">
      <div class="head head--c bt-tools__head" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>Four tools</p>
        <h2 class="h2" id="tools-t"><span class="g">The system does the repetition.</span><br>People do the judgement.</h2>
        <p class="lead">Each tool is built into the software your team already uses. Nothing to learn, one thing fewer to check.</p>
      </div>

      <div class="bt-tools__grid" data-rv-s data-rv-step="90">

        <!-- brand check -->
        <article class="bt-tool bt-tool--7">
          <div class="bt-tool__mock bt-lint" data-bd-live aria-hidden="true">
            <p class="bt-lint__hd"><span>Brand check <i>›</i> launch-visual-04.png</span><span class="bt-lint__score"><b class="num">3</b> found · <b class="num">3</b> fixed</span></p>
            <div class="bt-lint__row"><i class="bt-lint__k">Clearspace</i><span>Logo at 0.6× minimum</span><b class="bt-lint__fix">→ 1×</b></div>
            <div class="bt-lint__row"><i class="bt-lint__k">Palette</i><span>#1A8CFF is not a token</span><b class="bt-lint__fix">→ #0082FB</b></div>
            <div class="bt-lint__row"><i class="bt-lint__k">Lexicon</i><span>“seamless” is on the never list</span><b class="bt-lint__fix">→ “one system”</b></div>
            <p class="bt-lint__foot"><i></i>Passed after fixes · logged 14:02</p>
          </div>
          <div class="bt-tool__cap">
            <h3 class="h3">Brand check</h3>
            <p class="bt-tool__d">A linter for the brand. It flags what is off, suggests the fix, and records the result.</p>
          </div>
        </article>

        <!-- asset generation queue -->
        <article class="bt-tool bt-tool--5">
          <div class="bt-tool__mock bt-queue" data-bd-live aria-hidden="true">
            <p class="bt-queue__hd"><span>Render queue</span><span><b class="num">04</b> of 06</span></p>
            <div class="bt-queue__row is-done"><span>EN · 4:5</span><i><b style="--w:100%"></b></i><em>done</em></div>
            <div class="bt-queue__row is-done"><span>DE · 4:5</span><i><b style="--w:100%"></b></i><em>done</em></div>
            <div class="bt-queue__row is-done"><span>FR · 9:16</span><i><b style="--w:100%"></b></i><em>done</em></div>
            <div class="bt-queue__row is-live"><span>JP · 9:16</span><i><b style="--w:64%"></b></i><em>rendering</em></div>
            <div class="bt-queue__row"><span>IN · 1:1</span><i><b style="--w:0%"></b></i><em>queued</em></div>
            <div class="bt-queue__row"><span>BR · 1:1</span><i><b style="--w:0%"></b></i><em>queued</em></div>
          </div>
          <div class="bt-tool__cap">
            <h3 class="h3">Asset generation</h3>
            <p class="bt-tool__d">One approved source, every market and format. Reviewed by people, produced by the system.</p>
          </div>
        </article>

        <!-- copy assistant -->
        <article class="bt-tool bt-tool--5">
          <div class="bt-tool__mock bt-copy" data-bd-live aria-hidden="true">
            <span class="bt-copy__bub">Write the launch line for the ops offer.</span>
            <span class="bt-copy__bub bt-copy__bub--a">One system. Every market. <s>Seamlessly.</s> <b>Without the drift.</b></span>
            <span class="bt-copy__why"><i>›</i>“seamless” is on the never list. Swapped for a claim we can prove.</span>
          </div>
          <div class="bt-tool__cap">
            <h3 class="h3">Copy assistant</h3>
            <p class="bt-tool__d">Knows the voice, the lexicon and the words you never use. Inside the tools your team writes in.</p>
          </div>
        </article>

        <!-- template engine -->
        <article class="bt-tool bt-tool--7">
          <div class="bt-tool__mock bt-engine" data-bd-live aria-hidden="true">
            <p class="bt-engine__hd"><span>Template engine <i>›</i> launch · 6 markets</span><span><b class="num">6</b> of 6</span></p>
            <div class="bt-engine__grid">
              <?php foreach (['EN', 'DE', 'FR', 'JP', 'IN', 'BR'] as $i => $m): ?>
                <span class="bt-engine__v" style="--i:<?= $i ?>"><i class="bt-engine__hero"></i><i class="bt-engine__line"></i><i class="bt-engine__line bt-engine__line--s"></i><b><?= $m ?></b><em>›</em></span>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="bt-tool__cap">
            <h3 class="h3">Template engine</h3>
            <p class="bt-tool__d">Content and data in, finished assets out, across markets, sizes and channels.</p>
          </div>
        </article>

      </div>
    </div>
  </section>

  <!-- ===== how it is built · and who owns it ===== -->
  <section class="band bt-pipe" aria-labelledby="bpipe-t">
    <div class="wrap">
      <div class="head--row bt-pipe__head" data-rv>
        <div>
          <p class="lbl lbl--blue"><span class="dot"></span>How it is built</p>
          <h2 class="h2" id="bpipe-t"><span class="g">The brand system</span><br>becomes the training set</h2>
        </div>
        <p class="lead">A model can only learn what has been decided. So the identity and the system come first, and the model learns from them, not from the internet.</p>
      </div>

      <div class="bt-pipe__track" data-bd-live data-rv data-rv-d="80" aria-hidden="true">
        <i class="bt-pipe__rule"></i>
        <i class="bt-pipe__pkt"></i>
        <?php
        $nodes = [
            ['Brand system',  'Identity, tokens, rules'],
            ['Training set',  'Curated · labelled · rights-checked'],
            ['Fine-tune',     'Image and language models'],
            ['Guardrails',    'Written as tests'],
            ['Deploy',        'In the tools your team uses'],
        ];
        foreach ($nodes as $i => $n): ?>
          <div class="bt-pipe__node" style="--i:<?= $i ?>">
            <span class="bt-pipe__dot"><b class="num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></b></span>
            <span class="bt-pipe__t"><?= e($n[0]) ?></span>
            <span class="bt-pipe__d"><?= e($n[1]) ?></span>
          </div>
        <?php endforeach; ?>
      </div>

      <ul class="bt-own" data-rv-s data-rv-step="70">
        <?php foreach ([['Weights', 'The tuned models, in your accounts'], ['Datasets', 'Every asset and label we trained on'], ['Prompts', 'The prompt sets and system rules'], ['Logs', 'Every output, who approved it, when']] as $o): ?>
          <li class="bt-own__i">
            <span class="bt-own__lock" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="10.5" rx="2.2"/><path d="M8 10V7.4a4 4 0 0 1 8 0V10"/></svg></span>
            <span class="bt-own__t"><?= e($o[0]) ?></span>
            <span class="bt-own__d"><?= e($o[1]) ?></span>
            <span class="bt-own__y">yours</span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <?php
  $proc = $cap['process'];
  include __DIR__ . '/../../partials/brand/process.php';
  include __DIR__ . '/../../partials/brand/deliver.php';
  include __DIR__ . '/../../partials/brand/outcomes.php';
  include __DIR__ . '/../../partials/brand/pairs.php';
  $faqId = 'faq';
  $faq = ['title' => 'Brand AI Tools,<br><span class="g">asked directly</span>', 'items' => $cap['faq']];
  include __DIR__ . '/../../partials/brand/faq.php';
  include __DIR__ . '/../../partials/brand/next.php';
  include __DIR__ . '/../../partials/cta.php';
  ?>
</main>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
