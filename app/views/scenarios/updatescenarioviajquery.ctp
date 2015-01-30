<?php 
echo $javascript->link('/js/jquery.fancybox');
?>
<?php
  $ScenarioStatus=$scenarioDetails[0]['Scenario']['status'];
  $PerformDisable =0;
if($ScenarioStatus==5 || $ScenarioStatus==6 || $ScenarioStatus==7){
	$readonlytextbox="readonly='true'";
	$PerformDisable =1;
	$class = "button-left-readonly";
} else {
    $readonlytextbox ='';
	$class = "button-left";
}

?>

<script type="text/javascript">
function chngbkcolor(obj) {
        $(document).ready(function() {

            var valueToFind = jQuery(this).val();
            var CurrId = jQuery(obj).attr('id');

            CurrId = (typeof CurrId == 'undefined') ? '' : CurrId;

            jQuery('#save' + CurrId).show();
            jQuery('#trick' + CurrId).hide();

            var val = jQuery('#' + CurrId).val();
            var RowId = CurrId.substring(1, CurrId.length);

            //jQuery('#chk' + RowId).removeAttr("class");
            jQuery('#chk' + RowId).attr("class", "changedodsentry");
						
            if (val != '') {
				var edited = "<?php __('Edited'); ?>"
                jQuery('.sc_state_medium' + RowId).html(edited);
            }
           jQuery('#destid').val(CurrId);

// Jquery Validation
           var arr = CurrId.split('d');
		   $("#d"+arr[1]).addClass("form-change");
		   
		        jQuery('#updateOdsentry').show();
				jQuery('#savedestinations').attr("onclick", "javascript:saveOdsentry(this);");
            	jQuery('#savedestinations').attr("class", "showhighlight_buttonleft");
            	jQuery('#updateOdsentry').removeAttr("class");
            	jQuery('#updateOdsentry').attr("class", "button-right-hover");
		   
		   /*var rowdata = 'd'+arr[1];
		  	   
		   alert(rowdata);
		   validation = {
	    	    // Specify the validation rules
	    	    'rules': {
	    	        rowdata:{
	    	            'min': '9',
	    	            'max': '15',
	    	        }                 
	    	    },                  
	    	    // Specify the validation error messages
	    	    'messages': {  
	    	         rowdata: {
	    	             'min': "<?php __('min9Chars')?>",
	    	             'max': "<?php __('max15Chars')?>",
	    	         }
	    	    },
	    	  };
			
			if (inValidate(validation)) {
	    	$("#d"+arr[1]).attr("class","space_check  numeric_check form-change");
			$('#savedestinations').removeAttr("onclick","");
			$('#updateOdsentry').removeAttr("class");
		    $('#savedestinations').removeAttr("class", "showhighlight_buttonleft");
		    $('#updateOdsentry').attr("class", "button-right-disabled");
	    	    return false;
	    	  } 
			  else{
			  	jQuery('#savedestinations').attr("onclick", "javascript:saveOdsentry(this);");
				jQuery('#savedestination').attr("class", "showhighlight_buttonleft");
            	jQuery('#savedestinations').attr("class", "showhighlight_buttonleft");
            	jQuery('#destid').val(CurrId);

            	jQuery('#updateOdsentry').removeAttr("class");
            	jQuery('#updateOdsentry').attr("class", "button-right-hover");
			  }*/
		   

			 $("input.numeric_check").focus(function(e) {	
			 //make button heightlighted when there is unsaved destination
			 	$('#savedestinations').addClass('showhighlight_buttonleft');
				$('#updateOdsentry').removeClass('button-right-disabled');
				$('#updateOdsentry').addClass('button-right-hover');
			 
			 
			 
			 
			 
	 //  if ($("#d"+arr[1]).val().length < 3) {
  //            $('#overlay-error .error .message').text("<?php __('min3Chars') ?>");
  //            $('#overlay-error').removeClass('hide');
             
		// 	$("#d"+arr[1]).addClass("form-changeinvalidate");
		// 	$('#savedestinations').removeAttr("onclick","");
		// 	$('#updateOdsentry').removeAttr("class");
		//     $('#savedestinations').removeAttr("class", "showhighlight_buttonleft");
		//     $('#updateOdsentry').attr("class", "button-right-disabled");
			
		// 	$('#overlay-sucess').addClass('hide');	
			       
  //            return false;  
                   
  //         }
		// else if ($("#d"+arr[1]).val().length > 15) {
  //            $('#overlay-error .error .message').text("<?php __('max15Chars') ?>");
  //            $('#overlay-error').removeClass('hide');     
			 
		// 	 $("#d"+arr[1]).addClass("form-changeinvalidate");
		// 	 $('#savedestinations').removeAttr("onclick","");
		// 	 $('#updateOdsentry').removeAttr("class");
		//      $('#savedestinations').removeAttr("class", "showhighlight_buttonleft");
		//      $('#updateOdsentry').attr("class", "button-right-disabled");        
             
  //           return false;        
  //         }
		  
		
		  
		 //  else{
		 //  	jQuery('#savedestinations').attr("onclick", "javascript:saveOdsentry(this);");
   //          jQuery('#savedestinations').attr("class", "showhighlight_buttonleft");
   //          //jQuery('#destid').val(CurrId);

   //          jQuery('#updateOdsentry').removeAttr("class");
   //          jQuery('#updateOdsentry').attr("class", "button-right-hover");
			// $('#overlay-sucess').addClass('hide');
		 //  }
		  
	  
    });
			
			
			
			
        });
	//called when key is pressed in textbox
    $("input.numeric_check").keypress(function(e) {	
		//console.log(e.which);
      if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57) && e.which!=13 && e.which!=118)
      {        
        
		$('#overlay-error .error .message').text("<?php __('digitsOnly') ?>");
        $('#overlay-error').removeClass('hide');
		//$('#savedestinations').removeAttr("onclick","");
			
        return false;
		
      }
	  
	   else {	      	
      		//$("input").keydown(function() {
	          //inValidate(validation, 'keyup');                    
	        //});
            jQuery('#savedestinations').attr("onclick", "javascript:saveOdsentry(this);");
            jQuery('#savedestinations').attr("class", "showhighlight_buttonleft");
            //jQuery('#destid').val(CurrId);

            jQuery('#updateOdsentry').removeAttr("class");
            jQuery('#updateOdsentry').attr("class", "button-right-hover");
      }
        });

    }
