<?php

declare(strict_types=1);

namespace App\Models;

use App\Config\Database;
use App\Helpers\HttpResponse;
use App\Helpers\Constants;


class Products
{
    public static function get(): array
    {
        try {
            $books = Book::getAll();
            $dvds = DVD::getAll();
            $furnitures = Furniture::getAll();

            $allProducts = array_merge($books, $dvds, $furnitures);

            // Sort products by SKU value
            usort($allProducts, fn($a, $b) => strcmp($a['sku'], $b['sku']));

            return $allProducts;
        } catch (\Exception $e) {
            HttpResponse::dbError($e->getMessage());
            return [];
        }
    }

    public static function add(): void
    {
        try {
            $data = $_POST;
            $floats = array_merge(['price'], ...array_values(Constants::PROPERTY_MAP));
            $keys = array_keys($data);

            // Convert relevant attributes to float
            foreach ($floats as $f) {
                if (in_array($f, $keys)) {
                    $data[$f] = (float)$data[$f];
                }
            }

            $type = strtolower($data['type']);
            unset($data['type']);

            $class = "App\\Models\\" . ucfirst($type);
            $reflector = new \ReflectionClass($class);
            $product = $reflector->newInstanceArgs(array_values($data));

            self::saveToDatabase($product, $type === 'furniture' ? $type : $type . 's'); // Ensure the correct table name
        } catch (\Exception $e) {
            HttpResponse::dbError($e->getMessage());
        }
    }

    private static function saveToDatabase($product, string $table): void
    {
        $dbConn = Database::getConnection();
        $data = $product->getData();

        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $dbConn->prepare($sql);

        if (!$stmt) {
            HttpResponse::dbError($dbConn->error);
            return;
        }

        try {
            $stmt->execute(array_values($data));
        } catch (\Exception $e) {
            HttpResponse::dbError($e->getMessage());
        }
    }

    public static function delete(string $type, array $ids): void
    {
        try {
            $dbConn = Database::getConnection();
            $table = '';
    
            switch ($type) {
                case 'book':
                    $table = 'books';
                    break;
                case 'dvd':
                    $table = 'dvds';
                    break;
                case 'furniture':
                    $table = 'furnitures';
                    break;
                default:
                    throw new \Exception('Invalid product type');
            }
    
            $skus = implode(',', array_map(fn($item) => "'$item'", $ids));
            $sql = "DELETE FROM $table WHERE sku IN ($skus)";
            $stmt = $dbConn->prepare($sql);
            $stmt->execute();
    
            HttpResponse::deleted();
        } catch (\Exception $e) {
            HttpResponse::dbError($e->getMessage());
        }
    }
    

}
