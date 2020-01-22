<?php

    namespace jeyofdev\php\member\area\Controller\Security;


    use jeyofdev\php\member\area\App;
    use jeyofdev\php\member\area\Controller\AbstractController;


    class AuthController extends AbstractController
    {
        /**
         * Manage the controller linked to authentication
         *
         * @author jeyofdev <jgregoire.pro@gmail.com>
         */
        public function register () : void
        {
            $title = App::getInstance()->setTitle("Register")->getTitle();

            $this->render('security/auth/register', compact('title'));
        }
    }