<?php
$user_agent = $_SERVER['HTTP_USER_AGENT']; 
if (preg_match('/MSIE/i', $user_agent)) { 
$top = "-103";
$buttontop = "90";
}
else{
$top = "-108";	

}
if (preg_match('/Firefox/i', $user_agent)) { 
       $top = "-126";		
       
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
	$('#ScenarioScenarioDesc').removeClass( "form-change" );	

	$('.validate_msg').removeAttr("id");

	// $("#ScenarioScenarioName").keypress(function(e) {	
	// 	if (e.which == 32) {
	// 		return false;
	// 	}     
	// });
	
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
	        'ScenarioScenarioName':{
	            'required': true,
	            'max': '50',
	            'notSpace' : true
	            //'max': '30'
	        }, 
			 
	                            
	    },                  
	    // Specify the validation error messages
	    'messages': {  
	        'ScenarioScenarioName': {
	             'required': "<?php __('ScenarioNameNotempty')  ?>",
	             'max': "<?php __('max50')  ?>",
	             'notSpace': "<?php __('spaceNotAllowed')?>",
	         },
			
	           	         
	    },
	  };
  //$(".loading").html('<img alt="" src="<?php echo Configure::read('base_url');?>img/assets/ajax-loader.gif">');
					 
  if (inValidate(validation)) {  	
    return false;
  } else {
  
   $('.duplicate').css('display','block');
   $.fancybox.showLoading()  ;
  
    var scenarioid =  $('#scenarioid').val();
	var scenarioname =  $('#ScenarioScenarioName').val();
    var scenariodesc =  $('#ScenarioScenarioDesc').val();
	
	var TargetURL = "<?php echo Configure::read('base_url');?>Scenarios/editscenarioname/scenario_id:"+scenarioid+"/scenariodesc:"+scenariodesc+"/scenario_name:"+scenarioname;
	  
   //setTimeout(function() {
      	setTimeout(function(){ 
	  $.ajax({
          type: "POST",
          async : false,
          url: TargetURL,
          success: function(result){  
		  setTimeout(function() {
		  	
		  	$.fancybox.showLoading()  ;
            window.location.reload();
        }, 1000);       
 		$.fancybox.showLoading()  ;	 
          }
      });
	  },100);
	 
     
	//},6000); 
	
  }   
              //jQuery('#cboxClose').click();
        //location.reload();
}//end submitForm
		
		  function chngbkcolor(obj) {
			  $(document).ready(function() {
				  $('#button').attr("class", "showhighlight_buttonleft");
				  $('#updateStation').removeAttr("class");
				  $('#button').removeAttr("onmouseover");
				  $('#button').removeAttr("onmouseout");
				  $('#updateStation').attr("class", "button-right-hover");
				  $('#button').attr("onclick","submitForm()");
				  $('#scenarioscenarioDesc').removeClass( "form-change" );
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


	echo $form->create('Scenario', array(
                                'action' => 'editcpuname',
                                'id' => 'editcpuname',
                                'class' => 'dnForm',
                                'type' => 'POST',
								'invalidate' => 'invalidate',
								'autocomplete'=>'off'
));



	#echo $form->create(null, array('id' => 'featureEditForm', 'url' => '/features/update/'.$features[0]['Feature']['id'],'accept-charset'=>'ISO-8859-1'));
	?>	
	<div class="black_overlay duplicate"  style="display: none;"></div>
	
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
		
		<h4><?php echo __('Edit Scenario Details'); ?><span><?php echo $scenarioDetails['Scenario']['Name'];  ?></span>
		 <div class='demonstrations'>
           <div  style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick=" setTimeout( function() {     
					$('.fancybox-overlay').trigger('click');
					 },5); UnTip();">X</a></div>
	        <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onclick="Tip('<b><?php echo __('scenarioEditForm_helpTitel') ?></b><br/><?php echo __('scenarioEditForm_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>		
 		  </div>
		</h4>
		<div class="form-body">
			
			
			  <div class="form-box">
				<div class="form-left table-menu">
					<?php 
					echo '<div class="form-label">';  
					echo __('scenarioName'); 
					
					echo '</div>';
					?>
					
					<?php
					
					echo	$form->input('scenarioName', array('label' => false,'value'=>$scenarioDetails['Scenario']['Name'],'style'=>'width:140px;','onkeyup'=>'chngbkcolor(this)','placeholder'=>'Please enter Name'));
					?>		
					
				</div>
			  </div>
			  <div class="form-box">
			  <div class="form-right table-menu">
					<?php 
					echo '<div class="form-label">';  
					echo __('scenarioDesc'); 
					echo '</div>'; ?>
					
					<?php
					echo	$form->input('scenarioDesc', array('label' => false,'rows'=>'5','cols'=>'45','value'=>$scenarioDetails['Scenario']['remark'],'style'=>'width:140px;','onkeyup'=>'chngbkcolor(this)')) ;?>	
					<input type="hidden" name="scenarioid" id="scenarioid" value="<?php echo $scenario_id; ?>">	
				</div>
			  </div><br/>
			  <div class="form-box">
			  <div class="form-left table-menu">
					&nbsp;
				</div>
				<div class="form-right table-menu" style="vertical-align: top;margin-top:<?php echo $top; ?>px;">
					<?php echo __('editScenarioInfo',true); ?>
				</div>
				
			  </div>
		<br/>
		 
           <fieldset style="display:none;">
              <input type="hidden" name="_method" value="PUT" />
            </fieldset>
            <?php if(!(isset($error) && $error)){?>
     		<div class="button-right-disabled" id="updateStation">
              <a id="button" href="javascript:;"  onclick="submitForm();" name="submitForm" value="submitForm" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __("editMember"); ?></a>
            </div>
            <?php }?>	
	</div>
	
   
	 
          
     </div>          
  </div>

   <!--ight hand side  ends here-->

</form>
<h3><span class="alert alert-error overlay-error hide"></span></h3>

