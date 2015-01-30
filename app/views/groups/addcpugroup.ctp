<?php
$user_agent = $_SERVER['HTTP_USER_AGENT']; 
if (preg_match('/MSIE/i', $user_agent)) { 
$top = "-122";
$buttontop = "90";
}
else{
$top = "-130";	
$buttontop = "-25";
}
if (preg_match('/Firefox/i', $user_agent)) { 
       $top = "-155";	
       $buttontop = "-25";
    }
?>

<style>

.table-menu-popup {
    display: none;
    float: left !important;
    margin-left: -24px;
    margin-top: 3px;
    padding: 0;
    position: absolute;
}
.table-menu-popup li {
    position: relative;
    text-align: left;
    margin: 0;
    padding: 0;
    width: 13px;
}
.fancybox-inner{
	height: auto !important;
    overflow: auto;
   
}
.table-menu-popup li a, .table-menu-popup li a:link, .table-menu-popup li a:visited, .table-menu-popup li a:active {
    border-left: 0px solid #001155!important;
    border-right: 0px solid #001155!important;
    border-top: 0px solid #001155!important;
    padding: 2px 0 0 25px;
}
.table-menu-popup ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    width: 80px!important;
}
.greyed {
    background-color: #FF0000!important;
}
form .error, form .error:focus {
    border-color: #1047e0;
}
form .form-change {
    background-color: #CCCCCC !important;
    outline: 1px solid #CCCCCC !important;
}
</style>
<script>
$(document).ready(function(){
$('#button').removeAttr("onclick","");
$('#button').attr("onclick","noinfo()");
$('#GroupGroupDesc').removeClass( "form-change" );	
	
});
</script>

<script>
	function noinfo(){
				
		$('#overlay-error .error .message').text("<?php __('no changes entered') ?>");
		$('#overlay-error').removeClass('hide');
	}
</script>

<script>


function submitForm(){
	
	validation = {
	    // Specify the validation rules
	   
	    'rules': {                     
	        'drp':{
	        	'required' : true,
	            
	        }, 
			'GroupGroupName':{
	            'required': true,
	            	            
	        }, 
			 
	                            
	    },                  
	    // Specify the validation error messages
	    'messages': {  
	        'drp': {
	             'required': "<?php __('locationNotempty')  ?>",
	            
	         },  
			'GroupGroupName': {
	             'required': "<?php __('GroupNameNotempty')  ?>",
	             
	         },
			  
	           	         
	    },
	  };
	
	if (inValidate(validation)) {  	
		    return false;
		} else {  
  $('.black_overlay').css('display','block');
  $.fancybox.showLoading()  ;
  
    var groupLocationId =  $('#drp option:selected').val();	
	var groupname =  $('#GroupGroupName').val();
    var groupdesc =  $('#GroupGroupDesc').val();	
	
	var TargetURL = "<?php echo Configure::read('base_url');?>groups/addcpugroup/groupLocationId:"+groupLocationId+"/groupdesc:"+groupdesc+"/group_name:"+groupname+"/grouptype:cpu&customer_id=<?php echo $SELECTED_CNN ?>";
	
 //window.location.href = TargetURL;
     	 
     $('.dnForm').attr('action',base_url+'groups/addcpugroup/');
      $('.dnForm').attr('method','POST');
	  $.fancybox.showLoading()  ;
      	 
	  $.ajax({
          type: "POST",
          async : false,
          url: TargetURL,
          success: function(result){ 
		  var msg = result.split(':');
		  var groupid = msg[0];
		  var locname = msg[1];        
 			var path = trim(groupid +"&location_id="+locname+"&type=single&memcount=0");			
			var TargetURL2 = "<?php echo Configure::read('base_url'); ?>stations/selectstation/group_id:"+path;			
			$("#select_station").attr('href',TargetURL2);			
		    $("#select_station").trigger("click");
						
          }
      });
	 
	}
	
   
}//end submitForm
		
		  function chngbkcolor(obj) {
			  $(document).ready(function() {
			  	
				  $('#button2').attr("class", "showhighlight_buttonleft");
				  $('#button2').prop("class", "showhighlight_buttonleft");
				  $('#button2').addClass("showhighlight_buttonleft");				  
				  $('#updateStation').removeAttr("class");				  
				  $('#updateStation').attr("class", "button-right-hover");
				  $('#GroupGroupDesc').removeClass( "form-change" );
				  //$('#button').attr("onclick","submitForm()");
			  });

			//called when key is pressed in textbox
			    $("input.numeric_check").keypress(function(e) {	
			      if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57) && e.which!=13)
			      {        
			        $('#overlay-error .error .message').text("<?php __('digitsOnly') ?>");
			        $('#overlay-error').removeClass('hide');
			        return false;
			      } else {
			      		//$("input").keydown(function() {
				          inValidate(validation, 'keyup');                    
				        //});		
			      }
			    });
		  }
	
	//By creating tooltips after DOM load we make sure that referenced elements are available.
		
