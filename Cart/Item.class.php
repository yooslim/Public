<?php
/* YOo Slim | 2013 | https://github.com/YOoSlim */

class Item {
	const DEFAULT_IMAGE = 'img/def_item.png';
    private $id = null; // Obligatory
    private $reference = null; // Obligatory
    private $quantity = null;
	private $image = null;

    public function __construct($id, $ref, $quant = 1, $img = null) {
        $this->setID($id);
        $this->setReference($ref);
        $this->setQuantity($quant);
		$this->setImage($img);
    }
	
	public function setID($id) {
		$id = intval($id);
		if($id != 0) $this->id = $id;
	}
	
	public function setReference($ref) {
		if(!empty($ref)) $this->reference = $ref;
	}

    public function setQuantity($quant) {
        if($quant >= 0) $this->quantity = $quant;
    }
	
	public function setImage($img) {
		if(!empty($img)) $this->image = $img;
	}
	
	public function getID() {
		return $this->id;
	}
	
	public function getReference() {
		return $this->reference;
	}
	
	public function getQuantity() {
		return $this->quantity;
	}
	
	public function addItemCopies($quant = 1) {
		if($this->quantity + $quant >= 0) $this->quantity += $quant;
	}
	
	public function isCorrect() {
		if(!empty($this->reference) AND $this->id != null) return true;
		else return false;
	}
}
?>