$(document).ready(function(){
$('.counter').hide();
	$('#savescenariotitle').click(function(){
		var scenario_name = jQuery('.scenarios').val();
		var scenario_id = '<?php echo $scenario_id; ?>';
		var customer_id = '<?php echo $customer_id; ?>';		
			var TargetURL = "<?php echo Configure::read('base_url');?>scenarios/update_scname/scenario_id:"+scenario_id+"/customer_id:"+customer_id+"/scenario_name:"+scenario_name;
			jQuery.post( TargetURL, function( data ) {					
					//jQuery('.scenarios').val(data);
					var msgd=data.trim();
					
						window.location.href = "<?php echo Configure::read('base_url');?>scenarios/edit/scenario_id:"+msgd;
				
						//jQuery('#scenariossuccess').html('<font class="scenarioupdatemsg">Scenario updated successfully!</font>');
					
			});
			//window.location.href = "<?php echo Configure::read('base_url');?>scenarios/edit/customer_id:sv13";
    });	
	
	$('#crm_comment_option').val('');
	
});

 function saveOdsentry(id) {
        //alert(id);
    
        if (classInValidate(validation)) {        
          return false;
        } else {
        
                    
        var senddata = [];
		var rowdata = [];
		var dstname = [];
        jQuery('.changedodsentry').each(function() {

            var style = jQuery('.saveOdsentry').attr('style');
            var rowid = jQuery(this).attr('id');
            var attrlen = rowid.length;
            var Orowid = rowid.substring(2, attrlen);
            var Dbrowid = rowid.substring(3, attrlen);
            var Destval = jQuery('#d' + Dbrowid).val();
            senddata.push(Dbrowid + "=" + Destval);
			rowdata.push(Dbrowid);

        });

        var serialized = senddata.join("&")
		
		//var dstname="'d"+rowdata+"'";
				
        var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/updatemultipleodsentry/";
        var ScenarioId = $('#scenario_id').val();
        $('.black_overlay').show();
        jQuery.post(TargetURL, {'odsdata': serialized, 'scenario_id': ScenarioId}, function(data) {
        	$(".form-change").removeClass("form-change");
        	$(".hightlightbox").removeClass("hightlightbox");        	
            jQuery('#destid').val('');
            jQuery('.saveOdsentry').attr("style", "display:none");
            jQuery(' .trickOdsentry').attr("style", "display:inline");
            jQuery('#updateOdsentry').removeAttr("class");
            jQuery('#savedestinations').removeAttr("class");
            jQuery('#updateOdsentry').attr("class", " button-right-disabled");
            jQuery('#savedestinations').removeAttr("onclick");
			
			//make destination field heighlighted
			
			var numeric_text=$("input.numeric_check").each(function() {
			var num_val=$(this).val();
			if(num_val!="")
			{
				$('#overlay-sucess').addClass('hide');
			}
		
		});     
		
		setTimeout(function() {
            // Update Scenario Status
            var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/ScenarioCompletedOrNot/scenario_id:" + ScenarioId;

            jQuery.post(TargetURL, function(response) {
				
				
                jQuery('#Status').val(response);
                
                var msgd = response.trim();
				if(msgd == "Incomplete")
				{
					var scenarioStatus = "<?php __('Incomplete');?>"
				}
				else if(msgd == "Complete"){
					var scenarioStatus = "<?php __('Complete');?>"
				}
				jQuery('#sts').html(scenarioStatus); 
				
                if (msgd != "Incomplete") {
                    jQuery('#request_validation').show();
                    jQuery('#request_validationdiv').show();
                    //Hide buttons
                    jQuery('#crm_comment_div').hide();
                    jQuery('#activationdiv').hide();
                    jQuery('#deactivationdiv').hide();

                    //Hide Workflow messages
                    jQuery('#crm_comment_workflow').hide();
                    jQuery('#complete_workflow').show();
                    jQuery('#reject_workflow').hide();
                    jQuery('#activate_workflow').hide();
                    jQuery('#invalid_workflow').hide();

                } else {
                    // Hide buttons
                    jQuery('#request_validation').hide();
                    jQuery('#request_validationdiv').hide();
                    jQuery('#crm_comment_div').hide();
                    jQuery('#activationdiv').hide();
                    jQuery('#deactivationdiv').hide();

                    //Hide Workflow messages
                    jQuery('#crm_comment_workflow').hide();
                    jQuery('#complete_workflow').hide();
                    jQuery('#reject_workflow').hide();
                    jQuery('#activate_workflow').hide();
                    jQuery('#invalid_workflow').show();
                }
            });
},5); 
            // Change Odsentry state
            jQuery('#reloadme input[type="text"]').each(function() {
                var sid = jQuery(this).attr('id');
                var val = jQuery('#' + sid).val();
                var RowId = sid.substring(1, sid.length);
                if (val != '') {
					var validrec = "<?php __('Valid'); ?>";
                    jQuery('.sc_state_medium' + RowId).html(validrec);
                }
            });

            setTimeout(function() {
                $('.black_overlay').hide();
            }, 500);

        });
        }//end validation check else
		
    }
