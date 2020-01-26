<?php

    namespace jeyofdev\php\member\area\Mail;



    /**
     * Manage the sending of mail
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    interface MailInterface
    {
        /**
         * Mailer configuration
         * 
         * @return self
         */
        public function config (?bool $smtpAuth = true);



        /**
         * Set the mail header
         *
         * @return self
         */
        public function header (string $receiver, ?string $fromName = null);



        /**
         * Set the content of the email
         *
         * @return self
         */
        public function content (string $subject, string $body, string $altBody, ?bool $isHTML = true);


        /**
         * send mail
         *
         * @return self
         */
        public function send ();



        /**
         * Get the path of configs
         *
         * @return string
         */
        public function getConfigPath();
    }



