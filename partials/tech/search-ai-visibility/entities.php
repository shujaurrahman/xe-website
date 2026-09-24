<?php /* DRAFT COPY — review before launch */
/* Entities (paper) — making the machines sure who you are. A knowledge graph with the placeholder
   company at the centre and eight typed edges radiating out, beside the JSON-LD that declares them.
   The graph is an SVG: edges draw and nodes settle when the block enters, and the JSON-LD lines
   reveal on the same stagger, so the picture and the code arrive together. Below 620px the drawing
   is dropped rather than squeezed — its labels would render at roughly half the site's smallest
   type — and the key beneath it carries every property, its node type and what it earns in words. Motion is CSS only,
   keyed off .is-in the way the rest of the page is; under reduced motion it is all shown at once.
   Every value below is a placeholder for the example company; none of it describes Xterra Edze. */

/* An edge runs between two boxes, not between their centres: drawn centre-to-centre it would cross
   the centre card and the node card it points at. Given both boxes, this returns where the line
   should start and stop — the point at which the ray leaves each box, plus a small breathing gap. */
$tsv_en_edge = static function (float $ax, float $ay, float $ahw, float $ahh,
                                float $bx, float $by, float $bhw, float $bhh, float $gap = 7.0): array {
    $dx = $bx - $ax;
    $dy = $by - $ay;
    $len = sqrt($dx * $dx + $dy * $dy);
    if ($len < 0.001) {
        return [$ax, $ay, $bx, $by];
    }
    $ux = $dx / $len;
    $uy = $dy / $len;
    /* how far along the ray a box of this size is left: whichever side it reaches first */
    $leaves = static fn (float $hw, float $hh): float => min(
        abs($ux) > 1e-6 ? $hw / abs($ux) : INF,
        abs($uy) > 1e-6 ? $hh / abs($uy) : INF
    );
    $from = $leaves($ahw, $ahh) + $gap;
    $to   = $len - ($leaves($bhw, $bhh) + $gap);
    if ($to <= $from) {          // boxes overlap or nearly touch: no edge worth drawing
        $from = $to = $len / 2;
    }
    return [
        round($ax + $ux * $from, 1), round($ay + $uy * $from, 1),
        round($ax + $ux * $to, 1),   round($ay + $uy * $to, 1),
    ];
};

/* [x, y, box width, schema type, the property that connects it, what it earns] */
/* The two side nodes sit further out than a circle would put them: at equal radius their boxes and
   the centre card nearly touch, leaving no room to draw the edge between them. */
$tsv_en_nodes = [
    [320,  50, 132, 'Product',        'makesOffer',      'What you sell, named consistently'],
    [455,  95, 128, 'Person',         'employee',        'Named authors and spokespeople'],
    [536, 200, 148, 'PostalAddress',  'address',         'One address, everywhere the same'],
    [455, 305, 126, 'Review',         'review',          'Ratings you did not write yourself'],
    [320, 350, 132, 'sameAs',         'profiles',        'The profiles that confirm the entity'],
    [185, 305, 126, 'Article',        'author',          'Who wrote it, and when it changed'],
    [104, 200, 132, 'FAQPage',        'mainEntity',      'Questions, answered on the page'],
    [185,  95, 156, 'BreadcrumbList', 'itemListElement', 'Where the page sits in the site'],
];

