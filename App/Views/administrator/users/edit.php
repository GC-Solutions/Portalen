<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_start.php'; ?>

<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_menu.php'; ?>
    <div class="page-container">
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/side_bar.php'; ?>
    <div class="page-content-wrapper">
    <div class="page-content">
    <!-- <div class="page-bar">
        <div class="page-title-breadcrumb">
            <div class=" pull-left">
                <div class="page-title">Edit Company User</div>
            </div>
        </div>
    </div> -->


    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card card-box">
                <div class="card-head">
                    <header>Edit Company User</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>updateUser" method="post" id="form_sample_1"
                          class="form-horizontal">
                        <div class="form-body">
                            <input type="hidden" value="<?php echo $_REQUEST['companyId']; ?>" name="CompanyID">
                            <input type="hidden" value="<?php echo $getUserDetails[0]['UserID']; ?>" name="UserID">

                            <div class="form-group row">
                                <label class="control-label col-md-3">Name
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="UserFirstName"
                                           value="<?php echo $getUserDetails[0]['UserFirstName']; ?>" required
                                           data-required="1" class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">Lastname
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="UserLastName" required
                                           value="<?php echo $getUserDetails[0]['UserLastName']; ?>"
                                           data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">DB Param
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="DBParam"                     value="<?php echo $getUserDetails[0]['DBParam']; ?>"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">API Param
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="APIParam"                     value="<?php echo $getUserDetails[0]['APIParam']; ?>"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                   Do Not Use Company DBparma for all user  
                                </label>
                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id ='ChangeChkBox'>
                                            <?php
                                            $AllowParentDBParam = (isset($getUserDetails[0]["AllowParentDBParam"])) ? $getUserDetails[0]["AllowParentDBParam"] : 0;
                                            $checked = "";
                                            if ($AllowParentDBParam) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="AllowParentDBParam" id ="AllowParentDBParam"
                                                       value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="control-label col-md-3">
                                   Do Not Use Company APIparma for all user  
                                </label>
                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id ='ChangeChkBox'>
                                            <?php
                                            $AllowParentAPIParam = (isset($getUserDetails[0]["AllowParentAPIParam"])) ? $getUserDetails[0]["AllowParentAPIParam"] : 0;
                                            $checked = "";
                                            if ($AllowParentAPIParam) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="AllowParentAPIParam" id ="AllowParentAPIParam"
                                                       value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Make this User a group user  
                                </label>
                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id ='ChangeChkBox'>
                                            <?php
                                            $UserGroupFlag = (isset($getUserDetails[0]["UserGroupFlag"])) ? $getUserDetails[0]["UserGroupFlag"] : 0;
                                            $checked = "";
                                            if ($UserGroupFlag) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="UserGroupFlag"
                                                       value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                   Want to use group User   
                                </label>
                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id ='ChangeChkBox'>
                                            <?php
                                            $UserGroupActiveFlag = (isset($getUserDetails[0]["UserGroupActiveFlag"])) ? $getUserDetails[0]["UserGroupActiveFlag"] : 0;
                                            $checked = "";
                                            if ($UserGroupActiveFlag) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="UserGroupActiveFlag"
                                                       value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Available Group to Join
                                </label>

                                <div class="col-md-4">
                                    <select name="AvailableUserGroup[]" id="multiple"
                                            class="form-control select2-multiple AvailableUserGroup" data-reorder="1" multiple>
                                        <option value="">Select</option>
                                        <?php  if (!empty($getUserGroup)) {
                                            $AvailableUserGroup = (!empty($getUserDetails[0]['AvailableUserGroup'])) ? $getUserDetails[0]['AvailableUserGroup'] : array();
                                            if ($AvailableUserGroup) {
                                                $AvailableUserGroup = explode(',', $AvailableUserGroup);
                                            }
                                            
                                            $getUserGroup = explode(',', $getUserGroup);
                                          

                                            if ($getUserGroup) {
                                                foreach ($getUserGroup as $key => $value) {
                                                    $selected = "";
                                                    
                                                    if (in_array($value, $AvailableUserGroup)) {
                                                        $selected = 'selected="selected"';
                                                    }
                                                    $value = trim($value);
                                                    echo '<option value="' . $value . '"' . $selected . '>' . $value . '</option>';
                                                }
                                            } ?>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                  Turn off the direct Login   
                                </label>
                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id ='ChangeChkBox'>
                                            <?php
                                            $DefaultLogin = (isset($getUserDetails[0]["DefaultLogin"])) ? $getUserDetails[0]["DefaultLogin"] : 0;
                                            $checked = "";
                                            if ($DefaultLogin) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="DefaultLogin"
                                                       value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                  Enable Save Filter for this user 
                                </label>
                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id ='SaveFilterBTN'>
                                            <?php
                                            $SaveFilterBTN = (isset($getUserDetails[0]["SaveFilterBTN"])) ? $getUserDetails[0]["SaveFilterBTN"] : 1;
                                            $checked = "";
                                            if ($SaveFilterBTN) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="SaveFilterBTN"
                                                       value="1"/>
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
                                                <input type='text'  size="16" class="form-control" name="UserStartDate" value="<?php echo $getUserDetails[0]['UserStartDate']; ?>" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                        </div>
                                    <input type="hidden" id="dtp_input2"
                                           value="<?php echo $getUserDetails[0]['UserStartDate']; ?>"/>
                                    <br/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">End Date
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    
                                    <div class='input-group date' id='datetimepicker2'>
                                                <input type='text'  size="16" class="form-control" name="UserEndDate" value="<?php echo $getUserDetails[0]['UserEndDate']; ?>" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                    <input type="hidden" id="dtp_input2"
                                           value="<?php echo $getUserDetails[0]['UserEndDate']; ?>"/>
                                    <br/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">Authotization
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="Auth" id="Auth"  value="<?php if(!empty($getUserDetails[0]['Auth'])){echo $getUserDetails[0]['Auth'];}else{print_r(base64_encode($getUserDetails[0]['UserEmail'].':'.$getUserDetails[0]['UserPassword']));} ?>"
                                           class="form-control"/>
                                    <div class="btn-group">
                                            <input type="button"  class="btn btn-info" onclick="keyGen()" value="Generate Auth Key ">
                                            
                                        </div>
                                </div>
                                 
                            </div>
                           
                            <div class="form-group row">
                                <label class="control-label col-md-3">Email
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="email" name="UserEmail"  id="UserEmail"
                                           value="<?php echo $getUserDetails[0]['UserEmail']; ?>" data-required="1"
                                           required class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">Password
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="password" name="UserPassword"  id="UserPassword"
                                           value="<?php echo $getUserDetails[0]['UserPassword']; ?>" required
                                           data-required="1" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">User Role
                                    
                                </label>

                                <div class="col-md-4">
                                    <?php
                                        $UserRole = $getUserDetails[0]['UserRole'];
                                    ?>
                                    <select name="UserRole" class="form-control UserRole" >
                                        <option value=""> Select</option>
                                        <option value="1" <?php if ($UserRole == 1) {
                                            echo "selected='selected'";
                                        } ?>>Admin 
                                        </option>
                                        <option value="2" <?php if ($UserRole == 2) {
                                            echo "selected='selected'";
                                        } ?>>User 
                                        </option>
                                    </select>
                                </div>
                            </div>

                           

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Allow Redis 
                                </label>

                                <div class="col-md-1">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" >
                                            <?php
                                            $EnableCacheUser = (isset($getUserDetails[0]["EnableCacheUser"])) ? $getUserDetails[0]["EnableCacheUser"] : 0;
                                            $checked = "";
                                            if ($EnableCacheUser) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="EnableCacheUser" id="EnableCacheUser" value="1"/>
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
                                            $TableSelection = (isset($getUserDetails[0]["TableSelection"])) ? $getUserDetails[0]["TableSelection"] : 0;
                                            $checked = "";
                                            if ($TableSelection) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="TableSelection" id="TableSelection" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3"> Time Duration for Redis to be Active on SQL 
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="TimeDurationRedisUser" id="TimeDurationRedisUser"  value="<?php if(!empty($getUserDetails[0]['TimeDurationRedisUser'])){echo $getUserDetails[0]['TimeDurationRedisUser'];} ?>" class="form-control"/>
                                    
                                </div>
                                 
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3"> Time CLock  for Redis to be Active on SQL 
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="TimeRedisUser" id="TimeRedisUser"  value="<?php if(!empty($getUserDetails[0]['TimeRedisUser'])){echo $getUserDetails[0]['TimeRedisUser'];} ?>" class="form-control"/>
                                    
                                </div>
                                 
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Disable Redis Saving API Data 
                                </label>

                                <div class="col-md-1">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" >
                                            <?php
                                            $DisableAPIDataRedisUser = (isset($getUserDetails[0]["DisableAPIDataRedisUser"])) ? $getUserDetails[0]["DisableAPIDataRedisUser"] : 0;
                                            $checked = "";
                                            if ($DisableAPIDataRedisUser) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="DisableAPIDataRedisUser" id="DisableAPIDataRedisUser" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3"> Time Duration for Redis to be Active on API 
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="TimeDurationRedisUserAPI" id="TimeDurationRedisUserAPI"  value="<?php if(!empty($getUserDetails[0]['TimeDurationRedisUserAPI'])){echo $getUserDetails[0]['TimeDurationRedisUserAPI'];} ?>" class="form-control"/>
                                    
                                </div>
                                 
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3"> Time CLock  for Redis to be Active on API 
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="TimeRedisUserAPI" id="TimeRedisUserAPI"  value="<?php if(!empty($getUserDetails[0]['TimeRedisUserAPI'])){echo $getUserDetails[0]['TimeRedisUserAPI'];} ?>" class="form-control"/>
                                    
                                </div>
                                 
                            </div>
                            
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Over Write Company Redis Setting with User Redis setting 
                                </label>

                                <div class="col-md-1">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" >
                                            <?php
                                            $OverwirteCompanySetting = (isset($getUserDetails[0]["OverwirteCompanySetting"])) ? $getUserDetails[0]["OverwirteCompanySetting"] : 0;
                                            $checked = "";
                                            if ($OverwirteCompanySetting) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="OverwirteCompanySetting" id="OverwirteCompanySetting" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Over Write Company and User Redis Setting with Table Redis setting 
                                </label>

                                <div class="col-md-1">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" >
                                            <?php
                                            $OverwirteUserAndCompanySetting = (isset($getUserDetails[0]["OverwirteUserAndCompanySetting"])) ? $getUserDetails[0]["OverwirteUserAndCompanySetting"] : 0;
                                            $checked = "";
                                            if ($OverwirteUserAndCompanySetting) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="OverwirteUserAndCompanySetting" id="OverwirteUserAndCompanySetting" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Allow Notification
                                </label>

                                <div class="col-md-1">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" >
                                            <?php
                                            $AllowNotification = (isset($getUserDetails[0]["AllowNotification"])) ? $getUserDetails[0]["AllowNotification"] : 0;
                                            $checked = "";
                                            if ($AllowNotification) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="AllowNotification" id="AllowNotification" value="1"  onchange="showNotification('pushNotification')"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                            <div id="pushNotification" style ='display:none;'>
                                <div class="form-group row"  >
                                        <label class="control-label col-md-3">
                                            Notifications 
                                        </label>
                                        <div class="col-md-4">
                                                <select name="SelectedNotification[]" id="SelectedNotification"
                                                        class="form-control select2-multiple dataSourceColumns" data-reorder="1" multiple >
                                                    <option value="">Select</option>
                                                    <?php 
                                                        $SelectedNotification = isset($getUserDetails[0]['SelectedNotification'])?$getUserDetails[0]['SelectedNotification']:array();
                                                        if ($SelectedNotification) {
                                                            $SelectedNotification = explode(',', $SelectedNotification);
                                                        }
                                                        foreach ($getPushNotification as $key => $value) {
                                                            $selected = "";
                                                            if (!empty($SelectedNotification) && in_array($value['ID'], $SelectedNotification)) {
                                                                $selected = 'selected="selected"';
                                                            }
                                                            echo '<option value= "' . $value['ID'] . '"' . $selected . '>' . $value['Name'] . '</option>';
                                                        }
                                                        
                                                        ?>
                                                    
                                                </select>
                                        </div>          
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">
                                         Notification Update Timer (BY default after an hr )
                                    </label>

                                    <div class="col-md-4">
                                        <input type="text" name="pushCronUpdateTime"  id="pushCronUpdateTime"
                                            value="<?php echo $getUserDetails[0]['pushCronUpdateTime']; ?>" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Enable Fresh Desk on User 
                                </label>

                                <div class="col-md-1">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" >
                                            <?php
                                            $EnableFreshDeskUser = (isset($getUserDetails[0]["EnableFreshDeskUser"])) ? $getUserDetails[0]["EnableFreshDeskUser"] : 0;
                                            $checked = "";
                                            if ($EnableFreshDeskUser) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="EnableFreshDeskUser" id="EnableFreshDeskUser" value="1"  onchange="showFreshDeskCompany('freshDeskCompany')"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id='freshDeskCompany' style ='display:none;'>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">
                                        Select all Users 
                                    </label>

                                    <div class="col-md-1">
                                        <div class="col-md-12 padding_none">
                                            <div class="checkboxes" >
                                                <?php
                                                $SelectAllUsers = (isset($getUserDetails[0]["SelectAllUsers"])) ? $getUserDetails[0]["SelectAllUsers"] : 0;
                                                $checked = "";
                                                if ($SelectAllUsers) {
                                                    $checked = "checked='checked'";
                                                }
                                                ?>
                                                <label>
                                                    <input type="checkbox" <?= $checked; ?> name="SelectAllUsers" id="SelectAllUsers" value="1" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">
                                                Select Spefic Users
                                    </label>

                                    <div class="col-md-1">
                                        <div class="col-md-12 padding_none">
                                            <div class="checkboxes" >
                                                <?php
                                                $SelectSpecficUsers = (isset($getUserDetails[0]["SelectSpecficUsers"])) ? $getUserDetails[0]["SelectSpecficUsers"] : 0;
                                                $checked = "";
                                                if ($SelectSpecficUsers) {
                                                    $checked = "checked='checked'";
                                                }
                                                ?>
                                                <label>
                                                    <input type="checkbox" <?= $checked; ?> name="SelectSpecficUsers" id="SelectSpecficUsers" value="1"  onchange="showFreshDeskCompany('freshDeskCompanyss')"/>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row"  id='freshDeskCompanyss' style ='display:none;' >
                                    <label class="control-label col-md-3">
                                        Fresh Desk Company User 
                                    </label>
                                    <div class="col-md-4">
                                            <select name="AllowedFreshDeskUser[]" id="AllowedFreshDeskUser"
                                                    class="form-control select2-multiple dataSourceColumns" data-reorder="1" multiple >
                                                <option value="">Select</option>
                                                <?php 
                                                    $AllowedFreshDeskUser = isset($getUserDetails[0]['AllowedFreshDeskUser'])?$getUserDetails[0]['AllowedFreshDeskUser']:array();
                                                    if ($AllowedFreshDeskUser) {
                                                        $AllowedFreshDeskUser = explode(',', $AllowedFreshDeskUser);
                                                    }
                                                    foreach ($getFreshDeskUsers as $key => $value) {
                                                        $selected = "";
                                                        if (!empty($AllowedFreshDeskUser) && in_array($value['contact_id'], $AllowedFreshDeskUser)) {
                                                            $selected = 'selected="selected"';
                                                        }
                                                        echo '<option value= "' . $value['contact_id'] . '"' . $selected . '>' . $value['email'] . '</option>';
                                                    }
                                                    
                                                    ?>
                                                
                                            </select>
                                        </div>          
                                </div>
                            </div>


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
                                       href="<?php echo baseUrl; ?>editcompany?id=<?= $_REQUEST['companyId']; ?>">Cancel
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>

                                <div class="btn-group offset-md-1">
                                    <a class="btn copy_user_settings" rel="ligthbox" href="#copyUserSettings"
                                       style="background: hotpink; color: #FFF;">
                                        Copy Settings from users
                                    </a>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div style="display: none;">
        <div class="row" id="copyUserSettings">
            <div class="col-md-12">
                <form id="copyUserSettingsForm" method="POST" onsubmit="return copyUserSettings();"
                      class="form-horizontal">
                    <input type="hidden" id="companyId" value="<?php echo $_REQUEST['companyId']; ?>" name="CompanyId">
                    <input type="hidden" id="UserId" value="<?php echo $getUserDetails[0]['UserID']; ?>" name="UserId">

                    <div class="form-body">

                        <div class="form-group row">
                            <label class="control-label col-md-3">Select user
                                <span class="required"> * </span>
                            </label>

                            <div class="col-md-7">
                                <select type="text" name="selectedUserId" required data-required="1"
                                        class="form-control">
                                    <option value=""> Select</option>
                                    <?php foreach ($getTotalUsers as $key => $value) { ?>
                                        <option
                                            value="<?= $value['UserID']; ?>"><?= trim($value['UserFirstName']) . ' ' . trim($value['UserLastName']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">

                            <div class="offset-md-3 col-md-3">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-info">
                                        Save
                                    </button>
                                    &nbsp;&nbsp;
                                    <div class="loader" style="display: none;">
                                        <img src="<?php echo baseUrl; ?>assets/images/loader.gif" alt=""
                                             style="width: 200px;">
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .loader {
            width: 30px;
            height: 30px;
            overflow: hidden;
            position: relative;
        }

        .loader > img {
            position: absolute;
            top: 60%;
            transform: translate(-50%, -50%);
            left: 50%;
        }
    </style>
<script type="text/javascript">
    <?php 
      
      if ( isset($getUserDetails[0]["EnableFreshDeskUser"]) &&  $getUserDetails[0]['EnableFreshDeskUser'] == '1') {?>
          $('#freshDeskCompany').show();
<?php } ?>
<?php 
      
      if ( isset($getUserDetails[0]["EnableFreshDeskUser"]) &&  $getUserDetails[0]['EnableFreshDeskUser'] == '1' && (isset($getUserDetails[0]["SelectSpecficUsers"]) &&  $getUserDetails[0]['SelectSpecficUsers'] == '1') ) {?>
          $('#freshDeskCompanyss').show();
<?php } ?>
<?php 
      
      if ( isset($getUserDetails[0]["AllowNotification"]) &&  $getUserDetails[0]['AllowNotification'] == '1') {?>
          $('#pushNotification').show();
<?php } ?>
function showNotification(box) {
    var chboxs = document.getElementById(box).style.display;
    var vis = "none";
        if(chboxs=="none"){
         vis = "block"; }
        if(chboxs=="block"){
         vis = "none"; }
    document.getElementById(box).style.display = vis;
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
    function keyGen(){

        var getEmail = $('#UserEmail').val();
        var getPass = $('#UserPassword').val();
        if(getEmail !== "" && getPass !== "")
        {
            var genKey = btoa(getEmail+":"+getPass);
            document.getElementById('Auth').value = genKey;
            
        }else{
            alert("Email or Password is Missing");
        }      
    }
</script>
    <script>
        $('.copy_user_settings').on('click', function () {
            $.fancybox({
                href: '#copyUserSettings',
                autoSize: false,
                width: "50%",
                height: "auto",
                scrolling: "no"
            });
        });

        function copyUserSettings() {
            var url = baseUrl + 'copyUserSettings';
            setTimeout(function () {
                $('.loader').show();
            }, 500);
            $.ajax({
                url: url,
                data: $('#copyUserSettingsForm').serialize(),
                type: 'POST'
            }).done(function (data) {
                    location.reload();
                })
                .fail(function (data) {
                });
            $('.loader').hide();
            return false
        }
    </script>
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>