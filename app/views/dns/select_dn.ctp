<style>
	.table-content table  colgroup col:nth-child(7)
{
	width:150px !important;
}
</style>
<script type="text/javascript">
var dnid = '<?php echo $referred_from; ?>';
var addabove = '<?php echo $addabove; ?>';
var replaceabove = '<?php echo $replaceabove; ?>';
jQuery(document).ready(function(){ 
     /** code to select all filteres records : start **/
	$('.reset').click(function(){ 
		var checkboxes = $(this).closest('form').find(':checkbox');
		checkboxes.removeAttr('checked');
	});
	/** code to select all filteres records : ends **/
    $('#removeChecked').on("click",function(){ 
		var count = 0;
		$('form input[type="search"]').each(function(){
				if($(this).val()!=""){ count++; }
		}); 
		if(count>0){ 
			var checkboxes = $( "table.dataTable tr:visible" ).find(':checkbox');
			checkboxes.removeAttr('checked');
		}
	});
	
	$('.selectdnsCheckbox').click(function(){  
	   	var checkboxes = $(this).closest('form').find(':checkbox:checked');
		checkboxes.removeAttr('checked');
		$(this).attr('checked', 'checked');
	});
 });


function submit_dn(){
	var checkboxes = $('form').find(':checkbox:checked');
					DN_id =  checkboxes.val(); 
					var newFeature = window.parent.$('#newaddedFeatues').val();
					newFeature += DN_id+",";
					//newFeature =  newFeature.concat(newFeature,","+DN_id); 
					//alert(newFeature);
					window.parent.$('#newaddedFeatues').val(newFeature);
				
					if(dnid){                            // case for updating
						window.parent.$('#dragdroptbl tr').find('td').each(function () {   
						//	alert($(this).closest("tr").attr('id'));
							if($(this).text().trim() == dnid){ 
                                var tr_id = $(this).closest("tr").attr('id');
								var pos_val = $(this).find("input[name^='featureNewPosition']").val();
								$(this).html('<a class="opencolorbox cboxElement" href="/voipphoneRE3/dns/selectdns/scenario_id:4&type=single&update='+DN_id+'">'+DN_id+'</a><input type="hidden" id="StationFeaturevalue['+tr_id+']" value="'+DN_id+'" name="featurevalue['+tr_id+']"><input type="hidden" value="'+pos_val+'" name="featureNewPosition['+tr_id+']">');
								//$(this).find('input:hidden').val(DN_id);
							}
						}); 
					}else if(replaceabove){
						//alert(addabove);
						var l = replaceabove.split("@"); var old_DNID = l[0]; var old_trID = l[1]; //alert(old_trID);
							//alert(window.parent.$('#dragdroptbl tr#'+old_trID).find("td:nth-child(2) a").text());
						var addbeforeDN = window.parent.$('#dragdroptbl tr#'+old_trID).find("td:nth-child(2) a").text();
						var DN_Value = window.parent.$('#dragdroptbl tr#'+replaceabove).find("td:nth-child(2) input[name='featurevalue["+replaceabove+"]']").val();
						var trID_to_assign = window.parent.$('#dragdroptbl tr:last').attr('id'); //alert(trID_to_assign);
						window.parent.$('#dragdroptbl tr:last').remove();
						var trold_new_position  = window.parent.$('#dragdroptbl tr#'+old_trID).find("td:nth-child(2) input[name='featureNewPosition["+old_trID+"]']").val();
						//alert(DN_Value);
						  window.parent.$('#dragdroptbl tr#'+old_trID).before('<tr id="'+trID_to_assign+'" onmouseout="hoverRow(this,false); " onmouseover="hoverRow(this,true);" style="cursor: move; height: 23px; background-color: transparent;"><td><input id="StationFeaturename['+trID_to_assign+']" type="hidden" value="DN_INDIVIDUAL" name="featurename['+trID_to_assign+']">DN_INDIVIDUAL</td><td><input id="StationFeaturevalue['+trID_to_assign+']" type="hidden" value="'+DN_id+'" name="featurevalue['+trID_to_assign+']"><input id="StationFeatureNewPosition['+trID_to_assign+']" type="hidden" value="'+trold_new_position+'" name="featureNewPosition['+trID_to_assign+']"><a class="opencolorbox cboxElement" href="/voipphoneRE3/dns/selectdns/scenario_id:1&type=single&update='+DN_id+'">'+DN_id+'</a></td><td class="table-right" onmouseout="this.className=\'table-right\';" onmouseover="this.className=\'table-right-over\';" style="background:url(/voipphoneRE3/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat 3px 5px;border-style: none;"><div class="table-menu"><div class="table-menu-popup" style="z-index: 1; display: none;"><ul><li class="script"><a class="opencolorbox cboxElement" href="/voipphoneRE3/dns/selectdns/scenario_id:1&type=single&replace='+DN_id+'@'+trID_to_assign+'">Add DN</a></li><li class="last log"><a href="javascript:del_dn(\''+DN_id+'@'+trID_to_assign+'\')">Delete</a></li></ul></div></div></td></tr>');	
						  var elem = window.parent.$('#dragdroptbl tr#'+trID_to_assign).nextAll();
						 $(elem).each(function () {   			
							var new_pos = $(this).find("td:nth-child(2) input[name^='featureNewPosition']").val();
							new_pos = Number(new_pos)+Number(1);
							new_pos = (new_pos.toString().length==1)? '0'+new_pos : new_pos; // check lengh and make it 2 if not e.g. 1 to 01
							 $(this).find("td:nth-child(2) input[name^='featureNewPosition']").val(new_pos);
						  });
					}else if(addabove){
						//alert(addabove);
						var emptyTdCount = 0; 
						window.parent.$('#dragdroptbl tr#'+addabove).find('td').each(function () {  
						//	alert($(this).closest("tr").attr('id'));
						
                                if(emptyTdCount==0){
									$(this).text('DN_INDIVIDUAL');
									//$(this).html('<input type="hidden" id="StationFeaturename['+tr_id+']" value="DN" name="featurename['+tr_id+']">');
									$(this).html('<input type="hidden" id="StationFeaturename['+addabove+']" value="DN_INDIVIDUAL" name="featurename['+addabove+']">'+$(this).html());

								}else if(emptyTdCount==1){  
									var pos_val = $(this).find("input[name^='featureNewPosition']").val();
									$(this).html('<a class="opencolorbox cboxElement" href="/voipphoneRE3/dns/selectdns/scenario_id:4&type=single&update='+DN_id+'">'+DN_id+'</a><input type="hidden" id="StationFeaturevalue['+addabove+']" value="'+DN_id+'" name="featurevalue['+addabove+']"><input type="hidden" value="'+pos_val+'" name="featureNewPosition['+addabove+']">');
								}else if(emptyTdCount==2){ 
									//alert($(this).html());
									$(this).html('<div class="table-menu"><div class="table-menu-popup" style="z-index: 1; display: none;"><ul><li class="script"><a class="opencolorbox cboxElement" href="/voipphoneRE3/dns/selectdns/scenario_id:1&type=single&replace='+DN_id+'@'+addabove+'">Add DN</a></li><li class="last log"><a href="javascript:del_dn(\''+DN_id+'@'+addabove+'\')">Delete</a></li></ul></div></div>');
								}
								
								if(emptyTdCount >= 3){  
									//alert(emptyTdCount);
									return false;
								}
								emptyTdCount++;
						}); 
						
					}else{
						var emptyTdCount = 0; 
						window.parent.$('#dragdroptbl tr').find('td').each(function () {   							
							if($(this).text().trim() == ""){
								var tr_id = $(this).closest("tr").attr('id');	
								if(emptyTdCount==0){
									$(this).text('DN_INDIVIDUAL');
									//$(this).html('<input type="hidden" id="StationFeaturename['+tr_id+']" value="DN" name="featurename['+tr_id+']">');
									$(this).html('<input type="hidden" id="StationFeaturename['+tr_id+']" value="DN_INDIVIDUAL" name="featurename['+tr_id+']">'+$(this).html());

								}else if(emptyTdCount==1){  
									var pos_val = $(this).find("input[name^='featureNewPosition']").val();
									$(this).html('<a class="opencolorbox cboxElement" href="/voipphoneRE3/dns/selectdns/scenario_id:4&type=single&update='+DN_id+'">'+DN_id+'</a><input type="hidden" id="StationFeaturevalue['+tr_id+']" value="'+DN_id+'" name="featurevalue['+tr_id+']"><input type="hidden" value="'+pos_val+'" name="featureNewPosition['+tr_id+']">');
								}
								emptyTdCount++;
								
							}else{ 	var tr_id = $(this).closest("tr").attr('id');	
							if(emptyTdCount==2){
										$(this).html('<div class="table-menu"><div class="table-menu-popup" style="z-index: 1; display: none;"><ul><li class="script"><a class="opencolorbox cboxElement" href="/voipphoneRE3/dns/selectdns/scenario_id:1&type=single&replace='+DN_id+'@'+tr_id+'">Add DN</a></li><li class="last log"><a href="javascript:del_dn(\''+DN_id+'@'+tr_id+'\')">Delete</a></li></ul></div></div>');
								}
							}
								if(emptyTdCount >= 3){
									//alert(emptyTdCount);
									return false;
								}
								
						}); 
					}
						  //rebind to drag-drop feature again
						  window.parent.$('#dragdroptbl').tableDnD({ 
							onDragStart: function(table, row) { 
							}, 
							onDrop: function(table, row) { //alert("ssd");
								$('#AjaxResult').load(base_url+"stations/editstation?"+window.parent.$.tableDnD.serialize());
									var tblstr = decodeURI(window.parent.$.tableDnD.serialize());
									var tmparray = new Array();
									var x = 0;
									tmparray = tblstr.split("&dragdroptbl[]="); 
									while (x < tmparray.length) {
										if (tmparray[x] != "dragdroptbl[]=") { 
										   pos=x+1; 
										   pos = (pos.toString().length==1)? '0'+pos : pos;
										   original_position = tmparray[x].replace("dragdroptbl[]=", ""); 
										  //  alert(pos+"=="+original_position);
										  // alert($('#'+original_position).find($("input[name^='featureNewPosition']")).attr('id'));
										 //  alert($('#'+original_position).find($(".opencolorbox")).attr('href'));
										 window.parent.$('#'+original_position).find("td:nth-child(2) input[name^='featureNewPosition']").val(pos);
										 // alert( $('#'+original_position).find("td:nth-child(2) input[name^='featureNewPosition']").val());
										  // $(apriority).val(tmparray[x]);
										}
										x++;
									}
							}
						});
					jQuery('#cboxClose').click();
} 




  function submit_odsentries(){
			var checkboxes = $('form').find(':checkbox:checked');
							DN_id =  checkboxes.val(); 
							var newFeature = window.parent.$('#newaddedFeatues').val();
							newFeature += DN_id+",";
							//newFeature =  newFeature.concat(newFeature,","+DN_id); 
							//alert(newFeature);
							window.parent.$('#newaddedFeatues').val(newFeature);
						
							if(dnid){                            // case for updating
								window.parent.$('#dragdroptbl tr').find('td').each(function () {   
								//	alert($(this).closest("tr").attr('id'));
									if($(this).text().trim() == dnid){ 
                                        var tr_id = $(this).closest("tr").attr('id');
										var pos_val = $(this).find("input[name^='featureNewPosition']").val();
										$(this).html('<a class="opencolorbox cboxElement" href="/voipphoneRE3/dns/selectdns/scenario_id:4&type=single&update='+DN_id+'">'+DN_id+'</a><input type="hidden" id="StationFeaturevalue['+tr_id+']" value="'+DN_id+'" name="featurevalue['+tr_id+']"><input type="hidden" value="'+pos_val+'" name="featureNewPosition['+tr_id+']">');
										//$(this).find('input:hidden').val(DN_id);
									}
								}); 
							}else if(replaceabove){
								//alert(addabove);
								var l = replaceabove.split("@"); var old_DNID = l[0]; var old_trID = l[1]; //alert(old_trID);
 								//alert(window.parent.$('#dragdroptbl tr#'+old_trID).find("td:nth-child(2) a").text());
								var addbeforeDN = window.parent.$('#dragdroptbl tr#'+old_trID).find("td:nth-child(2) a").text();
								var DN_Value = window.parent.$('#dragdroptbl tr#'+replaceabove).find("td:nth-child(2) input[name='featurevalue["+replaceabove+"]']").val();
								var trID_to_assign = window.parent.$('#dragdroptbl tr:last').attr('id'); //alert(trID_to_assign);
								window.parent.$('#dragdroptbl tr:last').remove();
								var trold_new_position  = window.parent.$('#dragdroptbl tr#'+old_trID).find("td:nth-child(2) input[name='featureNewPosition["+old_trID+"]']").val();
								//alert(DN_Value);
								  window.parent.$('#dragdroptbl tr#'+old_trID).before('<tr id="'+trID_to_assign+'" onmouseout="hoverRow(this,false); " onmouseover="hoverRow(this,true);" style="cursor: move; height: 23px; background-color: transparent;"><td><input id="StationFeaturename['+trID_to_assign+']" type="hidden" value="DN_INDIVIDUAL" name="featurename['+trID_to_assign+']">DN_INDIVIDUAL</td><td><input id="StationFeaturevalue['+trID_to_assign+']" type="hidden" value="'+DN_id+'" name="featurevalue['+trID_to_assign+']"><input id="StationFeatureNewPosition['+trID_to_assign+']" type="hidden" value="'+trold_new_position+'" name="featureNewPosition['+trID_to_assign+']"><a class="opencolorbox cboxElement" href="/voipphoneRE3/dns/selectdns/scenario_id:1&type=single&update='+DN_id+'">'+DN_id+'</a></td><td class="table-right" onmouseout="this.className=\'table-right\';" onmouseover="this.className=\'table-right-over\';" style="background:url(/voipphoneRE3/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat 3px 5px;border-style: none;"><div class="table-menu"><div class="table-menu-popup" style="z-index: 1; display: none;"><ul><li class="script"><a class="opencolorbox cboxElement" href="/voipphoneRE3/dns/selectdns/scenario_id:1&type=single&replace='+DN_id+'@'+trID_to_assign+'">Add DN</a></li><li class="last log"><a href="javascript:del_dn(\''+DN_id+'@'+trID_to_assign+'\')">Delete</a></li></ul></div></div></td></tr>');	
								  var elem = window.parent.$('#dragdroptbl tr#'+trID_to_assign).nextAll();
								 $(elem).each(function () {   			
									var new_pos = $(this).find("td:nth-child(2) input[name^='featureNewPosition']").val();
									new_pos = Number(new_pos)+Number(1);
									new_pos = (new_pos.toString().length==1)? '0'+new_pos : new_pos; // check lengh and make it 2 if not e.g. 1 to 01
									 $(this).find("td:nth-child(2) input[name^='featureNewPosition']").val(new_pos);
								  });
							}else if(addabove){
								//alert(addabove);
								var emptyTdCount = 0; 
								window.parent.$('#dragdroptbl tr#'+addabove).find('td').each(function () {  
								//	alert($(this).closest("tr").attr('id'));
								
                                        if(emptyTdCount==0){
											$(this).text('DN_INDIVIDUAL');
											//$(this).html('<input type="hidden" id="StationFeaturename['+tr_id+']" value="DN" name="featurename['+tr_id+']">');
											$(this).html('<input type="hidden" id="StationFeaturename['+addabove+']" value="DN_INDIVIDUAL" name="featurename['+addabove+']">'+$(this).html());

										}else if(emptyTdCount==1){  
											var pos_val = $(this).find("input[name^='featureNewPosition']").val();
											$(this).html('<a class="opencolorbox cboxElement" href="/voipphoneRE3/dns/selectdns/scenario_id:4&type=single&update='+DN_id+'">'+DN_id+'</a><input type="hidden" id="StationFeaturevalue['+addabove+']" value="'+DN_id+'" name="featurevalue['+addabove+']"><input type="hidden" value="'+pos_val+'" name="featureNewPosition['+addabove+']">');
										}else if(emptyTdCount==2){ 
											//alert($(this).html());
											$(this).html('<div class="table-menu"><div class="table-menu-popup" style="z-index: 1; display: none;"><ul><li class="script"><a class="opencolorbox cboxElement" href="/voipphoneRE3/dns/selectdns/scenario_id:1&type=single&replace='+DN_id+'@'+addabove+'">Add DN</a></li><li class="last log"><a href="javascript:del_dn(\''+DN_id+'@'+addabove+'\')">Delete</a></li></ul></div></div>');
										}
										
										if(emptyTdCount >= 3){  
											//alert(emptyTdCount);
											return false;
										}
										emptyTdCount++;
								}); 
								
							}else{
								var emptyTdCount = 0; 
								window.parent.$('#dragdroptbl tr').find('td').each(function () {   							
									if($(this).text().trim() == ""){
										var tr_id = $(this).closest("tr").attr('id');	
										if(emptyTdCount==0){
											$(this).text('DN_INDIVIDUAL');
											//$(this).html('<input type="hidden" id="StationFeaturename['+tr_id+']" value="DN" name="featurename['+tr_id+']">');
											$(this).html('<input type="hidden" id="StationFeaturename['+tr_id+']" value="DN_INDIVIDUAL" name="featurename['+tr_id+']">'+$(this).html());

										}else if(emptyTdCount==1){  
											var pos_val = $(this).find("input[name^='featureNewPosition']").val();
											$(this).html('<a class="opencolorbox cboxElement" href="/voipphoneRE3/dns/selectdns/scenario_id:4&type=single&update='+DN_id+'">'+DN_id+'</a><input type="hidden" id="StationFeaturevalue['+tr_id+']" value="'+DN_id+'" name="featurevalue['+tr_id+']"><input type="hidden" value="'+pos_val+'" name="featureNewPosition['+tr_id+']">');
										}
										emptyTdCount++;
										
									}else{ 	var tr_id = $(this).closest("tr").attr('id');	
									if(emptyTdCount==2){
												$(this).html('<div class="table-menu"><div class="table-menu-popup" style="z-index: 1; display: none;"><ul><li class="script"><a class="opencolorbox cboxElement" href="/voipphoneRE3/dns/selectdns/scenario_id:1&type=single&replace='+DN_id+'@'+tr_id+'">Add DN</a></li><li class="last log"><a href="javascript:del_dn(\''+DN_id+'@'+tr_id+'\')">Delete</a></li></ul></div></div>');
										}
									}
										if(emptyTdCount >= 3){
											//alert(emptyTdCount);
											return false;
										}
										
								}); 
							}
								  //rebind to drag-drop feature again
								  window.parent.$('#dragdroptbl').tableDnD({ 
									onDragStart: function(table, row) { 
									}, 
									onDrop: function(table, row) { //alert("ssd");
										$('#AjaxResult').load(base_url+"stations/editstation?"+window.parent.$.tableDnD.serialize());
											var tblstr = decodeURI(window.parent.$.tableDnD.serialize());
											var tmparray = new Array();
											var x = 0;
											tmparray = tblstr.split("&dragdroptbl[]="); 
											while (x < tmparray.length) {
												if (tmparray[x] != "dragdroptbl[]=") { 
												   pos=x+1; 
												   pos = (pos.toString().length==1)? '0'+pos : pos;
												   original_position = tmparray[x].replace("dragdroptbl[]=", ""); 
												  //  alert(pos+"=="+original_position);
												  // alert($('#'+original_position).find($("input[name^='featureNewPosition']")).attr('id'));
												 //  alert($('#'+original_position).find($(".opencolorbox")).attr('href'));
												 window.parent.$('#'+original_position).find("td:nth-child(2) input[name^='featureNewPosition']").val(pos);
												 // alert( $('#'+original_position).find("td:nth-child(2) input[name^='featureNewPosition']").val());
												  // $(apriority).val(tmparray[x]);
												}
												x++;
											}
										
									   
									}
								});
							jQuery('#cboxClose').click();

 } 
