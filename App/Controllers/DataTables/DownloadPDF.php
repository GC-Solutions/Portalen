<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Models\Page;
/**
 * DownloadPDF controller
 *
 * PHP version 7.0
 This file contain a function that  will generate the PDF and Download it 
 */


class DownloadPDF extends \Core\Controller
{
    // code to download the PDF
    public function downloadPdfAction()
    {
        set_time_limit(0);
        ini_set('memory_limit', '2G');
        //$postData = $_REQUEST['params'];
        // (Start) If Data is being posted to generate a pdf and download it 
        if($_REQUEST) {
            // variable Declaration and initialization 
            $placeholderId = (isset($_REQUEST['dataSourceId'])) ? $_REQUEST['dataSourceId'] : "";
            $InvoiceNo = (isset($_REQUEST['InvoiceNo'])) ? $_REQUEST['InvoiceNo'] : "";
            $getPlaceholderDetails = Page::getDatasourceDetailsById($placeholderId);
            //(Start) if placeholder detal for Table is fetched 
           
            if ($getPlaceholderDetails) {
                // Variable Declaration and initialization 
                $getSourceType = $getPlaceholderDetails[0]['SourceAddress'];
                $requestType = $getPlaceholderDetails[0]['RequestType'];
                $requestBody = $getPlaceholderDetails[0]['Body'];
                // replace Invoice number with the actual number in request Url .
                $requestUrl = str_replace("(InvoiceNo)", $InvoiceNo, $getSourceType);
                if ($requestUrl) {
                    $gcsCustomer = $requestUrl;
                    // (Start) Curl request 
                    // Initialize Curl 
                    $ch = curl_init();
                    // Curl option for herder , body and url for requesting the data 
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_NOBODY, false);
                    curl_setopt($ch, CURLOPT_URL, $gcsCustomer);
                    // In case of post Request need to send the body and header so setting the Curl Options here 
                    if ($requestType && $requestType == 2) {
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    }
                    // Curl option for Timeout if reponse is not given 
                    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
                    // Transfer back of data is set true .
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $results = curl_exec($ch);
                    curl_close($ch); // Close the Curl 
                    
                    // (End) Curl request 
                    //(Start) if Data is Fetched from Curl requested
                    if ($results) {
                        // Decode the data from json to array so processing can be done on it .
                        $decodedResults = json_decode($results, true);
                        $base64Data = $decodedResults['Result']['PdfBase64String'];
                        if(isset($base64Data)){
                            // performing a base 64 decode 
                            $decoded = base64_decode($base64Data);
                            $file = 'invoice.pdf'; // File name
                            // add all the decoded data to that file 
                            file_put_contents($file, $decoded);
                            // Setting the heder of the file and it will allow it to download s
                            if (file_exists($file)) {
                                header('Content-Description: File Transfer');
                                header('Content-Type: application/pdf');
                                header('Content-Disposition: attachment; filename="'.basename($file).'"');
                                header('Expires: 0');
                                header('Cache-Control: must-revalidate');
                                header('Pragma: public');
                                header('Content-Length: ' . filesize($file));
                                readfile($file);
                                exit;
                            }
                        }  else {
                            echo "<script>alert('No Invoice Present');</script>";
                            $path = $_REQUEST['currLoc'];
                            header("Location: ".$path);
                            exit;
                           // echo "<script>window.close();</script>";
                        }
                    }
                     //(End) if Data is Fetched from Curl requested
                }
            }
            //(End) if placeholder detal for Table is fetched 
        }
        // (End) If Data is being posted to generate a pdf and download it 
    }
}

?>