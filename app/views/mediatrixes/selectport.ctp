<?php 
echo $javascript->link('/js/jquery.dataTables.min');
#App::import('Model','Location');
 #$this->Location=new Location();
 ?>
<!--[if IE]>
     <meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1">
<![endif]--> 

<style>
    .table-content table  colgroup col:nth-child(7)
    {
        width:150px !important;
    }

.fancybox-inner{
	 height: auto !important;
    overflow: auto;
    width: 737px !important;
	z-index: 1002 !important;
}
.fancybox-wrap
{
z-index: 1002 !important;	
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
    padding: 0px 10px 4px 0px!important;
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
    
	padding-left:5px!important;
    text-align: left;
    vertical-align: top;
}



div.DataTables_sort_wrapper span{
 background: url("../../images/assets/table-sort-default.gif") no-repeat scroll 3% 80% rgba(0, 0, 0, 0) !important;
    color: #555555;
    margin-top: -7px;

}

div.DataTables_sort_wrapper span.ui-icon-triangle-1-s{
 background: url("../../images/assets/table-sort-asc.gif") no-repeat scroll 3% 80% rgba(0, 0, 0, 0) !important;
    color: #555555;
    margin-top: -7px;

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
function infotest(){

// $("#infotest").off("click");
}
function changebutton(){	
	//alert('test');
	jQuery('#stationbutton').attr("class", "showhighlight_buttonleft");
	jQuery('#updatestation').removeAttr("class");
	jQuery('#updatestation').attr("class", "button-right-hover");
	
	
	jQuery('#dnsbutton2').attr("class", "showhighlight_buttonleft");
	jQuery('#updatedns2').removeAttr("class");
	jQuery('#updatedns2').attr("class", "button-right-hover");

}

    var dnid = '<?php echo $referred_from; ?>';
    jQuery(document).ready(function() {
		var grpmembercount = $("#grpmembercount").val();
		$("#cpumembercount").val(grpmembercount);
		
		var locationName = $("#locationName").val();
	
		//$("th.tablesorter-filter select").val(locationName);
		
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
                //checkboxes.removeAttr('checked');
            }
        });

        $('.selectdnsCheckbox').click(function() {
            var checkboxes = $(this).closest('form').find(':radio:checked');
            //checkboxes.removeAttr('checked');
            $(this).attr('checked', 'checked');
			$('#stationbutton').attr("class", "showhighlight_buttonleft");
					$('#updatestation').removeAttr("class");
                    $('#updatestation').attr("class", "button-right-hover");
        });
		
    });
	  
	
    function submit_stationentries() {
        var checkboxes = $('form').find(':radio:checked');
        mediatrix_id = checkboxes.val();
		
		var checkboxId = checkboxes.attr('id');	
		var selection =checkboxId.split('-');
		var slectionID =    selection['1'];
		//selectdnscheckbox
		var station_id = '<?php echo $station_id ?>';
		//var stationLoc = $("#stationlocation_"+mediatrix_id).val();
		var stationLoc = 'test';
		//var portId     = $("#portID_"+slectionID).val();
		var portId     = checkboxes.val();
		var customer_id = '<?php echo $cust_id; ?>';
		var phone_type = $("#drp").val();
	    //alert(portId);
	
      //$('.filtersForm').attr('action', base_url + 'stations/updateBase/&stationLoc='+ stationLoc+'&station_id='+ station_id+'&port='+ portId);
	  var TargetURL =base_url + 'stations/updateBase/&customer_id='+ customer_id+ '&phone_type='+ phone_type+'&station_id='+ station_id+'&port='+ portId;
        $('.black_overlay').css('display', 'block');
	    $.fancybox.showLoading();
	   //checking browser of ajax submit behavoir
	   var asyncronation;
	   if(browserCheck()=="MSIE"){
	    asyncronation = true;
	    }
	   else{
		asyncronation = false;
	     }
	
       
        jQuery.post(TargetURL, {station_id: station_id,stationLoc:stationLoc, port:portId,customer_id:customer_id,phone_type:phone_type}, function(data) {	
				
				//alert(data);	
				var TargetURL = "<?php echo Configure::read('base_url');?>stations/editstation/<?php echo $station_id ?>";
					window.location.href = TargetURL;
           
        });
        
      

       
       
    }

    /* ### Change Pagination style Script ###*/
	/*
    function paginationStyle(totPages,currPage) {
       
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
      
        $('.slectstationcountdisplay').html(showrecord);
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
            odd: ''  // even row zebra striping
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
                3: {sorter: true, filter: true},
				4: {sorter: true, filter: true},
				6: {sorter: false, filter: true},
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
                    output: '{startRow} - {endRow} / {filteredRows} ({totalRows})',                    
                    pagerUpdate:function(totPages,currPage)
                    {
                        paginationStyle(totPages,currPage);
                    }

                });

    });*/
