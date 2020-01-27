<?php

    namespace jeyofdev\php\member\area\Helper;


    use DateTime;
    use DateTimeZone;


    /**
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    class DateHelper
    {
        /**
         * Get the current date
         *
         * @return DateTime
         */
        public static function getCurrentDate () : DateTime
        {
            $timeZone = new DateTimeZone('Europe/Paris');
            $currentDate = new DateTime('now', $timeZone);

            return $currentDate;
        }
    }

