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

    
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://gcsolutionsassist.freshdesk.com/api/v2/companies',
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

    $response = curl_exec($curl);
    $response =json_decode( $response , true);
    curl_close($curl);
    
    if(isset($response['message']) && $response['message'] == 'You have exceeded the limit of requests per hour' ){
        echo "You have exceeded the limit of requests per hour"; 
        exit;
    }else{
        $sql = "TRUNCATE TABLE  Companies";
        $q = $db->prepare($sql);
        $q->execute();

        $check = 1;
        $i = 1;
        while ($check) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://gcsolutionsassist.freshdesk.com/api/v2/companies?per_page=100&page='.$i,
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

            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);
        
            if( isset( $info['http_code']) && $info['http_code'] == '429'){
                echo "waiting Contacts "; 
                sleep(60);
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://gcsolutionsassist.freshdesk.com/api/v2/companies?per_page=100&page='.$i,
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
            
                $response = curl_exec($curl);
                $info = curl_getinfo($curl);
                curl_close($curl);
            }

            $response = json_decode($response , true);

            if(!empty($response)){
                $i = $i+ 1;
                foreach($response as $key => $value){
                    $sql = "INSERT INTO Companies(  company_id ,name,description,note,domains,created_at,updated_at,custom_fields ,health_score,account_tier,renewal_date,industry) 
                    VALUES( :company_id ,:name, :description,:note,:domains,:created_at,:updated_at,:custom_fields ,:health_score,:account_tier,:renewal_date,:industry)";
            
                    $stmt = $db->prepare($sql);
                    
                    $stmt->bindParam(':company_id',$value['id'] , PDO::PARAM_STR);
                    $stmt->bindParam(':name', $value['name'], PDO::PARAM_STR);
                    $stmt->bindParam(':description', $value['description'], PDO::PARAM_STR);
                    $stmt->bindParam(':note', $value['note'], PDO::PARAM_STR);
                    if(is_array($value['domains'])){
                        $value['domains'] = implode(',', $value['domains']);
                        $stmt->bindParam(':domains', $value['domains'], PDO::PARAM_STR);
                    }else{
                        $stmt->bindParam(':domains', $value['domains'], PDO::PARAM_STR);
                    }
                
                    $stmt->bindParam(':created_at', $value['created_at'], PDO::PARAM_STR);
                    $stmt->bindParam(':updated_at', $value['created_at'], PDO::PARAM_STR);
                    if(is_array($value['custom_fields'])){
                        $value['custom_fields'] = implode(',', $value['custom_fields']);
                        $stmt->bindParam(':custom_fields', $value['custom_fields'], PDO::PARAM_STR);
                    }else{
                        $stmt->bindParam(':custom_fields', $value['custom_fields'], PDO::PARAM_STR);
                    }
                    $stmt->bindParam(':health_score', $value['health_score'], PDO::PARAM_STR);
                    $stmt->bindParam(':account_tier', $value['account_tier'], PDO::PARAM_STR);
                    $stmt->bindParam(':renewal_date', $value['renewal_date'], PDO::PARAM_STR);
                    $stmt->bindParam(':industry', $value['industry'], PDO::PARAM_STR);
                    $stmt->execute();
                }
            }else{
                $check = 0;
                break;
            }
            
        }
        echo " All Compies Added "; 

        // Code to empty the Table 
        $sql = "TRUNCATE TABLE  Contacts";
        $q = $db->prepare($sql);
        $q->execute();

        $check = 1;
        $i = 1;
        while ($check) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://gcsolutionsassist.freshdesk.com/api/v2/contacts?per_page=100&page='.$i,
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

            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);
        
            if( isset( $info['http_code']) && $info['http_code'] == '429'){
                echo "waiting Contacts "; 
                sleep(60);
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://gcsolutionsassist.freshdesk.com/api/v2/contacts?per_page=100&page='.$i,
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
            
                $response = curl_exec($curl);
                $info = curl_getinfo($curl);
                curl_close($curl);
            }

            $response = json_decode($response , true);
            if(!empty($response)){
                $i = $i+ 1;
                foreach($response as $key => $value){
                $sql = "INSERT INTO Contacts(active,company_id,address ,description,email,contact_id,job_title,language,mobile,name,phone,time_zone,twitter_id,custom_fields,facebook_id,created_at,updated_at,csat_rating,preferred_source) 
                VALUES(:active,:company_id,:address ,:description,:email,:contact_id,:job_title,:language,:mobile,:name,:phone,:time_zone,:twitter_id,:custom_fields,:facebook_id,:created_at,:updated_at,:csat_rating,:preferred_source)";
        
                $stmt = $db->prepare($sql);

                $stmt->bindParam(':contact_id',$value['id'] , PDO::PARAM_STR);
                $stmt->bindParam(':name', $value['name'], PDO::PARAM_STR);
                $stmt->bindParam(':description', $value['description'], PDO::PARAM_STR);
                $stmt->bindParam(':active', $value['active'], PDO::PARAM_STR);
                $stmt->bindParam(':address', $value['address'], PDO::PARAM_STR);
                $stmt->bindParam(':email', $value['email'], PDO::PARAM_STR);
                $stmt->bindParam(':created_at', $value['created_at'], PDO::PARAM_STR);
                $stmt->bindParam(':updated_at', $value['created_at'], PDO::PARAM_STR);
                if(is_array($value['custom_fields'])){
                    $value['custom_fields'] = implode(',', $value['custom_fields']);
                    $stmt->bindParam(':custom_fields', $value['custom_fields'], PDO::PARAM_STR);
                }else{
                    $stmt->bindParam(':custom_fields', $value['custom_fields'], PDO::PARAM_STR);
                }
                $stmt->bindParam(':job_title', $value['job_title'], PDO::PARAM_STR);
                $stmt->bindParam(':language', $value['language'], PDO::PARAM_STR);
                $stmt->bindParam(':mobile', $value['mobile'], PDO::PARAM_STR);
                $stmt->bindParam(':phone', $value['phone'], PDO::PARAM_STR);
                $stmt->bindParam(':time_zone', $value['time_zone'], PDO::PARAM_STR);
                $stmt->bindParam(':facebook_id', $value['facebook_id'], PDO::PARAM_STR);
                $stmt->bindParam(':twitter_id', $value['twitter_id'], PDO::PARAM_STR);
                $stmt->bindParam(':csat_rating', $value['csat_rating'], PDO::PARAM_STR);
                $stmt->bindParam(':preferred_source', $value['preferred_source'], PDO::PARAM_STR);
                $stmt->bindParam(':company_id', $value['company_id'], PDO::PARAM_STR);
        
                $stmt->execute();
                }
            }else{
                $check = 0;
                break;
            }
        }
        echo "Contacts  Added "; 

        $currentDate  = date('Y-m-d');
        $start_date = '2020-03-01';

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
        echo "Tickets  Added "; 

        // Groups 

        // Code to empty the Table 
        $sql = "TRUNCATE TABLE Groups";
        $q = $db->prepare($sql);
        $q->execute();
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://gcsolutionsassist.freshdesk.com/api/v2/groups',
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

        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
    
        if( isset( $info['http_code']) && $info['http_code'] == '429'){
            echo "waiting Groups "; 
            sleep(60);
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://gcsolutionsassist.freshdesk.com/api/v2/groups',
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
        
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);
        }

        $response = json_decode($response , true);
    
        if(!empty($response)){
            
            foreach($response as $key => $value){
                $sql = "INSERT INTO Groups(group_id,group_name,description,escalate_to,unassigned_for,business_hour_id,group_type,created_at,updated_at) 
                VALUES(:group_id,:group_name,:description,:escalate_to,:unassigned_for,:business_hour_id,:group_type,:created_at,:updated_at)";

                $stmt = $db->prepare($sql);

                
                $stmt->bindParam(':group_id',$value['id'] , PDO::PARAM_STR);
                $stmt->bindParam(':group_name', $value['name'], PDO::PARAM_STR);
                $stmt->bindParam(':description', $value['description'], PDO::PARAM_STR);
                $stmt->bindParam(':escalate_to', $value['escalate_to'], PDO::PARAM_STR);
                $stmt->bindParam(':unassigned_for', $value['unassigned_for'], PDO::PARAM_STR);
                $stmt->bindParam(':business_hour_id', $value['business_hour_id'], PDO::PARAM_STR);
                $stmt->bindParam(':group_type', $value['group_type'], PDO::PARAM_STR);
                $stmt->bindParam(':created_at', $value['created_at'], PDO::PARAM_STR);
                $stmt->bindParam(':updated_at', $value['created_at'], PDO::PARAM_STR);

                $stmt->execute();
            }
        }
        echo " Groups  Added "; 

        // Agents 

        // Code to empty the Table 
        $sql = "TRUNCATE TABLE Agents";
        $q = $db->prepare($sql);
        $q->execute();
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://gcsolutionsassist.freshdesk.com/api/v2/agents',
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

        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
    
        if( isset( $info['http_code']) && $info['http_code'] == '429'){
            echo "waiting Agents "; 
            sleep(60);
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://gcsolutionsassist.freshdesk.com/api/v2/agents',
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
        
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);
        }

        $response = json_decode($response , true);
        if(!empty($response)){
            
            foreach($response as $key => $value){
                $sql = "INSERT INTO Agents(available,occasional,agent_id ,ticket_scope,created_at,updated_at,last_active_at,available_since,type,contact_active,contact_email,contact_job_title,contact_language,contact_last_login_at,contact_mobile,contact_name,contact_phone,contact_time_zone,contact_created_at,contact_updated_at,signature) 
                VALUES(:available,:occasional,:agent_id ,:ticket_scope,:created_at,:updated_at,:last_active_at,:available_since,:type,:contact_active,:contact_email,:contact_job_title,:contact_language,:contact_last_login_at,:contact_mobile,:contact_name,:contact_phone,:contact_time_zone,:contact_created_at,:contact_updated_at,:signature)";

                $stmt = $db->prepare($sql);

                $stmt->bindParam(':available',$value['available'] , PDO::PARAM_STR);
                $stmt->bindParam(':occasional', $value['occasional'], PDO::PARAM_STR);
                $stmt->bindParam(':agent_id', $value['id'], PDO::PARAM_STR);
                $stmt->bindParam(':ticket_scope', $value['ticket_scope'], PDO::PARAM_STR);
                $stmt->bindParam(':created_at', $value['created_at'], PDO::PARAM_STR);
                $stmt->bindParam(':updated_at', $value['updated_at'], PDO::PARAM_STR);
                $stmt->bindParam(':last_active_at', $value['last_active_at'], PDO::PARAM_STR);
                $stmt->bindParam(':available_since', $value['available_since'], PDO::PARAM_STR);
                $stmt->bindParam(':type', $value['type'], PDO::PARAM_STR);
                $stmt->bindParam(':contact_active', $value['contact']['active'], PDO::PARAM_STR);
                $stmt->bindParam(':contact_email', $value['contact']['email'], PDO::PARAM_STR);
                $stmt->bindParam(':contact_job_title', $value['contact']['job_title'], PDO::PARAM_STR);
                $stmt->bindParam(':contact_language', $value['contact']['language'], PDO::PARAM_STR);
                $stmt->bindParam(':contact_last_login_at', $value['contact']['last_login_at'], PDO::PARAM_STR);
                $stmt->bindParam(':contact_mobile', $value['contact']['mobile'], PDO::PARAM_STR);
                $stmt->bindParam(':contact_name', $value['contact']['name'], PDO::PARAM_STR);
                $stmt->bindParam(':contact_phone', $value['contact']['phone'], PDO::PARAM_STR);
                $stmt->bindParam(':contact_time_zone', $value['contact']['time_zone'], PDO::PARAM_STR);
                $stmt->bindParam(':contact_created_at', $value['contact']['created_at'], PDO::PARAM_STR);
                $stmt->bindParam(':contact_updated_at', $value['contact']['updated_at'], PDO::PARAM_STR);
                $stmt->bindParam(':signature', $value['signature'], PDO::PARAM_STR);
        

                $stmt->execute();
            }
        }
        echo " Agents  Added "; 
    }
    exit;


?>