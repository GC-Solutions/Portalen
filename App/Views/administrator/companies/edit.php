<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_start.php'; ?>

<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_menu.php'; ?>
    <div class="page-container">
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/side_bar.php'; ?>
    <div class="page-content-wrapper">
    <div class="page-content">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card card-box">
                <div class="card-head">
                    <header><?= $getCompanyDetails[0]['CompanyName']; ?></header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>updatecompany" method="post" id="form_sample_1"
                          class="form-horizontal" enctype="multipart/form-data">
                        <input type="hidden" name="CompanyID" value="<?= $getCompanyDetails[0]['CompanyID']; ?>">

                        <div class="form-body">
                            <div class="form-group row">
                                <label class="control-label col-md-3">Company ID
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="company_id" data-required="1"
                                           value="<?= $getCompanyDetails[0]['CompanyID']; ?>" disabled required
                                           class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">Company Name
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="CompanyName" required
                                           value="<?= $getCompanyDetails[0]['CompanyName']; ?>" data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">GIS Key
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="CompanyGISKey" required
                                           value="<?= $getCompanyDetails[0]['CompanyGISKey']; ?>" 
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">GIS Token
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="CompanyGISToken" required
                                           value="<?= $getCompanyDetails[0]['CompanyGISToken']; ?>" 
                                           class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">BABCDB
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="CompanyBABCDb" required
                                           value="<?= $getCompanyDetails[0]['CompanyBABCDb']; ?>" data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                    <label class="control-label col-md-3">BPDB
                                        <span class="required"> * </span>
                                    </label>

                                    <div class="col-md-4">
                                        <input type="text" name="CompanyBPDb" required
                                               value="<?= $getCompanyDetails[0]['CompanyBPDb']; ?>" data-required="1"
                                               class="form-control"/>
                                    </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Allow  Company Folder 
                                </label>

                                <div class="col-md-1">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" >
                                            <?php
                                            $AllowCompanyFolder = (isset($getCompanyDetails[0]["AllowCompanyFolder"])) ? $getCompanyDetails[0]["AllowCompanyFolder"] : 0;
                                            $checked = "";
                                            if ($AllowCompanyFolder) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="AllowCompanyFolder" id="AllowCompanyFolder" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                        <div class="form-group row">
                            <label class="control-label col-md-3">
                                Use this FTP to Upload Image  
                            </label>
                            <div class="col-md-4">
                                <input type="text" name="FTPCredential" 
                                       value="<?= $getCompanyDetails[0]['FTPCredential']; ?>" 
                                       class="form-control"/>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3">
                                Use this SFTP to Upload Image  
                            </label>
                            <div class="col-md-4">
                                <input type="text" name="SFTPCredential" 
                                       value="<?= $getCompanyDetails[0]['SFTPCredential']; ?>" 
                                       class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">
                                Upload the PEM file   
                            </label>
                            <div class="col-md-4">
                                <input type="file" name="SFTPKeys" id="SFTPKeys">
                                
                            </div>
                        </div>
                                
                                <?php 
                                  $keyVal = 0;
                                if (isset($getCompanyDetails[0]['CompanyHostName'])){
                                                                      $getCompanyDetails[0]['CompanyHostName'] = json_decode($getCompanyDetails[0]['CompanyHostName'], true);
                                    if( $getCompanyDetails[0]['CompanyHostName']) { 
                                    foreach ( $getCompanyDetails[0]['CompanyHostName'] as $key => $value) { 
                                          
                                        ?>
                                        <div id="Maindiv<?= $key; ?>">
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">DB Crediendtials
                                            </label>

                                            <div class="col-md-4">
                                                <input type="text" id="CompanyHostName<?= $key; ?>" name="CompanyHostName<?= $key; ?>"
                                                       value="<?php if(isset($value[0])) echo $value[0]; ?>" 
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                    <div class="form-group row">
                                    <label class="control-label col-md-3">
                                        DB Type 
                                        <span class="required"> * </span>
                                    </label>

                                    <div class="col-md-4">
                                        <?php
                                        $DBType = (isset($getCompanyDetails[0]['DBType'])) ? json_decode($getCompanyDetails[0]['DBType'], true) : "";
                                        
                                        if(isset($DBType[$key])){
                                            $DBType = $DBType[$key];
                                            $DBType[0] = isset($DBType[$key])?$DBType[$key]:'';
                                        }else
                                        {
                                             $DBType[0] ='';
                                        }
                                        ?>
                                        <select name="DBType<?= $key; ?>" id="DBType<?= $key; ?>" class="form-control" >
                                            <option value=""> Select</option>
                                            <option value="sqlsrv" <?php if ($DBType[0] == 'sqlsrv') {
                                                echo "selected='selected'";
                                            } ?>>SQL SERVER
                                            </option>
                                            <option value="mysql" <?php if ($DBType[0] == 'mysql') {
                                                echo "selected='selected'";
                                            } ?>>MY SQL
                                            </option>
                                             <option value="pgsql" <?php if ($DBType[0] == 'pgsql') {
                                                echo "selected='selected'";
                                            } ?>>Postgre SQL
                                            </option>
                                              <option value="mongodb" <?php if ($DBType[0] == 'mongodb') {
                                                echo "selected='selected'";
                                            } ?>>MongoDb
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-md-3">
                                    </label>

                                    <div class="col-md-4">
                                        <input type="button"  onclick="deleteRowDatabtn('<?= $key; ?>');" value= "Delete DB"/>
                                    </div>
                            </div>
                                   </div>  
                                <?php   $keyVal = $key ;  }  }
                                } ?>
                               
                               
                              
                              
                         
                           
                            <div class="form-group row" id="orderRowDatabtndiv">
                                    <label class="control-label col-md-3">
                                    </label>

                                    <div class="col-md-4">
                                        <input type="button" id="orderRowDatabtn" onlick="duplicate();" value= "Add More DB"/>
                                       
                                    </div>
                            </div>
                            <?php 
                                
                                $keyVal = 0;
                                if (isset($getCompanyDetails[0]['AdminDb'])){
                                    $getCompanyDetails[0]['AdminDb'] = json_decode($getCompanyDetails[0]['AdminDb'], true);
                                } if($getCompanyDetails[0]['AdminDb']){
                                    foreach ( $getCompanyDetails[0]['AdminDb'] as $key => $value) {
                            ?>
                             <div id="MainAdminDBdiv<?= $key; ?>">
                                <div class="form-group row">

                                    <label class="control-label col-md-3">AdminDB
                                    </label>

                                    <div class="col-md-4" id="dropDB<?= $key; ?>">
                                         <select id ="AdminDbDrop<?= $key; ?>" name="AdminDbDrop<?= $key; ?>"  class="form-control" >
                                            <option value=""> Select</option>
                                            <?php 
                                            if($getAllAdminDB){
                                                foreach($getAllAdminDB as $adminDBKey => $adminDBVal){?>
                                                <option value="<?= $adminDBVal['ID']?>" <?php if ( isset($value[0]) && $value[0] ==  $adminDBVal['ID']) {
                                                    echo "selected='selected'";
                                                } ?>> <?= $adminDBVal['Name']?>
                                                </option>
                                            <?php } } ?>
                                            
                                        </select>

                                    </div>

                                </div>
                            </div>
                            <?php }} ?>

                            <div class="form-group row" id ="adminDBbtndiv">
                                    <label class="control-label col-md-3">
                                    </label>

                                    <div class="col-md-4">
                                        <input type="button"  onclick="adminDBbtn(<?= $keyVal ?>);" value= "Add More AdminDB "/>
                                    </div>
                            </div>
                            
                                 <?php 
                                   $keyVal = 0;
                                 if (isset($getCompanyDetails[0]['CompanyDBPass'])){

                                  
                                    $getCompanyDetails[0]['CompanyDBPass'] = json_decode($getCompanyDetails[0]['CompanyDBPass'], true);
                                    if($getCompanyDetails[0]['CompanyDBPass']){
                                    foreach ( $getCompanyDetails[0]['CompanyDBPass'] as $key => $value) { 
                                          
                                        ?>
                                <div id="MainAPIdiv<?= $key; ?>">
                                <div class="form-group row">

                                    <label class="control-label col-md-3">API Address 
                                    </label>

                                    <div class="col-md-4" id="dropD<?= $key; ?>">
                                         <select id ="CompanyDBPassDrop<?= $key; ?>" name="CompanyDBPassDrop<?= $key; ?>" onchange="nameLinkData(<?= $key; ?>)" class="form-control" >
                                            <option value=""> Select</option>
                                            <?php 
                                            if($getAllAddress){
                                                foreach($getAllAddress as $addressKey => $addresVal){?>
                                                <option value="<?= $addresVal['Address']?>" <?php if ( isset($value[0]) && $value[0] ==  $addresVal['Address']) {
                                                    echo "selected='selected'";
                                                } ?>> <?= $addresVal['AddressName']?>
                                                </option>
                                            <?php } } ?>
                                            
                                        </select>

                                    </div>

                                    <div class="col-md-4" id="dropDr<?= $key; ?>">
                                         <input type="button" onClick="showData(<?= $key; ?>);" value= "Add Custom Fields"/>
                                    </div>  

                                    <?php 
                                    $varble = '';
                                    if( isset($value[0]) ){
                                    foreach ($getAllAddress as $getAllAddresskey => $getAllAddressvalue) {
                                        if($value[0] == $getAllAddressvalue['Address']){
                                            $varble = 'Yes';
                                            Break;
                                        }
                                        
                                     } 
                                     if( $varble == '')
                                     {
                                        $varble = $value[0];
                                    }else{
                                        $varble = '';
                                    }
                                         
                                     }
                                    
                                   
                                    ?>
                                    <div class="col-md-4"  id="fields<?= $key; ?>" style="display: none;">
                                        <input type="text"  name="CompanyDBPassField<?= $key; ?>" 
                                               value="<?php echo $varble; ?>" 
                                               class="form-control"/>
                                      
                                    </div>
                                    
                                </div>
                                <?php $DatsourceLinkName = (isset($getCompanyDetails[0]['DatsourceLinkName'])) ? json_decode($getCompanyDetails[0]['DatsourceLinkName'], true) : "";
                                    $DatsourceLinkName = isset($DatsourceLinkName[$key])?$DatsourceLinkName[$key]:''; ?>
                                <div class="form-group row"  style="display: none"  id="linkName<?= $key; ?>" >
                                    <label class="control-label col-md-3">Linking Name at Datsource 
                                    </label>

                                    <div class="col-md-4">
                                        <input type="text" name="DatsourceLinkName<?= $key; ?>"  id= "DatsourceLinkName<?= $key; ?>"
                                               value="<?php  if(isset($DatsourceLinkName[0])) echo $DatsourceLinkName[0]; ?>" 
                                               class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">API Params 
                                    </label>
                                    <?php $CompanyDBUserName = (isset($getCompanyDetails[0]['CompanyDBUserName'])) ? json_decode($getCompanyDetails[0]['CompanyDBUserName'], true) : "";
                                        if(!isset($CompanyDBUserName[$key]))
                                        {
                                            $CompanyDBUserName[0] = '';
                                        }else
                                            $CompanyDBUserName = $CompanyDBUserName[$key]; ?>
                                    <div class="col-md-4">
                                        <input type="text" name="CompanyDBUserName<?= $key; ?>" 
                                               value="<?php if(isset($CompanyDBUserName[0])) echo $CompanyDBUserName[0]; ?>" 
                                               class="form-control"/>
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="control-label col-md-3">
                                    </label>

                                    <div class="col-md-4">
                                        <input type="button"  onclick="deleteAPIDatabtn('<?= $key; ?>');" value= "Delete API"/>
                                    </div>
                            </div>
                             </div>
                                <?php $keyVal = $key ; }
                                }} ?>
                           
                            <div class="form-group row" id ="orderAPIDatabtndiv">
                                    <label class="control-label col-md-3">
                                    </label>

                                    <div class="col-md-4">
                                        <input type="button"  onclick="orderAPIDatabtn(<?= $keyVal ?>);" value= "Add More API "/>
                                    </div>
                            </div>
                            <div class="form-group row" id ="directPaymentBtnDiv">
                                    <label class="control-label col-md-3">
                                    </label>
                                    <div class="col-md-4">
                                        <input type="button"  onclick="directPaymentBtn();" value= "Add SEPA DIRECT PAYMENT "/>
                                    </div>
                            </div>
                            <?php  if(!empty($getCompanyDetails[0]['AccountHolderName'])) { ?>
                                <div id ='directPayment' >
                            <?php }else{ ?>
                                <div id ='directPayment' style="display:none">
                            <?php } ?>
                           
                                <div class="form-group row">
                                    <label class="control-label col-md-3">Account Holder Name
                                        <span class="required"> * </span>
                                    </label>

                                    <div class="col-md-4">
                                        <input type="text" name="AccountHolderName" maxlength="70" value = "<?= $getCompanyDetails[0]['AccountHolderName'] ?>"
                                            class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">IBAN Number 
                                        <span class="required"> * </span>
                                    </label>

                                    <div class="col-md-4">
                                        <input type="text" name="IBANNumber" value = "<?= $getCompanyDetails[0]['IBANNumber'] ?>"
                                            class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">BIC Number 
                                        <span class="required"> * </span>
                                    </label>

                                    <div class="col-md-4">
                                        <input type="text" name="BICNumber" value = "<?= $getCompanyDetails[0]['BICNumber'] ?>"
                                            class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">Creditor ID
                                        <span class="required"> * </span>
                                    </label>

                                    <div class="col-md-4">
                                        <input type="text" name="CreditorID" value = "<?= $getCompanyDetails[0]['CreditorID'] ?>"
                                            class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">Org ID
                                    </label>

                                    <div class="col-md-4">
                                        <input type="text" name="OrgId" value = "<?= $getCompanyDetails[0]['OrgId'] ?>"
                                            class="form-control"/>
                                    </div>   
                                    <div class="col-md-4">
                                        <div class="checkboxes" >
                                        <?php
                                            $EnableOrgId = (isset($getCompanyDetails[0]['EnableOrgId'])) ? $getCompanyDetails[0]['EnableOrgId'] : 0;
                                            $checked = "";
                                            if ($EnableOrgId ) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="EnableOrgId" value="1"/>
                                            </label>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">End to End
                                       
                                    </label>

                                    <div class="col-md-4">
                                        <input type="text" name="EndtoEndId" value = "<?= $getCompanyDetails[0]['EndtoEndId'] ?>"
                                            class="form-control"/>
                                    </div>   
                                    <div class="col-md-4">
                                        <div class="checkboxes" >
                                        <?php
                                            $EnableEndtoEndId = (isset($getCompanyDetails[0]['EnableEndtoEndId'])) ? $getCompanyDetails[0]['EnableEndtoEndId'] : 0;
                                            $checked = "";
                                            if ($EnableEndtoEndId ) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="EnableEndtoEndId" value="1"/>
                                            </label>
                                            
                                        </div>
                                    </div>
                                  
                                </div>
                                
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">Start Date
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                <div class='input-group date' id='datetimepicker3'>
                                        <input type='text'  size="16" class="form-control" name="CompanyStartDate" value="<?= $getCompanyDetails[0]['CompanyStartDate']; ?>" />
                                        <span class="input-group-addon">
                                            <!-- <span class="glyphicon glyphicon-calendar"></span> -->
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">End Date
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                               
                                    <div class='input-group date' id='datetimepicker2'>
                                        <input type='text'  size="16" class="form-control" name="CompanyEndDate" value="<?= $getCompanyDetails[0]['CompanyEndDate']; ?>" />
                                        <span class="input-group-addon">
                                            <!-- <span class="glyphicon glyphicon-calendar"></span> -->
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">Company Email
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="CompanyEmail"
                                           value="<?= $getCompanyDetails[0]['CompanyEmail']; ?>" required
                                           data-required="1" class="form-control"/>
                                </div>
                            </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">
                                Allow Other Company User
                            </label>

                            <div class="col-md-1">
                                <div class="col-md-12 padding_none">
                                    <div class="checkboxes" >
                                        <?php
                                        $AllowOtherCompanyUser = (isset($getCompanyDetails[0]["AllowOtherCompanyUser"])) ? $getCompanyDetails[0]["AllowOtherCompanyUser"] : 0;
                                        $checked = "";
                                        if ($AllowOtherCompanyUser) {
                                            $checked = "checked='checked'";
                                        }
                                        ?>
                                        <label>
                                            <input type="checkbox" <?= $checked; ?> name="AllowOtherCompanyUser" id="AllowOtherCompanyUser" value="1"/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">
                               Enable Redis on This company Users
                            </label>

                            <div class="col-md-1">
                                <div class="col-md-12 padding_none">
                                    <div class="checkboxes" >
                                        <?php
                                        $EnableRedisCompany = (isset($getCompanyDetails[0]["EnableRedisCompany"])) ? $getCompanyDetails[0]["EnableRedisCompany"] : 0;
                                        $checked = "";
                                        if ($EnableRedisCompany) {
                                            $checked = "checked='checked'";
                                        }
                                        ?>
                                        <label>
                                            <input type="checkbox" <?= $checked; ?> name="EnableRedisCompany" id="EnableRedisCompany" value="1" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">
                                Enable Selective table for redis 
                            </label>

                            <div class="col-md-1">
                                <div class="col-md-12 padding_none">
                                    <div class="checkboxes" >
                                        <?php
                                        $TableSelectionCompany = (isset($getCompanyDetails[0]["TableSelectionCompany"])) ? $getCompanyDetails[0]["TableSelectionCompany"] : 0;
                                        $checked = "";
                                        if ($TableSelectionCompany) {
                                            $checked = "checked='checked'";
                                        }
                                        ?>
                                        <label>
                                            <input type="checkbox" <?= $checked; ?> name="TableSelectionCompany" id="TableSelectionCompany" value="1"/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3"> Time Duration for Redis to be Active on SQL 
                            </label>
                            
                            <div class="col-md-4">
                                <input type="text" name="TimeDurationRedisCompany" id="TimeDurationRedisCompany"  value="<?php if(!empty($getCompanyDetails[0]['TimeDurationRedisCompany'])){echo $getCompanyDetails[0]['TimeDurationRedisCompany'];} ?>" class="form-control"/>
                                
                            </div>
                                
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3"> Time Clock  for Redis to be Active on SQL 
                            </label>
                            
                            <div class="col-md-4">
                                <input type="text" name="TimeRedisCompany" id="TimeRedisCompany"  value="<?php if(!empty($getCompanyDetails[0]['TimeRedisCompany'])){echo $getCompanyDetails[0]['TimeRedisCompany'];} ?>" class="form-control"/>
                                
                            </div>
                                
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">
                                Disable Redis for API Data
                            </label>

                            <div class="col-md-1">
                                <div class="col-md-12 padding_none">
                                    <div class="checkboxes" >
                                        <?php
                                        $DisableAPIDataRedisCompany = (isset($getCompanyDetails[0]["DisableAPIDataRedisCompany"])) ? $getCompanyDetails[0]["DisableAPIDataRedisCompany"] : 0;
                                        $checked = "";
                                        if ($DisableAPIDataRedisCompany) {
                                            $checked = "checked='checked'";
                                        }
                                        ?>
                                        <label>
                                            <input type="checkbox" <?= $checked; ?> name="DisableAPIDataRedisCompany" id="DisableAPIDataRedisCompany" value="1"/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3"> Time Duration for Redis to be Active on API 
                            </label>
                            
                            <div class="col-md-4">
                                <input type="text" name="TimeDurationRedisCompanyAPI" id="TimeDurationRedisCompanyAPI"  value="<?php if(!empty($getCompanyDetails[0]['TimeDurationRedisCompanyAPI'])){echo $getCompanyDetails[0]['TimeDurationRedisCompanyAPI'];} ?>" class="form-control"/>
                                
                            </div>
                                
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3"> Time CLock  for Redis to be Active on API 
                            </label>
                            
                            <div class="col-md-4">
                                <input type="text" name="TimeRedisCompanyAPI" id="TimeRedisCompanyAPI"  value="<?php if(!empty($getCompanyDetails[0]['TimeRedisCompanyAPI'])){echo $getCompanyDetails[0]['TimeRedisCompanyAPI'];} ?>" class="form-control"/>
                                
                            </div>
                                
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">
                                Enable Fresh Desk 
                            </label>

                            <div class="col-md-1">
                                <div class="col-md-12 padding_none">
                                    <div class="checkboxes" >
                                        <?php
                                        $EnableFreshDesk = (isset($getCompanyDetails[0]["EnableFreshDesk"])) ? $getCompanyDetails[0]["EnableFreshDesk"] : 0;
                                        $checked = "";
                                        if ($EnableFreshDesk) {
                                            $checked = "checked='checked'";
                                        }
                                        ?>
                                        <label>
                                            <input type="checkbox" <?= $checked; ?> name="EnableFreshDesk" id="EnableFreshDesk" value="1"  onchange="showFreshDeskCompany('freshDeskCompany')"/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div  id='freshDeskCompany' style ='display:none;'>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Select All  Fresh Desk  Company 
                                </label>

                                <div class="col-md-1">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" >
                                            <?php
                                            $selectAllFreshDeskCompany = (isset($getCompanyDetails[0]["selectAllFreshDeskCompany"])) ? $getCompanyDetails[0]["selectAllFreshDeskCompany"] : 0;
                                            $checked = "";
                                            if ($selectAllFreshDeskCompany) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="selectAllFreshDeskCompany" id="selectAllFreshDeskCompany" value="1" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Select Specfic Fresh Desk Company
                                </label>

                                <div class="col-md-1">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" >
                                            <?php
                                            $selectspecficFreshDeskCompany = (isset($getCompanyDetails[0]["selectspecficFreshDeskCompany"])) ? $getCompanyDetails[0]["selectspecficFreshDeskCompany"] : 0;
                                            $checked = "";
                                            if ($selectspecficFreshDeskCompany) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="selectspecficFreshDeskCompany" id="selectspecficFreshDeskCompany" value="1"  onchange="showFreshDeskCompany('freshDeskCompanyss')"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row" id='freshDeskCompanyss' style ='display:none;' >
                                <label class="control-label col-md-3">
                                    FreshDesk  Comapnies
                                </label>
                                <label class="col-md-4">
                                        <select name="FreshDeskCompany[]" id="FreshDeskCompanys"
                                                class="form-control select2-multiple dataSourceColumns" data-reorder="1" multiple >
                                            <option value="">Select</option>
                                            <?php 
                                                $FreshDeskCompany = isset($getCompanyDetails[0]['FreshDeskCompany'])?$getCompanyDetails[0]['FreshDeskCompany']:array();
                                                if ($FreshDeskCompany) {
                                                    $FreshDeskCompany = explode(',', $FreshDeskCompany);
                                                }
                                                foreach ($getFreshDeskCompanies as $key => $value) {
                                                    $selected = "";
                                                    if (!empty($FreshDeskCompany) && in_array($value['company_id'], $FreshDeskCompany)) {
                                                        $selected = 'selected="selected"';
                                                    }
                                                    echo '<option value= "' . $value['company_id'] . '"' . $selected . '>' . $value['name'] . '</option>';
                                                }
                                                
                                                ?>
                                            
                                        </select>
                                    </label>          
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Enable private Msgs
                                </label>

                                <div class="col-md-1">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" >
                                            <?php
                                            $EnablePrivateMsg = (isset($getCompanyDetails[0]["EnablePrivateMsg"])) ? $getCompanyDetails[0]["EnablePrivateMsg"] : 0;
                                            $checked = "";
                                            if ($EnablePrivateMsg) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="EnablePrivateMsg" id="EnablePrivateMsg" value="1" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">
                               Enable Saving Data in json File 
                            </label>

                            <div class="col-md-1">
                                <div class="col-md-12 padding_none">
                                    <div class="checkboxes" >
                                        <?php
                                        $EnablejsonSaveDataAllUser = (isset($getCompanyDetails[0]["EnablejsonSaveDataAllUser"])) ? $getCompanyDetails[0]["EnablejsonSaveDataAllUser"] : 0;
                                        $checked = "";
                                        if ($EnablejsonSaveDataAllUser) {
                                            $checked = "checked='checked'";
                                        }
                                        ?>
                                        <label>
                                            <input type="checkbox" <?= $checked; ?> name="EnablejsonSaveDataAllUser" id="EnablejsonSaveDataAllUser" value="1"/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3"> Time Duration for Json File Update  (reprat after 00:20 min )
                            </label>
                            
                            <div class="col-md-4">
                                <input type="text" name="TimeDurationJson" id="TimeDurationJson"  value="<?php if(!empty($getCompanyDetails[0]['TimeDurationJson'])){echo $getCompanyDetails[0]['TimeDurationJson'];} ?>" class="form-control"/>
                                
                            </div>
                                
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3"> Time  for Json File Update (Time should be in hours like ,00:04 oclock) 
                            </label>
                            
                            <div class="col-md-4">
                                <input type="text" name="TimeJson" id="TimeJson"  value="<?php if(!empty($getCompanyDetails[0]['TimeJson'])){echo $getCompanyDetails[0]['TimeJson'];} ?>" class="form-control"/>
                                
                            </div>
                                
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">
                                Allow google Analytics 
                            </label>

                            <div class="col-md-1">
                                <div class="col-md-12 padding_none">
                                    <div class="checkboxes" >
                                        <?php
                                        $APIOption = (isset($getCompanyDetails[0]["APIOption"])) ? $getCompanyDetails[0]["APIOption"] : 0;
                                        $checked = "";
                                        if ($APIOption) {
                                            $checked = "checked='checked'";
                                        }
                                        ?>
                                        <label>
                                            <input type="checkbox" <?= $checked; ?> name="APIOption" id="APIOption" value="1"/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" id = "googleApiURLButton" style="display: none">
                               <button class="btn btn-info" onclick="copyToClipboard('#googleApiURL')">Copy Link </button> 
                            </div>
                        </div>
                            <input type="hidden" id="googleApiURL" name="googleApiURL" value="http://www.babcnew.com/generateAccessToken?Id=<?= base64_encode($getCompanyDetails[0]['CompanyID']); ?>" >

                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">
                                 
                            </label>
                            <div class="col-md-4">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-info">
                                        Save <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <a class="btn deepPink-bgcolor"
                                       href="<?php echo baseUrl; ?>editcompany?id=<?= $_REQUEST['id']; ?>">Cancel
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">

