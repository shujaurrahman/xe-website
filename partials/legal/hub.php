<?php /* DRAFT COPY — review before launch */ ?>
<?php /* Legal hub body: the register + company particulars. All particulars are PLACEHOLDER until counsel supplies them. */
$lgl_latest = max(array_column($LGL_POLICIES, 'iso'));
$lgl_latest_h = '';
foreach ($LGL_POLICIES as $lgl_p) if ($lgl_p['iso'] === $lgl_latest) $lgl_latest_h = $lgl_p['updated'];
?>
<!-- PLACEHOLDER: legal review by qualified counsel before launch -->
<main id="main" class="bdh lgl lgl--hub">

<section class="band lgl-hubhero" aria-labelledby="lgl-h1">
  <div class="wrap lgl-hubhero__g">
    <div>
      <p class="lbl lbl--blue"><span class="dot"></span>Legal</p>
      <h1 class="d2 lgl-h1" id="lgl-h1"><span class="g">The fine print,</span> written to be read.</h1>
      <p class="lead lgl-lead">Every policy that governs this website and our work, in one register. Each opens with a short summary, and each says when it last changed.</p>
      <p class="lgl-draft"><span class="lgl-draft__dot" aria-hidden="true"></span>Draft — under legal review. These documents may change before they take effect.</p>
    </div>
    <div class="lgl-hubhero__stat">
      <div><b><?= count($LGL_POLICIES) ?></b><span>Documents</span></div>
      <div><b>0</b><span>Tracking cookies</span></div>
      <div><b><?= e(date('j M', strtotime($lgl_latest))) ?></b><span>Last change</span></div>
    </div>
  </div>
</section>

<section class="band band--tight lgl-register" aria-labelledby="lgl-reg-t">
  <div class="wrap">
    <h2 class="sr" id="lgl-reg-t">The register of policies</h2>
    <ol class="lgl-reg">
      <?php $lgl_n = 0; foreach ($LGL_POLICIES as $lgl_k => $lgl_p): $lgl_n++; ?>
        <li class="lgl-reg__r">
          <span class="lgl-reg__i"><?= sprintf('%02d', $lgl_n) ?></span>
          <h3 class="lgl-reg__t"><a href="<?= e(lgl_url($lgl_k)) ?>"><?= e($lgl_p['title']) ?></a></h3>
          <p class="lgl-reg__d"><?= e($lgl_p['sum']) ?></p>
          <p class="lgl-reg__m"><b>v<?= e($lgl_p['version']) ?> · draft</b><time datetime="<?= e($lgl_p['iso']) ?>"><?= e($lgl_p['updated']) ?></time></p>
          <span class="lgl-reg__go" aria-hidden="true"><svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8h10M9 4l4 4-4 4"/></svg></span>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<section class="band band--alt lgl-company" id="company" aria-labelledby="lgl-co-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div><p class="lbl lbl--blue"><span class="dot"></span>Company information</p>
        <h2 class="h2" id="lgl-co-t"><span class="g">Who you are dealing with.</span> The legal particulars.</h2></div>
      <div><p class="lead">Xterra Edze is an Indian company with offices in New Delhi and Ludhiana. These are the details that appear on our contracts and tax invoices.</p></div>
    </div>
    <div class="lgl-co">
      <div class="lgl-co__card">
        <h3>The company</h3>
        <!-- PLACEHOLDER: entity name, CIN, GSTIN, registered office and trademark details — confirm against registration documents before launch. -->
        <dl class="lgl-dl">
          <dt>Legal entity</dt><dd><span class="lgl-ph"><?= e($LGL_CO['entity']) ?></span></dd>
          <dt>Trading as</dt><dd>Xterra Edze®</dd>
          <dt>CIN</dt><dd><span class="lgl-ph"><?= e($LGL_CO['cin']) ?></span></dd>
          <dt>GSTIN</dt><dd><span class="lgl-ph"><?= e($LGL_CO['gstin']) ?></span></dd>
          <dt>Registered office</dt><dd><span class="lgl-ph"><?= e($LGL_CO['office']) ?></span></dd>
          <?php foreach ($SITE['company']['studios'] as $lgl_s): ?>
            <dt><?= e($lgl_s['city']) ?> office</dt><dd><?= e(implode(', ', array_merge($lgl_s['units'], $lgl_s['lines']))) ?></dd>
          <?php endforeach; ?>
          <?php foreach ($LGL_CO['tm'] as $lgl_tm): ?>
            <dt>Trademark</dt><dd>XTERRA EDZE · <span class="lgl-ph"><?= e($lgl_tm[0]) ?></span> · <?= e($lgl_tm[1]) ?></dd>
          <?php endforeach; ?>
        </dl>
      </div>
      <div class="lgl-co__card lgl-co__card--ink">
        <h3>Grievance Officer</h3>
        <p class="p">For complaints about personal data or content on this site, as the DPDP Act 2023 and the IT Rules 2021 require.</p>
        <dl class="lgl-dl">
          <dt>Name</dt><dd><span class="lgl-ph"><?= e($LGL_CO['go_name']) ?></span></dd>
          <dt>Email</dt><dd><a href="<?= e(lgl_mail('Grievance')) ?>"><?= e($LGL_CO['go_mail']) ?></a></dd>
          <dt>Post</dt><dd><span class="lgl-ph"><?= e($LGL_CO['office']) ?></span></dd>
          <!-- PLACEHOLDER: response times — confirm against the DPDP Rules and IT Rules before launch. -->
          <dt>Response</dt><dd>Acknowledged within <span class="lgl-ph">[24 hours]</span>; resolved within <span class="lgl-ph">[15 days]</span></dd>
        </dl>
        <p class="lgl-co__note">Security issues go to the <a href="<?= e(lgl_url('security')) ?>">disclosure policy</a> instead.</p>
      </div>
    </div>
  </div>
</section>
</main>
