<?php /* DRAFT COPY — review before launch */
/* Deliverables — the ledger. Every item that is handed over, by capability, straight from the
   'deliver' arrays in data/campaign-content.php, with the format each one arrives in. Nothing is
   summarised away: the count in the head is the sum of the rows below it. */
$dl_total = 0;
foreach ($CAPS as $dl_c) { $dl_total += count($dl_c['deliver']); }
$dl_formats = [];
foreach ($CAPS as $dl_c) { foreach ($dl_c['deliver'] as $dl_d) { foreach (preg_split('/\s*·\s*/', $dl_d[1]) as $dl_f) { $dl_formats[$dl_f] = true; } } }
?>
<section class="band cch-deliver" id="deliverables" aria-labelledby="deliverables-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>What is handed over</p>
        <h2 class="h2" id="deliverables-t"><span class="g">Not a deck at the end.</span> <?= $dl_total ?> things you keep.</h2>
      </div>
      <div>
        <p class="lead">Every item below is a deliverable from one of the eight capabilities, in the format it actually arrives in. Copy, design files, photography and licences transfer to you on delivery, with usage rights recorded per asset.</p>
        <dl class="cch-dl__facts">
          <div><dt>Deliverables</dt><dd><?= $dl_total ?></dd></div>
          <div><dt>Capabilities</dt><dd><?= count($CAPS) ?></dd></div>
          <div><dt>Ownership</dt><dd>Yours on delivery</dd></div>
        </dl>
      </div>
    </div>

    <div class="cch-dl__grid" data-rv data-rv-d="60">
      <?php foreach ($CAPS as $dl_slug => $dl_c): ?>
        <div class="cch-dl__group">
          <p class="cch-dl__gh">
            <span class="cch-dl__gn"><?= e($dl_c['n']) ?></span>
            <a class="cch-dl__gt" href="#<?= e($dl_slug) ?>"><?= e($dl_c['name']) ?><i aria-hidden="true">›</i></a>
            <span class="cch-dl__gc"><?= count($dl_c['deliver']) ?></span>
          </p>
          <ul class="bdh-list cch-dl__list" role="list">
            <?php foreach ($dl_c['deliver'] as $dl_d): ?>
              <li><span><?= e($dl_d[0]) ?></span><small><?= e($dl_d[1]) ?></small></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>

    <p class="cch-note cch-dl__note">Formats are the ones your team already works in: <?= e(implode(', ', array_slice(array_keys($dl_formats), 0, 12))) ?> and the rest. Nothing is delivered in a format only we can open.</p>
  </div>
</section>
