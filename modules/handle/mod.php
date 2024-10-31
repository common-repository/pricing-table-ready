<?php
class handlePrt extends modulePrt {
    public function init() {
		add_filter('wp_insert_post_data', array($this->getController(), 'savePostData'), 99, 2);
        add_action('wp_insert_post', array($this->getController(), 'saveProduct'), 99, 2);
        parent::init(); 
    }
}