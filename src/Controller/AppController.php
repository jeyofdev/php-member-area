<?php

    namespace jeyofdev\php\member\area\Controller;


    use jeyofdev\php\member\area\Router\Router;


    /**
     * Initialize the controller of the url called
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    class AppController
    {
        /**
         * @var AppController
         */
        private static $_instance;



        /**
         * The corresponding controller of the url called
         *
         * @var string
         */
        private $controller;



        /**
         * The corresponding action on the url called
         *
         * @var string
         */
        private $action;



        /**
         * Singleton of the class AppController
         *
         * @return AppController
         */
        public static function getInstance() : AppController
        {
            if (is_null(self::$_instance)) {
                self::$_instance = new AppController();
            }

            return self::$_instance;
        }



        /**
         * Execute the action of the controller corresponding to the url called
         *
         * @return void
         */
        public function run (Router $router) : void
        {
            $match = $router->getRouter()->match();

            $this->setController($match);
            $this->setAction($match);

            $controller = new $this->controller();
            $method = $this->action;
            $controller->$method();
        }



        /**
         * Set the controller of the url called
         *
         * @return self
         */
        public function setController (array $match) : self
        {
            $target = str_replace('/', '.', $match["target"]);
            $page = explode('.', $target);
            
            $this->controller = '\jeyofdev\php\member\area\Controller\\' . ucfirst($page[0]) . 'Controller';

            return $this;
        }



        /**
         * Set the action of the url called
         *
         * @param array $match
         * @return self
         */
        public function setAction (array $match) : self
        {
            $target = str_replace('/', '.', $match["target"]);  // 'home.index';
            $page = explode('.', $target);
            
            $this->action = $page[1];

            return $this;
        }
    }