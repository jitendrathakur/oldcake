<?php
 
 App::import('Model', 'Log');
 $this->Log = new Log();
  echo $javascript->link('/js/jquery.fancybox');
  #echo $javascript->link('/js/modalPopLite1');
  #echo $html->css('modalPopLite');
  echo $javascript->link('front');
?>
  <script>
	function submenuactivity(obj, action)
	  {	
		if(action==1){ $('#table-popup').show();} 
		else if(action==0){ $('#table-popup').hide();}	
	  }
  </script>
  <script type="text/javascript">
	$(document).ready(function() {
		//$.noConflict();
		$('.fancybox').fancybox();
		 $('.tooltip').mouseout(function(n){
			$(this).find("p:first").attr("style", "display:none;");  
	  }); 
	  $('.tooltip').mouseover(function(n){
		$(this).find("p").attr("style", "display:inline;");  
	  });			
	});
  </script>
  <script>
	function fancyboxclose(){
		setTimeout( function() { $('#close-btn').trigger('click'); },5);
	 	}
		
</script>
  
  <script>
  	function scenario_delete(val){
		//string = document.referrer;
		var clickedScenario = $('#ScenarioUID').val();
		$('.black_overlay').css('display', 'block');
	    $.fancybox.showLoading()  ;	
		
		var TargetURL = "<?php echo Configure::read('base_url');?>scenarios/deleteScenario/scenario_id:"+clickedScenario;
	
 		jQuery.post( TargetURL,  function( data ) {  //alert(data);
			window.location.href = "<?php echo Configure::read('base_url'); ?>scenarios/index/customer_id:<?php echo $SELECTED_CUSTOMER_NAME; ?>";
	});
	setTimeout( function() {     
			$('#close-btn').trigger('click');
		 },5000);
	//window.location.reload();
}
  </script>

<style type="text/css">
	/* CSS for modelpopup */
	     
	#clicker	{			
		cursor:pointer;
	}
	
	.popup-wrapper		{
		width:390px;
		height:150px;
		background-color:#fff;
		padding:10px;		
	}
	body	{
	    padding:10px;
	}

.demonstrations1 div {
  float: right;
  width: 20px;
  height: 30px;
  margin: -30px 0 5px!important;
  cursor: pointer;
  font-size: 15px;
  font-weight: bold;
}
</style>

<script type="text/javascript">
//script for modelpopup

	  function InitScenario(val,valName){
	  	
		document.getElementById('ScenarioUID').value= val;
		document.getElementById('ScenarioUName').innerHTML = valName;
	  }

	$(function () {
		//jQuery('.sid').each(function() { 
	    $('.popup-wrapper').modalPopLite({ openButton: '.clicker', closeButton: '#close-btn', isModal: true });
		
		
		// });
			
	});
	
	
</script>


