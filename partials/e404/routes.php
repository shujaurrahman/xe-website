<?php /* DRAFT COPY — review before launch */
$E404_MAIN = [
    ['Home',        'index.php',      'compass', 'The whole company on one page.'],
    ['What we do',  'services/',      'layers',  'Six disciplines and every capability.'],
    ['Industries',  'industries.php', 'globe',   'Where we work and what we know there.'],
    ['Work',        'work.php',       'target',  'How programmes run and what they ship.'],
    ['Approach',    'approach.php',   'workflow','How we plan, build, review and hand over.'],
    ['Careers',     'careers.php',    'users',   'Open roles and how we hire.'],
    ['Contact',     'contact.php',    'chat',    'Send a brief or book a call.'],
    ['Capability finder', 'services/#finder', 'search', 'Search every capability by the need it answers.'],
];
/* Rank the destinations by how close each is to the address that failed, the same guess the hero's
   route readout makes: best word-level similarity between the typed words and the route's name and path. */
$e404_rank = function (array $e404_m) use ($e404_word): int {
    if (trim($e404_word) === '') return 0;
    $e404_hay = preg_split('~[^a-z0-9]+~', strtolower($e404_m[0] . ' ' . $e404_m[1] . ' ' . $e404_m[3]), -1, PREG_SPLIT_NO_EMPTY);
    $e404_top = 0;
    foreach (preg_split('~\s+~', trim($e404_word)) as $e404_w) {
        if (strlen($e404_w) < 3) continue;
        foreach ($e404_hay as $e404_h) {
            if (strlen($e404_h) < 3) continue;
            similar_text($e404_w, $e404_h, $e404_pc);
            if (strpos($e404_h, $e404_w) === 0 || strpos($e404_w, $e404_h) === 0) $e404_pc = max($e404_pc, 90);
            $e404_top = max($e404_top, (int) round($e404_pc));
        }
    }
    return $e404_top;
};
foreach ($E404_MAIN as $e404_i => $e404_m) { $E404_MAIN[$e404_i][4] = $e404_rank($e404_m); $E404_MAIN[$e404_i][5] = $e404_i; }
$e404_ranked = trim($e404_word) !== '' && max(array_column($E404_MAIN, 4)) >= 40;
if ($e404_ranked) usort($E404_MAIN, fn ($a, $b) => [$b[4], $a[5]] <=> [$a[4], $b[5]]);
?>
<section class="band band--alt e404-routes" id="destinations" aria-labelledby="destinations-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div><p class="lbl lbl--blue"><span class="dot"></span>Destinations</p>
        <h2 class="h2" id="destinations-t"><span class="g">Where to go instead.</span> Every main page, one step away.</h2></div>
      <div><?php if ($e404_ranked): ?><p class="lead">Ranked by how close each page is to <code class="e404-code"><?= e($e404_path) ?></code>, nearest first.</p><?php endif; ?><p class="lead">If a link on our own site sent you here, tell us at <a class="tl" href="mailto:<?= e($SITE['company']['email']) ?>?subject=<?= rawurlencode('Broken link: ' . ($e404_path ?: '/')) ?>"><?= e($SITE['company']['email']) ?></a> and we will fix it.</p></div>
    </div>

    <ul class="e404-dest">
      <?php foreach ($E404_MAIN as $e404_n => $e404_m): $e404_near = $e404_ranked && $e404_n === 0; ?>
        <li<?= $e404_near ? ' class="is-near"' : '' ?>><a class="e404-dest__a" href="<?= e(xe_url($e404_m[1])) ?>">
          <?= xt_icon($e404_m[2]) ?>
          <?php if ($e404_ranked): ?><span class="e404-dest__m"><?= $e404_near ? 'Nearest · ' : '' ?>match <?= (int) $e404_m[4] ?>%<span class="e404-dest__bar" aria-hidden="true"><i style="width:<?= (int) $e404_m[4] ?>%"></i></span></span><?php endif; ?>
          <span class="e404-dest__t"><?= e($e404_m[0]) ?></span>
          <span class="e404-dest__d"><?= e($e404_m[3]) ?></span>
          <span class="e404-dest__go" aria-hidden="true">›</span>
        </a></li>
      <?php endforeach; ?>
    </ul>

    <h3 class="e404-sub">The six disciplines</h3>
    <ul class="e404-disc">
      <?php foreach ($SITE['disciplines'] as $e404_d): ?>
        <li><a href="<?= e(xe_discipline_url($e404_d)) ?>"><span><?= e($e404_d['n']) ?></span><?= e($e404_d['name']) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
