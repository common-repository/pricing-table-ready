<?php
class installerPrt {
	static public $update_to_version_method = '';
	static public function init() {
		global $wpdb;
		$wpPrefix = $wpdb->prefix; 
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		$current_version = get_option(PRT_DB_PREF. 'db_version', 0);
		$installed = (int) get_option(PRT_DB_PREF. 'db_installed', 0);
		
		if (!dbPrt::exist($wpPrefix.PRT_DB_PREF."htmltype")) {
			$q = "CREATE TABLE IF NOT EXISTS `".$wpPrefix.PRT_DB_PREF."htmltype` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `label` varchar(32) NOT NULL,
			  `description` varchar(255) NOT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE INDEX `label` (`label`)
			) DEFAULT CHARSET=utf8";
			dbDelta($q);
		}
		dbPrt::query("INSERT INTO `".$wpPrefix.PRT_DB_PREF."htmltype` VALUES
			(1, 'text', 'Text'),
			(2, 'password', 'Password'),
			(3, 'hidden', 'Hidden'),
			(4, 'checkbox', 'Checkbox'),
			(5, 'checkboxlist', 'Checkboxes'),
			(6, 'datepicker', 'Date Picker'),
			(7, 'submit', 'Button'),
			(8, 'img', 'Image'),
			(9, 'selectbox', 'Drop Down'),
			(10, 'radiobuttons', 'Radio Buttons'),
			(11, 'countryList', 'Countries List'),
			(12, 'selectlist', 'List'),
			(13, 'countryListMultiple', 'Country List with posibility to select multiple countries'),
			(14, 'block', 'Will show only value as text'),
			(15, 'statesList', 'States List'),
			(16, 'textFieldsDynamicTable', 'Dynamic table - multiple text options set'),
			(17, 'textarea', 'Textarea'),
			(18, 'checkboxHiddenVal', 'Checkbox with Hidden field')");
		/**
		 * modules 
		 */
		if (!dbPrt::exist($wpPrefix.PRT_DB_PREF."modules")) {
			$q = "CREATE TABLE IF NOT EXISTS `".$wpPrefix.PRT_DB_PREF."modules` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `code` varchar(64) NOT NULL,
			  `active` tinyint(1) NOT NULL DEFAULT '0',
			  `type_id` smallint(3) NOT NULL DEFAULT '0',
			  `params` text,
			  `has_tab` tinyint(1) NOT NULL DEFAULT '0',
			  `label` varchar(128) DEFAULT NULL,
			  `description` text,
			  `ex_plug_dir` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE INDEX `code` (`code`)
			) DEFAULT CHARSET=utf8;";
			dbDelta($q);
		}
		dbPrt::query("INSERT INTO `".$wpPrefix.PRT_DB_PREF."modules` (id, code, active, type_id, params, has_tab, label, description) VALUES
		  (NULL, 'adminmenu',1,1,'',0,'Admin Menu',''),
		  (NULL, 'handle',1,1,'',0,'Hendle',''),
		  (NULL, 'options',1,1,'',1,'Options',''),
		  (NULL, 'pages',1,1,'',1,'Pages',''),
		  (NULL, 'templates',1,1,'',0,'Templates for Plugin',''),
		  (NULL, 'promo_ready',1,1,'',0,'Promo ready','')
		   ;");

		
		/**
		 *  modules_type 
		 */
		if(!dbPrt::exist($wpPrefix.PRT_DB_PREF."modules_type")) {
			$q = "CREATE TABLE IF NOT EXISTS `".$wpPrefix.PRT_DB_PREF."modules_type` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `label` varchar(64) NOT NULL,
			  PRIMARY KEY (`id`)
			) AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;";
			dbDelta($q);
		}
		dbPrt::query("INSERT INTO `".$wpPrefix.PRT_DB_PREF."modules_type` VALUES
		  (1,'system'),
		  (2,'addons')
		  ");
		/**
		 * options 
		 */
		if(!dbPrt::exist($wpPrefix.PRT_DB_PREF."options")) {
			$q = "CREATE TABLE IF NOT EXISTS `".$wpPrefix.PRT_DB_PREF."options` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `code` varchar(64) CHARACTER SET latin1 NOT NULL,
			  `value` longtext NULL,
			  `label` varchar(128) CHARACTER SET latin1 DEFAULT NULL,
			  `description` text CHARACTER SET latin1,
			  `htmltype_id` smallint(2) NOT NULL DEFAULT '1',
			  `params` text NULL,
			  `cat_id` mediumint(3) DEFAULT '0',
			  `sort_order` mediumint(3) DEFAULT '0',
			  `value_type` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  KEY `id` (`id`),
			  UNIQUE INDEX `code` (`code`)
			) DEFAULT CHARSET=utf8";
			dbDelta($q);
		}
		$eol = "\n";
		$msgText = 'We apologize, but at this time our site does not work. But we promise you, very soon we will resume work. '. $eol. 'We just want to improve our site for your comfort.Be among the first to see our new website! Just send your email using the form below and we will inform you.';
		dbPrt::query("INSERT INTO `".$wpPrefix.PRT_DB_PREF."options` (`id`,`code`,`value`,`label`,`description`,`htmltype_id`,`params`,`cat_id`,`sort_order`,`value_type`) VALUES 
			(NULL,'constructor','1','Number constructor','Number constructor',1,'',0,0,'')
			;");
			//(NULL,'full','1','Full backup','on/off full backup',1,'',0,0,'dest_backup'),
			
			/* options categories */
		if(!dbPrt::exist($wpPrefix.PRT_DB_PREF."options_categories")) {
			$q = "CREATE TABLE IF NOT EXISTS `".$wpPrefix.PRT_DB_PREF."options_categories` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `label` varchar(128) NOT NULL,
			  PRIMARY KEY (`id`),
			  KEY `id` (`id`)
			) DEFAULT CHARSET=utf8";
			dbDelta($q);
		}
		
