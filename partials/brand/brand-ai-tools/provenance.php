<?php /* DRAFT COPY — review before launch */
/* 07 Provenance — a content-credentials inspector for one published asset. Left: the asset and
   its manifest. Middle: the timeline (capture → curate → tune → generate → edit → check → approve →
   publish), each event a button. Right: who / what / when for the selected event.
   provenance.js steps through the events until touched; arrow keys move between them. */
// PLACEHOLDER: illustrative manifest, names, times and hashes — confirm before launch
$cat_ev = [   // [step, when, kind, title, who, what, detail, hash, highlight]
    ['Capture',  '08-02 10:02', 'person', 'Reference photographed',        'Photographer · Studio 2',   'Camera raw → ref-0231',              'The source still life was shot in your studio. Rights: owned, recorded at capture.', 'a3f1…9c20', 'source'],
    ['Curate',   '08-04 16:40', 'person', 'Approved into the training set', 'Brand lead · agent suggested', 'ref-0231 → training set v7',      'The agent matched it to palette v7 at 0.94 and suggested approval. A person made the call.', '7be0…11d4', 'source'],
    ['Tune',     '08-19 09:15', 'agent',  'Model version trained',         'Tuning pipeline',           'Image model v4.2 · yours',           'Trained on set v7, scored on the eval set and released after sign-off at the gate.', 'c912…e5a8', 'model'],
    ['Generate', '09-03 11:20', 'agent',  'Variant generated',             'Generation pipeline',       'Model v4.2 · prompt set v3.1 · seed 5521', 'Produced from an approved source with palette, lockup and clear space locked.', '0d6c…a771', 'model'],
    ['Edit',     '09-03 11:48', 'person', 'Crop and headline adjusted',    'Designer',                  'Crop 4:5 safe area · kerning',       'A person tightened the crop and the headline. The edit is recorded, not hidden.', '5e2b…40f9', 'crop'],
    ['Check',    '09-03 11:49', 'agent',  'Brand check passed',            'Brand check',               'Colour ✓ · clear space ✓ · tone 0.91 · rights ✓', 'All four checks passed on the edited file, so it moved to review.', '5e2b…40f9', 'check'],
    ['Approve',  '09-03 14:05', 'person', 'Approved for release',          'Brand lead',                'Note: hold the warm crop for Market 07', 'The release decision sits with a named person, with the note kept in the record.', '5e2b…40f9', 'sign'],
    ['Publish',  '09-03 14:06', 'agent',  'Published with credentials',    'Publishing pipeline',       '54 renditions · 6 formats × 9 markets', 'Every rendition carries the signed manifest and an AI-generated disclosure.', '5e2b…40f9', 'sign'],
];
$cat_pv_sel = 4;
$cat_people = count(array_filter($cat_ev, fn ($cat_e) => $cat_e[2] === 'person'));
$cat_img = fn ($f) => xe_url('assets/imgs/brand/brand-ai-tools/' . $f);
?>
<section class="band cat-paper cat-pv" id="provenance" aria-labelledby="provenance-t">
  <div class="wrap">
    <div class="cat-head" data-rv>
      <div>
        <p class="cat-prompt"><b>$ brandctl inspect 0409-b</b> <span>content credentials · signed manifest</span></p>
        <h2 class="h2" id="provenance-t"><span class="g">Every output can say</span> where it came from.</h2>
      </div>
      <p class="lead">Each published asset carries a signed record: the reference it came from, the model version, every edit, every check and the person who approved it. Open any file and read its history.</p>
    </div>

    <div class="cat-pv__ui" data-rv data-pv-hl="<?= e($cat_ev[$cat_pv_sel][8]) ?>">
      <div class="cat-pv__asset">
        <figure class="cat-pv__fig">
          <!-- PLACEHOLDER: reference photography (Unsplash) standing in for a generated asset — confirm before launch -->
          <img src="<?= $cat_img('out-vase-grapes.jpg') ?>" alt="The published asset: a white vase, a pear and grapes on a linen table" width="1000" height="694" loading="lazy" decoding="async">
          <span class="cat-pv__crop" aria-hidden="true"><i>crop · 4:5 safe area</i></span>
          <span class="cat-pv__cs" aria-hidden="true"><i>clear space ✓</i></span>
          <span class="cat-pv__src" aria-hidden="true"><img src="<?= $cat_img('tile-teapot.jpg') ?>" alt="" width="525" height="700" loading="lazy" decoding="async"><i>ref-0231</i></span>
          <span class="cat-pv__model" aria-hidden="true">model v4.2</span>
          <span class="cat-pv__badge" aria-hidden="true"><b>cr</b> signed</span>
        </figure>
        <dl class="cat-pv__man">
          <div><dt>Asset</dt><dd>0409-b · Product C · Market 03</dd></div>
          <div><dt>Signature</dt><dd><span class="cat-led"></span>Valid · your key</dd></div>
          <div><dt>Disclosure</dt><dd>AI-generated · edited by a person</dd></div>
          <div><dt>Record</dt><dd><?= count($cat_ev) ?> events · <?= $cat_people ?> people</dd></div>
        </dl>
      </div>

      <div class="cat-pv__tlw">
        <p class="cat-pv__legend"><span class="cat-pv__k is-person"></span>Person <span class="cat-pv__k is-agent"></span>Automated <span class="cat-illus">Illustrative</span></p>
        <ol class="cat-pv__tl" aria-label="Provenance timeline">
          <?php foreach ($cat_ev as $cat_ei => $cat_e): ?>
            <li class="is-<?= $cat_e[2] ?>">
              <button type="button" class="cat-pv__ev" data-pv-i="<?= $cat_ei ?>" aria-pressed="<?= $cat_ei === $cat_pv_sel ? 'true' : 'false' ?>" aria-controls="pv-detail">
                <span class="cat-pv__k is-<?= $cat_e[2] ?>" aria-hidden="true"></span>
                <span class="cat-pv__step"><?= e($cat_e[0]) ?></span>
                <span class="cat-pv__title"><?= e($cat_e[3]) ?></span>
                <time class="cat-pv__when"><?= e($cat_e[1]) ?></time>
              </button>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>

      <div class="cat-pv__detail" id="pv-detail" aria-live="polite">
        <?php foreach ($cat_ev as $cat_ei => $cat_e): ?>
          <div class="cat-pv__d" data-pv-d="<?= $cat_ei ?>" data-hl="<?= e($cat_e[8]) ?>"<?= $cat_ei === $cat_pv_sel ? '' : ' hidden' ?>>
            <p class="cat-pv__dk"><span class="cat-pv__k is-<?= $cat_e[2] ?>"></span><?= sprintf('%02d', $cat_ei + 1) ?> · <?= e($cat_e[0]) ?> · <?= $cat_e[2] === 'person' ? 'a person decided' : 'automated, logged' ?></p>
            <h3 class="cat-pv__h"><?= e($cat_e[3]) ?></h3>
            <p class="cat-pv__p"><?= e($cat_e[6]) ?></p>
            <dl class="cat-pv__kv">
              <div><dt>Who</dt><dd><?= e($cat_e[4]) ?></dd></div>
              <div><dt>What</dt><dd><?= e($cat_e[5]) ?></dd></div>
              <div><dt>When</dt><dd><?= e($cat_e[1]) ?> UTC</dd></div>
              <div><dt>Hash</dt><dd><?= e($cat_e[7]) ?></dd></div>
            </dl>
          </div>
        <?php endforeach; ?>
        <!-- PLACEHOLDER: reference photo (Unsplash) — replace with your own review session before launch -->
        <figure class="cat-photo cat-pv__photo">
          <img src="<?= $cat_img('lightbox-review.jpg') ?>" alt="A reviewer leaning over a light table, checking a print by hand" width="667" height="1000" loading="lazy" decoding="async">
          <figcaption><span>Sign-off stays with people</span></figcaption>
        </figure>
      </div>
    </div>
  </div>
</section>
