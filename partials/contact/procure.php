<?php /* DRAFT COPY — review before launch */
/* Procure — the questions procurement, legal and security ask before a brief is allowed to become a
   conversation, answered in one place so nobody has to email for them. Six clauses in a document
   frame, then the tender panel. Nothing here claims a certificate: every framework is named as one
   delivery is built to, and every entity, insurance and policy detail is a PLACEHOLDER for counsel.
   PLACEHOLDER: confirm every line in this section with counsel and finance before launch. */
$ct_pc_rows = [
    ['lock', 'NDA before anything detailed',
     'We sign yours, or send ours, before the first call where anything confidential is discussed. Tick the NDA box in the brief and it happens without you chasing it.',
     ['Legal', 'Procurement'], 'Ask for', 'Mutual NDA, or your paper'],
    ['shield', 'Security questionnaires answered during scoping',
     'We complete your questionnaire while the scope is being written, not after a contract is signed. Where a control does not apply to the work, we say so rather than leaving a blank.',
     ['Security', 'IT'], 'Typical turnaround', 'Five working days'],
    ['database', 'Your data stays where you put it',
     'We work in your cloud accounts and your tools wherever the work allows. Where we must hold a copy, it is the smallest useful subset, masked where it can be, and deleted on a date agreed in writing.',
     ['Security', 'Data protection'], 'Regimes we build to', 'GDPR · India DPDP Act'],
    ['handshake', 'Supplier onboarding',
     'We complete supplier forms, portal registrations and vendor assessments as part of mobilisation. Tell us in the brief which portal you use and how long approval usually takes there.',
     ['Procurement'], 'We will need', 'Portal name, sponsor, lead time'],
    ['doc', 'Contracting and payment',
     'A statement of work names the deliverables, the acceptance criteria and the schedule. IP in what we make for you is assigned to you as it is created. Payment terms and milestones are set in that document.',
     ['Legal', 'Finance'], 'Read first', 'Commercial policy'],
    ['clipboard-check', 'Insurance, entity and tax details',
     'Registered entity, tax registrations and certificates of insurance are sent on request with the first proposal, so procurement is not waiting on them later.',
     ['Procurement', 'Finance'], 'Sent with', 'The first proposal'],
];
/* PLACEHOLDER: confirm the tender commitments and timings below before launch */
$ct_pc_tender = [
    ['What to send', 'The invitation, the evaluation criteria, the response format and the deadline.'],
    ['What we need to know', 'Whether clarification questions are allowed, and by when.'],
    ['What you get', 'A decision to bid or decline within three working days, so you are not left waiting.'],
    ['Who reads it', 'A discipline lead and whoever would run the engagement, not a bid team.'],
];
?>
<section class="band ct-procure" id="procurement" aria-labelledby="procurement-t">
  <div class="wrap bdh-grid ct-pc__grid">

    <div class="bdh-c4 ct-pc__side">
      <div class="bdh-sticky">
        <div class="bdh-head ct-pc__head" data-rv>
          <p class="lbl lbl--blue"><span class="dot"></span>For procurement, legal and security</p>
          <h2 class="h2" id="procurement-t"><span class="g">The answers</span> before you ask for them.</h2>
          <p class="lead">Six questions arrive with almost every enterprise brief. Here they are answered once, with what we will need from your side to move quickly.</p>
        </div>
        <ul class="ct-pc__links">
          <li><a class="tl" href="<?= xe_url('legal/commercial-policy.php') ?>">Commercial policy <span class="i" aria-hidden="true">›</span></a></li>
          <li><a class="tl" href="<?= xe_url('legal/security.php') ?>">Security <span class="i" aria-hidden="true">›</span></a></li>
          <li><a class="tl" href="<?= xe_url('legal/privacy.php') ?>">Privacy notice <span class="i" aria-hidden="true">›</span></a></li>
          <li><a class="tl" href="<?= xe_url('legal/responsible-ai.php') ?>">Responsible AI <span class="i" aria-hidden="true">›</span></a></li>
        </ul>
      </div>
    </div>

    <div class="bdh-c7 bdh-s6 ct-pc__doc" data-rv data-rv-d="60">
      <div class="ct-pc__bar">
        <span class="ct-pc__file">procurement.md <i>·</i> Your company × <?= e($SITE['company']['name']) ?></span>
        <span class="ct-pc__ver"><?= count($ct_pc_rows) ?> clauses</span>
      </div>
      <ol class="ct-pc__list">
        <?php foreach ($ct_pc_rows as $ct_i => $ct_c2): ?>
          <li class="ct-pc__row">
            <span class="ct-pc__ico" aria-hidden="true"><?= xt_icon($ct_c2[0], ['size' => 20]) ?></span>
            <div class="ct-pc__main">
              <p class="ct-pc__meta"><span class="ct-pc__sec">§<?= $ct_i + 1 ?></span><span class="ct-pc__who"><span class="bdh-sr">Usually asked by </span><?= e(implode(' · ', $ct_c2[3])) ?></span></p>
              <h3 class="ct-pc__t"><?= e($ct_c2[1]) ?></h3>
              <p class="ct-pc__d"><?= e($ct_c2[2]) ?></p>
              <p class="ct-pc__kv"><span><?= e($ct_c2[4]) ?></span><b><?= e($ct_c2[5]) ?></b></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
      <p class="ct-pc__foot">Building to ISO/IEC 27001, SOC 2, GDPR or the India DPDP Act describes how delivery is run. It is not a claim to hold a certificate — certificates come from independent auditors.</p>

      <div class="ct-tender">
        <div class="ct-tender__head">
          <span class="ct-tender__ico" aria-hidden="true"><?= xt_icon('flag', ['size' => 20]) ?></span>
          <div>
            <h3 class="ct-tender__t">Running a tender or an RFP?</h3>
            <p class="ct-tender__d">Attach the invitation to the brief above, or send it to <a href="mailto:<?= e($SITE['company']['email']) ?>"><?= e($SITE['company']['email']) ?></a>. We read it before we decide whether to bid, and we tell you either way.</p>
          </div>
        </div>
        <dl class="ct-tender__l">
          <?php foreach ($ct_pc_tender as $ct_t2): ?>
            <div><dt><?= e($ct_t2[0]) ?></dt><dd><?= e($ct_t2[1]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
      </div>
    </div>

  </div>
</section>
