<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\User;

class Products extends BaseController
{
    public function index(): string
    {        
        $logger = \Config\Services::logger();
        $session = session();
        $usuario = $session->get("user");
        $logger->info('Ingreso usuario: ' . print_r($usuario, true));



        return view('products/home', ["title" => "Listado de productos", "user" => ["admin" => $usuario["is_admin"]]]);   
    }
    
    // public function productsList() {
    //     $logger = \Config\Services::logger();
        
    //     try {
    //         $session = session();
    //         $usuario = $session->get("user");
    //         $logger->info('Ingreso usuario: ' . print_r($usuario, true));

    //         $logger->info('Ingreso a listado de productos');
    //         $productsModel = new Product();
    //         $products = $productsModel->getAllProducts();
    //         return view('products/productsList', ["products" => $products, "user" => ["admin" => $usuario["is_admin"]]]);
    //     } catch (\Exception $e) {
    //         $logger->error('Error al intentar listar productos: ' . $e->getMessage());
    //         return view('errors/html/error_load_json');
    //     }
    // }

    // public function productsPaginatedList($page = 1, $items = 10) {
    //     $logger = \Config\Services::logger();
        
    //     try {
    //         $session = session();
    //         $usuario = $session->get("user");
    //         $logger->info('Ingreso usuario: ' . print_r($usuario, true));
    //         $logger->info('Ingreso a listado de productos');
    //         $productsModel = new Product();
    //         $products = $productsModel->getProductsPage($page, $items)['rows'];
    //         return view('products/productsList', ["products" => $products, "user" => ["admin" => $usuario["is_admin"]]]);
    //     } catch (\Exception $e) {
    //         $logger->error('Error al intentar listar productos: ' . $e->getMessage());
    //         return view('errors/html/error_load_json');
    //     }
    // }

    public function productsSearchPaginatedList() {
        $logger = \Config\Services::logger();
        
        try {

            $title = $this->request->getPost("titulo");
            $priceFrom = $this->request->getPost("desde");
            $priceTo = $this->request->getPost("hasta");
            $date = $this->request->getPost("fechaCreacion");
            $page = $this->request->getPost("pagina");



            $items = 5;
            $session = session();
            $usuario = $session->get("user");
            $logger->info('Ingreso usuario: ' . print_r($usuario, true));
            $logger->info('Ingreso a listado de productos');
            $productsModel = new Product();
            $products = $productsModel->getProductsPageWithFilters($page, $items, $title, $priceFrom, $priceTo, $date);
            $logger->info('Products Page: ' . print_r($products, true));
            return view('products/productsList', ["paginator" => $products, "user" => ["admin" => $usuario["is_admin"]]]);
        } catch (\Exception $e) {
            $logger->error('Error al intentar listar productos: ' . $e->getMessage());
            return view('errors/html/error_load_json');
        }
    }

    public function productEdit($productId) {
        
        $logger = \Config\Services::logger();
        try {
            $logger->info('Ingreso a edicion de producto');

            $productsModel = new Product();
            $product = $productsModel->getProduct($productId);
            return view('products/productsEdit', ["product" => $product]);
        } catch (\Exception $e) {
            $logger->error('Error al intentar editar producto: ' . $e->getMessage());

            return view('errors/html/error_load_json');
        }
        
    }

    public function productUpdate() {

        $logger = \Config\Services::logger();
        try {
    
            $logger->info('Ingreso a actualizacion de producto');
    
    
    
            $rules = [
                'titulo' => 'required|min_length[3]|max_length[50]',
                'precio' => 'required|numeric|greater_than_equal_to[1]'
            ];
    
            if (!$this->validate($rules)) {
                return $this->response->setJSON(['success' => false, 'errors' => $this->validator->getErrors()]);
            }

            $productsModel = new Product();

            $newProduct = new \stdClass();
            $newProduct->id = $this->request->getPost("id");
            $newProduct->title = $this->request->getPost("titulo");
            $newProduct->price = $this->request->getPost("precio");

            $productsModel->updateProduct($newProduct);

            return $this->response->setJSON(['success' => true, "message" => "Producto actualizado correctamente."]);
        } catch (\Exception $e) {

            $logger->error('Error al intentar actualizar producto: ' . $e->getMessage());

            return $this->response->setJSON(['success' => false, "errors" => "Ocurrio un error al intentar actualizar el producto"]);

        }
    }

    public function productDelete($productId) {
        $logger = \Config\Services::logger();
        try {
            $validation = \Config\Services::validation();
    
            $logger->info('Ingreso a eliminacion de producto');
    
            $rules = [
                'id' => 'required|numeric|greater_than_equal_to[1]'
            ];
    
            $validation->reset();
            $validation->setRules($rules);
        
            if (!$validation->run(["id" => $productId])) {
                return $this->response->setJSON(['success' => false, 'errors' => $this->validator->getErrors()]);
            }

            $productsModel = new Product();
            $productsModel->removeProduct($productId);

            return $this->response->setJSON(['success' => true, "message" => "Producto eliminado correctamente."]);
        } catch (\Exception $e) {
            $logger->error('Error al intentar eliminar producto: ' . $e->getMessage());

            return $this->response->setJSON(['success' => false, "errors" => "Ocurrio un error al intentar eliminar el producto"]);

        }

    }

    public function productCreate() {
        return view('products/productsAdd');
    }

    public function createNew() {        
        $logger = \Config\Services::logger();
        try {

    
            $logger->info('Ingreso a eliminacion de producto');
    
            $rules = [
                'titulo' => 'required|min_length[3]|max_length[50]',
                'precio' => 'required|numeric|greater_than_equal_to[1]'
            ];
    
            if (!$this->validate($rules)) {
                return $this->response->setJSON(['success' => false, 'errors' => $this->validator->getErrors()]);
            }
            
            $productsModel = new Product();
        
            $newProduct = new \stdClass();
            $newProduct->id = $productsModel->getNewId();
            $newProduct->title = $this->request->getPost("titulo");
            $newProduct->price = $this->request->getPost("precio");
            $newProduct->created_at = date("Y-m-d H:i");
            
            $productsModel->insertProduct($newProduct);
            return $this->response->setJSON(['success' => true, "message" => "Producto creado correctamente."]);

        } catch (\Exception $e) {

            $logger->error('Error al intentar crear producto: ' . $e->getMessage());

            return $this->response->setJSON(['success' => false, "errors" => "Ocurrio un error al intentar crear el producto"]);

        }
    }
}