jQuery(function() {
	jQuery.extend(jQuery.tablesorter.themes.bootstrap, {
		// these classes are added to the table. To see other table classes available,
		// look here: http://twitter.github.com/bootstrap/base-css.html#tables
		table      : 'table table-bordered',
		header     : 'bootstrap-header', // give the header a gradient background
		footerRow  : '',
		footerCells: '',
		icons      : '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
		sortNone   : 'bootstrap-icon-unsorted',
		sortAsc    : 'icon-chevron-up',
		sortDesc   : 'icon-chevron-down',
		active     : '', // applied when column is sorted
		hover      : '', // use custom css here - bootstrap class may not override it
		filterRow  : '', // filter row class
		even       : '', // odd row zebra striping
		odd        : ''  // even row zebra striping
	});

	// call the tablesorter plugin and apply the uitheme widget
	jQuery(".dataTable").tablesorter({
		// this will apply the bootstrap theme if "uitheme" widget is included
		// the widgetOptions.uitheme is no longer required to be set
		theme : "bootstrap",

		widthFixed: true,

		headerTemplate : '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!

		// widget code contained in the jquery.tablesorter.widgets.js file
		// use the zebra stripe widget if you plan on hiding any rows (filter widget)
		widgets : [ "uitheme", "filter", "zebra" ],

		widgetOptions : {
			// using the default zebra striping class name, so it actually isn't included in the theme variable above
			// this is ONLY needed for bootstrap theming if you are using the filter widget, because rows are hidden
			zebra : ["even", "odd"],

			// reset filters button
			filter_reset : ".reset"

			// set the uitheme widget to use the bootstrap theme class names
			// this is no longer required, if theme is set
			// ,uitheme : "bootstrap"

		},
		
		headers: { 
		0: {sorter: false,filter: false},
		6: {sorter: false,filter: false},
		7: {sorter: false,filter: false}

		} 
	})
	.tablesorterPager({

		// target the pager markup - see the HTML block below
		container: jQuery(".pager"),

		// target the pager page select dropdown - choose a page
		cssGoto  : ".pagenum",

		// remove rows from the table to speed up the sort of large tables.
		// setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
		removeRows: false,

		// output string - default is '{page}/{totalPages}';
		// possible variables: {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
		output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'

	});

});
</script>
<div class="block top">
	<br>
	
	   <h5>Choose Station</h5>
	<?php 
	    echo $form->create('Dns',array('action'=>'selectdns','id'=>'filters','class'=>'filtersForm','type'=>'GET'));
	    echo $form->input('Location.customer_id', array('type'=>'hidden','value'=>$custId)); 
	   ?>
	    <div class="cb">
			<div class="block" style="margin: 0px;">
				<div class="button-right">
				<?php echo $html->link( __("Export Csv", true),  array('controller'=> 'dns', 'action'=>'export'),array('onmouseover'=>'hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
				</div>
				
				<div class="button-left">
					<?php echo $html->link( __("reset", true),'javascript:void(0);',array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);','class'=>'reset')); ?>
                </div>
				
            </div>
	
	    <?php
	
		
		// check $locations variable exists and is not empty
		if(isset($dns) && !empty($dns)) : 
		?>
		<!--Showing Page <?php //echo $paginator->counter(); ?>-->  
		
		<?php //echo $this->element('pagination/top');?>
	    <div id="" class="table-content">
		<table id="exampleSingle" class="phonekey dataTable">
				<thead> 	
				<tr class="table-top">
	            <th class="table-column table-left-ohne">&nbsp;</th>
				<th class="table-column <?php if(in_array('sort:id',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:id',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:102px;text-align: left;">
				<?php echo __("freeDnId",true); ?></th>

				<th class="table-column <?php if(in_array('sort:location_id',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:location_id',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:102px;text-align: left;"><?php echo __("Location",true); ?></th>
				<th class="table-column <?php if(in_array('sort:function',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:function',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:102px;text-align: left;"><?php echo __("Function",true); ?></th>
				<th class="table-column <?php if(in_array('sort:display',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:display',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:102px;text-align: left;"><?php echo __("DISPLAYNAME",true); ?></th>
				<th class="table-column <?php if(in_array('sort:emer',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:emer',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:102px;text-align: left;"><?php 
				echo __("Emergency",true); ?></th>
				<th class="table-column filter-false"><?php  
				// echo $html->link( __("+", true),'javascript:void(0);',array('id'=>'addChecked','class'=>'addChecked'));
				// echo $html->link( __("-", true),'javascript:void(0);',array('id'=>'removeChecked','class'=>'removeChecked'));
				?></th> 
				 <th class="table-right-ohne">&nbsp;</th> 
				 </tr>
				</thead>
				<tfoot>
						<th colspan="7" class="pager form-horizontal">
							<button type="button" class="btn first"><i class="icon-step-backward"></i></button>
							<button type="button" class="btn prev"><i class="icon-arrow-left"></i></button>
							<span class="pagedisplay"></span> <!-- this can be any element, including an input -->
							<button type="button" class="btn next"><i class="icon-arrow-right"></i></button>
							<button type="button" class="btn last"><i class="icon-step-forward"></i></button>
							<select class="pagesize input-mini" title="Select page size">
								<option selected="selected" value="10">10</option>
								<option value="20">20</option>
								<option value="30">30</option>
								<option value="40">40</option>
							</select>
							<select class="pagenum input-mini" title="Select page number"></select>
						</th>
					</tr>
				</tfoot>
				 <tbody>
				   <?php
					// initialise a counter for striping the table
					$count = 0; 	
					// loop through and display format
					foreach($dns as $dn): 
						// stripes the table by adding a class to every other row
						$class = ( ($count % 2) ? " class='altrow'": '' );
						// increment count
						$count++; 
					?>
					
			        <tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false); " >
	             	<td class="table-left">&nbsp;</td>
	            	<td> 
	            	<?php 
	            		if(($dn['Dns']['function'] != '') && ($dn['Dns']['function'] != 'CFRA') && ($dn['Dns']['function'] != 'UCD') && ($dn['Dns']['function'] != 'INTERNAL'))
	            		{
	            			echo $html->link($dn['Dns']['id'],array('controller'=>'stations', 'action'=>'edit', 'DN-'.$dn['Dns']['id']));
	            			?>
	            			</td>
							<td class="table-content column-width-100" style="width:125px;">
	                		<?php 
	                		echo $html->link($dn['Location']['name'],array('controller'=>'stations', 'action'=>'edit', 'DN-'.$dn['Dns']['id']),array('class'=>'opencolorbox'));
	                		#echo $dn['Location']['name']; 
	                		?>
					</td>
	                		<td>
	                		<?php 
	                		#echo $dn['Dns']['function'];
	                		echo $html->link(__($dn['Dns']['function'], true),array('controller'=>'stations', 'action'=>'edit', 'DN-'.$dn['Dns']['id'])); 
	                		?>
	                		</td>

	                		<td>
	                		<?php 
	                		#echo $dn['Dns']['display']; 
	                		echo $html->link($dn['Dns']['display'],array('controller'=>'stations', 'action'=>'edit', 'DN-'.$dn['Dns']['id']));
	                		?>
	                		</td>
							<td>
	                		<?php 
	                		#echo $dn['Dns']['emer']; 
	                		echo $html->link($dn['Dns']['emer'],array('controller'=>'stations', 'action'=>'edit', 'DN-'.$dn['Dns']['id']));
	                		?>
	                		</td>
							<td><input type="checkbox" class="selectdnsCheckbox <?php echo $dn['Dns']['id']  ?>" name="selectdnsCheckbox[]" value="<?php echo $dn['Dns']['id']  ?>" /></td>
							  <td class="table-right-ohne">&nbsp;</td>
	            			<?php
	            		}
	            		else
	            		{
	            			echo $dn['Dns']['id'];
	            			?>
	            			</td>
							<td class="table-content column-width-100" style="width:125px;">
	                		<?php echo $dn['Location']['name']; ?>
							</td>
	                		<td><?php echo $dn['Dns']['emer']; ?></td>
	                		<td><?php echo __($dn['Dns']['function'], true); ?></td>
	                		
	                		<td><?php echo $dn['Dns']['display']; ?></td>
							<td><input type="checkbox" class="selectdnsCheckbox <?php echo $dn['Dns']['id']  ?>" name="selectdnsCheckbox[]" value="<?php echo $dn['Dns']['id']  ?>" /></td>
							  <td class="table-right-ohne">&nbsp;</td>
		    				
	            			<?php 
	            		}
	            		endforeach; ?>
	            	</tr>
					
				
				 </tbody>
				 
		</table>
			<div class="block" style="margin: 0px;">
				<div class="button-right">
					<a href="javascript:void(null)"  onclick="javascript:submit_dn();" name="submitForm" value="submitForm" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __("Submit");?></a>
				</div>
           </div>
	    <?php echo $form->end(); ?>
	<?php //echo $this->element('pagination/newpaging'); ?>
	</div>
	    </div>
	   
	    <?php
		else:
			__("No Dns available in DB");
			echo '</div>';
		endif;
		?>
	 
                <div class="button-left">
                	<?php if($userpermission==Configure::read('access_id'))
                	{
						#echo $html->link(__('Back', true),  array('controller'=> 'customers', 'action'=>'index'),array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);')); 
	
                        	#echo $html->link('back',  array('controller'=> 'stations', 'action'=>'edit', $station_number));
                	}
                	?>
                </div>
	</div>
</div>
<!--right hand side starts from here-->
<!--<div id="related-content" style="float: left; margin-left:10px;">
<br/>
        <div class="box start link">
                <a href="http://www.swisscom.ch/grossunternehmen" target="_blank">
                <?php __('Home Swisscom') ?>
                </a>
        </div>
        <div class="box info">
        	 <h3><?php __('DN List') ?></h3>
                 <p>
                  <?php __('DN_blurb') ?>
                 </p>
        </div>

<!--INTERNAL USER OPTIONS -->
        <?php /* if($userpermission==Configure::read('access_id'))
        {?>
                <div class="box info">
                <h3><?php __("Internal User");?></h3>
                <p><?php __("Customer View:");?></p>
                <p><?php echo $selected_customer; ?></p>

                </div>
	<?php } */ ?>

		</div>
<!--ight hand side  ends here-->

