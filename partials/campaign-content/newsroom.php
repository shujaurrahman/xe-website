<?php /* DRAFT COPY — review before launch */
/* Newsroom — the part of the discipline you cannot buy: being repeated accurately. A message house
   built as a CSS flow diagram (claim, then the evidence under it, then the question each piece of
   evidence invites), what a newsroom has to publish before it can be quoted, an illustrative answer
   panel showing what "cited" looks like now, who repeats it and how that is measured, and the crisis
   work done while everything is still calm. Every position here is the one set out for Public
   Relations in data/campaign-content.php, including the refusal to promise coverage.
   PLACEHOLDER: the example claim, evidence and answer panel are illustrative, not a real client. */
$nr_proofs = [
    ['A named customer, before and after', 'Published with their permission, with the dates and the scope stated.', 'Which customer, and can I speak to them?'],
    ['A method note behind the number',    'How the saving is calculated, what is inside the figure and what is not.', 'What is left out of this?'],
    ['An independent benchmark',            'A third-party study or analyst note, with who commissioned it on the record.', 'Who paid for the research?'],
];
$nr_room = [
    ['Fact page',                'The numbers, dated and sourced, in one place a journalist can cite without ringing you.', 'doc'],
    ['Data story',               'Original analysis with the method published, so anyone can check it rather than trust it.', 'chart'],
    ['Quote bank',               'Approved quotes attributed to a named spokesperson with a real title, ready to lift.', 'chat'],
    ['Structured data',          'schema.org Organization, Article and Person markup, so a machine can attribute the claim to you.', 'code'],
    ['Spokesperson pages',       'Who to ask, what each person actually covers, and the route to reach them.', 'users'],
    ['Image and footage library','High resolution, with the licence, the term and the releases attached to each file.', 'vision'],
];
$nr_who = [
    ['Journalists',        'Briefings, exclusives and announcements run with embargo discipline.', 'Coverage volume and quality, and whether your key messages survive into the article.'],
    ['Analysts and awards','Questionnaire responses and evidence packs for the bodies your buyers read.', 'Inclusion, category placement and what the write-up says about you.'],
    ['Answer engines',     'Fact pages and data stories structured so a model can quote them correctly.', 'Whether an engine names you when it is asked about your category, tracked against a baseline.'],
];
$nr_crisis = [
    ['Scenarios',          'The handful of things that could actually go wrong, written down while nothing has.'],
    ['Holding statements', 'Drafted and legally reviewed in advance, so the first hour is not spent writing.'],
    ['Escalation tree',    'Who is called, in what order, with a named deputy for everyone on it.'],
    ['A rehearsed hour',   'One walkthrough with the real people, because a plan nobody has read is not a plan.'],
];
$nr_answer = [
    ['1', 'Your company', 'yourcompany.example/facts'],
    ['2', 'A trade title', 'coverage · published this quarter'],
    ['3', 'An analyst note', 'category landscape'],
];
$nr_pr = $CAPS['public-relations'];
?>
<section class="band band--alt cch-newsroom" id="newsroom" aria-labelledby="newsroom-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Earned attention</p>
        <h2 class="h2" id="newsroom-t"><span class="g">Being mentioned is easy.</span> Being quoted correctly is the work.</h2>
      </div>
      <div>
        <p class="lead">Advertising is what you say. Coverage is what other people repeat, and what a model repeats when someone asks about your category. Both need the same thing first: a claim that survives the next question.</p>
      </div>
    </div>

    <div class="cch-nr__house" data-rv data-rv-d="60">
      <p class="cch-nr__hk"><span class="cch-k">The message house</span><span class="cch-ill">Illustrative</span></p>
      <div class="cch-nr__claim">
        <p class="cch-k">The claim</p>
        <p class="cch-nr__ct">Teams move to us because the switch pays for itself inside a year.</p>
      </div>
      <p class="cch-nr__bar" aria-hidden="true"><i></i><i></i><i></i></p>
      <ol class="cch-nr__proofs">
        <?php foreach ($nr_proofs as $nr_i => $nr_p): ?>
          <li class="cch-nr__proof">
            <p class="cch-k">Evidence <?= str_pad((string) ($nr_i + 1), 2, '0', STR_PAD_LEFT) ?></p>
            <h3 class="cch-nr__pt"><?= e($nr_p[0]) ?></h3>
            <p class="cch-nr__pd"><?= e($nr_p[1]) ?></p>
            <p class="cch-nr__pq"><span class="cch-k">The question it invites</span><?= e($nr_p[2]) ?></p>
          </li>
        <?php endforeach; ?>
      </ol>
      <p class="cch-note cch-nr__hn">Nothing is pitched until the narrative, the evidence and the spokespeople are ready. Preparation is what turns interest into an article.</p>
    </div>

    <div class="cch-nr__mid">
      <div class="cch-nr__room" data-rv data-rv-d="60">
        <h3 class="cch-nr__mt">What a newsroom has to publish before it can be quoted</h3>
        <ul class="cch-tiles cch-nr__tiles" role="list">
          <?php foreach ($nr_room as $nr_r): ?>
            <li class="cch-tile">
              <span class="cch-tile__top">
                <span class="cch-tile__ico" aria-hidden="true"><?= xt_icon($nr_r[2], ['size' => 18]) ?></span>
                <span class="cch-tile__t"><?= e($nr_r[0]) ?></span>
              </span>
              <span class="cch-tile__d"><?= e($nr_r[1]) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="cch-nr__side" data-rv data-rv-d="100">
        <p class="bdh-sr">An illustrative answer panel: someone asks an answer engine who to look at in a category, and the answer names Your company first, citing the company's own fact page, a trade title and an analyst note.</p>
        <div class="cch-nr__panel cch-on-ink" aria-hidden="true">
          <p class="cch-nr__pbar"><span class="bdh-ui__dots"><i></i><i></i><i></i></span><span>answer engine</span><span class="cch-ill">Illustrative</span></p>
          <p class="cch-nr__prompt"><i>›</i>who should we look at in this category, in India?</p>
          <p class="cch-nr__ans">Three names come up consistently. <b>Your company</b><sup>1</sup> is usually mentioned first for teams moving off spreadsheets, and its published method note<sup>1</sup> is the only one that states what is inside the saving. Trade coverage<sup>2</sup> and an analyst landscape<sup>3</sup> both place it in the same group.</p>
          <ul class="cch-nr__src" role="list">
            <?php foreach ($nr_answer as $nr_a): ?>
              <li><span><?= e($nr_a[0]) ?></span><b><?= e($nr_a[1]) ?></b><em><?= e($nr_a[2]) ?></em></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <p class="cch-note cch-nr__sn">A model can only name you from what it can read and attribute. That is why the newsroom is built before the outreach, not after it.</p>
      </div>
    </div>

    <div class="cch-nr__who" data-rv data-rv-d="60">
      <h3 class="cch-nr__mt">Who repeats it, and how we know</h3>
      <div class="cch-nr__wgrid">
        <?php foreach ($nr_who as $nr_wi => $nr_w): ?>
          <div class="cch-nr__wc">
            <p class="cch-nr__wn"><span><?= str_pad((string) ($nr_wi + 1), 2, '0', STR_PAD_LEFT) ?></span><?= e($nr_w[0]) ?></p>
            <p class="cch-nr__wd"><?= e($nr_w[1]) ?></p>
            <p class="cch-nr__wm"><span class="cch-k">Measured by</span><?= e($nr_w[2]) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="cch-nr__crisis" data-rv data-rv-d="60">
      <div class="cch-nr__ch">
        <p class="lbl lbl--blue"><span class="dot"></span>Issues readiness</p>
        <h3 class="cch-nr__mt">A bad week is survivable if the work was done in a calm one</h3>
        <p class="cch-nr__cd">Communications follow the incident, never the other way round. We work with your security and legal teams so statements match the timelines that apply, such as breach intimation under India's DPDP Act and the CERT-In reporting directions.</p>
      </div>
      <ol class="cch-nr__clist">
        <?php foreach ($nr_crisis as $nr_ci => $nr_c): ?>
          <li><b><?= e($nr_c[0]) ?></b><span><?= e($nr_c[1]) ?></span></li>
        <?php endforeach; ?>
      </ol>
    </div>

    <div class="cch-nr__honest" data-rv data-rv-d="60">
      <p class="cch-nr__hq"><span class="g">We cannot guarantee coverage.</span> Editorial decisions belong to journalists and editors.</p>
      <div class="cch-nr__hc">
        <p class="cch-nr__hd">We commit to the narrative, the evidence, the relationships and the measurement, and we report what landed and what did not. Paid partnerships, sponsored content and advertorials are bought and labelled as advertising, and kept clearly separate from earned coverage.</p>
        <p class="cch-capls">
          <a class="cch-capl" href="#public-relations"><b><?= e($nr_pr['n']) ?></b><?= e($nr_pr['short']) ?><i aria-hidden="true">›</i></a>
          <a class="cch-capl" href="#content-marketing"><b><?= e($CAPS['content-marketing']['n']) ?></b><?= e($CAPS['content-marketing']['short']) ?><i aria-hidden="true">›</i></a>
        </p>
        <a class="btn btn--out btn--sm" href="<?= e(svc_contact_url(['campaign-content:pr-programme'], null, 'campaign-content')) ?>">Start a PR brief <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>
  </div>
</section>
