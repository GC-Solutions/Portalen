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
                    <header>Add Push Notification</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>savePushNotification" method="post" class="form-horizontal">
                        <div class="form-body">
                            <input type="hidden" name="id"  value=""/>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Notification Title 
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Name" required="" data-required="1"
                                           value="<?php if(isset($getNotiData['Name'])){ echo $getNotiData['Name'];} ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Notification Description
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Descriptions" required="" data-required="1"
                                           value="<?php  if(isset($getNotiData['Descriptions'])){echo $getNotiData['Descriptions'];} ?>"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Allow popUp Notification
                                </label>
                                <?php  $AllowPopUp = isset($getNotiData['AllowPopUp'])?$getNotiData['AllowPopUp']:0; 
                                        $checked = '';
                                        if($AllowPopUp){ 
                                            $checked = "checked='checked'";
                                        } 
                                ?>
                                <div class="col-md-4">
                                    <input type="checkbox" <?= $checked; ?> name="AllowPopUp"  value="1" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    PopUP Notification Description
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="PopUpDescriptions"
                                           value="<?php if(isset($getNotiData['PopUpDescriptions'])){echo $getNotiData['PopUpDescriptions'];} ?>"
                                           class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Notification Type
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <?php
                                            $tableType = isset($getNotiData['MsgType'])?$getNotiData['MsgType']:0;
                                    ?>
                                    <select name="MsgType" class="form-control MsgType" required="">
                                        <option value=""> Select</option>
                                        <option value="1" <?php if ($tableType == 1) {
                                            echo "selected='selected'";
                                        } ?>>Error Msg 
                                        </option>
                                        <option value="2" <?php if ($tableType == 2) {
                                            echo "selected='selected'";
                                        } ?>>Success Msg 
                                        </option>
                                        <option value="3" <?php if ($tableType == 3) {
                                            echo "selected='selected'";
                                        } ?>>Warning Msg
                                        </option>
                                        <option value="4" <?php if ($tableType == 4) {
                                            echo "selected='selected'";
                                        } ?>>Info Msg 
                                        </option>
                                       
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Table 
                                </label>

                                <div class="col-md-4">
                                            <select class="form-control TableId select2-multiple DataTableId" data-maximum-selection-length="1" multiple name="TableID">
                                                <option value="">Select</option>
                                                <?php foreach ($getAllTable as $key => $value) {
                                                    $selectedOption = "";

                                                    if (isset($getNotiData['TableID']) && $getNotiData['TableID'] == $value['ID']) {
                                                        $selectedOption = "selected='selected'";
                                                    }
                                                    ?>
                                                    <option <?= $selectedOption; ?>
                                                        value="<?php echo $value['ID']; ?>"><?php echo $value['Name']; ?></option>
                                                <?php } ?>
                                            </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                   Condition on Column
                                </label>

                                <div class="col-md-4">
                                    <select name="ColumnNameColor[]" id="ColumnNameColormultiple"
                                            class="form-control select2-multiple dataTableColumns" data-reorder="1" multiple
                                            onChange='getSelectedOptions()'>
                                        <option value="">Select</option>
                                       
                                    </select>
                                </div>
                            </div>
                            <div id='ColorBtn'>

                            </div>
                            <div id='ColorConditions'>

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
                                           href="<?php echo baseUrl; ?>placeholders">Cancel
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

