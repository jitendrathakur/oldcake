
<?php //echo $this->element('editable'); ?>


<?php echo $javascript->link('/js/jquery.fancybox'); ?>

<?php  $selectnumber = Configure :: read('selectnumber'); 
       $checkboxselect =  $selectnumber[0];?>
	   <script type="text/javascript">
	
	$(document).ready(function() {
	$('.phonekey tr').html(function(i, el) {
  return el.replace(/>\s*</g, '><');
});

    $("#drp option").each(function(){
	      if($(this).val() == "")
	         $(this).remove();
	     });
	
		
		 
	});
	
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.fancybox').fancybox();
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#update').hide();
        $('#selectzip').show();
		
    });
	$(document).ready(function() {
		$('div').on('keyup','#pagenumber', function(e){
			$("input[type='text']").keypress(function(e) {
				if (e.which == 13) 
				{
					
					var t = $('#myTable7').dataTable();
					var textval = parseInt($(this).val());	
					
					t.fnPageChange(textval,true);
					
					$("#pagenumber").val(textval);
					//alert(textval);
				}
			});
	});
 });
    function zipvalidate()
    {
        $(document).ready(function() {

            var location_zip = $('#LocationPlz').val();
            var name = $('#LocationName').val();
			var address = $('#LocationAddress').val();
			var ort = $('#LocationOrt').val();
			 
			
            if (name == '') {
                
				
				$('#overlay-error .error .message').text("<?php __('Please enter location title') ?>");
		        $('#overlay-error').removeClass('hide');
				$('#overlay-sucess').addClass('hide');
                $('#LocationName').focus();
                return false;
            }
			if (address == '') {
                
				
				$('#overlay-error .error .message').text("<?php __('Please enter location address') ?>");
		        $('#overlay-error').removeClass('hide');
				$('#overlay-sucess').addClass('hide');
                $('#LocationAddress').focus();
                return false;
            }
			if (ort == '') {
                $('#overlay-error .error .message').text("<?php __('Please enter Ort') ?>");
		        $('#overlay-error').removeClass('hide');
				$('#overlay-sucess').addClass('hide');
                $('#LocationOrt').focus();
                return false;
            }

            if (location_zip == '') {
                
				$('#overlay-error .error .message').text("<?php __('Please enter zip code') ?>");
		        $('#overlay-error').removeClass('hide');
				$('#overlay-sucess').addClass('hide');
                $('#LocationPlz').focus();
                return false;
            }

            if (isNaN(location_zip)) {
                
				$('#overlay-error .error .message').text("<?php __('Please enter a valid zip code') ?>");
		        $('#overlay-error').removeClass('hide');
				$('#overlay-sucess').addClass('hide');
				
                return false;
            }
			
			

            var location_id = "<?php echo $location_id; ?>";
            var TargetURL = "<?php echo Configure::read('base_url'); ?>locations/validatezip/location_zip:" + location_zip;

            jQuery.post(TargetURL, function(data) {
						

                if(data == 2)
                {
                  
					$('#slect_zip').attr('href', "<?php echo Configure::read('base_url'); ?>locations/selectzip/location_zip:" + location_zip + '&showlist:1');
                    $("#slect_zip").trigger("click");
                } else {

                    if(data == 0) {
                        
						$('#overlay-error .error .message').text("<?php __('invalid ZIP, edit and try again') ?>");
		                $('#overlay-error').removeClass('hide');
						$('#overlay-sucess').addClass('hide');
                        return false;
                    } else {
						
                        var datasplit = data.split('****');
						
                        var emerval = datasplit[1];
						//var datadisp = datasplit[0]
						//if(datadisp==1){
							//alert('location added succesfully');
						//}
						$('#overlay-sucess .ok .message').text("<?php __('please add location details') ?>");
		                $('#overlay-sucess').removeClass('hide');
						$('#overlay-error').addClass('hide');
						
                        $('#LocationEmer').val(emerval);
                        $('#LocationEditForm').submit();                       						  
                        $('#selectzip').hide();
                        $('#update').show();
						//jQuery('#create').trigger("click");
                        jQuery('#create').attr("class", "showhighlight_buttonleft");
                        jQuery('#update').attr("class", "button-right-hover");
						

                    }

                }
            });
        });
    }

</script>


