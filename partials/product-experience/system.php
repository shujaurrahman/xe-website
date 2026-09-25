<?php /* DRAFT COPY — review before launch */
/* System — the structural layer. One drawn pipeline (brand constants → one token source → every
   surface, with a contribution path back), then what "done" means for a component, then adoption
   measured per team. Every edge in the diagram stops 8 units short of the box it leaves and the box it
   enters, so no line runs through a label. */
$sys_contract = [
    ['Every state drawn', 'Default, hover, focus, active, disabled, loading, empty and error — in the library, not in a ticket.', ''],
    ['Operable by keyboard', 'Reachable, operable and escapable without a mouse, with a documented key map.', '2.1.1 Keyboard · A'],
    ['Focus visible, and not hidden', 'A focus indicator that survives every background, and is never entirely hidden behind a sticky header or a toolbar.', '2.4.7 · A / 2.4.11 Focus Not Obscured (Minimum) · AA'],
    ['Targets big enough', 'At least 24 × 24 CSS pixels, or spaced far enough apart to meet the exception.', '2.5.8 Target Size (Minimum) · AA'],
    ['Text contrast checked', 'At least 4.5:1 for body text and 3:1 for large text, in every theme the component ships in.', '1.4.3 Contrast (Minimum) · AA'],
    ['Control contrast checked', 'At least 3:1 for control boundaries, icons that carry meaning and the focus indicator itself.', '1.4.11 Non-text Contrast · AA'],
    ['Name, role and value exposed', 'What it is, what it does and what it currently is, all available to assistive technology.', '4.1.2 Name, Role, Value · A'],
    ['Tested where it cannot rot', 'Unit tests, visual regression and an automated accessibility check on every merge, plus a manual screen-reader pass per release.', ''],
    ['Documented both ways', 'When to use it, when not to, the props, and a worked example that is generated from the code.', ''],
];
/* PLACEHOLDER: illustrative adoption figures for five product teams, not a client result */
$sys_adopt = [
    ['Team A · web app',     92],
    ['Team B · admin',       78],
    ['Team C · marketing',   64],
    ['Team D · mobile',      41],
    ['Team E · new product', 12],
];
$sys_target = 80;
?>
<section class="band band--ink pxh-system" id="system" aria-labelledby="system-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>System design</p>
        <h2 class="h2" id="system-t"><span class="g">Ten screens is a design.</span> A thousand is a system.</h2>
      </div>
      <div>
        <p class="lead">Foundations are defined once and consumed everywhere. A colour, a focus style or a target size is changed in one place and inherited by every product that uses it — including the accessibility fix you would otherwise make four times.</p>
        <p class="pxh-capls pxh-system__caps"><a class="pxh-capl" href="#system-design"><b><?= e($CAPS['system-design']['n']) ?></b><span><?= e($CAPS['system-design']['name']) ?></span><i aria-hidden="true">›</i></a></p>
      </div>
    </div>

    <figure class="pxh-system__pipe" data-rv>
      <figcaption class="pxh-system__pk"><span class="pxh-k">One source of truth</span><span class="bdh-ill">Schematic</span></figcaption>
      <p class="bdh-sr">A pipeline: the brand constants from Brand Design feed one token source held as JSON, which feeds a semantic layer. From there the tokens are exported to a Figma library, a web package in React and TypeScript, iOS in Swift, Android in Kotlin, and email templates, which your product teams consume. A dashed contribution path runs from the product teams back into the semantic layer, so the system grows instead of being worked around.</p>
      <div class="bdh-scroll-x mask-x pxh-wide pxh-system__scroll" tabindex="0" role="group" aria-label="The token pipeline, drawn. Scroll sideways to see all of it.">
      <div class="pxh-dia pxh-system__dia" style="--ar:1000 / 470" aria-hidden="true">
        <svg viewBox="0 0 1000 470" fill="none" focusable="false">
          <g class="pxh-system__boxes">
            <rect x="20" y="180" width="150" height="60" rx="8" class="is-outside"/>
            <rect x="250" y="140" width="200" height="56" rx="8" class="is-core"/>
            <rect x="250" y="224" width="200" height="56" rx="8" class="is-core"/>
            <rect x="620" y="40"  width="280" height="44" rx="8"/>
            <rect x="620" y="104" width="280" height="44" rx="8"/>
            <rect x="620" y="168" width="280" height="44" rx="8"/>
            <rect x="620" y="232" width="280" height="44" rx="8"/>
            <rect x="620" y="296" width="280" height="44" rx="8"/>
            <rect x="560" y="390" width="240" height="48" rx="8" class="is-outside"/>
          </g>

          <!-- brand constants → token source and semantic layer -->
          <path class="pxh-edge" d="M178 210 H202 Q210 210 210 202 V176 Q210 168 218 168 H242"/>
          <path class="pxh-edge" d="M210 218 V244 Q210 252 218 252 H242"/>
          <path class="pxh-arrow" d="M242 163.5 L250 168 L242 172.5 Z"/>
          <path class="pxh-arrow" d="M242 247.5 L250 252 L242 256.5 Z"/>
          <!-- token source → semantic layer -->
          <path class="pxh-edge" d="M350 204 V212"/>
          <path class="pxh-arrow" d="M345.5 216 L350 224 L354.5 216 Z"/>
          <!-- semantic layer → the export bus → every surface -->
          <path class="pxh-edge pxh-edge--live" d="M458 252 H520"/>
          <path class="pxh-edge pxh-edge--live" d="M520 62 V406"/>
          <path class="pxh-edge pxh-edge--live" d="M520 62 H612"/>
          <path class="pxh-edge pxh-edge--live" d="M520 126 H612"/>
          <path class="pxh-edge pxh-edge--live" d="M520 190 H612"/>
          <path class="pxh-edge pxh-edge--live" d="M520 254 H612"/>
          <path class="pxh-edge pxh-edge--live" d="M520 318 H612"/>
          <path class="pxh-arrow pxh-arrow--blue" d="M612 57.5 L620 62 L612 66.5 Z"/>
          <path class="pxh-arrow pxh-arrow--blue" d="M612 121.5 L620 126 L612 130.5 Z"/>
          <path class="pxh-arrow pxh-arrow--blue" d="M612 185.5 L620 190 L612 194.5 Z"/>
          <path class="pxh-arrow pxh-arrow--blue" d="M612 249.5 L620 254 L612 258.5 Z"/>
          <path class="pxh-arrow pxh-arrow--blue" d="M612 313.5 L620 318 L612 322.5 Z"/>
          <!-- the bus reaches the teams -->
          <path class="pxh-edge" d="M520 406 Q520 414 528 414 H552"/>
          <path class="pxh-arrow" d="M552 409.5 L560 414 L552 418.5 Z"/>
          <!-- contribution: teams back into the semantic layer -->
          <path class="pxh-edge pxh-edge--dash" d="M552 414 H358 Q350 414 350 406 V288"/>
          <path class="pxh-arrow" d="M345.5 288 L350 280 L354.5 288 Z"/>

          <g class="pxh-system__tx">
            <text x="95" y="205" text-anchor="middle" class="is-k">FROM BRAND DESIGN</text>
            <text x="95" y="224" text-anchor="middle">Brand constants</text>
            <text x="350" y="163" text-anchor="middle" class="is-k">ONE FILE</text>
            <text x="350" y="182" text-anchor="middle">Token source · JSON</text>
            <text x="350" y="247" text-anchor="middle" class="is-k">NAMED BY MEANING</text>
            <text x="350" y="266" text-anchor="middle">Semantic layer</text>
            <text x="640" y="67">Figma library</text>
            <text x="640" y="131">Web package · React + TypeScript</text>
            <text x="640" y="195">iOS · Swift tokens</text>
            <text x="640" y="259">Android · Kotlin tokens</text>
            <text x="640" y="323">Email templates</text>
            <text x="680" y="412" text-anchor="middle" class="is-k">CONSUMED BY</text>
            <text x="680" y="431" text-anchor="middle">Your product teams</text>
            <text x="452" y="390" text-anchor="middle" class="is-k">CONTRIBUTION</text>
          </g>
        </svg>
      </div>
      </div>
      <p class="pxh-note pxh-system__pn">A Figma library on its own drifts from production inside a quarter, and a code package on its own drifts from the designs. The token set is the contract between them, exported to each platform from one source.</p>
    </figure>

    <div class="pxh-system__cols">
      <div class="pxh-system__contract" data-rv>
        <p class="pxh-k">Definition of done · per component</p>
        <p class="pxh-system__ct">A component is finished when the next team can use it without asking us anything.</p>
        <ul class="pxh-system__list" role="list">
          <?php foreach ($sys_contract as $sys_i => $sys_c): ?>
            <li style="--i:<?= $sys_i ?>">
              <span class="pxh-system__tick" aria-hidden="true"><?= xt_icon('check', ['size' => 18, 'mono' => true]) ?></span>
              <span class="pxh-system__li">
                <b><?= e($sys_c[0]) ?></b>
                <span><?= e($sys_c[1]) ?></span>
                <?php if ($sys_c[2] !== ''): ?><em><?= e($sys_c[2]) ?></em><?php endif; ?>
              </span>
            </li>
          <?php endforeach; ?>
        </ul>
        <p class="pxh-note">Criteria are named as they appear in WCAG 2.2. Conformance is a statement your organisation publishes about a product; nobody issues a certificate for it.</p>
      </div>

      <div class="pxh-system__side" data-rv data-rv-d="80">
        <div class="pxh-system__adopt">
          <p class="pxh-k">Adoption, per team<span class="bdh-ill">Illustrative</span></p>
          <p class="pxh-system__at">A system nobody uses is a cost, not an asset.</p>
          <!-- PLACEHOLDER: illustrative adoption figures, not a client result — confirm before launch -->
          <div class="pxh-bars">
            <?php foreach ($sys_adopt as $sys_ai => $sys_a): ?>
              <div class="pxh-bar pxh-bar--tgt">
                <span class="pxh-bar__n"><?= e($sys_a[0]) ?></span>
                <span class="pxh-bar__v"><?= $sys_a[1] ?>%</span>
                <span class="pxh-bar__track"><i class="pxh-bar__fill<?= $sys_a[1] < $sys_target ? ' pxh-bar__fill--quiet' : '' ?>" style="--p:<?= $sys_a[1] ?>;--i:<?= $sys_ai ?>"></i><i class="pxh-bar__tgt" style="--tgt:<?= $sys_target ?>"></i></span>
              </div>
            <?php endforeach; ?>
          </div>
          <p class="pxh-system__al"><span class="pxh-system__key" aria-hidden="true"></span>The rule is the adoption target agreed with each team. It is measured from component usage across your repositories, not from a survey.</p>
        </div>

        <div class="pxh-system__bound">
          <p class="pxh-k">Where this stops, and Brand Design starts</p>
          <p>Brand Systems governs how the brand behaves across every channel: expression, rules, assets and tone. System Design is the product’s structural layer: tokens, components, states and versioning, in design and in code. The brand system sets the constants; this consumes them and makes them buildable.</p>
          <a class="tl" href="<?= xe_url('services/brand-design.php') ?>">Brand Design <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>
    </div>
  </div>
</section>
