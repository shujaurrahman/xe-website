<?php /* DRAFT COPY — review before launch */
/* 09 Process — the programme as a deploy log. Each $CAT process step is a deploy entry with its
   weeks, description, artefacts and the log lines of what agents ran and what people decided.
   deploy.js resolves each entry (queued → running → succeeded) as it scrolls in. HTML = final. */
$cat_proc = $CAT['process'];
$cat_lines = [   // per step: [kind, text] — DRAFT COPY; figures illustrative
    [['agent', 'sorted and labelled 3,112 brand assets into 14 categories'], ['agent', 'flagged 188 references with unclear rights'], ['person', 'Brand lead approved training set v7 and the tool scope']],
    [['agent', 'fine-tuned the image model · 4 versions evaluated'], ['agent', 'guardrails written as 11 tests · 640 eval cases'], ['person', 'Brand lead signed off v4.2 at the release gate']],
    [['agent', 'brand check shipped as a design-tool plugin and an API'], ['agent', 'generation pipeline wired into your asset library'], ['person', 'Design lead approved templates and locked slots']],
    [['person', 'pilot team live in Market 03'], ['agent', 're-tuned on 1,240 approved pilot outputs'], ['person', 'handover: weights, datasets, prompts and logs moved to your accounts']],
];
$cat_hash = ['a41c9e2', '7f03bd1', 'c58e21a', '0e9d6f4'];
$cat_arts = 0; foreach ($cat_proc['steps'] as $cat_s) { $cat_arts += count($cat_s[3]); }
?>
<section class="band cat-paper cat-paper--alt cat-dp" id="deploy" aria-labelledby="deploy-t">
  <div class="wrap">
    <div class="cat-head" data-rv>
      <div>
        <p class="cat-prompt"><b>$ brandctl deploy --log</b> <span>how the programme runs · <?= e($CAT['meta'][0]) ?></span></p>
        <h2 class="h2" id="deploy-t"><?php /* DRAFT COPY */ ?><span class="g">Shipped in stages,</span> every stage logged.</h2>
      </div>
      <p class="lead"><?= e($cat_proc['lead']) ?></p>
    </div>

    <div class="cat-dp__ui">
      <ol class="cat-dp__log">
        <?php foreach ($cat_proc['steps'] as $cat_si => $cat_s): ?>
          <li class="cat-dp__e is-done" style="--i:<?= $cat_si ?>">
            <span class="cat-dp__dot" aria-hidden="true"></span>
            <article class="cat-dp__card">
              <p class="cat-dp__top">
                <span class="cat-dp__id">deploy #0<?= $cat_si + 1 ?> · <?= e($cat_hash[$cat_si]) ?></span>
                <span class="cat-dp__st"><span class="cat-dp__stq">queued</span><span class="cat-dp__str">running</span><span class="cat-dp__sts">succeeded</span></span>
                <span class="cat-dp__wk"><?= e($cat_s[1]) ?></span>
              </p>
              <h3 class="cat-dp__h"><?= e($cat_s[0]) ?></h3>
              <p class="cat-dp__desc"><?= e($cat_s[2]) ?></p>
              <ol class="cat-dp__lines">
                <?php foreach ($cat_lines[$cat_si] as $cat_li => $cat_l): ?>
                  <li class="is-<?= $cat_l[0] ?>" style="--k:<?= $cat_li ?>"><b><?= $cat_l[0] === 'person' ? 'person' : 'agent' ?></b><span><?= e($cat_l[1]) ?></span></li>
                <?php endforeach; ?>
              </ol>
              <p class="cat-dp__arts"><span>artefacts</span><?php foreach ($cat_s[3] as $cat_a): ?><em><?= e($cat_a) ?></em><?php endforeach; ?></p>
            </article>
          </li>
        <?php endforeach; ?>
      </ol>

      <aside class="cat-dp__side" aria-label="Deploy summary">
        <!-- PLACEHOLDER: reference photo (Unsplash) — replace with your own pilot team before launch -->
        <figure class="cat-photo cat-dp__photo">
          <img src="<?= xe_url('assets/imgs/brand/brand-ai-tools/edit-suite.jpg') ?>" alt="An editor in headphones working at a screen in a dark edit suite" width="1600" height="809" loading="lazy" decoding="async">
          <figcaption><span>Run phase · pilot team live</span></figcaption>
        </figure>
        <dl class="cat-dp__sum">
          <div><dt>Phases</dt><dd><?= count($cat_proc['steps']) ?></dd></div>
          <div><dt>Length</dt><dd><?= e($CAT['meta'][0]) ?></dd></div>
          <div><dt>Artefacts</dt><dd><?= $cat_arts ?></dd></div>
          <div><dt>Handover</dt><dd>Your accounts</dd></div>
        </dl>
        <p class="cat-dp__legend"><span class="is-agent">agent</span> runs the repetition <span class="is-person">person</span> makes the call</p>
      </aside>
    </div>
  </div>
</section>
