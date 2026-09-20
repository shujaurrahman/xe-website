<?php /* DRAFT COPY — review before launch */
/* Security — the access, IP and confidentiality terms settled before anyone starts, with the
   frameworks our practices are aligned with. No certification is claimed: the badges are
   code-built and worded as alignment. */
$ttw_sc_items = [
    ['doc', 'NDA and IP assignment, signed first', 'Every engineer signs a mutual NDA and an IP assignment naming your entity, before they are introduced to you. Work product is yours from the first commit, not on final payment.'],
    ['fingerprint', 'Background verification', 'Identity, education and previous employment verified before an offer, at the level your policy requires. Results are held for the engagement and available for your audit.'],
    ['key', 'Least privilege through your SSO', 'Accounts are issued in your identity provider, scoped to the repositories and environments the role needs, with your MFA and conditional-access rules applied. We ask for production access only where the role genuinely requires it.'],
    ['shield', 'Managed devices, encrypted disks', 'Company-managed laptops with full-disk encryption, screen lock, patching and endpoint protection enforced by policy. No personal machines on client work, and no client data on removable media.'],
    ['rollback', 'Offboarding within 24 hours', 'Access is revoked across your systems and ours within one working day of an engineer leaving the account, with a written confirmation of what was revoked and when.'],
    ['log', 'Data handling agreed in writing', 'Which categories of your data an engineer may touch, where it may be copied, and whether production data may appear in a test environment — decided at contract stage, not during an incident.'],
];
$ttw_sc_badges = ['iso27001', 'soc2', 'gdpr', 'dpdp'];
?>
<section class="band ttw-sec" id="security" aria-labelledby="security-t">
  <div class="wrap">

    <header class="ttw-head ttw-head--wide" data-rv>
      <div class="ttw-head__t">
        <p class="lbl lbl--blue"><span class="dot"></span>Access, IP and confidentiality</p>
        <h2 class="h2" id="security-t"><span class="g">Settled up front,</span> not after the first incident.</h2>
      </div>
      <div class="ttw-head__l">
        <p class="lead">Adding people to your systems is a security change. These are the controls that come with every engineer, written into the contract so your security team reviews them once rather than case by case.</p>
      </div>
    </header>

    <div class="ttw-sec__grid">

      <ol class="ttw-sec__list" data-bdh-in data-ttw-arm role="list">
        <?php foreach ($ttw_sc_items as $ttw_sc_i => $ttw_sc_it): ?>
          <li class="ttw-sec__it" style="--i:<?= (int) $ttw_sc_i ?>">
            <span class="ttw-tick ttw-sec__tk" aria-hidden="true"><svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 6.4 4.6 9 10 3"/></svg></span>
            <span class="ttw-sec__ic"><?= xt_icon($ttw_sc_it[0], ['size' => 20]) ?></span>
            <span class="ttw-sec__tx">
              <b class="ttw-sec__h"><?= e($ttw_sc_it[1]) ?></b>
              <span class="ttw-sec__d"><?= e($ttw_sc_it[2]) ?></span>
            </span>
          </li>
        <?php endforeach; ?>
      </ol>

      <aside class="ttw-sec__side">
        <div class="ttw-card ttw-sec__card">
          <h3 class="bdh-t">Frameworks we align delivery with</h3>
          <p class="bdh-d">Our practices are built to these frameworks, and we will answer a security questionnaire against them. That is alignment, not certification.</p>
          <!-- PLACEHOLDER: confirm whether Xterra Edze holds any of these certifications before launch; until then the wording stays "aligned practices" -->
          <ul class="xt-badges ttw-sec__badges" role="list">
            <?php foreach ($ttw_sc_badges as $ttw_sc_b): ?>
              <?= xt_badge($ttw_sc_b, ['tag' => 'li', 'detail' => true]) ?>
            <?php endforeach; ?>
          </ul>
          <p class="ttw-sec__fine">Where you hold a certification of your own, we work inside your control set and evidence our part of it. Your auditors may speak to the delivery manager directly.</p>
        </div>

        <div class="ttw-card ttw-sec__card ttw-sec__card--q">
          <h3 class="bdh-t">Questions your security team will ask</h3>
          <dl class="ttw-sec__qa">
            <div><dt>Where does the code live?</dt><dd>In your repositories. We do not keep a private mirror, and local clones sit on managed, encrypted devices.</dd></div>
            <div><dt>Can engineers use AI assistants?</dt><dd>Only the ones your policy approves, configured against your organisation accounts, with your code excluded from public model training.</dd></div>
            <div><dt>Who else can see our data?</dt><dd>Only the named people on your account and, where you agree it, a delivery manager. Access lists are shared with you and reviewed monthly.</dd></div>
          </dl>
        </div>
      </aside>

    </div>

  </div>
</section>
