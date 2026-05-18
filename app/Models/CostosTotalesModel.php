<?php

namespace App\Models;

use CodeIgniter\Model;

class CostosTotalesModel extends Model
{
    protected $table = 'tbl_costos_totales';
    protected $primaryKey = 'id_costos';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    
    protected $allowedFields = [
        'fk_nombre_razon_social',
        'subtotal',
        'iva',
        'total',
    ];
    
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    }