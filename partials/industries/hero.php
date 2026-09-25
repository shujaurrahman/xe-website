<?php /* DRAFT COPY — review before launch */ ?>
<?php
$ind_cols = [
    ['Advertising & claims', 'ASCI, CCPA, SEBI codes', 'Claims'],
    ['Sector regulator', 'RBI, TRAI, drug law', 'Regulator'],
    ['Payments', 'PCI DSS v4.0.1', 'Payments'],
    ['Personal data', 'DPDP Act, GDPR', 'Data'],
    ['Accessibility', 'WCAG 2.2 AA', 'Access'],
    ['AI governance', 'EU AI Act, OWASP LLM', 'AI'],
];
$ind_map = [
    'consumer-health'    => [3, 3, 1, 2, 2, 2],
    'financial-services' => [2, 3, 3, 3, 2, 2],
    'retail-commerce'    => [2, 2, 3, 3, 2, 1],
    'b2b-technology'     => [1, 1, 1, 3, 2, 3],
    'hospitality'        => [2, 1, 3, 3, 2, 1],
    'telecom-media'      => [2, 3, 1, 3, 2, 2],
];
$ind_lv = [1 => 'Sometimes shapes the work', 2 => 'Often shapes the work', 3 => 'Shapes most of the work'];
/* the readout under the map title is counted from the map itself, so the sentence can never drift from the grid */
$ind_tally = [1 => 0, 2 => 0, 3 => 0];
foreach ($ind_map as $ind_row) { foreach ($ind_row as $ind_v) $ind_tally[$ind_v]++; }
$ind_cells = array_sum($ind_tally);
/* capability pages that actually exist under services/<discipline>/ — counted, never asserted */
$ind_caps_live = 0;
foreach ($SITE['disciplines'] as $ind_dd) {
    foreach ($ind_dd['caps'] as $ind_cc) {
        if (!empty($ind_cc[2]) && is_file(__DIR__ . '/../../services/' . $ind_dd['slug'] . '/' . $ind_cc[2] . '.php')) $ind_caps_live++;
    }
}
?>
<section class="band ind-hero" id="top" aria-labelledby="ind-hero-t">
  <span class="dots ind-hero__dots" aria-hidden="true"></span>
  <div class="wrap ind-hero__grid">
    <div class="ind-hero__say">
      <p class="lbl lbl--blue"><span class="dot"></span>Industries · six sectors</p>
      <h1 class="d1" id="ind-hero-t"><span class="g">Built to the rules</span> your category plays by.</h1>
      <p class="lead">The same six disciplines, applied under very different constraints. We start from what regulators, platforms and customers already expect of your sector — then design the brand, the product and the systems to meet it.</p>
      <div class="ind-hero__cta">
        <a class="btn btn--ink btn--lg" href="#console">Build a draft brief <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out btn--lg" href="#explorer">Explore the sectors <span class="i" aria-hidden="true">›</span></a>
      </div>
      <dl class="ind-hero__proof">
        <div><dt>Sectors</dt><dd><?= count($IND) ?></dd></div>
        <div><dt>Disciplines</dt><dd><?= count($SITE['disciplines']) ?></dd></div>
        <div><dt>Capability pages</dt><dd><?= $ind_caps_live ?></dd></div>
        <div><dt>Markets covered</dt><dd class="ind-hero__mk">IN · EU · US</dd></div>
      </dl>
    </div>

    <figure class="ind-map" data-ind-map>
      <figcaption class="ind-map__cap">
        <span class="bdh-ro">Constraint map</span>
        <span class="ind-map__key" aria-hidden="true"><span><span class="ind-meter ind-meter--sm" data-v="1"><i></i><i></i><i></i></span>Sometimes</span><span><span class="ind-meter ind-meter--sm" data-v="2"><i></i><i></i><i></i></span>Often</span><span><span class="ind-meter ind-meter--sm" data-v="3"><i></i><i></i><i></i></span>Most work</span></span>
      </figcaption>
      <div class="bdh-scroll-x mask-x ind-map__scroll" tabindex="0" role="region" aria-label="Constraint map: which rules shape the work in each sector">
        <table class="ind-map__t">
          <caption class="sr">How heavily each area of regulation typically shapes our work in each sector, from sometimes to most of the work.</caption>
          <thead><tr><th scope="col" class="ind-map__corner">Sector</th>
            <?php foreach ($ind_cols as $ind_c): ?><th scope="col"><span class="ind-map__ch"><?= e($ind_c[0]) ?></span><span class="ind-map__ab" aria-hidden="true"><?= e($ind_c[2]) ?></span><span class="ind-map__cs"><?= e($ind_c[1]) ?></span></th><?php endforeach; ?>
          </tr></thead>
          <tbody>
          <?php foreach ($IND as $ind_s): ?>
            <tr><th scope="row"><a href="#<?= e($ind_s['id']) ?>"><span class="ind-map__n"><?= e($ind_s['n']) ?></span><?= e($ind_s['name']) ?></a></th>
            <?php foreach ($ind_map[$ind_s['id']] as $ind_ci => $ind_v): ?>
              <td><span class="ind-meter ind-meter--sm" data-v="<?= $ind_v ?>" style="--i:<?= $ind_ci ?>" aria-hidden="true"><i></i><i></i><i></i></span><span class="sr"><?= e($ind_lv[$ind_v]) ?></span></td>
            <?php endforeach; ?></tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <p class="ind-map__tally bdh-ro" aria-hidden="true"><?= $ind_cells ?> cells · <b><?= $ind_tally[3] ?></b> shape most of the work · <b><?= $ind_tally[2] ?></b> often · <b><?= $ind_tally[1] ?></b> sometimes</p>
      <p class="ind-map__note sm">Our reading of typical programmes, not legal advice. <a class="tl" href="#rulebook">See exactly what applies, and what does not <span class="i" aria-hidden="true">›</span></a><span class="ind-map__swipe"> Swipe the table for all six areas.</span></p>
    </figure>
  </div>
</section>
