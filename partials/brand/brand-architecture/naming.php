<?php /* DRAFT COPY — review before launch */
/* 6 · Naming system — the new-brand test as a flow. Four questions down a spine; three of them
   have an exit. Answer and the path lights to an outcome (descriptor / sub-brand / new brand) with
   the naming rule that applies. HTML = the unanswered test; naming.js runs a sample until touched. */
$cba_q = [
    // question, help, exit on answer ('yes'|'no'), outcome key on exit
    ['Is it a genuinely new offer, not a size, version or variant of one you already sell?', 'Variants never get names of their own.', 'no', 'desc'],
    ['Does the master brand’s promise stretch to cover it without harming either?', 'If the stretch hurts the core or the newcomer, they should not share a name.', 'no', 'new'],
    ['Do customers need to ask for it by name to find it?', 'If a plain description finds it, a name is a cost with no return.', 'no', 'desc'],
    ['Will it be funded to build recognition of its own for three years or more?', 'A name nobody invests in is a label customers learn to ignore.', 'no', 'desc'],
];
$cba_out = [
    'desc' => ['Descriptor', 'Your brand + plain word', 'The master brand plus a descriptive word customers already use. No trademark, no colour or logo of its own. Tiers follow the fixed ladder: Core, Plus, Pro.'],
    'sub'  => ['Sub-brand', 'Your brand + coined name', 'The master brand leads; one coined or evocative word from the approved naming territory, screened for trademark and meaning in every market before use.'],
    'new'  => ['New brand', 'Standalone name', 'A full naming process: territory, long list, linguistic and legal checks in every market. Goes to the governance board with its business case; the parent appears only in the legal line.'],
];
?>
<section class="band cba-name" id="naming" aria-labelledby="naming-t">
  <div class="wrap">
    <div class="cba-head" data-rv>
      <div class="cba-head__t">
        <p class="cba-eb"><b>A-105</b><i aria-hidden="true"></i>Naming system · the new-brand test</p>
        <h2 class="h2" id="naming-t"><span class="g">Before anything gets a name,</span> it passes the test.</h2>
      </div>
      <div class="cba-head__l">
        <p class="lead"><?= e($CBA_CAP['offer'][3][1]) ?> <?= e($CBA_CAP['offer'][5][1]) ?></p>
      </div>
    </div>

    <div class="cba-name__formula" data-rv aria-label="Nomenclature order">
      <span class="cba-mono">Nomenclature</span>
      <ol>
        <li><b>Your brand</b><small>Master</small></li>
        <li><b>Sub-brand</b><small>Only if it passes</small></li>
        <li><b>Tier</b><small>Core · Plus · Pro</small></li>
        <li><b>Descriptor</b><small>Plain words</small></li>
      </ol>
    </div>

    <div class="cba-name__app" data-cba-name data-step="0">
      <div class="cba-name__ask cba-sheet">
        <p class="cba-name__prog cba-mono"><span>Question <b data-n="num">1</b> of <?= count($cba_q) ?></span><span data-n="state">Awaiting answer</span></p>
        <h3 class="cba-name__q" data-n="q" aria-live="polite"><?= e($cba_q[0][0]) ?></h3>
        <p class="cba-name__help" data-n="help"><?= e($cba_q[0][1]) ?></p>
        <div class="cba-name__btns">
          <button type="button" class="cba-ctl" data-ans="yes">Yes</button>
          <button type="button" class="cba-ctl" data-ans="no">No</button>
          <button type="button" class="cba-name__reset" data-n="reset">Start again</button>
        </div>
        <div class="cba-name__result" data-n="result" aria-live="polite" hidden>
          <p class="cba-mono cba-mono--blue">Outcome</p>
          <p class="cba-name__rh" data-n="rname"></p>
          <p class="cba-name__rf cba-mono cba-mono--ink" data-n="rform"></p>
          <p class="cba-name__rr" data-n="rrule"></p>
          <p class="cba-name__who"><span class="cba-mono cba-mono--blue">Agent</span> screens names for conflicts and meaning in every market. <span class="cba-mono cba-mono--ink">People</span> choose the name and sign off the test.</p>
        </div>
      </div>

      <ol class="cba-name__flow" aria-hidden="true">
        <?php foreach ($cba_q as $cba_qi => $cba_qq): $cba_o = $cba_out[$cba_qq[3]]; ?>
          <li class="cba-name__row" data-row="<?= $cba_qi ?>">
            <span class="cba-name__spine"></span>
            <span class="cba-name__dia"><b>Q<?= $cba_qi + 1 ?></b></span>
            <span class="cba-name__qt"><?= e($cba_qq[0]) ?></span>
            <span class="cba-name__exit"><i></i><em><?= $cba_qq[2] === 'no' ? 'No' : 'Yes' ?></em></span>
            <span class="cba-name__out cba-name__out--<?= $cba_qq[3] ?>" data-out="<?= $cba_qq[3] ?>"><?= e($cba_o[0]) ?></span>
          </li>
        <?php endforeach; ?>
        <li class="cba-name__row cba-name__row--end" data-row="4">
          <span class="cba-name__spine"></span>
          <span class="cba-name__term" data-out="sub"><em>Yes</em><?= e($cba_out['sub'][0]) ?></span>
        </li>
      </ol>
    </div>
    <script type="application/json" id="naming-data"><?= json_encode(['q' => $cba_q, 'out' => $cba_out], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
  </div>
</section>
