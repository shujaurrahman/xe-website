<?php /* DRAFT COPY — review before launch */
/* 04.4 Vision — a before/after slider on two scenes (a bottling line, a retail shelf). Left of the handle:
   the camera frame. Right of it: the same frame with detections, confidence and the review flag. Beside it,
   the per-class results with precision and recall and what each detection triggers. Below, the two model
   routes: a fine-tuned detector at the edge, or a multimodal model for documents.
   Every box, class and score is illustrative. vision.js drives the slider sweep. */
$tapv_scenes = [
    [
        'key' => 'line', 'tab' => 'Bottling line', 'img' => 'vision-line.jpg', 'x' => 22,
        'alt' => 'Seven dark wine bottles with yellow capsules pass along a conveyor in front of stainless steel tanks',
        'frame' => 'Line 2 · camera 3 · frame 18,204', 'model' => 'detector v2.3 · edge GPU · 14 ms',
        'boxes' => [   // [class, left, top, width, height, confidence, kind: ok | flag | review, label shown (default: class), label below the box, short label on phones]
            ['capsule_ok',  21.4, 44.5, 6.4, 39, '0.99', 'ok', 'ok'],
            ['capsule_ok',  28.5, 44.5, 6.4, 39, '0.98', 'ok', 'ok'],
            ['capsule_ok',  38.4, 44.5, 6.4, 39, '0.99', 'ok', 'ok'],
            ['occluded',    48.6, 44.5, 6.4, 39, '0.62', 'review', '', true, 'occl'],
            ['capsule_ok',  59.2, 44.5, 6.4, 39, '0.97', 'ok', 'ok'],
            ['capsule_ok',  68.8, 44.5, 6.4, 39, '0.98', 'ok', 'ok'],
            ['capsule_ok',  78.9, 44.5, 6.4, 39, '0.98', 'ok', 'ok'],
            ['pitch_short', 24.6, 85,   7.1, 3.2, '0.94', 'flag', 'pitch 0.7×', true, 'pitch'],
        ],
        'rows' => [   // [class, count, precision, recall, action]
            ['capsule_ok', '6', '0.99', '0.98', 'Pass'],
            ['pitch_short', '1', '0.95', '0.93', 'Slow the infeed to re-space'],
            ['occluded', '1', '0.88', '0.90', 'Re-check at camera 4 · 0.62 < 0.70'],
        ],
        'sum' => '7 bottles · 1 spacing fault · 1 to re-check',
    ],
    [
        'key' => 'shelf', 'tab' => 'Retail shelf', 'img' => 'vision-shelf.jpg', 'x' => 22,
        'alt' => 'A chilled supermarket shelf of milk and soy milk cartons in rows above electronic price labels',
        'frame' => 'Store 114 · aisle 6 · photo 09:12', 'model' => 'detector v1.8 + OCR · phone app · 0.9 s',
        'boxes' => [
            ['facings · 9',    20.5, 10,   41,  18.5, '0.97', 'ok'],
            ['facings · 8',    19.5, 37.5, 37.5, 19.5, '0.96', 'ok', '', true],
            ['price_tag',      20.6, 31.4, 5.2, 3.8, '0.98', 'ok', '', true, 'tag'],
            ['price_mismatch', 36.2, 60.2, 5.2, 3.8, '0.88', 'flag', '', true, 'price'],
            ['gap',            13.8, 11,   6.4, 17,  '0.93', 'flag'],
            ['low_stock',      67.4, 10,   9.2, 18.5, '0.66', 'review', '', true, 'low'],
        ],
        'rows' => [
            ['facings', '17', '0.97', '0.95', 'Planogram check'],
            ['price_tag', '9', '0.98', '0.96', 'OCR against the price file'],
            ['price_mismatch', '1', '0.91', '0.88', 'Task to store staff'],
            ['gap', '1', '0.94', '0.92', 'Replenishment request'],
            ['low_stock', '1', '0.79', '0.83', 'Human review · 0.66 < 0.70'],
        ],
        'sum' => '17 facings in frame · 1 price mismatch · 1 gap',
    ],
];
?>
<section class="band band--alt tap-vision" id="vision" aria-labelledby="vision-t">
  <div class="wrap">
    <div class="tap-head" data-rv>
      <div>
        <p class="tap-eb"><span class="tap-eb__box" aria-hidden="true"></span><span class="tap-eb__n">04.4</span><span>Vision &amp; documents</span><span class="tap-eb__p">/vision</span></p>
        <h2 class="h2" id="vision-t"><span class="g">Vision that counts,</span> reads and checks.</h2>
      </div>
      <div>
        <p class="lead">Drag the handle to compare the camera frame with what the model saw. Every detection carries a class and a confidence; anything under the review threshold goes to a person, and their corrections become training data for the next model version.</p>
      </div>
    </div>

    <div class="tap-vis" data-rv>
      <div class="tap-vis__top">
        <div class="bdh-seg" role="tablist" aria-label="Scene">
          <?php foreach ($tapv_scenes as $tapv_i => $tapv_s): ?>
            <button type="button" role="tab" id="vis-t<?= $tapv_i ?>" aria-controls="vis-p<?= $tapv_i ?>" aria-selected="<?= $tapv_i === 0 ? 'true' : 'false' ?>"<?= $tapv_i ? ' tabindex="-1"' : '' ?>><?= e($tapv_s['tab']) ?></button>
          <?php endforeach; ?>
        </div>
        <p class="tap-vis__hint"><span class="tap-ill">Illustrative detections</span><span>Review threshold 0.70</span></p>
      </div>

      <div class="bdh-panes">
        <?php foreach ($tapv_scenes as $tapv_i => $tapv_s): ?>
          <div class="bdh-pane tap-vis__pane<?= $tapv_i === 0 ? ' is-on' : '' ?>" id="vis-p<?= $tapv_i ?>" role="tabpanel" aria-labelledby="vis-t<?= $tapv_i ?>">
            <div class="tap-vis__grid">
              <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
              <figure class="tap-vis__fig tap-glass" style="--x:<?= $tapv_s['x'] ?>%">
                <div class="tap-vis__frame">
                  <img class="tap-vis__img" src="<?= xe_url('assets/imgs/tech/ai-product-automation/' . $tapv_s['img']) ?>" alt="<?= e($tapv_s['alt']) ?>" width="1600" height="1067" loading="lazy" decoding="async">
                  <div class="tap-vis__after" aria-hidden="true">
                    <img class="tap-vis__img" src="<?= xe_url('assets/imgs/tech/ai-product-automation/' . $tapv_s['img']) ?>" alt="" width="1600" height="1067" loading="lazy" decoding="async">
                    <?php foreach ($tapv_s['boxes'] as $tapv_j => $tapv_b): ?>
                      <span class="tap-vbox tap-vbox--<?= $tapv_b[6] ?><?= !empty($tapv_b[8]) ? ' tap-vbox--below' : '' ?>" style="--l:<?= $tapv_b[1] ?>%;--t:<?= $tapv_b[2] ?>%;--w:<?= $tapv_b[3] ?>%;--h:<?= $tapv_b[4] ?>%;--j:<?= $tapv_j ?>">
                        <b><span class="tap-vbox__full"><?= e(($tapv_b[7] ?? '') !== '' ? $tapv_b[7] : $tapv_b[0]) ?></span><?php if (!empty($tapv_b[9])): ?><span class="tap-vbox__short"><?= e($tapv_b[9]) ?></span><?php endif; ?> <em><?= e($tapv_b[5]) ?></em></b>
                      </span>
                    <?php endforeach; ?>
                  </div>
                  <span class="tap-vis__chip tap-vis__chip--l" aria-hidden="true">Camera frame</span>
                  <span class="tap-vis__chip tap-vis__chip--r" aria-hidden="true">Detections</span>
                  <span class="tap-vis__handle" aria-hidden="true"><i></i></span>
                  <input class="tap-vis__range" type="range" min="0" max="100" step="1" value="<?= $tapv_s['x'] ?>" aria-label="Detection overlay: move left to show more detections, right to show more of the camera frame" aria-valuetext="Detections shown on <?= 100 - $tapv_s['x'] ?>% of the frame">
                </div>
                <figcaption class="tap-vis__cap"><span><?= e($tapv_s['frame']) ?></span><span><?= e($tapv_s['model']) ?></span></figcaption>
                <span class="tap-glass__c" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
              </figure>

              <div class="tap-vis__res">
                <p class="tap-vis__sum"><?= e($tapv_s['sum']) ?></p>
                <div class="bdh-scroll-x tap-vis__tw" tabindex="0" role="region" aria-label="<?= e($tapv_s['tab']) ?> detection results, scroll sideways if needed">
                  <table class="tap-vis__table">
                    <caption class="bdh-sr"><?= e($tapv_s['tab']) ?>: detections per class with precision and recall on the validation set, and the action each one triggers (illustrative)</caption>
                    <thead><tr><th scope="col">Class</th><th scope="col">Count</th><th scope="col"><abbr title="Precision">P</abbr></th><th scope="col"><abbr title="Recall">R</abbr></th></tr></thead>
                    <tbody>
                      <?php foreach ($tapv_s['rows'] as $tapv_r): ?>
                        <tr><th scope="row"><code><?= e($tapv_r[0]) ?></code><span><?= e($tapv_r[4]) ?></span></th><td><?= e($tapv_r[1]) ?></td><td><?= e($tapv_r[2]) ?></td><td><?= e($tapv_r[3]) ?></td></tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
                <dl class="tap-vis__defs">
                  <div><dt>Precision</dt><dd>Of everything flagged, the share that was right. Low precision wastes people’s time.</dd></div>
                  <div><dt>Recall</dt><dd>Of the real defects, the share that was caught. Low recall lets problems through.</dd></div>
                </dl>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="tap-vis__routes" data-rv-s>
      <article class="tap-vis__route">
        <p class="tap-vis__rk"><?= xt_icon('scan', ['size' => 20]) ?>Route A</p>
        <h3 class="tap-vis__rt">Fine-tuned detector at the edge</h3>
        <p class="tap-vis__rd">A YOLO-family or similar object detector trained on your labelled images, exported to ONNX and run on a camera-side GPU in tens of milliseconds per frame. For counting, inspection and anything that moves on a line.</p>
        <p class="tap-vis__rm"><span>Frames per second</span><span>Precision and recall per class</span><span>Works offline</span></p>
      </article>
      <article class="tap-vis__route">
        <p class="tap-vis__rk"><?= xt_icon('doc', ['size' => 20]) ?>Route B</p>
        <h3 class="tap-vis__rt">Multimodal model for documents</h3>
        <p class="tap-vis__rd">A vision-language model reads layout, tables, stamps and handwriting and returns JSON against a schema, validated before anything posts. Seconds per page, run in your cloud or through a provider with data-processing terms.</p>
        <p class="tap-vis__rm"><span>Field-level accuracy</span><span>Straight-through rate</span><span>Schema validation</span></p>
      </article>
      <article class="tap-vis__route tap-vis__route--loop">
        <p class="tap-vis__rk"><?= xt_icon('approve', ['size' => 20]) ?>Both routes</p>
        <h3 class="tap-vis__rt">People review the uncertain cases</h3>
        <p class="tap-vis__rd">A review queue shows the frame, the box and the model’s guess. One click confirms or corrects it. Corrections are versioned as labelled data, and the next model only ships if it beats the current one on the held-out set.</p>
        <p class="tap-vis__rm"><span>Review queue</span><span>Labelled data</span><span>Held-out test set</span></p>
      </article>
    </div>
  </div>
</section>
