<?php
// This File is cron that update Product Images table on daily base.
ini_set('memory_limit', '200G');
ini_set('display_errors', 1);
error_reporting(E_ALL);


     $_arrayList = array('ResultList');
    $retval = array();

    
    $DBName = 'BP_SelectedBrands';
    $db = new PDO("sqlsrv:Server=212.247.32.103;Database=BP_SelectedBrands;", "jeff", "gcsmakeit2010");

    // Throw an Exception when an error occurs
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


      $dir    = '212.247.32.103:8082/API-IMG/Selected%20Brands%20-%20Demo/Images/user/shopsb%40babc.app/';

        $ftp_server = "212.247.32.103";
      $ftp_user_name = "Images";
      $ftp_user_pass = "babc";
              

      // set up basic connection
      $conn_id = ftp_connect($ftp_server );


      // login with username and password
      $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 
      ftp_pasv($conn_id, true); 
  
    if($login_result){
      //First Delete all the Records then create new ones .
              
      // $sql = "TRUNCATE TABLE ProductImages";
      // $q = $db->prepare($sql);
      // $q->execute();
    
             
      //$CompanyDir = 'htdocs/'.$folder.'/'.trim($_SESSION['CompanyName']).'/';
      $nList = ftp_nlist($conn_id, " /Selected Brands - Demo/Images/user/shopsb@babc.app/");

      foreach ($nList as $nListKey => $nListValue) {
  
           $check = ftp_nlist($conn_id, $nListValue );
           $nListValue = explode('/', $nListValue);
           $nListValue =  end($nListValue);
          
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
                   
                   $newTemp  = explode($nListValue, $checkValue);
                   
                   $ProductNo = explode(' ' , end($newTemp));
                  
                   if(count($ProductNo)>1)
                   {
                       $tempPro  = $ProductNo[0];
                   }else{
                    
                      $tempPro = explode('.', $ProductNo[0]);
                      $tempPro = $tempPro[0];
                   }
                   
                  
                   $ProductNo = explode('/' , $tempPro);
                   $ProductNo = end($ProductNo);
                   $ImgExt = explode('.', $checkValue);
                   $ImgExt = $ImgExt[1];
                   $ImageUrl = $ftp_server.':8082/API-IMG'.$checkValue ;

                    
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
              
            
              echo "<pre>";
              print_r($chk."|");
              print_r(count($tempArr)."|");
              print_r($nListValue);
              //National Geographic
              // if($nListValue == 'UGG')
              // {
              //        foreach ($tempArr as $key => $value) {
                 

                  
              //              $sql = "INSERT INTO ProductImages(ProductNo,ImageURL, FolderName,DateCreated,DateUpdated)
              //                      VALUES (:ProductNo, :ImageURL, :FolderName, :DateCreated, :DateUpdated)";

                                  
              //                    $stmt = $db->prepare($sql);
              //                    $date = Date('Y-m-d H:i:s');
              //                    $stmt->bindParam(':ProductNo', $key, PDO::PARAM_STR);
              //                    $stmt->bindParam(':ImageURL', $value, PDO::PARAM_STR);
                                  
              //                    $stmt->bindParam(':FolderName', $nListValue, PDO::PARAM_STR);
              //                    $stmt->bindParam(':DateCreated', $date, PDO::PARAM_STR);
              //                    $stmt->bindParam(':DateUpdated', $date, PDO::PARAM_STR);
                               
              //                    $stmt->execute();

              //    }
              // }
               // foreach ($tempArr as $key => $value) {
               

                
               //   $sql = "INSERT INTO ProductImages(ProductNo,ImageURL, FolderName,DateCreated,DateUpdated)
               //           VALUES (:ProductNo, :ImageURL, :FolderName, :DateCreated, :DateUpdated)";

                        
               //         $stmt = $db->prepare($sql);
               //         $date = Date('Y-m-d H:i:s');
               //         $stmt->bindParam(':ProductNo', $key, PDO::PARAM_STR);
               //         $stmt->bindParam(':ImageURL', $value, PDO::PARAM_STR);
                        
               //         $stmt->bindParam(':FolderName', $nListValue, PDO::PARAM_STR);
               //         $stmt->bindParam(':DateCreated', $date, PDO::PARAM_STR);
               //         $stmt->bindParam(':DateUpdated', $date, PDO::PARAM_STR);
                     
               //         $stmt->execute();

               // }
                    
              
           }
        
      }
    }
    if(ftp_close($conn_id)) {
        echo "<br>Connection closed Successfully!";
    }
    print_r("All Images Uploaded");
    exit;

 ?>