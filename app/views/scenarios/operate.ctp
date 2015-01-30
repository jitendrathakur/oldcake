<?php
echo $javascript->link('/js/jquery.fancybox');
echo $this->element('editable');
?>

<?php
$ScenarioStatus = $scenarioDetails[0]['Scenario']['status'];
$PerformDisable = 0;
if ($ScenarioStatus == 5 || $ScenarioStatus == 6 || $ScenarioStatus == 7) {
    $readonlytextbox = "readonly='true'";
    $PerformDisable = 1;
    $class = "button-left-readonly";
} else {
    $readonlytextbox = '';
    $class = "button-left";
}
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.fancybox').fancybox();

        //Disable the buttons if scenario is completed i.e. status=6
<?php
if ($PerformDisable == 1) {
    ?>
            // Disable Add Number buttons
            jQuery('#add_numbers').removeAttr("onmouseout");
            jQuery('#add_numbers').removeAttr("href");
            jQuery('#add_numbers').removeAttr("onmouseover");
            jQuery('#add_numbers').attr("class", "pointer");

            //Disable edit selected and hide pop up over menu
            jQuery('#edit_selected_scenario_popupmenu').hide();
            jQuery('#edit_selected_scenario').removeAttr("onmouseout");
            jQuery('#edit_selected_scenario').removeAttr("href");
            jQuery('#edit_selected_scenario').removeAttr("onmouseover");
            jQuery('#edit_selected_scenario').attr("class", "pointer");

            // Disable All Checkboxes
            jQuery('#reloadwholdpagedata input[type="checkbox"]').each(function() {
                jQuery(this).attr("disabled", true);
            });

            //Disable Delete options
            jQuery('.deleteOdsentry').removeAttr("href");
            jQuery('.deleteOdsentry').attr("class", "deleteOdsentry pointer");


<?php } ?>

    });

    function submenuactivity(obj, action) {
        if (action == 1) {
            //$('.table-menu-popup').show();
			$('#table-popup').show();
        } else if (action == 0) {
           // $('.table-menu-popup').hide();
			$('#table-popup').hide();
        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
		
		            

        $('#minus').hide();
        $('#mbtn').hide();

        $('#minus').click(function() {
            $('#pbtn').show();
            $('#minus').hide();
            $('#mbtn').hide();
            $('#plus').show();
        });

        $('#minus_schedule').hide();
        $('#mbtn_schedule').hide();

        $('#minus_schedule').click(function() {
            $('#pbtn_schedule').show();
            $('#minus_schedule').hide();
            $('#mbtn_schedule').hide();
            $('#plus_schedule').show();
        });

        $('#plus_schedule').click(function() {
			
            $('#pbtn_schedule').hide();
            $('#minus_schedule').show();
            $('#mbtn_schedule').show();
            $('#plus_schedule').hide();
        });

        $('#minus_ods').hide();
        $('#mbtn_ods').hide();

        $('#minus_ods').click(function() {
            $('#pbtn_ods').show();
            $('#minus_ods').hide();
            $('#mbtn_ods').hide();
            $('#plus_ods').show();
        });

        $('#plus_ods').click(function() {
            $('#pbtn_ods').hide();
            $('#minus_ods').show();
            $('#mbtn_ods').show();
            $('#plus_ods').hide();
        });
    });

</script>

