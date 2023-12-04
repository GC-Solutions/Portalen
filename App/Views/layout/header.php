<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->
<head>

<!-- Global site tag (gtag.js) - Google Analytics - Disabled for now
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-158640351-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-158640351-1');
</script>-->

<meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="" content="" />
    <title>GC Solutions AB | BABC PORTAL</title>
   
   <link rel="stylesheet" type="text/css" href="<?php echo baseUrl;?>assets/DataTables/datatables.min.css"/>
   <link href="<?php echo baseUrl;?>assets/Theme/assets/plugins/bootstrap/bootstrap-4.5.2/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script> 
<link href="<?php echo baseUrl;?>assets/Theme/assets/plugins/bootstrap/bootstrap-4.5.2/dist/js/bootstrap.min.js" rel="stylesheet" type="text/js" />
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>


   <!-- <script src="<?php echo baseUrl;?>assets/Theme/assets/plugins/jquery/jquery.min.js" type="text/javascript"> </script>
    -->
   <script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/counterup/jquery.waypoints.js"></script>
   <script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/counterup/jquery.counterup.min.js"></script>
   <script src="<?php echo baseUrl; ?>assets/DataTables/datatables.min.js" ></script>
    <!-- Side Bar Table -->
   <script src="<?php echo baseUrl; ?>assets/Theme/assets/js/sidebar.js"></script>

    <!-- google font -->
   <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet"> 
   
   <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
   <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
   <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-components-web/4.0.0/material-components-web.min.css">
   <link rel="stylesheet" href=" https://cdn.datatables.net/1.10.22/css/dataTables.material.min.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  
   <!-- <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.dataTables.min.css">
   <script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script> -->

   <!-- <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js">
   <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.4/js/dataTables.fixedHeader.min.js"> -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   
   

        
    <!-- icons -->
   <link href="<?php echo baseUrl;?>assets/Theme/assets/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
   <link href="<?php echo baseUrl;?>assets/Theme/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
   
   <!--bootstrap -->
   <link href="<?php echo baseUrl;?>assets/Theme/assets/plugins/bootstrap/bootstrap-4.5.2/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  
   <!-- <link href="<?php echo baseUrl;?>assets/Theme/assets/plugins/bootstrap/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    -->
   <link href="<?php echo baseUrl;?>assets/Theme/assets/plugins/bootstrap/bootstrap-4.5.2/dist/js/bootstrap.min.js" rel="stylesheet" type="text/js" />
   
   <!-- <link href="<?php echo baseUrl;?>assets//Theme/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen"> -->

   <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script> -->



<script type='text/javascript'>

var date = new Date();
date.setDate(date.getDate() + 15);

		$( document ).ready(function() {
			$('#datetimepicker3').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                
            });
            $('#datetimepicker2').datetimepicker({
                format: 'YYYY-MM-DD',
                minDate: date
            });
            $('#datetimepicker1').datetimepicker({format: 'YYYY-MM-DD'});
		});
