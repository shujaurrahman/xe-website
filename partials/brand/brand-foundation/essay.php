<?php /* DRAFT COPY — review before launch */
/* §1 Why a foundation — a short long-read. Superscript note calls open their sidenote in the
   gutter (desktop) or as an inline note under the paragraph (phones). */
$cbf_essay_p = [   // paragraphs; {n} marks a note call
    'Ask five leaders what the company is and you will usually hear five good answers. None of them is wrong. The trouble starts downstream: the identity team designs for one answer, product builds for another and a campaign briefs a third.{1} Each call is defended on its own terms, and the brand drifts one reasonable decision at a time.',
    'A foundation is the short document that ends the drift. It records what the brand believes, whom it serves, what it will not do and the reasons behind each. It is written to be used in the room where a close call is made, not framed in reception.{2}',
    'That changes how it is written. Plain words, because it will be repeated by people who were never in the workshop. Values phrased as rules, because a value that cannot settle a disagreement is decoration.{3} And a test: we run the draft against decisions the business has already faced. If it would not have made them easier, it is not finished.{4}',
    'Agents do much of the reading. They synthesise interview transcripts, scan the language of the category and pressure-test each draft for claims a competitor could make just as easily. People do the deciding: which tension matters, which option the leadership team will stand behind, and when the document is ratified.',
];
$cbf_essay_notes = [   // n => [title, text]
    1 => ['Drift', 'The usual symptom is three decks with three descriptions of the same company, each signed off by a different owner.'],
    2 => ['Used, not displayed', 'We judge a foundation by the decisions it settles in its first quarter, not by how well it reads out of context.'],
    3 => ['Rules, not adjectives', '“We are bold” settles nothing. “We launch when it is useful, not when it is finished” settles a roadmap meeting.'],
    4 => ['The foundation test', 'Three to five past decisions, chosen with the leadership team before drafting starts, so the test cannot be tuned to the answer.'],
];
?>
<section class="band cbf-essay" id="why" aria-labelledby="why-t">
  <div class="wrap">
    <header class="cbf-head" data-rv>
      <p class="cbf-head__sec"><b>§ 01</b>Premise</p>
      <div class="cbf-head__body">
        <h2 class="h2" id="why-t"><span class="g">Why a foundation.</span> Most brand arguments are foundation arguments in disguise.</h2>
        <p class="cbf-mono cbf-essay__read">Reading time 2 min <span aria-hidden="true">·</span> <?= count($cbf_essay_notes) ?> notes <span aria-hidden="true">·</span> select a number to open its note</p>
      </div>
    </header>

    <div class="cbf-essay__body">
      <?php foreach ($cbf_essay_p as $cbf_i => $cbf_txt):
          preg_match_all('/\{(\d)\}/', $cbf_txt, $cbf_m);
          $cbf_html = preg_replace_callback('/\{(\d)\}/', fn ($cbf_x) =>
              '<sup class="cbf-essay__call"><button type="button" class="cbf-essay__ref" aria-expanded="false" aria-controls="why-note-' . $cbf_x[1] . '"><span class="bdh-sr">Note </span>' . $cbf_x[1] . '</button></sup>', e($cbf_txt)); ?>
        <div class="cbf-essay__row" data-rv>
          <p class="cbf-essay__p<?= $cbf_i === 0 ? ' cbf-essay__p--first' : '' ?>"><?= $cbf_html ?></p>
          <?php if ($cbf_m[1]): ?>
          <div class="cbf-essay__notes">
            <?php foreach ($cbf_m[1] as $cbf_num): $cbf_note = $cbf_essay_notes[(int) $cbf_num]; ?>
              <aside class="cbf-essay__note" id="why-note-<?= e($cbf_num) ?>" aria-label="Note <?= e($cbf_num) ?>">
                <p class="cbf-essay__nh"><span class="cbf-essay__nn"><?= e($cbf_num) ?></span><?= e($cbf_note[0]) ?></p>
                <p class="cbf-essay__nt"><?= e($cbf_note[1]) ?></p>
              </aside>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>

      <!-- PLACEHOLDER: reference photo (Unsplash) — replace with own documentary photography before launch -->
      <figure class="cbf-plate cbf-essay__plate" data-rv>
        <div class="cbf-plate__img"><img src="<?= xe_url('assets/imgs/brand/brand-foundation/essay-notebook.jpg') ?>" alt="A hand writing notes in an open notebook" width="1400" height="933" loading="lazy" decoding="async"></div>
        <figcaption><b>Plate 1</b><span>Listening comes before drafting: interviews and the documents already in circulation, read before a word of the foundation is written.</span></figcaption>
      </figure>
    </div>
  </div>
</section>
