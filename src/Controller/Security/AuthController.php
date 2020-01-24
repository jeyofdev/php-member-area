<?php

    namespace jeyofdev\php\member\area\Controller\Security;


    use DateTime;
    use DateTimeZone;
    use jeyofdev\php\member\area\App;
    use jeyofdev\php\member\area\Controller\AbstractController;
    use jeyofdev\php\member\area\Entity\User;
    use jeyofdev\php\member\area\Form\LoginForm;
    use jeyofdev\php\member\area\Form\RegisterForm;
    use jeyofdev\php\member\area\Form\Validator\LoginValidator;
    use jeyofdev\php\member\area\Form\Validator\RegisterValidator;
    use jeyofdev\php\member\area\Helper\Helpers;
    use jeyofdev\php\member\area\Mail\Mail;


    class AuthController extends AbstractController
    {
        /**
         * Manage the user registration
         *
         * @author jeyofdev <jgregoire.pro@gmail.com>
         */
        public function register () : void
        {
            $errors = []; // form errors
            $flash = null; // flash message

            /**
             * repository of the entity 'user'
             */
            $userRepository = $this->entityManager->getRepository(User::class);

            $validator = new RegisterValidator("en", $_POST, $userRepository);
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
                    $this->session->setFlash("Congratulations, you are now registered. An email has been sent to you to confirm your account.", "success", "my-5");

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



        /**
         * Confirm user registration
         *
         * @author jeyofdev <jgregoire.pro@gmail.com>
         */
        public function confirm () : void
        {
            // url settings of the current page
            $params = $this->router->getParams();
            $userId = (int)$params["id"];
            $token = $params["token"];

            // get the current user
            $userRepository = $this->entityManager->getRepository(User::class);
            $currentUser = $userRepository->find($userId);

            if (!is_null($currentUser) && $currentUser->getConfirmation_token() === $token) {
                $timeZone = new DateTimeZone('Europe/Paris');
                $currentDate = new DateTime('now', $timeZone);

                $currentUser
                    ->setConfirmation_token()
                    ->setConfirmed_at($currentDate);

                $this->entityManager->persist($currentUser);
                $this->entityManager->flush();

                // session
                $this->session->setFlash("Your account has been validated", "success", "my-5");
                $this->session->write("auth", $currentUser);

                $url = $this->router->url("account");
                App::redirect(301, $url);
            } else {
                $this->session->setFlash("This token is no longer valid", "danger", "my-5");
                
                $url = $this->router->url("home");
                App::redirect(301, $url);
            }

            // flash message
            $flash = $this->session->generateFlash();

            $title = App::getInstance()->setTitle("Confirm")->getTitle();
            $bodyClass = strtolower($title);


            $this->render('security/auth/confirm', $this->router, $this->session, compact('title', 'bodyClass', 'flash'));
        }



        /**
         * Manage a user's connection
         *
         * @return void
         */
        public function login () : void
        {
            $errors = []; // form errors
            $flash = null; // flash message

            /**
             * repository of the entity 'user'
             */
            $userRepository = $this->entityManager->getRepository(User::class);

            $validator = new LoginValidator("en", $_POST);
            if ($validator->isSubmit()) {
                if ($validator->isValid()) {
                    $user = $userRepository->findOneBy(["username" => $_POST["username"]]);

                    // check if the user exist
                    if (!is_null($user) && !is_null($user->getConfirmed_at()) && password_verify($_POST['password'], $user->getPassword())) {
                        // session
                        $this->session->setFlash("Welcome " . $user->getUsername() . ", you are connected to your account.", "success", "my-5");
                        $this->session->write("auth", $user);

                        $url = $this->router->url("account");
                        App::redirect(301, $url);
                    } else {
                        $this->session->setFlash("Incorrect username or password.", "danger", "my-5");
                    }
                } else {
                    $errors = $validator->getErrors();
                    $errors["form"] = true;
                }
            }

            // form
            $form = new LoginForm($_POST, $errors, $this->router);

            // url of the current page
            $url = $this->router->url("login");

            // flash message
            if (array_key_exists("form", $errors)) {
                $this->session->setFlash("The form contains errors", "danger", "my-5");
            }
            $flash = $this->session->generateFlash();

            $title = App::getInstance()->setTitle("Login")->getTitle();
            $bodyClass = strtolower($title);


            $this->render('security/auth/login', $this->router, $this->session, compact('form', 'url', 'title', 'bodyClass', 'flash'));
        }



        /**
         * Manage forgotten password
         *
         * @return void
         */
        public function forget () : void
        {
            $title = App::getInstance()->setTitle("Forget")->getTitle();
            $bodyClass = strtolower($title);


            $this->render('security/auth/forget', $this->router, $this->session, compact('title', 'bodyClass'));
        }
    }