function toggleAdvanceSearch(){
	//$("#advancesearch").show
	if(document.getElementById('advancesearch').style.display=='none'){
		document.getElementById('advancesearch').style.display='block';
	}else{
		document.getElementById('advancesearch').style.display='none';
	}

}
function toggleShowHistory(){
	//$("#advancesearch").show
	if(document.getElementById('showhistory').style.display=='none'){
		document.getElementById('showhistory').style.display='block';
	}else{
		document.getElementById('showhistory').style.display='none';
	}
}
function toggleexecutionschedule(){
	//$("#advancesearch").show
	if(document.getElementById('showexecution').style.display=='none'){
		document.getElementById('showexecution').style.display='block';
	}else{
		document.getElementById('showexecution').style.display='none';
	}

}
function toggleodsentries(){
	//$("#advancesearch").show
	if(document.getElementById('showods').style.display=='none'){
		document.getElementById('showods').style.display='block';
	}else{
		document.getElementById('showods').style.display='none';
	}

}
</script>

<style>

.tablesorter-filter
{
	width:100% !important;
}
.space_check
{
	width:91%;
	height:auto !important;
	margin-bottom:0 !important;
}
.table th, .table td
{
	padding: 1px 6px;  /* 4px 6px;  */
	background-color:#fff !important;
}
.tablesorter-bootstrap .tablesorter-pager select
{
	width:64px;
	margin:0 20px;
}
.table-top th, .table-right-ohne th
{
	height:35px;
}
#example colgroup col:nth-child(3)
{
	width:40% !important;
}
#example colgroup col:nth-child(4)
{
	width:30% !important;
}


