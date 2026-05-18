<?php

namespace App\Models;

use CodeIgniter\Model;

class NombreRazonSocialModel extends Model
{
    protected $table = 'nombre_razon_social';
    protected $primaryKey = 'id_razon_social';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    
    protected $allowedFields = [
        'fk_descripcion_estudio_mercado',
        'fk_proveedor',
        'precio_unitario',
        'precio_total',
        'marca_modelo'
    ];
    
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    }