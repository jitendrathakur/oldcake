<style>
.spclWidth_tooltop{
	width:150px !important;
}
</style>
<style type="text/css">
/* CSS for modelpopup */
     
 #clicker4 {	cursor:pointer;	}

#popup-wrapper4{
	width:390px;
	height: auto;
    padding: 10px 10px 40px;
	background-color:#F9F9F9;
	
}
	
body
{
    padding:10px;
}
		
.demonstrations1 div {
  float: right;
  width: 20px;
  height: 30px;
  margin: -19px 0 5px!important;
  cursor: pointer;
  font-size: 15px;
  font-weight: bold;
}
.modalPopLite-mask2 {
    background-color: #f;
    left: 0;
    position: absolute;
    top: 0;
    z-index: 9994;
}
	</style>

<?php 

echo $javascript->link('/js/jquery.fancybox');

?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
</script>

<script>
	$(function () {
		$('#popup-wrapper4').modalPopLite({ openButton: '.clicker4', closeButton: '#close-btn4', isModal: true });
		
	});

    function fancyboxclose2(){
		setTimeout( function() { $('#close-btn4').trigger('click'); },5);
		
	 	}
		
		
		function initTrunkId(trunkIDetails){
		var trunkDatavalue =$(trunkIDetails).attr('name');
		$('#clickerId4').attr('onclick','deleteTrunk("'+trunkDatavalue+'")');
	     }
	function deleteTrunk(trunkIDetails){
		
	
		var trunkData = trunkIDetails.split('-');
		
		var trunkId = trunkData['0'];
		var trunkName = trunkData['1'];
		var customer_id ='<?php echo $SELECTED_CNN ?>';
		window.location= "<?php echo Configure::read('base_url');?>trunks/deleteTrunk/?customer_id="+customer_id+"&trunk_id="+trunkId+"&trunk_name="+trunkName;
		
		
	}	
</script>




<div>		

	<div id="modalPopLite-mask4" style="width:100%;z-index: 1;"  class="modalPopLite-mask"></div>
	<div id="modalPopLite-wrapper" style="left: -10000px;z-index: 1000; " class="modalPopLite-wrapper">
		<div class="modalPopLite-child" id="popup-wrapper4" >
		<div class="black_overlay" style="display: none;"></div>
		<h4><?php echo __('Confirmation',true); ?>
		<span class='demonstrations1' style="display: block!important; " >           
				<span style="font-size: 18px !important;margin-top: -17px; float: right;"> <a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); return fancyboxclose2(); " >X</a>	</span>  
				<span style="font-size: 18px !important;margin-top: -17px; float: right;margin-right: 10px;"><a href="javascript:;"  style="cursor:pointer;margin-top: 5px;" onMouseOver="Tip('<b><?php echo __('deleteTrunk_helpTitel') ?></b><br/><?php echo __('deleteTrunk_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a>	</span>		
			</span>
 </h4>
			<span style="width:388px; height:150px;margin:15px auto;  ">
			<h6><?php 
			
				echo __( wordwrap('trunkDeleteConfirmation',62,"<br>\n"));
			
			?></h6> <br>
			
				
			
				<span class="button-left" style="margin:2px 230px 11px !important" >
				
				<?php echo $html->link( __("Cancle", true),'javascript:void(null)',array('id' => 'close-btn4')); ?>
				
				</span>
				<a href="#" id="close-btn4">	</a>
					
				<span  class="button-right" style="margin:-35px 2px 10px !important" >
				
				<?php echo $html->link(__("Ok", true), 'javascript:void();', array('onclick'=>'', 'class'=>'clicker4','id'=>'clickerId4')); ?>
				
				</span>
					
			</span>		
		</div>
			
	</div>

</div>


<?php


 if((isset($success)) && $success){?>

		<div class="notification first" style="width: 534px" >

			<div class="ok">
				<div class="message">
					<?php echo $success." ".$_SESSION['success'];
					 
					?>
				</div>
			</div>
		</div>

	<?php }elseif(isset($error) && $error){?>
		<div class="notification first" >

			<div class="error">
				<div class="message">
					<?php
						#echo $error;

						if($error=='xml_not_respond')
							__("Xml Server is not responding");
						else
							__($error);
							
							
					?>
				</div>
			</div>
		</div>

	<?php }
		else
		{
			//echo '<br>';
			//echo '<div style="width:534px;height:55px;"  ></div>';
		}
