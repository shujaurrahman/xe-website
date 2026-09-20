<?php /* DRAFT COPY — review before launch */
/* 05 · Real usage. Four editorial photographs of the contexts people actually use products in, in two staggered
   columns (01 + 03 left, 02 + 04 right, offset down), each with an annotation pin on the photograph and a code-built
   requirement card overlapping its lower edge: what that context forces the build to do, with the WCAG 2.2 criteria
   and thresholds that follow. Photographs parallax (BDH.parallax, automatic on [data-bdh-parallax]); cards rise in
   with [data-rv]. Below 860px the columns dissolve (display:contents) and inline order restores 01 → 04. */
$twa_sf = [   // photo, w, h, position, alt, context label, scene line, requirement, spec lines, tags, pin x %, pin y %, pin label, icon
    ['surface-warehouse.jpg', 1600, 1065, '30% 50%', 'Two workers walking a warehouse aisle, one in a hi-vis vest holding a handheld scanner',
        'Warehouse floor', 'Gloves, glare and a signal that drops behind the racking.',
        'Offline queue and big tap targets',
        ['Actions queued locally and synced on reconnect, in order, without duplicates', 'Tap targets 44 px or larger, well past the 24 × 24 px minimum of WCAG 2.2 2.5.8', 'Contrast 7:1 for readouts under industrial lighting', 'Camera barcode scan with a manual-entry fallback'],
        ['PWA', 'Service worker', 'Background Sync'], 38, 57, 'Offline · 3 actions queued', 'sync'],
    ['surface-commuter.jpg', 1600, 1201, '50% 50%', 'A commuter reading her phone on an underground train',
        'Commute', 'One hand, one thumb, and a network that comes and goes between stations.',
        'Thumb-zone navigation and INP under 200 ms',
        ['Primary actions inside the lower two-thirds of the screen, reachable with one thumb', 'Interaction to Next Paint 200 ms or less at p75, measured in the field', 'Optimistic updates with retry and backoff when the request fails', 'No layout shift when the connection returns'],
        ['INP ≤ 200 ms', 'Optimistic UI', 'Retry + backoff'], 75, 48, 'One hand · thumb reach', 'latency'],
    ['surface-desk.jpg', 1600, 1067, '60% 50%', 'An operations analyst working across two wide monitors',
        'Operations desk', 'Two monitors, dense tables and a keyboard that rarely leaves the hand.',
        'Dense data tables with keyboard shortcuts',
        ['Virtualised tables that stay smooth at 100,000 rows', 'Density toggle, sticky headers and columns the user can reorder', 'Shortcuts for search, navigation and bulk actions, with a visible cheat sheet', 'Exports that match the filter on screen, not the whole table'],
        ['Virtualised', 'Shortcuts', 'Bulk actions'], 49, 42, '2 screens · 140 rows visible', 'dashboard'],
    ['surface-bus-stop.jpg', 1600, 1067, '70% 50%', 'An older man at a bus stop reading his phone with the text enlarged',
        'Bus stop', 'Bifocals, cold hands and the text zoomed to 200%.',
        '200% zoom and reflow at 320 px',
        ['Content reflows at 320 CSS px with no two-directional scrolling (WCAG 2.2 1.4.10)', 'Text resizes to 200% with nothing lost or clipped (1.4.4) and spacing overrides hold (1.4.12)', 'Focus always visible; nothing depends on hover or fine pointer control', 'Plain language, one action per screen'],
        ['WCAG 2.2 AA', 'Reflow 320 px', 'Zoom 200%'], 40, 68, 'Text at 200% · 320 px reflow', 'accessibility'],
];
?>
<section class="band band--alt twa-surfaces" id="surfaces" aria-labelledby="surfaces-t">
  <div class="wrap">
    <div class="twa-head" data-rv>
      <p class="twa-head__run"><b>05 · Real usage</b><span>Four contexts · four requirements</span></p>
      <div class="twa-head__t">
        <h2 class="h2" id="surfaces-t"><span class="g">Real usage looks like this.</span> Each context sets a requirement.</h2>
      </div>
      <div class="twa-head__l">
        <p class="lead">The people who will use the product are rarely at a desk on a fast connection. Four contexts we design and test for, and the requirement each one imposes on the build before a line of code is written.</p>
      </div>
    </div>

    <!-- PLACEHOLDER: reference photographs (Unsplash) — confirm before launch -->
    <div class="twa-sf">
      <?php foreach ([[0, 2], [1, 3]] as $twa_col => $twa_ids): ?>
      <div class="twa-sf__col twa-sf__col--<?= $twa_col ?>">
        <?php foreach ($twa_ids as $twa_i): $twa_s = $twa_sf[$twa_i]; ?>
        <article class="twa-sf__item twa-sf__item--<?= $twa_i ?>" style="order:<?= $twa_i ?>" aria-labelledby="surfaces-h<?= $twa_i ?>">
          <figure class="twa-sf__fig">
            <span class="bdh-img twa-sf__img" data-bdh-parallax="0.05">
              <img src="<?= xe_url('assets/imgs/tech/websites-apps/' . $twa_s[0]) ?>" width="<?= $twa_s[1] ?>" height="<?= $twa_s[2] ?>" alt="<?= e($twa_s[4]) ?>" loading="lazy" decoding="async" style="object-position:<?= e($twa_s[3]) ?>">
            </span>
            <span class="twa-ph__frame" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
            <span class="twa-sf__tag" aria-hidden="true"><b><?= sprintf('%02d', $twa_i + 1) ?></b><?= e($twa_s[5]) ?></span>
            <span class="twa-sf__pin<?= $twa_s[10] > 60 ? ' twa-sf__pin--l' : '' ?>" aria-hidden="true" style="--x:<?= $twa_s[10] ?>%;--y:<?= $twa_s[11] ?>%" data-bdh-live><i class="twa-sf__ring"></i><b><?= e($twa_s[12]) ?></b></span>
          </figure>
          <div class="twa-sf__card" data-rv>
            <p class="twa-sf__ctx"><?= xt_icon($twa_s[13], ['size' => 20]) ?><span>Context <?= sprintf('%02d', $twa_i + 1) ?> · <?= e($twa_s[5]) ?></span></p>
            <p class="twa-sf__scene"><?= e($twa_s[6]) ?></p>
            <p class="twa-sf__rk">Requirement</p>
            <h3 class="twa-sf__req" id="surfaces-h<?= $twa_i ?>"><?= e($twa_s[7]) ?></h3>
            <ul class="twa-sf__spec">
              <?php foreach ($twa_s[8] as $twa_sp): ?><li><?= e($twa_sp) ?></li><?php endforeach; ?>
            </ul>
            <p class="twa-sf__tags bdh-tags"><?php foreach ($twa_s[9] as $twa_tg): ?><span class="bdh-tag"><?= e($twa_tg) ?></span><?php endforeach; ?></p>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
