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
                    <header>Enter company configuration</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>savecompany" method="post" id="form_sample_1"
                          class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group row">
                                <label class="control-label col-md-3">Company Name
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="CompanyName" required data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">GIS Key
                                    
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="CompanyGISKey" 
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">GIS Token
                                    
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="CompanyGISToken" 
                                           class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">BABCDB
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="CompanyBABCDb" data-required="1" required
                                           class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">BPDB
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="CompanyBPDb" data-required="1" required
                                           class="form-control"/>
                                </div>
                            </div>
                            <!-- Start  new Part--->
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Allow  Company Folder 
                                </label>

                                <div class="col-md-1">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" >
                        
                                            <label>
                                                <input type="checkbox"  name="AllowCompanyFolder" id="AllowCompanyFolder" value="1"/>
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
                                        value="" 
                                        class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Use this SFTP to Upload Image  
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="SFTPCredential" 
                                        value="" 
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
                            
                            ?>
                            <div id="Maindiv<?= $keyVal; ?>">
                                <div class="form-group row">
                                    <label class="control-label col-md-3">DB Crediendtials
                                    </label>

                                    <div class="col-md-4">
                                        <input type="text" id="CompanyHostName<?= $keyVal; ?>" name="CompanyHostName<?= $keyVal; ?>"
                                                value="" 
                                                class="form-control"/>
                                    </div>
                                </div>
                                    <div class="form-group row">
                                    <label class="control-label col-md-3">
                                        DB Type 
                                        <span class="required"> * </span>
                                    </label>

                                    <div class="col-md-4">
                                        
                                        <select name="DBType<?= $keyVal; ?>" id="DBType<?= $keyVal; ?>" class="form-control" >
                                            <option value=""> Select</option>
                                            <option value="sqlsrv" >SQL SERVER
                                            </option>
                                            <option value="mysql" >MY SQL
                                            </option>
                                             <option value="pgsql" >Postgre SQL
                                            </option>
                                              <option value="mongodb">MongoDb
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-md-3">
                                    </label>

                                    <div class="col-md-4">
                                        <input type="button"  onclick="deleteRowDatabtn('<?= $keyVal; ?>');" value= "Delete DB"/>
                                    </div>
                            </div>
                                   </div>  
                           
                            <div class="form-group row" id="orderRowDatabtndiv">
                                    <label class="control-label col-md-3">
                                    </label>

                                    <div class="col-md-4">
                                        <input type="button" id="orderRowDatabtn" onlick="duplicate();" value= "Add More DB"/>
                                       
                                    </div>
                            </div>
                            <?php 
                                
                                $keyVal = 0;
                               
                            ?>
                             <div id="MainAdminDBdiv<?= $keyVal; ?>">
                                <div class="form-group row">

                                    <label class="control-label col-md-3">AdminDB
                                    </label>

                                    <div class="col-md-4" id="dropDB<?= $keyVal; ?>">
                                         <select id ="AdminDbDrop<?= $keyVal; ?>" name="AdminDbDrop<?= $keyVal; ?>"  class="form-control" >
                                            <option value=""> Select</option>
                                            <?php 
                                            if($getAllAdminDB){
                                                foreach($getAllAdminDB as $adminDBKey => $adminDBVal){?>
                                                <option value="<?= $adminDBVal['ID']?>" > <?= $adminDBVal['Name']?>
                                                </option>
                                            <?php } } ?>
                                            
                                        </select>

                                    </div>

                                </div>
                            </div>
                         

                            <div class="form-group row" id ="adminDBbtndiv">
                                    <label class="control-label col-md-3">
                                    </label>

                                    <div class="col-md-4">
                                        <input type="button"  onclick="adminDBbtn(<?= $keyVal ?>);" value= "Add More AdminDB "/>
                                    </div>
                            </div>
                            
                                 <?php 
                                   $keyVal = 0;
                             
                                          
                                        ?>
                                <div id="MainAPIdiv<?= $keyVal; ?>">
                                <div class="form-group row">

                                    <label class="control-label col-md-3">API Address 
                                    </label>

                                    <div class="col-md-4" id="dropD<?= $keyVal; ?>">
                                         <select id ="CompanyDBPassDrop<?= $keyVal; ?>" name="CompanyDBPassDrop<?= $keyVal; ?>" onchange="nameLinkData(<?= $keyVal; ?>)" class="form-control" >
                                            <option value=""> Select</option>
                                            <?php 
                                            if($getAllAddress){
                                                foreach($getAllAddress as $addressKey => $addresVal){?>
                                                <option value="<?= $addresVal['Address']?>" > <?= $addresVal['AddressName']?>
                                                </option>
                                            <?php } } ?>
                                            
                                        </select>

                                    </div>

                                    <div class="col-md-4" id="dropDr<?= $keyVal; ?>">
                                         <input type="button" onClick="showData(<?= $keyVal; ?>);" value= "Add Custom Fields"/>
                                    </div>  

                                    <?php 
                                    $varble = '';
                                    
                                    ?>
                                    <div class="col-md-4"  id="fields<?= $keyVal; ?>" style="display: none;">
                                        <input type="text"  name="CompanyDBPassField<?= $keyVal; ?>" 
                                               value="<?php echo $varble; ?>" 
                                               class="form-control"/>
                                      
                                    </div>
                                    
                                </div>
                               
                                <div class="form-group row"  style="display: none"  id="linkName<?= $keyVal; ?>" >
                                    <label class="control-label col-md-3">Linking Name at Datsource 
                                    </label>

                                    <div class="col-md-4">
                                        <input type="text" name="DatsourceLinkName<?= $keyVal; ?>"  id= "DatsourceLinkName<?= $keyVal; ?>"
                                               value="" 
                                               class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">API Params 
                                    </label>
                                  
                                    <div class="col-md-4">
                                        <input type="text" name="CompanyDBUserName<?= $keyVal; ?>" 
                                               value="" 
                                               class="form-control"/>
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="control-label col-md-3">
                                    </label>

                                    <div class="col-md-4">
                                        <input type="button"  onclick="deleteAPIDatabtn('<?= $keyVal; ?>');" value= "Delete API"/>
                                    </div>
                                </div>
                             </div>
                                
                           
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
                            <div id ='directPayment' style="display:none">
                                <div class="form-group row">
                                    <label class="control-label col-md-3">Account Holder Name
                                        <span class="required"> * </span>
                                    </label>

                                    <div class="col-md-4">
                                        <input type="text" name="AccountHolderName" maxlength="70"
                                            class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">IBAN Number 
                                        <span class="required"> * </span>
                                    </label>

                                    <div class="col-md-4">
                                        <input type="text" name="IBANNumber" 
                                            class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">BIC Number 
                                        <span class="required"> * </span>
                                    </label>

                                    <div class="col-md-4">
                                        <input type="text" name="BICNumber" 
                                            class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">Creditor ID
                                        <span class="required"> * </span>
                                    </label>

                                    <div class="col-md-4">
                                        <input type="text" name="CreditorID" 
                                            class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">Org ID
                                    </label>

                                    <div class="col-md-4">
                                        <input type="text" name="OrgId" value = ""
                                            class="form-control"/>
                                    </div>   
                                    <div class="col-md-4">
                                        <div class="checkboxes" >
                                
                                        
                                            <label>
                                                <input type="checkbox"  name="EnableOrgId" value="1"/>
                                            </label>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">End to End
                                       
                                    </label>

                                    <div class="col-md-4">
                                        <input type="text" name="EndtoEndId" value = ""
                                            class="form-control"/>
                                    </div>   
                                    <div class="col-md-4">
                                        <div class="checkboxes" >
                                        
                                            <label>
                                                <input type="checkbox"  name="EnableEndtoEndId" value="1"/>
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
                                        <input type='text'  size="16" class="form-control" name="CompanyStartDate" value="" />
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
                                    <div class='input-group date' id='datetimepicker3'>
                                            <input type='text'  size="16" class="form-control" name="CompanyEndDate" value="" />
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
                                    <input type="text" name="CompanyEmail" required data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                            <label class="control-label col-md-3">
                                Allow Other Company User
                            </label>

                            <div class="col-md-1">
                                <div class="col-md-12 padding_none">
                                    <div class="checkboxes" >
                                        
                                        <label>
                                            <input type="checkbox"  name="AllowOtherCompanyUser" id="AllowOtherCompanyUser" value="1"/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">
                                Allow google Analytics 
                            </label>

                            <div class="col-md-1">
                                <div class="col-md-12 padding_none">
                                    <div class="checkboxes" >
                                        
                                        <label>
                                            <input type="checkbox" name="APIOption" id="APIOption" value="1"/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" id = "googleApiURLButton" style="display: none">
                               <button class="btn btn-info" onclick="copyToClipboard('#googleApiURL')">Copy Link </button> 
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
                                    <a class="btn deepPink-bgcolor" a href="<?php echo baseUrl; ?>companies">Cancel
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                        </div>


                        </div>
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
function directPaymentBtn(){
    $("#directPayment").show(); 
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