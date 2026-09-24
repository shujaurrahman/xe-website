<?php /* DRAFT COPY — review before launch */ ?>
<?php
$wrk_n_cases = count($WRK['cases']);
$wrk_used = [];
foreach ($WRK['cases'] as $wrk_c) foreach ($wrk_c['did'] as $wrk_x) $wrk_used[$wrk_x[0]] = true;
?>
<section class="band wrk-hero" id="top" aria-labelledby="wrk-hero-t">
  <div class="wrap">
    <div class="wrk-hero__grid">
      <div class="wrk-hero__say">
        <p class="lbl lbl--blue"><span class="dot"></span>Selected work · anonymised</p>
        <h1 class="d1" id="wrk-hero-t"><span class="g">Delivered.</span> Named only with permission.</h1>
      </div>
      <div class="wrk-hero__side">
        <p class="lead">Work that reshapes how people experience a brand, moves the numbers that matter, and leaves the system better than we found it. Our clients’ names stay theirs — so each programme below is told through its brief, the system we built and how it is measured.</p>
        <div class="wrk-hero__cta">
          <a class="btn btn--ink btn--lg" href="#index">Browse the programmes <span class="i" aria-hidden="true">›</span></a>
          <a class="btn btn--out btn--lg" href="#featured">Featured case <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>
    </div>

    <!-- PLACEHOLDER: figures carried over from the previous site — confirm before launch -->
    <dl class="wrk-led" aria-label="The work in numbers">
      <div><dt>Programmes shipped</dt><dd data-bdh-count>380+</dd></div>
      <div><dt>Markets under delivery</dt><dd>9</dd></div>
      <div><dt>Industries served</dt><dd>12</dd></div>
      <div><dt>On this page</dt><dd><?= $wrk_n_cases ?> programmes · <?= count($wrk_used) ?> disciplines</dd></div>
    </dl>
  </div>
</section>
