<?php
class Response{
        public $id;
        public $question_id;
        public $response_value;

        public function __construct($id, $question_id, $response_value){
            $this->id = $id;
            $this->question_id = $question_id;
            $this->response_value = $response_value;
        }

        function get_id(){
            return $this->id;
        }

        function set_id($id){
            $this->id = $id;
        }

        function get_question_id(){
            return $this->question_id;
        }

        function set_question_id($question_id){
            $this->question_id = $question_id;
        }

        function get_response_id(){
            return $this->response_value;
        }

        function set_response_id($response_id){
            $this->response_id= $response_id;
        }
    }
?>