<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use App\Models\Placeholder;
use App\Controllers\DataFormatHelper\DataTableHelper;
/*
This File Conatin Function to Add the info regarding action Button .
*/
class ActionButton extends \Core\Controller
{
    //(Start) This Function add the link that are used when clicked on action Button .
	public static function getActionButton($tableActions , $dataToTable , $actationTableColumn , $placeholderId , $userPagePlaceholder){
		$orderNoCol = '';
        $orderNoValue = '';
       
        // (Start) Condition Setting the OrderNo COl and it Value thats being set from admin side 
        if(count($tableActions) > 1) {
            foreach ($tableActions as $eachAction) {
                foreach ($eachAction as $actionDetails) {
                    if ((isset($actionDetails['TableParameterColumn']))) {
                        $orderNoCol .= $actionDetails['TableParameterColumn'].'||';
                    }
                    if ((isset($actionDetails['TableParameterColumnValue']))) {
                        $orderNoValue .= $actionDetails['TableParameterColumnValue'].'||';
                    }
                }
            }

            $orderNoCol = rtrim($orderNoCol, '||');
            $orderNoValue = rtrim($orderNoValue, '||');
        }
        // (Start) Condition Setting the OrderNo COl and it Value thats being set from admin side 
        // variable declaration
        $names_ = "";
        $actions_ = "";
        $t = "";
        $txt_ =  "";
        $class_ = "";
        $separator= "%";
        //(Start) For all the table Action defined for that table rows .
        foreach ($tableActions as $key => $eachAction) {
            if(isset($key) && !in_array($key,$actationTableColumn)) {
                foreach ($eachAction as $actionDetails) {
                    //Get External Url if defined .
                    $externalUrl = $actionDetails['ExternalUrl'];
                    $tableParameterColumnValue = (isset($actionDetails['TableParameterColumnValue'])) ? $actionDetails['TableParameterColumnValue'] : "";
                   
                    if(count($tableActions) == 1) {
                        $orderNoCol = '';
                        $orderNoValue = '';
                        $orderNoCol = $actionDetails['TableParameterColumn'];
                        $orderNoValue = $tableParameterColumnValue;
                        
                    }
                    $pageTextValue = '';
                    //(Start) Get page Text 
                    if($_SESSION['UserID'] && $actionDetails['PageTargetId']) {
                        $pageText = Page::getPageText($actionDetails['PageTargetId'], $_SESSION['UserID']);
                        if($pageText) {
                            $pageTextValue = $pageText[0]['PageMenuText'];
                        }
                    }
                     //(End) Get page Text 
                     //(Start) In Case if External Url is defined 
                    if (!empty($externalUrl)) {
                        $buttonAction = $externalUrl;
                    } //(end)In Case if External Url is defined 
                    else {
                    //(Start) if external Url not defined 
                        $buttonAction = baseUrl . 'page?id=' . $actionDetails['PageTargetId'] . '&page_text='. $pageTextValue .'&columnName=' . $actionDetails['TableParameterColumn'] . '&columnValue=' . $tableParameterColumnValue;
                    }
                    //(End) if external Url not defined 
                    //(Start) if the action selected is Update DataSource . it can be update through form or predefined update .
                    if ($actionDetails['updateDataSource'] == 1) {
                        $parameterArray = array('orderNoCol'=>$orderNoCol,'orderNoValue'=>$orderNoValue,'baseUrl' => baseUrl, 'pageTextValue' => rawurlencode ($pageTextValue), 'dataSourceId' => $actionDetails['DataSourceId'],'pageTargetId' => $actionDetails['PageTargetId']);
                        if( $actionDetails['PredefinedUpdate'] == 1 &&  ($actionDetails['PredefinedUpdateRedis'] == 1) && isset($_SESSION['CacheUser'])){
                            $parameterArray['placeholderId'] = $placeholderId;
                            $parameterArray['userPagePlaceholder'] = $userPagePlaceholder;
                            $parameterArray['DeleteRedis'] = 1;
                        }
                        $parameterArray = json_encode($parameterArray, JSON_UNESCAPED_SLASHES);
                        // (Start) For predefined Update 
                        if ($actionDetails['PredefinedUpdate'] == 1) {
                            $buttonAction = 'getUpdatePredefined('. $parameterArray .')';
                            $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                            $class_ .= str_replace("http://","",$buttonAction).$separator;
                        } 
                        // (End)For predefined Update 
                        // (Start)For Update a DataSoucre Call 
                        else if ($actionDetails['DataSourceCall'] == 1) {
                            $buttonAction = 'getUpdateDataSourceCall('. $parameterArray .')';
                            $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                            $class_ .= str_replace("http://","",$buttonAction).$separator;
                        } 
                        // (End)For Update a DataSoucre Call 
                        else if($actionDetails['FormOnActionBTN'] == 1) {
                            $buttonAction = "LiveAPISyncReport('create' , '1698' , '2' , '0')";
                            $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                            $class_ .= str_replace("http://","",$buttonAction).$separator;
                        } 
                        // (Start)For Update row from Form  
                        else {
                            
                            $buttonAction = baseUrl . 'getUpdateForm?dataSourceId=' . $actionDetails['DataSourceId'] .   '&pageId=' . $actionDetails['PageTargetId']  . '&columnName=' . $orderNoCol . '&columnValue=' . $orderNoValue . '&tableID=' . $actionDetails['TableTemplateId']. '&page_text='. rawurlencode ($pageTextValue) ;
                           
                            if( ($actionDetails['PredefinedUpdateRedis'] == 1) && isset($_SESSION['CacheUser'])){
                                $buttonAction = $buttonAction.'&placeholderId='.$placeholderId.'&userPagePlaceholder=' .  $userPagePlaceholder . '&DeleteRedis=1';
                            }
                            $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                            $class_ .= str_replace("http://","",$buttonAction).$separator;
                        }
                        // (End))For Update row from Form 
                    } 
                    //(End) if the action selected is Update DataSource . it can be update through form or predefined update .
                    else {
                        // (Start ) if you want to Download a PDf normally a invoice .
                        if ($actionDetails['IsPdf'] == 1) {
                            $buttonAction = baseUrl . 'downloadPdf?dataSourceId=' . $actionDetails['DataSourceId'] . '&InvoiceNo=' . $invoiceNo;
                            $txt_ .= $actionDetails['ActionButtonText'].$separator;
                            $class_ .= str_replace("http://","",$buttonAction).$separator;
                        } 
                        else if($actionDetails['FormOnActionBTN'] == 1) {
                            $buttonAction = "LiveAPISyncReport('create' , '1698' , '2' , '0')";
                            $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                            $class_ .= str_replace("http://","",$buttonAction).$separator;
                        } 
                        // (End) if you want to Download a PDf normally a invoice .
                        else {
                            $txt_ .= $actionDetails['ActionButtonText'].$separator;
                            $class_ .= str_replace("http://","",$buttonAction).$separator;
                        }
                    }
                }
            }
         
        }
        //(End) For all the table Action defined for that table rows .
        return array( $txt_ , $class_ );
	}
    //(End) This Function add the link that are used when clicked on action Button .

}
?>