.table-bordered {
    border-collapse: separate;
    border-image: none;
    border-radius: 0px !important;
    border-style: none !important;
    border-width: 0px !important;
	border-top-right-radius:0px !important;
	border-top-left-radius:0px !important;
}

.withdatatablecss {
/*border-bottom:#CCCCCC 1px solid !important;*/ border-right: 1px solid #CCCCCC !important;border-top:#CCCCCC 1px solid !important; border-radius:0px !important;	
}



</style>
<script type="text/javascript">
function deleteOdsentry(record_id,scid,elem){
	$.post(base_url+'odsentries/delete/'+record_id+'/'+scid,{},function(data){
		
	alert('Record is deleted successfully');
			 $('#reloadwholdpagedata').html(data);
		/*if(data=="success"){
		    $('#'+record_id).closest('tr').remove();
			alert('Record is deleted successfully');
		}*/
	});
}
function submit_form(action){
	//alert(action);
	$('.filtersForm').attr('action',base_url+'odsentries/index/'+action);
	$('.filtersForm').attr('method','POST');
	$.ajax({
				type: "POST",
				async : false,
				dataType: 'json',
				url: $('.filtersForm').attr('action'),
				data: $('.filtersForm').serialize(),
				success: function(data){  //alert(data);
					if(data.message=="updated"){
						alert(data.affectedRows+'Record(s) updated successfully')
					}else{
						alert('Some error occured, Please try again');
					} 
				}
	});

}



                        $(document).ready(function() {

                            paginationStyle();
                            $('.pagerscenarioedit a').click(function() {
                                paginationStyle();
                            });
                            function paginationStyle() {
                                setTimeout(function() {

                                    $(".tablesorter-filter").keypress(function() {
                                        paginationStyle();
                                    });
								    $(".tablesorter-filter").change(function() {
                                        paginationStyle();
                                    });
                                   // $("table").removeClass('table-striped');
                                   // $("table").removeClass('tablesorter-bootstrap');
                                    var pageDisplay = $(".pagedisplay").text();
                                    temp = pageDisplay.split(" -");
                                    //console.log(temp);
									page2 = temp[1].split("/");
									page3=page2[1].split("(");
									var showrecord = page3[0];

                                    left = temp[0] / 10;
                                    box = left;
                                    if (temp[0] % 10 > 0) {
                                        box = parseInt(left) + 1;
                                    }
                                    if (typeof temp[1] == 'undefined') {
                                        return false;
                                    }

                                    right = temp[1].split("/ ");
                                    rightKey = right[1].split(" ");
                                    right = rightKey[0] / 10;
                                    if (rightKey[0] % 10 > 0) {
                                        totalPage = parseInt(right) + 1;
                                    }
									$('.countdisplay').html(showrecord);
                                    $(".pagedisplay").text('');
                                    var newStyle = "<input type='text' name='currpage' value='" + box + "' style='width:25px;text-align:center;float: inherit;' maxlength='3' class='GoOnTargetPage'>";
                                    newStyle += "<span style='font-weight:bold'> <?php __('Of') ?> " + totalPage + "</span>";
                                    $(".pagedisplay").html(newStyle);
                                    $('.GoOnTargetPage').keyup(function() {
                                        //console.log($(this).val());
                                        $("input[type='text']").keypress(function(e) {
                                            if (e.which == 13) {

                                                $('.pagenum').val($(this).val()).trigger('change');
                                                paginationStyle();
                                                //return false;
                                            }

                                        });
                                    });
                                }, 100);
                            }//


                        });







