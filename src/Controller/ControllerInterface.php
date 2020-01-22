<?php

    namespace jeyofdev\php\member\area\Controller;


    /**
     * Manage the controllers
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    interface ControllerInterface
    {
        /**
         * Send the datas to the view
         *
         * @return void
         */
        public function render (string $view, array $datas = []);



        /**
         * Get the path of views
         *
         * @return string
         */
        public function getViewPath();
    }