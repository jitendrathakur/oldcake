<script>
jQuery(function() {

	$('.choosen').select2();
});

</script>

<?php
$user_agent = $_SERVER['HTTP_USER_AGENT']; 
if (preg_match('/MSIE/i', $user_agent)) { 
$top = "-135";
$buttontop = "90";
}
else{
$top = "-130";	

}
if (preg_match('/Firefox/i', $user_agent)) { 
       $top = "-166";		
       
    }
?>


<!--<meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="expires" content="0">-->


<style>
.form-label:hover .table-menu-popup {
	 display: block;
}

.table-menu-popup {
    display: none;
    float: left !important;
    margin-left: -24px;
    margin-top: 3px;
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
    width: 80px!important;
}
.greyed {
    background-color: #FF0000!important;
}
.reapply{
  	color:#fff !important;
	background-position: 0 -108px;
    cursor: pointer;
    left: 48%;
    margin-left: -22px;
    margin-top: -22px;
    position: fixed;
    top: 42%;
    z-index: 8060;
	font-weight:bold;
  }

</style>
<script>
$(document).ready(function(){
	
	   $('#collapse').hide();                                                   
		$('#button').removeAttr("onclick","");
		$('#button').attr("onclick","noinfo()");
	
	
});
</script>

<script>
	function noinfo(){
				
		//$('#overlay-error .error .message').text("<?php __('no changes entered') ?>");
		//$('#overlay-error').removeClass('hide');
		
		//window.parent.document.getElementById('overlay-error").hide();
		window.parent.$("#overlay-error").delete();
	}
</script>
<script type="text/javascript"> 
    $(document).ready(function() { //alert("ret");

    	$(document).keypress(function(e) {
    		if (e.which == 13) {
    			$("a#button").trigger('click');
    			return false;
    			//alert("dfdf");
    		}
    	});

        
	});
    validation = {
    	    // Specify the validation rules
    	    'rules': {                     
    	    	  
    	        'StationDISPLAYNAME':{
    	            'spclChar': true,
    	            'max': '12'
    	            //'max': '30'
    	        },  
    	        'StationCFBNUMBER':{
    	            'max': '30'
    	        },
    	        'StationCFUNUMBER':{
    	            'max': '30'
    	        },
    	        'StationCFNANUMBER':{
    	            'max': '30'
    	        },     
    	        'StationCFBSTATUS' : {
    	        	'isValue' : 'StationCFBNUMBER',
					'beforeCheck' : 'StationCFBNUMBER'
    	        },     
    	        'StationCFUSTATUS' : {
    	        	'isValue' : 'StationCFUNUMBER',
					'beforeCheck' : 'StationCFUNUMBER'
    	        },     
    	        'StationCFNASTATUS' : {
    	        	'isValue' : 'StationCFNANUMBER',
					'beforeCheck' : 'StationCFNANUMBER'
    	        }                              
    	    },                  
    	    // Specify the validation error messages
    	    'messages': {  

   	         	 
   	         	'StationDISPLAYNAME': {
    	             'spclChar': "<?php __('Special characters are not allowed')  ?>",
    	             'max': "<?php __('max12')  ?>"
    	         },  
    	         'StationCFBNUMBER': {
    	             'required': "<?php __('Please enter CFB')?>",
    	             'max': "CBF Number length must not be greater than 30 digits"
    	         },
    	         'StationCFUNUMBER': {
    	             'required': "<?php __('Please enter CFU')?>",
    	             'max': "CBF Number length must not be greater than 30 digits"
    	         },
    	         'StationCFNANUMBER': {
    	             'required': "<?php __('Please enter CFNA')?>",
    	             'max': "CBF Number length must not be greater than 30 digits"
    	         },
    	         'StationCFBSTATUS': {
    	             'isValue': "<?php __('__CFBcannotActivateBlank')?>",
					 'beforeCheck': "<?php __('__CFBcannotActivateBlank')?>"     
    	         },
    	         'StationCFUSTATUS': {
    	             'isValue': "<?php __('__CFUcannotActivateBlank')?>",
					'beforeCheck': "<?php __('__CFUcannotActivateBlank')?>"     					 
    	         },
    	         'StationCFNASTATUS': {
    	             'isValue': "<?php __('__CFNAcannotActivateBlank')?>",
					 'beforeCheck': "<?php __('__CFNAcannotActivateBlank')?>"     
    	         }        
    	    },
    	  };
</script>


<script>

function reapply(){
	
	var TransactionID= $("#transactionId").val();
	var stationId= $("#stationId").val();
	//var logId= $("#logId").val();
		var url = "<?php echo Configure::read('base_url');?>stations/reapplyTransaction/station_id:"+stationId+"&transaction_id="+TransactionID;
		//$('.black_overlay').css('display','block');
        $.fancybox.showLoading();
		window.location.href=url;
	}
