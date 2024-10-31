<?php
class modInstallerPrt {
    static private $_current = array();
    /**
     * Install new modulePrt into plugin
     * @param string $module new modulePrt data (@see classes/tables/modules.php)
     * @param string $path path to the main plugin file from what module is installed
     * @return bool true - if install success, else - false
     */
    static public function install($module, $path) {
        $exPlugDest = explode('plugins', $path);
        if(!empty($exPlugDest[1])) {
            $module['ex_plug_dir'] = str_replace(DS, '', $exPlugDest[1]);
        }
        $path = $path. DS. $module['code'];
        if(!empty($module) && !empty($path) && is_dir($path)) {
            if(self::isModule($path)) {
                $filesMoved = false;
                if(empty($module['ex_plug_dir']))
                    $filesMoved = self::moveFiles($module['code'], $path);
                else
                    $filesMoved = true;     //Those modules doesn't need to move their files
                if($filesMoved) {
                    if(framePrt::_()->getTable('modules')->exists($module['code'], 'code')) {
                        framePrt::_()->getTable('modules')->delete(array('code' => $module['code']));
                    }
                    framePrt::_()->getTable('modules')->insert($module);
                    self::_runModuleInstall($module);
                    self::_installTables($module);
                    return true;
                    /*if(framePrt::_()->getTable('modules')->insert($module)) {
                        self::_installTables($module);
                        return true;
                    } else {
                        errorsPrt::push(langPrt::_(array('Install', $module['code'], 'failed ['. mysql_error(). ']')), errorsPrt::MOD_INSTALL);
                    }*/
                } else {
                    errorsPrt::push(langPrt::_(array('Move files for', $module['code'], 'failed')), errorsPrt::MOD_INSTALL);
                }
            } else
                errorsPrt::push(langPrt::_(array($module['code'], 'is not plugin module')), errorsPrt::MOD_INSTALL);
        }
        return false;
    }
    static protected function _runModuleInstall($module) {
        $moduleLocationDir = PRT_MODULES_DIR;
        if(!empty($module['ex_plug_dir']))
            $moduleLocationDir = utilsPrt::getPluginDir( $module['ex_plug_dir'] );
        if(is_dir($moduleLocationDir. $module['code'])) {
            importClassPrt($module['code'], $moduleLocationDir. $module['code']. DS. 'mod.php');
            $moduleClass = toeGetClassNamePrt($module['code']);
            $moduleObj = new $moduleClass($m);
            if($moduleObj) {
                $moduleObj->install();
            }
        }
    }
    /**
     * Check whether is or no module in given path
     * @param string $path path to the module
     * @return bool true if it is module, else - false
     */
    static public function isModule($path) {
        return true;
    }
    /**
     * Move files to plugin modules directory
     * @param string $code code for module
     * @param string $path path from what module will be moved
     * @return bool is success - true, else - false
     */
    static public function moveFiles($code, $path) {
        if(!is_dir(PRT_MODULES_DIR. $code)) {
            if(mkdir(PRT_MODULES_DIR. $code)) {
                utilsPrt::copyDirectories($path, PRT_MODULES_DIR. $code);
                return true;
            } else 
                errorsPrt::push(langPrt::_('Can not create module directory. Try to set permission to '. PRT_MODULES_DIR. ' directory 755 or 777'), errorsPrt::MOD_INSTALL);
        } else
            return true;
            //errorsPrt::push(langPrt::_(array('Directory', $code, 'already exists')), errorsPrt::MOD_INSTALL);
        return false;
    }
    static private function _getPluginLocations() {
        $locations = array();
        $plug = reqPrt::getVar('plugin');
        if(empty($plug)) {
            $plug = reqPrt::getVar('checked');
            $plug = $plug[0];
        }
        $locations['plugPath'] = plugin_basename( trim( $plug ) );
        $locations['plugDir'] = dirname(WP_PLUGIN_DIR. DS. $locations['plugPath']);
        $locations['xmlPath'] = $locations['plugDir']. DS. 'install.xml';
        return $locations;
    }
    static private function _getModulesFromXml($xmlPath) {
        if($xml = utilsPrt::getXml($xmlPath)) {
            if(isset($xml->modules) && isset($xml->modules->mod)) {
                $modules = array();
                $xmlMods = $xml->modules->children();
                foreach($xmlMods->mod as $mod) {
                    $modules[] = $mod;
                }
                if(empty($modules))
                    errorsPrt::push(langPrt::_('No modules were found in XML file'), errorsPrt::MOD_INSTALL);
                else
                    return $modules;
            } else
                errorsPrt::push(langPrt::_('Invalid XML file'), errorsPrt::MOD_INSTALL);
        } else
            errorsPrt::push(langPrt::_('No XML file were found'), errorsPrt::MOD_INSTALL);
        return false;
    }
    /**
     * Check whether modules is installed or not, if not and must be activated - install it
     * @param array $codes array with modules data to store in database
     * @param string $path path to plugin file where modules is stored (__FILE__ for example)
     * @return bool true if check ok, else - false
     */
    static public function check($extPlugName = '') {
        $locations = self::_getPluginLocations();
        if($modules = self::_getModulesFromXml($locations['xmlPath'])) {
            foreach($modules as $m) {
                $modDataArr = utilsPrt::xmlNodeAttrsToArr($m);
                if(!empty($modDataArr)) {
                    if(framePrt::_()->moduleExists($modDataArr['code'])) { //If module Exists - just activate it
                        self::activate($modDataArr);
                    } else {                                           //  if not - install it
                        if(!self::install($modDataArr, $locations['plugDir'])) {
                            errorsPrt::push(langPrt::_(array('Install', $modDataArr['code'], 'failed')), errorsPrt::MOD_INSTALL);
                        }
                    }
                }
            }
        } else
            errorsPrt::push(langPrt::_('Error Activate module'), errorsPrt::MOD_INSTALL);
        if(errorsPrt::haveErrors(errorsPrt::MOD_INSTALL)) {
            self::displayErrors();
            return false;
        }
        return true;
    }
    /**
     * Deactivate module after deactivating external plugin
     */
    static public function deactivate() {
        $locations = self::_getPluginLocations();
        if($modules = self::_getModulesFromXml($locations['xmlPath'])) {
            foreach($modules as $m) {
                $modDataArr = utilsPrt::xmlNodeAttrsToArr($m);
                if(framePrt::_()->moduleActive($modDataArr['code'])) { //If module is active - then deacivate it
                    if(framePrt::_()->getModule('options')->getModel('modules')->put(array(
                        'id' => framePrt::_()->getModule($modDataArr['code'])->getID(),
                        'active' => 0,
                    ))->error) {
                        errorsPrt::push(langPrt::_('Error Deactivation module'), errorsPrt::MOD_INSTALL);
                    }
                }
            }
        }
        if(errorsPrt::haveErrors(errorsPrt::MOD_INSTALL)) {
            self::displayErrors(false);
            return false;
        }
        return true;
    }
    static public function activate($modDataArr) {
        $locations = self::_getPluginLocations();
        if($modules = self::_getModulesFromXml($locations['xmlPath'])) {
            foreach($modules as $m) {
                $modDataArr = utilsPrt::xmlNodeAttrsToArr($m);
                if(!framePrt::_()->moduleActive($modDataArr['code'])) { //If module is not active - then acivate it
                    if(framePrt::_()->getModule('options')->getModel('modules')->put(array(
                        'code' => $modDataArr['code'],
                        'active' => 1,
                    ))->error) {
                        errorsPrt::push(langPrt::_('Error Activating module'), errorsPrt::MOD_INSTALL);
                    }
                }
            }
        }
    } 
    /**
     * Display all errors for module installer, must be used ONLY if You realy need it
     */
    static public function displayErrors($exit = true) {
        $errors = errorsPrt::get(errorsPrt::MOD_INSTALL);
        foreach($errors as $e) {
            echo '<b style="color: red;">'. $e. '</b><br />';
        }
        if($exit) exit();
    }
    static public function uninstall() {
        $locations = self::_getPluginLocations();
        if($modules = self::_getModulesFromXml($locations['xmlPath'])) {
            foreach($modules as $m) {
                $modDataArr = utilsPrt::xmlNodeAttrsToArr($m);
                self::_uninstallTables($modDataArr);
                framePrt::_()->getModule('options')->getModel('modules')->delete(array('code' => $modDataArr['code']));
                utilsPrt::deleteDir(PRT_MODULES_DIR. $modDataArr['code']);
            }
        }
    }
    static protected  function _uninstallTables($module) {
        if(is_dir(PRT_MODULES_DIR. $module['code']. DS. 'tables')) {
            $tableFiles = utilsPrt::getFilesList(PRT_MODULES_DIR. $module['code']. DS. 'tables');
            if(!empty($tableNames)) {
                foreach($tableFiles as $file) {
                    $tableName = str_replace('.php', '', $file);
                    if(framePrt::_()->getTable($tableName))
                        framePrt::_()->getTable($tableName)->uninstall();
                }
            }
        }
    }
    static public function _installTables($module) {
        $modDir = empty($module['ex_plug_dir']) ? 
            PRT_MODULES_DIR. $module['code']. DS : 
            utilsPrt::getPluginDir($module['ex_plug_dir']). $module['code']. DS; 
        if(is_dir($modDir. 'tables')) {
            $tableFiles = utilsPrt::getFilesList($modDir. 'tables');
            if(!empty($tableFiles)) {
                framePrt::_()->extractTables($modDir. 'tables'. DS);
                foreach($tableFiles as $file) {
                    $tableName = str_replace('.php', '', $file);
                    if(framePrt::_()->getTable($tableName))
                        framePrt::_()->getTable($tableName)->install();
                }
            }
        }
    }
}
