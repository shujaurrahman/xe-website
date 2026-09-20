<?php
/**
 * Services & packages — the shared catalogue section. One component, per-page data, identical everywhere.
 *
 *   <?php $svc_key = 'growth-strategy'; include __DIR__ . '/../../services/catalogue.php'; ?>   (from partials/<a>/<b>/)
 *   <?php $svc_key = 'brand-design'; include __DIR__ . '/../partials/services/catalogue.php'; ?>   (from services/<page>.php)
 *
 *   $svc_key  required  a page key from data/services/*.php (the discipline slug on a hub, the capability slug
 *                       on a capability page). Renders nothing when the key has no data.
 *   $SITE     required  from partials/init.php.
 *   Page assets: assets/css/services.css (.svc-*) and assets/js/services.js (standalone; uses window.XE when present).
 *
 * What it renders: a head (eyebrow, the page's title and lead, how to buy), a category rail with counts
 * (ARIA tablist once services.js runs; without JS every category is shown stacked), offer cards with a direct
 * "Enquire" link and an "Add to brief" toggle, a brief tray (count, names, package picker, "Continue to contact"),
 * and the page's engagement packages with a "Choose …" link each.
 *
 * Progressive enhancement: the catalogue is a GET form to the contact page. "Add to brief" is a real checkbox
 * (service[]), the package picker a real select and "Continue to contact" a real submit, so the whole flow works
 * with JS off. services.js adds the tabs, the live tray, a brief that persists across pages for the visit
 * (sessionStorage) and keeps every "Choose …" link carrying the services already picked.
 *
 * Locals are prefixed svc_ so the chrome's variables ($c $d $i $k $item $url $current $disc $col $l $s) are untouched.
 */
require_once __DIR__ . '/lib.php';

$svc_key  = (string) ($svc_key ?? '');
$svc_page = svc_page($svc_key);
if ($svc_page):
    $svc_pk_all  = svc_packages();
    $svc_pks     = array_values(array_filter($svc_page['packages'], fn ($svc_x) => isset($svc_pk_all[$svc_x])));
    $svc_cats    = array_values(array_filter($svc_page['categories'], fn ($svc_x) => !empty($svc_x['offers'])));
    $svc_total   = array_sum(array_map(fn ($svc_x) => count($svc_x['offers']), $svc_cats));
    $svc_meta    = svc_page_meta($svc_key);
    $svc_logos   = function_exists('xt_logo');
    $svc_two     = fn (int $svc_n): string => str_pad((string) $svc_n, 2, '0', STR_PAD_LEFT);
