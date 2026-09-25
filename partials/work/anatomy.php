<?php /* DRAFT COPY — review before launch */
/* Anatomy — how to read the index. A sample entry with numbered pins on its parts, and the same
   seven numbers explained beside it. Static by design: the pins are labels, not controls, so the
   section reads identically with JavaScript off. */
$wrk_a = null;
foreach ($wrk_cases as $wrk_c) if (empty($wrk_c['featured'])) { $wrk_a = $wrk_c; break; }
if ($wrk_a === null) $wrk_a = $wrk_cases[0] ?? null;
if ($wrk_a !== null):
$wrk_parts = [
    ['Sector, not client', 'Who the work was for. When we cannot name the client, the sector and the shape of the business carry the context instead.'],
    ['The brief', 'The problem in one sentence, as the client put it — before we reframed anything.'],
    ['What we did', 'Which of the six disciplines were involved, and the role each one played. Every discipline links to what it is.'],
    ['The system', 'What the programme left behind and is still running. Not the deck, not the launch — the thing that keeps working.'],
    ['Deliverables', 'The artefacts you would own at the end: the files, the pipelines, the documentation, the logs.'],
    ['Measured by', 'The numbers the programme is judged on. These are measures, not results — the two get confused often, and we keep them apart.'],
    ['Results', 'Deliberately blank. A figure appears here only once the client has approved both the number and the wording.'],
];
?>
<section class="band wrk-anat" id="anatomy" aria-labelledby="anatomy-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>How to read this page</p>
        <h2 class="h2" id="anatomy-t"><span class="g">Every programme</span> is told the same way.</h2>
      </div>
      <div>
        <p class="lead">A portfolio is easy to make persuasive and hard to make checkable. This one is built as a record: the same seven parts for every programme, in the same order, with the one part we are not allowed to fill in left visibly empty.</p>
      </div>
    </div>

    <div class="wrk-anat__grid">

      <ol class="wrk-anat__list" data-bdh-stagger data-bdh-in>
        <?php foreach ($wrk_parts as $wrk_i => $wrk_p): ?>
        <li class="bdh-up"><span class="wrk-anat__n bdh-ro"><?= wrk_n($wrk_i + 1) ?></span>
          <div><h3 class="bdh-t bdh-t--s"><?= e($wrk_p[0]) ?></h3><p class="bdh-d"><?= e($wrk_p[1]) ?></p></div></li>
        <?php endforeach; ?>
      </ol>

      <div class="wrk-anat__spec" data-rv data-rv-d="70">
        <p class="wrk-anat__cap bdh-ro">Sample entry · <?= e($wrk_a['slug']) ?></p>
        <div class="wrk-anat__card bdh-ui" aria-hidden="true">
          <?= wrk_img($wrk_a['img'], ['ratio' => 'r169', 'tag' => 'div', 'class' => 'wrk-anat__img',
              'inner' => '<span class="wrk-pin" data-p="1">01</span>']) ?>
          <div class="wrk-anat__body">
            <p class="wrk-anat__row"><span class="bdh-tag"><?= e($WRK['industries'][$wrk_a['industry']]) ?></span><span class="bdh-ro"><?= e($wrk_a['duration']) ?></span></p>
            <h3 class="bdh-t bdh-t--l"><?= e($wrk_a['title']) ?></h3>
            <p class="wrk-anat__brief"><span class="wrk-pin" data-p="2">02</span><?= e($wrk_a['brief']) ?></p>
            <p class="wrk-anat__chips"><span class="wrk-pin" data-p="3">03</span><?php foreach ($wrk_a['did'] as $wrk_x): $wrk_d = $wrk_disc[$wrk_x[0]] ?? null; if (!$wrk_d) continue; ?><b><?= e($wrk_d['short'] ?? $wrk_d['name']) ?></b><?php endforeach; ?></p>
            <dl class="wrk-anat__dl">
              <div><dt class="bdh-ro"><span class="wrk-pin" data-p="4">04</span>The system</dt><dd><?= e($wrk_a['system']) ?></dd></div>
              <div><dt class="bdh-ro"><span class="wrk-pin" data-p="5">05</span>Deliverables</dt><dd><?= e(implode(' · ', array_slice($wrk_a['deliverables'], 0, 3))) ?> …</dd></div>
              <div><dt class="bdh-ro"><span class="wrk-pin" data-p="6">06</span>Measured by</dt><dd><?= e(implode(' · ', array_slice($wrk_a['measure'], 0, 2))) ?> …</dd></div>
              <div class="wrk-anat__blank"><dt class="bdh-ro"><span class="wrk-pin" data-p="7">07</span>Results</dt><dd><span class="wrk-red" style="--w:6"></span> <span class="wrk-red" style="--w:4"></span> · pending approval</dd></div>
            </dl>
          </div>
        </div>
        <p class="bdh-sr">Illustration: a sample programme entry with its seven parts numbered — the sector, the brief, the disciplines involved, the system left behind, the deliverables, the measures, and the results line, which is blacked out because it has not been approved.</p>
      </div>

    </div>
  </div>
</section>
<?php endif; ?>
