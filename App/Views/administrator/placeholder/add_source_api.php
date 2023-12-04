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
                    <header>Add Data Source Table API</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>saveDataSource" method="post" class="form-horizontal">
                        <div class="form-body">
                            <input type="hidden" name="id"
                                   value="<?= $id = (isset($dataSourceDetails['ID'])) ? $dataSourceDetails['ID'] : ""; ?>">

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Name
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Name" required="" data-required="1"
                                           value="<?= $name = (isset($dataSourceDetails['Name'])) ? $dataSourceDetails['Name'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Descriptions
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Descriptions" required="" data-required="1"
                                           value="<?= $descriptions = (isset($dataSourceDetails['Descriptions'])) ? $dataSourceDetails['Descriptions'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Enter Source Adress
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="SourceAddress" required="" data-required="1"
                                           value="<?= $sourceAddress = (isset($dataSourceDetails['SourceAddress'])) ? $dataSourceDetails['SourceAddress'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                     Linked External Api Address
                                    
                                </label>

                                <div class="col-md-4">
                                    <?php $ExternalAPIReq = (isset($dataSourceDetails['ExternalAPIReq'])) ? $dataSourceDetails['ExternalAPIReq'] : ""; ?>
                                    <select name="ExternalAPIReq" class="form-control callType">

                                        <option value="" <?php if(empty($ExternalAPIReq)) echo "selected='selected'"; ?>>API</option>

                                        <?php

                                        foreach($allExternalApiUrl as $key => $value){
                                            
                                        ?>
                                          <option value="<?php echo $value['Address'];?>" <?php if($ExternalAPIReq == $value['Address']) echo "selected='selected'"; ?>><?php echo $value['AddressName'];?> </option>

                                        <?php  }?>
                                        

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Request Type
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <?php $requestType = (isset($dataSourceDetails['RequestType'])) ? $dataSourceDetails['RequestType'] : ""; ?>
                                    <select name="RequestType" class="form-control callType" required="">
                                        <option value="" <?php if(empty($requestType)) echo "selected='selected'"; ?>>Request Type</option>
                                        <option value="1" <?php if($requestType == 1) echo "selected='selected'"; ?>>Get</option>
                                        <option value="2" <?php if($requestType == 2) echo "selected='selected'"; ?>>Post</option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    API Headers
                                </label>

                                <div class="col-md-4">
                                    <textarea name="Headers"
                                    <?php  if(isset($dataSourceDetails['Headers']) && ($dataSourceDetails['Headers'] != '') ) {$Headers = $dataSourceDetails['Headers'] ;}else{ $Headers = '';} ?>
                                    class="form-control"><?=  $Headers ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Api Type
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <?php $apiType = (isset($dataSourceDetails['ApiType'])) ? $dataSourceDetails['ApiType'] : ""; ?>
                                    <select name="ApiType" id = "ApiType" class="form-control callType" required="" onchange="showDiv(this);">
                                        <option value="" <?php if(empty($apiType)) echo "selected='selected'"; ?>>Api Type</option>
                                        <option value="1" <?php if($apiType == 1) echo "selected='selected'"; ?>>Single Nodes</option>
                                        <option value="2" <?php if($apiType == 2) echo "selected='selected'"; ?>>Multiple Nodes</option>
                                        <option value="3" <?php if($apiType == 3) echo "selected='selected'"; ?>>Inner Node for Column and value </option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Body
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <textarea name="Body"
                                           class="form-control"> <?= $body = (isset($dataSourceDetails['Body'])) ? $dataSourceDetails['Body'] : ""; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Columns
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Columns" required="" data-required="1"
                                           value="<?= $columns = (isset($dataSourceDetails['Columns'])) ? $dataSourceDetails['Columns'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row" style="display: none;" id ="apiType3" >
                                <label class="control-label col-md-3">
                                        Node for Column Name
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="GetColumnName" 
                                           value="<?= $apiData = (isset($dataSourceDetails['GetColumnName'])) ? $dataSourceDetails['GetColumnName'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row" style="display: none;" id ="apiType4" >
                                <label class="control-label col-md-3">
                                    Node for Column Value
                                    
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="GetValueName" 
                                           value="<?= $GetValueName = (isset($dataSourceDetails['GetValueName'])) ? $dataSourceDetails['GetValueName'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                             <div class="form-group row" style="display: none;" id ="d_col" >
                                <label class="control-label col-md-3">
                                    Display Name for Columns
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <textarea name="DisplayColumnName"
                                              class="form-control"> <?= $DisplayColumnName = (isset($dataSourceDetails['DisplayColumnName'])) ? $dataSourceDetails['DisplayColumnName'] : ""; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Columns Properties
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <textarea name="ColumnsProperties"
                                              class="form-control"> <?= $ColumnsProperties = (isset($dataSourceDetails['ColumnsProperties'])) ? $dataSourceDetails['ColumnsProperties'] : ""; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Parameter
                                    <span class="required"></span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Placeholder"
                                           value="<?= $placeholder = (isset($dataSourceDetails['Placeholder'])) ? $dataSourceDetails['Placeholder'] : ""; ?>"
                                           class="form-control"/>
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
                                    <a class="btn deepPink-bgcolor" href="<?php echo baseUrl; ?>data_source">Cancel
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
$(document).ready(function() {
    if($("#ApiType").val() == 2)
    {
       $("#d_col").show(); 
    }
    if($("#ApiType").val() == 3)
    {
       $("#apiType3").show(); 
       $("#apiType4").show(); 
    }
});
function showDiv(sel){
    if(sel.value == 2)
    {
       $("#d_col").show(); 
    }else{
        $("#d_col").hide(); 
    }
    if(sel.value == 3)
    {
       $("#apiType3").show(); 
       $("#apiType4").show(); 
    }else{
        $("#apiType3").hide(); 
        $("#apiType4").hide(); 
    }

}
    
</script>
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>