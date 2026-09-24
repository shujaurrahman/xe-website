<?php /* DRAFT COPY — review before launch */ ?>
<?php
$ind_cols = [
    ['Advertising & claims', 'ASCI, CCPA, SEBI codes'],
    ['Sector regulator', 'RBI, TRAI, drug law'],
    ['Payments', 'PCI DSS v4.0.1'],
    ['Personal data', 'DPDP Act, GDPR'],
    ['Accessibility', 'WCAG 2.2 AA'],
    ['AI governance', 'EU AI Act, OWASP LLM'],
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
?>
<section class="band ind-hero" id="top" aria-labelledby="ind-hero-t">
  <span class="dots ind-hero__dots" aria-hidden="true"></span>
  <div class="wrap ind-hero__grid">
    <div class="ind-hero__say">
      <p class="lbl lbl--blue"><span class="dot"></span>Industries · six sectors</p>
      <h1 class="d1" id="ind-hero-t"><span class="g">Built to the rules</span> your category plays by.</h1>
      <p class="lead">The same six disciplines, applied under very different constraints. We start from what regulators, platforms and customers already expect of your sector — then design the brand, the product and the systems to meet it.</p>
      <div class="ind-hero__cta">
        <a class="btn btn--ink btn--lg" href="#explorer">Explore the sectors <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out btn--lg" href="<?= xe_url('contact.php') ?>">Talk about your sector <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <figure class="ind-map" data-ind-map>
      <figcaption class="ind-map__cap">
        <span class="bdh-ro">Constraint map</span>
        <span class="ind-map__key" aria-hidden="true"><i class="ind-lv ind-lv--1"></i>Sometimes <i class="ind-lv ind-lv--2"></i>Often <i class="ind-lv ind-lv--3"></i>Most work</span>
      </figcaption>
      <div class="bdh-scroll-x mask-x ind-map__scroll" tabindex="0" role="region" aria-label="Constraint map: which rules shape the work in each sector">
        <table class="ind-map__t">
          <caption class="sr">How heavily each area of regulation typically shapes our work in each sector, from sometimes to most of the work.</caption>
          <thead><tr><th scope="col" class="ind-map__corner">Sector</th>
            <?php foreach ($ind_cols as $ind_c): ?><th scope="col"><span class="ind-map__ch"><?= e($ind_c[0]) ?></span><span class="ind-map__cs"><?= e($ind_c[1]) ?></span></th><?php endforeach; ?>
          </tr></thead>
          <tbody>
          <?php foreach ($IND as $ind_s): ?>
            <tr><th scope="row"><a href="#<?= e($ind_s['id']) ?>"><span class="ind-map__n"><?= e($ind_s['n']) ?></span><?= e($ind_s['name']) ?></a></th>
            <?php foreach ($ind_map[$ind_s['id']] as $ind_ci => $ind_v): ?>
              <td><i class="ind-lv ind-lv--<?= $ind_v ?>" style="--ci:<?= $ind_ci ?>" aria-hidden="true"></i><span class="sr"><?= e($ind_lv[$ind_v]) ?></span></td>
            <?php endforeach; ?></tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <p class="ind-map__note sm">Our reading of typical programmes, not legal advice. Each dossier below names the specific rules.</p>
    </figure>
  </div>
</section>
