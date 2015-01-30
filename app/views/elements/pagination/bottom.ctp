<?php
$fullurl = $_SERVER['REQUEST_URI'];
$fullurlarray=explode('?',$fullurl);//getting full url parameter to passed in parameter

	//echo $javascript->link('/js/jquery-1.10.1.min'); // added new

	 $controller= $this->params['controller'];
	 $Model= substr($controller,0,(strlen($controller)-1));
	 $action= $this->params['action']; 
	 
	 //echo "<pre>";
	 //print_r($this->params);
	$currentPage=isset($this->params['named']['page'])?$this->params['named']['page']:(isset($this->params['paging'][ucwords($Model)]['page'])?$this->params['paging'][ucwords($Model)]['page']:"");	 
	 $currentPaginage=isset($this->params['named']['Paginate'])?$this->params['named']['Paginate']:(isset($this->params['paging'][ucwords($Model)]['current'])?$this->params['paging'][ucwords($Model)]['current']:"");
	 
	 $TotalPages = $this->params['paging'][ucwords($Model)]['pageCount'];
	 
	 $Paginate = $this->params['paging'][ucwords($Model)]['defaults']['limit'];
	 
	 
     $PaginationURL = Configure::read('base_url').$controller.'/'.$action;
	 
	 if(isset($this->params['pass']) && !empty($this->params['pass'])){
	  	$PaginationURL .='/'.$this->params['pass'][0];
	 }
	 
	
	
	 if($this->params['named']['Paginate']==""){
	 	$this->params['named']['Paginate']=$paginationLimit;
	 }
	
	 if(isset($this->params['named']) && !empty($this->params['named'])){
	 
	   $times = 1;
	   foreach( $this->params['named'] as $key=>$value){
		 //if($times ==1)
			$PaginationURL .='/'.$key.':'.$value;
			
		 $times++;
		}
		
		
	 }	 
	 
?>
<script language="javascript">
jQuery(document).ready(function(){ 
	jQuery('.GoOnTargetPage').keypress(function(event){
        var keycode = (event.which ? event.which : event.keyCode);
        if(keycode == '13'){
			var PaginationURL = '<?php echo $PaginationURL; ?>';
			var filterUrl = '<?php  echo $fullurlarray['1'];   ?>';
			var paginate = jQuery('#paginate').val();
			var TotalPages = jQuery('#TotalPages').val();
			var TargetPage = jQuery(this).val();
			
			if (PaginationURL.toLowerCase().indexOf("/page:") >= 0){
				
				if(PaginationURL.toLowerCase().indexOf("customers/index") >= 0){
					
					var i = PaginationURL.indexOf("/page:");
					
					PaginationURL= PaginationURL+"/?"+filterUrl;
				
				  var cstposition = PaginationURL.indexOf("?name");  
				  
				  var exactpostion =  cstposition - i;  
					
				}
				else{
					var i = PaginationURL.indexOf("/page:");
					PaginationURL= PaginationURL+"/?"+filterUrl;
				  var cstposition = PaginationURL.indexOf("/customer_id");  
				 
				  var exactpostion =  cstposition - i;        
			
				}
				
              var PaginationURL = PaginationURL.slice(0,i)+ '/page:'+TargetPage + PaginationURL.substr(i+exactpostion);
			  //var PaginationURL = PaginationURL.slice(0,i)+ '/page:'+TargetPage;
			 
			  var NewURL = PaginationURL;
			  
			}
			else{
				  
			     var NewURL = PaginationURL+'/page:'+TargetPage+'?'+filterUrl;
			}	
	          
				window.location.href=NewURL;	
        }
        event.stopPropagation();
    });
});
</script>

<div class="paging " style="width:350px;">
<?php 
	$filter_url	=	explode('/',$filter_ur);
	$arry		=	array();
	$exist		=	0;
	foreach($filter_url as $filterUrl){
		$exist=0;
		$filt	=	explode(':',$filterUrl);

		foreach($this->passedArgs as $i=>$url){
		
			if($filt[0]===$i)
				$exist	=1;
		}
		if(isset($filt[0]) && isset($filt[1]) ){
			if(!$exist){
				$arry[$filt[0]]	=	$filt[1];
			}
		}
	
	}
	
	  
			if($this->passedArgs['Paginate']==""){
				$this->passedArgs['Paginate']=$paginationLimit;
			}      
$this->passedArgs['Paginate'] = $this->passedArgs['Paginate']."?".$fullurlarray['1']; //replacing parameter of pagination with url parameter 02/07/2014
	$this->passedArgs	=	array_merge($this->passedArgs,$arry);

	$passedArgs_prev	= array();
	$passedArgs_next	= array();
	
	$passedArgs_prev	=	$this->passedArgs;
	$passedArgs_next	=	$this->passedArgs;
	
	if(isset($this->passedArgs['page'])){
		$passedArgs_prev['page']	=	$passedArgs_prev['page']-1;
		$passedArgs_next['page']	=	$passedArgs_next['page']+1;
	}
	if(isset($this->passedArgs['page']))
		$now	=	$this->passedArgs['page'];
	else 	
		$now	=	1;
	
	$args=	array('url'=>$this->passedArgs);
	
	
	$argFL=	array('url'=>$this->passedArgs,'class'=>'disabled','tag'=>'span');

	$full_args		=	$args;
	$full_argsFL	=	$argFL;
	
	$tot	=	explode('of',$paginator->counter());
        
	if(isset($passedArgs_prev['page']))
		$full_args['url']['page']	=	$passedArgs_prev['page'];
		if($full_args['url']['Paginate']=='?'){
	
	 $full_args['url']['Paginate'] = $paginationLimit.'?';
	
	 }
	
	echo $paginator->first('<< ',$full_argsFL);		
	echo $paginator->prev(' < ',$full_args, null, array('class'=>'disabled','tag'=>'span'));
	echo '&nbsp;'?><?php __('Page')?><?php echo '<input type="text" name="currpage" value="'.$now.'" style="width:25px;text-align:center;" maxlength="3" class="GoOnTargetPage">'?><?php __('Of') ?><?php echo '&nbsp;'.$tot[1];
	if(isset($passedArgs_next['page']))
	     	$full_args['url']['page']	=	$passedArgs_next['page'];
	 if($full_args['url']['Paginate']=='?'){
	
	 $full_args['url']['Paginate'] = $paginationLimit.'?';
	
	 }
	echo $paginator->next(' > ', $full_args, null, array('class'=>'disabled','tag'=>'span'));
	echo $paginator->last('>> ', $full_argsFL);	
  ?>
  <input type="hidden" id="paginate" value="<?php echo $Paginate; ?>" />
  <input type="hidden" id="TotalPages" value="<?php echo $TotalPages; ?>" />
</div>