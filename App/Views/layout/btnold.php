 <!-- Start What is this code from header menue -->
 <?php
$countBack= 0;
if (!empty($_REQUEST['backbutton']) ){
        $url = str_replace('dev.babcportal.com/public/', '', $_REQUEST['backbutton']) ;
        
        $countBack = $_SESSION['cntBack'] ;
        $name = 'backBtn' . $countBack;
       
        if(isset($_SESSION[$name]) && $_SESSION[$name] != $url){
            $countBack = $_SESSION['cntBack'] + 1;
            $name = 'backBtn' . $countBack;
            
            if(isset($_SESSION[$name]))
            {
                unset($_SESSION[$name]);
                unset($_SESSION['cntBack']);
            }
            $_SESSION['BackbtnCheck'] = '1';
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
                $url = str_replace('dev.babcportal.com/public/', '', $_SERVER['REQUEST_URI']) ;
                $_SESSION[$name] = $url;
                $_SESSION['cntBack'] = trim($countBack);
                $_SESSION['BackbtnCheck'] = '1';
           }
        else{   
             $countBack = $_GET['check'];
             $BTNcmt =  isset($_SESSION['cntBack'])?$_SESSION['cntBack']:'';
             $name = 'backBtn' . ($BTNcmt);
             $_SESSION['BackbtnCheck'] = '1';
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
   
    $url = str_replace('/public', '', $_SERVER['REQUEST_URI']) ;
    $_SESSION[$name] = $url;
    $_SESSION['cntBack'] = trim($countBack);
    $prevLink = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'index.php';
   // $prevLink = str_replace('http://212.247.32.103:8082/bpu/public/', '', $prevLink);
    $_SESSION['prevLink'] = $prevLink;
}  
?>
<!-- End What is this code from header menus -->