<?php 
      
      if ( isset($getCompanyDetails[0]["EnableFreshDesk"]) &&  $getCompanyDetails[0]['EnableFreshDesk'] == '1') {?>
          $('#freshDeskCompany').show();
<?php }  ?>

<?php 
      
      if ( isset($getCompanyDetails[0]["EnableFreshDesk"]) &&  $getCompanyDetails[0]['EnableFreshDesk'] == '1' &&  isset($getCompanyDetails[0]["selectspecficFreshDeskCompany"]) &&  $getCompanyDetails[0]['selectspecficFreshDeskCompany'] == '1' ) {?>
          $('#freshDeskCompanyss').show();
<?php }  ?>

function directPaymentBtn(){
    $("#directPayment").show(); 
}
function showFreshDeskCompany(box) {
    var chboxs = document.getElementById(box).style.display;
    var vis = "none";
        if(chboxs=="none"){
         vis = "block"; }
        if(chboxs=="block"){
         vis = "none"; }
    document.getElementById(box).style.display = vis;
}
function showData(id){

        $("#fields"+id).show();  
        $("#linkName"+id).show(); 
        $("#dropD"+id).hide();
        $("#dropDr"+id).hide();
        $('#CompanyDBPassDrop'+id).val('');
        
    
}


$("#APIOption").click(function () {
        if ($(this).is(":checked")) {
           $('#googleApiURLButton').show();
        } else {
            $('#googleApiURLButton').hide();
        }
});

