<?php /* DRAFT COPY — review before launch */
/* Deliver — what you actually hold at the end. $CAP['deliver'] supplies the item and its format
   chip; the table below adds a mark and a purpose to each one, because a deliverable list with no
   purpose beside it reads like a contents page and with no mark beside it reads like a bullet
   list. Seven artefacts plus a closing tile fill the four-column grid exactly, so no cell is left
   standing empty. Repository ownership is stated plainly: the connectors are yours. Stagger reveal
   only, no JS of its own. */
/* item name => [icon, what the artefact is for] */
$tis_dl_note = [
    'Integration architecture & data flow map' => ['network', 'Every system, every flow, the direction of truth for each field, and the owner of each one. The document the next engineer reads first.'],
    'API specifications & developer docs'      => ['api', 'OpenAPI 3.1 and AsyncAPI definitions in your repository, published to a portal your own teams and vendors can read.'],
    'Integrations with monitoring & alerting'  => ['plug', 'The connectors themselves, in your source control, with dashboards and alert rules committed beside the code.'],
    'Contract & regression test suites'        => ['eval', 'Consumer-driven contract tests that run in CI, so a vendor schema change fails a pipeline instead of a customer order.'],
    'Support model & service levels'           => ['handshake', 'Severity definitions, response and restore targets, escalation path and named contacts, agreed before go-live.'],
    'Runbooks & on-call rota'                  => ['headset', 'One page per failure mode: what the alert means, how to confirm it, how to fix it, and when to escalate.'],
    'Monthly service report'                   => ['chart', 'Sync success, freshness, incidents, what we changed, and the improvement backlog for the month ahead.'],
];
$tis_dl_own = [
    ['git-branch', 'Everything lands in your repositories', 'Connector code, infrastructure definitions, tests and alert rules are committed to repositories you own from the first week, not handed over at the end.'],
    ['key',        'Credentials stay in your vault',        'Vendor keys and OAuth clients are issued in your accounts and stored in your secret manager. We hold scoped access that you can revoke in one action.'],
    ['doc',        'Written so someone else can take over', 'Runbooks, decision records and the integration map are maintained as the system changes, which is what makes support transferable.'],
];
?>
<section class="band tis-dl" id="deliver" aria-labelledby="deliver-t">
  <div class="wrap">

    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tis-kick"><b>$ ls artefacts/</b> <span>7 artefacts · all in your repositories</span></p>
        <h2 class="h2" id="deliver-t"><span class="g">What you get,</span> and what it is for.</h2>
      </div>
      <div>
        <p class="lead">An integration you cannot see into is a liability. These are the artefacts that make yours legible: to your team, to a new vendor, and to whoever is on call at three in the morning.</p>
      </div>
    </div>

    <ol class="tis-dl__grid" role="list" data-rv data-bdh-stagger>
      <?php foreach ($CAP['deliver'] as $tis_dl_i => $tis_dl_d): $tis_dl_n = $tis_dl_note[$tis_dl_d[0]] ?? null; ?>
        <li class="tis-dl__item" style="--i:<?= (int) $tis_dl_i ?>">
          <p class="tis-dl__top">
            <span class="tis-dl__ico" aria-hidden="true"><?= xt_icon($tis_dl_n[0] ?? 'doc', ['size' => 20]) ?></span>
            <span class="bdh-idx"><?= e(str_pad((string) ($tis_dl_i + 1), 2, '0', STR_PAD_LEFT)) ?></span>
          </p>
          <h3 class="bdh-t tis-dl__t"><?= e($tis_dl_d[0]) ?></h3>
          <?php if ($tis_dl_n): ?>
            <p class="bdh-d"><?= e($tis_dl_n[1]) ?></p>
          <?php endif; ?>
          <p class="tis-dl__fmt"><span class="bdh-tag"><?= e($tis_dl_d[1]) ?></span></p>
        </li>
      <?php endforeach; ?>
      <li class="tis-dl__item tis-dl__item--end" style="--i:<?= count($CAP['deliver']) ?>">
        <p class="tis-dl__top">
          <span class="tis-dl__ico" aria-hidden="true"><?= xt_icon('git-branch', ['size' => 20, 'mono' => true]) ?></span>
        </p>
        <h3 class="bdh-t tis-dl__t">Every one of them is yours</h3>
        <p class="bdh-d">All seven land in repositories and accounts you own, from the first week rather than at the end. Nothing on this list is held back as leverage.</p>
        <p class="tis-dl__fmt"><a class="tis-dl__cta" href="<?= e(xe_url('contact.php')) ?>"><?= e($CAP['cta']) ?> <span class="i" aria-hidden="true">&rsaquo;</span></a></p>
      </li>
    </ol>

    <div class="tis-dl__own" data-rv>
      <?php foreach ($tis_dl_own as $tis_dl_o): ?>
        <div class="tis-dl__ownc">
          <span class="tis-dl__owni" aria-hidden="true"><?= xt_icon($tis_dl_o[0], ['size' => 20]) ?></span>
          <h3 class="bdh-t"><?= e($tis_dl_o[1]) ?></h3>
          <p class="bdh-d"><?= e($tis_dl_o[2]) ?></p>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>
