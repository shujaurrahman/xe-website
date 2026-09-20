<?php /* DRAFT COPY — review before launch */
/* The shift — a scroll-lit statement, one wide photograph with a telemetry overlay, and four shifts. Each
   shift carries one mono figure that describes the market, never a claim about Xterra Edze, with its source.
   Words are split into spans so shift.js can light them; the markup reads in full without it. */
$shift_grey = 'Technology is no longer a website and a server.';
$shift_ink  = 'It is software, data and AI that must stay fast, secure and affordable every day.';
$shift_words = function (string $text): string {
    return implode(' ', array_map(fn ($shift_w) => '<span class="tih-shift__w">' . e($shift_w) . '</span>', preg_split('/\s+/', trim($text))));
};
$shift_cards = [
    // [then, now, figure, figure caption, count?, title, text, source, what we do about it, capability slug]
    ['A pilot', 'In the product', 'LLM01', 'Prompt injection, first on the list', false,
     'AI moved into the product',
     'Features, agents and copilots now sit in customer journeys, so they bring a new class of bug that ordinary testing does not catch.',
     'OWASP Top 10 for LLM Applications, 2025',
     'We ship AI features behind evals and guardrails, with a named person approving anything that reaches a customer.',
     'ai-product-automation'],
    ['~4k tokens', '1M+ tokens', '1M+', 'Tokens of context, up from about 4k', false,
     'Models change every month',
     'Context windows, prices and rankings move faster than release plans. Evals that run on every change replace one-off testing.',
     'Provider model documentation, 2023–2025',
     'One gateway, one golden set. Changing model is a configuration change we can demonstrate, not a rebuild.',
     'ai-strategy-agents'],
    ['10 blue links', '1 cited answer', '10 → 1', 'Ten blue links became one answer, citing a few sources', false,
     'Answers replaced links',
     'AI Overviews, ChatGPT search and Perplexity answer first and cite a few sources. Being one of them is now a technical job.',
     'Google, OpenAI and Perplexity product pages',
     'We measure citations in answer engines beside rankings and revenue, in one monthly report.',
     'search-ai-visibility'],
    ['Annual audit', 'Hours to report', '6 h', 'To report a cyber incident in India', true,
     'Scrutiny rose',
     'The DPDP Act 2023, the EU AI Act and CERT-In six-hour incident reporting make security, privacy and AI governance delivery work.',
     'CERT-In Directions, 28 April 2022',
     'Security, privacy and AI governance run inside delivery, so the evidence exists as the work ships.',
     'cybersecurity-ai-trust'],
];
?>
<section class="band band--alt tih-shift" id="shift" aria-labelledby="shift-t">
  <div class="wrap">
    <div class="tih-shift__top">
      <p class="lbl lbl--blue tih-shift__lbl" data-rv><span class="dot"></span>Why now</p>
      <h2 class="tih-shift__h" id="shift-t"><span class="g"><?= $shift_words($shift_grey) ?></span> <?= $shift_words($shift_ink) ?></h2>
      <div class="tih-shift__stand" data-rv data-rv-d="120">
        <p class="lead">Four things changed at once, and they changed what a technology partner has to be able to do. None of them is a trend: each is a standard, a price list or a law you can look up.</p>
        <p class="tih-shift__note">Every figure below describes the market, with its source named. None of them is a claim about our own results.</p>
      </div>
    </div>

    <!-- PLACEHOLDER: reference photograph (Unsplash) — replace with commissioned/own imagery before launch -->
    <figure class="bdh-img bdh-img--r219 bdh-img--xl tih-shift__img" data-bdh-parallax="0.05" data-rv>
      <img src="<?= xe_url('assets/imgs/tech/hub/shift-servers.jpg') ?>" alt="A data-centre aisle lined with rack servers" width="2000" height="1325" loading="lazy" decoding="async">
      <span class="tih-shift__frame" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
      <span class="tih-shift__read" aria-hidden="true" data-bdh-live>
        <span><i class="bdh-pulse"></i>rack-14 · in-region</span>
        <span>gpu util <b>64%</b></span>
        <span>p95 <b>212 ms</b></span>
      </span>
      <span class="bdh-cap-chip tih-shift__chip"><b>Where the stack runs now</b>Your cloud account, your region, observable end to end</span>
    </figure>

    <ol class="tih-shift__cards" data-rv-s data-rv-step="90">
      <?php foreach ($shift_cards as $shift_i => $shift_c): ?>
        <li class="tih-shift__card">
          <p class="tih-shift__diff" aria-label="Then: <?= e($shift_c[0]) ?>. Now: <?= e($shift_c[1]) ?>.">
            <span class="bdh-idx" aria-hidden="true"><?= str_pad((string) ($shift_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <del aria-hidden="true"><?= e($shift_c[0]) ?></del><i aria-hidden="true">→</i><ins aria-hidden="true"><?= e($shift_c[1]) ?></ins>
          </p>
          <p class="tih-shift__fig"><span<?= $shift_c[4] ? ' data-bdh-count' : '' ?>><?= e($shift_c[2]) ?></span></p>
          <p class="tih-shift__cap"><?= e($shift_c[3]) ?></p>
          <h3 class="bdh-t tih-shift__t"><?= e($shift_c[5]) ?></h3>
          <p class="bdh-d tih-shift__d"><?= e($shift_c[6]) ?></p>
          <?php $shift_cap = $TI[$shift_c[9]]; ?>
          <div class="tih-shift__do">
            <p class="tih-k">What we do about it</p>
            <p class="tih-shift__dd"><?= e($shift_c[8]) ?></p>
            <a class="tih-capl" href="<?= xe_url('services/technology-intelligence/' . $shift_c[9] . '.php') ?>"><b><?= e($shift_cap['n']) ?></b><?= e($shift_cap['short']) ?><i aria-hidden="true">›</i></a>
          </div>
          <p class="tih-shift__src">Source · <?= e($shift_c[7]) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
