<?php /* DRAFT COPY — review before launch */
/* Hero — the page opens ON the map. The "opportunity terrain" fills the whole hero edge to edge;
   the headline sits in the map's legend cartouche, bottom-left, like a survey sheet's key.
   Contours are computed here (marching squares over a sum of peaks) so the HTML already holds
   the finished map; hero.js breathes them and drives the survey cursor. Figures are illustrative. */
$cgs_hero_peaks = [ // label, x, y, height, spread — PLACEHOLDER: illustrative terrain, confirm before launch
    ['A', 1000, 300, 1.00, 105], ['B', 745, 165, .74, 80], ['C', 855, 545, .64, 112],
    ['D', 1105, 650, .47, 66], ['E', 700, 665, .56, 58],
];
$cgs_hero_levels = [.12, .22, .32, .42, .52, .62, .72, .82, .92];
$cgs_hero_W = 1200; $cgs_hero_H = 800; $cgs_hero_step = 12;

if (!function_exists('cgs_terrain_paths')) {
    /** One SVG path "d" per level: marching squares over f(x,y). Shared maths with hero.js. */
    function cgs_terrain_paths(array $peaks, array $levels, int $W, int $H, int $st): array {
        $cols = intdiv($W, $st); $rows = intdiv($H, $st); $v = [];
        for ($j = 0; $j <= $rows; $j++) for ($i = 0; $i <= $cols; $i++) {
            $x = $i * $st; $y = $j * $st;
            $z = .05 * sin($x / 53) * cos($y / 41);
            foreach ($peaks as $p) { $z += $p[3] * exp(-((($x - $p[1]) ** 2) + (($y - $p[2]) ** 2)) / (2 * $p[4] ** 2)); }
            $v[$j][$i] = $z;
        }
        $T = [1 => [[3, 2]], 2 => [[2, 1]], 3 => [[3, 1]], 4 => [[0, 1]], 5 => [[3, 0], [2, 1]], 6 => [[0, 2]], 7 => [[3, 0]],
              8 => [[3, 0]], 9 => [[0, 2]], 10 => [[3, 2], [0, 1]], 11 => [[0, 1]], 12 => [[3, 1]], 13 => [[2, 1]], 14 => [[3, 2]]];
        $out = [];
        foreach ($levels as $lv) {
            $d = '';
            for ($j = 0; $j < $rows; $j++) for ($i = 0; $i < $cols; $i++) {
                $a = $v[$j][$i]; $b = $v[$j][$i + 1]; $c = $v[$j + 1][$i + 1]; $e = $v[$j + 1][$i];
                $k = ($a > $lv ? 8 : 0) | ($b > $lv ? 4 : 0) | ($c > $lv ? 2 : 0) | ($e > $lv ? 1 : 0);
                if (!isset($T[$k])) continue;
                $x0 = $i * $st; $y0 = $j * $st;
                $pt = function ($ed) use ($a, $b, $c, $e, $lv, $x0, $y0, $st) {
                    switch ($ed) {
                        case 0: return [$x0 + $st * ($lv - $a) / ($b - $a), $y0];
                        case 1: return [$x0 + $st, $y0 + $st * ($lv - $b) / ($c - $b)];
                        case 2: return [$x0 + $st * ($lv - $e) / ($c - $e), $y0 + $st];
                        default: return [$x0, $y0 + $st * ($lv - $a) / ($e - $a)];
                    }
                };
                foreach ($T[$k] as $sg) { $p = $pt($sg[0]); $q = $pt($sg[1]);
                    $d .= 'M' . round($p[0], 1) . ' ' . round($p[1], 1) . 'L' . round($q[0], 1) . ' ' . round($q[1], 1); }
            }
            $out[] = $d;
        }
        return $out;
    }
}
$cgs_hero_d = cgs_terrain_paths($cgs_hero_peaks, $cgs_hero_levels, $cgs_hero_W, $cgs_hero_H, $cgs_hero_step);
$cgs_hero_rank = $cgs_hero_peaks; usort($cgs_hero_rank, fn ($p, $q) => $q[3] <=> $p[3]);
?>
<section class="cgs-hero" id="top" aria-labelledby="hero-t">
  <!-- PLACEHOLDER: illustrative terrain peaks and index values, confirm before launch -->
  <figure class="cgs-sheet" data-cgs-terrain
          data-w="<?= $cgs_hero_W ?>" data-h="<?= $cgs_hero_H ?>" data-st="<?= $cgs_hero_step ?>"
          data-peaks='<?= e(json_encode($cgs_hero_peaks)) ?>' data-levels='<?= e(json_encode($cgs_hero_levels)) ?>'>
    <div class="cgs-sheet__map" aria-hidden="true">
      <svg class="cgs-terrain" viewBox="0 0 <?= $cgs_hero_W ?> <?= $cgs_hero_H ?>" preserveAspectRatio="xMaxYMid slice">
        <g class="cgs-terrain__iso">
          <?php foreach ($cgs_hero_d as $cgs_li => $cgs_path): ?>
            <path class="<?= $cgs_li % 3 === 2 ? 'is-index' : '' ?><?= $cgs_li >= 7 ? ' is-top' : '' ?>" style="--i:<?= $cgs_li ?>" d="<?= $cgs_path ?>"/>
          <?php endforeach; ?>
        </g>
        <g class="cgs-terrain__peaks">
          <?php foreach ($cgs_hero_peaks as $cgs_pi => $cgs_p): $cgs_up = $cgs_p[2] > 360; $cgs_end = $cgs_p[1] > $cgs_hero_W - 160; ?>
            <g class="cgs-peak<?= $cgs_pi === 0 ? ' is-lead' : '' ?>" data-peak="<?= $cgs_pi ?>" style="--i:<?= $cgs_pi ?>">
              <path d="M<?= $cgs_p[1] - 6 ?> <?= $cgs_p[2] + 5 ?>L<?= $cgs_p[1] ?> <?= $cgs_p[2] - 6 ?>L<?= $cgs_p[1] + 6 ?> <?= $cgs_p[2] + 5 ?>Z"/>
              <line x1="<?= $cgs_p[1] ?>" y1="<?= $cgs_p[2] + ($cgs_up ? -10 : 10) ?>" x2="<?= $cgs_p[1] ?>" y2="<?= $cgs_p[2] + ($cgs_up ? -40 : 40) ?>"/>
              <text x="<?= $cgs_p[1] + ($cgs_end ? -8 : 8) ?>" y="<?= $cgs_p[2] + ($cgs_up ? -46 : 58) ?>"<?= $cgs_end ? ' text-anchor="end"' : '' ?>>SEG <?= $cgs_p[0] ?> · <?= number_format($cgs_p[3], 2) ?></text>
            </g>
          <?php endforeach; ?>
        </g>
        <g class="cgs-cursor" transform="translate(860 400)">
          <line x1="-1200" y1="0" x2="1200" y2="0"/><line x1="0" y1="-800" x2="0" y2="800"/>
          <circle r="16"/><circle class="cgs-cursor__dot" r="3"/>
        </g>
      </svg>
    </div>
    <div class="cgs-sheet__hud">
      <div class="wrap cgs-sheet__hudin">
        <p class="cgs-sheet__bar" aria-hidden="true"><span>Opportunity terrain</span><span>Your category · sheet 01</span></p>
        <figcaption class="cgs-sheet__foot">
          <span class="cgs-sheet__read" aria-hidden="true"><b>X</b><span data-cgs-x>860</span><b>Y</b><span data-cgs-y>400</span><b>Index</b><span data-cgs-z>0.41</span></span>
          <span class="cgs-illus">Illustrative</span>
          <span class="bdh-sr">Illustrative opportunity terrain for a category: five segments shown as peaks, highest first —
            <?= e(implode(', ', array_map(fn ($p) => 'Segment ' . $p[0] . ' ' . number_format($p[3], 2), $cgs_hero_rank))) ?>.</span>
        </figcaption>
      </div>
    </div>
  </figure>

  <div class="wrap cgs-hero__in">
    <div class="cgs-hero__text">
      <nav class="cgs-crumb cgs-hero__up" style="--i:0" aria-label="Breadcrumb">
        <ol>
          <li><a href="<?= xe_url('services/index.php') ?>">Services</a></li>
          <li><a href="<?= xe_discipline_url($BRAND) ?>"><?= e($BRAND['name']) ?></a></li>
          <li aria-current="page"><?= e($CAP['name']) ?></li>
        </ol>
      </nav>
      <p class="cgs-eye cgs-hero__up" style="--i:1"><b><?= e($CAP['n']) ?></b><i></i><?= e($CAP['kicker']) ?></p>
      <h1 class="cgs-hero__h cgs-hero__up" id="hero-t" style="--i:2"><?= $CAP['title'] ?></h1>
      <p class="lead cgs-hero__lead cgs-hero__up" style="--i:3"><?= e($CAP['lead']) ?></p>
      <div class="cgs-hero__act cgs-hero__up" style="--i:4">
        <a class="btn btn--ink btn--lg" href="<?= xe_url('contact.php') ?>"><?= e($CAP['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out btn--lg" href="#scorer">Try the segment scorer <span class="i" aria-hidden="true">›</span></a>
      </div>
      <dl class="cgs-hero__meta cgs-hero__up" style="--i:5">
        <?php foreach ($CAP['meta'] as $cgs_mi => $cgs_mv): ?>
          <div><dt><?= e($CAP['meta_k'][$cgs_mi] ?? '') ?></dt><dd><?= e($cgs_mv) ?></dd></div>
        <?php endforeach; ?>
      </dl>
      <p class="cgs-hero__key cgs-hero__up" style="--i:6" aria-hidden="true">
        <span><i class="cgs-key cgs-key--peak"></i>Segment peak</span><span><i class="cgs-key cgs-key--iso"></i>Opportunity contour</span><span><i class="cgs-key cgs-key--cur"></i>Survey cursor</span>
      </p>
    </div>
  </div>
</section>
