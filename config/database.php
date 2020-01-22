<?php

    use jeyofdev\php\member\area\Database\Database;


    // Autoload
    require join(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'vendor', 'autoload.php']);


    // php errors
    $whoops = new \Whoops\Run;
    $whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();


    // initialize the database
    $database = new Database("localhost", "root", "root", "member_area");
    $database->create();