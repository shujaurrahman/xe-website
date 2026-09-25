<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* The handover, laid out as the folder you receive. */
$cch_tree = [   // [folder, [[file, format]]]
    ['01 Strategy',     [['Campaign brief & platform', 'Deck'], ['Audience & channel plan', 'Sheet'], ['Measurement plan & baseline', 'Document']]],
    ['02 Design system',[['Key visual masters', 'Figma · PSD'], ['Campaign toolkit & rules', 'Figma library'], ['Format templates', 'Figma · Canva-ready']]],
    ['03 Content',      [['Hero film & stills', 'ProRes · TIFF'], ['Channel cut-downs', 'MP4 · JPG · HTML5'], ['Copy deck, all lengths & languages', 'Sheet']]],
    ['04 Earned',       [['Press materials & story angles', 'Document'], ['Creator briefs & contracts', 'PDF']]],
    ['05 Flight',       [['Flighting plan & budgets', 'Sheet'], ['Tracking plan & UTMs', 'Sheet'], ['Live campaign dashboard', 'Dashboard']]],
    ['06 Rights & results', [['Usage-rights register', 'Sheet'], ['Results & learnings', 'Deck']]],
];
?>
<section class="band band--alt cch-deliv" id="deliverables" aria-labelledby="deliverables-t">
  <div class="wrap cch-deliv__g">
    <div class="cch-deliv__copy" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>What you receive</p>
      <h2 class="h2" id="deliverables-t"><span class="g">Everything we make</span> is yours, and easy to find.</h2>
      <p class="lead">Source files, not just exports. Every asset transfers to you with its usage rights recorded, so the campaign can be extended, re-cut or re-run without us.</p>
      <ul class="cch-deliv__facts bdh-ro">
        <li><span class="bdh-ok" aria-hidden="true">✓</span>Editable masters and templates</li>
        <li><span class="bdh-ok" aria-hidden="true">✓</span>Rights and licences logged per asset</li>
        <li><span class="bdh-ok" aria-hidden="true">✓</span>Named for your DAM, not ours</li>
      </ul>
    </div>
    <div class="cch-tree" data-rv>
      <p class="cch-tree__root bdh-ro"><?= xt_icon('layers') ?>your-brand / campaign-launch /</p>
      <ul class="cch-tree__l">
        <?php foreach ($cch_tree as $cch_f): ?>
        <li class="cch-tree__f">
          <span class="cch-tree__fn bdh-ro"><?= e($cch_f[0]) ?></span>
          <ul>
            <?php foreach ($cch_f[1] as $cch_file): ?>
            <li class="cch-tree__i"><span class="cch-tree__n"><?= e($cch_file[0]) ?></span><span class="cch-tree__fmt bdh-ro"><?= e($cch_file[1]) ?></span></li>
            <?php endforeach; ?>
          </ul>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
