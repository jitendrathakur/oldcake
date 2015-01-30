

<style>
.table-menu-popup {
    display: none;
    float: left !important;
    margin-left: -24px;
    margin-top: 5px;
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
    width: 87px!important;
}
.tablesorter-bootstrap .tablesorter-header i {
    background-repeat: no-repeat;
    display: inline-block;
    float: right!important;
    height: 14px;
    left: 2px;
    line-height: 14px;
    margin-top: 10px!important;
    position: absolute; 
    width: 12px;
}
.tablesorter-bootstrap .tablesorter-header-inner {
    font-size: 11px;
    padding: 0px 10px 4px 0!important;
    position: relative;
}
 .tablesorter-filter
    {
        width:100% !important;
		margin: 0 -2px !important;
        padding: 4px 1px !important;
		height:26px!important;
    }
	
	.tablesorter-bootstrap .tablesorter-filter-row td {
    background: none repeat scroll 0 0 #EEEEEE;
    line-height: normal;
    padding: 4px 3px;
    text-align: center;
    transition: line-height 0.1s ease 0s;
    vertical-align: middle;
}
.table th, .table td {
    border-top: 1px solid #DDDDDD;
    line-height: 20px;
    
	padding-left:3px!important;
    text-align: left;
    vertical-align: top;
}	
	
</style>

			
	        <table class="phonekey" id="NOTdragdroptbl" width="400px!important">
			  <thead>
			    <tr class="table-top">
				  <!--<th class="table-column" style="width:20px;">&nbsp;</th>-->
				  <th class="table-column" style="width:100px;text-align: left;">&nbsp;&nbsp;<?php echo __('Label')?>&nbsp;&nbsp;</th>
				  <th class="table-column" style="width:90px!important;text-align: left;">&nbsp;&nbsp;<?php echo __('BLF Number')?>&nbsp;&nbsp;</th>
				  <th class="table-column" style="width:90px!important;text-align: left;">&nbsp;&nbsp;<?php echo __('Stations')?>&nbsp;&nbsp;</th>
				  <th class="table-column" style="width:20px;text-align: left;">&nbsp;&nbsp;<?php echo __('Key')?>&nbsp;&nbsp;</th>
				  <th class="table-column " style="width:20px;text-align: left;">&nbsp;&nbsp;<?php //__('Options'); ?>&nbsp;&nbsp;</th>
 				  <!-- <th class="table-column" style="width:20px;">&nbsp;</th>-->
			    </tr>
			  </thead>
			  <tbody>
	            <?php
			    foreach($observers as $observer):
				 #echo "<pre>";print_r($observer);
				 ?>
	            <tr onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">
	              <!-- <td class="table-left">&nbsp;</td> -->
				  <td><?php echo $observer['Feature']['label']?></td>
				  <td><?php echo $observer['Feature']['primary_value']?></td>
	              <td><?php echo $observer['Stationkey']['station_id']?></td>
             	  <td><?php echo $observer['Stationkey']['keynumber'];?></td>
	              <td class="table-right-ohne" style="background: url(<?php
    			    echo $this->webroot;
					?>/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat 3px 5px; border-right: 1px solid #D1D1D1!important;" onmouseout="this.className='table-right';" id="<?php
     				echo $sta_id;
					?>tdlast" >
					  <div class="table-menu ">
         			    <div class="table-menu-popup" style="z-index: 1;margin-left: 10px;  margin-top: -10px;">
        			      <ul style="width: 100px;">
					        <li class="last log" style=" border-left:1px solid #001155!important;border-right: 1px solid #001155!important;border-top: 1px solid #001155!important;width: 200px;">
							  <?php echo $html->link( __("linkToCoobserver", true),array('controller'=>'stations','action'=>'editstation',$observer['Stationkey']['station_id'])); ?>
					        </li>
					      </ul>	
					    </div>
					  </div>
					</td>
	            	</tr>
	            	<?php 
	           endforeach; ?>
	          </tbody>
	        </table>
		  
