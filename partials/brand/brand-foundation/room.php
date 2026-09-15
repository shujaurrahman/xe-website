<?php /* DRAFT COPY — review before launch */
/* §10 Outcomes — "What changes in the room": each $BD outcome as a before/after pair of remarks.
   The before line is struck through as it scrolls in; the after line is written in its place.
   Remarks are illustrative composites of what gets said, not quotations from clients. */
$cbf_room_pairs = [   // per $BD outcome: [before, after]
    ['It depends who you ask. Sales would say one thing, product another.', 'We are the finance record that makes every figure traceable.'],
    ['Let’s take it offline and come back to it next quarter.', 'Rule two says we do not discount. We decline and make a counter-offer.'],
    ['Can someone send the agency the strategy deck? Which version is current?', 'The brief starts from page one of the foundation. Version 1.0.'],
];
?>
<section class="band band--alt cbf-room" id="outcomes" aria-labelledby="outcomes-t">
  <div class="wrap">
    <header class="cbf-head cbf-head--split" data-rv>
      <p class="cbf-head__sec"><b>§ 10</b>Outcomes</p>
      <div class="cbf-head__body">
        <h2 class="h2" id="outcomes-t"><span class="g">What changes</span> in the room.</h2>
        <p class="lead">A foundation is working when the conversation changes. These are the kinds of remarks that disappear, and what replaces them.</p>
      </div>
    </header>

    <div class="cbf-room__grid">
      <!-- PLACEHOLDER: reference photo (Unsplash) — replace with own documentary photography before launch -->
      <figure class="cbf-plate cbf-room__plate" data-rv>
        <div class="cbf-plate__img"><img src="<?= xe_url('assets/imgs/brand/brand-foundation/room-workshop.jpg') ?>" alt="Hands resting on printed pages around a meeting table during a working session" width="1400" height="930" loading="lazy" decoding="async"></div>
        <figcaption><b>Plate 4</b><span>A working session in week three. Short, small, and argued rather than presented.</span></figcaption>
      </figure>

      <!-- PLACEHOLDER: illustrative remarks, not client quotations — confirm before launch -->
      <ol class="cbf-room__list">
        <?php foreach ($CAP['outcomes'] as $cbf_i => $cbf_o): $cbf_p = $cbf_room_pairs[$cbf_i] ?? ['', '']; ?>
          <li class="cbf-room__row" data-cbf-room>
            <div class="cbf-room__what">
              <span class="cbf-room__n">0<?= $cbf_i + 1 ?></span>
              <h3 class="cbf-room__h"><?= e($cbf_o[0]) ?></h3>
              <p class="cbf-room__d"><?= e($cbf_o[1]) ?></p>
            </div>
            <div class="cbf-room__pair">
              <blockquote class="cbf-room__q cbf-room__q--before"><p class="cbf-room__k">Before</p><p class="cbf-room__t"><span class="bdh-sr">Heard before: </span><span class="cbf-room__s">“<?= e($cbf_p[0]) ?>”</span></p></blockquote>
              <blockquote class="cbf-room__q cbf-room__q--after"><p class="cbf-room__k">After</p><p class="cbf-room__t"><span class="bdh-sr">Heard after: </span>“<?= e($cbf_p[1]) ?>”</p></blockquote>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
    <p class="cbf-room__ill"><span class="cbf-ill">Illustrative</span> Composite remarks written to show the change. They are not quotations.</p>
  </div>
</section>
