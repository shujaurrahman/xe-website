<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Anatomy of a key visual: five parts, pinned on the frame and explained beside it. */
$cch_parts = [   // [pin x %, pin y %, name, rule]
    [22, 30, 'Photography direction', 'Real moments, warm side light, hands in frame. One brief for every photographer in every market.'],
    [6, 50, 'Headline system',       'One typeface, three lengths written up front — long, short and single-phrase — so small formats never truncate the idea.'],
    [76, 9, 'Graphic device',        'A single device that can carry the idea on its own when there is no room for a photograph.'],
    [80, 86, 'Lockup zone',           'A fixed corner and clearspace, so the brand is found in the same place in every format.'],
    [36, 90, 'Call to action',        'Written per channel and per stage: learn more at the top of the funnel, a specific action at the bottom.'],
];
?>
<section class="band cch-kit" id="kit" aria-labelledby="kit-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Campaign design system</p>
        <h2 class="h2" id="kit-t"><span class="g">Not a set of ads.</span> A kit of parts that makes the next hundred.</h2></div>
      <div><p class="lead">A campaign design system defines the few things that must never change and the many that may. Designers, agencies and AI tools then produce new executions that still read as one campaign.</p></div>
    </div>
    <div class="cch-kit__g">
      <figure class="cch-kit__fig" data-rv>
        <div class="cch-frame cch-frame--r45 cch-kit__frame">
          <img src="<?= e(xe_url('assets/imgs/campaign-content/kit-billboard.jpg')) ?>" alt="A blank billboard frame standing on a terrace between apartment buildings" width="1200" height="1200" loading="lazy" decoding="async" style="object-position:50% 50%">
          <span class="cch-frame__hl cch-kit__hl" aria-hidden="true">Win the first<br>ten minutes.</span>
          <span class="cch-kit__dev" aria-hidden="true"><i></i><i></i><i></i></span>
          <span class="cch-kit__cta" aria-hidden="true">See how</span>
          <span class="cch-kit__lock" aria-hidden="true">Your brand</span>
          <?php foreach ($cch_parts as $cch_i => $cch_p): ?>
          <span class="cch-kit__pin" style="left:<?= $cch_p[0] ?>%;top:<?= $cch_p[1] ?>%" aria-hidden="true"><?= $cch_i + 1 ?></span>
          <?php endforeach; ?>
        </div>
        <figcaption class="bdh-ro cch-kit__cap">Master key visual · 4:5 · five parts annotated</figcaption>
      </figure>
      <ol class="cch-kit__list">
        <?php foreach ($cch_parts as $cch_i => $cch_p): ?>
        <li class="cch-kit__i" data-rv>
          <span class="cch-kit__n"><?= $cch_i + 1 ?></span>
          <div><h3 class="h3 cch-kit__t"><?= e($cch_p[2]) ?></h3><p class="p"><?= e($cch_p[3]) ?></p></div>
        </li>
        <?php endforeach; ?>
        <li class="cch-kit__i cch-kit__i--sum" data-rv>
          <span class="cch-kit__n"><?= xt_icon('layers') ?></span>
          <div><h3 class="h3 cch-kit__t">Delivered as templates, not PDFs</h3><p class="p">The kit ships as locked design templates and a component library, so a new market or a new format is an afternoon's work rather than a new brief.</p></div>
        </li>
      </ol>
    </div>
  </div>
</section>
