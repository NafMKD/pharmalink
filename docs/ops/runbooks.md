# Runbooks

## Deploy (high level)
- Build images via GitHub Actions
- Apply K8s manifests (HPA autoscaling)
- Run migrations with `--safe` flag

## Backups
- Postgres PITR enabled; daily snapshot verification

## Incidents
- Severity matrix + on-call contacts
- Rollback procedure
