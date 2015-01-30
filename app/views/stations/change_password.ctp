
<link rel="stylesheet" href="//google-code-prettify.googlecode.com/svn/trunk/src/prettify.css" type="text/css"/>
<script type="text/javascript" src="//google-code-prettify.googlecode.com/svn/trunk/src/prettify.js"></script>
<?php echo $javascript->link('/js/validation.js'); ?>
<script type="text/javascript"> 
    $(document).ready(function() { //alert("ret");
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

	$(document).keypress(function(e) {
		if (e.which == 13) {
			$("a#button").trigger('click');
			return false;
			//alert("dfdf");
		}
	});

	validation = {
	    // Specify the validation rules
	    'rules': {                     
	        'StationPassword':{
	            'required': true,
	            'min': '4',
	            'max': '6',	           
	        }  
                              	
	    },                  
	    // Specify the validation error messages
	    'messages': {  
	        'StationPassword': {
	             'required': "<?php __('enterValue')?>",
	             'min': "<?php __('min4Chars')?>",
	             'max': "<?php __('max6Chars')?>",            
	         }
	         
	    },
	};

    function submitForm(){    	
    	  
    	  if (inValidate(validation)) {
    		  
    	    //return false;
    	  } else {
        	  
    		  $('.filtersForm').attr('action',base_url+'stations/change_password/<?php
    				  echo $statId;
    				  ?>');
    				  		$('.black_overlay').css('display','block');
    				  		$('.filtersForm').attr('method','POST');
    				  		$.ajax({
    				  				type: "POST",
    				  				async : false,
    				  				url: $('.filtersForm').attr('action'),
    				  				data: $('.filtersForm').serialize(),
    				  				success: function(data){ 					 
    				  						//jQuery('#fancybox').click();
    				  						location.reload(); 
    				  						//window.reload();					
    				  				}
    				  		});
    				  		jQuery('#cboxClose').click();
    	  }   
    	              //jQuery('#cboxClose').click();
    	        //location.reload();
    	}//end submitForm


	
	
	
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
        		$('#simid').change(function(){
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

		//called when key is pressed in textbox
	    $("input.numeric_check").keypress(function(e) {	
	      if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57) && e.which!=13)
	      { 
	      	if ($(this).closest(".fancybox-overlay").length) {
			    $('.fancybox-overlay #overlay-error .error .message').text("<?php __('digitsOnly') ?>");
			    $('.fancybox-overlay #overlay-error').removeClass('hide');
		    } else {
			    $('#overlay-error .error .message').text(message);
			    $('#overlay-error').removeClass('hide');
		    }        
	        
	        return false;
	      } else {
	      	
	      		//$("input").keydown(function() {
		          inValidate(validation, 'keyup');                    
		        //});		
	      	
	       
	      }
	    });

  	});
    		
});

         function chngbkcolor(obj) {
			  $(document).ready(function() {
				  jQuery('#button').attr("class", "showhighlight_buttonleft");
				  jQuery('#updateStation').removeAttr("class");
				  jQuery('#updateStation').attr("class", "button-right-hover");

			  });
		  }

</script>
 
<div class="black_overlay" style="height: 100%; width: 100%; display: none;">
				<div id="black_overlay_loading">
				<img alt="" src="../../img/assets/ajax-loader.gif">
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
							__("There was a problem in applying the changes.");
					?>
				</div>
			</div>
		</div>
		
	<?php }
		else
		{
			#echo '<br>';
		}
		?>

      

			
<div id="newEdit">
		<div class="form-body">

<?php 

echo $form->create('Station', array(
				'action' => 'change_password',
				'id' => 'Station',
				'class' => 'filtersForm',
				'type' => 'POST',
				'invalidate' => 'invalidate'
));

echo $form->input('Station.id', array('type'=>'hidden','value'=>$stationDetails[0]['Station'])); 
?>
<div class="cb">

 	


<h4 ><?php echo __('passwordChange') . $statId;?>
 <div class='demonstrations'>
           <div  style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick=" setTimeout( function() {     
					$('.fancybox-overlay').trigger('click');
					 },5); UnTip();">X</a></div>
	        <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onclick="Tip('<?php echo __('changePassword_helpTitel') ?></b><br/><?php echo __('changePassword_helpText') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>		
    		
 		</div></h4>
  
        <div class="form-box">
       	 
				<div class="form-left">

						<?php ;
						echo '<div class="form-label">';
						echo __('Password');
						echo '</div>';
						echo $form->input('password', array('type'=>'text','class'=>'numeric_check', 'label' => false,'style'=>'width:100px;','onkeyup'=>'chngbkcolor(this)'));
					
					?>
				</div>
				<div class="form-right">
				<p><?php echo __('password_blurb')?>
				</div>
				<div class="form-left">

						<p></p>
				</div>
				<div class="form-right">
				<div class="button-right-disabled" id="updateStation">

					<a id="button" href="javascript:;" onclick="submitForm()" name="submitForm" value="submitForm" ><?php __("apply");	?></a>
		
     			 </div>  
				</div>
				
		</div>
		    
     
</div>

</div>
</div>
