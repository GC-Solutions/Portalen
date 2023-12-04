<?php
ini_set("memory_limit", "-1");
set_time_limit(0);
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Include Composer autoloader if not already done.


$db = new PDO("sqlsrv:Server=10.30.57.5;Database=BP_Saljpartner;", "jeff", "gcsmakeit2010");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM PDFuploadedFiles";
$stmt = $db->query( $sql);
$PDFData = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "TRUNCATE TABLE PDFuploadedFiles ";
$q = $db->prepare($sql);
$q->execute();

$dir = '/var/www/vhosts/babcportal.app/httpdocs/BabcPortal_Other_Assests/Cron/pdf2/PDFS';

$file = scandir($dir, 0);

for($j = 2; $j < count($file); $j++){ 

    $fileName  =  $dir.'/'.$file[$j];
    $fileTime = filectime($fileName);
    $fileNameNew = explode('_' , $file[$j]);
    if(count($fileNameNew) >= 2){
        $fileNameNew = $fileNameNew[1];
    }else{
        $fileNameNew = $fileNameNew[0];
    }
    $fileTime = date('Y-m-d H:i:s' ,$fileTime );

    $db = new PDO("sqlsrv:Server=10.30.57.5;Database=BP_Saljpartner;", "jeff", "gcsmakeit2010");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "Insert into PDFuploadedFiles (Filename , dateCreated) VALUES ( '".$fileNameNew."' , '" .$fileTime." ')";
    $stmt = $db->prepare($sql);
    $stmt->execute();
}


exit;


echo "Data Updated ";
exit;





?>