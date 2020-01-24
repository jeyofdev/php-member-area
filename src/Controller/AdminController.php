<?php

    namespace jeyofdev\php\member\area\Controller;


    use jeyofdev\php\member\area\App;


    class AdminController extends AbstractController
    {
        public function account () : void
        {
            // flash message
            $flash = $this->session->generateFlash();

            $title = App::getInstance()->setTitle("Account")->getTitle();
            $bodyClass = strtolower($title);

            $this->render('admin.account', $this->router, $this->session, compact('title', 'bodyClass', 'flash'));
        }
    }