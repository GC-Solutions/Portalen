<?php

// This File is cron that update Products table on daily base.
ini_set('memory_limit', '200G');
ini_set('display_errors', 1);
error_reporting(E_ALL);

     $_arrayList = array('ResultList');
      $retval = array();

		$results = array();
		    $requestBody = '{
                              "AddSideTableData": true,
                             "FieldFilter": "SES>=203;SES<=213",
                             "FieldList": ["ProductNo", "Description", "Category", "StandardPrice", "HVL", "MVL", "VariantCode", "AmountPerUnit", "CountryOfOrigin", "SupplierNo", "SuppliersProductNo", "PurchaseCurrencyCode", "Weight", "Volyme", "Code1", "Code5", "Code6", "PurchasePrice", "Season", "DeliveryCode", "ProductText"],
                             "Index": 1,
                             "IndexFilter": "",
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
         
            $DBName = 'BP_SelectedBrands';
			$db = new PDO("sqlsrv:Server=212.247.32.103;Database=BP_SelectedBrands;", "jeff", "gcsmakeit2010");

	        // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $sql = "TRUNCATE TABLE Products";
	        $q = $db->prepare($sql);
	        $q->execute();

        	// Add the record 
			foreach ($apiData as $apiDataKey => $apiDataValue) {

				$sql = "INSERT INTO Products(ProductNo,Description,Category,StandardPrice,HVL,MVL,VariantCode,AmountPerUnit,CountryOfOrigin,SupplierNo,SuppliersProductNo,PurchaseCurrencyCode,Weight,Volyme,Code5,Code6,PurchasePrice,Season,DeliveryCode,CategoryDescription,VariantDescription,VariantNo,DimensionDescription,DimensionCode,price_sek_pre,price_sek_after,price_sek_consumer,price_dkk_pre,price_dkk_after,price_dkk_consumer,price_nok_pre,price_nok_after,price_nok_consumer,price_eur_pre,price_eur_after,price_eur_consumer,TX1,TX2,TX3,TX4,TX5,TX6,TX7,TX8,TX9,TX10,TX11,TX12,TX13,TX14,TX15,ModelAndVariantNo,ModelNo , Code1 , SKU , Quantity , PackType)
				VALUES (:ProductNo,:Description,:Category,:StandardPrice,:HVL,:MVL,:VariantCode,:AmountPerUnit,:CountryOfOrigin,:SupplierNo,:SuppliersProductNo,:PurchaseCurrencyCode,:Weight,:Volyme,:Code5,:Code6,:PurchasePrice,:Season,:DeliveryCode,:CategoryDescription,:VariantDescription,:VariantNo,:DimensionDescription,:DimensionCode,:price_sek_pre,:price_sek_after,:price_sek_consumer,:price_dkk_pre,:price_dkk_after,:price_dkk_consumer,:price_nok_pre,:price_nok_after,:price_nok_consumer,:price_eur_pre,:price_eur_after,:price_eur_consumer,:TX1,:TX2,:TX3,:TX4,:TX5,:TX6,:TX7,:TX8,:TX9,:TX10,:TX11,:TX12,:TX13,:TX14,:TX15,:ModelAndVariantNo,:ModelNo , :Code1 ,  :SKU , :Quantity , :PackType)";
							       
		        $stmt = $db->prepare($sql);

		        $stmt->bindParam(':ProductNo', $apiDataValue['ProductNo'], PDO::PARAM_STR);
		        $stmt->bindParam(':Description', $apiDataValue['Description'], PDO::PARAM_STR);
		        $stmt->bindParam(':Category', $apiDataValue['Category'] , PDO::PARAM_STR);
		        $stmt->bindParam(':StandardPrice', $apiDataValue['StandardPrice'] , PDO::PARAM_STR);
		       	$stmt->bindParam(':HVL', $apiDataValue['HVL'] , PDO::PARAM_STR);
		        $stmt->bindParam(':MVL', $apiDataValue['MVL'] , PDO::PARAM_STR);
		        $stmt->bindParam(':VariantCode', $apiDataValue['VariantCode'] , PDO::PARAM_STR);
		        $stmt->bindParam(':AmountPerUnit', $apiDataValue['AmountPerUnit'] , PDO::PARAM_STR);
		        $stmt->bindParam(':CountryOfOrigin', $apiDataValue['CountryOfOrigin'] , PDO::PARAM_STR);
		        $stmt->bindParam(':SupplierNo', $apiDataValue['SupplierNo'] , PDO::PARAM_STR);
		        $stmt->bindParam(':SuppliersProductNo', $apiDataValue['SuppliersProductNo'] , PDO::PARAM_STR);
		        $stmt->bindParam(':PurchaseCurrencyCode', $apiDataValue['PurchaseCurrencyCode'] , PDO::PARAM_STR);
		        $stmt->bindParam(':Weight', $apiDataValue['Weight'] , PDO::PARAM_STR);
		        $stmt->bindParam(':Volyme', $apiDataValue['Volyme'] , PDO::PARAM_STR);
		        $stmt->bindParam(':Code5', $apiDataValue['Code5'] , PDO::PARAM_STR);
		        $stmt->bindParam(':Code6', $apiDataValue['Code6'] , PDO::PARAM_STR);
		        $stmt->bindParam(':PurchasePrice', $apiDataValue['PurchasePrice'] , PDO::PARAM_STR);
		        $stmt->bindParam(':Season', $apiDataValue['Season'] , PDO::PARAM_STR);
		        $stmt->bindParam(':DeliveryCode', $apiDataValue['DeliveryCode'] , PDO::PARAM_STR);
		        $stmt->bindParam(':CategoryDescription', $apiDataValue['CategoryDescription'] , PDO::PARAM_STR);
		        $stmt->bindParam(':VariantDescription', $apiDataValue['VariantDescription'] , PDO::PARAM_STR);
		        $stmt->bindParam(':VariantNo', $apiDataValue['VariantNo'] , PDO::PARAM_STR);
		        $stmt->bindParam(':DimensionDescription', $apiDataValue['DimensionDescription'] , PDO::PARAM_STR);
		        $stmt->bindParam(':DimensionCode', $apiDataValue['DimensionCode'] , PDO::PARAM_STR);
		        $stmt->bindParam(':price_sek_pre', $apiDataValue['price_sek_pre'] , PDO::PARAM_STR);
		        $stmt->bindParam(':price_sek_after', $apiDataValue['price_sek_after'] , PDO::PARAM_STR);
		        $stmt->bindParam(':price_sek_consumer', $apiDataValue['price_sek_consumer'] , PDO::PARAM_STR);
		        $stmt->bindParam(':price_dkk_pre', $apiDataValue['price_dkk_pre'] , PDO::PARAM_STR);
		        $stmt->bindParam(':price_dkk_after', $apiDataValue['price_dkk_after'] , PDO::PARAM_STR);
		        $stmt->bindParam(':price_dkk_consumer', $apiDataValue['price_dkk_consumer'] , PDO::PARAM_STR);
		        $stmt->bindParam(':price_nok_pre', $apiDataValue['price_nok_pre'] , PDO::PARAM_STR);
		        $stmt->bindParam(':price_nok_after', $apiDataValue['price_nok_after'] , PDO::PARAM_STR);
		        $stmt->bindParam(':price_nok_consumer', $apiDataValue['price_nok_consumer'] , PDO::PARAM_STR);
		        $stmt->bindParam(':price_eur_pre', $apiDataValue['price_eur_pre'] , PDO::PARAM_STR);
		        $stmt->bindParam(':price_eur_after', $apiDataValue['price_eur_after'] , PDO::PARAM_STR);
		        $stmt->bindParam(':price_eur_consumer', $apiDataValue['price_eur_consumer'] , PDO::PARAM_STR);
		        $stmt->bindParam(':TX1', $apiDataValue['ProductText'][0]['Value'] , PDO::PARAM_STR);
		        $stmt->bindParam(':TX2', $apiDataValue['ProductText'][1]['Value'] , PDO::PARAM_STR);
			    $stmt->bindParam(':TX3', $apiDataValue['ProductText'][2]['Value'] , PDO::PARAM_STR);
				$stmt->bindParam(':TX4', $apiDataValue['ProductText'][3]['Value'] , PDO::PARAM_STR);
				$stmt->bindParam(':TX5', $apiDataValue['ProductText'][4]['Value'] , PDO::PARAM_STR);
				$stmt->bindParam(':TX6', $apiDataValue['ProductText'][5]['Value'] , PDO::PARAM_STR);
				$stmt->bindParam(':TX7', $apiDataValue['ProductText'][6]['Value'] , PDO::PARAM_STR);
			    $stmt->bindParam(':TX8', $apiDataValue['ProductText'][7]['Value'] , PDO::PARAM_STR);
				$stmt->bindParam(':TX9', $apiDataValue['ProductText'][8]['Value'] , PDO::PARAM_STR);
				$stmt->bindParam(':TX10', $apiDataValue['ProductText'][9]['Value'] , PDO::PARAM_STR);
				$stmt->bindParam(':TX11', $apiDataValue['ProductText'][10]['Value'] , PDO::PARAM_STR);
				$stmt->bindParam(':TX12', $apiDataValue['ProductText'][11]['Value'] , PDO::PARAM_STR);
				$stmt->bindParam(':TX13', $apiDataValue['ProductText'][12]['Value'] , PDO::PARAM_STR);
				$stmt->bindParam(':TX14', $apiDataValue['ProductText'][13]['Value'] , PDO::PARAM_STR);
				$stmt->bindParam(':TX15', $apiDataValue['ProductText'][14]['Value'] , PDO::PARAM_STR);
				$stmt->bindParam(':ModelAndVariantNo', $apiDataValue['ModelAndVariantNo'] , PDO::PARAM_STR);
				$stmt->bindParam(':ModelNo', $apiDataValue['ModelNo'] , PDO::PARAM_STR);
				//$stmt->bindParam(':SeasonDescription', $apiDataValue['SeasonDescription'] , PDO::PARAM_STR);
                $stmt->bindParam(':Code1', $apiDataValue['Code1'] , PDO::PARAM_STR);
                
		        if(isset($apiDataValue['Pack']))
		        {
		        	
		        	$stmt->bindParam(':SKU', $apiDataValue['Pack'][0]['SKU'] , PDO::PARAM_STR);
		        	$stmt->bindParam(':Quantity', $apiDataValue['Pack'][0]['Quantity'] , PDO::PARAM_STR);
					$stmt->bindParam(':PackType', $apiDataValue['Pack'][0]['Type'] , PDO::PARAM_STR);
		        	

		     	
		        }else{
                    $sku = '';
                    $qty = '';
                    $pac = '';
                  $stmt->bindParam(':SKU', $sku , PDO::PARAM_STR);
                  $stmt->bindParam(':Quantity',$qty , PDO::PARAM_STR);
                  $stmt->bindParam(':PackType', $pac, PDO::PARAM_STR);
                 
                }

		     
		        $stmt->execute();
			}

        /////////////// 2nd API call 
        $_arrayList = array('ResultList');
        $retval = array();
  
          $results = array();
              $requestBody = '{
                                "AddSideTableData": true,
                               "FieldFilter": "SES<=202;ST3>=1",
                               "FieldList": ["ProductNo", "Description", "Category", "StandardPrice", "HVL", "MVL", "VariantCode", "AmountPerUnit", "CountryOfOrigin", "SupplierNo", "SuppliersProductNo", "PurchaseCurrencyCode", "Weight", "Volyme", "Code1", "Code5", "Code6", "PurchasePrice", "Season", "DeliveryCode", "ProductText"],
                               "Index": 1,
                               "IndexFilter": "",
                               "OGAFilter": "",
                               "ReadCount":0,
                               "ReturnCount": 0,
                               "IncludeSpecialSelectedPrices":true,
                               "ReverseReading": false
  }';
              
              $ch = curl_init();
  
              curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
              curl_setopt($ch, CURLOPT_NOBODY, false);
              curl_setopt($ch, CURLOPT_URL, 'http://176.10.244.90:55562/GIS/v2/BPProductSvc/REST/GetProductDynamicList/000 ');
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
           
              $DBName = 'BP_SelectedBrands';
              $db = new PDO("sqlsrv:Server=212.247.32.103;Database=BP_SelectedBrands;", "jeff", "gcsmakeit2010");
  
              // Throw an Exception when an error occurs
              $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
              // Add the record 
              foreach ($apiData as $apiDataKey => $apiDataValue) {
  
                  $sql = "INSERT INTO Products(ProductNo,Description,Category,StandardPrice,HVL,MVL,VariantCode,AmountPerUnit,CountryOfOrigin,SupplierNo,SuppliersProductNo,PurchaseCurrencyCode,Weight,Volyme,Code5,Code6,PurchasePrice,Season,DeliveryCode,CategoryDescription,VariantDescription,VariantNo,DimensionDescription,DimensionCode,price_sek_pre,price_sek_after,price_sek_consumer,price_dkk_pre,price_dkk_after,price_dkk_consumer,price_nok_pre,price_nok_after,price_nok_consumer,price_eur_pre,price_eur_after,price_eur_consumer,TX1,TX2,TX3,TX4,TX5,TX6,TX7,TX8,TX9,TX10,TX11,TX12,TX13,TX14,TX15,ModelAndVariantNo,ModelNo , Code1 , SKU , Quantity ,PackType)
                  VALUES (:ProductNo,:Description,:Category,:StandardPrice,:HVL,:MVL,:VariantCode,:AmountPerUnit,:CountryOfOrigin,:SupplierNo,:SuppliersProductNo,:PurchaseCurrencyCode,:Weight,:Volyme,:Code5,:Code6,:PurchasePrice,:Season,:DeliveryCode,:CategoryDescription,:VariantDescription,:VariantNo,:DimensionDescription,:DimensionCode,:price_sek_pre,:price_sek_after,:price_sek_consumer,:price_dkk_pre,:price_dkk_after,:price_dkk_consumer,:price_nok_pre,:price_nok_after,:price_nok_consumer,:price_eur_pre,:price_eur_after,:price_eur_consumer,:TX1,:TX2,:TX3,:TX4,:TX5,:TX6,:TX7,:TX8,:TX9,:TX10,:TX11,:TX12,:TX13,:TX14,:TX15,:ModelAndVariantNo,:ModelNo , :Code1 ,  :SKU , :Quantity , :PackType)";
                                     
                  $stmt = $db->prepare($sql);
  
                  $stmt->bindParam(':ProductNo', $apiDataValue['ProductNo'], PDO::PARAM_STR);
                  $stmt->bindParam(':Description', $apiDataValue['Description'], PDO::PARAM_STR);
                  $stmt->bindParam(':Category', $apiDataValue['Category'] , PDO::PARAM_STR);
                  $stmt->bindParam(':StandardPrice', $apiDataValue['StandardPrice'] , PDO::PARAM_STR);
                     $stmt->bindParam(':HVL', $apiDataValue['HVL'] , PDO::PARAM_STR);
                  $stmt->bindParam(':MVL', $apiDataValue['MVL'] , PDO::PARAM_STR);
                  $stmt->bindParam(':VariantCode', $apiDataValue['VariantCode'] , PDO::PARAM_STR);
                  $stmt->bindParam(':AmountPerUnit', $apiDataValue['AmountPerUnit'] , PDO::PARAM_STR);
                  $stmt->bindParam(':CountryOfOrigin', $apiDataValue['CountryOfOrigin'] , PDO::PARAM_STR);
                  $stmt->bindParam(':SupplierNo', $apiDataValue['SupplierNo'] , PDO::PARAM_STR);
                  $stmt->bindParam(':SuppliersProductNo', $apiDataValue['SuppliersProductNo'] , PDO::PARAM_STR);
                  $stmt->bindParam(':PurchaseCurrencyCode', $apiDataValue['PurchaseCurrencyCode'] , PDO::PARAM_STR);
                  $stmt->bindParam(':Weight', $apiDataValue['Weight'] , PDO::PARAM_STR);
                  $stmt->bindParam(':Volyme', $apiDataValue['Volyme'] , PDO::PARAM_STR);
                  $stmt->bindParam(':Code5', $apiDataValue['Code5'] , PDO::PARAM_STR);
                  $stmt->bindParam(':Code6', $apiDataValue['Code6'] , PDO::PARAM_STR);
                  $stmt->bindParam(':PurchasePrice', $apiDataValue['PurchasePrice'] , PDO::PARAM_STR);
                  $stmt->bindParam(':Season', $apiDataValue['Season'] , PDO::PARAM_STR);
                  $stmt->bindParam(':DeliveryCode', $apiDataValue['DeliveryCode'] , PDO::PARAM_STR);
                  $stmt->bindParam(':CategoryDescription', $apiDataValue['CategoryDescription'] , PDO::PARAM_STR);
                  $stmt->bindParam(':VariantDescription', $apiDataValue['VariantDescription'] , PDO::PARAM_STR);
                  $stmt->bindParam(':VariantNo', $apiDataValue['VariantNo'] , PDO::PARAM_STR);
                  $stmt->bindParam(':DimensionDescription', $apiDataValue['DimensionDescription'] , PDO::PARAM_STR);
                  $stmt->bindParam(':DimensionCode', $apiDataValue['DimensionCode'] , PDO::PARAM_STR);
                  $stmt->bindParam(':price_sek_pre', $apiDataValue['price_sek_pre'] , PDO::PARAM_STR);
                  $stmt->bindParam(':price_sek_after', $apiDataValue['price_sek_after'] , PDO::PARAM_STR);
                  $stmt->bindParam(':price_sek_consumer', $apiDataValue['price_sek_consumer'] , PDO::PARAM_STR);
                  $stmt->bindParam(':price_dkk_pre', $apiDataValue['price_dkk_pre'] , PDO::PARAM_STR);
                  $stmt->bindParam(':price_dkk_after', $apiDataValue['price_dkk_after'] , PDO::PARAM_STR);
                  $stmt->bindParam(':price_dkk_consumer', $apiDataValue['price_dkk_consumer'] , PDO::PARAM_STR);
                  $stmt->bindParam(':price_nok_pre', $apiDataValue['price_nok_pre'] , PDO::PARAM_STR);
                  $stmt->bindParam(':price_nok_after', $apiDataValue['price_nok_after'] , PDO::PARAM_STR);
                  $stmt->bindParam(':price_nok_consumer', $apiDataValue['price_nok_consumer'] , PDO::PARAM_STR);
                  $stmt->bindParam(':price_eur_pre', $apiDataValue['price_eur_pre'] , PDO::PARAM_STR);
                  $stmt->bindParam(':price_eur_after', $apiDataValue['price_eur_after'] , PDO::PARAM_STR);
                  $stmt->bindParam(':price_eur_consumer', $apiDataValue['price_eur_consumer'] , PDO::PARAM_STR);
                  $stmt->bindParam(':TX1', $apiDataValue['ProductText'][0]['Value'] , PDO::PARAM_STR);
                  $stmt->bindParam(':TX2', $apiDataValue['ProductText'][1]['Value'] , PDO::PARAM_STR);
                  $stmt->bindParam(':TX3', $apiDataValue['ProductText'][2]['Value'] , PDO::PARAM_STR);
                  $stmt->bindParam(':TX4', $apiDataValue['ProductText'][3]['Value'] , PDO::PARAM_STR);
                  $stmt->bindParam(':TX5', $apiDataValue['ProductText'][4]['Value'] , PDO::PARAM_STR);
                  $stmt->bindParam(':TX6', $apiDataValue['ProductText'][5]['Value'] , PDO::PARAM_STR);
                  $stmt->bindParam(':TX7', $apiDataValue['ProductText'][6]['Value'] , PDO::PARAM_STR);
                  $stmt->bindParam(':TX8', $apiDataValue['ProductText'][7]['Value'] , PDO::PARAM_STR);
                  $stmt->bindParam(':TX9', $apiDataValue['ProductText'][8]['Value'] , PDO::PARAM_STR);
                  $stmt->bindParam(':TX10', $apiDataValue['ProductText'][9]['Value'] , PDO::PARAM_STR);
                  $stmt->bindParam(':TX11', $apiDataValue['ProductText'][10]['Value'] , PDO::PARAM_STR);
                  $stmt->bindParam(':TX12', $apiDataValue['ProductText'][11]['Value'] , PDO::PARAM_STR);
                  $stmt->bindParam(':TX13', $apiDataValue['ProductText'][12]['Value'] , PDO::PARAM_STR);
                  $stmt->bindParam(':TX14', $apiDataValue['ProductText'][13]['Value'] , PDO::PARAM_STR);
                  $stmt->bindParam(':TX15', $apiDataValue['ProductText'][14]['Value'] , PDO::PARAM_STR);
                  $stmt->bindParam(':ModelAndVariantNo', $apiDataValue['ModelAndVariantNo'] , PDO::PARAM_STR);
                  $stmt->bindParam(':ModelNo', $apiDataValue['ModelNo'] , PDO::PARAM_STR);
                  //$stmt->bindParam(':SeasonDescription', $apiDataValue['SeasonDescription'] , PDO::PARAM_STR);
                  $stmt->bindParam(':Code1', $apiDataValue['Code1'] , PDO::PARAM_STR);
                  
                  if(isset($apiDataValue['Pack']))
                  {
                      
                      $stmt->bindParam(':SKU', $apiDataValue['Pack'][0]['SKU'] , PDO::PARAM_STR);
                      $stmt->bindParam(':Quantity', $apiDataValue['Pack'][0]['Quantity'] , PDO::PARAM_STR);
                      $stmt->bindParam(':PackType', $apiDataValue['Pack'][0]['Type'] , PDO::PARAM_STR);
                      
  
                   
                  }else{
                      $sku = '';
                      $qty = '';
                      $pac = '';
                    $stmt->bindParam(':SKU', $sku , PDO::PARAM_STR);
                    $stmt->bindParam(':Quantity',$qty , PDO::PARAM_STR);
                    $stmt->bindParam(':PackType', $pac, PDO::PARAM_STR);
                   
                  }
  
               
                  $stmt->execute();
              }
			
			print_r("Data Uploaded"); exit;
	
	
?>