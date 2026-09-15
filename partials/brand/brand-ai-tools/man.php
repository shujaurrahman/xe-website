<?php /* DRAFT COPY — review before launch */
/* 12 FAQ — a man page. NAME and SYNOPSIS stay open; each $CAT['faq'] entry is a manual section
   (MODELS, OWNERSHIP, PREREQUISITES, GUARDRAILS) that opens one at a time. SEE ALSO links the pairs. */
$cat_secs = ['MODELS', 'OWNERSHIP', 'PREREQUISITES', 'GUARDRAILS'];   // aligned to $CAT['faq']
$cat_see = [];
foreach ($CAT['pairs'] as $cat_ps) { if (isset($CAT_CAPS[$cat_ps])) $cat_see[] = $CAT_CAPS[$cat_ps]; }
?>
<section class="band cat-paper cat-man" id="faq" aria-labelledby="faq-t">
  <div class="wrap cat-man__in">
    <div class="cat-man__side" data-rv>
      <p class="cat-prompt"><b>$ man brandctl</b> <span>questions enterprise teams ask first</span></p>
      <h2 class="h2" id="faq-t"><span class="g">Read the manual</span> before you ask.</h2>
      <p class="lead">The questions that come up in the first meeting, answered plainly. Anything else goes in the brief.</p>
      <a class="btn btn--out cat-man__cta" href="<?= xe_url('contact.php') ?>">Ask something else <span class="i" aria-hidden="true">›</span></a>
    </div>

    <div class="cat-man__page" data-rv>
      <p class="cat-man__rh" aria-hidden="true"><span>BRANDCTL(7)</span><span>Brand AI Tools Manual</span><span>BRANDCTL(7)</span></p>

      <div class="cat-man__fixed">
        <p class="cat-man__sec">NAME</p>
        <p class="cat-man__body"><b>brand-ai-tools</b> — <?php $cat_nm = rtrim($CAT_CAPS['brand-ai-tools'][1] ?? $CAT['kicker'], '.'); echo e(preg_match('/^[A-Z][A-Z]/', $cat_nm) ? $cat_nm : lcfirst($cat_nm)); ?></p>
        <p class="cat-man__sec">SYNOPSIS</p>
        <p class="cat-man__body cat-man__mono">brandctl [tune | check | generate | write | render | govern] --brand your-brand</p>
      </div>

      <div class="cat-man__qs">
        <?php foreach ($CAT['faq'] as $cat_qi => $cat_q): $cat_open = $cat_qi === 0; ?>
          <div class="cat-man__item<?= $cat_open ? ' is-open' : '' ?>">
            <h3 class="cat-man__h">
              <button type="button" class="cat-man__btn" id="faq-b-<?= $cat_qi ?>" aria-expanded="<?= $cat_open ? 'true' : 'false' ?>" aria-controls="faq-p-<?= $cat_qi ?>">
                <span class="cat-man__sec"><?= e($cat_secs[$cat_qi] ?? 'NOTES') ?></span>
                <span class="cat-man__q"><?= e($cat_q[0]) ?></span>
                <span class="cat-man__tog" aria-hidden="true"></span>
              </button>
            </h3>
            <div class="cat-man__panel" id="faq-p-<?= $cat_qi ?>" role="region" aria-labelledby="faq-b-<?= $cat_qi ?>">
              <div class="cat-man__clip"><p class="cat-man__body"><?= e($cat_q[1]) ?></p></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="cat-man__fixed cat-man__see">
        <p class="cat-man__sec">SEE ALSO</p>
        <p class="cat-man__body cat-man__mono">
          <?php foreach ($cat_see as $cat_si => $cat_sc): ?><?= $cat_si ? ', ' : '' ?><a href="<?= xe_cap_url($BRAND, $cat_sc) ?>"><?= e($cat_sc[2]) ?>(7)</a><?php endforeach; ?>
        </p>
      </div>
      <p class="cat-man__rh cat-man__rf" aria-hidden="true"><span>Draft · <?= date('Y') ?></span><span>BRANDCTL(7)</span></p>
    </div>
  </div>
</section>
