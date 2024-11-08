<?php
namespace App\Validators;
 use app\config\Database;

class ProductValidator
{
    protected $db;

    // Pass the database connection to the constructor
    public function __construct($dbConnection)
    {
        $this->db = $dbConnection;
    }

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
        } elseif ($this->isSkuExists($sku)) {
            $errors[] = "SKU must be unique.";
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

    private function isSkuExists($sku)
    {
        $query = $this->db->prepare("SELECT COUNT(*) FROM products WHERE sku = ?");
        $query->bind_param('s', $sku);
        $query->execute();
        $result = $query->get_result();
        $count = $result->fetch_row()[0];

        return $count > 0;
    }
}
