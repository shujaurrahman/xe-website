<?php /* DRAFT COPY — review before launch */
/* Hero — the domain model comes first. A heading row over a full-width entity canvas: eight entities
   (Account, Contact, Opportunity, Order, Case, Product, Event, Consent) with typed fields and crow's-foot
   relations, and the Account record popped out beside them as the form a person would actually use.
   Order and Product meet through the order_lines join table (drawn as a junction chip under them), and
   optional children use zero-or-many. hero.js routes the relations from the untransformed layout, draws them
   in dependency order and runs an order through the model. Without script the cards and their foreign keys
   still read as the model. */
$tcs_hero_ents = [   // key => [label, table, icon, grid order for the reveal, fields [[key, name, type]]]
    'consent'     => ['Consent',     'consents',      'check',    4, [['PK', 'id', 'uuid'], ['FK', 'contact_id', '→ contact'], ['', 'purpose', 'enum'], ['', 'status', 'enum'], ['', 'captured_at', 'timestamptz'], ['', 'source', 'text']]],
    'event'       => ['Event',       'events',        'bolt',     5, [['PK', 'id', 'uuid'], ['FK', 'contact_id', '→ contact'], ['', 'type', 'text'], ['', 'channel', 'enum'], ['', 'occurred_at', 'timestamptz']]],
    'opportunity' => ['Opportunity', 'opportunities', 'target',   2, [['PK', 'id', 'uuid'], ['FK', 'account_id', '→ account'], ['', 'stage', 'enum'], ['', 'amount', 'numeric']]],
    'case'        => ['Case',        'cases',         'headset',  6, [['PK', 'id', 'uuid'], ['FK', 'contact_id', '→ contact'], ['FK', 'order_id', '→ order'], ['', 'priority', 'enum'], ['', 'sla_due_at', 'timestamptz']]],
    'contact'     => ['Contact',     'contacts',      'users',    1, [['PK', 'id', 'uuid'], ['FK', 'account_id', '→ account'], ['', 'email', 'citext · PII'], ['IDX', 'email_sha256', 'text'], ['', 'phone_e164', 'text']]],
    'account'     => ['Account',     'accounts',      'database', 0, [['PK', 'id', 'uuid'], ['', 'name', 'text'], ['', 'tier', 'enum'], ['', 'region', 'text']]],
    'product'     => ['Product',     'products',      'cube',     8, [['PK', 'sku', 'text'], ['', 'name', 'text'], ['', 'price', 'numeric'], ['', 'active', 'boolean']]],
    'order'       => ['Order',       'orders',        'doc',      7, [['PK', 'id', 'uuid'], ['FK', 'account_id', '→ account'], ['', 'total', 'numeric'], ['', 'channel', 'enum'], ['', 'placed_at', 'timestamptz']]],
];
/* [from, side, attach, to, side, attach, start marker, end marker, draw order, label] — attach = fraction along a top/bottom edge.
   'lines' is the order_lines join table: an Order has one or many lines, a Product appears on zero or many. */
