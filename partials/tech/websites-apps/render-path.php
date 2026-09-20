<?php /* DRAFT COPY — review before launch */
/* 04 · The stack, along the path a request takes. Six hops (Device → Edge → Rendering → APIs → Data → Observability),
   each a tab with its time budget, the technologies we work with at that hop, and why. A request packet walks the
   hops while the panel autoplays (render-path.js, BDH.tabs); the return packet carries the response back. Beneath,
   one page request traced hop by hop on a square-root time axis. The HTML is the finished state: every budget bar
   filled, the first hop selected. Budgets and timings are illustrative targets for a mobile visit over 4G. */
$twa_rp_hops = [   // key, name, role, icon, used ms, budget ms, budget label, stack slugs, why, how we hold it
    ['device', 'Device',        'Parse, hydrate, respond',   'mobile',    96,  150, '≤ 150 ms to hydrate',
        ['react', 'vuedotjs', 'flutter', 'reactnative', 'swift', 'kotlin', 'typescript', 'tailwindcss'],
        'The least code that does the job. Astro or Next.js is chosen by how much JavaScript the page truly needs, and only the interactive islands hydrate. Flutter or React Native when one codebase should serve both stores; native Swift and Kotlin for camera, sensor and background-heavy apps.',
        'Bundle-size limit per route in CI · hydration only for islands · INP measured in the field'],
    ['edge',   'Edge / CDN',    'Cache hit near the user',   'edge',      14,  30,  '≤ 30 ms at the edge',
        ['cloudflare', 'vercel', 'fastly', 'akamai'],
        'Pages and assets are cached at the edge with explicit cache keys, so most requests never reach a server and a deploy purges only what changed. Cloudflare or Vercel by where your traffic and your team already are; Fastly or Akamai when an enterprise contract already exists.',
        'Cache-hit ratio on the dashboard · stale-while-revalidate for content · immutable asset URLs'],
    ['render', 'Rendering',     'Server render, streamed',   'server',    68,  180, '≤ 180 ms to first byte',
        ['nextdotjs', 'astro', 'nodedotjs', 'typescript', 'tailwindcss'],
        'HTML arrives ready to paint. The shell streams before the data does, so the browser starts fonts and the hero image while the product query is still running. Next.js for products with real application state; Astro for content sites that should ship almost no JavaScript.',
        'p95 render time per template · streaming on by default · no client-side data waterfall'],
    ['api',    'APIs',          'Typed, cached, parallel',   'api',       105, 120, '≤ 120 ms p95 per page',
        ['graphql', 'openapiinitiative', 'contentful', 'sanity', 'strapi', 'shopify', 'algolia'],
        'One typed contract, GraphQL or OpenAPI, between the front end and every service behind it, with request coalescing and a short-TTL cache so a busy product page costs one round trip. A headless CMS or Shopify feed the same contract as your own services.',
        'Contract tests in CI · N+1 queries fail the build · calls batched per page'],
    ['data',   'Data',          'Indexed queries, hot cache', 'database', 26,  40,  '≤ 40 ms p95 per query',
        ['postgresql', 'redis', 'supabase', 'firebase'],
        'PostgreSQL with the indexes the real queries use, reviewed from the slow-query log rather than guessed. Redis holds sessions, carts and the hot set. Every query has a p95 budget and an alert, so a table growing tenfold is noticed before customers notice.',
        'Slow-query log reviewed each sprint · migrations rehearsed on a production copy'],
    ['obs',    'Observability', 'Traces, RUM, errors',       'radar',     2,   5,   '≤ 5 ms overhead',
        ['opentelemetry', 'sentry', 'datadog', 'grafana'],
        'OpenTelemetry stamps every hop above with one trace ID, so a slow page can be followed from the tap to the query. Sentry catches errors with the release that introduced them; Datadog RUM records the p75 field data this page keeps returning to. Sampled, so the cost stays under five milliseconds.',
        'One trace ID across hops · release tagged on every error · p75 alerts per template'],
];
$twa_rp_spans = [   // hop key, label, start ms, end ms, note  — one first-visit request, mobile, 4G (illustrative)
    ['device', 'DNS · TLS · request',              0,   38,   'HTTP/3 · connection reused after the first visit'],
    ['edge',   'Edge · cache lookup',              38,  52,   'miss on the first request · hit for the next five minutes'],
    ['render', 'Rendering · shell streamed',       52,  120,  'first byte at 120 ms'],
    ['api',    'APIs · product, stock, reviews',   60,  165,  'three calls in parallel, coalesced'],
    ['data',   'Data · PostgreSQL + Redis',        66,  96,   'index scan 24 ms · cache 2 ms'],
    ['render', 'Rendering · body streamed',        120, 212,  'HTML complete at 212 ms'],
    ['device', 'Device · paint + hydrate',         212, 1900, 'LCP at 1.9 s · islands hydrated by 1.1 s'],
    ['obs',    'Observability · trace exported',   212, 230,  'asynchronous · sampled'],
];
$twa_rp_max = 2000;
$twa_rp_x   = fn (float $ms): float => round(sqrt(max(0, $ms) / $twa_rp_max) * 100, 2);
/* full tick set on desktop; the four marked "key" survive the narrow layout, the rest are hidden there */
$twa_rp_ticks = [0, 50, 100, 200, 500, 1000, 2000];
$twa_rp_keytk = [0, 100, 500, 2000];
$twa_rp_ms  = fn (int $ms): string => $ms >= 1000 ? rtrim(rtrim(number_format($ms / 1000, 1), '0'), '.') . ' s' : $ms . ' ms';
$twa_rp_delivery = ['githubactions', 'playwright', 'storybook', 'lighthouse', 'github'];

