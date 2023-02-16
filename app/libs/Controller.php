<?php
/*
* Basic parent controller loads the views and models 
*/

/**
 * Parent controller for all controllers
 */
class Controller
{

    /**
     * Load model from app root, for future accessing
     * @param $model
     * @return mixed
     */
    public function model($model)
    {
        // Require model file 
        require_once '../app/models/' . $model . '.php';

        // Instantiate model
        return new $model();
    }

    /**
     * Load a view from app root
     * @param $view
     * @param $data
     * @return void
     */
    public function view($view, $data = [])
    {
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            die('View does not exist');
        }
    }
}
