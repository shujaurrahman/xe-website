<?php /* DRAFT COPY — review before launch */ ?>
<?php
/**
 * Per-capability copy and showcase data the template sections read (data/campaign-content.php is shared and
 * not edited from here). Every key is optional: a missing key falls back to the template's generic line.
 *   img    offer plate [file in assets/imgs/campaign-content/, w, h, alt, object-position] (credited in CREDITS.md)
 *   h      section headings: deliver / out / stack / std / on => [grey phrase, ink rest, lead]
 *   apply  standard key => how that framework applies to THIS capability
 *   show   the mid-page topic showcase: lbl, g, ink, lead, ui (window title), sub, cols, rows, kpi [[k, v, note]], note
 *          A cell "ok:Text" / "hold:Text" / "flag:Text" renders as a status chip; row[0] is the row header.
 * PLACEHOLDER: every figure in a showcase is illustrative sample data, not a client result — confirm before launch.
 */
return [
'content-marketing' => [
    'img' => ['cap-content-marketing.jpg', 1400, 933, 'A hand writes notes in pencil on a lined notebook page, in black and white', '50% 50%'],
    'h' => [
        'deliver' => ['The engine,', 'not a folder of posts.', 'You keep the topic architecture, the brief templates your experts answer in an hour, and the dashboard that ties each piece to the demand it earned.'],
        'out'     => ['Fewer pieces.', 'More of them doing a job.', 'Measured against the baseline agreed in week one. These are the aims content is planned against, not guarantees.'],
        'stack'   => ['Written in your CMS.', 'Measured in your analytics.', 'The research, publishing and measurement tools content marketing runs on. Named as tools we use, not partnerships. AI drafts only ever reach an editor, never the site.'],
        'std'     => ['Readable, fast,', 'and honest about data.', 'Frameworks every published page is checked against. We build to them; they are not certifications we hold.'],
        'on'      => ['Content earns attention.', 'These two carry it further.'],
    ],
    'apply' => [
        'wcag22' => 'Heading order, link text, alt text and contrast checked on every template before a single article ships.',
        'cwv'    => 'Article templates held to LCP ≤ 2.5 s, INP ≤ 200 ms and CLS ≤ 0.1 so search visibility is not lost to a slow page.',
        'gdpr'   => 'Gated assets and newsletter sign-ups collect only what the offer needs, with consent logged per form.',
        'dpdp'   => 'Indian sign-ups get a plain notice, a named purpose and a withdrawal route as easy as the opt-in.',
    ],
    'show' => [
        'lbl' => 'In practice · topic ledger', 'g' => 'Every piece has a question', 'ink' => 'and a reason to exist.',
        'lead' => 'The ledger is the plan: each row is a question real buyers ask, the intent behind it, the expert who answers it and whether search is starting to notice.',
        'ui' => 'Topic ledger · Cluster 02', 'sub' => '5 of 14 questions',
        'cols' => ['Buyer question', 'Intent', 'Expert', 'Brief', 'Search visibility'],
        'rows' => [
            ['How long does a migration really take?', 'Evaluate', 'Head of delivery', 'ok:Published', 'Top 10 · 4 terms'],
            ['What does it cost to run per month?', 'Decide', 'Finance lead', 'ok:Published', 'Top 20 · 2 terms'],
            ['Which teams have to change how they work?', 'Evaluate', 'Change lead', 'hold:In edit', 'Not yet indexed'],
            ['What goes wrong in the first quarter?', 'Learn', 'Support lead', 'hold:Expert review', '—'],
            ['How do we compare vendors fairly?', 'Decide', 'Procurement', 'flag:Needs data', '—'],
        ],
        'kpi' => [['Pieces with a named job', '14 / 14', 'Every row has a buyer question'], ['Expert time per brief', '≈ 1 hr', 'Interview, not a blank page'], ['Qualified visits', '+38%', 'Cluster 01, quarter on quarter']],
        'note' => 'The real ledger is built from your search data, sales calls and support tickets.',
    ],
],
'social-media-marketing' => [
    'img' => ['cap-social-media-marketing.jpg', 1200, 1011, 'A hand holds a phone with a blank screen against a plain light background', '50% 50%'],
    'h' => [
        'deliver' => ['A presence you can run', 'without us in the room.', 'Platform playbooks, the pillar templates, the community response guide and the reporting view all stay in your accounts.'],
        'out'     => ['People come back.', 'Then they come through.', 'Social is judged on return visits and what it sends to search, site and sales. Aims against your baseline, not guarantees.'],
        'stack'   => ['Planned in one place.', 'Published where people are.', 'The planning, publishing and listening tools social runs on. Named as tools we use, not partnerships. AI suggestions sit behind a person’s approval.'],
        'std'     => ['Accessible posts,', 'lawful audiences.', 'Frameworks social content and audience data are checked against. We build to them; they are not certifications we hold.'],
        'on'      => ['A feed is the start.', 'These two widen the circle.'],
    ],
    'apply' => [
        'wcag22' => 'Captions on every video, alt text on every image post, and no meaning carried by colour or emoji alone.',
        'gdpr'   => 'Custom audiences and pixel data used only with recorded consent, and community replies never ask for personal data in public.',
        'dpdp'   => 'WhatsApp and DM journeys carry a clear notice and opt-out, and customer lists are uploaded only for the purpose they were collected for.',
    ],
    'show' => [
        'lbl' => 'In practice · platform matrix', 'g' => 'One pillar,', 'ink' => 'rebuilt for every feed it lands in.',
        'lead' => 'Nothing is cross-posted. Each platform gets its own format, rhythm, measure and reply target, and the matrix is the agreement the team works to.',
        'ui' => 'Platform matrix · Pillar “How it’s made”', 'sub' => '5 platforms',
        'cols' => ['Platform', 'Native format', 'Cadence', 'Measure', 'Reply target'],
        'rows' => [
            ['LinkedIn', 'Document post, 8 slides', '3 a week', 'Saves + profile visits', 'ok:Same day'],
            ['Instagram', 'Reel, 20–30 s, captioned', '4 a week', 'Shares + return viewers', 'ok:4 hrs'],
            ['YouTube', 'Short plus one long cut', '1 a week', 'Returning viewers', 'hold:Next day'],
            ['WhatsApp channel', 'Single update with a link', '2 a week', 'Click-through', 'ok:4 hrs'],
            ['X', 'Thread, 5 posts', 'Daily', 'Replies from target accounts', 'flag:Under review'],
        ],
        'kpi' => [['Posts rebuilt, not reposted', '100%', 'By rule'], ['Median reply time', '2 h 40 m', 'Target 4 hrs'], ['Social-referred sign-ups', '+21%', 'Month three vs baseline']],
        'note' => 'Reply targets are agreed with your team and staffed before launch.',
    ],
],
'public-relations' => [
    'img' => ['cap-public-relations.jpg', 1100, 733, 'A camera on a tripod, a microphone and a tablet set up on a coffee table for a recorded interview', '50% 50%'],
    'h' => [
        'deliver' => ['The story, the proof', 'and the people ready to tell it.', 'Narrative, proof pack, media list, spokesperson briefs and a coverage log you own, so the next story starts from evidence.'],
        'out'     => ['Others repeat it.', 'Search and AI answers cite it.', 'PR is measured on credible mentions, where they are cited and what they send. Aims against a baseline, not guarantees.'],
        'stack'   => ['Monitored in the open.', 'Logged where you can see it.', 'The monitoring, search and publishing tools PR runs on, including AI answer engines we check for citations. Named as tools, not partnerships.'],
        'std'     => ['Newsrooms and journalists', 'are handled with care too.', 'Frameworks your press materials and media data are checked against. We build to them; they are not certifications we hold.'],
        'on'      => ['Coverage opens a door.', 'These two keep it open.'],
    ],
    'apply' => [
        'gdpr' => 'Journalist contact data held on a legitimate-interest basis, with a record of the assessment and an unsubscribe on every pitch.',
        'dpdp' => 'Contact lists for Indian media kept to named purposes, with deletion on request honoured across every tool.',
        'wcag22' => 'Newsroom pages, press releases and PDFs built to be read with a screen reader, with tagged headings and real text.',
    ],
    'show' => [
        'lbl' => 'In practice · story tracker', 'g' => 'A story is only as strong', 'ink' => 'as the proof behind it.',
        'lead' => 'Every angle is paired with a proof asset before it is pitched. The tracker shows which stories are ready, where they are going and whether AI answers now cite them.',
        'ui' => 'Story tracker · Q3', 'sub' => '5 angles',
        'cols' => ['Story angle', 'Proof asset', 'Outlet type', 'Stage', 'Cited in AI answers'],
        'rows' => [
            ['What 400 buyers said about switching', 'Original survey, method note', 'Trade + national business', 'ok:Covered · 6', 'ok:3 of 5 engines'],
            ['The cost nobody budgets for', 'Anonymised cost model', 'Trade', 'ok:Covered · 2', 'hold:1 of 5'],
            ['Founder on building for regulated buyers', 'Spokesperson brief', 'Podcast + broadcast', 'hold:Booked', '—'],
            ['A year of the programme, in numbers', 'Data pack', 'Regional', 'hold:Pitching', '—'],
            ['Response to the new regulation', 'Expert comment', 'Newswire', 'flag:Legal sign-off', '—'],
        ],
        'kpi' => [['Pitches with a proof asset', '100%', 'By rule'], ['Credible mentions', '14', 'Quarter, tier 1–2 only'], ['Branded search', '+17%', 'Weeks after coverage']],
        'note' => 'No real outlets or results are shown; the tracker is filled from your coverage log.',
    ],
],
'social-influencer-activation' => [
    'img' => ['cap-social-influencer-activation.jpg', 680, 1000, 'A photographer adjusts a camera and lights on a white studio set, in black and white', '50% 35%'],
    'h' => [
        'deliver' => ['Every creator agreement,', 'every right, on file.', 'Briefs, signed agreements, usage and disclosure records, the content itself and the performance read-out, handed over in your drive.'],
        'out'     => ['Creators you can reuse,', 'content you are allowed to.', 'Measured on reach that converts and on content cleared for paid use. Aims against your baseline, not guarantees.'],
        'stack'   => ['Briefed, tracked,', 'and paid for in the open.', 'The briefing, tracking and commerce tools activation runs on. Named as tools we use, not partnerships. AI shortlists creators; a person approves every one.'],
        'std'     => ['Disclosed, consented', 'and fair to the creator.', 'Rules every creator post and audience list is checked against. We build to them; they are not certifications we hold.'],
        'on'      => ['Creators start the talk.', 'These two keep it going.'],
    ],
    'apply' => [
        'gdpr' => 'Creator and audience data processed under written agreements, with tracking links and pixels used only where consent is recorded.',
        'dpdp' => 'Indian creators and entrants get a plain notice for what is collected, why, and how to withdraw — mirrored in the contract.',
        'wcag22' => 'Creator briefs require captions, alt text and readable on-screen type, checked before a post is approved.',
    ],
    'show' => [
        'lbl' => 'In practice · rights matrix', 'g' => 'Before anything goes live,', 'ink' => 'the matrix says who owns what, and for how long.',
        'lead' => 'Each creator’s deliverables, disclosure and usage rights sit in one view, so paid teams only boost what they are cleared to, and nothing runs past its term. Built to ASCI influencer guidelines and the FTC endorsement guides.',
        'ui' => 'Rights matrix · Launch wave 1', 'sub' => '5 creators',
        'cols' => ['Creator', 'Deliverable', 'Disclosure', 'Usage rights', 'Term'],
        'rows' => [
            ['Creator A · 42k', 'Reel + 3 stories', 'ok:#ad, first line', 'ok:Organic + paid', '90 days'],
            ['Creator B · 180k', 'YouTube integration', 'ok:Spoken + label', 'hold:Organic only', '12 months'],
            ['Creator C · 9k', 'Unboxing post', 'ok:Platform label', 'ok:Organic + paid', '60 days'],
            ['Creator D · 65k', 'Live session', 'hold:Script review', 'hold:Pending', '—'],
            ['Creator E · 23k', 'Reel', 'flag:Label missing', 'flag:Blocked', '—'],
        ],
        'kpi' => [['Posts disclosed correctly', '4 / 5', 'One held until fixed'], ['Cleared for paid use', '60%', 'By content, this wave'], ['Rights expiring in 30 days', '1', 'Auto-flagged to paid team']],
        'note' => 'Creators are anonymised; guideline checks follow ASCI and FTC rules current at launch.',
    ],
],
'performance-marketing' => [
    'img' => ['cap-performance-marketing.jpg', 1000, 667, 'A hand-drawn line chart on paper beside a ruler, pens and a notebook on a wooden desk', '50% 50%'],
    'h' => [
        'deliver' => ['Accounts, tracking and tests', 'all in your name.', 'Ad accounts, conversion tracking, the test library and the incrementality read-outs stay yours, documented so another team could run them tomorrow.'],
        'out'     => ['Spend that proves itself.', 'Three numbers finance will sign.', 'Each measured against a holdout, not a platform’s own report. Aims against your baseline, not guarantees.'],
        'stack'   => ['Bought on the platforms.', 'Judged in your warehouse.', 'The ad, analytics and data tools performance marketing runs on. Named as tools we use, not partnerships. Bidding automation runs inside budgets a person sets.'],
        'std'     => ['Tracking that respects consent,', 'models that can be explained.', 'Frameworks our tracking, audiences and automated bidding are checked against. We build to them; they are not certifications we hold.'],
        'on'      => ['Performance buys the click.', 'These two make it worth buying.'],
    ],
    'apply' => [
        'gdpr' => 'Pixels and conversion APIs fire only after consent, with Consent Mode signals passed to ad platforms and server events minimised.',
        'dpdp' => 'Customer-match uploads limited to people who agreed to marketing, hashed before upload and deleted when consent is withdrawn.',
        'wcag22' => 'Landing pages built for the click are checked for contrast, focus order and form labels, not just conversion rate.',
        'nist-ai-rmf' => 'Automated bidding and audience models documented: what they optimise, the guardrails on spend, and who reviews them each week.',
    ],
    'show' => [
        'lbl' => 'In practice · holdout read-out', 'g' => 'Platforms report what they touched.', 'ink' => 'A holdout shows what they caused.',
        'lead' => 'Regions are split into matched test and control groups before spend moves. The read-out compares them, so the lift you report is the lift the money bought.',
        'ui' => 'Geo holdout · Paid social, 6 weeks', 'sub' => 'Test vs control',
        'cols' => ['Region group', 'Spend', 'Conversions', 'Per 100k people', 'Read'],
        'rows' => [
            ['Test · North cluster', '₹18.4L', '2,184', '71.2', 'ok:Exposed'],
            ['Test · West cluster', '₹21.1L', '2,436', '69.8', 'ok:Exposed'],
            ['Control · South cluster', '—', '1,902', '64.9', 'hold:Held out'],
            ['Control · East cluster', '—', '1,655', '64.1', 'hold:Held out'],
            ['Pre-period fit', '8 weeks', 'r = 0.96', '—', 'ok:Matched'],
        ],
        'kpi' => [['Incremental lift', '+9.4%', '90% CI 4.1–14.2'], ['Incremental ROAS', '2.1×', 'vs 4.8× platform-reported'], ['Budget decision', 'Scale +30%', 'Signed off by finance']],
        'note' => 'Not a client result. Real read-outs publish the method, the matching and the interval.',
    ],
],
'omnichannel-marketing-strategy' => [
    'img' => ['cap-omnichannel-marketing-strategy.jpg', 1000, 662, 'Orange and blue sticky notes arranged in columns on a whiteboard plan', '50% 50%'],
    'h' => [
        'deliver' => ['A plan the whole team', 'can argue with and then use.', 'The channel role map, budget model, measurement plan and quarterly review pack, in formats your finance and channel teams already work in.'],
        'out'     => ['Every channel has a job.', 'Every job has a number.', 'Measured on the plan’s own terms: reach, conversion and cost at each stage. Aims against your baseline, not guarantees.'],
        'stack'   => ['Modelled in your data.', 'Planned where people meet.', 'The analytics, modelling and planning tools strategy runs on. Named as tools we use, not partnerships. Models inform decisions; people make them.'],
        'std'     => ['A plan that uses data', 'the way people agreed to.', 'Frameworks the measurement plan and audience strategy are checked against. We build to them; they are not certifications we hold.'],
        'on'      => ['Strategy picks the channels.', 'These two fill them.'],
    ],
    'apply' => [
        'gdpr' => 'Cross-channel audiences and attribution built on consented, minimised data, with retention set per source.',
        'dpdp' => 'Journeys that join channels for Indian customers name each purpose and honour a single withdrawal everywhere.',
        'wcag22' => 'Every owned touchpoint in the plan carries an accessibility check, so no stage of the journey shuts people out.',
    ],
    'show' => [
        'lbl' => 'In practice · channel role map', 'g' => 'Channels stop competing', 'ink' => 'when each one has its own job.',
        'lead' => 'The role map gives every channel one job in the journey, a share of budget and the measure it is judged on, so reviews compare like with like.',
        'ui' => 'Channel role map · FY plan', 'sub' => '5 of 9 channels',
        'cols' => ['Channel', 'Job in the journey', 'Stage', 'Budget share', 'Judged on'],
        'rows' => [
            ['Online video', 'Make the category feel familiar', 'Reach', '24%', 'ok:Brand search lift'],
            ['Paid search', 'Catch intent the rest created', 'Convert', '28%', 'ok:Incremental CPA'],
            ['Paid social', 'Show the product in use', 'Consider', '18%', 'hold:Holdout due Q2'],
            ['Email + CRM', 'Turn first order into second', 'Retain', '8%', 'ok:Repeat rate'],
            ['Out of home', 'Anchor two launch cities', 'Reach', '12%', 'flag:Measure not agreed'],
        ],
        'kpi' => [['Channels with one job', '9 / 9', 'No shared targets'], ['Budget moved on evidence', '14%', 'At the first quarterly review'], ['Blended CAC', '−11%', 'Against the prior plan']],
        'note' => 'Shares and measures are set with your finance team, not copied from another plan.',
    ],
],
'campaign-design-systems' => [
    'img' => ['cap-campaign-design-systems.jpg', 800, 1200, 'A printed colour sheet running through the rollers of an offset press', '50% 45%'],
    'h' => [
        'deliver' => ['The kit of parts,', 'versioned like software.', 'Tokens, components, templates, usage rules and the change log, published where designers, agencies and AI tools pick them up.'],
        'out'     => ['The next hundred executions', 'cost less than the first ten.', 'Measured on speed, reuse and drift from the master. Aims against your baseline, not guarantees.'],
        'stack'   => ['Built in Figma.', 'Shipped to every tool that makes.', 'The design, content and automation tools campaign systems run on. Named as tools we use, not partnerships. Generative tools draw only from approved parts.'],
        'std'     => ['Every template accessible,', 'every AI output labelled.', 'Frameworks the system’s parts are checked against. We build to them; they are not certifications we hold.'],
        'on'      => ['A system is only worth', 'what gets made with it.'],
    ],
    'apply' => [
        'wcag22' => 'Colour pairs, type sizes and motion in every template pre-checked, so a new execution cannot fail contrast by accident.',
        'cwv'    => 'Web and landing templates ship with image sizes and font loading that hold LCP ≤ 2.5 s and CLS ≤ 0.1.',
        'eu-ai-act' => 'AI-generated imagery made from the kit is marked as such, with the prompt and approver kept in the change log.',
    ],
    'show' => [
        'lbl' => 'In practice · inheritance map', 'g' => 'Change the token once.', 'ink' => 'Every execution that uses it follows.',
        'lead' => 'The map shows which components inherit each token and which executions use them, so a change is reviewed once and a visual diff catches anything that drifted.',
        'ui' => 'Campaign kit · v2.4', 'sub' => 'Token → component → execution',
        'cols' => ['Part', 'Inherits', 'Used by', 'Visual diff', 'Status'],
        'rows' => [
            ['Colour · accent', 'Token', '38 executions', '0 px drift', 'ok:Stable'],
            ['Headline lock-up', 'Type scale + accent', '26 executions', '0 px drift', 'ok:Stable'],
            ['Offer badge', 'Accent + radius', '19 executions', '3 px on 2 sizes', 'hold:In review'],
            ['Story frame 9:16', 'Grid + lock-up', '12 executions', '0 px drift', 'ok:Stable'],
            ['Legacy banner 728', 'Old grid', '4 executions', '11 px', 'flag:Retire'],
        ],
        'kpi' => [['Executions from the kit', '92%', 'Not rebuilt from scratch'], ['New size, brief to live', '1 day', 'Down from 5'], ['Drift caught before launch', '7', 'By visual diff, this quarter']],
        'note' => 'The map is generated from your design files and published templates.',
    ],
],
'global-content-production' => [
    'img' => ['cap-global-content-production.jpg', 1600, 809, 'An editor in headphones works on a video timeline at a dark editing desk', '50% 50%'],
    'h' => [
        'deliver' => ['Every market’s files,', 'masters and approvals, kept.', 'Masters, localised versions, glossaries, reviewer sign-offs and the rights log, stored so any asset can be traced and re-cut.'],
        'out'     => ['One master,', 'every market, on the same day.', 'Measured on time to market, first-pass approval and cost per localised asset. Aims against your baseline, not guarantees.'],
        'stack'   => ['Produced once,', 'versioned for everywhere.', 'The production, localisation and delivery tools we work in. Named as tools we use, not partnerships. AI drafts translations and cut-downs; native reviewers approve them.'],
        'std'     => ['Readable in every language,', 'honest about what AI made.', 'Frameworks every localised asset is checked against. We build to them; they are not certifications we hold.'],
        'on'      => ['Production scales the idea.', 'These two decide what to make.'],
    ],
    'apply' => [
        'wcag22' => 'Subtitles, audio description where needed, and right-to-left layouts checked in each market’s own language.',
        'gdpr'   => 'Talent and location releases stored with the asset, with personal data in them limited to what the rights need.',
        'dpdp'   => 'Consent from people filmed in India recorded in plain language, with a route to withdraw from future use.',
        'eu-ai-act' => 'Synthetic voices, faces and translations labelled as AI-generated, with the model and reviewer recorded per asset.',
    ],
    'show' => [
        'lbl' => 'In practice · localisation queue', 'g' => 'One master in.', 'ink' => 'Every market out, each checked by a native reviewer.',
        'lead' => 'The queue shows each market’s version of the same master: its language, what was adapted, where it is and who signed it off. Nothing publishes without the native review.',
        'ui' => 'Localisation queue · Spring master', 'sub' => '5 of 11 markets',
        'cols' => ['Market', 'Language', 'Adapted', 'Stage', 'Native review'],
        'rows' => [
            ['Germany', 'de-DE', 'Copy, legal line', 'ok:Live', 'ok:Signed'],
            ['Japan', 'ja-JP', 'Copy, type, pacing', 'ok:Live', 'ok:Signed'],
            ['UAE', 'ar-AE · RTL', 'Layout mirrored', 'hold:In review', 'hold:With reviewer'],
            ['India', 'hi-IN + en-IN', 'Voice-over, subtitles', 'hold:AI draft', '—'],
            ['Brazil', 'pt-BR', 'Offer, pricing line', 'flag:Legal query', '—'],
        ],
        'kpi' => [['Markets live on day one', '7 / 11', 'Target 11 by next master'], ['First-pass approval', '82%', 'Native reviewers'], ['Cost per localised asset', '−34%', 'Against the prior season']],
        'note' => 'Markets, languages and reviewers are set per programme.',
    ],
],
];
