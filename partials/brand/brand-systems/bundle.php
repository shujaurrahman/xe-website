<?php /* DRAFT COPY — review before launch */
/* 10 · Deliverables ($CAP['deliver']) as a release bundle: every artefact carries the same version,
   its formats and a short content hash. "Verify" re-checks each row. Hashes are placeholders derived
   from the artefact name. PLACEHOLDER: versions and hashes illustrative — confirm before launch */
$cbs_bn_owner = ['Design systems lead', 'Design systems lead', 'Content lead', 'Brand lead', 'System owner', 'Design systems lead', 'System owner'];
?>
<section class="band cbs-bn" id="deliverables" aria-labelledby="cbs-bn-t">
  <div class="wrap">
    <div class="cbs-bn__grid">
      <header class="cbs-head cbs-bn__head" data-rv>
        <p class="cbs-head__path"><b>10</b><i>/</i>deliverables<i>/</i>release-bundle</p>
        <h2 class="cbs-head__h" id="cbs-bn-t"><span class="g">What you receive,</span> versioned together.</h2>
        <p class="lead cbs-head__lead">Everything ships as one release. Tokens, components, templates, rules, governance, documentation and the notes all carry the same version number, so design, code and the guidelines never disagree about which brand is current.</p>
        <dl class="cbs-bn__facts">
          <div><dt>Artefacts</dt><dd><?= count($CAP['deliver']) ?></dd></div>
          <div><dt>Version</dt><dd>1.0.0</dd></div>
          <div><dt>Owned by</dt><dd>You</dd></div>
        </dl>
      </header>

      <div class="cbs-bn__card" data-cbs-bn>
        <div class="cbs-bn__top">
          <p class="cbs-bn__name"><code>@yourbrand/system</code><span class="cbs-tag cbs-tag--ink">v1.0.0</span><span class="cbs-tag cbs-tag--line">bundle</span></p>
          <button type="button" class="cbs-btn" data-cbs-bn-verify>Verify bundle</button>
        </div>
        <div class="bdh-scroll-x cbs-bn__scroll" tabindex="0" role="region" aria-label="Release bundle contents">
          <table class="cbs-bn__table">
            <caption class="bdh-sr">Release bundle v1.0.0: artefact, formats, version, hash and owner</caption>
            <thead><tr><th scope="col">Artefact</th><th scope="col">Formats</th><th scope="col">Version</th><th scope="col">Hash</th><th scope="col">Owner</th></tr></thead>
            <tbody>
              <?php foreach ($CAP['deliver'] as $cbs_di => $cbs_d): ?>
                <tr data-cbs-bn-row style="--i:<?= $cbs_di ?>">
                  <th scope="row"><span class="cbs-bn__ico" aria-hidden="true"><?= sprintf('%02d', $cbs_di + 1) ?></span><?= e($cbs_d[0]) ?></th>
                  <td><span class="cbs-bn__fmts"><?php foreach (array_map('trim', explode('·', $cbs_d[1])) as $cbs_fm): ?><span><?= e($cbs_fm) ?></span><?php endforeach; ?></span></td>
                  <td class="cbs-bn__mono">1.0.0</td>
                  <td class="cbs-bn__mono"><span class="cbs-bn__hash" data-cbs-bn-hash><?= e(substr(md5($cbs_d[0]), 0, 7)) ?></span></td>
                  <td><span class="cbs-bn__own"><?= e($cbs_bn_owner[$cbs_di] ?? 'System owner') ?></span></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <p class="cbs-bn__foot"><span class="cbs-bn__ok" data-cbs-bn-status role="status" aria-live="polite"><?= count($CAP['deliver']) ?> of <?= count($CAP['deliver']) ?> artefacts match v1.0.0</span><span class="cbs-note">Hashes illustrative</span></p>
      </div>
    </div>
  </div>
</section>
