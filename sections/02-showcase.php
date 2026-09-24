<?php /* DRAFT COPY — review before launch */ ?>
<section class="band band--alt s02" id="showcase" aria-labelledby="s02-t">
  <div class="s02__bg" aria-hidden="true">
    <span class="aurora aurora--soft"><i></i><i></i><i></i><i></i></span>
    <span class="dither dither--wide s02__dither"></span>
  </div>
  <div class="wrap s02__in">

    <p class="lbl lbl--blue s02__eyebrow"><span class="dot"></span>Chapter 04 · The work</p>
    <h2 class="sr" id="s02-t">From a brief to a system that runs</h2>

    <!-- the reference's two-pill diagram, made into a real control:
         ink fills the selected pill, a blue dot walks the rule between them -->
    <div class="s02__switch" data-rv data-rv-d="90">
      <div class="s02__toggle" role="tablist" aria-label="Show the brief, or what we delivered">
        <button class="pill s02__pill" type="button" role="tab"
                id="s02-tab-1" aria-controls="s02-pane-1" aria-selected="true">Brief</button>

        <span class="s02__wire" aria-hidden="true">
          <i class="s02__fill"></i>
          <i class="s02__dot"></i>
        </span>

        <button class="pill s02__pill" type="button" role="tab"
                id="s02-tab-2" aria-controls="s02-pane-2" aria-selected="false" tabindex="-1">Delivered</button>
      </div>
    </div>

    <div class="s02__stage" data-rv data-rv-d="170">
      <span class="s02__grid dots" aria-hidden="true"></span>
      <div class="s02__panes">

        <!-- ── pane 1 · the brief as it arrives ───────────────────────────── -->
        <div class="s02__pane is-on" id="s02-pane-1" role="tabpanel" aria-labelledby="s02-tab-1" tabindex="0">
          <!-- PLACEHOLDER: illustrative inbound briefs, written for layout — replace with real, cleared client briefs -->
          <ul class="s02__briefs">
            <li class="s02__brief">
              <span class="s02__edge" aria-hidden="true"></span>
              <div class="s02__top">
                <span class="s02__sector">Consumer health</span>
                <span class="s02__idx" aria-hidden="true">01</span>
              </div>
              <p class="s02__quote">&ldquo;Nine markets. One brand. Stop the drift.&rdquo;</p>
              <div class="s02__foot">
                <span class="s02__tags"><i>Brand Design</i><i>Campaign</i></span>
                <span class="s02__wks">10 weeks</span>
              </div>
            </li>

            <li class="s02__brief">
              <span class="s02__edge" aria-hidden="true"></span>
              <div class="s02__top">
                <span class="s02__sector">Financial services</span>
                <span class="s02__idx" aria-hidden="true">02</span>
              </div>
              <p class="s02__quote">&ldquo;Our CRM knows nothing about our customers.&rdquo;</p>
              <div class="s02__foot">
                <span class="s02__tags"><i>Marketing Technology</i><i>Data</i></span>
                <span class="s02__wks">14 weeks</span>
              </div>
            </li>

            <li class="s02__brief">
              <span class="s02__edge" aria-hidden="true"></span>
              <div class="s02__top">
                <span class="s02__sector">B2B software</span>
                <span class="s02__idx" aria-hidden="true">03</span>
              </div>
              <p class="s02__quote">&ldquo;Ship an AI assistant that doesn&rsquo;t embarrass us.&rdquo;</p>
              <div class="s02__foot">
                <span class="s02__tags"><i>AI Design</i><i>Product</i></span>
                <span class="s02__wks">8 weeks</span>
              </div>
            </li>

            <li class="s02__brief">
              <span class="s02__edge" aria-hidden="true"></span>
              <div class="s02__top">
                <span class="s02__sector">Retail &amp; commerce</span>
                <span class="s02__idx" aria-hidden="true">04</span>
              </div>
              <p class="s02__quote">&ldquo;We rank on Google. We&rsquo;re invisible in ChatGPT.&rdquo;</p>
              <div class="s02__foot">
                <span class="s02__tags"><i>Technology</i><i>Search</i></span>
                <span class="s02__wks">6 weeks</span>
              </div>
            </li>
          </ul>
        </div>

        <!-- ── pane 2 · what shipped ──────────────────────────────────────── -->
        <div class="s02__pane" id="s02-pane-2" role="tabpanel" aria-labelledby="s02-tab-2" tabindex="0">
          <!-- PLACEHOLDER: reference imagery, swap for Xterra Edze's own work before launch -->
          <div class="s02__mosaic">
            <!-- the first four tiles answer briefs 01–04, in order, by discipline -->
            <div class="s02__row">
              <figure class="s02__t s02__t--16">
                <img src="assets/imgs/c69b0bdd_T5J8ZvGDJWsakqEOGBZNtykg3E0.webp" alt="" aria-hidden="true"
                     width="3200" height="2400" loading="lazy" decoding="async">
                <figcaption class="s02__cap s02__cap--brief"><span class="s02__bi"><span class="sr">Answers brief </span>01 <span aria-hidden="true">→</span></span>Brand</figcaption>
              </figure>

              <figure class="s02__t s02__t--43">
                <img src="assets/imgs/1e2b6b79_cap-client-portals.webp" alt="" aria-hidden="true"
                     width="900" height="641" loading="lazy" decoding="async">
                <figcaption class="s02__cap s02__cap--brief"><span class="s02__bi"><span class="sr">Answers brief </span>02 <span aria-hidden="true">→</span></span>Marketing Technology</figcaption>
              </figure>

              <figure class="s02__t s02__t--34">
                <img src="assets/imgs/17973a26_j5zkzCoLjv3Nel6mPelVJ5OwCjM.png" alt="" aria-hidden="true"
                     width="2048" height="1536" loading="lazy" decoding="async">
                <figcaption class="s02__cap s02__cap--brief"><span class="s02__bi"><span class="sr">Answers brief </span>03 <span aria-hidden="true">→</span></span>AI</figcaption>
              </figure>

              <figure class="s02__t s02__t--43">
                <img src="assets/imgs/b19b0950_2b4e28b5bffd2be8.jpg" alt="" aria-hidden="true"
                     width="1027" height="662" loading="lazy" decoding="async">
                <figcaption class="s02__cap s02__cap--brief"><span class="s02__bi"><span class="sr">Answers brief </span>04 <span aria-hidden="true">→</span></span>Technology</figcaption>
              </figure>
            </div>

            <div class="s02__row">
              <figure class="s02__t s02__t--34">
                <img src="assets/imgs/3b186bd3_L3MIwmBYXPmulFMJfyH5uCFEns.png" alt="" aria-hidden="true"
                     width="3805" height="2376" loading="lazy" decoding="async">
                <figcaption class="s02__cap">Product</figcaption>
              </figure>

              <figure class="s02__t s02__t--1">
                <img src="assets/imgs/69efafe1_ds3pyMGMNrhRq7KRBPggBjJLMNg.png" alt="" aria-hidden="true"
                     width="1440" height="900" loading="lazy" decoding="async">
                <figcaption class="s02__cap">Campaign</figcaption>
              </figure>

              <figure class="s02__t s02__t--1">
                <img src="assets/imgs/8599929a_o35xFsOzb7RHHzOvvCWvhTp3T5k.png" alt="" aria-hidden="true"
                     width="2048" height="1332" loading="lazy" decoding="async">
                <figcaption class="s02__cap">Brand</figcaption>
              </figure>

              <figure class="s02__t s02__t--32">
                <img src="assets/imgs/0713d126_962143a38444fcca.jpg" alt="" aria-hidden="true"
                     width="1023" height="662" loading="lazy" decoding="async">
                <figcaption class="s02__cap">Product</figcaption>
              </figure>
            </div>

          </div>
        </div>

      </div>
    </div>

    <noscript><style>
      /* without JS the switch cannot turn: show the briefs, then what was delivered */
      .s02__switch{display:none}
      .s02__panes{gap:clamp(14px,1.9vw,26px)}
      .s02__pane,.s02__pane:not(.is-on){grid-area:auto;opacity:1;visibility:visible;transform:none}
    </style></noscript>

    <div class="s02__cta" data-rv data-rv-d="240">
      <a class="btn btn--ink" href="<?= xe_url('work.php') ?>">See what we have built <span class="i" aria-hidden="true">›</span></a>
    </div>

  </div>
</section>
