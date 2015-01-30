<?php
class Tag extends AppModel {
	var $name = 'Tag';

	var $actsAs = array('Containable');

	
	var $validate = array(
		'original_tag' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter original tag',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'type' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter type',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
		
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(		
		'Transentry' => array(
			'className' => 'Transentry',
			'foreignKey' => 'tag_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Potentry' => array(
			'className' => 'Potentry',
			'foreignKey' => 'tag_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	/*var $hasOne = array(
		'Potentry' => array(
			'className' => 'Potentry',
			'foreignKey' => 'tag_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);*/

}