var jar = 1;
<?php
if(isset($getNotiData["Conditions"])){ ?>
        var opts = [],
        opt;
        $("#ColorBtn").children().remove();
        var dats = $("#ColumnNameColormultiple").val();
        $.each(dats, function ( datsKey, datsValue) {
            if(document.getElementById('#condition'+datsValue) !== true){
                opts.push('condition'+datsValue);
            }
            
        });
        $.each(opts, function ( datsKey, datsValue) {
            $("#"+datsValue).remove();
            
        });
        $.each(dats, function ( datsKey, datsValue) {

            let btn = document.createElement("button");
            btn.innerHTML = "Condition for "+datsValue;
            btn.name = datsValue;
            btn.id = datsValue;
            btn.type="button";
            btn.onclick = function () { newConditionFields(datsValue)};
            $('#ColorBtn').append(btn);
        });
            
            <?php
                $ColorTextMatch = json_decode($getNotiData["Conditions"] , true); 
               
                foreach ($ColorTextMatch as $ColorTextMatchkey => $ColorTextMatchvalue) { 
                    ksort($ColorTextMatchvalue);
                   
                    foreach($ColorTextMatchvalue as $innerkey => $innerValue){ ?>
                       
                        var textValue = "<?php echo $ColorTextMatchkey; ?>";
                        var textkey = "<?php echo $innerkey; ?>";
                        var text = document.createElement('div');
                        text.id = "condition"+textValue+textkey;
                        var IDNew = "condition"+textValue+textkey;
                        var val = '';

                        
						val += ' <div id ="'+IDNew+'">';
                        val += ' <div class="form-group row" >'+
                                        '<label class="control-label col-md-3"> '+textValue+'Rule '+textkey+' </label>'+
                                        '<div class="col-md-9" id="rules">'+
                                            '<div class="col-md-3">'+
                                                '<input placeholder="first parameter" type="text" name="'+textValue+'_FirstParameter_'+textkey+'"  id="FirstParameter" value="<?php if($innerValue["FirstParameter"] != ''){ print_r($innerValue['FirstParameter']);}?>"  class="form-control"  <?php if($innerValue["FirstParameter"] == ''){ ?> readonly <?php }?> />'+
                                            '</div>'+
                                            '<div class="col-md-3">'+
                                                '<select name="'+textValue+'_Condition_'+textkey+'" class="form-control" onchange="InBetween(\''+textkey+'\' ,  \''+textValue+'\' , this )"  id="Condition">'+
                                                    '<option value=""> Select</option>'+
                                                    '<option value="="  <?php if( isset($innerValue["Condition"]) && $innerValue["Condition"] ==  '='){ echo  'selected="selected"' ;}?> >  is Equal</option>'+
                                                    '<option value="!=" <?php if( isset($innerValue["Condition"]) && $innerValue["Condition"] ==  '!='){ echo  'selected="selected"' ;}?> > is Not Equal</option>'+
                                                    '<option value=">" <?php if( isset($innerValue["Condition"]) && $innerValue["Condition"] ==  '>'){ echo  'selected="selected"' ;}?> > is Greater</option>'+
                                                    '<option value="<" <?php if( isset($innerValue["Condition"]) && $innerValue["Condition"] ==  '<'){ echo  'selected="selected"' ;}?>  > is Less then </option>'+
                                                    '<option value=">="  <?php if( isset($innerValue["Condition"]) && $innerValue["Condition"] ==  '>='){ echo  'selected="selected"' ;}?> > is Greater then and equal to </option>'+
                                                    '<option value="<="  <?php if( isset($innerValue["Condition"]) && $innerValue["Condition"] ==  '<='){ echo  'selected="selected"' ;}?> > is Less then and equal to </option>'+
                                                    '<option value="InBetween"  <?php if( isset($innerValue["Condition"]) && $innerValue["Condition"] ==  'InBetween'){ echo  'selected="selected"' ;}?> > In Between </option>'+
							'<option value="InText"  <?php if( isset($innerValue["Condition"]) && $innerValue["Condition"] ==  'InText'){ echo  'selected="selected"' ;}?> > In Text </option>'+
                                                
                                                '</select>'+
                                            '</div>'+
                                            '<div class="col-md-3">'+
                                                '<input placeholder="Second parameter" type="text" name="'+textValue+'_SecondParameter_'+textkey+'"  value="<?php print_r($innerValue['SecondParameter']);?>"  class="form-control"/>'+
                                            '</div>'+
                                            '<div class="col-md-3">'+
                                                '<button  type="button" id = "'+textValue+'_AddMorePara" onclick="Addnewpara(\''+textkey+'\' ,  \''+textValue+'\')" >  Add more Parameter for'+textValue+'</button> '+
                                                '<button  type="button" id = "'+textValue+'_DeletePara" onclick="Deletepara(\''+textkey+'\' ,  \''+textValue+'\')"  > Delete Parameter '+textkey+' for'+textValue+'</button> '+
                                       
                                            '</div>'+
                                        '</div>'+
                                    '</div></div>';
                                    val += '<input type ="hidden" name="'+textValue+'_totalNum" id="'+textValue+'_totalNum" value="'+textkey+'"  />'

                                

                        text.innerHTML =val;
                        if(textkey == '1')
                        {
                            $('#ColorConditions').append(val);
                        }else{
                            var IDNews = "condition"+textValue+(parseInt(textkey)-1);
                            //$('#'+IDNew).append(val);
                            $( val ).insertAfter( '#'+IDNews );
                        }
                          
                    <?php    
                        }
                    }
                ?>
    <?php } ?>