jQuery(function() { 
	jQuery.extend(jQuery.tablesorter.themes.bootstrap, {
		// these classes are added to the table. To see other table classes available,
		// look here: http://twitter.github.com/bootstrap/base-css.html#tables	
	});
	
	// call the tablesorter plugin and apply the uitheme widget
	jQuery(".tablesorterjquery").tablesorter({
		// this will apply the bootstrap theme if "uitheme" widget is included
		// the widgetOptions.uitheme is no longer required to be set
		theme : "bootstrap",
		widthFixed: true,
		bFilter: false,
		bInfo: false,
		emptyTo: 'none',
		link           : '<a href="#">{page}</a>',

		headerTemplate : '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!
		emptyTo: 'zero',

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
		1: {sorter: false,filter: false},
		2: {sorter: 'digit'},
		
		5: {sorter: false,filter: false},
		6: {sorter: false,filter: false}		
		
		} 
	})
	
	
	
	
	.tablesorterPager({
		// target the pager markup - see the HTML block below
		
		container: jQuery(".pagerscenarioedit"),

		// target the pager page select dropdown - choose a page
		cssGoto  : ".pagenum",
		
		initWidgets      : true,

		// remove rows from the table to speed up the sort of large tables.
		// setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
		removeRows: false,

		// output string - default is '{page}/{totalPages}';
		// possible variables: {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
		output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'
		//output: 'Page <input type="text" name="currpage" value="{page}" class="pagination_text" maxlength="3"> Of {totalPages}'

	});

     jQuery(".smallwidth").focus(function () {
		var valueToFind = jQuery(this).val(); 
		 if(valueToFind=='DN From' || valueToFind=='DN To'){
			jQuery(this).val(''); 
		 } else {
			jQuery(this).val(valueToFind); 
		 }
    });

     jQuery(".smallwidth").focusout(function () {
		var valueToFind = jQuery(this).val(); 
		 if(valueToFind=='' || valueToFind==''){
			 var id= jQuery(this).attr('id');
			 if(id=='min')
			     jQuery(this).val('DN From'); 
			 else if(id=='max')	 
				jQuery(this).val('DN To'); 
		 } 
    });
	
	
	jQuery("#filter_now").click(function () {	
		var MinVal = jQuery('#rangeMinMinval').val();		
		var MaxVal = jQuery('#rangeMaxMaxval').val();	
	
		if((MinVal.length <9 || MinVal.length >9) && (MaxVal.length <9 || MaxVal.length >9)){
			alert('Filter Range From and To Must Be 9 digits!');
			return false;
		} else {
		
			if (isNaN(MinVal) || isNaN(MaxVal)){
				alert('Filter Range must be numeric only!');
				return false;
			} else {		
				jQuery("#form").submit();
			}
		}
	});

	jQuery("#reset_filter").click(function () {
	
		jQuery('#rangeMinMinval').val('');
		jQuery('#rangeMaxMaxval').val('');
		jQuery("#form").submit();
	});
	
     jQuery(".deldest").click(function () {
	    jQuery('input[type="checkbox"]:checked').each(function() { 
			var Odsentryid = jQuery(this).val();
	
			var TargetURL = "<?php echo Configure::read('base_url');?>scenarios/deletedest/dest_id:"+Odsentryid;
			
			jQuery.post( TargetURL, function( data ) {			
				jQuery("#firstchild"+data).parents("tr").hide();
			});	

			jQuery("#firstchild"+Odsentryid).parents("tr").hide();			
		});		

	    jQuery('input[type="checkbox"]:checked').each(function() { 
			jQuery(this).attr("checked", false);				
		});	

	setTimeout(function(){
		 window.location.reload();
	  },1000);		
    });

	/*Check All / Uncheck All functionality*/
    jQuery("#checkAll").click(function () {
        if (jQuery("#checkAll").is(':checked')) {		
           	
			$('.counter').show();
			 var noofrecord=0;	
			jQuery('input[type="checkbox"]').each(function() { 	
			     
				var CClass = jQuery(this).parents("tr").attr('class');	
				if (CClass.indexOf("filtered") ==-1) { 
					var attrid = jQuery(this).attr('id');	
					
						jQuery('#'+attrid).removeAttr('class');
						jQuery('#'+attrid).prop("checked", true);
					noofrecord++;
			  	}
		   });
		   $('.counter').text(noofrecord-1+": records are selected");
	
        } else {
			jQuery('input[type="checkbox"]').each(function() {
				jQuery(this).removeAttr("checked");
				 $('.counter').text("0"+": records are selected");
				 $('.counter').hide();
			});
        }
		
		
    });
	
	jQuery('.odsentchk').click(function () {	 
        	var noofrecord=0;		
			jQuery("#checkAll").removeAttr("checked");
			$('.counter').show();
			jQuery('input[type="checkbox"]').each(function() { 	
	
				if ($(this).is(':checked')) {	
			     noofrecord++;			
				}
				
	        });
			if(noofrecord<1)
			{
			$('.counter').hide();
			}
	   $('.counter').text(noofrecord+": records are selected");
        
    });
	
	
	jQuery('.dosorting').click(function(){
			jQuery('input[type="checkbox"]').each(function() {
				jQuery(this).removeAttr("checked");
			});	
	});
	
 });
 
