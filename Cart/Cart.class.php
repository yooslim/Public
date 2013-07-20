<?php
/* YOo Slim | 2013 | https://github.com/YOoSlim */

class Cart {
    private $items = array();

	// Add and item to the panel, if item already exists, then just incrementing the quantity
    public function addItem(Item $a) {
        $exist = false;

        foreach($this->items AS &$item) {
            if($item->getID() == $a->getID()) {
                $item->setReference($a->getReference());
				$item->addItemCopies();
                $exist = true;
                break;
            }
        }

        if(!$exist AND $a->isCorrect()) array_push($this->items, $a);
    }
	
	// Edit an item data if it exists 
	public function setItem($id, $quant, $newReference = null) {
		foreach($this->items AS &$item) {
            if($item->getID() == $id) {
                $item->setReference($newReference);
				$item->addItemCopies($quant);
                break;
            }
        }
		
		$this->cleanCart();
	}
	
	// Returns an item according to its position
	public function getItem($num) {
		if(array_key_exists($num, $this->items)) return $this->items[$num];
		else return null;
	}
	
	// Search for an item, returns it if found, else returns null
	public function search($id) {
		foreach($this->items AS $item) {
            if($item->getID() == $id) {
                return $item;
            }
        }
		
		return null;
	}
	
	// Returns the number of items
	public function getItemCount() {
		return count($this->items);
	}
	
	// After every item edition, checking if all the items quantities are > 0, if not, remove the concerning items
	private function cleanCart() {
		foreach($this->items AS $id=>$item) {
            if($item->getQuantity() == 0) {
                unset($this->items[$id]);
            }
        }
	}
}
?>