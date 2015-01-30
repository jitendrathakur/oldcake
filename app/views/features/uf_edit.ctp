<script>
jQuery(function() {
	$('.choosen').select2();
	//$('.choosen').css("width", "60px");
	jQuery(document).ready(function(){
		 var tt=$("#uftype").val();
		 if(tt=="BLF"){
		 	var stationNumber = $('#StationNUMBER').val();
			//"<?php echo Configure::read('base_url');?>img/assets/btn-expand-highlighted.gif"
			
				$('#plus_schedule').attr('style',"background:url('<?php echo Configure::read('base_url');?>img/assets/btn-expand-highlighted.gif') no-repeat !important;");
		 }
		 if(tt=="AUD"){
		 	$("#editblurb").attr("style","margin-top: -71px; margin-left:10px;text-align: justify;float:right; vertical-align: top;");
		 }
   
		$("#uftype").change(function(){	   
			  var t=$("#uftype").val();
			  if(t=="BLF")
			  {		
				  document.getElementById('blfobservers').style.display='block';
				  document.getElementById('blfval').style.display='block';
				  document.getElementById('audval').style.display='none';
				  $("#StationAUDNUMBER").addClass('hide');
				  $('#button').removeAttr("onclick","");
				  $("#editblurb").removeAttr("style","");
				  $("#editblurb").attr("style","margin-top: -71px; margin-left:10px;text-align: justify;float:right; vertical-align: top;");
				  
				  //expand the number table
				   var stationNo =  $('#StationNUMBER').val();
				  if(stationNo==""){
				  	$('#seldns').css("display","block");
					$('#button').hide();
				  }
				  else{
				  	$('#button').show();
					 $('#updateufedit').attr("class", "button-right-hover");
					 $('#button').attr("class", "showhighlight_buttonleft");  
				  }
			  }
			  else{
				  document.getElementById('blfobservers').style.display='none';
				  document.getElementById('blfval').style.display='none';
				  document.getElementById('audval').style.display='block';
				  $("#StationAUDNUMBER").removeClass('hide');
				   
		          $('#StationLABEL').attr("readonly",false);
		          $('#StationLABEL').attr("onkeyup","chngbkcolor(this)");
		          $('#uftype').attr("readonly",false);			
		          $('#button').attr("disabled",false);
		          $('#button').attr("onclick","submitForm()");
				  $("#editblurb").removeAttr("style","");
				  $("#editblurb").attr("style","margin-top: -71px; margin-left:10px;text-align: justify;float:right; vertical-align: top;");
				  $('#button').show();
				   $('#updateufedit').attr("class", "button-right-hover");
				   $('#button').attr("class", "showhighlight_buttonleft");
		     }
	});	
    });
});
	$(document).keypress(function(e) {
		if (e.which == 15) {
			//$("a#button").trigger('click');
			return false;
		//alert("dfdf");
		}
	});
	validation = {
    	    // Specify the validation rules
    	    'rules': {                     
    	        'StationLABEL':{
    	            'max': '10',
    	        } ,
    	        'StationAUDNUMBER':{
    	            'min': '1',
    	            'max': '30',
    	        }  
                                  
    	    },                  
    	    // Specify the validation error messages
    	    'messages': {  
    	        'StationLABEL': {
    	             'max': "<?php __('max10Chars')?>",
    	         },
    	         'StationAUDNUMBER': {
    	             'min': "<?php __('min1Chars')?>",
    	             'max': "<?php __('max30Chars')?>",
    	         }
    	         
    	    },
    	  };
	function submitForm(){

		validation = {
	    	    // Specify the validation rules
	    	    'rules': {                     
	    	        'StationLABEL':{
	    	            'max': '10',
	    	        } ,
	    	        'StationAUDNUMBER':{
	    	            'min': '3',
	    	            'max': '30',
	    	        }  
	                                  
	    	    },                  
	    	    // Specify the validation error messages
	    	    'messages': {  
	    	        'StationLABEL': {
	    	             'max': "<?php __('max10Chars')?>",
	    	         },
	    	         'StationAUDNUMBER': {
	    	             'min': "<?php __('min3Chars')?>",
	    	             'max': "<?php __('max30Chars')?>",
	    	         }
	    	    },
	    	  };
	    	  if (inValidate(validation)) {
	    		  
	    	    //return false;
	    	  } else {
					$('.black_overlay').css('display','block');
					//$.fancybox.showLoading()  ;
  	  				
					 	$.fancybox.showLoading()  ;
		  				$('.ufForm').attr('action',base_url+'features/updateUF/<?php echo $stationkey_id;
					  ?>');
					  
		  						$('.ufForm').attr('method','POST');
								
								
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
	                                  url: $('.ufForm').attr('action'),
	                                  data: $('.ufForm').serialize(),
	                                  success: function(result){
	                                	  location.href =  location.href;
	                                  }
				                  });
				              
				              //location.href = base_url+'stations/editstation/444034944'
	    	  }
	}


	function selectdns(){
		var checkboxes = $('form').find(':radio:checked');
        DN_id = checkboxes.val();
		//alert("kk"+DN_id);
		$("#StationNUMBER").val(DN_id);
		$("#blfnumber").val(DN_id);
		$("#seldns").hide();
		$('#button').attr("class", "showhighlight_buttonleft");
		  $('#updateufedit').removeAttr("class");
		  $('#button').removeAttr("onmouseover");
		  $('#button').removeAttr("onmouseout");
		  $('#updateufedit').removeAttr("class");
		  $('#updateufedit').attr("class", "button-right-hover");
		  $('#StationLABEL').attr("readonly",false);
		  $('#StationLABEL').attr("onkeyup","chngbkcolor(this)");
		  $('#uftype').attr("readonly",false);			
		  $('#button').attr("disabled",false);
		  $('#button').attr("onclick","submitForm()");
		  $('#button').show();
		  
		  //show hide expand collapse
		  $('#pbtn_schedule').show();
            $('#minus_schedule').hide();
            $('#mbtn_schedule').hide();
            $('#plus_schedule').show();	
		  
		   var tt=$("#uftype").val();
		 if(tt=="BLF"){
		 	var stationNumber = $('#StationNUMBER').val();
				$('#plus_schedule').attr('style',"background:url('<?php echo Configure::read('base_url');?>img/assets/btn-expand-highlighted.gif') no-repeat !important;");			
		 }
		                   
	}
      
	function chngbkcolor(obj) {
	  $(document).ready(function() {
	  var ufType =	$('#uftype').val();
	  var stationNo =  $('#StationNUMBER').val();
	  
	  
	  if(ufType=="BLF" && stationNo!=""){
	  	
		 $('#button').attr("class", "showhighlight_buttonleft");
		  $('#updateufedit').removeAttr("class");
		  $('#button').removeAttr("onmouseover");
		  $('#button').removeAttr("onmouseout");
		   $('#button').attr("onclick","submitForm()");
		  $('#updateufedit').removeAttr("class");
		  $('#button').attr("class", "showhighlight_buttonleft");
		  $('#updateufedit').attr("class", "button-right-hover");
	  	
	  }
	  
		if(ufType=="AUD" ){
	  	
		 $('#button').attr("class", "showhighlight_buttonleft");
		  $('#updateufedit').removeAttr("class");
		  $('#button').removeAttr("onmouseover");
		  $('#button').removeAttr("onmouseout");
		   $('#button').attr("onclick","submitForm()");
		  $('#updateufedit').removeAttr("class");
		  $('#button').attr("class", "showhighlight_buttonleft");
		  $('#updateufedit').attr("class", "button-right-hover");
	  	
	  	
	  }
		
		 
	  });
	//called when key is pressed in textbox
    $("input.numeric_check").keypress(function(e) {	
      if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57) && e.which!=13)
      {        
        $('#overlay-error .error .message').text("<?php __('digitsOnly') ?>");
        $('#overlay-error').removeClass('hide');
        return false;
      } else {	      	
      		//$("input").keydown(function() {
	          inValidate(validation, 'keyup');                    
	        //});	       
      }
    });
  }
