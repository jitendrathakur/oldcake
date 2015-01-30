<?php
class TagsController extends AppController {

	var $components = array('RequestHandler');

/**
   * different models used
   *
   * @array contains models
   */
  public $uses = array('Tag', 'Transentry', 'Potentry');

	var $name = 'Tags';

function export($lang = null) {
		//$this->autoRender = false;
		if (!$lang) {
			$lang = 'deu';
		}
		$base_path = Configure :: read('base_path');
		$languages = Configure::read('language');
		foreach ($languages as $exportlang=>$longName)
		{
		 	$this->log('TAGS CONTROLLER : PROCESSING LANG' .  $exportlang  . ' ' . $longName, LOG_DEBUG);	
			$records = $this->Transentry->find('all',
				array(
						'conditions' => array('language' => $exportlang),
						'fields' => array('Transentry.tag_id','Transentry.translation', 'Tag.tag', 'Tag.original_tag')
				)
			);

			
			$file_path = $base_path . 'app/locale/' . $exportlang . '/LC_MESSAGES/default.po';
			$archive_file_path = $base_path . 'app/locale/' . $exportlang . '/LC_MESSAGES/archives/default.po.' . 'date' ;

			$execPath = 'sudo ls -lrt ' . $cache_dir;
			
			$outy = exec($execPath, $output, $retval);
			$f_array=print_r($output, true);

			$this->log('TAGS CONTROLLER : EXECUTING' . $execPath, LOG_DEBUG);
			$this->log('TAGS CONTROLLER : RESPONSE' . $f_array, LOG_DEBUG);
		
			file_put_contents($file_path, '**START**');
			foreach($records as $record)
			{
				#$this->log('TAGS CONTROLLER : RECORD' . $record['Transentry']['translation'], LOG_DEBUG);
				$text ='msgid "'. $record['Tag']['original_tag'] . '"' . "\n";
				#file_put_contents($file_path, $text, FILE_APPEND);
				file_put_contents($file_path, $text, FILE_APPEND);
				$text ='msgstr "'. $record['Transentry']['translation'] . '"' . "\n";
				file_put_contents($file_path, $text, FILE_APPEND);
				file_put_contents($file_path, "\n", FILE_APPEND);
	
			}
			file_put_contents($file_path, '**END**',"\n", FILE_APPEND);
			$cache_dir = $base_path . '/app/tmp/cache/*';
			$execPath = 'sudo rm -rf ' . $cache_dir;
			
			$output = exec($execPath, $output, $retval);
		
			$this->log('TAGS CONTROLLER : EXECUTING' . $execPath, LOG_DEBUG);
			$this->log('TAGS CONTROLLER : RESPONSE' . $output, LOG_DEBUG);
		
			#exit;
		}
		$this->redirect('/tags&lang=' . $lang);
	
	}
	
	function index() {		
		$this->pageTitle = 'TAG List';
		$lang=isset($this->params['url']['lang'])?$this->params['url']['lang']:(isset($this->params['named']['lang'])?$this->params['named']['lang']:"");
		if($lang==''){
			$lang = 'deu';
			
				
		}
		$cond = array();
		$cond = array('language' => $lang);

		$origtag=isset($this->params['url']['origtag'])?$this->params['url']['origtag']:(isset($this->params['named']['origtag'])?$this->params['named']['origtag']:"");
		if($origtag!=''){
	
			$cond = array_merge($cond,array('Tag.original_tag LIKE'=>'%'.$origtag.'%',  'language' => $lang));
			$this->passedArgs['origtag'] = $origtag;
		
		}
		$translation=isset($this->params['url']['translation'])?$this->params['url']['translation']:(isset($this->params['named']['translation'])?$this->params['named']['translation']:"");
		if($translation!=''){
			$cond = array_merge($cond,array('Transentry.translation LIKE'=>'%'.$translation.'%', 'language' => $lang));
			$this->passedArgs['translation'] = $translation;
		
		}
		$tag_type=isset($this->params['url']['type'])?$this->params['url']['type']:(isset($this->params['named']['type'])?$this->params['named']['type']:"");
		if($tag_type!=''){
			$cond = array_merge($cond,array('Tag.type'=>$tag_type));
			$this->passedArgs['type'] = $tag_type;
		
		}
		
		$tagtypes = $this->Tag->find('all', array(
				'contain'=>false,
				'fields'=>array('DISTINCT type')

		));
		$ttypes[''] = '';
		
		foreach($tagtypes as $tagtype):
		$ttypes[$tagtype['Tag']['type']] = $tagtype['Tag']['type'];
		$this->log("TAGS CONTROLLER : TAG TYPE" . $tagtype['Tag']['type'], LOG_DEBUG);
		endforeach;
			
		$this->set('tagtypes',$ttypes);
		
		$language = Configure::read('language');
		$this->pageTitle = 'TAG List : ' . $language[$lang];
		
		$this->set('lang', $lang);
		//print_r($_SESSION['Config']['language']);
		$this->Tag->recursive = 2;
		#$this->paginate = array(
		#	'limit'=>25,
         #   'fields'=>array(
          #  	'Tag.*', 
           # 	'(SELECT COUNT(Transentry.id) FROM transentries Transentry WHERE Tag.id = Transentry.tag_id) as trans_count',
          #  #	'(SELECT COUNT(Potentry.id) FROM potentries Potentry WHERE Tag.id = Potentry.tag_id) as pot_count'
           # ),
		#	'conditions' => $cond,
         #   'contain' => array('Transentry' => array('conditions' => $transcond))
        #);   
		$this->paginate = array('conditions'=>$cond,
			'fields' => array(
			'Tag.*',
			'Transentry.translation',
			'count(Transentry.id) as trans_count'),
			'limit' => $this->paginate['limit'], 
			'group'=>'Tag.id',
			'conditions'=>$cond);
		#$results = $this->paginate('Tags');
		$this->set('tags', $this->paginate('Transentry'));
		
		
	#	$translations  = $this->Transentry->find('all',
	#			array(
	#					'conditions' => array('language' => $exportlang),
	#					'fields' => array('Transentry.tag_id','Transentry.translation', 'Tag.tag', 'Tag.original_tag')
	#			)
	#	);
        #$language = Configure::read('language');
        $this->set('language', $language);
    	
      
        
		#$this->set('tags', $this->paginate());
	}

