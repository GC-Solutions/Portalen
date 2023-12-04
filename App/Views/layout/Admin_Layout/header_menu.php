<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/newmenue.php'; ?>

<?php 
    $check = 0;
 if($check == 1){?>
<!-- start header -->
<div class="page-header navbar navbar-fixed-top">
    <div class="page-header-inner">

				<ul class="nav navbar-nav navbar-left in">
					<li><a href="#" class="menu-toggler sidebar-toggler"><i class="icon-menu"></i></a></li>
				</ul>
                                            
                <!-- start mobile menu -->       
           <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>
        
        
        
  <!-- end mobile menu -->
             <a href="<?php echo baseUrl; ?>index.php">
                              <span class="logo-default">

                <img src="assets/images/Logo/Default/bb.png" alt="Smiley face" width="142" height="62">   


                </span>
            </a>
       


		
			<!-- start header menu -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
           
                <!-- start manage user dropdown -->
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                       data-close-others="true">
	                        <span class="username username-hide-on-mobile"> <?php if(isset($_SESSION['CompanyName'])){ echo $_SESSION['CompanyName'];}?>-</span>                        
	                        <span class="username username-hide-on-mobile"> <?php if ($_SESSION) {
                                echo $_SESSION['UserFirstName']; 
                            } ?></span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default animated jello">
                        <li>
                            <a href="<?php echo baseUrl; ?>logout">
                                <i class="icon-logout"></i> Logout </a>
                        </li>   
                    </ul>      
                </li>
                <!-- end manage user dropdown -->
               <li class="dropdown dropdown-quick-sidebar-toggler">
							<a id="headerSettingButton" class="mdl-button mdl-js-button mdl-button--icon pull-right"
								data-upgraded=",MaterialButton">
								<i class="material-icons">settings</i>
							</a>
				</li>
                
            </ul>
       
        </div>
    </div>
</div>
<!-- end header -->
<?php

$countBack= 0;
if (!empty($_REQUEST['backbutton']) ){
        $url = str_replace('212.247.32.103:8082/bpu/public/', '', $_REQUEST['backbutton']) ;
        
        $countBack = $_SESSION['cntBack'] ;
        $name = 'backBtn' . $countBack;
        
        if($_SESSION[$name] != $url){
            $countBack = $_SESSION['cntBack'] + 1;
            $name = 'backBtn' . $countBack;
            
            if(isset($_SESSION[$name]))
            {
                unset($_SESSION[$name]);
                unset($_SESSION['cntBack']);
            }
            $_SESSION['cntBack'] = trim($countBack) ;
            $_SESSION[$name] = $url;
        }
}elseif(isset($_GET['check'])){
        if($_GET['check'] == '0')
           {
               $countBack =  0 ;
                $name = 'backBtn' . $countBack;
                 if(isset($_SESSION[$name]))
                    {
                        unset($_SESSION[$name]);
                        unset($_SESSION['cntBack']);
                    }
                $url = str_replace('212.247.32.103:8082/bpu/public/', '', $_SERVER['REQUEST_URI']) ;
                $_SESSION[$name] = $url;
                $_SESSION['cntBack'] = trim($countBack);
           }
        else{   
             $countBack = $_GET['check'];
             $name = 'backBtn' .  $_SESSION['cntBack'];
             $nameCheck = 'backBtn' .  $countBack;
             if(isset($_SESSION[$name])){
                unset($_SESSION[$name]);
             }
            
            if(!isset($_SESSION[$nameCheck]))
            {
                unset($_SESSION['cntBack']);
            }else{
                unset($_SESSION['cntBack']);
                $_SESSION['cntBack'] = trim($countBack) ;
            }
           
        }
}else{
    $countBack =  0 ;
    $name = 'backBtn' . $countBack;
     if(isset($_SESSION[$name]))
        {
            unset($_SESSION[$name]);
            unset($_SESSION['cntBack']);
        }
    $url = str_replace('212.247.32.103:8082/bpu/public/', '', $_SERVER['REQUEST_URI']) ;
    $_SESSION[$name] = $url;
    $_SESSION['cntBack'] = trim($countBack);
    $prevLink = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'http://212.247.32.103:8082/bpu/public/index.php';
    $prevLink = str_replace('http://212.247.32.103:8082/bpu/public/', '', $prevLink);
    $_SESSION['prevLink'] = $prevLink;
}  
 }
?>