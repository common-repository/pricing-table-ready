<?php
class optionsViewPrt extends viewPrt {
	public function getSettingPage() {
		add_meta_box('pricing-table-tables-options', __('Tables', 'Ready! pricing table'), array( $this, 'optTablesEditor' ), PRT_TYPE_POST, 'normal', 'core');
	    add_meta_box('pricing-table-preview', __('Preview', 'ready'), array( $this, 'optPreView' ), 'ready-pricing-tables', 'normal', 'core');
    	add_meta_box('pricing-table-options', __('Options', 'ready'), array( $this, 'optRightOptionPanel' ), 'ready-pricing-tables', 'side', 'core');
	}
	
	public function optTablesEditor(){
		global $post;
		
		$listCol = framePrt::_()->getModule('handle')->getModel()->getColumns($post->ID);
		$optList = framePrt::_()->getModule('handle')->getModel()->getOptions($post->ID);
		
		$this->assign('decsArr', $listCol[0]);
		$this->assign('optList', $optList);
		$this->assign('decsTemtale', parent::getContent('optDescColumn'));
		
		$this->assign('columns', $listCol);
		$column = parent::getContent('optColumnSet');
		$column .= parent::getContent('optColumn');
		
		
		$this->assign('dinamicColumn', $column);
		parent::display('optMainTable');
	}
	
	public function optRightOptionPanel(){
		global $post;
		$multiVar = framePrt::_()->getModule('handle')->getModel()->getOptions($post->ID);
		
		$this->assign('multiVar', $multiVar);
		$this->assign('popupTemplate', framePrt::_()->getModule('handle')->getModel()->getPopupTemlpate(0));
		parent::display('optRightMain');
	}
	
	public function optPreView(){
		echo 'preview';
	}
	
	public function refreshTables($id){
		
		$listCol = framePrt::_()->getModule('handle')->getModel()->getColumns($id);
		$optList = framePrt::_()->getModule('handle')->getModel()->getOptions($id);
		
		//print_r($optList); 
		$this->assign('decsArr', $listCol[0]);
		$this->assign('optList', $optList);
		$this->assign('decsTemtale', parent::getContent('optDescColumn'));
		
		$this->assign('columns', $listCol);
		$column = parent::getContent('optColumnSet');
		$column .= parent::getContent('optColumn');
		
		$this->assign('dinamicColumn', $column);
		
		return parent::getContent('optMainTable');
	}

	public function displayDeactivatePage() {
        $this->assign('GET', reqPrt::get('get'));
        $this->assign('POST', reqPrt::get('post'));
        $this->assign('REQUEST_METHOD', strtoupper(reqPrt::getVar('REQUEST_METHOD', 'server')));
        $this->assign('REQUEST_URI', basename(reqPrt::getVar('REQUEST_URI', 'server')));
        parent::display('deactivatePage');
    }
}
