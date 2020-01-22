<?php

    use jeyofdev\php\member\area\Controller\AppController;
    use jeyofdev\php\member\area\Router\Router;


    // Autoload
    require join(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'vendor', 'autoload.php']);


    // php errors
    $whoops = new \Whoops\Run;
    $whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();


    // constantes
    define("ROOT", dirname(__DIR__));
    define("DEBUG_TIME", microtime(true));
    define("VIEW_PATH", ROOT . DIRECTORY_SEPARATOR . 'views');


    // router
    $router = new Router(VIEW_PATH);
    $router
        ->get('/', 'home/index', 'home')
        ->match('/register/', 'security/auth/register', 'register');


    // controller
    AppController::getInstance()->run($router);