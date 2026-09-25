<?php /* DRAFT COPY — review before launch */ ?>
<?php
$mtd_hs = $mtd_head('stack', ['Your platforms first.', 'Ours where they help.', 'Tools we use on ' . strtolower($CAP['name']) . '.']);
/* Logos with artwork render as tiles; names without artwork as a chip row beneath (no empty glyph boxes). */
$mtd_sk = xt_stack_data();
$mtd_st_tiles = array_values(array_filter($CAP['stack'], fn ($mtd_z) => !empty($mtd_sk[$mtd_z]['file'])));
$mtd_st_chips = array_values(array_diff($CAP['stack'], $mtd_st_tiles));
?>
<section class="band mtd-stack" id="stack" aria-labelledby="stack-t">
  <div class="wrap mtd-stack__g">
    <div class="bdh-head" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>Technologies we work with</p>
      <h2 class="h2" id="stack-t"><span class="g"><?= e($mtd_hs[0]) ?></span> <?= e($mtd_hs[1]) ?></h2>
      <p class="lead"><?= e($mtd_hs[2]) ?> Named as technologies we work with, not partnerships; model providers run inside an approval step, never around it.</p>
    </div>
    <div class="mtd-stack__t" data-rv>
      <?= xt_stack($mtd_st_tiles, ['variant' => 'tiles', 'label' => $CAP['name'] . ' technologies']) ?>
      <?php if ($mtd_st_chips): ?><div class="mtd-stack__more"><?= xt_stack($mtd_st_chips, ['variant' => 'chips', 'label' => 'Also used']) ?></div><?php endif; ?>
    </div>
  </div>
</section>
