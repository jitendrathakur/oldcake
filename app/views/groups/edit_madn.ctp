<!--<link rel="stylesheet" href="//google-code-prettify.googlecode.com/svn/trunk/src/prettify.css" type="text/css"/>
<script type="text/javascript" src="//google-code-prettify.googlecode.com/svn/trunk/src/prettify.js"></script>-->

<?php 
 App::import('Model','Location');
 $this->Location=new Location(); 
 #echo "<pre>";print_r($groupMembers); 
 #App::import('Model','Station');
 # $this->Station=new Station(); 
 //echo $javascript->link('/js/jquery-1.10.1.min');
echo $this->element('editable');
?>
<style>
.tooltip p {
    background: url("../images/assets/bg-actionbox.gif") repeat-x scroll 0 0 #E6E6E6;
    border: 1px solid #666666;
    color: #000000;
    display: none;
    margin-left: -130px;
    min-width: 150px !important;
}
#mcTooltipWrapper {
	display:none;
}
.t_Tooltip{
	display:none !important;
}
.showhighlight_arrow {
    background: url("../../images/assets/btn-hov-right-arrow.gif") no-repeat scroll right center rgba(0, 0, 0, 0) !important;
    color: #FFFFFF !important;
   
    height: 18px !important;
    padding: 0 20px 0 15px !important;
    text-decoration: none !important;
    width: 76% !important;
}

.showhighlight_arrow4 {
    background: url("../../images/assets/btn-hov-right-arrow.gif") no-repeat scroll right center rgba(0, 0, 0, 0) !important;
    color: #FFFFFF !important;
   
    height: 18px !important;
    padding: 0 20px 0 15px !important;
    text-decoration: none !important;
    width: 60px !important;
}
.modalPopLite-mask2 {
    background-color: #f;
    left: 0;
    position: absolute;
    top: 0;
    z-index: 9994;
}
</style>
<?php echo $javascript->link('/js/jquery.fancybox'); ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
	
		function submenuactivity(obj, action){	
		if(action==1){
			$('#table-popup').show();
		} else if(action==0){
			$('#table-popup').hide();
		}
	}
</script>


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


	validation = {
    	    // Specify the validation rules
    	    'rules': {                     
    	        'GroupGroupName':{
    	            'required': true,
    	            'max': '50'
    	            //'max': '30'
    	        },  
    	        'GroupGroupDesc':{
    	        	'required' : true,
    	            'max': '50'
    	        },                       
    	    },                  
    	    // Specify the validation error messages
    	    'messages': {  
    	        'GroupGroupName': {
    	             'required': "<?php __('GroupNameNotempty')  ?>",
    	             'max': "<?php __('max50')  ?>"
    	         },  
    	         'GroupGroupDesc': {
    	             'required': "<?php __('GroupDescNotEmpty')?>",
    	             'max': "<?php __('max50')  ?>"
    	         },    	         
    	    },
    	  };
	
	function submi_form(form_id)
	{
		//if (inValidate(validation)) {  	
		//    return false;
		//} else {	
			$('#'+form_id).submit();
		//}
	} 

	function reloadme(){
		location.reload();
	}
</script>
<script>
function chngbkcolor(obj){
$(document).ready(function(){
		jQuery('#button').attr("class","showhighlight_arrow4");	

		jQuery('#updateOdsentry').removeAttr("class");	
	    jQuery('#updateOdsentry').attr("class","button-right-hover");
});

}
</script>
  <script>
	function fancyboxclose(){
		setTimeout( function() { $('#close-btn').trigger('click'); },5);
	 	}
		
