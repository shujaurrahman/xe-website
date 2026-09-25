<?php /* DRAFT COPY — review before launch */
/* States — designing for the wrong answer. Four interface states every AI product needs, each drawn as a small
   code-built mock (aria-hidden, described by a .bdh-sr sentence). No JS. */
?>
<section class="band aih-states" id="states" aria-labelledby="states-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Designed for the wrong answer</p>
        <h2 class="h2" id="states-t"><span class="g">The model will be unsure, slow or wrong.</span> The interface is designed for all three.</h2>
      </div>
      <div><p class="lead">Most AI products are designed for the demo answer. We design the four states people actually meet, so a bad answer costs one click instead of their trust.</p></div>
    </div>

    <div class="aih-sts">
      <article class="aih-sts__i">
        <div class="aih-sts__mock" aria-hidden="true">
          <div class="aih-bub">Returns are free within 30 days for unworn items<sup>1</sup>, except final-sale lines<sup>2</sup>.</div>
          <div class="aih-conf"><span>Confidence</span><span class="aih-conf__m"><i></i><i></i><i class="off"></i></span><span>Medium</span></div>
          <div class="aih-src"><span>1 · Returns policy v3</span><span>2 · Sale terms</span></div>
        </div>
        <p class="bdh-sr">Mock: an assistant answer with two numbered citations and a medium confidence meter.</p>
        <p class="aih-sts__k">01 · Uncertain</p>
        <h3 class="aih-sts__t">Show the sources and how sure it is</h3>
        <p class="aih-sts__d">Citations and confidence sit on the answer, so people check the claims that matter rather than trusting all of it or none of it.</p>
      </article>

      <article class="aih-sts__i">
        <div class="aih-sts__mock" aria-hidden="true">
          <p class="aih-stream__k"><span class="bdh-pulse"></span>Reading 3 documents · 2.1 s</p>
          <div class="aih-stream"><i style="--w:92%"></i><i style="--w:78%"></i><i style="--w:40%"></i></div>
          <div class="aih-mock__row"><span class="aih-mock__btn">Stop</span><span class="aih-mock__hint">Partial answer kept</span></div>
        </div>
        <p class="bdh-sr">Mock: a streaming answer showing what the system is reading, elapsed time and a stop button.</p>
        <p class="aih-sts__k">02 · Slow</p>
        <h3 class="aih-sts__t">Say what it is doing at four seconds</h3>
        <p class="aih-sts__d">Streaming, visible progress and a stop that keeps the partial result. Waiting feels shorter when people can see the work.</p>
      </article>

      <article class="aih-sts__i">
        <div class="aih-sts__mock" aria-hidden="true">
          <div class="aih-bub">Your order ships on <s>Monday</s> <b>Thursday</b> from the Pune warehouse.</div>
          <div class="aih-mock__row"><span class="aih-mock__tag">Corrected by you · logged for review</span><span class="aih-mock__btn">Undo</span></div>
        </div>
        <p class="bdh-sr">Mock: an answer where the person has corrected a date in place, with an undo control and a note that the correction was logged.</p>
        <p class="aih-sts__k">03 · Wrong</p>
        <h3 class="aih-sts__t">Make the correction one action away</h3>
        <p class="aih-sts__d">Edit in place, undo anything, reach a person. Each correction is logged and feeds the next evaluation set.</p>
      </article>

      <article class="aih-sts__i">
        <div class="aih-sts__mock" aria-hidden="true">
          <ol class="aih-plan">
            <li class="done">Build the segment · 1,240 people</li>
            <li class="done">Draft the email in brand voice</li>
            <li class="hold">Send to 1,240 people <span>Needs approval</span></li>
          </ol>
          <div class="aih-mock__row"><span class="aih-mock__btn">Edit plan</span><span class="aih-mock__btn aih-mock__btn--go">Approve</span></div>
        </div>
        <p class="bdh-sr">Mock: an agent plan of three steps; the last step, sending an email to 1,240 people, waits for approval.</p>
        <p class="aih-sts__k">04 · Consequential</p>
        <h3 class="aih-sts__t">Pause before anything that cannot be undone</h3>
        <p class="aih-sts__d">Agents show their plan. Steps that spend money, send messages or publish wait for a person, and the stop button never moves.</p>
      </article>
    </div>
  </div>
</section>
