<?php /* DRAFT COPY — review before launch */
/* Standards — the frameworks this discipline genuinely works to, as code-built badges (xt_badge; never
   official seal artwork). Only the nine named in data/marketing-technology.php appear, grouped into the
   four things they govern. Selecting a badge shows what it covers, how it shows up in delivery, and which
   capabilities apply it. Below: the consent-mode matrix, because on this page consent is not a policy
   paragraph but a set of signals that change what a tag may do; then the technical requirements that are
   not standards but are just as binding on deliverability and platform approval.
   Nothing here says Xterra Edze holds a certification. */
$std_groups = [
    ['privacy',  'Privacy & consent',          ['gdpr', 'dpdp', 'iso27701']],
    ['ai',       'AI governance & transparency', ['eu-ai-act', 'nist-ai-rmf', 'iso42001']],
    ['quality',  'Accessibility & experience',  ['wcag22', 'cwv']],
    ['payments', 'Payments',                    ['pci-dss']],
];
/* which capabilities apply each framework, straight from the capability data */
$std_caps = [];
foreach ($CAPS as $std_cs => $std_c) { foreach ($std_c['standards'] as $std_k) { $std_caps[$std_k][] = $std_cs; } }
$std_keys = [];
foreach ($std_groups as $std_g) { foreach ($std_g[2] as $std_k) { $std_keys[] = $std_k; } }
$std_first = 'dpdp';
$std_total = count($std_keys);

