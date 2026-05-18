<?php

namespace App\Models;

use CodeIgniter\Model;

class ProcesoModel extends Model
{
    protected $table = 'tbl_procesos';
    protected $primaryKey = 'id_proceso';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    
    protected $allowedFields = [
        'tipo_proceso',
        'alias_proceso',
        'status'
    ];
    
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
public function obtenerDocumentosPorProceso($idProceso)
{
    return $this->db->table('tbl_documentos_procesos dp')
        ->select('dp.*, p.tipo_proceso, p.alias_proceso, p.id_proceso')
        ->join('tbl_procesos p', 'p.id_proceso = dp.fk_proceso')
        ->where('p.id_proceso', $idProceso)
        ->get()
        ->getResultArray();
}
public function getProcesoPorID($idProceso)
{
    return $this->db->table('tbl_documentos_procesos')
        ->select('tbl_documentos_procesos.*, tbl_procesos.tipo_proceso, tbl_procesos.alias_proceso, 
tbl_procesos.id_proceso')
        ->join('tbl_procesos', 'tbl_procesos.id_proceso = tbl_documentos_procesos.fk_proceso')
        ->where('tbl_procesos.id_proceso', $idProceso)
        ->get()
        ->getResultArray();
}
}