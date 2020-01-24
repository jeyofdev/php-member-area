<?php

    namespace jeyofdev\php\member\area\Form\Validator;


    use jeyofdev\php\member\area\Repository\UserRepository;


    /**
     * Validation of the forget form
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    
    class ForgetValidator extends AbstractValidator
    {
        public function __construct(string $lang, array $datas, UserRepository $userRepository)
        {
            parent::__construct($datas);

            $this->validator::lang($lang);

            $this->validator->rule("required", "email");
            $this->validator->rule("email", "email");
            $this->validator->rule(function ($field, $value) use ($userRepository) {
                $params = [$field => $value];
                return $userRepository->findBy($params);
            }, "email", "No account matches this email");
        }
    }