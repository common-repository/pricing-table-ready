<?php
class adminmenuPrt extends modulePrt {
    public function init() {
        parent::init();
		add_action('plugins_loaded', array($this,'init_textdomain'));
        $this->getController()->getView('adminmenu')->init();
		add_thickbox();
		add_filter('the_content', array($this, 'insertTable'));
		add_action('init', array($this, 'addToWpMenu'));
		add_action('add_meta_boxes', array($this, 'mainSettings'));
		add_filter('manage_edit-'.PRT_TYPE_POST.'_columns', array($this, 'prtColumnsStruct'), 10, 1);
		add_action('manage_posts_custom_column', array($this, 'shortcodeLine'), 10, 1);
		add_shortcode('ready-pricing-tables', array($this, 'shortCode'));
		add_action('admin_footer', array($this, 'displayAdminFooter'), 9);
		
    }
	
	function mainSettings(){
		//add_meta_box('pricing-table-tables-options', __('Tables', 'Ready! pricing table'), array( $this, 'test1' ), PRT_TYPE_POST, 'normal', 'core');
		framePrt::_()->getModule('options')->getView()->getSettingPage();
	}
	
	function test1(){
		echo 'asdasd';
	}
	
	function init_textdomain()
	{
		$path = '/'. PRT_PLUG_NAME. '/'. 'lang'. '/'. get_locale(). '/';
		if ( function_exists('load_plugin_textdomain') ){
			load_plugin_textdomain( 'prtTD', false, $path);
		}
	}
	
	function addToWpMenu(){
		$labels = array(
        'name' => __('Pricing Tables', 'prtTD'),
        'singular_name' => __('Pricing Table', 'prtTD'),
        'add_new' => __('Add New', 'prtTD'),
        'add_new_item' => __('Add New Pricing Table', 'prtTD'),
        'edit_item' => __('Edit Pricing Table', 'prtTD'),
        'new_item' => __('New Pricing Table', 'prtTD'),
        'all_items' => __('All Pricing Tables', 'prtTD'),
        'view_item' => __('View Pricing Table', 'prtTD'),
        'search_items' => __('Search Pricing Tables', 'prtTD'),
        'not_found' =>  __('No Pricing Table found'.$first_start, 'prtTD'),
        'not_found_in_trash' => __('No Pricing Tables found in Trash', 'prtTD'), 
        'parent_item_colon' => '',
        'menu_name' => 'Ready! Pricing Table'
        );
		
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true, 
        'show_in_menu' => true, 
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true, 
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title'),
        'menu_icon' => PRT_PLUG_IMG_SPEC.'icon.png'
        );
		
		register_post_type(PRT_TYPE_POST, $args);
	}
	
	function displayAdminFooter(){
		if (framePrt::_()->isTablesEditAdminPage()){
			framePrt::_()->getModule('promo_ready')->displayAdminFooter();
		}
	}
	
	function shortcodeLine(){
		global $post;
		$post_type = get_post_type($post->ID);
		if ($post_type === 'ready-pricing-tables') {
        	echo '<input type=text readonly=readonly value="[ready-pricing-tables id='.$post->ID.']" size=55 style="font-weight:bold;text-align:Center;" onclick="this.select()" />';
	    } 
	}
	
	function prtColumnsStruct($columns){
		$column_shorcode = array('readyshortcode' => __('Embed Code', 'ready-pricing-tables'));
		$columns = array_slice($columns, 0, 2, true) + $column_shorcode + array_slice($columns, 2, 1, true);
	    return $columns;
	}
	
	function shortCode($atts)
	{
		return framePrt::_()->getModule('handle')->getModel()->refreshPreview($atts['id']);
	}
	
	function insertTable($content)
	{
    	global $post;
	    $post_type = get_post_type($post->ID);
	    if ($post_type === 'ready-pricing-tables') {
	        $shrt = do_shortcode('[ready-pricing-tables id='.$post->ID.']'); 
	        return $shrt;
	    } else {
	       return $content; 
    	}
	}
	
}