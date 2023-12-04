<?php

namespace App\Controllers\Admin\adminImage;

use \Core\View;
use \App\Models\User;
use \App\Models\Companies;
use \App\Models\Images;
/**
 * Home controller
 *
 * PHP version 7.0
 */
class Image extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */

   
    //This Function show all the Images of company user on admin side 
    public function showImagesAction()
    {
        $getAllImages = Images::getAllImages();
        View::render('administrator/Images/showImages.php', ['getAllImages' => $getAllImages]);
    }

    // This FUnction Saves the data at DB side for Address
    public function saveImageAction(){

        Images::saveImages();
        header('Location: ' . baseUrl . 'images');
    }

    // This FUnction  perform the Edit and Add . for Edit it bring the data to displayed that is already present and for Add it takes to the Add form .
    public function  addImagesAction(){

        if (isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1) {
            $ImageId = (isset($_REQUEST['ID'])) ? $_REQUEST['ID'] : "";
           
            if($ImageId){

                $getImages = Images::getImages($ImageId);
                //print_r($getImages);exit;
                $allCompanies =  Companies::getAll();
                View::render('administrator/Images/addImages.php', ['allCompanies' => $allCompanies , 'getImage' => $getImages]);
            }
            else{

               $allCompanies =  Companies::getAll();
               View::render('administrator/Images/addImages.php', ['allCompanies' => $allCompanies]);
            }
        } else {
            header('Location: ' . baseUrl . 'images');
        }
    }

    // This Function delete the AdminDB from Admin side
    public function deleteImagesAction()
    {
        $ImageId = (isset($_REQUEST['ID'])) ? $_REQUEST['ID'] : "";

        if (isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1 && $ImageId) {
           Images::deleteImage($ImageId);
        }
        header('Location: ' . baseUrl . 'images');
    }


}