function saveToLog(action){
	var comment = $('#crm_comment_option').val();
	var scenario_id = '<?php echo $scenario_id; ?>';
	var cust_id = '<?php echo $SELECTED_CUSTOMER; ?>';
	$.post(base_url+"scenarios/validates/"+scenario_id,{'log_entry':action,'comment':comment,'cust_id':cust_id},function(data){ //alert(data);
		if(data){ 
			//alert("Scenario "+action);
			if(data=="scenario_accepted"){
				$('#sc_state').text('5');
			}else if(data=="scenario_rejected"){
				$('#sc_state').text('6');
		
			}else if(data=="scenario_validate_requested"){
				$('#sc_state').text('6');
			}
			
			window.location.reload();
		}
	}); 

 }

</script>

<script type="text/javascript">
	function selectAll(x) {
	for(var i=0,l=x.form.length; i<l; i++)
	if(x.form[i].type == 'checkbox' && x.form[i].name != 'sAll')
	x.form[i].checked=x.form[i].checked?false:true
	}
</script>
<script>
function dispinput(val) {
	if(val=="nm") {
		jQuery('#inpt').fadeIn();
		jQuery('#nm').fadeOut();
	}
}
</script>
<script>
	jQuery(document).ready(function(){
		jQuery('input#inpt').keypress(function(e) {
          if (e.which == '13') {

		var scenerio_name = jQuery('#inpt').val();
		var scenerio_id = '<?php echo $scenario_id; ?>';
		var TargetURL = "<?php echo Configure::read('base_url');?>scenarios/edittitles/scenerio_id:"+scenerio_id+"/scenerio_name:"+scenerio_name;
					
			jQuery.post( TargetURL, function( data ) {					
					
					 jQuery("#nm").html(data);	
					 jQuery('#nm').fadeIn();
		             jQuery('#inpt').fadeOut();				
					 jQuery('#Id').val(data);
					
			});  
		  }
		  
		}); 
    });	
	

</script>
   <?php //echo $this->element('pagination/top');  ?>
                <div class="pagerscenarioedit form-horizontal">
                <?php echo __("totalEntries")?><span class="countdisplay"><?php echo $odsTotalrecord;?></span><?php echo __("entriesPerPage"); ?>: 
                    <select class="pagesize input-mini" title="Select page size">
                        <option selected="selected" value="10">10</option>
                        <option selected="selected" value="25">25</option>
                        <option selected="selected" value="50">50</option>
                        <option selected="selected" value="100">100</option>
                       
                    </select>
                </div>    
