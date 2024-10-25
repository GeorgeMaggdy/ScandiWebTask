<?php
require_once 'Product.php';

class Book extends Product
{
    private $weight;

    public function __construct($sku, $name, $price, $attributes)
    {
        parent::__construct($sku, $name, $price, 'Book');
        $this->weight = $attributes['weight'] ?? null;
    }

    public function getInsertQuery()
    {
        return "INSERT INTO products (sku, name, price, type, weight_kg) VALUES (?, ?, ?, ?, ?)";
    }

    public function bindParams($stmt)
    {
        $stmt->bind_param("ssdsi", $this->sku, $this->name, $this->price, $this->type, $this->weight);
    }
}
