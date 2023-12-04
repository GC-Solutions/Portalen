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
                    <header>Add Parameter</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>saveparameter" method="post" id="form_sample_1" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group row">
                                <label class="control-label col-md-3"> Parameter Name
                                    <span class="required"> * </span>
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="ParamName" value="<?php if(isset($paramDetail['ParamName'])) {echo $paramDetail['ParamName']; } ?>" required data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">Parameter Value
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="ParamValue" 
                                    value="<?php if(isset($paramDetail['ParamValue'])) {echo $paramDetail['ParamValue']; } ?>"  required data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Parameter type
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <?php
                                    $ParamType = (isset($paramDetail['ParamType'])) ? $paramDetail['ParamType'] : "";
                                    ?>
                                    <select name="ParamType" class="form-control" required="">
                                        <option value=""> Select</option>
                                        <option value="1" <?php if ($ParamType == 1) {
                                            echo "selected='selected'";
                                        } ?>>Global
                                        </option>
                                        <option value="2" <?php if ($ParamType == 2) {
                                            echo "selected='selected'";
                                        } ?>>Selective
                                        </option>
                                       
                                    </select>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Color
                                   
                                </label>

                                <div class="col-md-4">
                                    <?php
                                    $Color = (isset($paramDetail['Color'])) ? $paramDetail['Color'] : "";
                                    ?>
                                    <select name="Color" class="form-control" >
                                        <option value=""> Select</option>
                                        <option value="1" <?php if ($Color == 1) {
                                            echo "selected='selected'";
                                        } ?>>Red
                                        </option>
                                        <option value="2" <?php if ($Color == 2) {
                                            echo "selected='selected'";
                                        } ?>>Green
                                        </option>
                                        <option value="3" <?php if ($Color == 3) {
                                            echo "selected='selected'";
                                        } ?>>Blue
                                        </option>
                                       
                                    </select>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Type
                                   
                                </label>

                                <div class="col-md-4">
                                    <?php
                                    $DataType = (isset($paramDetail['DataType'])) ? $paramDetail['DataType'] : "";
                                    ?>
                                    <select name="DataType" class="form-control" >
                                        <option value=""> Select</option>
                                        <option value="1" <?php if ($DataType == 1) {
                                            echo "selected='selected'";
                                        } ?>>Generic
                                        </option>
                                        <option value="2" <?php if ($DataType == 2) {
                                            echo "selected='selected'";
                                        } ?>>Numeric
                                        </option>
                                        <option value="3" <?php if ($DataType == 3) {
                                            echo "selected='selected'";
                                        } ?>>Date
                                        </option>
                                        <option value="4" <?php if ($DataType == 4) {
                                            echo "selected='selected'";
                                        } ?>>Text
                                        </option>
                                       
                                    </select>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Fill Type
                                   
                                </label>

                                <div class="col-md-4">
                                    <?php
                                    $FillType = (isset($paramDetail['FillType'])) ? $paramDetail['FillType'] : "";
                                    ?>
                                    <select name="FillType" class="form-control" >
                                        <option value=""> Select</option>
                                        <option value="1" <?php if ($FillType == 1) {
                                            echo "selected='selected'";
                                        } ?>>Inner
                                        </option>
                                        <option value="2" <?php if ($FillType == 2) {
                                            echo "selected='selected'";
                                        } ?>>Column 
                                        </option>
                                        <option value="3" <?php if ($FillType == 3) {
                                            echo "selected='selected'";
                                        } ?>>Row
                                        </option>
                                       
                                       
                                    </select>
                                </div>

                            </div>
                            
                            <div class="form-group row" >
                                <label class="control-label col-md-3">
                                    Rule 1 <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    Change value 1 
                                </label>
                                <div class="col-md-9" id="rules">
                                    <div class="col-md-3">
                                        <input placeholder="first parameter" type="text" name="param1" 
                                        value="<?php if(isset($paramDetail['ParamValue'])) {echo $paramDetail['ParamValue']; } ?>"  
                                               class="form-control"/>
                                    </div>
                                    <div class="col-md-3">
                                         <select name="paramcondition" class="form-control" >
                                            <option value=""> Select</option>
                                            <option value="=" >  is Equal
                                            </option>
                                            <option value="!=" > is Not Equal
                                            </option>
                                            <option value=">" > is Greater
                                            </option>
                                            <option value="<" > is Less then 
                                            </option>
                                             <option value=">=" > is Greater then and equal to
                                            </option>
                                            <option value="<=" > is Less then and equal to
                                            </option>
                                           
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input placeholder="Second parameter" type="text" name="param2" 
                                        value="<?php if(isset($paramDetail['ParamValue'])) {echo $paramDetail['ParamValue']; } ?>"  
                                               class="form-control"/>
                                    </div>
                                   
                               
                                    <div class="col-md-3">
                                        <input  placeholder="Change Value 1" type="text" name="param1" 
                                        value="<?php if(isset($paramDetail['ParamValue'])) {echo $paramDetail['ParamValue']; } ?>"  
                                               class="form-control"/>
                                         <small class="text-muted">Value when the condition is agreed .</small>
                                    </div>
                                    
                                
                          
                                </div>
                                <!-- <div class="form-group row" id ="addMoreRuleBtn">
                                    <label class="control-label col-md-3">
                                    </label>

                                    <div class="col-md-4">
                                        <input type="button"  onclick="Clonetable();" value= "Add More Rules "/>
                                    </div>
                                </div> -->
                            </div>
                            
                           

                            <input type="hidden" name="id" value="<?php if(isset($paramDetail['id'])) {echo $paramDetail['id']; } ?>">
                        </div>
                        <div class="form-group row ">
                                <label class="control-label col-md-3">Authorization 
                                           
                                </label>
                                <div class="col-md-4">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-info">
                                        Save <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">

