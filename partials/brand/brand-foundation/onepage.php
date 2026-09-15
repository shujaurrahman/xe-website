<?php /* DRAFT COPY — review before launch */
/* §8 Foundation on a page — the one-page artefact as a printable sheet. Each block is a button:
   hover/focus/select zooms the sheet towards it and the margin explains it. Content is illustrative. */
$cbf_one = [   // id => [label, sheet content HTML-safe text, why it is on the page, used when, owner, grid area]
    'purpose'  => ['Purpose',  'So that decisions about money are made on figures people can trust.', 'The reason the brand exists, in one sentence anyone can repeat.', 'Choosing between two good ideas.', 'Chief executive', 'pu'],
    'vision'   => ['Vision',   'A finance function where every number can explain itself.', 'Where the brand is heading, so today’s choices point the same way.', 'Setting the three-year plan.', 'Executive team', 'vi'],
    'mission'  => ['Mission',  'Link every entry to its source, and make that link easy to follow.', 'What the brand does about its purpose, stated as work rather than aspiration.', 'Prioritising the roadmap.', 'Product lead', 'mi'],
    'position' => ['Positioning', 'For finance leads closing the month under pressure who need numbers they can defend, Your brand is the finance record that makes every figure traceable, because every entry links to its source document.', 'For whom, against what and why you: the statement the leadership team signed.', 'Briefing identity, campaigns and sales.', 'Brand lead', 'po'],
    'audience' => ['Audience & insight', 'Finance leads at mid-sized firms. The question they face is rarely “is it right?” but “where did it come from?”', 'The people the brand is for and the insight that makes the positioning true.', 'Deciding who a new feature or message is for.', 'Insight lead', 'au'],
    'values'   => ['Values', 'Traceable before persuasive · Earned, not discounted · Useful in a minute · Standards over silos', 'The four rules that settle close calls, each tested against a real decision.', 'Any decision that is close.', 'Everyone', 'va'],
    'story'    => ['Narrative', 'Every figure traceable, so finance teams can decide with confidence.', 'The line that survives every length of the story.', 'Opening a deck, an email or an induction.', 'Communications lead', 'na'],
    'test'     => ['Foundation test', 'Re-run against three past decisions. All three settled.', 'The evidence that the page works, so it is trusted rather than filed.', 'Reviewing the foundation each year.', 'Executive team', 'te'],
];
$cbf_one_first = array_key_first($cbf_one);
?>
<section class="band band--alt cbf-one" id="on-a-page" aria-labelledby="onepage-t">
  <div class="wrap">
    <header class="cbf-head cbf-head--split" data-rv>
      <p class="cbf-head__sec"><b>§ 08</b>On a page</p>
      <div class="cbf-head__body">
        <h2 class="h2" id="onepage-t"><span class="g">The whole foundation,</span> on one sheet anyone can carry.</h2>
        <p class="lead">The long document holds the evidence. This page holds the decisions. Select a block to see why it is there and when it gets used.</p>
      </div>
    </header>

    <!-- PLACEHOLDER: illustrative one-page foundation for a generic brand — confirm before launch -->
    <div class="cbf-one__grid" data-cbf-one>
      <div class="cbf-one__desk">
        <div class="cbf-one__sheet" data-one-sheet>
          <header class="cbf-one__top">
            <span>Your brand</span><span>Foundation on a page</span><span>v1.0 · Ratified</span>
          </header>
          <div class="cbf-one__blocks">
            <?php foreach ($cbf_one as $cbf_k => $cbf_b): ?>
              <button type="button" class="cbf-one__b cbf-one__b--<?= $cbf_b[5] ?>" data-one="<?= $cbf_k ?>" aria-pressed="<?= $cbf_k === $cbf_one_first ? 'true' : 'false' ?>" aria-controls="onepage-note">
                <span class="cbf-one__bl"><?= e($cbf_b[0]) ?></span>
                <span class="cbf-one__bt"><?= e($cbf_b[1]) ?></span>
              </button>
            <?php endforeach; ?>
          </div>
          <footer class="cbf-one__foot"><span>Owner · Executive team</span><span>Review · annually</span><span>Page 1 / 1</span></footer>
        </div>
        <p class="cbf-one__fmt"><span class="cbf-mono">Formats</span> <?= e($CAP['deliver'][5][1]) ?> <span class="cbf-ill">Illustrative content</span></p>
      </div>

      <aside class="cbf-one__note" id="onepage-note" aria-live="polite">
        <?php foreach ($cbf_one as $cbf_k => $cbf_b): ?>
          <div class="cbf-one__card" data-one-card="<?= $cbf_k ?>"<?= $cbf_k === $cbf_one_first ? '' : ' hidden' ?>>
            <p class="cbf-mono cbf-one__n">Block <?= str_pad((string) (array_search($cbf_k, array_keys($cbf_one)) + 1), 2, '0', STR_PAD_LEFT) ?> of <?= count($cbf_one) ?></p>
            <h3 class="cbf-one__h"><?= e($cbf_b[0]) ?></h3>
            <p class="cbf-one__why"><?= e($cbf_b[2]) ?></p>
            <dl class="cbf-one__dl">
              <div><dt>Used when</dt><dd><?= e($cbf_b[3]) ?></dd></div>
              <div><dt>Owned by</dt><dd><?= e($cbf_b[4]) ?></dd></div>
            </dl>
          </div>
        <?php endforeach; ?>
        <p class="cbf-one__hint">Every block links back to its clause in the full document, so the page never drifts from the evidence behind it.</p>
      </aside>
    </div>
  </div>
</section>
