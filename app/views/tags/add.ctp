<script type="text/javascript">
	$(document).ready(function() {
		$("#TagAddForm input[type='submit']").click(function() {
			
			$('#TagAddForm #errorMessageOriginal, #errorMessageType, #errorMessageComment').empty();

			if ($("#TagOriginalTag").val() == '') {				
				$('#TagAddForm #errorMessageOriginal').html("Please enter original tag");
				return false;
			}
			if ($("#TagType").val() == '') {				
				$('#TagAddForm #errorMessageType').html("Please enter type");
				return false;
			}
			if ($("#TagComment").val() == '') {				
				$('#TagAddForm #errorMessageComment').html("Please enter comment");
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
		          //$('#TagAddForm #errorMessageOriginal').html(response.failure.original_tag);
		          //$('#TagAddForm #errorMessageType').html(response.failure.type);
		          //$('#TagAddForm #errorMessageComment').html(response.failure.comment);
		        }

		      }
		    });

		    return false;	
		})
		
	});
</script>

<div>
<?php echo $form->create('Tag');?>
	<fieldset>
		<legend><?php __('Add Tag'); ?></legend>
	<?php
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
