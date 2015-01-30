<?php 

//echo $javascript->link('/js/jquery-1.10.1.min');

echo $javascript->link('/js/jquery.fancybox');
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
</script>
<script type="text/javascript">
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
            $('#pbtn_ods').hide();
            $('#minus_ods').show();
            $('#mbtn_ods').show();
            $('#plus_ods').hide();
        });
    });
function toggleShowHistory() {
        //$("#advancesearch").show
        if (document.getElementById('showhistory').style.display == 'none') {
            document.getElementById('showhistory').style.display = 'block';
        } else {
            document.getElementById('showhistory').style.display = 'none';
        }
    }
</script>
<!--  SCM additional style -->
<link rel="stylesheet" type="text/css" href="https://extranet-acc.swisscom.ch/portal/css/portal.css" media="screen" />

<link rel="stylesheet" href="//google-code-prettify.googlecode.com/svn/trunk/src/prettify.css" type="text/css"/>
<script type="text/javascript" src="//google-code-prettify.googlecode.com/svn/trunk/src/prettify.js"></script>



<script type="text/javascript"> 
    $(document).ready(function() { //alert("ret");
	        
	
	
        $('#dragdroptbl').tableDnD({ 
            onDragStart: function(table, row) { 
                //$(table).parent().find('.result').text('');
            }, 
             onDrop: function(table, row) { //alert("ssd");
                $('#AjaxResult').load(base_url+"groups/edit?"+$.tableDnD.serialize());
               // prettyPrint();
			  // var newPositionedAry = decodeURI($.tableDnD.serialize()); alert(newPositionedAry);
				    var tblstr = decodeURI($.tableDnD.serialize());
                    var tmparray = new Array();
                    var x = 0;
                    tmparray = tblstr.split("&dragdroptbl[]="); 
                    while (x < tmparray.length) {
                        if (tmparray[x] != "dragdroptbl[]=") { 
						   pos=x+1; 
						   pos = (pos.toString().length==1)? '0'+pos : pos;
						   original_position = tmparray[x].replace("dragdroptbl[]=", ""); 
						  //  alert(pos+"=="+original_position);
						  // alert($('#'+original_position).find($("input[name^='featureNewPosition']")).attr('id'));
						 //  alert($('#'+original_position).find($(".opencolorbox")).attr('href'));
						 $('#'+original_position).find("td:nth-child(2) input[name^='featureNewPosition']").val(pos);
						 // alert( $('#'+original_position).find("td:nth-child(2) input[name^='featureNewPosition']").val());
                          // $(apriority).val(tmparray[x]);
                        }
                        x++;
                    }
					
                
			   
            }
        });
		
	});
	function submitForm(){
		$('.filtersForm').attr('action',base_url+'groups/group_change/');
		$('.filtersForm').attr('method','POST');
		$.ajax({
				type: "POST",
				async : false,
				dataType: 'json',
				url: $('.filtersForm').attr('action'),
				data: $('.filtersForm').serialize(),
				success: function(data){ 
					// do nothing
				}
		});
	}
	function reloadme(){
		location.reload();
	}
</script>


<!--  -->

<style>
.doku-right{
	padding-right: 10px;
}



.call-to-action-right{
    background: url("images/assets/bg-actionbox.gif") repeat-x scroll 0 0 #E6E6E6 ;
    margin-bottom: 0;
    margin-top: 0;
    padding-bottom: 0;
    padding-top: 11px;	
}

img {
 max-width: 1000px !important;
width: auto !important;
height: auto;
vertical-align: middle;
border: 0;
-ms-interpolation-mode: bicubic;
}
.fileLinks{
	background-image: url("images/assets/arrow-black.gif")!impotant;
    background-position: 0 4px !impotant;
	height:20px;
    background-repeat: no-repeat !impotant;
	font-weight: normal;text-decoration: none !impotant;
list-style:none;margin:0 !important;padding:0 !important;
 
}
</style>
<?php
$selectedLanguage = $_SESSION['Config']['language'];
if($selectedLanguage=='de'){ ?>
<style>
.call-to-action{
	
	background: url("images/assets/bg-actionbox.gif") repeat-x scroll 0 0 #E6E6E6;
    margin-bottom: 0;
    margin-top: 0;
    padding-bottom: 0;
    padding-top: 11px;
	height:133px !important;
}
</style>
<?php }	else { ?>
<style>
.call-to-action{
	
	background: url("images/assets/bg-actionbox.gif") repeat-x scroll 0 0 #E6E6E6;
    margin-bottom: 0;
    margin-top: 0;
    padding-bottom: 0;
    padding-top: 11px;
	height:133px !important;
}
</style>
<?php	} ?>

<style>

    .tablesorter-filter
    {
        width:100% !important;
		margin: 0 -2px !important;
    padding: 4px 1px !important;
    }
    .space_check
    {
        width:91%;
        height:auto !important;
        margin-bottom:0 !important;
    }
    .table th, .table td
    {
        padding: 1px 6px;  
        border:none;
    }
    .tablesorter-bootstrap .tablesorter-pager select
    {
        width:64px;
        margin:0 20px;
    }
    .table-top th, .table-right-ohne th
    {
        height:40px;
        border-top:#CCC 1px solid;

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
        border-bottom:#D1D1D1 1px solid !important; border-right: 1px solid #D1D1D1 !important;border-top:#D1D1D1 1px solid !important; border-radius:0px !important;	border-left: 1px solid #D1D1D1!important;
    }
.tablesorter-filter-row td
	{
		 border-right: 1px solid #D1D1D1 !important;border-top:#D1D1D1 1px solid !important; border-radius:0px !important;border-left: 1px solid #D1D1D1!important;
	}
    
li {
    line-height: 15px!important;
}	
	
 

