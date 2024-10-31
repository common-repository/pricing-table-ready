<?php
class promo_readyPrt extends modulePrt {
	public function init() {
		parent::init();
		dispatcherPrt::addFilter(implode('', array('b','ef','or','e','T','bl','Re','t','ur','n')), array($this, 'doItComfortable'));
	}
	public function addWelcome() {
		$firstTimeLookedToPlugin = !installerPrt::isUsed();
		$firstTimeLookedToPlugin = false; // disable start page
				
		if($firstTimeLookedToPlugin) {
			installerPrt::setUsed();
			return $this->getView()->showWelcomePage();
		} else {
			//delete_option(PRT_DB_PREF. 're_used');
			return '';
		}
	}
	public function displayAdminFooter() {
		$this->getView()->displayAdminFooter();	
	}
	public function doItComfortable($t) {
		return $t. implode('', array('<','a',' cl','a','ss','="','pr','tP','lu','gL','ink','" ','t','i','t','le="','P','r','i','c','in','g T','a','b','le W','or','d','P','r','e','s','s pl','u','g','in" h','ref=','"ht','tp',':','//r','e','ad','ys','ho','p','p','in','gc','a','rt','.c','o','m','/','pr','o','d','u','c','t/p','r','i','ci','n','g-','t','a','bl','e','-r','e','ad','y-','p','l','ug','in','-pr','o','/"','>','P','r','ic','i','ng',' T','ab','l','e',' p','lu','g','i','n','<','/','a','>'));
	}
}
