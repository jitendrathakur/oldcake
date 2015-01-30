<?php
//if($_GET['page']=="ufedit"){
	
		if($_SESSION['APPNAME']  == 'Phone')
			{ 
				echo '<script type="text/javascript">';
				echo 'var base_url="' . Configure::read('base_url') . '"';
				echo '</script>';
			}
			else
			{
				echo '<script type="text/javascript">';
				echo 'var base_url="' . Configure::read('gate_url') . '"';
				echo '</script>';
			}
	    if ($_SESSION['Config']['language'] != '')
                {
                        $page_lang = strtolower($_SESSION['Config']['language']);
                }
                else
                {
                        $page_lang = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);
                }

		//Style

	        echo $html->css('table'); #commented
	        //echo $html->css('prototable'); //for prototype
        	echo $html->css('phone');
        	echo $html->css('layout');
        	echo $html->css('form');
        	echo $html->css('formate');
			#echo $html->css('jquery.fancybox');
			echo $html->css('station');
			echo $html->css('common');
			echo $html->css("custom");
			#echo $html->css("main"); // added colapsable
			echo $html->css("portal"); // for dashboard
			
			echo $html->css("jquery.tablesorter.pager");  // added new
			echo $html->css("theme.bootstrap");  // added new
			echo $html->css("bootstrap.min");  // added new
			#echo $html->css("tablednd");  // added new
			echo $html->css("select2");
		
			echo $html->css("datepick"); //commented
			#echo $html->css("jquery/jquery.ui.datepicker");
			echo $html->css("localization");  // added new

		//JAvascript
		
		
		echo $javascript->link('/js/webtoolkit.utf8');
		echo $javascript->link('/js/standard');
		echo $javascript->link('/js/table');
		
		
		echo $javascript->link('/js/jquery-1.10.1.min');
		
		#echo $javascript->link('/js/jquery.1-4-2.min'); 
		
	
		echo $javascript->link('/js/'.$page_lang.'_language.js');
	
	  
        echo $javascript->link('/js/jquery.tablesorter'); //added new
		echo $javascript->link('/js/jquery.tablesorter.widgets');
		echo $javascript->link('/js/jquery.tablesorter.pager');
		echo $javascript->link('/js/jquery.tablednd');
		
        
       	?>
		
		<script>
		  function submit_dnuf() {
		
        var checkboxes = $('form').find(':checkbox:checked');
        DN_id = checkboxes.val();
        $('.filtersForm').attr('action', base_url + 'stations/addDN/' + DN_id + '&station_id=' +<?php echo $station_id ?>);
        $('.black_overlay').css('display', 'block');
        //setTimeout(function(){
			
        $.ajax({
            type: "POST",
            async: false,
            url: $('.filtersForm').attr('action'),
            data: $('.filtersForm').serialize(),
            success: function(data) {
				
                //if (data == "success") {
                    if(1){
                    DN_id = '02@' + DN_id; //alert(DN_id);
                    var emptyTdCount = 1;
                    var flag = "";
                    jQuery('.black_overlay').removeAttr('style');
                    jQuery('.black_overlay').attr("style", "display:none");
                    //alert("DN Added Successfully!");
                   jQuery('.fancybox-close').click();
                } else {
                    alert("Some error occurred, Try again!");
                    jQuery('.black_overlay').removeAttr('style');
                    jQuery('.black_overlay').attr("style", "display:none");
                }
            }
        });
		
        //},0);
       // setTimeout(function() {
            //$('.fancybox-overlay').trigger('click');
      //  }, 200);

       // window.location.reload();
        return false;

    }
		</script>
	
		
		<?php	
	
//}
?>

<script type="text/javascript">

jQuery(document).ready(function() {
    $('.selectdnsCheckbox').click(function() {
        var p = $(this).val();
        jQuery('input[type="checkbox"]').each(function() {
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
            var checkboxes = $(this).closest('form').find(':checkbox');
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
                var checkboxes = $("table.dataTable tr:visible").find(':checkbox');
                checkboxes.removeAttr('checked');
            }
        });

        $('.selectdnsCheckbox').click(function() {
            var checkboxes = $(this).closest('form').find(':checkbox:checked');
            //checkboxes.removeAttr('checked');
            //$(this).attr('checked', 'checked');
        });
    });

    /* function to create group*/
    function create_group() {
        var numCheckedCheckbox = 0;
        var identifier = 0;
        jQuery('input[type="checkbox"]').each(function() {
            if ($(this).is(':checked')) {
                numCheckedCheckbox++;
                identifier = $(this).val();
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
            window.location.href = '<?php echo Configure::read('base_url'); ?>groups/edit/group_id:' + data;
        });


    }
    /* End function to create group*/

 
    function create_station() {

        var checkboxes = $('form').find(':checkbox:checked');
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

                //$("table").removeClass('table-striped');
                //$("table").removeClass('tablesorter-bootstrap');

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
				$('.slectdnscountdisplay').html(showrecord);

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
                1: {sorter: false, filter: false},
				5: {sorter: false, filter: false},
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
                    output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'

                });

    });
