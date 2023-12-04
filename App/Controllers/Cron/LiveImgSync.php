<?php

namespace App\Controllers\Cron;

use PDO;
use App\Models\Page;
use \App\Models\User;

class LiveImgSync extends \Core\Controller
{
    public static  function LiveImgSync()
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://10.30.57.12/Babcportal/BabcPortal_Other_Assests/Cron/Selected_Brands/ImgUpload/LiveImgSync.php");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        curl_close($ch);
        echo $output;
        exit;
    
    }
    public static  function LiveReportSync()
    {
        $placeholderId = (isset($_POST['PID'])) ? $_POST['PID'] : "";
        $getPlaceholderDetails = Page::getDatasourceTableDetails($placeholderId);
        $getSourceType = "select * from LiveReportSync where TableID = '".$placeholderId."'";
        $allData = User::executeQuery($getSourceType, 'BP_Admin10' , '' );
        
        if($allData){
            $query = "Update LiveReportSync   set ReportStatus  = '1' where TableID = '".$placeholderId."'";
            $retrunVal = User::AddQuery($query, 'BP_Admin10');
        }else{
            if(!empty($getPlaceholderDetails[0]['customTable']))
            {
                $Table =$getPlaceholderDetails[0]['customTable'];
            } else
            {
                 $Table = "";
            }
            
            if(!empty($getPlaceholderDetails[0]['DBName']) || $getPlaceholderDetails[0]['AllowCustomTable'] == 1)
            {
                //$userCompanyDbName = $getCompanyDetails[0]['CompanyBPDb'];
                $userCompanyDbName = $_SESSION['BPDB'];
            } else
            {
                $userCompanyDbName = $_SESSION['BPDB'];
            }
            $postUrl = $getPlaceholderDetails[0]['LiveSyncPostURL'];
            $postBody = $getPlaceholderDetails[0]['LiveSyncPostBody'];

            $query = "insert into  LiveReportSync (TableID,PostUrl,PostBody,CompanyDB,CustomTable,ReportStatus)Values( '".$placeholderId."' , '".$postUrl."', '".$postBody."' , '".$userCompanyDbName."' , '".$Table."' , '1' ) ";
            $retrunVal = User::AddQuery($query, 'BP_Admin10');
           
        }
        echo "request sent";
        exit;
        
     

        
    }
    public static function LiveAPIReportSync(){

     
       if(isset($_POST['ActionURL'])){
        
        $_POST['ActionURL']  = $_POST['ActionURL'].'&OGAFilter='.$_POST['OGAFilter'];
        header("Location:" .$_POST['ActionURL'] );
        exit;
       }else{
            $_POST['Date'] = date('ymd');
            $_SESSION['Allowfetchdata'] = 1;
            $_SESSION['TableValue'] = $_POST;
            $_SESSION['URLReport'] = $_SERVER['HTTP_REFERER'];
            header("Location:" .$_SERVER['HTTP_REFERER'] );
            exit;
       }
        
    }

}