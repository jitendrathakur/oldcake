<?php
class Potentry extends AppModel {
	var $name = 'Potentry';

	var $validate = array(
		'tag_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Tag could not empty',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'page' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter the page',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'linenumber' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter line number',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Tag' => array(
			'className' => 'Tag',
			'foreignKey' => 'tag_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