<script type="text/javascript">
    function chngbkcolor(obj) {
        $(document).ready(function() {

            var valueToFind = jQuery(this).val();
            var CurrId = jQuery(obj).attr('id');

            jQuery('#save' + CurrId).show();
            jQuery('#trick' + CurrId).hide();

            var val = jQuery('#' + CurrId).val();
            var RowId = CurrId.substring(1, CurrId.length);

            jQuery('#chk' + RowId).removeAttr("class");
            jQuery('#chk' + RowId).attr("class", "changedodsentry");

            if (val != '') {
                jQuery('.sc_state_medium' + RowId).html('Edited');
            }


            jQuery('#savedestinations').attr("onclick", "javascript:saveOdsentry(this);");
            jQuery('#savedestinations').attr("class", "showhighlight_buttonleft");
            jQuery('#destid').val(CurrId);

            jQuery('#updateOdsentry').removeAttr("class");
            jQuery('#updateOdsentry').attr("class", "button-right-hover");
        });

    }
    $(document).ready(function() {
        $('.counter').hide();
		
		$('.deldest').hide();
		$('.cntchk_updatemsg2').hide();
        $('#savescenariotitle').click(function() {
            var scenario_name = jQuery('.scenarios').val();
			if(scenario_name==""){
				$('#overlay-error .error .message').text("<?php __('Please enter Scenario Name') ?>");
		        $('#overlay-error').removeClass('hide');
				$('#overlay-sucess').addClass('hide');
                $('#Id').focus();
                return false;
			}else{
				
			
            var scenario_id = '<?php echo $scenario_id; ?>';
            var customer_id = '<?php echo $customer_id; ?>';
            var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/update_scname/scenario_id:" + scenario_id + "/customer_id:" + customer_id + "/scenario_name:" + scenario_name;
            jQuery.post(TargetURL, function(data) {
                //jQuery('.scenarios').val(data);
                //var msgd = data.trim();
                var msgd = data;
				
                window.location.href = "<?php echo Configure::read('base_url'); ?>scenarios/edit/scenario_id:" + msgd;
				$('#overlay-sucess .ok .message').text("<?php __('Scenario Updated Sucessfully') ?>");
		       $('#overlay-sucess').removeClass('hide');
               //jQuery('#scenariossuccess').html('<font class="scenarioupdatemsg">Scenario updated successfully!</font>');
            });
            //window.location.href = "<?php echo Configure::read('base_url'); ?>scenarios/edit/customer_id:sv13";
			}
        });

        $('#crm_comment_option').val('');
    });
    function saveOdsentry(id) {
        var senddata = [];
        jQuery('.changedodsentry').each(function() {

            var style = jQuery('.saveOdsentry').attr('style');
            var rowid = jQuery(this).attr('id');
            var attrlen = rowid.length;
            var Orowid = rowid.substring(2, attrlen);
            var Dbrowid = rowid.substring(3, attrlen);
            var Destval = jQuery('#d' + Dbrowid).val();
            senddata.push(Dbrowid + "=" + Destval);

        });

        var serialized = senddata.join("&")
        var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/updatemultipleodsentry/";
        var ScenarioId = $('#scenario_id').val();
        $('.black_overlay').show();
        jQuery.post(TargetURL, {'odsdata': serialized, 'scenario_id': ScenarioId}, function(data) {
            jQuery('#destid').val('');
            jQuery('.saveOdsentry').attr("style", "display:none");
            jQuery(' .trickOdsentry').attr("style", "display:inline");
            jQuery('#updateOdsentry').removeAttr("class");
            jQuery('#savedestinations').removeAttr("class");
            jQuery('#updateOdsentry').attr("class", " button-right-disabled");
            jQuery('#savedestinations').removeAttr("onclick");
            // Update Scenario Status
            var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/ScenarioCompletedOrNot/scenario_id:" + ScenarioId;

            jQuery.post(TargetURL, function(response) {
                jQuery('#Status').val(response);
                jQuery('#sts').html('Status :' + response);
                var msgd = response.trim();
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

            // Change Odsentry state
            jQuery('#reloadme input[type="text"]').each(function() {
                var sid = jQuery(this).attr('id');
                var val = jQuery('#' + sid).val();
                var RowId = sid.substring(1, sid.length);
                if (val != '') {
                    jQuery('.sc_state_medium' + RowId).html('Valid');
                }
            });

            setTimeout(function() {
                $('.black_overlay').hide();
            }, 500);

        });
    }
    function toggleAdvanceSearch() {
        //$("#advancesearch").show
        if (document.getElementById('advancesearch').style.display == 'none') {
            document.getElementById('advancesearch').style.display = 'block';
        } else {
            document.getElementById('advancesearch').style.display = 'none';
        }

    }
    function toggleShowHistory() {
        //$("#advancesearch").show
        if (document.getElementById('showhistory').style.display == 'none') {
            document.getElementById('showhistory').style.display = 'block';
        } else {
            document.getElementById('showhistory').style.display = 'none';
        }
    }
    function toggleexecutionschedule() {
        //$("#advancesearch").show
        if (document.getElementById('showexecution').style.display == 'none') {
            document.getElementById('showexecution').style.display = 'block';
        } else {
            document.getElementById('showexecution').style.display = 'none';
        }

    }
    function toggleodsentries() {
        //$("#advancesearch").show
        if (document.getElementById('showods').style.display == 'none') {
            document.getElementById('showods').style.display = 'block';
        } else {
            document.getElementById('showods').style.display = 'none';
        }

    }
</script>
<script>
	function fancyboxclose(){
		setTimeout( function() { $('#close-btn').trigger('click'); },5);
	 	}
		function fancyboxclose2(){
		setTimeout( function() { $('#close-btn2').trigger('click'); },5);
	 	}
		
</script>
<style>
    .tablesorter-filter
    {
        width:100% !important;
		margin: 0 -2px !important;
    padding: 4px 1px !important;
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
        border:none;
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
        border-bottom:#D1D1D1 1px solid !important; border-right: 1px solid #D1D1D1 !important;border-top:#D1D1D1 1px solid !important; border-radius:0px !important;	border-left: 1px solid #D1D1D1!important;
    }
.tablesorter-filter-row td
	{
		 border-right: 1px solid #D1D1D1 !important;border-top:#D1D1D1 1px solid !important; border-radius:0px !important;border-left: 1px solid #D1D1D1!important;
	}
    .tablesorter-icon {
        background-image: url("../../images/assets/table-sort-default.gif");
    }
#mcTooltipWrapper {
	display:none;
}
.t_Tooltip{
	display:none !important;
}
.tablesorter-bootstrap .tablesorter-header i {
    background-repeat: no-repeat;
    display: inline-block;
    float: right!important;
    height: 14px;
    left: 6px;
    line-height: 14px;
    margin-top: 10px!important;
    position: absolute; 
    width: 12px;
}
.tablesorter-bootstrap .tablesorter-header-inner {
    font-size: 11px;
    padding: 2px 10px 4px 0!important;
    position: relative;
}
</style>
<script type="text/javascript">
    function deleteOdsentry(record_id, scid, elem) {
        $.post(base_url + 'odsentries/delete/' + record_id + '/' + scid, {}, function(data) {
            //$('#'+record_id).closest('tr').remove();
            alert('Record is deleted successfully');
            $('#reloadwholdpagedata').html(data);
            /*if(data=="success"){
             $('#'+record_id).closest('tr').remove();
             alert('Record is deleted successfully');
             }*/
        });
    }
    function submit_form(action) {
        //alert(action);
        $('.filtersForm').attr('action', base_url + 'odsentries/index/' + action);
        $('.filtersForm').attr('method', 'POST');
        $.ajax({
            type: "POST",
            async: false,
            dataType: 'json',
            url: $('.filtersForm').attr('action'),
            data: $('.filtersForm').serialize(),
            success: function(data) {  //alert(data);
                if (data.message == "updated") {
                    alert(data.affectedRows + 'Record(s) updated successfully')
                } else {
                    alert('Some error occured, Please try again');
                }
            }
        });
    }

    /* ### Change Pagination style Script ### */
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
				page2 = temp[1].split("/");
				page3=page2[1].split("(");
				var showrecord = page3[0];
                //console.log(temp);
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

                if (rightKey[0] % 10 >= 0) {
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

            }, 1000);
        }//
    });

    jQuery(function() {
        jQuery.extend(jQuery.tablesorter.themes.bootstrap, {
            // these classes are added to the table. To see other table classes available,
            // look here: http://twitter.github.com/bootstrap/base-css.html#tables	
        });
        // call the tablesorter plugin and apply the uitheme widget
        jQuery(".tablesorterscenario").tablesorter({
            // this will apply the bootstrap theme if "uitheme" widget is included
            // the widgetOptions.uitheme is no longer required to be set
            theme: "bootstrap",
            widthFixed: true,
            bFilter: false,
            bInfo: false,
            icons: '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
            sortNone: 'bootstrap-icon-unsorted',
            sortAsc: 'icon-chevron-up',
            sortDesc: 'icon-chevron-down',
            headerTemplate: '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!

            // widget code contained in the jquery.tablesorter.widgets.js file
            // use the zebra stripe widget if you plan on hiding any rows (filter widget)
            widgets: ["uitheme", "filter", "zebra"],
            widgetOptions: {
                // using the default zebra striping class name, so it actually isn't included in the theme variable above
                // this is ONLY needed for bootstrap theming if you are using the filter widget, because rows are hidden
                zebra: ["even", "odd"],
                // reset filters button
                filter_reset: ".reset"

                        // set the uitheme widget to use the bootstrap theme class names
                        // this is no longer required, if theme is set
                        // ,uitheme : "bootstrap"
            },
            headers: {
                0: {sorter: false, filter: false},
                1: {sorter: true, filter: true},
                2: {sorter: 'digit'},
                4: {sorter: false, filter: false},
                6: {sorter: false, filter: false}

            }
        })
                .tablesorterPager({
                    // target the pager markup - see the HTML block below
                    container: jQuery(".pagerscenarioedit"),
                    // target the pager page select dropdown - choose a page
                    cssGoto: ".pagenum",
                    initWidgets: true,
                    // remove rows from the table to speed up the sort of large tables.
                    // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
                    removeRows: false,
                    // output string - default is '{page}/{totalPages}';
                    // possible variables: {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
                   // output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'
                    //  output: 'Page <input type="text" name="currpage" value="{page}" class="pagination_text" maxlength="3"> Of {totalPages}'
					 output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'
                });

        jQuery(".smallwidth").focus(function() {
            var valueToFind = jQuery(this).val();
            if (valueToFind == 'DN From' || valueToFind == 'DN To') {
                jQuery(this).val('');
            } else {
                jQuery(this).val(valueToFind);
            }
        });

        jQuery(".smallwidth").focusout(function() {
            var valueToFind = jQuery(this).val();
            if (valueToFind == '' || valueToFind == '') {
                var id = jQuery(this).attr('id');
                if (id == 'min')
                    jQuery(this).val('DN From');
                else if (id == 'max')
                    jQuery(this).val('DN To');
            }
        });

        jQuery("#filter_now").click(function() {
            var MinVal = jQuery('#rangeMinMinval').val();
            var MaxVal = jQuery('#rangeMaxMaxval').val();

            if ((MinVal.length < 9 || MinVal.length > 9) && (MaxVal.length < 9 || MaxVal.length > 9)) {
                alert('Filter Range From and To Must Be 9 digits!');
                return false;
            } else {

                if (isNaN(MinVal) || isNaN(MaxVal)) {
                    alert('Filter Range must be numeric only!');
                    return false;
                } else {
                    jQuery("#form").submit();
                }
            }
        });

        jQuery("#reset_filter").click(function() {
            jQuery('#rangeMinMinval').val('');
            jQuery('#rangeMaxMaxval').val('');
            jQuery("#form").submit();
        });

        jQuery(".deldest").click(function() {
            jQuery('input[type="checkbox"]:checked').each(function() {
                var Odsentryid = jQuery(this).val();
                var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/deletedest/dest_id:" + Odsentryid;
                jQuery.post(TargetURL, function(data) {
                    jQuery("#firstchild" + data).parents("tr").hide();
                });
                jQuery("#firstchild" + Odsentryid).parents("tr").hide();
            });

            jQuery('input[type="checkbox"]:checked').each(function() {
                jQuery(this).attr("checked", false);
            });

            setTimeout(function() {
                window.location.reload();
            }, 1000);
        });

        /*Check All / Uncheck All functionality*/
        jQuery("#checkAll").click(function() {
            if (jQuery("#checkAll").is(':checked')) {

                $('.counter').show();
				$('.deldest').show();
				$('.cntchk_updatemsg2').show();
                var noofrecord = 0;
                jQuery('input[type="checkbox"]').each(function() {

                    var CClass = jQuery(this).parents("tr").attr('class');
                    if (CClass.indexOf("filtered") == -1) {
                        var attrid = jQuery(this).attr('id');

                        jQuery('#' + attrid).removeAttr('class');
                        jQuery('#' + attrid).prop("checked", true);
                        noofrecord++;
                    }
                });
                $('.counter').text(noofrecord - 1 + ": records are selected");
				$('.cnt').text("<?php echo __('Update Selected'); ?> : " + (noofrecord - 1 ));

            } else {
                jQuery('input[type="checkbox"]').each(function() {
                    jQuery(this).removeAttr("checked");
                    $('.counter').text("0" + ": records are selected");
					$('.cnt').text("");
					$('.cntchk_updatemsg2').hide();
                    $('.counter').hide();
					$('.deldest').hide();
                });
            }
        });

        jQuery('.odsentchk').click(function() {
            var noofrecord = 0;
            jQuery("#checkAll").removeAttr("checked");
            $('.counter').show();
			
			$('.deldest').show();
			$('.cntchk_updatemsg2').show();
            jQuery('input[type="checkbox"]').each(function() {

                if ($(this).is(':checked')) {
                    noofrecord++;
                }
            });
            if (noofrecord < 1)
            {
                $('.counter').hide();
				$('.deldest').hide();
				$('.cntchk_updatemsg2').hide();
            }
            $('.counter').text(noofrecord + ": records are selected");
			$('.cnt').text("<?php echo __('Update Selected'); ?> : " + (noofrecord ));

        });


        jQuery('.dosorting').click(function() {
            jQuery('input[type="checkbox"]').each(function() {
                jQuery(this).removeAttr("checked");
            });
        });

    });

    function saveToLog(action) {
        var comment = $('#crm_comment_option').val();
        var scenario_id = '<?php echo $scenario_id; ?>';
        var cust_id = '<?php echo $SELECTED_CUSTOMER; ?>';
        $.post(base_url + "scenarios/validates/" + scenario_id, {'log_entry': action, 'comment': comment, 'cust_id': cust_id}, function(data) { //alert(data);
            if (data) {
                //alert("Scenario "+action);
                if (data == "scenario_accepted") {
                    $('#sc_state').text('5');
                } else if (data == "scenario_rejected") {
                    $('#sc_state').text('6');

                } else if (data == "scenario_validate_requested") {
                    $('#sc_state').text('6');
                }

                window.location.reload();
            }
        });

    }

