<?php
ini_set('memory_limit', '200G');
ini_set('display_errors', 1);
error_reporting(E_ALL);
$row = 1;
$var = [];

            
if (($handle = fopen("csv/Kopia.csv", "r")) !== FALSE) {
   
    while (($data = fgetcsv($handle, 10000, ',')) !== FALSE) {
       
       
        $num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
       	
        if($row == '2')
        {
        	
        	$sql = "Insert into Selected_Brands (" ;
        	$temp = "";
        	
        	for ($c=0; $c < $num; $c++) {
        		$sql .= trim(str_replace('"', '', $data[$c])).',';
            	
            	array_push($var, $data[$c]);
            	
        	}
        	
        	$sql = rtrim($sql , ",");
        
        	$sql = $sql ." ) VALUES " ;
        	
        }else{
        	$sql = $sql ." (" ;
        	for ($c=0; $c < count($data); $c++) {
        		 
        		$sql .=  "'".str_replace("'", "", $data[$c])."',";  		
        		
        		
        	}
        	$sql = rtrim($sql , ",");
        
        	$sql = $sql ." ) ," ;
        	//break;
        }


    }
    fclose($handle);
  
    $sql = rtrim($sql , ",");

	$db = new PDO("sqlsrv:Server=212.247.32.103;Database=BP_SelectedBrands;", "jeff", "gcsmakeit2010");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
    $data = $db->exec($sql);
	   if($data)
	   {
	   	echo"data Uploaded";
	   }
   
}
?>

