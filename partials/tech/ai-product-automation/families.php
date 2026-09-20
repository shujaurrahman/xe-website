<?php /* DRAFT COPY — review before launch */
/* Families — the four kinds of AI feature, as tall cards: a photograph, a code-built capability strip that
   plays once on entry and on hover (a citation lights, a waveform moves, a box draws, a node fires), what it
   is typically used for, and the metric it moves. Below: the two capabilities every family shares. */
$tapf_cards = [
    [
        'key' => 'knowledge', 'n' => '01', 'title' => 'Knowledge & RAG', 'icon' => 'doc', 'img' => 'family-knowledge.jpg', 'pos' => '50% 50%',
        'alt' => 'A long library aisle lined with shelves of bound volumes',
        'desc' => 'Answers grounded in your documents, with citations a person can check and access that follows each user’s permissions.',
        'uses' => ['Policy and product assistants for staff', 'Help centres that answer, not only search', 'Contract search with clause-level citations'],
        'metric' => ['Deflection rate', 'Questions resolved without a ticket'],
        'href' => '#inspector', 'go' => 'Inspect a RAG answer',
    ],
    [
        'key' => 'conversation', 'n' => '02', 'title' => 'Conversational AI', 'icon' => 'chat', 'img' => 'family-conversation.jpg', 'pos' => '40% 55%',
        'alt' => 'A headset with a microphone rests beside an open laptop on a desk',
        'desc' => 'Chat and voice assistants that resolve requests through your systems and hand over to a person with the full context.',
        'uses' => ['Order, booking and account support on web and WhatsApp', 'Voice agents for first-line calls', 'Agent assist: suggested replies and live summaries'],
        'metric' => ['Average handle time', 'Minutes per resolved conversation'],
        'href' => '#conversation', 'go' => 'Watch a handover',
    ],
    [
        'key' => 'vision', 'n' => '03', 'title' => 'Vision & documents', 'icon' => 'vision', 'img' => 'family-inspection.jpg', 'pos' => '50% 45%',
        'alt' => 'Hands measure a machined metal part with a digital caliper on a workshop bench, an inspection sheet beside it',
        'desc' => 'Extraction, counting and inspection from scans, photos and video, with confidence thresholds and review queues.',
        'uses' => ['Invoice, form and ID extraction into your systems', 'Cap, fill and label checks on a production line', 'Shelf gaps and price-label compliance'],
        'metric' => ['Straight-through processing', 'Documents posted with no manual touch'],
        'href' => '#vision', 'go' => 'Compare before and after',
    ],
    [
        'key' => 'automation', 'n' => '04', 'title' => 'Workflow automation', 'icon' => 'workflow', 'img' => 'family-automation.jpg', 'pos' => '55% 45%',
        'alt' => 'Hands typing on a laptop showing a configuration table of workflow rules',
        'desc' => 'Multi-step processes across email, documents, CRM and ERP, with retries, audit trails and people at the approval gates.',
        'uses' => ['Accounts payable from inbox to posting', 'Customer onboarding and KYC checks', 'Order exceptions and returns'],
        'metric' => ['Cycle time', 'Hours from trigger to done'],
        'href' => '#automation', 'go' => 'Run a workflow',
    ],
];
$tapf_more = [$CAP['offer'][3], $CAP['offer'][5]];   // AI features in your product · Evals & LLMOps
$tapf_more_href = ['#efficiency', '#quality'];
?>
<section class="band band--alt tap-families" id="families" aria-labelledby="families-t">
  <div class="wrap">
    <div class="tap-head" data-rv>
      <div>
        <p class="tap-eb"><span class="tap-eb__box" aria-hidden="true"></span><span class="tap-eb__n">04.1</span><span>Feature families</span><span class="tap-eb__p">/families</span></p>
        <h2 class="h2" id="families-t"><span class="g">Four kinds of AI feature.</span> Each one opened up below.</h2>
      </div>
      <div>
        <p class="lead">Most of the AI we put into products falls into four families. They share one engineering bar: an eval set before a launch date, a confidence threshold that sends uncertain cases to a person, and a cost per request known from the first prototype.</p>
      </div>
    </div>

    <ul class="tap-fam" role="list" data-rv-s>
      <?php foreach ($tapf_cards as $tapf_i => $tapf_c): ?>
        <li class="tap-fam__card tap-fam__card--<?= e($tapf_c['key']) ?>" style="--i:<?= $tapf_i ?>">
          <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
          <figure class="bdh-img tap-fam__img">
            <img src="<?= xe_url('assets/imgs/tech/ai-product-automation/' . $tapf_c['img']) ?>" alt="<?= e($tapf_c['alt']) ?>" width="1200" height="900" loading="lazy" decoding="async" style="object-position:<?= e($tapf_c['pos']) ?>">
            <span class="tap-fam__ico"><?= xt_icon($tapf_c['icon'], ['size' => 20]) ?></span>
          </figure>

          <div class="tap-fam__strip" aria-hidden="true">
            <?php if ($tapf_c['key'] === 'knowledge'): ?>
              <span class="tap-fam__ans">Refunds within 14 days of delivery<i class="tap-cite">1</i></span>
              <span class="tap-fam__src">returns-policy.pdf · §2.1</span>
            <?php elseif ($tapf_c['key'] === 'conversation'): ?>
              <span class="tap-fam__wave"><?php for ($tapf_w = 0; $tapf_w < 22; $tapf_w++): ?><i style="--h:<?= [0.35, 0.6, 0.9, 0.5, 0.75, 1, 0.55, 0.3, 0.65, 0.85, 0.4, 0.7, 0.95, 0.6, 0.35, 0.5, 0.8, 0.45, 0.65, 0.3, 0.55, 0.4][$tapf_w] ?>;--k:<?= $tapf_w ?>"></i><?php endfor; ?></span>
              <span class="tap-fam__src">STT › LLM › TTS · 0.71 s</span>
            <?php elseif ($tapf_c['key'] === 'vision'): ?>
              <span class="tap-fam__doc"><i></i><i></i><i></i><i></i><b></b></span>
              <span class="tap-fam__src">total · 0.98 · posted</span>
            <?php else: ?>
              <svg class="tap-fam__flow" viewBox="0 0 120 24" fill="none"><path d="M8 12h104"/><circle cx="8" cy="12" r="5"/><circle cx="46" cy="12" r="5"/><circle cx="84" cy="12" r="5"/><rect x="106" y="6" width="12" height="12" rx="3"/><circle class="tap-fam__tok" cx="8" cy="12" r="2.6"/></svg>
              <span class="tap-fam__src">4 steps · 1 approval</span>
            <?php endif; ?>
          </div>

          <div class="tap-fam__body">
            <p class="tap-fam__n"><?= e($tapf_c['n']) ?></p>
            <h3 class="tap-fam__t"><?= e($tapf_c['title']) ?></h3>
            <p class="tap-fam__d"><?= e($tapf_c['desc']) ?></p>
            <p class="tap-fam__k">Typical uses</p>
            <ul class="bdh-bullets tap-fam__uses">
              <?php foreach ($tapf_c['uses'] as $tapf_u): ?><li><?= e($tapf_u) ?></li><?php endforeach; ?>
            </ul>
            <div class="tap-fam__metric">
              <p class="tap-fam__k">Moves</p>
              <p class="tap-fam__mv"><?= e($tapf_c['metric'][0]) ?></p>
              <p class="tap-fam__md"><?= e($tapf_c['metric'][1]) ?></p>
            </div>
            <a class="tl tap-fam__go" href="<?= e($tapf_c['href']) ?>"><?= e($tapf_c['go']) ?> <span class="i" aria-hidden="true">›</span></a>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
    <p class="tap-fam__hint" aria-hidden="true"><span>Swipe for all four</span><i><?php foreach ($tapf_cards as $tapf_i => $tapf_c): ?><b<?= $tapf_i === 0 ? ' class="is-on"' : '' ?>></b><?php endforeach; ?></i></p>

    <div class="tap-fam__more" data-rv>
      <p class="tap-fam__morek">Across all four</p>
      <?php foreach ($tapf_more as $tapf_i => $tapf_o): ?>
        <a class="tap-fam__row" href="<?= e($tapf_more_href[$tapf_i]) ?>">
          <span class="tap-fam__rico"><?= xt_icon($tapf_o[3], ['size' => 22]) ?></span>
          <span class="tap-fam__rtxt"><b><?= e($tapf_o[0]) ?></b><span><?= e($tapf_o[1]) ?></span></span>
          <span class="bdh-tag"><?= e($tapf_o[2]) ?></span>
          <span class="tap-fam__rarr" aria-hidden="true">›</span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