</script>

<script type="text/javascript">
    function selectAll(x) {
        for (var i = 0, l = x.form.length; i < l; i++)
            if (x.form[i].type == 'checkbox' && x.form[i].name != 'sAll')
                x.form[i].checked = x.form[i].checked ? false : true
    }
</script>
<script>
    function dispinput(val) {
        if (val == "nm") {
            jQuery('#inpt').fadeIn();
            jQuery('#nm').fadeOut();
        }
    }
</script>
<script>
    jQuery(document).ready(function() {
        jQuery('input#inpt').keypress(function(e) {
            if (e.which == '13') {

                var scenerio_name = jQuery('#inpt').val();
                var scenerio_id = '<?php echo $scenario_id; ?>';
                var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/edittitles/scenerio_id:" + scenerio_id + "/scenerio_name:" + scenerio_name;

                jQuery.post(TargetURL, function(data) {

                    jQuery("#nm").html(data);
                    jQuery('#nm').fadeIn();
                    jQuery('#inpt').fadeOut();
                    jQuery('#Id').val(data);

                });
            }
        });
    });

function chngbkcolor2(obj) {
			  $(document).ready(function() {
				  $('#savescenariotitle').attr("class", "showhighlight_buttonleft");
				  $('#updatescenario').removeAttr("class");
				  $('#updatescenario').attr("class", "button-right-hover");

			  });
		  }
</script>
 <script>
  	function scenario_delete(val,val2){
		//string = document.referrer;
		
		//alert(val+'/'+val2);
		
		
		var clickedScenario = $('#ScenarioUID').val();
		var clickedExecution = $('#ExecutionUID').val();
		
		
		var TargetURL = "<?php echo Configure::read('base_url');?>scenarios/delete_schedule/"+clickedScenario+"/"+clickedExecution;
	
 		jQuery.post( TargetURL,  function( data ) {  //alert(data);
			window.location.href = "<?php echo Configure::read('base_url'); ?>scenarios/edit/scenario_id:"+clickedScenario+"&mode=operate&etype=deleted";
	});
	//window.location.reload();
}
  </script>
  <script>
  	function deletesource(val){
		//alert(val);
		
		var TargetURL = "<?php echo Configure::read('base_url');?>scenarios/deleteScenario/scenario_id:"+val;
	
 		jQuery.post( TargetURL,  function( data ) {  //alert(data);
			//window.location.reload();
			window.location.href = "<?php echo Configure::read('base_url'); ?>scenarios/index/customer_id:<?php echo $SELECTED_CUSTOMER; ?>";
	});
	//window.location.reload();
}
  </script>

<style type="text/css">
	/* CSS for modelpopup */
	     
	#clicker	{			
		cursor:pointer;
	}
	#popup-wrapper		{
		width:390px;
		height:150px;
		background-color:#fff;
		padding:10px;		
	}
	#clicker2	{			
		cursor:pointer;
	}
	#popup-wrapper2		{
		width:390px;
		height:180px;
		background-color:#fff;
		padding:10px;		
	}
	body	{
	    padding:10px;
	}