<div class="block top">
<?php if((isset($success)) && $success){?>
		<div class="notification first" style="width: 534px" >
			<div class="ok">
				<div class="message">
					<?php echo __($success, true);?>
				</div>
			</div>
		</div>
		
	<?php }elseif(isset($error) && $error){?>
		<div class="notification first" >
			<div class="error">
				<div class="message">
					<?php 
						#echo $error;
						echo __($error, true);
					?>
				</div>
			</div>
		</div>
		<?php 		
		}
		
	    #For pagination reasons to handle sort and filter
	    $paginator->options(array('url' => $this->passedArgs));
	    
	    echo $form->create('Scenario',array('action'=>'index/customer_id:'.$SELECTED_CUSTOMER_NAME,'id'=>'filters','type'=>'GET'));
	   // echo $form->input('Scenario.customer_id', array('type'=>'hidden','value'=>$SELECTED_CUSTOMER_NAME)); 
	    $scenarioStatus = Configure :: read('scenarioStatus'); 
	    ?>
			<div class="black_overlay" style="height: 800px; width: 1366px; display: none;">    
    </div>
		<div class="cb">
			<!--CBM START HERE -->
			<div class="block" style="margin: 0px;">
				<!--<div class="button-right">
					<?php echo $html->link( __("Export Csv", true),  array('controller'=> 'scenarios', 'action'=>'export',),array('onmouseover'=>'hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
				</div>-->
				<div class="button-right">
 					<?php #echo $html->link( __("createScenario", true),  array('controller'=> 'scenarios', 'action'=>'edit', 'scenario_id:create&customer_id=' . $SELECTED_CUSTOMER_NAME),array('onmouseover'=>'submenuactivity(this,1);hoverButtonRight(this);','onmouseout'=>'javascript:submenuactivity(this,1);javascript:outButtonRight(this);','id'=>'demo_skins_yellow')); ?>
					<?php 
					if($tooltipisonoroff !=0) { ?>
					<a href="<?php echo Configure::read('base_url');?>scenarios/edit/scenario_id:create&customer_id=<?php echo $SELECTED_CUSTOMER_NAME ?>" onMouseOver="Tip('<?php echo __('createScenario_desc') ?>', BALLOON, true, ABOVE, false); submenuactivity(this,1);hoverButtonRight(this);" onMouseOut="UnTip(); javascript:submenuactivity(this,1);javascript:outButtonRight(this);"><?php echo __("createScenario", true); ?></a>
				    <?php	} 
				    else {
					echo $html->link( __("createScenario", true),  array('controller'=> 'scenarios', 'action'=>'edit', 'scenario_id:create&customer_id=' . $SELECTED_CUSTOMER_NAME),array('onmouseover'=>'submenuactivity(this,1);hoverButtonRight(this);','onmouseout'=>'javascript:submenuactivity(this,1);javascript:outButtonRight(this);','id'=>'demo_skins_yellow')); 
					 } ?>
 				</div>

           </div>
        <?php
		if(count($scenarios) < 1)
	    {
	    	echo '<p>' . __('There are currently no scenarios in the database', true) . '</p>';
	    }
	    else
	    {
	    ?>
		 <!--CBM END HERE -->
			<!--CBM START HERE -->
			<div id="" class="table-content">
				<?php echo $this->element('pagination/top'); ?>
				<table class="table-content phonekey">
					<thead>
						<tr class="table-top">
							
							<th class="table-column <?php if(in_array('sort:Name',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:Name',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:132px;text-align: left;"><?php echo $paginator->sort(__("scenario_name",true), 'Name', $filter_options);?></th>
							<th class="table-column <?php if(in_array('sort:status',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:status',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:100px;text-align: left;"><?php echo $paginator->sort(__("scenariostatus",true), 'Status', $filter_options);?></th>
							<th  class="table-column" style="width:95px;text-align: left;;padding-top:2px!important;"><?php echo __("odsOptions",true)?></th>
							<th  class="table-column" style="width:35px;text-align: right;;padding-top:2px!important;"><?php echo __("CountDN",true)?></th>
							<th  class="table-column" style="width:150px;text-align: left;;padding-top:2px!important;"><?php echo __("nextSchedule",true)?></th>
							<th  class="table-column" style="width:20px" ></th>	
							<th class="table-right-ohne" style="border-right: 1px solid #D1D1D1!important;">&nbsp;</th>
						</tr>
					</thead>
					<tbody>

				<!--CBM END HERE -->
				
	        		<?php
					// initialise a counter for striping the table
					$count = 0;
					//pr($scenarios);
					// loop through and display format
					foreach ($scenarios as $scenario)
					:
					// stripes the table by adding a class to every other row
					$class = (($count % 2) ? " class='altrow'" : '');
					// increment count
					$count++;
					
					
					
					?>
		        		<tr>
		        		  
                    		<td>
                    		  <table class="table-content phonekey" style="border-style: none;">
                    		    <tr><td style="border-style: none;">
                    		      <?php 
                     			  #echo $html->link($scenario['Scenario']['Name'], '',array('onclick'=>'javascript:return scriptview(\''.$scenario['Scenario']['id'].'\');','title'=>$scenario['Scenario']['id'])) ;
                    			  #echo $scenario['Scenario']['Name']
                    			  if(strlen(strval($scenario['Scenario']['Name']) )> 15)
								{
									$link = substr($scenario['Scenario']['Name'], 0, 18) . '..';
									$longScenarioname=array("onMouseOver"=>"Tip('".$scenario['Scenario']['Name']."', BALLOON, true, ABOVE, false)",'onMouseOut'=>"UnTip(); ");
								}
								else {
									$link = $scenario['Scenario']['Name'];
									$longScenarioname=array("onMouseOver"=>"",'onMouseOut'=>"");
								}
							 
							 
							 
								
								if ($scenario['Scenario']['status'] == '6')
								{
									echo $html->link($link,array('controller'=>'scenarios', 'action'=>'edit/scenario_id:'.$scenario['Scenario']['id'].'&mode=operate'));
								
								}
								
								elseif ($scenario['Scenario']['status'] == '3')
								{
									if(($userpermission == Configure::read('access_id')) && ($_SESSION['VIEWMODE'] != 'EXTERNAL'))
									{
										
										echo $html->link($link,array('controller'=>'scenarios', 'action'=>'edit/scenario_id:'.$scenario['Scenario']['id']));
											
									}
									else 
									{
										echo $scenario['Scenario']['Name'];
									}
								}
								else 
								{
									echo $html->link($link,array('controller'=>'scenarios', 'action'=>'edit/scenario_id:'.$scenario['Scenario']['id']),$longScenarioname);
									
								}
								 ?></span>
                                
                    			  </td>
                    	   		   <!-- <td  class="table-right" style="border-style: none;" onmouseover="this.className='table-right-over';" onmouseout="this.className='table-right';"> -->
							    </tr>
							  </table>
							</td>
               		           <?php 
              		      if ($scenario['Scenario']['status'] == '7')
                		    {
                		      echo '<td style="color:red">';
                 		  	  ?><?php
                       		  #echo __($scenarioStatus[$scenario['Scenario']['status']], true);
                             }
                   		  elseif (($scenario['Scenario']['status'] == '8') || ($scenario['Scenario']['status'] == '1'))
                             { echo '<td>';}
                          else { echo '<td>';}
					?>
                    <span  id="indexsts_<?php echo $scenario['Scenario']['id']; ?>"> 
                    <?php
                    	#Differnt links based on state
                    		if(($scenario['Scenario']['status'] == '8'))
                    		{
                    			$record = $this->Log->getLogDetails($scenario['Scenario']['id'],8,$SELECTED_CUSTOMER_NAME);	
				  
				 				foreach($record as $log){
						
								#$comment = $log['Log']['modification_response'];
								$logid = $log['Log']['id'];
								echo $html->link(__($scenarioStatus[$scenario['Scenario']['status']], true),array('controller'=>'logs', 'action'=>'logdetails',$logid), array('class'=>"fancybox fancybox.ajax"));
								}
                    		}
                    
                    		elseif(($scenario['Scenario']['status'] >0) && ($scenario['Scenario']['status'] <4))
                    		{
                    			if ($scenario['Scenario']['status'] == '3')
                    			{
                    				if(($userpermission == Configure::read('access_id')) && ($_SESSION['VIEWMODE'] != 'EXTERNAL'))
                    				{
                    			
                    					echo $html->link(__($scenarioStatus[$scenario['Scenario']['status']], true),array('controller'=>'scenarios', 'action'=>'edit?scenario_id='.$scenario['Scenario']['id']));
                    				
                    				}
                    				else
                    				{
                    					echo __($scenarioStatus[$scenario['Scenario']['status']], true);
                    			
                    				}
                    			}
                    			else 
                    			{
                    				echo $html->link(__($scenarioStatus[$scenario['Scenario']['status']], true),array('controller'=>'scenarios', 'action'=>'edit?scenario_id='.$scenario['Scenario']['id']));
                    				 
                    			}
                    			                  		
                    		     
                    		}
	   						 elseif(($scenario['Scenario']['status'] >3) && ($scenario['Scenario']['status'] <7))
                    		{
                    			                  		
                    		     echo $html->link(__($scenarioStatus[$scenario['Scenario']['status']], true),array('controller'=>'scenarios', 'action'=>'edit?scenario_id='.$scenario['Scenario']['id'] . '&mode=operate'));
                    			
                    		}
                    		elseif($scenario['Scenario']['status'] == 7)
                    		{
								
                    			#echo __($scenarioStatus[$scenario['Scenario']['status']]);
                    			$record = $this->Log->getLogDetails($scenario['Scenario']['id'],7,$SELECTED_CUSTOMER_NAME);
                    			
                    			foreach($record as $log){
                    			
                    				#$comment = $log['Log']['modification_response'];
                    				$logid = $log['Log']['id'];
                    				echo $html->link(__($scenarioStatus[$scenario['Scenario']['status']], true),array('controller'=>'logs', 'action'=>'logdetails',$logid), array('class'=>"fancybox fancybox.ajax"));
								}
                    			 
                    		}
                    		?>
                    
                    </span>
                    </td>     	
                     <td>
				 <?php  if ($scenario['Scenario']['status'] == '4') { 
				 	?>
				 	<div class="info info-activate" style="z-index: inherit">
				 	<!--   <a href="">&nbsp;</a> -->
				 	<?php # TEMP COMMENT OUT echo $html->link( '.',array('controller'=>'scenarios', 'action'=>'create_schedule/'.$scenario['Scenario']['id'].'/create/'.$SELECTED_CUSTOMER_NAME.'/0/activate'), array('class'=>"fancybox fancybox.ajax",'id'=>'activateScenario')); ?>
					<span id="opt_<?php echo $scenario['Scenario']['id']; ?>">
					
					<?php echo $html->link( '.',array('controller'=>'scenarios', 'action'=>'confirmapply?scenario_id='.$scenario['Scenario']['id'].'&operation=activate'), array('class'=>"fancybox fancybox.ajax",'id'=>'activateScenario'));
										
					?></span>		
				 	
				 	<div class="flyout" id="actdiv_<?php echo $scenario['Scenario']['id']; ?>">
				 	   <h4 id="actfly_<?php echo $scenario['Scenario']['id']; ?>"><?php echo __('ACTIVATE')?></h4>
				 	     <div class="flyout-text warn" id="actflylabel_<?php echo $scenario['Scenario']['id']; ?>" >
				 	        <?php echo __('Use this option to activate the scenario.')?>
				 	      </div>
				 	    <div class="flyout-footer"></div>
				 	</div>
				 </div>
				 	<?php 
				 	                    	
				 	#echo $html->link( __("", true),'javascript:deleteOdsentry('.$res['Odsentry']['source'].',this);',array('id'=>$res['Odsentry']['source'],'class'=>'deleteOdsentry'));
				 
				 
				 } ?>
				 
				  <?php  if ($scenario['Scenario']['status'] == '6') { 
				 	?>
				 	<div class="info info-deactivate" style="z-index: inherit">
				 	<!--   <a href="">&nbsp;</a> -->
				 	 <?php #echo $html->link( '.',array('controller'=>'scenarios', 'action'=>'create_schedule/'.$scenario['Scenario']['id'].'/create/'.$SELECTED_CUSTOMER_NAME.'/0/deactivate'), array('class'=>"fancybox fancybox.ajax",'id'=>'deactivateScenario')); ?>

					<span id="opt1_<?php 
					echo $scenario['Scenario']['id']; ?>"><?php echo $html->link( '.',array('controller'=>'scenarios', 'action'=>'confirmapply?scenario_id='.$scenario['Scenario']['id'].'&operation=deactivate'), array('class'=>"fancybox fancybox.ajax",'id'=>'deactivateScenario')); 
					?></span>
											
				 	
				 	<div class="flyout" id="deactdiv_<?php echo $scenario['Scenario']['id']; ?>">
				 	  <h4 id="deactfly_<?php echo $scenario['Scenario']['id']; ?>"><?php echo __('De-Activate')?></h4>
				 	    <div class="flyout-text warn" id="deactflylabel_<?php echo $scenario['Scenario']['id']; ?>">
				 	       <?php echo __('Use this option to de-activate the scenario.')?>
				 	    </div>
				 	   <div class="flyout-footer"></div>
				 	 </div>
				 </div>
				 	<?php 
				 	                    	
				 	#echo $html->link( __("", true),'javascript:deleteOdsentry('.$res['Odsentry']['source'].',this);',array('id'=>$res['Odsentry']['source'],'class'=>'deleteOdsentry'));
				 
				 
				 } ?>
				  <?php  if ($scenario['Scenario']['status'] == '7') { 
				  
				  $scenarioId = $scenario['Scenario']['id'];
				  
				 // $urlfilter="scenarios/edit/scenario_id:$scenario['Scenario']['id']/sort:name/direction:desc";
				 	?>
				 	<div class="info info-error" style="z-index: inherit">
				 	
				 	<?php echo $html->link('.',  array('controller'=> 'scenarios', 'action'=>'edit', 'scenario_id:'.$scenario['Scenario']['id'] . '&mode=operate&view=log'));?>				
				 	
				 	<div class="flyout">
				 	<h4><?php echo __('Warning')?></h4>
				 	                       	<div class="flyout-text error" >
				 	                            <?php echo __('warning_OdsActivationFailure')?>
				 	                      	</div>
				 	                      	<div class="flyout-footer"></div>
				 	                       	</div>
				 	                    	</div>
				 	<?php 
				 	                    	
				 	#echo $html->link( __("", true),'javascript:deleteOdsentry('.$res['Odsentry']['source'].',this);',array('id'=>$res['Odsentry']['source'],'class'=>'deleteOdsentry'));
				 
				 
				 } 
				 if (($scenario['Scenario']['status'] >= 1) &&  ($scenario['Scenario']['status'] < 4)){ ?>
				
				  <?php
				 				  						
				  		#__('construct');
				 				  					
				 				  					
				}	
				 ?>
				 </td>
               
					<td style="padding:2px;text-align:right";><?php echo $scenarioCount[$scenario['Scenario']['id']];?></td>
										
					<td style="padding:0px">
						<table style="border:none; padding:0; margin:0">
							<?php 
							#$execRecords = count($scenario['Execution'])-1;
							$executions = $scenario['Execution'];
							
							#print_r($executions);
							$dates = array();
							foreach ($executions as $key => $row)
							{
								$dates[$key] = $row['targetDate'];
								
							}
							array_multisort($dates, SORT_ASC,  $executions);
							#print_r($executions);
							$counter = 1;
							foreach ($executions as $execution)
							{
								
								#if($scenario['Execution'][$iterateExecutions]['status'] =='SCHEDULED' || 
								#$scenario['Execution'][$iterateExecutions]['status'] =='INPROGRESS' || 
								#($scenario['Execution'][$iterateExecutions]['status'] == 'WARNING' &&  (strtotime("-5 day") <= strtotime($scenario['Execution'][$iterateExecutions]['modified'])))) 
								
								if($execution['status'] =='SCHEDULED' || 
								$execution['status'] =='INPROGRESS') 
								{
								  while ($counter <= 1)
									{
									?>
									<tr  onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">
									<td style="width:90px;text-align: left;border:none; border-right: 2px"><?php echo __($execution['operation']); ?></td>
									<td style="width:80px;text-align: left;border:none;"><?php

									
									$today = date('d.m.Y');
									
									$tDate = date('d.m.Y',strtotime($execution['targetDate']));
									if($today == $tDate)
									
									{
										#echo date('d.m.Y');
										#echo date('d.m.Y',strtotime($execution['targetDate']));
										#echo date('H:s',strtotime($execution['targetDate']));
										echo $html->link(date('H:i',strtotime($execution['targetDate'])),  array('controller'=> 'scenarios', 'action'=>'edit', 'scenario_id:'.$scenario['Scenario']['id'] . '&mode=operate'));
																				 
									}
									else 
									{
												
										#echo date('d.m.Y');
										#echo $tDate;
										echo $html->link($tDate,  array('controller'=> 'scenarios', 'action'=>'edit', 'scenario_id:'.$scenario['Scenario']['id'] . '&mode=operate'));
										
										#echo 'NOT TODAY';
									}
									
									
									
									?></td>
									 <?php 
								   if($execution['status'] =='WARNING')
									{
										echo '<td style="width:70px;text-align: left; color: red;">';
									 	echo $execution['status'];
									 	echo '</td>';
									}
								  else
									{
									  #  echo '<td style="width:70px;text-align: left;">';
									  #	echo $execution['status'];
									  #  echo '</td>';
									}
								 	?>
									<?php
								  if($execution['status'] =='INPROGRESS')
									{
									 echo '<td style="width:70px;text-align: left;border:none;">';
									 echo $execution['status'];
									 echo '</td>';
		 							 #echo '<td class="table-right-ohne">' . $html->link('Log',  array('controller'=> 'logs', 'action'=>'viewlog', 'customer_id:'.$SELECTED_CUSTOMER_NAME . '&' . 'affected_obj=' . $scenario['Scenario']['id'])) . '</td>';
									 ?>
									 <td class="table-right-ohne" style="background: url(<?php echo $this->webroot ?>/images/assets/icons/9px/148_arrowdown_02_cmyk.gif) no-repeat 3px 5px;border-style: none;"></td>
									 <?php
									}
									?>
									</tr>
									<?php
									$counter++;
									}
								}
							}
							?>
						</table>
					</td>
				  <td class="table-right-ohne	 tooltip" >
                    <div>
                      <div class="fl">
						<span><!--<a href="javascript:;" onclick="Tip(' <?php echo __('Szenario create process'); ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>-->
						<a href="javascript:;" onclick="Tip(' <?php echo __($scenario['Scenario']['remark']); ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
						
						 					
						</span>
                                               
                      </div>
                    </div>
                 </td>
		            		<td id="sc_<?php echo $count;?>" class="table-right-ohne" style="background: url(<?php echo $this->webroot; ?>/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat 3px 45%;border-right: 1px solid #D1D1D1!important;"   onmouseover="this.className='table-right-over';" onmouseout="this.className='table-right';">
                    		  <div class="table-menu">
                    			<div class="table-menu-popup" style="z-index: 1">
                    				<ul>
                    				  <?php 
                    				  if (($scenario['Scenario']['status'] != '7') && ($scenario['Scenario']['status'] != '6'))
                    				 	{
											
											$scenario_id = $scenario['Scenario']['id'];
											$scenario_name = $scenario['Scenario']['Name'];
											 ?>
                    					  <li class="delete">
									 	    <?php #echo $html->link( __("Delete Schedule", true),array('controller'=>'scenarios', 'action'=>'deleteStation/'.$scenario['Scenario']['id'])); 
										    #echo $html->link( __("Delete Scenario", true),''); 
											
											# echo $html->link( __("deleteScenario", true),array('controller'=>'scenarios', 'action'=>'deleteScenario/scenario_id:' . $scenario['Scenario']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure want to delete ?');"));
											
 #echo $html->link( __("deleteScenario", true),array('escape'=>false,'title'=>'Delete','onclick'=>"javascript:scenario_delete('.$scenario['Scenario']['id'].');"));
 ?>
 <!--<a href="javascript:;" onclick="scenario_delete(<?php echo $scenario['Scenario']['id'] ?>)"><?php echo  __("deleteScenario", true); ?></a>-->
 <?php																				  
										    echo $html->link( __("deleteScenario", true),'javascript:void(null)', array('onmouseover'=>"javascript:InitScenario('".$scenario_id."','".$scenario_name."')", 'escape'=>false,'title'=>'Delete','class'=>"clicker",'custid'=>"$scenario_id", 'id'=> 'updateScenarioId')); 
																				
												 									  
										  ?>	
										
										 										
										  </li>
																			  
										  
										   <?php 
                    					} 
																				
										?>
																				  
								     <?php 
								     		if(($scenario['Scenario']['status'] != '7') && ($scenario['Scenario']['status'] != '6'))
								     		{
								     			if(($scenario['Scenario']['status'] == '3'))
								     			{
								     				if (($userpermission == Configure::read('access_id')) && ($_SESSION['VIEWMODE'] != 'EXTERNAL'))
								     				{
								     				
								     					echo '<li class="edit">';
								     					echo $html->link(__('editScenario', true),  array('controller'=> 'scenarios', 'action'=>'edit', 'scenario_id:'.$scenario['Scenario']['id']));
								     					echo '</li>';
								     				}
								     	
								     			}
								     			else 
												{
													echo '<li class="edit">';
													echo $html->link(__('editScenario', true),  array('controller'=> 'scenarios', 'action'=>'edit', 'scenario_id:'.$scenario['Scenario']['id']));
													echo '</li>';
												}
	    									
								     		
								     		}			
	    									if (($scenario['Scenario']['status'] > 3) && ($scenario['Scenario']['status'] != '7')){?>
										  <li class="edit">
								     		<?php echo $html->link(__('operateScenario', true),  array('controller'=> 'scenarios', 'action'=>'edit', 'scenario_id:'.$scenario['Scenario']['id'] . '&mode=operate'));?>
										  </li>
								
										  <?php } 
										  if (($userpermission == Configure::read('access_id')) && ($_SESSION['VIEWMODE'] != 'EXTERNAL'))
										  {
										  ?>
										  <li class="script">
											<?php 
											
												echo $html->link(__("viewScript", true), array('controller' => 'scenarios', 'action' => 'scriptdetails/' . $scenario['Scenario']['id']), array('class' => "fancybox fancybox.ajax")); 
											?>									  
										  </li>
										  <?php 
										  }?>
										  
										  
										  <li class="script">
											<?php echo $html->link(__("viewSummary", true), array('controller' => 'scenarios', 'action' => 'scriptsummary/' . $scenario['Scenario']['id']), array('class' => "fancybox fancybox.ajax")); ?>									  
										  </li>
										  
										  <?Php
										  if (($scenario['Scenario']['status'] == '1') || ($scenario['Scenario']['status'] == '2') || ($scenario['Scenario']['status'] == '3')){ ?>
										  	<li class="script">
																						
											<a href="<?php echo Configure::read('base_url');?>logs/viewlog?customer_id=&affected_obj=<?php echo $scenario['Scenario']['id']; ?>&user=&log_entry=&status=&afterdate=&aftertime=&beforedate=&beforetime=&currpage=1"><?php echo __('viewScenarioHistory',true) ?></a>
											
																				  
										  </li>
										<?php  } else {  ?>
										  
										  <li class="script">
											<?php echo $html->link(__('viewScenarioHistory', true),  array('controller'=> 'scenarios', 'action'=>'edit', 'scenario_id:'.$scenario['Scenario']['id'] . '&mode=operate&view=log'));?>									  
										  </li>
										 <?php } ?>
										  
										  <?php 
                    				  	if (($scenario['Scenario']['status'] == '7') && ($userpermission == Configure::read('access_id')) && ($_SESSION['VIEWMODE'] != 'EXTERNAL'))
                                
                               
                    				 	{ ?>
                    					  <li class="edit">
									 	    <?php #echo $html->link( __("Delete Schedule", true),array('controller'=>'scenarios', 'action'=>'deleteStation/'.$scenario['Scenario']['id'])); 
										    #echo $html->link( __("Delete Scenario", true),''); 									  
										    echo $html->link(__("manualExceptionProcess", true), array('controller' => 'scenarios', 'action' => 'exceptionoverride?scenario_id=' . $scenario['Scenario']['id']), array('class' => "fancybox fancybox.ajax"));									  
										 #echo $html->link( __("deleteScenario", true),array('controller'=>'scenarios', 'action'=>'deleteScenario', $scenario['Scenario']['id']),array('escape'=>false,'title'=>'Delete','value'=>"Confirm !" ,'onclick'=>"dalert.ReplaceConfirm();confirm('Wanna replace native confirm?','yes','no');")); ?>	
										 
										  </li> <?php 
                    					} ?>
										  
                    				</ul>
							
                    			</div>
								
			
             				  </div>
							  
</td>
							
		        		</tr>
	        		<?php 
                    endforeach; ?>
					
					
					</tbody>
<?php							  
/*
 * Start Confirmation Overlay Model
*/	
?>
						  
<div>
				
	<div id="modalPopLite-mask" style="width:100%" class="modalPopLite-mask"></div>
	<div id="modalPopLite-wrapper" style="left: -10000px;z-index: 2;" class="modalPopLite-wrapper">
	<div class="modalPopLite-child popup-wrapper" id="popup-wrapper">
	    <h4><?php echo __('Confirmation',true); ?>
			<span class='demonstrations1' style="display: block!important;" >           
				<span style="font-size: 18px !important;margin-top: -17px; float: right;"> <a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); return fancyboxclose(); " >X</a>	</span>  
				<span style="font-size: 18px !important;margin-top: -17px; float: right;margin-right: 10px;"><a href="javascript:;"  style="cursor:pointer;margin-top: 5px;" onMouseOver="Tip('<b><?php echo __('confirmDeleteScenario_helpTitel') ?></b><br/><?php echo __('confirmDeleteScenario_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a>	</span>		
			</span>
		  </h4>
	 <span  style="width:230px; height:150px;margin:50px auto;">
	         <?php #echo $scenario['Scenario']['id']; ?>
			 
			<h6 style="margin-left:0px;font-weight:normal !important;" ><?php #echo __('ConfirmDeleteScenario');?>
				
				<?php echo __('scenarioNameToDelete') ?> <span id="ScenarioUName"></span>
			</h6> <br><br>
			<a href="#" id="close-btn"></a>	
			 <span class="button-left" style="margin-left:229px !important;" >
			<?php
				
				 echo $html->link( __("Cancle", true),'javascript:void(null)',array('id' => 'close-btn')); 
			 ?>
						
			</span>
			
			<span  class="button-right" style="margin-right:25px;" >
			<?php
				$scenario_id = $scenario['Scenario']['id'];
				
			 echo $html->link(__("Ok", true), 'javascript:void(null)', array('onclick'=>'javascript:scenario_delete("'.$scenario_id.'")', 'id' => "$scenario_id",'class'=>'clicker')); ?>
				
	      	</span>
		</span>	
	</div>
  </div>
</div>
<input type="hidden" name="ScenarioUID" id="ScenarioUID" class="sid" value="">
				</table>

</div>
	<?php 
    $form->end();
	echo $this->element('pagination/bottom');
	} 
	?>
	</div>
	<?php //echo $this->element('pagination/newpaging');?>
	</div>
</div>
                <!--right hand side starts from here-->
<div id="related-content">
	<div class="box start link">
        	<a href="http://www.swisscom.ch/<?php __('corporatebusiness') ?>" target="_blank"><?php __('Home Swisscom') ?></a>
    </div>
          <div class="box">
        	 <h3><?php __('Scenario List'); ?></h3>
                 <p><?php __('This page allows gate users to list all onDemand scenarios. ') ?></p>
			 <div id="shortcont"><a href="javascript:;" style="cursor:pointer" onclick="set_visi('fullcont')"  title=""><?php echo __('moreStart') ?></a></div>
            <div style="display:none;" id="fullcont_type"  >
               <p><?php echo __('scenarioList_helpText') ?></p>
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('shortcont')"  title=""><?php echo __('moreEnd') ?></a>      
			</div>
        </div>
		<div class="box">
		 <span style="font-weight: normal;text-decoration: none !impotant;" >
			<a href="<?php echo Configure::read('base_url')."files/Anleitung_OnDemandSchaltung_RE3.pdf"; ?>" style="cursor:pointer"  target="_blank"  title="Anleitung Self Administration RE3 on Demand Schaltung"><?php __("re3Ods_guide");?></a>
		</span>
		</div>
          <?php if($userpermission==Configure::read('access_id'))
        { ?>

        <!--INTERNAL USER OPTIONS -->
              <div class="box info">
                <h3><?php __("Internal User");?></h3>
                <p><?php __("customerName");?><?php echo $selected_customer; ?></p>
                <p><?php __("customerId");?><?php echo $SELECTED_CNN; ?></p>
              </div>
              
               						
    	<?php 
    		if ($_SESSION['VIEWMODE'] == 'EXTERNAL')
    		{
    			echo $html->link(__("scmView", true), array('controller' => 'scenarios', 'action' => 'toggleView?customer_id=' . $SELECTED_CNN . '&view=INTERNAL'));
    		}
    		else
    		{
    			echo $html->link(__("userView", true), array('controller' => 'scenarios', 'action' => 'toggleView?customer_id=' . $SELECTED_CNN . '&view=EXTERNAL'));
    		}
        } ?>
		</div>
<!--right hand side  ends here-->

