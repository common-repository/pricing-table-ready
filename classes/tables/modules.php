<?php
class tableModulesPrt extends tablePrt {
    public function __construct() {
        $this->_table = '@__modules';
        $this->_id = 'id';     /*Let's associate it with posts*/
        $this->_alias = 'toe_m';
        $this->_addField('label', 'text', 'varchar', 0, langPrt::_('Label'), 128)
                ->_addField('type_id', 'selectbox', 'smallint', 0, langPrt::_('Type'))
                ->_addField('active', 'checkbox', 'tinyint', 0, langPrt::_('Active'))
                ->_addField('params', 'textarea', 'text', 0, langPrt::_('Params'))
                ->_addField('has_tab', 'checkbox', 'tinyint', 0, langPrt::_('Has Tab'))
                ->_addField('description', 'textarea', 'text', 0, langPrt::_('Description'), 128)
                ->_addField('code', 'hidden', 'varchar', '', langPrt::_('Code'), 64)
                ->_addField('ex_plug_dir', 'hidden', 'varchar', '', langPrt::_('External plugin directory'), 255);
    }
}
?>
