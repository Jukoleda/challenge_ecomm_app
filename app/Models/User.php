<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model {

    function __construct() {

    }
  
    public function getAllUsers() {

        $users = $this->validateAndGetJsonData();
        return $users;

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

        $products = $this->validateFile(USERS_FILE_PATH);
        $products = json_decode($products, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Error al intentar leer el archivo de base de datos Productos");
            // $error = json_last_error_msg();
        }

        return $products;
    }

}