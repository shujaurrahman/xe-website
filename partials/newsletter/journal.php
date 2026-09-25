<?php /* DRAFT COPY — review before launch */
/* How it sits beside the journal — the question a reader actually has, which is whether this is the
   same thing twice. It is not: the journal publishes when a post is finished; the newsletter collects
   and adds the argument for why it was worth your time.
   The posts listed are read through the journal's own documented API (partials/blog/lib.php →
   blog_posts()), so nothing here invents a title or points at a page that is not there: a post whose
   page file does not exist yet renders as plain text rather than a link, exactly as /blog does. If the
   journal is ever absent, the whole list is skipped and the section still reads. */
$jou_posts = [];
$jou_lib = dirname(__DIR__) . '/blog/lib.php';
if (is_file($jou_lib)) {
    require_once $jou_lib;
    if (function_exists('blog_posts')) { $jou_posts = array_slice(blog_posts(), 0, 4, true); }
}
$jou_rows = [
    ['What it is',  'A written record: articles and case studies, in full.', 'A monthly letter: one argument, three links with reasons, one number.'],
    ['When it moves', 'When a post is finished — a handful a quarter.',      'Once a month at most, and never to fill a slot.'],
    ['What it costs', 'Nothing. No address, no account, no wall.',           'Your address, and nothing else.'],
    ['Where it lives', 'On this site, permanently.',                          'In your inbox, and on this site the same day.'],
];
?>
<section class="band band--alt nlt-jou" id="journal" aria-labelledby="journal-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Beside the journal</p>
        <h2 class="h2" id="journal-t"><span class="g">The journal is the record.</span> The newsletter is the argument.</h2>
      </div>
      <div>
        <p class="lead">They are not the same thing sent twice. The journal publishes a piece when it is finished
          and it is free to read for ever. The newsletter picks what mattered, says why, and adds the part that is
          only worth writing once a month.</p>
        <a class="tl" href="<?= xe_url('blog/index.php') ?>">Read the journal <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <div class="nlt-jou__grid">
      <div class="bdh-scroll-x nlt-jou__scroll" tabindex="0" role="group" aria-label="The journal compared with the newsletter — scroll sideways to read both columns">
        <table class="nlt-jou__t">
          <caption class="bdh-sr">How the journal and the newsletter differ, on four points.</caption>
          <thead>
            <tr>
              <th scope="col"><span class="bdh-sr">Point of comparison</span></th>
              <th scope="col">The journal</th>
              <th scope="col" class="nlt-jou__mine"><?= e($NLT['meta']['name']) ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($jou_rows as $jou_r): ?>
              <tr>
                <th scope="row"><?= e($jou_r[0]) ?></th>
                <td><?= e($jou_r[1]) ?></td>
                <td class="nlt-jou__mine"><?= e($jou_r[2]) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <p class="nlt-hint-x" aria-hidden="true">Scroll sideways for both columns</p>

      <div class="nlt-jou__side">
        <?php if ($jou_posts): ?>
          <p class="nlt-k">Most recent in the journal</p>
          <ul class="nlt-jou__posts">
            <?php foreach ($jou_posts as $jou_p): ?>
              <li>
                <?php if (!empty($jou_p['live']) && !empty($jou_p['url'])): ?>
                  <a class="nlt-jou__pa" href="<?= e($jou_p['url']) ?>">
                    <span class="nlt-jou__pt"><?= e($jou_p['title']) ?></span>
                    <span class="nlt-jou__pm"><?= e(date('M Y', strtotime($jou_p['iso']))) ?> · <?= (int) $jou_p['minutes'] ?> min</span>
                  </a>
                <?php else: ?>
                  <span class="nlt-jou__pa nlt-jou__pa--off">
                    <span class="nlt-jou__pt"><?= e($jou_p['title']) ?></span>
                    <span class="nlt-jou__pm">Page pending</span>
                  </span>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>

        <?php $nl_signup = [
            'variant' => 'card',
            'id'      => 'aside',
            'source'  => 'newsletter',
            'heading' => 'Prefer it in your inbox?',
            'cta'     => 'Subscribe',
        ]; ?>
        <?php include __DIR__ . '/signup.php'; ?>
      </div>
    </div>
  </div>
</section>
