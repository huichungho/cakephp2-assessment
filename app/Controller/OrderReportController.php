<?php
	class OrderReportController extends AppController{

		public function index(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));
			// debug($orders);exit;

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
			// debug($portions);exit;

			// To Do - write your own array in this format
			// $order_reports = array('Order 1' => array(
			// 							'Ingredient A' => 1,
			// 							'Ingredient B' => 12,
			// 							'Ingredient C' => 3,
			// 							'Ingredient G' => 5,
			// 							'Ingredient H' => 24,
			// 							'Ingredient J' => 22,
			// 							'Ingredient F' => 9,
			// 						),
			// 					  'Order 2' => array(
			// 					  		'Ingredient A' => 13,
			// 					  		'Ingredient B' => 2,
			// 					  		'Ingredient G' => 14,
			// 					  		'Ingredient I' => 2,
			// 					  		'Ingredient D' => 6,
			// 					  	),
			// 					);

			// ...

			// order <identified by> order_details <has many> items(dishes) <comprises of> portions <identified by> portion_details <has many> parts(ingredients)
			// SQL - select orders.id, orders.name, items.name, order_details.quantity, portions.name, portion_details.value, parts.name 
			// from orders inner join order_details on orders.id = order_details.order_id inner join items on order_details.item_id = items.id inner join portions on items.id = portions.item_id inner join portion_details on portions.id = portion_details.portion_id inner join parts on portion_details.part_id = parts.id where orders.id = 2;

			$data = $this->Order->find('all', array(
				'joins' => array(
					array(
						'table' => 'order_details',
						'type' => 'INNER',
						'conditions' =>'order_details.order_id = Order.id'
					),
					array(
						'table' => 'items',
						'type' => 'INNER',
						'conditions' =>'items.id = order_details.item_id'
					),array(
						'table' => 'portions',
						'type' => 'INNER',
						'conditions' =>'portions.item_id = items.id'
					),array(
						'table' => 'portion_details',
						'type' => 'INNER',
						'conditions' =>'portion_details.portion_id = portions.id'
					),array(
						'table' => 'parts',
						'type' => 'INNER',
						'conditions' =>'portion_details.part_id = parts.id'
					)
				),
				'conditions' => array(
					'Order.valid' => 1,
					// 'Order.id' => 2
				),
				'fields' => array('Order.name', 'order_details.quantity', 'portion_details.value', 'parts.name'),
				'order' => array(['Order.id ASC', 'parts.name ASC']) // sort precedence
			));

			// post process ingredients prices
			foreach ($data as $record) {
				if (!isset($orderInfo[$record['Order']['name']])) {
					$orderInfo[$record['Order']['name']] = array();
				}
				if (isset($orderInfo[$record['Order']['name']][$record['parts']['name']])) {
					$orderInfo[$record['Order']['name']][$record['parts']['name']] += $record['order_details']['quantity']*$record['portion_details']['value'];
				} else {
					$orderInfo[$record['Order']['name']][$record['parts']['name']]  = $record['order_details']['quantity']*$record['portion_details']['value'];
				}
			}

			// debug($orderInfo);
			// exit;

			$this->set('order_reports',$orderInfo);

			// tab 2 & 3 - duplicate from questions
			$this->set('orders',$orders);

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
				
			// debug($portions);exit;

			$this->set('portions',$portions);

			$this->set('title',__('Question - Orders Report'));








			$this->set('title',__('Orders Report'));
		}

		public function Question(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));

			// debug($orders);exit;

			$this->set('orders',$orders);

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
				
			// debug($portions);exit;

			$this->set('portions',$portions);

			$this->set('title',__('Question - Orders Report'));
		}

	}