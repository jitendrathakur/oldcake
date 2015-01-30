<?php
class AppError extends ErrorHandler {
var $helpers = array('Html', 'Form', 'Javascript');

	function accessDenied($params) {
	  //die();
	  //$this->controller->set('file', $params['file']);
	  $this->layout='ajax';
	  $this->_outputMessage('access_denied');
	}	
	function sessionExpired($params) {
	  //die();
	  //$this->controller->set('file', $params['file']);
	  $this->layout='ajax';
	  $this->_outputMessage('session_expired');
	}
}
?>
