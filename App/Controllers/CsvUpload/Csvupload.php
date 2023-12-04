<?php

namespace App\Controllers\CsvUpload;

use \Core\View;
use \App\Models\User;
use \App\Models\Companies;
use \App\Models\Page;
/**
 * Csvupload controller
 *
 * PHP version 7.0
 */
// this file is actually called as an Ajax request when we try to upload an csv or to Perform an Crud oprertion on Edit Able Table .
// the main function has 2 main parts one for uploading the data on NO sql (MONGODB ) and other part for RDB .
class Csvupload extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */

   
    //This function is called as ajax request when the csv is Uploaded and it save it in DB
    static public function csvUploadAction()
    {
      
       
       // ini_set('max_input_vars', '20000' );
       
        $placeholderId = (isset($_REQUEST['placeholderId'])) ? $_REQUEST['placeholderId'] : "";

        $getPlaceholderDetails1= Page::getDatasourceTableDetails($placeholderId);

        
        if($getPlaceholderDetails1[0]['DBName'] != '' || $getPlaceholderDetails1[0]['AllowCustomTable'] == '1' || $getPlaceholderDetails1[0]['EnableDefaultCrudCSV'] == '1' ||  $getPlaceholderDetails1[0]['EnableCrudCSV'] == '1'){ // condition that check if that Table is allowed to upload the csv .

            if(!empty($getPlaceholderDetails1[0]['DBType']))
            {
                $_SESSION['dataSourceDbType'] = $getPlaceholderDetails1[0]['DBType'];
            }
            if($getPlaceholderDetails1[0]['SourceAddress'])
            {
                $table = explode('FROM', $getPlaceholderDetails1[0]['SourceAddress']);
            }

            // this part of code is for MongoDB DB .
            if($getPlaceholderDetails1[0]['DBType'] == 'mongodb')
            {
                if($_POST['action'] == 'create' )
                    { // part to Create a new entry in MONGODB .
                        $doc=[];
                        
                        foreach ($_POST['data']  as $key => $value) { 
                                foreach ($value as $Colkey => $Colvalue) {
                                    $doc[$key][$Colkey] = $Colvalue;
                                }
                        }
                        
                        $retrunVal = User::AddQueryMongo($table[0], $doc , $_POST['action']);
                        //print_r(json_encode($retrunVal));
                        return json_encode($retrunVal);
                        exit();

                    }else if( $_POST['action'] == 'edit')
                    { // part to edit an entry in DB 
                    
                        $doc=[];
                        
                        
                        if(isset($_POST['editcolumn']) &&  isset($_POST['editcolumname'])){
                            foreach ($_POST['data']['keyless']  as $key => $value) { 
                                
                                    $doc[$key] = $value;
                                    
                            } 
                            $retrunVal = User::AddQueryMongo($table[0], $doc , $_POST['action'] ,$_POST['editcolumname'] , $_POST['editcolumn'] ); 

                        }else if(count($_POST['data']) > 1 && !isset($_POST['data']['keyless']))
                        {   
                            $i = 0;
                            foreach ($_POST['data']  as $key => $value) { 
                                if(!empty($value['ID']))
                                {
                                    foreach ($value  as $colkey => $colvalue) { 
                                        $doc[$colkey] = $colvalue;
                                    }
                                    $retrunVal = User::AddQueryMongo($table[0], $doc , $_POST['action']);
                                }
                            }

                        }else{
                            foreach ($_POST['data']['keyless']  as $key => $value) { 
                                
                                    $doc[$key] = $value;
                                    
                            } 
                            $retrunVal = User::AddQueryMongo($table[0], $doc , $_POST['action']); 
                        } 
                        
                        print_r(json_encode($retrunVal));
                        return json_encode($retrunVal);
                        exit();

                    }else if($_POST['action'] == 'remove')
                    { // part to Delete all or specfic entry in DB

                        $rowId = $_GET['ID'];
                        if(strpos($rowId, ','))
                        {
                            $ids = explode(',', $rowId);
                            foreach ($ids as $key => $value) {
                                $retrunVal = User::AddQueryMongo($table[0], ['ID' => $value] , $_POST['action']);
                            }  
                        }else{
                            $retrunVal = User::AddQueryMongo($table[0], ['ID' => $rowId] , $_POST['action']);
                        }

                    
                        print_r(json_encode($retrunVal));
                        return json_encode($retrunVal);
                        exit();

                    }


            }else{ // this Part of is for rest of the rational database .
               
               
                if($_POST['action'] == 'create')
                {
                    $allIds = '';
                    $allIDNo = '';
                    $AllData = [];
                    $pay_type = ''; 
                    
                    if(isset($_POST['pay_type']) && $_POST['pay_type'] == 'Payment' ){
                        $pay_type = $_POST['pay_type'];
                        unset($_POST['action']);
                        unset($_POST['pay_type']);
                        foreach ($_POST as $key => $value) {
                            if(strpos($key , 'form')){
                                $ke = str_replace('form' , '', $key);
                                $_POST[$ke] = $value;
                                unset($_POST[$key]);
                            }
                        }
                        $tempData = $_POST;
                        unset($_POST);
                        $_POST['data'][0] = $tempData;
                    }

                    if(isset($_POST['fileUpload']) && $_POST['fileUpload'] == 'file' ){
                        $pay_type = $_POST['fileUpload'];
                        unset($_POST['action']);
                        unset($_POST['fileUpload']);
                        
                        
                        $CompanyId = $_SESSION['CompanyName'];
                        $username = explode('.' , $_SESSION['username']);
                        $_POST['CompanyId'] = $_SESSION['CompanyName'];
                        $_POST['CompanyUser'] = $_SESSION['username'];
                        
                        $absPath = 'http://212.247.32.103:8082/';
                        $dir = dirname( __FILE__ );
                        $dir = explode('Dev\BabcPortal', $dir);
                        $dir[0] = str_replace('\\', '/', $dir[0]);
                        
                        $CompanyDir = $dir[0].'API-IMG/'.trim($CompanyId).'/';
                        $CompanyUserDir = $dir[0].'API-IMG/'.trim($CompanyId).'/'. $username[0].'/';
                            
                        
                        if(!file_exists($CompanyDir))
                        {
                            mkdir($CompanyDir);
                        }
                        if(!file_exists($CompanyUserDir)){
                            mkdir($CompanyUserDir);
                        }
                        $CompanyUserDir = $CompanyUserDir . $_POST['FolderName'].'/';
                        if(!file_exists($CompanyUserDir)){
                            mkdir($CompanyUserDir);
                        }
                        $Imagepath= '';
                        if(!empty($_FILES)){
                            $Image=$_FILES['ImageUpload']['name']; 
                            $Imagepath= $CompanyUserDir.$Image;
                            $absPath = $absPath.'API-IMG/'.trim($CompanyId).'/'. $username[0].'/'. $_POST['FolderName'].'/'.$Image;
                            move_uploaded_file($_FILES["ImageUpload"]["tmp_name"],$Imagepath);
                        }
                        $_POST['ImagePath'] = $absPath;
                        $_POST['DateCreated'] = date('Y-m-d');

                        $tempData = $_POST;
                        unset($_POST);
                        $_POST['data'][0] = $tempData;
                    }
                     
                    if(isset($_GET['placeholderId'])){
                        $displayCol = " select Columns , DisplayColumnNames from Tables  where ID = '".$_GET['placeholderId']."'";
                        $Coltile = User::executeQuery($displayCol, 'BP_Admin10');
                        $Coltile1 = trim($Coltile[0]['Columns']);
                        $ColtileDisplay = trim($Coltile[0]['DisplayColumnNames']);
                        $dataKey =explode(',' ,$Coltile1);
                        $dataKeyOLD =array_keys($_POST['data'][0]);
                        $getPlaceholderDetails1[0]['Columns'] =   trim($Coltile[0]['Columns']);
                       
                    }
                    foreach ($_POST['data'] as $key => $value) { // check to remove all the null entries from the csv 
                        if(!array_filter($value)) {
                        
                            unset($_POST['data'][$key]);
                        }else{ //this part get all the  Artikelnr and ID to check if its already present in DB or not.
                            if(array_key_exists('Artikelnr', $_POST['data'][0]) && array_key_exists('Variantkod', $_POST['data'][0]) )
                            {
                                $allIds =  $allIds.", '".$value['Artikelnr']."'";
                                $allIDNo = $allIDNo.", '".$value['Variantkod']."'";
                            }else{
                                $allIds =  $allIds.", '".$value['ID']."'";
                            }
                           
                            if(trim($ColtileDisplay) != '' ) {
                               
                                foreach ($dataKey as $keyVal => $valueVal) {
                                  
                                    $_POST['data'][$key][$dataKey[$keyVal]] =  $_POST['data'][$key][$dataKeyOLD[$keyVal]]; 
                                    if(trim($dataKeyOLD[$keyVal]) != trim($dataKey[$keyVal]) ) {
                                        unset($_POST['data'][$key][$dataKeyOLD[$keyVal]]);
                                    }
                                }
                            }
                        }
                        
                        
                    }
                    //print_r( $_POST ); exit;
                    $allIds = trim($allIds , ',');
                    $allIDNo = trim($allIDNo , ',');
                    // Query to check if entry already exist in DB.
                    if(array_key_exists('Artikelnr', $_POST['data'][0]) &&  array_key_exists('Variantkod', $_POST['data'][0]))
                    {
                        $checkSql  = "Select * from " . $getPlaceholderDetails1[0]['customTable'].  " where Artikelnr IN (".$allIds.") and Variantkod IN (".$allIDNo.")";
                    
                    }else{
                        $checkSql  = "Select * from " . $getPlaceholderDetails1[0]['customTable'].  " where ID IN (".$allIds.")";
                    
                    }
                    
                    $getCompanyDetails = Companies::getCompaniesDetails($_SESSION['UserID']);
                    
                    if($getPlaceholderDetails1[0]['DBName']){
                        $userCompanyDbName =  $getPlaceholderDetails1[0]['DBName'];
                    if(isset($_SESSION['dataSourceDbType']))
                    {
                        unset($_SESSION['dataSourceDbType']);
                    }
                
                    }else if ($getPlaceholderDetails1[0]['AllowCustomTable'] == 1){
                        
                        $userCompanyDbName =  $getCompanyDetails[0]['CompanyBPDb'];
                    }else{
                            $userCompanyDbName =  $getCompanyDetails[0]['CompanyBABCDb'];
                    }
                    
                    
                    
                    $AllData = User::executeQuery($checkSql, $userCompanyDbName);
                    $rmvArray = []; 
                    if(isset($_POST['data'][0]['Övriga resekostn'])) {
                        foreach($_POST['data'] as $key => $valData){
                            $_POST['data'][$key]['Övriga resekostn. ex.moms'] = $_POST['data'][$key]['Övriga resekostn'][' ex']['moms'] ;
                            unset($_POST['data'][$key]['Övriga resekostn']);
                        }
                    }
                    
                    foreach ($AllData as $keys => $value) {
                        $key = '';
                        if(array_key_exists('Artikelnr', $_POST['data'][0]) && array_key_exists('Variantkod', $_POST['data'][0]))
                        {
                            foreach ($_POST['data'] as $key12 => $value12) {
                                if(isset($value12['Artikelnr']))
                                {
                                    if(trim($value['Artikelnr']) == trim($value12['Artikelnr']) && trim($value['Variantkod']) == trim($value12['Variantkod']) ){
                                        $key = $key12;
                                        break;
                                    }
                                }
                            }
                            $_POST['data'][$key]['ID'] = $AllData[$keys]['ID'];
                        
                        }else{
                            $key = array_search( $value['ID'], array_column($_POST['data'] , 'ID'));
                            $_POST['data'][$key]['ID'] = $AllData[$keys]['ID'];
                        
                        }
                        
                        $AllData[$keys] = $_POST['data'][$key];
                        $rmvArray[] = $key;
                        $_POST['data'] = array_values($_POST['data']);
                        
                    }
                    
                    foreach ($rmvArray as $rvmkey => $rvmvalue) {
                        unset($_POST['data'][$rvmvalue]);
                    }
                    
                    $retrunVal1 = 0;
                    
                    if(!empty($AllData)){ // This Part of code  is to update the csv entries that are already present in DB .
                        foreach ($AllData as $key1 => $value) {
                            $query = "Update  ".  $getPlaceholderDetails1[0]['customTable']  ." set ";
                            $tempQueryVal = '';
                            
                            foreach($value as $key => $val){
                                
                                if(trim($key) != 'ID'){
                                    
                                    if(strpos($key,' ') !== false || strpos($key,'/') !== false){
                                        $tempQueryVal .=  "[".$key."] = '".$val."' ,";
                                    }else{
                                        $tempQueryVal .=  $key." = '".$val."' ,";
                                    }
                                    
                                    
                                }
                            }
                            
                            $tempQueryVal = rtrim($tempQueryVal , ',');
                                
                            $id = $value['ID'];
                            $tempQueryVal .=  " WHERE  ID  = '".$id ."'";
    
                            $query = $query . trim($tempQueryVal);
                            
                            $retrunVal1 = User::AddQuery($query, $userCompanyDbName);

                        }
                        
                        $query = '';
                    }

                    $retrunVal = 0;
                    // This part of code will get all the new data that need to be inserted in database table.
                    if(!empty($_POST['data']))
                    {
                        
                        $column = explode(',', $getPlaceholderDetails1[0]['Columns']);
                        
                        foreach($column as $colK => $colV){
                            if($colV == 'ID'){
                                unset($column[$colK]);
                            }
                        }
                        $getPlaceholderDetails1[0]['Columns'] = implode(',', $column);
                        $column  = $getPlaceholderDetails1[0]['Columns'];
                        //$column  = str_replace('ID ,' , '' , $getPlaceholderDetails1[0]['Columns']);
                            $temoArr = explode("," , $column); 
                        
                        if(in_array('Övriga resekostn. ex.moms' , $temoArr)){
                            unset($temoArr[0]);
                            $column  = implode("," , $temoArr);
                            $tempCol = str_replace(',','],[' , $column);
                            $tempCol = "[".$tempCol."]";
                            $tempCol = str_replace('[ID ],',' ',  $tempCol);
                            
                            $column = $tempCol;
                        }
                        
                        
                        $query = "INSERT INTO ". $getPlaceholderDetails1[0]['customTable'] ." (".$column.") VALUES ";
                        $Columns = explode(',', $getPlaceholderDetails1[0]['Columns']);
                        
                        $tempQueryVal = '';
                    
                        foreach ($_POST['data'] as $key => $value) {
                        
                            $tempQueryVal =  $tempQueryVal.'(';
                            foreach ($Columns as $Colkey => $Colvalue) {
                                $Colvalue = trim($Colvalue);
                                
                                if($Colvalue != 'ID'){
                                        if(strpos($Colvalue,'.') !== false && $Colvalue != 'Övriga resekostn. ex.moms')
                                            {
                                                $val = explode('.', $Colvalue);
                                                foreach($val as $keyss => $vals){
                                                    $vals = trim($vals);
                                                    if($keyss == 0)
                                                    {
                                                        $colValue = $value[$vals];
                                                    
                                                    }
                                                    else{
                                                    
                                                        $colValue = $colValue[$vals];
                                                    }
                                                    
                                                }

                                                
                                                $tempQueryVal .= "'" .$colValue."' ,";
                                            }
                                        else{
                                                if(!isset($value[$Colvalue])){
                                                    $tempQueryVal .= "'" .''."' ,";
                                                }else{
                                                    $tempQueryVal .= "'" .$value[$Colvalue]."' ,";
                                                }
                                            
                                            }
                                }

                            }
                            
                                
                            $tempQueryVal = rtrim($tempQueryVal , ',');
                            $tempQueryVal .= '),';
                        }
                    
                            
                        
                        $query = str_replace('(ID ,' , '(', $query);
                        
                        //$query =preg_replace('/ID ,/', '', $query, 1);
                        $query = $query . rtrim($tempQueryVal, ',');
                        //print_r($query); exit;
                        $retrunVal = User::AddQuery($query, $userCompanyDbName); // Excute the query here 
                    }
                    if( $retrunVal1 == 1)
                    {
                        $retrunVal = 1;
                    }
                    if($pay_type == 'Payment' ||  $pay_type == 'fileUpload'){
                        header('Location: ' . $_SERVER['HTTP_REFERER']);
                    }
                    print_r(json_encode($retrunVal));
                    return json_encode($retrunVal);
                    exit();
                }else if($_POST['action'] == 'edit')
                { // Update that record in DB 
                    $pay_type = '';
                    if(isset($_POST['pay_type']) && $_POST['pay_type'] == 'Payment' ){
                        $pay_type = $_POST['pay_type'];
                        unset($_POST['action']);
                        unset($_POST['pay_type']);
                        foreach ($_POST as $key => $value) {
                            if(strpos($key , 'form')){
                                $ke = str_replace('form' , '', $key);
                                $_POST[$ke] = $value;
                                unset($_POST[$key]);
                            }
                        }
                        $tempData = $_POST;
                        unset($_POST);
                        $_POST['data']['keyless'] = $tempData;

                    }
                    
                    $query = "Update  ".  $getPlaceholderDetails1[0]['customTable']  ." set "; // SQL Query 
                    $tempQueryVal = '';

                    //Loop to get all the data from POST request that need to be updated.
                    foreach ($_POST['data']['keyless'] as $key => $value) {
                        if($key != 'ID')
                            $tempQueryVal .=  $key." = '".$value."' ,";
                    }

                    $tempQueryVal = rtrim($tempQueryVal , ',');
                        
                    $id = $_POST["data"]['keyless']['ID'];
                    $tempQueryVal .=  " WHERE  ID  = '".$id ."'";

                    $query = $query . trim($tempQueryVal);
                        // get the Compoany name to get all the info regarding it .
                    $getCompanyDetails = Companies::getCompaniesDetails($_SESSION['UserID']);
                    // this part get the DB name on which that database Table is present .
                    if($getPlaceholderDetails1[0]['DBName']){
                        $userCompanyDbName =  $getPlaceholderDetails1[0]['DBName'];
                    if(isset($_SESSION['dataSourceDbType']))
                    {
                        unset($_SESSION['dataSourceDbType']);
                    }
                
                    }else if ($getPlaceholderDetails1[0]['AllowCustomTable'] == 1){
                        
                        $userCompanyDbName =  $getCompanyDetails[0]['CompanyBPDb'];
                    }else{
                            $userCompanyDbName =  $getCompanyDetails[0]['CompanyBABCDb'];
                    }
                
                    $retrunVal = User::AddQuery($query, $userCompanyDbName);
                    if($pay_type == 'Payment'){
                        header('Location: ' . $_SERVER['HTTP_REFERER']);
                    }
                    print_r(json_encode($retrunVal));
                    return json_encode($retrunVal);
                    exit();

                }else if($_POST['action'] == 'remove')
                { // delete from DB part 
                    $rowId = $_GET['ID']; // get that row ID .


                    if($rowId == 'all'){ // allow to delete All the rows from the DB
                        $query = "DELETE from " . $getPlaceholderDetails1[0]['customTable'] ;
                    }else{ // allow to delete  specfic  rows from the DB
                        $query = "DELETE from " .  $getPlaceholderDetails1[0]['customTable'] ." where ID in (".$rowId.")" ;
                            
                    
                    }
                    // get the Compoany name to get all the info regarding it .
                    $getCompanyDetails = Companies::getCompaniesDetails($_SESSION['UserID']);
                    
                    // this part get the DB name on which that database Table is present .
                    if($getPlaceholderDetails1[0]['DBName']){
                            $userCompanyDbName =  $getPlaceholderDetails1[0]['DBName'];
                            if(isset($_SESSION['dataSourceDbType']))
                            {
                                unset($_SESSION['dataSourceDbType']);
                            }
                
                    }else if ($getPlaceholderDetails1[0]['AllowCustomTable'] == 1){
                        
                        $userCompanyDbName =  $getCompanyDetails[0]['CompanyBPDb'];
                    }else{
                            $userCompanyDbName =  $getCompanyDetails[0]['CompanyBABCDb'];
                    }

                    $retrunVal = User::AddQuery($query, $userCompanyDbName);
                    print_r(json_encode($retrunVal));
                    return json_encode($retrunVal);
                    exit();
                } 
            }
        }

        return 0;
        exit;
    }

    
}
