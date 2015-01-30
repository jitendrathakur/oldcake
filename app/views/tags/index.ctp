<?php 
echo $javascript->link('/js/jquery.fancybox');
?>
<script type="text/javascript">

	$(document).ready(function() {
		$('.fancybox').fancybox();		

		paginationStyle();
		$('.pagerscenario a').click(function () { 
			paginationStyle();

		});		

		
							
		function paginationStyle() {		
			setTimeout(function() {	

				$( ".tablesorter-filter" ).change(function() {
				  paginationStyle();
				});

				$("table").removeClass('table-striped');
				$("table").removeClass('tablesorter-bootstrap');

				var pageDisplay = $(".pagedisplay").text();
				temp = pageDisplay.split(" -");
				//console.log(temp);
				left = temp[0]/10;	
				box = left; 
				if (temp[0]%10 > 0) {
					box = parseInt(left) + 1;
				}
				if (typeof temp[1] == 'undefined') {
					return false;
				}
				
				right = temp[1].split("/ ");			
				rightKey = right[1].split(" ");
				
				right = rightKey[0]/10;
				if (rightKey[0]%10 > 0) {
					totalPage = parseInt(right) + 1;
				}
				
				$(".pagedisplay").text('');
				var newStyle = "<input type='text' name='currpage' value='"+box+"' style='width:25px;text-align:center;float: inherit;' maxlength='3' class='GoOnTargetPage'>";
				newStyle += "<span style='font-weight:bold'> Of "+totalPage+"</span>";
				$(".pagedisplay").html(newStyle);
				$('.GoOnTargetPage').keyup(function () { 
					//console.log($(this).val());
					$("input[type='text']").keypress(function (e) {
					  if (e.which == 13) {
					  	
					  	$('.pagenum').val($(this).val()).trigger('change');
					  	paginationStyle();					    
					    //return false;
					  }
					  
					});
					
			    });

			}, 100);
		}//

		$("#languageTag").change(function() {			
			window.location.href = rootUrl + 'tags&lang='+$(this).val();
		});


	});

	
jQuery(function() { 
	jQuery.extend(jQuery.tablesorter.themes.bootstrap, {
		// these classes are added to the table. To see other table classes available,
		// look here: http://twitter.github.com/bootstrap/base-css.html#tables	
	});
	
	// call the tablesorter plugin and apply the uitheme widget
	jQuery(".dataTable").tablesorter({
		// this will apply the bootstrap theme if "uitheme" widget is included
		// the widgetOptions.uitheme is no longer required to be set
		theme : "bootstrap",
		bwidthFixed: false,
		bFilter: false,
		bInfo: false,
		emptyTo: 'none',
		link           : '<a href="#">{page}</a>',
		sPaginationType: "full_numbers",
        sDom: "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",  

		headerTemplate : '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!

		// widget code contained in the jquery.tablesorter.widgets.js file
		// use the zebra stripe widget if you plan on hiding any rows (filter widget)
		widgets : [ "uitheme", "filter", "zebra" ],

		widgetOptions : {
			// using the default zebra striping class name, so it actually isn't included in the theme variable above
			// this is ONLY needed for bootstrap theming if you are using the filter widget, because rows are hidden
			zebra : ["even", "odd"],

			// reset filters button
			filter_reset : ".reset"

			// set the uitheme widget to use the bootstrap theme class names
			// this is no longer required, if theme is set
			// ,uitheme : "bootstrap"
		},
		
		headers: { 
		0: {sorter: false,filter: false},
		2: {sorter: 'digit', filter: true},
		3: {},
		4: {},
		5: {filter: false}

		
		},	
	})
	.tablesorterPager({
		// target the pager markup - see the HTML block below
		container: jQuery(".pagerscenario"),
	

		// target the pager page select dropdown - choose a page
		cssGoto  : ".pagenum",
		
		initWidgets      : true,
		//page: 5,
		//size:5,

		cssPageSize: '.pagesize',

		// remove rows from the table to speed up the sort of large tables.
		// setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
		removeRows: false,

		// output string - default is '{page}/{totalPages}';
		// possible variables: {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
		output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'
		//output: 'Page <input type="text" name="currpage" value="{page}" class="pagination_text" maxlength="3"> Of {totalPages}'		

	});

	
 });
 
</script>

<div id="showods" style="display:block">

	<div class="block" style="margin: 0px;">

