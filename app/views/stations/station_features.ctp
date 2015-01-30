<link rel="stylesheet" href="//google-code-prettify.googlecode.com/svn/trunk/src/prettify.css" type="text/css"/>
<script type="text/javascript" src="//google-code-prettify.googlecode.com/svn/trunk/src/prettify.js"></script>
<style>
    .form-left{
    padding-bottom: 2px !important;
  }
  .form-label {
      width:140px !important;
    }
  #cfrapin .text {
      width:120px !important;
    }
  #cfrapin label {
      width:17px !important;
    }   
  .morewidth {
    width:268px !important;
  }
  
  .form-box .form-right{
    width: 265px !important;
  }
  
  .form-right .blurb_text {
    margin-left:10px !important;
  }
  .form-left input[type="checkbox"]{
    /*width: 50px !important; */
    margin-left: 60px !important;
    
  }
  .form-right input[type="checkbox"]{
    margin-left: 60px !important;
    
  }
  h4{
    padding-top: 10px !important;
  }
  #modalPopLite-mask10{
  	display: none !important;
   
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
  }
 
</style>
<style type="text/css">
/* CSS for modelpopup */
     
#clicker21	{	cursor:pointer;	}

#popup-wrapper21{
	width:390px;
	height: auto;
    padding: 10px 10px 40px;
	background-color:#F9F9F9;
	
}

		
		

	</style>

