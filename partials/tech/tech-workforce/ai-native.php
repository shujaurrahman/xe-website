<?php /* DRAFT COPY — review before launch */
/* AI-native — how an engineer on your account actually works: an assistant in the editor under
   your policy, generated tests, an agent-drafted pull request, and a human review that is never
   optional. Beside it the policy card and the DORA measures we report against.
   The mock is decorative (aria-hidden) with a .bdh-sr description; ai-native.js types the
   suggestion and runs the checks while the section is on screen. */
$ttw_an_code = [
    ['ln', 'export async function withRetry&lt;T&gt;('],
    ['ln', '  fn: () =&gt; Promise&lt;T&gt;,'],
    ['ln', '  { attempts = 9, baseMs = 200 } = {}'],
    ['ln', '): Promise&lt;T&gt; {'],
    ['ln', '  for (let i = 0; i &lt; attempts; i++) {'],
    ['ln', '    try { return await fn(); }'],
    ['ln', '    catch (err) { if (i === attempts - 1) throw err; }'],
];
$ttw_an_ghost = '    await sleep(Math.min(baseMs * 2 ** i, 5_000) + jitter());';

$ttw_an_checks = [
    ['ESLint &amp; type check', 'passed', '38 s'],
    ['Unit tests · 142', 'passed', '1 m 04 s'],
    ['Contract tests · 26', 'passed', '52 s'],
    ['Secret scan &amp; CodeQL', 'passed', '1 m 11 s'],
    ['Human review', 'required', 'blocking'],
];

$ttw_an_policy = [
    ['approve', 'Approved assistants only', 'Configured against your organisation accounts, not personal ones, so usage sits inside your own audit trail.'],
    ['lock', 'Your code stays out of public training', 'Enterprise or zero-retention endpoints where your contract requires them, with the setting evidenced in writing.'],
    ['scan', 'Secrets scanning on every commit', 'Pre-commit hooks and a CI gate, because assistants paste as readily as engineers do.'],
    ['eye', 'A human reviews and a human approves', 'Generated code is reviewed by a named engineer on your side. An agent never approves its own pull request.'],
    ['log', 'Sessions logged to the engineer and repository', 'Prompt and completion metadata retained for the engagement, available to you on request.'],
];

$ttw_an_dora = [
    ['Deployment frequency', 'Daily or better', 'Per service, once the pipeline is theirs to use'],
    ['Lead time for changes', '≤ 2 days', 'Commit to production, median'],
    ['Change failure rate', '&lt; 15%', 'Deployments needing a fix or rollback'],
    ['Time to restore service', '&lt; 4 h', 'From detection to service restored'],
];

