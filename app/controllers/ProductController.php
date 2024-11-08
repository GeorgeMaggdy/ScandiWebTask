<?php

namespace App\Controllers;

use App\Models\Products;

class ProductController
{
    public static function showProductList(): void
    {
        try {
            $products = Products::get();
            require_once __DIR__ . '/../views/products/products_list.php';
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to fetch products']);
        }
    }

    public static function addProduct(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Products::add();
            $_SESSION['success'] = "Product added successfully!";
            header("Location: /scandiwebtask/public/products_list");
            exit();
        }

        require_once __DIR__ . '/../views/products/add_product.php';
    }

    public static function deleteProducts(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $type = $data['type'] ?? null;
            $ids = $data['ids'] ?? null;

            if ($type && $ids) {
                Products::delete($type, $ids);
                header("Location: /scandiwebtask/public/products_list");
                exit();
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Invalid data provided']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['message' => 'Method not allowed']);
        }
    }



}
