<?php
class handleControllerPrt extends controllerPrt {
	protected $_currentPostArr = array();
	
	public function saveOptGroup(){
		$res = new responsePrt();
		$post = reqPrt::get('post');
		
		$ret = $this->getModel()->saveOptGroup($post['post_id'], $post['indata']);
		
		if ( $ret ){
			$res->addMessage(langPrt::_('<div id="insMsgInfo">changes have been saved</div>'));
			$res->addData($ret);
		}
		
		$res->pushError($this->getModel()->getErrors());

		return $res->ajaxExec();
	}
	
	public function savePostData($data , $postarr) {
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $data;
			if($data['post_type'] != PRT_TYPE_POST)  return $data;
			if(empty($this->_currentPostArr)) {     //Only one data may pass through cycle of this two methods - savePostData() and saveProduct()
				$this->_currentPostArr = $postarr;
			}
			return $data;
	}
		
	public function saveProduct($post_ID, $post) {
			//print_r($this->_currentPostArr);
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return false;
			if(!current_user_can('edit_post', $post_ID)) return false;
			if(!$post_ID) return false;
			if(empty($this->_currentPostArr)) return false;     //nothing to update
			if($post->post_type != PRT_TYPE_POST) return false;
			if (!$this->_currentPostArr['ID']) return false;
			if ($this->_currentPostArr['post_status'] == 'trash') return false;
			
			$sendCulumnArr =  $this->getModel()->rebuildArrColumn($this->_currentPostArr);
			$sendOptArr =  $this->getModel()->rebuildArrOpt($this->_currentPostArr);
			
			$this->getModel()->saveColumn($post_ID, $sendCulumnArr);
			$this->getModel()->saveOptGroup($post_ID, $sendOptArr);
			
			$this->_currentPostArr = array();   //Ready for next cycle - if need
			return true;
		}
	
	public function saveColumn(){
		$res = new responsePrt();
		$post = reqPrt::get('post');
		
		$ret = $this->getModel()->saveColumn($post['post_id'], $post['indata']);
		
		if ( $ret == 'ok'){
			$res->addData('ok');
		} else {
			$res->addMessage(langPrt::_('<div id="insMsgInfo">columns have been changes</div>'));
			$res->addData($ret);
		}
		
		$res->pushError($this->getModel()->getErrors()); 

		return $res->ajaxExec();
	}
	
	public function refreshTables(){
		$res = new responsePrt();
		$post = reqPrt::get('post');
		
		$content = framePrt::_()->getModule('options')->getView()->refreshTables($post['post_id']);
		$res->addData(array($content));
		
		return $res->ajaxExec();
	}
	
	public function addEmptyColumn(){
		$res = new responsePrt();
		$post = reqPrt::get('post');
		
		$this->getModel()->addEmptyColumn($post['post_id'], $post['num']);
		$res->addMessage(langPrt::_('<div id="insMsgInfo">columns added</div>'));
		
		return $res->ajaxExec();
	}
	
	public function refreshPreview(){
		$res = new responsePrt();
		$post = reqPrt::get('post');
		
		$options = framePrt::_()->getModule('options')->getPostMeta($post['post_id'], '_ready_options');
		if ($options['prtPrwEnable']){
			$content = $this->getModel()->refreshPreview($post['post_id']);
			$res->addMessage(langPrt::_('<div id="insMsgInfo">preview refreshed</div>'));
		} else {
			$content = 'disabled';
			$res->addMessage(langPrt::_('<div id="insMsgInfo">refresh preview disabled</div>'));
		}
		
		$res->addData(array($content));
		
		return $res->ajaxExec();
	}
	
	public function checkStyle(){
		$res = new responsePrt();
		$post = reqPrt::get('post');
		
		$content = $this->getModel()->getStyleList($post['prtTemplateSelect'], $post['prtStyleSelect']);
		$res->addData(array($content));
		
		return $res->ajaxExec();
	}
	
	public function deleteColumn(){
		$res = new responsePrt();
		$post = reqPrt::get('post');
		
		$this->getModel()->deleteColumn($post['post_id'], $post['num']);
		$res->addMessage(langPrt::_('<div id="insMsgInfo">column deleted</div>'));
		
		return $res->ajaxExec();
	}
   
}

