<?php
class promo_readyControllerPrt extends controllerPrt {
	public function sendInfo(){
		$res = new responsePrt();
		if($this->getModel()->welcomePageSaveInfo(reqPrt::get('post'))) {
			//installerPrt::setUsed();
		} else {
			$res->pushError($this->getModel()->getErrors());
		}
		return $res->ajaxExec();
	}
}
?>