function submitForm(){
	
  //$(".loading").html('<img alt="" src="<?php echo Configure::read('base_url');?>img/assets/ajax-loader.gif">');
					 
  if (inValidate(validation)) {  	
    return false;
  } else {
	  $('.black_overlay').css('display','block');
	  $.fancybox.showLoading();
  
   	var groupid =  $('#grpid').val();
	var groupdesc =  $('#StationGroupDesc').val();
	  
	var TargetURL = "<?php echo Configure::read('base_url');?>features/updateGroupDescription/group_id:"+groupid+"/groupdesc:"+groupdesc;
			 
			 //jQuery.post( TargetURL, {'group_id':groupid, 'groupdesc':groupdesc}, function( response ) {
			 	//location.reload(false);
			 	//});
  
  

   
	 // $('.black_overlay').css('display','block');
      $('.dnForm').attr('action',base_url+'features/updateDN/<?php echo $stationkey_id;?>');
      $('.dnForm').attr('method','POST');
	  $.fancybox.showLoading()  ;
	  
	  //checking browser of ajax submit behavoir
	var asyncronation;
	var typedata;
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
        url: $('.dnForm').attr('action'),
        data: $('.dnForm').serialize(),
        success: function(result){	
		
		var resultData = result.split('-');
		var reapplyFlag = resultData['0'];
		var transactionId = resultData['1'];
		var stationId = resultData['2'];
           
		  
		if(trim(reapplyFlag)=="REAPPLY"){
			 TransactionID= $("#transactionId").val(transactionId);
	         stationId= $("#stationId").val(stationId);
	        //logId= $("#logId").val('');
			 $('.black_overlay').css('display','none');
			 $("#fancybox-loading").hide();
			 $('#clickerId41').trigger("click")
			 $('#clickerId41').attr('onclick','reapply()');
			 $('#modalPopLite-mask10').hide();
			
		}
		else{
			 $('#clickerId41').attr('onclick','');
			$(".fancybox-overlay").hide();
			$("#fancybox-loading").hide();
        	location.href =  location.href;
		}
			
        }
    });

	
  }   

}//end submitForm
		 $('.numeric_check').bind( "click keyup keydown", function() {
				//alert($(this).attr('readonly'));
				if($(this).attr('readonly') == "readonly"){
					$(this).off("click");
					$(this).attr('style','outline: 0px solid #1047e0 !important;');
				}
		});
		  function chngbkcolor(obj) {
		  	
			  $(document).ready(function() {
			  var readOnly = $(obj).attr('readonly');
			  if(readOnly != "readonly"){

				  $('#button').attr("class", "showhighlight_buttonleft");
				  $('#updateStation').removeAttr("class");
				  $('#button').removeAttr("onmouseover");
				  $('#button').removeAttr("onmouseout");
				  $('#updateStation').attr("class", "button-right-hover");
				  $('#button').attr("onclick","submitForm()");
				  
				  }
			  });

			//called when key is pressed in textbox
			    $("input.numeric_check").keydown(function(e) {
			    	
	//if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57) && e.which!=13 && e.which!=17 &&e.which!=86 &&e.which!=37 && e.which!=39 && e.which!=67)
	 //if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57) && e.which!=13)
	 
	 if( 
      	e.which!=8 && 
      	e.which!=0 && 
      	(e.which<48 || e.which>57) && 
      	e.which!=13 && 
      	e.which!=118 &&
      	(e.which<96 || e.which>106) &&
      	e.which!=37 &&
      	e.which!=39 &&
      	e.which!=17 &&
      	e.which!=67 &&
		e.which!=86 &&
		e.which!=88 &&
      	e.which!=46      	
      	)
			      {        
			        $('#overlay-error .error .message').text("<?php __('digitsOnly') ?>");
					
					//window.parent.$("#overlay-error").delete();					
					//	window.parent.document.getElementById('HiddenFieldState");

			        //$('#overlay-error').removeClass('hide');
			        return false;
			      } else {
			      		//$("input").keydown(function() {
				          //inValidate(validation, 'keyup');                    
				        //});		
			      }
			    });
		  }
	
	//By creating tooltips after DOM load we make sure that referenced elements are available.
		
		// toggle show and hide observe list
		
		function toggleShowObserve(){
			
         	//$("#advancesearch").show
         	if(document.getElementById('blfobservers').style.display=='none'){
         		document.getElementById('blfobservers').style.display='block';
				
				$('#expand').hide();
             	$('#collapse').show();
				
         	}else{
         		document.getElementById('blfobservers').style.display='none';
				
				$('#expand').show();
             	$('#collapse').hide();
         	}
         }
</script>
	<script type="text/javascript">
	
	    function toggleAdvanceSearch() {
        //$("#advancesearch").show
        if (document.getElementById('advancesearch').style.display == 'none') {
            document.getElementById('advancesearch').style.display = 'block';
        } else {
            document.getElementById('advancesearch').style.display = 'none';
        }
    }
    function toggleShowHistory() {
        //$("#advancesearch").show
        if (document.getElementById('showhistory').style.display == 'none') {
            document.getElementById('showhistory').style.display = 'block';
        } else {
            document.getElementById('showhistory').style.display = 'none';
        }
    }
    function toggleexecutionschedule() {
        //$("#advancesearch").show
        if (document.getElementById('showexecution').style.display == 'none') {
            document.getElementById('showexecution').style.display = 'block';
        } else {
            document.getElementById('showexecution').style.display = 'none';
        }

    }
    function toggleodsentries() {
        //$("#advancesearch").show
        if (document.getElementById('showods').style.display == 'none') {
            document.getElementById('showods').style.display = 'block';
        } else {
            document.getElementById('showods').style.display = 'none';
        }

    }
	
	/*
    $(document).ready(function() {

        $('#minus').hide();
        $('#mbtn').hide();

        $('#minus').click(function() {
            $('#pbtn').show();
            $('#minus').hide();
            $('#mbtn').hide();
            $('#plus').show();
        });

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

        $('#minus_ods').hide();
        $('#mbtn_ods').hide();

        $('#minus_ods').click(function() {
            $('#pbtn_ods').show();
            $('#minus_ods').hide();
            $('#mbtn_ods').hide();
            $('#plus_ods').show();
        });

        $('#plus_ods').click(function() {
            $	('#pbtn_ods').hide();
            $('#minus_ods').show();
            $('#mbtn_ods').show();
            $('#plus_ods').hide();
        });
    });
   */
