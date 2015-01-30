<script type="text/javascript">
	$(document).ready(function() {
		$("#PotentryEditForm input[type='submit']").click(function() {
			$('#errorMessageLinePage, #errorMessageLineNumber').empty();

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
		          $('#PotentryEditForm #errorMessageLinePage').html(response.failure.page);
		          $('#PotentryEditForm #errorMessageLineNumber').html(response.failure.linenumber);
		        }

		      }
		    });

		    return false;	
		})
		
	});
</script>
<div class="potentries form">
<?php echo $form->create('Potentry');?>
	<fieldset>
		<legend><?php __('Edit Potentry'); ?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('tag_id');
		echo $form->input('page', array(
          'label' => array(
            'text' => 'Page<div id="errorMessageLinePage"></div>'
          )));
		echo $form->input('linenumber', array(
          'label' => array(
            'text' => 'Line Number<div id="errorMessageLineNumber"></div>'
          )));
		//echo $form->input('createdBy');
		echo $form->input('status', array('type' => 'checkbox'));
		echo $form->submit('Submit', array('class' => 'btn', 'style'=>'height:40px;'));
	?>
	</fieldset>
<?php echo $form->end();?>
</div>