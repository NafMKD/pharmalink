# Architecture

## 1. Core Tech Stack

* **Backend:** Laravel 12 + Octane (RoadRunner)
* **API:** REST (JSON), WebSockets
* **Frontend:** React + Vite (TanStack Query, Router)
* **Mobile:** Telegram Mini App + Bot
* **Search:** Meilisearch
* **DB (OLTP):** PostgreSQL (primary + replicas, partitioned tables)
* **Analytics/DWH:** ClickHouse (future: Kafka → CDC)
* **Cache/Queues:** Redis Cluster + Horizon
* **Object Storage:** S3-compatible (AWS/MinIO/Wasabi)
* **CDN & Edge:** Cloudflare
* **Containers:** Docker + Kubernetes
* **Observability:** OpenTelemetry, Prometheus/Grafana, Loki/ELK, Sentry
* **CI/CD:** GitHub Actions, blue/green or canary deploys

---

## 2. API & Frontend

* **API-first** (Laravel service + public API)
* React SPA + Telegram Mini App consume API
* Inertia optional for Admin

---

## 3. Domain Boundaries (Modules)

* **Tenancy & Billing:** tenants, plans, subscriptions, invoices, payments
* **Identity & Access:** SaaS admins, tenant-level users, roles (importer, wholesaler, supplier, pharmacy, salesperson)
* **Businesses & Products:** business profiles, product catalog, categories, moderation
* **Salesperson Verification:** link requests, approvals, revocations
* **Chat & Negotiation:** chats, messages, attachments
* **Moderation & Compliance:** product/salesperson review, audit trail
* **Notifications:** email/SMS/Telegram, in-app
* **Analytics & Data Pipeline:** price tracking, usage, dashboards

---

## 4. Data Model (Key Tables)

* `tenants`, `plans`, `subscriptions`, `invoices`, `payments`
* `saas_users`, `users` (tenant-level)
* `businesses`, `product_categories`, `products` (partitioned)
* `salesperson_links`
* `chats`, `messages`, `message_attachments`
* `moderation`, `audit_trail`

Indexes: BTREE on `tenant_id`, `business_id`, `product_id`, `created_at`; GIN for JSON fields; geo indexes if required.

---

## 5. Caching Strategy

* **Edge:** Cloudflare (public GETs, purge on updates)
* **App:** Redis (hot lists, profiles, unread counts)
* **DB:** Read replicas, materialized views
* **Search:** Meilisearch query cache

---

## 6. Messaging & Async

* Phase 1: Redis Queues + Horizon
* Phase 2: Kafka (event streams)
* Outbox pattern for reliable delivery

---

## 7. Real-time

* WebSockets (Laravel WebSockets / Pusher)
* Messages in Postgres, files in S3
* Non-expiring chats; cold storage for old data

---

## 8. Search & Discovery

* **Meilisearch indices:**

  * `products` (name, description, brand, category, attributes, location, price)
  * `businesses` (name, type, city, verified status)
  * Optional: users (salespeople, pharmacies) for directory/discovery


---

## 9. Analytics

* Debezium (Postgres → Kafka)
* ClickHouse warehouse
* Metabase / Superset dashboards

---

## 10. Security & Auth

* Laravel Sanctum (tokens)
* RBAC via policies/middleware
* Cloudflare WAF, API rate limits
* Audit logs (append-only)

---

## 11. Deployment & Ops

* **Envs:** dev/stage/prod
* **K8s Deployments:** api, websockets, workers, scheduler, indexer
* **Autoscale:** HPA by CPU/RPS/queue depth
* **Backups:** PITR (Postgres), snapshots (Meilisearch/S3)
* **Monitoring:** OTel, Prometheus, Grafana, Sentry, Loki

---

## 12. Performance Checklist

* Octane + RoadRunner
* Eager loading, indices, pagination/cursors
* Batch inserts for prices/messages
* Image pipeline → WebP/AVIF → CDN
* Precompute trending nightly

---

## 13. Dev Process

* Modular monolith (`App/Modules/...`)
* Patterns: CQRS-lite, Repository, Service layer, Outbox, Saga
* Tests: Pest, Playwright, API contract
* Feature flags: Laravel Pennant

---

## 14. Rollout Plan

* **MVP:** Postgres + Redis + Meilisearch + React SPA + Telegram Bot
* **Scale:** Kafka, ClickHouse, multi-node Meilisearch, autoscaled workers

---

Final: **API-first Laravel Octane + React SPA + Meilisearch + Postgres + Redis.** Telegram Mini App reuses the API. ClickHouse and Kafka as scale phase.