<script type="text/javascript">
    $(document).ready(function() {
		
		/*$('#drp').change(function(){
			
		location.reload(true);	
		}
		);
		
		*/
		
		
	$('#plus').trigger("click");	
    $('#button').removeAttr("onclick","");
    $('#button').attr("onclick","noinfo()");
	
        jQuery('.odsentchk').removeAttr("checked");
		jQuery('#rangeMinMinval').val("");
		jQuery('#rangeMaxMaxval').val("");
	   
	    $('#minus').hide();
        $('#mbtn').hide();
        $('#logmbtn').hide();

        $('#minus').click(function() {
            $('#pbtn').show();
            $('#minus').hide();
            $('#mbtn').hide();
            $('#plus').show();
        });

        $('#minus').hide();
        $('#mbtn').hide();

        $('#plus').click(function() {
            $('#pbtn').hide();
            $('#minus').show();
            $('#mbtn').show();
            $('#plus').hide();
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
<script>
	function noinfo(){
				
		$('#overlay-error .error .message').text("<?php __('no changes entered') ?>");
		$('#overlay-error').removeClass('hide');
	}
</script>
<script language="javascript">
    $(document).ready(function() {
        validation = {
            // Specify the validation rules
            'rules': {                     
                'LocationName':{
                    'required': true,
                    'max': '50'
                    //'max': '30'
                },  
                'LocationDesc':{
                    'max': '150'
                },                       
            },                  
            // Specify the validation error messages
            'messages': {  
                'LocationName': {
                     'required': "<?php __('LocationNameNotempty')  ?>",
                     'max': "<?php __('max50')  ?>"
                 }, 
				
	    	         'LocationDesc': {
                         'max': "<?php __('max150')  ?>"
	    	            
	    	         } 
            },
          };
        });
       // $('#button').click(function() { 
		function submitlocationForm(){ 
            if (inValidate(validation)) {   
                //return false;
            }else{
				
			   $('.duplicate').css('display','block');
              $.fancybox.showLoading()  ;       
            var location_name = jQuery('#LocationName').val();
            var location_remark = jQuery('#LocationDesc').val();
			var location_address = jQuery('#LocationAddress').val();
			var CustomerLocType = jQuery('#drp').val();
			var location_ort = jQuery('#LocationOrt').val();
            var location_id = '<?php echo $location_id; ?>';
			var location_remark = jQuery('#LocationDesc').val();
			var location_cer1 = jQuery('#LocationCer1').val();
		    var location_cer2 = jQuery('#LocationCer2').val();
                                
								 
            //var TargetURL = "<?php echo Configure::read('base_url'); ?>locations/editlocation/location_id:" + location_id + "/location_name:" + location_name + "/location_remark:" + location_remark+ "/location_address:" + location_address+ "/loctype:" + CustomerLocType+ "/location_ort:" + location_ort+ "/location_cer1:" + location_cer1+ "/location_cer2:" + location_cer2;
            var TargetURL = "<?php echo Configure::read('base_url'); ?>locations/editlocation/location_id:" + location_id + "/location_name:" + location_name + "/location_address:" + location_address+ "/loctype:" + CustomerLocType+ "/location_ort:" + location_ort+ "/location_cer1:" + location_cer1+ "/location_cer2:" + location_cer2;
			
			
			
            jQuery.post(TargetURL, {location_remark: location_remark }, function(data) {
				
			//alert(data);
                window.location.reload();
                //$("#msg").html(data);
				//$('#overlay-sucess .ok .message').text("<?php __('changes added successfully') ?>");
				//$('#success_added').hide();
				 
		        $('#overlay-sucess').removeClass('hide');
                jQuery('#updateOdsentry').removeAttr("class");
                jQuery('#updateOdsentry').attr("class", "button-right-disabled");
                jQuery('#button').removeAttr("class");

            });
			}
        //});
		}

		function submitBlockFilter(){ 
            
			         
            
			var block_id = jQuery('#blockSelect').val();
            var location_id = '<?php echo $location_id; ?>';

            var TargetURL = "<?php echo Configure::read('base_url'); ?>locations/edit/" + location_id + '&block_id=' + block_id;
			//window.location(TargetURL);
			 window.location.href = TargetURL;
            //jQuery.post(TargetURL, function(data) {
                
                //$("#msg").html(data);
	

            //});
            //location.reload(true);	
			
        //});
		}

    

    function toggleShowHistory() {
        //$("#advancesearch").show
        if (document.getElementById('showhistory').style.display == 'none') {
            document.getElementById('showhistory').style.display = 'block';
        } else {
            document.getElementById('showhistory').style.display = 'none';
        }
    }
    function toggleLogs() {
        //$("#advancesearch").show
        if (document.getElementById('showLogs').style.display == 'none') {
            document.getElementById('showLogs').style.display = 'block';

         	$('#logplus').hide();
         	$('#logminus').show();
        } else {
            document.getElementById('showLogs').style.display = 'none';
        }
    }
    
</script>
<script type="text/javascript"> 
    $(document).ready(function() { //alert("ret");

    	$(document).keypress(function(e) {
    		if (e.which == 13) {
    			$("a#filter_now").trigger('click');
    			return false;    			
    		}
    	});

        
	});
</script>
<style>

    .tablesorter-filter
    {
        width:100% !important;
		margin: 0 -2px !important;
        padding: 4px 1px !important;
    }
  /*  .space_check
    {
        width:91%;
        height:auto !important;
        margin-bottom:0 !important;
    }*/
    .table th, .table td
    {
        padding: 1px 6px;  
        border:none;
    }
    .tablesorter-bootstrap .tablesorter-pager select
    {
        width:64px;
        margin:0 20px;
    }
    .table-top th, .table-right-ohne th
    {
        height:40px;
        border-top:#CCC 1px solid;

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
	
	.t_Tooltip{
	display:none !important;
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
.tablesorter-bootstrap .tablesorter-header-inner {
    font-size: 11px;
    padding: 0px 10px 4px 0!important;
    position: relative;
	margin-left:-3px!important
}
  

/*.tablesorter-bootstrap .tablesorter-filter-row .tablesorter-filter {
  
    margin: 0 -2px !important;
    padding: 4px 1px !important;
   
}*/
</style>
<script>
$(document).ready(function(){
		
        $(".readtext").click(function(){
            $(this).blur();
			return false;
        });
    });
</script>


<script type="text/javascript">
    function deleteOdsentry(record_id, elem) {
        $.post(base_url + 'odsentries/index/' + record_id, {}, function(data) {
            if (data == "success") {
                $('#' + record_id).closest('tr').remove();
                alert('Record is deleted successfully');
            }
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
        //console.log(showrecord);
        $('.countdisplay').html(showrecord);
        var newStyle = "<input type='text' name='currpage' value='" + box + "' style='width:25px;text-align:center;float: inherit;' maxlength='3' class='GoOnTargetPage'>";
        newStyle += "<span style='font-weight:bold'> <?php echo __('Of') ?> " + totPages + "</span>";
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


    jQuery(function() {
	/*
        jQuery.extend(jQuery.tablesorter.themes.bootstrap, {
            // these classes are added to the table. To see other table classes available,
            // look here: http://twitter.github.com/bootstrap/base-css.html#tables	
        });

        // call the tablesorter plugin and apply the uitheme widget
        jQuery(".dataTable").tablesorter({
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
			sortList: [[0,1],[1,0]],
			
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
                1: {sorter: true, filter: true },
                2: {sorter: true, filter: true},
                3: {sorter: true, filter: true},
                4: {sorter: true, filter: true},
                5: {sorter: true, filter: true},
				7: {sorter: false, filter: false}

             }
        })
                .tablesorterPager({
                    // target the pager markup - see the HTML block below
                    container: jQuery(".pagerlocationedit"),
                    // target the pager page select dropdown - choose a page
                    cssGoto: ".pagenum",
					initWidgets: true,
                    // remove rows from the table to speed up the sort of large tables.
                    // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
                    removeRows: false,
                    // output string - default is '{page}/{totalPages}';
                    // possible variables: {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
                    //output: '{startRow} - {endRow} [{page}] {filteredRows} ({totalRows})'
                    //output: 'Page <input type="text" name="currpage" value="{page}" class="pagination_text" maxlength="3"> Of {totalPages}'
                    output: '{startRow} - {endRow} / {filteredRows} ({totalRows})',
                    pagerUpdate:function(totPages,currPage)
                    {
                        paginationStyle(totPages,currPage);
                    }
        					

                });*/
				
//$(document).ready(function() {

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
                    //jQuery("#form").submit();

                    var TargetURL = "<?php echo Configure::read('base_url'); ?>locations/filterdnslocation/location_id:<?php echo $location_id; ?>" + "/MinVal:" + MinVal + "/MaxVal:" + MaxVal;
                                        jQuery.post(TargetURL, function(response) {
                                            $('#ajax_load').html(response);
                                        });

                                    }
                                }
                            });

                            jQuery("#reset_filter").click(function() {

                                jQuery('#rangeMinMinval').val('');
                                jQuery('#rangeMaxMaxval').val('');
                                //jQuery("#form").submit();
                            });
							
							
							/*jQuery("#reset_check").click(function() {

                               jQuery('input[type="checkbox"]:checked').each(function() {
                                    jQuery(this).removeAttr("checked", false);
                                });
								$('.cnt').text("");
								   //$('.cntchk_updatemsg').hide();
								    $('.cntchk_updatemsg2').hide();
								   $('#reset_check').hide();
                            });*/
							

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
                            });

                            jQuery('.odsentchk').click(function() {
                                var noofrecord = 0;
								 //var  selnum = $("#chknumber").val();
								 var  selnum = $(".pagesize").val();
									  var chknum = selnum-1;
                                jQuery('input[type="checkbox"]').each(function() {
                                    if ($(this).is(':checked')&& $(this).attr('id')!='checkAll') {
									
										if(noofrecord<=chknum){
											noofrecord++;
										}
										else{
											var attrid = jQuery(this).attr('id');
                                            jQuery('#' + attrid).removeAttr("checked", "");
											return false;
										}
                                        
                                    }
                                });

                                //$('.cnt').text("<?php echo __('dnOfLocationSelected'); ?> :" + noofrecord);	
								$('.cnt').text("<?php echo __('Update Selected'); ?> :" + noofrecord);	
								
							
								
								if(noofrecord==0){
								//$('#reset_check').hide();	
								//$('.cntchk_updatemsg').hide();
								 $('.cntchk_updatemsg2').hide();
								}else{
									//$('#reset_check').show();
									//$('.cntchk_updatemsg').show();
									 $('.cntchk_updatemsg2').show();
								}
								

                            });


                            /*Check All / Uncheck All functionality*/
                            jQuery("#checkAll").click(function() {
                                if (jQuery("#checkAll").is(':checked')) {
									

                                    jQuery('#content input[type="checkbox"]').each(function() {
                                        var attrid = jQuery(this).attr('id');
                                        jQuery('#' + attrid).removeAttr("checked");
                                    });

                                    var noofrecord = 0;
									var checkFilteredClass;
                                    jQuery('input[type="checkbox"]').each(function() {
                                        var CStyle = jQuery(this).parents("tr").attr('style');
                                        var CClass = jQuery(this).parents("tr").attr('class');
                                   		//var  selnum = $("#chknumber").val();
										var  selnum = $(".pagesize").val();
										
										
										//var  selnum = "<?php echo count($dnsdetail); ?>";
										//alert(selnum);
                                        //if (CStyle.indexOf("display: none") == -1 ) {
										
											if(noofrecord<=selnum){
												
												
												checkFilteredClass = jQuery(this).parent().parent().hasClass("filtered");
												

                                               if (!checkFilteredClass) {
											   	    
                                            var attrid = jQuery(this).attr('id');
                                            jQuery('#' + attrid).prop("checked", "checked");
											
                                            noofrecord++;	
                                                 }
																
											}
											else{
												var attrid = jQuery(this).attr('id');
	                                            jQuery('#' + attrid).removeAttr("checked", "");
												return false;
										     }					
                                           // $('.cnt').text("<?php echo __('dnOfLocationSelected'); ?> : " + (noofrecord - 1 ));
											$('.cnt').text("<?php echo __('Update Selected'); ?> : " + (noofrecord - 1 ));
											$('#checkAll').removeAttr("data-value","");																					
											//$('.cntchk_updatemsg').show();
											 $('.cntchk_updatemsg2').show();
											 $('#reset_check').show();
											 
											// $('#seldns').attr("class", "showhighlight_buttonright");
											 //$('#updateselected').removeAttr("class");
		                    				// $('#updateselected').attr("class", "button-right-hover");
											 
											
                                        //}
										  /*if (CClass.indexOf("filtered") == -1) {
										  	if(noofrecord<=selnum){
                                            var attrid = jQuery(this).attr('id');
                                            jQuery('#' + attrid).prop("checked", "checked");
											
                                            noofrecord++;						
											}
											else{
												var attrid = jQuery(this).attr('id');
	                                            jQuery('#' + attrid).removeAttr("checked", "");
												return false;
										     }						
                                            $('.cnt').text("<?php echo __('dnOfLocationSelected'); ?> : " + (noofrecord - 1 ));
																																
											$('.cntchk_updatemsg').show();
											 $('.cntchk_updatemsg2').show();
											 $('#reset_check').show();
                                        }*/
										
                                    });
									//alert(noofrecord);
                                   // $('.cnt').text("<?php echo __('dnOfLocationSelected'); ?> :" + noofrecord - 1);
											

                                } else {
									
                                    jQuery('input[type="checkbox"]').each(function() {
										
                                        jQuery(this).removeAttr("checked");
                                    });
                                   // $('.cnt').text("0" + ": <?php echo __('dnOfLocationSelected'); ?>");
								   $('.cnt').text("");
								   //$('.cntchk_updatemsg').hide();
								    $('.cntchk_updatemsg2').hide();
								    $('#reset_check').hide();
								  
                                }
                            });

                            jQuery('.dosorting').click(function() {
                                jQuery('.dosorting').addClass("tablesorter-icon");
                                jQuery('input[type="checkbox"]').each(function() {
                                    jQuery(this).removeAttr("checked");
                                });
                            });

                        });

                        function saveToLog(action) {
                            var comment = $('#LogAfterdate').val();
                            var scenario_id = '<?php echo $scenario_id; ?>';
                            var cust_id = '<?php echo $SELECTED_CUSTOMER_NAME; ?>';
                            $.post(base_url + "scenarios/validates/" + scenario_id, {'log_entry': action, 'comment': comment, 'cust_id': cust_id}, function(data) { //alert(data);
                                if (data) {
                                    alert("Scenario " + action);
                                    if (data == "scenario_accepted") {
                                        $('#sc_state').text('5');
                                    } else if (data == "scenario_rejected") {
                                        $('#sc_state').text('6');

                                    } else if (data == "scenario_validate_requested") {
                                        $('#sc_state').text('6');
                                    }
                                }
                            });
                        }

                        function chngbkcolor(obj) {
                            $(document).ready(function() {
                                jQuery('#button').attr("class", "showhighlight_buttonleft");

                                jQuery('#updateOdsentry').removeAttr("class");
                                jQuery('#updateOdsentry').attr("class", "button-right-hover");
								$('#button').attr("onclick","submitlocationForm()");

                            });
                        }


</script>
<script>
function set_visifilterlocation(val)
{	
	if(val=='shortcontloc') {	
		$(".scontloc").slideToggle("slow");		
	}	
}

</script>
<script>
function set_visimenu(val)
{
	
	if(val=='dispmenu') {
			$("#edit_stat_popupmenu").slideToggle("slow");
	}
}

</script>

<?php $selnumber = Configure :: read('selectnumber');
$chknumber = $selnumber[0];
 ?>
 <input type="hidden" name="chknumber" id="chknumber" value="<?php echo $chknumber; ?>"/>
<?php $leaveStatus = Configure :: read('leaveStatus'); ?>
<?php if ($leaveStatus[0] == "on") { ?>
    <!--######## Start  Save Leave Page Event #################-->
   <script language="JavaScript">
        var ids = new Array('LocationName', 'LocationDesc');
        var values = new Array('', '');

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
<!--
<div class="black_overlay duplicate"  style="display: none; width:100%; height: 160%;"></div>
-->
<div class="block top">

<span id="smsg"></span>

<div id="overlay-error" class="notification first hide" style="width: 100%" >
    
    <div class="error">
        <div class="message">
            
        </div>
    </div>
</div>

<div id="overlay-sucess" class="notification first hide" style="width: 100%" >
    
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
	
		<div id="success_added" class="notification first" style="width: 534px" >
		
			<div class="ok">
				<div class="message">
					<?php echo $success;?>
				</div>
			</div>
		</div>
		
	<?php }elseif(isset($error) && $error){?>
		<div class="notification first" >
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
		
		if (!empty($location)) { $readonly = 'true'; ?>
		 <h4><?php echo __('locationDetail'); ?>
		 <span id="msg"> <?php echo $location['Location']['name']; ?></span>
		 </h4>
		    
	     	<?php } 
    	else { ?>
		<script>
			$(document).ready(function() {
				
       
		$('#overlay-sucess .ok .message').text("<?php __('please add location details') ?>");
		$('#overlay-sucess').removeClass('hide');
    });
		</script>
		
		 <h4><?php echo __('locationCreate'); ?></h4> <?php  }
		if (!empty($location)) { ?>	
    		<div id="myTable" class="phonekey table-content">
        	<?php echo $form->create(null, array('id' => 'LocationEditForm', 'url' => array('controller' => 'locations', 'action' => 'update/' . $location_id), 'accept-charset' => 'UTF-8', 'invalidate' => 'invalidate')); ?>
        	<input type="hidden" value="" id="hid_blf"/>
        	<input type="hidden" name="location_id" id="location_id" value="<?php echo $location_id; ?>" />
           		<fieldset>
                	<fieldset style="display:none;">
                    	<input type="hidden" name="_method" value="PUT" />
                	</fieldset>
               <!--Start of location attributes section -->
                <input type="hidden" id="show_main_val" value="0"  />
                <div id="newEdit">
                   <div class="form-body">
                        <div class="form-box">
                            <div class="form-left">
                                <?php
                                echo '<div style="width:100px; float: left">' . __('loc_name', true) . '</div>';
                                echo $form->input('Location.name', array('label' => false, 'type' => 'text', 'value' => $location['Location']['name'], 'style' => 'width:140px;', 'onkeyup' => "chngbkcolor(this);",''));
                                echo '<div style="width:100px; float: left">' . __('Remark', true) . '</div>';
                                echo $form->input('Location.desc', array('label' => false,'rows'=>'5','cols'=>'45', 'value' => $location['Location']['remark'], 'style' => 'width:140px;', 'onkeyup' => "chngbkcolor(this);"));
                                ?> 
                              <!-- 
                                <?php 
                                if ($userpermission == Configure::read('access_id')) { 
									$readonlyfield = 'false';
									$class = ''; }
								else{
									$readonlyfield = 'false';
									$class = 'readtext'; } ?>	
                               	<div style="width:100px; float: left"><?php echo __('locType', true) ?> </div> <?php	
									$loc_type = __($loctype,true);								
									echo $form->select('loc_type', $loc_type,$location['Location']['loc_type'],array('label'=>false, 'style'=>'width:146px;margin-top:5px','id'=>'drp','onchange'=>'chngbkcolor(this)','readonly' => $readonlyfield,'class'=>$class));
 								?>	
 							  -->
                            </div>
                          	<div class="form-right">
                                <?php
                                echo '<div style="width:100px; float: left">' . __('Address', true) . '</div>';
                                echo $form->input('Location.address', array('type' => 'text', 'label' => false, 'value' => $location['Location']['address'], 'style' => 'width:140px;', 'onkeyup' => "chngbkcolor(this);"));
                                ?>			
                            </div>
                            <div class="form-right">
                                <?php
                                echo '<div style="width:100px; float: left">' . __('Ort', true) . '</div>';
                                echo $form->input('Location.ort', array('type' => 'text', 'label' => false, 'value' => $location['Location']['ort'], 'style' => 'width:140px;', 'onkeyup' => "chngbkcolor(this);"));
                                ?>			
                            </div>
                            <div class="form-left">
                                <?php
								
								if($location['Location']['emer']!=""){
									$readonly12="true";
								}
								else{
									$readonly12="false";
								}
                                echo '<div style="width:100px; float: left">' . __('zip', true) . '</div>';
                                echo $form->input('Location.zip', array('type' => 'text', 'label' => false, 'value' => $location['Location']['plz'], 'style' => 'width:140px;','readonly'=>$readonly12, 'onkeyup' => "chngbkcolor(this);"));
                                ?>	
                           </div>
                           <div class="form-right">
                                <?php
                                echo '<div style="width:100px; float: left">' . __('emer', true) . '</div>';
                                echo $form->input('Location.emergency', array('type' => 'text', 'label' => false, 'value' => $location['Location']['emer'], 'style' => 'width:140px;', 'readonly' => $readonly ,'class'=>'readtext'));
                                ?>		
                            </div>
                            <div class="form-right">
                                <?php
                                echo '<div style="width:100px; float: left">' . __('Pro Nr', true) . '</div>';
                                echo $form->input('Location.pro_nr', array('type' => 'text', 'label' => false, 'value' => $location['Location']['pro_nr'], 'style' => 'width:140px;', 'readonly' => $readonly ,'class'=>'readtext'));
                                ?>		
                            </div>
							<!-- mgi 7.6.14
							<div class="form-right">
                                <div style="width:100px; float: left"><?php echo __('locSource', true) ?> </div> <?php
							  	$locsource = __($location['Location']['loc_source'],true);
							    echo $form->input('Location.loc_source', array('type' => 'text', 'label' => false, 'value' => $locsource, 'style' => 'width:140px;', 'readonly' => $readonly ,'class'=>'readtext')); ?>		
                            </div> 
                            --> <?php 
							
							if (($userpermission == Configure::read('access_id')) && ($_SESSION['VIEWMODE'] != 'EXTERNAL'))  { ?> <?php 
							
							if ($location['Location']['loc_type']!='Virtual'){ ?>
                            <br><br>
                            <h5><?php echo __('technical', true) ?>
							</h5>
							<div><?php echo __('dataNotSynchronized', true) ?></div>
							</br>
 						    <div class="form-right">
                            <?php
                            echo '<div style="width:100px; float: left">' . __('Scm Name', true) . '</div>';
                            echo $form->input('Location.scm_name', array('type' => 'text', 'label' => false, 'value' => $location['Location']['scm_name'], 'style' => 'width:140px;', 'readonly' => $readonly ,'class'=>'readtext'));
                            ?>
                        </div>
                  		    <div class="form-right">
                            <?php
                            echo '<div style="width:100px; float: left">' . __('lbl', true) . '</div>';
                            echo $form->input('Location.lbl', array('type' => 'text', 'label' => false, 'value' => $location['Location']['lbl'], 'style' => 'width:140px;', 'readonly' => $readonly ,'class'=>'readtext'));
                            ?>
                        </div>
                            <div class="form-right">
                                <?php
                                echo '<div style="width:100px; float: left">' . __('Type', true) . '</div>';
                                echo $form->input('Location.loctype', array('type' => 'text', 'label' => false, 'value' => $location['Location']['loctype'], 'style' => 'width:140px;', 'readonly' => $readonly ,'class'=>'readtext'));
                                ?>		
                            </div>
                            <div class="form-left ">
                                <?php
                                echo '<div style="width:100px; float: left">' . __('Middle Box Id', true) . '</div>';
                                echo $form->input('Location.middle_box', array('type' => 'text', 'label' => false, 'value' =>  $location['Location']['middle_box'], 'style' => 'width:140px;', 'readonly' => $readonly ,'class'=>'readtext'));
								?>
                            </div>
                            <div class="form-right tooltip">
                                <?php
                                   echo '<div style="width:100px; float: left">' . __('CER Name', true) . '</div>';
								   $ident = $location['Location']['cer1'];
								   if(strlen($ident) > 25){ $link = substr($location['Location']['cer1'], 0, 25) . '..';}
								   else {	$link = $location['Location']['cer1'];	}
                                   echo $form->input('Location.cer1', array('type' => 'text', 'label' => false, 'value' => $link, 'style' => 'width:139px;','class'=>'' ,'onkeyup'=>'chngbkcolor(this)',));
								 if(strlen($location['Location']['cer1'])>25) { ?>
                                  <div>
								   <div class="fl"><span style="cursor:default" >
								<p><?php  echo $location['Location']['cer1']; ?></p>
                                </div>
							</div>
                                <?php }  ?>
                            </div>
                            <div class="form-left">
                                <?php
                                echo '<div style="width:100px; float: left">' . __('CER Name2', true) . '</div>';
                                echo $form->input('Location.cer2', array('type' => 'text', 'label' => false, 'value' => $location['Location']['cer2'], 'style' => 'width:140px;', 'onkeyup'=>'chngbkcolor(this)','class'=>''));
                                ?>		
                            </div>
                            <div class="form-right">
                                <?php
                                echo '<div style="width:100px; float: left">' . __('Srv code', true) . '</div>';
                               echo $form->input('Location.srv_code', array('type' => 'text', 'label' => false, 'value' => $location['Location']['srv_code'], 'style' => 'width:140px;', 'readonly' => $readonly ,'class'=>'readtext'));
                                ?>		
                            </div>
                            <div class="form-left">
                                <?php
                                echo '<div style="width:100px; float: left">' . __('Call Spliting', true) . '</div>';
                                echo $form->input('Location.call_splitting', array('type' => 'text', 'label' => false, 'value' => $location['Location']['call_splitting'], 'style' => 'width:140px;', 'readonly' => $readonly ,'class'=>'readtext'));
                                ?>		
                            </div>
                            <div class="form-right">
                                <?php
                                echo '<div style="width:100px; float: left">' . __('Bw', true) . '</div>';
                                echo $form->input('Location.bw', array('type' => 'text', 'label' => false, 'value' => $location['Location']['bw'], 'style' => 'width:140px;', 'readonly' => $readonly ,'class'=>'readtext'));
                                ?>		
                            </div>
                            <div class="form-left">
                                <?php
                                echo '<div style="width:100px; float: left">' . __('Technologies', true) . '</div>';
                                echo $form->input('Location.technology', array('type' => 'text', 'label' => false, 'value' => $location['Location']['technology'], 'style' => 'width:140px;', 'readonly' => $readonly ,'class'=>'readtext'));
                                ?>		
                            </div>
                           <div class="form-right">
                               <div style="width:100px; float: left"><?php echo __('locSource', true) ?> </div> <?php
							   $locsource = __($location['Location']['loc_source'],true);
							   echo $form->input('Location.loc_source', array('type' => 'text', 'label' => false, 'value' => $locsource, 'style' => 'width:140px;', 'readonly' => $readonly ,'class'=>'readtext')); ?>		
                            </div>
                            <div class="form-left">
                               	<div style="width:100px; float: left;margin-top: 0px;"><?php echo __('locType', true) ?> </div> <?php	
								$loc_type = __($loctype,true);								
								echo $form->select('loc_type', $loc_type,$location['Location']['loc_type'],array('label'=>false,'empty'=>'false' ,'style'=>'width:146px;margin-top:-1px','id'=>'drp','onchange'=>'chngbkcolor(this)','readonly' => $readonlyfield,'class'=>$class));?> 
							</div>	
                              <!-- <div style="width:100px; float: left"><?php echo __('locType', true) ?> </div>-->
 							<?php	
								#$loc_type = __($loctype,true);								
								#echo $form->select('loc_type', $loc_type,$location['Location']['loc_type'],array('label'=>false, 'style'=>'width:140px;','id'=>'drp','onchange'=>'chngbkcolor(this)'));
 								?>	
                            	<?php echo $form->input('Location.id', array('type' => 'hidden', 'value' => $location_id)); ?>		
                                <?php echo $form->end(); ?>
                          </div>
						   <?php 
						    } else {  ?>
							
						   
						  <?php
						    }			  
						  
						  }
						  if ($location['Location']['loc_type']=='Virtual'){ ?>
						  
						 <input type="hidden" id="drp" value="<?php echo $location['Location']['loc_type']?>" />
						  <input type="hidden" id="LocationCer1" value=" " />
						   <input type="hidden" id="LocationCer2" value=" " />
						  
						  	 <?php  /* ?> 
						   
						   <br><br>
                            <h5><?php echo __('technical', true); ?></br> </h5>
							<div><?php echo __('dataNotSynchronized', true); ?></div>
							</br>
						    <div class="form-right">
                               <div style="width:100px; float: left"><?php echo __('locSource', true) ?> </div> <?php
							   $locsource = __($location['Location']['loc_source'],true);
							   echo $form->input('Location.loc_source', array('type' => 'text', 'label' => false, 'value' => $locsource, 'style' => 'width:140px;', 'readonly' => $readonly ,'class'=>'readtext')); ?>		
                            </div>
                            <div class="form-left">
                               	<div style="width:100px; float: left;margin-top: 0px;"><?php echo __('locType', true) ?> </div> <?php	
								$loc_type = __($loctype,true);								
								echo $form->select('loc_type', $loc_type,$location['Location']['loc_type'],array('label'=>false, 'style'=>'width:146px;margin-top:-1px','id'=>'drp','onchange'=>'chngbkcolor(this)','readonly' => $readonlyfield,'class'=>$class));?> 
							</div>	
                             
 							
                            	<?php echo $form->input('Location.id', array('type' => 'hidden', 'value' => $location_id)); ?>		
                                <?php echo $form->end(); ?>
						  
						   </div>	
						   <?php */  ?> 
						   <?php }
						    ?> 
                       </div>
					   
                    </div>
               
                <!--<div class="button-right">
                       <a href="javascript:void(null);"  onclick="document.getElementById('LocationEditForm').submit();" name="validate" value="validate"><?php __('Update') ?></a>
                </div>-->
                <div class="button-right-disabled"  id="updateOdsentry">
                    <!--<a href="javascript:void(null);" id="button"  name="validate" class="buttonvalid" onclick="needToConfirm = false;" value="validate" ><?php __('updateLocationEdit_button') ?></a>-->
					<a href="javascript:void(null);" id="button"  name="validate" class="buttonvalid" onclick="submitlocationForm();" value="validate" ><?php __('updateLocationEdit_button') ?></a>
					
					
                </div>
            </fieldset>
            </form>
            <div style="display:block">					
                <h4 style="display:block;float:left;width: 100%;"><?php echo __('DN_details_LocEdit', true); ?> <a class="maintopRelatedContentButton" id="maintopContentButton" onclick="return toggleShowHistory();" href="javascript:void(0)" style="float:right;">
                        <div style="width:20px; height:20px;" id="pbtn">
                            <div id="plus"></div>
                        </div>
                        <div style="width:20px;background:#eee; height:20px;" id="mbtn">
                            <div id="minus"></div>
                        </div>
                    </a>
					<a style="font-weight: normal;font-size: 12px !important;margin-left: 5px;" href="javascript:;" id="edit_stat" onclick="set_visimenu('dispmenu')"  <?php echo $readonly; ?>><?php// __("Options"); ?> </a>
					</h4> 
            </div>
<br/><br/>
<?php 
if(($custtype=="Gate") || ($custtype=="Gate +")){
	$dispfunc = 1;
}
else{
	$dispfunc = 2;
}
?>

        
            <?php
            if (isset($showHistory)) { ?> <div class="table-content" style="display:none"> <?php } 
            else { ?> <div id="showhistory" class="table-content" style="display:block"> <?php } ?>

            <form id="form" class="filtersForm" action="<?php echo Configure::read('base_url'); ?>locations/edit/<?php echo $location['Location']['id']; ?>" enctype="multipart/form-data" method="POST">    
                <input type="hidden" name="location_id" id="location_id" value="<?php echo $location['Location']['id']; ?>" />
                <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $SELECTED_CUSTOMER_NAME; ?>" />                 					
					<?php  $selectedLanguage = $_SESSION['Config']['language'];
						if($selectedLanguage=='de'){
							 $width = 200;
							 $rangeminwidth = 85;
							 $rangemaxwidth = 60;
							 $filterwidth = 220;
							 }
						else if($selectedLanguage=='fr') {
							 $width = 183;
							 $rangeminwidth = 75;
							 $rangemaxwidth = 75;
							 $filterwidth = 213;
							 }
						else if($selectedLanguage=='it'){
							$width = 146;
							 $rangeminwidth = 75;
							 $rangemaxwidth = 75;
							 $filterwidth = 213;
						}
						else if($selectedLanguage=='en'){
							 $width = 146;
							 $rangeminwidth = 75;
							 $rangemaxwidth = 75;
							 $filterwidth = 213;
						}
					?>
					<?php
$user_agent = $_SERVER['HTTP_USER_AGENT']; 

if (preg_match('/MSIE/i', $user_agent)) {
	$locwidth = 350;
	$checkwidth = 100;
	$dnlocation = 120; 
	}
	else{
	$locwidth = 150;
	$checkwidth = 80;
	$dnlocation = 90; 	
	}
?>
					 <?php
				    $dncount=count($dnsdetail);
			    	if ( $dncount==0) { ?><div>&nbsp;&nbsp;</div> <div  style="display:none"> <?php }
			    	else { ?> <div  style="display:block"> <?php }?>
					
				<div id="edit_stat_popupmenu" style="display:non ">
                      <div id="shortcontloc" class="scontloc" style="display: ;margin-left: 5px;">
					  <!-- <?php echo __('DN Range Filter'); ?> -->
					  
					  	<?php if(isset($blockOptions))
					  	{?>
					    <div class="form-box">
 							<div class="form-left">
                                <?php echo $form->input('block_id', array('label' => false,'type'=>'select', 'options'=>$blockOptions, 'id' => 'blockSelect', 'default'=>$block_id,'style'=>'width:206px;','onchange'=>"javascript:submitBlockFilter();")); ?>
					
                            </div>
                            <div class="form-right">
                               <p><?php echo __('largeDataSet_blurb')?></p>	
                            </div>
 							
 							<!-- 
 							<div class="form-left" style="margin-left: 0px;width:<?php echo $rangeminwidth; ?>px !important">
                                <?php echo '<div style="width:80px; float: left;margin-left: 0px;">' . __('rangeMin', true) . '</div>'; ?>		
                            </div>
							<div class="form-right" style="margin-left: 1px;width:85px !important">
                                <?php echo $form->input('rangeMin.minval', array('style' => 'margin:1px 2px 3px 22px; width:65px !important;', 'label' => false, 'class' => 'filter_range_textbox', 'div' => false, 'maxlength' => '9', 'value' => $rangeMinval));?>		
                            </div>
							<div class="form-left" style="margin-left: 1px;width:<?php echo $rangemaxwidth; ?>px !important;">
                                <?php echo '<div style="width:50px; float: left;margin-left: 40px;">' . __('rangeMax', true) . '</div>';?>		
                            </div>
                            <div class="form-right" style="margin-left: 5px;width:85px !important;">
                                <?php echo $form->input('rangeMax.maxval', array('style' => 'margin:1px 2px 3px 8px;width:65px !important;', 'label' => false, 'class' => 'filter_range_textbox', 'div' => false, 'maxlength' => '9', 'value' => $rangeMaxval));?>		
                            </div>
							<div class="form-left" style="width: <?php echo $width; ?>px !important; margin-top: -9px!important" >
							<div class="button-right" id="reset_filter" >
                                <a id="reset_filter" href="javascript:void(0);" onmouseout="outButtonRight(this)" onmouseover="hoverButtonRight(this)"><?php __('Clear') ?></a>
                            </div>
							<div class="button-right" id="filter_now" >
                                <a id="filter_now" href="javascript:void(0);" onmouseout="outButtonRight(this)" onmouseover="hoverButtonRight(this)"><?php __('filter') ?></a>
                            </div>	
                            -->											
 						 </div>	
 						 <?php } # end large dataset?>
 						 
                        </div>
						
 					  </div>	                       
				</div>
                        <input type="hidden" id="customer_id_data" value="<?php echo $selected_customer; ?>">
                        <div class="clear"></div>
 				<span id="msg"></span>
				<!-- <div style="display: inline;margin-left:5px; margin-top: -20px;" class="cnt" > <?php #echo __('dnOfLocationSelected'); ?> </div> 
                   <?php echo $html->link(__("Update Selected", true), array('controller' => 'dns', 'action' => 'openlocationupdateview/customer_id:' . $SELECTED_CUSTOMER_NAME . '/loc_id:' . $location['Location']['id']), array('class' => $selected['DN List'] . " fancybox fancybox.ajax cntchk_updatemsg")); ?> 
                    <div class="button-right" style="float: right;margin: -4px 2px 11px !important;"><a href="javascript:;" id="reset_check"  onMouseOver="Tip('<?php echo __('Cleck here Reset all selected checkbox') ?>', BALLOON, true, ABOVE, false) , hoverButtonRight(this)" onMouseOut="UnTip() , outButtonRight(this)"><?php echo __('Reset'); ?></a></div> --> 
                 
               
				 </div>
				
				    
				
				 <?php
				    $dncount=count($dnsdetail);
			    	if ( $dncount==0) { ?> 
					<div style="margin: auto"><?php echo __("currentlyNoDnForLocation_pleaseAddDn"); ?></div>
					<div class="button-right-hover" style="margin: -22px 2px 11px !important;">
                            <?php echo $html->link(__("Add Numbers", true), array('controller' => 'dns', 'action' => 'selectdns', "location_id:" . $location['Location']['id']), array('class' => $selected['DN List'] . " fancybox fancybox.ajax showhighlight_buttonleft" )); ?>		
                        </div>	
					
					<div  style="display:none">
					 <?php }
			    	else { ?> <div  style="display:block"> <?php }?>
				
				
				 <!-- <div class="pagerlocationedit form-horizontal" >            
                   <?php// echo __("totalEntries")?> <span class="countdisplay"></span> <?php //echo __("entriesPerPage"); ?>: 
                    <select class="pagesize input-mini" title="Select page size" style="float: right; margin-right: <?php echo $filterwidth; ?>px;">
                        <option selected="selected" value="10">10</option>						
                        <option selected="selected" value="25">25</option>
                        <option selected="selected" value="50">50</option>
                        <option selected="selected" value="100">100</option>
                    </select>
 									
					</div> 	-->
				   
                       <div id="ajax_load">
								<!-- Badal Singh -->
								
								<input type="hidden" name="IDS" id="IDS"  />
								<input type="hidden" name="IDSSAVE" id="IDSSAVE"  />
								
								<script type="text/javascript" language="javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.2/jquery.dataTables.min.js"></script>
							
							
							
							
							<div id="" class="table-content">
							<div class="black_overlay_update duplicate" style="display:block;"></div>
							<table id="myTable7" class="dataTable phonekey" cellpadding="0" cellspacing="0" style="width:98%; border:1px solid #ccc !important; margin-left:5px; border-top-color:#CCC">
								
								<thead>
								
									<tr class="tablesorter-filter-row78">
									
										<td>&nbsp;</td>
										<td><input type="text" id="search_filter" ></td>
										
										
										<td>
											<select id="msds-select">
											<option></option>
											<?php
												foreach($locationlist as $list){
												?>
												<option value="<?php echo $list; ?>"><?php echo $list; ?></option>
											<?php	
												}
											?>
											
											</select>
										</td>
										
										
										<?php 
										$checkthirdcol = 0; 
										if($dispfunc=='2') { $checkthirdcol = 1;}?>
										
										<?php
										if($checkthirdcol){?>
										<td>
											<select id="msds-select-function">
											<option></option>
											<?php
												foreach($functionlist as $list){
												?>
												<option value="<?php echo $list; ?>"><?php echo $list; ?></option>
											<?php	
												}
											?>
										
											</select>
										</td>
										<?php	
											}
										?>
										
									</tr>
								
                                    <tr class="table-top" style=" border:1px solid #ccc !important; border-bottom:#D1D1D1 1px solid; border-right: 1px solid #D1D1D1;border-top:#D1D1D1 1px solid;">
                                        <!--<th width="3%" class="table-column table-left-ohne withdatatabledatatablecss" >&nbsp;</th>-->
                                        <th align="left" style="border-right: 1px solid rgb(209, 209, 209) ! important;" width="<?php $checkwidth; ?>px !important;border-left: 1px solid #D1D1D1!important;" class="table-left-ohne" ><input type="checkbox"  name="sAll" id="checkAll" class="showselect" style="margin-top: 5px !important;margin-left:3px !important;"  ></th>
                                        <th style="border-right: 1px solid rgb(209, 209, 209) ! important;" align="left" width="<?php echo $dnlocation; ?>px !important" class="table-column dosorting " style="margin-top: -2px;" ><a href="javascript:void(0);"><?php echo __('dnLocation')?></a> </th>
                                        <th  style="border-right: 1px solid rgb(209, 209, 209) ! important;" align="left" width="<?php echo $locwidth; ?>px !important" class="table-column filter-select filter-parsed  dosorting" data-placeholder=""><a href="javascript:void(0);"><?php  echo __('location')?></a></th>
                                   <?php 
										$checkthirdcol = 0;
										if($location['Location']['scm_name']=="UNKNOWN"){  $checkthirdcol =1; ?>
                                        <th width="150px !important" class="table-column filter-select filter-exact dosorting" data-placeholder=""><a href="javascript:void(0);"> <?php echo __('emer')?></a></th><?php } ?>
										<?php if($dispfunc=='2') { $checkthirdcol = 1;?>
                                        <th align="left" width="150px !important" class="table-column filter-select filter-exact dosorting" data-placeholder=""><a href="javascript:void(0);"> <?php echo __('Function')?></a></th>
										<?php } ?>
                                    </tr>
									</thead>
									
								<tbody>
								
								</tbody>
							</table>
							</div>
							<!-- Badal Singh -->
							<script>
							
							//$(document).ready(function() {
							
							//});
							
							
							
							populate();
							//alert('dddd');
							function populate()
							{
								//alert('dddd');
								
								$.fancybox.showLoading();
								$('.black_overlay_update').show();
								
								
								var checkthirdcol = "<?php echo $checkthirdcol; ?>";
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
										"aoColumnDefs": [
											{ "sWidth": "10%", "aTargets": [ -1 ] }
										],
									
									"oLanguage": {
										"sSearch": "Futher Filter Search results:",
										"sInfo": "Got a total of _TOTAL_ results to show (_START_ to _END_)",
										"sLengthMenu": '<div style="float:left"><?php echo __("totalEntries")?> : &nbsp;<div id="counter" style="width:20px;float:right;"></div> </div> <div style="float:right"><?php echo __("entriesPerPage"); ?> :  <select style="margin-top:-1px;">' +
										'<option value="5">5</option>' +
										'<option value="10">10</option>' +
										'<option value="15">15</option>' +
										'<option value="20">20</option>' +
										'<option value="25">25</option>' +
										'</select></div><br />'
											},
											"bSort": true,
											"aaSorting": [[ 0, "desc" ]],
											"aaSorting": [[ 1, "asc" ]],
									
									'fnDrawCallback': function(oSettings) {
									
										//$('#myTable7_paginate span').html(" Hello _TOTAL_");
										/*
										var oTable = $('#myTable7').dataTable();
										$('input:checked', oTable.fnGetNodes()).each(function(i){

											alert($(this).val());

										});
										
										*/
										
										
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
											
											$("#msds-select-function").html(functionuniquearray);
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
									    $('#myTable7_paginate span').html(' Page <input class="GoOnTargetPage12" id="pagenumber" maxlength="maxlength" style="width:25px;text-align:center;float: inherit;" type="text" value="' + (iPage+1) + '" /> of ' + iTotalPages);
									  
									    $('div#counter').html(iTotal);
										$("#chknumber").val(iTotal);
										
										if ($("#checkAll").is(':checked')) {
											
											//$('.odsentchk').bind('click', function() {  });
											getval = $("#chknumber").val();
											if(iTotal == getval)
											$('.cnt').text("<?php echo __('Update Selected'); ?> : " + (iTotal));
										}
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
								

								
								var jArray = <?php echo $jsondnsdetail; ?>;
								var IDS = "";
								var countlength = "<?php echo count($dnsdetail ); ?>";
								
								
								 var seldnids = '';
								 var dnIdCount = 0;
								 var breakWordCheck;
								 var dn_id;
								
								for (var irow = 0; irow < countlength; irow++)   
								{
									var cells = new Array();
									//var r = jQuery('<tr  id=' + irow + '>');
									//for (var icol = 0; icol < 1; icol ++)
									
									getId = jArray[irow]['Dns']['id'];
									dnsid = jArray[irow]['Dns']['id'];
									
									
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
									
									//$("#IDS").val(seldnids);
									
									cells[0] = '<input onclick="checkallf()" type="checkbox" align="left" id="chk'+getId+'" value="'+getId+'" class="odsentchk">';
									
									
									cells[1] = jArray[irow]['Dns']['id'];
									
									locationid = jArray[irow]['Location']['id'];
									
									cells[2] = '<a id="" class="fancybox fancybox.ajax" href="<?php echo Configure::read('base_url'); ?>locations/create_location/customer_id:<?php echo $SELECTED_CUSTOMER_NAME; ?>/dns_id:'+dnsid+'/location_id:'+locationid+'/loc_id:'+locationid+'">'+jArray[irow]['Location']['name']+'</a>';
									
									if(checkthirdcol)
									{
									
										//cells[3] = jArray[irow]['Dns']['function'];
										scm_name = 	jArray[irow]['Location']['scm_name'];
										
										
										if(scm_name=="UNKNOWN"){
											cells[3] = jArray[irow]['Dns']['emer'];
										}
										
										var dispfunc = "<?php echo $dispfunc; ?>";
										
										//alert(dispfunc);
										
										
										if(dispfunc=='2') {
											
											functionval = jArray[irow]['Dns']['function'];
											
											if(jArray[irow]['Dns']['function']!=''){
												//alert('<?php echo __($dnsdetail[1]['Dns']['function'],true); ?>');
												cells[3] =  functionval;
											}
											else { 
												cells[3] =  "<?php echo __('free',true); ?>";
											} 
										}
										
										
									}
									var ai = t.fnAddData(cells,false);
								}
								
								$("#IDS").val(seldnids);
								$("#IDSSAVE").val(seldnids);

									
								
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
							
							
							
							$(document).ready(function() {
							  
							  var oTable;
							  oTable = $('#myTable7').dataTable();

							  $('#msds-select').change( function() { 									
									oTable.fnFilter( $(this).val(),2); 
									
									//checkboxall();
									
									//$("div a.cnt").text("Hello");
									oTable.fnDraw();
							   });
							   
							    $('#msds-select-function').change( function() { 									
									oTable.fnFilter( $(this).val(),3); 
									
									//checkboxall();
									oTable.fnDraw();
							   });
							   
							   $('#search_filter').keyup( function() { 									
									oTable.fnFilter( $(this).val(),1); 
									//checkboxall();
									oTable.fnDraw();
							   });
							   
							   
						   });
							
							$('#btn').click(function(){populate();});

							console.time('render');
							
							/*
							jQuery('#myTable7').dataTable(
								{
									'bDestroy': true,
									"bInfo": true,
									"bProcessing": true,
									"bDeferRender": true,
									'iDisplayLength': 10,
									'sPaginationType': 'full_numbers',
									'sDom': '<"top"i> T<"clear">lfrtip',
									'sPageButtonActive': "paginate_active",
									'sPageButtonStaticDisabled': "paginate_button",
									"oLanguage": {
										//"sSearch": "Futher Filter Search results:",
										"sInfo": "Got a total of _TOTAL_ results to show (_START_ to _END_)",
										"sLengthMenu": 'totalEntries entriesPerPage:  <select>' +
								'<option value="5">5</option>' +
								'<option value="10">10</option>' +
								'<option value="15">15</option>' +
								'<option value="20">20</option>' +
								'<option value="25">25</option>' +
								'</select>'
									},
								    "bSort": false,
									"aaSorting": [[ 0, "desc" ]],
									"aaSorting": [[ 1, "desc" ]]
								}
								);
							console.timeEnd('render');
							//$("table#myTable7 tr:nth-child(2)").remove();
							//$("#myTable7_filter").hide();
							*/
							
							$("#myTable7_filter").hide();
							
							$("#myTable7_first").text("<<");	
							$("#myTable7_previous").text(" <");	
							
							$("#myTable7_next").text(" >");	
							$("#myTable7_last").text(" >>");
							
							

							
							</script>
							
							<!-- End of script Badal Singh -->
                        </div> 
						
                        <div class="" style="" >
						<!--<div class="cnt" style="display: inline;margin-left:5px; margin-top: -20px;"></div>-->
						<div id="updateselected" class="button-left-hover" style="margin: 10px 2px 11px !important;">
                            <?php echo $html->link(__("Update Selected", true), array('controller' => 'dns', 'action' => 'openlocationupdateview/customer_id:' . $SELECTED_CUSTOMER_NAME . '/loc_id:' . $location['Location']['id']), array('class' => $selected['DN List'] . " fancybox fancybox.ajax cntchk_updatemsg2 cnt showhighlight_buttonright")); ?> 
							</div>
                             
                        </div><br/>
					<!--	</div>-->
						<div class="button-right-hover" style="margin: -11px 2px 11px !important;">
 <?php echo $html->link(__("Add Numbers", true), array('controller' => 'dns',  'action' => 'selectdns', "location_id:" . $location['Location']['id']), array('class' => $selected['DN List'] . " fancybox fancybox.ajax showhighlight_buttonleft ",'id'=>"add_numbers" )); ?>		
                        </div> 		
                        </div> 		
                    </form>		    
                </div>
                
      <!-- LOGS -->
				<h4 style="display:block;float:left;width: 100%;"><?php echo __('Logs')?> <a class="maintopRelatedContentButton" id="maintopContentButton" onclick="return toggleLogs();" href="javascript:void(0)" style="float:right;">
					<div style="width:20px; height:20px;" id="logpbtn">
					<div id="plus"></div>
					</div>
					<div style="width:20px; height:20px;" id="logmbtn">
					<div id="minus"></div>
					</div>
					</a></h4>
					</div>
			    	<?php
			    	if (isset($showLogs) || ((isset($success)) && $success)) { ?>
					 <div id="showLogs" class="table-content" style="display:none"> <?php }
			    	else { ?> <div id="showLogs" class="table-content" style="display:none"> <?php }?>
				    <table class="table-content phonekey">
				    <thead>
						<tr class="table-top">
							<th class="table-column"> <?php echo __('Created');?></th>
							<th class="table-column"> <?php echo __('User');?></th>
							<th class="table-column"> <?php echo __('log_entry');?></th>
							<th class="table-column"> <?php echo __('Detail');?></th>
						</tr>
					</thead>
	  			      <tbody>
		        		<?php
							// loop through and display format
							foreach($loginfo as $log): ?>
	            			<tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">
	                		<td style="width:70px;">
	                	<?php
	               		 $formatted_date = date('d.m.Y H:i:s',strtotime($log['Log']['created']));
	                		preg_match("/^(.*) (.*)/", $formatted_date, $matches);
					if ($matches[0])
					{
	               	 	#$datetime2line = $matches[1] . '<br>' . $matches[2];
	               	 	echo $matches[1] ;
	               	 	echo $matches[2] ;
					}else{
	                	echo $log['Log']['created'] ;
	                }
	                ?>
	               </td>
	                <td style="width:50px;">
	                <?php echo $log['Log']['user'] ?>
	           		</td>
	                 <td><?php
	                 $logstring = htmlspecialchars($log['Log']['log_entry']);
	                 echo substr($logstring, 0, 70);
	                 #echo $logstring;
	                 ?>...</td>
	          			<td> <?php echo $html->link(__("details", true), array('controller'=> 'logs', 'action'=>'logdetails',$log['Log']['id']), array('class' => "fancybox fancybox.ajax")); ?></td>
	         	  </tr>
	         		<?php
					endforeach;
					?>
	       	 	</tbody>
				</table>
			 </div>
			</div>
    <?php
} else {
    ?>
    <input type="hidden" value="" id="hid_blf"/>
    <div id="myTable" class="phonekey table-content">
        <fieldset>
           <fieldset>
                <fieldset style="display:none;">
                    <input type="hidden" name="_method" value="PUT" />
                </fieldset>
                <!-- CBM
                	<div class="button-right">
                      <a href="javascript:void(null);"  onclick="javascript:return validate_form();" name="validate" value="validate" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"> <?php __('Validate') ?></a>
                    </div>
                    <div class="button-left">
                		<?php echo $html->link(__('reset', true), array('controller' => 'stations', 'action' => 'edit', $location['Location']['id']), array('onmouseover' => 'javascript:hoverButtonLeft(this);', 'onmouseout' => 'javascript:outButtonLeft(this);')); ?>
                    </div>
                -->
            </fieldset>

     <!--Start of Create Location attributes section -->
            <?php echo $form->create(null, array('id' => 'LocationEditForm', 'url' => array('controller' => 'locations', 'action' => 'update/'), 'accept-charset' => 'ISO-8859-1')); ?>      
            <input type="hidden" id="show_main_val" value="0"  />
            <div id="newEdit">
               <div class="form-body">
                    <div class="form-box">
                             <div class="form-left">
                                <?php
                                echo '<div style="width:100px; float: left">' . __('loc_name', true) . '</div>';
                                echo $form->input('Location.name', array('label' => false, 'type' => 'text', 'value' => $location['Location']['name'], 'style' => 'width:140px;', 'onkeyup' => "chngbkcolor(this);",'class'=>'form-changevalidate'));
                                echo '<div style="width:100px; float: left">' . __('Remark', true) . '</div>';
                                echo $form->input('Location.remark', array('label' => false,'rows'=>'5','cols'=>'45', 'value' => $location['Location']['remark'], 'style' => 'width:140px;', 'onkeyup' => "chngbkcolor(this);"));
                                ?>
                            </div>
                          <div class="form-right">
                                <?php
                                echo '<div style="width:100px; float: left">' . __('Address', true) . '</div>';
                                echo $form->input('Location.address', array('type' => 'text', 'label' => false, 'value' => $location['Location']['address'], 'style' => 'width:140px;', 'onkeyup' => "chngbkcolor(this);",'class'=>'form-changevalidate'));
                                ?>			
                            </div>
                            <div class="form-right">
                                <?php
                                echo '<div style="width:100px; float: left">' . __('Ort', true) . '</div>';
                                echo $form->input('Location.ort', array('type' => 'text', 'label' => false, 'value' => $location['Location']['ort'], 'style' => 'width:140px;', 'onkeyup' => "chngbkcolor(this);",'class'=>'form-changevalidate'));
                                ?>			
                            </div>
                            <div class="form-left">
                                <?php
                                echo '<div style="width:100px; float: left">' . __('zip', true) . '</div>';
                                echo $form->input('Location.plz', array('type' => 'text', 'label' => false, 'value' => $location['Location']['plz'], 'style' => 'width:140px;', 'onkeyup' => "chngbkcolor(this);",'class'=>'form-changevalidate'));
                                ?>	
                           </div>
                           
                       <!--  
                             <div class="form-right">
                                <?php
                                echo '<div style="width:100px; float: left">' . __('emer', true) . '</div>';
                                echo $form->input('Location.emergency', array('type' => 'text', 'label' => false, 'value' => $location['Location']['emer'], 'style' => 'width:140px;', 'readonly' => $readonly ,'class'=>'readtext'));
                                ?>		
                            </div>
						-->

                       <div class="form-right">
                            <?php
                            echo '<div style="width:100px; float: left">' . __('Emrg String', true) . '</div>';
                            echo $form->input('Location.emer', array('type' => 'text', 'label' => false, 'value' => $location['Location']['emer'], 'style' => 'width:100px;', 'readonly' => 'true'));
                            echo $form->input('Location.customer_id', array('type' => 'hidden', 'label' => false, 'value' => $SELECTED_CNN));
                            echo $form->input('Location.slug', array('type' => 'hidden', 'label' => false, 'value' => ''));
							
                            ?>		

                        </div>
						<!--  
                            <div class="form-right">
                                <?php
                                echo '<div style="width:100px; float: left">' . __('Pro Nr', true) . '</div>';
                                echo $form->input('Location.pro_nr', array('type' => 'text', 'label' => false, 'value' => $location['Location']['pro_nr'], 'style' => 'width:140px;', 'readonly' => $readonly ,'class'=>'readtext'));
                                ?>		
                            </div>
						-->

                        <div class="button-right-hover" id="update" >
                          <!--  <a href="javascript:void(null);" id="create"  onclick="document.getElementById('LocationEditForm').submit();" name="update" value="validate" ><?php __('createLocation') ?></a> -->
                        </div>
                        <div class="button-right" id="selectzip">
                            <a href="javascript:void(null);"  onclick="zipvalidate();" name="validate" value="validate" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __('validateEmer') ?></a>
                        </div>
                        <div class="form-left">
                            <?php
                            echo $form->input('Location.status', array('type' => 'hidden', 'value' => 1));
                            echo $form->input('Location.customer_id', array('type' => 'hidden', 'value' => $SELECTED_CUSTOMER_NAME));
							$randgeneratedid = rand(0,time());
							echo $form->input('Location.id', array('type' => 'hidden', 'value' => $randgeneratedid));
							echo $form->input('Location.loc_type', array('type' => 'hidden', 'value' => 'Virtual'));
							
                            ?>		
                            <?php echo $form->end(); ?>
                        </div>	
                    </div>	
                </div>
            </div>	
            </form>
    </div>
    </div>
    <div style="visibility:hidden;" id="slelectzip_div" ><a id="slect_zip"  class="fancybox fancybox.ajax" >ADD zip</a></div>

    </fieldset>
<?php }
?>
<?php if(empty($location)){ 
	echo "</div>";
}
?>

<!--right hand side starts from here-->
<div id="related-content">
    <div class="box start link">
        <a href="http://www.swisscom.ch/grossunternehmen" target="_blank">
            <?php __('Home Swisscom') ?>
        </a>
    </div>
    <div class="box">
        	 <h3><?php __('locationEdit') ?></h3>
                 <p>
                  <?php __('locationEdit_blurb') ?>
                 </p>
			<div id="shortcont">
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('fullcont')"  title=""><?php echo __('moreStart') ?></a>             
            </div>
            <div style="display:none;" id="fullcont_type"  >
               <p  ><?php echo __('dnlocationEdit_helpText') ?></p>
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('shortcont')"  title=""><?php echo __('moreEnd') ?></a>      
			</div>
    </div>
		
   <!--  mgi 7.6.14 
    <div class="box call-to-action">
        <div class="info info-error" style="z-index: 2">
            <a href="" id="warningNotification">&nbsp;</a></div><h3><?php __("notifications"); ?></h3>
        	<p><?php __("InWork Objects"); ?>.</p>
        <div>
            <ul><?php echo $this->element('right_notifications', array('SELECT_CUSTOMER' => $SELECTED_CNN)); ?></ul>	
        </div>
    </div>
   --> 
    <!--INTERNAL USER OPTIONS -->
    <?php if ($userpermission == Configure::read('access_id')) {
        ?>
        <div class="box info">
            <h3><?php __('Internal User') ?></h3>
            <p>   
			<?php echo $html->link( __($selected_customer . '('. $SELECTED_CNN. ')', true), array('controller'=> 'customers', 'action'=>'customeredit', 'customer_id:'.$SELECTED_CNN), array('class' => " fancybox fancybox.ajax",'style'=>'color:#555 !important;text-decoration:none;')); ?>
			
			<?php //echo $selected_customer . '('. $SELECTED_CNN. ')'; ?>
				
			</p>
            <p><?php echo $location['Location']['pro_nr']; ?></p>
       </div>

        <!--COmment out upload functionality 
        <fieldset>
        <div class="block">
        <div class="button-left">
        <a href="javascript:void(null);"  onclick="javascript:return upload_xml();"  onmouseover="hoverButtonLeft(this)" onmouseout="outButtonLeft(this)">
        <?php __("Upload"); ?>
        </a>
        </div>
        </div>
        </fieldset>
        -->


    <?php 
    		if ($_SESSION['VIEWMODE'] == 'EXTERNAL')
    		{
    			echo $html->link(__("scmView", true), array('controller' => 'locations', 'action' => 'toggleView?customer_id=' . $SELECTED_CNN . '&view=INTERNAL'));
    		}
    		else
    		{
    			echo $html->link(__("userView", true), array('controller' => 'locations', 'action' => 'toggleView?customer_id=' . $SELECTED_CNN . '&view=EXTERNAL'));
    		}
        } ?>
</div>
<!--right hand side  ends here-->

</div>
<script type="text/javascript">
	/*
	$(document).ready(function() {
	if($('#LocationEmergency').val()!=""){
		  document.getElementById("LocationZip").disabled=true;
		 
		 }
		 });
		 
		 */
</script>