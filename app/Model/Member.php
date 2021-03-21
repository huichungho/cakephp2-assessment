<?php

class Member extends AppModel{

	var $hasMany = array('transactions' => array(
                            'conditions' => array('transactions.valid' => 1)
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