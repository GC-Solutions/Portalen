<?php


ini_set("memory_limit", "-1");
set_time_limit(0);
ini_set('display_errors', 1);
error_reporting(E_ALL);

 function getDB($DBName)
{
	 $DBPass = 'gcsmakeit2010';
	 $DBUsername = 'jeff';
	 $DBHost = '10.30.57.5';
     $db = new PDO("sqlsrv:Server=$DBHost;Database=$DBName;", "$DBUsername", "$DBPass" );
     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     return $db;
}
	
function verifyGroupUser($email){
	
        if (!empty($email)) {
            $conditions[] = 'UserEmail = ?';
            $parameters[] = $email;
        }

        $sql = "SELECT * FROM Users";
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $db = getDB('BP_Admin10');
        $stmt = $db->prepare($sql);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
        return $data;

}
function getUserPages($userId){
	try {
            $db = getDB('BP_Admin10');
            $sql = "SELECT Pages.PageFilename,Pages.ID AS PageTableID,Pages.PageText,UserPageAccess.ShowAsMenu,UserPageAccess.ID AS userPageId, UserPageAccess.ParentPages, UserPageAccess.PageMenuText ,UserPageAccess.PageId, UserPageAccess.ParentPageText , UserPageAccess.SecondaryPageMenuOrder , UserPageAccess.SecondaryChildPageMenuOrder,
                UserPageAccess.ParentLinkFlag , UserPageAccess.DefaultFirstPage , UserPageAccess.PageMenuOrder  , UserPageAccess.EnableTicketMenuLabel  , UserPageAccess.EnableTicketClickFilter , UserPageAccess.EnableFixedHeader ,    UserPageAccess.EnableFixedLeftColumn ,  UserPageAccess.ID as UserPageAccessID

			FROM Pages,UserPageAccess
			WHERE UserPageAccess.PageId = Pages.ID AND UserPageAccess.UserId ='" . $userId . "' ORDER BY UserPageAccess.PageMenuOrder ASC";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;

        } catch (PDOException $e) {
        }
	
}
 function getUserDetails($id){
            if (!empty($id)) {
                $conditions[] = 'UserID = ?';
                $parameters[] = $id;
            }
            $sql = "SELECT * FROM Users";
            if ($conditions) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }
            $db = getDB('BP_Admin10');
            $stmt = $db->prepare($sql);
            $stmt->execute($parameters);
            $data = $stmt->fetchAll();
        
            return $data;
        }

function getCompanyDetails($id){
	   // Make Connection with DB 
       $db = getDB('BP_Admin10');
       // this Code allows us to add multiple condition parameter and its value . 
       if (!empty($id)) {
            $conditions[] = 'CompanyID = ?';
            $parameters[] = $id;
        }
        // Query 
        $sql = "SELECT * FROM Company";
        // concatenate condition if id is given 
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        //prepare query to bind value .
        $stmt = $db->prepare($sql);
        // Execute query 
        $stmt->execute($parameters);
        // fetch all data 
        $data = $stmt->fetchAll();
       
        if(!empty($data) &&  isset($_SESSION['UserID'])){
           
            $UserData =  getUserDetails($_SESSION['UserID']);
           
            if($UserData[0]['EnableFreshDeskUser']){
                $data[0]['CompanyBPDb'] = 'GCS_Tickets_Portal';
            }
        }
       
        return $data;

}
 function getCompaniesDetails($id)
{
    // Make Connection with DB 
    $db = getDB('BP_Admin10');
    // this Code allows us to add multiple condition parameter and its value .
    if (!empty($id)) {
        $conditions[] = ' u.UserID = ?';
        $parameters[] = $id;
    }
    // Query to get all comapny with inner join on user . 
    // this query will get all those company that have an entry on user table to with same company ID .
    $sql = "SELECT * FROM Company c Inner Join Users u ON c.CompanyID = u.CompanyID";
    // if Contion is applied then this query will get all those company that have an entry on user
    // table to with same company ID  and with the same userid as mention in where Clause.
    if ($conditions) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }
    //preapre query to bind value 
    $stmt = $db->prepare($sql);
    //Execute Query
    $stmt->execute($parameters);
    // Fetch All Data 
    $data = $stmt->fetchAll();
    if(!empty($data)){
        
        if($data[0]['EnableFreshDeskUser']){
            $data[0]['CompanyBPDb'] = 'GCS_Tickets_Portal';
        }
    }
    return $data;
}
 function getPagePlaceholders($pageId, $userId, $pageText)
{
    $db = getDB('BP_Admin10');
    $sql = "select UserPageAccess.*, UserPagePlaceholders.*
            from UserPageAccess, UserPagePlaceholders
            WHERE
            UserPageAccess.ID = UserPagePlaceholders.UserPageAccessId
            AND UserPageAccess.PageId =" . $pageId . "
            AND UserPageAccess.UserId =" . $userId . "
            AND UserPageAccess.PageMenuText ='" .$pageText . "'";
    //echo $sql;
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll();
    return $data;
}
function getDatasourceTableDetails($id)
{
    try {

        $db = getDB('BP_Admin10');
        $sql = "select TableType , DataSourceId from Tables
                where Tables.ID =" . $id . "";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $res= $stmt->fetchAll();
       
        if( isset($res[0]) && $res[0]['TableType'] == '3')
            {
                $Ids = '';
                $DataSourceId = explode(',',  $res[0]['DataSourceId']);
                foreach ($DataSourceId as $key => $value) {
                    if(empty($Ids)){
                        $Ids = "'". $value ."',";
                    }else{
                        $Ids = $Ids."'". $value ."',";
                    }
                }
                $Ids = trim($Ids , ',');

                $sql = "select Tables.*, DataSource.*, Tables.Columns as tableColumns
                from Tables, DataSource
                WHERE
                DataSource.ID IN (".$Ids.")
                AND Tables.ID =" . $id . "";
                
                
            }else{
                  $sql = "select Tables.*, DataSource.*, Tables.Columns as tableColumns
                    from Tables, DataSource
                    WHERE
                    DataSource.ID IN (Tables.DataSourceId)
                    AND Tables.ID =" . $id . "";
            }

        
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $data = $stmt->fetchAll();
    } catch (Exception $exc) {
    }
}
function getTableActionDetails($id)
{
    try {
        $db = getDB('BP_Admin10');
        $sql = "select TableActions.*, UserPagePlaceholders.*
            from TableActions, UserPagePlaceholders
            WHERE UserPagePlaceholders.ID =" . $id . "";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $data = $stmt->fetchAll();
    } catch (Exception $exc) {
    }
}
function getTableActionDetailsByIdIN($id){
    try {
        $db = getDB('BP_Admin10');
        $sql = "select TableActions.*, DataSource.* from DataSource, TableActions
            WHERE DataSource.ID = TableActions.DataSourceId AND TableActions.ID IN (" . $id . ")";
        
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $data = $stmt->fetchAll();
    } catch (Exception $exc) {
    }
}
function executeQuery($query, $databaseName, $Table = '' ){
    $db = getDB($databaseName);
    try{
        
        $stmt = $db->query($query);
        $data = $stmt->fetchAll();
        //print_r($query); exit;
        }
    catch(PDOException $e){
            if( $e->getCode() == '42S02'){
                $data = 'createTable';
            }
        }
    
    return $data;
}
function ColumnProperties($columnData,$singleColumnValue)
{
    if(is_array($columnData)) // condition if more an array conatining the properties are given 
    {
        foreach ($columnData as $key => $value) {
            if(is_array($singleColumnValue)) {
                if (array_key_exists("type",$singleColumnValue) && $singleColumnValue['type'] == 'decimals')
                {
                    
                    if (array_key_exists("decimals",$singleColumnValue) && array_key_exists("thousand_sep",$singleColumnValue) && array_key_exists("decimal_point",$singleColumnValue)) {
                        $thousandSep = $singleColumnValue['thousand_sep'];
                        $decimals = $singleColumnValue['decimals'];
                        $decimalPoint = $singleColumnValue['decimal_point'];
                        $value = (float)$value;
                        $value = rtrim(rtrim((string)number_format($value, $decimals, $decimalPoint, $thousandSep),""),$decimalPoint);
                    }
                }
                if (array_key_exists("type",$singleColumnValue) && $singleColumnValue['type'] == 'integer')
                {
                    if ($value && is_numeric($value)) {
                        $value = round($value);
                    }
                }

                if (array_key_exists("type",$singleColumnValue) && $singleColumnValue['type'] == 'text')
                {
                            
                    $value = (string)$value;
                }

                
            }
            $columnData[$key] = $value;
        }
    }else{
        
        if(is_array($singleColumnValue)) {
            if (array_key_exists("type",$singleColumnValue) && $singleColumnValue['type'] == 'decimals')
            {
                if (array_key_exists("decimals",$singleColumnValue) && array_key_exists("thousand_sep",$singleColumnValue) && array_key_exists("decimal_point",$singleColumnValue)) {
                    $thousandSep = $singleColumnValue['thousand_sep'];
                    $decimals = $singleColumnValue['decimals'];
                    $decimalPoint = $singleColumnValue['decimal_point'];
                    $columnData = (float)$columnData;
                    $columnData = rtrim(rtrim((string)number_format($columnData, $decimals, $decimalPoint, $thousandSep),""),$decimalPoint);
                }
            }
            if (array_key_exists("type",$singleColumnValue) && $singleColumnValue['type'] == 'integer')
            {
                if ($columnData && is_numeric($columnData)) {
                    $columnData = round($columnData);
                }
            }

            if (array_key_exists("type",$singleColumnValue) && $singleColumnValue['type'] == 'text')
            {
                $columnData = (string)$columnData;
                    
            }

            if (array_key_exists("type",$singleColumnValue) && $singleColumnValue['type'] == 'date')
            {
                //$columnData = date("Y-m-d", strtotime($columnData));
                // do nothing
            }
        }else{
            
                $columnData = (string)$columnData;
                    
            
        }
        
    }
    return $columnData;
}
     // This Function Basically perform Round Off the numerical number
function columnDataRound($columnData,$singleColumnValue)
{
    if(is_array($columnData))
    {
        foreach ($columnData as $key => $value) {

            if(!is_array($singleColumnValue)) {
                if ($value && is_numeric($value)) {
                    $value = round($value);
                }
            }
            $columnData[$key] = $value;
        }
    }else{
        if(!is_array($singleColumnValue)) {
            
            if ($columnData && is_float($columnData)) {
                $columnData  = $columnData;
            }
            else if ($columnData && is_numeric($columnData)) {
                if($singleColumnValue == 'Volyme'){
                    $columnData =$columnData;
                }else{
                    $columnData = round($columnData);
                }
                
            }
        }
    }
    return $columnData;
}
function searchArray(array $array, $search)
{
    while ($array) { 
        if (isset($array[$search])) return $array[$search];
        $segment = array_shift($array);
        if (is_array($segment)) {
            if ($return = searchArray($segment, $search)) return $return; // recursive function that will perform search on inner nodes 
        }
    }
    return false;
}
function addforLoops( $value , $params , $count = 0  , $cntNew = 0 )
    {
        // Variable declaration 
        $res = array();
        $singleFlag = 0;
        //(Start) Part Specially for Product Text because they have inner node that have same name for index.
        if( $params[$count] == 'ProductText')
        {
           
            $nam = trim($params[$count]);
            $count = $count + 1;
        
            if(!empty($value[$nam])){
                $value = $value[$nam];
                foreach ($value as $keys => $values) {

                    if($values['Field'] == $params[$count]){
                            $res = $values['Value'];
                            
                        }
                     
                }
            }   
        }//(End) Part Specially for Product Text because they have inner node that have same name for index.
        else if(!isset($value[trim($params[$count])]) && array_key_exists( $count + 1,$params))
        {
            $nam = trim($params[$count]);
            if(isset($value[$nam])){
                $value = $value[$nam];
            }   
            if( $count < count($params)-1){
                $cntNeaw = $count + 1; 
            }
            $singleFlag = 1;
            // Performing a recursive FUnction to fuction inner data of nodes
            addforLoops($value , $params , $cntNeaw ); 
        }else{
            $res = isset($value[trim($params[$count])])?$value[trim($params[$count])]:'';
        }

        if($count > $cntNew && $cntNew != 0)
        {
            $GLOBALS['flag1'] = $count;
        }
        $cnt = count($params);
        $cntNew = 0;
        // generating the data part .
        if( is_array($res) && !isset($res[0])  &&  $params[0] != 'ProductText' ){
            
            if( $count < $cnt-1){
                $cntNew = $count + 1;
            }
            if($singleFlag)
            {
                addforLoops($value , $params , $cntNew , $count );
            }else{
                addforLoops($res , $params , $cntNew , $count );
            }
        }
        else if( is_array($res) && count($res) >= 1  &&  $params[0] != 'ProductText'){ 
           
           foreach ($res as $key => $val) {
                if( $count < $cnt-1){
                    $count = $count + 1;
                }
                addforLoops($val , $params , $count );
                
                if( $GLOBALS['flag1'] )
                {
                   $count = $count - 1;
                }
                else{
                    $count = 0;
                }
           }
        }
        else
        {
            $GLOBALS['flag1'] = $count;
            if($res == '')
            {
                $res = 0;
            }
            array_push($GLOBALS['retVal'], $res);
        }
       return $GLOBALS['retVal'];
        
    }
