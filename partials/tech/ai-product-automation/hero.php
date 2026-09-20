<?php /* DRAFT COPY — review before launch */
/* Hero — mirrored split. Left: an editorial photograph of a clipboard; the supplier invoice on its sheet is
   code-built HTML (fictional), opened up by document AI: layout boxes draw corner-first, confidence counts,
   the JSON fills field by field, the one uncertain field (a quantity corrected by hand in pencil) waits for
   an accounts-payable clerk, then posts to the ERP — the same invoice-to-ERP story as the automation
   section below. Right: breadcrumb, eyebrow, h1, lead, actions, meta.
   The HTML is the finished run (all fields extracted, approved, posted). hero.js replays it.
   Box geometry is in % of the invoice sheet (.tap-inv), which sits over the paper in the photograph. */
$taph_boxes = [   // [json key, left %, top %, width %, height %, confidence, JSON value, kind: '' | 'pii' | 'review', label side: 'tl' | 'tr' | 'bl' | 'br' | 'l']
    // Boxes keep at least a 6% vertical gap in the same column; each label sits on its box's free side.
    ['supplier',     4,   9.4, 47,  6.4, '0.99', '"Your supplier Pvt Ltd"', '',       'tl'],
    ['invoice_no',  58,   9.4, 38,  6.4, '0.99', '"INV-24-01873"',          '',       'tr'],
    ['gstin',        4,  22.2, 46,  4.8, '0.98', '"27AABCY1234K1Z8"',       '',       'bl'],
    ['line_items',   3,  38.2, 94, 25.4, '0.86', '[4 rows]',                'review', 'tr'],
    ['total',       54,  73.2, 43,  5.8, '0.97', '108984.80',               '',       'l'],
    ['bank_account', 4,  82.6, 47,  4.8, '0.96', '"[REDACTED:BANK]"',       'pii',    'bl'],
];
$taph_items = [   // [description, qty, rate, amount]
    ['Stainless steel jug, 1.5 L', '40',  '820.00',   '32,800.00'],
    ['Blender motor base, 750 W',  '20',  '2,150.00', '43,000.00'],
    ['Blade assembly, 4-wing',     '60',  '240.00',   '14,400.00'],
    ['Shipping carton, 5-ply',     '120', '18.00',    '2,160.00'],
];
$taph_steps = ['Ingest', 'Layout', 'Extract', 'Validate', 'Review', 'Post'];
?>
<section class="band tap-hero" id="top" aria-labelledby="hero-t">
  <span class="tap-hero__grid dots" aria-hidden="true"></span>
  <div class="wrap tap-hero__in">

    <div class="tap-hero__stage">
      <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
      <figure class="tap-hero__fig tap-glass" data-hero-stage="6">
        <div class="tap-hero__frame"><div class="tap-hero__canvas">
        <div class="bdh-img tap-hero__img">
          <img src="<?= xe_url('assets/imgs/tech/ai-product-automation/hero-invoice.jpg') ?>" alt="" width="1360" height="1700" fetchpriority="high" decoding="async">
        </div>
        <div class="tap-hero__ov" aria-hidden="true">
          <div class="tap-inv">
            <div class="tap-inv__doc">
              <p class="tap-inv__r tap-inv__kind" style="--y:2.6"><b>Tax invoice</b><span>Original for recipient</span></p>
              <p class="tap-inv__r tap-inv__name" style="--y:10.6">Your supplier Pvt Ltd</p>
              <p class="tap-inv__r tap-inv__sm" style="--y:17.2">Industrial Estate, Pune 411019</p>
              <p class="tap-inv__r" style="--y:23.4">GSTIN 27AABCY1234K1Z8</p>
              <dl class="tap-inv__ref">
                <div style="--y:11.2"><dt>Invoice no.</dt><dd>INV-24-01873</dd></div>
                <div style="--y:17.2"><dt>Date</dt><dd>12 Sep 2026</dd></div>
                <div style="--y:22.4"><dt>PO</dt><dd>4500-2231</dd></div>
              </dl>
              <p class="tap-inv__r tap-inv__sm tap-inv__to" style="--y:31.4"><span>Bill to</span>Your company · Receiving dock 2</p>
              <div class="tap-inv__row tap-inv__th" style="--y:40"><span>#</span><span>Description</span><span>Qty</span><span>Rate</span><span>Amount ₹</span></div>
              <?php foreach ($taph_items as $taph_i => $taph_it): ?>
                <div class="tap-inv__row" style="--y:<?= 45.8 + $taph_i * 4.5 ?>"><span><?= $taph_i + 1 ?></span><span><?= e($taph_it[0]) ?></span><span<?= $taph_i === 0 ? ' class="tap-inv__fix"' : '' ?>><?= e($taph_it[1]) ?></span><span><?= e($taph_it[2]) ?></span><span><?= e($taph_it[3]) ?></span></div>
              <?php endforeach; ?>
              <svg class="tap-inv__pencil" viewBox="0 0 70 24"><path d="M3 6 C7 3 13 4 12 8 C11.5 10 9 11 7.5 11 C12 11 14 14 12 17 C10 20 5 20 3 18"/><path d="M26 4 C21 5 18 11 18.5 15 C19 19 24 20 25.5 16.5 C27 13 23 11 19.5 13.5"/><path d="M42 14.5 L67 9.5"/></svg>
              <div class="tap-inv__tot">
                <p style="--y:66.4"><span>Subtotal</span><span>92,360.00</span></p>
                <p style="--y:70"><span>IGST 18%</span><span>16,624.80</span></p>
                <p class="tap-inv__grand" style="--y:73.6"><span>Total</span><span>₹ 1,08,984.80</span></p>
              </div>
              <p class="tap-inv__r tap-inv__sm" style="--y:83.6">Bank a/c 50200034117417 · IFSC YOUR0001234</p>
            </div>
            <span class="tap-hero__scan"></span>
            <?php foreach ($taph_boxes as $taph_i => $taph_b): ?>
              <span class="tap-hbox tap-hbox--<?= $taph_b[8] ?> is-on<?= $taph_b[7] ? ' tap-hbox--' . $taph_b[7] : '' ?>" data-hbox="<?= $taph_i ?>" style="--l:<?= $taph_b[1] ?>%;--t:<?= $taph_b[2] ?>%;--w:<?= $taph_b[3] ?>%;--h:<?= $taph_b[4] ?>%">
                <i></i><i></i><i></i><i></i>
                <?php if ($taph_b[7] === 'pii'): ?><span class="tap-hbox__red"><b></b></span><?php endif; ?>
                <b class="tap-hbox__lbl"><?= e($taph_b[0]) ?> <em><?= $taph_b[7] === 'pii' ? 'redacted' : e($taph_b[5]) ?></em></b>
              </span>
            <?php endforeach; ?>
          </div>
        </div>
        </div></div>
        <figcaption class="tap-hero__bar" aria-hidden="true">
          <ol class="tap-hero__steps">
            <?php foreach ($taph_steps as $taph_i => $taph_s): ?>
              <li class="is-done<?= $taph_i === count($taph_steps) - 1 ? ' is-on' : '' ?>"><b><?= sprintf('%02d', $taph_i + 1) ?></b><span><?= e($taph_s) ?></span></li>
            <?php endforeach; ?>
          </ol>
        </figcaption>
        <span class="tap-glass__c" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
        <div class="tap-hjson tap-win tap-win--ink tap-on-ink">
          <div class="tap-win__bar">
            <span class="tap-win__dots" aria-hidden="true"><i></i><i></i><i></i></span>
            <span class="tap-win__path"><b>extract.json</b> · doc-ai v3</span>
            <span class="tap-win__end">
              <button type="button" class="tap-hjson__pause" data-hero-pause aria-pressed="false" hidden>Pause</button>
            </span>
          </div>
          <ol class="tap-hjson__code" aria-hidden="true">
            <li class="tap-hjson__p">{</li>
            <?php foreach ($taph_boxes as $taph_i => $taph_b): ?>
              <li class="tap-hjson__ln is-on<?= $taph_b[7] === 'review' ? ' is-flag' : '' ?>" data-hl="<?= $taph_i ?>">
                <code><span class="k">"<?= e($taph_b[0]) ?>"</span>: <span class="v" data-v><?= e($taph_b[6]) ?></span><?= $taph_i < count($taph_boxes) - 1 ? ',' : '' ?></code>
                <span class="tap-conf<?= $taph_b[7] === 'review' ? ' is-low' : '' ?>" style="--v:<?= e($taph_b[5]) ?>"><span data-c><?= e($taph_b[5]) ?></span><span class="tap-conf__bar"></span></span>
              </li>
            <?php endforeach; ?>
            <li class="tap-hjson__p">}</li>
          </ol>
          <p class="tap-hjson__route" data-route-state="post">
            <span class="tap-hjson__dot" aria-hidden="true"></span>
            <span data-route>Posted to ERP · approved by AP clerk</span>
          </p>
        </div>
      </figure>
      <p class="bdh-sr">Illustrative invoice extraction on a fictional supplier invoice. The invoice is photographed on a clipboard, its layout is detected and six fields are extracted with confidence scores between 0.86 and 0.99: supplier, invoice number, GSTIN, line items, total and bank account. The bank account number is redacted before logging. The line items score 0.86, below the 0.90 threshold, because one quantity was corrected by hand in pencil, so an accounts-payable clerk checks them. Once approved, the invoice is posted to the ERP.</p>
    </div>

    <div class="tap-hero__text">
      <nav class="tap-crumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="<?= xe_url('services/') ?>">Services</a></li>
          <li><a href="<?= xe_url('services/technology-intelligence.php') ?>"><?= e($TECH['name']) ?></a></li>
          <li><span aria-current="page"><?= e($CAP['name']) ?></span></li>
        </ol>
      </nav>
      <p class="tap-eb tap-hero__eb"><span class="tap-eb__box" aria-hidden="true"></span><span>Capability <span class="tap-eb__n"><?= e($CAP['n']) ?></span> of <?= count($TECH['caps']) ?></span><span class="tap-eb__p">AI in the product, not beside it</span></p>
      <h1 class="tap-hero__h" id="hero-t"><span class="g">AI features that show their working,</span> and automation that finishes the job.</h1>
      <p class="lead tap-hero__lead"><?= e($CAP['lead']) ?></p>
      <div class="tap-hero__act">
        <a class="btn btn--ink btn--lg" href="<?= xe_url('contact.php') ?>">Scope an AI feature <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out btn--lg" href="#inspector">Inspect a RAG answer <span class="i" aria-hidden="true">›</span></a>
      </div>
      <!-- PLACEHOLDER: confirm typical timeframe before launch -->
      <dl class="tap-hero__meta">
        <?php foreach ($CAP['meta'] as $taph_i => $taph_m): ?>
          <div><dt><?= e($CAP['meta_k'][$taph_i] ?? '') ?></dt><dd><?= e($taph_m) ?></dd></div>
        <?php endforeach; ?>
      </dl>
    </div>

  </div>
</section>