</script>






<div class="block top">
   <?php
    echo $form->create('Station', array('action' => 'select_station', 'id' => 'filters', 'class' => 'filtersForm', 'type' => 'GET'));
    echo $form->input('Station.customer_id', array('type' => 'hidden', 'value' => $custId));
    ?>
   <h4> <?php if (isset($grouptype)) { ?>
        <?php /*echo __("Choose Identifier to Create Group"); ?> Type <?php echo strtoupper($grouptype);*/
		
		echo __("selectDnMadnGroup");
		 ?>
    <?php } else {
        ?>
         <?php echo __('Select DN', true) ?>
    <?php } ?>
     <?php  if($_GET['page']!="ufedit"){ ?>
	<div class='demonstrations'>
           <div ><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="return fancyboxclose(); UnTip();"><h4>X</h4></a></div>
	        <div ><a href="javascript:;"  style="cursor:pointer" onMouseOver="Tip('<b><?php echo __('selectDnsToScenario_helpTitel') ?></b><br/><?php echo __('selectDnsToScenario_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" ><h4>?</h4></a></div>		
    		
    </div>
	<?php } ?>
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
						if($_GET['page']=="ufedit"){
							$Onclickevent = "javascript:submit_dnuf();";
						}
                        ?>

                        <div class="button-right-disabled" id="updatedns2">
                            <a id="dnsbutton2" href="<?php echo $hrefevent; ?>"  onclick="<?php echo $Onclickevent; ?>" name="submitForm" value="submitForm"  ><?php __("Submit"); ?></a>
                        </div>
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
             <div class="pager form-horizontal" style="margin:0 !important; float:left" >
               <?php echo __("totalEntries")?> <span class="slectdnscountdisplay"></span> <?php echo __("entriesPerPage"); ?>: 
                    <select class="pagesize input-mini" title="Select page size">
                        <option selected="selected" value="10">10</option>
                        <option selected="selected" value="25">25</option>
                        <option selected="selected" value="50">50</option>
                        <option selected="selected" value="100">100</option>
                    </select>
                </div>

                <table id="exampleSingle" class="phonekey dataTable">
                    <thead> 	
                        <tr class="table-top">
                            <th class="table-column table-left-ohne">&nbsp;</th>

                            <?php if (isset($ports) && !empty($ports)) { ?>
                                <th class="table-column filter-false">&nbsp;</th> 	
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
                                <th class="table-column filter-false"><?php
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
                                    <?php echo __("Id", true); ?></th>
                                   <!-- data-value="<?php #echo $dnsLocationName; ?>"-->

                                <th data-value="<?php echo $dnsLocationName; ?>"  class="table-column filter-select filter-exact <?php
                                if (in_array('sort:location_id', $filter_sort) && in_array('direction:asc', $filter_sort))
                                    echo 'sortlink_asc';elseif ((in_array('sort:location_id', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                    echo 'sortlink_desc';
                                else
                                    echo 'sortlink';
                                ?> "style="width:102px;text-align: left;" ><?php echo __("Location", true); ?></th>	    	

                                <!--<th class="table-column <?php
                                if (in_array('sort:function', $filter_sort) && in_array('direction:asc', $filter_sort))
                                    echo 'sortlink_asc';elseif ((in_array('sort:function', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                    echo 'sortlink_desc';
                                else
                                    echo 'sortlink';
                                ?> "style="width:102px;text-align: left;"><?php echo __("Function", true); ?></th>-->

                                <th class="table-column <?php
                                if (in_array('sort:display', $filter_sort) && in_array('direction:asc', $filter_sort))
                                    echo 'sortlink_asc';elseif ((in_array('sort:display', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                    echo 'sortlink_desc';
                                else
                                    echo 'sortlink';
                                ?> "style="width:130px;text-align: left;"><?php echo __("DISPLAYNAME", true); ?></th>

                               <!-- <th class="table-column <?php
                                if (in_array('sort:emer', $filter_sort) && in_array('direction:asc', $filter_sort))
                                    echo 'sortlink_asc';elseif ((in_array('sort:emer', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                    echo 'sortlink_desc';
                                else
                                    echo 'sortlink';
                                ?> "style="width:102px;text-align: left;"><?php echo __("Emergency", true); ?></th>-->

                            <?php } ?>
                            <th class="table-right-ohne">&nbsp;</th> 
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

                    </th>
                    </tr>
                    </tfoot>
                    <tbody>

                        <?php
                        if (isset($ports) && !empty($ports)) {
                            $count = 0;
                            foreach ($ports as $port):
                                // stripes the table by adding a class to every other row
                                $class = ( ($count % 2) ? " class='altrow'" : '' );
                                // increment count
                                $count++;
                                ?>
                                <tr onmouseover="hoverRow(this, true);" onmouseout="hoverRow(this, false);
                                    " >
                                    <td class="table-left">&nbsp;</td>	
                                    <td><input type="checkbox" class="selectdnsCheckbox <?php echo $port['Port']['id']; ?>" name="selectdnsCheckbox[]" value="<?php echo $port['Port']['id']; ?>" /></td>								 
                                    <td class="column-width-150"><?php echo $port['Port']['id']; ?></td>
                                    <td><?php echo $port['Port']['mediatrix_id']; ?></td>
                                    <td><?php echo $port['Port']['station_id']; ?></td>
                                    <td><?php echo $port['Station']['phone_type']; ?></td>
                                    <td><?php echo $port['Port']['type']; ?></td>

                                    <td class="table-right-ohne">&nbsp;</td>9501089847

                                    <?php
                                endforeach;
                            } else {
                                // initialise a counter for striping the table
                                $count = 0;
                                // loop through and display format
                                foreach ($dns2 as $dn):
                                    // stripes the table by adding a class to every other row
                                    $class = ( ($count % 2) ? " class='altrow'" : '' );
                                    // increment count
                                    $count++;
                                    ?>

                                <tr onmouseover="hoverRow(this, true);" onmouseout="hoverRow(this, false);
                                    " >
                                    <td class="table-left">&nbsp;</td>
                                    <td style="width:55px;!important"> 
                                        <?php
                                        if (($dn['Dns']['function'] != '') && ($dn['Dns']['function'] != 'CFRA') && ($dn['Dns']['function'] != 'UCD') && ($dn['Dns']['function'] != 'INTERNAL')) {
                                            ?>
                                            <input type="checkbox" class="selectdnsCheckbox <?php echo $dn['Dns']['id'] ?>" name="selectdnsCheckbox[]" value="<?php echo $dn['Dns']['id'] ?>" onclick="uncheckanother()" /> 
                                       
									    <td><?php echo $html->link($dn['Dns']['id'], array('controller' => 'stations', 'action' => 'edit', 'DN-' . $dn['Dns']['id'])); ?></td>


                                        </td>
                                        <td class="table-content column-width-100" style="width:125px;">
                                            <?php
                                            echo $html->link($dn['Location']['name'], array('controller' => 'stations', 'action' => 'edit', 'DN-' . $dn['Dns']['id']), array('class' => 'opencolorbox'));
                                            #echo $dn['Location']['name']; 
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            #echo $dn['Dns']['function'];
                                            echo $html->link(__($dn['Dns']['function'], true), array('controller' => 'stations', 'action' => 'edit', 'DN-' . $dn['Dns']['id']));
                                            ?>
                                        </td>

                                        <td>
                                            <?php
                                            #echo $dn['Dns']['display']; 
                                            echo $html->link($dn['Dns']['display'], array('controller' => 'stations', 'action' => 'edit', 'DN-' . $dn['Dns']['id']));
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            #echo $dn['Dns']['emer']; 
                                            echo $html->link($dn['Dns']['emer'], array('controller' => 'stations', 'action' => 'edit', 'DN-' . $dn['Dns']['id']));
                                            ?>
                                        </td>

                                        <td class="table-right-ohne">&nbsp;</td>
                                        <?php
                                    } else {  ?>
									<input type="checkbox" class="selectdnsCheckbox <?php echo $dn['Dns']['id'] ?>" name="selectdnsCheckbox[]" value="<?php echo $dn['Dns']['id'] ?>" />
                                </td>
                                <td ><?php echo $dn['Dns']['id']; ?></td>
                                <td class="table-content" style="width:125px;">
                                    <?php echo $dn['Location']['name']; ?>
                                </td>
                                <!--<td><?php echo $dn['Dns']['emer']; ?></td>-->
                                <!--<td><?php echo __($dn['Dns']['function'], true); ?></td>-->

                                <td><?php echo $dn['Dns']['display']; ?></td>

                                <td class="table-right-ohne">&nbsp;</td>

                                <?php
                            }
                        endforeach;
                    }
                    ?>
                    </tr>	    				
                    </tbody>

                </table>
                <div class="block" style="margin: 0px;">
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

                        <div class="button-right-disabled" id="updatedns">
                            <a id="dnsbutton" href="<?php echo $hrefevent; ?>"  onclick="<?php echo $Onclickevent; ?>" name="submitForm" value="submitForm"  ><?php __("Submit"); ?></a>
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
    
    <div class="form-box">
	<div class="form-right-inactive">
		<p><?php echo __('inactiveFeature')?></p>
	</div>		
</div>
</div>
<div class="black_overlay" style="height: 622px; width: 1366px; display: none;">
    <div id="black_overlay_loading">
        <img alt="" src="../../img/assets/ajax-loader.gif">
    </div>
</div>
