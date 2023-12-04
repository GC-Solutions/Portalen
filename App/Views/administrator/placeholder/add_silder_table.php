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
                    <header>Add Slider table </header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>save_slider_table" method="post" class="form-horizontal">
                        <div class="form-body">
                            <input type="hidden" name="id"
                                   value="<?= $id = (isset($getTableDetails['ID'])) ? $getTableDetails['ID'] : ""; ?>"/>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Slider Table name
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Name" required="" data-required="1"
                                           value="<?= $Name = (isset($getTableDetails['Name'])) ? $getTableDetails['Name'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                Slider Table description
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Descriptions" required="" data-required="1"
                                           value="<?= $descriptions = (isset($getTableDetails['Descriptions'])) ? $getTableDetails['Descriptions'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div  id = 'sideBar' >
                               
                                <div id='SideBarTab'>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Table for Tab 1 or design 1
                                        </label>
                                        <?php
                                        $TableSideBar = (isset($getTableDetails['TableSideBar'])) ? $getTableDetails['TableSideBar'] : "";
                                        
                                        ?>
                                        <div class="col-md-4">
                                            <select class="form-control  select2-multiple" data-maximum-selection-length="1" multiple name="TableSideBar">
                                                <option value="">Select</option>
                                                <?php foreach ($getAllTable as $key => $value) {
                                                    $selectedOption = "";

                                                    if ($TableSideBar == $value['ID']) {
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
                                                Action on Silder Tabs 1 or design 1
                                                
                                            </label>
                                            <?php
                                            $selectedPlaceholderActionValue = (isset($getTableDetails['TabAction'])) ? $getTableDetails['TabAction'] : "";

                                            if ($selectedPlaceholderActionValue) {
                                                $selectedPlaceholderActionValue = explode(',', $selectedPlaceholderActionValue);
                                            }
                                            ?>
                                            <div class="col-md-4">
                                                <select name="TabAction[]" id="multiple"
                                                        class="form-control select2-multiple dataSourceColumns"
                                                        multiple>
                                                    <option value=""> Select</option>
                                                    <?php foreach ($getAllTableActions as $key => $value) {
                                                        $selectedOption = "";
                                                        if (!empty($selectedPlaceholderActionValue)) {
                                                            if (in_array($value['ID'], $selectedPlaceholderActionValue)) {
                                                                $selectedOption = "selected='selected'";
                                                            }
                                                        }
                                                        ?>
                                                        <option <?= $selectedOption; ?>
                                                            value="<?php echo $value['ID']; ?>"><?php echo $value['Name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                </div>
                                <div id='SideBarTab2' style='display:none;'>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Table for Tab 2
                                        </label>
                                        <?php
                                        $TableSideBar = (isset($getTableDetails['TableSideBar2'])) ? $getTableDetails['TableSideBar2'] : "";
                                        
                                        ?>
                                        <div class="col-md-4">
                                            <select class="form-control  select2-multiple" data-maximum-selection-length="1" multiple name="TableSideBar2">
                                                <option value="">Select</option>
                                                <?php foreach ($getAllTable as $key => $value) {
                                                    $selectedOption = "";

                                                    if ($TableSideBar == $value['ID']) {
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
                                                Action on Silder Tabs 2
                                                
                                            </label>
                                            <?php
                                            $selectedPlaceholderActionValue = (isset($getTableDetails['TabAction2'])) ? $getTableDetails['TabAction2'] : "";

                                            if ($selectedPlaceholderActionValue) {
                                                $selectedPlaceholderActionValue = explode(',', $selectedPlaceholderActionValue);
                                            }
                                            ?>
                                            <div class="col-md-4">
                                                <select name="TabAction2[]" id="multiple"
                                                        class="form-control select2-multiple dataSourceColumns"
                                                        multiple>
                                                    <option value=""> Select</option>
                                                    <?php foreach ($getAllTableActions as $key => $value) {
                                                        $selectedOption = "";
                                                        if (!empty($selectedPlaceholderActionValue)) {
                                                            if (in_array($value['ID'], $selectedPlaceholderActionValue)) {
                                                                $selectedOption = "selected='selected'";
                                                            }
                                                        }
                                                        ?>
                                                        <option <?= $selectedOption; ?>
                                                            value="<?php echo $value['ID']; ?>"><?php echo $value['Name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                </div>
                                <div id='SilderAddMore' class = "form-group row">
                                    <div class="control-label col-md-3 "></div>
                                    <div class="col-md-4 btn-group">
                                        <button onclick="AddMoreTab()" type="button" class="btn btn-info">
                                            Add more <i class="fa fa-plus"></i>
                                        </button>
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

     <?php 
      if ( isset($getTableDetails["TableSideBar2"]) &&  $getTableDetails['TableSideBar2'] == '1') { ?>
       $('#SideBarTab2').show();
        <?php } ?>
  
    function AddMoreTab(){
        $('#SideBarTab2').show();    
    }    


</script>
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>