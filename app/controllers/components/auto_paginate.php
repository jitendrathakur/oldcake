<?php

#-----------------------------------------------------------------#
# $Rev:: 22            $:  Revision of last commit                #
#-----------------------------------------------------------------#

/**
 * Auto Paginate Component class.
*
 * A simple extension for paginating that helps with persisting user-defined pagination limits.
 *
 * @filesource
 * @author          Jamie Nay
 * @copyright       Jamie Nay
 * @license         http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link            http://jamienay.com/code/auto-paginate-component
 */
class AutoPaginateComponent extends Object {
 
 /**
 * Other components needed by this component
 *
 * @access public
 * @var array
 */
 public $components = array('Session');
 
 /**
 * component settings
 *
 * @access public
 * @var array
 */
 public $settings = array();
 
/**
 * Default values for settings.
 * - options: the results-per-page options to present to the user.
 *
 * @access private
 * @var array
 */
 private $__defaults = array(
 'options' => array(10, 25, 50, 100),
 'defaultLimit' => 25
 );
 
 /**
 * Configuration method.
 *
 * @access public
 * @param object $model
 * @param array $settings
 */
 public function initialize(&$controller, $settings = array()) {
 $this->settings = array_merge($this->__defaults, $settings);
 $this->controller =& $controller;
 }
 
 /**
 * beforeRender()
 *
* Set the variables needed by the controller.
 *
 * @access public
 * @param $controller Controller object
 */
 public function beforeRender(&$controller) {
 $controller->set('paginationOptions', $this->settings['options']);
 $controller->set('paginationLimit', $this->paginationLimit());
 }
 
/**
 *
 * Set the controller's $paginate variable.
 *
 * @access public
 * @param array $options
 */
 public function setPaginate($options = array()) {
 $defaults = array(
 'limit' => $this->paginationLimit()
 );
 
 $this->controller->paginate = array_merge($defaults, $options);
 }
 
 /**
 * Set the pagination limit based on user input and session variables.
*
 * @access public
 */
 public function paginationLimit() {
if (isset($this->controller->params['named']['Paginate'])) {
 $this->Session->write('Pagination.limit', $this->controller->params['named']['Paginate']);
 }
 
 return ($this->Session->check('Pagination.limit') ? $this->Session->read('Pagination.limit') :
 $this->settings['defaultLimit']);
 }
 
}
 
?>
