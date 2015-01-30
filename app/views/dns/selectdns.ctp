<?php 
if(($cst_type=="Gate") || ($cst_type=="Gate +")){
	$dispfunc = 1;
}
else{
	$dispfunc = 2;
}


$user_agent = $_SERVER['HTTP_USER_AGENT']; 
if (preg_match('/MSIE/i', $user_agent)) { 
	$top = "30";					
}else{
							
$top = "48";						
 }
if (preg_match('/Firefox/i', $user_agent)) { 
						  
$top = "30";						 
}
							
						
?>


<style>
.fancybox-inner{
	height: auto !important;
    overflow: auto;
    width: 650px!important;
}

.tablesorter-bootstrap .tablesorter-header-inner {
    padding: 1px 10px 4px 0 !important;
}
td { white-space: nowrap; }
th{width: 80px ! important; text-align: left; -moz-user-select: none;}
</style>
<script type="text/javascript">
    $(document).ready(function() {
		
				

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
		
    });

    function submitBlockFilterSelectdns(){ 
	var filterval = $("#blockSelectSelectDns option:first").text();
		
		var arr = filterval.split('(');
		var arrdata = arr[1];
		
		var arr2 = arrdata.split(')');
		
		$("#dnval").val(arr2[0]);

	    var hrefBefore = jQuery('#add_numbers').attr('href');
		var block_id = jQuery('#blockSelectSelectDns').val();
		var dnsval = jQuery('#dnval').val();

		var hrefFilter = hrefBefore+'&block_id=' + block_id+'&dnval=' + arr2[0];
		jQuery('#add_numbers').attr('href',hrefFilter);
         jQuery('.black_overlay').removeAttr('style');
         jQuery('.black_overlay').attr("style", "display:none");
         jQuery('.fancybox-close').click();
         jQuery('#add_numbers').trigger("click");
		 jQuery('#add_numbers').attr('href',hrefBefore);
		
        //var TargetURL = "<?php echo Configure::read('base_url'); ?>test/edit/" + location_id + '&block_id=' + block_id;
		//window.location(TargetURL);
		// window.location.href = TargetURL;
        //jQuery.post(TargetURL, function(data) {
            
            //$("#msg").html(data);


        //});
        //location.reload(true);	
		
    //});
	}
     jQuery('#checkAllDn').click(function() {
			if ($(this).is(':checked')) {
				jQuery('#dnsbutton').attr("class", "showhighlight_buttonleft");
				jQuery('#updatedns').removeAttr("class");
				jQuery('#updatedns').attr("class", "button-right-hover");
			}
			else{
				
				
				jQuery('#updatedns').attr("class", "button-right");
				jQuery('#updatedns a').removeAttr("class");
				
			}
	 });
	function checkallf(id){
		//alert('added');
					jQuery('#dnsbutton').attr("class", "showhighlight_buttonleft");
					  jQuery('#updatedns').removeAttr("class");
                      jQuery('#updatedns').attr("class", "button-right-hover");
		if ($("#checkAllDn").is(':checked')) {
										
					var noofrecord = 0;
					 var  selnum = $("#chknumber").val();
					// alert(selnum);
						  var chknum = selnum-1;
						
						//jQuery('input[type="checkbox"]').each(function() {
						if ($("#chk"+id).is(':checked')) {
							
						 
							//if(noofrecord<=chknum){
								selnum++;
								
							//}
							//else{
								//var attrid = jQuery(this).attr('id');
							   // jQuery('#' + attrid).removeAttr("checked", "");
								//return false;
							//}
							
						}
						else
						{
							selnum--;
						
						}
						
					//});

					//$('.cnt').text("<?php echo __('dnOfLocationSelected'); ?> :" + noofrecord);	
					$('.cntdns').text("<?php echo __('dnOfLocationSelected'); ?> :" + selnum);	
					
				
					
					if(selnum ==0){
					//$('#reset_check').hide();	
					//$('.cntchk_updatemsg').hide();
					 $('.cntdns').hide();
					}else{
						//$('#reset_check').show();
						//$('.cntchk_updatemsg').show();
						 $('.cntdns').show();
					}
					
					$("#chknumber").val(selnum);	
					
					 // jQuery('#updatedns').removeAttr("class");
                    //  jQuery('#updatedns').attr("class", "button-right-hover");
					}
					else{
						counter = 0;
								$('.selectdnsCheckbox').each(function() {
									if ($(this).is(':checked')) {
										counter++;
									}
								});
							//singlecount++;
							//$("#chknumber").val(singlecount);
								$('.cntdns').text("<?php echo __('dnOfLocationSelected'); ?> :" + counter);	
							$('.cntdns').show();
							
					}
	}
</script>
<script type="text/javascript">
function set_visifilterdns(val)
{	
	if(val=='shortcontdns') {
			$(".scontdns").slideToggle("slow");
	}	
}

</script>


