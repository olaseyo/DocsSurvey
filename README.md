# docsperaSurvey

This is a light microservice built on top SLIM MVC framework.

## Installation


``` bash
Clone Repo
```

``` bash
$ composer install
```

``` bash
  Create a database called survey_template
```

``` bash
  run migration with  php vendor/bin/phinx migrate -c config-phinx.php
  Database is seeded on the fly
```

``` php
  Update the configuration file config.php in the root directory accordingly

define('DB_ADAPTER','mysql');
define('DB_NAME','survey_template');
define('DB_HOST','localhost');
define('DB_PORT',3306);
define('DB_USER','olumide');
define('DB_PASS','root');
define('DB_SOCKET','/Applications/MAMP/tmp/mysql/mysql.sock');
```

``` bash
  Start Application  with php -S localhost:8080 -t public
```

## Testing


``` php
Run Test with  ./vendor/bin/phpunit
```
##Postman Collection

https://www.getpostman.com/collections/1eaf4074a47f4d0d2ff8
