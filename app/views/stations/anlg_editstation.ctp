<style>
.dropped {
	background:#F00 !important;
}
.t_Tooltip{
	display:none !important;
	}
span
{
white-space:nowrap;
}

#close{
	position: absolute;
	right: -11px;
    top: 5px;
	width: 36px;
	height: 36px;
	cursor: pointer;
	z-index: 8040;
	font-size: 18px !important;
	font-weight:bold;
	text-decoration:none; 
}


</style>
<?php
$user_agent = $_SERVER['HTTP_USER_AGENT']; 

if (preg_match('/MSIE/i', $user_agent)) { ?>

<style>
	
	#expansionImage{
	margin-top: 145px !important;
	height:auto;
}
#expansionImage1{
	margin-top:100px important;
	padding-bottom: 50px;
	height:auto;

}

#expansionImage2{
	margin-top: 225px important;
	margin-bottom: 50px;
	height:auto;
}
#internalUserPort{
	margin-top: 25px !important;
	margin-top: 25px !important;
}
#inf{
	height:190px;
}
	
.toolTipText{
	font-weight:bold;float:left;padding-left:50px;
}	

.toolTipText a{
	      color:inherit;text-decoration:none;
      }
	  .toolTipText a:hover{
	     font-weight:bold;
      }
	
</style>
	
	<?php
	}else{
		
		
	?>	
		<style>
	
	#expansionImage{
					margin-top: 117px !important;
					height:auto;
				}
		#expansionImage1{
					margin-top: 60px; 
					padding-bottom: 50px;
					height:auto;

				}

		#expansionImage2{
					margin-top: 200px;
					margin-bottom: 50px;
					height:auto;
					}
	    #rightImageTag{
			padding-left:10px;
			
		}
		
		#internalUserPort{
	         margin-top: 10px !important;
        }
		#inf{
	        height:190px;
              }

		.toolTipText{
	      font-weight:bold;float:left;padding-left:50px;
      }
	.toolTipText a{
	      color:inherit;text-decoration:none;
      }
	  .toolTipText a:hover{
	     font-weight:bold;
      }
	  
	  
	
		</style>
	<?php  } ?>
	
	
	<?php   if (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false) { ?>
	        <style>
	
	#expansionImage{
					margin-top: 145px !important;
					height:auto;
				}
	#internalUserPort{
	margin-top: 25px !important;
}			
				
				</style>
        
  <?php   }  ?>
	
	
