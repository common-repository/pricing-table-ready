<?php
class tableLogPrt extends tablePrt {
    public function __construct() {
        $this->_table = '@__log';
        $this->_id = 'id';     /*Let's associate it with posts*/
        $this->_alias = 'toe_log';
        $this->_addField('id', 'text', 'int', 0, langPrt::_('ID'), 11)
                ->_addField('type', 'text', 'varchar', '', langPrt::_('Type'), 64)
                ->_addField('data', 'text', 'text', '', langPrt::_('Data'))
                ->_addField('date_created', 'text', 'int', '', langPrt::_('Date created'))
				->_addField('uid', 'text', 'int', 0, langPrt::_('User ID'))
				->_addField('oid', 'text', 'int', 0, langPrt::_('Order ID'));
    }
}