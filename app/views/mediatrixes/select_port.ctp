
<!--[if IE]>
     <meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1">
<![endif]--> 

<?php 
#App::import('Model','Location');
 #$this->Location=new Location();
 ?>
<style>
    .table-content table  colgroup col:nth-child(7)
    {
        width:150px !important;
    }

.fancybox-inner{
	 height: auto !important;
    overflow: auto;
    width: 437px !important;
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
</style>
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>-->
<script type="text/javascript">
    var dnid = '<?php echo $referred_from; ?>';
    jQuery(document).ready(function() {
		var grpmembercount = $("#grpmembercount").val();
		$("#cpumembercount").val(grpmembercount);
		
		var locationName = $("#locationName").val();
		
		//$('body').data('value',locationName);
		//alert($('body').data('value'));
		
		//$(".tablesorter-filter").attr("selected",locationName);
		//$('.tablesorter-filter option[value=locationName]').attr('selected','selected');
		$("th.tablesorter-filter select").val(locationName);
		
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
		
		
		  /*$('.selectdnsCheckbox').click(function() {
            var p = $(this).val();
            jQuery('input[type="radio"]').each(function() {
			  if ($(this).val() == p)
			  {
				  $(this).prop('checked', true);

			  }
			  else {
				  $(this).prop('checked', false);
			  }
			  		$('#stationbutton').attr("class", "showhighlight_buttonleft");
					$('#updatestation').removeAttr("class");
                    $('#updatestation').attr("class", "button-right-hover");

           });
         });*/
		
    });
	  function redirect_index(){
	  	var cpumembercount = $("#cpumembercount").val();
		if(cpumembercount==0){
					 
		  var TargetURL = "<?php echo Configure::read('base_url');?>groups/deleteGroup/group_id:<?php echo $group_id ?>";	
 		jQuery.post( TargetURL,  function( data ) {  //alert(data);			
			window.location.href= base_url+'groups/pickupgroups/customer_id:<?php echo $cust_id; ?>';
			$('#overlay-sucess .ok .message').text("<?php __('Add Group Canceled') ?>");
		    $('#overlay-sucess').removeClass('hide');
	});
		 
		 
		}else{
			
		 setTimeout( function() {     
			$('.fancybox-overlay').trigger('click');
		 },5);
	 
	} 	
		//window.location.href= base_url+'groups/index/customer_id:<?php echo $cust_id; ?>';
	  	
	  }
	
    

    /* ### Change Pagination style Script ###*/

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
				4: {sorter: false, filter: false},
				6: {sorter: false, filter: false},
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

    });
</script>

