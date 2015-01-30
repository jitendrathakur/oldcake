 <!--[if IE]>
            <meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1">
        <![endif]-->  
<?php 
 App::import('Model','Location');
 $this->Location=new Location();
//echo $javascript->link('/js/jquery-1.10.1.min');
echo $javascript->link('/js/jquery.fancybox');
//echo $this->element('editable');
?>

<style>
#mcTooltipWrapper {
	display:none;
}
.t_Tooltip{
	display:none !important;
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
		$('.fancybox').fancybox();
		
		var grpmembercount = $("#grpmembercount").val();
		
		if(grpmembercount==0){
			$('#addMemberStation').click();
		}
		
		
	});
	
	
	function submenuactivity(action) {
		 var p = action;
		jQuery('input[type="checkbox"]').each(function() {
        if (action == p) {
            $('#table-menu-popup').show();
        } else {
            $('#table-menu-popup').hide();
        }
	 });
    }
	
</script>

<link rel="stylesheet" href="//google-code-prettify.googlecode.com/svn/trunk/src/prettify.css" type="text/css"/>
<script type="text/javascript" src="//google-code-prettify.googlecode.com/svn/trunk/src/prettify.js"></script>
<script type="text/javascript"> 
    $(document).ready(function() { //alert("ret");
        $('#dragdroptbl').tableDnD({ 
            onDragStart: function(table, row) { 
                //$(table).parent().find('.result').text('');
            }, 
            onDrop: function(table, row) { //alert("ssd");
                $('#AjaxResult').load(base_url+"groups/edit?"+$.tableDnD.serialize());
               // prettyPrint();
			  // var newPositionedAry = decodeURI($.tableDnD.serialize()); alert(newPositionedAry);
				    var tblstr = decodeURI($.tableDnD.serialize());
                    var tmparray = new Array();
                    var x = 0;
                    tmparray = tblstr.split("&dragdroptbl[]="); 
                    while (x < tmparray.length) {
                        if (tmparray[x] != "dragdroptbl[]=") { 
						   pos=x+1; 
						   pos = (pos.toString().length==1)? '0'+pos : pos;
						   original_position = tmparray[x].replace("dragdroptbl[]=", ""); 
						  //  alert(pos+"=="+original_position);
						  // alert($('#'+original_position).find($("input[name^='featureNewPosition']")).attr('id'));
						 //  alert($('#'+original_position).find($(".opencolorbox")).attr('href'));
						 $('#'+original_position).find("td:nth-child(2) input[name^='featureNewPosition']").val(pos);
						 // alert( $('#'+original_position).find("td:nth-child(2) input[name^='featureNewPosition']").val());
                          // $(apriority).val(tmparray[x]);
                        }
                        x++;
                    }
                
			   
            }
        });
	});
	function submitForm(){
		$('.filtersForm').attr('action',base_url+'groups/group_change/');
		$('.filtersForm').attr('method','POST');
		$.ajax({
				type: "POST",
				async : false,
				dataType: 'json',
				url: $('.filtersForm').attr('action'),
				data: $('.filtersForm').serialize(),
				success: function(data){ 
					// do nothing
				}
		});
	}
	function reloadme(){
		location.reload();
	}


	validation = {
	    // Specify the validation rules
	    'rules': {                     
	        'GroupGroupName':{
	            'required': true,
	            'max': '50'
	            //'max': '30'
	        },  
	        //'GroupGroupDesc':{
	        	//'required' : true,
	          //  'max': '50'
	      //  },                       
	    },                  
	    // Specify the validation error messages
	    'messages': {  
	        'GroupGroupName': {
	             'required': "<?php __('GroupNameNotempty')  ?>",
	             'max': "<?php __('max50')  ?>"
	         },  
	        // 'GroupGroupDesc': {
	           //  'required': "<?php __('GroupDescNotEmpty')?>",
	           //  'max': "50"
	        // },    	         
	    },
	  };
	
	function submi_form(form_id)
	{	
		if (inValidate(validation)) {  	
		    return false;
		} else {	
			$('#'+form_id).submit();
		}
	} 


         function chngbkcolor(obj) {
			  $(document).ready(function() {
				  jQuery('#button').attr("class", "showhighlight_buttonleft");
				  jQuery('#updateGroup').removeAttr("class");
				  jQuery('#updateGroup').attr("class", "button-right-hover");

			  });
		  }



