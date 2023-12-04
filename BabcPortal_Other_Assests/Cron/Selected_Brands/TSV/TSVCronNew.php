<?php

    ini_set("memory_limit", "-1");
    set_time_limit(0);
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $DBName = 'BP_SelectedBrands';
    $DBPass = 'gcsmakeit2010';
    $DBUsername = 'jeff';
    $DBHost = '10.30.57.5';
    $db = new PDO("sqlsrv:Server=$DBHost;Database=$DBName;", "$DBUsername", "$DBPass");

    // Throw an Exception when an error occurs
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $_arrayList = array('ResultList');
    // remove data from TSV table 
    $sql = "TRUNCATE TABLE TSV";
	$q = $db->prepare($sql);
	$q->execute();

    $fileNames = array('PRICAT_SB-Miinto_Ben_Sherman_Clothes',
                        'PRICAT_SB-Miinto_CAT_Shoes',
                        'PRICAT_SB-Miinto_Lacoste',
                        'PRICAT_SB-Miinto_Napapijri',
                        'PRICAT_SB-Miinto_Ugg'
                        );
    foreach ($fileNames as $filekey => $filevalue) {
        
        //$BasePath = $_SERVER['DOCUMENT_ROOT'] ;
        $fp = fopen("C:\MAMP\htdocs\Babcportal\BabcPortal_Other_Assests\Selected_brands\TSV\Miinto\\".$filevalue.'.tsv', 'wb');  // Save data in these file
        
       // $fp = fopen($BasePath."/Babcportal/BabcPortal_Other_Assests/Selected_brands/TSV/Miinto/".$filevalue.'.tsv', 'wb');  // Save data in these file and open the file 
       
        $doc =  file_get_contents("http://content.selectedbrands.com/miinto/item_data/".$filevalue.".txt");
        $lines=explode("\n",$doc);
      
        // $head = $lines[0].implode("\t",  $headerColumnName);
        $head = $lines[0];
        fwrite($fp, $head);
        fwrite($fp, "\n");
        unset($lines[0]);
        
       
        foreach ($lines as $key => $value) {
            $img = array();
            $productNo = explode("\t" , $value );
            $productNo =  isset($productNo[1])?$productNo[1]:'';
            if(!empty($productNo)){
                $productNo = substr( $productNo , 0 , -2);
                // $sql = "SELECT img.ImageURL , (SB.Artikelnr + SB.Variantkod) as SKU ,Category
                // ,Short_Description
                // ,Description
                // ,Attribute_Color_Swatch
                // ,Attribute_Materials
                // ,Attribute_True_to_size, img.ProductNo  FROM ProductImages img
                // left join Selected_Brands SB on (SB.Artikelnr + SB.Variantkod)  = img.ProductNo
                // where img.ProductNo = '". $productNo."'";

                $sql = "SELECT img.ImageURL FROM ProductImages img
                left join Selected_Brands SB on (SB.Artikelnr + SB.Variantkod)  = img.ProductNo
                where img.ProductNo = '". $productNo."'";

                // Excute Query 
                $stmt = $db->query($sql);
                // Fetch All data 
                $data = $stmt->fetchAll();
                if(isset( $data[0]['ImageURL']) && empty($img)){
                    $img = explode(',' , $data[0]['ImageURL'] ) ;
                    $imageLink = $img[0];
                    unset( $img[0]);
                    $additionalImgLink = implode(',' , $img );
                }
            }
            
            $newdata = '';
            if(!empty($data)){
                $data =  $data[0];
                $imgData = explode("\t", $value);
                $imgData[11]=  $imageLink;
                $imgData[12]= $additionalImgLink ;
                $value = implode("\t" , $imgData);
               // $newdata =  $data['SKU'] ."\t".$data['Category'] ."\t".$data['Short_Description'] ."\t".$data['Description'] ."\t".$data['Attribute_Color_Swatch'] ."\t".$data['Attribute_Materials'] ."\t".$data['Attribute_True_to_size']; 
            }
            if($newdata){
                $value = $value.$newdata;
            }
            fwrite($fp, $value);
            fwrite($fp, "\n");
            
            //Insert in DB
            $sql = "INSERT INTO TSV(   gtin , id ,item_group_id ,   title , description ,    brand ,  product_type ,gender ,   color , size ,  availability ,   image_link , additional_image_link ,season_tag , stock_level , style_id ,discount_retail_price_DKK ,retail_price_DKK , discount_retail_price_SEK ,retail_price_SEK , discount_retail_price_NOK ,  retail_price_NOK ,discount_retail_price_EUR , retail_price_EUR ) 
VALUES(:gtin ,:id ,:item_group_id ,:title ,:description,:brand , :product_type ,:gender ,:color ,:size ,:availability ,   :image_link , :additional_image_link , :season_tag , :stock_level , :style_id ,:discount_retail_price_DKK ,:retail_price_DKK , :discount_retail_price_SEK , :retail_price_SEK ,:discount_retail_price_NOK ,  :retail_price_NOK ,:discount_retail_price_EUR ,:retail_price_EUR )";
				 $value = explode("\t", $value);
               
            $stmt = $db->prepare($sql);
          
            $stmt->bindParam(':gtin', $value[0], PDO::PARAM_STR);
            $stmt->bindParam(':id' ,$value[1], PDO::PARAM_STR);
            $stmt->bindParam(':item_group_id' ,  $value[2], PDO::PARAM_STR);
            $stmt->bindParam(':title' , $value[3], PDO::PARAM_STR);
            $stmt->bindParam(':description' ,  $value[4], PDO::PARAM_STR);  
            $stmt->bindParam(':brand' ,  $value[5], PDO::PARAM_STR);
            $stmt->bindParam(':product_type' , $value[6], PDO::PARAM_STR);
            $stmt->bindParam(':gender' , $value[7], PDO::PARAM_STR);
            $stmt->bindParam(':color' , $value[8], PDO::PARAM_STR);
            $stmt->bindParam(':size' ,   $value[9], PDO::PARAM_STR);
            $stmt->bindParam(':availability' ,   $value[10], PDO::PARAM_STR);
            $stmt->bindParam(':image_link' , $value[11], PDO::PARAM_STR);
            $stmt->bindParam(':additional_image_link' , $value[12], PDO::PARAM_STR);
            $stmt->bindParam(':season_tag' , $value[13], PDO::PARAM_STR);
            $stmt->bindParam(':stock_level' , $value[14], PDO::PARAM_STR);
            $stmt->bindParam(':style_id' , $value[15], PDO::PARAM_STR);
            $stmt->bindParam(':discount_retail_price_DKK' , $value[16], PDO::PARAM_STR);
            $stmt->bindParam(':retail_price_DKK' , $value[17], PDO::PARAM_STR);
            $stmt->bindParam(':discount_retail_price_SEK', $value[18], PDO::PARAM_STR);
            $stmt->bindParam(':retail_price_SEK' , $value[19], PDO::PARAM_STR);
            $stmt->bindParam(':discount_retail_price_NOK',  $value[20], PDO::PARAM_STR);
            $stmt->bindParam(':retail_price_NOK' , $value[21], PDO::PARAM_STR);
            $stmt->bindParam(':discount_retail_price_EUR' , $value[22], PDO::PARAM_STR);
            $stmt->bindParam(':retail_price_EUR' , $value[23], PDO::PARAM_STR);
            $stmt->execute();
           
        }
        
        fclose($fp);
    }
   
    print_r("success");
    exit;
    
    


?>