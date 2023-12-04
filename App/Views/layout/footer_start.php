<?php
use \App\Models\Placeholder;
use App\Controllers\PanelAndDataTables;
use \App\Models\MongoTable;
use App\Models\Page;
$filterationApplied = '';
$pholderId = '';
$searchValue = '';
$_SESSION['queryString']  = '';
if (!empty($_REQUEST['pholderid']) && !empty($_REQUEST['searchvalue'])) {
    $filterationApplied .= '&pholderid=' . $_REQUEST['pholderid'] . '&searchvalue=' . $_REQUEST['searchvalue'];
    $pholderId = trim($_REQUEST['pholderid']);
    $searchValue = $_REQUEST['searchvalue'];
    $searchValue = json_decode($searchValue);
    if($searchValue) {
        $searchValue = (array)$searchValue[0];
        $searchValue = json_encode($searchValue, JSON_UNESCAPED_SLASHES);
    }

}
if (!empty($_REQUEST['Noti']) ) {
    $_SESSION['NotiCheck'] = $_REQUEST['Noti']  ;
	
}else{
    unset($_SESSION['NotiCheck']);
}


$newArrCheck = array();
if (!empty($_REQUEST['columnName']) && !empty($_REQUEST['columnValue'])) {
   
	
    $filterationApplied .= '&';
    $filterationApplied .= $_REQUEST['columnName'] . '=' . $_REQUEST['columnValue'];
    if(isset($_REQUEST['OGAFilter'])){
        $filterationApplied .= '&OGAFilter=' . $_REQUEST['OGAFilter'];
    }
    //$_SESSION['NoRedisFoucus'] = 1;
    if(isset($_REQUEST['focusPage']))
    {
        
        $Loc = isset($_REQUEST['currLoc'])?str_replace('#' , '' , $_REQUEST['currLoc']):'';
        $Loc =str_replace('undefined', '' , $Loc);
        $Loc = explode('page?' ,  $Loc );
        $Loc = '/page?'.$Loc[1];
       
		if(strpos($Loc, '&check=') !== false )
		{
			$Loc = explode('&check=' ,  $Loc );
			$Loc = $Loc[0];
			
		}
		
        $filterationApplied .= '&focusPage=1';
        $nct = 0;
        foreach($_REQUEST as $key => $val){
            if(strpos($key, 'Filter') ){
                if(strpos($key, 'Range') ){
                    
                    $key = str_replace('Filter', '' , $key);
                    if($val != '')
                    {
                        $vla = explode(',' , $val);
                        $from = explode(':' , $vla[0]);
                        $to = explode(':' , $vla[1]);
                        $_SESSION[$Loc.$_REQUEST['TableId'].'Range'][$nct] = ['from' => $to[1] , 'to' => $from[1]];
						if(isset($_SESSION[$Loc.$_REQUEST['TableId']]) && !is_array($_SESSION[$Loc.$_REQUEST['TableId']]))
						{
							unset($_SESSION[$Loc.$_REQUEST['TableId']]);
						}	
						$_SESSION[$Loc.$_REQUEST['TableId']][] = null;
                        
                    }
                }else{
                    $key = str_replace('Filter', '' , $key);
                    
                    if($val == '')
                    {
						if(isset($_SESSION[$Loc.$_REQUEST['TableId']]) && !is_array($_SESSION[$Loc.$_REQUEST['TableId']]))
						{
							unset($_SESSION[$Loc.$_REQUEST['TableId']]);
						}	
						$_SESSION[$Loc.$_REQUEST['TableId']][] = null;
						
                    }else{
                       
                        $val = str_replace(array( '^', '$',
                        '(' , '?', '.', ')' , '*' ,'!' ) , '' , $val);
						 $_SESSION[$Loc.$_REQUEST['TableId']][] = ['sSearch' => $val , 'bRegex' => true];
						 
                    }
                }
               $nct++;
            }else if(strpos($key, 'Sort')){
                $sortVal = explode(',' , $val);
                
                $_SESSION[$Loc.$_REQUEST['TableId'].'SortIndex'] = $sortVal[0];
                $_SESSION[$Loc.$_REQUEST['TableId'].'SortOrder'] =  $sortVal[1];
            }
        }
        if(isset( $_SESSION[$Loc.$_REQUEST['TableId']]) ){

         
            $pageId =  explode('?id=' ,$Loc);
            $pageIdNew =  explode('&page_text=' ,$pageId[1]);
            $pageId = $pageIdNew[0];
            $pageNameCurr =  explode('&check=' ,$pageIdNew[1]);
            $pageNameCurr =  str_replace('%20', ' ' ,$pageNameCurr[0]);
            $holderName  = $_REQUEST['TableId'];
            
            $userId = isset($_SESSION['UserID'])?$_SESSION['UserID']:'';
            $Pid = isset($_SESSION['ParentUserID'])?$_SESSION['ParentUserID']:'';
            $userIdNew  = !empty($Pid)?$Pid:$userId;
            
            $value = $_SESSION[$Loc.$_REQUEST['TableId']];
          
            $value = str_replace(array( '^', '$',
            '(' , '?', '.', ')' , '*' ,'!' ) , '' , $value);
            //$value = explode(',' ,$value);
            $newArr = array();
            $newArr1 = array();
			
            foreach( $value as $key => $val){
                    if(empty($val)){
                        $newArr[$key] = null ;
                    }else {
                        $newArr[$key] = $val;
                        //$newArr[$key]["bRegex"] = true;
                    }
            }
            $newArr = array_filter($newArr)?$newArr:''; 
			$newArrCheck[$userIdNew] = $newArr;
			$newArrCheck = json_encode($newArrCheck);
            $_SESSION[$Loc.$_REQUEST['TableId']] = $newArrCheck;
            //$getData = Page::GetPageSearchFilter($pageId, $userId, $pageNameCurr , $holderName );
        
            //$getData = isset($getData['SearchFilter'])?json_decode($getData['SearchFilter'] , true):array();
            //$getDataCheck = !empty($getData)?array_filter($getData):''; 
            //if(!empty($getDataCheck)){
                //$getData[$userIdNew] = $newArr;
            //}else{
               // $getData[$userIdNew] = $newArr;
            //}
        
            //$newArr = json_encode($getData);
            
           // $dataNew = Page::AddPageSearchFilter($pageId, $userId, $pageNameCurr , $holderName ,  $newArr  );
            

        }
    }
   
}


