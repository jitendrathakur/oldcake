<div class="tags view well span12">
<h3><?php  __('Tag');?></h3>
	<dl><?php $i = 0; $class = ' class="altrow span2"';?>
		<dt class="span4"><?php __('Id'); ?></dt>
		<dd class="span4">
			<?php echo $tag['Tag']['id']; ?>
			&nbsp;
		</dd>
		<dt class="span4"><?php __('Original Tag'); ?></dt>
		<dd class="span4">
			<?php echo $tag['Tag']['original_tag']; ?>
			&nbsp;
		</dd>
		<dt class="span4"><?php __('Type'); ?></dt>
		<dd class="span4">
			<?php echo $tag['Tag']['type']; ?>
			&nbsp;
		</dd>
		<dt class="span4"><?php __('Comment'); ?></dt>
		<dd class="span4">
			<?php echo $tag['Tag']['comment']; ?>
			&nbsp;
		</dd>
		<dt class="span4"><?php __('Created'); ?></dt>
		<dd class="span4">
			<?php echo $tag['Tag']['created']; ?>
			&nbsp;
		</dd>
		<dt class="span4"><?php __('CreatedBy'); ?></dt>
		<dd class="span4">
			<?php echo $tag['Tag']['createdBy']; ?>
			&nbsp;
		</dd>
		<dt class="span4"><?php __('Modified'); ?></dt>
		<dd class="span4">
			<?php echo $tag['Tag']['modified']; ?>
			&nbsp;
		</dd>
		<dt class="span4"><?php __('ModifiedBy'); ?></dt>
		<dd class="span4">
			<?php echo $tag['Tag']['modifiedBy']; ?>
			&nbsp;
		</dd>
		<dt class="span4"><?php __('Status'); ?></dt>
		<dd class="span4">
			<?php echo ($tag['Tag']['status']) ? 'Active' : 'Inactive'; ?>
			&nbsp;
		</dd>
	</dl>
</div>

<div class="related">
	<h3><?php __('Related Potentries');?></h3>
	<?php if (!empty($tag['Potentry'])):?>
	<table cellpadding = "0" cellspacing = "0" class="table table-striped table-bordered table-hover table-condensed" id="potentries">
	<thead>
		<th><?php __('Id'); ?></th>
		<th><?php __('Tag Id'); ?></th>
		<th><?php __('Page'); ?></th>
		<th><?php __('Linenumber'); ?></th>
		<th><?php __('Created'); ?></th>	
		<th><?php __('Status'); ?></th>		
	</thead>
	<tbody>
	<?php
		$i = 0;
		foreach ($tag['Potentry'] as $potentry):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $potentry['id'];?></td>
			<td><?php echo $tag['Tag']['original_tag'];?></td>
			<td><?php echo $potentry['page'];?></td>
			<td><?php echo $potentry['linenumber'];?></td>
			<td><?php echo $potentry['created'];?></td>	
			<td><?php echo ($potentry['status']) ? 'Active' : 'Inactive';?></td>			
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
<?php endif; ?>
	
</div>
<div class="related">
	<h3><?php __('Related Transentries');?></h3>
	<?php if (!empty($tag['Transentry'])):?>
	<table cellpadding = "0" cellspacing = "0" class="table table-striped table-bordered table-hover table-condensed" id="transentries">
	<thead>
		<th><?php __('Id'); ?></th>
		<th><?php __('Tag Id'); ?></th>
		<th><?php __('Language'); ?></th>
		<th><?php __('Translation'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Status'); ?></th>		
	</thead>
	<tbody>
	<?php
		$i = 0;
		foreach ($tag['Transentry'] as $transentry):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $transentry['id'];?></td>
			<td><?php echo $tag['Tag']['original_tag'];?></td>
			<td><?php echo $transentry['language'];?></td>
			<td><?php echo $transentry['translation'];?></td>
			<td><?php echo $transentry['created'];?></td>	
			<td><?php echo ($potentry['status']) ? 'Active' : 'Inactive';?></td>			
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
<?php endif; ?>	
</div>