var j = 1;
function Clonetable(){
        
    

    var original = document.getElementById('rules');
    var text = document.createElement('div');
    text.className = "col-md-9";
    text.id = "rules" + ++j;
   
    var val = '';

    val += '<div class="col-md-3">'+
                '<select name="paramConnectingCondition" class="form-control" >'+
                    '    <option value=""> Select</option>'+
                    '    <option value="&" > And '+
                     '    <option value="||" > Or '+
                    '    </option>'+
                    '</select>'+
                '</div>';

    val += '    <div class="col-md-3">'+
                '<input placeholder="first parameter" type="text" name="param1" value="<?php if(isset($paramDetail['ParamValue'])) {echo $paramDetail['ParamValue']; } ?>"  required data-required="1" class="form-control"/>'+
                '</div>'+
                '<div class="col-md-3">'+
                    '<select name="paramcondition" class="form-control" >'+
                    '    <option value=""> Select</option>'+
                    '    <option value="=" >  is Equal'+
                    '    </option>'+
                    '    <option value="!=" > is Not Equal'+
                    '    </option>'+
                    '    <option value=">" > is Greater'+
                    '    </option>'+
                    '    <option value="<" > is Less then '+
                    '    </option>'+
                    '     <option value=">=" > is Greater then and equal to'+
                    '    </option>'+
                    '    <option value="<=" > is Less then and equal to'+
                    '    </option>'+
                       
                    '</select>'+
                    '</div>'+
                    '<div class="col-md-3">'+
                    '<input placeholder="Second parameter" type="text" name="param2"  value="<?php if(isset($paramDetail['ParamValue'])) {echo $paramDetail['ParamValue']; } ?>"  required data-required="1"  class="form-control"/> '+
                    '</div>';                
    
    text.innerHTML =val;

    if(original == null)
    {
        $( "#addMoreRuleBtn" ).before(text);
        
    }else{
        original.after(text);
    }

        
    
} 
</script>
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>