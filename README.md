# SkillBridge

SkillBridge is a university-level community skill-sharing platform. One account
can teach skills, learn from other community members, or do both. Contact details
remain private until a teacher accepts a learning request.

## Technology stack

- PHP with a simple MVC structure
- MySQL and `mysqli`
- PHP sessions
- HTML, CSS, and plain JavaScript
- XAMPP for local development

No PHP or JavaScript framework, ORM, external authentication service, or live
communication service is used.

## Core features

- Registration, login, logout, disabled-account checks, and role-based access
- User profile viewing and editing
- Teaching Skills CRUD with suggested pricing guidance
- Starter skill categories and skills
- Teacher search with skill, category, experience, location, and price filters
- Public teacher profiles without private contact information
- Skill-specific learning requests and Sent/Received request pages
- Teacher Accept/Reject actions with accepted-only contact sharing
- User dashboard and database-based notifications
- Admin dashboard, user enable/disable, category CRUD, skill CRUD, and read-only
  learning-request oversight
- Server-side validation, prepared statements, ownership checks, escaped output,
  and responsive layouts

## Folder structure

```text
assets/       CSS, JavaScript, and image assets
config/       Reusable MySQL connection
controllers/  Request handling and page coordination
database/     Database schema and starter data
helpers/      Authentication and input helpers
models/       Database queries
views/        Page templates and shared partials
index.php     Application entry point and router
```

## Local setup with XAMPP

1. Copy this project into `C:\xampp\htdocs\skillbridge`.
2. Start Apache and MySQL from the XAMPP Control Panel.
3. Open `http://localhost/phpmyadmin`.
4. Import `database/skillbridge.sql` first. It creates the `skillbridge` database
   and its six core tables.
5. Import `database/seed.sql` second. It adds 13 starter categories and 27 skills.
   The script uses `INSERT IGNORE`, so importing it again does not add duplicates.
6. Confirm `config/database.php` matches the local MySQL settings. Standard XAMPP
   uses host `localhost`, user `root`, an empty password, and database
   `skillbridge`.
7. Open `http://localhost/skillbridge/`.

## Demo data setup

Demo data is optional and is intended only for screenshots, demonstrations, and
testing. For a populated demonstration database, import the SQL files in this
order:

1. `database/skillbridge.sql`
2. `database/seed.sql`
3. `database/demo_data.sql`

The demo script adds fictional Sri Lankan users, teaching listings, learning
requests, and notifications. It is safe to import repeatedly without duplicating
those demo records.

Shared password for all demo accounts: `SkillBridge123`

- Normal user: `nimal.perera@skillbridge.test`
- Learner-only user: `piumi.abeysekara@skillbridge.test`
- Administrator: `admin.demo@skillbridge.test`
- Disabled account for admin demonstrations: `ravindu.dissanayake@skillbridge.test`

## Creating an administrator

Register a normal account first. Then run this query in phpMyAdmin, replacing the
example email with that account's email:

```sql
UPDATE users SET role = 'admin' WHERE email = 'your-email@example.com';
```

Log out and log in again. Administrators use the same `users` table and login
system; there is no separate admins table.

## Core database tables

1. `users`
2. `skill_categories`
3. `skills`
4. `teaching_skills`
5. `learning_requests`
6. `notifications`

## Scope exclusions

This core version intentionally does not include ratings, reviews, favourites,
payments, scheduling, calendars, live chat, video calling, AI features, GPS,
profile-image upload, email/push notifications, or other optional functionality.
