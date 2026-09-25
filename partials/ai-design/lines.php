<?php /* DRAFT COPY — review before launch */
/* Lines — where AI Design stops and the next discipline starts. Buyers ask this in the first call, and
   the capability FAQs in data/ai-design.php answer it plainly, so the page should too.
 *
 * Every link here goes to a discipline hub that exists on disk. The four AI Design capability subpages
 * do not exist yet, so they are still anchors on this page. */
$ln_rows = [
    [
        'slug'  => 'brand-design',
        'name'  => 'Brand Design',
        'they'  => 'The brand system itself: strategy, identity, architecture, guidelines, and the tooling built around them.',
        'we'    => 'The model layer those tools call: the dataset, the tuning, the fidelity scoring, the serving and the re-tuning.',
        'meet'  => 'At the brand check. Their template engine calls our brand model; their guidelines become our scoring set.',
        'cap'   => 'brand-ai-tools',
    ],
    [
        'slug'  => 'technology-intelligence',
        'name'  => 'Technology &amp; Intelligence',
        'they'  => 'AI engineered into business systems: agents, retrieval, data platforms, infrastructure and production evaluation.',
        'we'    => 'What a customer or a colleague actually meets on screen, and the models that make brand work.',
        'meet'  => 'At the acceptance criteria. Design writes them, engineering meets them, and on larger programmes the two run together.',
        'cap'   => 'ai-application-design',
    ],
    [
        'slug'  => 'product-experience',
        'name'  => 'Product &amp; Experience Design',
        'they'  => 'The product: its strategy, its system design and the experience across the whole of it.',
        'we'    => 'The AI surfaces inside it — the assistant, the agentic flow, the multimodal input and the trust surfaces.',
        'meet'  => 'At the design system. AI patterns are added to the product’s own components rather than bolted on beside them.',
        'cap'   => 'ai-application-design',
    ],
    [
        'slug'  => 'marketing-technology',
        'name'  => 'Marketing Technology',
        'they'  => 'The stack that runs campaigns and lifecycle: automation, data, channels and the always-on machinery.',
        'we'    => 'The creative that stack distributes, and the models that produce it under direction.',
        'meet'  => 'At the component feed. Approved parts in, assembled variants out, nothing unreviewed reaching a customer.',
        'cap'   => 'ai-content-studio',
    ],
];
$ln_have = [];
foreach ($SITE['disciplines'] as $ln_d) { $ln_have[$ln_d['slug']] = $ln_d; }
?>
<section class="band aih-ln" id="lines" aria-labelledby="lines-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Where the lines are</p>
        <h2 class="h2" id="lines-t"><span class="g">Four disciplines touch this one.</span> Here is the seam in each case.</h2>
      </div>
      <div>
        <p class="lead">Every one of these overlaps with AI Design somewhere, and the overlap is where programmes go wrong. So the answer is written down: what they own, what we own, and the single artefact the two meet on.</p>
        <p class="aih-note">Many clients buy two of these together. The difference is which side leads.</p>
      </div>
    </div>

    <div class="aih-ln__set">
      <?php foreach ($ln_rows as $ln_i => $ln_r): ?>
        <article class="aih-ln__i" data-rv data-rv-d="<?= 40 + $ln_i * 15 ?>">
          <div class="aih-ln__h">
            <span class="bdh-idx"><?= str_pad((string) ($ln_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <h3 class="aih-ln__t"><?= $ln_r['name'] ?></h3>
            <?php if (isset($ln_have[$ln_r['slug']])): ?>
              <a class="tl aih-ln__l" href="<?= xe_url('services/' . $ln_r['slug'] . '.php') ?>">Their hub <span class="i" aria-hidden="true">›</span></a>
            <?php endif; ?>
          </div>
          <div class="aih-ln__c">
            <p class="aih-k">They own</p>
            <p class="aih-ln__p"><?= e($ln_r['they']) ?></p>
          </div>
          <div class="aih-ln__c aih-ln__c--us">
            <p class="aih-k aih-k--blue">We own</p>
            <p class="aih-ln__p"><?= e($ln_r['we']) ?></p>
          </div>
          <div class="aih-ln__c aih-ln__c--seam">
            <p class="aih-k">They meet at</p>
            <p class="aih-ln__p"><?= e($ln_r['meet']) ?></p>
            <a class="aih-caplink aih-ln__cl" href="#<?= e($ln_r['cap']) ?>"><b><?= e($CAPS[$ln_r['cap']]['n']) ?></b><span><?= e($CAPS[$ln_r['cap']]['short']) ?></span><i aria-hidden="true">›</i></a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <p class="aih-ln__all"><a class="tl" href="<?= xe_url('services/index.php') ?>">All six disciplines, side by side <span class="i" aria-hidden="true">›</span></a></p>
  </div>
</section>
