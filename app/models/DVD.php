<?php
require_once 'Product.php';

class DVD extends Product
{
    private $size;

    public function __construct($sku, $name, $price, $attributes)
    {
        parent::__construct($sku, $name, $price, 'DVD');
        $this->size = $attributes['size'] ?? null;
    }

    // Return the specific query for this product type
    public function getInsertQuery()
    {
        return "INSERT INTO products (sku, name, price, type, size_mb) VALUES (?, ?, ?, ?, ?)";
    }

    // Bind specific parameters for this product type
    public function bindParams($stmt)
    {
        $stmt->bind_param("ssdsi", $this->sku, $this->name, $this->price, $this->type, $this->size);
    }
}