</script>

<style type="text/css">
/* CSS for modelpopup */
     
 #clicker41 {	cursor:pointer;	}

#popup-wrapper41{
	width:390px;
	height: auto;
    padding: 10px 10px 40px;
	background-color:#F9F9F9;
	
}
	
body
{
    padding:10px;
}
		
.demonstrations1 div {
  float: right;
  width: 20px;
  height: 30px;
  margin: -19px 0 5px!important;
  cursor: pointer;
  font-size: 15px;
  font-weight: bold;
}
.modalPopLite-mask2 {
    background-color: #f;
    left: 0;
    position: absolute;
    top: 0;
    z-index: 9994;
}
	</style>

<script>
	$(function () {
		$('#popup-wrapper41').modalPopLite({ openButton: '.clicker41', closeButton: '#close-btn41', isModal: true });
		
	});

    function fancyboxclose2(){
		setTimeout( function() { $('#close-btn41').trigger('click'); },5);
		
	 	}
		
		
		function initTrunkId(trunkIDetails){
		
	     }
	function deleteTrunk(trunkIDetails){
		
	
		alert("checking");
		
	}	
	$(document).ready(function(){
		$('#close-btn41').click(function(){
			
		//$(".fancybox-overlay").hide();	
			
		});
		                   
		
		});
	
</script>




<div>		

	<div id="modalPopLite-mask4" style="width:100%;z-index: 1;"  class="modalPopLite-mask"></div>
	<div id="modalPopLite-wrapper" style="left: -10000px;z-index: 100000000000000000000000000000; " class="modalPopLite-wrapper">
		<div class="modalPopLite-child" id="popup-wrapper41" >
		<div class="black_overlay" style="display: none;"></div>
		<h4><?php echo __('Confirmation',true); ?>
		<span class='demonstrations1' style="display: block!important; " >           
				<span style="font-size: 18px !important;margin-top: -17px; float: right;"> <a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); return fancyboxclose2(); " >X</a>	</span>  
				<span style="font-size: 18px !important;margin-top: -17px; float: right;margin-right: 10px;"><a href="javascript:;"  style="cursor:pointer;margin-top: 5px;" onMouseOver="Tip('<b><?php echo __('reapplyTransaction_helpTitel') ?></b><br/><?php echo __('reapplyTransaction_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a>	</span>		
			</span>
 </h4>
			<span style="width:388px; height:150px;margin:15px auto;  ">
			<h6><?php 
			
				echo __( wordwrap('Do you want to reapply ?',62,"<br>\n"));
			
			?></h6> <br>
			
				
			
				<span class="button-left" style="margin:2px 230px 11px !important" >
				
				<?php echo $html->link( __("Cancle", true),'javascript:void()',array('id' => 'close-btn41')); ?>
				
				</span>
				<a href="#" id="close-btn41">	</a>
					
				<span  class="button-right" style="margin:-35px 2px 10px !important" >
				
				<?php echo $html->link(__("Reapply", true), 'javascript:void();', array('onclick'=>'', 'class'=>'clicker41','id'=>'clickerId41')); ?>
				
				</span>
					
			</span>		
		</div>
			
	</div>

</div>

<?php 
if($featureType=='DN_INDIVIDUAL'){
				$titletag = __("dnEditIndividual",true);
				$ftop = "-20";
			}
			if($featureType=='DN_MADN_PILOT'){
				$titletag = __("dnEditPilot",true);
				$ftop = "-20";
			}
			if($featureType=='DN_MADN'){
				$titletag = __("dnEditMember",true);
				$ftop = "0";
			}
			if(($featureType=="DN_MADN") && (isset($spg))){
				$titletag = __("dnEditGroup",true);
				$ftop = "0";
			}
			if($featureType=='DN_XLH_PILOT'){
				$titletag = __("dnEditPilot",true);
				$ftop = "-20";
			}
			if($featureType=='DN_XLH'){
				$titletag = __("dnEditMember",true);
				$ftop = "0";
			}
			if(($featureType=="DN_XLH") && (isset($spg))){
				$titletag = __("dnEditGroup",true);
				$ftop = "0";
			}
$featStat['4'] = '!';

