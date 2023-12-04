<?php

ini_set("memory_limit", "-1");
set_time_limit(0);
ini_set('display_errors', 1);
error_reporting(E_ALL);

use \lyquidity\xbrl_validate\PhpOffice\PhpSpreadsheet\Groups;
use \lyquidity\xbrl_validate\PhpOffice\PhpSpreadsheet\Group;
use \lyquidity\xbrl_validate\PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once __DIR__ . '/data.php';

if ( file_exists( __DIR__ . '/../../../autoload.php' ) )
{
	require_once __DIR__ . '/../../../autoload.php';
}
// Required for the original implementation
elseif ( file_exists( __DIR__ . '/../vendor/autoload.php' ) )
{
	require_once __DIR__ . '/../vendor/autoload.php';
}
else
{
	throw new Exception("Unable to autoload classes");
}

$files = get_included_files();
$bootstrap = realpath( __DIR__ . '/../phpspreadsheet/Spreadsheet.php' );
if ( ! in_array( $bootstrap, $files ) )
{
	require_once __DIR__ . '/../phpspreadsheet/Spreadsheet.php';
}

require_once __DIR__ . '/phpMail/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$DBName = 'BP_Saljpartner';
$DBPass = 'gcsmakeit2010';
$DBUsername = 'jeff';
$DBHost = '10.30.57.5';
$db = new PDO("sqlsrv:Server=$DBHost;Database=$DBName;", "$DBUsername", "$DBPass");

$str =['"' , "'"] ;
// Throw an Exception when an error occurs
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
$db->setAttribute(PDO::SQLSRV_ATTR_ENCODING,PDO::SQLSRV_ENCODING_UTF8  );

function SendMail($userMail ,  $file_name)
{

	$mail_host = 'smtp.office365.com';
	$mail_username = 'noreply@gcsolutions.se';
	$mail_password = '!GCSmail2022';
	$mail_port = 587;

	$mail = new PHPMailer(true);
		try {
			$mail->isSMTP();
			$mail->Host       = $mail_host;
			$mail->SMTPAuth   = true;
			$mail->Username   = $mail_username;
			$mail->Password   = $mail_password;
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
			$mail->Port       = $mail_port;

			$mail->setFrom($mail_username, 'Babc Portal');
			$mail->addAddress('saharkhan201@gmail.com', 'User');
			$mail->addAddress('saman.andishmand@gcsolutions.se', 'User');
			if($userMail){
				$mail->addAddress($userMail, 'User');
			}
			

			$mail->isHTML(true);
			$mail->Subject = 'Excel Files Upload ';
			$mail->Body    = $file_name. "  Have Been Imported to SQL Succesfully  " ;

			$mail->send();
		} catch (Exception $e) {
			$error = "Mailer Error: " . $mail->ErrorInfo;
		}


}

function __fatalHandler($userMail)
{
    $error = error_get_last();

    // Check if it's a core/fatal error, otherwise it's a normal shutdown

    if ($error !== NULL && in_array($error['type'],
        array(E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING,
              E_COMPILE_ERROR, E_COMPILE_WARNING,E_RECOVERABLE_ERROR))) {
		$Body = $error ['message'] .' in '.$error ['file']. ' on '.$error ['line'];
        //print_r($Body );
		
		$mail_host = 'smtp.office365.com';
		$mail_username = 'noreply@gcsolutions.se';
		$mail_password = '!GCSmail2022';
		$mail_port = 587;

		$mail = new PHPMailer(true);
		try {
			$mail->isSMTP();
			$mail->Host       = $mail_host;
			$mail->SMTPAuth   = true;
			$mail->Username   = $mail_username;
			$mail->Password   = $mail_password;
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
			$mail->Port       = $mail_port;

			$mail->setFrom($mail_username, 'Babc Portal');
			$mail->addAddress('saharkhan201@gmail.com', 'User');
			$mail->addAddress('saman.andishmand@gcsolutions.se', 'User');
			if($userMail){
				$mail->addAddress($userMail, 'User');
			}
			

			$mail->isHTML(true);
			$mail->Subject = 'Excel Files Upload ';
			$mail->Body    = $Body;
			//$mail->Body    = count($file)-2 . " File Have Been Imported to SQL Succesfully  " ;

			$mail->send();
		} catch (Exception $e) {
			$error = "Mailer Error: " . $mail->ErrorInfo;
		}
        echo "</pre>";
        die;
    }
}

$spreadsheet = new Spreadsheet();

//$dir = "C:\MAMP\htdocs\Babcportal\BabcPortal_Other_Assests\BabcPortal\Excel\Säljpartner";
$dir = '/var/www/vhosts/babcportal.app/httpdocs/BabcPortal_Other_Assests/BabcPortal/Excel/Säljpartner';

$file = scandir($dir, 0);
$TimeHR = strtotime('-1 hour');
$timeNow = strtotime(date("Y-m-d H:i:s"));
$DataEnteredFile = 0;
$mailsendName =  [];
$file = scandir($dir, 0);

$sql = 'SELECT distinct(FileNameExcel)FROM ExcelFileData';
$stmt = $db->query($sql);
$AllFileName = $stmt->fetchAll(PDO::FETCH_ASSOC);
$AllFileName = array_column($AllFileName, 'FileNameExcel');

