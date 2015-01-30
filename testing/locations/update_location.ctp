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


    /* ### Change Pagination style Script ###*/

    $(document).ready(function() {

        paginationStyle();
        $('.pager a').click(function() {
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
                1: {sorter: false, filter: false},
                6: {sorter: false, filter: false}

            }

        })
                .tablesorterPager({
                    // target the pager markup - see the HTML block below
                    container: jQuery(".pager"),
                    // target the pager page select dropdown - choose a page
                    cssGoto: ".pagenum",
                    // remove rows from the table to speed up the sort of large tables.
                    // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
                    removeRows: false,
                    // output string - default is '{page}/{totalPages}';
                    // possible variables: {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
                   // output: '{startRow} - {endRow} [{page}] {filteredRows} ({totalRows})'
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
                                //alert("kk");
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
                            });

                            jQuery('.odsentchk').click(function() {
                                var noofrecord = 0;
                                jQuery('input[type="checkbox"]').each(function() {
                                    if ($(this).is(':checked')) {
                                        noofrecord++;
                                    }
                                });

                                $('.cnt').text(noofrecord + ": <?php echo __('dnOfLocationSelected'); ?>");
								if(noofrecord==0){
								$('.updcnt').hide();	
								}else{
									$('.updcnt').show();
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
                                    jQuery('#content input[type="checkbox"]').each(function() {
                                        var CClass = jQuery(this).parents("tr").attr('style');
                                        if (CClass.indexOf("display: none") == -1) {
                                            var attrid = jQuery(this).attr('id');
                                            jQuery('#' + attrid).prop("checked", "checked");
                                            noofrecord++;
											$('.cnt').text(noofrecord - 1 + ": <?php echo __('dnOfLocationSelected'); ?>");	
																					
											$('.updcnt').show();
                                        }
                                    });

                                    $('.cnt').text(noofrecord - 1 + ": <?php echo __('dnOfLocationSelected'); ?>");

                                } else {
                                    jQuery('input[type="checkbox"]').each(function() {
                                        jQuery(this).removeAttr("checked");
                                    });
                                    //$('.cnt').text("0" + ": <?php echo __('dnOfLocationSelected'); ?>");
									$('.cnt').text("");
								    $('.updcnt').hide();
                                }
                            });





                            jQuery('.dosorting').click(function() {
                                jQuery('input[type="checkbox"]').each(function() {
                                    jQuery(this).removeAttr("checked");
                                });
                            });

                        });

                        function saveToLog(action) {
                            var comment = $('#LogAfterdate').val();
                            var scenario_id = '<?php echo $scenario_id; ?>';
                            var cust_id = '<?php echo $SELECTED_CUSTOMER; ?>';
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

</script>

<style>
    .tablesorter-filter
    {
        width:80% !important;
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
        width:20% !important;
    }
    #example colgroup col:nth-child(4)
    {
        width:20% !important;
    }


</style>
            <div style="display: inline;font-weight:bold;margin-left:5px;" class="cnt" > <?php #echo __('dnOfLocationSelected'); ?> </div>
			<div class="pager form-horizontal" >                 
               <?php echo __("totalEntries")?><span class="countdisplay"></span><?php echo __("entriesPerPage"); ?>: 
                    <select class="pagesize input-mini" title="Select page size" style="float: right; margin-right: 290px;">
                        <option selected="selected" value="10">10</option>
                        <option selected="selected" value="25">25</option>
                        <option selected="selected" value="50">50</option>
                        <option selected="selected" value="100">100</option>                       
                    </select>
            </div>                 

<table id="example dnslistdata" class="dataTable phonekey" cellpadding="0" cellspacing="0" style="width:98%; margin-left:5px; border-top-color:#CCC">
    <thead>
        <tr class="table-top" style="border-bottom:#CCCCCC 1px solid; border-right: 1px solid #CCCCCC;border-top:#CCCCCC 1px solid;">
            <th width="3%" class="table-column table-left-ohne withdatatablecss" >&nbsp;</th>
            <th width="15%" class="table-column table-right-ohne  withdatatablecss"><input type="checkbox" name="sAll" id="checkAll" class="showselect"></th>
            <th width="11%" class="table-column dosorting withdatatablecss" >&nbsp;&nbsp;ID&nbsp;&nbsp;</th>

            <th width="27%" class="table-column filter-select filter-parsed  dosorting withdatatablecss" data-placeholder="Location">
                &nbsp;&nbsp;Location&nbsp;&nbsp;
            </th>

            <th width="24%" class="table-column filter-select filter-exact dosorting withdatatablecss" data-placeholder="Function">
                &nbsp;&nbsp;Function&nbsp;&nbsp;
            </th>
            <th width="17%" class="table-column filter-select filter-exact dosorting withdatatablecss" data-placeholder="State">
                &nbsp;&nbsp;State&nbsp;&nbsp;
            </th>
                            <!--<th width="15%" class="table-column table-right-ohne  withdatatablecss"><input type="checkbox" name="sAll" id="checkAll" class="showselect"></th>-->
            <th width="3%" class="table-right-ohne" style="border-bottom:#CCCCCC 1px solid; border-top:#CCCCCC 1px solid;border-radius:0px !important;">&nbsp;</th>
        </tr>
    </thead>
    <tfoot>
    <th colspan="8" class="pager form-horizontal">
        <span><a class="first" href="javascript:;">&lt;&lt;</a></span>
        <span><a class="prev" href="javascript:;">&lt;</a></span>
        <span>Page</span>
        <select class="pagenum input-mini hide" title="Select page number"></select>
        <span class="pagedisplay"></span> <!-- this can be any element, including an input -->			
        <span><a class="next" href="javascript:;">&gt; </a></span>
        <span><a class="last" href="javascript:;">&gt;&gt; </a></span>
<!--        <button type="button" class="btn first"><i class="icon-step-backward"></i></button>
<button type="button" class="btn prev"><i class="icon-arrow-left"></i></button>
<span class="pagedisplay"></span>  this can be any element, including an input 
<button type="button" class="btn next"><i class="icon-arrow-right"></i></button>
<button type="button" class="btn last"><i class="icon-step-forward"></i></button>
<select class="pagesize input-mini" title="Select page size">
<option selected="selected" value="10">10</option>
<option value="5">5</option>
<option value="10">10</option>
<option value="20">20</option>
</select>
<select class="pagenum input-mini" title="Select page number"></select>-->
    </th>
</tr>
</tfoot>
<tbody>
<?php
//echo $this->element('sql_dump');

 if(isset($success)){	$msg = $success;$val="1"; } 
elseif(isset($error)) {
	$msg = $error;$val="0"; 
}
?>
<input type="hidden" name="sval" id="sval" value="<?php echo $val; ?>,<?php echo $msg ?>" class="sucess">



    <?php
    $i = 0;
	

    foreach ($dnsdetail as $res) {
        ?>

        <tr style="background-color:#FFF; border-bottom:#CCCCCC 1px solid; border-right: 1px solid #CCCCCC;">
            <td style="background-color:#FFF; border-bottom:#CCCCCC 1px solid;  border-right: 1px solid #CCCCCC;" class="table-left" id="firstchild<?php echo $res['Odsentry']['id']; ?>">&nbsp;</td>
            <td style="background-color:#FFF; border-bottom:#CCCCCC 1px solid; border-right: 1px solid #CCCCCC; " class="table-right-ohne" align="center" > <input type="checkbox" class="odsentchk"  value="<?php echo $res['Dns']['id']; ?>" id="chk<?php echo $res['Dns']['id']; ?>" style="margin-left:25px;"/> </td>
            <td style="background-color:#FFF; border-bottom:#CCCCCC 1px solid;  border-right: 1px solid #CCCCCC;"><?php echo $res['Dns']['id']; ?></td>
            <td style="background-color:#FFF;border-bottom:#CCCCCC 1px solid;  border-right: 1px solid #CCCCCC;" id="lkname_<?php echo $res['Dns']['id']; ?>">

                <?php echo $html->link(__($res['Location']['name'], true), array('controller' => 'locations', 'action' => 'create_location/customer_id:' . $selected_customer . '/dns_id:' . $res['Dns']['id'] . '/location_id:' . $res['Location']['id'] . '/loc_id:' . $location_id), array('class' => "fancybox fancybox.ajax", 'id' => '')); ?>

                <?php //echo $res['Location']['name'];  ?>
                <input type="hidden" name="lokname_<?php echo $res['Dns']['id']; ?>" id="lokname_<?php echo $res['Dns']['id']; ?>" value="<?php echo $res['Location']['name']; ?>" />
                <input type="hidden" name="dnid_<?php echo $res['Dns']['id']; ?>" id="dnid_<?php echo $res['Dns']['id']; ?>" value="<?php echo $res['Dns']['name']; ?>" />
            </td> 

            <td style="background-color:#FFF; border-bottom:#CCCCCC 1px solid;  border-right: 1px solid #CCCCCC;"><?php echo $res['Dns']['function']; ?>

            </td>
            <td style="background-color:#FFF;border-bottom:#CCCCCC 1px solid;  border-right: 1px solid #CCCCCC;"><div class="status<?php echo $res['Dns']['id']; ?>"> <?php echo $dnsStatus[$res['Dns']['status']]; ?></div></td>

            <!-- <td style="background-color:#FFF; border-bottom:#CCCCCC 1px solid; border-right: 1px solid #CCCCCC; " class="table-right-ohne" align="center" > <input type="checkbox" class="odsentchk"  value="<?php echo $res['Dns']['id']; ?>" id="chk<?php echo $res['Dns']['id']; ?>" style="margin-left:25px;"/> </td>-->
            <td style="background-color:#FFF;  border-bottom:#CCCCCC 1px solid;" align="center" >&nbsp;</td>
        </tr>
        <?php
        $i++;
    }
    ?>
</tbody>

</table>