<?php /* DRAFT COPY — review before launch */ ?>
<?php /* Cookie Policy body. Inventory verified by grep on 24 Sep 2026 — re-run before launch:
   grep -rn "localStorage\|sessionStorage\|document.cookie\|setcookie" assets/js sections partials legal
   COUNSEL: classification of xe-seen (presentation-only, session-scoped, no identifier) as strictly necessary / exempt;
   whether ePrivacy-style consent applies to EU/UK visitors for it. No dark patterns: equal-weight accept/reject, nothing pre-ticked. */ ?>
<?php lgl_sec('preferences'); ?>
  <p>Strictly necessary storage is always on, because the site's features need it. The other categories are <strong>off</strong> and <strong>not in use today</strong>: switching them on or off records your choice for the future and changes nothing now.</p>
  <form class="lgl-cp" method="post" action="<?= e(lgl_url('cookies')) ?>#preferences" aria-labelledby="lgl-cp-t">
    <div class="lgl-cp__h"><p id="lgl-cp-t">Storage preferences</p><span class="lgl-st <?= $lgl_pref['at'] ? 'lgl-st--ok' : 'lgl-st--off' ?>"><?= $lgl_pref['at'] ? 'Choice saved' : 'No choice saved yet' ?></span></div>
    <div class="lgl-cp__row">
      <div><h3>Strictly necessary</h3><p>Makes features you use work — the services brief, the opening animation playing once, and remembering this choice.</p><span class="lgl-st lgl-st--ok">In use · always on</span></div>
      <label class="lgl-sw"><input type="checkbox" checked disabled aria-describedby="lgl-cp-nec"><span class="lgl-sw__t" aria-hidden="true"></span><span id="lgl-cp-nec">Always on</span></label>
    </div>
    <div class="lgl-cp__row">
      <div><h3>Analytics</h3><p>Would measure how the site is used, in aggregate. No analytics tool is installed.</p><span class="lgl-st lgl-st--off">Not in use today</span></div>
      <label class="lgl-sw"><input type="checkbox" name="analytics" value="1"<?= $lgl_pref['analytics'] ? ' checked' : '' ?>><span class="lgl-sw__t" aria-hidden="true"></span><span>Allow analytics</span></label>
    </div>
    <div class="lgl-cp__row">
      <div><h3>Marketing</h3><p>Would let advertising platforms recognise you across sites. No such tag is installed.</p><span class="lgl-st lgl-st--off">Not in use today</span></div>
      <label class="lgl-sw"><input type="checkbox" name="marketing" value="1"<?= $lgl_pref['marketing'] ? ' checked' : '' ?>><span class="lgl-sw__t" aria-hidden="true"></span><span>Allow marketing</span></label>
    </div>
    <div class="lgl-cp__act">
      <button class="btn btn--out" type="submit" name="lgl_act" value="none">Reject all optional</button>
      <button class="btn btn--out" type="submit" name="lgl_act" value="all">Accept all</button>
      <button class="btn btn--dark" type="submit" name="lgl_act" value="save">Save my choices</button>
    </div>
    <p class="lgl-cp__stat<?= $lgl_saved ? ' is-saved' : '' ?>" role="status">
      <?php if ($lgl_pref['at']): ?>
        <?= $lgl_saved ? 'Saved. ' : '' ?>Stored in cookie xe_prefs on <?= e(gmdate('j M Y, H:i', $lgl_pref['at'])) ?> UTC — analytics <?= $lgl_pref['analytics'] ? 'on' : 'off' ?>, marketing <?= $lgl_pref['marketing'] ? 'on' : 'off' ?>. Kept for 180 days.
      <?php else: ?>
        Nothing is stored until you press a button. Until then, only strictly necessary storage is used.
      <?php endif; ?>
    </p>
  </form>
</section>

<?php lgl_sec('what'); ?>
  <p>A <strong>cookie</strong> is a small text file a website asks your browser to keep and send back on later visits. <strong>Session storage</strong> is similar but stays in your browser, is never sent to our server, and is cleared when you close the tab. Both can hold personal data, so both are covered here.</p>
</section>

<?php lgl_sec('inventory'); ?>
  <div class="lgl-tw mask-x" tabindex="0" role="region" aria-label="Storage inventory, scrolls sideways on small screens">
    <table class="lgl-tbl">
      <caption class="sr">Every cookie and browser-storage item used by this website</caption>
      <thead><tr><th scope="col">Name</th><th scope="col">Type</th><th scope="col">What it does</th><th scope="col">Lasts</th><th scope="col">Category</th></tr></thead>
      <tbody>
        <tr><th scope="row"><code>xe-seen</code></th><td>Session storage</td><td>Records that the opening animation has played, so it shows once per visit. Holds only the value "1".</td><td>Until the tab closes</td><td>Strictly necessary</td></tr>
        <tr><th scope="row"><code>xe-brief</code></th><td>Session storage</td><td>Holds the services and package you pick in the catalogue, so the contact form can pre-fill them. Cleared when the form is sent.</td><td>Until the tab closes</td><td>Strictly necessary</td></tr>
        <tr><th scope="row"><code>xe_prefs</code></th><td>First-party cookie</td><td>Records your choice in the panel above and when you made it. Set only when you press a button.</td><td>180 days</td><td>Strictly necessary</td></tr>
      </tbody>
    </table>
  </div>
  <p>Our web host may keep standard server logs, which are not cookies; the <a href="<?= e(lgl_url('privacy')) ?>">Privacy Notice</a> covers them.</p>
</section>

<?php lgl_sec('third'); ?>
  <p>No third party sets cookies or storage through this site. Fonts, images and scripts are served from our own domain. If you follow a link to another site — LinkedIn, for example — that site's own policy applies.</p>
</section>

<?php lgl_sec('control'); ?>
  <p>You can also clear or block cookies and site data in your browser's settings. Blocking session storage will stop the services brief from carrying into the contact form; everything else will still work.</p>
</section>

<?php lgl_sec('changes'); ?>
  <p>Before we add any cookie or storage item, we will list it here and — if it is not strictly necessary — keep it off until you opt in through the panel above.</p>
</section>
