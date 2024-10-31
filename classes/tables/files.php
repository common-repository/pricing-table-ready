<?php
class tableFilesPrt extends tablePrt {
    public function __construct() {
        $this->_table = '@__files';
        $this->_id = 'id';
        $this->_alias = 'toe_f';
        $this->_addField('pid', 'hidden', 'int', '', langPrt::_('Product ID'))
                ->_addField('name', 'text', 'varchar', '255', langPrt::_('File name'))
                ->_addField('path', 'hidden', 'text', '', langPrt::_('Real Path To File'))
                ->_addField('mime_type', 'text', 'varchar', '32', langPrt::_('Mime Type'))
                ->_addField('size', 'text', 'int', 0, langPrt::_('File Size'))
                ->_addField('active', 'checkbox', 'tinyint', 0, langPrt::_('Active Download'))
                ->_addField('date','text','datetime','',langPrt::_('Upload Date'))
                ->_addField('download_limit','text','int','',langPrt::_('Download Limit'))
                ->_addField('period_limit','text','int','',langPrt::_('Period Limit'))
                ->_addField('description', 'textarea', 'text', 0, langPrt::_('Descritpion'))
                ->_addField('type_id','text','int','',langPrt::_('Type ID'));
    }
}
