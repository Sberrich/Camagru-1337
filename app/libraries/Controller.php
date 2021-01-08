<?php
    /*
    * Base Controller
    * Loads the models and views
    */
    class Controller
    {
        function __construct()
        {
           
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            if($_SERVER['REQUEST_METHOD'] == 'POST')
                foreach($_POST as $key => $val)
                {
                    if(is_array($_POST[$key]))
                        $_POST[$key] = "     ";
                }
              
            
        }
        // Load model
        public function model($model)
        {
             // Require model file
            require_once '../app/models/'.$model.'.php';
             // Instatiate model
            return new $model();
        }
        // Load view
        public function view($view, $data = [])
        {
            // Check for the view file
            if(file_exists('../app/views/'.$view.'.php')){
                require_once '../app/views/'. $view.'.php';
            }else{
                // View does not exist
                die('View Does Not Exist');
            }
        }
    }