<?php

    namespace jeyofdev\php\member\area\Helper;


    /**
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    class Helpers
    {
        /**
         * Convert all applicable characters to HTML entities
         *
         * @return string
         */
        public static function e (string $content) : string
        {
            return htmlentities($content);
        }



        /**
         * Generate a random string with letters and numbers
         * Which are mixed and can be used several times
        * @param int  The number of characters
        * @return string
        */
        public static function str_random(int $length) : string
        {
            $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
            return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
        }
    }