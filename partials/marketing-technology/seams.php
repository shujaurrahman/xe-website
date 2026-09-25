<?php /* DRAFT COPY — review before launch */
/* Seams — why this discipline exists. Almost nobody is short of marketing tools; the value leaks at the
   joins. One code-drawn diagram of what we build instead (the systems that feed the record, the record,
   and the systems that act on it), then the seven joins that leak, each with the capability that closes it.
   No JavaScript: the diagram is decorative with a spoken-word description beside it, and the rows are static.
   The connectors are routed by mth_edge() so each stops at the box edge instead of the box centre. */
$sea_srcs = [
    ['Commerce',     'orders · carts · catalogue'],
    ['CRM',          'contacts · deals · activity'],
    ['Service',      'tickets · calls · outcomes'],
    ['Web & app',    'events · forms · sessions'],
];
$sea_dests = [
    ['Email · SMS · WhatsApp', 'journeys · templates'],
    ['Paid media',             'audiences · exclusions'],
    ['Site & app',             'content · personalisation'],
    ['Sales',                  'tasks · quotes · routing'],
];
/* stage geometry, 1000 × 300 */
$sea_xs   = [170, 385, 600, 815];
$sea_spine = mth_box(500, 150, 880, 58);
$sea_top  = array_map(fn ($sea_x) => mth_box($sea_x, 42, 180, 54), $sea_xs);
$sea_bot  = array_map(fn ($sea_x) => mth_box($sea_x, 258, 180, 54), $sea_xs);

