<?php

namespace App\Controllers;
use App\Models\User;

class Home extends BaseController
{
    public function index(): string
    {
        return view('login/home', ["title" => "Ingresar"]);
    }

    public function login() {

        $logger = \Config\Services::logger();
        
        try {

            $session = session();


            $rules = [
                'usuario' => 'required|min_length[3]|max_length[50]',
                'clave' => 'required|min_length[8]|max_length[24]'
            ];
    
            if (!$this->validate($rules)) {
                return $this->response->setJSON(['success' => false, 'errors' => $this->validator->getErrors()]);
            }

            $usuario = $this->request->getPost("usuario");
            $clave = $this->request->getPost("clave");


            $logger->info('Intentando obtener listado de usuarios');
            $users = new User();
            $usuarios = $users->getAllUsers();

            foreach ($usuarios as $user) {
                if ($user["user"] === $usuario && $user["pass"] === $clave) {
                    $session->set(["user" => $user]);
                    return $this->response->setJSON(['success' => true, 'errors' => "", "redirect" => "/products"]);
                }
            }

            return $this->response->setJSON(['success' => false, 'errors' => "Usuario o clave incorrectos"]);
        } catch (\Exception $e) {
            $logger->error('Error al intentar encontrar el usuario: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'errors' => "", "view" => view('errors/html/error_load_users')]);

        }


    }
}