</script>

<script type="text/javascript">
    $(document).ready(function() {

       $('#minus_schedule').hide();
        $('#mbtn_schedule').hide();		
	    $('#minus_schedule').click(function() {
			 $('#button').show();
            $('#pbtn_schedule').show();
            $('#minus_schedule').hide();
            $('#mbtn_schedule').hide();
            $('#plus_schedule').show();			
        });

        $('#plus_schedule').click(function() {
			 $('#button').hide();
            $('#pbtn_schedule').hide();
            $('#minus_schedule').show();
            $('#mbtn_schedule').show();
            $('#plus_schedule').hide();
        });

    });

</script>
<script>
function dispselectdns(val){	
	if(val=='dispdns') {			
			$("#seldns").slideToggle("slow");
			$('#StationLABEL').attr("readonly",true);
			$('#StationLABEL').removeAttr("onkeyup","");
			$('#uftype').attr("readonly",true);			
			$('#button').attr("disabled",true);			
			$('#button').removeAttr("onclick","");
			$('#updateufedit').removeAttr("class");
		    $('#button').removeAttr("class", "showhighlight_buttonleft");
		    $('#updateufedit').attr("class", "button-right-disabled");
	}	
}

</script>


<script type="text/javascript">

jQuery(document).ready(function() {
    $('.selectdnsCheckbox').click(function() {
		
		var checkboxes = $('form').find(':radio:checked');
        DN_id = checkboxes.val();		
		
		$('.ufForm').attr('action',base_url+'features/updateobserver/'+DN_id);
		  						
		  						$('.ufForm').attr('method','POST');
				                  $.ajax({
	                                  type: "POST",	                                  
	                                  url: $('.ufForm').attr('action'),
	                                  data: $('.ufForm').serialize(),
	                                  success: function(result){									  	
	  									$("#ajaxload").html(result);
	                                  }
				                  });
		
        var p = $(this).val();
        jQuery('input[type="radio"]').each(function() {
            if ($(this).val() == p)
            {
                $(this).prop('checked', true);				
            }
            else {
                $(this).prop('checked', false);
            }
					$('#dnsbutton').attr("class", "showhighlight_buttonleft");
					$('#dnsbutton').attr("onclick", "selectdns()");
				
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
        					

                });

	});
	
	
	
	
	
	
	
	
</script>

<style>
.table-menu-popup {
    display: none;
    float: left !important;
    margin-left: -24px;
    margin-top: 5px;
    padding: 0;
    position: absolute;
}
.table-menu-popup li {
  
    position: relative;
    text-align: left;
    margin: 0;
    padding: 0;
    width: 13px;
}
.fancybox-inner{
	height: auto !important;
    overflow: auto;
   
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
	
</style>

<?php

$user_agent = $_SERVER['HTTP_USER_AGENT']; 
if (preg_match('/MSIE/i', $user_agent)) { 
	$top = "40";					
}else{
							
$top = "58";						
 }
if (preg_match('/Firefox/i', $user_agent)) { 
						  
$top = "40";						 
}


?>
<?php 
#DIWAKARTEST
#if(!empty($features)){
	if(1){
	echo $form->create('Station', array(
                                'action' => 'updateUFFeatures',
                                'id' => 'Station',
                                'class' => 'ufForm',
                                'type' => 'POST',
								'accept-charset' => 'ISO-8859-1',
								'invalidate' => 'invalidate'
));

	#echo $form->create(null, array('id' => 'featureEditForm', 'url' => '/features/update/'.$features[0]['Feature']['id'],'accept-charset'=>'ISO-8859-1'));
	?>	
	
	
	<div class="black_overlay" style="height: 100%; width: 100%; display: none;">
				<!--<div id="black_overlay_loading" class="loading">
				<img alt="" src="<?php echo Configure::read('base_url');?>img/assets/ajax-loader.gif">
				</div>-->
	</div>
	<div class="block top">
	
	<div style="height: 55px">
		<div id="overlay-error" class="notification first hide" style="width: 100%" >
		
			<div class="error">
				<div class="message">
					
				</div>
			</div>
		</div>

<?php if((isset($success)) && $success){?>
	
		<div class="notification first" style="width: 534px" >
		
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
							__("Xml Server is not responding");
						else
							__($error);
					?>
				</div>
			</div>
		</div>
		
	<?php }
		else
		{
			echo '<br>';
		}
		?>
				<!--CBM ADDED BUTTONS TO TOP-->
			    <fieldset>
                   <fieldset style="display:none;">
                   <input type="hidden" name="_method" value="PUT" />
                </fieldset>
         </div>

           </fieldset>
	<div id="newEdit">
	
			<?php //if (array_key_exists('AUD', $features))
			if ($featureType=="AUD")
			{
				$displayAUD = 'block';
				$classAUD = '';
				$selected = 'AUD';
				$displayBLF = 'none';
				$buttondisabled ='button-right';
				$style = 'style="margin-top: -71px; margin-left:10px;text-align: justify;float:right; vertical-align: top;"';
			}
			else {
				$displayBLF = 'block';
				$classAUD = 'hide';
				$selected = 'BLF';
				$displayAUD = 'none';
				$buttondisabled ='button-right-disabled';
				$style = 'style="margin-top: -71px; margin-left:10px;text-align: justify;float:right; vertical-align: top;"';
			}
			
			$d = explode("@",$stationkey_id);
			
			?><h4><?php echo __('featureEdit')?> <?php echo $d[0]; ?> &nbsp;<?php echo __('onStation')?> <?php echo $d[1]; ?><?php echo __('featureEditEnd')?>
			
		<div class='demonstrations'>
            <div  style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick=" UnTip(); setTimeout( function() {$('.fancybox-overlay').trigger('click'); },5);">X</a></div>
	        <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onclick="Tip('<b><?php echo __('ufEdit_helpTitle') ?></b><br/><?php echo __('ufEdit_hlepText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>		
 		</div>
		  </h4>
			<div class="form-body">
			
				<div class="form-box">
				  <div class="form-left table-menu">
				    <div style="width:100px; float: left" ><?php echo __('ufLabel')?></div>
					<div class="table-menu-popup" style="z-index: 1">
                    	<ul>
						  <li  style="width: 13px!important; margin-top: 0px!important;"><a href="javascript:;" onclick="Tip('<?php echo __('ufLabel_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li>
						</ul>
                    </div>
					<?php echo	$form->input('LABEL', array('label' => false,'onkeyup'=>'chngbkcolor(this)','value'=>$features[$selected]['label'],'style'=>'width:100px;'));	?>		
				  </div>
				</div>
				<div class="form-box">
				<div class="form-right table-menu" style="margin-top: 5px;">
					<div style="width:100px; float: left"><?php echo __('ufType')?></div>
					<div class="table-menu-popup" style="z-index: 1">
                    	<ul>
						  <li  style="width: 13px!important; margin-top: 0px!important;"><a href="javascript:;" onclick="Tip('<?php echo __('ufType_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li>
						</ul>
                    </div>
					<?php 
					
					$aud	= __(AUD,true);
					$optblf 	= __(BLF,true);
					   #echo $form->input('Language', array('value'=>$features['LANG']['primary_value'], 'style'=>'width:200px;','onchange'=>"javascript:submi_form('filters');"));
					   #echo $form->input('Language', array('label' => false,'type'=>'select', 'options'=>$languageOptions, 'default'=>'somegroup',array('style'=>'width:200px;'),'style'=>'width:20px;'));
					   echo $form->input('TYPE', array('label' => false,'type'=>'select', 'options'=>array('AUD'=>$aud,'BLF'=>$optblf), 'id'=>'uftype', 'default'=>$featureType,array('style'=>'width:200px;'),'style'=>'width:106px;', 'onkeyup'=>'chngbkcolor(this)')); 
					 ?>
		
					</div>
				</div>
				<div class="form-box">
				<div id='audval' class="form-left table-menu" style="display:<?php echo $displayAUD ?>; width: 235px;margin-top: 5px;">
					<div style="width:100px; float: left"><?php echo __('numberAud')?></div>
					<div class="table-menu-popup" style="z-index: 1">
                    	<ul>
						  <li  style="width: 13px!important; margin-top: 0px!important;"><a href="javascript:;" onclick="Tip('<?php echo __('numberAud_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li>
						</ul>
                    </div>
					<?php 
					echo	$form->input('AUD_NUMBER', array('label' => false,'value'=>$features['AUD']['primary_value'],'style'=>'width:100px;','class'=>'numeric_check '.$classAUD,'onkeyup'=>'chngbkcolor(this)'));	?>						
				</div>
										
				</div>
				<div class="form-box">
			      <div id='blfval' class="form-left table-menu" style="display:<?php echo $displayBLF ?>; width: 235px;">
				    <!--<div style="width:100px; float: left"><?php echo __('numberBlf')?></div>-->					
					 				
					<div style="width:100px; float: left" ><?php echo __('NUMBER_BLF'); ?></div>					
					<?php echo	$form->input('NUMBER', array('label' => false,'value'=>$features['BLF']['primary_value'],'style'=>'width:100px;','readonly'=>true));	
					#echo $form->input('BLF_NUMBER', array('label' => false,'type'=>'select', 'options'=>$blfDns, 'id'=>'uftype', 'default'=>$features['BLF']['primary_value'],'onkeyup'=>'chngbkcolor(this)', 'class' => 'choosen', 'style'=>'width:100px;')); 
					?>
					
					<div class="table-menu-popup" style="z-index: 1">
                    	<ul>
						  <li  style="width: 13px!important; margin-top: 0px!important;"><a href="javascript:;" onclick="Tip('<?php echo __('numberBlf') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li>
						</ul>
                    </div>
					<input type="hidden" name="data[Station][BLF_NUMBER]" id="blfnumber" value="<?php echo $features['BLF']['primary_value']; ?>">
					 <a  href="javascript:;" style="cursor:pointer"  onclick="dispselectdns('dispdns')"  title="">
					     <div style="width:20px; height:20px;float:right" id="pbtn_schedule"  >
				             <div id="plus_schedule"></div>
				         </div>
				         <div style="width:20px; height:20px;display: none;float:right" id="mbtn_schedule" >
				             <div id="minus_schedule"></div>
				         </div>
	  				</a>
					<br/>
	  				<a  href="javascript:;" style="cursor:pointer;margin-top:-10px;margin-right:5px;float:right" onMouseOver="Tip('<?php echo __('Select BLF Number') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()"  title="">...</a>  
								
					
				<br/><br/><br/><br/>
				
			
		 <div id="seldns"  style="display: none; width: 500px!important;">
			 <h4 style="width: 100%"><?php echo __('Select Observed Number'); ?></h4>		
			 <div  class="table-content" >
                <div class="pagerlocationedit form-horizontal" style="margin:0 !important; float:left" >
                 <?php echo __("totalEntries")?> <span class="countdisplay"></span> <?php echo __("entriesPerPage"); ?>: 
                    <select class="pagesize input-mini" title="Select page size" style="float: right; width: 50px;">
                        <option selected="selected" value="10">10</option>
                        <option selected="selected" value="25">25</option>
                        <option selected="selected" value="50">50</option>
                        <option selected="selected" value="100">100</option>
                    </select>
                </div>
                <table id="exampleSingle" class="phonekey dataTable cust_tab_pag">
                   <thead> 	
                     <tr class="table-top">
                        <!--<th class="table-column table-left-ohne">&nbsp;</th>-->
                        <th class="table-column table-left-ohne filter-false" style="border-left: 1px solid #D1D1D1!important;"><p style="position: relative;top:<?php echo $top; ?>px;"><?php echo __('Filter'); ?></p>&nbsp;</th> 
                        <th class="table-column" style="width:30px!important;text-align: left;"><?php echo __("blfDn", true); ?></th>
                        <th data-value="<?php echo $dnsLocationName; ?>"  class="table-column filter-select filter-exact "style="width:165px!important;text-align: left;" ><?php echo __("Location", true); ?>
							
							
						</th>
                        <th class="table-column"style="width:90px!important;text-align: left;"><?php echo __("DISPLAYNAME", true); ?></th>
                        <!--<th class="table-right-ohne">&nbsp;</th>--> 
                     </tr>
                   </thead>
                   <tfoot >
   					 <th colspan="4" class="pagerlocationedit form-horizontal" style="border-bottom:1px solid #F9F9F9 !important;border-left:1px solid #F9F9F9 !important;border-right: 1px solid #F9F9F9 !important;">
                        <span><a class="first" href="javascript:;">&lt;&lt;</a></span>
                        <span><a class="prev" href="javascript:;">&lt;</a></span>
                        <span><?php  __('Page'); ?></span>
                        <select class="pagenum input-mini hide" title="Select page number"></select>
                        <span class="pagedisplay"></span> <!-- this can be any element, including an input -->			
                        <span><a class="next" href="javascript:;">&gt; </a></span>
                        <span><a class="last" href="javascript:;">&gt;&gt; </a></span>
                    </th>
                   </tfoot>
                   <tbody>
                      <?php
                         // initialise a counter for striping the table
                         $count = 0;
                         // loop through and display format
                         foreach ($results as $dn){								
                           // stripes the table by adding a class to every other row
                           $class = ( ($count % 2) ? " class='altrow'" : '' );
                           // increment count
                           $count++;
						                          ?>
                     <tr onmouseover="hoverRow(this, true);" onmouseout="hoverRow(this, false); " >
                          <!--<td class="table-left">&nbsp;</td>-->
                          <td>     
					    	<input style="margin-left:10px !important"  type="radio" class="selectdnsCheckbox <?php echo $dn['Dns']['id'] ?>" name="selectdnsCheckbox[]" value="<?php echo $dn['Dns']['id'] ?>"  />
                          </td>
                          <td ><?php echo $dn['Dns']['id']; ?></td>
                          <td  style="width:110px !important;"> <?php echo $dn['Location']['name']; ?> </td>                              
                          <td  style="width:80px!important;"><?php echo $dn['Dns']['display']; ?></td>
                          <!--<td class="table-right-ohne">&nbsp;</td>-->
					</tr>
                      <?php                      
                        }                    
                      ?> 
                   </tbody>
                </table>              
              </div>	
			  <div class="button-right-disabled" id="updatedns">
                            <a id="dnsbutton" href="javascript:;"   name="submitForm" value="submitForm"  ><?php __("add"); ?></a>
                     </div> 			
			</div>
			
		</div>
				<div class="form-right" id="editblurb" <?php echo $style; ?> >
				  <p><?php echo __('ufEdit_blurb')?></p>
				  <?php if(!(isset($error) && $error)){?>
						 <div class="<?php echo $buttondisabled; ?>" id="updateufedit">
						 <!--onclick="submitForm()"-->
               		    <a id="button" href="javascript:;"  value="submitForm"  ><?php __("Submit"); ?></a>
              		   </div>
                  <?php }?>
				</div>
			 </div>
		<br/>
		<div id="blfobservers" class="form-box" style="display:<?php echo $displayBLF ?>">
		<h4><?php __('observerSection'); ?></h4>
		  <div id="ajaxload" class="table-content main_table_content">
	        <table class="phonekey" id="NOTdragdroptbl" width="400px!important">
			  <thead>
			    <tr class="table-top">
				  <!--<th class="table-column" style="width:20px;">&nbsp;</th>-->
				  <th class="table-column" style="width:120px;text-align: left;">&&nbsp;<?php echo __('Label')?>&nbsp;&nbsp;</th>
				  <th class="table-column" style="width:90px!important;text-align: left;">&nbsp;<?php echo __('BLF Number')?>&nbsp;&nbsp;</th>
				  <th class="table-column" style="width:90px!important;text-align: left;">&nbsp;<?php echo __('Stations')?>&nbsp;&nbsp;</th>
				  <th class="table-column" style="width:20px;text-align: left;">&nbsp;<?php echo __('Key')?>&nbsp;&nbsp;</th>
				  <th class="table-column " style="width:20px;text-align: left;">&nbsp;<?php //__('Options'); ?>&nbsp;&nbsp;</th>
 				  <!-- <th class="table-column" style="width:20px;">&nbsp;</th>-->
			    </tr>
			  </thead>
			  <tbody>
	            <?php
			    foreach($observers as $observer):
				 #echo "<pre>";print_r($observer);
				 ?>
	            <tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">
	              <!-- <td class="table-left">&nbsp;</td> -->
				  <td><?php echo $observer['Feature']['label']?></td>
				  <td><?php echo $observer['Feature']['primary_value']?></td>
	              <td><?php echo $observer['Stationkey']['station_id']?></td>
             	  <td><?php echo $observer['Stationkey']['keynumber'];?></td>
	              <td class="table-right-ohne" style="background: url(<?php
    			    echo $this->webroot;
					?>/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat 3px 5px; border-right: 1px solid #D1D1D1!important;" onmouseout="this.className='table-right';" id="<?php
     				echo $sta_id;
					?>tdlast" >
					  <div class="table-menu ">
         			    <div class="table-menu-popup" style="z-index: 1;margin-left: 10px;  margin-top: -10px;">
        			      <ul style="width: 100px;">
					        <li class="last log" style=" border-left:1px solid #001155!important;border-right: 1px solid #001155!important;border-top: 1px solid #001155!important;width: 200px;">
							  <?php echo $html->link( __("linkToCoobserver", true),array('controller'=>'stations','action'=>'editstation',$observer['Stationkey']['station_id'])); ?>
					        </li>
					      </ul>	
					    </div>
					  </div>
					</td>
	            	</tr>
	            	<?php 
	           endforeach; ?>
	          </tbody>
	        </table>
		  </div> 
		</div>
	  </div>
    </div>
  </div>	
	<?php }?>
   <!--ight hand side  ends here-->
</form>

<?php   exit; ?>