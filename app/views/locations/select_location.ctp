<style>
    .table-content table  colgroup col:nth-child(7)
    {
        width:150px !important;
    }
</style>
<script type="text/javascript">
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
    function submit_dn() {
        var checkboxes = $('form').find(':checkbox:checked');
        DN_id = checkboxes.val();
        $('.filtersForm').attr('action', base_url + 'stations/addDN/' + DN_id + '&station_id=' +<?php echo $station_id ?>);
        $('.black_overlay').css('display', 'block');
        setTimeout(function() {
            $.ajax({
                type: "POST",
                async: false,
                dataType: 'json',
                url: $('.filtersForm').attr('action'),
                data: $('.filtersForm').serialize(),
                success: function(data) {
                    if (data.message == "success") {
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
        }, 0);

        window.location.reload();
        return false;

    }
    function create_station() {


        var checkboxes = $('form').find(':checkbox:checked');
        DN_id = checkboxes.val();
        $('.filtersForm').attr('action', base_url + 'stations/create/station_id:' + DN_id);
        $('.black_overlay').css('display', 'block');
        setTimeout(function() {
            $.ajax({
                type: "POST",
                async: false,
                dataType: 'json',
                url: $('.filtersForm').attr('action'),
                data: $('.filtersForm').serialize(),
                success: function(data) {
                    if (data.message == "success") {
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
        }, 0);

        window.location.reload();
        return false;

    }
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
                    output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'

                });

    });
</script>
<div class="block top">
    <br>

    <?php
    echo $form->create('Location', array('action' => 'select_station', 'id' => 'filters', 'class' => 'filtersForm', 'type' => 'GET'));
    echo $form->input('Location.customer_id', array('type' => 'hidden', 'value' => $custId));
    ?>
    <div class="cb">
        <div class="block" style="margin: 0px;">
            <div class="button-right">
                <?php echo $html->link(__("Export Csv", true), array('controller' => 'dns', 'action' => 'export'), array('onmouseover' => 'hoverButtonRight(this);', 'onmouseout' => 'javascript:outButtonRight(this);')); ?>
            </div>

            <div class="button-left">
                <?php echo $html->link(__("reset", true), 'javascript:void(0);', array('onmouseover' => 'javascript:hoverButtonLeft(this);', 'onmouseout' => 'javascript:outButtonLeft(this);', 'class' => 'reset')); ?>
            </div>

        </div>

        <?php
        // check $locations variable exists and is not empty
        if (isset($locations) && !empty($locations)) :
            ?>
            <!--Showing Page <?php //echo $paginator->counter();     ?>-->  

            <?php //echo $this->element('pagination/top');?>
            <div id="" class="table-content">
                <table id="exampleSingle" class="phonekey dataTable">
                    <thead> 	
                        <tr class="table-top">
                            <th class="table-column table-left-ohne">&nbsp;</th>
                            <th class="table-column <?php
                            if (in_array('sort:id', $filter_sort) && in_array('direction:asc', $filter_sort))
                                echo 'sortlink_asc';elseif ((in_array('sort:id', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                echo 'sortlink_desc';
                            else
                                echo 'sortlink';
                            ?> "style="width:102px;text-align: left;">
                                <?php echo __("Id", true); ?></th>

                            <th class="table-column <?php
                            if (in_array('sort:location_id', $filter_sort) && in_array('direction:asc', $filter_sort))
                                echo 'sortlink_asc';elseif ((in_array('sort:location_id', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                echo 'sortlink_desc';
                            else
                                echo 'sortlink';
                            ?> "style="width:102px;text-align: left;"><?php echo __("id", true); ?></th>


                            <th class="table-column <?php
                            if (in_array('sort:function', $filter_sort) && in_array('direction:asc', $filter_sort))
                                echo 'sortlink_asc';elseif ((in_array('sort:function', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                echo 'sortlink_desc';
                            else
                                echo 'sortlink';
                            ?> "style="width:102px;text-align: left;"><?php echo __("id", true); ?></th>

                            <th class="table-column <?php
                            if (in_array('sort:display', $filter_sort) && in_array('direction:asc', $filter_sort))
                                echo 'sortlink_asc';elseif ((in_array('sort:display', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                echo 'sortlink_desc';
                            else
                                echo 'sortlink';
                            ?> "style="width:102px;text-align: left;"><?php echo __("id", true); ?></th>

                            <th class="table-column <?php
                            if (in_array('sort:emer', $filter_sort) && in_array('direction:asc', $filter_sort))
                                echo 'sortlink_asc';elseif ((in_array('sort:emer', $filter_sort) && in_array('direction:desc', $filter_sort)))
                                echo 'sortlink_desc';
                            else
                                echo 'sortlink';
                            ?> "style="width:102px;text-align: left;"><?php echo __("Emergency", true); ?></th>
                            <th class="table-column filter-false"><?php
                                // echo $html->link( __("+", true),'javascript:void(0);',array('id'=>'addChecked','class'=>'addChecked'));
                                // echo $html->link( __("-", true),'javascript:void(0);',array('id'=>'removeChecked','class'=>'removeChecked'));
                                ?></th> 
                            <th class="table-right-ohne">&nbsp;</th> 
                        </tr>
                    </thead>
                    <tfoot>
                    <th colspan="7" class="pager form-horizontal">
                        <button type="button" class="btn first"><i class="icon-step-backward"></i></button>
                        <button type="button" class="btn prev"><i class="icon-arrow-left"></i></button>
                        <span class="pagedisplay"></span> <!-- this can be any element, including an input -->
                        <button type="button" class="btn next"><i class="icon-arrow-right"></i></button>
                        <button type="button" class="btn last"><i class="icon-step-forward"></i></button>
                        <select class="pagesize input-mini" title="Select page size">
                            <option selected="selected" value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                        </select>
                        <select class="pagenum input-mini" title="Select page number"></select>
                    </th>
                    </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        // initialise a counter for striping the table
                        $count = 0;
                        // loop through and display format
                        foreach ($locations as $location):
                            // stripes the table by adding a class to every other row
                            $class = ( ($count % 2) ? " class='altrow'" : '' );
                            // increment count
                            $count++;
                            ?>

                            <tr onmouseover="hoverRow(this, true);" onmouseout="hoverRow(this, false);
                                " >
                                <td class="table-left">&nbsp;</td>
                                <td> 
                                    <?php
                                    echo $location['Location']['id'];
                                    ?>
                                </td>
                                <td class="table-content column-width-100" style="width:125px;">
                                    <?php echo $location['Location']['id']; ?>
                                </td>
                                <td><?php echo $location['Location']['id']; ?></td>
                                <td><?php echo $location['Location']['id']; ?></td>

                                <td><?php echo $location['Location']['id']; ?></td>
                                <td><?php echo $location['Location']['id']; ?></td>
                                <td class="table-right-ohne">&nbsp;</td>

                            <?php endforeach; ?>
                        </tr>


                    </tbody>

                </table>
                <div class="block" style="margin: 0px;">
                    <?php
                    if (isset($portId)) {
                        ?>
                        <div class="button-right">
                            <a href="javascript:create_station()"  onclick="javascript:create_station();" name="submitForm" value="submitForm" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __("Submit"); ?></a>
                        </div>
                        <?php
                    } else {
                        ?>

                        <div class="button-right">
                            <a href="javascript:submit_dn()"  onclick="javascript:submit_dn();" name="submitForm" value="submitForm" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __("Submit"); ?></a>
                        </div>
                    <?php } ?>
                </div>
                <?php echo $form->end(); ?>
                <?php //echo $this->element('pagination/newpaging');   ?>
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
        if ($userpermission == Configure::read('access_id')) {
            #echo $html->link(__('Back', true),  array('controller'=> 'customers', 'action'=>'index'),array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);')); 
            #echo $html->link('back',  array('controller'=> 'stations', 'action'=>'edit', $station_number));
        }
        ?>
    </div>
</div>
</div>
<div class="black_overlay" style="height: 622px; width: 1366px; display: none;">
    <div id="black_overlay_loading">
        <img alt="" src="../../img/assets/ajax-loader.gif">
    </div>
</div>
<!--right hand side starts from here-->
<!--<div id="related-content" style="float: left; margin-left:10px;">
<br/>
        <div class="box start link">
                <a href="http://www.swisscom.ch/grossunternehmen" target="_blank">
<?php __('Home Swisscom') ?>
                </a>
        </div>
        <div class="box info">
                 <h3><?php __('DN List') ?></h3>
                 <p>
<?php __('DN_blurb') ?>
                 </p>
        </div>

<!--INTERNAL USER OPTIONS -->
<?php /* if($userpermission==Configure::read('access_id'))
  {?>
  <div class="box info">
  <h3><?php __("Internal User");?></h3>
  <p><?php __("Customer View:");?></p>
  <p><?php echo $selected_customer; ?></p>

  </div>
  <?php } */ ?>

</div>
<!--ight hand side  ends here-->