if (!empty($_REQUEST['columnName']) && !empty($_REQUEST['columnValue'])) {

    $_SESSION['queryString']  = '&columnName=' . $_REQUEST['columnName'] . '&columnValue=' . $_REQUEST['columnValue'];
}
$allTablePlaceID = array_column($getPagePlaceholders, 'PlaceholderValue'); 
?>
<script>
    var elements = document.getElementsByClassName("table-scrollable");
    var ScrollBtn = '<div class="arrow-container">'+
                        '<div class="left"></div>'+
                        '<div class="right"></div>'+
                    '</div>';
    //$(".table-scrollable").prepend(ScrollBtn);
    for(var i = 0; i < elements.length; i++){
        $(ScrollBtn).insertBefore( elements[i]);
       
    }
    
    // var tableId = document.querySelectorAll('[class^="Table_"]');
   
    // var AllIdsTable = <?php //echo json_encode($allTablePlaceID); ?>;
    // var  tempArr = [];
    // for (let i = 0; i < AllIdsTable.length; i++) {
    
    //     if(AllIdsTable[i].includes('Table_')){
    //         for (let j = 0; j < tableId.length; j++) {
                
    //             if(tableId[j].className == AllIdsTable[i]){

                  
    //                 tempArr.push(tableId[j].className);
    //             }

    //         }
           
    //     }
    // }
    // for (let i = 0; i < tableId.length; i++) {
    //     if(!tempArr.includes(tableId[i].className)){
    //         console.log(tableId[i].className);
    //         var TabsPart = document.querySelectorAll('[class^="mdl-tabs__tab tabs_three"]');
           
    //         if(TabsPart.length > 0){
    //             $( "#"+tableId[i].className )
    //             .closest( "div.mdl-tabs__panel" )
    //             .css( "display", "none" );
    //         }else{
    //             $( "."+tableId[i].className )
    //             .closest( ".row" )
    //             .css( "display", "none" );
    //         }
           

    //     }
    // }
   

                
//     $( "li.item-a" )
//   .closest( "ul" )
//   .css( "background-color", "red" );
</script>

<!-- Custome_Code -->
<script src="<?php echo baseUrl; ?>assets/Custome_Code/DataTables/customDataTables.js"></script>
<script src="<?php echo baseUrl; ?>assets/Custome_Code/Panels/customPanel.js"></script>
<script src="<?php echo baseUrl; ?>assets/Custome_Code/Highsofts/customHighCharts.js"></script>
<script src="<?php echo baseUrl; ?>assets/Custome_Code/Highsofts/customHighPieCharts.js"></script>

