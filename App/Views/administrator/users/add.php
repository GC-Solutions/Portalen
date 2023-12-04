<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_start.php'; ?>

<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_menu.php'; ?>
    <div class="page-container">
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/side_bar.php'; ?>
    <div class="page-content-wrapper">
        <div class="page-content">
          <!--   <div class="page-bar">
                <div class="page-title-breadcrumb">
                    <div class=" pull-left">
                        <div class="page-title">Create Company User</div>
                    </div>
                </div>
            </div>

 -->
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="card card-box">
                        <div class="card-head">
                            <header>Create Company User</header>
                        </div>
                        <div class="card-body" id="bar-parent1">
                            <form action="<?php echo baseUrl;?>saveuser" method="post" id="form_sample_1" class="form-horizontal">
                                <div class="form-body">
                                    <input type="hidden" value="<?php echo $_REQUEST['id'];?>" name="CompanyID">

                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Name
                                            <span class="required"> * </span>
                                        </label>

                                        <div class="col-md-4">
                                            <input type="text" name="UserFirstName" required data-required="1" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Lastname
                                            <span class="required"> * </span>
                                        </label>

                                        <div class="col-md-4">
                                            <input type="text" name="UserLastName" required  data-required="1" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-md-3">DB Param
                                        </label>

                                        <div class="col-md-4">
                                            <input type="text" name="DBParam" class="form-control"/>
                                        </div>
                                    </div>
                            <div class="form-group row">
                                        <label class="control-label col-md-3">API Param
                                        </label>

                                        <div class="col-md-4">
                                            <input type="text" name="APIParam" class="form-control"/>
                                        </div>
                                    </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                   Do Not Use Company DBparma for all user  
                                </label>
                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id ='ChangeChkBox'>
                                            <label>
                                                <input type="checkbox" name="AllowParentDBParam" id ="AllowParentDBParam"
                                                       value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                   Do Not Use Company DBparma for all user  
                                </label>
                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id ='ChangeChkBox'>
                                            <label>
                                                <input type="checkbox" name="AllowParentAPIParam" id ="AllowParentAPIParam"
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
                                            
                                            <label>
                                                <input type="checkbox" name="UserGroupFlag"
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
                                            <label>
                                                <input type="checkbox" name="UserGroupActiveFlag"
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
                                            $getUserGroup = explode(',', $getUserGroup);
                                            if ($getUserGroup) {
                                                foreach ($getUserGroup as $key => $value) {
                                                    $selected = "";
                                                    
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
                                            <label>
                                                <input type="checkbox"  name="DefaultLogin"
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
                                            <label>
                                                <input type="checkbox"  checked='checked' name="SaveFilterBTN"
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
                                    
                                    <div class='input-group date' id='datetimepicker2'>
                                        <input type='text'  size="16" class="form-control" name="UserStartDate" value="" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">End Date
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    
                                    <div class='input-group date' id='datetimepicker3'>
                                        <input type='text'  size="16" class="form-control" name="UserEndDate" value="" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="form-group row">
                                <label class="control-label col-md-3">Email
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="email" name="UserEmail" id ="UserEmail" data-required="1" required class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">Password
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="password" name="UserPassword" id ="UserPassword" required data-required="1" class="form-control"/>
                                </div>
                            </div>


                            </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">Authorization 
                                        
                                    </label>

                                    <div class="col-md-4">
                                        <input type="Auth" name="Auth" id ="Auth" class="form-control"/>
                                        <div class="btn-group">
                                            <button  class="btn btn-info" type="button" onclick="keyGen()">
                                                Generate Auth Key 
                                            </button>
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
                                                
                                                <label>
                                                    <input type="checkbox"  name="EnableFreshDeskUser" id="EnableFreshDeskUser" value="1"  onchange="showFreshDeskCompany('freshDeskCompany')"/>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id='freshDeskCompany' style ='display:none;'>
                                    <div class="form-group row" >
                                        <label class="control-label col-md-3">
                                            Fresh Desk Company User 
                                        </label>
                                        <div class="col-md-4">
                                                <select name="AllowedFreshDeskUser[]" id="AllowedFreshDeskUser"
                                                        class="form-control select2-multiple dataSourceColumns" data-reorder="1" multiple >
                                                    <option value="">Select</option>
                                                    <?php 
                                                        
                                                        foreach ($getFreshDeskUsers as $key => $value) {
                                                            $selected = "";
                                                            
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
                                        <a class="btn deepPink-bgcolor" a href="<?php echo baseUrl;?>editcompany?id=<?= $_REQUEST['id'];?>">Cancel
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
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>