<?php /* DRAFT COPY — review before launch */
/* 05 SIGNATURE — the Profile Stitcher. A step-through identity resolution engine: eight raw events from Web,
   App, Store POS, Support desk and Email, each carrying identifiers (cookie, device, hashed email, phone,
   loyalty ID). Each step redraws the identity graph, the golden profile, segment membership and activation to
   four destinations. Match rules switch between deterministic only and deterministic plus probabilistic
   (merge at confidence ≥ 0.85, steward review below). Withdrawing marketing consent blocks the marketing
   destinations with a logged reason. All data is fictional. The HTML is the finished run (8 of 8 events,
   probabilistic on, consent granted, one merge waiting for the data steward); stitcher.js runs the engine. */
$tcs_st_nodes = [   // key => [type label, value, graph glyph, final x, final y]
    'ck1' => ['Cookie',        'ck_7f3a',        'ck', 118, 118],
    'em'  => ['Email SHA-256', '9b2e…41',        '@',  262, 58],
    'dv'  => ['Device',        'dv_19c2',        'dv', 404, 116],
    'ph'  => ['Phone',         '+91 •• 4471',    'ph', 432, 262],
    'ly'  => ['Loyalty',       'L-20931',        'ly', 300, 346],
    'ck2' => ['Cookie',        'ck_d201',        'ck', 118, 272],
    'ck3' => ['Cookie',        'ck_e913',        'ck', 176, 396],
];
$tcs_st_events = [   // [time, channel, icon, event, identifiers [node keys], detail]
    ['09:12', 'Web',          'browser',  'product_view',       ['ck1'],        '/products/p-2231'],
    ['09:14', 'Web',          'browser',  'newsletter_signup',  ['ck1', 'em'],  'form · marketing consent'],
    ['11:40', 'App',          'mobile',   'login',              ['dv', 'em'],   'verified email'],
    ['13:05', 'Store POS',    'pin',      'purchase',           ['ly', 'ph'],   '4,850 · Store 014'],
    ['16:22', 'Support desk', 'headset',  'ticket_opened',      ['em', 'ph'],   'delivery question'],
    ['19:48', 'Web',          'browser',  'product_view',       ['ck2'],        'device + network signals'],
    ['21:03', 'Email',        'link',     'campaign_click',     ['em'],         'Autumn range'],
    ['22:17', 'Web',          'browser',  'add_to_cart',        ['ck3'],        'weak signals'],
];
$tcs_st_segments = [   // [key, name, rule]
    ['known',   'Known contacts',        'verified email'],
    ['store',   'Store buyers · 30 days', 'POS purchase'],
    ['case',    'Open support case',     'ticket status open'],
    ['intent',  'High intent · 24 h',     '≥ 2 product views'],
    ['engaged', 'Email engaged · 7 days', 'click or reply'],
];
$tcs_st_dest = [   // [key, logo slug (or icon:name where the library has no licence-clean mark), name, use, purpose, final status, final detail, fields sent, final purpose check]
    ['sf', 'icon:cloud', 'Salesforce', 'CRM · sales and service',     'Service',   'ok',   'Contact + open case · 16:22',   'email, phone, open case',     'Lawful basis: contract'],
    ['hs', 'hubspot',    'HubSpot',    'Marketing email',             'Marketing', 'ok',   'List: Email engaged · 21:03',   'email, list membership',      'Consent granted · 09:14'],
    ['ga', 'google',     'Google Ads', 'Customer Match',              'Marketing', 'ok',   'Audience: High intent · 19:48', 'email_sha256 only',           'Consent granted · 09:14'],
    ['mt', 'meta',       'Meta',       'Custom Audiences',            'Marketing', 'ok',   'Exclude: recent store buyers',  'email_sha256 only',           'Consent granted · 09:14'],
];
$tcs_st_channels = [['Web', 'browser'], ['App', 'mobile'], ['Store', 'pin'], ['Support', 'headset'], ['Email', 'link']];
$tcs_st_data = [
    'nodes'  => array_map(fn ($n) => ['type' => $n[0], 'value' => $n[1], 'x' => $n[3], 'y' => $n[4]], $tcs_st_nodes),
    'events' => array_map(fn ($ev) => ['t' => $ev[0], 'ch' => $ev[1], 'ev' => $ev[3], 'ids' => $ev[4], 'd' => $ev[5]], $tcs_st_events),
];
?>
<section class="band band--ink tcs-stitcher" id="stitcher" aria-labelledby="stitcher-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tcs-eb"><span class="tcs-eb__g" aria-hidden="true"></span>Signature · the Profile Stitcher</p>
        <h2 class="h2" id="stitcher-t"><span class="g">Eight events, one customer.</span> Stitched, consented and activated.</h2>
      </div>
      <div>
        <p class="lead">A customer data platform is an identity engine before it is anything else. Step through a day of events from five channels and watch them resolve into one golden profile, under match rules you can change and a consent gate you can pull.</p>
      </div>
    </div>

    <div class="tcs-sx" data-rv data-sx='<?= e(json_encode($tcs_st_data, JSON_UNESCAPED_UNICODE)) ?>' data-step="8" data-prob="1" data-consent="granted">
      <p class="bdh-sr">Interactive demonstration with fictional data. Use Next event, Play all or Reset to step through eight events. Switch the match rules between deterministic only and deterministic plus probabilistic, and switch marketing consent to withdrawn. The status line below the controls announces each change; the profile, segments, destinations and steward queue update to match.</p>

      <div class="bdh-ui bdh-ui--ink tcs-sx__win">
        <div class="bdh-ui__bar">
          <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
          <span class="tcs-sx__title">cdp <i>/</i> <span class="tcs-sx__tm">identity-resolution <i>/</i> </span>Your company</span>
          <span class="tcs-sx__live"><i class="bdh-pulse" aria-hidden="true"></i>Fictional data</span>
        </div>

        <div class="tcs-sx__tool">
          <div class="tcs-sx__run">
            <button type="button" class="tcs-btn tcs-btn--pri" data-sx-next aria-disabled="true"><?= xt_icon('bolt', ['mono' => true]) ?>Next event</button>
            <button type="button" class="tcs-btn" data-sx-play>Play all</button>
            <button type="button" class="tcs-btn" data-sx-reset><?= xt_icon('rollback', ['mono' => true]) ?>Reset</button>
            <span class="tcs-sx__count" aria-hidden="true"><b data-sx-n>8</b> / 8</span>
          </div>
          <div class="tcs-sx__rules">
            <div class="tcs-sx__rule">
              <span class="tcs-sx__rk" id="sx-rules-l">Match rules</span>
              <div class="bdh-seg" role="radiogroup" aria-labelledby="sx-rules-l">
                <button type="button" role="radio" aria-checked="false" data-sx-prob="0">Deterministic only</button>
                <button type="button" role="radio" aria-checked="true" data-sx-prob="1">+ Probabilistic ≥ 0.85</button>
              </div>
            </div>
            <button type="button" class="bdh-switch tcs-sx__consent" aria-pressed="false" data-sx-consent><span class="bdh-switch__track" aria-hidden="true"></span>Marketing consent withdrawn</button>
          </div>
        </div>
        <p class="tcs-sx__status" aria-live="polite" data-sx-status>Event 8 of 8 · Web add_to_cart · ck_e913 scored 0.72, below 0.85 · queued for data steward review</p>

        <div class="tcs-sx__main">
          <!-- event stream -->
          <div class="tcs-sx__col tcs-sx__stream">
            <p class="tcs-sx__h"><span>Event stream</span><em>5 channels</em></p>
            <ol class="tcs-sx__evs">
              <?php foreach ($tcs_st_events as $tcs_st_i => $tcs_st_ev): ?>
                <li class="tcs-sx__ev is-done<?= $tcs_st_i === 7 ? ' is-cur' : '' ?>" data-ev="<?= $tcs_st_i + 1 ?>">
                  <button type="button" class="tcs-sx__evb" data-sx-goto="<?= $tcs_st_i + 1 ?>"<?= $tcs_st_i === 7 ? ' aria-current="step"' : '' ?>>
                    <span class="tcs-sx__evi"><?= xt_icon($tcs_st_ev[2], ['size' => 16, 'mono' => true]) ?></span>
                    <span class="tcs-sx__evt"><b><?= e($tcs_st_ev[1]) ?></b><time><?= e($tcs_st_ev[0]) ?></time></span>
                    <span class="tcs-sx__evn"><?= e($tcs_st_ev[3]) ?><em> · <?= e($tcs_st_ev[5]) ?></em></span>
                    <span class="tcs-sx__ids"><?php foreach ($tcs_st_ev[4] as $tcs_st_k): ?><i><?= e($tcs_st_nodes[$tcs_st_k][2]) ?> <?= e($tcs_st_nodes[$tcs_st_k][1]) ?></i><?php endforeach; ?></span>
                  </button>
                </li>
              <?php endforeach; ?>
            </ol>
          </div>

          <!-- identity graph -->
          <div class="tcs-sx__col tcs-sx__graph">
            <p class="tcs-sx__h"><span>Identity graph</span><em data-sx-graphnote>7 identifiers · 1 profile · 1 in review</em></p>
            <svg class="tcs-sg" viewBox="0 0 560 440" aria-hidden="true" focusable="false">
              <g class="tcs-sg__rings"><circle cx="262" cy="222" r="120"/><circle cx="262" cy="222" r="200"/></g>
              <?php foreach ($tcs_st_nodes as $tcs_st_k => $tcs_st_nd): $tcs_st_p = in_array($tcs_st_k, ['ck2', 'ck3'], true); ?>
                <line class="tcs-sg__e<?= $tcs_st_p ? ' is-prob' : '' ?><?= $tcs_st_k === 'ck3' ? ' is-review' : '' ?>" data-e="<?= $tcs_st_k ?>" x1="<?= $tcs_st_nd[3] ?>" y1="<?= $tcs_st_nd[4] ?>" x2="262" y2="222"/>
              <?php endforeach; ?>
              <text class="tcs-sg__el" data-el="ck2" x="190" y="240">0.91</text>
              <text class="tcs-sg__el is-review" data-el="ck3" x="232" y="318">0.72 · review</text>
              <g class="tcs-sg__h tcs-sg__h--b is-gone" data-h="B" transform="translate(470 330)"><circle r="24"/><text class="tcs-sg__ht" y="4">P-0002</text></g>
              <g class="tcs-sg__h tcs-sg__h--a" data-h="A" transform="translate(262 222)"><circle class="tcs-sg__pulse" r="30"/><circle r="30"/><text class="tcs-sg__ht" y="4">P-0001</text><text class="tcs-sg__hl" y="50">golden profile</text></g>
              <?php foreach ($tcs_st_nodes as $tcs_st_k => $tcs_st_nd): ?>
                <g class="tcs-sg__n<?= $tcs_st_k === 'ck3' ? ' is-orphan is-review' : '' ?>" data-n="<?= $tcs_st_k ?>" transform="translate(<?= $tcs_st_nd[3] ?> <?= $tcs_st_nd[4] ?>)">
                  <circle r="17"/><text class="tcs-sg__nt" y="3.5"><?= e($tcs_st_nd[2]) ?></text><text class="tcs-sg__nl" y="33"><?= e($tcs_st_nd[1]) ?></text>
                </g>
              <?php endforeach; ?>
              <text class="tcs-sg__empty" x="262" y="226">Waiting for the first event</text>
            </svg>
            <ul class="tcs-sx__legend" aria-hidden="true">
              <li><i class="is-det"></i>Deterministic link</li><li><i class="is-prob"></i>Probabilistic link</li><li><i class="is-orph"></i>Unresolved</li>
            </ul>
          </div>

          <!-- golden profile + segments -->
          <div class="tcs-sx__col tcs-sx__profile">
            <p class="tcs-sx__h"><span>Golden profile</span><em data-sx-pstate>Known</em></p>
            <div class="tcs-sx__pc">
              <div class="tcs-sx__pid"><span class="tcs-sx__av"><?= xt_icon('users', ['size' => 18, 'mono' => true]) ?></span><div><b data-sx-pid>P-0001</b><span data-sx-ids>6 identifiers linked</span></div></div>
              <dl class="tcs-sx__traits">
                <div><dt>Email</dt><dd data-sx-t="email">9b2e…41 · verified at login</dd></div>
                <div><dt>Phone</dt><dd data-sx-t="phone">+91 ••••• 4471</dd></div>
                <div><dt>Loyalty</dt><dd data-sx-t="loyalty">L-20931 · Silver</dd></div>
                <div><dt>Lifetime value</dt><dd data-sx-t="ltv">4,850</dd></div>
                <div><dt>Last seen</dt><dd data-sx-t="seen">21:03 · Email</dd></div>
                <div><dt>Marketing consent</dt><dd data-sx-t="consent">Granted · 09:14 · signup form</dd></div>
              </dl>
              <ul class="tcs-sx__ch" aria-label="Channels seen">
                <?php foreach ($tcs_st_channels as $tcs_st_c): ?>
                  <li class="is-on" data-sx-ch="<?= e($tcs_st_c[0]) ?>"><?= xt_icon($tcs_st_c[1], ['size' => 14, 'mono' => true]) ?><?= e($tcs_st_c[0]) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <p class="tcs-sx__h tcs-sx__h--sub"><span>Segments</span><em data-sx-segn>5 of 5</em></p>
            <ul class="tcs-sx__segs">
              <?php foreach ($tcs_st_segments as $tcs_st_s): ?>
                <li class="is-in" data-sx-seg="<?= $tcs_st_s[0] ?>"><b><?= e($tcs_st_s[1]) ?></b><span><?= e($tcs_st_s[2]) ?></span><i data-sx-segs>In</i></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>

        <div class="tcs-sx__foot">
          <div class="tcs-sx__col tcs-sx__dests">
            <p class="tcs-sx__h"><span>Activation</span><em>consent checked per purpose, every sync</em></p>
            <ul class="tcs-sx__dl">
              <?php foreach ($tcs_st_dest as $tcs_st_d): ?>
                <li class="tcs-sx__d is-ok" data-sx-d="<?= $tcs_st_d[0] ?>">
                  <span class="tcs-sx__pipe" aria-hidden="true"><i></i></span>
                  <span class="tcs-sx__dlogo"><?= str_starts_with($tcs_st_d[1], 'icon:') ? xt_icon(substr($tcs_st_d[1], 5), ['size' => 20, 'mono' => true]) : xt_logo($tcs_st_d[1], ['size' => 20, 'hidden' => true]) ?></span>
                  <span class="tcs-sx__dn"><b><?= e($tcs_st_d[2]) ?></b><span><?= e($tcs_st_d[3]) ?></span></span>
                  <span class="tcs-sx__dp">Purpose · <?= e($tcs_st_d[4]) ?></span>
                  <span class="tcs-sx__df"><em>Sends</em><?= e($tcs_st_d[7]) ?></span>
                  <span class="tcs-sx__dg" data-sx-dg data-state="ok"><?= xt_icon('shield', ['size' => 13, 'mono' => true]) ?><span data-sx-dgt><?= e($tcs_st_d[8]) ?></span></span>
                  <span class="tcs-st tcs-st--ok" data-sx-ds>Synced</span>
                  <span class="tcs-sx__dd" data-sx-dd><?= e($tcs_st_d[6]) ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

          <div class="tcs-sx__col tcs-sx__side">
            <p class="tcs-sx__h"><span>Data steward queue</span><em data-sx-qn>1 waiting</em></p>
            <div class="tcs-sx__q" data-sx-q>
              <div class="tcs-sx__qi">
                <p class="tcs-sx__qt"><b>ck_e913</b> → P-0001<span class="tcs-sx__score">0.72 <small>/ 0.85</small></span></p>
                <p class="tcs-sx__qs">Same /24 network · similar session path · different browser</p>
                <div class="tcs-sx__qa">
                  <button type="button" class="tcs-btn tcs-btn--pri" data-sx-decide="merge">Approve merge</button>
                  <button type="button" class="tcs-btn" data-sx-decide="keep">Keep separate</button>
                </div>
              </div>
              <p class="tcs-sx__qe">Nothing waiting. Matches that score below 0.85 land here for a person to decide.</p>
            </div>
            <p class="tcs-sx__h tcs-sx__h--sub"><span>Resolution log</span><em>append-only</em></p>
            <ol class="tcs-sx__log" data-sx-log>
              <li><time>22:17:03</time><span>merge.queued ck_e913 → P-0001 · 0.72 &lt; 0.85</span></li>
              <li><time>21:03:40</time><span>event.attached campaign_click → P-0001</span></li>
              <li><time>19:48:26</time><span>identity.linked ck_d201 → P-0001 · 0.91 · probabilistic</span></li>
              <li><time>16:22:09</time><span>profile.merged P-0002 → P-0001 · email + phone</span></li>
              <li><time>13:05:51</time><span>profile.created P-0002 · loyalty + phone</span></li>
            </ol>
          </div>
        </div>
      </div>

      <div class="tcs-sx__explain">
        <div class="tcs-sx__x">
          <span class="tcs-sx__xi"><?= xt_icon('key', ['size' => 22]) ?></span>
          <h3 class="tcs-sx__xt">Deterministic first</h3>
          <p>Exact keys join records: a verified login, a hashed email, a loyalty ID, a phone number in E.164. These merges are safe to automate and easy to explain.</p>
        </div>
        <div class="tcs-sx__x">
          <span class="tcs-sx__xi"><?= xt_icon('eval', ['size' => 22]) ?></span>
          <h3 class="tcs-sx__xt">Probabilistic, with a threshold</h3>
          <p>Device, network and behaviour signals are scored. Above the agreed threshold the link is made and marked as inferred; below it, a data steward decides. Survivorship rules pick which value wins: verified beats typed, recent beats old.</p>
        </div>
        <div class="tcs-sx__x">
          <span class="tcs-sx__xi"><?= xt_icon('shield', ['size' => 22]) ?></span>
          <h3 class="tcs-sx__xt">Consent is a hard gate</h3>
          <p>Consent is stored per purpose and checked at every activation, not once at collection. A withdrawal stops marketing syncs within minutes and is logged with the rule it applied.</p>
          <ul class="tcs-sx__laws" role="list"><?= xt_badge('gdpr', ['variant' => 'chip', 'tag' => 'li']) ?><?= xt_badge('dpdp', ['variant' => 'chip', 'tag' => 'li']) ?></ul>
        </div>
      </div>
    </div>
  </div>
</section>