<script type="text/javascript">


    $(document).ready(function() { //alert("ret");
		//Set default button display for collapsable
		

    	$('#minus').hide();
     	$('#mbtn').hide();
     	$('#expmbtn').hide();
         $('#expansionImage').hide();   //hide expansion image
     	
		
		 $('#minus').click(function() {
            $('#pbtn').show();
            $('#minus').hide();
            $('#mbtn').hide();
            $('#plus').show();
			$('#exppbtn').show();
			$('#expansionImage').hide();       //hide expansion image
        });

       

        $('#plus').click(function() {
            $('#pbtn').hide();
            $('#minus').show();
            $('#mbtn').show();
            $('#plus').hide();
			$('#expmbtn').show();
			
			$('#expansionImage').show();                    //show expansion image
        });

		
		
		

        $('#dragdroptbl').tableDnD({
            onDragStart: function(table, row) {
                //$(table).parent().find('.result').text('');
				//$('#dragdroptbl tbody tr').removeAttr("class");
				//$('#dragdroptbl tbody tr').attr("style","background:#000 !important");
            },
            onDrop: function(table, row) {

			var tblstr = decodeURI($.tableDnD.serialize());

			// Code to show dropped row in the list.. It goes hide when it drops
			  var selectedrow = row.id;
			  $('#'+selectedrow).removeAttr( "style" );
			  $('#'+selectedrow).prop( "style","background-color: rgba(0, 0, 0, 0);cursor: move;display: table-row;height: 23px;opacity: 100;");
			//  $('#'+selectedrow).css('background-color','#F00');


			// End of section to show dropped row

                    var tmparray = new Array();
                    var x = 0;
                    tmparray = tblstr.split("&dragdroptbl[]=");

                    while (x < tmparray.length) {
                        if (tmparray[x] != "dragdroptbl[]=") {

						   pos=x+1;
						   pos = (pos.toString().length==1)? '0'+pos : pos;
						   original_position = tmparray[x].replace("dragdroptbl[]=", "");

						var pooo=$("input[name^='featureNewPosition["+original_position+"]']").val();
					  // alert(pooo);
						 $("input[name^='featureNewPosition["+original_position+"]']").val(pos);
					   var pooo=$("input[name^='featureNewPosition["+original_position+"]']").val();
                      // alert(pooo);
					  sts ='<span style="margin-left:150px;"> <img src="<?php echo Configure::read('base_url');?>/images/fancybox_loading.gif"></span>';
		     			   $('.spinresult').html(sts);
						  // $('#'+selectedrow).css('background-color','#F00');
						   $('#'+selectedrow).addClass("dropped");
                        }

                        x++;
                    }

				$('.filtersForm').attr('action',base_url+'stations/major_cfeature_change/<?php
				echo $statId;
				?>');
						$('.filtersForm').attr('method','POST');
						$.ajax({
								type: "POST",
								async : false,
								dataType: 'html',
								url: $('.filtersForm').attr('action'),
								data: $('.filtersForm').serialize(),
								success: function(data){
									//alert("hi");
								}
						});
                /*sts ='';
		        $('.spinresult').html(sts); */
			     window.location.reload();
            }

        });

		$('#13tdlast').removeAttr( "class" );
		$('#13tdlast').removeAttr( "onmouseout" );
		$('#13tdlast').removeAttr( "style" );

		$('#14tdlast').removeAttr( "class" );
		$('#14tdlast').removeAttr( "onmouseout" );
		$('#14tdlast').removeAttr( "style" );
		
		
		$('#33tdlast').removeAttr( "class" );
		$('#33tdlast').removeAttr( "onmouseout" );
		$('#33tdlast').removeAttr( "style" );

		$('#34tdlast').removeAttr( "class" );
		$('#34tdlast').removeAttr( "onmouseout" );
		$('#34tdlast').removeAttr( "style" );
		
		
		$('#35tdlast').removeAttr( "class" );
		$('#35tdlast').removeAttr( "onmouseout" );
		$('#35tdlast').removeAttr( "style" );

		$('#36tdlast').removeAttr( "class" );
		$('#36tdlast').removeAttr( "onmouseout" );
		$('#36tdlast').removeAttr( "style" );
		
		
		
		$('#55tdlast').removeAttr( "class" );
		$('#55tdlast').removeAttr( "onmouseout" );
		$('#55tdlast').removeAttr( "style" );

		$('#56tdlast').removeAttr( "class" );
		$('#56tdlast').removeAttr( "onmouseout" );
		$('#56tdlast').removeAttr( "style" );
		
		
		$('#57tdlast').removeAttr( "class" );
		$('#57tdlast').removeAttr( "onmouseout" );
		$('#57tdlast').removeAttr( "style" );

		$('#58tdlast').removeAttr( "class" );
		$('#58tdlast').removeAttr( "onmouseout" );
		$('#58tdlast').removeAttr( "style" );
		
		

		$('#14').addClass( "graybg" );
		$('#13').addClass( "graybg" );
		
		    $('#33').addClass( "graybg" );
			$('#34').addClass( "graybg" );
			$('#35').addClass( "graybg" );
			$('#36').addClass( "graybg" );
			
			$('#55').addClass( "graybg" );
			$('#56').addClass( "graybg" );
			$('#57').addClass( "graybg" );
			$('#58').addClass( "graybg" );
			
			
			//show image tag tooltip on hover
			
			$('#rightImageTag').hover(function(){
				
				$($(this).children()[1]).attr("style","display:block;float:left;text-decoration: none;");
			
			});
			
			$('#rightImageTagExpn1').hover(function(){
				
				$($(this).children()[1]).attr("style","display:block;float:left;text-decoration: none;");
			
			});
			
			$('#rightImageTagExpn2').hover(function(){
				
				$($(this).children()[1]).attr("style","display:block;float:left;text-decoration: none;");
			
			});
			//show image tag tooltip on mouse leave
			
			$('#rightImageTag').mouseleave(function(){
			
			$($(this).children()[1]).attr("style","display:none;");
			});
				
			
			$('#rightImageTagExpn1').mouseleave(function(){
			
			$($(this).children()[1]).attr("style","display:none;");
			});
			
			
			$('#rightImageTagExpn2').mouseleave(function(){
			
			$($(this).children()[1]).attr("style","display:none;");
			});
			
			
			
			
		 //changing right side image based on phone type based on even body load
		  var t=$("#phone_type").val();
		  //alert(t);
		  
		  var phonePdf="<?php	 $selectedLanguage = $_SESSION['Config']['language'];
						if($selectedLanguage=='de'){ 
							echo 'Bedienung_IP-Phone_VoIP-de.pdf' ;
						 }elseif ($selectedLanguage=='fr'){
							echo 'Bedienung_IP-Phone_VoIP-fr.pdf' ;
						}elseif($selectedLanguage=='it'){
							echo 'Bedienung_IP-Phone_VoIP-it.pdf' ;
						}else{ 
							echo 'Bedienung_IP-Phone_VoIP-en.pdf' ;
						} ?>
						";
		var medPhonePdf="<?php	 $selectedLanguage = $_SESSION['Config']['language'];
						if($selectedLanguage=='de'){ 
							echo 'Bedienung_MediatrixPhone_de.pdf' ;
						 }elseif ($selectedLanguage=='fr'){
							echo 'Bedienung_MediatrixPhone_fr.pdf' ;
						}elseif($selectedLanguage=='it'){
							echo 'Bedienung_MediatrixPhone_it.pdf' ;
						}else{ 
							echo 'Bedienung_MediatrixPhone_en.pdf' ;
						} ?>
						";
		  
		  if(t=="1140")
		 {

			 var infopath="<?php echo Configure::read('base_url');?>/files/"+phonePdf;
			 var toolTipText="<span class='toolTipText'><a href='"+infopath+"' target='blank'><?php echo __('type1140'); ?></a></span>";
			  tInfo="<?php echo __('type1140_info');   ?>";
			  var toolTipInfo="'"+tInfo+"'";	
				
              var toolTipLink='<a href="javascript:;" style="display:none;" onclick="Tip('+toolTipInfo+', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>';
	
			 $('#rightImageTag').html(toolTipText);
		 	 $('#rightImageTag').append(toolTipLink);	
		
		 $('#rightSideImage').attr("src","<?php echo Configure::read('base_url');?>images/1140_01.png");
		 $('#rightSideImage1').attr("href","<?php echo Configure::read('base_url');?>images/1140_01.png");
		
		 }
		 else if(t=="1120")
		 {
		 	
			 var infopath="<?php echo Configure::read('base_url');?>/files/"+phonePdf;
			 
		 	var toolTipText="<span class='toolTipText'><a href='"+infopath+"'  target='blank'><?php echo __('type1120'); ?></a></span>";
			  tInfo="<?php echo __('type1120_info');   ?>";
			  var toolTipInfo="'"+tInfo+"'";	
				
              var toolTipLink='<a href="javascript:;" style="display:none;" onclick="Tip('+toolTipInfo+', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>';
	
			 $('#rightImageTag').html(toolTipText);
		 	 $('#rightImageTag').append(toolTipLink);	
			
		 	 $('#rightSideImage').attr("src","<?php echo Configure::read('base_url');?>images/1120.png");
			  $('#rightSideImage1').attr("href","<?php echo Configure::read('base_url');?>images/1120.png");	
		 }
		 else if(t=="fax")
		 {
			  var infopath="<?php echo Configure::read('base_url');?>/files/"+medPhonePdf;
			  var toolTipText="<span class='toolTipText'><?php echo __('typeFax'); ?></span>";
              var pdfLink = "<div style='clear:both'></div><a href='"+infopath+"' target='blank' style='float:left;' ><?php echo __('mediatrixManual'); ?></a>";
			    tInfo="<?php echo __('typeFax_info');   ?>";
			    var toolTipInfo="'"+tInfo+"'";	
				
              var toolTipLink='<a href="javascript:;" style="display:none;" onclick="Tip('+toolTipInfo+', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>';
	
			 $('#rightImageTag').html(toolTipText);
		 	 $('#rightImageTag').append(toolTipLink);	
		 	 $('#rightImageTag').append(pdfLink);	
			
		 	 $('#rightSideImage').attr("src","<?php echo Configure::read('base_url');?>images/Fax-01.jpg");	
			  $('#rightSideImage1').attr("href","<?php echo Configure::read('base_url');?>images/Fax-01.jpg");
			 
		 }
		 else if(t=="fax / modem")
		 {
			  var infopath="<?php echo Configure::read('base_url');?>/files/"+medPhonePdf;
			  var toolTipText="<span class='toolTipText'><?php echo __('typefax/modem'); ?></span>";
              var pdfLink = "<div style='clear:both'></div><a href='"+infopath+"' target='blank' style='float:left;' ><?php echo __('mediatrixManual'); ?></a>";
			    tInfo="<?php echo __('typefax/modem_info');   ?>";
  			    var toolTipInfo="'"+tInfo+"'";	
				
              var toolTipLink='<a href="javascript:;" style="display:none;" onclick="Tip('+toolTipInfo+', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>';
	
			 $('#rightImageTag').html(toolTipText);
		 	 $('#rightImageTag').append(toolTipLink);
		 	$('#rightImageTag').append(pdfLink);		
			
		 	 $('#rightSideImage').attr("src","<?php echo Configure::read('base_url');?>images/fax-modem-01.jpg");	
			  $('#rightSideImage1').attr("href","<?php echo Configure::read('base_url');?>images/fax-modem-01.jpg");
		 }
		 else if(t=="modem")
		 {
			  var infopath="<?php echo Configure::read('base_url');?>/files/"+medPhonePdf;
			  var toolTipText="<span class='toolTipText'><?php echo __('typeModem'); ?></span>";
              var pdfLink = "<div style='clear:both'></div><a href='"+infopath+"' target='blank' style='float:left;' ><?php echo __('mediatrixManual'); ?></a>";
			    tInfo="<?php echo __('typeModem_info');   ?>";
			    var toolTipInfo="'"+tInfo+"'";	
				
              var toolTipLink='<a href="javascript:;" style="display:none;" onclick="Tip('+toolTipInfo+', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>';
	
			 $('#rightImageTag').html(toolTipText);
		 	 $('#rightImageTag').append(toolTipLink);	
		 	$('#rightImageTag').append(pdfLink);	
			
		 	 $('#rightSideImage').attr("src","<?php echo Configure::read('base_url');?>images/fax-modem-01.jpg");	
			  $('#rightSideImage1').attr("href","<?php echo Configure::read('base_url');?>images/fax-modem-01.jpg");
		 }
		 else if(t=="phone")
		 {
			  var infopath="<?php echo Configure::read('base_url');?>/files/"+medPhonePdf;
			  var toolTipText="<span class='toolTipText'><?php echo __('typePhone'); ?></span>";
              var pdfLink = "<div style='clear:both'></div><a href='"+infopath+"' target='blank' style='float:left;' ><?php echo __('mediatrixManual'); ?></a>";
			    tInfo="<?php echo __('typePhone_info');   ?>";
			    var toolTipInfo="'"+tInfo+"'";	
				
              var toolTipLink='<a href="javascript:;" style="display:none;" onclick="Tip('+toolTipInfo+', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>';
	
			 $('#rightImageTag').html(toolTipText);
		 	 $('#rightImageTag').append(toolTipLink);
		 	$('#rightImageTag').append(pdfLink);		
			
			
		 	 $('#rightSideImage').attr("src","<?php echo Configure::read('base_url');?>images/phone-01.jpg");
			  $('#rightSideImage1').attr("href","<?php echo Configure::read('base_url');?>images/phone-01.jpg");	
		 }
		 else if(t=="2033")
		 {
		 	var toolTipText="<span class='toolTipText'><?php echo __('type2033'); ?></span>";
			  tInfo="<?php echo __('type2033_info');   ?>";
			  var toolTipInfo="'"+tInfo+"'";	
				
              var toolTipLink='<a href="javascript:;" style="display:none;" onclick="Tip('+toolTipInfo+', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>';
	
			 $('#rightImageTag').html(toolTipText);
		 	 $('#rightImageTag').append(toolTipLink);	
			
		 	 $('#rightSideImage').attr("src","<?php echo Configure::read('base_url');?>images/2033-01.jpg");
			  $('#rightSideImage1').attr("href","<?php echo Configure::read('base_url');?>images/2033-01.jpg");	
		 }
		 else 
		 {
			var infopath="<?php echo Configure::read('base_url');?>/files/"+medPhonePdf;
			var toolTipText="<span class='toolTipText'><?php echo __('typeModem'); ?></span>";
            var pdfLink = "<div style='clear:both'></div><a href='"+infopath+"' target='blank' style='float:left;' ><?php echo __('mediatrixManual'); ?></a>";
			  tInfo="<?php echo __('typeModem_info');   ?>";
			  var toolTipInfo="'"+tInfo+"'";	
				
              var toolTipLink='<a href="javascript:;" style="display:none;" onclick="Tip('+toolTipInfo+', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>';
	
			 $('#rightImageTag').html(toolTipText);
		 	 $('#rightImageTag').append(toolTipLink);	
			
			
		
			
		 	 $('#rightSideImage').attr("src","<?php echo Configure::read('base_url');?>images/fax-modem-01.jpg");	
			  $('#rightSideImage1').attr("href","<?php echo Configure::read('base_url');?>images/fax-modem-01.jpg");
		 }
			
			
			//adding tag expansion image 1 and 2
			
			var toolTipText="<span class='toolTipText'><?php echo __('typeKem1'); ?></span>";
			  tInfo="<?php echo __('typeKem1_info');   ?>";
			  var toolTipInfo="'"+tInfo+"'";	
				
              var toolTipLink='<a href="javascript:;" style="display:none;" onclick="Tip('+toolTipInfo+', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>';
	
			 $('#rightImageTagExpn1').html(toolTipText);
		 	 $('#rightImageTagExpn1').append(toolTipLink);	
			 
			 
			 var toolTipText="<span class='toolTipText'><?php echo __('typeKem2'); ?></span>";
			  tInfo="<?php echo __('typeKem2_info');   ?>";
			  var toolTipInfo="'"+tInfo+"'";	
				
              var toolTipLink='<a href="javascript:;" style="display:none;" onclick="Tip('+toolTipInfo+', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>';
	
			 $('#rightImageTagExpn2').html(toolTipText);
		 	 $('#rightImageTagExpn2').append(toolTipLink);	
			
			
			
			
			
			
			

      // $("#phone_type").change(function(){
	   		
		  var t=$("#phone_type").val();
		  if(t=="1140")
		  {
			//document.getElementById('1140_image').style.display='block';
			//document.getElementById('1120_image').style.display='none';
            //document.getElementById('11401_image').style.display='block';
			//document.getElementById('11201_image').style.display='none';
			
			$("#1140_image").show();
			$("#1120_image").hide();
			$("#11401_image").show();
			$("#11201_image").hide();

		    $('#13').removeAttr('class');
			$('#13tdlast').attr( "style","cursor:move;");
		    $('#13tdlast').attr( "class","table-right" );
			$('#13tdlast').attr( "onmouseout", "this.className='table-right';" );
			$('#13tdlast').attr( "style","background: url("+"<?php echo Configure::read('base_url');?>"+"images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat;");

			$('#14').removeAttr('class');
			$('#14tdlast').attr( "style","cursor:move;");
		    $('#14tdlast').attr( "class","table-right" );
			$('#14tdlast').attr( "onmouseout", "this.className='table-right';" );
			$('#14tdlast').attr( "style","background: url("+"<?php echo Configure::read('base_url');?>"+"images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat 3px 5px;border:none;");
			$('#14').addClass( "graybg" );
			$('#13').addClass( "graybg" );
			
			
			
			
			
			
			$('#09').removeClass( "graybg" );
			$('#10').removeClass( "graybg" );
			$('#11').removeClass( "graybg" );
			$('#12').removeClass( "graybg" );
			
			//show last td
			
			
			$('#09tdlast').show();
			$('#10tdlast').show();
			$('#11tdlast').show();
			$('#12tdlast').show();
			
			
			//make right border white
			
			$('#09').attr("style","border-right:1px solid #ccc");
			$('#10').attr("style","border-right:1px solid #ccc");
			$('#11').attr("style","border-right:1px solid #ccc");
			$('#12').attr("style","border-right:1px solid #ccc");
			
			
			
			$('#09tdlast').attr( "style","background: url("+"<?php echo Configure::read('base_url');?>"+"images/assets/icons/9px/198_angleright_06_cmyk.gif) 3px 5px no-repeat;");
			
			$('#10tdlast').attr( "style","background: url("+"<?php echo Configure::read('base_url');?>"+"images/assets/icons/9px/198_angleright_06_cmyk.gif) 3px 5px no-repeat;");
			
			$('#11tdlast').attr( "style","background: url("+"<?php echo Configure::read('base_url');?>"+"images/assets/icons/9px/198_angleright_06_cmyk.gif) 3px 5px no-repeat;");
			
			$('#12tdlast').attr( "style","background: url("+"<?php echo Configure::read('base_url');?>"+"images/assets/icons/9px/198_angleright_06_cmyk.gif) 3px 5px no-repeat;");
			
			$('#13tdlast').attr( "style","background: url("+"<?php echo Configure::read('base_url');?>"+"images/assets/icons/9px/198_angleright_06_cmyk.gif) 3px 5px no-repeat;");
			
			$('#14tdlast').attr( "style","background: url("+"<?php echo Configure::read('base_url');?>"+"images/assets/icons/9px/198_angleright_06_cmyk.gif) 3px 5px no-repeat;");
			
			
			
			
			
			
						
		  }
		  else{
			//document.getElementById('1120_image').style.display='block';
			//document.getElementById('1140_image').style.display='none';
			//document.getElementById('11401_image').style.display='none';
			//document.getElementById('11201_image').style.display='block';
			
			$("#1140_image").hide();
			$("#1120_image").show();
			$("#11401_image").hide();
			$("#11201_image").show();
			
			$('#13tdlast').removeAttr( "class" );
			$('#13tdlast').removeAttr( "onmouseout" );
			$('#13tdlast').removeAttr( "style" );

			$('#14tdlast').removeAttr( "class" );
			$('#14tdlast').removeAttr( "onmouseout" );
			$('#14tdlast').removeAttr( "style" );

			$('#09').addClass( "graybg" );
			$('#10').addClass( "graybg" );
			$('#11').addClass( "graybg" );
			$('#12').addClass( "graybg" );
			$('#13').addClass( "graybg" );
			$('#14').addClass( "graybg" );
			
			/*$('#09tdlast').removeAttr( "style","background: url(/voipphoneRE3.2/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat;");
			$('#09tdlast').find('.table-menu').remove();
			$('#10tdlast').removeAttr( "style","background: url(/voipphoneRE3.2/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat;");
			$('#10tdlast').find('.table-menu').remove();
			$('#11tdlast').removeAttr( "style","background: url(/voipphoneRE3.2/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat;");
			$('#11tdlast').find('.table-menu').remove();
			$('#12tdlast').removeAttr( "style","background: url(/voipphoneRE3.2/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat;");
			$('#12tdlast').find('.table-menu').remove();
			$('#13tdlast').removeAttr( "style","background: url(/voipphoneRE3.2/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat;");
			$('#13tdlast').find('.table-menu').remove();
			$('#14tdlast').removeAttr( "style","background: url(/voipphoneRE3.2/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat;");
			$('#14tdlast').find('.table-menu').remove();*/
			
			
			
			//hiding last td
			$('#09tdlast').hide();
			$('#10tdlast').hide();
			$('#11tdlast').hide();
			$('#12tdlast').hide();
			
			
			//make right border white
			
			$('#09').attr("style","border-right:1px solid #fff");
			$('#10').attr("style","border-right:1px solid #fff");
			$('#11').attr("style","border-right:1px solid #fff");
			$('#12').attr("style","border-right:1px solid #fff");
	     }
		 
		
		 
		

//});


        //right side image close button
		
		$('#rightSideImage,#expansionImage1,#expansionImage2').click(function(){
			setTimeout( function() {     
			$('.fancybox-skin').append('<div style="font-size: 18px !important;"> <a href="javascript:;" id="close" style="cursor:pointer;"  onMouseOut="UnTip()" onclick="UnTip(); return fancyboximgclose(); ">X</a></div>');
			var tiptext="<?php echo __('close_window') ?>";
		$('#close').attr("onMouseOver","Tip('"+tiptext+"', BALLOON, true, ABOVE, false"+")");		
		 },700);
			});

        //right side image close button ends



	});


        function toggleShowHistory(){
			
         	//$("#advancesearch").show
         	if(document.getElementById('showhistory').style.display=='none'){
         		document.getElementById('showhistory').style.display='block';
				
				$('#pbtn').hide();
             	$('#mbtn').show();
				
         	}else{
         		document.getElementById('showhistory').style.display='none';
				
				$('#pbtn').show();
             	$('#mbtn').hide();
         	}
         }

        function toggleShowExpansion(){
         	//$("#advancesearch").show
         	if(document.getElementById('showexp').style.display=='none'){
         		document.getElementById('showexp').style.display='block';

             	$('#expplus').hide();
             	$('#expminus').show();

         	}else{
         		document.getElementById('showexp').style.display='none';
         	}
         }
        function submitForm(){
		$('.filtersForm').attr('action',base_url+'stations/major_cfeature_change/<?php
echo $statId;
?>');
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
	function del_feature(delFeat){
		$('.filtersForm').attr('action',base_url+'stations/major_cfeature_change/<?php echo $statId;?>&delete_feature='+delFeat);
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

</script>

<script>
function set_visimenu(val)
{
	
	if(val=='dispmenu') {
			$("#edit_stat_popupmenu").slideToggle("slow");
	}
}

</script>

<?php

//echo $javascript->link('/js/jquery-1.10.1.min');
echo $javascript->link('/js/jquery.fancybox');
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});

		function submenuactivity(obj, action) {
        if (action == 1) {
            $('#table-menu-popup').show();
        } else if (action == 0) {
            $('#table-menu-popup').hide();
        }
    }

	function submenuactivity2(obj, action) {
        if (action == 1) {
            $('#table-menu-popup2').show();
        } else if (action == 0) {
            $('#table-menu-popup3').hide();
        }
    }

	function submenuactivity3(obj, action) {
        if (action == 1) {
            $('#table-menu-popup3').show();
        } else if (action == 0) {
            $('#table-menu-popup3').hide();
        }
    }


	function memberGroupCount(short_name,feature_shortName, stationedit_feature,closeId){


		
		//short_name is DB feature to lookup
		//feature_shortName is with key attached
		//stationedit_feature  is the key featureName
		$('#confirm2').html("");
		$('#confirm7').html("");
		
		    var clickedScenario = $('#stationUID').val();
			
			var stationId = $('#stationId').val();
			
			 var TargetURL = "<?php echo Configure::read('base_url'); ?>stations/groupMemberCount/station_id:" + stationId + "/delete_action:" + feature_shortName + "/delete_feature:" +  clickedScenario+ "/short_name:" +  short_name;
				
	            jQuery.post(TargetURL, function(data) {
	             
					
	            if(data==1)
	            {
				  
				    var confirmation_msg = "<?php echo __("groupLastMemberDeleteConfiramtion");?>";
					$('#confirm1').hide();
					$('#confirm2').show();
					$('#confirm2').html(confirmation_msg);
					$('#clickerId').attr("onclick","stationAud_delete()");
				}
				else{
					//alert(stationedit_feature);
					if(stationedit_feature=="DN_XLH_PILOT")
					{
						
						$('#'+closeId).trigger("click");
					    $('#displayMsg').html("<?php echo __("noXlhPilotDelete");?>");
	                    $('#displayMsgbutton').trigger("click");
					}
					else if(stationedit_feature == "DN_MADN_PILOT"){
						
						$('#'+closeId).trigger("click");
					    $('#displayMsg').html("<?php echo __("noMADNPilotDelete");?>");
	                    $('#displayMsgbutton').trigger("click");
						
					}
					else
					{
						stationAud_delete();
						//deleteStation();
						$('#confirm1').show();
						$('#confirm2').hide();
					}
				}

	            });
			
		
	}
		

	function deleteStationCheck(short_name,feature_shortName, stationedit_feature,closeId){
		
		
		//short_name is DB feature to lookup
		//feature_shortName is with key attached
		//stationedit_feature  is the key featureName
		$('#confirm2').html("");
		$('#confirm7').html("");
		
		    var clickedScenario = $('#stationUID').val();
			
			var stationId = $('#stationId').val();
			
			 //var TargetURL = "<?php echo Configure::read('base_url'); ?>stations/groupMemberCount/station_id:" + stationId + "/delete_action:" + feature_shortName + "/delete_feature:" +  clickedScenario+ "/short_name:" +  short_name;
			 
			  var TargetURL = "<?php echo Configure::read('base_url'); ?>stations/checkStationDeleteValidity/groupString:<?php echo $groupString ?>";
				
	            jQuery.post(TargetURL, function(data) {
					
					var isgroupDelete = data.split('/');
				
		   	    var DeleteStation = isgroupDelete['0'];
		   	    var GroupDeleteConfirm = isgroupDelete['1'];	
	            if(DeleteStation==1)
	            {
				   
					if(GroupDeleteConfirm==1){
						deleteStation();
						
					}
					else{
						var msgContent = '<?php echo __('confirmToDeleteGroup');?>';
						$('#close-btn4').trigger("click");
					$('#msgafterchek').html(msgContent);
					$('#clickerID10').trigger("click");
					$('#clickerID10').attr("onclick","javascript:deleteStationGroup();");
					}
					
				
					
				}
				else{
					
					
					$('#close-btn4').trigger("click");
					$('#'+closeId).trigger("click");
						
					    $('#displayMsg').html("<?php echo __("noStationDelete");?>");
	                    $('#displayMsgbutton').trigger("click");
					
				}

	            });
			
			
	
		}
function purgeStationCheck(short_name,feature_shortName, stationedit_feature,closeId){
		
		$('#confirm2').html("");
	$('#confirm7').html("");
	
	    var clickedScenario = $('#stationUID').val();
		
		var stationId = $('#stationId').val();
		
		 var TargetURL = "<?php echo Configure::read('base_url'); ?>stations/groupMemberCount/station_id:" + stationId + "/delete_action:" + feature_shortName + "/delete_feature:" +  clickedScenario+ "/short_name:" +  short_name;
			
            jQuery.post(TargetURL, function(data) {

           
            if(data==1)
            {
			  
			      purgeStation();
				  
				 
			   
			}
			else{
				//alert(stationedit_feature);
				if(stationedit_feature=="DN_XLH_PILOT")
				{
					//if it is xlh_pilot and there are more than 1 group memeber then don't allow to delete
					/*$('#confirm1').hide();
					$('#confirm2').hide();
					$('#confirm7').show();
					$('#confirm7').html("<?php echo __('canNotDeleteXlhPilotwithMembers')?>");
					*/
					
				 //$('#close-btn4').trigger("click");
					$('#'+closeId).trigger("click");
					
				    $('#displayMsg').html("<?php echo __("noXlhPilotDelete");?>");
                    $('#displayMsgbutton').trigger("click");
				}
				else
				{
					
					
					purgeStation();
					$('#confirm1').show();
					$('#confirm2').hide();
				}
			}

            });
		
				
	   
	}

</script>
<style>
#table-menu-popup {
    margin-left: 130px !important;
    margin-top: -10px;
    padding: 0;
    position: absolute;
}

</style>
<style type="text/css">
/* CSS for modelpopup */
     
#clicker,#clicker2,#clicker4,#clicker5,#clicker6	{	cursor:pointer;	}

#popup-wrapper,#popup-wrapper2,#popup-wrapper4, #popup-wrapper5, #popup-wrapper6	{
	width:390px;
	height:180px;
	background-color:#F9F9F9;
	padding:10px;		
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
.modalPopLite-mask2{
    background-color: #f;
    left: 0;
    position: absolute;
    top: 0;
    z-index: 9994;
}
	</style>

<script>
  	function stationAud_delete(){
		
		$("#modalPopLite-mask").hide();		
		$("#modalPopLite-mask").css("background-color", "#f");
		$("#modalPopLite-mask").attr('class','modalPopLite-mask2');
		
		$("#modalPopLite-mask1").hide();		
		$("#modalPopLite-mask1").css("background-color", "#f");
		$("#modalPopLite-mask1").attr('class','modalPopLite-mask2');
		var clickedScenario = $('#stationUID').val();
		
		var deleteAction = $('#stationDeleteAction').val();

		var stationId = $('#stationId').val();
		var tval = clickedScenario.split('-');
		var valCond = tval[1];
		$('.black_overlay').css('display', 'block');
	    $.fancybox.showLoading();	
		
		setTimeout( function() {
         
		
			
		var TargetURL = "<?php echo Configure::read('base_url');?>stations/"+deleteAction+"&feature_id="+clickedScenario;			
		

$.fancybox.showLoading()  ;
		window.location.href = TargetURL;
	},2000);
	$.fancybox.showLoading()  ;	
 		//jQuery.post( TargetURL,  function( data ) {  //alert(data);
			//window.location.href = "<?php echo Configure::read('base_url'); ?>stations/editstation/<?php echo $statId; ?>";
	//});
	/*setTimeout( function() {     
			$('#close-btn').trigger('click');
		 },200);*/
	
}

  	function uploadStation(){
	       
		   $("#modalPopLite-mask4").hide();		
		$("#modalPopLite-mask4").css("background-color", "#f");
		$("#modalPopLite-mask4").attr('class','modalPopLite-mask2');
	   $('.black_overlay').css('display', 'block');
	    $.fancybox.showLoading();
		setTimeout( function() {     
	   window.location= "<?php echo Configure::read('base_url');?>stations/uploadStation/<?php echo $statId?>";
	   },1000);
	   
	}
function deleteStation(){
	   
		$("#modalPopLite-mask1").hide();		
		$("#modalPopLite-mask1").css("background-color", "#f");
		$("#modalPopLite-mask1").attr('class','modalPopLite-mask2');
		$('.black_overlay').css('display', 'block');
	    $.fancybox.showLoading();	
		setTimeout( function() {     
		window.location= "<?php echo Configure::read('base_url');?>stations/deleteStation/<?php echo $statId?>";
		},1000);
		
	}
	
	function purgeStation(){
	       
		   $("#modalPopLite-mask3").hide();		
		$("#modalPopLite-mask3").css("background-color", "#f");
		$("#modalPopLite-mask3").attr('class','modalPopLite-mask2');
	   $('.black_overlay').css('display', 'block');
	    $.fancybox.showLoading();
		setTimeout( function() {     
	   window.location= "<?php echo Configure::read('base_url');?>stations/purgeStation/<?php echo $statId?>";
	   },1000);
	   
	}
  </script>
  <script type="text/javascript">
//script for modelpopup

	  function InitStation(val,val2){
	  	
		document.getElementById('stationUID').value=val;
		document.getElementById('stationDeleteAction').value=val2;
		var t = val.split('-');

		
		
		if(t[1]=="RAG"){
			var type="<?php echo __('RAG',true)?>";	
		}
		else if(t[1]=="PRK"){
			var type="<?php echo __('PRK',true)?>";	
		}
		else if(t[1]=="CNF"){
			var type="<?php echo __('CNF',true)?>";	
		}
		else if(t[1]=="CXR"){
			var type="<?php echo __('CXR',true)?>";	
		}
		else if(t[1]=="CPU"){
			var type="<?php echo __('CPU',true)?>";	
			
		}
		else{
			var type="<?php echo __('unknownFeature',true)?>";	
		}
		
	   var saprate1=" <?php echo  __('Of',true); ?> ";
	   var saprate2=" <?php echo  __('station',true); ?> ";
	   var saprate=saprate1+" "+saprate2;
		var tp=t[0].replace("@",saprate);
		
	
		var cMessage = "<?php echo __('deleteFeatureFromKey') ?>  " +type+ " <?php echo __('Key') ?> "+ tp;
		//break confirmation message in two line 
		var newline = "</br>";	
		var position = 66;
		
		if(cMessage.length>71){
      var confirmationMsg = [cMessage.slice(0, position), newline, cMessage.slice(position)].join('');
		}
		else{
			var confirmationMsg = cMessage;
		}
		//break confirmation message in two line ends here
		$("#confirm1").html(confirmationMsg);
		
	
	  }

	$(function () {
	    $('.popup-wrapper').modalPopLite({ openButton: '.clicker', closeButton: '#close-btn', isModal: true });
		$('#popup-wrapper2').modalPopLite({ openButton: '.clicker2', closeButton: '#close-btn2', isModal: true });
		$('#popup-wrapper4').modalPopLite({ openButton: '.clicker4', closeButton: '#close-btn4', isModal: true });
		$('#popup-wrapper5').modalPopLite({ openButton: '.clicker5', closeButton: '#close-btn5', isModal: true });
		$('#popup-wrapper6').modalPopLite({ openButton: '.clicker6', closeButton: '#close-btn6', isModal: true });
		
	});
	
	
</script>
<script>
	function fancyboximgclose(){
		setTimeout( function() { $('.fancybox-overlay').trigger('click'); },5);
		 
	}
</script>
<script>
	function fancyboxclose(){
		setTimeout( function() { $('#close-btn').trigger('click'); },5);
		
	 	}
		function fancyboxclose2(){
		setTimeout( function() { $('#close-btn2').trigger('click'); },5);
		setTimeout( function() { $('#close-btn5').trigger('click'); },5);
		setTimeout( function() { $('#close-btn4').trigger('click'); },5);
		setTimeout( function() { $('#close-btn6').trigger('click'); },5);
		
	 	}
		
</script>
<script>
function change_password(){
		 
	 	$('#close-btn2').click();
	 	$('#passwordChange').click();
	 
}
</script>

<?php if($stationDetails[0]['Station']['status']=='9'){    ?>
	<script>
	$(document).ready(function() {
	$('#content a').bind("click.myDisable", function() { return false; });
	$('#related-content a').bind("click.myDisable", function() { return false; });
	$('#content a.clicker6').hide();
	

	});
	</script>


<?php }   ?>
<?php
// Set COnstants
$activationusers = Configure::read('activationusers');
 $featureStatus = Configure :: read('featureStatus');
 $stationStatus = Configure :: read('stationStatus');
?>
<div class="block top">

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



<div id="newEdit">
		<div class="form-body">

<?php

#-----------------------------------------------------------------------------#
#                If Base Station only show some dialgoue                      #
#-----------------------------------------------------------------------------#

if($stationDetails[0]['Station']['status'] == 6){


	echo $form->create('Station',array('action'=>'updateBase','id'=>'updateBase','type'=>'POST'));
	echo $form->input('Station.id', array('type'=>'hidden','value'=>$stationDetails[0]['Station'])); ?>


		<!--CBM ADDED BUTTONS TO TOP-->

	<h4><?php echo __('Station Details');?></h4>
			<div class="form-box">
				<div class="form-left">
					<?php #echo $form->input('station_id', array('value'=>$stationDetails[0]['Station']['id'], 'style'=>'width:200px;')); ?>
					<?php
					echo '<div style="width:100px; float: left">' . __('stationId', true). '</div>';
					echo $form->input('station_id', array('type'=>'text','label' => false,'value'=>$stationDetails[0]['Station']['id'],'style'=>'width:100px;','readonly'=>$readonly));
					?>
				</div>
				<div class="form-right">
					<?php #echo $form->input('status', array('value'=>$stationDetails[0]['Station']['status'], 'style'=>'width:200px;')); ?>
					<?php
					echo '<div style="width:100px; float: left">' . __('stationStatus', true). '</div>';
					echo $form->input('stationStatus', array('type'=>'text','label' => false,'value'=>$stationStatus[$stationDetails[0]['Station']['status']],'style'=>'width:100px;','readonly'=>$readonly));
					?>
				</div>
				<div class="form-left">
						<?php
								#$phoneTypesAll = array_merge($phoneTypes['CICM'], $phoneTypes['ANLG']);
								$phoneTypesAll = $phoneTypes['CICM'] + $phoneTypes['ANLG'];
								#echo $form->select('phone_type', $phoneTypesAll,$stationDetails1[0]['Station']['phone_type'],array('style'=>'width:200px;','id'=>'drp','onchange'=>"javascript:submi_form('updateBase');"));
								echo '<div style="width:100px; float: left">' . __('phoneType', true). '</div>';
								echo $form->select('phone_type', $phoneTypesAll,$stationDetails[0]['Station']['phone_type'],array('label'=>false, 'style'=>'width:100px;','id'=>'drp','onchange'=>"javascript:submi_form('updateBase');"));
							?>
				</div>
				<div class="form-right">
					<?php
						# Show the selectableport if the station is ANLG and status -== 6
							if ($stationDetails[0]['Station']['type'] == 'CICM')
							{

								echo '<div style="width:100px; float: left">' . __('PhonePassword', true). '</div>';
								echo $form->input('PhonePassword', array('type'=>'text','label' => false,'value'=>'','style'=>'width:100px;', 'onchange'=>"javascript:submi_form('updateBase')"));
								#echo $form->input('PhonePassword', array('value'=>'', 'style'=>'width:200px;', 'onchange'=>"javascript:submi_form('updateBase')"));
							}
							elseif($stationDetails[0]['Station']['type'] == 'ANLG')
							{
								echo '<div style="width:100px; float: left">' . __('phoneType', true). '</div>';
								echo $form->select('phone_type', $phoneTypes[$stationDetails[0]['Station']['type']],$stationDetails[0]['Station']['phone_type'],array('label'=>false, 'style'=>'width:100px;','onchange'=>"javascript:submi_form('layoutchange');"));

								#echo $form->select('port', $ports,$stationDetails[0]['Station']['port'],array('style'=>'width:200px;','onchange'=>"javascript:submi_form('updateBase');"));
							}


						?>
				</div>
			</div>
			<div class="button-right">
					<a href="javascript:submi_form('updateBase')"  onclick="" name="submitForm" value="submitForm" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php
__("add");
					?></a>

		</div>


	<?php

}
else { # Else The station is not status 6
	 ?>

	 <h4><?php echo __('Station Details') . $stationDetails[0]['Station']['id'] ; ?>
       	 	<span style="display: inline; float:right;" id="sts"><?php echo __('stationStatus') . __($stationStatus[$stationDetails[0]['Station']['status']], true); ?></span>
			 </h4>
			 
			 
			 	<div style="padding-left: 5px; width: 600px;">
                   <!-- <a href="javascript:void(null)" id="edit_stat"  onmouseover="submenuactivity(this, 1)" onmouseout="submenuactivity(this, 0)" <?php echo $readonly; ?>><?php __("Options"); ?> </a>-->
					<!-- <a href="javascript:void(null)" id="edit_stat" onclick="set_visimenu('dispmenu')"  <?php echo $readonly; ?>><?php __("Options"); ?> </a>-->
                   <!-- <div class="table-menu" id="edit_stat_popupmenu">
                        <div class="table-menu-popup" id="table-menu-popup" style="z-index: 1">-->
						 
					 <div id="edit_stat_popupmenu"   style="width:150px !important;float:left;">
                        <div  style="z-index: 1">
                           <ul>
						   
							  <li><div>
							   <a href="" onclick="return false" style="text-decoratio:none;color:#000;"><span  id="edit_stat" style="text-decorationnone;color:#000; margin-left:0px; float:left;cursor:default;font-weight: bold;"   <?php echo $readonly; ?>><?php __("stationEditOptions"); ?> </span></a>
							  
							  
							  	</div></li>
						        
                                <li class="inactive">
   								 <?php
   								 #WORKING echo $html->link(__("resetFeatures", true), array('controller'=> 'stations', 'action'=>'resetFeature',$statId));
   								 #echo $html->link(__("resetFeatures", true), '');
   								 ?>
                                </li>
								<?php if(($stationDetails[0]['Station']['type'] != 'ANLG') && ($stationDetails[0]['Station']['status'] < 7)){?>
                                <li class="schedule">
   								 <?php echo $html->link(__("changePassword", true), array('controller'=> 'stations', 'action'=>'change_password',$statId), array('class' => "fancybox fancybox.ajax")); ?>
								<!-- <div style="display: none;">
								 <a id="passwordChange" href="<?php echo Configure::read('base_url');?>stations/change_password/<?php echo $statId ?>" class="fancybox fancybox.ajax"><?php echo __("changePassword", true); ?></a>
								 </div>
								 
								 <a href="javascript:;" id="changePassword" click="javascript:change_password();" ><?php echo __("changePassword", true); ?></a>-->
								 
								 
								 
                                 </li>
                                 <?php }?>
								  <li class="schedule">
                                <?php /*echo $html->link(__('stationFeatures', true), array(
    							'controller' => 'stations',
    							'action' => 'station_features',
    							$statId
								), array(
								'class' => 'fancybox fancybox.ajax'
								));*/
								?>
								<?php 
								
								if($stationDetails[0]['Station']['status'] != 7){
								
								?>
								
								 <a href="<?php echo Configure::read('base_url');?>stations/station_features/<?php echo $statId ?>"  class="fancybox fancybox.ajax"><?php echo __("stationFeatures", true); ?></a>
								 
								 
                                 <?php }
                                else {
									
									?>
									
									<a href="" onclick="return false" onMouseOver="Tip('<?php echo __('stationFeaturesTooltip') ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " ><?php echo __("stationFeatures", true); ?></a>
								 
								 
								<?php } 
		
								
								?>
								 </li>
								
                                
                                <?php 
                                if($stationDetails[0]['Station']['type'] != 'ANLG'){
                                if($stationDetails[0]['Station']['status'] < 7){?>
								<li class="schedule">
   								 <?php
   								 #echo $html->link(__("Add DN", true), array('controller'=>'dns','action'=>'selectdns','station_id:'.$statId . '&type=singleLogic'), array('class' => "fancybox fancybox.ajax"));
   								 #echo $html->link(__("resetFeatures", true), '');
   								 ?>
								 
								  <a href="<?php echo Configure::read('base_url');?>dns/selectdns/station_id:<?php echo $statId ?>&type=singleLogic&page=editstation&loc_id=<?php echo $stationLocationid;  ?>" class="fancybox fancybox.ajax"><?php echo __("Add DN", true); ?></a>
								 
                                </li>
                                
                                <?php }
                                else {?>
									
									<a href="" onclick="return false"onMouseOver="Tip('<?php echo __('addDnTooltip') ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " ><?php echo __("Add DN", true); ?></a>
								 
								 
								<?php }
								}
								
								if(($stationDetails[0]['Station']['status'] != 7) && ($userpermission==Configure::read('access_id')))
								{?>
                                <li class="schedule">
                                <?php #echo $html->link(__('addCombox', true),'');?>
								 <a href="javascript:void()" onMouseOver="Tip('<?php echo __('deleteStationTooltip') ?>', BALLOON, true, ABOVE, false);" class="clicker4" id="deleteStation" onMouseOut="UnTip(); " ><?php echo __("deleteStation", true); ?></a>
								  
                                
                                </li>
								  <?php if(($userpermission==Configure::read('access_id')) && ($activationusers[$_SESSION['ACCOUNTNAME']] == 'RE3')){?>
								   <li class="schedule">
								   <a href="javascript:void()" onMouseOver="Tip('<?php echo __('purgeStationTooltip') ?>', BALLOON, true, ABOVE, false);" class="clicker5"  onMouseOut="UnTip(); " ><?php echo __("purgeStation", true); ?></a>
								  
								  </li>
								  
		                       <?php }
                               } 
                                if($stationDetails[0]['Station']['status'] == 7){?>
								
                                <li class="schedule">
                                <?php #echo $html->link(__('addCombox', true),'');?>
								 <a href="<?php echo Configure::read('base_url');?>stations/overrideException/station_id:<?php echo $statId?>" onMouseOver="Tip('<?php echo __('overrideException') ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " ><?php echo __("overrideException", true); ?></a>
                                
                                </li>
                               <?php } 
                               if(($userpermission==Configure::read('access_id'))  && ($activationusers[$_SESSION['ACCOUNTNAME']] == 'RE3')){?>
                               		   <li class="schedule">
                               			   <a href="javascript:void()" onMouseOver="Tip('<?php echo __('uploadStationTooltip') ?>', BALLOON, true, ABOVE, false);" class="clicker6"  onMouseOut="UnTip(); " ><?php echo __("uploadStation", true); ?></a>
                               		  </li>
                               								  
                               <?php } ?>
                            </ul>
                        </div>
                    </div>
					
					
					
					<div  style="width:275px;float:left; padding:20px; margin-left: 50px; " >
				   
               <?php
                   $stationActive = ($stationDetails[0]['Station']['status'] == 1) ? 'display:block;' : 'display:none;';
                   $stationImported = ($stationDetails[0]['Station']['status'] == 2) ? 'display:block;' : 'display:none;';
                   $stationDiscovered = ($stationDetails[0]['Station']['status'] == 3) ? 'display:block;' : 'display:none;';
                   $stationTest = ($stationDetails[0]['Station']['status'] == 4) ? 'display:block;color:#AC1917 !important;font-weight: bold;font-size: 17.5px; !important' : 'display:none;';
                   $stationInwork = ($stationDetails[0]['Station']['status'] == 5) ? 'display:block;' : 'display:none;';
                   $statioAdded = ($stationDetails[0]['Station']['status'] == 6) ? 'display:block;color:#AC1917 !important;font-weight: bold;font-size: 17.5px !important;' : 'display:none;';
                   $stationException = ($stationDetails[0]['Station']['status'] == 7) ? 'display:block;color:#AC1917 !important;font-weight: bold;font-size: 17.5px !important;' : 'display:none;';
                   $stationSpecialConfig = ($stationDetails[0]['Station']['status'] == 8) ? 'display:block;color:#AC1917 !important;' : 'display:none;';
                   
               ?>				
                   <p id="crm_comment_workflow" style="<?php echo $stationActive; ?>"><?php __(stationEditActive_blurb) ?> </p>                           
                   <p id="complete_workflow" style="<?php echo $stationImported; ?>"><?php __(stationEditImported_blurb) ?></p>
                   <p id="reject_workflow" style="<?php echo $stationDiscovered; ?>"><?php __(stationEditDiscovered_blurb) ?></p>
                   <p id="activate_workflow" style="<?php echo $stationInwork; ?>"><?php __(stationEditInwork_blurb) ?></p>
                   <p id="deactivate_workflow" style="<?php echo $stationException; ?>"><?php __(stationEditException_blurb) ?></p>
                   <p id="invalid_workflow" style="<?php echo $stationSpecialConfig; ?>"><?php __(stationEditSpecialConfig_blurb) ?></p>
                   
                   	            
			</div>
			</div>


   



	<!--CBM ADDED BUTTONS TO TOP-->


			<div class="form-box">
				<!--<div class="form-left">
					<?php
						#echo $form->select('phone_type', $phoneTypes[$stationDetails[0]['Station']['type']],$stationDetails[0]['Station']['phone_type'],array('style'=>'width:200px;','onchange'=>"javascript:submi_form('filters');"));
						#echo $form->input('phone_type', array('type'=>'select', 'options'=>$phoneTypes[$stationDetails[0]['Station']['type']], 'default'=>$stationDetails[0]['Station']['phone_type'],array('style'=>'width:200px;','onchange'=>"javascript:submi_form('layoutchange');")));
						#echo $form->input('phone_type', array('value'=>$stationDetails[0]['Station']['phone_type'], 'style'=>'width:200px;'));
					?>
					<?php
						echo '<div style="width:100px; float: left">' . __('phoneType', true). '</div>';
						echo $form->select('phone_type', $phoneTypes[$stationDetails[0]['Station']['type']],$stationDetails[0]['Station']['phone_type'],array('label'=>false, 'style'=>'width:100px;','onchange'=>"javascript:submi_form('layoutchange');"));
						
						
						
						//echo $form->input('phone_type',array('label'=>false,'value'=>$stationDetails[0]['Station']['phone_type'], 'style'=>'width:100px;padding-left:5px;','onchange'=>"javascript:submi_form('layoutchange');",'readonly'=>'true'));
						
					?>
					
				</div>-->
			<?php	echo $form->input('phone_type',array('label'=>false,'value'=>$stationDetails[0]['Station']['phone_type'], 'style'=>'width:100px;padding-left:5px;','onchange'=>"javascript:submi_form('layoutchange');",'type'=>'hidden')); ?>
				
				<!--<div class="form-right">
					<?php
					# Show the selectableport if the station is ANLG and status -== 6

								#echo $form->input('port', array('value'=>$stationDetails[0]['Station']['port'], 'style'=>'width:200px;'));

						?>
						<?php
					echo '<div style="width:75px; float: left">' . __('Port', true). '</div>';
					//echo $form->input('port', array('type'=>'text','label' => false,'value'=>$stationDetails[0]['Station']['port'],'style'=>'width:175px;padding-left:5px;','readonly'=>'true'));
					?>
					
					<?php if($stationDetails[0]['Station']['type']=="ANLG"){     ?>
				 <div style="float:right;margin-right: 15px; padding-left:5px;background:#F9F9F9; border:1px solid #F1F1F1" >	<a     href="<?php echo Configure::read('base_url')."mediatrixes/edit/mediatrix_id:".$mediatrixId;?>" ><?php echo $stationDetails[0]['Station']['port'] ?></a></div>
				 
				 <?php } else{ ?>
				 
				  <div style="float:right;margin-right: 15px; padding-left:5px;background:#F9F9F9; border:1px solid #F1F1F1" >	<?php echo $stationDetails[0]['Station']['port'] ?></div>
				 
				 <?php } ?>
				 
				</div>-->
				
				
				
			</div>

<?php
} #end of status != 6

echo $form->end();

if($stationDetails[0]['Station']['status'] != 6){


echo $form->create('Station', array(
				'action' => 'editStation',
				'id' => 'filters',
				'class' => 'filtersForm',
				'type' => 'GET'
));
?>
<div class="cb">



        <!--<div class="form-box">

					<?php
					foreach ($stationDisplayFeature as $stationDFeature)
					{
						if($stationFeatures[$stationDFeature] == '1')
						{
							echo $stationDFeature . ' ';
						}
					}

					?>

			</div>-->

      <?php 
      /*
      if($stationDetails[0]['Station']['status'] == 5){
    	?>
    <div class="button-right">
    		<?php echo $html->link( __('apply', true),  array('controller'=> 'stations', 'action'=>'apply',$statId),array('onmouseover'=>'javascript:hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
    </div>
    <?php } 
    
    	*/?>
       <h4><?php echo __('Key Features')?>
	   
	 <!--  <div style="padding-left: 5px; display: inline">
                    <a href="javascript:void(null)" id="edit_keyfeatures"  onmouseover="submenuactivity3(this, 1)" onmouseout="submenuactivity3(this, 0)" <?php echo $readonly; ?>><?php __("Options"); ?> </a>
                    <div class="table-menu" id="edit_keyfeatures_popupmenu">
                        <div class="table-menu-popup" id="table-menu-popup3" style="z-index: 1">
                            <ul>
                                <li class="schedule">
   								 <?php
   								 echo $html->link(__("Add DN", true), array('controller'=>'dns','action'=>'selectdns','station_id:'.$statId . '&type=singleLogic'), array('class' => "fancybox fancybox.ajax"));
   								 #echo $html->link(__("resetFeatures", true), '');
   								 ?>
                                </li>

                            </ul>
                        </div>
                    </div>

                </div>-->

     </h4>


      <?php




	// check $stationFeatures variable exists and is not empty
	if (isset($keyFeatures) && !empty($keyFeatures)):

	#echo "<pre>";print_r($keyFeatures);
	?>


	    <div id="" class="table-content main_table_content" style="height: auto!important">
		<div id="AjaxResult" style="display:none; float: right; width: 250px; border: 1px solid silver; padding: 4px; font-size: 90%">
		</div>


		<!--  BASE STATION -->
		<h5><?php echo __('BaseKeys', true)?></h5>
		



		<!--  This is the actual data in the table -->
		<table class="phonekey stationtb2" id="dragdroptbl">

		<thead>
			<tr class="table-top">

				 <th class="table-column" style='width:20px'>&nbsp;<?php echo __('Key'); ?>&nbsp;&nbsp;</th>
				 <th class="table-column" style='width:10px'>&nbsp;&nbsp;</th>
				 <th class="table-column" style='width:90px' align="left" >&nbsp;<?php echo __('Label'); ?>&nbsp;&nbsp;</th>
				 <th class="table-column" style='width:150px' align="left">&nbsp;<?php echo __('Feature'); ?>&nbsp;&nbsp;</th>
				 <th class="table-column" style='width:80px' align="left">&nbsp;<?php echo __('Value'); ?>&nbsp;&nbsp;</th>
				   <!--<th class="table-column" style='width:50px'>&nbsp;&nbsp;<?php echo __('Status'); ?> &nbsp;&nbsp;</th>-->
				   <!-- <th class="table-column" style='width:20px'>&nbsp;&nbsp;<?php echo __('info'); ?>&nbsp;&nbsp;</th>-->
				 <th class="table-columnt"  align="left" style="border-right: 1px solid #D1D1D1!important;">&nbsp;&nbsp;<?php echo (''); ?>&nbsp;&nbsp;</th>
 			 </tr>
		</thead>
 		 <tbody>
		 <?php
    	// initialise a counter for striping the table
    	$stationArray = array();
    	echo $form->input("newaddedFeatues", array(
        	'type' => 'hidden',
        	'value' => '',
        	'id' => "newaddedFeatues"
    	));
		$finalAry = array();
		#echo "<pre>";print_r($keyFeatures);
		foreach($keyFeatures as $k=>$v){
			$station_id = explode('@', $v['Feature']['id']);
			$sta_id_key    = str_pad($station_id[0], 2, '0', STR_PAD_LEFT);
			$finalAry[$sta_id_key] = $v;

		}
        #echo "<pre>";print_r($keyFeatures);
		// Loop through the 14 keys of the station
    	for ($j = 0; $j < 14; $j++)
		{
        	$stationArray = $keyFeatures[$j]; //$setHeight = "";
			$sta_id = str_pad($j+1, 2, '0', STR_PAD_LEFT);
        	$class        = (($j % 2) ? " class='altrow'" : '');
      		if (isset($finalAry) && !empty($finalAry[$sta_id]['Feature']['id'])) {
            	$station_id = explode('@', $finalAry[$sta_id]['Feature']['id']);
            	$sta_id_key    = str_pad($station_id[0], 2, '0', STR_PAD_LEFT);
        	
            #} # original close of loop
            	
            	
        	$fullKey = $sta_id  . '@' . $statId ;
            // $setHeight  = 'height:21px';
 			?>
 			<!-- <tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">-->
			<tr style="cursor:move;height:23px;" onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false); " id="<?php
        	echo $sta_id;
			?>" >
			<td>0</td>
			<td></td>
 			<td class="tooltip">
			<div>
				<div class="fl"><span style="cursor:default" >
	        <?php
				if($sta_id_key==$sta_id)
				 {
					$statKey = $sta_id  . '@' . $statId;
					if($sta_id_key==$sta_id){ $shortName = $finalAry[$sta_id]['Feature']['short_name'];}
 				 		$label = $finalAry[$sta_id]['Feature']['label'];
						$link = $finalAry[$sta_id]['Feature']['link'];
					if(strlen($label)> 15) {
						#echo substr($label, 0, 15) . '..';
						echo $html->link(substr($label, 0, 13) . '..', array('controller' => 'groups','action' => 'edit/group_id:' .$link));
					}
					else{
						if($shortName!='CPU'){
							 echo $html->link($label, array('controller' => 'features','action' => 'edit',	"stationkey_id:$statKey&featureType=$shortName"), array('class' => $selected['DN List'] . " fancybox fancybox.ajax"));
						}
						else {
							echo $html->link($label, array('controller' => 'groups','action' => 'edit/group_id:' .$link));
						}
 					}
 				}
				
				//echo "<pre>";
				//print_r($finalAry);
			?>
			</div>
				</div>
			</td>

			<td  class="table-menu" >
	        <?php

			$shortName = "";
			$tool_tipname	=__($shortName.'_desc',true);

			if($sta_id_key==$sta_id){
				$shortName = $finalAry[$sta_id]['Feature']['short_name'];
			}
        	echo $form->input("featurename[$sta_id]", array(
            	'type' => 'hidden',
            	'value' => $shortName
        	));
			//echo $sta_id."$$".$sta_id_key;

			if($sta_id_key==$sta_id){ //echo "<pre>"; print_r($stationArray['Feature']['id']);
				#echo __($shortName, true);
				#$statKey = $sta_id  . '@' . $statId;
				$statKey = '01@' . $statId;
				//echo $html->link($shortName,'');

				/*if($shortName=='AUD'){$locshortName =  $audlang[0]['Transentry']['translation'];}
				if($shortName=='BLF'){$locshortName =  $blflang[0]['Transentry']['translation'];}
				if($shortName=='CNF'){$locshortName =  $cnflang[0]['Transentry']['translation'];}
				if($shortName=='PRK'){$locshortName =  $prklang[0]['Transentry']['translation'];}
				if($shortName=='RAG'){$locshortName =  $raglang[0]['Transentry']['translation'];}
				if($shortName=='CPU'){$locshortName =  $cpulang[0]['Transentry']['translation'];}
				if($shortName=='CXR'){locshortName =  $cxrlang[0]['Transentry']['translation'];}
				if($shortName=='CFUIF'){$locshortName =  $cfuiflang[0]['Transentry']['translation'];}
				if($shortName=='DN_INDIVIDUAL'){$locshortName =  $dnlang[0]['Transentry']['translation'];}
				if($locshortName=="") {$locshortName = $shortName;}*/

				$tooltipname = $shortName . '_desc';
				  if($shortName=='CPU'){
					$locshortName = __('cpuMemberFeature',true);
				}else{
					$locshortName = __($shortName,true);
				}
				

				?>

				<span>
					<span style="margin-left: 10px;"><?php echo substr($locshortName, 0, 35);?> </span><?php //if(strlen($locshortName)>20) { ?>
					<div class="table-popup"  style="z-index: 1;display:none;position: absolute;margin-top:-10px;">
					 <ul style="margin-top:-10px;margin-left:-4px;" >
						<li >
							 <a href="javascript:;" onclick="Tip('<?php echo __($tooltipname) ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
					 	</li>
					 </ul>
					</div>
					 <?php //} ?>
				</span>
				<?php
				}
				?>
			</td>

	        <td nowrap >
	        <?php
			$DNID = "";
			if($sta_id_key==$sta_id){$DNID = $finalAry[$sta_id]['Feature']['primary_value'];}
       		  // $DNID = $stationArray['Feature']['primary_value'];
        	echo $form->input("featurevalue[$sta_id]", array(
            	'type' => 'hidden',
            	'value' => $DNID
        	    ));
        	echo $form->input("featureNewPosition[$sta_id]", array(
            	'type' => 'hidden',
            	'value' => $sta_id
        	    ));
			if($sta_id_key==$sta_id){
        		/* echo $html->link($finalAry[$sta_id]['Feature']['primary_value'], array(
            	'controller' => 'dns',
            	'action' => 'selectdns',
            	"customer_id:$customer_id&type=single&update=$DNID"
        		), array(
            	'class' => $selected['DN List'] . " opencolorbox"
        		)); */
				
				$val=trim($finalAry[$sta_id]['Feature']['primary_value'],",");
				
			  echo 	wordwrap($val,35,"<br>\n",TRUE);
			  }
			?>
	        </td>
	        <!-- <td> <?php #echo  $featureStatus[$finalAry[$sta_id]['Feature']['status']];?></td>-->
			<?php #if(!empty($shortName)){ ?>
			<!--<td class="table-right	 tooltip" style="background: url(<?php echo $this->webroot; ?>/images/assets/icons/16px/045_information_02_cmyk.gif) no-repeat 2px 2px;">
						<div>
							<div class="fl"><span><?php echo $html->link('', '',array('onclick'=>'')) ?></span>
								<p><?php
								$tooltipname = $shortName . '_desc';
								echo __($tooltipname);?></p>
							</div>
						</div>
	          </td>-->
					 <?php #} else { ?>
					 <!--<td class="table-right-ohne" >&nbsp;</td>-->
					 <?php #} ?>

<?php
//echo $sta_id;

 if(($sta_id=='13' || $sta_id=='14')){ ?>
			<td class="table-right-ohne" style="background-color: #ffffff !important; border: none !important;"  id="<?php
        	echo $sta_id;
			?>">
			<?php }else { ?>
			<td class="table-right-ohne" style="background: url(<?php
        	echo $this->webroot;
			?>/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat 3px 5px;border-right: 1px solid #D1D1D1!important; background-color: #ffffff;" onmouseout="this.className='table-right-ohne';" id="<?php
        	echo $sta_id;
			?>tdlast">
			<?php } ?>
			
			<?php if(($sta_id=='13' || $sta_id=='14')){ ?>
<?php } else { ?>
<div class="table-menu">
            <div class="table-menu-popup" style="z-index: 1">
            <ul>

			<?php if(($shortName == 'KEY1_DN') || ($shortName == 'DN_INDIVIDUAL') || ($shortName == 'DN_MADN') || ($shortName == 'DN_MADN_PILOT'))
				{  ?>
					<li class="edit">
					<?php
					echo $html->link(__('dnEdit', true), array(
					'controller' => 'features',
					'action' => 'edit',
					"stationkey_id:$statKey&featureType=$shortName"
					), array(
					'class' => $selected['DN List'] . " fancybox fancybox.ajax"
					))
					?>
					</li>
					<?php  if($info1==0){?>
					<li class="location">
						<?php	echo $html->link(__('Change Location', true), array('controller' => 'locations', 'action' => 'create_location/customer_id:' . $customer_id . '/dns_id:' . $finalAry[$sta_id]['Feature']['primary_value'] . '/location_id:' . $stationkeylocation . '/loc_id:' . $stationkeylocation), array('class' => "fancybox fancybox.ajax")); ?>

					</li>
					<?php if(($shortName == 'MLH') || ($shortName == 'DLH')){ ?>
						<li class="location">
						<?php	echo $html->link(__('Change Location', true), array('controller' => 'locations', 'action' => 'create_location/customer_id:' . $customer_id . '/dns_id:' . $finalAry[$sta_id]['Feature']['primary_value'] . '/location_id:' . $stationkeylocation . '/loc_id:' . $stationkeylocation), array('class' => "fancybox fancybox.ajax")); ?>

					</li>
					<?php } 
					}?>
					<?php

					if (($sta_id_key != 1) && ($shortName == 'DN_INDIVIDUAL'))
					{
						?>
						<li class="last delete">
						<?php
						$featureId = $statKey . '-' . $shortName;
        				#echo $html->link(__('Delete - not working', true), 'javascript:del_dn("' . $DNID . '@' . $sta_id . '")');
        				#echo $html->link(__('Delete - not working', true), 'javascript:del_feature("' . $featureId . '	")');
						/*echo $html->link(__('Delete', true), array(
						'controller' => 'stations',
						'action' => 'major_cfeature_change',
						"$statId&delete_feature=$featureId"
						),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure want to delete this ?');"))
						*/
						?>
						
						<?php																				  
						if($stationDetails[0]['Station']['status'] < 7)
						{
							echo $html->link( __("Delete", true),'javascript:void(null)', array('onmouseover'=>"javascript:InitStation('".$featureId."','major_cfeature_change')", 'escape'=>false,'title'=>'Delete','class'=>"clicker",'custid'=>"$featureId")); 
						}?>
						
						
						</li>


					<?php
					}
					if(($shortName == 'DN_MADN') || ($shortName == 'DN_MADN_PILOT'))
					{
						?>
								<li class="last group">
								<?php
								$featureId = $statKey . '-' . $shortName;

								echo $html->link(__('editGroup', true), array(
								'controller' => 'groups',
								'action' => 'edit/group_id:' .
								$link
								))?>
								</li>
								
								<li class="last delete">
								<?php
								$featureId = $statKey . '-' . $shortName;

								/*echo $html->link(__('MajorDelete', true), array(
								'controller' => 'stations',
								'action' => 'major_cfeature_change',
								"$statId&delete_feature=$featureId"
								),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure want to delete this ?');"))
								*/
								?>
								<?php	
								if($stationDetails[0]['Station']['status'] < 7)
								{																			  
								echo $html->link( __("MajorDelete", true),'javascript:void(null)', array('onmouseover'=>"javascript:InitStation('".$featureId."','major_cfeature_change')", 'escape'=>false,'title'=>'Delete','class'=>"clicker",'custid'=>"$featureId")); 
					            }
								?>
								
								</li>
								
								
								
								<?php
					}
			}
					
				elseif(($shortName == 'CPU'))
				{  ?>
							<li class="last delete">
							<?php
							$featureId = $statKey . '-' . $shortName;

							/*echo $html->link(__('Delete', true), array(
							'controller' => 'stations',
							'action' => 'major_cfeature_change',
							"$statId&delete_feature=$featureId"
							),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure want to delete this ?');"))
							*/
							/*echo $html->link(__('Delete', true), array(
							'controller' => 'stations',
							'action' => 'minor_delete/feature_id:'.
							"$featureId"
							),array('escape'=>false,'title'=>'Delete','onclick'=>"return confirm('Are you sure want to delete this ?');"))
							*/
							?>
							
							<?php		
							if($stationDetails[0]['Station']['status'] < 7)
							{																		  
								echo $html->link( __("Delete", true),'javascript:void(null)', array('onmouseover'=>"javascript:InitStation('".$featureId."','minor_delete')", 'escape'=>false,'title'=>'Delete','class'=>"clicker",'custid'=>"$featureId", 'id'=> 'updateStationId')); 
							}?>
							
							
							
						    </li>
						    <li class="last group">
							<?php
							$featureId = $statKey . '-' . $shortName;

							echo $html->link(__('groupEdit', true), array(
							'controller' => 'groups',
							'action' => 'edit/group_id:'.$link
							))?>
						    </li>
						    <li class="last group">
							<?php
							$featureId = $statKey . '-' . $shortName;
							if($stationDetails[0]['Station']['status'] < 7){
									
							echo $html->link(__('selectGroup', true), array(
							'controller' => 'stations',
							'action' => 'select_cpugroup/' . $statKey
							), array(
							'class' => "fancybox fancybox.ajax"
							)
					
							);}?>
						    </li>
			
							<?php

			}
			elseif(($stationDetails[0]['Station']['status'] < 7) && (in_array($shortName, array('MSB','UCDLG', 'RAG', 'PRK', 'MWT', 'CWT', 'CNF'))))
			{  
									
				?>
						<li class="last delete">
							<?php
							$featureId = $statKey . '-' . $shortName;												  
							echo $html->link( __("Delete", true),'javascript:void(null)', array('onmouseover'=>"javascript:InitStation('".$featureId."','minor_delete')", 'escape'=>false,'title'=>'Delete','class'=>"clicker",'custid'=>"$featureId", 'id'=> 'updateStationId')); 
					       ?>
										
										
						</li>
									 
			<?php
			
			
			}
			else
			{
			?>
				<li class="log">
				<?php	echo $html->link(__('No Options', true), ''	);	?>
				</li>
				<?php
			}
			?>
            </ul>
            </div>
			</div>
<?php } ?>

		</td>
	    <?php
	    
	    } # new end of loop
    } //endfor 1- 14;

	?>
	            	</tr>
				 </tbody>
		</table>
		<!--  END BASE STATION -->
		<!--  Extension 1  -->
		<br>

		
		<!--  End extension 2 -->
		    <div class="result"></div>
	    <?php
    echo $form->end();
    ?>

    <?php
    /* if($stationDetails[0]['Station']['status'] == 5){
    	?>
    <div class="button-right">
    		<?php echo $html->link( __('apply', true),  array('controller'=> 'stations', 'action'=>'apply',$statId),array('onmouseover'=>'javascript:hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
    </div>
    <?php } 
    */?>

	<?php //echo $this->element('pagination/newpaging');
	?>

					<h4 style="display:block;float:left;width: 100%;"><?php echo __('Station History'); ?> <a class="maintopRelatedContentButton" id="maintopContentButton" onclick="return toggleShowHistory();" href="javascript:void(0)" style="float:right;">
					
					<div style="width:20px;" id="pbtn">
					<div id="plus"></div>
					</div>
					<div style="width:20px;" id="mbtn">
					<div id="minus"></div>
					</div>
					</a></h4>
					</div>

			    	<?php
			    	if (isset($showHistory) || ((isset($success)) && $success))
			    	{
			    		?>
			    		<div id="showhistory" class="table-content" style="display:block">
			    		<?php

			    	}
			    	else
			    	{
			    		?>
			    		<div id="showhistory" class="table-content" style="display:none">
			    		<?php
			    	}?>
				    <table class="table-content phonekey" id="logTable" style="<?php  echo $diplayTable;   ?> width: 100%; !important">
				    <thead>
						<tr class="table-top">
							<th class="table-column" align="left"> <?php echo __('Created');?></th>
							<th class="table-column" align="left"> <?php echo __('User');?></th>
							<th class="table-column" align="left"> <?php echo __('log_entry');?></th>
							<!--<th class="table-column" align="left"> <?php echo __('Detail');?></th>-->
							<th  class="table-column"style="width:68px;text-align: left;"><?php __("Status");?></th>

						</tr>

					</thead>
	  			      <tbody>
		        	<?php

					// loop through and display format
					foreach($loginfo as $log):

					?>
	            	<tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">
	                
				   <td style="width:110px;">
                    <?php
                    $formatted_date = date('d.m.Y H:i:s', strtotime($log['Log']['created']));
                    preg_match("/^(.*) (.*)/", $formatted_date, $matches);
                    if ($matches[0]) {
                        #$datetime2line = $matches[1] . '<br>' . $matches[2];
                        echo $matches[1];
                        echo ' ';
                        echo $matches[2];
                    } else {
                        echo $log['Log']['created'];
                    }
                    ?>
                    </td>
	               <!-- <td style="width:50px;">
	                <?php echo $log['Log']['user'] ?>
	           		</td>
	                 <td><?php
	                 $logstring = htmlspecialchars($log['Log']['log_entry']);
	                 echo substr($logstring, 0, 70);
	                 #echo $logstring;
	                 ?>...</td>
	          			<td> <?php echo $html->link(__("details", true), array('controller'=> 'logs', 'action'=>'logdetails',$log['Log']['id']), array('class' => "fancybox fancybox.ajax")); ?></td>
						<td><?php echo $log['Log']['modification_status']?'Success':'Failed'?></td>
						-->
						
						 <td >
        				<?php echo $log['Log']['user'] ?>
                    </td>
                                    
                    <td> <?php echo $html->link($log['Log']['log_entry'], array('controller'=> 'logs', 'action'=>'logdetails',$log['Log']['id']), array('class' => "fancybox fancybox.ajax")); ?></td>
                                    
                                    
                   <td><?php echo __($log['Log']['modification_status']?'Success':'Failed')?></td>

	         	  </tr>
	         		<?php
					endforeach;
					?>
	       	 	</tbody>
				</table>
			 </div>
			 
	</div>


	    <?php
	else:
    	__("No features available in DB");
    	echo '</div>';
	endif;
} # End of key features, station != 6
?>
 </div>
