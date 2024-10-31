<?php
require_once 'Product.php';

class Furniture extends Product
{
    private $height;
    private $width;
    private $length;

    public function __construct($sku, $name, $price, $attributes)
    {
        parent::__construct($sku, $name, $price, 'Furniture');
        $this->height = $attributes['height'] ?? null;
        $this->width = $attributes['width'] ?? null;
        $this->length = $attributes['length'] ?? null;
        $this->type = 'Furniture';

    }

    public function getInsertQuery()
    {
        return "INSERT INTO products (sku, name, price, type, height_cm, width_cm, length_cm) VALUES (?, ?, ?, ?, ?, ?, ?)";
    }

    public function bindParams($stmt)
    {
        $stmt->bind_param("ssdsiii", $this->sku, $this->name, $this->price, $this->type, $this->height, $this->width, $this->length);
    }
}
