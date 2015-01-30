<?php 
App::import('Model', 'Dns');
    $this->Dns = new Dns();
   
//echo $javascript->link('/js/jquery-1.10.1.min');
//echo $javascript->link('/js/jquery.fancybox');


 echo $javascript->link('/js/jquery.fancybox');
  echo $javascript->link('front');

?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
</script>

<script type="text/javascript">
$(document).ready(function(){
	$('#savednsname').click(function(){
		var dns_name = jQuery('.dns').val();
		var dns_id = '<?php echo $dns_id; ?>';
		var customer_id = '<?php echo $customer_id; ?>';		
			var TargetURL = "<?php echo Configure::read('base_url');?>scenarios/update_dnsdetails/dns_id:"+scenario_id+"/customer_id:"+customer_id+"/dns_name:"+scenario_name;
			jQuery.post( TargetURL, function( data ) {					
					alert(data);
					
			});  
    });	
	
});


function activesubmit(changedval,dns_id){ 

	var SelectedLoc = changedval.value;
	var CurrId = jQuery(changedval).attr('id'); 
		var val = jQuery('#'+CurrId).val();		
		var RowId = CurrId.substring(1,CurrId.length); 	
		jQuery('#chk'+RowId).removeAttr("class");	
			jQuery('#chk'+RowId).attr("class","changelocation");
		if(val!=''){									
				jQuery('.status'+RowId).html('Edited');	
			}	
	
		jQuery('#savelocation').attr("onclick","javascript:saveDnsLocation(this);");
		jQuery('#savelocation').attr("class","showhighlight_arrow");
		jQuery('#updateOdsentry').removeAttr("class");	
	    jQuery('#updateOdsentry').attr("class","button-right-hover");
	
   }

   
function saveDnsLocation(obj){
$(document).ready(function(){
var senddata = []; 
 jQuery('.changelocation').each(function() { 		
    
		var style = jQuery('.changelocation').attr('style'); 			
			var rowid = jQuery(this).attr('id'); 
			var attrlen = rowid.length;
			var Orowid = rowid.substring(2,attrlen); 
			var Dbrowid = rowid.substring(3,attrlen);
			var Destval =jQuery('#d'+Dbrowid).val();	
			
			senddata.push(Dbrowid+"="+Destval);		
		 
	 });
	 
	 var serialized = senddata.join("&") 
     var customer_id_data = jQuery('#customer_id_data').val();
		var TargetURL = "<?php echo Configure::read('base_url');?>dns/update_location/";
		  jQuery.post( TargetURL, {serialized:serialized, customer_id:customer_id_data}, function( data ) {	
		  
		     var responsedata = data.split('@#');
				for(var i=0; i < responsedata.length; i++){
				  
				    var thislist = responsedata[i];
					
					var selectedrow = thislist.split('**');
					
					var Id = selectedrow[0];
					var status = selectedrow[1];
					
					jQuery('.status'+Id).html(status);			
				}
		    });	
		});
     }

</script>
<script type="text/javascript">

$(document).ready(function(){
jQuery(".space_check").keyup(function () {
		var valueToFind = jQuery(this).val(); 
		jQuery(this).closest("tr").find("a").html(valueToFind);
    });
	
  $('input').keypress(function(event){

        var keycode = (event.which ? event.which : event.keyCode);
        if(keycode == '13'){
            
			

		var dest_code = jQuery(this).val();
		var attrid = jQuery(this).attr('id');
		var attrlen = attrid.length;
		var Odsentryid = attrid.substring(1,attrlen); 
			var TargetURL = "<?php echo Configure::read('base_url');?>scenarios/updateviajQuery/dest_id:"+Odsentryid+"/dest_code:"+dest_code;
		
			jQuery.post( TargetURL, function( data ) {	
			});	
        }
        event.stopPropagation();
    });
});



</script>

<style>
.tablesorter-filter
{
	width:100% !important;
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
	border:none;background-color:#fff;
}
.tablesorter-bootstrap .tablesorter-pager select
{
	width:64px;
	margin:0 20px;
}
.table-top th, .table-right-ohne th
{
	height:35px;
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
border-bottom:#CCCCCC 1px solid !important; border-right: 1px solid #CCCCCC !important;border-top:#CCCCCC 1px solid !important; border-radius:0px !important;	
}

