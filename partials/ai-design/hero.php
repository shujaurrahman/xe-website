<?php /* DRAFT COPY — review before launch */
/* Hero — the discipline's one object, stated once. Text on paper, left. Right: an ink panel holding a
   single generation run as a vertical strip: brief → direction → route → gates → record. The HTML is the
   finished state (every stage resolved, every readout at its value); hero.js walks a highlight down the
   strip and types the event line while the panel is on screen. Reduced motion keeps the static strip. */

/* One illustrative run. Nothing here is a client result; every figure is marked illustrative in the bar. */
$hero_route = [
    // [step, what it routes to, how it is named — 'slug' uses a mark from data/tech-stack.php, 'mark' is set in type]
    ['plan',   'slug', 'anthropic',    'shot list from the approved brief'],
    ['stills', 'mark', 'Flux',         'stills on the brand-tuned adapter'],
    ['motion', 'mark', 'Runway · Veo', 'shot-by-shot, 4 s each'],
    ['voice',  'mark', 'ElevenLabs',   'consented voice, 6 languages'],
];
$hero_gates = [
    // [gate, verdict, state]
    ['Rights',    '24 / 24 inputs cleared',  'pass'],
    ['Fidelity',  '0.91 vs 0.85 threshold',  'pass'],
    ['Guardrails','no marks, no likeness',   'pass'],
    ['Provenance','C2PA attached',           'pass'],
    ['Approval',  'named reviewer',          'human'],
];
$hero_stat = [
    ['fid',  'Brand fidelity', '0.91', 'scored'],
    ['out',  'Deliverables',   '24',   'assets'],
    ['rts',  'Rights record',  '100%', 'complete'],
    ['appr', 'Human approval', '1',    'named'],
];
/* the run log: one line at a time, typed by hero.js (illustrative) */
$hero_feed = [
    ['brief',      'film/launch-q3 · 6 markets · 4 ratios · direction v3 locked'],
    ['route',      'stills → brand adapter v7 · motion → 14 shots · voice → 6 languages'],
    ['rights',     '24 inputs checked · 24 licensed or consented · 0 unresolved'],
    ['evals',      'brand fidelity 0.91 · palette 0.94 · type 0.88 · above threshold'],
    ['guardrails', 'third-party marks blocked · no named likeness · claims flagged for legal'],
    ['provenance', 'C2PA Content Credentials written · disclosure label per market'],
    ['approval',   'queued to a named reviewer · 24 assets approved · logged'],
    ['delivery',   '24 assets to your asset library · rights and expiry recorded'],
];
$hero_caps = array_map(fn ($hero_c) => $hero_c['name'], array_values($CAPS));
?>
<section class="aih-hero" id="top" aria-labelledby="hero-t">
  <span class="aih-hero__bg dots" aria-hidden="true"></span>

  <div class="wrap aih-hero__in">
    <div class="aih-hero__text">
      <p class="lbl lbl--blue aih-hero__up" style="--i:0"><span class="dot"></span>What we do · <?= e($DISC['n']) ?> · <?= e($DISC['name']) ?></p>
      <h1 class="aih-hero__h aih-hero__up" id="hero-t" style="--i:1"><span class="g">Brand experiences</span> that could not exist before AI.</h1>
      <p class="lead aih-hero__lead aih-hero__up" style="--i:2"><?= e($DISC['intro']) ?></p>
      <div class="aih-hero__act aih-hero__up" style="--i:3">
        <a class="btn btn--ink" href="<?= e(svc_contact_url([], null, 'ai-design')) ?>">Start an AI design brief <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out" href="#run">Open a generation run <span class="i" aria-hidden="true">›</span></a>
      </div>
      <dl class="aih-hero__proof aih-hero__up" style="--i:4">
        <div><dt>Capabilities</dt><dd><?= count($CAPS) ?></dd></div>
        <div><dt>Scope</dt><dd>Strategy → model → studio</dd></div>
        <div><dt>Every output</dt><dd>Directed, scored, logged</dd></div>
      </dl>
    </div>

    <div class="aih-hero__vis">
      <p class="bdh-sr">An illustrative generation run, shown as a strip: a brief for a launch film in six markets, locked art direction, a route that sends planning to a language model and stills, motion and voice to generative media tools, then five checks — rights, brand fidelity scored 0.91 against a 0.85 threshold, guardrails, C2PA provenance and approval by a named reviewer — and a record of 24 delivered assets. <?= e($DISC['name']) ?> covers <?= e(implode(', ', $hero_caps)) ?>.</p>

      <div class="aih-panel aih-panel--ink xt-on-ink aih-hero__panel" aria-hidden="true" data-bdh-in>
        <div class="aih-panel__bar">
          <span class="aih-panel__dots"><i></i><i></i><i></i></span>
          <span class="aih-panel__title">run <i>/</i> film.launch-q3</span>
          <span class="aih-panel__ill aih-panel__sp">Illustrative</span>
          <span class="aih-panel__live"><i class="bdh-pulse"></i>Live</span>
        </div>

        <ol class="aih-hero__run">
          <li class="aih-hero__s" data-s="brief">
            <span class="aih-hero__sd"><b>01</b></span>
            <span class="aih-hero__sk">Brief</span>
            <span class="aih-hero__sv">Launch film · 6 markets · 4 ratios</span>
          </li>
          <li class="aih-hero__s" data-s="direct">
            <span class="aih-hero__sd"><b>02</b></span>
            <span class="aih-hero__sk">Direction</span>
            <span class="aih-hero__sv">Reference set v3 · grade and type rules locked</span>
          </li>
          <li class="aih-hero__s" data-s="route">
            <span class="aih-hero__sd"><b>03</b></span>
            <span class="aih-hero__sk">Route</span>
            <span class="aih-hero__sv">Chosen per output, on evidence</span>
            <ul class="aih-hero__route">
              <?php foreach ($hero_route as $hero_r): ?>
                <li>
                  <span class="aih-hero__rk"><?= e($hero_r[0]) ?></span>
                  <?php if ($hero_r[1] === 'slug'): ?>
                    <span class="aih-hero__rm"><?= xt_logo($hero_r[2], ['size' => 16, 'label' => true]) ?></span>
                  <?php else: ?>
                    <span class="aih-hero__rm"><span class="aih-mark"><?= e($hero_r[2]) ?></span></span>
                  <?php endif; ?>
                  <span class="aih-hero__rw"><?= e($hero_r[3]) ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          </li>
          <li class="aih-hero__s" data-s="gate">
            <span class="aih-hero__sd"><b>04</b></span>
            <span class="aih-hero__sk">Gates</span>
            <span class="aih-hero__sv">Five checks, all recorded</span>
            <ul class="aih-hero__gates">
              <?php foreach ($hero_gates as $hero_g): ?>
                <li data-state="<?= e($hero_g[2]) ?>"><i aria-hidden="true"></i><b><?= e($hero_g[0]) ?></b><span><?= e($hero_g[1]) ?></span></li>
              <?php endforeach; ?>
            </ul>
          </li>
          <li class="aih-hero__s" data-s="record">
            <span class="aih-hero__sd"><b>05</b></span>
            <span class="aih-hero__sk">Record</span>
            <span class="aih-hero__sv">Prompt, model version, inputs, approver, disclosure</span>
          </li>
        </ol>

        <p class="aih-hero__feed" data-bdh-live data-feed="<?= e(json_encode($hero_feed, JSON_UNESCAPED_UNICODE)) ?>">
          <span class="aih-hero__fp">›</span><span class="aih-hero__fs"><?= e($hero_feed[0][0]) ?></span><span class="aih-hero__fx"><span class="aih-hero__fxt"><?= e($hero_feed[0][1]) ?></span><span class="bdh-caret"></span></span>
        </p>

        <dl class="aih-panel__foot">
          <?php foreach ($hero_stat as $hero_st): ?>
            <div><dt><?= e($hero_st[1]) ?></dt><dd><b data-k="<?= e($hero_st[0]) ?>"><?= e($hero_st[2]) ?></b> <?= e($hero_st[3]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
      </div>
    </div>
  </div>
</section>
