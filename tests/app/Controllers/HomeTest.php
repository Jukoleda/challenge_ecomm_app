<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;

class HomeTest extends CIUnitTestCase
{
    use ControllerTestTrait;

    public function testIndex()
    {
        $result = $this->withUri('http://localhost:8080/')
                       ->controller(Home::class)
                       ->execute('index');

        $this->assertTrue($result->isOK());
    }

    public function testLogin()
    {

        $result = $this->controller(Home::class)
                       ->execute('login');

        $this->assertTrue($result->isOK());
        $response = json_decode($result->getJSON());
        // die(print_r($response, true));
        $this->assertFalse($response->success);
    }
}
