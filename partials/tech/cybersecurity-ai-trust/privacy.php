<?php /* DRAFT COPY — review before launch */
/* TM-08 Privacy — personal data mapped from the form it is typed into to the day it is erased. Left:
   the photograph and the legal framing (DPDP, GDPR, ISO/IEC 27701). Right: a four-stage flow with the
   checkpoint and the retention rule at each stage. Below: an erasure console that propagates one data
   principal's request across every system holding the record. privacy.js runs the propagation. */

/* [key, stage, icon, what happens, the checkpoint, the retention rule] */
$tscp_flow = [
    ['collect', 'Collect', 'doc',
        'Sign-up, checkout and support forms capture only the fields a stated purpose actually needs. Optional fields are marked optional and behave that way.',
        'Notice and consent recorded with purpose, timestamp, version and the language it was shown in.',
        'Consent record kept for as long as processing continues, then archived as proof.'],
    ['store', 'Store', 'database',
        'Personal data lands in one system of record. Every other system holds a reference or a minimised copy, never a second master.',
        'Encrypted at rest, identifiers tokenised, access scoped by tenant and role, production data never copied into test.',
        'Live for as long as the relationship lasts, then the category timer takes over.'],
    ['process', 'Process & share', 'sync',
        'Analytics, support tooling and AI features read a minimised copy. Prompts and vector indexes carry the least data that still answers the question.',
        'Processor contracts and sub-processor register, a purpose tag on every pipeline, personal data masked before it reaches a model.',
        'Derived copies expire with the pipeline that created them; nothing outlives its purpose by default.'],
    ['erase', 'Retain & erase', 'rollback',
        'Retention timers run per data category. Erasure starts at the system of record and propagates outwards until every copy is accounted for.',
        'A deletion receipt per system, and backups erased on the next rotation rather than quietly skipped.',
        'Purge on schedule. The evidence that the purge happened is what we keep.'],
];

/* [system, role, what the request does there, readout] */
$tscp_sys = [
    ['Product database', 'System of record', 'Record and its derived rows removed inside the transaction.', '1.2 s'],
    ['Data warehouse',   'Analytics',        'Row deleted, downstream models rebuilt on the next scheduled run.', '18 s'],
    ['CRM',              'Sales & support',  'Contact, notes and ticket history removed through the vendor API.', '4.6 s'],
    ['Email platform',   'Lifecycle email',  'Profile and event history purged; a one-way hash stays on the suppression list.', '9.1 s'],
    ['Vector index',     'AI retrieval',     'Embeddings and source chunks dropped, then the index is compacted.', '31 s'],
    ['Object storage',   'Attachments',      'Uploaded files, thumbnails and signed-URL logs deleted.', '6.3 s'],
    ['Backups',          'Disaster recovery','Queued against the next rotation and erased within the retention window.', 'queued'],
];

/* The backup row is queued against the next rotation, not erased today: count it separately so the
   readout and the list say the same thing. */
