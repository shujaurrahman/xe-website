<?php /* DRAFT COPY — review before launch */
/* Principles — the terms we work on. A sticky head with a photograph on the left; on the right a terms sheet
   (a document window): six clauses, each with the plain answer, who usually asks, and how the term is enforced
   in the work itself (a repository rule, a CI policy, a gateway setting, a definition of done), so the promise
   is checkable rather than asserted. principles.js types each "enforced as" block the first time it scrolls in;
   the icons draw once (CSS). No certification is claimed here. */
$pr_terms = [
    ['code', 'You own the code and the model configuration',
     'Source code, infrastructure code, prompts, eval sets and model and gateway configuration live in your repositories from the first commit, and the IP is assigned to you as it is created.',
     ['Legal', 'Procurement'], 'repository',
     ['repo.owner    = "your-org"', 'ip.assignment = "on creation"', 'includes      = [code, iac, prompts, evals, model_config]']],
    ['sync', 'Model-agnostic and reversible',
     'Every model sits behind a gateway and an eval suite. Changing provider, or bringing a model in-house, is a configuration change we can demonstrate, not a rebuild.',
     ['CTO', 'Procurement'], 'gateway config',
     ['route "support.answer" { model = var.model }', 'switch.requires = "golden set ≥ gate"', 'lock_in         = none  # open formats, your keys']],
    ['shield', 'Security from the first commit',
     'Least-privilege access, your single sign-on where you have it, secrets in a vault, scans on every build, and your security questionnaire answered during scoping, not after.',
     ['Security', 'IT'], 'CI policy',
     ['ci.required = [sast, deps, secrets, iac, image]', 'access      = sso + mfa, least privilege', 'secrets     = vault only · never in prompts']],
    ['approve', 'People approve, agents assist',
     'Agents draft, test and propose. A named person approves every merge, every production change and any action that reaches your customers, and every AI action is logged.',
     ['Security', 'Risk'], 'branch protection',
     ['main.required_reviews = 1   # a named person', 'agents.can_merge      = false', 'ai_actions.log        = [model, prompt, reviewer]']],
    ['chart', 'Measured, not asserted',
     'Targets for speed, reliability, AI quality, security, cost and carbon are agreed before launch and reported every month with their definitions, good months and bad.',
     ['CTO', 'Finance'], 'service report',
     ['report.monthly = [cwv_p75, slo_30d, evals, vulns,', '                  cost_per_1k, sci_per_request]', 'targets        = "agreed before launch"']],
    ['doc', 'Documentation and handover are deliverables',
     'Architecture decisions, runbooks, dashboards and onboarding guides are written as the work lands and accepted like any other deliverable, so your team can run it without us.',
     ['IT', 'Operations'], 'definition of done',
     ['done    += [adr, runbook, dashboard, alert, owner]', 'handover = "rehearsed, not emailed"']],
];
?>
<section class="band tih-principles" id="principles" aria-labelledby="principles-t">
  <div class="wrap bdh-grid tih-pr__grid">
    <div class="bdh-c4 tih-pr__side">
      <div class="bdh-sticky tih-pr__stick">
        <div class="bdh-head tih-pr__head" data-rv>
          <p class="lbl lbl--blue"><span class="dot"></span>How we work with you</p>
          <h2 class="h2" id="principles-t"><span class="g">The terms,</span> written into the build.</h2>
          <p class="lead">Procurement, legal, IT and security ask the same questions. Here are the answers, and where each one is enforced in the work.</p>
        </div>
        <!-- PLACEHOLDER: reference photograph (Unsplash) — replace with commissioned/own imagery before launch -->
        <figure class="bdh-img bdh-img--r45 bdh-zoom tih-pr__img" data-rv data-rv-d="100">
          <img src="<?= xe_url('assets/imgs/tech/hub/principles-review.jpg') ?>" alt="Two engineers reviewing code together on a laptop" width="1800" height="1013" loading="lazy" decoding="async">
          <span class="bdh-cap-chip tih-pr__chip"><b>Review, not handoff</b>Decisions written down as they are made</span>
        </figure>
      </div>
    </div>

    <div class="bdh-c7 bdh-s6 tih-pr__doc" data-rv data-rv-d="60">
      <div class="tih-pr__bar">
        <span class="tih-pr__file">terms.md <i>·</i> Your company × <?= e($SITE['company']['name']) ?></span>
        <span class="tih-pr__ver"><?= count($pr_terms) ?> clauses</span>
      </div>
      <ol class="tih-pr__list">
        <?php foreach ($pr_terms as $pr_i => $pr_t): ?>
          <li class="tih-pr__term" style="--i:<?= $pr_i ?>">
            <span class="tih-pr__ico" aria-hidden="true"><?= xt_icon($pr_t[0], ['size' => 22]) ?></span>
            <div class="tih-pr__main">
              <p class="tih-pr__meta"><span class="tih-pr__sec">§<?= $pr_i + 1 ?></span><span class="tih-pr__who"><span class="bdh-sr">Usually asked by </span><?= e(implode(' · ', $pr_t[3])) ?></span></p>
              <h3 class="tih-pr__t"><?= e($pr_t[1]) ?></h3>
              <p class="tih-pr__d"><?= e($pr_t[2]) ?></p>
              <div class="tih-pr__code">
                <p class="tih-pr__ck"><span>Enforced as</span><b><?= e($pr_t[4]) ?></b></p>
                <pre class="tih-pr__pre"><?php foreach ($pr_t[5] as $pr_ln): ?><code><?= e($pr_ln) ?></code>
<?php endforeach; ?></pre>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
      <p class="tih-pr__foot">Alignment with ISO/IEC 27001, SOC 2 or ISO/IEC 42001 describes how we work. It is not a certification claim; certificates come from independent auditors.</p>
    </div>
  </div>
</section>
