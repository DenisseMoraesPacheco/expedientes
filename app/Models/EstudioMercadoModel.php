<?php

namespace App\Models;

use CodeIgniter\Model;

class EstudioMercadoModel extends Model
{
    protected $table = 'estudio_mercado';
    protected $primaryKey = 'id_estudio';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    
    protected $allowedFields = [
        'fk_area',
        'nombre_estudio'
    ];
    
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    

    // MODELO

public function getEstudioById($id_estudio)
{
    return $this->db->table('estudio_mercado em')
        ->select('
            em.id_estudio,
            em.nombre_estudio,
            a.area,
            em.created_at,

            dc.producto_servicio,
            dc.unidad_medida,

            dem.partida,
            dem.cantidad,

            u.nombre,
            u.apellidoP,
            u.apellidoM,

            nrs.precio_unitario,
            nrs.precio_total,
            nrs.marca_modelo,

            tct.subtotal,
            tct.iva,
            tct.total
        ')
        ->join('area a', 'a.id_area = em.fk_area')
        
        ->join('descripcion_estudio_mercado dem', 
            'dem.fk_estudio_mercado = em.id_estudio'
        )

        ->join('descripcion_catalogo dc', 
            'dc.id_descripcion_catalogo = dem.fk_descripcion_catalogo'
        )

        ->join('nombre_razon_social nrs', 
            'nrs.fk_descripcion_estudio_mercado = dem.id_descripcion'
        )

        ->join('usuarios u', 
            'u.id_usuario = nrs.fk_proveedor'
        )

        ->join('tbl_costos_totales tct', 
            'tct.fk_nombre_razon_social = nrs.id_razon_social',
            'left'
        )

        ->where('em.id_estudio', $id_estudio)

        ->orderBy('dem.partida', 'ASC')

        ->get()
        ->getResultArray();
}

public function obtenerEstudiosFinalizados()
{
    return $this->select('
            estudio_mercado.id_estudio,
            estudio_mercado.nombre_estudio,
            area.area,
            estudio_mercado.created_at
        ')
        ->join('area', 'area.id_area = estudio_mercado.fk_area')
        ->findAll();
}

    }

