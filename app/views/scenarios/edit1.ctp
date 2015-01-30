							<div id="reloadwholdpagedata" style="margin-left: 10px!important;margin-right: 10px!important;">
							
							<div class="clear"></div>
							<div id="" class="table-content">
							<table id="myTable7" class="dataTable phonekey" cellpadding="0" cellspacing="0" style="width:98%; border:1px solid #ccc !important; margin-left:5px; border-top-color:#CCC">
					
							  <thead>
							  
								<tr class="tablesorter-filter-row78">
										<td>&nbsp;</td>
										<td><input style="width:93%;" type="text" id="search_source" ></td>
										<td><input style="width:93%;" type="text" id="search_dest" ></td>
										<td>
										
											<select id="search_state" style="width:93%; !important;margin-left:5px;float:left;margin-right:4px;">
												<option></option>
												<option value="<?php echo __('Valid',true); ?>"><?php echo __('Valid',true); ?></option>
												<option value="<?php echo __('Invalid',true); ?>"><?php echo __('Invalid',true); ?></option>
											</select>
										</td>
									</tr>
									
								<tr class="table-top" style=" border:1px solid #ccc !important; border-bottom:#D1D1D1 1px solid; border-right: 1px solid #D1D1D1;border-top:#D1D1D1 1px solid;">
								  <!--<th class="table-column table-left-ohne withdatatablecss">&nbsp;</th>-->
								  <th align="left" style=" width: 10px !important;border-right: 1px solid rgb(209, 209, 209) ! important;"  class="table-left-ohne" ><input type="checkbox" name="sAll" id="checkAll" class="showselect" style=" margin-top: 6px !important;margin-left:10px !important; width: 20px!important"></th>
								  <th style="width:95px !important;border-right: 1px solid rgb(209, 209, 209) ! important;" align="left"  class="table-column dosorting " style="margin-top: -2px;"><a href="javascript:void(0);"><?php echo __('Source'); ?></a></th>
								  <th style="width:120px !important;border-right: 1px solid rgb(209, 209, 209) ! important;" align="left"  class="table-column filter-select filter-parsed  dosorting" data-placeholder=""><a href="javascript:void(0);"><?php echo __('Dest'); ?></a></th>
									<?php
								   if ($scenarioDetails[0]['Scenario']['status'] == 3){?>
								  
								  
								  <th width="129px !important" align="left" class="table-column filter-select filter-exact dosorting" data-placeholder=""><a href="javascript:void(0);"><?php echo __('odsConfig'); ?></a></th>
									 <?php }else{?>
								   <th width="129px !important" align="left" class="table-column filter-select filter-exact dosorting" data-placeholder=""><a href="javascript:void(0);"><?php echo __('State'); ?></a></th>
								 <?php } ?>
								 
								  
								  <!--   <th class="table-column table-right-ohne withdatatablecss" style="width:50px!important;">&nbsp;</th> -->
								  <!--<th class="table-column table-right-ohne" style="border-bottom:#CCCCCC 1px solid;border-top:#CCCCCC 1px solid;">&nbsp;</th>-->
								</tr>
							  </thead>
                    
							<tbody id="reloadme" >
							</tbody>
							</table>
							</div>
							
							<!-- Badal Singh -->
							<script>
							
							//$(document).ready(function() {
							
							//});
							
							
							var indext = 3;
							populate();
							//alert('dddd');
							function populate()
							{
								//alert('dddd');
								
								$.fancybox.showLoading();
								//$('.black_overlay_update').show();
								
								
								
								console.time('populate');
								var t = $('#myTable7').dataTable({
								
								'bDestroy': true,
									"bInfo": true,
									"bFilter": true,
									"sDom":"lrtip",
									"bProcessing": true,
									"bDeferRender": true,
									"search" : false,
									'iDisplayLength': 10,
									'sPaginationType': 'full_numbers',
									'sDom': '<"top"i> T<"clear">lfrtip',
									'sPageButtonActive': "paginate_active",
									'sPageButtonStaticDisabled': "paginate_button",
									
									"bJQueryUI": true,
									"bAutoWidth": false , 
									"columns": [
										null,
										{ "orderDataType": "dom-text-numeric" },
										{ "orderDataType": "dom-text", type: 'string' },
										{ "orderDataType": "dom-select" }
									],
									"oLanguage": {
										"sZeroRecords":"<?php echo __("noMatching"); ?>",
										"sSearch": "Futher Filter Search results:",
										"sInfo": "Got a total of _TOTAL_ results to show (_START_ to _END_)",
										"sLengthMenu": '<div style="float:left;margin-left:5px;"><?php echo __("totalEntries")?>&nbsp;</div> <div id="counter" style="float:left;"></div> '+
										'<div style="float:left;margin-left:5px;"><?php echo __("entriesPerPage"); ?>' +
										'<select style="margin-top:-1px;width:53px;">' +


										'<option value="10">10</option>' +
										'<option value="25">25</option>' +
										'<option value="50">50</option>' +
										'<option value="100">100</option>' +
										'</select></div><br />'
											},
											"bSort": true,
										
									'fnDrawCallback': function(oSettings) {
									
										if ($("#checkAll").is(':checked')) {
											$('.odsentchk').prop("checked", "checked");
											
												
										}
									},
									"fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
									
										var total = 0;
										 var seldnids = '';
										 var dnIdCount = 0;
										 var breakWordCheck;
										 var dn_id;
										 var functiondropdown = [];
										 
										var selectedval = $('#msds-select-function').val();
										//alert(selectedval);
										
										for (var i = 0; i < aiDisplay.length; i++) {
											
											
											//functiondropdown += "<option value='"+aaData[aiDisplay[i]][3]+"'>"+aaData[aiDisplay[i]][3]+"</option>";
											
											functiondropdown.push(aaData[aiDisplay[i]][3]);
											
											var getId = aaData[aiDisplay[i]][1] * 1;												
											
											
											breakWordCheck = dnIdCount % 5 ;
											if(breakWordCheck == 0){										
												dn_id = getId;
												seldnids += dn_id + ','+'</br>';								
											}
											else{										
												dn_id = getId;						
												seldnids += dn_id + ',';	
											}
											
											dnIdCount++;
									
										
											//total += number;
										}
										
										if (functiondropdown instanceof Array) 
										{
										
											var uniqueNames = [];
											$.each(functiondropdown, function(i, el){
												if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
											});
											
											functionuniquearray = "<option></option>";
											
											for(i=0; i<= uniqueNames.length; i++){	
												
												if(!uniqueNames[i]) continue;
												
												selected = "";
												if(uniqueNames[i] == selectedval) selected = "selected"; 
												//alert(uniqueNames[i]);
												functionuniquearray += "<option "+selected+" value='"+uniqueNames[i]+"'>"+uniqueNames[i]+"</option>";
											}
											
											//alert(functionuniquearray);
											
											//$("#msds-select-function").html(functionuniquearray);
											//$("#msds-select-function").val("");
										}
										
										
										
										//alert(uniqueNames);

										$("#IDS").val(seldnids);
										$("#IDSSAVE").val(seldnids);
										
									},
									"fnInfoCallback": function( oSettings, iStart, iEnd, iMax, iTotal, sPre ) {
									   									   
									    iPage = oSettings._iDisplayLength === -1 ? 1: Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength );
										
										iTotalPages =  oSettings._iDisplayLength === -1 ?  1 : Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength );
;
									    $('#myTable7_paginate span').html(' <?php __('Page'); ?> <input class="GoOnTargetPage12" id="pagenumber" maxlength="maxlength" style="width:25px;text-align:center;float: inherit;" type="text" value="' + (iPage+1) + '" /> <?php echo __('Of') ?> ' + iTotalPages);
									  
									    $('div#counter').html(iTotal);
										//$("#chknumber").val(iTotal);
										
										count = 0;
										$('.odsentchk').each(function() {
											if ($(this).is(':checked')) {
												count++;
											}
										});
										
										//alert('ddd');
										
										$("#chknumber").val(count);
										
										if ($("#checkAll").is(':checked')) {
											
											//$('.odsentchk').bind('click', function() {  });
											getval = $("#chknumber").val();
											//if(iTotal == getval)
											//$('.cnt').text("<?php echo __('Update Selected'); ?> : " + (iTotal));
										}
										
										$('.cnt').text("<?php echo __('Update Selected'); ?> : " + (count));
										
									   /*
									   perPage = iEnd - iStart + 1;
									   
									   //alert(perPage);
									   totalRatio = iTotal/perPage;
									   intTotalRatio = parseInt(totalRatio, 10);
									   totalPages = totalRatio > intTotalRatio ? intTotalRatio + 1 : intTotalRatio;
									   currentRatio = iStart/perPage;
									   intCurrentRatio = parseInt(currentRatio, 10);
									   currentPage = currentRatio > intCurrentRatio ? intCurrentRatio + 1 : intCurrentRatio;
									   //alert('Displaying ' + currentPage + ' of ' + totalPages + ' pages');
									   
									   if(iEnd == iTotal){
										//totalPages--;
									   }
									   
									  // alert(totalPages);
									   
									   $('#myTable7_paginate span').html(' Page <input class="GoOnTargetPage12" id="pagenumber" maxlength="maxlength" style="width:25px;text-align:center;float: inherit;" type="text" value="' + currentPage + '" /> of ' + totalPages);
									  
									    $('div#counter').html(iTotal);
										
										$('.cnt').text("<?php echo __('Update Selected'); ?> : " + (iTotal));
										$("#chknumber").val(iTotal);
										*/
										//$('#myTable7_paginate span').html(" Paging ");
										
										
										$("#myTable7_first").removeClass("ui-state-default");	
										$("#myTable7_previous").removeClass("ui-state-default");	
										
										$("#myTable7_next").removeClass("ui-state-default");	
										$("#myTable7_last").removeClass("ui-state-default");	
									}
									
								}
								) ;								
								

								
								var jArray = <?php echo $jsonodsEntryList; ?>;
								var IDS = "";
								var countlength = "<?php echo count($odsEntryList ); ?>";
								
								
								 var seldnids = '';
								 var dnIdCount = 0;
								 var breakWordCheck;
								 var dn_id;
							
								for (var irow = 0; irow < countlength; irow++)   
								{
									indext = 3;
									var cells = new Array();
									//var r = jQuery('<tr  id=' + irow + '>');
									//for (var icol = 0; icol < 1; icol ++)
									
									odsentry_id = jArray[irow]['Odsentry']['id'];
									source =  jArray[irow]['Odsentry']['source'];
									dest =  jArray[irow]['Odsentry']['dest'];
									PerformDisable = '<?php echo $PerformDisable; ?>';
									readonlytextbox =  '<?php echo $readonlytextbox; ?>';
									
									cells[0] = '<input type="checkbox" class="odsentchk" name="a'+odsentry_id+'" value="'+odsentry_id+'" id="chk'+odsentry_id+'" style="margin-left:10px !important;margin-bottom: 3px!important;" />';
									cells[1] = source;
									
									if (PerformDisable == 1) 
									{
										if(dest == null){
											dest = "";
										}
										cells[2] = '<input class="space_check  numeric_check destname"  autocomplete="off" customid="'+odsentry_id+'"  id="d'+odsentry_id+'" name="'+source+'" type="text" value="'+dest+'" style="vertical-align: middle;padding-bottom:3px;  " size="13" '+readonlytextbox+' ><span style="display:none;" id="updatechk'+odsentry_id+'" >'+dest+'</span>';
        								
									} 
									else {
											if(dest == null){
												dest = "";
											}
										
                                          cells[2] = '<input  onkeyup="chngbkcolor(this);" class="space_check  numeric_check destname" customid="'+odsentry_id+'" onkeyup="chngbkcolor(this);"  autocomplete="off" id="d'+odsentry_id+'" name="'+source+'" style="vertical-align: middle;padding-bottom:3px;" type="text" value="'+dest+'" size="13" '+readonlytextbox+'><span id="updatechk'+odsentry_id+'" style="display:none;">'+dest+'</span>';
                                    }
									
									
								    valid = '<?php __('Valid',true); ?>';
                                    invalid = '<?php __('Invalid',true); ?>';
									
									if (jArray[0]['Scenario']['status'] == 3){
										cells[3] = '<span class="sc_state_medium'+odsentry_id+'" >'+jArray[irow]['Odsentry']['config']+'</span>';
									}
									else{
										cells[3] = '<span class="sc_state_medium'+odsentry_id+'" >'+jArray[irow]['Odsentry']['dest1']+'</span>';
									}
									 
									var ai = t.fnAddData(cells,false);
								}
							
							//alert(t.fnGetData().length);
								t.fnDraw();
								console.timeEnd('populate');
								
								
								//$.fancybox.hideLoading();
								//$('.black_overlay_update').hide();

								//$.fancybox.hideLoading();
								
								
								setTimeout(function(){
									$('#fancybox-loading').hide();
									$('.black_overlay_update').hide();								
								}, 2000);
								
								
							}
							
							  var oTable;
							  oTable = $('#myTable7').dataTable();
							  
							$('#search_source').keyup( function() { 									
									oTable.fnFilter( $(this).val(),1); 
									
									//checkboxall();
									oTable.fnDraw();
							});
							$('#search_dest').keyup( function() { 									
								oTable.fnFilter( $(this).val(),2); 
								
								//checkboxall();
								oTable.fnDraw();
						   });  
							$('#search_state').change( function() { 
									//alert($(this).val());'=' + filterValue + '='
									filterValue = $(this).val();
									if(filterValue != ""){
										oTable.fnFilter("^"+$(this).val()+"$",3, true); 
									}else{
										oTable.fnFilter($(this).val(),3); 
									}
									//checkboxall();
									oTable.fnDraw();
							 });   
							 
							 $("#myTable7_filter").hide();
							
							$("#myTable7_first").text("<<");	
							$("#myTable7_previous").text(" <");	
							
							$("#myTable7_next").text(" >");	
							$("#myTable7_last").text(" >>");
							
							
							
							</script>
							
							<script type="text/javascript">
    function deleteOdsentry(record_id, scid, elem) {
        $.post(base_url + 'odsentries/delete/' + record_id + '/' + scid, {}, function(data) {
            //$('#'+record_id).closest('tr').remove();
            //alert('Record is deleted successfully');
			
			$('#overlay-sucess .ok .message').text("<?php __('Record is deleted successfully') ?>");
		    $('#overlay-sucess').removeClass('hide');
			
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

    /* 

    function paginationStyle(totPages,currPage) {
        // $("table").removeClass('table-striped');
        // $("table").removeClass('tablesorter-bootstrap');
        var pageDisplay = $(".cust_tab_pag .pagedisplay").text();
        temp = pageDisplay.split("-");
        temp[0] = $.trim(temp[0]);
        temp[1] = $.trim(temp[1]);
        if (typeof temp[1] != 'undefined') {
            page2 = temp[1].split("/");
            page2[0] = $.trim(page2[0]);
            page2[1] = $.trim(page2[1]);
            page3=page2[1].split("(");
            page3[0] = $.trim(page3[0]);
            page3[1] = $.trim(page3[1]);
            var showrecord = page3[0];
            totalPage = totPages;
        } else {
            return false;
        }
        if(typeof totalPage == "undefined")
        {
            return false;
        }
        $(".pagedisplay").text('');
        box = currPage+1;
        $('.countdisplay').html(showrecord);       
        var newStyle = "<input type='text' name='currpage' value='" + box + "' style='width:25px;text-align:center;float: inherit;' maxlength='3' class='GoOnTargetPage'>";
        newStyle += "<span style='font-weight:bold'> <?php echo __('Of') ?> " + totalPage + "</span>";
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

    }//end paginationstyle
	
*/
    jQuery(function() {
		/*
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
			emptyTo: 'zero',
            headerTemplate: '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!
			sortList: [[2,0],[1,0]],
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
                2: {sorter: true,filter: true, empty : "top" },
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
			 output: '{startRow} - {endRow} / {filteredRows} ({totalRows})',
			 pagerUpdate:function(totPages,currPage)
	        {
	            paginationStyle(totPages,currPage);
	        }
	    });
			*/
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
                    jQuery("#form2").submit();
                }
            }
        });

        jQuery("#reset_filter").click(function() {
            jQuery('#rangeMinMinval').val('');
            jQuery('#rangeMaxMaxval').val('');
            jQuery("#form2").submit();
        });

        jQuery(".deldest2").click(function() {
			$('.black_overlay').css('display', 'block');
	    $.fancybox.showLoading()  ;
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
				
				// var arr = CurrId.split('d');
		   
                var noofrecord = 0;
				var scStatus = $("#scenarioStatusId").val();
                jQuery('input[type="checkbox"]').each(function() {

                    var CClass = jQuery(this).parents("tr").attr('class');
                    if (CClass.indexOf("filtered") == -1) {
                        
						
						var attrid = jQuery(this).attr('id');
						var dataattr = attrid.split('chk');
						
						if(scStatus!=3){
							$("#d"+dataattr[1]).attr("class","space_check  numeric_check form-change");
						}
						

                        jQuery('#' + attrid).removeAttr('class');
                        jQuery('#' + attrid).prop("checked", true);
                        noofrecord++;
                    }
                });
                $('.counter').text(noofrecord - 1 + " <?php echo __('records are selected'); ?>");
				//$('.cnt').text("<?php echo __('Update scenario Selected'); ?> : " + (noofrecord - 1 ));

            } else {
                jQuery('input[type="checkbox"]').each(function() {
                    jQuery(this).removeAttr("checked");
                    $('.counter').text("0" + " <?php echo __('records are selected'); ?>");
					$('.cnt').text("");
					$('.cntchk_updatemsg2').hide();
                    $('.counter').hide();
					$('.deldest').hide();
					// when multiple update all dest fields are blue
					   var attrid = jQuery(this).attr('id');						
						var dataattr = attrid.split('chk');						
						$("#d"+dataattr[1]).attr("class","space_check  numeric_check ");
                });
            }
        });

        jQuery('.odsentchk').click(function() {
			
            var noofrecord = 0;
            jQuery("#checkAll").removeAttr("checked");
            $('.counter').show();
			
			$('.deldest').show();
			$('.cntchk_updatemsg2').show();
		
			
			var scStatus = $("#scenarioStatusId").val();			
            jQuery('input[type="checkbox"]').each(function() {
			// when multiple update all dest fields are blue
					  var attrid = jQuery(this).attr('id');						
						var dataattr = attrid.split('chk'); 
                 if ($(this).is(':checked')) {
						if(scStatus!=3){										
						//$("#d"+dataattr[1]).attr("class","space_check  numeric_check form-change");
						}
                    noofrecord++;
                }
				else{
					//$("#d"+dataattr[1]).attr("class","space_check  numeric_check  ");
				}
				
            });
			
			
            if (noofrecord < 1)
            {
                $('.counter').hide();
				$('.deldest').hide();
				$('.cntchk_updatemsg2').hide();
										
									
            }
            $('.counter').text(noofrecord + " <?php echo __('records are selected'); ?>");
			//$('.cnt').text("<?php echo __('Update  Selected'); ?> : " + (noofrecord ));

        });


        jQuery('.dosorting').click(function() {
            jQuery('input[type="checkbox"]').each(function() {
                jQuery(this).removeAttr("checked");
            });
        });

	});//end jQuery Start
    

    function saveToLog(action) {
			
        var comment = $('#crm_comment_option').val();
        var scenario_id = '<?php echo $scenario_id; ?>';
        var cust_id = '<?php echo $SELECTED_CUSTOMER; ?>';
        $.post(base_url + "scenarios/validates/" + scenario_id, {'log_entry': action, 'comment': comment, 'cust_id': cust_id}, function(data) { //alert(data);
            if (data) {
                //alert("Scenario "+action);
                if (data == "scenario_accepted") {
                    $('#sc_state').text('5');
                    //window.location.reload();
                } else if (data == "scenario_rejected") {
                    $('#sc_state').text('6');
                    //window.location.reload();

                } else if (data == "scenario_validate_requested") {
                    $('#sc_state').text('3');
                    //alert("scenario_validate_requested");
                    //window.location.href = base_url + "scenarios/index/" + cust_id;
                    //window.location.href = "<?php echo Configure::read('base_url'); ?>scenarios/index/<?php echo $SELECTED_CUSTOMER; ?>";
					window.location.href = "<?php echo Configure::read('base_url'); ?>scenarios/index/customer_id:<?php echo $SELECTED_CUSTOMER; ?>";
                    
                }
                url = "<?php echo Configure::read('base_url'); ?>scenarios/index/customer_id:<?php echo $SELECTED_CUSTOMER; ?>";
                //alert(url);
                window.location.href = url;
                
                //window.location.reload();
            }
        });

    }

