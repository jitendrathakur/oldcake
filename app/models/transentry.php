<?php
class Transentry extends AppModel {
	var $name = 'Transentry';
	var $validate = array(
		'tag_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'language' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'translation' => array(
			'notempty' => array(
                'rule' => 'notempty',              
                'message' => 'Translation could not be empty',
                'last' => true
                ),
			'length' => array( 
				'rule' => 'validateLength', 
				'min' => 2, 
				'max' => 5000 ,
				'message' => 'Tranlation length between 2 to 150 character'
			),
			//'unique' => array( 
				//'rule' => 'validateUnique', 				
				//'message' => 'Tranlation should be unique'
			//),
			// 'unique' => array( 
			// 	'rule' => 'validateUnique',				
			// 	'message' => 'Tranlation should be unique'
			// ) 
            /*'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'message' => 'Translation should be string'
            )*/
		),
		//'comment' => array(
			//'notempty' => array(
				//'rule' => array('notempty'),
				//'message' => 'Comment could not be empty',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			//),
		//),
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

	function validateLength($value, $params = array()) { 		
		$value = $value['translation'];
        $valid = false; 
         
        $params = am(array( 
            'min' => null, 
            'max' => null, 
        ), $params); 
         
        if (empty($params['min']) || empty($params['max'])) { 
            $valid = false; 
        } else if (strlen($value) >= $params['min'] && strlen($value) <= $params['max']) { 
            $valid = true; 
        } 
         
        return $valid; 
    }//end validateLength()


    public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
    	$conditions = compact('conditions');
    	if ($recursive != $this->recursive) {
    		$conditions['recursive'] = $recursive;
    	}
    
    	unset( $extra['contain'] );
    
    	$count = $this->find('count', array_merge($conditions, $extra));
    
    	if (isset($extra['group'])) {
    		$count = $this->getAffectedRows();
    	}
    	return $count;    		
    		
    }//end paginateCount


    function validateUnique($value, $params = array()) {   
		$translation = $value['translation'];	
		$result = $this->find('first', array('conditions' => array('translation' => $translation)));
        if (empty($result)) {
        	$valid = true; 
        } else {
        	$valid = false; 
        }         
        return $valid; 
    }//end validateLength()

    
}//end class