</script>
	

<?php 


	echo $form->create('Group', array(
                                'action' => 'addcpugroup',
                                'id' => 'addcpugroup',
                                'class' => 'dnForm',
                                'type' => 'POST',
								'invalidate' => 'invalidate',
								'autocomplete'=>'off'
));



	#echo $form->create(null, array('id' => 'featureEditForm', 'url' => '/features/update/'.$features[0]['Feature']['id'],'accept-charset'=>'ISO-8859-1'));
	?>	
	<div class="black_overlay"  style="display: none;"></div>
	
	<div class="block top">
		  	
		
		<div id="overlay-error" class="notification first hide" style="width: 100%" >
		
			<div class="error">
				<div class="message">
					
				</div>
			</div>
		</div>
		
	<?php if((isset($inProgress)) && $inProgress){?>
		<div class="notification first" style="width: 534px" >
		
			<div class="ok">
				<div class="message">
					IN WORK
				</div>
			</div>
		</div>
		
	<?php 
	#CBM TEST
	} ?>
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
		}?>
		
 
	<div id="newEdit">
		
		<h4 style="width: 543px;"><?php echo __('Create CPU Details'); ?>
		 <div class='demonstrations'>
           <div  style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick=" setTimeout( function() {     
					$('.fancybox-overlay').trigger('click');
					 },5); UnTip();">X</a></div>
	        <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onclick="Tip('<b><?php echo __('cpuaddForm_helpTitel') ?></b><br/><?php echo __('cpuaddForm_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>		
 		  </div>
		</h4>
		<div class="form-body">
			
			
			  <div class="form-box">
				<div class="form-left table-menu">
					<?php 
					echo '<div class="form-label">';  
					echo __('groupName'); 
					
					echo '</div>';
					?>
					
					<?php
					
					echo	$form->input('groupName', array('label' => false,'value'=>$groupDetails['Group']['name'],'style'=>'width:140px;','onkeyup'=>'chngbkcolor(this)'));
					?>		
					
				</div>
			  			  
			  </div>
			  <div class="form-box">
			  	
				
				<div class="form-right table-menu">
					<?php 
					echo '<div class="form-label">';  
					echo __('Location'); 
					echo '</div>'; ?>
					
					<?php
					
					
					echo $form->select('location_id', $locations,$locations,array('label'=>false, 'style'=>'width:146px;margin-top:-1px','id'=>'drp'));
					
					 ?>	
					
				</div>
				
				
				
				</div>
				<div class="form-box">
				
				<div class="form-right table-menu">
					<?php 
					echo '<div class="form-label">';  
					echo __('groupDesc'); 
					echo '</div>'; ?>
					
					<?php
					echo	$form->input('groupDesc', array('label' => false,'rows'=>'5','cols'=>'45','value'=>$groupDetails['Group']['desc'],'style'=>'width:140px;','onkeyup'=>'chngbkcolor(this)')) ;
					
										
					?>	
					<input type="hidden" name="groupid" id="groupid" value="<?php echo $group_id; ?>">	
				</div>
				
			  </div>
			  
			  <div class="form-box">
			   <div class="form-left table-menu">
					&nbsp;
				</div>
				<div class="form-right table-menu" style="vertical-align: top;margin-top:<?php echo $top; ?>px;">
					<?php echo __('addcpuInfo',true); ?>
				</div>
				
			  </div>
		 
           <fieldset style="display:none;">
              <input type="hidden" name="_method" value="PUT" />
            </fieldset>
            <?php if(!(isset($error) && $error)){?>
     		<div class="button-right-disabled" id="updateStation" style="margin-left: 150px !important;float:right;">
              <a id="button2" href="javascript:;" onclick="submitForm();" name="submitForm" value="submitForm" ><?php __("addMember"); ?></a>
            </div>
            <?php }?>
          	  
			
	</div>
	
    
	
     </div>          
  </div>

   <!--ight hand side  ends here-->

</form>
<h3><span class="alert alert-error overlay-error hide"></span></h3>