</script>
<script>
  	function deletesource(val){ 
		//alert(val);
		$('.black_overlay').css('display', 'block');
	    $.fancybox.showLoading()  ;			
		var TargetURL = "<?php echo Configure::read('base_url');?>scenarios/deleteScenario/scenario_id:"+val;	
 		jQuery.post( TargetURL,  function( data ) {  //alert(data);			
			window.location.href = "<?php echo Configure::read('base_url'); ?>scenarios/index/customer_id:<?php echo $SELECTED_CUSTOMER; ?>";
	});
	setTimeout( function() {     
			$('#close-btn').trigger('click');
		 },200);
}

  	function submitBlockFilter(){ 
        
        
        
		var block_id = jQuery('#blockSelect').val();
        var scenario_id = '<?php echo $scenario_id; ?>';

        var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/edit/scenario_id:" + scenario_id + '&block_id=' + block_id;
		//window.location(TargetURL);
		 window.location.href = TargetURL;
        //jQuery.post(TargetURL, function(data) {
            
            //$("#msg").html(data);


        //});
        //location.reload(true);	
		
    //});
	}
	
function delete_allschedule(val){
	//$('.black_overlay').css('display', 'block');
	   // $.fancybox.showLoading()  ;	
	 var TargetURL = "<?php echo Configure::read('base_url');?>scenarios/delete_allschedule/"+val;
	 jQuery.post( TargetURL, function(data){
	 	$('#close-btn3').click();
	 	$('#add_numbers').click();
	 });
	 setTimeout( function() {     
			$('#close-btn').trigger('click');
		 },200);
}

  </script>
