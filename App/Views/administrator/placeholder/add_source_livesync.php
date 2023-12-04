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
                    <header>Add Data Source Table API POST</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>saveDataSource" method="post" class="form-horizontal">
                        <div class="form-body">
                            <input type="hidden" name="id"
                                   value="<?= $id = (isset($dataSourceDetails['ID'])) ? $dataSourceDetails['ID'] : ""; ?>">

                            <input type="hidden" name="updateDataSource" value="1">

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
                                    Enter POST Source Adress
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="SourceAddress_2" required="" data-required="1"
                                           value="<?= $sourceAddress2 = (isset($dataSourceDetails['SourceAddress_2'])) ? $dataSourceDetails['SourceAddress_2'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Post Request Type
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <?php $requestType2 = (isset($dataSourceDetails['RequestType_2'])) ? $dataSourceDetails['RequestType_2'] : ""; ?>
                                    <select name="RequestType_2" class="form-control" required="">
                                        <option value="" <?php if(empty($requestType2)) echo "selected='selected'"; ?>>Request Type</option>
                                        <option value="1" <?php if($requestType2 == 1) echo "selected='selected'"; ?>>Get</option>
                                        <option value="2" <?php if($requestType2 == 2) echo "selected='selected'"; ?>>Post</option>
                                    </select>
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

                                            $Apis = json_decode( $value['CompanyDBPass'] , true);
                                            if($Apis != ''){
                                            foreach( $Apis as $k => $v)
                                            {
                                        ?>
                                          <option value="<?php echo $v[0];?>" <?php if($ExternalAPIReq == $v) echo "selected='selected'"; ?>><?php echo $v[0];?> </option>

                                        <?php }  }}?>
                                        

                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Post Body
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <textarea name="Body_2" required="" data-required="1"
                                              class="form-control"> <?= $body2 = (isset($dataSourceDetails['Body_2'])) ? $dataSourceDetails['Body_2'] : ""; ?></textarea>
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
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>