<script src="<?php echo baseUrl; ?>assets/Custome_Code/Highsofts/customHighMaps.js"></script>
<script src="<?php echo baseUrl; ?>assets/Custome_Code/DataTables/customSendordersTable.js"></script>
<script src="<?php echo baseUrl; ?>assets/Custome_Code/DataTables/customFormUpdates.js"></script>
<script src="<?php echo baseUrl; ?>assets/Custome_Code/DataTables/customButton.js"></script>
<script src="<?php echo baseUrl; ?>assets/Custome_Code/DataTables/customFooterSum.js"></script>
<script type="text/javascript">
    
$(document).on("click", "#navbarDropdown", function(){
  
    $.ajax({
            type: "POST",
            url: 'setSessionFilter',
            data: "save", // serializes the form's elements.
            success: function(data)
            {
                console.log("mlkm");
            }
          });
});

</script>

<?php


foreach($_SESSION as $key => $value) {
  if(strpos($key, 'DS_ID_'))
  {
        unset($_SESSION[$key]);
  }
}

if (isset($getPagePlaceholders)) {
    $pannelIds = array();
   
    $mapPresent = 0;
    $pieChartPresent = 0;
    //$graphDiscription = array();
    $graphDes = array();

    if(!empty($graphDiscription))
    {
        $graphDes = json_decode($graphDiscription);
    }

    foreach($getPagePlaceholders as $arr1)
    {
        if(in_array('MapHC_1',$arr1))
        {
           $mapPresent = 1;
        }

        if(in_array('PieChartHC_1',$arr1))
        {
           $pieChartPresent = 1;
        }
    }
   
    if(!empty($graphDes)){
        $placeHolderId = (string)$arr1['PlaceholderId'];
        $tableId = 'TableId';
        if(isset($graphDes->$tableId))
        {
             print_r($graphDes->$tableId); exit;
        }
       
        if(isset($graphDes->$placeHolderId))
        {

            $graphDes1 = $graphDes->$placeHolderId; 
            
        }
     }
    $mainArr = [];
    $allTabs = [];
    foreach ($getPagePlaceholders as $key => $value) {
        if(!empty($value['TablesId'])){
       
            
            $temp['linkedArr'] = $value['Tablelinked'];
            $temp['commonField'] =  $value['CommonField'];
            $mainArr[$value['TablesId']][0] =  $temp;
        
      
        }
    }
      if(!empty($mainArr))
        {       
           
           $mainArrNew = [];
            foreach ($mainArr as $k => $v) {
                $temp = [];
                 $flg =0;
                 $mainArrNew[$k] = $v;
                foreach ($mainArr as $k1 => $v1) {
                         
                    
                        if($v1[0]['linkedArr'] == $k)
                        {
                          
                           
                            $flg = $flg+1;
                            $temp['linkedArr'] = $k1;
                            $temp['commonField'] =  $v1[0]['commonField'];
                            $temp['rlink'] = 'rlink';
                            $mainArr[$k][$flg] =  $temp;

                            foreach ($mainArr as $keysss => $valuessss) {
                                if($valuessss[0]['linkedArr'] == $k1)
                                {
                                    $flg = $flg+1;
                                    $temp['linkedArr'] = $keysss;
                                    $temp['commonField'] =$valuessss[0]['commonField'];
                                    $temp['rlink'] = 'rlink';
                                    $mainArr[$k][$flg] =  $temp;
                                }
                            }
                         

                        
                        }
                    
                    
                }
                  foreach ($mainArr as $k1 => $v1) {
                         
                        
                        if($v[0]['linkedArr'] == $k1)
                        {
                         
                            $flg = $flg+1;
                            $temp['linkedArr'] = $v1[0]['linkedArr'];
                            $temp['commonField'] =  $v1[0]['commonField'];
                            $temp['rlink'] = 'rlink';
                            $mainArr[$k][$flg] =  $temp;
                            if(isset($mainArr[$v1[0]['linkedArr']])){
                                $flg = $flg+1;
                                $temp['linkedArr'] = $mainArr[$v1[0]['linkedArr']][0]['linkedArr'];
                                $temp['commonField'] = $mainArr[$v1[0]['linkedArr']][0]['commonField'];
                                $temp['rlink'] = 'rlink';
                                $mainArr[$k][$flg] =  $temp;

                            }
                           
                        
                        }
                    
                    
                }
        } 
    
         $flg = 0 ;
          $temp = [];
             foreach ($mainArr as $k => $v) {
                    if(!array_key_exists($v[0]['linkedArr'], $mainArr)){
                        
                       
                        foreach ($v as $keyss => $valss) {

                            if($valss['linkedArr'] == $v[0]['linkedArr'])
                            {
                                    $temp['linkedArr'] = $k;
                                    $temp['commonField'] =  $v[0]['commonField'];
                                   
                                    $mainArr[$v[0]['linkedArr']][0] =  $temp;
                            }else
                            {
                                    $temp['linkedArr'] = $valss['linkedArr'];
                                    $temp['commonField'] =  $valss['commonField'];
                                    $temp['rlink'] = 'rlink';
                                    $mainArr[$v[0]['linkedArr']][$flg] =  $temp;
                            }
                            $flg = $flg+1;
                        }
                      
                    }

             }

         
         $allTabs =array_keys($mainArr);
         foreach ($allTabs as $key => $value) {

             $allTabs[$value] = $mainArr[$value][0]['commonField'];
             unset($allTabs[$key] );
         }
          
        }
    
    foreach ($getPagePlaceholders as $key => $value) {
        
        
        $userPageAccessPlaceholderId = $value['ID'];
        $selectedPlaceholderId = $value['PlaceholderId'];
        $type = $value['PlaceholderType'];
        $tableIds = $value['TablesId'];
        $tableLinked = $value['Tablelinked'];
        $commonField = $value['CommonField'];

        $getDataUrl = '';
        $getColumnsUrl = '';
        $getPanelInformation = '';
        $getPanelData = '';
        $placeholderValue = $value['PlaceholderValue'];

        $searchVar = 'noData';
        $searchVarRange = 'noData';
        $sessionsearchVar = 'noData';
        $sessionsearchVarMulti = array();
        $sessionsearchVarRange  = 'noData';
        $sessionSort  = 'noData';
        $currentUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] ;
       
        $PageName = explode('&page_text=' , $_SERVER['REQUEST_URI']);
        $pageId = explode('?id=' ,$PageName[0]); 
        $pageId = $pageId[1];
        $PageName = $PageName[1];
        $PageName = str_replace('%20', ' ', $PageName);
        $_SESSION['currentPageName1'] = $PageName;
        $NewPath = explode('page?' , $_SERVER['REQUEST_URI']);
        $NewPath = '/page?'.$NewPath[1];
       $URLPathCheck = '';
        $name ='';
       
        if(isset($_SESSION['removeSession'])){
            $getKeys = array_keys($_SESSION);
           
            foreach( $getKeys as $k =>$v){
                if(strpos($v ,$placeholderValue) !== false){
                   
                        if($v != $NewPath.$placeholderValue || $v != $NewPath.$placeholderValue.'Range' || $v != $NewPath.$placeholderValue.'SortOrder' ){
                            $name = explode($placeholderValue , $v);
                            $name = $name[0].$placeholderValue;
                           
                            break;
                        }
                }
            }
        }
        
        // if( isset($_SESSION[$name]) && isset($_SESSION['removeSession']) ){
           

        //         unset($_SESSION[$name]);

        //         if( isset($_SESSION[$name.'Range'])){
                    
        //             unset($_SESSION[$name.'Range']);
        //         }    
        //         if( isset($_SESSION[$name.'SortIndex']) && isset($_SESSION[$name.'SortOrder'])){
                    
        //             unset($_SESSION[$name.'SortIndex']);
        //             unset($_SESSION[$name.'SortOrder']);
        //         }
        //     unset($_SESSION['removeSession']);

        // }
        
        if( isset($_SESSION[$NewPath .$placeholderValue])){
                $URLPath = $NewPath;
               
        }else{
            if(strpos($NewPath , '&check=')){
               
                if(strpos($NewPath , '&columnName=')){
                    $URLPath = explode('&columnName=', $NewPath);
                   
                    $URLPath =  $URLPath[0];
                   
                    if( !isset($_SESSION[$URLPath .$placeholderValue])){
                        $URLPath = $NewPath;
                    }
                    
    
                }else {
                    $URLPath = explode('&check=', $NewPath);
                
                    if(count($URLPath) > 2){
                        $URLPath =$URLPath[0].'&check='.$URLPath[1];
                        if( !isset($_SESSION[$URLPath .$placeholderValue])){
                            $URLPath = $NewPath;
                        }
                        
                    }else {
                        $URLPath =  $URLPath[0];
                        $URLPath = str_replace('//' , '/' , $URLPath);
                        if( !isset($_SESSION[$URLPath .$placeholderValue])){
                            $URLPath = $NewPath;
                        }
                    }
                }
               
            }
            else{
                $URLPath = $NewPath;
            }
			if(strpos($URLPath, '&check=') !== false )
			{
				$URLPathCheck = explode('&check=' ,  $URLPath );
				$URLPathCheck = $URLPathCheck[0];
			}else {
				$URLPathCheck =$URLPath;
			}
			 
        }
		
        //print_r($URLPathCheck .trim($placeholderValue));
		//exit;
        $checkFilters = '';
        //if( isset($_SESSION[$URLPath .$placeholderValue])  ){
        if( !empty( $value['SearchFilter']) && (isset($_SESSION['SaveFilterBTN']) && $_SESSION['SaveFilterBTN'] == '1') ){
			
            $FilSearch =  json_decode($value['SearchFilter'] , true);
            $userId = isset($_SESSION['UserID'])?$_SESSION['UserID']:'';
            $Pid = isset($_SESSION['ParentUserID'])?$_SESSION['ParentUserID']:'';
            $userIdNew  = !empty($Pid)?$Pid:$userId;
			
            if(isset($FilSearch[$userIdNew])){
                $checkFilters = $FilSearch[$userIdNew];
            }else if(isset($_SESSION[$URLPathCheck .trim($placeholderValue)])){
				$FilSearch =  isset($_SESSION[$URLPathCheck .$placeholderValue])?json_decode($_SESSION[$URLPathCheck .$placeholderValue], true):[];
				if(isset($FilSearch[$userIdNew])){
					$checkFilters = $FilSearch[$userIdNew];
				}
			}
			
			//print_r($checkFilters);
        }
		
        if( !empty($checkFilters) && (isset($_SESSION['SaveFilterBTN']) && $_SESSION['SaveFilterBTN'] == '1')  ){
            $searchVar = array();
          
            $searchVar['PredefineSearch'] = $checkFilters;
            $sessionsearchVar = json_encode( $searchVar);
           
            $sessionsearchVarMulti[$placeholderValue] = $searchVar;
           
            //unset($_SESSION[$URLPath .$placeholderValue]);

            if( isset($_SESSION[$URLPath .$placeholderValue.'Range'])){
                $searchVarRange = array();
                
                $searchVarRange['PredefineSearchForRange'] = $_SESSION[$URLPath .$placeholderValue.'Range'];
                $sessionsearchVarRange = json_encode( $searchVarRange);
                unset($_SESSION[$URLPath .$placeholderValue.'Range']);
            } 
            
            if( isset($_SESSION[$URLPath .$placeholderValue.'SortIndex']) && isset($_SESSION[$URLPath .$placeholderValue.'SortOrder'])){
                $sessionSort = array();
                
                $sessionSort['PredefineSort'] = $_SESSION[$URLPath .$placeholderValue.'SortOrder'];
                $sessionSort['PredefineSortIndex'] = $_SESSION[$URLPath .$placeholderValue.'SortIndex'];
                
                $sessionSort = $sessionSort;
                unset($_SESSION[$URLPath .$placeholderValue.'SortIndex']);
                unset($_SESSION[$URLPath .$placeholderValue.'SortOrder']);
            }
            
            
        }
 
        $placId = trim($selectedPlaceholderId);
     
        $_SESSION[ $placId.'_orgData'] =  $sessionsearchVar;
       
        if ($type == 1) {
            $getPanelInformation = baseUrl . 'getPanelInformation?id=' . $userPageAccessPlaceholderId . '&placeholderId=' . $selectedPlaceholderId;
            $getPanelData = baseUrl . 'getPanelData?id=' . $userPageAccessPlaceholderId . '&placeholderId=' . $selectedPlaceholderId;
            $getPanelData .= $filterationApplied;
            ?>
            <script>
                panelInformationUrl = '<?php echo $getPanelInformation;?>';
                panelDataUrl = '<?php echo $getPanelData;?>';
                Placeholder_ID = '<?php echo $placeholderValue;?>';
                placeholderPanelId = '<?php echo $selectedPlaceholderId;?>';
                ShowPanelData(panelDataUrl, Placeholder_ID, panelInformationUrl,placeholderPanelId);
            </script>
        <?php } else if ($type == 2) {
			
			if(!empty($filterationApplied) ){
				$_SESSION['NoRedisFoucus'] = 1;
			}
            $getDataUrl = baseUrl . 'generateTable?id=' . $userPageAccessPlaceholderId . '&placeholderId=' . $selectedPlaceholderId;
            $getColumnsUrl = baseUrl . 'getTableColumns?id=' . $userPageAccessPlaceholderId . '&placeholderId=' . $selectedPlaceholderId;
            $getDataUrl .= $filterationApplied;
            $getPlaceholderDetails = Placeholder::getDataTableDescription($selectedPlaceholderId);
            $tabDetail = Page::getDatasourceTableDetails($selectedPlaceholderId);
            
            if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == 1 &&  $tabDetail[0]['EnableTxtFile'] == '1' && $tabDetail[0]['ReportOnLoad'] == 1 && $tabDetail[0]['FilterSessionEnable'] == 1 && (isset($_SESSION['SaveFilterBTN']) && $_SESSION['SaveFilterBTN'] == '1') ){
                //$server = explode('htdocs/' , $_SERVER['DOCUMENT_ROOT']);
                //$server = $server[0].'htdocs/Babcportal';
				$server = $_SERVER['DOCUMENT_ROOT'];
                $server = $server.'/BabcPortal_Other_Assests/BabcPortal/Reports/';
                $CompanyDir =  $server.trim($_SESSION['CompanyName']).'/';
                $CompanyUserDir =  $server.trim($_SESSION['CompanyName']).'/'.$_SESSION['UserFirstName'].'/';
            
                $file = $placId .'_'.$tabDetail[0]['Descriptions'];
                
                $fileNameSearch = $CompanyUserDir.$file.'Search.txt';
                
                if(file_exists($fileNameSearch)){
                    $fileDataSearch = file_get_contents($fileNameSearch);
                    if($fileDataSearch != ''){
                        $_SESSION[$placId .''] = $fileDataSearch;
                        $sessionsearchVar = $fileDataSearch;
                    }
                }
            }

            if( isset($_SERVER['HTTP_REFERER']) && isset($_SESSION[$currentUrl.$_SERVER['HTTP_REFERER'].$placeholderValue]) &&  $tabDetail[0]['EnableTxtFile'] == '1' && $tabDetail[0]['ReportOnLoad'] == 1  && $tabDetail[0]['FilterSessionEnable'] == 1 && (isset($_SESSION['SaveFilterBTN']) && $_SESSION['SaveFilterBTN'] == '1')){
               
                if($tabDetail[0]['ReportOnLoad'] == 1){
                       
                    $resSearch = json_encode($_SESSION[$currentUrl.$_SERVER['HTTP_REFERER'].$placeholderValue]);
                    
                    file_put_contents($fileNameSearch, $resSearch );
                 }
            }
            $tableTitle = '';
            if ($getPlaceholderDetails) {
                $tableTitle = (isset($getPlaceholderDetails[0]['Descriptions'])) ? $getPlaceholderDetails[0]['Descriptions'] : "";
            }
            
            if(isset($_SESSION['AllParameters'])  )
            {
                foreach ($_SESSION['AllParameters'] as $key => $value) {

                 
                    if('('. $value['ParamName'].')' == $tableTitle){
                        $tableTitle = $value['ParamValue'];
                    }
                }
            }
            ?>

            <script>
               
                url = '<?php echo $getDataUrl;?>';
                columnsUrl = '<?php echo $getColumnsUrl;?>';
                Placeholder_ID = '<?php echo $placeholderValue;?>';
                placeholderId = '<?= $selectedPlaceholderId;?>';
                tableTitle = '<?= $tableTitle;?>';
                searchValue = '<?= $searchValue;?>';
                pannelIds = '<?= $panelGraphIds;?>';
                graphDiscription = '<?= $graphDiscription;?>';
                pieDiscription='<?= $pieDiscription;?>';
                mapDiscription = '<?= $mapDiscription;?>';
                mapPresent = '<?= $mapPresent;?>';
                pieChartPresent = '<?= $pieChartPresent;?>';
                queryString = '<?php print_r( $_SESSION['queryString'] );?>';
                tableIds = '<?php echo json_encode($allTabs);?>';
                commonField = '<?= $commonField;?>';
                tableLinked = '<?php echo json_encode($mainArr);?> ';
                sessionsearchVarMulti =  '<?php echo json_encode($sessionsearchVarMulti); ?>';
                sessionSearch = '<?php echo ($sessionsearchVar); ?>';
                sessionSearchRange = '<?php echo $sessionsearchVarRange; ?>';
                sessionSort = <?php echo json_encode($sessionSort); ?>;
                pageName =<?php echo "'".$pageName."'";?>;
                pageId =<?php echo "'".$pageId."'";?>;
               
                //console.log(sessionSort);
               
                ShowTableData(url, Placeholder_ID, columnsUrl, placeholderId, tableTitle, searchValue, pannelIds,graphDiscription, mapPresent, pieChartPresent, pieDiscription , queryString , tableIds , commonField, tableLinked , mapDiscription , sessionSearch , sessionSearchRange , sessionSort ,sessionsearchVarMulti , pageName , pageId);
                
                // ShowTableData(url, Placeholder_ID, columnsUrl, placeholderId, tableTitle, searchValue, pannelIds,graphDiscription, mapPresent, pieChartPresent, pieDiscription , tableIds , commonField );           
            </script>
        <?php } else if ($type == 3 ) {
            // print_r($graphDiscription->1044); exit;
            // if(empty($graphDes->TableId)){
                $getGraphDataUrl = baseUrl . 'generateGraphData?id=' . $userPageAccessPlaceholderId . '&placeholderId=' . $selectedPlaceholderId;

                $getGraphDataUrl .= $filterationApplied;
            // }else{
            //     print_r("njkfdnjvkndjknvdf"); exit;
                $getGraphDataUrl = baseUrl . 'generateGraphDataHighChart?id=' . $userPageAccessPlaceholderId . '&placeholderId=' . $selectedPlaceholderId;
            //}
            // if (strpos($placeholderValue, 'GraphHC_') !== false) {
            //     $getGraphDataUrl = baseUrl . 'generateGraphDataHighChart?id=' . $userPageAccessPlaceholderId . '&placeholderId=' . $selectedPlaceholderId;
            // }
            ?>
            <script>
                url = '<?php echo $getGraphDataUrl;?>';
                Placeholder_ID = '<?php echo $placeholderValue;?>';
                graphDiscription = '<?= $graphDiscription;?>';
                graphDiscription = JSON.parse(graphDiscription);
                
                ShowGraphData(url, Placeholder_ID);
              
            </script>
            <?php } else if ($type == 4) { 

            $getMapDataUrl = baseUrl . 'generateMapData?id=' . $userPageAccessPlaceholderId . '&placeholderId=' . $selectedPlaceholderId;
            $getMapDataUrl .= $filterationApplied;

            ?>
            <script>
                url = '<?php echo $getMapDataUrl;?>';
                Placeholder_ID = '<?php echo $placeholderValue;?>'; 
                
                ShowMapData(url, Placeholder_ID);
            </script>

<?php }else if ($type == 5 && empty($pieDiscription)) { 

            $getPieChartUrl = baseUrl . 'generatePieChartData?id=' . $userPageAccessPlaceholderId . '&placeholderId=' . $selectedPlaceholderId;
            $getPieChartUrl .= $filterationApplied;

            ?>
            <script>
                url = '<?php echo $getPieChartUrl;?>';
                Placeholder_ID = '<?php echo $placeholderValue;?>'; 
                ShowPieChartData(url, Placeholder_ID);
            </script>

<?php }else if ($type == 7) { 

            $getSendOrderUrl = baseUrl . 'generateSendOrdersData?id=' . $userPageAccessPlaceholderId . '&placeholderId=' . $selectedPlaceholderId;
            $getSendOrderUrl .= $filterationApplied;
           

            ?>
            <script>
                url = '<?php echo $getSendOrderUrl;?>';
                Placeholder_ID = '<?php echo $placeholderValue;?>'; 
                ShowSendOrdersData(url, Placeholder_ID);
            </script>
<?php } else if ($type == 8) {
            
            $value = isset($_REQUEST['columnValue'])?$_REQUEST['columnValue']:'';
            $getDataUrl = baseUrl . 'generateReadTable?id=' . $userPageAccessPlaceholderId . '&placeholderId=' . $selectedPlaceholderId.'&ProductNo='.$value;
            $getColumnsUrl = baseUrl . 'getTableColumns?id=' . $userPageAccessPlaceholderId . '&placeholderId=' . $selectedPlaceholderId.'&Mtype=MongotableColumn'.'&ProductNo='.$value;
            $getDataUrl .= $filterationApplied;
            
            $tableTitle = '';
            $tableTitle = MongoTable::getMongotableByID($selectedPlaceholderId);
            $getPlaceholderDetails = Placeholder::getDataTableDescription($tableTitle[0]['RelatedDataTables']);
          
            if ($getPlaceholderDetails) {

                $tableTitle = (isset($getPlaceholderDetails[0]['Descriptions'])) ? $getPlaceholderDetails[0]['Descriptions'] : "";
                $tableTitle .= ' Extra Info';
            }
            ?>

            <script>
              
                url = '<?php echo $getDataUrl;?>';
                columnsUrl = '<?php echo $getColumnsUrl;?>';
                Placeholder_ID = '<?php echo $placeholderValue;?>';
                placeholderId = '<?= $selectedPlaceholderId;?>';
                tableTitle = '<?= $tableTitle;?>';
                searchValue = '<?= $searchValue;?>';
                pannelIds = '<?= $panelGraphIds;?>';
                graphDiscription = '<?= $graphDiscription;?>';
                pieDiscription='<?= $pieDiscription;?>';
                mapDiscription = '<?= $mapDiscription;?>';
                mapPresent = '<?= $mapPresent;?>';
                pieChartPresent = '<?= $pieChartPresent;?>';
                queryString = '<?php print_r( $_SESSION['queryString'] );?>';
                tableIds = '<?= $tableIds;?>';
                commonField = '<?= $commonField;?>';
                ShowTableData(url, Placeholder_ID, columnsUrl, placeholderId, tableTitle, searchValue, pannelIds,graphDiscription, mapPresent, pieChartPresent, pieDiscription , queryString , tableIds , commonField , mapDiscription);           
           
           </script>
<?php }}
}

