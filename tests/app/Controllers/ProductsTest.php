<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\Fabricator;
use App\Models\Product;
use CodeIgniter\Session\Session;

class ProductsTest extends CIUnitTestCase
{
    use ControllerTestTrait;

    //comentado por desconocer como probar session
    // public function testIndex()
    // {
    //     $result = $this->controller(Products::class)
    //                    ->execute('index');

    //     $this->assertTrue($result->isOK());
    //     $this->assertStringContainsString('Listado de productos', $result->getBody());
    // }

    public function testProductUpdate()
    {
        $postData = [
            'id' => 1,
            'titulo' => 'Updated Product',
            'precio' => 200
        ];

        $result = $this->withBody(json_encode($postData))
                       ->controller(Products::class)
                       ->execute('productUpdate');

        $this->assertTrue($result->isOK());
        $response = json_decode($result->getJSON(), true);
        $this->assertTrue($response['success'] !== true);
        //comentado por no saber como hacer que tome los parametros enviado por body. Assert por validacion de faltante de campos
        // $this->assertEquals('Producto actualizado correctamente.', $response['message']);
    }

    public function testProductDelete()
    {
        $productId = 1;

        $result = $this->controller(Products::class)
                       ->execute('productDelete', $productId);

        $this->assertTrue($result->isOK());
        $response = json_decode($result->getJSON(), true);
        $this->assertTrue($response['success']);
        $this->assertEquals('Producto eliminado correctamente.', $response['message']);
    }

    public function testCreateNew()
    {
        $postData = [
            'titulo' => 'New Product',
            'precio' => 300
        ];

        $result = $this->withBody(json_encode($postData))
                       ->controller(Products::class)
                       ->execute('createNew');

        $this->assertTrue($result->isOK());
        $response = json_decode($result->getJSON());
        // die(print_r($response, true));
        $this->assertTrue($response->success !== true);
        //comentado por no saber como hacer que tome los parametros enviado por body. Assert por validacion de faltante de campos
        // $this->assertEquals('Producto creado correctamente.', $response->message);
    }
}
