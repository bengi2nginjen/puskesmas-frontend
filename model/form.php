<?php
class Form{
        public $id;
        public $name;
        public $date_created;
        public $created_by;
        public $description;
        public $is_active;
        public $questions;

        function __construct($id, $name, $date_created, $created_by, $description, $is_active, $questions){
            $this->id = $id;
            $this->name = $name;
            $this->date_created = $date_created;
            $this->created_by = $created_by;
            $this->description = $description;
            $this->is_active = $is_active;
            $this->questions = $questions;
        }
        
        function get_id(){
            return $this->id;
        }

        function set_id($id){
            $this->id = $id;
        }

        function get_name(){
            return $this->name;
        }

        function set_name($name){
            $this->name = $name;
        }

        function get_date_created(){
            return $this->date_created;
        }

        function set_date_created($date_created){
            $this->date_created = $date_created;
        }

        function get_created_by(){
            return $this->created_by;
        }

        function set_created_by($created_by){
            $this->created_by = $created_by;
        }

        function get_description(){
            return $this->description;
        }

        function set_description($description){
            $this->description = $description;
        }

        function get_is_active(){
            return $this->is_active;
        }

        function set_is_active($is_active){
            $this->is_active = $is_active;
        }

        function get_questions(){
            return $this->questions;
        }

        function set_questions($questions){
            $this->questions = $questions;
        }
    }
?>