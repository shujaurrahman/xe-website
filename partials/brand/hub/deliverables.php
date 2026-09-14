<?php /* DRAFT COPY — review before launch */
/* The handover kit — a file explorer of what the client receives. Folders 1–6 are the capabilities
   (items from data/brand-design.php); folder 7 is the programme itself. */
$dl_folders = [];
foreach ($BRAND['caps'] as $dl_cap) { $dl_folders[] = [$dl_cap[0], $BD[$dl_cap[2]]['deliver']]; }
$dl_folders[] = ['Programme', [
    ['Rollout plan',          'Roadmap'],
    ['Launch templates',      'Figma · Office'],
    ['Team training',         'Recorded sessions'],
    ['Governance model',      'Document'],
    ['Brand health tracker',  'Dashboard'],
    ['Decision log',          'Document'],
]];
/* which CSS specimen a format string gets */
$dl_kind = function (string $fmt): string {
    $f = strtolower($fmt);
    foreach ([
        'terminal' => ['weights', 'api', 'plugin', 'comfyui', 'tests', 'prompt'],
        'code'     => ['json', 'css', 'variables', 'changelog', 'code'],
        'web'      => ['web', 'dashboard', 'cms'],
        'figma'    => ['figma'],
        'sheet'    => ['sheet'],
        'video'    => ['video', 'lottie', 'recorded'],
        'deck'     => ['deck', 'board', 'roadmap'],
    ] as $dl_k => $dl_words) {
        foreach ($dl_words as $dl_w) { if (strpos($f, $dl_w) !== false) return $dl_k; }
    }
    return 'doc';
};
?>
<section class="band band--alt bdh-deliverables" id="deliverables" aria-labelledby="deliverables-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>What you receive</p>
        <h2 class="h2" id="deliverables-t"><span class="g">Everything handed over,</span> in files your teams can use.</h2>
      </div>
      <div><p class="lead">No deck about what comes next. Source files, tokens, templates, guidelines and models, organised the way your teams work and owned by you.</p></div>
    </div>

    <div class="bdh-grid bdh-dl" data-rv data-rv-d="80">
      <div class="bdh-c4 bdh-dl__explorer">
        <p class="bdh-dl__crumb"><span aria-hidden="true">▤</span>Your brand /</p>
        <div class="bdh-dl__tabs" role="tablist" aria-label="Handover folders" aria-orientation="vertical">
          <?php foreach ($dl_folders as $dl_i => $dl_f): ?>
            <button class="bdh-dl__tab" type="button" role="tab" id="deliverables-t<?= $dl_i ?>" aria-controls="deliverables-p<?= $dl_i ?>"
                    aria-selected="<?= $dl_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $dl_i === 0 ? '0' : '-1' ?>">
              <span class="bdh-dl__folder" aria-hidden="true"></span>
              <span class="bdh-dl__name"><?= e($dl_f[0]) ?></span>
              <small><?= count($dl_f[1]) ?></small>
            </button>
          <?php endforeach; ?>
        </div>
        <p class="bdh-dl__foot"><span class="bdh-ok" aria-hidden="true">✓</span>Transfers to your accounts on delivery</p>
      </div>

      <div class="bdh-c8 bdh-dl__panes bdh-panes">
        <?php foreach ($dl_folders as $dl_i => $dl_f): ?>
          <div class="bdh-pane<?= $dl_i === 0 ? ' is-on' : '' ?>" id="deliverables-p<?= $dl_i ?>" role="tabpanel" aria-labelledby="deliverables-t<?= $dl_i ?>">
            <ul class="bdh-dl__grid">
              <?php foreach ($dl_f[1] as $dl_j => $dl_item): $dl_k = $dl_kind($dl_item[1]); ?>
                <li class="bdh-dl__card" style="--i:<?= $dl_j ?>">
                  <span class="bdh-dl__spec is-<?= $dl_k ?>" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></span>
                  <h3 class="bdh-t bdh-t--s bdh-dl__t"><?= e($dl_item[0]) ?></h3>
                  <p class="bdh-tags"><?php foreach (explode(' · ', $dl_item[1]) as $dl_b): ?><span class="bdh-tag"><?= e($dl_b) ?></span><?php endforeach; ?></p>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <p class="bdh-dl__own">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="4.5" y="10.5" width="15" height="10" rx="2.2"/><path d="M8 10.5V7.5a4 4 0 0 1 8 0v3"/></svg>
      Source files, tokens, templates and model weights transfer to your accounts. Nothing is retained or reused elsewhere.
    </p>
  </div>
</section>
