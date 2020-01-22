<?php

    namespace jeyofdev\php\member\area\Form\Validator;


    /**
     * Validation of the registration form
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    
    class RegisterValidator extends AbstractValidator
    {
        public function __construct(string $lang, array $datas)
        {
            parent::__construct($datas);

            $this->validator::lang($lang);

            $this->validator->rule("required", ["username", "email", "password", "passwordConfirm"]);
            $this->validator->rule("lengthBetween", "username", 5, 100);
            $this->validator->rule("lengthBetween", ["password", "passwordConfirm"], 5, 255);
        }
    }