</div>

</div>
</div>



<!--right hand side starts from here-->
<div id="related-content">
        <div class="box start link">
                <a href="http://www.swisscom.ch/grossunternehmen" target="_blank">
                <?php __('Home Swisscom') ?>
                </a>
        </div>
       <div class="box"  id="inf"   >
        	 <h3><?php __('stationEdit') ?></h3>
                 <p>
                  <?php __('stationEdit_blurb') ?>
                 </p>
			<div id="shortcont">
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('fullcont')"  title=""><?php echo __('moreStart') ?></a>
            </div>
            <div style="display:none;" id="fullcont_type"  >
               <p  ><?php echo __('stationEdit_helpText') ?></p>
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('shortcont')"  title=""><?php echo __('moreEnd') ?></a>
			</div>
        </div>


		
		<?php
      /*
		$disp1140 = 'none';
		$disp1120 = 'none';
		$disp11401 = 'none';
		$disp11201 = 'none';
		
		if($stationDetails[0]['Station']['phone_type'] == '1120')
		{
			$disp1120 = 'block'; 
			$disp11201 = 'block'; 
			
		}
		else if($stationDetails[0]['Station']['phone_type'] == '1140')
		{
			$disp1140 = 'block'; 
			$disp11401 = 'block'; 
			
		 }
		
		 */
		 
		 
		 ?>
		<!--<a id="11201_image" style="display:<?php echo $disp11201?>"  href="<?php echo Configure::read('base_url');?>images/1120.png"  class="fancybox fancybox "><img id="1120_image"    src="<?php echo Configure::read('base_url');?>images/1120.png"></a>-->
		
		<div id="rightImgbox" >
	
		<a id="rightSideImage1"   href="<?php echo Configure::read('base_url');?>images/1120.png"  class="fancybox fancybox ">
		<img id="rightSideImage"    src="<?php echo Configure::read('base_url');?>images/1120.png">
		
		</a>
			<span id="rightImageTag" ></span>
			<div style="clear:both"></div>
			 <?php if($userpermission==Configure::read('access_id'))
        {?>
			<div id="internalUserPort" style="margin-top:0px !important">
			
					<?php 
					if($stationDetails[0]['Station']['type']=="ANLG"){     ?>
				 <div style="margin-right: 5px; padding-left:0px;" >	<a     href="<?php echo Configure::read('base_url')."mediatrixes/edit/mediatrix_id:".$mediatrixId;?>" ><?php echo $stationDetails[0]['Station']['port'] ?></a></div>
				 
				 <?php } else{ ?>
				 
				  <div style="margin-right: 5px; padding-left:0px; " >	<?php echo $stationDetails[0]['Station']['port'] ?></div>
				 
				 <?php } ?>
				 
		</div>
      <?php } ?>

