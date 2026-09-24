<?php /* DRAFT COPY — review before launch */
/* Signature — System Design: component architecture. Tokens → components → patterns → surfaces, every dependency drawn
   as an edge trimmed to the box edges it joins (never centre to centre). Picking a part highlights everything
   downstream of it (computed here by walking the edges), so the readout always matches the drawing. */
$pxd_bw = 116; $pxd_bh = 34; $pxd_cx = [4, 164, 324, 480]; $pxd_gy = 60; $pxd_top = 30;
$pxd_cols = ['Tokens', 'Components', 'Patterns', 'Surfaces'];
$pxd_nodes = [   // id => [label, column, row]
    't1' => ['color.action', 0, 0], 't2' => ['space.scale', 0, 1], 't3' => ['type.scale', 0, 2],
    'c1' => ['Button', 1, 0], 'c2' => ['Input', 1, 1], 'c3' => ['Card', 1, 2], 'c4' => ['Dialog', 1, 3],
    'p1' => ['Sign-up', 2, 0], 'p2' => ['Checkout', 2, 1], 'p3' => ['AI answer', 2, 2],
    's1' => ['Web app', 3, 0], 's2' => ['iOS', 3, 1], 's3' => ['Android', 3, 2],
];
$pxd_edges = [
    ['t1', 'c1'], ['t1', 'c4'], ['t2', 'c2'], ['t2', 'c3'], ['t3', 'c2'], ['t3', 'c3'],
    ['c1', 'p1'], ['c1', 'p2'], ['c2', 'p1'], ['c2', 'p2'], ['c3', 'p3'], ['c4', 'p2'], ['c4', 'p3'],
    ['p1', 's1'], ['p1', 's2'], ['p2', 's1'], ['p2', 's3'], ['p3', 's1'], ['p3', 's2'], ['p3', 's3'],
];
$pxd_pick = ['a' => 't1', 'b' => 'c2', 'c' => 'p3'];
$pxd_down = [];   // state => set of reached node ids (incl. the picked one)
foreach ($pxd_pick as $pxd_v => $pxd_start) {
    $pxd_seen = [$pxd_start => true]; $pxd_q = [$pxd_start];
    while ($pxd_q) { $pxd_n = array_shift($pxd_q); foreach ($pxd_edges as $pxd_e) if ($pxd_e[0] === $pxd_n && empty($pxd_seen[$pxd_e[1]])) { $pxd_seen[$pxd_e[1]] = true; $pxd_q[] = $pxd_e[1]; } }
    $pxd_down[$pxd_v] = $pxd_seen;
}
$pxd_count = function (string $pxd_v, int $pxd_col) use ($pxd_down, $pxd_nodes, $pxd_pick): int {
    $pxd_n = 0; foreach ($pxd_down[$pxd_v] as $pxd_id => $_) if ($pxd_nodes[$pxd_id][1] === $pxd_col && $pxd_id !== $pxd_pick[$pxd_v]) $pxd_n++; return $pxd_n;
};
$pxd_say = [];
foreach ($pxd_pick as $pxd_v => $pxd_id) {
    $pxd_parts = [];
    foreach ([1 => 'component', 2 => 'pattern', 3 => 'surface'] as $pxd_col => $pxd_w) { $pxd_c = $pxd_count($pxd_v, $pxd_col); if ($pxd_c) $pxd_parts[] = $pxd_c . ' ' . $pxd_w . ($pxd_c > 1 ? 's' : ''); }
    $pxd_say[$pxd_v] = 'Change ' . $pxd_nodes[$pxd_id][0] . ' once: ' . implode(', ', $pxd_parts) . ' inherit it, each covered by a visual regression check.';
}
$pxd_opts = [['a', 'Token · color.action', $pxd_say['a']], ['b', 'Component · Input', $pxd_say['b']], ['c', 'Pattern · AI answer', $pxd_say['c']]];
$pxd_sr = 'An illustrative component architecture: three tokens feed four components, which build three patterns used on web, iOS and Android; changing a part shows everything downstream that inherits it.';
$pxd_hi = function (string $pxd_id) use ($pxd_down): string { return implode(' ', array_keys(array_filter($pxd_down, fn ($pxd_s) => isset($pxd_s[$pxd_id])))); };
$pxd_xy = fn (string $pxd_id): array => [$pxd_cx[$pxd_nodes[$pxd_id][1]], $pxd_top + $pxd_nodes[$pxd_id][2] * $pxd_gy];
?>
<div class="pxd-ar bdh-scroll-x mask-x">
  <svg class="pxd-ar__svg" viewBox="0 0 600 <?= $pxd_top + 3 * $pxd_gy + $pxd_bh + 6 ?>" role="presentation" focusable="false">
    <?php foreach ($pxd_cols as $pxd_j => $pxd_t): ?><text class="pxd-ar__col" x="<?= $pxd_cx[$pxd_j] ?>" y="14"><?= sprintf('%02d', $pxd_j + 1) ?> · <?= e(strtoupper($pxd_t)) ?></text><?php endforeach; ?>
    <?php foreach ($pxd_edges as $pxd_e):
        [$pxd_x1, $pxd_y1] = $pxd_xy($pxd_e[0]); [$pxd_x2, $pxd_y2] = $pxd_xy($pxd_e[1]);
        $pxd_hie = implode(' ', array_keys(array_filter($pxd_down, fn ($pxd_s) => isset($pxd_s[$pxd_e[0]]) && isset($pxd_s[$pxd_e[1]])))); ?>
    <line class="pxd-ar__e" data-hi="<?= $pxd_hie ?>" x1="<?= $pxd_x1 + $pxd_bw + 4 ?>" y1="<?= $pxd_y1 + $pxd_bh / 2 ?>" x2="<?= $pxd_x2 - 4 ?>" y2="<?= $pxd_y2 + $pxd_bh / 2 ?>"/>
    <?php endforeach; ?>
    <?php foreach ($pxd_nodes as $pxd_id => $pxd_n): [$pxd_x, $pxd_y] = $pxd_xy($pxd_id); $pxd_sel = implode(' ', array_keys($pxd_pick, $pxd_id, true)); ?>
    <g class="pxd-ar__n" data-hi="<?= $pxd_hi($pxd_id) ?>"<?= $pxd_sel ? ' data-sel="' . $pxd_sel . '"' : '' ?>>
      <rect x="<?= $pxd_x ?>" y="<?= $pxd_y ?>" width="<?= $pxd_bw ?>" height="<?= $pxd_bh ?>" rx="7"/>
      <text x="<?= $pxd_x + 12 ?>" y="<?= $pxd_y + 21.5 ?>"><?= e($pxd_n[0]) ?></text>
    </g>
    <?php endforeach; ?>
  </svg>
</div>
<p class="pxd-ar__ro"><?php foreach ($pxd_pick as $pxd_v => $pxd_id): ?><span data-on="<?= $pxd_v ?>"><b><?= count($pxd_down[$pxd_v]) - 1 ?></b> parts inherit a change to <?= e($pxd_nodes[$pxd_id][0]) ?></span><?php endforeach; ?></p>
