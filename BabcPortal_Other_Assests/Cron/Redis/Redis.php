
<?php
ini_set("memory_limit", "-1");
set_time_limit(0);
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connecting to Redis server on localhost
$redis = new Redis();
$redis->connect('127.0.0.1', 32771);
// Check whether server is running or not
echo 'Redis is running: ' . $redis->ping() . '<br>';

    $currentDate =  Date('Y-m-d h:i');
    $DBName = 'BP_Admin10';
    $DBPass = 'gcsmakeit2010';
    $DBUsername = 'jeff';
    $DBHost = '10.30.57.5';
    $db = new PDO("sqlsrv:Server=$DBHost;Database=$DBName;", "$DBUsername", "$DBPass");
    // Throw an Exception when an error occurs
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $CurrentTime = Date('H:i');
    //$sql = "select * from Users where EnableCacheUser = '1'";
    $sql = "select c.* , u.*
    from Company c 
    inner join Users u on u.CompanyID = c.CompanyID 
    where (c.EnableRedisCompany = '1' or u.EnableCacheUser = '1')and  c.CompanyID = '1015' And u.UserId = '3160'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $UserData = $stmt->fetchAll();

    
    foreach ($UserData as $key => $value) {
        if( $value['AvailableUserGroup']) {
			 $checkAll = explode(',' , $value['AvailableUserGroup'] );
            
			 foreach($checkAll as $KeycheckAll => $ValcheckAll){
                $sql = "Select * from Users where UserEmail = '".$ValcheckAll."'";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $ParentUserID = $stmt->fetchAll();
               
                $userID = !empty($ParentUserID)?$ParentUserID[0]['UserID']:$value['UserID'];
                if($value['TableSelectionCompany'] == 1 || $value['TableSelection'] == 1 ){
                    $sql = "select Distinct Tables.ID as tableID , Tables.DataSourceId, Tables.Name , Tables.TimeDurationRedisTable , Tables.TimeRedisTable , Tables.DisableReports 
                            from UserPagePlaceholders , Tables
                            where Tables.ID = UserPagePlaceholders.PlaceholderId   And Tables.EnableCacheTable = '1'
                            and UserPagePlaceholders.UserId = '".$userID."'";
                    }else{
                        $sql = "select Distinct Tables.ID as tableID , Tables.DataSourceId, Tables.Name , Tables.TimeDurationRedisTable , Tables.TimeRedisTable , Tables.DisableReports 
                            from UserPagePlaceholders , Tables 
                            where Tables.ID = UserPagePlaceholders.PlaceholderId 
                            and UserPagePlaceholders.UserId = '".$userID."'";
                    }
        
                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                    $data = $stmt->fetchAll();
                   
                    $time = '';
                    $checktime = '';
				if(!empty($data )){
                
       
						if($value['OverwirteCompanySetting'] == '' && $value['OverwirteUserAndCompanySetting'] == ''){
							if($value['TimeDurationRedisCompany'] == '' && $value['TimeDurationRedisCompanyAPI'] == '' && $value['TimeRedisCompanyAPI'] == '' && $value['TimeRedisCompany']){
								if($value['TimeDurationRedisUser'] == '' && $value['TimeDurationRedisUserAPI'] == '' && $value['TimeRedisUserAPI'] == '' && $value['TimeRedisUser'] == ''){
									$time  = '00:00';
								}
							}
						}

						foreach ($data as $Datakey => $Datavalue) {
							if(strpos($Datavalue['DataSourceId'] , ',') === false){
								$sql = " select RequestType from DataSource where  ID = '".$Datavalue['DataSourceId']."'";

								$stmt = $db->prepare($sql);
								$stmt->execute();
								$dataM = $stmt->fetchAll(); 
							}


							$Datavalue['RequestType'] = isset($dataM[0]['RequestType'])?$dataM[0]['RequestType']:3;


							if($value['OverwirteCompanySetting'] == '' && $value['OverwirteUserAndCompanySetting'] == ''){

								if($value['TimeDurationRedisCompany'] != '' || $value['TimeDurationRedisCompanyAPI'] != '' || $value['TimeRedisCompanyAPI'] != '' || $value['TimeRedisCompany'] != ''){

									if($Datavalue['RequestType'] == '3'){
										$checktime = !empty($value['TimeDurationRedisCompany'])?$value['TimeDurationRedisCompany']:'';
										$time =  !empty($value['TimeRedisCompany'])?$value['TimeRedisCompany']:'';

									}else{

										$checktime = !empty($value['TimeDurationRedisCompanyAPI'])?$value['TimeDurationRedisCompanyAPI']:'';
										$time =  !empty($value['TimeRedisCompanyAPI'])?$value['TimeRedisCompanyAPI']:'';

									}

								}else if($value['TimeDurationRedisUser'] != '' || $value['TimeDurationRedisUserAPI'] != '' || $value['TimeRedisUserAPI'] != '' || $value['TimeRedisUser'] != ''){
									if($Datavalue['RequestType'] == '3'){
										$checktime = !empty($value['TimeDurationRedisUser'])?$value['TimeDurationRedisUser']:'';
										$time =  !empty($value['TimeRedisUser'])?$value['TimeRedisUser']:'';
									}else{
										$checktime = !empty($value['TimeDurationRedisUserAPI'])?$value['TimeDurationRedisUserAPI']:'';
										$time =  !empty($value['TimeRedisUserAPI'])?$value['TimeRedisUserAPI']:'';

									}
								}
							}else  if($value['OverwirteCompanySetting'] != '' ){
								if($value['TimeDurationRedisUser'] != '' || $value['TimeDurationRedisUserAPI'] != '' || $value['TimeRedisUserAPI'] || $value['TimeRedisUser']){
									if($Datavalue['RequestType'] == '3'){
										$checktime = !empty($value['TimeDurationRedisUser'])?$value['TimeDurationRedisUser']:'';
										$time =  !empty($value['TimeRedisUser'])?$value['TimeRedisUser']:'';
									}else{
										$checktime = !empty($value['TimeDurationRedisUserAPI'])?$value['TimeDurationRedisUserAPI']:'';
									}
								}
							}else if( $value['OverwirteUserAndCompanySetting'] == ''){
								$checktime = !empty($Datavalue['TimeDurationRedisTable'])?$Datavalue['TimeDurationRedisTable']:'24:00';
								$time =  !empty($Datavalue['TimeRedisTable'])?$Datavalue['TimeRedisTable']:'24:00';

							}

							//time Adding 
							if($time == '' && $checktime == ''){
								$time  = '00:00';
							}else if($checktime != ''){
								$checktimeOld  =  $checktime; 
								$checktime  = explode(':', trim($checktime));
							}

							if($time != ''){
								$time = $time;
								$checktimeOld  = '';
								$checktimeNew  = explode(',', trim($time));
							}


							$Uid = trim($value['UserID'].$ValcheckAll);
							$sql = "select * from RedisLog where UserID = '".$Uid."' and CompanyID = '".$value['CompanyID']."' and TableID = '".$Datavalue['tableID']."'";
							$stmt = $db->prepare($sql);
							$stmt->execute();
							$RedisData = $stmt->fetchAll();
                           
							if($checktimeOld){

								$DateUpdated = isset($RedisData[0]['DateUpdated'])?$RedisData[0]['DateUpdated']:'';
								if($DateUpdated){
									$diff=(strtotime($currentDate)-strtotime($DateUpdated))/60;
									$diff = floor($diff / 60);  

									if($diff >= $checktimeOld ){
										$keyName = $value['CompanyID'] .'-'.$Uid .'-'.$Datavalue['tableID'];

										if ($redis->exists([$Uid ,$keyName]) === 1) {

											$redis->del($Uid ,$keyName);
											$sql = "update RedisLog  set DateUpdated  = '".$currentDate."' where UserID = '".$Uid."' and CompanyID = '".$value['CompanyID']."' and TableID = '".$Datavalue['tableID']."'";
											$stmt = $db->prepare($sql);
											$stmt->execute();

										}
									}
								}else{
									$keyName = $value['CompanyID'] .'-'.$Uid.'-'.$Datavalue['tableID'];

										if ($redis->exists([$Uid ,$keyName]) === 1) {

											$redis->del($Uid ,$keyName);
											$sql = "Insert into RedisLog (UserID,CompanyID, TableID, DateCreated , DateUpdated , TimeUpdated) VALUES (
											'". $Uid."', '".$value['CompanyID']."' , '".$Datavalue['tableID']."' , '".$currentDate."'  , '".$currentDate."' , '')";
											$stmt = $db->prepare($sql);
											$stmt->execute();

										}
								}


							}else if(!empty($RedisData) && $time){


								foreach($checktimeNew as $NewKey => $NewVal){
									$CurrentTime = Date('H:i');
									$CurrentTime   =   strtotime($CurrentTime);
									$endTime = date("H:i", strtotime('+1 hours', strtotime($NewVal))); // $now + 3 hours

									$NewVal1   =   strtotime($NewVal);
									$endTime =  strtotime($endTime);

									if( $CurrentTime >= $NewVal1  &&  $CurrentTime <= $endTime ){

										$keyName = $value['CompanyID'] .'-'.$Uid .'-'.$Datavalue['tableID'];

										if ($redis->exists([$Uid ,$keyName]) === 1) {

											$redis->del($Uid ,$keyName);
											$sql = "update RedisLog  set DateUpdated  = '".$currentDate."' where UserID = '".$Uid."' and CompanyID = '".$value['CompanyID']."' and TableID = '".$Datavalue['tableID']."'";
											$stmt = $db->prepare($sql);
											$stmt->execute();

										}
									}
								}

							}else {
                               
                               
								foreach($checktimeNew as $NewKey => $NewVal){
									$CurrentTime = Date('H:i');
									$CurrentTime1   =   strtotime($CurrentTime);
									$endTime = date("H:i", strtotime('+1 hours', strtotime($NewVal))); // $now + 3 hours

									$NewVal1   =   strtotime($NewVal);
									$endTime =  strtotime($endTime);
                                   
	
									if( $CurrentTime1 >= $NewVal1  &&  $CurrentTime1 <= $endTime ){
                                       
										$keyName = trim($value['CompanyID'] .'-'.$Uid .'-'.$Datavalue['tableID']);
                                         
										if ($redis->exists([$Uid ,$keyName]) === 1) {
                                          	$redis->del($Uid ,$keyName);

											$sql = "Insert into RedisLog (UserID,CompanyID, TableID, DateCreated , DateUpdated , TimeUpdated) VALUES (
											'". $Uid ."', '".$value['CompanyID']."' , '".$Datavalue['tableID']."' , '".$currentDate."'  , '".$currentDate."' , '')" ;

											$stmt = $db->prepare($sql);
											$stmt->execute();

										}
									}else{
										$keyName = $value['CompanyID'] .'-'.$Uid.'-'.$Datavalue['tableID'];

										if ($redis->exists([$Uid ,$keyName]) === 1) {

											$redis->del($Uid ,$keyName);
											//print_r($keyName ); 
											$sql = "Insert into RedisLog (UserID,CompanyID, TableID, DateCreated , DateUpdated , TimeUpdated) VALUES (
											'". $Uid ."', '".$value['CompanyID']."' , '".$Datavalue['tableID']."' , '".$currentDate."'  , '".$currentDate."' , '')" ;

											$stmt = $db->prepare($sql);
											$stmt->execute();

										}
									}
								}
							}




						}
					}
			 }
	
		}else{
			if($value['TableSelectionCompany'] == 1 || $value['TableSelection'] == 1 ){
        	$sql = "select Distinct Tables.ID as tableID , Tables.DataSourceId, Tables.Name , Tables.TimeDurationRedisTable , Tables.TimeRedisTable , Tables.DisableReports 
                from UserPagePlaceholders , Tables
                where Tables.ID = UserPagePlaceholders.PlaceholderId   And Tables.EnableCacheTable = '1'
                and UserPagePlaceholders.UserId = '".$value['UserID']."'";
        }else{
            $sql = "select Distinct Tables.ID as tableID , Tables.DataSourceId, Tables.Name , Tables.TimeDurationRedisTable , Tables.TimeRedisTable , Tables.DisableReports 
                from UserPagePlaceholders , Tables 
                where Tables.ID = UserPagePlaceholders.PlaceholderId 
                and UserPagePlaceholders.UserId = '".$value['UserID']."'";
        }
       
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $time = '';
		$checktime = '';
		
        if(!empty($data )){
                
       
            if($value['OverwirteCompanySetting'] == '' && $value['OverwirteUserAndCompanySetting'] == ''){
                if($value['TimeDurationRedisCompany'] == '' && $value['TimeDurationRedisCompanyAPI'] == '' && $value['TimeRedisCompanyAPI'] == '' && $value['TimeRedisCompany']){
                    if($value['TimeDurationRedisUser'] == '' && $value['TimeDurationRedisUserAPI'] == '' && $value['TimeRedisUserAPI'] == '' && $value['TimeRedisUser'] == ''){
                        $time  = '00:00';
                    }
                }
            }
            
            foreach ($data as $Datakey => $Datavalue) {
                if(strpos($Datavalue['DataSourceId'] , ',') === false){
                    $sql = " select RequestType from DataSource where  ID = '".$Datavalue['DataSourceId']."'";
                   
                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                    $dataM = $stmt->fetchAll(); 
                }
                
               
                $Datavalue['RequestType'] = isset($dataM[0]['RequestType'])?$dataM[0]['RequestType']:3;
               
				 
                if($value['OverwirteCompanySetting'] == '' && $value['OverwirteUserAndCompanySetting'] == ''){
                    
                    if($value['TimeDurationRedisCompany'] != '' || $value['TimeDurationRedisCompanyAPI'] != '' || $value['TimeRedisCompanyAPI'] != '' || $value['TimeRedisCompany'] != ''){
                       
                        if($Datavalue['RequestType'] == '3'){
                            $checktime = !empty($value['TimeDurationRedisCompany'])?$value['TimeDurationRedisCompany']:'';
                            $time =  !empty($value['TimeRedisCompany'])?$value['TimeRedisCompany']:'';

                        }else{
                            
                            $checktime = !empty($value['TimeDurationRedisCompanyAPI'])?$value['TimeDurationRedisCompanyAPI']:'';
                            $time =  !empty($value['TimeRedisCompanyAPI'])?$value['TimeRedisCompanyAPI']:'';
     							
                        }
                        
                    }else if($value['TimeDurationRedisUser'] != '' || $value['TimeDurationRedisUserAPI'] != '' || $value['TimeRedisUserAPI'] != '' || $value['TimeRedisUser'] != ''){
                        if($Datavalue['RequestType'] == '3'){
                            $checktime = !empty($value['TimeDurationRedisUser'])?$value['TimeDurationRedisUser']:'';
                            $time =  !empty($value['TimeRedisUser'])?$value['TimeRedisUser']:'';
                        }else{
                            $checktime = !empty($value['TimeDurationRedisUserAPI'])?$value['TimeDurationRedisUserAPI']:'';
                            $time =  !empty($value['TimeRedisUserAPI'])?$value['TimeRedisUserAPI']:'';
                           
                        }
                    }
                }else  if($value['OverwirteCompanySetting'] != '' ){
                    if($value['TimeDurationRedisUser'] != '' || $value['TimeDurationRedisUserAPI'] != '' || $value['TimeRedisUserAPI'] || $value['TimeRedisUser']){
                        if($Datavalue['RequestType'] == '3'){
                            $checktime = !empty($value['TimeDurationRedisUser'])?$value['TimeDurationRedisUser']:'';
                            $time =  !empty($value['TimeRedisUser'])?$value['TimeRedisUser']:'';
                        }else{
                            $checktime = !empty($value['TimeDurationRedisUserAPI'])?$value['TimeDurationRedisUserAPI']:'';
                        }
                    }
                }else if( $value['OverwirteUserAndCompanySetting'] == ''){
                    $checktime = !empty($Datavalue['TimeDurationRedisTable'])?$Datavalue['TimeDurationRedisTable']:'24:00';
                    $time =  !empty($Datavalue['TimeRedisTable'])?$Datavalue['TimeRedisTable']:'24:00';

                }
               
                //time Adding 
                if($time == '' && $checktime == ''){
                    $time  = '00:00';
                }else if($checktime != ''){
                    $checktimeOld  =  $checktime; 
                    $checktime  = explode(':', trim($checktime));
                }

                if($time != ''){
                    $time = $time;
                    $checktimeOld  = '';
                    $checktimeNew  = explode(',', trim($time));
                }
             
		
              
                $sql = "select * from RedisLog where UserID = '".$value['UserID']."' and CompanyID = '".$value['CompanyID']."' and TableID = '".$Datavalue['tableID']."'";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $RedisData = $stmt->fetchAll();
               
                if($checktimeOld){
					
                    $DateUpdated = isset($RedisData[0]['DateUpdated'])?$RedisData[0]['DateUpdated']:'';
    				if($DateUpdated){
						 $diff=(strtotime($currentDate)-strtotime($DateUpdated))/60;
						$diff = floor($diff / 60);  

						if($diff >= $checktimeOld ){
							$keyName = $value['CompanyID'] .'-'.$value['UserID'] .'-'.$Datavalue['tableID'];

							if ($redis->exists([$value['UserID'] ,$keyName]) === 1) {

								$redis->del($value['UserID'] ,$keyName);
								$sql = "update RedisLog  set DateUpdated  = '".$currentDate."' where UserID = '".$value['UserID']."' and CompanyID = '".$value['CompanyID']."' and TableID = '".$Datavalue['tableID']."'";
								$stmt = $db->prepare($sql);
								$stmt->execute();

							}
						}
					}else{
						$keyName = $value['CompanyID'] .'-'.$value['UserID'] .'-'.$Datavalue['tableID'];

							if ($redis->exists([$value['UserID'] ,$keyName]) === 1) {

								$redis->del($value['UserID'] ,$keyName);
								$sql = "Insert into RedisLog (UserID,CompanyID, TableID, DateCreated , DateUpdated , TimeUpdated) VALUES (
                                '". $value['UserID'] ."', '".$value['CompanyID']."' , '".$Datavalue['tableID']."' , '".$currentDate."'  , '".$currentDate."' , '')";
								$stmt = $db->prepare($sql);
								$stmt->execute();

							}
					}
                   
    
                }else if(!empty($RedisData) && $time){
                   
                    
                    foreach($checktimeNew as $NewKey => $NewVal){
						$CurrentTime = Date('H:i');
                        $CurrentTime   =   strtotime($CurrentTime);
                        $endTime = date("H:i", strtotime('+1 hours', strtotime($NewVal))); // $now + 3 hours
                    
                        $NewVal1   =   strtotime($NewVal);
                        $endTime =  strtotime($endTime);
                        
                        if( $CurrentTime >= $NewVal1  &&  $CurrentTime <= $endTime ){
                            
                            $keyName = $value['CompanyID'] .'-'.$value['UserID'] .'-'.$Datavalue['tableID'];
                   
                            if ($redis->exists([$value['UserID'] ,$keyName]) === 1) {
                               
                                $redis->del($value['UserID'] ,$keyName);
                                $sql = "update RedisLog  set DateUpdated  = '".$currentDate."' where UserID = '".$value['UserID']."' and CompanyID = '".$value['CompanyID']."' and TableID = '".$Datavalue['tableID']."'";
                                $stmt = $db->prepare($sql);
                                $stmt->execute();
                                
                            }
                        }
                    }
                    
                }else {
                    
                    foreach($checktimeNew as $NewKey => $NewVal){
                       $CurrentTime = Date('H:i');
                        $CurrentTime1   =   strtotime($CurrentTime);
                        $endTime = date("H:i", strtotime('+1 hours', strtotime($NewVal))); // $now + 3 hours
                       
                        $NewVal1   =   strtotime($NewVal);
                        $endTime =  strtotime($endTime);
                       
                        if( $CurrentTime1 >= $NewVal1  &&  $CurrentTime1 <= $endTime ){
                           
                           
                            $keyName = $value['CompanyID'] .'-'.$value['UserID'] .'-'.$Datavalue['tableID'];
                           
                            
                            if ($redis->exists([$value['UserID'] ,$keyName]) === 1) {
                        
                                $redis->del($value['UserID'] ,$keyName);
                                
                                $sql = "Insert into RedisLog (UserID,CompanyID, TableID, DateCreated , DateUpdated , TimeUpdated) VALUES (
                                '". $value['UserID'] ."', '".$value['CompanyID']."' , '".$Datavalue['tableID']."' , '".$currentDate."'  , '".$currentDate."' , '')" ;
                            
                                $stmt = $db->prepare($sql);
                                $stmt->execute();
                                
                            }
                        }else{
                            $keyName = $value['CompanyID'] .'-'.$value['UserID'] .'-'.$Datavalue['tableID'];
                                
                            if ($redis->exists([$value['UserID'] ,$keyName]) === 1) {
                        
                                $redis->del($value['UserID'] ,$keyName);
                                print_r($keyName ); 
                                $sql = "Insert into RedisLog (UserID,CompanyID, TableID, DateCreated , DateUpdated , TimeUpdated) VALUES (
                                '". $value['UserID'] ."', '".$value['CompanyID']."' , '".$Datavalue['tableID']."' , '".$currentDate."'  , '".$currentDate."' , '')" ;
                            
                                $stmt = $db->prepare($sql);
                                $stmt->execute();
                                
                            }
                        }
                    }
                }
    
               
               
    
            }
        }
	}
		
        
  
        
    }
    print_r('success'); exit;
   










?>