# Rebuild propel
php app/console propel:database:drop --force
php app/console propel:database:create
php app/console propel:build
php app/console propel:insert-sql --force

php app/console propel:fixtures:load --yml --dir=app/propel/fixtures
php app/console fos:user:change-password admin admin
php app/console fos:user:change-password user user
