<?php /* DRAFT COPY — review before launch */
/* Case studies, set out as case files rather than cards: the record on the left, the spine down the
   middle, the plate on the right. It exists so the reader can see at a glance what a case study on
   this site contains — and that none of them claims a client result. */
$cas_list = [];
foreach ($POSTS as $cas_p) { if ($cas_p['type'] === 'case-study') $cas_list[] = $cas_p; }
if (!$cas_list) return;
$cas_spine = blog_case_spine();
?>
<section class="band band--ink blg-cases" id="cases" aria-labelledby="cases-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Case studies · <?= count($cas_list) ?></p>
        <h2 class="h2" id="cases-t"><span class="g">Every case study</span> is set out the same way.</h2>
      </div>
      <div>
        <p class="lead">Six stages, in the same order, every time: the brief, what could not move, what we did, who did what, what we measure, and what the client owns afterwards. The order is the argument — it puts the constraints before the solution and the handover before the outcome.</p>
        <a class="btn btn--white" href="<?= xe_url('work.php') ?>">See the full programme index <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <ol class="blg-cases__l" data-rv-s data-rv-step="90">
      <?php foreach ($cas_list as $cas_p): $cas_c = $cas_p['case']; ?>
        <li class="blg-cases__i">
          <article class="blg-casef">
            <div class="blg-casef__rec">
              <p class="blg-casef__k">Case file</p>
              <h3 class="blg-casef__t">
                <?php if ($cas_p['live']): ?><a href="<?= e($cas_p['url']) ?>"><?= e($cas_p['title']) ?></a><?php else: ?><?= e($cas_p['title']) ?><?php endif; ?>
              </h3>
              <p class="blg-casef__d"><?= e($cas_p['dek']) ?></p>
              <dl class="blg-casef__dl">
                <div><dt>Sector</dt><dd><?= e($cas_c['sector']) ?></dd></div>
                <div><dt>Shape</dt><dd><?= e($cas_c['shape']) ?></dd></div>
                <div><dt>Duration</dt><dd><?= e($cas_c['duration']) ?></dd></div>
                <div><dt>Client</dt><dd>Not named</dd></div>
              </dl>
              <?php if ($cas_p['live']): ?>
                <a class="btn btn--white btn--sm" href="<?= e($cas_p['url']) ?>">Open the case file <span class="i" aria-hidden="true">›</span></a>
              <?php else: ?>
                <span class="bdh-ill">Page pending</span>
              <?php endif; ?>
            </div>

            <ol class="blg-casef__spine" aria-label="The six stages of this case study">
              <?php $cas_n = 1; foreach ($cas_spine as $cas_k => $cas_label): ?>
                <li><span class="blg-casef__sn" aria-hidden="true"><?= e(str_pad((string) $cas_n, 2, '0', STR_PAD_LEFT)) ?></span><span class="blg-casef__sl"><?= e($cas_label) ?></span>
                  <span class="blg-casef__sc"><?php
                    echo $cas_k === 'constraints' ? count($cas_c['constraints']) . ' fixed'
                       : ($cas_k === 'did' ? count($cas_c['movements']) . ' movements'
                       : ($cas_k === 'disciplines' ? count($cas_c['matrix']) . ' practices'
                       : ($cas_k === 'changed' ? count($cas_c['changed']) . ' measures'
                       : ($cas_k === 'owns' ? count($cas_c['owns']) . ' artefacts' : $cas_p['minutes'] . ' min'))));
                  ?></span>
                </li>
              <?php $cas_n++; endforeach; ?>
            </ol>

            <div class="blg-casef__plate">
              <span class="bdh-img bdh-img--r34 blg-casef__img">
                <img src="<?= xe_url('assets/imgs/blog/' . $cas_p['cover']['file']) ?>" alt="" width="<?= (int) $cas_p['cover']['w'] ?>" height="<?= (int) $cas_p['cover']['h'] ?>" loading="lazy" decoding="async"
                     <?= !empty($cas_p['cover']['pos']) ? 'style="object-position:' . e($cas_p['cover']['pos']) . '"' : '' ?>>
              </span>
              <p class="blg-casef__ill">Illustration · reference photograph</p>
            </div>
          </article>
        </li>
      <?php endforeach; ?>
    </ol>

    <p class="blg-cases__note">
      <!-- PLACEHOLDER: the case studies in the journal are in-house illustrations. Replace with real, client-approved write-ups before launch. -->
      Every case file above is written in-house as an illustration. No client is named, no number is a client result, and nothing here has been endorsed by anyone.
    </p>
  </div>
</section>