</script>
  
  <script>
  	function group_delete(){
		//string = document.referrer;
		var clickedStation = $('#StationUID').val();
		var clickedStationKey = $('#stationKeyId').val();
		
		
		
		$("#modalPopLite-mask").hide();		
		$("#modalPopLite-mask").css("background-color", "#f");
		$("#modalPopLite-mask").attr('class','modalPopLite-mask2');
		
		$("#modalPopLite-mask1").hide();		
		$("#modalPopLite-mask1").css("background-color", "#f");
		$("#modalPopLite-mask1").attr('class','modalPopLite-mask2');
		
		$('.black_overlay').css('display', 'block');
	    $.fancybox.showLoading()  ;	

	  setTimeout( function() {  
		var TargetURL = "<?php echo Configure::read('base_url');?>stations/major_cfeature_change/"+clickedStation+"&delete_feature="+clickedStationKey+"-DN_MADN&customer_id=<?php echo $SELECTED_CNN; ?>";
$.fancybox.showLoading()  ;
		window.location.href = TargetURL;
		},2000);
		$.fancybox.showLoading()  ;
 		//jQuery.post( TargetURL,  function( data ) {  //alert(data);
		//	exit();
			//window.location.href = "<?php echo Configure::read('base_url'); ?>groups/edit/group_id:<?php echo $groupDetails['Group']['id'];?>";
			//window.location.reload();
			
	//});
	/*setTimeout( function() {     
			$('#close-btn').trigger('click');
		 },200);*/
	
}

  	function group_delete2(){
		//string = document.referrer;
		var clickedStation = $('#StationUID').val();
		var clickedStationKey = $('#stationKeyId').val();
		
		$('.black_overlay').css('display', 'block');
	    $.fancybox.showLoading()  ;	
		setTimeout( function() {
		var TargetURL = "<?php echo Configure::read('base_url');?>stations/major_cfeature_change/"+clickedStation+"&delete_feature="+clickedStationKey+"-DN_MADN&customer_id=<?php echo $SELECTED_CNN; ?>";
		alert(clickedStation+"==="+clickedStationKey);
	$.fancybox.showLoading()  ;
 		jQuery.post( TargetURL,  function( data ) {  //alert(data);
			
			//window.location.href = "<?php echo Configure::read('base_url'); ?>groups/edit/group_id:<?php echo $groupDetails['Group']['id'];?>";
			//window.location.reload();
			
	});
	},2000);
	$.fancybox.showLoading()  ;
	/*setTimeout( function() {     
			$('#close-btn').trigger('click');
		 },200);*/
	
}
  </script>