?>

	<div class="block top">
	<br>
	
	    <?php 
	    echo $form->create('Trunk',array('action'=>'index/'.$customer_id,'id'=>'filters','type'=>'GET'));
	   ?>
	    <div class="cb">
			<div id="" class="table-content">
				    <table class="table-content phonekey dataTable tablesorter" >
						<thead>
							    <tr class="table-top">
									<!--<th class="table-column table-left-ohne" style="width:20px;">&nbsp;</th>-->
									<th  class="table-column"style="width:152px;text-align: left;"><?php __("trunkName");?></th>
									<th  class="table-column"style="width:102px;text-align: left;"><?php __("Location");?></th>
									<th  class="table-column  "style="width:64px;text-align: left;" data-placeholder="Gate Type"><?php __("gateType");?></th>
									<th  class="table-column"style="width:102px;text-align: left;"><?php __("pbxType");?></th>
									<th  class="table-column"style="width:103px;text-align: left;"><?php __("trunkRemark");?></th>
									<!--<th class="table-right-ohne">&nbsp;</th>-->
							    </tr>
							    <tr>
									<!--<td class="table-column table-left-ohne">&nbsp;</td>-->
									<td><?php echo $form->input('name', array('label' => false, 'type'=>'text','class' => 'filter-class onclick','style'=>'width:140px;', 'value'=>(isset($this->params['named']['name'])?$this->params['named']['name']:(isset($this->params['url']['name'])?$this->params['url']['name']:'')))); ?></td>
									<td><?php echo $form->input('location_name', array('label' => false, 'type'=>'text','class' => 'filter-class onclick','style'=>'width:87px;', 'value'=>(isset($this->params['named']['location_name'])?$this->params['named']['location_name']:(isset($this->params['url']['location_name'])?$this->params['url']['location_name']:'')))); ?></td>
									<td><?php echo $form->select('gate_type',$gate_type_list,(isset($this->params['named']['gate_type'])?$this->params['named']['gate_type']:(isset($this->params['url']['gate_type'])?$this->params['url']['gate_type']:'')),array('style'=>'width:46px;')); ?></td>
									<td><?php echo $form->input('pbx_type', array('label' => false, 'type'=>'text','class' => 'filter-class onclick','style'=>'width:88px;', 'value'=>(isset($this->params['named']['pbx_type'])?$this->params['named']['pbx_type']:(isset($this->params['url']['pbx_type'])?$this->params['url']['pbx_type']:'')))); ?></td>
									<td><?php echo $form->input('remark', array('label' => false, 'type'=>'text','class' => 'filter-class onclick','style'=>'width:90px;', 'value'=>(isset($this->params['named']['remark'])?$this->params['named']['remark']:(isset($this->params['url']['remark'])?$this->params['url']['remark']:'')))); ?></td>
									<!--<td class="table-right-ohne">&nbsp;</td>-->
							    </tr>
						</thead>
				    </table>
			</div>
			
			<div class="block" style="margin: 0px;">
				<div class="button-right">
					<a href="javascript:void(null)"  onclick="javascript:submi_form('filters');" name="data[filter]" value="filter" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __("filter");?></a>
				</div>

				<div class="button-left">
					<?php echo $html->link( __("reset", true),  array('controller'=> 'trunks', 'action'=>'index', 'customer_id:'.$customer_id),array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);')); ?>
                </div>
				
            </div>
	
	    <?php	
		
		// check $locations variable exists and is not empty
		if(isset($trunks) && !empty($trunks)) :
		?>
		<!--Showing Page <?php //echo $paginator->counter(); ?>-->  
		
		<?php echo $this->element('pagination/top'); ?>
	    <div id="" class="table-content">
		<table class="phonekey">
	    	<?php
			  //echo $this->element('pagination/newpaging');
			?>
	    	<thead>
	        	<tr class="table-top">
					<!--<th class="table-left-ohne" style="width:20px;">&nbsp;</th>  -->
					<th class="table-column <?php if(in_array('sort:name',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:name',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:152px;text-align: left;"><?php echo $paginator->sort(__("trunkName",true), 'name', $filter_options);?></th>
					<th class="table-column <?php if(in_array('sort:location_id',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:location_id',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:102px;text-align: left;"><?php echo $paginator->sort(__("Location",true), 'location_id', $filter_options);?></th>
					<th class="table-column <?php if(in_array('sort:gate_type',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:gate_type',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:64px;text-align: left;"><?php echo $paginator->sort(__("gateType",true), 'gate_type', $filter_options);?></th>
					<th class="table-column <?php if(in_array('sort:pbx_type',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:pbx_type',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:104px;text-align: left;"><?php echo $paginator->sort(__("pbxType",true), 'pbx_type', $filter_options);?></th>
					<!--<th class="table-column <?php if(in_array('sort:remark',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:remark',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:72px;text-align: left;border-right: 1px solid #D1D1D1!important;"><?php echo $paginator->sort(__("trunkRemark",true), 'remark', $filter_options);?></th>-->
					<th  class="table-column  " style="width:55px;text-align: right;padding-top:2px!important;" ><?php echo __("# of DN", true); ?></th>
					<th  class="table-column" style="width:20px" ></th>	
					<th  class="table-right-ohne" style="border-right: 1px solid #D1D1D1!important;"></th>
	            </tr>
	        </thead>
		<?php //echo $this->element('pagination/top'); ?>
	        <tbody>
	        	<?php
				// initialise a counter for striping the table
				$count = 0;
	
				// loop through and display format
				#echo '<pre>'; print_r($trunkDNCount);
			  #echo '<pre>';print_r($trunks);
				
				foreach($trunks as $trunk):
					// stripes the table by adding a class to every other row
					$class = ( ($count % 2) ? " class='altrow'": '' );
					// increment count
					$count++;
					
					#echo "<pre>";print_r($trunk);
				?>
	              <tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">
	             	<!--<td class="table-left">&nbsp;</td>-->		
	            	   <td class="wid-217px tooltip"> 
						    							
							<?php 
	                		 		$trunkNameTooltip = __('trunkName_tooltip',true);
									 echo $html->link( __($trunk['Trunk']['name'], true),array('controller'=>'trunks', 'action'=>'edit/trunk_id:'.$trunk['Trunk']['id']),array('onMouseOver'=>"Tip('$trunkNameTooltip', BALLOON, true, ABOVE, false)",'onMouseOut'=>"UnTip()")); 						
	                				?>
							
														
							
	            			</td>
	            			<td> 
						    <?php 
	            			  echo $trunk['Location']['name']; 
	            			?>
	            			</td>
							<td>
							<?php 
	            			  echo $trunk['Trunk']['gate_type']; 
	            			?>
					      </td>
	                		<td>
							<?php 
							  echo $trunk['Trunk']['pbx_type']; 
							?>
	                		</td>
                           
	                		<?php 
							/*if ($trunk['Trunk']['remark'] != '')
	                		{
	                		
	                		?><td class="sublist-align wid-217px tooltip">
							<div>
								<div class="fl"><span style="cursor:default" ><?php echo substr($trunk['Trunk']['remark'], 0, 10) . '...' ?></span>
								<p><?php echo $trunk['Trunk']['remark']?></p>
								</div>
							</div>
						</td>
						<?php 
	                		}
	                		else
	                		{
	                		echo '<td></td>';
	                		}*/
							?>
							<td style="text-align: right;padding-top:2px!important;" ><?php echo $trunkDNCount[$trunk['Trunk']['id']]; ?></td>
							
							<td class="table-right-ohne	 tooltip" >
                                        <div>
                                            <div class="fl">
											<span><a href="javascript:;" onclick="Tip(' <?php echo __('Channels').': '. $trunk['Trunk']['channel']; ?><br/><?php echo __('redundancy').': '. $trunk['Trunk']['redundancy'];  ?><br/><?php echo __('remark').': '. $trunk['Trunk']['remark'];?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
											</span>
                                               
                                            </div>
                                        </div>
                                    </td>
					 <td class="table-right-ohne" style="background: url(<?php echo $this->webroot; ?>/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat 3px 5px;border-right: 1px solid #D1D1D1!important;"   onmouseover="this.className='table-right-over';" onmouseout="this.className='table-right';">
                        <div class="table-menu">
                          <div class="table-menu-popup" style="z-index: 1; display: none;">
                            <ul>
                            <li class="last log">
                              <?php echo $html->link( __('Edit', true),array('controller'=>'trunks', 'action'=>'edit/trunk_id:'.$trunk['Trunk']['id'])); 
	           			?>
                            </li>
							
							
							<?php #??? who should have access
	           				if($trunk['Trunk']['status']=='7' ){ ?>
							
							<?php if($trunkDNCount[$trunk['Trunk']['id']]==0 || $trunkDNCount[$trunk['Trunk']['id']]='' ){ ?>
							<li class="last log">
							
							
                              <?php //echo $html->link( __('Delete', true),array('controller'=>'trunks', 'class'=>'clicker4' ,'action'=>'deleteTrunk','?' => array('trunk_id' => $trunk['Trunk']['id'], 'customer_id' => $SELECTED_CNN ))); ?>
						<a href="javascript:void()"  class="clicker4" id="deleteTrunk" onclick=" " name="<?php echo $trunk['Trunk']['id']."-".$trunk['Trunk']['name'];   ?>" onmouseover="initTrunkId(this)" ><?php echo __("deleteTrunk", true); ?></a>
						
                            </li>
							<?php }  ?>
							<?php }  ?>
							
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
			__("No Dns available in DB");
			echo '</div>';
		endif;
		?>
	 
                <div class="button-left">
                	<?php if($userpermission==Configure::read('access_id'))
                	{
						#echo $html->link(__('Back', true),  array('controller'=> 'trunks', 'action'=>'index'),array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);')); 
	
                        	#echo $html->link('back',  array('controller'=> 'stations', 'action'=>'edit', $station_number));
                	}
                	?>
                </div>
	</div>