/* Every technology mark in this section is emitted once into a hidden <symbol> block and referenced with <use>.
   The same slugs repeat across the hop strip and all six panes, so inlining each path six times cost roughly
   35 KB of duplicate geometry on a page that argues for byte budgets in §08. The chip markup below is the kit's
   own (.xt-stack--chips / .xt-chip), so assets/css/tech/kit.css still owns how these look. */
$twa_rp_sym = [];
foreach ($twa_rp_hops as $twa_h) {
    foreach ($twa_h[7] as $twa_sl) {
        $twa_f = xt_tech((string) $twa_sl)['file'] ?? '';
        $twa_b = $twa_f ? xt__svg_body($twa_f) : null;
        if ($twa_b) $twa_rp_sym['twa-rp-' . preg_replace('~[^a-z0-9]+~', '', strtolower((string) $twa_sl))] = $twa_b;
    }
}
unset($twa_h, $twa_sl, $twa_f, $twa_b);
$twa_rp_id = fn (string $twa_sl): string => 'twa-rp-' . preg_replace('~[^a-z0-9]+~', '', strtolower($twa_sl));
$twa_rp_use = function (string $twa_sl, int $twa_size) use ($twa_rp_sym, $twa_rp_id): string {
    $twa_i = $twa_rp_id($twa_sl);
    if (!isset($twa_rp_sym[$twa_i])) return '';
    return '<svg class="xt-logo" width="' . $twa_size . '" height="' . $twa_size . '" aria-hidden="true" focusable="false"'
         . ' data-tech="' . e($twa_sl) . '"><use href="#' . e($twa_i) . '"></use></svg>';
};
/* the kit's chips branch, drawn from the sprite instead of from a fresh copy of every path */
$twa_rp_chips = function (array $twa_slugs, string $twa_label) use ($twa_rp_use): string {
    $twa_out = '';
    foreach ($twa_slugs as $twa_sl) {
        $twa_t = xt_tech((string) $twa_sl);
        $twa_n = $twa_t['name'] ?? (string) $twa_sl;
        $twa_m = $twa_rp_use((string) $twa_sl, 18);
        $twa_out .= '<li class="xt-chip' . ($twa_m === '' ? ' xt-chip--word' : '') . '">'
                  . ($twa_m === '' ? '<span class="xt-chip__dot" aria-hidden="true"></span>' : $twa_m)
                  . '<span class="xt-chip__n">' . e($twa_n) . '</span></li>';
    }
    return '<ul class="xt-stack xt-stack--chips" role="list" aria-label="' . e($twa_label) . '">' . $twa_out . '</ul>';
};
?>
<section class="band twa-render-path" id="render-path" aria-labelledby="render-path-t">
  <div class="wrap">
    <div class="twa-head" data-rv>
      <p class="twa-head__run"><b>04 · The stack</b><span>One request · mobile · 4G · budgets per hop</span></p>
      <div class="twa-head__t">
        <h2 class="h2" id="render-path-t"><span class="g">The stack,</span> along the path a request takes.</h2>
      </div>
      <div class="twa-head__l">
        <p class="lead">Every technology here earns its place at one hop, with a time budget we hold it to. Pick a hop to read why it is there; the trace beneath shows what a single page request costs from the tap to the paint.</p>
      </div>
    </div>

    <svg class="twa-rp__sprite" aria-hidden="true" focusable="false" width="0" height="0"><defs>
      <?php foreach ($twa_rp_sym as $twa_si => $twa_sb): ?><symbol id="<?= e($twa_si) ?>" viewBox="<?= e($twa_sb['vb']) ?>" fill="currentColor"><?= $twa_sb['body'] ?></symbol><?php endforeach; ?>
    </defs></svg>

    <div class="twa-rp" data-rv>
      <p class="bdh-sr">Diagram: a request travels from the device through the edge cache, server rendering, APIs and the database, and every hop reports to observability. Each hop carries a time budget: device hydration 150 milliseconds, edge 30, rendering 180, APIs 120 at the 95th percentile, data 40 per query, observability overhead 5. Values are illustrative targets.</p>

      <div class="twa-rp__lane" role="tablist" aria-label="Hops along the request path">
        <span class="twa-rp__track" aria-hidden="true"><i></i></span>
        <span class="twa-rp__packet twa-rp__packet--req" aria-hidden="true"><i></i>GET /shop/stoneware</span>
        <span class="twa-rp__packet twa-rp__packet--res" aria-hidden="true"><i></i>200 · text/html · streamed</span>
        <?php foreach ($twa_rp_hops as $twa_hi => $twa_h): $twa_hp = $twa_h[4] / $twa_h[5]; ?>
          <button type="button" class="twa-rp__hop is-done<?= $twa_hi === 0 ? ' is-hot' : '' ?>" role="tab" id="rp-t<?= $twa_hi ?>" aria-controls="rp-p<?= $twa_hi ?>" aria-selected="<?= $twa_hi === 0 ? 'true' : 'false' ?>" tabindex="<?= $twa_hi === 0 ? '0' : '-1' ?>" data-hop="<?= e($twa_h[0]) ?>" style="--p:<?= round($twa_hp, 3) ?>">
            <span class="twa-rp__node" aria-hidden="true"><?= xt_icon($twa_h[3], ['size' => 22]) ?></span>
            <span class="twa-rp__idx" aria-hidden="true"><?= sprintf('%02d', $twa_hi + 1) ?></span>
            <span class="twa-rp__name"><?= e($twa_h[1]) ?></span>
            <span class="twa-rp__role"><?= e($twa_h[2]) ?></span>
            <span class="twa-rp__budget" aria-hidden="true">
              <span class="twa-rp__bar"><i class="twa-rp__fill"></i><em class="twa-rp__cap"></em></span>
              <span class="twa-rp__ms"><b><?= $twa_h[4] ?></b> / <?= $twa_h[5] ?> ms</span>
            </span>
            <span class="bdh-sr">Budget <?= e($twa_h[6]) ?>, typically <?= $twa_h[4] ?> milliseconds used.</span>
            <span class="twa-rp__logos" aria-hidden="true"><?php foreach (array_slice(array_values(array_filter($twa_h[7], fn ($twa_x) => !empty(xt_tech($twa_x)['file']))), 0, 4) as $twa_ls): ?><?= $twa_rp_use($twa_ls, 16) ?><?php endforeach; ?></span>
          </button>
        <?php endforeach; ?>
      </div>

      <div class="twa-rp__panes bdh-panes">
        <?php foreach ($twa_rp_hops as $twa_hi => $twa_h): ?>
          <div class="twa-rp__pane bdh-pane<?= $twa_hi === 0 ? ' is-on' : '' ?>" role="tabpanel" id="rp-p<?= $twa_hi ?>" aria-labelledby="rp-t<?= $twa_hi ?>" tabindex="0">
            <div class="twa-rp__why">
              <p class="twa-rp__k"><span class="bdh-idx"><?= sprintf('%02d', $twa_hi + 1) ?></span><span><?= e($twa_h[6]) ?></span></p>
              <h3 class="twa-rp__t"><?= e($twa_h[1]) ?> <span class="g">· <?= e($twa_h[2]) ?></span></h3>
              <p class="twa-rp__d"><?= e($twa_h[8]) ?></p>
              <p class="twa-rp__hold"><b>How we hold the budget</b><span><?= e($twa_h[9]) ?></span></p>
            </div>
            <div class="twa-rp__stack">
              <p class="twa-rp__sk">Technologies we work with at this hop</p>
              <?= $twa_rp_chips($twa_h[7], 'Technologies at the ' . $twa_h[1] . ' hop') ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="twa-rp__trace">
        <div class="twa-rp__th">
          <p class="twa-rp__tt"><b>One request, traced</b><span>first visit · mid-range Android · 4G · trace-id 7f3a…c21e</span></p>
          <p class="twa-rp__tot"><span>First byte <b>120 ms</b></span><span>HTML complete <b>212 ms</b></span><span>LCP <b>1.9 s</b></span><span class="twa-ill">Illustrative</span></p>
        </div>
        <p class="bdh-sr">Trace of one page request, illustrative: DNS, TLS and the request take the first 38 milliseconds; the edge cache lookup misses at 52; the rendering shell streams by 120 milliseconds while three API calls run in parallel to 165 and the database answers by 96; the HTML is complete at 212 milliseconds; the device paints the largest element at 1.9 seconds; the trace exports asynchronously.</p>
        <div class="twa-rp__wf" aria-hidden="true" style="--rows:<?= count($twa_rp_spans) ?>">
          <span class="twa-rp__axk">Span · square-root time axis</span>
          <div class="twa-rp__axis">
            <?php foreach ($twa_rp_ticks as $twa_tk): ?><span class="twa-rp__tk<?= $twa_tk === 0 ? ' twa-rp__tk--0' : ($twa_tk === $twa_rp_max ? ' twa-rp__tk--end' : '') ?><?= in_array($twa_tk, $twa_rp_keytk, true) ? '' : ' twa-rp__tk--min' ?>" style="--x:<?= $twa_rp_x($twa_tk) ?>%"><i></i><?= $twa_tk === 0 ? '0' : e($twa_rp_ms($twa_tk)) ?></span><?php endforeach; ?>
            <span class="twa-rp__mark twa-rp__mark--ttfb" style="--x:<?= $twa_rp_x(120) ?>%"><i></i><b>TTFB 120 ms</b></span>
            <span class="twa-rp__mark twa-rp__mark--lcp" style="--x:<?= $twa_rp_x(1900) ?>%"><i></i><b>LCP 1.9 s</b></span>
          </div>
          <?php foreach ($twa_rp_spans as $twa_si => $twa_sp):
              $twa_l = $twa_rp_x($twa_sp[2]); $twa_w = max(0.6, $twa_rp_x($twa_sp[3]) - $twa_l);
              $twa_rg = $twa_rp_ms($twa_sp[2]) . ' → ' . $twa_rp_ms($twa_sp[3]); ?>
            <div class="twa-rp__row" data-hop="<?= e($twa_sp[0]) ?>">
              <span class="twa-rp__rl"><?= e($twa_sp[1]) ?><small><?= e($twa_rg) ?></small></span>
              <span class="twa-rp__rb">
                <span class="twa-rp__span bdh-grow" style="--i:<?= $twa_si + 2 ?>;left:<?= $twa_l ?>%;width:<?= $twa_w ?>%"></span>
                <?php if ($twa_w > 40): ?>
                <span class="twa-rp__rn twa-rp__rn--in" style="--l:<?= $twa_l ?>%;--mw:calc(<?= $twa_w ?>% - 16px)"><b><?= e($twa_rg) ?> · </b><?= e($twa_sp[4]) ?></span>
                <?php else: ?>
                <span class="twa-rp__rn" style="--l:<?= round($twa_l + $twa_w, 2) ?>%"><b><?= e($twa_rg) ?> · </b><?= e($twa_sp[4]) ?></span>
                <?php endif; ?>
              </span>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="twa-rp__pre">
        <p class="twa-rp__prek"><?= xt_icon('pipeline', ['size' => 20]) ?><span>Before any request exists</span></p>
        <p class="twa-rp__pred">Built, tested and budget-checked in the pipeline, so what reaches the edge has already passed the gates.</p>
        <?= xt_stack($twa_rp_delivery, ['variant' => 'row', 'size' => 18, 'label' => 'Delivery tooling', 'class' => 'twa-rp__prel']) ?>
      </div>
    </div>
  </div>
</section>
