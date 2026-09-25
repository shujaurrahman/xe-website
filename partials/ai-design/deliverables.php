<?php /* DRAFT COPY — review before launch */
/* Deliverables — what lands, per capability, straight from the 'deliver' arrays in data/ai-design.php,
   plus the part clients actually ask about: whose account it lands in. Four columns on a wide screen,
   two at tablet, one on a phone, with the reading order unchanged. */
$dv_own = [
    ['Weights, adapters and datasets',   'Delivered as files and into your own model registry, with the training scripts that produced them.'],
    ['Prompts, scoring sets and logs',   'In your repositories, versioned, from the first commit rather than at the end.'],
    ['Nothing retained by us',           'We do not keep your material and we do not train anything else on it.'],
    ['Documented to be re-run',          'Model cards, runbooks and the scoring set, so your team can tune the next version without us.'],
];
?>
<section class="band band--alt aih-dv" id="deliverables" aria-labelledby="deliverables-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Deliverables</p>
        <h2 class="h2" id="deliverables-t"><span class="g">What lands,</span> and whose account it lands in.</h2>
      </div>
      <div>
        <p class="lead">Design work, produced work, model work and the decisions behind all three. Each line below is a real artefact with a real format, not a phase name. The capability it belongs to is at the head of its column.</p>
        <p class="aih-note">A model nobody but us can retrain is not a deliverable. Ownership is listed at the foot of this section.</p>
      </div>
    </div>

    <div class="aih-dv__cols">
      <?php foreach ($CAPS as $dv_s => $dv_c): ?>
        <div class="aih-dv__col" data-rv data-rv-d="<?= 40 + (int) $dv_c['n'] * 15 ?>">
          <div class="aih-dv__ch">
            <span class="bdh-idx"><?= e($dv_c['n']) ?></span>
            <h3 class="aih-dv__ct"><?= e($dv_c['name']) ?></h3>
            <a class="tl aih-dv__cl" href="#<?= e($dv_s) ?>">What it covers <span class="i" aria-hidden="true">›</span></a>
          </div>
          <ul class="bdh-list aih-dv__list">
            <?php foreach ($dv_c['deliver'] as $dv_d): ?>
              <li><span><?= e($dv_d[0]) ?></span><small><?= e($dv_d[1]) ?></small></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="aih-dv__own" data-rv data-rv-d="70">
      <div class="aih-dv__oh">
        <p class="aih-k aih-k--blue">Ownership</p>
        <h3 class="aih-dv__ot">Yours, and portable</h3>
        <p class="aih-dv__od">Weights, datasets, prompts, scores and logs sit in your accounts. Nothing is retained and nothing else is trained on them.</p>
      </div>
      <dl class="aih-dv__ol">
        <?php foreach ($dv_own as $dv_o): ?>
          <div><dt><?= e($dv_o[0]) ?></dt><dd><?= e($dv_o[1]) ?></dd></div>
        <?php endforeach; ?>
      </dl>
      <!-- PLACEHOLDER: confirm the contractual IP, retention and non-training position with the client's counsel before launch -->
      <p class="aih-note aih-dv__on">The contractual wording for ownership, retention and non-training is agreed in the engagement terms rather than implied by this page.</p>
    </div>
  </div>
</section>
