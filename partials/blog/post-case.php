<?php /* DRAFT COPY — review before launch */
/* The case-study spine — a dossier, not an article with different words. Six fixed stages, in the same
   order every time: the brief, what could not move, what we did, who did what, what we measure, what
   the client owns afterwards. A horizontal spine strip sticks under the navigation and marks the stage
   in view (post.js); without JavaScript it is an ordinary row of anchors and every stage is complete.
   The judgement call and the honest "result pending approval" panel are part of the form, not optional. */
$cse   = $POST['case'];
$spine = blog_case_spine();
$cse_w = ['', 'Supporting', 'Substantial', 'Leading'];   // the weight 1–3 in the matrix, in words
?>
<nav class="blg-spine" aria-label="Case stages" data-blg-spine>
  <div class="wrap">
    <div class="bdh-scroll-x blg-spine__scroll" tabindex="0" role="group" aria-label="Case stages, scroll sideways">
      <ol class="blg-spine__l">
        <?php $cse_n = 1; foreach ($spine as $cse_k => $cse_label): ?>
          <li><a href="#cs-<?= e($cse_k) ?>" data-blg-spine-a="cs-<?= e($cse_k) ?>"><b><?= e(str_pad((string) $cse_n, 2, '0', STR_PAD_LEFT)) ?></b><?= e($cse_label) ?></a></li>
        <?php $cse_n++; endforeach; ?>
      </ol>
    </div>
  </div>
</nav>

<!-- ===== 01 · the brief ===== -->
<section class="band blg-cs blg-cs--brief" id="cs-brief" aria-labelledby="cs-brief-t">
  <div class="wrap">
    <div class="blg-cs__head">
      <p class="lbl lbl--blue"><span class="dot"></span>Stage 01 · The brief</p>
      <h2 class="h2" id="cs-brief-t"><span class="g">What they asked for,</span> and what was actually wrong.</h2>
    </div>
    <div class="blg-cs__brief">
      <div class="blg-cs__briefcol">
        <?php foreach ($cse['problem'] as $cse_i => $cse_para): ?>
          <p class="<?= $cse_i === 0 ? 'blg-lede' : 'blg-p' ?>"><?= blog_inline($cse_para) ?></p>
        <?php endforeach; ?>
      </div>
      <aside class="blg-cs__aside">
        <p class="blg-k">On the record</p>
        <dl class="blg-cs__rec">
          <div><dt>Sector</dt><dd><?= e($cse['sector']) ?></dd></div>
          <div><dt>Team</dt><dd><?= e($cse['shape']) ?></dd></div>
          <div><dt>Typical duration</dt><dd><?= e($cse['duration']) ?></dd></div>
          <div><dt>Stage</dt><dd><?= e($cse['stage']) ?></dd></div>
        </dl>
        <p class="blg-cs__note">Durations are typical ranges for work of this shape, not commitments. The client is not named and has not been asked to endorse anything on this page.</p>
      </aside>
    </div>
  </div>
</section>

<!-- ===== 02 · constraints ===== -->
<section class="band band--alt blg-cs blg-cs--con" id="cs-constraints" aria-labelledby="cs-constraints-t">
  <div class="wrap">
    <div class="blg-cs__head blg-cs__head--row">
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Stage 02 · What could not move</p>
        <h2 class="h2" id="cs-constraints-t"><span class="g">The constraints came first.</span> Everything else was designed around them.</h2>
      </div>
      <p class="lead">A constraint is not a problem to be negotiated away. Writing them down before any option is drawn is what stops a design being rejected six weeks later for a reason that was known on day one.</p>
    </div>
    <ol class="blg-con" data-rv-s data-rv-step="60">
      <?php foreach ($cse['constraints'] as $cse_i => $cse_row): ?>
        <li class="blg-con__i">
          <span class="blg-con__n" aria-hidden="true"><?= e(str_pad((string) ($cse_i + 1), 2, '0', STR_PAD_LEFT)) ?></span>
          <span class="blg-con__lock" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" focusable="false"><rect x="4.5" y="10.5" width="15" height="9.5" rx="2.5"/><path d="M8 10.5V7.8a4 4 0 0 1 8 0v2.7"/></svg>
          </span>
          <h3 class="blg-con__t"><?= e($cse_row[0]) ?></h3>
          <p class="blg-con__d"><?= blog_inline($cse_row[1]) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<!-- ===== 03 · what we did ===== -->
