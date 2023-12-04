<?php
// this file is not USed its the first Cron .

       $DBName = 'BP_SelectedBrands';
       $DBPass = 'gcsmakeit2010';
       $DBUsername = 'jeff';
       $DBHost = '10.30.57.5';
       $db = new PDO("sqlsrv:Server=$DBHost;Database=$DBName;", "$DBUsername", "$DBPass");

    // Throw an Exception when an error occurs
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $_arrayList = array('ResultList');
    $headerColumnName = array (
        
        array('id',	'gtin','item_group_id',	'brand',	'title',	'product_type',	'gender',
            'color' ,	'size'	,'image_link', 'additional_image_link', 'c:stock_level:integer'	,'desrciption	material'	,
            'c:retail_price_StandardPrice:integer' ,
            'c:retail_price_PurchasePrice:integer' ,
            'c:retail_price_price_sek_pre:integer' ,
            'c:retail_price_price_sek_after:integer' ,
            'c:retail_price_price_sek_consumer:integer' ,
            'c:retail_price_price_dkk_pre:integer' ,
            'c:retail_price_price_dkk_after:integer' ,
            'c:retail_price_price_dkk_consumer:integer' ,
            'c:retail_price_price_nok_pre:integer' ,
            'c:retail_price_price_nok_after:integer' ,
            'c:retail_price_price_nok_consumer:integer' ,
            'c:retail_price_price_eur_pre:integer' ,
            'c:retail_price_price_eur_after:integer' ,
            'c:retail_price_price_eur_consumer:integer' 
    ));
    
    $fp = fopen('SV_TSV.tsv', 'wb');
   
    foreach ($headerColumnName as $fields) {
       
        fwrite($fp, implode("\t", $fields));
        fwrite($fp, "\n");
            //fputcsv($fp, $fields);
    }

    $results = array();
    $requestBody = '{
        "AddSideTableData": true,
       "FieldFilter": "SES>=203;SES<=213",
       "FieldList": ["ProductNo", "Description", "Category", "StandardPrice", "HVL", "MVL", "VariantCode", "AmountPerUnit", "CountryOfOrigin", "SupplierNo", "SuppliersProductNo", "PurchaseCurrencyCode", "Weight", "Volyme", "Code1", "Code5", "Code6", "PurchasePrice", "Season", "DeliveryCode", "ProductText", "ProductGroup3",  "Quantity","OrderNo"],
       "Index": 1,
       "IndexFilter": "1017715KBLK",
       "OGAFilter": "",
       "ReadCount":0,
       "ReturnCount": 0,
       "IncludeSpecialSelectedPrices":true,
       "ReverseReading": false  
    }';
    
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_NOBODY, false);
    curl_setopt($ch, CURLOPT_URL, 'http://176.10.244.90:55562/GIS/v2/BPProductSvc/REST/GetProductDynamicList/000');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
        
    //curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $results = curl_exec($ch);
    
    $apiData = [];
    if ($results) {
        $decodedResults = json_decode($results, true);
        $apiData = $decodedResults;

        if ($decodedResults) {
            foreach ($_arrayList as $key) {
                if (isset($decodedResults[$key])) {
                    $apiData = $decodedResults[$key];
                    break;
                }
            }
        }
    }
    $img = array();
    foreach ($apiData as $key => $value) {

        $sql = "SELECT * FROM ProductImages where ProductNo = '".$value['ProductNo']."'";
        // Excute Query 
        $stmt = $db->query($sql);
        // Fetch All data 
        $data = $stmt->fetchAll();
       if(empty($img)){
            $img = explode(',' , $data[0]['ImageURL'] ) ;
            $imageLink = $img[0];
            unset( $img[0]);
            $additionalImgLink = implode(',' , $img );
       }
       

        fwrite($fp, $value['ProductNo'] );
        fwrite($fp, "\t");
 fwrite($fp, $value['ProductText'][12]['Value'] );
        fwrite($fp, "\t");
 fwrite($fp, $value['Category'] );
        fwrite($fp, "\t");
 fwrite($fp, $value['DeliveryCode'] );
        fwrite($fp, "\t");
 fwrite($fp, $value['Description'] );
        fwrite($fp, "\t");
 fwrite($fp, $value['Category'] );
        fwrite($fp, "\t");
 fwrite($fp, $value['Category'] );
        fwrite($fp, "\t");
 fwrite($fp, $value['ProductText'][0]['Value'] );
        fwrite($fp, "\t");
 fwrite($fp, $value['DimensionCode'] );
        fwrite($fp, "\t");
 fwrite($fp, $imageLink );
        fwrite($fp, "\t");
 fwrite($fp, $additionalImgLink );
        fwrite($fp, "\t");
 fwrite($fp, $value['ProductGroup3'] );
        fwrite($fp, "\t");
 fwrite($fp," " );
        fwrite($fp, "\t");

 fwrite($fp, $value['StandardPrice'] );
        fwrite($fp, "\t");
 fwrite($fp, $value['PurchasePrice'] );
        fwrite($fp, "\t"); 
fwrite($fp, $value['price_sek_pre'] );
        fwrite($fp, "\t"); 
fwrite($fp, $value['price_sek_after'] );
        fwrite($fp, "\t"); 
fwrite($fp, $value['price_sek_consumer'] );
        fwrite($fp, "\t"); 
fwrite($fp, $value['price_dkk_pre'] );
        fwrite($fp, "\t"); 
fwrite($fp, $value['price_dkk_after'] );
        fwrite($fp, "\t"); 
fwrite($fp, $value['price_dkk_consumer'] );
        fwrite($fp, "\t"); 
fwrite($fp, $value['price_nok_pre'] );
        fwrite($fp, "\t"); 
fwrite($fp, $value['price_nok_after'] );
        fwrite($fp, "\t"); 
fwrite($fp, $value['price_nok_consumer'] );
        fwrite($fp, "\t");
 fwrite($fp, $value['price_eur_pre'] );
        fwrite($fp, "\t");
 fwrite($fp, $value['price_eur_pre'] );
        fwrite($fp, "\t"); 
fwrite($fp, $value['price_eur_consumer'] );
        fwrite($fp, "\t"); 
        fwrite($fp, "\n"); 
    }
    
    fclose($fp);
    print_r("success");
    exit;
    
    


?>