<?php
/**
 * Technology & Intelligence: the ten capabilities, in depth.
 *
 * The names and one-line descriptions come from data/site.php (the client's approved copy);
 * 'name' here must match it exactly. Everything below is the long-form content the hub and
 * the capability pages are built from: what each one offers, how it runs, what is handed over,
 * what changes, and the questions people ask. Timeframes are typical, not promised, and are
 * marked PLACEHOLDER so they can be confirmed before launch.
 *
 * Fields per capability
 *   n, slug, name, short, kicker    index, page slug, approved name, short label, eyebrow line
 *   title                           heading HTML: <span class="g">grey first phrase.</span> ink rest
 *   lead, meta + meta_k, cta        intro paragraph, three meta values with their labels, CTA label
 *   icon                            the capability's icon (xt_icon name, partials/tech/kit.php)
 *   offer_title, offer_lead         heading HTML and lead for the offer section
 *   offer                           6 × [title, description, tag, icon — xt_icon name]
 *   process                         ['title' (HTML), 'lead', 'steps' => [[name, timing, description, [outputs]]]]
 *   deliver                         [[item, format]]
 *   outcomes                        3 × [title, text]
 *   faq                             5 × [question, answer]
 *   pairs                           2 related capability slugs
 *   img                             card photo ['src','w','h','alt','pos'] (assets/imgs/tech/shared/, credits in CREDITS.md there)
 *   stack                           technology slugs from data/tech-stack.php, most relevant first (render with xt_stack)
 *   standards                       badge keys from xt_standards() (render with xt_badge)
 *
 * Truthfulness: technologies are ones we work with, never partnerships. Standards are frameworks
 * delivery is built to or aligned with; nothing here says Xterra Edze holds a certification.
 *
 * Voice: calm, precise, confident. Short active sentences. No exclamation marks.
 */

