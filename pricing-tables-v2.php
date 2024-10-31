<?php
/*
Plugin Name: Pricing Table Ready!
Plugin URI: http://readyshoppingcart.com/product/pricing-table-ready-plugin-pro/
Description: Pricing Table Ready! WordPress plugin allow you generate and manage CSS pricing table or comparison table with table generator in the easy way.
Author: Pricing Table
Version: 0.3.6
Author URI: http://readyshoppingcart.com
*/

    require_once(dirname(__FILE__). DIRECTORY_SEPARATOR. 'config.php');
    require_once(dirname(__FILE__). DIRECTORY_SEPARATOR. 'functions.php');

    importClassPrt('dbPrt');
    importClassPrt('installerPrt');
    importClassPrt('baseObjectPrt');
    importClassPrt('modulePrt');
    importClassPrt('modelPrt');
    importClassPrt('viewPrt');
    importClassPrt('controllerPrt');
    importClassPrt('helperPrt');
    importClassPrt('tabPrt');
    importClassPrt('dispatcherPrt');
    importClassPrt('fieldPrt');
    importClassPrt('tablePrt');
    importClassPrt('framePrt');
    importClassPrt('langPrt');
    importClassPrt('reqPrt');
    importClassPrt('uriPrt');
    importClassPrt('htmlPrt');
    importClassPrt('responsePrt');
    importClassPrt('fieldAdapterPrt');
    importClassPrt('validatorPrt');
    importClassPrt('errorsPrt');
    importClassPrt('utilsPrt');
    importClassPrt('modInstallerPrt');
    importClassPrt('wpUpdater');
	importClassPrt('toeWordpressWidgetPrt');
	importClassPrt('installerDbUpdaterPrt');
	importClassPrt('templateModulePrt');
	importClassPrt('templateViewPrt');
	importClassPrt('fileuploaderPrt');
	//importClassPrt('PclZip', BUP_HELPERS_DIR. 'plczip.lib.php');
	//importClassPrt('recapcha',			BUP_HELPERS_DIR. 'recapcha.php');
	//importClassPrt('mobileDetect',		BUP_HELPERS_DIR. 'mobileDetect.php');

    installerPrt::update();
    errorsPrt::init();
    
    dispatcherPrt::doAction('onBeforeRoute');
    framePrt::_()->parseRoute();
    dispatcherPrt::doAction('onAfterRoute');

    dispatcherPrt::doAction('onBeforeInit');
    framePrt::_()->init();
    dispatcherPrt::doAction('onAfterInit');

    dispatcherPrt::doAction('onBeforeExec');
    framePrt::_()->exec();
    dispatcherPrt::doAction('onAfterExec');