<?php /* DRAFT COPY — review before launch */
/* The rhythm — how often it arrives, and what a year of it actually costs the reader.
   The year rail is twelve possible sends. The three scenarios are models, marked as models: the target
   twelve, a year with skips, and a quiet year. Each one multiplies the sample issue's own measured
   length (partials/newsletter/lib.php) by the number of issues, so the figures are arithmetic on a
   thing you can read on this page rather than a claim about anything sent.
   rhythm.js switches the scenario; without it the first is fully rendered and the other two are simply
   not reachable, which is the finished state for a reader with no JavaScript. */
$rhy_st   = nlt_stats($NLT);
$rhy_slots = 12;
$rhy_scen = [
    // key, label, issues, the sentence under the readout
    ['target', 'The target', 12, 'One issue a month, which is what we are aiming at.'],
    ['skips',  'With skips', 10, 'A realistic year: two months where nothing was worth sending, so nothing was sent.'],
    ['quiet',  'A quiet year', 6, 'A year with a lot of delivery and little to say about it. Still no padding.'],
];
$rhy_min = fn (int $rhy_n): int => (int) round($rhy_n * $rhy_st['total'] / 210);
$rhy_first = $rhy_scen[0];
$rhy_facts = [
    ['Send window', $NLT['meta']['window']],
    ['Length',      $NLT['meta']['length'] . ' — the sample above is ' . $rhy_st['total'] . ' words'],
    ['Skip rule',   $NLT['meta']['skip']],
    ['Re-sends',    'None. One send, to everyone who confirmed.'],
];
?>
<section class="band nlt-rhy" id="rhythm" aria-labelledby="rhythm-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The rhythm</p>
        <h2 class="h2" id="rhythm-t"><span class="g">Twelve possible sends a year,</span> and what they cost you.</h2>
      </div>
      <div>
        <p class="lead">The honest way to ask for an inbox is to say how much of it you want. This is the arithmetic:
          the sample issue you just read, multiplied by the number of issues in a year.</p>
      </div>
    </div>

    <div class="nlt-rhy__panel" data-nlt-rhythm data-words="<?= (int) $rhy_st['total'] ?>">
      <div class="nlt-rhy__top">
        <div class="nlt-rhy__ttl">
          <p class="nlt-k">A year, modelled</p>
          <p class="nlt-rhy__cap"><span class="nlt-sample">Modelled</span> Not a record of anything sent.</p>
        </div>
        <div class="bdh-seg nlt-rhy__seg" role="group" aria-label="How many issues in the year">
          <?php foreach ($rhy_scen as $rhy_i => $rhy_s): ?>
            <button type="button" data-rhy="<?= e($rhy_s[0]) ?>" data-issues="<?= (int) $rhy_s[2] ?>"
                    data-say="<?= e($rhy_s[3]) ?>"
                    aria-pressed="<?= $rhy_i === 0 ? 'true' : 'false' ?>"><?= e($rhy_s[1]) ?></button>
          <?php endforeach; ?>
        </div>
      </div>

      <ol class="nlt-rhy__rail" data-rhy-rail aria-label="Twelve possible sends in a year">
        <?php for ($rhy_n = 1; $rhy_n <= $rhy_slots; $rhy_n++): ?>
          <li class="nlt-rhy__slot<?= $rhy_n <= $rhy_first[2] ? ' is-on' : '' ?>" style="--i:<?= $rhy_n - 1 ?>">
            <span class="nlt-rhy__fill" aria-hidden="true"></span>
            <span class="nlt-rhy__sn"><?= str_pad((string) $rhy_n, 2, '0', STR_PAD_LEFT) ?></span>
            <span class="nlt-rhy__ss"><?= $rhy_n <= $rhy_first[2] ? 'Issue' : 'Skipped' ?></span>
          </li>
        <?php endfor; ?>
      </ol>

      <dl class="nlt-rhy__out">
        <div>
          <dt>Issues</dt>
          <dd><span class="nlt-num" data-rhy-issues><?= (int) $rhy_first[2] ?></span><span>a year</span></dd>
        </div>
        <div>
          <dt>Words</dt>
          <dd><span class="nlt-num" data-rhy-words><?= number_format($rhy_first[2] * $rhy_st['total']) ?></span><span>a year</span></dd>
        </div>
        <div>
          <dt>Reading time</dt>
          <dd><span class="nlt-num" data-rhy-mins><?= $rhy_min($rhy_first[2]) ?></span><span>minutes a year</span></dd>
        </div>
        <div class="nlt-rhy__say">
          <dt>What that scenario is</dt>
          <dd data-rhy-say><?= e($rhy_first[3]) ?></dd>
        </div>
      </dl>

      <p class="bdh-sr" role="status" aria-live="polite" data-rhy-live></p>

      <p class="nlt-rhy__base">At the sample issue's measured length of <span class="nlt-num"><?= (int) $rhy_st['total'] ?></span> words,
        read at 210 words a minute — the same rate the journal uses to print a reading time.</p>
    </div>

    <dl class="nlt-facts nlt-rhy__facts" data-rv>
      <?php foreach ($rhy_facts as $rhy_f): ?>
        <div><dt><?= e($rhy_f[0]) ?></dt><dd><?= e($rhy_f[1]) ?></dd></div>
      <?php endforeach; ?>
    </dl>
    <!-- PLACEHOLDER: confirm the cadence, the send window and the skip rule before launch. Every figure
         in this section is a target or arithmetic on the sample above; none of it is a measurement. -->
  </div>
</section>