$ttw_an_tools = ['github', 'gitlab', 'jira', 'linear', 'anthropic', 'openai', 'githubcopilot', 'cursor'];
?>
<section class="band band--ink ttw-ai" id="ai-native" aria-labelledby="ai-native-t">
  <div class="wrap">

    <header class="ttw-head ttw-head--wide" data-rv>
      <div class="ttw-head__t">
        <p class="lbl lbl--blue"><span class="dot"></span>AI-native delivery</p>
        <h2 class="h2" id="ai-native-t"><span class="g">Every engineer ships with AI,</span> under your policy.</h2>
      </div>
      <div class="ttw-head__l">
        <p class="lead">Assistants are part of the job, so they are part of the contract. Tools run on your accounts, generated code is reviewed by a person, and the effect shows up in DORA metrics rather than in a claim about speed.</p>
      </div>
    </header>

    <div class="ttw-ai__grid">

      <div class="ttw-ai__work" data-ttw-ai>
        <div class="ttw-win ttw-win--ink ttw-ai__ide" aria-hidden="true">
          <p class="ttw-win__bar">
            <span class="ttw-win__dots"><i></i><i></i><i></i></span>
            <span class="ttw-win__path">src/lib/<b>retry.ts</b></span>
            <span class="ttw-win__end"><span class="ttw-ai__asst"><span class="ttw-led ttw-led--pulse"></span>assistant · your org</span></span>
          </p>
          <div class="ttw-ai__code">
            <?php foreach ($ttw_an_code as $ttw_an_i => $ttw_an_l): ?>
              <p class="ttw-ai__l"><span class="ttw-ai__no"><?= $ttw_an_i + 1 ?></span><code><?= $ttw_an_l[1] ?></code></p>
            <?php endforeach; ?>
            <p class="ttw-ai__l ttw-ai__l--g" data-ttw-ghost><span class="ttw-ai__no">8</span><code data-ttw-ghost-t><?= e($ttw_an_ghost) ?></code></p>
            <p class="ttw-ai__l"><span class="ttw-ai__no">9</span><code>  }</code></p>
            <p class="ttw-ai__l"><span class="ttw-ai__no">10</span><code>}</code></p>
          </div>
          <p class="ttw-ai__sug">
            <span class="ttw-ai__sl" data-ttw-state>Suggestion accepted</span>
            <span class="ttw-ro">Tab to accept · Esc to reject · 3 of 7 suggestions accepted today</span>
          </p>
        </div>

        <div class="ttw-win ttw-win--ink ttw-ai__pr" aria-hidden="true">
          <p class="ttw-win__bar">
            <span class="ttw-win__path">Pull request <b>#1842</b> · drafted by agent, owned by the engineer</span>
            <span class="ttw-win__end"><span class="ttw-ill">Illustrative</span></span>
          </p>
          <div class="ttw-ai__prb">
            <p class="ttw-ai__prt">fix(retry): cap exponential backoff at 5 s</p>
            <p class="ttw-ai__prd">With no ceiling the eight waits between nine attempts add up to 51 s, and a worker is held for the whole window. Capping each delay at 5 s brings the same nine attempts to about 21 s. Adds a test for the cap and one for the jitter bound.</p>
            <ul class="ttw-ai__checks" role="list">
              <?php foreach ($ttw_an_checks as $ttw_an_ci => $ttw_an_c): ?>
                <li class="ttw-ai__chk" data-ttw-check style="--i:<?= (int) $ttw_an_ci ?>">
                  <span class="ttw-led<?= $ttw_an_c[1] === 'required' ? ' ttw-led--off' : '' ?>"></span>
                  <span class="ttw-ai__cn"><?= $ttw_an_c[0] ?></span>
                  <span class="ttw-ro ttw-ai__cs"><?= e($ttw_an_c[1]) ?> · <?= e($ttw_an_c[2]) ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
        <p class="bdh-sr">A mock editor showing a retry helper in TypeScript. An assistant suggests capping the exponential backoff at five seconds; the engineer accepts it. Below, a pull request drafted by an agent and owned by the engineer passes lint, unit tests, contract tests and a secret scan, and still waits on a required human review.</p>
      </div>

      <aside class="ttw-ai__side">
        <div class="ttw-card ttw-ai__pol">
          <h3 class="bdh-t">Your policy, not ours</h3>
          <ul class="ttw-ai__pl" role="list">
            <?php foreach ($ttw_an_policy as $ttw_an_p): ?>
              <li>
                <span class="ttw-ai__pi"><?= xt_icon($ttw_an_p[0], ['size' => 18]) ?></span>
                <span class="ttw-ai__pt"><b><?= e($ttw_an_p[1]) ?></b><?= e($ttw_an_p[2]) ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
          <p class="ttw-ai__tools"><span class="ttw-lbl">Tools we work in</span><?= xt_stack($ttw_an_tools, ['variant' => 'logos', 'size' => 22, 'label' => 'Engineering tools we work in']) ?></p>
        </div>

        <div class="ttw-card ttw-ai__dora">
          <h3 class="bdh-t">Measured with DORA</h3>
          <p class="bdh-d">The four DORA measures are reported every sprint for the services the squad touches. These are the targets we work to; the baseline is taken in the first month.</p>
          <!-- PLACEHOLDER: confirm DORA targets per engagement before launch -->
          <ul class="ttw-ai__dt" role="list">
            <?php foreach ($ttw_an_dora as $ttw_an_d): ?>
              <li><span class="ttw-lbl"><?= e($ttw_an_d[0]) ?></span><span class="ttw-fig"><?= $ttw_an_d[1] ?></span><span class="ttw-ro"><?= e($ttw_an_d[2]) ?></span></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </aside>

    </div>

  </div>
</section>
