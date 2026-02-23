DB_FKPark - Database folder for FKPark and helpers
===================================================

Why is this in FKPark?
  These PHP files are here so you can open them in your browser at
  http://localhost/FKPark/DB_FKPark/... (Apache serves files from htdocs).

What to use:
  - migrate_fresh.php  → Creates/resets the fkpark database and all its tables.
  - create_my_databases.php → Creates empty databases: classconnect, nilamfyp, personal-portfolio.
  - dbcon.php, dbh.php → Used by FKPark and other PHP pages to connect to MySQL.

Your old data (classconnect, nilamfyp):
  The old MySQL data was corrupted. MySQL cannot start with it, so we could not export it.
  Your project files (classconnect, nilamfyp) are still in c:\xampp\mysql\data_corrupt_keep
  but cannot be read without special recovery tools.
  To use your projects again: create the empty databases (create_my_databases.php),
  then run your project's migrations/setup (e.g. php artisan migrate in Laravel) to create tables.
  If you have any .sql backup from before, import it in phpMyAdmin.