		dbPrt::query("INSERT INTO `".$wpPrefix.PRT_DB_PREF."options_categories` VALUES
			(1, 'General'),
			(2, 'Template')
			;");
			
			
		/**
		 * Log table - all logs in project
		 */
		if(!dbPrt::exist($wpPrefix.PRT_DB_PREF."log")) {
			dbDelta("CREATE TABLE `".$wpPrefix.PRT_DB_PREF."log` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `type` varchar(64) NOT NULL,
			  `data` text,
			  `date_created` int(11) NOT NULL DEFAULT '0',
			  `uid` int(11) NOT NULL DEFAULT 0,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8");
		}
		/**
		* Files
		*/
	   if(!dbPrt::exist($wpPrefix.PRT_DB_PREF."files")) {
		   dbDelta("CREATE TABLE IF NOT EXISTS `".$wpPrefix.PRT_DB_PREF."files` (
			 `id` int(11) NOT NULL AUTO_INCREMENT,
			 `pid` int(11) NOT NULL,
			 `name` varchar(255) NOT NULL,
			 `path` varchar(255) NOT NULL,
			 `mime_type` varchar(255) DEFAULT NULL,
			 `size` int(11) NOT NULL DEFAULT '0',
			 `active` tinyint(1) NOT NULL,
			 `date` datetime DEFAULT NULL,
			 `download_limit` int(11) NOT NULL DEFAULT '0',
			 `period_limit` int(11) NOT NULL DEFAULT '0',
			 `description` text NOT NULL,
			 `type_id` SMALLINT(5) NOT NULL DEFAULT 1,
			 PRIMARY KEY (`id`)
		   ) DEFAULT CHARSET=utf8");
	   }
		
		
		installerDbUpdaterPrt::runUpdate(); 
		
		update_option(PRT_DB_PREF. 'db_version', PRT_VERSION);
		add_option(PRT_DB_PREF. 'db_installed', 1);
		dbPrt::query("UPDATE `".$wpPrefix.PRT_DB_PREF."options` SET value = '". PRT_VERSION. "' WHERE code = 'version' LIMIT 1");
		
		$warehouse = ABSPATH.$warehouse;
		if (!file_exists($warehouse)) {
			utilsPrt::createDir($warehouse, $params = array('chmod' => 0755, 'httpProtect' => 2));
		}
	}
	
	
	
	/**
	 * Create pages for plugin usage
	 */
	
	/**
	 * Return page data from given array, searched by title, used in self::createPages()
	 * @return mixed page data object if success, else - false
	 */
	static private function _getPageByTitle($title, $pageArr) {
		foreach($pageArr as $p) {
			if($p->title == $title)
				return $p;
		}
		return false;
	}
	static public function delete() {
		global $wpdb;
		$wpPrefix = $wpdb->prefix; 
		$deleteOptions = reqPrt::getVar('deleteOptions');
		
		if(is_null($deleteOptions)) {
			framePrt::_()->getModule('options')->getView()->displayDeactivatePage();
			exit();
		}
		
		if((bool) $deleteOptions) {
			$wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.PRT_DB_PREF."modules`");
			$wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.PRT_DB_PREF."modules_type`");
			$wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.PRT_DB_PREF."options`");
			$wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.PRT_DB_PREF."options_categories`");
			$wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.PRT_DB_PREF."htmltype`");
			$wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.PRT_DB_PREF."files`");
			$wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.PRT_DB_PREF."log`");
		}
		delete_option(PRT_DB_PREF. 'db_version');
		delete_option(PRT_DB_PREF. 'db_installed');
	}
	static protected function _addPageToWP($post_title, $post_parent = 0) {
		return wp_insert_post(array(
			 'post_title' => langPrt::_($post_title),
			 'post_content' => langPrt::_($post_title. ' Page Content'),
			 'post_status' => 'publish',
			 'post_type' => 'page',
			 'post_parent' => $post_parent,
			 'comment_status' => 'closed'
		));
	}
	static public function update() {
		global $wpdb;
		$wpPrefix = $wpdb->prefix; /* add to 0.0.3 Versiom */
		$currentVersion = get_option(PRT_DB_PREF.'db_version', 0);
		$installed = (int) get_option(PRT_DB_PREF.'db_installed', 0);
		
		if($installed && version_compare(PRT_VERSION, $currentVersion, '>')) {
			self::init();
			update_option(PRT_DB_PREF.'db_version', PRT_VERSION);
		}
	}
	static public function setUsed() {
			update_option(PRT_DB_PREF. 're_used', 1);
		}
	static public function isUsed() {
		return (int) get_option(PRT_DB_PREF. 're_used');
	}
}
