<?php

ini_set("memory_limit", "-1");
set_time_limit(0);
ini_set('display_errors', 1);
error_reporting(E_ALL);

    $DBName = 'BP_GcSolutions';
    $DBPass = 'gcsmakeit2010';
    $DBUsername = 'jeff';
    $DBHost = '10.30.57.5';
    $db = new PDO("sqlsrv:Server=$DBHost;Database=$DBName;", "$DBUsername", "$DBPass");
    // Throw an Exception when an error occurs
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
    $ch = curl_init();
                         
    curl_setopt($ch, CURLOPT_NOBODY, false);

    curl_setopt($ch, CURLOPT_URL,'http://10.30.57.11:55563/GIS/DatabaseLogSvc/REST/GetFilteredLog/gcs'); // Curl option for url setting 

    $Body = array (
        'LogDateFrom' => '220427',
        'LogDateTo' => '221220',
        'LogTypes' => 
        array (
          0 => 'C',
        ),
        'Tables' => 
        array (
          0 => 
          array (
            'Fields' => 
            array (
              0 => 
              array (
                'Name' => 'VIP',
              ),
            ),
            'Name' => 'AGA',
          ),
        ),
      );
    $Body = json_encode($Body);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $Body);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

    // Curl option for time out
    curl_setopt($ch, CURLOPT_TIMEOUT, 6000000000);
    // curl option set to true for getting the result back .
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //curl Execute 
    $results = curl_exec($ch);
    $results = json_decode($results , true);
    
    if(!empty($results['ResultList'])){
        foreach($results['ResultList'] as $key => $value){
            // print_r( $value['FieldList']); exit;
            if($value['FieldList']){
                foreach($value['FieldList'] as $Fkey => $FValue){
                    
                    $Field = $FValue['Field'] ; 
                    $ValueAfter = $FValue['ValueAfter'] ;
                    $ValueAfterLength  = $FValue['ValueAfterLength'] ;
                    $ValueBefore = $FValue['ValueBefore']  ;
                    $ValueBeforeLength =  $FValue['ValueBeforeLength'] ;
                    $LogDate = $value['LogDate'] ;
                    $LogTime = $value['LogTime'] ;
                    $Tables = $value['Table'] ;
                    $Users = $value['User'] ;

                    $sql = "INSERT INTO DataLogs(Field,ValueAfter,ValueAfterLength, ValueBefore,  ValueBeforeLength, LogDate , LogTime, Tables, Users ) 
                    VALUES(:Field,:ValueAfter,:ValueAfterLength, :ValueBefore, :ValueBeforeLength, :LogDate , :LogTime, :Tables, :Users)";
              
                    $stmt = $db->prepare($sql);
                    
                    $stmt->bindParam(':Field',  $Field , PDO::PARAM_STR);
                    $stmt->bindParam(':ValueAfter' ,$ValueAfter, PDO::PARAM_STR);
                    $stmt->bindParam(':ValueAfterLength' ,  $ValueAfterLength, PDO::PARAM_STR);
                    $stmt->bindParam(':ValueBefore' , $ValueBefore, PDO::PARAM_STR);
                    $stmt->bindParam(':ValueBeforeLength' ,$ValueBeforeLength, PDO::PARAM_STR);  
                    $stmt->bindParam(':LogDate' ,  $LogDate, PDO::PARAM_STR);
                    $stmt->bindParam(':LogTime' , $LogTime, PDO::PARAM_STR);
                    $stmt->bindParam(':Tables' , $Tables, PDO::PARAM_STR);
                    $stmt->bindParam(':Users' , $Users, PDO::PARAM_STR);
            
                    $stmt->execute();
                    

                   
                }
            }
            else{
                $Field = ''; 
                $ValueAfter =  '';
                $ValueAfterLength  = '';
                $ValueBefore =  '';
                $ValueBeforeLength =   '';
                $LogDate =$value['LogDate'] ;
                $LogTime = $value['LogTime'] ;
                $Tables = $value['Table'] ;
                $Users = $value['User'] ;
                
                $sql = "INSERT INTO DataLogs(Field,ValueAfter,ValueAfterLength, ValueBefore,  ValueBeforeLength, LogDate , LogTime, Tables, Users ) 
                    VALUES(:Field,:ValueAfter,:ValueAfterLength, :ValueBefore, :ValueBeforeLength, :LogDate , :LogTime, :Tables, :Users)";
              
                    $stmt = $db->prepare($sql);
                    
                    $stmt->bindParam(':Field',  $Field , PDO::PARAM_STR);
                    $stmt->bindParam(':ValueAfter' ,$ValueAfter, PDO::PARAM_STR);
                    $stmt->bindParam(':ValueAfterLength' ,  $ValueAfterLength, PDO::PARAM_STR);
                    $stmt->bindParam(':ValueBefore' , $ValueBefore, PDO::PARAM_STR);
                    $stmt->bindParam(':ValueBeforeLength' ,$ValueBeforeLength, PDO::PARAM_STR);  
                    $stmt->bindParam(':LogDate' ,  $LogDate, PDO::PARAM_STR);
                    $stmt->bindParam(':LogTime' , $LogTime, PDO::PARAM_STR);
                    $stmt->bindParam(':Tables' , $Tables, PDO::PARAM_STR);
                    $stmt->bindParam(':Users' , $Users, PDO::PARAM_STR);
            
                    $stmt->execute();
            }
        }
    }

   
    echo "Cron Successful";
	exit;