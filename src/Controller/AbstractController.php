<?php

    namespace jeyofdev\php\member\area\Controller;


    use jeyofdev\php\member\area\Router\Router;


    /**
     * Manage the controllers
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    abstract class AbstractController implements ControllerInterface
    {
        /**
         * The path of views
         * 
         * @var string
         */
        private $viewPath = VIEW_PATH;



        /**
         * @param Router $router
         */
        public function __construct (Router $router)
        {
            $this->router = $router;
        }



        /**
         * {@inheritDoc}
         */
        public function render (string $view, Router $router, array $datas = []) : void
        {
            ob_start();
            extract($datas);
            require $this->getViewPath() . DIRECTORY_SEPARATOR . str_replace(".", "/", $view) . '.php';
            $content = ob_get_clean();
            require $this->getViewPath() . DIRECTORY_SEPARATOR . 'layout/default.php';
        }



        /**
         * {@inheritDoc}
         */
        public function getViewPath() : string
        {
            return $this->viewPath;
        }
    }