<!--INTERNAL USER OPTIONS -->
        <?php if($userpermission==Configure::read('access_id'))
        {?>
                <div class="box info" style="padding-left:0px !important;margin-top: 0px !important;padding-bottom:0px;">
                <h3><?php __("Internal User");?></h3>
                <p><?php __("Customer View: ");?><?php echo $customer_id; ?></p>
                <p><?php echo  $selected_customer; ?></p>
                </div>
				 <div  style="height:83px;margin-top: 1px;" >
				
				 <p><?php __("proNr:");?><?php echo $pr_nr[1]['Location']['pro_nr']; ?></p>
		     </div>
				
	<?php } ?>
	<!-- 
	<div style="font-weight: bold;color: #ac1917;font-size: 17.5px !important;" id="location_name"><?php __("locationOfStation");?><?php echo $pr_nr[1]['Location']['name']; ?></div>
	-->
	<div>
	<span><?php __("locationOfStation");?></span>
	<span id="location_name">
	<?php echo $stationLocation['name']; ?>
		
	</span>
	
	</div>
	
		
	<?php if ($stationDetails[0]['Station']['extensions'] > 0)
		{?>
	   <div  id="expansionImage">
	   
	   	
		<div id="expansionImage1" >
		
		
		
		<a    href="<?php echo Configure::read('base_url');?>images/KEM1_01.png"  class="fancybox fancybox "><img id="expansionImage11"    src="<?php echo Configure::read('base_url');?>images/KEM1_01.png"></a>
		
		<div id="rightImageTagExpn1" ></div>
		
		</div>
		
		
		<?php if ($stationDetails[0]['Station']['extensions'] > 1)
		{?>
		
		<div id="expansionImage2">
		
		<a    href="<?php echo Configure::read('base_url');?>images/KEM2_01.png"  class="fancybox fancybox "><img id="expansionImage12"    src="<?php echo Configure::read('base_url');?>images/KEM2_01.png"></a>
		
		<div id="rightImageTagExpn2" ></div>
		
		</div>
		
		<?php }?>
		
	   </div>
	<?php }?>

		</div>
