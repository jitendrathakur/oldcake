<script type="text/javascript">

    jQuery(document).ready(function() {
        /** code to select all filteres records : start **/
        $('.reset').click(function() {
            var checkboxes = $(this).closest('form').find(':checkbox');
            checkboxes.removeAttr('checked');
        });
		
		<?php if(!empty($scenario_id)) { ?>		
           jQuery('.selectdnsCheckbox').click(function() {
            var noofrecord = 0;
			$('.cntdns').show();
			var  selnum = $("#chknumber").val();
				    var  chknum = selnum-1;	
            jQuery('input[type="checkbox"]').each(function() {
                if ($(this).is(':checked')) {
					if(noofrecord<=chknum) {
					
					 jQuery('#dnsbutton').attr("class", "showhighlight_buttonleft");

                      jQuery('#updatedns').removeAttr("class");
                      jQuery('#updatedns').attr("class", "button-right-hover");
					 
                    noofrecord++;
					}
					else{
						var attrid = jQuery(this).attr('id');
                        jQuery('#' + attrid).removeAttr("checked", "");
						return false;
					}
                }
            });

           if (noofrecord < 1)
            {
                $('.cntdns').hide();
            }
            //$('.cntdns').text(noofrecord + ": records are selected");
			$('.cntdns').text("<?php echo __('dnOfLocationSelected'); ?> : " + noofrecord);
        });
           $(document).on('click', '#checkAllDn', function(event) {
            var noofrecord = 0;
            if (jQuery("#checkAllDn").is(':checked')) {
				
				$('.cntdns').show();
                jQuery('.dnlist input[type="checkbox"]').each(function() {
					var CCStyle = jQuery(this).parent().parent().attr('style');
                    var CClass = jQuery(this).parents("tr").attr('class');
					//CStyle.indexOf("display: none") == -1
					var  selnum = $("#chknumber").val();
				    var  chknum = selnum-1;					
					
                  if (CCStyle.indexOf("display: none") == -1) {						
						
					if(noofrecord<=selnum) {
																		
                        var attrid = jQuery(this).attr('id');						
                        jQuery('#' + attrid).prop("checked","checked");
						jQuery(this).attr("checked", true);
						jQuery(this).prop("checked", true);						
                     }
					 else{
					 	var attrid = jQuery(this).attr('id');
                        jQuery('#' + attrid).removeAttr("checked", "");
						return false;
					 }   
						
					  jQuery('#dnsbutton').attr("class", "showhighlight_buttonleft");
					  jQuery('#updatedns').removeAttr("class");
                      jQuery('#updatedns').attr("class", "button-right-hover");
						
                        noofrecord++;
                        //alert("kk"+noofrecord);

                    }
					
					/* else if (CCStyle.indexOf("display: none") == -1 && CClass.indexOf("filtered") == -1) {
						//if($('.visb').is(':visible')){
												
                        var attrid = jQuery(this).attr('id');
						
                        jQuery('#' + attrid).prop("checked","checked");
						//jQuery(this).attr("checked", true);
						//jQuery(this).prop("checked", true);						
                        
						
					  jQuery('#dnsbutton').attr("class", "showhighlight_buttonleft");
					  jQuery('#updatedns').removeAttr("class");
                      jQuery('#updatedns').attr("class", "button-right-hover");
						
                        noofrecord++;
                        //alert("kk"+noofrecord);

                    }
					*/
					 //noofrecord++;
                });
               // $('.cntdns').text(noofrecord - 1 + ": records are selected");
				 $('.cntdns').text("<?php echo __('dnOfLocationSelected'); ?> : " + (noofrecord - 1 ));

            } else {
                jQuery('.dnlist input[type="checkbox"]').each(function() {
                    jQuery(this).removeAttr("checked");
                });
               // $('.cntdns').text("0" + ": records are selected");
				$('.cntdns').hide();
            }
        });
		<?php } else {  ?>
			 jQuery('.selectdnsCheckbox').click(function() {
            var noofrecord = 0;
			$('.cntdns').show();
			var  selnum = $("#chknumber").val();
				    var  chknum = selnum-1;	
            jQuery('input[type="checkbox"]').each(function() {
                if ($(this).is(':checked')) {
					
					
					 jQuery('#dnsbutton').attr("class", "showhighlight_buttonleft");

                      jQuery('#updatedns').removeAttr("class");
                      jQuery('#updatedns').attr("class", "button-right-hover");
					 
                    noofrecord++;
					
                }
            });

           if (noofrecord < 1)
            {
                $('.cntdns').hide();
            }
            //$('.cntdns').text(noofrecord + ": records are selected");
			$('.cntdns').text("<?php echo __('dnOfLocationSelected'); ?> : " + noofrecord);
        });
           $(document).on('click', '#checkAllDn', function(event) {
            var noofrecord = 0;
            if (jQuery("#checkAllDn").is(':checked')) {
				
				$('.cntdns').show();
                jQuery('.dnlist input[type="checkbox"]').each(function() {
					var CCStyle = jQuery(this).parent().parent().attr('style');
                    var CClass = jQuery(this).parents("tr").attr('class');
					//CStyle.indexOf("display: none") == -1
					var  selnum = $("#chknumber").val();
				    var  chknum = selnum-1;					
					
                  if (CCStyle.indexOf("display: none") == -1) {						
						
					
																		
                        var attrid = jQuery(this).attr('id');						
                        jQuery('#' + attrid).prop("checked","checked");
						jQuery(this).attr("checked", true);
						jQuery(this).prop("checked", true);						
                       
						
					  jQuery('#dnsbutton').attr("class", "showhighlight_buttonleft");
					  jQuery('#updatedns').removeAttr("class");
                      jQuery('#updatedns').attr("class", "button-right-hover");
						
                        noofrecord++;
                        //alert("kk"+noofrecord);

                    }
					
				/*	else if (CCStyle.indexOf("display: none") == -1 && CClass.indexOf("filtered") == -1) {
						//if($('.visb').is(':visible')){
												
                        var attrid = jQuery(this).attr('id');
						
                        jQuery('#' + attrid).prop("checked","checked");
						//jQuery(this).attr("checked", true);
						//jQuery(this).prop("checked", true);						
                        
						
					  jQuery('#dnsbutton').attr("class", "showhighlight_buttonleft");
					  jQuery('#updatedns').removeAttr("class");
                      jQuery('#updatedns').attr("class", "button-right-hover");
						
                        noofrecord++;
                        //alert("kk"+noofrecord);

                    }
					
					*/
					
					 //noofrecord++;
                });
               // $('.cntdns').text(noofrecord - 1 + ": records are selected");
				 $('.cntdns').text("<?php echo __('dnOfLocationSelected'); ?> : " + (noofrecord - 1 ));

            } else {
                jQuery('.dnlist input[type="checkbox"]').each(function() {
                    jQuery(this).removeAttr("checked");
                });
               // $('.cntdns').text("0" + ": records are selected");
				$('.cntdns').hide();
            }
        });
		
		<?php } ?>
		
        $('#addChecked').on("click", function() {
            var count = 0;
            $('form input[type="search"]').each(function() {
                if ($(this).val() != "") {
                    count++;
                }
            });
            if (count == 0) {
                //var checkboxes = $(this).closest('form').find(':checkbox'); 
                var checkboxes = $(this).closest('form').find('input[type=checkbox]:not(:disabled)');
                //checkboxes.attr('checked', 'checked');
            } else {
                /** add script to check all checkbox who does not fall under hidden tr **/
                var checkboxes = $("table.dataTable tr:visible").find('input[type=checkbox]:not(:disabled)');
                //var checkboxes1 = jQuery( tr:(.filtered)).find(':checkbox');
                //checkboxes.attr('checked', 'checked');
            }
        });
        /** code to select all filteres records : ends **/
        jQuery("#filter_now_overlay").click(function() {
            var MinVal = jQuery('#rangeMin_overlayMinval').val();
            var MaxVal = jQuery('#rangeMax_overlayMaxval').val();
			var customer_id="<?php echo $$customers['Customer']['id']; ?>";  

            if ((MinVal.length < 9 || MinVal.length > 9) && (MaxVal.length < 9 || MaxVal.length > 9)) {
                alert('Filter Range From and To Must Be 9 digits!');
                return false;
            } else {

                if (isNaN(MinVal) || isNaN(MaxVal)) {
                    alert('Filter Range must be numeric only!');
                    return false;
                } else {


                   // var TargetURL = "<?php echo Configure::read('base_url'); ?>dns/filterdns/scenario_id:<?php echo $scenario_id; ?>" + "/MinVal:" + MinVal + "/MaxVal:" + MaxVal;
				   var TargetURL = "<?php echo Configure::read('base_url'); ?>dns/filterdns/scenario_id:<?php echo $scenario_id; ?>/location_id:<?php echo $location_id; ?>" + "/MinVal:" + MinVal + "/MaxVal:" + MaxVal+"/customer_id:"+customer_id;
					//var TargetURL = "<?php echo Configure::read('base_url'); ?>dns/filterdns/MinVal:" + MinVal + "/MaxVal:" + MaxVal;

                                        jQuery.post(TargetURL, function(response) {

                                            $('#ajax_load').html(response);


                                        });
                                    }
                                }
                            });


                            $('#removeChecked').on("click", function() {
                                var count = 0;
                                $('form input[type="search"]').each(function() {
                                    if ($(this).val() != "") {
                                        count++;
                                    }
                                });
                                if (count > 0) {
                                    var checkboxes = $("table.dataTable tr:visible").find(':checkbox');
                                    checkboxes.removeAttr('checked');
                                }
                            });

                        });

                        /*function submit_odsentries(id) {
                            //var trainindIdArray;
                            if ($('input.selectdnsCheckbox').filter(":checked").length > 0) {
                                $('.filtersForm').attr('action', base_url + 'odsentries/index/scenario_id:<?php echo $scenario_id ?>');
                                $('.filtersForm').attr('method', 'POST');
                                //$('#filters').submit();
                                $.ajax({
                                    type: "POST",
                                    async: false,
                                    dataType: 'json',
                                    url: $('.filtersForm').attr('action'),
                                    data: $('.filtersForm').serialize(),
                                    success: function(data) {
                                        if (data.message == "Success") {
                                            $.each(data.selectdnsCheckbox, function(index, key) {
                                                $("." + key).closest("tr").addClass("insertedDNStyle"); // add class to change tr background color 
                                                $("." + key).closest("tr").find('.entryStatus').text("Added"); // add class to change tr background color 
                                                $("." + key).attr("disabled", true);  // disable checkboxes								
                                                window.location.reload();
                                            });
                                            $('.reset').click();
                                        } else {
                                            alert('Some error occured, Please try again');
                                        }

                                        var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/updatescenarioviajquery/";
                                        var ScenarioId = '<?php echo $scenario_id ?>';
                                        $('.black_overlay').show();

                                        jQuery.post(TargetURL, {'scenario_id': ScenarioId}, function(data) {
                                            $('#reloadme').html(data);
                                            jQuery('#updateOdsentry').removeAttr("class");
                                            jQuery('#savedestinations').removeAttr("class");
                                            jQuery('#updateOdsentry').attr("class", " button-right-disabled");
                                            jQuery('.black_overlay').hide();

                                            jQuery('.fancybox-close').click();
                                        });


                                        //Updated the Scenario status i.e. Complete or Incomplete
                                        var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/ScenarioCompletedOrNot/scenario_id:" + ScenarioId;

                                        jQuery.post(TargetURL, function(response) {
                                            jQuery('#Status').val(response);

                                            var msgd = response.trim();
                                            if (msgd == "Complete") {
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

                                    }
                                });
                            } else {
                                alert("Please select at least one record");
                            }
                        }*/



