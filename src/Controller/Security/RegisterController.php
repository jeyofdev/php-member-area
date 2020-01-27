<?php

    namespace jeyofdev\php\member\area\Controller\Security;


    use jeyofdev\php\member\area\App;
    use jeyofdev\php\member\area\Auth\Register;
    use jeyofdev\php\member\area\Controller\AbstractController;
    use jeyofdev\php\member\area\Form\RegisterForm;


    class RegisterController extends AbstractController
    {
        /**
         * Manage the user registration
         *
         * @author jeyofdev <jgregoire.pro@gmail.com>
         */
        public function index () : void
        {
            // add a user
            $register = new Register($this->session, $this->router);
            $register->add();

            // the form
            $form = new RegisterForm($_POST, $register->errors);

            // url of the current page
            $url = $this->router->url("register");

            // flash message
            $flash = $this->session->generateFlash();

            $title = App::getInstance()->setTitle("Register")->getTitle();
            $bodyClass = strtolower($title);


            $this->render('security/register/index', $this->router, $this->session, compact('form', 'url', 'flash', 'title', 'bodyClass'));
        }



        /**
         * Confirm user registration
         *
         * @author jeyofdev <jgregoire.pro@gmail.com>
         */
        public function confirm () : void
        {
            // url settings of the current page
            $params = $this->router->getParams();
            $userId = (int)$params["id"];
            $token = $params["token"];

            $register = new Register($this->session, $this->router);
            $register->confirm($userId, $token);
        }
    }