<?php
echo $javascript->link('/js/jquery.fancybox');
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
</script>	
<script>
function set_visi(val)
{
	if(val=='fullcont') {
			$("#fullcont_type").slideDown();
			$("#shortcont").slideUp();
	}
	else {
			$("#fullcont_type").slideUp();
			$("#shortcont").slideDown();
	}
}
</script>
<?php    
$activationusers = Configure::read('activationusers');

?>
<?php if(preg_match('/(?i)msie [1-8]/',$_SERVER['HTTP_USER_AGENT'])){// if IE<=8 ?>
  <div class="notification first" style="width: 534px" >

			<div class="warning">
				<div class="message">
					<?php echo __("Browser version is not supported", true); ?>
				</div>
			</div>
		</div>
<?php } ?>
	<!--$Rev:: 22            $:  Revision of last commit-->
	<div class="block top">
	<?php 
	#For pagination reasons to handle sort and filter
	#$paginator->options(array('url' => $this->passedArgs));
	$paginator->options(array('url' => array('cid' => $this->passedArgs['cid'], 'bsk' => $this->passedArgs['bsk'], 'name' => $this->passedArgs['name'])));   
	echo $form->create('Customer',array('action'=>'index','id'=>'filters', 'type'=>'GET')); ?>
	<br>
		<div class="cb">
		<?php
		#CBM RE2 Link to logs page.
		if($userpermission==Configure::read('access_id')){
		}?>
			<!--CBM START HERE -->
			<div id="" class="table-content">
				<table class="table-content phonekey">
					<thead>
						<tr class="table-top">
							<!--<th class="table-column table-left-ohne" style="width:20px;">&nbsp;</th>-->
							<!--273-->
							<th  class="table-column"style="width:291px;text-align: left;">&nbsp;<?php __("Name");?></th>
							<th  class="table-column" style="width:59px;text-align: left;">&nbsp;<?php __("CNN");?></th>
							<th  class="table-column" style="width:63px;text-align: left;">&nbsp;<?php __("Type");?></th>
							<th  class="table-column" style="width:117px;text-align: left;">&nbsp;<?php __("BSK");?></th>
							<!--<th class="table-right-ohne" style=" border-right: 1px solid #D1D1D1!important;">&nbsp;</th>-->
						</tr>
						<tr>
							<!--<td class="table-column table-left-ohne">&nbsp;</td>-->
							<td><?php echo $form->input('name', array('label' => false, 'type'=>'text','class' => 'filter-class onclick','style'=>'width:278px;', 'value'=>(isset($this->params['named']['name'])?$this->params['named']['name']:(isset($this->params['url']['name'])?$this->params['url']['name']:'')))); ?></td>
							<td><?php echo $form->input('cid',  array('label' => false,'type'=>'text','class' => 'filter-class onclick', 'style'=>'width:45px;', 'value'=>(isset($this->params['named']['cid'])?$this->params['named']['cid']:(isset($this->params['url']['cid'])?$this->params['url']['cid']:'')))); ?></td>
							<td><?php echo $form->select('type', $customerTypes,(isset($this->params['named']['type'])?$this->params['named']['type']:(isset($this->params['url']['type'])?$this->params['url']['type']:'')),array('onchange'=>"javascript:submi_formsss('filters');",'style'=>'width:55px;')); ?></td>
							<td><?php echo $form->input('bsk',  array('label' => false,'type'=>'text','class' => 'filter-class onclick', 'style'=>'width:65px;', 'value'=>(isset($this->params['named']['bsk'])?$this->params['named']['bsk']:(isset($this->params['url']['bsk'])?$this->params['url']['bsk']:'')))); ?></td>
							<!--<td class="table-right-ohne" style=" border-right: 1px solid #D1D1D1!important;">&nbsp;</td>-->
						</tr>
					</thead>
					<tbody>
				</table>
			</div>
			
			<div class="block" style="margin: 0px;">
				<div class="button-right">
					<?php echo $html->link( __("Export Csv", true),  array('controller'=> 'customers', 'action'=>'export'),array('onmouseover'=>'hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
				</div>
				<div class="button-right">
					<a href="javascript:void(null)"  onclick="javascript:submi_form('filters');" name="data[filter]" value="filter" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __("filter");?></a>
				</div>
				<div class="button-left">
					<?php echo $html->link( __("reset", true),  array('controller'=> 'customers', 'action'=>'index'),array('onmouseover'=>'hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);')); ?>
				</div>
            </div>
		<!--CBM END HERE -->
		<!--CBM START HERE -->
			<div id="" class="table-content">
				<?php echo $this->element('pagination/top'); ?>
				<table class="table-content phonekey">
					<thead>
						<tr class="table-top">
							<!--<th class="table-column table-left-ohne" style="width:20px;">&nbsp;</th>-->
							<th  class="table-column <?php if(in_array('sort:name',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:name',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?>"style="width:338px;text-align: left;"><?php echo $paginator->sort(__("Name",true), 'name', $filter_options);?></th>
							<th  class="table-column <?php if(in_array('sort:id',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:id',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?>" style="width:63px;text-align: left;"><?php echo $paginator->sort(__("CNN",true), 'id', $filter_options);?></th>
							<th  class="table-column <?php if(in_array('sort:type',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:type',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?>" style="width:63px;text-align: left;"><?php echo $paginator->sort(__("Type",true), 'type', $filter_options);?></th>
							<th  class="table-column <?php if(in_array('sort:bsk',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:bsk',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?>" style="width:80px;text-align: left;"><?php echo $paginator->sort(__("BSK",true), 'bsk', $filter_options);?></th>
							<th  class="table-column table-right-ohne"></th>
							<th class="table-right-ohne" style=" border-right: 1px solid #D1D1D1!important;">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
		<!--CBM END HERE -->
	        		<?php
	            		// initialise a counter for striping the table
	            		$count = 0;
	
	            		// loop through and display format
	            		foreach($customers as $customer):
	                    		// stripes the table by adding a class to every other row
	                    		$class = ( ($count % 2) ? " class='altrow'": '' );
	                    		// increment count
	                    		$count++;
	            		?>
		        		<tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">
		        		<!--<td class="table-left">&nbsp;</td>-->
		        		<!-- <td><?php echo $html->link( __($customer['Customer']['name'], true), array('controller'=> 'dns', 'action'=>'viewdns', 'customer_id:'.$customer['Customer']['id'])); ?></td>-->
		        		     <td><?php echo $html->link( __($customer['Customer']['name'], true), array('controller'=> 'customers', 'action'=>'edit', 'customer_id:' . $customer['Customer']['id'])); ?></td>
						<!-- <td><?php echo $html->link($customer['Customer']['id'],  array('controller'=> 'customers', 'action'=>'edit',  'customer_id:' . $customer['Customer']['id'])); ?></td>
  						     <td><?php echo $html->link($customer['Customer']['type'],  array('controller'=> 'customers', 'action'=>'edit',  'customer_id:' . $customer['Customer']['id'])); ?></td>
						     <td><?php echo $html->link($customer['Customer']['bsk'],  array('controller'=> 'customers', 'action'=>'edit',  'customer_id:' . $customer['Customer']['id'])); ?></td>
                   		-->
                   		<td><?php echo $customer['Customer']['id'] ?></td>
						<td><?php echo $customer['Customer']['type'] ?></td>
						<td ><?php echo $customer['Customer']['bsk']?></td>
						<?php $custinfo = __('more information',true);?>
						 <td class="table-right-ohne	 tooltip" >
	          		 	<div>
							<div class="fl">
								<?php
						 if($customer['Customer']['id']=="AAAA"){ ?>
						<span><a href="javascript:;" onclick="Tip(' <?php echo __('customer_aaa');?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a></span>
								<?php	} else { ?>						
							<span><a href="javascript:;" onclick="Tip(' <?php echo __('moh_id').': '. $customer['Customer']['moh_id']; ?><br/><?php echo __('presentation_group').': '. $customer['Customer']['presentation_group']; ?><br/><?php echo __('customer_group').': '. $customer['Customer']['customer_group']; ?><br/><?php echo __('onDemand').': '. $customer['Customer']['onDemand']; ?><br/><?php echo __('SLA').': '. $customer['Customer']['SLA']; ?><br/> <?php echo __('CTI').': '. $customer['Customer']['CTI']; ?><br/><?php echo __('NSC').': '. $customer['Customer']['NSC'] ?><br/><?php echo __('ONB').': '. $customer['Customer']['ONB']?><br/><?php echo __('CD').': '. $customer['Customer']['CD']?><br/><?php echo __('OC').': '. $customer['Customer']['OC']?><br/><?php echo __('Info1').': '. $customer['Customer']['Info1']?><br/><?php echo __('Info2').': '. $customer['Customer']['Info2']?><br/><?php echo __('Info3').': '. $customer['Customer']['Info3']?><br/><?php echo __('cicm').': '. $customer['Customer']['cicm']?><br/><?php echo __('free_ports').': '. $customer['Customer']['free_ports']?><br/><?php echo __('netcgid').': '. $customer['Customer']['netcgid']?><br/> <?php echo __('adnumid').': '. $customer['Customer']['adnumid']?><br/><?php echo __('netnameid').': '. $customer['Customer']['netnameid']?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a></span>
				<?php } ?>				
								<!-- 
								<p><?php echo __("click for more info", true); ?></p>
								-->
							</div>
						</div>
	          		 </td>
                    		<td class="table-right-ohne" style="background: url(<?php echo $this->webroot; ?>/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat 2px 2px; border-right: 1px solid #D1D1D1!important;" onmouseover="this.className='table-right-over';" onmouseout="this.className='table-right';"> 
                    	<div class="table-menu">
                       <div class="table-menu-popup">
                       <?php 
                       #$counts = $this->requestAction('customers/counts/' . $customer['Customer']['id']);
                       ?>
                         <ul>
                           <li class="home" ><?php echo $html->link( __("customerHome", true), array('controller'=> 'customers', 'action'=>'edit', 'customer_id:'.$customer['Customer']['id'])); ?></li>
						   
						   <?php
						  
						    if($activationusers[$_SESSION['ACCOUNTNAME']] == 'RE3'){ ?>
						  <li class="edit" ><?php echo $html->link( __("Edit Customer", true), array('controller'=> 'customers', 'action'=>'customeredit', 'customer_id:'.$customer['Customer']['id']), array('class' => " fancybox fancybox.ajax")); ?></li>
						  <?php }  ?>
						  
                           <li class="dial" ><?php echo $html->link( __("View DN List", true), array('controller'=> 'dns', 'action'=>'viewdns', 'customer_id:'.$customer['Customer']['id'])); ?></li>
                           <?php if($mCounts[$customer['Customer']['id']]['stationcount']  > 0){ ?>
                           <li class="last handset" ><?php echo $html->link(__("View Station List", true), array('controller'=> 'stations', 'action'=>'index', $customer['Customer']['id'])); ?></li>
                           <?php } ?>
                           <?php if($mCounts[$customer['Customer']['id']]['type'] == 'Phone'){ ?>
                           <li class="last group" ><?php echo $html->link(__("View pickupGroup List", true), array('controller'=> 'groups', 'action'=>'pickupgroups/customer_id:'. $customer['Customer']['id'])); ?></li>
                           <li class="last group" ><?php echo $html->link(__("View numberGroup List", true), array('controller'=> 'groups', 'action'=>'numbergroups/customer_id:'. $customer['Customer']['id'])); ?></li>
                           <?php } ?>
                           <li class="location" ><?php echo $html->link( __("View Location List", true), array('controller'=> 'locations', 'action'=>'index', $customer['Customer']['id'])); ?></li>
                           <?php if($mCounts[$customer['Customer']['id']]['mediatrixcount'] > 0){ ?>
                           <li class="last mediatrix" ><?php echo $html->link(__("View Mediatrix List", true), array('controller'=> 'mediatrixes', 'action'=>'index/customer_id:' . $customer['Customer']['id'])); ?></li>
                         	<?php } ?>
                         	<?php if($mCounts[$customer['Customer']['id']]['onDemand'] > 0){ ?>
                         	<li class="ods" ><?php echo $html->link( __("View ODS List", true), array('controller'=> 'scenarios', 'action'=>'index', 'customer_id:'.$customer['Customer']['id'])); ?></li>
                           <?php } ?>
                           <?php if($mCounts[$customer['Customer']['id']]['trunkcount'] > 0){ ?>
                         	<li class="trunk" ><?php echo $html->link( __("View Trunk List", true), array('controller'=> 'trunks', 'action'=>'index', $customer['Customer']['id'])); ?></li>
                           <?php } ?>
                         </ul>
                      </div>
                     </div>
                   	</td>		
		        	</tr>
	        		<?php endforeach; ?>				
					</tbody>
				</table>
			</div>
			</div>
	<?php echo $form->end(); ?>
	<?php echo $this->element('pagination/bottom'); ?>
	</div>
</div>
                <!--right hand side starts from here-->
<div id="related-content">
	<div class="box start link">
        	<a href="http://www.swisscom.ch/<?php __('corporatebusiness') ?>" target="_blank">
		    	<?php __('Home Swisscom') ?>
            </a>
    </div>
         <div class="box">
        	   <h3><?php __('customerList') ?></h3>
        	   <p><?php __('customerList_blurb') ?></p>
			     <span style="font-weight: normal;text-decoration: none !impotant;" >
               <a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Self_Admin.html"; ?>" style="cursor:pointer"  target="_blank"  title="VoIP_Self_Admin video"><?php echo __('VoIP_Self_Admin video') ?></a>             
            </span>
			   
        	<div id="shortcont">
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('fullcont')"  title=""><?php echo __('moreStart') ?></a>             
            </div>
            <div style="display:none;" id="fullcont_type"  >
               <p  ><?php echo __('customerList_helpText') ?></p>
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('shortcont')"  title=""><?php echo __('moreEnd') ?></a>      
			</div>
          </div>

         <div class="box call-to-action">
			<div class="info info-warning`	" style="z-index: 2">
				<a href="" id="warningNotification">&nbsp;</a></div><h3><?php __("notifications");?></h3>
				<!--<p><?php __("InWork Objects");?>.</p>-->
			<div>
			<ul>
				<?php echo $this->element('right_notifications',array('SELECT_CUSTOMER' => $SELECTED_CNN)); ?>
            </ul>	
			</div>
		</div>
		<div class="box">
        	   <h3><?php __('usageStatistics') ?></h3>
        	   <p><?php __('usageStatistics_blurb') ?></p>
			     
			   
        	<div id="shortcont">
               <?php echo $html->link( __("usageStatistics", true), array('controller'=> 'logs', 'action'=>'reports')); ?>             
            </div>
            
          </div>
		
</div>
<script>
<!--ight hand side  ends here-->
function submi_formsss(form_id)
{	
	$('#'+form_id).submit();
} 

<!--right hand side  ends here-->
</script>
