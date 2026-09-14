<?php /* DRAFT COPY — review before launch */
/* Inception to delivery — the programme map. A week ruler with eight stage bars (buttons in a
   tablist) and three decision gates; choosing a stage opens its detail pane below.
   PLACEHOLDER: illustrative timings — confirm before launch. */
$jr_weeks = 20;
$jr_stages = [
    // [name, weeks label, start wk, end wk, summary, decision, artefacts, people, AI assist]
    ['Discovery & audit',       'Wk 01–03', 1, 3,
     'What the brand has to do for the business, what exists today, and what is in scope.',
     'Scope and ambition, agreed by the sponsor.',
     ['Brand audit', 'Touchpoint inventory', 'Stakeholder map'],
     'Sponsor, brand lead and our engagement director.',
     'Touchpoints crawled and clustered; drift flagged for a person to review.'],
    ['Research & insight',      'Wk 02–05', 2, 5,
     'Customers, employees and the category, heard directly and read at volume.',
     'Which audiences matter most, and what they need.',
     ['Interview synthesis', 'Audience definitions', 'Category read'],
     'Customers, sales and service teams, our research lead.',
     'Transcripts and reviews synthesised into themes, every finding linked to its source.'],
    ['Strategy & positioning',  'Wk 05–07', 5, 7,
     'Purpose, positioning and principles drafted, argued over and tightened.',
     'A positioning the leadership team signs.',
     ['Brand foundation', 'Positioning statement', 'Growth thesis'],
     'The executive team.',
     'Positioning options stress-tested against competitor messaging.'],
    ['Architecture & naming',   'Wk 06–09', 6, 9,
     'Every brand and product given a place, a relationship and a naming rule.',
     'Portfolio model and naming rules.',
     ['Architecture model', 'Naming system', 'Migration outline'],
     'Portfolio owners, product leads and legal.',
     'Name candidates screened for language issues across target markets; legal clearance stays with counsel.'],
    ['Identity design',         'Wk 08–13', 8, 13,
     'Visual, verbal and behavioural identity designed together and shown on real touchpoints.',
     'One direction, chosen on real touchpoints.',
     ['Direction boards', 'Visual & verbal identity', 'Motion principles'],
     'Brand lead, design leads and pilot markets.',
     'Directions rendered across the full touchpoint inventory for testing.'],
    ['System & guidelines',     'Wk 12–16', 12, 16,
     'Tokens, components, templates and living guidelines built from the chosen identity.',
     'What is fixed, what flexes, and who approves change.',
     ['Design tokens', 'Template library', 'Living guidelines'],
     'Product design, marketing operations and IT.',
     'Rules written as machine-readable tokens and checks that tools and agents can apply.'],
    ['Activation & rollout',    'Wk 15–20', 15, 20,
     'The brand launched market by market, with teams and partners trained to use it.',
     'Launch sequence by market and channel.',
     ['Rollout plan', 'Launch templates', 'Team training'],
     'Market leads, agencies and internal communications.',
     'Localised variants generated within guardrails; every output checked and logged.'],
    ['Governance & evolution',  'Wk 18 → ongoing', 18, 20,
     'Ownership, measurement and a release cadence, so the brand keeps improving after launch.',
     'How the brand is owned, measured and changed.',
     ['Governance model', 'Brand health tracker', 'Release cadence'],
     'The brand council.',
     'Brand check monitors live assets and reports drift to the brand owner.'],
];
$jr_gates = [[7, 'Positioning signed'], [11, 'Direction chosen'], [18, 'Launch']];
$jr_pad = fn (int $n): string => str_pad((string) $n, 2, '0', STR_PAD_LEFT);
?>
<section class="band bdh-journey" id="journey" aria-labelledby="journey-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Inception to delivery</p>
        <h2 class="h2" id="journey-t"><span class="g">From the first conversation</span> to a brand your teams can run.</h2>
      </div>
      <div><p class="lead">Eight stages, one accountable team. Every stage ends in a decision and an artefact you keep. Timings are typical for an enterprise programme and scale with scope.</p></div>
    </div>

    <div class="bdh-jr__map" data-rv data-rv-d="80">
      <div class="bdh-jr__top">
        <span class="bdh-jr__cap">Typical enterprise programme <span class="bdh-ill">Illustrative</span></span>
        <span class="bdh-jr__legend" aria-hidden="true"><span><i class="is-bar"></i>Stage</span><span><i class="is-gate"></i>Decision gate</span></span>
      </div>

      <div class="bdh-scroll-x bdh-jr__scroll" tabindex="0" aria-label="Programme map — scroll sideways to see every week">
        <div class="bdh-jr__chart" style="--weeks:<?= $jr_weeks ?>">
          <div class="bdh-jr__ruler" aria-hidden="true"><span>Week</span><?php for ($jr_w = 1; $jr_w <= $jr_weeks; $jr_w++): ?><span><?= $jr_pad($jr_w) ?></span><?php endfor; ?></div>

          <div class="bdh-jr__rows" role="tablist" aria-label="Programme stages" aria-orientation="vertical">
            <?php foreach ($jr_stages as $jr_i => $jr_s): ?>
              <button class="bdh-jr__row" type="button" role="tab" id="journey-t<?= $jr_i ?>" aria-controls="journey-p<?= $jr_i ?>"
                      aria-selected="<?= $jr_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $jr_i === 0 ? '0' : '-1' ?>" style="--s:<?= $jr_s[2] ?>;--e:<?= $jr_s[3] ?>">
                <span class="bdh-jr__lbl"><b><?= $jr_pad($jr_i + 1) ?></b><span><?= e($jr_s[0]) ?></span></span>
                <span class="bdh-jr__wk"><?= e($jr_s[1]) ?></span>
                <span class="bdh-jr__track" aria-hidden="true"><i class="bdh-jr__bar<?= $jr_i === 7 ? ' is-ongoing' : '' ?>" style="--i:<?= $jr_i ?>"></i></span>
              </button>
            <?php endforeach; ?>
          </div>

          <?php foreach ($jr_gates as $jr_g): ?>
            <span class="bdh-jr__gate" style="--w:<?= $jr_g[0] ?>" aria-hidden="true"><i></i><b><?= e($jr_g[1]) ?></b></span>
          <?php endforeach; ?>
          <span class="bdh-jr__play" aria-hidden="true"></span>
        </div>
      </div>
    </div>

    <div class="bdh-panes bdh-jr__panes">
      <?php foreach ($jr_stages as $jr_i => $jr_s): ?>
        <div class="bdh-pane bdh-jr__pane<?= $jr_i === 0 ? ' is-on' : '' ?>" id="journey-p<?= $jr_i ?>" role="tabpanel" aria-labelledby="journey-t<?= $jr_i ?>">
          <div class="bdh-jr__intro">
            <span class="bdh-jr__big" aria-hidden="true"><?= $jr_pad($jr_i + 1) ?></span>
            <h3 class="bdh-jr__h"><?= e($jr_s[0]) ?></h3>
            <p class="bdh-jr__sum"><?= e($jr_s[4]) ?></p>
            <p class="bdh-meta"><span><?= e($jr_s[1]) ?></span><span>Typical</span></p>
          </div>
          <dl class="bdh-jr__cells">
            <div><dt>The decision</dt><dd><?= e($jr_s[5]) ?></dd></div>
            <div><dt>What you get</dt><dd class="bdh-tags"><?php foreach ($jr_s[6] as $jr_a): ?><span class="bdh-tag"><?= e($jr_a) ?></span><?php endforeach; ?></dd></div>
            <div><dt>Who is in the room</dt><dd><?= e($jr_s[7]) ?></dd></div>
            <div class="is-ai"><dt><span class="bdh-tag bdh-tag--blue">✦ Where AI assists</span></dt><dd><?= e($jr_s[8]) ?></dd></div>
          </dl>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="bdh-jr__nav">
      <span class="bdh-jr__count" aria-live="polite">Stage <b>01</b> of <?= $jr_pad(count($jr_stages)) ?></span>
      <button class="bdh-jr__btn" type="button" data-dir="-1" aria-label="Previous stage">‹</button>
      <button class="bdh-jr__btn" type="button" data-dir="1" aria-label="Next stage">›</button>
    </div>
  </div>
</section>
