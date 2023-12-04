<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use \lyquidity\xbrl_validate\PhpOffice\PhpSpreadsheet\Groups;
use \lyquidity\xbrl_validate\PhpOffice\PhpSpreadsheet\Group;
use \lyquidity\xbrl_validate\PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use PDO;

class PivotTable extends \Core\Controller
{
    public static  function  GenerateExcelPivotTable()
    {
        //ini_set('max_input_vars', 3000000000000000);
        
         // Set the number of seconds a script is allowed to run to infinity 
         set_time_limit(0);
         // Memory Limit for the script 
         ini_set('memory_limit', '10G');
        $EntryData = json_decode($_REQUEST['data'] );
        if(isset($_REQUEST['data']) && $EntryData != ""){
            
            if(strpos(dirname(__DIR__) , '/App/Controllers') !== false){
                $dir = explode('/App/Controllers',dirname(__DIR__));
                $dir = $dir[0];
            }else{
                $dir = explode('\App\Controllers',dirname(__DIR__));
                $dir = $dir[0];
            }
            
            if ( file_exists(  $dir . '/vendor/pivottable/vendor/autoload.php' ) )
            {
                require_once (  $dir . '/vendor/pivottable/vendor/autoload.php');
                
            }
            else
            {
                
                echo ("Unable to autoload classes");
            }
            
            $files = get_included_files();
            $bootstrap = realpath(  $dir. '/vendor/pivottable/phpspreadsheet/Spreadsheet.php' );
            
            if ( !in_array( $bootstrap, $files ) )
            {
                
                require_once ($dir. '/vendor/pivottable/phpspreadsheet/Spreadsheet.php');
                
            }
            
                $outputFileName = $dir . '/vendor/pivottable/examples/generated.xlsx';

                $spreadsheet = new Spreadsheet();
                
                $spreadsheet->getProperties()
                    ->setCreator("XBRL Query Generator")
                    ->setLastModifiedBy("XBRL Query Generator")
                    ->setTitle("Microsoft 2018 QK")
                    ->setSubject("Pivot table report")
                    ->setDescription("This could be an explanation")
                    ->setKeywords("xbrl microsoft 2018 10k")
                    ->setCategory("Reports");


                $DataWithKeys = [];
                $mainPageData = [];
                $DataRecived = json_decode($_REQUEST['data'] , true);
                
                $columnName = $_REQUEST['columnName'];
                $firstKey = '';
                $firstKeyInt = '';
                $firstCol = 0;
                $lastCol = '';

                foreach($DataRecived as $keys => $values){
                    $temp = [];
                   
                    foreach($values as $key => $value){
                        if(count($columnName) > $key){
                            if($key == (count($columnName)-1)){
                        
                                $checkfotInt = strtr($value, array(","=>"", "."=>""));
                                $int = floatval($checkfotInt);
                             
                                if(is_float($int)){
                                    
                                    $temp[$columnName[$key]] = $int;
                                    
                                }else{
                                    $temp[$columnName[$key]] = $value;
                                }
                                if(strpos($value , '.') !== false  || strpos($value , ',') !== false){
                                    $value2 = strtr($value, array("."=>"", ","=>""));
                                    if(is_numeric( $value2 ) && $firstCol == ''){
                                        $firstCol = $key;
                                    }else if(is_numeric( $value2 )){
                                        $lastCol = $key;
                                        $firstKeyInt = $columnName[$key];
                                    }
    
                                }
                                $value2 = strtr($value, array("."=>"", ","=>"."));
                                
                                $temp2[$columnName[$key]] = $value2;
                            }else{
                              
                                if($firstKey == '' && is_string($value) ){
                                    $value = strtr($value, array("."=>"", ","=>"."));
                                    if(!is_numeric($value) && $value != '' ){
                                        $firstKey = $columnName[$key];
                                    }
                                }else if($firstKey != '' && is_string($value) && $value == '##' ){
                                    $firstKey = $columnName[$key+1];
                                }else{
                                    $value = strtr($value, array("."=>"", ","=>"."));
                                    if(is_numeric($value) && $value != '' ){
                                        $firstKeyInt = $columnName[$key];
                                    }
                                }
                                
                                $temp[$columnName[$key]] = rtrim($value);
                                
                                if(strpos($value , '.') !== false  || strpos($value , ',') !== false){
                                    $value2 = strtr($value, array("."=>"", ","=>""));
                                    if(is_numeric($value2 ) && $firstCol == ''){
                                        $firstCol = $key;
                                    }else if(is_numeric( $value2 )){
                                        $lastCol = $key;
                                    }
    
                                }
                                $value2 = strtr($value, array("."=>"", ","=>"."));
                                
                                if(is_numeric($value2) && (strpos($value , '.') !== false)){
                                    $value2 = number_format( (float)$value, 2, '.', '');
    
                                }
                                $temp2[$columnName[$key]] =($value);
                            }
                        }
                       
                        
                    }
                   
                    $DataWithKeys[] = $temp;
                    $mainPageData[] = $temp2;
                }
                
               // $data =    $DataWithKeys;
                $data = $mainPageData;
               
                if((count($DataRecived[0]) == count($columnName)) &&  $firstKey == ''){
                    $firstKey = $columnName[0];
                }
                if((count($DataRecived[0]) == count($columnName)) &&  $firstKeyInt == ''){
                    $cntName = count($columnName)-2;
                    $firstKeyInt = $columnName[$cntName];
                }

                $networks = array(
                    
                        array(	'data' => $data,
                        'args' => array(
                            "Worksheet1",
                            2 + count( $data ) + 1 + 3, 2,
                            new Groups( new Group( $firstKey ) ),
                            new Groups( ),
                            new Groups( array($firstKeyInt) )
                        )
                    ),
                
                );
                $arrayData = $mainPageData; 
               
                $arrayTitle = $columnName;
                //For title 
                $spreadsheet->getActiveSheet()->fromArray(
                    $arrayTitle,  // The data to set
                    NULL ,     // Array values with this value will not be set
                    'A1'); 

               // $alphabet = range('A', 'Z');
                //$alphabet2 = range('AA', 'ZZ');
                $max = 41; 
                for ($l = 'A', $i = 0; $i < $max; $l++, $i++) {
                    $alphabet[] = $l;
                }
                
               
                $fcol = $alphabet[$firstCol];
                $fcol = $fcol.'2';

                if( $lastCol == ''){
                    $lastCol = $firstCol;
                }
                
                $lastcol = $alphabet[$lastCol];
                $lastcol = $lastcol.count($arrayData);
                $lastColINdex = count($arrayTitle);
               
                $spreadsheet->getActiveSheet()->getStyle("{$fcol}:{$lastcol}")
                ->getNumberFormat()
                ->setFormatCode('0.00');
               
                foreach (range('A',  $alphabet[$lastColINdex]) as $col) {
                    $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                   
                }
               
                // For Data
                $spreadsheet->getActiveSheet()->fromArray(
                        $arrayData,  // The data to set
                        NULL ,     // Array values with this value will not be set
                        'A2'); 

                
                
                foreach ( $networks as $index => $network )
                {
                    $range = $spreadsheet->addData( $data, $network['args'][0] );
                    $spreadsheet->addNewPivotTable( $data, $range, ...$network['args'] );
                    
                }

                
                $writer = IOFactory::createWriter( $spreadsheet, 'Xlsx' );
                ob_start();
                // Write file to the browser
                //$writer->save($outputFileName);
                $writer->save('php://output');
                $xlsData = ob_get_contents();
                ob_end_clean();
                
                $response =  array(
                        'op' => 'ok',
                        'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($xlsData)
                    );

                die(json_encode($response));
                
            
                $spreadsheet->disconnectWorksheets();
                unset( $spreadsheet );
                exit;
        }else{
            $response =  array(
                'op' => 'NoData'
            );
            die(json_encode($response));
        }
      
    }
	
	
	// Save excel 
    public  function SaveExcel(){
         // Set the number of seconds a script is allowed to run to infinity 
          set_time_limit(0);
         // Memory Limit for the script 
        ini_set('memory_limit', '200G');
		if(isset($_REQUEST['id'])){
			$excelFileRef = $this->saveExcelExportDb($_REQUEST['id'], "progressing");
			if(strpos(dirname(__DIR__) , '/App/Controllers') !== false){
                $dir = explode('/App/Controllers',dirname(__DIR__));
                $dir = $dir[0];
            }else{
                $dir = explode('\App\Controllers',dirname(__DIR__));
                $dir = $dir[0];
            }
			if(isset($_REQUEST['close']) && $_REQUEST['close'] == 'false'){
				$location = $this->saveExcelExportChunk($_REQUEST['id'], $_REQUEST['part_number'], $dir, json_decode($_REQUEST['data'], true), false);
				die("Your file is being written, please wait! we at: " . $location);
			}else {
				// end writing data
				$filepath = $dir . '/public/assets/excel_files/' . $_REQUEST['id'].'_columns'. '.json';
				$location = $this->saveExcelExportChunk($_REQUEST['id'], '0000', $dir, $_REQUEST['columnName'], true);
				$this->saveExcelCompleteCall($_REQUEST['id'], "saved");
				$response =  array(
                    'op' => 'ok',
					'location' => $location
                );
				die(json_encode($response)); 

			}
		}

    }
	
