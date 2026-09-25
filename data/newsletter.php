<?php
/* DRAFT COPY — review before launch.
 * =====================================================================================================
 * THE DISPATCH — everything /newsletter shows comes from here
 * =====================================================================================================
 *
 * <!-- PLACEHOLDER: confirm the newsletter's name, its cadence and its sending address before launch.
 *      Nothing in this file is a record of a sent issue. The three archive entries and the sample
 *      issue are written in-house as a proof of the format, and every one of them renders on the page
 *      with a visible "sample" mark. No subscriber count, no open rate and no issue number is stated
 *      anywhere on the page, because none of them exists yet. -->
 *
 * -----------------------------------------------------------------------------------------------------
 * HOW THE PAGE USES THIS FILE
 * -----------------------------------------------------------------------------------------------------
 * newsletter.php does `$NLT = require data/newsletter.php;` and every partial in partials/newsletter/
 * reads from $NLT. Nothing here is rendered as raw HTML: each partial escapes with e(), so write plain
 * text and use the curly apostrophe (’) as the rest of the site does.
 *
 * 'meta'      the standing facts — all targets, never achieved results
 * 'blocks'    the six blocks every issue is made of. THE CONTRACT. Each block is:
 *               'key'    short id, used for anchors and tab ids
 *               'n'      the printed index
 *               'name'   what the block is called in the issue
 *               'short'  the short label the sample reader puts on its tab
 *               'job'    why the block exists — one sentence
 *               'never'  what the block will never contain — one sentence
 *               'words'  the target length in words (a target, never a measurement)
 *               'icon'   an xt_icon() name
 *               'sample' the block as it would appear in a real issue:
 *                          'head'  the line the reader sees
 *                          'body'  paragraphs, as a list of strings
 *                          'items' optional [label, text, link?] rows (link = a page.php on this site)
 *                          'note'  optional small print under the block
 * 'issue'     the wrapper around the sample issue — subject line, preheader, who it is from
 * 'readers'   who it is for: [code, who, uses it for, skip it if]
 * 'promise'   two ledgers: what it is / what it is not
 * 'privacy'   the promises about an address, each with the mechanism that keeps it
 * 'stored'    every field the sign-up would hold once the email service is connected
 * 'archive'   sample issues. EVERY ONE IS MARKED AS A SAMPLE ON THE PAGE. Replace with real issues,
 *             or empty the list — the section renders an honest empty state when it is empty.
 * 'topics'    the optional interest boxes on the full sign-up form. Keys are stored in the notification
 *             email; they are not a filter that exists yet, and the form says so.
 * 'faq'       three groups of questions. The ANSWER strings are authored HTML (they may carry a link
 *             or a PLACEHOLDER comment) and are echoed raw by partials/newsletter/faq.php; everything
 *             else in this file is plain text and is escaped with e(). Do not put a visitor's words,
 *             or anything you did not write yourself, into an answer string.
 */

