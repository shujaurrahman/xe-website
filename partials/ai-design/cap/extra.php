<?php /* DRAFT COPY — review before launch */ ?>
<?php
/**
 * Per-capability extras for the shared template (content data/ai-design.php does not carry).
 *   m    3 measures, one per outcome in data/ai-design.php: [measure, measured by, baseline 0–1, target 0–1, baseline text, target text]
 *        PLACEHOLDER: every figure is an illustrative typical target, not an achieved result — confirm before launch.
 *   fit  "Where it sits": eyebrow, heading HTML, lead, 4 nodes [discipline, name, line, is-this-capability], note
 *   see  one-line hook for the signature mock's jump link
 */
return [
    'ai-application-design' => [
        'm' => [
            ['Recovery after a wrong answer', 'Moderated sessions on the prompt set', 0.35, 0.80, '35%', '80%+'],
            ['Agent actions approved first time', 'Approval events in the prototype log', 0.50, 0.85, '50%', '85%+'],
            ['Task success on the prompt set', 'Tasks completed ÷ tasks attempted',    0.58, 0.85, '58%', '85%+'],
        ],
        'fit' => [
            'lbl'   => 'Where it sits',
            'title' => '<span class="g">Design sets the bar.</span> Engineering clears it.',
            'lead'  => 'AI Application Design owns what people meet. The acceptance criteria it writes become the tests engineering builds against.',
            'nodes' => [
                ['AI Design', 'AI Strategy & Consulting', 'Which use case, and why this one first.', false],
                ['AI Design', 'AI Application Design', 'The conversation, controls and failure states, tested on a live model.', true],
                ['Technology & Intelligence', 'AI engineering', 'Agents, retrieval and infrastructure built to the specification.', false],
                ['Both', 'Production evaluation', 'The same prompt set, re-run on every release.', false],
            ],
            'note' => 'The prompt set written in week one is the thread through all four.',
        ],
        'see' => 'Watch an assistant plan, call tools and cite',
    ],
    'ai-content-studio' => [
        'm' => [
            ['Assets per brief', 'Approved assets per brief, per week', 0.25, 0.80, '12', '40+'],
            ['Brand pass at first go', 'Brand scorer + reviewer on every asset', 0.40, 0.80, '40%', '80%+'],
            ['Brief to approved', 'Timestamps in the studio log', 1.00, 0.30, '10 days', '3 days'],
        ],
        'fit' => [
            'lbl'   => 'Where it sits',
            'title' => '<span class="g">One brief in.</span> Every format out, each from the model that earned it.',
            'lead'  => 'The studio routes each asset to the model that wins on your evaluation set, then holds it for a person before anything publishes.',
            'nodes' => [
                ['Brand Design', 'Brand system', 'Voice, colour, type and the rules the scorer checks.', false],
                ['AI Design', 'AI Content Studio', 'Brief, routing, generation and review in one pipeline.', true],
                ['AI Design', 'Brand AI Tools', 'Tuned models the studio calls when stock models fall short.', false],
                ['Your team', 'Channels', 'Published with content credentials and an audit record.', false],
            ],
            'note' => 'A model change is a routing decision, not a new studio.',
        ],
        'see' => 'See how one brief is routed across models',
    ],
    'brand-ai-tools' => [
        'm' => [
            ['On-brand at first go', 'Brand check on every generated variant', 0.40, 0.85, '40%', '85%+'],
            ['Colour drift (ΔE)', 'Mean ΔE 2000 against brand palette', 1.00, 0.35, '5.8', '≤ 2.0'],
            ['Cost per approved asset', 'Model spend + review time, indexed', 1.00, 0.45, 'Index 100', 'Index 45'],
        ],
        'fit' => [
            'lbl'   => 'Two tools, one name',
            'title' => '<span class="g">This one makes.</span> Brand Design’s one checks.',
            'lead'  => 'Brand AI Tools is a capability of both disciplines. Here it means custom-tuned generative models that produce on-brand work. In Brand Design it means the governance tooling that checks any asset against the brand system, whoever or whatever made it.',
            'nodes' => [
                ['Brand Design', 'Brand system', 'Identity, voice, tokens and rules.', false],
                ['AI Design · Brand AI Tools', 'Custom-tuned models', 'Trained on approved work, making on-brand variants.', true],
                ['Brand Design · Brand AI Tools', 'Governance checks', 'Every asset scored against the system, from any source.', false],
                ['Your team', 'Approval', 'A named person signs off. The record is kept.', false],
            ],
            'note' => 'They meet at the scoring step: our models are tuned until they pass the checks Brand Design wrote.',
            'link' => ['brand-design', 'brand-ai-tools', 'See Brand Design’s Brand AI Tools'],
        ],
        'see' => 'Watch a tuned model make variants and a brand check score them',
    ],
    'ai-strategy-consulting' => [
        'm' => [
            ['Pilots reaching production', 'Pilots scaled ÷ pilots started', 0.20, 0.60, '1 in 5', '3 in 5'],
            ['Weekly use at 90 days', 'Weekly active users ÷ licensed seats', 0.20, 0.70, '20%', '70%+'],
            ['Decisions with a business case', 'Portfolio items with a scored case', 0.30, 1.00, '30%', '100%'],
        ],
        'fit' => [
            'lbl'   => 'Where it sits',
            'title' => '<span class="g">Strategy picks the work.</span> The other three make it real.',
            'lead'  => 'A scored portfolio and a roadmap, then pilots handed to the capability that builds each one, with the measure of success agreed before it starts.',
            'nodes' => [
                ['AI Design', 'AI Strategy & Consulting', 'Opportunities scored, pilots chosen, rules written.', true],
                ['AI Design', 'AI Application Design', 'Customer and employee experiences.', false],
                ['AI Design', 'AI Content Studio', 'Content production at volume.', false],
                ['AI Design', 'Brand AI Tools', 'Models tuned on your brand.', false],
            ],
            'note' => 'Engineering-heavy pilots go to Technology & Intelligence, with the same scorecard.',
        ],
        'see' => 'See a pilot portfolio scored and sequenced',
    ],
];
