<script type="text/javascript">
	$(document).ready(function() {		
		$("#TransentryEditForm input[type='submit']").click(function() {
			$('#TransentryEditForm #errorMessageTranslation').empty();

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
		          $('#TransentryEditForm #errorMessageTranslation').html(response.failure.translation);        
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
		<legend><?php __('Edit Transentry'); ?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('tag_id', array('options' => $tag, 'default' => $this->data['Transentry']['tag_id']));
		?>
		<div class="input text">
			<label for="TransentryTranslation">Language</label>
			<h5><?php echo $languages[$this->data['Transentry']['language']]; ?></h5>
		</div>
		<?php		
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
