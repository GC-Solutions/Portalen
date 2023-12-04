<!DOCTYPE html>

<html lang="en">
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="" content="" />
    <title>GC Solutions AB | BABC PORTAL</title>
   
<link rel="stylesheet" type="text/css" href="<?php echo baseUrl;?>assets/DataTables/datatables.min.css"/>

<script src="<?php echo baseUrl;?>assets/Theme/assets/plugins/jquery/jquery.min.js" type="text/javascript"> </script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/counterup/jquery.waypoints.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/counterup/jquery.counterup.min.js"></script>
<script src="<?php echo baseUrl; ?>assets/DataTables/datatables.min.js" ></script>

 <!-- google font -->
<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet"> 
                
 <!-- icons -->
<link href="<?php echo baseUrl;?>assets/Theme/assets/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo baseUrl;?>assets/Theme/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    

<!--bootstrap -->
<link href="<?php echo baseUrl;?>assets/Theme/assets/plugins/bootstrap/bootstrap-4.5.2/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo baseUrl;?>assets/Theme/assets/plugins/bootstrap/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet"  >
<link href="<?php echo baseUrl;?>assets/Theme/assets/plugins/bootstrap/bootstrap-4.5.2/dist/js/bootstrap.min.js"  type="text/js" />
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" ></script>
<!--? -->
<link href="<?php echo baseUrl;?>assets/Theme/assets/plugins/summernote/summernote.css" rel="stylesheet">
<link href="<?php echo baseUrl;?>assets/Theme/assets/plugins/select2/css/select2.css" rel="stylesheet" type="text/css" />
<link href="<?php echo baseUrl;?>assets/Theme/assets/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

    
<!-- morris chart -->
<link href="<?php echo baseUrl;?>assets/Theme/assets/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    
<!-- Material Design Lite CSS -->
<link rel="stylesheet" href="<?php echo baseUrl;?>assets/Theme/assets/plugins/material/material.min.css">
<link rel="stylesheet" href="<?php echo baseUrl;?>assets/Theme/assets/css/material_style.css">

<!-- animation -->
<link href="<?php echo baseUrl;?>assets/Theme/assets/css/pages/animate_page.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo baseUrl;?>assets/Theme/assets/plugins/sweet-alert/sweetalert.min.css">

<!-- Template Styles -->
<link href="<?php echo baseUrl;?>assets/Theme/assets/css/plugins.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo baseUrl;?>assets/Theme/assets/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo baseUrl;?>assets/Theme/assets/css/responsive.css" rel="stylesheet" type="text/css" />
<link href="<?php echo baseUrl;?>assets/Theme/assets/css/theme-color.css" rel="stylesheet" type="text/css" />

 <!-- favicon -->
 <link rel="shortcut icon" href="<?php echo baseUrl;?>assets/Theme/assets/img/favicon.ico" />

 <!-- Custom Css -->
 <link rel="stylesheet" href="<?php echo baseUrl;?>assets/Custome_Code/Other/css/custom.css">

<!-- Other Scripts needs to get chnages to local later -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://code.highcharts.com/mapdata/custom/world.js"></script>
<script src="https://blacklabel.github.io/custom_events/js/customEvents.js"></script>
<script scr="https://cdn.datatables.net/rowgroup/1.1.1/js/dataTables.rowGroup.min.js"></script>
<script scr=" https://cdn.datatables.net/colreorder/1.5.2/js/dataTables.colReorder.min.js"></script>

<link rel="stylesheet" href="<?php echo baseUrl;?>assets/Custome_Code/Other/css/dropzone.css">
<script src="<?php echo baseUrl;?>assets/Custome_Code/Other/js/dropzone.js"></script>
<script type='text/javascript'>
var date = new Date();
date.setDate(date.getDate() + 15);
var mindate = date.getFullYear()+'-'+date.getMonth()+'-'+ date.getDate();
		$( document ).ready(function() {
			$('#datetimepicker1').datetimepicker(
                {
                    autoclose: true,
                    dateFormat: 'yy-mm-dd',
                }
            );
            $('#datetimepicker2').datetimepicker(
                {
                    autoclose: true,
                    changeYear: true,
                    changeMonth: true,
                    minDate: mindate,
                    dateFormat: "yy-m-dd",
                    yearRange: "-100:+20",
                }
            );
            $('#datetimepicker3').datetimepicker(
                {
                    autoclose: true,
                    dateFormat: 'yyyy-mm-dd',
                }
            );
		});
	</script>
    
<style>
    .dataTables_filter input{
        display: block;
        width: 100%;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        outline: 0!important;
        box-shadow: none!important;
    }
    .dataTables_wrapper button{
        background-color: #2CA8FF !important;
        border: 1px solid #2CA8FF !important;
        color: #fff !important;
        font-size: 12px;
        transition: box-shadow .28s cubic-bezier(.4, 0, .2, 1);
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        -ms-border-radius: 2px;
        -o-border-radius: 2px;
        border-radius: 2px;
        overflow: hidden;
        position: relative;
        padding: 8px 14px 7px;
        margin: 0px 5px;
    }
    .dataTables_info{
        float: center;
        display: inline-block;
         background-color: #ffffff !important;
        border: 0px solid #2CA8FF !important;
        color: #000000 !important;
        font-size: 12px;
        transition: box-shadow .28s cubic-bezier(.4, 0, .2, 1);
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        -ms-border-radius: 2px;
        -o-border-radius: 2px;
        border-radius: 2px;
        /*overflow: hidden;*/
        position: relative;
        /*padding: 8px 14px 7px;*/
        margin: 0px 5px;

    }
    .dataTables_paginate{
        float: right;
        display: inline-block;
    }
    td a.tableButtons {
        margin: 2px 0px;
    }
    tfoot {
        display: table-header-group;
    }
</style>

</head>
<!-- END HEAD -->
<body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white white-sidebar-color logo-white">
	