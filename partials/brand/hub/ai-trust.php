<?php /* DRAFT COPY — review before launch */
/* Agents do the repetition, people make the calls — six pairs, a photo, four governance cards. */
$trust_pairs = [
    ['Research',     'Synthesises interviews, reviews and market signals',  'Which insight matters, and what we do about it'],
    ['Generation',   'Produces variants from approved parts',               'What ships, and what is never automated'],
    ['Compliance',   'Flags drift, contrast and claim issues on every asset','Exceptions, and when a rule should change'],
    ['Localisation', 'Drafts market versions and length fits',             'In-market reviewers sign off meaning and nuance'],
    ['Guidelines',   'Proposes updates when patterns repeat',               'The brand owner approves every release'],
    ['Monitoring',   'Reports drift across live channels',                  'The brand council sets priorities'],
];
$trust_gov = [
    ['key',    'Your models, your accounts',   'Weights, prompts, pipelines and logs sit in your cloud and transfer on delivery.'],
    ['lock',   'Data stays scoped',            'Your assets are used only for your brand. Data handling is agreed in writing before anything is shared.'],
    ['record', 'Every output recorded',        'Provenance and approvals are logged, with content credentials attached where the channel supports them.'],
    ['scale',  'Tools chosen on evidence',     'Flux, Adobe Firefly and ComfyUI for images; Gemini, OpenAI or Anthropic models for language, picked per task. We hold no partner badges and switch when the evidence changes.'],
];
$trust_icons = [
    'key'    => '<circle cx="8" cy="15" r="4"/><path d="M11 12.2 20 3.5M16.5 7l2.5 2.5M14 9.5l2 2"/>',
    'lock'   => '<rect x="4.5" y="10.5" width="15" height="10" rx="2.2"/><path d="M8 10.5V7.5a4 4 0 0 1 8 0v3"/>',
    'record' => '<path d="M6 3.5h9l3.5 3.5v13.5H6z"/><path d="M14.5 3.5V7.5h4M9 12h6M9 15.5h6"/>',
    'scale'  => '<path d="M12 4v16M6 20h12M4 9l3-4 3 4M14 9l3-4 3 4"/><path d="M4 9a3 3 0 0 0 6 0M14 9a3 3 0 0 0 6 0"/>',
];
?>
<section class="band bdh-ai-trust" id="ai-trust" aria-labelledby="ai-trust-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Judgement and governance</p>
        <h2 class="h2" id="ai-trust-t"><span class="g">Agents do the repetition.</span> People make the calls.</h2>
      </div>
      <div><p class="lead">AI takes the volume. Accountability stays with named people on your side and ours, and every step is recorded.</p></div>
    </div>

    <div class="bdh-grid bdh-trust__grid">
      <div class="bdh-c8 bdh-trust__table" data-rv>
        <div class="bdh-trust__hdr" aria-hidden="true"><span>Agents do</span><span></span><span>People decide</span></div>
        <ul class="bdh-trust__rows" data-bdh-live>
          <?php foreach ($trust_pairs as $trust_i => $trust_p): ?>
            <li class="bdh-trust__row" style="--i:<?= $trust_i ?>">
              <p class="bdh-trust__k"><?= e($trust_p[0]) ?></p>
              <div class="bdh-trust__pair">
                <p class="bdh-trust__a"><span class="bdh-sr">Agents: </span><?= e($trust_p[1]) ?></p>
                <span class="bdh-trust__spine" aria-hidden="true"><i></i></span>
                <p class="bdh-trust__p"><span class="bdh-sr">People decide: </span><?= e($trust_p[2]) ?></p>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="bdh-c4 bdh-s9 bdh-trust__side">
        <div class="bdh-sticky" data-rv data-rv-d="120">
          <!-- PLACEHOLDER: reference photography (Unsplash) — replace with commissioned/own imagery before launch -->
          <figure class="bdh-img bdh-img--r34 bdh-img--xl bdh-trust__img">
            <img src="<?= xe_url('assets/imgs/brand/hub/ai-trust/review.jpg') ?>" alt="Two colleagues reviewing printed documents together at a table" width="1200" height="675" loading="lazy" decoding="async">
            <span class="bdh-cap-chip bdh-trust__chip"><b>Human in the loop</b>Every release has a named human owner.</span>
          </figure>
        </div>
      </div>
    </div>

    <ul class="bdh-trust__gov" data-rv-s data-rv-step="90">
      <?php foreach ($trust_gov as $trust_g): ?>
        <li class="bdh-card bdh-card--lift">
          <span class="bdh-trust__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><?= $trust_icons[$trust_g[0]] ?></svg></span>
          <h3 class="bdh-t"><?= e($trust_g[1]) ?></h3>
          <p class="bdh-d"><?= e($trust_g[2]) ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