<!--ight hand side  ends here-->


<?php							  
/*
 * Start Confirmation Overlay Model For Delete
*/	
?>
						  
<div>
				
	<div id="modalPopLite-mask" style="width:100%" class="modalPopLite-mask"></div>
	<div id="modalPopLite-wrapper" style="left: -10000px;z-index: 2;" class="modalPopLite-wrapper">
	<div class="modalPopLite-child popup-wrapper" id="popup-wrapper">
	<div class="black_overlay" style="display: none;"></div>
	    <h4><?php echo __('Confirmation',true); ?>
			<span class='demonstrations1' style="display: block!important;" >           
				<span style="font-size: 18px !important;margin-top: -17px; float: right;"> <a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); return fancyboxclose(); " >X</a>	</span>  
				<span style="font-size: 18px !important;margin-top: -17px; float: right;margin-right: 10px;"><a href="javascript:;"  style="cursor:pointer;margin-top: 5px;" onMouseOver="Tip('<b><?php echo __('confirmDeleteAnalogStation_helpTitel') ?></b><br/><?php echo __('confirmDeleteAnalogStation_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a>	</span>		
			</span>
		  </h4>
	 <span  style="width:230px; height:180px;margin:50px auto;">
	         
			<h6 style="margin-left:0px;" id="confirm1" ><?php echo __('confirmDeleteAnalogStation');?></h6> <br><br>
			<a href="#" id="close-btn"></a>	
			 <span class="button-left" style="margin:2px 230px 11px !important" >
				<?php echo $html->link( __("Cancle", true),'javascript:void(null)',array('id' => 'close-btn'));  ?>
			 </span>
			
			<span  class="button-right" style="margin:-35px 2px 10px !important" >
			<?php
			echo $html->link(__("Ok", true), 'javascript:void(null)', array('onclick'=>'javascript:memberGroupCount("close-btn")','class'=>'clicker','id'=>'clickerId')); 
						
			# echo $html->link(__("Ok", true), 'javascript:void(null)', array('onclick'=>'javascript:stationAud_delete()','class'=>'clicker')); 
			#echo $html->link(__("Ok", true), 'javascript:void(null)', array('onclick'=>'javascript:deleteStationCheck("close-btn4")', 'class'=>'clicker4','id'=>'clickerId4')); 
			?>
				
	      	</span>
		</span>	
	</div>
  </div>
