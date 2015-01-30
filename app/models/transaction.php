<?php
class Transaction extends AppModel {
	var $name = 'Transaction';

	var $actsAs = array('Containable');
		
	var $hasMany = array(
        	'Log'=>array(
            	'className'=>'Log'
        	)

    	);

}