</style>
<?php if(preg_match('/(?i)msie [1-8]/',$_SERVER['HTTP_USER_AGENT'])){// if IE<=8 ?>
  <div class="notification first" style="width: 534px" >

			<div class="warning">
				<div class="message">
					<?php echo __("Browser version is not supported", true) ?>
				</div>
			</div>
		</div>
<?php } ?>
<div class="block-eservices " style="margin-left:5px; margin-top: 3px;">
<?php 
if( $custdetail['Customer']['type']=="Gate"||$custdetail['Customer']['type']=="Gate +"){?>
		<div class="box call-to-action-right" style="width: 534px!important;min-height: 100px;">
			<div class="info info-warning`	" style="z-index: 2">
				<a href="" id="updateNotification">&nbsp;</a></div><h3 style="color: inherit;"><b><?php __("re3Gate_title");?></b></h3>
				
			<div>
			<ul style="margin-left: 37px;">
				<li><?php __("re3Gate_text");?></li>
				
				<?php	 $selectedLanguage = $_SESSION['Config']['language'];
						if($selectedLanguage=='de'){ ?>
						
							<li class="fileLinks"><span style="margin-right: 50px; float: left;">
               					 <a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Gate.html"; ?>" style="cursor:pointer;text-decoration: underline;"  target="_blank"  title="<?php __("re3Gate_videoTip");?>"><?php __("re3Gate_video");?></a>
								</span>
 								<a href="<?php echo Configure::read('base_url')."files/Anleitung_OnDemandSchaltung_RE3.pdf"; ?>" style="cursor:pointer;text-decoration: underline;float: left;"  target="_blank"  title="<?php __("re3Ods_guideTip");?>"><?php __("re3Ods_guide");?></a>
            				</li>		
						<?php   }elseif ($selectedLanguage=='fr'){?>
							<li class="fileLinks"><span style="margin-right: 50px;float: left;">
                				<a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Gate.html"; ?>" style="cursor:pointer;text-decoration: underline;"  target="_blank"  title="<?php __("re3Gate_videoTip");?>"><?php __("re3Gate_video");?></a>
								</span>
								<a href="<?php echo Configure::read('base_url')."files/Anleitung_OnDemandSchaltung_RE3_f.pdf"; ?>" style="cursor:pointer;text-decoration: underline;float: left;"  target="_blank"  title="<?php __("re3Ods_guideTip");?>"><?php __("re3Ods_guide");?></a>
							</li>
							
						<?php }elseif($selectedLanguage=='it'){?>
							<li class="fileLinks"><span style="margin-right: 50px;float: left;">
               					 <a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Gate.html"; ?>" style="cursor:pointer;text-decoration: underline;"  target="_blank"  title="<?php __("re3Gate_videoTip");?>"><?php __("re3Gate_video");?></a>
								</span>
 								<a href="<?php echo Configure::read('base_url')."files/Anleitung_OnDemandSchaltung_RE3.pdf"; ?>" style="cursor:pointer;text-decoration: underline;float: left;"  target="_blank"  title="<?php __("re3Ods_guideTip");?>"><?php __("re3Ods_guide");?></a>
           					 </li>
						<?php  }else{ ?>
							<li class="fileLinks"><span style="margin-right: 50px;float: left;">
               					 <a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Gate.html"; ?>" style="cursor:pointer;text-decoration: underline;"  target="_blank"  title="<?php __("re3Gate_videoTip");?>"><?php __("re3Gate_video");?></a>
								</span>
 								<a href="<?php echo Configure::read('base_url')."files/Anleitung_OnDemandSchaltung_RE3.pdf"; ?>" style="cursor:pointer;text-decoration: underline; float: left;"  target="_blank"  title="<?php __("re3Ods_guideTip");?>"><?php __("re3Ods_guide");?></a>
           					 </li>
						<?php } ?>
				
           		 </ul>	
			</div>
		</div> <?php  }   
if( $custdetail['Customer']['type']=="Phone"||$custdetail['Customer']['type']=="Hybrid"){?>
		<div class="box call-to-action-right" style="width: 534px!important;min-height: 100px;">
			<div class="info info-warning`	" style="z-index: 2">
				<a href="" id="updateNotification">&nbsp;</a></div><h3 style="color: inherit;"><b><?php __("re3Gate_title");?></b></h3>
				
			<div>
			<ul style="margin-left: 37px;">
				<li><?php __("re3Phone_text");?></li>
				
				<?php	 $selectedLanguage = $_SESSION['Config']['language'];
						if($selectedLanguage=='de'){ ?>
						<li class="fileLinks"><span  style="margin-right: 50px;float: left;">
                <a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Self_Admin.html"; ?>" style="cursor:pointer;text-decoration: underline;"  target="_blank"  title="<?php __("re3Phone_videoTip");?>"><?php __("re3Phone_video");?></a>                            
                </span> <a href="<?php echo Configure::read('base_url')."files/RE3_Kundenbrief_VoIP_Phone_de.pdf"; ?>" style="cursor:pointer;text-decoration: underline;float: left;"  target="_blank"  title="<?php __("re3Phone_notesTip");?>"><?php __("re3Phone_notes");?></a> </li>			
						<?php   }elseif ($selectedLanguage=='fr'){?>
						<li class="fileLinks"><span style="margin-right: 50px;float: left;" >
                <a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Self_Admin_fr.html"; ?>" style="cursor:pointer;text-decoration: underline;"  target="_blank"  title="<?php __("re3Phone_videoTip");?>"><?php __("re3Phone_video");?></a>                            
                </span> <a href="<?php echo Configure::read('base_url')."files/RE3_Kundenbrief_VoIP_Phone_fr.pdf"; ?>" style="cursor:pointer;text-decoration: underline;float: left;"  target="_blank"  title="<?php __("re3Phone_notesTip");?>"><?php __("re3Phone_notes");?></a></li>				
						<?php }elseif($selectedLanguage=='it'){?>
						<li class="fileLinks"><span  style="margin-right: 50px;float: left;">
                <a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Self_Admin.html"; ?>" style="cursor:pointer;text-decoration: underline;"  target="_blank"  title="<?php __("re3Phone_videoTip");?>"><?php __("re3Phone_video");?></a>                            
                </span> <a href="<?php echo Configure::read('base_url')."files/RE3_Kundenbrief_VoIP_Phone_de.pdf"; ?>" style="cursor:pointer;text-decoration: underline;float: left;"  target="_blank"  title="<?php __("re3Phone_notesTip");?>"><?php __("re3Phone_notes");?></a> </li>
						<?php  }else{ ?>
						<li class="fileLinks"><span  style="margin-right: 50px;float: left;">
                <a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Self_Admin.html"; ?>" style="cursor:pointer;text-decoration: underline;"  target="_blank"  title="<?php __("re3Phone_videoTip");?>"><?php __("re3Phone_video");?></a>                            
                </span> <a href="<?php echo Configure::read('base_url')."files/RE3_Kundenbrief_VoIP_Phone_de.pdf"; ?>" style="cursor:pointer;text-decoration: underline;float: left;"  target="_blank"  title="<?php __("re3Phone_notesTip");?>"><?php __("re3Phone_notes");?></a> </li>
						<?php } ?>
            
            </ul>	
			</div>
		</div> <?php  }   
		
