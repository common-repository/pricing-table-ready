<?php
class tableOptionsPrt extends tablePrt {
     public function __construct() {
        $this->_table = '@__options';
        $this->_id = 'id';     /*Let's associate it with posts*/
        $this->_alias = 'toe_opt';
        $this->_addField('id', 'text', 'int', 0, langPrt::_('ID'))->
                _addField('code', 'text', 'varchar', '', langPrt::_('Code'), 64)->
                _addField('value', 'text', 'varchar', '', langPrt::_('Value'), 134217728)->
                _addField('label', 'text', 'varchar', '', langPrt::_('Label'), 255)->
                _addField('description', 'text', 'text', '', langPrt::_('Description'))->
                _addField('htmltype_id', 'selectbox', 'text', '', langPrt::_('Type'))->
				_addField('cat_id', 'hidden', 'int', '', langPrt::_('Category ID'))->
				_addField('sort_order', 'hidden', 'int', '', langPrt::_('Sort Order'))->
				_addField('value_type', 'hidden', 'varchar', '', langPrt::_('Value Type'));;
    }
}
?>
