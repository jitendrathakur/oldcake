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
    width: 80px!important;
}
</style>
<script>
$(document).ready(function(){
$('#button').removeAttr("onclick","");
$('#button').attr("onclick","noinfo()");
	
	
});
</script>
<script>
	function noinfo(){
				
		$('#overlay-error .error .message').text("<?php __('no changes entered') ?>");
		$('#overlay-error').removeClass('hide');
	}
</script>
<script>
function submitForm(){
	
 
  
	  $('.black_overlay').css('display','block');
  $.fancybox.showLoading()  ;
    $('.dnForm').attr('action',base_url+'customers/updatecustomer/<?php echo $customerid;
?>');
      $('.dnForm').attr('method','POST');
      $.ajax({
          type: "POST",
          async : false,
          cache: false,
          dataType: 'json',
          url: $('.dnForm').attr('action'),
          data: $('.dnForm').serialize(),
          success: function(result){         
         
          /*if (result == true) {
            alert('dfdf');
            location.reload();
          } else {
            alert('12');
            $(".alert-error").removeClass('hide');
          $(".alert-error").text(result);                 
          }*/
          
          
          }
      });
    location.reload();

    
              //jQuery('#cboxClose').click();
        //location.reload();
}//end submitForm
		
		  function chngbkcolor(obj) {
			  $(document).ready(function() {
				  $('#button').attr("class", "showhighlight_buttonleft");
				  $('#updateStation').removeAttr("class");
				  $('#button').removeAttr("onmouseover");
				  $('#button').removeAttr("onmouseout");
				  $('#updateStation').attr("class", "button-right-hover");
				  $('#button').attr("onclick","submitForm()");
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
	
	//By creating tooltips after DOM load we make sure that referenced elements are available.
	
	
		
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

</script>


<?php 

	echo $form->create('Customer', array(
                                'action' => 'customeredit',
                                'id' => 'customeredit',
                                'class' => 'dnForm',
                                'type' => 'POST',
								'invalidate' => 'invalidate',
								'name'=>'form1'
));
	?>	
	
	<div class="black_overlay" style="height: 100%; width: 100%; display: none;">
				<!--<div id="black_overlay_loading">
				<img alt="" src="../../img/assets/ajax-loader.gif">
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
							__("There was a problem in applying the changes.");
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
			
	<div id="newEdit">
		<?php
			
			echo $form->input('id', array('type'=>'hidden','value'=>$custdata['Customer']['id']));
		 ?>
		<h4><?php echo __('Customer Details') .'&nbsp;'. $custdata['Customer']['name'] .'&nbsp;('.$custdata['Customer']['id'].')'; ?>
	
		  <div class='demonstrations'>
           <div  style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer;" onMouseOver="Tip('<?php echo __('close_window') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" onclick="UnTip(); setTimeout( function() {     
					$('.fancybox-overlay').trigger('click');
					 },5); ">X</a></div>
	        <div style="font-size: 18px !important;"><a href="javascript:;"  style="cursor:pointer" onclick="Tip('<b><?php echo __('customer_details') ?></b><br/><?php echo __('customer_close') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()" >?</a></div>		
 		  </div>
		 </h4>
		<p> <?php echo __(wordwrap('customerEdit_blurb',90,"<br>\n")); ?></p>		
		 
		 
		<div class="form-body">
			<div class="form-box">
  <!--  mgi 14.8.14 
  				<div class="form-left">
					<?php 
					echo '<div class="form-label">'; 
					echo __('Customer Nmae'); 
					echo '</div>';
					echo $custdata['Customer']['name'];
					?>		
				</div>
				<div class="form-right">
					<?php 					
					echo '<div class="form-label">';
					echo __('CNN Id');
					echo '</div>';				
					echo $custdata['Customer']['id'];
					?>		
				</div>
				<div class="form-right">
					<?php 					
					echo '<div class="form-label">';  
					echo __('MOH Id'); 
					echo '</div>';					
					echo $custdata['Customer']['moh_id'];
					?>	
			   </div>
    -->						
	         </div>
			
           <br/>
			<h4><?php echo __('Customer Option');?>			</h4>
				
			
            <div class="form-box">	
			<div class="form-left table-menu">
					<?php 
					echo '<div class="form-label">';
					echo __('customerType');
					echo '</div>';
					?>
					 <div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li>
									<a href="javascript:;" onclick="Tip('<?php echo __('customerType_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									</li>						
									
                    				</ul>
                    			</div>
					<?php
					//echo $custdata['Customer']['type'];
				    echo $form->select('type', $customerTypes,$custdata['Customer']['type'],array('style'=>'width:136px;','onchange'=>'chngbkcolor(this)')); 
					?>	
			     </div>	
				 <div class="form-right table-menu">
					<?php 
					echo '<div class="form-label">';  
					echo __('Leading0'); 
					echo '</div>';
					?>
					<div class="table-menu-popup" style="z-index: 1">
                    	 <ul><li><a href="javascript:;" onclick="Tip('<?php echo __('Leading0_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a></li></ul>
                    </div>
					<?php
					echo	$form->input('leading_zero', array( 'label' => false,'type'=>'checkbox','checked'=>($custdata['Customer']['leading_zero'] == '1' ? TRUE : FALSE), 'value'=> $custdata['Customer']['leading_zero'],'onclick'=>'chngbkcolor(this)')); ?>
			     </div>	    
				<div style="clear: both"></div>
				<div class="form-left table-menu">
					<?php 
					echo '<div class="form-label">';  
					echo __('Customer Group'); 
					echo '</div>';
					?>
					           <div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li >
									<a href="javascript:;" onclick="Tip('<?php echo __('customer_group_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									</li>						
									
                    				</ul>
                    			</div>
             			
					<?php
					
					echo	$form->input('customer_group', array('label' => false,'value'=>$custdata['Customer']['customer_group'], 'type'=>'text', 'onkeyup'=>'chngbkcolor(this)'));?>
					
			     </div>
				   
				<div class="form-right table-menu">
					<?php 
					
					echo '<div class="form-label">';  
					echo __('Presentation group'); 
					echo '</div>';
					?>
					
					  <div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li>
									<a href="javascript:;" onclick="Tip('<?php echo __('Presentation_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									</li>						
									
                    				</ul>
                    			</div>
					
					
					<?php
				
					echo	$form->input('presentation_group', array( 'label' => false,'value'=> $custdata['Customer']['presentation_group'],'onkeyup'=>'chngbkcolor(this)')); ?>
					
			</div>

			<div class="form-box">
				<div class="form-left table-menu">
					<?php 
					echo '<div class="form-label">';  
					echo __('On Demand'); 
					echo '</div>';
					?>
					  <div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li >
									<a href="javascript:;" onclick="Tip('<?php echo __('onDemand_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									</li>					
									
                    				</ul>
                    			</div>
					<?php
				 
					echo	$form->input('onDemand', array('label' => false,'value'=>$custdata['Customer']['onDemand'], 'type'=>'checkbox', 'checked'=>($custdata['Customer']['onDemand'] == '1' ? TRUE : FALSE),'style'=>'width:15px;','onclick'=>'chngbkcolor(this)'));	?>
					
					
					
				</div>
				<div class="form-right table-menu">
					<?php 
					
					echo '<div class="form-label">';  
					echo __('CFRA'); 
					echo '</div>';
					?>
					<div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li >
									<a href="javascript:;" onclick="Tip('<?php echo __('CFRA_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									</li>						
									
                    				</ul>
                    			</div>
					<?php
					
					echo	$form->input('CFRA', array('label' => false,'value'=>$custdata['Customer']['CFRA'], 'type'=>'checkbox', 'checked'=>($custdata['Customer']['CFRA'] == '1' ? TRUE : FALSE),'style'=>'width:15px;','onclick'=>'chngbkcolor(this)'));
					?>		
					
				</div>
			</div>

			<div class="form-box">
				<div class="form-left table-menu">
					<?php 
					echo '<div class="form-label">';  
					echo __('CTI'); 
					
					echo '</div>';
					?>
					<div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li >
									<a href="javascript:;" onclick="Tip('<?php echo __('CTI_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									
									</li>						
									
                    				</ul>
                    			</div>
					<?php
					
					echo	$form->input('CTI', array('label' => false,'value'=>$custdata['Customer']['CTI'], 'type'=>'checkbox', 'checked'=>($custdata['Customer']['CTI'] == '1' ? TRUE : FALSE),'style'=>'width:15px;', 'onclick'=>'chngbkcolor(this)'));
					
					?>		
					
				</div>
				
				
				
				
				
				<div class="form-right table-menu">
					<?php 
					
					echo '<div class="form-label">';  
					echo __('Nsc'); 
					echo '</div>';
					?>
					<div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li >
									<a href="javascript:;" onclick="Tip('<?php echo __('Nsc_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									</li>						
									
                    				</ul>
                    			</div>
					<?php
					
					echo	$form->input('NSC', array('label' => false,'value'=>$custdata['Customer']['NSC'], 'type'=>'checkbox', 'checked'=>($custdata['Customer']['NSC'] == '1' ? TRUE : FALSE),'style'=>'width:15px;','onclick'=>'chngbkcolor(this)'));	
					
					
					?>		
					
				</div>
				
				<div class="form-left table-menu">
					<?php 
					
					echo '<div class="form-label">';  
					echo __('ONB'); 
					echo '</div>';
					?>
					<div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li >
									<a href="javascript:;" onclick="Tip('<?php echo __('ONB_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									</li>						
									
                    				</ul>
                    			</div>
					<?php
					
					echo	$form->input('ONB', array('label' => false,'value'=>$custdata['Customer']['ONB'], 'type'=>'checkbox', 'checked'=>($custdata['Customer']['ONB'] == '1' ? TRUE : FALSE),'style'=>'width:15px;','onclick'=>'chngbkcolor(this)'));	
					
					
					?>		
					
				</div>
	
					<div class="form-right table-menu">
					<?php 
					
					echo '<div class="form-label">';  
					echo __('CD'); 
					echo '</div>';
					?>
					<div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li >
									<a href="javascript:;" onclick="Tip('<?php echo __('cd_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									</li>						
									
                    				</ul>
                    			</div>
					<?php
					
					echo	$form->input('CD', array('label' => false,'value'=>$custdata['Customer']['CD'], 'type'=>'checkbox', 'checked'=>($custdata['Customer']['CD'] == '1' ? TRUE : FALSE),'style'=>'width:15px;','onclick'=>'chngbkcolor(this)'));	
				
					
					?>		
					
				</div>
					<div class="form-left table-menu">
					<?php 
					
					echo '<div class="form-label">';  
					echo __('OC'); 
					echo '</div>';
					?>
					<div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li >
									<a href="javascript:;" onclick="Tip('<?php echo __('oc_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									</li>						
									
                    				</ul>
                    			</div>
					<?php
					
					echo	$form->input('OC', array('label' => false,'value'=>$custdata['Customer']['OC'], 'type'=>'checkbox', 'checked'=>($custdata['Customer']['OC'] == '1' ? TRUE : FALSE),'style'=>'width:15px;','onclick'=>'chngbkcolor(this)'));	
					
					
					?>		
					
				</div>
<div class="form-right table-menu">
					<?php 
					
					echo '<div class="form-label">';  
					echo __('Info1'); 
					echo '</div>';
					?>
					<div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li >
									<a href="javascript:;" onclick="Tip('<?php echo __('Info1_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									</li>						
									
                    				</ul>
                    			</div>
					<?php
					
					
					
					echo	$form->input('Info1', array('label' => false,'value'=>$custdata['Customer']['Info1'], 'type'=>'checkbox', 'checked'=>($custdata['Customer']['Info1'] == '1' ? TRUE : FALSE),'style'=>'width:15px;','onclick'=>'chngbkcolor(this)'));
					
					?>		
					
				</div>
				<div class="form-left table-menu">
					<?php 
					
					echo '<div class="form-label">';  
					echo __('Info2'); 
					echo '</div>';
					?>
					<div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li >
									<a href="javascript:;" onclick="Tip('<?php echo __('Info2_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									</li>						
									
                    				</ul>
                    			</div>
					<?php
					
					echo	$form->input('Info2', array('label' => false,'value'=>$custdata['Customer']['Info2'], 'type'=>'checkbox', 'checked'=>($custdata['Customer']['Info2'] == '1' ? TRUE : FALSE),'style'=>'width:15px;','onclick'=>'chngbkcolor(this)'));
					?>		
					
				</div>
				<div class="form-right table-menu">
					<?php 
					
					echo '<div class="form-label">';  
					echo __('Info3'); 
					echo '</div>';
					?>
					<div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li >
									<a href="javascript:;" onclick="Tip('<?php echo __('Info3_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									</li>						
									
                    				</ul>
                    			</div>
					<?php
					
					echo	$form->input('Info3', array('label' => false,'value'=>$custdata['Customer']['Info3'], 'type'=>'checkbox', 'checked'=>($custdata['Customer']['Info3'] == '1' ? TRUE : FALSE),'style'=>'width:15px;','onclick'=>'chngbkcolor(this)'));
					
					?>		
					
				</div>


	        <div class="form-left table-menu">
					<?php 
					
					echo '<div class="form-label">';  
					echo __('CICM'); 
					echo '</div>';
					?>
					<div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li >
									<a href="javascript:;" onclick="Tip('<?php echo __('cicm_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									</li>						
									
                    				</ul>
                    			</div>
					<?php
					
					echo	$form->input('cicm', array( 'label' => false,'value'=>$custdata['Customer']['cicm'],'onkeyup'=>'chngbkcolor(this)'));
					
					
					?>		
					
				</div>
					<div class="form-right table-menu">
					<?php 
					
					echo '<div class="form-label">';  
					echo __('Free port'); 
					echo '</div>';
					?>
					<div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li >
									<a href="javascript:;" onclick="Tip('<?php echo __('freeports_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									</li>						
									
                    				</ul>
                    			</div>
					<?php
					
					echo	$form->input('freeports', array('label' => false,'value'=>$custdata['Customer']['free_ports'], 'type'=>'text', 'onkeyup'=>'chngbkcolor(this)'));	
					
					
					?>		
					
				</div>
					<div class="form-left table-menu">
					<?php 
					
					echo '<div class="form-label">';  
					echo __('netcgid'); 
					echo '</div>';
					?>
					<div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li >
									<a href="javascript:;" onclick="Tip('<?php echo __('netcgid_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									</li>						
									
                    				</ul>
                    			</div>
					<?php
					
					echo	$form->input('netcgid', array('label' => false,'value'=>$custdata['Customer']['netcgid'], 'type'=>'text','onkeyup'=>'chngbkcolor(this)'));	
					
					
					?>		
					
				</div>
					<div class="form-right table-menu">
					<?php 
					
					echo '<div class="form-label">';  
					echo __('adnumid'); 
					echo '</div>';
					?>
					<div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li >
									<a href="javascript:;" onclick="Tip('<?php echo __('adnumid_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									</li>						
									
                    				</ul>
                    			</div>
					<?php
					
					echo	$form->input('adnumid', array('label' => false,'value'=>$custdata['Customer']['adnumid'], 'type'=>'text','onkeyup'=>'chngbkcolor(this)'));	
					
					
					?>		
					
				</div>
					<div class="form-left table-menu">
					<?php 
					
					echo '<div class="form-label">';  
					echo __('netnameid'); 
					echo '</div>';
					?>
					<div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li >
									<a href="javascript:;" onclick="Tip('<?php echo __('netnameid_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									</li>						
									
                    				</ul>
                    			</div>
					<?php
					
					echo	$form->input('netnameid', array('label' => false,'value'=>$custdata['Customer']['netnameid'], 'type'=>'text', 'onkeyup'=>'chngbkcolor(this)'));	
					
					
					?>		
					
				</div>
				
					<div class="form-right table-menu">
					<?php 
					echo '<div class="form-label">';  
					echo __('BSK ID'); 
					echo '</div>';
					?>
					           <div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li >
									<a href="javascript:;" onclick="Tip('<?php echo __('Bsk_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									</li>						
									
                    				</ul>
                    			</div>
             			
					<?php
					
					echo	$form->input('bsk', array('label' => false,'value'=>$custdata['Customer']['bsk'], 'type'=>'text', 'onkeyup'=>'chngbkcolor(this)'));?>
					
			     </div>				
				<div class="form-left table-menu">
					<?php 
					echo '<div style="float:left !important;">'; 
					echo '<div class="form-label">';  
					echo __('SLA'); 
					echo '</div>';
					?>
					 <div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li >
									<a href="javascript:;" onclick="Tip('<?php echo __('SLA_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									</li>						
									
                    				</ul>
                    			</div>
					<?php
					echo "</div>";
				
					echo	$form->input('SLA', array( 'label' => false,'value'=>$custdata['Customer']['SLA'],'onkeyup'=>'chngbkcolor(this)'));	
					?>	
					
					</div>
					<div class="form-right table-menu">
					<?php 
					echo '<div class="form-label">';  
					echo __('MOH Id'); 
					echo '</div>';					
					
					?>
					           <div class="table-menu-popup" style="z-index: 1">
                    				<ul>									
									<li >
									<a href="javascript:;" onclick="Tip('<?php echo __('Moh_desc') ?>', BALLOON, true, ABOVE, false)" onMouseOut="UnTip()">...</a>
									</li>						
									
                    				</ul>
                    			</div>
								<?php  echo $custdata['Customer']['moh_id']; ?>
			     </div>				
				
			</div>

<br/>
			

		 <fieldset>
                       <fieldset style="display:none;">
                        <input type="hidden" name="_method" value="PUT" />
                        </fieldset>

			 <div class="button-right-disabled" id="updateStation">
            <a id="button" href="javascript:;"  onclick="submitForm();" name="submitForm" value="submitForm" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __("Submit"); ?></a>
                     </div>


           </fieldset>
            </div>          
            </div>
			

   <!--ight hand side  ends here-->


</form>
<h3><span class="alert alert-error overlay-error hide"></span></h3>

