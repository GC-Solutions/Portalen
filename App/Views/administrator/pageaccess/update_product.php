<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_update_form.php'; ?>

    <div class="page-container">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12 col-sm-12" style="margin: auto; top: 0;">
                    <div class="card card-box">
                        <form action="<?php echo baseUrl; ?>saveDataToMongoDB" method="post"
                              class="form-horizontal" enctype="multipart/form-data" >
                           
                            <input type="hidden" name="curLoc" value="<?= $_SERVER['HTTP_REFERER'] ?>">
                            <input type="hidden" name="queryString" value="<?= $queryString ?>">
                            <?php if ($apiData) {
                                foreach ($apiData as $key => $eachRow) { ?>
                                    <div class="form-body">

                                        <?php if($eachRow->columnType == 'textField')
                                        { ?>
                                            <div class="form-group row">
                                            <label class="control-label col-md-5">
                                                <?= $key;?>
                                            </label>

                                           
                                            <div class="col-md-5">
                                                <textarea  name="<?= $key;?>" class="form-control" rows="4" cols="50"><?php if(isset($dataMongoDb[0]->$key)){ echo($dataMongoDb[0]->$key);} ?></textarea>
                                            </div>
                                        </div>
                                        <?php } elseif($eachRow->columnType == 'file') { ?>
                                            <div class="form-group row">
                                                <label class="control-label col-md-5">
                                                    <?= $key;?>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="file" name="uploadImage_MongoDB[]" multiple="multiple">
                                                </div>
                                        </div>
                                      
                                        <?php if(!empty($uploadImage)) { ?>
                                        <div class="form-group row">
                                                <label class="control-label col-md-5">
                                                  "Images Photo"
                                                </label>
                                                <div class="col-md-5">

                                                    <?php 
                                                    $i =0;
                                                    foreach ($uploadImage as $key => $value) {
                                                        echo '<div id=image'.$i.'><span style="cursor:pointer; float:right;" onclick="javascript:deleteimage(image'.$i.' , '.$i.')">X</span> ';
                                                         echo '<img width="50" height="60" src="data:jpeg;base64,'.$value['image'].'" /><br/></div>' ; 
                                                     $i = $i+1;
                                                    }

                                                   ?> 
                                                   <input type="hidden" name="EditedImage" id ="EditedImage" value="">
                                                </div>
                                        </div>
                                         <?php } ?>

                                         <?php } elseif($eachRow->columnType == 'folderFile') { ?>
                                           <div class="form-group row">
                                                <label class="control-label col-md-5">
                                                    <?= $key;?>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="file" name="uploadImage_Folder[]" multiple="multiple">
                                                </div>
                                        </div>
                                      
                                        <?php // if(!empty($uploadImage)) { ?>
                                         <!--<div class="form-group row">
                                                <label class="control-label col-md-5">
                                                  "Images Photo"
                                                </label>
                                                <div class="col-md-5">

                                                    <?php 
                                                    // $i =0;
                                                    // foreach ($uploadImage as $key => $value) {
                                                    //     echo '<div id=image'.$i.'><span style="cursor:pointer; float:right;" onclick="javascript:deleteimage(image'.$i.' , '.$i.')">X</span> ';
                                                    //      echo '<img width="50" height="60" src="data:jpeg;base64,'.$value['image'].'" /><br/></div>' ; 
                                                    //  $i = $i+1;
                                                    // }

                                                   ?> 
                                                   <input type="hidden" name="EditedImage" id ="EditedImage" value="">
                                                </div>
                                        </div> -->
                                         <?php //}


                                     }// file End  ?>
                                    </div>
                               
                           <?php } } ?>
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

            <!-- wizard with validation-->
        </div>
    </div>
<script type="text/javascript">
function deleteimage(image_id , key)
{
        var newArr = [];
        var arr = [];
        var arr1  =  []; 
        var value =$('#EditedImage').val();
        if(value)
        {
             arr  = JSON.parse(value);
            
             
        }else{
             arr  = <?php echo json_encode($uploadImage);?>;
        }
        
        
        var id = image_id.id;
        $("#"+id).remove();
       
        delete arr[key];
        newArr = arr; 
        arr = JSON.stringify(arr); 
        console.log(arr);
        $('#EditedImage').val(arr)  ;

      
}
</script>
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_update_form.php'; ?>