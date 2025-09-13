# Roles & Permissions

**Organizations**: Importer, Wholesaler, Supplier, Pharmacy.
**User roles** are scoped per organization.

- Supplier/Importer/Wholesaler/Pharmacy: manage listings, view org analytics, chat.
- **Salesperson**: can post on behalf of linked org(s) after approval; occupation hidden on public listings.
- Admin (platform): moderation, verification, reports.

Key rules:
- Salesperson may link to multiple orgs; each link has `pending|approved|revoked`.
- Posting “as org” requires `approved` link; system stamps `posted_by_user_id` + `org_id`.
- All actions audited.

### Account identity & platform username
User identity is phone-first. Telegram usernames may be linked and will serve as the visible `platform_username` if the user chooses. Platform usernames must be unique. Emails are not used for account identification.
