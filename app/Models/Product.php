<?php

namespace App\Models;

use CodeIgniter\Model;

class Product extends Model {

    function __construct() {

    }
    public function insertProduct($product) {
        $products = $this->validateAndGetJsonData();
        $products[] = $product;
        file_put_contents(PRODUCTS_FILE_PATH, json_encode($products));
    } 

    public function removeProduct($productId) {

        $products = $this->validateAndGetJsonData();
        $position = -1;
        foreach($products as $index => $element) {
            if ($element->id == $productId) {
                $position = $index;
                break;
            }
        }

        if ($position > -1) {
            // unset($products[$position]);
            array_splice($products, $position, 1);
            file_put_contents(PRODUCTS_FILE_PATH, json_encode($products));
            return true;
        }

        return false;
    }

    public function updateProduct($product) {

        $products = $this->validateAndGetJsonData();
        $position = -1;
        foreach($products as $index => $element) {
            if ($element->id == $product->id) {
                $position = $index;
                break;
            }
        }

        if ($position > -1) {
            $products[$position]->title = $product->title;
            $products[$position]->price = $product->price;
            file_put_contents(PRODUCTS_FILE_PATH, json_encode($products));
            return true;
        }

        return false;
    }

    public function getProduct($productId) {

        $products = $this->validateAndGetJsonData();
        foreach($products as $element) {
            if ($element->id == $productId) {
                return $element;
            }
        }

        return null;
    }

    public function getAllProducts() {

        $products = $this->validateAndGetJsonData();
        return $products;

    }

    public function getProductsPage($page, $items) {

        $products = $this->validateAndGetJsonData();

        $totalCount = count($products);
        $totalPages = ceil($totalCount / $items);
        $rows =  $items < count($products) ? array_splice($products, $items * ($page -1), $items) : $products;
        return ["data" => $rows, "page" => $page, "totalPages" => $totalPages, "totalCount" => $totalCount, "items" => count($rows)];

    }
    public function getProductsPageWithFilters($page, $items, $title, $priceFrom, $priceTo, $date) {

        $products = $this->validateAndGetJsonData();

        $refined = array_filter($products, function($producto) use ($title, $priceFrom, $priceTo, $date) {
            $match = true;

            if ($title && stripos($producto->title, $title) === false) {
                $match = false;
            }

            if ($priceFrom && $producto->price < $priceFrom) {
                $match = false;
            }

            if ($priceTo && $producto->price > $priceTo) {
                $match = false;
            }
            if ($date && explode(" ", $producto->created_at)[0] != $date) {
                $match = false;
            }
            return $match;
        });

        $totalCount = count($refined);
        $totalPages = ceil($totalCount / $items);
        $rows =  $items < count($refined) ? array_splice($refined, $items * ($page -1), $items) : $refined;
        return ["data" => $rows, "page" => $page, "totalPages" => $totalPages, "totalCount" => $totalCount, "items" => count($rows)];

    }

    public function getNewId() {
        
        $products = $this->validateAndGetJsonData();

        $id = 0;

        foreach ($products as $product) {
            if ($product->id > $id) {
                $id = $product->id;
            }
        }

        return $id + 1;
    }

    private function validateFile($filePath) {
        if (!is_file($filePath)) {
            throw new \Exception("Error al intentar encontrar la base de datos Productos");
        }
        if (!is_readable($filePath)) {
            throw new \Exception("No se puede abrir el archivo de base de datos Productos");
        }

        return file_get_contents($filePath);
    }

    private function validateAndGetJsonData() {

        $products = $this->validateFile(PRODUCTS_FILE_PATH);
        $products = json_decode($products);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Error al intentar leer el archivo de base de datos Productos");
            // $error = json_last_error_msg();
        }

        return $products;
    }

}