<?php

    namespace jeyofdev\php\member\area;


    use jeyofdev\php\member\area\Helper\Helpers;
    use jeyofdev\php\member\area\Router\Router;


    /**
     * Global class of the App
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    class App {
        /**
         * @var App
         */
        private static $_instance;



        /**
         * The title of the current page
         * 
         * @var string
         */
        private $title;



        /**
         * Singleton of the class App
         * 
         * @return App
         */
        public static function getInstance() : App
        {
            if (is_null(self::$_instance)) {
                self::$_instance = new App();
            }

            return self::$_instance;
        }



        /**
         * Get the title of the current page
         *
         * @return string|null
         */
        public function getTitle () : ?string
        {
            return (!is_null($this->title)) ? Helpers::e($this->title) : "Home";
        }



        /**
         * Set the title of the current page
         *
         * @return self
         */
        public function setTitle (string $title, ?string $prefix = null) : self
        {
            $this->title = (!is_null($prefix)) ? "$prefix $title" : $title;
            return $this;
        }



        /**
         * Execute a redirection
         *
         * @param int $code http response code (301, 404, 200...)
         * @param Router $router
         * @param string $url The redirection route
         * @return void
         */
        public static function redirect (int $code, Router $router, string $route = "home") : void
        {
            $url = $router->url($route);

            http_response_code($code);
            header("Location: " . $url);
            exit();
        }
    }