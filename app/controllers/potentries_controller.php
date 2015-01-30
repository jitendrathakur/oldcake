<?php
class PotentriesController extends AppController {

	var $components = array('RequestHandler');

	var $name = 'Potentries';

	function index($tagId = null) {		
		
		$this->autorender = false;
  		$this->layout = 'ajax';  		
  		if (!empty($tagId)) {  			
  			$this->paginate = array(			
	            'conditions'=>array('Potentry.tag_id' => $tagId)     
	        );    	
  		}
		$this->Potentry->recursive = 0;	

		$this->set('potentries', $this->paginate());

		//$tagExist = $this->Potentry->find('first', array('conditions' => array('Potentry.tag_id' => $tagId)));
		
		$this->set(compact('tagId'));		
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid potentry', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('potentry', $this->Potentry->read(null, $id));
	}


	function add($tagId = null) {
		
		$this->layout = false;		
		$response['success'] = 'false';
		if (!empty($this->data)) {
			$this->autoRender = false;
			$this->Potentry->create();
			if ($this->Potentry->save($this->data)) {
				$response['success'] = 'true';			
				$this->Session->setFlash(__('The potentry has been saved', true));
				//$this->redirect(array('action' => 'index'));
			} else {
				$response['failure'] = $this->Potentry->validationErrors;
				$this->Session->setFlash(__('The potentry could not be saved. Please, try again.', true));
			}
			if ($this->RequestHandler->isAjax()) {				
				return json_encode($response);				
		    }
		}		

		$tag = $this->Potentry->Tag->find('list',
		 array(
		 	'fields' => array('original_tag'), 
		 	'conditions' => array('Tag.id' => $tagId)
		 	)
		 );
		
		$this->set(compact('tag', 'tagId'));
	}


	function edit($id = null) {
		$this->layout = false;	
		$response['success'] = 'false';
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Potentry', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Potentry->save($this->data)) {
				$response['success'] = 'true';	
				$this->Session->setFlash(__('The potentry has been saved', true));
				//$this->redirect(array('action' => 'index'));
			} else {
				$response['failure'] = $this->Potentry->validationErrors;
				$this->Session->setFlash(__('The potentry could not be saved. Please, try again.', true));
			}
			if ($this->RequestHandler->isAjax()) {				
				return json_encode($response);				
		    }
		}
		if (empty($this->data)) {
			$this->data = $this->Potentry->read(null, $id);
		}

		$tags = $this->Potentry->Tag->find('list',
		  array(
		 	'fields' => array('original_tag'), 
		 	'conditions' => array('Tag.id' => $this->data['Potentry']['tag_id'])
		 	)
		);
				
		$this->set(compact('tags'));		
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for potentry', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Potentry->delete($id)) {
			$this->Session->setFlash(__('Potentry deleted', true));
			$this->redirect(array('controller' => 'tags', 'action'=>'index'));
		}
		$this->Session->setFlash(__('Potentry was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