function Deletepara(num , para){
    document.getElementById("condition"+para+num).remove();
}
function getSelectedOptions() {
  var opts = [],
    opt;
    $("#ColorBtn").children().remove();
    var dats = $("#ColumnNameColormultiple").val();
    $.each(dats, function ( datsKey, datsValue) {
        if(document.getElementById('#condition'+datsValue) !== true){
            opts.push('condition'+datsValue);
        }
        
    });
    $.each(opts, function ( datsKey, datsValue) {
        $("#"+datsValue).remove();
        
    });
    $.each(dats, function ( datsKey, datsValue) {

        let btn = document.createElement("button");
        btn.innerHTML = "Condition for "+datsValue;
        btn.name = datsValue;
        btn.id = datsValue;
        btn.type="button";
        btn.onclick = function() { newConditionFields(datsValue);}; 
        $('#ColorBtn').append(btn);
    });
}

function newConditionFields (datsValue) {
        
        var element =  document.getElementById("condition"+datsValue+'1');
        if (typeof(element) != 'undefined' && element != null)
        {
        }else{
            
            var text = document.createElement('div');
            text.id = "condition"+datsValue+'1';
            var IDss = "condition"+datsValue+'1';
            var val = '';

            val += '  <div id ="'+IDss+'">';
            

            val += ' <div class="form-group row" >'+
                            '<label class="control-label col-md-3"> '+datsValue+'Rule 1 </label>'+
                            '<div class="col-md-9" id="rules">'+
                                '<div class="col-md-3">'+
                                    '<input placeholder="first parameter" type="text" name="'+datsValue+'_FirstParameter_1"  id="FirstParameter" value=""  class="form-control" readonly />'+
                                '</div>'+
                                '<div class="col-md-3">'+
                                    '<select name="'+datsValue+'_Condition_1" class="form-control" onchange="InBetween(\'1\' ,  \''+datsValue+'\' , this)"  id="Condition">'+
                                        '<option value=""> Select</option>'+
                                        '<option value="="   >  is Equal</option>'+
                                        '<option value="!=" > is Not Equal</option>'+
                                        '<option value=">"  > is Greater</option>'+
                                        '<option value="<"   > is Less then </option>'+
                                        '<option value=">="   > is Greater then and equal to </option>'+
                                        '<option value="<=" > is Less then and equal to </option>'+
                                        '<option value="<="  > is Less then and equal to </option>'+   
                                        '<option value="InBetween" > In Between </option>'+
				                       '<option value="InText" > In Text </option>'+
				                       
                                    
                                    '</select>'+
                                '</div>'+
                                '<div class="col-md-3">'+
                                    '<input placeholder="Second parameter" type="text" name="'+datsValue+'_SecondParameter_1"  value=""  class="form-control"/>'+
                                '</div>'+
                                '<div class="col-md-3">'+
                                    '<button  type="button" id = "'+datsValue+'_AddMorePara" onclick="Addnewpara(\'1\' ,  \''+datsValue+'\')" >  Add more Parameter for'+datsValue+'</button> '+
                                    '<button  type="button" id = "'+datsValue+'_DeletePara" onclick="Deletepara(\'1\' ,  \''+datsValue+'\')"  > Delete Parameter 1 for'+datsValue+'</button> '+
                                '</div>'+
                            '</div>'+
                        '</div> </div>';
                        
                        val += '<input type ="hidden" name="'+datsValue+'_totalNum" id="'+datsValue+'_totalNum" value="1"  />'

                    

            text.innerHTML =val;
            $('#ColorConditions').append(val);
        }
   
};

