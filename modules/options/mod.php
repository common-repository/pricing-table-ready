<?php
class optionsPrt extends modulePrt {
    /**
     * Method to trigger the database update
     */
    public function init(){
        parent::init();
    }
    /**
     * This method provides fast access to options model method get
     * @see optionsModel::get($d)
     */
    public function get($d = array()) {
        return $this->getController()->getModel()->get($d);
    }
	
	public function getPostMeta($id, $meta_key) {
        return $this->getModel()->getPostMeta($id, $meta_key);
    }
	
	
}

