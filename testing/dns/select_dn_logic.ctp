<script type="text/javascript">

function changebutton(){	
	//alert('test');
	$('#dnsbutton').attr("class", "showhighlight_buttonleft");
	$('#updatedns').removeAttr("class");
	$('#updatedns').attr("class", "button-right-hover");
	$('#dnsbutton2').attr("class", "showhighlight_buttonleft");
	$('#updatedns2').removeAttr("class");
	$('#updatedns2').attr("class", "button-right-hover");
}

jQuery(document).ready(function() {
    $('.selectdnsCheckbox').click(function() {
        var p = $(this).val();
		
		alert(p);
		
        jQuery('input[type="radio"]').each(function() {
            if ($(this).val() == p)
            {
                $(this).prop('checked', true);				
            }
            else {
                $(this).prop('checked', false);
            }
					$('#dnsbutton').attr("class", "showhighlight_buttonleft");
					$('#updatedns').removeAttr("class");
                    $('#updatedns').attr("class", "button-right-hover");
					$('#dnsbutton2').attr("class", "showhighlight_buttonleft");
					$('#updatedns2').removeAttr("class");
                    $('#updatedns2').attr("class", "button-right-hover");
        });
    });
});
    var dnid = '<?php echo $referred_from; ?>';
    jQuery(document).ready(function() {
        /** code to select all filteres records : start **/
        $('.reset').click(function() {
            var checkboxes = $(this).closest('form').find(':radio');
            checkboxes.removeAttr('checked');
        });
        /** code to select all filteres records : ends **/
        $('#removeChecked').on("click", function() {
            var count = 0;
            $('form input[type="search"]').each(function() {
                if ($(this).val() != "") {
                    count++;
                }
            });
            if (count > 0) {
                var checkboxes = $("table.dataTable tr:visible").find(':radio');
                checkboxes.removeAttr('checked');
            }
        });

        $('.selectdnsCheckbox').click(function() {
            var checkboxes = $(this).closest('form').find(':radio:checked');
            //checkboxes.removeAttr('checked');
            //$(this).attr('checked', 'checked');
        });
    });

    /* function to create group*/
    function create_group() {
        var numCheckedCheckbox = 0;
        var identifier = 0;
        jQuery('input[type="radio"]').each(function() {
            if ($(this).is(':checked')) {
                numCheckedCheckbox++;
                identifier = $(this).val();
				locname = $("#locid"+identifier).val();
				
            }
        });

        if (numCheckedCheckbox == 0) {
            alert('Please choose at least one Identifier!');
            return false;
        }

        if (numCheckedCheckbox > 1) {
            alert('Please choose only one Identifier!');
            return false;
        }

        var customer_id = jQuery('#GroupGroupcustomerId').val();
        var grouptype = jQuery('#GroupGrouptype').val();

        var TargetURL = "<?php echo Configure::read('base_url'); ?>groups/add_group/";
        jQuery.post(TargetURL, {'customer_id': customer_id, 'identifier': identifier, 'grouptype': grouptype}, function(data) {
			
			$("#locationName").val(locname);
			var path = trim(data +"&location_id="+locname+"&memcount=0");			
			var TargetURL2 = "<?php echo Configure::read('base_url'); ?>stations/selectstation/group_id:"+path;
			
			$("#select_station").attr('href',TargetURL2);
			// $(".fancybox").trigger("click");
		    $("#select_station").trigger("click");
			 
			
           // window.location.href = TargetURL2;
        });


    }
    /* End function to create group*/

    function submit_dn() {
		 
		
        var checkboxes = $('form').find(':radio:checked');
        DN_id = checkboxes.val();
        $('.filtersForm').attr('action', base_url + 'stations/addDN/' + DN_id + '&station_id=' +<?php echo $station_id ?>);
	    $('.black_overlay').css('display', 'block');
		 $.fancybox.showLoading()  ;

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
            url: $('.filtersForm').attr('action'),
            data: $('.filtersForm').serialize(),
            success: function(result){
          	  location.href =  location.href;
            }
        });
    }
    function create_station() {

        var checkboxes = $('form').find(':radio:checked');
        DN_id = checkboxes.val();
        $('.filtersForm').attr('action', base_url + 'stations/create/port_id:<?php echo $portId; ?>/station_id:' + DN_id);
        $('.black_overlay').css('display', 'block');
        //alert("kk");
        //setTimeout(function(){
        $.ajax({
            type: "POST",
            async: false,
            dataType: 'html',
            url: $('.filtersForm').attr('action'),
            data: $('.filtersForm').serialize(),
            success: function(data) {
                if (data) {
                    /* DN_id = '02@'+DN_id; //alert(DN_id);
                     var emptyTdCount = 1; 	var flag ="";	
                     jQuery('.black_overlay').removeAttr('style');
                     jQuery('.black_overlay').attr("style","display:none");
                     //  alert("DN Added Successfully!");
                     jQuery('.fancybox-close').click();
                     */

                    window.location.href = base_url + "stations/editstation/" + data;
                    return false;
                } else {
                    alert("Some error occurred, Try again!");
                    jQuery('.black_overlay').removeAttr('style');
                    jQuery('.black_overlay').attr("style", "display:none");
                }
            }
        });
        //},0);
        setTimeout(function() {
            $('.fancybox-overlay').trigger('click');
        }, 200);

        //window.location.reload();
        return false;

    }


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

        $('.slectdnscountdisplay').html(showrecord);
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
            odd: '', // even row zebra striping
            emptyTo: 'none',
            link: '<a href="#">{page}</a>',
            sPaginationType: "full_numbers",
            sDom: "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
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
				4: {sorter: false, filter: false},
                7: {sorter: false, filter: false}

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
                    //output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'
					output: '{startRow} - {endRow} / {filteredRows} ({totalRows})',
                    pagerUpdate:function(totPages,currPage)
                    {
                        paginationStyle(totPages,currPage);
                    }
                });
				*/

    });