<table id="example" class="dataTable tablesorter tablesorterjquery" cellpadding="0" cellspacing="0" style="width:98%; margin-left:5px; border-top-color:#CCC">
				<thead>
				<tr class="table-top">
				 <th class="table-column table-left-ohne" style="border-bottom:#CCCCCC 1px solid; border-right: 1px solid #CCCCCC;border-top:#CCCCCC 1px solid;">&nbsp;</th>
                 <th class="table-column table-left-ohne withdatatablecss"><input type="checkbox" name="sAll" id="checkAll" class="showselect" style="margin-left:25px !important;"></th>
				 <th class="table-column dosorting withdatatablecss">&nbsp;&nbsp;Source&nbsp;&nbsp;</th>
				 <th class="table-column dosorting withdatatablecss">&nbsp;&nbsp;Dest&nbsp;&nbsp;</th>
				 <th class="table-column filter-select filter-exact dosorting withdatatablecss" data-placeholder="State">&nbsp;&nbsp;State&nbsp;&nbsp;</th>
				 

				 
                 <th class="table-column table-right-ohne withdatatablecss">&nbsp;</th>
                 <th class="table-column table-right-ohne" style="border-bottom:#CCCCCC 1px solid;border-top:#CCCCCC 1px solid;">&nbsp;</th>
				 </tr>
				</thead>
				<tfoot>
				<th colspan="8" class="pagerscenarioedit form-horizontal">
				<!--<button type="button" class="btn first"><i class="icon-step-backward"></i></button>
				<button type="button" class="btn prev"><i class="icon-arrow-left"></i></button>
				<span class="pagedisplay"></span>
				<button type="button" class="btn next"><i class="icon-arrow-right"></i></button>
				<button type="button" class="btn last"><i class="icon-step-forward"></i></button>-->
                
                
                <span><a class="first" href="javascript:;">&lt;&lt;</a></span>
                <span><a class="prev" href="javascript:;">&lt;</a></span>
                 <span><?php __('Page'); ?></span>
                <select class="pagenum input-mini hide" title="Select page number"></select>
                <span class="pagedisplay"></span> <!-- this can be any element, including an input -->			
                <span><a class="next" href="javascript:;">&gt; </a></span>
                <span><a class="last" href="javascript:;">&gt;&gt; </a></span>
                
                
				</th>
				</tr>
				</tfoot>
				 <tbody >
				 <?php foreach ($odsEntryList as $res)  {  ?>

				 <tr style="background-color:#FFF; border-bottom:#CCCCCC 1px solid; border-right: 1px solid #CCCCCC;">
                
				  <td class="table-left withdatatablecss" id="firstchild<?php echo $res['Odsentry']['id']; ?>">&nbsp;</td>
                   <td class="table-right-ohne withdatatablecss"><input type="checkbox" class="odsentchk" name="a<?php echo $res['Odsentry']['id']; ?>" value="<?php echo $res['Odsentry']['id']; ?>" id="chk<?php echo $res['Odsentry']['id']; ?>" style="margin-left:25px !important;" /> </td>
				 <td class="withdatatablecss"><?php echo $res['Odsentry']['source']; ?></td>
			 	 <td class="withdatatablecss">
					<!--<div class="input text">-->
					<?php echo $html->link(__($res['Odsentry']['dest'], true),'#',array('style'=>'display:none;','class'=>'getVal')); ?>
					
					 <?php if($PerformDisable==1){ ?>					
                     <input class="space_check destname"  AUTOCOMPLETE=OFF id="d<?php echo $res['Odsentry']['id']; ?>" name="<?php echo $res['Odsentry']['source']; ?>" type="text" value="<?php echo trim($res['Odsentry']['dest']); ?>" size="13" <?php echo $readonlytextbox; ?> >
					 <?php } else { ?>
					  <input class="space_check destname" onkeyup="chngbkcolor(this);"  AUTOCOMPLETE=OFF id="d<?php echo $res['Odsentry']['id']; ?>" name="<?php echo $res['Odsentry']['source']; ?>" type="text" value="<?php echo trim($res['Odsentry']['dest']); ?>" size="13" <?php echo $readonlytextbox; ?> >
					 <?php } ?>
                   <!--</div>-->
				 </td>
				 <td id="sc_state_medium " class="withdatatablecss sc_state_medium<?php echo $res['Odsentry']['id']; ?>" align="center"><?php echo ($res['Odsentry']['dest']) ? 'Valid' : 'Invalid'; ?></td>
				 

				  <td class="table-right-ohne withdatatablecss"><div style="width:50px;"> <?php echo $html->link( __("", true),'javascript:deleteOdsentry('.$res['Odsentry']['source'].','.$res['Odsentry']['scenario_id'].',this);',array('id'=>$res['Odsentry']['source'],'class'=>'deleteOdsentry'));  ?></div> </td>
                  <td class="withdatatablecss">&nbsp;</td>
				 </tr>
				<?php } ?>
				 </tbody>
				 
				</table>