</div>




<input type="hidden" name="stationUID" id="stationUID" class="sid" value="">
<input type="hidden" name="stationDeleteAction" id="stationDeleteAction"  value="">
<input type="hidden" name="stationId" id="stationId"  value="<?php echo $statId; ?>">



<?php 
/**
* 
* @Start delete station  Confirmation Overlay 
* 
*/
?>							
<div>		

	<div id="modalPopLite-mask4" style="width:100%;z-index: 1;"  class="modalPopLite-mask"></div>
	<div id="modalPopLite-wrapper" style="left: -10000px;z-index: 1000; " class="modalPopLite-wrapper">
		<div class="modalPopLite-child" id="popup-wrapper4" >
		<div class="black_overlay" style="display: none;"></div>
		<h4><?php echo __('Confirmation',true); ?>
		<span class='demonstrations1' style="display: block!important; " >           
				<span style="font-size: 18px !important;margin-top: -17px; float: right;"> <a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); return fancyboxclose2(); " >X</a>	</span>  
				<span style="font-size: 18px !important;margin-top: -17px; float: right;margin-right: 10px;"><a href="javascript:;"  style="cursor:pointer;margin-top: 5px;" onMouseOver="Tip('<b><?php echo __('deleteStation_helpTitel') ?></b><br/><?php echo __('deleteStation_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a>	</span>		
			</span>
 </h4>
			<span style="width:388px; height:150px;margin:15px auto;  ">
			<h6><?php 
			
				echo __( wordwrap('confirmDeleteAnalogStation',62,"<br>\n"));
			
			
			//echo __('confirmTodeleteStation');
			
			?></h6> <br>
			
				
			
				<span class="button-left" style="margin:2px 230px 11px !important" >
				
				<?php echo $html->link( __("Cancle", true),'javascript:void(null)',array('id' => 'close-btn4')); ?>
				
				</span>
				<a href="#" id="close-btn4">	</a>
					
				<span  class="button-right" style="margin:-35px 2px 10px !important" >
				
				<?php echo $html->link(__("Ok", true), 'javascript:void(null)', array('onclick'=>'javascript:deleteStationCheck("close-btn4")', 'class'=>'clicker4','id'=>'clickerId4')); ?>
				
				</span>
					
			</span>		
		</div>
			
	</div>

