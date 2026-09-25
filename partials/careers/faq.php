<?php /* DRAFT COPY — review before launch */
/* Careers FAQ — the questions candidates actually send us, in two groups: before you apply, and
   once you are in the process. Built on the core [data-acc] accordion (assets/js/core.js), so it
   needs no script of its own; the <noscript> rule leaves every answer open and hides the plus
   marks, which is the finished readable state. A FAQPage block is emitted from the same array, so
   the structured data can never drift from the copy. Locals prefixed fq_. */
$fq_groups = [
    ['Before you apply', [
        ['I do not match every requirement. Should I apply?',
         'Yes. The requirement list is what the role needs eighteen months in, not what you need on day one. If you meet most of the "You bring" list and the work in your portfolio is close, apply and say in your note which parts you have not done yet. Naming a gap has never cost anybody an interview here.'],
        ['Do you publish pay ranges?',
         'Not on the listing yet, and we would rather say so than pretend. The hiring lead states the range for the role on the first call without being asked, before you spend time on a craft conversation, and we neither ask what you currently earn nor use it to set an offer.',
         'whether pay ranges will be published on listings before launch'],
        ['Can I apply for more than one role?',
         'Apply for the closest one and name the second in your note — there is a field for it on the form. One considered application reaches a person faster than three copies of the same thing, and applying widely is not read as enthusiasm.'],
        ['What if nothing listed fits?',
         'Send a general application. It goes to the same inbox and is read by the same people. We have shaped roles around people before, and the strongest general applications are the ones that say clearly what you want to spend your time on rather than listing everything you can do.'],
        ['Do you hire graduates and interns?',
         'Yes, into internships with a mentor, a learning plan and work that ships. Internships are paid. When an internship is open it is listed above with the rest, under its practice.',
         'that all internships are paid, before launch'],
        ['Do you hire outside India?',
         'Not yet. Every role listed is based in New Delhi, in Ludhiana or remote within India, because those are the places we can currently employ people properly. If that changes we will list it rather than leave it vague.',
         'the employing entities and any plan to hire outside India, before launch'],
    ]],
    ['Once you have applied', [
        ['Will an AI read my application?',
         'A person reads every application, and no model scores, ranks or rejects candidates here. We do use AI in the parts of hiring that are administrative — scheduling, and transcribing a call when everyone on it has agreed — and a person can always ask for the transcript or for it not to be made.',
         'the hiring-side AI tooling and consent wording, before launch'],
        ['Is the work sample paid?',
         'Yes, at a fair hourly rate for the level you are applying at, and it is capped at about three hours. If a paid exercise does not suit you, bring existing work instead and we will review that. Choosing that route does not put you at a disadvantage.',
         'the work-sample fee and cap before launch'],
        ['How long will it take, and will I hear back?',
         'We work to five working days for a first answer and about four weeks from application to offer. You hear something after every stage, including when the answer is no, and a no has a reason in it. If a target passes and you have heard nothing, that is our mistake — write in and we will answer the same week.',
         'the reply targets before launch'],
        ['What happens to my CV and my details?',
         'They arrive as an email to the hiring inbox. Nothing is stored on this website — there is no database and no file store behind the form. The application is read by the practice lead and, at offer stage, by a founder. Ask us to delete it at any point and we will.',
         'the hiring inbox, the retention period and who may read applications, before launch'],
        ['Can I reapply after a no?',
         'Yes, and people do. There is no waiting period and no mark on a record, because there is no record. If the no was about a specific gap, the reason we sent you is the thing to answer next time.'],
        ['Can I ask for feedback?',
         'Ask, and you will get it in writing — specific to the stage you reached. We keep it short and honest rather than kind and useless, which is what candidates tell us they want and occasionally regret asking for.'],
    ]],
];
$fq_ld = ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => []];
foreach ($fq_groups as $fq_g) foreach ($fq_g[1] as $fq_q) {
    $fq_ld['mainEntity'][] = ['@type' => 'Question', 'name' => $fq_q[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $fq_q[1]]];
}
$fq_n = 0;
?>
<noscript><style>.car-faq__p{height:auto;overflow:visible}.car-faq__plus{display:none}</style></noscript>
<section class="band band--alt car-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
        <h2 class="h2" id="faq-t"><span class="g">Twelve questions</span> candidates actually send us.</h2></div>
      <div><p class="lead">Answered the way we would answer them on a call. If yours is not here, write to <a class="tl" href="mailto:<?= e($SITE['company']['email']) ?>?subject=<?= e(rawurlencode('A question about a role')) ?>"><?= e($SITE['company']['email']) ?></a> — a question is not a worse first contact than an application.</p></div>
    </div>

    <div class="car-faq__cols">
      <?php foreach ($fq_groups as $fq_gi => $fq_g): ?>
      <div class="car-faq__col">
        <h3 class="car-faq__gt"><span class="car-faq__gn"><?= str_pad((string) ($fq_gi + 1), 2, '0', STR_PAD_LEFT) ?></span><?= e($fq_g[0]) ?></h3>
        <div class="car-faq__list" data-acc>
          <?php foreach ($fq_g[1] as $fq_q): $fq_n++; $fq_open = $fq_n === 1; ?>
            <?php if (!empty($fq_q[2])): ?><!-- PLACEHOLDER: confirm <?= e($fq_q[2]) ?> --><?php endif; ?>
            <div class="car-faq__row">
              <h4 class="car-faq__hq">
                <button class="car-faq__q" type="button" data-acc-b aria-expanded="<?= $fq_open ? 'true' : 'false' ?>" aria-controls="car-faq-a<?= $fq_n ?>" id="car-faq-q<?= $fq_n ?>">
                  <span class="car-faq__t"><?= e($fq_q[0]) ?></span>
                  <span class="car-faq__plus" aria-hidden="true"></span>
                </button>
              </h4>
              <div class="car-faq__p<?= $fq_open ? ' is-open' : '' ?>" id="car-faq-a<?= $fq_n ?>" role="region" aria-labelledby="car-faq-q<?= $fq_n ?>" data-acc-p>
                <p class="car-faq__a"><?= e($fq_q[1]) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<script type="application/ld+json"><?= json_encode($fq_ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
