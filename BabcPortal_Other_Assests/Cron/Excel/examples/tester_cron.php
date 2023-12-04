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


$DBName = 'BP_Admin10';
$DBPass = 'gcsmakeit2010';
$DBUsername = 'jeff';
$DBHost = '10.30.57.5';
$db = new PDO("sqlsrv:Server=$DBHost;Database=$DBName;", "$DBUsername", "$DBPass");

$str =['"' , "'"] ;
// Throw an Exception when an error occurs
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
$db->setAttribute(PDO::SQLSRV_ATTR_ENCODING,PDO::SQLSRV_ENCODING_UTF8  );

function SendMail($userMail ,  $Bidy)
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
			$mail->Subject = 'Excel Files Sent ';
			$mail->Body    = $Body ;

			$mail->send();
		} catch (Exception $e) {
			$error = "Mailer Error: " . $mail->ErrorInfo;
		}


}

ini_set('memory_limit', '200G');
$spreadsheet = new Spreadsheet();

$dir = '/var/www/vhosts/babcportal.app/httpdocs';

$file = scandir($dir, 0);

$sql = "select * from excelExport where status = 'saved'";
$stmt = $db->query($sql);
$AllFileName = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($AllFileName as $key => $val){
	$sql = "select * from excelExportChunks where FileId = '".$val['FileId']."'";
	$stmt = $db->query($sql);
	$allData = [];
	$chunks = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($chunks as $chunk){
		$location = $dir.$chunk["Location"];
		$content = json_decode(file_get_contents($location ), true);
		//$allData = array_merge($allData, $content);
		print_r($content); 
		unset($content);
		unset($location);
	}
	
	exit;
	$filePath = $dir.$val['FileNameJson'] ;
	$FileName  = explode('.' , $val['FileNameJson']);
	$FileName  = $FileName[0];
	if(file_exists( $filePath )){
		exit;
		/*$getFileContent = file_get_contents($filePath );
		print_r("Hello "); exit;
		$getFileContent = json_decode(file_get_contents($filePath ), true);
		*/
		$spreadsheet->getActiveSheet()->fromArray(
                        $getFileContent,  // The data to set
                        NULL ,     // Array values with this value will not be set
                        'A2'); 
		$writer = IOFactory::createWriter( $spreadsheet, 'Xlsx' );
		$excelFilePath = $dir . $FileName . '.xlsx';
		$writer->save($excelFilePath);
		$userMail = $val['UserEmail'];
		$Body = '<a href="https://babcportal.app/public/assets/excel_files/'.$FileName.'.xlsx">Download Excel File from this Link </a>';
		SendMail($userMail  , $Body);


	}
	
}

print_r($AllFileName); exit;











?>