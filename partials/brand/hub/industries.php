<?php /* DRAFT COPY — review before launch */
/* Industries — eight expanding photo panels (an accordion on small screens). */
$ind_sectors = [
    // [name, line, priorities, constraint, photo, w, h, alt, object-position]
    ['Financial services', 'Trust is the product.',
     ['Clarity under regulation', 'Consistent disclosures across channels', 'A digital identity that still reads as secure'],
     'Regulated communications · approval workflows', 'financial.jpg', 674, 1200, 'Glass office towers in a financial district', '50% 50%'],
    ['Healthcare & life sciences', 'Every word is reviewed.',
     ['Patient and professional audiences in one system', 'Plain language and accessibility', 'Product brands under a corporate master'],
     'Medical, legal and regulatory review', 'healthcare.jpg', 800, 1200, 'A scientist using a pipette in a laboratory', '50% 40%'],
    ['Technology & SaaS', 'The product changes monthly. The brand can’t.',
     ['Tokens shared with the product UI', 'Naming for fast-growing feature sets', 'One voice for developers and enterprise buyers'],
     'Release cadence · product surfaces', 'technology.jpg', 1200, 900, 'Close-up of server hardware in a data centre', '50% 50%'],
    ['Consumer & retail', 'Won or lost on a shelf and a screen.',
     ['Packaging systems that scale across ranges', 'Seasonal flex without drift', 'Content at marketplace volume'],
     'Retailer and marketplace specs', 'retail.jpg', 800, 1200, 'A minimal clothing store interior', '50% 50%'],
    ['Industrial & manufacturing', 'Complex portfolios, long buying cycles.',
     ['Architecture across divisions and acquired brands', 'Technical documentation as a touchpoint', 'An employer brand that attracts engineers'],
     'Distributor networks · multilingual technical content', 'industrial.jpg', 800, 1200, 'Engineers working on the floor of a manufacturing plant', '50% 50%'],
    ['Energy & utilities', 'Under public and regulatory scrutiny.',
     ['A transition story backed by evidence', 'Clear customer communication', 'Safety-critical signage and fleet'],
     'Claims scrutiny · regulated customer communications', 'energy.jpg', 1200, 800, 'Wind turbines across a rolling landscape', '50% 50%'],
    ['Public sector & institutions', 'Accessible to everyone, by design.',
     ['Accessibility built into every token', 'Plain language', 'An identity that scales across departments and services'],
     'Accessibility standards · procurement frameworks', 'public.jpg', 1200, 675, 'The white shelves and stairs of a modern public library', '50% 50%'],
    ['Hospitality & real estate', 'The brand is a place.',
     ['Wayfinding and environmental design', 'Architecture across properties', 'A consistent experience across owners and operators'],
     'Owner–operator models · physical rollout', 'hospitality.jpg', 1200, 675, 'A modern hotel lobby with a marble reception desk', '50% 50%'],
];
?>
<section class="band band--alt bdh-industries" id="industries" aria-labelledby="industries-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Industries</p>
        <h2 class="h2" id="industries-t"><span class="g">Same discipline,</span> different stakes in every sector.</h2>
      </div>
      <div>
        <p class="lead">Regulation, buying cycles and where the brand is experienced change what good looks like. We start from the constraints of your sector.</p>
        <a class="tl" href="<?= xe_url('industries.php') ?>">Industries we serve <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <!-- PLACEHOLDER: reference photography (Unsplash) — replace with commissioned/own imagery before launch -->
    <div class="bdh-ind__rail" data-rv data-rv-d="80">
      <?php foreach ($ind_sectors as $ind_i => $ind_s): $ind_n = str_pad((string) ($ind_i + 1), 2, '0', STR_PAD_LEFT); $ind_open = $ind_i === 0; ?>
        <div class="bdh-ind__panel<?= $ind_open ? ' is-open' : '' ?>">
          <figure class="bdh-img bdh-ind__img">
            <img src="<?= xe_url('assets/imgs/brand/hub/industries/' . $ind_s[4]) ?>" alt="<?= e($ind_s[7]) ?>" width="<?= $ind_s[5] ?>" height="<?= $ind_s[6] ?>" loading="lazy" decoding="async" style="object-position:<?= e($ind_s[8]) ?>">
          </figure>
          <button class="bdh-ind__btn" type="button" id="industries-b<?= $ind_i ?>" aria-expanded="<?= $ind_open ? 'true' : 'false' ?>" aria-controls="industries-c<?= $ind_i ?>">
            <span class="bdh-ind__idx"><?= $ind_n ?></span>
            <span class="bdh-ind__name"><?= e($ind_s[0]) ?></span>
            <span class="bdh-ind__plus" aria-hidden="true"></span>
          </button>
          <div class="bdh-ind__card" id="industries-c<?= $ind_i ?>" role="region" aria-labelledby="industries-b<?= $ind_i ?>">
            <p class="bdh-ind__k"><span class="bdh-idx"><?= $ind_n ?></span>Sector</p>
            <h3 class="bdh-t bdh-t--l"><?= e($ind_s[0]) ?></h3>
            <p class="bdh-ind__line"><?= e($ind_s[1]) ?></p>
            <ul class="bdh-bullets"><?php foreach ($ind_s[2] as $ind_p): ?><li><?= e($ind_p) ?></li><?php endforeach; ?></ul>
            <span class="bdh-tag"><?= e($ind_s[3]) ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
