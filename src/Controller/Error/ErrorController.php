<?php

    namespace jeyofdev\php\member\area\Controller\Error;


    use jeyofdev\php\member\area\App;
    use jeyofdev\php\member\area\Controller\AbstractController;


    class ErrorController extends AbstractController
    {
        public function notFound () : void
        {
            header("HTTP/1.1 404 Not Found");

            // flash message
            $this->session->setFlash("The page you want to access is not found or does not exist", "danger", "my-5");
            $flash = $this->session->generateFlash();

            // url of the home page
            $url = $this->router->url("home");

            $title = App::getInstance()->setTitle("404")->getTitle();
            $bodyClass = "not-found";

            $this->render('error.404', $this->router, $this->session, compact('url', 'title', 'bodyClass'));
        }
    }