.demonstrations1 div {
  float: right;
  width: 20px;
  height: 30px;
  margin: -19px 0 5px!important;
  cursor: pointer;
  font-size: 15px;
  font-weight: bold;
}

</style>

<script type="text/javascript">
//script for modelpopup

	  function InitScenario(val,val2){
	  	
		
				
		document.getElementById('ScenarioUID').value= val;
		document.getElementById('ExecutionUID').value= val2;
	  }

	$(function () {
		
	    $('#popup-wrapper').modalPopLite({ openButton: '.clicker', closeButton: '#close-btn', isModal: true });
		$('#popup-wrapper2').modalPopLite({ openButton: '.clicker2', closeButton: '#close-btn2', isModal: true });
					
	});
	
</script>

<!--######## Start  Save Leave Page Event #################-->
<?php $leaveStatus = Configure :: read('leaveStatus'); ?>
<?php if ($leaveStatus[0] == "on") { ?>
    <script language="JavaScript">
        var ids = new Array('destid');
        var values = new Array('');

        function populateArrays()
        {
            // assign the default values to the items in the values array
            for (var i = 0; i < ids.length; i++)
            {
                var elem = document.getElementById(ids[i]);
                if (elem)
                    if (elem.type == 'checkbox' || elem.type == 'radio')
                        values[i] = elem.checked;
                    else
                        values[i] = elem.value;
            }
        }
        var needToConfirm = true;
        window.onbeforeunload = confirmExit;
        function confirmExit()
        {
            if (needToConfirm)
            {
                // check to see if any changes to the data entry fields have been made
                for (var i = 0; i < values.length; i++)
                {
                    var elem = document.getElementById(ids[i]);
                    if (elem)
                        if ((elem.type == 'checkbox' || elem.type == 'radio')
                                && values[i] != elem.checked)
                            return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
                        else if (!(elem.type == 'checkbox' || elem.type == 'radio') &&
                                elem.value != values[i])
                            return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
                }

                // no changes - return nothing      
            }
        }
    </script>
<?php } ?>

<div class="update_message"></div>

<div id="overlay-error" class="notification first hide" style="width: 98%; margin-left:5px;margin-right:5px;" >
    
    <div class="error">
        <div class="message">
            
        </div>
    </div>
</div>

<div id="overlay-sucess" class="notification first hide" style="width: 98%; margin-left:5px;margin-right:5px;" >
    
    <div class="ok">
        <div class="message">
            
        </div>
    </div>
</div>

<?php
#-----------------------------------------------------------------#
# $Rev:: 22            $:  Revision of last commit                #
#-----------------------------------------------------------------#
//echo $form->create(null, array('id' => 'LocationEditForm', 'url' => array('controller' => 'locations', 'action' => 'update/'.$location_id),'accept-charset'=>'ISO-8859-1'));


if((isset($success)) && $success){?>
	
		<div class="notification first" style="width: 98%; margin-left:5px;margin-right:5px;" >
		
			<div class="ok">
				<div class="message">
					<?php echo $success;?>
				</div>
			</div>
		</div>
		
	<?php }elseif(isset($error) && $error){?>
		<div class="notification first" style="width: 98%; margin-left:5px;margin-right:5px;">
			<div class="error">
				<div class="message">
					<?php 
						#echo $error;
						if($error=='xml_not_respond')
							_("Xml Server is not responding");
						else
							__("There was a problem in applying the changes.");
					?>
				</div>
			</div>
		</div>
	<?php }
		else { echo '<br>'; }


