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
                    <header>Add a Form</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>save_DynamicForm" method="post" class="form-horizontal">
                        <div class="form-body">
                            <input type="hidden" name="id"
                                   value="<?= $id = (isset($getTableDetails['ID'])) ? $getTableDetails['ID'] : ""; ?>"/>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Form name
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Name" required="" data-required="1"
                                           value="<?= $Name = (isset($getTableDetails['Name'])) ? $getTableDetails['Name'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Form description
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Description" required="" data-required="1"
                                           value="<?= $descriptions = (isset($getTableDetails['Description'])) ? $getTableDetails['Description'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                   Call Type
                                </label>

                                <div class="col-md-4">
                                    <select  name="CallType"   >
                                        <option value="">Select</option> 
                                      
                                        <option <?php  if(isset($getTableDetails['CallType']) && ($getTableDetails['CallType'] == '1') ){
                                               echo 'selected="selected"';
                                             } ?> value="1">  API </option> 
                                        <option <?php  if(isset($getTableDetails['CallType']) && ($getTableDetails['CallType'] == '2')){
                                               echo 'selected="selected"';
                                             } ?> value="2"> SQL </option> 
                                        </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Select Selction type
                                </label>

                                <div class="col-md-4">
                                    <select  name="SelectionType" id="SelectionType" onchange="ShowDiv(this.value)" >
                                        <option value="">Select</option> 
                                      
                                        <option <?php  if(isset($getTableDetails['SelectionType']) && ($getTableDetails['SelectionType'] == '1') ){
                                               echo 'selected="selected"';
                                             } ?> value="1"> Json </option> 
                                        <option <?php  if(isset($getTableDetails['SelectionType']) && ($getTableDetails['SelectionType'] == '2')){
                                               echo 'selected="selected"';
                                             } ?> value="2"> Add more Option </option> 
                                        </select>
                                </div>
                            </div>
                            
                            <div id = 'sqlDivMain' style="display: none;">
                                             
                                 <?php 
                                    $key = 1;
                                    if(isset($getTableDetails['SelectionType']) && ($getTableDetails['SelectionType'] == '2') && isset($getTableDetails['DetailColumns']) && !empty($getTableDetails['DetailColumns']) ){
                                        $DetailColumns = json_decode($getTableDetails['DetailColumns'],true);
                                        foreach( $DetailColumns as $DetailColumnsKey =>  $DetailColumnsValsVal){ 
                                                
                                            ?>
                                            <div id = 'sqlDiv<?php echo $key; ?>'>
                                           
                                                <div class="form-group row">
                                                    <label class="control-label col-md-3">
                                                    Form Fields Names and their types Column <?php echo $key ;?>
                                                    </label>

                                                    <div class="col-md-4">
                                                        ColumnName
                                                        <input type="text" name="columnName<?php echo $key; ?>"  value="<?php if(isset($DetailColumnsValsVal['columnName'])){ echo $DetailColumnsValsVal['columnName']; } ?>" class="form-control"/>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-group row">
                                                    <label class="control-label col-md-3">
                                                    </label>

                                                    <div class="col-md-4">
                                                        Display Column Name
                                                        <input type="text" name="displayColumnName<?php echo $key; ?>"  value="<?php if(isset($DetailColumnsValsVal['displayColumnName'])){ echo $DetailColumnsValsVal['displayColumnName']; } ?>" class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="control-label col-md-3">   
                                                    </label>

                                                    <div class="col-md-4">
                                                        Column Type
                                                        
                                                        <select  name="columnType<?php echo $key; ?>"   >
                                                            <option value="">Select</option> 
                                                            <option value="textField" <?php if(isset($DetailColumnsValsVal['columnType']) && $DetailColumnsValsVal['columnType'] == 'textField' ){ echo 'selected="selected"'; } ?>>textField</option> 
                                                            <option value="date" <?php if(isset($DetailColumnsValsVal['columnType']) && $DetailColumnsValsVal['columnType'] == 'date' ){ echo 'selected="selected"'; } ?>>date</option> 
                                                            <option value="textarea" <?php if(isset($DetailColumnsValsVal['columnType']) && $DetailColumnsValsVal['columnType'] == 'textarea' ){ echo 'selected="selected"'; } ?>>textarea</option> 
                                                            <option value="dropdown" <?php if(isset($DetailColumnsValsVal['columnType']) && $DetailColumnsValsVal['columnType'] == 'dropdown' ){ echo 'selected="selected"'; } ?>>dropdown</option> 
                                                            <option value="file" <?php if(isset($DetailColumnsValsVal['columnType']) && $DetailColumnsValsVal['columnType'] == 'file' ){ echo 'selected="selected"'; } ?>>file</option> 

                                                        </select>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-group row">
                                                    <label class="control-label col-md-3">   
                                                    </label>

                                                    <div class="col-md-4">
                                                        Default value
                                                        <input type="text" name="Default<?php echo $key; ?>"  value="<?php if(isset($DetailColumnsValsVal['Default']) ){ echo $DetailColumnsValsVal['Default'];  } ?>" class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="control-label col-md-3">   
                                                    </label>

                                                    <div class="col-md-4">
                                                        Max Lenght
                                                        <input type="text" name="maxLenght<?php echo $key; ?>"  value="<?php if(isset($DetailColumnsValsVal['maxLenght']) ){ echo $DetailColumnsValsVal['maxLenght'];  } ?>" class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="control-label col-md-3">   
                                                    </label>

                                                    <div class="col-md-4">
                                                        Check 
                                                        <input type="text" name="check<?php echo $key; ?>"  value="<?php if(isset($DetailColumnsValsVal['check']) ){ echo $DetailColumnsValsVal['check'];  } ?>" class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="form-group row" >
                                                    <label class="control-label col-md-3">
                                                    </label>
                                                    <div class="col-md-4" id = "deleteColumns">
                                                        <button  type="button"  onclick="DeleteColumn('<?php echo $key; ?>')" > Delete Column </button>     
                                                    </div> 
                                                </div>
                                               
                                           </div>

                                        <?php $key = $key+1 ; } $key = $key-1 ;
                                    } else {  $key = 1; ?>            
                              
                                        <div id = 'sqlDiv<?php echo $key; ?>'>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3">
                                                Form Fields Names and their types Column 1 
                                                </label>

                                                <div class="col-md-4">
                                                    ColumnName
                                                    <input type="text" name="columnName1"  value="" class="form-control"/>
                                                </div> 
											</div>					<div class="form-group row">
                                                    <label class="control-label col-md-3">
                                                    </label>
            <div class="col-md-4">
                                                    Display Column Name
                                                    <input type="text" name="displayColumnName1"  value="" class="form-control"/>
                                                </div>                                    
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3">   
                                                </label>

                                                <div class="col-md-4">
                                                    ColumnType
                                                    <select  name="columnType1"   >
                                                        <option value="">Select</option> 
                                                        <option value="textField">textField</option> 
                                                        <option value="date">date</option> 
                                                        <option value="textarea">textarea</option> 
                                                        <option value="dropdown">dropdown</option> 
                                                        <option value="file">file</option> 

                                                    </select>
                                                </div>
                                                
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3">   
                                                </label>

                                                <div class="col-md-4">
                                                    Default value
                                                    <input type="text" name="Default1"  value="" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3">   
                                                </label>

                                                <div class="col-md-4">
                                                    Max Lenght
                                                    <input type="text" name="maxLenght1"  value="" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3">   
                                                </label>

                                                <div class="col-md-4">
                                                    Check 
                                                    <input type="text" name="check1"  value="" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group row" >
                                                    <label class="control-label col-md-3">
                                                    </label>
                                                    <div class="col-md-4" id = "deleteColumns">
                                                        <button  type="button"  onclick="DeleteColumn('<?php echo $key; ?>')" > Delete Column </button>     
                                                    </div> 
                                            </div>
                                        
                                        </div>
                                    <?php } ?>
                                <div class="form-group row" >
                                    <label class="control-label col-md-3">
                                    </label>
                                    <div class="col-md-4" id = "AddColumns">
                                        <button  type="button"  onclick="AddMoreColumns('<?php echo $key+1; ?>')" >  Add More Columns </button>     
                                    </div> 
                                </div>
                            </div>
                          
                            
                            <div class="form-group row" id='jsonMain' style="display: none;" >
                                <label class="control-label col-md-3">
                                   Form Fields Names and their types in Json
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                  <textarea name="DetailColumns"
                                            class="form-control"> <?= $DetailColumns = (isset($getTableDetails['DetailColumns'])) ? $getTableDetails['DetailColumns'] : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                   Make all Field Read only 
                                </label>
                                <div class="col-md-9">
                                    <div class="col-md-4">
                                        <div class="checkboxes">
                                            <?php
                                            $AllReadOnly = (isset($getTableDetails["AllReadOnly"])) ? $getTableDetails["AllReadOnly"] : 0;
                                            $checked = "";
                                            if ($AllReadOnly) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="AllReadOnly"
                                                       value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row" >
                                <label class="control-label col-md-3">
                                   Add Hiddden Field Names and their types 
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                  <textarea name="HiddenColumns"
                                            class="form-control"> <?= $HiddenColumns = (isset($getTableDetails['HiddenColumns'])) ? $getTableDetails['HiddenColumns'] : ""; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Action Button 
                                </label>

                                <div class="col-md-4">
                                        <select  name="ActionButton"   >
                                        <option value="">Select</option> 
                                      
                                        <option <?php  if(isset($getTableDetails['ActionButton']) && (strpos($getTableDetails['ActionButton'] , 'csvUpload') !== false )  ){
                                               echo 'selected="selected"';
                                             } ?> value="csvUpload">Add to Sql and Upload Image  </option> 
                                        <option <?php  if(isset($getTableDetails['ActionButton']) && (strpos($getTableDetails['ActionButton'] , 'csvUpload') !== false )   ){
                                               echo 'selected="selected"';
                                             } ?> value="csvUpload">Add to Sql </option> 
                                        <option <?php  if(isset($getTableDetails['ActionButton']) && (strpos($getTableDetails['ActionButton'] , 'GetData') !== false ) ){
                                               echo 'selected="selected"';
                                             } ?>  value="GetData">Get Live data  </option> 
                                       
                                        </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Design Type  
                                </label>

                                <div class="col-md-4">
                                        <select  name="DesignType"  >
                                        <option value="">Select</option> 
                                        <option  <?php  if( isset($getTableDetails['DesignType']) && $getTableDetails['DesignType'] == '1' ){
                                               echo 'selected="selected"';
                                             } ?> value="1">Basic Design  </option> 
                                        <option  <?php  if(isset($getTableDetails['DesignType']) && $getTableDetails['DesignType'] == '2' ){
                                               echo 'selected="selected"';
                                             } ?> value="2">Material Design  </option> 
                                         <option  <?php  if(isset($getTableDetails['DesignType']) && $getTableDetails['DesignType'] == '1,2' ){
                                               echo 'selected="selected"';
                                             } ?> value="1,2">Both Basic And New Design </option> 
                                       
                                        </select>
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
<script type="text/javascript" >
      <?php 
      
      if(isset($getTableDetails['SelectionType']) && ($getTableDetails['SelectionType'] == '1') ) {?>
          $('#jsonMain').show();
     <?php } else if(isset($getTableDetails['SelectionType']) && ($getTableDetails['SelectionType'] == '2') ) { ?>
        $('#sqlDivMain').show();
    <?php } else if(isset($getTableDetails['SelectionType']) && ($getTableDetails['SelectionType'] == '') ) { ?>
        $('#jsonMain').show();
    <?php } ?>  
    
    function ShowDiv(val){
        if(val == 1){
            $('#jsonMain').show();
            $('#sqlDivMain').hide();
        }else if (val == 2){
            $('#sqlDivMain').show();
            $('#jsonMain').hide();

        }
    }

    function DeleteColumn(id){
        document.getElementById("sqlDiv"+id).remove();
    }
    function AddMoreColumns(id){
    
            var text = document.createElement('div');
            //text.id = "sqlDiv"+id;
           
            var val = '';
            val += '<div id="sqlDiv'+id+'"> <div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                        ' Form Fields Names and their types Column'+id+''+
                        '</label>'+

                        '<div class="col-md-4">'+
                        '    ColumnName'+
                        '    <input type="text" name="columnName'+id+'"  value="" class="form-control"/>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                        '</label>'+

                        '<div class="col-md-4">'+
                           ' Display Column Name'+
                            '<input type="text" name="displayColumnName'+id+'"  value="" class="form-control"/>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                    ' <label class="control-label col-md-3">   '+
                    ' </label>'+

                    ' <div class="col-md-4">'+
                    '  ColumnType'+
                    ' <select  name="columnType'+id+'"   >'+
                    '    <option value="">Select</option> '+
                    '    <option value="textField">textField</option> '+
                    '   <option value="date">date</option> '+
                    '  <option value="textarea">textarea</option> '+
                    '  <option value="dropdown">dropdown</option> '+
                    '  <option value="file">file</option> '+

                    ' </select>'+
                    ' </div>'+
                        
                    ' </div>'+
                    ' <div class="form-group row">'+
                    '    <label class="control-label col-md-3">   '+
                    '   </label>'+

                    '    <div class="col-md-4">'+
                    '        Default value'+
                    '        <input type="text" name="Default'+id+'"  value="" class="form-control"/>'+
                    '    </div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                    '   <label class="control-label col-md-3">   '+
                    '   </label>'+

                    '   <div class="col-md-4">'+
                    '       Max Lenght'+
                    '      <input type="text" name="maxLenght'+id+'"  value="" class="form-control"/>'+
                    '  </div>'+
                    ' </div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3"> '+  
                        ' </label>'+

                        ' <div class="col-md-4">'+
                        '  Check '+
                        '  <input type="text" name="check'+id+'"  value="" class="form-control"/>'+
                        '</div>'+
                    ' </div>'+ 
                    '<div class="form-group row" >'+
                            '<label class="control-label col-md-3">'+
                            '</label>'+
                            '<div class="col-md-4" id = "deleteColumns">'+
                                '<button  type="button"  onclick="DeleteColumn(\''+(parseInt(id))+'\')" > Delete Column </button> '+    
                            '</div> '+
                    '</div></div>';

            text.innerHTML =val;
            $( val ).insertAfter( '#sqlDiv'+(parseInt(id)-1) );

     $("#AddColumns").empty();   
                      
     $("#AddColumns").append('<button  type="button"  onclick="AddMoreColumns(\''+(parseInt(id)+1)+'\')" >  Add More Columns </button> ');
        
    }
</script>
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>