</script>

   <!--? -->
   <link href="<?php echo baseUrl;?>assets/Theme/assets/plugins/summernote/summernote.css" rel="stylesheet">
   <link href="<?php echo baseUrl;?>assets/Theme/assets/plugins/select2/css/select2.css" rel="stylesheet" type="text/css" />
   <link href="<?php echo baseUrl;?>assets/Theme/assets/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

    <!-- morris chart -->
   <link href="<?php echo baseUrl;?>assets/Theme/assets/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
   
   <!-- animation -->
   <link href="<?php echo baseUrl;?>assets/Theme/assets/css/pages/animate_page.css" rel="stylesheet">
   <link rel="stylesheet" href="<?php echo baseUrl;?>assets/Theme/assets/plugins/jquery-toast/dist/jquery.toast.min.css">
   <link rel="stylesheet" href="<?php echo baseUrl;?>assets/Theme/assets/plugins/sweet-alert/sweetalert.min.css">
   
   
   <!-- Template Styles -->
   <link href="<?php echo baseUrl;?>assets/Theme/assets/css/plugins.min.css" rel="stylesheet" type="text/css" />

   <?php 
    $pageName = isset($_REQUEST['page_text'])?$_REQUEST['page_text']:'0';
   
    if($pageName !== '0'  && (isset($_SESSION['EnableFixedLeftColumn'][$pageName]) && $_SESSION['EnableFixedLeftColumn'][$pageName] == '1')){  ?>
    <link href="<?php echo baseUrl;?>assets/Theme/assets/css/style_old.css" rel="stylesheet" type="text/css" />
   
   <?php  } else{  ?>
    <link href="<?php echo baseUrl;?>assets/Theme/assets/css/style_new.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo baseUrl;?>assets/Theme/assets/css/fixed_column.css" rel="stylesheet" type="text/css" />
     
  <?php  } ?>
   
   <link href="<?php echo baseUrl;?>assets/Theme/assets/css/responsive.css" rel="stylesheet" type="text/css" />
   <link href="<?php echo baseUrl;?>assets/Theme/assets/css/theme-color.css" rel="stylesheet" type="text/css" />
   <link href="<?php echo baseUrl;?>assets/Theme/assets/css/sidebar.css" rel="stylesheet" type="text/css" />
   <link href="<?php echo baseUrl;?>assets/Theme/assets/css/pages/inbox.min.css" rel="stylesheet" type="text/css" />
   <link href="<?php echo baseUrl;?>assets/Theme/assets/css/dataTable.css" rel="stylesheet" type="text/css" />
   <link href="<?php echo baseUrl;?>assets/Theme/assets/css/tablet-dropdown.css" rel="stylesheet" type="text/css" />


   <!-- favicon -->
   <link rel="shortcut icon" href="<?php echo baseUrl;?>assets/Theme/assets/img/favicon.ico" />
   
    <!-- Material Design Lite CSS -->
   <link rel="stylesheet" href="<?php echo baseUrl;?>assets/Theme/assets/plugins/material/material.min.css">
   <link rel="stylesheet" href="<?php echo baseUrl;?>assets/Theme/assets/css/material_style.css">
   <!-- <script src="<?php echo baseUrl;?>assets/Theme/assets/plugins/material/material.min.js"></script> -->
   <link rel="stylesheet" href="<?php echo baseUrl;?>assets/Theme/assets/css/getmdl-select.min.css">
 <!-- Custom Css -->
   <link rel="stylesheet" href="<?php echo baseUrl;?>assets/Custome_Code/Other/css/custom.css">

  <!-- Highsoft Highcharts -->
   <script src="<?php echo baseUrl;?>assets/Highsoft/Highcharts-8.2.0/code/highcharts.js"></script>
   <script src="<?php echo baseUrl;?>assets/Highsoft/Highcharts-8.2.0/code/modules/series-label.js"></script>
   <script src="<?php echo baseUrl;?>assets/Highsoft/Highcharts-8.2.0/code/modules/exporting.js"></script>
   <script src="<?php echo baseUrl;?>assets/Highsoft/Highcharts-8.2.0/code/modules/series-label.js"></script>
   <script src="<?php echo baseUrl;?>assets/Highsoft/Highcharts-8.2.0/code/modules/export-data.js"></script>
   <script src="<?php echo baseUrl;?>assets/Highsoft/Highcharts-8.2.0/code/highcharts-3d.js"></script>
   <script src="<?php echo baseUrl;?>assets/Highsoft/Highcharts-8.2.0/code/modules/boost.js"></script>
   <script src="<?php echo baseUrl;?>assets/Highsoft/Highcharts-8.2.0/code/modules/data.js"></script>
   <script src="<?php echo baseUrl;?>assets/Highsoft/Highcharts-8.2.0/code/modules/drilldown.js"></script>
   <script src="<?php echo baseUrl;?>assets/Highsoft/Highcharts-8.2.0/code/modules/accessibility.js"></script>
   <script src="<?php echo baseUrl;?>assets/Highsoft/Highcharts-8.2.0/code/modules/sunburst.js"></script>

<!-- Highsoft Highmaps -->
   <script src="<?php echo baseUrl;?>assets/Highsoft/Highcharts-Maps-8.2.0/code/modules/map.js"></script>
   <script src="<?php echo baseUrl;?>assets/Highsoft/Highcharts-Maps-8.2.0/code/modules/data.js"></script>
   <script src="<?php echo baseUrl;?>assets/Highsoft/Highcharts-Maps-8.2.0/code/modules/exporting.js"></script>
   <script src="<?php echo baseUrl;?>assets/Highsoft/Highcharts-Maps-8.2.0/code/modules/offline-exporting.js"></script>
   <script src="<?php echo baseUrl;?>assets/Highsoft/Highcharts-Maps-8.2.0/code/modules/offline-exporting.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/4.6.3/papaparse.min.js"></script>
    <script src="<?php echo baseUrl;?>assets/DataTables/Editor-1.9.4/js/dataTables.editor.min.js"></script>
     <script src="<?php echo baseUrl;?>assets/DataTables/Editor-1.9.4/js/dataTables.editor.min.js"></script>
    <script src="<?php echo baseUrl;?>assets/DataTables/Editor-1.9.4/js/editor.bootstrap4.min.js"></script>
 
   <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.6/proj4.js"></script>
   <script src="https://code.highcharts.com/mapdata/countries/se/se-all.js"></script>
  
    <script src="https://code.highcharts.com/mapdata/index.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
    <script src="https://www.highcharts.com/samples/static/jquery.combobox.js"></script>
    <script src="<?php echo baseUrl;?>assets/DataTables/Select-1.3.1/js/dataTables.select.min.js"></script>

    <script src="<?php echo baseUrl;?>assets/DataTables/Buttons-1.6.3/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo baseUrl;?>assets/DataTables/Buttons-1.6.3/js/buttons.html5.min.js"></script>
    <script src="<?php echo baseUrl;?>assets/DataTables/Buttons-1.6.3/js/buttons.print.min.js"></script>
    

  <!-- Other Scripts needs to get chnages to local later -->
   <script type="text/javascript" src="https://www.google.com/jsapi"></script>
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   <script src="https://code.highcharts.com/mapdata/custom/world.js"></script>
   <script src="https://blacklabel.github.io/custom_events/js/customEvents.js"></script>
   <script scr="https://cdn.datatables.net/rowgroup/1.1.1/js/dataTables.rowGroup.min.js"></script>
   <script scr=" https://cdn.datatables.net/colreorder/1.5.2/js/dataTables.colReorder.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
   <!-- <script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css"></script> -->
   <script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>

