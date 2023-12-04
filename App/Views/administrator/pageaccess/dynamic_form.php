
<?php if($PageDesign != '2' ){?>
    <?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_update_formTest.php'; ?> 

    <div class="page-container">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12 col-sm-12" style="margin: auto; top: 0;">
                    <div class="card card-box">
                        
                        <form action="<?php echo $actionButton; ?>" method="post" enctype="multipart/form-data"
                              class="form-horizontal"  >
                           
                           
                            <?php if ($DetailColumns) {
                                $DetailColumns = json_decode($DetailColumns , true);
                                $HiddenColumns = json_decode($HiddenColumns , true);
                                
                                foreach ($DetailColumns as $key => $eachRow) { 
                                    if($AllReadOnly){
                                        if(!isset($eachRow['readType'])){
                                            $eachRow['readType']='readonly';
                                        }
                                    }
                                    ?>
                                    <div class="form-body">

                                        <?php if($eachRow['columnType'] == 'textField')
                                        { 
                                            $default = isset($eachRow['Default'])?$eachRow['Default']:'';
                                        ?>
                                            <div class="form-group row">
                                                <label class="control-label col-md-5">
                                                    <?= $key;?>
                                                </label>
                                               
                                                <div class="col-md-5">
                                                    <input type="text" id="<?= trim($eachRow['columnName']);?>" name="<?= trim($key);?>" value="<?= $default?>" class="form-control" <?php if(isset($eachRow['maxLenght'])){ ?>  maxlength="<?=$eachRow['maxLenght'];?>"   <?php } ?>   <?php if(isset($eachRow['readType'])){ ?> readonly <?php } ?>  />
                                                </div>
                                            </div>
                                        <?php } else if ($eachRow['columnType'] == 'date'){?>
                                            <div class="form-group row">
                                                <label class="control-label col-md-5">
                                                    <?= $key;?>
                                                </label>
                                                <div class="col-md-5">
                                                    <?php $dateId = $eachRow['check'] ;
                                                        if($dateId == 'currDate'){
                                                            $dateId = 'datetimepicker1';
                                                        }elseif($dateId == 'currDatewithTime'){
                                                            $dateId = 'datetimepicker3';
                                                        }elseif($dateId == '15dateAfter'){
                                                            $dateId = 'datetimepicker2';
                                                        }
                                                        $format = isset($eachRow['dateformat'])?$eachRow['dateformat']:'Y-m-d h:i:s';

                                                    ?>
                                                    <div class='input-group date' id='<?= $dateId ;?>'>
                                                        <?php if($dateId == 'datetimepicker3'){ ?>
                                                            <input type='text' class="form-control"  name="<?= trim($key);?>" value="<?= date('Y-m-d h:i:s');?>" readonly />
                                                        <?php }else{ ?>
                                                            <input type='text' class="form-control" name="<?= trim($key);?>" value="<?= date('Y-m-d');?>" <?php if(isset($eachRow['readType'])){ ?> readonly <?php } ?> />
                                                        <?php } ?>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php } else if ($eachRow['columnType'] == 'dropdown'){?>
                                            <div class="form-group row">
                                                <label class="control-label col-md-5">
                                                    <?= $key;?>
                                                </label>
                                                    <div class="col-md-5">
                                                        <select  name="<?= trim($key);?>"  id ="<?= trim($eachRow['columnName']);?>"  >
                                                            <option value="">Select</option>   
                                                            <?php
                                                            $ftnname =  $eachRow['fetchDataFrom'];
                                                            $ftnVal = $$ftnname;
                                                            
                                                            foreach ($ftnVal as $cuskey => $cusvalue) {?>
                                                            <?php if($ftnname == 'getAllPaymentCustomer') 
                                                            {?>
                                                                <option  value="<?= $cusvalue['AccountNumber'];?>" ><?= $cusvalue['AccountNumber'];?> </option>   
                                                            <?php }elseif($ftnname == 'getAllAbsenceReasons'){ ?>
                                                                <option  value="<?= $cusvalue;?>" ><?= $cusvalue;?> </option> 
                                                            <?php }elseif($ftnname == 'getAllActivity'){?>
                                                                <option  value="<?= $cusvalue;?>" ><?= $cusvalue;?> </option> 
                                                            <?php }else {?>
                                                                <option  value="" ><?= $cusvalue;?> </option>   
                                                            <?php }} ?>
                                                        </select>
                                                           
                                                    </div>
                                            </div>
                                        <?php }else if ($eachRow['columnType'] == 'textarea'){?>
                                            <div class="form-group row">
                                                <label class="control-label col-md-5">
                                                    <?= $key;?>
                                                </label>
                                                <div class="col-md-5">
                                                    <textarea rows="4" cols="13" id="<?= trim($eachRow['columnName']);?>" name="<?= trim($key);?>"  <?php if(isset($eachRow['readType'])){ ?> readonly <?php } ?> > </textarea>
                                                
                                                </div>
                                            </div>
                                        <?php }elseif($eachRow['columnType'] == 'file') { ?>
                                            <div class="form-group row">
                                                <label class="control-label col-md-5">
                                                    <?= $key;?>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="file" name="<?=$key?>" id="<?=$key?>" >
                                                </div>
                                            </div>

                                         <?php  }  ?>
                                        
                                    </div>
                               
                            <?php } } ?>
                            <?php  if($lSearch == '1'){ ?>
                                        <input type="hidden" id="LSearch" name="LSearch" value="1" class="form-control"/>
                            <?php } ?>
                            <input type="hidden" id="ID" name="ID" value="" class="form-control"/>
                            <input type="hidden" id="action" name="action" value="<?= $action;?>"  class="form-control"/>
                            <?php if($HiddenColumns){
                                foreach ($HiddenColumns as $Hiddenkey => $HiddenColumn) {?>
                            <input type="hidden" id="<?= $Hiddenkey;?>" name="<?= $Hiddenkey;?>" value="<?= $HiddenColumn['columnValue'];?>" class="form-control"/>
                            
                            <?php } }?>
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="offset-md-5 col-md-7">
                                        <div class="btn-group">
                                        
                                            <button type="submit" class="btn btn-danger">
                                              
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                       
                        </form>
                    </div>
                </div>
            </div>

            <!-- wizard with validation-->
        </div>
    </div>
<?php }else{ ?>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

    <script type='text/javascript'>
    var date = new Date();
    date.setDate(date.getDate() + 15);

            $( document ).ready(function() {
                $('#datetimepicker3').datetimepicker({
                    format: 'YYYY-MM-DD HH:mm:ss',
                    
                });
                $('#datetimepicker2').datetimepicker({
                    format: 'YYYY-MM-DD'
                    //minDate: date
                });
                $('#datetimepicker1').datetimepicker({format: 'YYYY-MM-DD'});
                $('.dateNew').datetimepicker({format: 'YYYY-MM-DD'});
            });
    </script>
    
    <!-- <div class="page-container">
        <div class="page-content">  -->
            <!-- <div class="row">
                <div class="col-md-12 col-sm-12" style="margin: auto; top: 0;">
                    <div class="card card-box">  -->
                            <form action="<?php echo $actionButton; ?>"  method="post" enctype="multipart/form-data" >
                                
                                <div class="card-body row">
                                    <?php if ($DetailColumns) {
                                    $DetailColumns = json_decode($DetailColumns , true);
                                    $HiddenColumns = json_decode($HiddenColumns , true);
                                    $newNum = 4;
                                    foreach ($DetailColumns as $key => $eachRow) { ?>
                                        
                                        <?php
                                       
                                         $newNum=  $newNum+1;
                                         $default = isset($eachRow['Default'])?$eachRow['Default']:''; 
                                        if (isset($eachRow) && isset($eachRow['displayColumnName'])) {
                                            $displayColumnName = $eachRow['displayColumnName'];
                                        }else {
                                            $displayColumnName = trim($key);
                                        }
                                        if ($eachRow['columnType'] == 'dropdown'){?>
                                            <div class="col-lg-6 p-t-20">
                                                <!-- Select with arrow-->
                                                <label for="<?= $key;?>" class="mdl-textfield__label"><?= $key;?></label>
                                                   
                                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height select-width is-dirty is-upgraded" style="width: 124px;" data-upgraded="">
                                                   
                                                   <select class="mdl-textfield__input" name="<?= trim($key);?>" id ="<?= trim($eachRow['columnName']);?>" onchange="myFunction()">
                                                    <option>select</option>
                                                    <?php           
                                                        $ftnname =  $eachRow['fetchDataFrom'];
                                                        $ftnVal = $$ftnname;
                                                        
                                                        foreach ($ftnVal as $cuskey => $cusvalue) {?>
                                                        <?php if($ftnname == 'getAllPaymentCustomer') {?>
                                                            <option value="<?= $cusvalue['AccountNumber'];?>"><?= $cusvalue['AccountNumber'];?></option>
                                                        <?php }else{  ?>
                                                            
                                                            <option  <?php 
                                                             $key = trim($key);
                                                             if (isset($columnName) && isset($columnName[$key])) {
                                                                        $default = $columnName[$key];
                                                                     } 
                                                            if (isset($default) && ( trim($default) == trim($cusvalue) )) {
                                                            echo "selected='selected'";
                                                        } ?> value="<?= $cusvalue;?>"><?= $cusvalue;?></option>
                                                        <?php }} ?>
                                                    
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <!-- <div class="col-lg-6 p-t-20">
                                                    <label for="<?= trim($eachRow['columnName']);?>" class="pull-right margin-0">
                                                        <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
                                                    </label>
                                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height txt-full-width">
                                                    <input class="mdl-textfield__input" type="text" name="<?= trim($key);?>"  id ="<?= trim($key);?>" value="" readonly
                                                        tabIndex="-1">
                                                   
                                                    <label for="<?= trim($eachRow['columnName']);?>" class="mdl-textfield__label"> <?= $key;?></label>
                                                    <ul data-mdl-for="<?= trim($eachRow['columnName']);?>" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                                    <?php           
                                                        $ftnname =  $eachRow['fetchDataFrom'];
                                                        $ftnVal = $$ftnname;
                                                        
                                                        foreach ($ftnVal as $cuskey => $cusvalue) {?>
                                                        <?php if($ftnname == 'getAllPaymentCustomer') {?>
                                                            <li class="mdl-menu__item <?= trim($eachRow['columnName']);?>" data-val="<?= $cusvalue['AccountNumber'];?>"><?= $cusvalue['AccountNumber'];?></li>
                                                        <?php }else{?>
                                                            <li class="mdl-menu__item" data-val="<?= $cusvalue;?>"><?= $cusvalue;?></li>
                                                        
                                                        <?php }} ?>
                                                    </ul>
                                                </div>
                                            </div> -->
                                        <?php }elseif($eachRow['columnType'] == 'textField'){ ?>
                                            <?php 
                                                $key = trim($key);
                                                if (isset($columnName) && isset($columnName[$key])) {
                                                           $default = $columnName[$key];
                                                }
                                                 
                                            ?> 
                                            <div class="col-lg-6 p-t-20">
                                                        <label class="mdl-textfield__label"><?= $displayColumnName;?></label>
                                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                                            <input class="mdl-textfield__input" type="text" id="<?= trim($eachRow['columnName']);?>" name="<?= trim($key);?>" value="<?= $default?>" <?php if(isset($eachRow['maxLenght'])){ ?>  maxlength="<?=$eachRow['maxLenght'];?>"   <?php } ?> <?php if(isset($eachRow['readType'])){ ?> readonly = "true" <?php } ?>  >
                                                         </div>
                                            </div>
                                        <?php  } else if ($eachRow['columnType'] == 'date'){?>
                                            
                                            <div class="col-lg-6 p-t-20">
                                                <?php $dateId = isset($eachRow['check'])?$eachRow['check']:'';
                                                      $class = '';
                                                      $dateCheck  = '';
                                                      $defaultDate = '';
                                                    if($dateId == 'currDate' ){
                                                        $dateId = 'datetimepicker1';
                                                    }elseif($dateId == 'currDatewithTime'){
                                                        $dateId = 'datetimepicker3';
                                                    }elseif($dateId == '15dateAfter'){
                                                        $dateId = 'datetimepicker2';
                                                    }else{
                                                        $dateId = 'datetimepicker'.$newNum;
                                                        $defaultDate = isset($eachRow['Default'])?$eachRow['Default']:'';
                                                        $dateCheck  = 'new';
                                                        $class = 'dateNew'; 
                                                    }
                                                ?>
                                                <div class="">
                                                    <div class='input-group date <?= $class ;?>' id='<?= $dateId ;?>'>
                                                        
                                                        <?php if($dateId == 'datetimepicker3'){ ?>
                                                            <input class="mdl-textfield__input" type="text" name="<?= trim($key);?>"  value="<?= date('Y-m-d h:i:s');?>" readonly style="padding-top: 29px;" />
                                                        <?php }elseif($dateCheck == 'new'){?>
                                                            <input class="mdl-textfield__input" type="text" name="<?= trim($key);?>"  value="<?= $defaultDate;?>" style="padding-top: 29px;">
                                                        <?php }else{ ?>
                                                            <input class="mdl-textfield__input input-datepicker-text" type="text" name="<?= trim($key);?>"  value="<?= date('Y-m-d');?>" style="padding-top: 29px;">
                                                        <?php } ?>
                                                        <span class="input-group-addon input-datepicker">
                                                            <!-- <span class="glyphicon glyphicon-calendar"></span> -->
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>

                                                        </span>
                                                    </div>
                                                    
                                                    <label class="mdl-textfield__label"> <?= $displayColumnName;?></label>
                                                </div>
                                            </div>
                                        <?php }elseif($eachRow['columnType'] == 'textarea'){?>           
                                                <div class="col-lg-12 p-t-20">
                                                    <div class="mdl-textfield mdl-js-textfield txt-full-width">
                                                        <textarea class="mdl-textfield__input" rows="4" id="<?= trim($eachRow['columnName']);?>" name="<?= trim($key);?>"></textarea>
                                                        <label class="mdl-textfield__label" for="<?= trim($displayColumnName);?>"> <?= $displayColumnName;?></label>
                                                    </div>
                                                </div>
                                          
                                            <?php  } ?>

                                    <?php }} ?>
                                    <?php  if($lSearch == '1'){ ?>
                                        <input type="hidden" id="LSearch" name="LSearch" value="1" class="form-control"/>
                                    <?php } ?>
                                    <?php  if($ActionURL != ''){ ?>
                                        <input type="hidden" id="ActionURL" name="ActionURL" value="<?= $ActionURL?>" class="form-control"/>
                                    <?php } ?>
                                    <?php if (isset($columnName) && isset($columnName['ID'])) {
                                                           $defaultID = $columnName['ID'];
                                                        }else{ 
                                                            $defaultID = '';
                                                        } ?> 
                                    <input type="hidden" id="ID" name="ID" value="<?= $defaultID;?>" class="form-control"/>
                                    <input type="hidden" id="action" name="action" value="<?= $action;?>"  class="form-control"/>
                                    <?php if($HiddenColumns){
                                        foreach ($HiddenColumns as $Hiddenkey => $HiddenColumn) {?>
                                    <input type="hidden" id="<?= $Hiddenkey;?>" name="<?= $Hiddenkey;?>" value="<?= $HiddenColumn['columnValue'];?>" class="form-control"/>
                                    
                                    <?php } }?>
                                    <div class="col-lg-12 p-t-20 text-center">
                                        <button type="submit"
                                            class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink">Submit</button>
                                        <button type="button" 
                                            class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-default" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </form>
                    <!-- </div>
                </div>
            </div> -->

            <!-- wizard with validation-->
        <!-- </div>
    </div> -->

<?php } ?>

<script>

       
$('body').on("change", "#Customer_AccountNumberform", function () {
        var selectedID = '';
        $('#Customer_AccountNumberform option:selected').each(function() {
            if(selectedID == '')
            {
                selectedID = $(this).val();
            }
        });
       
        if (selectedID.trim() != '') {
            var url = 'getSpecficPaymentCustomer'
            $.ajax({
                url: url,
                data: {AccID: selectedID  },
                type: 'POST'
            }).done(function (data) {
                   
                var resonseObj = $.parseJSON(data);
                
                document.getElementById("DebtorNameform").value = resonseObj.data[0]['DebtorName'];
                document.getElementById("Customer_IBANform").value = resonseObj.data[0]['Customer_IBAN'];
                document.getElementById("Customer_BICform").value = resonseObj.data[0]['Customer_BIC'];
                document.getElementById("Mandate_Typeform").value = resonseObj.data[0]['Mandate_Type'];
                document.getElementById("Mandate_Referenceform").value = resonseObj.data[0]['Mandate_Reference'];
   
                })
        } 
       
    });
</script>


<?php if($PageDesign != '2' ){include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_update_form.php';} ?>