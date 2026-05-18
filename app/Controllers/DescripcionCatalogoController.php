<?php
namespace App\Controllers;

use App\Models\CatalogoModel;
use App\Models\DescripcionCatalogoModel;

class DescripcionCatalogoController extends BaseController
{
   public function obtenerDescripcionCatalogo($idCatalogo)
{
    $modelo = new DescripcionCatalogoModel();

    $datos = $modelo->obtenerDescripcionCatalogoPorID($idCatalogo);

    if (empty($datos)) {

        return $this->response->setJSON([
            'success' => false,
            'message' => 'No se encontraron registros'
        ]);

    }

    return $this->response->setJSON([
        'success' => true,
        'data' => $datos
    ]);
}


}