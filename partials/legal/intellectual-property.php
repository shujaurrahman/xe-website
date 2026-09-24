<?php /* DRAFT COPY — review before launch */ ?>
<?php /* Intellectual Property body. COUNSEL: registration numbers, classes and proprietor name must match the Trade Marks
   Registry certificates exactly; use of ® is lawful only for registered marks in India (Trade Marks Act 1999 s.107);
   copyright-assignment formalities (Copyright Act 1957 s.19); takedown handling vs. IT Act s.79 intermediary rules. */ ?>
<?php lgl_sec('marks'); ?>
  <!-- PLACEHOLDER: confirm trademark registration number/class before launch; use ™ until registered -->
  <p><strong>Xterra Edze®</strong> is a registered trademark of <span class="lgl-ph"><?= e($LGL_CO['entity']) ?></span>, registered with the Trade Marks Registry, Government of India.</p>
  <!-- PLACEHOLDER: registration numbers, classes and specifications — confirm against the certificates before launch. -->
  <div class="lgl-tw mask-x" tabindex="0" role="region" aria-label="Trademark registrations, scrolls sideways on small screens">
    <table class="lgl-tbl">
      <thead><tr><th scope="col">Mark</th><th scope="col">Registration no.</th><th scope="col">Class</th><th scope="col">Covers</th></tr></thead>
      <tbody>
        <?php foreach ($LGL_CO['tm'] as $lgl_tm): ?>
          <tr><th scope="row">XTERRA EDZE</th><td><span class="lgl-ph"><?= e($lgl_tm[0]) ?></span></td><td><span class="lgl-ph"><?= e($lgl_tm[1]) ?></span></td><td><?= e($lgl_tm[2]) ?></td></tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>

<?php lgl_sec('use'); ?>
  <p>You may use our name in plain text to refer to us accurately — in an article, a case study we have approved, or a list of suppliers. Use the ® on the first prominent mention. You may not use our logo, or anything confusingly similar to our name or marks, without written permission.</p>
  <ul class="lgl-mk" aria-label="Examples of correct and incorrect use of the mark">
    <li><div class="lgl-mk__s"><span>Xterra Edze<sup>®</sup></span></div><p class="lgl-mk__c"><span class="lgl-st lgl-st--ok">Do</span>Our name as two words, both capitalised, with ® on first prominent use.</p></li>
    <li><div class="lgl-mk__s lgl-mk__s--x"><s>XterraEdze</s></div><p class="lgl-mk__c"><span class="lgl-st lgl-st--gap">Don't</span>Join, abbreviate, translate or alter the name.</p></li>
    <li><div class="lgl-mk__s">Built with Xterra Edze</div><p class="lgl-mk__c"><span class="lgl-st lgl-st--ok">Do</span>A factual credit, where we did the work and you have our agreement.</p></li>
    <li><div class="lgl-mk__s lgl-mk__s--x"><s>Xterra Edze Certified</s></div><p class="lgl-mk__c"><span class="lgl-st lgl-st--gap">Don't</span>Suggest certification, partnership or endorsement we have not given.</p></li>
  </ul>
  <p>Trademark line for your credits:</p>
  <div class="lgl-copy">
    <code id="lgl-tm-line">Xterra Edze® is a registered trademark of <?= e($LGL_CO['entity']) ?>.</code>
    <button class="btn btn--out btn--sm" type="button" data-lgl-copy="lgl-tm-line" hidden>Copy line</button>
  </div>
</section>

<?php lgl_sec('copy'); ?>
  <p>The text, page designs, illustrations, interface mock-ups, code and compilation of this website are © <span class="lgl-ph"><?= e($LGL_CO['entity']) ?></span> or its licensors. You may quote short passages with credit and a link. Any other copying, adaptation or republication — including use to train an AI model — needs our written permission. Photographs are licensed from Unsplash and credited in the site's source.</p>
</section>

<?php lgl_sec('client'); ?>
  <p>On full payment, the deliverables we create for a client are assigned to that client in writing. We keep our pre-existing tools, methods and know-how, and license what the client needs to use the deliverable. The <a href="<?= e(lgl_url('commercial-policy')) ?>#ip">Commercial Policy</a> sets out the detail; the signed agreement prevails.</p>
</section>

<?php lgl_sec('third'); ?>
  <p>Technology names and logos on this site belong to their owners. We show them because we work with those technologies. Their appearance does not mean a partnership, sponsorship or endorsement unless we say so explicitly.</p>
</section>

<?php lgl_sec('takedown'); ?>
  <p>If you believe something on this site infringes your rights, or that someone is misusing our marks, email <a href="<?= e(lgl_mail('IP notice')) ?>"><?= e($SITE['company']['email']) ?></a> with: what the work or mark is, where the infringing material appears, your contact details, and a statement that the information is accurate and you are the owner or authorised to act. We will acknowledge it and act promptly, and tell you what we did.</p>
</section>