?>

<?php 
#There was a check here to see if user was internal. removed.
if(1 == 1)	{ 

	?>
<?php
if((isset($success)) ){?>
	
		<div class="notification first" style="width: 534px" >		
			<div class="ok">
				<div class="message">
					<?php echo $success;
					//session_unset($_SESSION['success_msg1']);
					
					?>
					
				</div>
			</div>
		</div>
		
	<?php }elseif(isset($error)){?>
		<div class="notification first" >
			<div class="error">
				<div class="message">
					<?php 
						#echo $error;
						//session_unset($_SESSION['success_msg2']);
						
					?>
				</div>
			</div>
		</div>
	<?php } 
	else{
		
	}?>

<?php $counts = $this->requestAction('customers/updatedcounts/' . $SELECTED_CNN); ?>
<h4 style="margin-left:6px;width:525px;"><?php __("Cockpit Info");?>
              <!--<span style="float: right;font-weight: normal;text-decoration: none !impotant;" >
               <a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Self_Admin.html"; ?>" style="cursor:pointer"  target="_blank"  title="VoIP_Self_Admin video"><?php echo __('VoIP_Self_Admin video') ?></a>             
            </span>-->
</h4>

<div style="margin-left:6px;">
	<h3 style="color: inherit"><?php echo __('News & Warnings',true); ?></h3>
	<!-- <?php echo __('NewsInfo',true); ?> -->
</div>

<div class="eservice-row" style="width:552px; !important">
  <div class="eservice-row-top">
  
    <div class="eservice-row-top-left" style="padding-right: 5px !important; width: 257px !important;">
      <div class="call-to-action">    
      <table class="doku">
	<tr>
	
	<td rowspan="2" valign="top" class="doku-middle">
		<img src="<?php echo Configure::read('base_url');?>images/065_dial_03_rgb_64.png"   />
	    </td>
	<td valign="top" class="doku-right">
		<h3><?php echo $html->link(__('DN List', true), array('controller'=>'dns', 'action'=>'viewdns',"customer_id:$SELECTED_CNN"), array('class'=> $selected['DN'])); ?></h3>
	</td>
	</tr>
	<tr>
	  
	  <td valign="top" class="doku-right">
	    
	    <?php echo substr(__("DNListInfo", true),0,120);
		
		 ?>
		
	    <a href="javascript:;" onclick="Tip(' <?php echo __("DNListInfo_text") ; ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
	    <?php if(strlen(substr(__("DNListInfo", true),0,120))<120){echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}   ?>
		
	    </td>
	  </tr>
	<tr>
	  <td colspan="2" class="doku-middle">&nbsp;</td>
	  </tr>
	  </table>
	</div>
    </div>
 
    <div  class="eservice-row-top-left " style="padding-right: 5px !important; width: 257px !important;">
     
    <div class="call-to-action">    
      <table class="doku">
	<tr>
	
	<td rowspan="2" valign="top" class="doku-middle">
		<img src="<?php echo Configure::read('base_url');?>images/041_office_03_rgb_64.png" />
	    </td>
	<td valign="top" class="doku-right">
		<h3><?php echo $html->link(__('Location List', true), array('controller'=>'locations', 'action'=>'index',$SELECTED_CNN), array('class'=> $selected['Location']));?></h3>
	</td>
	</tr>
	<tr>
	  
	  <td valign="top" class="doku-right">
	    
	    <?php echo substr(__("LocationInfo", true),0,120); ?>
	    
	    
	    <a href="javascript:;" onclick="Tip(' <?php echo __("LocationInfo_text", true); ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
	    
	    <?php if(strlen(substr(__("LocationInfo", true),0,120))<120){echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}   ?>
		
	    </td>
	  </tr>
	<tr>
	  <td colspan="2" class="doku-middle">&nbsp;</td>
	  </tr>
	  </table>
	</div>
  </div>
 
  <?php if($counts['ODS'][$SELECTED_CNN] > 0){ ?>
    <div class="eservice-row-top-left" style="padding-right: 5px !important; width: 257px !important;">
     
      <div class="call-to-action">
     
     <table class="doku">
	<tr>
	
	<td rowspan="2" valign="top" class="doku-middle">
		<img src="<?php echo Configure::read('base_url');?>images/249_forward_03_rgb_64.png" />
	    </td>
	<td valign="top" class="doku-right" style="margin-top: -10px;">
		<h3 style="vertical-align: top"><?php echo $html->link(__('Scenarios', true), array('controller'=>'scenarios', 'action'=>'index', "customer_id:$SELECTED_CNN"), array('class'=> $selected['Scenario'])); ?></h3>
	</td>
	</tr>
	<tr>
	  
	  <td valign="top" class="doku-right">
	   
	    <?php echo substr(__("ScenariosInfo", true),0,120); ?>
	    <a href="javascript:;" onclick="Tip(' <?php echo __("ScenariosInfo_text") ; ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
	    <?php if(strlen(substr(__("ScenariosInfo", true),0,120))<120){echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}   ?>
		
	    </td>
	  </tr>
	<tr>
	  <td colspan="2" class="doku-middle">&nbsp;</td>
	  </tr>
	 </table>
	</div>
    </div>
<?php } ?>
<?php if($counts['Stations'][$SELECTED_CNN] > 0){ ?>
    <div class="eservice-row-top-left" style="padding-right: 5px !important; width: 257px !important;">
     
      <div class="call-to-action">
     
       <table class="doku">
	<tr>
	
	<td rowspan="2" valign="top" class="doku-middle">
		<img src="<?php echo Configure::read('base_url');?>images/121_phonepro_03_rgb_64.png" />
	    </td>
	<td valign="top" class="doku-right">
		<h3><?php echo $html->link(__('Stations', true), array('controller'=>'stations', 'action'=>'index',$SELECTED_CNN), array('class'=> $selected['Station']));?></h3>
	</td>
	</tr>
	<tr>
	  
	  <td valign="top" class="doku-right">
	  
	  <?php echo __('StationsInfo',true); ?>
	    <a href="javascript:;" onclick="Tip(' <?php echo __("StationsInfo_text") ; ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
	    <?php if(strlen(substr(__("StationsInfo", true),0,120))<120){echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}   ?>
		
	    </td>
	  </tr>
	<tr>
	  <td colspan="2" class="doku-middle">&nbsp;</td>
	  </tr>
	   </table>
	</div>
  </div>
<?php } ?>
  
  <?php if($counts['Trunks'][$SELECTED_CNN] > 0){ ?>
    <div class="eservice-row-top-left" style="padding-right: 5px !important; width: 257px !important;">
     
      <div class="call-to-action">
     
       <table class="doku">
	<tr>
	
	<td rowspan="2" valign="top" class="doku-middle">
		<img src="<?php echo Configure::read('base_url');?>images/079_pbx_03_rgb_64.png" />
	    </td>
	<td valign="top" class="doku-right">
		<h3><?php echo $html->link(__('Trunk', true), array('controller'=>'trunks', 'action'=>'index/'.$SELECTED_CNN), array('class'=> $selected['Trunk'])); ?></h3>
	</td>
	</tr>
	<tr>
	  
	  <td valign="top" class="doku-right">
	  
	    <?php echo substr(__("TrunkInfo", true),0,120); ?>
	    <a href="javascript:;" onclick="Tip(' <?php echo __("TrunkInfo_text") ; ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
	    <?php if(strlen(substr(__("TrunkInfo", true),0,120))<120){echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}   ?>
		
	    </td>
	  </tr>
	<tr>
	  <td colspan="2" class="doku-middle">&nbsp;</td>
	  </tr>
	   </table>
	</div>
    </div>
<?php } ?>	
    <div class="eservice-row-top-left" style="padding-right: 5px !important; width: 257px !important;">
    
      <div class="call-to-action">
     
      <table class="doku">
	<tr>
	
	<td rowspan="2" valign="top" class="doku-middle">
		<img src="<?php echo Configure::read('base_url');?>images/045_information_03_rgb_64.png" />
	    </td>
	<td valign="top" class="doku-right">
		 <h3>
		 <?php 
		 
		if ($userpermission == Configure::read('access_id')) {
       	 	echo $html->link(__('Reports', true), array('controller'=>'customers', 'action'=>'reports'), array('class'=> $selected['Reports']));
        }
        else
        {
       		 echo __('Reports', true);
        }
        ?></h3>
		
	</td>
	</tr>
	<tr>
	  
	  <td valign="top" class="doku-right">
	 
	    <?php echo substr(__("ReportsInfo", true),0,120); ?>
	    <a href="javascript:;" onclick="Tip(' <?php echo __("ReportsInfo_text") ; ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
	    <?php if(strlen(substr(__("ReportsInfo", true),0,120))<120){echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}   ?>
		
	    </td>
	  </tr>
	<tr>
	  <td colspan="2" class="doku-middle">&nbsp;</td>
	  </tr>
	  </table>
	</div>
  </div>

 
  <?php if($counts['Mediatrix'][$SELECTED_CNN] > 0){ ?>
    <div class="eservice-row-top-left" style="padding-right: 5px !important; width: 257px !important;">
      
      <div class="call-to-action">
     
      <table class="doku">
	<tr>
	
	<td rowspan="2" valign="top" class="doku-middle">
		<img src="<?php echo Configure::read('base_url');?>images/184_gateway_03_rgb_64.png" />
	    </td>
	<td valign="top" class="doku-right">
		 <h3><?php echo $html->link(__('Mediatrix', true), array('controller'=>'mediatrixes', 'action'=>'index', "customer_id:$SELECTED_CNN"), array('class'=> $selected['Mediatrix'])); ?></h3>
	</td>
	</tr>
	<tr>
	  
	  <td valign="top" class="doku-right">
	   
	    <?php echo substr(__("MediatrixInfo", true),0,120); ?>
	    <a href="javascript:;" onclick="Tip(' <?php echo __("MediatrixInfo_text") ; ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
	    <?php if(strlen(substr(__("MediatrixInfo", true),0,120))<120){echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}   ?>
		
		
	    </td>
	  </tr>
	<tr>
	  <td class="doku-middle">&nbsp;</td>
	  <td valign="top" class="doku-right">&nbsp;</td>
	  </tr>
	  </table>
	</div>
    </div>
<?php } ?>
<?php if($counts['Groups'][$SELECTED_CNN] > 0){ ?>
    <div class="eservice-row-top-left" style="padding-right: 5px !important; width: 257px !important;">
     
      <div class="call-to-action">
     
     <table class="doku">
	<tr>
	<td rowspan="2" valign="top" class="doku-middle">
		<img src="<?php echo Configure::read('base_url');?>images/192_group_03_rgb_64.png" />
	    </td>
	<td valign="top" class="doku-right">
		 <h3><?php echo $html->link(__('Group List', true), array('controller'=>'groups', 'action'=>'numbergroups',"customer_id:$SELECTED_CNN"), array('class'=> $selected['Group']));?></h3>
	</td>
	</tr>
	<tr>
	  <td valign="top" class="doku-right" >
	    <?php echo substr(__("GroupListInfo", true),0,120); ?>
	    <a href="javascript:;" onclick="Tip(' <?php echo __("GroupListInfo_text") ; ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
	    <?php if(strlen(substr(__("GroupListInfo", true),0,120))<120){echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}   ?>
	    </td>
	  </tr>



	<tr>
	  <td class="doku-middle">&nbsp;</td>
	  <td valign="top" class="doku-right">&nbsp;</td>
	  </tr>
	 </table>
	</div>
  </div>
  <div class="eservice-row-top-left" style="padding-right: 5px !important; width: 257px !important;">
     
      <div class="call-to-action">
     
     <table class="doku">
	<tr>
	<td rowspan="2" valign="top" class="doku-middle">
		<img src="<?php echo Configure::read('base_url');?>images/398_social_network_03_rgb_64.png" />
	    </td>
	<td valign="top" class="doku-right">
		 <h3><?php echo $html->link(__('cpuGroupList', true), array('controller'=>'groups', 'action'=>'pickupgroups',"customer_id:$SELECTED_CNN"), array('class'=> $selected['Group']));?></h3>
	</td>
	</tr>
	<tr>
	  <td valign="top" class="doku-right" >
	    <?php echo substr(__("cpuGroupListInfo", true),0,120); ?>
	    <a href="javascript:;" onclick="Tip(' <?php echo __("cpuGroupListInfo_text") ; ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
	    <?php if(strlen(substr(__("cpuGroupListInfo", true),0,120))<120){echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}   ?>
	    </td>
	  </tr>
	<tr>
	  <td class="doku-middle">&nbsp;</td>
	  <td valign="top" class="doku-right">&nbsp;</td>
	  </tr>
	 </table>
	</div>
  </div>
<?php } ?>
  </div>
  
</div>

<div style="margin:left:5px;">
	<!--  <h3><?php echo __('Terms & Conditions',true); ?></h3>
	  <?php echo __('termsInfo',true); ?>
	-->
</div>
<?php } else { ?>




<h4><?php __("Options");?></h4>

<div class="eservice-row">
  <div class="eservice-row-top">
    <div class="eservice-row-top-left">
      <h3><a href="/voipphone" ><?php __("GateStatistics");?><br>(<?php __("GStatsDesc");?>)</a></h3>
      <p>
     
      <table class="doku">
	<tr>
	
	<td class="doku-middle">
		<a href=""><?php __("stations");?></a>
	</td>
	<td class="doku-right">
		<a href="">17232</a>
	</td>
	</tr>
	<tr>
	
	<td class="doku-middle">
		<a href=""><?php __("Used DNS");?></a>
	</td>
	<td class="doku-right">
		<a href="">999</a>
	</td>
	</tr>
	<tr>
	<td class="doku-middle">
		<a href=""><?php __("Free DNS");?></a>
	</td>
	<td class="doku-right">
		<a href="">888</a>
	</td>
	</tr>
	<tr>	
		<td class="doku-middle">
		<a href=""><?php __("otherStat");?></a>
	</td>
	<td class="doku-right">
		<a href="">676</a>
	</td>
	</tr>
	</table>
	</p>
    </div>
    <div class="eservice-row-top-right">
     <h3><a href="/voipphone" ><?php __("PhoneStatistics");?><br>(<?php __("PStatsDesc");?>)</a></h3>
      <p>
     
      <table class="doku">
	<tr>
	
	<td class="doku-middle">
		<a href=""><?php __("Scenarios");?></a>
	</td>
	<td class="doku-right">
		<a href="">17232</a>
	</td>
	</tr>
	<tr>
	
	<td class="doku-middle">
		<a href=""><?php __("PBXDNs");?></a>
	</td>
	<td class="doku-right">
		<a href="">999</a>
	</td>
	</tr>
	
	<tr>	
		<td class="doku-middle">
		<a href=""><?php __("otherStat");?></a>
	</td>
	<td class="doku-right">
		<a href="">676</a>
	</td>
	</tr>
	</table>
	</p>
  </div>
  </div>
  <div class="eservice-row-bottom">
    <div class="eservice-row-bottom-left">
      <div class="button-right">
        <a href="/scenarios/index/customer_id:<?php echo $SELECTED_CUSTOMER ?>"  onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)">Starten</a>
      </div>
      <div class="clear-both"></div>
    </div>
    <div class="eservice-row-bottom-right">
      <div class="button-right">
        <a href="/scenarios/index/customer_id:<?php echo $SELECTED_CUSTOMER ?>"  onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)">Starten</a>
      </div>
      <div class="clear-both"></div>
    </div>
  </div>
