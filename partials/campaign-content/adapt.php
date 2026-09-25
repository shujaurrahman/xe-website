<?php /* DRAFT COPY — review before launch */
/* Adapt — SIGNATURE INTERACTIVE. The adaptation engine: one campaign idea, every placement it has to
   survive. Choose a placement (a radiogroup: arrow keys move and select, Home and End jump) and the
   canvas rebuilds the same idea at that placement's true proportions, with its own line length, type
   step and mandatory lines, while the pre-flight panel reports the eight checks the campaign system
   runs before anything reaches media. A switch overlays the rules — safe area, clearspace and the
   type floor — and is on by default, so the page without JavaScript shows the interesting state.
   Every frame and every check result is in the markup; adapt.js only switches which one is shown and
   replays the checks. Frame sizes are computed here so each placement fits the 4:3 stage exactly at
   its own aspect ratio: nothing is squashed to fit.
   PLACEHOLDER: the example brand, line, specifications and check values are illustrative. */
$ad_checks = [
    ['Contrast',           'Line on background'],
    ['Minimum type size',  'At viewing distance'],
    ['Safe area',          'Platform and trim'],
    ['Logo clearspace',    'One mark height'],
    ['Legal line',         'Market requirement'],
    ['Captions',           'Burnt-in or supplied'],
    ['Alt text',           'Written, not generated'],
    ['Localisation',       'Line-box reserve'],
];
/* p = pass · w = needs a person · n = does not apply here */
$ad_places = [
    [
        'k' => 'bumper', 'name' => '6-second bumper', 'spec' => '16:9 · 1920 × 1080 · video', 'short' => '16:9',
        'ar' => 16 / 9, 'sc' => 0.94, 'kind' => 'canvas', 'size' => 'l',
        'line' => 'Built for how you work.', 'legal' => false, 'note' => 'Sound off by default',
        'ch' => [['p', '7.4:1'], ['p', '48 px on a 1080 grid'], ['p', 'Title-safe 5%'], ['p', '1× mark'],
                 ['n', 'Not required on brand film'], ['p', 'Burnt-in and SRT supplied'], ['n', 'Captions carry it'], ['p', 'Reserve +20%']],
    ],
    [
        'k' => 'story', 'name' => 'Story and Reel', 'spec' => '9:16 · 1080 × 1920 · video', 'short' => '9:16',
        'ar' => 9 / 16, 'sc' => 0.98, 'kind' => 'canvas', 'size' => 'l',
        'line' => 'Built for how you work.', 'legal' => false, 'note' => 'Interface covers the lower band',
        'ch' => [['p', '7.4:1'], ['p', '56 px'], ['w', 'Lower 14% sits under the platform interface'], ['p', '1× mark'],
                 ['n', 'Not required'], ['p', 'Burnt-in · autoplay is muted'], ['n', 'Captions carry it'], ['p', 'Reserve +20%']],
    ],
    [
        'k' => 'feed', 'name' => 'In-feed carousel', 'spec' => '4:5 · 1080 × 1350 · still', 'short' => '4:5',
        'ar' => 4 / 5, 'sc' => 0.96, 'kind' => 'canvas', 'size' => 'm',
        'line' => 'Built for the way you already work.', 'legal' => true, 'note' => 'Card 1 of 5',
        'ch' => [['p', '7.4:1'], ['p', '34 px'], ['p', 'Clear of the caption fold'], ['p', '1× mark'],
                 ['p', 'Present · offer terms'], ['n', 'Still image'], ['p', 'Written per asset'], ['p', 'Reserve +20%']],
    ],
    [
        'k' => 'display', 'name' => 'Display banner', 'spec' => '300 × 250 · static', 'short' => '300×250',
        'ar' => 300 / 250, 'sc' => 0.46, 'kind' => 'canvas', 'size' => 's',
        'line' => 'Built for you.', 'legal' => false, 'note' => 'The hardest format in the set',
        'ch' => [['p', '7.4:1'], ['w', '14 px · under the 16 px floor'], ['p', 'No platform overlay'], ['w', 'Clearspace down to 0.6× mark'],
                 ['n', 'Legal moved to the landing page'], ['n', 'Static'], ['p', 'Written per asset'], ['w', 'No room to reserve · separate master']],
    ],
    [
        'k' => 'billboard', 'name' => '48-sheet billboard', 'spec' => '10:3 · 6096 × 3048 mm · print', 'short' => '10:3',
        'ar' => 10 / 3, 'sc' => 1.0, 'kind' => 'canvas', 'size' => 'xl',
        'line' => 'Built for you.', 'legal' => false, 'note' => 'Read in under two seconds',
        'ch' => [['p', '11.2:1 · print stock'], ['p', '520 mm cap height'], ['p', 'Trim 20 mm'], ['p', '1× mark'],
                 ['w', 'Not legible at distance · moved to the microsite'], ['n', 'Print'], ['n', 'Print'], ['p', 'Reserve +20%']],
    ],
    [
        'k' => 'email', 'name' => 'Email hero', 'spec' => '2:1 · 1200 × 600 · still', 'short' => '2:1',
        'ar' => 2 / 1, 'sc' => 0.9, 'kind' => 'canvas', 'size' => 'l',
        'line' => 'Built for the way you already work.', 'legal' => true, 'note' => 'Renders at 600 px wide',
        'ch' => [['p', '7.4:1'], ['p', '28 px on a 2× asset'], ['p', 'Above the fold at 600 px'], ['p', '1× mark'],
                 ['p', 'Present · unsubscribe in the footer'], ['n', 'Still image'], ['p', 'Alt text carries the line'], ['p', 'Reserve +20%']],
    ],
    [
        'k' => 'search', 'name' => 'Search ad', 'spec' => 'Text · 30 and 90 characters', 'short' => 'Text',
        'ar' => 5 / 2, 'sc' => 0.86, 'kind' => 'text', 'size' => 'm',
        'line' => 'Built for how you work', 'legal' => false, 'note' => 'No creative area at all',
        'ch' => [['n', 'Platform-rendered'], ['n', 'Platform-rendered'], ['n', 'No creative area'], ['n', 'No mark'],
                 ['p', 'Claims match the message house'], ['n', 'Text'], ['n', 'Text'], ['p', 'Headline fits 30 characters']],
    ],
    [
        'k' => 'retail', 'name' => 'Retail end-cap', 'spec' => '2:3 · 700 × 1050 mm · print', 'short' => '2:3',
        'ar' => 2 / 3, 'sc' => 0.94, 'kind' => 'canvas', 'size' => 'm',
        'line' => 'Built for how you work.', 'legal' => true, 'note' => 'Seen from three metres',
        'ch' => [['p', '9.6:1 · print stock'], ['p', '90 mm cap height'], ['p', 'Shelf line 120 mm clear'], ['p', '1× mark'],
                 ['p', 'Present · price rules'], ['n', 'Print'], ['n', 'Print'], ['p', 'Reserve +20%']],
    ],
    [
        'k' => 'regional', 'name' => 'Regional adaptation', 'spec' => '4:5 · Devanagari type stack · still', 'short' => 'Regional',
        'ar' => 4 / 5, 'sc' => 0.96, 'kind' => 'canvas', 'size' => 'm',
        'line' => 'Built for the way you already work.', 'legal' => true, 'note' => 'Type stack and line box change',
        'ch' => [['p', '7.4:1'], ['p', '34 px'], ['p', 'Clear of the caption fold'], ['p', '1× mark'],
                 ['p', 'Present · local terms'], ['n', 'Still image'], ['p', 'Written in market'], ['w', 'Line box +26% · one word breaks']],
    ],
];
/* the frame is laid inside a 4:3 stage: whichever edge binds first is set to the placement's presence,
   the other follows from its aspect ratio, so every placement keeps its true proportions */
