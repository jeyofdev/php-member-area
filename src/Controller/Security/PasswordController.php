<?php

    namespace jeyofdev\php\member\area\Controller\Security;


    use jeyofdev\php\member\area\App;
    use jeyofdev\php\member\area\Auth\ResetUserPassword;
    use jeyofdev\php\member\area\Controller\AbstractController;
    use jeyofdev\php\member\area\Form\ForgetForm;


    /**
     * Controller that manages password change
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    class PasswordController extends AbstractController
    {
        /**
         * Manage the forgotten password request
         *
         * @author jeyofdev <jgregoire.pro@gmail.com>
         */
        public function new () : void
        {
            // add a user
            $ResetUserPassword = new ResetUserPassword($this->session, $this->router);
            $ResetUserPassword->new();

            // form
            $form = new ForgetForm($_POST, $ResetUserPassword->getErrors());

            // url of the current page
            $url = $this->router->url("password_new");

            // flash message
            $flash = $this->session->generateFlash();

            $title = App::getInstance()->setTitle("Forget")->getTitle();
            $bodyClass = strtolower($title);


            $this->render('security/password/new', $this->router, $this->session, compact('form', 'url', 'title', 'bodyClass', 'flash'));
        }



        /**
         * Manage password change
         *
         * @author jeyofdev <jgregoire.pro@gmail.com>
         */
        public function update () : void
        {
            // url settings of the current page
            $params = $this->router->getParams();
            $userId = (int)$params["id"];
            $token = $params["token"];

            // change user password
            $ResetUserPassword = new ResetUserPassword($this->session, $this->router);
            $ResetUserPassword->update($userId, $token);

            // form
            $form = $ResetUserPassword->getResetForm();

            // url of the current page
            $url = $this->router->url("password_update", ["id" => $userId, "token" => $token]);

            // flash message
            $flash = $this->session->generateFlash();

            $title = App::getInstance()->setTitle("Reset")->getTitle();
            $bodyClass = strtolower($title);

            $this->render('security/password/update', $this->router, $this->session, compact('form', 'url', 'title', 'bodyClass', 'flash'));
        }
    }