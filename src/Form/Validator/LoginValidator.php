<?php

    namespace jeyofdev\php\member\area\Form\Validator;


    /**
     * Validation of the registration form
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    
    class LoginValidator extends AbstractValidator
    {
        public function __construct(string $lang, array $datas)
        {
            parent::__construct($datas);

            $this->validator::lang($lang);

            $this->validator->rule("required", ["username", "password"]);
            $this->validator->rule("lengthBetween", "username", 5, 100);
            $this->validator->rule("lengthBetween", "password", 5, 255);
            $this->validator->rule('alphaNum', ["username", "password"]);
        }
    }