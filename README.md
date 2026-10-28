# IRM Church Website

A PHP + MySQL church website starter for IRM Church, Minanga, Aparri, Cagayan.
Develop locally with Laragon, then deploy to PHP/MySQL hosting.

## Features
- Responsive public homepage
- About, ministries, events, contact sections
- Prayer request submission with private-by-default handling
- Admin login and dashboard
- Admin can review prayer requests and manage announcements
- PDO prepared statements, CSRF tokens, password hashing, output escaping
- SQL schema and sample content

## Local setup (Laragon)
1. Extract this folder into `C:\laragon\www\irm-church`.
2. Start Laragon services.
3. Create a MySQL database named `irm_church`.
4. Import `database/irm_church.sql` using HeidiSQL or phpMyAdmin.
5. Edit `config.php` with your database credentials.
6. Open `http://irm-church.test` (if Laragon auto virtual hosts are enabled), or `http://localhost/irm-church/`.
7. Create the first admin using the one-time setup page: `http://irm-church.test/setup-admin.php`.
8. After creating the admin, DELETE `setup-admin.php` from the server immediately.

## Online deployment
- Choose a free PHP + MySQL host that permits your intended use and has HTTPS.
- Create the database and import `database/irm_church.sql`.
- Upload the PHP files into the hosting web root (`public_html` or equivalent).
- Update `config.php` with the host's database name, username, password, and host.
- Visit `setup-admin.php` once to create the first admin, then delete it.
- Test prayer submission, admin access, and HTTPS before announcing the website.

## Important
- This is a starter project; it is not yet a verified production deployment.
- Do not publish real personal or sensitive prayer requests without clear consent.
- Prayer requests are private by default. Public display is not implemented in this starter.
- Back up the database regularly and use a unique strong admin password.
- Configure email only if the hosting provider supports it; this version does not send email.
- The contact information and service schedule are intentionally marked as placeholders until the church confirms them.
