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

## Important

CMM suffers from the [Symfony Issue #29347](https://github.com/symfony/symfony/issues/29347), and won't execute properly if you have the PHP OPCache extension enabled.

Since, at least in Ubuntu and Linux Mint, the `php7.2-opcache` package is required by the `libapache2-mod-php7.2` package, the simplest workaround is to edit the `/etc/php/7.2/mods-available/opcache.ini` file and add the line below:

```bash
opcache.enable=0
```
