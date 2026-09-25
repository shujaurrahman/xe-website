<?php /* DRAFT COPY — review before launch */
/* Index — the showcase, and the page's signature component.
   The filter is a real GET form: work.php reads ?d[]= and ?i[]= and marks the cells that do not match
   with the hidden attribute, so choosing a discipline and pressing "Apply filters" genuinely filters the
   page with JavaScript switched off. assets/js/work/index.js removes the need to press anything: it
   toggles the same hidden attribute on change, rewrites the count and keeps the URL shareable.
   Every card carries the whole record. A record with no photograph draws a plate in code rather than
   borrowing a stock photograph, so nothing here can be mistaken for the project it describes.
   <!-- PLACEHOLDER: replace with real case studies before launch --> */

/* the code-drawn stand-in for a photograph: four wireframe compositions, chosen by record index */
$wkx_plate = function (int $wkx_seed): string {
    $wkx_art = [
        '<g fill="none" stroke="currentColor" stroke-width="1.4">'
        . '<rect x="26" y="30" width="180" height="180" rx="10"/>'
        . '<rect x="228" y="30" width="226" height="52" rx="8"/>'
        . '<rect x="228" y="94" width="226" height="52" rx="8"/>'
        . '<rect x="228" y="158" width="150" height="52" rx="8"/>'
        . '<circle cx="78" cy="78" r="16"/><path d="M40 196 96 132l34 38 30-26 46 52" stroke-width="1"/></g>',

        '<g fill="none" stroke="currentColor" stroke-width="1.4">'
        . '<path d="M40 206h400" stroke-width="1"/>'
        . '<rect x="56" y="126" width="54" height="80" rx="6"/>'
        . '<rect x="142" y="86" width="54" height="120" rx="6"/>'
        . '<rect x="228" y="146" width="54" height="60" rx="6"/>'
        . '<rect x="314" y="58" width="54" height="148" rx="6"/>'
        . '<path d="M56 112 168 72 255 132 341 44" stroke-width="1"/></g>',

        '<g fill="none" stroke="currentColor" stroke-width="1.4">'
        . '<rect x="130" y="24" width="220" height="192" rx="14"/>'
        . '<rect x="160" y="52" width="160" height="136" rx="10"/>'
        . '<rect x="190" y="80" width="100" height="80" rx="7"/>'
        . '<rect x="216" y="104" width="48" height="32" rx="5"/>'
        . '<path d="M40 120h74M366 120h74" stroke-width="1"/></g>',

        '<g fill="none" stroke="currentColor" stroke-width="1.4">'
        . '<path d="M116 74h94M116 166h94M254 120h86M232 92 232 148" stroke-width="1"/>'
        . '<circle cx="100" cy="74" r="14"/><circle cx="100" cy="166" r="14"/>'
        . '<circle cx="226" cy="74" r="14"/><circle cx="226" cy="166" r="14"/>'
        . '<circle cx="354" cy="120" r="18"/>'
        . '<path d="M114 80 210 112M114 160 210 128" stroke-width="1"/></g>',
    ];
    $wkx_i = $wkx_seed % count($wkx_art);
    return '<svg class="wk-plate__art" viewBox="0 0 480 240" preserveAspectRatio="xMidYMid slice"'
         . ' aria-hidden="true" focusable="false">' . $wkx_art[$wkx_i] . '</svg>';
};
$wkx_total = count($WK['cases']);
?>
<section class="band band--alt wk-index" id="index" aria-labelledby="index-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Showcase</p>
        <h2 class="h2" id="index-t"><span class="g">Filter the archive.</span> Read the whole record.</h2>
      </div>
      <div>
        <p class="lead">Pick a discipline, a sector, or both. Each card opens to the full record: the
          problem, what we did, what the client received, what changed and how it was measured.</p>
      </div>
    </div>

    <form class="wk-index__filter" method="get" action="<?= xe_url('work.php') ?>" data-wk-filter>
      <div class="wk-index__sets">
        <fieldset class="wk-index__set">
          <legend class="wk-k">Discipline</legend>
          <div class="wk-index__chips">
            <?php foreach ($WK['disc'] as $wkx_slug => $wkx_row): $wkx_n = $WK['count_d'][$wkx_slug] ?? 0; ?>
              <span class="wk-facet">
                <input type="checkbox" name="d[]" id="wkf-d-<?= e($wkx_slug) ?>" value="<?= e($wkx_slug) ?>"
                       <?= in_array($wkx_slug, $WK['on_d'], true) ? 'checked' : '' ?>
                       <?= $wkx_n === 0 ? 'disabled' : '' ?>>
                <label for="wkf-d-<?= e($wkx_slug) ?>"><?= e($wkx_row['name']) ?><b><?= $wkx_n ?></b></label>
              </span>
            <?php endforeach; ?>
          </div>
        </fieldset>

        <fieldset class="wk-index__set">
          <legend class="wk-k">Sector</legend>
          <div class="wk-index__chips">
            <?php foreach ($WK['industries'] as $wkx_key => $wkx_label): $wkx_n = $WK['count_i'][$wkx_key] ?? 0; ?>
              <span class="wk-facet">
                <input type="checkbox" name="i[]" id="wkf-i-<?= e($wkx_key) ?>" value="<?= e($wkx_key) ?>"
                       <?= in_array($wkx_key, $WK['on_i'], true) ? 'checked' : '' ?>
                       <?= $wkx_n === 0 ? 'disabled' : '' ?>>
                <label for="wkf-i-<?= e($wkx_key) ?>"><?= e($wkx_label) ?><b><?= $wkx_n ?></b></label>
              </span>
            <?php endforeach; ?>
          </div>
        </fieldset>
      </div>

      <div class="wk-index__bar">
        <p class="wk-index__count" role="status" data-wk-count>
          Showing <b class="num"><?= (int) $WK['shown'] ?></b> of <?= (int) $wkx_total ?> records
        </p>
        <noscript><button class="btn btn--ink btn--sm" type="submit">Apply filters</button></noscript>
        <a class="tl wk-index__clear" href="<?= xe_url('work.php') ?>#index" data-wk-clear<?= $WK['filtered'] ? '' : ' hidden' ?>>
          Clear all filters <span class="i" aria-hidden="true">›</span>
        </a>
        <p class="wk-note wk-index__hint">Filters combine: any of the chosen disciplines, in any of the
          chosen sectors. The number beside each chip is how many records carry it.</p>
      </div>
    </form>

    <p class="wk-index__empty" data-wk-empty<?= $WK['shown'] > 0 ? ' hidden' : '' ?>>
      No record matches that combination yet. <a class="tl" href="<?= xe_url('work.php') ?>#index">Clear the filters <span class="i" aria-hidden="true">›</span></a>
    </p>

    <ol class="wk-index__grid" data-wk-grid>
      <?php foreach ($WK['cases'] as $wkx_ci => $wkx_c):
              $wkx_on   = ($WK['matches'])($wkx_c);
              $wkx_pack = $wkx_c['engagement'] !== '' ? ucfirst($wkx_c['engagement']) : ''; ?>
        <li class="wk-index__cell" id="c-<?= e($wkx_c['slug']) ?>"
            data-d="<?= e(implode(' ', $wkx_c['disciplines'])) ?>" data-i="<?= e($wkx_c['sector']) ?>"
            <?= $wkx_on ? '' : 'hidden' ?>>
          <article class="wk-index__card">
            <p class="wk-index__top">
              <span class="bdh-idx"><?= str_pad((string) ($wkx_ci + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <?php if (!empty($wkx_c['placeholder'])): ?>
                <span class="bdh-ill">Placeholder record</span>
              <?php endif; ?>
              <?php if (!empty($wkx_c['confidential'])): ?>
                <span class="bdh-tag">Client named under NDA</span>
              <?php endif; ?>
            </p>

            <?php if (!empty($wkx_c['images'])): $wkx_im = $wkx_c['images'][0]; ?>
              <figure class="bdh-img bdh-img--r169 wk-index__shot">
                <img src="<?= xe_url($wkx_im['src']) ?>" alt="<?= e($wkx_im['alt']) ?>"
                     width="<?= (int) $wkx_im['w'] ?>" height="<?= (int) $wkx_im['h'] ?>" loading="lazy" decoding="async">
              </figure>
            <?php else: ?>
              <div class="wk-plate dots wk-index__plate" style="--wk-seed:<?= $wkx_ci ?>">
                <?= $wkx_plate($wkx_ci) ?>
                <span class="wk-plate__n" aria-hidden="true">R<?= str_pad((string) ($wkx_ci + 1), 2, '0', STR_PAD_LEFT) ?></span>
                <span class="wk-plate__mark bdh-ill">Image to come</span>
                <span class="bdh-sr">No photograph is published for this record yet. A drawing stands in for it.</span>
              </div>
            <?php endif; ?>

            <p class="wk-attrib">
              <span><?= e($wkx_c['attrib']) ?></span>
              <?php if ($wkx_c['scope'] !== ''): ?><em><?= e($wkx_c['scope']) ?></em><?php endif; ?>
            </p>
            <h3 class="bdh-t bdh-t--l wk-index__t"><?= e($wkx_c['title']) ?></h3>
            <p class="bdh-d wk-index__p"><?= e($wkx_c['problem']) ?></p>

            <p class="bdh-tags wk-index__tags">
              <?php foreach ($wkx_c['disc_names'] as $wkx_ds => $wkx_dn): ?>
                <span class="bdh-tag bdh-tag--blue"><?= e($wkx_dn) ?></span>
              <?php endforeach; ?>
            </p>

            <details class="wk-index__rec">
              <summary class="wk-index__sum">
                <span>The full record</span>
                <i class="wk-index__plus" aria-hidden="true"></i>
              </summary>
              <div class="wk-index__body">
                <div class="wk-index__cols">
                  <div>
                    <p class="wk-k">What we did</p>
                    <ul class="bdh-bullets">
                      <?php foreach ($wkx_c['did'] as $wkx_v): ?><li><?= e($wkx_v) ?></li><?php endforeach; ?>
                    </ul>
                  </div>
                  <div>
                    <p class="wk-k">What the client received</p>
                    <ul class="bdh-bullets">
                      <?php foreach ($wkx_c['outputs'] as $wkx_v): ?><li><?= e($wkx_v) ?></li><?php endforeach; ?>
                    </ul>
                  </div>
                </div>

                <div class="wk-index__out">
                  <p class="wk-k">Outcome</p>
                  <p class="wk-index__claim"><?= e($wkx_c['outcome']['claim']) ?></p>
                  <?php if (($wkx_c['outcome']['measure'] ?? '') !== ''): ?>
                    <p class="wk-index__fig num"><?= e($wkx_c['outcome']['measure']) ?></p>
                  <?php else: ?>
                    <p class="wk-index__nofig"><span class="bdh-ill">No figure published</span>
                      A number appears here only with its baseline, its window and the source that
                      verified it. Until then the record says what changed in words.</p>
                  <?php endif; ?>
                  <dl class="wk-rows wk-index__ev">
                    <div><dt>Baseline</dt><dd><?= e($wkx_c['outcome']['baseline']) ?></dd></div>
                    <div><dt>Window</dt><dd><?= e($wkx_c['outcome']['window']) ?></dd></div>
                    <div><dt>Verified by</dt><dd><?= e($wkx_c['outcome']['verified']) ?></dd></div>
                  </dl>
                </div>

                <dl class="wk-rows wk-index__meta">
                  <div><dt>Ran</dt><dd><?= e($wkx_c['dates']['start']) ?> – <?= e($wkx_c['dates']['end']) ?></dd></div>
                  <div><dt>Duration</dt><dd><?= e($wkx_c['dates']['duration']) ?></dd></div>
                  <?php if ($wkx_pack !== ''): ?>
                    <div><dt>Engagement</dt><dd><?= e($wkx_pack) ?> · <a class="wk-index__lk" href="<?= xe_url('approach.php') ?>#engagements">how engagements are shaped</a></dd></div>
                  <?php endif; ?>
                  <div><dt>Sector</dt><dd><?= e($wkx_c['industry_label']) ?></dd></div>
                </dl>

                <?php if (!empty($wkx_c['quote']['text'])): ?>
                  <blockquote class="wk-index__quote">
                    <p><?= e($wkx_c['quote']['text']) ?></p>
                    <footer><?= e(trim(($wkx_c['quote']['name'] ?? '') . ' ' . ($wkx_c['quote']['role'] ?? ''))) ?><?= !empty($wkx_c['quote']['org']) ? ', ' . e($wkx_c['quote']['org']) : '' ?></footer>
                  </blockquote>
                <?php else: ?>
                  <p class="wk-note wk-index__noq"><span class="bdh-ill">No quote published</span>
                    A quote appears here once the person who said it has approved it in writing.</p>
                <?php endif; ?>
              </div>
            </details>
          </article>
        </li>
      <?php endforeach; ?>

      <li class="wk-index__cell wk-index__cell--add">
        <div class="wk-index__add">
          <span class="wk-index__addico" aria-hidden="true"><?= xt_icon('doc', ['size' => 22]) ?></span>
          <p class="wk-attrib"><span>Your sector</span><em>your markets</em></p>
          <h3 class="bdh-t bdh-t--l">Your work goes here</h3>
          <p class="bdh-d">The next record is one entry appended to <code>data/work.php</code>: the problem,
            the decisions, the outputs, the outcome with its baseline, and the images when they clear. The
            filters, the counts and the sector list above rebuild themselves from that file.</p>
          <p class="bdh-tags">
            <span class="bdh-ill">Slot reserved</span>
            <span class="bdh-ill">No code beyond typing</span>
          </p>
          <a class="tl" href="#anatomy">See the record's shape <span class="i" aria-hidden="true">›</span></a>
        </div>
      </li>
    </ol>

    <p class="wk-note wk-index__foot">
      Every record above is a placeholder while real case studies are cleared for publication. Sector
      attribution — <em>Consumer health · nine markets</em> — is also how genuinely confidential work will
      be shown once the real records land.
      <?php if ($WK['filtered']): ?>
        <span class="wk-index__state">Filtered by <?= e(implode(', ', array_map(fn (string $wkx_s): string => $WK['disc'][$wkx_s]['name'], $WK['on_d']))) ?><?= ($WK['on_d'] && $WK['on_i']) ? ' and ' : '' ?><?= e(implode(', ', array_map(fn (string $wkx_s): string => $WK['industries'][$wkx_s], $WK['on_i']))) ?>. <a class="wk-index__lk" href="<?= xe_url('work.php') ?>#index">Clear</a>.</span>
      <?php endif; ?>
    </p>
  </div>
</section>
