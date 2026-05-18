<?php
namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\UnidadesMedidaModel;
use App\Models\BitacoraModel;

class UnidadesController extends BaseController
{

public function obtenerUnidadesMedida()
{
    $unidades = new UnidadesMedidaModel();
    $unidadesModel = $unidades->getUnidades();

    if (!$unidadesModel) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'No se encontraron unidades de medida'
        ]);
    }

    return $this->response->setJSON([
        'success' => true,
        'data' => $unidadesModel
    ]);
}
    }
