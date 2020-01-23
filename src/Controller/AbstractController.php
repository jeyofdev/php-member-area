<?php

    namespace jeyofdev\php\member\area\Controller;


    use jeyofdev\php\member\area\Router\Router;
    use jeyofdev\php\member\area\Session\Session;
    use Doctrine\ORM\EntityManager;


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
         * The path of config
         * 
         * @var string
         */
        private $configPath = CONFIG_PATH;



        /**
         * @var Session
         */
        protected $session;



        /**
         * @var Router
         */
        protected $router; 



        /**
         * @var EntityManager
         */
        protected $entityManager;



        /**
         * @param Router $router
         */
        public function __construct (Router $router)
        {
            $this->session = new Session();
            $this->router = $router;

            require $this->getConfigPath() . DIRECTORY_SEPARATOR . 'doctrine.php';
            $this->entityManager = $entityManager;
        }



        /**
         * {@inheritDoc}
         */
        public function render (string $view, Router $router, Session $session, array $datas = []) : void
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



        /**
         * {@inheritDoc}
         */
        public function getConfigPath() : string
        {
            return $this->configPath;
        }
    }

