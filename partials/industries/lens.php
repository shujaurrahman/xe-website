<?php /* DRAFT COPY — review before launch */
/* Lens — the five questions we answer before any work starts, answered for all six categories at once.
   One table: the questions are row headers, the categories are columns, and every one of the thirty
   answers is in the shipped HTML. lens.js adds a "read as" control that emphasises one column; with
   JavaScript off the whole matrix simply reads as a matrix, which is the finished state. The first
   column is sticky inside the scroller so a question stays visible while the columns move. */
$ind_lens = $IND['lens'];
?>
<section class="band band--alt ind-lens" id="lens" aria-labelledby="lens-t">
  <div class="wrap">
    <div class="ind-head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>How we read a category</p>
        <h2 class="h2" id="lens-t"><span class="g">Five questions,</span> answered before anything is designed.</h2>
      </div>
      <div>
        <p class="lead">The same five questions in every category. The answers are what make the work different, and they are written down before a layout, a data model or a campaign exists.</p>
        <div class="ind-seg ind-lens__seg" role="group" aria-label="Emphasise one category" data-ind-lens-seg hidden>
          <button type="button" data-cat="" aria-pressed="true">All six</button>
          <?php foreach ($IND_SET as $ind_c): ?>
            <button type="button" data-cat="<?= e($ind_c['slug']) ?>" aria-pressed="false"><?= e($ind_c['short']) ?></button>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <div class="ind-scroll ind-lens__wrap" data-rv data-rv-d="60">
      <div class="bdh-scroll-x ind-lens__sx" tabindex="0" role="group" aria-label="The five questions answered for each category, scroll sideways">
        <table class="ind-tbl ind-lens__tbl" data-ind-lens>
          <caption class="bdh-sr">The five questions we answer before any work starts, answered for each of the six categories.</caption>
          <thead>
            <tr>
              <th scope="col">The question</th>
              <?php foreach ($IND_SET as $ind_c): ?>
                <th scope="col" data-cat="<?= e($ind_c['slug']) ?>"><a href="#<?= e($ind_c['slug']) ?>"><?= e($ind_c['name']) ?></a></th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($ind_lens as $ind_qi => $ind_q): ?>
              <tr>
                <th scope="row">
                  <span class="ind-num">Q<?= str_pad((string) ($ind_qi + 1), 2, '0', STR_PAD_LEFT) ?></span>
                  <span class="ind-lens__q"><?= e($ind_q[0]) ?></span>
                  <span class="ind-lens__why"><?= e($ind_q[1]) ?></span>
                </th>
                <?php foreach ($IND_SET as $ind_c): ?>
                  <td data-cat="<?= e($ind_c['slug']) ?>"><?= e($ind_c['lens'][$ind_qi] ?? '') ?></td>
                <?php endforeach; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <p class="ind-note ind-hint">Scroll the table sideways to reach every category, or use the control above to bring one forward.</p>
    </div>
  </div>
</section>
