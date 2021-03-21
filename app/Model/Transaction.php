<?php

class Transaction extends AppModel{

	var $belongsTo = array('Member');

	var $hasMany = array('TransactionItem' => array(
								'conditions' => array('TransactionItem.valid' => 1)
							)
						);
						
	var $inserted_ids = array();

	function afterSave($created, $options = array()) {
		if($created) {
			$this->inserted_ids[] = $this->getInsertID();
		}
		return true;
	}
}