<?php /* DRAFT COPY — review before launch */
/* 14 FAQ — the five questions from data/technology-intelligence.php plus one on Kubernetes and GPU
   capacity planning. Native <details>/<summary>, so it works with JavaScript off and is keyboard
   operable without any script. One is open on load. */
$tic_fq_items = $CAP['faq'];
$tic_fq_items[] = [
    'Do you do Kubernetes and GPU capacity planning?',
    'Yes. Cluster design, node pools per workload class, GPU sharing where it is safe, and a capacity model built from your traffic shape rather than a vendor sizing sheet. The plan states what happens at forecast peak, what the warm pool costs to hold, and where the queue absorbs a spike instead of a new node.',
];
$tic_fq_side = [
    ['doc',       'Send us what you have',      'An architecture sketch, a cloud bill, a latency dashboard or a week of traffic data is enough to start a useful conversation.'],
    ['scan',      'Or start with an audit',     'A two-week read of the platform: latency percentiles, failure modes, unit cost and carbon, with a ranked plan at the end.'],
    ['handshake', 'Then decide what to build',  'Nothing is rebuilt to be modern. Work starts where the measurement says the latency, the spend or the risk actually sits.'],
];
?>
<section class="band tic-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="tic-head" data-rv>
      <p class="tic-ch"><b>13</b><span>Questions</span><i aria-hidden="true"></i><em>answered plainly</em></p>
      <div class="tic-head__t">
        <h2 class="h2" id="faq-t"><span class="g">AI infrastructure,</span> asked directly.</h2>
      </div>
      <div class="tic-head__l">
        <p class="lead">The six questions that come up in nearly every first conversation about running AI in production.</p>
      </div>
    </div>

    <div class="tic-fq">
      <ul class="tic-fq__list" role="list" data-rv-s data-rv-step="70">
        <?php foreach ($tic_fq_items as $tic_fq_i => $tic_fq_q): ?>
          <li class="tic-fq__item">
            <details class="tic-fq__d"<?= $tic_fq_i === 0 ? ' open' : '' ?>>
              <summary class="tic-fq__q">
                <span class="bdh-idx tic-fq__n"><?= sprintf('%02d', $tic_fq_i + 1) ?></span>
                <span class="tic-fq__qt"><?= e($tic_fq_q[0]) ?></span>
                <span class="tic-fq__ic" aria-hidden="true"></span>
              </summary>
              <div class="tic-fq__a"><p><?= e($tic_fq_q[1]) ?></p></div>
            </details>
          </li>
        <?php endforeach; ?>
      </ul>

      <aside class="tic-fq__side" aria-label="Where a conversation usually starts">
        <div class="tic-fq__card" data-rv>
          <p class="tic-k">Where this usually starts</p>
          <ul class="tic-fq__steps" role="list">
            <?php foreach ($tic_fq_side as $tic_fq_s): ?>
              <li><?= xt_icon($tic_fq_s[0], ['size' => 18]) ?><b><?= e($tic_fq_s[1]) ?></b><span><?= e($tic_fq_s[2]) ?></span></li>
            <?php endforeach; ?>
          </ul>
          <a class="btn btn--ink tic-fq__cta" href="<?= e(function_exists('svc_contact_url') ? svc_contact_url([], null, $CAP['slug']) : xe_url('contact.php')) ?>"><?= e($CAP['cta']) ?><span class="i" aria-hidden="true">›</span></a>
          <p class="tic-note">Or read the discipline overview first — <a class="tl" href="<?= e(xe_url('services/technology-intelligence.php')) ?>">Technology &amp; Intelligence <span class="i" aria-hidden="true">›</span></a></p>
        </div>
      </aside>
    </div>
  </div>
</section>
