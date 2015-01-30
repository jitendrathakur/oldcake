<?php
#-----------------------------------------------------------------#
# $Rev:: 22            $:  Revision of last commit                #
#-----------------------------------------------------------------#
?>
<?php
echo $javascript->link('/js/jquery.fancybox');
echo $javascript->link('/js/timepicker');
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.fancybox').fancybox();
    });
</script>
<script type="text/javascript">
$(function()
	{
		 $( ".date-pick" ).datepicker({"seperator":"."});
		 $(".timepicker").timepicker({ampm: false, timeFormat:'hh:mm'});
	});
	
</script>

<style type="text/css">

.ui-slider-horizontal .ui-slider-handle{
    margin-left: -0.1em;
    top: -0.3em;
}
.ui-slider .ui-slider-handle {
    cursor: default;
    height: 1.2em;
    position: absolute;
    width: 1.2em;
    z-index: 2;
}
.ui-widget .ui-widget {
    font-size: 1em;
}
.ui-slider-horizontal {
    height: 0.8em;
}
.ui-slider {
    position: relative;
    text-align: left;
}
.ui-corner-all, .ui-corner-bottom, .ui-corner-right, .ui-corner-br {
    border-bottom-right-radius: 4px;
}
.ui-corner-all, .ui-corner-bottom, .ui-corner-left, .ui-corner-bl {
    border-bottom-left-radius: 4px;
}
.ui-corner-all, .ui-corner-top, .ui-corner-right, .ui-corner-tr {
    border-top-right-radius: 4px;
}
.ui-corner-all, .ui-corner-top, .ui-corner-left, .ui-corner-tl {
    border-top-left-radius: 4px;
}
.ui-datepicker-trigger {
    float: none !important;
    margin-left: 3px;

    margin-top: 5px;
}

.submit input{
 /*height: 25px;*/
 margin: 10px 0px 0px 92px;
}
.table-content .table-right-ohne{
	
	border-right: 1px solid #cccccc !important;;
}
</style>

