<?php

    namespace jeyofdev\php\member\area\Form;


    use jeyofdev\php\member\area\Form\GenerateForm\AbstractBuilderBootstrapForm;
    use jeyofdev\php\member\area\Form\GenerateForm\FormInterface;
    use jeyofdev\php\member\area\Router\Router;


    /**
     * Build the login form
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    class LoginForm extends AbstractBuilderBootstrapForm implements FormInterface
    {
        /**
         * @var Router
         */
        protected $router; 



        /**
         * @param Router $router
         */
        public function __construct ($datas, array $errors, Router $router)
        {
            parent::__construct($datas, $errors);
            $this->router = $router;
        }



        /**
         * {@inheritDoc}
         */
        public function build (string $url, string $labelSubmit, ?string $urlLink = null) : string
        {
            $urlForget = $this->router->url($urlLink);

            $this
                ->formStart($url, "post")
                ->input("text", "username", "Username :", [], ["tag" => "div"])
                ->input("password", "password", 'Password : <a href="' . $urlForget . '">(I forgot my password)</a>', [], ["tag" => "div"])
                ->checkbox("remember", "Remember me", "form-check-label", "1", [], ["tag" => "div"])
                ->submit($labelSubmit, "btn btn-light")
                ->formEnd();

            return implode("\n", $this->extract());
        }



        /**
         * {@inheritDoc}
         */
        public function extract () : array
        {
            extract($this->form);

            $buttons = implode("\n", $buttons);
            $fields = implode("\n", $fields);

            $this->form = [
                "start" => $start,
                "fields" => $fields,
                "buttons" => $buttons,
                "end" => $end,
            ];

            return $this->form;
        }
    }