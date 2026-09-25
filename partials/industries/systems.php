<?php /* DRAFT COPY — review before launch */
/* Systems — the unglamorous half of every brief. What each sector actually runs on: the systems of
   record, where the customer meets you, what the data really is, and the thing that usually breaks —
   then the platforms and technologies that work sits on, through the shared kit (xt_stack).
   Technologies are ones we work with. No partner, reseller or certification tier is implied. */
$sys_labels = ['database', 'browser', 'layers', 'alert'];
?>
<section class="band band--alt ind-sys" id="systems" aria-labelledby="systems-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The systems underneath</p>
        <h2 class="h2" id="systems-t"><span class="g">Nobody starts from nothing.</span> Every sector starts from an estate.</h2>
      </div>
      <div>
        <p class="lead">Before design, before AI, before a line of code, there is a set of systems that already holds the business. Knowing what they are — and which one is allowed to be the truth — decides most of the architecture.</p>
        <p class="ind-note"><b>Technologies we work with.</b> No partner, reseller or certification tier is implied by any mark on this page.</p>
      </div>
    </div>

    <ol class="ind-sys__list" data-rv-s data-rv-step="70">
      <?php foreach ($IND as $sys_i => $sys_s): ?>
        <li class="ind-sys__row" id="systems-<?= e($sys_s['id']) ?>">
          <div class="ind-sys__id">
            <p class="ind-rail"><b><?= e($sys_s['n']) ?></b></p>
            <h3 class="bdh-t bdh-t--l"><a href="#<?= e($sys_s['id']) ?>"><?= e($sys_s['name']) ?></a></h3>
            <p class="ind-sys__note"><?= e($sys_s['stack_note']) ?></p>
            <p class="ind-sys__count"><span class="ind-k">Platforms in play</span><span><b><?= count($sys_s['stack']) ?></b> typical in this category</span></p>
          </div>

          <div class="ind-sys__body">
            <dl class="ind-sys__facts">
              <?php foreach ($sys_s['systems'] as $sys_fi => $sys_f): ?>
                <div>
                  <dt><span class="ind-sys__fi" aria-hidden="true"><?= xt_icon($sys_labels[$sys_fi] ?? 'dot', ['size' => 18]) ?></span><?= e($sys_f[0]) ?></dt>
                  <dd><?= e($sys_f[1]) ?></dd>
                </div>
              <?php endforeach; ?>
            </dl>
            <div class="ind-sys__stack">
              <p class="ind-k">Platforms and technologies this usually sits on</p>
              <?= xt_stack($sys_s['stack'], ['variant' => 'chips', 'size' => 16, 'label' => 'Technologies typical of ' . $sys_s['name'], 'class' => 'ind-sys__chips']) ?>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>

    <p class="ind-note ind-sys__foot">Each list is what we most often find and build on in that category, not a fixed stack. Every choice is made per engagement on evidence, written into an architecture decision record, and kept reversible. <a class="tl" href="<?= xe_url('services/technology-intelligence.php') ?>#stack">See the full technology library <span class="i" aria-hidden="true">›</span></a></p>
  </div>
</section>
