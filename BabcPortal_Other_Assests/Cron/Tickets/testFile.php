<?php


ini_set("memory_limit", "-1");
set_time_limit(0);
ini_set('display_errors', 1);
error_reporting(E_ALL);

$DBName = 'GCS_Tickets_Portal';
$DBPass = 'gcsmakeit2010';
$DBUsername = 'jeff';
$DBHost = '10.30.57.5';
$db = new PDO("sqlsrv:Server=$DBHost;Database=$DBName;", "$DBUsername", "$DBPass");
// Throw an Exception when an error occurs
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$currentDate  = date('Y-m-d');
$start_date = '2020-03-01';
$cnt = 0;
$lastDate = '';

  // Code to empty the Table 
  $sql = "TRUNCATE TABLE  Tickets";
  $q = $db->prepare($sql);
  $q->execute();

  $sql = "TRUNCATE TABLE  TicketConversation";
  $q = $db->prepare($sql);
  $q->execute();

while($lastDate < $currentDate){
    if($lastDate == ''){
        $effectiveDate = date('Y-m-d', strtotime("+3 months", strtotime($start_date)));
        $lastDate = $effectiveDate;
    }else{
        $start_date = date('Y-m-d', strtotime($lastDate. ' + 1 days'));;
        $effectiveDate = date('Y-m-d', strtotime("+3 months", strtotime($lastDate)));
        $lastDate = $effectiveDate;
    }
       
    $check = 1;
    $i = 1;
    print_r($start_date.'<br>'); print_r($lastDate.'<br>');
    while ($check && $i <= 10) {
       
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://gcsolutionsassist.freshdesk.com/api/v2/search/tickets?query=%22created_at%20:%3E%20\''.$start_date.'\'%20AND%20created_at%20:%3C%20\''.$lastDate.'\'%22&page='.$i,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic OGJyNUVDZjE3clo4bERYa1Izb3Y6WA==',
            'Cookie: _x_w=3; _x_m=x_c'
        ),
        ));

        $response = curl_exec($curl);

        $info = curl_getinfo($curl);
        curl_close($curl);
        
        if( isset( $info['http_code']) && $info['http_code'] == '429'){
            echo "waiting tickets "; 
            sleep(60);
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://gcsolutionsassist.freshdesk.com/api/v2/search/tickets?query=%22created_at%20:%3E%20\''.$start_date.'\'%20AND%20created_at%20:%3C%20\''.$lastDate.'\'%22&page='.$i,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Basic OGJyNUVDZjE3clo4bERYa1Izb3Y6WA==',
                'Cookie: _x_w=3; _x_m=x_c'
            ),
            ));
    
            $response = curl_exec($curl);
    
            $info = curl_getinfo($curl);
            curl_close($curl);
        
        }
        $response = json_decode($response , true);
       
        if(!empty($response)){
            $i = $i+ 1;
            foreach($response['results'] as $key => $value){
                $sql = "INSERT INTO Tickets (cc_emails,fwd_emails ,reply_cc_emails,ticket_cc_emails ,fr_escalated,spam,email_config_id,group_id,priority,requester_id,responder_id,source,company_id,status,subject,association_type,support_email,to_emails,product_id,ticket_id,type,due_by,fr_due_by,is_escalated,custom_fields,created_at ,updated_at ,associated_tickets_count ,tags ,description,description_text) 
                VALUES(:cc_emails,:fwd_emails ,:reply_cc_emails,:ticket_cc_emails ,:fr_escalated,:spam,:email_config_id,:group_id,:priority,:requester_id,:responder_id,:source,:company_id,:status,:subject,:association_type,:support_email,:to_emails,:product_id,:ticket_id,:type,:due_by,:fr_due_by,:is_escalated,:custom_fields,:created_at ,:updated_at ,:associated_tickets_count ,:tags ,:description,:description_text)";
             

                $stmt = $db->prepare($sql);
               
                if(is_array($value['cc_emails'])){
                    $value['cc_emails'] = implode(',', $value['cc_emails']);
                    $stmt->bindParam(':cc_emails',$value['cc_emails'] , PDO::PARAM_STR);
                }else{
                    $stmt->bindParam(':cc_emails',$value['cc_emails'] , PDO::PARAM_STR);
                }
                if(is_array($value['fwd_emails'])){
                    $value['fwd_emails'] = implode(',', $value['fwd_emails']);
                    $stmt->bindParam(':fwd_emails',$value['fwd_emails'] , PDO::PARAM_STR);
                }else{
                    $stmt->bindParam(':fwd_emails',$value['fwd_emails'] , PDO::PARAM_STR);
                }
                if(is_array($value['reply_cc_emails'])){
                    $value['reply_cc_emails'] = implode(',', $value['reply_cc_emails']);
                    $stmt->bindParam(':reply_cc_emails',$value['reply_cc_emails'] , PDO::PARAM_STR);
                }else{
                    $stmt->bindParam(':reply_cc_emails',$value['reply_cc_emails'] , PDO::PARAM_STR);
                }
                if(is_array($value['ticket_cc_emails'])){
                    $value['ticket_cc_emails'] = implode(',', $value['ticket_cc_emails']);
                    $stmt->bindParam(':ticket_cc_emails',$value['ticket_cc_emails'] , PDO::PARAM_STR);
                }else{
                    $stmt->bindParam(':ticket_cc_emails',$value['ticket_cc_emails'] , PDO::PARAM_STR);
                }
        
                $stmt->bindParam(':fr_escalated',$value['fr_escalated'] , PDO::PARAM_STR);
                $stmt->bindParam(':spam', $value['spam'], PDO::PARAM_STR);
                $stmt->bindParam(':email_config_id', $value['email_config_id'], PDO::PARAM_STR);
                $stmt->bindParam(':group_id', $value['group_id'], PDO::PARAM_STR);
                $stmt->bindParam(':priority', $value['priority'], PDO::PARAM_STR);
                $stmt->bindParam(':requester_id', $value['requester_id'], PDO::PARAM_STR);
                $stmt->bindParam(':responder_id', $value['responder_id'], PDO::PARAM_STR);
                $stmt->bindParam(':source', $value['source'], PDO::PARAM_STR);
                if(is_array($value['custom_fields'])){
                    $value['custom_fields'] = implode(',', $value['custom_fields']);
                    $stmt->bindParam(':custom_fields', $value['custom_fields'], PDO::PARAM_STR);
                }else{
                    $stmt->bindParam(':custom_fields', $value['custom_fields'], PDO::PARAM_STR);
                }
                $stmt->bindParam(':company_id', $value['company_id'], PDO::PARAM_STR);
                $stmt->bindParam(':status', $value['status'], PDO::PARAM_STR);
                $stmt->bindParam(':subject', $value['subject'], PDO::PARAM_STR);
                $stmt->bindParam(':association_type', $value['association_type'], PDO::PARAM_STR);
                $stmt->bindParam(':support_email', $value['support_email'], PDO::PARAM_STR);
                if(is_array($value['to_emails'])){
                    $value['to_emails'] = implode(',', $value['to_emails']);
                    $stmt->bindParam(':to_emails',$value['to_emails'] , PDO::PARAM_STR);
                }else{
                    $stmt->bindParam(':to_emails',$value['to_emails'] , PDO::PARAM_STR);
                }

                $stmt->bindParam(':product_id', $value['product_id'], PDO::PARAM_STR);
                $stmt->bindParam(':ticket_id', $value['id'], PDO::PARAM_STR);
                $stmt->bindParam(':type', $value['type'], PDO::PARAM_STR);
                $stmt->bindParam(':due_by', $value['due_by'], PDO::PARAM_STR);
                $stmt->bindParam(':fr_due_by', $value['fr_due_by'], PDO::PARAM_STR);
                $stmt->bindParam(':associated_tickets_count', $value['associated_tickets_count'], PDO::PARAM_STR);
                $stmt->bindParam(':is_escalated', $value['is_escalated'], PDO::PARAM_STR);
                if(is_array($value['tags'])){
                    $value['tags'] = implode(',', $value['tags']);
                    $stmt->bindParam(':tags',$value['tags'] , PDO::PARAM_STR);
                }else{
                    $stmt->bindParam(':tags',$value['tags'] , PDO::PARAM_STR);
                }
                $stmt->bindParam(':created_at', $value['created_at'], PDO::PARAM_STR);
                $stmt->bindParam(':updated_at', $value['updated_at'], PDO::PARAM_STR);
                $stmt->bindParam(':description', $value['description'], PDO::PARAM_STR);
                $stmt->bindParam(':description_text', $value['description_text'], PDO::PARAM_STR);
        
                $stmt->execute();
                if($value['id']){
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://gcsolutionsassist.freshdesk.com/api/v2/tickets/'.$value['id'].'?include=conversations,requester,company',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Basic OGJyNUVDZjE3clo4bERYa1Izb3Y6WA=='
                        ),
                    ));
                
                    $Convo = curl_exec($curl);
                    $info = curl_getinfo($curl);
                    curl_close($curl);
                   
                    if( isset( $info['http_code']) && $info['http_code'] == '429'){
                        echo "waiting tickets "; 
                        sleep(60);
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://gcsolutionsassist.freshdesk.com/api/v2/tickets/'.$value['id'].'?include=conversations,requester,company',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                        CURLOPT_HTTPHEADER => array(
                            'Authorization: Basic OGJyNUVDZjE3clo4bERYa1Izb3Y6WA=='
                            ),
                        ));
                    
                        $Convo = curl_exec($curl);
                        $info = curl_getinfo($curl);
                        curl_close($curl);
                    }
                    $Convo = json_decode($Convo , true);
                    if($Convo){
                        $company = $Convo['company'];
                        $requester = $Convo['requester'];
                        $Convo = $Convo['conversations'];
                        foreach( $Convo as  $ConvoKey =>  $ConvoValue ){
    
                            $sql = "INSERT INTO TicketConversation (body,body_text,conversation_id ,incoming,private,user_id,support_email,source,category ,to_emails,from_email,cc_emails ,bcc_emails,email_failure_count,outgoing_failures,thread_id ,thread_message_id,created_at,updated_at ,last_edited_at,last_edited_user_id ,attachments ,automation_id  ,automation_type_id ,auto_response ,ticket_id ,source_additional_info,requester_id ,requester_name,requester_email ,requester_mobile ,requester_phone ,company_id ,company_name) 
                            VALUES( :body,:body_text,:conversation_id ,:incoming,:private,:user_id,:support_email,:source,:category ,:to_emails,:from_email,:cc_emails ,:bcc_emails,:email_failure_count,:outgoing_failures,:thread_id ,:thread_message_id,:created_at,:updated_at ,:last_edited_at,:last_edited_user_id ,:attachments ,:automation_id  ,:automation_type_id ,:auto_response ,:ticket_id ,:source_additional_info,:requester_id ,:requester_name,:requester_email ,:requester_mobile ,:requester_phone ,:company_id ,:company_name)";
                    
                            $stmt = $db->prepare($sql);
                            $stmt->bindParam(':body', $ConvoValue['body'], PDO::PARAM_STR);
                            $stmt->bindParam(':body_text', $ConvoValue['body_text'], PDO::PARAM_STR);
                            $stmt->bindParam(':conversation_id', $ConvoValue['id'], PDO::PARAM_STR);
                            $stmt->bindParam(':incoming', $ConvoValue['incoming'], PDO::PARAM_STR);
                            $stmt->bindParam(':private', $ConvoValue['private'], PDO::PARAM_STR);
                            $stmt->bindParam(':user_id', $ConvoValue['user_id'], PDO::PARAM_STR);
                            $stmt->bindParam(':support_email', $ConvoValue['support_email'], PDO::PARAM_STR);
                            $stmt->bindParam(':source', $ConvoValue['source'], PDO::PARAM_STR);
                            $stmt->bindParam(':category', $ConvoValue['category'], PDO::PARAM_STR);
                          
                            if(is_array($ConvoValue['to_emails'])){
                                $ConvoValue['to_emails'] = implode(',', $ConvoValue['to_emails']);
                                $stmt->bindParam(':to_emails', $ConvoValue['to_emails'], PDO::PARAM_STR);
                            }else{
                                $stmt->bindParam(':to_emails', $ConvoValue['to_emails'], PDO::PARAM_STR);
                            }
                            $stmt->bindParam(':from_email', $ConvoValue['from_email'], PDO::PARAM_STR);
                            
                            if(is_array($ConvoValue['cc_emails'])){
                                $ConvoValue['cc_emails'] = implode(',', $ConvoValue['cc_emails']);
                                $stmt->bindParam(':cc_emails', $ConvoValue['cc_emails'], PDO::PARAM_STR);
                            }else{
                                $stmt->bindParam(':cc_emails', $ConvoValue['cc_emails'], PDO::PARAM_STR);
                            }
                            if(is_array($ConvoValue['bcc_emails'])){
                                $ConvoValue['bcc_emails'] = implode(',', $ConvoValue['bcc_emails']);
                                $stmt->bindParam(':bcc_emails', $ConvoValue['bcc_emails'], PDO::PARAM_STR);
                            }else{
                                $stmt->bindParam(':bcc_emails', $ConvoValue['bcc_emails'], PDO::PARAM_STR);
                            }
                           
                            $stmt->bindParam(':email_failure_count', $ConvoValue['email_failure_count'], PDO::PARAM_STR);
                            $stmt->bindParam(':outgoing_failures', $ConvoValue['outgoing_failures'], PDO::PARAM_STR);
                            $stmt->bindParam(':thread_id', $ConvoValue['thread_id'], PDO::PARAM_STR);
                            $stmt->bindParam(':thread_message_id', $ConvoValue['thread_message_id'], PDO::PARAM_STR);
                            $stmt->bindParam(':created_at', $ConvoValue['created_at'], PDO::PARAM_STR);
                            $stmt->bindParam(':updated_at', $ConvoValue['updated_at'], PDO::PARAM_STR);
                            $stmt->bindParam(':last_edited_at', $ConvoValue['last_edited_at'], PDO::PARAM_STR);
                            $stmt->bindParam(':last_edited_user_id', $ConvoValue['last_edited_user_id'], PDO::PARAM_STR);
                            
                            if(is_array($ConvoValue['attachments'])){
                                $attch = '';
                                foreach($ConvoValue['attachments'] as $attchKey => $attachValue ){
                                    $attch = $attch. $attachValue['attachment_url'].',';
                                }
                                $attch = rtrim($attch , ',');
                                $stmt->bindParam(':attachments', $attch, PDO::PARAM_STR);
                            }else{
                                $stmt->bindParam(':attachments', $ConvoValue['attachments'], PDO::PARAM_STR);
                            }
                            $stmt->bindParam(':automation_id', $ConvoValue['automation_id'], PDO::PARAM_STR);
                            $stmt->bindParam(':automation_type_id', $ConvoValue['automation_type_id'], PDO::PARAM_STR);
                            $stmt->bindParam(':auto_response', $ConvoValue['auto_response'], PDO::PARAM_STR);
                            $stmt->bindParam(':ticket_id', $ConvoValue['ticket_id'], PDO::PARAM_STR);
                            $stmt->bindParam(':source_additional_info', $ConvoValue['source_additional_info'], PDO::PARAM_STR);
    
                            //  Requester  INfo 
                            $stmt->bindParam(':requester_id', $requester['id'], PDO::PARAM_STR);
                            $stmt->bindParam(':requester_name', $requester['name'], PDO::PARAM_STR);
                            $stmt->bindParam(':requester_email', $requester['email'], PDO::PARAM_STR);
                            $stmt->bindParam(':requester_mobile', $requester['mobile'], PDO::PARAM_STR);
                            $stmt->bindParam(':requester_phone', $requester['phone'], PDO::PARAM_STR);
                                // COmpany INfo 
                            $stmt->bindParam(':company_id', $company['id'], PDO::PARAM_STR);
                            $stmt->bindParam(':company_name', $company['name'], PDO::PARAM_STR);
                            $stmt->execute();
                        }
                    }
                   

                }//END for ID check 

            }// For loop for tickets 
            
        }else{
            $check = 0;
            break;
        }
    }// while Loop
}// outer while 

echo "data Uploaded ";




    