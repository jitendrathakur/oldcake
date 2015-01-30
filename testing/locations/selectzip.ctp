<div id="zipdiv">
<script type="text/javascript">

jQuery(document).ready(function(){ 

 jQuery('.selectdnsCheckbox').click(function(event){
 
  var id= $(this).attr("id");
 
  
 if ($(this).is(':checked')) {
 
 
   jQuery('input[type="radio"]').each(function() {
   var iid=$(this).attr('id');
 
   if(id!=iid){
				jQuery(this).prop("checked",false);
				}
			});
		}
     });
});


//function slect_plz(){
	jQuery(document).ready(function(){ 
	   jQuery('#addLocation').click(function(event){
         jQuery('input[type="radio"]').each(function() {
		if ($(this).is(':checked')) {
		var plz=$(this).val();
      
		var args = plz.split("****");
		
		
		
		var zipval = args[0];
		var emerval = args[1];	
		
		
		$('#LocationPlz').val(zipval);
		
		
		$('#LocationEmer').val(emerval);
		
		
		jQuery('.fancybox-close').click();
		
		$('#selectzip').hide();
		$('#update').show();	
		$('#create').attr("class", "showhighlight_buttonleft");
        $('#update').attr("class", "button-right-hover");
		 $('#LocationEditForm').submit();  
	}
	
		});
	
	
});
});
//}
</script>
<script>
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
                            jQuery(".tablesorterdns").tablesorter({
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
                                    7: {sorter: false, filter: false}


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
                                        //  output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'
										//output: '{startRow} - {endRow} [{page}] {filteredRows} ({totalRows})'
										//output: 'Page <input type="text" name="currpage" value="{page}" class="pagination_text" maxlength="3"> Of {totalPages}'
										output: '<input type="text" name="currpage" value="{page}" class="pagination_text" maxlength="3"> <?php echo __('Of') ?> {totalPages}'

                                    });
                        });</script>
</script>
<style>
    .tablesorter-filter
    {
        width:100% !important;
		float:left !important;
				
    }
    .space_check
    {
        width:75%;
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
        width:150px !important;
    }
    #example colgroup col:nth-child(4)
    {
        width:120px !important;
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
tablesorter-filter-row input[type="search"]{
	width: 100% !important;
}	
</style>

<div>
<div id="overlay-sucess" class="notification first hide" style="width: 100%" >
    
    <div class="ok">
        <div class="message">
            <?php echo __("please select location"); ?>
        </div>
    </div>
</div>
<h4><?php echo __('selectEmer'); ?>
	
	<div class='demonstrations'>           
		   <div> <a href="javascript:;"  style="cursor:pointer;font-size:18px !important;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick=" setTimeout( function() {     
					$('.fancybox-overlay').trigger('click');
					 },5); UnTip();">X</a></div>		  
	        
			<div><a href="javascript:;"  style="cursor:pointer;font-size:18px !important;" onMouseOver="Tip('<b><?php echo __('selectzip_helpTitel') ?></b><br/><?php echo __('selectzip_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>				
    		
 	  </div>
	
</h4>
<table id="example" class="dataTable tablesorterdns"  style="width:400px;border-collapse: collapse;" cellspacing="0" cellpadding="0">
<thead> 	
				<tr class="table-top ">
				 <th class="table-column filter-false withdatatablecss"></th>
				 <th class="table-column  withdatatablecss"style="width:102px;text-align: left;">
				 Emergency
				 </th>
                 <th class="table-column  withdatatablecss"style="width:102px;text-align: left;">
				 ZIP
				 </th>
				 <th class="table-column  withdatatablecss"style="width:102px;text-align: left;">
				 ORT
				</th>
				
				
				 </tr>
				</thead>
<tbody>
<?php

					foreach($bakom as $bkms)
					{
?>					

                   <tr>
				    <td class="withdatatablecss" style="width:55px;!important;padding-left: 10px !important;"><input type="radio" class="selectdnsCheckbox"  id="<?php echo $bkms['Bakom']['id']  ?>" name="selectdnsCheckbox[]" value="<?php echo $bkms['Bakom']['PLZ']?>****<?php echo $bkms['Bakom']['emer']?>" /></td>
				   <td class="withdatatablecss">
				   <?php
					echo $bkms['Bakom']['emer'];
						
					?>
					</td>
					<td class="withdatatablecss">
				   <?php
					echo $bkms['Bakom']['PLZ'];
						
					?>
					</td>
					<td class="withdatatablecss">
				   <?php
					echo $bkms['Bakom']['ort'];
						
					?>
					</td>
					
					 
	<?php				
					}
                 

?>
</tr>
 <tbody>
 </table>
 <div class="block" style="margin: 0px;">
			 	
				<div class="button-right">
					<a href="javascript:void(0);" id="addLocation" onclick="javascript:slect_plz();" name="submitForm" value="submitForm" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __("addLocation");?></a>
				</div>
				
</div>
</div>
</div>