<?php 
	    echo $form->create('Tags',array('action'=>'index','id'=>'filters','type'=>'GET'));
	    #echo $form->input('Group.customer_id', array('type'=>'hidden','value'=>$SELECTED_CNN)); 
	   ?>
		<div class="button-left">
				<?php echo $html->link( __("Add New Tags", true),array('controller'=>'tags', 'action'=>'add&lang=' . $lang), array('onmouseover'=>'hoverButtonLeft(this)', 'onmouseout'=>'outButtonLeft(this)','class'=> $selected['DN List']." fancybox fancybox.ajax",'escape'=>$readonly, 'id'=>'add_numbers' )); ?>	
		</div>	
		<div class="button-left">
				<?php echo $html->link( __("createLocalization", true),array('controller'=>'tags', 'action'=>'export', $lang), array('onmouseover'=>'hoverButtonLeft(this)', 'onmouseout'=>'outButtonLeft(this)')); ?>	
		</div>
		
		<div class="control pull-right" id="">
			<?php echo $form->input('lang', array('options' => $language, 'default'=> $lang,'empty' => 'select language', 'label' => false, 'style' => 'height:25px', 'id' => 'languageTag')); ?>
		</div>
		
	</div>

	

	<div class="block">	
	<div id="" class="table-content">
				    <table class="table-content phonekey">
						<thead>
							    <tr class="table-top">
									<th class="table-column table-left-ohne" style="width:20px;">&nbsp;</th>
									<th  class="table-column"style="width:150px;text-align: left;"><?php __("tag");?></th>
									<th  class="table-column"style="width:280px;text-align: left;"><?php __("translation");?></th>
									<th  class="table-column"style="width:62px;text-align: left;"><?php __("Type");?></th>
									<th class="table-right-ohne">&nbsp;</th>
							    </tr>
						
							    <tr>
									<td class="table-column table-left-ohne">&nbsp;</td>
									<td><?php echo $form->input('origtag', array('label' => false, 'type'=>'text','class' => 'filter-class onclick', 'value'=>(isset($this->params['named']['origtag'])?$this->params['named']['origtag']:(isset($this->params['url']['origtag'])?$this->params['url']['origtag']:'')))); ?></td>
                                    
									<td><?php echo $form->input('translation', array('label' => false, 'type'=>'text','class' => 'filter-class onclick', 'value'=>(isset($this->params['named']['translation'])?$this->params['named']['translation']:(isset($this->params['url']['translation'])?$this->params['url']['translation']:'')))); ?></td>
                                    
									<td><?php echo $form->select('type', $tagtypes,(isset($this->params['named']['type'])?$this->params['named']['type']:(isset($this->params['url']['type'])?$this->params['url']['type']:'')),array('style'=>'width:55px;','onchange'=>"javascript:submi_form('filters');")); ?></td>
                                   
									
									<td class="table-right-ohne">&nbsp;</td>
							    </tr>
						</thead>
				    </table>
                    
			</div>
	
			<div class="button-right">
					<?php echo $html->link( __("reset", true),  array('controller'=> 'tags', 'action'=>'index/?lang=' . $lang),array('onmouseover'=>'hoverButtonRight(this);','onmouseout'=>'javascript:outButtonRight(this);')); ?>
				</div>
		
		<div id="" class="table-content">
		<table class="phonekey">
	    	<?php
			echo $this->element('pagination/top');
			?>
	    	<thead>
	        	<tr class="table-top">
	        	<th class="table-column table-left-ohne">&nbsp;</th>
	        	

			<th class="table-column <?php if(in_array('sort:tag',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:tag',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:150px;text-align: left;"><?php echo $paginator->sort(__("Tag",true), 'tag', $filter_options);?></th>
			<th class="table-column <?php if(in_array('sort:translation',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:translation',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:280px;text-align: left;"><?php echo $paginator->sort(__("Translation",true), 'translation', $filter_options);?></th>
			<th class="table-column <?php if(in_array('sort:type',$filter_sort) && in_array('direction:asc',$filter_sort)) echo  'sortlink_asc';elseif((in_array('sort:type',$filter_sort) && in_array('direction:desc',$filter_sort))) echo 'sortlink_desc';else echo 'sortlink';?> "style="width:30px;text-align: left;"><?php echo $paginator->sort(__("Type",true), 'type', $filter_options);?></th>
		
			<th class="table-column"><?php echo __('Action')?></th>
			
			
	            </tr>
	        </thead>
		<?php //echo $this->element('pagination/top'); ?>
	        <tbody>
	        	<?php 
		
			foreach ($tags as $tag):
			$transentry = utf8_encode($tag['Transentry'][0]['translation']);
			?>
			<tr  onmouseover="hoverRow(this,true);" onmouseout="hoverRow(this,false);">
				<td class="table-column table-left-ohne">&nbsp;</td>
				<td class="truncate"><?php echo $tag['Tag']['original_tag']; ?>&nbsp;</td>
				<td class="truncate"><?php echo $html->link( $tag['Transentry']['translation'], array('controller' => 'transentries', 'action'=>'index/'. $tag['Tag']['id'] . '&lang=' . $lang), array('class'=> "fancybox fancybox.ajax", 'escape' => false)); ?>&nbsp;</td>
				<td><?php echo !empty($tag['Tag']['type']) ? $tag['Tag']['type'] : 'User'; ?>&nbsp;</td>										
				
				<td class="table-right-ohne" style="background: url(<?php echo $this->webroot; ?>/images/assets/icons/9px/198_angleright_06_cmyk.gif) no-repeat 2px 2px;" onmouseover="this.className='table-right-over';" onmouseout="this.className='table-right';"> 
                    	<div class="table-menu">
                       <div class="table-menu-popup">
                       
                         <ul>
                           <li class="dial" ><?php echo $html->link( __("viewTag", true), array('controller'=>'tags', 'action'=>'view', $tag['Tag']['id']), array('class'=> "fancybox fancybox.ajax", 'escape' => false)); ?></li>
            
                           <li class="last handset" ><?php echo $html->link(__("editTag", true), array('action'=>'edit/' . $tag['Tag']['id'] . '&lang=' . $lang), array('class'=> "fancybox fancybox.ajax", 'escape' => false)); ?></li>
                      
                           <li class="dial" ><?php echo $html->link( __("deleteTag", true), array('action'=>'delete', $tag['Tag']['id']), array('escape' => false), sprintf('Are you sure you want to delete Tag: %s?', $tag['Tag']['original_tag'])); ?></li>
                    
                   
                         	<li class="dial" ><?php echo $html->link( __("viewTranslations", true), array('controller' => 'transentries', 'action'=>'index/'. $tag['Tag']['id'] . '&lang=' . $lang), array('class'=> "fancybox fancybox.ajax", 'escape' => false)); ?></li>
                      
                   
                         	<li class="dial" ><?php echo $html->link( __("viewCodeEntries", true), array('controller' => 'potentries', 'action'=>'index', $tag['Tag']['id']), array('class'=> "fancybox fancybox.ajax", 'escape' => false)); ?></li>
              
                         </ul>
                      </div>
                     </div>
                   	</td>		
                   	<!-- ><td>
				<?php echo $html->link($html->image('icon/eye.png'), array('controller'=>'tags', 'action'=>'view', $tag['Tag']['id']), array('class'=> "fancybox fancybox.ajax", 'escape' => false)); ?>		
				<?php echo $html->link($html->image('icon/edit.gif'), array('action'=>'edit/' . $tag['Tag']['id'] . '&lang=' . $lang), array('class'=> "fancybox fancybox.ajax", 'escape' => false));?>

				<?php echo $html->link($html->image('icon/trash.png'), array('action'=>'delete', $tag['Tag']['id']), array('escape' => false), sprintf('Are you sure you want to delete Tag: %s?', $tag['Tag']['original_tag']));?>
				<?php echo $html->link(
					$html->image('icon/translation.png'), array('controller' => 'transentries', 'action'=>'index/'. $tag['Tag']['id'] . '&lang=' . $lang), array('class'=> "fancybox fancybox.ajax", 'escape' => false));				
				?>
				&nbsp;&nbsp;
				<?php
				//$potStatus = ($tag[0]['pot_count']) ? 'icon/success.png' : 'icon/cross.png';
				echo $html->link(
					$html->image('icon/pot.png')."<i class='counter'>".$tag[0]['pot_count']."</i>", array('controller' => 'potentries', 'action'=>'index', $tag['Tag']['id']), array('class'=> "fancybox fancybox.ajax", 'escape' => false));				
				?>				

				</td>		
				-->
			</tr>
		<?php endforeach; ?>
			</tr>
		</body>
		</table>
		<?php echo $this->element('pagination/bottom'); ?>
	</div>
	</div>

</div>	
	