<?php

namespace App\Controllers\Admin\adminCompany;

use \Core\View;
use \App\Models\User;
use \App\Models\Companies;
use \App\Models\Addresses;
use \App\Models\AdminDBs;

/**
 * Company controller
 *
 * PHP version 7.0
 */
class Company extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */

    //This Function show all the company on compaines Panel on admin side 
    public function showAction()
    {
        $getAllCompanies = Companies::getAll(); // Call to  Function in Companies Model to fetch all the company .
        View::render('administrator/companies/show.php', ['getAllCompanies' => $getAllCompanies]); //  load the view of the page . 
    }

    //this Function Fetch all the data of specific comapny that needs to be Edited 
    public function editAction()
    {
        $companyId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : ""; // get the Comapnay ID 
        $requestType = (isset($_REQUEST['type'])) ? $_REQUEST['type'] : ""; // get the type of operation you want to perform (Edit or Add ) on company. 

        if ($requestType == 'editcompany') { // Condition for edit company 
            $getAllAddress = Addresses::getAllAddress(); 
            $getAllAdminDB = AdminDBs::getAllAdminDB();
            $getCompanyDetails = Companies::getCompanyDetails($companyId);
            $query = 'select * from Companies';
            $getFreshDeskCompanies = User::executeQuery($query, 'GCS_Tickets_Portal' , 'Companies' );
        
            View::render('administrator/companies/edit.php', [
                'companyId' => $companyId,
                'getCompanyDetails' => $getCompanyDetails, 
                'getAllAddress'=> $getAllAddress,
                'getAllAdminDB'=> $getAllAdminDB,
                'getFreshDeskCompanies' =>  $getFreshDeskCompanies 
            ]);
        } else {
            $getCompanyDetails = Companies::getCompanyDetails($companyId);
            $getTotalUsers = Companies::getTotalUsers($companyId);
            $getCompanyUsers = Companies::getCompanyUsers($companyId);
            View::render('administrator/companies/edit.company.php', [
                'companyId' => $companyId,
                'getCompanyDetails' => $getCompanyDetails,
                'getTotalUsers' => $getTotalUsers,
                'getCompanyUsers' => $getCompanyUsers
            ]);
        }
    }
    //this Function allows us to Delete the companies 
    public function deleteAction()
    {
        $companyId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";

        if (isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1 && $companyId) {
            Companies::deleteCompany($companyId);
        }
        header('Location: ' . baseUrl . 'companies');
    }
    // this FUnction Basically Saves the data at DB side  that needs to be edited 
    public function updateAction()
    {
        $arr = [];
        $arrke = [];
        foreach($_REQUEST as $key => $val){ // loop to get all the posted data from form 
                if(strpos($key, 'CompanyHostName') !== false  && $val != '' ) // this condition check if this variable is preesnt in the POSTed data 
                {
                    array_push($arr, array($val));
                }
                if(strpos($key, 'DBType') !== false && $val != '')// this condition check if this variable is preesnt in the POSTed data 
                {
                    array_push($arrke, array($val));
                }  
        }
        $_REQUEST['CompanyHostName'] = json_encode($arr);  // update the posted paramter data to this json one .
        $_REQUEST['DBType'] = json_encode($arrke); // update the posted paramter data to this json one .
        $arr = [];
        $arrke = [];
        $adminDB = [];
        foreach($_REQUEST as $key => $val){
                if(strpos($key, 'CompanyDBPassField') !== false && $val != '')
                {
                    array_push($arr, array($val));
                }else if(strpos($key, 'CompanyDBPassDrop') !== false && $val != '')
                {
                    array_push($arr, array($val));
                }
                if(strpos($key, 'CompanyDBUserName') !== false && $val != '')
                {
                    array_push($arrke, array($val));
                }  
                if(strpos($key, 'AdminDbDrop') !== false && $val != '')
                {
                    array_push($adminDB, array($val));
                }
        }

        $_REQUEST['CompanyDBPass'] = json_encode($arr);
        $_REQUEST['CompanyDBUserName'] = json_encode($arrke);
        $_REQUEST['AdminDb'] = json_encode($adminDB);
        $arr = [];
        foreach($_REQUEST as $key => $val){
            if(strpos($key, 'DatsourceLinkName') !== false && $val != '')
                {
                    array_push($arr, array($val));
                }
        }
        $_REQUEST['DatsourceLinkName'] = json_encode($arr);
        if(!empty($_FILES['SFTPKeys']['name']))
        {
            $Imagename = $_FILES['SFTPKeys']['name']; 
            $ImagepathSave = $_SERVER['DOCUMENT_ROOT'].'/assets/keys/'.$Imagename;
            move_uploaded_file($_FILES['SFTPKeys']["tmp_name"],$ImagepathSave);
            $_REQUEST['SFTPKeys'] =  $_FILES['SFTPKeys']['name'];
             
        }  
        $FreshDeskCompany = (isset($_REQUEST['FreshDeskCompany'])) ? $_REQUEST['FreshDeskCompany'] : "";
      
        if ($FreshDeskCompany) {
            $FreshDeskCompany = implode(',', $FreshDeskCompany);
        }
        $_REQUEST['FreshDeskCompany'] =  $FreshDeskCompany;  
       
        Companies::updateCompany();
        header('Location: ' . baseUrl . 'companies');
    }
    // this function takes to the Add form at admin side
    public function addAction(){

        $getAllAddress = Addresses::getAllAddress(); 
        $getAllAdminDB = AdminDBs::getAllAdminDB();
       
        if (isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1) {
            View::render('administrator/companies/add.php',  [
                'getAllAddress'=> $getAllAddress,
                'getAllAdminDB'=> $getAllAdminDB
            ]);
        } else {
            header('Location: ' . baseUrl . 'companies');
        }
    }
    // this function takes to the saves the new company
    public function saveAction(){
        $arr = [];
        $arrke = [];
        foreach($_REQUEST as $key => $val){ // loop to get all the posted data from form 
            if(strpos($key, 'CompanyHostName') !== false  && $val != '' ) // this condition check if this variable is preesnt in the POSTed data 
            {
                array_push($arr, array($val));
            }
            if(strpos($key, 'DBType') !== false && $val != '')// this condition check if this variable is preesnt in the POSTed data 
            {
                array_push($arrke, array($val));
            }  
        }
        $_REQUEST['CompanyHostName'] = json_encode($arr);  // update the posted paramter data to this json one .
        $_REQUEST['DBType'] = json_encode($arrke); // update the posted paramter data to this json one .
        $arr = [];
        $arrke = [];
        $adminDB = [];
        foreach($_REQUEST as $key => $val){
            if(strpos($key, 'CompanyDBPassField') !== false && $val != '')
            {
                array_push($arr, array($val));
            }else if(strpos($key, 'CompanyDBPassDrop') !== false && $val != '')
            {
                array_push($arr, array($val));
            }
            if(strpos($key, 'CompanyDBUserName') !== false && $val != '')
            {
                array_push($arrke, array($val));
            }  
            if(strpos($key, 'AdminDbDrop') !== false && $val != '')
            {
                array_push($adminDB, array($val));
            }
        }

        $_REQUEST['CompanyDBPass'] = json_encode($arr);
        $_REQUEST['CompanyDBUserName'] = json_encode($arrke);
        $_REQUEST['AdminDb'] = json_encode($adminDB);
        $arr = [];
        foreach($_REQUEST as $key => $val){
            if(strpos($key, 'DatsourceLinkName') !== false && $val != '')
                {
                    array_push($arr, array($val));
                }
        }
        $_REQUEST['DatsourceLinkName'] = json_encode($arr);
        if(!empty($_FILES['SFTPKeys']['name']))
        {
            $Imagename = $_FILES['SFTPKeys']['name']; 
            $ImagepathSave = $_SERVER['DOCUMENT_ROOT'].'/assets/keys/'.$Imagename;
            move_uploaded_file($_FILES['SFTPKeys']["tmp_name"],$ImagepathSave);
            $_REQUEST['SFTPKeys'] =  $_FILES['SFTPKeys']['name'];
             
        } 
        Companies::addCompany();
        header('Location: ' . baseUrl . 'companies');
    }
    public function pageAction()
    {
        echo "yes";
        exit;
    }
}