if (empty($scenarioDetails)) {
    ?>
	<script>
		$(document).ready(function() {
		$('#overlay-sucess .ok .message').text("<?php __('please add Scenario details') ?>");
		$('#overlay-sucess').removeClass('hide');
      });
	</script>
    <h4 style="margin-left:5px;"><?php echo __('scenarioName'); ?><?php echo $scenarioDetails[0]['Scenario']['Name'] ?></h4>
    <p style="margin-left:10px;"><?php echo __('createText', true) ?>
    <form id="form" class="filtersForm" action="<?php echo Configure::read('base_url'); ?>scenarios/edit/scenario_id:<?php echo $scenario_id; ?>" enctype="multipart/form-data" method="POST">    
        <input type="hidden" name="scenario_id" id="scenario_id" value="<?php echo $scenario_id; ?>" />
        <br>
        <div class="form-box">
            <div class="form-left">
                <?php
                echo '<div style="width:100px; float: left;margin-left:10px;">' . __('name', true) . '</div>';
                echo $form->input('Id', array('label' => false, 'value' => $scenarioDetails[0]['Scenario']['Name'], 'class' => 'scenarios form-changevalidate', 'style' => 'width:150px;','onkeyup'=>'chngbkcolor2(this)'));
                ?>		
                <div id="scenariossuccess"></div>					
            </div>
            <div class="form-box" >
                <div class="button-right" id="updatescenario">
                    <a id="savescenariotitle" onmouseout="outButtonRight(this)" onmouseover="hoverButtonRight(this)" href="javascript:void(0);"  onclick="namevalidate();">Save</a>
                </div>
            </div>	
        </div>
    </div>
    <?php
} else {
    ?>


    <?php $scenarioStatus = Configure :: read('scenarioStatus'); ?>

    <!--   <div id="content"> -->
    <h4 style="margin-left:10px!important;margin-right:10px!important;"><?php echo __('scenarioName'); ?> 
       <a data-title="Enter Scenario Name" data-placement="right" data-type="text" id="scenerio_name" href="#" class="editable editable-click" data-original-title="" title="" style="display: inline;"><?php echo trim($scenarioDetails[0]['Scenario']['Name']); ?> <span style="padding-left:45px;"></span></a>
       <?php /* ?> <span style="color:darkblue;" id="nm" onclick="dispinput('nm');"><?php echo $scenarioDetails[0]['Scenario']['Name']?></span>
         <input type="text" id="inpt" name="title" value="<?php echo $scenarioDetails[0]['Scenario']['Name']?>" style="display:none; width:150px;"/>

         <span style="float:right;" id="sts"><?php echo __('scenarioStatus') . ''  . $scenarioStatus[$scenarioDetails[0]['Scenario']['status']];	?>
         </span> 
        <?php */ ?>

        <span style="float:right;" id="sts"><?php echo __('scenarioState') . ' ' . __($scenarioStatus[$scenarioDetails[0]['Scenario']['status']], true); ?>		
        </span>

    </h4>

    <form id="form" class="filtersForm" action="<?php echo Configure::read('base_url'); ?>scenarios/edit/scenario_id:<?php echo $scenario_id; ?>" enctype="multipart/form-data" method="POST">    
        <input type="hidden" name="scenario_id" id="scenario_id" value="<?php echo $scenario_id; ?>" />
        <br>
          <div class="form-box">
               
                <div class="form-left">
				
                
                <div>	<span  id="edit_stat" style="margin-left:10px; float:left;cursor:default;font-weight: bold;"   <?php echo $readonly; ?>><?php __("ScenarioOperateOptions"); ?> </span></div>
				<br>
	      				   <ul style="margin: 0 0 0 10px">
      
                                <?php 
                                if($scenarioDetails[0]['Scenario']['status'] == 4) #inactive
                                {
									?>
                                	<li class="schedule">
                                <?php #echo $html->link(__('addCombox', true),'');?>
                                <a href="<?php echo Configure::read('base_url');?>scenarios/edit/scenario_id:<?php echo $scenarioDetails[0]['Scenario']['id']?>" onMouseOver="Tip('<?php echo __('editScenario') ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); "><?php echo __("editScenario", true); ?></a>    
                                </li>
                                <li class="schedule">
                                <?php #echo $html->link(__('addCombox', true),'');?>
									<a href="<?php echo Configure::read('base_url');?>scenarios/confirmapply?scenario_id=<?php echo $scenarioDetails[0]['Scenario']['id'].'&operation=activate'?>" onMouseOver="Tip('<?php echo __('activateScenario') ?>', BALLOON, true, ABOVE, false);" class="fancybox fancybox.ajax" onMouseOut="UnTip(); " ><?php echo __("activateScenario", true); ?></a>    
                                </li>
                               <?php 
                                }
                                if($scenarioDetails[0]['Scenario']['status'] == 6)
                                 {?>
                                <li class="schedule">
                                <?php #echo $html->link(__('addCombox', true),'');?>
                                <a href="<?php echo Configure::read('base_url');?>scenarios/confirmapply?scenario_id=<?php echo $scenarioDetails[0]['Scenario']['id'].'&operation=deactivate'?>" onMouseOver="Tip('<?php echo __('deactivateScenario') ?>', BALLOON, true, ABOVE, false);" class="fancybox fancybox.ajax" onMouseOut="UnTip(); " ><?php echo __("deactivateScenario", true); ?></a>    
                                </li>
                                <?php 
                                }
                                if(($userpermission == Configure::read('access_id')) && ($_SESSION['VIEWMODE'] != 'EXTERNAL') && ($scenarioDetails[0]['Scenario']['status'] >3))
                                
                                {?>
                                <li class="schedule">
                                <?php #echo $html->link(__('addCombox', true),'');?>
                                <a href="<?php echo Configure::read('base_url');?>scenarios/scriptdetails/<?php echo $scenarioDetails[0]['Scenario']['id']?>" onMouseOver="Tip('<?php echo __('viewScript') ?>', BALLOON, true, ABOVE, false);" class="fancybox fancybox.ajax" onMouseOut="UnTip(); " ><?php echo __("viewScript", true); ?></a>    
                                </li>
                                <li class="schedule">
                                <?php #echo $html->link(__('addCombox', true),'');?>
                                <a href="<?php echo Configure::read('base_url');?>scenarios/scriptsummary/<?php echo $scenarioDetails[0]['Scenario']['id']?>" onMouseOver="Tip('<?php echo __('viewSummary') ?>', BALLOON, true, ABOVE, false);" class="fancybox fancybox.ajax" onMouseOut="UnTip(); " ><?php echo __("viewSummary", true); ?></a>    
                                </li>
                                <?php 
                                }
                                
                                if(($scenarioDetails[0]['Scenario']['status'] == 1) ||
                                ($scenarioDetails[0]['Scenario']['status'] == 2)||
                                ($scenarioDetails[0]['Scenario']['status'] == 4)||
                                ($scenarioDetails[0]['Scenario']['status'] == 7))
                                {?>
                                <li class="schedule">
                                <?php #echo $html->link(__('addCombox', true),'');?>
									<a class="clicker2" href="<?php echo Configure::read('base_url');?>scenarios/deleteScenario/scenario_id:<?php echo $scenarioDetails[0]['Scenario']['id']?>" onMouseOver="Tip('<?php echo __('deleteScenario') ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " ><?php echo __("deleteScenario", true); ?></a>  
																									
									  
                                </li>
                               <?php } ?>
                            </ul>
                </div>
				
				<div>
					

	<div id="modalPopLite-mask" style="width:100%" class="modalPopLite-mask"></div>
	<div id="modalPopLite-wrapper" style="left: -10000px;z-index: 1;" class="modalPopLite-wrapper">
<div class="modalPopLite-child" id="popup-wrapper2">
<h4><?php echo __('Confirmation',true); ?>
		<span class='demonstrations1'>           
		   <span style="font-size: 18px !important; float: right;"> <a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="return fancyboxclose2(); UnTip();">X</a></span>		  
	        
			<span style="font-size: 18px !important; float: right;margin-right: 10px;"><a href="javascript:;"  style="cursor:pointer" onMouseOver="Tip('<b><?php echo __('confirmToDeleteScenario_helpTitel') ?></b><br/><?php echo __('confirmToDeleteScenario_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></span>				
    		
        </span>	
   </h4>
         <span style="width:230px; height:180px;margin:50px auto;  ">
		<h6><?php echo __("ConfirmDeleteScenario")?></h6> <br><br>
		 <span class="button-left" style="margin-left: 230px;">
		 <?php echo $html->link( __("Cancle", true),'javascript:void(null)',array('id' => 'close-btn2')); ?>
		 
		
		</span>
		<a href="#" id="close-btn2">
		</a>
		
		<span  class="button-right" style="margin-right:25px;">
		<?php echo $html->link(__("Ok", true), 'javascript:void(null)', array('onclick'=>'javascript:deletesource('.$scenarioDetails[0]['Scenario']['id'].')', 'id' => 'request_validation','class'=>'clicker2')); ?>
					
         </span>
				
		</span>		
	</div>
	
	
	</div>

	</div>
				
                <div class="form-right">
        		
               
               <?php
                   $ActivateWorkflowDisplay = ($scenarioDetails[0]['Scenario']['status'] == 4) ? 'display:block;' : 'display:none;';
                   $DeActivateworkflowDisplay = ($scenarioDetails[0]['Scenario']['status'] == 6) ? 'display:block;' : 'display:none;';
                   $CRMCommentWorkflowDisplay = ($scenarioDetails[0]['Scenario']['status'] == 3) ? 'height:120px;display:block;' : 'height:120px;display:none;';
                   $CompleteWorkflowDisplay = ($scenarioDetails[0]['Scenario']['status'] == 2) ? 'display:block;' : 'display:none;';
                   $RejectWorkflowDisplay = ($scenarioDetails[0]['Scenario']['status'] == 8) ? 'display:block;' : 'display:none;';
                   $InvalidWorkflowDisplay = ($scenarioDetails[0]['Scenario']['status'] == 1) ? 'display:block;' : 'display:none;';
               ?>				
                   <p id="crm_comment_workflow" style="<?php echo $CRMCommentWorkflowDisplay; ?>"><?php __(scenarioOperateWorkflowText_3) ?></p>                           
                   <p id="complete_workflow" style="<?php echo $CompleteWorkflowDisplay; ?>"><?php __(scenarioOperateWorkflowText_2) ?></p>
                   <p id="reject_workflow" style="<?php echo $RejectWorkflowDisplay; ?>"><?php __(scenarioOeprateWorkflowText_8) ?></p>
                   <p id="activate_workflow" style="<?php echo $ActivateWorkflowDisplay; ?>"><?php __(scenarioOperateWorkflowText_4) ?></p>
                   <p id="deactivate_workflow" style="<?php echo $DeActivateworkflowDisplay; ?>"><?php __(scenarioOeprateWorkflowText_6) ?></p>
                   <p id="invalid_workflow" style="<?php echo $InvalidWorkflowDisplay; ?>"><?php __(scenarioOperateWorkflowText_1) ?></p>	            
			</div>
		</div>
         
         
         
        <!-- Display buttons for actions -->
        <?php
        $ActivateButtonDisplay = ($scenarioDetails[0]['Scenario']['status'] == 4) ? 'display:block;' : 'display:none;';
        $DeActivateButtonDisplay = ($scenarioDetails[0]['Scenario']['status'] == 6) ? 'display:block;' : 'display:none;';
        $CRMCommentDisplay = ($scenarioDetails[0]['Scenario']['status'] == 3) ? 'height:120px;display:block;' : 'height:120px;display:none;';
        
        
        
        $RequestForValidateButtonDisplay = (($scenarioDetails[0]['Scenario']['status'] == 2) || ( $scenarioDetails[0]['Scenario']['status'] == 8)) ? 'display:block;' : 'display:none;';
        ?>					
        <div class="form-box" style="<?php echo $CRMCommentDisplay; ?>" id="crm_comment_div">
            <?php if (($userpermission == Configure::read('access_id')) && ($_SESSION['VIEWMODE'] != 'EXTERNAL')) {
                ?>
                <div class="form-left">

                    <?php echo '<div style="width:100px; float: left">' . __('SCM Comment', true) . '</div>';
                    echo $form->input('Log.modification_response', array('type' => 'textarea', 'class' => 'date-pick', 'style' => 'margin:4px 4px 5px 8px;width:350px;', 'label' => false, 'div' => false, 'id' => 'crm_comment_option', 'value' => '', 'default' => ''));
                    ?>
                </div>
                <div class="form-right">
                    <div class="button-right">
                        <?php echo $html->link(__("Accept", true), 'javascript:saveToLog("accepted")', array('onmouseover' => 'hoverButtonRight(this)', 'onmouseout' => 'outButtonRight(this)')); ?>
                    </div>

                    <div class="button-right">
                        <?php echo $html->link(__("Reject", true), 'javascript:saveToLog("rejected")', array('onmouseover' => 'hoverButtonRight(this)', 'onmouseout' => 'outButtonRight(this)')); ?>
                    </div>
                </div>
                <?php }
            ?>
        </div>   

        <div id="request_validationdiv" class="form-box" style="<?php echo $RequestForValidateButtonDisplay; ?>" >
            <div class="form-left">
                <div class="button-right">
                    <?php echo '' ?>
                </div>
            </div>
            <div class="form-right">
                <div class="button-right">
                    <?php echo $html->link(__("Request Validation", true), 'javascript:saveToLog("validate_request")', array('onmouseover' => 'hoverButtonRight(this)', 'onmouseout' => 'outButtonRight(this)', 'id' => 'request_validation')); ?>	

                </div>
            </div>
        </div>					  	

        <div class="form-box" style="<?php echo $ActivateButtonDisplay; ?>" id="activationdiv">
            <div class="form-left">
                <p></p>	
            </div>
            <div class="form-right">
                <div class="button-right">
                    <?php 
                    echo $html->link( __("activateScenario", true),array('controller'=>'scenarios', 'action'=>'confirmapply?scenario_id='.$scenarioDetails[0]['Scenario']['id'].'&operation=activate'), array('class'=>"fancybox fancybox.ajax"));
					#echo $html->link(__("Activate", true), array('controller' => 'scenarios', 'action' => 'create_schedule/' . $scenario_id . '/create/' . $SELECTED_CUSTOMER . '/0/activate'), array('class' => "fancybox fancybox.ajax", 'onmouseover' => 'hoverButtonRight(this)', 'onmouseout' => 'outButtonRight(this)')); ?>	

                </div>

            </div>
        </div>

        <div class="form-box" style="<?php echo $DeActivateButtonDisplay; ?>" id="deactivationdiv">
            <div class="form-left">
                <p></p>	
            </div>
            <div class="form-right">
                <div class="button-right">
                    <?php 
                    echo $html->link( __("deactivateScenario", true),array('controller'=>'scenarios', 'action'=>'confirmapply?scenario_id='.$scenarioDetails[0]['Scenario']['id'].'&operation=deactivate'), array('class'=>"fancybox fancybox.ajax"));
                
                    #echo $html->link(__("De-activate", true), array('controller' => 'scenarios', 'action' => 'create_schedule/' . $scenario_id . '/create/' . $SELECTED_CUSTOMER . '/0/deactivate'), array('class' => "fancybox fancybox.ajax", 'onmouseover' => 'hoverButtonRight(this)', 'onmouseout' => 'outButtonRight(this)')); ?>	
                </div>
            </div>
        </div>	

      

          

    <?php
	$show = 'none';
	$log = $this->params['url']['view'];
	 if($log == 'log'){
	 $show = 'none';
	} else {
		
	
    #$show = 'none';
   # if (($scenarioDetails[0]['Scenario']['status'] == 4) || ($scenarioDetails[0]['Scenario']['status'] == 5) || ($scenarioDetails[0]['Scenario']['status'] == 6) || ($scenarioDetails[0]['Scenario']['status'] == 7)) {
	if(1)
	{
    	$readonly = 'true';
        $show = 'block';
    } }
    ?>
            <div style="display:block"> 
               <h4 style="margin-left:10px!important;margin-right:10px!important;"> <?php echo __('executionSchedules'); ?> 
                 <a class="maintopRelatedContentButton" id="maintopContentButton" onclick="return toggleexecutionschedule();" href="javascript:void(0)" style="float:right;">
                   <div style="width:20px;background:#eee; height:20px;" id="pbtn_schedule">
                      <div id="plus_schedule"></div>
                   </div>
                   <div style="width:20px;background:#eee; height:20px;" id="mbtn_schedule">
                     <div id="minus_schedule"></div>
                   </div>
                 </a>
               </h4> 	
            </div>		     

            <div id="showexecution" style="display:<?php echo $show; ?>">	
			<table id="example dnslistdata" class="dataTable tablesorter table-content phonekey" cellpadding="0" cellspacing="0" style="width:96%; margin-left:10px;margin-right:10px; border-top-color:#D1D1D1">
                
                    <thead>
                        <tr class="table-top">
                            <!--<th class="table-column table-left-ohne">&nbsp;</th>-->
                            <th class="table-column" style="width:100px; text-align: left;"> <?php echo __('Operation'); ?></th>
                            <th class="table-column" style="width:100px; text-align: left;"> <?php echo __('scheduledDate'); ?></th>
                            <th class="table-column" style="width:100px; text-align: left;"> <?php echo __('createdBy'); ?></th>
                            <th class="table-column" style="width:100px; text-align: left;"> <?php echo __('createdDate'); ?></th>
                            <th class="table-column" style="width:30px; text-align: left;"> <?php echo __('option'); ?></th>
                        </tr>


                    </thead>
                    <tbody>
    <?php
    #$execRecords = count($scenario['Execution'])-1;
    $executions = $scenarioDetails[0]['Execution'];

    #print_r($executions);
    $dates = array();
    foreach ($executions as $key => $row) {
        $dates[$key] = $row['targetDate'];
    }
    array_multisort($dates, SORT_ASC, $executions);
    #print_r($executions);
    $counter = 1;
    foreach ($executions as $execution) {
        #if($scenario['Execution'][$iterateExecutions]['status'] =='SCHEDULED' || 
        #$scenario['Execution'][$iterateExecutions]['status'] =='INPROGRESS' || 
        #($scenario['Execution'][$iterateExecutions]['status'] == 'WARNING' &&  (strtotime("-5 day") <= strtotime($scenario['Execution'][$iterateExecutions]['modified'])))) 
        if ($execution['status'] == 'SCHEDULED' ||
                $execution['status'] == 'INPROGRESS') {
            ?>
                                <tr  onmouseover="hoverRow(this, true);" onmouseout="hoverRow(this, false);">
                                    
                                    <td style="width:70px;text-align: left;">
                                <?php echo __($execution['operation'],true); ?>
                                    </td>
                                    <td style="width:100px;text-align: left;">
                                <?php echo date('d.m.Y H:i', strtotime($execution['targetDate'])); ?>
                                    </td>
                                    <td style="width:100px;text-align: left;">
                                <?php echo date('d.m.Y H:i', $execution['user_id']); ?>
                                    </td>
                                    <td style="width:100px;text-align: left;">
                                <?php echo date('d.m.Y H:i', strtotime($execution['created'])); ?>
                                    </td>

                                        <?php
                                        if ($execution['status'] == 'WARNING') {
                                            echo '<td style="width:70px;text-align: left; color: red;">';
                                            echo $execution['status'];
                                            echo '</td>';
                                        } else {
                                            #	echo '<td style="width:70px;text-align: left;">';
                                            #	echo $execution['status'];
                                            #	echo '</td>';
                                        }
                                        ?>

                                    <?php
                                    if ($execution['status'] == 'SCHEDULED') {
                                        ?>
                                        <td class="table-right-ohne"  onmouseover="this.className = 'table-right-over';" onmouseout="this.className = 'table-right';" style="background: url(<?php echo $this->webroot ?>/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat 2px 2px;border-right:#D1D1D1 1px solid;" >
										
									
										
                                            <div class="table-menu">
                                                <div class="table-menu-popup">
                                                    <ul>
                                                        <li class="last delete">
                                        <?php
                                        if ($execution['status'] == 'SCHEDULED') {

                                            #echo $html->link( __("Delete Schedule", true),array('controller'=>'scenarios', 'action'=>'create_schedule/'.$scenario['Scenario']['id'].'/delete/'.$SELECTED_CUSTOMER_NAME.'/'.$execution['id']), array('class'=>"fancybox fancybox.ajax"));  											
                                            #echo $html->link(__("Delete Schedule", true), array('controller' => 'scenarios', 'action' => '/delete_schedule/' . $scenarioDetails[0]['Scenario']['id'] . '/' . $execution['id']));
                                            
									$scenario_id = $scenarioDetails[0]['Scenario']['id'];
									$execution_id = $execution['id'];		
											
											echo $html->link( __("Delete Schedule", true),'javascript:void(null)', array('onmouseover'=>'javascript:InitScenario('.$scenario_id.','.$execution_id.')', 'escape'=>false,'title'=>'Delete','class'=>"clicker",'custid'=>"$execution_id", 'id'=> 'updateScenarioId')); 
											
											
                                        } else {
                                            ?>
                                                                <a onclick="alert('You can not delete a schedule after it has been applied.')" href="javascript:void(0)">Delete Schedule</a>
                                        <?php } ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                                            <?php
                                                        } else {

                                                            #echo '<td class="table-right-ohne">' . $html->link('Log',  array('controller'=> 'logs', 'action'=>'viewlog', 'customer_id:'.$SELECTED_CUSTOMER_NAME . '&' . 'affected_obj=' . $scenario['Scenario']['id'])) . '</td>';
                                                            ?>
                                        <td class="table-right-ohne" style="background: url(<?php echo $this->webroot ?>/images/assets/icons/9px/148_arrowdown_02_cmyk.gif) no-repeat 3px 5px;border-style: none;"></td>
                                                            <?php
                                                        }
                                                        ?>
                                </tr>
                            </tbody>
                                                        <?php
                                                    }
                                                }
                                                ?>



<?php							  
/*
 * Start Confirmation Overlay Model
*/	
?>						  
<div>
					
	<div id="modalPopLite-mask" style="width:100%" class="modalPopLite-mask"></div>
	<div id="modalPopLite-wrapper" style="left: -10000px;z-index: 1;" class="modalPopLite-wrapper">
	<div class="modalPopLite-child " id="popup-wrapper">
	<h4><?php echo __('Confirmation',true); ?>
		<span class='demonstrations1'>           
		   <span style="font-size: 18px !important; float: right;"> <a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="return fancyboxclose(); UnTip();">X</a></span>		  
	        
			<span style="font-size: 18px !important; float: right;margin-right: 10px;"><a href="javascript:;"  style="cursor:pointer" onMouseOver="Tip('<b><?php echo __('confirmToChangeDeleteSchedule_helpTitel') ?></b><br/><?php echo __('confirmToDeleteSchedule_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></span>				
    		
        </span>	
   </h4>
	
	
	 <span  style="width:230px; height:150px;margin:50px auto;">
	         <?php #echo $scenario['Scenario']['id']; ?>
			 
			<h6 style="font-weight:normal!important;"><?php echo __('ConfirmDeleteSchedule');?></h6> <br><br>
			 <span class="button-left" style="margin-left:230px;" >
			<?php echo $html->link( __("Cancle", true),'javascript:void(null)',array('id' => 'close-btn')); ?>
						
			</span>
			<a href="#" id="close-btn"></a>	
			<span  class="button-right" style="margin-right:25px;" >
				
				<?php
				$scenario_id = $scenario['Scenario']['id'];
				
			 echo $html->link(__("Ok", true), 'javascript:void(null)', array('onclick'=>'javascript:scenario_delete("'.$scenario_id.'","'.$execution_id.'")', 'id' => "$execution_id",'class'=>'clicker')); ?>
	      	</span>
		</span>	
	</div>
  </div>
</div>
 <input type="hidden" name="ScenarioUID" id="ScenarioUID" class="sid" value="">
 <input type="hidden" name="ExecutionUID" id="ExecutionUID" class="exid" value="">




                </table>
                <div style="display:block">
                    <div class="button-right" style="margin-right:10px!important;">
                            <?php echo $html->link(__("addSchedule", true), array('controller' => 'scenarios', 'action' => 'create_schedule/' . $scenarioDetails[0]['Scenario']['id'] . '/create/' . $SELECTED_CUSTOMER), array('class' => "fancybox fancybox.ajax")); ?>											
                    </div>
                </div>	
            </div>	
            <!--  -->
            <div style="display:block">					
                <h4 style="display:block;float:left;width: 97%;margin-left:10px!important;margin-right:10px!important;"><?php echo __('Scenario History'); ?> <a class="maintopRelatedContentButton" id="maintopContentButton" onclick="return toggleShowHistory();" href="javascript:void(0)" style="float:right;">
                        <div style="width:20px;background:#eee; height:20px;" id="pbtn">
                            <div id="plus"></div>
                        </div>
                        <div style="width:20px;background:#eee; height:20px;" id="mbtn">
                            <div id="minus"></div>
                        </div>
                    </a></h4> 
            </div>

     
	 <?php
	$show = 'none';
	$log = $this->params['url']['view'];
	 if($log == 'log'){
	 $show = 'block';
	} else {
		
	if (isset($showHistory)) {
	
    	$readonly = 'true';
        $show = 'block';
    } }
    ?>
	 
	 
	 
                <div id="showhistory" class="table-content" style="display:<?php echo $show; ?>">
        
                       <table id="example dnslistdata" class="dataTable tablesorter table-content phonekey" cellpadding="0" cellspacing="0" style="width:98%; margin-left:5px; border-top-color:#D1D1D1">
                        <thead>
                            <tr class="table-top">
                                <th class="table-column" style="width:130px;text-align:left"> <?php echo __('Created'); ?></th>
                                <th class="table-column" style="width:75px;text-align:left"> <?php echo __('User'); ?></th>
                                <th class="table-column" style="width:200px;text-align:left"> <?php echo __('log_entry'); ?></th>
                                
                                <th class="table-column" style="width:70px;text-align:left"> <?php echo __('Status'); ?></th>
                            </tr>
                        </thead>
                      <tbody>
            <?php
            // loop through and display format
			
			
            foreach ($loginfo as $log):
                ?>
                <tr onmouseover="hoverRow(this, true);" onmouseout="hoverRow(this, false);">
                   <td style="width:70px;">
                    <?php
                    $formatted_date = date('d.m.Y H:i:s', strtotime($log['Log']['created']));
                    preg_match("/^(.*) (.*)/", $formatted_date, $matches);
                    if ($matches[0]) {
                        #$datetime2line = $matches[1] . '<br>' . $matches[2];
                        echo $matches[1];
                        echo ' ';
                        echo $matches[2];
                    } else {
                        echo $log['Log']['created'];
                    }
                    ?>
                    </td>
                    <td >
        				<?php echo $log['Log']['user'] ?>
                    </td>
                                    
                    <td> <?php echo $html->link($log['Log']['log_entry'], array('controller'=> 'logs', 'action'=>'logdetails',$log['Log']['id']), array('class' => "fancybox fancybox.ajax")); ?></td>
                                    
                                    
                   <td><?php echo __($log['Log']['modification_status']?'Success':'Failed')?></td>
                  
                                </tr>
        <?php
    endforeach;
    ?>
                        </tbody>
                    </table>

                </div>


                <!--  -->


            </div>
                                    <?php
                                } # End of new sceanrio filter
                                ?>

        <div class="black_overlay" style="height:1220px; width: 1366px; display: none;">
            <div id="black_overlay_loading">
                <img alt="" src="../../img/assets/ajax-loader.gif">
            </div>
        </div>
        <div id="related-content">
            <div class="box start link">
                <a href="#">
                   <?php __('Home Swisscom') ?>
                </a>
            </div>
          <!-- mgi30.5.14
            <div class="box info">
                <h3><?php __('Scenario Operate') ?></h3>
                <p><?php __('scenarioOperate_blurb') ?></p>
            </div>
            <div class="box">
                <h3 class="red"><?php # __("_infoBox"); ?></h3>
                <div class="red">
                   <?php # __('_UpdateInfo'); ?>
                </div>
            </div>
		  -->
			
			<div class="box">
        	   <h3><?php __('Scenario Operate'); ?></h3>
                 <p><?php __('scenarioOperate_blurb') ?></p>
			   <div id="shortcont"><a href="javascript:;" style="cursor:pointer" onclick="set_visi('fullcont')"  title=""><?php echo __('moreStart') ?></a></div>
               <div style="display:none;" id="fullcont_type"  >
                 <p><?php echo __('scenarioOperate_helpText') ?></p>
                 <a href="javascript:;" style="cursor:pointer" onclick="set_visi('shortcont')"  title=""><?php echo __('moreEnd') ?></a>      
			  </div>
           </div> <?php
            if ($scenarioDetails[0]['Scenario']['status'] == 4) { ?>
            	<a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('scenarioOperate_helpText4') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="return fancyboxclose4(); UnTip();"><h3><?php __('ScenarioOperateStates4') ?></h3></a>
				<img id="statemodel"  src="<?php echo Configure::read('base_url');?>images/scenario_operate4.png" style="height: 121px !important;"> <?php } ?><?php
             if ($scenarioDetails[0]['Scenario']['status'] == 6) { ?>
            	<a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('scenarioOperate_helpText6') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="return fancyboxclose4(); UnTip();"><h3><?php __('ScenarioOperateStates6') ?></h3></a>
				<img id="statemodel"  src="<?php echo Configure::read('base_url');?>images/scenario_operate6.png" style="height: 121px !important; "><?php } ?>
			
               <?php if ($userpermission == Configure::read('access_id')) {
                    ?>
                <div class="box info">
                    <h3><?php __("Internal User"); ?></h3>
                    <p><?php echo $selected_customer; ?></p>
                    <p><?php __("customerId"); ?><?php echo $SELECTED_CNN; ?></p>
                </div>
                <?php 
                if ($_SESSION['VIEWMODE'] == 'EXTERNAL')
             	   {
                		echo $html->link(__("scmView", true), array('controller' => 'scenarios', 'action' => 'toggleView?customer_id=' . $SELECTED_CNN . '&view=INTERNAL'));
                	}
                	else
                	{
                		echo $html->link(__("userView", true), array('controller' => 'scenarios', 'action' => 'toggleView?customer_id=' . $SELECTED_CNN . '&view=EXTERNAL'));
                		
                	}
                } ?>

        </div>				
    </div>

    <!--right hand side starts from here-->
    <!--ight hand side  ends here-->
	
	<script type="text/javascript">
    $(document).ready(function() {
		
		          var check_schedule="<?php echo $this->params['pass']['0'];  ?>";
				  if(check_schedule=="sch_edit")
				  {
				  	
					
				  	document.getElementById('showexecution').style.display = 'block';
					document.getElementById('showods').style.display = 'none';
					
					 
				  }
				 
				  }
				  );
				  
	 </script>			  
				  
				  
	
	
	
	
	
	
	
	
    <script type="text/javascript">
        function toggleAdvanceSearch() {
            //$("#advancesearch").show
            if (document.getElementById('advancesearch').style.display == 'none') {
                document.getElementById('advancesearch').style.display = 'block';
            } else {
                document.getElementById('advancesearch').style.display = 'none';
            }

        }
    </script>

<?php if ($leaveStatus[0] == "on") { ?>
    <script language="JavaScript">
        populateArrays();
    </script>
  <?php } ?>  