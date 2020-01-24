<?php

    namespace jeyofdev\php\member\area\Form\Validator;


    /**
     * Validation of the forget form
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    
    class ForgetValidator extends AbstractValidator
    {
        public function __construct(string $lang, array $datas)
        {
            parent::__construct($datas);

            $this->validator::lang($lang);

            $this->validator->rule("required", "email");
            $this->validator->rule("email", "email");
        }
    }