<script type="text/javascript">
    $(document).ready(function() {

    	$("body").on('paste', '.numeric_check', function(e) {
    		// alert("fdfdf");

		    // $("#updateOdsentry").show();    

		     $('#savedestinations').attr("onclick", "javascript:saveOdsentry(this);");
		    // $('#savedestinations').attr("class", "showhighlight_buttonleft");
		    // //jQuery('#destid').val(CurrId);

		    // $('#updateOdsentry').removeAttr("class");
		    // $('#updateOdsentry').attr("class", "button-right-hover");
		    
		    var obj = $(this);
		    chngbkcolor(obj);
		    setTimeout(function () {
		      var str = $(obj).val();
		      if(!str.match(/^\d+$/)) {
		        (obj).val('')
		      }
		    }, 10);
		    //return false;
	  	});



		jQuery('#updateOdsentry').hide();		            
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
		}
	 $(document).ready(function() {
	//called when key is pressed in textbox
	
	
	
	
    $("input.numeric_check").keydown(function(e) {	
	
	
		//console.log(e.which);

		/*
		 Digits and

·         number pad

·         back and

·         delete and

·         copy pasete (ctrl-v not supported) 
*/
      if( 
      	e.which!=8 && 
      	e.which!=0 && 
      	(e.which<48 || e.which>57) && 
      	e.which!=13 && 
      	e.which!=118 &&
      	(e.which<96 || e.which>106) &&
      	e.which!=37 &&
      	e.which!=39 &&
      	e.which!=17 &&
      	e.which!=67 &&
		e.which!=86 &&
		e.which!=88 &&
      	e.which!=46      	
      	)
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
		});

    
    $(document).ready(function() {	
		
        $('.counter').hide();
		
		$('.deldest').hide();
		$('.cntchk_updatemsg2').hide();

		//Omit space character to name field

		// $("#Id").keypress(function(e) {	
		// 	if (e.which == 32) {
		// 		return false;
		// 	}     
		// });

		
	
        $('#savescenariotitle').click(function() {

        	validation = {
	    	    // Specify the validation rules
	    	    'rules': {                     
	    	        'Id':{
	 					'required': true,
	 					'spclChar': true,
	    	            'max': '20',
	    	            'notSpace' : true,
	    	        }	                                  
	    	    },                
	    	    // Specify the validation error messages
	    	    'messages': {  
	    	        'Id': {
						'required': "<?php __('ScenarioNameNotempty')  ?>",
						'spclChar': "<?php __('Special characters are not allowed')  ?>",
	    	            'max': "<?php __('max20Chars')?>",
	    	            'notSpace': "<?php __('spaceNotAllowed')?>",
	    	        }	    	         
	    	    },			
	    	};
	    	
            var scenario_name = jQuery('.scenarios').val();
			var scenario_remark = jQuery('#ScenarioRemark').val();
            
			if (inValidate(validation)) {				
				$('#overlay-sucess').addClass('hide');
				return false;
			}else{							
	            var scenario_id = '<?php echo $scenario_id; ?>';
	            var customer_id = '<?php echo $customer_id; ?>';
				
	            var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/update_scname/scenario_id:" + scenario_id + "/customer_id:" + customer_id + "/scenario_name:" + scenario_name+ "/scenario_remark:" + scenario_remark;
	            jQuery.post(TargetURL, function(data) {
	                var msgd = data;
	                               
	                window.location.href = "<?php echo Configure::read('base_url'); ?>scenarios/edit/scenario_id:" + msgd;
					$('#overlay-sucess .ok .message').text("<?php __('Scenario succesfully added') ?>");
			        $('#overlay-sucess').removeClass('hide');
	             	 //$('#add_numbers').click();	
				 
					url = '<?php echo Configure::read('base_url');?>dns/selectdns/scenario_id:' + msgd;
	                //alert(url);
				   //$('#add_numbers').attr('href', url);
				   //$('#add_numbers').click();
				   //$("#add_numbers").trigger("click");
	               //jQuery('#scenariossuccess').html('<font class="scenarioupdatemsg">Scenario updated successfully!</font>');

	            });
           
			}
        });
		
		
		

$(function(){
     $("#Id").keyup(function(e){
          if (e.keyCode === 13) {
               var scenario_name = jQuery('.scenarios').val();
			 //if (inValidate(validation)) {				
				//in$('#overlay-sucess').addClass('hide');
			//	return false;
			//}else{							
            var scenario_id = '<?php echo $scenario_id; ?>';
            var customer_id = '<?php echo $customer_id; ?>';
            var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/update_scname/scenario_id:" + scenario_id + "/customer_id:" + customer_id + "/scenario_name:" + scenario_name;
            jQuery.post(TargetURL, function(data) {
                var msgd = data;
                               
                window.location.href = "<?php echo Configure::read('base_url'); ?>scenarios/edit/scenario_id:" + msgd;
				$('#overlay-sucess .ok .message').text("<?php __('Scenario succesfully added') ?>");
		        $('#overlay-sucess').removeClass('hide');
             	 //$('#add_numbers').click();	
			 
				url = '<?php echo Configure::read('base_url');?>dns/selectdns/scenario_id:' + msgd;
                //alert(url);
			   //$('#add_numbers').attr('href', url);
			   //$('#add_numbers').click();
			   //$("#add_numbers").trigger("click");
               //jQuery('#scenariossuccess').html('<font class="scenarioupdatemsg">Scenario updated successfully!</font>');

            });
          }
     });

});

        $('#crm_comment_option').val('');
    });


	validation = {
                // Specify the validation rules
        'rules': {                     
          
            'destname':{
            	'leading': '0',
                'min': '9',
                'max': '20',
                'excludeStr': ['084', '0800', '090', '00870','00881', '00882', '00883', '0039310']
                
              }  
                              
        },                  
        // Specify the validation error messages
        'messages': {            
            'destname': {
             	'leading' : "<?php __('leadingZeroOds')?>",
                'min': "<?php __('min9Chars')?>",
                'max': "<?php __('max20Chars')?>",
                'excludeStr' : "<?php __('excludeNumber')?>"
            }
        }
    };


    $("body").on('keydown', 'input, textarea', function(e) {  
  		//console.log("inside");
	    var form = $(this).parents('form:first');
//	    var invalidate = form.attr("invalidate");
	    var classinvalidate = form.attr("classinvalidate");

	    var oldVal = $(this).val();   
	    
	    var priorVal = $(this).attr('data-value'); 
	    
	    if (priorVal != '' && oldVal != priorVal) {
	        $(this).addClass('form-change');
			$('#overlay-sucess').addClass('hide');
	    }	

		if ((typeof classinvalidate != "undefined")) {     
	
	        classInValidate(validation, 'keyup', $(this), e); 
	  
			$('#overlay-sucess').addClass('hide');   

	    } else {
	      //console.log("no validation");
		  //$('#overlay-sucess').removeClass('hide');
	    }
	});

	$('.fancybox-loading').hide();	
    function saveOdsentry12(id) {
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
			

			//jQuery("#update"+rowid).text(Destval);
			
            senddata.push(Dbrowid + "=" + Destval);
			rowdata.push(Dbrowid);
			
			//window.location.reload();

        });

        var serialized = senddata.join("&")
		
		//var dstname="'d"+rowdata+"'";
				
        var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/updatemultipleodsentry/";
        var ScenarioId = $('#scenario_id').val();
        $('.black_overlaysaveOdsentry').show();
        jQuery.post(TargetURL, {'odsdata': serialized, 'scenario_id': ScenarioId}, function(data) {
			
        	$(".form-change").removeClass("form-change");
        	$(".hightlightbox").removeClass("hightlightbox");        	
            jQuery('#destid').val('');
            jQuery('.saveOdsentry').attr("style", "display:none");
            jQuery(' .trickOdsentry').attr("style", "display:inline");
            jQuery('#updateOdsentry').removeAttr("class");
            jQuery('#savedestinations').removeAttr("class");
            jQuery('#updateOdsentry').attr("class", " button-right-disabled");
			 jQuery('#updateOdsentry').hide();
            jQuery('#savedestinations').removeAttr("onclick");
			
			//make destination field heighlighted
			
			var numeric_text=$("input.numeric_check").each(function() {
			var num_val=$(this).val();
			var customid = $(this).attr('customid');
			//alert(customid);
			if(num_val!="")
			{
				$('#overlay-sucess').addClass('hide');
			}
			//$("#updatechk"+customid).text(num_val);
			//$("#d"+customid).attr('data-value',num_val);
			//$("#d"+customid).attr('value',num_val);
			//window.location.reload();
			
			//$("#reloadwholdpagedata").html(result);
		});     
		
		
		setTimeout(function() {
            // Update Scenario Status
			var scn_status = $('#sts').html();
            var TargetURL = "<?php echo Configure::read('base_url'); ?>scenarios/ScenarioCompletedOrNot/scenario_id:" + ScenarioId+"/status:"+scn_status;

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
			
				var scenairoInactive = "<?php echo __($scenarioStatus[$scenarioDetails[0]['Scenario']['status']], true); ?>";
				 
				
                if (msgd != "Incomplete") {
					
					if(msgd == scenairoInactive){

                    //Hide Workflow messages
                    jQuery('#crm_comment_workflow').hide();
                    jQuery('#complete_workflow').hide();
                    jQuery('#reject_workflow').hide();
                    jQuery('#activate_workflow').show();
                    jQuery('#invalid_workflow').hide();
					
				}else{
					
		
					
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
					
					}
					

                } 
				 
				else {
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
				
                $('.black_overlaysaveOdsentry').hide();
            }, 500);

        });
        }//end validation check else
		
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
							
							<!-- End of script Badal Singh -->
						</div>