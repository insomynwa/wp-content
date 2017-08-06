<?php

class WOOCP_Batch {

	private $batchId;
	public function GetBatchId() { return $this->batchId;}
	public function SetBatchId( $batchId ) { $this->batchId = $batchId; }

	private $name;
	public function GetName() { return $this->name; }
	public function SetName( $name ) { $this->name = $name; }

	private $startDate;
	public function GetStartDate(){ return $this->startDAte; }
	public function SetStartDate( $startDate ) { $this->startDate = $startDate; } 

	private $endDate;
	public function GetEndDate(){ return $this->endDate; }
	public function SetEndDate( $endDate ) { $this->endDate = $endDate; } 

	private $stock;
	public function GetStock(){ return $this->stock; }
	public function SetStock( $stock) { $this->stock = $stock; } 

	private $price;
	public function GetPrice(){ return $this->price; }
	public function SetPrice( $price) { $this->price = $price; } 
	
	public function __construct(){

	}

	public function GetBatchesByProductId($product_id){
		$args = array(
			'post_type' => 'batch',
			'meta_key' => 'meta_product_parent',
			'meta_value' => $product_id,
		);
		$batches = get_posts($args); //var_dump($batches);die;

		$arrayBatch = array();

		$newBatch = new WOOCP_Batch();

		foreach ($batches as $batch) {

			$newBatch->batchId = $batch->ID;
			$newBatch->startDate = $batch->meta_batch_startdate;
			$newBatch->endDate = $batch->meta_batch_enddate;
			$newBatch->stock = $batch->meta_batch_stock;
			$newBatch->price = $batch->meta_batch_price;

			$arrayBatch[] = $newBatch;
		}

		return $arrayBatch;
	}
}