function submit_odsentries(id) {
                            //var trainindIdArray;
                            if ($('input.selectdnsCheckbox').filter(":checked").length > 0) {
                                $('.filtersForm').attr('action', base_url + 'odsentries/index/scenario_id:<?php echo $scenario_id ?>');
                                $('.filtersForm').attr('method', 'POST');
                                //$('#filters').submit();
								
                                $.ajax({
                                    type: "POST",
                                    url: $('.filtersForm').attr('action'),
                                    data: $('.filtersForm').serialize(),
                                    success: function(data) {

                                        if (data.message == "Success") {
                                            $.each(data.selectdnsCheckbox, function(index, key) {
                                                $("." + key).closest("tr").addClass("insertedDNStyle"); // add class to change tr background color 
                                                $("." + key).closest("tr").find('.entryStatus').text("Added"); // add class to change tr background color 
                                                $("." + key).attr("disabled", true);  // disable checkboxes								
                                                //window.location.reload();
                                            });
                                            $('.reset').click();
                                        } else {
                                            //alert('Some error occured, Please try again');
                                        }

                                        var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/updatescenarioviajquery/";
                                        var ScenarioId = '<?php echo $scenario_id ?>';
                                        $('.black_overlay').show();

                                        jQuery.post(TargetURL, {'scenario_id': ScenarioId}, function(data) {
                                            $('#reloadme').html(data);
                                            jQuery('#updateOdsentry').removeAttr("class");
                                            jQuery('#savedestinations').removeAttr("class");
                                            jQuery('#updateOdsentry').attr("class", " button-right-disabled");
                                            jQuery('.black_overlay').hide();

                                            jQuery('.fancybox-close').click();
                                        });


                                        //Updated the Scenario status i.e. Complete or Incomplete
                                        var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/ScenarioCompletedOrNot/scenario_id:" + ScenarioId;

                                        jQuery.post(TargetURL, function(response) {
                                            jQuery('#Status').val(response);
                                            jQuery('#sts').html('Status :' + response);

                                            var msgd = response.trim();
                                            if (msgd == "Complete") {
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
window.location.reload();
                                    }
                                });
                            } else {
                                alert("Please select DN's");
                            }
							 
                        }



                        function submit_locationentries(id) {
                            //var trainindIdArray;
                            if ($('input.selectdnsCheckbox').filter(":checked").length > 0) {
                                $('.filtersForm').attr('action', base_url + 'locations/updatedns/location_id:<?php echo $location_id ?>');
                                $('.filtersForm').attr('method', 'POST');
                                $('.black_overlay').css('display', 'block');
                                //$('#filters').submit();
                                $.ajax({
                                    type: "POST",
                                    async: false,
                                    dataType: 'json',
                                    url: $('.filtersForm').attr('action'),
                                    data: $('.filtersForm').serialize(),
                                    success: function(data) {

                                        //if (data == "1") {
											//alert("success");
                                            jQuery('.black_overlay').removeAttr('style');
                                            jQuery('.black_overlay').attr("style", "display:none");
                                            window.location.reload();
                                            $.each(data.selectdnsCheckbox, function(index, key) {
                                                $("." + key).closest("tr").addClass("insertedDNStyle"); // add class to change tr background color 
                                                $("." + key).closest("tr").find('.entryStatus').text("Added"); // add class to change tr background color 
                                                $("." + key).attr("disabled", true); // disable checkboxes

                                            });
                                            $('.reset').click();
                                        //} else {
                                         //   alert("record can not be saved try again");
                                           // jQuery('.black_overlay').removeAttr('style');
                                            //jQuery('.black_overlay').attr("style", "display:none");
                                        //}
                                    }
                                });
                            } else {
                                alert("Please select at least one record");
                            }
                        }

                        /* ### Change Pagination style Script ###*/                       

                        $(document).ready(function() {

                            paginationStyle();
                            $('.selectdnspager a').click(function() {
                                paginationStyle();
                            });
                            function paginationStyle() {
                                setTimeout(function() {

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
									
									
									temp3 = temp[0].split("Of "+totalPage);
									temp4 = temp3[1];
									if(isNaN(temp4)){
										left = temp[0] / 10;
	                                    box = left;
	                                    if (temp[0] % 10 > 0) {
	                                        box = parseInt(left) + 1;
	                                    }	
									}else{
										left = temp3[1] / 10;
	                                    box = left;
	                                    if (temp3[1] % 10 > 0) {
	                                        box = parseInt(left) + 1;
	                                    }
									}
									
                                    /*left = temp[0] / 10;
                                    box = left;
                                    if (temp[0] % 10 > 0) {
                                        box = parseInt(left) + 1;
                                    }*/
                                    if (typeof temp[1] == 'undefined') {
                                        return false;
                                    }

                                    right = temp[1].split("/ ");
                                    rightKey = right[1].split(" ");
                                    right = rightKey[0] / 10;
                                    if (rightKey[0] % 10 > 0) {
                                        totalPage = parseInt(right) + 1;
                                    }

                                    $('.countdisplay5').html(showrecord);
									$(".pagedisplay").text('');
                                    var newStyle = "<input type='text' name='currpage' value='" + box + "' style='width:25px;text-align:center;float: inherit;' maxlength='3' class='GoOnTargetPage'>";
                                    newStyle += "<span style='font-weight:bold'> Of " + totalPage + "</span>";
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
                                table: 'table table-bordered',
                                header: 'bootstrap-header', // give the header a gradient background
                                footerRow: '',
                                footerCells: '',
                                icons: '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
                                sortNone: 'bootstrap-icon-unsorted',
                                sortAsc: 'icon-chevron-up',
                                sortDesc: 'icon-chevron-down',
                                active: '', // applied when column is sorted
                                hover: '', // use custom css here - bootstrap class may not override it
                                filterRow: '', // filter row class
                                even: '', // odd row zebra striping
                                odd: '' // even row zebra striping
                            });

                            // call the tablesorter plugin and apply the uitheme widget
                            jQuery(".dataTable").tablesorter({
                                // this will apply the bootstrap theme if "uitheme" widget is included
                                // the widgetOptions.uitheme is no longer required to be set
                                theme: "bootstrap",
                                widthFixed: true,
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
                                    6: {sorter: false, filter: false},
                                    7: {sorter: false, filter: false},
                                    8: {sorter: false, filter: false},
                                    9: {sorter: false, filter: false}

                                }
                            })
                                    .tablesorterPager({
                                        // target the pager markup - see the HTML block below
                                        container: jQuery(".selectdnspager"),
                                        // target the pager page select dropdown - choose a page
                                        cssGoto: ".pagenum",
                                        // remove rows from the table to speed up the sort of large tables.
                                        // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
                                        removeRows: false,
                                        // output string - default is '{page}/{totalPages}';
                                        // possible variables: {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
                                        output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'

                                    });

                        });
</script>

<style>
    .tablesorter-filter
    {
        width:100% !important;
		float:left !important;
		
		
    }
    .space_check
    {
        width:71%;
        height:auto !important;
        margin-bottom:0 !important;
    }
    .table th, .table td
    {
        padding: 1px 6px;  /* 4px 6px;  */
		background-color:#F9F9F9 !important;
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
        width:12% !important;
    }
    #example colgroup col:nth-child(4)
    {
        width:20% !important;
    }

    .selectdnsCheckbox {/*margin-left:24px !important;*/}

    .withdatatablecss {
        border-bottom:#CCCCCC 1px solid !important; border-right: 1px solid #CCCCCC !important;border-top:#CCCCCC 1px solid !important; border-radius:0px !important;	
    }
	.tablesorter-filter-row td
	{
		border-bottom:#CCCCCC 1px solid !important; border-right: 1px solid #CCCCCC !important;border-top:#CCCCCC 1px solid !important; border-radius:0px !important;
	}
	.table-bordered {
    border-image: none;
    border-radius: 0 !important;
    border-style: none !important;
    border-width: 0 !important;
    width: 630px ;
}
.form-box .form-left {
    float: left;
    margin: 0;
    padding: 0;
    width: 230px !important;
}
.form-box .form-right {
    float: left;
    margin: 0;
    padding: 0;
    width: 230px!important;
}
.fancybox-close {
    cursor: pointer;
    height: 0px!important;
    position: absolute;
    right: -30px;
    top: -20px;
    width: 36px;
    z-index: 8040;
}	


.tablesorter-bootstrap .tablesorter-header i {
    background-repeat: no-repeat;
    display: inline-block;
    float: right!important;
    height: 14px;
    left: 2px;
    line-height: 14px;
    margin-top: 10px!important;
    position: absolute; 
    width: 12px;
}
a{
	text-decoration: none!important;
}
.tablesorter-bootstrap .tablesorter-header, .tablesorter-bootstrap tfoot th, .tablesorter-bootstrap tfoot td {
    padding: 5px 8px!important;
}

</style>

<?php

	
  $cst_type=$customers['Customer']['type'];


?>



<?php $selnumber = Configure :: read('selectnumber');
$chknumber = $selnumber[0];
 ?>
 
 <input type="hidden" name="chknumber" id="chknumber" value="<?php echo $chknumber; ?>"/>
<input type="hidden" value="<?php echo $location_id ?>">
<table id="example" class="dataTable ">
    <thead> 	
        <tr class="table-top withdatatablecss">
           <!-- <th class="table-column table-left-ohne withdatatablecss">&nbsp;</th>-->
		   <?php if (!empty($scenario_id)) { ?>
            <th class="table-right-ohne withdatatablecss"><input type="checkbox" name="sAll" id="checkAllDn"  class="showselect"></th>
			<?php } else { ?> 
			<th class="table-right-ohne withdatatablecss"><input type="checkbox" name="sAll" id="checkAllDn"   class="showselect"></th>
			<?php } ?>
            <th class="table-column withdatatablecss<?php
            if (in_array('sort:id', $filter_sort) && in_array('direction:asc', $filter_sort))
                echo 'sortlink_asc';elseif ((in_array('sort:id', $filter_sort) && in_array('direction:desc', $filter_sort)))
                echo 'sortlink_desc';
            else
                echo 'sortlink';
            ?> "style="width:102px;text-align: left;">
                <?php echo __("Id", true); ?></th>

            <th class="table-column filter-select filter-exact withdatatablecss <?php
            if (in_array('sort:location_id', $filter_sort) && in_array('direction:asc', $filter_sort))
                echo 'sortlink_asc';elseif ((in_array('sort:location_id', $filter_sort) && in_array('direction:desc', $filter_sort)))
                echo 'sortlink_desc';
            else
                echo 'sortlink';
            ?> "style="width:102px !imporatant;text-align: left;"><?php echo __("Location", true); ?></th>

            <?php if($cst_type!="Gate" && $cst_type!="Gate+" ){     ?>
            <th class="table-column withdatatablecss filter-select filter-exact <?php
            if (in_array('sort:function', $filter_sort) && in_array('direction:asc', $filter_sort))
                echo 'sortlink_asc';elseif ((in_array('sort:function', $filter_sort) && in_array('direction:desc', $filter_sort)))
                echo 'sortlink_desc';
            else
                echo 'sortlink';
            ?> "style="width:102px;text-align: left;"><?php echo __("Function", true); ?></th>
          <?php }    ?>
           <?php 
											   $odsflag=count($scenarioData);
											  
											  if($odsflag!=0){     ?>
            <th class="table-column withdatatablecss"><?php echo __("ODS", true); ?></th>
			 <?php }    ?>
			<?php if($cst_type!="Phone"){     ?>  
            <th class="table-column withdatatablecss" style="width:12% !important;"><?php echo __("trunk", true); ?></th>				
            <?php }    ?>

            <!--<th class="table-right-ohne withdatatablecss" style="width:6% !important;">&nbsp;</th>-->
        </tr>
    </thead>
    <tfoot>
    <th colspan="8" class="selectdnspager form-horizontal " style="border-bottom:1px solid #F9F9F9 !important;border-left:1px solid #F9F9F9 !important;border-right: 1px solid #F9F9F9 !important;">
        <span><a class="first" href="javascript:;">&lt;&lt;</a></span>
        <span><a class="prev" href="javascript:;">&lt;</a></span>
        <span>Page</span>
        <select class="pagenum input-mini hide" title="Select page number"></select>
        <span class="pagedisplay"></span> <!-- this can be any element, including an input -->			
        <span><a class="next" href="javascript:;">&gt; </a></span>
        <span><a class="last" href="javascript:;">&gt;&gt; </a></span>
        
    </th>
</tr>
</tfoot>
<tbody >
    <?php
// initialise a counter for striping the table
    $count = 0;
    $options = $general->get_odsentries($scenario_id); //echo "<pre/>"; print_r($options); die;
//echo "<pre/>"; print_r($dns); die;
//echo "<pre/>"; print_r($scenarioMap);  print_r($scenarioData);
// loop through and display format
    $dnsIdsArray = array();
     
    foreach ($dns2 as $dn): $insertedDNStyle = "";
	   
        $disableCheckbox = "";
        $entryStatus = "Available";
        // stripes the table by adding a class to every other row
        $class = ( ($count % 2) ? " class='altrow'" : '' );
        // increment count
        $count++;

        if (in_array($dn['Dns']['id'], $dnsIdsArray)) {
            //if (in_array($dn['Dns']['id'], $options)) {
            #If this DN exists already then don't show it here.

            $insertedDNStyle = 'class="insertedDNStyle"';
            $disableCheckbox = 'disabled';
            $entryStatus = "Added";
        } else {
            #Not already belonging to the 
            $AllScenariosForThisDns = $scenarioMap[$dn['Dns']['id']];
            $dnsIdsArray[] = $dn['Dns']['id'];
            ?>

            <tr onmouseover="hoverRow(this, true);" onmouseout="hoverRow(this, false);
                " <?php echo $insertedDNStyle; ?>>
                <!--<td class="table-left withdatatablecss">&nbsp;</td>-->
                <td class="withdatatablecss"><input type="checkbox" class="selectdnsCheckbox"  id="<?php echo $dn['Dns']['id'] ?>" name="selectdnsCheckbox[]" value="<?php echo $dn['Dns']['id'] ?>" <?php echo $disableCheckbox; ?>/></td>	
                <td class="withdatatablecss"> 
                    <?php
                    if (($dn['Dns']['function'] != '') && ($dn['Dns']['function'] != 'CFRA') && ($dn['Dns']['function'] != 'UCD') && ($dn['Dns']['function'] != 'INTERNAL')) {
                        echo $dn['Dns']['id'];
                        ?>
                    </td>
                    <td class="table-content column-width-50 withdatatablecss" style="width:125px !important;">
                        <?php
                        echo $dn['Location']['name'];
                        #echo $dn['Location']['name']; 
                        ?>
                    </td>
					
					 <?php if($cst_type!="Gate" && $cst_type!="Gate+"){     ?>  
                    <td class="withdatatablecss">
					
                        <?php
                       
                        echo __($dn['Dns']['function'], true);
                        ?>
                    </td>
                    <?php   }   ?>
                    <?php 
											   $odsflag=count($scenarioData);
											  
											  if($odsflag!=0){     ?>
											  
                                                <td height="20px; " class="withdatatablecss">
												
	                		 					 <?php 
	                							  $AllScenariosForThisDns=explode(',',$dn[0]['scenlist']);
												 ?>
																
													<div id="scenario_tip<?php echo $DnsId;?>">
													<?php
													foreach($AllScenariosForThisDns As $scenarioId)
													{
														
														$linkName = $scenarioData[$scenarioId];
														echo "<li style='list-style:none;'>". $linkName; 
													  	echo "</li>";						  
													}
																			 									
													?>
													</div>
		
	                							</td>
												 <?php  }   ?>
					<?php if($cst_type!="Phone"){     ?>  
                                                <td class="withdatatablecss">
	                		 					 <?php 
	                		  
	                		 						 $AllTrunksForThisDns=explode(',',$dn[0]['trunklist']);
								
													foreach($AllTrunksForThisDns as $trunk_id){
									
														$Trunkname = $TrunkDataData[$trunk_id];
														echo '<li style="list-style:none;">' . $Trunkname . '</li>'; 
											
														}
														?>
	                							</td>
                                                <?php }    ?>  

                    <!--<td class="table-right-ohne withdatatablecss">&nbsp;</td>-->
                    <?php
                } else {
                    echo $dn['Dns']['id'];
                    ?>
                    </td>
                    <td class="table-content column-width-100 withdatatablecss" style="width:125px;">
                        <?php echo $dn['Location']['name']; ?>
                    </td>

                    <td class="withdatatablecss"><?php echo __($dn['Dns']['function'], true); ?></td>


                    <td height="20px;" class="withdatatablecss">
                        <?php
                        if (isset($AllScenariosForThisDns) && !empty($AllScenariosForThisDns)) {
                            ?>							

                            <div id="scenario_tip<?php echo $DnsId; ?>">
                                <?php
                                foreach ($AllScenariosForThisDns As $key => $scenarioId) {
                                    echo "<li style='list-style:none;'>" . $html->link($scenarioData[$scenarioId], array('controller' => 'scenarios', 'action' => 'edit/scenario_id:' . $scenarioId));
                                    echo "</li>";
                                }
                                #echo $html->link( __('TEST', true),array('controller'=>'scenarios','action' => 'edit/scenario_id:'.$scenarioId));
                                ?>
                            </div>
                        <?php } ?>
                    </td>

                    <td class="withdatatablecss">
                        <?php
                        if (!empty($dn['Trunkentry'])) {
                            foreach ($dn['Trunkentry'] as $trunk) {
                                $trunk_id = $trunk['trunk_id'];
                                $Trunkname = $TrunkDataData[$trunk_id];

                                echo $html->link($Trunkname, array('controller' => 'trunks', 'action' => 'edit/trunk_id:' . $trunk_id));
                            }
                        }
                        ?>
                    </td>
						

                    <!--<td class="table-right-ohne withdatatablecss">&nbsp;</td>-->

                    <?php
                }
            } # not already added
        endforeach;
        ?>
    </tr>


</tbody>

</table>