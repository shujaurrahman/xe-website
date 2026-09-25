<?php /* DRAFT COPY — review before launch */ ?>
<?php $ind_lvl = [3 => 'Leads', 2 => 'Core', 1 => 'Supports']; ?>
<section class="band band--alt ind-exp" id="explorer" aria-labelledby="explorer-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Sector explorer</p>
        <h2 class="h2" id="explorer-t"><span class="g">Pick a sector.</span> See which disciplines lead.</h2></div>
      <div><p class="lead">Every programme draws on the same six disciplines in a different mix. Choose a sector to see the usual balance, the rules in play and the number we are asked to move.</p></div>
    </div>

    <div class="ind-exp__app">
      <div class="ind-exp__list mask-x" role="tablist" aria-label="Sectors" aria-orientation="vertical" hidden data-ind-tabs>
        <?php foreach ($IND as $ind_i => $ind_s): ?>
        <button type="button" role="tab" id="ind-tab-<?= e($ind_s['id']) ?>" aria-controls="ind-pane-<?= e($ind_s['id']) ?>" aria-selected="<?= $ind_i ? 'false' : 'true' ?>" tabindex="<?= $ind_i ? '-1' : '0' ?>">
          <span class="ind-exp__n"><?= e($ind_s['n']) ?></span><span class="ind-exp__nm"><?= e($ind_s['name']) ?></span><span class="ind-exp__kpi"><?= e($ind_s['kpi']) ?></span>
        </button>
        <?php endforeach; ?>
      </div>

      <div class="ind-exp__panes">
        <?php foreach ($IND as $ind_i => $ind_s): arsort($ind_s['mix']); ?>
        <article class="ind-exp__pane" id="ind-pane-<?= e($ind_s['id']) ?>" role="tabpanel" aria-labelledby="ind-pane-<?= e($ind_s['id']) ?>-t">
          <figure class="bdh-img ind-exp__img">
            <img src="<?= e($BASE) ?>assets/imgs/industries/<?= e($ind_s['img']) ?>" alt="" loading="lazy" decoding="async">
            <span class="ind-exp__chip bdh-ro"><?= e($ind_s['n']) ?> · <?= e($ind_s['kpi']) ?></span>
          </figure>
          <div class="ind-exp__body">
            <h3 class="h3" id="ind-pane-<?= e($ind_s['id']) ?>-t"><?= e($ind_s['name']) ?></h3>
            <p class="ind-exp__line"><?= e($ind_s['line']) ?></p>
            <dl class="ind-exp__at">
              <div><dt>Number we move</dt><dd><?= e($ind_s['kpi']) ?></dd></div>
              <div><dt>Named instruments</dt><dd><?= count($ind_s['rules']) ?></dd></div>
              <div><dt>Starting points</dt><dd><?= count($ind_s['entry']) ?></dd></div>
            </dl>
            <p class="ind-exp__sub bdh-ro">Discipline mix · typical programme</p>
            <ul class="ind-mix">
              <?php foreach ($ind_s['mix'] as $ind_slug => $ind_w): $ind_d = $ind_disc[$ind_slug]; ?>
              <li class="ind-mix__row" style="--w:<?= $ind_w ?>">
                <a href="<?= xe_discipline_url($ind_d) ?>"><?= e($ind_d['name']) ?></a>
                <span class="ind-meter" data-v="<?= $ind_w ?>" aria-hidden="true"><i></i><i></i><i></i></span>
                <span class="ind-mix__lv bdh-ro"><?= $ind_lvl[$ind_w] ?></span>
              </li>
              <?php endforeach; ?>
            </ul>
            <div class="ind-exp__rules">
              <?php foreach (array_slice($ind_s['rules'], 0, 3) as $ind_r): ?><span class="bdh-tag"><?= e($ind_r[0]) ?></span><?php endforeach; ?>
            </div>
            <p class="ind-exp__links">
              <a class="tl" href="#<?= e($ind_s['id']) ?>">Read the <?= e(ctype_alpha($ind_s['name'][1]) && ctype_lower($ind_s['name'][1]) ? lcfirst($ind_s['name']) : $ind_s['name']) ?> dossier <span class="i" aria-hidden="true">›</span></a>
              <a class="tl" href="#console">Build a brief for it <span class="i" aria-hidden="true">›</span></a>
            </p>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