</script>
<script>
	function fancyboxclose(){
		//window.location.reload();
		 setTimeout( function() {     
			$('.fancybox-overlay').trigger('click');
		 },5);
	}
	

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

<style>
	.fancybox-inner{
	 height: auto !important;
    overflow: auto;
    width: 350px !important;
}
.table-menu-popup li a, .table-menu-popup li a:link, .table-menu-popup li a:visited, .table-menu-popup li a:active {
    border-left: 0px solid #001155!important;
    border-right: 0px solid #001155!important;
    border-top: 0px solid #001155!important;
    padding: 2px 0 0 25px;
}
.table-menu-popup ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    width: 87px!important;
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
    
	padding-left:3px!important;
    text-align: left;
    vertical-align: top;
}


div.DataTables_sort_wrapper span{
 background: url("../../images/assets/table-sort-default.gif") no-repeat scroll 3% 80% rgba(0, 0, 0, 0) !important;
    color: #555555;
    margin-top: 0px;

}

div.DataTables_sort_wrapper span.ui-icon-triangle-1-s{
 background: url("../../images/assets/table-sort-asc.gif") no-repeat scroll 3% 80% rgba(0, 0, 0, 0) !important;
    color: #555555;
    margin-top: 0px;

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
    margin-top: 0px;


}

.dataTable select {
    background-color: #ffffff;
    border: 1px solid #cccccc;
    height: 26px;
    width: 100px !important;
}
</style>