?>
  <!-- Modal -->
<div class="modal fade" id="empModal" role="dialog">
    <div class="modal-dialog">
 
     <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
        
            </div>
            <div class="modal-footer">
           
            </div>
        </div>
    </div>
</div>

<!-- data tables -->
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/popper/popper.min.js"></script>

<!-- Boststrap -->
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/bootstrap/bootstrap-4.5.2/dist/js/bootstrap.min.js"></script>

<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/jquery-blockui/jquery.blockui.min.js"></script>

<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/counterup/jquery.waypoints.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/counterup/jquery.counterup.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-csv/0.71/jquery.csv-0.71.min.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/pages/sparkline/sparkline-data.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/app.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/layout.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/theme-color.js"></script>

<!-- Material new -->
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/material/material.min.js"></script>

<script type="text/javascript" src="<?php echo baseUrl;?>assets/Custome_Code/Other/js/getmdl-select.min.js"></script>
   
<!-- animation -->
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/pages/ui/animations.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/select2/js/select2.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/pages/select2/select2-init.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/pages/table/table_data.js"></script>

<!-- notifications new -->
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/jquery-toast/dist/jquery.toast.min.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/jquery-toast/dist/toast.js"></script>

<!-- animation -->
<script src="<?php echo baseUrl; ?>assets/Custome_Code/Other/js/common.js"></script>
<script src="<?php echo baseUrl;?>assets/Custome_Code/Other/js/jquery.fancybox.min.js"></script>
<link href="<?php echo baseUrl;?>assets/Custome_Code/Other/css/jquery.fancybox.min.css" rel="stylesheet" type="text/css" />

