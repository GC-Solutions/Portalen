<?php 

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

	$ftp_server = 'https://sb-files.babcportal.com/'; // Ip address 
	//$basePath = $_SERVER['DOCUMENT_ROOT']; // base path in folder 

	//$filename = $basePath.'/Babcportal/BabcPortal_Other_Assests/Selected_brands/API-IMG/Selected Brands - Demo/Images/user/shopsb@babc.app/';
	$filename ='C:\MAMP\htdocs\Babcportal\BabcPortal_Other_Assests\Selected_brands\API-IMG\Selected Brands - Demo\Images\user\shopsb@babc.app\\';

	
	//$nList = (scandir( $filename));
	$nList =array_diff(scandir( $filename), array('.', '..'));
    //First Delete all the Records then create new ones .
                
	$sql = "TRUNCATE TABLE ProductImages";
	$q = $db->prepare($sql);
	$q->execute();
   
    foreach ($nList as $nListKey => $nListValue) {

		//$check = scandir( $filename. $nListValue);
		$check =array_diff(scandir( $filename. $nListValue.'/'), array('.', '..'));
		$chk = count($check) ; 
		
		if( $chk > 0  )
		{

			$tempArr = [];
			foreach ($check as $checkKey => $checkValue) {
				
				$ProductNo = '';
				$ImgExt =  '' ;
				
				$ProductNo = explode(' ' , $checkValue);
				$ProductNo = explode('_' , $ProductNo[0]);
				
				if(count($ProductNo)>1)
				{
					$ProductNo  = $ProductNo[0];
				}else{

					$ProductNo = explode('.', $ProductNo[0]);
					$ProductNo =  $ProductNo[0];
				}
				
				$ImgExt = explode('.', $checkValue);
				$ImgExt = isset($ImgExt[1])?$ImgExt[1]:'';
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
			
			foreach ($tempArr as $key => $value) {
				$sql = "INSERT INTO ProductImages(ProductNo,ImageURL, FolderName,DateCreated,DateUpdated)
						VALUES (:ProductNo, :ImageURL, :FolderName, :DateCreated, :DateUpdated)";

						
					$stmt = $db->prepare($sql);
					$date = Date('Y-m-d H:i:s');
					$stmt->bindParam(':ProductNo', $key, PDO::PARAM_STR);
					$stmt->bindParam(':ImageURL', $value, PDO::PARAM_STR);
						
					$stmt->bindParam(':FolderName', $nListValue, PDO::PARAM_STR);
					$stmt->bindParam(':DateCreated', $date, PDO::PARAM_STR);
					$stmt->bindParam(':DateUpdated', $date, PDO::PARAM_STR);
					
					$stmt->execute();

			}
		
		}

		
	}	

    print_r("All Images Uploaded");
    exit;
