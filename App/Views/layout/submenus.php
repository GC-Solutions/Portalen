
<?php 

$cnt = trim(isset($_SESSION['cntBack'])?$_SESSION['cntBack']:0);  
if( $cnt > 0){
       
        // $name = 'backBtn' . ($_SESSION['cntBack'] - 1);
        // $prev = $_SESSION['cntBack'] - 1;
?>
<!-- <div class="page-bar" style="margin-top: -55px;">
	<div class="page-title-breadcrumb">
        <ol class="breadcrumb page-breadcrumb pull-right"> -->
            <?php 
            
            if(isset($_SESSION['backBtn0'])){   
                $curr_Page = $_SESSION['backBtn0'];
                $currentPageName = explode('&', urldecode($curr_Page));
                $currentPageName = !empty($currentPageName[1])?$currentPageName[1]:'';
                $currentPageName = explode('page_text=',$currentPageName);
                $curr_Page = !empty($currentPageName[1])?$currentPageName[1]:'';   
            }else{
                $curr_Page = $_SESSION['currentPageName'];
            }
                 
            
            $breadcrumb = '';
            $BackBtn = array();
            $BackBtnCnt = array_keys($_SESSION);
            foreach($BackBtnCnt as  $BackBtnkey => $BackBtnVal ){
                    if(strpos($BackBtnVal , 'backBtn') !== false){
                        array_push($BackBtn , $BackBtnVal );
                    }
            }
            if(isset($_SESSION['cntBack'])){ 
                for ($i=0; $i <=$_SESSION['cntBack'] ; $i++) { 
                    
                    $links = $_SESSION['backBtn'.$i];
                    $link_name = explode('&', $links);
                    $link_name = explode('page_text=', $link_name[1]);
                    
                    //$links = str_replace(baseUrl ,'', 'http://'.$links );
                
                    if($i == $_SESSION['cntBack'])
                    {
                        $link_name[1] = str_replace('%20' , ' ', $link_name[1]);
                        $breadcrumb = $breadcrumb.'<li>'.$link_name[1].'</li>';
                    }else{
                        $val = $i -1 ;
                        if(strpos($links , 'public/') === false){
                            $links = baseUrl.$links;
                        }else {
							$tempLink = explode('public/' , $links);
							$tempLink = baseUrl.$tempLink[1];
							$links = $tempLink; 
						}
                        $link_name[1] = str_replace('%20' , ' ', $link_name[1]);
						
                        $breadcrumb = $breadcrumb.'<li><a class="parent-item" href="'.$links.'&check='.$i.'">'.$link_name[1].'</a></li>&nbsp;<i class="fa fa-angle-right" ></i>&nbsp;';
                    }
                

                }
            }
			
           
            foreach ($_SESSION['PageDetails'] as $pageDetails ) {       
                if( isset($subpage1['PageMenuText']) && trim($pageDetails['PageMenuText']) == trim($curr_Page))
                {
                    //$breadcrumb = '<li>'.$curr_Page.'</li>';
                    //$breadcrumb = '<li>'.$curr_Page.'</li>';
                   
                    $breadcrumb = '<li><a class="parent-item" href="'. baseUrl . 'page?id=' . $pageDetails['PageTableID'].'&page_text=' .$pageDetails['PageMenuText'].'" >'.$pageDetails['PageMenuText'].'</a></li>&nbsp;<i class="fa fa-angle-right" ></i>&nbsp;'.$breadcrumb;
                    
                    if(isset($pageDetails['ParentPageText']) && $pageDetails['ParentPageText'] != '')
                    {
                        
                        foreach ($_SESSION['PageDetails'] as $subpage ) {
                            
                            if(   isset($subpage['PageMenuText']) && strpos($pageDetails['ParentPageText'],$subpage['PageMenuText']) !== false)
                            {
                            
                                $breadcrumb = '<li><a class="parent-item" href="'. baseUrl . 'page?id=' . $subpage['PageTableID'].'&page_text=' .$subpage['PageMenuText'].'" >'.$subpage['PageMenuText'].'</a></li>&nbsp;<i class="fa fa-angle-right" ></i>&nbsp;'.$breadcrumb;

                                 foreach ($_SESSION['PageDetails'] as $subpage1 ) {
                                    
                                    if( isset($subpage1['PageMenuText']) && strpos($subpage['ParentPageText'],$subpage1['PageMenuText']) !== false)
                                    {

                                        $breadcrumb = '<li><a class="parent-item" href="'. baseUrl . 'page?id=' . $subpage1['PageTableID'].'&page_text=' .$subpage1['PageMenuText'].'">'.$subpage1['PageMenuText'].'</a></li>&nbsp;<i class="fa fa-angle-right" ></i>&nbsp;'.$breadcrumb;
                                    }
                                }

                            }
                        }
                        

                        
                    }   
                     
                }

            } 
         
            //echo $breadcrumb;?>
               <script>
                   //console.log(document.getElementsByClassName("breadcrumb page-breadcrumb pull-right")[0].innerHTML) ;
                   document.getElementsByClassName("breadcrumb page-breadcrumb pull-right")[0].innerHTML ='<?php echo $breadcrumb;?>' ;
               </script>
<!--      		
		</ol> 
	</div>
</div>	 -->
<?php } ?>



		
            