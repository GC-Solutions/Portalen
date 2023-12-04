<?php

ini_set("memory_limit", "-1");
set_time_limit(0);
ini_set('display_errors', 1);
error_reporting(E_ALL);

use \lyquidity\xbrl_validate\PhpOffice\PhpSpreadsheet\Groups;
use \lyquidity\xbrl_validate\PhpOffice\PhpSpreadsheet\Group;
use \lyquidity\xbrl_validate\PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;
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


$DBName = 'BP_Admin10';
$DBPass = 'gcsmakeit2010';
$DBUsername = 'jeff';
$DBHost = '10.30.57.5';
$db = new PDO("sqlsrv:Server=$DBHost;Database=$DBName;", "$DBUsername", "$DBPass");


// Throw an Exception when an error occurs
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
$db->setAttribute(PDO::SQLSRV_ATTR_ENCODING,PDO::SQLSRV_ENCODING_UTF8  );

function SendMail($userMail ,  $Boby)
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
			$mail->Subject = 'Excel Files Export';
			$mail->Body    = $Boby ;

			$mail->send(); 
		} catch (Exception $e) {
			$error = "Mailer Error: " . $mail->ErrorInfo;
		}


}

function num2alpha($n) {
    $r = '';
    for ($i = 1; $n >= 0 && $i < 10; $i++) {
    $r = chr(0x41 + ($n % pow(26, $i) / pow(26, $i - 1))) . $r;
    $n -= pow(26, $i);
    }
    return $r;
}

$spreadsheet = new Spreadsheet();

$dir = '/var/www/vhosts/babcportal.app/httpdocs';
$dir1 = '/var/www/vhosts/babcportal.app/httpdocs/public/assets/excel_files/';
//$dir = 'C:\MAMP\htdocs\Babcportal\BabcPortal_Dev\Dev_Git';

//$file = scandir($dir, 0);

$sql = "select * from excelExport where status = 'saved'";
$stmt = $db->query($sql);
$AllFileName = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($AllFileName as $key => $val){
	
	$sql = "select * from excelExportChunks where FileId = '".$val['FileId']."' order by ID Asc ";
	
	$stmt = $db->query($sql);
	$allData = [];
	$chunks = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$MainData = array();
	
	$columnPath = $dir1  . $val['FileId']. "_columns.json";
	$excelFilePath =  $dir1  . $val['FileId']. ".xlsx";

	
	if(file_exists($columnPath)){
		$columnData = json_decode(file_get_contents($columnPath), true);
		unlink($columnPath);
	}
	
	if(!empty($chunks)){
		foreach($chunks as $chunk){
			$location = $dir.$chunk["Location"];
			
			//$location = str_replace('/' , '\\' ,$location );
			
			if(file_exists($location)){
				$content = json_decode(file_get_contents($location ), true);
				$MainData = array_merge($MainData , $content);
				$sql = "Delete from excelExportChunks  where  Location = :Location ";
				$stmt = $db->prepare($sql);
				$fId = $chunk['Location'];
				$stmt->bindParam(':Location' , $fId, PDO::PARAM_STR);
				$stmt->execute();
				unlink($location);
			}
			
		}
		
		$spreadsheet->getActiveSheet()->fromArray(
			$columnData,  // The data to set
			NULL ,     // Array values with this value will not be set
			'A1'); 
		$spreadsheet->getActiveSheet()->fromArray(
			$MainData,  // The data to set
			NULL ,     // Array values with this value will not be set
			'A2'); 
		$ColAlpha = count($columnData);
		$totalCount = count($MainData)+1;
		$lastcol = num2alpha($ColAlpha-1).$totalCount;

        $spreadsheet->getActiveSheet()->getStyle("A2:$lastcol")->getNumberFormat()->setFormatCode('#');

		foreach (range('A', num2alpha($ColAlpha-1)) as $col) {
			$spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		   
		}
		
		$writer = IOFactory::createWriter( $spreadsheet, 'Xlsx' );
		$writer->save($excelFilePath);
		$Boby = '<a href="https://babcportal.app/public/assets/excel_files/'.$val['FileId'].'.xlsx">Download Excel File</a>';
		
		SendMail($val['UserEmail'] ,  $Boby);
		$sql = "UPDATE excelExport SET status = :status  where  FileId = :FileId ";
		$stmt = $db->prepare($sql);
		$status = 'sent';
		$fId = $val['FileId'];
		$stmt->bindParam(':status' , $status , PDO::PARAM_STR);
		$stmt->bindParam(':FileId' ,  $fId, PDO::PARAM_STR);
		$stmt->execute();
		 
	}

}
print_r("done"); exit;
 exit;

?>