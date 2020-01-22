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
            $this->render('home.index');
        }
    }

