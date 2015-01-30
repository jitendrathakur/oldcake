    <!--[if IE]>
            <meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1">
    <![endif]-->  
	<?php 

echo $javascript->link('/js/jquery.fancybox');
?>
<style>
#content .block ul {
    margin-top: 3px!important;
    padding: 0 7px 0 1px;
}

.table-menu-popup {
    margin-left: 10px !important;
    margin-top: 0px !important;
    padding: 0;
    position: absolute;
}
#mcTooltipWrapper {
	display:none;
}
.t_Tooltip{
	display:none !important;
}
.button-right li a:hover, .button-right-hover li a:hover {
 	float: none !important; 
 }

</style>
<?php
$user_agent = $_SERVER['HTTP_USER_AGENT']; 

if (preg_match('/MSIE/i', $user_agent)) { ?>
<style>
	.button-right {
	height: 21px !important;
	
}

.button-right a, .button-right a:active, .button-right a:link, .button-right a:visited {
	
	padding: 1px 20px 5.5px 10px!important;
	
}
</style>
<?php } else { ?>
<style>
	.button-right {
	height: 22px !important;
	
}
</style>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
	
	function submenuactivity(obj, action){	
					
		if(action==1){
			$('#table-popup').show();
			jQuery('#button3').attr("class","showhighlight_buttonleft");	
			jQuery('#button3').removeAttr("onmouseout","hoverButtonRight(this)");
			jQuery('#updateOdsentry').removeAttr("class");	
		    jQuery('#updateOdsentry').attr("class","button-right-hover");
		} else if(action==0){
			$('#table-popup').hide();

		}		

	}
	 $('.tooltip').mouseout(function(n){
      $(this).find("p:first").attr("style", "display:none;");  
    }); 
  
     $('.tooltip').mouseover(function(n){
      $(this).find("p").attr("style", "display:inline;");  
    });	
	
	
	
	    function toggleShowHistory() {
        //$("#advancesearch").show
        if (document.getElementById('advancesearch').style.display == 'none') {
            document.getElementById('advancesearch').style.display = 'block';
        } else {
            document.getElementById('advancesearch').style.display = 'none';
        }
    }

	
</script>

	
	<div class="block top">
	<div id="overlay-sucess" class="notification first hide" style="width: 100%" >
    
    <div class="ok">
        <div class="message">
		
            
        </div>
    </div>
</div>


<?php 
$success = $_SESSION['success'];

if((isset($success)) && $success){?>
	
		<div class="notification first" style="width: 534px" >
		
			<div class="ok">
				<div class="message">
					<?php 
					
					if(isset($_SESSION['delete_group'])){
						echo __($_SESSION['delete_group']);
						 unset($_SESSION['delete_group']);
					}
					
					
					
					echo __($success);
					
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
							__("There was a problem in applying the changes.");
					?>
				</div>
			</div>
		</div>
		
	<?php }
	unset($_SESSION['success']);
	
	?>


	<a id="select_station" style="visibility: hidden;" class="fancybox fancybox.ajax" href="">Add Member</a>
	<br>
	
	    <?php 
	    
	    $activationusers = Configure::read('activationusers');
	    
		 $paginator->options(array('url' => $this->passedArgs));
		 
	    echo $form->create('Group',array('action'=>'/pickupgroups','id'=>'filters','type'=>'GET'));
	    echo $form->input('Group.customer_id', array('type'=>'hidden','value'=>$SELECTED_CNN)); 
	   ?>
	    <div class="cb">
			<div id="" class="table-content">
				    <table class="table-content phonekey" width="98%">
						<thead>
							    <tr class="table-top">
									
									<th  class="table-column"style="width:176px;text-align: left;">&nbsp;<?php __("groupName");?></th>
									<th  class="table-column"style="width:174px;text-align: left;">&nbsp;<?php __("groupLocation");?></th>
									<th  class="table-column"style="width:116x;text-align: left;">&nbsp;<?php __("groupDescription");?></th>
									
							    </tr>
						
							    <tr>
									
									<td><?php echo $form->input('name', array('label' => false, 'type'=>'text','class' => 'filter-class onclick', 'value'=>(isset($this->params['named']['name'])?$this->params['named']['name']:(isset($this->params['url']['name'])?$this->params['url']['name']:'')))); ?></td>
									<td>
									
								<?php 
								//echo "<pre>";
								//print_r($locationList);
								
								echo $form->select('location_id',$locationList,(isset($this->params['named']['location_id'])?$this->params['named']['location_id']:(isset($this->params['url']['location_id'])?$this->params['url']['location_id']:'')),array('style'=>'width:135px;','onchange'=>"javascript:submi_form('filters');")); ?>	
						           </td>
									<td><?php echo $form->input('desc', array('label' => false, 'type'=>'text','class' => 'filter-class onclick', 'value'=>(isset($this->params['named']['desc'])?$this->params['named']['desc']:(isset($this->params['url']['desc'])?$this->params['url']['desc']:'')))); ?></td>
									
							    </tr>
						</thead>
				    </table>
                    
			</div>
			
			<div class="block" style="margin: 0px;">

				<div class="button-left">
					<?php echo $html->link( __("reset", true),  array('controller'=> 'groups', 'action'=>'pickupgroups', 'customer_id:'.$SELECTED_CNN),array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);')); ?>
                </div>

                <div class="button-right">
		            <?php echo $html->link( __("Export Csv", true),  array('controller'=> 'groups', 'action'=>'export'),array('onmouseover'=>'hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
		        </div>

				<div class="button-right">
					<a href="javascript:void(null)"  onclick="javascript:submi_form('filters');" name="data[filter]" value="filter" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __("filter");?></a>
				</div>
            </div>
			
            <div style="display:block">					
                <h4 ><?php echo __('Advance Filter', true); ?>
                 <a class="maintopRelatedContentButton" id="maintopContentButton" onclick="return toggleShowHistory();" href="javascript:void(0)" style="float:right;">
                        
                    </a></h4> 
            </div>
             <?php 
                if (isset($showHistory)) 
                 { 
             ?>	
                <div id="advancesearch"  class="table-content phonekey" style="display:none">
             <?php } else {
                    ?>
                    <div id="advancesearch"  class="table-content phonekey"  style="display:block">

                    <?php }
                    ?>
                        <div class="form-box">
                           

                            <div class="form-left">
                                <?php
                               
                                
                                echo '<div style="width:100px; float: left">' . __('memberDnFilter', true) . '</div>';
                                echo $form->select('station_id',$stationList,(isset($this->params['named']['station_id'])?$this->params['named']['station_id']:(isset($this->params['url']['station_id'])?$this->params['url']['station_id']:'')),array('style'=>'width:135px;','onchange'=>"javascript:submi_form('filters');",'default'=>$group['Stationkey']['station_id']));
                                
								
                                ?>		

                            </div>
                             <div class="form-right">
                                <p></p>
                            </div>
        
</div></div>
            <br/> <br/>
			
			
               <div style="height: 42px;">
 				<div class="button-right" id="updateOdsentry" >
				<?php 
									echo $html->link( __("Add Group", true),array('controller'=>'groups', 'action'=>'addcpugroup/grouptype:cpu&customer_id='.$SELECTED_CNN), array('class'=>"fancybox fancybox.ajax",'onmouseover'=>"hoverButtonRight(this)" ,'onmouseout'=>"outButtonRight(this)"))	 ?>

				</div>
				  </div>    
            <br/>
	
	    <?php
	
		
		// check $locations variable exists and is not empty
		if(isset($groups) && !empty($groups)) :
		?>
		<!--Showing Page-->   <?php //echo $paginator->counter(); ?>
		
		<?php //echo $this->element('pagination/top'); ?>
	    <div id="" class="table-content">
		<table class="phonekey" width="98%">
	    	<?php
			echo $this->element('pagination/top');
			?>
	    	<thead>
	        	<tr class="table-top">
	        	<!--<th class="table-column table-left-ohne">&nbsp;</th>-->
				
		 <?php
			
		   $url = $this->params['named']['direction'];
		   $url2 = $this->params['url']['url'];		   
		   
			if($url=="" && strlen($url2)>6 ){ 
				#$filter_sort = array('0'=>'groups','1'=>'index','2'=>'Page:1','3'=>'customer_id:'.$SELECTED_CNN,'4'=>'sort:name','5'=>'direction:desc');
				 $urlfilter="groups/pickupgroups/page:1/customer_id:$SELECTED_CNN/sort:name/direction:desc";
				 
				 //$filter_options
			?>
			
				<th class="table-column <?php echo 'sortlink_asc';?>" style="width:152px;text-align: left;"> <a id="sortlink" href="<?php echo Configure::read('base_url').$urlfilter; ?>"><?php echo __("groupName",true); ?></a>
				</th>				
			<?php }else{ ?>

			<th class="table-column <?php if(in_array('sort:name',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:name',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:152px;text-align: left;"><?php echo $paginator->sort(__("groupName",true), 'name',$filter_options);?></th>
			<?php } ?>
			
			<th class="table-column <?php if(in_array('sort:Location.name',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:Location.name',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:152px;text-align: left;">
			<?php echo $paginator->sort(__("groupLocation",true), 'Location.name',$filter_options);?>
				
			</th>
			

			<th class="table-column <?php if(in_array('sort:desc',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:desc',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:90px;text-align: left;"><?php echo $paginator->sort(__("groupDescription",true), 'desc',$filter_options);?></th>
			
			
			
			
			<th class="table-column "style="width:30px;text-align: left;padding-top:2px;"><?php echo __("#mems",true);?></th>
			
			
			
			
			<th class="table-right-ohne" style="border-right: 1px solid #D1D1D1!important;">&nbsp;</th>
			
	            </tr>
	        </thead>
		<?php //echo $this->element('pagination/top'); ?>
	        <tbody>
	        	<?php
				// initialise a counter for striping the table
				$count = 0;
				$groupStatus = Configure :: read('groupStatus');
				#echo "<pre>"; print_r($groupMemCount);
				// loop through and display format
				#echo "<pre>";print_r($groups);
				foreach($groups as $group):
				#echo "<pre>";print_r($group);
				
					// stripes the table by adding a class to every other row
					$class = ( ($count % 2) ? " class='altrow'": '' );
					// increment count
					$count++;
				?>
	            <tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">
	             	<!--<td class="table-left">&nbsp;</td>-->

	            		<td class="tooltip">
							<div>
								<div class="fl"><span style="cursor:default" ><?php
								
								if($group['Group']['type'] == 'MADN')
								{
									$ident = $madn_displaynames[$group['Stationkey']['id']];
									#$ident = $group['Stationkey']['id'];
								}
								else 
								{
									$ident = $group['Group']['name'];
								}
								if(strlen(strval($ident) > 15))
								{
									$link = substr($ident, 0, 18) . '..';
								}
								else {
									$link = $ident;
								}
								 echo $html->link($link,array('controller'=>'groups', 'action'=>'edit/group_id:'.$group['Group']['id']));  ?></span>
                                <?php 
                                if(strlen($ident)>18) { ?>
								<p><?php  echo $html->link($group['Group']['name'],array('controller'=>'groups', 'action'=>'edit/group_id:'.$group['Group']['id'])); ?></p>
                                <?php 
								}
								
								?>
								</div>
							</div>
					  </td>
	                 <td>
	                		<?php 
							
							echo __($group['Location']['name']);
	                		
	                		#echo $html->link(__($group['Group']['type'], true),array('controller'=>'stations', 'action'=>'edit', $group['Group']['id'])); 
	                		?>
	                	</td>
					  <td class="sublist-align wid-217px tooltip" style="border-left: 1px solid #D1D1D1!important;">
							<div>
								<div class="fl"><span style="cursor:default" ><?php echo substr($group['Group']['desc'], 0, 15);?> <?php if(strlen($group['Group']['desc'])>15) { echo  '..' ; } ?></span>
                                <?php if(strlen($group['Group']['desc'])>15) { ?>
								<p><?php echo $html->link($group['Group']['desc'],array('controller'=>'groups', 'action'=>'edit/group_id:'.$group['Group']['id']));
	           			?></p>
                        <?php } ?>
								</div>
							</div>
						</td>
	                	<td>
	                		<?php 
	                		#echo $dn['Dns']['function'];
	                		if(($group['Group']['type'] == 'MADN') || ($group['Group']['type'] == 'madn'))
	                		{
	                			
								echo $groupMem = $groupMemCount[$group['Group']['identifier']];
								?>
								<input type="hidden" name="memcount" id="memcount" value="<?php echo $groupMem; ?>">
								<?php
	                			
	                		}
	                		else {
								echo $groupMem = $groupMemCount[$group['Group']['id']];
								
								?>
								<input type="hidden" name="memcount" id="memcount" value="<?php echo $groupMem; ?>">
								<?php
							}

	                		
	                		?>
							
	                	</td>

	                		<td class="table-right-ohne" style="background: url(<?php echo $this->webroot; ?>/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat 3px 5px;border-right: 1px solid #D1D1D1!important;"   onmouseover="this.className='table-right-over';" onmouseout="this.className='table-right';">
                    			<div class="table-menu">
                    			<div class="table-menu-popup" style="z-index: 1">
                    				<ul>
        
									<li class="edit">
									<?php echo $html->link(__('groupEditMenu', true),  array('controller'=> 'groups', 'action'=>'edit', 'group_id:'.$group['Group']['id']));?>
									  
									</li>
									<?php 
									//if($groupMemCount[$group['Group']['identifier']] < 1)
									if($groupMem<1)
									
									{
									?>									
									
									<li class="delete">
									<?php echo $html->link(__('groupDeleteMenu', true),  array('controller'=> 'groups', 'action'=>'deleteGroup', 'group_id:'.$group['Group']['id']),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete this ?');"));?>
									  
									</li>
									<?php
									}
									?>
									
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
        	   <h3><?php __('cpuGroupList') ?></h3>
        	   <p><?php __('cpuGroupList_blurb') ?></p>
        	<div id="shortcont">
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('fullcont')"  title=""><?php echo __('moreStart') ?></a>             
            </div>
            <div style="display:none;" id="fullcont_type"  >
               <p  ><?php echo __('cpuGroupList_helpText') ?></p>
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('shortcont')"  title=""><?php echo __('moreEnd') ?></a>      
			</div>
        </div>

<!--INTERNAL USER OPTIONS -->
        <?php if($userpermission==Configure::read('access_id'))
        {?>
                <div class="box info">
                <h3><?php __("Internal User");?></h3>
                <p><?php __("customerName");?><?php echo $selected_customer; ?></p>
                <p><?php __("customerId");?><?php echo $SELECTED_CNN; ?></p>

                </div>
	<?php } ?>
<input type="hidden" name="locationName" id="locationName" value=""/>
		</div>
<!--right hand side  ends here-->

