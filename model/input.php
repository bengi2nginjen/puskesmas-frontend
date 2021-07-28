<?php
class Input{
        public $id;
        public $input_text;
        public $input_type;

        function __construct($id, $input_text, $input_type){
            $this->id = $id;
            $this->input_text = $input_text;
            $this->input_type = $input_type;
        }

        function get_id(){
            return $this->id;
        }

        function set_id($id){
            $this->id = $id;
        }

        function get_input_text(){
            return $this->input_text;
        }

        function set_input_text($input_text){
            $this->input_text = $input_text;
        }

        function get_input_type(){
            return $this->input_type;
        }

        function set_input_type($input_type){
            $this->input_type = $input_type;
        }

    }

    abstract class InputType{
        const Text = 0;
        const Number = 1;
        const Select = 2;
        const Radiobutton = 3;
        const Checkbox = 4;
        const Date = 5;
    }
?>