</div>
<?php
/**
* 
* @Start purg station  Confirmation Overlay 
* 
*/
?>							
<div>		

	<div id="modalPopLite-mask5" style="width:100%;z-index: 1;" class="modalPopLite-mask"></div>
	<div id="modalPopLite-wrapper" style="left: -10000px;z-index: 999;" class="modalPopLite-wrapper">
		<div class="modalPopLite-child" id="popup-wrapper5" >
		<div class="black_overlay" style="display: none;"></div>
		<h4><?php echo __('Confirmation',true); ?>
		<span class='demonstrations1' style="display: block!important;" >           
				<span style="font-size: 18px !important;margin-top: -17px; float: right;"> <a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); return fancyboxclose2(); " >X</a>	</span>  
				<span style="font-size: 18px !important;margin-top: -17px; float: right;margin-right: 10px;"><a href="javascript:;"  style="cursor:pointer;margin-top: 5px;" onMouseOver="Tip('<b><?php echo __('purgeStation_helpTitel') ?></b><br/><?php echo __('purgeStation_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a>	</span>		
			</span>
 </h4>
			<span style="width:388px; height:150px;margin:15px auto; white-space: normal !important;  ">
			<h6><?php
			  echo __( wordwrap('confirmTopurgeStation',62,"<br>\n"));
			  //echo __('confirmTopurgeStation');
			
			 
			 ?></h6> <br>
				<span class="button-left" style="margin:2px 230px 11px !important" >
				
				<?php echo $html->link( __("Cancle", true),'javascript:void(null)',array('id' => 'close-btn5')); ?>
				
				</span>
				<a href="#" id="close-btn5">	</a>
					
				<span  class="button-right" style="margin:-35px 2px 10px !important" >
				<?php echo $html->link(__("Ok", true), 'javascript:void(null)', array('onclick'=>'javascript:purgeStation()', 'class'=>'clicker5','id'=>'clickerId5')); ?>
				
				</span>
							
			</span>		
		</div>
			
	</div>

