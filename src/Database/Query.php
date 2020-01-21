<?php

    namespace jeyofdev\php\member\area\Database;


    use PDO;


    /**
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    Class Query
    {
        /**
         * Set a query and execute it
         *
         * @return void
         */
        public static function prepareAndExecute (PDO $connection, string $query, ?string $message = null) : void
        {
            $connection->prepare($query)->execute();

            if (!is_null($message)) {
                echo $message;
            }
        }
    }