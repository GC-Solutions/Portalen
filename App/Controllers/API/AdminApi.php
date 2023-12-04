<?php

namespace App\Controllers\API;

use MongoDB;
use \Core\View;
use \App\Models\Apis;
use \App\Models\Placeholder;
use \App\Models\Page;
use \App\Models\User;
use \App\Models\Companies;
use \App\Models\Execute;
use App\Controllers\DataFormatHelper\DataTableHelper;
use \App\Models\DataSources;
use \App\Models\TablePlaceholders;
use \App\Models\Products;
/**
 * AdminApi controller
 *
 * PHP version 7.0
 */
// This File contain all the function when we create an API at Admin side .

class AdminApi extends \Core\Controller
{

	//Show all Api 
	public function showAllAPI(){
		$getAllAPI = Apis::getAllAPI();
        View::render('administrator/API/show.php', ['getAllApi' => $getAllAPI]);
	}

	//Delete API from Admin Side
	public function deleteAction()
  	{
      $APIId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
      if ($APIId) {
          Apis::deleteAPI($APIId);
      }
      header('Location: ' . baseUrl . 'api');
  	}
  	// Add and Edit Api 
  	public function addApiAction(){
        if (isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1) {
            $APIid = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
            
            if($APIid){

            	$getAllTableActions = Placeholder::getAllTableData("TableActions");
                $getSpecificDetail = Apis::getAPI($APIid);
              	$getDataTable = TablePlaceholders::getAllDataTable();
                $getDataSource = DataSources::getAllDataSource();
                $getAllAPI = Apis::getAllAPI();
              
                View::render('administrator/API/add.php', ['APIDetail' => $getSpecificDetail[0] , 'getDataTable' => $getDataTable , 'getAllTableActions' => $getAllTableActions , 'getDataSource' => $getDataSource , 'getAllAPI' => $getAllAPI]);
            }
            else{

            	$getAllTableActions = Placeholder::getAllTableData("TableActions");
            	$getDataTable = TablePlaceholders::getAllDataTable();
                $getDataSource = DataSources::getAllDataSource();
                $getAllAPI = Apis::getAllAPI();
              
              View::render('administrator/API/add.php', ['getDataTable' => $getDataTable , 'getAllTableActions' => $getAllTableActions, 'getDataSource' => $getDataSource , 'getAllAPI' => $getAllAPI]);
            }
        } else {
            header('Location: ' . baseUrl . 'api');
        }
  	}
  	// Save ApI
  	public function saveApiAction(){
    	$Fields = (isset($_REQUEST['Fields'])) ? $_REQUEST['Fields'] : "";

        if ($Fields) {
            $Fields = implode(',', $Fields);
        }
        $params = (isset($_REQUEST['parameterFocusPage'])) ? $_REQUEST['parameterFocusPage'] : "";

        if ($params) {
            $params = implode(',', $params);
        }
        $PlaceholderActionIds = (isset($_REQUEST['PlaceholderActionIds'])) ? $_REQUEST['PlaceholderActionIds'] : "";

        if ($PlaceholderActionIds) {
            $PlaceholderActionIds = implode(',', $PlaceholderActionIds);
        }
    	$_REQUEST['Fields'] = $Fields;
    	$_REQUEST['parameterFocusPage'] = $params;
    	$_REQUEST['PlaceholderActionIds'] = $PlaceholderActionIds;
    	
        Apis::addAPI();
        header('Location: ' . baseUrl . 'api');
    }

}