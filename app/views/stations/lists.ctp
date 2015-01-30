<!--$Rev:: 22            $:  Revision of last commit--> 

<div class="stations form">


<?php if((isset($success)) && $success){?>
	<div style="font-size:1.5em;color:green"><?php echo $success;?> </div>
<?php }?>
	<form id="StationEditForm" method="post" action="<?php echo  'http://selfcare.rainconcert.in/stations/edit/'.$stationinfo[0]['Station']['id'];?>" onsubmit="javascript:return validate();">
	<!--<form id="StationEditForm" method="post" action="<?php echo  'http://192.168.0.170/selfcare/stations/edit/'.$stationinfo[0]['Station']['id'];?>" >-->
		<fieldset>
			<fieldset style="display:none;">
				<input type="hidden" name="_method" value="PUT" />
			</fieldset>
			<div class="block">
				<div class="button-left">
				<button type="button" onclick="javascript:validate_form();" name="validate" value="validate">Validate</button>
				</div>
			</div><br>
		</fieldset>
	
	
	<fieldset>
		<legend><?php __("station_data")?> <?php echo $stationinfo[0]['Station']['number']?><a href="#">(Select new station)</a></legend>
		<!--<input type="hidden" name="data[Station][id]" value="9" id="StationId" /> -->
		<TABLE class="phone-key"> 
			<tr>
				<TD>
					<div class="input password"><label for="StationPassword">Password: *</label>
						<input type="password" size="13" value="<?php echo $location['Station']['password']?>" />
					</div>
				</TD>
				
				<TD>
					<div class="input select"><label for="StationLocations">Location: *</label>
						<label><?php echo $location['Location']['name']?></label>
					</div>
				</TD>
				<TD>
					<div class="input select"><label for="StationType">Type: *</label>
						<select name="station_type">
						<option>1120</option>
						<option>1140</option>
						</select>
					</div>
				</TD>
			
			</tr>
		</table>
	</fieldset>
	<?php //echo $stationinfo[0]['Station']['extensions']?>
	<fieldset>
		<legend>Main Key DATA</legend>
		<TABLE class="phone-key">
			<TR>
				<TH><p><?php __("keyid")?></p></TH>
				<TH><p><?php __("config")?></p></TH>
				<TH><p><?php __("possible modi")?></p></TH>
				<TH><p><?php __("feature values")?></p></TH>
			</TR>
			<?php $j=0; 
			foreach($stationinfo as $data){
           		if($j<12){
           	?>
					<TR>
						<td>
							<div class="buttons"> <p><?php echo $data['Stationkey']['number']?></p> </div>
						</td>
						
						<TD>
						 <?php 
		                    	if(isset($data['Feature'][0]['short_name']) && isset($data['Feature'][0]['value']))
		                   	 			echo  $data['Feature'][0]['short_name'] .' : '.$data['Feature'][0]['value'].'<br>';
	       	 					if( isset($data['Feature'][1]) ){
		               	 	?>
		               	 	<a href="javascript:void(null);" onclick="javascript:show_hide('<?php echo $data['Stationkey']['number']?>');">Show/hide</a>
		                    <?php }?>
		               	 	<div id="config_<?php echo $data['Stationkey']['number']?>" style="display:none">
			                   <?php 
			                     $i=0;
			                     foreach($data['Feature'] as $feat){
			                     	if($i!=0)
			                 		{
		                 		
			                			if(isset($feat['short_name']) && isset($feat['value']))
			                			{	//$tool_tipname	=__($feat['short_name'])	;
			        						echo '<a class="hide_color"  href="#" title="'.__($feat['short_name'],true).'">'.$feat['short_name'].'</a><br>';
			            				}
	                 					
			                   		 }	
			                      $i++;
			                    
			                    }
			                    ?><input type="hidden" id="hide" value="0">
							</div> 
						<TD>
						 <?php
	                    	$set_val	=0;
							
	                    	if(isset($data['Feature'][0]['short_name'])){
	                    		if($data['Feature'][0]['short_name']=='DN' || $data['Feature'][0]['short_name']=='MADN'){
	                    			$set_val=1;
	                    	?>
	                    	DISPLAY NAME<br><br>LANGUAGE<br><br>BARRING SET
	                	<?php } }
	                		if(!$set_val){
	                			$aud_exi=0;
	                		      foreach($data['Feature'] as $featu){ 
	                		      	
	                		      	if($featu['short_name']=='AUD'){
	                		      		$aud_exi=1;
	                		      	}
	                		      }
        		      	?> 
							<select id="data_sel[<?php echo $data['Stationkey']['id']?>]" name="data_sel[<?php echo $data['Stationkey']['id']?>]" style="width:75px;" onchange="javascript:clearValuetxt('mod_text_<?php echo $data['Stationkey']['number']?>');">
                			<option></option>	
							<option value="AUD" <?php if($aud_exi){?> selected="selected"<?php }?> >AUD</option>
                				<option value="BLF">BLF</option>
               				 </select>
	                	<?php }?>
						</TD>
						
						 <?php $set_text=0;
                   			if(isset($data['Feature'][0]['short_name'])){
	                    		if($data['Feature'][0]['short_name']=='DN' || $data['Feature'][0]['short_name']=='MADN'){
	                    			$set_text=1;
	                    	?>
		                    	<TD>
									<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
										<tr>
											<TD><div class="input text"><label for="StationKey1Featval">&nbsp;</label><input type="text" size="13" id="data[<?php echo $data['Feature'][1]['id']?>]" name="data[<?php echo $data['Feature'][1]['id']?>]" value="<?php echo $data['Feature'][1]['value']?>"></div></TD>
											<TD><div class="input text"><label for="StationKey1Featval">&nbsp;</label></div></TD>
										</tr>
										<tr>
											<TD><div class="input text"><label for="StationKey1Featval">&nbsp;</label>
													<select id="data[<?php echo $data['Feature'][2]['id']?>]" name="data[<?php echo $data['Feature'][2]['id']?>]">
														<option value="EN" <?php if($data['Feature'][2]['value']=='EN'){?> selected="selected"<?php }?> >EN</option>
						                				<option value="FR" <?php if($data['Feature'][2]['value']=='FR'){?> selected="selected"<?php }?> >FR</option>
						                				<option value="DE" <?php if($data['Feature'][2]['value']=='DE'){?> selected="selected"<?php }?> >DE</option>
						               				 </select>
					               				 </div>
											</TD>
											<TD><div class="input text"><label for="StationKey1Featval">&nbsp;</label></div></TD>
										</tr>	
										<tr>
											<TD><div class="input text"><label for="StationKey1Featval">&nbsp;</label>
											
												<select id="data[<?php echo $data['Feature'][3]['id']?>]" name="data[<?php echo $data['Feature'][3]['id']?>]">
												<?php for($i=1;$i<=10;$i++){?>
													<option value="Set <?php echo $i?>" <?php if($data['Feature'][3]['value']=='Set '.$i){?> selected="selected"<?php }?>>Set <?php echo  $i?></option>
					               				<?php }?>
												 </select>
												</div>
											</TD>
											<TD><div class="input text"><label for="StationKey1Featval">&nbsp;</label></div></TD>
										</tr>
									</table>
								</TD>
							<?php }
                   			}if(!$set_text){
								  $i=0;$text_other=0;
			                     foreach($data['Feature'] as $feat){
			                     	
		                 			if($feat['short_name']	=='AUD'){?>
		                   				<TD>
											<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
												<tr>
													<TD><div class="input text "><label for="StationKey1Featval">&nbsp;</label><input class="numeric_check"  id="mod_text_<?php echo $data['Stationkey']['number']?>"  name="data[<?php echo $feat['id']?>]" type="text" value="<?php echo $feat['value']  ?>" size="13"></div></TD>
													<TD><div class="input text "><label id="" for="StationKey1Featval">&nbsp;</label>&nbsp;</div></TD>
												</tr>
										
											</table>
										</TD>
                   				<?php $text_other=1;}
			                     }
	                   			if(!$text_other){?>
	                   			
	                   				<TD style="width:65%">
										<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
											<tr>
												<TD><div class="input text "><label for="StationKey1Featval">&nbsp;</label><input class="numeric_check" type="text" size="13"></div></TD>
												<TD><div class="input text"><label id="" for="StationKey1Featval">&nbsp;</label>&nbsp;</div></TD>
											</tr>
									
										</table>
									</TD>
	                   			
	                   			<?php }
	                   			}?>
					</TR>

				<?php $j++; }
			}?>
		</TABLE>
	
	</fieldset>
	
	
	
	<div class="cb fl">
		<a id="clickMe" class="clickMe" onclick="javascript:show_exp_link('1');">EXPANSION MODULE  1</a>
	</div>
	<div class="fl" style="width:100px;" onclick="javascript:show_exp_link('1');">
		<div id="btn_1" class="fl expandButton">&nbsp;</div>
		<input type="hidden" value="0" id="show_link_hide_1">
	</div>
	<div class="cb"></div>
 <?php $n	=	$stationinfo[0]['Station']['extensions'];
 	$stationinfo[0]['Station']['extensions'];
 	for($k=1;$k<=$n;$k++){
 ?>
  <div id="show_expansion_<?php echo $k?>" style="display:none">
	<fieldset>
		<legend>EXPANSION MODULE KEY DATA</legend>
	
		<TABLE class="phone-key">
			<TR>
				<TH><p><?php __("keyid")?></p></TH>
				<TH><p><?php __("config")?></p></TH>
				<TH><p><?php __("possible modi")?></p></TH>
				<TH><p><?php __("feature values")?></p></TH>
			</TR>
			<?php $j=0; 
			foreach($stationinfo as $data){
           		if($j>$k*12 && $j<($k*12)+12 ){
           	?>
					<TR>
						<td>
							<div class="buttons"> <p><?php echo $data['Stationkey']['number']?></p> </div>
						</td>
						
						<TD>
						 <?php 
		                    	if(isset($data['Feature'][0]['short_name']) && isset($data['Feature'][0]['value']))
		                   	 			echo  $data['Feature'][0]['short_name'] .' : '.$data['Feature'][0]['value'].'<br>';
	       	 					if( isset($data['Feature'][1]) ){
		               	 	?>
		               	 	<a href="javascript:void(null);" onclick="javascript:show_hide('<?php echo $data['Stationkey']['number']?>');">Show/hide</a>
		                    <?php }?>
		               	 	<div id="config_<?php echo $data['Stationkey']['number']?>" style="display:none">
			                   <?php 
			                     $i=0;
			                     foreach($data['Feature'] as $feat){
			                     	if($i!=0)
			                 		{
		                 			
			                			if(isset($feat['short_name']) && isset($feat['value']))
			                			{
			        						echo '<a class="hide_color" href="#" title="'.__($feat['short_name']).'">'.$feat['short_name'].'</a><br>';
			            				}
	                 					
			                   		 }	
			                      $i++;
			                    
			                    }
			                    ?>
							</div>
						<TD>
							<?php
	                    	$set_val	=0;
							
	                    	if(isset($data['Feature'][0]['short_name'])){
	                    		if($data['Feature'][0]['short_name']=='DN' || $data['Feature'][0]['short_name']=='MADN'){
	                    			$set_val=1;
	                    	?>
	                    	DISPLAY NAME<br><br>LANGUAGE<br><br>BARRING SET
	                	<?php } }
	                		if(!$set_val){
	                			$aud_exi=0;
	                		      foreach($data['Feature'] as $featu){ 
	                		      	
	                		      	if($featu['short_name']=='AUD'){
	                		      		$aud_exi=1;
	                		      	}
	                		      }
        		      	?> 
							<select id="data_sel[<?php echo $data['Stationkey']['id']?>]" name="data_sel[<?php echo $data['Stationkey']['id']?>]" style="width:75px;" onchange="javascript:clearValuetxt('mod_text_<?php echo $data['Stationkey']['number']?>');">
                			<option></option>	
							<option value="AUD" <?php if($aud_exi){?> selected="selected"<?php }?> >AUD</option>
                				<option value="BLF">BLF</option>
               				 </select>
	                	<?php }?>
						</TD>
						
						 <?php $set_text=0;
                   			if(isset($data['Feature'][0]['short_name'])){
	                    		if($data['Feature'][0]['short_name']=='DN' || $data['Feature'][0]['short_name']=='MADN'){
	                    			$set_text=1;
	                    	?>
		                    	<TD>
									<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
										<tr>
											<TD><div class="input text"><label for="StationKey1Featval">&nbsp;</label><input type="text" size="13" id="mod_text_<?php echo $data['Stationkey']['number']?>" name="data[<?php echo $data['Feature'][1]['id']?>]" value="<?php echo $data['Feature'][1]['value']?>"></div></TD>
											<TD><div class="input text"><label for="StationKey1Featval">&nbsp;</label></div></TD>
										</tr>
										<tr>
											<TD>
												<div class="input text"><label for="StationKey1Featval">&nbsp;</label>
													<select id="data[<?php echo $data['Feature'][2]['id']?>]" name="data[<?php echo $data['Feature'][2]['id']?>]">
														<option value="EN" <?php if($data['Feature'][2]['value']=='EN'){?> selected="selected"<?php }?> >AUD</option>
						                				<option value="FR" <?php if($data['Feature'][2]['value']=='FR'){?> selected="selected"<?php }?> >FR</option>
						                				<option value="DE" <?php if($data['Feature'][2]['value']=='DE'){?> selected="selected"<?php }?> >DE</option>
						               				 </select>
					               				 </div>
				               				 </TD>
											<TD><div class="input text"><label for="StationKey1Featval">&nbsp;</label></div></TD>
										</tr>	
										<tr>
											<TD>
												<div class="input text"><label for="StationKey1Featval">&nbsp;</label>
													<select id="data[<?php echo $data['Feature'][3]['id']?>]" name="data[<?php echo $data['Feature'][3]['id']?>]">
													<?php for($i=1;$i<=10;$i++){?>
														<option value="Set <?php echo $i?>" <?php if($data['Feature'][3]['value']=='Set'.$i){?> selected="selected"<?php }?>>Set <?php echo  $i?></option>
						               				<?php }?>
													 </select>
												</div>							
											</TD>
											<TD><div class="input text"><label for="StationKey1Featval">&nbsp;</label></div></TD>
										</tr>
									</table>
								</TD>
							<?php }
                   			}if(!$set_text){
								  $i=0;$text_other=0;
			                     foreach($data['Feature'] as $feat){
			                     	
		                 			if($feat['short_name']	=='AUD'){?>
		                   				<TD>
											<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
												<tr>
													<TD><div class="input text"><label for="StationKey1Featval">&nbsp;</label><input id="data[<?php echo $feat['id']?>]" name="data[<?php echo $feat['id']?>]" type="text" value="<?php echo $feat['value']  ?>" size="13"></div></TD>
													<TD><div class="input text"><label for="StationKey1Featval">&nbsp;</label>&nbsp;</div></TD>
												</tr>
										
											</table>
										</TD>
                   				<?php $text_other=1;}
			                     }
	                   			if(!$text_other){?>
	                   			
	                   				<TD style="width:65%">
										<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
											<tr>
												<TD><div class="input text"><label for="StationKey1Featval">&nbsp;</label><input type="text" size="13"></div></TD>
												<TD><div class="input text"><label for="StationKey1Featval">&nbsp;</label>&nbsp;</div></TD>
											</tr>
									
										</table>
									</TD>
	                   			
	                   			<?php }
	                   			}?>
					</TR>
				
				<?php  }$j++;
			}?>
		</TABLE>

	</fieldset>
	<?php if($k!=$stationinfo[0]['Station']['extensions']){?>
	<div class="cb fl">
		<a id="clickMe" class="clickMe"  onclick="javascript:show_exp_link('<?php echo $k+1?>');">EXPANSION MODULE  <?php echo $k+1?></a>
	</div>
	<div class="fl" style="width:100px;" onclick="javascript:show_exp_link('<?php echo $k+1?>');">
		<div id="btn_<?php echo $k+1?>" class="fl expandButton">&nbsp;</div>
		<input type="hidden" value="0" id="show_link_hide_<?php echo $k+1?>">
	</div>
	<div class="cb"></div>
		<?php }?>
	
	</div>
	
	<?php }?>
	
	</form>
</div>
	
	
