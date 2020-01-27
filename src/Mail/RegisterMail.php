<?php

    namespace jeyofdev\php\member\area\Mail;


    use jeyofdev\php\member\area\Entity\User;


    /**
     * Manage the e-mail concerning the registration of a new user
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    class RegisterMail extends AbstractMail
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
            $this->setSubject("Confirmation de votre compte");
            $this->setBody("Afin de valider votre compte merci de cliquer sur ce lien http://localhost:8000/register/confirm/" . $user->getId() . "-" . $user->getConfirmation_token());
            $this->setAltBody("Afin de valider votre compte merci de cliquer sur ce lien http://localhost:8000/register/confirm/" . $user->getId() . "-" . $user->getConfirmation_token());

            // send the mail
            $this
                ->config()
                ->header($user->getEmail(), $user->getUsername())
                ->content($this->getSubject(), $this->getBody(), $this->getAltBody())
                ->send();
        }
    }