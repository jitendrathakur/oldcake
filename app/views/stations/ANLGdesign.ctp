<?php 

//echo $javascript->link('/js/jquery-1.10.1.min');
echo $javascript->link('/js/jquery.fancybox');
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
</script>
	

<link rel="stylesheet" href="//google-code-prettify.googlecode.com/svn/trunk/src/prettify.css" type="text/css"/>
<script type="text/javascript" src="//google-code-prettify.googlecode.com/svn/trunk/src/prettify.js"></script>
<script type="text/javascript"> 
    $(document).ready(function() { //alert("ret");
        $('#dragdroptbl').tableDnD({ 
            onDragStart: function(table, row) { 
                //$(table).parent().find('.result').text('');
            }, 
            onDrop: function(table, row) {
				var rows = table.tBodies[0].rows; alert(rows);
                $('#AjaxResult').load(base_url+"stations/design?"+$.tableDnD.serialize());
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
                $('#AjaxResult').load(base_url+"stations/design?"+$.tableDnD.serialize());
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
<div class="block top">

<h4>station Header</h4>
<div class="button-right">
		<?php echo $html->link( __('deleteStation', true),  array('controller'=> 'stations', 'action'=>'deleteStation',$statId),array('onmouseover'=>'javascript:hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
</div>	
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
			
	
			<div class="form-box">
				<div class="form-left">
					<?php echo $form->input('station_id', array('value'=>$stationDetails[0]['Station']['id'], 'style'=>'width:200px;')); ?>			
		
				</div>
				<div class="form-right">
					<?php echo $form->input('status', array('value'=>$stationDetails[0]['Station']['status'], 'style'=>'width:200px;')); ?>			
				</div>
				<div class="form-left">
						<?php echo $form->select('phone_type', $phoneTypes,$stationDetails[0]['Station']['phone_type'],array('style'=>'width:200px;','onchange'=>"javascript:submi_form('updateBase');")); ?>			
				</div>
				<div class="form-right">
					<?php 
						# Show the selectableport if the station is ANLG and status -== 6
							if ($stationDetails[0]['Station']['type'] == 'CICM')
							{
								echo $form->input('port', array('value'=>'AUTOSECLECT', 'style'=>'width:200px;')); 
							}
							elseif($stationDetails[0]['Station']['type'] == 'ANLG')
							{
								
								echo $form->select('port', $ports,$stationDetails[0]['Station']['port'],array('style'=>'width:200px;','onchange'=>"javascript:submi_form('updateBase');"));			
							}

							 
						?>			
				</div>
			</div>

		</div>
		
	
	<?php 
	
}
else { # Else The station is not status 6
	 ?>


	<!--CBM ADDED BUTTONS TO TOP-->
			
			<div class="form-box">
				<div class="form-left">
					<?php echo $form->input('phoneId', array('value'=>$stationDetails[0]['Station']['id'], 'style'=>'width:200px;')); ?>			
		
				</div>
				<div class="form-right">
					<?php echo $form->input('status', array('value'=>$stationDetails[0]['Station']['status'], 'style'=>'width:200px;')); ?>			
				</div>
			</div>
			<div class="form-box">
				<div class="form-left">
					<?php 
						#echo $form->select('phone_type', $phoneTypes,$stationDetails[0]['Station']['phone_type'],array('style'=>'width:200px;','onchange'=>"javascript:submi_form('filters');")); 		
						echo $form->input('phone_type', array('value'=>$stationDetails[0]['Station']['phone_type'], 'style'=>'width:200px;'));
					?>
				</div>
				<div class="form-right">
					<?php 
					# Show the selectableport if the station is ANLG and status -== 6

								echo $form->input('port', array('value'=>$stationDetails[0]['Station']['port'], 'style'=>'width:200px;'));
							 
						?>			
				</div>
			</div>
		
<?php  
} #end of status != 6

echo $form->end(); 
			
if($stationDetails[0]['Station']['status'] != 6){ 


echo $form->create('Station', array(
				'action' => 'design',
				'id' => 'filters',
				'class' => 'filtersForm',
				'type' => 'GET'
));
?>
<div class="cb">

 	


<h4>Station features</h4>
        
        <div class="form-box">
				<div class="form-left">
					<?php if(array_key_exists('COMBOX', $stationFeatures))
					{
						echo $form->input('combox', array('value'=>$stationFeatures['COMBOX'], 'type'=>'checkbox', 'checked'=>($stationFeatures['COMBOX'] == '1' ? TRUE : FALSE)));			
					}
					else
					{
						echo '<p></p>';
					}
					?>
				</div>
				<div class="form-right">
				<?php if(array_key_exists('MOH', $stationFeatures))
					{
						echo $form->input('moh', array('value'=>$stationFeatures['MOH'], 'type'=>'checkbox', 'checked'=>($stationFeatures['MOH'] == '1' ? TRUE : FALSE)));		
					}
					else
					{
						echo '<p></p>';
					}
					?>
				</div>
		</div>
		<div class="form-box">
				<div class="form-left">
					<?php if(array_key_exists('SIMRING', $stationFeatures))
					{
						echo $form->input('Simring', array('value'=>$stationFeatures['SIMRING'], 'type'=>'checkbox','checked'=>($stationFeatures['SIMRING'] == '1' ? TRUE : FALSE)));				
					}
					else
					{
						echo '<p></p>';
					}
					?>
				</div>
				<div class="form-right">
					<?php if(array_key_exists('CFRA', $stationFeatures))
					{
						echo $form->input('cfra', array('value'=>$stationFeatures['CFRA'], 'type'=>'checkbox', 'checked'=>($stationFeatures['CFRA'] == '1' ? TRUE : FALSE)));				
					}
					else
					{
						echo '<p></p>';
					}
					?>
				</div>
		</div>
		<div class="form-box">
				<div class="form-left">
					<?php if(array_key_exists('CWT', $stationFeatures))
					{
						echo $form->input('cwt', array('value'=>$stationFeatures['CWT'], 'type'=>'checkbox', 'checked'=>($stationFeatures['CWT'] == '1' ? TRUE : FALSE)));				
					}
					else
					{
						echo '<p></p>';
					}
					?>
				</div>
				<div class="form-right">
					<?php if(array_key_exists('CTI', $stationFeatures))
					{
						echo $form->input('cti', array('value'=>$stationFeatures['CTI'], 'type'=>'checkbox', 'checked'=>($stationFeatures['CTI'] == '1' ? TRUE : FALSE)));			
					}
					else
					{
						echo '<p></p>';
					}
					?>
				</div>
		</div>
		
			
<h4>Station Parameters</h4>
        
        <div class="form-box">
				<div class="form-left">
					<?php echo $form->input('sim1', array('value'=>$stationFeatures['SIMRINGMEMBER1'], 'style'=>'width:200px;')); ?>			
		
				</div>
				<div class="form-right">
					<?php echo $form->input('sim2', array('value'=>$stationFeatures['SIMRINGMEMBER2'], 'style'=>'width:200px;')); ?>			
				</div>
			</div>
			<div class="form-box">
				<div class="form-left">
					<?php echo $form->input('sim3', array('value'=>$stationFeatures['SIMRINGMEMBER3'], 'style'=>'width:200px;')); ?>
				
				</div>
				<div class="form-right">
	
						<?php echo $form->input('sim4', array('value'=>$stationFeatures['SIMRINGMEMBER4'], 'style'=>'width:200px;')); ?>
	
				</div>
			</div>

<div class="block" style="margin: 0px;">
			<div class="button-right">
					<a href="javascript:submitForm()"  onclick="" name="submitForm" value="submitForm" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php
__("Submit");
					?></a>
			</div>
			<div class="button-right">
						<?php echo $html->link( __('resetFeatures', true),  array('controller'=> 'stations', 'action'=>'resetFeature',$statId),array('onmouseover'=>'javascript:hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
            </div>
			<div class="button-right">
						<?php
				echo $html->link(__('edit', true), array(
    			'controller' => 'stations',
    			'action' => 'edit',
    			$statId
				), array(
  		 	 	'onmouseover' => 'javascript:hoverButtonRight(this);',
    			'onmouseout' => 'javascript:outButtonRight(this);',
				'class' => 'fancybox fancybox.ajax'
				));
				?>
        	</div>
        	<div class="button-right">
						<?php
				echo $html->link(__('undo', true), array(
   				 'controller' => 'stations',
 				   'action' => 'design',
 				   $statId
				), array(
   				 'onmouseover' => 'javascript:hoverButtonRight(this);',
   				 'onmouseout' => 'javascript:outButtonRight(this);'
				));
				?>
				<div class="button-right">
					  <?php echo $html->link( __("Add DN", true),array('controller'=>'dns','action'=>'selectdns','station_id:'.$statId . '&type=singleLogic'),array('onmouseover'=>'javascript:hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);','class'=>'opencolorbox')); ?>
				</div>
        	</div>
      </div>
      
       	<h4>key features</h4>
       	
       	
      <?php
		   
	// check $stationFeatures variable exists and is not empty
	if (isset($keyFeatures) && !empty($keyFeatures)):
	?>
	    <div id="" class="table-content main_table_content">
		<div id="AjaxResult" style="display:none; float: right; width: 250px; border: 1px solid silver; padding: 4px; font-size: 90%">
		</div>
		<table class="phonekey stationtbl">
			  <?php
    // initialise a counter for striping the table
    $stationAry = array(); //echo "<pre/>"; print_r($stationFeatures); die;
    for ($i = 0; $i < 54; $i++) { //echo "<pre/>"; print_r($stationFeatures[$i]); 
        $stationAry = $keyFeatures[$i];
        //foreach($stationFeatures as $station):
        // stripes the table by adding a class to every other row
        $class      = (($i % 2) ? " class='altrow'" : '');
        // increment count
        //$count++;
	?>
				<tr style="height:23px;">
					<td  style="width: 20px;"> <?php 
		$sta_id = str_pad($i+1, 2, '0', STR_PAD_LEFT);
      /*    if (isset($stationAry) && !empty($stationAry['Feature']['id'])) {
            $station_id = explode('@', $stationAry['Feature']['id']);
            $sta_id     = str_pad($station_id[0], 2, '0', STR_PAD_LEFT);
        } else {
            $sta_id = str_pad($sta_id + 1, 2, '0', STR_PAD_LEFT);
        }  */
        echo $form->input("key['$sta_id']", array(
            'type' => 'hidden',
            'value' => $sta_id
        ));
        echo $sta_id;
	?></td>
				</tr>
				<?php
    } //endforeach; 
	?>
		</table>
		<table class="phonekey stationtb2" id="dragdroptbl">
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
	foreach($keyFeatures as $k=>$v){ 
		$station_id = explode('@', $v['Feature']['id']); 
		$sta_id_key    = str_pad($station_id[0], 2, '0', STR_PAD_LEFT);
		$finalAry[$sta_id_key] = $v;
		
	} 
    for ($j = 0; $j < 54; $j++) {
        $stationArray = $keyFeatures[$j]; //$setHeight = "";
		$sta_id = str_pad($j+1, 2, '0', STR_PAD_LEFT);
        $class        = (($j % 2) ? " class='altrow'" : '');
      if (isset($finalAry) && !empty($finalAry[$sta_id]['Feature']['id'])) {
            $station_id = explode('@', $finalAry[$sta_id]['Feature']['id']);
            $sta_id_key    = str_pad($station_id[0], 2, '0', STR_PAD_LEFT);
        } 
            // $setHeight  = 'height:21px';										
        
        
?>
					
			       <!-- <tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">-->
			        <tr style="cursor:move;height:23px;" onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false); " id="<?php
        echo $sta_id;
?>" >
					<td>
	                		<?php
		$shortName = "";
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
			$statKey = $sta_id  . '@' . $statId;
			echo $html->link($shortName, array(
			'controller' => 'features',
			'action' => 'edit',
			"stationkey_id:$statKey&featureType=$shortName"), array(
			'class' => $selected['DN List'] . " opencolorbox"
			));
		}
?>
					</td>
	                <td>
	        <?php
		$DNID = "";
		if($sta_id_key==$sta_id){
			$DNID = $finalAry[$sta_id]['Feature']['primary_value'];
		}
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
        echo $html->link($finalAry[$sta_id]['Feature']['primary_value'], array(
            'controller' => 'dns',
            'action' => 'selectdns',
            "customer_id:$customer_id&type=single&update=$DNID"
        ), array(
            'class' => $selected['DN List'] . " opencolorbox"
        ));
		}
?>
	                </td>
					<td class="table-right" style="background: url(<?php
        echo $this->webroot;
?>/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat 3px 5px;border-style: none;"   onmouseover="this.className='table-right-over';" onmouseout="this.className='table-right';">
							<div class="table-menu">
                    			<div class="table-menu-popup" style="z-index: 1">
                    				<ul>
									<?php if(empty($DNID)){ ?>
									<li class="script">
									<?php
        echo $html->link(__('Add DN', true), array(
            'controller' => 'dns',
            'action' => 'selectdns',
            "customer_id:$customer_id&type=single&add=$sta_id"
        ), array(
            'class' => $selected['DN List'] . " opencolorbox"
        ));
?>
									</li> <?php }else{ ?>
									<li class="script">
									<?php
										echo $html->link(__('Add DN', true), array(
												'controller' => 'dns',
												'action' => 'selectdns',
												"customer_id:$customer_id&type=single&replace=$DNID@$sta_id"
											), array(
												'class' => $selected['DN List'] . " opencolorbox"
											));
									?>
									</li> 
									<?php } ?>
									<?php if(!empty($DNID)){ ?>
									<li class="last log">
									<?php
        echo $html->link(__('Delete', true), 'javascript:del_dn("' . $DNID . '@' . $sta_id . '")');
	?>
									</li>
									<?php } ?>
                    				</ul>
                    			</div>
							</div>
					</td>
	            	<?php
    } //endforeach; 
	?>
	            	</tr>
				 </tbody>	 
		</table>
		    <div class="result"></div>
	    <?php
    echo $form->end();
	?>
	<?php //echo $this->element('pagination/newpaging'); 
	?>
	</div>
	    </div>
	   
	    <?php
	else:
    	__("No Dns available in DB");
    	echo '</div>';
	endif;
} # End of key features, station != 6
?>
</div>
</div>
</div>
