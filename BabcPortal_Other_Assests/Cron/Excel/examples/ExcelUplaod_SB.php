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


$DBName = 'BP_SelectedBrands';
$DBPass = 'gcsmakeit2010';
$DBUsername = 'jeff';
$DBHost = '10.30.57.5';
$db = new PDO("sqlsrv:Server=$DBHost;Database=$DBName;", "$DBUsername", "$DBPass");

$str =['"' , "'"] ;
// Throw an Exception when an error occurs
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
$db->setAttribute(PDO::SQLSRV_ATTR_ENCODING,PDO::SQLSRV_ENCODING_UTF8  );


$spreadsheet = new Spreadsheet();

$dir = "C:\MAMP\htdocs\Babcportal\BabcPortal_Other_Assests\BabcPortal\Excel_SB";
$TimeHR = strtotime('-1 hour');
$timeNow = strtotime(date("Y-m-d H:i:s"));

$file = scandir($dir, 0);
for($j = 2; $j < count($file); $j++){ 
	$file_name =  $dir.'\\'.$file[$j];
	
	$fileTime = filectime($file_name);
	
	if($fileTime < $timeNow &&  $fileTime > $TimeHR){
		
		$spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load($file_name);
		$worksheet = $spreadsheet->getActiveSheet();
		$rows = [];
		$columnName =  [];
		$count = 0;
		$sql  = '';
		$name  = "INSERT INTO Selected_Brands( " ;
		$name1 = "VALUES(" ;
		foreach ($worksheet->toArray() as $row) {
			$Temprows = array();
			if($count == 0) {
				
				
				foreach($row as $rowData) {
					$columnName[] = $rowData;
					$name  .=  $rowData .','  ;
				
				}
				$name  = trim($name , ',');
				
				$name  .= ')';
				
				$count = 1;
			}else {
				//Check for Update 
				$sql  = "select * from Selected_Brands where  ";
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
				
				$stmt = $db->query($sql);
				$data = $stmt->fetchAll();

				$name1  = trim($name1 , ',');
				$name1  .= ')';
				
				if(empty($data)){
					$sql  = $name . $name1;
					$stmt = $db->prepare($sql);
					$stmt->execute();
				}else{
					$sql = 'Delete from Selected_Brands ' .$Check;
					
					$stmt = $db->prepare($sql);
					$stmt->execute();

					$sql  = $name . $name1;
					$stmt = $db->prepare($sql);
					$stmt->execute();
					//$dup = $dup+1;
					
				}
			}
			
			
		}
		unlink($file_name);
	}
}

require_once __DIR__ . '/phpMail/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$mail = new PHPMailer(true);

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

        $mail->isHTML(true);
        $mail->Subject = 'Excel Files have been uploaded ';
        $mail->Body    = count($file)-2 . " File Have Been Imported to SQL Succesfully  " ;

        $mail->send();
    } catch (Exception $e) {
        $error = "Mailer Error: " . $mail->ErrorInfo;
    }

$Msg = count($file)-2 . "Has Been Imported to SQL ";

print_r($Msg ); 

exit;
	
	


	
	
  