	function view($id = null) {
		//$this->autoRender = false;
  		$this->layout = 'ajax';
		if (!$id) {
			$this->Session->setFlash(__('Invalid tag', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('tag', $this->Tag->read(null, $id));
	}

	function add() {
		
		$lang=isset($this->params['url']['lang'])?$this->params['url']['lang']:(isset($this->params['named']['lang'])?$this->params['named']['lang']:"");
		if($lang==''){
			$lang = 'eng';
		
		
		}
		$this->set('lang', $lang);
		
		$this->layout = false;		
		
		$response['success'] = 'false';
		if (!empty($this->data)) {	
			$this->autoRender = false;
			$this->data['Tag']['tag'] = ltrim($this->data['Tag']['original_tag']);
			$this->Tag->create();
			if ($this->Tag->save($this->data)) {
				
				//Workaround
				$id = $this->Tag->id;
				#$transsave['Transentry']['language'] =  'deu';
				
				$transsave['Transentry']['tag_id'] =  $id;
				$transsave['Transentry']['found_tag'] =  $id;
				$transsave['Transentry']['translation'] =  '__' . $this->data['Tag']['original_tag'];
				$transsave['Transentry']['comment'] =  '-';
				$transsave['Transentry']['status'] =  '';
				
				$transsave['Transentry']['language'] =  'deu';
				$this->Transentry->create();
				$this->Transentry->save($transsave);
				$transsave['Transentry']['language'] =  'eng';
				$this->Transentry->create();
				$this->Transentry->save($transsave);
				$transsave['Transentry']['language'] =  'ita';
				$this->Transentry->create();
				$this->Transentry->save($transsave);
				$transsave['Transentry']['language'] =  'fre';
				$this->Transentry->create();
				$this->Transentry->save($transsave);
				
				$response['success'] = 'true';			
				$this->Session->setFlash(__('The tag has been saved', true));
				//$response['redirect'] = $this->redirect(array('action' => 'index'));
			} else {				
				//$response['failure'] = $this->Tag->validationErrors;
				$this->Session->setFlash(__('The tag could not be saved. Please, try again.', true));
			}
		
			if ($this->RequestHandler->isAjax()) {	
				
				return $response['success'];	
		    }
		}

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
			$this->Session->setFlash(__('Invalid tag', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Tag->save($this->data)) {
				$response['success'] = 'true';	
				$this->Session->setFlash(__('The tag has been saved', true));
				//$this->redirect(array('action' => 'index'));
			} else {
				//$response['failure'] = $this->Tag->validationErrors;
				$this->Session->setFlash(__('The tag could not be saved. Please, try again.', true));
			}
			if ($this->RequestHandler->isAjax()) {				
				return $response['success'];		
		    }
		}
		if (empty($this->data)) {
			$this->data = $this->Tag->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for tag', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Tag->delete($id)) {
			$conditn = array (
			'Transentry.tag_id' => $id
			);
			$this->Transentry->deleteAll($conditn);
			$this->Session->setFlash(__('Tag deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Tag was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