</script>





  <?php 
  /**
  * Group Delete Function via Ajax
  * 
  * @return
  */ ?>
  <script>
  	function group_delete(){
		
		var clickedStation = $('#StationUID').val();
		
		$("#modalPopLite-mask").hide();		
		$("#modalPopLite-mask").css("background-color", "#f");
		$("#modalPopLite-mask").attr('class','modalPopLite-mask2');
		
		$("#modalPopLite-mask1").hide();		
		$("#modalPopLite-mask1").css("background-color", "#f");
		$("#modalPopLite-mask1").attr('class','modalPopLite-mask2');
		
		$('.black_overlay').css('display', 'block');
	$.fancybox.showLoading()  ;		
	setTimeout( function() { 	
		var TargetURL = "<?php echo Configure::read('base_url');?>stations/minor_delete?feature_id="+clickedStation+"-CPU&customer_id=<?php echo $SELECTED_CNN ?>&spg=edit_cpu";
$.fancybox.showLoading()  ;
		window.location.href = TargetURL;
},2000);
$.fancybox.showLoading()  ;		
 		//jQuery.post( TargetURL,  function( data ) {  //alert(data);
		//	window.location.href = "<?php echo Configure::read('base_url'); ?>groups/edit/group_id:<?php echo $groupDetails['Group']['id'];?>";
			//window.location.reload();
			
	//});
	
	/*setTimeout( function() {     
			$('#close-btn').trigger('click');
		 },200);*/
	
}
  </script>
  <?php
  /**
  * Assign Vlaue in Function
  */
  ?>
  <script type="text/javascript">
//script for modelpopup

	  function InitGroup(val){
		document.getElementById('StationUID').value= val;
		
	  }

	$(function () {
	    $('.popup-wrapper').modalPopLite({ openButton: '.clicker', closeButton: '#close-btn', isModal: true });
	
	});
	
</script>
  
  
<script>
	function fancyboxclose(){
		setTimeout( function() { $('#close-btn').trigger('click'); },5);
	 	}
		
