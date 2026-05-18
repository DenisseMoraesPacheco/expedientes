<?php
namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\AreasModel;
use App\Models\BitacoraModel;

class AreasController extends BaseController
{
    public function obtenerAreas(){
        $areas =new AreasModel();
        $areasModel = $areas->getAreas();
        if (!$areasModel) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Proceso no encontrado'
                ]);
            }
            return $this->response->setJSON([
                'success' => true,
                'data' => $areasModel
            ]);
        
        }
    }
