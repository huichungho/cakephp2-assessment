<?php

class TransactionItemController extends AppController {

	public function index() {

		if( $this->request->is('ajax') ) {
			$this->autoRender = false;
		}
	
		if ($this->request->isPost()) {
			$transaction_items = $this->TransactionItem->find('all');
			return (json_encode($transaction_items));
		}
	}

	public function store() {
        // store to db
		// debug('saving data');
		// debug($this->data); exit;

		if( $this->request->is('ajax') ) {
			$this->autoRender = false;
		}

		if ($this->request->isPost()) {
			
			if ($this->data != null) {

				// $user = $this->TransactionItem->find('all',[
				// 	'fields' => array('amount' => 'MAX(TransactionItem.id)'),
				// ]);

				// $max = ((int)array_values($user[0][0])[0]);
				// $item->id = $max;

				$item = $this->request->data;
				$item->sum = $item->sum == null ? 0 : $item->sum;
				$item->price = $item->price == null ? 0 : $item->price;
				$item->quantity = $item->quantity == null ? 0 : $item->quantity;
				$item->transaction_id = $item->transaction_id == null ? 1 : $item->transaction;
				
				if ($this->TransactionItem->save($item)) {
					// success
					return 'saved';
				}
			}
		}
	}

	public function delete() {

		if( $this->request->is('ajax') ) {
			$this->autoRender = false;
		}

		if ($this->data != null) {
			$this->TransactionItem->id = $this->request->data['id'];
			if ($this->TransactionItem->exists($this->TransactionItem->id)) {
				if ($this->TransactionItem->delete()) {
					// success
					return 'deleted';
				}
			}
		}

		return 'nothing to delete';
	}
}