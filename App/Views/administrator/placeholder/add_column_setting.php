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
                    <header>Add Column Setting </header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>save_column_setting" method="post" class="form-horizontal">
                        <div class="form-body">
                            <input type="hidden" name="id"
                                   value="<?= $id = (isset($getTableDetails['ID'])) ? $getTableDetails['ID'] : ""; ?>"/>
                           
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Table name 
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="CustomColumnWidthName" required="" data-required="1"
                                           value="<?= $CustomColumnWidthName = (isset($getTableDetails['CustomColumnWidthName'])) ? $getTableDetails['CustomColumnWidthName'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Table description
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="CustomColumnWidthDesc" required="" data-required="1"
                                           value="<?= $CustomColumnWidthDesc = (isset($getTableDetails['CustomColumnWidthDesc'])) ? $getTableDetails['CustomColumnWidthDesc'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Data Table
                                </label>

                                <div class="col-md-4">
                                    <select name="TableId" class="form-control TableId select2-multiple DataTableId" data-maximum-selection-length="1" multiple >
                                        <option value=""> Select</option>
                                        <?php
                                        if ($getDataTable) {
                                            $getDataTableId = (isset($getTableDetails['ID'])) ? $getTableDetails['ID'] : "";
                                            ?>
                                            <?php foreach ($getDataTable as $key => $getDataTableValue) {
                                                $selected = '';
                                                if ($getDataTableValue['ID'] == $getDataTableId) {
                                                    $selected = 'selected="selected"';
                                                }
                                                ?>
                                                <option <?= $selected; ?>
                                                    value="<?= $getDataTableValue['ID']; ?>"><?= $getDataTableValue['Name']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                            <div id="ColumnFilterWidth" >
                                            
                            <?php if ( isset($getTableDetails['EnableFilterWidth1']) && ($getTableDetails['EnableFilterWidth1'] == 1) ){ ?>
                                    
                            <?php  $columwidth = json_decode($getTableDetails['CustomColumnWidth'] , true);
                                    $colKey = 1;
                                    foreach( $columwidth as   $columwidthKey => $columwidthVal){ ?>
                                            <div id="ColumnFilterWidth<?=  $colKey;?>">
                                                <div class="form-group row">
                                                    <label class="control-label col-md-3">
                                                        Select column name and its width in px
                                                    </label>
            
                                                    <div class="col-md-4">
                                                        <select name="ColumnWidthName<?= $colKey;?>" id="ColumnWidthName<?= $colKey;?>"  class="form-control  dataTableColumns" >
                                                            <option value="">Select</option>
                                                        
                                                            <?php 
                                                                $existingColumnsOfColWidth = isset($getTableDetails['Columns'])?$getTableDetails['Columns']:'';;
                                                                if ($existingColumnsOfColWidth) {
                                                                
                                                                
                                                                    $existingColumnsOfColWidth = explode(',', $existingColumnsOfColWidth);
                                                                    if ($existingColumnsOfColWidth) {
                                                                        foreach ($existingColumnsOfColWidth as $key => $value) {
                                                                            $selected = "";
                                                                            $value = trim($value);
                                                                            if ( $value == $columwidthKey ) {
                                                                                $selected = 'selected="selected"';
                                                                            }
                                                                            echo '<option value= "' . $value . '"' . $selected . '>' . $value . '</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="control-label col-md-3">
                                                        
                                                    </label>
            
                                                    <div class="col-md-4">
                                                        <input type="text" name="ColumnWidth<?=  $colKey;?>" 
                                                            value="<?= $columwidthVal; ?>"
                                                            class="form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php $colKey = $colKey +1 ;}?>
                            
                            <?php  $colKey = $colKey - 1 ; }else{  $colKey = 1;?>
                            <div id="ColumnFilterWidth1">
                                <div class="form-group row">
                                    <label class="control-label col-md-3">
                                        Select column name and its width in px
                                    </label>

                                    <div class="col-md-4">
                                        <select name="ColumnWidthName1" id="ColumnWidthName1"  class="form-control  dataTableColumns" >
                                            <option value="">Select</option>
                                        
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">
                                        
                                    </label>

                                    <div class="col-md-4">
                                        <input type="text" name="ColumnWidth1" 
                                            value=""
                                            class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    
                                </label>
                                <div class="col-md-4">
                                    <input type ="hidden" name="TotalColumns" id="TotalColumns" value="<?php echo $colKey;?>"  />
                                    <button  type="button" id = "AddColWidthBtn" onclick="AddNewColWDiv()" >  Add width for another column </button>          
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


function ShowColWidth(checkbox){
    if (checkbox.checked)
    {
       $('#ColumnFilterWidth').show();
   }else{
        $('#ColumnFilterWidth').hide();
   }
}
function AddNewColWDiv(){
   
    var num = document.getElementById('TotalColumns').value;
     var oldnum = num;        
    num = parseInt(num)+1;
 
    document.getElementById('TotalColumns').value = num;
    var text = document.createElement('div');
 
    var val = '';
    
    val += '    <div id="ColumnFilterWidth'+num+'">'+
                                    '<div class="form-group row">'+
                                       ' <label class="control-label col-md-3">'+
                                           ' Select column name and its width in px'+
                                        '</label>'+

                                       ' <div class="col-md-4">'+
                                            '<select name="ColumnWidthName'+num+'" id="ColumnWidthName'+num+'"  class="form-control  dataSourceColumns" >'+
                                              
                                               
                                              
                                           ' </select>'+
                                        '</div>'+
                                   ' </div>'+
                                    '<div class="form-group row">'+
                                        '<label class="control-label col-md-3">'+
                                            
                                        '</label>'+

                                        '<div class="col-md-4">'+
                                         '   <input type="text" name="ColumnWidth'+num+'"  value="" class="form-control"/>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';


                   
                    text.innerHTML =val;
                   
                    $( val ).insertAfter( '#ColumnFilterWidth'+oldnum );
                    var $options = $('#ColumnWidthName1 option').clone();
                    console.log($options);
                    $('#ColumnWidthName'+num).append($options);
                  

}
</script>
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>