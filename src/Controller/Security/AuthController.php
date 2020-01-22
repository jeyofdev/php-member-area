<?php

    namespace jeyofdev\php\member\area\Controller\Security;

    use jeyofdev\php\member\area\App;
    use jeyofdev\php\member\area\Controller\AbstractController;
    use jeyofdev\php\member\area\Form\RegisterForm;


    class AuthController extends AbstractController
    {
        /**
         * Manage the controller linked to authentication
         *
         * @author jeyofdev <jgregoire.pro@gmail.com>
         */
        public function register () : void
        {
            $errors = []; // form errors

            // form
            $form = new RegisterForm($_POST, $errors);

            // url of the current page
            $url = '';

            $title = App::getInstance()->setTitle("Register")->getTitle();


            $this->render('security/auth/register', $this->router, compact('form', 'url', 'title'));
        }
    }