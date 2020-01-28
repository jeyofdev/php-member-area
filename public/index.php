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
    define("CONFIG_PATH", ROOT . DIRECTORY_SEPARATOR . 'config');
    define("VIEW_PATH", ROOT . DIRECTORY_SEPARATOR . 'views');


    // router
    $router = new Router(VIEW_PATH);
    $router
        ->match('/404/', 'error/404', '404')
        ->get('/', 'home/index', 'home')

        ->match('/login/', 'security/auth/login', 'login')
        ->match('/logout/', 'security/auth/logout', 'logout')

        ->match('/user/register/', 'security/register/index', 'register')
        ->match('/user/register/confirm/[i:id]-[*:token]/', 'security/register/confirm', 'register_confirm')

        ->match('/user/password/new/', 'security/password/new', 'password_new')
        ->match('/user/password/update/[i:id]-[*:token]/', 'security/password/update', 'password_update')

        ->get('/account/', 'admin/account', 'account');


    // controller
    AppController::getInstance()->run($router);