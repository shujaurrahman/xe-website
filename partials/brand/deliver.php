<?php
/**
 * What is handed over, drawn as the handover pack itself: a file browser with
 * one row per deliverable and file-type badges read from the format string.
 * The transfer completes, row by row, when the pack scrolls into view.
 *
 *   $cap          required  deliver [[name, 'Figma · JSON'], …], name, slug
 *   $deliverLead  optional  lead text
 */
require_once __DIR__ . '/icons.php';
$dvFiles = $cap['deliver'];
$dvN     = count($dvFiles);
$dvFmts  = [];
foreach ($dvFiles as $d) { foreach (bd_badges($d[1]) as $b) { $dvFmts[$b] = true; } }
$dvZip   = $cap['slug'] . '-handover';
$dvPad   = function ($x) { return str_pad((string) $x, 2, '0', STR_PAD_LEFT); };
$dvLead  = $deliverLead ?? 'Every file, every rule and every model ships into your accounts, under your name. Nothing stays with us.';
?>
<section class="band bd-deliver" id="deliverables" aria-labelledby="deliver-t">
  <div class="wrap bd-deliver__in">
    <div class="bd-deliver__head" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>What you walk away with</p>
      <h2 class="h2" id="deliver-t"><span class="g">Handed over,</span> in the formats you use</h2>
      <p class="lead"><?= e($dvLead) ?></p>
      <ul class="bd-deliver__facts">
        <li><b class="num"><?= $dvPad($dvN) ?></b><span>Deliverables</span></li>
        <li><b class="num"><?= $dvPad(count($dvFmts)) ?></b><span>Formats</span></li>
        <li><b class="num">100%</b><span>Yours</span></li>
      </ul>
      <ul class="bd-deliver__own">
        <li><?= bd_icon('tick') ?>Source files, not exports</li>
        <li><?= bd_icon('tick') ?>Shipped into your accounts</li>
        <li><?= bd_icon('tick') ?>IP transfers on delivery</li>
      </ul>
    </div>

    <div class="bd-pack" data-bd-pack data-rv data-rv-d="100" style="--n:<?= $dvN ?>">
      <div class="bd-pack__bar">
        <span class="bd-stage__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="bd-pack__crumb">Handover <i aria-hidden="true">›</i> <?= e($cap['name']) ?></span>
        <span class="bd-pack__state"><i aria-hidden="true"></i><span data-bd-pack-state>Transferred</span></span>
      </div>

      <div class="bd-pack__head">
        <span class="bd-pack__zip" aria-hidden="true">
          <svg viewBox="0 0 40 48" fill="none"><path d="M4 4a3 3 0 0 1 3-3h19l11 11v31a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3z" stroke="currentColor" stroke-width="1.5"/><path d="M26 1v8a3 3 0 0 0 3 3h8" stroke="currentColor" stroke-width="1.5"/><path d="M16 6h4M16 11h4M16 16h4M16 21h4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><rect class="a" x="14" y="26" width="8" height="9" rx="1.5" stroke="currentColor" stroke-width="1.5"/></svg>
        </span>
        <span class="bd-pack__id">
          <span class="bd-pack__name"><?= e($dvZip) ?>.zip</span>
          <span class="bd-pack__meta"><?= $dvN ?> files · <?= count($dvFmts) ?> formats · owner: you</span>
        </span>
        <span class="bd-pack__xfer" aria-hidden="true">
          <span class="bd-pack__prog"><i></i></span>
          <span class="bd-pack__pct"><span data-bd-pack-n><?= $dvN ?></span> / <?= $dvN ?></span>
        </span>
      </div>

      <div class="bd-pack__cols" aria-hidden="true"><span></span><span>Name</span><span>Formats</span><span>Owner</span><span></span></div>
      <ul class="bd-pack__list">
        <?php foreach ($dvFiles as $i => $d): $badges = bd_badges($d[1]); ?>
          <li class="bd-pack__row" style="--i:<?= $i ?>">
            <span class="bd-pack__file" aria-hidden="true"><i></i></span>
            <span class="bd-pack__b">
              <span class="bd-pack__t"><?= e($d[0]) ?></span>
              <span class="bd-pack__path" aria-hidden="true"><?= $dvPad($i + 1) ?>_<?= e(bd_slugify($d[0])) ?>/</span>
            </span>
            <span class="bd-pack__fmts">
              <span class="sr">Formats: <?= e($d[1]) ?></span>
              <?php foreach ($badges as $b): ?><b aria-hidden="true"><?= e($b) ?></b><?php endforeach; ?>
            </span>
            <span class="bd-pack__own" aria-hidden="true">You</span>
            <span class="bd-pack__ok" aria-hidden="true"><?= bd_icon('tick') ?></span>
          </li>
        <?php endforeach; ?>
      </ul>

      <p class="bd-pack__foot">
        <?= bd_icon('shield') ?>
        <span>IP transfers on delivery. Source files, tokens, weights and logs included.</span>
      </p>
    </div>
  </div>
</section>
