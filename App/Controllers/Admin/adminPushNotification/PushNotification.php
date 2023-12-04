<?php

namespace App\Controllers\Admin\adminPushNotification;

use \Core\View;
use \App\Models\User;
use \App\Models\PushNotifications;
use \App\Models\Placeholder;
use \App\Models\TablePlaceholders;

/**
 * Push Notification  controller
 *
 * PHP version 7.0
 */
class PushNotification extends \Core\Controller
{
    
    public function showPushNotification()
    {

        $getPushNotification = PushNotifications::getAllpushNotification();
        View::render('administrator/PushNotification/showNotification.php', ['getPushNotification' => $getPushNotification]);
    }
    public function addPushNotification()
    {

        if(isset($_REQUEST['id'])){
            $getAllTable = Placeholder::getAllTableData("Tables");
            $id = $_REQUEST['id'] ;
            $getNotiData = PushNotifications::getPushNotification($id);
            //print_r($getNotiData ); exit;
            View::render('administrator/PushNotification/addEditNotification.php', ['getNotiData' =>  $getNotiData[0] , 'getAllTable' => $getAllTable]);
       
        }else{
            $getAllTable = Placeholder::getAllTableData("Tables");
            View::render('administrator/PushNotification/addEditNotification.php', ['getAllTable' => $getAllTable]);
       
        }
   }
    public function savePushNotification()
    {
        $saveData = $_REQUEST;
       
        $dataArr = [];
        $tabColumn = TablePlaceholders::getTableColumns($saveData['TableID']);
        $tabColumn = explode(',' , $tabColumn[0]['Columns'] );
        foreach( $tabColumn as $colKey => $colVal){
            
            $keys  = array_keys($saveData);
            $keyTemp = [];
            foreach($keys as $saveKey => $saveValue){
                if(strpos($saveValue ,  $colVal.'_FirstParameter_') !== false){
                    $ids = explode( $colVal.'_FirstParameter_' , $saveValue);
                    $keyTemp[] = $ids[1];
                }
            }
            $cnt = 1;
            
            foreach( $keyTemp as $ke => $i)
            {
                
                $conName = $colVal.'_Condition_'.$i;
               
                if(!empty($saveData[$conName])  ){
                    
                    $dataArr[$colVal][$cnt]['FirstParameter'] = $saveData[$colVal.'_FirstParameter_'.$i];
                    $dataArr[$colVal][$cnt]['Condition'] = $saveData[$colVal.'_Condition_'.$i];
                    $dataArr[$colVal][$cnt]['SecondParameter'] = $saveData[$colVal.'_SecondParameter_'.$i];
                   
                }
                $cnt = $cnt +1;
            }
            
        }
        
        $dataArr = json_encode($dataArr);
        $saveData['Conditions'] =  $dataArr;
        PushNotifications::addNotification($saveData);
        header('Location: ' . baseUrl . 'pushNotification');

    }

   
    
}