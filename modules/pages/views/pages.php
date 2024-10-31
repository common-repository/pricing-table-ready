<?php
class pagesViewPrt extends viewPrt {
    public function displayDeactivatePage() {
        $this->assign('GET', reqPrt::get('get'));
        $this->assign('POST', reqPrt::get('post'));
        $this->assign('REQUEST_METHOD', strtoupper(reqPrt::getVar('REQUEST_METHOD', 'server')));
        $this->assign('REQUEST_URI', basename(reqPrt::getVar('REQUEST_URI', 'server')));
        parent::display('deactivatePage');
    }
}

