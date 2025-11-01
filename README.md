# Service Quality Feedback System

A web-based anonymous service evaluation platform built with PHP and PostgreSQL.

## ✅ Main Features
- Dynamic questions loaded from database
- Anonymous evaluation (no personal data collected)
- Score-based answers (0–10 or 0–5)
- Optional comment/feedback field
- Admin panel for:
  - Managing questions
  - Registering devices (tablets)
  - Viewing results and averages per sector

## 🗄️ Database (PostgreSQL)
Tables:
- `evaluations`
- `questions`
- `devices`
- `sectors`
- `admin_users`

See [`sql/database.sql`](sql/database.sql) for full setup.

## ⚙️ Installation
```bash
git clone https://github.com/marcs-sus/service-feedback-web.git
cd service-feedback-web
```
