# Auth changes: Phone & Telegram

- Emails are not used as account keys.
- Phone number (E.164) is primary. OTP-based authentication is used (no passwords).
- Telegram username can be linked, but linking requires proof (bot message, signature, or prior phone OTP).
- Endpoints updated: /auth/login-otp, /auth/verify-otp, /auth/telegram/link, /auth/telegram/login.

See `docs/api/openapi.yaml` for the updated contract.
