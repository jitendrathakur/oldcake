<?php
class TransactionsController extends AppController {

	var $name = 'Transactions';	
	
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
	
	function process($fullTransaction) {
		#$fullTransaction = $TransactionDetails['Transaction']['transaction'];
		$this->log("Transaction controller : APPLYING FULL TRANS : $fullTransaction", LOG_DEBUG);
		
		
		
		$pattern='/<algRequest>(.+?)<\/algRequest>/';
		$ft = preg_replace("/[\n\r]+\s+/", "", $fullTransaction);
		#$results_array=isXML($fullTransaction);
		if(preg_match_all($pattern, $ft, $matches))
			#if(preg_match_all($pattern, $fullTransaction, &$matches))
		{
		
		
			foreach($matches[1] as $match)
			{
					
				$xmltosend = $match;
					
				$this->log('Transaction CONTROLLER APPLY : individual transaction' . $xmltosend, LOG_DEBUG);
					
					
				#Send the command and
				$res = $this->Authentication->algclient($xmltosend, $transId);
				$this->log('Transaction CONTROLLER APPLY : RESPONSE FROM C20' . $res, LOG_DEBUG);
				$transTrace .=  $xmltosend . '\n' . $res;
					
				#Check status somehow
				#if ivalid break out of loop???
		
			}
			
			return $transTrace;
		
		}
	}
	
	
}
