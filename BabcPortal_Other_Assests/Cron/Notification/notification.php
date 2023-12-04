<?php

ini_set("memory_limit", "-1");
set_time_limit(0);
ini_set('display_errors', 1);
error_reporting(E_ALL);

    $DBName = 'BP_Admin10';
    $DBPass = 'gcsmakeit2010';
    $DBUsername = 'jeff';
    $DBHost = '10.30.57.5';
    $db = new PDO("sqlsrv:Server=$DBHost;Database=$DBName;", "$DBUsername", "$DBPass" );
    // Throw an Exception when an error occurs
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
    $sql = " select Users.* , Company.*
    from Users , Company  
    where Users.AllowNotification = '1'AND 
    Company.CompanyID = Users.CompanyID   " ;
    
    $stmt = $db->query( $sql);
    $Users = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
     //over here
    if($Users){
        
        ///$sql = "TRUNCATE TABLE NotiLog";
       /// $q = $db->prepare($sql);
       // $q->execute();

        foreach($Users as $keyUser => $ValUser){
          

            $NotiID = explode(',' ,$ValUser['SelectedNotification']); 
           
            $LogOutdate = (int)$ValUser['UserLastLogoutDate'] ;
            $LogOutTime = $ValUser['UserLastLogoutTime'] ;

            if(strpos($LogOutTime , ':') !== false){
                $LogOutTime = explode(':' , $LogOutTime );
               
                array_pop($LogOutTime);
               
                $LogOutTime = implode(':', $LogOutTime );
            }
           
            if($NotiID){
                foreach($NotiID as $NotiIDKey => $NotiIDVal ){
                    $DBName = 'BP_Admin10';
                    $DBPass = 'gcsmakeit2010';
                    $DBUsername = 'jeff';
                    $DBHost = '10.30.57.5';
                    $db = new PDO("sqlsrv:Server=$DBHost;Database=$DBName;", "$DBUsername", "$DBPass" );
                    // Throw an Exception when an error occurs
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  
                    $sql = "select  DataSource.*, PushNotification.PopUpDescriptions,  PushNotification.Conditions as pushCondition , PushNotification.Descriptions as pushDesc 
                    from Tables, DataSource , PushNotification
                    WHERE
                    DataSource.ID IN (Tables.DataSourceId)
                    AND Tables.ID = (PushNotification.TableID)
                    And PushNotification.ID = '".$NotiIDVal."' " ;
                  
                    print_r($NotiIDVal); 
                    $stmt = $db->query( $sql);
                    $Notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
                   
                    $Notifications  = $Notifications[0];

                    if($Notifications && $Notifications['RequestType'] == '2' ){
                        
                        $url  = str_replace('(address)' ,$ValUser['CompanyGISKey'] , $Notifications['SourceAddress'] );
                        $url  = str_replace('(token)' ,$ValUser['CompanyGISToken'] , $url );
                        $Body =  $Notifications['Body'];
                        if(($ValUser['DBParam'])) {
                            $arr = explode('|', $ValUser['DBParam'] );
                            if(!empty($arr[0])){
                                foreach ($arr as $v) {
                                    $val = explode(':', $v);
                                    $str = explode(',', $val[1]);
                                    $dataVal = '';
                                    if(count($str) > 1){
                                        foreach ($str as $ke => $va) {
                                            $dataVal = $dataVal .  $va . ",";
                                        }
                                    }else{
                                         $dataVal = $str[0];
                                    }
                
                                    $dataVal = rtrim($dataVal,',');
                                    $Body = str_replace("'(".$val[0].")'", $dataVal,$Body);
                                    $Body = str_replace("(".$val[0].")", $dataVal, $Body);
                                    
                                }
                            }
                        }

                        if (strpos($url, strtolower('(nowtime)')) !== false) {
                            $currentDateValue = substr(date('Ymd'), 2);
                            $url = str_replace("(nowtime)", $currentDateValue, $url);
                        }   
                        
                        if (strpos($Body, strtolower('(nowtime)')) !== false) {
                                $currentDateValue = substr(date('Ymd'), 2);
                                $Body = str_replace("(nowtime)", $currentDateValue, $Body);
                            
                        } 
                        //Curl initalization 
                      
                        $ch = curl_init();
                         
                        curl_setopt($ch, CURLOPT_NOBODY, false);
                    
                        curl_setopt($ch, CURLOPT_URL, $url); // Curl option for url setting 
                    
                        if ($Body) {
                            // Curl for post body 
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $Body);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                        }
                        // Curl option for time out
                        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
                        // curl option set to true for getting the result back .
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        //curl Execute 
                        $results = curl_exec($ch);
                        $decodedResults = array();
                        if($results){
                            $decodedResults = json_decode($results, true);
                        }
                       
                        $NotiCondition = $Notifications['pushCondition'] ;
                        
                        $NotiCondition =json_decode($NotiCondition, true);
                        $newTempArr = array();
                        $LogOutTimeN = '';
                        
                       
                        foreach($decodedResults as $key => $value){
                            $flag = 2; 
                            
                            foreach($NotiCondition as $conkey => $convalue){
                                if($flag == 1){
                                    break;
                                }
                                
                                foreach($convalue as $ckey => $cvalue){
									$OldSecondParameter = '';
                                
                                    if(strpos($cvalue['SecondParameter'] , '(LogoutDate)') !== false){
										$OldSecondParameter = $cvalue['SecondParameter'];
                                        $cvalue['SecondParameter'] = (int)(str_replace('(LogoutDate)' , $LogOutdate , $cvalue['SecondParameter'] ));
                                		
                                    }
                                    if(strpos($cvalue['SecondParameter'] , '(LogoutTime)') !== false){
                                        if($value['LogDate'] > $LogOutdate ){
                                            $LogOutTimeN = (int)strtotime("00:00");
                                            $value[$conkey] = (int)strtotime($value[$conkey]);
                                        }else{
                                            $LogOutTimeN = (int)strtotime( $LogOutTime);
                                            $value[$conkey] = (int)strtotime($value[$conkey]);
                                        }
                                        $cvalue['SecondParameter'] = str_replace('(LogoutTime)' , $LogOutTimeN , $cvalue['SecondParameter'] );
                                    }
                                    
                                    if($cvalue['Condition'] == '='){
                                        if($value[$conkey] == $cvalue['SecondParameter']){
                                                $flag = 0;
                                        }else{
                                            $flag = 1;
                                            break;
                                        }

                                    
                                    }else if($cvalue['Condition'] == '!='){
                                        if($value[$conkey] != $cvalue['SecondParameter']){
                                            $flag = 0;
                                        }else{
                                            $flag = 1;
                                            break;
                                        }
                                    
                                    }else if($cvalue['Condition'] == '<='){
                                        if($value[$conkey] <= $cvalue['SecondParameter']){
                                            $flag = 0;
                                        }else{
                                            $flag = 1;
                                            break;
                                        }
                                    
                                    }else if($cvalue['Condition'] == '>='){
                                            
                                        if($value[$conkey] >= $cvalue['SecondParameter']){
											 if(strpos($OldSecondParameter , '(LogoutDate)') !== false){
												  $date = date('ymd');
												 if($value[$conkey] ==  $date){
													 $flag = 0;
												 }else{
													 $flag = 1;
													  break;
												 }
												 
											 }else{
												 $flag = 0;
											 }
                                            
                                        }else{
                                            $flag = 1;
                                            break;
                                        }
                                    
                                    }else if($cvalue['Condition'] == '<'){
                                        if($value[$conkey] < $cvalue['SecondParameter']){
                                            $flag = 0;
                                        }else{
                                            $flag = 1;
                                            break;
                                        }
                                    
                                    }else if($cvalue['Condition'] == '>'){
                                        if($value[$conkey] > $cvalue['SecondParameter']){
                                            $flag = 0;
                                        }else{
                                            $flag = 1;
                                            break;
                                        }
                                    
                                    }else if($cvalue['Condition'] == 'InText'){
                                        
                                        if( strpos($cvalue['SecondParameter'] , $value[$conkey] ) !== false || strpos($value[$conkey] , $cvalue['SecondParameter']  ) !== false ){
                                            
                                            $flag = 0;
                                        }else{
                                            
                                            $flag = 1;
                                            break;
                                        }
                                    
                                    }
                                    
                                }
                                
                            }
                            
                            
                            if($flag == 0){ 
                            
                                $newTempArr[] = $value; 
                                
                            }    
                        }
                        
                       

                    }else {
                        $Query  = $Notifications['SourceAddress'];
                        $newTempArr = array();
                        if(($ValUser['DBParam'])) {
                            $arr = explode('|', $ValUser['DBParam'] );
                            if(!empty($arr[0])){
                                foreach ($arr as $v) {
                                    $val = explode(':', $v);
                                    $str = explode(',', $val[1]);
                                    $dataVal = '';
                                    if(count($str) > 1){
                                        foreach ($str as $ke => $va) {
                                            $dataVal = $dataVal .  $va . ",";
                                        }
                                    }else{
                                         $dataVal = $str[0];
                                    }
                
                                    $dataVal = rtrim($dataVal,',');
                                    $Query = str_replace("'(".$val[0].")'", $dataVal,$Query);
                                    $Query = str_replace("(".$val[0].")", $dataVal, $Query);
                                    
                                }
                            }
                        }

                        if (strpos($Query, strtolower('(nowtime)')) !== false) {
                            $currentDateValue = substr(date('Ymd'), 2);
                            $Query = str_replace("(nowtime)", $currentDateValue, $Query);
                        } 
                       
                        if($Notifications['customTable']){
                            $DBName = $ValUser['CompanyBPDb'] ;
                        }else{
                            $DBName = $ValUser['CompanyBABCDb'];
                        }
                        $LogCheck =0;
                        if(strpos($Query , ' UserHistory')){
                            $LogCheck = 1;
                            $DBName = 'BP_Admin10';

                        }
                       
                        $DBPass = 'gcsmakeit2010';
                        $DBUsername = 'jeff';
                        $DBHost = '10.30.57.5';
                        $db = new PDO("sqlsrv:Server=$DBHost;Database=$DBName;", "$DBUsername", "$DBPass");
                        // Throw an Exception when an error occurs
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                       
                        $stmt = $db->query( $Query);
                        $QueryData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $newTempArr = $QueryData;
                        $NotiCondition = $Notifications['pushCondition'] ;
                        $NowTime =  date("H:i:s", strtotime('-1 hour')) ;
                        $NowDate = date("Y-m-d") ;
                        $NewArr = array();
                        //$DateTime = date("Y-m-d H:i:s", strtotime('-1 hour'));
                        if($NotiCondition){
                            $NotiCondition = str_replace( '(NowTime)' , $NowTime , $NotiCondition );
                            $NotiCondition = str_replace( '(NowDate)' , $NowDate , $NotiCondition );
                            $NotiCondition = json_decode($NotiCondition , true);
                          
                            foreach( $newTempArr as $key => $val){
                                //if($LogCheck  ){
                                     
                                    $NewCheck  = 0;
                                    foreach( $NotiCondition as $keyN => $valNew){
                                        foreach( $valNew as $keyNew => $valN){
                                           
                                            if($valN['Condition'] == '='){
                                               
                                                if(trim($valN['SecondParameter']) == trim($val[$keyN])){
                                                    $NewCheck  =  $NewCheck+ 1;
                                                   
                                                }
                                                
                                            }else if($valN['Condition'] == '>='){
                                                
                                               $KeyData = explode('.' , $val[$keyN] );
                                               $KeyData = $KeyData[0];

                                                if( strtotime($KeyData) >=  strtotime($valN['SecondParameter']) ){
                                                    $NewCheck  = $NewCheck+1;
                                                }

                                            }
                                        }
                                            
                                    }  
                                     
                                   
                                    if($NewCheck == count($NotiCondition)){
                                        $NewArr[] = $val;
                                    } 
                                //}
                            }

                            $newTempArr = $NewArr;
                        }
                        
                    } 
                   
                   
                    if($newTempArr){

                        $DBName = 'BP_Admin10';
                        $DBPass = 'gcsmakeit2010';
                        $DBUsername = 'jeff';
                        $DBHost = '10.30.57.5';
                        $db = new PDO("sqlsrv:Server=$DBHost;Database=$DBName;", "$DBUsername", "$DBPass");
                        // Throw an Exception when an error occurs
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        if(strpos($Notifications['pushDesc'] , '(KeyValue)') !== false){
                            $KeyValue = array_map(function ($ar) {return $ar['KeyValue'];}, $newTempArr);
                            $KeyValue = array_unique($KeyValue);
                            //TableName 
                            $KeyTable = array_map(function ($ar) {return $ar['Table'];}, $newTempArr);
                            $KeyTable = array_unique($KeyTable);
                            //Field
                            $KeyField = array_map(function ($ar) {return $ar['Field'];}, $newTempArr);
                            $KeyField = array_unique($KeyField);
                            //Value before
                            $KeyValueBefore = array_map(function ($ar) {return $ar['ValueBefore'];}, $newTempArr);
                            $KeyValueBefore = array_unique($KeyValueBefore);


                            // $KeyValue = implode(',' ,  $KeyValue);
                            foreach($KeyValue as $KVKey => $KVVal){
                                $notiDes = str_replace('(KeyValue)' , $KVVal ,$Notifications['pushDesc'] );
                                $notiDes = str_replace('(ValueBefore)' , $KeyValueBefore[$KVKey] , $notiDes );

                                $notiDes = str_replace('(Table)' , $KeyTable[$KVKey] , $notiDes );
                                $notiDes = str_replace('(Field)' , $KeyField[$KVKey] , $notiDes );
                                
                                $sql = "select * from NotiLog where NotiId = '".$NotiIDVal."' AND UserID = '".$ValUser['UserID']."'  AND LogDate = '".$LogDate."' ";
                                
                                $stmt = $db->query($sql);
                                $DataPresent  = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                if(!empty($DataPresent)){
                                    $sql = "UPDATE NotiLog SET NotiDescription = :NotiDescription , dateUpdated =:dateUpdated  where NotiId = :NotiId  AND UserID = :UserID  AND LogDate = :LogDate";
                                    $stmt = $db->prepare($sql);
                                    $date = date('Y-m-d h:i:s');
                                    $stmt->bindParam(':NotiId' ,$NotiIDVal, PDO::PARAM_STR);
                                    $stmt->bindParam(':NotiDescription' ,  $notiDes, PDO::PARAM_STR);
                                    $stmt->bindParam(':UserID' , $ValUser['UserID'], PDO::PARAM_STR);
									$stmt->bindParam(':LogDate' , $LogDate, PDO::PARAM_STR);
                                    $stmt->bindParam(':dateUpdated' , $date, PDO::PARAM_STR);
                                    $stmt->execute();
                                }else {
                                    $sql = "INSERT INTO NotiLog(   DisplayStatus ,NotiId ,NotiDescription ,   UserID , PopUpDesc , dateCreated ,  dateUpdated , LogDate) 
                                    VALUES(:DisplayStatus ,:NotiId ,:NotiDescription ,:UserID ,:PopUpDesc , :dateCreated ,  :dateUpdated , :LogDate )";
                                
                                        
                                    $stmt = $db->prepare($sql);
                                    $date = date('Y-m-d h:i:s');
                                    $status = '1';
									$LogDate = $ValUser['UserLastLogoutDate'] ;
                                    $stmt->bindParam(':DisplayStatus',  $status , PDO::PARAM_STR);
                                    $stmt->bindParam(':NotiId' ,$NotiIDVal, PDO::PARAM_STR);
                                    $stmt->bindParam(':NotiDescription' ,  $notiDes, PDO::PARAM_STR);
                                    $stmt->bindParam(':UserID' , $ValUser['UserID'], PDO::PARAM_STR);
                                    $stmt->bindParam(':PopUpDesc' ,$Notifications['PopUpDescriptions'], PDO::PARAM_STR);  
                                    $stmt->bindParam(':dateCreated' ,  $date, PDO::PARAM_STR);
                                    $stmt->bindParam(':dateUpdated' , $date, PDO::PARAM_STR);
									$stmt->bindParam(':LogDate' , $LogDate, PDO::PARAM_STR);
								
                                    $stmt->execute();
                                }
                            }
                            
                           

                        }else{
							$date = date('Y-m-d h:i:s');
							$LogDate = $ValUser['UserLastLogoutDate'] ;
                            $notiDes = str_replace('(Count)' ,count($newTempArr) ,$Notifications['pushDesc'] );
                            $sql = "select * from NotiLog where NotiId = '".$NotiIDVal."' AND UserID = '".$ValUser['UserID']."' AND  LogDate = '".$LogDate."' AND CAST(dateCreated AS DATE) = '".$date."'";
                           
                            $stmt = $db->query($sql);
                            $DataPresent  = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            if(!empty($DataPresent)){
                                    $sql = "UPDATE NotiLog SET NotiDescription = :NotiDescription , dateUpdated =:dateUpdated  where NotiId = :NotiId  AND UserID = :UserID   AND LogDate = :LogDate AND CAST(dateCreated AS DATE) = :dateCreated";
                                    $stmt = $db->prepare($sql);
                                    $date = date('Y-m-d h:i:s');
                                    $stmt->bindParam(':NotiId' ,$NotiIDVal, PDO::PARAM_STR);
                                    $stmt->bindParam(':NotiDescription' ,  $notiDes, PDO::PARAM_STR);
                                    $stmt->bindParam(':UserID' , $ValUser['UserID'], PDO::PARAM_STR);
								    $stmt->bindParam(':LogDate' , $LogDate, PDO::PARAM_STR);
                                    $stmt->bindParam(':dateUpdated' , $date, PDO::PARAM_STR);
								    $stmt->bindParam(':dateCreated' , $date, PDO::PARAM_STR);
                                    $stmt->execute();
                            }else {

                                $sql = "INSERT INTO NotiLog(   DisplayStatus ,NotiId ,NotiDescription ,   UserID , PopUpDesc , dateCreated ,  dateUpdated , LogDate) 
                                VALUES(:DisplayStatus ,:NotiId ,:NotiDescription ,:UserID ,:PopUpDesc , :dateCreated ,  :dateUpdated , :LogDate)";
                            
                                    
                                $stmt = $db->prepare($sql);
                                $date = date('Y-m-d h:i:s');
                                $status = '1';
                                $stmt->bindParam(':DisplayStatus',  $status , PDO::PARAM_STR);
                                $stmt->bindParam(':NotiId' ,$NotiIDVal, PDO::PARAM_STR);
                                $stmt->bindParam(':NotiDescription' ,  $notiDes, PDO::PARAM_STR);
                                $stmt->bindParam(':UserID' , $ValUser['UserID'], PDO::PARAM_STR);
                                $stmt->bindParam(':PopUpDesc' ,$Notifications['PopUpDescriptions'], PDO::PARAM_STR);  
                                $stmt->bindParam(':dateCreated' ,  $date, PDO::PARAM_STR);
                                $stmt->bindParam(':dateUpdated' , $date, PDO::PARAM_STR);
                        		$stmt->bindParam(':LogDate' , $LogDate, PDO::PARAM_STR);
                                $stmt->execute();
                            }
                        }
                    }
                   
                }
            }
           
        }

    }

    echo "Cron Successful";
	exit;