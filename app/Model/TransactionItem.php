<?php
	class TransactionItem extends AppModel{
		// public $belongsTo = array('Transaction');

        public $belongsTo = array(
            'Transaction' => array(
                'className' => 'Transaction',
                'foreignKey' => 'transaction_id'
            )
        );
	}