<section class="band blg-cs blg-cs--did" id="cs-did" aria-labelledby="cs-did-t">
  <div class="wrap">
    <div class="blg-cs__head blg-cs__head--row">
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Stage 03 · What we did</p>
        <h2 class="h2" id="cs-did-t"><span class="g">In movements,</span> in the order they happened.</h2>
      </div>
      <p class="lead">Each movement names the disciplines that carried it and the artefacts it produced. Artefacts are the things that outlast the engagement, so they are listed even when they are unglamorous.</p>
    </div>

    <ol class="blg-mov">
      <?php foreach ($cse['movements'] as $cse_m): ?>
        <li class="blg-mov__i" data-rv>
          <div class="blg-mov__rail" aria-hidden="true"><span class="blg-mov__n"><?= e($cse_m['n']) ?></span><span class="blg-mov__line"></span></div>
          <div class="blg-mov__body">
            <h3 class="blg-mov__t"><?= e($cse_m['title']) ?></h3>
            <p class="blg-mov__d"><?= blog_inline($cse_m['text']) ?></p>
            <div class="blg-mov__foot">
              <div class="blg-mov__disc">
                <p class="blg-k">Disciplines</p>
                <ul class="bdh-tags">
                  <?php foreach ($cse_m['disciplines'] as $cse_slug): if (!isset($DISCS[$cse_slug])) continue; ?>
                    <li><a class="bdh-tag bdh-tag--blue blg-mov__dl" href="<?= xe_discipline_url($DISCS[$cse_slug]) ?>"><?= e($DISCS[$cse_slug]['short']) ?></a></li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <div class="blg-mov__art">
                <p class="blg-k">Artefacts</p>
                <ul class="blg-mov__al">
                  <?php foreach ($cse_m['artifacts'] as $cse_a): ?><li><?= e($cse_a) ?></li><?php endforeach; ?>
                </ul>
              </div>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>

    <?php if (!empty($cse['call'])): ?>
      <aside class="blg-call" aria-labelledby="cs-call-t">
        <p class="blg-k">The judgement call</p>
        <h3 class="blg-call__t" id="cs-call-t"><?= e($cse['call'][0]) ?></h3>
        <p class="blg-call__d"><?= blog_inline($cse['call'][1]) ?></p>
      </aside>
    <?php endif; ?>
  </div>
</section>

<!-- ===== 04 · who did what ===== -->
<section class="band band--alt blg-cs blg-cs--mtx" id="cs-disciplines" aria-labelledby="cs-disciplines-t">
  <div class="wrap">
    <div class="blg-cs__head blg-cs__head--row">
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Stage 04 · Who did what</p>
        <h2 class="h2" id="cs-disciplines-t"><span class="g">One squad,</span> several disciplines, one account of the work.</h2>
      </div>
      <p class="lead">The weight beside each discipline is the share of the work it carried, on a three-point scale agreed at the close of the programme. It is a description of the shape of the team, not a billing record.</p>
    </div>

    <ul class="blg-mtx" data-bdh-in>
      <?php foreach ($cse['matrix'] as $cse_slug => $cse_row): if (!isset($DISCS[$cse_slug])) continue; $cse_d = $DISCS[$cse_slug]; ?>
        <li class="blg-mtx__r">
          <span class="blg-mtx__n" aria-hidden="true"><?= e($cse_d['n']) ?></span>
          <div class="blg-mtx__who">
            <h3 class="blg-mtx__t"><a class="blg-mtx__a" href="<?= xe_discipline_url($cse_d) ?>"><?= e($cse_d['name']) ?><span class="blg-mtx__i" aria-hidden="true">›</span></a></h3>
            <p class="blg-mtx__d"><?= e($cse_row[0]) ?></p>
          </div>
          <div class="blg-mtx__w">
            <p class="blg-mtx__wl"><?= e($cse_w[$cse_row[1]] ?? 'Supporting') ?></p>
            <span class="blg-mtx__bar" aria-hidden="true">
              <?php for ($cse_b = 1; $cse_b <= 3; $cse_b++): ?>
                <i class="<?= $cse_b <= $cse_row[1] ? 'is-on' : '' ?>" style="--i:<?= $cse_b ?>"></i>
              <?php endfor; ?>
            </span>
            <span class="bdh-sr"><?= e($cse_w[$cse_row[1]] ?? 'Supporting') ?> role, <?= (int) $cse_row[1] ?> of 3.</span>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

