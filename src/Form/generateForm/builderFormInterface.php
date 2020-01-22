<?php

    namespace jeyofdev\php\member\area\Form\GenerateForm;


    /**
     * Set the elements of the form
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    interface BuilderFormInterface
    {
        /**
         * Set the opening tag of the form
         *
         * @return self
         */
        public function formStart (string $action = "#", string $method = "post", ?string $class = null, ?string $id = null);



        /**
         * Set the closing tag of the form
         *
         * @return self
         */
        public function formEnd ();



        /**
         * Set the input
         *
         * @return self
         */
        public function input (string $type, string $name, string $label, array $options, array $surround = []);



        /**
         * Set a submit button
         *
         * @return self
         */
        public function submit (string $label, ?string $class = null);



        /**
         * set a reset button
         *
         * @return self
         */
        public function reset (string $label, ?string $class = null);
    }