<?php
ini_set("memory_limit", "-1");
set_time_limit(0);
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Include Composer autoloader if not already done.
include 'vendor/autoload.php';
// Initialize and load PDF Parser library 
$parser = new \Smalot\PdfParser\Parser(); 



 $db = new PDO("sqlsrv:Server=10.30.57.5;Database=BP_Saljpartner;", "jeff", "gcsmakeit2010");
 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


require_once __DIR__ . '/phpMail/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Function for Sending Mail

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
		
			$mail->addAddress('jonatan.janebrink@gcsolutions.se', 'User');
			if($userMail){
				$mail->addAddress($userMail, 'User');
			}
			

			$mail->isHTML(true);
			$mail->Subject = 'PDF Files Upload ';
			$mail->Body    = $file_name. "  Have Been Imported to SQL Succesfully  " ;

			$mail->send();
		} catch (Exception $e) {
			$error = "Mailer Error: " . $mail->ErrorInfo;
		}


}

//Function for Fatal Error
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
			$mail->addAddress('noreply@gcsolutions.se', 'User');
			$mail->addAddress('jonatan.janebrink@gcsolutions.se', 'User');
			if($userMail){
				$mail->addAddress($userMail, 'User');
			}
			

			$mail->isHTML(true);
			$mail->Subject = 'PDF Files Upload ';
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


//$file = 'test1.pdf'; 
$TimeHR = strtotime('-1 hour');
$timeNow = strtotime(date("Y-m-d H:i:s"));
$DataEnteredFile = 0;
$dir = '/var/www/vhosts/babcportal.app/httpdocs/BabcPortal_Other_Assests/Cron/pdf2/PDFS';
$file = scandir($dir, 0);

$sql = 'select DISTINCT(FileNamePDF) from PDfFileData;';
$stmt = $db->query($sql);
$AllFileName = $stmt->fetchAll(PDO::FETCH_ASSOC);
$AllFileName = array_column($AllFileName, 'FileNamePDF');

