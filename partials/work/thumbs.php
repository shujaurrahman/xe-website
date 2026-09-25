<?php /* DRAFT COPY — review before launch */
/**
 * Programme artefacts — one code-built illustration per programme: the thing the work left behind,
 * drawn in HTML and CSS rather than screenshotted from a client system. Every figure on them is
 * illustrative and never a client result.
 *
 *   wrk_thumb_label(string $slug): string   the short readout printed on the artefact's title bar
 *   wrk_thumb(string $slug, array $o): string  the artefact itself, aria-hidden, with a .bdh-sr sentence
 *
 * To add an artefact for a new programme, add a row to $wrk_art below with the same key as the
 * programme's 'slug' in data/work.php, then a `case` for it in the switch. A programme with no
 * artefact simply renders without one.
 */
if (!function_exists('wrk_thumb')) {

function wrk_art_set(): array
{
    return [
        'nine-markets-one-brand'      => ['Token sheet · 9 markets', 'a token sheet: four locked brand colours and nine market columns, all synced.'],
        'crm-that-remembers'          => ['Customer timeline',       'a customer timeline where the next message is chosen from the last event.'],
        'assistant-sales-trusts'      => ['Eval scorecard',          'an evaluation scorecard for a sales assistant: grounded answers, refusals and escalations, each against a target.'],
        'visible-in-ai-answers'       => ['AI answer · citations',   'an AI answer panel citing the brand as one of three sources.'],
        'season-in-days'              => ['Season run sheet',        'a season run sheet: brief, master assets, adaptations and live, compressed into days.'],
        'direct-booking-product'      => ['Booking path',            'a four-step direct booking path with the all-in price shown from the first step.'],
        'one-intelligence-layer'      => ['One data layer',          'network, marketing and care sources feeding one shared intelligence layer.'],
        'global-content-production'   => ['Master → adaptations',    'one master asset adapted into six market versions.'],
        'onboarding-with-disclosures' => ['KYC stepper',             'a five-step onboarding stepper with the disclosure step logged.'],
    ];
}

function wrk_thumb_label(string $wrk_id): string
{
    $wrk_t = wrk_art_set();
    return $wrk_t[$wrk_id][0] ?? '';
}

function wrk_thumb(string $wrk_id, array $wrk_o = []): string
{
    $wrk_t = wrk_art_set();
    if (!isset($wrk_t[$wrk_id])) return '';
    $wrk_cls = trim('wrk-th wrk-th--' . $wrk_id . ' ' . ($wrk_o['class'] ?? ''));
    ob_start(); ?>
<div class="<?= e($wrk_cls) ?>">
  <div class="wrk-th__ui" aria-hidden="true">
    <span class="wrk-th__bar bdh-ro"><span class="bdh-pulse"></span><?= e($wrk_t[$wrk_id][0]) ?><b class="bdh-ill">Illustrative</b></span>
    <div class="wrk-th__body">
<?php switch ($wrk_id):
case 'nine-markets-one-brand': ?>
      <span class="wrk-th__sw"><i class="wrk-sw--ink"></i><i class="wrk-sw--blue"></i><i class="wrk-sw--wash"></i><i class="wrk-sw--paper"></i></span>
      <span class="wrk-th__mk"><?php for ($wrk_i = 1; $wrk_i <= 9; $wrk_i++): ?><b>M<?= $wrk_i ?></b><?php endfor; ?></span>
<?php break; case 'crm-that-remembers': ?>
      <ol class="wrk-th__tl"><li>Viewed loan offer</li><li>Paused at income step</li><li class="is-on">Next: reminder with saved progress</li></ol>
<?php break; case 'assistant-sales-trusts': ?>
      <span class="wrk-th__ev"><b>Grounded</b><i style="--v:96"></i><em>96%</em></span>
      <span class="wrk-th__ev"><b>Says “don’t know”</b><i style="--v:88"></i><em>88%</em></span>
      <span class="wrk-th__ev"><b>Escalates pricing</b><i style="--v:100"></i><em>100%</em></span>
<?php break; case 'visible-in-ai-answers': ?>
      <span class="wrk-th__q">Best running shoe for flat feet?</span>
      <span class="wrk-th__cite"><b>1</b>review site</span><span class="wrk-th__cite is-on"><b>2</b>Your brand · fit guide</span><span class="wrk-th__cite"><b>3</b>forum</span>
<?php break; case 'season-in-days': ?>
      <span class="wrk-th__run"><b>Brief</b><i style="--s:0;--n:1"></i></span>
      <span class="wrk-th__run"><b>Masters</b><i style="--s:1;--n:2"></i></span>
      <span class="wrk-th__run"><b>Adapt ×120</b><i style="--s:3;--n:2"></i></span>
      <span class="wrk-th__run"><b>Live</b><i style="--s:5;--n:2"></i></span>
<?php break; case 'direct-booking-product': ?>
      <ol class="wrk-th__steps"><li class="is-on">Dates</li><li>Room</li><li>Guest</li><li>Pay</li></ol>
      <span class="wrk-th__price"><span>All-in, taxes included</span><b>shown from step 1</b></span>
<?php break; case 'one-intelligence-layer': ?>
      <span class="wrk-th__src"><b>Network</b><b>Marketing</b><b>Care</b></span>
      <span class="wrk-th__layer">One intelligence layer</span>
<?php break; case 'global-content-production': ?>
      <span class="wrk-th__master">Master</span>
      <span class="wrk-th__grid"><?php foreach (['IN', 'SG', 'AE', 'UK', 'ID', 'ZA'] as $wrk_m): ?><b><?= e($wrk_m) ?></b><?php endforeach; ?></span>
<?php break; default: ?>
      <ol class="wrk-th__steps wrk-th__steps--5"><li class="is-done">PAN</li><li class="is-done">Video KYC</li><li class="is-on">KFS</li><li>e-sign</li><li>Fund</li></ol>
      <span class="wrk-th__price"><span>Disclosure</span><b>shown · logged</b></span>
<?php endswitch; ?>
    </div>
  </div>
  <p class="bdh-sr">Illustration: <?= e($wrk_t[$wrk_id][1]) ?></p>
</div>
<?php
    return (string) ob_get_clean();
}

}
