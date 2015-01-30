<?php
class TransentriesController extends AppController {

	var $components = array('RequestHandler');

	var $name = 'Transentries';	

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
	
	
	function export($lang = null) {
		//$this->autoRender = false;
		if (!$lang) {
			$lang = 'eng';
		}
		$records = $this->Transentry->find('all',
				array(
						'conditions' => array('language' => $lang),
						'fields' => array('tag_id','translation')
				)
		);
		#$base_path = Configure :: read('base_path');
		#$base_path = $base_path . '/app/localeTESTCBM';
		$base_path = Configure :: read('base_path');
		$file_path = $base_path . 'app/locale/' . $lang . '/LC_MESSAGES/def.po';
	
		foreach($records as $record)
		{
			$this->log('TRANS CONTROLLER : RECORD' . $record['Transentry']['translation'], LOG_DEBUG);
			$text ='msg_id "'. $record['Transentry']['tag_id'] . '"' . "\n";
			file_put_contents($file_path, $text, FILE_APPEND);
			$text ='msg_str "'. $record['Transentry']['translation'] . '"' . "\n";
			file_put_contents($file_path, $text, FILE_APPEND);
			file_put_contents($file_path, "\n", FILE_APPEND);
	
		}
		
		$cache_dir = $base_path . '/app/tmp/cache/*';
		#$execPath = 'sudo rm -rf ' . $cache_dir;
		$execPath = 'sudo ls -lrt ' . $cache_dir;
			
		#$output = system($execPath, $retval);
			
		$output = exec($execPath, $output, $retval);
		exit;
	
	}
	
	
	

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid transentry', true));
			$this->redirect(array('action' => 'index'));
		}
		$languages = Configure::read('language');
		$this->set(compact('languages'));
		$this->set('transentry', $this->Transentry->read(null, $id));
	}

	function add($tagId = null) {
		$lang=isset($this->params['url']['lang'])?$this->params['url']['lang']:(isset($this->params['named']['lang'])?$this->params['named']['lang']:"");
		if($lang==''){
			$lang = 'eng';

		}
		$this->set('lang', $lang);		
		$this->layout = false;		
		$response['success'] = 'false';
		if (!empty($this->data)) {
			$results_array=print_r($this->data, true);
			$this->log("Transentries controller : trans details : $results_array", LOG_DEBUG);
			$this->data['Transentry']['translation'] =  utf8_decode($this->data['Transentry']['translation']);
			
			$this->autoRender = false;
			$this->Transentry->create();
			
			if ($this->Transentry->save($this->data)) {
				
				$response['data'] = $this->Transentry->read(null, $this->Transentry->id);
				
				$response['success'] = 'true';			
				$this->Session->setFlash(__('The transentry has been saved', true));
				//$this->redirect(array('action' => 'index'));
			} else {
				$response['failure'] = $this->Transentry->validationErrors;
				if (!empty($response['failure']) && is_array($response['failure'])) {
					foreach($response['failure'] as $error) {
						$response['failure'] = $error;
						break;
					}
				}
				return $response['failure'];				
				$this->Session->setFlash(__('The transentry could not be saved. Please, try again.', true));
			}
			if ($this->RequestHandler->isAjax()) {				
				return $response['success'];				
		    }
		}		
		
		$languages = Configure::read('language');
		
		$this->set(compact('tag', 'languages', 'tagId'));
	}

	function edit($id = null) {
		$lang=isset($this->params['url']['lang'])?$this->params['url']['lang']:(isset($this->params['named']['lang'])?$this->params['named']['lang']:"");
		if($lang==''){
			$lang = 'eng';
		
		
		}
		$this->set('lang', $lang);
		$this->layout = false;	
		$response['success'] = 'false';
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid transentry', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Transentry->save($this->data)) {
				$response['success'] = 'true';	
				$this->Session->setFlash(__('The transentry has been saved', true));
				//$this->redirect(array('action' => 'index'));
			} else {
				$response['failure'] = $this->Transentry->validationErrors;
				$this->Session->setFlash(__('The transentry could not be saved. Please, try again.', true));
			}
			if ($this->RequestHandler->isAjax()) {				
				return json_encode($response);				
		    }
		}
		if (empty($this->data)) {
			$this->data = $this->Transentry->read(null, $id);
		}
		$tag = $this->Transentry->Tag->find('list', array('fields' => array('original_tag')));
		$languages = Configure::read('language');
		
		$this->set(compact('tag', 'languages'));		
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for transentry', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Transentry->delete($id)) {
			$this->Session->setFlash(__('Transentry deleted', true));
			$this->redirect(array('controller' => 'tags', 'action'=>'index'));
		}
		$this->Session->setFlash(__('Transentry was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