</div>

<div class="eservice-row">
  <div class="eservice-row-top">
    <div class="eservice-row-top-left">
      <h3><a href="/portal/index/alleeservices/voip/voip-phone/form-voip-phone-change.htm" ><?php __("Options");?><br>(<?php __("OptionDesc");?>)</a></h3>
      <ul>
      <li>ODS</li>
      <li>CTI</li>
      <li>MOH</li>
      <li>PPP</li>
      <li>GGG</li>
      </ul>
    </div>
    <div class="eservice-row-top-right">
      <h3><a href="/portal/index/alleeservices/voip/voip-phone/form-voip-phone-gruppe.htm" ><?php __("Usage");?><br>(<?php __("UsagenDesc");?>)</a></h3>
      <p>
     
      <table class="doku">
	<tr>
	
	<td class="doku-middle">
		<a href=""><?php __("Scenarios Activated");?></a>
	</td>
	<td class="doku-right">
		<a href="">17232</a>
	</td>
	</tr>
	<tr>
	
	<td class="doku-middle">
		<a href=""><?php __("Station modifications");?></a>
	</td>
	<td class="doku-right">
		<a href="">17232</a>
	</td>
	</tr>
	<tr>
	
	<td class="doku-middle">
		<a href=""><?php __("Logons");?></a>
	</td>
	<td class="doku-right">
		<a href="">999</a>
	</td>
	</tr>
	
	<tr>	
		<td class="doku-middle">
		<a href=""><?php __("otherStat");?></a>
	</td>
	<td class="doku-right">
		<a href="">676</a>
	</td>
	</tr>
	</table>
	</p>
   </div>
  </div>
  <div class="eservice-row-bottom">
    <div class="eservice-row-bottom-left">
      <div class="button-right">
        <a href="/scenarios/index/customer_id:<?php echo $SELECTED_CUSTOMER ?>"  onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)">Starten</a>
      </div>
      <div class="clear-both"></div>
    </div>
    <div class="eservice-row-bottom-right">
      <div class="button-right">
        <a href="/scenarios/index/customer_id:<?php echo $SELECTED_CUSTOMER ?>"  onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)">Starten</a>
      </div>
      <div class="clear-both"></div>
    </div>
  </div>
