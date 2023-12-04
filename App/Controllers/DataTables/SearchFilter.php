<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Models\Page;


/**
 *Search Filter  controller
 *
 * PHP version 7.0
 */
//  
class SearchFilter extends \Core\Controller
{
    public function DeleteSearch(){
        echo "pinged ";

        $pageId = $_REQUEST['placeholderId'];
        $userId = isset($_SESSION['UserID'])?$_SESSION['UserID']:'';
        $Pid = isset($_SESSION['ParentUserID'])?$_SESSION['ParentUserID']:'';
        $userIdNew  = !empty($Pid)?$Pid:$userId;
        $pageText = $_REQUEST['pageName'];
        $holderValue = $_REQUEST['holderValue'];

        
        $getData = Page::GetPageSearchFilter($pageId, $userId, $pageText , $holderValue );
       
        $getData = json_decode($getData['SearchFilter'] , true);
        if(isset($getData[$userIdNew])){
            unset($getData[$userIdNew]);
        }
       
        $getData = !empty($getData)?json_encode($getData):'';
        $data = Page::AddPageSearchFilter($pageId, $userId, $pageText , $holderValue ,  $getData );
        
        echo json_encode($data); 
        exit;

    }
    public function SaveSearch(){

        $pageId = $_REQUEST['placeholderId'];
        $userId = isset($_SESSION['UserID'])?$_SESSION['UserID']:'';
        $Pid = isset($_SESSION['ParentUserID'])?$_SESSION['ParentUserID']:'';
        $userIdNew  = !empty($Pid)?$Pid:$userId;
        $pageText = $_REQUEST['pageName'];
        $holderValue = $_REQUEST['holderValue'];
        $value =   implode(',' ,$_REQUEST['value']);
        
        $value = str_replace(array( '^', '$',
        '(' , '?', '.', ')' , '*' ,'!' ) , '' , $value);
        $value = explode(',' ,$value);
        $newArr = array();
        $newArr1 = array();
        foreach( $value as $key => $val){
                if(empty($val)){
                    $newArr[$key] = null ;
                }else {
                    $newArr[$key]["sSearch"] = $val;
                    $newArr[$key]["bRegex"] = true;
                }
        }
        $newArr = array_filter($newArr)?$newArr:''; 

        $getData = Page::GetPageSearchFilter($pageId, $userId, $pageText , $holderValue );
       
        $getData = json_decode($getData['SearchFilter'] , true);
        $getDataCheck = !empty($getData)?array_filter($getData):''; 
        if(!empty($getDataCheck)){
            $getData[$userIdNew] = $newArr;
        }else{
            $getData[$userIdNew] = $newArr;
        }
       
        $newArr = json_encode($getData);
        $data = Page::AddPageSearchFilter($pageId, $userId, $pageText , $holderValue , $newArr );
        echo json_encode($data); 
        exit;

    }
}