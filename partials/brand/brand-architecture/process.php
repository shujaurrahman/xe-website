<?php /* DRAFT COPY — review before launch */
/* 9 · Process — the engagement as a floor plan. Each step of $BD process is a room, its width in
   proportion to its weeks; the artefacts sit in the room like furniture. Rooms light in sequence
   (autoplay until touched); a room button opens its detail. HTML = the first room selected. */
$cba_steps = $CBA_CAP['process']['steps'];
$cba_room_ai = [ // where agents work, what people decide — per step (DRAFT COPY)
    ['Inventory every brand, name and touchpoint; cluster search and journey data into a first navigation map.', 'Interview brand owners and customers; confirm what each brand is actually for.'],
    ['Score each model against growth plans and navigation data; draft the trade-off table for every option.', 'Leadership chooses the model in a working session and signs the decision record.'],
    ['Screen candidate names for conflicts and meaning in every market; draft the migration order and its dependencies.', 'Choose the names, set the phases and approve each gate before anything moves.'],
];
$cba_weeks = [];
foreach ($cba_steps as $cba_st) {
    preg_match_all('/\d+/', $cba_st[1], $cba_m);
    $cba_weeks[] = count($cba_m[0]) > 1 ? (int) $cba_m[0][1] - (int) $cba_m[0][0] + 1 : 1;
}
$cba_total = array_sum($cba_weeks);
?>
<section class="band band--alt cba-proc" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <div class="cba-head" data-rv>
      <div class="cba-head__t">
        <p class="cba-eb"><b>A-108</b><i aria-hidden="true"></i>How the engagement runs</p>
        <h2 class="h2" id="process-t"><?php /* DRAFT COPY */ ?><span class="g">A corridor of rooms,</span> each one ending in a decision.</h2>
      </div>
      <div class="cba-head__l">
        <p class="lead"><?= e($CBA_CAP['process']['lead']) ?> <?= $cba_total ?> weeks, laid out as a plan: walk from room to room.</p>
      </div>
    </div>

    <div class="cba-proc__app" data-cba-proc>
      <div class="cba-proc__planwrap cba-sheet">
        <div class="cba-proc__ruler" aria-hidden="true" style="--n:<?= $cba_total ?>">
          <?php for ($cba_w = 1; $cba_w <= $cba_total; $cba_w++): ?><span>Wk <?= sprintf('%02d', $cba_w) ?></span><?php endfor; ?>
        </div>
        <div class="cba-proc__plan" role="tablist" aria-label="Engagement steps" style="--cols:<?= implode(' ', array_map(fn ($cba_x) => 'minmax(0,' . $cba_x . 'fr)', $cba_weeks)) ?>">
          <?php foreach ($cba_steps as $cba_si => $cba_st): ?>
            <button type="button" class="cba-proc__room<?= $cba_si === 0 ? ' is-on' : '' ?>" role="tab" id="process-tab-<?= $cba_si ?>" aria-controls="process-pane-<?= $cba_si ?>" aria-selected="<?= $cba_si === 0 ? 'true' : 'false' ?>" tabindex="<?= $cba_si === 0 ? '0' : '-1' ?>">
              <span class="cba-proc__rn">Room <?= sprintf('%02d', $cba_si + 1) ?> · <?= e($cba_st[1]) ?></span>
              <span class="cba-proc__rt"><?= e($cba_st[0]) ?></span>
              <span class="cba-proc__dim" aria-hidden="true"><b><?= $cba_weeks[$cba_si] ?> <?= $cba_weeks[$cba_si] === 1 ? 'week' : 'weeks' ?></b></span>
              <span class="cba-proc__furn" aria-hidden="true">
                <?php foreach ($cba_st[3] as $cba_art): ?><i><?= e($cba_art) ?></i><?php endforeach; ?>
              </span>
              <span class="cba-proc__door" aria-hidden="true"></span>
            </button>
          <?php endforeach; ?>
        </div>
        <p class="cba-proc__corr cba-mono" aria-hidden="true"><span>Corridor · decisions recorded as you go</span><span>N ↑</span></p>
      </div>

      <div class="cba-proc__detail">
        <?php foreach ($cba_steps as $cba_si => $cba_st): ?>
          <div class="cba-proc__pane" role="tabpanel" id="process-pane-<?= $cba_si ?>" aria-labelledby="process-tab-<?= $cba_si ?>"<?= $cba_si === 0 ? '' : ' hidden' ?>>
            <div class="cba-proc__main">
              <p class="cba-mono cba-mono--blue"><?= e($cba_st[1]) ?> · <?= $cba_weeks[$cba_si] ?> weeks</p>
              <h3 class="cba-proc__h"><?= e($cba_st[0]) ?></h3>
              <p class="cba-proc__desc"><?= e($cba_st[2]) ?></p>
              <p class="cba-mono cba-proc__al">Leaves the room with</p>
              <ul class="cba-proc__arts">
                <?php foreach ($cba_st[3] as $cba_art): ?><li><?= e($cba_art) ?></li><?php endforeach; ?>
              </ul>
            </div>
            <dl class="cba-proc__who">
              <div><dt class="cba-mono cba-mono--blue">Agents work</dt><dd><?= e($cba_room_ai[$cba_si][0]) ?></dd></div>
              <div><dt class="cba-mono cba-mono--ink">People decide</dt><dd><?= e($cba_room_ai[$cba_si][1]) ?></dd></div>
            </dl>
          </div>
        <?php endforeach; ?>
        <!-- PLACEHOLDER: reference photography (Unsplash) — replace with own imagery before launch -->
        <figure class="cba-plate cba-proc__photo">
          <img src="<?= xe_url('assets/imgs/brand/brand-architecture/site-model-cardboard.jpg') ?>" alt="A card and paper site model of low buildings among model trees on a gridded base" width="1400" height="934" loading="lazy" decoding="async">
          <figcaption><b>Fig. 05</b>Worked out in the model before it is built</figcaption>
        </figure>
      </div>
    </div>
  </div>
</section>
