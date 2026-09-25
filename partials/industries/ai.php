<?php /* DRAFT COPY — review before launch */
/* AI — the first agent worth building in each category, shown as the run it would actually produce.
   A console on ink: a tablist of the six categories across the head, one pane per category with the
   agent, what it is grounded in, and an illustrative run log. Below, the four bounds that are the same
   in every category. ai.js wires BDH.tabs (keyboard, auto-advance until the first interaction); the
   first pane ships with .is-on, so with JavaScript off the console shows a complete run.
   PLACEHOLDER: every run log is illustrative. No log here is from a client system. */
$ind_bounds = [
    ['database', 'Grounded, not generative', 'Every answer is drawn from a named system of record: a claim library, a live catalogue, a property system, your own documentation. If the source does not say it, the assistant does not either.'],
    ['lock',     'Tools on an allow-list', 'An agent may call the functions we listed and nothing else. Prompt injection is treated as the default threat rather than an edge case, and adversarial cases sit in the eval set.'],
    ['approve',  'A person approves anything that changes something', 'A price, a record, a clinical or a credit outcome: a named reviewer decides. The agent proposes, drafts and prioritises. It does not decide.'],
    ['log',      'Evals before release, an audit log after', 'A fixed set of real cases scored on every change to a model, a prompt or a source, with an agreed gate. Every answer stores its inputs, its sources, the model version and the reviewer.'],
];
?>
<section class="band band--ink ind-ai" id="ai" aria-labelledby="ai-t">
  <div class="wrap">
    <div class="ind-head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>AI, per category</p>
        <h2 class="h2" id="ai-t"><span class="g">One agent worth building first,</span> in each category.</h2>
      </div>
      <div>
        <p class="lead">The interesting question is never which model. It is what the agent is allowed to read, what it may do on its own, and what a person has to sign. Here is the first agent we would build in each category, and the run it would produce.</p>
      </div>
    </div>

    <div class="bdh-ui bdh-ui--ink ind-ai__ui" data-rv data-rv-d="60" data-ind-ai>
      <div class="ind-ai__bar">
        <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <p class="ind-k ind-ai__bk">Agent run <span class="bdh-ill ind-ai__ill">Illustrative</span></p>
        <div class="ind-seg ind-ai__seg" role="tablist" aria-label="Category">
          <?php foreach (array_values($IND_SET) as $ind_i => $ind_c): $ind_on = $ind_i === 0; ?>
            <button type="button" role="tab" id="ai-t<?= $ind_i ?>" aria-controls="ai-p<?= $ind_i ?>"
                    aria-selected="<?= $ind_on ? 'true' : 'false' ?>" tabindex="<?= $ind_on ? '0' : '-1' ?>"><?= e($ind_c['short']) ?></button>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="bdh-panes ind-ai__panes">
        <?php foreach (array_values($IND_SET) as $ind_i => $ind_c): $ind_a = $ind_c['ai']; ?>
          <div class="bdh-pane ind-ai__pane<?= $ind_i === 0 ? ' is-on' : '' ?>" id="ai-p<?= $ind_i ?>" role="tabpanel" aria-labelledby="ai-t<?= $ind_i ?>">
            <div class="ind-ai__meta">
              <div>
                <p class="ind-k">First agent · <?= e($ind_c['name']) ?></p>
                <h3 class="ind-ai__an"><?= e($ind_a['agent']) ?></h3>
              </div>
              <div>
                <p class="ind-k">Grounded in</p>
                <p class="ind-ai__gr"><?= e($ind_a['ground']) ?></p>
              </div>
            </div>
            <ol class="ind-ai__log" aria-label="Run log for the <?= e($ind_a['agent']) ?>">
              <?php foreach ($ind_a['log'] as $ind_li => $ind_ln): ?>
                <li style="--i:<?= $ind_li ?>">
                  <span class="ind-ai__lt"><?= e($ind_ln[0]) ?></span>
                  <span class="ind-ai__ls"><?= e($ind_ln[1]) ?></span>
                  <span class="ind-ai__ll"><?= e($ind_ln[2]) ?></span>
                </li>
              <?php endforeach; ?>
            </ol>
            <p class="ind-ai__pf">
              <span class="bdh-pulse" aria-hidden="true"></span>
              Nothing in this run leaves a trace we cannot show you: inputs, sources, model version and reviewer are stored with the answer.
            </p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <ol class="ind-ai__bounds" data-rv-s data-rv-step="70" aria-label="The bounds that apply in every category">
      <?php foreach ($ind_bounds as $ind_bi => $ind_b): ?>
        <li>
          <span class="ind-ai__bi" aria-hidden="true"><?= xt_icon($ind_b[0], ['size' => 20, 'mono' => true]) ?></span>
          <p class="ind-k">Bound <?= str_pad((string) ($ind_bi + 1), 2, '0', STR_PAD_LEFT) ?></p>
          <h3 class="bdh-t bdh-t--s"><?= e($ind_b[1]) ?></h3>
          <p class="bdh-d"><?= e($ind_b[2]) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
