<?php

namespace App\Controllers\Admin\adminAddress;

use \Core\View;
use \App\Models\User;
use \App\Models\Companies;
use \App\Models\Addresses;
/**
 * Address controller
 *
 * PHP version 7.0
 */
class Address extends \Core\Controller
{
    //This Function show all the External Address(fortnox etc) on Addres Panel on admin side 
    public function showAddressAction()
    {
        $getAllAddress = Addresses::getAllAddress(); // Call to  Function in Address Model to gett all the Address .
        View::render('administrator/companies/showAddress.php', ['getAllAddress' => $getAllAddress]); //  load the view of the page . 
    }

    // This FUnction Saves the data at DB side for Address
    public function saveAddressAction(){
        Addresses::saveAddress(); // Call to  Function in Address Model to  create a new address .
        header('Location: ' . baseUrl . 'address'); // will route back to Address page .
    }

    // This FUnction  perform the Edit and Add . for Edit it bring the data to displayed that is already present and for Add it takes to the Add form .
    public function addAddressAction(){

        if (isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1) {  // this condition check if we have accesed this page as admin.
            $Addressid = (isset($_REQUEST['ID'])) ? $_REQUEST['ID'] : ""; 
           
            if($Addressid){ // this condition when we open address form for edit
                $getAddress = Addresses::getAddress($Addressid);
                View::render('administrator/companies/addEditAddress.php', ['getAddress' => $getAddress]);
            }
            else{
                View::render('administrator/companies/addEditAddress.php', ['']);
            }
        } else {
            header('Location: ' . baseUrl . 'address');
        }
    }

    // This Function delete the Address from Admin side
    public function deleteAddressAction()
    {
        $addressId = (isset($_REQUEST['ID'])) ? $_REQUEST['ID'] : ""; 

        if (isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1 && $addressId) { // this condition check if we have accesed this page as admin and check if we have the id of the adress page that we need to delete.
            Addresses::deleteAddress($addressId);
        }
        header('Location: ' . baseUrl . 'address');
    }


}
