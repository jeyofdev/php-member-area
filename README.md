# Create a member management system





### Tools

Check that the latest version of [Nodejs](https://nodejs.org/en/download/) is installed :
```sh
$ node -v
```

Check that the latest version of [Yarn](https://yarnpkg.com/en/docs/install) is installed :
```sh
$ yarn -v
```

Check that the latest version of [Composer](https://getcomposer.org/download/) is installed :
```sh
$ composer -v
```




### Install all dependencies

```sh
$ yarn install
$ composer install
```



### Run webpack in dev mode

```sh
$ yarn run dev
```


### Run the internal web server of php

```sh
$ php -S localhost:8000 -t public
```


### Create the database with [Doctrine](https://www.doctrine-project.org/)

Create the database :
```php
// config/database.php
$database = new Database("host", "username", "password", "database-name");
$database->create();
```
```sh
$ php -S localhost:8000 -t config
$ #http://localhost:8000/database.php
```

Configure doctrine :
```php
// config/doctrine.php

...
// database configuration parameters
$conn = array(
    'driver'   => 'pdo_mysql',
    'host'     => 'host',
    'charset'  => 'utf8',
    'user'     => 'username',
    'password' => 'password',
    'dbname'   => 'database-name'
);
...
```

Add the tables to the database :
```sh
$ vendor/bin/doctrine orm:schema-tool:update --force
```

Check that the database is correctly synchronized :
```sh
$ vendor/bin/doctrine orm:validate-schema
```




### Configure mail sending
```php
// config/mail.php

$mailConfig = [
    'host'       => 'your email host',  // ex: smtp-mail.outlook.com
    'username'   => 'your email address',
    'password'   => 'your password',
    'port'       => 587
];
```