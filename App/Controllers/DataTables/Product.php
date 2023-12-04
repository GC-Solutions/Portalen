<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use \App\Models\Companies;
use App\Models\Placeholder;
use App\Controllers\DataFormatHelper\DataTableHelper;
use App\Models\Products;
use App\Models\MongoTable;

/**
 * Product controller
 *
 * PHP version 7.0
 */
// this is the file that is Used by the Products to add extra INfo on the table . 
class Product extends \Core\Controller
{

    // Add Extra Info for Products in MondoDB
     public function AddMoreInfoAction()
    { 
        set_time_limit(0);
        ini_set('memory_limit', '2G');
        
        $id = trim($_REQUEST['data']['TableId']);
        // get the value for table 
        $gettable  = MongoTable::getMongotable( $id );
        $productId = trim($_REQUEST['data']['ProductNo']); // productNo to fetch the data if already present in it .
       
        $formFields = json_decode($gettable[0]['DetailColumns']);
        $fields = [];
        foreach ($formFields as $key => $value) {
            $fields[$key ] = 1;
        }
        $fields['ImageId'] = 1;
        $dataMongoDb  = [];
        $dataMongoDb  = Products::getProduct($fields , $productId );
        $uploadImage = [];
        // get the Images on edit option .
        if(isset($dataMongoDb[0]->ImageId)){
            foreach ($dataMongoDb[0]->ImageId as $ImageIdkey => $ImageIdvalue) {

                $formFields = [];
                $filters = ['_id' => $ImageIdvalue];  
                $formFields['uploadImage'] = 1;
                $formFields['uploadImage_MongoDB'] = 1;
                $tableId = 'B2SBC.ImageInfo';
                $dataImage  = Products::getAllProduct($formFields , $filters , $tableId );
                $uploadImage[$ImageIdkey]['imageId']= $ImageIdvalue;
                if(isset($dataImage[0]->uploadImage)){
                    $uploadImage[$ImageIdkey]['image'] = base64_encode($dataImage[0]->uploadImage->getData()); 
                }else{
                    $uploadImage[$ImageIdkey]['image'] = base64_encode($dataImage[0]->uploadImage_MongoDB->getData()); 
                }
                
               
            }
        }
        // it conatian the value if the product has already data in it .
        $_SESSION['MainproData'] = $_REQUEST['data'] ; //Set the value for table .
        View::render('administrator/pageaccess/update_product.php', ['apiData' => json_decode($gettable[0]['DetailColumns']) , 'queryString' => $_SESSION['queryString'] , 'dataMongoDb' => $dataMongoDb , 'uploadImage' => $uploadImage ]);  
    }

    //save Data To Mongo DB 
    public function saveDataToMongoDB()
    {
        set_time_limit(0);
        ini_set('memory_limit', '2G');
        //print_r($_SESSION); exit;
        // curLos from Post to reoute back to eacat location .
        $curLoc = (isset($_REQUEST['curLoc'])) ? $_REQUEST['curLoc'] : "";
        if($_REQUEST['queryString'])
        {
            $curLoc = $curLoc . $_REQUEST['queryString'];
        }
        // get the value for table 
        foreach ($_SESSION['MainproData']  as $mdkey => $mdvalue) {
            if(!array_key_exists($mdkey, $_REQUEST))
            {
                 $_REQUEST[$mdkey] = $mdvalue;
            }
        }
        // ths part of code is incase you remove images or add multiple images .
        if(isset($_REQUEST['EditedImage']) && !empty($_REQUEST['EditedImage']))
        {
            $tempArr = [];
            $_REQUEST['EditedImage'] = json_decode($_REQUEST['EditedImage'], true);
            $EditedImage = array_filter($_REQUEST['EditedImage']);
           
            
                foreach($EditedImage  as $key =>$value){
                    $tempArr[] =  $EditedImage[$key]['imageId'];
                }
               
                $_REQUEST['imageId'] = $tempArr;
        }
        // this function baisacally bring the data if product ID is peresnt in MongoDB 
        $pro =  isset($_REQUEST['ProductNo'])? $_REQUEST['ProductNo']:0;
        $dataMongoDb  = Products::getProduct(['ProductNo' => 1 , 'ImageId' => 1] ,$pro);
     
        if($dataMongoDb)
        {
            // THis part is basically the update part .
           if($dataMongoDb == 0){
                unset($_SESSION['MainproData']);
                unset($_REQUEST['curLoc']);
                unset($_REQUEST['queryString']);
                
                $res  = Products::addProduct();
           }else{
            if($dataMongoDb[0]->ImageId)
            {
                if(!isset($_REQUEST['imageId']))
                {
                    $_REQUEST['imageIdOrg'] = $dataMongoDb[0]->ImageId;
                }
            }
            
            unset($_SESSION['MainproData']);
            unset($_REQUEST['curLoc']);
            unset($_REQUEST['queryString']);
          
            $res  = Products::UpdateProduct();
        }
        }else{
            // This Part adds a new Product .
            unset($_SESSION['MainproData']);
            unset($_REQUEST['curLoc']);
            unset($_REQUEST['queryString']);
            
            $res  = Products::addProduct();
        }
        // route back to the Location 
        header('Location: ' . $curLoc);
        exit;
    }