<style type="text/css">
	/* CSS for modelpopup */
	     
	#clicker	{			
		cursor:pointer;
	}
	.popup-wrapper		{
		width:390px;
		height:225px;
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

	  function InitGroup(val,val1,key){
	  	
		document.getElementById('StationUID').value= val1;
		document.getElementById('stationKeyId').value= val;
		document.getElementById('KeyId').value= key;
		
		
		
	  }

	$(function () {
	    $('.popup-wrapper').modalPopLite({ openButton: '.clicker', closeButton: '#close-btn', isModal: true });
	
	});
     $(document).ready(function() {
	 	
		$('.clicker').click(function(){
			var key = $('#KeyId').val();
			
			var memberpilot = $('#'+"featurepilot"+key).val();
			if(memberpilot=="p"){
			    var confirmation_msg = "<?php echo __("deletePilot_blurb");?>";
				$('#confirm_pilot1').hide();
				$('#confirm_pilot2').show();
				$('#confirm_pilot2').html(confirmation_msg);
			}
			else{
				$('#confirm_pilot1').show();
				$('#confirm_pilot2').hide();
			}
			
			
		});
	 	
		});	
	
</script>

<!--######## Start  Save Leave Page Event #################-->
<?php $leaveStatus = Configure :: read('leaveStatus'); 
$activationusers = Configure::read('activationusers');
?>

 <?php if($leaveStatus[0]=="on") { ?>

<script language="JavaScript">
  var ids = new Array('GroupGroupName', 'GroupGroupDesc');
  var values = new Array('', '');
  
  function populateArrays()
  {
    // assign the default values to the items in the values array
    for (var i = 0; i < ids.length; i++)
    {
      var elem = document.getElementById(ids[i]);
      if (elem)
        if (elem.type == 'checkbox' || elem.type == 'radio')
          values[i] = elem.checked;
        else
          values[i] = elem.value;
    }      
  }



  var needToConfirm = true;
  
  window.onbeforeunload = confirmExit;
  function confirmExit()
  {
    if (needToConfirm)
    {
      // check to see if any changes to the data entry fields have been made
      for (var i = 0; i < values.length; i++)
      {
        var elem = document.getElementById(ids[i]);
        if (elem)
          if ((elem.type == 'checkbox' || elem.type == 'radio')
                  && values[i] != elem.checked)
            return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
          else if (!(elem.type == 'checkbox' || elem.type == 'radio') &&
                  elem.value != values[i])
            return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
      }

      // no changes - return nothing      
    }
  }
</script>
<?php } ?>

<div class="block top">
	<div id="overlay-errdor" class="notification first hide" style="width: 100%" >
	
		<div class="error">
			<div class="message">
				
			</div>
		</div>
	</div>
<?php if((isset($success)) && $success){?>
	
		<div class="notification first" style="width: 534px" >
		
			<div class="ok">
				<div class="message">
					<?php //echo $success;
					if(isset($_SESSION["group_created"])){
						
						
						echo __($_SESSION["group_created"]);
						
						unset($_SESSION["group_created"]);
					}
					
					   echo "&nbsp;";
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
	    echo $form->create('Group',array('action'=>'edit/group_id:' . $groupDetails['Group']['id'],'id'=>'edit','type'=>'POST', 'invalidate' => 'invalidate'));	   ?>
            <!-- <h4><?php echo __("Group Detail") ?><a data-title="Enter Group Name" data-placement="right" data-type="text" id="group_name" href="#" class="none" data-original-title="" title="" style="display: inline;"><?php echo $groupname?> <span style="padding-left:45px;"></span></a>
               <span style="float:right;" id="sts"><?php echo __('groupDn') . '' . $groupDetails['Group']['identifier']; ?></span>
            </h4>-->
  <h4><?php echo __("Group Detail") ?><?php echo $groupname?>
               <span style="float:right;" id="sts"><?php echo __('groupDn') . '' . $groupDetails['Group']['identifier']; ?></span>
            </h4>


 	    <div class="cb">
		
		<input type="hidden" name="group_id" id="group_id" value="<?php echo $groupDetails['Group']['id'];?>" />
		<div class="form-box">
		
		<div class="form-left" id="edit_stat_popupmenu" style="display: block">
              
          <div>
				<span  id="edit_stat" style="margin-left:15px; float:left;cursor:default;font-weight: bold;"<?php echo $readonly; ?>><?php __("GroupMadnEditOptions"); ?> </span>
		  </div>
				<br>
	      				   <ul style="margin: 0 0 0 14px">
							<li><?php echo $html->link( __('changedGroup',true),array('div'=>false, 'controller'=>'features', 'action'=>'edit/dn_id:'.  $groupDetails['Group']['identifier'] . '&featureType=DN_MADN&spg=edit_madn&lname=changedGroup'), array('class' => 'fancybox fancybox.ajax')); ?></li>
							
								<li><?php echo $html->link( __("Add Member", true),array('controller'=>'stations','action'=>'selectstation','group_id:'.$group_id .'&location_id='.$stationLocationid. '&type=singl&memcount='.$groupMemberscount),array('class'=>'fancybox fancybox.ajax')); ?></li>
							
							</ul>
		
		</div>
 			
		<div class="form-right">
					<?php 
					#echo '<div style="width:100px; float: left">' . __('groupId', true). '</div>';
					#echo $form->input("identifier", array('type'=>'hidden','value'=>$groupDetails['Group']['identifier']));
                                                               
                     echo __('groupMadnInfo_blurb');                                          

					?>

			</div>
</div>
		
		<div class="form-box">


			<!-- 
			<div class="form-left">
					<?php 
					echo '<div style="width:100px; float: left">' . __('groupName', true). '</div>';
                                        /*
                                         * 
                                         if($groupDetails['Group']['name']!="") {
					echo	$form->input('groupName', array('label' => false,'value'=>$groupDetails['Group']['name'],'style'=>'width:132px;','onkeyup'=>"chngbkcolor(this);"));
                                        }else {
					
					echo	$form->input('groupName', array('label' => false,'value'=>'Please enter Name','style'=>'width:132px;','onkeyup'=>"chngbkcolor(this);",'onfocus'=>'(this.value == "Please enter Name") && (this.value = "")','onblur'=>'(this.value == "") && (this.value = "Please enter Name")'));
                                        }
                                        */
                                        
                                        echo	'<p>' . $groupname. '</p>'?>
						?>		
			</div>
			-->
			<!--<div class="form-left">
					<?php 
					echo '<div style="width:100px; float: left">' . __('groupDesc', true). '</div>';
					echo	$form->input('groupDesc', array('label' => false,'value'=>$groupDetails['Group']['desc'],'style'=>'width:120px;','onkeyup'=>"chngbkcolor(this);"));	?>		
			</div>-->
		</div>
			<div class="block" style="margin: 0px;">
            <?php
            if($groupMemberscount>=16) {
?>
            
				<div class="button-left-readonly" >
					  <a href="javascript:;" onclick="submenuactivity(this,1)" ><?php __('Add Member'); ?></a>
                      <div class="table-menu">
                    			<div class="table-menu-popup" id="table-popup" style="z-index: 1">
                    				<ul>
                    				<li class="log">										
									<?php echo $html->link( __("No Members", true)); ?>											
									</li>
									
                    				</ul>
                    			</div>
             			</div>
               </div>
                <?php } else { 
				$grouplocationName=$this->Location->getgroupLocation($stationLocationid);
				$stationLocationName = $grouplocationName['Location']['name'];
				$stationLocationName = $groupArray['Location']['name'];
				?>
				<?php if($groupDetails['Group']['name']!="") { ?>
					
               			 <div class="button-left-hover" style="display: none;">
					  <?php #echo $html->link( __("Add Member", true),array('controller'=>'stations','action'=>'selectstation','group_id:'.$group_id .'&location_id='.$stationLocationName. '&type=single'),array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);','class'=>'fancybox fancybox.ajax')); ?>
						<?php echo $html->link( __("Add Member", true),array('controller'=>'stations','action'=>'selectstation','group_id:'.$group_id .'&location_id='.$stationLocationid. '&type=single&memcount='.$groupMemberscount),array('class'=>'fancybox fancybox.ajax , showhighlight_buttonright')); ?>
						</div>
				
                <?php } } ?>
				
				<?php if($groupDetails['Group']['name']!="") { ?>
				
				<!--<div class="button-right-disabled"  id="updateOdsentry">
					<a id="button" href="javascript:void(null)"  onclick="submi_form('edit');" name="data[filter]" value="filter" ><?php __("save");?></a>
				</div>-->
				<?php } else { ?>
				<!--<div class="button-right-hover"  id="updateOdsentry">
					<a id="button" class="showhighlight_arrow4" href="javascript:void(null)"  onclick="submi_form('edit');" name="data[filter]" value="filter" ><?php __("save");?></a>
				</div>-->
				<?php } ?>		
				
				
			</div>
        
		
		
		
	    <?php
		// check $stationFeatures variable exists and is not empty
		#echo "<pre>";print_r($stationLocation);
		//if(isset($groupMembers) && !empty($groupMembers)) : 
		
	    #???Added for testing. need to understand why this was added.
		if(1) :
		
		#echo "<pre>";print_r($groupMembers);
		$stationStatus = Configure :: read('stationStatus');
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
					$k=0;
					for($i=0;$i<=15;$i++){ //echo "<pre/>"; print_r($stationFeatures[$i]); 

						$memberAry = $groupMembers[$i];
					//foreach($stationFeatures as $station):
						// stripes the table by adding a class to every other row
						$class = ( ($i % 2) ? " class='altrow'": '' );
						// increment count
						//$count++;
						$k++;
						
					?>
				<tr style="height:23px;">
					<td  style="width: 20px;"> <?php echo $k; 
					
					
					?></td>
				</tr>
				<?php } //endforeach; ?>
		</table>
		<!--  Group Specific Section -->
		
		<table class="phonekey stationtb2" id="NOTdragdroptbl">
		<thead>
			<tr class="table-top">
				 <th class="table-column" align="left" ><?php echo __('memberStation')?></th>
				 <th class="table-column" align="left"><?php echo __('Key')?></th>
				 <th class="table-column" align="left"><?php echo __('memberPilot')?></th>
                 <th class="table-column filter-select filter-exact" data-placeholder="State" align="left"><?php echo __('memberLocation')?></th>
				 <th class="table-column filter-select filter-exact" data-placeholder="State" align="left"><?php echo __('DISPLAYNAME')?></th>
				 <th class="table-column filter-select filter-exact" data-placeholder="State" align="left"><?php echo __('memberState')?></th>
				 <th class="table-column" align="left"><?php //echo __('menu')?></th>
			 </tr>
		</thead>
				 <tbody>
				   <?php
					// initialise a counter for striping the table
					$memberArray = array(); 	echo $form->input("newaddedFeatues", array('type'=>'hidden','value'=>'','id'=>"newaddedFeatues"));
					$LocationArray =array();
					for($j=0;$j<=15;$j++){

					  	$groupArray = $groupMembers[$j]; //$setHeight = "";
						#echo "<pre>";print_r($groupArray);
						
					    $matches = explode('@', $groupArray['Feature']['stationkey_id']);
					    $stationkey_id = $matches[0];
					    $station_id = $matches[1];
						//foreach($stationFeatures as $station):
						// stripes the table by adding a class to every other row
						$class = ( ($j % 2) ? " class='altrow'": '' );
						if(isset($memberArray) && !empty($memberArray)) {
										$sta_id = str_pad($station_id[0], 2, '0', STR_PAD_LEFT);
						}else{
										$sta_id = str_pad($sta_id+1, 2, '0', STR_PAD_LEFT);			
                                       // $setHeight  = 'height:21px';										
						}
					#echo	$LocationArray[$station_id] = $station_id;
					#echo $station_id;
					 //$countNumStation = count($station_id)+1;
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
	                		#echo $station_id; 
	                		?>
					</td>
	                <td>
	                		<?php 
							//$DNID = $groupArray['Feature']['primary_value'];
							$DNID = $groupArray['Feature']['stationkey_id'];
							echo $form->input("featurevalue[$sta_id]", array('type'=>'hidden','value'=>$groupArray['Feature']['stationkey_id'])); 
							echo $form->input("featureNewPosition[$sta_id]", array('type'=>'hidden','value'=>$sta_id)); 
	                		
	                		#echo $html->link($stationkey_id,array('controller'=>'stations', 'action'=>'editstation',$station_id)); 
	                		echo $stationkey_id;
	                		?>
	                </td>
	                <td>
	                		<?php 
	              if ($grp_pilot[0]['stationkeys']['id'] == $groupArray['Feature']['stationkey_id'] && $groupArray['Feature']['stationkey_id'] != ''){
				  	echo "P";
							#echo __($groupArray['Feature']['pilot'],true);
							echo $form->input("featurepilot.$sta_id", array('type'=>'hidden','value'=>"p")); 
				  }
	                		
							echo $form->input("featurepilot[$sta_id]", array('type'=>'hidden','value'=>$groupArray['Feature']['PILOT'])); 
	                		?>
					</td>
                    <td>
	                		<?php 
							/*
							
							if($groupArray['Stationkey']['location_id']!=""){
							 $grouplocationName=$this->Location->getgroupLocation($groupArray['Stationkey']['location_id']);
							 echo $grouplocationName['Location']['name'];
							} else if(!empty($DNID)) {
								#echo "Unknown Location";
								#echo $station_id;
								#$grouplocationId=$this->Station->getgroupLocationid($station_id);
								
								#echo "<pre>";print_r($stationLocation);
								
								
								$grouplocationName=$this->Location->getgroupLocation($stationLocation[$groupArray['Stationkey']['station_id']]);
							    echo $grouplocationName['Location']['name'];
							    
								
							}
							
							*/
							#$grouplocationName = $groupModel[$groupArray['Station']['location_id']];
							$grouplocationName = $groupArray['Location']['name'];
							echo $grouplocationName;
							
							#echo $form->input("featurestatus[$sta_id]", array('type'=>'hidden','value'=>$groupArray['Feature']['status'])); 
	                		?>
					</td>
					<td>
	                		<?php 
							#echo __($groupArray['GROUP_PREMEMBER'],true);
							echo __($StationMemberDisplay[$groupArray['station']],true);
							echo __($StationMemberDisplay[$station_id],true);
							echo $form->input("featurestatus[$sta_id]", array('type'=>'hidden','value'=>$groupArray['Feature']['status'])); 
	                		?>
					</td>
					<td>
	                		<?php 
							#echo __($groupArray['Feature']['Station']['status'],true);
	                		echo __($stationStatus[$stationStates[$groupArray['Stationkey']['station_id']]],true);
							
							echo $form->input("featurestatus[$sta_id]", array('type'=>'hidden','value'=>$groupArray['Feature']['status'])); 
	                		?>
					</td>
					<td class="table-right" style="background: url(<?php
        	echo $this->webroot;
			?>/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat 3px 5px;border-right: 1px solid #D1D1D1!important;" onmouseout="this.className='table-right';" id="<?php
        	echo $sta_id;
			?>tdlast">
			<div class="table-menu">
            <div class="table-menu-popup" style="z-index: 1">
            <ul>
			<?php if(empty($DNID))
			{ ?>
				<li class="log">
				<?php
        		#echo $html->link(__('No Options', true), '');
				
				?>
				</li>
				 
				<li class="log">
				<?php echo $html->link( __("Add Member", true),array('controller'=>'stations','action'=>'selectstation','group_id:'.$group_id .'&location_id='.$stationLocationid. '&type=single&memcount='.$groupMemberscount),array('class'=>'fancybox fancybox.ajax ')); ?>
				</li>
				<?php 
		
			}
			else
			{
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
               
                if(($station_id !='') && ($stationStates[$groupArray['Stationkey']['station_id']] != 7)){ ?>
				
				
				<?php
				 if($stationkey_id != 1){
					if ($grp_pilot[0]['stationkeys']['id'] == $groupArray['Feature']['stationkey_id'] && $groupArray['Feature']['stationkey_id'] != '' ){  
					     
						if($groupMemberscount==1 ) {
							?>
							<li class="delete">
							<?php
							$groupstationKeyId = $groupArray['Feature']['stationkey_id'];
							echo $html->link( __("memberDelete", true),'javascript:void(null)', array('onmouseover'=>"javascript:InitGroup('".$groupstationKeyId."','$station_id','$sta_id')", 'escape'=>false,'title'=>'Delete','class'=>"clicker"));                        ?>
							</li>
							<?php
						}
				
					}
					else
					{  
					  ?>
					  <li class="delete">
					  <?php
						$groupstationKeyId = $groupArray['Feature']['stationkey_id'];
												  
						echo $html->link( __("memberDelete", true),'javascript:void(null)', array('onmouseover'=>"javascript:InitGroup('".$groupstationKeyId."','$station_id','$sta_id')", 'escape'=>false,'title'=>'Delete','class'=>"clicker")); 
					?>  
					</li>
					<?php } 
						}
					} 
				} ?>
            </ul>
            </div>
			</div>
		</td>
	    <?php } //endforeach; ?>
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
	<div class="modalPopLite-child popup-wrapper" id="popup-wrapper">
	<div class="black_overlay" style="display: none;"></div>
	    <h4><?php echo __('Confirmation',true); ?>
		<?php 
				 $groupMemberscount;
				if($groupMemberscount==1) {
					$confirmmsg = "groupLastMemberDeleteConfiramtion";			
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
	        <h6 style="margin-left:0px;" id="confirm_pilot1" ><?php echo __($confirmmsg);?></h6>
			<h6 style="margin-left:0px;" id="confirm_pilot2" ></h6> <br><br>
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
<input type="hidden" name="stationKeyId" id="stationKeyId" class="sid" value="">

<input type="hidden" name="grpmembercount" id="grpmembercount" value="<?php echo $groupMemberscount ?>">
<input type="hidden" name="KeyId" id="KeyId" class="sid" value="">
				 
				 
				  
		</table>
		
		<!--  End Group specific section -->
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
        	 <h3><?php __('groupMadnEdit') ?></h3>
                 <p><?php __('groupMadnEdit_blurb') ?></p>

                 <div class="table-right  tooltip" style="background: url(<?php echo $this->webroot; ?>/images/assets/icons/16px/045_information_02_cmyk.gif) no-repeat 2px 2px;">
                      <div>
                          <div class="fl"><span><?php echo $html->link('', '', array('onclick' => '')) ?></span>
                              <p><?php echo __('groupList') ?><br/><?php echo __('groupList_blurb') ?></p>
                          </div>
                      </div>
                  </div>
				
			<div id="shortcont">
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('fullcont')"  title=""><?php echo __('moreStart') ?></a>             
            </div>
            <div style="display:none;" id="fullcont_type"  >
               <p  ><?php echo __('groupMadnEdit_helpText') ?></p>
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
</script>
<?php if($leaveStatus[0]=="on") { ?>
<script language="JavaScript">
  populateArrays();
</script>
<?php } ?>
