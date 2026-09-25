<?php /* DRAFT COPY — review before launch */
/* Signature — AI Product Strategy & Development: an AI feature spec. The task, the human's role and the risk note are
   fixed; the model option changes the eval results against fixed thresholds, and highlights the fallback that has to
   carry each gap. Options: a large hosted model · b small model · c small model + retrieval. Ships option c. */
$pxd_opts = [
    ['a', 'Large model', 'Large hosted model: quality passes, but p95 latency and cost per draft fail. The timeout fallback would carry too much traffic.'],
    ['b', 'Small model', 'Small model alone: fast and cheap, but groundedness and acceptance fall below threshold. Not shippable.'],
    ['c', 'Small + retrieval', 'Small model with retrieval: all five thresholds met. Ships behind a flag to 10% of agents, with the fallbacks below.'],
];
$pxd_def = 2;
$pxd_sr  = 'An illustrative AI feature specification for drafting support replies: three model options measured against five evaluation thresholds, with the fallbacks that handle each gap.';
$pxd_ev = [   // [metric, threshold, [a, b, c], pass per option]
    ['Answers grounded in sources',   '≥ 90%',  ['94%', '78%', '92%'],   [1, 0, 1]],
    ['Drafts accepted, light edits',  '≥ 70%',  ['81%', '64%', '76%'],   [1, 0, 1]],
    ['p95 latency',                   '≤ 2.5 s', ['3.4 s', '0.9 s', '1.6 s'], [0, 1, 1]],
    ['Cost per draft vs budget',      '≤ 100%', ['240%', '35%', '60%'],  [0, 1, 1]],
    ['Injection cases blocked (LLM01)', '100%', ['100%', '100%', '100%'], [1, 1, 1]],
];
$pxd_fb = [
    ['Confidence below 0.6', 'Show the sources, no draft', 'b'],
    ['No source found',      'Say so, offer a saved template', 'b'],
    ['No reply within 4 s',  'Template now, draft when ready', 'a'],
];
$pxd_vs = ['a', 'b', 'c'];
?>
<div class="pxd-ai">
  <dl class="pxd-ai__spec">
    <div><dt>Task</dt><dd>Draft a reply to a support ticket</dd></div>
    <div><dt>Human role</dt><dd>Agent edits and sends; AI never sends</dd></div>
    <div><dt>Risk note</dt><dd>Limited risk · AI use disclosed</dd></div>
  </dl>
  <table class="pxd-ai__ev">
    <thead><tr><th scope="col">Eval</th><th scope="col">Threshold</th><th scope="col">Result</th></tr></thead>
    <tbody>
      <?php foreach ($pxd_ev as $pxd_r): ?>
      <tr>
        <th scope="row"><?= e($pxd_r[0]) ?></th>
        <td><?= e($pxd_r[1]) ?></td>
        <td><?php foreach ($pxd_vs as $pxd_j => $pxd_v): ?><span data-on="<?= $pxd_v ?>" class="pxd-ai__r<?= $pxd_r[3][$pxd_j] ? ' is-ok' : ' is-no' ?>"><?= e($pxd_r[2][$pxd_j]) ?><i><?= $pxd_r[3][$pxd_j] ? 'pass' : 'fail' ?></i></span><?php endforeach; ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="pxd-ai__fb">
    <p class="pxd-ai__h">Fallbacks</p>
    <ul>
      <?php foreach ($pxd_fb as $pxd_f): ?><li data-hi="<?= $pxd_f[2] ?>"><b><?= e($pxd_f[0]) ?></b><span><?= e($pxd_f[1]) ?></span></li><?php endforeach; ?>
    </ul>
  </div>
  <p class="pxd-ai__verdict"><span data-on="a">3 of 5 met · latency and cost fail</span><span data-on="b">3 of 5 met · quality fails</span><span data-on="c" class="is-rec">5 of 5 met · ship behind a flag</span></p>
</div>
