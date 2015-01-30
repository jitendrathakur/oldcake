<?php
echo $paginator->counter(array(
'format' => __('Total Elements <b> %count% </b> &nbsp; &nbsp; Records per page :', true)
));
?>
 <?php
$fullurl = $_SERVER['REQUEST_URI'];
$fullurlarray=explode('?',$fullurl);
 
 
 //get parameter value
 
 $dnIdf = $this->params['url']['id'];
 $location_idf = $this->params['url']['location_id'];
 $functionf = $this->params['url']['function'];
 $display = $this->params['url']['display'];
 
 
 
 
 
	
	$results = array();
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
	
	
		
	$this->passedArgs	=	array_merge($this->passedArgs,$arry);	
	
	foreach ((array)$paginationOptions as $option) {
		if ($paginationLimit == $option) {
			$results[] = $option;
		} else {
 	
			$args = $this->passedArgs;
			
			
			
			$args['Paginate'] = $option."?".$fullurlarray['1'];
			
			$results[] = $html->link($option, $args);
			
		}
	}
	
	
 echo implode(" | ", $results);
 ?>
 <br>
