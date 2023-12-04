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

    // Code to empty the Table 
    $sql = "TRUNCATE TABLE OnDrop";
	$q = $db->prepare($sql);
	$q->execute();

    $filevalue = 'NewOnDropTSV';

    $BasePath = $_SERVER['DOCUMENT_ROOT'] ;
    $fp = fopen("C:\MAMP\htdocs\Babcportal\BabcPortal_Other_Assests\Selected_brands\TSV\Ondrop\\".$filevalue.'.tsv', 'wb');  // Save data in these file
    
    $doc =  file_get_contents("http://content.selectedbrands.com/miinto/item_data/Item_Additional_Info_Test.txt");
    $lines=explode("\n",$doc);

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
            
            $sql = "SELECT img.ImageURL , img.ProductNo , img.FolderName , SB.Category ,  SB.Short_Description , SB.Artikelnr  , SB.Variantkod , SB.Description , SB.Attribute_Materials, SB.Attribute_Color_Swatch, SB.Upperlining , SB.Innerlining , SB.Insole FROM ProductImages img
                  left join Selected_Brands SB on (SB.Artikelnr + SB.Variantkod)  = img.ProductNo
                  where img.ProductNo = '".$productNo."'";

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
        $des = isset($data[0]['Short_Description'])?$data[0]['Short_Description']:'';
        $Artikelnr = isset($data[0]['Artikelnr'])?$data[0]['Artikelnr']:'';
        $Variantkod = isset($data[0]['Variantkod'])?$data[0]['Variantkod']:'';
        $Category  = isset($data[0]['Category'])?$data[0]['Category']:'';
        $SBDescription = isset($data[0]['Description'])?$data[0]['Description']:'';
        $Attribute_Materials  = isset($data[0]['Attribute_Materials'])?$data[0]['Attribute_Materials']:'';
        $Attribute_Color_Swatch =  isset($data[0]['Attribute_Color_Swatch'])?$data[0]['Attribute_Color_Swatch']:'';
        $Upperlining =isset($data[0]['Upperlining'])?$data[0]['Upperlining']:'';
        $Innerlining =isset($data[0]['Innerlining'])?$data[0]['Innerlining']:'';
        $Insole  =isset($data[0]['Insole'])?$data[0]['Insole']:'';
        $ProductNo =  isset($data[0]['ProductNo'])?$data[0]['ProductNo']:'';
        $FolderName = isset($data[0]['FolderName'])?$data[0]['FolderName']:'';
        $Images  = isset($data[0]['ImageURL'])?$data[0]['ImageURL']:'';

        if(!empty($data)){
            $data =  $data[0];
            $imgData = explode("\t", $value);
            $imgData[11]=  $imageLink;
            $imgData[12]= $additionalImgLink ;
            $value = implode("\t" , $imgData);
        }
          
        fwrite($fp, $value);
        fwrite($fp, "\n"); 
        //Insert in DB
        $sql = "INSERT INTO OnDrop(   gtin , id ,item_group_id ,   title , description ,    brand ,  product_type ,gender ,   color , size ,  availability ,   image_link , additional_image_link ,season_tag , stock_level , style_id ,discount_retail_price_DKK ,retail_price_DKK , discount_retail_price_SEK ,retail_price_SEK , discount_retail_price_NOK ,  retail_price_NOK ,discount_retail_price_EUR , retail_price_EUR ,  supplier_item_no ,	qty_per_unit,	taric,	weight,	volume , Short_Description , Artikelnr  , Variantkod ,Category  , SBDescription , Attribute_Materials  , Upperlining ,Innerlining ,Insole  , ProductNo , 
        FolderName , Images ,  Attribute_Color_Swatch, Zalando_EUR_consumer, Zalando_DKK_consumer, Zalando_NOK_consumer, Zalando_SEK_consumer ) 
        VALUES(:gtin ,:id ,:item_group_id ,:title ,:description,:brand , :product_type ,:gender ,:color ,:size ,:availability ,   :image_link , :additional_image_link , :season_tag , :stock_level , :style_id ,:discount_retail_price_DKK ,:retail_price_DKK , :discount_retail_price_SEK , :retail_price_SEK ,:discount_retail_price_NOK ,  :retail_price_NOK ,:discount_retail_price_EUR ,:retail_price_EUR ,  :supplier_item_no,	:qty_per_unit,	:taric,	:weight, :volume, :Short_Description , :Artikelnr  , :Variantkod , :Category  , :SBDescription , :Attribute_Materials  , :Upperlining ,:Innerlining , :Insole  , :ProductNo , 
        :FolderName , :Images  ,:Attribute_Color_Swatch, :Zalando_EUR_consumer, :Zalando_DKK_consumer, :Zalando_NOK_consumer, :Zalando_SEK_consumer )";
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
        $stmt->bindParam(':supplier_item_no' , $value[24], PDO::PARAM_STR);
        $stmt->bindParam(':qty_per_unit' , $value[25], PDO::PARAM_STR);
        $stmt->bindParam(':taric' , $value[26], PDO::PARAM_STR);
        $stmt->bindParam(':weight' , $value[27], PDO::PARAM_STR);
        $stmt->bindParam(':volume' , $value[28], PDO::PARAM_STR);
        $stmt->bindParam(':Short_Description' , $des, PDO::PARAM_STR);
        $stmt->bindParam(':Artikelnr' , $Artikelnr, PDO::PARAM_STR);
        $stmt->bindParam(':Variantkod' , $Variantkod, PDO::PARAM_STR);
        $stmt->bindParam(':Category' , $Category, PDO::PARAM_STR);
        $stmt->bindParam(':SBDescription' , $SBDescription, PDO::PARAM_STR);
        $stmt->bindParam(':Attribute_Materials' , $Attribute_Materials, PDO::PARAM_STR);
        $stmt->bindParam(':Upperlining' , $Upperlining, PDO::PARAM_STR);
        $stmt->bindParam(':Innerlining' , $Innerlining, PDO::PARAM_STR);
        $stmt->bindParam(':Insole' , $Insole, PDO::PARAM_STR);
        $stmt->bindParam(':ProductNo' , $ProductNo, PDO::PARAM_STR);
        $stmt->bindParam(':FolderName' , $FolderName, PDO::PARAM_STR);
        $stmt->bindParam(':Images' , $Images, PDO::PARAM_STR);
        $stmt->bindParam(':Attribute_Color_Swatch' , $Attribute_Color_Swatch, PDO::PARAM_STR);
        $stmt->bindParam(':Zalando_EUR_consumer' , $value[29], PDO::PARAM_STR);
        $stmt->bindParam(':Zalando_DKK_consumer' , $value[30], PDO::PARAM_STR);
        $stmt->bindParam(':Zalando_NOK_consumer' , $value[31], PDO::PARAM_STR);
        $stmt->bindParam(':Zalando_SEK_consumer' , $value[32], PDO::PARAM_STR);
        $stmt->execute();
      
    }
    fclose($fp);
    
    print_r("success");
    exit;

?>