</script>
<script>
	/*
	function redirect_index(){ 
	
		  var TargetURL = "<?php echo Configure::read('base_url');?>dns/setDnsFree/station_id:<?php echo $station_id ?>";
 		jQuery.post( TargetURL,  function( data ) {  
		  
			window.location.href= base_url+'dns/viewdns/customer_id:<?php echo $cust_id; ?>';
			
			$('#overlay-sucess .ok .message').text("<?php __('Add Station Canceled') ?>");
		    $('#overlay-sucess').removeClass('hide');
	});
		
	  }
	  */
	  
	 
	
</script>
<?php $stationStatus = Configure :: read('stationStatus'); ?>
<div class="block top">
    <h5<?php echo __('Choose Station', true); ?></h5>
    <div class="black_overlay" style="display: none;">
        
    </div>

    <?php
    echo $form->create('Mediatrixes', array('action' => 'selectport', 'id' => 'filters', 'class' => 'filtersForm', 'type' => 'GET'));
    echo $form->input('Mediatrixes.customer_id', array('type' => 'hidden', 'value' => $cust_id));
    ?>
	<input type="hidden" name="cpumembercount" id="cpumembercount" value="">
	<input type="hidden" name="grouptype" id="grouptype" value="<?php echo $group_type; ?>">
    <div class="cb">
  <h4> <?php echo __('portSelector'); ?>
         
         
  <div class='demonstrations'>
           <div style="font-size: 18px !important; z-index: 1000!important;"><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); redirect_index(); "; window.focus();>X</a></div>
	        <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onclick="Tip('<b><?php echo __('portSelector_helpTitle'); ?></b><br/><?php echo __('portSelector_helpText'); ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>		
    		
 </div>
     
  
  </h4>
        <?php
        // check $locations variable exists and is not empty
        if (isset($mediatrixes) && !empty($mediatrixes)) :
            ?>
            <!--Showing Page <?php //echo $paginator->counter();   ?>-->  

            <?php #echo $this->element('pagination/top'); ?>
              

            <div id="" class="table-content">
			 
				<span id="blurb"><?php echo $burlbInfoText =  __("selectFreePort",true); 	 ?></span>
				<?php
		if(strlen($burlbInfoText)>16 ){ 		
			$width = 645;
			$float = right;
		}
		else {
			$width = 300;
			$float = right;
		}
		#echo wordwrap($str,15,"<br>\n");				
		$splitat = strpos($burlbInfoText," ",strlen($burlbInfoText)/2);
		$col1 = substr($burlbInfoText, 0, $splitat);
		$col2 = substr($burlbInfoText, $splitat);
		
		
        ?>
				
		<!--<div>
				<div  style="width:170px; text-align: left;float:left;margin-top:-16px;"><?php echo $col1; ?></div>
				<div  style="width:170px; text-align: left;float: right;margin-top:0px;"><?php echo $col2; ?></div>
		</div>-->
			
		
			<br/>
            
                <table id="exampleSingle" class="phonekey dataTable" style="margin-bottom:15px;">
				
                    <thead> 

						<tr class="table-top withdatatablecss">	
							<th><div style="width:30px;">&nbsp;</div></th>
							
							<th><input type="text" id="search_filter_portname" style="width:156px !important;margin-left:5px;float:left;margin-right:4px;" ></th>
							
							<th>
											<select id="search_filter_porttype" style="width:65px !important;margin-left:5px;float:left;margin-right:4px;">
											<option></option>
											<?php
												foreach($portlist as $list){
												?>
												<option value="<?php echo $list; ?>"><?php echo $list; ?></option>
											<?php	
												}
											?>
											
											</select>
										</th>
										
							
							<th>
											<select id="search_filter_location" style="width:100px !important;margin-left:5px;float:left;margin-right:4px;">
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
							
							<th><input type="text" id="search_filter_stationid" style="width:100px !important;margin-left:5px;float:left;margin-right:4px;" ></th>
							
							<th>
											<select id="search_filter_status" style="width:100px !important;margin-left:5px;float:left;margin-right:4px;">
											<option></option>
											<?php
												foreach($statuslist as $list){
												?>
												<option value="<?php echo $list; ?>"><?php echo $list; ?></option>
											<?php	
												}
											?>
											
											</select>
										</th>
							
							<th><input type="text" id="search_filter_displayname" style="width:100px !important;margin-left:5px;float:left;margin-right:4px;" ></th>
							
						</tr>
                        <tr class="table-top">
                           <th class="table-column filter-select filter-exact "style="width:102px;text-align: left;" > <div>&nbsp;</div></th>
							
                            <th align="left" class="table-column <?php
                            if (in_array('sort:id', $filter_sort) && in_array('direction:asc', $filter_sort))
                                echo 'sortlink_asc';elseif ((in_array('sort:id', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                echo 'sortlink_desc';
                            else
                                echo 'sortlink';
                            ?> "style="width:112px;text-align: left;">
                            <div><?php echo __("Port Name", true); ?></div></th>
							
							
                            <?php
														
							 if($stationLocationid!="") { $stationLocationName = $stationLocationid; }
							 ?>

                            <th class="table-column filter-select filter-exact <?php
                            if (in_array('sort:type', $filter_sort) && in_array('direction:asc', $filter_sort))
                                echo 'sortlink_asc';elseif ((in_array('sort:type', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                echo 'sortlink_desc';
                            else
                                echo 'sortlink';
                            ?> "style="width:102px;text-align: left;" id="locid" data-value="<?php echo trim($stationLocationName); ?>"> <div><?php echo __("Port Type", true); ?> </div></th>
                            
							<th class="table-column filter-select filter-exact "style="width:102px;text-align: left;" data-value="<?php echo trim($preFilterLocation); ?>" > <div><?php echo __("Location", true); ?> </div></th>
							<th class="table-column  filter-exact "style="width:90px;text-align: left;" data-value="" > <div><?php echo __("Station ID", true); ?> </div></th>
							<th class="table-column filter-select filter-exact "style="width:110px;text-align: left;" data-value="" > <div><?php echo __("Status", true); ?> </div></th>
							<th class="table-column  filter-exact "style="width:110px;text-align: left;" data-value="" > <div><?php echo __("Display Name", true); ?> </div></th>
							
							
							
							<?php
                               
                            ?>
								
							
                           
                             
                        </tr>
                    </thead>
                   
                    <tbody>
                        


                    </tbody>

                </table>
				<br />
                <script type="text/javascript">
							
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
									
									"bJQueryUI": true,
										"aoColumnDefs": [
											{ "sWidth": "10%", "aTargets": [ -1 ] }
										],
									
									"oLanguage": {
										"sZeroRecords":"<?php echo __("noMatching"); ?>",
										"sSearch": "Futher Filter Search results:",
										"sInfo": "Got a total of _TOTAL_ results to show (_START_ to _END_)",
										"sLengthMenu": '<div style="float:left"><?php echo __("totalEntries")?>&nbsp;</div> <div id="counter" style="float:left;"></div> '+
										'<div style="float:left;margin-left:2px;"><?php echo __("entriesPerPage"); ?>' +
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
										$("#chknumber").val(iTotal);
										
										$("#exampleSingle_first").removeClass("ui-state-default");	
										$("#exampleSingle_previous").removeClass("ui-state-default");	
										
										$("#exampleSingle_next").removeClass("ui-state-default");	
										$("#exampleSingle_last").removeClass("ui-state-default");
										
										if ($("#checkAllDn").is(':checked')) {
											
											//$('.odsentchk').bind('click', function() {  });
											getval = $("#chknumber").val();
											//if(iTotal == getval)
											 $('.cntdns').text("<?php echo __('dnOfLocationSelected'); ?> : "+ (iTotal));
											
											//$('.cnt').text("<?php echo __('Update Selected'); ?> : " + (iTotal));
										}
									   
									}
									
								}
								) ;								
								
								
								var jArray = <?php echo $dns3; ?>;
								
								var countlength = "<?php echo count($mediatrixes ); ?>";
								
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
									var Mediatrixid = jArray[irow]['Mediatrix']['id'];
									var stationid = jArray[irow]['Station']['id'];
									var portname = jArray[irow]['Port']['name'];
									var porttype = jArray[irow]['Port']['type'];
									var portid = jArray[irow]['Port']['id'];
									var featureval = jArray[irow]['Feature']['primary_value'];
									var locationname = jArray[irow]['Location']['name'];
									var checkval = jArray[irow]['Mediatrix']['checkval'];
									
									if (stationid !== null && stationid !== undefined) {
										cells[0] = "&nbsp;";
									}else{
										
										
										cells[0] = '<input onclick="changebutton()" type="radio" class="selectdnsCheckbox"  id="selectdnsCheckbox'+stationid+'" name="selectdnsCheckbox[]" value="'+portid+'" style="margin:7px 6px 0" />';
									}
									cells[1] = portname;
									
									cells[2] = porttype;
									
									cells[3] = locationname;
									
									cells[4] = stationid;
									
									cells[5] = checkval;
									
									cells[6] = featureval;
										
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
							  
							  /*
							  
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
							*/
							  var oTable;
							  oTable = $('#exampleSingle').dataTable();
							   
							   $('#search_filter_portname').keyup( function() { 									
									//alert('ffff');
									oTable.fnFilter( $(this).val(),1); 
									
									//checkboxall();
									
									//$("div a.cnt").text("Hello");
									oTable.fnDraw();
							   });
							   $('#search_filter_porttype').change( function() { 									
									//alert('ffff');
									oTable.fnFilter( $(this).val(),2); 
									
									//checkboxall();
									
									//$("div a.cnt").text("Hello");
									oTable.fnDraw();
							   });
							    $('#search_filter_location').change( function() { 									
									//alert('ffff');
									oTable.fnFilter( $(this).val(),3); 
									
									//checkboxall();
									
									//$("div a.cnt").text("Hello");
									oTable.fnDraw();
							   });
							    $('#search_filter_stationid').keyup( function() { 									
									//alert('ffff');
									oTable.fnFilter( $(this).val(),4); 
									
									//checkboxall();
									
									//$("div a.cnt").text("Hello");
									oTable.fnDraw();
							   });
							    $('#search_filter_status').change( function() { 									
									//alert('ffff');
									oTable.fnFilter( $(this).val(),5); 
									
									//checkboxall();
									
									//$("div a.cnt").text("Hello");
									oTable.fnDraw();
							   });
							   
							   
							   $('#search_filter_displayname').keyup( function() { 									
									//alert('ffff');
									oTable.fnFilter( $(this).val(),6); 
									
									//checkboxall();
									
									//$("div a.cnt").text("Hello");
									oTable.fnDraw();
							   });
							  
						   });
							
							$("#exampleSingle_filter").hide();
							
							$("#exampleSingle_first").text("<<");	
							$("#exampleSingle_previous").text(" <");	
							
							$("#exampleSingle_next").text(" >");	
							$("#exampleSingle_last").text(" >>");
							
					</script>
					<br /></br />
                <div class="block" style="margin-top: 0px; ">
                    <div class="button-right-disabled" id="updatestation"  style="top: -50px; right:5px; position: relative;">
                        <a id="stationbutton" href="javascript:void(null)"  onclick="javascript:submit_stationentries();"  name="submitForm" value="submitForm" ><?php __("Submit"); ?></a>
                    </div>
                </div>
    <?php echo $form->end(); ?>
    
            </div>
            
       
		  
        </div>

        <?php
    else:
        __("No Mediatrix available in DB");
        echo '</div>';
    endif;
    ?>

</div>

<?php  exit; ?>