/* the seven joins. Each 'glyph' is a 44 × 24 mark: solid where the join holds, dashed where it breaks. */
$sea_rows = [
    ['Identity',
     'The same person is four records: one in commerce, one in the CRM, one in the service desk, one in the ad platform.',
     'Segments nobody trusts, duplicate contact, and a lifetime value figure no one will sign.',
     'customer-relationship-strategy',
     '<rect x="2" y="3" width="11" height="7" rx="2"/><rect x="2" y="14" width="11" height="7" rx="2"/><rect class="a" x="31" y="8.5" width="11" height="7" rx="2"/><path d="M13 6.5h6M13 17.5h6"/><path class="x" d="M25 12h6"/><path class="b" d="M20.5 8.5l4 3.5-4 3.5"/>'],
    ['Consent',
     'Consent is captured at the form and then ignored at the send, because the audience was built from an export.',
     'Messages that should never have left, and a regulator\'s question you cannot answer with a record.',
     'ai-driven-marketing-automation',
     '<path d="M9 2.5 16 5v5.5c0 4-2.9 7.2-7 8.5-4.1-1.3-7-4.5-7-8.5V5z"/><path class="a" d="M5.6 10.5 8 12.8l3.8-4"/><path class="x" d="M21 12h7"/><rect x="31" y="6" width="11" height="12" rx="2"/><path class="b" d="M34 10h5M34 13.5h3"/>'],
    ['Content',
     'One price change means six places to retype it, and one of them is always missed.',
     'Claims that disagree between channels, and localisation quoted as a project every time.',
     'content-communication-infrastructure',
     '<rect x="2" y="6" width="11" height="12" rx="2"/><path d="M13 9h9M13 12h9"/><path class="x" d="M13 15h9"/><path class="a" d="M30 9h12M30 12h12"/><path class="x" d="M30 15h12"/>'],
    ['Production',
     'The adaptation queue, not the media plan, decides how many variants a campaign can run.',
     'Tests that never happen, and a studio spending the week resizing instead of thinking.',
     'ai-creative-solutions',
     '<rect x="2" y="4" width="8" height="16" rx="2"/><rect x="12" y="4" width="8" height="16" rx="2"/><path class="x" d="M23 6v12"/><rect class="a" x="26" y="4" width="8" height="16" rx="2"/><rect x="36" y="4" width="6" height="16" rx="2"/>'],
    ['Measurement',
     'Three platforms each claim the same conversion, and the finance number matches none of them.',
     'Budget moved on the loudest report instead of on evidence.',
     'ai-campaign-optimization',
     '<path d="M2 20V4"/><path d="M6 20V9"/><path class="a" d="M12 20V6"/><path d="M18 20v-8"/><path class="x" d="M24 12h5"/><path d="M31 20V4M31 20h11"/><path class="b" d="M33 16l3-4 3 2.5"/>'],
    ['Qualification',
     'Sales filters the good leads out of the noise by hand, two days after the enquiry arrived.',
     'Deals lost to whoever replied first.',
     'ai-lead-generation',
     '<path d="M2 4h20L14 13v6l-4 2v-8z"/><path class="x" d="M25 12h5"/><rect class="a" x="32" y="6" width="10" height="12" rx="2"/><path class="b" d="M35 10h4M35 13.5h2.5"/>'],
    ['Handover',
     'What was promised on the call never reaches the CRM, so the next message contradicts it.',
     'A forecast built from notes, and a customer repeating themselves.',
     'automated-dynamic-sales',
     '<rect x="2" y="6" width="12" height="12" rx="2"/><path class="a" d="M5 10h6M5 13.5h4"/><path class="x" d="M17 12h8"/><rect x="30" y="6" width="12" height="12" rx="2"/><path class="b" d="M33 12h6M36.5 9.5l2.5 2.5-2.5 2.5"/>'],
];
$sea_cap = fn (string $sea_s): array => $CAPS[$sea_s];
?>
<section class="band band--alt mth-seams" id="seams" aria-labelledby="seams-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Why this exists</p>
        <h2 class="h2" id="seams-t"><span class="g">Nobody is short of marketing tools.</span> The value leaks at the joins.</h2>
      </div>
      <div>
        <p class="lead">A stack audit almost never finds a missing product. It finds seven joins that were never built, each one quietly making the next thing harder. This page is about closing them.</p>
      </div>
    </div>

    <figure class="mth-sea__fig" data-rv data-rv-d="60">
      <p class="bdh-sr">A diagram of what we build instead of another tool: four source systems — commerce, CRM, service and web and app — feed one consented customer record, and that record feeds the four places marketing acts: email, SMS and WhatsApp; paid media; the site and app; and sales. Every arrow is a join that has to be built and maintained.</p>
      <div class="mth-stage mth-sea__stage" style="--ar:1000 / 300" aria-hidden="true">
        <svg viewBox="0 0 1000 300" focusable="false">
          <?php foreach ($sea_top as $sea_i => $sea_b): ?>
            <path class="mth-edge" d="<?= e(mth_edge($sea_b, $sea_spine, 'tee')) ?>"/>
          <?php endforeach; ?>
          <?php foreach ($sea_bot as $sea_i => $sea_b): ?>
            <path class="mth-edge" d="<?= e(mth_edge($sea_spine, $sea_b, 'tee')) ?>"/>
          <?php endforeach; ?>
        </svg>
        <?php foreach ($sea_srcs as $sea_i => $sea_s): ?>
          <span class="mth-node" style="--x:<?= $sea_xs[$sea_i] / 10 ?>;--y:14;--w:18">
            <span class="mth-node__t"><?= e($sea_s[0]) ?></span>
            <span class="mth-node__s"><?= e($sea_s[1]) ?></span>
          </span>
        <?php endforeach; ?>
        <span class="mth-node mth-sea__spine" style="--x:50;--y:50;--w:88">
          <span class="mth-node__t"><b>REC</b>One consented customer record</span>
          <span class="mth-node__s">identity resolved · consent stored with its source and scope · segments and scores attached · retention applied</span>
        </span>
        <?php foreach ($sea_dests as $sea_i => $sea_d): ?>
          <span class="mth-node" style="--x:<?= $sea_xs[$sea_i] / 10 ?>;--y:86;--w:18">
            <span class="mth-node__t"><?= e($sea_d[0]) ?></span>
            <span class="mth-node__s"><?= e($sea_d[1]) ?></span>
          </span>
        <?php endforeach; ?>
      </div>
      <figcaption class="mth-note mth-sea__cap"><b>Feeds above, actions below, one record between them.</b> Each arrow is a join. Built once, it stays correct; left to exports and spreadsheets, it leaks.</figcaption>
    </figure>

    <ol class="mth-sea__rows" data-rv-s data-rv-step="40">
      <?php foreach ($sea_rows as $sea_i => $sea_r): $sea_c = $sea_cap($sea_r[3]); ?>
        <li class="mth-sea__row">
          <span class="mth-sea__n"><?= str_pad((string) ($sea_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <svg class="mth-sea__glyph" viewBox="0 0 44 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><?= $sea_r[4] ?></svg>
          <h3 class="mth-sea__t"><?= e($sea_r[0]) ?></h3>
          <p class="mth-sea__what"><?= e($sea_r[1]) ?></p>
          <p class="mth-sea__cost"><span class="mth-k">What it costs</span><?= e($sea_r[2]) ?></p>
          <span class="mth-sea__fix">
            <span class="mth-k">Closed by</span>
            <a class="mth-capl" href="<?= e(($MTH['cap_href'])($sea_r[3])) ?>"><b><?= e($sea_c['n']) ?></b><?= e($sea_c['name']) ?><i aria-hidden="true">›</i></a>
          </span>
        </li>
      <?php endforeach; ?>
    </ol>

    <p class="mth-note mth-sea__note" data-rv>Not one of these is a product problem. Every one of them is a join, and a join is something you can build, test and hand over.</p>
  </div>
</section>
