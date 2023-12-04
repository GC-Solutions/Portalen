<?php

ini_set('memory_limit', '200G');
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';
use EDI\Parser;
use EDI\Analyser;
use EDI\Mapping\MappingProvider;
use EDI\Reader;

set_time_limit(0);
// Memory Limit for the script 
ini_set('memory_limit', '2G');

$servers = array();
$servers[] = array('10.30.57.5', 'tieto',  't2022!!');
$servers[] = array( '10.30.57.5', 'menigo', 'm2022!!');

foreach($servers as $serverKey => $serverVal){

    $ftp = ftp_connect('10.30.57.5' );
    ftp_set_option($ftp, FTP_USEPASVADDRESS, false);
    $login_result = ftp_login($ftp, $serverVal[1], $serverVal[2]);
    ftp_pasv($ftp, true);
    $companies = ftp_nlist($ftp, ".");
    $currentDate = date("Y-m-d");
    if(!empty($companies)){
        foreach($companies as $cKey => $cVal){
            $cVal = explode('.', $cVal);
            $cVal = $cVal[1];
            $users = ftp_nlist($ftp,  $cVal);
            foreach($users as $uKey => $uVal){
                $folders = ftp_nlist($ftp,  $uVal);
                foreach($folders as $fKey => $fVal){
                    $contents = ftp_nlist($ftp, $fVal);
                    if(!empty($contents))
                    {
                        foreach($contents as $Key => $Val){
                            //$Val = explode('/', $Val);
                            //$Val =  end($Val);
                            
                            $filename = "ftp://".$serverVal[1].":".$serverVal[2]."@".$serverVal[0].$Val;
                            $lastchanged = ftp_mdtm($ftp, $Val);
                            
                            if ($lastchanged != -1)
                            {
                                if($currentDate == date("Y-m-d",$lastchanged)){
                                    
                                    $parser = new Parser($filename);
                                    $parsed = $parser->get();
                                    $segments = $parser->getRawSegments();
                                    $analyser = new Analyser();
                                    $mapping = new MappingProvider('D96A');
                                    $analyser->loadSegmentsXml($mapping->getSegments());
                                    $analyser->loadMessageXml($mapping->getMessage('coparn'));
                                    $analyser->loadCodesXml($mapping->getCodes());
                                    $analyser->directory = 'D96A';
                                    $result = $analyser->process($parsed, $segments);  
                                    $result = explode("'" , $result);
                    
                                    echo "<pre>";
                    
                                    $MainArr = array();
                                    for ($i=0; $i < count($result) ; $i++) { 
                                        if(strpos($result[$i] , 'UNA') === false){ 
                                            if(strpos($result[$i] , 'UNB') === false){ 
                                                if(strpos($result[$i] , 'UNH') === false){ 
                                                    
                                                    $val = explode("]" , $result[$i]);
                                                    $keyName = explode(" " , trim($val[0])) ; 
                                                    $keyName = $keyName[0];
                                                    $MainArr1 = array();
                                                    for ($j=1; $j < count($val) ; $j++) { 
                                                    
                                                        $valnew = explode(PHP_EOL , $val[$j]);
                                                    
                                                        for ($k=0; $k <= 1 ; $k++) { 
                                                            if(isset($valnew[$k])){
                                                                $valMain = explode(" " , trim($valnew[$k]));
                                                                $colVal = explode(" " , trim($valnew[0]));
                                                                if($k == 1) {
                                                                    $colName  = end($valMain);
                                                                    
                                                                    $MainArr1[$keyName][$colName] = trim($colVal[0]);
                                                                }
                                                            }
                                                        }
                                                    
                                                    }
                                                    $MainArr[]= $MainArr1;
                                                    
                                                }
                                            }
                                        }
                                    }
                                    print_r("------------------------------------------<br />");
                                    $Cname  = explode("/" , $cVal);
                                    $Uname = explode("/" , $uVal);
                                    $Foname  = explode("/" , $fVal);
                                    $Finame  = explode("/" , $Val);
                                    print_r("Company Name :  <b>". end($Cname) ."</b>");
                                    print_r("<br />User Name: <b>". end($Uname) ."</b>");
                                    print_r("<br />Folder Name: <b>". end($Foname) ."</b>");
                                    print_r("<br />File Name : <b>". end($Finame) ."</b>");
                                    print_r("<br />------------------------------------------<br />");
                                    
                                    $headerRow = array();
                                    $LineRows = array();

                                    if(end($Foname) == 'invoice'){ 
                                        $lineNum = 0;
                                        foreach($MainArr as $mainKey => $mainVal){
                                           
                                            if(is_array($mainVal)){
                                                foreach($mainVal as $mainKey1 => $mainVal1){
                                                    if($mainKey1 == 'BGM'){ 
                                                        if($mainVal1['documentmessageName'] == '380'){
                                                            $headerRow[0]['DocMsgID'] = $mainVal1['documentmessageNumber'];
                                                        }
                                                    }else if($mainKey1 == 'DTM'){ 
                                                        if($mainVal1['datetimeperiodQualifier'] == '137'){
                                                            $headerRow[0]['InvoiceDate'] = date("Y-m-d", strtotime($mainVal1['datetimeperiod']));
                                                            
                                                        }
                                                        if($mainVal1['datetimeperiodQualifier'] == '13'){
                                                            $headerRow[0]['PaymentDate'] = date("Y-m-d", strtotime($mainVal1['datetimeperiod']));
                                                        }
                                                    }else if($mainKey1 == 'RFF'){ 
                                                        if(!isset($mainVal1['lineNumber'])){ 
                                                            if($mainVal1['referenceQualifier'] == 'ON'){
                                                                $headerRow[0]['ReferenceNumber'] = $mainVal1['referenceNumber'];
                                                            }
                                                        }else{
                                                            if($mainVal1['referenceQualifier'] == 'ON'){
                                                                $LineRows[$lineNum]['ReferenceNumber'] = $mainVal1['referenceNumber'];
                                                                $LineRows[$lineNum]['ReferenceLineNumber'] = $mainVal1['lineNumber'];
                                                            }
                                                        }
                                                    }else if($mainKey1 == 'NAD'){ 
                                                        if($mainVal1['partyQualifier'] == 'BY'){
                                                            $headerRow[0]['BuyerNumber'] = $mainVal1['partyIdIdentification'];
                                                        }else if($mainVal1['partyQualifier'] == 'CN'){
                                                            $headerRow[0]['ConsigneeNumber'] = $mainVal1['partyIdIdentification'];
                                                        }
                                                    }
                                                    else if($mainKey1 == 'LIN'){ 
                                                        $lineNum = $lineNum + 1;
                                                        $LineRows[$lineNum]['LineNumber'] = $mainVal1['lineItemNumber'];
                                                        $LineRows[$lineNum]['ItemNumber'] = $mainVal1['itemNumber'];
                                                    } else if($mainKey1 == 'PIA'){ 
                                                        
                                                        $LineRows[$lineNum]['ProductAdditionalInfoItemNumber'] = $mainVal1['itemNumber'];
                                                        
                                                    } else if($mainKey1 == 'QTY'){ 
                                                        
                                                        $LineRows[$lineNum]['Quantity'] = $mainVal1['quantity'];
                                                        
                                                    } else if($mainKey1 == 'MOA'){ 
                                                        if($mainVal1['monetaryAmountTypeQualifier']== '203'){ 
                                                            $LineRows[$lineNum]['MonetaryAmount'] = $mainVal1['monetaryAmount'];
                                                        } 
                                                        
                                                    }else if($mainKey1 == 'PRI'){ 
                                                        $LineRows[$lineNum]['Price'] = $mainVal1['price'];
                                                       
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    else if(end($Foname) == 'order'){ 
                                        $lineNum = 0;
                                        foreach($MainArr as $mainKey => $mainVal){
                                           
                                            if(is_array($mainVal)){
                                                foreach($mainVal as $mainKey1 => $mainVal1){
                                                    
                                                    if($mainKey1 == 'BGM'){ 
                                                        if($mainVal1['documentmessageName'] == '220'){
                                                            $headerRow[0]['OrderDocMsgID'] = $mainVal1['documentmessageNumber'];
                                                        }
                                                    }else if($mainKey1 == 'DTM'){ 
                                                        if($mainVal1['datetimeperiodQualifier'] == '137'){
                                                            $headerRow[0]['OrderDate'] = date("Y-m-d", strtotime($mainVal1['datetimeperiod']));
                                                        }
                                                        if($mainVal1['datetimeperiodQualifier'] == '2'){
                                                            $headerRow[0]['DeliveryDate'] = date("Y-m-d", strtotime($mainVal1['datetimeperiod']));
                                                        }
                                                    
                                                    }else if($mainKey1 == 'NAD'){ 
                                                        if($mainVal1['partyQualifier'] == 'BY'){
                                                            $headerRow[0]['OrderBuyerNumber'] = $mainVal1['partyIdIdentification'];
                                                        }else if($mainVal1['partyQualifier'] == 'CN'){
                                                            $headerRow[0]['OrderConsigneeNumber'] = $mainVal1['partyIdIdentification'];
                                                        }
                                                    }
                                                    else if($mainKey1 == 'LIN'){ 
                                                        $lineNum = $lineNum + 1;
                                                        $LineRows[$lineNum]['OrderLineNumber'] = $mainVal1['lineItemNumber'];
                                                        $LineRows[$lineNum]['OrderItemNumber'] = $mainVal1['itemNumber'];
                                                    } else if($mainKey1 == 'PIA'){ 
                                                        $LineRows[$lineNum]['OrderProductAdditionalInfoItemNumber'] = $mainVal1['itemNumber'];
                                                    } else if($mainKey1 == 'QTY'){ 
                                                        $LineRows[$lineNum]['OrderQuantity'] = $mainVal1['quantity'];
                                                        
                                                    } 
                                                }
                                            }
                                        } 
                                    }
                                    
                                    $db = new PDO("sqlsrv:Server=10.30.57.5;Database=BP_Saljpartner;", "jeff", "gcsmakeit2010");
                                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                    if(!empty($headerRow)){
                                        if(end($Foname) == 'order'){
                                            foreach ($headerRow as $headerRowKey => $headerRowValue) {
                                
                                                $sql = "INSERT INTO  EdiFactOrderHead (OrderDocMsgID, OrderDate , OrderBuyerNumber ,OrderConsigneeNumber , DeliveryDate )
                                                        VALUES (:OrderDocMsgID, :OrderDate , :OrderBuyerNumber , :OrderConsigneeNumber , :DeliveryDate )";
                    
                                                    
                                                    $stmt = $db->prepare($sql);
                                                   
                                                    $stmt->bindParam(':OrderDocMsgID', $headerRowValue['OrderDocMsgID'] ,  PDO::PARAM_STR);
                                                    $stmt->bindParam(':OrderDate', $headerRowValue['OrderDate'] ,  PDO::PARAM_STR);
                                                    $stmt->bindParam(':OrderBuyerNumber', $headerRowValue['OrderBuyerNumber'] ,  PDO::PARAM_STR);
                                                    $stmt->bindParam(':OrderConsigneeNumber', $headerRowValue['OrderConsigneeNumber'] ,  PDO::PARAM_STR);
                                                    $stmt->bindParam(':DeliveryDate', $headerRowValue['DeliveryDate'] ,  PDO::PARAM_STR);
                                                    
                                                    $stmt->execute();
                    
                                            }
                                        }else if(end($Foname) == 'invoice'){
                                            foreach ($headerRow as $headerRowKey => $headerRowValue) {
                                
                                                $sql = "INSERT INTO  EdiFactInvoiceHead (DocMsgID, InvoiceDate , ReferenceNumber ,BuyerNumber , ConsigneeNumber , PaymentDate )
                                                        VALUES (:DocMsgID, :InvoiceDate , :ReferenceNumber , :BuyerNumber , :ConsigneeNumber , :PaymentDate )";
                    
                                                    
                                                    $stmt = $db->prepare($sql);
                                                   
                                                    $stmt->bindParam(':DocMsgID', $headerRowValue['DocMsgID'] ,  PDO::PARAM_STR);
                                                    $stmt->bindParam(':InvoiceDate', $headerRowValue['InvoiceDate'] ,  PDO::PARAM_STR);
                                                    $stmt->bindParam(':ReferenceNumber', $headerRowValue['ReferenceNumber'] ,  PDO::PARAM_STR);
                                                    $stmt->bindParam(':BuyerNumber', $headerRowValue['BuyerNumber'] ,  PDO::PARAM_STR);
                                                    $stmt->bindParam(':ConsigneeNumber', $headerRowValue['ConsigneeNumber'] ,  PDO::PARAM_STR);
                                                    $stmt->bindParam(':PaymentDate', $headerRowValue['PaymentDate'] ,  PDO::PARAM_STR);
                                                  
                                                    $stmt->execute();
                    
                                            }
                                        }
                                       
                                    }
                                    if(!empty($LineRows)){
                                        if(end($Foname) == 'order'){
                                            foreach ($LineRows as $LineRowsKey => $LineRowsValue) {
                                                
                                                $sql = "INSERT INTO EdiFactOrderRows (OrderLineNumber, OrderItemNumber , OrderProductAdditionalInfoItemNumber ,OrderQuantity )
                                                        VALUES (:OrderLineNumber, :OrderItemNumber , :OrderProductAdditionalInfoItemNumber , :OrderQuantity  )";
                    
                                                    $stmt = $db->prepare($sql);
                                                   
                                                    $stmt->bindParam(':OrderLineNumber', $LineRowsValue['OrderLineNumber'] ,  PDO::PARAM_STR);
                                                    $stmt->bindParam(':OrderItemNumber', $LineRowsValue['OrderItemNumber'] ,  PDO::PARAM_STR);
                                                    $stmt->bindParam(':OrderProductAdditionalInfoItemNumber', $LineRowsValue['OrderProductAdditionalInfoItemNumber'] ,  PDO::PARAM_STR);
                                                    $stmt->bindParam(':OrderQuantity', $LineRowsValue['OrderQuantity'] ,  PDO::PARAM_STR);
                                                   
                                                    $stmt->execute();
                    
                                            }
                                        }else if(end($Foname) == 'invoice'){
                                            foreach ($LineRows as $LineRowsKey => $LineRowsValue) {
                                               
                                                $sql = "INSERT INTO  EdiFactInvoiceRows (LineNumber, ItemNumber , ProductAdditionalInfoItemNumber ,Quantity , MonetaryAmount , Price , ReferenceNumber, ReferenceLineNumber)
                                                        VALUES (:LineNumber, :ItemNumber , :ProductAdditionalInfoItemNumber , :Quantity , :MonetaryAmount , :Price , :ReferenceNumber, :ReferenceLineNumber )";
                    
                                                    $stmt = $db->prepare($sql);

                                                    $stmt->bindParam(':LineNumber', $LineRowsValue['LineNumber'] ,  PDO::PARAM_STR);
                                                    $stmt->bindParam(':ItemNumber', $LineRowsValue['ItemNumber'] ,  PDO::PARAM_STR);
                                                    $stmt->bindParam(':ProductAdditionalInfoItemNumber', $LineRowsValue['ProductAdditionalInfoItemNumber'] ,  PDO::PARAM_STR);
                                                    $stmt->bindParam(':Quantity', $LineRowsValue['Quantity'] ,  PDO::PARAM_STR);
                                                    $stmt->bindParam(':MonetaryAmount', $LineRowsValue['MonetaryAmount'] ,  PDO::PARAM_STR);
                                                    $stmt->bindParam(':Price', $LineRowsValue['Price'] ,  PDO::PARAM_STR);
                                                    $stmt->bindParam(':ReferenceNumber', $LineRowsValue['ReferenceNumber'] ,  PDO::PARAM_STR);
                                                    $stmt->bindParam(':ReferenceLineNumber', $LineRowsValue['ReferenceLineNumber'] ,  PDO::PARAM_STR);
                                                    $stmt->execute();
                    
                                            }
                                        }
                                    }
                                   
                                        
                                
                                }else{
                                    echo "not Uploaded today ";
                                }
                            }
                            else
                            {
                                echo "Could not get last modified";
                            }
                            
                        }
                       
                    }
                    
                }
                
            }
            
        
        }
    }
}


?>