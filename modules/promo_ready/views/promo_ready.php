<?php
class promo_readyViewPrt extends viewPrt {
	
	 public function displayAdminFooter() {
        parent::display('adminFooter');
    }
	
	public function showWelcomePage() {
		$this->assign('askOptions', array(
			1 => array('label' => 'Google'),
			2 => array('label' => 'Wordpress.org'),
			3 => array('label' => 'Reffer a friend'),
			4 => array('label' => 'Find on the web'),
			5 => array('label' => 'Other way...'),
		));
		//parent::display('welcomePage');
		return parent::getContent('welcomePage');
	}
	
	public function showAdminSendStatNote() {
		parent::display('adminSendStatNote');
	}	
	
}
?>