<script type="text/javascript">

    jQuery(document).ready(function() {
		$('.cntdns').hide();
        /** code to select all filteres records : start **/
        $('.reset').click(function() {
            var checkboxes = $(this).closest('form').find(':checkbox');
            checkboxes.removeAttr('checked');
        });



<?php if (isset($scenario_name)) { ?>

        jQuery('.selectdnsCheckbox').click(function() {
            var noofrecord = 0;
			$('.cntdns').show();
            jQuery('input[type="checkbox"]').each(function() {
				var  selnum = $("#chknumber").val();
				var  chknum = selnum-1;
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
			//alert('s');
            var noofrecord = 0;
            if (jQuery("#checkAllDn").is(':checked')) {
				$('.selectdnsCheckbox').prop("checked", "checked");		
				counter = 0;
					$('.selectdnsCheckbox').each(function() {
					if ($(this).is(':checked')) {
					counter++;
					}
					
					});
					$("#chknumber").val(counter);	
$('.cntdns').text("<?php echo __('dnOfLocationSelected'); ?> : " + counter);
$('.cntdns').show();	
            } else {
               $('.selectdnsCheckbox').prop("checked", "");	
			   $('.cntdns').hide();
            }
        });

<?php } else { ?>

jQuery('.selectdnsCheckbox').click(function() {
            var noofrecord = 0;
			$('.cntdns').show();
            jQuery('input[type="checkbox"]').each(function() {
				var  selnum = $("#chknumber").val();
				
				var  chknum = selnum-1;
				
                if ($(this).is(':checked')) {
					if(noofrecord<=chknum){
										
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
			//alert('s1');
            if (jQuery("#checkAllDn").is(':checked')) {
					$('.selectdnsCheckbox').prop("checked", "checked");		
					counter = 0;
					$('.selectdnsCheckbox').each(function() {
					if ($(this).is(':checked')) {
					counter++;
					}
					});
					$("#chknumber").val(counter);
$('.cntdns').text("<?php echo __('dnOfLocationSelected'); ?> : " + counter);	
$('.cntdns').show();				
            } else {
                $('.selectdnsCheckbox').prop("checked", "");	
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
			var customerid="<?php echo $cst_id; ?>";    

            if ((MinVal.length < 9 || MinVal.length > 9) && (MaxVal.length < 9 || MaxVal.length > 9)) {
                alert('Filter Range From and To Must Be 9 digits!');
                return false;
            } else {

                if (isNaN(MinVal) || isNaN(MaxVal)) {
                    alert('Filter Range must be numeric only!');
                    return false;
                } else {

                   // var TargetURL = "<?php echo Configure::read('base_url'); ?>dns/filterdns/scenario_id:<?php echo $scenario_id; ?>" + "/MinVal:" + MinVal + "/MaxVal:" + MaxVal;
					 var TargetURL = "<?php echo Configure::read('base_url'); ?>dns/filterdns/scenario_id:<?php echo $scenario_id; ?>/location_id:<?php echo $location_id; ?>" + "/MinVal:" + MinVal + "/MaxVal:" + MaxVal+"/customer_id:"+customerid;

                                        jQuery.post(TargetURL, function(response) {

                                            $('#ajax_load_ajax').html(response);


                                        });
                                    }
                                }
                            });
						 jQuery("#reset_filter").click(function() {
							
                                jQuery('#rangeMin_overlayMinval').val('');
                                jQuery('#rangeMax_overlayMaxval').val('');
                                //jQuery("#form").submit();
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

                        function submit_odsentries(id) {
                            //var trainindIdArray;
                            if ($('input.selectdnsCheckbox').filter(":checked").length > 0) {
                                $('.filtersForm').attr('action', base_url + 'odsentries/index/scenario_id:<?php echo $scenario_id ?>');
                                $('.filtersForm').attr('method', 'POST');
                                //$('#filters').submit();
								 $('.black_overlay').css('display','block');
	                              $.fancybox.showLoading();
								//checking browser of ajax submit behavoir
								var asyncronation;
								if(browserCheck()=="FIREFOX"){
									 asyncronation = false;
								}
								else{
										asyncronation = true;	
								}
								
                                $.ajax({
                                    type: "POST",
									async : asyncronation,
									 dataType:'text',
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
                                            $('#reloadwholdpagedata').html(data);
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
						//$('#overlay-sucess .ok .message').text("<?php __('Scenario succesfully added') ?>");

						$('.update_message').html(data);
		        		$('#overlay-sucess').removeClass('hide');
                                  }
                                });
                            } else {
                                alert("Please select DNs");
                            }
							 
                        }

                        



		/*######################################### 8 May 2014 ######################################################################*/				

function submit_locationentries(id){
	var dnsids = '';
   var seldnids = '';
   if ($('input.selectdnsCheckbox').filter(":checked").length > 0) {
   jQuery('input.selectdnsCheckbox').each(function() { 
         
		if ($(this).is(':checked')) { 
					
			dn_id = $(this).val();
			
			dnsids += dn_id + '&';
			seldnids += dn_id + ',';
		}
   });
   
  // dnsids = dnsids.replace("on&", "");
   
 $('.black_overlay').css('display', 'block');
	$.fancybox.showLoading()  ;	
var TargetURL = "<?php echo Configure::read('base_url');?>locations/updatedns/";
	$('.black_overlay').css('display','block');
 		jQuery.post( TargetURL, {'location_id':'<?php echo $location_id ?>', 'dnsids':dnsids}, function( data ) {  //alert(data);
window.location.reload();
 //location.reload(false);
	});
	} else {
             //alert('<?php echo  __("Please Select at least one Identifier!", true) ;?>');
             var errorMessage = '<div id="overlay-error3" class="notification first" style="width: 100%"><div class="error">';
             errorMessage += '<div class="message"><?php echo __('Please Select atleast one Identifier!'); ?></div></div></div>';
         			$('.validataionMessage').html(errorMessage);
                     //alert('Please choose at least one Identifier!');
                     return false;
           }		
}
  

/*###########################################################################################################################*/	


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
        $('.countdisplay5').html(showrecord);
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
	
	$(document).ready(function() {
		$('div').on('keyup','#pagenumber', function(e){
			//alert($(this).val());
			//$("input[type='text']").keypress(function(e) {
				//alert(e.which);
				//if (e.which == 13) 
				{
					
					var t = $('#exampleSingle').dataTable();
					var textval = parseInt($(this).val());	
					
					//alert(textval);
					
					t.fnPageChange(textval,true);
					
					$("#pagenumber").val(textval);
					//alert(textval);
				}
			//});
	});
 });


</script>

<?php
/*
 * Css
*/
?>
<style>
.tablesorter-filter
{
        width:100% !important;
		float:left !important;
				
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
	

.selectdnsCheckbox {/*margin-left:24px !important;*/}

.withdatatablecss {
    border-bottom:#D1D1D1 1px solid !important; border-right: 1px solid #D1D1D1 !important;border-top:#D1D1D1 1px solid !important; border-radius:0px !important;	border-left: 1px solid #D1D1D1!important;
}
.tablesorter-filter-row td
{
	border-bottom:#D1D1D1 1px solid !important; border-right: 1px solid #D1D1D1 !important;border-top:#D1D1D1 1px solid !important; border-radius:0px !important;border-left: 1px solid #D1D1D1!important;
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
.tablesorter-bootstrap .tablesorter-header-inner {
    font-size: 11px;
    padding: 0px 10px 4px 1px!important;
    position: relative;
	margin-left:-5px;
}
.tablesorter-filter
{
    width:100% !important;
	margin: 0 -2px !important;
    padding: 4px 1px !important;
	height:26px!important;
}
	
.tablesorter-bootstrap .tablesorter-filter-row td {
background: none repeat scroll 0 0 #EEEEEE;
line-height: normal;
padding: 4px 3px;
text-align: center;
transition: line-height 0.1s ease 0s;
vertical-align: middle;
}
.table th, .table td {
    border-top: 1px solid #DDDDDD;
    line-height: 20px;
    
	padding-left:6px!important;
    text-align: left;
    vertical-align: top;
}	
#example tr td:nth-child(2) input[type="search"]{
    width: 90px !important;
}
#example tr td:nth-child(3) .dataTable select{
    width: 80px !important;
}
#example tr td:nth-child(4) input[type="search"], #example tr td:nth-child(5) input[type="search"] {
    width: 110px !important;
}


div.DataTables_sort_wrapper span{
 background: url("../../images/assets/table-sort-default.gif") no-repeat scroll 3% 80% rgba(0, 0, 0, 0) !important;
    color: #555555;
    margin-top: 0px;
    margin-top:-7px;

}

div.DataTables_sort_wrapper span.ui-icon-triangle-1-s{
 background: url("../../images/assets/table-sort-asc.gif") no-repeat scroll 3% 80% rgba(0, 0, 0, 0) !important;
    color: #555555;
    margin-top:-7px;

}

.dataTable input[type="radio"], .dataTable input[type="checkbox"] {
    line-height: normal;
    margin: 0 0 3px !important;
}

.tablesorter-filter-row78 td {
    background: none repeat scroll 0 0 #eee;
    line-height: normal;
    padding: 4px 6px;
    text-align: center;
    transition: line-height 0.1s ease 0s;
    vertical-align: middle;
}

div.DataTables_sort_wrapper span.ui-icon-triangle-1-n{
background: url("../../images/assets/table-sort-desc.gif") no-repeat scroll 3% 80% rgba(0, 0, 0, 0) !important;
    color: #555555;
    margin-top: -7px;


}

.dataTable select {
    background-color: #ffffff;
    border: 1px solid #cccccc;
    height: 26px;
    width: 100px !important;
}

</style>

<script type="text/javascript">
	function fancyboxclose(){
		setTimeout( function() { $('.fancybox-overlay').trigger('click'); },5);
		 
	}
</script>
<?php $selnumber = Configure :: read('selectnumber');
$chknumber = $selnumber[0];
 ?>
 <input type="hidden" name="chknumber" id="chknumber" value="<?php echo $chknumber; ?>"/>

<form id="form_overlay" class="filtersForm" action="<?php echo Configure::read('base_url'); ?>dns/filterdns/scenario_id:<?php echo $scenario_id; ?>" enctype="multipart/form-data" method="POST" > 

<input type="hidden" id="dnval" name="dnval" value="<?php echo $dnval; ?>" />

    <div class="black_overlay" style="height:100%; width: 650px; display: none;">
        
    </div>
    <?php if (isset($scenario_name)) { ?>
        <h4> <?php echo __('selectDnsToScenario_prefix'); ?><?php echo $scenario_name; ?><?php echo __('selectDnsToScenario_postfix'); ?>
     

      <div class='demonstrations'>           
		   <div style="font-size: 18px !important;"> <a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); return fancyboxclose(); ">X</a></div>		  
	        
			<div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onMouseOver="Tip('<b><?php echo __('selectDnsToScenario_helpTitel') ?></b><br/><?php echo __('selectDnsToScenario_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>				
    		
 	  </div>
     
        </h4> <br/>
             
             
    <?php } else { ?>
        <h4> <?php echo __('Adding number to Location'); ?>   <?php echo $location_name; ?> <?php echo __('dnsMove'); ?> 

   <div class='demonstrations'>           
			   <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); return fancyboxclose(); ">X</a></div>		  
	        
			<div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onMouseOver="Tip('<?php echo __('selectDnsToLocation_helpTitel') ?></b><br/><?php echo __('selectDnsToLocation_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>				
    		
 	  </div>

         </h4>
    <?php } ?>
	
	<?php  $selectedLanguage = $_SESSION['Config']['language'];
						if($selectedLanguage=='de'){
							 $width = 220;
							 $rangeminwidth = 200;
							 $rangemaxwidth = 200;
							 $filterwidth = 243;
							 
							 $dnidtablewidth = 80;
							 $locationtablewidth = 80;
							 $functiontablewidth = 80;
							 $odstablewidth = 80;
							 $trunktablewidth = 80;
							 
							 }
						else if($selectedLanguage=='fr') {
							 $width = 183;
							 $rangeminwidth = 200;
							 $rangemaxwidth = 200;
							 $filterwidth = 213;
							 
							 $dnidtablewidth = 80;
							 $locationtablewidth = 80;
							 $functiontablewidth = 80;
							 $odstablewidth = 80;
							 $trunktablewidth = 80;
							 }
						else if($selectedLanguage=='it'){
							$width = 146;
							 $rangeminwidth = 200;
							 $rangemaxwidth = 200;
							 $filterwidth = 213;
							 
							 $dnidtablewidth = 80;
							 $locationtablewidth = 80;
							 $functiontablewidth = 80;
							 $odstablewidth = 80;
							 $trunktablewidth = 80;
						}
						else if($selectedLanguage=='en'){
							 $width = 146;
							 $rangeminwidth = 200;
							 $rangemaxwidth = 200;
							 $filterwidth = 213;
							 
							 $dnidtablewidth = 80;
							 $locationtablewidth = 80;
							 $functiontablewidth = 80;
							 $odstablewidth = 80;
							 $trunktablewidth = 80;
						}
					
/**
* Start Range Filter
* 
*/		
?>	
    
<div class="validataionMessage"></div>
<div id="shortcontdns" class="scontdns" style="display: block;margin-left: 5px;">    

	
   <div class="form-box" >	
	             									
            <div class="form-left" id="filter_now_overlay" style="float:left;">
                <?php
				
					//$dnsTotalrecord=100;
					
					
					
					if(!empty($dnval)){
						
						$dnsval = $dnval;
						$dnsTotalrecord =$dnval; 
					}else{
						$dnsval = 1000;
						$dnsTotalrecord = $dnsTotalrecord;
					}
						
					
				 
				 if(isset($blockOptions))
					  	{
							
							if($selectedLanguage=='de'){
								$topmargin = 9;
								}else{
									$topmargin = 9;
								}
							?>
						<?php echo __('DN Range Filter'); ?> 
					    <div class="form-box" style="margin-top: <?php echo $topmargin; ?>px;">
 						
							<div class="form-left">
                                <?php echo $form->input('block_id', array('label' => false,'type'=>'select', 'options'=>$blockOptions, 'id' => 'blockSelectSelectDns', 'default'=>$block_id,'style'=>'width:206px; float: left;','onchange'=>"javascript:submitBlockFilterSelectdns();")); ?>
					
                            </div>
							
                            <div style="width:206px" class="form-right">
                               <p><?php echo __('largeDataSet_blurb')?></p>	
                            </div>
 							
 																
 						 </div>	
 						 <?php } # end large dataset?>
            </div>	
      
      		<div class="form-right" id="filter_now_overlay" style="float:left;">
               <p></p>
      		 </div>	
      </div>
      

</div>	
<?php
	/**
	* End Range Filter	
	* 
	*/
?>
<?php 
if($dnsTotalrecord<$dnsval){
	$style = "float: left;margin-left: 5px;";
	
}

?>
	<div class="block top" style="<?php echo $style; ?>">
     
		
        <?php
		
       // echo $form->create('Dns', array('action' => 'selectdns', 'id' => 'filters', 'class' => 'filtersForm', 'type' => 'GET'));
	  
	   if($this->params['named']['location_id']!=""){
	   	 $dnsInfo =  __('selectDns4LocationInfo',true); 	
	   	
	   }
	   if($this->params['named']['scenario_id']!=""){
	   	$dnsInfo =  __('selectDns4ScenarioInfo',true); 	
	   	
	   }
        echo $form->input('Location.customer_id', array('type' => 'hidden', 'value' => $custId));
			
	
		if(($dnsTotalrecord>=$dnsval) && strlen($dnsInfo)>=20 ){
		
			$width = 390;
			$float = right;
			$selectedLanguage = $_SESSION['Config']['language'];
		if($selectedLanguage=='de'){
			$margin1 = -25;
			}else{
			$margin1 = -6;	
			}
			$margin2 = 0;
		}
		else {
			$width = 625;
			$float = right;
			$margin1 = -10;
			$margin2 = -31;
		}
		
		#echo wordwrap($str,15,"<br>\n");	
					
		//$splitat = strpos($dnsInfo," ",strlen($dnsInfo)/2);
		//$splitat = strpos($dnsInfo," ",123);
		//$col1 = substr($dnsInfo, 0, $splitat);
		//$col2 = substr($dnsInfo, $splitat);
		
		       
		$col = str_split($dnsInfo,200)
		
        ?>
				
		<div>
				<div  style="width:<?php echo $width; ?>px; text-align: left;float:left;margin-top:<?php echo $margin1; ?>px;"><?php echo $dnsInfo; ?></div>
				<!--<div  style="width:<?php echo $width; ?>px; text-align: left;float: right;margin-top:<?php echo $margin2 ?>px;"><?php echo $col['1']; ?></div>-->
		</div>
	</div>	
        <div class="cb dnlist">

            <?php
            // check $locations variable exists and is not empty
            if (isset($dns2) && !empty($dns2)) :
                ?>
                <!--Showing Page <?php //echo $paginator->counter();     ?>-->  

                <?php #echo $this->element('pagination/top'); ?>
				<?php echo $javascript->link('/js/jquery.dataTables.min'); ?>
                <div id="loadajax" class="table-content">

                    <input type="hidden" value="<?php echo $location_id ?>">
						
					<br/>
				
				
                    <div id="ajax_load_ajax">
                     
                    <div class="clear"></div>
					
                        <table id="exampleSingle" class="dataTable cust_tab_pag tablesorterdns" style="margin-bottom:15px;">
                            <thead> 	
							
								<tr class="table-top withdatatablecss">
									
										<th><?php//echo __('tableFilter', true);?></th>
										<th style="width:94px"> <input type="text" id="search_filter_dnId" style="width:90% !important;margin-left:2px;float:left;margin-right:4px;" ></th>
										<th style="width:120px">
											<select id="msds-select-new" style="width:93% !important;margin-left:5px;float:left;margin-right:4px;">
											<option></option>
											<?php
												foreach($locationlist as $list){
												?>
												<option value="<?php echo $list; ?>"><?php echo $list; ?></option>
											<?php	
												}
											?>
											
											</select>
										</th>
										
										 <?php if($dispfunc=='2'){     ?>  
										<th  ><select id="msds-select-function_next" style="width:93% !important;margin-left:5px;float:left;margin-right:4px;">
											<option></option>
											<?php
												foreach($functionlist as $list){
												?>
												<option value="<?php echo $list; ?>"><?php echo $list; ?></option>
											<?php	
												}
											?>
										
											</select></th>
										<?php   }   ?>
										
										 <?php 
										   $odsflag=count($scenarioData);											  
											  if($odsflag!=0){     ?>
										<th><input type="text" id="search_filter_ods" style="width:90% !important;margin-left:5px;float:left;margin-right:4px;" ></th>
										  <?php   }   ?>
										  
										<th><input type="text" id="search_filter_trunk" style="width:90% !important;margin-left:5px;float:left;margin-right:4px;" ></th>
										
								</tr>
								
                                <tr class="table-top withdatatablecss">
                                   <!-- <th class="table-column table-left-ohne withdatatablecss">&nbsp;</th>-->
								   <?php if (isset($scenario_name)) { ?>
								  
                                    <th class="table-right-ohne withdatatablecss" style="width: 4%!important;padding-left:1px !important;text-align: left;">
									<input type="checkbox"  name="sAll" id="checkAllDn" style="margin-top: 0px !important;border-left: 1px solid #D1D1D1!important;">
									</th> 
									<?php } else { ?>
									<th class="table-right-ohne withdatatablecss" style="width:4%!important;padding-left:1px !important;text-align: left;"><?php //echo __('Select '); ?><input type="checkbox"  name="sAll" id="checkAllDn" style="margin-top: 0px !important;border-left: 1px solid #D1D1D1!important;"><p style="position: relative;top:<?php echo $top; ?>px;"><?php //echo __('tableFilter'); ?></p></th>
									<?php } ?>
                                    <th style="width:95px!important; text-align: left;" class="table-column withdatatablecss <?php
                                    if (in_array('sort:id', $filter_sort) && in_array('direction:asc', $filter_sort))
                                        echo 'sortlink_asc';elseif ((in_array('sort:id', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                        echo 'sortlink_desc';
                                    else
                                        echo 'sortlink';
                                    ?> ">
                                       <div  style="margin-left:2px">  <?php echo __("dnId", true); ?></div></th>                                   
									
									<th style="width:120px!important; text-align: left;" class="table-column withdatatablecss filter-select filter-exact <?php
                                    if (in_array('sort:location_id', $filter_sort) && in_array('direction:asc', $filter_sort))
                                        echo 'sortlink_asc';elseif ((in_array('sort:location_id', $filter_sort) && in_array('direction:desc', $filter_sort)))     
										echo 'sortlink_desc';
                                    else
                                        echo 'sortlink';
                                    ?> ">
                                         <div  style="margin-left:2px">  <?php echo __("Location", true); ?></div></th>

                                     <?php if($dispfunc=='2'){     ?>     
                                    <th style="width:129px;text-align: left;" class="table-column withdatatablecss filter-select filter-exact <?php
                                    if (in_array('sort:function', $filter_sort) && in_array('direction:asc', $filter_sort))
                                        echo 'sortlink_asc';elseif ((in_array('sort:function', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                        echo 'sortlink_desc';
                                    else
                                        echo 'sortlink';
                                    ?> "> <div  style="margin-left:2px">  <?php echo __("Function", true); ?></div></th>
                                  <?php   }   ?>
                                     <?php 
										   $odsflag=count($scenarioData);											  
											  if($odsflag!=0){     ?>
                                    <th class="table-column withdatatablecss" style="width:110px !important;text-align: left;"> <div>  <?php echo __("ODS", true); ?></div></th>
									  <?php   }   ?>
									  <?php if($cst_type!="Phone"){     ?>     
                                    <th class="table-column withdatatablecss" style="width:150px !important;text-align: left;"> <div  style="margin-left:2px">  <?php echo __("trunk", true); ?></div></th>				                          <?php  }   ?>


                                    <!--<th class="table-right-ohne withdatatablecss" style="width:6% !important;">&nbsp;</th>-->
                                </tr>
								 
                            </thead>
							
							
                            <tbody >
                                
                            </tbody>

                        </table>
						
						<script type="text/javascript">
							
							//$(document).ready(function() {
							
							//});
							
							//alert('dddd');
							
							var dispfunc = "<?php echo $dispfunc; ?>";
							var odsflag = "<?php echo $odsflag; ?>";
							
							populate();
							//alert('dddd');
							function populate()
							{
								//alert('dddd');
								
								//$.fancybox.showLoading();
								//$('.black_overlay_update').show();
								
								console.time('populate');
								//alert('dddd');
								var t = $('#exampleSingle').dataTable({
								
								'bDestroy': true,
									"bInfo": true,
									"bFilter": true,
									"sDom":"lrtip",
									"bProcessing": false,
									"bDeferRender": true,
									"search" : false,
									'iDisplayLength': 10,
									'sPaginationType': 'full_numbers',
									'sDom': '<"top"i> T<"clear">lfrtip',
									'sPageButtonActive': "paginate_active",
									'sPageButtonStaticDisabled': "paginate_button",
									"bAutoWidth": false , 
									"bJQueryUI": true,
										"aoColumnDefs": [
											{ "sWidth": "10%", "aTargets": [ -1 ] }
										],
									
									"oLanguage": {
										"sZeroRecords":"<?php echo __("noMatching"); ?>",
										"sSearch": "Futher Filter Search results:",
										"sInfo": "Got a total of _TOTAL_ results to show (_START_ to _END_)",
										"sLengthMenu": '<div style="float:left"><?php echo __("totalEntries")?>&nbsp;</div> <div id="counter" style="float:left;"></div> '+
										'<div style="float:left;margin-left:5px;"><?php echo __("entriesPerPage"); ?>' +
										'<select style="margin-top:-1px;width:53px;">' +
										'<option value="10">10</option>' +
										'<option value="25">25</option>' +
										'<option value="50">50</option>' +
										'<option value="100">100</option>' +
										'</select></div><br />'
											},
											"bSort": true,
											"aaSorting": [[ 0, "desc" ]],
											"aaSorting": [[ 1, "asc" ]],
									
									'fnDrawCallback': function(oSettings) {
											if ($("#checkAllDn").is(':checked')) {
												$('.selectdnsCheckbox').prop("checked", "checked");												
											}
									},
									"fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
									
										var total = 0;
										 var seldnids = '';
										 var dnIdCount = 0;
										 var breakWordCheck;
										 var dn_id;
										 var functiondropdown = [];
										 
										var selectedval = $('#msds-select').val();
										//alert(selectedval);
										
										for (var i = 0; i < aiDisplay.length; i++) {
											
											
											//functiondropdown += "<option value='"+aaData[aiDisplay[i]][3]+"'>"+aaData[aiDisplay[i]][3]+"</option>";
											
											functiondropdown.push(aaData[aiDisplay[i]][2]);
											
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
											
											//$("#msds-select").html(functionuniquearray);
											//$("#msds-select-function").val("");
										}
										
									},
									"fnInfoCallback": function( oSettings, iStart, iEnd, iMax, iTotal, sPre ) {
									   
										 iPage = oSettings._iDisplayLength === -1 ? 1: Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength );
										
										iTotalPages =  oSettings._iDisplayLength === -1 ?  1 : Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength );
;
									    $('#exampleSingle_paginate span').html(' <?php __('Page'); ?> <input class="GoOnTargetPage12" id="pagenumber" maxlength="maxlength" style="width:25px;text-align:center;float: inherit;" type="text" value="' + (iPage+1) + '" /> <?php echo __('Of') ?> ' + iTotalPages);
									  
									    $('div#counter').html(iTotal);
										//$("#chknumber").val(iTotal);
										
										$("#exampleSingle_first").removeClass("ui-state-default");	
										$("#exampleSingle_previous").removeClass("ui-state-default");	
										
										$("#exampleSingle_next").removeClass("ui-state-default");	
										$("#exampleSingle_last").removeClass("ui-state-default");
										
										if ($("#checkAllDn").is(':checked')) {
											
											//$('.odsentchk').bind('click', function() {  });
											getval = $("#chknumber").val();
											//if(iTotal == getval)
											 //$('.cntdns').text("<?php echo __('dnOfLocationSelected'); ?> : "+ (iTotal));
											
											//$('.cnt').text("<?php echo __('dnOfLocationSelected'); ?>" + (iTotal));
										}
									   
									}
									
								}
								) ;								
								
								
								var jArray = <?php echo $dns3; ?>;
								
								var scenarioDataoutput = <?php echo $scenarioDataoutput; ?>;
								var TrunkDataoutput = <?php echo $TrunkDataoutput; ?>;

								var IDS = "";
								var countlength = "<?php echo count($results ); ?>";
								
								//alert(countlength);
								
								 var seldnids = '';
								 var dnIdCount = 0;
								 var breakWordCheck;
								 var dn_id;
								 var count = 0;
								 var dnsIdsArray = [];
								 
								for (var irow = 0; irow < countlength; irow++)   
								{
									var cells = new Array();
									var dnsid = jArray[irow]['Dns']['id'];
									var functionname = jArray[irow]['Dns']['function'];
									var getId = jArray[irow]['Dns']['id'];	
									
									var insertedDNStyle = "";
									var disableCheckbox = "";
                                    var entryStatus = "Available";
                                    // stripes the table by adding a class to every other row
                                    var class1 = ( (count % 2) ? " class='altrow'" : '' );
                                    // increment count
                                    count++;
									
									if (!jQuery.inArray(dnsid,dnsIdsArray))
									{		
										alert('dddd');
										insertedDNStyle = 'class="insertedDNStyle"';
										disableCheckbox = 'disabled';
										entryStatus = "Added";
									}
									else
									{
										dnsIdsArray.push(dnsid);
									
										cells[0] = '<input onclick="checkallf('+getId+')" style="margin-left:0px" type="checkbox" class="selectdnsCheckbox"  id="chk'+getId+'" name="selectdnsCheckbox[]" value="'+getId+'" />';
										
										if ((functionname != '') && (functionname != 'CFRA') && (functionname != 'UCD') && (functionname != 'INTERNAL'))
										{
											cells[1] = jArray[irow]['Dns']['id'];
                                        }
										
										//locationname = jArray[irow]['Location']['id'];
										
										
										
										cells[2] = jArray[irow]['Location']['name'];
										
										var scenlist1 = jArray[irow][0]['scenlist']+',';
										var str_array = scenlist1.split(',');											
										var linkdata = "";
										var setcounter = 0;
										for(var i = 0; i < str_array.length; i++) {
										   // Trim the excess whitespace.
										   
										   //alert(str_array[i]);
										   if(str_array[i] == '' || str_array[i] == 'null') continue;
										   
											setcounter = 1;
											linkName = scenarioDataoutput[str_array[i]];
											linkdata += "<li style='list-style:none; line-height:14px'>"+linkName+"</li>";										  
										}									
										//cells[3] = (linkdata == "") ? linkdata : functionname ;
										//alert(str_array.length);
										
										var trunklist1 = jArray[irow][0]['trunklist']+',';	
										//alert(trunklist1);
										var str_array = trunklist1.split(',');
										var linkdata_trunk = "";
										for(var i = 0; i < str_array.length; i++) {
										   // Trim the excess whitespace.
										   if(str_array[i] == '' || str_array[i] == 'null') continue;
											linkName = TrunkDataoutput[str_array[i]];
											if (linkName == null && linkName == undefined) {  continue;}
											
											linkdata_trunk += "<li style='list-style:none; line-height:14px'>"+linkName+"</li>";	
											//linkdata_trunk += linkName+"; ";										  
										}
										
										
										//alert(setcounter);
										
										var index = 3;
										if(dispfunc == 2){
											cells[index] = functionname;
											index++;
											//alert('dddd');
										}
										
										if(odsflag != 0){
											//alert('dddd');
											cells[index] = linkdata;
											index++;
										}
										
										
										
										
										cells[index] = linkdata_trunk;
																			
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
							
							$(document).ready(function() {
							  
							  
							  $.fn.dataTableExt.oApi.fnGetFilteredNodes = function ( oSettings )
								{
										var anRows = [];
										for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
										{
												var nRow = oSettings.aoData[ oSettings.aiDisplay[i] ].nTr;
												anRows.push( nRow );
										}
										return anRows;
								};
			
							  var oTable;
							  oTable = $('#exampleSingle').dataTable();
							   
							   $('#msds-select-new').change( function() { 									
									//alert('ffff');
									oTable.fnFilter( $(this).val(),2); 
									
									//checkboxall();
									
									//$("div a.cnt").text("Hello");
									oTable.fnDraw();
							   });
							   $('#msds-select-function_next').change( function() { 									
									oTable.fnFilter( $(this).val(),3); 
									
									//checkboxall();
									
									//$("div a.cnt").text("Hello");
									oTable.fnDraw();
							   });
							    $('#msds-select-function').change( function() { 									
									oTable.fnFilter( $(this).val(),3); 
									
									//checkboxall();
									oTable.fnDraw();
							   });
							   
							   $('#search_filter_dnId').keyup( function() { 									
									
									//alert($(this).val());
									oTable.fnFilter( $(this).val(),1); 
									//checkboxall();
									oTable.fnDraw();
							   });
							   
							   $('#search_filter_ods').keyup( function() { 									
									
									//alert($(this).val());
									oTable.fnFilter( $(this).val(),3); 
									//checkboxall();
									oTable.fnDraw();
							   });
							   
							   $('#search_filter_trunk').keyup( function() { 									
									
									//alert($(this).val());
									oTable.fnFilter( $(this).val(),4); 
									//checkboxall();
									oTable.fnDraw();
							   });
						   });
							
							$("#exampleSingle_filter").hide();
							
							$("#exampleSingle_first").text("<<");	
							$("#exampleSingle_previous").text(" <");	
							
							$("#exampleSingle_next").text(" >");	
							$("#exampleSingle_last").text(" >>");
							
					</script>
						<br>
						<div style="margin-left:3px; margin-top:0px; display: inline" class="cntdns">0: records are selected </div>
                    
                   
                        <?php if (isset($location_id)) { ?>
                           <div class="button-right" id="updatedns" style="margin-right: 19px;margin-top: 0px;">
                                <a id="dnsbutton" href="javascript:void(0);"   onclick="javascript:submit_locationentries('filters');" name="submitForm" value="submitForm" ><?php echo __('dnsSubmit'); ?></a>
                            </div>
							
							
                        <?php } else { ?>
                           <div class="button-right" id="updatedns" style="margin-right: 19px;margin-top:3px;">
                                <a id="dnsbutton" href="javascript:void(0);"  onclick="javascript:submit_odsentries('filters');" name="submitForm" value="submitForm" ><?php __("dnsSubmit"); ?></a>
                            </div>
                        <?php } ?>
                  </div>
                  </div>
                    <?php //echo $form->end(); ?>
                    <?php //echo $this->element('pagination/newpaging');   ?>
               
            </div>

            <?php
        else:
            __("No Dns available in DB");
            echo '</div>';
        endif;
        ?>

       
        <!--right hand side starts from here-->
      
</form>