$tcs_hero_rels = [
    ['contact', 'r', .5,  'account',     'l', .5,  'many',  'one',   0, ''],
    ['account', 't', .5,  'opportunity', 'b', .5,  'one',   'zmany', 1, ''],
    ['contact', 't', .64, 'event',       'b', .64, 'one',   'zmany', 2, ''],
    ['contact', 't', .22, 'consent',     'b', .5,  'one',   'zmany', 3, ''],
    ['contact', 'l', .5,  'case',        'r', .5,  'one',   'zmany', 4, ''],
    ['account', 'b', .5,  'order',       't', .74, 'one',   'zmany', 5, ''],
    ['case',    'b', .5,  'order',       't', .26, 'zmany', 'zone',  6, ''],
    ['order',   'b', .5,  'lines',       'r', .5,  'one',   'many',  7, ''],
    ['lines',   'l', .5,  'product',     'b', .5,  'zmany', 'one',   8, ''],
];
$tcs_hero_mk = [   // marker id => drawing, tip of the marker at x = 16 (the entity edge)
    'one'   => '<path d="M0 6H16M9 1v10M12.5 1v10"/>',
    'many'  => '<path d="M0 6H16M5 6 16 .5M5 6 16 11.5M4 1v10"/>',
    'zmany' => '<path d="M5.5 6H16M8 6 16 .5M8 6 16 11.5"/><circle cx="3" cy="6" r="2.5"/>',
    'zone'  => '<path d="M5.5 6H16M11 1v10"/><circle cx="3" cy="6" r="2.5"/>',
];
$tcs_hero_mk_name = ['one' => 'exactly one', 'many' => 'one or many', 'zmany' => 'zero or many', 'zone' => 'zero or one'];
/* the meta strip labels its values, so a value that repeats its label ("… to first release") is trimmed here */
$tcs_hero_meta = array_map(fn ($v) => preg_replace('~\s+to first release$~u', '', (string) $v), $CAP['meta']);
?>
<section class="band tcs-hero" id="hero" aria-labelledby="hero-t">
  <div class="wrap">
    <nav class="tcs-crumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="<?= xe_url('services/') ?>">Services</a></li>
        <li><a href="<?= xe_url('services/technology-intelligence.php') ?>"><?= e($TECH['name'] ?? 'Technology & Intelligence') ?></a></li>
        <li><span aria-current="page"><?= e($CAP['name']) ?></span></li>
      </ol>
    </nav>

    <div class="tcs-hero__top">
      <div class="tcs-hero__h">
        <p class="tcs-eb"><span class="tcs-eb__g" aria-hidden="true"></span>Capability <?= e($CAP['n']) ?> of <?= count($TI) ?><span class="tcs-hero__ebx"> · Built around how you run</span></p>
        <h1 class="tcs-hero__t" id="hero-t"><span class="g">Your business, modelled once,</span> then run on software that fits.</h1>
      </div>
      <div class="tcs-hero__side">
        <p class="lead tcs-hero__lead"><?= e($CAP_ROW[1] ?? '') ?> We start from your domain model, the accounts, orders, cases and consents your teams handle every day, and build the systems on top of it in your cloud, under your ownership.</p>
        <div class="tcs-hero__act">
          <a class="btn btn--ink btn--lg" href="<?= xe_url('contact.php') ?>"><?= e($CAP['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
          <a class="btn btn--out btn--lg" href="#stitcher">See the stitcher <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>
    </div>

    <div class="tcs-erd" data-rv>
      <div class="tcs-erd__bar">
        <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="tcs-erd__path">model <i>/</i> your-company <i>/</i> <b>core-domain</b></span>
        <span class="tcs-erd__ver" aria-hidden="true">v12 · 8 entities · 1 join table · 9 relations</span>
        <span class="tcs-erd__run" aria-hidden="true"><i class="bdh-pulse"></i><span data-erd-status>Order flowing through the model</span></span>
        <button type="button" class="tcs-erd__pause" data-erd-pause aria-pressed="false" hidden>Pause motion</button>
      </div>

      <div class="tcs-erd__canvas dots">
        <svg class="tcs-erd__svg" aria-hidden="true" focusable="false">
          <defs>
            <?php foreach ($tcs_hero_mk as $tcs_hero_k => $tcs_hero_d): ?>
              <marker id="tcs-mk-<?= $tcs_hero_k ?>" class="tcs-erd__mk" viewBox="0 0 16 12" refX="16" refY="6" markerWidth="16" markerHeight="12" markerUnits="userSpaceOnUse" orient="auto-start-reverse"><?= $tcs_hero_d ?></marker>
            <?php endforeach; ?>
          </defs>
          <?php foreach ($tcs_hero_rels as $tcs_hero_r): ?>
            <path class="tcs-erd__rel" pathLength="1" style="--i:<?= (int) $tcs_hero_r[8] ?>" data-from="<?= $tcs_hero_r[0] ?>" data-fs="<?= $tcs_hero_r[1] ?>" data-fa="<?= $tcs_hero_r[2] ?>" data-to="<?= $tcs_hero_r[3] ?>" data-ts="<?= $tcs_hero_r[4] ?>" data-ta="<?= $tcs_hero_r[5] ?>" marker-start="url(#tcs-mk-<?= $tcs_hero_r[6] ?>)" marker-end="url(#tcs-mk-<?= $tcs_hero_r[7] ?>)"/>
            <?php if ($tcs_hero_r[9] !== ''): ?><text class="tcs-erd__lbl" data-label-for="<?= $tcs_hero_r[0] ?>-<?= $tcs_hero_r[3] ?>" text-anchor="middle"><?= e($tcs_hero_r[9]) ?></text><?php endif; ?>
          <?php endforeach; ?>
          <path class="tcs-erd__lead" data-from="account" data-fs="r" data-to="rec" data-ts="l"/>
        </svg>

        <div class="tcs-erd__ents">
          <?php foreach ($tcs_hero_ents as $tcs_hero_k => $tcs_hero_e): ?>
            <article class="tcs-ent" data-ent="<?= $tcs_hero_k ?>" style="--i:<?= (int) $tcs_hero_e[3] ?>" aria-label="Entity <?= e($tcs_hero_e[0]) ?>">
              <header class="tcs-ent__h"><?= xt_icon($tcs_hero_e[2], ['mono' => true]) ?><b class="tcs-ent__t"><?= e($tcs_hero_e[0]) ?></b><span class="tcs-ent__tb"><?= e($tcs_hero_e[1]) ?></span></header>
              <ul class="tcs-ent__f">
                <?php foreach ($tcs_hero_e[4] as $tcs_hero_f): ?>
                  <li data-field="<?= e($tcs_hero_f[1]) ?>"><?php if ($tcs_hero_f[0] !== ''): ?><i class="tcs-k<?= $tcs_hero_f[0] === 'FK' ? ' tcs-k--fk' : '' ?>"><?= e($tcs_hero_f[0]) ?></i><?php else: ?><i></i><?php endif; ?><span><?= e($tcs_hero_f[1]) ?></span><em><?= e($tcs_hero_f[2]) ?></em></li>
                <?php endforeach; ?>
              </ul>
            </article>
          <?php endforeach; ?>

          <div class="tcs-erd__legend" aria-hidden="true" style="--i:9">
            <p class="tcs-erd__lk">Notation</p>
            <ul class="tcs-erd__keys">
              <?php foreach ($tcs_hero_mk as $tcs_hero_k => $tcs_hero_d): ?>
                <li><svg viewBox="0 0 16 12" width="22" height="16"><g class="tcs-erd__mk"><?= $tcs_hero_d ?></g></svg><?= e($tcs_hero_mk_name[$tcs_hero_k]) ?></li>
              <?php endforeach; ?>
            </ul>
            <dl class="tcs-erd__health">
              <div><dt>Migrations</dt><dd>v12 applied</dd></div>
              <div><dt>Orphaned keys</dt><dd>0</dd></div>
              <div><dt>Row-level policies</dt><dd>6</dd></div>
            </dl>
          </div>
        </div>

        <div class="tcs-erd__rec" data-ent="rec">
          <div class="tcs-rec" aria-hidden="true">
            <div class="tcs-rec__bar">
              <span class="tcs-rec__crumb">Record <i>›</i> Account <i>›</i> <b>Your company</b></span>
              <span class="tcs-st tcs-st--ok" data-rec-state>Synced</span>
            </div>
            <div class="tcs-rec__tabs"><span class="is-on">Details</span><span>Contacts <i>4</i></span><span>Orders <i data-rec-orders>12</i></span><span>Consent</span></div>
            <div class="tcs-rec__form">
              <div class="tcs-rec__row"><span class="tcs-rec__l">Name</span><span class="tcs-rec__in"><span data-rec-type>Your company</span></span></div>
              <div class="tcs-rec__row"><span class="tcs-rec__l">Tier</span><span class="tcs-rec__in tcs-rec__sel"><span data-rec-type>Enterprise</span></span></div>
              <div class="tcs-rec__row tcs-rec__row--2">
                <div><span class="tcs-rec__l">Region</span><span class="tcs-rec__in"><span data-rec-type>APAC · West</span></span></div>
                <div><span class="tcs-rec__l">Owner team</span><span class="tcs-rec__in"><span data-rec-type>Key accounts</span></span></div>
              </div>
              <div class="tcs-rec__row"><span class="tcs-rec__l">Health score</span><span class="tcs-rec__bar2"><i style="--v:.82"></i><b>82</b></span></div>
            </div>
            <dl class="tcs-rec__rel">
              <div><dt>Open opportunities</dt><dd>2</dd></div>
              <div><dt>Open cases</dt><dd>1</dd></div>
              <div><dt>Last order</dt><dd data-rec-last>ORD-48213 · 2 h ago</dd></div>
            </dl>
            <p class="tcs-rec__foot"><i class="tcs-k">RLS</i><span>region = 'APAC' · role key_accounts</span></p>
          </div>
        </div>

        <div class="tcs-erd__jn" data-jn="lines" aria-hidden="true"><?= xt_icon('link', ['size' => 13, 'mono' => true]) ?><b>order_lines</b><span>order_id · sku · qty</span></div>
        <span class="tcs-erd__dot" aria-hidden="true"></span>
      </div>

      <!-- PLACEHOLDER: confirm the typical first-release timeframe before launch -->
      <dl class="tcs-erd__meta">
        <?php foreach ($tcs_hero_meta as $tcs_hero_i => $tcs_hero_m): ?>
          <div><dt><?= e($CAP['meta_k'][$tcs_hero_i] ?? '') ?></dt><dd><?= e($tcs_hero_m) ?></dd></div>
        <?php endforeach; ?>
        <div class="tcs-erd__ill"><span class="bdh-ill">Illustrative model</span></div>
      </dl>
    </div>
    <p class="bdh-sr">An illustrative domain model for “Your company”: eight entities. An Account has one or more Contacts and any number of Opportunities and Orders. A Contact has any number of Events, Consents and Cases, and keeps both a deliverable email and a hashed email used for matching. Each Order has one or more order lines, each naming one Product, and a Case may refer to one Order. Beside the model, the same Account is shown as the record form a person would use, with its tier, region, owner team, health score and latest order.</p>
  </div>
</section>
