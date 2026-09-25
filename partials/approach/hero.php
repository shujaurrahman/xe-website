<?php /* DRAFT COPY — review before launch */
/* Hero — the claim, a live operations console, and the contents of the page. Sixteen sections is a long
   read, so the hero ends in a real contents list: five chapters, every section linked by its anchor, with
   the one-line promise of each. The console is decorative (aria-hidden) and described in .bdh-sr; hero.js
   arrives its log lines one at a time. Every figure in it is illustrative. */
$hero_meta = [
    ['Stages', 'Discover → Improve'],
    ['Named approvals', 'One per stage'],
    ['Audit log', 'Every agent action'],
    ['The output', 'Yours on payment'],
];
$hero_toc = [
    ['01', 'The principle', [
        ['principle',   'Five controls', 'What sits between an agent and your brand'],
        ['board',       'One job, six lanes', 'Watch a piece of work cross the intelligence layer'],
    ]],
    ['02', 'How a project runs', [
        ['delivery',    'Six stages, gate by gate', 'What happens, who is in the room, what you keep'],
        ['agents',      'The agent register', 'Every agent, its scope, its limits, its named owner'],
        ['rhythm',      'A week on a programme', 'The calendar you actually get'],
    ]],
    ['03', 'How quality holds', [
        ['quality',     'The bars every release clears', 'Numbers written into acceptance criteria'],
        ['recovery',    'When it fails', 'Severities, response, and the review that follows'],
        ['governance',  'Who owns what', 'One backlog, a decision log, a reporting cadence'],
    ]],
    ['04', 'What we agree', [
        ['scope',       'Scope, change and estimates', 'Ranges, not points. Nothing added without your yes'],
        ['contracts',   'Six ways to engage', 'The same operating model, six contracts'],
        ['handover',    'Handover and IP', 'You own the output, and you can leave with it'],
    ]],
    ['05', 'How we work', [
        ['global',      'Your hours, our day', 'Two studios in India, written handovers, one overlap window'],
        ['boundaries',  'What we will not do', 'Eight lines we hold, and what we do instead'],
        ['responsible', 'Responsible AI', 'Six commitments written into the contract'],
        ['faq',         'Questions', 'Answered directly, including the awkward ones'],
    ]],
];
?>
<section class="band apr-hero" id="top" aria-labelledby="apr-hero-t">
  <div class="wrap">
    <div class="apr-hero__grid">
      <div class="apr-hero__copy">
        <p class="lbl lbl--blue"><span class="dot"></span>Approach · how a project actually runs</p>
        <h1 class="d1" id="apr-hero-t"><span class="g">AI runs the operation.</span> People run the strategy.</h1>
        <p class="lead">Agents draft, check, localise and monitor. Evals and guardrails hold them to a written standard. A named person approves every step that ships, spends or speaks for you, and every step lands in a log you can read.</p>
        <div class="apr-hero__cta">
          <a class="btn btn--ink btn--lg" href="#delivery">See a project, stage by stage <span class="i" aria-hidden="true">›</span></a>
          <a class="btn btn--out btn--lg" href="#board">Watch the operation run <span class="i" aria-hidden="true">›</span></a>
        </div>
        <dl class="apr-hero__meta">
          <?php foreach ($hero_meta as $hero_m): ?>
          <div><dt><?= e($hero_m[0]) ?></dt><dd><?= e($hero_m[1]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
      </div>

      <div class="apr-hero__viz">
        <div class="apr-cp" aria-hidden="true" data-bdh-live>
          <div class="apr-cp__bar"><span class="apr-cp__dots"><i></i><i></i><i></i></span><span>Operation · Your company</span><span class="apr-cp__live"><i class="bdh-pulse"></i>Live</span></div>
          <div class="apr-cp__cols">
            <div class="apr-cp__col">
              <p class="apr-cp__h"><?= xt_icon('agent') ?> Agents · running</p>
              <ul class="apr-cp__list">
                <li><span>Brief synthesis</span><b class="apr-ok">done</b></li>
                <li><span>Variant drafts × 12</span><b class="apr-ok">done</b></li>
                <li><span>Eval · brand rules</span><b>11 / 12</b></li>
                <li><span>Guardrail · claims</span><b class="apr-flag">1 held</b></li>
              </ul>
            </div>
            <div class="apr-cp__gate"><span><?= xt_icon('approve') ?></span><b>Gate</b></div>
            <div class="apr-cp__col apr-cp__col--p">
              <p class="apr-cp__h"><?= xt_icon('users') ?> People · deciding</p>
              <div class="apr-cp__ask">
                <p class="apr-cp__q">Approve 11 variants for market launch?</p>
                <p class="apr-cp__who">Approver · Brand lead, Your company</p>
                <p class="apr-cp__btns"><span class="apr-cp__b apr-cp__b--y">Approve</span><span class="apr-cp__b">Send back</span></p>
              </div>
            </div>
          </div>
          <ol class="apr-cp__log">
            <li><time>09:41</time> agent.draft · 12 variants · brief v4</li>
            <li><time>09:44</time> eval.brand · 11 pass · 1 contrast fail</li>
            <li><time>09:44</time> guard.claims · “fastest” held for review</li>
            <li><time>09:52</time> gate.brand · waiting on approver</li>
          </ol>
        </div>
        <p class="bdh-sr">An operations console for a sample company: agents have drafted twelve campaign variants, evals passed eleven, a guardrail held one unsupported claim, and the work waits at a gate for the brand lead to approve or send back. Each step is recorded in a timestamped log. Every figure is illustrative.</p>
      </div>
    </div>

    <nav class="apr-toc" aria-label="Contents of this page" data-rv>
      <p class="apr-toc__k"><span class="apr-toc__ki"><?= xt_icon('doc', ['size' => 15]) ?></span>On this page · five chapters, fifteen answers</p>
      <ol class="apr-toc__ch">
        <?php foreach ($hero_toc as $hero_c): ?>
        <li class="apr-toc__c">
          <p class="apr-toc__cn"><span><?= e($hero_c[0]) ?></span><?= e($hero_c[1]) ?></p>
          <ul class="apr-toc__l">
            <?php foreach ($hero_c[2] as $hero_s): ?>
            <li><a href="#<?= e($hero_s[0]) ?>"><b><?= e($hero_s[1]) ?></b><span><?= e($hero_s[2]) ?></span></a></li>
            <?php endforeach; ?>
          </ul>
        </li>
        <?php endforeach; ?>
      </ol>
    </nav>
  </div>
</section>
