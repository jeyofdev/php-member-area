<?php

    namespace jeyofdev\php\member\area\Controller;


    use jeyofdev\php\member\area\App;


    /**
     * Controller of the home page
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    class HomeController extends AbstractController
    {
        public function index () : void
        {
            $title = App::getInstance()->setTitle("Home")->getTitle();
            $bodyClass = strtolower($title);

            $this->render('home.index', $this->router, $this->session, compact('title', 'bodyClass'));
        }
    }

