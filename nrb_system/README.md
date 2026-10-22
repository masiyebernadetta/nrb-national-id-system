# NRB National ID Registration System

**Course:** CIS-DMS-421 Database Management Systems
**Student:** BERNADETTA MASIYE - MSE/21/SS/025

## Requirements
- XAMPP (Apache & MySQL)
- Web Browser

## Installation & Setup
1. Place the `nrb_system` folder inside your XAMPP `htdocs` directory (e.g., `C:\xampp\htdocs\nrb_system`).
2. Open XAMPP Control Panel and start **Apache** and **MySQL**.
3. Open phpMyAdmin (http://localhost/phpmyadmin).
4. Create a database named `nrb_national_id`.
5. Import the `nrb_national_id.sql` file (included in submission) into the database.
6. Ensure your XAMPP MySQL user is `root` with no password (default XAMPP settings). If you have a password, update `config/db.php`.
7. Open your browser and go to: `http://localhost/nrb_system/public/index.php`

## Features Implemented
- Secure PDO database connection.
- Applicant registration with server-side validation.
- Applicant listing, search, and JOIN queries.
- View, edit, and safe deletion of records.
- National ID card issuance with transaction handling and duplicate constraint checking.
- XSS protection using `htmlspecialchars()`.