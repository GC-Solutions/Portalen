<?php

namespace App\Controllers\Admin\adminTwotable;

use \Core\View;
use \App\Models\User;
use \App\Models\Placeholder;
use \App\Models\TwoTables;
use \App\Models\TablePlaceholders;
/**
 * Home controller
 *
 * PHP version 7.0
 */
class TwoTable extends \Core\Controller
{
	
	//This Function show all the 2 tables being created at the admin Side 
    public function showAllTwoTables()
    {

        $getAll2Tables = TwoTables::getAllTwoTables();
        View::render('administrator/TwoTable/showtwoTables.php', ['getAll2Tables' => $getAll2Tables]);
    }

    // This FUnction Saves the data at DB side for 2 tables
    public function saveTwoTablesAction(){
    	
    	$tempTablePageId = '';
        $tempTableId = '';
        ///print_r($_REQUEST); exit;
    	foreach ($_REQUEST as $key => $value) {
    		
    		if(strpos($key, 'TableId') !== false)
    		{
    			$id = explode('TableId', $key);
    			if(isset($id[1]) && $id[1] != '')
    			{	
    				$tempTablePageId =  $tempTablePageId .',Table_' . $id[1];
    				$tempTableId =  $tempTableId .','.$value;
    				unset($_REQUEST[$key]);
    			}else{
    				$tempTablePageId = 'Table_1';
    				$tempTableId = $value;
    				unset($_REQUEST[$key]);
    			}
    			
    		} 
    	}

    	
    	$_REQUEST['TableId']  = $tempTableId;
    	$_REQUEST['TablePageId']  = $tempTablePageId ;
        TwoTables::saveTwoTables();
        header('Location: ' . baseUrl . 'twoTable');
    }

    // This FUnction  perform the Edit and Add .For Edit it bring the data to displayed that is already present and for Add it takes to the Add form .
    public function addTwoTablesAction(){

        if (isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1) {
            $twotableId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
           
            if($twotableId){

                $getTwoTable = TwoTables::getTwoTable($twotableId);
              	$getDataTable = TablePlaceholders::getAllDataTable();
                 
                View::render('administrator/TwoTable/addEditTwoTables.php', ['twoTableDetail' => $getTwoTable[0] , 'getDataTable' => $getDataTable]);
            }
            else{
                $getDataTable = TablePlaceholders::getAllDataTable();
               
               View::render('administrator/TwoTable/addEditTwoTables.php', ['getDataTable' => $getDataTable]);
            }
        } else {
            header('Location: ' . baseUrl . 'twoTable');
        }
    }

    // This Function delete the Address from Admin side
    public function deleteTwoTablesAction()
    {
        $TableId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";

        if (isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1 && $TableId) {
            TwoTables::deleteTable($TableId);
        }
        header('Location: ' . baseUrl . 'twoTable');
    }


 

}