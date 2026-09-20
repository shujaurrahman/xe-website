<?php /* DRAFT COPY — review before launch */
/* Workshop — an editorial spread. The large photograph of the long list on the wall beside who is in
   the room; below, the two days as an agenda (a pre-read written by agents, then four sessions, each
   day led by a smaller photograph), and the one-page AI strategy that leaves the room. workshop.js
   fills the page section by section and ticks the sign-off on entry; hub.js adds parallax to the
   large photograph. Photographs are scene-setting only, never clients. HTML = the finished page. */
$tas_ws_room = [   // [icon, who, what they bring]
    ['workflow', 'Operations',                 'The process as it really runs, not as the manual says.'],
    ['shield',   'Legal and privacy',          'The risk tier, the lawful basis, the steps that stay with a person.'],
    ['key',      'Security',                   'What an agent identity may touch, at what scope.'],
    ['cost',     'Finance',                    'Volumes, handling times and the true manual cost.'],
    ['users',    'The team who does the work', 'The edge cases that become the first golden set.'],
];
$tas_ws_days = [   // [day, photo, alt, pos, caption k, caption, sessions: [time, title, what happens, output], photo height at 1800 wide]
    ['Day 1', 'workshop-notes.jpg', 'Hands sort handwritten yellow notes across a blue table', '50% 55%', 'Day 1', 'Sorting the long list.', [
        ['Morning',   'The work as it really runs', 'Three to five processes walked end to end by the people who do them.', 'Process maps with baseline times'],
        ['Afternoon', 'The long list, scored',      'Every idea on the wall, scored on value, feasibility, risk and time.',  'A scored long list, usually a dozen'],
    ], 1202],
    ['Day 2', 'workshop-board.jpg', 'Two colleagues arrange sticky notes into columns on a whiteboard in a meeting room', '50% 30%', 'Day 2', 'The candidates sorted into columns.', [
        ['Morning',   'Risk and data, per candidate', 'Legal sets the tier, security the scopes, system owners the data readiness.', 'Risk tier, autonomy ceiling, data gaps'],
        ['Afternoon', 'Choose, own, measure',         'Three to build first, each with an owner, a baseline and a target.',          'The one-page strategy, signed'],
    ], 1192],
];
$tas_ws_doc = [   // [section, the line that gets written, skeleton line widths %]
    ['Ambition and measures',    'Return about 700 hours a month to sales ops and finance by the end of Q2; cost per task under a quarter of manual.', [92, 64]],
    ['Portfolio · build first',  'Reconcile vendor invoices · Draft renewal quotes · Triage inbound RFPs. Nine more sequenced by quarter.', [88, 70]],
    ['Operating model',          'Embedded: agents owned by the teams that run the process, with a small central platform and review group.', [84, 58]],
    ['Data readiness gaps',      'Billing history split across two systems · 18% of invoices arrive as PDFs · CRM firmographics patchy.', [90, 50]],
    ['Budget and measures',      'Build, run and review budget per use case; one owner and one number each; quarterly review.', [80, 46]],
    ['Risk tier and governance', 'Two limited-risk use cases carry disclosure duties; two high-risk candidates parked with a compliance plan.', [86, 62]],
];
$tas_ws_sign = ['COO', 'CFO', 'CISO', 'Head of sales ops'];
?>
<section class="band band--alt tas-workshop" id="workshop" aria-labelledby="workshop-t">
  <div class="wrap">
    <div class="tas-head" data-rv>
      <div class="tas-head__t">
        <p class="tas-kick"><span class="tas-kick__ref">08</span>The workshop</p>
        <h2 class="h2" id="workshop-t"><span class="g">Strategy with the people</span> who run the work.</h2>
      </div>
      <div class="tas-head__l">
        <p class="lead">Two days in the first week, in one room with operations, legal, security, finance and the team that does the job today. The long list goes on the wall, gets scored, and leaves as a one-page strategy the room has already agreed.</p>
      </div>
    </div>

    <div class="tas-ws" data-tas-ws>
      <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
      <figure class="tas-ws__big" data-rv>
        <div class="bdh-img bdh-img--r169 bdh-img--xl" data-bdh-parallax="0.06">
          <img src="<?= xe_url('assets/imgs/tech/ai-strategy-agents/workshop-wall.jpg') ?>" alt="Two colleagues place handwritten sticky notes on a glass wall divided into quarters" width="1800" height="1200" loading="lazy" decoding="async" style="object-position:50% 40%">
        </div>
        <figcaption class="tas-ws__cap"><span class="bdh-cap-chip"><b>Before scoring</b>The long list on the wall, sorted by quarter.</span></figcaption>
      </figure>

      <aside class="tas-ws__room" data-rv data-rv-d="80" aria-labelledby="workshop-room-t">
        <h3 class="tas-lbl" id="workshop-room-t">Who is in the room</h3>
        <ul class="tas-ws__who">
          <?php foreach ($tas_ws_room as $tas_r): ?>
            <li><?= xt_icon($tas_r[0], ['size' => 20]) ?><div><b><?= e($tas_r[1]) ?></b><span><?= e($tas_r[2]) ?></span></div></li>
          <?php endforeach; ?>
        </ul>
      </aside>

      <div class="tas-ws__agenda" data-rv data-rv-d="60">
        <!-- PLACEHOLDER: confirm the agent-summarised pre-read is part of the standard workshop before launch -->
        <div class="tas-ws__pre">
          <span class="tas-ws__prei"><?= xt_icon('doc', ['size' => 20]) ?></span>
          <p><b>The week before · a sourced pre-read</b>Process documents, a sample of tickets and the system inventory are summarised by agents into a short pre-read, every line linked to its source, so the room spends its time deciding.</p>
        </div>
        <div class="tas-ws__days">
          <?php foreach ($tas_ws_days as $tas_di => $tas_d): ?>
            <div class="tas-ws__day">
              <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
              <figure class="tas-ws__small">
                <div class="bdh-img bdh-img--r169">
                  <img src="<?= xe_url('assets/imgs/tech/ai-strategy-agents/' . $tas_d[1]) ?>" alt="<?= e($tas_d[2]) ?>" width="1800" height="<?= (int) $tas_d[7] ?>" loading="lazy" decoding="async" style="object-position:<?= e($tas_d[3]) ?>">
                </div>
                <figcaption class="tas-ws__cap"><span class="bdh-cap-chip"><b><?= e($tas_d[4]) ?></b><?= e($tas_d[5]) ?></span></figcaption>
              </figure>
              <ol class="tas-ws__sess">
                <?php foreach ($tas_d[6] as $tas_s): ?>
                  <li>
                    <p class="tas-ws__when"><?= e($tas_d[0]) ?> · <?= e($tas_s[0]) ?></p>
                    <h3 class="tas-ws__st"><?= e($tas_s[1]) ?></h3>
                    <p class="tas-ws__sd"><?= e($tas_s[2]) ?></p>
                    <p class="tas-ws__so"><?= xt_icon('check', ['size' => 14]) ?><?= e($tas_s[3]) ?></p>
                  </li>
                <?php endforeach; ?>
              </ol>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="tas-ws__doc" data-rv data-rv-d="140" data-ws-doc>
        <div class="tas-ws__dh">
          <p class="tas-ws__dk"><span>AI strategy · one page · Your company · v1</span><span class="tas-ill">Illustrative</span></p>
          <h3 class="tas-ws__dt">What leaves the room</h3>
        </div>
        <ol class="tas-ws__secs">
          <?php foreach ($tas_ws_doc as $tas_di => $tas_d): ?>
            <li class="tas-ws__sec" style="--i:<?= $tas_di ?>">
              <p class="tas-ws__sh"><span><?= $tas_di + 1 ?></span><?= e($tas_d[0]) ?></p>
              <div class="tas-ws__body">
                <p class="tas-ws__sl"><?= e($tas_d[1]) ?></p>
                <span class="tas-ws__lines" aria-hidden="true"><?php foreach ($tas_d[2] as $tas_w): ?><i style="--w:<?= (int) $tas_w ?>%"></i><?php endforeach; ?></span>
              </div>
            </li>
          <?php endforeach; ?>
        </ol>
        <div class="tas-ws__sign">
          <p class="tas-lbl">Agreed in the room</p>
          <ul>
            <?php foreach ($tas_ws_sign as $tas_si => $tas_sg): ?><li style="--i:<?= $tas_si ?>"><span class="tas-ws__tick" aria-hidden="true"></span><?= e($tas_sg) ?></li><?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
