<?php
class XmlenginesController extends AppController {

	var $name = 'Xmlengines';	
	
	var $components = array (
			'Authentication',
	);

	function index($tagId = null) {		
		$this->autorender = false;
		
		$lang=isset($this->params['url']['lang'])?$this->params['url']['lang']:(isset($this->params['named']['lang'])?$this->params['named']['lang']:"");
		if($lang==''){
			$lang = 'eng';
				
		}
		$this->set('lang', $lang);
		
  		$this->layout = 'ajax';  		
  		if (!empty($tagId)) {  			
  			$this->paginate = array(			
	            'conditions'=>array('Transentry.tag_id' => $tagId),
	            'order' => array('language')
	        );  
  		}
		$this->Transentry->recursive = 0;
				

		$tag = $this->Transentry->Tag->find('first', 
			array(
				'fields' => array('original_tag'),
				'conditions' => array('Tag.id' => $tagId),
				//'contain' => false
			)
		);		
		$languages = Configure::read('language');		
		
		$this->set(compact('tag', 'languages', 'tagId'));		
		$this->set('transentries', $this->paginate());
	}
	
	function process($xmlid) {
		#$fullTransaction = $TransactionDetails['Transaction']['transaction'];
		$this->log("Xmlengine controller : APPLYING FULL TRANS : $fullTransaction", LOG_DEBUG);
		
		#$transaction_id=isset($this->params['url']['transaction_id'])?$this->params['url']['transaction_id']:(isset($this->params['named']['transaction_id'])?$this->params['named']['transaction_id']:"");
		#$type=isset($this->params['url']['type'])?$this->params['url']['type']:(isset($this->params['named']['type'])?$this->params['named']['type']:"");
		$xmlid = isset($this->params['url']['xmlid'])?$this->params['url']['xmlid']:(isset($this->params['named']['xmlid'])?$this->params['named']['xmlid']:"");
		$this->log('XMLENGINE CONTROLLER ' . 'XMLINPUT DETAILS :' .   $transaction_id . ':' . $type . ':' . $xmlid, LOG_DEBUG);
		
		#extract the value from the DB into variable.
		$xmlInfo = $this->Xmlengine->find('first', array (
				'conditions' => array (
						'Xmlengine.id' => $xmlid
				)
		));
		
		
		if($xmlInfo['Xmlengine']['data'] == '')
		{
			$this->log('STATION CONTROLLER : APPLY : STATION IN EXCEPTIUON', LOG_DEBUG);
			echo 'fail';
			exit;
				
		}
		
		
		#save to filesystem.
		$layoutFile = $xmlInfo['Xmlengine']['layoutFile'];
		$transaction_id = $xmlInfo['Xmlengine']['transaction_id'];
		$mode = $xmlInfo['Xmlengine']['mode'];
		
		
		$this->log('XMLENGINE CONTROLLER ' . 'XMLINPUT DETAILS :' .   $transaction_id . ':' . $layoutFile . ':' . $xmlid, LOG_DEBUG);
		
		
		
		$fileName = $mode . '.' . $transaction_id  . '.input.xml';
		$base_path = Configure :: read('base_path');
		$path = $base_path . '/XMLEngine/transactions/' . $fileName;
		
		$this->log('XMLENGINE CONTROLLER ' . 'WRITING FILE :' .   $path, LOG_DEBUG);
		

		file_put_contents($path, $xmlInfo['Xmlengine']['data']);
		
		#execute the script
		
		$execPath = 'sudo /usr/bin/perl ' . $base_path . 'XMLEngine/processor.pl' . ' ' . $fileName . ' ' . $layoutFile . ' 2>&1';
			
		$this->log('XMLENGINE CONTROLLER ' . 'EXECUTING :' .   $execPath, LOG_DEBUG);
		
		#$output = system($execPath, $retval);
		
		#Run locally
		$output = exec($execPath, $output, $retval);
		
		#send the response to the client
		$this->log('XMLENGINE CONTROLLER ' . 'EXITING WITH RESPONSE :' .   $output, LOG_DEBUG);
		
		echo $output;
		
		
		
		
	}
	
	
}
