Setup MySQL and run Laravel migrations

What this does:
- Creates MySQL database (default `startup`) if missing
- Creates/updates app user (`appuser`) with password `TempStrongPass123!`
- Grants privileges to the app user
- Updates the project's `.env` with the MySQL settings
- Runs `php artisan config:clear`, `php artisan cache:clear`, and `php artisan migrate --force`

Requirements:
- MySQL server running locally
- `mysql` client in your PATH (so `mysql` command works)
- PHP and Composer installed, and able to run `php artisan` from project root
- Run PowerShell with sufficient privileges and from project root

How to run:
Open PowerShell in project root and execute:

```powershell
powershell -ExecutionPolicy Bypass -File .\scripts\setup_mysql_and_migrate.ps1
```

You'll be prompted for the MySQL `root` password. The script will then create the DB and user and run migrations.

If you prefer to provide custom values (host/port/db/user/password), pass them as parameters:

```powershell
powershell -ExecutionPolicy Bypass -File .\scripts\setup_mysql_and_migrate.ps1 -MySqlHost 127.0.0.1 -MySqlPort 3306 -Database startup -AppUser appuser -AppPass "YourPass123!"
```

If the script fails at the MySQL step, ensure:
- MySQL server is running
- The `mysql` client is installed and accessible
- The root password you enter is correct

If migrations fail, copy the output and share it so it can be debugged.