function copyToClipboard() {

  var element = $('#googleApiURL').val();
  
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val(element).select();
  document.execCommand("copy");
  $temp.remove();
}
function nameLinkData(id){
    
       var dropdown = document.getElementById("CompanyDBPassDrop"+id);
       
        var selectedOption = dropdown.options[dropdown.selectedIndex];
        console.log(selectedOption.text);
        $('#DatsourceLinkName'+id).val(selectedOption.text);
        console.log($('#DatsourceLinkName'+id).val());
        
      
        
}

 var i = 0;

function deleteRowDatabtn(id){
    
    $('#Maindiv'+id).remove();
   
 
}

function deleteAPIDatabtn(id){
   
    $('#MainAPIdiv'+id).remove();
}


$('#orderRowDatabtn').click(function(event) {
                   
                  
                    var original = document.getElementById('Maindiv'+i);
                   
                    var text = document.createElement('div');
                    text.id = "Maindiv" + ++i;
                    var val = '';
                    
                    val += '<div class="form-group row"><label class="control-label col-md-3">DB Crediendtials '+i+'                                  </label> <div class="col-md-4"> <input type="text" name="CompanyHostName'+i+'"    value=""                        class="form-control"/>                                                    </div></div><div class="form-group row"> <label class="control-label col-md-3"> DB Type'+i+' <span class="required"> * </span> </label> <div class="col-md-4"> <?php
                                        $DBType = (isset($getCompanyDetails[0]["DBType"])) ? $getCompanyDetails[0]["DBType"] : "";
                                        ?>
                                        <select name="DBType'+i+'" class="form-control" >                                            <option value=""> Select</option>                                            <option value="sqlsrv" >SQL SERVER </option><option value="mysql" >MY SQL </option>                                             <option value="pgsql" >Postgre SQL                                           </option>   <option value="mongodb" >MongoDb                                            </option>                                      </select>        </div>                               </div><div class="form-group row">                                    <label class="control-label col-md-3">                                    </label>                                    <div class="col-md-4">                                        <input type="button"  onclick="deleteRowDatabtn('+i+');" value= "Delete DB"                                 </div>                          </div> ';                
                    
                        text.innerHTML =val;
                        if(original == null)
                        {
                            $( "#orderRowDatabtndiv" ).before(text);
                            
                        }else{
                            original.after(text);
                        }
                    
                });  

