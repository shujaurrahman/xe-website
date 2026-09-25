<?php /* DRAFT COPY — review before launch */
/* Gates — the five decisions between the stages, read from the same map as the stepper. A gate is
   printed as what it is: a question, the evidence that answers it, who signs, and what happens on a no.
   The "on a no" line is the point of the section: a gate only means something if it can stop the work. */
$aprg_i = 0;
?>
<section class="band apr-gates" id="gates" aria-labelledby="gates-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The decisions</p>
        <h2 class="h2" id="gates-t"><span class="g">Five gates.</span> Each one can stop the work.</h2>
      </div>
      <div>
        <p class="lead">A gate is not a status meeting. It is a question with the evidence attached, signed
          by a named person on your side. If the evidence is not there, the work does not move on, and the
          date moves instead of the standard.</p>
      </div>
    </div>

    <ol class="apr-gates__list" data-rv-s data-rv-step="70">
      <?php foreach ($APR['gates'] as $aprg_key => $aprg_g): $aprg_i++; ?>
        <li class="apr-gates__row" id="gate-<?= e($aprg_key) ?>">
          <div class="apr-gates__id">
            <span class="apr-gates__n"><?= e($aprg_g['n']) ?></span>
            <h3 class="bdh-t apr-gates__name"><?= e($aprg_g['name']) ?></h3>
            <p class="apr-k">After <a class="apr-lk" href="#stage-<?= e($aprg_g['stage']) ?>"><?= e($aprg_g['after']) ?></a></p>
          </div>

          <div class="apr-gates__main">
            <p class="apr-gates__q"><?= e($aprg_g['question']) ?></p>
            <div class="apr-gates__ev">
              <p class="apr-k">The evidence it needs</p>
              <ul>
                <?php foreach ($aprg_g['evidence'] as $aprg_e): ?>
                  <li><span class="apr-tick" aria-hidden="true">✓</span><?= e($aprg_e) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>

          <div class="apr-gates__side">
            <p class="apr-gates__sign"><span class="apr-k">Signed by</span><span class="apr-who is-yours"><?= e($aprg_g['signs']) ?></span></p>
            <p class="apr-gates__no"><span class="apr-k">On a no</span><span><?= e($aprg_g['no']) ?></span></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>

    <p class="apr-note apr-gates__foot" data-rv>Gates are written into the statement of work before delivery
      starts, so nobody has to invent a decision point under pressure. Between gates, the weekly rhythm
      carries the smaller calls. <a class="apr-lk" href="#cadence">See how a week runs</a>.</p>
  </div>
</section>