?>
<section class="band band--alt svc" id="services" aria-labelledby="services-t" data-svc
         data-svc-from="<?= e($svc_key) ?>" data-svc-name="<?= e($svc_meta['name']) ?>" data-svc-contact="<?= e(xe_url('contact.php')) ?>">
  <div class="wrap">

    <header class="svc-head" data-rv>
      <div class="svc-head__t">
        <p class="lbl lbl--blue"><span class="dot"></span>Services &amp; packages</p>
        <h2 class="h2 svc-head__h" id="services-t"><?= $svc_page['title'] ?></h2>
      </div>
      <div class="svc-head__side">
        <p class="lead svc-head__lead"><?= e($svc_page['lead']) ?></p>
        <dl class="svc-facts">
          <div><dt>Categories</dt><dd><?= $svc_two(count($svc_cats)) ?></dd></div>
          <div><dt>Services</dt><dd><?= $svc_two($svc_total) ?></dd></div>
          <div><dt>Packages</dt><dd><?= $svc_two(count($svc_pks)) ?></dd></div>
        </dl>
        <a class="tl svc-head__help" href="<?= e(svc_contact_url([], null, $svc_key)) ?>">Not sure what you need? Describe the problem <span class="i" aria-hidden="true">›</span></a>
      </div>
    </header>

    <div class="svc-how" data-rv data-rv-d="60">
      <p class="svc-how__k">How to buy</p>
      <ol class="svc-how__steps">
        <li><span class="svc-how__n">01</span><span><b>Pick services.</b> Enquire about one, or add several to a brief.</span></li>
        <li><span class="svc-how__n">02</span><span><b>Choose how to engage.</b> A sprint, a fixed project or an ongoing team.</span></li>
        <li><span class="svc-how__n">03</span><span><b>Send the brief.</b> We reply within one working day.</span></li>
      </ol>
    </div>

    <form class="svc-cat" action="<?= e(xe_url('contact.php')) ?>" method="get" data-svc-form>
      <input type="hidden" name="from" value="<?= e($svc_key) ?>">

      <div class="svc-cols">
      <div class="svc-rail">
        <div class="svc-rail__in">
          <p class="svc-rail__k" id="svc-rail-k">Browse by category</p>
          <div class="svc-tabs" role="tablist" aria-labelledby="svc-rail-k" aria-orientation="vertical" data-svc-tabs>
            <span class="svc-tabs__ink" aria-hidden="true"></span>
            <?php foreach ($svc_cats as $svc_ci => $svc_c): ?>
              <button class="svc-tab" type="button" role="tab" id="svc-t-<?= e($svc_c['key']) ?>" aria-controls="svc-p-<?= e($svc_c['key']) ?>"
                      aria-selected="<?= $svc_ci === 0 ? 'true' : 'false' ?>" tabindex="<?= $svc_ci === 0 ? '0' : '-1' ?>" data-svc-tab>
                <span class="svc-tab__ico"><?= svc_icon($svc_c['icon'] ?? 'dot') ?></span>
                <span class="svc-tab__n"><?= e($svc_c['name']) ?></span>
                <span class="svc-tab__c"><span class="sr">, </span><?= $svc_two(count($svc_c['offers'])) ?><span class="sr"> services</span></span>
                <span class="svc-tab__pick" aria-hidden="true" data-svc-tabpick hidden></span><span class="sr" data-svc-tabsr></span>
              </button>
            <?php endforeach; ?>
          </div>
          <p class="svc-rail__note">Timelines are typical. Every quote follows a written scope.</p>
        </div>
      </div>

      <div class="svc-main">
        <div class="svc-panes">
          <?php foreach ($svc_cats as $svc_ci => $svc_c): $svc_cn = $svc_two($svc_ci + 1); ?>
            <div class="svc-pane" id="svc-p-<?= e($svc_c['key']) ?>" data-svc-pane>
              <div class="svc-pane__head">
                <span class="svc-pane__ico"><?= svc_icon($svc_c['icon'] ?? 'dot') ?></span>
                <p class="svc-pane__t"><span class="svc-pane__n"><?= $svc_cn ?></span><?= e($svc_c['name']) ?></p>
                <span class="svc-pane__c"><?= count($svc_c['offers']) ?> services</span>
              </div>

              <div class="svc-grid">
                <?php foreach ($svc_c['offers'] as $svc_oi => $svc_o):
                    $svc_id  = $svc_key . ':' . $svc_o['key'];
                    $svc_hid = 'svc-o-' . $svc_c['key'] . '-' . $svc_o['key'];
                    $svc_capm = null;   // hub cards may point at the capability page that sells this in depth
                    if (!empty($svc_o['cap']) && $svc_o['cap'] !== $svc_key) {
                        $svc_capm = svc_page_meta((string) $svc_o['cap']);
                        if (empty($svc_capm['url']) || $svc_capm['hub']) $svc_capm = null;
                    } ?>
                  <article class="svc-card" id="<?= e($svc_hid) ?>" aria-labelledby="<?= e($svc_hid) ?>-t" style="--i:<?= $svc_oi ?>"
                           data-svc-card data-id="<?= e($svc_id) ?>" data-name="<?= e($svc_o['name']) ?>">
                    <div class="svc-card__top">
                      <span class="svc-card__code" aria-hidden="true"><?= $svc_cn ?>.<?= $svc_two($svc_oi + 1) ?></span>
                      <?php if (!empty($svc_o['time'])): ?>
                        <span class="svc-card__time"><?= svc_icon('clock', ['size' => 14]) ?><span class="sr">Typical timeline: </span><?= e($svc_o['time']) ?></span>
                      <?php endif; ?>
                    </div>

                    <h3 class="svc-card__t" id="<?= e($svc_hid) ?>-t"><?= e($svc_o['name']) ?></h3>
                    <p class="svc-card__d"><?= e($svc_o['desc'] ?? '') ?></p>

                    <?php if (!empty($svc_o['includes'])): ?>
                      <p class="svc-card__k" id="<?= e($svc_hid) ?>-inc">What’s included</p>
                      <ul class="svc-card__inc" aria-labelledby="<?= e($svc_hid) ?>-inc">
                        <?php foreach ($svc_o['includes'] as $svc_x): ?><li><?= e($svc_x) ?></li><?php endforeach; ?>
                      </ul>
                    <?php endif; ?>

                    <?php if (!empty($svc_o['tags']) || !empty($svc_o['stack'])): ?>
                      <div class="svc-card__chips">
                        <?php if (!empty($svc_o['tags'])): ?>
                          <ul class="svc-tags" aria-label="Tags">
                            <?php foreach ($svc_o['tags'] as $svc_x): ?><li class="svc-tag"><?= e($svc_x) ?></li><?php endforeach; ?>
                          </ul>
                        <?php endif; ?>
                        <?php if (!empty($svc_o['stack'])): ?>
                          <ul class="svc-stack" aria-label="Tools">
                            <?php foreach ($svc_o['stack'] as $svc_x):
                                $svc_tn = svc_tech_name((string) $svc_x);
                                /* a logo only where the kit has a licence-clean mark; otherwise the name alone (no doubled wordmark) */
                                $svc_lg = $svc_logos && function_exists('xt_tech') && !empty(xt_tech((string) $svc_x)['file'] ?? null); ?>
                              <li class="svc-stack__i<?= $svc_lg ? ' svc-stack__i--logo' : '' ?>">
                                <?php if ($svc_lg): ?><?= xt_logo((string) $svc_x, ['size' => 16, 'hidden' => true]) ?><?php endif; ?><span class="svc-stack__n"><?= e($svc_tn) ?></span>
                              </li>
                            <?php endforeach; ?>
                          </ul>
                        <?php endif; ?>
                      </div>
                    <?php endif; ?>

                    <?php if (!empty($svc_o['best']) || $svc_capm): ?>
                      <div class="svc-card__foot">
                        <?php if (!empty($svc_o['best'])): ?>
                          <p class="svc-card__best"><span class="svc-card__bk">Best for</span><?= e($svc_o['best']) ?></p>
                        <?php endif; ?>
                        <?php if ($svc_capm): ?>
                          <a class="svc-card__cap" href="<?= e($svc_capm['url']) ?>">See <?= e($svc_capm['name']) ?> <span aria-hidden="true">›</span></a>
                        <?php endif; ?>
                      </div>
                    <?php endif; ?>

                    <div class="svc-card__act">
                      <a class="svc-card__enq" href="<?= e(svc_contact_url([$svc_id], null, $svc_key)) ?>">
                        Enquire<span class="sr"> about <?= e($svc_o['name']) ?></span> <span class="svc-card__arr" aria-hidden="true">›</span>
                      </a>
                      <label class="svc-add">
                        <input class="svc-add__in" type="checkbox" name="service[]" value="<?= e($svc_id) ?>"
                               aria-label="Add <?= e($svc_o['name']) ?> to your brief" data-svc-add>
                        <span class="svc-add__box" aria-hidden="true"><?= svc_icon('plus', ['class' => 'svc-add__plus']) ?><?= svc_icon('tick', ['class' => 'svc-add__tick']) ?></span>
                        <span class="svc-add__off" aria-hidden="true">Add to brief</span>
                        <span class="svc-add__on" aria-hidden="true">In your brief</span>
                      </label>
                    </div>
                  </article>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      </div>

        <div class="svc-tray" role="region" aria-labelledby="svc-tray-t" data-svc-tray>
          <div class="svc-tray__in">
            <div class="svc-tray__sum">
              <span class="svc-tray__count" aria-hidden="true"><b data-svc-count>00</b></span>
              <div class="svc-tray__txt">
                <p class="svc-tray__t" id="svc-tray-t">Your brief<span class="svc-tray__tn" data-svc-tn></span></p>
                <p class="svc-tray__hint" data-svc-hint>Tick “Add to brief” on any service, choose a package, then continue. Or enquire about one service directly.</p>
              </div>
            </div>
            <div class="svc-tray__body" id="svc-tray-body" data-svc-body>
              <ul class="svc-tray__list" aria-label="Services in your brief" data-svc-list hidden></ul>
              <div class="svc-tray__pk">
                <label class="svc-tray__pl" for="svc-pkg">Package</label>
                <span class="svc-tray__selw">
                  <select class="svc-tray__sel" id="svc-pkg" name="package" data-svc-pkg>
                    <option value="">Not sure yet</option>
                    <?php foreach ($svc_pks as $svc_x): ?>
                      <option value="<?= e($svc_x) ?>"><?= e($svc_pk_all[$svc_x]['name']) ?> · <?= e($svc_pk_all[$svc_x]['pricing']) ?></option>
                    <?php endforeach; ?>
                  </select>
                </span>
              </div>
              <button class="svc-tray__clear" type="button" data-svc-clear hidden>Clear brief</button>
            </div>
            <div class="svc-tray__go">
              <button class="svc-tray__more" type="button" aria-expanded="false" aria-controls="svc-tray-body" data-svc-more hidden>
                <span class="svc-tray__morel">Review</span><?= svc_icon('arrow', ['class' => 'svc-tray__chev']) ?>
              </button>
              <button class="btn btn--ink svc-tray__btn" type="submit" data-svc-go><span>Continue<span class="svc-tray__btnx"> to contact</span></span><span class="i" aria-hidden="true">›</span></button>
            </div>
          </div>
          <p class="sr" aria-live="polite" data-svc-live></p>
        </div>
        <span class="svc-tray__end" aria-hidden="true" data-svc-end></span>
    </form>

    <?php if ($svc_pks): ?>
      <div class="svc-pk">
        <div class="svc-pk__head" data-rv>
          <div class="svc-pk__ht">
            <p class="svc-pk__k"><span>Engagement packages</span><span class="svc-pk__kc"><?= $svc_two(count($svc_pks)) ?></span></p>
            <p class="svc-pk__t"><span class="g">Ways to engage.</span> Same team, same standard.</p>
          </div>
          <p class="svc-pk__lead">Each package shows how it is priced. Every engagement starts with a written scope and a quote agreed before work begins.</p>
        </div>

        <ul class="svc-pk__row svc-pk__row--<?= count($svc_pks) ?>" aria-label="Engagement packages" data-rv data-svc-in>
          <?php foreach ($svc_pks as $svc_pi => $svc_x): $svc_p = $svc_pk_all[$svc_x]; ?>
            <li class="svc-pkc" style="--i:<?= $svc_pi ?>" data-svc-pkcard="<?= e($svc_x) ?>">
              <div class="svc-pkc__in">
                <div class="svc-pkc__a">
                  <div class="svc-pkc__top">
                    <span class="svc-pkc__ico"><?= svc_icon($svc_p['icon'] ?? 'dot') ?></span>
                    <span class="svc-pkc__idx" aria-hidden="true">P·<?= $svc_two($svc_pi + 1) ?></span>
                    <span class="svc-pkc__sel" data-svc-pksel hidden>In your brief</span>
                  </div>
                  <h3 class="svc-pkc__n"><?= e($svc_p['name']) ?></h3>
                  <p class="svc-pkc__tag"><?= e($svc_p['tagline']) ?></p>
                  <dl class="svc-pkc__dl">
                    <div><dt>Typical length</dt><dd><?= e($svc_p['duration']) ?></dd></div>
                    <div><dt>Pricing</dt><dd><?= e($svc_p['pricing']) ?></dd></div>
                  </dl>
                </div>
                <div class="svc-pkc__b">
                  <p class="svc-pkc__k">Every <?= e(strtolower($svc_p['name'])) ?> includes</p>
                  <ul class="svc-pkc__inc">
                    <?php foreach ($svc_p['includes'] as $svc_y): ?><li><?= e($svc_y) ?></li><?php endforeach; ?>
                  </ul>
                  <p class="svc-pkc__best"><span>Best for</span><?= e($svc_p['best']) ?></p>
                </div>
                <a class="svc-pkc__go" href="<?= e(svc_contact_url([], $svc_x, $svc_key)) ?>" data-svc-pklink="<?= e($svc_x) ?>">
                  <span>Choose <?= e($svc_p['name']) ?></span>
                  <span class="svc-pkc__arrow" aria-hidden="true"><i></i><b>›</b></span>
                </a>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

  </div>
</section>
<?php endif; ?>
