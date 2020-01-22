<?php

    namespace jeyofdev\php\member\area\Controller\Security;

    use jeyofdev\php\member\area\App;
    use jeyofdev\php\member\area\Controller\AbstractController;
    use jeyofdev\php\member\area\Form\RegisterForm;
    use jeyofdev\php\member\area\Form\Validator\RegisterValidator;


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

            $validator = new RegisterValidator("en", $_POST);
            if ($validator->isSubmit()) {
                if ($validator->isValid()) {
                    
                } else {
                    $errors = $validator->getErrors();
                }
            }

            dump($errors);

            // form
            $form = new RegisterForm($_POST, $errors);

            // url of the current page
            $url = $this->router->url("register");

            $title = App::getInstance()->setTitle("Register")->getTitle();
            $bodyClass = strtolower($title);


            $this->render('security/auth/register', $this->router, compact('form', 'url', 'title', 'bodyClass'));
        }
    }