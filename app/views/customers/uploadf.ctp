
 <?php

						$user_agent = $_SERVER['HTTP_USER_AGENT']; 
						if (preg_match('/MSIE/i', $user_agent)) { 
						?>
						<style>

						#sumbitUpload{
										 margin-left:15px !important;
							             
						               }
						</style>
					 
						<?php 
						}
						else{
							?>
							<style>

						#sumbitUpload{
							            margin-left:15px !important;
						               }
						</style>
						
							<?php
		                    }
						if (preg_match('/Firefox/i', $user_agent)) { 
						  ?>  
							<style>

						#sumbitUpload{
							             margin-right:15px !important;
						                }
						</style>
						 
						  
						  <?php   
						    }
							
						?>


<?php 

echo $javascript->link('/js/jquery.fancybox');

?>
	
<script type="text/javascript">
   
   function chngbkcolor(obj) {
			  $(document).ready(function() {
			  	
				  jQuery('#button').attr("class", "showhighlight_buttonleft");
				  jQuery('#sumbitUpload').attr("class", "button-right-hover");

			  });
		  }
		  
		  
		  function submitUploadForm(){
	 $(document).ready(function() {
	 	
	          //$('#CustomersUploadfForm').submit();
		$('body').on('click', '#button', function(e){	  
			  
		$('body').unbind('click','#button');	
          e.preventDefault();
		  e.stopPropagation();
		  $('.black_overlay').css('display', 'block');
	    $.fancybox.showLoading();
        var formData = new FormData($(this).parents('form')[0]);
       
        $.ajax({
            url: '<?php echo Configure::read('base_url') ?>Customers/uploadf',
            type: 'POST',
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                return myXhr;
            },
            success: function (data) {
				
				
				  $('#msgNoticefication').html(data);
				  
				   $('.black_overlay').css('display', 'none');
				   $('#fancybox-loading').hide();
				  
					//$('#overlay-error .error .message').text("<?php __('Maximum file size => 10M') ?>");
                   //$('#overlay-error').removeClass('hide');
             
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
        
        
       
		return false;
     });
	 
	 });
	}
	/*
 function submitUploadForm(){
	 $(document).ready(function() {
	 	
	          $("#CustomersUploadfForm").submit();
			  });
	}
	*/
</script>
<style>
	#black_overlay_loading {
    left: 150px!important;
    position: absolute !important;
    top: 50px!important;
    z-index: 1002;
}
.black_overlay{
	background-color: #000000;
    display: none;
    height: 100%;
    left: 0;
    opacity: 0.5;
    position: absolute;
    top: 0;
    width: 100%;
    z-index: 1001;
}
.form-label{
	width: 90px !important;
}
.form-box .form-left{
	width:300px !important;
}
</style>

<div class="black_overlay" style=" display: none;">
        
    </div>
<div id="msgNoticefication" style="width: 100%">
	
	
</div>

<?php
if((isset($success)) && $success){?>
	
		<div class="notification first" style="width: 100%!imporatant;" >		
			<div class="ok">
				<div class="message">
					<?php echo $success;?>
				</div>
			</div>
		</div>
		
	<?php }elseif(isset($error) && $error){?>
		<div class="notification first" style="width: 100%!imporatant;">
			<div class="error">
				<div class="message">
					<?php 
						#echo $error;
						if($error=='xml_not_respond')
							_("Xml Server is not responding");
						else
							__("There was a problem in applying the changes.");
					?>
				</div>
			</div>
		</div>
	<?php }


?> 
    <?php
 
echo $form->create('Customers', array(
'action' => 'uploadf',
'type' => 'file'
)); ?>
	<div id="content" class="cb" style="width:650px;height: 150px;">
	  <h4 ><?php __('Uploadform')?>
	  
	  	<div class='demonstrations'>
           <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="setTimeout( function() { 	$('.fancybox-overlay').trigger('click'); },5); UnTip();">X</a></div>
	        <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onMouseOver="Tip('<b><?php echo __('selectUpload_helpTitel') ?></b><br/><?php echo __('selectUpload_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>		
    		
 		</div>
	  
	  </h4>
      <p>
	  <div>
	    <div style="float:left;width:350px;margin: 0;padding: 0;">	
		
		
	 
	    <div class="form-box">
		<div class="form-left">
			<?php 
						echo '<div class="form-label">';
						echo __('Upload');
						echo '</div>';
						echo $form->input('image_name', array('type'=>'file', 'label' => false,'onchange'=>'chngbkcolor(this)','style'=>'height:auto !important;'));
						echo $form->input('CustomerId', array('type'=>'hidden','value'=>$customer_id, 'label' => false,'style'=>'height:auto !important;'));
			?>
				  
        </div>
		</div>
		</div>
		<div style="float:right;width: 256px;">
		<div class="form-right" >
		
			<p><?php echo __('uploadCustomer_blurb')?></p>
		</div>
	    </div>
		
     </div>
     </p>
	 </div>
	<div class="cb" style="width:660px;height:50px;">
	 <div class="form-right">
		 <div class="button-right" id="sumbitUpload" style="margin-top: 25px !important;">
			<?php echo $html->link(__("uploadButton", true), 'javascript:void(null)', array('onclick'=>'javascript:submitUploadForm();','class'=>'','id'=>'button')); ?>		
     	 </div>  
        </div>	
	</div>
 
<?php echo $form->end(); ?>