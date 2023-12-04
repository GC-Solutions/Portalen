<?php
ini_set("memory_limit", "-1");
set_time_limit(0);
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Include Composer autoloader if not already done.

 $db = new PDO("sqlsrv:Server=10.30.57.5;Database=BABC_Saljpartner;", "jeff", "gcsmakeit2010");
 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = " select artikelnr  , bestnr from artikel  where bestnr != ''";
$stmt = $db->query( $sql);
$Users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$db = new PDO("sqlsrv:Server=10.30.57.5;Database=BP_Saljpartner;", "jeff", "gcsmakeit2010");
 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "select DISTINCT ID , Fakturanr , Fakt_datum , Sida , Varumottagare , 'Martin&Servera' as Customer ,supplier,   SUPPORT_SALES_APPLY_PERIOD,         Kundnr,       Kundnman    ,   Avtal       ,NAME     ,   ENHET       , CASE  WHEN LEFT(RIGHT(ARTIKEL,2),1)=' ' THEN REPLACE(ARTIKEL, RIGHT(ARTIKEL,1),'') ELSE ARTIKEL     END as ARTIKEL       , CASE          WHEN LEFT(RIGHT(ARTIKEL,2),1)=' ' THEN RIGHT(ARTIKEL,1)         ELSE ''     END as FLAGA,     LEV_ARTN_UTAN_SK   ,    KVANT       ,REPLACE(A_PRIS_BRUTTO,',','.') as A_PRIS_BRUTTO ,  REPLACE(A_PRIS_NETTO,',','.') as A_PRIS_NETTO       ,  REPLACE(RADNETTO,',','.') as RADNETTO  from PDfFileData  ";
$stmt = $db->query( $sql);
$PDFData = $stmt->fetchAll(PDO::FETCH_ASSOC);




$sql = "select DISTINCT ID,Fakturanr,Fakt_datum,Sida,Varumottagare , 'Menigo' as Customer , supplier,    SUPPORT_SALES_APPLY_PERIOD         ,Kundnr       ,Kundnman       ,Avtal       , NAME        ,ENHET       , CASE  WHEN LEFT(RIGHT(ARTIKEL,2),1)=' ' THEN REPLACE(ARTIKEL, RIGHT(ARTIKEL,1),'') ELSE ARTIKEL     END as ARTIKEL       , CASE          WHEN LEFT(RIGHT(ARTIKEL,2),1)=' ' THEN RIGHT(ARTIKEL,1)         ELSE ''     END as FLAGA,      LEV_ARTN_UTAN_SK       ,KVANT       ,REPLACE(A_PRIS_BRUTTO,',','.') as A_PRIS_BRUTTO ,  REPLACE(A_PRIS_NETTO,',','.') as A_PRIS_NETTO       ,  REPLACE(RADNETTO,',','.') as RADNETTO  from ExcelFileData ";
$stmt = $db->query( $sql);
$ExcelData = $stmt->fetchAll(PDO::FETCH_ASSOC);


foreach($Users as $key1 => $val1){
    foreach($PDFData as $key => $val){
       
        if(trim($val['ARTIKEL']) == trim($val1['bestnr'])){
            $sql = "update PDfFileData set Artikel_nr = '".$val1['artikelnr']."' where ID = '".$val['ID']."'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
          
        }
    }
}
foreach($Users as $key1 => $val1){
    foreach($ExcelData as $key => $val){
       
        if(trim($val['ARTIKEL']) == trim($val1['bestnr'])){
            $sql = "update ExcelFileData set Artikel_nr = '".$val1['artikelnr']."' where ID = '".$val['ID']."'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
          
        }
    }
}


echo "Data Updated ";
exit;





?>