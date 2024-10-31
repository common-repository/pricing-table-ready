<?php
class templateViewPrt extends viewPrt {
	protected $_styles = array();
	protected $_scripts = array();
	/**
	 * Provide or not html code of subscribe for to template. Can be re-defined for child classes
	 */
	protected $_useSubscribeForm = true;
	/**
	 * Provide or not html code of social icons for to template. Can be re-defined for child classes
	 */
	protected $_useSocIcons = true;
	public function getComingSoonPageHtml() {
		$this->_beforeShow();
		
		$this->assign('msgTitle', framePrt::_()->getModule('options')->get('msg_title'));
		$this->assign('msgTitleColor', framePrt::_()->getModule('options')->get('msg_title_color'));
		$this->assign('msgTitleFont', framePrt::_()->getModule('options')->get('msg_title_font'));
		$msgTitleStyle = array();
		if(!empty($this->msgTitleColor))
			$msgTitleStyle['color'] = $this->msgTitleColor;
		if(!empty($this->msgTitleFont)) {
			$msgTitleStyle['font-family'] = $this->msgTitleFont;
			$this->_styles[] = 'http://fonts.googleapis.com/css?family='. $this->msgTitleFont. '&subset=latin,cyrillic-ext';
		}
		$this->assign('msgTitleStyle', utilsPrt::arrToCss( $msgTitleStyle ));
		
		$this->assign('msgText', framePrt::_()->getModule('options')->get('msg_text'));
		$this->assign('msgTextColor', framePrt::_()->getModule('options')->get('msg_text_color'));
		$this->assign('msgTextFont', framePrt::_()->getModule('options')->get('msg_text_font'));
		$msgTextStyle = array();
		if(!empty($this->msgTextColor))
			$msgTextStyle['color'] = $this->msgTextColor;
		if(!empty($this->msgTextFont)) {
			$msgTextStyle['font-family'] = $this->msgTextFont;
			if($this->msgTitleFont != $this->msgTextFont)
				$this->_styles[] = 'http://fonts.googleapis.com/css?family='. $this->msgTextFont. '&subset=latin,cyrillic-ext';
		}
		$this->assign('msgTextStyle', utilsPrt::arrToCss( $msgTextStyle ));
		
		if($this->_useSubscribeForm && framePrt::_()->getModule('options')->get('sub_enable')) {
			$this->_scripts[] = framePrt::_()->getModule('subscribe')->getModPath(). 'js/frontend.subscribe.js';
			$this->assign('subscribeForm', framePrt::_()->getModule('subscribe')->getController()->getView()->getUserForm());
		}
		if($this->_useSocIcons) {
			$this->assign('socIcons', framePrt::_()->getModule('social_icons')->getController()->getView()->getFrontendContent());
		}
		
		if(file_exists($this->getModule()->getModDir(). 'css/style.css'))
			$this->_styles[] = $this->getModule()->getModPath(). 'css/style.css';
		
		$this->assign('logoPath', $this->getModule()->getLogoImgPath());
		$this->assign('bgCssAttrs', dispatcherPrt::applyFilters('tplBgCssAttrs', $this->getModule()->getBgCssAttrs()));
		$this->assign('styles', dispatcherPrt::applyFilters('tplStyles', $this->_styles));
		$this->assign('scripts', dispatcherPrt::applyFilters('tplScripts', $this->_scripts));
		$this->assign('initJsVars', dispatcherPrt::applyFilters('tplInitJsVars', $this->initJsVars()));
		$this->assign('messages', framePrt::_()->getRes()->getMessages());
		$this->assign('errors', framePrt::_()->getRes()->getErrors());
		return parent::getContent($this->getCode(). 'PRTHtml');
	}
	public function addScript($path) {
		if(!in_array($path, $this->_scripts))
			$this->_scripts[] = $path;
	}
	public function addStyle($path) {
		if(!in_array($path, $this->_styles))
			$this->_styles[] = $path;
	}
	public function initJsVars() {
		$ajaxurl = admin_url('admin-ajax.php');
		if(framePrt::_()->getModule('options')->get('ssl_on_ajax')) {
			$ajaxurl = uriPrt::makeHttps($ajaxurl);
		}
		$jsData = array(
			'siteUrl'					=> PRT_SITE_URL,
			'imgPath'					=> PRT_IMG_PATH,
			'loader'					=> PRT_LOADER_IMG, 
			'close'						=> PRT_IMG_PATH. 'cross.gif', 
			'ajaxurl'					=> $ajaxurl,
			'animationSpeed'			=> framePrt::_()->getModule('options')->get('js_animation_speed'),
			'PRT_CODE'					=> PRT_CODE,
		);
		return '<script type="text/javascript">
		// <!--
			var PRT_DATA = '. utilsPrt::jsonEncode($jsData). ';
		// -->
		</script>';
	}
	protected function _beforeShow() {
		
	}
}