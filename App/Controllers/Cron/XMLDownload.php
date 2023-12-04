<?php

namespace App\Controllers\Cron;

use \App\Models\User;
use \App\Models\Page;
use \App\Models\Companies;

use PDO;

class XMLDownload extends \Core\Controller
{
    public static  function XMLDownload()
    {

       
        $debName = '';
        $xml_contents = '';
        $placeholderId = '';
       
        
       
        if(isset($_POST['data'][0])){
          $_SESSION['XMLUserName']=$_POST['data'][0];
          $debName =  $_POST['data'][0];
         
        }

          if(isset($_SESSION['XMLUserName']) && !isset($_POST['data'][0])){
              $debName = $_SESSION['XMLUserName'];
              
              unset($_SESSION['XMLUserName']);
           
          }
      
        

         
        $query = "Select * from  SepaCustomerPayment where ID =  '". $debName ."'"; 
        $getCustomerPayment =  User::executeQuery($query, $_SESSION['BPDB'],'');
        
        if(empty($getCustomerPayment[0]['XMLString'])){

            $getCompanyDetails = Companies::getCompaniesDetails($_SESSION['UserID']); 
          
            $MsgId = substr(strtoupper(md5(microtime(true).mt_Rand())) , 0 , 35);
            $curr_date = date('Y-m-d H:i:s');
            
            $prce = (int)$getCustomerPayment[0]['Price'];
            $CtrlSum =  str_replace('.00', '', number_format($prce, 2, '.', '')); 
            $accHName = $_SESSION['AccountHolderName'];
            $PmtInfId = substr(strtoupper(md5(microtime(true).mt_Rand())) , 0 , 35);
            $SeqTp = $getCustomerPayment[0]['Mandate_Type'];
            $ReqdColltnDt = $getCustomerPayment[0]['Execution_Date'];
            $iban = $_SESSION['IBANNumber'];
            $Ccy = $getCustomerPayment[0]['Payment_Type'];
            $bic = $_SESSION['BICNumber'];
            //$EndToEndId = substr('NOTPROVIDED'. strtoupper(md5(microtime(true).mt_Rand())) , 0 , 35);
            $MndtId = substr($getCustomerPayment[0]['Mandate_Reference'], 0 , 35);
            $DtOfSgntr = $getCustomerPayment[0]['Date_Of_Signature'];
            $cdtID = $_SESSION['CreditorID'];
            $customerName = $getCustomerPayment[0]['DebtorName'];
            $customerIban = $getCustomerPayment[0]['Customer_IBAN'];
            $purpose = substr($getCustomerPayment[0]['Purpose'] , 0, 140 );
            $customerBic = $getCustomerPayment[0]['Customer_BIC'];
            $Created_Invoice = str_replace('+00:00', 'Z', gmdate('c', strtotime($getCustomerPayment[0]['Created_Invoice'])));
            $EndToEndId =  substr($getCustomerPayment[0]['EndToEndID'] , 0 , 35);
            $OrgId =  $getCompanyDetails[0]['OrgId'];
            

            $xml_contents = '<?xml version="1.0" encoding="utf-8"?><Document xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="urn:iso:std:iso:20022:tech:xsd:pain.008.001.02">
              <CstmrDrctDbtInitn>
                <GrpHdr>
                  <MsgId>'.$MsgId .'</MsgId>
                  <CreDtTm>'. $Created_Invoice.'</CreDtTm>
                  <NbOfTxs>1</NbOfTxs>
                  <CtrlSum>'.$CtrlSum.'</CtrlSum>
                  <InitgPty>
                    <Nm>'.$accHName.'</Nm>';
            
              if($getCompanyDetails[0]['EnableOrgId']){
                    $xml_contents .='<Id>
                    <OrgId>
                        <Othr>
                            <Id>'. $OrgId.'</Id>
                            <SchmeNm>
                                <Cd>CUST</Cd>
                            </SchmeNm>
                        </Othr>
                    </OrgId>
                  </Id>';
             }

            $xml_contents .= '</InitgPty>
                </GrpHdr>
                <PmtInf>
                  <PmtInfId>'.$PmtInfId.'</PmtInfId>
                  <PmtMtd>DD</PmtMtd>
                  <NbOfTxs>1</NbOfTxs>
                  <CtrlSum>'.$CtrlSum.'</CtrlSum>
                  <PmtTpInf>
                    <SvcLvl>
                      <Cd>SEPA</Cd>
                    </SvcLvl>
                    <LclInstrm>
                      <Cd>B2B</Cd>
                    </LclInstrm>
                    <SeqTp>'.$SeqTp.'</SeqTp>
                  </PmtTpInf>
                  <ReqdColltnDt>'.$ReqdColltnDt.'</ReqdColltnDt>
                  <Cdtr>
                    <Nm>'.$accHName.'</Nm>
                  </Cdtr>
                  <CdtrAcct>
                    <Id>
                      <IBAN>'.$iban .'</IBAN>
                    </Id>
                    <Ccy>'.$Ccy.'</Ccy>
                  </CdtrAcct>
                  <CdtrAgt>
                    <FinInstnId>
                      <BIC>'. $bic.'</BIC>
                    </FinInstnId>
                  </CdtrAgt>
                  <ChrgBr>SLEV</ChrgBr>
                  <DrctDbtTxInf> 
                  <PmtId>
                        <EndToEndId>'.$EndToEndId.'</EndToEndId>
                    </PmtId>
                  <InstdAmt Ccy="'.$Ccy.'">'.$CtrlSum.'</InstdAmt>
                    <DrctDbtTx>
                      <MndtRltdInf>
                        <MndtId>'.$MndtId.'</MndtId>
                        <DtOfSgntr>'.$DtOfSgntr.'</DtOfSgntr>
                      </MndtRltdInf>
                      <CdtrSchmeId>
                        <Id>
                          <PrvtId>
                            <Othr>
                              <Id>'.$cdtID.'</Id>
                              <SchmeNm>
                                <Prtry>SEPA</Prtry>
                              </SchmeNm>
                            </Othr>
                          </PrvtId>
                        </Id>
                      </CdtrSchmeId>
                    </DrctDbtTx>
                    <DbtrAgt>
                      <FinInstnId>
                        <BIC>'.$customerBic.'</BIC>
                      </FinInstnId>
                    </DbtrAgt>
                    <Dbtr>
                      <Nm>'.$customerName.'</Nm>
                    </Dbtr>
                    <DbtrAcct>
                      <Id>
                        <IBAN>'.$customerIban.'</IBAN>
                      </Id>
                    </DbtrAcct>
                    <RmtInf>
                      <Ustrd>'.$purpose.'</Ustrd>
                    </RmtInf>
                  </DrctDbtTxInf>
                </PmtInf>
              </CstmrDrctDbtInitn>
            </Document>';
         
            $query = "Update  SepaCustomerPayment set  XMLString = '".$xml_contents."' where ID = '".$debName."'";
            $retrunVal = User::AddQuery($query, $_SESSION['BPDB']);

        }else{
            $xml_contents = $getCustomerPayment[0]['XMLString'];

        }
        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename="Invoice.xml"');

        echo $xml_contents;

    
    }
    

}