</style>
<script type="text/javascript">
function deleteOdsentry(record_id,elem){
	$.post(base_url+'odsentries/index/'+record_id,{},function(data){
		if(data=="success"){
		    $('#'+record_id).closest('tr').remove();
			alert('Record is deleted successfully');
		}
	});
}
function submit_form(action){
	//alert(action);
	$('.filtersForm').attr('action',base_url+'odsentries/index/'+action);
	$('.filtersForm').attr('method','POST');
	$.ajax({
				type: "POST",
				async : false,
				dataType: 'json',
				url: $('.filtersForm').attr('action'),
				data: $('.filtersForm').serialize(),
				success: function(data){  //alert(data);
					if(data.message=="updated"){
						alert(data.affectedRows+'Record(s) updated successfully')
					}else{
						alert('Some error occured, Please try again');
					} 
				}
	});

}

jQuery(function() { 
	jQuery.extend(jQuery.tablesorter.themes.bootstrap, {
		// these classes are added to the table. To see other table classes available,
		// look here: http://twitter.github.com/bootstrap/base-css.html#tables	
	});

	// call the tablesorter plugin and apply the uitheme widget
	jQuery(".dataTable").tablesorter({
		// this will apply the bootstrap theme if "uitheme" widget is included
		// the widgetOptions.uitheme is no longer required to be set
		theme : "bootstrap",
		widthFixed: true,
		bFilter: false,
		bInfo: false,

		headerTemplate : '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!

		// widget code contained in the jquery.tablesorter.widgets.js file
		// use the zebra stripe widget if you plan on hiding any rows (filter widget)
		widgets : [ "uitheme", "filter", "zebra" ],

		widgetOptions : {
			// using the default zebra striping class name, so it actually isn't included in the theme variable above
			// this is ONLY needed for bootstrap theming if you are using the filter widget, because rows are hidden
			zebra : ["even", "odd"],

			// reset filters button
			filter_reset : ".reset"

			// set the uitheme widget to use the bootstrap theme class names
			// this is no longer required, if theme is set
			// ,uitheme : "bootstrap"
		},
		
		headers: { 
		0: {sorter: false,filter: false},
		5: {sorter: false,filter: false},
		6: {sorter: false,filter: false}

		} 
		
	})
	.tablesorterPager({
		// target the pager markup - see the HTML block below
		container: jQuery(".pager"),

		// target the pager page select dropdown - choose a page
		cssGoto  : ".pagenum",

		// remove rows from the table to speed up the sort of large tables.
		// setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
		removeRows: false,

		// output string - default is '{page}/{totalPages}';
		// possible variables: {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
		output: '{startRow} - {endRow} [{page}] {filteredRows} ({totalRows})'

	});
		
     
	

     jQuery(".smallwidth").focus(function () {
		var valueToFind = jQuery(this).val(); 
		 if(valueToFind=='DN From' || valueToFind=='DN To'){
			jQuery(this).val(''); 
		 } else {
			jQuery(this).val(valueToFind); 
		 }
    });

     jQuery(".smallwidth").focusout(function () {
		var valueToFind = jQuery(this).val(); 
		 if(valueToFind=='' || valueToFind==''){
			 var id= jQuery(this).attr('id');
			 if(id=='min')
			     jQuery(this).val('DN From'); 
			 else if(id=='max')	 
				jQuery(this).val('DN To'); 
		 } 
    });
	
	
	jQuery("#filter_now").click(function () {	
		var MinVal = jQuery('#rangeMinMinval').val();		
		var MaxVal = jQuery('#rangeMaxMaxval').val();	
	
		if((MinVal.length <9 || MinVal.length >9) && (MaxVal.length <9 || MaxVal.length >9)){
			alert('Filter Range From and To Must Be 9 digits!');
			return false;
		} else {
		
			if (isNaN(MinVal) || isNaN(MaxVal)){
				alert('Filter Range must be numeric only!');
				return false;
			} else {		
				jQuery("#form").submit();
			}
		}
	});

	jQuery("#reset_filter").click(function () {
	
		jQuery('#rangeMinMinval').val('');
		jQuery('#rangeMaxMaxval').val('');
		jQuery("#form").submit();
	});
	
     jQuery(".deldest").click(function () {
	    jQuery('input[type="checkbox"]:checked').each(function() { 
			var Odsentryid = jQuery(this).val();
	
			var TargetURL = "<?php echo Configure::read('base_url');?>scenarios/deletedest/dest_id:"+Odsentryid;
			
			jQuery.post( TargetURL, function( data ) {			
				jQuery("#firstchild"+data).parents("tr").hide();
			});	

			jQuery("#firstchild"+Odsentryid).parents("tr").hide();			
		});		

	    jQuery('input[type="checkbox"]:checked').each(function() { 
			jQuery(this).attr("checked", false);				
		});	
    });

	jQuery('.odsentchk').click(function () {	 
        	var noofrecord=0;		
			jQuery('input[type="checkbox"]').each(function() { 				
				if ($(this).is(':checked')) {	
			     noofrecord++;			
			    } 		   
	        });
			
	   $('.cnt').text(noofrecord+": records are selected");
        
    });
	
	
	/*Check All / Uncheck All functionality*/
    jQuery("#checkAll").click(function () {
        if (jQuery("#checkAll").is(':checked')) {	
		
			 jQuery('#content input[type="checkbox"]').each(function() { 
				   var attrid = jQuery(this).attr('id');	
					jQuery('#'+attrid).removeAttr("checked");			 
			 });		
		
              var noofrecord=0;		
			  jQuery('#content input[type="checkbox"]').each(function() { 	
				var CClass = jQuery(this).parents("tr").attr('class');					
				if (CClass.indexOf("filtered") ==-1) { 
					   var attrid = jQuery(this).attr('id');	
						jQuery('#'+attrid).prop("checked", "checked");
						noofrecord++;
			  	}
		   });
		   
		   $('.cnt').text(noofrecord-1+": records are selected");
	
        } else {
			jQuery('input[type="checkbox"]').each(function() {
				jQuery(this).removeAttr("checked");
			});
			 $('.cnt').text("0"+": records are selected");
        }
    });
	
	
	
	 
	
	jQuery('.dosorting').click(function(){
			jQuery('input[type="checkbox"]').each(function() {
				jQuery(this).removeAttr("checked");
			});	
	});
	
 });
 