<!-- ===== 05 · what we measure ===== -->
<section class="band band--ink blg-cs blg-cs--msr" id="cs-changed" aria-labelledby="cs-changed-t">
  <div class="wrap">
    <div class="blg-cs__head blg-cs__head--row">
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Stage 05 · What we measure</p>
        <h2 class="h2" id="cs-changed-t"><span class="g">Measures with definitions,</span> agreed before the build.</h2>
      </div>
      <p class="lead">Each measure carries the definition it was agreed under and the way it is read, because a number without either can be made to say anything. Definitions were written at the start, not chosen afterwards to suit the outcome.</p>
    </div>

    <div class="bdh-scroll-x mask-x blg-msr__scroll" tabindex="0" role="group" aria-label="Measures, definitions and how each is read — scroll sideways">
      <table class="blg-msr">
        <caption class="bdh-sr">The measures this programme is judged by, their definitions, and how each one is read.</caption>
        <thead>
          <tr><th scope="col">Measure</th><th scope="col">Definition agreed</th><th scope="col">How it is read</th></tr>
        </thead>
        <tbody>
          <?php foreach ($cse['changed'] as $cse_i => $cse_row): ?>
            <tr>
              <th scope="row"><span class="blg-msr__n" aria-hidden="true"><?= e(str_pad((string) ($cse_i + 1), 2, '0', STR_PAD_LEFT)) ?></span><?= e($cse_row[0]) ?></th>
              <td><?= blog_inline($cse_row[1]) ?></td>
              <td><?= blog_inline($cse_row[2]) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <aside class="blg-result">
      <?php if (!empty($cse['result'])): ?>
        <p class="blg-k">Outcome</p>
        <p class="blg-result__d"><?= blog_inline($cse['result']) ?></p>
      <?php else: ?>
        <!-- PLACEHOLDER: no result is published until the client has approved the exact wording and the number. -->
        <p class="blg-k">Outcome</p>
        <p class="blg-result__d">No result is published here. We do not put a number on a client’s programme until they have approved the exact wording, and we do not publish one we cannot show the working for. Measures are listed above so the basis is visible either way.</p>
      <?php endif; ?>
    </aside>
  </div>
</section>

<!-- ===== 06 · what you own ===== -->
<section class="band blg-cs blg-cs--own" id="cs-owns" aria-labelledby="cs-owns-t">
  <div class="wrap">
    <div class="blg-cs__head blg-cs__head--row">
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Stage 06 · What you own afterwards</p>
        <h2 class="h2" id="cs-owns-t"><span class="g">The handover is the deliverable.</span> Everything here stays with the client.</h2>
      </div>
      <p class="lead">Source, data, definitions, the gate that blocks a bad release, and the runbook that says how to turn it off. If any of it only worked while we were in the room, it was not finished.</p>
    </div>

    <ol class="blg-own" data-rv-s data-rv-step="50">
      <?php foreach ($cse['owns'] as $cse_i => $cse_row): ?>
        <li class="blg-own__i">
          <span class="blg-own__tick" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path class="bdh-draw" pathLength="1" d="m5 12.5 4.2 4.2L19 7"/></svg>
          </span>
          <h3 class="blg-own__t"><?= e($cse_row[0]) ?></h3>
          <p class="blg-own__d"><?= blog_inline($cse_row[1]) ?></p>
          <p class="blg-own__w"><span class="blg-k">Lives in</span><?= e($cse_row[2]) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<?php if (!empty($POST['body'])): ?>
<!-- ===== appendix ===== -->
<section class="band band--alt blg-read blg-read--ap" id="cs-appendix" aria-labelledby="cs-appendix-t">
  <div class="wrap blg-read__in blg-read__in--ap">
    <aside class="blg-rail" aria-label="Post tools">
      <div class="blg-rail__stick">
        <p class="blg-k" id="cs-appendix-t">Appendix</p>
        <p class="blg-rail__d">The technical detail behind the write-up, for readers who want the mechanism rather than the summary.</p>
        <?php $blg_share_variant = 'rail'; include __DIR__ . '/share.php'; ?>
      </div>
    </aside>
    <div class="blg-body">
      <?php blog_blocks($POST['body'], ['id_prefix' => 'ap', 'start' => 0]); ?>
    </div>
  </div>
</section>
<?php endif; ?>
