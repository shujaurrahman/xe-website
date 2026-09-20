<?php /* DRAFT COPY — review before launch */
/* TM-01 Exposure — why the surface changed. A photograph of a team mapping a system inventory on a
   glass wall, carrying an illustrative inventory readout; a before/after strip of untrusted input
   classes; and four plain statements of new exposure, each with the control that answers it.
   Daylight, not a dark room: the argument here is "look at what you actually run", not fear. */
$tsce_rows = [   // [icon, title, text, control, tags]
    ['prompt', 'Prompts are input now',
        'Anything the model reads can carry instructions: a chat message, a PDF, a web page, an email signature. Input validation has to cover natural language, not just form fields.',
        'Input classifiers and content isolation', ['LLM01']],
    ['agent', 'Agents have write access',
        'An agent that can refund, email or edit records turns a manipulated sentence into an action. What the agent is allowed to do matters more than which model it runs.',
        'Tool allow-lists, scoped tokens, human approval', ['LLM06']],
    ['vector', 'Vector stores hold sensitive text',
        'Embeddings and retrieved chunks carry contracts, tickets and personal data, often without the permissions of the system they were copied from.',
        'Tenant filters enforced at retrieval', ['LLM08', 'LLM02']],
    ['eye', 'Shadow AI arrives by browser tab',
        'Teams paste customer data into unapproved assistants and extensions. What is not in the inventory cannot be assessed, approved or monitored.',
        'AI inventory, approved tools, DLP at the edge', ['ISO/IEC 42001']],
];
$tsce_classic = ['Form fields', 'API parameters', 'File uploads', 'Headers & cookies'];
$tsce_ai      = ['Prompts', 'Retrieved documents', 'Tool outputs', 'Model & dataset files', 'Agent actions'];
?>
<section class="band band--alt tsc-exposure" id="exposure" aria-labelledby="exposure-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tsc-ref"><b>TM-01</b><span>Exposure</span></p>
        <h2 class="h2" id="exposure-t"><span class="g">AI widened the attack surface.</span> Most controls were built for forms and APIs.</h2>
      </div>
      <div>
        <p class="lead">A language model reads text from customers, documents, web pages and other tools, and some of what it reads can act. Four new kinds of exposure now sit beside the ones your security programme already covers.</p>
      </div>
    </div>

    <div class="tsc-exposure__grid">
      <div class="tsc-exposure__media" data-rv>
        <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
        <figure class="bdh-img bdh-img--r43 tsc-exposure__img" data-bdh-in>
          <img src="<?= xe_url('assets/imgs/tech/cybersecurity-ai-trust/inventory-review-wall.jpg') ?>" alt="Five colleagues stand at a glass wall covered in sticky notes in a daylit office; one of them writes on a note while the others read the wall" width="1800" height="1200" loading="lazy" decoding="async" style="object-position:50% 42%">
          <span class="tsc-exposure__frame" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
          <span class="tsc-exposure__scan" aria-hidden="true"></span>
          <span class="bdh-cap-chip tsc-exposure__chip" aria-hidden="true"><b>AI inventory · illustrative</b>14 AI systems found · 5 not yet approved</span>
        </figure>
        <p class="bdh-sr">The photograph carries an illustrative AI inventory readout: fourteen AI systems found across the estate, five of them not yet approved. A scanning line sweeps the frame while the section is on screen.</p>

        <div class="tsc-surface" data-bdh-in>
          <p class="tsc-surface__k">Untrusted input and actions to control</p>
          <div class="tsc-surface__row">
            <span class="tsc-surface__lbl">Classic web app <b><?= count($tsce_classic) ?></b></span>
            <ul class="tsc-surface__chips" role="list">
              <?php foreach ($tsce_classic as $tsce_c): ?><li><?= e($tsce_c) ?></li><?php endforeach; ?>
            </ul>
          </div>
          <div class="tsc-surface__row is-ai">
            <span class="tsc-surface__lbl">With AI features <b><?= count($tsce_classic) + count($tsce_ai) ?></b></span>
            <ul class="tsc-surface__chips" role="list">
              <?php foreach ($tsce_classic as $tsce_c): ?><li class="is-old"><?= e($tsce_c) ?></li><?php endforeach; ?>
              <?php foreach ($tsce_ai as $tsce_i => $tsce_c): ?><li class="is-new" style="--i:<?= $tsce_i ?>"><?= e($tsce_c) ?></li><?php endforeach; ?>
            </ul>
          </div>
          <p class="bdh-sr">The two rows above compare the same product before and after AI features: four classes of untrusted input in a classic web application, and nine once a model is in the path &#8212; the original four plus prompts, retrieved documents, tool outputs, model and dataset files, and agent actions.</p>
        </div>
      </div>

      <ol class="tsc-exposure__rows" data-rv-s data-rv-step="90">
        <?php foreach ($tsce_rows as $tsce_i => $tsce_r): ?>
          <li class="tsc-exposure__row">
            <span class="tsc-exposure__ico"><?= xt_icon($tsce_r[0], ['size' => 24]) ?></span>
            <div class="tsc-exposure__txt">
              <p class="tsc-exposure__n">E<?= $tsce_i + 1 ?> <i>·</i> New exposure</p>
              <h3 class="tsc-exposure__t"><?= e($tsce_r[1]) ?></h3>
              <p class="tsc-exposure__d"><?= e($tsce_r[2]) ?></p>
              <p class="tsc-exposure__c"><span class="tsc-exposure__ck">Control</span><span><?= e($tsce_r[3]) ?></span><?php foreach ($tsce_r[4] as $tsce_t): ?><span class="tsc-kbd"><?= e($tsce_t) ?></span><?php endforeach; ?></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>
