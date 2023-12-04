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
                    <header>Add Linking Tables</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>saveTwoTable" method="post" id="form_sample_1" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group row">
                                <label class="control-label col-md-3">Name
                                    <span class="required"> * </span>
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="Name" value="<?php if(isset($twoTableDetail['Name'])) {echo $twoTableDetail['Name']; } ?>" required data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Description
                                    <span class="required"> * </span>
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="Description" value="<?php if(isset($twoTableDetail['Description'])) {echo $twoTableDetail['Description']; } ?>" required data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Common Field
                                    <span class="required"> * </span>
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="commonField" value="<?php if(isset($twoTableDetail['commonField'])) {echo $twoTableDetail['commonField']; } ?>" required data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div id="CloneDiv1">
                               
                                   <?php
                                    if(!isset($twoTableDetail)){ ?>
                                     <div class="form-group row" >
                                        <label class="control-label col-md-3">
                                            Table_1 Data Table
                                        </label>
                                   
                                        <div class="col-md-4">
                                            <select name="TableId" class="form-control TableId select2-multiple DataTableId" data-maximum-selection-length="1" multiple >
                                                <option value=""> Select</option>
                                                <?php
                                                if ($getDataTable) {
                                                
                                                    ?>
                                                    <?php foreach ($getDataTable as $key => $getDataTableValue) {
                                                    
                                                        ?>
                                                        <option 
                                                            value="<?= $getDataTableValue['ID']; ?>"><?= $getDataTableValue['Name']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php } else{ 
                                       
                                        $tables = explode(',' , $twoTableDetail['TableId']);  
                                        $cnt = count($tables) ;
                                        for ($i=0; $i < count($tables) ; $i++) { ?>
                                         <div class="form-group row" >
                                            <label class="control-label col-md-3">
                                                Table_<?= $i+1; ?> Data Table
                                            </label>
                                            <div class="col-md-4">
                                            <?php if($i == 0){?>
                                                    <select name="TableId" class="form-control TableId select2-multiple DataTableId" data-maximum-selection-length="1" multiple >
                                                   
                                                <?php } else { ?>
                                                    <select name="TableId<?= $i; ?>" class="form-control TableId select2-multiple DataTableId" data-maximum-selection-length="1" multiple >
                                                   
                                                <?php } ?>
                                                <option value=""> Select</option>
                                                    <?php
                                                    if ($getDataTable) {
                                                    
                                                        ?>
                                                        <?php foreach ($getDataTable as $key => $getDataTableValue) {
                                                        
                                                            ?>
                                                            <option 
                                                                value="<? $getDataTableValue['ID']; ?>" <?php  if($tables[$i]  == $getDataTableValue['ID'] ){?> selected <?php } ?> ><?= $getDataTableValue['Name']; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            </div> 
                                       <?php }
                                        ?>
                                       
                                    <?php }   ?>
                                

                            </div>
                            <div class="form-group row" id ="moreTablediv">
                                    <label class="control-label col-md-3">
                                    </label>

                                    <div class="col-md-4">
                                        <input type="button"  onclick="Clonetable();" value= "Add More Tables "/>
                                    </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <div class="offset-md-3 col-md-9">
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
        
                    // if( j== 1 ){
                    //     j = id;
                    // }
                    <?php  if(isset($cnt))
                    {?> 
                        j = <?php echo $cnt; ?>
                    <?php }
                    ?>
                    
    if(j > 3 ){
        alert('Only 4 Tables can be linked') ;
    }else{
                    var original = document.getElementById('CloneDiv'+j);
                    var text = document.createElement('div');
                    text.id = "CloneDiv" + ++j;
                    var val = '';
                    
                    val += ' <div class="form-group row" >'+
                             '<label class="control-label col-md-3">'+
                                   '     Table_'+j+'Data Table </label>'+
                                  
                                        '<div class="col-md-4">                                        <select name="TableId'+j+'" class="form-control select2-multiple DataTableId" data-maximum-selection-length="1"  >              <option value=""> Select</option> '+  <?php
                                            if ($getDataTable) {
                                              
                                                ?> 
                                                <?php foreach ($getDataTable as $key => $getDataTableValue) {
                                                   
                                                    ?>
                                                    '<option                                                         value="<?= $getDataTableValue['ID']; ?>"><?= $getDataTableValue['Name']; ?></option>'+                                                <?php } ?>
                                            <?php } ?>
                                        '</select>'+'</div>'+                                                                             
                               ' </div>   ';                
                    
                    text.innerHTML =val;
           
                    if(original == null)
                    {
                        $( "#moreTablediv" ).before(text);
                        
                    }else{
                        original.after(text);
                    }

        
    }
                } 
</script>
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>