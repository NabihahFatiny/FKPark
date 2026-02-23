@echo off
title Export all MySQL databases
set MYSQL=c:\xampp\mysql\bin
set OUT=c:\xampp\mysql_backup_exports
if not exist "%OUT%" mkdir "%OUT%"

echo.
echo Exporting databases to %OUT%
echo.

set DBS=assignment2 cb23101 classconnect examplelara fkpark foodorderingsystem foodsystem fyphunting fyp_system java_users_db laravel laravel1 laravel2 laravelproject login myfirstlaravel nilamfyp orderfood profile project project_food project_login project_tiny studentinfo test testbcs1 tutorial tutoriallaravel ump vehicle wedding

for %%d in (%DBS%) do (
  echo Exporting %%d ...
  "%MYSQL%\mysqldump.exe" -u root "%%d" > "%OUT%\%%d.sql" 2>nul
  if exist "%OUT%\%%d.sql" (echo   OK - %%d.sql) else (echo   Skip or empty - %%d)
)

echo.
echo Done. SQL files are in: %OUT%
echo You can import them in phpMyAdmin after switching back to clean MySQL.
pause
