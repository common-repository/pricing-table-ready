<?php
/**
 * Class for templates module tab at options page
 */
class templatesViewPrt extends viewPrt {
    /**
     * Get the content for templates module tab
     * 
     * @return type 
     */
    public function getTabContent(){
       $templates = framePrt::_()->getModule('templatesPrt')->getModel()->get();
       if(empty($templates)) {
           $tpl = 'noTemplates';
       } else {
           $this->assign('templatesPrt', $templates);
           $this->assign('default_theme', framePrt::_()->getModule('optionsPrt')->getModel()->get('default_theme'));
           $tpl = 'templatesTab';
       }
       return parent::getContent($tpl);
   }
}

