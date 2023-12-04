<?php
// This File is cron that update read from file data on click .
ini_set('memory_limit', '200G');
ini_set('display_errors', 1);
error_reporting(E_ALL);
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'C:/xampp/htdocs/Dev/BabcPortal/vendor/autoload.php';


    $_arrayList = array('ResultList');
    $retval = array();

    $DBName = 'BP_Admin10';
    $db = new PDO("sqlsrv:Server=212.247.32.103;Database=BP_Admin10;", "jeff", "gcsmakeit2010");

    // Throw an Exception when an error occurs
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
    $sql = " select * from  LiveReportSync where ReportStatus = '1' " ;
    $stmt = $db->query( $sql);
    $val = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if($val){

        $sql = "update LiveReportSync set ReportStatus = '0' ";                  
        $stmt = $db->prepare($sql);
        $stmt->execute(); 
      foreach($val as $keyVal => $repoVal){

        $DBName = $repoVal['CompanyDB'];
        $db = new PDO("sqlsrv:Server=212.247.32.103;Database=".$DBName.";", "jeff", "gcsmakeit2010");
        // Throw an Exception when an error occurs
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $results = array();
		$requestBody = $repoVal['PostBody'];
        $reqURL = trim($repoVal['PostUrl']);
       
      
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_NOBODY, false);
        curl_setopt($ch, CURLOPT_URL, $reqURL);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
            
        //curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $results = curl_exec($ch);
        
       
        $apiData = [];
        if ($results) {
            $decodedResults = json_decode($results, true);
            $apiData = $decodedResults;

            if ($decodedResults) {
                foreach ($_arrayList as $key) {
                    if (isset($decodedResults[$key])) {
                        $apiData = $decodedResults[$key];
                        break;
                    }
                }
            }
        }
        $message = 'Data has not been Updated ';
        if( $apiData){
            $sql = "TRUNCATE TABLE ".$repoVal['CustomTable'];
            $q = $db->prepare($sql);
            $q->execute();
    
            // Add the record 
            foreach ($apiData['Records'] as $apiDataKey => $apiDataValue) {
    
                $sql = "INSERT INTO ".$repoVal['CustomTable']."(ANR, BEN , PRI , LGA , dateUpdated )
                VALUES (:ANR, :BEN , :PRI , :LGA , :dateUpdated)";
                                    
                $stmt = $db->prepare($sql);
                $ApiValue =$apiDataValue['FieldAndValues'];
                foreach( $ApiValue as $apiKey => $apival){
                   
                    $stmt->bindParam(':'.$apival['Field'], $apival['Value'], PDO::PARAM_STR);
                }
                $date =  date('Y-m-d H:i:s');
                $stmt->bindParam(':dateUpdated', date('Y-m-d H:i:s'), PDO::PARAM_STR);
                $stmt->execute();
            }
            $linkT0Page = 'http://212.247.32.103:8082/Dev/BabcPortal/public/page?id=1052&page_text=Live%20Reports';
            $message = 'Data has been updated  at ' .  date('Y-m-d H:i:s') . "The Linke to page is ". $linkT0Page ;
          
        }
       
        //Create an instance; passing `true` enables exceptionsx
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
           // $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->Host = 'smtp-mail.outlook.com';  
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'sahar.akhtar@gcsolutions.se';                     //SMTP username
            $mail->Password   = 'jHVCXmh5hjLChuT';                               //SMTP password
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            // $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';  
            //Recipients
            $mail->setFrom('sahar.akhtar@gcsolutions.se', 'GCS System');
           // $mail->addAddress('saharkhan201@gmail.com', 'Sahar');     //Add a recipient
            $mail->addAddress('saman.andishmand@gcsolutions.se', 'Saman ');     //Add a recipient
            
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Report Syncing has been completed ';
            $mail->Body    = $message;
            $mail->AltBody =  $message;

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        print_r("Data Uploaded");
        exit;
      }
        
    }
    echo "Cron Successful";
	exit;