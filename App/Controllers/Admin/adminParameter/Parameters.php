<?php

namespace App\Controllers\Admin\adminParameter;

use \Core\View;
use \App\Models\User;
use \App\Models\Parameter;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Parameters extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    // Show the parameters being set 
    public function showParameterAction()
    {

        $getAllParameter = Parameter::getAllParameter();

        View::render('administrator/parameter/show.php', ['getAllParameter' => $getAllParameter]);
    }
    // Add form for parameters 
    public function addAction(){
        if (isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1) {
            $paramId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
            if($paramId){

                $getSpecificParameter = Parameter::getParameter($paramId);
              
                View::render('administrator/parameter/add.php', ['paramDetail' => $getSpecificParameter[0]]);
            }
            else{
                View::render('administrator/parameter/add.php', []);
            }
        } else {
            header('Location: ' . baseUrl . 'parameter');
        }
    }
     // Save form for parameters 
    public function saveAction(){
        Parameter::addParameter();
        header('Location: ' . baseUrl . 'parameter');
    }
    // Delete parameters 
    public function deleteAction()
    {
        $paramId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";

        if (isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1 && $paramId) {
            Parameter::deleteParam($paramId);
        }
        header('Location: ' . baseUrl . 'parameter');
    }

    public function pageAction()
    {
        echo "yes";
        exit;
    }
}