for($j = 2; $j < count($file); $j++){ 
   	echo $file[$j]."<br>";
    $fileName  =  $dir.'/'.$file[$j];
    $mailFileName = '';
    $mail = '';
    $temp = explode('_' ,$file[$j]);
   
    if(count($temp) == 2){
		
		$mail = '';
		$mailFileName  = $temp[1];
	}else{
		$mailFileName  = $temp[0];
	}
    
    $fileTime = filectime($fileName);
    
    $fileTimeNew = time();
 
	//if($fileTime < $timeNow &&  $fileTime > $TimeHR){
	$TestTime  = (date('Y-m-d',strtotime("-1 days")));
	$NewTestTime = (date('Y-m-d' ,$fileTime));

	
    if((!in_array(trim($mailFileName) , $AllFileName))){
		//print_r($mailFileName); exit;
   	  //if(   $TestTime  ==  $NewTestTime ){
        $DataEnteredFile = $DataEnteredFile+ 1;
        
        $pdf = file_get_contents($fileName  );
        $number = preg_match_all("/\/Page\W/", $pdf, $dummy);
        $pdf = $parser->parseFile($fileName ); 
       // echo var_dump($pdf);
        $pages = $pdf->getPages();
        //echo var_dump($pages);
        $number = intval($number) ;
        echo $number;
        //$textContent = $pdf->getText();
        $Kundnr = '';
        $Kundnman =  '';
        $Avtal = '';


        $CompanyArr =[ 'Stockholm HK Avtal Kontrakt', 'Halmstad Avtal Offentliga',  'MAX BURGERS' ,'Norrköping Avtal Offentliga', 'Halmstad Avtal Privat Syd', 'Halmstad Avtal Privat Väst' , 'Enköping Avtal Priv Mälarda' , 'Umeå Avtal Offentlig' , 'Norrköping Avtal Privat', 'Stockholm Avtal Offentliga'];
        //$number-1
        for ($i= 0; $i < $number ; $i++) { 
        
            $i = intval($i);

            // First 3 Columns 
            $textContent =  $pages[$i]->getText();
            var_dump($textContent);
            $column = explode('Box 704' ,$textContent  );
            $column = explode('Sida' , $column[0]);
           
            $column = str_replace(["\r\n", "\r", "\n"], " ", trim($column[1]));
           
            $delimiter = "\t"; // Use the tab character as the delimiter

            $tempArr = explode(' ', $column);
            if (count($tempArr) !== 3) {
            
                $column = explode($delimiter, $column);
           
            }
            else {
                $column = $tempArr;
            }
           
            $Fakturanr = isset($column[0])?trim($column[0]): '';
          
     
            $Fakt_datum = isset($column[1])?trim($column[1]):'';
            $Sida = isset($column[2])?trim($column[2]):'';

            $column = explode('Varumottagare' ,$textContent);
            $column = explode('Momsreg.nummer' , $column[1]);
            $Varumottagare = trim($column[0]);
            $column = explode('Vår referens' ,trim($column[1]));
            $column = explode('Er referens' ,trim($column[1]));
       
            $column = str_replace(["\r\n", "\r", "\n"], ",", $column[0]);
            
            $column = explode(',' , $column);
            
            $Vår_referens  = trim($column[1]).' '.trim($column[2]);

            $column = array();
            if($i == 0){
                
                $column = explode('AVTALSSTÖD FÖRSÄLJNING GÄLLER PERIOD' , $textContent);
                $column = str_replace(["\r\n", "\r", "\n"], "==", $column[1]);
              //  var_dump($column);
                $column = explode("==" , $column);
              //  var_dump($column);
                $AVTALSSTÖD_FÖRSÄLJNING_GÄLLER_PERIOD = $column[0];
                unset($column[0]);
                $column = explode('AVTALSSTÖD FÖRSÄLJNING GÄLLER PERIOD' , $textContent);
                $tempCol = explode("Scan ID:" , $column[1]);
                $column[1] =  $tempCol[0];
            
            }
            else  {
                
                $column = explode('KVANT' , $textContent);
                $column = explode('NORRKÖPING' ,  $column[1]);
                if(count($column) >= 3) {
                    $oldCol = $column[0];
                    unset($column[0]);
                    $AllText = implode('NORRKÖPING' ,  $column);
                    $column[0] =  $oldCol;
                    $column[1] =  $AllText;

                }
            }
    
                $column = str_replace(',00', ",00|", $column[1]);
                $column = str_replace(',50', ",50|", $column);
            
                $column = str_replace(["\r\n", "\r", "\n","\t"], "==", $column);
                $column = str_replace("==KRT", " KRT", $column);
                $column = str_replace("==ST", " ST", $column);
                $column = str_replace("==HINK", " HINK", $column);
                $column = str_replace("99999999 ", "99999999==", $column);
                $column  =str_replace("==:", ":", $column); 
                $column  =str_replace("F==", "F ", $column); 
            // $column  =str_replace(" 16597,31", "", $column); 
        
                $column = explode("==" , $column);
                
                $tempcol = $column;
              
                $lastLines = 0;
                $prevkey = 0;
            

                foreach(  $tempcol as $tKey => $tVal){
                    
                    $key = array_search($tVal ,$column);
                    if($key == '' ){
                    
                        if($prevkey == 0 ){
                            $key  = $key;
                        }else {
                            $key  =  $prevkey+1;
                            $tVal = $column[$key];
                        }
                        
                    }else {
                        $prevkey  = $key;
                    }
                
                    if($key >= 0 && array_search($tVal ,$column) !== false ){

                        if((strpos($tVal , 'TOTAL MOMS') !== false )){
                        
                            $column[$key] = '';
                            break;
                        
                        
                        }
                        if(strpos($tVal , 'Moms 0%') !== false){
                            $lastLines = '1';
                            $column[$key] = '';
                        
                        }
                        
                        if(substr_count($tVal , ',') >= 3){
                            
                            if(strpos($tVal , '|') !== false){
                                $expVal = array_values(array_filter(explode( '|' , $tVal)));
                            
                                if(isset($expVal[3]) && $expVal[3] != ''){
                                
                                    $column = array_merge(array_slice($column, 0, $key+1), array($expVal[3]), array_slice($column,  $key+1));
                                    $expVal[3] = '';
                                    $column[$key] =  implode( '|' ,  $expVal);
                                    
                                }else {
                                    $expVal =  explode( ',' , $tVal);
                                    if(isset($expVal[3]) && $expVal[3] != ''){
                                        
                                        if(strlen(trim($expVal[3])) > 2){
                                        
                                            $redVal = substr(trim($expVal[3]) ,0 , 2);
                                            $restVal = trim($expVal[3]);
                                            $restVal = str_replace('|' , '' , substr(trim($restVal) ,2 , -1));
                                        
                                            $column = array_merge(array_slice($column, 0, $key+1), array($restVal), array_slice($column,  $key+1));
                                            $expVal[3] = $redVal;
                                            $column[$key] =  str_replace($restVal , '' , implode( ',' ,  $expVal));
                                        
                                            
                                        }
                                        
                                    }
                                }
                            }else {
                            
                                $expVal =  explode( ',' , $tVal);
                                if(isset($expVal[3]) && $expVal[3] != ''){
                                    
                                    if(strlen(trim($expVal[3])) > 2){
                                        
                                        $redVal = substr(trim($expVal[3]) ,0 , 2);
                                        $restVal = trim($expVal[3]);
                                        $restVal = substr(trim($restVal) ,2 , -1);
                                    
                                        $column = array_merge(array_slice($column, 0, $key+1), array($restVal), array_slice($column,  $key+1));
                                        $expVal[3] = $redVal;
                                        $column[$key] =  str_replace($restVal , '' , implode( ',' ,  $expVal));
                                        
                                    
                                    }
                                    
                                }
                                
                            }
                        
                        }
                    
                        if( substr_count($tVal , ',') == 1  || substr_count($tVal , ',') == 2 ){
                        
                            $arrcount = explode( " " , $tVal);
                            $arrcount = array_values(array_filter($arrcount));
                            $cnt = count($arrcount);
                            
                            if($cnt == 2 || $cnt == 3 ){
                                $chk = 0;
                                foreach($arrcount as $k => $v){
                                    $v  = str_replace(',' , '' , $v);
                                    if(intval($v)){
                                        $chk =$chk+1;
                                    }
                                } 
                            
                                if($cnt == $chk){
                                // $key = array_search($tVal ,$column);
                                    
                                    $column[$key] =  str_replace('==' , '' , ($column[$key])) ;
                                    
                                    if(substr_count($column[$key+1] , ',') == 1 || substr_count($column[$key+1] , ',') == 2){
                                            if(strpos($column[$key+1] , '|') !== false){
                                                $NewVal = array_values(array_filter(explode( '|' , $column[$key+1])));
                                            }else {
                                                $NewVal = array_values(array_filter(explode( ' ' , $column[$key+1])));
                                                if(substr_count($column[$key+1] , ',') == 1 ){
                                                    unset($NewVal[0]);
                                                    $NewValT = implode(' ' ,$NewVal);	
                                                    unset($NewVal);
                                                    $NewVal[1] =  $NewValT  ;
                                                }else if(substr_count($column[$key+1] , ',') == 2){
                                                    unset($NewVal[0]);
                                                    unset($NewVal[1]);
                                                    $NewValT = implode(' ' ,$NewVal);
                                                    unset($NewVal);
                                                    $NewVal[2] =  $NewValT  ;
                                                } 

                                            }
                                        
                                            if(substr_count($column[$key+1] , ',') == 1 && isset($NewVal[1]) && $NewVal[1] != '' ){
                                                
                                                $NewVal[1] = '=='.$NewVal[1];
                                                $column[$key+1] = implode( '|' ,  $NewVal);
                                            }else if(substr_count($column[$key+1] , ',') == 2 && isset($NewVal[2]) && $NewVal[2] != '' ){
                                                $NewVal[2] = '=='.$NewVal[2];
                                                $column[$key+1] = implode( '|' ,  $NewVal);
                                                
                                            }
                                            $trmpchk = 1;
                                            $column[$key] = $column[$key].' '.$column[$key+1].'==';
                                            $column[$key+1] = '';
                                        // $column = array_values(array_filter($column));
                                        
                                    }
                                    
                                    
                                }  
                            }
                        }
                        
                        if(strpos($tVal , 'KRT') !== false ){
                            
                            $KRT = explode(' ', $tVal);
                        
                            if(end($KRT) != 'KRT'  && (end($KRT) != 'KRT/')){
                                $trmpchk = 1;
                                $KRTVAl = implode(' ' , $KRT);
                                $KRT = str_replace("KRT", "KRT== ", $KRTVAl); 
                                $column[$key] = $KRT;
                                
                                
                            }
                            
                        }
                        
                        if(strpos($tVal ,  ' ST') !== false){
                            $checkrt = 0;
                            $KRT = array_values(array_filter(explode(' ', $tVal)));
                            $SKRT =  $tVal;
                            
                            foreach( $CompanyArr as $KrtKey => $KrtVal){
                                if(strpos( $SKRT  , $KrtVal ) !== false ){
                                    $checkrt = 1;
                                    break;
                                }
                            }
                            if(end($KRT) != 'ST' && $checkrt == 0 ){
                                $KRTVAl = implode(' ' , $KRT);
                                $KRT = str_replace("ST ", " ST==", $KRTVAl); 
                                $column[$key] = $KRT;
                                
                            
                            } 
                        
                        }
                        if(strpos($tVal ,  ' HINK') !== false){
                        
                            $KRT = explode(' ', $tVal);
                            
                            if(end($KRT) != 'HINK' ){
                                $trmpchk = 1;
                                $KRTVAl = implode(' ' , $KRT);
                                
                                $KRT = str_replace(" HINK ", " HINK==", $KRTVAl); 
                                $column[$key] = $KRT;
                                
                            } 
                        
                        }
                    
                        if(strpos($tVal ,'SÄR') !== false){
                        
                            $testVAl  = explode(' ', $tVal);

                            $testVAl  = array_values(array_filter($testVAl));
                        
                            if(count($testVAl) == 1){
                            
                            $column[$key-1] = $column[$key-1] .' '.$tVal;
                            $column[$key] = '';
                            
                            
                            }else if(  end($testVAl) != '' && is_int(intval(end($testVAl))) ){
                                if(intval(end($testVAl)) != 0){
                                

                                    $column[$key+1] = end($testVAl)." ".$column[$key+1];
                                    array_pop($testVAl);
                                    $testVAl  = implode(' ', $testVAl);
                                    $column[$key] = $testVAl;
                                
                                    
                                }
                            }
                        
                        }
                      
                        if(strpos($tVal , 'Avtal' , 2) !== false){
                            $newTval = array_values(array_filter(explode(' ' , $tVal)));
                            $cnt = count($newTval)-1;
                        
                            if($newTval[$cnt-1] == 'Avtal' && intval($newTval[$cnt]) != 0  ){
                                $newTval[$cnt-1] = '==Avtal' ;
                                $column[$key] = implode(' ' , $newTval) ;  
                            
                            }else if(substr_count( $tVal , 'Avtal') == 2 ){
                                    $newTest = explode('Stockholm HK Avtal Kontrakt' , $tVal);
                                    $ValTester =  $newTest[1];
                                    $testerVal  =  array_values(array_filter(explode(' ' ,  $ValTester)));
                                
                                    if(isset( $testerVal[3]) && $testerVal[3] != '' ){
                                        $testerVal[0] = '==' .  $testerVal[0] ;
                                        $testerVal[1] =  $testerVal[1]. '=='  ;
                                        $testerVal = implode(' ' ,  $testerVal);
                                        $newTest[1] =  $testerVal;
                                        $tVal = implode('Stockholm HK Avtal Kontrakt' , $newTest);
                                        $column[$key] =  $tVal;
                                    
                                    }
                            }
                        
                            
                        }
                    
                        if(strpos($tVal , 'Avtal') !== false){
                        
                            $avtal = explode(' ' , $tVal);
                            $avtal = array_values(array_filter($avtal));
                        
                            if($avtal[0] == 'Avtal' && count($avtal) > 2){
                            
                                $key = array_search($tVal ,$column);
                                $restVal = implode(' ' , array_slice($avtal,2)) ;  
                                $column = array_merge(array_slice($column, 0, $key+1), array($restVal), array_slice($column,  $key+1));
                                $column[$key] = implode(' ' , array_slice($avtal,0,2)) ;  
                            }
                                        
                        
                        }
                        if(strpos($tVal , '456485')!== false){
                            
                            $removedData = array_values(array_filter(explode(' ' , $tVal)));
                            if($removedData[0] == '456485' && count($removedData) == 2){
                            
                                $column[$key] = '456485   N/NORRKÖPINGS KOMMUN  Norrköping Avtal Offentliga';  
                            
                            }
                        }
                        
                    

                        if(substr_count($tVal , ',') == 1 && substr_count($tVal , ':') == 1){
                            $column[$key] = '';
                        }
                    
                    }
                    
                
                }
                
                //print_r($tempcol);
                //print_r($column);
                //exit;
               // echo var_dump($column);
                $column = implode("==" , $column);
               
            // $column = str_replace(',00|== ', ",00", $column);
                $column = str_replace('==SÄR', " SÄR", $column);
                $column = str_replace(',00|', ",00", $column);
                $column = str_replace(',50|', ",50", $column);
                // print_r($column);
                // exit;
                $column = explode("==" , $column);
             
                if($i == 0){
                    unset($column[0]);
                }
                $column = array_values(array_filter($column));
       



    
       $newArray = [];
       $b = 0;
       $concatenatedString ="";
       foreach ($column as $item) {
        if ( strlen(trim($item))<=13 && strlen(trim($column[$b+1]))<=13 && strlen(trim($column[$b+2]))<=13 && strlen(trim($column[$b+3]))<=13) {
            $concatenatedString = ' ' . $item;
        } 
        elseif ( strlen(trim($item))<=13 && strlen(trim($column[$b-1]))<=13 && strlen(trim($column[$b+1]))<=13 && strlen(trim($column[$b+2]))<=13) {

            $concatenatedString = $concatenatedString.' ' . $item;
        }
        elseif ( strlen(trim($item))<=13 && strlen(trim($column[$b-2]))<=13 && strlen(trim($column[$b-1]))<=13 && strlen(trim($column[$b+1]))<=13) {

            $concatenatedString = $concatenatedString.' '  . $item;
        }
        elseif ( strlen(trim($item))<=13 && strlen(trim($column[$b-3]))<=13 && strlen(trim($column[$b-2]))<=13 && strlen(trim($column[$b-1]))<=13) {

            $concatenatedString = $concatenatedString.' '  . $item;
            array_push($newArray, $concatenatedString);
     
        }
        else {
   
            array_push($newArray, $item);
        }
        $b++;
    }
                $column=$newArray;
        
                 //  echo var_dump($column);
  

                
                echo "<pre>";
                echo "------------------------------------";
                echo "Page Number ".$i;
                echo "------------------------------------";
                
                print_r( $column); 
                //exit;
            
            // echo "<pre>";
            // print_r( $column); exit;
                $lineCnt = 0;
                // First Pair 
                $BENÄMNING = '';
                $ENHET = '';
                // Second Pair 
                $ARTIKEL = '';
                $LEV_ARTN_UTAN_SK = '';
                // Third Pair
                $KVANT =  '';
                $A_PRIS_BRUTTO = '';
                $ANMÄRKNING = '';
                $A_PRIS_NETTO  = '';
                
                $RADNETTO = ''; 
                $NewVal123 = '';

                if(!empty($column)){
        //             echo "kjnjk";
        // exit;
                    foreach($column as $key => $val){
                       // var_dump($val);
                        $checkVal = explode(' ' , trim($val));
                        $checkVal = array_values(array_filter($checkVal));
                      
                        
                        if(strpos($val , 'Stockholm HK Avtal Kontrakt') !== false || strpos($val , 'Halmstad Avtal Offentliga') !== false || strpos($val , 'MAX BURGERS') !== false  || strpos($val , 'Norrköping Avtal Offentliga') !== false  || strpos($val , 'Halmstad Avtal Privat Syd') !== false  || strpos($val , 'Halmstad Avtal Privat Väst') !== false  || strpos($val , 'Enköping Avtal Priv Mälarda') !== false  || strpos($val , 'Umeå Avtal Offentlig') !== false  || strpos($val , 'Norrköping Avtal Privat') !== false   || strpos($val , 'Stockholm Avtal Offentliga') !== false ){  
                          echo var_dump($checkVal);
                          if(count($checkVal)>1) {
                            $check  = str_replace(',' , '' , $checkVal[1]);
                          }
                          else{
                            $check  = str_replace(',' , '' , $checkVal[0]);
                          }
                            if(is_numeric($check)){
                                foreach($checkVal as $keyC => $valC){
                                        if(strpos($valC , ',00') !== false ){
                                            $AnotherCheck = explode(',00' , $valC );
                                            if(is_numeric($AnotherCheck[1])){
                                                
                                                $AnotherCheck = array_values($AnotherCheck);
                                                $Arr1 = array_slice($checkVal, 0, ($keyC));
                                                array_push($Arr1 , $AnotherCheck[0].',00');
                                                
                                                $Arr2 = array_slice($checkVal, ($keyC+1));
                                                
                                                array_unshift($Arr2 , $AnotherCheck[1]);
                                                $Arr2 = implode(' ', $Arr2);
                                                
                                                $checkVal = $Arr1;
                                                $val = $Arr2 ;
                                                $Arr1 = implode(' ', $Arr1);
                                                $countCommas = substr_count($Arr1,",");
                                             
                                                if(is_numeric($checkVal[0]) && ($countCommas >= 1 && $countCommas <= 3)){
                                    
                                                    $checkVal = array_values(array_filter($checkVal));
                                                   
                                                    $KVANT = $checkVal[0];
                                                    $A_PRIS_BRUTTO = $checkVal[1];
                                                    $ANMÄRKNING = '';
                                                    $A_PRIS_NETTO  = isset($checkVal[2])?$checkVal[2]:'';
                                                    $RADNETTO = isset($checkVal[3])?$checkVal[3] :''; 
                                                
                                                }else if($NewVal123 != '' && ($countCommas >= 1 && $countCommas <= 3) )
                                                {
                                                    
                                                    $checkVal = array_values(array_filter($checkVal));
                                                    $KVANT = $NewVal123;
                                                    $NewVal123 = '';
                                                    $A_PRIS_BRUTTO = $checkVal[0];
                                                    $ANMÄRKNING = '';
                                                    $A_PRIS_NETTO  = isset($checkVal[1])?$checkVal[1]:'';
                                                    $RADNETTO = isset($checkVal[2])?$checkVal[2] :''; 
                            
                                                }
                                            }   

                                        }
                                }
                            
                            }
                            if($BENÄMNING != '' && $ENHET != '' ||  is_numeric($check)){
                                $sql = "INSERT INTO  PDfFileData (Fakturanr,Fakt_datum,Sida,Varumottagare,supplier,SUPPORT_SALES_APPLY_PERIOD,Kundnr,Kundnman,Avtal,NAME,ENHET,ARTIKEL,LEV_ARTN_UTAN_SK,KVANT,A_PRIS_BRUTTO,A_PRIS_NETTO,RADNETTO,FileNamePDF)
                                VALUES (:Fakturanr,:Fakt_datum,:Sida,:Varumottagare,:supplier,:SUPPORT_SALES_APPLY_PERIOD,
                                :Kundnr,:Kundnman,:Avtal,:NAME,:ENHET,:ARTIKEL,:LEV_ARTN_UTAN_SK,:KVANT,:A_PRIS_BRUTTO,:A_PRIS_NETTO,:RADNETTO,:FileNamePDF)";
                            
                            
                            $stmt = $db->prepare($sql);
                            
     



                            $stmt->bindParam(':Fakturanr', $Fakturanr ,  PDO::PARAM_STR);
                            $stmt->bindParam(':Fakt_datum', $Fakt_datum ,  PDO::PARAM_STR);
                            $stmt->bindParam(':Sida', $Sida ,  PDO::PARAM_STR);
                            $stmt->bindParam(':Varumottagare', $Varumottagare ,  PDO::PARAM_STR);
                            $stmt->bindParam(':supplier', $Vår_referens ,  PDO::PARAM_STR);
                            $stmt->bindParam(':SUPPORT_SALES_APPLY_PERIOD', $AVTALSSTÖD_FÖRSÄLJNING_GÄLLER_PERIOD ,  PDO::PARAM_STR);
                            $stmt->bindParam(':Kundnr', $Kundnr ,  PDO::PARAM_STR);
                            $stmt->bindParam(':Kundnman', $Kundnman ,  PDO::PARAM_STR);
                            $stmt->bindParam(':Avtal', $Avtal ,  PDO::PARAM_STR);
                            $stmt->bindParam(':NAME', $BENÄMNING ,  PDO::PARAM_STR);
                            $stmt->bindParam(':ENHET', $ENHET ,  PDO::PARAM_STR);
                            $stmt->bindParam(':ARTIKEL', $ARTIKEL ,  PDO::PARAM_STR);
                            $stmt->bindParam(':LEV_ARTN_UTAN_SK', $LEV_ARTN_UTAN_SK ,  PDO::PARAM_STR);
                            $stmt->bindParam(':KVANT', $KVANT ,  PDO::PARAM_STR);
                            $stmt->bindParam(':A_PRIS_BRUTTO', $A_PRIS_BRUTTO,  PDO::PARAM_STR);
                            $stmt->bindParam(':A_PRIS_NETTO', $A_PRIS_NETTO ,  PDO::PARAM_STR);
                            $stmt->bindParam(':RADNETTO', $RADNETTO ,  PDO::PARAM_STR);
                            $stmt->bindParam(':FileNamePDF', $mailFileName ,  PDO::PARAM_STR);
                            register_shutdown_function('__fatalHandler' ,  $mail);
                            $stmt->execute();
                            }
                        
                            $newVal = str_replace('Stockholm HK Avtal Kontrakt' , '', $val);
                            $newVal = str_replace('Halmstad Avtal Offentliga' , '',  $newVal);
                            $newVal = str_replace('MAX BURGERS' , '',  $newVal);
                            $newVal = str_replace('Norrköping Avtal Offentliga' , '',  $newVal);
                            $newVal = str_replace('Halmstad Avtal Privat Syd' , '',  $newVal);
                            $newVal = str_replace('Halmstad Avtal Privat Väst' , '',  $newVal);
                            $newVal = str_replace('Enköping Avtal Priv Mälarda' , '',  $newVal);
                            $newVal = str_replace('Umeå Avtal Offentlig' , '',  $newVal);
                            $newVal = str_replace('Norrköping Avtal Privat' , '',  $newVal);
                            $newVal = str_replace('Stockholm Avtal Offentliga' , '',  $newVal);
                          

                            $newVal1 = explode(' ' , $newVal);
                            $newVal1 = array_values(array_filter($newVal1));
                            $Kundnr = $newVal1[0];
                            $Kundnman = str_replace($Kundnr , '' , $newVal);
                            
                        }
                        else if(trim($checkVal[0]) == 'Avtal'){
                            $Avtal = str_replace($checkVal[0] , '' , $val);
                            $Avtal = explode('Scan ID' , $Avtal);
                            $Avtal = $Avtal[0];
                            $lineCnt = 0;
                        }
                  else {
                            
                            
                            if($lineCnt == 3)
                            {
                            
                                $checktestValArr = array_values(array_filter($checkVal));
                            
                                if(count($checktestValArr) <= 2 && count($checktestValArr) > 0 ){
                                    
                                    $checktestVal = str_replace(',' , '' ,$checktestValArr[0]);
                                
                                    if(is_numeric($checktestVal)){
                                        
                                        if(count($checktestValArr) == 2){

                                            $A_PRIS_NETTO  = isset($checktestValArr[0])?$checktestValArr[0]:$A_PRIS_NETTO;
                                            $RADNETTO = isset($checktestValArr[1])?$checktestValArr[1] :$RADNETTO ; 
                
                                        }else{
                                        
                                            $RADNETTO =  isset($checktestValArr[0])?$checktestValArr[0]:$RADNETTO;
                                            
                                        }
                                        
                                    }else{
                                        $BENÄMNING  =  $BENÄMNING . $val;
                                    }
                                
                                    $lineCnt = $lineCnt+1 ;
                                }else {
                                    $sql = "INSERT INTO  PDfFileData (Fakturanr,Fakt_datum,Sida,Varumottagare,supplier,SUPPORT_SALES_APPLY_PERIOD,Kundnr,Kundnman,Avtal,NAME,ENHET,ARTIKEL,LEV_ARTN_UTAN_SK,KVANT,A_PRIS_BRUTTO,A_PRIS_NETTO,RADNETTO,FileNamePDF)
                                    VALUES (:Fakturanr,:Fakt_datum,:Sida,:Varumottagare,:supplier,:SUPPORT_SALES_APPLY_PERIOD,
                                    :Kundnr,:Kundnman,:Avtal,:NAME,:ENHET,:ARTIKEL,:LEV_ARTN_UTAN_SK,:KVANT,:A_PRIS_BRUTTO,:A_PRIS_NETTO,:RADNETTO,:FileNamePDF)";
                                
                                
                                $stmt = $db->prepare($sql);
                                
                                $stmt->bindParam(':Fakturanr', $Fakturanr ,  PDO::PARAM_STR);
                                $stmt->bindParam(':Fakt_datum', $Fakt_datum ,  PDO::PARAM_STR);
                                $stmt->bindParam(':Sida', $Sida ,  PDO::PARAM_STR);
                                $stmt->bindParam(':Varumottagare', $Varumottagare ,  PDO::PARAM_STR);
                                $stmt->bindParam(':supplier', $Vår_referens ,  PDO::PARAM_STR);
                                $stmt->bindParam(':SUPPORT_SALES_APPLY_PERIOD', $AVTALSSTÖD_FÖRSÄLJNING_GÄLLER_PERIOD ,  PDO::PARAM_STR);
                                $stmt->bindParam(':Kundnr', $Kundnr ,  PDO::PARAM_STR);
                                $stmt->bindParam(':Kundnman', $Kundnman ,  PDO::PARAM_STR);
                                $stmt->bindParam(':Avtal', $Avtal ,  PDO::PARAM_STR);
                                $stmt->bindParam(':NAME', $BENÄMNING ,  PDO::PARAM_STR);
                                $stmt->bindParam(':ENHET', $ENHET ,  PDO::PARAM_STR);
                                $stmt->bindParam(':ARTIKEL', $ARTIKEL ,  PDO::PARAM_STR);
                                $stmt->bindParam(':LEV_ARTN_UTAN_SK', $LEV_ARTN_UTAN_SK ,  PDO::PARAM_STR);
                                $stmt->bindParam(':KVANT', $KVANT ,  PDO::PARAM_STR);
                                $stmt->bindParam(':A_PRIS_BRUTTO', $A_PRIS_BRUTTO,  PDO::PARAM_STR);
                                $stmt->bindParam(':A_PRIS_NETTO', $A_PRIS_NETTO ,  PDO::PARAM_STR);
                                $stmt->bindParam(':RADNETTO', $RADNETTO ,  PDO::PARAM_STR);
                                $stmt->bindParam(':FileNamePDF', $mailFileName ,  PDO::PARAM_STR);
                           
                                register_shutdown_function('__fatalHandler' ,  $mail);
                                $stmt->execute();

                                    // First Pair 
                                    $BENÄMNING = '';
                                    $ENHET = '';
                                    // Second Pair 
                                    $ARTIKEL = '';
                                    $LEV_ARTN_UTAN_SK = '';
                                    // Third Pair
                                    $KVANT =  '';
                                    $A_PRIS_BRUTTO = '';
                                    $ANMÄRKNING = '';
                                    $A_PRIS_NETTO  = '';
                                    $RADNETTO = ''; 
                                    $lineCnt = 0;
                            
                                }
                            

                                
                            }else if($lineCnt == 4)
                            {
                                $sql = "INSERT INTO  PDfFileData (Fakturanr,Fakt_datum,Sida,Varumottagare,supplier,SUPPORT_SALES_APPLY_PERIOD,Kundnr,Kundnman,Avtal,NAME,ENHET,ARTIKEL,LEV_ARTN_UTAN_SK,KVANT,A_PRIS_BRUTTO,A_PRIS_NETTO,RADNETTO,FileNamePDF)
                                VALUES (:Fakturanr,:Fakt_datum,:Sida,:Varumottagare,:supplier,:SUPPORT_SALES_APPLY_PERIOD,
                                :Kundnr,:Kundnman,:Avtal,:NAME,:ENHET,:ARTIKEL,:LEV_ARTN_UTAN_SK,:KVANT,:A_PRIS_BRUTTO,:A_PRIS_NETTO,:RADNETTO,:FileNamePDF)";


                                $stmt = $db->prepare($sql);

                                $stmt->bindParam(':Fakturanr', $Fakturanr ,  PDO::PARAM_STR);
                                $stmt->bindParam(':Fakt_datum', $Fakt_datum ,  PDO::PARAM_STR);
                                $stmt->bindParam(':Sida', $Sida ,  PDO::PARAM_STR);
                                $stmt->bindParam(':Varumottagare', $Varumottagare ,  PDO::PARAM_STR);
                                $stmt->bindParam(':supplier', $Vår_referens ,  PDO::PARAM_STR);
                                $stmt->bindParam(':SUPPORT_SALES_APPLY_PERIOD', $AVTALSSTÖD_FÖRSÄLJNING_GÄLLER_PERIOD ,  PDO::PARAM_STR);
                                $stmt->bindParam(':Kundnr', $Kundnr ,  PDO::PARAM_STR);
                                $stmt->bindParam(':Kundnman', $Kundnman ,  PDO::PARAM_STR);
                                $stmt->bindParam(':Avtal', $Avtal ,  PDO::PARAM_STR);
                                $stmt->bindParam(':NAME', $BENÄMNING ,  PDO::PARAM_STR);
                                $stmt->bindParam(':ENHET', $ENHET ,  PDO::PARAM_STR);
                                $stmt->bindParam(':ARTIKEL', $ARTIKEL ,  PDO::PARAM_STR);
                                $stmt->bindParam(':LEV_ARTN_UTAN_SK', $LEV_ARTN_UTAN_SK ,  PDO::PARAM_STR);
                                $stmt->bindParam(':KVANT', $KVANT ,  PDO::PARAM_STR);
                                $stmt->bindParam(':A_PRIS_BRUTTO', $A_PRIS_BRUTTO,  PDO::PARAM_STR);
                                $stmt->bindParam(':A_PRIS_NETTO', $A_PRIS_NETTO ,  PDO::PARAM_STR);
                                $stmt->bindParam(':RADNETTO', $RADNETTO ,  PDO::PARAM_STR);
                                $stmt->bindParam(':FileNamePDF', $mailFileName ,  PDO::PARAM_STR);
                                register_shutdown_function('__fatalHandler' ,  $mail);
                                $stmt->execute();
                                
                                // First Pair 
                                $BENÄMNING = '';
                                $ENHET = '';
                                // Second Pair 
                                $ARTIKEL = '';
                                $LEV_ARTN_UTAN_SK = '';
                                // Third Pair
                                $KVANT =  '';
                                $A_PRIS_BRUTTO = '';
                                $ANMÄRKNING = '';
                                $A_PRIS_NETTO  = '';
                                $RADNETTO = ''; 
                                $lineCnt = 0;
                            
                            }
                            
                            if($lineCnt == 0){
                            
                                if(trim(end($checkVal)) == 'KRT' || trim(end($checkVal)) == 'ST' || trim(end($checkVal)) == 'HINK' || trim(end($checkVal)) == 'KR' ){
                                    $ENHET = end($checkVal);
                                }
                                
                                $BENÄMNING  = trim(str_replace($ENHET , '' , $val));
                                $lineCnt = $lineCnt+ 1;
                                
                            }else if($lineCnt == 1){

                                if(trim(end($checkVal)) == 'KRT' || trim(end($checkVal)) == 'ST' || trim(end($checkVal)) == 'HINK' || trim(end($checkVal)) == 'KR'){
                                    $ENHET = end($checkVal);
                                    $lineCnt = 1;
                                }else{
                                
                                    $checkVal = array_values(array_filter($checkVal));
                                    if(count($checkVal) >= 4){
                                        $overcheck = count($checkVal)-1;
                                    
                                        $NewVal123 = end($checkVal);

                                        unset($checkVal[$overcheck]);
                                        $LEV_ARTN_UTAN_SK = end($checkVal);
                                        $overcheck = count($checkVal)-1;
                                        unset($checkVal[$overcheck]);
                                        $ARTIKEL  = implode(' ', $checkVal);
                                        $lineCnt = $lineCnt+ 1;

                                    

                                    }else {
                                        $LEV_ARTN_UTAN_SK = end($checkVal);
                                    
                                        $ARTIKEL  = trim(str_replace($LEV_ARTN_UTAN_SK , '' , $val));
                                    
                                        $lineCnt = $lineCnt+ 1;
                                    }
                                }
                            
                                
                            

                            }
                            else if($lineCnt == 2 ){
                                $countCommas = substr_count($val,",");
                            
                                if(is_numeric($checkVal[0]) && ($countCommas >= 1 && $countCommas <= 3)){
                                    
                                    $checkVal = array_values(array_filter($checkVal));
                                    $KVANT = $checkVal[0];
                                    $A_PRIS_BRUTTO = $checkVal[1];
                                    $ANMÄRKNING = '';
                                    $A_PRIS_NETTO  = isset($checkVal[2])?$checkVal[2]:'';
                                    $RADNETTO = isset($checkVal[3])?$checkVal[3] :''; 

                                }else if($NewVal123 != '' && ($countCommas >= 1 && $countCommas <= 3) )
                                {
                                    
                                    $checkVal = array_values(array_filter($checkVal));
                                    $KVANT = $NewVal123;
                                    $NewVal123 = '';
                                    $A_PRIS_BRUTTO = $checkVal[0];
                                    $ANMÄRKNING = '';
                                    $A_PRIS_NETTO  = isset($checkVal[1])?$checkVal[1]:'';
                                    $RADNETTO = isset($checkVal[2])?$checkVal[2] :''; 

                                }
                                $lineCnt = $lineCnt + 1;

                            }
                        
                        }   

                    } 
                    $lastcolumn = count($column)-1;
                    $lastVal = $column[$lastcolumn];
                    if(substr_count($lastVal , ',') == 3){
                        $sql = "INSERT INTO  PDfFileData (Fakturanr,Fakt_datum,Sida,Varumottagare,supplier,SUPPORT_SALES_APPLY_PERIOD,Kundnr,Kundnman,Avtal,NAME,ENHET,ARTIKEL,LEV_ARTN_UTAN_SK,KVANT,A_PRIS_BRUTTO,A_PRIS_NETTO,RADNETTO,FileNamePDF)
                        VALUES (:Fakturanr,:Fakt_datum,:Sida,:Varumottagare,:supplier,:SUPPORT_SALES_APPLY_PERIOD,
                        :Kundnr,:Kundnman,:Avtal,:NAME,:ENHET,:ARTIKEL,:LEV_ARTN_UTAN_SK,:KVANT,:A_PRIS_BRUTTO,:A_PRIS_NETTO,:RADNETTO,:FileNamePDF)";


                        $stmt = $db->prepare($sql);

                        $stmt->bindParam(':Fakturanr', $Fakturanr ,  PDO::PARAM_STR);
                        $stmt->bindParam(':Fakt_datum', $Fakt_datum ,  PDO::PARAM_STR);
                        $stmt->bindParam(':Sida', $Sida ,  PDO::PARAM_STR);
                        $stmt->bindParam(':Varumottagare', $Varumottagare ,  PDO::PARAM_STR);
                        $stmt->bindParam(':supplier', $Vår_referens ,  PDO::PARAM_STR);
                        $stmt->bindParam(':SUPPORT_SALES_APPLY_PERIOD', $AVTALSSTÖD_FÖRSÄLJNING_GÄLLER_PERIOD ,  PDO::PARAM_STR);
                        $stmt->bindParam(':Kundnr', $Kundnr ,  PDO::PARAM_STR);
                        $stmt->bindParam(':Kundnman', $Kundnman ,  PDO::PARAM_STR);
                        $stmt->bindParam(':Avtal', $Avtal ,  PDO::PARAM_STR);
                        $stmt->bindParam(':NAME', $BENÄMNING ,  PDO::PARAM_STR);
                        $stmt->bindParam(':ENHET', $ENHET ,  PDO::PARAM_STR);
                        $stmt->bindParam(':ARTIKEL', $ARTIKEL ,  PDO::PARAM_STR);
                        $stmt->bindParam(':LEV_ARTN_UTAN_SK', $LEV_ARTN_UTAN_SK ,  PDO::PARAM_STR);
                        $stmt->bindParam(':KVANT', $KVANT ,  PDO::PARAM_STR);
                        $stmt->bindParam(':A_PRIS_BRUTTO', $A_PRIS_BRUTTO,  PDO::PARAM_STR);
                        $stmt->bindParam(':A_PRIS_NETTO', $A_PRIS_NETTO ,  PDO::PARAM_STR);
                        $stmt->bindParam(':RADNETTO', $RADNETTO ,  PDO::PARAM_STR);
                        $stmt->bindParam(':FileNamePDF', $mailFileName ,  PDO::PARAM_STR);
                        register_shutdown_function('__fatalHandler' ,  $mail);
                        $stmt->execute();
                    }
                }
                echo "next page";
        }
        //SendMail($mail , $mailFileName);
    }
}

echo "Succesful Cron";

exit;





?>