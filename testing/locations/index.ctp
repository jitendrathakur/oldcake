<style>
.spclWidth_tooltop{
	width:250px !important;
}
</style>

<div class="block top">
<?php 
if(isset($_SESSION['success_msg'])){
	$success =  __($_SESSION['success_msg'],true);
	unset($_SESSION['success_msg']);
	
}


 ?>
 
<?php if((isset($success)) && $success){?>

		<div class="notification first" style="width: 534px" >

			<div class="ok">
				<div class="message">
					<?php echo $success;?>
				</div>
			</div>
		</div>

	<?php } ?>




    <?php
    echo $javascript->link('/js/jquery.fancybox');
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.fancybox').fancybox();
        });
    </script>
    <?php
    #For pagination reasons to handle sort and filter
   #$paginator->options(array('url' => $this->passedArgs));
  # echo "<pre>";print_r($this->passedArgs);
   $paginator->options(array('url' => array('lbl' => $this->passedArgs['lbl'], 'name' => $this->passedArgs['name'], 'plz' => $this->passedArgs['plz'], 'address' => $this->passedArgs['address'], 'emergency' => $this->passedArgs['emergency'])));
    echo $form->create('Location', array('action' => 'index/' . $SELECTED_CNN, 'id' => 'filters', 'type' => 'GET'));
    ?>
    <div class="cb">
        <div id="" class="table-content">
            <table class="phonekey dataTable">
                <thead>
                    <tr class="table-top">			
                       <!-- <th class="table-column table-left-ohne" style="width:20px;">&nbsp;</th>-->					
                        <th class="table-column" style="width:152px;">&nbsp;<span><?php echo $paginator->sort(__("locationName"), 'name', $filter_options); ?></span></th>
                        <th class="table-column" style="width:249px;"><span><?php __("Address"); ?></span></th>
						<th class="table-column" style="width:50px;"><span><?php __("zip"); ?></span></th>
                        <th class="table-column" style="width:80px;"><span><?php __("Emergency"); ?></span></th>
                        <!--<th class="table-right-ohne">&nbsp;</th>-->						
                    </tr>
                    <tr>
                        <!--<td class="table-column table-left-ohne">&nbsp;</td>-->
                        <td><?php echo $form->input('name', array('label' => false, 'type' => 'text', 'class' => 'filter-class onclick', 'style' => 'width:141px;', 'value' => (isset($this->params['named']['name']) ? $this->params['named']['name'] : (isset($this->params['url']['name']) ? $this->params['url']['name'] : '')))); ?></td>
						 <td><?php echo $form->input('address', array('label' => false, 'type' => 'text', 'class' => 'filter-class onclick', 'style' => 'width:233px;', 'value' => (isset($this->params['named']['address']) ? $this->params['named']['address'] : (isset($this->params['url']['address']) ? $this->params['url']['address'] : '')))); ?></td>
                        <td><?php echo $form->input('zip', array('label' => false, 'type' => 'text', 'class' => 'filter-class onclick', 'style' => 'width:40px;', 'value' => (isset($this->params['named']['zip']) ? $this->params['named']['zip'] : (isset($this->params['url']['zip']) ? $this->params['url']['zip'] : '')))); ?></td>
                        <td><?php echo $form->input('emergency', array('label' => false, 'type' => 'text', 'class' => 'filter-class onclick', 'style' => 'width:68px;', 'value' => (isset($this->params['named']['emergency']) ? $this->params['named']['emergency'] : (isset($this->params['url']['emergency']) ? $this->params['url']['emergency'] : '')))); ?></td>						
                       
                        <!--<td class="table-right-ohne">&nbsp;</td>-->
                    </tr>					
                </thead>
                <tbody>	
            </table>
        </div>
        <div class="block" style="margin: 0px;">              
         <!--  <div class="button-left">
           <?php
             echo $html->link(__('Location Details', true), array(
             'controller' => 'locations',
             'action' => 'index/customer_id:' . $SELECTED_CNN . '&' . 'type=detail'
              ), array('class' => 'fancybox fancybox.ajax'));
            ?>
          </div> -->
         </div>
         <div class="button-right">
			<a href="javascript:void(null)"  onclick="javascript:submi_form('filters');" name="data[filter]" value="filter" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __("filter");?></a>
		 </div>
		 <div class="button-left">
			<?php echo $html->link( __("reset", true),  array('controller'=> 'locations', 'action'=>'index', $SELECTED_CNN),array('onmouseover'=>'javascript:hoverButtonLeft(this);','onmouseout'=>'javascript:outButtonLeft(this);')); ?>
         </div>
         <div class="button-right">
            <?php echo $html->link( __("Export Csv", true),  array('controller'=> 'locations', 'action'=>'export'),array('onmouseover'=>'hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
        </div>
    </div>
    <div class="block" style="margin: 0px;"> 
	<?php
		
	if($locations[0]['Customer']['Info1']==0){		
	?>                    
           
		   <?php  $cust_type = $locations[0]['Customer']['type']; 
		   		if(($cust_type=="Gate") || ($cust_type=="Gate +")){
								
		   ?>
		    <div class="button-right">
                <?php
                echo $html->link(__('Add Location ', true), array(
                    'controller' => 'locations',
                    'action' => 'edit',
                    'create&customer_id=' . $SELECTED_CNN
                        ), array(
                    'onmouseover' => 'javascript:hoverButtonRight(this);',
                    'onmouseout' => 'javascript:outButtonRight(this);'
                ));
                ?>
        </div> 
		<?php } } //else { ?> 
		<!--<div class="button-right-disabled">
                <a href="javascript:;" id="addbutton"><?php echo __('Add Location ', true); ?></a>
        </div> -->
		<?php //} ?>   
<br/>
        <div id="" class="table-content">

            <?php
            // check $locations variable exists and is not empty
            //print_r($locations);
            if (isset($locations) && !empty($locations)) :
                ?>

                <!--CBM START HERE -->
                <div id="" class="table-content">
                    <?php echo $this->element('pagination/top'); ?>
      <table class="table-content phonekey">
       <thead>
        <tr class="table-top">
          <!--<th class="table-column table-left-ohne" style="width:20px;">&nbsp;</th>-->
  		 <?php
		   $url = $this->params['named']['direction'];
		   $url2 = $this->params['url']['url'];		   
		  if($url=="" && strlen($url2)>6 )
		    { 
			  #$filter_sort = array('0'=>'groups','1'=>'index','2'=>'Page:1','3'=>'customer_id:'.$SELECTED_CNN,'4'=>'sort:name','5'=>'direction:desc');
			  $urlfilter="locations/index/$SELECTED_CNN/page:1/sort:name/direction:desc";
			  ?>
			  <th class="table-column <?php echo 'sortlink_asc';?>" style="width:152px;text-align: left;"> <a id="sortlink" href="<?php echo Configure::read('base_url').$urlfilter; ?>"><?php echo __("locationName",true); ?></a></th>				
			  <?php 
		     }
			else
			 { ?>
			 <th  class="table-column <?php if (in_array('sort:name', $filter_sort) && in_array('direction:asc', $filter_sort)) echo 'sortlink_asc';elseif ((in_array('sort:name', $filter_sort) && in_array('direction:desc', $filter_sort))) echo 'sortlink_desc';
                    else echo 'sortlink'; ?>" style="width:152px;text-align: left;"><?php echo $paginator->sort(__("locationName", true), 'name', $filter_options); ?></th>
			<?php } ?>	
			
			  			   <!--<th  class="table-column " style="width:50px;text-align: left; padding-top:2px!important;" ><?php echo __("# of DN", true); ?></th>-->	
                           <!-- <th  class="table-column <?php if (in_array('sort:emergency', $filter_sort) && in_array('direction:asc', $filter_sort)) echo 'sortlink_asc';elseif ((in_array('sort:emergency', $filter_sort) && in_array('direction:desc', $filter_sort))) echo 'sortlink_desc';
                           else echo 'sortlink'; ?>" style="width:80px;text-align: left;"><?php echo $paginator->sort(__("Emergency", true), 'emergency', $filter_options); ?></th>
                           -->
             	  	<th  class="table-column <?php if (in_array('sort:address', $filter_sort) && in_array('direction:asc', $filter_sort)) echo 'sortlink_asc';elseif ((in_array('sort:address', $filter_sort) && in_array('direction:desc', $filter_sort))) echo 'sortlink_desc';
                    	else echo 'sortlink'; ?>" style="width:150px;text-align: left;"><?php echo $paginator->sort(__("Address", true), 'address', $filter_options); ?></th>	
 				  	<th class="table-column <?php if (in_array('sort:plz', $filter_sort) && in_array('direction:asc', $filter_sort)) echo 'sortlink_asc';elseif ((in_array('sort:plz', $filter_sort) && in_array('direction:desc', $filter_sort))) echo 'sortlink_desc';
                       	else echo 'sortlink'; ?>" style="width:50px;text-align: left;"><?php echo $paginator->sort(__("zip", true), 'plz', $filter_options); ?></th>	
					<th  class="table-column " style="width:80px;text-align: left;padding-top:2px!important;"><?php echo __("Emergency", true); ?></th>
                    	<!-- 
                    		<th  class="table-column  <?php if (in_array('sort:id', $filter_sort) && in_array('direction:asc', $filter_sort)) echo 'sortlink_asc';elseif ((in_array('sort:id', $filter_sort) && in_array('direction:desc', $filter_sort))) echo 'sortlink_desc';
                        	else echo 'sortlink'; ?>" style="width:50px" ><?php echo $paginator->sort(__("# of DN", true), 'id', $filter_options); ?></th>
                    	-->
                    <th  class="table-column  " style="width:50px;text-align: right;padding-top:2px!important;" ><?php echo __("# of DN", true); ?></th>

               		<th  class="table-column" style="width:20px" ></th>							
               		<th  class="table-column table-right-ohne" style="border-right: 1px solid #D1D1D1!important;"></th>
             </tr>
       </thead>
       <tbody>	
                            <?php
                            // initialise a counter for striping the table
                            $count = 0;
                            #echo "<pre>";print_r($locations);
                            // loop through and display format
                            foreach ($locations as $location):
                                // stripes the table by adding a class to every other row
                                $class = ( ($count % 2) ? " class='altrow'" : '' );
                                // increment count
                                $count++;
                                $location_id = $location['Location']['id'];
								#echo "<pre>";print_r($location);
                                ?>
                                <tr onmouseover="hoverRow(this, true);" onmouseout="hoverRow(this, false);">
                                    <!--<td class="table-left">&nbsp;</td>-->
                                    <td><?php
									if($location['Customer']['Info1']==0){
										echo $html->link(__($location['Location']['name'], true), array('controller' => 'locations', 'action' => 'edit', $location['Location']['id']));	 }
									else {
										echo __($location['Location']['name'], true); }
                                ?></td>
                                    <td><?php echo $location['Location']['address']; ?></td>
									<td><?php echo $location['Location']['plz']; ?></td>
                                    <td><?php echo $location['Location']['emer']; ?></td>
                                    <td style="text-align: right;padding-top:2px!important;" ><?php echo $locationDNCount[$location['Location']['id']]; ?></td>
                                    <td class="table-right-ohne	 tooltip" >
                                        <div>
                                            <div class="fl">
											<span><a href="javascript:;" onclick="Tip(' <?php echo __('Ort').': '. $location['Location']['ort']; ?><br/><?php echo __('Standort (SCM)').': '. $location['Location']['scm_name'];  ?><br/><?php echo __('locType').': '. $location['Location']['loc_type'];?><br/><?php echo __('locSource').': '. $location['Location']['loc_source'];?><br/><?php echo __('Beschreibung').': '. $location['Location']['remark']; ?>', BALLOON, true, ABOVE, false);" onMouseOut="UnTip(); " >...</a>
											</span>
                                               
                                            </div>
                                        </div>
                                    </td>
                                    <td class="table-right-ohne" style="background: url(<?php
                                        echo $this->webroot;
                                        ?>/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat 3px 5px;border-right: 1px solid #D1D1D1!important;" onmouseout="this.className = 'table-right';" id="<?php
                                        echo $sta_id;
                                        ?>tdlast">
                                        <div class="table-menu">
                                            <div class="table-menu-popup" style="z-index: 1">
                                                <ul>
												<?php if($location['Customer']['Info1']==0){ ?>
                                                    <li class="edit">
                                                        <?php
                                                        echo $html->link(__('Edit Location', true), array(
                                                            'controller' => 'locations',
                                                            'action' => 'edit',
                                                            $location['Location']['id']
                                                        ))
                                                        ?>
                                                    </li> 
												<?php } ?>
                                                    <?php
                                                    if (($locationDNCount[$location['Location']['id']] < 1) && ($locationMediatrixCount[$location['Location']['id']] < 1) && ($locationTrunkCount[$location['Location']['id']] < 1)) {
                                                        ?>
                                                        <li class="last delete">
                                                            <?php
                                                            echo $html->link(__('Delete Location', true), array(
                                                                'controller' => 'locations',
                                                                'action' => 'deletelocation/' . $location_id
                                                            ));
                                                            ?>
                                                        </li>

                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>


                                </tr>
    <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php
                echo $form->end();
                echo $this->element('pagination/bottom');
                ?>

                <?php
            else:
                echo 'There are currently no Locations in the database.';
            endif;
            ?>	 
        </div>
    </div>
</div>
</div>

<!--right hand side starts from here-->
<div id="related-content">
    <div class="box start link">
        <a href="http://www.swisscom.ch/<?php __('corporatebusiness') ?>" target="_blank">
            <?php __('Home Swisscom') ?>
        </a>
    </div>

    <!--<div class="box info">-->
	 <div class="box">
        <h3><?php __('Location List') ?></h3>
        <p>
            <?php
            if ($apptype == 'Phone') {
                __('This page allows  users to list all locations.');
            } else {
                __('gateCustomerSummary');
            }
            ?>
        </p>
		<div id="shortcont">
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('fullcont')"  title=""><?php echo __('moreStart') ?></a>             
            </div>
            <div style="display:none;" id="fullcont_type"  >
               <p  ><?php echo __('locationList_helpText') ?></p>
               <a href="javascript:;" style="cursor:pointer" onclick="set_visi('shortcont')"  title=""><?php echo __('moreEnd') ?></a>      
			</div>
    </div>
   
    <!--INTERNAL USER OPTIONS -->
<?php if ($userpermission == Configure::read('access_id')) {
    ?>
        <div class="box info">
            <h3><?php __("Internal User"); ?></h3>
            <p><?php __("Customer View:"); ?><?php echo $SELECTED_CNN; ?></p>
            <p><?php echo $selected_customer; ?></p>

        </div>
 <?php 
    		if ($_SESSION['VIEWMODE'] == 'EXTERNAL')
    		{
    			echo $html->link(__("scmView", true), array('controller' => 'locations', 'action' => 'toggleView?customer_id=' . $SELECTED_CNN . '&view=INTERNAL'));
    		}
    		else
    		{
    			echo $html->link(__("userView", true), array('controller' => 'locations', 'action' => 'toggleView?customer_id=' . $SELECTED_CNN . '&view=EXTERNAL'));
    		}
        } ?>

</div>


</div>
<!--ight hand side  ends here-->