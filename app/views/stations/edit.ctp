


<?php
#-----------------------------------------------------------------#
# $Rev:: 22            $:  Revision of last commit                #
#-----------------------------------------------------------------#

if(!empty($stationinfo)){
	echo $form->create(null, array('id' => 'StationEditForm', 'url' => '/stations/update/'.$stationinfo[0]['Station']['id'],'accept-charset'=>'ISO-8859-1'));
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
			<!--  <fieldset>
                       <fieldset style="display:none;">
                        <input type="hidden" name="_method" value="PUT" />
                        </fieldset>

                        <div class="button-right">
                        <a href="javascript:void(null);"  onclick="javascript:return validate_form();" name="validate" value="validate" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __('Validate') ?></a>
                        </div>
                        <div class="button-left">
                        <a href="javascript:void(null);"  onclick="javascript: history.go(-1);" name="back" value="back" onmouseover="hoverButtonLeft(this)" onmouseout="outButtonLeft(this)"><?php __('Back') ?></a>
                        </div>
						<div class="button-right">
						<?php echo $html->link( __('reset', true),  array('controller'=> 'stations', 'action'=>'edit',$stationinfo[0]['Station']['id']),array('onmouseover'=>'javascript:hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
                        </div>
                        <div class="button-right">
						<?php echo $html->link( __('Major Change', true),  array('controller'=> 'stations', 'action'=>'design',$stationinfo[0]['Station']['id']),array('onmouseover'=>'javascript:hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
                        </div>
                        <div class="button-right">
						<?php echo $html->link( __('resetFeatures', true),  array('controller'=> 'stations', 'action'=>'resetFeature',$stationinfo[0]['Station']['id']),array('onmouseover'=>'javascript:hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
                        </div>

           </fieldset>
           -->
			<!-- END CBM -->
			<input type="hidden" value="" id="hid_blf"/>	
	<div id="myTable" class="phonekey table-content">
		<fieldset>

			<fieldset>
                        	<fieldset style="display:none;">
                        		<input type="hidden" name="_method" value="PUT" />
                        	</fieldset>
                        		
					<!-- CBM
                        		<div class="button-right">
                        			<a href="javascript:void(null);"  onclick="javascript:return validate_form();" name="validate" value="validate" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"> <?php __('Validate') ?></a>
                        		</div>
					<div class="button-left">
						<?php echo $html->link( __('reset', true),  array('controller'=> 'stations', 'action'=>'edit',$location['Station']['id']),array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);')); ?>
                                        </div>
					-->

                        </fieldset>

			<!--Start of station attributes section -->
			<input type="hidden" name="stationname" value="<?php echo $stationinfo[0]['Station']['id']?>" id="stationname" />
			<input type="hidden" name="stationport" value="<?php echo $stationinfo[0]['Station']['port']?>" id="stationport" />
			<input type="hidden" id="show_main_val" value="0"  />
			<!--<TABLE class="phone" style="width:547px;"> -->
			<TABLE class="phone" > 
				<tr>
					<td class="table-left" style="width:13px;">&nbsp;</td>
					<td style="width:141px;">
						<h3 style="color: #001155;font-size: 13px"><?php __("Stations"); echo " " . $stationinfo[0]['Station']['id']?></h3>
						<?php 
						if($userpermission==Configure::read('access_id'))
						{
							echo $html->link( __('Configuration Logs', true),  array('controller'=> 'logs', 'action'=>'viewlog', 'affected_obj:' . $stationinfo[0]['Station']['id']));
						}?>
					</td>

					<TD colspan=2" style="padding: 0px; vertical-align: bottom">
						<?php $simring	=	explode(',',$location['Station']['SIMRING']);?>
						<!--<div  class="fl show" style="width:480px; id="show_main">-->
						<table style="margin: 0px;">
						<thead>
        					<tr class="table-top">
            					<th class="table-column"  style="height: 28px; text-align:left; width:174px; padding: 2px; border-top: none; border-left: none"><?php __('Feature') ?></th>
            					<th class="table-column"  style="height: 28px; text-align:left;  width:176px; padding: 2px; border-top: none; border-right: none"><?php __('feature values') ?></th>
							</tr>
						</thead>

						
						<tr>
						
	
						<td class="sublist-align wid-217px tooltip">
							<div  style="width:180px;">
								<div class="fl" style="width:176px;"><span style="cursor:default" ><?php __('Port') ?></span>
								<p><?php __('Port_desc') ?></p>
								</div>
							</div>
						</td>
						<td style="width:180px;border-right: none"><?php echo $location['Station']['port'];?></td>
						<!-- <td style="width:180px; border-right: none"></td> -->
						</tr>
						<tr>
						
	
						<td class="sublist-align wid-217px tooltip">
							<div  style="width:180px;">
								<div class="fl" style="width:176px;"><span style="cursor:default" ><?php __("phone_type") ?></span>
								<p><?php __('phone_type_desc') ?></p>
								</div>
							</div>
						</td>
						<td style="width:180px;border-right: none"><?php echo $location['Station']['phone_type'];?></td>
						<!-- <td style="width:180px; border-right: none"></td> -->
						</tr>
						<tr>

					
						<!--CBM MOVED -->
						<input type="hidden"  value="<?php echo strtoupper($location['Station']['type'])?>" id="password_type" />
	
						<?php
						 if (($location['Station']['password'] != '') && ($location['Station']['type'] != 'ANLG'))
						#if ($location['Station']['password'] != '')
						{?>
	
						<td class="sublist-align wid-217px tooltip" style="border:none">
						<div  style="width:180px;">
							<div class="fl" style="width:180px;"><span style="cursor:default" ><?php __('Password') ?></span>
							 	<p><?php __('Password_desc') ?></p>
							</div>
						</div>
						<!-- <input type="hidden"  value="<?php echo strtoupper($location['Station']['type'])?>" id="password_type" /> -->
						</td>
						<td style="width:176px; border-right: none;">
							<div class="fl" style="width:176px;">
							<input style="margin-top:3px;margin-bottom:3px;"  id="password"  class="numeric_check"  type="password"  size="13" <?php echo (strtoupper($location['Station']['type'])!='ANLG') ? 'value="'.$location['Station']['password'].'" style="width:168px;"':'readonly  style="border:1px solid white" '?> name="password" onfocus="clearMe(this)" />
							</div>
						</td>
						</tr>
						<tr>

						<?php }else{ #To create a row if pasword not set.?>
						 <td class="sublist-align wid-217px" style="border:none">
                                                <div  style="width:180px;">
						&nbsp;
                                                </div>
                                                </td>
                                                <td style="width:176px; border-right: none; border-bottom: none;">
                                                        <div class="fl" style="width:176px;">
							&nbsp;
                                                        </div>
                                                </td>
                                                </tr>
                                                <tr>
	


						<?php }
						if ($location['Station']['CFRA'] == 1)
						{?>
	
						<td class="sublist-align wid-217px tooltip">
							<div  style="width:180px;">
								<div class="fl" style="width:176px;"><span style="cursor:default" ><?php __('CFRA') ?></span>
								<p><?php __('CFRA_desc') ?></p>
								</div>
							</div>
						</td>
						<!-- <td style="width:180px; border: 1px;"><?php __('enabled') ?></td>-->
						<td style="width:180px; border-right: none"></td>
						</tr>
						<tr>

						<?php }
						if ($location['Station']['CTI'] == 1)
						{?>
	
						<td class="sublist-align wid-217px tooltip">
							<div  style="width:180px;">
								<div class="fl" style="width:176px;"><span style="cursor:default" ><?php __('CTI') ?></span>
								<p><?php __('CTI_desc') ?></p>
								</div>
							</div>
						</td>
						<!-- <td style="width:180px; border: 1px;"><?php __('enabled') ?></td>-->
						<td style="width:180px; border-right: none"></td>
						</tr>
						<tr>

						<?php }
						if ($location['Station']['COMBOX'] == 1)
						{?>
	
						<td class="wid-217px tooltip" style="border-top:1px solid #CCCCCC; border-left: none;">
							<div  style="width:180px;">
								<div class="fl" style="width:176px;"><span style="cursor:default"  ><?php __('COMBOX') ?></span><p><?php __('COMBOX_desc') ?></p>
								</div>
							</div>
						</td>
						<!-- <td style="width:180px; border: 1px;"><?php __('enabled') ?></td>-->
						<td style="width:180px; border-right: none"></td>
						</tr>
						<tr>

						<?php }
						if ($location['Station']['CWT'] == 1 )
						{?>
	
						<td class="wid-217px tooltip" style="border-top:1px solid #CCCCCC; border-left: none;">
							<div  style="width:180px;">
								<div class="fl" style="width:176px;"><span style="cursor:default" ><?php __('CWT') ?></span><p><?php __('CWT_desc') ?></p>
								</div>
							</div>
						</td>
						<!-- <td style="width:180px; border: 1px;"><?php __('enabled') ?></td>-->
						<td style="width:180px;border-right: none"></td>
						</tr>
						<tr>

						<?php }
						if ($location['Station']['SIMRING'] != '')
						{?>
	
						<td class="wid-217px tooltip"  style="border-top:1px solid #CCCCCC; border-left: none;">
						<div  style="width:180px;">
							<div class="fl" style="width:176px;"><span style="cursor:default"  ><?php __('SIMRING') ?></span><p><?php __('SIMRING_desc') ?></p>
							</div>
						</div>
						</td>
						<!-- <td style="width:180px; border: 0px;"><span><wrap><?php echo $location['Station']['SIMRING']?></wrap></span></td> -->
						<td style="width:180px; border-right: none"><?php echo $location['Station']['SIMRING']?></td>
						<tr>

						<?php }
						if ($location['Station']['extensions'] != 0)
						{?>
	
						<td class="wid-217px tooltip" style="border-bottom:none; border-left: none;">
						<div  style="width:180px;">
							<div class="fl" style="width:176px;"><span style="cursor:default"><?php __('Expansions') ?></span><p><?php __('Expansion_desc') ?></p></div>
						</div>
						&nbsp;
						</td>
						<td style="width:180px; border-right: none; border-bottom: none"><?php echo $location['Station']['extensions'] ?></td>
						</tr>
						<tr>

						<?php }
						if ($location['Station']['desc'] != '')
						{?>
	
						<td class="wid-217px tooltip" style="border-bottom:none; border-left: none;">
						<div  style="width:180px;">
							<div class="fl" style="width:176px;"><span style="cursor:default"><?php __('IDENTIFIED_CNN') ?></span><p><?php __('IDENTIFIED_CNN_desc') ?></p></div>
						</div>
						&nbsp;
						</td>
						<td style="width:180px; border-right: none; border-bottom: none"><?php echo $location['Station']['desc'] ?></td>
						</tr>
						<tr>

						<?php }?>
						</tr>
						</table>
					</td>
					<td class="table-right-ohne" style="width: 10px">&nbsp;</td> 

				</tr>
				
			</table>
		</fieldset>
		<?php //echo $stationinfo[0]['Station']['extensions']?>
		<fieldset>
			<div >
				<div style="float:left;text-align:right;width:505px;">
	           		 <?php __("Basic/Detailed View")?>
	            </div>
	            <div style="float:right">
		            <a href="javascript:void(null);" onclick="javascript:all_show_hide('show');">
		                <div style="float:right" id="btn_all" class="fl expandButton">&nbsp;
		                </div>
		            </a>
	            </div>
	           
            </div>
			
			<TABLE class="phone"  style="margin-bottom:0px;">
				<thead>
					<tr class="table-top">
						<th class="table-column table-left-ohne"><a href="#">&nbsp;</a></th>
						<th class="table-column"><span style="width:27px;text-align:left"><?php __("Key")?></span></th>
						<th class="table-column"><span style="width:110px;text-align:left"><?php __("Label")?></span></th>
						<th class="table-column"><span style="width:180px;text-align:left"><?php __("Feature")?></span></th>
						<th class="table-column" ><span style="width:176px; text-align:left"><?php __('feature values')?></span></th>
						<th class="table-right-ohne" style="width:100px;">&nbsp;&nbsp;&nbsp;&nbsp;</th>
					</tr>
				</thead>
				<?php $j=0; $l=0;
				foreach($stationinfo as $data){
					$fet_val='';$fet_prival='';$fet_otherval='';$fet_cs2kfeatures='';$fet_primvalue='';
					
					foreach($data['Feature'] as $Chk_feat){
		             
	        			if(isset($Chk_feat['short_name']) && isset($Chk_feat['primary_value']) && (strtoupper($Chk_feat['short_name'])=='DN' || strtoupper($Chk_feat['short_name'])=='MADN'))
	        			{	
							$fet_val	=	$Chk_feat['short_name'];
							$fet_prival	=	$Chk_feat['primary_value'];
	    				}
	    				elseif(isset($Chk_feat['short_name']) && $Chk_feat['short_name'] && empty($Chk_feat['primary_value']) &&  strtoupper($Chk_feat['short_name'])!='AUD' && strtoupper($Chk_feat['short_name'])!='BLF' ){
		           			$fet_otherval	=	$Chk_feat['short_name'];
		           			$fet_cs2kfeatures	=	$Chk_feat['cs2kfeatures'];
	    				}elseif(isset($Chk_feat['short_name']) && $Chk_feat['short_name'] && empty($Chk_feat['primary_value']) &&  strtoupper($Chk_feat['short_name'])!='AUD' && strtoupper($Chk_feat['short_name'])!='BLF' ){
		           			$fet_otherval	=	$Chk_feat['short_name'];
		           			$fet_cs2kfeatures	=	$Chk_feat['cs2kfeatures'];
	    				}
		            }

				#-----------------------FIRST 14 KEYS-------------------------------------
		            
	           		if($data['Stationkey']['keynumber']<=14){
	           			
	           	?>
						<TR>
							<td class="table-left">&nbsp;</td>
							<td>
								<!--<div class="buttons"> <p><?php echo $data['Stationkey']['keynumber']?></p> </div>-->
								<p style="margin: 2px 0px 0px 4px;"><?php echo $data['Stationkey']['keynumber']?></p>
							</td>
							
							
							<td style="vertical-align: top; padding: 3px;">
								<?php 
									$text_other	=0;$isfeature=0;$short_nam=0;$more=1;$limit=1;$set_val=0;
									foreach($data['Feature'] as $features){
										
										if($features['short_name']=='BLF' || $features['short_name']=='AUD'){?>
											<div id="div1_input_val_<?php echo $j ?>">
												<div class="fl">
													<div class="input text">
														<input class="space_check"  AUTOCOMPLETE=OFF  id="input_label_<?php echo $j ?>"  name="dataLabel[<?php echo $features['id']?>]" type="text" value="<?php echo $features['label']?>" size="13">
														
													</div>
												</div>
											</div>
										<?php $text_other=1;
										}else{
											
											/*if(isset($fet_otherval) && $more){?>
		                   	 						<span style="cursor:pointer" title="<?php echo ($fet_cs2kfeatures) ? $fet_cs2kfeatures:'';?>"> <?php echo  $fet_otherval ;?></span>
                   	 						<?php $more=0; }$text_other=1;*/
											
												if($limit){
													if($features['label']) $limit=0;?>
												<div class="fl">
													<?php 
														#echo isset($features['label'])?substr($features['label'],0,10):''."\n";
														echo isset($features['label'])?$features['label']:''."\n";
													?>
												</div>
											<?php }
											
											if($fet_val=='DN' || $fet_val=='MADN')
		                    					$set_val=1;
		                    				if(!$set_val){
		                    					if($features['short_name']){
		                   							$short_nam=1;
		                    					}
		                    				}
										}
								}
								if(!$set_val && !$short_nam && !$text_other){?>
								<div id="div1_input_val_<?php echo $j ?>" style="display:none;">
									<div class="fl"><div class="input text "><input style="width: 100px; " class="space_check"  AUTOCOMPLETE=OFF  id="input_label_<?php echo $j ?>"  type="text" name="<?php if($isfeature) { ?>data_label[<?php echo $feat['id']?>]<?php } elseif(!$short_nam) { echo 'data_label['.$data['Stationkey']['id'].']['.++$l.']'; }?>" size="13">
										
									</div></div>
								</div>
								<?php }?>
							</td>
							<TD <?php echo ($fet_val=='DN' || $fet_val=='MADN')?'colspan="2"':''?> style="padding-left:0px; padding-top:0px; vertical-align:top;">
							 <?php
		                    		$set_val	=0;
									$set_text	=0;
		                    		if($fet_val=='DN' || $fet_val=='MADN'){
		                    			$set_val=1;
		                    			$set_text=1;$val=array();
	                    				foreach($data['Feature'] as $features){
											if($features['short_name']=='DISPLAYNAME'){
													$val[0]['short_name']	='DISPLAYNAME';
													$val[0]['primary_value']=$features['primary_value'];
													$val[0]['id']=$features['id'];
												}
												if($features['short_name']=='LANG'){
													$val[1]['short_name']	='LANG';
													$val[1]['primary_value']=$features['primary_value'];
													$val[1]['id']=$features['id'];
												}
												if($features['short_name']=='BARRINGSET'){
													$val[2]['short_name']	='BARRINGSET';
													$val[2]['primary_value']=$features['primary_value'];
													$val[2]['id']=$features['id'];
												}
												if($features['short_name']=='CFB'){
													$val[3]['short_name']	='CFB';
													$val[3]['primary_value']=$features['primary_value'];
													$val[3]['id']=$features['id'];
												}
												if($features['short_name']=='CFBStatus'){
													$val[4]['short_name']	='CFBStatus';
													$val[4]['primary_value']=$features['primary_value'];
													$val[4]['id']=$features['id'];
												}
												if($features['short_name']=='CFU'){
													$val[5]['short_name']	='CFU';
													$val[5]['primary_value']=$features['primary_value'];
													$val[5]['id']=$features['id'];
												}
												if($features['short_name']=='CFUStatus'){
													$val[6]['short_name']	='CFUStatus';
													$val[6]['primary_value']=$features['primary_value'];
													$val[6]['id']=$features['id'];
												}
												if($features['short_name']=='CFNA'){
													$val[7]['short_name']	='CFNA';
													$val[7]['primary_value']=$features['primary_value'];
													$val[7]['id']=$features['id'];
												}
												if($features['short_name']=='CFNAStatus'){
													$val[8]['short_name']	='CFNAStatus';
													$val[8]['primary_value']=$features['primary_value'];
													$val[8]['id']=$features['id'];
												}
												if($features['short_name']=='CFDVT'){
													$val[9]['short_name']	='CFDVT';
													$val[9]['primary_value']=$features['primary_value'];
													$val[9]['id']=$features['id'];
												}
												if($features['short_name']=='CFK'){
													$val[10]['short_name']	='CFK';
													$val[10]['primary_value']=$features['primary_value'];
													$val[10]['id']=$features['id'];
												}
												if($features['short_name']=='CFKStatus'){
													$val[11]['short_name']	='CFKStatus';
													$val[11]['primary_value']=$features['primary_value'];
													$val[11]['id']=$features['id'];
												}
											}
											if(!isset($val[0]['short_name'])){
													$val[0]['short_name']	='DISPLAYNAME';
													$val[0]['primary_value']='';
													$val[0]['id']='';
											}if(!isset($val[1]['short_name'])){
													$val[1]['short_name']	='DISPLAYNAME';
													$val[1]['primary_value']='';
													$val[1]['id']='';
											}if(!isset($val[2]['short_name'])){
													$val[2]['short_name']	='DISPLAYNAME';
													$val[2]['primary_value']='';
													$val[2]['id']='';
											}
											?>
		                    	<div>
						<!-CBMMOD margin-bottom: 0px -->
			                    	<table border="0" cellpadding="0" cellspacing="0"  class="pad0-margin0" style="margin-bottom: 0px">
			                    		<tr style="height:25px;">
			                    		<!--CBM<tr>-->

								<td class="sublist-align wid-217px tooltip">
									<span  style="cursor:default" ><?php __('DISPLAYNAME') ?></span>
									<p><?php __('DISPLAYNAME_desc') ?></p>
								</td>
										
								<td  style="border-right:none;border-top:none;">
									 <?php if($val[0]['short_name']=='DISPLAYNAME' && !is_null($val[0]['primary_value'])){?>
											
									<?php if($val[0]['id']){?>
										<input  style="width: 168px;" type="text" size="13" class="display space_check"  id="data_<?php echo $j?>" name="data[<?php echo $val[0]['id']?>]" AUTOCOMPLETE=OFF value="<?php echo $val[0]['primary_value']?>">
									<?php }else {?><input type="text" style="border:none" readonly><?php }?>
										
										<input type="hidden" id="keydata_<?php echo $j?>" value="<?php echo $data['Stationkey']['id'];?>"/>
									<?php }?>
								</td>
											
											
							</tr>	
							<!-- CBMMOD height -->	
							<tr style="height:25px;">
							<!--CBM<tr>-->
								<td class="sublist-align wid-217px tooltip">
									<span   style="cursor:default"><?php __('LANGUAGE') ?></span>
									<p><?php __('LANGUAGE_desc') ?></p>
								</td>
								<td style="border-right:none;border-top:none;" class="tooltip">
								<?php if($val[1]['short_name']=='LANG'){?>
												
								<?php if($val[1]['id']){?>
								<select  style="width:174px;" id="data[<?php echo $val[1]['id']?>]" name="data[<?php echo $val[1]['id']?>]">
					       				<option value="FR" <?php if(strtoupper($val[1]['primary_value'])=='FR'){?> selected="selected"<?php }?> >FR</option>
					             			<option value="DE" <?php if(strtoupper($val[1]['primary_value'])=='DE'){?> selected="selected"<?php }?> >DE</option>
							                <option value="IT" <?php if(strtoupper($val[1]['primary_value'])=='IT'){?> selected="selected"<?php }?> >IT</option>
							        </select>
							         <p><?php __('LANG_help') ?></p>
						               	 <?php }?>
					               				 
												<?php }?>
											</td>
										</tr>
									
										<tr style="height:25px;">
										<!--<tr>-->
											<td class="sublist-align wid-217px tooltip">
												<span   style="cursor:default;float:left;margin-top:3px;" ><?php __('BARRINGSET') ?></span><p><?php __('BARRINGSET_desc') ?></p>
											</td>
											
											<td style="border-right:none;border-top:none;" class="tooltip">
											<?php
											if($val[2]['short_name']=='BARRINGSET'){
												?>
													
														<?php if($val[2]['id']){?>
															<select style="width:174px;" id="data[<?php echo $val[2]['id']?>]" name="data[<?php echo $val[2]['id']?>]">
															<?php for($i=1;$i<=5;$i++){
																	$barSetId = 'set' . $i;
															?>
																<!--CBM <option value="Set<?php echo $i?>" <?php if($val[2]['primary_value']=='Set'.$i){?> selected="selected"<?php }?>>Set <?php echo  $i?></option> -->
																<option value="Set<?php echo $i?>" <?php if($val[2]['primary_value']=='Set'.$i){?> selected="selected"<?php }?>><?__("$barSetId") ?></option>
								               				<?php }?>
															 </select>
															 
																 <p><?php __('BARRINGSET_help') ?></p>
															
														 <?php }?>
													
											<?php }?>
											</td>
										</tr>
									<?php
									#Start of CFB
									if (isset($val[3]['primary_value']))
									{
									?>
										<tr style="height:25px;">
			                    		<!--CBM<tr>-->

										<td class="sublist-align wid-217px tooltip">
										<span  style="cursor:default;" ><?php __('CFB'); ?></span>
										<p><?php __('CFB_desc'); ?></p>
										</td>
										
										<td  style="border-right:none;border-top:none;">
										<input  style="width: 98px;" type="text" size="13" id="data_<?php echo $j;?>" name="data[<?php echo $val[3]['id'];?>]" AUTOCOMPLETE=OFF value="<?php echo $val[3]['primary_value'];?>">
										<!-- Set teh default 0 for the checkbox-->
										
										<select style="width:70px" id="data_<?php echo $j;?>" name="data[<?php echo $val[4]['id'];?>]">
											<option value="I">INACTIVE</option>
											<option value="A" <?php if($val[4]['primary_value']=='A'){echo "selected";}?>>ACTIVE</option>
										</select> 
										
									    <input type="hidden" id="keydata_<?php echo $j;?>" value="<?php echo $data['Stationkey']['id'];?>"/>
										</td>	
										</tr>
										<?php
									} # End of CFB
									#Start of CFU
									if (isset($val[5]['primary_value']))
									{
									?>
										<tr style="height:25px;">
			                    		<!--CBM<tr>-->

										<td class="sublist-align wid-217px tooltip">
										<span  style="cursor:default;" ><?php __('CFU'); ?></span>
										<p><?php __('CFU_desc'); ?></p>
										</td>
										
										<td  style="border-right:none;border-top:none;">
										<input  style="width: 98px;" type="text" size="13" id="data_<?php echo $j;?>" name="data[<?php echo $val[5]['id'];?>]" AUTOCOMPLETE=OFF value="<?php echo $val[5]['primary_value'];?>">
										<!-- Set teh default 0 for the checkbox-->
										
										<select style="width:70px" id="data_<?php echo $j;?>" name="data[<?php echo $val[6]['id'];?>]">
											<option value="I">INACTIVE</option>
											<option value="A" <?php if($val[6]['primary_value']=='A'){echo "selected";}?>>ACTIVE</option>
										</select> 
										
									    <input type="hidden" id="keydata_<?php echo $j;?>" value="<?php echo $data['Stationkey']['id'];?>"/>
										</td>	
										</tr>
										<?php
									} # End of CFU
									if (isset($val[10]['primary_value']))
									{
									?>
										<tr style="height:25px;">
			                    		<!--CBM<tr>-->

										<td class="sublist-align wid-217px tooltip">
										<span  style="cursor:default;" ><?php __('CFK'); ?></span>
										<p><?php __('CFK_desc'); ?></p>
										</td>
										
										<td  style="border-right:none;border-top:none;">
										<input  style="width: 98px;" type="text" size="13" id="data_<?php echo $j;?>" name="data[<?php echo $val[10]['id'];?>]" AUTOCOMPLETE=OFF value="<?php echo $val[10]['primary_value'];?>">
										<!-- Set teh default 0 for the checkbox-->
										
										<select style="width:70px" id="data_<?php echo $j;?>" name="data[<?php echo $val[11]['id'];?>]">
											<option value="I">INACTIVE</option>
											<option value="A" <?php if($val[11]['primary_value']=='A'){echo "selected";}?>>ACTIVE</option>
										</select> 
										
									    <input type="hidden" id="keydata_<?php echo $j;?>" value="<?php echo $data['Stationkey']['id'];?>"/>
										</td>	
										</tr>
										<?php
									} # End of CFU
									#Start of CFNA
									if (isset($val[7]['primary_value']))
									{
									?>
										<tr style="height:25px;">
			                    		<!--CBM<tr>-->

										<td class="sublist-align wid-217px tooltip" style="border-bottom:none;">
										<span  style="cursor:default;" ><?php __('CFNA'); ?></span>
										<p><?php __('CFNA_desc'); ?></p>
										</td>
										
										<td  style="border-right:none;border-top:none;border-bottom:none;">
										<input  style="width: 98px;" type="text" size="13" id="data_<?php echo $j;?>" name="data[<?php echo $val[7]['id'];?>]" AUTOCOMPLETE=OFF value="<?php echo $val[7]['primary_value'];?>">
										<!-- Set teh default 0 for the checkbox-->
										
										<select style="width:70px" id="data_<?php echo $j;?>" name="data[<?php echo $val[8]['id'];?>]">
											<option value="I">INACTIVE</option>
											<option value="A" <?php if($val[8]['primary_value']=='A'){echo "selected";}?>>ACTIVE</option>
										</select> 
										
									    <input type="hidden" id="keydata_<?php echo $j;?>" value="<?php echo $data['Stationkey']['id'];?>"/>
										</td>	
										</tr>
										<?php
									} # End of CFU
									#Start of CFDVT
									if (isset($val[9]['primary_value']))
									{
									?>
										<tr style="height:25px;">
			                    		<!--CBM<tr>-->

										<td class="sublist-align wid-217px tooltip" style="border-bottom:none;">
										<span  style="cursor:default;" ><?php __('CFDVT'); ?></span>
										<p><?php __('CFDVT_desc'); ?></p>
										</td>
										
										<td  style="border-right:none;border-top:none;border-bottom:none;">
										<input  style="width: 98px;" type="text" size="13" id="data_<?php echo $j;?>" name="data[<?php echo $val[9]['id'];?>]" AUTOCOMPLETE=OFF value="<?php echo $val[9]['primary_value'];?>">
										<!-- Set teh default 0 for the checkbox-->
																			
									    <input type="hidden" id="keydata_<?php echo $j;?>" value="<?php echo $data['Stationkey']['id'];?>"/>
										</td>	
										</tr>
										<?php
									} # End of CFU
									?>	
			                    	</table>
	                    		</div>
		                	<?php }
		                		if(!$set_val){
		                			$aud_exi=0;
		                			$blf_exi=0;
		                			$isfeature=0;
		                			$text_other=0;
		                			$short_nam=0;
		                		      foreach($data['Feature'] as $featu){ 
		                		      	
		                		      	if($featu['short_name']=='AUD'){
		                		      		$aud_exi=1;
		                		      		$isfeature=1;
		                		      	}elseif($featu['short_name']=='BLF'){
		                		      		$isfeature=1;
		                		      		$blf_exi=1;
		                		      	}elseif($featu['short_name']){
		                   					
		                   					$short_nam=1;
		                   				}
		                		      	
		                		      }
		                		      if(!$short_nam){
				        		      	?> 
				        		      	<table border="0" cellpadding="0" cellspacing="0" class="pad0-margin0">
				                    		<tr style="height:22px;">
				                    		<!--CBM<tr>-->
												<td style="border:none;" class="tooltip">
													<select style="margin-top: 2px" id="sel_input_val_<?php echo $j ?>" name="<?php if($isfeature) { ?>data_sel[<?php echo $featu['id']?>]<?php } else { echo 'data_new['.$data['Stationkey']['id'].']['.$l.']'; }?>" onchange="javascript:clearValuetxt_all('input_val_<?php echo $j ?>','input_label_<?php echo $j ?>','sel_input_val_<?php echo $j ?>');">
							                			<option value=""></option>	
														<option value="AUD" <?php if($aud_exi){?> selected="selected"<?php }?> ><?php __('AUD') ?>
														</option>
						                				<option value="BLF"<?php if($blf_exi){?> selected="selected"<?php }?>><?php __('BLF') ?></option>
					               					 </select>
					               					<p><?php __('AUD_BLF_desc')?></p>
					               					
												</td>
											</tr>
										</table>
									<?php }?>
	
		                	<?php }
		                	
                			foreach($data['Feature'] as $feat1){
		                     	if($fet_val=='DN'){
			                 		if(in_array($feat1['primary_value'],$blf_exist))
		                 				$fet_primvalue	=	$feat1['primary_value'];
			                 	}
                			}
                			
                			
        						
							#Start of Miscellaneous (Advanced) Features

					                     $i=0;
					                     foreach($data['Feature'] as $feat){
								$tool_tipname	=__($feat['short_name'].'_desc',true);
					                     	if($fet_val=='DN' || $fet_val=='MADN')
					                 		{
					                 		
					                		if(isset($feat['short_name']))
					                		{
												#$tool_tipname	=__($feat['short_name'].'_desc',true);
					                			
												#Exclude the ones that are already shown as editable.
												if (($feat['short_name'] != 'DISPLAYNAME') && ($feat['short_name'] != 'BARRINGSET') && ($feat['short_name'] != 'LANG') && ($feat['short_name'] != 'LEADINGZERO') && 
												($feat['short_name'] != 'CFU') && ($feat['short_name'] != 'CFUStatus') && ($feat['short_name'] != 'CFB') && ($feat['short_name'] != 'CFBStatus') && ($feat['short_name'] != 'CFNA') && 
												($feat['short_name'] != 'CFNAStatus') && ($feat['short_name'] != 'CFK') && ($feat['short_name'] != 'CFKStatus') && ($feat['short_name'] != 'CFDVT'))
												{
													
													#GROUP MEMBER CODE
													if(($feat['short_name'] == 'hntid') || ($feat['short_name'] == 'madn'))
													{?>
														<!-- CBMMOD margin-bottom: 0px-->
														<table border="0" cellpadding="0" cellspacing="0"  class="pad0-margin0" width="100%" style="margin-bottom: 0px;">
														<tr>
														<td  style="border-left:none;border-bottom:none;border-left:none;width:180px;" class="tooltip">
														<a href="#" style="color:#555555;cursor:default" ><?php echo  __($feat['short_name'],true); ?></a><p><?php  echo $tool_tipname; ?></p>
														</td>
														<td style="border-right:none;border-bottom:none;border-left:none;">
														<?php 
															#print_r($grp_members);
															#die();
															#Loop through the group members
															foreach($grp_members[$data['Stationkey']['id']] as $grp_member)
															{
																
																#echo 'checking' .$grp_member['stationkeys']['id'] . '=>' . $grp_pilots[$data['Stationkey']['id']][0]['stationkeys']['id'];
																$pilot_ident = '';
																if($grp_member['stationkeys']['id'] == $grp_pilots[$data['Stationkey']['id']][0]['stationkeys']['id'])
																{
																	#echo 'Set' ;
																	$pilot_ident = '-P';
																}
																#print_r($grp_member);
																#die();
																preg_match("/[0-9]+@([0-9\-]+)/", $grp_member['stationkeys']['id'], $matches);
																if ($matches) {
																	echo $html->link($grp_member['stationkeys']['id'] . $pilot_ident,  array('controller'=> 'stations', 'action'=>'edit',$matches[1]));
																}
																else
																{
																	echo $html->link($grp_member['stationkeys']['id'] . $pilot_ident,  array('controller'=> 'stations', 'action'=>'edit',$grp_member['stationkeys']['id']));
																}
															}
															?>
														</td>
														</tr>
														</table>														
													<?php
													}
													#GROUP MEMBER END
								#-----------------------------DISPLAY NON-EDITABLE FEATURE BLOCK forDN KEYS---------------------------------------
												else
												{
													?>
																
													<div id="config_<?php echo $data['Stationkey']['id'];?>" class="show" style="display:none;">
																
													<table border="0" cellpadding="0" cellspacing="0"  class="pad0-margin0" width="100%" style="margin-bottom: 0px;">
													<tr>
													<td  style="border-left:none;border-bottom:none;border-left:none;width:180px;" class="tooltip">
													<a href="#" style="color:#555555;cursor:default; text-decoration: none" ><?php echo  __($feat['short_name'],true); ?></a><p><?php  echo $tool_tipname; ?></p>
													</td>
													<td style="border-right:none;border-bottom:none;border-left:none;">
													&nbsp;
													</td>
													</tr>
													</table>
																
													</div> 
										
													<?php
												}
									#-----------------------------END NON-EDITABLE---------------------------------------

											}



					            			}

					                   	 }
						#-----------------------------DISPLAY NON-EDITABLE FEATURE BLOCK fori NON DN KEYS----------------------------------------
								elseif (($feat['short_name'] != 'AUD') && ($feat['short_name'] != 'BLF')) #For non DN keys
								{

								?>

								<div id="config_<?php echo $data['Stationkey']['id'];?>">
									
								<table border="0" cellpadding="0" cellspacing="0"  class="pad0-margin0" width="100%" style="margin-bottom: 0px;">
								<tr>
									<td  style="border:none;width:180px;" class="tooltip">
									<a href="#" style="color:#555555;cursor:default; text-decoration: none" ><?php echo  __($feat['short_name'],true); ?></a><p><?php  echo $tool_tipname; ?></p>
									</td>
								</tr>
								</table>
								
								</div> 
								<?php
								}

						#-----------------------------END NON-EDITABLE---------------------------------------


					                    $i++;
					                    }
					                    
					                    #End of Miscellaneous (Advanced) features
					                    
					                    
					                    ?><input type="hidden" id="hide" value="0">
									
														
							 <?php 
	                   			
                			#Start of BLF Display
                			
		                	 if( isset($data['Feature'][0]['short_name']) && ($data['Feature'][0]['short_name']=='BLF') && in_array($data['Feature'][0]['primary_value'],$blf_exist)){
		                	 	
		                	 	
		                	 		$obser	=	str_replace($data['Stationkey']['id'], "",$statID[$data['Feature'][0]['primary_value']]);
									$remov	=	str_replace(',','',$obser);
		                	 	
		                	 
									if(trim($remov)){	?>
										<!-- CBM MOD -->
										<a href="javascript:void(null);"  class="show" style="display:none;color:#555555">BLF <?php echo ($data['Feature'][0]['short_name']=='BLF') ? ' Co-observers' : 'Observers'?></a>
									<?php }?>
									<input type="hidden" id="show_<?php echo $data['Stationkey']['id']?>"  value="0"/>
									<div id="list_blf_<?php echo $data['Stationkey']['id']?>" class="fl">
										
									</div>
							<?php }?>	
							<?php if($fet_val=='DN' && in_array($fet_primvalue,$blf_exist)){
								
								$obser	=	str_replace($data['Stationkey']['id'], "",$statID[$fet_primvalue]);
								$remov	=	str_replace(',','',$obser);
								if(trim($remov)){
								?>
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<!-- ORIG RE1 <td style="display:none;border-left:none;border-bottom:none;width:179px;" class="show tooltip"> -->
											<td style="border-left:none;border-bottom:none;width:179px;" class="ublist-align wid-217px tooltip">
												
												 <a href="#" style="color:#555555;cursor:default" ><?php echo  __('BLF Observers',true); ?></a><p><?php __('BLF Observers_desc'); ?></p>
											</td>
											<!-- ORIG RE1 <td style="display:none;border-left:none;border-right:none;border-bottom:none;" class="show"> -->
											<td style="border-left:none;border-right:none;border-bottom:none;" class="">
												<?php 
													$BLF_Observers = explode(', ', $statID[$fet_primvalue]);
													foreach ($BLF_Observers as $BLF_Member)
													{
														preg_match("/[0-9]+@([0-9]+)/", $BLF_Member, $matches);
														if ($matches) {
															echo $html->link($BLF_Member,  array('controller'=> 'stations', 'action'=>'edit',$matches[1]));
														}
														else
														{
														#echo 'yy'.$BLF_Member;
															echo $html->link($BLF_Member,  array('controller'=> 'stations', 'action'=>'edit',$BLF_Member));
														}
													}
												?>
											</td>
										</tr>
									</table>
								<?php }?>
									<input type="hidden" id="show_<?php echo $data['Stationkey']['id'];?>" value="0"/>
									<div id="list_blf_<?php echo $data['Stationkey']['id'];?>" class="fl">
									
									</div>
									<?php }
									
									#End of BLF Display
	                   			
	                   				#Start of Modifiable AUD/BLF
	                   				
	                   				
		                    		if(!$set_text){
									  $i=0;$text_other=0;$isfeature=0;
				                     foreach($data['Feature'] as $feat){
				                     	
			                 			if($feat['short_name']	=='AUD' || $feat['short_name']	=='BLF'){$isfeature=1;?>
			                   				<TD style="vertical-align:top; padding-top: 2px">
			                   					<div id="div_input_val_<?php echo $j ?>">
													<!--<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">-->
													<TABLE BORDER="0" style="margin:0px">
														<tr>
															<!--<TD  style="border:none;"><div class="fl">&nbsp;&nbsp;&nbsp;</div><br>-->
															<TD  style="border:none;">
															<div class="fl"><div class="input text"><input class="numeric_check" style="width: 166px" AUTOCOMPLETE=OFF  id="input_val_<?php echo $j ?>"  name="data[<?php echo $feat['id']?>]" type="text" value="<?php echo $feat['primary_value']  ?>" size="13">
					               								
															</div></div></TD>
														</tr>
														<?php if(in_array($data['Feature'][0]['primary_value'],$blf_exist)){
															
																	$obser	=	str_replace($data['Stationkey']['id'], "",$statID[$data['Feature'][0]['primary_value']]);
																	$remov	=	str_replace(',','',$obser);
																	
															if(trim($remov)):																
															?>
														<tr>
															<td style="display:none;border-left:none;border-right:none" class="show">
																<?php 
																#Orig RE1 echo trim($statID[$data['Feature'][0]['primary_value']],',');
																$BLF_Observers = explode(', ', $statID[$data['Feature'][0]['primary_value']]);
																foreach ($BLF_Observers as $BLF_Member)
																{
																	preg_match("/[0-9]+@([0-9]+)/", $BLF_Member, $matches);
																	if ($matches) {
																		echo $html->link($BLF_Member,  array('controller'=> 'stations', 'action'=>'edit',$matches[1]));
																	}
																	else
																	{
																		#echo 'yy'.$BLF_Member;
																		echo $html->link($BLF_Member,  array('controller'=> 'stations', 'action'=>'edit',$BLF_Member));
																	}
																}
																
																?>
																
															</td>
														</tr>
														<?php endif;}?>
													</table>
												</div>
											</TD>
	                   				<?php $text_other=1;}
				                     }
		                   			if(!$text_other){?>
		                   			
		                   				<TD style="width:65%;vertical-align:top; padding-top: 2px; padding-left: 1px;">
		                   					<div id="div_input_val_<?php echo $j ?>" style="display:none;">
												<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
														<tr>
															<!--<TD  style="border:none;"><div class="fl">&nbsp;&nbsp;&nbsp;</div><br>-->
															<TD  style="border:none;">
																<div class="fl">
																	<div class="input text"><input class="numeric_check" style="width: 166px"  AUTOCOMPLETE=OFF  id="input_val_<?php echo $j ?>"  type="text" size="13" name="<?php if($isfeature) { ?>data_txt[<?php echo $feat['id']?>]<?php } elseif(!$short_nam){ echo 'data_txt['.$data['Stationkey']['id'].']['.$l.']'; }?>">
					               										
																</div></div>
															</TD>
														</tr>
												</table>
											</div>
										</TD>
		                   			
		                   			<?php }
		                   			}?>
		                   			<td class="table-right-ohne">&nbsp;</td>
		                   			<input type="hidden" id="key_input_val_<?php echo $j ?>" value="<?php echo $data['Stationkey']['id'];?>"/>
						</TR>
	
					<?php $j++; }
				#-----------------------END OF FIRST 14 KEYS-------------------------------------
				}?>
			</TABLE>
		
		</fieldset>
		
				<!-- -----------------------START OF EXPANSION MODULES------------------------------------- -->
		
		<?php if($stationinfo[0]['Station']['extensions']!=0){?>
		<div class="fr" style="width:25px;" onclick="javascript:show_exp_link('1');">
			<!--<div id="btn_1" class="fl expandButton">&nbsp;</div>-->
			<input type="hidden" value="0" id="show_link_hide_1">
			<input type="hidden" value="<?php echo $stationinfo[0]['Station']['extensions']; ?>" id="show_link_extension">
		</div>
		
		<!--<div class="fr" >
			<a id="clickMe" class="clickMe" onclick="javascript:show_exp_link('1');">EXPANSION MODULE  1</a>
		</div>-->
		<?php }?>
		<div class="cb"></div>
	 <?php 
	
	 $n	=	$stationinfo[0]['Station']['extensions'];
	 	
	 	for($k=1;$k<=$n;$k++){
	 		if($k==1){
	 			$key_from	=	15;
	 			$key_to		=	36;
	 			
	 		}if($k==2){
	 			$key_from	=	37;
	 			$key_to		=	54;
	 			
	 		}
	 		
	 ?>
	  <div id="show_expansion_<?php echo $k?>" style="display:none;">
		<fieldset>
			<legend><?php __('EXPANSION MODULE KEY DATA') ?></legend>
		
			<TABLE class="phone">
				<thead>
					<TR class="table-top">
						<th class="table-column table-left-ohne"><a href="#">&nbsp;</a></th>
						<th class="table-column"><span style="width:27px;text-align:left"><?php __("Key")?></span></th>
						<th class="table-column"><span style="width:110px;text-align:left"><?php __("Label")?></span></th>
						<th class="table-column"><span style="width:180px;text-align:left"><?php __("Feature")?></span></th>
						<th class="table-column" ><span style="width:176px;"><?php __("feature values")?></span></th>
						<th class="table-right-ohne" style="width:100px;">&nbsp;&nbsp;&nbsp;&nbsp;</th>
					</TR>
				</thead>
				<?php $j=0; //$l=0;
				foreach($stationinfo as $data){
					$fet_val='';$fet_prival='';$fet_otherval='';$fet_cs2kfeatures='';
					
					foreach($data['Feature'] as $Chk_feat){
		             
	        			if(isset($Chk_feat['short_name']) && isset($Chk_feat['primary_value']) && ($Chk_feat['short_name']=='DN' || $Chk_feat['short_name']=='MADN'))
	        			{	
							$fet_val	=	$Chk_feat['short_name'];
							$fet_prival	=	$Chk_feat['primary_value'];
	    				}
	    				elseif(isset($Chk_feat['short_name']) && $Chk_feat['short_name']){
		           			$fet_otherval	=	$Chk_feat['short_name'];
		           			$fet_cs2kfeatures	=	$Chk_feat['cs2kfeatures'];
	    				}
		            }
		        #}
					
	           		if($data['Stationkey']['keynumber']>=$key_from && $data['Stationkey']['keynumber']<=$key_to){
	           	?>
							<TR>
							<td class="table-left">&nbsp;</td>
							<td>
								<!--<div class="buttons"> <p><?php echo $data['Stationkey']['keynumber']?></p> </div>-->
								<p style="margin: 2px 0px 0px 4px;"><?php echo $data['Stationkey']['keynumber']?></p>
							</td>
							
							
							<td style="vertical-align: top; padding: 3px;">
								<?php 
									$text_other	=0;$isfeature=0;$short_nam=0;$more=1;$limit=1;$set_val=0;
									foreach($data['Feature'] as $features){
										
										if($features['short_name']=='BLF' || $features['short_name']=='AUD'){?>
											<div id="div1_input_val_<?php echo $j ?>">
												<div class="fl">
													<div class="input text">
														<input class="space_check"  AUTOCOMPLETE=OFF  id="input_label_<?php echo $j ?>"  name="dataLabel[<?php echo $features['id']?>]" type="text" value="<?php echo $features['label']?>" size="13">
														
													</div>
												</div>
											</div>
										<?php $text_other=1;
										}else{
											
											/*if(isset($fet_otherval) && $more){?>
		                   	 						<span style="cursor:pointer" title="<?php echo ($fet_cs2kfeatures) ? $fet_cs2kfeatures:'';?>"> <?php echo  $fet_otherval ;?></span>
                   	 						<?php $more=0; }$text_other=1;*/
											
												if($limit){
													if($features['label']) $limit=0;?>
												<div class="fl">
													<?php 
														#echo isset($features['label'])?substr($features['label'],0,10):''."\n";
														echo isset($features['label'])?$features['label']:''."\n";
													?>
												</div>
											<?php }
											
											if($fet_val=='DN' || $fet_val=='MADN')
		                    					$set_val=1;
		                    				if(!$set_val){
		                    					if($features['short_name']){
		                   							$short_nam=1;
		                    					}
		                    				}
										}
								}
								if(!$set_val && !$short_nam && !$text_other){?>
								<div id="div1_input_val_<?php echo $j ?>" style="display:none;">
									<div class="fl"><div class="input text "><input style="width: 100px; " class="space_check"  AUTOCOMPLETE=OFF  id="input_label_<?php echo $j ?>"  type="text" name="<?php if($isfeature) { ?>data_label[<?php echo $feat['id']?>]<?php } elseif(!$short_nam) { echo 'data_label['.$data['Stationkey']['id'].']['.++$l.']'; }?>" size="13">
										
									</div></div>
								</div>
								<?php }?>
							</td>
							<TD <?php echo ($fet_val=='DN' || $fet_val=='MADN')?'colspan="2"':''?> style="padding-left:0px; padding-top:0px; vertical-align:top;">
							 <?php
		                    		$set_val	=0;
									$set_text	=0;
		                    		if($fet_val=='DN' || $fet_val=='MADN'){
		                    			$set_val=1;
		                    			$set_text=1;$val=array();
	                    				foreach($data['Feature'] as $features){
											if($features['short_name']=='DISPLAYNAME'){
													$val[0]['short_name']	='DISPLAYNAME';
													$val[0]['primary_value']=$features['primary_value'];
													$val[0]['id']=$features['id'];
												}
												if($features['short_name']=='LANG'){
													$val[1]['short_name']	='LANG';
													$val[1]['primary_value']=$features['primary_value'];
													$val[1]['id']=$features['id'];
												}
												if($features['short_name']=='BARRINGSET'){
													$val[2]['short_name']	='BARRINGSET';
													$val[2]['primary_value']=$features['primary_value'];
													$val[2]['id']=$features['id'];
												}
											}
											if(!isset($val[0]['short_name'])){
													$val[0]['short_name']	='DISPLAYNAME';
													$val[0]['primary_value']='';
													$val[0]['id']='';
											}if(!isset($val[1]['short_name'])){
													$val[1]['short_name']	='DISPLAYNAME';
													$val[1]['primary_value']='';
													$val[1]['id']='';
											}if(!isset($val[2]['short_name'])){
													$val[2]['short_name']	='DISPLAYNAME';
													$val[2]['primary_value']='';
													$val[2]['id']='';
											}
											?>
		                    	<div>
						<!-CBMMOD margin-bottom: 0px -->
			                    	<table border="0" cellpadding="0" cellspacing="0"  class="pad0-margin0" style="margin-bottom: 0px">
			                    		<tr style="height:25px;">
			                    		<!--CBM<tr>-->
								<td class="sublist-align wid-217px tooltip">
									<span  style="cursor:default" ><?php __('DISPLAYNAME') ?></span>
									<p><?php __('DISPLAYNAME_desc') ?></p>
								</td>
										
								<td  style="border-right:none;border-top:none;">
									 <?php if($val[0]['short_name']=='DISPLAYNAME'  && !is_null($val[0]['primary_value'])){?>
											
									<?php if($val[0]['id']){?>
										<input  style="width: 168px;" type="text" size="13" class="display space_check"  id="data_<?php echo $j?>" name="data[<?php echo $val[0]['id']?>]" AUTOCOMPLETE=OFF value="<?php echo $val[0]['primary_value']?>">
									<?php }else {?><input type="text" style="border:none" readonly><?php }?>
										
										<input type="hidden" id="keydata_<?php echo $j?>" value="<?php echo $data['Stationkey']['id'];?>"/>
									<?php }?>
								</td>
											
											
							</tr>	
							<!-- CBMMOD height -->	
							<tr style="height:25px;">
							<!--CBM<tr>-->
								<td class="sublist-align wid-217px tooltip">
									<span   style="cursor:default"><?php __('LANGUAGE') ?></span>
									<p><?php __('LANGUAGE_desc') ?></p>
								</td>
								<td style="border-right:none;border-top:none;" class="tooltip">
								<?php if($val[1]['short_name']=='LANG'){?>
												
								<?php if($val[1]['id']){?>
								<select  style="width:174px;" id="data[<?php echo $val[1]['id']?>]" name="data[<?php echo $val[1]['id']?>]">
					       				<option value="FR" <?php if(strtoupper($val[1]['primary_value'])=='FR'){?> selected="selected"<?php }?> >FR</option>
					             			<option value="DE" <?php if(strtoupper($val[1]['primary_value'])=='DE'){?> selected="selected"<?php }?> >DE</option>
							                <option value="IT" <?php if(strtoupper($val[1]['primary_value'])=='IT'){?> selected="selected"<?php }?> >IT</option>
							        </select>
							         <p><?php __('LANG_help') ?></p>
						               	 <?php }?>
					               				 
												<?php }?>
											</td>
										</tr>
									
										<tr style="height:25px;">
										<!--<tr>-->
											<td style="border:  none" class="tooltip">
												<span   style="cursor:default;float:left;margin-top:3px;" ><?php __('BARRINGSET') ?></span><p><?php __('BARRINGSET_desc') ?></p>
											</td>
											
											<td class="tooltip"  style="border-right:none;border-top:none;border-bottom:none;margin-bottom:0px;">
											<?php
											if($val[2]['short_name']=='BARRINGSET'){
												?>
													
														<?php if($val[2]['id']){?>
															<select style="width:174px;" id="data[<?php echo $val[2]['id']?>]" name="data[<?php echo $val[2]['id']?>]">
															<?php for($i=1;$i<=5;$i++){
																	$barSetId = 'set' . $i;
															?>
																<!--CBM <option value="Set<?php echo $i?>" <?php if($val[2]['primary_value']=='Set'.$i){?> selected="selected"<?php }?>>Set <?php echo  $i?></option> -->
																<option value="Set<?php echo $i?>" <?php if($val[2]['primary_value']=='Set'.$i){?> selected="selected"<?php }?>><?__("$barSetId") ?></option>
								               				<?php }?>
															 </select>
															 
																 <p><?php __('BARRINGSET_help') ?></p>
															
														 <?php }?>
													
											<?php }?>
											</td>
										</tr>
			                    	</table>
	                    		</div>
		                	<?php }
		                		if(!$set_val){
		                			$aud_exi=0;
		                			$blf_exi=0;
		                			$isfeature=0;
		                			$text_other=0;
		                			$short_nam=0;
		                		      foreach($data['Feature'] as $featu){ 
		                		      	
		                		      	if($featu['short_name']=='AUD'){
		                		      		$aud_exi=1;
		                		      		$isfeature=1;
		                		      	}elseif($featu['short_name']=='BLF'){
		                		      		$isfeature=1;
		                		      		$blf_exi=1;
		                		      	}elseif($featu['short_name']){
		                   					
		                   					$short_nam=1;
		                   				}
		                		      	
		                		      }
		                		      if(!$short_nam){
				        		      	?> 
				        		      	<table border="0" cellpadding="0" cellspacing="0" class="pad0-margin0">
				                    		<tr style="height:22px;">
				                    		<!--CBM<tr>-->
												<td style="border:none;" class="tooltip">
													<select style="margin-top: 2px" id="sel_input_val_<?php echo $j ?>" name="<?php if($isfeature) { ?>data_sel[<?php echo $featu['id']?>]<?php } else { echo 'data_new['.$data['Stationkey']['id'].']['.$l.']'; }?>" onchange="javascript:clearValuetxt_all('input_val_<?php echo $j ?>','input_label_<?php echo $j ?>','sel_input_val_<?php echo $j ?>');">
							                			<option value=""></option>	
														<option value="AUD" <?php if($aud_exi){?> selected="selected"<?php }?> ><?php __('AUD') ?>
														</option>
						                				<option value="BLF"<?php if($blf_exi){?> selected="selected"<?php }?>><?php __('BLF') ?></option>
					               					 </select>
					               					<p><?php __('AUD_BLF_desc')?></p>
					               					
												</td>
											</tr>
										</table>
									<?php }?>
	
		                	<?php }
		                	
                			foreach($data['Feature'] as $feat1){
		                     	if($fet_val=='DN'){
			                 		if(in_array($feat1['primary_value'],$blf_exist))
		                 				$fet_primvalue	=	$feat1['primary_value'];
			                 	}
                			}
		                	 if( isset($data['Feature'][0]['short_name']) && ($data['Feature'][0]['short_name']=='BLF') && in_array($data['Feature'][0]['primary_value'],$blf_exist)){
		                	 	
		                	 	
		                	 		$obser	=	str_replace($data['Stationkey']['id'], "",$statID[$data['Feature'][0]['primary_value']]);
									$remov	=	str_replace(',','',$obser);
		                	 	
		                	 
									if(trim($remov)){	?>
										<!-- CBM MOD -->
										<a href="javascript:void(null);"  class="show" style="display:none;color:#555555">BLF <?php echo ($data['Feature'][0]['short_name']=='BLF') ? ' Co-observers' : 'Observers'?></a>
									<?php }?>
									<input type="hidden" id="show_<?php echo $data['Stationkey']['id']?>"  value="0"/>
									<div id="list_blf_<?php echo $data['Stationkey']['id']?>" class="fl">
										
									</div>
									<?php }?>	
							<?php if($fet_val=='DN' && in_array($fet_primvalue,$blf_exist)){
								
								$obser	=	str_replace($data['Stationkey']['id'], "",$statID[$fet_primvalue]);
								$remov	=	str_replace(',','',$obser);
								if(trim($remov)){
								?>
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td style="display:none;border-left:none;border-bottom:none;width:179px;" class="show tooltip">
												<!--  <a class="show" href="javascript:void(null);" style="display:none;color:#555555; cursor: default" ><?php __('BLF Observers') ?></a> -->
												 <a href="#" style="color:#555555;cursor:default" ><?php echo  __('BLF Observers',true)?></a><p><?php __('BLF Observers_desc') ?></p>
											</td>
											<td style="display:none;border-left:none;border-right:none;border-bottom:none;" class="show">
												<?php # ORIG RE1 echo $statID[$fet_primvalue];?>
												<?php 
													$BLF_Observers = explode(', ', $statID[$fet_primvalue]);
													foreach ($BLF_Observers as $BLF_Member)
													{
														preg_match("/[0-9]+@([0-9]+)/", $BLF_Member, $matches);
														if ($matches) {
															echo $html->link($BLF_Member,  array('controller'=> 'stations', 'action'=>'edit',$matches[1]));
														}
														else
														{
														#echo 'yy'.$BLF_Member;
															echo $html->link($BLF_Member,  array('controller'=> 'stations', 'action'=>'edit',$BLF_Member));
														}
													}
												?>
											</td>
										</tr>
									</table>
								<?php }?>
									<input type="hidden" id="show_<?php echo $data['Stationkey']['id']?>" value="0"/>
									<div id="list_blf_<?php echo $data['Stationkey']['id']?>" class="fl">
									
									</div>
									<?php }
		                	
		       	 					if( isset($data['Feature'][1]) ){
				               	 	?>
				               	 	
				                    <?php }//echo "<pre>";print_r($data['Feature']);echo "dfdd";die('ss');?>
				               	 	<div id="config_<?php echo $data['Stationkey']['id']?>" class="show" style="display:none;">
					                   <?php //print_r($data['Feature']);echo "dfdd";die('ss');
					                     $i=0;
					                     foreach($data['Feature'] as $feat){
					                     	if($fet_val=='DN' || $fet_val=='MADN')
					                 		{
					                 		
					                		if(isset($feat['short_name']))
					                		{	$tool_tipname	=__($feat['short_name'].'_desc',true);
					                				
					                			//$tool_tipname2	=	($feat['cs2kfeatures'])?"------".$feat['cs2kfeatures']:'';
										#CBM ADDED TO STOP REPEAT
										if (($feat['short_name'] != 'DISPLAYNAME') && ($feat['short_name'] != 'BARRINGSET') && ($feat['short_name'] != 'LANG') && ($feat['short_name'] != 'LEADINGZERO'))
										{?>
					<!-- CBMMOD margin-bottom: 0px-->
											<table border="0" cellpadding="0" cellspacing="0"  class="pad0-margin0" width="100%" style="margin-bottom: 0px">
												<tr>
													<td  style="border-left:none;border-bottom:none;border-left:none;width:180px;" class="tooltip">
														<a href="#" style="color:#555555;cursor:default" ><?php echo  __($feat['short_name'],true)?></a><p><?php  echo $tool_tipname; ?></p>
													</td>
													<td style="border-right:none;border-bottom:none;border-left:none;">
														&nbsp;
													</td>
												</tr>
											
											</table>
													
					        					<!--echo "<a class='hide_color' style='height:1px;'  href='#' title='www'>".__($feat['short_name'],true).'</a><br>';-->
										<?}


					            			}

							#-----------------------------DISPLAY NON-EDITABLE FEATURE BLOCK fori NON DN KEYS----------------------------------------
									else #For non DN keys
									{
	
									?>
	
									<div id="config_<?php echo $data['Stationkey']['id'];?>">
										
									<table border="0" cellpadding="0" cellspacing="0"  class="pad0-margin0" width="100%" style="margin-bottom: 0px;">
									<tr>
										<td  style="border:none;width:180px;" class="tooltip">
										<a href="#" style="color:#555555;cursor:default; text-decoration: none" ><?php echo  __($feat['short_name'],true); ?></a><p><?php  echo $tool_tipname; ?></p>
										</td>
									</tr>
									</table>
									
									</div> 
									<?php
									}
	
							#-----------------------------END NON-EDITABLE---------------------------------------



					                   	 }



					                    $i++;
					                    }
					                    ?><input type="hidden" id="hide" value="0">
									</div> 
									<?php

								#NON MODIFIABLE FEATURES
									if(isset($fet_otherval) && $more && ($fet_val!='DN' && $fet_val!='MADN') && (strtolower($fet_otherval)!='blf' && strtolower($fet_otherval)!='aud') && !empty($fet_otherval)){?>
               	 						<!-- CBM <span style="cursor:pointer; padding-left: 2px;" title="<?php echo ($fet_otherval) ? $fet_otherval:'';?>"> <?php echo (strtolower($fet_otherval)!='blf' && strtolower($fet_otherval)!='aud') ? $fet_otherval :'';?></span> -->
               	 						<span class="tooltip" style="cursor:default; padding-left: 2px;" > <?php echo (strtolower($fet_otherval)!='blf' && strtolower($fet_otherval)!='aud') ? __("$fet_otherval") :'';?>
               	 						<p><?php echo ($fet_otherval) ? __("$fet_otherval" . '_desc'):'';?></p>
               	 						</span>
           	 						<?php $more=0; }?>
								</TD>
							
							 <?php 
	                   			
		                    		if(!$set_text){
									  $i=0;$text_other=0;$isfeature=0;
				                     foreach($data['Feature'] as $feat){
				                     	
			                 			if($feat['short_name']	=='AUD' || $feat['short_name']	=='BLF'){$isfeature=1;?>
			                   				<TD style="vertical-align:top; padding-top: 2px">
			                   					<div id="div_input_val_<?php echo $j ?>">
													<!--<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">-->
													<TABLE BORDER="0" style="margin:0px">
														<tr>
															<!--<TD  style="border:none;"><div class="fl">&nbsp;&nbsp;&nbsp;</div><br>-->
															<TD  style="border:none;">
															<div class="fl"><div class="input text"><input class="numeric_check" style="width: 166px" AUTOCOMPLETE=OFF  id="input_val_<?php echo $j ?>"  name="data[<?php echo $feat['id']?>]" type="text" value="<?php echo $feat['primary_value']  ?>" size="13">
					               								
															</div></div></TD>
														</tr>
														<?php if(in_array($data['Feature'][0]['primary_value'],$blf_exist)){
															
																	$obser	=	str_replace($data['Stationkey']['id'], "",$statID[$data['Feature'][0]['primary_value']]);
																	$remov	=	str_replace(',','',$obser);
																	
															if(trim($remov)):																
															?>
														<tr>
															<td style="display:none;border-left:none;border-right:none" class="show">
																<?php echo trim($statID[$data['Feature'][0]['primary_value']],',');?>
															</td>
														</tr>
														<?php endif;}?>
													</table>
												</div>
											</TD>
	                   				<?php $text_other=1;}
				                     }
		                   			if(!$text_other){?>
		                   			
		                   				<TD style="width:65%;vertical-align:top; padding-top: 2px; padding-left: 1px;">
		                   					<div id="div_input_val_<?php echo $j ?>" style="display:none;">
												<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
														<tr>
															<!--<TD  style="border:none;"><div class="fl">&nbsp;&nbsp;&nbsp;</div><br>-->
															<TD  style="border:none;">
																<div class="fl">
																	<div class="input text"><input class="numeric_check" style="width: 166px"  AUTOCOMPLETE=OFF  id="input_val_<?php echo $j ?>"  type="text" size="13" name="<?php if($isfeature) { ?>data_txt[<?php echo $feat['id']?>]<?php } elseif(!$short_nam){ echo 'data_txt['.$data['Stationkey']['id'].']['.$l.']'; }?>">
					               										
																</div></div>
															</TD>
														</tr>
												</table>
											</div>
										</TD>
		                   			
		                   			<?php }
		                   			}?>
		                   			<td class="table-right-ohne">&nbsp;</td>
		                   			<input type="hidden" id="key_input_val_<?php echo $j ?>" value="<?php echo $data['Stationkey']['id'];?>"/>
						</TR>
					
					<?php  }$j++;
				}?>
			</TABLE>
	
		</fieldset>

		<?php if($k!=$stationinfo[0]['Station']['extensions']){?>
		<!--<div class="fr" style="width:25px;"  onclick="javascript:show_exp_link('<?php echo $k+1?>');">
					<div id="btn_<?php echo $k+1?>" class="fl expandButton">&nbsp;</div>
					
		</div>--><input type="hidden" value="0" id="show_link_hide_<?php echo $k+1?>">
<!--		<div  class="fr" >
			<a id="clickMe" class="clickMe"  onclick="javascript:show_exp_link('<?php //echo $k+1?>');">EXPANSION MODULE  <?php //echo $k+1?></a>
		</div>-->
		<div class="cb"></div>
			<?php }?>
		
		</div>
		
		<?php }?>
			<!--CBM ADDED -->
			<!-- 
			<fieldset>
                       <fieldset style="display:none;">
                        <input type="hidden" name="_method" value="PUT" />
                        </fieldset>

                        <div class="button-right">
                        <a href="javascript:void(null);"  onclick="javascript:return validate_form();" name="validate" value="validate" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __('Validate') ?></a>
                        </div>
						<div class="button-right">
						<?php echo $html->link( __('reset', true),  array('controller'=> 'stations', 'action'=>'edit',$location['Station']['id']),array('onmouseover'=>'javascript:hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
                        </div>

           </fieldset>
           -->
			<!-- END CBM -->
		</div>
		
	</div>
		
	<div class="hide" style="display:none;">	
		<div id="upload_photo" align="left" class="phone" style="padding-left:10px;" >
			<h1 style="width: 520px; text-align: left"><?php  __("Modification Confirmation")?></h1>
			<hr style="width: 520px" >
			<div style="clear:both;height:20px">&nbsp;</div>
			<div class="cb" style="color:red;font-size:1.0em;text-align:left;font-weight:bold" id="error_report_js"></div>
		</div>
	</div>
	
	<div class="hide" style="display:none;">
		<img id="1120_image" style="display:none"  src="<?php echo Configure::read('base_url');?>images/1120.png">
		<img id="1140_image" style="display:none" src="<?php echo Configure::read('base_url');?>images/1140.png">
	</div>
</div>				


*/



</form>

