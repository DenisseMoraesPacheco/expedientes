<?php

namespace App\Models;

use CodeIgniter\Model;

class DescripcionEstudioMercado extends Model
{
    protected $table = 'descripcion_estudio_mercado';
    protected $primaryKey = 'id_descripcion';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    
    protected $allowedFields = [
        'fk_estudio_mercado',
        'partida',
        'descripcion',
        'fk_descripcion_catalogo',
        'cantidad'
    ];
    
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    }