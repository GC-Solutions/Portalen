<?php

namespace App\Controllers\DataTableDesign;

use MongoDB;
use \Core\View;

use \App\Models\Placeholder;

use App\Models\DataTableDesigns;

/**
 * DataTableDesign controller
 *
 * PHP version 7.0
 */
// This file conatin all the function for Adding the width to datatbale column . it has the function that are used at the admin side to defin them .

class DataTableDesign extends \Core\Controller
{

	//Show all Filter width 
	public function showdataTableDesign(){
		$getAllFilter = DataTableDesigns::getAllFilter();
        View::render('administrator/datatableDesign/show.php', ['getAllFilter' => $getAllFilter]);
	}

	//Delete FIlter from Admin Side
	public function deleteAction()
  	{
      $filterId = (isset($_REQUEST['ID'])) ? $_REQUEST['ID'] : "";
      if ($filterId) {
        DataTableDesigns::deleteFilter($filterId);
      }
      header('Location: ' . baseUrl . 'dataTableDesign');
  	}
  	// Add and Edit FIlter
  	public function addFilterWidthAction(){
        if (isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1) {
            $filterId = (isset($_REQUEST['ID'])) ? $_REQUEST['ID'] : "";
            
            if($filterId){

            
                $getSpecificDetail = DataTableDesigns::getFilter($filterId);
              	
              
                View::render('administrator/datatableDesign/add.php', ['filterDetail' => $getSpecificDetail[0]  ]);
            }
            else{

              View::render('administrator/datatableDesign/add.php', ['' => '' ]);
            }
        } else {
            header('Location: ' . baseUrl . 'dataTableDesign');
        }
  	}
  	// Save ApI
  	public function saveFilterWidthAction(){
    	
        DataTableDesigns::saveFilter();
        header('Location: ' . baseUrl . 'dataTableDesign');
    }

}