<?php /* DRAFT COPY — review before launch */
/* Consolidate — the sustainability angle, made operational rather than decorative. A before/after
   toggle on one illustrative estate: polling every few minutes across dozens of scheduled jobs
   versus events that fire only when something actually changed. Counters roll between the two
   states; the HTML carries the "after" figures as the readable default. SCI is quoted correctly:
   SCI = ((E x I) + M) per R. All figures illustrative. */
$tis_co_rows = [   // [label, before, after, unit, note]
    ['SaaS licences in the estate', '34', '26', 'seats',
     'Three tools existed only to move data between two others. Retiring them removes the seat cost and the integration surface at once.'],
    ['Scheduled polling jobs', '41', '6', 'jobs',
     'Most polls asked "has anything changed?" every five minutes and were told no. Webhooks and change data capture replaced them.'],
    ['Integration compute', '1,240', '430', 'hours / month',
     'Idle polling workers ran around the clock. Event consumers scale to zero between messages.'],
    ['Estimated energy', '512', '178', 'kWh / month',
     'Derived from compute hours and the published carbon intensity of the region, not measured at the socket.'],
    ['API calls to vendor systems', '11.8', '0.4', 'million / month',
     'Fewer calls also means fewer rate-limit incidents and lower tiered API charges.'],
];
/* [icon, title, what it is, before readout, after readout] — the two readouts are the move itself,
   stated in the same mono voice as the estate report above. */
$tis_co_moves = [
    ['sync',    'Replace polling with webhooks', 'Where a vendor supports them, a webhook fires on change. Where they do not, change data capture reads the database log instead of re-reading whole tables.',
     'poll every 5 min', 'webhook or CDC on change'],
    ['clock',   'Schedule heavy syncs off-peak', 'Full reconciliation runs once a night in a region and a window with lower carbon intensity, instead of hourly all day.',
     'reconcile hourly, all day', 'one nightly low-intensity window'],
    ['puzzle',  'Retire tools that only move data', 'Point-to-point connector subscriptions disappear once the flows run on one bus you already operate.',
     '3 point-to-point tools', '1 bus you already run'],
    ['filter',  'Send less, less often', 'Field-level filtering and compression at the producer cut payload size; batching cuts request count without delaying the flows that matter.',
     'whole record, every time', 'changed fields, batched'],
];
?>
<section class="band tis-co" id="consolidate" aria-labelledby="consolidate-t">
  <div class="wrap">

    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tis-kick"><b>$ estate consolidate --dry-run</b> <span>5 measures · one estate</span></p>
        <h2 class="h2" id="consolidate-t"><span class="g">Fewer tools,</span> fewer idle jobs.</h2>
      </div>
      <div>
        <p class="lead">Most integration energy is spent asking questions that have no answer. A poll that runs every five minutes runs 288 times a day and changes nothing 280 of them. Events remove the question.</p>
      </div>
    </div>

    <div class="tis-co__body" data-rv data-tis-co>

      <div class="tis-panel tis-co__panel">
        <div class="tis-panel__bar">
          <span><b>estate.report</b> <span aria-hidden="true">·</span> one mid-size commerce estate</span>
          <span class="tis-ill">Illustrative</span>
        </div>

        <div class="tis-co__ctl">
          <div class="bdh-seg" role="group" aria-label="Integration estate, before or after consolidation">
            <button type="button" aria-pressed="false" data-tis-state="before">Polling estate</button>
            <button type="button" aria-pressed="true" data-tis-state="after">Event-driven</button>
          </div>
          <p class="tis-co__ctln" data-co-caption>After: connectors consolidated onto one event bus, polling replaced where the vendor supports it.</p>
        </div>

        <ul class="tis-co__rows" role="list">
          <?php foreach ($tis_co_rows as $tis_co_i => $tis_co_r): ?>
            <li class="tis-co__row" style="--i:<?= (int) $tis_co_i ?>">
              <div class="tis-co__rt">
                <p class="tis-co__rl"><?= e($tis_co_r[0]) ?></p>
                <p class="tis-co__rn"><?= e($tis_co_r[4]) ?></p>
              </div>
              <p class="tis-co__rv">
                <span class="tis-co__num" data-co-before="<?= e($tis_co_r[1]) ?>" data-co-after="<?= e($tis_co_r[2]) ?>"><?= e($tis_co_r[2]) ?></span>
                <span class="tis-co__ru"><?= e($tis_co_r[3]) ?></span>
              </p>
              <p class="tis-co__rb">
                <span class="tis-co__was">was <?= e($tis_co_r[1]) ?></span>
              </p>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <aside class="tis-co__side">
        <div class="tis-co__sci">
          <?= xt_icon('leaf', ['size' => 22]) ?>
          <h3 class="bdh-t">Measured, not asserted</h3>
          <p class="tis-co__scil">We report the Software Carbon Intensity of the integration layer rather than an offset claim. SCI is defined as</p>
          <p class="tis-co__f"><span class="tis-co__fx">SCI = ((E &times; I) + M) per R</span></p>
          <ul class="tis-co__key" role="list">
            <li><b>E</b> energy consumed by the integration workloads</li>
            <li><b>I</b> location-based marginal carbon intensity of that region</li>
            <li><b>M</b> embodied emissions of the hardware used</li>
            <li><b>R</b> the functional unit &mdash; here, one thousand business events delivered</li>
          </ul>
          <ul class="xt-badges" role="list"><?= xt_badge('sci', ['tag' => 'li']) ?></ul>
          <p class="tis-co__scin">A framework we align delivery with. The figures on this page are illustrative, not a measured result. <!-- PLACEHOLDER: confirm whether SCI reporting is offered as standard or as an add-on before launch --></p>
        </div>
      </aside>
    </div>

    <div class="tis-co__mh" data-rv>
      <h3 class="tis-co__mhk">Four moves that do the work</h3>
      <p class="tis-co__mhl">None of these is a sustainability project. They are ordinary integration decisions that happen to cut energy, licence cost and rate-limit incidents at the same time.</p>
    </div>
    <ol class="tis-co__moves" role="list" data-rv data-bdh-stagger>
      <?php foreach ($tis_co_moves as $tis_co_i => $tis_co_m): ?>
        <li class="tis-co__move" style="--i:<?= (int) $tis_co_i ?>">
          <p class="tis-co__mtop">
            <span class="tis-co__mi" aria-hidden="true"><?= xt_icon($tis_co_m[0], ['size' => 20]) ?></span>
            <span class="bdh-idx"><?= e(sprintf('%02d', $tis_co_i + 1)) ?></span>
          </p>
          <h3 class="bdh-t tis-co__mt"><?= e($tis_co_m[1]) ?></h3>
          <p class="bdh-d"><?= e($tis_co_m[2]) ?></p>
          <p class="tis-co__mr">
            <span class="tis-co__mrb"><?= e($tis_co_m[3]) ?></span>
            <span class="tis-co__mra" aria-hidden="true">&rarr;</span>
            <span class="tis-co__mrf"><?= e($tis_co_m[4]) ?></span>
          </p>
        </li>
      <?php endforeach; ?>
    </ol>

    <p class="bdh-sr">The panel compares one illustrative estate before and after consolidation: 34 SaaS licences fall to 26, 41 scheduled polling jobs fall to 6, integration compute falls from 1,240 to 430 hours a month, estimated energy from 512 to 178 kWh a month, and vendor API calls from 11.8 million to 0.4 million a month.</p>
  </div>
</section>
