<?php
class tableModules_typePrt extends tablePrt {
    public function __construct() {
        $this->_table = '@__modules_type';
        $this->_id = 'id';     /*Let's associate it with posts*/
        $this->_alias = 'toe_m_t';
        $this->_addField($this->_id, 'text', 'int', '', langPrt::_('ID'))->
                _addField('label', 'text', 'varchar', '', langPrt::_('Label'), 128);
    }
}
?>
