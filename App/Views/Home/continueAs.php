<?php include_once dirname(__DIR__) . '/layout/Login_Page/header.php'; ?>
<style type="text/css">

table td , th {
    text-align: center;
}

.table {
    margin-top: 15%;
    margin-left: 26%;
    border-radius: 5px;
    width: 50%;
    float: none;
}

table#total\ votes {
    color: white;
    max-width: 450px;
    margin: auto;
    position: relative;
    top: 120px;
    border-collapse: separate;
    border-spacing: 10px 15px;
}

table#total\ votes th {
    font-size: 25px;
    border-bottom: none;
}

#total\ votes td, .table th {
    border-top: none;
}

#total\ votes td:hover {
    color: white;
    cursor: pointer;
}

#total\ votes td {
    box-shadow: rgb(0 0 0 / 7%) 0px 3px 8px;
    padding: 12px 12px 15px 12px;
    margin: 10px;
    background: #ffffff1c;
    border-radius: 5px;
}

</style>

<div class="page-container">
<div class="page-content-wrapper">
<div class="page-content">

    <div class="row">

        <div class="col-md-12 col-sm-12">
           <div class="container-fluid">
                    <form class="form-horizontal" method="post" action="<?php echo baseUrl; ?>login" 
                        id='form'>
                    <table id="total votes" class="table table-hover text-centered">
                        <thead><th>Continue As</th></thead>
                        <tbody>
                            <?php
                            $AvailableUsers = explode(',', $AvailableUsers);
                            foreach ($AvailableUsers as $key => $value) { ?>
                                <tr><td onclick='routeTo(this)'><?php echo $value; ?></td></tr>

                            
                            <?php }
                            ?>
                        </tbody>    
                    </table>
                </form>
            </div>

        </div>
    </div>
</dir>
</dir>
</dir>
<script type="text/javascript">
    function routeTo(data)
    {
        $('#form').append('<input type="hidden" name="AcccessUser" value="'+data.innerText+'" />');
        $('#form').submit();
    }
</script>

<?php include_once dirname(__DIR__) . '/layout/Login_Page/footer.php'; ?>
