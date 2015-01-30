<script type="text/javascript">
	$(document).ready(function() {
		$("#TransentryAddForm input[type='submit']").click(function() {
			$('#TransentryAddForm #errorMessageTranslation').empty();

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
		      	console.log(response);
		      			    
		        if (response.success == 'true') {       
		          window.location.href = rootUrl + 'tags';
		        } else {
		          $('#TransentryAddForm #errorMessageTranslation').html(response.failure.translation);        
		        }

		      }
		    });

		    return false;	
		})
		
	});
</script>

<div class="transentries form">
<?php echo $form->create('Transentry');?>
	<fieldset>
		<legend><?php __('Add Transentry'); ?></legend>
	<?php	
		echo $form->input('tag_id', array('options' => $tag, 'default' => $tagId));
		echo $form->input('language');
		echo $form->input('translation', array(
          'label' => array(
            'text' => 'Translation<div id="errorMessageTranslation"></div>'
          )));
		//echo $form->input('createdBy');
		//echo $form->input('modifiedBy');
		echo $form->input('status', array('type' => 'checkbox'));
		echo $form->submit('Submit', array('class' => 'btn', 'style'=>'height:40px;'));
	?>
	</fieldset>
<?php echo $form->end();?>
</div>