<div class="block top">
 
   <?php
    echo $form->create('Station', array('action' => 'select_station', 'id' => 'filters', 'class' => 'filtersForm', 'type' => 'GET'));
    echo $form->input('Station.customer_id', array('type' => 'hidden', 'value' => $custId));
    ?>
   <h4> <?php 
   		if ($grouptype == 'madn') {
		
			echo __("selectDnMadnGroup");
   		}
		elseif (($grouptype == 'mlh') || ($grouptype == 'dlh')) {
		
			echo __("selectDnXlhGroup");
   		}else {
        	echo __('Select DN', true);
    	} ?>
     
	<div class='demonstrations'>
           <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); return fancyboxclose(); ">X</a></div>
		   
		   <?php if(isset($page)&&$page=="editstation"){   ?>
		   
		   
		   <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onclick="Tip('<b><?php echo __('addDn_helpTitle') ?></b><br/><?php echo __('addDn_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>
		   
		   <?php  }
		   		  else
		   		  { 
		   			if(isset($page)&&$page=="groupindex")
					{    
						if ($grouptype == 'madn') 
						{?>
		    				<div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onclick="Tip('<b><?php echo __('selectDnMadn _helpTitle') ?></b><br/><?php echo __('selectDnMadn _helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>
		   
							<?php 
						}
						elseif (($grouptype == 'dlh') || ($grouptype == 'mlh'))
						{?>
								    <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onclick="Tip('<b><?php echo __('selectDnXlh _helpTitle') ?></b><br/><?php echo __('selectDnXlh _helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>
								   
									<?php 
						}
						
					}
					else
					{    	
			
			if ($grouptype == 'madn') 
						{?>
			
			 				<div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onclick="Tip('<b><?php echo __('selectDnMadnGroup_helpTitel') ?></b><br/><?php echo __('selectDnMadnGroup_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>
						<?php 
						}
						elseif (($grouptype == 'dlh') || ($grouptype == 'mlh'))
						{?>
							<div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onclick="Tip('<b><?php echo __('selectDnXlhGroup_helpTitel') ?></b><br/><?php echo __('selectDnXlhGroup_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>
						
							<?php 
						}
					
					}  
				}?>
    		
    </div>
	
