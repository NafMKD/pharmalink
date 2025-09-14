
# Database Schema – PharmaLink MVP (Final)

---

### 1. Tenants

```
- id int (pk)
- name char -- company/tenant name
- plan_id int nullable (fk → plans.id)
- status enum('active','suspended','cancelled') default 'active'
- created_at datetime
- updated_at datetime
- deleted_at datetime nullable
```

### 2. Plans (dynamic, managed by SaaS admin)

```
- id int (pk)
- name char -- e.g., 'free', 'starter', 'pro'
- description text nullable
- features json nullable
- price decimal nullable
- status enum('active','inactive') default 'active'
- created_at datetime
- updated_at datetime
- deleted_at datetime nullable
```

### 3. Saas\_admins (platform-level admins)

```
- id int (pk)
- name char
- email char unique
- password char
- phone char unique
- role enum('saas_admin')
- is_active boolean default true
- created_at datetime
- updated_at datetime
- deleted_at datetime nullable
```

---

## 4. Users (tenant-level, OTP login)

```
- id int (pk)
- tenant_id int (fk → tenants.id)
- phone char unique -- login via OTP
- role enum('importer','wholesaler','supplier','pharmacy','sales_person')
- is_active boolean default true
- email char nullable unique
- created_at datetime
- updated_at datetime
- deleted_at datetime nullable
```

## 5. Businesses

```
- id int (pk)
- tenant_id int (fk → tenants.id)
- user_id int (fk → users.id) -- owner of the business
- type enum('importer','wholesaler','supplier')
- address text nullable
- city char nullable
- contact_person char nullable
- contact_phone char nullable
- website char nullable
- is_verified boolean default false
- created_at datetime
- updated_at datetime
- deleted_at datetime nullable
```

## 6. Product Categories

```
- id int (pk)
- name char -- e.g., 'drug', 'equipment'
- description text nullable
- status enum('active','inactive') default 'active'
- created_at datetime
- updated_at datetime
- deleted_at datetime nullable
```

## 7. Products 

```
- id int (pk)
- tenant_id int (fk → tenants.id)
- business_id int (fk → businesses.id)
- posted_by int nullable (fk → users.id) -- salesperson or owner
- category_id int (fk → product_categories.id)
- name char
- brand char nullable
- unit char nullable
- price decimal
- available_quantity int nullable
- location char nullable
- description text nullable
- expiry_date date nullable -- only for drugs
- serial_number char nullable -- only for equipment
- manufacturer char nullable
- batch_number char nullable -- only for drugs
- is_active boolean default true
- is_flagged boolean default false
- created_at datetime
- updated_at datetime
- deleted_at datetime nullable
```

## 8. Salesperson Links

```
- id int (pk)
- tenant_id int (fk → tenants.id)
- salesperson_id int (fk → users.id)
- business_id int (fk → businesses.id)
- status enum('pending','approved','rejected') default 'pending'
- requested_by int nullable (fk → users.id)
- approved_by int nullable (fk → users.id)
- approved_at datetime nullable
- created_at datetime
- updated_at datetime
- deleted_at datetime nullable
```

--- 

### 9. Chats

```
- id int (pk)
- buyer_id int (fk → users.id)
- seller_id int (fk → users.id)
- product_id int nullable (fk → products.id)
- buyer_unread int default 0
- seller_unread int default 0
- last_message_preview text nullable
- last_message_at datetime nullable
- is_archived boolean default false
- created_at datetime
- updated_at datetime
- deleted_at datetime nullable
```

### 10. Messages

```
- id int (pk)
- chat_id int (fk → chats.id)
- sender_id int (fk → users.id)
- body text
- meta json nullable
- is_read boolean default false
- sent_at datetime default current
- created_at datetime
- updated_at datetime
- deleted_at datetime nullable
```

### 11. Message Attachments

```
- id int (pk)
- message_id int (fk → messages.id)
- file_path char -- storage path or URL
- file_type enum('image','document','video','other')
- file_size int nullable -- in bytes
- created_at datetime
- updated_at datetime
- deleted_at datetime nullable
```

--- 

## 12.Moderation

```
- id int (pk)
- tenant_id int (fk → tenants.id)
- type enum('post','salesperson')
- reference_id int -- fk to product or salesperson_links
- status enum('pending','approved','rejected') default 'pending'
- action_by int nullable (fk → users.id)
- action_at datetime nullable
- reason text nullable
- created_at datetime
- updated_at datetime
- deleted_at datetime nullable
```

## 13. Audit Trail

```
- id int (pk)
- tenant_id int nullable (fk → tenants.id)
- user_id int nullable (fk → users.id) -- tracks both SaaS and tenant users
- saas_admins int nullable (fk → saas_admins.id) -- tracks both SaaS and tenant users
- action enum('create','update','delete','login','approve','reject')
- auditable_type char -- e.g., 'products', 'users', 'businesses'
- auditable_id int -- record id
- old_values json nullable
- new_values json nullable
- ip_address char nullable
- user_agent text nullable
- created_at datetime
```