function saveToLog(action){
	var comment = $('#LogAfterdate').val();
	var scenario_id = '<?php echo $scenario_id; ?>';
	var cust_id = '<?php echo $SELECTED_CUSTOMER; ?>';
	$.post(base_url+"scenarios/validates/"+scenario_id,{'log_entry':action,'comment':comment,'cust_id':cust_id},function(data){ //alert(data);
		if(data){ 
			alert("Scenario "+action);
			if(data=="scenario_accepted"){
				$('#sc_state').text('5');
			}else if(data=="scenario_rejected"){
				$('#sc_state').text('6');
		
			}else if(data=="scenario_validate_requested"){
				$('#sc_state').text('6');
			}
		}
	}); 
 }

</script>

<?php $dnsStatus = Configure :: read('dnsStatus'); ?>
<br/>
<form id="form" class="filtersForm" action="<?php echo Configure::read('base_url');?>dns/edit/customer_id:<?php echo $customer_id;?>" enctype="multipart/form-data" method="POST">    
		<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer_id;?>" />
		<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer_id;?>" />                 					
					<!--<ul style="height:100px; margin-left: 84px;text-align: center;">
						<li >
							<ul class="margin0">

								<li class="clear height80">									
										<h6>Range Filter</h6>
										<fieldset>
											From <?php echo $form->input('rangeMin.minval', array( 'style'=>'margin:4px 4px 5px 8px;', 'label'=>false,'class'=>'filter_range_textbox', 'div'=>false, 'maxlength'=>'9', 'value'=>$rangeMinval));?>
											To <?php echo $form->input('rangeMax.maxval', array( 'style'=>'margin:4px 4px 5px 8px;', 'label'=>false,'class'=>'filter_range_textbox', 'div'=>false, 'maxlength'=>'9', 'value'=>$rangeMaxval));?>
										
										  <div class="showiconsmiddle">
											<div class="button-right" id="filter_now">
												<a id="filter_now" href="javascript:void(0);" onmouseout="javascript:outButtonRight(this);" onmouseover="hoverButtonRight(this);" >Filter</a>
											</div>										

											<div class="button-right" id="reset_filter">
												<a id="reset_filter" href="javascript:void(0);" onmouseout="javascript:outButtonRight(this);" onmouseover="hoverButtonRight(this);" >Clear</a>
											</div>											
										</div>
										
									</fieldset>																
								</li>									
								
							</ul>
						</li>
						</ul>-->
                        
                       <div> 
                        
						<?php 
						echo '<div style="width:200px;padding-left:10px; float: left">' . __('rangeMin', true). '';
						echo $form->input('rangeMin.minval', array( 'style'=>'margin:4px 4px 5px 8px;', 'label'=>false,'class'=>'filter_range_textbox', 'div'=>false, 'maxlength'=>'9', 'value'=>$rangeMinval));	?>		
						</div>
					
						
						<?php 
						echo '<div style="width:200px; float: left">' . __('rangeMax', true). '';
						echo $form->input('rangeMax.maxval', array( 'style'=>'margin:4px 4px 5px 8px;', 'label'=>false,'class'=>'filter_range_textbox', 'div'=>false, 'maxlength'=>'9', 'value'=>$rangeMaxval));	?>		
					</div>
						
				
			
                     </div>   
                        <div class="button-left" id="filter_now">
								<a id="filter_now" href="javascript:void(0);" onmouseout="outButtonRight(this)" onmouseover="hoverButtonRight(this)">Filter</a>
						</div>												
						<div class="button-left" id="reset_filter">
								<a id="reset_filter" href="javascript:void(0);" onmouseout="outButtonRight(this)" onmouseover="hoverButtonRight(this)">Clear</a>
						</div>
					
				<div class="button-right">
					<?php echo $html->link( __("Update Selected", true),array('controller'=>'dns','action' => 'openlocationupdateview/customer_id:'.$customer_id), array('onmouseover'=>'hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);','class'=>"fancybox fancybox.ajax")); ?>
				</div>
		        <input type="hidden" id="customer_id_data" value="<?php echo $customer_id; ?>">


			<div class="clear"></div>
				<ul class="search_btn_area">
				</ul>
				<div class="clear"></div>
				<div class="cnt"style="font-weight:bold">0: records are selected</div>
                <div id="dneditdata">
				<table id="example dnslistdata" class="dataTable phonekey" cellpadding="0" cellspacing="0" style="width:98%; margin-left:5px; border-top-color:#CCC">
				<thead>
				<tr class="table-top" style="border-bottom:#CCCCCC 1px solid; border-right: 1px solid #CCCCCC;border-top:#CCCCCC 1px solid;">
				 <th width="3%" class="table-column table-left-ohne withdatatablecss" >&nbsp;</th>
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
				 <th width="15%" class="table-column table-right-ohne withdatatablecss"><input type="checkbox" name="sAll" id="checkAll" class="showselect"></th>
				 <th width="3%" class="table-right-ohne" style="border-bottom:#CCCCCC 1px solid; border-top:#CCCCCC 1px solid;border-radius:0px !important;">&nbsp;</th>
				 </tr>
				</thead>
				<tfoot>
				<th colspan="8" class="pager form-horizontal">
				<button type="button" class="btn first"><i class="icon-step-backward"></i></button>
				<button type="button" class="btn prev"><i class="icon-arrow-left"></i></button>
				<span class="pagedisplay"></span> <!-- this can be any element, including an input -->
				<button type="button" class="btn next"><i class="icon-arrow-right"></i></button>
				<button type="button" class="btn last"><i class="icon-step-forward"></i></button>
				<select class="pagesize input-mini" title="Select page size">
				    <option selected="selected" value="10">10</option>
					<option value="5">5</option>
					<option value="10">10</option>
					<option value="20">15</option>
					<!--  <option value="30">20</option>  -->
				</select>
				<select class="pagenum input-mini" title="Select page number"></select>
				</th>
				</tr>
				</tfoot>
				 <tbody>
				 <?php 
				 $i=0;
				 
				 foreach ($dns as $res)  {  ?>

				 <tr style="background-color:#FFF; border-bottom:#CCCCCC 1px solid; border-right: 1px solid #CCCCCC;">
				  <td style="background-color:#FFF; border-bottom:#CCCCCC 1px solid;  border-right: 1px solid #CCCCCC;" class="table-left" id="firstchild<?php echo $res['Odsentry']['id']; ?>">&nbsp;</td>
				 <td style="background-color:#FFF; border-bottom:#CCCCCC 1px solid;  border-right: 1px solid #CCCCCC;"><?php echo $res['Dns']['id']; ?></td>
				 <td style="background-color:#FFF;border-bottom:#CCCCCC 1px solid;  border-right: 1px solid #CCCCCC;" id="lkname_<?php echo $res['Dns']['id']; ?>">
                
				 <?php echo $html->link( __($res['Location']['name'], true),array('controller'=>'dns', 'action'=>'create_location/customer_id:'.$customer_id.'/dns_id:'.$res['Dns']['id'].'/location_id:'.$res['Location']['id']), array('class'=>"fancybox fancybox.ajax",'id'=>'')); ?>
				 
				 <?php //echo $res['Location']['name']; ?>
                 <input type="hidden" name="lokname_<?php echo $res['Dns']['id']; ?>" id="lokname_<?php echo $res['Dns']['id']; ?>" value="<?php echo $res['Location']['name']; ?>" />
                 <input type="hidden" name="dnid_<?php echo $res['Dns']['id']; ?>" id="dnid_<?php echo $res['Dns']['id']; ?>" value="<?php echo $res['Dns']['name']; ?>" />
                 </td> 
									
				 <td style="background-color:#FFF; border-bottom:#CCCCCC 1px solid;  border-right: 1px solid #CCCCCC;"><?php echo $res['Dns']['function']; ?>
				 
                 </td>
				 <td style="background-color:#FFF;border-bottom:#CCCCCC 1px solid;  border-right: 1px solid #CCCCCC;"><div class="status<?php echo $res['Dns']['id']; ?>"> <?php echo $dnsStatus[$res['Dns']['status']]; ?></div></td>
				
			 	 
				  <td style="background-color:#FFF; border-bottom:#CCCCCC 1px solid; border-right: 1px solid #CCCCCC; " class="table-right-ohne" align="center" > <input type="checkbox" class="odsentchk"  value="<?php echo $res['Dns']['id']; ?>" id="chk<?php echo $res['Dns']['id']; ?>" style="margin-left:25px;"/> </td>
				  <td style="background-color:#FFF;  border-bottom:#CCCCCC 1px solid;" align="center" >&nbsp;</td>
				 </tr>
				<?php 
				$i++;
				} ?>
				 </tbody>
				 
				</table>
               </div> 
				         <?php //} ?>
                             
                <div class="form-box">
				
				<div class="form-left">
						<?php 
						echo '<div style="width:100px; float: left">' . __('totalCustomerDnsInWork', true). '</div>';
						echo $form->input('totalCustomer', array('type'=>'text' ,'label' => false,'value'=>$custDNCount,'style'=>'width:100px;', 'readonly'=>$readonly));
						 ?>
						 
				</div>
				</div>
				        
                <div class="button-right">
					<?php echo $html->link( __("apply changes", true),array('controller'=>'dns','action' => 'activate/customer_id:'.$customer_id), array('class'=>"fancybox fancybox.ajax")); ?>
				</div>
					
				</div>