/* the JSON-LD panel: [indent level, line]. Illustrative values for the placeholder company. */
$tsv_en_json = [
    [0, '{'],
    [1, '"@context": "https://schema.org",'],
    [1, '"@type": "Organization",'],
    [1, '"@id": "https://yourcompany.com/#organization",'],
    [1, '"name": "Your company",'],
    [1, '"url": "https://yourcompany.com/",'],
    [1, '"logo": "https://yourcompany.com/logo.png",'],
    [1, '"description": "Payroll and compliance software'],
    [1, '  for mid-size companies in India.",'],
    [1, '"foundingDate": "2014",'],
    [1, '"address": {'],
    [2, '"@type": "PostalAddress",'],
    [2, '"addressLocality": "Bengaluru",'],
    [2, '"addressRegion": "KA",'],
    [2, '"addressCountry": "IN"'],
    [1, '},'],
    [1, '"contactPoint": [{'],
    [2, '"@type": "ContactPoint",'],
    [2, '"contactType": "sales",'],
    [2, '"areaServed": "IN"'],
    [1, '}],'],
    [1, '"sameAs": ['],
    [2, '"https://www.linkedin.com/company/yourcompany",'],
    [2, '"https://www.wikidata.org/wiki/Q00000000",'],
    [2, '"https://github.com/yourcompany"'],
    [1, ']'],
    [0, '}'],
];

$tsv_en_types = [   // [type, where it goes, what it can earn]
    ['Organization', 'Once, sitewide, with a stable @id', 'A consistent entity every engine can resolve'],
    ['Product / Offer', 'Product and pricing pages', 'Price, availability and rating in the result'],
    ['Article + author', 'Every editorial page', 'A named, checkable author behind the claim'],
    ['FAQPage', 'Pages that genuinely answer questions', 'Eligibility only — Google restricted FAQ rich results to authoritative government and health sites in 2023'],
    ['BreadcrumbList', 'Every page below the home page', 'A readable path instead of a raw URL'],
];

