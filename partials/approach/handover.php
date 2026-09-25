<?php /* DRAFT COPY — review before launch */
/* Handover — ownership, stated as an inventory with a transfer moment against each line. The position is
   already on the site ("IP stays yours" on the home page, "You do" in the Technology & Intelligence FAQ);
   this section is where it is made specific enough to check. The photograph is reference imagery reused
   from assets/imgs/tech/hub/ and re-credited in assets/imgs/approach/CREDITS.md. */
$aprh_items = [
    ['code',     'Source code and infrastructure definitions', 'In your repositories from the first commit. There is never a moment where we hold the only copy.', 'From day one'],
    ['layers',   'Design source files and the design system',  'Editable source, not exports. Components, tokens and the rules they came from.',                  'As each part is accepted'],
    ['prompt',   'Prompts, eval sets and model configuration', 'The golden set, the gates, the routing rules. This is what lets you change model without us.',    'As built'],
    ['cloud',    'Cloud accounts and third-party services',    'Created in your name, billed to you, with our access removable in one action.',                   'Before go-live'],
    ['doc',      'Documentation, runbooks and the decision log', 'Why things are the way they are, not only what they are. The log is the part people miss.',      'Written as work lands'],
    ['users',    'Training and named owners',                   'Your people trained on the thing they now own, with a named owner per area, signed off by them.', 'Launch and Run'],
];
$aprh_no = [
    ['No proprietary runtime',      'Nothing we build needs a licence from us to keep running.'],
    ['No hostage credentials',      'You hold the root of every account. Our access is granted, and revocable.'],
    ['No undocumented magic',       'If a thing only one of our engineers understands, it is not finished.'],
    ['No exit fee',                 'Leaving is a handover, not a negotiation.'],
];
$aprh_exit = [
    ['30 days out', 'You tell us, or we tell you. Either way the handover plan is written that week.'],
    ['Weeks 1–2',   'Knowledge-transfer sessions, recorded, with your named owners in the room.'],
    ['Weeks 3–4',   'Your team runs it with us watching, not the other way round.'],
    ['Day 30',      'Our access is revoked, and you sign the handover as complete.'],
];
?>
<section class="band apr-handover" id="handover" aria-labelledby="handover-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Ownership</p>
        <h2 class="h2" id="handover-t"><span class="g">You own the output.</span> Including the parts that are awkward.</h2>
      </div>
      <div>
        <p class="lead">Owning the output means owning the prompts, the eval sets, the infrastructure
          definitions and the reasons behind the decisions, not just the files that look like deliverables.
          Most of it transfers as it is created, because a handover at the end is a handover you have to
          trust.</p>
      </div>
    </div>

    <div class="apr-ho__grid">
      <ul class="apr-ho__items" data-rv-s data-rv-step="60">
        <?php foreach ($aprh_items as $aprh_it): ?>
          <li>
            <span class="apr-ico" aria-hidden="true"><?= xt_icon($aprh_it[0], ['size' => 18]) ?></span>
            <div>
              <h3 class="bdh-t bdh-t--s"><?= e($aprh_it[1]) ?></h3>
              <p class="bdh-d"><?= e($aprh_it[2]) ?></p>
            </div>
            <span class="apr-ho__when"><?= e($aprh_it[3]) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="apr-ho__side">
        <!-- PLACEHOLDER: reference photograph (Unsplash) — replace with commissioned or own imagery
             before launch. Credited in assets/imgs/approach/CREDITS.md. -->
        <figure class="bdh-img bdh-img--r43 apr-ho__img" data-rv>
          <img src="<?= xe_url('assets/imgs/approach/handover-whiteboard.jpg') ?>"
               alt="Two colleagues working through a diagram on a whiteboard"
               width="1400" height="934" loading="lazy" decoding="async">
          <span class="bdh-cap-chip apr-ho__chip"><b>Knowledge transfer</b>Your owners in the room while it still matters</span>
        </figure>

        <div class="apr-ho__no" data-rv data-rv-d="80">
          <p class="apr-k">What we will not do</p>
          <ul>
            <?php foreach ($aprh_no as $aprh_n): ?>
              <li><h3 class="apr-ho__nt"><?= e($aprh_n[0]) ?></h3><p class="bdh-d"><?= e($aprh_n[1]) ?></p></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>

    <div class="apr-ho__exit" data-rv data-rv-d="60">
      <div class="apr-ho__eh">
        <p class="apr-k">If you want to take it in-house</p>
        <h3 class="bdh-t bdh-t--l">A leaving plan, rehearsed like any other release.</h3>
        <p class="bdh-d">This is written into the engagement from the start, because a team that cannot be
          left is a team that will be resented.
          <!-- PLACEHOLDER: confirm the notice period and handover window before launch --></p>
      </div>
      <ol class="apr-ho__steps">
        <?php foreach ($aprh_exit as $aprh_i => $aprh_e): ?>
          <li>
            <span class="bdh-idx"><?= str_pad((string) ($aprh_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <span class="apr-ho__sw"><?= e($aprh_e[0]) ?></span>
            <span class="apr-ho__sd"><?= e($aprh_e[1]) ?></span>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>
