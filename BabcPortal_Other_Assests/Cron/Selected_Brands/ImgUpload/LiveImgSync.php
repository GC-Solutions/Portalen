<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
ini_set("memory_limit", "-1");
set_time_limit(0);
ini_set('display_errors', 1);
error_reporting(E_ALL);


	$DBName = 'BP_SelectedBrands';
    $DBPass = 'gcsmakeit2010';
    $DBUsername = 'jeff';
    $DBHost = '10.30.57.5';

	// set up basic connection
    $db = new PDO("sqlsrv:Server=$DBHost;Database=$DBName;", "$DBUsername", "$DBPass");
    // Throw an Exception when an error occurs
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $ftp_server ='https://sb-files.babcportal.com/'; // Ip address 
	$basePath = $_SERVER['DOCUMENT_ROOT']; // base path in folder 

	$filename = $basePath.'/Babcportal/BabcPortal_Other_Assests/Selected_brands/API-IMG/Selected Brands - Demo/Images/user/shopsb@babc.app/';

    //$filename = dirname(__FILE__).'\\Selected Brands - Demo\Images\user\shopsb@babc.app\\';
    $nList = (scandir( $filename));
    $newCnt =0;
    foreach ($nList as $nListKey => $nListValue) {
  
        if($nListValue != '.' && $nListValue != '..' )
        {
        
            $check = scandir( $filename. $nListValue."\\");
            $updateDateFolder =  filemtime($filename. $nListValue);
            $updateDateFolder = date("Y-m-d", $updateDateFolder );
        
            $curDate = date("Y-m-d"); 
        
            if( $updateDateFolder == $curDate){
       
                $chk = count($check) ; 
                if( $chk > 0)
                {
            
                    $tempArr = [];
                    foreach ($check as $checkKey => $checkValue) {
                    
                    if($checkValue != '..')
                    {
                        if( $checkValue != '.'){
                            $ProductNo = '';
                            $ImgExt =  '' ;
                            
                            $ProductNo = explode(' ' , $checkValue);
                            
                            if(count($ProductNo)>1)
                            {
                                $ProductNo  = $ProductNo[0];
                            }else{
                            
                                $ProductNo = explode('.', $ProductNo[0]);
                                $ProductNo =  $ProductNo[0];
                            }
                            
                            $ImgExt = explode('.', $checkValue);
                            $ImgExt = $ImgExt[1];
                            $ImageUrl = $ftp_server.'API-IMG/Selected Brands - Demo/Images/user/shopsb@babc.app/'.$nListValue.'/'.$checkValue ;
                            $ImageUrl = str_replace(' ', '%20' , $ImageUrl );
                            
                            
                            if(array_key_exists($ProductNo, $tempArr))
                            {
                                $tempArr[$ProductNo] = $tempArr[$ProductNo].','.$ImageUrl;
                            }else
                            {
                                $tempArr[$ProductNo] = $ImageUrl;
                            }
                                
                        }
                        }
                    }
                    
                    $sql = "SELECT ImageURL FROM ProductImages where FolderName = '".$nListValue."'   ";
                    // Execute Query 
                    $stmt = $db->query($sql);
                    // Fetch all Data 
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach ($tempArr as $dataKey => $dataValue) {
                    $cnt = 0;
                    foreach ($data as $key => $value) {
                        
                        if($dataValue == $value['ImageURL']){
                            unset($tempArr[$dataKey]);
                            $cnt = 1;

                        }
                    }
                    
                    if($cnt == 0){
                        
                        $sql = "INSERT INTO ProductImages(ProductNo,ImageURL, FolderName,DateCreated,DateUpdated)
                                VALUES (:ProductNo, :ImageURL, :FolderName, :DateCreated, :DateUpdated)";
                        $curDate = date("Y-m-d H:i:s"); 
                        $stmt = $db->prepare($sql);
                        $date = Date('Y-m-d H:i:s');
                        $stmt->bindParam(':ProductNo', $dataKey, PDO::PARAM_STR);
                        $stmt->bindParam(':ImageURL', $dataValue, PDO::PARAM_STR);
                        $stmt->bindParam(':FolderName', $nListValue, PDO::PARAM_STR);
                        $stmt->bindParam(':DateCreated', $curDate, PDO::PARAM_STR);
                        $stmt->bindParam(':DateUpdated', $curDate, PDO::PARAM_STR);
                        
                        $stmt->execute();
                        $newCnt =  $newCnt +1;
                    }
                    
                    }
                    
                }  
            }
        
        }
    }
    
   
    print_r($newCnt." Images Uploaded");
    exit;

?>