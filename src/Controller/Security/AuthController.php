<?php

    namespace jeyofdev\php\member\area\Controller\Security;


    use jeyofdev\php\member\area\App;
    use jeyofdev\php\member\area\Auth\Connect;
    use jeyofdev\php\member\area\Auth\ResetUserPassword;
    use jeyofdev\php\member\area\Controller\AbstractController;
    use jeyofdev\php\member\area\Form\ForgetForm;
    use jeyofdev\php\member\area\Form\LoginForm;


    /**
     * Controller that manages user login
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    class AuthController extends AbstractController
    {
        /**
         * Manage a user's connection
         *
         * @author jeyofdev <jgregoire.pro@gmail.com>
         */
        public function login () : void
        {
            // Redirect if user is logged in
            if($this->session->exist('auth')) {
                App::redirect(301, $this->router, "account");
            }

            // connect a user
            $login = new Connect($this->session, $this->router);
            $login->login();

            // form
            $form = new LoginForm($_POST, $login->getErrors(), $this->router);

            // url of the current page
            $url = $this->router->url("login");

            // flash message
            $flash = $this->session->generateFlash();

            $title = App::getInstance()->setTitle("Login")->getTitle();
            $bodyClass = strtolower($title);


            $this->render('security/auth/login', $this->router, $this->session, compact('form', 'url', 'title', 'bodyClass', 'flash'));
        }



        /**
         * Manage the disconnection
         *
         * @author jeyofdev <jgregoire.pro@gmail.com>
         */
        public function logout () : void
        {
            // logout a user
            $login = new Connect($this->session, $this->router);
            $login->logout();
        }
    }