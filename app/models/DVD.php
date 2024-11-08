<?php

namespace App\Models;

use App\Helpers\ProductType;
use App\Models\ProductTrait;

class DVD extends AbstractProduct
{
    use ProductTrait;

    public function __construct($sku, $name, $price, protected float $size)
    {
        parent::__construct($sku, $name, $price, ProductType::DVD);
    }

    public function getData(): array
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => $this->price,
            'size' => $this->size,
        ];
    }

    public static function getAll(): array | null
    {
        try {
            return self::findAll('dvds'); // Ensure the correct table name
        } catch (\Exception $e) {
            self::throwDbError($e);
            return null;
        }
    }
    
}
