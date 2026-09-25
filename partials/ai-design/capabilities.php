<?php /* DRAFT COPY — review before launch */
/* Capabilities — four of them, so this is a dossier rather than a grid. Each one is a full record: the
   statement, the lead, the six design problems it solves, the technologies it is built with and the
   frameworks it is built to.

   ANCHORS. The four capability subpages do not exist yet, so each dossier carries id="<capability-slug>"
   and every capability link on this page points at #<capability-slug>. Nothing here links to a file that
   is not on disk. When the subpages are built, these ids stay put and the links become real URLs.

   The enquiry link is tagged with the capability's own catalogue key — $cap['svc'] where it has one,
   because "Brand AI Tools" is an approved capability of both Brand Design and AI Design and the
   catalogue keys every page in one flat namespace (see the note in data/ai-design.php). */
?>
<section class="band aih-caps" id="capabilities" aria-labelledby="capabilities-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Capabilities · <?= count($CAPS) ?></p>
        <h2 class="h2" id="capabilities-t"><span class="g">Four capabilities.</span> One way of working.</h2>
      </div>
      <div>
        <p class="lead">They are sold separately and they compound. Strategy decides what is worth building, the models learn the brand, the studio produces at volume, and application design shapes what a customer actually meets.</p>
        <div class="aih-caplinks">
          <?php foreach ($CAPS as $cap_s => $cap_c): ?>
            <a class="aih-caplink" href="#<?= e($cap_s) ?>"><b><?= e($cap_c['n']) ?></b><span><?= e($cap_c['short']) ?></span><i aria-hidden="true">›</i></a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <div class="aih-caps__set">
      <?php foreach ($CAPS as $cap_s => $cap_c): ?>
        <article class="aih-caps__i" id="<?= e($cap_s) ?>" data-rv data-rv-d="40">
          <div class="aih-caps__rail">
            <div class="aih-caps__id">
              <span class="aih-caps__ico"><?= xt_icon($cap_c['icon'], ['size' => 22]) ?></span>
              <span class="bdh-idx"><?= e($cap_c['n']) ?></span>
            </div>
            <p class="aih-caps__k"><?= e($cap_c['kicker']) ?></p>
            <dl class="aih-caps__meta">
              <?php foreach ($cap_c['meta'] as $cap_mi => $cap_m): ?>
                <div><dt><?= e($cap_c['meta_k'][$cap_mi] ?? '') ?></dt><dd><?= e($cap_m) ?></dd></div>
              <?php endforeach; ?>
            </dl>
            <a class="tl aih-caps__cta" href="<?= e(svc_contact_url([], null, $cap_c['svc'] ?? $cap_s)) ?>"><?= e($cap_c['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
          </div>

          <div class="aih-caps__body">
            <h3 class="aih-caps__n"><?= e($cap_c['name']) ?></h3>
            <p class="aih-caps__st"><?= $cap_c['title'] ?></p>
            <p class="aih-caps__lead"><?= e($cap_c['lead']) ?></p>

            <p class="aih-k aih-caps__ok">Six things it covers</p>
            <ul class="aih-caps__offers">
              <?php foreach ($cap_c['offer'] as $cap_o): ?>
                <li class="aih-caps__o">
                  <span class="aih-caps__oi"><?= xt_icon($cap_o[3], ['size' => 18]) ?></span>
                  <span class="aih-caps__ot"><?= e($cap_o[0]) ?></span>
                  <span class="aih-caps__od"><?= e($cap_o[1]) ?></span>
                  <span class="bdh-tag aih-caps__og"><?= e($cap_o[2]) ?></span>
                </li>
              <?php endforeach; ?>
            </ul>

            <div class="aih-caps__foot">
              <div class="aih-caps__fb">
                <p class="aih-k">Built with</p>
                <?= xt_stack(array_slice($cap_c['stack'], 0, 12), ['variant' => 'logos', 'size' => 21, 'label' => 'Technologies we work with on ' . $cap_c['name'], 'class' => 'aih-caps__logos']) ?>
              </div>
              <div class="aih-caps__fb">
                <p class="aih-k">Built to</p>
                <ul class="aih-caps__std" role="list">
                  <?php foreach ($cap_c['standards'] as $cap_k): ?>
                    <?= xt_badge($cap_k, ['variant' => 'chip', 'tag' => 'li']) ?>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <p class="aih-note aih-caps__note">Technologies are the ones we work with on this kind of work, not partnerships or reseller tiers. Standards are the frameworks delivery is built to or aligned with.</p>
  </div>
</section>
