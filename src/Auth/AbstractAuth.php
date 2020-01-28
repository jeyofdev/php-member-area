<?php

    namespace jeyofdev\php\member\area\Auth;


    use Doctrine\ORM\EntityManager;
    use jeyofdev\php\member\area\Entity\User;
    use jeyofdev\php\member\area\Repository\UserRepository;
    use jeyofdev\php\member\area\Router\Router;
    use jeyofdev\php\member\area\Session\Session;


    /**
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    abstract class AbstractAuth
    {
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
         * @var UserRepository
         */
        protected $repository;



        /**
         * The form errors
         *
         * @var array
         */
        public $errors = [];



        /**
         * @param Session $session
         * @param Router $router
         */
        public function __construct (Session $session, Router $router)
        {
            $this->session = $session;
            $this->router = $router;

            require $this->getConfigPath() . DIRECTORY_SEPARATOR . 'doctrine.php';
            $this->entityManager = $entityManager;

            $this->repository = $this->entityManager->getRepository(User::class);
        }



        /**
         * Get the path of config
         */
        public function getConfigPath() : string
        {
            return $this->configPath;
        }



        /**
         * Get the form errors
         *
         * @return  array
         */ 
        public function getErrors() : array
        {
            return $this->errors;
        }



        /**
         * Set form error flash message
         *
         * @param string $message
         * @return void
         */
        public function setFormErrorMessage (string $message)
        {
            if (array_key_exists("form", $this->errors)) {
                $this->session->setFlash($message, "danger", "my-5");
            }
        }
    }