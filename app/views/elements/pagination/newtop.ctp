<?php
echo $paginator->counter(array(
'format' => __('Total Elements <b> %count% </b> &nbsp; &nbsp; Records per page :', true)
));
?>
 <?php
	$results = array();
	/*$filter_ur = '';
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
		
	$this->passedArgs	=	array_merge($this->passedArgs,$arry);*/
	//pr($this->params);die;
	      $fields = array('customer_id','name','id','sort','direction','function','user','log_entry','status','station_id');
	      $urlArray=array();
	      $condition=isset($this->params['named']['customer_id'])?$this->params['named']:isset($this->params['named']['station_id'])?$this->params['named']:$this->params['url'];
		      $query_string = "";
		     
		      if(!empty($condition)){
			    foreach($condition as $field=>$val):
			      if(in_array($field,$fields)){
				  if(is_array($val)){
				      $urlArray = array_merge($urlArray,array($field=>implode("))|((",$val)));
				       foreach($val as $v):
					  $query_string .= $field."[]:".$v."/";
					endforeach;
				   }
				   else{
				      $urlArray = array_merge($urlArray,array($field=>$val));
				      $query_string .= $field.":".$val."/";
				   }
				 
			    }
			    endforeach;
		     }
       $paginator->options(array('url'=>$urlArray));
       $query_string = substr($query_string,0,-1);
       foreach($paginationOptions as $key=>$val):
	      echo " | ".$html->link($val,array('controller'=>$this->params['controller'],'action'=>$this->params['action'],$query_string.'/Paginate:'.$val)); 
       endforeach;

 ?>
 <br>
