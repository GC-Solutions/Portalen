<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use \App\Models\Companies;
use App\Models\Placeholder;
use App\Controllers\DataFormatHelper\DataTableHelper;
/**
 * SendForm controller
 *
 * PHP version 7.0
 */
// This File is used to gernerate form on a page .
// IT conatin functions that will get required setting set at the admin side and will craete a form at rum time.
class SendForm extends \Core\Controller
{
	 // (Start)generate data for Forms 
    public function generateSendOrdersDataAction()
    {
        // Set the number of seconds a script is allowed to run to infinity 
        set_time_limit(0);
        // Memory Limit for the script
        ini_set('memory_limit', '2G');
        $id = trim($_REQUEST['placeholderId']);
        $gettable  = Placeholder::getSendOrdertable( $id );
        echo json_encode(array('data' => ['MainData' => json_decode($gettable[0]['DetailColumns']) , 'orderRow' => json_decode($gettable[0]['DetailColumnsOrderColumn']) , 'formId' => $gettable[0]['ID'] ]));
        // the Return data will actually generate the form .
        return json_encode(array('data' => ['MainData' => json_decode($gettable[0]['DetailColumns']) , 'orderRow' => json_decode($gettable[0]['DetailColumnsOrderColumn']) , 'formId' => $gettable[0]['ID']]));
        exit;
        
    }
    //(End)generate data for Forms
    // This function  basically update the for form data being POsted from Update_form.php
    public function SendOrderData()
    {
        // Set the number of seconds a script is allowed to run to infinity 
        set_time_limit(0);
        // Memory Limit for the script 
        ini_set('memory_limit', '2G');
        $_REQUEST['formId']  = 1;
        $rowData = isset($_REQUEST['rowData']) ?$_REQUEST['rowData']:2;
        $body = [];
        // get the form ID and all its related feilds
        $gettable  = Placeholder::getSendOrdertable( $_REQUEST['formId'] );
        $DetailColumnsOrderColumn =  array_keys(get_object_vars(json_decode($gettable[0]['DetailColumnsOrderColumn'])));
        $DetailColumns =  array_keys(get_object_vars(json_decode($gettable[0]['DetailColumns'])));

        foreach($DetailColumns as $key => $value){
            $body[$value] = $_REQUEST[$value];
            unset($_REQUEST[$value]);
        }
        $tempArr1 = [];
        if($rowData){
            while($rowData){
               $tempArr = [];
               foreach($DetailColumnsOrderColumn as $orderColumKey =>  $orderColumVal ){
                
                    $tempArr[$orderColumVal] = $_REQUEST[$orderColumVal.$rowData];
                    unset($_REQUEST[$orderColumVal.$rowData]);
                }
                $rowData = $rowData - 1;
                array_push($tempArr1 ,$tempArr);
            }
            $tempArr = [];
            foreach($DetailColumnsOrderColumn as $orderColumKey =>  $orderColumVal ){
                
                    $tempArr[$orderColumVal] = $_REQUEST[$orderColumVal];
                    unset($_REQUEST[$orderColumVal]);
            }
            array_push($tempArr1 ,$tempArr);
            $body['orderRow'] =$tempArr1;

        }else{
            foreach($DetailColumnsOrderColumn as $orderColumKey =>  $orderColumVal ){
                
                    $tempArr[$orderColumVal] = $_REQUEST[$orderColumVal];
                    unset($_REQUEST[$orderColumVal]);
            }
             $body['orderRow'] = $tempArr;
        }
        $body = json_encode($body);
        $res  = Self::UpdateFormDataAction($body);
        $curLoc = $_SERVER['HTTP_REFERER'] ;
        header('Location: ' . $curLoc);
        exit;
        
    }



}



?>