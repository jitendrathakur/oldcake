<?php

#-----------------------------------------------------------------#
# $Rev:: 22            $:  Revision of last commit                #
#-----------------------------------------------------------------#


// page: /app/views/locations/view.ctp

?>

	<div class="locations view">
		<h2>Viewing Location: <?php echo $location['Location']['name']; ?></h2>
	    
	    <?php if(!empty($location['Station'])): ?>
	    
	    <div class="related">
	        <h3>Stations within this Location</h3>
	        <table>
	            <thead>
	                <tr>
	                    <th><?php __("Name")?></th>
	                    <th><?php __("station_created")?></th>
	                    <th><?php __("last_modi")?></th>
	                    <th><?php __("Action")?></th>
	                    <th><?php __("Log")?></th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php foreach($location['Station'] as $station): ?>
	                <tr>
	                    <td><?php echo $station['number']; ?></td>
	                    <td><?php echo $station['created']; ?></td>
	                    <td><?php echo $station['modified']; ?></td>
	                    <!-- <td><?php echo $html->link('View', '/stations/edit/'.$station['slug']);?></td> -->
	                    <td><?php echo $html->link('edit', array('controller'=> 'stations', 'action'=>'edit', $station['id'])); ?></td>
	                    <td><?php echo $html->link('viewlog', array('controller'=> 'stations', 'action'=>'viewlog', $station['id'])); ?></td>
	                </tr>
	                <?php endforeach; ?>
	            </tbody>
	        </table>
	    </div>
	    
	    <?php endif; ?>
	    
	    <ul class="actions">
	    	<li><?php echo $html->link('Back to Locations', array('action'=>'index'));?></li>
		</ul>
	</div>
</div>