</div>
<?php
/**
* 
* @Start station upload  Confirmation Overlay 
* 
*/
?>							
<div>		

	<div id="modalPopLite-mask6" style="width:100%;z-index: 1;"  class="modalPopLite-mask"></div>
	<div id="modalPopLite-wrapper" style="left: -10000px;z-index: 1000; " class="modalPopLite-wrapper">
		<div class="modalPopLite-child" id="popup-wrapper6" >
		<div class="black_overlay" style="display: none;"></div>
		<h4><?php echo __('Confirmation',true); ?>
		<span class='demonstrations1' style="display: block!important; " >           
				<span style="font-size: 18px !important;margin-top: -17px; float: right;"> <a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); return fancyboxclose2(); " >X</a>	</span>  
				<span style="font-size: 18px !important;margin-top: -17px; float: right;margin-right: 10px;"><a href="javascript:;"  style="cursor:pointer;margin-top: 5px;" onMouseOver="Tip('<b><?php echo __('uploadStation_helpTitel') ?></b><br/><?php echo __('uploadStation_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a>	</span>		
			</span>
 </h4>
			<span style="width:388px; height:150px;margin:15px auto;  ">
			<h6><?php 
			
			echo __( wordwrap('confirmToUploadStation',62,"<br>\n"));
			//echo __('confirmTodeleteStation');
			
			?></h6> <br>
				<span class="button-left" style="margin:2px 230px 11px !important" >
				
				<?php echo $html->link( __("Cancle", true),'javascript:void(null)',array('id' => 'close-btn6')); ?>
				
				</span>
				<a href="#" id="close-btn6">	</a>
					
				<span  class="button-right" style="margin:-35px 2px 10px !important" >
				<?php echo $html->link(__("Ok", true), 'javascript:void(null)', array('onclick'=>'javascript:uploadStation()', 'class'=>'clicker6')); ?>
				
				</span>
							
			</span>		
		</div>
			
	</div>

</div>
<?php
/**
* 
* @Start ChangePassword Confirmation Overlay 
* 
*/
?>							
<div>		

	<div id="modalPopLite-mask" style="width:100%" class="modalPopLite-mask"></div>
	<div id="modalPopLite-wrapper" style="left: -10000px;z-index: 1;" class="modalPopLite-wrapper">
		<div class="modalPopLite-child" id="popup-wrapper2">
		<h4><?php echo __('Confirmation',true); ?>
		<span class='demonstrations1' style="display: block!important;" >           
				<span style="font-size: 18px !important;margin-top: -17px; float: right;"> <a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); return fancyboxclose2(); " >X</a>	</span>  
				<span style="font-size: 18px !important;margin-top: -17px; float: right;margin-right: 10px;"><a href="javascript:;"  style="cursor:pointer;margin-top: 5px;" onMouseOver="Tip('<b><?php echo __('changePassword_helpTitel') ?></b><br/><?php echo __('changePassword_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a>	</span>		
			</span>
 </h4>
			<span style="width:388px; height:150px;margin:15px auto;  ">
			<h6><?php echo __('confirmToChangePassword');?></h6> <br>
				<span class="button-left" style="margin:2px 230px 11px !important" >
				
				<?php echo $html->link( __("Cancle", true),'javascript:void(null)',array('id' => 'close-btn2')); ?>
				
				</span>
				<a href="#" id="close-btn2">	</a>
					
				<span  class="button-right" style="margin:-35px 2px 10px !important" >
				<?php echo $html->link(__("Ok", true), 'javascript:void(null)', array('onclick'=>'javascript:change_password()', 'id' => 'changePassword','class'=>'clicker2')); ?>
				
				</span>
							
			</span>		
		</div>
			
	</div>

</div>

<div class="black_overlay" style="height: auto!important; width: 1366px; display: none;">
        
    </div>