$ad_box = 4 / 3;
foreach ($ad_places as $ad_i => $ad_p) {
    $ad_wide = $ad_p['ar'] >= $ad_box;
    $ad_places[$ad_i]['fw'] = round($ad_p['sc'] * ($ad_wide ? 100 : 100 * $ad_p['ar'] / $ad_box), 2);
    $ad_places[$ad_i]['fh'] = round($ad_p['sc'] * ($ad_wide ? 100 * $ad_box / $ad_p['ar'] : 100), 2);
    $ad_n = ['p' => 0, 'w' => 0, 'n' => 0];
    foreach ($ad_p['ch'] as $ad_c) { $ad_n[$ad_c[0]]++; }
    $ad_places[$ad_i]['n'] = $ad_n;
    $ad_places[$ad_i]['sum'] = $ad_n['w'] > 0
        ? $ad_n['p'] . ' of ' . ($ad_n['p'] + $ad_n['w']) . ' checks pass · ' . $ad_n['w'] . ' ' . ($ad_n['w'] === 1 ? 'needs' : 'need') . ' a person'
        : ($ad_n['p'] + $ad_n['w']) . ' of ' . ($ad_n['p'] + $ad_n['w']) . ' checks pass';
    if ($ad_n['n']) $ad_places[$ad_i]['sum'] .= ' · ' . $ad_n['n'] . ' not applicable';
}
$ad_first = $ad_places[0];
$ad_status = ['p' => 'Pass', 'w' => 'Needs a person', 'n' => 'Not applicable'];
$ad_cta = svc_contact_url(['campaign-content:campaign-system'], null, 'campaign-content');
?>
<section class="band band--alt cch-adapt" id="adapt" aria-labelledby="adapt-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The adaptation engine</p>
        <h2 class="h2" id="adapt-t"><span class="g">One idea.</span> Every placement it has to survive.</h2>
      </div>
      <div>
        <p class="lead">A campaign is not one film. Choose a placement and the same idea is rebuilt at that placement's real proportions, with its own line length, type step and mandatory lines — then checked against the rules before it can reach media.</p>
        <p class="cch-hint"><span class="cch-kbd">←</span><span class="cch-kbd">→</span> to change placement</p>
      </div>
    </div>

    <div class="bdh-ui cch-ad" data-place="0" data-rv data-rv-d="80" data-bdh-live>
      <div class="bdh-ui__bar cch-ad__top">
        <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="cch-ad__title">adaptation engine · your company · campaign master</span>
        <span class="cch-ad__state"><i class="bdh-pulse" aria-hidden="true"></i><span class="cch-ad__stxt">Pre-flight complete</span></span>
        <span class="bdh-ill">Illustrative</span>
      </div>

      <div class="cch-ad__places" role="radiogroup" aria-label="Placement">
        <?php foreach ($ad_places as $ad_i => $ad_p): ?>
          <button class="cch-ad__place" type="button" role="radio" aria-checked="<?= $ad_i === 0 ? 'true' : 'false' ?>"
                  tabindex="<?= $ad_i === 0 ? '0' : '-1' ?>" data-place="<?= $ad_i ?>">
            <span class="cch-ad__pratio" aria-hidden="true"><i style="--ar:<?= round($ad_p['ar'], 4) ?>"></i></span>
            <span class="cch-ad__pn"><?= e($ad_p['name']) ?></span>
            <span class="cch-ad__ps"><?= e($ad_p['short']) ?></span>
          </button>
        <?php endforeach; ?>
      </div>

      <p class="bdh-sr cch-ad__live" aria-live="polite"><?= e($ad_first['name']) ?>, <?= e($ad_first['spec']) ?>. <?= e($ad_first['sum']) ?>.</p>

      <div class="cch-ad__body">
        <div class="cch-ad__canvas">
          <div class="cch-ad__ch">
            <span class="cch-k">Canvas · true proportions</span>
            <button class="bdh-switch cch-ad__rules" type="button" aria-pressed="true">
              <span class="bdh-switch__track" aria-hidden="true"></span>Show the rules
            </button>
          </div>

          <p class="bdh-sr">The canvas shows one campaign idea rebuilt for the selected placement: a graphic device, the campaign line at the length that placement allows, the lockup for Your company, and the mandatory legal line where the market requires one. Safe-area and clearspace guides can be overlaid with the switch above. The measurements for every placement are listed in the pre-flight table beside the canvas.</p>

          <div class="cch-ad__stage is-rules" aria-hidden="true">
            <?php foreach ($ad_places as $ad_i => $ad_p): ?>
              <div class="bdh-pane cch-ad__frame cch-ad__frame--<?= e($ad_p['size']) ?><?= $ad_p['kind'] === 'text' ? ' is-text' : '' ?><?= $ad_i === 0 ? ' is-on' : '' ?>"
                   data-p="<?= e($ad_p['k']) ?>" style="--fw:<?= $ad_p['fw'] ?>%;--fh:<?= $ad_p['fh'] ?>%">
                <?php if ($ad_p['kind'] === 'text'): ?>
                  <span class="cch-ad__ad">
                    <span class="cch-ad__adk">Sponsored</span>
                    <span class="cch-ad__adu">yourcompany.example</span>
                    <span class="cch-ad__adh"><?= e($ad_p['line']) ?></span>
                    <span class="cch-ad__add">The tools your team already uses, joined up. See how it fits your workflow in four minutes.</span>
                  </span>
                <?php else: ?>
                  <span class="cch-ad__safe"></span>
                  <span class="cch-ad__dev"></span>
                  <span class="cch-ad__line"><?= e($ad_p['line']) ?></span>
                  <span class="cch-ad__lock"><i></i>Your company</span>
                  <?php if ($ad_p['legal']): ?><span class="cch-ad__legal">Terms apply. yourcompany.example/terms</span><?php endif; ?>
                  <?php if ($ad_p['k'] === 'regional'): ?><span class="cch-ad__badge">Devanagari stack</span><?php endif; ?>
                  <?php if ($ad_p['k'] === 'story'): ?><span class="cch-ad__ui"></span><?php endif; ?>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
            <span class="cch-ad__cross"></span>
          </div>

          <p class="cch-ad__cf">
            <span class="cch-ad__spec" data-ad="spec"><?= e($ad_first['spec']) ?></span>
            <span class="cch-ad__note" data-ad="note"><?= e($ad_first['note']) ?></span>
          </p>
        </div>

        <div class="cch-ad__pre">
          <p class="cch-ad__prh">
            <span class="cch-k">Pre-flight · before it reaches media</span>
            <span class="cch-ad__sum" data-ad="sum"><?= e($ad_first['sum']) ?></span>
          </p>

          <div class="bdh-panes cch-ad__panes">
            <?php foreach ($ad_places as $ad_i => $ad_p): ?>
              <table class="cch-ad__tbl bdh-pane<?= $ad_i === 0 ? ' is-on' : '' ?>" data-p="<?= e($ad_p['k']) ?>"
                     data-spec="<?= e($ad_p['spec']) ?>" data-note="<?= e($ad_p['note']) ?>" data-sum="<?= e($ad_p['sum']) ?>"
                     data-name="<?= e($ad_p['name']) ?>">
                <caption><?= e($ad_p['name']) ?> · <?= e($ad_p['spec']) ?></caption>
                <thead>
                  <tr><th scope="col">Check</th><th scope="col">Result</th></tr>
                </thead>
                <tbody>
                  <?php foreach ($ad_checks as $ad_ci => $ad_ck): $ad_r = $ad_p['ch'][$ad_ci]; ?>
                    <tr class="cch-ad__row is-<?= e($ad_r[0]) ?>" style="--i:<?= $ad_ci ?>">
                      <th scope="row"><b><?= e($ad_ck[0]) ?></b><small><?= e($ad_ck[1]) ?></small></th>
                      <td>
                        <span class="cch-ad__mk" aria-hidden="true"></span>
                        <span class="cch-ad__rv"><?= e($ad_r[1]) ?></span>
                        <span class="cch-ad__rs"><?= e($ad_status[$ad_r[0]]) ?></span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php endforeach; ?>
          </div>

        </div>
      </div>

      <div class="cch-ad__inherit">
        <div class="cch-ad__ic">
          <p class="cch-k">Every placement inherits</p>
          <ul role="list">
            <li><b>Tokens</b> from the brand system, so colour and type are not re-decided</li>
            <li><b>The message</b> from the matrix: audience × market × funnel stage</li>
            <li><b>The legal line</b> from the rules for the market it runs in</li>
          </ul>
        </div>
        <div class="cch-ad__ic">
          <p class="cch-k">Built and governed by</p>
          <p class="cch-capls cch-ad__caps">
            <a class="cch-capl" href="#campaign-design-systems"><b><?= e($CAPS['campaign-design-systems']['n']) ?></b><?= e($CAPS['campaign-design-systems']['short']) ?><i aria-hidden="true">›</i></a>
            <a class="cch-capl" href="#global-content-production"><b><?= e($CAPS['global-content-production']['n']) ?></b><?= e($CAPS['global-content-production']['short']) ?><i aria-hidden="true">›</i></a>
          </p>
          <a class="btn btn--ink btn--sm cch-ad__cta" href="<?= e($ad_cta) ?>">Start a campaign system brief <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>
    </div>

    <p class="cch-note cch-ad__foot">The example brand, line, specifications and check results above are illustrative, drawn to show how the rules work rather than to report a real campaign. Automated checks catch measurable rules: contrast, type size, safe areas, clearspace and mandatory lines. Anything that needs judgement is flagged for a person rather than passed.</p>
  </div>
</section>
