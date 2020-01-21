<?php

    namespace jeyofdev\php\member\area\Database;


    /**
     * Manage the creation of the database
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    interface DatabaseInterface
    {
        /**
         * Create a database
         *
         * @return self
         */
        public function create ();



        /**
         * Drop a database
         *
         * @return self
         */
        public function drop ();
    }