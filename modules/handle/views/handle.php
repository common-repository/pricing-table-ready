<?php
class handleViewPrt extends viewPrt {
   	public function getTicketPopupTemplate($multiVar){
		$this->assign('multiVar', $multiVar);
		return parent::getContent('ticketPopupTemplate');
	}
}