<?php

    namespace jeyofdev\php\member\area\Controller\Security;


    use jeyofdev\php\member\area\App;
    use jeyofdev\php\member\area\Controller\AbstractController;
    use jeyofdev\php\member\area\Entity\User;
    use jeyofdev\php\member\area\Form\RegisterForm;
    use jeyofdev\php\member\area\Form\Validator\RegisterValidator;
    use jeyofdev\php\member\area\Helper\Helpers;
    use jeyofdev\php\member\area\Mail\Mail;


    class AuthController extends AbstractController
    {
        /**
         * Manage the controller linked to authentication
         *
         * @author jeyofdev <jgregoire.pro@gmail.com>
         */
        public function register () : void
        {
            $errors = []; // form errors
            $flash = null; // flash message

            $validator = new RegisterValidator("en", $_POST);
            if ($validator->isSubmit()) {
                if ($validator->isValid()) {
                    // save the user in the database
                    $user = new User();
                    $user
                        ->setUsername($_POST["username"])
                        ->setEmail($_POST["email"])
                        ->setPassword($_POST["password"])
                        ->setConfirmation_token(Helpers::str_random(60));

                    $this->entityManager->persist($user);
                    $this->entityManager->flush();

                    // set the confirmation email
                    $subject = 'Confirmation de votre compte';
                    $body = "Afin de valider votre compte merci de cliquer sur ce lien http://localhost:8000/confirm/" . $user->getId() . "-" . $user->getConfirmation_token();
                    $altBody = "Afin de valider votre compte merci de cliquer sur ce lien http://localhost:8000/confirm/" . $user->getId() . "-" . $user->getConfirmation_token();

                    // send the mail
                    $mail = new Mail();
                    $mail
                        ->config()
                        ->header($user->getEmail(), $user->getUsername())
                        ->content($subject, $body, $altBody)
                        ->send();

                    // flash message
                    $this->session->setFlash("Congratulations, you are now registered", "success", "my-5");

                    // redirect the user
                    $url = $this->router->url("home");
                    App::redirect(301, $url);
                } else {
                    $errors = $validator->getErrors();
                    $errors["form"] = true;
                }
            }

            // form
            $form = new RegisterForm($_POST, $errors);

            // url of the current page
            $url = $this->router->url("register");

            // flash message
            if (array_key_exists("form", $errors)) {
                $this->session->setFlash("The form contains errors", "danger", "my-5");
            }
            $flash = $this->session->generateFlash();

            $title = App::getInstance()->setTitle("Register")->getTitle();
            $bodyClass = strtolower($title);


            $this->render('security/auth/register', $this->router, $this->session, compact('form', 'url', 'flash', 'title', 'bodyClass'));
        }
    }