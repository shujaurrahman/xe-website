<?php /* DRAFT COPY — review before launch (the crawler-control and llms.txt answers are new) */
/* FAQ (paper) — 12 · The questions scoping calls start with. Five come straight from
   $CAP['faq']; two are written for this page because they come up on every technical call:
   whether to block the AI crawlers, and whether llms.txt does anything yet.
   The left rail carries what a scoping call actually covers, taken from the Audit stage in
   section 10, so it is a second piece of content rather than a heading with white space under it.
   Accordion is the core [data-acc] widget — no JS of its own. */

/* what a scoping call covers — the four inputs the Audit stage needs, written for a buyer */
$tsv_fq_call = [
    ['The questions', 'Which prompts and queries your buyers actually use, and who answers them today.'],
    ['The evidence',  'Read access to Search Console and analytics, so the baseline is measured rather than guessed.'],
    ['The blockers',  'A sample of server logs and a staging URL, to see where a crawler stops and what that costs.'],
    ['The shape',     'What a realistic first ninety days looks like against your release process.'],
];

$tsv_fq_src = isset($CAP['faq']) ? $CAP['faq'] : [];

/* pull a data question by index, with its tag */
$tsv_fq_pick = static function ($tsv_fq_n, $tsv_fq_tag) use ($tsv_fq_src) {
    if (!isset($tsv_fq_src[$tsv_fq_n])) { return null; }
    return [$tsv_fq_src[$tsv_fq_n][0], $tsv_fq_src[$tsv_fq_n][1], $tsv_fq_tag];
};

$tsv_fq_items = array_values(array_filter([
    $tsv_fq_pick(0, 'Scope'),
    $tsv_fq_pick(3, 'Foundations'),
    [
        'Should we block the AI crawlers in robots.txt?',
        'Decide per bot, because they do different jobs. Googlebot is what puts you in Search, including AI Overviews. Google-Extended is a separate control over whether your content is used to ground and improve Gemini; it does not change how you rank in Search. GPTBot collects content for OpenAI model training, while OAI-SearchBot is the agent that fetches pages so ChatGPT search can cite them — block that one and you remove yourself from the answers you are trying to be quoted in. PerplexityBot fetches for Perplexity. We usually keep the search-facing agents allowed and take the training question on its own merits with your legal team. One caveat: robots.txt is a directive that well-behaved crawlers follow, not an access control. Anything that must stay private belongs behind authentication.',
        'Crawlers',
    ],
    [
        'Does llms.txt do anything yet?',
        'It is a community proposal, not a standard: a Markdown file that lists the pages you would like a model to read. No major search or answer engine has confirmed that it affects ranking or citation. It costs little to publish, so we will add it where the site can keep it accurate, then watch the prompt panel and report what the evidence shows rather than what the acronym promises. Nothing in the programme depends on it. The things that demonstrably move citations are crawlable pages, clear structure, correct entity data and sources that already get quoted.',
        'Emerging',
    ],
    $tsv_fq_pick(2, 'Measurement'),
    $tsv_fq_pick(1, 'Honesty'),
    $tsv_fq_pick(4, 'Timing'),
]));
$tsv_fq_count = count($tsv_fq_items);
?>
<section class="band tsv-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap tsv-faq__grid">

    <div class="tsv-faq__side">
      <div class="tsv-faq__head" data-rv>
        <p class="tsv-kick"><span class="tsv-kick__ref">12 · Questions</span><span>Asked on every call</span></p>
        <h2 class="h2" id="faq-t"><span class="g">Search and AI visibility,</span> asked directly.</h2>
        <p class="tsv-faq__l">The answers we would give in a scoping call, written the same way here. Where the honest answer is no, it says no.</p>
        <p class="tsv-faq__c"><span><?= str_pad((string) $tsv_fq_count, 2, '0', STR_PAD_LEFT) ?></span> questions</p>
        <a class="btn btn--out" href="<?= xe_url('contact.php') ?>">Ask the team directly <span class="i" aria-hidden="true">›</span></a>

        <div class="tsv-faq__call">
          <p class="tsv-faq__callk">What a scoping call covers</p>
          <ol class="tsv-faq__calll" role="list">
            <?php foreach ($tsv_fq_call as $tsv_fq_ci => $tsv_fq_c): ?>
              <li>
                <span class="tsv-faq__calln"><?= str_pad((string) ($tsv_fq_ci + 1), 2, '0', STR_PAD_LEFT) ?></span>
                <b><?= e($tsv_fq_c[0]) ?></b>
                <span class="tsv-faq__calld"><?= e($tsv_fq_c[1]) ?></span>
              </li>
            <?php endforeach; ?>
          </ol>
          <!-- PLACEHOLDER: confirm the scoping-call agenda with the delivery team before launch -->
          <p class="tsv-faq__callf">Roughly forty-five minutes. No deck, and no proposal until we have seen the data.</p>
        </div>
      </div>
    </div>

    <div class="tsv-faq__list" data-acc data-rv data-rv-d="80">
      <?php foreach ($tsv_fq_items as $tsv_fq_i => $tsv_fq_q):
          $tsv_fq_open = ($tsv_fq_i === 0); ?>
        <div class="tsv-faq__row">
          <h3 class="tsv-faq__hq">
            <button class="tsv-faq__q" type="button" data-acc-b id="faq-q<?= $tsv_fq_i ?>"
                    aria-expanded="<?= $tsv_fq_open ? 'true' : 'false' ?>" aria-controls="faq-a<?= $tsv_fq_i ?>">
              <span class="tsv-faq__n" aria-hidden="true"><?= str_pad((string) ($tsv_fq_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <span class="tsv-faq__t"><?= e($tsv_fq_q[0]) ?></span>
              <span class="tsv-faq__tag"><?= e($tsv_fq_q[2]) ?></span>
              <span class="tsv-faq__plus" aria-hidden="true"></span>
            </button>
          </h3>
          <div class="tsv-faq__p" id="faq-a<?= $tsv_fq_i ?>" role="region" aria-labelledby="faq-q<?= $tsv_fq_i ?>" data-acc-p>
            <div class="tsv-faq__pi"><p><?= e($tsv_fq_q[1]) ?></p></div>
          </div>
        </div>
      <?php endforeach; ?>

      <p class="tsv-faq__foot">
        <?= xt_icon('compass', ['size' => 18]) ?>
        <span>Answer surfaces change faster than the questions do. If an answer here stops being true, it gets rewritten — the same rule we apply to your pages.</span>
      </p>
    </div>

  </div>
</section>
