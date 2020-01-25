<?php

    namespace jeyofdev\php\member\area\Form;


    use jeyofdev\php\member\area\Form\GenerateForm\AbstractBuilderBootstrapForm;
    use jeyofdev\php\member\area\Form\GenerateForm\FormInterface;


    /**
     * Build the reset form
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    class ResetForm extends AbstractBuilderBootstrapForm implements FormInterface
    {
        /**
         * {@inheritDoc}
         */
        public function build (string $url, string $labelSubmit, ?string $urlLink = null) : string
        {
            $this
                ->formStart($url, "post")
                ->input("password", "password", "Password :", [], ["tag" => "div"])
                ->input("password", "passwordConfirm", "Password Confirmation :", [], ["tag" => "div"])
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