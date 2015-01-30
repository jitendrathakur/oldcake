<link href="<?php echo Configure::read('base_url');?>js/editable/bootstrap-combined.css" rel="stylesheet">
<!-- x-editable (bootstrap version) -->
<link href="<?php echo Configure::read('base_url');?>js/editable/bootstrap-editable.css" rel="stylesheet">
<script src="<?php echo Configure::read('base_url');?>js/editable/bootstrap-editable.js"></script>

<script language="javascript">
$(document).ready(function() {
    //toggle `popup` / `inline` mode
    $.fn.editable.defaults.mode = 'inline';     
    //make username editable
	 var scenerio_id = $('#scenario_id').val();
	 var location_id = $('#location_id').val();
	 var trunk_id = $('#trunk_id').val();
	 var group_id = $('#group_id').val();
	 
    $('#scenerio_name').editable({
		 type: 'text'       
        ,pk: 1
        ,url: '<?php echo Configure::read('base_url');?>scenarios/edit_scenario_via_ajax/scenerio_id:'+scenerio_id
    });
	$('#location_name').editable({
		 type: 'text'       
        ,pk: 1
        ,url: '<?php echo Configure::read('base_url');?>locations/edit_location_via_ajax/location_id:'+location_id
		,success: function(data){
			$('#LocationName').val(data);
		}
    });
	$('#trunk_name').editable({
		 type: 'text'       
        ,pk: 1
        ,url: '<?php echo Configure::read('base_url');?>trunks/edit_trunk_via_ajax/trunk_id:'+trunk_id
    });
	$('#group_name').editable({
		 type: 'text'       
        ,pk: 1
        ,url: '<?php echo Configure::read('base_url');?>groups/edit_group_via_ajax/group_id:'+group_id
		,success: function(data){
			$('#GroupGroupName').val(data);
		}
    });
	
	
	
	
});
</script>


