<?php
/**
 * Technology & Intelligence — the technology library.
 *
 * Every technology the tech pages may name, keyed by a stable slug:
 *   slug => ['name' => display name, 'category' => category key, 'file' => SVG path or null]
 *
 * 'file' is a monochrome Simple Icons SVG in assets/tech/logos/ (licence notes in
 * assets/tech/logos/LICENSE.md). null means there is no licence-clean mark to use:
 * the brand is not in Simple Icons, or its icon carries a non-commercial or custom
 * licence. xt_logo() then renders a plain mono wordmark chip. Never draw, trace or
 * fetch a substitute mark for those.
 *
 * Presentation rule: these are technologies we work with. Never imply a partnership,
 * certification or reseller tier with any vendor listed here.
 *
 * Categories, in their stable display order (labels come from xt_categories() in
 * partials/tech/kit.php; entries below are grouped in the same order):

 *   languages      Languages & runtimes
 *   frontend       Web & frontend
 *   mobile         Mobile
 *   backend        Backend & APIs
 *   data           Data, analytics & streaming
 *   ai-ml          AI & ML frameworks
 *   llm            Model providers
 *   ai-tooling     Agents, retrieval & evals
 *   cloud          Cloud & edge
 *   devops         Containers, IaC & CI/CD
 *   observability  Observability
 *   quality        Testing & quality
 *   security       Security & identity
 *   integration    Integration & messaging
 *   business       CRM, commerce & payments
 *   search         Search, SEO & analytics
 *   content        CMS & content
 *   collaboration  Collaboration & design
 *
 * Render with partials/tech/kit.php: xt_logo($slug), xt_stack([$slug, …]).
 */