    // Read data form Mongo DB
    public function generateReadTableAction()
    {
        set_time_limit(0);
        ini_set('memory_limit', '2G');
        $placeholderId = (isset($_REQUEST['placeholderId'])) ? $_REQUEST['placeholderId'] : "";

        $columnNames = array();
        $arrFeild = [];
        // get data from MongoDB 
        $getPlaceholderDetails  = MongoTable::getMongotableByID($placeholderId);
        $feilds = json_decode($getPlaceholderDetails[0]['DetailColumns'] , true);
        $feilds1['ProductNo'] = '';
        $feilds = array_merge($feilds1 ,$feilds);
        $formFields = [];
        foreach ($feilds as $key => $value) {
            $formFields[$key ] = 1;
        }
        
        $formFields['ProductNo'] = 1;
        $formFields['ImageId'] = 1;

        $filters =['TableId' => $getPlaceholderDetails[0]['RelatedDataTables'] , 'ProductNo' => $_REQUEST['ProductNo']];
        $tableId = 'B2SBC.productInfo';
        $dataMongoDb  = Products::getAllProduct($formFields , $filters , $tableId);
       
        if(($dataMongoDb != 0 && count($dataMongoDb) == 1) && ($dataMongoDb[0]->ProductNo ==  $_REQUEST['ProductNo'])  ){
            foreach ($dataMongoDb[0] as $key => $value) {
                if($key != 'ImageId' &&  $key != '_id' )
                {
                    
                    $_SESSION[$key] = $dataMongoDb[0]->$key;
                }

            }    

        }else{
            $feilds['minStockStatus'] = '';
            $feilds['maxStockStatus'] = '';
            
        }
       
        if($dataMongoDb){
         
            foreach($dataMongoDb as $key => $value){
                unset($value->_id);
                if(isset($value->ImageId))
                {
                    $tableId = 'B2SBC.ImageInfo';
                    $uploadImage = '';
                   
                    foreach ($value->ImageId as $ImageIdkey => $ImageIdvalue) {
                        
                        $filters = ['_id' => $ImageIdvalue];
                        
                        $formFields['uploadImage_MongoDB'] = 1;
                        $formFields['uploadImage'] = 1;
                        $dataImage  = Products::getAllProduct($formFields , $filters , $tableId );
                        
                        if(isset($dataImage[0]->uploadImage_MongoDB)){
                            $uploadImage = $uploadImage . '<img width="50" height="60" src="data:jpeg;base64,'.base64_encode($dataImage[0]->uploadImage_MongoDB->getData()).'" /><br/>'; 
                        }else{
                            $uploadImage = $uploadImage . '<img width="50" height="60" src="data:jpeg;base64,'.base64_encode($dataImage[0]->uploadImage->getData()).'" /><br/>'; 
                       
                        }
                       
                       
                    }
                   
                    $dataMongoDb[$key]->uploadImage = $uploadImage;
                    unset($value->ImageId);
                }else{
                    $dataMongoDb[$key]->uploadImage = '';
                }
                $value1 = [];
                foreach ($feilds as $ke => $val) {
                    // if(isset($_SESSION[$ke]) && $ke != 'ProductNo' && ($value->ProductNo != $_SESSION['ProductNo']) && ( strpos($value->ProductNo, $_SESSION['ProductNo'])!== false))
                    // {
                    //     if(isset($_SESSION[$ke])){
                    //          $value1[$ke] =isset($_SESSION[$ke])?$_SESSION[$ke]:'';
                    //     }else{
                    //          $value1[$ke] =isset($value->$ke)?$value->$ke:'';
                    //     }
                    // }else{
                    //     $value1[$ke] =isset($value->$ke)?$value->$ke:'';
                        
                    // }
                    $value1[$ke] =isset($value->$ke)?$value->$ke:'';
                }
               
                $dataMongoDb[$key] = array_values(json_decode(json_encode($value1), true));
             
            }

           
            if(count($feilds) >count($dataMongoDb[0]))
            {
                 foreach($dataMongoDb as $key => $value){
                        $i = 4;
                        while($i < count($feilds))
                        {
                            array_push($dataMongoDb[$key], '');
                            $i = $i+1;
                        }
                 }

            }
        }
        $tableData['data'] = $dataMongoDb? $dataMongoDb:[];
        echo json_encode($tableData, JSON_UNESCAPED_SLASHES);
        
        exit;
    }
  
}

?>