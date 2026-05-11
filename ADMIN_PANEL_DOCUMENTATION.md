# Feast Finder — Admin Panel Documentation

This document describes the admin panel features, pages, architecture and developer notes for the Feast Finder admin interface (feast-finder-admin).

## Overview

- Purpose: Manage vendors, users, orders, content and platform-wide configuration.
- Located as a separate frontend project (React / TanStack Start or Vite + React). The admin app contains standard admin pages and a set of "super-admin" tools.

## Key Pages

- /login — Admin authentication page.
- /dashboard — KPIs, charts, live orders feed, quick actions.
- /categories — Category CRUD and ordering.
- /vendors — Vendor list, status (verified, suspended), KYC link to verification page.
- /orders — Global order list with filters, status update actions, and detail view.
- /users — User list, search, ban/restore actions.
- /settings — Platform preferences and feature toggles.

### Super-Admin Tools
- /super-admin/global-config — Manage global settings and feature flags (maps to `settings` DB table).
- /super-admin/vendor-verification — Review vendor KYC (uses `vendor_verifications`).
- /super-admin/financials — View payouts, create payouts, reconcile (uses `payouts`).
- /super-admin/refunds — Process refunds (uses `refunds`).
- /super-admin/cms — Blog/CMS management.
- /super-admin/support — Support tickets and customer messages (maps to `support_tickets`).
- /super-admin/staff — Staff accounts and role assignments (`roles` + `role_user`).
- /super-admin/audit-logs — View system audit logs (`audit_logs`).

## Components & Layout

- `AdminLayout` — Global admin shell (Sidebar, TopBar, content area).
- `Sidebar` — Navigation for admin sections.
- `TopBar` — Search, notifications, admin profile menu.
- Reusable UI components: tables, filters, modals, forms.

## Auth & Context

- `AdminAuthContext` provides authentication state to the admin app, token handling and route guards.

## Backend integration (Laravel)

The backend supports admin features via the following tables (newly added for admin functionality):

- `vendor_verifications` — Stores KYC/verification requests and review status.
- `refunds` — Refund requests and processing state.
- `payouts` — Vendor payout records.
- `audit_logs` — System audit trail entries.
- `settings` — Key/value store for global configuration.
- `roles` and `role_user` — Simple role assignment for staff accounts.

## Developer Notes

- Database migrations and Eloquent models were added to the API repository to support admin features. See `database/migrations/2026_05_05_000015_*` through `000020_*` for the new migrations and `app/Models` for new models (`VendorVerification`, `Refund`, `Payout`, `AuditLog`, `Setting`, `Role`).
- Run migrations locally:
```powershell
composer dump-autoload
php artisan migrate
```

- Seeders: you already have seeders for vendors/meals/orders; extend them to create sample verification/payout/refund records if needed.

## Troubleshooting

- If the admin frontend reports duplicate imports (e.g. `StaffAccess` declared twice), open `src/App.tsx` in the admin frontend and check duplicated imports or duplicate component declarations.

## Next Improvements

- Add API controllers and resource routes to expose CRUD endpoints for the admin panel (vendors, verifications, payouts, refunds, settings, audit logs).
- Add policies and middleware to restrict super-admin routes to users with appropriate roles.
- Add admin-specific factories and seeders for verifications/payouts/refunds for development.

---

If you want, I can now scaffold API controllers and routes for these admin resources (`VendorVerificationController`, `RefundController`, `PayoutController`, `SettingController`, `AuditLogController`, `RoleController`) and wire API routes under `routes/api.php`.
