# ADR 0001: API-first for Web + Telegram

## Context
We need web + Telegram Mini App now, and native/mobile later. Scale and CDN caching are priorities.

## Decision
Build a public JSON API with Laravel Octane. React SPA and Telegram Mini App consume the same API. Admin may use Inertia or React but is not the public surface.

## Consequences
- (+) Reuse across clients, clear separation, CDN-friendly.
- (+) Can scale stateless workers more easily.
- (-) Slightly more boilerplate (CORS, tokens, versioning).
