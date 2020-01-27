<?php

    namespace jeyofdev\php\member\area\Auth;


    use jeyofdev\php\member\area\App;
    use jeyofdev\php\member\area\Form\ResetForm;
    use jeyofdev\php\member\area\Form\Validator\ForgetValidator;
    use jeyofdev\php\member\area\Form\Validator\ResetValidator;
    use jeyofdev\php\member\area\Helper\DateHelper;
    use jeyofdev\php\member\area\Helper\Helpers;
    use jeyofdev\php\member\area\Mail\ForgetMail;
    use jeyofdev\php\member\area\Router\Router;
    use jeyofdev\php\member\area\Session\Session;


    class ResetUserPassword extends AbstractAuth
    {
        /**
         * @var ForgetValidator|ResetValidator
         */
        private $validator;



        /**
         * @var ForgetMail
         */
        private $mailer;



        /**
         * The reset form
         *
         * @var ResetForm|null
         */
        public $resetForm = null;



        /**
         * @param Session $session
         * @param Router $router
         */
        public function __construct(Session $session, Router $router)
        {
            parent::__construct($session, $router);

            $this->mailer = new ForgetMail();
        }



        /**
         * Ask to change password
         *
         * @return void
         */
        public function forget () : void
        {
            $this->validator = new ForgetValidator("en", $_POST, $this->repository);

            if ($this->validator->isSubmit()) {
                if ($this->validator->isValid()) {

                    // get the user
                    $user = $this->repository->findOneBy(["email" => $_POST["email"]]);

                    // check if the user exist
                    if (!is_null($user) && !is_null($user->getConfirmed_at())) {
                        // save the user in the database
                        $user
                            ->setReset_token(Helpers::str_random(60))
                            ->setReset_at(DateHelper::getCurrentDate());

                        $this->entityManager->persist($user);
                        $this->entityManager->flush();

                        // send the mail
                        $this->mailer->execute($user);

                        // flash message
                        $this->session->setFlash("The password reminder instructions have been emailed to you..", "success", "my-5");

                        // redirect the user
                        App::redirect(301, $this->router, "login");
                    }
                } else {
                    $this->errors = $this->validator->getErrors();
                    $this->errors["form"] = true;
                }
            }

            // flash message
            $this->setFormErrorMessage("The form contains errors");
        }



        /**
         * Change user password
         *
         * @param integer $userId
         * @param string $token
         * @return void
         */
        public function reset (int $userId, string $token) : void
        {
            // get the user
            $user = $this->repository->findOneBy(["id" => $userId, "reset_token" => $token]);

            // check if the token is valid
            if (is_null($user)) {
                $this->session->setFlash("This token is not valid", "danger", "my-5");
            } else {
                $this->validator = new ResetValidator("en", $_POST, $this->repository);

                if ($this->validator->isSubmit()) {
                    if ($this->validator->isValid()) {
                        $user
                            ->setReset_token()
                            ->setReset_at();
    
                        $this->entityManager->persist($user);
                        $this->entityManager->flush();
    
                        // session
                        $this->session->setFlash("Your password has been successfully changed", "success", "my-5");
                        $this->session->write("auth", $user);
    
                        // redirect the user
                        App::redirect(301, $this->router, "account");
                    } else {
                        $this->errors = $this->validator->getErrors();
                        $this->errors["form"] = true;
                    }
                }
    
                // form
                $this->resetForm = new ResetForm($_POST, $this->errors);
            }

            // flash message
            $this->setFormErrorMessage("The form contains errors");
        }



        /**
         * Get the reset form
         *
         * @return  ResetForm|null
         */ 
        public function getResetForm() : ?ResetForm
        {
            return $this->resetForm;
        }
    }