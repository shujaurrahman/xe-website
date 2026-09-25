<?php /* DRAFT COPY — review before launch */
/* AI-native — the division of labour, stated plainly, and the record that proves it. Where a model
   does the work, where a person decides, the six guardrails, and an illustrative production record
   showing what is written down for every AI-assisted asset. Every line here is the position already
   set out in the AI answers in data/campaign-content.php: a person writes or rewrites the substance,
   a named editor approves every piece, disclosure follows platform and policy rules, provenance is
   recorded, and anything mistakable for a real person, place or event is labelled.
   PLACEHOLDER: the production record below is illustrative, not a real client's log. */
$ai_does = [
    ['Demand research',      'Search demand, sales objections and support tickets clustered into the questions customers actually ask.', 'search'],
    ['Drafts and variants',  'Outlines, headline and copy variants, metadata and translation first drafts, from a brief a person wrote.', 'prompt'],
    ['Adaptation at volume', 'Resizing, background extension, versioning and previsualisation inside the campaign system\'s rules.', 'layers'],
    ['Accessibility drafts', 'Alt text, subtitles, captions and audio-description drafts, for a person to correct rather than write.', 'accessibility'],
    ['Triage',               'First-pass moderation and comment classification, so the queue is sorted before anyone reads it.', 'filter'],
    ['Anomaly detection',    'Performance changes flagged the day they happen instead of at the monthly review.', 'radar'],
];
$ai_person = [
    ['The claim',            'What the business is willing to say, and whether the evidence behind it holds.'],
    ['The idea and the cast','The campaign idea, the art direction and who appears in the work.'],
    ['The reply',            'Any answer to a complaint, a safety issue or anything legal or medical.'],
    ['What ships',           'A named editor approves every piece before it publishes. Nothing goes out unreviewed.'],
];
$ai_rules = [
    ['A named approver',        'Every asset has one person who signed it off, recorded against the asset rather than remembered.'],
    ['Claims checked',          'Copy is checked against the message house, and nothing runs that your legal team has not passed.'],
    ['Disclosure by default',   'AI assistance is disclosed where a platform, a market code or your own policy requires it.'],
    ['Provenance recorded',     'Model, prompt version, approver and date are kept beside the asset for its whole life.'],
    ['Synthetic content labelled', 'Anything that could be mistaken for a real person, place or event is labelled and logged.'],
    ['Rights still apply',      'Training data, stock licences and model terms are checked before a tool enters the pipeline.'],
];
$ai_log = [
    ['Cluster 02 article',        'Outline and metadata drafted',            'Named editor, before publish',   'Noted in the editorial standard', 'Prompt version recorded'],
    ['Reel 07, six sizes',        'Resize and background extension',         'Art director, per size',         'Not required · no likeness',      'Model and prompt recorded'],
    ['Regional subtitle file',    'First-draft translation',                 'In-market reviewer',             'Machine-assisted noted in file',  'Source and model recorded'],
    ['Product hero, 3D',          'Scene generated, not photographed',       'Producer and your sign-off',     'Labelled computer-generated',     'Model, seed and prompt recorded'],
    ['Twenty-four ad variants',   'Copy variants from a winning pattern',    'Performance lead, before spend', 'Platform policy check',           'Test log linked to each variant'],
    ['Comment triage, one week',  'Sentiment and intent classified',         'Community manager answers',      'Internal only · no output',       'Classifier version recorded'],
];
$ai_cols = ['Asset', 'What the model did', 'Who approved it', 'Disclosure', 'Provenance'];
$ai_std  = ['eu-ai-act', 'nist-ai-rmf', 'wcag22', 'dpdp', 'gdpr'];
?>
<section class="band band--ink cch-ai" id="ai-native" aria-labelledby="ai-native-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>AI-native, stated plainly</p>
        <h2 class="h2" id="ai-native-t"><span class="g">AI makes more work possible.</span> It does not decide what to say.</h2>
      </div>
      <div>
        <p class="lead">The useful question is not whether we use AI. It is which steps it does, who signs off, and what is written down afterwards. All three are answered here, and the same answer is in every contract.</p>
      </div>
    </div>

    <div class="cch-ai__split" data-rv data-rv-d="60">
      <div class="cch-ai__col">
        <p class="cch-ai__ck"><span class="cch-k">Where a model does the work</span><span class="cch-ai__cn"><?= count($ai_does) ?></span></p>
        <ul class="cch-tiles cch-ai__tiles" role="list">
          <?php foreach ($ai_does as $ai_d): ?>
            <li class="cch-tile">
              <span class="cch-tile__top">
                <span class="cch-tile__ico" aria-hidden="true"><?= xt_icon($ai_d[2], ['size' => 18]) ?></span>
                <span class="cch-tile__t"><?= e($ai_d[0]) ?></span>
              </span>
              <span class="cch-tile__d"><?= e($ai_d[1]) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="cch-ai__col cch-ai__col--person">
        <p class="cch-ai__ck"><span class="cch-k">Where a person decides</span><span class="cch-ai__cn"><?= count($ai_person) ?></span></p>
        <ul class="cch-ai__plist" role="list">
          <?php foreach ($ai_person as $ai_p): ?>
            <li><b><?= e($ai_p[0]) ?></b><span><?= e($ai_p[1]) ?></span></li>
          <?php endforeach; ?>
        </ul>
        <p class="cch-note cch-ai__pn">A model can produce a hundred versions of a sentence. It cannot tell you which one your company is prepared to defend.</p>
      </div>
    </div>

    <div class="cch-ai__rules" data-rv data-rv-d="90">
      <h3 class="cch-ai__h3">Six rules that hold whatever the tool is</h3>
      <ol class="cch-ai__rlist">
        <?php foreach ($ai_rules as $ai_ri => $ai_r): ?>
          <li><span class="cch-ai__rn"><?= str_pad((string) ($ai_ri + 1), 2, '0', STR_PAD_LEFT) ?></span><b><?= e($ai_r[0]) ?></b><span><?= e($ai_r[1]) ?></span></li>
        <?php endforeach; ?>
      </ol>
    </div>

    <div class="cch-ai__record" data-rv data-rv-d="60">
      <p class="cch-ai__rh">
        <span class="cch-k">The production record · one week, illustrative</span>
        <span class="cch-ill">Illustrative</span>
      </p>
      <div class="bdh-scroll-x cch-ai__scroll" tabindex="0" role="group" aria-label="An illustrative production record of AI-assisted assets. Scroll sideways for the remaining columns.">
        <table class="cch-tbl cch-ai__tbl">
          <caption>What is written down for every AI-assisted asset</caption>
          <thead>
            <tr><?php foreach ($ai_cols as $ai_c): ?><th scope="col"><?= e($ai_c) ?></th><?php endforeach; ?></tr>
          </thead>
          <tbody>
            <?php foreach ($ai_log as $ai_row): ?>
              <tr>
                <th scope="row"><?= e($ai_row[0]) ?></th>
                <?php for ($ai_i = 1; $ai_i < 5; $ai_i++): ?>
                  <td data-h="<?= e($ai_cols[$ai_i]) ?>"><?= e($ai_row[$ai_i]) ?></td>
                <?php endfor; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="cch-ai__ft">
        <div>
          <p class="cch-k">Frameworks this is built to</p>
          <ul class="cch-ai__std" role="list"><?php foreach ($ai_std as $ai_s) { echo xt_badge($ai_s, ['variant' => 'chip', 'tag' => 'li']); } ?></ul>
        </div>
        <p class="cch-note">Advertising disclosure follows the code of the market the work runs in: the ASCI guidelines for influencer advertising in India, the FTC endorsement guides in the United States, and the platform's own paid-partnership label. Other markets are checked before launch. None of this is a certification we hold.</p>
      </div>
    </div>
  </div>
</section>
