<?php
class adminmenuViewPrt extends viewPrt {
    protected $_file = '';
    /**
     * Array for standart menu pages
     * @see initMenu method
     */
	 
    public function init() {
        $this->_file = __FILE__;
        parent::init();
    }
	
    public function initMenu() {
	
    }
	
    public function getFile() {
        return $this->_file;
    }
    /*public function getOptions() {
        return $this->_options;
    }*/
	
}