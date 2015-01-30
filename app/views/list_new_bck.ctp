<?php	$feature	=	array();$i=0;
//	foreach($stationinfo as $data){
//		foreach($data['Feature'] as $feat){
//			if($feat['short_name']=='DN' || $feat['short_name']=='MADN'){
//				
//				$feature[$i]['type']	=	'DN-MADN';
//				$feature[$i]['name']	=	$feat['short_name'];
//				$feature[$i]['value']	=	$feat['value'];
//			}elseif($feat['short_name']=='AUD'){
//				$feature[$i]['type']	=	'AUD';
//				$feature[$i]['name']	=	$feat['value'];
//			}$i++;
//		}
//	 
//	}echo "<pre>";print_r($feature);die();
?>




<div class="stations form"  >	
	<!--form tag starts-->
	<form id="StationEditForm" method="post" action="<?php echo  'http://192.168.0.170/selfcare/stations/edit/'.$stationinfo[0]['Station']['id'];?>">
	

	<div class="station_subcontainer">
		<div class="fl" style="width:100px;">
   			<input style="height:24px;" type="submit" name="validate" id="valiadte" value="Validate"/>
   		</div>
    </div>
    <div class="cb">&nbsp;</div>
   <div class="fl cb" style="width:150px;font-size:.7em;"> <?php __("station_data")?> <?php echo $stationinfo[0]['Station']['number']?></div>
	<div class="cb station_subcontainer_val" style="padding-left:21px;">
   		<div class="station_innersub">
        	<div class="fl" style="width:84px;"> Password</div>
            <div class="fl" style="width:135px;"><input type="password" size="13" value="<?php echo $location['Station']['password']?>" /></div>
            <div class="fl" style="width:75px;"> Location</div>
            <div class="fl" style="width:100px;">
            <label><?php echo $location['Location']['name']?></label>
            </div>
            <div class="fl" style="width:200px;">
				<lablel for="station_type"> Type : </label>
					<select name="station_type" id="station_type">
						<option value="1120" >1120</option>
						<option value="1140" >1140</option>
					</select>
			</div>
        </div>
    </div>
    <div>&nbsp;</div>
    
    <div class="station_subcontainer">
          <div style="width:615px;">
                <div class="station_listContainer">
                    <div align="center" class="fl wht_color" style="width:62px;"><?php __("keyid")?></div>
                    <div align="center" class="fl wht_color"style="width:120px;"><?php __("config")?></div>
                    <div align="center" class="fl wht_color" style="width:109px;"><?php __("possible modi")?></div>
                    <div align="center" class="fl wht_color"style="width:292px;"><?php __("feature values")?></div>
                     <div class="cb">&nbsp;</div>
                 </div>
               <?php $j=0; foreach($stationinfo as $data){
               		if($j<12){
               	?>
                <div align="center" class="station_itemContainer">
                    <div class="fl" style="width:62px;"><label><?php echo $data['Stationkey']['number']?></label></div>
                    <div class="fl station_itemvalue">
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
	                 			if($feat['short_name']!='DISPLAYNAME'){
                 					if($feat['short_name']!='DRING'){
                 						if($feat['short_name']!='BARRINGSET'){
				                			if(isset($feat['short_name']) && isset($feat['value']))
				                			{
				        						echo '<a class="hide_color" href="#" title="lang for '.$feat['short_name'].'">'.$feat['short_name'].'</a><br>';
				            				}
                 						}
                 					 }
		                 			}
		                   		 }	
		                      $i++;
		                    
		                    }
		                    ?>
		                    <input type="hidden" id="hide" value="0">
	                    </div>&nbsp;
                    </div>
                    <div class="fl station_itemvalue" style="width:187px;">
	                    <?php
	                    	$set_val	=0;
							
	                    	if(isset($data['Feature'][0]['short_name'])){
	                    		if($data['Feature'][0]['short_name']=='DN' || $data['Feature'][0]['short_name']=='MADN'){
	                    			$set_val=1;
	                    	?>
	                    	DISPLAY NAME,<br><br><br>
	                    	LANGUAGE,<br>
	                    	BARRING SET<br>
	                	<?php } }
	                		if(!$set_val){
	                			$aud_exi=0;
	                		      foreach($data['Feature'] as $featu){ 
	                		      	
	                		      	if($featu['short_name']=='AUD'){
	                		      		$aud_exi=1;
	                		      	}
	                		      }
        		      	?>         		

	                		<select id="modifies_<?php echo $data['Stationkey']['number']?>" style="width:75px;" onchange="javascript:clearValuetxt('mod_text_<?php echo $data['Stationkey']['number']?>');">
                				<option>BLF</option>
                				<option <?php if($aud_exi){?> selected="selected"<?php }?> >AUD</option>
               				 </select>
	                	<?php }?>
                    </div>
                    <div style="float:left;width:240px;">
                       <?php $set_text=0;
                   			if(isset($data['Feature'][0]['short_name'])){
	                    		if($data['Feature'][0]['short_name']=='DN' || $data['Feature'][0]['short_name']=='MADN'){
	                    			$set_text=1;
	                    	?>
                    	<div align="center"  class="fl station_itemvalue" style="width:90px;">
                    		<div class="fl">
                    			Display Name
                    		</div>
                    		<div class="cb ">&nbsp;</div>
                    		<div class="cb heig_18">&nbsp;</div>
                    		<div>
                    			PHONE LANG
                    		</div>
                    		<div class="cb heig_18">&nbsp;</div>
                    		<div>
                    			BARRING SET
                    		</div>
                    	</div>
                    	<div class="fl station_itemvalue" style="width:130px;">
                    		<div>
                    			<input type="text" size="13" id="data[<?php echo $data['Feature'][1]['id']?>]" name="data[<?php echo $data['Feature'][1]['id']?>]" value="<?php echo $data['Feature'][1]['value']?>">
                    		</div>
                    		<div>
                    			&nbsp;
                    		</div>
                    		
                    		<div>
                    			<input type="text" size="13" id="data[<?php echo $data['Feature'][2]['id']?>]" name="data[<?php echo $data['Feature'][2]['id']?>]" value="<?php echo $data['Feature'][2]['value']?>">
                    		</div>
                    			<br>
                    		<div>
                    			<input type="text" id="data[<?php echo $data['Feature'][3]['id']?>]" name="data[<?php echo $data['Feature'][3]['id']?>]" size="13" value="<?php echo $data['Feature'][3]['value']?>">
                    		</div>
                    	</div>
                	<?php }}
                	if(!$set_text){?>
                			 <?php 
		                     $i=0;$text_other=0;
		                     foreach($data['Feature'] as $feat){
		                     	
	                 			if($feat['short_name']	=='AUD'){?>
	        							<div class="fl"><input id="data[<?php echo $feat['id']?>]" name="data[<?php echo $feat['id']?>]" type="text" value="<?php echo $feat['value']  ?>" size="13"></div>
				            			
		                 		<?php $text_other=1;	}
		                    
		                    }
		                    if(!$text_other){?>
		                    	<div class="fl">
		                    		<input type="text" value="" size="13">
		                    	</div>
		                  <?php  }
		                    ?>
								
            		<?php }?>
                    </div>
                </div>
                <?php $j++;
               		}
               		}?>
             </div>
           </div>  
      </div>
		<?php for($k=0;$k<=$stationinfo[0]['Station']['extensions'];$k++){?>
	    <div class="cb">
	  	 <a id="clickMe" style="color:blue;cursor:pointer" onclick="javascript:show_exp_link('<?php echo $stationinfo[0]['Station']['extensions']?>');">SHOW/HIDE EXPANSION</a>
	   </div><input type="hidden" value="0" id="show_link_hide_<?php echo $stationinfo[0]['Station']['extensions']?>">
		<div id="show_expansion" style="display: none">
		
		<div class="station_subcontainer">
		 <div style="width:615px;">
	                <div class="station_listContainer">
	                    <div align="center" class="fl wht_color" style="width:62px;"><?php __("keyid")?></div>
	                    <div align="center" class="fl wht_color"style="width:120px;"><?php __("config")?></div>
	                    <div align="center" class="fl wht_color" style="width:109px;"><?php __("possible modi")?></div>
	                    <div align="center" class="fl wht_color"style="width:292px;"><?php __("feature values")?></div>
	                     <div class="cb">&nbsp;</div>
	                 </div>
	               <?php $j=0;foreach($stationinfo as $data){
	               		if($j>$k*12 && $j<(($k*24)+12)){
	               	?>
	                <div align="center" class="station_itemContainer">
	                    <div class="fl" style="width:62px;"><label><?php echo $data['Stationkey']['number']?></label></div>
	                    <div class="fl station_itemvalue">
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
		                 			if($feat['short_name']!='DISPLAYNAME'){
	                 					if($feat['short_name']!='DRING'){
	                 						if($feat['short_name']!='BARRINGSET'){
					                			if(isset($feat['short_name']) && isset($feat['value']))
					                			{
					        						echo '<a class="hide_color" href="#" title="lang for '.$feat['short_name'].'">'.$feat['short_name'].'</a><br>';
					            				}
	                 						}
	                 					 }
			                 			}
			                   		 }	
			                      $i++;
			                    
			                    }
			                    ?>
			                    <input type="hidden" id="hide" value="0">
		                    </div>&nbsp;
	                    </div>
	                    <div class="fl station_itemvalue" style="width:187px;">
		                    <?php
		                    	$set_val	=0;
								
		                    	if(isset($data['Feature'][0]['short_name'])){
		                    		if($data['Feature'][0]['short_name']=='DN' || $data['Feature'][0]['short_name']=='MADN'){
		                    			$set_val=1;
		                    	?>
		                    	DISPLAY NAME,<br><br><br>
		                    	LANGUAGE,<br>
		                    	BARRING SET<br>
		                	<?php } }
		                		if(!$set_val){
		                
		                			$aud_exi=0;
		                		      foreach($data['Feature'] as $featu){ 
		                		      	
		                		      	if($featu['short_name']=='AUD'){
		                		      		$aud_exi=1;
		                		      	}
		                		      }
	        		      	?>         		
	
		                		<select id="modifies_<?php echo $data['Stationkey']['number']?>" style="width:75px;" onchange="javascript:clearValuetxt('mod_text_<?php echo $data['Stationkey']['number']?>');">
	                				<option>BLF</option>
	                				<option <?php if($aud_exi){?> selected="selected"<?php }?> >AUD</option>
	               				 </select>
		                	<?php }?>
	                    </div>
	                    <div style="float:left;width:240px;">
	                       <?php $set_text=0;
	                   			if(isset($data['Feature'][0]['short_name'])){
		                    		if($data['Feature'][0]['short_name']=='DN' || $data['Feature'][0]['short_name']=='MADN'){
		                    			$set_text=1;
		                    	?>
	                    	<div align="center"  class="fl station_itemvalue" style="width:90px;">
	                    		<div class="fl">
	                    			Display Name
	                    		</div>
	                    		<div class="cb ">&nbsp;</div>
	                    		<div class="cb heig_18">&nbsp;</div>
	                    		<div>
	                    			PHONE LANG
	                    		</div>
	                    		<div class="cb heig_18">&nbsp;</div>
	                    		<div>
	                    			BARRING SET
	                    		</div>
	                    	</div>
	                    	<div class="fl station_itemvalue" style="width:130px;">
	                    		<div>
	                    			<input type="text" size="13" value="<?php echo $data['Feature'][1]['value']?>">
	                    		</div>
	                    		<div>
	                    			&nbsp;
	                    		</div>
	                    		
	                    		<div>
	                    			<input type="text" size="13" value="<?php echo $data['Station']['lang']?>">
	                    		</div>
	                    			<br>
	                    		<div>
	                    			<input type="text" size="13" value="<?php echo $data['Feature'][3]['value']?>">
	                    		</div>
	                    	</div>
	                	<?php }}
	                	if(!$set_text){?>
	                		<?php 
			                     $i=0;$text_other=0;
			                     foreach($data['Feature'] as $feat){
			                     	
		                 			if($feat['short_name']	=='AUD'){?>
		        							<div class="fl"><input id="mod_text_<?php echo $data['Stationkey']['number']?>" type="text" value="<?php echo $feat['value']  ?>" size="13"></div>
					            			
			                 		<?php $text_other=1;	}
			                    
			                    }
			                    if(!$text_other){?>
			                    	<div class="fl">
			                    		<input type="text" value="" size="13">
			                    	</div>
			                  <?php  }
			                    ?>
	            		<?php }?>
	                    </div>
	                </div>
	                <?php }
	                	$j++;
	               }?>
	             </div>
	             </div>
           </div>  
           <?php }?>
      </div>
    </div>
	
	</div>
    	
      </div>  
    </div>
    
    
	</form>
	<!--form tag ends-->
	
</div>