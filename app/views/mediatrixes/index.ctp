
<!--<script type="text/javascript" src="<?php echo Configure::read('base_url');?>js/jquery.1-4-2.min.js"></script>-->

<script type="text/javascript" src="<?php echo Configure::read('base_url');?>js/jquery.ie-select-width.js"></script>
<script type="text/javascript">
$(function ()
{
    // Set the width via the plugin.
    $('select#fixed-select-no-css').ieSelectWidth
    ({
        width : 120,
        containerClassName : 'select-container',
        overlayClassName : 'select-overlay'
    });
});

function showoptionmenu (val){	
	jQuery('.selectedmediatrix').each(function() {		
			  if ($(this).val() == val)
			  {
				  $('#table-popup').show();
			  }
			  else {			  	
				 $('#table-popup').hide();
			  }	
           });
		   
}


</script>

<?php
echo $javascript->link('/js/jquery.fancybox');
?>


<script>
    $(document).ready(function() {
        $('.fancybox').fancybox();
	});
</script>


	<div class="block top">
	<br>
	
	    <?php 
		$paginator->options(array('url' => $this->passedArgs));
	    echo $form->create('Mediatrix',array('action'=>'index/customer_id:'.$custId,'id'=>'filters','type'=>'GET'));
	   // echo $form->create('Mediatrix',array('action'=>'index','id'=>'filters','type'=>'GET'));
	    echo $form->input('customer_id', array('type'=>'hidden','value'=>$custId)); 
	   ?>
	    <div class="cb">
			<div id="" class="table-content">
				    <table class="table-content phonekey" width="100%">
						<thead>
							    <tr class="table-top">
									<!--<th class="table-column table-left-ohne" style="width:33px;">&nbsp;</th>-->
                                    <th  class="table-column"style="width:133px;text-align: left;">&nbsp;<?php __("mediatrixId");?></th>
									<th  class="table-column"style="width:145px;text-align: left;">&nbsp;<?php __("locationDesc");?></th>
 									<th  class="table-column "style="width:274px;text-align: left;">&nbsp;<?php __("Location");?></th>
                                    <!--<th class="table-right-ohne" style="width:260px;">&nbsp;</th>-->
									<!--<th  class="table-column"style="width:50px;text-align: left;"><?php __("ipaddress");?></th>
									<th  class="table-column"style="width:88px;text-align: left;"><?php __("totalPorts");?></th>
									<th  class="table-column"style="width:88px;text-align: left;"><?php __("freePorts");?></th>
									<th class="table-right-ohne">&nbsp;</th>
									-->
							    </tr>
						
							    <tr>
									<!--<td class="table-column table-left-ohne">&nbsp;</td>-->
									
                                     <td><?php echo $form->input('id', array('label' => false, 'type'=>'text','class' => 'filter-class onclick','style'=>'width:121px;', 'value'=>(isset($this->params['named']['id'])?$this->params['named']['id']:(isset($this->params['url']['id'])?$this->params['url']['id']:'')))); ?></td>
									 <td><?php echo $form->input('location_desc', array('label' => false, 'type'=>'text','class' => 'filter-class onclick','style'=>'width:134px;', 'value'=>(isset($this->params['named']['location_desc'])?$this->params['named']['location_desc']:(isset($this->params['url']['id'])?$this->params['url']['location_desc']:'')))); ?></td>
                                   
 									<td><?php echo $form->select('location_id', $validLocation,(isset($this->params['named']['location_id'])?$this->params['named']['location_id']:(isset($this->params['url']['location_id'])?$this->params['url']['location_id']:'')),array('style'=>'width:120px;','onchange'=>"javascript:submi_form('filters');",'id'=>'fixed-select-no-css')); ?>
										
									</td>
                                    
                                    
									<!--<td><?php echo $form->input('ipaddress', array('label' => false, 'type'=>'text','class' => 'filter-class onclick','style'=>'width:45px;', 'value'=>(isset($this->params['named']['ipaddress'])?$this->params['named']['ipaddress']:(isset($this->params['url']['ipaddress'])?$this->params['url']['ipaddress']:'')))); ?></td>-->
									<!-- <td><?php echo $form->input('totalPorts', array('label' => false, 'type'=>'text','class' => 'filter-class onclick','style'=>'width:88px;', 'value'=>(isset($this->params['named']['totalPorts'])?$this->params['named']['totalPorts']:(isset($this->params['url']['totalPorts'])?$this->params['url']['totalPorts']:'')))); ?></td>
									<td><?php echo $form->input('freePorts', array('label' => false, 'type'=>'text','class' => 'filter-class onclick','style'=>'width:88px;', 'value'=>(isset($this->params['named']['freePorts'])?$this->params['named']['freePorts']:(isset($this->params['url']['freePorts'])?$this->params['url']['freePorts']:'')))); ?></td>
									-->
									<!--<td class="table-right-ohne">&nbsp;</td>-->
							    </tr>
						</thead>
				    </table>
			</div>
			
			<div class="block" style="margin: 0px;">
				<div class="button-right">
				<?php echo $html->link( __("Export Csv", true),  array('controller'=> 'mediatrixes', 'action'=>'export'),array('onmouseover'=>'hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
				</div>
				
				<div class="button-right">
					<a href="javascript:void(null)"  onclick="javascript:submi_form('filters');" name="data[filter]" value="filter" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __("filter");?></a>
					
				</div>
				
				<!--<div class="button-left">
					<?php echo $html->link( __("reset", true),  array('controller'=> 'dns', 'action'=>'viewdns', 'customer_id:'.$custId),array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);')); ?>
                </div>-->
                
                <div class="button-left">
					<?php echo $html->link( __("reset", true),  array('controller'=> 'mediatrixes', 'action'=>'index', 'customer_id:'.$custId),array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);')); ?>
                </div>
                
                <!--<div class="button-left">
					<?php echo $html->link( __("detail", true),  array('controller'=> 'dns', 'action'=>'viewdns', 'customer_id:'.$custId . '&' . 'type=detail' ),array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);', 'class' => 'opencolorbox')); ?>
                </div>-->
				
            </div>
			
			
			<div  ><button type="submit" style="width: 0px;height: 0px; background-color: #FFFFFF !important; cursor: none !important; border: none;" ></button></div>
	
	    <?php
	
		
		// check $locations variable exists and is not empty
		if(isset($mediatrices) && !empty($mediatrices)) :
		?>
		<!--Showing Page <?php //echo $paginator->counter(); ?>-->  
		
		<?php //echo $this->element('pagination/top'); ?>
	    <div id="" class="table-content">
		<table class="phonekey">
	    	<?php
			echo $this->element('pagination/top');
			?>
	    	<thead>
	        	<tr class="table-top">
	        	<!--<th class="table-column table-left-ohne">&nbsp;</th>-->
	        	<?php //echo "<pre>"; print_r($paginator); ?>
				
				
		
		
		
		<?php
			
		   $url = $this->params['named']['direction'];
		   $url2 = $this->params['url']['url'];		   
		   
			if($url=="" && strlen($url2)>6 ){ 
				#$filter_sort = array('0'=>'groups','1'=>'index','2'=>'Page:1','3'=>'customer_id:'.$SELECTED_CNN,'4'=>'sort:name','5'=>'direction:desc');
				 $urlfilter="mediatrixes/index/page:1/customer_id:$SELECTED_CNN/sort:name/direction:desc";
			?>
			
				<th class="table-column <?php echo 'sortlink_asc';?>" style="width:136px;text-align: left;"> <a id="sortlink" href="<?php echo Configure::read('base_url').$urlfilter; ?>"><?php echo __("mediatrixId",true); ?></a>
				</th>				
			<?php }else{ ?>
			<th class="table-column <?php if(in_array('sort:name',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:name',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:136px;text-align: left;"><?php echo $paginator->sort(__("mediatrixId",true), 'name', $filter_options);?></th>
			
			<?php } ?>
				
				
				
             <th class="table-column <?php if(in_array('sort:location_desc',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:location_desc',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:150px;text-align: left;"><?php echo $paginator->sort(__("mediatrixDesc",true), 'location_desc', $filter_options);?></th>   
			   
			   
			                     
			
			<th class="table-column <?php if(in_array('sort:Location.name',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:Location.name',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:125px;text-align: left;"><?php echo $paginator->sort(__("Location",true), 'Location.name', $filter_options);?></th>
			<!--<th class="table-column <?php if(in_array('sort:ipaddress',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:ipaddress',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:70px;text-align: center;"><?php echo $paginator->sort(__("ipaddress",true), 'ipaddress', $filter_options);?></th>-->
			<th  class="table-column  " style="width:30px;" ><?php echo __("#Ports", true); ?></th>
			<th  class="table-column  " style="width:30px;" ><?php echo __("#Free", true); ?></th>
			<th  class="table-column" style="width:20px" ></th>	
			<th class="table-right-ohne" style="border-right: 1px solid #D1D1D1!important;">&nbsp;</th>
			
	            </tr>
	        </thead>
		<?php //echo $this->element('pagination/top'); ?>
	        <tbody>
	        	<?php
				// initialise a counter for striping the table
				$count = 0;
	
				// loop through and display format
				//echo '<pre>'; print_r($portfreeMap);
				foreach($mediatrices as $mediatrix):
					// stripes the table by adding a class to every other row
					$class = ( ($count % 2) ? " class='altrow'": '' );
					// increment count
					$count++;
					
				?>
	            <tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">
	             	<!--<td class="table-left">&nbsp;</td>-->
	            	 <td>
	           			<?php
	           			#echo $mediatrix['Mediatrix']['id'];
						$mediatrxName = __('mediatrixName_tooltip',true);
	           			echo $html->link($mediatrix['Mediatrix']['name'],array('controller'=>'mediatrixes', 'action'=>'edit/mediatrix_id:' . $mediatrix['Mediatrix']['id']),array('onMouseOver'=>"Tip('$mediatrxName', BALLOON, true, ABOVE, false)",'onMouseOut'=>"UnTip()"));
	           			
	           			?>
	           			</td>
						
	           			<td class="sublist-align wid-217px tooltip" style="border-left: 1px solid #D1D1D1!important;">
							<div>
								<div class="fl"><span style="cursor:default" ><?php echo substr($mediatrix['Mediatrix']['location_desc'], 0, 15);?> <?php if(strlen($mediatrix['Mediatrix']['location_desc'])>15) { echo  '..' ; } ?></span>
                                <?php if(strlen($mediatrix['Mediatrix']['location_desc'])>15) { ?>
								<p><?php echo $html->link($mediatrix['Mediatrix']['location_desc'],array('controller'=>'mediatrixes', 'action'=>'edit/mediatrix_id:' . $mediatrix['Mediatrix']['id']));
	           			?></p>
                        <?php } ?>
								</div>
							</div>
						</td>
                        
                       
                   		<td>
	               		<?php echo $mediatrix['Location']['name'];
	               		?>
						</td>
	               		<!--<td><?php echo $mediatrix['Mediatrix']['ipaddress']; ?></td>-->
	               		<td><?php echo $porttotalMap[$mediatrix['Mediatrix']['id']]; ?></td>
	               		
	               		<td><?php echo $portfreeMap[$mediatrix['Mediatrix']['id']]; ?></td>
	               		<!--<td class="table-right	 tooltip" style="background: url(<?php echo $this->webroot; ?>/images/assets/icons/16px/045_information_02_cmyk.gif) no-repeat 2px 2px;">
	          		 	<div>
							<div class="fl"><span><?php echo $html->link('', '',array('onclick'=>'')) ?></span>
								<p><?php echo 'IP :' . $mediatrix['Mediatrix']['ipaddress'] . '<br>' . 'Mask :' . $mediatrix['Mediatrix']['mask'] . '<br>' . 'Gateway :' . $mediatrix['Mediatrix']['default_gw']?></p>
							</div>
						</div>
	          		 </td>-->
					 
					 
					 <td class="table-right-ohne	 tooltip" >
                                <div>
                                    <div class="fl">
									<span><a href="javascript:;" onclick="Tip(' <?php echo __('IP').': '. $mediatrix['Mediatrix']['ipaddress']; ?><br/><?php echo __('Mask').': '. $mediatrix['Mediatrix']['mask'];  ?><br/><?php echo __('Gateway').': '. $mediatrix['Mediatrix']['default_gw'];?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
									</span>
                                       
                                    </div>
                                </div>
                    </td>
					 
					 
					 
					 
					 
	               		
                       <td class="table-right-ohne" style="background: url(<?php echo $this->webroot; ?>/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat 3px 5px;border-right: 1px solid #D1D1D1!important;" onclick="showoptionmenu(<?php echo $mediatrix['Mediatrix']['id']; ?>);" >
                        <div class="table-menu">
                          <div class="table-menu-popup" id="table-popup"  style="z-index: 1;display:none">
                            <ul>
                            <li class="last log">
                              <?php echo $html->link('Edit',array('controller'=>'mediatrixes', 'action'=>'edit/mediatrix_id:' . $mediatrix['Mediatrix']['id']));
	           			?>
						<input type="hidden" name="mid" class="selectedmediatrix" value="<?php echo $mediatrix['Mediatrix']['id']; ?>">
                            </li>
                            </ul>
                          </div>
                        </div>
                        </td>
		    			
	           			<?php 
	            		
	            	endforeach; ?>
	            	</tr>
	        		</tbody>

	    </table>
	    <?php echo $form->end(); ?>
	<?php echo $this->element('pagination/bottom'); ?>
	</div>
	    </div>
	   
	    <?php
		else:
			__("No Mediatrix available in DB");
			echo '</div>';
		endif;
		?>
	 
                <div class="button-left">
                	<?php if($userpermission==Configure::read('access_id'))
                	{
						#echo $html->link(__('Back', true),  array('controller'=> 'customers', 'action'=>'index'),array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);')); 
	
                        	#echo $html->link('back',  array('controller'=> 'stations', 'action'=>'edit', $station_number));
                	}
                	?>
                </div>
	</div>
</div>
<!--right hand side starts from here-->
<div id="related-content">
        <div class="box start link">
           <a href="http://www.swisscom.ch/grossunternehmen" target="_blank"><?php __('Home Swisscom') ?></a>
        </div>
        <div class="box ">
        	 <h3><?php __('mediatrixList') ?></h3>
              <p><?php __('mediatrixList_blurb') ?></p>
              <p><?php #echo $html->link(__("mediatrixList_more", true), array('controller' => 'medaitrix', 'action' => 'blurb_info/customer_id:' . $SELECTED_CNN), array('class' => "fancybox fancybox.ajax", 'id' => '')); ?></p>
			  <div id="shortcont">
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('fullcont')"  title=""><?php echo __('moreStart') ?></a>             
            </div>
            <div style="display:none;" id="fullcont_type"  >
               <p  ><?php echo __('mediatrixList_helpText') ?></p>
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('shortcont')"  title=""><?php echo __('moreEnd') ?></a>      
			</div>
              
         </div>
        
<!--INTERNAL USER OPTIONS -->
        <?php if($userpermission==Configure::read('access_id'))
        {?>
           <div class="box info">
             <h3><?php __("Internal User");?></h3>
             <p><?php echo $selected_customer; ?></p>
             <p><?php __("customerId");?><?php echo $SELECTED_CNN; ?></p>
            </div>
	    <?php 
    		if ($_SESSION['VIEWMODE'] == 'EXTERNAL')
    		{
    			echo $html->link(__("scmView", true), array('controller' => 'mediatrixes', 'action' => 'toggleView?customer_id=' . $SELECTED_CNN . '&view=INTERNAL'),array('style'=>'margin-left:10px;'));
    		}
    		else
    		{
    			echo $html->link(__("userView", true), array('controller' => 'mediatrixes', 'action' => 'toggleView?customer_id=' . $SELECTED_CNN . '&view=EXTERNAL'),array('style'=>'margin-left:10px;'));
    		}
        } ?>
</div> 
<!--right hand side  ends here-->

