<?php /* DRAFT COPY — review before launch */
/* The brief — the form itself, inside the <form> contact.php opened. Six blocks: who you are, what
   you need, the problem, the deeper brief, commercials, practicalities, plus an optional document.
   Blocks four to six are <details>, so they collapse without JavaScript and open on their own
   whenever they hold an answer or an error (contact.php $ct_open_*). Every control carries
   data-pv="<label>" and sits under a data-pv-block, which is how #inbox builds the live preview:
   the labels are exactly the ones ct_blocks() puts in the email, so the two cannot drift.
   Locals are prefixed ct_. */
$ct_req = ' <span class="ct-req" aria-hidden="true">*</span>';
?>
<section class="band band--alt ct-main" id="brief" aria-labelledby="brief-t">
  <div class="wrap ct-grid">

    <div class="ct-col">
      <div class="ct-main__head">
        <p class="lbl lbl--blue"><span class="dot"></span><?= $ct_app ? 'Your application' : 'The brief' ?></p>
        <h2 class="h2" id="brief-t"><?= $ct_app ? '<span class="g">Tell us about you,</span> and your work.' : '<span class="g">Answer what you can.</span> Leave the rest.' ?></h2>
        <p class="ct-main__d"><?= $ct_app
          ? 'Nothing here is scored by a keyword filter. A person reads it.'
          : 'Nothing below is a trick question. Every answer you give is one we do not have to ask for later, and an unanswered one never stops a brief being sent.' ?></p>
      </div>

      <?php if ($CT['state'] === 'failed'): ?>
        <!-- PLACEHOLDER: confirm where leads should go (email / CRM) before launch -->
        <div class="ct-alert ct-alert--fail" role="alert" tabindex="-1" data-ct-focus>
          <span class="ct-alert__ico" aria-hidden="true"><?= svc_icon('mail') ?></span>
          <div class="ct-alert__b">
            <p class="ct-alert__t">We could not send your brief from this page.</p>
            <p class="ct-alert__p">Nothing is lost. Your answers are still below, and the button opens your email app with the same brief written out, ready to send to <?= e($SITE['company']['email']) ?>.<?= $CT['doc'] ? ' An email app cannot carry your attachment, so please attach the document there yourself.' : '' ?></p>
            <div class="ct-alert__go">
              <a class="btn btn--ink" href="<?= e($CT['mailto']) ?>">Email the brief instead <span class="i" aria-hidden="true">›</span></a>
              <?php if ($CT['ref']): ?><span class="ct-alert__ref">Reference <?= e($CT['ref']) ?></span><?php endif; ?>
            </div>
          </div>
        </div>
      <?php elseif ($ct_err): ?>
        <div class="ct-alert" role="alert" tabindex="-1" id="ct-errs" data-ct-focus>
          <span class="ct-alert__ico" aria-hidden="true"><?= svc_icon('dot') ?></span>
          <div class="ct-alert__b">
            <p class="ct-alert__t"><?= count($ct_err) === 1 ? 'One thing to fix before we can send this.' : count($ct_err) . ' things to fix before we can send this.' ?></p>
            <ul class="ct-alert__list">
              <?php foreach ($ct_err as $ct_f => $ct_m): ?>
                <li><?php if ($ct_f === 'form'): ?><?= e($ct_m) ?><?php else: ?><a href="#ct-<?= e($ct_f) ?>"><?= e($ct_err_labels[$ct_f] ?? ucfirst($ct_f)) ?>: <?= e($ct_m) ?></a><?php endif; ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      <?php endif; ?>

      <?php if ($CT['dropped']): ?>
        <p class="ct-note"><?= $CT['dropped'] === 1 ? 'One service in the link you followed is no longer listed, so it is not selected below.' : $CT['dropped'] . ' services in the link you followed are no longer listed, so they are not selected below.' ?></p>
      <?php endif; ?>

      <!-- 01 · Who is asking -->
      <fieldset class="ct-set" data-pv-block="Who is asking" aria-describedby="ct-set1-d">
        <legend class="ct-set__lg"><span class="ct-set__n">01</span>Who is asking</legend>
        <p class="ct-set__d" id="ct-set1-d">So we know who to reply to, and in which hours. Fields marked <span class="ct-req">*</span> are required.</p>
        <div class="ct-fields">
          <div class="ct-field<?= isset($ct_err['name']) ? ' is-bad' : '' ?>">
            <label class="ct-label" for="ct-name">Name<?= $ct_req ?></label>
            <input class="ct-input" id="ct-name" name="name" type="text" autocomplete="name" maxlength="120" required value="<?= e($ct_v['name']) ?>" data-pv="Name"<?= $ct_fe('name') ?>>
            <?php if (isset($ct_err['name'])): ?><p class="ct-err" id="ct-e-name"><?= e($ct_err['name']) ?></p><?php endif; ?>
          </div>
          <div class="ct-field<?= isset($ct_err['email']) ? ' is-bad' : '' ?>">
            <label class="ct-label" for="ct-email">Work email<?= $ct_req ?></label>
            <input class="ct-input" id="ct-email" name="email" type="email" autocomplete="email" maxlength="190" required inputmode="email" value="<?= e($ct_v['email']) ?>" data-pv="Work email"<?= $ct_fe('email') ?>>
            <?php if (isset($ct_err['email'])): ?><p class="ct-err" id="ct-e-email"><?= e($ct_err['email']) ?></p><?php endif; ?>
          </div>
          <?php if (!$ct_app): ?>
          <div class="ct-field">
            <label class="ct-label" for="ct-company">Company <span class="ct-opt">Optional</span></label>
            <input class="ct-input" id="ct-company" name="company" type="text" autocomplete="organization" maxlength="160" value="<?= e($ct_v['company']) ?>" data-pv="Company">
          </div>
          <div class="ct-field">
            <label class="ct-label" for="ct-role">Your role <span class="ct-opt">Optional</span></label>
            <input class="ct-input" id="ct-role" name="role" type="text" autocomplete="organization-title" maxlength="120" placeholder="Head of Marketing, CTO, Founder…" value="<?= e($ct_v['role']) ?>" data-pv="Their role">
          </div>
          <?php endif; ?>
          <div class="ct-field<?= isset($ct_err['phone']) ? ' is-bad' : '' ?>">
            <label class="ct-label" for="ct-phone">Phone <span class="ct-opt">Optional</span></label>
            <input class="ct-input" id="ct-phone" name="phone" type="tel" autocomplete="tel" maxlength="40" value="<?= e($ct_v['phone']) ?>" data-pv="Phone"<?= $ct_fe('phone') ?>>
            <?php if (isset($ct_err['phone'])): ?><p class="ct-err" id="ct-e-phone"><?= e($ct_err['phone']) ?></p><?php endif; ?>
          </div>
          <?php if (!$ct_app): ?>
          <div class="ct-field<?= isset($ct_err['website']) ? ' is-bad' : '' ?>">
            <label class="ct-label" for="ct-website">Website <span class="ct-opt">Optional</span></label>
            <input class="ct-input" id="ct-website" name="website" type="url" autocomplete="url" maxlength="200" inputmode="url" placeholder="yourcompany.com" value="<?= e($ct_v['website']) ?>" data-pv="Website"<?= $ct_fe('website') ?>>
            <?php if (isset($ct_err['website'])): ?><p class="ct-err" id="ct-e-website"><?= e($ct_err['website']) ?></p><?php endif; ?>
          </div>
          <div class="ct-field">
            <label class="ct-label" for="ct-country">Country <span class="ct-opt">Optional</span></label>
            <input class="ct-input" id="ct-country" name="country" type="text" autocomplete="country-name" maxlength="80" value="<?= e($ct_v['country']) ?>" data-pv="Country">
          </div>
          <div class="ct-field">
            <label class="ct-label" for="ct-zone">Best hours to reach you <span class="ct-opt">Optional</span></label>
            <span class="ct-selw">
              <select class="ct-input ct-select" id="ct-zone" name="zone" data-pv="Best hours">
                <option value="">Choose a time zone</option>
                <?php foreach ($CT['zones'] as $ct_k => $ct_l): ?><option value="<?= e($ct_k) ?>"<?= $ct_v['zone'] === $ct_k ? ' selected' : '' ?>><?= e($ct_l) ?></option><?php endforeach; ?>
              </select>
            </span>
          </div>
          <?php endif; ?>
        </div>
      </fieldset>

      <?php if (!$ct_app): /* an application skips services, commercials and practicalities */ ?>
      <!-- 02 · What you need -->
      <fieldset class="ct-set ct-set--svc<?= isset($ct_err['service']) ? ' is-bad' : '' ?>" id="ct-service" data-pv-block="What they need" aria-describedby="ct-set2-d<?= isset($ct_err['service']) ? ' ct-e-service' : '' ?>">
        <legend class="ct-set__lg"><span class="ct-set__n">02</span>What you need</legend>
        <p class="ct-set__d" id="ct-set2-d">Six disciplines, every service we sell. Tick as many as you like — or skip it and describe the problem in block 03, and we will map it for you.</p>
        <?php if (isset($ct_err['service'])): ?><p class="ct-err" id="ct-e-service"><?= e($ct_err['service']) ?></p><?php endif; ?>

        <div class="ct-field ct-field--wide">
          <label class="ct-label" for="ct-kind">What kind of work is this? <span class="ct-opt">Optional</span></label>
          <span class="ct-selw">
            <select class="ct-input ct-select" id="ct-kind" name="kind" data-pv="Kind of work">
              <option value="">Choose the closest</option>
              <?php foreach ($CT['kinds'] as $ct_k => $ct_l): ?><option value="<?= e($ct_k) ?>"<?= $ct_v['kind'] === $ct_k ? ' selected' : '' ?>><?= e($ct_l) ?></option><?php endforeach; ?>
            </select>
          </span>
        </div>

        <div class="ct-find" hidden data-ct-find>
          <label class="bdh-sr" for="ct-q">Search services</label>
          <span class="ct-find__ico" aria-hidden="true"><?= svc_icon('search') ?></span>
          <input class="ct-find__in" id="ct-q" type="search" placeholder="Search every service, e.g. packaging, audit, React" autocomplete="off" data-ct-q>
          <p class="ct-find__n" aria-live="polite" data-ct-qn></p>
        </div>

        <div class="ct-discs" data-pv="Services" data-pv-kind="services">
          <?php foreach ($ct_groups as $ct_g): $ct_on2 = $ct_g['on_main'] + $ct_g['on_more']; ?>
            <details class="ct-disc" data-ct-disc data-slug="<?= e($ct_g['d']['slug']) ?>"<?= $ct_g['open'] ? ' open' : '' ?>>
              <summary class="ct-disc__s">
                <span class="ct-disc__n"><?= e($ct_g['d']['n']) ?></span>
                <span class="ct-disc__t"><?= e($ct_g['d']['name']) ?></span>
                <span class="ct-disc__c" data-ct-dcount><?= $ct_on2 ? $ct_on2 . ' selected' : '' ?></span>
                <span class="ct-disc__all"><?= $ct_g['n_main'] ?> services<?php if ($ct_g['n_more']): ?><span class="ct-disc__more"> · <?= $ct_g['n_more'] ?> in detail</span><?php endif; ?></span>
                <span class="ct-disc__pm" aria-hidden="true"></span>
              </summary>
              <div class="ct-disc__b">
                <?php foreach ($ct_g['main'] as $ct_b): ?>
                  <div class="ct-block" data-ct-block>
                    <p class="ct-block__h"><?= e($ct_b['label']) ?><?php if ($ct_b['sub']): ?> <span><?= e($ct_b['sub']) ?></span><?php endif; ?></p>
                    <ul class="ct-chips" data-meta="<?= e($ct_b['chips'][0]['meta'] ?? '') ?>">
                      <?php foreach ($ct_b['chips'] as $ct_x): ?>
                        <li data-ct-item data-s="<?= e($ct_x['search']) ?>"><label class="ct-chip"><input type="checkbox" name="service[]" value="<?= e($ct_x['id']) ?>"<?= $ct_x['meta'] !== ($ct_b['chips'][0]['meta'] ?? '') ? ' data-meta="' . e($ct_x['meta']) . '"' : '' ?><?= $ct_x['on'] ? ' checked' : '' ?>><span class="ct-chip__box" aria-hidden="true"></span><span class="ct-chip__n"><?= e($ct_x['name']) ?></span></label></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                <?php endforeach; ?>

                <?php if ($ct_g['more']): ?>
                  <div class="ct-caps" data-ct-caps>
                    <p class="ct-block__h">Every service, by capability page</p>
                    <?php foreach ($ct_g['more'] as $ct_b): $ct_bon = count(array_filter($ct_b['chips'], fn ($ct_x) => $ct_x['on']));
                      $ct_full = $ct_bon || $ct_v['from'] === $ct_b['key'];   /* arrived from this capability page: show its services */ ?>
                      <details class="ct-more" data-ct-more<?= $ct_full ? ' open' : '' ?>>
                        <summary class="ct-more__s">
                          <span class="ct-more__t"><?= e($ct_b['label']) ?></span>
                          <span class="ct-more__on" data-ct-mcount><?= $ct_bon ? $ct_bon . ' selected' : '' ?></span>
                          <span class="ct-more__c"><?= count($ct_b['chips']) ?> services</span>
                        </summary>
                        <div class="ct-more__b">
                          <div class="ct-block" data-ct-block>
                            <?php if ($ct_full): /* a pre-filled block renders in full, so the selection is visible and sent */ ?>
                            <ul class="ct-chips">
                              <?php foreach ($ct_b['chips'] as $ct_x): ?>
                                <li data-ct-item data-s="<?= e($ct_x['search']) ?>"><label class="ct-chip"><input type="checkbox" name="service[]" value="<?= e($ct_x['id']) ?>" data-meta="<?= e($ct_x['meta']) ?>"<?= $ct_x['on'] ? ' checked' : '' ?>><span class="ct-chip__box" aria-hidden="true"></span><span class="ct-chip__n"><?= e($ct_x['name']) ?></span></label></li>
                              <?php endforeach; ?>
                            </ul>
                            <?php else: /* the rest load on demand (contact.js, ?ct_more=1) to keep the page light */ ?>
                            <ul class="ct-chips" data-ct-lazy="<?= e($ct_b['key']) ?>"></ul>
                            <p class="ct-more__nojs" data-ct-lazyn>These <?= count($ct_b['chips']) ?> services list here with JavaScript on. Without it, name what you need in your message, or read the <a class="tl" href="<?= e($ct_b['url']) ?>"><?= e($ct_b['label']) ?> page</a>.</p>
                            <?php endif; ?>
                          </div>
                        </div>
                      </details>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
              </div>
            </details>
          <?php endforeach; ?>
        </div>
        <p class="ct-find__none" hidden data-ct-none>No service matches that. Describe what you need in your message and we will route it.</p>
      </fieldset>
      <?php endif; ?>

      <!-- 03 · The problem -->
      <fieldset class="ct-set" data-pv-block="The brief" aria-describedby="ct-set3-d">
        <legend class="ct-set__lg"><span class="ct-set__n">03</span><?= $ct_app ? 'About you and your work' : 'The problem, in your words' ?></legend>
        <p class="ct-set__d" id="ct-set3-d"><?= $ct_app
          ? 'A few lines on why this role, and links to your portfolio, CV or code.'
          : 'The one block we read first. Plain language beats a specification: what is happening, what it is costing you, and what you have already tried.' ?></p>
        <div class="ct-field<?= isset($ct_err['message']) ? ' is-bad' : '' ?>">
          <label class="ct-label" for="ct-message"><?= $ct_app ? 'Your application' : 'What is the problem?' ?><?php if (!$ct_app): ?><?= $ct_v['depth'] === 'rfq' ? $ct_req : '' ?><?php endif; ?> <span class="ct-opt"><?= $ct_app ? 'Why this role, and where we can see your work' : 'Two sentences is plenty to start' ?></span></label>
          <textarea class="ct-input ct-area" id="ct-message" name="message" rows="7" maxlength="4000" placeholder="<?= $ct_app ? '' : 'Our booking flow drops 40% of people at payment and nobody can tell us why…' ?>" aria-describedby="ct-message-n" data-pv="The problem" data-pv-long data-ct-msg<?= $ct_fe('message') ?>><?= e($ct_v['message']) ?></textarea>
          <?php if (isset($ct_err['message'])): ?><p class="ct-err" id="ct-e-message"><?= e($ct_err['message']) ?></p><?php endif; ?>
          <p class="ct-count" id="ct-message-n" data-ct-count>Up to 4,000 characters.</p>
        </div>

        <?php if (!$ct_app): ?>
        <details class="ct-fold" id="ct-fold-detail"<?= $ct_open_detail ? ' open' : '' ?> data-ct-fold="detail">
          <summary class="ct-fold__s">
            <span class="ct-fold__t">Four questions that turn a brief into a quote</span>
            <span class="ct-fold__c">4 optional</span>
            <span class="ct-fold__pm" aria-hidden="true"></span>
          </summary>
          <div class="ct-fold__b">
            <div class="ct-field">
              <label class="ct-label" for="ct-goals">What does success look like? <span class="ct-opt">Optional</span></label>
              <textarea class="ct-input ct-area ct-area--s" id="ct-goals" name="goals" rows="3" maxlength="2000" placeholder="Checkout completion back above 70%, and a team that can change the flow without us." data-pv="Goals" data-pv-long><?= e($ct_v['goals']) ?></textarea>
            </div>
            <div class="ct-field">
              <label class="ct-label" for="ct-audience">Who is it for? <span class="ct-opt">Optional</span></label>
              <textarea class="ct-input ct-area ct-area--s" id="ct-audience" name="audience" rows="2" maxlength="800" placeholder="Customers, markets, languages, internal teams…" data-pv="Audience" data-pv-long><?= e($ct_v['audience']) ?></textarea>
            </div>
            <div class="ct-field">
              <label class="ct-label" for="ct-current">What exists today? <span class="ct-opt">Optional</span></label>
              <textarea class="ct-input ct-area ct-area--s" id="ct-current" name="current" rows="3" maxlength="1500" placeholder="The platform, the stack, the brand guidelines, the agency you work with, links we can look at." data-pv="What exists today" data-pv-long><?= e($ct_v['current']) ?></textarea>
            </div>
            <div class="ct-field">
              <label class="ct-label" for="ct-measures">Which numbers should move? <span class="ct-opt">Optional</span></label>
              <textarea class="ct-input ct-area ct-area--s" id="ct-measures" name="measures" rows="2" maxlength="1000" placeholder="Conversion, cost per lead, time to publish, INP, support tickets…" data-pv="How success is measured" data-pv-long><?= e($ct_v['measures']) ?></textarea>
            </div>
            <p class="ct-fold__note">Answer none of these and we will still reply — we will just ask them on the call instead.</p>
          </div>
        </details>
        <?php endif; ?>
      </fieldset>

      <?php if (!$ct_app): ?>
      <!-- 04 · Commercials and the decision -->
      <details class="ct-set ct-set--fold" id="ct-fold-money" data-pv-block="Commercials and the decision"<?= $ct_open_money ? ' open' : '' ?> data-ct-fold="money">
        <summary class="ct-set__sum">
          <span class="ct-set__n">04</span>
          <span class="ct-set__lgt">Commercials and the decision</span>
          <span class="ct-set__c">7 optional</span>
          <span class="ct-fold__pm" aria-hidden="true"></span>
        </summary>
        <div class="ct-set__b">
          <p class="ct-set__d">None of it is binding. A range and a decision stage let us propose a scope that fits the first time, instead of a proposal you have to send back.</p>

          <p class="ct-sub">Engagement model</p>
          <div class="ct-pks" data-pv="Engagement" data-pv-kind="package">
            <?php foreach ($ct_pks as $ct_k => $ct_p): ?>
              <label class="ct-pk">
                <input type="radio" name="package" value="<?= e($ct_k) ?>" data-name="<?= e($ct_p['name']) ?>" data-meta="<?= e($ct_p['pricing'] . ' · ' . $ct_p['duration']) ?>"<?= $ct_v['package'] === $ct_k ? ' checked' : '' ?>>
                <span class="ct-pk__top">
                  <span class="ct-pk__ico" aria-hidden="true"><?= svc_icon($ct_p['icon'] ?? 'dot') ?></span>
                  <span class="ct-pk__dot" aria-hidden="true"></span>
                </span>
                <span class="ct-pk__n"><?= e($ct_p['name']) ?></span>
                <span class="ct-pk__d"><?= e($ct_p['tagline']) ?></span>
                <span class="ct-pk__m"><span><?= e($ct_p['pricing']) ?></span><span><?= e($ct_p['duration']) ?></span></span>
              </label>
            <?php endforeach; ?>
            <label class="ct-pk ct-pk--none">
              <input type="radio" name="package" value="" data-name="" data-meta=""<?= $ct_v['package'] === '' ? ' checked' : '' ?>>
              <span class="ct-pk__top">
                <span class="ct-pk__ico" aria-hidden="true"><?= svc_icon('compass') ?></span>
                <span class="ct-pk__dot" aria-hidden="true"></span>
              </span>
              <span class="ct-pk__n">Not sure yet</span>
              <span class="ct-pk__d">Tell us the problem and we will recommend the way to work that fits it.</span>
            </label>
          </div>
          <!-- PLACEHOLDER: confirm the typical durations shown on the engagement cards before launch -->

          <p class="ct-sub">Budget, timing and the decision</p>
          <div class="ct-fields">
            <div class="ct-field">
              <label class="ct-label" for="ct-budget">Budget range <span class="ct-opt">Optional</span></label>
              <span class="ct-selw">
                <select class="ct-input ct-select" id="ct-budget" name="budget" data-pv="Budget">
                  <option value="">Prefer not to say</option>
                  <?php foreach ($CT['budgets'] as $ct_k => $ct_l): ?><option value="<?= e($ct_k) ?>"<?= $ct_v['budget'] === $ct_k ? ' selected' : '' ?>><?= e($ct_l) ?></option><?php endforeach; ?>
                </select>
              </span>
            </div>
            <div class="ct-field">
              <label class="ct-label" for="ct-timeline">When would you like to start? <span class="ct-opt">Optional</span></label>
              <span class="ct-selw">
                <select class="ct-input ct-select" id="ct-timeline" name="timeline" data-pv="Timing">
                  <option value="">Choose a timeframe</option>
                  <?php foreach ($CT['timelines'] as $ct_k => $ct_l): ?><option value="<?= e($ct_k) ?>"<?= $ct_v['timeline'] === $ct_k ? ' selected' : '' ?>><?= e($ct_l) ?></option><?php endforeach; ?>
                </select>
              </span>
            </div>
            <div class="ct-field<?= isset($ct_err['deadline']) ? ' is-bad' : '' ?>">
              <label class="ct-label" for="ct-deadline">Is there a date it must be live? <span class="ct-opt">Optional</span></label>
              <input class="ct-input" id="ct-deadline" name="deadline" type="date" min="<?= e(date('Y-m-d')) ?>" max="<?= e(date('Y-m-d', strtotime('+3 years'))) ?>" value="<?= e($ct_v['deadline']) ?>" data-pv="Fixed date"<?= $ct_fe('deadline') ?>>
              <?php if (isset($ct_err['deadline'])): ?><p class="ct-err" id="ct-e-deadline"><?= e($ct_err['deadline']) ?></p><?php endif; ?>
            </div>
            <div class="ct-field">
              <label class="ct-label" for="ct-decision">Where are you in the decision? <span class="ct-opt">Optional</span></label>
              <span class="ct-selw">
                <select class="ct-input ct-select" id="ct-decision" name="decision" data-pv="Decision stage">
                  <option value="">Choose the closest</option>
                  <?php foreach ($CT['decisions'] as $ct_k => $ct_l): ?><option value="<?= e($ct_k) ?>"<?= $ct_v['decision'] === $ct_k ? ' selected' : '' ?>><?= e($ct_l) ?></option><?php endforeach; ?>
                </select>
              </span>
            </div>
            <div class="ct-field">
              <label class="ct-label" for="ct-buying">How would this be bought? <span class="ct-opt">Optional</span></label>
              <span class="ct-selw">
                <select class="ct-input ct-select" id="ct-buying" name="buying" data-pv="How it is bought">
                  <option value="">Choose the closest</option>
                  <?php foreach ($CT['buyings'] as $ct_k => $ct_l): ?><option value="<?= e($ct_k) ?>"<?= $ct_v['buying'] === $ct_k ? ' selected' : '' ?>><?= e($ct_l) ?></option><?php endforeach; ?>
                </select>
              </span>
            </div>
            <div class="ct-field">
              <label class="ct-label" for="ct-stakeholders">Who else is involved? <span class="ct-opt">Optional</span></label>
              <input class="ct-input" id="ct-stakeholders" name="stakeholders" type="text" maxlength="300" placeholder="Roles, not names — CTO, procurement, legal, an incumbent agency" value="<?= e($ct_v['stakeholders']) ?>" data-pv="Others involved">
            </div>
          </div>
        </div>
      </details>

      <!-- 05 · Practicalities -->
      <details class="ct-set ct-set--fold" id="ct-fold-prac" data-pv-block="Practicalities"<?= $ct_open_prac ? ' open' : '' ?> data-ct-fold="prac">
        <summary class="ct-set__sum">
          <span class="ct-set__n">05</span>
          <span class="ct-set__lgt">Practicalities</span>
          <span class="ct-set__c">3 optional</span>
          <span class="ct-fold__pm" aria-hidden="true"></span>
        </summary>
        <div class="ct-set__b">
          <p class="ct-set__d">The three things that change how we reply, rather than what we reply.</p>
          <div class="ct-fields">
            <div class="ct-field">
              <label class="ct-label" for="ct-heard">How did you hear about us? <span class="ct-opt">Optional</span></label>
              <span class="ct-selw">
                <select class="ct-input ct-select" id="ct-heard" name="heard" data-pv="Heard about us">
                  <option value="">Choose one</option>
                  <?php foreach ($CT['heards'] as $ct_k => $ct_l): ?><option value="<?= e($ct_k) ?>"<?= $ct_v['heard'] === $ct_k ? ' selected' : '' ?>><?= e($ct_l) ?></option><?php endforeach; ?>
                </select>
              </span>
            </div>
            <div class="ct-field">
              <label class="ct-label" for="ct-heard-note">Anything to add to that? <span class="ct-opt">Optional</span></label>
              <input class="ct-input" id="ct-heard-note" name="heard_note" type="text" maxlength="200" placeholder="Who referred you, which article, which event" value="<?= e($ct_v['heard_note']) ?>" data-pv-join="Heard about us">
            </div>
          </div>
          <div class="ct-checks">
            <label class="ct-check">
              <input type="checkbox" id="ct-nda" name="nda" value="1"<?= $ct_v['nda'] === '1' ? ' checked' : '' ?> data-pv="NDA first" data-pv-kind="check" data-pv-yes="Yes — before anything detailed is shared">
              <span class="ct-check__box" aria-hidden="true"></span>
              <span class="ct-check__b">
                <b>We need an NDA before we share the detail</b>
                <span>We will send ours, or sign yours. Either way it happens before the first call, not after it.</span>
              </span>
            </label>
          </div>
          <div class="ct-field">
            <label class="ct-label" for="ct-access">Accessibility or language needs <span class="ct-opt">Optional</span></label>
            <textarea class="ct-input ct-area ct-area--s" id="ct-access" name="access" rows="2" maxlength="800" placeholder="Captions or a transcript on calls, a language other than English, written rather than spoken, a time that suits a screen reader…" data-pv="Access or language" data-pv-long><?= e($ct_v['access']) ?></textarea>
          </div>
        </div>
      </details>

      <!-- 06 · The document -->
      <fieldset class="ct-set ct-set--doc<?= isset($ct_err['doc']) ? ' is-bad' : '' ?>" id="ct-doc-set" aria-describedby="ct-set6-d">
        <legend class="ct-set__lg"><span class="ct-set__n">06</span>Already have an RFQ?</legend>
        <p class="ct-set__d" id="ct-set6-d">Attach it and answer as little of the rest as you like. We read the document; the fields above just help us route it before anyone opens the attachment.</p>
        <?php if ($CT['max_doc'] > 0): ?>
          <div class="ct-file">
            <label class="ct-file__drop" for="ct-doc">
              <span class="ct-file__ico" aria-hidden="true"><?= svc_icon('doc') ?></span>
              <span class="ct-file__main">
                <b>Attach a brief, RFQ or deck</b>
                <span class="ct-file__hint" data-ct-filename>PDF, DOC, DOCX, PPT or PPTX · up to <?= e(ct_size($CT['max_doc'])) ?> on this server</span>
              </span>
              <span class="ct-file__btn" aria-hidden="true">Choose a file</span>
            </label>
            <input class="ct-file__in" id="ct-doc" name="doc" type="file" accept=".pdf,.doc,.docx,.ppt,.pptx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation" aria-describedby="ct-doc-n<?= isset($ct_err['doc']) ? ' ct-e-doc' : '' ?>" data-ct-file<?= isset($ct_err['doc']) ? ' aria-invalid="true"' : '' ?>>
            <?php if (isset($ct_err['doc'])): ?><p class="ct-err" id="ct-e-doc"><?= e($ct_err['doc']) ?></p><?php endif; ?>
            <p class="ct-file__note" id="ct-doc-n">The file is never written to this website. It is read once, attached to the email that reaches the lead, and deleted. We check what is inside it, not what it is named.</p>
          </div>
        <?php else: ?>
          <p class="ct-file__note">Uploads are switched off on this server. Send the brief and reply to our email with the document attached.</p>
        <?php endif; ?>
      </fieldset>
      <?php endif; ?>

      <div class="ct-send">
        <div class="ct-send__b">
          <p class="ct-consent">By sending this <?= $ct_app ? 'application' : 'brief' ?> you agree that we use these details to reply to it. Nothing is added to a mailing list, and nothing is shared outside the team.</p>
          <p class="ct-consent ct-consent--2">Read the <a href="<?= xe_url('legal/privacy.php') ?>">Privacy Notice</a> for how long we keep it and how to have it deleted.</p>
        </div>
        <button class="btn btn--ink btn--lg ct-send__btn" type="submit" data-ct-send><?= $ct_app ? 'Send the application' : 'Send the brief' ?> <span class="i" aria-hidden="true">›</span></button>
      </div>
    </div>

    <aside class="ct-side<?= ($ct_rows || $ct_pkg || $ct_app) ? ' ct-side--lead' : '' ?>" aria-labelledby="ct-brief-t">
      <div class="ct-brief" data-ct-brief>
        <div class="ct-brief__head">
          <h3 class="ct-brief__t" id="ct-brief-t"><?= $ct_app ? 'Your application' : 'Your brief' ?></h3>
          <?php if (!$ct_app): ?><span class="ct-brief__c" data-ct-bcount><?= count($ct_rows) === 1 ? '1 service' : count($ct_rows) . ' services' ?></span><?php endif; ?>
        </div>

        <?php if (!$ct_app): ?>
        <div class="ct-meter" data-ct-meter>
          <p class="ct-meter__k"><span>Completeness</span><b data-ct-mcount><?= $ct_on ?> of <?= $ct_all ?></b></p>
          <span class="ct-meter__track" aria-hidden="true"><i class="ct-meter__fill" data-ct-mfill style="width:<?= $ct_all ? round($ct_on / $ct_all * 100) : 0 ?>%"></i></span>
          <p class="ct-meter__d" data-ct-mnote>Two answers are enough to send. Every extra one takes a question out of the first call.</p>
        </div>
        <?php endif; ?>

        <?php if ($ct_from): ?>
          <p class="ct-brief__from"><span>From</span><a href="<?= e($ct_from['url']) ?>"><?= e($ct_from['name']) ?></a></p>
        <?php endif; ?>

        <?php if ($ct_app): ?>
          <p class="ct-brief__role"><span>Role</span><b><?= e($ct_app['role']) ?></b><span>Reference <?= e($ct_app['id']) ?></span></p>
        <?php endif; ?>
        <ul class="ct-brief__list" data-ct-blist<?= $ct_app ? ' hidden' : '' ?>>
          <?php foreach ($ct_rows as $ct_r): ?>
            <li class="ct-bi">
              <span class="ct-bi__n"><?= e($ct_r['name']) ?></span>
              <span class="ct-bi__m"><?= e($ct_r['discipline'] . ' · ' . ($ct_r['hub'] ? 'Overview' : $ct_r['page']) . ' · ' . $ct_r['category']) ?></span>
              <a class="ct-bi__x" href="<?= e($ct_without($ct_r['id'], false)) ?>" data-ct-rm="<?= e($ct_r['id']) ?>" aria-label="Remove <?= e($ct_r['name']) ?> from your brief"><?= svc_icon('x') ?></a>
            </li>
          <?php endforeach; ?>
        </ul>
        <?php if (!$ct_app): ?><p class="ct-brief__empty" data-ct-bempty<?= $ct_rows ? ' hidden' : '' ?>>No services chosen yet. Pick some from the list, or simply tell us the problem.</p><?php endif; ?>

        <div class="ct-brief__pk" data-ct-bpk<?= $ct_pkg ? '' : ' hidden' ?>>
          <span class="ct-brief__pkk">Engagement</span>
          <span class="ct-brief__pkn" data-ct-bpkn><?= $ct_pkg ? e($ct_pkg['name']) : '' ?></span>
          <span class="ct-brief__pkm" data-ct-bpkm><?= $ct_pkg ? e($ct_pkg['pricing'] . ' · ' . $ct_pkg['duration']) : '' ?></span>
          <a class="ct-bi__x" href="<?= e($ct_without(null, true)) ?>" data-ct-rmpk aria-label="Remove the engagement model from your brief"><?= svc_icon('x') ?></a>
        </div>

        <ol class="ct-brief__next">
          <?php if ($ct_app): ?>
            <li><span>01</span>The hiring lead for the role reads it.</li>
            <li><span>02</span>We aim to reply within five working days.</li>
            <li><span>03</span>A first call if it is a fit.</li>
          <?php else: ?>
            <li><span>01</span>It goes to the lead for that discipline.</li>
            <li><span>02</span>We aim to reply within one working day.</li>
            <li><span>03</span>A thirty-minute call, then a written scope.</li>
          <?php endif; ?>
        </ol>
        <?php if (!$ct_app): ?><p class="ct-brief__pv"><a class="tl" href="#inbox">See exactly what we receive <span class="i" aria-hidden="true">›</span></a></p><?php endif; ?>
      </div>

      <div class="ct-direct">
        <p class="ct-direct__k">Prefer to write or talk?</p>
        <a class="ct-direct__mail" href="mailto:<?= e($SITE['company']['email']) ?>"><?= e($SITE['company']['email']) ?></a>
        <a class="tl" href="<?= xe_url('index.php#book') ?>">Book a thirty-minute call <span class="i" aria-hidden="true">›</span></a>
        <a class="tl" href="#reach">Other inboxes and our offices <span class="i" aria-hidden="true">›</span></a>
      </div>
    </aside>

  </div>
</section>
