<?php
class templatesPrt extends modulePrt {
    /**
     * Returns the available tabs
     * 
     * @return array of tab 
     */
    protected $_styles = array();
    public function getTabs(){
        $tabs = array();
        $tab = new tabPrt(langPrt::_('Templates'), $this->getCode());
        $tab->setView('templatesTab');
		$tab->setSortOrder(1);
        $tabs[] = $tab;
        return $tabs;
    }
    public function init() {
        $this->_styles = array(
            'stylePrt'				=> array('path' => PRT_CSS_PATH. 'style.css'), 
			'adminStylesPrt'		=> array('path' => PRT_CSS_PATH. 'adminStyles.css'), 
			
			'jquery-tabs'			=> array('path' => PRT_CSS_PATH. 'jquery-tabs.css'),
			'jquery-buttons'		=> array('path' => PRT_CSS_PATH. 'jquery-buttons.css'),
			'wp-jquery-ui-dialog'	=> array(),
			'farbtastic'			=> array(),
			// Our corrections for ui dialog
			'jquery-dialog'			=> array('path' => PRT_CSS_PATH. 'jquery-dialog.css'),
			'jquery-progress'			=> array('path' => PRT_CSS_PATH. 'jquery-progress.css'),
        );
        $defaultPlugTheme = framePrt::_()->getModule('options')->get('default_theme');
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
			'siteLang'					=> langPrt::getData(),
			'options'					=> framePrt::_()->getModule('options')->getByCode(),
			'PRT_CODE'					=> PRT_CODE,
        );
        $jsData = dispatcherPrt::applyFilters('jsInitVariables', $jsData);

		framePrt::_()->addScript('jquery');
		framePrt::_()->addScript('jquery-ui-tabs', '', array('jquery'));
		framePrt::_()->addScript('jquery-ui-dialog', '', array('jquery'));
		framePrt::_()->addScript('jquery-ui-button', '', array('jquery'));
		 	
		framePrt::_()->addScript('farbtastic');

		framePrt::_()->addScript('commonPrt', PRT_JS_PATH. 'common.js');
		framePrt::_()->addScript('corePrt', PRT_JS_PATH. 'core.js');
		
		if (framePrt::_()->isTablesEditAdminPage()){
			framePrt::_()->addScript('adminOptionsPrt', PRT_JS_PATH. 'admin.options.js');
		}
		
        //if (is_admin()) {
			//framePrt::_()->addScript('adminOptionsPrt', PRT_JS_PATH. 'admin.options.js');
			framePrt::_()->addScript('ajaxupload', PRT_JS_PATH. 'ajaxupload.js');
			framePrt::_()->addScript('postbox', get_bloginfo('wpurl'). '/wp-admin/js/postbox.js');
		//} else {

        //}
        framePrt::_()->addJSVar('corePrt', 'PRT_DATA', $jsData);

		/*$desktop = true;
		if(utilsPrt::isTablet()) {
			$this->_styles['style-tablet'] = array();
			$desktop = false;
		} elseif(utilsPrt::isMobile()) {
			$this->_styles['style-mobile'] = array();
			$desktop = false;
		}
		if($desktop) {
			$this->_styles['style-desctop'] = array();
		}*/
        
        foreach($this->_styles as $s => $sInfo) {
            if(isset($sInfo['for'])) {
                if(($sInfo['for'] == 'frontend' && is_admin()) || ($sInfo['for'] == 'admin' && !is_admin()))
                    continue;
            }
            $canBeSubstituted = true;
            if(isset($sInfo['substituteFor'])) {
                switch($sInfo['substituteFor']) {
                    case 'frontend':
                        $canBeSubstituted = !is_admin();
                        break;
                    case 'admin':
                        $canBeSubstituted = is_admin();
                        break;
                }
            }
            if($canBeSubstituted && file_exists(PRT_TEMPLATES_DIR. $defaultPlugTheme. DS. $s. '.css')) {
                framePrt::_()->addStyle($s, PRT_TEMPLATES_PATH. $defaultPlugTheme. '/'. $s. '.css');
            } elseif($canBeSubstituted && file_exists(utilsPrt::getCurrentWPThemeDir(). 'csp'. DS. $s. '.css')) {
                framePrt::_()->addStyle($s, utilsPrt::getCurrentWPThemePath(). '/toe/'. $s. '.css');
            } elseif(!empty($sInfo['path'])) {
                framePrt::_()->addStyle($s, $sInfo['path']);
            } else {
				framePrt::_()->addStyle($s);
			}
        }
		add_action('wp_head', array($this, 'addInitJsVars'));
        parent::init();
    }
	/**
	 * Some JS variables should be added after first wordpress initialization.
	 * Do it here.
	 */
	public function addInitJsVars() {
		/*framePrt::_()->addJSVar('adminOptions', 'PRT_PAGES', array(
			'isCheckoutStep1' => framePrt::_()->getModule('pages')->isCheckoutStep1(),
			'isCart' => framePrt::_()->getModule('pages')->isCart(),
		));*/
	}
}
