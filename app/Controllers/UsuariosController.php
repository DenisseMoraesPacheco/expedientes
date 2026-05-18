<?php
namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\RolModel;
use App\Models\BitacoraModel;

class UsuariosController extends BaseController
{

public function crearProveedorTemporal()
{
    $db = \Config\Database::connect();

    $datos = [

        'nombre' => $this->request->getPost('nombre'),
        'apellidoP' => $this->request->getPost('apellidoP'),
        'apellidoM' => $this->request->getPost('apellidoM'),
        'correo' => $this->request->getPost('correo'),

        'colonia' => $this->request->getPost('colonia'),
        'calle_numero' => $this->request->getPost('calle_numero'),
        'ciudad' => $this->request->getPost('ciudad'),
        'estado' => $this->request->getPost('estado'),
        'codigo_postal' => $this->request->getPost('codigo_postal'),
        'pais' => $this->request->getPost('pais'),

        'telefono_principal' => $this->request->getPost('telefono_principal'),

        'rfc' => $this->request->getPost('rfc'),
        'curp' => $this->request->getPost('curp'),

        'num_credencial_votar' => $this->request->getPost('num_credencial_votar'),

        'nombre_razon_social' => $this->request->getPost('nombre_razon_social'),

        'tipo_persona' => $this->request->getPost('tipo_persona'),

        'fecha_inicio' => $this->request->getPost('fecha_inicio'),

        'fecha_final' => $this->request->getPost('fecha_final'),

        'contrasena_hash' => '',

        'id_rol' => 3,

        'active' => 1
    ];

    $guardar = $db->table('usuarios')->insert($datos);

    if($guardar){

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Datos guardados correctamente'
        ]);

    }else{

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Error al guardar'
        ]);

    }
}
    public function obtenerProveedores()
    {
        $proveedores = new UsuarioModel();
        $usuarioModel = $proveedores->getProveedores();
        

        if (!$usuarioModel) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No se encontraron unidades de medida'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $usuarioModel
        ]);
    }

    public function crearUsuarios()
    {
        return view("usuarios/crearUsuarios");
    }
    public function obtenerUsuario($id)
    {

        $usuarioModel = new UsuarioModel();
        $usuarios = $usuarioModel->editarUsuario($id);

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $usuarios
        ]);


    }
    public function editarUsuario($id = null)
    {
        if (!$id) {
            return redirect()->to('/usuarios/listar')->with('error', 'ID de usuario no especificado');
        }

        $usuarioModel = new UsuarioModel();

        // Obtener usuario con su rol
        $usuario = $usuarioModel->select('usuarios.*, roles.nombre AS nombre_rol')
            ->join('roles', 'roles.id_rol = usuarios.id_rol')
            ->where('usuarios.id_usuario', $id)
            ->first();

        if (!$usuario) {
            return redirect()->to('/usuarios/listar')->with('error', 'Usuario no encontrado');
        }

        // Eliminar datos sensibles antes de enviar a la vista
        unset($usuario['contrasena_hash']);
        unset($usuario['reset_token']);
        unset($usuario['reset_expires']);

        // Pasar datos a la vista
        return view('usuarios/editarUsuario', ['usuario' => $usuario]);
    }

    // Vista para listar usuarios
    public function listar()
    {
        $usuarioModel = new UsuarioModel();
        $data['usuarios'] = $usuarioModel->select('usuarios.*, roles.nombre AS nombre_rol')
            ->join('roles', 'roles.id_rol = usuarios.id_rol')
            ->findAll();

        return view('usuarios/verUsuarios', $data);
    }

    // Método AJAX para obtener usuarios
    public function obtenerUsuarios()
    {
        try {
            $usuarioModel = new UsuarioModel();
            $usuarios = $usuarioModel->select('usuarios.*, roles.nombre AS nombre_rol')
                ->join('roles', 'roles.id_rol = usuarios.id_rol')
                ->findAll();


            $data = [];
            foreach ($usuarios as $usuario) {
                $data[] = [
                    'id_usuario' => $usuario['id_usuario'],
                    'nombre_completo' => trim($usuario['nombre'] . ' ' . ($usuario['apellidoP'] ?? '') . ' ' . ($usuario['apellidoM'] ?? '')),
                    'correo' => $usuario['correo'],
                    'rol' => $usuario['nombre_rol'],
                    'telefono_principal' => $usuario['telefono_principal'] ?? 'No especificado',
                    'active' => $usuario['active'],
                    'estado_texto' => $usuario['active'] == 1 ? 'Activo' : 'Inactivo'
                ];
            }

            return $this->response->setJSON($data);

        } catch (\Exception $e) {
            log_message('error', 'Error al obtener usuarios: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al cargar los usuarios'
            ]);
        }
    }

    public function obtenerUsuariosConRol()
    {
        try {
            $usuarioModel = new UsuarioModel();
            $usuarios = $usuarioModel->getUsuariosConRol();

            return $this->response->setJSON([
                'success' => true,
                'data' => $usuarios
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error al obtener usuarios con rol: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al cargar los usuarios'
            ]);
        }
    }

    // Método para ver detalle de un usuario específico
    public function ver($id = null)
    {
        if (!$id) {
            return redirect()->to('/usuarios/listar')->with('error', 'Usuario no especificado');
        }

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->select('usuarios.*, roles.nombre AS nombre_rol')
            ->join('roles', 'roles.id_rol = usuarios.id_rol')
            ->where('usuarios.id_usuario', $id)
            ->first();

        if (!$usuario) {
            return redirect()->to('/usuarios/listar')->with('error', 'Usuario no encontrado');
        }

        return view('usuarios/verDetalleUsuario', ['usuario' => $usuario]);
    }

    public function actualizar($id = null)
    {
        try {
            if (!$id) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID de usuario no especificado'
                ]);
            }

            $data = $this->request->getPost();

            // Verificar si el correo ya existe (excepto el mismo usuario)
            $usuarioModel = new UsuarioModel();
            $existeCorreo = $usuarioModel->where('correo', $data['correo'])
                ->where('id_usuario !=', $id)
                ->first();
            if ($existeCorreo) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El correo electrónico ya está registrado por otro usuario'
                ]);
            }

            // Preparar datos para actualizar
            $usuario = [
                'id_rol' => $data['id_rol'],
                'nombre' => $data['nombre'],
                'apellidoP' => $data['apellidoP'],
                'apellidoM' => $data['apellidoM'],
                'correo' => $data['correo'],
                'active' => isset($data['active']) ? 1 : 0,
                'rfc' => $data['rfc'] ?: null,
                'curp' => $data['curp'] ?: null,
                'nombre_razon_social' => $data['nombre_razon_social'] ?: null,
                'tipo_persona' => $data['tipo_persona'] ?: null,
                'telefono_principal' => $data['telefono_principal'] ?: null,
                'calle_numero' => $data['calle_numero'] ?: null,
                'colonia' => $data['colonia'] ?: null,
                'ciudad' => $data['ciudad'] ?: null,
                'estado' => $data['estado'] ?: null,
                'codigo_postal' => $data['codigo_postal'] ?: null,
                'pais' => $data['pais'] ?: null,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Si se proporcionó nueva contraseña, actualizarla
            if (!empty($data['password'])) {
                if ($data['password'] !== $data['confirm_password']) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Las contraseñas no coinciden'
                    ]);
                }
                if (strlen($data['password']) < 6) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'La contraseña debe tener al menos 6 caracteres'
                    ]);
                }
                $usuario['contrasena_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

            // Actualizar usuario
            $result = $usuarioModel->update($id, $usuario);

            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Usuario actualizado exitosamente',
                    'redirect' => site_url('usuarios/listar')
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al actualizar el usuario'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Error al actualizar usuario: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error del sistema: ' . $e->getMessage()
            ]);
        }
    }

    // Método para cambiar estado de usuario
    public function cambiarEstado($id = null)
    {
        try {
            if (!$this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Petición no válida'
                ]);
            }

            if (!$id) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'ID de usuario no especificado'
                ]);
            }

            $json = $this->request->getJSON();
            $nuevoEstado = $json->active ?? null;

            if ($nuevoEstado === null || !in_array($nuevoEstado, [0, 1])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Estado no válido'
                ]);
            }

            $usuarioModel = new UsuarioModel();
            $usuario = $usuarioModel->find($id);

            if (!$usuario) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ]);
            }

            $result = $usuarioModel->update($id, [
                'active' => $nuevoEstado,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => $nuevoEstado == 1 ? 'Usuario activado' : 'Usuario desactivado'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al actualizar el estado'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Error al cambiar estado: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error del sistema: ' . $e->getMessage()
            ]);
        }
    }
}