$tsv_en_nap = [
    ['One legal name', 'The same registered name on the site, the profiles and the filings. Trading names go in <code>alternateName</code>, never in place of the legal one.'],
    ['One address, one number', 'Identical formatting everywhere, down to the punctuation. Conflicting details are the most common reason an entity stays ambiguous.'],
    ['One canonical URL per entity', 'A stable <code>@id</code> that never changes, so every later reference resolves to the same thing.'],
    ['Claimed profiles', 'Business profiles, professional networks and developer or industry directories, claimed and kept current, then declared in <code>sameAs</code>.'],
];
?>
<section class="band tsv-ent" id="entities" aria-labelledby="entities-t">
  <div class="wrap">

    <header class="tsv-head" data-rv>
      <div class="tsv-head__t">
        <p class="tsv-kick"><span class="tsv-kick__ref">04 · Entities</span><span>Structured data</span></p>
        <h2 class="h2" id="entities-t"><span class="g">Make the machines sure</span> who you are.</h2>
      </div>
      <div class="tsv-head__l">
        <p class="lead">An engine cannot cite a company it is not certain exists. Structured data and consistent facts turn a set of pages into one resolvable entity — a thing with a name, an address, products, people and a paper trail that agrees with itself.</p>
      </div>
    </header>

    <div class="tsv-ent__grid">

      <div class="tsv-ent__graph" data-rv>
        <div class="tsv-graph">
          <svg viewBox="0 0 640 400" class="tsv-graph__svg" role="img"
               aria-label="A knowledge graph: the placeholder company at the centre, connected by eight typed edges to Product, Person, PostalAddress, Review, sameAs, Article, FAQPage and BreadcrumbList.">
            <g class="tsv-graph__edges">
              <?php foreach ($tsv_en_nodes as $tsv_eni => $tsv_enn):
                  [$tsv_ex1, $tsv_ey1, $tsv_ex2, $tsv_ey2] =
                      $tsv_en_edge(320, 200, 82, 27, (float) $tsv_enn[0], (float) $tsv_enn[1], $tsv_enn[2] / 2, 21); ?>
                <line class="tsv-graph__e" x1="<?= $tsv_ex1 ?>" y1="<?= $tsv_ey1 ?>" x2="<?= $tsv_ex2 ?>" y2="<?= $tsv_ey2 ?>" style="--i:<?= $tsv_eni ?>"/>
              <?php endforeach; ?>
            </g>

            <g class="tsv-graph__nodes">
              <?php foreach ($tsv_en_nodes as $tsv_eni => $tsv_enn):
                  $tsv_enw = (int) $tsv_enn[2]; ?>
                <g class="tsv-graph__n" transform="translate(<?= (int) $tsv_enn[0] ?>,<?= (int) $tsv_enn[1] ?>)" style="--i:<?= $tsv_eni ?>">
                  <rect x="<?= -intdiv($tsv_enw, 2) ?>" y="-21" width="<?= $tsv_enw ?>" height="42" rx="9"/>
                  <text class="tsv-graph__nt" text-anchor="middle" y="-3"><?= e($tsv_enn[3]) ?></text>
                  <text class="tsv-graph__np" text-anchor="middle" y="12"><?= e($tsv_enn[4]) ?></text>
                </g>
              <?php endforeach; ?>
            </g>

            <g class="tsv-graph__c" transform="translate(320,200)">
              <rect x="-82" y="-27" width="164" height="54" rx="11"/>
              <text class="tsv-graph__ct" text-anchor="middle" y="-4">Your company</text>
              <text class="tsv-graph__cp" text-anchor="middle" y="13">Organization · @id</text>
            </g>
          </svg>
        </div>

        <ul class="tsv-graph__key" role="list">
          <?php foreach ($tsv_en_nodes as $tsv_enn): ?>
            <li><b><?= e($tsv_enn[4]) ?></b><i><?= e($tsv_enn[3]) ?></i><span><?= e($tsv_enn[5]) ?></span></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="tsv-ent__code" data-rv data-rv-d="120">
        <div class="tsv-win">
          <p class="tsv-win__bar">
            <span class="tsv-win__dots" aria-hidden="true"><i></i><i></i><i></i></span>
            <span class="tsv-win__path"><b>yourcompany.com</b> · /#organization</span>
            <span class="tsv-win__end"><?= xt_logo('schemaorg', ['size' => 22, 'hidden' => true]) ?></span>
          </p>
          <div class="tsv-json" aria-hidden="true">
            <p class="tsv-json__k">application/ld+json</p>
            <div class="tsv-json__code">
              <?php foreach ($tsv_en_json as $tsv_eji => $tsv_ej): ?>
                <span class="tsv-json__l" style="--i:<?= $tsv_eji ?>;--ind:<?= (int) $tsv_ej[0] ?>"><?= e($tsv_ej[1]) ?></span>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <p class="bdh-sr">An illustrative JSON-LD block for the placeholder company: an Organization with a stable identifier, name, URL, logo, description, founding date, a postal address in Bengaluru, a sales contact point for India, and three sameAs profiles.</p>

        <p class="tsv-note">
          <?= xt_icon('alert', ['size' => 18]) ?>
          <span><b>What markup does and does not do.</b> Valid structured data makes a page <em>eligible</em> for a rich result and helps an engine resolve your entity. It does not guarantee a rich result, and it does not rank a page. Google also states that no extra markup is required for its AI features beyond following Search Essentials. We mark up what is true on the page, and nothing that is not.</span>
        </p>
      </div>

    </div>

    <div class="tsv-ent__foot">
      <div class="tsv-ent__types" data-rv>
        <h3 class="tsv-sub">Types we implement, and where</h3>
        <ul class="tsv-types" role="list">
          <?php foreach ($tsv_en_types as $tsv_ent): ?>
            <li>
              <span class="tsv-types__t"><?= e($tsv_ent[0]) ?></span>
              <span class="tsv-types__w"><?= e($tsv_ent[1]) ?></span>
              <span class="tsv-types__e"><?= e($tsv_ent[2]) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="tsv-ent__nap" data-rv data-rv-d="80">
        <h3 class="tsv-sub">Facts that must agree with themselves</h3>
        <ul class="tsv-nap" role="list">
          <?php foreach ($tsv_en_nap as $tsv_eni => $tsv_enp): ?>
            <li>
              <span class="tsv-nap__n"><?= str_pad((string) ($tsv_eni + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <b><?= e($tsv_enp[0]) ?></b>
              <small><?= $tsv_enp[1] ?></small>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

  </div>
</section>
