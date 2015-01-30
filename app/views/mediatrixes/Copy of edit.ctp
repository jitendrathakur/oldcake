<?php
#-----------------------------------------------------------------#
# $Rev:: 22            $:  Revision of last commit                #
#-----------------------------------------------------------------#


if(!empty($mediatrix)){
	echo $form->create(null, array('id' => 'MediatrixEditForm', 'url' => '/mediatrixes/update/'.$mediatrix[0]['Mediatrix']['id'],'accept-charset'=>'ISO-8859-1'));
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
		<h4>Mediatrix Details</h4>
		<div class="form-body">
			<div class="form-box">
				<div class="form-left">
						<?php 
						echo '<div style="width:100px; float: left">' . __('Location', true). '</div>';
						echo $form->select('location_id', $locations,$location_id,array('label'=>false, 'style'=>'width:100px;','onchange'=>"javascript:submi_form('filters');"));
					?>
				</div>
				<div class="form-right">
						<?php 
						echo '<div style="width:100px; float: left">' . __('ipaddress', true). '</div>';
						echo	$form->input('ipaddress', array('label' => false,'value'=>$mediatrix[0]['Mediatrix']['ipaddress'],'style'=>'width:100px;'));	?>		
					
				</div>
				<div class="form-left">
						<?php 
						echo '<div style="width:100px; float: left">' . __('locationDesc', true). '</div>';
						echo	$form->input('location_desc', array('label' => false,'value'=>$mediatrix[0]['Mediatrix']['location_desc'],'style'=>'width:100px;'));	?>		
					
				</div>
				<div class="form-right">
						<?php 
						echo '<div style="width:100px; float: left">' . __('default_gw', true). '</div>';
						echo	$form->input('default_gw', array('label' => false,'value'=>$mediatrix[0]['Mediatrix']['default_gw'],'style'=>'width:100px;'));	?>		
					
				</div>
				<div class="form-left">
						<?php 
						echo '<div style="width:100px; float: left">' . __('locationDesc', true). '</div>';
						echo	$form->input('address', array('label' => false,'value'=>$mediatrix[0]['Location']['address'],'style'=>'width:100px;'));	?>		
					
				</div>
				<div class="form-right">
						<?php 
						echo '<div style="width:100px; float: left">' . __('mask', true). '</div>';
						echo	$form->input('mask', array('label' => false,'value'=>$mediatrix[0]['Mediatrix']['mask'],'style'=>'width:100px;'));	?>		
					
				</div>
			</div>
		</div>
		</div>
		<h4>Port Details Details</h4>	

		<table class="phonekey">
	    	<?php
			echo $this->element('pagination/newpaging');
			?>
	    	<thead>
	        	<tr class="table-top">
	        	<th class="table-column table-left-ohne">&nbsp;</th>
	        	

			<th class="table-column <?php if(in_array('sort:portid',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:portid',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:102px;text-align: left;"><?php echo $paginator->sort(__("portId",true), 'portid', $filter_options);?></th>

			<th class="table-column <?php if(in_array('sort:location_id',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:location_id',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:102px;text-align: left;"><?php echo $paginator->sort(__("Location",true), 'location_id', $filter_options);?></th>
	

			<th class="table-column <?php if(in_array('sort:ipaddress',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:ipaddress',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:102px;text-align: left;"><?php echo $paginator->sort(__("ipaddress",true), 'ipaddress', $filter_options);?></th>

			<th class="table-column <?php if(in_array('sort:mask',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:mask',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:102px;text-align: left;"><?php echo $paginator->sort(__("mask",true), 'mask', $filter_options);?></th>
	
			<th class="table-column <?php if(in_array('sort:default_gw',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:default_gw',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:102px;text-align: left;"><?php echo $paginator->sort(__("default_gw",true), 'default_gw', $filter_options);?></th>
			<th class="table-right-ohne">&nbsp;</th>
			
	            </tr>
	        </thead>
		<?php //echo $this->element('pagination/top'); ?>
	        <tbody>
	        	<?php
				// initialise a counter for striping the table
				$count = 0;
	
				// loop through and display format
				foreach($mediatrix[0]['Port'] as $port):
					// stripes the table by adding a class to every other row
					$class = ( ($count % 2) ? " class='altrow'": '' );
					// increment count
					$count++;
				?>
	            <tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">
	             	<td class="table-left">&nbsp;</td>
	            	<td> 
	            	<?php 
	           			#echo $mediatrix['Mediatrix']['id'];
	           			echo $port['id'];
	           			
	           			?>
	           			</td>
	           			<td>
	           			<?php
	           			#echo $mediatrix['Mediatrix']['id'];
	           			echo $port['id'];
	           			?>
	           			</td>
						<td class="table-content column-width-100" style="width:125px;">
	               		<?php echo $port['id'];
	               		?>
						</td>
	               		<td><?php echo $port['id']; ?></td>
	               		<td><?php echo $port['id']; ?></td>
	               		
	               		
	               		<td class="table-right-ohne">&nbsp;</td>
		    			
	           			<?php 
	            		
	            	endforeach; ?>
	            	</tr>
	        		</tbody>

	    </table>

	   

		
	           
            </div>
            </div>
            <?php 
			}
			?>

<!--right hand side starts from here-->
<div id="related-content">
        <div class="box start link">
        	<a href="http://www.swisscom.ch/grossunternehmen" target="_blank">
		<?php __('Home Swisscom') ?>
        	</a>
        </div>
	<?php 
	#DO NOT Display for Analgoue stations
	if (strtoupper($location['Location']['type'])!='ANLG')
	{ ?>
	
        <div class="box info">
	<h3><?php  __('Key assignment') ?></h3>

	<p>
	<?php __('Click one of the images below to view the key layout of the phone') ?>

	</p>
	<br>
	<ul>
	<li><h3 style="text-align: center"><?php __('E1140') ?></h3></li>
	<li style="text-align: center"><a href="javascript:void(null);"  onclick="javascript:showImage('1140');"  style="color:#11AAFF;"><img src="<?php echo Configure::read('base_url');?>images/1140_small.jpg"></a></li>
	<li><h3 style="text-align: center"><?php __('E1120') ?></h3></li>
	<li  style="text-align: center"><a href="javascript:void(null);"  onclick="javascript:showImage('1120');"  style="color:#11AAFF;"><img src="<?php echo Configure::read('base_url');?>images/1120_small.jpg"></a></li>
	</ul>
	</div>

	<fieldset>
                <fieldset style="display:none;">
                <input type="hidden" name="_method" value="PUT" />
       </fieldset>
	</fieldset>
	
	<?php } # End of ANLG If ?> 

 <!--INTERNAL USER OPTIONS -->
        <?php if($userpermission==Configure::read('access_id'))
        {?>
                <div class="box info">
			<h3><?php __('Internal User') ?></h3>
                	<p>
                	<?php __("Customer view:");  ?>
                	</p>
                	<p><?php echo $selected_customer; ?></p>

                </div>

<!--COmment out upload functionality 
<fieldset>
<div class="block">
<div class="button-left">
<a href="javascript:void(null);"  onclick="javascript:return upload_xml();"  onmouseover="hoverButtonLeft(this)" onmouseout="outButtonLeft(this)">
<?php __("Upload");?>
</a>
</div>
</div>
</fieldset>
-->


	<?php }
	?>
</div>
                <!--ight hand side  ends here-->


</form>
