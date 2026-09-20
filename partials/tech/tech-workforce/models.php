<?php /* DRAFT COPY — review before launch */
/* Models — four ways to add capacity, laid out as a scale from one person to a team you own.
   Each card carries the commercial facts an engineering leader asks first: who directs the work,
   minimum term, notice and the replacement commitment. Commercial terms are PLACEHOLDER. */
$ttw_md = [
    ['01', 'users', 'Individual specialists', 'One engineer', 'A single vetted engineer joins an existing team of yours and works in your rituals. Used to close a named skill gap — a Go backend engineer, an ML engineer, an SDET — without changing how the team runs.',
        [['Direction', 'Your team lead'], ['Minimum term', '3 months'], ['Notice', '30 days'], ['Replacement', 'Within 10 working days']],
        ['Skill gap', 'Fastest start']],
    ['02', 'puzzle', 'Pods', 'Two to four engineers', 'A small group covering one area end to end — a mobile pod, a data pod, a test-automation pod. They share a backlog slice and one point of contact, and review each other before anything reaches your team.',
        [['Direction', 'Your team lead, with our tech lead on quality'], ['Minimum term', '3 months'], ['Notice', '30 days'], ['Replacement', 'Within 10 working days']],
        ['One skill area', 'Self-reviewing']],
    ['03', 'layers', 'Delivery squads', 'Cross-functional, with a lead', 'A complete squad — tech lead, engineers, QA, design and a delivery manager — accountable for an outcome on your roadmap rather than for hours. Sprint reporting, DORA metrics and a monthly service review come with it.',
        [['Direction', 'Our delivery manager, to goals you set'], ['Minimum term', '6 months'], ['Notice', '60 days'], ['Replacement', 'Within 10 working days']],
        ['Outcome-owned', 'Reported every sprint']],
    ['04', 'handshake', 'Build–operate–transfer', 'A team that becomes yours', 'We recruit, vet and run the team, then transfer it to your entity: people, documentation, tooling and ways of working. Conversion terms are agreed in the contract at the start, so the handover is a plan rather than a negotiation.',
        [['Direction', 'Ours, then yours'], ['Minimum term', '12 months'], ['Notice', '90 days'], ['Transfer', 'Agreed up front']],
        ['You own the team', 'No conversion dispute']],
];
?>
<section class="band band--alt ttw-models" id="models" aria-labelledby="models-t">
  <div class="wrap">

    <header class="ttw-head ttw-head--wide" data-rv>
      <div class="ttw-head__t">
        <p class="lbl lbl--blue"><span class="dot"></span>Engagement models</p>
        <h2 class="h2" id="models-t"><span class="g">Four ways to add capacity,</span> from one engineer to a team you own.</h2>
      </div>
      <div class="ttw-head__l">
        <p class="lead">The models differ in who directs the work and how much of the delivery risk sits with us. Everything else — vetting, onboarding, security practice and reporting — is the same in all four.</p>
      </div>
    </header>

    <div class="ttw-models__scale" data-bdh-in data-ttw-arm aria-hidden="true">
      <span class="ttw-models__line"><i></i></span>
      <p class="ttw-models__ends"><span>One engineer in your team</span><span>A team you own</span></p>
    </div>

    <ol class="ttw-models__list" data-bdh-stagger>
      <?php foreach ($ttw_md as $ttw_m): ?>
        <li class="ttw-models__it" data-rv data-rv-s>
          <article class="ttw-card ttw-models__c">
            <p class="ttw-models__n"><span class="ttw-models__ix"><?= e($ttw_m[0]) ?></span><span class="ttw-models__ico"><?= xt_icon($ttw_m[1], ['size' => 22]) ?></span></p>
            <h3 class="bdh-t ttw-models__h"><?= e($ttw_m[2]) ?></h3>
            <p class="ttw-models__sz"><?= e($ttw_m[3]) ?></p>
            <p class="bdh-d ttw-models__d"><?= e($ttw_m[4]) ?></p>
            <!-- PLACEHOLDER: confirm minimum terms, notice periods and the replacement window before launch -->
            <dl class="ttw-models__facts">
              <?php foreach ($ttw_m[5] as $ttw_f): ?>
                <div><dt><?= e($ttw_f[0]) ?></dt><dd><?= e($ttw_f[1]) ?></dd></div>
              <?php endforeach; ?>
            </dl>
            <ul class="ttw-models__tags" role="list">
              <?php foreach ($ttw_m[6] as $ttw_t): ?><li><span class="bdh-tag"><?= e($ttw_t) ?></span></li><?php endforeach; ?>
            </ul>
          </article>
        </li>
      <?php endforeach; ?>
    </ol>

    <p class="ttw-models__note"><span class="ttw-ill">Illustrative</span> Terms above are typical ranges and are set per engagement. <a class="tl" href="<?= xe_url('contact.php') ?>?from=tech-workforce">Tell us the shape you need <span class="i" aria-hidden="true">›</span></a></p>

  </div>
</section>