function SumCalulation($sumType , $customSumData , $columnSumResults , $getColumnsProperties , $sumColumnLable , $searchValue , $searchValueArray , $columnSumResultsValue , $value1 , $dataToTable  ,$type = 'multiple'){
      
    if ($sumType == 1) {
        if ($columnSumResults && is_numeric($columnSumResults)) {
            $columnSumResults = round($columnSumResults);
        }

        if (!empty($searchValue) && !empty($searchValueArray)) {
            $columnSumResultsValue = strtolower($columnSumResults);

            if (!empty($columnSumResultsValue)) {
                foreach ($searchValueArray as $searchValue) {
                    if(isset($searchValue) && !empty($searchValue)) {
                        if (strpos($columnSumResultsValue, $searchValue) !== false) {
                            $matchedData = true;
                            $matchedValueCount++;
                        }
                    }
                }
            }

            if(!empty($getColumnsProperties[$sumColumnLable])){
                $columnSumResults = ColumnProperties($columnSumResults,$getColumnsProperties[$sumColumnLable]);
            }
            return  $columnSumResults;
        } else {
            if(!empty($getColumnsProperties[$sumColumnLable])){
                $columnSumResults = ColumnProperties($columnSumResults,$getColumnsProperties[$sumColumnLable]);
            }
            return $columnSumResults;
        }
    } else if ($sumType == 2) 
    {
        
        $csData = explode(',' , $value1); // 
        $sumLabel = explode(',' , $sumColumnLable); 
        
        foreach ($csData as $key => $value) {
            
            if (strpos($value, '--') === false) {
                
                if(1 === preg_match('~[0-9]~',  $value)){
                    try{
                        @eval('$result = (' . @$value . ');');

                    }catch(Exception $e){
                        $result = 0;
                    }
                }else{
                    $result = 0;
                }
                
                if (is_nan($result)) {
                    $result = 0;
                } else if(is_infinite($result)) {
                    $result = 100;
                }
                if (!empty($searchValue) && !empty($searchValueArray)) {
                    $resultValue = strtolower($result);

                    if (!empty($resultValue)) {
                        foreach ($searchValueArray as $searchValue) {
                            if(isset($searchValue) && !empty($searchValue)) {
                                if (strpos($resultValue, $searchValue) !== false) {
                                    $matchedData = true;
                                    $matchedValueCount++;
                                }
                            }
                        }
                    }
                    
                    if(!empty($getColumnsProperties[$sumLabel[$key]])){
                        $result = ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                    }
                    return $result;

                } else {
                    $sumLabelkey = trim($sumLabel[$key]);
                    if(!empty($getColumnsProperties[$sumLabelkey])){
                        $result = ColumnProperties($result,$getColumnsProperties[$sumLabelkey]);
                    }
                    
                    if($type == 'single')
                    {
                        return $result;
                    }else{
                        array_push($tempArr[$key], $result);
                    }
                }
            } else{
                
                $value = str_replace('--', '+', $value);
                try{
                    @eval('$result = (' . @$value . ');');
                    //eval("\$result = $customSumData;");
                }
                catch(Exception $e){
                    $result = 0;
                }
                if (is_nan($result)) {
                    $result = 0;
                } else if(is_infinite($result)) {
                    $result = 100;
                }
                if (!empty($searchValue) && !empty($searchValueArray)) {
                    $resultValue = strtolower($result);

                    if (!empty($resultValue)) {
                        foreach ($searchValueArray as $searchValue) {
                            if(isset($searchValue) && !empty($searchValue)) {
                                if (strpos($resultValue, $searchValue) !== false) {
                                    $matchedData = true;
                                    $matchedValueCount++;
                                }
                            }
                        }
                    }

                    if(!empty($getColumnsProperties[$sumLabel[$key]])){
                        $result =ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                    }
                } else {
                    if(!empty($getColumnsProperties[$sumLabel[$key]])){
                        $result = ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                    }
                    if($type == 'single')
                    {
                            return $result;
                    }else{
                        array_push($tempArr[$key], $result);
                    }
                    
                }
            }
        }
    }
}
 function getActionButton($tableActions , $dataToTable , $actationTableColumn , $placeholderId , $userPagePlaceholder){
    $orderNoCol = '';
    $orderNoValue = '';
   
    // (Start) Condition Setting the OrderNo COl and it Value thats being set from admin side 
    if(count($tableActions) > 1) {
        foreach ($tableActions as $eachAction) {
            foreach ($eachAction as $actionDetails) {
                if ((isset($actionDetails['TableParameterColumn']))) {
                    $orderNoCol .= $actionDetails['TableParameterColumn'].'||';
                }
                if ((isset($actionDetails['TableParameterColumnValue']))) {
                    $orderNoValue .= $actionDetails['TableParameterColumnValue'].'||';
                }
            }
        }

        $orderNoCol = rtrim($orderNoCol, '||');
        $orderNoValue = rtrim($orderNoValue, '||');
    }
    // (Start) Condition Setting the OrderNo COl and it Value thats being set from admin side 
    // variable declaration
    $names_ = "";
    $actions_ = "";
    $t = "";
    $txt_ =  "";
    $class_ = "";
    $separator= "%";
    //(Start) For all the table Action defined for that table rows .
    foreach ($tableActions as $key => $eachAction) {
        if(isset($key) && !in_array($key,$actationTableColumn)) {
            foreach ($eachAction as $actionDetails) {
                //Get External Url if defined .
                $externalUrl = $actionDetails['ExternalUrl'];
                $tableParameterColumnValue = (isset($actionDetails['TableParameterColumnValue'])) ? $actionDetails['TableParameterColumnValue'] : "";
               
                if(count($tableActions) == 1) {
                    $orderNoCol = '';
                    $orderNoValue = '';
                    $orderNoCol = $actionDetails['TableParameterColumn'];
                    $orderNoValue = $tableParameterColumnValue;
                    
                }
                $pageTextValue = '';
                //(Start) Get page Text 
                if($_SESSION['UserID'] && $actionDetails['PageTargetId']) {
                    $pageText = getPageText($actionDetails['PageTargetId'], $_SESSION['UserID']);
                    if($pageText) {
                        $pageTextValue = $pageText[0]['PageMenuText'];
                    }
                }
                 //(End) Get page Text 
                 //(Start) In Case if External Url is defined 
                if (!empty($externalUrl)) {
                    $buttonAction = $externalUrl;
                } //(end)In Case if External Url is defined 
                else {
                //(Start) if external Url not defined 
                    $buttonAction = baseUrl . 'page?id=' . $actionDetails['PageTargetId'] . '&page_text='. $pageTextValue .'&columnName=' . $actionDetails['TableParameterColumn'] . '&columnValue=' . $tableParameterColumnValue;
                }
                //(End) if external Url not defined 
                //(Start) if the action selected is Update DataSource . it can be update through form or predefined update .
                if ($actionDetails['updateDataSource'] == 1) {
                    $parameterArray = array('orderNoCol'=>$orderNoCol,'orderNoValue'=>$orderNoValue,'baseUrl' => baseUrl, 'pageTextValue' => rawurlencode ($pageTextValue), 'dataSourceId' => $actionDetails['DataSourceId'],'pageTargetId' => $actionDetails['PageTargetId']);
                    if( $actionDetails['PredefinedUpdate'] == 1 &&  ($actionDetails['PredefinedUpdateRedis'] == 1) && isset($_SESSION['CacheUser'])){
                        $parameterArray['placeholderId'] = $placeholderId;
                        $parameterArray['userPagePlaceholder'] = $userPagePlaceholder;
                        $parameterArray['DeleteRedis'] = 1;
                    }
                    $parameterArray = json_encode($parameterArray, JSON_UNESCAPED_SLASHES);
                    // (Start) For predefined Update 
                    if ($actionDetails['PredefinedUpdate'] == 1) {
                        $buttonAction = 'getUpdatePredefined('. $parameterArray .')';
                        $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                        $class_ .= str_replace("http://","",$buttonAction).$separator;
                    } 
                    // (End)For predefined Update 
                    // (Start)For Update a DataSoucre Call 
                    else if ($actionDetails['DataSourceCall'] == 1) {
                        $buttonAction = 'getUpdateDataSourceCall('. $parameterArray .')';
                        $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                        $class_ .= str_replace("http://","",$buttonAction).$separator;
                    } 
                    // (End)For Update a DataSoucre Call 
                    else if($actionDetails['FormOnActionBTN'] == 1) {
                        $buttonAction = "LiveAPISyncReport('create' , '1698' , '2' , '0')";
                        $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                        $class_ .= str_replace("http://","",$buttonAction).$separator;
                    } 
                    // (Start)For Update row from Form  
                    else {
                        
                        $buttonAction = baseUrl . 'getUpdateForm?dataSourceId=' . $actionDetails['DataSourceId'] .   '&pageId=' . $actionDetails['PageTargetId']  . '&columnName=' . $orderNoCol . '&columnValue=' . $orderNoValue . '&tableID=' . $actionDetails['TableTemplateId']. '&page_text='. rawurlencode ($pageTextValue) ;
                       
                        if( ($actionDetails['PredefinedUpdateRedis'] == 1) && isset($_SESSION['CacheUser'])){
                            $buttonAction = $buttonAction.'&placeholderId='.$placeholderId.'&userPagePlaceholder=' .  $userPagePlaceholder . '&DeleteRedis=1';
                        }
                        $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                        $class_ .= str_replace("http://","",$buttonAction).$separator;
                    }
                    // (End))For Update row from Form 
                } 
                //(End) if the action selected is Update DataSource . it can be update through form or predefined update .
                else {
                    // (Start ) if you want to Download a PDf normally a invoice .
                    if ($actionDetails['IsPdf'] == 1) {
                        $buttonAction = baseUrl . 'downloadPdf?dataSourceId=' . $actionDetails['DataSourceId'] . '&InvoiceNo=' . $invoiceNo;
                        $txt_ .= $actionDetails['ActionButtonText'].$separator;
                        $class_ .= str_replace("http://","",$buttonAction).$separator;
                    } 
                    else if($actionDetails['FormOnActionBTN'] == 1) {
                        $buttonAction = "LiveAPISyncReport('create' , '1698' , '2' , '0')";
                        $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                        $class_ .= str_replace("http://","",$buttonAction).$separator;
                    } 
                    // (End) if you want to Download a PDf normally a invoice .
                    else {
                        $txt_ .= $actionDetails['ActionButtonText'].$separator;
                        $class_ .= str_replace("http://","",$buttonAction).$separator;
                    }
                }
            }
        }
     
    }
    //(End) For all the table Action defined for that table rows .
    return array( $txt_ , $class_ );
}
 function getPageText($pageId, $userId)
{
    /*echo "SELECT UserPageAccess.PageMenuText FROM UserPageAccess WHERE PageId='" . $pageId . "' AND UserId='".$userId."'";
    die;*/
    try {
        $db = getDB('BP_Admin10');
        $stmt = $db->query("SELECT UserPageAccess.PageMenuText FROM UserPageAccess WHERE PageId='" . $pageId . "' AND UserId='".$userId."'");
        $data = $stmt->fetchAll();
    } catch (Exception $exc) {
    }

    return $data;
}
// Main Code 
    $sql = " select * from Users where EnablejsonSaveData = '1'" ;
     //$sql = " select u.* , c.* from Users u 
     //inner join Company c on c.CompanyID = u.CompanyID and c.EnablejsonSaveDataAllUser = '1'" ;

    $db = getDB('BP_Admin10');
    $stmt = $db->query( $sql);
    $Users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $userCount = [];
	foreach($Users as $UKey => $UValue){
		
		$userName = $UValue['UserEmail'];
		$password = $UValue['UserPassword'];
		
		$getUserDetails = $UValue ;
		$userCount = !empty( $getUserDetails['AvailableUserGroup'])?explode(',', $getUserDetails['AvailableUserGroup']):0;

		if($getUserDetails && !empty($getUserDetails['UserGroupActiveFlag']) && !empty($getUserDetails['AvailableUserGroup'])  && count($userCount) == 1 && empty($getUserDetails['DefaultLogin']) )
        {
          
            $_SESSION['ParentUserFirstName'] = $getUserDetails['UserFirstName'];
            $_SESSION['ParentCompanyID'] = $getUserDetails['CompanyID'];
            $_SESSION['ParentUserID'] = $getUserDetails['UserID'];
            $_SESSION['ParentAllowNoti'] = $getUserDetails['AllowNotification'];
            $_SESSION['ParentUserLastLogoutDate'] = $getUserDetails['UserLastLogoutDate'];
            $_SESSION['ParentUserLastLogoutTime'] = $getUserDetails['UserLastLogoutTime'];

            if(empty($getUserDetails['AllowParentDBParam'])){
               
                $_SESSION['ParentDBParam'] = $getUserDetails['DBParam'];
            }
           
            if(empty($getUserDetails['AllowParentAPIParam'])){
                        $_SESSION['ParentAPIParam'] = $getUserDetails['APIParam'];
                    }

            $getUserDetails = verifyGroupUser($userCount[0]);
           
            if(!empty($getUserDetails['AvailableUserGroup']) && !empty($getUserDetails['UserGroupFlag'] ))
                {
                    $getUserDetails = verifyGroupUser($getUserDetails['AvailableUserGroup']); 
                    $flag = 1;
                       
                        while($flag)
                        {   
                            if(!empty($getUserDetails['AvailableUserGroup']) && !empty($getUserDetails['UserGroupFlag'] ))
                            {

                                if(empty($getUserDetails['AllowParentDBParam']) && !isset($_SESSION['ParentDBParam'])){
                                
                                    $_SESSION['ParentDBParam'] = $getUserDetails['DBParam'];
                                }
                                if(empty($getUserDetails['AllowParentAPIParam']) && !isset($_SESSION['ParentAPIParam'])){

                                    $_SESSION['ParentAPIParam'] = $getUserDetails['APIParam'];
                                }
                                    $getUserDetails = verifyGroupUser($getUserDetails['AvailableUserGroup']); 
                                
                            }
                            else{
                                $flag = 0;
                            }
                        }
                      
                }

        }
		//print_r($getUserDetails[0]['UserID']); exit;
	    $getUserPages = getUserPages($getUserDetails[0]['UserID']);
		
        $userPageAccess = array();
		$EnableFixedHeader = array();
		$EnableFixedLeftColumn = array();
		foreach ($getUserPages as $userPage) {
			$userPageAccess[] = $userPage['PageTableID'];
			$EnableFixedHeader[$userPage['PageMenuText']] =  $userPage['EnableFixedHeader'];
			$EnableFixedLeftColumn[$userPage['PageMenuText']] =  $userPage['EnableFixedLeftColumn'];

		}
       
		$currentDateValue = substr(date('Ymd'), 2);
		$_SESSION['userPageAccess'] = $userPageAccess;
		$_SESSION['PageDetails'] = $getUserPages;
		$_SESSION['username'] = $getUserDetails[0]['UserEmail'];
		$_SESSION['password'] = $getUserDetails[0]['UserPassword'];
		$_SESSION['UserFirstName'] = $getUserDetails[0]['UserFirstName'];
		$_SESSION['UserLastName'] = $getUserDetails[0]['UserLastName'];
		$_SESSION['UserID'] = $getUserDetails[0]['UserID'];
		$_SESSION['IsAdmin'] = $getUserDetails[0]['IsAdmin'];
		$_SESSION['CompanyID'] = $getUserDetails[0]['CompanyID'];
		$_SESSION['DBParam'] = isset($_SESSION['ParentDBParam'])?$_SESSION['ParentDBParam']:$getUserDetails[0]['DBParam'];
		$_SESSION['APIParam'] = isset($_SESSION['ParentAPIParam'])?$_SESSION['ParentAPIParam']:$getUserDetails[0]['APIParam'];
		$_SESSION['NowTime'] = $currentDateValue;
		$_SESSION['AllowNotification'] = isset($_SESSION['ParentAllowNoti'])? $_SESSION['ParentAllowNoti']:$getUserDetails[0]['AllowNotification'];
		$_SESSION['EnableFixedHeader'] =  $EnableFixedHeader;
		$_SESSION['UserLastLogoutDate'] =  isset($_SESSION['ParentUserLastLogoutDate'])?$_SESSION['ParentUserLastLogoutDate']:$getUserDetails[0]['UserLastLogoutDate'];
		$getUserDetails[0]['UserLastLogoutTime'] =  isset($_SESSION['ParentUserLastLogoutTime'])?$_SESSION['ParentUserLastLogoutTime']:$getUserDetails[0]['UserLastLogoutTime'];
           
		if($getUserDetails[0]['UserLastLogoutTime']){
			$getUserDetails[0]['UserLastLogoutTime'] = explode(':' , $getUserDetails[0]['UserLastLogoutTime'] );

			array_pop($getUserDetails[0]['UserLastLogoutTime']);

			$getUserDetails[0]['UserLastLogoutTime'] = implode(':',$getUserDetails[0]['UserLastLogoutTime'] );
		}
		$_SESSION['UserLastLogoutTime'] =  $getUserDetails[0]['UserLastLogoutTime'];

		if(isset($_SESSION['parentSaveFilterBTN'])){
			$_SESSION['SaveFilterBTN'] =isset($_SESSION['parentSaveFilterBTN'])?$_SESSION['parentSaveFilterBTN']:0;
		}else{
			$_SESSION['SaveFilterBTN'] =!empty($getUserDetails[0]['SaveFilterBTN'])?$getUserDetails[0]['SaveFilterBTN']:0;
        }   
		$getCompanyDetails = getCompanyDetails($getUserDetails[0]['CompanyID']);
        
		if ($getCompanyDetails) {
			$_SESSION['CompanyName'] = $getCompanyDetails[0]['CompanyName'];

			if($getCompanyDetails[0]['AccountHolderName']){
				$_SESSION['AccountHolderName'] = $getCompanyDetails[0]['AccountHolderName'];
				$_SESSION['IBANNumber'] = $getCompanyDetails[0]['IBANNumber'];
				$_SESSION['BICNumber'] = $getCompanyDetails[0]['BICNumber'];
				$_SESSION['CreditorID'] = $getCompanyDetails[0]['CreditorID'];
			}
			$_SESSION['BPDB'] = $getCompanyDetails[0]['CompanyBPDb'];
			if(!empty($getCompanyDetails[0]['CompanyDBPass']))
			{
				$getCompanyDetails[0]['CompanyDBPass'] = json_decode( $getCompanyDetails[0]['CompanyDBPass'] , true);
				$getCompanyDetails[0]['CompanyDBUserName'] = json_decode( $getCompanyDetails[0]['CompanyDBUserName'] , true);

				foreach ($getCompanyDetails[0]['CompanyDBUserName'] as $key => $value) {


					$getCompanyDetails[0]['CompanyDBUserName'][$key][$getCompanyDetails[0]['CompanyDBPass'][$key][0]] = $value;
					unset( $getCompanyDetails[0]['CompanyDBUserName'][$key][0]);
				}
				$_SESSION['CompanyDBPass'] = $getCompanyDetails[0]['CompanyDBPass'];

				$_SESSION['CompanyDBUserName'] = $getCompanyDetails[0]['CompanyDBUserName'];
				$_SESSION['AdminDb'] = json_decode($getCompanyDetails[0]['AdminDb'] , true);
				$_SESSION['FTPCredential'] = $getCompanyDetails[0]['FTPCredential'];
				$_SESSION['AllowCompanyFolder'] = $getCompanyDetails[0]['AllowCompanyFolder'];
				$_SESSION['SFTPCredential'] = $getCompanyDetails[0]['SFTPCredential'];
				$_SESSION['SFTPKeys'] = $getCompanyDetails[0]['SFTPKeys'];

			}

			if(!empty($getCompanyDetails[0]['CompanyHostName'])){
				$getCompanyDetails[0]['CompanyHostName'] = json_decode( $getCompanyDetails[0]['CompanyHostName'] , true);
				$getCompanyDetails[0]['DBType'] = json_decode( $getCompanyDetails[0]['DBType'] , true);

				foreach ($getCompanyDetails[0]['CompanyHostName'] as $key => $value) {
					$getCompanyDetails[0]['CompanyHostName'][$key][$getCompanyDetails[0]['DBType'][$key][0]] = $value;
					unset( $getCompanyDetails[0]['CompanyHostName'][$key][0]);
				}

				$_SESSION['DBType'] = $getCompanyDetails[0]['DBType'];
				$_SESSION['CompanyHostName'] = $getCompanyDetails[0]['CompanyHostName'];
			}

			$_SESSION['LoggedIn'] = 1;
			//$allParameter = getAllParameter();
			$allParameter = '';
			$_SESSION['AllParameters'] = $allParameter;
			$_SESSION['CacheUser'] = $getCompanyDetails[0]['EnableRedisCompany']?$getCompanyDetails[0]['EnableRedisCompany']:$getUserDetails[0]['EnableCacheUser'];

			if($getCompanyDetails[0]['TableSelectionCompany']){
				$_SESSION['TableSelection'] = $getCompanyDetails[0]['TableSelectionCompany'];
			}else  if($getUserDetails[0]['TableSelection']){
				$_SESSION['TableSelection'] = $getUserDetails[0]['TableSelection'];
			}else
			{
				$_SESSION['TableSelection'] = 0;
			}
			$_SESSION['DisableAPIDataRedisUser'] =!empty($getCompanyDetails[0]['DisableAPIDataRedisCompany'])?$getCompanyDetails[0]['DisableAPIDataRedisCompany']:$getUserDetails[0]['DisableAPIDataRedisUser'];

			// print_r($_SESSION); exit;
		}  
	

        foreach($_SESSION['PageDetails'] as $Skey => $SVal){
        
            if($SVal['ShowAsMenu'] == '1' || $SVal['SecondaryChildPageMenuOrder'] != ''){
            //if( $SVal['PageMenuText']=='Total orders'){
                $pageId = $SVal['PageId'];
                $pageText = $SVal['PageMenuText'];
            
                $getPagePlaceholders = getPagePlaceholders($pageId, $_SESSION['UserID'], $pageText);
            
                foreach($getPagePlaceholders as $Pkey => $PVal){
                    //$userPageAccessPlaceholderId = $PVal['ID'];
                // $selectedPlaceholderId = $PVal['PlaceholderId'];
                    $getCompanyDetails = getCompaniesDetails($_SESSION['UserID']); // getting  user Company Info 
        
                    $placeholderId = $PVal['PlaceholderId'];
                    $pHolderId =  "";
                
                    $userPagePlaceholder = $PVal['ID'];
                    $searchValue =  "";
                    $silderActionId = "";

                    $getDatatableDetails = "";
                    $searchValueCount = '';
                    $getPlaceholderDetails1 = '';
                    $actationTableColumn  = array();
                    $fileName = '';
                    $fileData = '';
                    $RedisCheckData  = 1;

                    $getPlaceholderDetails1 = getDatasourceTableDetails($placeholderId);
            
                
                    if(isset($getPlaceholderDetails1[0]['AllowJsonSave']) && $getPlaceholderDetails1[0]['AllowJsonSave'] == 1 ){
                   
                        $FilterSession = 0;
                        $BasePath = '/var/www/vhosts/babcportal.app/httpdocs';
                		$server  = $BasePath."/BabcPortal_Other_Assests/BabcPortal/jsonData/";
                        $CompanyDir =  $server.trim($_SESSION['CompanyName']).'/';
                        $UserName=
							isset($_SESSION['ParentUserFirstName'])?$_SESSION['ParentUserFirstName']:$_SESSION['UserFirstName'];
                        $CompanyUserDir =  $server.trim($_SESSION['CompanyName']).'/'.$UserName.'/';
                    
                        $file = $placeholderId.'_'.$getPlaceholderDetails1[0]['Descriptions'];
                        $fileName = $CompanyUserDir.$file.'.txt';
                    
                    
                        //$_SESSION['Allowfetchdata']=0;
                        // if($getPlaceholderDetails1[0]['EnableChildRowsRunTym']){
                        //     $getChilRowDetails = Page::getChildRow($placeholderId);
                        // }
                    
                        //(Start) Condition if Join Table id Selected .
                        // if($getPlaceholderDetails1[0]['ColumnsMatching'])
                        // {
                        //     DataTableJoinTable::generateJoinTableAction();
                        //     exit;
                        // }
                        //(End) Condition if Join Table id Selected .
                        // Get table Action Detail
                        
                        $getTableActionDetails = getTableActionDetails($userPagePlaceholder);
                    
                        $tableActions = array();
                    
                        //(Start) processing for Action Button 
                        if ($getTableActionDetails || $silderActionId) {
                            
                            if($silderActionId){
                                $getTableActionIds = $silderActionId;
                            }else{
                                $getTableActionIds = (isset($getTableActionDetails[0]['PlaceholderActionIds'])) ? $getTableActionDetails[0]['PlaceholderActionIds'] : "";
                        
                            }
                            
                            if ($getTableActionIds) {
                                $tableActionDetails = getTableActionDetailsByIdIN($getTableActionIds);
                                if ($tableActionDetails) {
                                    foreach ($tableActionDetails as $getAllTableActions) {
                                        $actationTableColumn = array('RowNo');
                                        $columnRowNo = '';
                                        if(isset($getAllTableActions['Columns'])) {
                                            $columnRowNo = explode(",", $getAllTableActions['Columns']);
                                            foreach($columnRowNo as $value) {
                                                $value = trim($value);
                                                if($value == 'RowNo'){
                                                    $columnRowNo = $value;
                                                }
                                            }
                                        }
                                        $tableActions[$getAllTableActions['TableParameterColumn']][] = $getAllTableActions;
                                        if(isset($columnRowNo) && $columnRowNo == 'RowNo') {
                                            $tableActions[$columnRowNo][] = $getAllTableActions;
                                            $tableActions[$columnRowNo][0]['TableParameterColumn'] = $columnRowNo;
                                        }
                                    }
                                }
                            }
                        }
                        //(End) processing for Action Button 
						
                        $getPlaceholderDetailsColumnProperties  = array();
                        //(Start)if we have fetched data for placeholder
                        if(count($getPlaceholderDetails1) >= 1)
                        {
                        
                            $flagholder = 0 ;
                            foreach ($getPlaceholderDetails1 as $ke => $valueee) {
                                // Variable Declaration
                                $requestUrl = '';
                                $requestType = '';
                                $requestBody = '';
                                $requestGAPI = '';
                                $accessTokenGAPI = '';
                                $accessRefreshTokenGAPI = '';
                                $displayDetailButton = false;
                                $customSumData = '';
                                $customSumDataArr = array();
                                $explodeColumns = '';
                                $columnsList = array();
                                $getPlaceholderDetails[0] = $valueee;    
                                //(Start) if their is any detail of placeholder 
                                if ($getPlaceholderDetails) {
                                    // get Source type from Source type File . 
                                    $sourceType = 'address';
                                    if($sourceType == 'body')
                                    {
                                        $getSourceType = $getPlaceholderDetails[0]['Body'];
                                        
                                        $getSourceType = str_replace("(OGAFilter)", '""', $getSourceType);
                                        
                                    }else{
                                        $getSourceType = $getPlaceholderDetails[0]['SourceAddress'];
                                    }
                                    // Replacing the DBParam Paramter with the value set by the comapny .
                                    if(isset($_SESSION['DBParam'])) {
                                        $arr = explode('|', $_SESSION['DBParam'] );
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
                                                $getSourceType = str_replace("'(".$val[0].")'", $dataVal, $getSourceType);
                                                $getSourceType = str_replace("(".$val[0].")", $dataVal, $getSourceType);
                                                
                                            }
                                        }
                                    }
                                    // Replacing the APIParam Paramter with the value set by the comapny .
                                    if(isset($_SESSION['APIParam'])) {
                                        $arr = explode('|', $_SESSION['APIParam'] );
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
                                                $getSourceType = str_replace("'(".$val[0].")'", $dataVal, $getSourceType);
                                                $getSourceType = str_replace("(".$val[0].")", $dataVal, $getSourceType);
                                                
                                            }
                                        }
                                        
                                    }
                                    //Variable Declaration and intialization 
                                    $sumColumnLable = $getPlaceholderDetails[0]['SumColumnLable'];
                                    $keyColumnName = $getPlaceholderDetails[0]['KeyColumn'];
                                    $customSumFormula = $getPlaceholderDetails[0]['CustomSumFormula'];
                                    $companyAddress = $getCompanyDetails[0]['CompanyGISKey'];
                                    $companyToken = $getCompanyDetails[0]['CompanyGISToken'];
                                    $requestType = $getPlaceholderDetails[0]['RequestType'];
                                    $requestBody = $getPlaceholderDetails[0]['Body'];
                                    $requestGAPI = $getPlaceholderDetails[0]['SourceAddress'];
                                    $accessTokenGAPI =  $getCompanyDetails[0]['GoogleAccessToken'];
                                    $accessRefreshTokenGAPI =  $getCompanyDetails[0]['GoogleAccessRefreshToken'];
                                    $sumType = $getPlaceholderDetails[0]['SumType'];
                                    // getting Column Name .  will get the Columns in case of multiple Node .
                                    if($getPlaceholderDetails[0]['ApiType'] == '2')
                                    {
                                        $getColumnsList = $getPlaceholderDetails[0]['Columns'];
                                    }else{
                                        $getColumnsList = $getPlaceholderDetails[0]['tableColumns'];
                                        
                                    } 
                                
                                    // (Start) if we got the Column Name 
                                    $newExplodeColumns = array();
                                    if (isset($getColumnsList)) {
                                        $explodeColumns = explode(',', $getColumnsList);
                                    
                                        $explodeColumns = array_combine($explodeColumns,$explodeColumns);
                                        $columnsList = explode(',', $getColumnsList);
                                        $getColumnsProperties = $getPlaceholderDetails[0]['ColumnsProperties'];

                                        if (isset($getColumnsProperties)) {
                                            $getColumnsProperties = json_decode($getColumnsProperties, true);

                                            if(!empty($getPlaceholderDetailsColumnProperties)){

                                                $getPlaceholderDetailsColumnProperties = array_merge($getPlaceholderDetailsColumnProperties, $getColumnsProperties);
                                            
                                            }else{
                                                $getPlaceholderDetailsColumnProperties = $getColumnsProperties;
                                            }
                                            $getColumnsProperties = array_replace(array_flip($explodeColumns), $getColumnsProperties);
                                            unset($explodeColumns);
                                            foreach($getColumnsProperties as $key => $value) {
                                                if(in_array($key, $columnsList)) {
                                                    $explodeColumns[$key] = $value;
                                                }
                                            }
                                        }
                                    }
                                    // (End) if we got the Column Name 
                                    // replace now time with actual time in body and url.
                                    if (strpos($requestBody, strtolower('(nowtime)')) !== false) {
                                        if(isset($_SESSION['NowTime'])){
                                            $requestBody = str_replace("(nowtime)", $_SESSION['NowTime'], $requestBody);
                                        }
                                    }
                                    if (strpos($requestUrl, strtolower('(nowtime)')) !== false) {
                                        if(isset($_SESSION['NowTime'])){
                                            $requestUrl = str_replace("(nowtime)", $_SESSION['NowTime'], $requestUrl);
                                        }
                                    }
                                    //Getting Placeholder Name 
                                    $getPlaceholderColumn = trim($getPlaceholderDetails[0]['Placeholder']);
                                    if ($getPlaceholderColumn) {
                                        $getRequestData = (isset($_REQUEST[$getPlaceholderColumn])) ? $_REQUEST[$getPlaceholderColumn] : "";

                                        if ($getRequestData) {
                                            $requestBody = str_replace("(" . $getPlaceholderColumn . ")", $getRequestData, $requestBody);
                                        }
                                    }
                                    //Getting the Request Url 
                                    $requestUrl = str_replace("(address)", $companyAddress, $getSourceType);
                                    $requestUrl = str_replace("(token)", $companyToken, $requestUrl);
                                    $filterion = false;
                                    
                                    if ($getDatatableDetails && $getPlaceholderDetails) {
                                        if ($getDatatableDetails[0]['DataSourceId'] == $getPlaceholderDetails[0]['DataSourceId']) {
                                            if (!empty($searchValue)) {
                                                $keyValue = key($searchValue);
                                                if(in_array($keyValue, $columnsList)) {
                                                    $filterion = true;
                                                }
                                            }
                                        }
                                    }
                                }
                                //(End) if their is any detail of placeholder
                                //(Start) Fetching Data  from Data Source Call DB 
                                
                                
                                if ($requestType == 3) {
                                    // variable Declaration .
                                    $tableData = array();
                                    $sumType = $getPlaceholderDetails[0]['SumType'];
                                    
                                    if ($tableActions) {
                                        
                                        $pageTextValue = array();
                                        foreach ($tableActions as $key => $eachAction) {
                                            if(isset($key) && !in_array($key,$actationTableColumn)) {
                                                foreach ($eachAction as  $k => $actionDetails) {
                                                    $externalUrl = $actionDetails['ExternalUrl'];
                                                    if (!empty($externalUrl)) {
                                                        $buttonAction = $externalUrl;
                                                    } 
                                                    else {
                                                        if($_SESSION['UserID'] && $actionDetails['PageTargetId']) {
                                                            $pageText = getPageText($actionDetails['PageTargetId'], $_SESSION['UserID']);

                                                            if($pageText) {
                                                                $pageTextValue[$key][$k] = $pageText[0]['PageMenuText'];
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    // Fetch data from DataSource Call to DB 
                                    if(strpos($getSourceType, 'UserHistory')) 
                                    {
                                        $userCompanyDbName = 'BP_Admin10';
                                    }
                                    //(End) It will come in this condition when we want to get data for user login history 
                                    else{
                                        // (Start) this condition is to check if that table data should be fetched from  CompanyBPDb or CompanyBPDb .
                                        if(!empty($getPlaceholderDetails[0]['DBName']) || $getPlaceholderDetails[0]['AllowCustomTable'] == 1)
                                        {
                                        
                                            $userCompanyDbName = $getCompanyDetails[0]['CompanyBPDb'];
                                        
                                        } else
                                        {
                                            $userCompanyDbName = $getCompanyDetails[0]['CompanyBABCDb'];
                                        }
                                        // (End) this condition is to check if that table data should be fetched from  CompanyBPDb or CompanyBPDb .
                                    }
                                    // (Start)get CustomTable its specially if we want to get data from CompanyBPDb or we want to create a new table in DB .
                                    if(!empty($getPlaceholderDetails[0]['customTable']))
                                    {
                                        $Table =$getPlaceholderDetails[0]['customTable'];
                                    } else
                                    {
                                        $Table = "";
                                    }
                                    // (End)get CustomTable its specially if we want to get data from CompanyBPDb or we want to create a new table in DB .
                                    // (Start) need to set the DB type so that we can build and excute that type of queries .       
                                    if(!empty($getPlaceholderDetails[0]['DBType']) && empty($getPlaceholderDetails[0]['DBName']))
                                    {
                                        $_SESSION['dataSourceDbType'] = $getPlaceholderDetails[0]['DBType'];
                                    } else
                                    {
                                        unset($_SESSION['dataSourceDbType'])  ;
                                    }
                                    // (End) need to set the DB type so that we can build and excute that type of queries . 
                                    // Query Call 
                                    $FilterSession = !empty($getPlaceholderDetails1[0]['FilterSessionEnable'])?trim($getPlaceholderDetails1[0]['FilterSessionEnable']):0;
                                    $OldGetSourceType = $getSourceType;
                                    if(isset($_SESSION['TableValue']) || (isset($_SESSION['TableValue']['LSearch']) || $FilterSession == '1')){
                                        if(isset($_SESSION['TableValue']['LSearch'])){
                                            unset($_SESSION['TableValue']['LSearch']);
                                        }
                                    
                                        foreach($_SESSION['TableValue'] as $tabKey => $tabValue){
                                            //if(!empty($tabValue)){
                                                if(strpos($getSourceType,"(".$tabKey.")") !== false){
                                                    if( strpos($tabValue,',') !== false){
                                                        $tabValue = explode(',' , $tabValue);
                                                        $tabValue = implode("','" , $tabValue);
                                                        $tabValue = $tabValue;
                                                    }
                                                    $getSourceType = str_replace( "(".$tabKey.")", "'".trim( $tabValue)."'" , $getSourceType );
                                                
                                                }else{
                                                    if( strpos($tabValue,',') !== false){
                                                        $tabValue = explode(',' , $tabValue);
                                                        $tabValue = implode("','" , $tabValue);
                                                        $tabValue = "'".$tabValue. "'";
                                                    }
                                                    $getSourceType = str_replace( "'".$tabKey."'", "'".trim( $tabValue)."'" , $getSourceType );
                                                }
                                            
                                        // }
                                        }
                                        if($FilterSession != '1'){
                                            unset($_SESSION['Allowfetchdata']);
                                            unset($_SESSION['TableValue']);
                                        }
                                        
                                    }
                                    $dCheck = 1;
                                    if($getPlaceholderDetails[0]['AllowDynamicForm'] && !isset($_SESSION['TableValue']) ){
                                        
                                        if($OldGetSourceType == $getSourceType){
                                            $dCheck = 0;
                                        }
                                    
                                    }
                                    
                                    if($dCheck == 0){
                                        $allData = array();
                                    }else {
                                        $allData = executeQuery($getSourceType, $userCompanyDbName , $Table );

                                    }
                                
                                    //$allData = DBDataSourceCallData::getDBDataSourceCallData($getPlaceholderDetails , $getCompanyDetails, $getSourceType ); // Get the data from DB 
                                    //custom Sum Calculation for sum Type 1 
                                    if ($sumType == 1) {
                                        $columnSumResults = 0;
                                        $columnSumData = array();
                                        $singleColumn = $customSumFormula;
                                        foreach ($allData as $eachRecord) {
                                            $outputData = (isset($eachRecord[$singleColumn])) ? $eachRecord[$singleColumn] : "";
                                            if ($outputData > 0) {
                                                try {
                                                    $outputData = (int)$outputData;
                                                    $outputData = round($outputData);
                                                    $columnSumData[] = $outputData;
                                                } catch (Exception $exc) {
                                                }

                                            }
                                        }
                                        if ($columnSumData) {
                                            $columnSumResults = array_sum($columnSumData);
                                        }
                                    }
                                
                                    // (Start) For loop for data fetched .
                                
                                    foreach ($allData as  $eachRecord) {
                                        // Variable Declaration 
                                        $matchedData = false;
                                        $matchedValueCount = 0;
                                        $imgKeyCheck = 0;
                                        $imgKeyCheck1 = 0;
                                        $imgLinkKeyCheck = 0;
                                        $imgLinkKeyCheck1 = 0;
                                        $imgLinkAKeyCheck = 0;
                                        $imgLinkAKeyCheck1 = 0;
                                        $txt_ =  "";
                                        $class_ = "";
                                        $separator= "%";
                                        $keyColumnValue = '';
                                        $detailKeyColumnValue = '';
                                        $columnData = '';
                                        $customerAction = '';
                                        $customSumFormula = (isset($getPlaceholderDetails[0]['CustomSumFormula'])) ? $getPlaceholderDetails[0]['CustomSumFormula'] : "";
                                        //(Start) if column name list is not empty 
                                        if (isset($getColumnsList)) {
                                            $dataToTable = [];
                                            //(Start)  for loop for column Names 
                                            foreach ($explodeColumns as $singleColumn => $singleColumnValue) {
                                                
                                                // Processing for Images Column .
                                                if(array_key_exists('Images', $eachRecord)) // check if the Image Column is Present 
                                                {
                                                    $imgKeyCheck =  $imgKeyCheck + 1 ;
                                                }  
                                                if($singleColumn == 'Images') // check if the Image Column is Present 
                                                {
                                                    $imgKeyCheck1 =  $imgKeyCheck ;
                                                }

                                                // Processing for Images Column .
                                                if(array_key_exists('image_link', $eachRecord) ) // check if the Image Column is Present 
                                                {
                                                    $imgLinkKeyCheck =  $imgLinkKeyCheck + 1 ;
                                                }  
                                                if($singleColumn == 'image_link'  ) // check if the Image Column is Present 
                                                {
                                                    $imgLinkKeyCheck1 =  $imgLinkKeyCheck ;
                                                }
                                                
                                                if( array_key_exists('additional_image_link', $eachRecord)) // check if the Image Column is Present 
                                                {
                                                    $imgLinkAKeyCheck =  $imgLinkAKeyCheck + 1 ;
                                                }  
                                                if( $singleColumn == 'additional_image_link' ) // check if the Image Column is Present 
                                                {
                                                    $imgLinkAKeyCheck1 =  $imgLinkAKeyCheck ;
                                                }
                                                //(Start) Processing on Column name for Join Table 
                                                if($getPlaceholderDetails[0]['TableType'] == 3) // for Join Table
                                                {
                                                    $columnDataFlag  = 0 ;
                                                    $singleColumnVal = $singleColumn;
                                                    if(strpos($singleColumn, $getPlaceholderDetails[0]['Name']) !== false){
                                                        $singleColumn = explode('-', $singleColumn);
                                                        if(count($singleColumn) > 2){
                                                            array_shift($singleColumn);
                                                            $singleColumn = implode('-' , $singleColumn );
                                                        }
                                                        else if($singleColumn[1] != '')
                                                        {
                                                            $columnDataFlag  = 1;
                                                            $singleColumn = end($singleColumn);
                                                        }
                                                    
                                                    if (isset($getPlaceholderDetails[0]['ColumnsProperties']) && $columnDataFlag == 1 ) {
                                                        $getColumnsProperties = json_decode($getPlaceholderDetails[0]['ColumnsProperties'], true);
                                                        $singleColumnValue = isset($getColumnsProperties[$singleColumn])?$getColumnsProperties[$singleColumn]:$singleColumn;
                                                    }
                                                    }
                                                }
                                                //(End) Processing on Column name for Join Table 
                                                $columnData = '';
                                                if ($keyColumnName == $singleColumn) { // get row 
                                                    $keyColumnValue = $eachRecord[$singleColumn];
                                                }
                                                $singleColumn = trim($singleColumn);
                                                if(isset($eachRecord[$singleColumn]))
                                                {
                                                    $columnData = $eachRecord[$singleColumn];
                                                }
                                                //(Start) Processing for Custom Sum Formula and performing data formatting 
                                                if($getPlaceholderDetails[0]['TableType'] != 3 )
                                                {
                                                    if (isset($customSumFormula) && !empty($customSumFormula) && array_key_exists($singleColumn, $eachRecord)) // In case of CustomFormula replace the data 
                                                    {
                                                        $replaceColumn = "(" . $singleColumn . ")";
                                                        $sumColumnData = str_replace(array(',', ' '), '', $columnData);
                                                        $customSumData = str_replace($replaceColumn, $sumColumnData, $customSumFormula);
                                                        $customSumFormula = $customSumData;
                                                    }
                                                
                                                    $columnData = ColumnProperties($columnData,$singleColumnValue); // Data Formating 
                                                    $columnData = columnDataRound($columnData,$singleColumnValue); // Data Formating 
                                                    if($columnData == INF)
                                                    {
                                                        $columnData = $eachRecord[$singleColumn];
                                                    }
                                        
                                                }  
                                                //(End) Processing for Custom Sum Formula and performing data formatting 
                                                if (!empty($searchValue) && isset($searchValue[$singleColumn])) {
                                                    $columnDataValue = strtolower($columnData);
                                                    if(isset($searchValue[$singleColumn])) {
                                                        $searchValueComumn = explode('|',$searchValue[$singleColumn]);
                                                        $searchValueComumnCount = count($searchValueComumn);
                                                        if($searchValueComumnCount > 1) {
                                                            for($i = 0; $i < $searchValueComumnCount; $i++ ) {
                                                                if (strpos($columnDataValue, strtolower($searchValueComumn[$i])) !== false) {
                                                                    $matchedValueCount++;
                                                                }
                                                            }
                                                        } else {
                                                            if (strpos($columnDataValue, strtolower($searchValueComumn[0])) !== false) {
                                                                $matchedValueCount++;
                                                            }
                                                        }
                                                    }
                                                    if($getPlaceholderDetails[0]['TableType'] == 3)
                                                    {
                                                        $dataToTable[$singleColumnVal] = $columnData;
                                                    }
                                                    else{
                                                        $dataToTable[] = $columnData;
                                                    }
                                                } else {
                                                    if($getPlaceholderDetails[0]['TableType'] == 3)
                                                    {
                                                        $dataToTable[$singleColumnVal] = $columnData;
                                                    }
                                                    else{
                                                        $dataToTable[] = $columnData;
                                                    }
                                                }
                                                // Setting the paramter for Table Action 
                                                if (array_key_exists($singleColumn, $tableActions)) {
                                                    foreach ($tableActions[$singleColumn] as $key => $value) {
                                                        $tableActions[$singleColumn][$key]['TableParameterColumnValue'] = $columnData;
                                                    }
                                                }

                                            }
                                            //(End)  for loop for column Names 
                                            // (Start) for  Action button       
                                            if($tableActions){
                                                //(Start) For all the table Action defined for that table rows .
                                                foreach ($tableActions as $key => $eachAction) {
                                                    if(isset($key) && !in_array($key,$actationTableColumn)) {
                                                        foreach ($eachAction as $k => $actionDetails) {
                                                            // VAriable declaration and initialization 
                                                            $externalUrl = $actionDetails['ExternalUrl'];
                                                            $tableParameterColumnValue = (isset($actionDetails['TableParameterColumnValue'])) ? $actionDetails['TableParameterColumnValue'] : "";
                                                        
                                                            $textValue = (isset($pageTextValue[$key][$k])?$pageTextValue[$key][$k]:'');
                                                            if (!empty($externalUrl)) {
                                                                $buttonAction = $externalUrl;
                                                            } //(end)In Case if External Url is defined 
                                                            else {
                                                            //(Start) if external Url not defined 
                                                                $buttonAction = baseUrl . 'page?id=' . $actionDetails['PageTargetId'] . '&page_text='. $textValue .'&columnName=' . $actionDetails['TableParameterColumn'] . '&columnValue='.$tableParameterColumnValue;
                                                            
                                                            }
                                                            $parameterArray = array('orderNoCol'=>$actionDetails['TableParameterColumn'],'orderNoValue'=> $tableParameterColumnValue,'baseUrl' => baseUrl, 'pageTextValue' => rawurlencode ($textValue), 'dataSourceId' => $actionDetails['DataSourceId'],'pageTargetId' => $actionDetails['PageTargetId']);
                                                            $parameterArray = json_encode($parameterArray, JSON_UNESCAPED_SLASHES);
                                                            
                                                            //(Start) if the action selected is Update DataSource . it can be update through form or predefined update .
                                                            if ($actionDetails['updateDataSource'] == 1) {
                                                            // (Start) For predefined Update 
                                                                if ($actionDetails['PredefinedUpdate'] == 1) {
                                                                    $buttonAction = 'getUpdatePredefined('. $parameterArray .')';
                                                                    $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                                                                    $class_ .= str_replace("http://","",$buttonAction).$separator;
                                                                } 
                                                                else {
                                                                    $buttonAction = baseUrl . 'getUpdateForm?dataSourceId=' . $actionDetails['DataSourceId'] .   '&pageId=' . $actionDetails['PageTargetId']  . '&columnName=' . $actionDetails['TableParameterColumn'] . '&columnValue=' . $tableParameterColumnValue .'&tableID=' . $actionDetails['TableTemplateId']. '&page_text='. rawurlencode ($textValue) ;
                                                                
                                                                    $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                                                                    $class_ .= str_replace("http://","",$buttonAction).$separator;
                                                                }
                                                                // (End))For Update row from Form 
                                                            }
                                                            // (Start)For Update a DataSoucre Call 
                                                            else if ($actionDetails['DataSourceCall'] == 1) {
                                                                    $buttonAction = 'getUpdateDataSourceCall('. $parameterArray .')';
                                                                    $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                                                                    $class_ .= str_replace("http://","",$buttonAction).$separator;
                                                            } 
                                                            // (End)For Update a DataSoucre Call 
                                                            //(Start) if the action selected is Update DataSource . it can be update through form or predefined update .
                                                            else {
                                                                // (Start) if you want to Download a PDf normally a invoice .
                                                                if ($actionDetails['IsPdf'] == 1) {
                                                                    $buttonAction = baseUrl . 'downloadPdf?dataSourceId=' . $actionDetails['DataSourceId'] . '&InvoiceNo=' . $tableParameterColumnValue;
                                                                    $txt_ .= $actionDetails['ActionButtonText'].$separator;
                                                                    $class_ .= str_replace("http://","",$buttonAction).$separator;
                                                                } // (End) if you want to Download a PDf normally a invoice .
                                                                else if($actionDetails['FormOnActionBTN'] == 1) {
                                                                
                                                                    $buttonAction = 'LiveAPISyncReport("create" , "'.$placeholderId.'" , "2" ,  "0","'.$buttonAction.'" ,"1" , "'.$actionDetails['TableParameterColumn'].'" , "'.$tableParameterColumnValue.'")';
                                                                    $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                                                                    $class_ .= str_replace("http://","",$buttonAction).$separator;
                                                                } 
                                                                else {
                                                                    $txt_ .= $actionDetails['ActionButtonText'].$separator;
                                                                    $class_ .= str_replace("http://","",$buttonAction).$separator;
                                                                }
                                                            }
                                                        }
                                                    } 
                                                }
                                                //(End) For all the table Action defined for that table rows .
                                            }
                                            //(End) For ACTION BUTTON .
                                            $sumColumnLable = trim($sumColumnLable);
                                            
                                            if(isset($sumColumnLable) && !empty($sumColumnLable) &&  $sumColumnLable == 'City')
                                            {
                                                $dataToTable[] = 'ST';
                                            }
                                            //(Start) Else 
                                            else{
                                                //(Start) FOr Custom SUm Calculation 
                                                if (isset($sumColumnLable) && !empty($sumColumnLable)) { // Custom Formula Calcultion 
                                                    if (isset($explodeColumns)) {
                                                        if (!in_array($sumColumnLable, $explodeColumns)) {
                                                            // Will call the SUmm Calculation file after some more Testing .
                                                            if (!empty($customSumData)) {
                                                                if ($sumType == 1) {

                                                                    if ($columnSumResults && is_numeric($columnSumResults)) {
                                                                        $columnSumResults = round($columnSumResults);
                                                                    }

                                                                    if (!empty($searchValue) && !empty($searchValueArray)) {
                                                                        $columnSumResultsValue = strtolower($columnSumResults);

                                                                        if (!empty($columnSumResultsValue)) {
                                                                            foreach ($searchValueArray as $searchValue) {
                                                                                if(isset($searchValue) && !empty($searchValue)) {
                                                                                    if (strpos($columnSumResultsValue, $searchValue) !== false) {
                                                                                        $matchedData = true;
                                                                                        $matchedValueCount++;
                                                                                    }
                                                                                }
                                                                            }
                                                                        }

                                                                        if(!empty($getColumnsProperties[$sumColumnLable])){
                                                                            $columnSumResults = ColumnProperties($columnSumResults,$getColumnsProperties[$sumColumnLable]);
                                                                        }
                                                                        $dataToTable[] = $columnSumResults;

                                                                    } else {
                                                                        if(!empty($getColumnsProperties[$sumColumnLable])){
                                                                            $columnSumResults = ColumnProperties($columnSumResults,$getColumnsProperties[$sumColumnLable]);
                                                                        }
                                                                        $dataToTable[] = $columnSumResults;
                                                                    }

                                                                } 
                                                                else if ($sumType == 2) {
                                                                    $csData = explode(',' , $customSumData);
                                                                    $sumLabel = explode(',' , $sumColumnLable); 
                                                                
                                                                    foreach ($csData as $key => $value) {
                                                                        if (strpos($value, '--') === false) {
                                                                            
                                                                            try{
                                                                                @eval('$result = (' . @$value . ');');
                                                                            }
                                                                            catch(Exception $e){
                                                                                $result = 0;
                                                                            }
                                                                            if (is_nan($result)) {
                                                                                $result = 0;
                                                                            } else if(is_infinite($result)) {
                                                                                $result = 100;
                                                                            }
                                                                            if (!empty($searchValue) && !empty($searchValueArray)) {
                                                                                $resultValue = strtolower($result);

                                                                                if (!empty($resultValue)) {
                                                                                    foreach ($searchValueArray as $searchValue) {
                                                                                        if(isset($searchValue) && !empty($searchValue)) {
                                                                                            if (strpos($resultValue, $searchValue) !== false) {
                                                                                                $matchedData = true;
                                                                                                $matchedValueCount++;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }

                                                                                if(!empty($getColumnsProperties[$sumLabel[$key]])){
                                                                                    $result = ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                                                                                }
                                                                                $dataToTable[] = $result;

                                                                            } else {
                                                                                $sumLabelkey = trim($sumLabel[$key]);
                                                                                if(!empty($getColumnsProperties[$sumLabelkey])){
                                                                                    $result = ColumnProperties($result,$getColumnsProperties[$sumLabelkey]);
                                                                                }
                                                                                
                                                                                $dataToTable[] = round($result);
                                                                            }
                                                                        }
                                                                        else{

                                                                        $value = str_replace('--', '+', $value);
                                                                        try{
                                                                                @eval('$result = (' . @$value . ');');
                                                                                //eval("\$result = $customSumData;");
                                                                            }
                                                                            catch(Exception $e){
                                                                            $result = 0;
                                                                            }
                                                                            if (is_nan($result)) {
                                                                                $result = 0;
                                                                            } else if(is_infinite($result)) {
                                                                                $result = 100;
                                                                            }
                                                                            if (!empty($searchValue) && !empty($searchValueArray)) {
                                                                                $resultValue = strtolower($result);

                                                                                if (!empty($resultValue)) {
                                                                                    foreach ($searchValueArray as $searchValue) {
                                                                                        if(isset($searchValue) && !empty($searchValue)) {
                                                                                            if (strpos($resultValue, $searchValue) !== false) {
                                                                                                $matchedData = true;
                                                                                                $matchedValueCount++;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }

                                                                                if(!empty($getColumnsProperties[$sumLabel[$key]])){
                                                                                    $result = ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                                                                                }

                                                                                $dataToTable[] = $result;

                                                                            } else {
                                                                                if(!empty($getColumnsProperties[$sumLabel[$key]])){
                                                                                    $result = ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                                                                                }

                                                                                $dataToTable[$singleColumn] = round($result);
                                                                            }

                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }

                                                }
                                                
                                                //(End) FOr Custom SUm Calculation 
                                            } // (End) Else
                                            // (Start) Separate image as its Comma seapated value in DB . 
                                            if($imgKeyCheck1) 
                                            {
                                                // Processing that will separate the URL for iMage and will show 6 images . can change the Number from her .
                                                if($dataToTable[$imgKeyCheck1-1])
                                                {
                                                    $img = explode(',', $dataToTable[$imgKeyCheck1-1]);
                                                    $dataToTable[$imgKeyCheck1-1] = $img[0];
                                                    for ($i=1; $i <= 10 ; $i++) { 
                                                        if(isset($img[$i])){
                                                            $dataToTable[] = $img[$i];
                                                        }else{
                                                            $dataToTable[] = '';
                                                        }
                                                    }
                                                }
                                                else{
                                                    for ($i=1; $i <= 10 ; $i++) { 
                                                        $dataToTable[] = '';
                                                    }
                                                }
                                            
                                            }
                                            if($imgLinkKeyCheck1) 
                                            {
                                                // Processing that will separate the URL for iMage and will show 1 images . can change the Number from her .
                                                if($dataToTable[$imgLinkKeyCheck1-1])
                                                {
                                                    $img = explode(',', $dataToTable[$imgLinkKeyCheck1-1]);
                                                
                                                    $dataToTable[$imgLinkKeyCheck1-1] = $img[0];
                                                
                                                
                                                }
                                                else{
                                                
                                                        $dataToTable[] = '';
                                                }
                                            
                                            }
                                            if($imgLinkAKeyCheck1) 
                                            {
                                                // Processing that will separate the URL for iMage and will show 1 images . can change the Number from her .
                                                if($dataToTable[$imgLinkAKeyCheck1-1])
                                                {
                                                    $img = explode(',', $dataToTable[$imgLinkAKeyCheck1-1]);
                                                
                                                    unset($img[0]);
                                                    $dataToTable[$imgLinkAKeyCheck1-1] = implode(',' , $img);
                                                
                                                }
                                                else{
                                                
                                                        $dataToTable[] = '';
                                                }
                                            
                                            }
                                            // (End) Separate image as its Comma seapated value in DB . 
                                            if($tableActions){
                                                $dataToTable[] = $txt_ ;
                                                $dataToTable[] = $class_ ;
                                            }
                                            if($getPlaceholderDetails[0]['AddZeroForNegVal']){
                                                $ColAddZeroForNegVal = isset($getPlaceholderDetails[0]['ColAddZeroForNegVal'])?explode(',',$getPlaceholderDetails[0]['ColAddZeroForNegVal']):[];
                                                $COLName = $getPlaceholderDetails[0]['tableColumns'].','.$getPlaceholderDetails[0]['SumColumnLable'];
                                                $COLName = trim($COLName,',');
                                                $COLName = explode(',' , $COLName);
                                                $COLNameDisplay = isset($getPlaceholderDetails[0]['DisplayColumnNames'])?($getPlaceholderDetails[0]['DisplayColumnNames'].','.$getPlaceholderDetails[0]['SumColumnLable']):'';
                                                
                                                foreach($ColAddZeroForNegVal as $NKey => $NVal){
                                                    foreach($COLName as $COLNameKey => $COLNameVal){
                                                        if(!is_array($COLNameDisplay)){
                                                            
                                                            $COLNameDisplay = trim($COLNameDisplay,',');
                                                            $COLNameDisplay = explode(',' , $COLNameDisplay );
                                                            if(trim($COLName[$COLNameKey]) == trim($NVal) || trim($COLNameDisplay[$COLNameKey]) == trim($NVal) ){
                                                                
                                                                    if(strpos($dataToTable[$COLNameKey] , '-') !== false){
                                                                        $dataToTable[$COLNameKey]  =  0;
                                                                        
                                                                    }
                                                                
                                                                
                                                            }
                                                        }else{
                                                                
                                                            if(($COLName[$COLNameKey]) == trim($NVal)){
                                                                if(strpos($dataToTable[$COLNameKey] , '-') !== false){
                                                                    $dataToTable[$COLNameKey]  = 0;
                                                                    
                                                                }
                                                                
                                                                
                                                            }
                                                        }

                                                    }
                                                }
                                            }
                                            if ($filterion) {
                                                if($searchValueCount == $matchedValueCount) 
                                                {
                                                    $tableData['data'][] = $dataToTable;
                                                }
                                            } else {
                                                $tableData['data'][] = $dataToTable;
                                            }
                                        }

                                        //(End) if column name list is not empty 
                                    }   
                                    if(empty($tableData))
                                    {
                                        $tableData['data'] = [];
                                    }
									 //print_r($tableData['data']); exit;
                                    
                                } 
                                //(ENd) Fetching Data  from Data Source Call DB 
                                //(Start) Fetching Data  from Data Source Call Api  
                                else {
                                
                                    if(isset($getPlaceholderDetails) && $getPlaceholderDetails[0]['ApiType'] == '2')
                                    {
                                        
                                        $tableData = APIDataSourceCallMultipleNode::getAPIDataSourceCallMultipleNode($getPlaceholderDetails , $getCompanyDetails , $getSourceType, $requestUrl , $customSumFormula , $explodeColumns , $getColumnsList , $sumColumnLable , $sumType , $keyColumnName , $tableActions , $filterion ,  $actationTableColumn , $getColumnsProperties , $placeholderId , $userPagePlaceholder); 
                                    }else{
                                        $tableData['data'] = array();
                                        $invoiceNo = '';
                                        $_arrayList = array('ResultList');
                                        $columnValue = (isset($_REQUEST['columnValue'])) ? $_REQUEST['columnValue'] : "";
                                        //(Start) if a call is made then 
                                        if ($requestUrl) {
                                            
                                            $header  = '' ;
                                            $companyAddress = $getCompanyDetails[0]['CompanyGISKey'];
                                            $companyToken = $getCompanyDetails[0]['CompanyGISToken'];
                                            $sumType = $getPlaceholderDetails[0]['SumType'];
                                            $requestType = $getPlaceholderDetails[0]['RequestType'];
                                            $requestUrl = str_replace("(address)", $companyAddress, $getSourceType);
                                            $gcsCustomer = str_replace("(token)", $companyToken, $requestUrl);
                                            $gcsCustomer = isset($_REQUEST['id'])?str_replace("(id)", $_REQUEST['id'], $gcsCustomer):$gcsCustomer;
                                            $gcsCustomer = isset($_REQUEST['email'])?str_replace("(email)", $_REQUEST['email'], $gcsCustomer):$gcsCustomer;
                                            
                                            $sourceType = 'body';
                                            
                                            if($sourceType == 'body')
                                            {
                                                $requestBody = $getPlaceholderDetails[0]['Body'];
                                                
                                                $requestBody = str_replace("(OGAFilter)", '""',  $requestBody);
                                                
                                            }
                                            // Replacing the DBParam Paramter with the value set by the comapny .
                                            if(isset($_SESSION['DBParam'])) {
                                                $arr = explode('|', $_SESSION['DBParam'] );
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
                                                        $requestBody = str_replace("'(".$val[0].")'", $dataVal,  $requestBody);
                                                        $requestBody = str_replace("(".$val[0].")", $dataVal,  $requestBody);
                                                        
                                                    }
                                                }
                                            }
                                            // Replacing the APIParam Paramter with the value set by the comapny .
                                            if(isset($_SESSION['APIParam'])) {
                                                $arr = explode('|', $_SESSION['APIParam'] );
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
                                                        $requestBody = str_replace("'(".$val[0].")'", $dataVal,  $requestBody);
                                                         $requestBody = str_replace("(".$val[0].")", $dataVal,  $requestBody);
                                                        
                                                    }
                                                }
                                                
                                            } 
                                        
                                            $FilterSession = !empty($getPlaceholderDetails[0]['FilterSessionEnable'])?trim($getPlaceholderDetails[0]['FilterSessionEnable']):0;
                                            // (Start)replace now time if its given in call Url .
                                            if (strpos($requestUrl, strtolower('(nowtime)')) !== false) {
                                                if(isset($_SESSION['NowTime'])){
                                                    $gcsCustomer = str_replace("(nowtime)", $_SESSION['NowTime'], $gcsCustomer);
                                                }
                                            }   
                                            
                                        
                                            if (strpos($requestBody, strtolower('(nowtime)')) !== false) {
                                                if(isset($_SESSION['NowTime'])){
                                                    $requestBody = str_replace("(nowtime)", $_SESSION['NowTime'], $requestBody);
                                                }
                                            } 
                                            
                                            // (Start ) If we need to call External Api Like fortnox or Monday then it comes in this condition .
                                            if($getPlaceholderDetails[0]['ExternalAPIReq'])
                                            {
                                            
                                                //(Start) to call an thrid person Api or an External Api we need to access it uername , 
                                                //password and all the required info then condition get all that info that being set at the admin side .
                                                if(isset($_SESSION['CompanyDBUserName']) && strpos($gcsCustomer, '(ExternalAddress)') !== false)
                                                {
                                                    foreach($_SESSION['CompanyDBUserName'] as $k => $v){
                                                        if($_SESSION['CompanyDBPass'][$k][0] == $getPlaceholderDetails[0]['ExternalAPIReq'] ){
                                                            $header =  $_SESSION['CompanyDBUserName'][$k][$getPlaceholderDetails[0]['ExternalAPIReq']][0];
                                                            $header = explode('|', $header);
                                                        }
                                                    }
                                                }
                                                $gcsCustomer = str_replace('(ExternalAddress)', $getPlaceholderDetails[0]['ExternalAPIReq'], $gcsCustomer);
                                            }else if(!empty($getPlaceholderDetails[0]['Headers'])) {
                                                
                                                if(substr_count($getPlaceholderDetails[0]['Headers'], ' ') === strlen($getPlaceholderDetails[0]['Headers'])){
                                                    $header = '';
                                                }else{
                                                    $header = array(($getPlaceholderDetails[0]['Headers']));
                                                } 
                                            }
                                        
                                            // (End) If we need to call External Api Like fortnox or Monday then it comes in this condition .
                                            // Replace the CustomerNo if it comes in body with the one given in Get request.
                                            if(isset( $_GET['CustomerNo'])){
                                                $requestBody = str_replace('(CustomerNo)','"'. $_GET['CustomerNo'].'"', $requestBody);
                                            }
                                            
                                            $ch = curl_init();
                                             
                                            curl_setopt($ch, CURLOPT_NOBODY, false);
                                        
                                            curl_setopt($ch, CURLOPT_URL, $gcsCustomer); // Curl option for url setting 
                                        
                                            if ($requestType && $requestType == 2) {
                                                // Curl for post body 
                                                curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                                                if($header)
                                                {
                                                
                                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                                                }else{
                                                
                                                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                                                }
                                                
                                            }
                                            // Curl option for time out
                                            curl_setopt($ch, CURLOPT_TIMEOUT, 6000000000);
                                            // curl option set to true for getting the result back .
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                            //curl Execute 
                                            $results = curl_exec($ch);
                                            
                                            //(Start) if Api call return any Result 
                                            if ($results) { 
                                                // (Start)decode the json resukt from Api call and make it an array so further processing can be carried out on it .
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
                                                $COLName = $getPlaceholderDetails[0]['tableColumns'].','.$getPlaceholderDetails[0]['SumColumnLable'];
                                                $COLName = trim($COLName,',');
                                                $COLName = explode(',' , $COLName);
                                                $COLNameSort = [];
                                                if($getPlaceholderDetails[0]['ColumnSort']){
                                                    $ColumnSort = explode(',' ,$getPlaceholderDetails[0]['ColumnSort']);
                                                    
                                                    foreach($ColumnSort as $K => $V){
                                                        $newKey = array_search($V , $COLName);
                                                        $COLNameSort[] = $newKey;
                                                        
                                                    }
                                                }
                                                
                                                $columnSumResults = 0;
                                                $getColumnsProperties = '';
                                                $searchValue = '' ;
                                                $searchValueArray = array();
                                                $columnSumResultsValue = array();
                                                // (End)decode the json resukt from Api call and make it an array so further processing can be carried out on it .
                                                if ($apiData) {
                                                    //(Start) if Sum Type is 1 then need get the column Sum before .
                                                    if ($sumType == 1) {
                                                        $columnSumResults = 0;
                                                        $columnSumData = array();
                                                        $singleColumn = $customSumFormula;
                                                        foreach ($apiData as $eachRecord) {
                                                            
                                                            $outputData = searchArray($eachRecord, $singleColumn);
                                                            if ($outputData > 0) {
                                                                try {
                                                                    $outputData = (int)$outputData;
                                                                    $outputData = round($outputData);
                                                                    $columnSumData[] = $outputData;
                                                                } catch (Exception $ex) {
                                                                }

                                                            }
                                                        
                                                        }
                                                        
                                                        if ($columnSumData) {
                                                            $columnSumResults = array_sum($columnSumData);
                                                        }
                                                    }  
                                                    if((!isset($apiData[0]) && is_array($apiData))) //if Api return only single data
                                                    {
                                                        $tempArray =$apiData;
                                                        $apiData = array();
                                                        $apiData[0] = $tempArray;
                                                    }
                                                    //(End) if Sum Type is 1 then need get the column Sum before .  
                                                    //(Start)  when the Api return only one index as result  and set the return tableData variable  
                                                    if(!is_array($apiData) || (count($apiData) == 1 && count($apiData[0]) == 1))
                                                    {
                                                        if($getPlaceholderDetails[0]['TableType'] == '3')
                                                        {
                                                            $tableData['data'][$singleColumn] = $apiData;
                                                            $joinTbaleRes[$getPlaceholderDetails[0]['ID']] = $tableData;
                                                        }else{
                                                            $tableData['data'][] = $apiData;
                                                        }
                                                    }
                                                    // (End)  if Api return only single data
                                                    else{
                                                        if($getPlaceholderDetails[0]['ApiType'] == 3){
                                                            $MaintempData = [];
                                                            $GetColumnName = $getPlaceholderDetails[0]['GetColumnName'];
                                                            $GetValueName = $getPlaceholderDetails[0]['GetValueName'];
                                                            
                                                            $fetchCol = explode('->' , $GetColumnName);
                                                            $fetchName= explode('->' , $GetValueName);

                                                            $colName  = end($fetchCol);
                                                            $colValue = end($fetchName);

                                                            $ist = $apiData[0][$fetchCol[0]];
                                                            
                                                            foreach($ist as $istKey => $istValue){
                                                                $scd = $istValue[$fetchCol[1]];
                                                                $tempData = [];
                                                                foreach($scd as $scdKey => $scdValue){
                                                                    $tempData[$scdValue[$colName]] = $scdValue[$colValue];
                                                                    
                                                                }
                                                                $MaintempData[] = $tempData;
                                                            }
                                                            unset($apiData);
                                                            $apiData = $MaintempData;
                                                        }
                                                    // (Start) For muliple data 
                                                        foreach ($apiData as $eachRecord) {
                                                            
                                                            //(Start) if we have a row 
                                                            if ($eachRecord) {
                                                                //variable declaration
                                                                $matchedData = false;
                                                                $matchedValueCount = 0;
                                                                $keyColumnValue = '';
                                                                $detailColumnValue = '';
                                                                $mapColumnValue = '';
                                                                $columnData = '';
                                                                $customSumDataArr = array();
                                                                //(Start) if column name list is not empty 
                                                                if (isset($getColumnsList)) {

                                                                    $dataToTable = [];
                                                                    $filterData = false;
                                                                    $customSumFormula = (isset($getPlaceholderDetails[0]['CustomSumFormula'])) ? $getPlaceholderDetails[0]['CustomSumFormula'] : "";
                                                                
                                                                    // (Start)for loop for every Column defined at the admin side table Placeholder
                                                                    foreach ($explodeColumns as $singleColumn => $singleColumnValue) {
                                                                        // (Start) For Join table the column name formatting as the column name also has the table Name with it .
                                                                        if($getPlaceholderDetails[0]['TableType'] == 3)
                                                                        {
                                                                            $singleColumnVal = $singleColumn;
                                                                            if(strpos($singleColumn, $getPlaceholderDetails[0]['Name']) !== false){
                                                                                $singleColumn = explode('-', $singleColumn);
                                                                                if($singleColumn[1] != '')
                                                                                    {
                                                                                        $columnDataFlag  = 1;
                                                                                        $singleColumn = end($singleColumn);
                                                                                    }
                                                                                
                                                                                    
                                                                                if (isset($getPlaceholderDetails[0]['ColumnsProperties'])) {
                                                                                    $getColumnsProperties = json_decode($getPlaceholderDetails[0]['ColumnsProperties'], true);
                                                                                    $singleColumnValue = isset($getColumnsProperties[$singleColumn])?$getColumnsProperties[$singleColumn]:$singleColumn;
                                                                                }

                                                                            }
                                                                        }
                                                                        // (End) For Join table the column name formatting as the column name also has the table Name with it .
                                                                        // (Start) Condition that check which column should get the inner node data     
                                                                        if(strpos($singleColumn,'->') !== false)
                                                                        {   
                                                                            $flag1 = 0;
                                                                            global $retVal , $flag1 ;
                                                                            $GLOBALS['retVal'] = array();
                                                                            $GLOBALS['flag1'] = 0;
                                                                            $m_name = explode('->', $singleColumn );
                                                                            $columnData = addforLoops($eachRecord , $m_name , 0 );
                                                                        }
                                                                        // (End) Condition that check which column should get the inner node data    
                                                                        else{
                                                                            if ($singleColumn == $keyColumnName) {
                                                                                $keyColumnValue = searchArray($eachRecord, $singleColumn);
                                                                                $columnData = $keyColumnValue;
                                                                            }
                                                                            if ($singleColumn == 'CountryId') {
                                                                                $columnValue = searchArray($eachRecord, $singleColumn);
                                                                                if ($columnValue == '' || $columnValue == 'SE') {
                                                                                    $customerCountry = 'Sweden';
                                                                                } else if ($columnValue == 'FI') {
                                                                                    $customerCountry = 'Finland';
                                                                                } elseif ($columnValue == 'Ge') {
                                                                                    $customerCountry = 'Georgia';
                                                                                } elseif ($columnValue == 'IT') {
                                                                                    $customerCountry = 'Italy';
                                                                                } elseif ($columnValue == 'TW') {
                                                                                    $customerCountry = 'Taiwan';
                                                                                } elseif ($columnValue == 'NO') {
                                                                                    $customerCountry = 'Norway';
                                                                                } elseif ($columnValue == 'DK') {
                                                                                    $customerCountry = 'Denmark';
                                                                                } else {
                                                                                    $customerCountry = $columnValue;
                                                                                }
                                                                                $columnData = $customerCountry;
                                                                            } else {
                                                                                $columnData = searchArray($eachRecord, $singleColumn);
                                                                            }

                                                                            if ($singleColumn == 'InvoiceNo') {
                                                                                $columnDataValue = searchArray($eachRecord, $singleColumn);
                                                                                $invoiceNo = $columnDataValue;
                                                                            }
                                                                        }
                                                                        // (Start) Custom Sum Calcution  processing . In the code below we are replacing the column name and perform differnt operation like these 
                                                                        if($getPlaceholderDetails[0]['TableType'] != 3){
                                                                            if (isset($customSumFormula) && !empty($customSumFormula) && array_key_exists($singleColumn, $eachRecord)) {

                                                                            if(isset($singleColumnValue['Label']) && $singleColumn != $singleColumnValue['Label'])
                                                                                {
                                                                                        $replaceColumn = "(" . $singleColumnValue['Label'] . ")";
                                                                                    
                                                                                }else{
                                                                                        $replaceColumn = "(" . $singleColumn . ")";
                                                                                }

                                                                                
                                                                                if(is_array($columnData) || is_array($customSumFormula)){


                                                                                    if(is_array($customSumFormula))
                                                                                    {
                                                                                        foreach ($columnData as $k => $v) {

                                                                                            $sumColumnData = str_replace(array(',', ' '), '', $v);
                                                                                            $customSumData = str_replace($replaceColumn, $sumColumnData, $customSumFormula[$k], $cont);
                                                                                            
                                                                                            if($cont)
                                                                                            {   
                                                                                                $customSumDataArr[$k] =  $customSumData;
                                                                                                
                                                                                            }
                                                                                        }
                                                                                        
                                                                                    }else{
                                                                                        foreach ($columnData as $k => $v) {
                                                                                    
                                                                                            $sumColumnData = str_replace(array(',', ' '), '', $v);
                                                                                            $customSumData = str_replace($replaceColumn, $sumColumnData, $customSumFormula, $cont);
                                                                                            if($cont)
                                                                                            {   
                                                                                                array_push($customSumDataArr ,   $customSumData);

                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    $customSumData = $customSumDataArr;
                                                                                    $customSumFormula = $customSumDataArr ;

                                                                                }else{
                                                                                
                                                                                    $sumColumnData = str_replace(array(',', ' '), '', $columnData);
                                                                                    $customSumData = str_replace($replaceColumn, $sumColumnData, $customSumFormula);
                                                                                    $customSumFormula = $customSumData;
                                                                                }
                                                                            }
                                                        
                                                                            $columnData = ColumnProperties($columnData,$singleColumnValue);
                                                                            $columnData = columnDataRound($columnData,$singleColumnValue);
                                                                        }
                                                                        // (End) Custom Sum Calcution  processing . In the code below we are replacing the column name and perform differnt operation like these  
                                                                        if (!empty($searchValue) && isset($searchValue[$singleColumn])) {
                                                                            $columnDataValue = strtolower($columnData);
                                                                            if(isset($searchValue[$singleColumn])) {
                                                                                $searchValueComumn = explode('|',$searchValue[$singleColumn]);
                                                                                $searchValueComumnCount = count($searchValueComumn);
                                                                                if($searchValueComumnCount > 1) {
                                                                                    for($i = 0; $i < $searchValueComumnCount; $i++ ) {
                                                                                        if (strpos($columnDataValue, strtolower($searchValueComumn[$i])) !== false) {
                                                                                            $matchedValueCount++;
                                                                                        }
                                                                                    }
                                                                                } else {
                                                                                    if (strpos($columnDataValue, strtolower($searchValueComumn[0])) !== false) {
                                                                                        $matchedValueCount++;
                                                                                    }
                                                                                }
                                                                            }
                                                                        
                                                                            if($getPlaceholderDetails[0]['TableType'] == '3')
                                                                            { 
                                                                                $dataToTable[$singleColumnVal] = $columnData;

                                                                            }else{
                                                                                $dataToTable[] = $columnData;
                                                                            }
                                                                            
                                                                        } else {
                                                                            if($getPlaceholderDetails[0]['TableType'] == '3')
                                                                            { 
                                                                                $dataToTable[$singleColumnVal] = $columnData;

                                                                            }else{
                                                                                $dataToTable[] = $columnData;
                                                                            }
                                                                        }
                                                                        if(isset($singleColumnValue['Label']))
                                                                        {
                                                                            if (array_key_exists($singleColumnValue['Label'], $tableActions)) {
                                                                                foreach ($tableActions[$singleColumnValue['Label']] as $key => $value) {
                                                                                    $tableActions[$singleColumnValue['Label']][$key]['TableParameterColumnValue'] = $columnData[0];
                                                                                }
                                                                            }
                                                                        }else{
                                                                            if (array_key_exists($singleColumn, $tableActions)) {
                                                                                foreach ($tableActions[$singleColumn] as $key => $value) {
                                                                                    $tableActions[$singleColumn][$key]['TableParameterColumnValue'] = $columnData;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                    //(End)for loop for every Column defined at the admin side table Placeholder
                                                                    //(Start) code for custom Sum Calculation 
                                                                    
                                                                    $sumColumnLable = trim($sumColumnLable);
                                                                    
                                                                    if (isset($sumColumnLable) && !empty($sumColumnLable)) {
                                                                        if (isset($explodeColumns)) {
                                                                            if (!in_array($sumColumnLable, $explodeColumns)) {
                                                                                if (!empty($customSumData) ) {
                                                                                    if(is_array($customSumData))
                                                                                    {
                                                                                        $result = 0;
                                                                                        if($customSumData[0] == '/'){
                                                                                            $result = 0;
                                                                                            $dataToTable[] = $result;
                                                                                        }else{
                                                                                            
                                                                                            $tempArr = array();
                                                                                            $tempVal = explode(',', $customSumData[0]);

                                                                                            foreach ($tempVal  as $key => $value) {
                                                                                                $tempArr[$key] = array();
                                                                                            }
                                                                                            
                                                                                            foreach ($customSumData as $key1 => $value1) {
                                                                                                    // calling the function for custom Sum .
                                                                                                    $getColumnsProperties = json_decode($getPlaceholderDetails[0]['ColumnsProperties'], true);
                                                                                                   SumCalulation($sumType , $customSumData , $columnSumResults , $getColumnsProperties , $sumColumnLable , $searchValue , $searchValueArray , $columnSumResultsValue , $value1 , $dataToTable , 'multiple');
                                                                                            }
                                                                                            if(count($tempArr) > 0)
                                                                                            {
                                                                                                foreach ($tempVal  as $key => $value) {
                                                                                                    $dataToTable[] = $tempArr[$key];
                                                                                                }
                                                                                            }else{
                                                                                                $dataToTable[] = $result;
                                                                                            }
                                                                                        }
                                                                                        
                                                                                    }else{
                                                                                        if($customSumData[0] == '/'){
                                                                                            $result = 0;
                                                                                            $dataToTable[] = $result;
                                                                                        }else{
                                                                                            $sepVal =  explode(',', $customSumData);
                                                                                            if(count($sepVal) >=1){
                                                                                                $sepLabel =  explode(',', $sumColumnLable);
                                                                                                foreach ($sepVal as $key1 => $value1) {
                                                                                                    $getColumnsProperties = json_decode($getPlaceholderDetails[0]['ColumnsProperties'], true);

                                                                                                    $dataToTable[] = SumCalulation($sumType ,  $value1 , $columnSumResults , $getColumnsProperties , $sepLabel[$key1] , $searchValue , $searchValueArray , $columnSumResultsValue , $value1 , $dataToTable , 'single' );
                                                                                                }
                                                                                            }else{
                                                                                                $getColumnsProperties = json_decode($getPlaceholderDetails[0]['ColumnsProperties'], true);
                                                                                                $dataToTable[] = SumCalulation($sumType , $customSumData , $columnSumResults , $getColumnsProperties , $sumColumnLable , $searchValue , $searchValueArray , $columnSumResultsValue , $customSumData , $dataToTable , 'single' );
                                                                                            
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }

                                                                    }	

                                                                    if($getPlaceholderDetails[0]['AddZeroForNegVal']){
                                                                        $ColAddZeroForNegVal = isset($getPlaceholderDetails[0]['ColAddZeroForNegVal'])?explode(',',$getPlaceholderDetails[0]['ColAddZeroForNegVal']):[];
                                                                        
                                                                        foreach($ColAddZeroForNegVal as $NKey => $NVal){
                                                                            foreach($COLName as $COLNameKey => $COLNameVal){
                                                                                
                                                                                    if(($COLName[$COLNameKey]) == trim($NVal)){
                                                                                        if(strpos($dataToTable[$COLNameKey] , '-') !== false){
                                                                                            $dataToTable[$COLNameKey]  = 0;
                                                                                            break;
                                                                                            
                                                                                        }
                                                                                        
                                                                                        
                                                                                    }
                                                                        
                                                                            }
                                                                        }
                                                                    }
                                                                    
                                                                    $tempArrColumnSort = array();
                                                                    if(trim($getPlaceholderDetails[0]['ColumnSort']) != ''){
                                                                        $ColumnSort = explode(',' ,$getPlaceholderDetails[0]['ColumnSort']);
                                                                        
                                                                        foreach($COLNameSort as $ColumnSortKey => $ColumnSortVal){
                                                                            
                                                                            $tempArrColumnSort[] =  $dataToTable[$ColumnSortVal];
                                                                            
                                                                        }
                                                                        //$dataToTable = $tempArr;
                                                                        
                                                                    }
                                                                    
                                                                    // action Button 
                                                                    if($tableActions){
                                                                        
                                                                        $ActValue = getActionButton($tableActions , $dataToTable , $actationTableColumn , $placeholderId , $userPagePlaceholder);
                                                                        if($tempArrColumnSort){
                                                                            $tempArrColumnSort[] =$ActValue[0];
                                                                            $tempArrColumnSort[] =$ActValue[1];
                                                                        }
                                                                        else{
                                                                            $dataToTable[] =$ActValue[0];
                                                                            $dataToTable[] =$ActValue[1];
                                                                        }
                                                                        
                                                                    }
                                                                    
                                                                    
                                                                    if ($filterion) {
                                                                        if(isset($searchValueCount) && $searchValueCount == $matchedValueCount) {
                                                                            if($tempArrColumnSort){
                                                                                $tableData['data'][] =$tempArrColumnSort;
                                                                            }else{
                                                                                $tableData['data'][] = $dataToTable;
                                                                            }
                                                                        }
                                                                    } 
                                                                    else {
                                                                        if($tempArrColumnSort){
                                                                            $tableData['data'][] =$tempArrColumnSort;
                                                                        }else{
                                                                            $tableData['data'][] = $dataToTable;
                                                                        }
                                                                    }
                                                                }//(End) if column name list is not empty 
                                                            }// (End)for loop for every  record
                                                        }//(End) if we have multiple records 
                                                    }//End forEach Multiple
                                                }//End If apiData
                                                
                                            }// End if results
                                        }
                                    }
                                    
                                }
                                //(End) Fetching Data  from Data Source Call Api
                            }
                        }
                        if (isset($getColumnsList)) {
                            $explodeColumns = explode(',', $getColumnsList);
                            if($explodeColumns[0] == 'checkbox' || $explodeColumns[0] == 'box' ) {
                                for ($new=0; $new < count($tableData['data']) ; $new++) { 
                                    $tableData['data'][$new][0] = $new+1;
                                }
                            }
                        }
                                    
                        //(End)if we have fetched data for placeholder
                        //Condition to be exceuted in case of Multiple Node .
                        if(isset($_REQUEST['ticket_id']))
                        {
                            return $tableData;
                        }else{
                            if(isset($getPlaceholderDetails) && $getPlaceholderDetails[0]['ApiType'] == '2')
                            {
                                $input = array();
                                $input = array_map("unserialize", array_unique(array_map("serialize", $tableData)));
                                unset($tableData);
                                $tableData['data'] = array_values($input);
                                $tableData['data'] = array_values($input);
                                foreach ($tableData['data'] as $key => $value) {
                                    foreach ($value as $ke => $val) {
                                        if(empty($val))
                                        {
                                        $tableData['data'][$key][$ke ] = '';
                                        }
                                    }
                                }
                            
                                if( is_dir($CompanyDir) === false )
                                {
                                    mkdir($CompanyDir , 0777);
                                }
                                if(is_dir($CompanyUserDir) === false){
                                    mkdir($CompanyUserDir , 0777);
                                }
                                $fp = fopen( $fileName, 'wb');
                                file_put_contents($fileName, json_encode($tableData, JSON_UNESCAPED_SLASHES) );
                                if($getPlaceholderDetails[0]['EnableCacheTable']){
                                    $keyName = $_SESSION['CompanyID'] .'-'.$_SESSION['UserID'] .'-'.$placeholderId;
                                    $NewData = json_encode($tableData, JSON_UNESCAPED_SLASHES);
                                    $redis = new Redis();
                                    $redis->connect('127.0.0.1', 6379); //change in Linux
                                    $redis->hset($_SESSION['UserID'],$keyName, $NewData );
                                }
                            
                            }else{
                                
                                if( is_dir($CompanyDir) === false )
                                {
                                    mkdir($CompanyDir , 0777);
                                }
                                if(is_dir($CompanyUserDir) === false){
                                    mkdir($CompanyUserDir , 0777);
                                }
                                $fp = fopen( $fileName, 'wb');
                                file_put_contents($fileName, json_encode($tableData, JSON_UNESCAPED_SLASHES) );
                                if($getPlaceholderDetails[0]['EnableCacheTable']){
                                    
                                    $keyName = $_SESSION['CompanyID'] .'-'.$_SESSION['UserID'] .'-'.$placeholderId;
                                    $NewData = json_encode($tableData, JSON_UNESCAPED_SLASHES);
                                    $redis = new Redis();
                                    $redis->connect('127.0.0.1', 32771); //change in Linux
                                    $RedisCheck =  $redis->exists([$_SESSION['UserID'] ,$keyName]) ;
                                    
                                    if( $RedisCheck  === 1){
                                    
                                        $redis->del($keyName);
                                        
                                    }
                                    $redis->hset($_SESSION['UserID'],$keyName, $NewData );
                                }
                            }
                        }
                    }

                }
                
            }
        }
    }
   exit;


?>