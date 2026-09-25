<?php /* DRAFT COPY — review before launch */
/* Inbox — the brief exactly as it reaches us. Rendered on the server from ct_blocks(), the same
   structure that composes the email, so what is shown here and what is sent can never drift.
   contact.js rebuilds it from the form as you type (it reads the data-pv labels in #brief, which
   are the same labels); with JavaScript off it is a correct, complete picture of the values in the
   page right now, which for a first load is the empty template — and that template is itself useful,
   because it is the shape of a brief we can price. */
$ct_pv_who = [
    ['Who is asking',                'The lead for the discipline, and nobody else', 'users'],
    ['What they need',               'Routed by service to the team that would do the work', 'workflow'],
    ['The brief',                    'Read first, before anything commercial', 'doc'],
    ['Commercials and the decision', 'The engagement lead, to shape a scope that fits', 'cost'],
    ['Practicalities',               'Acted on before the first call — NDA, access, language', 'clipboard-check'],
];
$ct_pv_i = 0;
?>
<section class="band band--ink ct-inbox" id="inbox" aria-labelledby="inbox-t">
  <div class="wrap bdh-grid ct-inbox__grid">

    <div class="bdh-c4 ct-inbox__side">
      <div class="bdh-sticky ct-inbox__stick">
        <div class="bdh-head ct-inbox__head" data-rv>
          <p class="lbl lbl--blue"><span class="dot"></span>No black box</p>
          <h2 class="h2" id="inbox-t"><span class="g">This is the whole thing</span> that lands in our inbox.</h2>
          <p class="lead">One plain-text email, plus your attachment if you send one. It is written as you fill the form in, and you can read every line of it before you press send.</p>
        </div>

        <ul class="ct-inbox__who">
          <?php foreach ($ct_pv_who as $ct_w): ?>
            <li>
              <span class="ct-inbox__wi" aria-hidden="true"><?= xt_icon($ct_w[2], ['size' => 18]) ?></span>
              <b><?= e($ct_w[0]) ?></b>
              <span><?= e($ct_w[1]) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>

        <ul class="ct-inbox__never">
          <li>Nothing is written to this website — no database, no file on disk, no copy of your attachment.</li>
          <li>No tracking pixel, no mailing list, no third-party form service in between.</li>
          <li>Reply-To is set to your address, so answering the email answers you.</li>
        </ul>
        <!-- PLACEHOLDER: confirm the lead destination (inbox or CRM) and this description of it before launch -->
      </div>
    </div>

    <div class="bdh-c8 ct-inbox__doc" data-rv data-rv-d="80">
      <div class="bdh-ui bdh-ui--ink ct-pv">
        <div class="bdh-ui__bar ct-pv__bar">
          <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
          <span class="ct-pv__file">brief.txt</span>
          <span class="ct-pv__to">to <?= e($SITE['company']['email']) ?></span>
          <button class="ct-pv__copy" type="button" hidden data-ct-copy>Copy this brief</button>
        </div>
        <div class="ct-pv__scroll bdh-scroll-x" tabindex="0" role="region" aria-labelledby="inbox-t">
          <div class="ct-pv__body" data-ct-pvbody data-site="<?= e($SITE['company']['name']) ?>">
            <p class="ct-pv__top">
              <span><?= $ct_v['depth'] === 'rfq' ? 'New RFQ' : 'New brief' ?> from the <?= e($SITE['company']['name']) ?> website</span>
              <span>Reference: <i>assigned when you send</i></span>
              <span>Depth:     <?= e($CT['depths'][$ct_v['depth']][0]) ?></span>
            </p>
            <?php foreach ($ct_blocks as $ct_bk): $ct_pv_i++; ?>
              <div class="ct-pv__blk">
                <p class="ct-pv__bt"><span class="ct-pv__bn"><?= str_pad((string) $ct_pv_i, 2, '0', STR_PAD_LEFT) ?></span>— <?= e(strtoupper($ct_bk['title'])) ?></p>
                <dl class="ct-pv__rows">
                  <?php foreach ($ct_bk['rows'] as $ct_r): $ct_has = trim((string) $ct_r[1]) !== ''; ?>
                    <div class="ct-pv__r<?= $ct_has ? '' : ' is-empty' ?>">
                      <dt><?= e($ct_r[0]) ?></dt>
                      <dd<?= !empty($ct_r[2]) ? ' class="ct-pv__v--long"' : '' ?>><?= $ct_has ? e($ct_r[1]) : 'not answered' ?></dd>
                    </div>
                  <?php endforeach; ?>
                </dl>
              </div>
            <?php endforeach; ?>
            <div class="ct-pv__blk">
              <p class="ct-pv__bt"><span class="ct-pv__bn"><?= str_pad((string) ($ct_pv_i + 1), 2, '0', STR_PAD_LEFT) ?></span>— ATTACHMENT</p>
              <dl class="ct-pv__rows">
                <div class="ct-pv__r is-empty" data-ct-pvdoc>
                  <dt>Document</dt>
                  <dd>none attached</dd>
                </div>
              </dl>
            </div>
          </div>
        </div>
        <p class="ct-pv__foot"><span class="ct-pv__live" data-ct-pvlive hidden>Updates as you type</span><span>Values you have entered on this page. Nothing has been sent.</span></p>
      </div>
    </div>

  </div>
</section>