</div>
<!--right hand side starts from here-->
<div id="related-content">
        <div class="box start link">
                <a href="http://www.swisscom.ch/grossunternehmen" target="_blank">
                <?php __('Home Swisscom') ?>
                </a>
        </div>
        <div class="box">
        	 <h3><?php __('trunkList') ?></h3>
                 <p>
                  <?php __('trunkList_blurb') ?>
                 </p>
			<div id="shortcont">
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('fullcont')"  title=""><?php echo __('moreStart') ?></a>             
            </div>
            <div style="display:none;" id="fullcont_type"  >
               <p  ><?php echo __('trunkList_helpText') ?></p>
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('shortcont')"  title=""><?php echo __('moreEnd') ?></a>      
			</div>	 
        </div>

<!--INTERNAL USER OPTIONS -->
        <?php if($userpermission==Configure::read('access_id'))
        {?>
                <div class="box info">
                <h3><?php __("Internal User");?></h3>
                <p><?php __("Customer View:");?><?php echo $SELECTED_CNN; ?></p>
                <p><?php echo $selected_customer; ?></p>

                </div>
	 <?php 
    		if ($_SESSION['VIEWMODE'] == 'EXTERNAL')
    		{
    			echo $html->link(__("scmView", true), array('controller' => 'trunks', 'action' => 'toggleView?customer_id=' . $SELECTED_CNN . '&view=INTERNAL'),array('style'=>'margin-left:10px;'));
    		}
    		else
    		{
    			echo $html->link(__("userView", true), array('controller' => 'trunks', 'action' => 'toggleView?customer_id=' . $SELECTED_CNN . '&view=EXTERNAL'),array('style'=>'margin-left:10px;'));
    		}
        } ?>

		</div>
<!--ight hand side  ends here-->

