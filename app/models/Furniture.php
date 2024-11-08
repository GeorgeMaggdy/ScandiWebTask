<?php

namespace App\Models;

use App\Helpers\ProductType;
use App\Models\ProductTrait;

class Furniture extends AbstractProduct
{
    use ProductTrait;

    private float $height;
    private float $width;
    private float $length;

    public function __construct(string $sku, string $name, float $price, float $height, float $width, float $length)
    {
        parent::__construct($sku, $name, $price, ProductType::FURNITURE);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function getData(): array
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => $this->price,
            'height' => $this->height,
            'width' => $this->width,
            'length' => $this->length,
        ];
    }

    public static function getAll(): array | null
    {
        try {
            return self::findAll('furniture'); // Ensure the correct table name
        } catch (\Exception $e) {
            self::throwDbError($e);
            return null;
        }
    }
}
