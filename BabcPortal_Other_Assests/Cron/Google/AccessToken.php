<?php
// This File is cron that update read from file data on click .
ini_set('memory_limit', '200G');
ini_set('display_errors', 1);
error_reporting(E_ALL);

    $DBName = 'BP_Admin10';
    $db = new PDO("sqlsrv:Server=10.30.57.5;Database=BP_Admin10;", "jeff", "gcsmakeit2010");

    // Throw an Exception when an error occurs
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
    $sql = " select * from Company where CompanyID = '3' " ;
    $stmt = $db->query( $sql);
    $val = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $accessRefreshTokenGAPI = ''; 
    if($val){
        foreach($val as $valKey => $valVal){

            $accessRefreshTokenGAPI = '1//0coHmH2gBszoVCgYIARAAGAwSNwF-L9IrHMrX7UgDDURCFWqQJqSxNFUcFTdymQQVrtaj51lE468EKaylH1Acu3I3d2eRJ_5LUr4';
            //$accessRefreshTokenGAPI = $valVal['GoogleAccessRefreshToken'];
            // (Start ) Curl Request 
            $ch = curl_init();
            
            $fileContent = file_get_contents('http://dev.babcportal.com/public/Test_Files/client_secret.json');
            $fileContent = json_decode($fileContent , true); 
            
            $url = "https://accounts.google.com/o/oauth2/token"; // path for google Oauth 
           
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POST, 1);

            curl_setopt($ch, CURLOPT_POSTFIELDS,
                        "client_id=".$fileContent['web']['client_id']."&client_secret=".$fileContent['web']['client_secret']."&grant_type=refresh_token&refresh_token=".$accessRefreshTokenGAPI);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $results = curl_exec($ch); // Excute Curl 
           
            $results =  json_decode( $results, true); // json decode the data to array .
           
            
            if(isset($results['refresh_token'])){
                $data =  array('companyId' => $valVal['CompanyID'] , 'accessToken' => $results); 
            }else{
                //$results['refresh_token'] = '1//0cKyPCj0M6dXzCgYIARAAGAwSNwF-L9IrjhMFkvDD2RV80biutGgu4SKlwY2wIrqb4yIhpmbmxEt6Ae_GpHAvZ9CoSPb6jUCEhTQ';
                $results['refresh_token'] = $valVal['GoogleAccessRefreshToken'];
                $data =  array('companyId' => $valVal['CompanyID'] , 'accessToken' => $results); 
            
            }
           
            /// Query to update a record 
            $sql = "UPDATE Company SET
            GoogleAccessToken = :GoogleAccessToken,
            GoogleAccessRefreshToken = :GoogleAccessRefreshToken
            WHERE CompanyID = :CompanyID";
             // prepare query to bind value with parameters 
            $stmt = $db->prepare($sql);

            $GoogleAccessToken =  $data['accessToken']['token_type']." ".$data['accessToken']['access_token'];
            $GoogleAccessRefreshToken = $data['accessToken']['refresh_token'];
             // parameter Binding 
            $stmt->bindParam(':GoogleAccessRefreshToken', $GoogleAccessRefreshToken , PDO::PARAM_STR);
            $stmt->bindParam(':GoogleAccessToken', $GoogleAccessToken, PDO::PARAM_STR);
            $stmt->bindParam(':CompanyID', $data['companyId'], PDO::PARAM_INT);
            $stmt->execute();  // Execute QUery 
        
            curl_close($ch);// close Curl 
        }
    }

    echo "Cron Successful";
	exit;