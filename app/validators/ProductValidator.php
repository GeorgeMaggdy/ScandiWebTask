<?php

class ProductValidator
{
    public function validate($data)
    {
        $errors = [];
        $sku = trim($data['sku']);
        $name = trim($data['name']);
        $price = trim($data['price']);
        $productType = $data['type'];

        // General validations
        if (empty($sku)) {
            $errors[] = "SKU is required.";
        }
        if (empty($name)) {
            $errors[] = "Name is required.";
        }
        if (empty($price) || !is_numeric($price)) {
            $errors[] = "Valid price is required.";
        }
        if (empty($productType)) {
            $errors[] = "Product type is required.";
        }

        // Type-specific validations
        if ($productType === 'DVD' && empty($data['size'])) {
            $errors[] = "Size in MB is required for DVD.";
        }
        if ($productType === 'Book' && empty($data['weight'])) {
            $errors[] = "Weight in KG is required for Book.";
        }
        if ($productType === 'Furniture') {
            if (empty($data['height']) || empty($data['width']) || empty($data['length'])) {
                $errors[] = "All dimensions (height, width, length) are required for Furniture.";
            }
        }

        return $errors;
    }
}