return [

    /* ---- Languages & runtimes ---- */
    'typescript'          => ['name' => 'TypeScript',            'category' => 'languages',    'file' => 'assets/tech/logos/typescript.svg'],
    'javascript'          => ['name' => 'JavaScript',            'category' => 'languages',    'file' => 'assets/tech/logos/javascript.svg'],
    'python'              => ['name' => 'Python',                'category' => 'languages',    'file' => 'assets/tech/logos/python.svg'],
    'go'                  => ['name' => 'Go',                    'category' => 'languages',    'file' => 'assets/tech/logos/go.svg'],
    'rust'                => ['name' => 'Rust',                  'category' => 'languages',    'file' => 'assets/tech/logos/rust.svg'],
    'kotlin'              => ['name' => 'Kotlin',                'category' => 'languages',    'file' => 'assets/tech/logos/kotlin.svg'],
    'swift'               => ['name' => 'Swift',                 'category' => 'languages',    'file' => 'assets/tech/logos/swift.svg'],
    'php'                 => ['name' => 'PHP',                   'category' => 'languages',    'file' => 'assets/tech/logos/php.svg'],
    'openjdk'             => ['name' => 'Java',                  'category' => 'languages',    'file' => 'assets/tech/logos/openjdk.svg'],
    'dotnet'              => ['name' => '.NET',                  'category' => 'languages',    'file' => 'assets/tech/logos/dotnet.svg'],
    'nodedotjs'           => ['name' => 'Node.js',               'category' => 'languages',    'file' => 'assets/tech/logos/nodedotjs.svg'],

    /* ---- Web & frontend ---- */
    'react'               => ['name' => 'React',                 'category' => 'frontend',     'file' => 'assets/tech/logos/react.svg'],
    'nextdotjs'           => ['name' => 'Next.js',               'category' => 'frontend',     'file' => 'assets/tech/logos/nextdotjs.svg'],
    'vuedotjs'            => ['name' => 'Vue.js',                'category' => 'frontend',     'file' => null],
    'angular'             => ['name' => 'Angular',               'category' => 'frontend',     'file' => 'assets/tech/logos/angular.svg'],
    'svelte'              => ['name' => 'Svelte',                'category' => 'frontend',     'file' => 'assets/tech/logos/svelte.svg'],
    'astro'               => ['name' => 'Astro',                 'category' => 'frontend',     'file' => 'assets/tech/logos/astro.svg'],
    'tailwindcss'         => ['name' => 'Tailwind CSS',          'category' => 'frontend',     'file' => 'assets/tech/logos/tailwindcss.svg'],
    'threedotjs'          => ['name' => 'Three.js',              'category' => 'frontend',     'file' => 'assets/tech/logos/threedotjs.svg'],
    'webassembly'         => ['name' => 'WebAssembly',           'category' => 'frontend',     'file' => 'assets/tech/logos/webassembly.svg'],

    /* ---- Mobile ---- */
    'flutter'             => ['name' => 'Flutter',               'category' => 'mobile',       'file' => 'assets/tech/logos/flutter.svg'],
    'reactnative'         => ['name' => 'React Native',          'category' => 'mobile',       'file' => null],
    'expo'                => ['name' => 'Expo',                  'category' => 'mobile',       'file' => 'assets/tech/logos/expo.svg'],
    'ios'                 => ['name' => 'iOS',                   'category' => 'mobile',       'file' => 'assets/tech/logos/ios.svg'],
    'android'             => ['name' => 'Android',               'category' => 'mobile',       'file' => 'assets/tech/logos/android.svg'],
    'jetpackcompose'      => ['name' => 'Jetpack Compose',       'category' => 'mobile',       'file' => 'assets/tech/logos/jetpackcompose.svg'],

    /* ---- Backend & APIs ---- */
    'nestjs'              => ['name' => 'NestJS',                'category' => 'backend',      'file' => 'assets/tech/logos/nestjs.svg'],
    'fastapi'             => ['name' => 'FastAPI',               'category' => 'backend',      'file' => 'assets/tech/logos/fastapi.svg'],
    'django'              => ['name' => 'Django',                'category' => 'backend',      'file' => 'assets/tech/logos/django.svg'],
    'laravel'             => ['name' => 'Laravel',               'category' => 'backend',      'file' => 'assets/tech/logos/laravel.svg'],
    'springboot'          => ['name' => 'Spring Boot',           'category' => 'backend',      'file' => 'assets/tech/logos/springboot.svg'],
    'graphql'             => ['name' => 'GraphQL',               'category' => 'backend',      'file' => 'assets/tech/logos/graphql.svg'],
    'openapiinitiative'   => ['name' => 'OpenAPI Initiative',    'category' => 'backend',      'file' => 'assets/tech/logos/openapiinitiative.svg'],
    'redis'               => ['name' => 'Redis',                 'category' => 'backend',      'file' => 'assets/tech/logos/redis.svg'],
    'rabbitmq'            => ['name' => 'RabbitMQ',              'category' => 'backend',      'file' => 'assets/tech/logos/rabbitmq.svg'],
    'temporal'            => ['name' => 'Temporal',              'category' => 'backend',      'file' => 'assets/tech/logos/temporal.svg'],
    'supabase'            => ['name' => 'Supabase',              'category' => 'backend',      'file' => 'assets/tech/logos/supabase.svg'],
    'firebase'            => ['name' => 'Firebase',              'category' => 'backend',      'file' => 'assets/tech/logos/firebase.svg'],

    /* ---- Data, analytics & streaming ---- */
    'postgresql'          => ['name' => 'PostgreSQL',            'category' => 'data',         'file' => 'assets/tech/logos/postgresql.svg'],
    'mongodb'             => ['name' => 'MongoDB',               'category' => 'data',         'file' => 'assets/tech/logos/mongodb.svg'],
    'snowflake'           => ['name' => 'Snowflake',             'category' => 'data',         'file' => 'assets/tech/logos/snowflake.svg'],
    'databricks'          => ['name' => 'Databricks',            'category' => 'data',         'file' => 'assets/tech/logos/databricks.svg'],
    'apachespark'         => ['name' => 'Apache Spark',          'category' => 'data',         'file' => 'assets/tech/logos/apachespark.svg'],
    'apachekafka'         => ['name' => 'Apache Kafka',          'category' => 'data',         'file' => 'assets/tech/logos/apachekafka.svg'],
    'apacheairflow'       => ['name' => 'Apache Airflow',        'category' => 'data',         'file' => 'assets/tech/logos/apacheairflow.svg'],
    'dbt'                 => ['name' => 'dbt',                   'category' => 'data',         'file' => null],
    'clickhouse'          => ['name' => 'ClickHouse',            'category' => 'data',         'file' => 'assets/tech/logos/clickhouse.svg'],
    'elasticsearch'       => ['name' => 'Elasticsearch',         'category' => 'data',         'file' => 'assets/tech/logos/elasticsearch.svg'],
    'googlebigquery'      => ['name' => 'Google BigQuery',       'category' => 'data',         'file' => 'assets/tech/logos/googlebigquery.svg'],
    'duckdb'              => ['name' => 'DuckDB',                'category' => 'data',         'file' => 'assets/tech/logos/duckdb.svg'],
    'airbyte'             => ['name' => 'Airbyte',               'category' => 'data',         'file' => 'assets/tech/logos/airbyte.svg'],
    'looker'              => ['name' => 'Looker',                'category' => 'data',         'file' => 'assets/tech/logos/looker.svg'],
    'powerbi'             => ['name' => 'Power BI',              'category' => 'data',         'file' => null],

    /* ---- AI & ML frameworks ---- */
    'pytorch'             => ['name' => 'PyTorch',               'category' => 'ai-ml',        'file' => 'assets/tech/logos/pytorch.svg'],
    'tensorflow'          => ['name' => 'TensorFlow',            'category' => 'ai-ml',        'file' => 'assets/tech/logos/tensorflow.svg'],
    'huggingface'         => ['name' => 'Hugging Face',          'category' => 'ai-ml',        'file' => 'assets/tech/logos/huggingface.svg'],
    'scikitlearn'         => ['name' => 'scikit-learn',          'category' => 'ai-ml',        'file' => 'assets/tech/logos/scikitlearn.svg'],
    'nvidia'              => ['name' => 'NVIDIA',                'category' => 'ai-ml',        'file' => 'assets/tech/logos/nvidia.svg'],
    'mlflow'              => ['name' => 'MLflow',                'category' => 'ai-ml',        'file' => 'assets/tech/logos/mlflow.svg'],
    'vllm'                => ['name' => 'vLLM',                  'category' => 'ai-ml',        'file' => 'assets/tech/logos/vllm.svg'],
    'ray'                 => ['name' => 'Ray',                   'category' => 'ai-ml',        'file' => 'assets/tech/logos/ray.svg'],
    'onnx'                => ['name' => 'ONNX',                  'category' => 'ai-ml',        'file' => 'assets/tech/logos/onnx.svg'],
    'jupyter'             => ['name' => 'Jupyter',               'category' => 'ai-ml',        'file' => 'assets/tech/logos/jupyter.svg'],

    /* ---- Model providers ---- */
    'openai'              => ['name' => 'OpenAI',                'category' => 'llm',          'file' => null],
    'anthropic'           => ['name' => 'Anthropic',             'category' => 'llm',          'file' => 'assets/tech/logos/anthropic.svg'],
    'googlegemini'        => ['name' => 'Google Gemini',         'category' => 'llm',          'file' => 'assets/tech/logos/googlegemini.svg'],
    'mistralai'           => ['name' => 'Mistral AI',            'category' => 'llm',          'file' => 'assets/tech/logos/mistralai.svg'],
    'meta'                => ['name' => 'Meta Llama',            'category' => 'llm',          'file' => 'assets/tech/logos/meta.svg'],
    'deepseek'            => ['name' => 'DeepSeek',              'category' => 'llm',          'file' => 'assets/tech/logos/deepseek.svg'],
    'ollama'              => ['name' => 'Ollama',                'category' => 'llm',          'file' => 'assets/tech/logos/ollama.svg'],
    'perplexity'          => ['name' => 'Perplexity',            'category' => 'llm',          'file' => 'assets/tech/logos/perplexity.svg'],

    /* ---- Agents, retrieval & evals ---- */
    'langchain'           => ['name' => 'LangChain',             'category' => 'ai-tooling',   'file' => 'assets/tech/logos/langchain.svg'],
    'langgraph'           => ['name' => 'LangGraph',             'category' => 'ai-tooling',   'file' => 'assets/tech/logos/langgraph.svg'],
    'llamaindex'          => ['name' => 'LlamaIndex',            'category' => 'ai-tooling',   'file' => null],
    'pinecone'            => ['name' => 'Pinecone',              'category' => 'ai-tooling',   'file' => null],
    'weaviate'            => ['name' => 'Weaviate',              'category' => 'ai-tooling',   'file' => null],
    'qdrant'              => ['name' => 'Qdrant',                'category' => 'ai-tooling',   'file' => 'assets/tech/logos/qdrant.svg'],
    'milvus'              => ['name' => 'Milvus',                'category' => 'ai-tooling',   'file' => 'assets/tech/logos/milvus.svg'],
    'pgvector'            => ['name' => 'pgvector',              'category' => 'ai-tooling',   'file' => null],
    'replicate'           => ['name' => 'Replicate',             'category' => 'ai-tooling',   'file' => 'assets/tech/logos/replicate.svg'],
    'modal'               => ['name' => 'Modal',                 'category' => 'ai-tooling',   'file' => 'assets/tech/logos/modal.svg'],
    'githubcopilot'       => ['name' => 'GitHub Copilot',        'category' => 'ai-tooling',   'file' => 'assets/tech/logos/githubcopilot.svg'],
    'cursor'              => ['name' => 'Cursor',                'category' => 'ai-tooling',   'file' => 'assets/tech/logos/cursor.svg'],

    /* ---- Cloud & edge ---- */
    'amazonwebservices'   => ['name' => 'AWS',                   'category' => 'cloud',        'file' => null],
    'microsoftazure'      => ['name' => 'Microsoft Azure',       'category' => 'cloud',        'file' => null],
    'googlecloud'         => ['name' => 'Google Cloud',          'category' => 'cloud',        'file' => 'assets/tech/logos/googlecloud.svg'],
    'cloudflare'          => ['name' => 'Cloudflare',            'category' => 'cloud',        'file' => 'assets/tech/logos/cloudflare.svg'],
    'vercel'              => ['name' => 'Vercel',                'category' => 'cloud',        'file' => 'assets/tech/logos/vercel.svg'],
    'netlify'             => ['name' => 'Netlify',               'category' => 'cloud',        'file' => 'assets/tech/logos/netlify.svg'],
    'digitalocean'        => ['name' => 'DigitalOcean',          'category' => 'cloud',        'file' => 'assets/tech/logos/digitalocean.svg'],
    'fastly'              => ['name' => 'Fastly',                'category' => 'cloud',        'file' => 'assets/tech/logos/fastly.svg'],
    'akamai'              => ['name' => 'Akamai',                'category' => 'cloud',        'file' => 'assets/tech/logos/akamai.svg'],

    /* ---- Containers, IaC & CI/CD ---- */
    'docker'              => ['name' => 'Docker',                'category' => 'devops',       'file' => 'assets/tech/logos/docker.svg'],
    'kubernetes'          => ['name' => 'Kubernetes',            'category' => 'devops',       'file' => 'assets/tech/logos/kubernetes.svg'],
    'helm'                => ['name' => 'Helm',                  'category' => 'devops',       'file' => 'assets/tech/logos/helm.svg'],
    'terraform'           => ['name' => 'Terraform',             'category' => 'devops',       'file' => 'assets/tech/logos/terraform.svg'],
    'pulumi'              => ['name' => 'Pulumi',                'category' => 'devops',       'file' => 'assets/tech/logos/pulumi.svg'],
    'ansible'             => ['name' => 'Ansible',               'category' => 'devops',       'file' => 'assets/tech/logos/ansible.svg'],
    'argo'                => ['name' => 'Argo',                  'category' => 'devops',       'file' => 'assets/tech/logos/argo.svg'],
    'githubactions'       => ['name' => 'GitHub Actions',        'category' => 'devops',       'file' => 'assets/tech/logos/githubactions.svg'],
    'github'              => ['name' => 'GitHub',                'category' => 'devops',       'file' => 'assets/tech/logos/github.svg'],
    'gitlab'              => ['name' => 'GitLab',                'category' => 'devops',       'file' => 'assets/tech/logos/gitlab.svg'],
    'jenkins'             => ['name' => 'Jenkins',               'category' => 'devops',       'file' => 'assets/tech/logos/jenkins.svg'],
    'istio'               => ['name' => 'Istio',                 'category' => 'devops',       'file' => 'assets/tech/logos/istio.svg'],

    /* ---- Observability ---- */
    'opentelemetry'       => ['name' => 'OpenTelemetry',         'category' => 'observability', 'file' => 'assets/tech/logos/opentelemetry.svg'],
    'prometheus'          => ['name' => 'Prometheus',            'category' => 'observability', 'file' => 'assets/tech/logos/prometheus.svg'],
    'grafana'             => ['name' => 'Grafana',               'category' => 'observability', 'file' => 'assets/tech/logos/grafana.svg'],
    'datadog'             => ['name' => 'Datadog',               'category' => 'observability', 'file' => 'assets/tech/logos/datadog.svg'],
    'sentry'              => ['name' => 'Sentry',                'category' => 'observability', 'file' => 'assets/tech/logos/sentry.svg'],
    'newrelic'            => ['name' => 'New Relic',             'category' => 'observability', 'file' => 'assets/tech/logos/newrelic.svg'],
    'elastic'             => ['name' => 'Elastic',               'category' => 'observability', 'file' => 'assets/tech/logos/elastic.svg'],
    'pagerduty'           => ['name' => 'PagerDuty',             'category' => 'observability', 'file' => 'assets/tech/logos/pagerduty.svg'],

    /* ---- Testing & quality ---- */
    'playwright'          => ['name' => 'Playwright',            'category' => 'quality',      'file' => null],
    'cypress'             => ['name' => 'Cypress',               'category' => 'quality',      'file' => 'assets/tech/logos/cypress.svg'],
    'selenium'            => ['name' => 'Selenium',              'category' => 'quality',      'file' => 'assets/tech/logos/selenium.svg'],
    'jest'                => ['name' => 'Jest',                  'category' => 'quality',      'file' => 'assets/tech/logos/jest.svg'],
    'k6'                  => ['name' => 'k6',                    'category' => 'quality',      'file' => 'assets/tech/logos/k6.svg'],
    'postman'             => ['name' => 'Postman',               'category' => 'quality',      'file' => 'assets/tech/logos/postman.svg'],
    'sonarqubecloud'      => ['name' => 'SonarQube',             'category' => 'quality',      'file' => 'assets/tech/logos/sonarqubecloud.svg'],

    /* ---- Security & identity ---- */
    'okta'                => ['name' => 'Okta',                  'category' => 'security',     'file' => 'assets/tech/logos/okta.svg'],
    'auth0'               => ['name' => 'Auth0',                 'category' => 'security',     'file' => 'assets/tech/logos/auth0.svg'],
    'openid'              => ['name' => 'OpenID',                'category' => 'security',     'file' => 'assets/tech/logos/openid.svg'],
    'jsonwebtokens'       => ['name' => 'JWT',                   'category' => 'security',     'file' => 'assets/tech/logos/jsonwebtokens.svg'],
    'vault'               => ['name' => 'Vault',                 'category' => 'security',     'file' => 'assets/tech/logos/vault.svg'],
    'snyk'                => ['name' => 'Snyk',                  'category' => 'security',     'file' => 'assets/tech/logos/snyk.svg'],
    'trivy'               => ['name' => 'Trivy',                 'category' => 'security',     'file' => 'assets/tech/logos/trivy.svg'],
    'falco'               => ['name' => 'Falco',                 'category' => 'security',     'file' => 'assets/tech/logos/falco.svg'],
    'owasp'               => ['name' => 'OWASP',                 'category' => 'security',     'file' => 'assets/tech/logos/owasp.svg'],
    'burpsuite'           => ['name' => 'Burp Suite',            'category' => 'security',     'file' => 'assets/tech/logos/burpsuite.svg'],
    '1password'           => ['name' => '1Password',             'category' => 'security',     'file' => 'assets/tech/logos/1password.svg'],

    /* ---- Integration & messaging ---- */
    'zapier'              => ['name' => 'Zapier',                'category' => 'integration',  'file' => 'assets/tech/logos/zapier.svg'],
    'make'                => ['name' => 'Make',                  'category' => 'integration',  'file' => 'assets/tech/logos/make.svg'],
    'n8n'                 => ['name' => 'n8n',                   'category' => 'integration',  'file' => 'assets/tech/logos/n8n.svg'],
    'mulesoft'            => ['name' => 'MuleSoft',              'category' => 'integration',  'file' => null],
    'kong'                => ['name' => 'Kong',                  'category' => 'integration',  'file' => 'assets/tech/logos/kong.svg'],
    'twilio'              => ['name' => 'Twilio',                'category' => 'integration',  'file' => null],
    'whatsapp'            => ['name' => 'WhatsApp',              'category' => 'integration',  'file' => 'assets/tech/logos/whatsapp.svg'],
    'slack'               => ['name' => 'Slack',                 'category' => 'integration',  'file' => null],
    'microsoftteams'      => ['name' => 'Microsoft Teams',       'category' => 'integration',  'file' => null],

    /* ---- CRM, commerce & payments ---- */
    'salesforce'          => ['name' => 'Salesforce',            'category' => 'business',     'file' => null],
    'hubspot'             => ['name' => 'HubSpot',               'category' => 'business',     'file' => 'assets/tech/logos/hubspot.svg'],
    'zoho'                => ['name' => 'Zoho',                  'category' => 'business',     'file' => 'assets/tech/logos/zoho.svg'],
    'sap'                 => ['name' => 'SAP',                   'category' => 'business',     'file' => 'assets/tech/logos/sap.svg'],
    'shopify'             => ['name' => 'Shopify',               'category' => 'business',     'file' => 'assets/tech/logos/shopify.svg'],
    'woocommerce'         => ['name' => 'WooCommerce',           'category' => 'business',     'file' => 'assets/tech/logos/woocommerce.svg'],
    'stripe'              => ['name' => 'Stripe',                'category' => 'business',     'file' => 'assets/tech/logos/stripe.svg'],
    'razorpay'            => ['name' => 'Razorpay',              'category' => 'business',     'file' => 'assets/tech/logos/razorpay.svg'],
    'paypal'              => ['name' => 'PayPal',                'category' => 'business',     'file' => 'assets/tech/logos/paypal.svg'],
    'intercom'            => ['name' => 'Intercom',              'category' => 'business',     'file' => 'assets/tech/logos/intercom.svg'],
    'zendesk'             => ['name' => 'Zendesk',               'category' => 'business',     'file' => 'assets/tech/logos/zendesk.svg'],

    /* ---- Search, SEO & analytics ---- */
    'google'              => ['name' => 'Google',                'category' => 'search',       'file' => 'assets/tech/logos/google.svg'],
    'googlesearchconsole' => ['name' => 'Google Search Console', 'category' => 'search',       'file' => 'assets/tech/logos/googlesearchconsole.svg'],
    'googleanalytics'     => ['name' => 'Google Analytics',      'category' => 'search',       'file' => 'assets/tech/logos/googleanalytics.svg'],
    'googletagmanager'    => ['name' => 'Google Tag Manager',    'category' => 'search',       'file' => 'assets/tech/logos/googletagmanager.svg'],
    'pagespeedinsights'   => ['name' => 'PageSpeed Insights',    'category' => 'search',       'file' => 'assets/tech/logos/pagespeedinsights.svg'],
    'lighthouse'          => ['name' => 'Lighthouse',            'category' => 'search',       'file' => 'assets/tech/logos/lighthouse.svg'],
    'semrush'             => ['name' => 'Semrush',               'category' => 'search',       'file' => 'assets/tech/logos/semrush.svg'],
    'ahrefs'              => ['name' => 'Ahrefs',                'category' => 'search',       'file' => null],
    'algolia'             => ['name' => 'Algolia',               'category' => 'search',       'file' => 'assets/tech/logos/algolia.svg'],
    'posthog'             => ['name' => 'PostHog',               'category' => 'search',       'file' => 'assets/tech/logos/posthog.svg'],
    'mixpanel'            => ['name' => 'Mixpanel',              'category' => 'search',       'file' => 'assets/tech/logos/mixpanel.svg'],
    'schemaorg'           => ['name' => 'Schema.org',            'category' => 'search',       'file' => null],

    /* ---- CMS & content ---- */
    'wordpress'           => ['name' => 'WordPress',             'category' => 'content',      'file' => 'assets/tech/logos/wordpress.svg'],
    'contentful'          => ['name' => 'Contentful',            'category' => 'content',      'file' => 'assets/tech/logos/contentful.svg'],
    'sanity'              => ['name' => 'Sanity',                'category' => 'content',      'file' => 'assets/tech/logos/sanity.svg'],
    'strapi'              => ['name' => 'Strapi',                'category' => 'content',      'file' => 'assets/tech/logos/strapi.svg'],
    'webflow'             => ['name' => 'Webflow',               'category' => 'content',      'file' => 'assets/tech/logos/webflow.svg'],

    /* ---- Collaboration & design ---- */
    'figma'               => ['name' => 'Figma',                 'category' => 'collaboration', 'file' => 'assets/tech/logos/figma.svg'],
    'storybook'           => ['name' => 'Storybook',             'category' => 'collaboration', 'file' => 'assets/tech/logos/storybook.svg'],
    'jira'                => ['name' => 'Jira',                  'category' => 'collaboration', 'file' => 'assets/tech/logos/jira.svg'],
    'confluence'          => ['name' => 'Confluence',            'category' => 'collaboration', 'file' => 'assets/tech/logos/confluence.svg'],
    'linear'              => ['name' => 'Linear',                'category' => 'collaboration', 'file' => 'assets/tech/logos/linear.svg'],
    'notion'              => ['name' => 'Notion',                'category' => 'collaboration', 'file' => 'assets/tech/logos/notion.svg'],
    'miro'                => ['name' => 'Miro',                  'category' => 'collaboration', 'file' => 'assets/tech/logos/miro.svg'],
];
