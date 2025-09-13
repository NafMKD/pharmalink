# Getting Started (Local)

## Prereqs
- Node 20+, PNPM or Yarn
- PHP 8.3+, Composer
- Docker Desktop
- Make (optional, for DX)

## First run
```bash
# spin up infra services (db, redis, minio, mailhog)
docker compose -f infra/compose.yaml up -d

# install deps
composer install --working-dir=apps/api
pnpm -w install

# envs
cp apps/api/.env.example apps/api/.env
cp apps/web/.env.example apps/web/.env

# run dev
php -d variables_order=EGPCS apps/api/artisan migrate
php apps/api/artisan octane:start --watch
pnpm --filter @pharmalink/web dev
````

## Services (default)

* Postgres: `localhost:5432` user/pass `pharmalink/pharmalink`
* Redis: `localhost:6379`
* MinIO: `localhost:9000` (S3-compatible)
* MailHog: `localhost:8025`

Troubleshooting: see `/docs/ops/runbooks.md`.


