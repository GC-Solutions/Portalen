<?php
use \App\Models\Placeholder;
use App\Controllers\PanelAndDataTables;
use \App\Models\MongoTable;
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

if (!empty($_REQUEST['columnName']) && !empty($_REQUEST['columnValue'])) {
    $filterationApplied .= '&';
    $filterationApplied .= $_REQUEST['columnName'] . '=' . $_REQUEST['columnValue'];

    //$filterationApplied .= '&columnName=' . $_REQUEST['columnName'] . '&columnValue=' . $_REQUEST['columnValue'];
}
if (!empty($_REQUEST['columnName']) && !empty($_REQUEST['columnValue'])) {

    $_SESSION['queryString']  = '&columnName=' . $_REQUEST['columnName'] . '&columnValue=' . $_REQUEST['columnValue'];
}
 
?>

<!-- Custome_Code -->
<script src="<?php echo baseUrl; ?>assets/Custome_Code/DataTables/customDataTables.js"></script>
<script src="<?php echo baseUrl; ?>assets/Custome_Code/Panels/customPanel.js"></script>
<script src="<?php echo baseUrl; ?>assets/Custome_Code/Highsofts/customHighCharts.js"></script>
<script src="<?php echo baseUrl; ?>assets/Custome_Code/Highsofts/customHighPieCharts.js"></script>
<script src="<?php echo baseUrl; ?>assets/Custome_Code/Highsofts/customHighMaps.js"></script>
<script src="<?php echo baseUrl; ?>assets/Custome_Code/DataTables/customSendordersTable.js"></script>


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

            $getDataUrl = baseUrl . 'generateTable?id=' . $userPageAccessPlaceholderId . '&placeholderId=' . $selectedPlaceholderId;
            $getColumnsUrl = baseUrl . 'getTableColumns?id=' . $userPageAccessPlaceholderId . '&placeholderId=' . $selectedPlaceholderId;
            $getDataUrl .= $filterationApplied;
            $getPlaceholderDetails = Placeholder::getDataTableDescription($selectedPlaceholderId);
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
                mapPresent = '<?= $mapPresent;?>';
                pieChartPresent = '<?= $pieChartPresent;?>';
                queryString = '<?php print_r( $_SESSION['queryString'] );?>';
                tableIds = '<?php echo json_encode($allTabs);?>';
                commonField = '<?= $commonField;?>';
                tableLinked = '<?php echo json_encode($mainArr);?> '; 

                ShowTableData(url, Placeholder_ID, columnsUrl, placeholderId, tableTitle, searchValue, pannelIds,graphDiscription, mapPresent, pieChartPresent, pieDiscription , queryString , tableIds , commonField, tableLinked);

              

                
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
                mapPresent = '<?= $mapPresent;?>';
                pieChartPresent = '<?= $pieChartPresent;?>';
                queryString = '<?php print_r( $_SESSION['queryString'] );?>';
                tableIds = '<?= $tableIds;?>';
                commonField = '<?= $commonField;?>';
                ShowTableData(url, Placeholder_ID, columnsUrl, placeholderId, tableTitle, searchValue, pannelIds,graphDiscription, mapPresent, pieChartPresent, pieDiscription , queryString , tableIds , commonField);           
            </script>
<?php }}
}
?>
<!-- data tables -->
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets//plugins/popper/popper.min.js"></script>

<!-- bootstrap -->
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/bootstrap/bootstrap-4.5.2/dist/js/bootstrap.min.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/jquery-blockui/jquery.blockui.min.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/counterup/jquery.waypoints.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/counterup/jquery.counterup.min.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/pages/sparkline/sparkline-data.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/app.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/layout.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/theme-color.js"></script>

<!-- animation -->
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/pages/ui/animations.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/select2/js/select2.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/pages/select2/select2-init.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/pages/table/table_data.js"></script>

<!-- animation -->
<script src="<?php echo baseUrl; ?>assets/Custome_Code/Other/js/common.js"></script>
<script src="<?php echo baseUrl;?>assets/Custome_Code/Other/js/jquery.fancybox.min.js"></script>
<link href="<?php echo baseUrl;?>assets/Custome_Code/Other/css/jquery.fancybox.min.css" rel="stylesheet" type="text/css" />
<script>
// var $input = $("select");
// $input.select2();
// $("ul.select2-selection__rendered").sortable({
//   containment: 'parent'
// });
</script>
<!-- <script > 
    var objects = new Array();
    objects = '<?php //echo json_encode($customVariable);?>'; 

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
    //$('.datepicker').datepicker();
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