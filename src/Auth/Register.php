<?php

    namespace jeyofdev\php\member\area\Auth;


    use jeyofdev\php\member\area\App;
    use jeyofdev\php\member\area\Entity\User;
    use jeyofdev\php\member\area\Form\Validator\RegisterValidator;
    use jeyofdev\php\member\area\Helper\DateHelper;
    use jeyofdev\php\member\area\Helper\Helpers;
    use jeyofdev\php\member\area\Mail\RegisterMail;
    use jeyofdev\php\member\area\Router\Router;
    use jeyofdev\php\member\area\Session\Session;


    /**
     * User registration
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    class Register extends AbstractAuth
    {
        /**
         * @var RegisterValidator
         */
        private $validator;



        /**
         * @var RegisterMail
         */
        private $mailer;



        /**
         * @param Session $session
         * @param Router $router
         */
        public function __construct (Session $session, Router $router)
        {
            parent::__construct($session, $router);

            $this->validator = new RegisterValidator("en", $_POST, $this->repository);
            $this->mailer = new RegisterMail($this->router);
        }



        /**
         * New user registration
         *
         * @return void
         */
        public function add () : void
        {
            if ($this->validator->isSubmit()) {
                if ($this->validator->isValid()) {

                    // save the user in the database
                    $user = new User();
                    $user
                        ->setUsername($_POST["username"])
                        ->setEmail($_POST["email"])
                        ->setPassword($_POST["password"])
                        ->setConfirmation_token(Helpers::str_random(60));

                    $this->entityManager->persist($user);
                    $this->entityManager->flush();

                    // send the mail
                    $this->mailer->execute($user);

                    // flash message
                    $this->session->setFlash("Congratulations, you are now registered. An email has been sent to you to confirm your account.", "success", "my-5");

                    // redirect the user
                    App::redirect(301, $this->router, "home");
                } else {
                    $this->errors = $this->validator->getErrors();
                    $this->errors["form"] = true;
                }
            }

            // flash message
            $this->setFormErrorMessage("The form contains errors");
        }



        /**
         * Confirm user registration
         *
         * @param integer $userId
         * @param string $token
         * @return void
         */
        public function confirm (int $userId, string $token) : void
        {
            // get the user
            $user = $this->repository->find($userId);

            if (!is_null($user) && $user->getConfirmation_token() === $token) {
                $user
                    ->setConfirmation_token()
                    ->setConfirmed_at(DateHelper::getCurrentDate());

                $this->entityManager->persist($user);
                $this->entityManager->flush();

                // session
                $this->session->setFlash("Your account has been validated", "success", "my-5");
                $this->session->write("auth", $user);

                App::redirect(301, $this->router, "account");
            } else {
                $this->session->setFlash("This token is no longer valid", "danger", "my-5");

                App::redirect(301, $this->router, "home");
            }
        }
    }

