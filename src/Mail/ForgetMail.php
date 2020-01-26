<?php

    namespace jeyofdev\php\member\area\Mail;


    use jeyofdev\php\member\area\Entity\User;


    /**
     * Manage the email concerning the forgotten password
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    class ForgetMail extends AbstractMail
    {
        /**
         * Send a mail
         *
         * @param User $user
         * @return void
         */
        public function execute (User $user) : void
        {
            // set the confirmation email
            $this->setSubject("Change your password");
            $this->setBody("In order to change your password please click on this link http://localhost:8000/reset/" . $user->getId() . "-" . $user->getReset_token());
            $this->setAltBody("In order to change your password please click on this link http://localhost:8000/reset/" . $user->getId() . "-" . $user->getReset_token());

            // send the mail
            $this
                ->config()
                ->header($user->getEmail(), $user->getUsername())
                ->content($this->getSubject(), $this->getBody(), $this->getAltBody())
                ->send();
        }
    }