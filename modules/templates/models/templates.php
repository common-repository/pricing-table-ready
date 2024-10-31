<?php
class templatesModelPrt extends modelPrt {
    protected $_allTemplates = array();
    public function get($d = array()) {
        parent::get($d);
        if(empty($this->_allTemplates)) {
            $directories = utilsPrt::getDirList(PRT_TEMPLATES_DIR);
            if(!empty($directories)) {
                foreach($directories as $code => $dir) {
                    if($xml = utilsPrt::getXml($dir['path']. 'settings.xml')) {
                        $this->_allTemplates[$code] = $xml;
                        $this->_allTemplates[$code]->prevImg = PRT_TEMPLATES_PATH. $code. '/screenshot.png';
                    }
                }
            }
            if(is_dir( utilsPrt::getCurrentWPThemeDir(). 'csp'. DS )) {
                if($xml = utilsPrt::getXml( utilsPrt::getCurrentWPThemeDir(). 'csp'. DS. 'settings.xml' )) {
                    $code = utilsPrt::getCurrentWPThemeCode();
					if(strpos($code, '/') !== false) {	// If theme is in sub-folder
						$code = explode('/', $code);
						$code = trim( $code[count($code)-1] );
					}
                    $this->_allTemplates[$code] = $xml;
					if(is_file(utilsPrt::getCurrentWPThemeDir(). 'screenshot.jpg'))
						$this->_allTemplates[$code]->prevImg = utilsPrt::getCurrentWPThemePath(). '/screenshot.jpg';
					else
						$this->_allTemplates[$code]->prevImg = utilsPrt::getCurrentWPThemePath(). '/screenshot.png';
                }
            }
        }
        if(isset($d['code']) && isset($this->_allTemplates[ $d['code'] ]))
            return $this->_allTemplates[ $d['code'] ];
        return $this->_allTemplates;
    }
}
