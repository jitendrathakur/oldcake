<script type="text/javascript">
	$(document).ready(function() {
		$("#TagEditForm input[type='submit']").click(function() {
			
			$('#TagEditForm #errorMessageOriginal, #errorMessageType, #errorMessageComment').empty();

			if ($("#TagOriginalTag").val() == '') {				
				$('#TagEditForm #errorMessageOriginal').html("Please enter original tag");
				return false;
			}
			if ($("#TagType").val() == '') {				
				$('#TagEditForm #errorMessageType').html("Please enter type");
				return false;
			}
			if ($("#TagComment").val() == '') {				
				$('#TagEditForm #errorMessageComment').html("Please enter comment");
				return false;
			}
			var form = $(this).parents('form:first');
		    var data = form.serialize();
		    var action = form.attr('action');

		    $.ajax({
		      type: "POST",
		      url: action,
		      data: data,
		      cache: true,
		      dataType: "json",
		      success: function(response) {   
		      			    
		        if (response == true) {       
		          window.location.href = base_url + 'tags&lang=<?php echo $lang ?>';
		        } else {
		          //$('#TagEditForm #errorMessageOriginal').html(response.failure.original_tag);
		          //$('#TagEditForm #errorMessageType').html(response.failure.type);
		          //$('#TagEditForm #errorMessageComment').html(response.failure.comment);
		        }

		      }
		    });

		    return false;	
		})
		
	});
</script>

<style>
div[id*='errorMessage'] {
	color:red;
	float: right;
}
</style>
<div class="tags form">
<?php echo $form->create('Tag');?>
	<fieldset>
		<legend><?php __('Edit Tag'); ?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('original_tag', array(
          'label' => array(
            'text' => 'Original Tag<div id="errorMessageOriginal"></div>'
          )));
		$option = array('user' => 'User', 'code' => 'Code', 'zombie' => 'Zombie');
		echo $form->input('type', array('options' => $option));
		echo $form->input('comment', array(
          'label' => array(
            'text' => 'comment<div id="errorMessageComment"></div>'
          )));
		//echo $form->input('createdBy');
		//echo $form->input('modifiedBy');
		$option = array('1' => 'Active', '0' => 'Inactive');
		echo $form->input('status', array('options' => $option));
		echo $form->submit('Submit', array('class' => 'btn', 'style'=>'height:40px;'));
	?>
	</fieldset>
<?php echo $form->end();?>
</div>
