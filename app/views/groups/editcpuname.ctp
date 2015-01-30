
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
	        'GroupGroupName':{
	            'required': true,
	            'max': '50'
	            //'max': '30'
	        }, 
			 
	                            
	    },                  
	    // Specify the validation error messages
	    'messages': {  
	        'GroupGroupName': {
	             'required': "<?php __('GroupNameNotempty')  ?>",
	             'max': "<?php __('max50')  ?>"
	         },
			
	           	         
	    },
	  };
  //$(".loading").html('<img alt="" src="<?php echo Configure::read('base_url');?>img/assets/ajax-loader.gif">');
					 
  if (inValidate(validation)) {  	
    return false;
  } else {
  
  $('.black_overlay').css('display','block');
  $.fancybox.showLoading()  ;
  
    var groupid =  $('#groupid').val();
	var groupname =  $('#GroupGroupName').val();
    var groupdesc =  $('#GroupGroupDesc').val();
	var TargetURL = "<?php echo Configure::read('base_url');?>groups/editcpuname/group_id:"+groupid+"/groupdesc:"+groupdesc+"/group_name:"+groupname;
	  
   //setTimeout(function() {
   	 
      $('.dnForm').attr('action',base_url+'features/updateDN/<?php echo $stationkey_id;?>');
      $('.dnForm').attr('method','POST');
	  $.fancybox.showLoading()  ;
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
				  $('#GroupGroupDesc').removeClass( "form-change" );
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
                                'action' => 'editcpuname',
                                'id' => 'editcpuname',
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
		
		<h4><?php echo __('Edit CPU Details'); ?>
		 <div class='demonstrations'>
           <div  style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick=" setTimeout( function() {     
					$('.fancybox-overlay').trigger('click');
					 },5); UnTip();">X</a></div>
	        <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onclick="Tip('<b><?php echo __('cpueditForm_helpTitel') ?></b><br/><?php echo __('cpueditForm_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>		
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
					
					echo	$form->input('groupName', array('label' => false,'value'=>$groupDetails['Group']['name'],'style'=>'width:140px;','onkeyup'=>'chngbkcolor(this)','placeholder'=>'Please enter Name'));
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
					echo	$form->input('groupDesc', array('label' => false,'rows'=>'5','cols'=>'45','value'=>$groupDetails['Group']['desc'],'style'=>'width:140px;','onkeyup'=>'chngbkcolor(this)')) ;?>	
					<input type="hidden" name="groupid" id="groupid" value="<?php echo $group_id; ?>">	
				</div>
			  </div><br/>
			  <div class="form-box">
			  <div class="form-left table-menu">
					&nbsp;
				</div>
				<div class="form-right table-menu" style="vertical-align: top;margin-top:<?php echo $top; ?>px;">
					<?php echo __('editcpuInfo',true); ?>
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

