<?php   echo $javascript->link('/js/jquery'); 
?>   
<script>

	jQuery("#addsourcedn").click(function () {
		      var enteredSource = jQuery('#source').val();
                      var enteredDest = jQuery('#destination').val();
                      var enteredState = jQuery('#state').val();
		     var scenario_id = jQuery('#scenario_id').val();
                     
			var TargetURL = "<?php echo Configure::read('base_url');?>scenarios/addviajQuery/source_code:"+enteredSource+"/dest_code:"+enteredDest+"/state_code:"+enteredState+"/scenario_id:"+scenario_id;
			
			jQuery.post( TargetURL, function( data ) {			
	
		     });	 
		
		jQuery('#success').html('Dest. Number Added Successfully!');
    });	
	
</script>
<style>
input, textarea, .uneditable-input {
    width:auto !important;
}    
</style>
    

<table width="300">

    <tr>
     <td>Enter Source : <input type="text" name="source" id="source" size="80"></td>
      </tr>
       <tr>
          <td>Enter Destination : <input type="text" name="destination" id="destination" size="80"></td>
      </tr>

       <tr>
      <td> Status : 
            <input type="radio" name="state" value="1" id="state" checked> Valid 
             <input type="radio" name="state" value="2" id="state"> InValid
      </td>

     </tr>
     <tr>
         <td> <div class="block" style="margin: 0px;">
       <div class="button-left">
        <a href="javascript:void(0);" id="addsourcedn">Add Source DN</a>

     </div></td>

     <input type="hidden" name="scenario_id" id="scenario_id" value="<?php echo $scenario_id; ?>" >

     </tr>
</table>