return [

    'meta' => [
        // PLACEHOLDER: confirm the newsletter's name before launch.
        'name'      => 'The Dispatch',
        'from'      => 'Xterra Edze',
        'line'      => 'Written notes from the people building the work, once a month.',
        // Every figure below is a TARGET agreed for the format, not a measurement of anything sent.
        'cadence'   => 'One issue a month',
        'cadence_n' => 12,
        'skip'      => 'A month with nothing worth sending is skipped, not padded.',
        'window'    => 'Tuesday morning, India Standard Time',
        'length'    => 'Under 900 words',
        'blocks_n'  => 6,
        // PLACEHOLDER: confirm the sending address and the reply-to address before launch.
        'sender'    => 'dispatch@xterraedze.com',
        'reply'     => 'Every issue is sent from an address a person reads.',
        'status'    => 'The first issue has not gone out yet.',
    ],

    'issue' => [
        'label'     => 'Sample issue',
        'subject'   => 'We stopped writing prompts first',
        'preheader' => 'One change of mind, three things worth reading, and one number with its definition.',
        'to'        => 'you@yourcompany.com',
        'desk'      => 'Technology & Intelligence desk',
    ],

    'blocks' => [
        [
            'key'   => 'mind',
            'short' => 'Change of mind',
            'n'     => '01',
            'name'  => 'One thing we changed our mind about',
            'job'   => 'Open with a position we held, what broke it, and what we do now instead.',
            'never' => 'Never a prediction about the industry, and never a position nobody at the company actually held.',
            'words' => 180,
            'icon'  => 'lightbulb',
            'sample' => [
                'head' => 'We stopped writing prompts first.',
                'body' => [
                    'For most of last year the first artefact on an AI feature was a prompt. It reads like progress: something exists, it answers, a demo can be booked. Then the model changes, the retrieval index is rebuilt, someone tightens a system message, and nobody can say whether the thing got better or worse.',
                    'The first artefact is now an eval set — thirty to a hundred real cases with the answer a domain expert would accept, and a written rule for what counts as right. Writing it is slower and considerably duller. It also settles the argument, because a change that drops the score below the gate does not ship, no matter how good the demo felt.',
                    'The practical cost is about two days at the start of a build. The practical return is that every later change takes an afternoon to judge instead of a week to argue about.',
                ],
            ],
        ],
        [
            'key'   => 'reading',
            'short' => 'Reading',
            'n'     => '02',
            'name'  => 'Three things worth your time',
            'job'   => 'Three pieces of reading, each with the reason it is here rather than a summary of it.',
            'never' => 'Never a link without a reason, and never a link we have not read to the end.',
            'words' => 140,
            'icon'  => 'doc',
            'sample' => [
                'head' => 'What we read this month, and why.',
                'items' => [
                    ['Our own', 'Evals before agents — the long version of the note above, including the shape of a golden set and what to do when experts disagree with each other.', 'blog/evals-before-agents.php'],
                    ['Our own', 'Core Web Vitals are a field measurement, not a lab score — why a green Lighthouse run on a developer’s laptop tells you almost nothing about the 75th percentile.', 'blog/core-web-vitals-are-field-data.php'],
                    ['Elsewhere', 'The Green Software Foundation’s Software Carbon Intensity specification, now ISO/IEC 21031:2024. Worth an hour if anyone has asked you to put a carbon number in a board pack. Linked in full in the email.'],
                ],
                'note' => 'External links are written out in the email so you can see where they go before you click.',
            ],
        ],
        [
            'key'   => 'number',
            'short' => 'The number',
            'n'     => '03',
            'name'  => 'One number, defined',
            'job'   => 'A single measure, with its threshold, its population and the mistake people make reading it.',
            'never' => 'Never a number from a client’s system, and never a figure without the definition printed beside it.',
            'words' => 160,
            'icon'  => 'gauge',
            'sample' => [
                'head' => 'INP ≤ 200 ms.',
                'body' => [
                    'Interaction to Next Paint is the Core Web Vitals responsiveness metric. It replaced First Input Delay in March 2024 and it measures something FID did not: the whole interaction, from the tap to the next frame the browser paints, including the work your JavaScript does in between.',
                    'Good is 200 ms or less. Between 200 ms and 500 ms needs improvement; above 500 ms is poor. The number that counts is the 75th percentile of real visits over a rolling 28 days — not a lab run, and not the median.',
                    'The common mistake is reading an average. An average INP of 180 ms with a heavy tail is a page that feels broken for a quarter of the people using it, and the p75 is the figure that says so.',
                ],
                'note' => 'The other two: LCP ≤ 2.5 s, CLS ≤ 0.1, at the same 75th percentile of field data.',
            ],
        ],
        [
            'key'   => 'work',
            'short' => 'From the work',
            'n'     => '04',
            'name'  => 'From the work',
            'job'   => 'One thing that changed in how we build, described concretely enough to copy.',
            'never' => 'Never a client name, never a logo, and never a result a client has not approved in writing.',
            'words' => 130,
            'icon'  => 'wrench',
            'sample' => [
                'head' => 'The eval suite now runs on a schedule, not on a push.',
                'body' => [
                    'Running the golden set on every commit sounded right and behaved badly: model providers change behaviour between releases, so a suite that only runs when someone pushes code goes quiet exactly when the ground is moving underneath it.',
                    'It now runs nightly against production configuration as well as on every change, and a drop below the gate opens a ticket with the failing cases attached. Three of the last drops we caught this way had no code change behind them at all.',
                ],
                'note' => 'No client is named in this section, ever. Where a number would identify one, it is left out.',
            ],
        ],
        [
            'key'   => 'question',
            'short' => 'A question',
            'n'     => '05',
            'name'  => 'One question, answered',
            'job'   => 'A question a reader actually sent, answered straight, with the reasoning shown.',
            'never' => 'Never a question we wrote ourselves to set up a pitch.',
            'words' => 130,
            'icon'  => 'chat',
            'sample' => [
                'head' => '“How many eval cases is enough?”',
                'body' => [
                    'Enough that a real failure mode appears more than once. In practice that is thirty to fifty cases for a narrow task and a few hundred for anything that touches free text, split so that roughly a third of them are the awkward ones — the ambiguous, the out-of-scope and the deliberately hostile.',
                    'Coverage matters more than volume. A thousand cases drawn from the same three templates will pass a model that fails on the fourth thing a customer types.',
                ],
                'note' => 'Reply to any issue with a question. The ones we can answer usefully appear here, with the sender’s name removed unless they ask for it.',
            ],
        ],
        [
            'key'   => 'housekeeping',
            'short' => 'Housekeeping',
            'n'     => '06',
            'name'  => 'The housekeeping',
            'job'   => 'Where the email came from, what we hold, and how to stop it — in every issue, at the same place.',
            'never' => 'Never a tracking pixel, and never an unsubscribe link that takes more than one click.',
            'words' => 70,
            'icon'  => 'shield',
            'sample' => [
                'head' => 'How to leave, and what we hold.',
                'body' => [
                    'One click at the bottom of the email removes you, with no confirmation page and no survey. We hold your address, the date you confirmed it and the page you signed up from. Nothing else.',
                    'Replies go to a person at the desk that wrote the issue, not to a no-reply address.',
                ],
            ],
        ],
    ],

    'readers' => [
        ['CTO', 'Engineering and technology leaders',
         'A short monthly read that keeps one argument per issue, with the definition attached, so you can forward it instead of explaining it.',
         'You want release notes for a specific vendor’s product.'],
        ['PRD', 'Product and design leads',
         'The decisions taken before anything was built, and the ones we got wrong — written by the people who took them.',
         'You are looking for tool round-ups or design inspiration boards.'],
        ['MKT', 'Marketing and growth leaders',
         'What is actually measurable in a stack you already own, and what a number means before anyone puts it in a board pack.',
         'You want channel tactics or campaign templates.'],
        ['OPS', 'Founders and operators',
         'Enough technical grounding to ask a supplier a hard question, without a glossary.',
         'You need a vendor shortlist or a procurement checklist — that is a conversation, not a newsletter.'],
    ],

    'promise' => [
        'is' => [
            ['One argument per issue', 'Each issue makes one point properly rather than six points badly.'],
            ['Written by the desk that did the work', 'The Technology & Intelligence, Product & Experience and Marketing Technology desks write in turn, under their own names.'],
            ['Specific enough to act on', 'Thresholds, definitions and the reasoning behind a decision, not a trend summary.'],
            ['Honest about what went wrong', 'The changes of mind are the point. An issue with nothing we got wrong in it is usually an issue not worth sending.'],
            ['Readable in one sitting', 'Under 900 words, plain HTML, and a plain-text part that reads properly on its own.'],
        ],
        'not' => [
            ['Not a company news feed', 'No hiring announcements, no award posts, no “we are excited to share”.'],
            ['Not a drip sequence', 'Subscribing does not start an automated series of emails, and it never puts you into a sales sequence.'],
            ['Not a lead magnet', 'There is no gated PDF behind this, and no sales call attached to it.'],
            ['Not tracked', 'No tracking pixel, no per-recipient link rewriting, no open or click reporting.'],
            ['Not a re-post of the journal', 'Posts are linked with the reason they are worth your time. The reason is the part that is written for the email.'],
        ],
    ],

    'privacy' => [
        ['We never sell, rent or share your address', 'It is not passed to advertisers, data brokers, partners or any other company, at any price.',
         'The only third party that ever holds it is the email service that sends the issue, as a processor under contract.'],
        ['We never track whether you opened it', 'No tracking pixel is embedded and no per-recipient link rewriting is used, so there is no open rate and no click report to read.',
         'This is set in the sending service’s configuration and is checked on every send.'],
        ['We never add an address that did not ask', 'No address is imported from a conference list, a scraped source or a business card, and a contact-form enquiry does not subscribe you.',
         'Confirmed opt-in: you are on the list only after clicking the link in the confirmation email.'],
        ['We never use it for sales outreach', 'Subscribing does not make you a lead. The address is used to send the issue and nothing else.',
         'Newsletter addresses are kept apart from anything a salesperson can reach.'],
        ['We never make leaving hard', 'One click at the bottom of any issue. No confirmation page, no survey, no “are you sure”.',
         'The unsubscribe link and the List-Unsubscribe header are both on every issue.'],
        ['We never keep it once you leave', 'An unsubscribe removes the address rather than flagging it, except for the single record needed to make sure it is not added again by mistake.',
         'Retention and deletion are set out in the Privacy Notice.'],
    ],

    'stored' => [
        ['Email address', 'The address the issue is sent to.', 'Until you unsubscribe'],
        ['Confirmation date', 'The moment you clicked the link in the confirmation email — the record that consent was given.', 'Until you unsubscribe'],
        ['Sign-up page', 'Which page on this site the form was submitted from, so we can tell which writing brings people in.', 'Until you unsubscribe'],
        ['Chosen interests', 'The optional boxes below, if you tick any. Used to decide what to write, not to segment sends today.', 'Until you unsubscribe'],
        ['Delivery failures', 'Whether the last issue bounced, so a dead address stops being mailed.', 'Rolling, most recent only'],
    ],

    'topics' => [
        'ai'        => 'AI systems, agents and evals',
        'platform'  => 'Platforms, performance and reliability',
        'product'   => 'Product and experience decisions',
        'martech'   => 'Marketing technology and data',
        'green'     => 'Sustainable and efficient software',
    ],

    /* Sample issues. Each renders with a visible "sample" mark and no issue number, because no issue
       has been sent. Replace with real issues once the first one goes out, or empty the list. */
    'archive' => [
        ['We stopped writing prompts first',
         'Why the first artefact on an AI build is now an eval set, what that costs, and the number it settles.',
         'Technology & Intelligence desk', ['ai', 'platform']],
        ['The number in the board pack',
         'Three measures that get quoted without their definitions — INP, SLO attainment and cost per thousand requests — and what each one actually says.',
         'Marketing Technology desk', ['martech', 'platform']],
        ['What we removed this quarter',
         'Four things we took out of a delivery process, and the two we had to put back.',
         'Product & Experience desk', ['product']],
    ],

    'faq' => [
        ['The reading', [
            ['How often does it arrive?',
             'The target is one issue a month, sent on a Tuesday morning in India Standard Time. A month with nothing worth sending is skipped rather than padded, so some years will have fewer than twelve. <!-- PLACEHOLDER: confirm the cadence and the send window before launch. -->'],
            ['Who writes it?',
             'The practice that did the work. The Technology & Intelligence, Product & Experience and Marketing Technology desks take it in turn, and the desk is named at the top of every issue. It is not written by a marketing team from a brief.'],
            ['How is AI used in writing it?',
             'For structure, edit passes and checking our own arguments back. Drafting comes from the people who did the work, every technical claim is checked against a primary source, and a person who did not write the issue reads it before it is sent. Nothing is generated and sent unread.'],
        ]],
        ['Your address', [
            ['What happens the moment I press subscribe?',
             'Today: your address is emailed to us and nothing is written to a database, because no email service is connected yet. Once it is, you will get one confirmation email, and you are on the list only after you click the link in it. The page says this at the form as well, because it is the part people assume. <!-- PLACEHOLDER: confirm the email service and the confirmation email before launch. -->'],
            ['Will I be added to a sales list?',
             'No. Subscribing is not an enquiry. The address is used to send the issue and is kept apart from anything a salesperson can reach. If you want to talk to us, the contact form is the route.'],
            ['Do you know whether I opened it?',
             'No. There is no tracking pixel and no per-recipient link rewriting, so there is no open rate and no click report. We judge it by replies and by whether people stay.'],
            ['How do I leave?',
             'One click at the bottom of any issue, with no confirmation page and no survey. Your address is removed rather than flagged. You can also write to us and we will do it by hand.'],
        ]],
        ['The mechanics', [
            ['Can I read it without subscribing?',
             'Yes. Issues are published on this page as they go out, so the archive is readable without an address. There is nothing in the email that is withheld from the web version.'],
            ['Is there an RSS feed?',
             'Not yet. The journal is the written record and the newsletter collects from it, so a feed of the journal is the closest thing today. <!-- PLACEHOLDER: decide whether to publish an RSS feed for issues before launch. -->'],
            ['Can I forward it, or quote it?',
             'Freely. Quote with a link back. There is nothing confidential in an issue — anything a client has not approved for publication does not go in one.'],
            ['Something in an issue is wrong. What happens?',
             'Tell us and the web version is corrected with a date on it and a line saying what changed. If the error is material, the correction is repeated at the top of the next issue. We do not edit a record silently.'],
        ]],
    ],
];
