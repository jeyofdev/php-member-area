<?php

    namespace jeyofdev\php\member\area\Form\GenerateForm;


    /**
     * Build the form
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    interface FormInterface
    {
        /**
         * Build the form
         *
         * @return string
         */
        public function build (string $url, string $labelSubmit);



        /**
         * Extract the elements of the form
         *
         * @return array
         */
        public function extract ();
    }