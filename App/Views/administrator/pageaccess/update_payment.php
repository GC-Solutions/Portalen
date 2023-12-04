
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_update_formTest.php'; ?>

    <div class="page-container">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12 col-sm-12" style="margin: auto; top: 0;">
                    <div class="card card-box">
                        <form action='<?php echo baseUrl; ?>csvUpload?placeholderId=<?php echo $pId; ?>' method="post"
                              class="form-horizontal">
                            
                            <?php if ($columnName) {
                                foreach ($columnName as $key => $eachRow) { ?>
                                    <div class="form-body">
                                        <div class="form-group row">
                                            <?php if(trim($key) == 'ID'){?>
                                                
                                                <div class="col-md-5">
                                                    <input type="hidden" id="<?= trim($key);?>" name="<?= trim($key);?>" value="<?= trim($eachRow);?>" class="form-control"/>
                                                </div>
                                            <?php }else{
                                                if(trim($key) == 'Customer_AccountNumber'){ ?>
                                                    <label class="control-label col-md-5">
                                                        <?= $key;?>
                                                    </label>

                                                    <div class="col-md-5">
                                                        <select  name="<?= trim($key);?>"  id ="<?= trim($key).'form';?>" onchange="myFunction()" >
                                                        <option value="">Select</option>   
                                                        <?php foreach ($getAllPaymentCustomer as $cuskey => $cusvalue) {?>
                                                        <option <?php if (trim($cusvalue['AccountNumber']) == trim($eachRow) ) {
                                                            echo "selected='selected'";
                                                        } ?> value="<?= $cusvalue['AccountNumber'];?>" ><?= $cusvalue['AccountNumber'];?> </option>   
                                                        <?php } ?>
                                                        </select>
                                                       
                                                    </div>

                                            <?php }else if (trim($key) == 'Price'){?>
                                                <label class="control-label col-md-5">
                                                        <?= $key;?>
                                                </label>

                                                <div class="col-md-5">
                                                    <input type="text" id="<?= trim($key);?>" name="<?= trim($key);?>" value="<?= trim($eachRow);?>" maxlength="18" class="form-control" />
                                                </div>
                                            <?php }else if (trim($key) == 'Mandate_Type'){?>
                                                <label class="control-label col-md-5">
                                                        <?= $key;?>
                                                </label>

                                                <div class="col-md-5">
                                                        <select  name="<?= trim($key);?>"  id ="<?= trim($key).'form';?>" >
                                                        <option value="">Select</option> 
                                                        <option  <?php if ('FRST' == trim($eachRow) ) {
                                                            echo "selected='selected'";
                                                        } ?>value="FRST">FRST</option> 
                                                        <option <?php if ('RCUR' == trim($eachRow) ) {
                                                            echo "selected='selected'";
                                                        } ?> value="RCUR">RCUR</option> 
                                                        <option  <?php if ('OOFF' == trim($eachRow) ) {
                                                            echo "selected='selected'";
                                                        } ?>value="OOFF">OOFF</option> 
                                                        <option <?php if ('FNAL' == trim($eachRow) ) {
                                                            echo "selected='selected'";
                                                        } ?> value="FNAL">FNAL</option> 
                                                        </select>
                                                </div>
                                            <?php }else if (trim($key) == 'Payment_Type'){?>
                                                <label class="control-label col-md-5">
                                                        <?= $key;?>
                                                </label>

                                                <div class="col-md-5">
                                                        <select  name="<?= trim($key);?>"  id ="<?= trim($key);?>" >
                                                        <option value="">Select</option> 
                                                        <?php foreach ($currencyCode as $currKey => $currValue) { ?>
                                                            <option  <?php if (!empty(trim($eachRow)) && trim($eachRow) == $currKey ) {
                                                                    echo "selected='selected'";
                                                            }else if (empty(trim($eachRow)) && ($currKey) == 'EUR'){   echo "selected='selected'";} ?>value="<?php print_r($currKey);?>"><?php  print_r($currKey);?></option>     
                                                        <?php } ?>
                                                       
                                                        
                                                        </select>
                                                </div>   
                                            <?php }else if (trim($key) == 'Date_Of_Signature'){?>
                                                <label class="control-label col-md-5">
                                                        <?= $key;?>
                                                </label>

                                                <div class="col-md-5">
                                                    <div class='input-group date' id='datetimepicker1'>
                                                        <input type='text' class="form-control" name="<?= trim($key);?>" value="<?= trim($eachRow);?>" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php }else if (trim($key) == 'Execution_Date'){?>
                                                <label class="control-label col-md-5">
                                                        <?= $key;?>
                                                </label>

                                                <div class="col-md-5">
                                                    <div class='input-group date' id='datetimepicker2'>
                                                        <input type='text' class="form-control" name="<?= trim($key);?>"  value="<?= trim($eachRow);?>" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php }else if (trim($key) == 'Created_Invoice'){?>
                                                <label class="control-label col-md-5">
                                                        <?= $key;?>
                                                </label>

                                                <div class="col-md-5">
                                                    <div class='input-group date' id='datetimepicker3'>
                                                        <input type='text' class="form-control"  name="<?= trim($key);?>" value="<?php if(empty(trim($eachRow))){ echo date('Y-m-d h:i:s');} else { echo trim($eachRow) ;} ?>" readonly />
                                                        
                                                    </div>
                                                </div>
                                            <?php }else if (trim($key) == 'Purpose'){?>
                                                <label class="control-label col-md-5">
                                                        <?= $key;?>
                                                </label>

                                                <div class="col-md-5">
                                                   <textarea rows="4" cols="13" id="<?= trim($key);?>" name="<?= trim($key);?>" ><?= trim($eachRow);?></textarea>
                                                </div>
                                            <?php }else{ ?>
                                            
                                                    <label class="control-label col-md-5">
                                                        <?= $key;?>
                                                    </label>

                                                    <div class="col-md-5">
                                                        <input type="text" id="<?= trim($key).'form';?>" name="<?= trim($key);?>" value="<?= trim($eachRow);?>" class="form-control" maxlength='35'/>
                                                    </div>
                                            <?php }} ?>
                                        </div>
                                    </div>
                                <?php }
                            } ?>
                            <input type="hidden" id="action" name="action" value="<?= $action;?>" class="form-control"/>
                            <input type="hidden" id="pay_type" name="pay_type" value="Payment" class="form-control"/>
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="offset-md-5 col-md-7">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-danger">
                                                <?= ucfirst($action);?>
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

<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>