<!-- <script src="<?php echo baseUrl;?>assets/DataTables/Editor-1.9.4/css/editor.dataTables.min.css"></script>
    
<script src="<?php echo baseUrl;?>assets/DataTables/Select-1.3.1/css/select.dataTables.min.css"></script>
<script src="<?php echo baseUrl;?>assets/DataTables/Buttons-1.6.3/css/buttons.dataTables.min.css"></script> -->
   
<!-- <script > 
    var objects = new Array();
    objects = '<?php echo json_encode($customVariable);?>'; 

    console.log(window.location.href);

    $.each(JSON.parse(objects), function (key, value) {

        var pName = value['ParamName'].trim();
        var pValue = value['ParamValue'].trim();

        var regExp = new RegExp( '\\('+pName+'\\)',"g");
        document.body.innerHTML = document.body.innerHTML.replace(regExp, pValue);        
        

    });
</script> -->

<?php if(isset($_SESSION['syncFlag']) && $_SESSION['syncFlag'] == '1'){?>
 <script type="text/javascript">
        
        var time = "<?php echo $_SESSION['syncTime']; ?>"
        setTimeout(function(){
            location.reload(); }, time);
</script>

<?php }?>
 <script>
        baseUrl = '<?php echo baseUrl;?>';
        (function($) {
    var defaults={
        sm : 540,
        md : 720,
        lg : 960,
        xl : 1140,
        navbar_expand: 'lg'
    };
    $.fn.bootnavbar = function() {

        var screen_width = $(document).width();

        if(screen_width >= defaults.lg){
            $(this).find('.dropdown').hover(function() {
                $(this).addClass('show');
                $(this).find('.dropdown-menu').first().addClass('show').addClass('animated fadeIn').one('animationend oAnimationEnd mozAnimationEnd webkitAnimationEnd', function () {
                    $(this).removeClass('animated fadeIn');
                });
            }, function() {
                $(this).removeClass('show');
                $(this).find('.dropdown-menu').first().removeClass('show');
            });
        }

        $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
          if (!$(this).next().hasClass('show')) {
            $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
          }
          var $subMenu = $(this).next(".dropdown-menu");
          $subMenu.toggleClass('show');

          $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
            $('.dropdown-submenu .show').removeClass("show");
          });

          return false;
        });
    };
})(jQuery);
$(document).ready(function() {
    
    var curPage = decodeURIComponent($(location).attr('href')).split('page_text=');
    $( ".mr-auto .nav-item" ).each( function() {
        if(curPage[1] == $.trim($( this ).text())){
           $( this ).addClass( "active" );
        }
        
    });

});

    </script>

</body>
</html>