</div>

<?php } ?>


<div style="display:block">	
                <!--<h4 style="display:block;float:left;width: 100%;"><?php echo __('Recent Activity'); ?> <a class="maintopRelatedContentButton" id="maintopContentButton" onclick="return toggleShowHistory();" href="javascript:void(0)" style="float:right;"> -->
                <h4 style="margin-left:6px;width:525px;"><?php echo __('Recent Activity'); ?> <a class="maintopRelatedContentButton" id="maintopContentButton" onclick="return toggleShowHistory();" href="javascript:void(0)" style="float:right;">
                        
                        <div style="width:20px;background:#eee; height:20px;" id="pbtn">
                            <div id="plus"></div>
                        </div>
                        <div style="width:20px;background:#eee; height:20px;" id="mbtn">
                            <div id="minus"></div>
                        </div>
                    </a></h4> 
            </div>



<?php
	$show = 'none';
	
		
	if (isset($showHistory)) {
	
    	$readonly = 'true';
        $show = 'block';
    } 
    ?>


<div id="showhistory" class="table-content" style="display:<?php echo $show; ?>">


<p>Table showing last 5 records from <?php 
if ($userpermission == Configure::read('access_id')) {
	echo $html->link(__('activitLog', true),  array('controller'=> 'logs', 'action'=>'viewlog', 'customer_id:'.$SELECTED_CUSTOMER_NAME));
}
?> </p>
 				


	 <table id="example dnslistdata" class="dataTable tablesorter phonekey" cellpadding="0" cellspacing="0" style="width:98%; margin-left:5px; border-top-color:#CCC">
			    	
			<thead>
						<tr class="table-top">
							<th class="table-column" style="text-align: left" > <?php echo __('affected_obj');?></th>
							<th class="table-column" style="text-align: left"> <?php echo __('Created');?></th>
							<th class="table-column" style="text-align: left"> <?php echo __('User');?></th>
							<th class="table-column" style="text-align: left"> <?php echo __('log_entry');?></th>
							<th class="table-column" style="text-align: left"> <?php echo __('Status');?></th>
							
						</tr>
						
			</thead>
	        <tbody>
	        	<?php

	
				// loop through and display format
				foreach($loginfo as $log):

				
				?>
	            	<tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">
	             	<td class="withdatatablecss"> <?php 
	             	if ( substr($log['Log']['log_entry'], 0, 8) == 'Scenario')
	             	{
	             		echo $html->link($log['Log']['affected_obj_name'],  array('controller'=> 'scenarios', 'action'=>'edit', 'scenario_id:'.$log['Log']['affected_obj']));
	             	}
	             	else
	             	{
	             		echo $log['Log']['affected_obj']; 
	             	}
	             	?>
	             	</td>
	                <td style="width:70px;" class="withdatatablecss">
	                <?php 
	                $formatted_date = date('d.m.Y H:i:s',strtotime($log['Log']['created']));
	                preg_match("/^(.*) (.*)/", $formatted_date, $matches);
					if ($matches[0]) 
					{
	               	 	#$datetime2line = $matches[1] . '<br>' . $matches[2];
	               	 	echo $matches[1] ;
	               	 	echo $matches[2] ;
					}else{
	                	echo $log['Log']['created'] ;
	                }
	                ?>
	               </td>
	                <td style="width:50px;" class="withdatatablecss">
	                <?php echo $log['Log']['user'] ?>
	           		</td>
	                 <td class="withdatatablecss"> <?php echo $log['Log']['log_entry'] ?></td>
	                 <td class="withdatatablecss"><?php echo $log['Log']['modification_status']?'Success':'Failed' ?></td>
	          		 
	           </tr>
	         	<?php 
				endforeach;
				?>
	        </tbody>
			</table>

