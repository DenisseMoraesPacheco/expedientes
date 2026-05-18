<?php
namespace App\Models;

use CodeIgniter\Model;

class AreasModel extends Model
{
    protected $table = 'area';
    protected $primaryKey = 'id_area';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['area'];  
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Método para obtener roles
    public function getAreas()
    {
        return $this->findAll();
    }
    
    // Método para obtener rol por nombre
    public function getRolByNombre($nombre)
    {
        return $this->where('nombre', $nombre)->first();
    }
}