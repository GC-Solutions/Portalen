<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use App\Models\Placeholder;
use App\Controllers\DataFormatHelper\DataTableHelper;
use App\Controllers\DataTables\APIDataSourceCallData;
use App\Controllers\DataTables\GeneralDataTableFtn;
use App\Controllers\DataTables\SumCalculation;
use App\Controllers\DataTables\ActionButton;



class  SourceType extends \Core\Controller
{
	public static function getSourceType($getPlaceholderDetails , $sourceType){

        // Variable Declaration and Initialization that will be used to create Source type 
		$customerNo = (isset($_REQUEST['CustomerNo'])) ? $_REQUEST['CustomerNo'] : "";
        $CustomerNo = (isset($_REQUEST['CustomerNo'])) ? $_REQUEST['CustomerNo'] : "";
        $ChildProductNo = (isset($_REQUEST['ChildProductNo'])) ? $_REQUEST['ChildProductNo'] : "";
        $ProductNo = (isset($_REQUEST['ProductNo'])) ? $_REQUEST['ProductNo'] : "";
        $Product_No = (isset($_REQUEST['Product_No'])) ? $_REQUEST['Product_No'] : "";
        $OrderNo = (isset($_REQUEST['OrderNo'])) ? $_REQUEST['OrderNo'] : "";
        $SupplierNo = (isset($_REQUEST['SupplierNo'])) ? $_REQUEST['SupplierNo'] : "";   
        $CountryId = (isset($_REQUEST['CountryId'])) ? $_REQUEST['CountryId'] : ""; 
        $Period = (isset($_REQUEST['Period'])) ? $_REQUEST['Period'] : ""; 
        $CategoryId = (isset($_REQUEST['CategoryId'])) ? $_REQUEST['CategoryId'] : "";  
        $Category_ID = (isset($_REQUEST['Category_ID'])) ? $_REQUEST['Category_ID'] : "";  
        $SellerId = (isset($_REQUEST['SellerId'])) ? $_REQUEST['SellerId'] : "";  
        $Category = (isset($_REQUEST['Category'])) ? $_REQUEST['Category'] : ""; 
        $ProductGroup1 = (isset($_REQUEST['ProductGroup1'])) ? $_REQUEST['ProductGroup1'] : "";  
        $ProductGroup2 = (isset($_REQUEST['ProductGroup2'])) ? $_REQUEST['ProductGroup2'] : "";  
        $ProductGroup3 = (isset($_REQUEST['ProductGroup3'])) ? $_REQUEST['ProductGroup3'] : "";  
        $ProductGroup4 = (isset($_REQUEST['ProductGroup4'])) ? $_REQUEST['ProductGroup4'] : "";  
        $WarehouseNo = (isset($_REQUEST['WarehouseNo'])) ? $_REQUEST['WarehouseNo'] : "";  
        $Purchaser = (isset($_REQUEST['Purchaser'])) ? $_REQUEST['Purchaser'] : "";  
        $Year = (isset($_REQUEST['Year'])) ? $_REQUEST['Year'] : "";  
        $DeliverCustomerNo = (isset($_REQUEST['DeliverCustomerNo'])) ? $_REQUEST['DeliverCustomerNo'] : "";
        $InvoiceCustomerNo = (isset($_REQUEST['InvoiceCustomerNo'])) ? $_REQUEST['InvoiceCustomerNo'] : "";
        $CompanyId = (isset($_REQUEST['CompanyId'])) ? $_REQUEST['CompanyId'] : "";
        $company_id = (isset($_REQUEST['company_id'])) ? $_REQUEST['company_id'] : "";
        $company_name = (isset($_REQUEST['company_name'])) ? $_REQUEST['company_name'] : "";
        $requester_id = (isset($_REQUEST['requester_id'])) ? $_REQUEST['requester_id'] : "";
        $contact_id = (isset($_REQUEST['contact_id'])) ? $_REQUEST['contact_id'] : "";
        $ticket_id = (isset($_REQUEST['ticket_id'])) ? $_REQUEST['ticket_id'] : "";
        $ProjectId = (isset($_REQUEST['ProjectId'])) ? $_REQUEST['ProjectId'] : "";
        $Focus = (isset($_REQUEST['Focus'])) ? $_REQUEST['Focus'] : "";
        $CurrencyId = (isset($_REQUEST['CurrencyId'])) ? $_REQUEST['CurrencyId'] : "";
        $PriceListId = (isset($_REQUEST['PriceListId'])) ? $_REQUEST['PriceListId'] : "";
        $SKUPack = (isset($_REQUEST['SKUPack'])) ? $_REQUEST['SKUPack'] : "";
        $ModelNo = (isset($_REQUEST['ModelNo'])) ? $_REQUEST['ModelNo'] : "";
        $ProductionGroup = (isset($_REQUEST['ProductionGroup'])) ? $_REQUEST['ProductionGroup'] : "";
        $OGAFilter = (isset($_REQUEST['OGAFilter'])) ? $_REQUEST['OGAFilter'] : "";
        $priority = (isset($_REQUEST['priority'])) ? $_REQUEST['priority'] : "";
        $agent_id = (isset($_REQUEST['agent_id'])) ? $_REQUEST['agent_id'] : "";
        $group_id = (isset($_REQUEST['group_id'])) ? $_REQUEST['group_id'] : "";
        if($sourceType == 'body')
        {
            $getSourceType = $getPlaceholderDetails[0]['Body'];
            
            if(isset( $_GET['CustomerNo']) && is_numeric($CustomerNo)){
                $getSourceType = str_replace("(CustomerNo)", $CustomerNo, $getSourceType);
            }  
            if(isset( $_GET['CustomerNo'])){
                if(strpos($getSourceType , '(CustomerNo)"') !== false){
                    $getSourceType = str_replace('(CustomerNo)', $_GET['CustomerNo'], $getSourceType);
                }else{
                    $getSourceType = str_replace('(CustomerNo)','"'. $_GET['CustomerNo'].'"', $getSourceType);
                }
                
            }
            
            if($OGAFilter) {
                $getSourceType = str_replace("(OGAFilter)", $OGAFilter, $getSourceType);
            }else{
                $getSourceType = str_replace("(OGAFilter)", '""', $getSourceType);
            }
            if($getPlaceholderDetails[0]['AllowDynamicForm']){
                $sourceVal = json_decode( $getSourceType , true);
                foreach ($sourceVal  as $key => $value) {
                    if($key == 'FilePath'){
                        $tempValue = explode('.txt' , $value);
                        $tempValue = $tempValue[0].'('.$_SESSION['username'].').txt';
                        $sourceVal[$key] = $tempValue;

                    }elseif(is_array($value)){
                        if(in_array('FilePath' , $value)){
                            $tempValue = explode('.txt' , $value['FilePath']);
                            $tempValue = $tempValue[0].'('.$_SESSION['username'].').txt';
                            $sourceVal[$key]['FilePath'] = $tempValue;
                        }
                    }
                }
                $getSourceType = json_encode($sourceVal); 
            }
          
        }else{
            $getSourceType = $getPlaceholderDetails[0]['SourceAddress'];
        }
        
        // Replacing the DBParam Paramter with the value set by the comapny .
        if(isset($_SESSION['DBParam'])) {
            $arr = explode('|', $_SESSION['DBParam'] );
            if(!empty($arr[0])){
                foreach ($arr as $v) {
                    $val = explode(':', $v);
                    $str = explode(',', $val[1]);
                    $dataVal = '';
                    if(count($str) > 1){
                        foreach ($str as $ke => $va) {
                            $dataVal = $dataVal .  $va . ",";
                        }
                    }else{
                         $dataVal = $str[0];
                    }

                    $dataVal = rtrim($dataVal,',');
                    $getSourceType = str_replace("'(".$val[0].")'", $dataVal, $getSourceType);
                    $getSourceType = str_replace("(".$val[0].")", $dataVal, $getSourceType);
                    
                }
            }
        }
        // Replacing the APIParam Paramter with the value set by the comapny .
        if(isset($_SESSION['APIParam'])) {
            $arr = explode('|', $_SESSION['APIParam'] );
            if(!empty($arr[0])){
                foreach ($arr as $v) {
                    $val = explode(':', $v);

                    $str = explode(',', $val[1]);
                    $dataVal = '';
                    if(count($str) > 1){
                        foreach ($str as $ke => $va) {
                            $dataVal = $dataVal .  $va . ",";
                        }
                    }else{
                         $dataVal = $str[0];
                    }

                    $dataVal = rtrim($dataVal,',');
                    $getSourceType = str_replace("'(".$val[0].")'", $dataVal, $getSourceType);
                    $getSourceType = str_replace("(".$val[0].")", $dataVal, $getSourceType);
                    
                }
            }
            
        }
      
        if(isset($_SESSION['TicketFilterId'])){
            $company_id = (isset($_SESSION['TicketFilterId'])) ? $_SESSION['TicketFilterId'] : "";
            unset($_SESSION['TicketFilterId']);
        }
        // Replacing the paramter with their respective values . 
        if(isset($CustomerNo)) {
            $getSourceType = str_replace("(CustomerNo)", $CustomerNo, $getSourceType);
        }
        if(isset($ModelNo)) {
            $getSourceType = str_replace("(ModelNo)", "'".$ModelNo."'", $getSourceType);
        }
        if(isset($ProductNo)) {
            $getSourceType = str_replace("(ProductNo)", $ProductNo, $getSourceType);
        }
        if(isset($ChildProductNo)) {
            $ChildProductNo = str_replace("and", "&", $ChildProductNo);
            $getSourceType = str_replace("(ChildProductNo)", $ChildProductNo, $getSourceType);
        }
        
        if(isset($SKUPack)) {
           
            $getSourceType = str_replace("(SKUPack)", "'" .$SKUPack ."'", $getSourceType);
        }
        if(isset($OrderNo)) {
            $getSourceType = str_replace("(OrderNo)", $OrderNo, $getSourceType);
        }
        if(isset($SupplierNo)) {
            $getSourceType = str_replace("(SupplierNo)", $SupplierNo, $getSourceType);
        }
         if(isset($CountryId)) {
            $getSourceType = str_replace("(CountryId)", $CountryId, $getSourceType);
        }
         if(isset($Period)) {
            $getSourceType = str_replace("(Period)", $Period, $getSourceType);
        }
        if(isset($CategoryId)) {
            $getSourceType = str_replace("(CategoryId)", $CategoryId, $getSourceType);
        }
        if(isset($Category_ID)) {
            $getSourceType = str_replace("(Category_ID)", $Category_ID, $getSourceType);
        }
        if(isset($Product_No)) {
            $getSourceType = str_replace("(Product_No)", $Product_No, $getSourceType);
        }
        if(isset($SellerId)) {
            $getSourceType = str_replace("(SellerId)", $SellerId, $getSourceType);
        }
        if(isset($Category)) {
            $getSourceType = str_replace("(Category)", $Category, $getSourceType);
        }
        if(isset($ProductGroup1)) {
            $getSourceType = str_replace("(ProductGroup1)", $ProductGroup1, $getSourceType);
        }
        if(isset($ProductGroup2)) {
            $getSourceType = str_replace("(ProductGroup2)", $ProductGroup2, $getSourceType);
        }
        if(isset($ProductGroup3)) {
            $getSourceType = str_replace("(ProductGroup3)", $ProductGroup3, $getSourceType);
        }
        if(isset($ProductGroup4)) {
            $getSourceType = str_replace("(ProductGroup4)", $ProductGroup4, $getSourceType);
        }
        if(isset($WarehouseNo)) {
            $getSourceType = str_replace("(WarehouseNo)", $WarehouseNo, $getSourceType);
        }
        if(isset($Purchaser)) {
            $getSourceType = str_replace("(Purchaser)", $Purchaser, $getSourceType);
        }
        if(isset($ProductionGroup)) {
            $getSourceType = str_replace("(ProductionGroup)", $ProductionGroup, $getSourceType);
        }
        
        if(isset($Year)) {
            $getSourceType = str_replace("(Year)", $Year, $getSourceType);
        }
        if(isset($DeliverCustomerNo)) {
            $getSourceType = str_replace("(DeliverCustomerNo)", $DeliverCustomerNo, $getSourceType);
        }
        if(isset($InvoiceCustomerNo)) {
            $getSourceType = str_replace("(InvoiceCustomerNo)", $InvoiceCustomerNo, $getSourceType);
        }
        if(isset($CompanyId)) {
            $getSourceType = str_replace("(CompanyId)", $CompanyId, $getSourceType);
        }
        if(isset($requester_id)) {
            $getSourceType = str_replace("(requester_id)", $requester_id, $getSourceType);
        }
        if(isset($company_id)) {
            $getSourceType = str_replace("(company_id)", $company_id, $getSourceType);
        }
        if(isset($company_name)) {
            $company_name = str_replace("%20", ' ', $company_name);
            $getSourceType = str_replace("(company_name)", $company_name, $getSourceType);
        }

        
        if(isset($contact_id)) {
            $getSourceType = str_replace("(contact_id)", $contact_id, $getSourceType);
        }
        if(isset($ticket_id)) {
            $getSourceType = str_replace("(ticket_id)", $ticket_id, $getSourceType);
        }
        if(isset($ProjectId)) {
            $getSourceType = str_replace("(ProjectId)", $ProjectId, $getSourceType);
        }
        if(isset($Focus)) {
            $getSourceType = str_replace("(Focus)", $Focus, $getSourceType);
        }
        if(isset($CurrencyId)) {
            $getSourceType = str_replace("(CurrencyId)", $CurrencyId, $getSourceType);
        }
        if(isset($PriceListId)) {
            $getSourceType = str_replace("(PriceListId)", $PriceListId, $getSourceType);
        }
        if(isset($priority)) {
            $getSourceType = str_replace("(priority)", $priority, $getSourceType);
        }
        if(isset($agent_id)) {
            $getSourceType = str_replace("(agent_id)", $agent_id, $getSourceType);
        }
        if(isset($group_id)) {
            $getSourceType = str_replace("(group_id)", $group_id, $getSourceType);
        }
        if(isset( $_SESSION['FreshDeskCompanyCheck']) && $company_id == '' && $company_name == ''){
            if( $_SESSION['FreshDeskCompanyCheck'] == '1'){
                $getSourceType = $getSourceType ." ('') or 1=1 )";
            }else{
                $getSourceType = $getSourceType ." (".$_SESSION['FreshDeskCompanyCheck'].") and 1=1 )";
            }
        }
        //print_r($getSourceType); exit;
        // return the Source Type .
        return $getSourceType;
	}
	    


}
?>