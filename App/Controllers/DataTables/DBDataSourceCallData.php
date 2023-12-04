<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use \App\Models\Companies;
use App\Models\Placeholder;
use \App\Models\DataTableDesigns;
use App\Controllers\DataFormatHelper\DataTableHelper;
use App\Controllers\DataTables\DataTableJoinTable;
use App\Controllers\DataTables\GeneralDataTableFtn;


class DBDataSourceCallData extends \Core\Controller
{
    //(Start) This Function is used to get the data from DB .
	public static function getDBDataSourceCallData( $getPlaceholderDetails , $getCompanyDetails, $getSourceType , $oldSourceType){
      //  set_time_limit(0);
			// (Start)it will come in this condition when we want to get data for user login history 

            if(strpos($getSourceType, 'UserHistory')) 
            {
                $userCompanyDbName = 'BP_Admin10';
            }
            //(End) It will come in this condition when we want to get data for user login history 
            else{
                // (Start) this condition is to check if that table data should be fetched from  CompanyBPDb or CompanyBPDb .
                if(!empty($getPlaceholderDetails[0]['DBName']) || $getPlaceholderDetails[0]['AllowCustomTable'] == 1)
                {
                   
                    $userCompanyDbName = $getCompanyDetails[0]['CompanyBPDb'];
                   
                } else
                {
                     $userCompanyDbName = $getCompanyDetails[0]['CompanyBABCDb'];
                }
                // (End) this condition is to check if that table data should be fetched from  CompanyBPDb or CompanyBPDb .
            }
            // (Start)get CustomTable its specially if we want to get data from CompanyBPDb or we want to create a new table in DB .
            if(!empty($getPlaceholderDetails[0]['customTable']))
            {
                $Table =$getPlaceholderDetails[0]['customTable'];
            } else
            {
                 $Table = "";
            }
            // (End)get CustomTable its specially if we want to get data from CompanyBPDb or we want to create a new table in DB .
            // (Start) need to set the DB type so that we can build and excute that type of queries .       
            if(!empty($getPlaceholderDetails[0]['DBType']) && empty($getPlaceholderDetails[0]['DBName']))
            {
                $_SESSION['dataSourceDbType'] = $getPlaceholderDetails[0]['DBType'];
            } else
            {
                unset($_SESSION['dataSourceDbType'])  ;
            }
            // (End) need to set the DB type so that we can build and excute that type of queries . 
            // Query Call 
            $FilterSession = !empty($getPlaceholderDetails1[0]['FilterSessionEnable'])?trim($getPlaceholderDetails1[0]['FilterSessionEnable']):0;
       
            if(isset($_SESSION['TableValue']) || (isset($_SESSION['TableValue']['LSearch']) || $FilterSession == '1')){
                if(isset($_SESSION['TableValue']['LSearch'])){
                    unset($_SESSION['TableValue']['LSearch']);
                }
               
                foreach($_SESSION['TableValue'] as $tabKey => $tabValue){
                    //if(!empty($tabValue)){
                        if(strpos($getSourceType,"(".$tabKey.")") !== false){
                            if( strpos($tabValue,',') !== false){
                                $tabValue = explode(',' , $tabValue);
                                $tabValue = implode("','" , $tabValue);
                                $tabValue = $tabValue;
                            }
                            $getSourceType = str_replace( "(".$tabKey.")", "'".trim( $tabValue)."'" , $getSourceType );
                           
                        }else{
                            if( strpos($tabValue,',') !== false){
                                $tabValue = explode(',' , $tabValue);
                                $tabValue = implode("','" , $tabValue);
                                $tabValue = "'".$tabValue. "'";
                            }
                            $getSourceType = str_replace( "'".$tabKey."'", "'".trim( $tabValue)."'" , $getSourceType );
                        }
                       
                   // }
                }
                if($FilterSession != '1'){
                    unset($_SESSION['Allowfetchdata']);
                    unset($_SESSION['TableValue']);
                }
                
            }
           $DynamicCheck = 1;
            if($getPlaceholderDetails[0]['AllowDynamicForm'] && (!isset($_SESSION['TableValue'])) ){
                if($oldSourceType == $getSourceType){
					$DynamicCheck = 0;
				}
				
            }
		    //print_r($oldSourceType);
            //print_r($getSourceType);   exit;
		    if($DynamicCheck){
            	$allData = User::executeQuery($getSourceType, $userCompanyDbName , $Table );
			}else{
				$allData = array();
			}
            
            // (Start) in case if the Table is not present and you want to create new table then this part of code will create it .      
            if($allData == 'createTable')
            {
               
                $tabName = $getPlaceholderDetails[0]['customTable'];
                $TabFeilds = json_decode($getPlaceholderDetails[0]['dbNewColumns'] , true);
                $feild = '';
                // (Start) For Loop That is actually creating a query for new column and their dataType .
                foreach($TabFeilds as $TabKey => $TabValue){
                        if($TabKey == 'ID'){
                            $feild .= $TabValue['label'] .' int NOT NULL IDENTITY (1,1) ,';
                        }else{
                            $feild .= $TabValue['label'];
                            if($TabValue['type'] == 'integer')
                            {
                                $feild .= ' int NULL ,';
                            }else if($TabValue['type'] == 'nvarchar')
                            {
                                $feild .= ' nvarchar(max) NULL ,';
                            }else if($TabValue['type'] == 'date'){
                                $feild .= 'date NULL ,';
                            }
                        }

                }// (End) For Loop That is actually creating a query for new column and their dataType .
                $feild = rtrim( $feild , ',');
                //Query to create a new Table in DB 
                $newTabQuery = 'create Table ' .  $tabName . ' ( ' . $feild . ');';
                $res =  User::AddQuery($newTabQuery, $getCompanyDetails[0]['CompanyBPDb']);
                if(!$res)
                {
                    $allData = User::executeQuery($getSourceType, $getCompanyDetails[0]['CompanyBPDb'] , $Table );
            
                }
               
            } // (End) in case if the Table is not present and you want to create new table then this part of code will create it . )
            //return the Data .
		
            return $allData;

	}
    //(End) This Function is used to get the data from DB .
}
?>