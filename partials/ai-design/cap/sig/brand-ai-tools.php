<?php /* DRAFT COPY — review before launch */
/* Signature — a custom-tuned model making on-brand variants, each run through a brand check; one is sent back.
   Items carry data-s (step 1–4). The variant tiles crop one credited studio photograph (assets/imgs/ai-design/hub). */
$aid_vars = [
    // [label, object-position, scale, checks [name, value, ok], score, state, ok?]
    ['A', '38% 55%', 1.0, [['Colour ΔE', '1.4', true], ['Type', 'pass', true], ['Clear space', 'pass', true]], '0.93', 'Approved', true],
    ['B', '52% 40%', 1.35, [['Colour ΔE', '1.9', true], ['Type', 'pass', true], ['Clear space', 'pass', true]], '0.90', 'Approved', true],
    ['C', '70% 62%', 1.7, [['Colour ΔE', '4.6', false], ['Type', 'pass', true], ['Clear space', '71%', false]], '0.78', 'Regenerate', false],
];
$aid_sig = [
    'head'  => 'brand-model <b>/</b> your-brand <b>/</b> v4',
    'sr'    => 'Illustration: a custom-tuned brand model. A Flux base model with a brand adapter, trained on 1,240 approved assets, is given the prompt "autumn window, ceramic range, three variants". It makes three variants. A brand check scores each on colour difference, type and logo clear space: variants A and B pass at 0.93 and 0.90 and are approved; variant C fails colour and clear space at 0.78 and is sent back to regenerate.',
    'steps' => [
        ['Prompt',      'Step 1 of 4: the tuned brand model receives a prompt.'],
        ['Variants',    'Step 2 of 4: the model makes three variants.'],
        ['Brand check', 'Step 3 of 4: each variant is checked for colour, type and clear space.'],
        ['Decide',      'Step 4 of 4: two variants are approved and one is sent back to regenerate.'],
    ],
];
ob_start(); ?>
<div class="aid-tune" data-s="1">
  <div class="aid-tune__m">
    <p class="aid-k"><span>Tuned model</span></p>
    <p class="aid-tune__n">Flux base + brand adapter v4</p>
    <p class="aid-tune__r">1,240 approved assets · held-out score 0.91</p>
  </div>
  <p class="aid-tune__p"><span>Prompt</span>“Autumn window, ceramic range, three variants.”</p>
</div>
<div class="aid-vars">
  <?php foreach ($aid_vars as $aid_v): ?>
    <div class="aid-var<?= $aid_v[6] ? '' : ' is-flag' ?>">
      <div class="aid-var__img" data-s="2">
        <img src="<?= e(xe_url('assets/imgs/ai-design/hub/studio-vase.jpg')) ?>" width="600" height="450" alt="" loading="lazy" style="object-position:<?= e($aid_v[1]) ?>;transform:scale(<?= e((string) $aid_v[2]) ?>)">
        <span class="aid-var__l"><?= e($aid_v[0]) ?></span>
      </div>
      <ul class="aid-var__c" data-s="3">
        <?php foreach ($aid_v[3] as $aid_ck): ?>
          <li class="<?= $aid_ck[2] ? 'is-ok' : 'is-no' ?>"><span><?= e($aid_ck[0]) ?></span><b><?= e($aid_ck[1]) ?></b></li>
        <?php endforeach; ?>
        <li class="aid-var__s"><span>Score</span><b><?= e($aid_v[4]) ?></b></li>
      </ul>
      <p class="aid-var__st" data-s="4"><?= e($aid_v[5]) ?></p>
    </div>
  <?php endforeach; ?>
</div>
<p class="aid-tune__f" data-s="3"><span>Checks: Brand Design’s governance rules</span><span>Floor 0.85</span></p>
<?php $aid_sig['body'] = ob_get_clean();
