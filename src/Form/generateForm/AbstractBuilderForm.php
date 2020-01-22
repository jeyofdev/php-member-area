<?php

    namespace jeyofdev\php\member\area\Form\GenerateForm;


    use jeyofdev\php\member\area\Exception\NotAllowedException;


    /**
     * Set the elements of the form
     * 
     * @author jeyofdev <jgregoire.pro@gmail.com>
     */
    abstract class AbstractBuilderForm implements BuilderFormInterface
    {
        /**
         * The form elements
         *
         * @var array
         */
        protected $form;



        /**
         * The allowed values ​​of the 'method' attribute in the form tag
         */
        const METHOD_ALLOWED = ["get", "post"];



        /**
         * The type of button allowed
         */
        const BUTTON_TYPE_ALLOWED = ["submit", "reset"];



        /**
         * The type of input allowed
         */
        const INPUT_TYPE_ALLOWED = ["text", "password", "checkbox", "radio", "file", "hidden"];



        /**
         * The authorized Boolean attributes
         */
        const ATTRIBUTE_BOOL_ALLOWED = ["autofocus", "disabled", "readonly", "required", "multiple"];



        /**
         * {@inheritDoc}
         */
        public function formStart (string $action = "#", string $method = "post", ?string $class = null, ?string $id = null)
        {
            $method = strtolower($method);
            $this->checkValueIsInArray($method, self::METHOD_ALLOWED, "method");

            $class = !is_null($class) ? ' class="' . $class . '"' : null;
            $id = !is_null($id) ? ' id="' . $id . '"' : null;

            $start = '<form action="' . $action . '" method="' . $method . '"' . $class . $id . '>';
            $this->form["start"] = $start;

            return $this;
        }



        /**
         * {@inheritDoc}
         */
        public function formEnd ()
        {
            $this->form["end"] = "</form>";
            return $this;
        }



        /**
         * {@inheritDoc}
         */
        public function input (string $type, string $name, ?string $label, array $options, array $surround = [])
        {
            $type = strtolower($type);
            $this->checkValueIsInArray($type, self::INPUT_TYPE_ALLOWED, "type");

            $class = array_key_exists("class", $options) ? $this->getClass($name, $options["class"]) : $this->getClass($name);
            $options = $this->getOptions($options);

            $input = '<label for="' . $name . '">' . $label . '</label>';
            $input .= '<input type="' . $type . '" class="' . $class . '" id="' . $name . '" name="' . $name . '" ' . $options . '>';

            $input = $this->generateFormElement($input, $surround);

            $this->form["fields"][$name] = $input;

            return $this;
        }



        /**
         * {@inheritDoc}
         */
        public function submit (string $label, ?string $class = null)
        {
            return $this->button("submit", $label, $class);
        }



        /**
         * {@inheritDoc}
         */
        public function reset (string $label, ?string $class = null)
        {
            return $this->button("reset", $label, $class);
        }



        /**
         * Set the buttons
         *
         * @return self
         */
        private function button (string $type = "submit", string $label, ?string $class = null) : self
        {
            $type = strtolower($type);
            $this->checkValueIsInArray($type, self::BUTTON_TYPE_ALLOWED, "type");

            $class = !is_null($class) ? ' class="' . $class . '"' : null;

            $button = '<button type="' . $type . '"' . $class . '>' . $label . '</button>';
            $this->form["buttons"][$type] = $button;

            return $this;
        }



        /**
         * Generate the form elements with an optional surround
         *
         * @return string
         */
        private function generateFormElement (string $field, array $surround = []) : string
        {
            if (!empty($surround)) {
                $surroundTag = $surround['tag'];

                $item = '<' . $surroundTag . ' class="' . $surround["class"] . '">';
                $item .= $field;
                $item .= '</' . $surroundTag . '>';
            } else {
                $item = $field;
            }

            return $item;
        }



        /**
         * Get the class of a form element
         *
         * @return string|null
         */
        private function getClass (string $key, ?string $class = null) : ?string
        {
            $inputClass = $class;
            return $inputClass;
        }



        /**
         * Get the optional attributes
         *
         * @return string|null
         */
        private function getOptions (array $options) : ?string
        {
            if (!empty($options)) {
                $items = [];

                foreach ($options as $k => $v) {
                    if (!in_array($k, self::ATTRIBUTE_BOOL_ALLOWED)) {
                        $items[] = "$k = $v";
                    } else {
                        $items[] = $k;
                    }
                }
            }

            return isset($items) ? implode(" ", $items) : null;
        }



        /**
         * Check that the value of an attribute is allowed
         *
         * @return void
         */
        private function checkValueIsInArray (string $value, array $array, string $attributeName) : void
        {
            if (!in_array($value, $array)) {
                throw new NotAllowedException($value, $attributeName);
            }
        }
    }