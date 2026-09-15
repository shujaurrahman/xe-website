<?php /* DRAFT COPY — review before launch */
/* §6 Narrative in three lengths — one story at 10, 50 and 250 words. The line that survives every
   length is marked. narrative.js animates the reflow; counts are computed here from the text. */
$cbf_nar_core = 'Every figure traceable, so finance teams can decide with confidence.';
$cbf_nar = [   // [words label, use, short name, paragraphs] — {core} marks the surviving line; the story is illustrative
    ['10', 'The lift · a sign-off email', 'Lift', ['{core}']],
    ['50', 'The deck · an opening slide', 'Deck', [
        'Month-end is where a finance team earns or loses the trust of the business. Most tools make the numbers faster. Few make them defensible. Your brand links every entry to its source, so any figure can be questioned and answered in a minute. {core}',
    ]],
    ['250', 'The new hire · the first-week pack', 'New hire', [
        'Every month, finance teams are asked the same question in a dozen forms: where did this number come from? When the answer takes a day, decisions wait, meetings multiply and confidence in the figures drains away, however accurate they turn out to be.',
        'Your brand was built around that question. Every entry links to the document it came from, every change carries a name and a reason, and every report can be opened down to its source in a few clicks. We do not ask customers to trust the numbers. We show them why they can.',
        'That is why we do not compete on being the fastest or the cheapest option. Speed matters, and our customers close sooner, but speed without a trail only moves the argument to the next meeting. We would rather be the tool a finance lead reaches for when the board asks a hard question.',
        'It also shapes how we work with each other. We write things down, we cite our sources, and we change our minds in the open. When a decision is close, we ask which option leaves a clearer record. In practice, a claim in a deck has a footnote, a number in a meeting has a link, and a disagreement ends with a decision that someone owns.',
        'You will hear one line more than any other in your first weeks. It is short on purpose. {core}',
    ]],
];
$cbf_nar_words = function (array $ps) use ($cbf_nar_core): int {
    return count(preg_split('/\s+/', trim(str_replace('{core}', $cbf_nar_core, implode(' ', $ps)))));
};
?>
<section class="band band--alt cbf-nar" id="narrative" aria-labelledby="narrative-t">
  <div class="wrap">
    <header class="cbf-head cbf-head--split" data-rv>
      <p class="cbf-head__sec"><b>§ 06</b>Narrative</p>
      <div class="cbf-head__body">
        <h2 class="h2" id="narrative-t"><span class="g">One story,</span> told at three lengths.</h2>
        <p class="lead"><?= e($CAP['offer'][4][1]) ?> Purpose, vision and mission live inside it, so nobody has to recite them.</p>
      </div>
    </header>

    <!-- PLACEHOLDER: illustrative narrative for a generic brand — confirm before launch -->
    <div class="cbf-nar__desk" data-cbf-nar>
      <div class="cbf-nar__ctrl">
        <p class="cbf-mono cbf-nar__cl" id="narrative-len">Length in words</p>
        <div class="cbf-nar__seg" role="tablist" aria-labelledby="narrative-len">
          <?php foreach ($cbf_nar as $cbf_i => $cbf_n): ?>
            <button type="button" role="tab" class="cbf-nar__tab" id="narrative-tab-<?= $cbf_i ?>" aria-controls="narrative-pane-<?= $cbf_i ?>" aria-selected="<?= $cbf_i === 1 ? 'true' : 'false' ?>" tabindex="<?= $cbf_i === 1 ? '0' : '-1' ?>"><b><?= e($cbf_n[0]) ?></b><span><?= e($cbf_n[2]) ?></span></button>
          <?php endforeach; ?>
          <span class="cbf-nar__thumb" aria-hidden="true"></span>
        </div>
        <span class="cbf-ill">Illustrative</span>
      </div>

      <div class="cbf-nar__page">
        <div class="cbf-nar__stage">
          <?php foreach ($cbf_nar as $cbf_i => $cbf_n):
              $cbf_w = $cbf_nar_words($cbf_n[3]); $cbf_s = max(3, (int) round($cbf_w / 238 * 60)); ?>
            <div class="cbf-nar__pane cbf-nar__pane--<?= e($cbf_n[0]) ?>" role="tabpanel" id="narrative-pane-<?= $cbf_i ?>" aria-labelledby="narrative-tab-<?= $cbf_i ?>" tabindex="0" data-words="<?= $cbf_w ?>" data-secs="<?= $cbf_s ?>" data-use="<?= e($cbf_n[1]) ?>"<?= $cbf_i === 1 ? '' : ' hidden' ?>>
              <?php foreach ($cbf_n[3] as $cbf_p): ?>
                <p><?= str_replace('{core}', '<mark class="cbf-nar__core">' . e($cbf_nar_core) . '</mark>', e($cbf_p)) ?></p>
              <?php endforeach; ?>
            </div>
          <?php endforeach; ?>
        </div>

        <dl class="cbf-nar__read" aria-live="polite">
          <div><dt>Words</dt><dd data-nar="words"><?= $cbf_nar_words($cbf_nar[1][3]) ?></dd></div>
          <div><dt>Reading time</dt><dd data-nar="secs"><?= max(3, (int) round($cbf_nar_words($cbf_nar[1][3]) / 238 * 60)) ?>s</dd></div>
          <div><dt>Where it is used</dt><dd data-nar="use"><?= e($cbf_nar[1][1]) ?></dd></div>
          <div class="cbf-nar__key"><dt><mark class="cbf-nar__core">Marked</mark></dt><dd>The line that survives every length.</dd></div>
        </dl>
      </div>
    </div>
  </div>
</section>
