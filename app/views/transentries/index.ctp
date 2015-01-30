<script type="text/javascript">
$(document).ready(function() {

	$(".transentries .edit").dblclick(function() {
		$(this).find("input, select").removeClass('hide');
		$(this).find('span').text('');
	});

	$("input[type='text']").keypress(function (e) {
	  if (e.which == 13) {
	  	//alert("dfdf");
	  	$(this).parents('form:first').find('#push').trigger('click');
	   // $(this).find('#push').trigger('click');
	    return false;
	  }
	  
	});

	validation = {
      // Specify the validation rules
      'rules': {                      
          //'TransentryTranslation': "required",
          'TransentryTranslation': {
              'required': true,
              'checkStr': '$'
          },                     
      },                  
      // Specify the validation error messages
      'messages': {                      
          //'TransentryTranslation': "<?php echo __('Translation could not be empty') ?>",
          'TransentryTranslation': {
              'required': "<?php echo __('Translation could not be empty') ?>",
              'checkStr': "<?php echo __('Translation should not contain $ character') ?>"
          },                      
      },
    };

	$(".transentries #push").click(function() {	
			
		var form = $(this).parents('form:first');
		var invalidate = form.attr("invalidate");
	      if (typeof invalidate != "undefined") {
	        if (inValidate(validation)) {
	          return false;
	        }
	      }   
	    var data = form.serialize();
	  	var action = form.attr('action');
	  	var formId = form.attr('id');
	    

	    $.ajax({
	      type: "POST",
	      url: action,
	      data: data,
	      cache: true,
	      success: function(response) {	      	
	        if (response.trim() == 'true') {   
	        	window.location.href = base_url + 'tags';	        	
	        } else {
	        	$(".alert-error").removeClass('hide');
	        	$(".alert-error").text(response);	          
	        }

	      }
	    });

	    return false;	

	});
	
} );



function inValidate(validation) {

  $(".alert-error").text("");
  //$('.help-inline span').closest('.control-group').removeClass('error'); 
  var invalid = false; 
  $.each(validation.rules, function( index, value ) {
   
    if (typeof value === 'string') {    	
      if (value == 'required') {
        if ($("#"+index).val() == '') {        
          $(".alert-error").text(validation.messages[index]);          
          $(".alert-error").removeClass('hide');          
          invalid = true;         
        }
      }  
    } else {    	
      $.each(value, function( rule, expression ) {
        if (rule == 'required') {
          if ($("#"+index).val() == '') {
            $(".alert-error").text(validation.messages[index][rule]);
            $(".alert-error").removeClass('hide');
            invalid = true; 
            return false;                 
          }
        } else if (rule == 'min') {
          if ($("#"+index).val() < expression) {
            $(".alert-error").text(validation.messages[index][rule]);
            $(".alert-error").removeClass('hide');
            invalid = true;  
            return false;           
          }
        } else if (rule == 'checkStr') {        	
        	var str = $("#"+index).val();
        	if (str.indexOf("$") != -1) {
        		invalid = true;        		
        		$(".alert-error").text(validation.messages[index][rule]);
            	$(".alert-error").removeClass('hide');
        	}        	
        	return false;			
        }
      });
    }                
  }); 
  return invalid;
 
}//end inValidate()

</script>

<style>

input[type='text'] {
	width:70px;
} 

.grid {	
    float: left;
    text-align: center;
    width: 70px;
    height: 30px;
    border-left: 1px solid #DDDDDD;
    border-top: 1px solid #DDDDDD;
}

.grid2 {	
    float: left;
    text-align: center;
    width: 100px;
    height: 30px;
    border-left: 1px solid #DDDDDD;
    border-top: 1px solid #DDDDDD;
}
.grid3 {	
    float: left;
    text-align: center;
    width: 140px;
    height: 30px;
    border-left: 1px solid #DDDDDD;
    border-top: 1px solid #DDDDDD;
}

form {
	margin:0;
}

</style>

<h3>Transentries : <?php echo $tag['Tag']['original_tag'] ?></h3>

<div class="span10">

	<div class="row">

		<div class="grid"><strong>Language</strong></div>
		<div class="grid2" style="width:400px"><strong>Translation</strong></div>
		<div class="grid"><strong>Status</strong></div>
		<div class="grid"><strong>Action</strong></div>
	</div>
	<?php
	$i = 0;
	foreach ($languages as $key => $language):	
	echo $form->create('Transentry', array('id' => 'TransentryAddForm'.$i, 'invalidate' => 'invalidate'));
		echo $form->input('tag_id', array('type' => 'hidden', 'value' => $tag['Tag']['id'])); 
		echo $form->input('id', array('type' => 'hidden', 'value' => $transentries[$i]['Transentry']['id']));
		#echo $form->input('comment', array('type' => 'text', 'class' => 'hide', 'label' => false, 'value' => $transentries[$i]['Transentry']['comment'])); 
				         
		?>
		         
		
		<div class="row transentries">

		  <form class="form-horizontal">
		    
		    <div class="grid">
		      <fieldset>
		        
		        <div class="control-group">
		         
		          <div class="controls">
		            <span><?php echo $language; ?></span>
		            <?php echo $form->input('language', array('type' => 'hidden', 'value' => $key)); ?>
		          </div>
		        </div>
		      </fieldset>
		    </div>
		    <div class="grid2 edit" style="width:400px">
		      <fieldset>
		        
		        <div class="control-group">
		         
		          <div class="controls " style="width:400px">
		            <span class="TransentryTranslation truncate" title="Double click to edit"><?php echo !empty($transentries[$i]['Transentry']['translation']) ? $transentries[$i]['Transentry']['translation'] : "NA"; ?></span>
					<?php echo $form->input('translation', array('type' => 'text', 'class' => 'hide', 'style'=>'width:390px;', 'label' => false, 'value' => $transentries[$i]['Transentry']['translation'])); ?>

		          </div>
		        </div>
		      </fieldset>
		    </div>
		    
		  
		    <div class="grid edit">
		      <fieldset>
		        
		        <div class="control-group">
		         
		          <div class="controls ">
		            <span class="TransentryStatus" title="Double click to edit"><?php echo ($transentries[$i]['Transentry']['status']) ? 'Active' : 'Inactive'; ?></span>
					<?php //$checked = ($transentries[$i]['Transentry']['status']) ? 'checked' : ''; ?>
					<?php //echo $form->input('status', array('type' => 'checkbox', 'class' => 'hide', 'label' => false, 'checked' => $checked)); ?>
					<?php $option = array('1' => 'Active', '0' => 'Inactive');
		               echo $form->input('status', array('options' => $option, 'class' => 'hide', 'label' => false)); ?>
		          </div>
		        </div>
		      </fieldset>
		    </div>
		    <div class="grid">
		      <fieldset>
		        
		        <div class="control-group">
		         
		          <div class="controls">
		            <?php echo $html->link($html->image('icon/save.png'), array('action' => 'ajax_add', $transentries[$i]['Transentry']['id']), array('class'=> "save-".$transentries[$i]['Transentry']['id'], 'escape' => false, 'id' => 'push')); ?>
					<?php //echo $html->link($html->image('icon/trash.png'), array('action' => 'delete', $transentries[$i]['Transentry']['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $transentries[$i]['Transentry']['id'])); ?>
		          </div>
		        </div>
		      </fieldset>
		    </div>    
		  </form>
		</div>
	<?php $i++; ?>
<?php endforeach; ?>
</div>
<h3><span class="alert alert-error overlay-error hide"></span></h3>