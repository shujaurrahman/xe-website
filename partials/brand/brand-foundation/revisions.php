<?php /* DRAFT COPY — review before launch */
/* §7 Process — the $BD process set as the document's revision history. Each version row opens
   (core [data-acc]) to its description, artefacts, who did what, and a small diff of the draft. */
$cbf_rev_meta = [   // per $BD step: [version, status, agents, people, diff [[-|+|=, text], …]]
    ['v0.1', 'Discovery',  'Transcribe and cluster interviews; read the documents already in circulation; list the category’s repeated claims.',
        'Run the leadership interviews and customer conversations; decide which tensions matter.',
        [['+', 'Tension map · heritage ↔ reinvention, premium ↔ accessible'], ['+', '38 excerpts, 11 strategist-read'], ['=', 'No positioning drafted yet']]],
    ['v0.6', 'Working draft', 'Generate positioning options from the evidence; stress-test each for distinctiveness, credibility and ownability.',
        'Argue the draft in two working sessions; cut options; phrase values as rules.',
        [['-', 'a leading, innovative provider of solutions'], ['+', 'the operations partner for finance teams'], ['+', 'Values rewritten as four decision rules']]],
    ['v1.0', 'Ratified',   'Run the draft against past decisions and draft the reasoning traces; flag any rule that settled nothing.',
        'Choose the test decisions; sign the foundation; own the narrative and the one-page version.',
        [['+', 'Reason to believe: every figure can be traced'], ['=', '3 past decisions re-run · all settled'], ['+', 'Status: Draft → Ratified']]],
];
$cbf_rev_steps = $CAP['process']['steps'];
?>
<section class="band cbf-rev" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <header class="cbf-head cbf-head--split" data-rv>
      <p class="cbf-head__sec"><b>§ 07</b>Revision history</p>
      <div class="cbf-head__body">
        <h2 class="h2" id="process-t"><?php /* DRAFT COPY */ ?><span class="g">Three versions</span> between the first interview and the signature.</h2>
        <p class="lead"><?= e($CAP['process']['lead']) ?></p>
      </div>
    </header>

    <div class="cbf-rev__doc">
      <div class="cbf-rev__cols" aria-hidden="true">
        <span>Version</span><span>Phase</span><span>Weeks</span><span>Status</span>
      </div>
      <!-- PLACEHOLDER: version numbers, excerpt counts and diffs are illustrative — confirm before launch -->
      <ol class="cbf-rev__list" data-acc>
        <?php foreach ($cbf_rev_steps as $cbf_i => $cbf_s): $cbf_m = $cbf_rev_meta[$cbf_i] ?? ['v0.' . $cbf_i, '', '', '', []]; ?>
          <li class="cbf-rev__row" data-rv>
            <h3 class="cbf-rev__h">
              <button type="button" class="cbf-rev__btn" data-acc-b aria-expanded="<?= $cbf_i === 0 ? 'true' : 'false' ?>" aria-controls="process-p-<?= $cbf_i ?>" id="process-b-<?= $cbf_i ?>">
                <span class="cbf-rev__ver"><?= e($cbf_m[0]) ?></span>
                <span class="cbf-rev__name"><?= e($cbf_s[0]) ?></span>
                <span class="cbf-rev__wk"><?= e($cbf_s[1]) ?></span>
                <span class="cbf-rev__st<?= $cbf_i === count($cbf_rev_steps) - 1 ? ' is-final' : '' ?>"><?= e($cbf_m[1]) ?></span>
                <span class="cbf-rev__tog" aria-hidden="true"></span>
              </button>
            </h3>
            <div class="cbf-rev__panel" id="process-p-<?= $cbf_i ?>" data-acc-p role="region" aria-labelledby="process-b-<?= $cbf_i ?>"<?= $cbf_i === 0 ? '' : ' style="height:0"' ?>>
              <div class="cbf-rev__in">
                <div class="cbf-rev__desc">
                  <p class="cbf-rev__p"><?= e($cbf_s[2]) ?></p>
                  <p class="cbf-mono cbf-rev__al">Artefacts</p>
                  <ul class="cbf-rev__arts">
                    <?php foreach ($cbf_s[3] as $cbf_a): ?><li><?= e($cbf_a) ?></li><?php endforeach; ?>
                  </ul>
                </div>
                <dl class="cbf-rev__roles">
                  <div><dt>Agents</dt><dd><?= e($cbf_m[2]) ?></dd></div>
                  <div><dt>People</dt><dd><?= e($cbf_m[3]) ?></dd></div>
                </dl>
                <div class="cbf-rev__diff">
                  <p class="cbf-mono cbf-rev__al">Changes in this version <span class="cbf-ill">Illustrative</span></p>
                  <ul>
                    <?php foreach ($cbf_m[4] as $cbf_d): ?>
                      <li class="is-<?= $cbf_d[0] === '+' ? 'add' : ($cbf_d[0] === '-' ? 'del' : 'same') ?>"><span aria-hidden="true"><?= e($cbf_d[0]) ?></span><span class="bdh-sr"><?= $cbf_d[0] === '+' ? 'Added: ' : ($cbf_d[0] === '-' ? 'Removed: ' : 'Unchanged: ') ?></span><?= $cbf_d[0] === '-' ? '<del>' . e($cbf_d[1]) . '</del>' : e($cbf_d[1]) ?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <!-- PLACEHOLDER: reference photo (Unsplash) — replace with own documentary photography before launch -->
    <figure class="cbf-plate cbf-rev__plate" data-rv>
      <div class="cbf-plate__img"><img src="<?= xe_url('assets/imgs/brand/brand-foundation/revisions-signing.jpg') ?>" alt="Hands signing printed pages on a meeting table" width="1400" height="1050" loading="lazy" decoding="async"></div>
      <figcaption><b>Plate 3</b><span>Version 1.0 is a signature, not a presentation. The people who make the calls sign the document, and every later brief cites the version it started from.</span></figcaption>
    </figure>
  </div>
</section>
