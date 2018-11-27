# CMM: Church Membership Management

A Symfony application that makes church members management easier.

## Create the Database

```sql
CREATE DATABASE church CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE DATABASE church_test CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE USER 'church_admin'@'%' IDENTIFIED BY '12345678';
CREATE USER 'church_test_admin'@'%' IDENTIFIED BY '12345678';

GRANT ALL PRIVILEGES ON church.* TO 'church_admin'@'%';
GRANT ALL PRIVILEGES ON church_test.* TO 'church_test_admin'@'%';

FLUSH PRIVILEGES;
```

## Download the vendors

```bash
composer install --ignore-platform-reqs
```

## Load fixtures and Link the assets

```bash
bin/console doctrine:fixtures:load --no-interaction
bin/console assetic:dump
bin/console assets:install --symlink
```
