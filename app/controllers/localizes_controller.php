<?php 
/**
 * function for localization
 */

uses("L10n");
class LocalizesController extends AppController {
    var $name = 'Localize';
    var $uses = array();
/**
 * function for changing the language based on the language selected
 *
 * @param string $lang
 */
    function change ($lang = null) {

        #$url = $this->referer(null, true);
	$url = $_SERVER["HTTP_REFERER"];

		$lang = $this->params['form']['selected_lang'];
		
		$this->L10n = new L10n();

		$this->L10n->get($lang);

		$_SESSION['Config']['language'] = $lang;
		$this->Session->write('FROM_LANG','1');// for the correct switching of language based on the header lang and manual lang change
        $this->redirect($url, null, true);
    }
} 
?>