if(!empty($features)){
	echo $form->create('Station', array(
                                'action' => 'updateDNFeatures',
                                'id' => 'updateDNFeatures',
                                'class' => 'dnForm',
                                'type' => 'POST',
								'invalidate' => 'invalidate',
								'autocomplete'=>'off'
));
#echo $form->input("returnDNList", array(
#		'type' => 'hidden',
#		'value' => $returnDNList,
#		'id' => "returnDNList"
#));


	#echo $form->create(null, array('id' => 'featureEditForm', 'url' => '/features/update/'.$features[0]['Feature']['id'],'accept-charset'=>'ISO-8859-1'));
	?>	
	
	
	<input type="hidden" name="transactionId" id="transactionId" value=""	>
	<input type="hidden" name="stationId" id="stationId" value=""	>
	<input type="hidden" name="logId" id="logId" value=""	>
	<div class="black_overlay"  style="display: none;">
				<!--<div id="black_overlay_loading" class="loading">
				<img alt="" src="<?php echo Configure::read('base_url');?>img/assets/ajax-loader.gif">
				</div>-->
				
				
	</div>
	
	<div class="block top" style="z-index: 1;">
		  	
		<div style="height: 55px">
		<div id="overlay-error" class="notification first hide" style="width: 100%" >
		
			<div class="error">
				<div class="message">
					
				</div>
			</div>
		</div>
		</div>
	<?php if((isset($inProgress)) && $inProgress){?>
		<div class="notification first" style="width: 534px" >
		
			<div class="ok">
				<div class="message">
					IN WORK
				</div>
			</div>
		</div>
		
	<?php 
	#CBM TEST
	} ?>
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
		}?>
		
 <!--CBM ADDED BUTTONS TO TOP-->
	<div id="newEdit">
		<?php  $d=explode('@',$stationkey_id);
			$key = $d[0];
			$dnno = $d[1];
			
			
			
			echo $form->input('DN', array('type'=>'hidden','value'=>$features['DN']['primary_value']));
			
			#If source page is not edit_madn don't sho key options. this is because should only available when launched from ediststaiotn.

			if((($featureType=="DN_MADN") || ($featureType=="DN_XLH"))&& (isset($spg)))
			{
				?>
				
				<h4><?php echo $titletag .'&nbsp;'. $features['DN']['primary_value']; ?>
		 <div class='demonstrations'>
           <div style="font-size: 18px !important;" ><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick=" setTimeout( function() {     
					$('.fancybox-overlay').trigger('click');
					 },5); UnTip();">X</a></div>
	        <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onclick="Tip('<b><?php echo __('groudnForm_helpTitel') ?></b><br/><?php echo __('groupForm_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>		
 		  </div>
		</h4>
				<?php 
			}
			else {
		 ?>
		 
		<h4><?php echo $titletag .'&nbsp;'. $features['DN']['primary_value']; ?>
		 <div class='demonstrations'>
           <div  style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick=" setTimeout( function() {     
					$('.fancybox-overlay').trigger('click');
					 },5); UnTip();">X</a></div>
	        <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onclick="Tip('<b><?php echo __('dnForm_helpTitel') ?></b><br/><?php echo __('dnForm_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>		
 		  </div>
		</h4>
		<div class="form-body">
			<div class="form-box">
			    <div class="form-left">
					<?php 
					echo '<div class="form-label">'; 
					echo __('Station Id'); 
					echo '</div>';
					#echo	$form->input('IGNORE_STATIONID', array('label' => false,'value'=>$dnno,'style'=>'width:100px;', 'readonly'=>'true'));
					echo $dnno;
					?>		
				</div>
				<div class="form-right">
					<?php 
					#echo '<div style="width:100px; float: left">' . __('KEY') . '</div>';
					echo '<div class="form-label">';
					echo __('DN Type');
					echo '</div>';
					#echo	$form->input('', array('label' => false,'value'=>$featureType,'style'=>'width:100px;', 'readonly'=>'true'));
					echo __($featureType);
					?>		
				</div>
				<div class="form-left">
					<?php 
					#echo '<div style="width:100px; float: left">' . __('KEY') . '</div>';
					echo '<div class="form-label">';
					echo __('Key');
					echo '</div>';
					#echo	$form->input('IGNORE_KEY', array('label' => false,'value'=>$key,'style'=>'width:100px;', 'readonly'=>'true'));	
					echo $key;
					?>	
			     </div>
				   
				<div class="form-right">
					<?php 
					echo '<div class="form-label">';  
					echo __('Port Type'); 
					echo '</div>';
					#echo '<div style="width:100px; float: left">' . __('Leading0') . '</div>';
					#echo	$form->input('LEADINGZERO', array('label' => false,'value'=>$features['LEADINGZERO']['primary_value'], 'type'=>'checkbox', 'checked'=>($features['LEADINGZERO']['primary_value'] == '1' ? TRUE : FALSE),'style'=>'width:15px;','onclick'=>'chngbkcolor(this)'));	
					echo $porttype;
					echo $featStat[$features['LEADINGZERO']['status']] ;?>
  			    </div>
	         </div>
			 <div class="form-box">    
				<div class="form-left">
					<?php 
					echo '<div class="form-label">';  
					echo __('Locations'); 
					echo '</div>';
					#echo '<div style="width:100px; float: left">' . __('Locations') . '</div>';
					//echo $form->input('location_id', array('label' => false,'type'=>'select', 'options'=>$locations, 'default'=>$location_id,'style'=>'width:106px;','onchange'=>'chngbkcolor(this)')); 
					echo $location_name['Location']['name'];
					echo $featStat[$features['location_id']['status']] ;?>
				</div>
				<div class="form-right">
					<?php echo '<div class="form-label">';
					echo __('emer'); 
					echo '</div>';
					#echo $form->input('IGNORE_emer', array('label' => false,'value'=>$dnDetails['Location']['emer'], 'style'=>'width:100px;', 'readonly'=>'true','onkeyup'=>'chngbkcolor(this)'));
					echo $dnDetails['Location']['emer']; 
					?>
				</div>
			</div><br/>
			
			
			<h4><?php echo __('DN Option');?>			</h4>
			<?php if ($custtype == 'Gate +'){ $ncosreadonly = true;} else $ncosreadonly = false;?>
            <div class="form-box">			    
				<div class="form-left table-menu">
					<?php 
					echo '<div class="form-label">';  
					echo __('LANGUAGE'); 
					echo '</div>';
					?>
					  <div class="table-menu-popup" style="z-index: 1">
                    	<ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('LANG_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                      </div>
             		<?php
					echo $form->input('LANG', array('label' => false,'type'=>'select', 'options'=>$languageOptions, 'default'=>$features['LANG']['primary_value'],'readonly'=>$ncosreadonly,'style'=>'width:106px;','onchange'=>'chngbkcolor(this)')); 
					echo $featStat[$features['LANG']['status']] ;?>
					<?php
					# $onclick = "<span onclick=Tip(\'echo__(LANG_desc)\') >...</span>"; ?>						
			     </div>
				 <div class="form-right table-menu">
					<?php 
					echo '<div class="form-label">';  
					echo __('LEADINGZERO'); 
					echo '</div>';
					?>
				      <div class="table-menu-popup" style="z-index: 1">
                        <ul><li><a href="javascript:;" onclick="Tip('<?php echo __('LEAD_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
               	      </div>
					<?php
					if($porttype=="ANLG"){
						echo	$form->input('LEADINGZERO', array('label' => false,'value'=>$features['LEADINGZERO']['primary_value'], 'type'=>'checkbox', 'checked'=>($features['LEADINGZERO']['primary_value'] == '1' ? TRUE : FALSE),'style'=>'width:15px;','readonly'=>$ncosreadonly,'onclick'=>'chngbkcolor(this)'));
	
					}
					else{
						echo	$form->input('LEADINGZERO', array('label' => false,'value'=>$features['LEADINGZERO']['primary_value'], 'type'=>'checkbox', 'checked'=>($features['LEADINGZERO']['primary_value'] == '1' ? TRUE : FALSE),'style'=>'width:15px;','readonly'=>true,'onclick'=>'chngbkcolor(this)'));	
					}
					
					echo $featStat[$features['LEADINGZERO']['status']] ;?>	
			    </div>
			</div>	
     		 <div class="form-box">
				 <div class="form-left table-menu">
					<?php 
					echo '<div class="form-label">';  
					echo __('BARRINGSET'); 
					echo '</div>';
					?>
					  <div class="table-menu-popup" style="z-index: 1">
                    	<ul>									
							<li ><a href="javascript:;" onclick="Tip('<?php echo __('BARRINGSET_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li>						
             			</ul>
                      </div>
					<?php
					#echo '<div style="width:100px; float: left">' . __('Barring') . '</div>';
					#echo $form->input('Language', array('value'=>$features['LANG']['primary_value'], 'style'=>'width:200px;','onchange'=>"javascript:submi_form('filters');")); 	
					#echo $form->input('Language', array('label' => false,'type'=>'select', 'options'=>$languageOptions, 'default'=>'somegroup',array('style'=>'width:200px;'),'style'=>'width:20px;')); 
					echo $form->input('BARRINGSET', array('label' => false,'type'=>'select', 'options'=>$barringOptions, 'default'=>$features['BARRINGSET']['primary_value'],'readonly'=>$ncosreadonly, 'style'=>'width:106px;','onchange'=>'chngbkcolor(this)')); 
					echo $featStat[$features['BARRINGSET']['status']] ;?>
					
				</div>
				<div class="form-right table-menu">
					<?php 
					#echo '<div style="float:left !important;">'; 
					echo '<div class="form-label">';  
					echo __('SUPPRESS'); 
					echo '</div>';
					?>
					  <div class="table-menu-popup" style="z-index: 1">
                    	<ul>									
						  <li ><a href="javascript:;" onclick="Tip('<?php echo __('SUPPRESS_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li>						
                    	</ul>
                      </div>
					<?php
					#echo "</div>";
					#echo '<div style="width:100px; float: left">' . __('Suppress') . '</div>';
					echo	$form->input('SUPPRESS', array('label' => false,'value'=>$features['SUPPRESS']['primary_value'], 'type'=>'checkbox', 'checked'=>($features['SUPPRESS']['primary_value'] == '1' ? TRUE : FALSE),'style'=>'width:15px;','onclick'=>'chngbkcolor(this)'));	
					echo $featStat[$features['SUPPRESS']['status']] ;?>	
					
			    </div>
			</div>

			<div class="form-box">
				<div class="form-left table-menu">
					<p></p>
					
				</div>
				<div class="form-right table-menu">
					<?php 
					#if(1)
					if(array_key_exists('CPU', $stationfeatures))
					{
						echo '<div class="form-label">';  
						echo __('CPUMember'); 
						echo '</div>';
						?>
						<div class="table-menu-popup" style="z-index: 1">
                    	<ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('CPUMember_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                    	</div>
						<?php
						#echo '<div style="width:100px; float: left">' . __('cpuMember') . '</div>';
						#echo $form->input('Language', array('value'=>$features['LANG']['primary_value'], 'style'=>'width:200px;','onchange'=>"javascript:submi_form('filters');")); 	
						#echo $form->input('Language', array('label' => false,'type'=>'select', 'options'=>$languageOptions, 'default'=>'somegroup',array('style'=>'width:200px;'),'style'=>'width:20px;')); 
					
						if($key == 01)
						{
						echo	$form->input('CPUMEMBER', array('label' => false,'value'=>$features['CPUMEMBER']['primary_value'], 'type'=>'checkbox', 'checked'=>($features['CPUMEMBER']['primary_value'] == '1' ? TRUE : FALSE),'style'=>'width:15px;','readonly'=>'true','onclick'=>'chngbkcolor(this)'));	
						}
						else
						{
							echo	$form->input('CPUMEMBER', array('label' => false,'value'=>$features['CPUMEMBER']['primary_value'], 'type'=>'checkbox', 'checked'=>($features['CPUMEMBER']['primary_value'] == '1' ? TRUE : FALSE),'style'=>'width:15px;','onclick'=>'chngbkcolor(this)'));	
					
						}
						echo $featStat[$features['CPUMEMBER']['status']] ;
					
					}
					?>		
				</div>
			</div>	
			  <div class="form-box">

				<div class="form-left table-menu">
					<p>	</p>
				</div>
				<div class="form-right table-menu">
					<?php 
					
							
					
					if(array_key_exists('MSB', $stationfeatures) && ($key != 01))
					{
					echo '<div class="form-label">';  
					echo __('MSB'); 
					echo '</div>';
					?>
					<div class="table-menu-popup" style="z-index: 1">
                    	<ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('MSB_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                    </div>
					<?php
					#echo '<div style="width:100px; float: left">' . __('MSB') . '</div>';
					#echo $form->input('Language', array('value'=>$features['LANG']['primary_value'], 'style'=>'width:200px;','onchange'=>"javascript:submi_form('filters');")); 	
					#echo $form->input('Language', array('label' => false,'type'=>'select', 'options'=>$languageOptions, 'default'=>'somegroup',array('style'=>'width:200px;'),'style'=>'width:20px;')); 
					echo	$form->input('MSBMEMBER', array('label' => false,'value'=>$features['MSBMEMBER']['primary_value'], 'type'=>'checkbox', 'checked'=>($features['MSBMEMBER']['primary_value'] == '1' ? TRUE : FALSE),'style'=>'width:15px;','onclick'=>'chngbkcolor(this)'));	
					echo $featStat[$features['MSBMEMBER']['status']] ;
					}
					?>		
				</div>
			</div>
            <br/>
			<?php 
			} # End SPG check
			#If this is DN_INDIVIDUAL or DN_MADN_PILOT or came from DN form or Group edit form.
			if((($featureType!="DN_MADN") && ($featureType!="DN_XLH")) || (isset($spg)))
			  {?>
			  
			  <div class="form-box" style="margin-top: <?php echo $ftop; ?>px;">
				<div class="form-left table-menu" style="margin-top: <?php echo $ftop; ?>px;">
					<?php 
					echo '<div class="form-label">';  
					echo __('DISPLAYNAME'); 
					
					echo '</div>';
					?>
					<div class="table-menu-popup" style="z-index: 1">
                    	<ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('DISPLAYNAME_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                    </div>
					<?php
					#echo '<div style="width:100px; float: left">' . __('DISP') . '</div>';
					echo	$form->input('DISPLAYNAME', array( 'label' => false,'value'=>$features['DISPLAYNAME']['primary_value'],'style'=>'width:100px','onkeyup'=>'chngbkcolor(this)'));	
					echo $featStat[$features['DISPLAYNAME']['status']] ;
					?>		
					
				</div>
			  </div><br/>
			  <div class="form-box" style="margin-top: <?php echo $ftop; ?>px;">
			  <div class="form-right table-menu">
					<?php 
					echo '<div class="form-label">';  
					echo __('SDNA'); 
					echo '</div>'; ?>
					<div class="table-menu-popup" style="z-index: 1">
                    	<ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('SDNA_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                    </div>
					<?php
					#echo	$form->input('SDNA', array('label' => false,'value'=>$features['SDNA']['primary_value'],'class'=>'numeric_check','style'=>'width:100px;','onkeyup'=>'chngbkcolor(this)'));	
					echo $form->input('SDNA', array('label' => false,'type'=>'select', 'options'=>$sdnaDns, 'default'=>$features['SDNA']['primary_value'],'onchange'=>'chngbkcolor(this)', 'class'=>'choosen', 'style'=>'width:106px;')); 
										
					echo $featStat[$features['SDNA']['status']] ;?>		
				</div>
			
				<?php if($this->params['url']['lname']!="changedGroup" && count($observers)!=0){ ?>
			
				<div class="form-right table-menu">
					<?php 
					echo '<div class="form-label" style="width:73%;">';  
					echo count($observers)." ";  echo __('blfCoObservers'); 
					?>
					<a  onclick="return toggleShowObserve() ;" href="javascript:void(0)" style="float:right;">
					
					<div style="width:20px;" id="expand">
					<div id="plus"></div>
					</div>
					<div style="width:20px;" id="collapse">
					<div id="minus"></div>
					</div>
					</a>
					<?php
					echo '</div>'; ?>
					
					<div class="table-menu-popup" style="z-index: 1">
                    	<ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('blfCoObserver_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                    </div>
						
				</div>
			  </div><br/>
			   <div class="form-box" style="margin-top: 10px;">
			   <div id="blfobservers" class="form-box" style="display:none">
		<h4><?php __('observerSection'); ?></h4>
		  <div id="ajaxload" class="table-content main_table_content" style="height: auto !important;">
	        <table class="phonekey" id="NOTdragdroptbl" width="400px!important">
			  <thead>
			    <tr class="table-top">
				  <!--<th class="table-column" style="width:20px;">&nbsp;</th>-->
				  <th class="table-column" style="width:120px;text-align: left;">&nbsp;<?php echo __('Label')?>&nbsp;&nbsp;</th>
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
			
		
			 <?php   }   ?> 
			 	</div>
			  <?php if((($featureType=="DN_MADN") || ($featureType=="DN_XLH")) && (isset($spg))) {		  		 			 
			  ?>
			  <div class="form-box">
			  <div class="form-left table-menu">
					<?php 
					echo '<div class="form-label">';  
					echo __('groupDesc'); 
					echo '</div>'; ?>
					<div class="table-menu-popup" style="z-index: 1">
                    	<ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('group_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                    </div>
					<?php
					echo	$form->input('groupDesc', array('label' => false,'rows'=>'5','cols'=>'45','value'=>$groupDetailsdesc['Group']['desc'],'style'=>'width:100px;','onkeyup'=>"chngbkcolor(this);"));	
					?>	
					<input type="hidden" name="grpid" id="grpid" value="<?php echo $grpid; ?>"	>
				</div>
			  </div>
			  <div class="form-box">
			  <div class="form-left table-menu">
			  	&nbsp;
			  </div>
			  <div class="form-right table-menu" style="margin-top:<?php echo $top;?>px;">
					<?php 
					
					if(($featureType=='DN_XLH_PILOT')||($featureType=='DN_XLH')){
						echo __('groupXlhEdit_info',true); 
					}
					else{
						echo __('groupMadnEdit_info',true); 
					}
					
					
					
					?>
				</div>
			  </div>
			  <?php } ?>
			  </div>
			    <h4><?php echo __('Forwarding');?>
					
					<?php    if(($featureType=='DN_XLH_PILOT')||($featureType=='DN_XLH')){  ?>
		
            <div class="form-box" style="padding-top:5px;">     
					<p><?php  echo __( wordwrap('tag_xlhReadOnly',100,"<br>\n"));  ?> </p>
				
			</div>
            <?php } ?>
					
					
					
					
					
				</h4>
				
				
				
				
             <?php
				if($featureType=='DN_XLH_PILOT'){ $cfxreadonly=TRUE;   ?>
				
				<script>
				
				
			function disable() {
			    document.getElementById("StationCFDVT").disabled=true;
			}
			  disable();
			</script>
				
				<?php }  ?>
                <?php if(($featureType=='DN_XLH')){ $cfxreadonly=TRUE;   ?>
				
				<script>
				
				
			function disable() {
			    document.getElementById("StationCFDVT").disabled=true;
			}
			  disable();
			</script>
				
				<?php }  ?>
			
				
		<div class="form-body">
			   
			   <?php //if(!$features['CFUMEMBER']['primary_value']){ $cfxreadonly=TRUE;}else{$cfxreadonly=$readonly;}?>
			   <div class="form-box">   
				 <div class="form-left table-menu">
					<?php 
					echo '<div class="form-label">'; 
					echo __('CFU'); 
					echo '</div>';
					?>
					<div class="table-menu-popup" style="z-index: 1">
                    	<ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('CFU_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                	</div>
					<?php
					#echo '<div style="width:100px; float: left">' . __('CFU Number') . '</div>';
					echo	$form->input('CFUNUMBER', array('label' => false,'value'=>$features['CFUNUMBER']['primary_value'],'class'=>'numeric_check','style'=>'width:100px;','readonly'=>$cfxreadonly,'onkeyup'=>'chngbkcolor(this)'));	
					echo $featStat[$features['CFUNUMBER']['status']] ;?>
				 </div>
				 <div class="form-right table-menu">
					<?php 
					echo '<div class="form-label">'; 
					echo __('CFUEnable'); 
					echo '</div>';
					?>
					<div class="table-menu-popup" style="z-index: 1">
                    	<ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('CFB_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                    </div>
					<?php
					#echo '<div style="width:100px; float: left">' . __('CFUSTATUS') . '</div>';
					echo	$form->input('CFUSTATUS', array('label' => false,'value'=>$features['CFUSTATUS']['primary_value'], 'type'=>'checkbox', 'checked'=>($features['CFUSTATUS']['primary_value'] == 'A' ? TRUE : FALSE),'style'=>'width:15px;','readonly'=>$cfxreadonly,'onclick'=>'chngbkcolor(this)'));	
					echo $featStat[$features['CFUSTATUS']['status']] ;?>
				 </div>
           	   </div>
           	   
           	   <?php //if(!$features['CFBMEMBER']['primary_value']){ $cfxreadonly=TRUE;}else{$cfxreadonly=$readonly;}?>
           	   
             <div class="form-box">   
			   <div class="form-left table-menu">
				<!-- <div class="form-label" onclick="Tip('<?php echo __('CFB_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()"> -->
				 <div class="form-label" > 
					<?php echo __('CFB'); ?> 
				 </div>
				 <div class="table-menu-popup" style="z-index: 1">
                    	<ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('CFB_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                	</div>
				<!-- <div class="table-menu-popup" style="z-index: 1">
                    <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('CFB_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                 </div>  -->
					<?php
					#echo '<div style="width:100px; float: left">' . __('CFB Number') . '</div>';
					echo	$form->input('CFBNUMBER', array('label' => false,'value'=>$features['CFBNUMBER']['primary_value'],'class'=>'numeric_check', 'style'=>'width:100px;','readonly'=>$cfxreadonly,'onkeyup'=>'chngbkcolor(this)'));	
					echo $featStat[$features['CFBNUMBER']['status']] ;?>
						
				</div>
				<div class="form-right table-menu">
					<?php 
					echo '<div class="form-label">'; 
					echo __('CFBEnable'); 
					echo '</div>'; ?>
					<div class="table-menu-popup" style="z-index: 1">
                    	<ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('CFB_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                	</div>
					<!-- <div class="table-menu-popup" style="z-index: 1">
                    	<ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('CFBEnable_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                    </div> -->
					<?php
					#echo '<div style="width:100px; float: left">' . __('CFBSTATUS') . '</div>';
					echo	$form->input('CFBSTATUS', array('label' => false,'value'=>$features['CFBSTATUS']['primary_value'], 'type'=>'checkbox', 'checked'=>($features['CFBSTATUS']['primary_value'] == 'A' ? TRUE : FALSE),'style'=>'width:15px;','readonly'=>$cfxreadonly,'onclick'=>'chngbkcolor(this)'));	
					echo $featStat[$features['CFBSTATUS']['status']] ;?>	
				</div>
            </div> 
            
            
            <?php //if(!$features['CFNAMEMBER']['primary_value']){ $cfxreadonly=TRUE;}else{$cfxreadonly=$readonly;}?>
            
		     <div class="form-box">     
				<div class="form-left table-menu">
					<?php 
					echo '<div class="form-label">';  
					echo __('CFNA'); 
					echo '</div>'; ?>
					<div class="table-menu-popup" style="z-index: 1">
                    	<ul>									
							<li ><a href="javascript:;" onclick="Tip('<?php echo __('CFNA_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li>						
                    	</ul>
                    </div>
					<?php #echo '<div style="width:100px; float: left">' . __('CFNA Number') . '</div>';
					echo	$form->input('CFNANUMBER', array('label' => false,'value'=>$features['CFNANUMBER']['primary_value'],'class'=>'numeric_check','style'=>'width:100px;','readonly'=>$cfxreadonly,'onkeyup'=>'chngbkcolor(this)'));	
					echo $featStat[$features['CFNANUMBER']['status']] ;?>	
				</div>
				<div class="form-right">
				<div class="table-menu">
					<?php 
					echo '<div class="form-label">';
					echo __('CFNAEnable'); 
					echo '</div>'; ?>
					<div class="table-menu-popup" style="z-index: 1">
                    	<ul>									
							<li ><a href="javascript:;" onclick="Tip('<?php echo __('CFNA_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li>						
                    	</ul>
                    </div>
					
					<?php
				        $CFNAEnable_desc = __('CFNAEnable_desc',true);
						$CFNAEnable_desclen = strlen($CFNAEnable_desc);
						if($CFNAEnable_desc != "*empty*"){
					?>
				<!--	<div class="table-menu-popup" style="z-index: 1">
                    	<ul style="width:100px;">									
							<li ><a href="javascript:;" onclick="Tip('<?php echo __('CFNAEnable_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li>
                    	</ul>
                    </div> -->
					<?php } ?>
					<?php #echo '<div style="width:100px; float: left">' . __('CFNASTATUS') . '</div>';
					echo	$form->input('CFNASTATUS', array('label' => false,'value'=>$features['CFNASTATUS']['primary_value'], 'type'=>'checkbox', 'checked'=>($features['CFNASTATUS']['primary_value'] == 'A' ? TRUE : FALSE),'style'=>'width:15px;','readonly'=>$cfxreadonly,'onclick'=>'chngbkcolor(this)'));	
					echo $featStat[$features['CFNASTATUS']['status']] ;?>
						
				</div>
			<!--CFDVT-->
				 <div class="table-menu">
                       <?php
                       echo '<div class="form-label table-menu"  style="width:30px;">';
                       echo __('nach');
                       echo '</div>'; ?>
					   <?php
				         $CFDVT_desc = __('CFDVT_desc',true);
						$CFDVT_desclen = strlen($CFDVT_desc);
						if($CFDVT_desc != "*empty*"){
						 ?>
					   <div class="table-menu-popup" style="z-index: 1;">
                    	<ul style="margin-top:0px;margin-left:145px;">									
							<li ><a href="javascript:;" onclick="Tip('<?php echo __('CFDVT_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>	</li>
                    	</ul>
                      </div>
					   <?php } ?>
                       <?php echo $form->input('CFDVT', array('label' => false,'type'=>'select', 'options'=>$cfdvtOptions, 'default'=>$features['CFDVT']['primary_value'],'style'=>'width:56px;','readonly'=>$cfxreadonly,'onclick'=>'chngbkcolor(this)' )); 
                       echo $featStat[$features['CFDVT']['status']] ;?><?php echo __('sec'); ?>
				</div>	
			</div>
            </div>
            
            
            
            
		</div>
		
		
				   	
       <?php }
       else {

		?>
		   <?php   if($featureType!='DN_XLH'){  ?>
			<h4><?php echo __('ForwardingDisabledGrpMember');?>    </h4>
            <div class="form-box">     
				<div class="form-left">
					
					<a href="<?php echo Configure::read('base_url');?>groups/edit/group_id:<?php echo $features['DN']['primary_value']?>" onMouseOver="Tip('<?php echo __('groupLink') ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " ><?php echo __("groupLink", true); ?></a>	
				</div>
				<div class="form-right">
					<p><?php echo __('groupForwarding_blurb');?> </p>
				</div>
			</div>
            <?php }else{ ?>
			
			 <div class="form-box">     
				<div class="form-left">
					
					<a href="<?php echo Configure::read('base_url');?>groups/edit/group_id:<?php echo $features['DN']['primary_value']?>" onMouseOver="Tip('<?php echo __('groupLink') ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " ><?php echo __("groupLink", true); ?></a>	
				</div>
				
			</div>
			<?php } ?>
			
			
			
			
 		<?php } ?>
	</div>
	<?php }?>
    <div class="form-box">
	<!--<div class="form-right-inactive">
		<p><?php echo __('inactiveFeature')?></p>
	</div>-->		
	</div>
	 <br/>
		 <fieldset>
           <fieldset style="display:none;">
              <input type="hidden" name="_method" value="PUT" />
            </fieldset>
            <?php if(!(isset($error) && $error)){?>
     		<div class="button-right-disabled" id="updateStation" style="margin-right:8px !important; ">
              <a id="button" href="javascript:;"  onclick="submitForm();" name="submitForm" value="submitForm" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __("Submit"); ?></a>
            </div>
            <?php }?>
          </fieldset>
     </div>          
  </div>

   <!--ight hand side  ends here-->

</form>


<?php  exit; ?>
