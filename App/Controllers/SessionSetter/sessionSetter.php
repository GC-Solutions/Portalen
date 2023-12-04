<?php

namespace App\Controllers\SessionSetter;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use \App\Models\Companies;
use App\Models\Placeholder;
use App\Controllers\DataFormatHelper\DataTableHelper;


/**
 * DataTables controller
 *
 * PHP version 7.0
 */
// this File is used when we have set the row group for a DataTable . it basiclly set/get the session that remember the pervious state of the sort .
class sessionSetter extends \Core\Controller
{
    function setSession(){
      
       $_SESSION['rowGroupSort'] = $_POST['data'];
       print_r( $_SESSION['rowGroupSort']);
       exit;
    }
    function setSessionFilter(){
      
      $_SESSION['removeSession'] = 1;
      //$_SESSION['PervPath'] = $_REQUEST['path'];
      print_r( $_SESSION['removeSession']);
      exit;
   }
   function getSession(){
      
        //$_SESSION['rowGroupSort'] = $_POST['data'];
        echo isset($_SESSION['rowGroupSort'])?$_SESSION['rowGroupSort']:'';
        exit;
   }
   function SaveFilterSession(){
      
      $_SESSION['TicketFilterId'] = isset($_POST['data'])?(implode(',', $_POST['data'])):'';
      print_r( $_SESSION['TicketFilterId']);
      exit;
      
   }
}