var j = 0;
function orderAPIDatabtn(id){
        
                    
                    if( j== 0 ){
                        j = id;
                    }
                   
                    var original = document.getElementById('MainAPIdiv'+j);
                    var text = document.createElement('div');
                    text.id = "MainAPIdiv" + ++j;
                    var val = '';
                    
                    val += '  <div class="form-group row">                                    <label class="control-label col-md-3">API Address '+j+'                              </label>  <div class="col-md-4" id="dropD'+j+'">                  <select id ="CompanyDBPassDrop'+j+'" name="CompanyDBPassDrop'+j+'" onchange="nameLinkData('+j+')" class="form-control">                                            <option value=""> Select</option>                                            <?php 
                                            if($getAllAddress){
                                                foreach($getAllAddress as $addressKey => $addresVal){?>
                                                <option value="<?= $addresVal['Address']?>" > <?= $addresVal['AddressName']?>
                                                </option>                                            <?php } } ?>'+                        
                                            '</select>               </div>                                    <div class="col-md-4" id="dropDr'+j+'">                                         <input type="button" onClick="showData('+j+');" value= "Add Custom Fields"/>                                    </div>                                      <div class="col-md-4"  id="fields'+j+'" style="display: none;">                                        <input type="text"  name="CompanyDBPassField'+j+'"    value=""                                                class="form-control"/>                               </div>                                </div> <div class="form-group row" style="display: none"  id="linkName'+j+'">                                    <label class="control-label col-md-3">Linking Name at Datsource'+j+'                                    </label>                                    <div class="col-md-4">                                        <input type="text" name="DatsourceLinkName'+j+'"       id="DatsourceLinkName'+j+'"                                         value=""                                                class="form-control"/>                                    </div>                                </div>                    <div class="form-group row">                                    <label class="control-label col-md-3">API Params'+j+' </label>                                    <div class="col-md-4">                                        <input type="text" name="CompanyDBUserName'+j+'"                                                value=""    class="form-control"/> </div>                                </div><div class="form-group row">                                    <label class="control-label col-md-3">                                    </label>                                    <div class="col-md-4">   <input type="button"  onclick="deleteAPIDatabtn('+j+');" value= "Delete API"/>                                   </div>                            </div> ';                
                    
                    text.innerHTML =val;
           
                    if(original == null)
                    {
                        $( "#orderAPIDatabtndiv" ).before(text);
                        
                    }else{
                        original.after(text);
                    }
                }  

var k = 0;
function adminDBbtn(id){
             
                    if( k== 0 ){
                        k = id;
                    }
                   
                    var original = document.getElementById('MainAdminDBdiv'+k);
                    var text = document.createElement('div');
                    text.id = "MainAdminDBdiv" + ++k;
                    var val = '';
                    
                    val += '<div class="form-group row">                                    <label class="control-label col-md-3">AdminDB '+k+'                              </label>  <div class="col-md-4" id="dropDB'+k+'">                  <select id ="AdminDbDrop'+k+'" name="AdminDbDrop'+k+'" class="form-control">                                            <option value=""> Select</option>                          <?php  
                         if($getAllAdminDB){   
                          foreach($getAllAdminDB as $adminDBKey => $adminDBVal){ ?> <option value=<?= $adminDBVal["ID"]?>><?= $adminDBVal["Name"]?></option> <?php } } ?>    </select>  </div>';                
                    
                    text.innerHTML =val;
           
                    if(original == null)
                    {
                        $( "#adminDBbtndiv" ).before(text);
                        
                    }else{
                        original.after(text);
                    }
                }                  


</script>
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>