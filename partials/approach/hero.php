<?php /* DRAFT COPY — review before launch */ ?>
<section class="band apr-hero" id="top" aria-labelledby="apr-hero-t">
  <div class="wrap apr-hero__grid">
    <div class="apr-hero__copy">
      <p class="lbl lbl--blue"><span class="dot"></span>Approach · how the operation runs</p>
      <h1 class="d1" id="apr-hero-t"><span class="g">AI runs the operation.</span> People run the strategy.</h1>
      <p class="lead">Agents draft, check, localise and monitor. Evals and guardrails hold them to a standard. Named people approve every step that matters, and every step is written to a log you can read.</p>
      <div class="apr-hero__cta">
        <a class="btn btn--ink btn--lg" href="#board">Watch the operation run <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out btn--lg" href="#contracts">Choose a contract <span class="i" aria-hidden="true">›</span></a>
      </div>
      <dl class="apr-hero__meta">
        <div><dt>Stages</dt><dd>Discover → Improve</dd></div>
        <div><dt>Human gates</dt><dd>One per stage</dd></div>
        <div><dt>Audit log</dt><dd>Every action</dd></div>
      </dl>
    </div>
    <div class="apr-hero__viz">
      <div class="apr-cp" aria-hidden="true">
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
          <li><time>09:44</time> guard.claims · "fastest" held for review</li>
          <li><time>09:52</time> gate.brand · waiting on approver</li>
        </ol>
      </div>
      <p class="bdh-sr">An operations console for a sample company: agents have drafted twelve campaign variants, evals passed eleven, a guardrail held one unsupported claim, and the work waits at a gate for the brand lead to approve or send back. Each step is recorded in a timestamped log.</p>
    </div>
  </div>
</section>
