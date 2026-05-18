<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpresaPresentacionModel extends Model
{
    protected $table = 'tbl_empresa_presentacion';
    protected $primaryKey = 'id_empresa_presentacion'; 
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    
    protected $allowedFields = [
        'fk_proveedor',      
        'fk_proceso',        
        'fecha_presentacion',
        'documento_empresa',
        'observaciones',
        'estado'
    
    ];
    
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Si tu tabla no tiene timestamps, elimina las líneas de arriba y usa:
    // protected $useTimestamps = false;
    
    // Reglas de validación (opcional pero recomendado)
    protected $validationRules = [
        'fk_proveedor' => 'required|integer',
        'fk_proceso' => 'required|integer',
        'documento_empresa' => 'required|string|max_length[255]'
    ];
    
    protected $validationMessages = [
        'fk_proveedor' => [
            'required' => 'El proveedor es requerido',
            'integer' => 'El ID del proveedor debe ser un número entero'
        ]
    ];
    
    // Relaciones (si usas CodeIgniter 4 con propiedades)
    // public function proveedor()
    // {
    //     return $this->belongsTo('ProveedoresModel', 'fk_proveedor');
    // }
    
    // public function proceso()
    // {
    //     return $this->belongsTo('ProcesosModel', 'fk_proceso');
    // }
}