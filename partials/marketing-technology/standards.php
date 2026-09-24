<?php /* DRAFT COPY — review before launch */
/* Standards: the frameworks this work is built to (never a claim of certification), and the consent record that
   makes the privacy ones real. PCI DSS applies only where the sales work touches card payments. */
$mth_sd_keys = ['dpdp', 'gdpr', 'iso27701', 'iso42001', 'nist-ai-rmf', 'eu-ai-act', 'wcag22', 'pci-dss'];
$mth_sd_mail = ['SPF', 'DKIM', 'DMARC', 'BIMI', 'RFC 8058 one-click unsubscribe', 'WhatsApp template opt-in'];
?>
<section class="band mth-std" id="standards" aria-labelledby="standards-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Frameworks we build to</p>
        <h2 class="h2" id="standards-t"><span class="g">Privacy is a data model.</span> Compliance follows from it.</h2>
      </div>
      <div><p class="lead">We design and document delivery against these frameworks so your own compliance and audit work has something solid to stand on. They are frameworks we build to, not certifications we hold.</p></div>
    </div>

    <div class="mth-std__wrap">
      <ul class="mth-std__badges">
        <?php foreach ($mth_sd_keys as $mth_sd_k): ?>
        <?= xt_badge($mth_sd_k, ['tag' => 'li', 'variant' => 'seal']) ?>
        <?php endforeach; ?>
      </ul>
      <p class="mth-std__scope">PCI DSS applies only where quoting and payment flows touch card data. ISO/IEC 42001, the NIST AI RMF and the EU AI Act shape how decisioning and generative models are documented, tested and overseen.</p>

      <div class="mth-std__rec">
        <div class="mth-std__recui" aria-hidden="true">
          <p class="mth-std__bar"><span class="bdh-pulse"></span>consent_record · profile A-1042</p>
<pre class="mth-std__pre bdh-ro"><span class="k">purpose</span>       marketing.lifecycle
<span class="k">channel</span>       whatsapp
<span class="k">notice</span>        v7 · en-IN · shown 12 Mar 10:14
<span class="k">action</span>        checkbox, unticked by default
<span class="k">source</span>        checkout · web
<span class="k">given_at</span>      2026-03-12T10:14:22+05:30
<span class="k">withdrawn_at</span>  <span class="n">null</span>
<span class="k">enforced</span>      at every send</pre>
        </div>
        <p class="bdh-sr">An illustrative consent record for one profile: purpose, channel, notice version and language, how consent was given, where, when, whether it has been withdrawn, and that it is enforced at every send.</p>
        <ul class="mth-std__rules">
          <li><b>Specific.</b> One record per purpose and channel, never one blanket yes.</li>
          <li><b>Provable.</b> The notice version, the action and the time are stored with it.</li>
          <li><b>Reversible.</b> Withdrawal is as easy as giving consent and takes effect at the next send.</li>
          <li><b>Enforced late.</b> Checked when a message is about to go, not when a list was built.</li>
        </ul>
      </div>

      <div class="mth-std__mail">
        <p class="mth-std__k">Sender standards set up in every build</p>
        <ul class="mth-std__chips"><?php foreach ($mth_sd_mail as $mth_sd_m): ?><li class="mth-chip mth-chip--ok"><?= e($mth_sd_m) ?></li><?php endforeach; ?></ul>
      </div>
    </div>
  </div>
</section>