</script>
<style type="text/css">
	/* CSS for modelpopup */
	     
	#clicker	{			
		cursor:pointer;
	}
	.popup-wrapper		{
		width:390px;
		height:185px;
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





<div class="block top">
	
	<!--<div id="overlay-error" class="notification first hide" style="width: 100%" >
	
		<div class="error">
			<div class="message">
				
			</div>
		</div>
	</div>-->

<?php 


 //$stationLocationid = $_SESSION['stationLocationid'];
$activationusers = Configure::read('activationusers');
if((isset($success)) && $success){?>
	
		<div class="notification first" style="width: 534px" >
		
			<div class="ok">
				<div class="message">
					<?php //echo $success;
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
		
	<?php }?>
	<br>
	

	    <?php 
		
		
		
		
		echo $form->create('Group',array('action'=>'edit/group_id:' . $groupDetails['Group']['id'],'id'=>'edit','type'=>'POST', 'invalidate' => 'invalidate'));
		$stationStatus = Configure :: read('stationStatus');
	    //echo $form->create('Station',array('action'=>'editstation','id'=>'filters','class'=>'filtersForm','type'=>'GET'));
	   ?>

            <!-- <h4><?php echo __("Group Detail") ?><a data-title="Enter Group Name" data-placement="right" data-type="text" id="group_name" href="#" class="editable editable-click" data-original-title="" title="" style="display: inline;"><?php echo trim($groupDetails['Group']['name']);?> <span style="padding-left:45px;"></span></a></h4>-->
			 
			 <h4><?php echo __("Group Detail") ?><?php echo trim($groupDetails['Group']['name']);?> </h4>


	    <div class="cb">
		<?php //if($groupDetails['Group']['name']=="") { ?>
		<?php if(($groupMemberscount==0) && $groupDetails['Group']['name']=="") { ?>
			
		
		 <div class="form-box">
			<div class="form-left">
					<?php 
					echo '<div style="width:100px; float: left">' . __('groupType', true). '</div>';
					echo	'<p>' . $groupDetails['Group']['type'] . '</p>'?>			
					
			</div>
			<div class="form-left">
					<?php 
					echo '<div style="width:100px; float: left">' . __('groupId', true). '</div>';
					echo	'<p>' . $groupDetails['Group']['identifier'] . '</p>';
					echo $form->input('identifier', array('type'=>'hidden','value'=>$groupDetails['Group']['identifier'])); 
								?>
					
			</div>
			<div class="form-left">
					<?php 
					echo '<div style="width:100px; float: left">' . __('groupName', true). '</div>';
					if($groupDetails['Group']['name']!=""){
					echo	$form->input('groupName', array('label' => false,'value'=>$groupDetails['Group']['name'],'style'=>'width:132px;','onkeyup'=>'chngbkcolor(this)','placeholder'=>'Please enter Name'));
					} else {
					echo	$form->input('groupName', array('label' => false,'value'=>'Please enter Name','style'=>'width:132px;','onkeyup'=>'chngbkcolor(this)','onfocus'=>'(this.value == "Please enter Name") && (this.value = "")','onblur'=>'(this.value == "") && (this.value = "Please enter Name")'));
					}
					
					
						?>		
					
			</div>
			<div class="form-right">
					<?php 
					echo '<div style="width:100px; float: left">' . __('groupDesc', true). '</div>';
					echo	$form->input('groupDesc', array('label' => false,'value'=>$groupDetails['Group']['desc'],'style'=>'width:100px;','onkeyup'=>'chngbkcolor(this)'));	?>		
					
			</div>
		</div>
		<?php } else { ?>
		
		
		<div class="form-box">
		<div class="form-left" id="edit_stat_popupmenu" style="display: block">
          <div>
				<span  id="edit_stat" style="margin-left:15px; float:left;cursor:default;font-weight: bold;"<?php echo $readonly; ?>><?php __("GroupCPUEditOptions"); ?> </span>
		  </div>
				<br>
	      				   <ul style="margin: 0 0 0 14px">
							<li><?php echo $html->link( __('editGroup',true),array('div'=>false, 'controller'=>'groups', 'action'=>'editcpuname/group_id:'. $group_id), array('class' => 'fancybox fancybox.ajax')); ?></li>
							
							
							<li><?php echo $html->link( __("Add Member", true),array('controller'=>'stations','action'=>'selectstation','group_id:'.$group_id .'&location_id='.$stationLocationid. '&type=single&memcount='.$groupMemberscount),array('class'=>'fancybox fancybox.ajax','id'=>'addMemberStation')); ?></li>
							
							</ul>
		
		</div>
		<div class="form-right">
					<?php                                     
                     echo __('groupCpuInfo_blurb');  
					?>

		</div>
		</div>
		<?php } ?>
		
		
		
		
			<div class="block" style="margin: 0px;">
			<?php if($groupDetails['Group']['name']!="") { ?>
				<div class="button-right" id="updateGroup">
					<!--<a id="button" href="javascript:void(null)"  onclick="javascript:submi_form('edit');" name="submitForm" value="submitForm" onmouseover='javascript:hoverButtonRight(this);',  onmouseout="outButtonRight(this)"><?php __("save");?></a>-->
				</div>
				<?php } else { ?>
				<div class="button-right-hover" id="updateGroup">
					<a id="button" class="showhighlight_buttonleft" href="javascript:void(null)"  onclick="javascript:submi_form('edit');" name="submitForm" value="submitForm" ><?php __("save");?></a>
				</div>
				<?php } ?>
				<?php //if($groupDetails['Group']['name']!="") {
					if(($groupMemberscount==0) && $groupDetails['Group']['name']!="") {
					 ?>
				<div class="button-left-hover" style="display: none;">
					<?php //if($activationusers[$_SESSION['ACCOUNTNAME']] == 'RE3'){?>
					  <?php echo $html->link( __("Add Member", true),array('controller'=>'stations','action'=>'selectstation','group_id:'.$group_id .'&location_id='.$stationLocationid. '&type=single'),array('class'=>'fancybox fancybox.ajax , showhighlight_buttonright','id'=>'addMemberStation')); ?>
				
					<?php //}?>
						
					</div>
				
				<?php } //}  ?>
			<input type="hidden" name="grpmembercount" id="grpmembercount" value="<?php echo $groupMemberscount; ?>">
				<!--<div class="button-left">
					<?php echo $html->link( __("save", true),'javascript:void(0);',array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);','class'=>'reset')); ?>
                </div>-->
            </div>
	
	    <?php
		// check $stationFeatures variable exists and is not empty
		if(isset($groupMembers) && !empty($groupMembers)) :
		#if(1) :
		
		#echo "<pre>";print_r($groupMembers);
		
		?>
	    <div id="" class="table-content main_table_content">
		<div id="AjaxResult" style="display:none; float: right; width: 250px; border: 1px solid silver; padding: 4px; font-size: 90%">
		</div>
		
		<table class="phonekey stationtbl">
				<thead>
				<tr class="table-top">
				 <th class="table-column">&nbsp;&nbsp;ID&nbsp;&nbsp;</th>
				 </tr>
		</thead>
			  <?php
					// initialise a counter for striping the table
					$memberAry = array(); //echo "<pre/>"; print_r($stationFeatures); die;
					
$LocationArray =array();
					foreach ($groupMembers as $groupMember)
					{				
						
						$matches = explode('@', $groupMember['Feature']['stationkey_id']);
						$stationkey_id = $matches[0];
						$station_id = $matches[1];

						$LocationArray[$station_id] = $station_id;
					}
					
					$NumLoop = count($LocationArray)+1;					
					
					
					
					for($i=1;$i<$NumLoop;$i++){ //echo "<pre/>"; print_r($stationFeatures[$i]); 
						$memberAry = $groupMembers[$i];
						$count=0;
					#foreach($groupMembers as $groupMember):
						// stripes the table by adding a class to every other row
						$class = ( ($i % 2) ? " class='altrow'": '' );
						// increment count
						
					?>
				<tr style="height:23px;">
					<td  style="width: 20px;"> <?php echo $i; ?></td>
				</tr>
				<?php }//$count++; endforeach; // ?>
				<td  style="width: 20px;"> <?php echo $i; ?></td>
		</table>
		<table class="phonekey stationtb2" id="dragdroptbl">
		<thead>
			<tr class="table-top">
				 
				 <th class="table-column" align="left" ><?php echo __('memberStation')?></th>
				 <th class="table-column" align="left"><?php echo __('Key')?></th>
                 <th class="table-column filter-select filter-exact" data-placeholder="State" align="left"><?php echo __('memberLocation')?></th>
				 <th class="table-column filter-select filter-exact" data-placeholder="State" align="left"><?php echo __('memberState')?></th>
				 <th class="table-column" align="left"><?php //echo __('menu')?></th>
		
			 </tr>
		</thead>
				 <tbody>
				   <?php
					// initialise a counter for striping the table
					$memberArray = array(); 	echo $form->input("newaddedFeatues", array('type'=>'hidden','value'=>'','id'=>"newaddedFeatues"));
					$x = 0; $LocationArray =array();
					foreach ($groupMembers as $groupMember)
					{
						
						
						$matches = explode('@', $groupMember['Feature']['stationkey_id']);
						$stationkey_id = $matches[0];
						$station_id = $matches[1];
						if(array_key_exists($station_id, $stationMatched))
						{
							
							 $stationArray[$stationMatched[$station_id]]['keylist'] = $stationArray[$stationMatched[$station_id]]['keylist'] . ',' . $stationkey_id;
							 
							 
						}
						else
						{
							
							$stationMatched[$station_id] = $x;
							$stationArray[$stationMatched[$station_id]]['station_id'] = $station_id;
							#$stationArray[$stationMatched[$station_id]]['status'] = $groupMember['Feature']['status'];
							$stationArray[$stationMatched[$station_id]]['status'] = $groupMember['Station']['status'];
							$stationArray[$stationMatched[$station_id]]['keylist'] = $stationArray[$stationMatched[$station_id]]['keylist'] . ',' . $stationkey_id;
							$stationArray[$stationMatched[$station_id]]['location_id'] = $groupMember['Stationkey']['location_id'];
							$x++;
						}
						
						$stationArray[$station_id]['station_id'] = $station_id;
						$LocationArray[$station_id] = $station_id;
						
					}
					$countNumStation = count($LocationArray);
					$NumLoop = count($LocationArray)+1;
					for($j=0;$j<$NumLoop;$j++){
					  	$groupArray = $groupMembers[$j]; //$setHeight = "";
						#echo "<pre>";print_r($groupArray);
					    $matches = explode('@', $groupArray['Feature']['stationkey_id']);
					    //$stationkey_id = $matches[0];
					    //$station_id = $matches[1];
					    $station_id = $stationArray[$j]['station_id'];
						
					    $stationkey_id = $stationArray[$j]['keylist'];
					    $status = $stationArray[$j]['status'];
					    $station_id = $stationArray[$station_id]['station_id'];
						
												
						#echo "<pre>";print_r(count($station_id));
						
						//foreach($stationFeatures as $station):
						// stripes the table by adding a class to every other row
						$class = ( ($j % 2) ? " class='altrow'": '' );
						if(isset($memberArray) && !empty($memberArray)) {
										$sta_id = str_pad($station_id[0], 2, '0', STR_PAD_LEFT);
						}else{
										$sta_id = str_pad($sta_id+1, 2, '0', STR_PAD_LEFT);			
                                       // $setHeight  = 'height:21px';										
						}
					//}
					?>
					
			       <!-- <tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">-->
			        <tr style="cursor:move;height:23px;" onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false); " id="<?php echo $sta_id; ?>" >
					<td>
						<?php 
							//$DNID = $groupArray['Feature']['primary_value'];
							$DNID = $groupArray['Feature']['stationkey_id'];
							echo $form->input("featurevalue[$sta_id]", array('type'=>'hidden','value'=>$groupArray['Feature']['stationkey_id'])); 
							echo $form->input("featureNewPosition[$sta_id]", array('type'=>'hidden','value'=>$sta_id)); 
							echo $html->link($station_id,array('controller'=>'stations', 'action'=>'editstation',$station_id)); 
							
							#$DNID = $groupMember['Feature']['stationkey_id'];
							#echo $form->input("featurevalue[$station_id]", array('type'=>'hidden','value'=>$groupMember['Feature']['stationkey_id'])); 
							#echo $form->input("featureNewPosition[$station_id]", array('type'=>'hidden','value'=>$station_id)); 
							#echo $html->link($station_id,array('controller'=>'stations', 'action'=>'editstation',$station_id)); 
							
	                		
	                		
	                		?>
					</td>
	                <td>
	                		<?php 
							//$DNID = $groupArray['Feature']['primary_value'];
							$DNID = $groupArray['Feature']['stationkey_id'];
							echo $form->input("featurevalue[$sta_id]", array('type'=>'hidden','value'=>$groupArray['Feature']['stationkey_id'])); 
							echo $form->input("featureNewPosition[$sta_id]", array('type'=>'hidden','value'=>$sta_id)); 
							#echo $html->link($stid,array('controller'=>'stations', 'action'=>'editstation',$station_id));
	                        echo $stid =  trim($stationkey_id,",");  		
	                		 
							
							#$DNID = $groupMember['Feature']['stationkey_id'];
							#echo $form->input("featurevalue[$station_id]", array('type'=>'hidden','value'=>$groupMember['Feature']['stationkey_id'])); 
							#echo $form->input("featureNewPosition[$station_id]", array('type'=>'hidden','value'=>$station_id)); 
							#echo $html->link($stationkey_id,array('controller'=>'stations', 'action'=>'editstation',$station_id)); 
	                		?>
	                </td>
                    <td>
	                		<?php 
							#echo __($groupArray['Feature']['Station']['status'],true);
	                		#echo __($stationStatus[$stationStates[$groupArray['Stationkey']['station_id']]],true);
							if($groupArray['Stationkey']['location_id']!="") {
								
							 $grouplocationName=$this->Location->getgroupLocation($stationArray[$stationMatched[$station_id]]['location_id']);
							 echo $grouplocationName['Location']['name'];
							} else if(!empty($DNID)){
								
								#echo "Unknown Location";
								$grouplocationName=$this->Location->getgroupLocation($stationLocation[$stationArray[$stationMatched[$station_id]]['station_id']]);
							    echo $grouplocationName['Location']['name'];
								
								 }
							#echo $form->input("featurestatus[$sta_id]", array('type'=>'hidden','value'=>$groupArray['Feature']['status'])); 
	                		?>
					</td>
					<td>
	                		<?php 
							echo __($stationStatus[$status],true);
							echo $form->input("featurestatus[$sta_id]", array('type'=>'hidden','value'=>$groupArray['Feature']['status'])); 
							#$status=$groupMember['Feature']['status'];
							#echo $stationStatus[$status];
							#echo $form->input("featurestatus[$station_id]", array('type'=>'hidden','value'=>$groupMember['Feature']['status'])); 
	                		?>
					</td>
					<td class="table-right" style="background: url(<?php
        	echo $this->webroot;
			?>/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat 3px 5px;border-right: 1px solid #D1D1D1!important;" onclick="submenuactivity(<?php echo $station_id; ?>)" onmouseout="this.className='table-right';" id="<?php
        	echo $sta_id;
			?>tdlast">
            
			<div class="table-menu">
            <div class="table-menu-popup"  style="z-index: 1">
            <ul >
			<?php if(empty($station_id))
			{ ?>
				<!--<li class="log">
				<?php
        		echo $html->link(__('No Options', true), ''
        		);
				?>
				</li>--> 
				
                <li class="log">
				<?php #echo $html->link( __("Add Member", true),array('controller'=>'stations','action'=>'selectstation','group_id:'.$group_id . '&type=single'),array('class'=>'fancybox fancybox.ajax')); ?>
				<?php echo $html->link( __("Add Member", true),array('controller'=>'stations','action'=>'selectstation','group_id:'.$group_id .'&location_id='.$stationLocationid. '&type=single'),array('class'=>'fancybox fancybox.ajax')); ?>
				
				</li>
				
				<?php 
			}
			else
			{

			 if($station_id !='') {
				?>
				
				<li class="handset">
				<?php
				echo $html->link(__('stationEdit', true), array(
						'controller' => 'stations',
						'action' => 'editstation',
						$station_id
				));
				?>
				</li> 
				<?php 
				/*if($countNumStation==1) {										
					$confirmmsg ="groupLastMemberDeleteConfiramtion";		
				
				}
				else {
					$confirmmsg = "groupDeleteMember";					
				}*/				
				?>
				
				<li class="delete">
				<?php
				#echo $html->link(__('memberDelete', true), '');
				#echo $html->link(__('memberDelete', true), array(
				#		'controller' => 'stations',
				#		'action' => 'major_cfeature_change',
				#		$station_id . '&delete_feature=' . $cpuKeyFeatures[$station_id] . '-CPU&customer_id='.$SELECTED_CNN
				#),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('.$confirmmsg.');"));
				
				
				/**
				* 
				* @var Old Delete function with Windows Overlay
				* 
				*/
				
				/*echo $html->link(__('memberDelete', true), array(
						'controller' => 'stations',
						'action' => 'minor_delete?feature_id=' . $cpuKeyFeatures[$station_id] . '-CPU&customer_id='.$SELECTED_CNN.'&spg=edit_cpu'
				),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('.$confirmmsg.');"));*/
				
				
				$cpufeatureskey = $cpuKeyFeatures[$station_id];
				
				?>
				
				
				<?php
				/**
				* 
				* New Delete Function Confirmation Overlay
				* 
				*/
																								  
				if($stationArray[$stationMatched[$station_id]]['status'] < 7)
				{
					echo $html->link( __("memberDelete", true),'javascript:void(null)', array('onmouseover'=>"javascript:InitGroup('".$cpufeatureskey."')", 'escape'=>false,'title'=>'Delete','class'=>"clicker")); 
				}
				?>
				
				
				
				</li>	
				<?php  
			   }
			} 
			?>
            </ul>
            </div>
			</div>
		</td>
	            	<?php  }  //endforeach; ?>
	            	</tr>
                 
                    
				 </tbody>	
				 
				 				 <?php							  
