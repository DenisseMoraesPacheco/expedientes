<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsuarioModel;

class AdminController extends BaseController
{
    public function guardar()
    {
        try {
            // Verificar si es petición AJAX
            if (!$this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Petición no válida'
                ]);
            }

            $data = $this->request->getPost();

            // Verificar si el correo ya existe
            $usuarioModel = new UsuarioModel();
            $existeCorreo = $usuarioModel->where('correo', $data['correo'])->first();
            if ($existeCorreo) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El correo electrónico ya está registrado'
                ]);
            }

            // Convertir vacíos a NULL
            foreach ($data as $key => $value) {
                if ($value === "") {
                    $data[$key] = null;
                }
            }

            // Mapear campos correctamente
            $usuario = [
                'id_rol' => $data['id_rol'],
                'nombre' => $data['nombre'],
                'apellidoP' => $data['apellidoP'],
                'apellidoM' => $data['apellidoM'],
                'correo' => $data['correo'],
                'contrasena_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
                'active' => isset($data['active']) ? 1 : 0, // Corrección para checkbox
                'rfc' => $data['rfc'],
                'curp' => $data['curp'],
                'nombre_razon_social' => $data['nombre_razon_social'],
                'tipo_persona' => $data['tipo_persona'],
                'telefono_principal' => $data['telefono_principal'],
                'calle_numero' => $data['calle_numero'],
                'colonia' => $data['colonia'],
                'ciudad' => $data['ciudad'],
                'estado' => $data['estado'],
                'codigo_postal' => $data['codigo_postal'],
                'pais' => $data['pais'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Guardar usuario
            $model = new UsuarioModel();
            $idUsuario = $model->insert($usuario);
            
            if ($idUsuario) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Usuario guardado exitosamente',
                    'redirect' => '../usuarios/listar', // Redirige a la lista de usuarios
                    'id_usuario' => $idUsuario
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al guardar el usuario. Por favor, intente nuevamente.'
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Error al guardar usuario: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error del sistema: ' . $e->getMessage()
            ]);
        }
    }
}