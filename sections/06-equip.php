<?php /* DRAFT COPY — review before launch */ ?>
<section class="band band--rules bdh s06" id="equip" aria-labelledby="s06-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row s06__head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Capabilities</p>
        <h2 class="h2" id="s06-t"><span class="g">Equip your team</span> to move faster</h2>
      </div>
      <div>
        <p class="lead">Manage brand, product and growth on one system of shared intelligence.</p>
        <!-- Controls for the rail below. The rail is a native scroll-snap row, so every card is
             reachable by swipe, trackpad or keyboard even without JS; JS wires these buttons,
             and advances one card at a time only while the rail is on screen. -->
        <div class="s06__nav" data-s06-nav hidden>
          <button class="s06__arrow" type="button" data-s06-prev aria-controls="s06-rail" aria-label="Previous card">
            <svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M10 3 5 8l5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
          <button class="s06__arrow s06__play" type="button" data-s06-play aria-controls="s06-rail" aria-pressed="false" aria-label="Pause auto-advance">
            <svg class="s06__ico-pause" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M5.5 3.5v9M10.5 3.5v9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
            <svg class="s06__ico-play" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M5 3.2v9.6L12.6 8z" fill="currentColor"/></svg>
          </button>
          <button class="s06__arrow" type="button" data-s06-next aria-controls="s06-rail" aria-label="Next card">
            <svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M6 3l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
          <span class="s06__count" data-s06-count aria-hidden="true">01 / 05</span>
        </div>
      </div>
    </div>
  </div>

  <div class="s06__rail bdh-scroll-x mask-x" id="s06-rail" tabindex="0" role="region" aria-roledescription="carousel"
       aria-label="What we equip teams with, scroll sideways" data-s06-rail>
    <ul class="s06__track" data-s06-track>

      <li class="s06__slide">
      <article class="s06__card" aria-labelledby="s06-c1">
        <p class="s06__pill"><span class="s06__i" aria-hidden="true">01</span>Agents</p>
        <div class="s06__mock" aria-hidden="true">
          <span class="s06__bub">Can I move my delivery to Friday?</span>
          <span class="s06__bub s06__bub--a">Moved to Friday 09:00. Confirmation sent.</span>
          <span class="s06__tag">resolved · 1.2s</span>
        </div>
        <p class="bdh-sr">A support agent moves a customer's delivery to Friday 09:00 and confirms it, resolved in 1.2 seconds.</p>
        <h3 class="h3 s06__t" id="s06-c1">AI Strategy &amp; Agents</h3>
        <p class="s06__p">Where AI fits, what to build first, and custom agents that do real work.</p>
      </article>
      </li>

      <li class="s06__slide">
      <article class="s06__card" aria-labelledby="s06-c2">
        <p class="s06__pill"><span class="s06__i" aria-hidden="true">02</span>Automation</p>
        <div class="s06__mock" aria-hidden="true">
          <span class="s06__flow">
            <i class="s06__node">Trigger</i><b aria-hidden="true"></b>
            <i class="s06__node">Enrich</i><b aria-hidden="true"></b>
            <i class="s06__node is-done">Route <span class="f-d" aria-hidden="true">✓</span></i>
          </span>
          <span class="s06__tag">4 steps · no handoffs</span>
        </div>
        <p class="bdh-sr">A workflow runs trigger, enrich and route with no handoffs.</p>
        <h3 class="h3 s06__t" id="s06-c2">AI Product &amp; Automation</h3>
        <p class="s06__p">AI features, knowledge and workflow automation — inside your product and your ops.</p>
      </article>
      </li>

      <li class="s06__slide">
      <article class="s06__card" aria-labelledby="s06-c3">
        <p class="s06__pill"><span class="s06__i" aria-hidden="true">03</span>Visibility</p>
        <div class="s06__mock" aria-hidden="true">
          <ul class="s06__list">
            <li><span>Google</span><i aria-hidden="true">✓</i></li>
            <li><span>ChatGPT</span><i aria-hidden="true">✓</i></li>
            <li><span>Perplexity</span><i aria-hidden="true">✓</i></li>
            <li><span>AI Overviews</span><i aria-hidden="true">✓</i></li>
          </ul>
          <span class="s06__tag">cited, not just ranked</span>
        </div>
        <p class="bdh-sr">A brand checked as present on Google, ChatGPT, Perplexity and AI Overviews: cited, not just ranked.</p>
        <h3 class="h3 s06__t" id="s06-c3">Search &amp; AI Visibility</h3>
        <p class="s06__p">Ranking on Google and getting cited by the answer engines — as one system.</p>
      </article>
      </li>

      <li class="s06__slide">
      <article class="s06__card" aria-labelledby="s06-c4">
        <p class="s06__pill"><span class="s06__i" aria-hidden="true">04</span>Audits</p>
        <div class="s06__mock s06__mock--ring" aria-hidden="true">
          <svg class="s06__ring" viewBox="0 0 80 80" aria-hidden="true">
            <circle cx="40" cy="40" r="32" fill="none" stroke="currentColor" stroke-width="6" opacity=".12"/>
            <circle class="s06__ringv" cx="40" cy="40" r="32" fill="none" stroke="currentColor" stroke-width="6"
                    stroke-linecap="round" stroke-dasharray="201" stroke-dashoffset="30" transform="rotate(-90 40 40)"/>
          </svg>
          <ul class="s06__scores">
            <li><span>Technical</span><i>92</i></li>
            <li><span>Content</span><i>78</i></li>
            <li><span>AI readiness</span><i>64</i></li>
          </ul>
        </div>
        <p class="bdh-sr">An example audit scorecard: technical 92, content 78, AI readiness 64.</p>
        <h3 class="h3 s06__t" id="s06-c4">Audits &amp; Assessments</h3>
        <p class="s06__p">What's broken, what it's costing you, and what to fix first.</p>
      </article>
      </li>

      <li class="s06__slide">
      <article class="s06__card" aria-labelledby="s06-c5">
        <p class="s06__pill"><span class="s06__i" aria-hidden="true">05</span>Squads</p>
        <div class="s06__mock" aria-hidden="true">
          <span class="s06__team">
            <i class="mono-tile">EN</i><i class="mono-tile">AI</i><i class="mono-tile">DS</i><i class="mono-tile">PM</i>
          </span>
          <span class="s06__tag">your stack · your sprint cadence</span>
        </div>
        <p class="bdh-sr">A four-role squad (engineering, AI, data science, product) working in your stack and sprint cadence.</p>
        <h3 class="h3 s06__t" id="s06-c5">Tech Workforce</h3>
        <p class="s06__p">Vetted engineers, AI specialists and full delivery squads embedded in your team.</p>
      </article>
      </li>

    </ul>
  </div>
</section>
