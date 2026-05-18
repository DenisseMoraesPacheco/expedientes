<?php
namespace App\Controllers;

use App\Models\CatalogoModel;

class CatalogoController extends BaseController
{
    public function obtenerCatalogo()
    {
        $catalogo = new CatalogoModel();
        $CatalogoModel = $catalogo->findAll();
        

        if (!$CatalogoModel) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No se encontraron el catalogo'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $CatalogoModel
        ]);
    }

    
        }