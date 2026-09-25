<?php /* DRAFT COPY — review before launch */
/* Shift — what actually changed about earning attention, in four cards. Each card is a then/now strip:
   the old single answer, dashed and spent, and the several things that now carry the same job. Every
   claim below is the position already set out in data/campaign-content.php; the capability chips point
   at the card on this page that owns it. The strip (.cch-shift__strip) is a reusable idiom. */
$shift_items = [
    [
        'k'    => 'Discovery',
        'h'    => 'People look for you in three places at once.',
        'p'    => 'Search results, feeds, and answers written by a model. The same architecture serves all three: clear entities, answer-first structure and cited sources are what ranking systems and answer engines both reward.',
        'then' => ['A page that ranks'],
        'now'  => ['Search results', 'Feeds', 'Answers that cite you'],
        'do'   => 'Rankings and AI-answer citations are tracked against one baseline, not two reports.',
        'caps' => ['content-marketing', 'public-relations'],
    ],
    [
        'k'    => 'The auction',
        'h'    => 'Platforms now optimise across creative, not audiences.',
        'p'    => 'A steady supply of genuinely different concepts, not colour variants, is what moves cost per acquisition. Creative supply became a media decision.',
        'then' => ['Audience targeting'],
        'now'  => ['Creative volume', 'Distinct concepts', 'One hypothesis per variant'],
        'do'   => 'A testing framework with a hypothesis per variant and enough versions to learn from.',
        'caps' => ['performance-marketing', 'campaign-design-systems'],
    ],
    [
        'k'    => 'Measurement',
        'h'    => 'The consented path carries what cookies used to.',
        'p'    => 'Consent mode, server-side tagging, first-party data and modelled conversions now do the work third-party cookies did. Anything that depends on cookies is temporary.',
        'then' => ['Third-party cookies'],
        'now'  => ['Consent mode', 'Server-side tagging', 'Conversion APIs', 'Offline imports'],
        'do'   => 'The consented measurement layer is built and validated before budget moves.',
        'caps' => ['performance-marketing', 'omnichannel-marketing-strategy'],
    ],
    [
        'k'    => 'Trust',
        'h'    => 'Borrowed trust has to be labelled.',
        'p'    => 'Paid partnerships, sponsored content and advertorials are bought and labelled as advertising. Earned coverage is earned. The two are kept clearly separate, in the brief and in the contract.',
        'then' => ['The brand says it'],
        'now'  => ['Journalists repeat it', 'Creators repeat it', 'Labelled when paid'],
        'do'   => 'Disclosure obligations are written into briefs and contracts, then checked at publication.',
        'caps' => ['social-influencer-activation', 'public-relations'],
    ],
];
$shift_chip = function (string $shift_slug) use ($CAPS): string {
    $shift_c = $CAPS[$shift_slug];
    return '<a class="cch-capl" href="#' . e($shift_slug) . '"><b>' . e($shift_c['n']) . '</b>' . e($shift_c['short']) . '<i aria-hidden="true">›</i></a>';
};
?>
<section class="band cch-shift" id="shift" aria-labelledby="shift-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>What changed</p>
        <h2 class="h2" id="shift-t"><span class="g">Attention did not get harder.</span> It got plural.</h2>
      </div>
      <div>
        <p class="lead">Four things moved at once, and each one replaced a single answer with several. A campaign that still assumes the old answer is not wrong so much as incomplete.</p>
      </div>
    </div>

    <ol class="cch-shift__grid" data-rv-s data-rv-step="70">
      <?php foreach ($shift_items as $shift_i => $shift_s): ?>
        <li class="cch-shift__card">
          <p class="cch-shift__k"><span><?= str_pad((string) ($shift_i + 1), 2, '0', STR_PAD_LEFT) ?></span><?= e($shift_s['k']) ?></p>
          <h3 class="cch-shift__h"><?= e($shift_s['h']) ?></h3>
          <p class="cch-shift__p"><?= e($shift_s['p']) ?></p>

          <div class="cch-shift__strip">
            <p class="cch-shift__lane">
              <span class="cch-k">Was</span>
              <?php foreach ($shift_s['then'] as $shift_t): ?><span class="cch-shift__was"><?= e($shift_t) ?></span><?php endforeach; ?>
            </p>
            <p class="cch-shift__lane is-now">
              <span class="cch-k">Now</span>
              <?php foreach ($shift_s['now'] as $shift_n): ?><span class="cch-shift__now"><?= e($shift_n) ?></span><?php endforeach; ?>
            </p>
          </div>

          <p class="cch-shift__do"><?= e($shift_s['do']) ?></p>
          <p class="cch-capls cch-shift__caps">
            <?php foreach ($shift_s['caps'] as $shift_cs) { echo $shift_chip($shift_cs); } ?>
          </p>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
