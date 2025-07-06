#!/bin/sh
set -e

echo 'Waiting for MySQL to launch... '

until nc -z db 3306; do
  echo 'MySQL is unavailable...'
  sleep 1
done

echo 'MySQL ready...'

cd /var/www/html
composer install

echo 'Running migrations...'
php ./framework-core/commands/migrate.php
echo "Migrations finished."

echo 'Importing data...'
php ./framework-core/commands/importer/import.php
echo "Import finished."

echo 'Ready - please go to http://localhost:8080/'
exec "$@"