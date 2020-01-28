<?php

    namespace jeyofdev\php\member\area\Auth;


    use jeyofdev\php\member\area\App;
    use jeyofdev\php\member\area\Form\Validator\LoginValidator;
    use jeyofdev\php\member\area\Router\Router;
    use jeyofdev\php\member\area\Session\Session;


    /**
     * Connect a user
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    class Connect extends AbstractAuth
    {
        /**
         * @var LoginValidator
         */
        private $validator;



        /**
         * @param Session $session
         * @param Router $router
         */
        public function __construct (Session $session, Router $router)
        {
            parent::__construct($session, $router);

            $this->validator = new LoginValidator("en", $_POST, $this->repository);
        }



        /**
         * Log in
         *
         * @return void
         */
        public function login () : void
        {
            if ($this->validator->isSubmit()) {
                if ($this->validator->isValid()) {
                    // get the user
                    $user = $this->repository->findOneBy(["username" => $_POST["username"]]);

                    // check if the user exist
                    if (!is_null($user) && !is_null($user->getConfirmed_at()) && password_verify($_POST['password'], $user->getPassword())) {
                        // session
                        $this->session->setFlash("Welcome " . $user->getUsername() . ", you are connected to your account.", "success", "my-5");
                        $this->session->write("auth", $user);

                        // redirect the user
                        App::redirect(301, $this->router, "account");
                    } else {
                        $this->session->setFlash("Incorrect username or password.", "danger", "my-5");
                    }
                } else {
                    $this->errors = $this->validator->getErrors();
                    $this->errors["form"] = true;
                }
            }

            // flash message
            $this->setFormErrorMessage("The form contains errors");
        }



        /**
         * Log out
         *
         * @return void
         */
        public function logout () : void
        {
            $this->session->setFlash("You are now disconnected.", "success", "my-5");
            $this->session->destroy("auth");

            // redirect the user
            App::redirect(301, $this->router, "login");
        }
    }

