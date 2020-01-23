<?php

    namespace jeyofdev\php\member\area\Form\Validator;


    use jeyofdev\php\member\area\Repository\UserRepository;


    /**
     * Validation of the registration form
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    
    class RegisterValidator extends AbstractValidator
    {
        public function __construct(string $lang, array $datas, UserRepository $userRepository)
        {
            parent::__construct($datas);

            $this->validator::lang($lang);

            $this->validator->rule("required", ["username", "email", "password", "passwordConfirm"]);
            $this->validator->rule("lengthBetween", "username", 5, 100);
            $this->validator->rule("lengthBetween", ["password", "passwordConfirm"], 5, 255);
            $this->validator->rule('alphaNum', ["username", "password", "passwordConfirm"]);
            $this->validator->rule('email', 'email');
            $this->validator->rule('equals', 'password', 'passwordConfirm');
            $this->validator->rule(function ($field, $value) use ($userRepository) {
                $params = [$field => $value];
                return !$userRepository->findBy($params);
            }, "username", "This username is already used");
            $this->validator->rule(function ($field, $value) use ($userRepository) {
                $params = [$field => $value];
                return !$userRepository->findBy($params);
            }, "email", "This email is already used");
        }

        
    }