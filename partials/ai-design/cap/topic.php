<?php /* DRAFT COPY — review before launch */ ?>
<?php
/**
 * Per-capability section headings and the mid-page topic showcase (data/ai-design.php is shared and not edited here).
 *   h     deliver / out / stack / std / on => [grey phrase, ink rest, lead]  (missing keys fall back to the template)
 *   show  lbl, g, ink, lead, ui, sub, cols, rows, kpi [[k, v, note]], note — a cell "ok:" / "hold:" / "flag:" renders a status chip
 * PLACEHOLDER: every showcase figure is illustrative sample data, not a client result — confirm before launch.
 */
return [
'ai-application-design' => [
    'h' => [
        'deliver' => ['The specification engineering builds to,', 'in your repositories.', 'Conversation design, the failure-state catalogue, the prompt set and the tested prototype live in your repositories and design files from the first week.'],
        'out'     => ['People trust it', 'because it shows its working.', 'Three measures taken on the live-model prototype, baselined before design starts. Typical targets, not promises; yours are set per engagement.'],
        'stack'   => ['Designed on a live model,', 'never a mock-up of one.', 'The design, model and prototyping tools AI application work runs on, most used first. Chosen on your prompt set; nothing locks you to a vendor.'],
        'std'     => ['Safe to put in front of people', 'and ready for your reviewers.', 'The frameworks that shape the guardrails, the failure states and the records we hand over. We build to them; they are not certifications we hold.'],
        'on'      => ['An assistant needs a reason', 'and content to work with.'],
    ],
    'show' => [
        'lbl' => 'In practice · failure-state catalogue', 'g' => 'Designed for the wrong answer', 'ink' => 'as carefully as the right one.',
        'lead' => 'Every way the assistant can fail gets a designed state: what triggers it, what the person sees, how they recover, and the test that proves it on the live model.',
        'ui' => 'Failure states · Support assistant', 'sub' => '5 of 23 states',
        'cols' => ['State', 'Trigger', 'What the person sees', 'Recovery', 'Tested'],
        'rows' => [
            ['No source found', 'Retrieval under threshold', 'Says so, offers search', 'One tap to a person', 'ok:41 / 41'],
            ['Low confidence', 'Grader score < 0.7', 'Answer with caveat + sources', 'Ask a follow-up', 'ok:38 / 40'],
            ['Action needs approval', 'Refund over limit', 'Plan shown, approve or edit', 'Named approver', 'ok:25 / 25'],
            ['Prompt injection attempt', 'Instruction in a document', 'Ignores it, flags the file', 'Logged for review', 'hold:18 / 20'],
            ['Out of scope', 'Legal or medical ask', 'Declines, explains why', 'Hand-off with context', 'flag:9 / 12'],
        ],
        'kpi' => [['States designed', '23', 'Before launch, not after'], ['Prompt-set pass rate', '94%', 'Target 95% to ship'], ['Hand-offs with context', '100%', 'No repeat questions']],
        'note' => 'Taken from a prototype. Your catalogue is written against your own prompt set and policies.',
    ],
],
'ai-content-studio' => [
    'h' => [
        'deliver' => ['The studio, its routing', 'and every approved asset.', 'Pipelines, routing rules, evaluation sets, the brand scorer and the audit log run in your cloud and workspaces from the first sprint.'],
        'out'     => ['More assets per brief,', 'fewer rounds per asset.', 'Measured in the studio log against a baseline week. Typical targets, not promises; yours are set per engagement.'],
        'stack'   => ['Routed to the best model,', 'swapped when a better one wins.', 'The model hosts, generators and content tools the studio runs on. Each asset type is re-scored on your evaluation set before routing changes.'],
        'std'     => ['Every asset traceable', 'to a model, a prompt and a person.', 'The frameworks behind the studio’s labelling, logging and review rules. We build to them; they are not certifications we hold.'],
        'on'      => ['A studio is only as good', 'as the models and the plan behind it.'],
    ],
    'show' => [
        'lbl' => 'In practice · routing ledger', 'g' => 'One brief,', 'ink' => 'each asset sent to the model that earned it.',
        'lead' => 'The ledger records where every asset went, how it scored against your evaluation set and the brand scorer, and the person who approved it before it could publish.',
        'ui' => 'Routing ledger · Brief 118', 'sub' => '5 of 42 assets',
        'cols' => ['Asset', 'Routed to', 'Eval score', 'Brand check', 'Reviewer'],
        'rows' => [
            ['Hero still 16:9', 'Image model A · tuned', '0.91', 'ok:Pass', 'ok:Approved'],
            ['Product copy × 12', 'Text model B', '0.88', 'ok:Pass', 'ok:Approved'],
            ['Story cut 9:16', 'Video model C', '0.79', 'hold:Colour ΔE 3.1', 'hold:Edit requested'],
            ['Alt text × 30', 'Text model A', '0.95', 'ok:Pass', 'ok:Approved'],
            ['Voice-over 30 s', 'Speech model D', '0.72', 'flag:Tone off', 'flag:Rejected'],
        ],
        'kpi' => [['Assets from this brief', '42', 'In 3 working days'], ['Brand pass at first go', '81%', 'Target 80%+'], ['Published without a reviewer', '0', 'By design']],
        'note' => 'Model names are withheld because routing changes as models are re-scored.',
    ],
],
'brand-ai-tools' => [
    'h' => [
        'deliver' => ['Your tuned models,', 'weights and all.', 'Model weights, training sets with provenance, evaluation reports and the serving configuration sit in your accounts. Nothing is held hostage to a platform.'],
        'out'     => ['On-brand at the first attempt,', 'at a fraction of the cost.', 'Measured on every generated variant against your brand palette and rules. Typical targets, not promises; yours are set per engagement.'],
        'stack'   => ['Trained on open tooling,', 'served where you choose.', 'The training, evaluation and serving tools brand models are built with. Weights and configuration stay portable between providers.'],
        'std'     => ['Trained on data you may use,', 'governed like any other system.', 'The frameworks behind the training-data record, the risk register and the release gate. We build to them; they are not certifications we hold.'],
        'on'      => ['A tuned model earns its keep', 'inside a studio and a plan.'],
    ],
    'show' => [
        'lbl' => 'In practice · model card', 'g' => 'A model ships only when', 'ink' => 'it beats the base model on your brand.',
        'lead' => 'The release gate compares the tuned model with the stock model it started from, on the checks your brand team cares about. Each has a threshold; the card says pass or hold.',
        'ui' => 'Model card · Brand image model v3', 'sub' => 'Release gate',
        'cols' => ['Check', 'Base model', 'Tuned v3', 'Threshold', 'Gate'],
        'rows' => [
            ['Palette drift (mean ΔE 2000)', '5.8', '1.7', '≤ 2.0', 'ok:Pass'],
            ['Brand-rule adherence', '46%', '88%', '≥ 85%', 'ok:Pass'],
            ['Product shape fidelity', '0.71', '0.93', '≥ 0.90', 'ok:Pass'],
            ['Unsafe or off-policy outputs', '1.9%', '0.3%', '≤ 0.5%', 'ok:Pass'],
            ['Text rendering in image', '38%', '61%', '≥ 80%', 'hold:Route to designer'],
        ],
        'kpi' => [['Training images with provenance', '100%', 'Licensed or owned'], ['Cost per approved asset', 'Index 45', 'Base model = 100'], ['Checks passed', '4 / 5', 'Fifth stays with people']],
        'note' => 'Thresholds are agreed with your brand team before training starts.',
    ],
],
'ai-strategy-consulting' => [
    'h' => [
        'deliver' => ['A roadmap your board can fund', 'and your teams can start.', 'The use-case register, scoring model, risk register, business cases and the 90-day plan, in the documents and trackers your teams already run.'],
        'out'     => ['Fewer pilots.', 'More of them reaching production.', 'Measured on decisions made, pilots shipped and value tracked. Typical targets, not promises; yours are set per engagement.'],
        'stack'   => ['Tested on the models', 'your people would actually use.', 'The model, collaboration and planning tools strategy work runs on. Every use case is tried on a live model before it is scored.'],
        'std'     => ['A strategy your risk team', 'can sign on the first read.', 'The frameworks behind the risk register, the governance model and the policy set. We build to them; they are not certifications we hold.'],
        'on'      => ['A strategy is a list', 'until something gets built.'],
    ],
    'show' => [
        'lbl' => 'In practice · use-case scoring', 'g' => 'Forty ideas in.', 'ink' => 'Three funded, each for a reason on the record.',
        'lead' => 'Every use case is scored on value, feasibility and risk with the people who own it, tried on a live model, and given a decision the board can read in one line.',
        'ui' => 'Use-case register · Workshop 3', 'sub' => '5 of 41 cases',
        'cols' => ['Use case', 'Value', 'Feasibility', 'Risk', 'Decision'],
        'rows' => [
            ['Claims triage assistant', 'High · ₹4–6 Cr/yr', 'High', 'Limited', 'ok:Fund · Q1'],
            ['Sales call summaries', 'Medium', 'High', 'Minimal', 'ok:Fund · Q1'],
            ['Contract clause review', 'High', 'Medium', 'Minimal', 'hold:Pilot with legal'],
            ['Emotion reading in interviews', 'Low', 'Medium', 'Prohibited', 'flag:Decline'],
            ['Internal policy search', 'Medium', 'High', 'Minimal', 'ok:Fund · Q2'],
        ],
        'kpi' => [['Use cases scored', '41', 'From six business units'], ['Funded', '3', 'With owners and measures'], ['Declined on risk', '4', 'Reasons recorded']],
        'note' => 'The risk column is the EU AI Act tier; values are ranges agreed with finance.',
    ],
],
];
