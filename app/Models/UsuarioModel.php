<?php
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'id_rol',
        'nombre',
        'apellidoP',
        'apellidoM',
        'correo',
        'contrasena_hash',
        'active',
        'rfc',
        'curp',
        'num_credencial_votar',
        'nombre_razon_social',
        'tipo_persona',
        'telefono_principal',
        'calle_numero',
        'colonia',
        'ciudad',
        'estado',
        'codigo_postal',
        'pais',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    

 public function getProveedores()
{
    return $this->select('usuarios.*, roles.nombre AS nombre_rol')
        ->join('roles', 'roles.id_rol = usuarios.id_rol')
        ->where('usuarios.id_rol', 3) // Trae todos los usuarios con rol proveedor
        ->get()
        ->getResultArray();
}
    // Método para obtener usuario con su rol
    public function editarUsuario($id)
    {
        return $this->select('usuarios.*, roles.nombre AS nombre_rol')  
            ->join('roles', 'roles.id_rol = usuarios.id_rol')
            ->where('usuarios.id_usuario', $id)
            ->first();
    }
    
    // Método para obtener todos los usuarios con sus roles

    public function getUsuariosConRol()
{
    return $this->select("CONCAT(usuarios.nombre, ' ', usuarios.apellidoP, ' ', usuarios.apellidoM) AS nombre_completo, usuarios.correo, usuarios.active, roles.nombre AS rol")
        ->join('roles', 'roles.id_rol = usuarios.id_rol')
        ->findAll();
}

}