<script type="text/javascript"> 
    $(document).ready(function() { //alert("ret");
	
	
	$('#collapse').hide();   
	
  
  //simring station member
  
  if($('#StationSIMRINGMEMBER1').val()!=""){
    
      $('#StationSIMRINGMEMBER2').parent().parent().show();
    
  }
  else{ 
    $('#StationSIMRINGMEMBER2').parent().parent().hide();
    }
    
    
    if($('#StationSIMRINGMEMBER2').val()!=""){
      $('#StationSIMRINGMEMBER2').parent().parent().show();
    if($('#StationSIMRINGMEMBER3').val()!=""){
		    $('#StationSIMRINGMEMBER1').parent().parent().show();
		  $('#StationSIMRINGMEMBER2').parent().parent().show();
    $('#StationSIMRINGMEMBER2add2').hide();
    }
    else{
      $('#StationSIMRINGMEMBER2add2').show();
    }
  }
  else{
    $('#StationSIMRINGMEMBER3').parent().parent().hide();
    
    }
    
    if($('#StationSIMRINGMEMBER3').val()!=""){
		   $('#StationSIMRINGMEMBER1').parent().parent().show();
		  $('#StationSIMRINGMEMBER2').parent().parent().show();
      $('#StationSIMRINGMEMBER4').parent().parent().show();
    if($('#StationSIMRINGMEMBER4').val()!=""){
		
		 $('#StationSIMRINGMEMBER1').parent().parent().show();
		  $('#StationSIMRINGMEMBER2').parent().parent().show();
      $('#StationSIMRINGMEMBER3').parent().parent().show();
    $('#StationSIMRINGMEMBER3add3').hide();
    }
    else{
      $('#StationSIMRINGMEMBER3add3').show();
    }
  }
  else{
    $('#StationSIMRINGMEMBER4').parent().parent().hide();
    $('#StationSIMRINGMEMBER3add3').hide();
    }
    
    if($('#StationSIMRINGMEMBER4').val()!=""){
      $('#StationSIMRINGMEMBER4').parent().parent().show();
    
  }
  
  
  
     
     $('#StationSIMRINGMEMBER1,#StationSIMRINGMEMBER2,#StationSIMRINGMEMBER3,#StationSIMRINGMEMBER4').keyup(function(){
     var memberValue = $(this).val();
     var memberValueSize = memberValue.length;
     
     if(memberValueSize>4 && memberValueSize<15 ){
      var elementId = $(this).attr("id");
    var position = elementId.indexOf("StationSIMRINGMEMBER");  
    var idpart = (parseInt( elementId.substr(20,21))+1).toString();
    var nextId = "StationSIMRINGMEMBER"+idpart;
    
    $('#'+nextId).parent().parent().show();
    
    //elementId.slice(0,i)+ '/page:'+TargetPage + elementId.substr(i+exactpostion);
     }
      
      
     });
     
     
      
  
     $('#StationSIMRINGMEMBER1add1').click(function(){
      $('#StationSIMRINGMEMBER2').parent().parent().show();
     });
      $('#StationSIMRINGMEMBER2add2').click(function(){
      $('#StationSIMRINGMEMBER3').parent().parent().show();
     });
      $('#StationSIMRINGMEMBER3add3').click(function(){
      $('#StationSIMRINGMEMBER4').parent().parent().show();
     });
  
  
  
  
  
  
  
  
  
  
  
  
  //stting value of loacation
  var location=$('#location_name').html();
    $('#loc_name').html(location);
  
  
  
  
        $('#dragdroptbl').tableDnD({ 
            onDragStart: function(table, row) { 
                //$(table).parent().find('.result').text('');
            }, 
            onDrop: function(table, row) {
        var rows = table.tBodies[0].rows; alert(rows);
                $('#AjaxResult').load(base_url+"stations/editstation?"+$.tableDnD.serialize());
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
              // alert(pos+"=="+original_position);
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

    validation = {
          // Specify the validation rules
          'rules': {                     
            'StationDescription':{
                  'max': '50'
                  
              },     
          
              'cfrapinid' : {
                'isValue' : 'StationCFRAPIN'
              }
			  ,
              'StationCFRAPIN' : {
			  	'required': true,
                  'min' : '4',
                  'max' : '10',
                  'notSpace' : true
              },
			  
              'simid' : {
                'isValue' : 'StationSIMRINGMEMBER'
              },
              'StationSIMRINGMEMBER1' : {
                  'min' : '4',
                  'max' : '15',
                  'notSpace' : true
              },
              'StationSIMRINGMEMBER2' : {
                  'min' : '4',
                  'max' : '15',
                  'notSpace' : true            
              },
               'StationSIMRINGMEMBER3' : {
                  'min' : '4',
                  'max' : '15',
                  'notSpace' : true
              },              
               'StationSIMRINGMEMBER4' : {
                  'min' : '4',
                  'max' : '15',
                  'notSpace' : true
              },            
          },         

          // Specify the validation error messages
          'messages': {  
            'StationDescription': {
                  'max': "<?php __('max50')  ?>"
              },  

              'cfrapinid': {
                   'isValue': "<?php __('__StationCFRAPINcannotActivateBlank')?>",
                   'max': "<?php __('max10')  ?>",
                   'min': "<?php __('min4')  ?>"           
              }
			  ,
              'StationCFRAPIN': {
			  	 'required': "<?php __('enterValue')?>",
                'min': "<?php __('min4')  ?>",      
            	  'max': "<?php __('max10')  ?>",
                'notSpace': "<?php __('spaceNotAllowed')  ?>"
              },
			  
              'simid': {
                   'isValue': "<?php __('__StationSIMRINGMEMBERcannotActivateBlank')?>"           
              },
              'StationSIMRINGMEMBER1': {
                'min': "<?php __('min4')  ?>",      
            	  'max': "<?php __('max15')  ?>",
                'notSpace': "<?php __('spaceNotAllowed')  ?>"
              },
              'StationSIMRINGMEMBER2': {
                'min': "<?php __('min4')  ?>",      
            	  'max': "<?php __('max15')  ?>",
                'notSpace': "<?php __('spaceNotAllowed')  ?>"   
              },
              'StationSIMRINGMEMBER3': {
                 'min': "<?php __('min4')  ?>",      
            	  'max': "<?php __('max15')  ?>",
                'notSpace': "<?php __('spaceNotAllowed')  ?>"   
              },
              'StationSIMRINGMEMBER4': {
                 'min': "<?php __('min4')  ?>",      
            	  'max': "<?php __('max15')  ?>",
                'notSpace': "<?php __('spaceNotAllowed')  ?>"   
              }
          },
      };
	  
	  function reapply(){
		var url = "<?php echo Configure::read('base_url');?>stations/reapplyTransaction/station_id:<?php echo $display['affected_obj']?>&transaction_id=<?php echo $transaction['id']?>";
		$('.black_overlay').css('display','block');
        $.fancybox.showLoading();
		window.location.href=url;
	}
	  
	  
  function submitForm(){

    if (inValidate(validation)) {   
        return false;
      } else {

        
        for (i=1;i<=4;i++) {
          var temp1 = $("#StationSIMRINGMEMBER"+i).val();
          if ($("#StationSIMRINGMEMBER"+i).hasClass('form-change')) {

            for (j=1;j<=4;j++) {           
              //var j = 1 + i;
              if (i != j) {
                var temp2 = $("#StationSIMRINGMEMBER"+j).val();
                if ((temp2 != "") && (temp2 == temp1)) {
                  $('.fancybox-overlay #overlay-error .error .message').text("<?php echo __('SIMRINGMEMBERUnique') ?>");
                  $('.fancybox-overlay #overlay-error').removeClass('hide');

                  $("#StationSIMRINGMEMBER"+j).removeClass('form-change');
                  $("#StationSIMRINGMEMBER"+j).addClass('error');
                  //alert("wrong");
                  return false;
                }
              }
              
            }//inner

          }
        }//end outer for
	
        
  
      $('.filtersForm').attr('action',base_url+'stations/updateStationFeatures/<?php echo $statId; ?>');
      $('.black_overlay').css('display','block');
	  //$('#overlayImg').attr("src","<?php echo Configure::read('base_url');?>img/assets/ajax-loader.gif");
	  
	   $.fancybox.showLoading();	
      $('.filtersForm').attr('method','POST');
	     setTimeout(function() {
		 	
           $.ajax({
        type: "POST",
        async : true,
        url: $('.filtersForm').attr('action'),
        data: $('.filtersForm').serialize(),
        success: function(data){   
		
		
		if(trim(data)=="REAPPLY"){
			var reapplyTransaction = "<?php echo __('reapplyTransaction')  ?>";
		$('#modalPopLite-wrapper10 .black_overlay').append('<p class="reapply">'+reapplyTransaction+'</p>' );
		
		//calling reapply function
		
		}
		else{
			window.location.reload(false);
		}
		
		
			//window.location.href=window.location.href;
			//window.location.reload(false);
                 
        }
      });
	
	  
	  
	  
       }, 300);
     
      jQuery('#cboxClose').click();
    }
	return;
  }
  function del_dn(addabove){
    //alert(addabove);
     var l = addabove.split("@"); var old_DNID = l[0]; var old_trID = l[1]; //alert(old_trID);
    //alert(window.parent.$('#dragdroptbl tr#'+old_trID).find("td:nth-child(2) a").text());
    var newposval = $('#dragdroptbl tr:last').find("td:nth-child(2) input[name^='featureNewPosition']").val();
    //var deletedtr = $('#dragdroptbl tr#'+old_trID);
    var elem = $('#dragdroptbl tr#'+old_trID).nextAll();
     $(elem).each(function () {         
      var new_pos = $(this).find("td:nth-child(2) input[name^='featureNewPosition']").val();
      new_pos = Number(new_pos)-Number(1);
      new_pos = (new_pos.toString().length==1)? '0'+new_pos : new_pos; // check lengh and make it 2 if not e.g. 1 to 01
       $(this).find("td:nth-child(2) input[name^='featureNewPosition']").val(new_pos);
      }); 
    $('#dragdroptbl tr#'+old_trID).remove();
    $('#dragdroptbl tr:last').after('<tr id="'+old_trID+'" onmouseout="hoverRow(this,false); " onmouseover="hoverRow(this,true);" style="cursor: move; height: 23px; background-color: transparent;"><td><input id="StationFeaturename['+old_trID+']" type="hidden" value="" name="featurename['+old_trID+']"></td><td><input id="StationFeaturevalue['+old_trID+']" type="hidden" value="" name="featurevalue['+old_trID+']"><input id="StationFeatureNewPosition['+old_trID+']" type="hidden" value="'+newposval+'" name="featureNewPosition['+old_trID+']"><a class="opencolorbox cboxElement" href="/voipphoneRE3/dns/selectdns/customer_id:" . <?php echo $customer_id ?> . "&type=single&update="></a></td><td class="table-right" onmouseout="this.className=\'table-right\';" onmouseover="this.className=\'table-right-over\';" style="background:url(/voipphoneRE3/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat 3px 5px;border-style: none;"><div class="table-menu"><div class="table-menu-popup" style="z-index: 1; display: none;"><ul><li class="script"><a class="opencolorbox cboxElement" href="/voipphoneRE3/dns/selectdns/customer_id:" . <?php echo $customer_id ?> . "&type=single&add=\''+old_trID+'\'">Add DN</a></li></ul></div></div></td></tr>');  
    
            $('#dragdroptbl').tableDnD({ 
            onDragStart: function(table, row) { 
                //$(table).parent().find('.result').text('');
            }, 
            onDrop: function(table, row) { //alert("ssd");
                $('#AjaxResult').load(base_url+"stations/editstation?"+$.tableDnD.serialize());
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
  }
</script>
<script type="text/javascript">
//function toggleSimring(){
                //$("#advancesearch").show
               // if(document.getElementById('simring').style.display=='none'){
                 //       document.getElementById('simring').style.display='block';
                //}else{
                  //      document.getElementById('simring').style.display='none';
                //}

jQuery(function() {

        jQuery(document).ready(function(){
        
            $('#simid').click(function(){
          jQuery('#button').attr("class", "showhighlight_buttonleft");
              jQuery('#updateStation').attr("class","button-right-hover");
                if($(this).is(":checked"))
                {
                  document.getElementById('simring').style.display='block';
                }
                else
                {
                  document.getElementById('simring').style.display='none';
                }

              });

              $("#cfrapinid").click(function() {

                $('#button').attr("class", "showhighlight_buttonleft");
              $('#updateStation').attr("class","button-right-hover");

                if($(this).is(":checked"))
                {
                  $("#cfrapin").attr("style", "");                  
                }
                else
                {
                  $("#cfrapin").attr("style", "display:none");
                
                }

              });
        
        // $('#cfrapinid').change(function(){
        //  jQuery('#button').attr("class", "showhighlight_buttonleft");
    //          jQuery('#updateStation').attr("class","button-right-hover");
    //            if($(this).is(":checked"))
    //            {
    //              document.getElementById('cfrapin').style.display='block';
    //            }
    //            else
    //            {
    //              document.getElementById('cfrapin').style.display='none';
    //            }

    //          });
        

          
          });
});

         $(function () {
		$('#popup-wrapper21').modalPopLite({ openButton: '.clicker21', closeButton: '#close-btn21', isModal: true });
	});

           function extensionChange(object){
            	 
			
			 $(document).ready(function() {
			
		
          jQuery('.clicker21').trigger('click');
	
        });  
		   }

         function setPreextensionValue(){
			var extenstionPreval=jQuery('#StationExtentionPre').val();
		
			jQuery('#StationExtensions').val(extenstionPreval);
			 jQuery('#close-btn21').trigger('click');
		 }
		 
		 function selectedextensionValue(){
			
			 jQuery('#close-btn21').trigger('click');
		 }
		     
			function fancyboxclose(){
		setTimeout( function() { $('#close-btn21').trigger('click'); },5);
		
	 	} 
			 
			 
         function chngbkcolor(obj) {
        $(document).ready(function() {
          jQuery('#button').attr("class", "showhighlight_buttonleft");
          jQuery('#updateStation').removeAttr("class");
          jQuery('#updateStation').attr("class", "button-right-hover");

        });

      //called when key is pressed in textbox
	    $("input.numeric_check").keypress(function(e) {	
	      if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57) && e.which!=13)
	      { 
	      	if ($(this).closest(".fancybox-overlay").length) {
			    $('.fancybox-overlay #overlay-error .error .message').text("<?php __('digitsOnly') ?>");
				$(this).removeClass('form-change');
				$(this).addClass('error');
				
			    $('.fancybox-overlay #overlay-error').removeClass('hide');
		    } else {
			    
			    $('#overlay-error .error .message').text(message);
			    $('#overlay-error').removeClass('hide');
		    }        
	        
	        return false;
	      } else {
		  	  $(this).addClass('form-change');
				$(this).removeClass('error');
	      		//$("input").keydown(function() {
		         // inValidate(validation, 'keyup');                    
		        //});		
	      	
	       
	      }
	    });
      }
	  function toggleShowNoneditFeature(){
			
         	//$("#advancesearch").show
         	if(document.getElementById('noneditFeature').style.display=='none'){
         		document.getElementById('noneditFeature').style.display='block';
				
				$('#expand').hide();
             	$('#collapse').show();
				
         	}else{
         		document.getElementById('noneditFeature').style.display='none';
				
				$('#expand').show();
             	$('#collapse').hide();
         	}
         }

</script>
<style>

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
    width: 10px!important;
}
.greyed {
    background-color: #FF0000!important;
}

</style>

<?php							  
/*
 * Start Confirmation Overlay Model For Delete
*/	
?>
	
	


<div>
				
	<div id="modalPopLite-mask21" style="width:100%" class="modalPopLite-mask"></div>
	<div id="modalPopLite-wrapper" style="left: -10000px;z-index: 9999;" class="modalPopLite-wrapper">
	<div class="modalPopLite-child popup-wrapper" id="popup-wrapper21">
	<div class="black_overlay" style="display: none;"></div>
	    <h4><?php echo __('Confirmation',true); ?>
			<span class='demonstrations1' style="display: block!important;" >           
				<span style="font-size: 18px !important;margin-top: -17px; float: right;"> <a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); return fancyboxclose(); " >X</a>	</span>  
				<span style="font-size: 18px !important;margin-top: -17px; float: right;margin-right: 10px;"><a href="javascript:;"  style="cursor:pointer;margin-top: 5px;" onMouseOver="Tip('<b><?php echo __('expansionChange_helpTitel') ?></b><br/><?php echo __('expansionChange_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a>	</span>		
			</span>
		  </h4>
	 <span  style="width:230px; height:180px;margin:50px auto;">
	        
			<h6 style="margin-left:0px;" id="confirm1" ><?php echo __('expansionChange') ?></h6> <br><br>
			<a href="#" id="close-btn21"></a>	
			 <span class="button-left" style="margin:2px 230px 11px !important" >
				<?php echo $html->link( __("Cancle", true),'javascript:setPreextensionValue()',array('id' => ''));  ?>
			 </span>
			 
			 <a href="#" id="close-btn21"></a>	
			 <span class="button-right" style="margin:-35px 2px 10px !important" >
				<?php echo $html->link( __("ok", true),'javascript:void()',array('id' => 'close-btn21'));  ?>
			 </span>
			
			<span  class="button-right" style="margin:-35px 2px 10px !important; visibility: hidden;" >
			<?php
				
			 echo $html->link(__("Ok", true), 'javascript:void(null)', array('onclick'=>'javascript:selectedextensionValue()','class'=>'clicker21','id'=>'clickerId21')); ?>
				
	      	</span>
		</span>	
	</div>
  </div>
</div>

<div class="black_overlay" style=" display: none;">
  <div id="overlay-error" class="notification first hide" style="width: 100%" >
    <div class="error">
        <div class="message">
          
        </div>
      </div>
    </div>
 </div>

<div class="block top">
 <div style="height: 55px">
		<div id="overlay-error" class="notification first hide" style="width: 100%" >
		
			<div class="error">
				<div class="message">
					
				</div>
			</div>
		</div>
		</div>
<div id="newEdit">
    <div class="form-body">

<?php 

    
if($stationDetails[0]['Station']['status'] != 6){ 


echo $form->create('Station', array(
        'action' => 'updateStationFeatures',
        'id' => 'updateStationFeatures',
        'class' => 'filtersForm',
        'type' => 'POST',
        'invalidate' => 'invalidate'
));

echo $form->input('Station.id', array('type'=>'hidden','value'=>$stationDetails[0]['Station'])); 
?>

<?php //echo "<pre>";
//print_r($stationDetails['0']['Station']);  
 ?>
<div class="cb">

<div style="height: 55px">
<!--<div id="overlay-error" class="notification first hide" style="width: 100%" >
    
      <div class="error">
        <div class="message">
          
        </div>
      </div>
    </div>-->
</div>
<?php //echo "<pre>";
      //print_r($stationFeatures);
     ?>
<h4><span ><?php echo __('stationFeatureForm') .' '. $statId;?></span>
  <div class='demonstrations'>
            <div  style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick=" UnTip(); setTimeout( function() { $('.fancybox-overlay').trigger('click'); },5);">X</a></div>
          <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onclick="Tip('<b><?php echo __('stationfeatures_helpTitle') ?></b><br/><?php echo __('stationfeatures_hlepText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>   
    </div>
  
</h4>

 <div class="form-box">
         
        <div class="form-left">     
            
            <table>

              <tr>              
              
              <td colspan="2">
              <div class="form-right table-menu">
              <?php  echo '<div class="form-label">';
            echo __('Port');
            echo '</div>';
            ?>    
            <div class="table-menu-popup" style="z-index: 1">
                              <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('Port_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                              </div>
            
              <?php 
			  //$mediatrix = explode(" ",$stationDetails[0]['Station']['port']);
			         $mediatrix =$stationDetails[0]['Station']['port'];
			   echo __($mediatrix); 
			   
			    ?>  
              </div>
              </td>
              </tr>
			  
             
              <tr>
              <td colspan="2">
              <div class="form-right table-menu">
                <?php  echo '<div class="form-label">';
            echo __('Location');
            echo '</div>';
            ?>  
               <div class="table-menu-popup" style="z-index: 1">
                              <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('Location_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                              </div>
                <span id=loc_name></span>
                
                </div>
              </td></tr>
              <tr><td colspan="2">
                
                <div class="form-right table-menu">
              <?php  echo '<div class="form-label">';
            echo __('phoneType');
            echo '</div>';
            ?>  
                 <div class="table-menu-popup" style="z-index: 1">
                              <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('phoneType_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                              </div>
                 
                <?php  
				   
				$readonlyPhone = array('console', 'server', 'i2004', 'i2002');
			    $readonlyCheck = in_array($stationDetails[0]['Station']['phone_type'],$readonlyPhone);
				if($readonlyCheck){
					
					
				}
				else{
					 $stationDetails[0]['Station']['type'];
					 if($stationDetails[0]['Station']['type']=="ANLG"){
					 	
					?>
					<script type="text/javascript">
					$(document).ready(function(){
						
					   $('#StationPhoneType option[value=console]').prop('style','display:none');
                       $('#StationPhoneType option[value=server]').prop('style','display:none');
					   $('#StationPhoneType option[value=i2004]').prop('style','display:none');
                       $('#StationPhoneType option[value=i2002]').prop('style','display:none');
					   $('#StationPhoneType option[value=1120]').prop('style','display:none');
                       $('#StationPhoneType option[value=1140]').prop('style','display:none');
					   $('#StationPhoneType option[value=virtual]').prop('style','display:none');
                       $('#StationPhoneType option[value=2033]').prop('style','display:none');
					   
						
					});
					</script>
					<?php  } else{ ?>
					
					<script type="text/javascript">
					$(document).ready(function(){
						
					   $('#StationPhoneType option[value=console]').prop('disabled', true);
                       $('#StationPhoneType option[value=server]').prop('disabled', true);
					   $('#StationPhoneType option[value=i2004]').prop('disabled', true);
                       $('#StationPhoneType option[value=i2002]').prop('disabled', true);
					   
						
					});
					</script>
					
			   <?php
			     }		
				}
				
				
				
				echo $form->input('phone_type',array('label'=>false,'value'=>$phoneTypes,'selected'=>$stationDetails[0]['Station']['phone_type'] ,'style'=>'width:93px;padding-left:5px;','onchange'=>'chngbkcolor(this)'));
                ?>
                </div>
              </td></tr>
              
              <tr><td colspan="2">
                
                <div class="form-right table-menu">
                  <?php 
                
                  echo '<div class="form-label" >';
                    echo __('Expansions');
                    echo '</div>';
                    ?>
                  <div class="table-menu-popup" style="z-index: 1">
                              <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('Expansion_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                              </div>
                  <?php
                  echo $form->input('extensions', array('label' => false,'type'=>'select', 'options'=>$extensions, 'default'=>$stationDetails[0]['Station']['extensions'],'style'=>'width:93px;','onchange'=>'extensionChange();')); 
				  
				  
				   ;
				   echo $form->input('Station.extentionPre', array('type'=>'hidden','value'=>$stationDetails[0]['Station']['extensions'])); 
				  ?>
         
                      </div>
                
                
              </td></tr>              
              
              
              <tr><td valign="top" colspan="2">
                <div class="form-right table-menu">
                <?php  echo '<div class="form-label">';
            echo __('Description');
            echo '</div>';
            ?>    
            <div class="table-menu-popup" style="z-index: 1">
                              <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('Description_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                              </div>
              
                <?php     
                echo $form->input('desc', array('label' => false, 'value'=>$stationDetails[0]['Station']['desc'], 'type'=>'textarea', 'style'=>'width:100px;height:50px;','onclick'=>'chngbkcolor(this)'));
                
                ?>
                </div>
              </td></tr>
              
            </table>
        </div>
        <div class="form-right">
          <div  style="margin-left:25px !important;"><?php echo __( wordwrap('stationFeature_blurb',40,"<br>\n"));?></div>
        </div>
</div>        
        
<h4><span href="javascript:void();" onMouseOver="Tip('<?php echo __('stationFeatureEditTooltip') ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " style=" cursor: default;color:#555;" ><?php echo __('stationFeatureEdit') ;?></span>  </h4> 
<!--<h4><?php echo __('station features') .' '. $statId;?>-->
  <!--<div class='demonstrations'>
            <div  style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick=" UnTip(); setTimeout( function() { $('.fancybox-overlay').trigger('click'); },5);">X</a></div>
          <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onclick="Tip('<b><?php echo __('stationfeatures_helpTitle') ?></b><br/><?php echo __('stationfeatures_hlepText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>   
    </div>-->
  
</h4>
        
        <div class="form-box">
         
        <!--<div class="form-left">
          <?php if(array_key_exists('COM', $stationFeatures))
          {
            #echo 'COMBOX';
            echo '<div class="form-label">';
            echo __('COMBOX');
            echo '</div>';
            echo $form->input('COM', array('label' => false, 'value'=>$stationFeatures['COM'], 'type'=>'checkbox', 'checked'=>($stationFeatures['COM'] == '1' ? TRUE : FALSE),'style'=>'width:15px;','onclick'=>'chngbkcolor(this)'));      
          }
          else
          {
            echo '<p></p>';
          }
          ?>
          <div class="table-menu-popup" style="z-index: 1">
                      <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('LANG_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                      </div>
        </div>-->
        
    </div>
    <div>
    <div style="float: left; width: 266px;">
    <div class="form-box">
    <div class="form-left table-menu">
    	
        <?php if($customerDetails['Customer']['moh_id'] != 0)
          {
            echo '<div class="form-label">';
            echo __('MOH');
            echo '</div>';
            ?>
            <div class="table-menu-popup" style="z-index: 1">
                      <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('KSMOH_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                      </div>
            <?php
            echo $form->input('MOH', array('label' => false,'value'=>$stationFeatures['MOH'], 'type'=>'checkbox', 'checked'=>($stationFeatures['MOH'] == '1' ? TRUE : FALSE),'style'=>'width:20px;','onclick'=>'chngbkcolor(this)'));   
          }
          else
          {
            echo '<p></p>';
          }
          ?>
          
        </div>
        
        
        <div style="clear: both"></div>
        
      <div class="form-left table-menu">
          <?php if($customerDetails['Customer']['CTI'] == 1)
          {
            echo '<div class="form-label">';
            echo __('CTI');
            echo '</div>';
            ?>
          <div class="table-menu-popup" style="z-index: 1">
                      <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('CTI_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                      </div>
          <?php
            echo $form->input('CTI', array('label' => false,'value'=>$stationFeatures['CTI'], 'type'=>'checkbox', 'checked'=>($stationFeatures['CTI'] == '1' ? TRUE : FALSE),'style'=>'width:20px;','onclick'=>'chngbkcolor(this)'));     
          }
          else
          {
            echo '<p></p>';
          }
          ?>
        </div>
              
        
    </div>
    
    
    
    <div class="form-box">
    <div class="form-left table-menu">
        
            <?php if((array_key_exists('CFUFEATURE', $stationFeatures)) && ($customerDetails['Customer']['CFRA'] == 1))
   			 {
            echo '<div class="form-label">';
            echo __('CFRA');
            echo '</div>';
            ?>
          <div class="table-menu-popup" style="z-index: 1">
                      <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('CFRA_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                      </div>
          <?php
            echo $form->input('CFRA', array('label' => false,'value'=>$stationFeatures['CFRA'], 'id'=>'cfrapinid', 'type'=>'checkbox','checked'=>(isset($stationFeatures['CFRA']) ? TRUE : FALSE),'style'=>'width:20px;','onclick'=>'chngbkcolor(this)'));
          ?>
</div>    
<div style="clear: both;"></div>      

            
            
          <?php
            if (isset($stationFeatures['CFRA']))
            {
              ?>  
              <div id="cfrapin"  style="display:block;width:70px !important;">
            <div class="form-left table-menu">
              <?php
            
            }
            else
            {
              ?>
              <div id="cfrapin"   style="display:none;width:70px !important;">
            <div class="form-left table-menu">
              <?php
            }?>
          
        <div class="table-menu-popup" style="z-index: 1">
                      <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('CFRAPIN_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                      </div>
          <?php  
          if ((isset($stationFeatures['CFRA'])) && ($stationDetails[0]['Station']['cfra_pin'] == ''))
          {
          	$stationDetails[0]['Station']['cfra_pin'] = '????';
          }
          elseif ((! isset($stationFeatures['CFRA'])) && ($stationDetails[0]['Station']['cfra_pin'] != ''))
		{
			$stationDetails[0]['Station']['cfra_pin'] = '';
		}
          echo $form->input('CFRAPIN', array('type'=>'text', 'value'=> $stationDetails[0]['Station']['cfra_pin'], 'label' => 'Pin', 'class'=>'numeric_check','style'=>'width:70px;','onkeyup'=>'chngbkcolor(this)')); ?>       
          
          
          </div>
          
          <?php } # end logic to check UI?>
          
          
          
        </div>
        
        </div>
		
		<?php 
		$grouponkeyArray=array('DN_MADN','DN_MADN_PILOT','DN_XLH','DN_XLH_PILOT');

		if(!in_array($grouponKey1,$grouponkeyArray))
				{  ?>
          <div class="form-box">
        <div class="form-left table-menu">
          <?php   
          if($stationFeatures['UCD']) 
          {
            echo '<p></p>';
          }
          else
          {
            
          
            echo '<div class="form-label">';
            echo __('SIMRING');
            echo '</div>';
            ?>
            <div class="table-menu-popup" style="z-index: 1">
                        <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('SIMRING_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                        </div>
            <?php
              echo $form->input('SIMRING', array('label' => false,'value'=>$stationFeatures['SIMRING'], 'id'=>'simid', 'type'=>'checkbox','checked'=>($stationFeatures['SIMRING'] == '1' ? TRUE : FALSE),'style'=>'width:20px;','onclick'=>'chngbkcolor(this)'));       
            
          }
            
          ?>
        </div>
		<?php   } ?> 
        <?php
            if ($stationFeatures['SIMRING'] == 1)
            {
              ?>  
              <div id="simring" class="form-box" style="display:block;width:390px !important;">
              <?php
            
            }
            else
            {
              ?>
              <div id="simring" class="form-box" style="display:none;width:390px !important;">
              <?php
            }?>
          
          
          
          <!--  <div style="display:<?php echo $showSimRing?>" class="form-box"> -->
        <div class="form-left table-menu" style="width: 107px !important;padding-bottom: 0px !important; ">
          <?php 
        
          echo '<div class="form-label" style="width:20px !important;">' . __('1.', true). '</div>';
          ?>
          
          <div class="table-menu-popup" style="z-index: 1">
                      <ul style="width:10px !important"><li ><a href="javascript:;" onclick="Tip('<?php echo __('1_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li>
            </ul>
                      </div>
          <?php
          echo $form->input('SIMRINGMEMBER1', array('type'=>'text','label' => false,'value'=>$stationFeatures['SIMRINGMEMBER1'],'style'=>'width:70px;','readonly'=>$readonly,'onkeyup'=>'chngbkcolor(this)'));
          
          ?>
          
    
        </div>
        <div class="form-right table-menu">
          <?php 
          echo '<div class="form-label" style="width:20px !important;">' . __('2.', true). '</div>';
          
          ?>
          
          <div class="table-menu-popup" style="z-index: 1">
                      <ul style="width:10px !important"><li ><a href="javascript:;" onclick="Tip('<?php echo __('2_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li>
            </ul>
                      </div>
          <?php
          echo $form->input('SIMRINGMEMBER2', array('type'=>'text','label' => false,'value'=>$stationFeatures['SIMRINGMEMBER2'],'style'=>'width:70px;','readonly'=>$readonly,'onkeyup'=>'chngbkcolor(this)'));
          
          ?>
            
          </div>
        <div class="form-left table-menu" style="width: 107px !important;">
          <?php 
        
          echo '<div class="form-label" style="width:20px !important;">' . __('3.', true). '</div>';
          ?>
          
          <div class="table-menu-popup" style="z-index: 1">
                      <ul style="width:10px !important"><li ><a href="javascript:;" onclick="Tip('<?php echo __('3_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li>
            </ul>
                      </div>
          <?php
          echo $form->input('SIMRINGMEMBER3', array('type'=>'text','label' => false,'value'=>$stationFeatures['SIMRINGMEMBER3'],'style'=>'width:70px;','readonly'=>$readonly,'onkeyup'=>'chngbkcolor(this)'));
          
          ?>
            
          </div>
        <div class="form-right table-menu">
  
            <?php 
        
          echo '<div class="form-label" style="width:20px !important;">' . __('4.', true). '</div>';
          ?>
          
          <div class="table-menu-popup" style="z-index: 1">
                      <ul style="width:10px !important"><li ><a href="javascript:;" onclick="Tip('<?php echo __('4_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li>
            </ul>
                      </div>
          <?php
          echo $form->input('SIMRINGMEMBER4', array('type'=>'text','label' => false,'value'=>$stationFeatures['SIMRINGMEMBER4'],'style'=>'width:70px;','readonly'=>$readonly,'onkeyup'=>'chngbkcolor(this)'));
          
          ?>
          
          </div>
      </div>
    
        
    </div>
  </div> 
 
   
  <div style="float: right; width: 247px;">
    <div class="form-right">
            <div class="blurb_text" ><?php  echo __(wordwrap('stationFeatureEdit_blurb',40,"<br>\n"));?></div>
        </div>
    
  </div>
  </div>
  
  
    
<h4><span href="javascript:void();" onMouseOver="Tip('<?php echo __('keyFeatureEditTooltip') ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " style=" cursor: default;color:#555;" ><?php echo __('keyFeatureEdit') ;?> </span> </h4>   
   
   <?php 
   #Check special config and exception
   if($stationDetails[0]['Station']['status'] == 8){ 
   	$readonly = 'true';
   	echo __('specialConfigBlurb');
   }
   	
   ?>
    
    <div>
    <div style="float: left; width:266px;">
    <div class="form-box">
    	<?php if(! (array_key_exists('DN_XLH_PILOT', $stationFeatures)))
    	{?>
        <div class="form-left table-menu">
          <?php 
          echo '<div class="form-label">';
            echo __('RAG');
            echo '</div>';
            ?>
          <div class="table-menu-popup" style="z-index: 1">
                      <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('RAG_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                      </div>
          <?php
          echo $form->input('RAG', array('label' => false,'value'=>$stationFeatures['RAG'], 'type'=>'checkbox', 'checked'=>($stationFeatures['RAG'] == '1' ? TRUE : FALSE),'style'=>'width:20px;','readonly'=>$readonly,'onclick'=>'chngbkcolor(this)'));       
          ?>
        </div>
        <?php } else {echo '<p></p>';}?>
          
        <div style="clear: both"></div>
        <div class="form-left table-menu">
          <?php 
          echo '<div class="form-label">';
            echo __('PRK');
            echo '</div>';
            ?>
          <div class="table-menu-popup" style="z-index: 1">
                      <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('PRK_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                      </div>
          <?php
          echo $form->input('PRK', array('label' => false,'value'=>$stationFeatures['PRK'], 'type'=>'checkbox', 'checked'=>($stationFeatures['PRK'] == '1' ? TRUE : FALSE),'style'=>'width:20px;','readonly'=>$readonly,'onclick'=>'chngbkcolor(this)'));     
          ?>
        </div>
        
    <div style="clear: both"></div>
        <div class="form-left table-menu">
          <?php 
          echo '<div class="form-label">';
            echo __('CNF');
            echo '</div>';
            ?>
          <div class="table-menu-popup" style="z-index: 1">
                      <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('CNF_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                      </div>
          <?php
          echo $form->input('CNF', array('label' => false,'value'=>$stationFeatures['CNF'], 'type'=>'checkbox', 'checked'=>($stationFeatures['CNF'] == '1' ? TRUE : FALSE),'style'=>'width:20px;','readonly'=>$readonly,'onclick'=>'chngbkcolor(this)'));       
          ?>
        </div>
        <div style="clear: both"></div>
          <?php 
          # If DN_MADN, DN_XLH exists then show
          # IF MSBEnable feature exists and is unset then
          #if(array_key_exists('MADN', $stationFeatures))
          #if(($dnCount > 1) && (array_key_exists('MADN', $stationFeatures)))
          if($dnCount > 0)
          {
            echo '<div class="form-left  table-menu">';
            echo '<div class="form-label">';
            echo __('MSB');
            echo '</div>';
            ?>
          <div class="table-menu-popup" style="z-index: 1">
                      <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('MSB_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                      </div>
          <?php
            echo $form->input('MSB', array('label' => false,'value'=>$stationFeatures['MSB'], 'type'=>'checkbox', 'checked'=>($stationFeatures['MSB'] == '1' ? TRUE : FALSE),'style'=>'width:20px;','readonly'=>$readonly,'onclick'=>'chngbkcolor(this)'));     
            echo '</div>';
            echo '<div class="form-right">';
            echo '</div>';
            
          #echo $form->input('msbenable', array('label' => false,'value'=>$stationFeatures['MSB'], 'type'=>'checkbox', 'checked'=>($stationFeatures['MSB'] == '1' ? TRUE : FALSE),'style'=>'width:20px;'));     
          #}
          #else 
          #{
          # echo '<p></p>';
            #Not shown on form but keep the value sent back to controller.
            #echo $form->input('MSBEnable', array('type'=>'hidden','value'=>$stationFeatures['MSBEnable']));
          }
          ?>
          
        <div class="form-left table-menu">
          <?php 
            echo '<div class="form-label">';
            echo __('CWT');
            echo '</div>';
            ?>
          <div class="table-menu-popup" style="z-index: 1">
                      <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('CWT_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                      </div>
          <?php
            echo $form->input('CWT', array('label' => false,'value'=>$stationFeatures['CWT'], 'type'=>'checkbox', 'checked'=>($stationFeatures['CWT'] == '1' ? TRUE : FALSE),'style'=>'width:20px;','readonly'=>$readonly,'onclick'=>'chngbkcolor(this)'));       
          
          ?>
        </div>
        <div style="clear: both;"></div>
        <div class="form-left table-menu">
          <?php 
            echo '<div class="form-label">';
            echo __('MWT');
            echo '</div>';
            ?>
          <div class="table-menu-popup" style="z-index: 1">
                      <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('MWT_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                      </div>
          <?php
            echo $form->input('MWT', array('label' => false,'value'=>$stationFeatures['MWT'], 'type'=>'checkbox', 'checked'=>($stationFeatures['MWT'] == '1' ? TRUE : FALSE),'style'=>'width:20px;','readonly'=>$readonly,'onclick'=>'chngbkcolor(this)'));       
          
          ?>
        </div>
        
        
    
    </div>
    </div>
    <div style="float: right; width: 247px;">
      <div class="form-right">
            <div class="blurb_text" ><?php  echo __(wordwrap('keyFeatureEdit_blurb',40,"<br>\n"));?></div>
        </div>
      
      
      
    </div>
    </div>
    
    
    
    
      <h4><?php echo __('stationFeatureNoneEdit') ;?> <a  onclick="return toggleShowNoneditFeature() ;" href="javascript:void(0)" style="float:right;">
					
					<div style="width:20px;" id="expand">
					<div id="plus"></div>
					</div>
					<div style="width:20px;" id="collapse">
					<div id="minus"></div>
					</div>
					</a> </h4>  
        <!--<div class="form-left">
          <?php 
          echo '<div class="form-label">';
            echo __('UCDLG');
            echo '</div>';
          echo  $form->input('ucdlg', array('label' => false,'value'=>$stationFeatures['UCDLG'], 'type'=>'checkbox', 'checked'=>($stationFeatures['UCDLG'] == '1' ? TRUE : FALSE),'style'=>'width:20px;','onclick'=>'chngbkcolor(this)'));        
          ?>
        </div>
        <div class="form-right">
          <?php 
          echo '<div class="form-label">';
            echo __('UCD');
            echo '</div>';
          echo $form->input('ucd', array('label' => false,'value'=>$stationFeatures['UCD'], 'type'=>'checkbox', 'checked'=>($stationFeatures['UCD'] == '1' ? TRUE : FALSE),'style'=>'width:20px;','onclick'=>'chngbkcolor(this)'));     
          ?>
        </div>-->
		<div id="noneditFeature" style="display: none;">
		
        <div>
    <div style="float: left;width: 266px;">
	 <?php  if(array_key_exists("AUTODISP",$stationFeatures)){   ?>
	 <table>
		<tr>
		<td>
        <div class="form-left table-menu ">
          <?php 
          echo '<div class="form-label" style="width:181px !important;">';
            echo __('Autodisp');
            echo '</div>';
            ?>
          <div class="table-menu-popup" style="z-index: 1">
                      <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('AUTODISP_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                      </div>
          <?php
             /* echo  $form->input('autodisp', array('label' => false,'value'=>$stationFeatures['AUTODISP'], 'type'=>'checkbox', 'checked'=>($stationFeatures['AUTODISP'] == '1' ? TRUE : FALSE),'style'=>'width:20px;','onclick'=>'chngbkcolor(this)')); */        
          ?>
        </div>
		</td>
		</tr>
		</table>
		 <?php }   ?>
		
        <?php  if(array_key_exists("LNR",$stationFeatures)){   ?>
		<table>
		<tr>
		<td>
        <div class="form-left table-menu morewidth">
          <?php 
          echo '<div class="form-label" style="width:181px !important;">';
            echo __('LNR');
            echo '</div>';
            ?>
          <div class="table-menu-popup" style="z-index: 1">
                      <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('LNR_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                      </div>
          <?php
          /* echo $form->input('lnr', array('label' => false,'value'=>$stationFeatures['LNR'], 'type'=>'checkbox', 'checked'=>($stationFeatures['LNR'] == '1' ? TRUE : FALSE),'style'=>'width:20px;','onclick'=>'chngbkcolor(this)'));  */    
          ?>
        </div>
		</td>
		</tr>
		</table>
		<?php  }   ?>
		<?php  if(array_key_exists("DCPU",$stationFeatures)){   ?>
		<table>
		<tr>
		<td>
        <div class="form-left table-menu morewidth">
          <?php 
          echo '<div class="form-label" style="width:181px !important;">';
            echo __('DCPU');
            echo '</div>';
            ?>
          <div class="table-menu-popup" style="z-index: 1">
                      <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('DCPU_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                      </div>
          <?php
          /* echo $form->input('dcpu', array('label' => false,'value'=>$stationFeatures['DCPU'], 'type'=>'checkbox', 'checked'=>($stationFeatures['DCPU'] == '1' ? TRUE : FALSE),'style'=>'width:20px;','onclick'=>'chngbkcolor(this)')); */        
          ?>
        </div>
		</td>
		</tr>
		</table>
		<?php  }   ?>
		
		<?php  if(array_key_exists("UCD",$stationFeatures)){   ?>
		<table>
		<tr>
		<td>
		 <div class="form-left table-menu morewidth">
          <?php 
           echo '<div class="form-label" style="width:181px !important;">';
            echo __('UCD');
            echo '</div>';
            ?>
          
			 <div class="table-menu-popup" style="z-index: 1">
                      <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('UCD_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                      </div>		  
				  
          <?php
          /* echo $form->input('dcpu', array('label' => false,'value'=>$stationFeatures['DCPU'], 'type'=>'checkbox', 'checked'=>($stationFeatures['DCPU'] == '1' ? TRUE : FALSE),'style'=>'width:20px;','onclick'=>'chngbkcolor(this)')); */        
          ?>
        </div>
		</td>
		</tr>
		</table>
		<?php  }   ?>

		<?php  
		if(array_key_exists("CWI",$stationFeatures))
		  {?><table><tr><td>
		    <div class="form-left table-menu morewidth"> <?php 
            	echo '<div class="form-label" style="width:181px !important;">';
            	echo __('CWI');
            	echo '</div>';?>
			   <div class="table-menu-popup" style="z-index: 1">
                 <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('CWI_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
               </div>
        	</div> </td></tr></table><?php  
		  }?>

		<?php  
		if(array_key_exists("DRING",$stationFeatures))
		  {?><table><tr><td>
		    <div class="form-left table-menu morewidth"> <?php 
            	echo '<div class="form-label" style="width:181px !important;">';
            	echo __('DRING');
            	echo '</div>';?>
			   <div class="table-menu-popup" style="z-index: 1">
                 <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('DRING_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
               </div>
        	</div> </td></tr></table><?php  
		  }?>

		<?php  
		if(array_key_exists("SCS",$stationFeatures))
		  {?><table><tr><td>
		    <div class="form-left table-menu morewidth"> <?php 
            	echo '<div class="form-label" style="width:181px !important;">';
            	echo __('SCS');
            	echo '</div>';?>
			   <div class="table-menu-popup" style="z-index: 1">
                 <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('SCS_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
               </div>
        	</div> </td></tr></table><?php  
		  }?>

		<?php  
		if(array_key_exists("CHD",$stationFeatures))
		  {?><table><tr><td>
		    <div class="form-left table-menu morewidth"> <?php 
            	echo '<div class="form-label" style="width:181px !important;">';
            	echo __('CHD');
            	echo '</div>';?>
			   <div class="table-menu-popup" style="z-index: 1">
                 <ul><li ><a href="javascript:;" onclick="Tip('<?php echo __('CHD_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
               </div>
        	</div> </td></tr></table><?php  
		  }?>
		
		
    </div>
    
    </div>
    <div style="float: right;width: 237px;">
          <div class="form-right">
           <div class="blurb_text" ><?php echo   __(wordwrap('stationFeatureNoneEdit_blurb',40,"<br>\n"));?></div>
        </div>
    </div>
    </div>
    
    
    </div>
    
    <div class="form-box">
    <?php if($stationDetails[0]['Station']['status'] != 7){?> 
  		<div class="button-right-disabled" id="updateStation">
 		 <a id="button" href="javascript:;" onclick="submitForm()" name="submitForm" value="submitForm1" ><?php
__("Submit");
          ?></a>
      
            
      </div>
      <?php } ?>
      </div>
        
      <?php
       
  
} # End of key features, station != 6
?>
</div>

</div>
</div>
