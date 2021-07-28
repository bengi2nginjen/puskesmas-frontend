<?php
class FormResponse{
        public $id;
        public $form_id;
        public $user_id;
        public $date_created;
        public $response_value;

        public function __construct($id, $form_id, $user_id, $date_created, $user_response){
            $this->id = $id;
            $this->form_id = $form_id;
            $this->user_id = $user_id;
            $this->date_created = $date_created;
            $this->response_value = $user_response;
        }

        function get_id(){
            return $this->id;
        }

        function set_id($id){
            $this->id = $id;
        }

        function get_form_id(){
            return $this->form_id;
        }

        function set_form_id($form_id){
            $this->form_id = $form_id;
        }

        function get_user_id(){
            return $this->user_id;
        }

        function set_user_id($user_id){
            $this->user_id = $user_id;
        }

        function get_date_created(){
            return $this->date_created;
        }

        function set_date_created($date_created){
            $this->date_created = $date_created;
        }

        function get_user_response(){
            return $this->response_value;
        }

        function set_user_response($user_response){
            $this->response_value = $user_response;
        }
    }
    ?>