</div>
		
</div>


		
		</div>


		<div id="related-content">
		<div class="box start link">
				<a href="http://www.swisscom.ch/grossunternehmen" target="_blank">Home Swisscom</a>
		</div>
		<?php if ($userpermission == Configure::read('access_id')) {
        ?>
		
		<div class="box call-to-action-right">
			<div class="info info-warning`	" style="z-index: 2">
				<a href="" id="warningNotification">&nbsp;</a></div><h3><?php __("notifications");?></h3>
				<!-- <p><?php __("InWork Objects");?>.</p>-->
			<div>
			
			<ul>
				<?php echo $this->element('right_notifications',array('SELECT_CUSTOMER' => $SELECTED_CNN)); ?>
            </ul>	
			</div>
		</div>
		
		
		<?php }?>
		
		
		
		
		<div class="box">
			<h3><?php __("miniStatistic");?></h3>
			  <!-- <p><?php __("Totals");?></p> -->
			<p><table class="doku">
			<tr>
	
			
			<td class="doku-middle">
				<?php __("nrOfDn");?>
			</td>
			
			<td class="doku-right">
				<?php echo $DNCount; ?>
			</td>
			</tr>
			<tr>
			<td class="doku-middle">
				<?php __("nrOfLocation");?>
			</td>
			
			<td class="doku-right">
				<?php echo $locTotalCount; ?>
			</td>
			</tr>
			<?php if($scenarioTotalCount > 0){ ?>
			<tr>
			<td class="doku-middle">
				<?php __("nrOfScenarios");?>
			</td>
			
			<td class="doku-right">
				<?php echo $scenarioTotalCount; ?>
			</td>
			</tr>
			<?php } ?>
			<?php if($stationTotalCount > 0){ ?>
			<tr>
			<td class="doku-middle">
				<?php __("nrOfStations");?>
			</td>
			
			<td class="doku-right">
				<?php echo $stationTotalCount; ?>
			</td>
			</tr>
			<?php } ?>
			
			<?php if($trunkTotalCount > 0){ ?>
			<tr>
			<td class="doku-middle">
				<?php __("nrOfTrunk");?>
			</td>
			
			<td class="doku-right">
				<?php echo $trunkTotalCount; ?>
			</td>
			</tr>
			<?php } ?>
			<?php if($mediatrixTotalCount > 0){ ?>
			<tr>
			<td class="doku-middle">
				<?php __("nrOfMediatrix");?>
			</td>
			
			<td class="doku-right">
				<?php echo $mediatrixTotalCount; ?>
			</td>
			</tr>
			<?php } ?>
			<?php if($groupMadnTotalCount > 0){ ?>
			<tr>
			<td class="doku-middle">
				<?php __("nrOfMadnGroups");?>
			</td>
			
			<td class="doku-right">
				<?php echo $groupMadnTotalCount;?>
			</td>
			</tr>
			<?php } ?>
			<?php if($groupCpuTotalCount > 0){ ?>
			<tr>
			<td class="doku-middle">
				<?php __("nrOfCpuGroups");?>
			</td>
			
			<td class="doku-right">
				<?php echo $groupCpuTotalCount; ?>
			</td>
			</tr>
			<?php } ?>
		
  

		</table></p>
		<p></p>
	<p></p>
	<p></p>
	<p></p>
	<p></p>
	<p></p>
	<p></p>
	<p></p>
	<p></p>
	<p></p>
</div>

