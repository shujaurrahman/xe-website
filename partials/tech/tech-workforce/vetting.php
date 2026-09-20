<?php /* DRAFT COPY — review before launch */
/* Vetting — the funnel is one continuous narrowing shape, not twelve disconnected bars: each band
   is clipped from the number entering that stage to the number leaving it, so the narrowing is the
   picture rather than something to infer from stub widths. Beside it, each stage says what is
   actually assessed, who runs it, and its own pass rate on a 0–100% scale — which is the readable
   number, where an absolute width of 5 in 100 is not. Pass-through figures are illustrative.
   The shape is decorative (aria-hidden) and described in full for screen readers. */
$ttw_vt = [
    ['01', 'Profile screen', 'Senior engineer, 20 min', 'Evidence over CV claims: repositories, commit history, the systems actually shipped, and whether the stated depth matches the work.', 100, 32],
    ['02', 'Live technical interview', 'Senior engineer, 60 min', 'Coding in the language the role needs, with real constraints — no puzzle questions. Debugging an unfamiliar snippet, reasoning about complexity, and writing a test first.', 32, 17],
    ['03', 'Take-home or pairing', 'Tech lead, 2–3 h', 'A small, real problem: a failing service, a slow query, a flaky suite. Pairing is preferred so we see how they ask questions, not only what they submit.', 17, 10],
    ['04', 'System design', 'Principal engineer, 60 min', 'Sizing, data model, failure modes, idempotency, rollout and rollback. Scored for judgement about trade-offs rather than for naming a fashionable pattern.', 10, 7],
    ['05', 'AI tooling &amp; secure coding', 'Tech lead, 45 min', 'How they use AI assistants and how they check the output; input validation, secrets handling, dependency risk, and the OWASP Top 10 classes that apply to the role.', 7, 5],
    ['06', 'Communication &amp; references', 'Delivery manager, 45 min', 'Written clarity, disagreement handled well, incident behaviour, and two references from people who reviewed their code.', 5, 4],
];
$ttw_vt_in  = (int) $ttw_vt[0][4];
$ttw_vt_out = (int) $ttw_vt[count($ttw_vt) - 1][5];
/* The clip runs from the stage's entry width to its exit width, both centred on the shape. */
$ttw_vt_clip = function (int $in, int $out): string {
    return '--a1:' . ((100 - $in) / 2) . '%;--a2:' . ((100 + $in) / 2) . '%'
         . ';--b1:' . ((100 - $out) / 2) . '%;--b2:' . ((100 + $out) / 2) . '%';
};
?>
<section class="band ttw-vet" id="vetting" aria-labelledby="vetting-t">
  <div class="wrap">

    <header class="ttw-head" data-rv>
      <div class="ttw-head__t">
        <p class="lbl lbl--blue"><span class="dot"></span>Vetting</p>
        <h2 class="h2" id="vetting-t"><span class="g">How we vet</span> before you meet anyone.</h2>
      </div>
      <div class="ttw-head__l">
        <p class="lead">Engineers are assessed by engineers, in the stack the role needs. Every stage is run by a named person against a written scorecard, and you see the scorecard with the shortlist.</p>
        <span class="ttw-ill">Illustrative pass-through</span>
      </div>
    </header>

    <div class="ttw-vet__grid">

      <figure class="ttw-vet__fig">
        <figcaption class="ttw-vet__fc">
          <span class="ttw-lbl">Applicants for one role</span>
          <span class="ttw-vet__hl"><span class="ttw-fig"><?= $ttw_vt_in ?></span><span class="ttw-vet__ar" aria-hidden="true">→</span><span class="ttw-fig ttw-vet__hb"><?= $ttw_vt_out ?></span></span>
          <span class="ttw-ro ttw-vet__fs">screened, to reach your shortlist</span>
        </figcaption>
        <div class="ttw-vet__shape" data-bdh-in data-ttw-arm aria-hidden="true">
          <?php foreach ($ttw_vt as $ttw_v_i => $ttw_v): ?>
            <span class="ttw-vet__bn"><?= e($ttw_v[0]) ?></span>
            <span class="ttw-vet__bd" style="--i:<?= (int) $ttw_v_i ?>;<?= e($ttw_vt_clip((int) $ttw_v[4], (int) $ttw_v[5])) ?>"></span>
            <span class="ttw-vet__bc"><?= (int) $ttw_v[4] ?> in</span>
          <?php endforeach; ?>
          <span class="ttw-vet__bo"><?= $ttw_vt_out ?> reach your shortlist</span>
        </div>
        <p class="bdh-sr">A funnel narrowing through six stages. Of one hundred applicants for a role, thirty-two pass the profile screen, seventeen the live technical interview, ten the take-home or pairing exercise, seven the system design interview, five the AI-tooling and secure-coding interview, and four the communication and reference check. Those four reach your shortlist. The figures are illustrative.</p>
      </figure>

      <ol class="ttw-vet__stages">
        <?php foreach ($ttw_vt as $ttw_v_i => $ttw_v): $ttw_v_pct = (int) round($ttw_v[5] / $ttw_v[4] * 100); ?>
          <li class="ttw-vet__st" data-rv data-rv-s>
            <p class="ttw-vet__sh">
              <span class="ttw-vet__ix"><?= e($ttw_v[0]) ?></span>
              <span class="ttw-vet__sn"><?= $ttw_v[1] ?></span>
              <span class="ttw-ro ttw-vet__who"><?= e($ttw_v[2]) ?></span>
            </p>
            <p class="ttw-vet__d"><?= $ttw_v[3] ?></p>
            <p class="ttw-vet__rate">
              <span class="ttw-ro ttw-vet__rn"><?= (int) $ttw_v[5] ?> of <?= (int) $ttw_v[4] ?> continue</span>
              <span class="ttw-vet__meter" aria-hidden="true"><i style="--p:<?= $ttw_v_pct ?>%"></i></span>
              <span class="ttw-vet__pc"><?= $ttw_v_pct ?>% pass</span>
            </p>
          </li>
        <?php endforeach; ?>
      </ol>

    </div>

    <div class="ttw-vet__after">
      <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
      <figure class="bdh-img bdh-img--r43 ttw-vet__img" data-rv>
        <img src="<?= e(xe_url('assets/imgs/tech/tech-workforce/interview.jpg')) ?>" alt="Two people at a laptop during a technical interview, one talking through the code on screen" width="1200" height="900" loading="lazy" decoding="async">
      </figure>
      <div class="ttw-card ttw-vet__card" data-rv>
        <h3 class="bdh-t">What reaches you</h3>
        <!-- PLACEHOLDER: confirm vetting pass rates, bench size and shortlist timing before launch -->
        <ul class="ttw-vet__list" role="list">
          <li><span class="ttw-tick" aria-hidden="true"><svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 6.4 4.6 9 10 3"/></svg></span><span><b>A shortlist, not a stack of CVs.</b> Typically three to five engineers per role, each with the scorecard and the recording links from their interviews.</span></li>
          <li><span class="ttw-tick" aria-hidden="true"><svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 6.4 4.6 9 10 3"/></svg></span><span><b>Your own interview.</b> You interview anyone on the shortlist and decline anyone, for any reason, at no cost.</span></li>
          <li><span class="ttw-tick" aria-hidden="true"><svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 6.4 4.6 9 10 3"/></svg></span><span><b>Background verification.</b> Identity, education and previous employment checked before an offer, to the level your policy requires.</span></li>
          <li><span class="ttw-tick" aria-hidden="true"><svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 6.4 4.6 9 10 3"/></svg></span><span><b>A replacement commitment.</b> If the fit is wrong in the first weeks, we replace the engineer and do not bill the overlap.</span></li>
        </ul>
      </div>
    </div>

  </div>
</section>