/* Google Consent Mode v2 signals and what each state permits. Vendor behaviour, correct at the time of writing. */
$std_signals = [
    ['analytics_storage',   'Analytics cookies set; full event and journey data.',            'Cookieless pings only; conversions modelled, no identifiers stored.'],
    ['ad_storage',          'Advertising cookies set; remarketing lists available.',           'No advertising cookies; no remarketing from this visit.'],
    ['ad_user_data',        'User data may be sent to ad platforms for measurement.',          'No user data sent to ad platforms.'],
    ['ad_personalization',  'Audience building and personalised advertising available.',       'No audience building and no personalised advertising.'],
];
/* the requirements that are not standards but decide whether a message arrives at all */
$std_tech = [
    ['Sender authentication',    'SPF, DKIM and DMARC on every sending domain, with a policy that moves past p=none, and BIMI where the brand qualifies.'],
    ['One-click unsubscribe',    'List-Unsubscribe and List-Unsubscribe-Post headers (RFC 8058) on commercial email, honoured within two days.'],
    ['Bulk sender requirements', 'Gmail and Yahoo require authenticated mail and a spam rate below 0.30%; we build to stay under 0.10%.'],
    ['WhatsApp Business rules',  'Template categories approved before use, opt-in recorded, and the 24-hour customer service window respected.'],
    ['Commercial SMS in India',  'Sender and template registration under TRAI’s commercial communication rules, with preferences honoured.'],
    ['AI content provenance',    'Content Credentials (C2PA) attached where the platform supports them, and AI disclosure applied where a market requires it.'],
];
?>
<section class="band mth-standards" id="standards" aria-labelledby="standards-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Standards &amp; frameworks</p>
        <h2 class="h2" id="standards-t"><span class="g">Frameworks</span> we build to.</h2>
      </div>
      <div>
        <p class="lead">Privacy and consent are the load-bearing frameworks of this discipline, so the work is built to them rather than reviewed against them afterwards. Every badge here is drawn in code by us; none is an official seal, and none of these is a certificate we hold. Where you need one, it comes from an independent auditor.</p>
      </div>
    </div>

    <div class="mth-std" data-std="<?= e($std_first) ?>" data-rv data-rv-d="60">
      <div class="mth-std__wall">
        <p class="bdh-sr">Choose a framework to see what it governs, how it shows up in delivery and which capabilities apply it. The details appear in the panel after the list.</p>
        <?php foreach ($std_groups as $std_gi => $std_g): ?>
          <div class="mth-std__group">
            <p class="mth-std__gh"><b><?= str_pad((string) ($std_gi + 1), 2, '0', STR_PAD_LEFT) ?></b><span><?= e($std_g[1]) ?></span><small><?= count($std_g[2]) ?> of <?= $std_total ?></small></p>
            <ul class="mth-std__list" role="list">
              <?php foreach ($std_g[2] as $std_k): $std_s = xt_standard($std_k); if (!$std_s) continue; $std_n = count($std_caps[$std_k] ?? []); ?>
                <li>
                  <button type="button" class="mth-std__b" data-std="<?= e($std_k) ?>" aria-pressed="<?= $std_k === $std_first ? 'true' : 'false' ?>" aria-controls="standards-panel">
                    <?= xt_badge($std_k) ?>
                    <span class="mth-std__bc"><b><?= $std_n ?></b> of <?= count($CAPS) ?> capabilities</span>
                  </button>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="mth-std__side">
        <div class="mth-std__panel bdh-sticky" id="standards-panel" aria-live="polite">
          <div class="bdh-panes mth-std__panes">
            <?php foreach ($std_keys as $std_k): $std_s = xt_standard($std_k); $std_on = $std_k === $std_first; ?>
              <div class="bdh-pane mth-std__pane<?= $std_on ? ' is-on' : '' ?>" data-std="<?= e($std_k) ?>">
                <p class="mth-k mth-std__pk"><?= e($std_s['kind']) ?> · <?= e($std_s['body']) ?></p>
                <h3 class="mth-std__pt"><?= e($std_s['code']) ?></h3>
                <p class="mth-std__pn"><?= e($std_s['name']) ?></p>
                <p class="mth-k">What it covers</p>
                <p class="mth-std__pc"><?= e($std_s['covers']) ?></p>
                <p class="mth-k">How it shows up in delivery</p>
                <p class="mth-std__pa"><?= e($std_s['apply']) ?></p>
                <p class="mth-k">Capabilities that apply it</p>
                <span class="mth-capls">
                  <?php foreach (($std_caps[$std_k] ?? []) as $std_cs): $std_c = $CAPS[$std_cs]; ?>
                    <a class="mth-capl" href="<?= e(($MTH['cap_href'])($std_cs)) ?>"><b><?= e($std_c['n']) ?></b><?= e($std_c['short']) ?><i aria-hidden="true">›</i></a>
                  <?php endforeach; ?>
                </span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <div class="mth-std__below">
      <div class="mth-std__consent" data-rv data-rv-d="40">
        <h3 class="mth-std__h3">Consent, as the tags actually see it</h3>
        <p class="mth-std__sub">Consent Mode does not decide whether a tag fires. It tells the tag what it may do, per signal, on that visit. The decision still belongs to your notice and your record.</p>
        <div class="bdh-scroll-x mth-std__scroll" tabindex="0" role="group" aria-label="Consent signals and what each state permits, scroll sideways to see both states">
          <table class="mth-std__table">
            <thead>
              <tr>
                <th scope="col">Signal</th>
                <th scope="col"><span class="mth-flag mth-flag--on">Granted</span></th>
                <th scope="col"><span class="mth-flag mth-flag--off">Denied</span></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($std_signals as $std_sg): ?>
                <tr>
                  <th scope="row"><code><?= e($std_sg[0]) ?></code></th>
                  <td><?= e($std_sg[1]) ?></td>
                  <td><?= e($std_sg[2]) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <p class="mth-note">Modelled conversions fill part of the gap denial leaves, and geo experiments and mix modelling do not depend on individual tracking at all. That is why <a class="mth-std__jump" href="#ai-campaign-optimization">AI Campaign Optimization</a> calibrates models with experiments rather than trusting platform-reported credit.</p>
      </div>

      <div class="mth-std__tech" data-rv data-rv-d="70">
        <h3 class="mth-std__h3">Also binding, and not a standard</h3>
        <p class="mth-std__sub">These are platform and mailbox-provider requirements. Miss one and the work never reaches anybody, whatever the campaign was worth.</p>
        <dl class="mth-std__techl">
          <?php foreach ($std_tech as $std_t): ?>
            <div><dt><?= e($std_t[0]) ?></dt><dd><?= e($std_t[1]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
        <p class="mth-note">No one can promise inbox placement, because mailbox providers decide it. What we can build is every condition they publish, and monitoring that tells you the day it slips.</p>
      </div>
    </div>
  </div>
</section>