</h4>

    
    
    
    <div class="cb">
        <div class="block" style="margin: 0px;">
            <!--<div class="button-right">-->
                                    <?php
                    if (isset($portId)) {
                        ?>
                        <div class="button-right-disabled" id="updatedns">
                            <a id="dnsbutton" href="javascript:;"  onclick="javascript:create_station();" name="submitForm" value="submitForm" ><?php __("Submit"); ?></a>
                        </div>
                        <?php
                    } else {

                        if (isset($grouptype) && $grouptype != '') {
                            $Onclickevent = "javascript:create_group();";
                            $hrefevent = "javascript:void(0);";

                            echo $form->input('Group.groupcustomer_id', array('label' => false, 'value' => $groupcustomer_id, 'type' => 'hidden'));
                            echo $form->input('Group.grouptype', array('label' => false, 'value' => $grouptype, 'type' => 'hidden'));
                        } else {
                            $Onclickevent = "javascript:submit_dn();";
                            #$hrefevent = "javascript:submit_dn();";
                            $hrefevent = "javascript:void(0);";
                        }
						
                        ?>

                       <!-- <div class="button-right-disabled" id="updatedns2">
                            <a id="dnsbutton2" href="<?php echo $hrefevent; ?>"  onclick="<?php echo $Onclickevent; ?>" name="submitForm" value="submitForm"  ><?php __("Submit"); ?></a>
                        </div>-->
                    <?php } ?>
                    
             <!-- </div>-->

            <div class="button-left">
                <?php //echo $html->link(__("reset", true), 'javascript:void(0);', array('onmouseover' => 'javascript:hoverButtonLeft(this);', 'onmouseout' => 'javascript:outButtonLeft(this);', 'class' => 'reset')); ?>
            </div>

        </div>

        <?php
        // check $locations variable exists and is not empty
        if (isset($dns2) && !empty($dns2)) :
            ?>
            <!--Showing Page <?php //echo $paginator->counter();    ?>-->  

            <?php //echo $this->element('pagination/top'); ?>
            <div id="" class="table-content">
			
			<?php  
			$buttonText = __("Submit",true);
			//selectDnMadnGroupInfo
			if(isset($page)&&$page=="editstation")
			{
			echo $dnsInfo =  __("addDn_blurb",true); 
			$buttonText = __("Submit",true);
		
			}
			else if(isset($page)&&$page=="groupindex"){
				
				
				if ($grouptype == 'madn')
				{
							echo $dnsInfo =  __("selectDnMadnGroupInfo",true); 
							$buttonText = __("selectFreeDn",true);
				}
				elseif (($grouptype == 'dlh') || ($grouptype == 'mlh'))
				{
							echo $dnsInfo =  __("selectDnXlhGroupInfo",true); 
							$buttonText = __("selectFreeDn",true);
				}

			}
			
			
			
			//echo $dnsInfo =  __("selectDnMadnGroupInfo",true);
					
		if(strlen($dnsInfo)>21){ 				
			$width = 645;
			$float = right;
		}
		else {
			$width = 300;
			$float = right;
		}
		#echo wordwrap($str,15,"<br>\n");				
		$splitat = strpos($dnsInfo," ",strlen($dnsInfo)/2);
		$col1 = substr($dnsInfo, 0, $splitat);
		$col2 = substr($dnsInfo, $splitat);
		
		
        ?>
			
		<!--<div>
				<div  style="width:170px; text-align: left;float:left;margin-top:-16px;"><?php //echo $col1; ?></div>
				<div  style="width:170px; text-align: left;float: right;margin-top:0px;"><?php //echo $col2; ?></div>
				
				
				
		</div>	-->
			
			
			
			<!--
			
             <div class="pager form-horizontal" style="margin:0 !important; float:left;height: 29px;margin-left: -3px!important;" >
               <?php //echo __("totalEntries")?> <span class="slectdnscountdisplay"></span> <?php //echo __("entriesPerPage"); ?>: 
                    <select class="pagesize input-mini" title="Select page size">
                        <option selected="selected" value="10">10</option>
                        <option selected="selected" value="25">25</option>
                        <option selected="selected" value="50">50</option>
                        <option selected="selected" value="100">100</option>
                    </select>
                </div>
			-->
					
				
				
                <table id="exampleSingle" class="cust_tab_pag phonekey dataTable">
                    <thead> 	
					
						<tr class="tablesorter-filter-row78">
									
										<td><div style="width:50px">&nbsp;</div></td>
										<td><input type="text" id="search_filter" ></td>
										
										
										<td>
											<select id="msds-select" style="height:26px !important;">
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
										
						</tr>
					
                        <tr class="table-top">
                            <!--<th class="table-column table-left-ohne">&nbsp;</th>-->

                            <?php if (isset($ports) && !empty($ports)) { ?>
                                <!--<th class="table-column filter-false">&nbsp;</th>--> 	
                                <th class="table-column <?php
                                if (in_array('sort:id', $filter_sort) && in_array('direction:asc', $filter_sort))
                                    echo 'sortlink_asc';elseif ((in_array('sort:id', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                    echo 'sortlink_desc';
                                else
                                    echo 'sortlink';
                                ?> "style="width:102px;text-align: left;">
                                    <?php echo __("Port Id", true); ?></th>

                                <th class="table-column <?php
                                if (in_array('sort:mediatrix_id', $filter_sort) && in_array('direction:asc', $filter_sort))
                                    echo 'sortlink_asc';elseif ((in_array('sort:mediatrix_id', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                    echo 'sortlink_desc';
                                else
                                    echo 'sortlink';
                                ?> "style="width:102px;text-align: left;">
                                    <?php echo __("Mediatrix Id", true); ?></th>

                                <th class="table-column <?php
                                if (in_array('sort:station_id', $filter_sort) && in_array('direction:asc', $filter_sort))
                                    echo 'sortlink_asc';elseif ((in_array('sort:station_id', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                    echo 'sortlink_desc';
                                else
                                    echo 'sortlink';
                                ?> "style="width:102px;text-align: left;">
                                    <?php echo __("Station Id", true); ?></th>

                                <th class="table-column filter-select filter-exact" style="width:102px;text-align: left;">
                                    <?php echo __("Phone Type", true); ?></th>

                                <th class="table-column filter-select filter-exact" style="width:102px;text-align: left;">
                                    <?php echo __("Port Type", true); ?></th>

                            <?php } else { ?>
                                <th class=""><?php
                                    // echo $html->link( __("+", true),'javascript:void(0);',array('id'=>'addChecked','class'=>'addChecked'));
                                    // echo $html->link( __("-", true),'javascript:void(0);',array('id'=>'removeChecked','class'=>'removeChecked'));
                                    ?></th> 
                                <th class="table-column <?php
                                if (in_array('sort:id', $filter_sort) && in_array('direction:asc', $filter_sort))
                                    echo 'sortlink_asc';elseif ((in_array('sort:id', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                    echo 'sortlink_desc';
                                else
                                    echo 'sortlink';
                                ?> "style="width:80px;text-align: left;">
                                    <?php echo __("dnId", true); ?></th>
                                   <!-- data-value="<?php #echo $dnsLocationName; ?>"-->

                                <th  class="table-column filter-select filter-exact <?php
                                if (in_array('sort:location_id', $filter_sort) && in_array('direction:asc', $filter_sort))
                                    echo 'sortlink_asc';elseif ((in_array('sort:location_id', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                    echo 'sortlink_desc';
                                else
                                    echo 'sortlink';
                                ?> "style="width:102px;text-align: left;" data-value="<?php echo $prelocation;  ?>" ><?php echo __("Location", true); ?></th>	    	

                                <!--<th class="table-column <?php
                                if (in_array('sort:function', $filter_sort) && in_array('direction:asc', $filter_sort))
                                    echo 'sortlink_asc';elseif ((in_array('sort:function', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                    echo 'sortlink_desc';
                                else
                                    echo 'sortlink';
                                ?> "style="width:102px;text-align: left;"><?php echo __("Function", true); ?></th>

                                <th class="table-column <?php
                                if (in_array('sort:display', $filter_sort) && in_array('direction:asc', $filter_sort))
                                    echo 'sortlink_asc';elseif ((in_array('sort:display', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                    echo 'sortlink_desc';
                                else
                                    echo 'sortlink';
                                ?> "style="width:102px;text-align: left;"><?php echo __("DISPLAYNAME", true); ?></th>

                                <th class="table-column <?php
                                if (in_array('sort:emer', $filter_sort) && in_array('direction:asc', $filter_sort))
                                    echo 'sortlink_asc';elseif ((in_array('sort:emer', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                    echo 'sortlink_desc';
                                else
                                    echo 'sortlink';
                                ?> "style="width:102px;text-align: left;"><?php echo __("Emergency", true); ?></th>-->

                            <?php } ?>
                            <!--<th class="table-right-ohne">&nbsp;</th>--> 
                        </tr>
                    </thead>
                    
                    <tbody>
    				
                    </tbody>

                </table>
				
				<script>
							
							//$(document).ready(function() {
							
							//});
							
							
							
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
										"sLengthMenu": '<div style="float:left"><?php echo __("totalEntries")?> : &nbsp;<div id="counter" style="width:20px;float:right;"></div> </div> <div style="float:left"><?php echo __("entriesPerPage"); ?> :  <select style="margin-top:-1px;">' +
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
											
											$("#msds-select").html(functionuniquearray);
											//$("#msds-select-function").val("");
										}
										
									},
									"fnInfoCallback": function( oSettings, iStart, iEnd, iMax, iTotal, sPre ) {
									   
										 iPage = oSettings._iDisplayLength === -1 ? 1: Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength );
										
										iTotalPages =  oSettings._iDisplayLength === -1 ?  1 : Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength );
;
									    $('#exampleSingle_paginate span').html(' Page <input class="GoOnTargetPage12" id="pagenumber" maxlength="maxlength" style="width:25px;text-align:center;float: inherit;" type="text" value="' + (iPage+1) + '" /> of ' + iTotalPages);
									  
									    $('div#counter').html(iTotal);
										$("#chknumber").val(iTotal);
										
										$("#exampleSingle_first").removeClass("ui-state-default");	
										$("#exampleSingle_previous").removeClass("ui-state-default");	
										
										$("#exampleSingle_next").removeClass("ui-state-default");	
										$("#exampleSingle_last").removeClass("ui-state-default");
									   
									}
									
								}
								) ;								
								
								
								var jArray = <?php echo $dns3; ?>;
								var IDS = "";
								var countlength = "<?php echo count($results ); ?>";
								
								//alert(countlength);
								
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
									functionname = jArray[irow]['Dns']['function'];
									
									
									if ((functionname != '') && (functionname != 'CFRA') && (functionname != 'UCD') && (functionname != 'INTERNAL'))
									{
									
										cells[0] = '<input onclick="changebutton()" style="margin-left:13px;" type="radio" align="left" id="chk'+getId+'" value="'+getId+'" name="selectdnsCheckbox[]" class="selectdnsCheckbox '+getId+'">';
									
										locationid = jArray[irow]['Location']['id'];
										
										cells[1] = jArray[irow]['Dns']['id'];
										
										cells[2] = jArray[irow]['Location']['name'];
										
										cells[3] = jArray[irow]['Location']['function'];
										
										cells[4] = jArray[irow]['Location']['display'];
										
										cells[5] = jArray[irow]['Location']['emer'];
										
									}
									
									else
									{
										cells[0] = '<input onclick="changebutton()" type="radio" align="left" id="chk'+getId+'" value="'+getId+'" name="selectdnsCheckbox[]" class="selectdnsCheckbox '+getId+'">';
										
									
										cells[1] = jArray[irow]['Dns']['id'];
										
										locationid = jArray[irow]['Location']['id'];
										
										cells[2] = jArray[irow]['Location']['name'];
										
										//alert(cells);
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
									
									//alert($(this).val());
									oTable.fnFilter( $(this).val(),1); 
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
				
                <div class="block" style="margin-top: 30px;">
                    <?php
                    if (isset($portId)) {
                        ?>
                        <div class="button-right" id="updatedns">
                            <a id="dnsbutton" href="javascript:;"  onclick="javascript:create_station();" name="submitForm" value="submitForm"  ><?php __("Submit"); ?></a>
                        </div>
                        <?php
                    } else {

                        if (isset($grouptype) && $grouptype != '') {
                            $Onclickevent = "javascript:create_group();";
                            $hrefevent = "javascript:void(0);";

                            echo $form->input('Group.groupcustomer_id', array('label' => false, 'value' => $groupcustomer_id, 'type' => 'hidden'));
                            echo $form->input('Group.grouptype', array('label' => false, 'value' => $grouptype, 'type' => 'hidden'));
                        } else {
                            $Onclickevent = "javascript:submit_dn();";
                            #$hrefevent = "javascript:submit_dn();";
                            $hrefevent = "javascript:void(0);";
                        }
                        ?>

                        <div class="button-right-disabled" id="updatedns" style="top: -45px; position: relative;" >
                            <a id="dnsbutton" href="<?php echo $hrefevent; ?>"  onclick="<?php echo $Onclickevent; ?>" name="submitForm" value="submitForm"  ><?php echo $buttonText;  ?></a> 
                        </div>
                    <?php } ?>
                </div>
                <?php echo $form->end(); ?>
                <?php //echo $this->element('pagination/newpaging');  ?>
            </div>
        </div>

        <?php
    else:
        __("No Dns available in DB");
        echo '</div>';
    endif;
    ?>

    <div class="button-left">
        <?php
        //if ($userpermission == Configure::read('access_id')) {
            #echo $html->link(__('Back', true),  array('controller'=> 'customers', 'action'=>'index'),array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);')); 
            #echo $html->link('back',  array('controller'=> 'stations', 'action'=>'edit', $station_number));
       // }
        ?>
    </div>
    
</div>
<div class="black_overlay" style=" display: none;">
    <!--<div id="black_overlay_loading">
        <img alt="" src="../../img/assets/ajax-loader.gif">
    </div>-->
</div>
