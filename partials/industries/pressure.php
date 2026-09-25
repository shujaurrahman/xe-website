<?php /* DRAFT COPY — review before launch */
/* Pressure — five things changed at once, and each one lands differently in each sector. Every figure
   describes the market and names its source; none is a claim about Xterra Edze or a client result.
   The landing grid is a real table (th scope), so the comparison is readable by a screen reader and
   without CSS. pressure.js only staggers the meters in; the HTML already shows them filled. */
$prs_forces = [
    [
        'n' => '01', 'icon' => 'search',
        'then' => 'Ten blue links', 'now' => 'One cited answer',
        'fig' => '10 → 1', 'cap' => 'Ten ranked links became one answer that cites a few sources.',
        'src' => 'Google AI Overviews, ChatGPT search and Perplexity product documentation',
        't' => 'Discovery became an answer',
        'd' => 'People ask a question and read a reply. Whether your product is one of the sources it quotes is now a technical question about structured data, facts and page speed — not a media-buying one.',
        'do' => 'We measure citations in answer engines beside rankings, and structure product and claim data so an assistant can read it correctly.',
        'hard' => 'retail-commerce',
    ],
    [
        'n' => '02', 'icon' => 'lock',
        'then' => 'A privacy policy', 'now' => 'A consent record',
        'fig' => 'DPDP', 'cap' => 'India’s first horizontal data-protection law, with the DPDP Rules behind it.',
        'src' => 'Digital Personal Data Protection Act, 2023',
        't' => 'Consent became law, not policy',
        'd' => 'Notice, purpose limitation and a withdrawal route as easy as the consent are now duties with a regulator behind them. A policy page no longer covers what a form collects.',
        'do' => 'Consent is designed into the form, recorded against the purpose, and honoured by the tags, the CRM and the warehouse — not only by the banner.',
        'hard' => 'telecom-media',
    ],
    [
        'n' => '03', 'icon' => 'shield',
        'then' => 'Best practice', 'now' => 'Mandatory',
        'fig' => '6.4.3', 'cap' => 'The PCI DSS v4 requirement covering every script that runs on a payment page.',
        'src' => 'PCI DSS v4.0.1, mandatory since 31 March 2025',
        't' => 'The payment page came into scope',
        'd' => 'A hosted checkout no longer takes you out of scope on its own. Requirement 6.4.3 covers the scripts on the page, which in most companies means the tag manager, not the checkout code.',
        'do' => 'We inventory every script on the payment path, authorise them explicitly, and put change detection in front of the tag manager.',
        'hard' => 'retail-commerce',
    ],
    [
        'n' => '04', 'icon' => 'accessibility',
        'then' => 'A good intention', 'now' => 'A date',
        'fig' => '28 Jun 2025', 'cap' => 'The date the European Accessibility Act began to apply to consumer services.',
        'src' => 'Directive (EU) 2019/882, as transposed by each member state',
        't' => 'Accessibility acquired a deadline',
        'd' => 'E-commerce, consumer banking, transport and e-books sold into the EU are covered. WCAG 2.2 AA is the working floor everywhere else, and 2.2 added criteria that catch real products: focus that is never obscured, 24 × 24 CSS px targets, no drag-only controls.',
        'do' => 'Automated checks run in the pipeline, and a keyboard and screen-reader pass runs on every key journey before it ships.',
        'hard' => 'hospitality',
    ],
    [
        'n' => '05', 'icon' => 'agent',
        'then' => 'A pilot', 'now' => 'In the journey',
        'fig' => 'LLM01', 'cap' => 'Prompt injection, first on the OWASP list of risks specific to LLM applications.',
        'src' => 'OWASP Top 10 for LLM Applications',
        't' => 'AI moved into the product',
        'd' => 'Assistants and agents now sit inside customer journeys, which brings a class of failure ordinary testing does not catch and a class of obligation ordinary sign-off does not cover.',
        'do' => 'Every AI feature ships with an eval set, guardrails, a named human approver where it matters, and an audit log of what it produced.',
        'hard' => 'b2b-technology',
    ],
];
/* how hard each force lands, per sector: 3 shapes most of the work · 2 often shapes it · 1 sometimes */
$prs_land = [
    '01' => ['consumer-health' => 3, 'financial-services' => 2, 'retail-commerce' => 3, 'b2b-technology' => 3, 'hospitality' => 3, 'telecom-media' => 2],
    '02' => ['consumer-health' => 2, 'financial-services' => 3, 'retail-commerce' => 3, 'b2b-technology' => 2, 'hospitality' => 3, 'telecom-media' => 3],
    '03' => ['consumer-health' => 1, 'financial-services' => 3, 'retail-commerce' => 3, 'b2b-technology' => 1, 'hospitality' => 3, 'telecom-media' => 2],
    '04' => ['consumer-health' => 2, 'financial-services' => 3, 'retail-commerce' => 3, 'b2b-technology' => 2, 'hospitality' => 3, 'telecom-media' => 2],
    '05' => ['consumer-health' => 2, 'financial-services' => 2, 'retail-commerce' => 2, 'b2b-technology' => 3, 'hospitality' => 2, 'telecom-media' => 3],
];
$prs_lv   = [1 => 'Sometimes shapes the work', 2 => 'Often shapes the work', 3 => 'Shapes most of the work'];
$prs_name = [];
foreach ($IND as $prs_s) { $prs_name[$prs_s['id']] = $prs_s; }
?>
<section class="band ind-prs" id="pressure" aria-labelledby="pressure-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Why now</p>
        <h2 class="h2" id="pressure-t"><span class="g">Five things changed at once.</span> None of them landed evenly.</h2>
      </div>
      <div>
        <p class="lead">These are not trends. Each one is a standard, a statute or a dated obligation you can look up — and each one costs a different sector a different amount.</p>
        <p class="ind-note">Every figure below describes the market and names its source. None of them is a claim about our own results.</p>
      </div>
    </div>

    <ol class="ind-prs__list" data-rv-s data-rv-step="80">
      <?php foreach ($prs_forces as $prs_f): $prs_h = $prs_name[$prs_f['hard']]; ?>
        <li class="ind-prs__card">
          <p class="ind-prs__top">
            <span class="bdh-idx"><?= e($prs_f['n']) ?></span>
            <span class="ind-prs__ico" aria-hidden="true"><?= xt_icon($prs_f['icon'], ['size' => 20]) ?></span>
          </p>
          <p class="ind-prs__diff" aria-label="Then: <?= e($prs_f['then']) ?>. Now: <?= e($prs_f['now']) ?>.">
            <del aria-hidden="true"><?= e($prs_f['then']) ?></del><i aria-hidden="true">→</i><ins aria-hidden="true"><?= e($prs_f['now']) ?></ins>
          </p>
          <p class="ind-prs__fig"><?= e($prs_f['fig']) ?></p>
          <p class="ind-prs__figc"><?= e($prs_f['cap']) ?></p>
          <h3 class="bdh-t ind-prs__t"><?= e($prs_f['t']) ?></h3>
          <p class="bdh-d ind-prs__d"><?= e($prs_f['d']) ?></p>
          <div class="ind-prs__foot">
            <div class="ind-prs__do">
              <span class="ind-k">What we do about it</span>
              <p><?= e($prs_f['do']) ?></p>
            </div>
            <p class="ind-prs__hard">
              <span class="ind-k">Lands hardest</span>
              <a href="#<?= e($prs_h['id']) ?>"><b><?= e($prs_h['n']) ?></b><?= e($prs_h['name']) ?><i aria-hidden="true">›</i></a>
            </p>
            <p class="ind-prs__src">Source · <?= e($prs_f['src']) ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>

    <figure class="ind-prs__grid" data-rv data-rv-d="60">
      <figcaption class="ind-prs__gcap">
        <span class="ind-k">Where each force lands</span>
        <span class="ind-prs__key" aria-hidden="true">
          <span><span class="ind-meter ind-meter--sm" data-v="1"><i></i><i></i><i></i></span>Sometimes</span>
          <span><span class="ind-meter ind-meter--sm" data-v="2"><i></i><i></i><i></i></span>Often</span>
          <span><span class="ind-meter ind-meter--sm" data-v="3"><i></i><i></i><i></i></span>Most of the work</span>
        </span>
      </figcaption>
      <div class="bdh-scroll-x mask-x ind-prs__scroll" tabindex="0" role="region" aria-label="How hard each of the five forces lands in each sector">
        <table class="ind-ledger ind-prs__tbl">
          <caption class="sr">How much each of the five forces typically shapes our work in each sector, from sometimes to most of the work. Our reading of typical programmes, not legal advice.</caption>
          <thead>
            <tr>
              <th scope="col">Force</th>
              <?php foreach ($IND as $prs_s): ?>
                <th scope="col"><span class="ind-prs__cn"><?= e($prs_s['n']) ?></span><?= e($prs_s['short']) ?></th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($prs_forces as $prs_ri => $prs_f): ?>
              <tr>
                <th scope="row"><span class="ind-prs__rn"><?= e($prs_f['n']) ?></span><?= e($prs_f['t']) ?></th>
                <?php foreach ($IND as $prs_ci => $prs_s): $prs_v = $prs_land[$prs_f['n']][$prs_s['id']]; ?>
                  <td>
                    <span class="ind-meter ind-meter--sm" data-v="<?= $prs_v ?>" style="--i:<?= $prs_ci ?>;--s:<?= $prs_ri ?>" aria-hidden="true"><i></i><i></i><i></i></span>
                    <span class="sr"><?= e($prs_lv[$prs_v]) ?></span>
                  </td>
                <?php endforeach; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <p class="ind-note ind-prs__note">Our reading of typical programmes in each category, for orientation. It is not legal advice, and it is not a substitute for your own counsel. Each sector dossier names the specific instruments.<span class="ind-prs__swipe"> Swipe the table to see all six sectors.</span></p>
    </figure>
  </div>
</section>