<div class="block top">
    <h5<?php echo __('Choose Station', true); ?></h5>
    <div class="black_overlay" style="display: none;">
        <!--<div id="black_overlay_loading">
            <img alt="" src="<?php echo Configure::read('base_url');?>img/assets/ajax-loader.gif">
        </div>-->
    </div>

    <?php
    echo $form->create('Station', array('action' => 'select_station', 'id' => 'filters', 'class' => 'filtersForm', 'type' => 'GET'));
    echo $form->input('Station.customer_id', array('type' => 'hidden', 'value' => $cust_id));
    ?>
	<input type="hidden" name="cpumembercount" id="cpumembercount" value="">
	<input type="hidden" name="grouptype" id="grouptype" value="<?php echo $group_type; ?>">
    <div class="cb">
  <h4> <?php echo __('dnForm'); ?>
         <?php if($group_type=='CPU'){
         	
         	
		 	
			if($memcount==0){
				$helptitle =  __('1stCpuMember_helpTitle',true);
				$helptext =   __('1stCpuMember_helpText',true);
				$burlbInfoText =   __('1stCpuMemberInfo',true); 
			}else{
				$helptitle =  __('cpuMember_helpTitle',true);
				$helptext =   __('cpuMember_helpText',true);
				$burlbInfoText =   __('cpuMemberInfo',true);
			}
			
				 
			}
			elseif($group_type=='MADN'){

				#If the singl string is passed that means that is MADN
				#if($grou_type )
				if($memcount==0){
				$helptitle =  __('1stMadnMember_helpTitle',true);
			    $helptext =   __('1stMadnMember_helpText',true);
				$burlbInfoText =   __('1stMadnMemberInfo',true); 
				}else{
				$helptitle =  __('madnMember_helpTitle',true);
			    $helptext =   __('madnMember_helpText',true);
				$burlbInfoText =   __('madnMemberInfo',true);
				}
			}
			elseif($group_type=='XLH'){
			
				#If the singl string is passed that means that is MADN
				
				if($memcount==0){
					$helptitle =  __('1stXlhMember_helpTitle',true);
					$helptext =   __('1stXlhMember_helpText',true);
					$burlbInfoText =   __('1stMXlhMemberInfo',true);
				}else{
					$helptitle =  __('xlhMember_helpTitle',true);
					$helptext =   __('xlhMember_helpText',true);
					$burlbInfoText =   __('xlhMemberInfo',true);
				}
			}
			else {

				if($memcount==0){
					$helptitle =  __('1stMember_helpTitle',true);
					$helptext =   __('1stMember_helpText',true);
					$burlbInfoText =   __('1stMemberInfo',true);
				}else{
					$helptitle =  __('Member_helpTitle',true);
					$helptext =   __('Member_helpText',true);
					$burlbInfoText =   __('MemberInfo',true);
				}

			}

			
			 ?>
         
  <div class='demonstrations'>
           <div style="font-size: 18px !important; z-index: 1000!important;"><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); redirect_index(); "; window.focus();>X</a></div>
	        <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onclick="Tip('<b><?php echo $helptitle; ?></b><br/><?php echo $helptext; ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>		
    		
 </div>
     
  
  </h4>
        <?php
        // check $locations variable exists and is not empty
        if (isset($stations) && !empty($stations)) :
            ?>
            <!--Showing Page <?php //echo $paginator->counter();   ?>-->  

            <?php #echo $this->element('pagination/top'); ?>
              

            <div id="" class="table-content">
			 
				<span id="blurb"><?php echo $burlbInfoText	; ?></span>
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
            <div class="pager form-horizontal" style="margin:0 !important; float:left; padding: 0px;height: 34px;margin-left: 1px!important;" >
               <?php echo __("totalEntries")?> <span class="slectstationcountdisplay"></span> <?php echo __("entriesPerPage"); ?>: 
                    <select class="pagesize input-mini" title="Select page size">
                        <option selected="selected" value="10">10</option>
                        <option selected="selected" value="25">25</option>
                        <option selected="selected" value="50">50</option>
                        <option selected="selected" value="100">100</option>
                    </select>
                </div>
                <table id="exampleSingle" class="cust_tab_pag phonekey dataTable">
                    <thead> 	
                        <tr class="table-top">
                            <th class="table-column table-left-ohne" style="border-left: 1px solid #D1D1D1!important;">&nbsp;</th>
                            <th class="table-column <?php
                            if (in_array('sort:id', $filter_sort) && in_array('direction:asc', $filter_sort))
                                echo 'sortlink_asc';elseif ((in_array('sort:id', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                echo 'sortlink_desc';
                            else
                                echo 'sortlink';
                            ?> "style="width:102px;text-align: left;">
                            <?php echo __("memberStation", true); ?></th>
							
							
                            <?php
														
							 if($stationLocationid!="") { $stationLocationName = $stationLocationid; }
	                       // else { $stationLocationName=$stationsfirstLocationName; }
							 ?>

                            <th class="table-column filter-select filter-exact <?php
                            if (in_array('sort:type', $filter_sort) && in_array('direction:asc', $filter_sort))
                                echo 'sortlink_asc';elseif ((in_array('sort:type', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                echo 'sortlink_desc';
                            else
                                echo 'sortlink';
                            ?> "style="width:102px;text-align: left;" id="locid" data-value="<?php echo trim($stationLocationName); ?>"><?php echo __("memberLocation", true); ?></th>
                            
							<th class="table-column  filter-exact "style="width:102px;text-align: left;" ><?php echo __("DISPLAYNAME", true); ?></th>
							
							
							<!--<th class="table-column filter-false">-->
							<?php
                                // echo $html->link( __("+", true),'javascript:void(0);',array('id'=>'addChecked','class'=>'addChecked'));
                                // echo $html->link( __("-", true),'javascript:void(0);',array('id'=>'removeChecked','class'=>'removeChecked'));
                            ?>
								
							<!--</th> -->
                           
                             
                        </tr>
                    </thead>
                    <tfoot>
                    <th colspan="4" class="pager form-horizontal" style="border-bottom:1px solid #F9F9F9 !important;border-left:1px solid #F9F9F9 !important;border-right: 1px solid #F9F9F9 !important;">
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
                    <tbody>
                        <?php
                        // initialise a counter for striping the table
                        $count = 0;
                        // loop through and display format
                        foreach ($stations as $station):
						//echo "<pre>";print_r($station);
                            // stripes the table by adding a class to every other row
                            $class = ( ($count % 2) ? " class='altrow'" : '' );
                            // increment count
                            $count++;
                            ?>

                            <tr onmouseover="hoverRow(this, true);" onmouseout="hoverRow(this, false);
                                " >
                                
								 <td><input style="margin-left: 5px !important;" type="radio" class="selectdnsCheckbox <?php echo $station['Station']['id'] ?>" name="selectdnsCheckbox[]" value="<?php echo $station['Station']['id'] ?>" /></td>
                                <td> 
                                    <?php
                                    #echo $html->link($station['Station']['id'],array('controller'=>'stations', 'action'=>'edit', 'DN-'.$station['Station']['id']));
                                    echo $station['Station']['id'];
                                    ?>
                                </td>
                                <td class="table-content column-width-100" style="width:125px;">
                                    <?php
                                    #echo $html->link($station['Station']['type'],array('controller'=>'stations', 'action'=>'edit',                     'DN-'.$station['Station']['id']),array('class'=>'opencolorbox'));
                                    #echo $station['Station']['type'];

									//$grouplocationName=$this->Location->getgroupLocation($station['Station']['location_id']);
							        //echo $grouplocationName['Location']['name'];
									

									#$grouplocationName=$this->Location->getgroupLocation($station['Stationkey']['location_id']);
							        #echo $grouplocationName['Location']['name'];
							        echo $station['Location']['name'];

                                    ?>
                                    <input type="hidden" name="grouplocation" id="grouplocation_<?php echo $station['Station']['id'] ?>" value="<?php echo $station['Location']['name']; ?>" />
                                </td>
								<td class="table-content column-width-100" style="width:125px;">
                                    <?php
                                   
							        echo $station['Feature']['primary_value'];

                                    ?>
                                    <input type="hidden" name="grouplocation" id="grouplocation_<?php echo $station['Station']['id'] ?>" value="<?php echo $station['Location']['name']; ?>" />
                                </td>
								
								
								
                              <!-- <td class="table-right-ohne">&nbsp;</td>-->
                                

    <?php endforeach; ?>
                        </tr>


                    </tbody>

                </table>
                <?php
                	if(($group_type == 'XLH') && ($memcount==0))
                	{
                				$localizedMLH = __('MLH', true);
                				$localizedDLH = __('DLH', true);
                				$group_types = array('MLH' => $localizedMLH, 'DLH' => $localizedDLH);
                				
								echo $form->select('group_subtype', $group_types,'MLH',array('label'=>false, 'style'=>'width:100px;','id'=>'group_subtype'));
                	}
				?>
                <div class="block" style="margin-top: 0px; ">
                    <div class="button-right-disabled" id="updatestation"  style="top: -50px; right:5px; position: relative;">
                        <a id="stationbutton" href="javascript:void(null)"  onclick="javascript:submit_groupentries();"  name="submitForm" value="submitForm" ><?php __("Submit"); ?></a>
                    </div>
                </div>
    <?php echo $form->end(); ?>
    <?php //echo $this->element('pagination/newpaging');   ?>
            </div>
            
         <!--   <div class="form-box">
	<div class="form-right-inactive">
		<p><?php echo __('inactiveFeature')?></p>
	</div>		
          </div> -->
		  
        </div>

        <?php
    else:
        __("No Station available in DB");
        echo '</div>';
    endif;
    ?>

</div>

