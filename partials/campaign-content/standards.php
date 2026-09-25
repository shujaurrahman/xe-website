<?php /* DRAFT COPY — review before launch */
/* Standards — the frameworks and codes this work is actually held to, as a table rather than a wall,
   because the useful information is what each one changes about the work. The badges are code-built
   by xt_badge (partials/tech/kit.php); none is an official seal, and nothing here says Xterra Edze
   holds a certification. Security certifications are deliberately absent: campaign and content work
   handles audience, creator and customer data, so privacy, accessibility, performance and AI
   transparency apply — an information-security certificate would not be ours to claim and would not
   describe this work. Advertising and disclosure codes are listed separately, as obligations the
   work is built to meet market by market. "Where it applies" comes from each capability's own
   'standards' list in data/campaign-content.php. */
$st_rows = [
    ['wcag22',      'Captions and subtitles on every video, alt text written per asset rather than generated and forgotten, and contrast and minimum type size checked before an asset reaches media.'],
    ['cwv',         'Content hubs and landing pages are measured in the field, not the lab: LCP at or under 2.5 s, INP at or under 200 ms, CLS at or under 0.1. A slow page wastes the media that brought someone to it.'],
    ['gdpr',        'A lawful basis recorded per audience, consent passed to every tag that fires, and creator, talent and prospect data held only as long as the contract needs it.'],
    ['dpdp',        'Notice and consent handled for Indian audiences, and breach intimation timelines written into the crisis playbook rather than discovered during a crisis.'],
    ['eu-ai-act',   'Synthetic content that could be mistaken for a real person, place or event is labelled, and a provenance record is kept for every AI-assisted asset.'],
    ['nist-ai-rmf', 'Every AI step in the campaign pipeline is inventoried and risk-assessed, and each one has a named owner and a human approval point before anything publishes.'],
];
/* which capability cards apply each framework */
$st_where = [];
foreach ($CAPS as $st_slug => $st_c) { foreach ($st_c['standards'] as $st_k) { $st_where[$st_k][] = $st_slug; } }
$st_codes = [
    ['ASCI influencer guidelines',      'India',           'Paid partnerships carry a clear, prominent disclosure label. The obligation sits in the creator brief and the contract, not in a reminder.'],
    ['FTC endorsement guides',          'United States',   'Material connections disclosed clearly and conspicuously, in the post itself rather than in a profile bio.'],
    ['Platform paid-partnership tools', 'Every platform',  'The platform label is used as well as the written disclosure, and both are checked at publication rather than assumed.'],
    ['Other markets',                   'Checked per launch', 'Advertising codes are confirmed with your legal team market by market before an activation goes live.'],
];
?>
<section class="band band--alt cch-std" id="standards" aria-labelledby="standards-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Standards and codes</p>
        <h2 class="h2" id="standards-t"><span class="g">Six frameworks</span> and four advertising codes.</h2>
      </div>
      <div>
        <p class="lead">These are the ones this work genuinely touches: accessibility, page performance, privacy in two jurisdictions, and AI transparency. What matters is not the badge but what each one changes about how the work is made.</p>
      </div>
    </div>

    <div class="cch-std__wrap" data-rv data-rv-d="60">
      <table class="cch-tbl cch-std__tbl">
        <caption>Frameworks this discipline builds to, what each one governs, and where it applies</caption>
        <thead>
          <tr>
            <th scope="col">Framework</th>
            <th scope="col">What it governs</th>
            <th scope="col">What it changes here</th>
            <th scope="col">Where it applies</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($st_rows as $st_r): $st_s = xt_standard($st_r[0]); if (!$st_s) continue; ?>
            <tr>
              <th scope="row">
                <span class="cch-std__badge"><?= xt_badge($st_r[0], ['variant' => 'chip']) ?></span>
                <span class="cch-std__name"><?= e($st_s['name']) ?></span>
                <span class="cch-std__body"><?= e($st_s['body']) ?> · <?= e($st_s['kind']) ?></span>
              </th>
              <td data-h="What it governs"><?= e($st_s['covers']) ?></td>
              <td data-h="What it changes here"><?= e($st_r[1]) ?></td>
              <td data-h="Where it applies">
                <span class="cch-capls cch-std__caps">
                  <?php foreach ($st_where[$st_r[0]] ?? [] as $st_cs): $st_cc = $CAPS[$st_cs]; ?>
                    <a class="cch-capl" href="#<?= e($st_cs) ?>"><b><?= e($st_cc['n']) ?></b><?= e($st_cc['short']) ?><i aria-hidden="true">›</i></a>
                  <?php endforeach; ?>
                </span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="cch-std__codes" data-rv data-rv-d="90">
      <div class="cch-std__ch">
        <h3 class="cch-std__h3">Advertising and disclosure codes</h3>
        <p class="cch-std__cd">Earned coverage is earned. Paid partnerships, sponsored content and advertorials are bought and labelled as advertising, and the two are kept clearly separate. These are obligations the work is built to meet, described here rather than claimed as accreditations.</p>
      </div>
      <ol class="cch-std__clist">
        <?php foreach ($st_codes as $st_ci => $st_c): ?>
          <li>
            <p class="cch-std__cn"><span><?= str_pad((string) ($st_ci + 1), 2, '0', STR_PAD_LEFT) ?></span><?= e($st_c[0]) ?><em><?= e($st_c[1]) ?></em></p>
            <p class="cch-std__ct"><?= e($st_c[2]) ?></p>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <!-- PLACEHOLDER: confirm any certification Xterra Edze itself holds before launch -->
    <p class="cch-note cch-std__note"><b>Alignment describes how we work.</b> Every badge above is drawn in code by us, never reproduced from an official seal, and none of it says Xterra Edze holds a certification. Information-security certifications are not listed because this discipline's work does not involve the systems they cover; where a campaign touches your platforms, the Technology &amp; Intelligence team brings the frameworks that do apply. Certifications held by Xterra Edze itself: to be confirmed before launch.</p>
  </div>
</section>
