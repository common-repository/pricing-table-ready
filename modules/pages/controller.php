<?php
class pagesControllerPrt extends controllerPrt {
    public function recreatePages() {
		$res = new responsePrt();
		if($this->getModel()->recreatePages()) {
			$res->addMessage(langPrt::_('Pages was recreated'));
		} else {
			$res->pushError($this->getModel()->getErrors());
		}
		$res->ajaxExec();
	}
}

