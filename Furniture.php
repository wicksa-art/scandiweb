<?php
include_once 'Product.php';

class Furniture extends Product {
    private $dimensions;

    public function __construct($sku, $name, $price, $dimensions) {
        parent::__construct($sku, $name, $price);
        $this->dimensions = $dimensions;
    }

    public function getSpecificAttribute() {
        return $this->dimensions;
    }
}
?>