/*
 * Start Confirmation Overlay Model For Delete
*/	
?>
						  
<div>
				
	<div id="modalPopLite-mask" style="width:100%" class="modalPopLite-mask"></div>
	<div id="modalPopLite-wrapper" style="left: -10000px;z-index: 2;" class="modalPopLite-wrapper">
	<div class="modalPopLite-child popup-wrapper " id="popup-wrapper">
	<div class="black_overlay" style="display: none;"></div>
	    <h4><?php echo __('Confirmation',true); ?>
		<?php 
				if($countNumStation==1) {										
					$confirmmsg ="groupLastMemberDeleteConfiramtion";		
				
				}
				else {
					$confirmmsg = "groupDeleteMember";					
				}				
				?>
			<span class='demonstrations1' style="display: block!important;" >           
				<span style="font-size: 18px !important;margin-top: -17px; float: right;"> <a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); return fancyboxclose(); " >X</a>	</span>  
				<span style="font-size: 18px !important;margin-top: -17px; float: right;margin-right: 10px;"><a href="javascript:;"  style="cursor:pointer;margin-top: 5px;" onMouseOver="Tip('<b><?php echo __('confirmDeleteGroupMember_helpTitel') ?></b><br/><?php echo __('confirmDeleteGroupMember_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a>	</span>		
			</span>
		  </h4>
	 <span  style="width:230px; height:150px;margin:50px auto;">
	        
			<h6 style="margin-left:0px;" ><?php echo __($confirmmsg);?></h6> <br><br>
			<a href="#" id="close-btn"></a>	
			 <span class="button-left" style="margin:2px 230px 11px !important" >
			<?php
				 echo $html->link( __("Cancle", true),'javascript:void(null)',array('id' => 'close-btn')); 
			 ?>
						
			</span>
			
			<span  class="button-right" style="margin:-35px 2px 10px !important" >
			<?php
								
			 echo $html->link(__("Ok", true), 'javascript:void(null)', array('onclick'=>'javascript:group_delete()','class'=>'clicker')); ?>
				
	      	</span>
		</span>	
	</div>
  </div>
