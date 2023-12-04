<?php

namespace App\Controllers\Admin\adminDB;

use \Core\View;
use \App\Models\User;
use \App\Models\Companies;
use \App\Models\AdminDBs;
/**
 * AdminDB controller
 *
 * PHP version 7.0
 */
class AdminDB extends \Core\Controller
{
    //This Function show all the Admin DB on admin side 
    public function showAdminDBAction()
    {
        $getAllAdminDB = AdminDBs::getAllAdminDB();
        View::render('administrator/adminDB/showAdminDB.php', ['getAllAdminDB' => $getAllAdminDB]);
    }

    // This FUnction Saves the data at DB side for Address
    public function saveAdminDBAction(){

        AdminDBs::saveAdminDB();
        header('Location: ' . baseUrl . 'adminDB');
    }

    // This FUnction  perform the Edit and Add . for Edit it bring the data to displayed that is already present and for Add it takes to the Add form .
    public function  addAdminDBAction(){

        if (isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1) {
            $AdminDBId = (isset($_REQUEST['ID'])) ? $_REQUEST['ID'] : "";
           
            if($AdminDBId){

                $getAdminDB = AdminDBs::getAdminDB($AdminDBId);
                View::render('administrator/adminDB/addEditAdminDB.php', ['getAdminDB' => $getAdminDB]);
            }
            else{

               View::render('administrator/adminDB/addEditAdminDB.php', ['']);
            }
        } else {
            header('Location: ' . baseUrl . 'adminDB');
        }
    }

    // This Function delete the AdminDB from Admin side
    public function deleteAdminDBAction()
    {
        $addressId = (isset($_REQUEST['ID'])) ? $_REQUEST['ID'] : "";

        if (isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1 && $addressId) {
           AdminDBs::deleteAdminDB($addressId);
        }
        header('Location: ' . baseUrl . 'adminDB');
    }


}
