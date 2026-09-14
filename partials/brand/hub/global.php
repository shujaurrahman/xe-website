<?php /* DRAFT COPY — review before launch */
/* Global scale — a rollout matrix (market × asset, three waves), an acquisition before/after, and
   governance that travels. PLACEHOLDER: illustrative rollout — confirm before launch. */
$gl_assets  = ['Identity', 'Templates', 'Digital', 'Signage', 'Packaging', 'Training'];
$gl_markets = [
    // [region, script, wave]
    ['EMEA',     'Latin',          1],
    ['EMEA',     'Latin',          1],
    ['APAC',     'Devanagari',     2],
    ['EMEA',     'Arabic · RTL',   2],
    ['Americas', 'Latin',          2],
    ['APAC',     'CJK',            3],
    ['Americas', 'Latin',          3],
    ['APAC',     'Devanagari',     3],
];
/* a cell goes live in its market's wave; physical assets (signage, packaging) one wave later */
$gl_live = fn (int $wave, int $asset): int => $wave + (in_array($asset, [3, 4], true) ? 1 : 0);
$gl_state = function (int $live, int $view): string {
    if ($view >= $live) return 'live';
    if ($view === $live - 1) return 'loc';
    return 'plan';
};
$gl_rules = [
    'Tiered approvals: what markets change on their own, and what needs the council.',
    'Local flex within written ranges.',
    'One source of truth that every partner and tool reads from.',
];
?>
<section class="band bdh-global" id="global" aria-labelledby="global-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Global scale</p>
        <h2 class="h2" id="global-t"><span class="g">One system,</span> many markets, many brands.</h2>
      </div>
      <div><p class="lead">Enterprise brands rarely launch once. They roll out market by market, absorb acquisitions and hand work to hundreds of partners. We design for that from the first week.</p></div>
    </div>

    <div class="bdh-gl__matrix" data-view="3" data-rv>
      <div class="bdh-gl__top">
        <p class="bdh-gl__cap">Rollout by market <span class="bdh-ill">Illustrative</span></p>
        <div class="bdh-seg bdh-gl__waves" role="group" aria-label="Rollout wave">
          <?php for ($gl_w = 1; $gl_w <= 3; $gl_w++): ?>
            <button type="button" data-wave="<?= $gl_w ?>" aria-pressed="<?= $gl_w === 3 ? 'true' : 'false' ?>">Wave <?= $gl_w ?></button>
          <?php endfor; ?>
        </div>
      </div>

      <div class="bdh-scroll-x bdh-gl__scroll" tabindex="0" aria-label="Rollout matrix — scroll sideways on small screens">
        <table class="bdh-gl__table">
          <thead>
            <tr><th scope="col">Market</th><?php foreach ($gl_assets as $gl_a): ?><th scope="col"><?= e($gl_a) ?></th><?php endforeach; ?><th scope="col" class="bdh-gl__scr">Script</th></tr>
          </thead>
          <tbody>
            <?php foreach ($gl_markets as $gl_i => $gl_m): ?>
              <tr>
                <th scope="row"><span>Market <?= str_pad((string) ($gl_i + 1), 2, '0', STR_PAD_LEFT) ?></span><small><?= e($gl_m[0]) ?></small></th>
                <?php foreach ($gl_assets as $gl_j => $gl_a): $gl_l = $gl_live($gl_m[2], $gl_j); $gl_s = $gl_state($gl_l, 3); ?>
                  <td><span class="bdh-gl__dot is-<?= $gl_s ?>" data-live="<?= $gl_l ?>" style="--i:<?= $gl_i + $gl_j ?>"><span class="bdh-sr"><?= $gl_s === 'live' ? 'Live' : ($gl_s === 'loc' ? 'Localising' : 'Planned') ?></span></span></td>
                <?php endforeach; ?>
                <td class="bdh-gl__scr"><span class="bdh-tag"><?= e($gl_m[1]) ?></span></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="bdh-gl__foot">
        <p class="bdh-gl__legend" aria-hidden="true"><span><i class="bdh-gl__dot is-plan"></i>Planned</span><span><i class="bdh-gl__dot is-loc"></i>Localising</span><span><i class="bdh-gl__dot is-live"></i>Live</span></p>
        <p class="bdh-gl__note">Transcreation, not translation: in-market reviewers sign off every market.</p>
      </div>
      <p class="bdh-tags bdh-gl__chips"><span class="bdh-tag">Script-ready type pairings</span><span class="bdh-tag">Length-expansion rules</span><span class="bdh-tag">Right-to-left layouts</span><span class="bdh-tag">Local flex ranges</span></p>
    </div>

    <div class="bdh-grid bdh-gl__cards">
      <article class="bdh-c6 bdh-card bdh-gl__acq" data-state="after" data-rv>
        <div class="bdh-gl__ch">
          <h3 class="bdh-t bdh-t--l">After an acquisition</h3>
          <div class="bdh-seg" role="group" aria-label="Portfolio view">
            <button type="button" data-set="before" aria-pressed="false">Before</button>
            <button type="button" data-set="after" aria-pressed="true">After</button>
          </div>
        </div>
        <p class="bdh-d">Every brand gets a place, a relationship and a migration path, so customers are never left guessing.</p>

        <div class="bdh-gl__map" aria-hidden="true">
          <svg class="bdh-gl__wires" viewBox="0 0 100 100" preserveAspectRatio="none" focusable="false">
            <g class="is-before">
              <path d="M18 22 L70 16"/><path d="M18 22 L40 52"/><path d="M70 16 L78 62"/><path d="M40 52 L16 78"/><path d="M40 52 L78 62"/><path d="M70 16 L16 78"/>
            </g>
            <g class="is-after">
              <path d="M50 14 V36 H18 V58"/><path d="M50 36 V58"/><path d="M50 36 H82 V58"/><path class="is-dash" d="M82 86 V66"/>
            </g>
          </svg>
          <span class="bdh-gl__node is-a" style="--bx:18%;--by:22%;--ax:50%;--ay:14%"><b class="is-b">Brand A</b><b class="is-f">Master brand</b></span>
          <span class="bdh-gl__node" style="--bx:70%;--by:16%;--ax:18%;--ay:58%"><b>Brand B</b><small>endorsed</small></span>
          <span class="bdh-gl__node" style="--bx:40%;--by:52%;--ax:50%;--ay:58%"><b>Product C</b><small>sub-brand</small></span>
          <span class="bdh-gl__node is-d" style="--bx:78%;--by:62%;--ax:82%;--ay:86%"><b>Sub-brand D</b><small>retired → migrated</small></span>
          <span class="bdh-gl__node" style="--bx:16%;--by:78%;--ax:82%;--ay:58%"><b>Service E</b><small>descriptor</small></span>
        </div>
      </article>

      <article class="bdh-c6 bdh-card bdh-gl__gov" data-rv data-rv-d="100" data-bdh-live>
        <h3 class="bdh-t bdh-t--l">Governance that travels</h3>
        <p class="bdh-d">Clear owners at the centre, clear ranges at the edge.</p>
        <div class="bdh-gl__rings" aria-hidden="true">
          <span class="bdh-gl__ring is-3"><em>Tools &amp; agents</em></span>
          <span class="bdh-gl__ring is-2"><em>Agencies &amp; partners</em></span>
          <span class="bdh-gl__ring is-1"><em>Market leads</em></span>
          <span class="bdh-gl__core">Brand council</span>
          <span class="bdh-gl__orbit"><i></i></span>
        </div>
        <ul class="bdh-bullets bdh-gl__rules">
          <?php foreach ($gl_rules as $gl_r): ?><li><?= e($gl_r) ?></li><?php endforeach; ?>
        </ul>
      </article>
    </div>
  </div>
</section>
