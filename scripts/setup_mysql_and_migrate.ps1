Param(
    [string]$MySqlHost = "127.0.0.1",
    [int]$MySqlPort = 3306,
    [string]$Database = "startup",
    [string]$AppUser = "appuser",
    [string]$AppPass = "TempStrongPass123!"
)

Write-Host "This script will create database '$Database' and user '$AppUser' (if missing). You will be prompted for MySQL root password."

$createSql = "CREATE DATABASE IF NOT EXISTS $Database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; CREATE USER IF NOT EXISTS '$AppUser'@'localhost' IDENTIFIED BY '$AppPass'; GRANT ALL PRIVILEGES ON $Database.* TO '$AppUser'@'localhost'; FLUSH PRIVILEGES;"

# Run mysql CLI (will prompt for root password)
Write-Host "Running MySQL commands (you will be prompted for the root password)..."
& mysql -u root -p -h $MySqlHost -P $MySqlPort -e $createSql

if ($LASTEXITCODE -ne 0) {
    Write-Error "MySQL command failed. Ensure MySQL server is running, the mysql client is installed, and you entered the correct root password."
    exit 1
}

# Update .env in project root with the MySQL settings
$envPath = Join-Path -Path (Get-Location) -ChildPath ".env"
if (Test-Path $envPath) {
    $env = Get-Content $envPath
    $env = $env -replace '^DB_CONNECTION=.*', 'DB_CONNECTION=mysql'
    $env = $env -replace '^DB_HOST=.*', 'DB_HOST=' + $MySqlHost
    $env = $env -replace '^DB_PORT=.*', 'DB_PORT=' + $MySqlPort
    $env = $env -replace '^DB_DATABASE=.*', 'DB_DATABASE=' + $Database
    $env = $env -replace '^DB_USERNAME=.*', 'DB_USERNAME=' + $AppUser
    $env = $env -replace '^DB_PASSWORD=.*', 'DB_PASSWORD=' + $AppPass
    $env | Set-Content $envPath
    Write-Host ".env updated with MySQL settings."
} else {
    Write-Warning ".env not found in current directory. Please run this script from the project root."
}

# Run artisan migration commands
Write-Host "Clearing config and cache, then running migrations..."
php artisan config:clear
php artisan cache:clear
php artisan migrate --force

if ($LASTEXITCODE -eq 0) {
    Write-Host "Migrations ran successfully."
} else {
    Write-Error "Migrations failed. Check the error messages above and fix the DB credentials or permissions."
    exit 1
}
