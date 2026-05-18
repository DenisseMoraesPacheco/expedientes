<?php
namespace App\Models;

use CodeIgniter\Model;

class UnidadesMedidaModel extends Model
{
    protected $table = 'unidades_medida';
    protected $primaryKey = 'id_unidad';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nombre'];  
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Método para obtener roles
    public function getUnidades()
    {
        return $this->findAll();
    }
    
    // Método para obtener rol por nombre
    public function getRolByNombre($nombre)
    {
        return $this->where('nombre', $nombre)->first();
    }
}