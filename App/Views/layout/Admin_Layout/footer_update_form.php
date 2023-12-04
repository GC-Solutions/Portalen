
<!-- data tables -->
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/popper/popper.min.js"></script>

<!-- bootstrap -->
<script src="<?php echo baseUrl;?>assets/Theme/assets/plugins/material/material.min.js"></script>
<script type="text/javascript" src="<?php echo baseUrl;?>assets/Custome_Code/Other/js/getmdl-select.min.js"></script>
   
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/jquery-blockui/jquery.blockui.min.js"></script>
<!-- <script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/counterup/jquery.waypoints.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/counterup/jquery.counterup.min.js"></script> -->
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/pages/sparkline/sparkline-data.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/app.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/layout.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/theme-color.js"></script>


<!-- animation -->
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/pages/ui/animations.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/plugins/select2/js/select2.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/pages/select2/select2-init.js"></script>
<script src="<?php echo baseUrl; ?>assets/Theme/assets/js/pages/table/table_data.js"></script>

<!-- animation -->
<script src="<?php echo baseUrl; ?>assets/Custome_Code/Other/js/common.js"></script>
<!-- <script src="<?php echo baseUrl;?>assets/Custome_Code/Other/js/jquery.fancybox.min.js"></script>
<link href="<?php echo baseUrl;?>assets/Custome_Code/Other/css/jquery.fancybox.min.css" rel="stylesheet" type="text/css" /> -->


<?php if(isset($_SESSION['syncFlag']) && $_SESSION['syncFlag'] == '1'){?>
 <script type="text/javascript">
        
        var time = "<?php echo $_SESSION['syncTime']; ?>"
        setTimeout(function(){
            location.reload(); }, time);

</script>

<?php }?>

</body>
</html>