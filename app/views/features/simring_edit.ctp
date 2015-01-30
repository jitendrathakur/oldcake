<?php
#-----------------------------------------------------------------#
# $Rev:: 22            $:  Revision of last commit                #
#-----------------------------------------------------------------#


if(!empty($features)){
	echo $form->create(null, array('id' => 'featureEditForm', 'url' => '/features/update/'.$features[0]['Feature']['id'],'accept-charset'=>'ISO-8859-1'));
	?>	
	<div class="block top">
	<?php if((isset($inProgress)) && $inProgress){?>
	
		<div class="notification first" style="width: 534px" >
		
			<div class="ok">
				<div class="message">
					IN WORK
				</div>
			</div>
		</div>
		
	<?php } ?>
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
			<fieldset>
                       <fieldset style="display:none;">
                        <input type="hidden" name="_method" value="PUT" />
                        </fieldset>

                        <div class="button-right">
                        <a href="javascript:void(null);"  onclick="javascript:return validate_form();" name="validate" value="validate" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __('Validate') ?></a>
                        </div>
                        <div class="button-left">
                        <a href="javascript:void(null);"  onclick="javascript: history.go(-1);" name="back" value="back" onmouseover="hoverButtonLeft(this)" onmouseout="outButtonLeft(this)"><?php __('Back') ?></a>
                        </div>

           </fieldset>
	<div id="newEdit">
		<h3>This overlay could contain all station features in one dialogue</h3>
		<h4>SIMRING Members Details</h4>
		<div class="form-body">
			<div class="form-box">
				<div class="form-left">
					<?php echo $form->input('member1', array('value'=>$features['SIMRINGMEMBER1']['primary_value'], 'style'=>'width:200px;','onchange'=>"javascript:submi_form('filters');")); ?>			
		
				</div>
				<div class="form-left">
					<?php echo $form->input('member2', array('value'=>$features['SIMRINGMEMBER1']['name'], 'style'=>'width:200px;','onchange'=>"javascript:submi_form('filters');")); ?>			
		
				</div>
			</div>
			<div class="form-box">
				<div class="form-left">
					<?php echo $form->input('member3', array('value'=>$features['SIMRINGMEMBER1']['name'], 'style'=>'width:200px;','onchange'=>"javascript:submi_form('filters');")); ?>			
		
				</div>
				<div class="form-left">
					<?php echo $form->input('member4', array('value'=>$features['SIMRINGMEMBER1']['name'], 'style'=>'width:200px;','onchange'=>"javascript:submi_form('filters');")); ?>			
		
				</div>
			</div>
		</div>
		</div>


	<?php }?>


		
	           
            </div>
            </div>

   <!--ight hand side  ends here-->


</form>