<div class="box">

           <?php
				 if($custdetail['Customer']['moh_id']!=0){ ?>
				 <h3 style="font-weight: bold !important;"><?php __("mohOption");?></h3>	
				 <ul style="margin: 0px !important">
				 <li><?php  echo __("moh_blurb");
				
				   ?></li>
				 <li>
				<div style="height: 50px !important;">
				 <div class="button-right" style="">
				 <?php
				 
				 	 echo $html->link(__('mohUpload',true), array('controller' => 'Customers', 'action' => 'uploadf/customer_id:'.$SELECTED_CNN), array('class' => 'fancybox fancybox.ajax','onmouseover'=>"hoverButtonRight(this)", 'onmouseout'=>"outButtonRight(this)"));
				
				 
				 ?>
				 </div>
				 </div>
				 
				 <!-- <div>
				  <div class="fl">
											<span>
					<a href="javascript:;" onclick="Tip(' <?php echo __("mohUplad_info") ; ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
											</span>  
                                </div>
								</div>-->
				 </li>
				 </ul>
				 <?php 
				 
				 if( $custdetail['Customer']['type']=="Phone"||$custdetail['Customer']['type']=="Hybrid"){?>
		   
				   <h3><?php __("gateInfo");?></h3>			
					<ul class="fileLinks">
						
				<?php	 $selectedLanguage = $_SESSION['Config']['language'];
						if($selectedLanguage=='de'){ ?>
						<li class="fileLinks" ><a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Self_Admin.html"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Phone_videoTip");?>"><?php __("re3Phone_video");?></a> </li>
						<li class="fileLinks" ><a href="<?php echo Configure::read('base_url')."files/Inbetriebnahmeanleitung_IP_Phone_11x.pdf"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("phoneIbs_guideTip");?>"><?php __("phoneIbs_guide");?></a> </li>
						<li class="fileLinks" ><a href="<?php echo Configure::read('base_url')."files/Phone_Broschure-de.pdf"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Phone_guideTip");?>"><?php __("re3Phone_guide");?></a> </li>
						
						<?php   }elseif ($selectedLanguage=='fr'){?>
						<li class="fileLinks" ><a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Self_Admin_fr.html"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Phone_videoTip");?>"><?php __("re3Phone_video");?></a> </li>
						<li class="fileLinks" ><a href="<?php echo Configure::read('base_url')."files/Phone_Broschure-de.pdf"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Phone_guideTip");?>"><?php __("re3Phone_guide");?></a> </li>
						
						<?php }elseif($selectedLanguage=='it'){?>
						<li class="fileLinks" ><a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Self_Admin.html"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Phone_videoTip");?>"><?php __("re3Phone_video");?></a> </li>
						<li class="fileLinks" ><a href="<?php echo Configure::read('base_url')."files/Phone_Broschure-de.pdf"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Phone_guideTip");?>"><?php __("re3Phone_guide");?></a> </li>
						
						<?php  }else{ ?>
						<li class="fileLinks" ><a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Self_Admin.html"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Phone_videoTip");?>"><?php __("re3Phone_video");?></a> </li>
						<li class="fileLinks"><a href="<?php echo Configure::read('base_url')."files/Phone_Broschure-de.pdf"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Phone_guideTip");?>"><?php __("re3Phone_guide");?></a> </li>
						
						<?php } ?>
					
			      </ul>
		   
		   <?php }?>
				 
				 <?php
		
		    if( $custdetail['Customer']['type']=="Gate"||$custdetail['Customer']['type']=="Gate +"){?>
		   
		   <h3><?php __("gateInfo");?></h3>			
			<ul style="list-style:none;margin:0 !important;padding:0 !important;">
					
					<?php	 $selectedLanguage = $_SESSION['Config']['language'];
						if($selectedLanguage=='de'){ ?>
						<li class="fileLinks"><a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Gate.html"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Gate_videoTip");?>"><?php __("re3Gate_video");?></a> </li>
						<li class="fileLinks"><a href="<?php echo Configure::read('base_url')."files/Anleitung_OnDemandSchaltung_RE3.pdf"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Ods_guideTip");?>"><?php __("re3Ods_guide");?></a> </li>
						
						<?php   }elseif ($selectedLanguage=='fr'){?>
						<li class="fileLinks"><a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Gate.html"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Gate_videoTip");?>"><?php __("re3Gate_video");?></a> </li>
						<li class="fileLinks"><a href="<?php echo Configure::read('base_url')."files/Anleitung_OnDemandSchaltung_RE3_f.pdf"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Ods_guideTip");?>"><?php __("re3Ods_guide");?></a> </li>
						
						<?php }elseif($selectedLanguage=='it'){?>
						<li class="fileLinks"><a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Gate.html"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Gate_videoTip");?>"><?php __("re3Gate_video");?></a> </li>
						<li class="fileLinks"><a href="<?php echo Configure::read('base_url')."files/Anleitung_OnDemandSchaltung_RE3.pdf"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Ods_guideTip");?>"><?php __("re3Ods_guide");?></a> </li>
						
						<?php  }else{ ?>
						<li class="fileLinks"><a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Gate.html"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Gate_videoTip");?>"><?php __("re3Gate_video");?></a> </li>
						<li class="fileLinks"><a href="<?php echo Configure::read('base_url')."files/Anleitung_OnDemandSchaltung_RE3.pdf"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Ods_guideTip");?>"><?php __("re3Ods_guide");?></a> </li>
						
						<?php } ?>
			      </ul>
		   
		   <?php } ?>
				 
				 <?php   
				 
				  }else{ ?>
           <?php
		
		    if( $custdetail['Customer']['type']=="Gate"||$custdetail['Customer']['type']=="Gate +"){?>
		   
		   <h3><?php __("gateInfo");?></h3>			
			<ul style="list-style:none;margin:0 !important;padding:0 !important;">
					<?php	 $selectedLanguage = $_SESSION['Config']['language'];
						if($selectedLanguage=='de'){ ?>
						<li class="fileLinks"><a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Gate.html"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Gate_videoTip");?>"><?php __("re3Gate_video");?></a> </li>
						<li class="fileLinks"><a href="<?php echo Configure::read('base_url')."files/Anleitung_OnDemandSchaltung_RE3.pdf"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Ods_guideTip");?>"><?php __("re3Ods_guide");?></a> </li>
						
						<?php   }elseif ($selectedLanguage=='fr'){?>
						<li class="fileLinks"><a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Gate.html"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Gate_videoTip");?>"><?php __("re3Gate_video");?></a> </li>
						<li class="fileLinks"><a href="<?php echo Configure::read('base_url')."files/Anleitung_OnDemandSchaltung_RE3_f.pdf"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Ods_guideTip");?>"><?php __("re3Ods_guide");?></a> </li>
						
						<?php }elseif($selectedLanguage=='it'){?>
						<li class="fileLinks"><a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Gate.html"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Gate_videoTip");?>"><?php __("re3Gate_video");?></a> </li>
						<li class="fileLinks"><a href="<?php echo Configure::read('base_url')."files/Anleitung_OnDemandSchaltung_RE3.pdf"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Ods_guideTip");?>"><?php __("re3Ods_guide");?></a> </li>
						
						<?php  }else{ ?>
						<li class="fileLinks"><a href="<?php echo Configure::read('base_url')."files/VoIP_Self_Admin/VoIP_Gate.html"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Gate_videoTip");?>"><?php __("re3Gate_video");?></a> </li>
						<li class="fileLinks"><a href="<?php echo Configure::read('base_url')."files/Anleitung_OnDemandSchaltung_RE3.pdf"; ?>" style="cursor:pointer"  target="_blank"  title="<?php __("re3Ods_guideTip");?>"><?php __("re3Ods_guide");?></a> </li>
						
						<?php } ?>
					
					
					
			      </ul>
		   
		   <?php }else{ ?>
		   

			<h3><?php __("service Options");?></h3>			
			<ul style="list-style:none;margin:0 !important;padding:0 !important;">
				
				<?php if( $custdetail['Customer']['ONB']=="1"){?>
				<li>
				 <div class="fl"><?php echo __('nameONB'); ?> </div>
				  <?php if( $custdetail['Customer']['ONB']=="1"){?>
					         <div>
                                <div class="fl">
											<span>
					<a href="javascript:void(null);" onclick="Tip(' <?php echo __("service_Options_ONB") ; ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
											</span>  
                                </div>
								</div>
				
				
				<?php }else{ echo ":".$custdetail['Customer']['ONB'];}  ?>
					
				</li>
				<?php } ?>
				 <?php if( $custdetail['Customer']['CD']=="1"){?>
				<li>
				<div class="fl"><?php echo __('nameCD'); ?> </div> <?php if( $custdetail['Customer']['CD']=="1"){?>
					         <div>
                                <div class="fl">
											<span>
					<a href="javascript:;" onclick="Tip(' <?php  echo __("service_Options_CD"); ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
											</span>  
                                </div>

								</div>
				
				
				<?php }else{ echo ":".$custdetail['Customer']['CD'];} ?></li>
				<?php } ?>
				<?php if( $custdetail['Customer']['NSC']=="1"){?>
				<li>
				<div class="fl"><?php echo __('nameNSC'); ?> </div><?php if( $custdetail['Customer']['NSC']=="1"){?>
					         <div>
                                <div class="fl">
											<span>
					<a href="javascript:;" onclick="Tip(' <?php echo __("service_Options_NSC"); ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
											</span>  
                                </div>
								</div>
				
				
				<?php }else{ echo ":".$custdetail['Customer']['CFRA']; } ?></li>
				<?php } ?>
				<?php if( $custdetail['Customer']['CFRA']=="1"){?>
				<li>
				<div class="fl"><?php echo __('nameCFRA'); //echo __('CFRA'); ?> </div><?php if( $custdetail['Customer']['CFRA']=="1"){?>
					         <div>
                                <div class="fl">
											<span>
					<a href="javascript:;" onclick="Tip(' <?php echo __("service_Options_CFRA") ; ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
											</span>  
                                </div>
								</div>
				
				
				<?php }else{ echo ":".$custdetail['Customer']['CTI']; } ?></li>
				<?php } ?>
				<?php if( $custdetail['Customer']['CTI']=="1"){?>
				<li>
				<div class="fl"><?php echo __('nameCTI');?> </div><?php if( $custdetail['Customer']['CTI']=="1"){?>
					         <div>
                                <div class="fl">
											<span>
					<a href="javascript:;" onclick="Tip(' <?php echo __("service_Options_CTI") ; ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
											</span>  
                                </div>
								</div>
				
				
				<?php }else{ echo ":".$custdetail['Customer']['CTI'];} ?></li>
				<?php } ?>
				
				<?php if( $custdetail['Customer']['SLA']!=""){?>
				<li>
				<?php echo __('nameSLA');?> 	         			
				
				<?php echo " ".$custdetail['Customer']['SLA']; ?>
					
				</li>
				<?php } ?>
				
				
				
				<?php if( $custdetail['Customer']['OC']=="1"){?>
				<li>
				<div class="fl"><?php echo __('nameOC'); ?> </div> <?php if( $custdetail['Customer']['OC']=="1"){?>
					         <div>
                                <div class="fl">
											<span>
					<a href="javascript:;" onclick="Tip(' <?php echo __("service_Options_OC") ; ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
											</span>  
                                </div>
								</div>
				
				
				<?php }else{ echo ":".$custdetail['Customer']['OC'];} ?></li>
				<?php }
				
				 ?>
				 
			</ul>
			<?php   }    ?>
			<?php   }    ?>
			
		<h3><?php __("supportInfo");?></h3>
		<p>
			
	    <p href="javascript:;" onmouseover="Tip(' <?php echo __("supportAdmin_info") ; ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " style="float:left" ><?php 
	       		echo substr(__("supportAdmin", true),0,120); ?></p>
	    <?php if(strlen(substr(__("", true),0,120))<120){echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}   ?>
			</p>	
			
		
