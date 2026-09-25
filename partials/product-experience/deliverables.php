<?php /* DRAFT COPY — review before launch */
/* Deliverables — the full inventory, capability by capability, with the format each thing arrives in.
   Straight from data/product-experience.php, so the page and the capability pages can never disagree
   about what is handed over. The last cell of the grid is who owns it afterwards. */
$dlv_caps = array_values($CAPS);
$dlv_total = array_sum(array_map(fn ($dlv_c) => count($dlv_c['deliver']), $dlv_caps));
$dlv_own = [
    ['Design files and libraries', 'Created in your Figma organisation, not ours. Libraries are published from your account so they keep working after we leave.'],
    ['Tokens and component code',  'Committed to your repositories from the first commit, published under your package scope, versioned with your release process.'],
    ['Research', 'Transcripts, clips and findings in a repository your team can search, with consent records attached and a retention date on every recording.'],
    ['The intellectual property', 'Assigned to you as it is created, including prompts, evaluation sets and the reasoning behind the decisions, not only the artefacts.'],
];
?>
<section class="band band--alt pxh-deliver" id="deliverables" aria-labelledby="deliverables-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Deliverables</p>
        <h2 class="h2" id="deliverables-t"><span class="g">What arrives,</span> and in what format.</h2>
      </div>
      <div>
        <p class="lead">No engagement here ends in a deck alone. This is the whole inventory across the five capabilities, with the format each item is handed over in, so the scope conversation starts from a list rather than an adjective.</p>
        <p class="pxh-deliver__count"><span class="pxh-k">In total</span><b><?= $dlv_total ?></b> deliverables · <b><?= count($dlv_caps) ?></b> capabilities</p>
      </div>
    </div>

    <div class="pxh-deliver__grid">
      <?php foreach ($dlv_caps as $dlv_i => $dlv_c): ?>
        <div class="pxh-deliver__col" data-rv data-rv-d="<?= ($dlv_i % 4) * 50 ?>">
          <p class="pxh-deliver__ch">
            <a class="pxh-capl" href="#<?= e($dlv_c['slug']) ?>"><b><?= e($dlv_c['n']) ?></b><span><?= e($dlv_c['short']) ?></span><i aria-hidden="true">›</i></a>
            <span class="pxh-deliver__cn"><?= count($dlv_c['deliver']) ?> items</span>
          </p>
          <h3 class="pxh-deliver__ct"><?= e($dlv_c['name']) ?></h3>
          <ul class="bdh-list pxh-deliver__list">
            <?php foreach ($dlv_c['deliver'] as $dlv_d): ?>
              <li><span><?= e($dlv_d[0]) ?></span><small><?= e($dlv_d[1]) ?></small></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>

      <div class="pxh-deliver__own" data-rv data-rv-d="60">
        <p class="pxh-k">Who owns it afterwards</p>
        <p class="pxh-deliver__ot">You do — including the parts that are easy to leave behind.</p>
        <dl class="pxh-deliver__olist">
          <?php foreach ($dlv_own as $dlv_o): ?>
            <div><dt><?= e($dlv_o[0]) ?></dt><dd><?= e($dlv_o[1]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
        <p class="pxh-note">A handover is a date in the plan, not a meeting at the end. The parts your team will run — the design system, the research cadence, the analytics — are handed over in stages, with the training and the documentation that make each one possible.</p>
      </div>
    </div>
  </div>
</section>