$tscp_queued = 0;
foreach ($tscp_sys as $tscp_s) { if ($tscp_s[3] === 'queued') $tscp_queued++; }
$tscp_erased = count($tscp_sys) - $tscp_queued;
?>
<section class="band tsc-privacy" id="privacy" aria-labelledby="privacy-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tsc-ref"><b>TM-08</b><span>Personal data</span></p>
        <h2 class="h2" id="privacy-t"><span class="g">Privacy by design,</span> under the DPDP Act and the GDPR.</h2>
      </div>
      <div>
        <p class="lead">Privacy stops being a policy document the moment someone asks you to delete their data and you have to find every copy. We map the journey first, put a checkpoint at each stage, and make erasure something the system does rather than something a person remembers.</p>
      </div>
    </div>

    <div class="tsc-pv">
      <aside class="tsc-pv__side" data-rv>
        <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
        <figure class="bdh-img bdh-img--r45 tsc-pv__img" data-bdh-in>
          <img src="<?= xe_url('assets/imgs/tech/cybersecurity-ai-trust/hands-phone-form.jpg') ?>" alt="A person holding a phone in both hands, entering details into an on-screen form" width="1800" height="1200" loading="lazy" decoding="async" style="object-position:50% 45%">
          <span class="tsc-pv__frame" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
          <figcaption class="bdh-cap-chip tsc-pv__cap"><b>Point of collection</b>Where the promise is made</figcaption>
        </figure>

        <div class="tsc-pv__law">
          <h3 class="tsc-pv__lt">What the law asks of you</h3>
          <ul class="bdh-bullets tsc-pv__ll" role="list">
            <li><b>DPDP Act 2023.</b> Clear notice and consent in the language the person chooses, purpose limitation, reasonable security safeguards, intimation to the Data Protection Board and to affected people after a breach, and a route for access, correction, erasure and grievance. Significant data fiduciaries carry added duties, including a Data Protection Officer in India, independent audit and impact assessment.</li>
            <li><b>GDPR.</b> Applies wherever EU personal data is processed: lawful basis, data protection by design and by default, processor contracts under Article 28, a DPIA for high-risk processing, and a 72-hour breach notification clock.</li>
            <li><b>AI-specific.</b> Personal data used for training, fine-tuning or retrieval needs its own basis, its own retention rule and its own way out of the index.</li>
          </ul>
          <ul class="xt-badges tsc-pv__badges" role="list">
            <?php foreach (['dpdp', 'gdpr', 'iso27701'] as $tscp_b): ?><?= xt_badge($tscp_b, ['tag' => 'li', 'variant' => 'chip']) ?><?php endforeach; ?>
          </ul>
          <p class="tsc-pv__dis">General information about obligations, not legal advice. We work alongside your counsel and your Data Protection Officer.</p>
        </div>
      </aside>

      <div class="tsc-pv__main">
        <ol class="tsc-pv__flow" data-rv-s data-rv-step="90" aria-label="How personal data moves through the systems we build">
          <?php foreach ($tscp_flow as $tscp_i => $tscp_f): ?>
            <li class="tsc-pv__st" style="--i:<?= $tscp_i ?>">
              <div class="tsc-pv__sth">
                <span class="tsc-pv__sico" aria-hidden="true"><?= xt_icon($tscp_f[2], ['size' => 20]) ?></span>
                <p class="tsc-pv__sn tsc-mono"><?= str_pad((string) ($tscp_i + 1), 2, '0', STR_PAD_LEFT) ?></p>
                <h3 class="tsc-pv__st3"><?= e($tscp_f[1]) ?></h3>
              </div>
              <p class="tsc-pv__sw"><?= e($tscp_f[3]) ?></p>
              <dl class="tsc-pv__sd">
                <div><dt>Checkpoint</dt><dd><?= e($tscp_f[4]) ?></dd></div>
                <div><dt>Retention</dt><dd><?= e($tscp_f[5]) ?></dd></div>
              </dl>
              <span class="tsc-pv__wire" aria-hidden="true"><i></i></span>
            </li>
          <?php endforeach; ?>
        </ol>

      </div>
    </div>

    <div class="tsc-pv__console bdh-ui" data-pv data-rv>
      <div class="bdh-ui__bar tsc-pv__bar">
        <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="tsc-pv__bt">Erasure request · DSR-2418</span>
        <span class="tsc-pv__bs tsc-mono" data-pv-state>Closed &#183; receipt issued</span>
      </div>
      <div class="tsc-pv__cbody">
        <div class="tsc-pv__ctop">
          <div>
            <h3 class="tsc-pv__ct">One request, every copy</h3>
            <p class="tsc-pv__cw">A data principal asks for their record to be erased. The request is verified once, then fans out to every system that holds a copy. Nothing relies on someone remembering the seventh system.</p>
          </div>
          <div class="tsc-pv__cctl">
            <button type="button" class="tsc-btn tsc-btn--pri" data-pv-run data-pv-label="Run the request again">Run the request again</button>
            <p class="tsc-pv__cn tsc-mono"><b data-pv-done><?= $tscp_erased ?></b> / <?= $tscp_erased ?> erased <i>&#183;</i> <?= $tscp_queued ?> queued for the next backup rotation</p>
          </div>
        </div>
        <ol class="tsc-pv__sys" aria-label="Systems the erasure request reaches">
          <?php foreach ($tscp_sys as $tscp_i => $tscp_s): ?>
            <li class="tsc-pv__row is-done<?= $tscp_i === count($tscp_sys) - 1 ? ' is-queued' : '' ?>" style="--i:<?= $tscp_i ?>">
              <span class="tsc-tick tsc-pv__tick" aria-hidden="true"></span>
              <p class="tsc-pv__rn"><?= e($tscp_s[0]) ?><span><?= e($tscp_s[1]) ?></span></p>
              <p class="tsc-pv__rw"><?= e($tscp_s[2]) ?></p>
              <p class="tsc-pv__rt tsc-mono"><?= e($tscp_s[3]) ?></p>
            </li>
          <?php endforeach; ?>
        </ol>
        <p class="tsc-pv__live bdh-sr" role="status" aria-live="polite" data-pv-live></p>
        <p class="tsc-pv__cfoot">
          <span class="tsc-ill">Illustrative</span>
          <span>Timings are from a reference implementation. The receipt, the system list and the backup rotation window are what an auditor or a regulator asks to see.</span>
        </p>
      </div>
    </div>
  </div>
</section>