</div>
<input type="hidden" name="StationUID" id="StationUID" class="sid" value="">


				 
				 
				  
		</table>
		    <div class="result"></div>
	    <?php echo $form->end(); ?>
	<?php //echo $this->element('pagination/newpaging'); ?>
	</div>
	    </div>
	   
	    <?php
		else:
			__("No Members available in this Group");
			echo '</div>';
		endif;
		?>
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
        	 <h3><?php __('groupCpuEdit') ?></h3>
                 <p>
                  <?php __('groupCpuEdit_blurb') ?>
                 </p>
			<div id="shortcont">
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('fullcont')"  title=""><?php echo __('moreStart') ?></a>             
            </div>
            <div style="display:none;" id="fullcont_type"  >
               <p  ><?php echo __('groupCpuEdit_helpText') ?></p>
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('shortcont')"  title=""><?php echo __('moreEnd') ?></a>      
			</div>	 
        </div>
        <!-- 
        <div class="box call-to-action">
						<div class="info info-error" style="z-index: 2">
				 	<a href="" id="warningNotification">&nbsp;</a></div><h3><?php __("notifications");?></h3>
			
				 	<p><?php __("InWork Objects");?>.</p>
			<div>
			<ul>
					<?php echo $this->element('right_notifications',array('SELECT_CUSTOMER' => $SELECTED_CNN)); ?>
             </ul>	
			</div>
		</div>
		-->

<!--INTERNAL USER OPTIONS -->
        <?php if($userpermission==Configure::read('access_id'))
        {?>
                <div class="box info">
                <h3><?php __("Internal User");?></h3>
                <p><?php __("customerName");?><?php echo $selected_customer; ?></p>
                <p><?php __("customerId");?><?php echo $SELECTED_CNN; ?></p>

                </div>
	<?php } ?>

		</div>
<!--right hand side  ends here-->

