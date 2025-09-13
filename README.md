# PharmaLink

API-first B2B pharma supply-chain platform: listings, chat-based negotiation, pricing trends, and Telegram Mini App support.

## Monorepo map
- `apps/` – deployable apps (`api` Laravel, `web` React, `admin` Inertia or React, `telegram` Mini App + Bot)
- `packages/` – shared code (UI kit, contracts, utils, PHP domain)
- `docs/` – product + engineering docs (start here: `/docs/README.md`)
- `infra/` – Docker, K8s, Terraform
- `.github/` – CI/CD, issue/PR templates

## Quick start
See **/docs/getting-started.md** for local setup, env, and dev scripts.

## Architecture
High-level overview in **/docs/architecture.md**. Decisions recorded as ADRs in **/docs/adr**.

## Contracts
OpenAPI source of truth in **/docs/api/openapi.yaml**. Clients are generated into `packages/contracts`.
