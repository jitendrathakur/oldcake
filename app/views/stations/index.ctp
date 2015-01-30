
<!-- <script type="text/javascript" src="<?php echo Configure::read('base_url');?>js/jquery.ie-select-width.js"></script> -->
<?php
#echo $javascript->link('/js/jquery-1.10.1.min'); 
echo $javascript->link('/js/jquery.fancybox');
?>
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
<script type="text/javascript">
	$(document).ready(function() {
		//triming filter
		
		$("input:text").change(function() { 
			$(this).val($(this).val().replace(/\s/g,""));
			$(this).val($.trim($(this).val()));
		 } );	
  	});   
	
	function initStationId(stationID){
		var stationID =$(stationID).attr('name');
		$('#clickerId4').attr('onclick','deleteStation('+stationID+')');
	}
	function deleteStation(stationID){
		window.location= "<?php echo Configure::read('base_url');?>stations/deleteStation/"+stationID;
		
		
	}
	
</script>
<script type="text/javascript">

if(browserCheck()!="MSIE"){

$(function ()
{
    // Set the width via the plugin.
  /*  $('select#fixed-select-no-css').ieSelectWidth({
        width : 130,
        containerClassName : 'select-container',
        overlayClassName : 'select-overlay'
    });
	*/
});

}
</script>
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
</script>


<?php
/**
* 
* @Start delete station  Confirmation Overlay 
* 
*/
?>

 						
<div>		

	<div id="modalPopLite-mask4" style="width:100%;z-index: 1;"  class="modalPopLite-mask"></div>
	<div id="modalPopLite-wrapper" style="left: -10000px;z-index: 1000; " class="modalPopLite-wrapper">
		<div class="modalPopLite-child" id="popup-wrapper4" >
		<div class="black_overlay" style="display: none;"></div>
		<h4><?php echo __('Confirmation',true); ?>
		<span class='demonstrations1' style="display: block!important; " >           
				<span style="font-size: 18px !important;margin-top: -17px; float: right;"> <a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); return fancyboxclose2(); " >X</a>	</span>  
				<span style="font-size: 18px !important;margin-top: -17px; float: right;margin-right: 10px;"><a href="javascript:;"  style="cursor:pointer;margin-top: 5px;" onMouseOver="Tip('<b><?php echo __('deleteStation_helpTitel') ?></b><br/><?php echo __('deleteStation_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a>	</span>		
			</span>
 </h4>
			<span style="width:388px; height:150px;margin:15px auto;  ">
			<h6><?php 
			
				echo __( wordwrap('stationDeleteConfirmation',62,"<br>\n"));
			
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
App::import('Model','Location');
 $this->Location=new Location();
 ?>
<?php
#-----------------------------------------------------------------#
# $Rev:: 22            $:  Revision of last commit                #
#-----------------------------------------------------------------#


// file: /app/views/locations/index.ctp
?>
 <?php $stationStatus = Configure :: read('stationStatus'); ?>
 
 <?php if((isset($success)) && $success){?>

		<div class="notification first" style="width: 534px" >

			<div class="ok">
				<div class="message">
					<?php echo $success;?>
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
			echo '<br>';
		}
