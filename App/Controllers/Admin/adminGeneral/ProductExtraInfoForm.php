<?php

namespace App\Controllers\Admin\adminGeneral;

use \Core\View;
use \App\Models\User;
use \App\Models\Placeholder;
use \App\Models\Page;
use \App\Models\Companies;
use \App\Models\TablePlaceholders;
use \App\Models\MongoTable;
/**
 * Placeholders controller
 *
 * PHP version 7.0
 */
class ProductExtraInfoForm extends \Core\Controller
{

	// Function that show the form for getting the value
	public function addMongodbAction()
    {
        $id = (isset($_REQUEST['id'])) ?$_REQUEST['id']:'';
       
        if($id)
        {
               $getTableDetails = MongoTable::getMongotableByID($id);
               
               $getDataTable = TablePlaceholders::getAllDataTable();
               View::render('administrator/placeholder/add_mongodb.php', ['getDataTable' => $getDataTable , 'getTableDetails' => $getTableDetails]);
        }else{
            
            $getDataTable = TablePlaceholders::getAllDataTable();
            View::render('administrator/placeholder/add_mongodb.php', ['getDataTable' => $getDataTable]);
        }
     
    }
    // Function to create and edit  a new form for extra info 
    public function saveMongodbAction()
    {
        $saveData = $_REQUEST; //fetch all Posted data from form 
        MongoTable::addMongoTable($saveData);
        header('Location: ' . baseUrl . 'placeholders');
    }

}