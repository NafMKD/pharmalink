# Database Notes

- Postgres 16, UUID PKs, created_at indexes.
- Large tables (`prices`, `messages`) → monthly partitioning.
- Outbox table for async event publishing.
- Search denormalization workers feed OpenSearch.

> Next: add ERD (`docs/db/er-diagram.drawio`) once the first models land.
