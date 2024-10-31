<?php

class Product {
    protected $sku;
    protected $name;
    protected $price;
    protected $type;  // New type property

    public function __construct($sku, $name, $price) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->type = '';  // Initialize type as an empty string by default
    }

    public function getSku() {
        return $this->sku;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getType() {
        return $this->type;  // New getter for type
    }

    public function getTypeSpecificAttribute() {
        return '';  // Implement in child classes
    }
}
