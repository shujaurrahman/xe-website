<?php /* DRAFT COPY — review before launch */
/* Deliverables: what the client owns at the end, drawn from each capability's hand-over list, plus the ownership
   terms that apply to all of it. */
$mth_dv_own = [
    ['Built in your accounts', 'Journeys, models, dashboards and templates live in your platforms, your warehouse and your repositories. Nothing sits in an account we control.'],
    ['Documented to be run',   'Runbooks, admin guides, metric definitions and model cards written for the people who will operate the system.'],
    ['No black boxes',         'Every decision rule, prompt and scoring feature is readable, versioned and can be switched off.'],
];
?>
<section class="band band--alt mth-dlv" id="deliverables" aria-labelledby="deliverables-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>What you own</p>
        <h2 class="h2" id="deliverables-t"><span class="g">Working systems,</span> not slide decks about them.</h2>
      </div>
      <div><p class="lead">Every module ends in something running in your stack, with the documents that let your team change it. Two hand-overs from each capability, as a sample of the full list.</p></div>
    </div>

    <div class="mth-dlv__wrap">
      <div class="mth-dlv__tbl bdh-scroll-x mask-x" tabindex="0" role="region" aria-label="Deliverables by capability">
        <table>
          <thead><tr><th scope="col">Deliverable</th><th scope="col">Format</th><th scope="col">From</th></tr></thead>
          <tbody>
          <?php foreach ($CAPS as $mth_dv_slug => $mth_dv): foreach (array_slice($mth_dv['deliver'], 0, 2) as $mth_dv_i => $mth_dv_d): ?>
            <tr>
              <th scope="row"><?= e($mth_dv_d[0]) ?></th>
              <td><span class="mth-dlv__fmt"><?= e($mth_dv_d[1]) ?></span></td>
              <td><?php if ($mth_dv_i === 0): ?><a class="mth-dlv__from" href="<?= e(xe_cap_url($DISC, [2 => $mth_dv_slug])) ?>"><span class="bdh-idx"><?= e($mth_dv['n']) ?></span><?= e($mth_dv['short']) ?></a><?php else: ?><span class="mth-dlv__same"><span class="bdh-idx"><?= e($mth_dv['n']) ?></span><?= e($mth_dv['short']) ?></span><?php endif; ?></td>
            </tr>
          <?php endforeach; endforeach; ?>
          </tbody>
        </table>
      </div>
      <ul class="mth-dlv__own">
        <?php foreach ($mth_dv_own as $mth_dv_o): ?>
        <li><h3 class="bdh-t"><?= e($mth_dv_o[0]) ?></h3><p class="bdh-d"><?= e($mth_dv_o[1]) ?></p></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
