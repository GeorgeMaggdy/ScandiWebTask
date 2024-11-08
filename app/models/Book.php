<?php

namespace App\Models;

use App\Helpers\ProductType;
use App\Models\ProductTrait;

class Book extends AbstractProduct
{
    use ProductTrait;

    private float $weight;

    public function __construct(string $sku, string $name, float $price, float $weight)
    {
        parent::__construct($sku, $name, $price, ProductType::BOOK);
        $this->weight = $weight;
    }

    public function getData(): array
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => $this->price,
            'weight' => $this->weight,
        ];
    }

    public static function getAll(): array | null
    {
        try {
            return self::findAll('books'); // Correct table name
        } catch (\Exception $e) {
            self::throwDbError($e);
            return null;
        }
    }
}