<div class="block top">
				<br />
				
				<?php echo $form->create('Log',array('action'=>'viewlog','id'=>'filters','type'=>'GET')); 
				#To make the filter and sort work together
				$paginator->options(array('url' => $this->passedArgs));
				#$paginator->options(array('url' => array('beforetime' => $this->passedArgs['beforetime'], 'beforedate' => $this->passedArgs['beforedate'], 'aftertime' => $this->passedArgs['aftertime'], 'afterdate' => $this->passedArgs['afterdate'])));

				
				if($userpermission!=Configure::read('access_id'))
				{
					echo $form->input('customer_id', array('type'=>'hidden','value'=>(isset($this->params['named']['customer_id'])?$this->params['named']['customer_id']:(isset($this->params['url']['customer_id'])?$this->params['url']['customer_id']:'')))); 
				}
				?>
				<?php
				$customerList = array(); 
				foreach($customer as $key => $value ){
					$customerList[$key] = $key." (".$value.")";
					
				}
				
				
				?>
				
				
				
				
				<div class="cb">
				<div id="" class="table-content">
				    <table class="table-content phonekey">
						<thead> 
							    <tr class="table-top">
								
									<!--<th class="table-column table-left-ohne" style="width:20px;">&nbsp;</th>-->
									<?php if($userpermission==Configure::read('access_id'))	{?>
									<th  class="table-column" style="width:58px;text-align: left;"><span><?php __("Customer");?></span></th>
									<?php }	?>
									<th  class="table-column"style="width:58px;text-align: left;">
									<?php if($_SESSION['APPNAME']=='Gate'){echo __("Scenario");}else{ echo __("Station");}?></th>
									<th  class="table-column"style="width:48px;text-align: left;"><?php __("User");?></th>
									<th  class="table-column"style="width:108px;text-align: left;"><?php __("Description");?></th>
									<th  class="table-column"style="width:48px;text-align: left;"><?php __("Status");?></th>
									<th  class="table-column"style="width:45px;text-align: left;"><?php __("id");?></th>
									
									<!--<th class="table-right-ohne">&nbsp;</th>-->
							    </tr>
							    <tr>
									<!--<td class="table-column table-left-ohne">&nbsp;</td>-->
									
									<?php 
									if($userpermission==Configure::read('access_id')){
										echo '<td>';
										echo $form->select('Log.customer_id', $customerList,(isset($this->params['named']['customer_id'])?$this->params['named']['customer_id']:(isset($this->params['url']['customer_id'])?$this->params['url']['customer_id']:'')),array('onchange'=>"javascript:submi_formsss('filters');", 'style'=>'width:100px;'));
										echo '</td>';
									}
									?>
									<td><?php echo $form->input('Log.affected_obj', array('label' => false, 'type'=>'text','class' => 'filter-class onclick','style'=>'width:93px;', 'value'=>(isset($this->params['named']['affected_obj'])?$this->params['named']['affected_obj']:(isset($this->params['url']['affected_obj'])?$this->params['url']['affected_obj']:'')))); ?></td>
									<td><?php echo $form->input('Log.user', array('label' => false, 'type'=>'text','class' => 'filter-class onclick','style'=>'width:93px;', 'value'=>(isset($this->params['named']['user'])?$this->params['named']['user']:(isset($this->params['url']['user'])?$this->params['url']['user']:'')))); ?></td>
									<td><?php echo $form->input('Log.log_entry', array('label' => false, 'type'=>'text','class' => 'filter-class onclick','style'=>'width:93px;', 'value'=>(isset($this->params['named']['log_entry'])?$this->params['named']['log_entry']:(isset($this->params['url']['log_entry'])?$this->params['url']['log_entry']:''))));?></td>
									<td><?php echo $form->select('Log.status', array('1'=>'Success', '0'=>'Failed'),(isset($this->params['named']['status'])?$this->params['named']['status']:(isset($this->params['url']['status'])?$this->params['url']['status']:'')),array('onchange'=>"javascript:submi_formsss('filters');")); ?></td>
									<td><?php echo $form->input('Log.id', array('label' => false, 'type'=>'text','class' => 'filter-class onclick','style'=>'width:45px;', 'value'=>(isset($this->params['named']['id'])?$this->params['named']['id']:(isset($this->params['url']['id'])?$this->params['url']['id']:''))));?></td>
									
									<!--<td class="table-right-ohne">&nbsp;</td>-->
							    </tr>
						</thead>
				    </table>
				</div>
				<div style="margin:10px;">
					<a class="maintopRelatedContentButton" id="maintopContentButton" onclick="return toggleAdvanceSearch();" href="javascript:void(0)"><?php __('Advanced Filter') ?></a>
					</div>
				
			    	<?php
			    	if (isset($advancedFlag))
			    	{
			    		?>	
			    		<div class="table-content" style="display:block">
			    		<?php
			    	
			    	}
			    	else
			    	{
			    		?>
			    		<div id="advancesearch" class="table-content" style="display:none">
			    		<?php
			    	}?>
				    <table class="table-content phonekey">
						<thead>
							    <tr class="table-top">
									<th class="table-right-ohne">&nbsp;</th>	
									
									<th colspan='2' class="table-column" style="width:88px;text-align: left;" ><?php __("After Date")?></th>		

									<th colspan='2' class="table-column" style="width:88px;text-align: left;"><?php __("Before Date")?></th>		
	
									<th class="table-right-ohne">&nbsp;</th>											
							    </tr>
							    <tr>
							    <td style="height: 10px; border: none; " class="table-column table-left-ohne">&nbsp;</td>
							    <td style="height: 10px; padding:0px 0px 0px 12px;"><?php echo __('Date', true) ?></td>
							    <td style="height: 10px;  padding:0px 0px 0px 12px;"><?php echo __('Time', true) ?></td>
							    <td style="height: 10px; padding:0px 0px 0px 12px;" ><?php echo __('Date', true) ?></td>
							    <td style="height: 10px; padding:0px 0px 0px 12px;"><?php echo __('Time', true) ?></td>
							    <td style="height: 10px; border: none" class="table-right-ohne">&nbsp;</td>
							    </tr>
							    <tr>
									<td class="table-column table-left-ohne">&nbsp;</td>
					
									<td>
									<?php #echo $form->input('Log.afterdate', array('type'=>'text','class'=>'date-pick', 'style'=>'margin:4px 4px 5px 8px;', 'label'=>false, 'div'=>false, 'value'=>(isset($this->params['named']['afterdate'])?$this->params['named']['afterdate']:(isset($this->params['url']['afterdate'])?$this->params['url']['afterdate']:''))));?>
									<?php echo $form->input('Log.afterdate', array('type'=>'text','class'=>'date-pick', 'style'=>'margin:4px 4px 5px 8px;', 'label'=>false, 'div'=>false, 'value'=>(isset($this->passedArgs['afterdate'])?$this->passedArgs['afterdate']:'')));?>
									</td>
									<td>
									<?php #echo $form->input('Log.aftertime', array('type'=>'text','class'=>'filter-class timepicker', 'style'=>'margin:4px 4px 5px 8px','label'=>false, 'value'=>(isset($this->params['named']['aftertime'])?$this->params['named']['aftertime']:(isset($this->params['url']['aftertime'])?$this->params['url']['aftertime']:'')))) ;?>
									<?php echo $form->input('Log.aftertime', array('type'=>'text','class'=>'filter-class timepicker', 'style'=>'margin:4px 4px 5px 8px','label'=>false, 'value'=>(isset($this->passedArgs['aftertime'])?$this->passedArgs['aftertime']:''))) ;?>
									</td>
									<td>
									<?php #echo $form->input('Log.beforedate', array('type'=>'text','class'=>'date-pick', 'style'=>'margin:4px 4px 5px 8px;', 'label'=>false, 'div'=>false, 'value'=>(isset($this->passedArgs['beforedate'])?$this->passedArgs['beforedate']:isset($this->params['named']['beforedate'])?$this->params['named']['beforedate']:(isset($this->params['url']['beforedate'])?$this->params['url']['beforedate']:''))));?>
									<?php echo $form->input('Log.beforedate', array('type'=>'text','class'=>'date-pick', 'style'=>'margin:4px 4px 5px 8px;', 'label'=>false, 'div'=>false, 'value'=>(isset($this->passedArgs['beforedate'])?$this->passedArgs['beforedate']:'')));?>
									</td>									
									<td>
									<?php #echo $form->input('Log.beforetime', array('type'=>'text','class'=>'filter-class timepicker', 'style'=>'margin:4px 4px 5px 8px','label'=>false, 'value'=>(isset($this->params['named']['beforetime'])?$this->params['named']['beforetime']:(isset($this->params['url']['beforetime'])?$this->params['url']['beforetime']:'')))) ;?>
									<?php echo $form->input('Log.beforetime', array('type'=>'text','class'=>'filter-class timepicker', 'style'=>'margin:4px 4px 5px 8px','label'=>false, 'value'=>(isset($this->passedArgs['beforetime'])?$this->passedArgs['beforetime']:''))) ;?>
									</td>
									<td class="table-right-ohne">&nbsp;</td>
							    </tr>
							   
						</thead>
				    </table>
				    
				    
			</div>
			<!-- ---------------------------------------------------------------------------------------------- -->
		<div class="block" style="margin: 0px;">
				<div class="button-right">
				<a href="javascript:void(null)"  onclick="javascript:submi_formsss('filters');" name="data[filter]" value="filter" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __("filter");?></a> 
				</div>
				<div class="button-right">
				<?php echo $html->link( __("Export Csv", true),  array('controller'=> 'logs', 'action'=>'export'),array('onmouseover'=>'hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
				</div>
				<div class="button-left">
				<?php 
				if($userpermission==Configure::read('access_id'))	
				{
					echo $html->link( __("Reset", true),  array('controller'=> 'logs', 'action'=>'viewlog'),array('onmouseover'=>'hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);')); 
				}
				else
				{
					echo $html->link( __("Reset", true),  array('controller'=> 'logs', 'action'=>'viewlog', 'customer_id:' . $SELECTED_CNN ),array('onmouseover'=>'hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);')); 
				
				}
				?>
				</div>
				
				<?php if($userpermission==Configure::read('access_id'))
				{?>
				<div class="button-left">
				<?php 

						echo $html->link(__('Reports', true), array('controller'=>'logs', 'action'=>'reports'), array('class'=> $selected['Reports'])); ?>
		 		
		 		</div>
		 		<?php }?>
			</div>
	    <?php
		//check $locations variable exists and is not empty
		
		
		
		
		
		
		if(isset($loginfo) && !empty($loginfo)): ?>
		<div id="" class="table-content">
		<?php echo 	$this->element('pagination/top');?>
	    <table class="table-content phonekey" style="width: 100% !important;line-height: normal !important;">
	    	
			<thead>
						<tr class="table-top">
							<!--<th class="table-column table-left-ohne" style="width:20px;">&nbsp;</th>-->
								<?php

								if($userpermission==Configure::read('access_id'))	
								{
								?>

								
								<th class="table-column <?php if(in_array('sort:customer_id',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:customer_id',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:60px;text-align: left;"><?php echo $paginator->sort(__("Customer",true), 'customer_id', $filter_options);?></th>

								<?php
								}
								if($_SESSION['APPNAME']=='Gate')
								{
									?>
									<th class="table-column <?php if(in_array('sort:affected_obj',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:affected_obj',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:60px;text-align: left;"><?php echo $paginator->sort(__("Scenario",true), 'affected_obj', $filter_options);?></th>
									<?php
																		
								}
								else
								{
									?>
									<th class="table-column <?php if(in_array('sort:affected_obj',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:affected_obj',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:60px;text-align: left;"><?php echo $paginator->sort(__("Station",true), 'affected_obj', $filter_options);?></th>
									<?php
								}
								?>
		

							<th class="table-column <?php if(in_array('sort:created',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:created',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:70px;text-align: left;"><?php echo $paginator->sort(__("Created",true), 'created', $filter_options);?></th>
							<th class="table-column <?php if(in_array('sort:user',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:user',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:60px;text-align: left;"><?php echo $paginator->sort(__("User",true), 'user', $filter_options);?></th>
							<th class="table-column <?php if(in_array('sort:log_entry',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:log_entry',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:180px;text-align: left;"><?php echo $paginator->sort(__("Description",true), 'log_entry', $filter_options);?></th>
							<!--<th class="table-column <?php if(in_array('sort:status',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:status',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:40px;text-align: left;"><?php echo $paginator->sort(__("Status",true), 'status', $filter_options);?></th>-->
							<!--<th></th>-->
						</tr>
						
			</thead>
		<?php //echo $this->element('pagination/top'); ?>
	        <tbody>
	        	<?php
				// initialise a counter for striping the table
				$count = 0;
	
				// loop through and display format
				foreach($loginfo as $log):
					// stripes the table by adding a class to every other row
					$class = ( ($count % 2) ? " class='altrow'": '' );
					// increment count
					$count++;
				
				
				
				if($userpermission==Configure::read('access_id'))	
				{
				?>
	            	<tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">
	             	<!--<td class="table-left">&nbsp;</td>-->
	            	<td> <?php echo $log['Log']['customer_id'] ?></td>
	            	<td> <?php echo $log['Log']['affected_obj'] ?></td>
	                <td style="width:110px;">
                    <?php
                    $formatted_date = date('d.m.Y H:i:s', strtotime($log['Log']['created']));
                    preg_match("/^(.*) (.*)/", $formatted_date, $matches);
                    if ($matches[0]) {
                        #$datetime2line = $matches[1] . '<br>' . $matches[2];
                        echo $matches[1];
                        echo ' ';
                        echo $matches[2];
                    } else {
                        echo $log['Log']['created'];
                    }
                    ?>
                    </td>
	                <td style="width:50px;">
	                <?php echo $log['Log']['user'] ?>
	           		</td>
	                 <td class="table-right-ohne tooltip" style="vertical-align: middle;"> 
					<?php  $log['Log']['modification_status']?$linkColor='color:':$linkColor='color:#AC1917';
					     //echo $linkColor;
					
					?>
					
					<?php if (($log['Log']['info'] != '') && (substr($log['Log']['log_entry'], 0, 6) != 'Report')) {$log['Log']['log_entry'] .= ' (C)';}?>
					 <?php echo $html->link($log['Log']['log_entry'], array('controller'=> 'logs', 'action'=>'logdetails',$log['Log']['id']), array('class' => "fancybox fancybox.ajax",'style'=>$linkColor)); ?>
					 	
						
						<div>
							<div class="fl"><span><?php echo $html->link('', '',array('onclick'=>'javascript:return logview(\''.$log['Log']['id'].'\');')) ?></span>
								<p><?php echo 'ID :' . $log['Log']['id'];
								 if ($log['Log']['info'] != '') echo ' - ' . $log['Log']['info'] ?></p>
								
							</div>
					 </td>
	                 
	                 <!--<td><?php echo $log['Log']['modification_status']?'Success':'Failed'?></td>-->
	          		<!-- <td class="table-right-ohne tooltip" style="background: url(<?php echo $this->webroot; ?>/images/assets/icons/16px/045_information_02_cmyk.gif) no-repeat 2px 2px;">-->
					 <!--<td class="table-right-ohne tooltip" >
					 <a href="javascript:void();">...</a>
	          		 	<div>
							<div class="fl"><span><?php echo $html->link('', '',array('onclick'=>'javascript:return logview(\''.$log['Log']['id'].'\');')) ?></span>
								<p><?php echo 'ID :' . $log['Log']['id'] . ' - ' . $log['Log']['info'] ?></p>
							</div>
						</div>
	          		 </td>-->
	           </tr>
	           <?php 
				}
				else
				{
				?>
					<tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">
	             	<td class="table-left">&nbsp;</td>
	            	<td> <?php echo $log['Log']['affected_obj'];?></td>
	            	<td style="width:70px;">
	            	<?php
	            	$formatted_date = date('d.m.Y H:i:s',strtotime($log['Log']['created']));
	                preg_match("/^(.*) (.*)/", $formatted_date, $matches);
					if ($matches[0]) 
					{
						echo "$matches[1]<br>";
						echo "$matches[2]";
					}
					else
					{
						echo $log['Log']['created'];
					}
					?>
					</td>
	                <td style="width:50px;"><?php echo $log['Log']['user']; ?></td>
	                <td><?php echo $log['Log']['log_entry']; ?></td>
	                <td><?php echo $log['Log']['modification_status']?'success':'Failed'?></td>
	          		<td class="table-right-ohne tooltip" style="background: url(<?php echo $this->webroot; ?>/images/assets/icons/16px/045_information_02_cmyk.gif) no-repeat 2px 2px;">
	          		 	<div>
							<div class="fl"><span><?php echo $html->link('', '',array('onclick'=>'javascript:return logview(\''.$log['Log']['id'].'\');')) ?></span>
								<p><?php echo 'ID :' . $log['Log']['id'] . ' - ' . $log['Log']['info'] ?></p>
							</div>
						</div>
	          		 </td>
					
				<?php
				}
				endforeach;
				?>
	        </tbody>
			</table>
	    <?php echo $this->element('pagination/bottom');?>
			</div>
		
				<?php
				else:
					__("No modifications in DB");
				endif;
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
                 <h3><?php __('logList') ?></h3>
                 <p>
                  <?php __('logList_blurb') ?>
                 </p>
				 <div id="shortcont">
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('fullcont')"  title=""><?php echo __('moreStart') ?></a>             
            </div>
            <div style="display:none;" id="fullcont_type"  >
               <p  ><?php echo __('logList_helpText') ?></p>
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('shortcont')"  title=""><?php echo __('moreEnd') ?></a>      
			</div>
        </div>

<!--INTERNAL USER OPTIONS -->
        <?php if($userpermission==Configure::read('access_id'))
        {?>
                <div class="box info">
                <h3><?php __("Internal User");?></h3>
                <p><?php __("Customer View:");?></p>
                <p><?php echo $selected_customer; ?></p>

                </div>
	<?php } ?>

	</div>
</div>
</div>


<script type="text/javascript">
function toggleAdvanceSearch(){
		//$("#advancesearch").show
		if(document.getElementById('advancesearch').style.display=='none'){
			document.getElementById('advancesearch').style.display='block';
		}else{
			document.getElementById('advancesearch').style.display='none';
		}

	}
	
function validate_form()
{
	//alert('testing');
	var dateval = $('#ExecutionTargetDate').val();
	var timeval = $('#ExecutionTime').val();
	var options = $('#ExecutionOperation').val();
	if(dateval==''){
	$('#error_messages').show();
	$('#error_messages').html('Please choose schedule date!');
	return false;
	}else if(!validate_pastdate(dateval)){
	
		$('#error_messages').show();
		$('#error_messages').html('Please enter future or current date only!');
		return false;
	
	}else if(timeval ==''){
			$('#error_messages').show();
			$('#error_messages').html('Please enter the time!');
		return false;
	}else if(options==''){
		$('#error_messages').show();
		$('#error_messages').html('Please choose operation!');
	return false;
	}

}

function validate_pastdate(dateCheck)
{
		var splitDate = dateCheck.split(".");
		var refDate = new Date(splitDate[2]+" "+splitDate[1]+" "+splitDate[0]);
		today = new Date();
		today.setHours(0,0,0,0)
		if (refDate < today)
		{
			return false;
		}else{
			return true;
		}
}
	
function submi_formsss(form_id)
{	
	$('#'+form_id).submit();
} 

<!--right hand side  ends here-->
</script>