<div id="related-content">
        <div class="box start link">
                <a href="#">
                <?php __('Home Swisscom') ?>
                </a>
        </div>
        <div class="box info">
                 <h3><?php __('customerHome') ?></h3>
                 <p>
                  <?php __('customerHome_blurb') ?>
                 </p>
        </div>
		<div class="box call-to-action">
			<h3><?php __("notifications");?></h3>
			<p><?php __("InWork Objects");?>.</p>
			<div>
			<ul>
					
					<?php echo $this->element('right_notifications',array('SELECT_CUSTOMER' => $SELECTED_CNN)); ?>
             </ul>	
			</div>
			<div class="button-right-grey">
				<a href="/portal/index/produkteberatung.htm?thema=2&produkt=15" onmouseover="hoverButtonRightGrey(this)" onmouseout="outButtonRightGrey(this)">Weiter</a>
		</div>
		</div>
		
<!--INTERNAL USER OPTIONS -->
        <?php if($userpermission==Configure::read('access_id'))
        {?>
                <div class="box info">
                <h3><?php __("Internal User");?></h3>
                <p><?php __("Customer View:");?></p>
                <p><?php echo $selected_customer; ?></p>

                </div>
        <?php } ?>


                        <div class="box">
                                <h3 class="red"><?php # __("_infoBox");?></h3>
                                <div class="red">
                                <?php # __('_UpdateInfo');?>
                                </div>
                                </div>



                			
		</div>
        </form>
		<!--right hand side starts from here-->

<!--ight hand side  ends here-->
<script type="text/javascript">
function toggleAdvanceSearch(){
                //$("#advancesearch").show
                if(document.getElementById('advancesearch').style.display=='none'){
                        document.getElementById('advancesearch').style.display='block';
                }else{
                        document.getElementById('advancesearch').style.display='none';
                }

        }
</script>
