<?php
class Question{
        public $id;
        public $question;
        public $number;
        public $description;
        public $input;

        function __construct($id, $question, $number, $description, $input ){
            $this->id = $id;
            $this->question = $question;
            $this->number = $number;
            $this->description = $description;
            $this->input = $input;
        }
        
        function get_id(){
            return $this->id;
        }

        function set_id($id){
            $this->id = $id;
        }

        function get_question(){
            return $this->question;
        }

        function set_question($question){
            $this->question = $question;
        }

        function get_number(){
            return $this->number;
        }

        function set_number($number){
            $this->number = $number;
        }

        function get_description(){
            return $this->description;
        }

        function set_description($description){
            $this->description = $description;
        }

        function get_input(){
            return $this->input;
        }

        function set_input($input){
            $this->input = $input;
        }
    }
?>