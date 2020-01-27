<?php

    namespace jeyofdev\php\member\area\Auth;


    use jeyofdev\php\member\area\App;
    use jeyofdev\php\member\area\Router\Router;
    use jeyofdev\php\member\area\Session\Session;


    class Auth {
        /**
         * Check that the user is logged in
         *
         * @param Router $router
         * @param string $url The route name
         * @return void
         */
        public static function isConnect (Router $router) : void
        {
            $session = new Session();

            if (!$session->exist("auth")) {
                $session->setFlash("You are not authorized to access this page. You must log in to access it.", "danger", "my-5");

                App::redirect(301, $router, "login");
            }
        }
    }

