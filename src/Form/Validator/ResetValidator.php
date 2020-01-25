<?php

    namespace jeyofdev\php\member\area\Form\Validator;


    /**
     * Validation of the reset form
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    
    class ResetValidator extends AbstractValidator
    {
        public function __construct(string $lang, array $datas)
        {
            parent::__construct($datas);

            $this->validator::lang($lang);

            $this->validator->rule("required", ["password", "passwordConfirm"]);
            $this->validator->rule("lengthBetween", ["password", "passwordConfirm"], 5, 255);
            $this->validator->rule('alphaNum', ["password", "passwordConfirm"]);
            $this->validator->rule('equals', 'password', 'passwordConfirm');
        }
    }