<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Models\Page;
use \App\Models\User;

use PDO;

class Payment extends \Core\Controller
{
    public static  function AddPayment()
    {
      
        $currentUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] ;
        if($_REQUEST['action'] == 'create')
        {
            $placeholderId = (isset($_REQUEST['placeholderId'])) ? $_REQUEST['placeholderId'] : "";
            $getPlaceholderDetails = Page::getDatasourceTableDetails($placeholderId);
           
            if($getPlaceholderDetails[0]['AllowDynamicForm']){
                $getISOCurCode = array('AFA'  ,
                'AWG' ,
                'AUD' ,
                'ARS' ,
                'AZN' ,
                'BSD',
                'BDT' ,
                'BBD' ,
                'BYR' ,
                'BOB' ,
                'BRL' ,
                'GBP' ,
                'BGN',
                'KHR' ,
                'CAD' ,
                'KYD' ,
                'CLP' ,
                'CNY' ,
                'COP' ,
                'CRC' ,
                'HRK' ,
                'CPY' ,
                'CZK' ,
                'DKK' ,
                'DOP' ,
                'XCD'  ,
                'EGP'  ,
                'ERN'  ,
                'EEK' ,
                'EUR' ,
                'GEL',
                'GHC' ,
                'GIP' ,
                'GTQ' ,
                'HNL',
                'HKD',
                'HUF' ,
                'ISK' ,
                'INR' ,
                'IDR',
                'ILS' ,
                'JMD' ,
                'JPY' ,
                'KZT' ,
                'KES' ,
                'KWD',
                'LVL' ,
                'LBP' ,
                'LTL' ,
                'MOP' ,
                'MKD',
                'MGA' ,
                'MYR' ,
                'MTL',
                'BAM' ,
                'MUR' ,
                'MXN' ,
                'MZM' ,
                'NPR' ,
                'ANG' ,
                'TWD',
                'NZD' ,
                'NIO' ,
                'NGN' ,
                'KPW' ,
                'NOK' ,
                'OMR' ,
                'PKR',
                'PYG' ,
                'PEN' ,
                'PHP' ,
                'QAR' ,
                'RON' ,
                'RUB' ,
                'SAR' ,
                'CSD' ,
                'SCR',
                'SGD' ,
                'SKK',
                'SIT' ,
                'ZAR' ,
                'KRW' ,
                'LKR' ,
                'SRD' ,
                'SEK' ,
                'CHF' ,
                'TZS' ,
                'THB' ,
                'TTD' ,
                'TRY' ,
                'AED' ,
                'USD' ,
                'UGX' ,
                'UAH' ,
                'UYU' ,
                'UZS' ,
                'VEB' ,
                'VND' ,
                'AMK',
                'ZWD' );
                $formData = Page::getDynamicFormData($getPlaceholderDetails[0]['DynamicFormName']);
                $getAllPaymentCustomer = array();
                $getMandateType = array();
                $detail = json_decode($formData[0]['DetailColumns'] , true);
                $getAllAbsenceReasons = '';
                $getAllActivity = '';
                $actionBTns = '';
                $actionURL = '';
                
                if(isset($_REQUEST['actionBTN'])){
                    // if(baseUrl == "/public//")
                    // {
                    //     $actionBTns = 'http://localhost:9999/'.$_REQUEST['actionButon'];
                    // }else{
                    //    // $actionBTns = baseUrl.$_REQUEST['actionButon'];
                    //    $actionBTns = 'http://localhost:9999'.$_REQUEST['actionButon'];
                    // }
                    $actionURL = $_REQUEST['actionButon'];
                    $columnValues = json_decode($formData[0]['DetailColumns'], true);
                    $colName = $_REQUEST['columnNames'];
                    $colValue = $_REQUEST['columnValues'];
                    foreach($columnValues  as $colkey => $colVale){
                        if($colkey ==  $colName){
                            $columnValues[ $colkey]['Default'] = $colValue;
                            break ;
                        }
                    } 
                    $formData[0]['DetailColumns'] = json_encode($columnValues);
                    
                }else{
                    if($_SESSION['BPDB'] == 'BP_Arxus'){
                        $getAllPaymentCustomer = self::getAllPaymentCustomer();
                        $getMandateType = array('FRST' , 'RCUR', 'OOFF' , 'FNAL');
                    
                    }
                    
                    foreach($detail as $key => $val){
                        
                        if(isset($val['fetchDataFrom'])){
                            if($val['fetchDataFrom'] == 'getAllAbsenceReasons'){
                                $getAllAbsenceReasons = self::getAllAbsenceReasons();
                            }elseif($val['fetchDataFrom'] == 'getAllActivity'){
                                $getAllActivity = self::getAllActivity();

                            }
                        }
                    }
                }
                
                if(strpos($formData[0]['ActionButton'] , 'http://212.247.32.103:8082/') !== false){
                        $tempUrl = explode('public/' , $formData[0]['ActionButton']);
                        $formData[0]['ActionButton'] = $currentUrl.'/'.'public/'.end($tempUrl);
                        
                }else{
                      $formData[0]['ActionButton'] = $currentUrl.'/'.'public/'.$formData[0]['ActionButton'];
                }
                
                $actionBTns = $formData[0]['ActionButton'].'?placeholderId='.$placeholderId;
                
                $Btn  = isset($_REQUEST['LSearch'])? $_REQUEST['LSearch']:0;
                
                if(isset($getPlaceholderDetails[0]['Body'])){
                   
                    if(isset($_SESSION['URLReport'])){
                        if($_SESSION['URLReport'] != $_SERVER['HTTP_REFERER']){
                            
                            unset($_SESSION['TableValue']); 
                        }
                    }
                    $columnValues = json_decode($formData[0]['DetailColumns'], true);
                    $bodyJson = json_decode($getPlaceholderDetails[0]['Body'], true);
                   
                    if(isset($bodyJson['RunReport']['Dialogs'])){
                        foreach($bodyJson['RunReport']['Dialogs'] as $JKey => $JVal){
                                $idName = $JVal['Id'];
                               
                                $keyNew = str_replace(' ' , '_',  $idName);
                                if(isset($_SESSION['TableValue'][$keyNew]) && $Btn == '1'){
                                    $MainVal = (isset($_SESSION['TableValue'][$keyNew]) && $Btn == '1')?$_SESSION['TableValue'][$keyNew]:$JVal['Value'];
                                  
                                }else{
                                    $MainVal = (isset($_SESSION['TableValue'][$key]) && $Btn == '1')?$_SESSION['TableValue'][$key]:$JVal['Value'];
                                  
                                }
                                  
                                if(array_key_exists($idName,$columnValues)){
                                    $columnValues[$idName]['Default'] = $MainVal;
                                }
                        }
                     
                    }
                    foreach($columnValues as $key => $value){
                        
                        if(isset($bodyJson['RunReport'][$key]) ){
                            $keyNew = str_replace(' ' , '_', $key);
                            if(isset($_SESSION['TableValue'][$keyNew]) && $Btn == '1'){
                                $MainVal = (isset($_SESSION['TableValue'][$keyNew]) && $Btn == '1')?$_SESSION['TableValue'][$keyNew]:$bodyJson['RunReport'][$key];
                              
                            }else{
                                $MainVal = (isset($_SESSION['TableValue'][$key]) && $Btn == '1')?$_SESSION['TableValue'][$key]:$bodyJson['RunReport'][$key];
                              
                            }
                              
                            $columnValues[$key]['Default'] = $MainVal;
                        }
                       
                    }
                    
                    $formData[0]['DetailColumns'] = json_encode($columnValues);

                }else{
                   
                    if(isset($formData[0]['CallType']) && ($formData[0]['CallType'] == '2') ){
                        $columnValues = json_decode($formData[0]['DetailColumns'], true);
                       
                        foreach($columnValues as $key => $value){
                           
                            if(isset($_SESSION['TableValue'][$key]) && $Btn == '1'){
                                $columnValues[$key]['Default'] = (isset($_SESSION['TableValue'][$key]) && $Btn == '1')?$_SESSION['TableValue'][$key]:'';
                           
                            }else if(isset($columnValues[$key]['Default'])){
                                $columnValues[$key]['Default'] = $value['Default'];
                            }
                            
                        }
                        $formData[0]['DetailColumns'] = json_encode($columnValues);
                    }
                   
                }
               
                // if( isset($_SESSION['AllParameters'])){
                //     foreach($_SESSION['AllParameters'] as $key => $value){
                //         $formData[0]['DetailColumns'] = str_replace("(".$value['ParamName'].")", $value['ParamValue'], $formData[0]['DetailColumns']);
                //     }
                    
                // }
                $pageDesign  = isset($_REQUEST['DID'])? $_REQUEST['DID']:$formData[0]['DesignType'];
                
                View::render('administrator/pageaccess/dynamic_form.php', [ 'ActionURL' => $actionURL , 'lSearch' => $Btn , 'getAllActivity'=> $getAllActivity, 'getAllAbsenceReasons'=> $getAllAbsenceReasons ,'AllReadOnly'=> $formData[0]['AllReadOnly'] , 'actionButton'=> $actionBTns , 'PageDesign'=>$pageDesign  , 'DetailColumns' => $formData[0]['DetailColumns'], 'HiddenColumns' => $formData[0]['HiddenColumns'], 'pId' =>  $placeholderId , 'action' => $_REQUEST['action'] , 'getISOCurCode' => $getISOCurCode , 'getMandateType' => $getMandateType , 'getAllPaymentCustomer'=> $getAllPaymentCustomer ]);


            }else{

                    $ISOCurCode = array('AFA' => array('Afghan Afghani', '971'),
                    'AWG' => array('Aruban Florin', '533'),
                    'AUD' => array('Australian Dollars', '036'),
                    'ARS' => array('Argentine Pes', '032'),
                    'AZN' => array('Azerbaijanian Manat', '944'),
                    'BSD' => array('Bahamian Dollar', '044'),
                    'BDT' => array('Bangladeshi Taka', '050'),
                    'BBD' => array('Barbados Dollar', '052'),
                    'BYR' => array('Belarussian Rouble', '974'),
                    'BOB' => array('Bolivian Boliviano', '068'),
                    'BRL' => array('Brazilian Real', '986'),
                    'GBP' => array('British Pounds Sterling', '826'),
                    'BGN' => array('Bulgarian Lev', '975'),
                    'KHR' => array('Cambodia Riel', '116'),
                    'CAD' => array('Canadian Dollars', '124'),
                    'KYD' => array('Cayman Islands Dollar', '136'),
                    'CLP' => array('Chilean Peso', '152'),
                    'CNY' => array('Chinese Renminbi Yuan', '156'),
                    'COP' => array('Colombian Peso', '170'),
                    'CRC' => array('Costa Rican Colon', '188'),
                    'HRK' => array('Croatia Kuna', '191'),
                    'CPY' => array('Cypriot Pounds', '196'),
                    'CZK' => array('Czech Koruna', '203'),
                    'DKK' => array('Danish Krone', '208'),
                    'DOP' => array('Dominican Republic Peso', '214'),
                    'XCD' => array('East Caribbean Dollar', '951'),
                    'EGP' => array('Egyptian Pound', '818'),
                    'ERN' => array('Eritrean Nakfa', '232'),
                    'EEK' => array('Estonia Kroon', '233'),
                    'EUR' => array('Euro', '978'),
                    'GEL' => array('Georgian Lari', '981'),
                    'GHC' => array('Ghana Cedi', '288'),
                    'GIP' => array('Gibraltar Pound', '292'),
                    'GTQ' => array('Guatemala Quetzal', '320'),
                    'HNL' => array('Honduras Lempira', '340'),
                    'HKD' => array('Hong Kong Dollars', '344'),
                    'HUF' => array('Hungary Forint', '348'),
                    'ISK' => array('Icelandic Krona', '352'),
                    'INR' => array('Indian Rupee', '356'),
                    'IDR' => array('Indonesia Rupiah', '360'),
                    'ILS' => array('Israel Shekel', '376'),
                    'JMD' => array('Jamaican Dollar', '388'),
                    'JPY' => array('Japanese yen', '392'),
                    'KZT' => array('Kazakhstan Tenge', '368'),
                    'KES' => array('Kenyan Shilling', '404'),
                    'KWD' => array('Kuwaiti Dinar', '414'),
                    'LVL' => array('Latvia Lat', '428'),
                    'LBP' => array('Lebanese Pound', '422'),
                    'LTL' => array('Lithuania Litas', '440'),
                    'MOP' => array('Macau Pataca', '446'),
                    'MKD' => array('Macedonian Denar', '807'),
                    'MGA' => array('Malagascy Ariary', '969'),
                    'MYR' => array('Malaysian Ringgit', '458'),
                    'MTL' => array('Maltese Lira', '470'),
                    'BAM' => array('Marka', '977'),
                    'MUR' => array('Mauritius Rupee', '480'),
                    'MXN' => array('Mexican Pesos', '484'),
                    'MZM' => array('Mozambique Metical', '508'),
                    'NPR' => array('Nepalese Rupee', '524'),
                    'ANG' => array('Netherlands Antilles Guilder', '532'),
                    'TWD' => array('New Taiwanese Dollars', '901'),
                    'NZD' => array('New Zealand Dollars', '554'),
                    'NIO' => array('Nicaragua Cordoba', '558'),
                    'NGN' => array('Nigeria Naira', '566'),
                    'KPW' => array('North Korean Won', '408'),
                    'NOK' => array('Norwegian Krone', '578'),
                    'OMR' => array('Omani Riyal', '512'),
                    'PKR' => array('Pakistani Rupee', '586'),
                    'PYG' => array('Paraguay Guarani', '600'),
                    'PEN' => array('Peru New Sol', '604'),
                    'PHP' => array('Philippine Pesos', '608'),
                    'QAR' => array('Qatari Riyal', '634'),
                    'RON' => array('Romanian New Leu', '946'),
                    'RUB' => array('Russian Federation Ruble', '643'),
                    'SAR' => array('Saudi Riyal', '682'),
                    'CSD' => array('Serbian Dinar', '891'),
                    'SCR' => array('Seychelles Rupee', '690'),
                    'SGD' => array('Singapore Dollars', '702'),
                    'SKK' => array('Slovak Koruna', '703'),
                    'SIT' => array('Slovenia Tolar', '705'),
                    'ZAR' => array('South African Rand', '710'),
                    'KRW' => array('South Korean Won', '410'),
                    'LKR' => array('Sri Lankan Rupee', '144'),
                    'SRD' => array('Surinam Dollar', '968'),
                    'SEK' => array('Swedish Krona', '752'),
                    'CHF' => array('Swiss Francs', '756'),
                    'TZS' => array('Tanzanian Shilling', '834'),
                    'THB' => array('Thai Baht', '764'),
                    'TTD' => array('Trinidad and Tobago Dollar', '780'),
                    'TRY' => array('Turkish New Lira', '949'),
                    'AED' => array('UAE Dirham', '784'),
                    'USD' => array('US Dollars', '840'),
                    'UGX' => array('Ugandian Shilling', '800'),
                    'UAH' => array('Ukraine Hryvna', '980'),
                    'UYU' => array('Uruguayan Peso', '858'),
                    'UZS' => array('Uzbekistani Som', '860'),
                    'VEB' => array('Venezuela Bolivar', '862'),
                    'VND' => array('Vietnam Dong', '704'),
                    'AMK' => array('Zambian Kwacha', '894'),
                    'ZWD' => array('Zimbabwe Dollar', '716'));
                $columnName = explode("," , $getPlaceholderDetails[0]['Columns']);
                foreach($columnName as $key => $val){
                    $columnName[$val] = '';
                    unset($columnName[$key]);
                }
                $getAllPaymentCustomer = self::getAllPaymentCustomer();
                
                View::render('administrator/pageaccess/update_payment.php', ['columnName' => $columnName, 'getAllPaymentCustomer'=> $getAllPaymentCustomer, 'pId' =>  $placeholderId , 'action' => $_REQUEST['action'] , 'currencyCode' => $ISOCurCode]);

            }

            
        }else if ($_REQUEST['action'] == 'edit'){

            $ISOCurCode = array('AFA' => array('Afghan Afghani', '971'),
            'AWG' => array('Aruban Florin', '533'),
            'AUD' => array('Australian Dollars', '036'),
            'ARS' => array('Argentine Pes', '032'),
            'AZN' => array('Azerbaijanian Manat', '944'),
            'BSD' => array('Bahamian Dollar', '044'),
            'BDT' => array('Bangladeshi Taka', '050'),
            'BBD' => array('Barbados Dollar', '052'),
            'BYR' => array('Belarussian Rouble', '974'),
            'BOB' => array('Bolivian Boliviano', '068'),
            'BRL' => array('Brazilian Real', '986'),
            'GBP' => array('British Pounds Sterling', '826'),
            'BGN' => array('Bulgarian Lev', '975'),
            'KHR' => array('Cambodia Riel', '116'),
            'CAD' => array('Canadian Dollars', '124'),
            'KYD' => array('Cayman Islands Dollar', '136'),
            'CLP' => array('Chilean Peso', '152'),
            'CNY' => array('Chinese Renminbi Yuan', '156'),
            'COP' => array('Colombian Peso', '170'),
            'CRC' => array('Costa Rican Colon', '188'),
            'HRK' => array('Croatia Kuna', '191'),
            'CPY' => array('Cypriot Pounds', '196'),
            'CZK' => array('Czech Koruna', '203'),
            'DKK' => array('Danish Krone', '208'),
            'DOP' => array('Dominican Republic Peso', '214'),
            'XCD' => array('East Caribbean Dollar', '951'),
            'EGP' => array('Egyptian Pound', '818'),
            'ERN' => array('Eritrean Nakfa', '232'),
            'EEK' => array('Estonia Kroon', '233'),
            'EUR' => array('Euro', '978'),
            'GEL' => array('Georgian Lari', '981'),
            'GHC' => array('Ghana Cedi', '288'),
            'GIP' => array('Gibraltar Pound', '292'),
            'GTQ' => array('Guatemala Quetzal', '320'),
            'HNL' => array('Honduras Lempira', '340'),
            'HKD' => array('Hong Kong Dollars', '344'),
            'HUF' => array('Hungary Forint', '348'),
            'ISK' => array('Icelandic Krona', '352'),
            'INR' => array('Indian Rupee', '356'),
            'IDR' => array('Indonesia Rupiah', '360'),
            'ILS' => array('Israel Shekel', '376'),
            'JMD' => array('Jamaican Dollar', '388'),
            'JPY' => array('Japanese yen', '392'),
            'KZT' => array('Kazakhstan Tenge', '368'),
            'KES' => array('Kenyan Shilling', '404'),
            'KWD' => array('Kuwaiti Dinar', '414'),
            'LVL' => array('Latvia Lat', '428'),
            'LBP' => array('Lebanese Pound', '422'),
            'LTL' => array('Lithuania Litas', '440'),
            'MOP' => array('Macau Pataca', '446'),
            'MKD' => array('Macedonian Denar', '807'),
            'MGA' => array('Malagascy Ariary', '969'),
            'MYR' => array('Malaysian Ringgit', '458'),
            'MTL' => array('Maltese Lira', '470'),
            'BAM' => array('Marka', '977'),
            'MUR' => array('Mauritius Rupee', '480'),
            'MXN' => array('Mexican Pesos', '484'),
            'MZM' => array('Mozambique Metical', '508'),
            'NPR' => array('Nepalese Rupee', '524'),
            'ANG' => array('Netherlands Antilles Guilder', '532'),
            'TWD' => array('New Taiwanese Dollars', '901'),
            'NZD' => array('New Zealand Dollars', '554'),
            'NIO' => array('Nicaragua Cordoba', '558'),
            'NGN' => array('Nigeria Naira', '566'),
            'KPW' => array('North Korean Won', '408'),
            'NOK' => array('Norwegian Krone', '578'),
            'OMR' => array('Omani Riyal', '512'),
            'PKR' => array('Pakistani Rupee', '586'),
            'PYG' => array('Paraguay Guarani', '600'),
            'PEN' => array('Peru New Sol', '604'),
            'PHP' => array('Philippine Pesos', '608'),
            'QAR' => array('Qatari Riyal', '634'),
            'RON' => array('Romanian New Leu', '946'),
            'RUB' => array('Russian Federation Ruble', '643'),
            'SAR' => array('Saudi Riyal', '682'),
            'CSD' => array('Serbian Dinar', '891'),
            'SCR' => array('Seychelles Rupee', '690'),
            'SGD' => array('Singapore Dollars', '702'),
            'SKK' => array('Slovak Koruna', '703'),
            'SIT' => array('Slovenia Tolar', '705'),
            'ZAR' => array('South African Rand', '710'),
            'KRW' => array('South Korean Won', '410'),
            'LKR' => array('Sri Lankan Rupee', '144'),
            'SRD' => array('Surinam Dollar', '968'),
            'SEK' => array('Swedish Krona', '752'),
            'CHF' => array('Swiss Francs', '756'),
            'TZS' => array('Tanzanian Shilling', '834'),
            'THB' => array('Thai Baht', '764'),
            'TTD' => array('Trinidad and Tobago Dollar', '780'),
            'TRY' => array('Turkish New Lira', '949'),
            'AED' => array('UAE Dirham', '784'),
            'USD' => array('US Dollars', '840'),
            'UGX' => array('Ugandian Shilling', '800'),
            'UAH' => array('Ukraine Hryvna', '980'),
            'UYU' => array('Uruguayan Peso', '858'),
            'UZS' => array('Uzbekistani Som', '860'),
            'VEB' => array('Venezuela Bolivar', '862'),
            'VND' => array('Vietnam Dong', '704'),
            'AMK' => array('Zambian Kwacha', '894'),
            'ZWD' => array('Zimbabwe Dollar', '716'));
            $placeholderId = (isset($_REQUEST['placeholderId'])) ? $_REQUEST['placeholderId'] : "1607";
            
            $getPlaceholderDetails = Page::getDatasourceTableDetails($placeholderId);
            $formData = Page::getDynamicFormData($getPlaceholderDetails[0]['DynamicFormName']);
            $getAllPaymentCustomer = array();
            $getMandateType = array();
            $detail = json_decode($formData[0]['DetailColumns'] , true);
            $getAllAbsenceReasons = '';
            $getAllActivity = '';
            $actionBTns = '';
            $actionURL = '';
        
            if(strpos($formData[0]['ActionButton'] , 'http://212.247.32.103:8082/') !== false){
                $tempUrl = explode('public/' , $formData[0]['ActionButton']);
                $formData[0]['ActionButton'] = $currentUrl.'/'.'public/'.end($tempUrl);
                
            }else{
                $formData[0]['ActionButton'] = $currentUrl.'/'.'public/'.$formData[0]['ActionButton'];
            }
          
            $actionBTns = $formData[0]['ActionButton'].'?placeholderId='.$placeholderId;
        
            $columnName = explode("," , $getPlaceholderDetails[0]['Columns']);
            foreach($columnName as $key => $val){
                if(isset($_REQUEST['data'][$key])){
                    $val = trim($val);
                    $columnName[$val] = $_REQUEST['data'][$key] ;
                }else{
                    $val = trim($val);
                    $columnName[$val] = '';
                }
                
                unset($columnName[$key]);
            }
            $getAllPaymentCustomer = self::getAllPaymentCustomer();
            $getMandateType = array('FRST' , 'RCUR', 'OOFF' , 'FNAL');
             
            foreach($detail as $key => $val){
                
                if(isset($val['fetchDataFrom'])){
                    if($val['fetchDataFrom'] == 'getAllAbsenceReasons'){
                        $getAllAbsenceReasons = self::getAllAbsenceReasons();
                    }elseif($val['fetchDataFrom'] == 'getAllActivity'){
                        $getAllActivity = self::getAllActivity();

                    }
                }
            }
            $Btn  = isset($_REQUEST['LSearch'])? $_REQUEST['LSearch']:0;
                
            $getAllPaymentCustomer = self::getAllPaymentCustomer();
            $pageDesign  = isset($_REQUEST['DID'])? $_REQUEST['DID']:$formData[0]['DesignType'];
            //View::render('administrator/pageaccess/update_payment.php', ['columnName' => $columnName, 'getAllPaymentCustomer'=> $getAllPaymentCustomer, 'pId' =>  $placeholderId , 'action' => $_REQUEST['action'] , 'currencyCode' => $ISOCurCode]);
           
            View::render('administrator/pageaccess/dynamic_form.php', ['columnName' => $columnName, 'ActionURL' => $actionURL , 'lSearch' => $Btn , 'getAllActivity'=> $getAllActivity, 'getAllAbsenceReasons'=> $getAllAbsenceReasons ,'AllReadOnly'=> $formData[0]['AllReadOnly'] , 'actionButton'=> $actionBTns , 'PageDesign'=>$pageDesign  , 'DetailColumns' => $formData[0]['DetailColumns'], 'HiddenColumns' => $formData[0]['HiddenColumns'], 'pId' =>  $placeholderId , 'action' => $_REQUEST['action'] , 'getISOCurCode' => $ISOCurCode , 'getMandateType' => $getMandateType , 'getAllPaymentCustomer'=> $getAllPaymentCustomer ]);

        }
       

    }
    // This function return the payment Customer
    public static function getAllPaymentCustomer(){
        // Variable declaration 
        
        $responnse = array();
        $responnse['status'] = true;
        // fetch data Sources 
        $query = "SELECT * FROM PaymentCustomer ";
        $getAllPaymentCustomer =  User::executeQuery($query, $_SESSION['BPDB'],'');
        return $getAllPaymentCustomer;


     }
       // This function return the data source  
    public static function getSpecficPaymentCustomer(){
        $val = $_POST['AccID'];
        $query = "SELECT DebtorName, CustomerIBANNumber as Customer_IBAN, CustomerBICNumber as Customer_BIC , Mandate_Type ,  Mandate_Reference FROM PaymentCustomer where AccountNumber = '" .$val. "'";
        $getAllPaymentCustomer =  User::executeQuery($query, $_SESSION['BPDB'],'');
        $retVal['data'] = $getAllPaymentCustomer;
        echo json_encode($retVal);
        exit;

     }
     public static function getAllAbsenceReasons(){
         $arr = [ 
            'Semester','VAB','Läkarbesök','Sjuk', 'Pappaledig 10 dgr vid födsel', 'Föräldraledig','Tjänstledig',
            'Nyårsdagen', 'Trettondagen','Långfredagen','Annandag påsk', 'Första maj','Kristi Himmelfärd','Nationaldagen',
            'Midsommarafton','Alla Helgons dag','Julafton','Juldagen','Annandag jul','Nyårsafton'];
        return $arr;
     }
     public static function getAllActivity(){
        $arr =[
            '*** Mot kund (Välj ej, endast rubrik)','Debiteras, arbete mot kund','Ej debiteras, arbete mot kund','Debiteras, restid',
            'Kanske debiteras (Kundansvarig avgör)','***Kam, sälj, verksam.rel. mot uppdrag, egna produkter (Välj ej, endast rubrik)',
            'KAM, KUM, Sälj (proaktivitet)','GCS-relaterad verksamhet, mot uppdrag','Arbete med egna produkter (BP, Babc, BL o dylikt)',
            '***Ledning, LG,OPLF,CFO, övrigt (Välj ej, endast rubrik)','Ledning t.ex. LG,OPLG, CFO, ägare & styrelse',
            'Övrigt GCS ( tidredov, fakturering, utbildn. o dylikt)', 'Övrigt GCS om ej med ovan, används sparsamt (Utförlig text i kommentarsfältet)',
            '***Frånvaro (Välj ej, endast rubrik)','Frånvaro'];
        return $arr;
     }
}