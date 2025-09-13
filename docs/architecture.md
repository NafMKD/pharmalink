# Architecture

API-first, modular monolith (Laravel Octane) + React SPA + Telegram Mini App.
Edge caching via CDN; async jobs via Redis → future Kafka; analytics via ClickHouse (later).

```

\[ Clients ] --Web/Telegram--> \[ API (Laravel Octane) ] --Queue--> \[ Workers ]
\|        |                      |
\|        └--> \[ WebSockets ]    └--> \[ Indexer / ETL ]
├--> \[ Postgres (OLTP, replicas, partitions) ]
├--> \[ Redis (cache/queue) ]
├--> \[ OpenSearch (search) ]
└--> \[ S3/MinIO (files) ]

```

Bounded contexts:
- Identity & Access, Listings & Inventory, Salesperson Verification, Chat & Negotiation, Pricing & Trends, Search, Notifications.

Non-expiring chat stored in Postgres + S3; very old blobs tiered to cheaper storage.
