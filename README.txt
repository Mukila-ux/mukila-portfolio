MUKILA M PORTFOLIO - XAMPP SETUP

1. Copy this folder to:
   C:\xampp\htdocs\portfolio

2. Start Apache and MySQL in XAMPP.

3. Open:
   http://localhost/phpmyadmin

4. Import database.sql.
   It creates database: portfolio_db
   and table: messages

5. Open:
   http://localhost/portfolio/

6. Test Contact form.
   Submitted messages are stored in MySQL.

7. To view stored messages:
   http://localhost/portfolio/messages.php

LOCAL DATABASE SETTINGS:
Host: localhost
Username: root
Password: (blank)
Database: portfolio_db

If your XAMPP MySQL root account has a password, edit db.php.