</div>

<?php if ($userpermission == Configure::read('access_id')) {
        ?>
        <div class="box info">
            <h3><?php __('Internal User') ?></h3>
            <p><?php echo $selected_customer . '('. $SELECTED_CNN. ')'; ?></p>
            <p><?php echo $locpro_nr['Location']['pro_nr']; ?></p>
       </div>


    <?php 
    		if ($_SESSION['VIEWMODE'] == 'EXTERNAL')
    		{
    			echo $html->link(__("scmView", true), array('controller' => 'customers', 'action' => 'toggleView?customer_id=' . $SELECTED_CNN . '&view=INTERNAL'));
    		}
    		else
    		{
    			echo $html->link(__("userView", true), array('controller' => 'customers', 'action' => 'toggleView?customer_id=' . $SELECTED_CNN . '&view=EXTERNAL'));
    		}
        } ?>

</div>

<!--  -->


<script type="text/javascript">
        function toggleAdvanceSearch() {
            //$("#advancesearch").show
            if (document.getElementById('advancesearch').style.display == 'none') {
                document.getElementById('advancesearch').style.display = 'block';
            } else {
                document.getElementById('advancesearch').style.display = 'none';
            }

        }
    </script>


<script>
<!--ight hand side  ends here-->
function submi_formsss(form_id)
{	
	$('#'+form_id).submit();
} 

<!--right hand side  ends here-->
</script>