return [

    'websites-apps' => [
        'n'          => '01',
        'slug'       => 'websites-apps',
        'name'       => 'Websites & Apps',
        'short'      => 'Web & Apps',
        'kicker'     => 'Built for day two',
        'title'      => '<span class="g">Launch day is easy.</span> Real usage is the job.',
        'lead'       => 'Websites & Apps covers web, mobile and product applications engineered for the traffic, devices and change requests that arrive after launch. Performance budgets, accessibility and observability are built in from the first sprint, not added at the end.',
        'meta'       => ['8–16 weeks to first release', 'Web · iOS · Android', 'Core Web Vitals in CI'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical first release', 'Platforms', 'Standard'],
        'cta'        => 'Start a product brief',
        'icon'       => 'browser',
        'offer_title'=> '<span class="g">Six disciplines,</span> one release train',
        'offer_lead' => 'Design, engineering and quality run in the same sprint, so what ships is fast, accessible and measurable from the first release.',
        'offer' => [                    // [title, description, tag, icon — see xt_icons()]
            ['Marketing & content websites', 'Server-rendered or headless sites on a composable CMS, with structured content, edge caching and performance budgets that hold as pages multiply.', 'Next.js · headless CMS', 'browser'],
            ['Web applications',             'Customer portals, dashboards and SaaS products with typed APIs, role-based access and state that survives unreliable networks.', 'React · TypeScript', 'code'],
            ['Mobile apps',                  'Native iOS and Android, or cross-platform with Flutter or React Native, chosen on evidence: offline needs, device APIs and team skills.', 'Native or cross-platform', 'mobile'],
            ['Design systems in code',       'Tokens and components shared by web and mobile, documented in Storybook and tested for accessibility on every change.', 'Tokens · components', 'layers'],
            ['Performance & accessibility',  'Core Web Vitals budgets (LCP ≤ 2.5 s, INP ≤ 200 ms, CLS ≤ 0.1 at p75) and WCAG 2.2 AA checks that fail the build, not the launch.', 'Budgets in CI', 'gauge'],
            ['Release & observability',      'CI/CD with preview environments, feature flags, crash and error reporting, and real-user monitoring from day one.', 'Ship small · roll back fast', 'rocket'],
        ],
        'process' => [
            'title' => '<span class="g">Twelve weeks</span> to a first release',
            'lead'  => 'A thin, working slice ships early and grows every sprint. Nothing waits for a big-bang launch.',
            'steps' => [
                ['Discover',       'Wk 01–02', 'Users, journeys, analytics and the constraints that matter: devices, markets, integrations, compliance. The first slice is chosen.', ['Product brief', 'Architecture sketch', 'Release plan']],
                ['Design',         'Wk 02–05', 'Flows and interfaces designed in the design system, prototyped and tested with real users before anything is built twice.', ['Clickable prototype', 'Design tokens', 'Usability findings']],
                ['Build',          'Wk 04–11', 'Two-week sprints with a demo each time. Preview environments on every pull request, with tests and budgets in CI.', ['Working increments', 'Test suite', 'Preview builds']],
                ['Launch & learn', 'Wk 11–12', 'Staged rollout behind flags, store submission and monitoring live. Then a backlog shaped by real usage.', ['Production release', 'Dashboards', 'Next-quarter roadmap']],
            ],
        ],
        'deliver' => [
            ['Production web and mobile applications',  'Source · your repos'],
            ['Design system & component library',        'Figma · Storybook'],
            ['CI/CD pipelines & preview environments',   'Pipelines · YAML'],
            ['Automated test suites',                    'Unit · E2E · a11y'],
            ['Performance & accessibility reports',      'Lighthouse · WCAG'],
            ['Monitoring & alerting',                    'Dashboards · runbooks'],
            ['Architecture decision records',            'Markdown'],
        ],
        'outcomes' => [
            ['Fast where it counts',     'Performance budgets enforced on every merge and measured in the field at p75, not on a developer laptop.'],
            ['Shippable every sprint',   'Small releases behind flags, with rollbacks measured in minutes rather than a weekend.'],
            ['Built for the next team',  'Typed code, tests, documentation and decision records. Your engineers can own it from the first day.'],
        ],
        'faq' => [
            ['Native, cross-platform or web?', 'It depends on what the app has to do. Deep device integration and platform-specific interaction favour native; shared business logic and one team favour Flutter or React Native; many products only need a fast, installable web app. We recommend one in discovery, with the trade-offs written down.'],
            ['Which CMS do you use?', 'The one your editors will actually use. We often work with headless options such as Contentful, Sanity, Strapi or WordPress, and choose on content model, editorial workflow, localisation and cost.'],
            ['Who owns the code?', 'You do. Everything is built in your repositories and cloud accounts from the first commit, with no proprietary framework or licence lock-in.'],
            ['How do you use AI in delivery?', 'Engineers use AI assistants for scaffolding, tests and review, inside guardrails: no client code in tools that train on it, every change reviewed by a person and tested in CI. It shortens cycles; it does not replace review.'],
            ['What happens after launch?', 'A hypercare period, then either your team takes over with a full handover or we stay on through Integration & Support with agreed service levels.'],
        ],
        'pairs'     => ['custom-software-data-platforms', 'search-ai-visibility'],
        'img'       => ['src' => 'assets/imgs/tech/shared/websites-apps.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'Hands typing on a laptop at a low table in an informal workspace', 'pos' => '50% 50%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['typescript', 'react', 'nextdotjs', 'reactnative', 'flutter', 'swift', 'kotlin', 'nodedotjs', 'tailwindcss', 'contentful', 'sanity', 'vercel', 'playwright', 'storybook'],
        'standards' => ['cwv', 'wcag22', 'owasp-top10', 'owasp-asvs', 'gdpr'],
    ],

    'custom-software-data-platforms' => [
        'n'          => '02',
        'slug'       => 'custom-software-data-platforms',
        'name'       => 'Custom Software & Data Platforms',
        'short'      => 'Platforms',
        'kicker'     => 'Software shaped to the business',
        'title'      => '<span class="g">When off-the-shelf stops fitting,</span> build what the business runs on.',
        'lead'       => 'Custom Software & Data Platforms builds the CRMs, customer data platforms, internal tools and operational systems your business runs on, around your processes and your data model rather than a vendor’s defaults.',
        'meta'       => ['12–24 weeks to first release', 'CRM · CDP · internal tools', 'Your cloud, your IP'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical first release', 'Scope', 'Ownership'],
        'cta'        => 'Start a platform brief',
        'icon'       => 'database',
        'offer_title'=> '<span class="g">One data model,</span> every system that reads it',
        'offer_lead' => 'Platforms are designed from the data outwards, so reporting, automation and AI all read the same governed record.',
        'offer' => [
            ['Custom CRM & operations platforms', 'Pipelines, cases, field operations and approvals modelled on how your teams actually work, with the integrations they depend on.', 'Built to your process', 'workflow'],
            ['Customer data platforms',           'Identity resolution, consented profiles and real-time segments that marketing, sales and service all read from.', 'Identity · consent · segments', 'users'],
            ['Internal tools & portals',          'Admin consoles, partner portals and back-office tools that replace spreadsheets and email chains with audited workflows.', 'Roles · audit trail', 'dashboard'],
            ['Data platforms & warehousing',      'Ingestion, modelling and a governed warehouse or lakehouse, with transformations tested and versioned like code.', 'ELT · lakehouse', 'database'],
            ['Streaming & event architecture',    'Event-driven systems on Kafka or a managed equivalent, with change data capture, for data that cannot wait for the nightly batch.', 'Events · CDC', 'pipeline'],
            ['Analytics & decision products',     'A metric layer, dashboards and embedded analytics with one definition of every number.', 'One metric layer', 'chart'],
        ],
        'process' => [
            'title' => '<span class="g">Model first,</span> then build in slices',
            'lead'  => 'The domain and data model are agreed before the first screen, so every later feature has somewhere to land.',
            'steps' => [
                ['Map',       'Wk 01–03', 'Processes, systems of record, data flows and pain points mapped with the people who do the work. Build, buy or extend decided per module.', ['Process map', 'Domain model', 'Build-vs-buy record']],
                ['Architect', 'Wk 03–05', 'Service boundaries, data model, integration contracts, security model and non-functional targets agreed and documented.', ['Architecture & ADRs', 'API contracts', 'NFR targets']],
                ['Build',     'Wk 05–20', 'Modules delivered in priority order behind feature flags. Data migrated in rehearsed, reversible runs.', ['Platform modules', 'Migration runs', 'Test suites']],
                ['Adopt',     'Wk 20–24', 'Cutover, training and retirement of the old system. Usage and data quality measured from the first week.', ['Cutover plan', 'Training', 'Adoption dashboard']],
            ],
        ],
        'deliver' => [
            ['Platform source code & infrastructure as code', 'Your repos · Terraform'],
            ['Domain & data model',                           'ERD · data dictionary'],
            ['API specifications',                            'OpenAPI · GraphQL schema'],
            ['Data pipelines & transformation models',        'SQL · dbt · tests'],
            ['Migration scripts & reconciliation reports',    'Scripts · reports'],
            ['Role & permission model',                       'RBAC matrix'],
            ['Runbooks & admin guides',                       'Docs'],
        ],
        'outcomes' => [
            ['Software that matches the work', 'Teams stop working around the system. The process lives in the product, not in a side spreadsheet.'],
            ['One version of the customer',    'Consented, deduplicated profiles every team reads from, instead of five exports that disagree.'],
            ['No per-seat ceiling',            'Your IP in your cloud. Add users and modules without renegotiating a licence.'],
        ],
        'faq' => [
            ['Should we build or buy?', 'Buy where the process is standard and a product fits; build where the process is your advantage or the integrations make packaged software brittle. We decide module by module and record why.'],
            ['Can you work with Salesforce, HubSpot or SAP rather than replace them?', 'Yes. Often the right answer is to keep the system of record and build around it: custom apps, data sync and workflows that fill the gaps.'],
            ['How do you migrate data without losing it?', 'With rehearsed migrations and reconciliation reports: record counts, checksums and sampled field comparisons, run several times before the real cutover, with a rollback path.'],
            ['Is a CDP a product or a build?', 'Both exist. Packaged CDPs suit standard marketing use; a composable CDP on your own warehouse suits teams that need control of identity, consent and cost. We compare both against your use cases.'],
            ['Who maintains the platform?', 'Your team, with documentation, runbooks and a handover period, or our engineers under Integration & Support.'],
        ],
        'pairs'     => ['integration-support', 'ai-product-automation'],
        'img'       => ['src' => 'assets/imgs/tech/shared/custom-software-data-platforms.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'Two engineers review code together across a laptop and a wide monitor', 'pos' => '50% 40%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['typescript', 'python', 'nestjs', 'springboot', 'postgresql', 'apachekafka', 'snowflake', 'databricks', 'dbt', 'airbyte', 'graphql', 'salesforce', 'hubspot', 'docker'],
        'standards' => ['iso27001', 'soc2', 'gdpr', 'dpdp', 'owasp-asvs'],
    ],

    'ai-strategy-agents' => [
        'n'          => '03',
        'slug'       => 'ai-strategy-agents',
        'name'       => 'AI Strategy & Agents',
        'short'      => 'AI Strategy',
        'kicker'     => 'Where AI earns its place',
        'title'      => '<span class="g">Less AI theatre.</span> More work actually done.',
        'lead'       => 'AI Strategy & Agents decides where AI fits in your business, what to build first and how to measure it, then builds the custom agents and copilots that take on real work, with guardrails, evaluations and a person in the loop.',
        'meta'       => ['6-week strategy · 12-week pilot', 'Use cases · agents · copilots', 'Evals before rollout'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Scope', 'Standard'],
        'cta'        => 'Start an AI strategy brief',
        'icon'       => 'agent',
        'offer_title'=> '<span class="g">From a long list</span> to agents in production',
        'offer_lead' => 'Every use case is scored on value, feasibility and risk. The first agents are chosen because they can be measured, not because they demo well.',
        'offer' => [
            ['AI opportunity assessment',        'Processes, data and systems reviewed with the teams who own them. Use cases found where AI removes real effort or risk.', 'Interviews · process data', 'search'],
            ['Use-case portfolio & business case','Each candidate scored for value, feasibility, data readiness and risk, then sequenced with costs, owners and success measures.', 'Scored · sequenced', 'target'],
            ['Custom agents',                    'Agents that plan, call tools and APIs, and hand off to people, with scoped permissions and every step logged.', 'Tools · memory · handoff', 'agent'],
            ['Copilots for teams',               'Assistants inside the tools your people already use, grounded in your documents and systems rather than the open internet.', 'Grounded · in context', 'prompt'],
            ['Evaluation & guardrails',          'Task-level eval sets, red-team tests for prompt injection and tool misuse, and approval gates for actions with consequences.', 'Evals · approvals', 'eval'],
            ['AI governance & operating model',  'Policy, risk tiers, model choices and who approves what, aligned with NIST AI RMF, ISO/IEC 42001 and the EU AI Act where they apply.', 'Policy · risk tiers', 'shield'],
        ],
        'process' => [
            'title' => '<span class="g">A strategy in six weeks,</span> a working agent in twelve',
            'lead'  => 'The roadmap is tested by building the first agent against it. Evidence from the pilot reshapes the plan.',
            'steps' => [
                ['Assess',     'Wk 01–03', 'Leadership and team interviews, process walk-throughs, data and systems review, and risk appetite. The long list is built.', ['Opportunity map', 'Data readiness read', 'Risk appetite']],
                ['Prioritise', 'Wk 03–06', 'Use cases scored and sequenced. Operating model and governance drafted. One pilot chosen, with a baseline measure.', ['Use-case portfolio', 'AI roadmap', 'Pilot charter']],
                ['Pilot',      'Wk 07–12', 'The first agent built with tools, guardrails and an eval set, run in shadow mode against the baseline, then live with a person approving actions.', ['Working agent', 'Eval results', 'Approval workflow']],
                ['Scale',      'Wk 12+',   'A go or no-go decision on evidence. Rollout plan, monitoring and the next agents in the portfolio.', ['Decision record', 'Rollout plan', 'Monitoring']],
            ],
        ],
        'deliver' => [
            ['AI opportunity map & use-case portfolio', 'Board · Sheet'],
            ['AI roadmap with business cases',          'Deck · Sheet'],
            ['Agent or copilot in production',          'Source · your cloud'],
            ['Evaluation suite & red-team results',     'Tests · report'],
            ['Guardrail & approval policy',             'Policy · config'],
            ['AI governance framework',                 'Document'],
            ['Agent action & audit log',                'Dashboard'],
        ],
        'outcomes' => [
            ['A portfolio, not a pile of pilots', 'Use cases ranked on value and risk, with owners and measures, so investment follows evidence.'],
            ['Agents that finish tasks',          'Measured on task completion, accuracy and time saved against a baseline, not on how the demo looked.'],
            ['Safe by construction',              'Scoped permissions, human approval for consequential actions and a log of every step an agent takes.'],
        ],
        'faq' => [
            ['What is the difference between a copilot and an agent?', 'A copilot suggests and a person acts. An agent plans and takes actions through tools and APIs, within set permissions, and hands back to a person when a step needs approval. Most businesses start with copilots and move specific tasks to agents once evals show they are reliable.'],
            ['Which models do you use?', 'Models from OpenAI, Anthropic, Google and Mistral, and open-weight families such as Llama, chosen per task on quality, latency, cost and data-residency needs. We keep a model-agnostic layer so you can switch when the evidence changes.'],
            ['How do you stop an agent doing something it should not?', 'Least-privilege tool permissions, input and output guardrails, tests for prompt injection (OWASP LLM01) and excessive agency (LLM06), rate and spend limits, human approval for consequential actions, and a full action log.'],
            ['How do you measure whether it works?', 'A baseline taken before the pilot, a task-level eval set scored automatically and by reviewers, and production measures such as completion rate, escalation rate, handling time and cost per task.'],
            ['Is our data used to train the models?', 'No. We use enterprise API terms or self-hosted models that do not train on your data, keep data in your chosen region where required, and document every data flow.'],
        ],
        'pairs'     => ['ai-product-automation', 'audits-assessments'],
        'img'       => ['src' => 'assets/imgs/tech/shared/ai-strategy-agents.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A facilitator leads a workshop at a whiteboard while colleagues around the table discuss the plan', 'pos' => '50% 45%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['openai', 'anthropic', 'googlegemini', 'mistralai', 'meta', 'langchain', 'langgraph', 'llamaindex', 'python', 'fastapi', 'temporal', 'microsoftazure', 'amazonwebservices'],
        'standards' => ['nist-ai-rmf', 'iso42001', 'eu-ai-act', 'owasp-llm', 'gdpr'],
    ],

    'ai-product-automation' => [
        'n'          => '04',
        'slug'       => 'ai-product-automation',
        'name'       => 'AI Product & Automation',
        'short'      => 'AI Product',
        'kicker'     => 'AI inside the product',
        'title'      => '<span class="g">AI features people use.</span> Automation that holds.',
        'lead'       => 'AI Product & Automation adds AI to your products and operations: knowledge and retrieval-augmented generation, conversational and vision AI, and workflow automation. Built to be accurate, measured with evals and affordable to run every day.',
        'meta'       => ['8–14 weeks per feature', 'RAG · conversational · vision · automation', 'Eval-gated releases'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Scope', 'Standard'],
        'cta'        => 'Start an AI product brief',
        'icon'       => 'sparkle',
        'offer_title'=> '<span class="g">Six ways AI ships,</span> one evaluation bar',
        'offer_lead' => 'Every feature has an eval set before it has a launch date. Quality, latency and cost per request are tracked from the first prototype.',
        'offer' => [
            ['Knowledge & RAG',             'Search and answers grounded in your documents, with hybrid retrieval, re-ranking, citations and permission-aware access.', 'Grounded · cited', 'doc'],
            ['Conversational AI',           'Chat and voice assistants for customers and staff that resolve requests through your systems and hand over to people cleanly.', 'Chat · voice · handoff', 'chat'],
            ['Vision & document AI',        'Extraction, classification and inspection from images, scans and video, with confidence thresholds and human review queues.', 'OCR · detection', 'vision'],
            ['AI features in your product', 'Summaries, drafting, recommendations and natural-language search designed into the interface, with fallbacks when the model is unsure.', 'In-product', 'sparkle'],
            ['Workflow automation',         'Multi-step processes automated across email, documents, CRM and ERP, with exceptions routed to the right person.', 'Straight-through · exceptions', 'workflow'],
            ['Evals & LLMOps',              'Offline eval suites for faithfulness, relevance and safety, online monitoring, prompt and model versioning, and cost tracking.', 'Faithfulness · cost', 'eval'],
        ],
        'process' => [
            'title' => '<span class="g">Eval set first,</span> feature second',
            'lead'  => 'Before building, we agree what a good answer looks like and write the tests. Every change is then scored against them.',
            'steps' => [
                ['Frame',     'Wk 01–02', 'The job to be done, the users, the data sources and the failure modes that matter. Success measures and an eval set drafted with domain experts.', ['Feature spec', 'Eval set v1', 'Data inventory']],
                ['Prototype', 'Wk 02–05', 'Retrieval, prompts and model options compared on the eval set for quality, latency and cost. The design is chosen on the numbers.', ['Prototype', 'Model comparison', 'Cost model']],
                ['Build',     'Wk 05–12', 'Production pipeline, guardrails, interface, feedback capture and monitoring. Releases gated on eval thresholds in CI.', ['Production feature', 'Guardrails', 'Eval gate in CI']],
                ['Operate',   'Wk 12–14', 'Staged rollout, online evaluation, and drift and cost alerts. The eval set grows from real traffic.', ['Rollout', 'Quality dashboard', 'Improvement backlog']],
            ],
        ],
        'deliver' => [
            ['AI feature or automation in production', 'Source · your cloud'],
            ['Retrieval pipeline & index',             'Code · vector index'],
            ['Evaluation suite',                       'Datasets · scorers · CI'],
            ['Prompt & model registry',                'Versioned config'],
            ['Guardrails & human review queues',       'Config · workflow'],
            ['Quality, latency & cost dashboard',      'Dashboard'],
        ],
        'outcomes' => [
            ['Answers you can trace',          'Grounded responses with citations and measured faithfulness, so people check the source rather than trust the tone.'],
            ['Automation with an exit',        'Exceptions reach people with context. Straight-through rates rise as confidence is earned.'],
            ['Unit economics known up front',  'Cost per request and per resolved task tracked from the prototype, not discovered on the first invoice.'],
        ],
        'faq' => [
            ['What is RAG and when do we need it?', 'Retrieval-augmented generation fetches relevant passages from your own content and gives them to the model to answer from, with citations. You need it when answers must reflect your documents, policies or data rather than what a model learned in training.'],
            ['How do you measure answer quality?', 'With eval sets built with your experts, scored for faithfulness (is the answer supported by the retrieved sources), answer relevance, context precision and recall, and safety. Automated scorers are calibrated against human review.'],
            ['Fine-tuning or RAG?', 'RAG for knowledge that changes and must be cited; fine-tuning for style, format or narrow tasks where a smaller model can match a larger one at lower cost. Many systems use both.'],
            ['Can this run on our own infrastructure?', 'Yes. Open-weight models can be self-hosted in your cloud or on your own GPUs with vLLM or similar, and vector search can run in PostgreSQL with pgvector or in a dedicated vector database.'],
            ['What does it cost to run?', 'It depends on volume, model and context size. We model cost per request during the prototype, then use caching, smaller models for simple steps and batching to bring it down before launch.'],
        ],
        'pairs'     => ['ai-strategy-agents', 'ai-infrastructure-cloud'],
        'img'       => ['src' => 'assets/imgs/tech/shared/ai-product-automation.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'Lines of code glow on a monitor beside a backlit keyboard in a dim room', 'pos' => '50% 50%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['openai', 'anthropic', 'googlegemini', 'huggingface', 'pytorch', 'langchain', 'llamaindex', 'pgvector', 'qdrant', 'pinecone', 'n8n', 'python', 'fastapi', 'twilio'],
        'standards' => ['owasp-llm', 'nist-ai-rmf', 'iso42001', 'eu-ai-act', 'gdpr', 'dpdp'],
    ],

    'ai-infrastructure-cloud' => [
        'n'          => '05',
        'slug'       => 'ai-infrastructure-cloud',
        'name'       => 'AI Infrastructure & Cloud',
        'short'      => 'AI Infrastructure',
        'kicker'     => 'Fast, reliable, affordable',
        'title'      => '<span class="g">Models are the easy part.</span> Running them well is the work.',
        'lead'       => 'AI Infrastructure & Cloud builds the backend that makes AI fast, reliable and cheap to run at scale: inference platforms, cloud foundations, data and model pipelines, and the SRE and FinOps practice that keeps latency and spend in check.',
        'meta'       => ['4–12 weeks per phase', 'AWS · Azure · Google Cloud', 'SLOs and budgets from day one'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Clouds', 'Standard'],
        'cta'        => 'Start an infrastructure brief',
        'icon'       => 'gpu',
        'offer_title'=> '<span class="g">Latency, uptime, cost.</span> Engineered together.',
        'offer_lead' => 'Every platform decision is made against three numbers: p95 latency, availability against the SLO, and cost per thousand requests.',
        'offer' => [
            ['Inference platforms',                'Model serving with vLLM, Triton or managed endpoints: batching, quantisation, autoscaling and routing between models by cost and quality.', 'p95 latency · throughput', 'gpu'],
            ['Cloud foundations',                  'Landing zones, networking, identity and policy as code on AWS, Azure or Google Cloud, so every workload starts compliant.', 'Landing zone · IaC', 'cloud'],
            ['Kubernetes & platform engineering',  'Clusters, GPU node pools, GitOps delivery and an internal developer platform that makes the right path the easy one.', 'GitOps · golden paths', 'cluster'],
            ['Data & ML pipelines',                'Feature, training and embedding pipelines with lineage, orchestration and reproducible runs.', 'Lineage · reproducible', 'pipeline'],
            ['SRE & observability',                'SLOs, error budgets, tracing and alerting on OpenTelemetry, so dashboards catch incidents before customers do.', 'SLOs · error budgets', 'uptime'],
            ['FinOps & GreenOps',                  'Cost allocation, rightsizing, spot and committed capacity, caching and carbon measured per workload.', 'Cost · carbon per unit', 'cost'],
        ],
        'process' => [
            'title' => '<span class="g">Measure the baseline,</span> then move the numbers',
            'lead'  => 'Latency, availability, spend and carbon are measured before anything changes, so every improvement is proven.',
            'steps' => [
                ['Baseline', 'Wk 01–02', 'Current architecture, traffic, latency percentiles, incidents, spend and carbon measured. Targets and SLOs agreed.', ['Baseline report', 'SLO targets', 'Cost breakdown']],
                ['Design',   'Wk 02–04', 'Target architecture, serving strategy, capacity plan and migration path, with each decision recorded against the numbers.', ['Target architecture', 'Capacity model', 'ADRs']],
                ['Build',    'Wk 04–10', 'Infrastructure as code, pipelines and the serving stack built and load-tested. Observability and cost tags on from the first resource.', ['IaC modules', 'Load-test results', 'Dashboards']],
                ['Run',      'Wk 10–12', 'Cutover, on-call runbooks and a monthly review of SLOs, spend and capacity. Optimisation continues on evidence.', ['Runbooks', 'SLO reviews', 'FinOps report']],
            ],
        ],
        'deliver' => [
            ['Infrastructure as code modules',            'Terraform · Helm'],
            ['Reference architecture & decision records', 'Diagrams · ADRs'],
            ['Model serving stack',                       'Containers · config'],
            ['CI/CD & GitOps pipelines',                  'Pipelines · Argo CD'],
            ['SLOs, dashboards & alerts',                 'Grafana · alert rules'],
            ['Load & failover test reports',              'k6 · report'],
            ['Cost & carbon allocation report',           'Dashboard · Sheet'],
        ],
        'outcomes' => [
            ['Latency inside budget',     'p95 and p99 targets set per endpoint and held under load, with autoscaling tested rather than assumed.'],
            ['Reliability you can quote', 'SLOs with error budgets that decide when to ship features and when to fix reliability.'],
            ['Spend that tracks value',   'Cost per request, per user and per model visible to the team that controls it, and trending down.'],
        ],
        'faq' => [
            ['Should we self-host models or use APIs?', 'APIs are fastest to start and hard to beat at low volume. Self-hosting open-weight models pays off with steady high volume, strict data residency or tight latency needs. We model the break-even on your traffic before recommending either.'],
            ['What does an SLO and error budget look like?', 'An SLO is a target such as 99.9% of requests succeeding within 800 ms over 30 days. The error budget is the remaining 0.1%, about 43 minutes of full downtime in a 30-day month. When it is spent, reliability work takes priority over new features.'],
            ['Which cloud do you recommend?', 'The one that fits your existing contracts, data location, skills and the AI services you need. We work across AWS, Azure and Google Cloud and design for portability where it is worth the cost.'],
            ['How do you reduce GPU costs?', 'Right-sized instances, batching and quantisation, prompt and response caching, routing simple requests to smaller models, scaling to zero where latency allows, and spot or committed capacity where the workload fits.'],
            ['Do you measure carbon?', 'Yes, with the Green Software Foundation’s Software Carbon Intensity method, SCI = ((E × I) + M) per R, so emissions are reported per request or per inference and reduced alongside cost.'],
        ],
        'pairs'     => ['ai-product-automation', 'cybersecurity-ai-trust'],
        'img'       => ['src' => 'assets/imgs/tech/shared/ai-infrastructure-cloud.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'Server racks with patch cables and amber status displays in a dim equipment room', 'pos' => '40% 50%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['amazonwebservices', 'microsoftazure', 'googlecloud', 'kubernetes', 'terraform', 'docker', 'nvidia', 'vllm', 'ray', 'argo', 'opentelemetry', 'prometheus', 'grafana', 'cloudflare'],
        'standards' => ['sci', 'iso27001', 'soc2', 'cis', 'iso22301', 'iso14001'],
    ],

    'cybersecurity-ai-trust' => [
        'n'          => '06',
        'slug'       => 'cybersecurity-ai-trust',
        'name'       => 'Cybersecurity & AI Trust',
        'short'      => 'Security',
        'kicker'     => 'Secure, governed, provable',
        'title'      => '<span class="g">Trust is engineered,</span> then proven.',
        'lead'       => 'Cybersecurity & AI Trust secures your product, data and AI systems, and builds the governance that keeps you compliant. Threat modelling, secure delivery, cloud and identity security, AI red-teaming and audit-ready evidence, run as one programme.',
        'meta'       => ['2-week assessment · ongoing', 'Product · cloud · data · AI', 'Evidence captured as you ship'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical start', 'Scope', 'Standard'],
        'cta'        => 'Start a security brief',
        'icon'       => 'shield',
        'offer_title'=> '<span class="g">Security and AI governance</span> in one programme',
        'offer_lead' => 'Controls are built into pipelines and platforms, so compliance evidence is a by-product of shipping rather than a quarterly scramble.',
        'offer' => [
            ['Application & API security',     'Threat modelling, secure code review, SAST, DAST and dependency scanning, verified against OWASP ASVS.', 'ASVS · Top 10', 'code'],
            ['Cloud & identity security',      'Least-privilege IAM, SSO and MFA, secrets management, network segmentation and CIS-hardened configuration.', 'Zero trust · least privilege', 'key'],
            ['AI security & red-teaming',      'Adversarial testing for prompt injection, data exfiltration, jailbreaks and tool misuse, mapped to the OWASP Top 10 for LLM Applications and MITRE ATLAS.', 'LLM01 · ATLAS', 'bug'],
            ['AI governance & responsible AI', 'AI inventory, risk classification, impact assessments and human-oversight controls aligned with NIST AI RMF, ISO/IEC 42001 and the EU AI Act.', 'Inventory · oversight', 'shield'],
            ['Compliance readiness',           'Gap assessments and control implementation for ISO/IEC 27001, SOC 2, GDPR, the DPDP Act and PCI DSS, with evidence collected automatically.', 'Audit-ready', 'clipboard-check'],
            ['Detection & response',           'Logging, detection rules, incident runbooks and tabletop exercises, including CERT-In reporting timelines for India.', 'Detect · respond', 'radar'],
        ],
        'process' => [
            'title' => '<span class="g">Assess, fix, prove,</span> then keep it that way',
            'lead'  => 'Findings are ranked by exploitability and business impact. Fixes land in the pipeline, where they stay fixed.',
            'steps' => [
                ['Assess', 'Wk 01–02', 'Threat model, architecture and cloud review, identity and access review, and an AI system inventory. Gaps mapped to the frameworks you need.', ['Threat model', 'Gap assessment', 'Risk register']],
                ['Harden', 'Wk 03–08', 'Priority fixes, security gates in CI/CD, IAM clean-up, secrets rotation, AI guardrails and red-team fixes.', ['Remediation', 'Pipeline controls', 'Red-team report']],
                ['Govern', 'Wk 06–10', 'Policies, AI governance, risk ownership and automated evidence collection mapped to controls.', ['Policy set', 'Control mapping', 'Evidence automation']],
                ['Assure', 'Ongoing',  'Continuous scanning, regular red-team and tabletop exercises, audit support and a posture report for leadership.', ['Posture dashboard', 'Exercise reports', 'Audit support']],
            ],
        ],
        'deliver' => [
            ['Threat models & security architecture review', 'Diagrams · report'],
            ['Penetration test & AI red-team reports',       'Report · retest'],
            ['Risk register & remediation plan',             'Sheet · board'],
            ['Security controls in CI/CD',                   'Pipeline config'],
            ['Policy set & AI governance framework',         'Documents'],
            ['Control-to-evidence mapping',                  'Sheet · GRC tool'],
            ['Incident response runbooks',                   'Runbooks'],
        ],
        'outcomes' => [
            ['Fewer ways in',                'Exploitable findings closed first, and scanners in the pipeline stop the same class of issue returning.'],
            ['AI you can defend',            'Every AI system inventoried, risk-rated, tested against prompt injection and overseen by a named owner.'],
            ['Audits without the scramble',  'Evidence collected continuously and mapped to controls, so the auditor’s request list becomes a report rather than a project.'],
        ],
        'faq' => [
            ['Can you get us ISO 27001 certified or SOC 2 attested?', 'Certificates are issued by accredited certification bodies and SOC 2 reports by licensed CPA firms, not by us. We prepare you: gap assessment, control implementation, evidence and audit support, working alongside the auditor you appoint.'],
            ['What is prompt injection and how do you test for it?', 'Prompt injection (OWASP LLM01) is input, typed directly or hidden in content the model reads, that makes a model ignore its instructions or misuse its tools. We test with curated and generated attack suites, indirect injection through documents and web pages, and tool-permission abuse, then fix with isolation, least privilege and output checks.'],
            ['Does the EU AI Act apply to us?', 'It can apply to organisations outside the EU when AI systems are placed on the EU market or their outputs are used in the EU. We classify each use case by risk tier and set out which obligations, if any, follow.'],
            ['What does the DPDP Act require from us?', 'Clear notice and consent, purpose limitation, reasonable security safeguards, breach intimation to the Data Protection Board and affected people, and handling of data-principal rights, with added duties for significant data fiduciaries.'],
            ['Do you run a 24/7 SOC?', 'We design detection and response and can operate it with your team or with a managed SOC provider you choose. Round-the-clock coverage is agreed in the support model, never assumed.'],
        ],
        'pairs'     => ['audits-assessments', 'ai-infrastructure-cloud'],
        'img'       => ['src' => 'assets/imgs/tech/shared/cybersecurity-ai-trust.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A combination padlock resting on a white keyboard', 'pos' => '45% 55%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['okta', 'auth0', 'vault', 'snyk', 'trivy', 'burpsuite', 'owasp', 'cloudflare', 'sonarqubecloud', 'opentelemetry', 'elastic', 'falco', 'kubernetes', 'github'],
        'standards' => ['iso27001', 'soc2', 'nist-csf', 'owasp-asvs', 'owasp-llm', 'mitre-atlas', 'iso42001', 'eu-ai-act', 'gdpr', 'dpdp', 'pci-dss', 'cert-in'],
    ],

    'integration-support' => [
        'n'          => '07',
        'slug'       => 'integration-support',
        'name'       => 'Integration & Support',
        'short'      => 'Integration',
        'kicker'     => 'One system, looked after',
        'title'      => '<span class="g">Connected tools.</span> Engineers who stay.',
        'lead'       => 'Integration & Support connects your applications and data into one working system, then keeps it running with ongoing engineering: monitoring, incident response, upgrades and continuous improvement under agreed service levels.',
        'meta'       => ['4–10 weeks per phase', 'APIs · events · iPaaS', 'SLA-backed support'],   // PLACEHOLDER: confirm timeframe and support terms
        'meta_k'     => ['Typical length', 'Approach', 'Support'],
        'cta'        => 'Start an integration brief',
        'icon'       => 'plug',
        'offer_title'=> '<span class="g">Connect it once,</span> keep it working',
        'offer_lead' => 'Integrations are treated as products with contracts, monitoring and owners, so a vendor’s API change becomes an alert, not an outage.',
        'offer' => [
            ['API design & management',        'Versioned REST and GraphQL APIs with OpenAPI contracts, gateways, rate limits and developer documentation.', 'Contract-first', 'api'],
            ['System & data integration',      'CRM, ERP, commerce, payments and marketing systems connected through APIs, events or change data capture.', 'APIs · events · CDC', 'plug'],
            ['iPaaS & workflow automation',    'Low-code integration on Zapier, Make, n8n or MuleSoft where it fits, with the same monitoring as custom code.', 'Low-code, governed', 'workflow'],
            ['Legacy modernisation',           'Strangler-pattern wrappers and staged migration away from systems that are costly to change, without a risky big-bang switch.', 'Strangler pattern', 'sync'],
            ['Managed support & SRE',          'Monitoring, on-call, incident management and post-incident reviews against agreed response and resolution targets.', 'SLAs · on-call', 'headset'],
            ['Continuous improvement',         'A monthly engineering allowance for upgrades, security patches, performance work and the small features that pile up.', 'Retainer · roadmap', 'wrench'],
        ],
        'process' => [
            'title' => '<span class="g">Integrate in phases,</span> support from the first release',
            'lead'  => 'Each integration is monitored from the day it goes live, so support starts with context rather than a handover document.',
            'steps' => [
                ['Map',        'Wk 01–02', 'Systems, data flows, ownership, volumes and failure points. Integration patterns and data contracts agreed per flow.', ['Integration map', 'Data contracts', 'Pattern decisions']],
                ['Connect',    'Wk 02–08', 'Integrations built with retries, idempotency, dead-letter queues and alerting, then tested against sandboxes and recorded traffic.', ['Integrations', 'Contract tests', 'Alerting']],
                ['Transition', 'Wk 08–10', 'Runbooks, access, monitoring and support tiers agreed. Your team and ours rehearse an incident together.', ['Runbooks', 'Support model', 'Incident drill']],
                ['Support',    'Ongoing',  'On-call, incidents, upgrades and improvements. A monthly service review against SLAs and a quarterly roadmap.', ['Service reports', 'Post-incident reviews', 'Roadmap']],
            ],
        ],
        'deliver' => [
            ['Integration architecture & data flow map', 'Diagrams'],
            ['API specifications & developer docs',      'OpenAPI · portal'],
            ['Integrations with monitoring & alerting',  'Code · iPaaS · alerts'],
            ['Contract & regression test suites',        'Tests · CI'],
            ['Support model & service levels',           'Agreement'],
            ['Runbooks & on-call rota',                  'Docs · rota'],
            ['Monthly service report',                   'Report'],
        ],
        'outcomes' => [
            ['Data that arrives once',  'Idempotent, retried and monitored flows. No duplicates, no silent failures, no weekly reconciliation by hand.'],
            ['Change without breakage', 'Contract tests catch a vendor’s API change before your customers do.'],
            ['Support with context',    'The engineers who built it run it, with response targets you can hold them to.'],
        ],
        'faq' => [
            ['iPaaS or custom integration?', 'iPaaS suits standard connectors, moderate volumes and teams who want to change flows themselves. Custom code suits high volume, complex transformation, strict latency or cost at scale. Many estates use both, under the same monitoring.'],
            ['What service levels do you offer?', 'Support is agreed per system, typically with response targets by severity, business-hours or extended coverage, and a monthly improvement allowance. The exact terms are set in the support agreement.'],   // PLACEHOLDER: confirm support tiers before launch
            ['Can you support systems you did not build?', 'Yes, after an onboarding assessment of the code, infrastructure, monitoring and documentation. Gaps found there are fixed first, so support targets are realistic.'],
            ['How do you handle incidents?', 'Severity-based on-call with defined response times, a named incident lead, status updates to your stakeholders, and a blameless post-incident review with actions tracked to closure.'],
            ['What does a retainer include?', 'Monitoring and incident response, security patches and dependency upgrades, and an agreed number of engineering hours each month for improvements, prioritised with you.'],
        ],
        'pairs'     => ['custom-software-data-platforms', 'tech-workforce'],
        'img'       => ['src' => 'assets/imgs/tech/shared/integration-support.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'Blue network cables plugged into a rack-mounted switch with status lights glowing', 'pos' => '30% 50%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['mulesoft', 'zapier', 'make', 'n8n', 'kong', 'postman', 'openapiinitiative', 'apachekafka', 'rabbitmq', 'salesforce', 'hubspot', 'sap', 'stripe', 'pagerduty'],
        'standards' => ['iso27001', 'soc2', 'iso22301', 'dora-metrics', 'gdpr'],
    ],

    'search-ai-visibility' => [
        'n'          => '08',
        'slug'       => 'search-ai-visibility',
        'name'       => 'Search & AI Visibility',
        'short'      => 'Search',
        'kicker'     => 'Found by people and by machines',
        'title'      => '<span class="g">Rank on Google.</span> Get cited by the answer engines.',
        'lead'       => 'Search & AI Visibility makes your brand findable wherever people ask: ranking in Google and Bing, and cited in ChatGPT, Perplexity, Gemini and Google’s AI Overviews. Technical SEO, answer engine optimisation (AEO) and generative engine optimisation (GEO) run as one system.',
        'meta'       => ['90-day programme · ongoing', 'SEO · AEO · GEO', 'Reported monthly'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical cycle', 'Scope', 'Reporting'],
        'cta'        => 'Start a visibility brief',
        'icon'       => 'search',
        'offer_title'=> '<span class="g">One content system,</span> every place people ask',
        'offer_lead' => 'Crawlable pages, clear entities and genuinely useful answers serve both the ranking algorithm and the language model that summarises it.',
        'offer' => [
            ['Technical SEO',                   'Crawlability, indexation, rendering, site architecture, Core Web Vitals and international targeting with hreflang.', 'Crawl · index · render', 'terminal'],
            ['Answer engine optimisation',      'Content structured to answer real questions directly, earning featured snippets, People Also Ask placements and AI Overview citations.', 'AEO', 'chat'],
            ['Generative engine optimisation',  'Entity clarity, citations from trusted sources and content that language models can quote accurately when they recommend.', 'GEO', 'sparkle'],
            ['Structured data & entities',      'Schema.org markup in JSON-LD, knowledge graph alignment and consistent entity facts across your site and the wider web.', 'Schema.org · JSON-LD', 'cube'],
            ['Content strategy & authority',    'Topic clusters built from search demand and customer questions, written with subject experts to show real experience.', 'Topics · E-E-A-T', 'doc'],
            ['AI visibility measurement',       'Rankings, AI Overview presence, and brand mentions and citations across answer engines, tracked for a defined prompt set.', 'Share of answer', 'radar'],
        ],
        'process' => [
            'title' => '<span class="g">Fix the foundations,</span> then earn the citations',
            'lead'  => 'Nothing ranks or gets cited if it cannot be crawled and understood. Technical work comes first; authority compounds after.',
            'steps' => [
                ['Audit',   'Wk 01–03', 'Technical crawl, log and index analysis, content and entity audit, and a baseline of rankings and AI-answer presence for your priority questions.', ['Technical audit', 'Visibility baseline', 'Prompt set']],
                ['Fix',     'Wk 03–06', 'Indexation, rendering, speed, internal linking and structured data fixed with your developers, highest impact first.', ['Fix backlog', 'Schema implementation', 'CWV improvements']],
                ['Build',   'Wk 06–12', 'Topic clusters, answer-first pages and expert content published. Citations earned from trusted sources through digital PR.', ['Content cluster', 'Entity updates', 'Citation plan']],
                ['Measure', 'Monthly',  'Rankings, organic traffic and conversions, AI Overview presence and share of answer across engines, reported against the baseline.', ['Monthly report', 'Share-of-answer tracking', 'Next-quarter plan']],
            ],
        ],
        'deliver' => [
            ['Technical SEO audit & prioritised backlog', 'Report · tickets'],
            ['Structured data implementation',            'JSON-LD'],
            ['Topic & entity map',                        'Sheet · board'],
            ['Answer-first content',                      'CMS pages'],
            ['AI visibility prompt set & tracker',        'Dashboard'],
            ['Monthly visibility report',                 'Dashboard · PDF'],
        ],
        'outcomes' => [
            ['Pages that can be found',  'Every important page crawled, rendered and indexed, and fast enough to compete.'],
            ['Cited, not only ranked',   'Your brand named and linked in AI answers for the questions that lead to revenue.'],
            ['One measure of visibility','Rankings, AI Overview presence and share of answer tracked together against a baseline.'],
        ],
        'faq' => [
            ['What is the difference between SEO, AEO and GEO?', 'SEO earns rankings in search results. AEO, answer engine optimisation, structures content to be the direct answer in snippets and AI Overviews. GEO, generative engine optimisation, improves how assistants such as ChatGPT, Perplexity and Gemini understand, cite and recommend your brand. They share the same foundations, so we run them as one programme.'],
            ['Can you guarantee a first-page ranking or a ChatGPT citation?', 'No one can honestly guarantee either: search engines and model providers control their results. We commit to the work, the measurement and transparent reporting against a baseline.'],
            ['How do you measure visibility in AI answers?', 'We define a set of prompts that reflect how your customers ask, run them regularly across the major answer engines, and track whether your brand is mentioned, cited and linked, and how that share changes over time.'],
            ['Does AI search make SEO obsolete?', 'No. Answer engines draw heavily on content that is crawlable, well structured and cited by trusted sources, which is what good SEO produces. The measures change; the foundations do not.'],
            ['How long before results show?', 'Technical fixes can show within weeks of being recrawled. Content and authority typically take three to six months to compound, depending on competition and how often you publish.'],
        ],
        'pairs'     => ['websites-apps', 'audits-assessments'],
        'img'       => ['src' => 'assets/imgs/tech/shared/search-ai-visibility.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'A laptop screen shows an AI assistant search bar waiting for a question', 'pos' => '50% 50%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['google', 'googlesearchconsole', 'googleanalytics', 'googletagmanager', 'pagespeedinsights', 'lighthouse', 'semrush', 'ahrefs', 'schemaorg', 'perplexity', 'openai', 'googlegemini', 'wordpress', 'contentful'],
        'standards' => ['cwv', 'wcag22', 'gdpr', 'dpdp'],
    ],

    'audits-assessments' => [
        'n'          => '09',
        'slug'       => 'audits-assessments',
        'name'       => 'Audits & Assessments',
        'short'      => 'Audits',
        'kicker'     => 'Know before you spend',
        'title'      => '<span class="g">What’s broken, what it costs,</span> and what to fix first.',
        'lead'       => 'Audits & Assessments give you an independent, evidence-based read on your technology. Technical, SEO, security, data and AI-readiness audits find what is broken, estimate what it is costing you and rank what to fix first.',
        'meta'       => ['2–6 weeks', 'Technical · SEO · security · data · AI', 'Scoped up front'],   // PLACEHOLDER: confirm timeframe
        'meta_k'     => ['Typical length', 'Audit types', 'Commercials'],
        'cta'        => 'Start an audit brief',
        'icon'       => 'clipboard-check',
        'offer_title'=> '<span class="g">Six audits,</span> one ranked backlog',
        'offer_lead' => 'Every finding carries evidence, a severity, an estimated cost of inaction and an effort to fix, so the order of work is a calculation rather than an opinion.',
        'offer' => [
            ['Technical & architecture audit',   'Code quality, architecture, test coverage, dependencies, the delivery pipeline and DORA metrics, benchmarked against what your roadmap needs.', 'Code · architecture · delivery', 'code'],
            ['Performance & accessibility audit','Core Web Vitals from field data, load testing and WCAG 2.2 AA conformance, with the revenue and legal risk each gap carries.', 'CWV · WCAG 2.2', 'gauge'],
            ['SEO & AI visibility audit',        'Crawlability, indexation, structured data, content and entity gaps, and how often answer engines mention your brand.', 'Search · answer engines', 'search'],
            ['Security & compliance assessment', 'Vulnerability assessment, cloud and identity configuration review, and a gap analysis against ISO/IEC 27001, SOC 2 or the DPDP Act.', 'Vulnerabilities · gaps', 'shield'],
            ['Data & analytics audit',           'Data quality, lineage, governance, tracking accuracy and consent handling across your stack.', 'Quality · lineage · consent', 'database'],
            ['AI readiness assessment',          'Data, infrastructure, skills, governance and use-case readiness scored, with the prerequisites to fix before the first AI build.', 'Readiness score', 'brain'],
        ],
        'process' => [
            'title' => '<span class="g">Four weeks,</span> from access to action plan',
            'lead'  => 'Automated scans cover breadth; senior engineers cover depth. Findings are tested with your team before they are written up.',
            'steps' => [
                ['Scope',       'Wk 01',    'Objectives, systems in scope, access, stakeholders and the decisions the audit has to inform.', ['Audit charter', 'Access checklist']],
                ['Investigate', 'Wk 01–03', 'Automated scanning, manual review, interviews and data analysis. Evidence captured for every finding.', ['Evidence log', 'Interview notes', 'Scan results']],
                ['Quantify',    'Wk 03–04', 'Findings rated for severity and business impact, cost of inaction estimated, effort to fix sized and the backlog ranked.', ['Findings register', 'Impact model', 'Ranked backlog']],
                ['Report',      'Wk 04',    'Executive summary, detailed findings and a 30-60-90-day plan, walked through with leadership and the engineering team.', ['Executive readout', 'Detailed report', '30-60-90 plan']],
            ],
        ],
        'deliver' => [
            ['Executive summary',                 'Deck · 2 pages'],
            ['Detailed findings with evidence',   'Report'],
            ['Scorecard by audit area',           'Dashboard'],
            ['Ranked remediation backlog',        'Sheet · Jira'],
            ['Cost-of-inaction estimates',        'Model · Sheet'],
            ['30-60-90-day action plan',          'Roadmap'],
        ],
        'outcomes' => [
            ['A ranked list, not a long list', 'Findings ordered by impact and effort, so the first sprint of fixes is obvious.'],
            ['Numbers leadership can use',     'Cost of inaction and effort estimates that turn technical debt into a budget decision.'],
            ['An independent baseline',        'A scored starting point to measure progress against, re-run in six or twelve months.'],
        ],
        'faq' => [
            ['How is this different from an automated scan?', 'Scanners find symptoms at scale, and we use them. The audit adds senior review, context from your team, business impact and a ranked plan. A scan tells you there are 400 issues; an audit tells you which 12 matter this quarter.'],
            ['What access do you need?', 'Read access to code repositories, cloud consoles, analytics and the relevant tools, plus a few hours with the people who build and run the systems. Security testing happens only under a signed scope and rules of engagement.'],
            ['Will you tell us things we do not want to hear?', 'Yes. The value of an audit is its independence. Findings are evidenced and discussed with your team before the report, but they are not softened.'],
            ['Can you fix what you find?', 'Yes, or your team can. The backlog is written so anyone can execute it. If we do the work, it is scoped separately so the audit stays independent of the fix.'],
            ['Which audit should we start with?', 'The one closest to the decision you face: a replatform, an AI programme, a funding round, a compliance deadline or falling organic traffic. Several audits can run together and share one backlog.'],
        ],
        'pairs'     => ['cybersecurity-ai-trust', 'search-ai-visibility'],
        'img'       => ['src' => 'assets/imgs/tech/shared/audits-assessments.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'Two people review printed reports with a pen at a grey table beside a tablet and a phone', 'pos' => '50% 45%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['sonarqubecloud', 'snyk', 'lighthouse', 'pagespeedinsights', 'k6', 'googlesearchconsole', 'semrush', 'burpsuite', 'trivy', 'datadog', 'googleanalytics', 'github', 'jira'],
        'standards' => ['iso27001', 'soc2', 'owasp-asvs', 'wcag22', 'cwv', 'dora-metrics', 'nist-ai-rmf', 'dpdp', 'gdpr'],
    ],

    'tech-workforce' => [
        'n'          => '10',
        'slug'       => 'tech-workforce',
        'name'       => 'Tech Workforce',
        'short'      => 'Workforce',
        'kicker'     => 'Capacity without the hiring cycle',
        'title'      => '<span class="g">Engineers in your sprint,</span> not in your hiring pipeline.',
        'lead'       => 'Tech Workforce embeds vetted engineers, AI specialists and full delivery squads in your team. They work in your stack, your tools and your sprint cadence, with delivery management and quality measures that turn added capacity into shipped work.',
        'meta'       => ['Start in 2–4 weeks', 'Individuals · pods · squads', 'Your stack, your cadence'],   // PLACEHOLDER: confirm lead time
        'meta_k'     => ['Typical start', 'Models', 'Approach'],
        'cta'        => 'Start a team brief',
        'icon'       => 'users',
        'offer_title'=> '<span class="g">Three ways to add capacity,</span> one quality bar',
        'offer_lead' => 'Every engineer passes the same technical vetting and works to the same delivery practices, whether they join one of your teams or arrive as a squad.',
        'offer' => [
            ['Embedded engineers',             'Frontend, backend, mobile, data, DevOps and QA engineers joining your existing teams and rituals.', 'Staff augmentation', 'users'],
            ['AI specialists',                 'ML engineers, LLM application engineers, MLOps engineers and data scientists: the skills that are hardest to hire.', 'LLM · ML · MLOps', 'brain'],
            ['Delivery squads',                'Cross-functional pods with a lead, engineers, QA and design, accountable for an outcome rather than hours.', 'Outcome-owned', 'layers'],
            ['Technical vetting',              'A multi-stage assessment run by senior engineers: live coding in your stack, system design, code review and communication.', 'Vetted by engineers', 'check'],
            ['Onboarding in your stack',       'Access, environments, a codebase walkthrough and a first merged change in the first week, following a set onboarding plan.', 'First PR in week one', 'rocket'],
            ['Delivery & quality management',  'A delivery lead tracks throughput, DORA metrics, code quality and satisfaction, and acts before small issues grow.', 'DORA · reviews', 'dashboard'],
        ],
        'process' => [
            'title' => '<span class="g">From brief to first commit</span> in weeks',
            'lead'  => 'Roles are defined by the work, candidates are matched on evidence, and the engagement is reviewed on delivery, not timesheets.',
            'steps' => [
                ['Define',  'Wk 01',    'Roles, skills, seniority, time zones, tools and the outcomes the team is accountable for.', ['Role profiles', 'Engagement model']],
                ['Match',   'Wk 01–03', 'Shortlisted engineers vetted in your stack. You interview and choose.', ['Shortlist', 'Assessment results', 'Your interviews']],
                ['Onboard', 'Wk 03–04', 'Access, environments, security briefing, codebase walkthrough and a first merged change.', ['Onboarding plan', 'First merged PR']],
                ['Deliver', 'Ongoing',  'Work in your sprints, with a monthly delivery review of throughput, quality and fit, and changes made quickly.', ['Monthly review', 'Delivery metrics', 'Scaling plan']],
            ],
        ],
        'deliver' => [
            ['Vetted engineers or a delivery squad',  'Named people'],
            ['Role profiles & assessment results',    'Scorecards'],
            ['Onboarding plan',                       'Checklist'],
            ['Delivery metrics',                      'Dashboard'],
            ['Monthly engagement review',             'Report'],
            ['Knowledge transfer & handover plan',    'Docs'],
        ],
        'outcomes' => [
            ['Capacity in weeks',      'Engineers contributing in your codebase within weeks, not after a quarter of recruiting.'],
            ['Quality you can see',   'Throughput, DORA metrics and review data shared openly, so capacity shows up as shipped work.'],
            ['Flex without the risk', 'Scale up for a launch and down after it, with knowledge written down so nothing leaves with a contractor.'],
        ],
        'faq' => [
            ['How is this different from a recruitment agency?', 'We do not hand over CVs and step away. Engineers are vetted by engineers, supported by a delivery lead, and the engagement is measured on delivery quality. If someone is not the right fit, we replace them.'],   // PLACEHOLDER: confirm replacement terms before launch
            ['Who manages the engineers day to day?', 'Embedded engineers take direction from your team leads, in your rituals. Squads are led by our delivery lead against outcomes you agree. Either way, a delivery manager reviews quality and fit with you every month.'],
            ['What about IP, security and confidentiality?', 'Work happens in your repositories and tools under your security policies, with IP assignment, NDAs and least-privilege access in the contract. Access is revoked on the first day of offboarding.'],
            ['Which time zones do you cover?', 'Teams work from India, with overlap hours agreed per engagement so stand-ups, reviews and incident response line up with your working day.'],   // PLACEHOLDER: confirm coverage model before launch
            ['Can we hire the engineers permanently?', 'Conversion terms can be agreed in the contract, so a successful engagement can become a permanent hire without a dispute.'],   // PLACEHOLDER: confirm conversion terms before launch
        ],
        'pairs'     => ['integration-support', 'websites-apps'],
        'img'       => ['src' => 'assets/imgs/tech/shared/tech-workforce.jpg', 'w' => 1200, 'h' => 800, 'alt' => 'Four colleagues gather around a desktop screen, one pointing at the work under discussion', 'pos' => '50% 40%'],   // PLACEHOLDER: reference photo (Unsplash) — confirm before launch
        'stack'     => ['typescript', 'python', 'go', 'react', 'nodedotjs', 'flutter', 'pytorch', 'amazonwebservices', 'kubernetes', 'terraform', 'github', 'jira', 'linear', 'figma'],
        'standards' => ['iso27001', 'soc2', 'dora-metrics', 'iso9001', 'gdpr'],
    ],
];
