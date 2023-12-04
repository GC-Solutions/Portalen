<!-- New design  -->
<form action="<?php echo baseUrl; ?>placeholderUpdateForm"  method="post" enctype="multipart/form-data" >
                                
        <div class="card-body row">
            <input type="hidden" name="placeholderId" value="<?= $placeholderId ?>">
            <input type="hidden" name="pageId" value="<?= $pageId ?>">
            <input type="hidden" name="pageText" value="<?= $pageText ?>">
            
            <input type="hidden" name="curLoc" value="<?php if(isset($path)){ echo $path; }else { echo $_SERVER['HTTP_REFERER'];} ?>">
            <?php if ($apiData) {

                        foreach ($apiData as $key => $eachRow) { ?>
                            <div class="col-lg-6 p-t-20">
                                <?php if(!empty($columnNameDialog) && isset($columnNameDialog[$key])) {
                                     $inputName = $columnNameDialog[$key];
                                }else {
                                    $inputName =  $key;
                                } ?>
                                <label class="mdl-textfield__label"><?= $inputName;?></label>

                                    
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                         <input class="mdl-textfield__input" type="text"  name="<?= trim($key);?>" value="<?= $eachRow; ?>"  <?php if(in_array($key, $keys)){ ?> readonly = "true" <?php } ?>  >
                                    </div>
                                </div>
                          
                        <?php }
                    } ?>
            
            <div class="col-lg-12 p-t-20 text-center">
            <button type="submit"
                class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink">Update</button>
            <button type="button" 
                class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
</form>






<!-- <?php //include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_update_form.php'; ?>

    <div class="page-container">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12 col-sm-12" style="margin: auto; top: 0;">
                    <div class="card card-box">
                        <form action="<?php echo baseUrl; ?>placeholderUpdateForm" method="post"
                              class="form-horizontal">
                            <input type="hidden" name="placeholderId" value="<?= $placeholderId ?>">
                            <input type="hidden" name="pageId" value="<?= $pageId ?>">
                            <input type="hidden" name="pageText" value="<?= $pageText ?>">
                            
                            <input type="hidden" name="curLoc" value="<?php if(isset($path)){ echo $path; }else { echo $_SERVER['HTTP_REFERER'];} ?>">
                            <?php if ($apiData) {
                                foreach ($apiData as $key => $eachRow) { ?>
                                    <div class="form-body">
                                        <div class="form-group row">
                                            <label class="control-label col-md-5">
                                                <?= $key;?>
                                            </label>

                                            <?php
                                            $disabled = '';

                                            if(in_array($key, $keys)){
                                                $disabled = 'readonly="readonly"';
                                            }
                                            ?>
                                            <div class="col-md-5">
                                                <input type="text" <?= $disabled;?> name="<?= $key;?>" value="<?= $eachRow;?>" class="form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } ?>
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="offset-md-5 col-md-7">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-danger">
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            wizard with validation-->
        <!-- </div>
    </div> --> 
<?php //include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>