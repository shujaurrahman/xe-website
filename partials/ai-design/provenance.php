<?php /* DRAFT COPY — review before launch */
/* Provenance — the record. What is written against every generated output, what the log looks like, and
   what actually has to be disclosed.
 *
 * Uses .aih-ledger (the record table idiom) on an ink band, so the capability subpages get a log
 * component for free. The log rows are illustrative and the panel says so.
 *
 * On the law, stated carefully and no further: the EU AI Act's transparency duties require synthetic
 * image, audio, video and text to be marked in a machine-readable form and detectable as generated,
 * require deep fakes to be disclosed, and require people to be told when they are interacting with an
 * AI system. C2PA Content Credentials are a signed manifest travelling with the asset; support varies
 * by tool and by platform, which is why the wording below says "where they are supported".
 */
$pv_log = [
    // [time, object, model / route, inputs, approver role, disclosure]
    ['09:14', 'film/launch-q3/cut-a · 9:16',      'image adapter v7',   '12 input ids',   'Brand lead',   'Synthetic · C2PA'],
    ['09:31', 'packshot/sku-1184/scene-2',        'image adapter v7',   '3 input ids',    'Brand lead',   'Synthetic · C2PA'],
    ['10:02', 'copy/launch/de-DE/email-1',        'voice set v5',       'approved master','Market lead',  'AI-assisted'],
    ['10:20', 'voice/launch/es-ES/vo-1',          'consented voice',    'consent id',     'Market lead',  'Synthetic · disclosed'],
    ['10:41', 'claim/launch/price-comparison',    'voice set v5',       'source cited',   'Counsel',      'Held for review'],
    ['10:58', 'assistant/answer/88412',           'route 02 · retrieval','4 passages',    'Not required', 'AI system notice'],
];
$pv_fields = [
    ['Brief and direction version',   'Which brief, and which version of the direction it was produced under.'],
    ['Prompt and settings',           'The prompt, the negative prompt, the seed and every parameter, stored as a hash and in full.'],
    ['Model and version',             'Base model, adapter or prompt set, and the exact version that produced this output.'],
    ['Input assets',                  'Every input by id, with its licence or consent record attached to it.'],
    ['Scores',                        'The fidelity or quality score the output was released against, and the threshold.'],
    ['Approver and time',             'Who approved it, in which role, at what time, and what they saw when they did.'],
    ['Disclosure and provenance',     'The label applied, the market rule it satisfies, and the C2PA manifest where supported.'],
    ['Expiry',                        'When the licence, the consent or the usage right runs out, so the asset can be withdrawn.'],
];
$pv_disc = [
    [
        'n'    => '01',
        'name' => 'Marked so a machine can read it',
        'text' => 'The EU AI Act’s transparency duties require synthetic image, audio, video and text to be marked in a machine-readable form and detectable as artificially generated. We attach C2PA Content Credentials where the tool and the platform support them, and keep the record on our side where they do not.',
    ],
    [
        'n'    => '02',
        'name' => 'Disclosed where a person could be misled',
        'text' => 'Deep fakes have to be disclosed, and people have to be told when they are interacting with an AI system rather than a person. We agree the wording per surface and per market before production, not after a complaint.',
    ],
    [
        'n'    => '03',
        'name' => 'Labelled to each platform’s own rule',
        'text' => 'Several publishers and ad platforms require a synthetic-content label of their own, with their own definitions and their own placement. The disclosure standard covers each channel you actually publish in.',
    ],
];
?>
<section class="band band--ink aih-pv" id="provenance" aria-labelledby="provenance-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Provenance &amp; disclosure</p>
        <h2 class="h2" id="provenance-t"><span class="g">Every output knows</span> where it came from.</h2>
      </div>
      <div>
        <p class="lead">A rights query two years from now is answered from a record, not from memory. So every generated output carries the brief it came from, the model version that made it, the licence behind each input, the person who approved it and the label it went out with.</p>
        <p class="aih-note">The log is exportable, because that is the form an audit or a rights query arrives in.</p>
      </div>
    </div>

    <div class="aih-panel aih-pv__panel" data-rv data-rv-d="50">
      <div class="aih-panel__bar">
        <span class="aih-panel__dots"><i></i><i></i><i></i></span>
        <span class="aih-panel__title">output log <i>/</i> your brand <i>/</i> today</span>
        <span class="aih-panel__ill aih-panel__sp">Illustrative</span>
        <span class="aih-panel__live"><i class="bdh-pulse"></i>Appending</span>
      </div>
      <div class="aih-panel__body">
        <p class="aih-note aih-pv__hint">The log scrolls sideways on a narrow screen.</p>
        <div class="bdh-scroll-x aih-pv__wrap" tabindex="0" role="group" aria-label="An illustrative output log, scroll sideways on a narrow screen">
          <table class="aih-ledger aih-pv__tbl">
            <caption>One row per generated output, written whether it ships or not</caption>
            <thead>
              <tr>
                <th scope="col">Time</th><th scope="col">Object</th><th scope="col">Model or route</th>
                <th scope="col">Inputs</th><th scope="col">Approved by</th><th scope="col">Disclosure</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pv_log as $pv_r): ?>
                <tr>
                  <th scope="row"><?= e($pv_r[0]) ?></th>
                  <td><?= e($pv_r[1]) ?></td>
                  <td><?= e($pv_r[2]) ?></td>
                  <td><?= e($pv_r[3]) ?></td>
                  <td><b><?= e($pv_r[4]) ?></b></td>
                  <td><?= e($pv_r[5]) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <p class="aih-pv__note">Roles rather than names in this example. In service the log holds the person, and the export carries the whole chain: brief, prompt, settings, inputs, licences, scores, approver and label.</p>
      </div>
    </div>

    <div class="bdh-grid aih-pv__low">
      <div class="bdh-c5 aih-pv__fields" data-rv data-rv-d="40">
        <h3 class="aih-pv__h">Written against every output</h3>
        <dl class="aih-pv__rows">
          <?php foreach ($pv_fields as $pv_f): ?>
            <div><dt><?= e($pv_f[0]) ?></dt><dd><?= e($pv_f[1]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
      </div>

      <div class="bdh-c6 bdh-s7 aih-pv__disc" data-rv data-rv-d="70">
        <h3 class="aih-pv__h">What has to be disclosed</h3>
        <ol class="aih-pv__dl">
          <?php foreach ($pv_disc as $pv_d): ?>
            <li>
              <span class="bdh-idx"><?= e($pv_d['n']) ?></span>
              <div>
                <p class="aih-pv__dt"><?= e($pv_d['name']) ?></p>
                <p class="aih-pv__dd"><?= e($pv_d['text']) ?></p>
              </div>
            </li>
          <?php endforeach; ?>
        </ol>
        <!-- PLACEHOLDER: confirm the legal review step and the disclosure standard with the client's counsel before launch -->
        <p class="aih-note">We map which duties apply in the markets you publish in and prepare the position with your counsel. We do not give legal advice, and nothing here is a warranty about a vendor’s licence or indemnity.</p>
      </div>
    </div>
  </div>
</section>