	public  function getExcelExportFileById($fileId){
		$sql = "SELECT * FROM excelExport WHERE FileId = '".$fileId."'";
        $data = User::getDataTable($sql, 'BP_Admin10');
		return empty($data) ? false : $data[0];
	}
	
	public function saveExcelExportDb($fileId, $status){
		$exists = $this->getExcelExportFileById($fileId);
		//die(json_encode($exists));
		if(!$exists) {
			$date = Date('Y-m-d');
			$UserEmail = isset ($_SESSION['parentUsername'])?$_SESSION['parentUsername']:$_SESSION['username'];
			$UserID = isset ($_SESSION['ParentUserID'])?$_SESSION['ParentUserID']:$_SESSION['UserID'];		
			$sql = "Insert into excelExport(FileId , DateCreated , UserID , UserEmail , status ) values ( 					                          '".$fileId."' , '".$date."' ,  '".$UserID."' ,  '".$UserEmail."' , '".$status."' )";
			User::AddQuery($sql, 'BP_Admin10');
			return $this->getExcelExportFileById($fileId);
		}else {
			return $exists;
		}
	}
	
	public  function saveExcelExportChunk($fileId, $partId, $dir, $data, $cols = false){
		$location = '';
		if($cols){
			$location = '/public/assets/excel_files/'.$fileId.'_columns.json';
			$data = explode(",", $data);
		}else {
			$location = '/public/assets/excel_files/'.$fileId.'_'.$partId.'.json';
			$sql = "Insert into excelExportChunks(FileId, Location, PartId) values ('".$fileId."' , '".$location."' , '".$partId."')";
        User::AddQuery($sql, 'BP_Admin10');
		}
		//
		file_put_contents($dir.$location, json_encode($data));
		return $location;
	}
	
	public  function saveExcelCompleteCall($fileId, $status){
		$sql = "Update excelExport set status = '".$status."' where FileId = '".$fileId."'";
		User::AddQuery($sql, 'BP_Admin10');
	}

  
}