for($j = 2; $j < count($file); $j++){ 
	$file_name =  $dir.'/'.$file[$j];
	$temp = explode('_' ,$file[$j]);
	$mail = '';
	$newFilename  = '';
	if(count($temp) == 2){
		$mailsendName[$temp[0]] = $temp[1];
		$mail = '';
		$newFilename  = $temp[1];
	}else{
		$newFilename  = $temp[0];
	}
	
	
	//$fileTime = filectime($file_name);
	
	//if($fileTime < $timeNow &&  $fileTime > $TimeHR){
	$fileTime = filectime($file_name);
    
    $fileTimeNew = time();

	//if($fileTime < $timeNow &&  $fileTime > $TimeHR){
    
   // if( ($fileTimeNew - $fileTime)  <  900){
	  if( (!in_array(trim($newFilename) , $AllFileName))){
		//unlink($file_name);
		 
		$DataEnteredFile = $DataEnteredFile+ 1;
		$spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load($file_name);
		$worksheet = $spreadsheet->getActiveSheet();
		$rows = [];
		$columnName =  [];
		$count = 0;
		$sql  = '';
		$name  = "INSERT INTO ExcelFileData( " ;
		$name1 = "VALUES(" ;
		foreach ($worksheet->toArray() as $row) {
			
			$Temprows = array();
			if($count == 0) {
				
				$row[] = 'FileNameExcel';
				foreach($row as $rowData) {
					$check  = 0;
					
					if($rowData == 'Period'){
						$rowData = 'SUPPORT_SALES_APPLY_PERIOD';
					}else if($rowData == 'Leverantör'){
						$rowData = 'Varumottagare';
					}else if($rowData == 'Huvudknr' || $rowData == 'Huvud.knr' ){
						$rowData = 'Kundnr';
					}else if($rowData == 'Avtalsnr'){
						$rowData = 'Avtal';
					}else if($rowData == 'Avtalsnamn'){
						$rowData = 'Kundnman';
					}else if($rowData == 'Art.nr'){
						$rowData = 'ARTIKEL';
					}else if($rowData == 'Ert art.nr'){
						$rowData = 'LEV_ARTN_UTAN_SK';
					}else if($rowData == 'Beskrivning'){
						$rowData = 'NAME';
					}else if($rowData == 'Rab kr'){
						$rowData = 'A_PRIS_NETTO';
					}else if($rowData == 'Summa'){
						$rowData = 'RADNETTO';
					}else if($rowData == 'Antal'){
						$rowData = 'KVANT';
					}else if($rowData == 'Enhet'){
						$rowData = 'ENHET';
					}else if($rowData == 'Rab %'){
						$check  = 1;
					}else if($rowData == 'Vikt'){
						$check  = 1;
					}else if($rowData == 'Antal/enh'|| $rowData == 'Antal/Enh'){
						$check  = 1;
					}else if($rowData == 'EAN-nummer'){
						$check  = 1;
					}else if($rowData == 'Lager'){
						$check  = 1;
					}else if($rowData == 'Lev.nr' || $rowData == 'Lev-nr' ){
						$check  = 1;
					}
					
					if($check == 0){
						$columnName[] = $rowData;
						$name  .=  $rowData .','  ;
					}else {
						$columnName[] = '';
					}
					
				}
				//$name  = $name.'FileNameExcel';
				$name  = trim($name , ',');
				
				$name  .= ')';
				$name = str_replace(',,' , ',' , $name);
				
		  //print_r($name); exit;
				$count = 1;
			}else {
				//Check for Update 
				
					
				$row[] = $newFilename;
				$sql  = "select * from ExcelFileData where  ";
				$Check  = 'where ';
				$name1 = "VALUES(" ;
				for($i= 0 ; $i < count($row) ; $i++) {
					if($columnName[$i]){
						$row[$i] =  str_replace($str, '', $row[$i]);
						
						$sql  .= $columnName[$i] ."= '". $row[$i]."' AND ";
						$Check .= $columnName[$i] ."= '". $row[$i]."' AND ";
						
						$name1 .= "'".$row[$i] . "',";
					}
				}
				
				$sql = trim($sql  , 'AND ');
				$Check = trim($Check , 'AND ');
				register_shutdown_function('__fatalHandler' ,  $mail);
				$stmt = $db->query($sql);
				$data = $stmt->fetchAll();

				$name1  = trim($name1 , ',');
				$name1  .= ')';
				
				if(empty($data)){
					$sql  = $name . $name1;
					
					$stmt = $db->prepare($sql);
					register_shutdown_function('__fatalHandler' ,  $mail);
					$stmt->execute();
				}else{
					$sql = 'Delete from ExcelFileData ' .$Check;
					
					$stmt = $db->prepare($sql);
					register_shutdown_function('__fatalHandler' ,  $mail);
					$stmt->execute();

					$sql  = $name . $name1;
					
					$stmt = $db->prepare($sql);
					register_shutdown_function('__fatalHandler' ,  $mail);
					$stmt->execute();
					//$dup = $dup+1;
					
				}
			}
			
			
		}
		register_shutdown_function('__fatalHandler' ,  $mail);
		//unlink($file_name);
		//SendMail($mail , $newFilename );
	}
}


//register_shutdown_function('__fatalHandler' ,  $mail);

$Msg = count($file)-2 . "Has Been Imported to SQL ";

print_r($Msg ); 

exit;
	
	


	
	
  