?>

 
 
 
	<div class="block top">
	<br>
	
	
	    <?php
		#For pagination reasons to handle sort and filter
	    #$paginator->options(array('url' => $this->passedArgs));
		
	    
		echo $form->create('Station',array('url'=>'/stations/index/'.$cust_id,'id'=>'filters', 'type'=>'GET'));
		#For pagination reasons to handle sort and filter
		#$paginator->options(array('url' => array('location' => $this->passedArgs['location'])));
		#$paginator->options(array('url' =>false)); 
		$paginator->options(array('url' => array('sid' => $this->passedArgs['sid'], 'type' => $this->passedArgs['type'], 'port' => $this->passedArgs['port'], 'location_id' => $this->passedArgs['location_id'])));

		
		// check $locations variable exists and is not empty				
		
		 #if(isset($stations) && !empty($stations)) :
		 if(isset($stations)) :
		 
		 //Handling the location dropdown selection
		 
		 if(isset($_POST['location']))
		 {
		  $location_val=$_POST['location'];
		  
		 }
		 else
		 {
		   if(isset($curr_loc) && $curr_loc !=0)
		   {
		    $location_val=$curr_loc;
		    #$paginator->options(array('url' => array('location_id' => $location_val)));
		   }
		   else
		   {
		    $location_val=0;
		   }
		 }
		 	 
		?>
	
		<div id="" class="table-content">

		<!--Insert tables-->
			<!-- CBM
			<div class="button-right">
				<a href="#" id="st_profile_photo"   name="validate" value="validate" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __('Upload MOH File') ?></a>
			</div>

			<div class="button-right">
               		         <a href="javascript:void(null)"  onclick="javascript:submi_form('filters');" name="data[filter]" value="filter" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __("filter");?></a>
                         </div>
                         <div class="button-left">
				<?php //echo $html->link( __("reset", true),  array('controller'=> 'stations', 'action'=>'index', $cust_id,1),array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);')); ?>
                         </div>
			-->
			
			<?php #echo "<pre>";print_r($locations_ids); ?>	
			
		    <table cellspacing="0" class="phonekey">
		    	
		    	<thead>
		        	<tr class="table-top">
		        		<!--<td class="table-column table-left-ohne" style="width:20px;">&nbsp;</td>-->
		            	<th class="table-column" style="width: 90px" ><span><?php __("Number");?></span></th>
                        <th class="table-column" style="width:134px;"><span><?php __("Location")?>&nbsp</span></th>
                        <th class="table-column"  style="width:57px;"><span><?php __("Type")?></span></th>
                        <!--<th class="table-column" style="width:182px;"><span><?php  __("Port") ?></span></th>-->
		                <th class="table-column" style="width:130px;"><span><?php  __("DISPLAYNAME") ?></span></th>
		                <th class="table-column" style="width:100px;"><span><?php  __("Status") ?></span></th>
		                <!--<th class="table-right-ohne" style="border-right: 1px solid #D1D1D1!important;">&nbsp;</th>-->
		            </tr>
				 	<tr>
				<!--<td class="table-column table-left-ohne">&nbsp;</td>-->
		                <td><?php echo $form->input('sid', array('label' => false,'type'=>'text', 'class' => 'filter-class onclick','style'=>'width:75px;', 'value'=>(isset($this->params['named']['sid'])?$this->params['named']['sid']:(isset($this->params['url']['sid'])?$this->params['url']['sid']:'')))); ?></td>
				<td>
                
                <?php   $location_id=$this->passedArgs['location_id'];	 ?>
                
				<select name="location_id" style="width:125px;"  onchange="javascript:submi_form('filters');" id="fixed-select-no-css">
				<option value=""><?php __("No Location") ?></option>
				<?php foreach($locations_ids  as $eachlocation){
           if($eachlocation['Location']['scm_name']=="" && $eachlocation['Location']['address']!="" ) {
				$stationLocation =$locationstring = $eachlocation['Location']['name'] . ' ( ' . $eachlocation['Location']['plz'] . ' ,' .$eachlocation['Location']['address'].' )';
			}
			elseif($eachlocation['Location']['address']=="" &&  $eachlocation['Location']['scm_name']!="") {
				$stationLocation =$locationstring =$eachlocation['Location']['name'] . ' ( ' .$eachlocation['Location']['plz'] . ' ,' .$eachlocation['Location']['scm_name'].' )';
			}
			elseif($eachlocation['Location']['address']=="" &&  $eachlocation['Location']['scm_name']=="" &&  $eachlocation['Location']['plz']!="") {
				$stationLocation  = $eachlocation['Location']['name'] . ' ( ' . $eachlocation['Location']['plz'] .' )';
			}
			elseif($eachlocation['Location']['address']=="" &&  $eachlocation['Location']['scm_name']=="" &&  $eachlocation['Location']['plz']=="") {
            $stationLocation  = $eachlocation['Location']['name'];
			}
			else {
				$stationLocation =  $eachlocation['Location']['name'] . ' ( ' . $eachlocation['Location']['plz'] . ' ,' . $eachlocation['Location']['scm_name'] . ','.$eachlocation['Location']['address'].' )';
			}

          ?>      
                                  
                    <option value="<?php echo $eachlocation['Location']['id'];?>" <?php if($location_id==$eachlocation['Location']['id']) { echo "selected='selected'"; } ?> ><?php echo $stationLocation;?></option>
 				<?php }?>
				</select>
				</td>
						<td><?php echo $form->select('type',array(''=>'',
								'CICM'=>'CICM',
							        'ANLG'=>'ANLG'),(isset($this->params['named']['type'])?$this->params['named']['type']:(isset($this->params['url']['type'])?$this->params['url']['type']:'')),array('style'=>'width:54px;','onchange'=>"javascript:submi_form('filters');")); ?></td>
				
		               <!-- <td><?php echo $form->input('port', array('label' => false,'type'=>'text','class' => 'filter-class onclick','style'=>'width:172px;', 'value'=>(isset($this->params['named']['port'])?$this->params['named']['port']:(isset($this->params['url']['port'])?$this->params['url']['port']:'')))); ?></td>
		                </td>-->
                        
                         <td><?php echo $form->input('dispname', array('label' => false,'type'=>'text','class' => 'filter-class onclick','style'=>'width:120px;', 'value'=>(isset($this->params['named']['dispname'])?$this->params['named']['dispname']:(isset($this->params['url']['dispname'])?$this->params['url']['dispname']:'')))); ?></td>
		                </td>
						<?php  //$statusess =__($statuses,true);//changed on 2/07/2014 to make status localize
						
						foreach($statuses as $key => $statusname){
							
							 $sts[$key] =  __($statusname,true);
							
						}
						 ?>
 						<td>
												
						<?php echo $form->select('status', $sts,(isset($this->params['named']['status'])?$this->params['named']['status']:(isset($this->params['url']['status'])?$this->params['url']['status']:'')),array('style'=>'width:75px;','onchange'=>"javascript:submi_form('filters');")); ?>
							
							
							
						</td>
					 </tr>
		
		        </thead>
		    </table>
			<div class="block" style="margin: 0px;">
				
				<div class="button-right">
					
					<?php echo $html->link( __("Export Csv", true),  array('controller'=> 'stations', 'action'=>'export'),array('onmouseover'=>'hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
					
				</div>
				<div class="button-right">
               		         	<a href="javascript:void(null)"  onclick="javascript:submi_form('filters');" name="data[filter]" value="filter" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __("filter");?></a>
								
                         	</div>
							
                         	<div class="button-left">
					<?php echo $html->link( __("reset", true),  array('controller'=> 'stations', 'action'=>'index', $cust_id,1),array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);')); ?>
                         	</div>
			</div>
<div  ><button type="submit" style="width: 0px;height: 0px; background-color: #FFFFFF !important; cursor: none !important; border: none;" ></button></div>
				<?php echo $this->element('pagination/top'); ?>


			<table class="table-content phonekey">
		    <!--<table cellspacing="0" class="phonekey">-->
		    	<?php //echo  (isset($filter_sort) && in_array('sort:id',$filter_sort) && in_array('direction:asc',$filter_sort)) ? 'sortlink_asc':'ggggg'; print_r($filter_sort);die();?>
		    	<thead>
		        	<tr class="table-top">
		        	<!--<th class="table-column table-left-ohne" style="width:21px;">&nbsp;</th>-->
					
					
					<?php
			
		   $url = $this->params['named']['direction'];
		   $url2 = $this->params['url']['url'];		   
		   
			if($url=="" && strlen($url2)>6 ){ 
				#$filter_sort = array('0'=>'groups','1'=>'index','2'=>'Page:1','3'=>'customer_id:'.$SELECTED_CNN,'4'=>'sort:name','5'=>'direction:desc');
				 $urlfilter="stations/index/$SELECTED_CNN/page:1/sort:id/direction:desc";
			?>
			
				<th class="table-column <?php echo 'sortlink_asc';?>" style="width:91px;text-align: left;"> <a id="sortlink" href="<?php echo Configure::read('base_url').$urlfilter; ?>"><?php echo __("Number",true); ?></a>
				</th>				
			<?php }else{ ?>

			<th class="table-column <?php if(in_array('sort:id',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:id',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?>" style="width:91px; text-align: left;"><?php echo $paginator->sort(__("Number",true), 'id', $filter_options);?></th>
			<?php } ?>
					
		        	
		          
				  
				<th class="table-column" style="width:131px; text-align: left; padding: 2px 0px 0px 2px;"><?php echo  __("Location") ?></th>				
				
				<th class="table-column" style="text-align: left; padding: 2px 0px 0px 2px;"><?php echo  __("Type") ?></th>				
                        <!--<th class="table-column <?php if(in_array('sort:port',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:port',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?>" style="width:180px; text-align: left;"><?php echo $paginator->sort(__("Port",true), 'port', $filter_options);?></th>-->
                        <th class="table-column" style="width:130px; text-align: left; padding: 2px 0px 0px 2px;"><?php echo  __("DISPLAYNAME") ?></th>
		               <th class="table-column" style="text-align: left; padding: 2px 0px 0px 2px;"><?php echo  __("Status") ?></th>
		                <th class="table-right-ohne">&nbsp;</th>
                        <th class="table-right-ohne" style="border-right: 1px solid #D1D1D1!important;">&nbsp;</th>
		            </tr>
		
		        </thead>
		        <tbody>
		        	<?php
					
					// initialise a counter for striping the table
					$count = 0;
							
					// loop through and display format
					
					
					
					foreach($stations as $stations):
					
					#echo "<pre>";print_r($stations);
					
						// stripes the table by adding a class to every other row
						$class = ( ($count % 2) ? " class='altrow'": '' );
						// increment count
						$count++;
						
					?>
		            <tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">
		           		 <!--<td class="table-left">&nbsp;</td>-->
		            	<td style='width: 85px; text-align: left;'><?php echo $html->link($stations['Station']['id'],array('action'=>'editstation', $stations['Station']['id']));?></td>
                        
		          <!-- <td style='width: 85px;'><?php echo $html->link($stations['Feature']['primary_value'],array('action'=>'editstation', $stations['Station']['id']));?></td>
		          	<td style='width: 55px;'><?php echo $html->link($stations['Station']['type'],array('action'=>'editstation', $stations['Station']['id']));?></td>
		            <td style='width: 180px;'><?php echo $html->link($stations['Station']['port'],array('action'=>'editstation', $stations['Station']['id']));?></td>
		            <td style='width: 45px; text-align: right;'><?php echo $html->link($stations['Station']['status'],array('action'=>'editstation', $stations['Station']['id']));?></td>
		            	-->
		            	<td style='width: 85px;'>
                        <?php
						      $locationName=$this->Location->getgroupLocation($stations['Stationkey']['location_id']);
							       echo $locationName['Location']['name'];
						?>
                       </td>
		            	<td style='width: 55px;'><?php echo $stations['Station']['type']?></td>
		                </td>
		            	<!--<td style='width: 180px;'><?php echo $stations['Station']['port']?></td>-->
                       <td style='width: 85px;'><?php echo $stations['Feature']['primary_value']?></td>
		                <td style='width: 50px; text-align: left;'>
                                   
                                    <?php echo __($stationStatus[$stations['Station']['status']],true); 	 ?>
                                
                                </td>
		            	
		            	<!--<td class="table-right-ohne">&nbsp;</td>-->
                        
                        <td class="table-right-ohne	 tooltip" >
	          		 	<div>
							<div class="fl">		
							<span><a href="javascript:;" onclick="Tip(' <?php echo __('portname').': '. $stations['Station']['port']; ?><br/><?php echo __('Extensions').': '. $stations['Station']['extensions']; ?><br/><?php echo __('MoH').': '. $stations['Station']['MOH']; ?><br/><?php echo __('Device Type').': '. $stations['Station']['phone_type']; ?><br/><?php echo __('CTI').': '. $stations['Station']['CTI']; ?><br/><?php echo __('NSC').': '. $customer['Customer']['NSC'] ?><br/><?php echo __('Combox').': '. $stations['Station']['COMBOX']?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
							</span>
							
							</div>
						</div>
	          		 </td>
                         <td class="table-right-ohne" style="background: url(<?php echo $this->webroot; ?>/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat 3px 5px;border-right: 1px solid #D1D1D1!important;"   onmouseover="this.className='table-right-over';" onmouseout="this.className='table-right';">
                        <div class="table-menu">
                          <div class="table-menu-popup" style="z-index: 1; display: none;">
                            <ul>
                            <li class="last log">
                              <?php echo $html->link( __('stationEdit',true), array('controller'=>'stations', 'action'=>'editstation/' . $stations['Station']['id']));
	           			?>
                            </li>
							
							<?php if($stations['Station']['type'] == 'CICM')
							{?>
							<li class="last log">
					  <?php echo $html->link(__("changePassword", true), array('controller'=> 'stations', 'action'=>'change_password',$stations['Station']['id']), array('class' => "fancybox fancybox.ajax")); ?>
					 </li>
					 	<?php }?>
					<!-- <li class="last log">
	 <a href="javascript:void()"  class="clicker4" id="deleteStation" onclick=" " name="<?php echo $stations['Station']['id']   ?>" onmouseover="initStationId(this)" ><?php echo __("deleteStation", true); ?></a>
					 </li>-->
					 
					
                            </ul>
                          </div>
                        </div>
                        </td>
		            </tr>
		            <?php endforeach; ?>
		        </tbody>
		    </table>


		<!--end Insert tables-->

	
	
	        </div>
	<?php
	echo $this->element('pagination/bottom');


		else:
			echo 'There are 0 stations that match your criteria';
		endif;
		?>
	 
		<div class="button-left">
        		<?php if($userpermission==Configure::read('access_id'))
			{
				echo $html->link( __('Back',true),  array('controller'=> 'customers', 'action'=>'index'),array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);'));
		
			}
			?>
       		</div>
	</div>
	</form>
</div>	
<!--right hand side starts from here-->
<!--<div class="fl" style="color:#11AAFF;width:150px;padding-top:10px;">-->
<div id="related-content">
	<div class="box start link">
	<a href="http://www.swisscom.ch/grossunternehmen" target="_blank">
		<?php __('Home Swisscom') ?>
	</a>
	</div>
	<div class="box">
        	 <h3><?php __('stationList') ?></h3>
                 <p>
                  <?php __('stationList_blurb') ?>
                 </p>
			<div id="shortcont">
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('fullcont')"  title=""><?php echo __('moreStart') ?></a>             
            </div>
            <div style="display:none;" id="fullcont_type"  >
               <p  ><?php echo __('stationList_helpText') ?></p>
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('shortcont')"  title=""><?php echo __('moreEnd') ?></a>      
			</div>	 
        </div>
	
	<?php if($userpermission==Configure::read('access_id'))
        {
	?>

	<div class="box info">
		<h3><?php __('Internal User') ?></h3>
         <p><?php __("Customer View:");  ?><?php echo $cust_id; ?></p>
		 <p><?php echo $selected_customer; ?></p>
       </div>
	<?php } ?>
		
	<?php echo $locations_ids[1]['Location']['pro_nr']; ?>
	<div class="hide" style="display:none;">
		
		<div id="upload_photo" align="left" class="phone" style="padding-left:2px;" >
			<h1><?php  __("File Upload")?></h1>
			<hr>
			<!-- <div style="clear:both;height:70px">&nbsp;</div> -->
			<div style="clear:both;">&nbsp;</div>
			<form id="form" action="<?php echo Configure::read('base_url');?>stations/upload" enctype="multipart/form-data" target="upload_iframe" method="POST">
			<!-- <div id="upload_status" style="color:red;width:400px;height: 38px; text-align:left"></div> -->
			<div id="upload_status" style="color:red;height: 38px; text-align:left"></div>
				<div class="clear_both_il"></div>
			<div id="cont_cont_phone">
				<div class="fl label_container_np" style="padding-top:5px;padding-right:5px;">
					<?php __('Select File') ?>
					<input type="hidden" id="customerID" value="<?php echo $SELECTED_CUSTOMER_NAME?>" name="customerID"/>
				</div>
				<div class="fl text_container">
					<input style="height:24px;" type="file" name="file" id="file">
						
				</div>
			</div>
			<div class="clear_both_il"></div>
			<div class="row_separator" id="cont_cont_phone">
				<div class="fl label_container_np">
					&nbsp;
				</div>
			<div class="cb"></div>
			
		
		
			<div style="clear:both;height:95px"><br><?php __('moh_limit') ?><br><?php __('moh_license') ?></div>
			<div style="clear:both;height:40px">&nbsp;</div>
			<!-- <div class="fl text_container" style="height: 30px; width:456px;"> -->
				<div class="block">
					<div class="button-right" style="vertical-align: bottom" id="upload_button">
						<a href="javascript:void(null);" id="upload_student_photo" name="validate" value="Upload" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __('Upload') ?></a>
					</div>
				
				</div>
			<!-- </div> -->
		</div>
	</form>
</div>
</div>
<iframe name="upload_iframe" style="width: 400px; height: 100px; display: none;"></iframe>
</div>
<!--ight hand side  ends here-->

<script type="text/javascript">
	$(document).ready(function() {

	  /*
	   *  Simple image gallery. Uses default settings
	   */
	  $('.fancybox').fancybox();
	  
	});
</script>