function Addnewpara(num , datsValue){
       
        var element =  document.getElementById(datsValue+'_totalNum');
        if (typeof(element) != 'undefined' && element != null)
        {
            num = document.getElementById(datsValue+'_totalNum').value ;
            //num= parseInt(num);
        }
                    var IDNew = "condition"+datsValue+num;
                    
                    num= parseInt(num)+1;
                    var text = document.createElement('div');
                    text.id = "condition"+datsValue+num;
                    var IDNew1 = "condition"+datsValue+num;
                    var val = '';

                    val += ' <div id ="'+IDNew1+'">';

                    val += ' <div class="form-group row" >'+
                                    '<label class="control-label col-md-3"> '+datsValue+'Rule '+num+'  </label>'+
                                    '<div class="col-md-9" id="rules">'+
                                        '<div class="col-md-3">'+
                                            '<input placeholder="first parameter" type="text" name="'+datsValue+'_FirstParameter_'+num+'"  id="FirstParameter" value=""  class="form-control" readonly />'+
                                        '</div>'+
                                        '<div class="col-md-3">'+
                                            '<select name="'+datsValue+'_Condition_'+num+'" class="form-control" onchange="InBetween(\''+num+'\' ,  \''+datsValue+'\' , this)"  id="Condition">'+
                                                '<option value=""> Select</option>'+
                                                '<option value="="   >  is Equal</option>'+
                                                '<option value="!=" > is Not Equal</option>'+
                                                '<option value=">"  > is Greater</option>'+
                                                '<option value="<" > is Less then </option>'+
                                                '<option value=">="   > is Greater then and equal to </option>'+
                                                '<option value="<=" > is Less then and equal to </option>'+
                                                '<option value="<="  > is Less then and equal to </option>'+   
                                                '<option value="InBetween" > In Between </option>'+
                                                '<option value="InText" > In Text </option>'+
                                            '</select>'+
                                        '</div>'+
                                        '<div class="col-md-3">'+
                                            '<input placeholder="Second parameter" type="text" name="'+datsValue+'_SecondParameter_'+num+'"  value=""  class="form-control"/>'+
                                        '</div>'+
                                        '<div class="col-md-3">'+
                                            '<button  type="button" id = "'+datsValue+'_AddMorePara" onclick="Addnewpara(\''+num+'\' ,  \''+datsValue+'\')"  > Add more Parameter for'+datsValue+'</button> '+
                                            '<button  type="button" id = "'+datsValue+'_DeletePara" onclick="Deletepara(\''+num+'\' ,  \''+datsValue+'\')"  > Delete Parameter '+num+' for'+datsValue+'</button> '+
                                        '</div>'+
                                    '</div>'+
                                '</div>';
                        
                    document.getElementById(datsValue+'_totalNum').value = num;
                    text.innerHTML =val;
                   
                    //$('#'+IDNew).append(val);
                    $( val ).insertAfter( '#'+IDNew );
                   //$('#ColorConditions').append(val);
                    
}

function InBetween(num , para , el){

    if(el.value == 'InBetween'){
        $('input[name="'+para+'_FirstParameter_'+num+'"]').attr("readonly", false);
    }
}

$('#ChangeChkBox').change(function(){
    if(this.checked)
        $('#ChangeChkBox').val('0');
   else
        $('#ChangeChkBox').val('1');
});


</script>
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>