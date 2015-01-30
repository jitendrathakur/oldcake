<div class="potentries index">
	<h3><?php __('Potentries');?> <?php //echo $html->link(__('Add Potentries', true), array('action' => 'add', $tagId), array('class'=> "fancybox fancybox.ajax btn pull-right span", 'style' => 'margin:0px 20px 10px 0px')); ?></h3>
	<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-hover table-condensed">
	<tr>
			<th><?php echo 'id';?></th>
			<th><?php echo 'tag name';?></th>
			<th><?php echo 'page';?></th>
			<th><?php echo 'linenumber';?></th>
			<th><?php echo 'created';?></th>	
			<th><?php echo 'status';?></th>
			<?php /* <th class="actions"><?php __('Actions');?></th> */ ?>
	</tr>
	<?php
	$i = 0;
	if (!empty($potentries)) {
		foreach ($potentries as $potentry):
		?>
		<tr>
			<td><?php echo $potentry['Potentry']['id']; ?>&nbsp;</td>
			<td class="truncate">
				<?php echo $potentry['Tag']['original_tag']; ?>
			</td>
			<td><?php echo $potentry['Potentry']['page']; ?>&nbsp;</td>
			<td><?php echo $potentry['Potentry']['linenumber']; ?>&nbsp;</td>
			<td><?php echo $potentry['Potentry']['created']; ?>&nbsp;</td>		
			<td><?php echo ($potentry['Potentry']['status']) ? 'Active' : 'Inactive'; ?>&nbsp;</td>
			<?php /* <td class="actions">			
				<?php echo $html->link($html->image('icon/edit.gif'), array('action' => 'edit', $potentry['Potentry']['id']), array('class'=> "fancybox fancybox.ajax", 'escape' => false)); ?>
				<?php echo $html->link($html->image('icon/trash.png'), array('action' => 'delete', $potentry['Potentry']['id']), array('escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $potentry['Potentry']['id'])); ?>
			</td> */ ?>
		</tr>
	<?php endforeach;

	} else { ?>
		<tr><td colspan="7">No Record Found</td></tr>

	<?php } ?>

	</table>
	
</div>
